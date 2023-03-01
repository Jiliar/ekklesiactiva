<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;


class Utils extends Controller{

    public static function formatData($json, $etiqueta){
        $array = array();
        foreach($json as $key=>$value){
            $sql = "SELECT c.id_json FROM config_componentes_formulario c WHERE c.id_css = '$key' AND c.etiqueta= '$etiqueta'";
            $data = DB::select($sql);
            if($data != null && $data[0]->id_json != ""){
                if($key == 'txtPassword'){ //Para salvar contrase単as de usuario
                    $usuario = $array['usuario'];
                    $password_app = sha1(md5(trim($usuario).trim($value)));
                    $array[$data[0]->id_json]=trim($password_app);
                    $array['password']= Hash::make(trim($value)); //Contrase単a JWT
                }elseif($key == 'txtPonderacion' || $key == 'txtCalificacion'){
                    $array[$data[0]->id_json]= trim(str_replace(",", ".", $value));
                }elseif($key == 'txtAsignatura'){
                    $array[$data[0]->id_json]= strtoupper($value);
                }elseif($value != '' && $value != null){
                    $array[$data[0]->id_json]=trim($value);
                }

            }
        }
        $json = json_encode($array);
        $result = array('vector'=>$array,'json'=>$json);
        return $result;
    }

    public static function formatDataHTML($json, $etiqueta){
        $array = array();
        foreach($json as $key=>$value){
            $sql = "SELECT c.id_css FROM config_componentes_formulario c WHERE c.id_json = '$key' AND c.etiqueta= '$etiqueta'";
            $data = DB::select($sql);
            if($data != null && $data[0]->id_css != ""){
                $array[$data[0]->id_css]=trim($value);
            }
        }
        $json = json_encode($array);
        $result = array('vector'=>$array,'json'=>$json);
        return $result;
    }

    public static function getErrorMessage($msg){
        $query = "SELECT * FROM config_errors c WHERE c.estado = 1";
        $regs = DB::connection('local')->select($query);
        $msg_usr = "";
        foreach($regs as $reg){
            if(strpos($msg, $reg->mensaje) > 0){
                $msg_usr = $reg->lenguaje_usuario;
                break;
            }
        }
        $message = $msg_usr == ''?$msg:$msg_usr;
        return $message;
    }

    public static  function deleteOldFile($oldfile){
        $res = null;
        if(strpos(env('FILE_URL'), 'imagen') === false){
            $file = str_replace(env('FILE_URL'),env('FILE_LOCAL'), $oldfile);
            $res = Storage::disk('ftp')->delete($file);
        }
        return $res;
    }

    public static function uploadFile($data, $id){
        $files = array();
        $response = null;
        $json = json_decode($data['data'], TRUE);
        $uri = substr($json['hdnView'],5);
        $body = Utils::formatData($json, $uri);
        $token = session()->get('auth_token');
        foreach($data as $key => $val){
            if(stristr($key, 'file') !== false){
                $type = $val->getClientMimeType();
                $fecha = Date('Ymd');
                if($type == 'image/png' || $type == 'image/jpeg' || $type == 'application/pdf'){
                    $nombre_archivo = env('FILE_LOCAL').'/files/images/'.$uri.'/'.$fecha;
                }else{
                    $nombre_archivo = env('FILE_LOCAL').'/files/docs/'.$uri.'/'.$fecha;
                }
                $res = Storage::disk('ftp')->put($nombre_archivo, $val);
                array_push($files, $res);
            }
        }
        $valores = $body['vector'];
        $valores['id'] = strval($id);
        foreach($files as $file){
            $valores['archivo'] = str_replace(env('FILE_LOCAL'),env('FILE_URL'),$file);
            $response = Api::Put($uri, $token, $valores);
        }
        return  $response;
    }


    public static function evaluateDataRole($rol, $response){
        if($rol != 5){
            $collection = collect($response);
            $response = $collection->where('inactivo', 0);
            $response = $response->all();
        }
        return $response;
    }

    public static function getDataValidatUnique($etiqueta){
        $sql = "SELECT c.* FROM config_unique c WHERE c.etiqueta = '$etiqueta' AND inactivo = 0";
        $data = DB::select($sql);
        return $data;
    }

    public static function validateUnique($data, $valor){
        $flag = false;
        if(count($data) > 0){
            $tabla = $data[0]->etiqueta;
            $campo = $data[0]->id_comprobacion;
            $sql = "SELECT c.* FROM $tabla c WHERE c.$campo = '$valor'";
            $data = DB::select($sql);
            $flag = count($data)>0?true:false;
        }else{
            $data = null;
            $flag = false;
        }
        return $flag;
    }

    public static function securityRegister($vector, $table, $method){
        $sql = "SELECT COLUMN_NAME
                 FROM INFORMATION_SCHEMA.COLUMNS
                WHERE table_name = '$table';";
        $data = DB::select($sql);
        foreach($data as $value){
            if($value->COLUMN_NAME == 'acceso'){
                $vector['acceso']= '{"perfil": [0, 1, 2, 3, 4, 5], "empresas": [], "usuarios": []}';
                break;
            }
        }
        switch($method){
            case 'POST':
                switch($table) {
                    case 'logic_documentos_usuarios':
                        $vector['usuario_carga'] = session()->get('app_idusuario');
                        break;
                    default:
                        $vector['user_create'] = session()->get('app_idusuario');
                        break;
                }
                $vector['created_at'] = date('Y-m-d H:i:s');
                break;
            case 'PUT':
                $vector['user_update'] = session()->get('app_idusuario');
                $vector['updated_at'] = date('Y-m-d H:i:s');
                break;
        }
        return $vector;
    }

    function cifrar($string,$secret_key='19') {
        $output = false;
        $encrypt_method = "AES-256-CBC";
        $secret_iv = env('APP_KEY');
        $key = hash('sha256', $secret_key);
        $iv = substr(hash('sha256', $secret_iv), 0, 16);
        $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
        $output = base64_encode($output);
        return $output;
    }


    function descifrar($string,$secret_key='19') {
        $output = false;
        $encrypt_method = "AES-256-CBC";
        $secret_iv = env('APP_KEY');
        $key = hash('sha256', $secret_key);
        $iv = substr(hash('sha256', $secret_iv), 0, 16);
        $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
        return $output;
    }

}
