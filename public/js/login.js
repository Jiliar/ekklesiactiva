jQuery(document).on('submit', '#form_iniciar_sesion', function(event) {
    event.preventDefault();
    jQuery.ajax({
        url: 'login',
        type: 'POST',
        dataType: 'json',
        data: $(this).serialize(),
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        beforeSend: function() {
            $('#btnLogin').attr('disabled', true);
            $('#btnRegistro').attr('disabled', true);
        }
    })
        .done(function(respuesta) {
            var json = JSON.stringify(respuesta['output']);
            var data = JSON.parse(json);
            if (!respuesta.error) {
                window.open(data['view'], "_self");
            } else {
                $('.error').slideDown('slow');
                setTimeout(function() {
                    $('.error').slideUp('slow');
                }, 3000);
            }
        })
        .fail(function(resp) {
            $('.error').slideDown('slow');
            setTimeout(function() {
                $('.error').slideUp('slow');
            }, 3000);
        })
        .always(function() {
            $('#btnLogin').attr('disabled', false);
            $('#btnRegistro').attr('disabled', false);
        });
});


function registrarUsuario() {

    if($('#condiciones').is(":checked")) {

        var pass = $('#pass').val();
        var repass = $('#repass').val();

        if(pass == repass ){
            if(pass != '' && repass != '') {


                var tipo_id = $('#tipo_id').val().toUpperCase().trim();
                var identificacion = $('#identificacion').val().toUpperCase().trim();
                var nombre1 = $('#nombre1').val().toUpperCase().trim();
                var nombre2 = $('#nombre2').val().toUpperCase().trim();
                var apellido1 = $('#apellido1').val().toUpperCase().trim();
                var apellido2 = $('#apellido2').val().toUpperCase().trim();
                var email = $('#email').val().toLowerCase().trim();

                var flag = false;
                if( tipo_id == '#' || identificacion == '' || nombre1 == ''
                    || apellido1 == '' || apellido1 == '' || email == '' ){
                    flag = true;
                }
                if(email.includes('@')) {
                    if (!flag) {
                        jQuery.ajax({
                            url: 'register',
                            type: 'POST',
                            dataType: 'json',
                            data: {
                                'tipo_id': tipo_id, 'identificacion': identificacion,
                                'nombre1': nombre1, 'nombre2': nombre2, 'apellido1': apellido1,
                                'apellido2': apellido2, 'email': email,'password': pass, 'password_confirmation': repass,
                                'usuario': identificacion, 'inactivo': 0
                            },
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            beforeSend: function () {
                                $('#espere').css('display', 'block');
                                $('#btnLogin').attr('disabled', true);
                                $('#btnRegistro').attr('disabled', true);
                            }
                        })
                            .done(function (respuesta) {
                                var json = JSON.stringify(respuesta['output']);
                                var data = JSON.parse(json);
                                if (!respuesta.error) {
                                    $('#tipo_id').val('#');
                                    $('#identificacion').val('');
                                    $('#nombre1').val('');
                                    $('#nombre2').val('');
                                    $('#apellido1').val('');
                                    $('#apellido2').val('');
                                    $('#email').val('');
                                    $('#pass').val('');
                                    $('#repass').val('');
                                    $("#condiciones").prop("checked", false);
                                    Swal.fire(
                                        '¡Muy Bien!',
                                        'Se ha enviado una notificación de comprobación a su correo electronico, por favor confirme su registro.',
                                        'success'
                                    )
                                } else {
                                    Swal.fire(
                                        '¡Atención!',
                                        data,
                                        'error'
                                    )
                                }
                            })
                            .fail(function (resp) {
                                Swal.fire(
                                    '¡Atención!',
                                    '¡Error en el proceso de registro, consulte al administrador del sistema!',
                                    'error'
                                )
                            })
                            .always(function () {
                                $('#btnLogin').attr('disabled', false);
                                $('#btnRegistro').attr('disabled', false);
                                $('#espere').css('display', 'none');
                            });
                    } else {
                        Swal.fire(
                            '¡Atención!',
                            '¡Por favor debe registrar todos los datos proporcionados en el formulario!',
                            'info'
                        )
                    }
                }else {
                    Swal.fire(
                        '¡Atención!',
                        '¡Por favor verifique correo electronico insertado!',
                        'info'
                    )
                }
            }else{
                Swal.fire(
                    '¡Atención!',
                    '¡Por favor inserte una contraseña valida!',
                    'info'
                )
            }
        }else{
            Swal.fire(
                '¡Atención!',
                '¡Las contraseñas no coinciden, por favor corrija la inconsistencia!',
                'error'
            )
        }
    }else{
        Swal.fire(
            '¡Atención!',
            '¡Para poder registrarse necesitas aceptar terminos y condiciones!',
            'info'
        )
    }
}


function sendEmailReestablecer(){
    var identificacion = $('#identificacion').val();
    var email = $('#email').val();
    if(identificacion != '' && email != ''){
        var formData = new FormData();
        formData.append('identificacion',identificacion);
        formData.append('email', email);

        var request = $.ajax({
            url: 'form_send_reestablecer',
            type: 'POST',
            dataType: 'json',
            data:formData,
            cache:false,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            beforeSend: function() {
                $('#btnReestablecer').attr('disabled',true);
            }
        });

        request.done(function(respuesta) {
            var json = JSON.stringify(respuesta['output']);
            var data = JSON.parse(json);
            if (!respuesta.error) {
                Swal.fire(
                    '¡Muy Bien!',
                    'Te hemos enviado un correo para que puedas reestablecer tu contraseña',
                    'success'
                )
            } else {
                Swal.fire(
                    '¡Atención!',
                    data,
                    'error'
                )
            }
            $('#btnReestablecer').attr('disabled',false);
        });

        request.fail(function(jqXHR, textStatus, errorThrown) {
            let error = "";
            if (jqXHR.status === 0) {
                error = 'Not connect: Verify Network.';
            } else if (jqXHR.status == 404) {
                error = 'Requested page not found [404]';
            } else if (jqXHR.status == 500) {
                error = 'Internal Server Error [500].';
            } else if (textStatus === 'parsererror') {
                error = 'Requested JSON parse failed. '+errorThrown;
            } else if (textStatus === 'timeout') {
                error = 'Time out error.';
            } else if (textStatus === 'abort') {
                error = 'Ajax request aborted.';
            } else {
                error = 'Uncaught Error: ' + jqXHR.responseText;
            }
            showMsgSweet('¡Ha ocurrido un problema!', error, 'error');
        });

        request.always(function(){
            $('#btnReestablecer').attr('disabled',false);
        })
    }
}

function showMsgSweet(title, msg, icon){
    Swal.fire(title, msg, icon);
}

jQuery(document).on('submit', '#form_reset_password', function(event) {
    event.preventDefault();
    var clave = $('#clave').val();
    var reclave = $('#reclave').val();
    if(clave == reclave){
        var id = $('#id').val();

        var formData = new FormData();
        formData.append('id',id);
        formData.append('clave', clave);
        formData.append('reclave', reclave);


        $.ajax({
            url: 'pass',
            type: 'POST',
            dataType: 'json',
            data:formData,
            cache:false,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            beforeSend: function() {
                $('#btnReset').attr('disabled',true);
                $('#btnLogin2').css('disabled',true);
            }
        })

        .done(function(respuesta) {
            var json = JSON.stringify(respuesta['output']);
            var data = JSON.parse(json);
            if (!respuesta.error) {
                Swal.fire( '¡Muy Bien!', data, 'success')
                $('#clave').val('');
                $('#reclave').val('');
                $('#btnReset').attr('disabled',false);
                $('#btnLogin2').attr('disabled',false);
                //$('#btnRegistro2').css('display','block');
            } else {
                Swal.fire('¡Atención!', data, 'error')
            }
        })

        .fail(function(jqXHR, textStatus, errorThrown) {
            let error = "";
            if (jqXHR.status === 0) {
                error = 'Not connect: Verify Network.';
            } else if (jqXHR.status == 404) {
                error = 'Requested page not found [404]';
            } else if (jqXHR.status == 500) {
                error = 'Internal Server Error [500].';
            } else if (textStatus === 'parsererror') {
                error = 'Requested JSON parse failed. '+errorThrown;
            } else if (textStatus === 'timeout') {
                error = 'Time out error.';
            } else if (textStatus === 'abort') {
                error = 'Ajax request aborted.';
            } else {
                error = 'Uncaught Error: ' + jqXHR.responseText;
            }
            showMsgSweet('¡Ha ocurrido un problema!', error, 'error');
        })

        .always(function(){
            $('#btnReset').attr('disabled',false);
            $('#btnLogin2').css('disabled',false);
        })


    }else{
        showMsgSweet('¡Ha ocurrido un problema!', '¡Las contraseñas nos coinciden!', 'error');
    }
});


function openLogin(){
    window.open("http://digitalflyfinance.test/","_self")
}
