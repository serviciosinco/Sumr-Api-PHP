<?php

	$_s = Php_Ls_Cln($_GET['_s']);
	$_scl = Php_Ls_Cln($_GET['_scl']);
	$___prf_ls = GtSclLs([ 'us'=>SISUS_ID, 'cl'=>DB_CL_ENC ]); 
	$___scl_selected = $___prf_ls->scl->{$_scl};
	
	$___scl_dt_g = __LsDt([ 'k'=>'api_thrd', 'tp'=>'enc', 'id'=>$_scl ]);
	

	if($_s == 'fb'){ 
		$_scl_inc = 'fb.php';
	}elseif($_s == 'tw'){
		$_scl_inc = 'tw.php';
	}elseif($_s == 'ins'){
		$_scl_inc = 'ins.php';
	}elseif($_s == 'lnkin'){
		$_scl_inc = 'lnkin.php';
	}
		 
	if(!isN($_scl_inc)){ include(GL_SCL.'stup/'.$_scl_inc); }
?>

<style>
	
	button.btn_stup{ position: relative; border-radius:8px; -moz-border-radius:8px; -webkit-border-radius:8px; padding: 10px 10px 10px 40px; border: 1px solid #858282; overflow: hidden; }
	button.btn_stup:hover{ background-color: #ebeff1; }
	button.btn_stup:hover::before{ transform: rotate(10deg); left: -12px; }
	button.btn_stup::before{ display: block; width: 50px; height: 50px; position: absolute; left: -15px; top: 0px; background-position: center center; background-repeat: no-repeat; background-size: auto 80%; transform: rotate(20deg); }
	button.btn_stup.fb::before{ background-image: url('<?php echo DMN_IMG_ESTR_SVG ?>scl_stup_fb.svg'); }
	button.btn_stup.tw::before{ background-image: url('<?php echo DMN_IMG_ESTR_SVG ?>scl_stup_tw.svg'); }
	button.btn_stup.ins::before{ background-image: url('<?php echo DMN_IMG_ESTR_SVG ?>scl_stup_ins.svg'); }
	button.btn_stup.lnkin::before{ background-image: url('<?php echo DMN_IMG_ESTR_SVG ?>scl_stup_lnkin.svg'); }
	
</style>