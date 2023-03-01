<!DOCTYPE html>
<html lang="es">  
  <head>    
    <title>Curriculum Vitae {{$nombre_completo}}</title>    
    <meta charset="UTF-8">
    <meta name="title" content="Título de la WEB">
    <meta name="description" content="Descripción de la WEB">    
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <link href="{{ asset('cv/assets/css/index.css')}}" rel="stylesheet" type="text/css"/>
  </head>  
  <body>    
    <header>
      <table style='background-color:#00B5BA;'>
		<tr>
			<td style='width: 20% !important;' class='header-persona'><img alt='imagen' src="{{$imagen}}" class='imagen-persona'/></td>
			<td style='width: 40% !important;' class='header-persona'>
				<div class='titulo-persona'>{{$nombre_completo}}</div>
				<div class='direccion-persona'>
					<div class='header-body' style='padding-top: 10px;'><strong>Dirección: </strong>{{$direccion}}</div>
					<div class='header-body'><strong>Email: </strong>{{$email}}</div>
					<div class='header-body'><strong>Telefono: </strong>{{$telefono}}</div>
				</div>
			</td>
			<td style='width: 40% !important;' class='header-persona'>
				@if ($linkedin != '' && $linkedin != null)
				<div>
					<table><tr>
						<td><img src='{{ asset('cv/assets/icons/linkedin.png')}}' alt="LinkedIn" /> </td>
						<td class='header-social'><a href='{{$linkedin}}' target='_blank' class='social-network'>Linked In</a></td>
					</tr></table>
				</div>
				@endif
				@if ($facebook != '' && $facebook != null)
					<div>
						<table><tr>
							<td><img src='{{ asset('cv/assets/icons/facebook.png')}}' alt="Facebook" /> </td>
							<td class='header-social'><a href='{{$facebook}}' target='_blank' class='social-network'>Facebook</a></td>
						</tr></table>
					</div>
				@endif
				@if ($twitter != '' && $twitter != null)
					<div>
						<table><tr>
							<td><img src='{{ asset('cv/assets/icons/twitter.png')}}' alt="Twitter" /> </td>
							<td class='header-social'><a href='{{$twitter}}' target='_blank' class='social-network'>Twitter</a></td>
						</tr></table>
					</div>
				@endif
			</td>
		</tr>	
	  </table>  
    </header>   

    <section>
					@if ($resumen != '' && $resumen != null)
					<div class='titulo-seccion'>
						<table><tr>
							<td><img src='{{ asset('cv/assets/icons/check.png')}}' alt="check" style='width:20px;'/> </td>
							<td class='titulo-seccion'>RESUMEN</td>
						</tr></table>
					</div>
					<hr/>
						<div class ='argumentos' style='font-size: 12px;'>
							{{$resumen}}
						</div>
					@endif
					@if ($experiencias != '' && $experiencias != null)
					<table><tr>
						<td><img src='{{ asset('cv/assets/icons/check.png')}}' alt="check" style='width:20px;'/> </td>
						<td class='titulo-seccion'>EXPERIENCIAS LABORALES</td>
					</tr></table>
					<hr/>
						<div class ='argumentos'>
							<?=$experiencias ?>
						</div>
					@endif
					@if ($educacion != '' && $educacion != null)
						<table><tr>
							<td><img src='{{ asset('cv/assets/icons/check.png')}}' alt="check" style='width:20px;'/> </td>
							<td class='titulo-seccion'>EDUCACIÓN</td>
						</tr></table>
						<hr/>	
						<div class ='argumentos'>
							<?=$educacion ?>
						</div>
					@endif
					@if (trim($menciones) != '' && trim($menciones) != null)
					<table><tr>
						<td><img src='{{ asset('cv/assets/icons/check.png')}}' alt="check" style='width:20px;'/> </td>
						<td class='titulo-seccion'>MENCIONES Y PROYECTOS</td>
					</tr></table>
					<hr/>
						<div class ='argumentos'>
							<?=$menciones ?>
						</div>
					@endif
					@if (trim($habilidades) != '' && trim($habilidades) != null)
						<table><tr>
							<td><img src='{{ asset('cv/assets/icons/check.png')}}' alt="check" style='width:20px;'/> </td>
							<td class='titulo-seccion'>HABILIDADES</td>
						</tr></table>
						<hr/>
						<div class ='argumentos'>
							<?=$habilidades ?>
						</div>
					@endif
					@if (trim($idiomas) != '' && trim($idiomas) != null)
					<table><tr>
						<td><img src='{{ asset('cv/assets/icons/check.png')}}' alt="check" style='width:20px;'/> </td>
						<td class='titulo-seccion'>IDIOMAS</td>
					</tr></table>
					<hr/>
					<div class ='argumentos'>
						<?=$idiomas ?>
					</div>
					@endif
					@if (trim($intereses) != '' && trim($intereses) != null)
						<table><tr>
							<td><img src='{{ asset('cv/assets/icons/check.png')}}' alt="check" style='width:20px;'/> </td>
							<td class='titulo-seccion'>INTERESES</td>
						</tr></table>
						<hr/>
						<div class ='argumentos' style = 'text-align:center !important;'>
							<?=$intereses ?>
						</div>
					@endif

	</section>    

  </body>  
</html>


