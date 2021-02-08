<?php

	//---------------------- INCLUSIÓN DE ARCHIVOS ----------------------//

		ini_set("allow_url_fopen", 1);
		$__tme_s = microtime(true);

		$Rt = '../../includes/';

		$__fbsrc = 'ok';
		$__twiliosrc = 'ok';
		$__no_sbdmn = 'ok';
		$__bdapi = 'ok';

		require($Rt.'inc.php');
		//ob_start("compress_code");
		No_Cache();

		$rsp['ses'] = false;
		$api = new CRM_Api();

	//---------------------- INCLUSIÓN DE ARCHIVOS ----------------------//

		define('GL_LS', DIR_CNT.'ls/');
		define('GL_SV', DIR_CNT.'sv/');
		define('GL_DOC', DIR_CNT.'doc/');
		define('GL_AWS', DIR_CNT.'aws/');
		define('GL_APP', DIR_CNT.'app/');
		define('GL_STRE', DIR_CNT.'store/');

		$_pml = 'no';

		$__p1 = PrmLnk('rtn', 1, $_pml);
		$__p1_o = PrmLnk('rtn', 1, 'ok');
		$__p2 = PrmLnk('rtn', 2, $_pml);
		$__p2_o = PrmLnk('rtn', 2, 'ok');
		$__p3 = PrmLnk('rtn', 3, $_pml);
		$__p3_o = PrmLnk('rtn', 3, 'ok');
		$__p4 = PrmLnk('rtn', 4, $_pml);
		$__p4_o = PrmLnk('rtn', 4, 'ok');


	//---------------------- CONEXIÓN DE API ----------------------//

		$__Ses = $api->_Cnx([ 'p1'=>$__p1_o, 'p2'=>$__p2_o, 'p3'=>$__p3_o ]);

		if(!isN($__Ses->rq->enc)){
			$rsp['request_id'] = $__Ses->rq->enc;
		}

	//---------------------- INICIA PROCESAMIENTO ----------------------//

		if(is_https()){

			if($__Ses->e){

				$rsp['ses'] = true;
				//http_response_code(100);

				if($__p1_o == 'app'){

					include(DIR_CNT."app/_gn.php");

					$api->_Rq([ 'p1'=>$__p1_o, 'p2'=>$__p2_o, 'p3'=>$__p3_o, 'p4'=>$__p4_o, 'p5'=>$__p5_o ]);

				}else{

					//---------------------- FORZAR SIEMPRE DENTRO DE LA SESION ----------------------//

						_Cl_Lb(['sb'=>$__Ses->cl->sbd]);
						$_R = _StDbCl(['sbd'=>$__Ses->cl->sbd, 'enc'=>$__Ses->cl->enc, 'mre'=>$__dt_cl ]);

						if($__p1_o === 'l'){
							include(GL_LS."_gn.php");
						}elseif($__p1_o === 's'){
							include(GL_SV."_gn.php");
						}

						//$rsp['stbd'] = $__Ses->cl->sbd.' -> '.$__Ses->cl->enc.' - '.DB_CL_FLD.' - '.print_r($_R, true);
						include(dirname( dirname( dirname(__FILE__) ) ).'/__ac/'.$__Ses->cl->sbd.'/_api/index.php');

					//---------------------- FORZAR SIEMPRE DENTRO DE LA SESION ----------------------//

				}

			}elseif($__p1_o == 'webhook'){

				$api->_Rq([ 'p1'=>$__p1_o, 'p2'=>$__p2_o, 'p3'=>$__p3_o, 'p4'=>$__p4_o, 'p5'=>$__p5_o ]);

				if($__p2_o == 'facebook'){

					include(DIR_CNT."facebook.php");
					$nojs = 'ok';

				}elseif($__p2_o == 'emblue'){

					include(DIR_CNT."emblue.php");

				}elseif($__p2_o == 'aws'){

					//include(DIR_CNT."aws.php");

				}elseif($__p2_o == 'massive'){

					include(DIR_CNT."massive.php");

				}elseif($__p2_o == 'gateway'){

					include(DIR_CNT."gateway.php");

				}elseif($__p2_o == 'twilio'){

					include(DIR_CNT."twilio.php");

				}

			}elseif($__p1_o == 'store'){

				include(DIR_CNT."store/_gn.php");

			}elseif($__p1_o == 'docs'){

				$nojs='ok';
				$__no_json = 'ok';

				if(!isN($__p2_o)){

					include(GL_DOC.$__p2_o.".php");

				}else{

					include(GL_DOC."_main.php");

				}

			}else{

				$rsp['error'] = $__Ses->w;
				$rsp['ses'] = false;
				http_response_code(401);

			}

			if(!isN($api->new_rqu_id) && ($____prc_e=='ok' || $__e == 'ok')){

				$api->_Rq_Upd([ 'rsp'=>$rsp, 'e'=>'1' ]);

			}

		}else{

			$rsp['w'] = 'Debe ser conexión segura (https)';

		}

		if($__no_json != 'ok'){ Hdr_JSON(); }

		header("Access-Control-Allow-Origin: *");
		header('Access-Control-Allow-Methods: GET, PUT, POST');
		header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With, x-app-key');

		if($__tm != 'no'){
			$__qry_exc_t = (microtime(true) - $__tme_s)/60;
			$__qry_exc = number_format($__qry_exc_t, 5, '.', '');
			$rsp['t_r'] = $__qry_exc;
		}

		if(!isN($rsp) && $nojs != 'ok'){ $rtrn = json_encode($rsp, JSON_UNESCAPED_UNICODE | JSON_PARTIAL_OUTPUT_ON_ERROR); echo $rtrn; }
		if(!isN($CntWb)){ echo CntJQ($CntWb);  }

		//ob_end_flush();

?>