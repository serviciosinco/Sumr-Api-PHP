<?php

	//---------------------- INCLUSIÓN DE ARCHIVOS ----------------------//


		ini_set("allow_url_fopen", 1);
		$__tme_s = microtime(true);
		$Rt = '../../includes/';
		$__https_off = 'off';
		$__no_sbdmn = 'ok';
		$__bdfrnt = 'ok';

		require($Rt.'inc.php');
		No_Cache();

	//---------------------- INCLUSIÓN DE ARCHIVOS ----------------------//


		$__p1_o = PrmLnk('rtn', 1, 'ok'); // Account
		$__p2_o = PrmLnk('rtn', 2, 'ok'); // Country
		$__p3_o = PrmLnk('rtn', 3, 'ok'); // Sort
		$__p4_o = PrmLnk('rtn', 4, 'ok'); // Section
		$__p5_o = PrmLnk('rtn', 5, 'ok'); // File


	//---------------------- INICIA PROCESAMIENTO ----------------------//


		if(!isN($__p1_o)){

			$__dt_cl = __Cl([ 'id'=>$__p1_o, 't'=>'sbd' ]);

			if(!isN($__dt_cl->sbd)){

				$__dt_sort = GtSortDt([ 'id'=>$__p2_o, 't'=>'pml' ]);

				if($__p3_o == 'process'){
					include(DIR_CNT.'prc.php');
				}else{
					include(DIR_CNT.'html.php');
				}

			}

		}else{

			$rsp['w'] = 'Debe ser conexión segura (https)';

		}


?>