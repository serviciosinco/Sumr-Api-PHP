<?php

	//---------------------- INCLUSIÓN DE ARCHIVOS ----------------------//

		$__bdfrnt = 'ok';
		ini_set("allow_url_fopen", 1);
		$Rt = '../../includes/';
		require($Rt.'inc.php');
		ob_start("compress_code");
		No_Cache();

	//---------------------- INCLUSIÓN DE ARCHIVOS ----------------------//

		$__p1_o = PrmLnk('rtn', 1, 'ok');
		$__p1_g = PrmLnk('rtn', 1);
		$__p2_o = PrmLnk('rtn', 2, 'ok');
		$__p2_g = PrmLnk('rtn', 2);
		$__p3_o = PrmLnk('rtn', 3, 'ok');
		$__p3_g = PrmLnk('rtn', 3);

	//---------------------- INICIA PROCESAMIENTO ----------------------//

		header("access-control-allow-origin: *");

		if(!isN($__p2_g)){
			include(DIR_CNT.$__p2_g.'.php');
		}elseif(!isN($__p2_o)){
			include(DIR_CNT.$__p2_o.'.php');
		}else{
			include(DIR_CNT.'d1.php');
		}

		ob_end_flush();
?>