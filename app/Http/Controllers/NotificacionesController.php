<?php

namespace App\Http\Controllers;

use App\Models\AudCorreo;
use App\Submenu;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Mail\Notificacion;
use App\Mail\PosicionCandado;
use Exception;
use Illuminate\Support\Facades\Mail;

class NotificacionesController extends Controller {
    public function index() {

    }

    public function reestablecer(Request $request){
        $error = false;
        $data = $request->all();
        $query = "SELECT *
                  FROM auth_usuarios a
                  WHERE a.inactivo = 0
                  AND a.identificacion = '".$data['identificacion']."'
                  AND a.email = '".$data['email']."'";
        $data = DB::select($query);
        if(count($data)>0){
            $utils2 = new Utils();
            $user1 = $utils2->cifrar($data[0]->id);
            $asunto = 'REESTABLECIMIENTO DE CONTRASEÑA - BECAS BOOMERANG';
            $cuerpo_mensaje = "<p>Estimado usuario</p>
                                <p>Usted ha solicitado cambiar su contraseña, favor presione click en el siguinte enlace</p>
                                <a href='".env('HOST_URL')."/reset/xid=".$user1."' target='_blank'>
                                <p style='padding:10px; background:#00B5BA; color:white; text-align:center;
                                font-weight:bold; font-size:18px; text-decoration: none !important;'>
                                Click Aquí</p></a><br/><br/>";
            $mailable = new Notificacion();
            $mailable->setArchivo(null);
            $mailable->setAsunto($asunto);
            $mailable->setPara($data[0]->nombre1.' '.$data[0]->apellido1);
            $mailable->setCuerpoMensaje($cuerpo_mensaje);
            $mailable->setDelay(intval(env('MAIL_DELAY')));
            Mail::to($data[0]->email)->cc(env('MAIL_FROM_ADDRESS'))->send($mailable);



            $aud_correo = AudCorreo::create([
                'de' => env('MAIL_FROM_ADDRESS'),
                'usuario_para' => $data[0]->id,
                'correo_para' => $data[0]->email,
                'asunto' => $asunto,
                'cuerpo' => $cuerpo_mensaje,
                'fecha_envio' => date('Y:m:d H:i:s'),
                'tipo_correo' => 'REESTABLECIMIENTO',
                'inactivo' => 0,
            ]);

            $output = $aud_correo;
        }else{
            $error = true;
            $output = "¡No existe usuario con la identificación y el correo digitada!";
        }
        echo json_encode(array('error'=>$error,'output' => $output));
    }


    public function notificaciones(Request $request)
    {
        $data = $request->all();
        switch($data['hdnView']){
            case 'form_logic_notificaciones_etiqueta':

                $error = false;
                $output = "";
                $notificacion = $data['lstNotificacion'];
                if($notificacion != '#') {
                    $users = explode(",",$data['users']);
                    $query = "SELECT * FROM logic_notificaciones a WHERE a.inactivo = 0 AND a.id = '$notificacion'";
                    $data = DB::select($query);
                    try {
                        foreach ($users as $user) {
                            $query = "SELECT u.id AS ID,
                                CONCAT(u.nombre1,' ',u.apellido1,' ',u.apellido2) AS NOMBRE,
                                u.email AS EMAIL
                                FROM auth_usuarios u WHERE u.inactivo = 0 AND u.id = " . $user;
                            $data_user = DB::select($query);
                            $mailable = new Notificacion();
                            $mailable->setArchivo($data[0]->archivo);
                            $mailable->setAsunto($data[0]->asunto);
                            $mailable->setPara($data_user[0]->NOMBRE);
                            $mailable->setCuerpoMensaje($data[0]->cuerpo_mensaje);
                            $mailable->setDelay(intval(env('MAIL_DELAY')));
                            Mail::to($data_user[0]->EMAIL)->cc(env('MAIL_FROM_ADDRESS'))->send($mailable);

                            $asunto = "";
                            if($data[0]->archivo != null && $data[0]->archivo != ''){
                                $asunto = $data[0]->asunto." <br/> Archivo: ".$data[0]->archivo;
                            }else{
                                $asunto = $data[0]->asunto;
                            }

                            $aud_correo = AudCorreo::create([
                                'de' => env('MAIL_FROM_ADDRESS'),
                                'usuario_para' => $data_user[0]->ID,
                                'correo_para' => $data_user[0]->EMAIL,
                                'asunto' => $asunto,
                                'cuerpo' => $data[0]->cuerpo_mensaje,
                                'fecha_envio' => date('Y:m:d H:i:s'),
                                'tipo_correo' => 'NOTIFICACIÓN',
                                'inactivo' => 0,
                            ]);

                            $output .= "Enviado a " . $data_user[0]->NOMBRE . " email: " . $data_user[0]->EMAIL . "*";
                        }
                    } catch (Exception $e) {
                        $error = true;
                        $output .= "Error al intentar enviar correo electronico: " + e.getMessage();
                    }
                }else{
                    $error = true;
                    $output = "Error, por favor seleccione notificación que desea enviar";
                }
                echo json_encode(array('error'=>$error,'output' => $output));

                break;
            case 'form_logic_envia_notificaciones':
                $error = false;
                $output = "";
                $notificacion = $data['lstNotificacion'];
                if($notificacion != '#') {
                    $users = $data['table_row_check'];
                    $query = "SELECT * FROM logic_notificaciones a WHERE a.inactivo = 0 AND a.id = '$notificacion'";
                    $data = DB::select($query);
                    try {
                        foreach ($users as $user) {
                            $query = "SELECT u.id AS ID,
                                CONCAT(u.nombre1,' ',u.apellido1,' ',u.apellido2) AS NOMBRE,
                                u.email AS EMAIL
                                FROM auth_usuarios u WHERE u.inactivo = 0 AND u.id = " . $user;
                            $data_user = DB::select($query);
                            $mailable = new Notificacion();
                            $mailable->setArchivo($data[0]->archivo);
                            $mailable->setAsunto($data[0]->asunto);
                            $mailable->setPara($data_user[0]->NOMBRE);
                            $mailable->setCuerpoMensaje($data[0]->cuerpo_mensaje);
                            $mailable->setDelay(intval(env('MAIL_DELAY')));
                            Mail::to($data_user[0]->EMAIL)->cc(env('MAIL_FROM_ADDRESS'))->send($mailable);

                            $asunto = "";
                            if($data[0]->archivo != null && $data[0]->archivo != ''){
                                $asunto = $data[0]->asunto." <br/> Archivo: ".$data[0]->archivo;
                            }else{
                                $asunto = $data[0]->asunto;
                            }

                            $aud_correo = AudCorreo::create([
                                'de' => env('MAIL_FROM_ADDRESS'),
                                'usuario_para' => $data_user[0]->ID,
                                'correo_para' => $data_user[0]->EMAIL,
                                'asunto' => $asunto,
                                'cuerpo' => $data[0]->cuerpo_mensaje,
                                'fecha_envio' => date('Y:m:d H:i:s'),
                                'tipo_correo' => 'NOTIFICACIÓN',
                                'inactivo' => 0,
                            ]);

                            $output .= "Enviado a " . $data_user[0]->NOMBRE . " email: " . $data_user[0]->EMAIL . "*";
                        }
                    } catch (Exception $e) {
                        $error = true;
                        $output .= "Error al intentar enviar correo electronico: " + e.getMessage();
                    }
                }else{
                    $error = true;
                    $output = "Error, por favor seleccione notificación que desea enviar";
                }
                echo json_encode(array('error'=>$error,'output' => $output));
            break;
        }
    }
}
