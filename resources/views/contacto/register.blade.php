<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,700&display=swap" rel="stylesheet">
    <link href="https://unpkg.com/ionicons@4.5.10-0/dist/css/ionicons.min.css" rel="stylesheet">
    <link href="{{ asset('contactos/assets/style.css')}}" rel="stylesheet">

      <link rel="shortcut icon" href="{{ asset('images/favicon.png')}}" type="image/x-icon">
      <script src="{{ asset('vendors/jquery/jquery-3.4.1.js')}}"></script>
      <script src="{{ asset('js/login.js')}}"></script>
    <title>Formulario de Registro</title>
  </head>
  <body>
   <section class="contact-box">
       <div class="row no-gutters bg-dark">
           <div class="col-xl-5 col-lg-12 register2-bg">
               <div class="position-absolute logo p-4">
                   <img src="{{ asset('images/ekklesia-logo-3.png')}}" alt="" style="width:100%;"/>
               </div>
           </div>
           <div class="col-xl-7 col-lg-6 d-flex" style="background: #7cb4ea !important;">
                <div id='form-container' class="container align-self-center p-6">
                    <h1 class="font-weight-bold mb-3" id='title-form'>Crea tu cuenta</h1>
                    <p class="text-muted mb-5">Ingresa la siguiente información para registrarte.</p>

                    <form id="form_registrar_usuario" autocomplete="off">
                        <div class="form-row mb-12">
                            <div class="form-group col-md-4">
                                <label for="tipo_id" class="font-weight-bold">Tipo Identificación</label>
                                <select class="form-control" id="tipo_id">
                                <option value="#" autocomplete="off">Seleccione opción</option>
                                    @foreach ($tipos_id as $tipo)
                                        <option value="{{ $tipo->id }}">{{ $tipo->codigo." - ".$tipo->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label class="font-weight-bold">Identificación <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="identificacion" placeholder="Ingresa tu identificación" autocomplete="off">
                            </div>
                            <div class="form-group col-md-4">
                                <label class="font-weight-bold">Primer Nombre <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="nombre1" placeholder="Ingresa tu primer nombre" autocomplete="off">
                            </div>
                            <div class="form-group col-md-4">
                                <label class="font-weight-bold">Segundo Nombre <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="nombre2" placeholder="Ingresa tu segundo nombre">
                            </div>
                            <div class="form-group col-md-4">
                                <label class="font-weight-bold">Primer Apellido <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="apellido1" placeholder="Ingresa tu primer apellido" autocomplete="off">
                            </div>
                            <div class="form-group col-md-4">
                                <label class="font-weight-bold">Segundo Apellido <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="apellido2" placeholder="Ingresa tu segundo apellido" autocomplete="off">
                            </div>

                        <div class="form-group col-md-4">
                            <label class="font-weight-bold">Correo electrónico <span class="text-danger">*</span></label>
                            <input type="email" class="form-control" id="email" placeholder="Ingresa tu correo electrónico" autocomplete="off">
                        </div>
                        <div class="form-group col-md-4">
                            <label class="font-weight-bold">Contraseña <span class="text-danger">*</span></label>
                            <input type="password" class="form-control" id="pass" placeholder="Ingresa una contraseña" autocomplete="off">
                        </div>
                         <div class="form-group col-md-4">
                            <label class="font-weight-bold">Repita Contraseña <span class="text-danger">*</span></label>
                            <input type="password" class="form-control" id="repass" placeholder="Ingresa una contraseña" autocomplete="off">
                        </div>
                        </div>
                        <div class="form-group mb-5">
                            <div class="form-check">
                                <input id='condiciones' class="form-check-input" type="checkbox">
                                <a href="javascript:void(0)" data-toggle="modal" data-target="#exampleModalCenter" style="cursor: pointer;">
                                <label class="form-check-label text-muted" style="cursor: pointer;">Al seleccionar esta casilla aceptas nuestro aviso de privacidad de los datos</label>
                                </a>
                            </div>
                        </div>
                        <div id="espere" style="text-align: center; color:white; display:none;">
                            Espere por favor...
                        </div>
                        <div class="form-group col-md-12" style="text-align: center;">
                            <button type='button' id='btnRegistro' class="btn btn-primary width-100" style="margin:10px;" onclick="registrarUsuario()">Regístrate</button>
                            <a href="login">
                            <button type='button' id='btnLogin' class="btn btn-primary width-100" style="margin:10px;">Inicio Sesión</button>
                            </a>
                        </div>
                    </form>
                    <small class="d-inline-block text-muted mt-5">Todos los derechos reservados | © 2023 EkkleasiActiva</small>
                </div>
           </div>
       </div>

       <!-- Modal -->
       <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" class="col-xl-12">
           <div class="modal-dialog modal-dialog-top" style="max-width: 80%;" role="document">
               <div class="modal-content">
                   <div class="modal-header">
                       <h5 class="modal-title" id="exampleModalLongTitle" style="color:#7cb4ea;">Clausula de privacidad de la información</h5>
                       <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                           <span aria-hidden="true">&times;</span>
                       </button>
                   </div>
                   <div class="modal-body">
                       <iframe src="http://docs.google.com/gview?url=http://www.educoas.org/portal/bdigital/contenido/valzacchi/ValzacchiCapitulo-2New.pdf&embedded=true" style="width:100%; height:700px;" frameborder="0" ></iframe>
                   </div>
               </div>
           </div>
       </div>

       <script type="text/javascript">
           $(document).ready(function(){
               $('#myModal').on('shown.bs.modal', function () {
                   $('#myInput').trigger('focus')
               })
           });
        </script>
   </section>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
   <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.2/dist/sweetalert2.all.min.js"></script>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
  </body>
</html>
