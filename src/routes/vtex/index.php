<?php

	$Rt = '../../includes/'; $__pbc='ok'; $__bdfrnt = 'ok'; $__sess_sbd='ok'; include($Rt.'inc.php');

	//-------------------- GLOBAL - START --------------------//

		$browser = new Browser();

		$__f = substr($_SERVER['REQUEST_URI'], 1);

		$__pm_1 = PrmLnk('rtn', 1, 'ok');
		$__pm_2 = PrmLnk('rtn', 2, 'ok');
		$__pm_3 = PrmLnk('rtn', 3, 'ok');
		$__pm_4 = PrmLnk('rtn', 4, 'ok');

		$__bse = $_SERVER['HTTP_HOST'];
		$__id_rnd = '_'.Gn_Rnd(20);

		if(!isN($__cmpg_dt)){
			$__cl = __Cl([ 'id'=>$__cmpg_dt->acc->cl, 't'=>'id' ]);
		}

		if(isN($__cl->id)){

			$__cl = __Cl([ 't'=>'dmn', 'id'=>$_SERVER['HTTP_HOST'] ]);

			if(!isN($__cl->id)){ $__owndmn='ok'; }
			else{ $__cl = __Cl([ 'id'=>$__pm_1, 't'=>'sbd' ]); }

			if(!isN($__cl)){
				_StDbCl([ 'sbd'=>$__cl->sbd, 'enc'=>$__cl->enc, 'mre'=>$__cl ]);
			}else{
				$__chk = GtClDmnSubDt([ 't'=>'tp', 'id'=>'vtex', 'dmn'=>DMN_S, 'sub'=>Gt_SbDMN() ]);
				if(!isN($__chk->cl) && !isN($__chk->cl->id)){ $__dt_cl = __Cl([ 'id'=>$__chk->cl->id ]); }
			}

		}

		if( ChckSESS_cnt() ){
			$__cnt = GtCntDt([ 'id'=>$_SESSION[DB_CL_ENC_SES.MM_CNT], 't'=>'enc', 'bd'=>$__cl->bd ]);
			if(isN($__cnt->id)){
				$__vtex = new CRM_VTex();
				$__vtex->front_lgout();
				header('Location:/'.$_pm_module.'/login/');
			}
		}

		if (Dvlpr()){
			if($__owndmn == 'ok'){
				$_sbdo = '';
			}else{
				$_sbdo = $__cl->sbd;
			}
		}else{
			$_sbdo = "";
		}

		if($__owndmn == 'ok'){
			$_sbd = '/';
			$_pm_module = $__pm_1; // Modulo Vtex SUMR
			$_pm_section = $__pm_2; // Submodulo SUMR
			$_pm_action = $__pm_3; // Accion SUMR
		}else{
			$_sbd = '/'.$__cl->sbd;
			$_pm_module = $__pm_2; // Modulo Vtex SUMR
			$_pm_section = $__pm_3; // Submodulo SUMR
			$_pm_action = $__pm_4; // Accion SUMR
		}


	//-------------------- BUILD HTML --------------------//

	if(!isN($_pm_module)){

		if($_pm_section == 'process' || $_pm_section == 'data'){
			require_once(DIR_CNT."prc.php");
		}else{
			$__cmpg_dt = GtVtexCmpgDt([ 'tp'=>'pml', 'id'=>$_pm_section ]);
			require_once(DIR_CNT."html.php");
		}

	}else{

		$__chk = GtClDmnSubDt([ 't'=>'tp', 'id'=>'vtex', 'cl'=>$__cl->enc, 'sub'=>Gt_SbDMN() ]);

		if(!isN($__chk->dmn->url)){
			header('Location: '.$__chk->dmn->url);
		}else{
			require_once(DIR_CNT."html.php");
		}

	}
?>