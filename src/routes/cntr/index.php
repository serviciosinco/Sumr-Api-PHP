<?php $Rt = '../../includes/'; $__pbc='ok'; $__https_off = 'off'; $__bdfrnt = 'ok';

	include($Rt.'inc.php'); header('Access-Control-Allow-Origin: *');

	//-------------------- GLOBAL - START --------------------//

		$__f = substr($_SERVER['REQUEST_URI'], 1);

		$__pm_1 = PrmLnk('rtn', 1, 'ok');
		$__pm_2 = PrmLnk('rtn', 2, 'ok');
		$__pm_3 = PrmLnk('rtn', 3, 'ok');
		$__pm_4 = PrmLnk('rtn', 4, 'ok');

		$__cl = __Cl([ 'cnx'=>$__cnx->c_r, 'id'=>$__pm_1, 't'=>'sbd' ]);
		$__Forms = new CRM_Appl();

		if($__cl->sbd != NULL){
			_StDbCl([ 'sbd'=>$__cl->sbd, 'enc'=>$__cl->enc, 'mre'=>$__dt_cl ]); _Cl_Lb([ 'sb'=>$__cl->sbd ]);
			$__head_tt .= $__dt_cl->nm;
		}

	//-------------------- BUILD HTML --------------------//

	if($__pm_1 != ''){

		if($__pm_1 == 'css'){

			require_once(DIR_INC."_css.php");

		}elseif($__pm_2 == 'process'){

			require_once(DIR_CNT."prc.php");

		}elseif($__pm_2 == 'json'){

			require_once("json.php");

		}else{

			//if(isN($__cntr_fm->enc) && isN($__cnt->enc)){ exit(); }
			require_once(DIR_CNT."html.php");

		}

	}

?>