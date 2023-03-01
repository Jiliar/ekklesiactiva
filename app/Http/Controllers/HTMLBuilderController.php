<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;

class HTMLBuilderController{

    public function grid1(){return array('sm'=>12, 'md'=>12, 'lg'=>4, 'xl'=>3, 'xxl'=>3);}
    public function grid2_(){return array('sm'=>12, 'md'=>12, 'lg'=>3, 'xl'=>2, 'xxl'=>2);}
    public function grid2(){return array('sm'=>12, 'md'=>12, 'lg'=>6, 'xl'=>6, 'xxl'=>6);}
    public function grid4(){return array('sm'=>12, 'md'=>12, 'lg'=>4, 'xl'=>4, 'xxl'=>4);}
    public function grid5(){return array('sm'=>3, 'md'=>2, 'lg'=>1, 'xl'=>1, 'xxl'=>1);}
    public function grid8(){return array('sm'=>12, 'md'=>12, 'lg'=>8, 'xl'=>8, 'xxl'=>8);}
    public function grid9(){return array('sm'=>12, 'md'=>12, 'lg'=>9, 'xl'=>9, 'xxl'=>9);}
    public function grid10(){return array('sm'=>12, 'md'=>12, 'lg'=>10, 'xl'=>10, 'xxl'=>10);}
    public function grid12(){return array('sm'=>12, 'md'=>12, 'lg'=>12, 'xl'=>12, 'xxl'=>12);}

    public function JS(){
        $html ='
        <script src="'.asset('js/funciones.js').'"></script>
        <script src="'.asset('vendors/chartjs/Chart.bundle.min.js').'"></script>
        <script src="'.asset('vendors/qrcode/qrcode.min.js').'"></script>
        <script src="'.asset('vendors/jsbarcode/JsBarcode.all.min.js').'"></script>
        <script src="'.asset('vendors/ckeditor/ckeditor.js').'"></script>
        <script src="'.asset('vendors/metro4/js/metro.min.js').'"></script>
        <script src="'.asset('js/index.js').'"></script>';
        return $html;
    }
    public function BodyHTML($contenido){
        $html ='<!DOCTYPE html>
        <html lang="en" class=" scrollbar-type-1 sb-darkGray">
        <head>
            <meta charset="utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
            <link rel="stylesheet" href="'.asset('vendors/metro4/css/metro-all.min.css').'">
            <link rel="stylesheet" href="'.asset('css/index.css').'">
            <link rel="shortcut icon" href="'.asset('imagenes/logo.png').'">
            <script src="'.asset('jquery.js').'"></script>
            <script src="'.asset('jquery.min.js').'"></script>
            <script src="'.asset('js/funciones.js').'"></script>
            <script>window.on_page_functions = [];</script>
            <script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>
            <script src="//cdn.jsdelivr.net/npm/promise-polyfill@8/dist/polyfill.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/jquery.validate.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/additional-methods.min.js"></script>
        </head>
        '.$contenido.'
        '.$this->JS().'
        </html>';
        return $html;
    }

    public function Textfield($id, $label, $value, $type='text', $placeholder=null, $style=null, $class='', $n){

        $cells = "";
        if($n != null){
            $cells = "cell-sm-".$n['sm']." cell-md-".$n['md']." cell-lg-".$n['lg']." cell-xl-".$n['xl']." cell-xxl-".$n['xxl'];
        }

        $html = "<div class='$cells texts' id='container-".$id."'>";
        $html .= "<div class='form-group components'>";
        $html .= "<label>".$label."</label>";
        $html .= "<input type='".$type."' class='".$class." form-control' name='".$id."' id='".$id."' autocomplete='off' placeholder='".$placeholder."' value='".$value."' style='".$style."'/>";
        $html .= "</div></div>";
        return $html;
    }

    public function jTextfield($id, $label, $value, $type='text', $placeholder=null, $style=null, $class='', $n, $is_required= '', $is_readonly=''){

        $cells = $n != null? "cell-sm-".$n['sm']." cell-md-".$n['md']." cell-lg-".$n['lg']." cell-xl-".$n['xl']." cell-xxl-".$n['xxl']:"";
        $required = $is_required == 1?"required":"";
        $readonly = $is_readonly == 1?"readonly":"";
        $html = "<div class='$cells texts' id='container-".$id."'>";
        $html .= "<input type='".$type."'data-prepend='$label'  $required $readonly data-role='input' name='".$id."' id='".$id."' autocomplete='off' placeholder='".$placeholder."' value='".$value."' style='".$style."' class='".$class." form-control'/>";
        $html .= "</div>";
        return $html;
    }

    public function simplyFileChooser($id, $label, $value, $type='text', $placeholder=null, $style=null, $class='', $n, $is_required= '', $is_readonly='', $accept){

        $cells = $n != null? "cell-sm-".$n['sm']." cell-md-".$n['md']." cell-lg-".$n['lg']." cell-xl-".$n['xl']." cell-xxl-".$n['xxl']:"";
        $required = $is_required == 1?"required":"";
        $readonly = $is_readonly == 1?"readonly":"";
        $html = "<div class='$cells texts' id='container-".$id."'>";
        $html .= "<input type='".$type."'data-prepend='$label'  $required $readonly data-role='input' name='".$id."' id='".$id."' autocomplete='off' placeholder='".$placeholder."' value='".$value."' style='".$style."' class='".$class." form-control' accept='".$accept."'/>";
        $html .= "</div>";
        return $html;
    }

    public function jFile($id, $n, $accept, $multiple='multiple'){

        $cells = $n != null? "cell-sm-".$n['sm']." cell-md-".$n['md']." cell-lg-".$n['lg']." cell-xl-".$n['xl']." cell-xxl-".$n['xxl']:"";
        $html = "<div class='$cells' id='container-upload'>";
        $html .= "<input type='file' name='".$id."' id='".$id."' data-role='file' data-mode='drop' data-prepend='' accept=".$accept." $multiple />";
        $html .= "</div>";
        return $html;
    }

    public function Input($id, $value, $class='', $style='', $type=''){
        $html = "<div class='form-group texts'>";
        $html .= "<input type='".$type."' class='".$class." form-control' name='".$id."' id='".$id."'  value='".$value."' style='".$style."'/>";
        $html .= "</div>";
        return $html;
    }

    public function jDateTimefield($id, $label, $value, $type='text', $placeholder=null, $style=null, $class='', $n, $is_required= '', $is_readonly=''){
        $cells = $n != null? "cell-sm-".$n['sm']." cell-md-".$n['md']." cell-lg-".$n['lg']." cell-xl-".$n['xl']." cell-xxl-".$n['xxl']:"";
        $required = $is_required == 1?"required":"";
        $readonly = $is_readonly == 1?"readonly":"";
        $html = "<div class='$cells texts' id='container-".$id."'>";
        $html .= "<input type='datetime-local' data-prepend='$label'  $required $readonly data-role='input' name='".$id."' id='".$id."' autocomplete='off' placeholder='".$placeholder."' value='".$value."' style='".$style."' class='".$class." form-control'/>";
        $html .= "</div>";
        return $html;
    }

    public function jTimefield($id, $label, $value, $type='text', $placeholder=null, $style=null, $class='', $n, $is_required= '', $is_readonly=''): string
    {
        $cells = $n != null? "cell-sm-".$n['sm']." cell-md-".$n['md']." cell-lg-".$n['lg']." cell-xl-".$n['xl']." cell-xxl-".$n['xxl']:"";
        $required = $is_required == 1?"required":"";
        $readonly = $is_readonly == 1?"readonly":"";
        $html = "<div class='$cells texts' id='container-".$id."'>";
        $html .= "<input type='time' data-prepend='$label'  $required $readonly data-role='input' name='".$id."' id='".$id."' autocomplete='off' placeholder='".$placeholder."' value='".$value."' style='".$style."' class='".$class." form-control'/>";
        $html .= "</div>";
        return $html;
    }


    public function Textarea($id, $label, $value='', $style='', $class='', $n){
        $html = "<div class='cell-sm-".$n['sm']." cell-md-".$n['md']." cell-lg-".$n['lg']." cell-xl-".$n['xl']." cell-xxl-".$n['xxl']."' id='container-".$id."'>";
        $html .= "<div class='form-group texts'>";
        //$html .= "<label>".$label."</label>";
        $html .= "<textarea class='$class form-control' id='".$id."' data-prepend='".$label."' data-role='textarea' style='$style' rows='7' name='".$id."' >".$value."</textarea>";
        $html .= "</div></div>";
        return $html;
    }

    public function CKEditor($id, $n){
        $html = "<div class='cell-sm-".$n['sm']." cell-md-".$n['md']." cell-lg-".$n['lg']." cell-xl-".$n['xl']." cell-xxl-".$n['xxl']."' id='container-".$id."'>";
        $html .= "<textarea class='form-control' id='$id' name='$id' style='width:100% !important;'></textarea>";
        $html .= "<script src='//cdn.ckeditor.com/4.16.2/standard/ckeditor.js'></script>";
        $html .= "<script type='text/javascript'>CKEDITOR.replace('$id');</script>";
        $html .= "</div>";
        return $html;
    }


    public function Checkbox($id, $text, $checked, $class='', $n){
        $html = "<div class='components cell-sm-".$n['sm']." cell-md-".$n['md']." cell-lg-".$n['lg']." cell-xl-".$n['xl']." cell-xxl-".$n['xxl']."'>
                    <input class='".$class."' type='checkbox' id='".$id."' name='".$id."' data-caption='".$text."' '".$checked."'>
                </div>";
        return $html;
    }

    public function jSelect($id, $label, $options, $class='', $n, $value=0, $placeholder='Buscar', $first = true, $style=''){
        $html = "<div class='cell-sm-".$n['sm']." cell-md-".$n['md']." cell-lg-".$n['lg']." cell-xl-".$n['xl']." cell-xxl-".$n['xxl']."' style='".$style."'>";
        //$html .= "<div class='form-group'>";
        //$html .= "<label>".$label."</label>";
        $html .= "<select style='font-size:13px !important;' data-role='select' id='".$id."' name='".$id."' class='$class' placeholder='$placeholder' data-prepend='$label' data-on-change='dataChange'>";
        if($first)
            $html .= "<option value='#' selected>Seleccione Opcion</option>";
        for($i = 0; $i < count($options); $i++){
            $sel="";
            if( $options[$i]['VALUE']==$value){
                $sel=" selected ";
            }
            $html .= "<option value='".$options[$i]['VALUE']."' $sel >".$options[$i]['TEXTO']."</option>";
        }
        $html .= "</select></div>"; //</div>";
        return $html;
    }

    public function Select2($id, $label, $options, $class='', $n, $value=0, $placeholder='Buscar', $first = true){
        $html = "<div class='cell-sm-".$n['sm']." cell-md-".$n['md']." cell-lg-".$n['lg']." cell-xl-".$n['xl']." cell-xxl-".$n['xxl']."'>";
        //$html .= "<div class='form-group'>";
        //$html .= "<label>".$label."</label>";
        $html .= "<select id='".$id."' name='".$id."' class='$class' placeholder='$placeholder' data-on-change='dataChange'>";
        if($first){
            $html .= "<option value='#' selected>Sin Verificar</option>";
        }
        for($i = 0; $i < count($options); $i++){
            $sel="";
            if( $options[$i]['VALUE']==$value){
                $sel=" selected ";
            }
            $html .= "<option value='".$options[$i]['VALUE']."' $sel >".$options[$i]['TEXTO']."</option>";
        }
        $html .= "</select></div>"; //</div>";
        return $html;
    }

    public function jSelectMultiple($id, $label, $options, $class='', $n, $value=0, $placeholder='Buscar'){
        $html = "<div class='cell-sm-".$n['sm']." cell-md-".$n['md']." cell-lg-".$n['lg']." cell-xl-".$n['xl']." cell-xxl-".$n['xxl']."'>";
        $html .='<select id="'.$id.'" name="'.$id.'" class="'.$class.'" data-prepend="'.$label.'" placeholder="'.$placeholder.'" data-role="select"  multiple>';
        $html .='<optgroup label="Habilidades Desarrolladas en la experiencia">';
        for($i = 0; $i < count($options); $i++){
            $sel="";
            if( $options[$i]['VALUE']==$value){
                $sel=" selected ";
            }
            $html .= "<option value='".$options[$i]['VALUE']."' $sel >".$options[$i]['TEXTO']."</option>";
        }
        $html .= "</optgroup></select></div>";
        return $html;
    }

    public function jSelectYesNo($id, $label, $options, $class='', $n, $value=0){
        $html = "<div class='cell-sm-".$n['sm']." cell-md-".$n['md']." cell-lg-".$n['lg']." cell-xl-".$n['xl']." cell-xxl-".$n['xxl']."'>";
        //$html .= "<div class='form-group'>";
        //$html .= "<label>".$label."</label>";
        $html .= "<select data-role='select' id='".$id."' name='".$id."' class='$class' 	data-prepend='$label'>";
        $html .= "<option value='#' selected>Seleccione Opcion</option>";
        $selSI = $selNO = '';
        if($value == 'S') $selSI = 'selected';
        if($value == 'N') $selNO = 'selected';
        $html .= "<option value='S' $selSI >SI</option>";
        $html .= "<option value='N' $selNO >NO</option>";
        $html .= "</select></div>"; //</div>";
        return $html;
    }

    public function Select($id, $label, $options, $class='', $n, $value=0){
        $html = "<div class='cell-sm-".$n['sm']." cell-md-".$n['md']." cell-lg-".$n['lg']." cell-xl-".$n['xl']." cell-xxl-".$n['xxl']."'>";
        $html .= "<div class='form-group'>";
        $html .= "<label>".$label."</label>";
        $html .= "<select data-role='select' id='".$id."' name='".$id."' class='$class'>";
        $html .= "<option value='#' selected>Seleccione Opcion</option>";
        for($i = 0; $i < count($options); $i++){
            $sel="";
            if( $options[$i]->VALUE==$value){
                $sel=" selected ";
            }
            $html .= "<option value='".$options[$i]->VALUE."' $sel>".$options[$i]->TEXTO."</option>";
        }
        $html .= "</select></div></div>";
        return $html;
    }

    public function DatePicker($id, $label, $n, $class=''){
        $html = "<div class='cell-sm-".$n['sm']." cell-md-".$n['md']." cell-lg-".$n['lg']." cell-xl-".$n['xl']." cell-xxl-".$n['xxl']."'>";
        $html .= "<div class='form-group'>";
        $html .= "<label>".$label."</label>";
        $html .= "<input class=\"components ".$class."\" id='".$id."' name='".$id."' data-role='datepicker' data-locale='es-MX'>";
        $html .= "</div></div>";
        return $html;
    }

    public function ButtonJS($id, $text, $type, $class='',$style, $n, $function='', $params=null, $path='', $jidentify= false){
        $html = '';
        $onclick ='';
        if($params != null ){
            $i=1;
            if($jidentify){
                foreach($params as $par){
                    $campos = json_encode($par);
                    $html .= "<input type='hidden' class='jidentify' id='hdn_fields$i' value='$campos' />";
                    $i++;
                }
            }else{
                    $campos = json_encode($params);
                    $html .= "<input type='hidden' id='hdn_fields' value='$campos' />";
                    $i++;
            }


        }
        if($path !='' )
            $html .= "<input type='hidden' id='hdn_path' value='$path' />";

        if($function != '' && $path ==''){
            $onclick ="onclick = $function()";

        }else{
            if($function != '' && $path !='')
                $onclick ="onclick = $function($path)";
        }

        $html .= "<button type='$type' id = '$id' name = '$id' class='$class cell-sm-".$n['sm']." cell-md-".$n['md']." cell-lg-".$n['lg']." cell-xl-".$n['xl']." cell-xxl-".$n['xxl']."' $onclick style='width:100%; $style'>".$text."</button>";
        return $html;
    }


    public function Button($id, $text, $type, $class='',$style, $n, $js, $badge, $icon, $want_badge = true){
        $badge_ = "";
        if($want_badge){
            $badge_ = "<span class='badge'>$badge</span>";
        }
        $html = '';
        $html .= "<button type='$type' id = '$id'  class='$class cell-sm-".$n['sm']." cell-md-".$n['md']." cell-lg-".$n['lg']." cell-xl-".$n['xl']." cell-xxl-".$n['xxl']."' onclick=\"$js\" style='width:100%; $style'>";
        $html .= $badge_;
        $html .= "<span class='caption'>$text</span>";
        $html .= "<span class='$icon'></span>";
        $html .= "</button>";
        return $html;
    }

    public function Submit($id, $text, $type, $class='',$style, $js, $badge, $icon, $want_badge = true){
        $badge_ = "";
        if($want_badge){
            $badge_ = "<span class='badge'>$badge</span>";
        }
        $html = '';
        $html .= "<button type='$type' id = '$id'  class='$class' onclick=\"$js\" style='width:8%; $style'>";
        $html .= $badge_;
        $html .= "<span class='caption'>$text</span>";
        $html .= "<span class='$icon'></span>";
        $html .= "</button>";
        return $html;
    }

    public function Accordion($titulos, $contenido, $open=true, $id='panel'){
        $opened = $open?'frame active':'frame';
        $display =  $open?'display: block;':'display:none;';
        $heading_style = $open?'bg-white fg-red':'';
        $content_style = $open?'bg-white fg-black':'';
        $html = "<div  data-role='accordion' data-active-heading-class='bg-white fg-red' data-active-content-class='bg-white fg-black' data-one-frame='$open' data-show-active='$open' >";
                    for($i = 0; $i < count($titulos); $i++){
                        $html .= "<div id='$id'_$i class='$opened'><div class='heading $heading_style' style='font-weight:bold;'>".$titulos[$i]."</div><div class='content $content_style' style='$display'><div class='p-2'>".$contenido[$i]."</div></div></div>";
                    }
        $html.="</div>";
        if($open)
            $html.='<script type="text/javascript">$(document).ready(function(){$("#'.$id.' .content").attr("style","display:block !important;")}); sortButtons();</script>';
        return $html;
    }

    public function Div($id, $class='', $contenido='', $style='', $n){
        $cells = "";
        if($n != null){
            $cells = "cell-sm-".$n['sm']." cell-md-".$n['md']." cell-lg-".$n['lg']." cell-xl-".$n['xl']." cell-xxl-".$n['xxl'];
        }
        $html = "<div id='$id' class='$class $cells' style='$style'>";
        $html .= $contenido;
        $html.="</div>";
        return $html;
    }

    //Funcion para generar Tablas
    // - PARAMENTROS:
    // -- $head = indices de la tabla
    // -- $keys = datos que desea mostrar del Response elaborado
    // -- $data = datos a visualizar en la tabla
    // -- $id = Identificador de la tabla
    // -- $class = clase para definir propiedades de la tabla
    // -- $th_style = variable para manejo de estilos de los indices de la tabla
    // -- $td_style = variable para manejo de estilos de las columnas de la tabla
    // -- $table_style = variable para manejo de estilos de la tabla en general
    // -- $count_row = variable para indicar si la tabla debe visualizar conteo de filas

    public function TableLaravel($head, $keys, $data, $id, $class, $th_style='', $td_style='', $table_style='', $count_row=false, $download=false, $name='Reporte'){

        $th= ""; $tr = ""; $count_th = ""; $count_td = "";
        if($count_row)
            $count_th = "<th style='text-align:center; $th_style'>N～</th>";

        foreach($head as $val)
            $th .= "<th style='$th_style'>".$val."</th>";
        $thead = "<thead><tr>$count_th $th</tr></thead>";

        $pos = $pos = ($data->perPage() * $data->currentPage())-($data->perPage()-1);
        foreach($data as $val){
            $array = json_decode(json_encode($val), true);
            $td = "";
            for($i=0; $i < count($keys); $i ++){
                $td .= "<td style='".$td_style[$keys[$i]]."'>".$array[$keys[$i]]."</td>";
            }
            if($count_row)
                $count_th = "<td style='text-align:center;'>$pos</td>";
            $tr.="<tr>$count_th $td</tr>";
            $pos++;
        }
        $tbody = "<tbody>$tr</tbody>";
        $html = "<table class='$class' id='$id' style='$table_style'
        data-role='table'
        data-cls-component='mt-10'
        data-rows='10
        data-source='./table-big.json'
        data-pagination='true'
        data-show-all-pages='false'
        data-on-data-loaded='$('#activity').remove()'>";
        $html .= $thead;
        $html .= $tbody;
        $html .= "</table>";
        $aux = "";
        if($download){
            $button = $this->ButtonJS('btn_exportar', 'Exportar', 'button', 'export button success', 'float: right;',$this->grid1(), "exportingDataApi('".$name."','".$data."')");
            $aux .= $this->Div('footer-container-1', '', $data->links(), 'padding-top: 10px;', $this->grid2());
            $aux .= $this->Div('footer-container-2 float-right', '',$button, '', $this->grid2());
        }else{
            $aux = $this->Div('footer-pags-1', '', $data->links(), 'text-align:right;', $this->grid12());
        }
        $html .= $this->Row('rowfooter-container', $aux, 'margin: 10px 10px 30px 10px;');


        return $html;
    }

    public function DataTable($data, $type='radio'){
        $keys = array();
        $info = array();
        $information = array();
        $pos = 0;
        foreach($data as $value){
                foreach($value as $key=>$val){
                    $key = trim($key);
                    $val = trim($val);
                    if( (strpos($key, '_at') === false
                        && strpos($key, 'imagen') === false
                        && strpos($key, 'acceso') === false
                        && strpos($key, 'usuario_r') === false
                        && strpos($key, 'token') === false
                        && strpos($key, 'contenido') === false
                        && strpos($key, 'usuario_a') === false
                        && strpos($key, 'menu_subitems') === false
                        && strpos($key, 'requisitos_aprobados') === false
                        && strpos($key, 'requisitos_faltantes') === false
                        && strpos($key, 'descripcion_exp') === false
                        && strpos($key, 'puntaje_evaluaciones') === false
                        && strpos($key, 'evaluaciones_realizadas') === false
                        && strpos($key, 'descripcion_convocatoria') === false
                        && strpos($key, 'descripcion_emprendimiento') === false
                        && strpos($key, 'descripcion_men') === false
                        && strpos($key, 'usuario_e') === false
                        && strpos($key, 'usuario_cv') === false
                        && strpos($key, 'pass') === false)){
                        //print_r($key." : ".$val."\n");
                        if($val!='#' && $val!=null){
                        switch($key){
                            case 'inactivo':
                                $sql = "SELECT * FROM config_estados a where a.id = ".$val;
                                $response =  DB::select($sql);
                                $val = count($response) > 0 ? strtoupper($response[0]->nombre) : "ESTADO NO DEFINIDA";
                            break;
                            case 'ciudad':
                                $sql = "SELECT * FROM geo_cities a where a.id = ".$val;
                                $response =  DB::select($sql);
                                $val = count($response) > 0 ? strtoupper($response[0]->name) : "CIUDAD NO DEFINIDA";
                            break;
                            case 'pais':
                                $sql = "SELECT * FROM geo_countries a where a.id = ".$val;
                                $response =  DB::select($sql);
                                $val = count($response) > 0 ? strtoupper($response[0]->name) : "PAÍS NO DEFINIDO";
                            break;
                            case 'region':
                                $sql = "SELECT * FROM geo_states a where a.id = ".$val;
                                $response =  DB::select($sql);
                                $val = count($response) > 0 ? strtoupper($response[0]->name) : "REGIÓN NO DEFINIDA";
                            break;
                            case 'id_empresa':
                                $sql = "SELECT * FROM auth_empresas a where a.id = ".$val;
                                $response =  DB::select($sql);
                                $val = count($response) > 0 ? strtoupper($response[0]->razon_social) : "EMPRESA NO DEFINIDA";
                            break;
                            case 'id_perfil':
                                $sql = "SELECT * FROM auth_perfiles a where a.id = ".$val;
                                $response =  DB::select($sql);
                                $val = count($response) > 0 ? strtoupper($response[0]->nombre) : "PERFIL NO DEFINIDO";
                            break;
                            case 'tipo_id':
                                $sql = "SELECT * FROM auth_tipos_id a where a.id = ".$val;
                                $response =  DB::select($sql);
                                $val = count($response) > 0 ? strtoupper($response[0]->codigo) : "TIPO ID NO DEFINIDO";
                            break;
                            case 'tipo_doc':
                                $sql = "SELECT * FROM logic_tipo_documentos a where a.id = ".$val;
                                $response =  DB::select($sql);
                                $val = count($response) > 0 ? strtoupper($response[0]->nombre) : "TIPO DOC NO DEFINIDO";
                            break;
                            case 'usuarioevaluado':
                            case 'usuario_carga':
                            case 'registrado_por':
                            case 'id_usuario':
                                $sql = "SELECT * FROM auth_usuarios a where a.id = ".$val;
                                $response =  DB::select($sql);
                                $val = count($response) > 0 ? strtoupper($response[0]->nombre1." ".$response[0]->apellido1." ".$response[0]->apellido2) : "USUARIO NO DEFINIDO";
                            break;
                            case 'user_create':
                                    $sql = "SELECT * FROM auth_usuarios a where a.id = ".$val;
                                    $response =  DB::select($sql);
                                    $val = count($response) > 0 ? substr(strtoupper($response[0]->nombre1),0,1).strtoupper($response[0]->apellido1): "USUARIO NO DEFINIDO";
                            break;
                            case 'tipo_actividad':
                                $sql = "SELECT * FROM logic_tipos_actividades a where a.id = ".$val;
                                $response =  DB::select($sql);
                                $val = count($response) > 0 ? $response[0]->nombre : "TIPO ACTIVIDAD NO DEFINIDA";
                            break;
                            case 'id_concilio':
                                $sql = 'SELECT c.nombre FROM logic_concilios c WHERE c.id = '.$val;
                                $response =  DB::select($sql);
                                $val = count($response) > 0 ? $response[0]->nombre : "CONCILIO NO DEFINIDA";
                                break;
                            case 'id_actividad':
                                $sql = 'SELECT c.nombre FROM logic_actividades c WHERE c.id = '.$val;
                                $response =  DB::select($sql);
                                $val = count($response) > 0 ? $response[0]->nombre : "ACTIVIDAD NO DEFINIDA";
                                break;
                            case 'id_segmento':
                                $sql = 'SELECT c.nombre FROM logic_segmentos c WHERE c.id = '.$val;
                                $response =  DB::select($sql);
                                $val = count($response) > 0 ? $response[0]->nombre : "SEGMENTO NO DEFINIDO";
                                break;
                            case 'id_congregacion':
                            case 'congregacion':
                                $sql = 'SELECT c.nombre FROM logic_congregaciones c WHERE c.id = '.$val;
                                $response =  DB::select($sql);
                                $val = count($response) > 0 ? $response[0]->nombre : "CONGRAGACIÓN NO DEFINIDA";
                            break;
                        }
                    }else{
                        $val = "<span style='font-size:12px; font-weight:bold;'>NO DEFINIDO</span>";
                    }
                    $keys[$pos] = str_replace('_',' ',strtoupper($key));
                    $info[$key] = $val != null || trim($val) != ""?$val:'NO REGISTRA';
                    $pos++;
                }
            }
            array_push($information,$info);
        }

        $keys = array_unique($keys);
        $thead = "<thead><tr>";
        foreach($keys as $key){
            $key = strtoupper($key) == 'INACTIVO'?'ESTADO':$key;
            $key = strtoupper($key) == 'ID EMPRESA'?'EMPRESA':$key;
            $key = strtoupper($key) == 'ID PERFIL'?'ROL':$key;
            $key = strtoupper($key) == 'ID CATEGORIAC'?'CATEGORIA':$key;
            $key = strtoupper($key) == 'ID USUARIO'?'USUARIO':$key;
            $key = strtoupper($key) == 'ID ETIQUETA'?'ETIQUETA':$key;
            $key = strtoupper($key) == 'ULTIMOINGRESO'?'ULT. INGRESO':$key;
            $key = strtoupper($key) == 'ID CLIENTE'?'CLIENTE':$key;
            $key = strtoupper($key) == 'ID CENTRO COSTO'?'CENTRO DE COSTO':$key;
            $key = strtoupper($key) == 'ID SUBCENTRO COSTO'?'SUBCENTRO DE COSTO':$key;
            $key = strtoupper($key) == 'ID CENTRO OPERACIONES'?'CENTRO OPERACIONES':$key;
            $key = strtoupper($key) == 'ID UNIDAD ESTRAGICA NEGOCIO'?'UNIDAD ESTRATEGICA DE NEGOCIO':$key;
            $key = strtoupper($key) == 'ID PRODUCTOC'?'PRODUCTO':$key;
            $key = strtoupper($key) == 'ID PORCENTAJEC'?'VALOR':$key;
            $key = strtoupper($key) == 'ID PRODUCTO'?'PRODUCTO':$key;
            $key = strtoupper($key) == 'ID PEDIDO'?'PEDIDO':$key;
            $key = strtoupper($key) == 'ID SUBCUENTA'?'SUBCUENTA':$key;
            $key = strtoupper($key) == 'ID ESTADO FACTURA'?'ESTADO FACTURA':$key;
            $key = strtoupper($key) == 'ID FACTURA VENTA'?'FACTURA VENTA':$key;
            $key = strtoupper($key) == 'ID PRODUCTOV'?'PRODUCTO':$key;
            $key = strtoupper($key) == 'ID FACTURAV'?'FACTURA VENTA':$key;
            $key = strtoupper($key) == 'ID PROVEEDOR'?'PROVEEDOR':$key;
            $key = strtoupper($key) == 'ID ORDEN COMPRA'?'ORDEN COMPRA':$key;
            $key = strtoupper($key) == 'ID FACTURA COMPRA'?'FACTURA COMPRA':$key;
            $key = strtoupper($key) == 'ID FACTURAC'?'FACTURA COMPRA':$key;
            $key = strtoupper($key) == 'ID PUC'?'PLAN UNICO DE CUENTA':$key;
            $key = strtoupper($key) == 'ID CLASE'?'CLASE':$key;
            $key = strtoupper($key) == 'ID GRUPO'?'GRUPO':$key;
            $key = strtoupper($key) == 'ID CUENTA'?'CUENTA':$key;
            $key = strtoupper($key) == 'NOMBRE1'?'PRIMER NOMBRE':$key;
            $key = strtoupper($key) == 'NOMBRE2'?'SEGUNDO NOMBRE':$key;
            $key = strtoupper($key) == 'APELLIDO1'?'PRIMER APELLIDO':$key;
            $key = strtoupper($key) == 'APELLIDO2'?'SEGUNDO APELLIDO':$key;
            $key = strtoupper($key) == 'TIPO ID'?'TIPO IDENTIFICACION':$key;
            $key = strpos($key, " EXP") > 0?str_replace(' EXP','',$key):$key;
            $key = strpos($key, " EDU") > 0?str_replace(' EDU','',$key):$key;
            $key = strpos($key, " MEN") > 0?str_replace(' MEN','',$key):$key;
            $key = strtoupper($key) == 'ANIO'?'AÑO':$key;
            $thead .= "<th style='text-align:center !important;'>$key</th>";
        }
        $thead .= "</tr></thead>";
        $tbody = "<tbody>";
        foreach($information as $value){
            $tbody .= "<tr>";
                foreach($value as $val){
                    if(strpos($val, 'http') === false)
                        $tbody .= "<td tyle='text-align:center !important;'>$val</td>";
                    else
                        $tbody .= "<td style='text-align:center !important;'><a style='color:black !important;' href='$val' target='_blank'>
                                    <button class='button success square small outline' style='background: #ffffff !important;'>
                                        <span class='mif-attachment'></span>
                                    </button>
                                    </td>";
                }
            $tbody .= "</tr>";
        }
        $tbody .= "</tbody>";

        $id = 'detalle-registros';
        $html = "<table class='table subcompact row-hover striped' id='$id'
        data-role='table'
        data-rows='10'
        data-rows-steps='5, 10, 15, 20, 25, 30,100, 200, 500, 1000'
        data-show-activity='false'
        data-rownum='true'
        data-check='true'
        data-check-col-index='0'
        data-check-type='$type'
        data-horizontal-scroll='true'
        data-check-style='2'>
                    $thead
                    $tbody
                </table>";

        //$html .= $this->TableFunctions($id);
    return $html;
    }

    public function dataTableOrg($data, $type='radio'){
        $keys = array();
        $information = array();
        $pos = 0;
        foreach($data as $value){
            foreach($value as $key=>$val){
                $keys[$pos]=$key;
                $pos++;
            }
            break;
        }

            $thead = "<thead><tr>";
            foreach($keys as $key){
                $key = strtoupper($key) == 'INACTIVO'?'ESTADO':$key;
                $key = strtoupper($key) == 'ES_VERIFICABLE'?'¿ES VERIFICABLE?':$key;
                $key = strtoupper($key) == 'NECESITA_ADJUNTO'?'¿NECESITA ADJUNTO?':$key;
                $key = strtoupper($key) == 'CUMPLE'?'¿CUMPLE?':$key;
                $thead .= "<th style='text-align:center !important;'>$key</th>";
            }
            $thead .= "</tr></thead>";

            $tbody = "<tbody>";
            foreach($data as $value){
                $tbody .= "<tr>";
                    foreach($value as $val){
                        $css = "";
                        if($val == 'OBLIGATORIO'){
                            $css = 'background: yellow !important; font-weight:bold !important;';
                        }
                        if(strpos($val, 'http') === false){
                            $tbody .= "<td style='text-align:center !important; $css'>$val</td>";
                        }else{
                            $tbody .= "<td style='text-align:center !important; $css'><a style='color:black !important;' href='$val' target='_blank'>
                                        <button class='button success square small outline' style='background: #ffffff !important;'>
                                            <span class='mif-attachment'></span>
                                        </button>
                                        </td>";
                                    }
                    }
                $tbody .= "</tr>";
            }
            $tbody .= "</tbody>";
            $check_style = $type == 'radio'?2:1;
            $id = 'detalle-registros';
            $html = "<table class='table subcompact row-hover striped' id='$id'
            data-role='table'
            data-rows='5'
            data-rows-steps='5, 10, 15, 20, 25, 30'
            data-show-activity='false'
            data-rownum='true'
            data-check-col-index='0'
            data-check-type=\"$type\"
            data-horizontal-scroll='true'
            data-check-style='$check_style'>
                        $thead
                        $tbody
                    </table>";
        return $html;
    }

    public function Dialog($id, $titulo, $contenido){
        $html = '<div class="dialog" data-width="1000" data-close-button="true" data-role="dialog" id="'.$id.'">
                    <div class="dialog-title">'.$titulo.'</div>
                    <div class="dialog-content">
                        <div class="dialog-content-details">fsdfsdf
                        '.$contenido.'
                        </div>
                    </div>
                </div>';
        return $html;
    }

    public function TableFunctions($id){
        $html ="<script type='text/javascript'>
        $(document).ready(function() {
            $('#$id').DataTable({
             'columnDefs': [{
              'targets': 0
             }],
             language: {
              'sProcessing': 'Procesando...',
              'sLengthMenu': 'Mostrar _MENU_ resultados',
              'sZeroRecords': 'No se encontraron resultados',
              'sEmptyTable': 'Ningún dato disponible en esta tabla',
              'sInfo': 'Mostrando resultados _START_-_END_ de  _TOTAL_',
              'sInfoEmpty': 'Mostrando resultados del 0 al 0 de un total de 0 registros',
              'sInfoFiltered': '(filtrado de un total de _MAX_ registros)',
              'sSearch': 'Buscar:',
              'sLoadingRecords': 'Cargando...',
              'oPaginate': {
               'sFirst': 'Primero',
               'sLast': 'Último',
               'sNext': 'Siguiente',
               'sPrevious': 'Anterior'
              },
             }
            });
           });
           </script>";
        return $html;
    }

    public function TableArray($head, $keys, $data, $id, $class, $th_style='', $td_style='', $buttons = false, $table_style='', $download=false, $name='Reporte', $funcion='', $mostrarEliminar=''){

        $html= ""; $th= ""; $tr = ""; $count_td = "";
        $jclass="class='d-none'";

        foreach($head as $val){
            $jclass = "";
            if(str_contains($val,"ID_") ){
                $jclass='data-show="false"';
            }

            $th .= "<th $jclass style='$th_style'>".$val."</th>";
        }



        if($funcion!=""){
            switch($funcion){
                case "EliminarDoc": $th .= "<th style='$th_style'>ELIMINAR</th>"; break;
            }
        }
        $thead = "<thead><tr>$th</tr></thead>";


       /*foreach($data as $val){
            $array = json_decode(json_encode($val), true);
            $td = "";
            for($i=0; $i < count($keys); $i ++){
                $td .= "<td style='".$td_style[$keys[$i]]."'>".$array[$keys[$i]]."</td>";
            }
            $tr.="<tr>$td</tr>";
        }*/

        $pos =0;
        $puntos=null;

        if($data != null){

            foreach($data as $val){
                foreach($val as $item){
                    $td = "";
                    //MOSTRAR SOLOLS COLUMNAS REFERENCIADAS
                    for($i=0; $i < count($keys); $i ++){
                        if($keys[$i]=="ruta" || $keys[$i]=="RUTA"){
                            $td .= "<td style=''><a href='".$item->{$keys[$i]}."' target='_blank' >Ver Documento<span class='fa fa-book'></span></a></td>";
                        }else{
                            $td .= "<td style=''>".$item->{$keys[$i]}."</td>";
                        }
                    }
                    if($funcion!=""){
                        switch($funcion){
                            case "EliminarDoc":
                                  $td .= "<td style='$th_style'><a $mostrarEliminar href='#' onclick='javascript:$funcion(this,".$item->id.")'>Eliminar</a></td>";
                                break;
                        }

                    }
                    $tr.="<tr>$td</tr>";
                    $pos++;
                }

            }
        }

        $tbody = "<tbody>$tr</tbody>";


        if($buttons){

            $html = "<div class='text-center'>";
           // $html .= "<button class='button' onclick=\"$('#$id').data('table').loadData('".$json."')\" style='margin-left:10px;'>Cargar datos</button>";
            $html .= "<button class='button' onclick=\"$('#$id').data('table').prev()\" style='margin-left:10px;'>Anterior</button>";
            $html .= "<button class='button' onclick=\"$('#$id').data('table').next()\" style='margin-left:10px;'>Siguiente</button>";
            $html .= "<button class='button' onclick=\"$('#$id').data('table').first()\" style='margin-left:10px;'>Primero</button>";
            $html .= "<button class='button' onclick=\"$('#$id').data('table').last()\" style='margin-left:10px;'>Ultimo</button>";
            $html .= "<a onclick=\"$('#$id').data('table').toggleInspector()\" class=\"button ml-1\" style='margin-left:120px;'><span class=\"mif-cog\"></span></a>";
            $html .= "</div>";

        }

        $html .= "<table class='$class' id='$id' style='$table_style'
        data-role='table'
        data-cls-component='mt-10'
        data-rows='50'
        data-pagination='true'
        data-horizontal-scroll='true'
        data-table-search-title='Buscar:'
        data-table-rows-count-title= 'Pagina'
        data-all-records-title='Todos los registros'
        data-show-all-pages='false'
        data-rows-steps='-1, 10, 20, 50, 100'
        data-info-wrapper='#table-info'
        data-rows-wrapper='#rows-count'
        data-view-save-mode='client'
        data-view-save-path='TABLE:".$id.":KEYS'
        data-on-data-loaded='$('#activity').remove()'>";
        $html .= $thead;
        $html .= $tbody;
        $html .= "</table>";
        $aux = "";
        if($download){
            $button = $this->ButtonJS('btn_exportar', 'Exportar', 'button', 'button success', 'float: right;',$this->grid1(), "exportingDataApi('".$name."','".$data."')");
            $aux .= $this->Div('footer-container-1', '', '', 'padding-top: 10px;', $this->grid2());
            $aux .= $this->Div('footer-container-2 float-right', '',$button, '', $this->grid2());

        }else{
            $aux = $this->Div('footer-pags-1', '', '', 'text-align:right;', $this->grid12());
        }
        $html .= $this->Row('rowfooter-container', $aux, 'margin: 10px 10px 30px 10px;');


        return $html;
    }

    public function TableJson($json, $id, $class, $table_style='', $download=false, $name='Reporte', $buttons = false, $check = false,  $check_function=""){

        $html= ""; $th= ""; $tr = ""; $count_td = "";

        if($buttons){

            $html = "<div class='text-center'>";
            $html .= "<button class='button' onclick=\"$('#$id').data('table').loadData('".$json."')\" style='margin-left:10px;'>Cargar datos</button>";
            $html .= "<button class='button' onclick=\"$('#$id').data('table').prev()\" style='margin-left:10px;'>Anterior</button>";
            $html .= "<button class='button' onclick=\"$('#$id').data('table').next()\" style='margin-left:10px;'>Siguiente</button>";
            $html .= "<button class='button' onclick=\"$('#$id').data('table').first()\" style='margin-left:10px;'>Primero</button>";
            $html .= "<button class='button' onclick=\"$('#$id').data('table').last()\" style='margin-left:10px;'>Ultimo</button>";
            $html .= "<a onclick=\"$('#$id').data('table').toggleInspector()\" class=\"button ml-1\" style='margin-left:120px;'><span class=\"mif-cog\"></span></a>";
            $html .= "</div>";

        }

        $check_mode = $check?"data-check='true' data-check-col-index='0' data-check-type='radio'":"";

        $html .= "<table class='$class' id='$id' style='$table_style'
        data-role='table'
        data-cls-component='mt-10'
        data-rows='10'
        data-source='".$json."'
        data-pagination='true'
        data-horizontal-scroll='true'
        data-table-search-title='Buscar:'
        data-table-rows-count-title= 'Pagina'
        data-all-records-title='Todos los registros'
        data-show-all-pages='false'
        data-rows-steps='-1, 10, 20, 50, 100'
        data-info-wrapper='#table-info'
        data-rows-wrapper='#rows-count'
        data-view-save-mode='client'
        data-check-style = 1
        data-cls-body-row = 'row-class'
        $check_mode";
        if($check_function!=null){
            $html .= "data-on-check-click='$check_function'";
        }
        $html .= "data-view-save-path='TABLE:".$id.":KEYS'
        data-on-data-loaded='$(\"#activity\").remove()'>";
        $html .= "</table>";
        $aux = "";
        if($download){
            $name = strtoupper(str_replace(" ","_",$name));
            $button = $this->ButtonJS('btn_exportar', 'Exportar', 'button', 'button success', 'float: right;',$this->grid1(), "exportingDataApi", null, ("'btn_exportar,".$name.",".$json."'"));
            $aux .= $this->Div('footer-container-1', '', '', 'padding-top: 10px;', $this->grid2());
            $aux .= $this->Div('footer-container-2 float-right', '',$button, '', $this->grid2());
            $html .= $this->Row('rowfooter-container', $aux, 'margin: 10px 10px 30px 10px;');
            $html .= "<input type='hidden' name='_token' id='_token' value=".csrf_token().">";
        }
        return $html;
    }

    public function Container($id, $contenido, $style=''){
        $html = "<div id='".$id."' class='container-fluid' style='".$style."'>";
        $html .= $contenido;
        $html .= "</div>";
        return $html;
    }

    public function Row($id, $contenido, $style='', $n=null){
        $class = "";
        if($n != null)
            $class = "class='row cell-sm-".$n['sm']." cell-md-".$n['md']." cell-lg-".$n['lg']." cell-xl-".$n['xl']." cell-xxl-".$n['xxl']."'";
        else
            $class = "class='row'";

        $html = "<div id='".$id."' style='".$style."' $class>";
        $html .= $contenido;
        $html .= "</div>";
        return $html;
    }

    public function Form($id, $contenido, $method, $action){
        $html = "<form id='$id' action='$action' method='$method'>";
        $html .= $contenido;
        $html .= "</form>";
        return $html;
    }

    //Generar una lista con informaci車n proveniente de la base de datos, Input: $request = array('tabla'=>'','reporte'=>'','perfil'=>'','usuario'=>'');
    public function generateOptionsTable($tabla,$key){
        $sql = "SELECT $key[0] AS VALUE, $key[1] AS TEXTO FROM ".$tabla." a WHERE a.estado =1";
        $response =  DB::select($sql);
        return $response;
    }

    //Generar una lista con informaci車n proveniente de la base de datos, Input: $request = array('tabla'=>'','reporte'=>'','perfil'=>'','usuario'=>'');
    public function generateOptions($request){

        $sql = "SELECT
                    a.id AS ID,
                    a.texto AS TEXTO,
                    a.valor AS VALUE,
                    a.reporte AS REPORTES,
                    a.accesos AS ACCESO,
                    JSON_UNQUOTE(JSON_EXTRACT(JSON_EXTRACT(a.reporte, '$.valores'),'$[0]')) AS VALOR
                FROM  ".$request['tabla']." a
                WHERE a.estado =1
                AND FN_JSON_VERIFY_DATA(a.reporte, ".$request['reporte'].", '$.reporte') = 'VERDADERO'
                AND (FN_JSON_VERIFY_DATA(a.accesos, ".$request['perfil'].", '$.perfil') = 'VERDADERO'
                AND FN_JSON_VERIFY_DATA(a.accesos, ".$request['usuario'].", '$.usuarios') = 'FALSO')";

        $response =  DB::select($sql);

        return $response;
    }


    public function InfoApi($id){
        $sql = "SELECT * FROM config_api WHERE id=$id AND estado=1";
        $obj = DB::select($sql);
        return $obj;
    }


    public function ApiGlobal($obj, $do){
        //$param    = $dispo->getParam('Device');
        $param   = json_decode($obj[0]->parametros,true);

        $url = $obj[0]->url;
        if($do!="" && $do!=NULL){
            $url .= $do;
        }

        $client   = new Client();

        if($obj[0]->metodo!="GET"){
            $response = $client->request($obj[0]->metodo, $url, $param);
            $body = $response->getBody(); //$result = $body->read(1024);
            $result = json_decode(fgets($body->detach()));
        }else{
            $response = $client->request($obj[0]->metodo, $url);
            $result = json_decode($response->getBody());
        }

        //DD($obj->FObject);

        return $result->{$obj[0]->return};
    }

    public function TableGlobal($obj){
        $result  = json_decode($obj,true);
        return $result;
    }


    public function generateOptionsAPI($data,$key){

        $jar = array();
        foreach($data as $fil){
            $jar[] = (object)array("VALUE"=>$fil->{$key[0]},"TEXTO"=>$fil->{$key[1]});
        } //dd($jar);
        return $jar;
    }

    public function callData($request){

        $usuario = session()->get('app_idusuario');
        $perfil = session()->get('app_idrol');

        //$usuario = 1; $perfil = 1;

        $sql = "SELECT
                    *
                FROM  ".$request['tabla']." a
                WHERE a.estado =1
                AND a.etiqueta = '".$request['etiqueta']."'
                AND a.id_aplicaciones_det = ".$request['id_aplicaciones_det']."
                AND FN_JSON_VERIFY_DATA(a.accesos, ".$perfil.", '$.perfil') = 'VERDADERO'
                AND FN_JSON_VERIFY_DATA(a.accesos, ".$usuario.", '$.usuarios') = 'FALSO'
                ORDER BY a.orden ASC";

        $response =  DB::select($sql);
        //dd($sql);
        return $response;
    }

    public function paginateArray($data, $perPage = 15)
    {
        $page = Paginator::resolveCurrentPage();
        $total = count($data);
        $results = array_slice($data, ($page - 1) * $perPage, $perPage);

        return new LengthAwarePaginator($results, $total, $perPage, $page, [
            'path' => Paginator::resolveCurrentPath(),
        ]);
    }

    function getHTML($tabla, $etiqueta, $information){

        $html = new HTMLBuilderController;
        $componentes = "<input type='hidden' name='_token' id='_token' value=".csrf_token().">";
        $request = array('tabla'=>$tabla,'perfil'=>1,'usuario'=>1, 'etiqueta'=>$etiqueta);
        $data= $html->callData($request);
        foreach($data as $key => $value){
            $valor = '';
            if($information != null && $etiqueta != "documentos_digitalizados"){
                if(property_exists($information, $value->id_css)){
                    $id = $value->id_css;
                    $valor = $information != null && $information != ''?$information->$id:'';
                }
            }
            switch($value->tipo){
                case 'hidden':
                    $componentes .= $html->Input($value->id_css, $valor, $value->clase_css, '', $value->tipo);
                break;
                case 'text':
                    $grid = $html->grid2();
                    if($etiqueta == 'auth_usuarios_complementarios'){
                        $grid = $html->grid12();
                    }
                    $componentes .= $html->jTextfield($value->id_css, $value->caption, $valor, $value->tipo, '', '', $value->clase_css, $grid, $value->es_requerido, $value->es_readonly);
                break;
                case 'datetime':
                    $componentes .= $html->jDateTimefield($value->id_css, $value->caption, $valor, $value->tipo, '', '', $value->clase_css, $html->grid2(), $value->es_requerido, $value->es_readonly);
                break;
                case 'time':
                    $componentes .= $html->jTimefield($value->id_css, $value->caption, $valor, $value->tipo, '', '', $value->clase_css, $html->grid2(), $value->es_requerido, $value->es_readonly);
                break;
                case 'textarea':
                    $componentes .= $html->Textarea($value->id_css, $value->caption, $valor, 'height:500px;' ,$value->clase_css, $html->grid2());

                break;
                case 'file':
                    $componentes .= $html->jFile($value->id_css, $value->caption, $valor, $value->tipo, '', '', $value->clase_css, $html->grid2(), $value->es_requerido, $value->es_readonly);
                break;
                case 'date':
                    $valor = $valor != null?$valor:'';
                    $valor = strlen($valor) == 19?substr($valor,0,10):$valor;
                    $componentes .= $html->jTextfield($value->id_css, $value->caption, $valor, $value->tipo, '', '', $value->clase_css, $html->grid2(), $value->es_requerido, $value->es_readonly);
                break;
                case 'select_sino':
                    $componentes .= $html->jSelectYesNo($value->id_css, $value->caption, '',  $value->clase_css, $html->grid2(), $valor);
                break;
                case 'select':
                    $opciones = array();

                    if(strlen($value->origen)>0){
                        if(substr($value->origen,0,9) == '{"tabla":'){
                            $res = $html->TableGlobal($value->origen);
                            $par = explode(",",$res["params"]);
                            $opciones = $html->generateOptionsTable($res["tabla"],$par);

                        }else{
                            $opciones = $html->generateOptions($value->origen);
                        }
                    }


                    $componentes .= $html->jSelect($value->id_css, $value->caption, $opciones, $value->clase_css, $html->grid2(), $valor);
                break;
                case 'submit':
                    $component = $html->Button($value->id_css, $value->caption, $value->tipo, $value->clase_css, $value->custom_css, $value->js,'',$value->icono, false);
                    $componentes .= $html->Div('container-button', 'container-button', $component, '', $html->grid5());
                break;
                case 'button':
                    $component= $html->Button($value->id_css, $value->caption, $value->tipo, $value->clase_css, $value->custom_css, $html->grid12(),$value->js,'',$value->icono, false);
                    $componentes .= $html->Div('container-button', 'container-button', $component, '', $html->grid5());
                break;
            }

        }

        return $componentes;
    }


        // Metodos John Pardo

        public function generateOptionsUnfilter($request){
            $campo = $request['campo'];
            if($campo != 'estado') {
                $tabla = $request['tabla'];
                if($request['conexion'] == null)
                    $conn = 'local';
                else $conn = $request['conexion'];

                $sql = "SELECT
                        a.id AS VALUE,
                        a.$campo AS TEXTO
                    FROM  $tabla a
                    WHERE a.estado =1";

                $response =  DB::connection($conn)->select($sql);
            } else {
                $datos = array();
                $response = $datos;
            }

            return $response;
        }


        public function Tabs($parametros){
            $estructura = '';
            $estructura .= '<ul data-role="materialtabs"
                                data-fixed-tabs="false"
                                data-deep="true">';
            for($i=0; $i < count($parametros['titulos']);$i++) {
                $estructura .= '<li><a href="#etiqueta'.$i.'">'.$parametros['titulos'][$i].'</a></li>';
            }
            $estructura .= '</ul>';
            $estructura .= '<div>';
            for($i=0; $i < count($parametros['titulos']);$i++) {
                $estructura .= '<div id="etiqueta'.$i.'">'.$parametros['contenidos'][$i].'</div>';
            }
            $estructura .= '</div>';

            return $estructura;
        }

        public function grid1x4(){
            return array('sm'=>12, 'md'=>3, 'lg'=>3, 'xl'=>3, 'xxl'=>3);
        }

        public function esperar() {
            return '<div class="dialog w-25" data-role="dialog" data-close-button="false" id="esperar">
                        <div class="dialog-content">
                            <center>
                                <span class="mif-loop2 ani-spin mif-4x"></span><br><b>Cargando datos</b><br>Por favor espere...
                            </center>
                        </div>
                    </div>';
        }
        // Fin Metodos John Pardo

        public function Corrousel($data){
            $html = '<div data-role="carousel"
            data-height="@ (max-width: 1920px),500 | (max-width: 768px),350 | (max-width: 576px),100"
            data-cls-bullet="bullet-big"
            data-auto-start="true"
            data-cls-controls="fg-white"
            data-bullets-position="right"
            data-control-next="<span class=\'mif-chevron-right controls-piel\'></span>"
            data-control-prev="<span class=\'mif-chevron-left controls-piel\'></span>">';

           foreach($data as $val){
                if($val->archivo != null && trim($val->archivo) != ""){
                    if(trim($val->titulo) != ""){
                        $html .= '<div class="slide p-2 pl-10 pr-10" data-cover="'.$val->archivo.'">
                                    <div class="row flex-align-center h-100">
                                        <div class="cell-md-7 text-center">
                                        </div>
                                        <div class="cell-md-5 contenido" style="padding-right:20px;">
                                            <h1 class="text-light titulo-slider">'.$val->titulo.'</h1>
                                            <p class="mt-4 mb-4 container-contenido">'.substr($val->contenido,0,255).'</p>';
                        if(trim($val->articulo_enlace) != ""){
                            $html .='<a href="'.$val->articulo_enlace.'" target="_blank"><button class="button alert" style="margin-top: 20px !important;">Leer más</button></a>';
                        }
                        $html .='</div></div></div>';
                    }else{
                        $html .= "<div class='slide' data-cover='".$val->archivo."'></div>";
                    }
                }
           }
           $html .= "</div>";

           $html .= "<script type='text/javascript'>
                    $(document).ready(function(){
                        $('.container-contenido').remove();
                    });
                </script>";

            return $html;
        }

        public function Card($titulo, $img, $contenido, $enlace, $fecha, $n){
            $cells = "";
            if($n != null){
                $cells = "cell-sm-".$n['sm']." cell-md-".$n['md']." cell-lg-".$n['lg']." cell-xl-".$n['xl']." cell-xxl-".$n['xxl'];
            }

            $html = '<div class="'.$cells.'"><div class="card image-header">';
            if($img == '' && $img == null){
                $img = '';
            }

            $html.='<div class="card-header titulo-card fg-white"
                        style="background-image: url('.$img.')">
                        '.$titulo.'
                    </div>';

            if($contenido != '' && $contenido != null){
                $html .= '<div class="card-content p-2 contenido-card">
                                <p class="fg-gray">Fecha de Publicación '.$fecha.'</p>
                                '.$contenido.'
                            </div>';
            }
            if($enlace != '' && $enlace != null){
                $html .= '<div class="card-footer">
                                <button class="button secondary">
                                    <a href='.$enlace.' target="_blank" style="color: black !important;">Leer más</a>
                                </button>
                            </div>';
            }
            $html .= '</div></div>';
            return $html;
        }

        public function CardDialog($titulo, $img, $descripcion, $enlace, $fecha, $n, $id, $requisitos, $id_usuario, $tipo_convocatoria){
            $contenido = substr($descripcion,0,255);
            $cells = "";
            if($n != null){
                $cells = "cell-sm-".$n['sm']." cell-md-".$n['md']." cell-lg-".$n['lg']." cell-xl-".$n['xl']." cell-xxl-".$n['xxl'];
            }

            $html = '<div class="'.$cells.'"><div class="card image-header">';
            if($img == '' && $img == null){
                $img = '';
            }

            $html.='<div class="card-header titulo-card fg-white"
                        style="background-image: url('.$img.')">
                        '.$titulo.'
                    </div>';

            if($contenido != '' && $contenido != null){
                $html .= '<div class="card-content p-2 contenido-card">
                                <p class="fg-gray">Fecha de Publicación '.$fecha.'</p>
                                '.$contenido.'
                            </div>';
                $html .= '<div class="card-footer">
                            <button class="button secondary">
                                <a href="javascript:void(0)"  onclick=\'Metro.dialog.open("#demoDialog'.$id.'")\' style="color: black !important; ">Aplicar</a>
                            </button>
                        </div>';
            }

            $html .= '</div></div>';

            $requisito_html = "";
            if(count($requisitos)>0){
                $requisito_html = "<table class='table striped' style='font-size: 12px !important;'>";
                $requisito_html .= "<thead>
                                        <tr>
                                            <th class='sortable-column sort-asc'>NOMBRE REQUISITO</th>
                                            <th class='sortable-column sort-asc'>DESCRIPCIÓN</th>
                                            <th class='sortable-column sort-asc'>CONDICIÓN</th>
                                            <th class='sortable-column sort-asc'>¿NECESITA ADJUNTO?</th>
                                        </tr>
                                    </thead><tbody>";
                foreach($requisitos as $val){
                    $requisito_html .= "<tr>";
                    $requisito_html .= "<td style='text-align:center;'>".$val->NOMBRE_REQUISITO."</td>";
                    $requisito_html .= "<td style='text-align:center;'>".$val->DESC_REQUISITO."</td>";
                    $requisito_html .= "<td style='text-align:center;'>".$val->CONDICION."</td>";
                    $requisito_html .= "<td style='text-align:center;'>".$val->NECESITA_ADJUNTO."</td>";
                    $requisito_html .= "<tr>";
                }
                $requisito_html .= "</tbody></table>";
                $requisito_html = '<div class="dialog-title">Requisitos</div>
                                    <div class="dialog-content">
                                    '.$requisito_html.'
                                    </div>';
            }

            $enlace_html = "";
            if($enlace != '' && $enlace != null){
                $enlace_html .= '<div class="dialog-title">Enlace</div>
                                <div class="dialog-content" style="text-align: center;">
                                    <a href="'.$enlace.'" target="_blank" style="
                                    color: #321647 !important;
                                    font-weight: bold;
                                    font-size: 20px;">Archivo relacionado</a>
                                </div>';
            }

            $html .= '<div class="dialog" data-width="1000" data-close-button="true" data-role="dialog" id="demoDialog'.$id.'">
                        <div class="dialog-title">'.$titulo.'</div>
                        <div class="dialog-content">
                            <div class="dialog-title">Descripción de la Convocatoria</div>
                            <div class="dialog-content" style="font-size: 14px; text-align: justify;">
                            '.$descripcion.'
                            </div>
                            '.$requisito_html.'
                            '.$enlace_html.'
                        </div>
                        <div class="dialog-actions" style="text-align: center;">';
                   $html .= '<button class="button" id="btnSucessApply" style="background: #ffc0b6; !important;" onclick="applyConvocatoria(' . $id . ',' . $id_usuario . ','.$tipo_convocatoria.')">Aplicar</button>';
                    $html .= '<button class="button js-dialog-close" id="btnCloseApply" style="background: #321647 !important; color: white !important;">Cerrar</button>
                        </div>
                    </div>';

            return $html;
        }


        public function JSComplemetarios(){

            $str = "<script type='text/javascript'>
            $( document ).ready(function() {

                var request = $.ajax({
                    url: 'form_auth_usuarios_complementarios_get',
                    type: 'GET',
                    contentType: 'application/json; charset=UTF-8',
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name=\"csrf-token\"]').attr('content')
                    },
                });

                request.done(function (respuesta) {
                    var json = JSON.stringify(respuesta['output']);
                    var data = JSON.parse(json);
                    if (!respuesta.error) {
                        console.log(data);

                        let lst=Metro.getPlugin(\"#lstDepartamento_nac\", \"select\");
                        lst.val(data['departamento_nac']);

                        lst=Metro.getPlugin(\"#lstCiudad_nac\", \"select\");
                        lst.val(data['ciudad_nac']);

                        lst=Metro.getPlugin(\"#lstOrientacion_sexual\", \"select\");
                        lst.val(data['orientacion_sexual']);

                        lst=Metro.getPlugin(\"#lstEstado_civil\", \"select\");
                        lst.val(data['estado_civil']);

                        lst=Metro.getPlugin(\"#lstHijos\", \"select\");
                        lst.val(data['hijos']);

                        lst=Metro.getPlugin(\"#lstEstrato\", \"select\");
                        lst.val(data['estrato']);

                        lst=Metro.getPlugin(\"#lstSisben\", \"select\");
                        lst.val(data['sisben']);

                        lst=Metro.getPlugin(\"#lstPrograma_estudiar\", \"select\");
                        lst.val(data['programa_estudiar']);

                        lst=Metro.getPlugin(\"#lstGrado_escolaridad\", \"select\");
                        lst.val(data['grado_escolaridad']);

                        lst=Metro.getPlugin(\"#lstConectividad\", \"select\");
                        lst.val(data['conectividad']);

                        lst=Metro.getPlugin(\"#lstEquipos_tecnologicos\", \"select\");
                        lst.val(data['equipos_tecnologicos']);

                        lst=Metro.getPlugin(\"#lstPlan_emergencia_social\", \"select\");
                        lst.val(data['plan_emergencia_social']);

                        lst=Metro.getPlugin(\"#lstTipo_institucion\", \"select\");
                        lst.val(data['tipo_institucion']);

                        lst=Metro.getPlugin(\"#lstActualmente_estudia\", \"select\");
                        lst.val(data['actualmente_estudia']);

                        lst=Metro.getPlugin(\"#lstPertenece_programa\", \"select\");
                        lst.val(data['pertenece_programa']);

                        lst=Metro.getPlugin(\"#lstAcciones_sociales\", \"select\");
                        lst.val(data['acciones_sociales']);

                        $('#dtpAnio_culminado_o_porculminar').val(data['anio_culminado_o_porculminar']);
                        $('#dtpAnio_prueba_icfes').val(data['anio_prueba_icfes']);
                        $('#txtResultado_icfes').val(data['resultado_icfes']);
                        $('#txtCurso_tecnico_teconologo').val(data['curso_tecnico_teconologo']);
                        $('#txtOrganización_pertenece').val(data['organización_pertenece']);
                        $('#txtPrograma_beca').val(data['programa_beca']);
                        $('#txtGanador_boo').val(data['ganador_boo']);
                        $('#txtDeportista').val(data['deportista']);
                        $('#txtEste_programa').val(data['este_programa']);

                    } else {
                        Swal.fire('¡Atención!', data, 'error');
                    }
                });

                request.fail(function (jqXHR, textStatus, errorThrown) {
                        let error = '';
                        if (jqXHR.status === 0) {
                            error = 'Not connect: Verify Network.';
                        } else if (jqXHR.status == 404) {
                            error = 'Requested page not found [404]';
                        } else if (jqXHR.status == 500) {
                            error = 'Internal Server Error [500].';
                        } else if (textStatus === 'parsererror') {
                            error = 'Requested JSON parse failed. ' + errorThrown;
                        } else if (textStatus === 'timeout') {
                            error = 'Time out error.';
                        } else if (textStatus === 'abort') {
                            error = 'Ajax request aborted.';
                        } else {
                            error = 'Uncaught Error: ' + jqXHR.responseText;
                        }
                        showMsgSweet('¡Ha ocurrido un problema!', error, 'error');
                    });

            });
            </script>";

            return $str;
        }



}

?>
