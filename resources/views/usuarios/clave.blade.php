<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <link rel="stylesheet" href="{{ asset('vendors/metro4/css/metro-all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
    <link rel="shortcut icon" href="{{ asset('images/favicon.png')}}" type="image/x-icon">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<style>
    .main { width : 200px }
</style>

<body class="m4-cloak h-vh-100" style="background: white; color: black">
    <br><br>
    <center>
        <div class='main'>
            <span class="mif-lock mif-6x fg-red"></span> <br><br>
            <input id='actual' type="password" data-role="materialinput" data-label="Contraseña Actual" data-informer="Ingrese su contraseña actual" placeholder="Contraseña Actual" ><br>
            <input id='nueva' type="password" data-role="materialinput" data-label="Nueva contraseña" data-informer="Ingrese su  nueva contraseña" placeholder="Nueva contraseña"><br>
            <input id='confirma' type="password" data-role="materialinput" data-label="Confirmacion" data-informer="Repita su nueva contraseña" placeholder="Nueva contraseña"><br><br><br>
            <button class="button alert outline" id="cambiar">Cambiar Ahora &nbsp;&nbsp;<span class="mif-checkmark"></span></button>
        </div>
    </center>
</body>
</html>

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
    $("#cambiar").click(function(){
        actual = $("#actual").val();
        nueva  = $("#nueva").val();
        confirma = $("#confirma").val();
        datosOk = true;
        mensaje = '';

        if(nueva != confirma ) { datosOk = false; mensaje += '- No coinciden las contraseñas\n';  }
        if(actual == '' || nueva == '' || confirma == '') { datosOk = false; mensaje += '- Las contraseñas no pueden ser nulas\n';  }

        if(!datosOk) {
            alert('CAMBIO DE CABLE FALLIDA\n\nPor favor verifique lo siguiente :\n'+mensaje);
        } else {
            $.ajax({
                type:"get",
                 url:"{{asset('/changePassword')}}",
                 data: {
                    p_actual: actual,
                    p_nueva : nueva
                 },
                 success : function(data) {
                    if(data[0] == 0) {
                        $("#actual").val('');
                        $("#actual").focus();
                    } else {
                        $("#actual").val('');
                        $("#nueva").val('');
                        $("#confirma").val('');
                        $("#actual").focus();
                    }
                    alert(data[1]);
                 },
                 error : function() {
                     alert('ERROR EN TRANSACCION\n\nNo se pudo realizar la operacion');
                 }
            })
        }

    });
</script>
