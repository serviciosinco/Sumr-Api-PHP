<?php


	//---------------------- INCLUSIÓN DE ARCHIVOS ----------------------//

		ini_set("allow_url_fopen", 1);
		$__tme_s = microtime(true);
		$Rt = '../../includes/';
		require($Rt.'inc.php');
		require('_cls.php');

		Hdr_HTML();
		ob_start("cmpr_fm");


	//---------------------- VARIABLES GET ----------------------//

		$__t = Php_Ls_Cln($_GET['_t']);


	//---------------------- INCLUSIÓN DE ARCHIVOS ----------------------//



		if($__t == 'nav'){
			$___to_inc = 'nav.php';
		}



	//---------------------- COMPRIME E INCLUYE CONTENIDO --------------//

		if(!isN($___to_inc)){ include($___to_inc); }

		ob_end_flush(); }


?>