<!doctype html>
<html lang='es' class='no-js'>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Verificación | Success</title>
<link href="<?php echo DMN_EC; ?>inc/sty/all.css?_t=vrfy" rel="stylesheet" type="text/css">
<base href="/" target="_self">
<meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0" /> 
<body class="<?php if($_vrf_tp == 'success'){ echo '_ok'; }else{ echo '_no'; } ?>">
	
	<figure class="_logo"></figure>
	
	<section class="_wrp">
	
		<?php if($_vrf_tp == 'success'){ ?>
		
			<h1>¡Verificación Exitosa!</h1>
			<p>Ha verificado con éxito una dirección de correo electrónico. Ya puede empezar a enviar correos electrónicos desde esta dirección.</p>
			<h2>¡Gracias por utilizar SUMR!</h2>
		
		<?php }else{?>
			
			<h1>¡Verificación no Exitosa!</h1>
			<p>No se ha podido verificar la dirección de correo electrónico. Intente enviar el link de nuevo.</p>
		
		<?php } ?>	
			
	</section>
	
	<noscript> 
		<div class="_JvRc"> Su navegador NO tiene activo JAVA, puede representar dificultades para navegar </div> 
	</noscript>
</body>
</html> 