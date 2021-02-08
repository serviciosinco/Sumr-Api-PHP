<?php

	$Rt = '../../includes/'; $__pbc='ok'; $__https_off = 'off';

	include($Rt.'inc.php'); header('Access-Control-Allow-Origin: *');

	$__f = substr($_SERVER['REQUEST_URI'], 1);

	$__g_opq = Php_Ls_Cln($_GET['opaque']); //opaque=true
	$__g_icn = Php_Ls_Cln($_GET['icon']); //icon=true
	$__g_app = Php_Ls_Cln($_GET['app']); //app=true
	$__g_url = Php_Ls_Cln($_GET['url']); //icon=true
	$__g_trck = Php_Ls_Cln($_GET['trck']); //icon=true
	$__g_act = Php_Ls_Cln($_GET['act']); //act-related

	$__pm_1 = PrmLnk('rtn', 1, 'ok');
	$__pm_2 = PrmLnk('rtn', 2, 'ok');
	$__pm_3 = PrmLnk('rtn', 3, 'ok');
	$__pm_4 = PrmLnk('rtn', 4, 'ok');

	$__cl = __Cl([ 'id'=>$__pm_1, 't'=>'sbd' ]);



	if(!isN($__cl->sbd)){
		_StDbCl([ 'sbd'=>$__cl->sbd, 'enc'=>$__cl->enc, 'mre'=>$__dt_cl ]); _Cl_Lb([ 'sb'=>$__cl->sbd ]);
		$__head_tt .= $__dt_cl->nm;
	}

	if($__pm_1 != 'css' && $__pm_2 != 'base'){

		$__mdl = GtMdlDt([  'bd'=>$__cl->bd, 't'=>'pml', 'id'=>$__pm_2, 'fm'=>'ok' ]);

		$__head_tt .= ' '.SP.' '.$__mdl->tt;
		$__fm = $__mdl->tp->fm;
		$__mdl_id = $__mdl->id;
		$__mdl_enc = $__mdl->enc;

	}

	if($__pm_1 != ''){

		if($__pm_1 == 'css'){

			require_once(DIR_INC."_css.php");

		}elseif($__pm_2 == 'process'){

			require_once(DIR_CNT."prc.php");

		}elseif($__pm_2 == 'search'){

			require_once(DIR_CNT."sch.php");

		}else{

			if(isN($__mdl->enc) && isN($__mdlgen->enc) && ( $__mdl->est == _CId('ID_SISMDLEST_INACT') || $__mdl->est == _CId('ID_SISMDLEST_ELI') ) ){
				exit();
			}

			require_once(DIR_CNT."html.php");

		}
	}

?>