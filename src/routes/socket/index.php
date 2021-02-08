<?php

	//---------------------- INCLUSIÓN DE ARCHIVOS ----------------------//


		ini_set("allow_url_fopen", 1);
		$__tme_s = microtime(true);
		$Rt = '../../includes/';
		$__fbsrc = 'ok';
		require($Rt.'inc.php');
		No_Cache();

	//---------------------- INCLUSIÓN DE ARCHIVOS ----------------------//

		$_pml = 'no';
		$__p1 = PrmLnk('rtn', 1, $_pml);
		$__p1_o = PrmLnk('rtn', 1, 'ok');
		$__p2 = PrmLnk('rtn', 2, $_pml);
		$__p2_o = PrmLnk('rtn', 2, 'ok');

		define('GL_CNT', DIR_CNT);

	//---------------------- CONEXIÓN DE API ----------------------//


		if($__p1_o == 'connect'){
			include(GL_CNT.'connect.php');
		}elseif($__p1_o == 'disconnect'){
			include(GL_CNT.'disconnect.php');
		}else{
			$rsp["e"] = "ok";
			$rsp["w"] = "No connect";
		}


		ob_start("cmpr_fm");
		Hdr_JSON();
		if(!isN($rsp)){ echo json_encode($rsp); }
		ob_end_flush();


?>