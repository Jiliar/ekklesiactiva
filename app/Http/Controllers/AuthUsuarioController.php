<?php

namespace App\Http\Controllers;

use App\Mail\Notificacion;
use App\Models\AuthUsuario;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Hash;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Support\Facades\Mail;
use App\Models\AudCorreo;

class AuthUsuarioController extends Controller
{
    public $invalido = false;
    public $items = "";
    public $tokenExterno = '';

    public function index(){
        return AuthUsuario::all();
    }

    public function show($id){
        return AuthUsuario::find($id);
    }

    public function store(Request $request){
        return AuthUsuario::create($request->all());
    }

    public function update(Request $request, $id){
        $authUsuario = AuthUsuario::findOrFail($id);
        $authUsuario->update($request->all());
        return $authUsuario;
    }

    public function delete(Request $request, $id){
        $authUsuario = AuthUsuario::findOrFail($id);
        $authUsuario->delete();
        return 204;
    }


    public function showLogin(){
        return view('contacto.login');
    }

    public function showRegistrar(Request $request){
        $sql = "SELECT * FROM auth_tipos_id WHERE inactivo = 0";
        $tipos_id = DB::connection('local')->select($sql);
        return view('contacto.register')->with('tipos_id',$tipos_id);
    }

    public function resetUsuario(){
        return view('contacto.reset');
    }

    public function resetPassword(Request $request){
        $data = $request->all();
        $utils = new Utils();
        $user = $utils->descifrar($data['id']);
        $clave = $data['clave'];
        $reclave = $data['reclave'];
        $error = false;
        $output = "";
        if($clave == $reclave){
            $query = "SELECT * FROM auth_usuarios u WHERE u.inactivo = 0 AND u.id = ".$user;
            $data_user = DB::select($query);
            $usuario = $data_user[0]->identificacion;
            $claveEncriptada = sha1(md5(trim($usuario) . trim($clave)));
            if($data_user[0]->password_app != $claveEncriptada) {
                $claveJWT = Hash::make($clave);
                $answer = DB::table('auth_usuarios')
                    ->where('id', $user)
                    ->update(['password' => $claveJWT, 'password_app' => $claveEncriptada]);
                $error = false;
                $output = "¡Las contraseñas fueron cambiadas exitosamente!";
            }else{
                $error = true;
                $output = "¡No se ha realizado actualización de contraseñas,
                            la contraseña insertada es igual a la salvada anteriormente!";
            }
        }else{
            $error = true;
            $output = "¡Las contraseñas insertadas no coinciden!";
        }
        echo json_encode(array('error'=>$error, 'output' => $output));
    }


    public function registrarUsuario(Request $request){
        $error = false;

        try {
            $body = $request->all();
            $body['id_perfil'] = 5;
            $body['inactivo'] = 0;

            $url = env('API_URL') . "register";
            $headers = [
                'Accept' => '*/*',
                'Content-Type' => 'application/json'
            ];

            $client = new Client();
            $res = $client->post($url, [
                'headers' => $headers,
                'json' => $body
            ]);


            $user = json_decode($res->getBody(), true)['user'];
            //Enviar correo de confirmación
            $utils = new Utils();
            $user1 = $utils->cifrar($user['id']);
            $asunto2 = 'CONFIRMACIÓN DE CUENTA - EKKLESIACTIVA';
            $cuerpo_mensaje2 = "<p>Estimado usuario</p>
                                <p>Usted se ha registrado en el portal
                                <a href='".env('HOST_URL')."' target='_blank'>".env('HOST_URL')."</a>
                                </br>Para terminar con la gestión de registro confirme su correo aquí</p>
                                <a href='".env('HOST_URL')."confirmacion/xid=".$user1."' target='_blank'>
                                <p style='padding:10px; background:#FF7000; color:white; text-align:center;
                                font-weight:bold; font-size:18px; text-decoration: none !important;'>
                                Click Aquí</p></a><br/><br/>";
            $mailable = new Notificacion();
            $mailable->setArchivo(null);
            $mailable->setAsunto($asunto2);
            $mailable->setPara($body['nombre1'].' '.$body['apellido1']);
            $mailable->setCuerpoMensaje($cuerpo_mensaje2);
            $mailable->setDelay(intval(env('MAIL_DELAY')));
            Mail::to($body['email'])->cc(env('MAIL_FROM_ADDRESS'))->send($mailable);



            $aud_correo = AudCorreo::create([
                'de' => env('MAIL_FROM_ADDRESS'),
                'usuario_para' => $user['id'],
                'correo_para' => $user['email'],
                'asunto' => $asunto2,
                'cuerpo' => $cuerpo_mensaje2,
                'fecha_envio' => date('Y:m:d H:i:s'),
                'tipo_correo' => 'CONFIRMACIÓN',
                'inactivo' => 0,
            ]);

            $output = $user;
        }catch(ClientException $e){
            $error = true;
            $response = $e->getResponse();
            $info = json_decode(json_decode($response->getBody()->getContents(), true));
            $output = "";
            foreach($info as $key => $val){
                $validacion = "";
                if($val[0] == "validation.unique"){
                    $validacion = " debe ser unico y ya ha sido registrado antes.";
                }else if($val[0] == "validation.min.string"){
                    $validacion = " es muy corto.";
                }
                $output .= "<p>El campo ".$key.$validacion."</p>";
            }
        }
        echo json_encode(array('error'=>$error, 'output' => $output));
    }


    public function login(Request $request, $token = '') {
        // Validacion de conexion externa por token en URL ..
        $tokenExterno = $token;
        if($tokenExterno != '' && $tokenExterno != null) {
            $query = "SELECT u.*, r.id idrol, r.nombre nomrol
                      FROM auth_usuarios  u
                      LEFT JOIN auth_perfiles r ON r.id = u.id_perfil
                      WHERE SHA1(MD5(CONCAT(u.homologacion, CURDATE()))) = '$tokenExterno'";
        } else  {
            // Entrada normal por vista 'login'
            $usuario = $request->usuario;
            $clave   = $request->clave;
            $claveEncriptada = sha1(md5($usuario.$clave));
            $query = "SELECT u.*, r.id idrol, r.nombre nomrol
                      FROM auth_usuarios  u
                      LEFT JOIN auth_perfiles r ON r.id = u.id_perfil
                      WHERE u.inactivo = 0 AND u.usuario = '$usuario' AND u.password_app = '$claveEncriptada'";
        }

        $registro = DB::select($query);
        if(!$registro || (count($registro) != 1))
            echo json_encode(array('error'=>true, 'output' => 'Compruebe que su usuario esté activo, así como su usuario y/o contraseña'));
        else  {

            $idusuario = $registro[0]->id;
            $perfil    = $registro[0]->idrol;

            session()->put('app_idusuario',        $idusuario);
            session()->put('app_idrol',            $registro[0]->idrol);

            $query = "SELECT
                        a.menu_subitems
                      FROM auth_usuarios u
                      INNER JOIN auth_perfiles a ON a.id = u.id_perfil
                      WHERE u.id=$idusuario AND u.inactivo = 0";

            $reg = DB::select($query);

            $menu_subitems = $this->menu_subitems($reg[0]->menu_subitems);

            $imagen = ($registro[0]->archivo == '' || $registro[0]->archivo == null)?'images/nn.png':$registro[0]->archivo;

            session()->put('app_menu_subitems',    $menu_subitems);
            session()->put('app_nomusuariocorto',  $registro[0]->nombre1.' '.$registro[0]->apellido1);
            session()->put('app_nomusuario',       $registro[0]->nombre1.' '.$registro[0]->nombre2.' '.$registro[0]->apellido1.' '.$registro[0]->apellido2);
            session()->put('app_nomusuario_abrev', $registro[0]->nombre1.' '.$registro[0]->apellido1);
            session()->put('app_nomrol',           $registro[0]->nomrol);
            session()->put('app_idrol',            $registro[0]->idrol);
            session()->put('app_documento',        $registro[0]->identificacion);
            session()->put('app_imagen',           $imagen);
            session()->put('app_usuario',          $registro[0]->usuario);
            //JWT
            $response = Api::Post('login','',array('usuario'=>$request->usuario, 'password'=>$request->clave));
            session()->put('auth_token', $response['token']);
            //dd($response['token']);
            $output = array('view'=>'inicio');
            echo json_encode(array('error'=>false, 'output' => $output));
        }
    }

    public function confirmacion(Request $request){
        $data = explode("=",$_SERVER['REQUEST_URI']);
        if($data[0] == "/confirmacion/xid" || $data[0] == "confirmacion/xid"){
            $utils2 = new Utils();
            $user1 = $utils2->descifrar($data[1]);
            $affected = DB::table('auth_usuarios')
                ->where('id', $user1)
                ->update(['inactivo' => 0]);
            return view('correos.confirmacion');
        }
    }

    public function valida(Request $request) {
        if($request->token) {
            $this->tokenExterno = $request->token;
            $this->login(request());
        } else {
            if(session()->get('tokensesion') != null)
                return view('plantillas.inicio')->with('mensaje','Conexion Exitosa')->with('titulo','Informacion');
            else
                return view('contacto.login')->with('mensaje','')->with('titulo','');
        }

    }

    public function inicio(Request $request) {
        return view('plantillas.inicio')->with('mensaje','Bienvenido al sistema')->with('titulo','Saludo');
    }

   public function menu_subitems($subitems) {
        $info = 0;
        if($subitems != '' and $subitems != null) {
            $sql = "SELECT s.*,
                        i.icono AS icono,
                        i.modulo_categoria AS modulo_categoria
                    FROM menu_subitems s
                    INNER JOIN menu_items i ON i.id = s.id_item
                    WHERE s.inactivo = 0 AND i.inactivo = 0 AND  s.id IN ($subitems)
                    AND (FN_JSON_VERIFY_DATA(s.acceso, " . session()->get('app_idrol') . ", '$.perfil') = 'VERDADERO'
                    AND FN_JSON_VERIFY_DATA(s.acceso, " . session()->get('app_idusuario') . ", '$.usuarios') = 'FALSO')
                    ORDER BY i.orden ASC
                    ";
                    //dd($sql);
            $menues = DB::select($sql);
            $pos = 0;
            $items = array();
            $info = "";
            foreach ($menues as $dato) {
                if(!in_array($dato->id_item, $items)){
                    $items[$pos] = $dato->id_item;
                    $info .= "<li class='bg-planoB'>
                                <a href='#' class='dropdown-toggle bg-planoB fg-white'>
                                    <span class='icon'><span class='" . $dato->icono . " fg-planoC'></span></span>
                                    <span class='caption'>" . $dato->modulo_categoria . "</span>
                                </a>
                            </li>" . $this->opcionesmenu_subitems($dato->id_item);
                }
                $pos++;
            }
        }
        return($info);
    }

    public function cerrarSesion() {
        session()->put('app_idusuario','');
        session()->forget('app_menu_subitems');
        session()->forget('app_aplicaciones');
        session()->forget('app_nomusuariocorto');
        session()->forget('app_nomusuario');
        session()->forget('app_idrol');
        session()->forget('app_nomrol');
        session()->forget('app_idempresa');
        session()->forget('auth_token');
        echo "<script type='text/javaScript'> const nextURL = '".env('HOST_URL')."'; window.location.href = nextURL; </script>";
    }

    public function restorepassword(Request $request){
        $data = $request->all();
        $data = json_decode($data['data']);
        $passwordActual = $data->txtPasswordActual;
        $passwordNuevo = $data->txtPasswordNueva;
        $passwordRepetido = $data->txtPasswordRepetido;
        $msg = "";
        $error = true;
        if($passwordNuevo != $passwordActual){
            if($passwordNuevo == $passwordRepetido){
                $usuario = session()->get('app_idusuario');

                $query = "SELECT *
                            FROM auth_usuarios a
                            WHERE a.inactivo = 0 AND a.id = ".$usuario;
                $answer = DB::select($query);

                $value = sha1(md5(trim($answer[0]->identificacion).trim($passwordActual)));

                if($value == $answer[0]->password_app){
                    $password= Hash::make(trim($passwordNuevo)); //Contraseña JWT
                    $password_app = sha1(md5(trim($answer[0]->identificacion).trim($passwordNuevo)));
                    $query = "UPDATE auth_usuarios SET password = ?, password_app= ? WHERE id = ?";
                    $answer = DB::update($query, [$password, $password_app, $usuario]);($query);
                    if($answer){
                        $error = false;
                        $msg = "¡Operación realizada exitosamente!";
                    }
                }else{
                    $error = true;
                    $msg = "¡La contraseña actual del usuario no es legitima, Por favor verifiquela!";
                }
            }else{
                $error = true;
                $msg = "¡Existen inconsistencias en la digitación de la Contraseña Nueva y la Repetición de la misma, Por favor verifique!";
            }
        }else{
            $error = true;
            $msg = "¡Las constraseñas asignadas debe ser diferentes, Por favor verifique!";
        }
        echo json_encode(array('error'=>$error,'output' => $msg));
    }


    public function objSelect($conexion, $tabla, $campoID, $campoTEXTO, $caption, $id, $condicion) {
        $html = "<select id='$id' data-role='select' data-prepend='$caption'>";
        $html .= "<option value=''>Seleccione...</option>";
        if($condicion != '') $condicion = " WHERE $condicion ";
        $query = "SELECT $campoID campoid, $campoTEXTO campotexto FROM $tabla $condicion ORDER BY $campoTEXTO";
        $reg = DB::connection($conexion)->select($query);
        if(count($reg) > 0)
            foreach($reg as $dato) {
                if($dato->campotexto != '')
                    $html .= "<option value='".$dato->campoid."'>".$dato->campotexto."</option>";
            }

        $html .= "</select>";
        return $html;
    }

    public function userList() {
        $resultado  = [];

        $query =   "SELECT u.*, r.nombre nomrol, s.nombre nomsucursal
                    FROM auth_usuarios u
                    LEFT JOIN auth_perfiles r ON r.id = u.id_perfil
                    LEFT JOIN sucursales s ON s.id = u.sucursal
                    ORDER BY concat(u.apellido1, u.nombre1)";
        $info = DB::select($query);
        $tabla = '<table id="listaUsuarios" data-role="table" class="table row-border subcompact row-hover">';
        $tabla .= '<thead>';
        $tabla .= '<tr><th>Identificacion</th>
                       <th>Apellidos y Nombre(s)</th>
                       <th>Rol / Perfil</th>
                       <th>Sucursal</th>
                       <th>Correo</th>
                       <th>Telefono(s)</th>
                       <th>Estado<br>CTI</th>
                       <th>Estado<br>AC</th>
                       <th>Accion</th>
                    </tr>';
        $tabla .= '</thead><tbody>';
        foreach($info as $dato) {

            if($dato->estado == 1) $check_cti = 'checked'; else $check_cti = '';
            if($dato->inactivo == 0) $check_as = 'checked'; else $check_as = '';

            $activo_cti = '<input onclick="userStatus('.$dato->id.',0)" type="checkbox" data-role="switch" '.$check_cti.' data-material="true">';
            $activo_ac  = '<input onclick="userStatus('.$dato->id.',1)" type="checkbox" data-role="switch" '.$check_as.' data-material="true">';

            $boton = '<button onclick="showUser('.$dato->id.')" class="button small alert outline">Ver</button>';

            if($dato->estado == 0) $estado = 'Bloqueado'; else $estado = 'Activo';
            $tabla .= '<tr><td>'.$dato->identificacion.'</td>
                           <td>'.$dato->apellido1.' '.$dato->apellido2.' '.$dato->nombre1.' '.$dato->nombre2.'</td>
                           <td>'.$dato->nomrol.'</td>
                           <td>'.$dato->nomsucursal.'</td>
                           <td>'.$dato->email.'</td>
                           <td>'.$dato->tel_movil.' '.$dato->tel_fijo.'</td>
                           <td>'.$activo_cti.'</td>
                           <td>'.$activo_ac.'</td>
                           <td>'.$boton.'</td>
                        </tr>';
        }
        $tabla .= '</tbody></table>';
        $data = $resultado;
        return $tabla;
    }

    public function tabsRoles(){
        $estructura = '';
        $sql = "SELECT c.*
                FROM config_tablas_permisos c
                WHERE c.estado = 1";
        $info = DB::select($sql);
        if(count($info) >0) {
            $estructura .= '<style>.marcar:hover { background-color: yellow; }</style><ul data-role="materialtabs"
                                data-fixed-tabs="false"
                                data-deep="true">';
            for($i=0; $i < count($info); $i++) {
                $estructura .= '<li>
                                    <a class="fg-crimson" href="#tab'.$i.'">'.$info[$i]->descripcion.'</a>
                                </li>';
            }
            $estructura .= '</ul>';
            $estructura .= '<div style="margin-top:50px">';
            for($i=0; $i < count($info); $i++) {
                $query = str_replace("filtro","''",$info[$i]->consulta);
                $dbo   = $info[$i]->dbo;

                $reg = DB::connection($dbo)->select($query);
                $num = count($reg);
                if($num > 0) {
                    $contenido = '<b>Items '.$num.'</b><hr>';

                    $contenido .= '<table class="table striped table-border mt-4"
                                           data-role="table"
                                           data-rows="8"
                                           data-rows-steps="5, 6, 7, 8, 9, 10"
                                           data-show-activity="false"
                                           data-rownum="true"
                                    >';
                    $contenido .= '<thead><tr><th>Descripcion</th></tr></thead><tbody>';
                    foreach($reg as $dato) {
                        $contenido .=  '<tr><td class="marcar">
                                            <input type="checkbox" data-role="checkbox" onclick="cambiaEstado()">
                                            '.$dato->texto.'</td>
                                        </tr>';
                    }
                    $contenido .= '</tbody></table>';
                }

                $estructura .= '<div id="tab'.$i.'">'.$contenido.'</div>';

            }
            $estructura .= '</div>';
        }
        return $estructura;
    }

    public function tabsRoles2(Request $request){
        // Parametros -----------------------------
        $usuario  = $request->id_usuario;
        $perfil   = $request->id_rol;
        $empresas = $request->id_empresas;
        $filtro   = $request->filtro; // usuarios  perfil  empresas

        //dd("$usuario $perfil $empresas $filtro");

        $estructura = '';
        $sql = "SELECT c.*
                FROM config_tablas_permisos c
                WHERE c.estado = 1 ORDER BY c.orden";
        $info = DB::select($sql);

        if(count($info) >0) {
            $estructura .= '<style>.marcar:hover { background-color: yellow; }</style><ul data-role="materialtabs"
                                data-fixed-tabs="false"
                                data-deep="true">';
            for($i=0; $i < count($info); $i++) {
                $estructura .= '<li>
                                    <a class="fg-crimson" href="#tab'.$i.'">'.$info[$i]->descripcion.'</a>
                                </li>';
            }

            $estructura .= '</ul>';
            $estructura .= '<div style="margin-top: 50x">';
            for($i=0; $i < count($info); $i++) {

                $consulta = $info[$i]->consulta;
                $dbo   = $info[$i]->dbo;
                $sql2 = '';
                $condicion = '';

                if($info[$i]->tabla == 'menu_subitems') { // Condicion especial para los menu_subitems
                    $tempo = 'menu_subitems';
                    $sql2 = "SELECT
                                a.menu_subitems s
                            FROM auth_usuarios u
                            INNER JOIN auth_perfiles a ON a.id = u.id_perfil
                            WHERE u.id= $usuario AND u.inactivo = 0 AND s.inactivo = 0";

                    $infoU = DB::select($sql2);
                    if(count($infoU) > 0) {
                        $condicion = ' s.id IN ('.$infoU[0]->menu_subitems.')';
                    }

                    $condicion = "SELECT s.id, CONCAT(a.nombre,' - ',ad.modulo_nombre,' - ', s.descripcion) texto ,
                                    if($condicion,'checked','') estado_check
                                    FROM menu_subitems s
                                    LEFT JOIN  aplicaciones_det ad ON s.id_aplicaciones_det = ad.id
                                    LEFT JOIN aplicaciones a ON a.id = ad.id_aplicacion
                                    WHERE ad.inactivo = 0 AND  ad.estado = 1
                                    AND s.inactivo = 0
                                    ORDER BY a.nombre, ad.modulo_nombre;";

                    $reg = DB::select($condicion);

                }  else { // Para las demas tablas
                    if ($filtro == 'usuarios') {
                        $query = str_replace("filtro","if(FN_JSON_VERIFY_DATA(fr.acceso, ?, '$.usuarios') = 'FALSO','','checked') ",$consulta);
                        $valor_filtro = $usuario;
                    }
                    if ($filtro == 'perfil')      {
                        $query = str_replace("filtro","if(FN_JSON_VERIFY_DATA(fr.acceso, ?, '$.perfil') = 'VERDADERO' ,'checked','') ",$consulta);
                        $valor_filtro = $perfil;
                    }
                    if ($filtro == 'empresas')      {
                        $query = str_replace("filtro","if(FN_JSON_VERIFY_DATA(fr.acceso, ?, '$.empresas') = 'VERDADERO' ,'checked','') ",$consulta);
                        $valor_filtro = $empresas;
                    }

                    $reg = DB::connection($dbo)->select($query,[$valor_filtro]);
                }

                $num = count($reg);

                if($num > 0) {
                    $contenido = '<b>Items '.$num.'</b><hr>';

                    $contenido .= '<table class="table striped table-border mt-4"
                                           data-role="table"
                                           data-rows="8"
                                           data-rows-steps="5, 6, 7, 8, 9, 10"
                                           data-show-activity="false"
                                           data-rownum="true"
                                    >';
                    $contenido .= '<thead><tr><th>Descripcion</th></tr></thead><tbody>';
                    foreach($reg as $dato) {
                        $contenido .=  '<tr><td class="marcar">
                                            <input id="'.$info[$i]->tabla.'--'.$dato->id.'"  '.$dato->estado_check.' data-role="checkbox" type="checkbox" onclick="cambiaEstado(\''.$info[$i]->tabla.'\','.$dato->id.')">
                                            '.$dato->texto.'</td>
                                        </tr>';
                    }
                    $contenido .= '</tbody></table>';
                }

                $estructura .= '<div id="tab'.$i.'">'.$contenido.'</div>';
            }
            $estructura .= '</div>';
        }
        return $estructura;
    }

    public function userConf(Request $request) {
        $encabezado = ['Content-Type' => 'text/html'];
        $mensaje = '';
        $id = $request->id;
        switch($request->accion) {
            case 'status':
                $app  = $request->estadoApp; // 0 estado cti     1 estado AsercolCentral

                if($app == 0) { // Cambio estado entrada a CTI
                    $EAn  = DB::select("SELECT estado FROM auth_usuarios WHERE id = $id")[0]->estado;
                    if ($EAn == 1) $EAc = 2; else $EAc = 1;
                    DB::update("UPDATE usuarios SET estado = $EAc WHERE id = $id");
                }

                if($app == 1) { // Cambio estado entrada a ASERCOL CENTRAL
                    $EAn  = DB::select("SELECT estado_usuario FROM auth_usuarios WHERE id = $id")[0]->estado_usuario;
                    if ($EAn == 1) $EAc = 0; else $EAc = 1;
                    DB::update("UPDATE usuarios SET estado_usuario = $EAc WHERE id = $id");
                }

                $mensaje ='Cambio de estado realizado exitosamente ';
                break;
            case 'listado':
                $data = DB::select("SELECT u.*, r.nombre nomrol
                                                       FROM auth_usuarios u
                                                       LEFT JOIN auth_perfiles r ON r.id = u.id_perfil
                                                       WHERE u.id = $id");
                return response()->json(compact('data'), 200, $encabezado);
                break;
            default:
        }
        return $mensaje;
    }

    public function opcionesmenu_subitems($id_categoria) {
        $res = "";
        $reg = DB::select(" SELECT *
                            FROM   menu_subitems s
                            WHERE  inactivo = 0
                                AND (FN_JSON_VERIFY_DATA(s.acceso, " . session()->get('app_idrol') . ", '$.perfil') = 'VERDADERO'
                                AND FN_JSON_VERIFY_DATA(s.acceso, " . session()->get('app_idusuario') . ", '$.usuarios') = 'FALSO')
                                AND s.id_item = $id_categoria");
        if (count($reg) > 0) {
            $res .= "<ul class='navview-menu stay-open menu_subitems' data-role='dropdown'>";
            foreach($reg as $d) {
                if($d->ruta == '')
                    $res .= "<li><a><span class='caption'>".$d->abreviado."</span></a></li>";
                else
                    $res .= "<li><a href='#' onclick='llamarVista(\"".$d->etiqueta."\",\"".$d->descripcion."\")' ><span class='caption'>".$d->abreviado."</span></a></li>";
                }
            $res .= "</ul>";
        }
        return $res;
    }

    public function changePassword(Request $request) {
        $usuario = session()->get('app_usuario');
        $id      = session()->get('app_idusuario');
        $actual  = $request->p_actual;
        $nueva   = $request->p_nueva;

        $claveEncriptada = sha1(md5($usuario.$actual));
        $nuevaClaveEncriptada = sha1(md5($usuario.$nueva));

        $query = "SELECT u.* FROM auth_usuarios  u WHERE u.inactivo = 0 AND u.usuario = '$usuario' AND u.password_app = '$claveEncriptada'";
        $info = DB::select($query);

        if(count($info) == 1) {
            $query = "UPDATE usuarios SET password_app = '$nuevaClaveEncriptada' WHERE id = $id";
            $info = DB::update($query);
            $mensaje = array(0=>1, 1=>"OPERACION EXITOSA\n\nSu contraseña fue cambiada con exito\n\nLe recomendamos cerrar la sesion e ingresar con sus nuevas credenciales");
        } else {
            $mensaje = array(0=>0, 1=>"ERROR DE VALIDACION\n\nNo pudo realizarse el cambio de contraseña, posiblemente la contraseña actual este errada, por favor intente de nuevo");
        }
        return $mensaje;
    }

    public function rolesUsuario(Request $request) {
        // http://localhost/rolesUsuario?id=3&elemento=perfil&valor=14&tabla=aplicaciones&modo=eliminar
        // Parametros --------------------------------
        $tabla    = $request->tabla;
        $elemento = $request->elemento;
        $id       = $request->id; // Id del registro
        $valor    = $request->valor;
        $modo     = $request->modo;

        $mensaje = 'No se ha resuelto la peticion';

        if($tabla == 'menu_subitems') {
            // Actualizacion de opciones del menu de usuarios
            $usuario = $request->usuario;
            $sql = "SELECT * FROM auth_usuarios WHERE id = $usuario";
            $info = DB::select($sql);
            $mensaje = 'Opciones de usuario actualizadas...';
        } else {
            // Actualizacion de las demas tablas
            // http://localhost/rolesUsuario?usuario=875&valor=14&tabla=menu_subitems&modo=eliminar
            $sql = "SELECT  a.*, JSON_UNQUOTE(JSON_EXTRACT(a.accesos, '$.usuarios')) lista_idusu
                    FROM $tabla a WHERE a.id = $id";
            $acceso = DB::select($sql)[0]->accesos;

            $can = strlen($acceso);
            $tempo = strpos($acceso, $elemento);
            $ini = -1; $fin = -1;
            for($i=$tempo; $i < $can; $i++) {
                if($acceso[$i] == "[" && $ini == -1) $ini = $i;
                if($acceso[$i] == "]" && $fin == -1) $fin = $i;
            }
            $valores = substr($acceso, $ini + 1 , $fin - $ini - 1);
            $partes = array('parte1'=>substr($acceso,0, $ini + 1),
                            'parte2'=>$valores,
                            'parte3'=>substr($acceso,$fin, $can - $fin));

            if($valores != "")
                $vector = explode(',',$valores);
            else
                $vector = array();
            $posi = array_search($valor, $vector);

            // Eliminando valor -----------------------
            if($modo == 'eliminar') {
                if(!($posi === false)) {
                    unset($vector[$posi]);
                    $nuevos_valores = implode(',',$vector);
                    $nuevo_acceso = $partes['parte1'].$nuevos_valores.$partes['parte3'];
                    DB::update("UPDATE $tabla SET accesos = '$nuevo_acceso' WHERE id = $id");
                    $mensaje = "Eliminado el valor $valor de $elemento en $tabla con id $id";
                } else {
                    $mensaje = "No existe el valor";
                }
            }

            // Insertando valor -----------------------
            if($modo == 'insertar') {
                if($posi === false) {
                    $vector[] = $valor;
                    sort($vector, SORT_NATURAL | SORT_FLAG_CASE);
                    $nuevos_valores = implode(',',$vector);
                    $nuevo_acceso = $partes['parte1'].$nuevos_valores.$partes['parte3'];
                    DB::update("UPDATE $tabla SET accesos = '$nuevo_acceso' WHERE id = $id");
                    $mensaje = "Insertado el valor $valor de $elemento en $tabla con id $id";
                } else {
                    $mensaje = "Ya existe el valor $valor de $elemento en $tabla con id $id";
                }
            }

        }

        return $mensaje;
    }

    public function verPerfil(Request $request) {
        if(session()->get('app_idusuario') == null) return 'Error de seguridad, Autenticacion invalida';
        switch($request->accion) {
            case 'ver':
                $usuario = session()->get('app_idusuario');
                $sql = "SELECT email, tel_movil, tel_fijo, archivo FROM auth_usuarios WHERE id = $usuario";
                $info = DB::select($sql);
                return json_encode($info);
                break;
            case 'guardar':
                $id = session()->get('app_idusuario');
                $email = $request->email;
                $tel_movil = $request->tel_movil;
                $tel_fijo = $request->tel_fijo;
                $sql = "UPDATE usuarios SET email ='$email', tel_movil='$tel_movil', tel_fijo='$tel_fijo' WHERE id = $id";
                DB::update($sql);
                return 'Informacion Actualizada con exito..';
                break;
            default:
                return 'Accion incorrecta';
        }
    }

}
