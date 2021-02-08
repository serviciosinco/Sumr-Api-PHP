<?php

	$Rt = '../../includes/'; $__pbc='ok'; $__bdfrnt = 'ok'; $__sess_sbd='ok'; include($Rt.'inc.php');

	$__s = Php_Ls_Cln($_GET['_sz']);
	$__l = Php_Ls_Cln($_GET['lng']);
	$__f = substr($_SERVER['REQUEST_URI'], 1);

	$__pm_1 = PrmLnk('rtn', 1, 'ok');
	$__pm_2 = PrmLnk('rtn', 2, 'ok');
	$__pm_3 = PrmLnk('rtn', 3, 'ok');
	$__pm_4 = PrmLnk('rtn', 4, 'ok');


	$__dt_cl = __Cl(['id'=>$__pm_1, 't'=>'sbd']);

	if(!isN($__dt_cl->sbd)){ _StDbCl(['sbd'=>$__dt_cl->sbd, 'enc'=>$__dt_cl->enc, 'mre'=>$__dt_cl ]); }

	_Cl_Lb(['sb'=>$__dt_cl->sbd]);

	function isFle($_p=NULL){
		$__e = explode('.', $_p['f']);
		if(count($__e)>1){ return true; }else{ return false; }
	}


	if(!isN($__pm_1)){

		if($__pm_1 == 'css'){

			require_once(DIR_INC."_css.php");

		}elseif($__pm_1 == 'js'){

			require_once(DIR_INC."_js.php");

		}else{

			if(!isN($__pm_2)){

				$appdt = GtClAppDt([ 'id'=>$__pm_2, 't'=>'enc' ]);

				if($appdt->e != 'ok'){
					$appdt = GtClAppDt([ 'id'=>$__pm_2, 't'=>'pml' ]);
				}

				if(!isN($appdt->id)){

					if($appdt->stup->csfle == 'ok'){
						require_once( dirname(__FILE__, 3).'/'.DR_AC.$__dt_cl->sbd.'/'.FL_SB_APP.$appdt->enc.'/index.php' );
					}else{
						require_once(DIR_CNT.'dsh.php');
					}

				}else{

					if(file_exists(DIR_CNT.'dsh_404.php')){ require_once(DIR_CNT.'dsh_404.php'); }

				}

			}else{

				echo 'No pm2 value';

			}

		}

	}else{
		echo 'no especificado';
	}






?>