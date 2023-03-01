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
      <!--Sweet Alert-->
      <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.2/dist/sweetalert2.all.min.js"></script>
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
      <script src="{{ asset('vendors/jquery/jquery-3.4.1.js')}}"></script>
     <script src="{{ asset('js/login.js')}}"></script>
    <title>Reset Usuario</title>
  </head>
  <body>
  @php
  $data = explode("/",trim($_SERVER['REQUEST_URI']));
  $data = explode("=",$data[2]);
  $id = null;
  if($data[0] == 'xid'){
      $id = $data[1];
  }
  @endphp
   <section class="contact-box">
       <div class="row no-gutters bg-dark">
           <div class="col-xl-5 col-lg-12 register-bg">
               <div class="position-absolute logo p-4">
                <img src="{{ asset('images/ekklesia-logo-3.png')}}" alt="" style="width:100%;"/>
               </div>
                <div class="position-absolute testiomonial p-4">
                    <h3 class="font-weight-bold text-light">Estamos comprometidos...</h3>
                    <p class="lead text-light">Ayudamos a formar ciudadanos y comunidades conscientes y participativas.</p>
                </div>
           </div>
           <div class="col-xl-7 col-lg-12 d-flex" style="background: #7cb4ea!important;">
                <div id='form-container' class="container align-self-center p-6">
                    <h1 class="font-weight-bold mb-3" id='title-form' style="padding:60px 0px 0px 0px;">Reestablecer Contraseña</h1>
                    <p class="text-muted mb-5" style="padding:10px 0px 30px 0px;">Ingresa tus nuevas credenciales.</p>
                    <div class="error">Favor verifique las credenciales proporcionadas</div>
                    <form action="{{ asset('reset') }}" method="post" id="form_reset_password">
                        @csrf
                            <input type="hidden" value="{{$id}}" id="id" />
                            <div class="form-group col-md-12">
                                <label class="font-weight-bold">Contraseña <span class="text-danger">*</span></label>
                                <input type="password" name="clave" id="clave" class="form-control" placeholder="Ingresa una contraseña"
                                       pattern="[A-Za-z][A-Za-z0-9]*[0-9][A-Za-z0-9]*"
                                       title="¡La contraseña debe empezar con una letra y contener al menos un dígito!" required>
                            </div>
                        <div class="form-group col-md-12">
                            <label class="font-weight-bold">Repita Contraseña <span class="text-danger">*</span></label>
                            <input type="password" name="reclave" id="reclave" class="form-control" placeholder="Repita la contraseña digitada"
                                   pattern="[A-Za-z][A-Za-z0-9]*[0-9][A-Za-z0-9]*"
                                   title="¡La contraseña debe empezar con una letra y contener al menos un dígito!" required>
                        </div>

                        <div class="form-group col-md-12" style="text-align: center; padding:60px 0px 60px 0px;">
                            <button id='btnReset' type='submit' class="btn btn-primary width-100" style="margin:10px;" >Reset</button>
                            <button id='btnLogin2' type='button' class="btn btn-primary width-100" style="margin:10px;" onclick="openLogin()" disabled>Inicio Sesión</button>
                            <!--<button id='btnRegistro2' type='button' class="btn btn-primary width-100" style="margin:10px; display:none;">Regístrate</button>-->
                        </div>
                    </form>
                    <small class="d-inline-block text-muted mt-5">Todos los derechos reservados | © 2023 EkkleasiActiva</small>
                </div>
           </div>
       </div>
   </section>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  </body>
</html>
