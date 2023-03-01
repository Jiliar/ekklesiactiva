<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Calculation\MathTrig\Exp;

class ScreenController extends Controller
{
    public function vistas(Request $request)
    {
        $perfil = session()->get('app_idrol');
        $usuario = session()->get('app_idusuario');
        $h_ctrl = new HTMLBuilderController();

        $vista = $request->vista;
        $nomVista = $request->nomVista;
        $controles = $this->getInfo($vista, $perfil, $usuario, 'config_componentes_formulario');
        $visualizacion = false;
        $componentes = "";
        $n=$h_ctrl->grid4();

        if (count($controles) > 0) {

            $visualizacion = true;
            $componentes = $this->getComponents($controles, $perfil, $usuario);
            $html = "";
            if($visualizacion){
                switch($vista){
                    case 'inicio':
                        $token_laravel = $h_ctrl->Input('_token', csrf_token(), '', '', 'hidden');
                        //get Data Slider
                        $sliders = $this->getCMSContent('SLIDER');
                        //get Data Noticias
                        $news = $this->getCMSContent('NOTICIA');
                        //get Data Convocatorias Academicas
                        $convocatorias_academicas = $this->getConvocatoriasContent(1);
                        //get Data Convocatorias Empleo
                        $convocatorias_empleo = $this->getConvocatoriasContent(2);
                        //Generate Slider
                        $diapositivas = $h_ctrl->Corrousel($sliders);

                        //Convocatorias Academicas
                        $div_convocatorias_academicas = "";

                        if(count($convocatorias_academicas)>0){
                            $convocatorias = "";
                            foreach($convocatorias_academicas as $new){
                                $requisitos = $this->getRequisititosContent($new->id);
                                $convocatorias .=$h_ctrl->CardDialog($new->nombre,$new->archivo,$new->descripcion_convocatoria, $new->enlace, $new->created_at,$h_ctrl->grid1(), $new->id, $requisitos, $usuario, $new->tipo_convocatoria);
                            }
                            $titulo_convocatorias = "<div class='cell-sm-12 cell-md-12 cell-lg-12 cell-xl-12 cell-xxl-12' style='text-align: center;'><h1 class='title-noticias'>Convocatorias Academicas</h1></div>";
                            $div_convocatorias_academicas = $h_ctrl->Div('convovatorias-container','row',$titulo_convocatorias,'display: flex; justify-content: center;','');
                            $div_convocatorias_academicas .= $h_ctrl->Div('convovatorias-container','row',$convocatorias,'display: flex; justify-content: center;','');
                        }
                        //Convocatorias Empleo
                        $div_convocatorias_empleo = "";
                        if($perfil != 0) {
                            if (count($convocatorias_empleo) > 0) {
                                $convocatorias = "";
                                $usuario = session()->get('app_idusuario');
                                foreach ($convocatorias_empleo as $new) {
                                    $requisitos = $this->getRequisititosContent($new->id);
                                    $convocatorias .= $h_ctrl->CardDialog($new->nombre, $new->archivo, $new->descripcion_convocatoria, $new->enlace, $new->created_at, $h_ctrl->grid1(), $new->id, $requisitos, $usuario, $new->tipo_convocatoria);
                                }
                                $titulo_convocatorias = "<div class='cell-sm-12 cell-md-12 cell-lg-12 cell-xl-12 cell-xxl-12' style='text-align: center;'><h1 class='title-noticias'>Convocatorias de Empleabilidad</h1></div>";
                                $div_convocatorias_empleo = $h_ctrl->Div('convovatorias-container', 'row', $titulo_convocatorias, 'display: flex; justify-content: center;', '');
                                $div_convocatorias_empleo .= $h_ctrl->Div('convovatorias-container', 'row', $convocatorias, 'display: flex; justify-content: center;', '');
                            }
                        }
                        //Noticias
                        $div_noticias = "";
                        if(count($news)>0){
                            $noticias = "";
                            foreach($news as $new){
                                $noticias .=$h_ctrl->Card($new->titulo,$new->archivo,substr($new->contenido,0,255), $new->articulo_enlace, $new->created_at,$h_ctrl->grid1());
                            }
                            $titulo_noticias = "<h1 class='title-noticias'>Noticias</h1>";
                            $div_noticias = $h_ctrl->Div('news-container','row',$titulo_noticias,'display: flex; justify-content: center;','');
                            $div_noticias .= $h_ctrl->Div('news-container','row',$noticias,'display: flex; justify-content: center;','');
                        }

                        $html = $diapositivas.$div_noticias;
                    break;
                    default:
                        $token_laravel = $h_ctrl->Input('_token', csrf_token(), '', '', 'hidden');
                        $titulo_vista = "<div class='container-header'><div class='cuadrado1 fondo-header'></div><div class='cuadrado2'><h3>$nomVista</h3></div></div>";
                        $div_buttons = $h_ctrl->Div('','row','','display: flex; justify-content: center;','');
                        $componentes = $token_laravel.$componentes.$h_ctrl->Div('buttons-container', 'buttons-container', $div_buttons, '', $h_ctrl->grid12());
                        $contenido_formulario = $h_ctrl->Row('container-formulario', $componentes, 'margin: 0 auto;', '');
                        $contenido_formulario = $h_ctrl->Form('form_' .$request->vista, $contenido_formulario, 'POST', 'form_' . $request->vista . '@save');
                        $container_tabla =$h_ctrl->Div('container-detalles', '', '', 'overflow:auto;', $h_ctrl->grid12());
                        //Generación de Acordión
                        if($request->vista == 'logic_restaurar_password'){
                            $titulos_acordion = array('.:: Información General ::.');
                            $contenido_acordion = array($contenido_formulario);
                        }else{
                            $titulos_acordion = array('.:: Información General ::.', '.:: Listado Detallado ::.');
                            $contenido_acordion = array($contenido_formulario, $container_tabla);
                        }
                        $html .= $h_ctrl->Accordion($titulos_acordion, $contenido_acordion, true, 'main-panel');
                        $html = $titulo_vista . $html;
                    break;
                }

            }else{
                $html = "<span id='no-views'>No hay vista relacionada - conctacte al administrador del Sistema de información</span>";
            }


            return $html;
        }
    }

     public function getCMSContent($tipo){
        $query = "SELECT * FROM logic_cms a WHERE a.inactivo = 0 AND a.tipo_cms = '$tipo'";
        $data = DB::select($query);
        return $data;
    }

    public function getAllUsers(){
        $query = "SELECT * FROM auth_usuarios a WHERE a.inactivo = 0;";
        $data = DB::select($query);
        return $data;
    }

     public function getAllUsersWithFilters($tipo_usuario, $convocatoria){
        $v_tipo_usuario = "";
        if($tipo_usuario != '#'){
            $v_tipo_usuario = "AND a.id_perfil = ".$tipo_usuario;
        }
        $v_convocatoria = "";
        if($convocatoria != '#'){
            $v_convocatoria = "AND i.id_convocatoria = ".$convocatoria;
        }
        $query = "SELECT DISTINCT
                        a.*
                    FROM auth_usuarios a
                    LEFT JOIN logic_inscripciones i ON i.id_usuario = a.id
                    WHERE a.inactivo = 0
                    $v_tipo_usuario
                    $v_convocatoria
                    ";

        $data = DB::select($query);
        return $data;
    }

    public function getInfoCV($usuario){
        $tablas = array('auth_usuarios','logic_cv_informacion','logic_cv_experiencias',
                        'logic_cv_educacion','logic_cv_menciones',
                        'logic_cv_lenguajes','logic_cv_skills','logic_cv_intereses');
        $hv = array();
        foreach($tablas as $tabla){
            $condicion = $tabla == 'auth_usuarios'? "a.id = ".$usuario:"a.usuario_cv = ".$usuario;
            $start = $tabla == 'auth_usuarios'? 5:9;
            $query = "SELECT *
                        FROM ".$tabla." a
                        WHERE a.inactivo = 0 AND ".$condicion;
            $key = substr($tabla, $start, strlen($tabla));
            $hv[$key]=DB::select($query);
        }
        return $hv;
    }

     public function getConvocatoriasContent($tipo){
        $query = "SELECT * FROM logic_convocatorias a WHERE a.inactivo = 0 AND a.tipo_convocatoria = '$tipo'";
        $data = DB::select($query);
        return $data;
    }

    public function getUsuariosByTipo(){
        $query = "";

        if(session()->get('app_idrol') == 2){
            $query = "SELECT * FROM auth_usuarios a WHERE a.inactivo = 0 AND a.id_perfil = 3 AND a.id_empresa = ".session()->get('app_idempresa');
        }elseif(session()->get('app_idrol') == 3){
            $query = "SELECT * FROM auth_usuarios a WHERE a.inactivo = 0 AND a.id = ".session()->get('app_idusuario');
        }elseif(session()->get('app_idrol') == 1 || session()->get('app_idrol') == 5){
            $query = "SELECT * FROM auth_usuarios a WHERE a.inactivo = 0 AND a.id_perfil = 3";
        }

        $data = DB::select($query);
        return $data;
    }

    public function getEmpresas(){
        $query = "";
        if(session()->get('app_idrol') == 3 || session()->get('app_idrol') == 2){
            $query = "SELECT a.* FROM auth_empresas a INNER JOIN auth_usuarios u ON u.id_empresa = a.id WHERE a.inactivo = 0 AND u.id = ".session()->get('app_idusuario');
        }elseif(session()->get('app_idrol') == 1 || session()->get('app_idrol') == 5){
            $query = "SELECT a.* FROM auth_empresas a WHERE a.inactivo = 0";
        }
        $data = DB::select($query);
        return $data;
    }

    public function getTipoArchivosCargue(){
        $query = "SELECT a.id, a.nombre FROM logic_tipos_archivo_cargue a WHERE a.inactivo = 0";
        $data = DB::select($query);
        return $data;
    }

    public function getEtiquetas(){
        $query = "SELECT a.id, a.nombre FROM logic_etiquetas a WHERE a.inactivo = 0";
        $data = DB::select($query);
        return $data;
    }

    /* public function getRequisititosContent($id_convocatoria){
        $query = "SELECT
                    td.nombre AS TIPO_DOC,
                    r.nombre AS NOMBRE_REQUISITO,
                    r.descripcion AS DESC_REQUISITO,
                    r.condicion AS CONDICION,
                    r.necesita_adjunto AS NECESITA_ADJUNTO
                FROM logic_requisitos r
                INNER JOIN logic_convocatorias_requisitos cr ON cr.id_requisito = r.id
                INNER JOIN logic_convocatorias c ON c.id = cr.id_convocatoria
                INNER JOIN logic_tipo_documentos td ON td.id = r.tipo_doc
                WHERE
                c.id = ".$id_convocatoria;
        $data = DB::select($query);
        return $data;
    } */


    public function getInfo($vista, $perfil, $usuario, $tabla){
        $controles = array();
        try{
            $sql = "SELECT
                    *
                FROM $tabla a
                WHERE etiqueta = '$vista'
                    AND a.inactivo = 0
                    AND FN_JSON_VERIFY_DATA(a.acceso, " . $perfil . ", '$.perfil') = 'VERDADERO'
                    AND FN_JSON_VERIFY_DATA(a.acceso, " . $usuario . ", '$.usuarios') = 'FALSO'
                ORDER BY orden";
            $controles = DB::select($sql);
        }catch(Exception $e){
            $user = new AuthUsuarioController();
            $user->cerrarSesion();
            echo '<script type="text/javaScript"> location.reload(); </script>';
        }

        return $controles;
    }

    public function getComponents($controles, $perfil, $usuario){
        $h_ctrl = new HTMLBuilderController();
        $componentes =$h_ctrl->Input('hdnUsuario',  $usuario, '', '', 'hidden');
        $componentes .=$h_ctrl->Input('hdnPerfil',  $perfil, '', '', 'hidden');

        foreach ($controles as $v) {
            switch (trim($v->tipo)) {
                case 'date':
                case 'text':
                case 'number':
                case 'phone':
                case 'email':
                case 'password':
                    $value = ($v->id_css == 'txtAnio')?date('Y'):"";
                    $n = ($v->id_css == 'txtTitulo')?$h_ctrl->grid12():$h_ctrl->grid4();
                    if($v->etiqueta == 'auth_usuarios_complementarios' && strlen($v->caption) >= 23){
                        $n =$h_ctrl->grid12();
                    }
                    $componentes .= $h_ctrl->jTextfield($v->id_css, $v->caption, $value, $v->tipo, null, $v->custom_css, $v->clase_css, $n, $v->es_requerido, $v->es_readonly);
                    break;
                case 'file':
                    $accept="image/jpeg, image/jpg, image/png, image/gif";
                    $componentes .= $h_ctrl->simplyFileChooser($v->id_css, $v->caption, '', $v->tipo, null, $v->custom_css, $v->clase_css, $h_ctrl->grid4(), $v->es_requerido, $v->es_readonly, $accept);
                    break;
                case 'file-pdf':
                    $accept="application/pdf";
                    $tipo = "file";
                    $componentes .= $h_ctrl->simplyFileChooser($v->id_css, $v->caption, '', $tipo, null, $v->custom_css, $v->clase_css, $h_ctrl->grid4(), $v->es_requerido, $v->es_readonly, $accept);
                    break;
                case 'textarea':
                    $componentes .= $h_ctrl->Textarea($v->id_css, $v->caption, '', 'height:200px;', $v->clase_css, $h_ctrl->grid12());
                    break;
                case 'ckeditor':
                    $componentes .= $h_ctrl->CKEditor($v->id_css, $h_ctrl->grid12());
                    break;
                case 'select':
                case 'select_choose':
                    $origen = explode(":", $v->origen);
                    $opciones = array();
                    $n =$h_ctrl->grid4();
                    switch ($origen[0]) {
                        case 'db':
                            $query = "";
                            switch ($origen[1]) {
                            case 'auth_usuarios':
                                $query = "SELECT * FROM " . $origen[1] . " a WHERE inactivo = 0;";
                            break;
                            default:
                                $query = "SELECT *
                                            FROM " . $origen[1] . " a
                                            WHERE inactivo = 0
                                                AND FN_JSON_VERIFY_DATA(a.acceso, " . $perfil . ", '$.perfil') = 'VERDADERO'
                                                AND FN_JSON_VERIFY_DATA(a.acceso, " . $usuario . ", '$.usuarios') = 'FALSO';";
                            break;
                            }
                            $data = DB::select($query);
                            foreach ($data as $val) {
                                $value = "";
                                $text = "";
                                $value = $val->id;
                                switch ($origen[1]) {
                                    case 'auth_tipos_id':
                                        $text = $val->codigo . " - " . $val->nombre;
                                        break;

                                    case 'geo_countries':
                                    case 'geo_cities':
                                    case 'geo_states':
                                        $text = strtoupper($val->name);
                                        break;
                                    case 'auth_empresas':
                                        $text = strtoupper($val->nit . " - " . $val->razon_social);
                                        break;
                                    case 'logic_congregaciones':
                                    case 'logic_concilios':
                                    case 'logic_ministerios':
                                    case 'logic_segmentos':
                                    case 'logic_tipos_actividades':
                                    case 'logic_actividades':
                                    case 'auth_perfiles':
                                    case 'logic_requisitos':
                                    case 'config_estados':
                                        $text = strtoupper($val->nombre);
                                        break;
                                    case 'auth_usuarios':
                                        $text = strtoupper($val->identificacion. " - " . $val->nombre1. " " . $val->apellido1. " " . $val->apellido2);
                                    break;
                                    case 'logic_notificaciones':
                                        $text = "ID: ".$val->id." :: ".$val->nombre." :: TAG: ".$val->categoria;
                                        break;
                                }
                                array_push($opciones, array('VALUE' => $value, 'TEXTO' => $text));
                            }
                        break;
                        case 'val':
                            $options = explode(',',$origen[1]);
                            foreach($options as $val){
                                array_push($opciones, array('VALUE' => $val, 'TEXTO' => $val));
                            }
                        break;
                        case 'query':
                            $query = explode(',',$origen[1])[0];
                            switch($query){
                                case 'seguimiento_becados':
                                    $rol = session()->get('app_idrol');
                                    $query = "";
                                    switch($rol){
                                        case 1:
                                        case 5:
                                            $query = 'SELECT * FROM auth_usuarios c WHERE c.inactivo = 0 AND c.id_perfil = 3';
                                            break;
                                        case 3:
                                            $usuario = session()->get('app_idusuario');
                                            $query = 'SELECT * FROM auth_usuarios c WHERE c.inactivo = 0 AND c.id = '.$usuario;
                                            break;
                                    }
                                    $data = DB::select($query);
                                    foreach($data as $val){
                                        $value = $val->id;
                                        $text = ":: ".$val->identificacion." :: ".$val->nombre1." ".$val->apellido1." ".$val->apellido2;
                                        array_push($opciones, array('VALUE' => $value, 'TEXTO' => $text));
                                    }
                                    break;
                            }

                            break;
                        case 'val_range':
                            $options = explode(',',$origen[1]);
                            $options = explode('-',$options[0]);
                            $final = $options[1] == 'CURRENT_YEAR'?intval(date('Y')):$options[1];
                            $cantidad = intval($final) - intval($options[0]);
                            for($i = 1; $i <= $cantidad ; $i++){
                                $val =  intval($options[0])+$i;
                                array_push($opciones, array('VALUE' => $val, 'TEXTO' => $val));
                            }
                        break;
                    }
                    if(trim($v->tipo) == 'select_choose'){
                        $componentes .= $h_ctrl->jSelectMultiple($v->id_css, $v->caption, $opciones, $v->clase_css, $n, '', 'Buscar');
                    }else{
                        if($v->etiqueta == 'auth_usuarios_complementarios' && strlen($v->caption) >= 23){
                            $n =$h_ctrl->grid12();
                        }
                        $componentes .= $h_ctrl->jSelect($v->id_css, $v->caption, $opciones, $v->clase_css, $n, '', 'Buscar');
                    }

                    break;
                case 'submit':
                    $componentes .= $h_ctrl->Submit($v->id_css, $v->caption, $v->tipo, $v->clase_css, $v->custom_css, $v->js, '', $v->icono, false);
                    break;
                case 'button':
                    $componentes .= $h_ctrl->Button($v->id_css, $v->caption, $v->tipo, $v->clase_css, $v->custom_css, $h_ctrl->grid5(), $v->js, '', $v->icono, false);
                    break;
                case 'upload':
                    $accept="application/pdf";
                    $componentes .= $h_ctrl->jFile($v->id_css, $h_ctrl->grid12(), $accept, '');
                    break;
                case 'datetime':
                    $componentes .= $h_ctrl->jDateTimefield($v->id_css, $v->caption, '', $v->tipo, '', '', $v->clase_css, $h_ctrl->grid2(), $v->es_requerido, $v->es_readonly);
                    break;
                case 'time':
                    $componentes .= $h_ctrl->jTimefield($v->id_css, $v->caption, '', $v->tipo, '', '', $v->clase_css, $h_ctrl->grid2(), $v->es_requerido, $v->es_readonly);
                    break;
                case 'hidden':
                    switch($v->id_css){
                        case 'hdnView':
                            $componentes .= $h_ctrl->Input($v->id_css, $v->origen, $v->clase_css, '', $v->tipo);
                            break;
                        default:
                            $componentes .= $h_ctrl->Input($v->id_css, '', $v->clase_css, '', $v->tipo);
                            break;
                    }
                    break;
                default:
                    $componentes .="No existe componente ".$v->tipo;
                break;
            }
        }
        /*$componentes .= "<script type='text/javascript'>
                                function dataChange(el){
                                    console.log(el);
                                }
                        </script>";*/
        return $componentes;
    }

}
