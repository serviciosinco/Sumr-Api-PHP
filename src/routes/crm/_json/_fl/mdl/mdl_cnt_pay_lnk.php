<?php 
	
	//--------------- Get Values ---------------//

		$_g_clgtwy = Php_Ls_Cln($_POST['cl_gtwy']);
		$_g_mdlcnt = Php_Ls_Cln($_POST['mdl_cnt']);
		$_g_gtwyeml = Php_Ls_Cln($_POST['gtwy_eml']);
		$_g_gtwydc = Php_Ls_Cln($_POST['gtwy_dc']);
		$_g_gtwyqty = Php_Ls_Cln($_POST['gtwy_qty']);

	//------------- Class Gateway -------------//

		$__gtwy = new CRM_Gtwy();

	//------------- Process Data -------------//

	$__gtwy->mdlcntpaylnk_qty = $_g_gtwyqty;
	$__gtwy->clgtwypay_enc = $_g_clgtwy;

	$__gtwy->cnteml_enc = $_g_gtwyeml;
	$__gtwy->cntdc_enc = $_g_gtwydc;
	$__gtwy->mdlcnt_enc = $_g_mdlcnt;

	$__r = $__gtwy->mrcpago_pay_lnk();

	if($__r->e == 'ok' && !isN($__r->lnk) ){
		$rsp['e'] = 'ok';
		$rsp['url'] = $__r->lnk->url;
		$rsp['tp'] = $__r->tp;
		$rsp['fi'] = SIS_F_D2;
		$rsp['tmp_pgo'] = $__r->tmp_mpgo;
	}else{
		$rsp['w'] = $__r;
		$rsp['tmp_cwyget'] = $_g_clgtwy;
	}
	
?>