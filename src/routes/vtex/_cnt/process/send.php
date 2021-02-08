<?php 
 
	$___t = Php_Ls_Cln($_POST['____tp']);

	if($___t == 'new_rfd'){
		include(DIR_CNT.'process/send/new_rfd.php');
	}elseif($___t == 'new_ins'){
		include(DIR_CNT.'process/send/new_ins.php');
	}

	//------------------* PRINT RESULTS ------------------//
		
?>