<?php 
	
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "FrceLgin")) {	

	$__user = Php_Ls_Cln($_POST['_user']);
	$__dvc = Php_Ls_Cln($_POST['____dvc']);
	$__us_dt = GtUsDt($__user, 'enc');
	
	$___ses = new CRM_SES();
	$__usses_dt = $___ses->GtSesUsDt($__user , 'enc');

	if(!isN($__us_dt->id) && !isN($__usses_dt->id)){
			
		$rsp['ses']['off'] = UPD_UsSes([ 'id'=>SISUS_SES_ID, 'est'=>2 ]);

		$___ses = new CRM_SES();
		$___ses->__ck_cln();  
		
		$___ses->usr = enCad( $__us_dt->id . $__us_dt->eml . $__usses_dt->n );
		$___ses->usr_grp = enCad($__usses_dt->n);
		$___ses->usr_cl = $__dt_cl->enc;
		$___ses->usr_id = $__us_dt->id;
		$___ses->usdvc_cl = $__dt_cl->id;
		$___ses->usdvc_us = $__us_dt->id;
		$___ses->lgin_dvc = $__dvc;
		$___ses->usr_sve = true;
		
		$__e = $___ses->__lgin_set_rg();
	
		if($__e->e == 'ok'){
			UPDus_Onl([ 'rst'=>'ok' ]);
			$rsp['prc'] = $__e;
			$rsp['e'] = 'ok';
		}else{
			$rsp['r'] = $__e;
		}
	}

}
	
?>