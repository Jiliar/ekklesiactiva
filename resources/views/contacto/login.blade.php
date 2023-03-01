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
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"
            integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ=="
            crossorigin="anonymous" referrerpolicy="no-referrer" />
     <link rel="shortcut icon" href="{{ asset('images/favicon.png')}}" type="image/x-icon">
      <!--Sweet Alert-->
      <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.2/dist/sweetalert2.all.min.js"></script>
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
      <script src="{{ asset('vendors/jquery/jquery-3.4.1.js')}}"></script>
     <script src="{{ asset('js/login.js')}}"></script>
    <title>Inicio Sesión</title>
  </head>
  <body>
   <section class="contact-box">
       <div class="row no-gutters bg-dark">
           <div class="col-xl-5 col-lg-12 register-bg">
               <div class="position-absolute logo p-4">
                <img src="{{ asset('images/ekklesia-logo-3.png')}}" alt="" style="width:100%;"/>
               </div>
               {{--  <div class="position-absolute testiomonial p-4">
                    <h3 class="font-weight-bold text-light" style="color:gray;">Estamos comprometidos...</h3>
                    <p class="lead text-light" style="color:gray;">Ayudamos a formar ciudadanos y comunidades conscientes y participativas.</p>
                </div> --}}
           </div>
           <div class="col-xl-7 col-lg-12 d-flex" style="background: #7cb4ea !important;">
                <div id='form-container' class="container align-self-center p-6">
                    <h1 class="font-weight-bold mb-3" id='title-form' style="padding:60px 0px 0px 0px;">Iniciar Sesión</h1>
                    <p class="text-muted mb-5" style="padding:10px 0px 30px 0px;">Ingresa tus datos de usuario.</p>
                    <div class="error">Favor verifique las credenciales proporcionadas</div>
                    <form action="{{ asset('login') }}" method="post" id="form_iniciar_sesion">
                        @csrf
                            <div class="form-group col-md-12">
                                <label class="font-weight-bold">Usuario <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="usuario" id="usuario" placeholder="Ingrese usuario">
                            </div>
                        <div class="form-group col-md-12">
                            <label class="font-weight-bold">Contraseña <span class="text-danger">*</span></label>
                            <input type="password" name="clave" id="clave" class="form-control" placeholder="Ingresa una contraseña">
                        </div>

                        <div class="form-group col-md-12" style="text-align: center;" id='info-login'>
                            <a id='enlace' href="javascript:void(0)" data-toggle="modal" data-target="#exampleModalCenter"
                               style="cursor: pointer; color: #9a9393 !important; text-decoration: none;">¿Se me olvido la clave?</a>
                        </div>
                        <div class="form-group col-md-12" style="text-align: center; padding:60px 0px 60px 0px;">
                            <button id='btnLogin' type='submit' class="btn btn-primary width-100" style="margin:10px;">Inicio Sesión</button>
                            <a href="register">
                                <button id='btnRegistro' type='button' class="btn btn-primary width-100" style="margin:10px;">Regístrate</button>
                            </a>
                        </div>
                    </form>
                    <small class="d-inline-block text-muted mt-5">Todos los derechos reservados | © 2023 EkkleasiActiva</small>
                </div>
           </div>
       </div>

       <!-- Modal -->
       <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" class="col-xl-12">
           <div class="modal-dialog modal-dialog-top col-sm-12 col-md-12 col-lg-8 col-xl-8" role="document">
               <div class="modal-content">
                   <div class="modal-header" style="background: #7cb4ea; ">
                       <h5 class="modal-title" id="exampleModalLongTitle" style="color:#939393;">Reestablecimiento de contraseña</h5>
                       <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                           <span aria-hidden="true">&times;</span>
                       </button>
                   </div>
                   <div class="modal-body" style="background: #ffffff;">
                       <div class="form-group col-md-12 text-center" style="margin-top:50px;">
                           <i class="fas fa-key" style="font-size: 150px; color: #7cb4ea;"></i>
                           <p style="margin-top:20px; color: #7cb4ea;">Registra los datos sugeridos</p>
                       </div>
                       <div class="form-group col-md-12 text-center" style="margin-top:50px; display:none;">
                           <i class="fas fa-smile" style="font-size: 150px; color: #7cb4ea;"></i>
                           <p style="margin-top:20px; color: #7cb4ea;">Te hemos enviado un email ¡Revisalo!</p>
                       </div>
                       <div class="form-group col-md-12">
                           <label class="font-weight-bold">Identificación <span class="text-danger">*</span></label>
                           <input type="text" class="form-control" name="identificacion" id="identificacion" placeholder="Ingrese Identificación">
                       </div>
                       <div class="form-group col-md-12">
                           <label class="font-weight-bold">Correo electronico <span class="text-danger">*</span></label>
                           <input type="email" class="form-control" name="email" id="email" placeholder="Ingrese correo electronico">
                       </div>
                       <div class="form-group col-md-12" style="text-align: center;">
                           <button id='btnReestablecer' type='button' class="btn btn-primary width-100" onclick="sendEmailReestablecer()" style="margin:10px;">Reestablecer</button>
                       </div>
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
  </body>
</html>
