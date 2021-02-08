<?php

	//---------------------- INCLUSIÓN DE ARCHIVOS ----------------------//

		//ini_set("allow_url_fopen", 1);
		$__tme_s = microtime(true);
		$Rt = '../../../includes/';
		$__no_sbdmn = 'ok';
		$__bdapi = 'ok';

		require($Rt.'inc.php');
		ob_start("compress_code");
		No_Cache();

		$__cstore = new CRM_Store();

		$__pm_1 = PrmLnk('rtn', 1, 'ok');
		$__pm_2 = PrmLnk('rtn', 2, 'ok');
		$__pm_3 = PrmLnk('rtn', 3, 'ok');
        $__pm_4 = PrmLnk('rtn', 4, 'ok');

		$__s_id = _GetPost('store');
		$__start = _GetPost('start');


    //---------------------- GET INFO TROUGH DOMAIN ----------------------//

        if(!isN($__s_id)){
			$_s_i = $__s_id;
			$_s_t = 'pml';
        }else{
            $_s_i = $_SERVER['HTTP_HOST'];
			$_s_t = 'sbd';
        }

        $__s_dt = $__cstore->GtDt([ 'id'=>$_s_i, 't'=>$_s_t, 'strt'=>$__start ]);

        if(!isN($__s_dt->enc)){
			//_StDbCl([ 'sbd'=>$__s_dt->cl->sbd, 'enc'=>$__s_dt->cl->enc ]);
			$rsp['store_id'] = $__s_dt->enc;
        }

	//---------------------- INCLUSIÓN DE ARCHIVOS ----------------------//

		define('GL_LS', DIR_CNT.'ls/');
		define('GL_SV', DIR_CNT.'sv/');

		$__p1_o = PrmLnk('rtn', 1, 'ok');
		$__p2_o = PrmLnk('rtn', 2, 'ok');
		$__p3_o = PrmLnk('rtn', 3, 'ok');
		$__p4_o = PrmLnk('rtn', 4, 'ok');

	//---------------------- INICIA PROCESAMIENTO ----------------------//

		if(is_https()){

			if($__p1_o == 'webhook'){

				$api->_Rq([ 'p1'=>$__p1_o, 'p2'=>$__p2_o, 'p3'=>$__p3_o ]);

				if($__p2_o == 'facebook'){

					include(DIR_CNT."facebook.php");
					$nojs = 'ok';

				}elseif($__p2_o == 'emblue'){

					include(DIR_CNT."emblue.php");

				}elseif($__p2_o == 'aws'){

					include(DIR_CNT."aws.php");

				}elseif($__p2_o == 'massive'){

					include(DIR_CNT."massive.php");

				}elseif($__p2_o == 'gateway'){

					include(DIR_CNT."gateway.php");

				}elseif($__p2_o == 'twilio'){

					include(DIR_CNT."twilio.php");

				}

			}

		}else{

			$rsp['w'] = 'Debe ser conexión segura (https)';

		}

		if($__no_json != 'ok'){ Hdr_JSON(); }

		header("access-control-allow-origin: *");

		if($__tm != 'no'){
			$__qry_exc_t = (microtime(true) - $__tme_s)/60;
			$__qry_exc = number_format($__qry_exc_t, 5, '.', '');
			$rsp['t_r'] = $__qry_exc;
		}

		if(!isN($rsp) && $nojs != 'ok'){ $rtrn = json_encode($rsp, JSON_UNESCAPED_UNICODE | JSON_PARTIAL_OUTPUT_ON_ERROR); echo $rtrn; }
		if(!isN($CntWb)){ echo CntJQ($CntWb);  }

		//ob_end_flush();

?>