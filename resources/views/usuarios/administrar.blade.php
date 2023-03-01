@php
use App\Http\Controllers\UsuariosController;
use App\Http\Controllers\HTMLBuilderController;
$usuario = new UsuariosController;
$htmlC   = new HTMLBuilderController;
@endphp
<!DOCTYPE html>
<style>
    .listado {
        height: 370px;
        overflow-y: scroll;
        padding: 0px;
    }
    .trol {
        height: 400x;
    }
    .paneles {
        border-style: solid;
        border-color: grey;
        border-width: 2px;
    }
    .contenido {
        height: 270px;
        overflow-y: scroll;
    }
</style>
<html lang="en">
<head>
    <link rel="shortcut icon" href="{{ asset('imagenes/logo.png') }}">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <link rel="stylesheet" href="{{ asset('vendors/metro4/css/metro-all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="{{ asset('images/favicon.png')}}" type="image/x-icon">
    <title>Document</title>
</head>

<style>
    .main { width : 200px }
</style>

<body class="m4-cloak h-vh-100" style="background: white; color: black">
    <div  data-role="accordion"
            data-active-heading-class="bg-crimson fg-white">
        <div id="infobasica" class="frame active">
            <div class="heading"><b>Informacion Basica</b></div>
            <div class="content">
                <div class='grid'>
                    <div class="row">
                        <div class="cell-4">
                            <div>
                                <select id="tipo_id" data-role="select" data-prepend="Tipo de Identif.">
                                    <option value= "">Seleccione...</option>
                                    <option value= "CC">Cedula</option>
                                    <option value= "NIT">NIT</option>
                                    <option value= "PS">Pasaporte</option>
                                    <option value= "RUT">RUT</option>
                                </select>
                            </div>
                        </div>
                        <div class="cell-4"><div><input id='identificacion' type="text" data-role="input" data-prepend="Identificacion:"></div></div>
                        <div class="cell-4">
                            <div>
                                @php
                                    echo $usuario->objSelect('cti','roles','id','nombre','Perfil','rol','estado=1');
                                @endphp
                            </div>
                        </div>
                        <div class="cell-4"><div><input id='nombre1' type="text" data-role="input" data-prepend="1er Nombre:"></div></div>
                        <div class="cell-4"><div><input id='nombre2' type="text" data-role="input" data-prepend="2do Nombre:"></div></div>
                        <div class="cell-4"><div><input id='apellido1' type="text" data-role="input" data-prepend="1er Apellido:"></div></div>
                        <div class="cell-4"><div><input id='apellido2' type="text" data-role="input" data-prepend="2do Apellido:"></div></div>
                        <div class="cell-4"><div><input id='email' type="email" data-role="input" data-prepend="eMail:"></div></div>
                        <div class="cell-4">
                            <div>
                                <select id='empresa' data-role="select" data-prepend="Empresa:">
                                    <option value="">Seleccione...</option>
                                </select>
                            </div>
                        </div>
                        <div class="cell-4">
                            <div>
                                @php
                                    echo $usuario->objSelect('local','sucursales','id','nombre','Sucursal','sucursal','estado=1');
                                @endphp
                            </div>
                        </div>
                        <div class="cell-4"><div><input id='usuario_wsimex' type="text" data-role="input" data-prepend="ID WSimex"></div></div>
                        <div class="cell-4"><div><input id='tel_fijo' type="text" data-role="input" data-prepend="Tel. Fijo:"></div></div>
                        <div class="cell-4"><div><input id='tel_movil' type="text" data-role="input" data-prepend="Tel. Movil:"></div></div>
                        <div class="cell-4"><div><input id='usuario' type="text" data-role="input" data-prepend="Usuario"></div></div>
                        <div class="cell-4"><div><input id='tokenws' type="text" data-role="input" data-prepend="Token WS"></div></div>
                        <div class="cell-4"><div><input id='tokenws_dias' type="number" data-role="input" data-prepend="Token Venc. (dias)"></div></div>
                        <div class="cell-4"><div><input id='tokenws_fechaven' type="date" data-role="input" data-prepend="Fecha Venc."></div></div>
                        <div class="cell-4">
                            <div>
                                <select id='estado' data-role="select" data-prepend="Estado CTI:">
                                    <option value="">Seleccione...</option>
                                    <option value="1">ACTIVO...</option>
                                    <option value="0">INACTIVO...</option>
                                </select>
                            </div>
                        </div>
                        <div class="cell-4">
                            <div>
                                <select id='estado_usuario' data-role="select" data-prepend="Estado AS:">
                                    <option value="">Seleccione...</option>
                                    <option value="1">ACTIVO...</option>
                                    <option value="0">INACTIVO...</option>
                                </select>
                            </div>
                        </div>
                    </div> <! -- fin row -->
                    <div class="row">
                        <div class="cell-4">
                            <button class="button alert shadowed outline">Guardar &nbsp;&nbsp;<span class="mif-checkmark"></span></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id='listausuarios' class="frame">
            <div class="heading"><b>Lista de Usuarios</b></div>
            <div class="content">
                <div class="p-2 listado">@php echo($usuario->userList()) @endphp</div>
            </div>
        </div>
        <div class="frame">
            <div class="heading"><b>Roles y Permisos</b></div>
            <div class="content">
                <div class="p-2">
                    <div class="row">
                        <div class="cell-4 paneles">
                            <br>
                            <div class='p-1 p-3-md p-5-lg p-8-xl' style='border-radius: 8px; background-color: #e7e7e7'>
                                <b>Filtrar permisos por</b><br><br>
                                <input id="filtroUsuario" value="usuario" type="radio" data-role="radio" name="filtro" data-caption="Usuario" checked>
                                <input id="filtroRol"     value="rol"     type="radio" data-role="radio" name="filtro" data-caption="Rol">
                                <input id="filtroGE"      value="empresa" type="radio" data-role="radio" name="filtro" data-caption="Grupo Empresarial" >
                            </div>
                            <br>
                            <div class='p-1 p-3-md p-5-lg p-8-xl' style='border-radius: 8px; background-color: #e7e7e7'>
                                <b>
                                <div class="cell-12">
                                    <div>@php echo $usuario->objSelect('cti','usuarios','id','concat(apellido1," ",apellido2," ",nombre1," ",nombre2)','Buscar','confUsuario','estado=1 OR estado_usuario=1');  @endphp</div>
                                </div>
                                <div class="cell-12">
                                    <div>@php echo $usuario->objSelect('cti','roles','id','concat(nombre)','Buscar','confRol','estado=1');  @endphp</div>
                                </div>
                                <div class="cell-12">
                                    <div>@php echo $usuario->objSelect('local','grupo_empresarial','id','concat(razon_social)','Buscar','confGE','inactivo=0');  @endphp</div>
                                </div>
                                </b>
                            </div>
                            <br>
                        </div>
                        <div class="cell-8 paneles" id='htmlRoles'>
                            @php
                                echo $usuario->tabsRoles();
                            @endphp
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @php echo $htmlC->esperar(); @endphp

</body></html>

<script src="{{ asset('js/funciones.js') }}"></script>
<script src="{{ asset('vendors/chartjs/Chart.bundle.min.js') }}"></script>
<script src="{{ asset('vendors/qrcode/qrcode.min.js') }}"></script>
<script src="{{ asset('vendors/jsbarcode/JsBarcode.all.min.js') }}"></script>
<script src="{{ asset('vendors/ckeditor/ckeditor.js') }}"></script>
<script src="{{ asset('vendors/metro4/js/metro.min.js') }}"></script>
<script src="{{ asset('js/index.js') }}"></script>

</body>
</html>

<script src="{{ asset('jquery.js') }}"></script>
<script src="{{ asset('jquery.min.js') }}"></script>


<script>
    function userStatus(idusuario, app) {
        $.ajax({
            type: "GET",
            url : "{{asset('userConf')}}",
            data: { accion: 'status', id : idusuario, estadoApp: app },
            success : function (data) {  },
            error : function() {  }
        });
    }

    function showUser(idusuario) {
        $.ajax({
            type: "GET",
            url : "{{asset('userConf')}}",
            data: { accion: 'listado', id: idusuario },
            success : function (data) {
                datos = JSON.parse(data, true);
                $("#tipo_id").val("CC");
                $("#identificacion").val(datos['data'][0]['identificacion']);
                $("#rol").val(datos['data'][0]['rol']);
                $("#nombre1").val(datos['data'][0]['nombre1']);
                $("#nombre2").val(datos['data'][0]['nombre2']);
                $("#apellido1").val(datos['data'][0]['apellido1']);
                $("#apellido2").val(datos['data'][0]['apellido2']);
                $("#email").val(datos['data'][0]['email']);
                $("#sucursal").val(datos['data'][0]['sucursal']);
                $("#usuario_wsimex").val(datos['data'][0]['usuario_wsimex']);
                $("#tel_fijo").val(datos['data'][0]['tel_fijo']);
                $("#tel_movil").val(datos['data'][0]['tel_movil']);
                $("#usuario").val(datos['data'][0]['usuario']);
                $("#tokenws").val(datos['data'][0]['tokenws']);
                $("#tokenws_dias").val(datos['data'][0]['tokenws_dias']);
                $("#tokenws_fechaven").val(datos['data'][0]['tokenws_fechaven']);
                $("#estado").val(datos['data'][0]['estado']);
                $("#estado_usuario").val(datos['data'][0]['estado_usuario']);

                Metro.getPlugin("#tipo_id", 'select').val([$("#tipo_id").val()]);
                Metro.getPlugin("#rol", 'select').val([$("#rol").val()]);
                Metro.getPlugin("#sucursal", 'select').val([$("#sucursal").val()]);
                Metro.getPlugin("#estado", 'select').val([$("#estado").val()]);
                Metro.getPlugin("#estado_usuario", 'select').val([$("#estado_usuario").val()]);

                $("#confUsuario").val(idusuario);
                Metro.getPlugin("#confUsuario", 'select').val([$("#confUsuario").val()]);
                $("#confRol").val(datos['data'][0]['rol']);
                Metro.getPlugin("#confRol", 'select').val([$("#confRol").val()]);
            },
            error : function() {  }
        });
    }

    function cambiaEstado(tabla, id) {
        usuario = $("#confUsuario").val();
        rol     = $("#confRol").val();
        grupo   = $("#confGE").val(); // Grupo empresarial

        // http://localhost/rolesUsuario?id=3&elemento=perfil&valor=14&tabla=aplicaciones&modo=eliminar

        control = "#"+tabla+"--"+id;
        ruta = '';
        if ($(control).is(':checked')) modo = 'insertar'; else modo='eliminar';

        if($("#filtroUsuario").is(':checked')) { elemento = 'usuarios'; valor = usuario; }
        if($("#filtroRol").is(':checked'))     { elemento = 'perfil';   valor = rol;     }
        if($("#filtroGE").is(':checked'))      { elemento = 'empresas'; valor = grupo;   }

        if(tabla != 'submenu') {
            ruta = 'http://localhost/rolesUsuario?id='+id+'&elemento='+elemento+'&valor='+valor+'&tabla='+tabla+'&modo='+modo;
            $.ajax({
                type: 'get',
                url : ruta,
                success : function (data) { },
                error   : function () { alert('ERROR\n\nNo se puedo ejecutar la transaccion'); }
            })
        } else {
            alert('actualizando menu de usuarios');
        }
    }

    $("#confUsuario").change(function() { showRoles(); })
    $("#confRol").change(function()     { showRoles(); })
    $("#confGE").change(function()      { showRoles(); })
    $("#filtroUsuario").click(function(){ showRoles(); })
    $("#filtroRol").click(function()    { showRoles(); })
    $("#filtroGE").click(function()     { showRoles(); })

    function showRoles() {
        Metro.dialog.open('#esperar');
        htmlRoles = 'Sin informacion';
        usuario = $("#confUsuario").val();
        rol     = $("#confRol").val();
        grupo   = $("#confRol").val();

        if($("#filtroUsuario").is(':checked')) filtrado_por = 'usuarios';
        if($("#filtroRol").is(':checked'))     filtrado_por = 'perfil';
        if($("#filtroGE").is(':checked'))      filtrado_por = 'empresas';

        $.ajax({
            type:'get',
            url :'http://localhost/tabsRoles',
            data: {
                id_usuario  : usuario,
                id_rol      : rol,
                id_empresas : grupo,
                filtro      : filtrado_por
            },
            success : function(data) {
                $("#htmlRoles").html(data);
                Metro.dialog.close('#esperar');
            },
            error : function() { Metro.dialog.close('#esperar'); }

        })

    }
</script>
