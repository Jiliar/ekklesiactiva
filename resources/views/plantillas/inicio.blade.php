@php
    $imagen = session()->get('app_imagen');
    $menu_subitems = session()->get('app_menu_subitems');
   if( session()->get('app_nomusuariocorto') == null ){
        echo "<script type='text/javaScript'> const nextURL = '".env('HOST_URL')."'; window.location.href = nextURL; </script>";
    }
@endphp
<!DOCTYPE html>
<html lang="en" class=" scrollbar-type-1 ">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Metro 4 -->
    <link rel="shortcut icon" href="{{ asset('images/favicon.ico')}}" type="image/x-icon">
    <link rel="stylesheet"    href="{{ asset('css/custom.css')}}">
    <link rel="stylesheet"    href="{{ asset('vendors/metro4/css/metro-all.css')}}">
    <link rel="stylesheet"    href="{{ asset('css/index.css')}}">
    <link rel="stylesheet"    href="{{ asset('vendors/chartjs/Chart.min.css')}}">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="//cdn.ckeditor.com/4.20.0/standard/ckeditor.js"></script>
    <title> Ekklesia Activa </title>

</head>
<body class="m4-cloak h-vh-100">
<div data-role="navview" data-toggle="#paneToggle" data-expand="xl" data-compact="lg" data-active-state="true">
    <div class="navview-pane bg-planoB" style="background-color: white; z-index:1000;">
        <div class="d-flex flex-align-center bg-planoB fg-planoA container-button-movil">
            <button class="pull-button m-0 bg-planoB">
                <span class="mif-menu bg-planoB fg-white boton-movil"></span>
            </button>
            <h2 class="text-light m-0 fg-white bg-planoB pl-7 logo-title" style="line-height: 52px">
                <img src='images/ekklesia-logo-6.png' style='width:70% !important;'>
            </h2>
        </div>

        <div class="suggest-box bg-planoB">
            <div class="data-box bg-planoB" style='margin: 10px;'>
                <img src="{!! $imagen !!}" class="avatar">
                <div class="ml-4 avatar-title flex-column">
                    <a href="#" class="d-block fg-planoA text-medium no-decor"><span class=" name_visibility reduce-1">{!! session()->get('app_nomusuariocorto') !!}</span></a>
                    <p class="m-0"><span class="fg-green mr-2">&#x25cf;</span><span class="text-small">online</span></p>
                </div>
            </div>
            <img src="{!! $imagen !!}" class="avatar holder ml-2">
        </div>

        <div class="suggest-box bg-planoB" style='background-color: #7CB4EA   !important; padding: 3px !important;'>
            <!--<input type="text" data-role="input" data-clear-button="false" data-search-button="true">-->
            <button class="holder">
                <span class="mif-search fg-white"></span>
            </button>
        </div>

        <ul class="navview-menu mt-4 bg-planoD" id="side-menu">
            <li class="bg-planoB">
                <a href="inicio" class="dropdown-toggle bg-planoB fg-white">
                    <span class="icon"><span class="mif-home fg-planoC"></span></span>
                    <span class="caption">Inicio</span>
                </a>
            </li>
            {!! $menu_subitems !!}

        </ul>

        <div class="w-100 text-center text-small data-box p-2 border-top bd-grayMouse" style="position: absolute; bottom: 0">
            <div>&copy; 2023 <a href="https://" class="text-muted fg-white-hover no-decor">Ekklesia Activa</a></div>
        </div>
    </div>

    <div class="navview-content h-100 bg-planoB">
        <div data-role="appbar" class="pos-absolute bg-planoB fg-white">

            <a href="#" class="app-bar-item d-block d-none-lg bg-planoB" id="paneToggle" ><span class="mif-menu"></span></a>

            <div class="app-bar-container ml-auto">
                <!--<a href="#" class="app-bar-item">
                    <span class="mif-envelop"></span>
                    <span class="badge bg-green fg-white mt-2 mr-1">4</span>
                </a>
                <a href="#" class="app-bar-item">
                    <span class="mif-bell"></span>
                    <span class="badge bg-orange fg-white mt-2 mr-1">10</span>
                </a>
                <a href="#" class="app-bar-item">
                    <span class="mif-flag"></span>
                    <span class="badge bg-red fg-white mt-2 mr-1">9</span>
                </a>-->
                <div class="app-bar-container">
                    <a href="#" class="app-bar-item">
                        <img src="{!! $imagen !!}" class="avatar">
                        <span class="name_visibility ml-2 app-bar-name">{!! session()->get('app_nomusuariocorto') !!}</span>
                    </a>
                    <div class="user-block shadow-1" data-role="collapse" data-collapsed="true">
                        <div class="bg-darkPurple fg-white p-2 text-center">
                            <img src="{!! $imagen !!}" class="avatar">
                            <div class="name_visibility h4 mb-0">{!! session()->get('app_nomusuariocorto') !!}</div>
                            <div>{!! session()->get('app_nomrol') !!}</div>
                        </div>
                        <div class="bg-white d-flex flex-justify-between flex-equal-items p-2 bg-light">
                            <button id='perfil' class="button ml-1 button warning outline" onclick = "Metro.dialog.open('#modalPerfil')">Perfil</button>
                            <button id='cerrar' class="button ml-1 button warning outline" onclick = "Metro.dialog.open('#modalSN')">Cerrar Sesion</button>
                        </div>
                    </div>
                </div>
                <a href="#" class="app-bar-item" style='display:none;'>
                    <span class="mif-cogs"></span>
                </a>
            </div>
        </div>

        <div id="content-wrapper" class="content-inner h-100" style="overflow-y: auto">
            @yield('contenido')
            <div id='vistaFormulario'></div>
        </div>
    </div>
</div>

<div class="dialog" data-role="dialog" id="modalSN">
    <div class="dialog-title fg-white" style="background-color: #7CB4EA; color: rgb(255 255 255) !important;">Confirmaci&oacute;n Requerida</div>
    <div class="dialog-content" style='text-align: center;'>
            <span class="mif-question mif-5x fg-gray"></span><br>
            <div>Seguro de realizar esta operaci&oacute;n ?</div>
    </div>
    <div class="dialog-actions">
        <center>
            <button class="button dark outline js-dialog-close" onclick='cerrar()'>Si</button>
            <button class="button js-dialog-close">Cancelar</button>
        </center>
    </div>
</div>

<div class="dialog" data-role="dialog" id="modalPerfil" data-width="800">
    <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}" />
    <input type="hidden" name="hdnId" id="hdnId" value="{{ session()->get('app_idusuario') }}" />
    <div class="dialog-title fg-white" style="background-color: #7CB4EA; color: rgb(255 255 255) !important;">Información del Perfil</div>
    <div class="dialog-content" style='text-align: center;'>
        <div id="" class="row " style="display: flex; justify-content: center;">

            @php
                use Illuminate\Support\Facades\DB;
                $values = null;
                $usuario = session()->get('app_idusuario');
                if($usuario != null && !empty($usuario)){
                    $query = "SELECT *
                                FROM auth_usuarios a
                                WHERE a.inactivo = 0 AND a.id = ".$usuario;
                    $values = DB::select($query);
                }

                $archivo = $values != null ?  $values[0]->archivo : "";
                $tipo_id = $values != null ?  $values[0]->tipo_id : "";
                $identificacion = $values != null ?  $values[0]->identificacion : "";
                $nombre1 = $values != null ?  $values[0]->nombre1 : "";
                $nombre2 = $values != null ?  $values[0]->nombre2 : "";
                $apellido1 = $values != null ?  $values[0]->apellido1 : "";
                $apellido2 = $values != null ?  $values[0]->apellido2 : "";
                $email = $values != null ?  $values[0]->email : "";
                $telefono = $values != null ?  $values[0]->telefono : "";
                $direccion = $values != null ?  $values[0]->direccion : "";
                $id_ciudad  = $values != null ?  $values[0]->ciudad : "";


            @endphp


            <div class="cell-sm-12 cell-md-12 cell-lg-12 cell-xl-12 cell-xxl-12 texts" id="container-perfil">
                <img src="{{$archivo}}" class="img-responsive" id='img-profile' alt="" style='width: 200px !important; margin-bottom:20px; border-radius: 50%;'/>
                <div class="input fields form-control">
                    <input type="file" id='uplFile' data-role="file" data-prepend="Imagen de Perfil">
                </div>
            </div>

            <div class="cell-sm-12 cell-md-12 cell-lg-6 cell-xl-6 cell-xxl-6 texts" id="container-perfil">
                <div class="input fields form-control">
                    <select data-role="select" name="lstTipoId" id="lstTipoId">
                            @php
                            if($usuario != null && !empty($usuario)){
                                $sql = "SELECT * FROM auth_tipos_id a where a.inactivo = 0";
                                $response =  DB::select($sql);
                                foreach($response as $row){
                                    if( $row->id == $tipo_id){
                                        echo "<option value=".$row->id." selected='selected' >".$row->codigo." - ".$row->nombre."</option>";
                                    }else{
                                        echo "<option value=".$row->id." >".$row->codigo." - ".$row->nombre."</option>";
                                    }
                                }
                            }
                             @endphp
                    </select>
                </div>
            </div>

        <div class="cell-sm-12 cell-md-12 cell-lg-6 cell-xl-6 cell-xxl-6 texts" id="container-perfil">
            <div class="input fields form-control">
                <input type="text" required="required" readonly="readonly" value="{{$identificacion}}" data-prepend="Identificacion" data-role="input" name="txtIdentificacion" id="txtIdentificacion" autocomplete="off" placeholder="Identificacion" value="" style="" class="" data-role-input="true">
            </div>
        </div>

        <div class="cell-sm-12 cell-md-12 cell-lg-6 cell-xl-6 cell-xxl-6 texts" id="container-perfil">
            <div class="input fields form-control">
                <input type="text" required="required" value="{{$nombre1}}" data-prepend="Primer Nombre" data-role="input" name="txtNombre1" id="txtNombre1" autocomplete="off" placeholder="Primer Nombre" value="" style="" class="" data-role-input="true">
            </div>
        </div>

        <div class="cell-sm-12 cell-md-12 cell-lg-6 cell-xl-6 cell-xxl-6 texts" id="container-perfil">
            <div class="input fields form-control">
                <input type="text" value="{{$nombre2}}" data-prepend="Segundo Nombre" data-role="input" name="txtNombre2" id="txtNombre2" autocomplete="off" placeholder="Segundo Nombre" value="" style="" class="" data-role-input="true">
            </div>
        </div>

        <div class="cell-sm-12 cell-md-12 cell-lg-6 cell-xl-6 cell-xxl-6 texts" id="container-perfil">
            <div class="input fields form-control">
                <input type="text" required="required" value="{{$apellido1}}" data-prepend="Primer Apellido" data-role="input" name="txtApellido1" id="txtApellido1" autocomplete="off" placeholder="Primer Apellido" value="" style="" class="" data-role-input="true">
            </div>
        </div>

        <div class="cell-sm-12 cell-md-12 cell-lg-6 cell-xl-6 cell-xxl-6 texts" id="container-perfil">
            <div class="input fields form-control">
                <input type="text" required="required" value="{{$apellido2}}" data-prepend="Segundo Apellido" data-role="input" name="txtApellido2" id="txtApellido2" autocomplete="off" placeholder="Segundo Apellido" value="" style="" class="" data-role-input="true">
            </div>
        </div>

        <div class="cell-sm-12 cell-md-12 cell-lg-6 cell-xl-6 cell-xxl-6 texts" id="container-perfil">
            <div class="input fields form-control">
                <input type="email" value="{{$email}}" data-prepend="Email" data-role="input" name="txtEmail" id="txtEmail" autocomplete="off" placeholder="Email" value="" style="" class="" data-role-input="true">
            </div>
        </div>

        <div class="cell-sm-12 cell-md-12 cell-lg-6 cell-xl-6 cell-xxl-6 texts" id="container-perfil">
            <div class="input fields form-control">
                <input type="phone" value="{{$telefono}}" data-prepend="Telefono" data-role="input" name="txtTelefono" id="txtTelefono" autocomplete="off" placeholder="Telefono" value="" style="" class="" data-role-input="true">
            </div>
        </div>
        {{--
        <div class="cell-sm-12 cell-md-12 cell-lg-6 cell-xl-6 cell-xxl-6 texts" id="container-perfil">
            Ciudad:
            <div class="input fields form-control">
                <select data-role="select" name="lstCiudad" id="lstCiudad">
                        @php
                         $sql = "SELECT * FROM geo_cities a WHERE a.country_id = 48";
                         $response =  DB::select($sql);
                         foreach($response as $row){
                            if( $row->id == $id_ciudad){
                                    echo "<option value=".$row->id." selected='selected' >".strtoupper($row->name)."</option>";
                                }else{
                                    echo "<option value=".$row->id." >".strtoupper($row->name)."</option>";
                                }
                         }
                         @endphp
                </select>
            </div>
        </div>
 --}}
        <div class="cell-sm-12 cell-md-12 cell-lg-12 cell-xl-12 cell-xxl-12 texts" id="container-perfil">
            <textarea data-role="textarea" name="txtDireccion" id="txtDireccion" autocomplete="off" placeholder="Dirección">{{$direccion}}</textarea>
    </div>

    </div>

    </div>
    <div class="dialog-actions" style='text-align:center !important; margin:0px;'>
            <button id='btnGuardarDataPerfil' class="button dark outline js-dialog-close" onclick='saveProfile()' style="font-family: 'Monserrat Regular' !important;">Guardar</button>
            <button id='btnCancelarOperacionPerfil' class="button js-dialog-close" style="font-family: 'Monserrat Regular'' !important;">Cancelar</button>
    </div>
</div>

<script type='text/javascript'>

    function saveProfile(){


    let msg = '¿Desea guardar la información suministrada?';
    let title = 'Alerta'
    let icon = 'warning';
    let confirmButtonText = '!Si, estoy listo¡'
    let denyButtonText = '!No, dejame revisar¡'

    Swal.fire({
        title: title,
        icon: icon,
        showDenyButton: true,
        text: msg,
        confirmButtonText: confirmButtonText,
        denyButtonText: denyButtonText,
    }).then((result) => {
        if (result.isConfirmed) {
                saveProfileDB();
                $('#txtDireccion').val('');
                $('#uplFile').val('');
                $('#container-upload .drop-zone .files').text('0 archivos(s) seleccionados');
        } else if (result.isDenied) {
            showMsgSweet(titleDenied, msgDenied, 'info')
        }
    })

    }

    function saveProfileDB(){

        let files =  $('#uplFile')[0].files;
        let id_usuario =  $('#hdnId').val();
        let tipo_id = $('#lstTipoId').val();
        let identificacion = $('#txtIdentificacion').val();
        let nombre1 = $('#txtNombre1').val();
        let nombre2 = $('#txtNombre2').val();
        let apellido1 = $('#txtApellido1').val();
        let apellido2 = $('#txtApellido2').val();
        let email = $('#txtEmail').val();
        let telefono = $('#txtTelefono').val();
        let direccion = $('#txtDireccion').val();
        let ciudad = $('#lstCiudad').val();
        var token = $('#_token').val();
        var formData = new FormData();

        formData.append('_token',token);
        formData.append('tipo_id', tipo_id);
        formData.append('identificacion', identificacion);
        formData.append('nombre1', nombre1);
        formData.append('nombre2', nombre2);
        formData.append('apellido1', apellido1);
        formData.append('apellido2', apellido2);
        formData.append('email', email);
        formData.append('telefono', telefono);
        formData.append('direccion', direccion);
        formData.append('ciudad', ciudad);
        formData.append('id_usuario', id_usuario);

        if( typeof files !== "undefined"){
            jQuery.each($('input[type=file]')[0].files, function(i, file) {
                formData.append('file-'+i, file);
            });
        }else{
            formData.append('file', null);
        }

        let url = 'form_auth_usuarios_save';

        if(identificacion != '' && nombre1 != '' && apellido1 != '' && apellido2 != '' && tipo_id != '' && tipo_id != null){

                $.ajax({
                    url: url,
                    type: 'POST',
                    dataType: 'json',
                    data:formData,
                    cache:false,
                    processData: false,
                    contentType: false,
                    beforeSend: function() {
                        $('#btnGuardarDataPerfil').attr('disabled',true);
                        $('#btnCancelarOperacionPerfil').attr('disabled',true);
                    }
                })
                .done(function(respuesta) {
                var json = JSON.stringify(respuesta['output']);
                var data = JSON.parse(json);
                    if (!respuesta.error) {
                        var response_ = JSON.stringify(respuesta['object']);
                        var object = JSON.parse(response_);
                        $('#img-profile').prop('src', object['archivo']);
                        $('.avatar').prop('src', object['archivo']);
                        $('.name_visibility').text(object['nombre1']+' '+object['apellido1']);
                        successMsgFormSweet();
                    } else {
                        errorMsgFormSweet2(data)
                    }
                })

                .fail(function(resp) {
                    errorMsgFormMetro();
                })

                .always(function() {
                    $('#btnGuardarDataPerfil').attr('disabled',false);
                    $('#btnCancelarOperacionPerfil').attr('disabled',false);
                    console.log("complete");
                });
            }else{
                showMsgSweet('¡Ha ocurrido un problema!', 'Por favor incluya los datos obligatorios', 'error');
            }
    }

    function llamarVista(paramVista, paramNomVista) {
        $.ajax({
            type:"get",
            url:"{{asset('vistas')}}",
            data : { vista : paramVista, nomVista : paramNomVista },
            success : function(respuesta) {
                $("#vistaFormulario").html(respuesta);
                if( paramVista != 'inf_ministerios' &&
                    paramVista != 'inf_asistencias' &&
                    paramVista != 'inf_actividades'){
                    getTable();
                }
                getDataForm(paramVista);

               /*  if(paramVista == 'rep_info_complementaria' ||
                    paramVista == 'rep_prueba_psicotecnica_masiva' ||
                    paramVista == 'rep_prueba_conocimiento_masivo' ||
                   paramVista == 'logic_seleccion'){
                    getConvocatoriasByTipo('ACADEMICA', paramVista);
                } */

            },
            error : function() { }
        })


    }

    function cerrar() {
        $(location).attr('href', 'http://ekklesiactiva.test/cerrarSesion')
    }
</script>

<!-- jQuery first, then Metro UI JS -->
<script src="vendors/jquery/jquery-3.4.1.min.js"></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/printThis/1.15.0/printThis.min.js' integrity='sha512-d5Jr3NflEZmFDdFHZtxeJtBzk0eB+kkRXWFQqEc1EKmolXjHm2IKCA7kTvXBNjIYzjXfD5XzIjaaErpkZHCkBg==' crossorigin='anonymous' referrerpolicy='no-referrer'></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="vendors/qrcode/qrcode.min.js"></script>
<script src="vendors/jsbarcode/JsBarcode.all.min.js"></script>
<script src="vendors/metro4/js/metro.js"></script>
<script src="vendors/validation/jquery.validate.min.js"></script>
<script src="js/funciones.js"></script>
<script src="js/index.js"></script>
<script src='//cdn.ckeditor.com/4.16.2/standard/ckeditor.js'></script>
<!--Chart-->
<script src="vendors/chartjs/Chart.bundle.min.js"></script>
<script src="vendors/chartjs/Chart.min.js"></script>
<!--Sweet Alert-->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.2/dist/sweetalert2.all.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
</body>
</html>
