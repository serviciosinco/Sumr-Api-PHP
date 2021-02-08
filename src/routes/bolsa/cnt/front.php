<?php  Hdr_HTML(); ob_start("compress_code"); $_txt = GtClTexLng($_GET['lng']); ?>
<!DOCTYPE HTML>
<html lang="es">
	<head>
		<title>Bolsa de Empleo</title>
		<base href="https://empleo.sumr.in/" target="_self">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

		<link rel="icon" href="img/touch-icon-iphone.png" type="image/x-icon" />
		<link rel="apple-touch-icon-precomposed" href="img/touch-icon-iphone.png"/>
		<link rel="apple-touch-icon-precomposed" sizes="72x72" href="img/touch-icon-ipad.png"/>
		<link rel="apple-touch-icon-precomposed" sizes="114x114" href="img/touch-icon-iphone-retina.png"/>
		<link rel="apple-touch-icon-precomposed" sizes="144x144" href="img/touch-icon-ipad-retina.png"/>
		<link rel="apple-touch-startup-image" href="img/ios-startup.png"/>
		<link rel="shortcut icon" sizes="196x196" href="img/icon-chrome-196.png"/>
		<link rel="shortcut icon" sizes="128x128" href="img/icon-chrome-128.png"/>
		<meta name="apple-mobile-web-app-status-bar-style" content="black">
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="mobile-web-app-capable" content="yes">


	</head>
	<body>
		<header>
			<div class="wrap">
				<div class="ac">Logo Cliente</div>
				<div class="logo">Logo Sistema</div>
			</div>
		</header>
		<section>
			<div class="wrap">
				<div class="content">
					<div class="slider">Slider</div>


					<div class="options">
						<div class="registered">
							<h2>Ya registré <span>mi hoja de vida</span></h2>
							<form>
								<ul>
									<li><?php echo HTML_inp_tx('us_email', 'e-mail', '', FMRQD); ?> </li>
									<li><?php echo HTML_inp_tx('us_email', 'clave', '', FMRQD); ?></li>
									<li><button id="entergo">Entrar</button></li>
								</ul>
							</form>

						</div>
						<div class="registerto">
							<h2>Registrar <span>hoja de vida</span></h2>
							<form>
								<ul>
									<li><?php echo HTML_inp_tx('us_doc', 'documento', '', FMRQD_NM); ?> </li>
									<li><button id="registergo">Registrar</button></li>
								</ul>
							</form>
						</div>
					</div>



				</div>
			</div>
		</section>
		<footer>

		</footer>


	</body>
</html>
<script src="https://code.jquery.com/jquery-1.11.1.min.js"></script>
<script src="<?php echo DMN_JS; ?>jquery.validate.js"></script>
<script src="<?php echo DMN_JS; ?>jquery.form.js"></script>
<script src="<?php echo DMN_JS; ?>jquery.mCustomScrollbar.js"></script>
<script src="<?php echo DMN_JS; ?>jquery.mousewheel.js"></script>
<link rel=stylesheet href="css/all.css" type="text/css" media=screen>
<?php

	echo CntJQ($CntJV, 'ok').CntJQ($CntWb);
?>
<?php ob_end_flush();