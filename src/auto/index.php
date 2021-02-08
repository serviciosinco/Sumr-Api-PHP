<?php

	//if($_GET['Camilo'] == ''){ echo '<h1>Not allow yet</h1>'; exit(); }

	try {

		$__tme_s = microtime(true);

		//------------- START - INCLUDE BASIC -----------------//

			$_cls_xls = 'ok';
			//$Rt = '../includes/';
			$__https_off = 'off';
			$__no_sbdmn = 'ok';
			$__fbsrc = 'ok';
			$__twsrc = 'ok';
			$__emblue = 'ok';
			$__cls_bnce = 'ok';

			include( dirname( dirname(__FILE__) ) .'/includes/inc.php');
			ini_set('max_execution_time', 600000);

		//------------- Classes -----------------//

			//if(isWrkr()){ sleep(SLEP_TME_AUTO); }

			$__argv = _argv($argv);
			$_AUTOP = new API_CRM_Auto([ 'argv'=>$__argv ]);

		//------------- START - GET PARAMETERS - POST - GET -----------------//

			if($_AUTOP->_argv->Sv == 'ok'){
				@ini_set('display_errors', true);
				error_reporting(E_ALL & ~E_NOTICE);
			}

		//------------- START - INCLUDE BASIC -----------------//


			$__dt_cl = __Cl(['id'=>$_AUTOP->__pm_1, 't'=>'sbd']);
			if(!isN($__dt_cl->sbd)){ _StDbCl(['sbd'=>$__dt_cl->sbd, 'enc'=>$__dt_cl->enc, 'mre'=>$__dt_cl ]); }
			_Cl_Lb(['sb'=>$__dt_cl->sbd]);

			if($_AUTOP->g__cfrmt == 'json'){

				$_AUTOP->_Auto_Inc(DIR_CNT.'_json.php');

			}else{

				try {

					//ob_start("compress_code");
					$_AUTOP->_Auto_Inc(DIR_CNT.'_html.php');
					//ob_end_flush();

				} catch (Exception $e) {

					//ob_end_flush();
					echo 'Auto Error: ',  $e->getMessage(), "\n";

				}

			}

	} catch (Exception $e) {

	    echo $e->getMessage();

	}


	$__tmexc = _Rg_Tme($__tme_s, microtime(true));


?>