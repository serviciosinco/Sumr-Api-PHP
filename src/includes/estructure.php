<?php

	define('GL', __f());

	if (defined('DB_CL_ENC_SES') && (isset($_SESSION[DB_CL_ENC_SES.MM_ADM])) && $_SESSION[DB_CL_ENC_SES.MM_ACNT] === DB_CL_ENC){
		$IncWb = DIR_CNT.'sis.php';
	}else{
		$IncWb = DIR_CNT_FM.GL.'login.php';
	}

?>