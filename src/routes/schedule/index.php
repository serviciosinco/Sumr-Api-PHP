<?php $Rt = '../../includes/'; $__pbc='ok'; $__https_off = 'off'; $__bdfrnt = 'ok';


	include($Rt.'inc.php'); header('Access-Control-Allow-Origin: *');


	//-------------------- GLOBAL - START --------------------//

		$__f = substr($_SERVER['REQUEST_URI'], 1);


		$__g_opq = Php_Ls_Cln($_GET['opaque']); //opaque=true
		$__g_icn = Php_Ls_Cln($_GET['icon']); //icon=true
		$__g_url = Php_Ls_Cln($_GET['url']); //icon=true


		$__pm_1 = PrmLnk('rtn', 1, 'ok');
		$__pm_2 = PrmLnk('rtn', 2, 'ok');
		$__pm_3 = PrmLnk('rtn', 3, 'ok');
		$__pm_4 = PrmLnk('rtn', 4, 'ok');

		$__cl = __Cl([ 'cnx'=>$__cnx->c_r, 'id'=>$__pm_1, 't'=>'sbd' ]);

		if($__cl->sbd != NULL){
			_StDbCl([ 'sbd'=>$__cl->sbd, 'enc'=>$__cl->enc, 'mre'=>$__dt_cl ]); _Cl_Lb([ 'sb'=>$__cl->sbd ]);
			$__head_tt .= $__dt_cl->nm;
		}

		if($__pm_2=='g'){

			$__mdlgen = GtMdlGenDt([ 'bd'=>$__cl->bd, 't'=>'enc', 'id'=>$__pm_3, 'fm'=>'ok' ]);
			$__head_tt .= ' '.SP.' '.$__mdlgen->tt;
			$__fm = $__mdlgen->tp->fm;

		}else{
			$__mdl = GtMdlDt([ 'cnx'=>$__cnx->c_r, 'bd'=>$__cl->bd, 't'=>'enc', 'id'=>$__pm_2, 'fm'=>'ok' ]);
			$__head_tt .= ' '.SP.' '.$__mdl->tt;
			$__fm = $__mdl->tp->fm;
		}

		if(!isN($__mdl->tp->fm->thm) && $__mdl->tp->fm->thm->attr->key->vl != 'bsc'){
			$__fm_thm = $__mdl->tp->fm->thm->attr->key->vl;
		}

	//-------------------- BUILD PRECLASS --------------------//

		if($__g_opq){ $_bdcss=' _opq '; }
		if(isN($__g_icn)){ $_bdcss.=' no-icn '; }

	//-------------------- BUILD HTML --------------------//

	if($__pm_1 != ''){

		if($__pm_1 == 'css'){

			require_once(DIR_INC."_css.php");

		}elseif($__pm_1 == 'js'){

			require_once(DIR_INC."_js.php");

		}elseif($__pm_2 == 'process'){

			require_once(DIR_CNT."prc.php");

		}else{

			require_once(DIR_CNT."html.php");

		}
	}


?>