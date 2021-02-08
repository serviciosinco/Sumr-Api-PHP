<?php 
	
	$__dt_cl = __Cl([ 'id'=>$__p2, 't'=>'prfl' ]); 
	
	if(!isN($__dt_cl->sbd)){ $_sbd=$__dt_cl->sbd.'.'; }else{ $_sbd=''; }
	
	$__chck_ses = $_COOKIE[CKTRCK_SES];
	
	if(isN($__chck_ses)){
		$__idc_r = enCad(Gn_Rnd(20).SIS_F); 
		$expireson = time()+(10 * 365 * 24 * 60 * 60);	
		setcookie(CKTRCK_SES, $__p3, $expireson, '/', Gt_DMN(), true/*, 'httponly'*/);
	}
	
	Hdr_IMG();
	
	
?>