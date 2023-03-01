<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <link rel="stylesheet"    href="{{ asset('vendors/metro4/css/metro-all.css')}}">
    <link rel="stylesheet" href="css/custom.css">
    <link rel="shortcut icon" href="{{ asset('images/favicon.png')}}" type="image/x-icon">
  </head>
  <body>
    <form id="form_iniciar_sesion" action="{{ asset('login') }}" method="post">
        @csrf
        <center>
            <div id='login' >
                <img src="{{asset('images/traso-logo.png')}}" alt="" style='padding: 10px 10px;'>
                <br>
                <h4>Inicio de Sesion</h4>
                <div id='interno' class="bg-darkPurple">
                    Usuario <br>
                    <input type="text" name="usuario" id="usuario" class='form-control' autofocus required> <br>
                    Contraseña <br>
                    <input type="password" name="clave" class='form-control' required><br><br>
                </div><br>
                @if(isset($mensaje))
                    @if($mensaje != '')
                    <div class="bg-red fg-white" style="padding: 15px 15px; margin: 10px 10px; border-radius: 10px 10px">
                        <span class="mif-warning mif-5x"></span><br>
                        <h5>Acceso Denegado.</h5>
                        {{$mensaje}}
                    </div>
                    @endif
                @endif
                <button id='boton-login' class="button shadowed">Conectar &nbsp; <span class="mif-checkmark"></span></button>
                <br>
                <p style='font-size: 9pt; color: #191842' id='info-login'>
                    <b><a id='enlace' onclick='resetPassword()' style="text-decoration: none; color:#191842">Se me olvido la clave</a></b><br><br>
                    Proyecto de Becas - Colectivo Traso <br>
                    <a href="https://colectivotraso.org/" target='_blank' style="text-decoration: none; color:#191842">www.colectivotraso.org</a><br>
                    2.021 ::. Ver 1.0.0
                </p>
                <br>
            </div>
        </center>
    </form>
    <script src="vendors/metro4/js/metro.js"></script>

<div class="dialog" data-role="dialog" id="confirmar">
    <div class="dialog-title">Confirmacion Requerida</div>
    <div class="dialog-content">
        A continuacion se enviara a su correo una clave temporal, si esta seguro hagla click en <b>Reestablecer ahora</b>
    </div>
    <div class="dialog-actions">
        <button class="button alert outline js-dialog-close" onclick="confirmaResetPassword()">
            <span class="mif-refresh"></span>&nbsp;Reestablecer ahora
        </button>
        <button class="button js-dialog-close">Cerrar</button>
    </div>
</div>
  </body>
</html>

<script>
    function resetPassword() {
        if($("#usuario").val()== ''){
            Metro.infobox.create("<h5>Usuario Requerido</h5><p>Por favor esriba su usuario</p>");
        } else
            Metro.dialog.open("#confirmar");
    }

    function confirmaResetPassword() {
        $.ajax({
            type:'get',
            url : 'http://localhost/resetPassword/'+$("#usuario").val(),
            success : function(data) {
                Metro.infobox.create("<h5>Informacion</h5><p>"+data+"</p>");
            }
        })
    }
</script>
