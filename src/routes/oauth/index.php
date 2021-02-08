<?php

	$_cls_gapi = 'ok'; $__fbsrc = 'ok'; $__twsrc = 'ok'; $__inssrc = 'ok'; $__insslnkd = 'ok'; $__bdfrnt = 'ok'; header("Access-Control-Allow-Origin: *");

	//$___bug = 'ok';

	include('../../includes/inc.php');

	$__Oauth = new CRM_Oauth();
	$__Thrd = new CRM_Thrd();
	$__Eml = new CRM_Eml();

	//---------------------- GROUP LIST ----------------------//

		define('CNT', 'cnt/');
		define('CNT_GOOGLE', CNT.'google/');
		define('CNT_GOOGLE_HTML', CNT_GOOGLE.'html/');

	//---------------------- VARIABLES PERMA ----------------------//

		$__pm1 = PrmLnk('rtn', 1, 'ok');

	//---------------------- GET VARS ----------------------//

		$__code = Php_Ls_Cln($_GET['code']);
		$__cl = Php_Ls_Cln($_GET['_cl']);
		$__us = Php_Ls_Cln($_GET['_us']);
		$__eml = Php_Ls_Cln($_GET['_eml']);
		$__scl = Php_Ls_Cln($_GET['_scl']);
		$__scc = Php_Ls_Cln($_GET['success']);
		$__err = Php_Ls_Cln($_GET['_error']);
		$__err_m = Php_Ls_Cln($_GET['_error_m']);
		$__tp = Php_Ls_Cln($_GET['_tp']);
		$__lgin = Php_Ls_Cln($_GET['_lgin']);

		$__Oauth->_strt();


	if(!isN($__lgin)){ $_SESSION['oauth']['login'] = $__lgin; }
	if($__pm1 != '' && $__pm1 != 'index.php'){ $_SESSION['oauth']['type'] = $__pm1; }
	if(isset($_SESSION['oauth']['type'])){ $__pm1_o = $_SESSION['oauth']['type']; }

	if($__pm1 == 'google' || $__pm1_o == 'google'){

		if($__scc != 'ok'){ $__to_inc_ophp = 'google.php'; }else{ $__to_inc = 'google.php'; }

	}elseif($__pm1 == 'microsoft'){

		if($__scc != 'ok' && isN($__err)){ $__to_inc_ophp = 'microsoft.php'; }else{ $__to_inc = 'microsoft.php'; }

	}elseif($__pm1 == 'twitter'){

		$__to_inc = 'twitter.php';

	}elseif($__pm1 == 'facebook'){

		if(!isN($__scc)){
			$__to_inc = 'facebook.php';
		}else{
			$__to_inc_ophp = 'facebook.php';
		}

	}elseif($__pm1 == 'instagram'){

		$__to_inc = 'instagram.php';

	}elseif($__pm1 == 'linkedin'){

		$__to_inc = 'linkedin.php';

	}elseif($__pm1 == 'timedoctor'){

		$__to_inc = 'timedoctor.php';

	}


	$CntJV .= 'document.domain = "'.DMN_S.'"; window.opener.postMessage('.json_encode($_GET).', \'*\'); ';


if(!isN($__to_inc_ophp)){

	include( CNT.$__to_inc_ophp );

}elseif(!isN($__to_inc) || !isN($__err)){ ?>
	<?php ob_start("compress_code"); ?>
		<!DOCTYPE html>
		<html lang='es'>
		<head>
		    <title></title>
		</head>
		<body>
			<?php
				if($__to_inc != ''){ include(CNT.$__to_inc); }
				if(!isN($CntJV)){ echo CntJQ($CntJV, 'ok'); }
			?>
			<div class="_logo"></div>
			<div class="_cont">


				<div class="_cont_wrp">

					<?php if($__err == 'ok'){ ?>
						<h1 class="_hdr"><?php if(!isN($__err_tt)){ echo $__err_tt; }else{ echo 'Error en la conexión'; } ?></h1>
						<div class="_txt"><?php if(!isN($__err_dsc)){ echo $__err_dsc; }else{ echo 'Intenta de nuevo<br> desde la ventana de la aplicación'; } ?></div>
						<button onclick="window.close();">Cerrar</button>
					<?php }else{ ?>
						<h1 class="_hdr">Conexión Establecida</h1>
						<div class="_txt">La ventana se va a<br> cerrar en un instante...</div>
						<button onclick="window.close();">Cerrar</button>
					<?php } ?>

				</div>


			</div>
			<div class="_bck"></div>

			<link href="https://fonts.googleapis.com/css?family=Economica|Roboto" rel="stylesheet">
			<style>
				*{ font-family: 'Roboto'; box-sizing: border-box; }
				body{ background-color:#9bebff; padding: 0; margin: 0;  }
				h1,h2,h3,h4{ font-family: 'Economica'; text-align: center; }
				._bck{ background-image:url('<?php echo DMN_IMG_ESTR_SVG ?>api_bck.svg'); background-repeat: no-repeat; background-position: center bottom; background-size: 500px auto; width: 100%; height: 100%; position: absolute; z-index: 1; left: 0; top:0; }
				._logo{ background-image:url(<?php echo DMN_IMG_ESTR.LOGO_MAIN; ?>); background-repeat: no-repeat; background-position: center bottom; background-size: 120px auto; width: 200px; height: 100px; margin-left: auto; margin-right: auto; display: block; }
				._cont{ position: fixed; top: 140px; width: 100%; height: 80%; z-index: 10; }
				._cont ._cont_wrp{ background-color: rgba(255, 255, 255, 0.8); max-width: 400px; width: 80%; min-height: 200px; margin-bottom: 100px; display: block; border-radius:10px; -moz-border-radius:10px; -webkit-border-radius:10px; margin-left: auto; margin-right: auto; padding: 20px;  }
				._cont ._cont_wrp ._txt{ font-size: 14px; text-align: center; }
				._cont ._cont_wrp button{ background-color: #121212; color: #ffffff; text-align: center; border: none; padding: 10px 15px; border-radius:10px; -moz-border-radius:10px; -webkit-border-radius:10px; margin-left: auto; margin-right: auto; display: block; font-family: 'Economica'; font-size: 14px; text-transform: uppercase; margin-top: 20px; cursor:pointer; }

			</style>
		</body>
		</html>
	<?php ob_end_flush(); ?>

<?php } ?>