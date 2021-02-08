<?php

$_hb = 'no';
$__user = strtolower( Php_Ls_Cln($_POST['user']) );
$__us = new CRM_Us();

if(!isN($__user)){
		
	$__chk = explode('@', $__user);
	$_hb = 'no_dmn';
	
	if($__dt_cl->dmn->tot > 0){
		foreach($__dt_cl->dmn->main->ls as $_dmn_k=>$_dmn_v){
			if($__chk[1] == $_dmn_v->url || $__chk[1] == 'servicios.in'){ 
				$_hb = ''; break; 
			}
		}
	}		
	
	if(!filter_var($__user, FILTER_VALIDATE_EMAIL)){ $_hb = 'no_eml'; }
	if($__user == ''){ $_hb = 'no_all'; }
	if($__pass != $__pass_chk){ $_hb = 'no_chk'; }
		
	$__us_dt = GtUsDt($__user,'usr');

	if($_hb == 'no_all'){ 
		
		$rsp['e'] = 'no';
		$___Gt = GtSisPrcDt(Php_Ls_Cln(8));
		$rsp['w'] = $___Gt->tt;	
			
	}elseif($_hb == 'no_dmn'){ 
		
		$rsp['e'] = 'no';
		$___Gt = GtSisPrcDt(Php_Ls_Cln(12));
		$rsp['w'] = $___Gt->tt;	
		
	}elseif($_hb == 'no_eml'){ 
		
		$rsp['e'] = 'no';
		$___Gt = GtSisPrcDt(Php_Ls_Cln(8));
		$rsp['w'] = $___Gt->tt;	
		
	}elseif((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "EdUsFrgtPss")) { 
			
		if(!isN($__us_dt->id)){
			$_us_enc = $__us_dt->enc;
			$us_snd = 'ok';	
		}else{
			$us_snd = 'no';
			$rsp['e'] = 'no';
			$___Gt = GtSisPrcDt(Php_Ls_Cln(8));
			$rsp['w'] = $___Gt->tt;	
			$rsp['tmp'] = $__us_dt;	
		}

	}

	if($us_snd == 'ok'){			
		
		$_get_frgt = $__us->UsFrgt([ 'us'=>$__us_dt->id, 'eml'=>1 ]);

		if($_get_frgt->e == 'ok' && !isN($_get_frgt->id)){

			$__ec = new API_CRM_ec();
			$__ec->id = _CId('EC_USRRCVRPSSW');
			$__ec->frm = 'Ml';
			$__ec->html = 'ok';
			$__ec->ec_scl = 'no';
			$__ec->ec_tll = 'no';
			$__ec->ctj->lnk_acton = '<a href="'.DMN_BS_ADM.'?_fP='.$_get_frgt->id.'">'.DMN_BS_ADM.'/?_fP='.$_get_frgt->id.'</a>';
			$__us_msj = $__ec->_bld();
				
			if(!isN($__us_msj)){

				$__snd = new API_CRM_SndMail();

				$__snd->cl->id = DB_CL_ID;
				$__snd->from_n = 'CRM - SUMR';
				$__snd->us_as = 'Recupera tu clave';
				$__snd->us_to = $__user;
				$__snd->us_msj = $__us_msj;	
				$__snd->sndr = 'sumr';		
				$_rsl_snd = $__snd->__SndMl();
				//$rsp['snd'] = $_rsl_snd;
				
			}
			
			if($_rsl_snd->us_est == 'ok'){
				
				$rsp['e'] = 'ok';
				$rsp['m'] = 1;	
				//$rsp['rstl'] = $__user;	
				//$rsp['enc'] = $_us_enc;	
				
			}else{
				$rsp['e'] = 'no';
				$rsp['m'] = 2;
			}

		}else{

			$rsp['w'] = $_get_frgt->w;

		}

	}else{
		
		$rsp['e'] = 'no';
		$rsp['m'] = 2;		
	}

}

?>