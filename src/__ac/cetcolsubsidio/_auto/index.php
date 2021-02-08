<?php 

	$__t = Php_Ls_Cln($_GET['_t']);
	$__i = Php_Ls_Cln($_GET['_i']);
	$__e = Php_Ls_Cln($_GET['__e']);
	
	
	echo $__e.' == '.encAd(SIS_ENCI);
	
	if($__e == encAd(SIS_ENCI)){	
		
		include(DIR_CNT.'mdl_cnt_priority.php');
		
	}

?>