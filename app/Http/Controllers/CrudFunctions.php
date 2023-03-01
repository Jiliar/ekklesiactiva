<?php

namespace App\Http\Controllers;
use Exception;
use Illuminate\Http\Request;

use Hamcrest\Util;
use Illuminate\Support\Facades\DB;
use JWTAuth;
use Namshi\JOSE\JWT;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

trait CrudFunctions
{
    public function find(Request $request){
        $error = true;
        try{
            $token = session()->get('auth_token');
            $data = $request->all();
            $uri = $data['componente'];
            $id = $data['id'];
            $response = Api::Get($uri, $token, $id);
            $response = Utils::formatDataHTML($response, $uri);
            $error = $response == null?true:false;
            echo json_encode(array('error'=>$error,'output' => $response['json']));
        }catch(Exception $e){
            $errorMsg = Utils::getErrorMessage($e->getMessage());
            if(strpos($errorMsg,"token_expired") > -1 || strpos($errorMsg,"token_absent") > -1){
                $this->cerrarSesion();
                echo json_encode(array('error'=>$error,'output' => 'token_problem', 'etiqueta'=>env('FILE_URL')));
            }
            echo json_encode(array('error'=>$error,'output' => $errorMsg,'etiqueta'=>$uri));
        }
    }

    public function list(Request $request){
        $error = false;
        try{
            $token = session()->get('auth_token');
            $rol = session()->get('app_idrol');
            $response = null;
            $uri = $request->all()['uri'];
            $response = Api::Get($uri,$token);
            $rol = session()->get('app_idrol');
            $pro_response = Utils::evaluateDataRole($rol, $response);
            $h_ctrl = new HTMLBuilderController();
            $html = "";
            $flag = array_key_exists('status', $pro_response);
            if(!$flag){
                    if($pro_response != null){
                        if($rol == 0 || $rol == 2 || $rol == 3 || $rol == 4){
                            $html = "<div style=\"font-family: 'Monserrat Regular'; font-weight:bold; color: darkgray; margin-bottom:10px;\">
                                        Para modificar información especifica seleccione el dato a modificar en la tabla mediante radiobutton.
                                        (circulo después de columna ID)
                                    </div>";
                        }

                        if($rol != 1 && $rol != 2 ){
                            $new_response = array();
                            foreach($pro_response as $value){
                                unset($value['user_update']);
                                unset($value['user_inactive']);
                                unset($value['updated_at']);
                                unset($value['deleted_at']);
                                unset($value['created_at']);
                                unset($value['user_create']);
                                array_push($new_response, $value);
                            }
                            $html .= $h_ctrl->DataTable($new_response);
                        }else{
                            $new_response = array();
                            foreach($pro_response as $value){
                                unset($value['user_update']);
                                unset($value['user_inactive']);
                                unset($value['updated_at']);
                                unset($value['deleted_at']);
                                array_push($new_response, $value);
                            }
                            $html .= $h_ctrl->DataTable($new_response);
                        }

                    }else{
                        $html = "<span id='no-views'>No hay registros relacionados</span>";
                    }
                    echo json_encode(array('error'=>$error,'output' => $html));
            }else{
                if($pro_response['status'] == "Token is Expired"){
                    $user = new AuthUsuarioController();
                    $user->cerrarSesion();
                    echo '<script type="text/javaScript"> location.reload(); </script>';
                }
            }

        }catch(Exception $e){
            $error = true;
            $errorMsg = Utils::getErrorMessage($e->getMessage());
            if(strpos($errorMsg,"token_expired") > -1 || strpos($errorMsg,"token_absent") > -1){
                $this->cerrarSesion();
                echo json_encode(array('error'=>$error,'output' => 'token_problem', 'etiqueta'=>env('FILE_URL')));
            }
            echo json_encode(array('error'=>$error,'output' => $errorMsg,'etiqueta'=>$uri));
        }
    }

    public function save(Request $request){
        $error = true;
        try{
            //Inicialización de variables
            $token = session()->get('auth_token');
            $data = $request->all();
            $json = json_decode($data['data'], TRUE);
            $uri = substr($json['hdnView'],5);
            $body = Utils::formatData($json, $uri);
            $response =array();
            $old_file = null;
            $msg = "";
            if($data['method'] == 'save'){
                //REGISTRAR REGISTRO
                $datos_validacion = Utils::getDataValidatUnique($uri, $body['vector']);
                if(count($datos_validacion) == 0){
                    $vector = Utils::securityRegister($body['vector'], $uri, $request->method());
                    //dd(json_encode($vector));
                    $response = Api::Post($uri, $token, $vector);
                }else{
                    //Validar existencia del registro para no volverlo a registrar
                    $id_validate = $datos_validacion[0]->id_comprobacion;
                    $existe = Utils::validateUnique($datos_validacion, $body['vector'][$id_validate]);
                    if(!$existe){
                        $vector = Utils::securityRegister($body['vector'], $uri, $request->method());
                        //dd(json_encode($vector));
                        $response = Api::Post($uri, $token, $vector);
                    }else{
                        $response = array();
                        $msg = "¡Ya se ha registrado esta información anteriormente!";
                    }
                }

            }else{
                //ACTUALIZAR REGISTRO
                //Captura de archivo guardado anteriormente para posterior eliminación
                if(array_key_exists('file-0', $data)){
                    $get = Api::Get($uri, $token, $body['vector']['id']);
                    $old_file = $get['archivo'];
                }
                //Actualizar el registro con url del nuevo archivo
                $response = Api::Put($uri, $token, $body['vector']);

                if(count($response) == 0){
                    $msg = "¡No se pudo realizar la actualización de la información, Asegurese de seleccionar un registro en la tabla detalles!";
                }else{
                    $msg = "¡La información fue actualizada exitosamente!";
                }
            }

            //SUBIR ARCHIVOS Y ELIMINAR ARCHIVOS OBSOLETOS GUARDADOS CON ANTERIORIDAD
            if(count($response) > 0){
                if(array_key_exists('file-0', $data)){
                    $response = Utils::uploadFile($data, $response['id']);
                    Utils::deleteOldFile($old_file);
                }
            }
            //SALIDA DE LA OPERACIÓN
            $error = count($response) == 0?true:false;
            $response = count($response) == 0?$msg:$response;
            echo json_encode(array('error'=>$error,'output' => $response));
        }catch(Exception $e){
            $errorMsg = Utils::getErrorMessage($e->getMessage());
            if(strpos($errorMsg,"token_expired") > -1 || strpos($errorMsg,"token_absent") > -1){
                $this->cerrarSesion();
                echo json_encode(array('error'=>$error,'output' => 'token_problem', 'etiqueta'=>env('FILE_URL')));
            }
            echo json_encode(array('error'=>$error,'output' => $errorMsg,'etiqueta'=>$uri));
        }

    }

    public function cerrarSesion() {
        session()->put('app_idusuario','');
        session()->forget('app_menu_subitems');
        session()->forget('app_aplicaciones');
        session()->forget('app_nomusuariocorto');
        session()->forget('app_nomusuario');
        session()->forget('app_idrol');
        session()->forget('app_nomrol');
        session()->forget('auth_token');
    }


}
