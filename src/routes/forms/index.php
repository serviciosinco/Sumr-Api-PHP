<?php include('includes/inc.php'); ob_start('compress_code'); Hdr_HTML([ 'cche'=>'ok' ]); ?>
<!DOCTYPE HTML>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<title></title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<base href="/" target="_blank">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<link rel="icon" href="https://img.[DOMAIN]/estr/favicon.ico" type="image/x-icon">
		<link rel="preconnect" href="https://js.[DOMAIN]" />
		<link rel="preconnect" href="https://css.[DOMAIN]" />
		<link rel="preconnect" href="https://img.[DOMAIN]" />
		<style>
			<?php include('includes/css/hd.css'); ?>
		</style>
	</head>
	<body class="SUMR_Form">
		<header>
			<nav><ul><li></li></ul></nav>
		</header>
		<section class="sumr-cnt">
			<div class="_prld _anm"></div>
		</section>
		<footer></footer>
	</body>
</html>
<script type="text/javascript">

	"use strict";

	var SUMR_Main={slc:{ sch:''}};

	function __ld_all(){
		SUMR_Ld.f.js({
			t:'c',
			u:'sb/fm/main.js',
			c:function(){
				SUMR_Fm.f.init();
			}
		});
	}

</script>
<script type="text/javascript" src="https://js.[DOMAIN]/_ld.js?__r=<?php if(!Dvlpr()){ echo E_TAG; }else{ echo Enc_Rnd('r'); } ?>" async></script>
<?php ob_end_flush(); ?>