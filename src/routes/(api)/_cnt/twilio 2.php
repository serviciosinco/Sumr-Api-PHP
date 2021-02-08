<?php

	//-------------- GET BASIC DATA -------------//

	$__c = Php_Ls_Cln($_POST['SUMR_Cl']);
	if(isN($__c)){ $__c = Php_Ls_Cln($_GET['SUMR_Cl']); }

	$__u = Php_Ls_Cln($_POST['SUMR_User']);
	if(isN($__u)){ $__u = Php_Ls_Cln($_GET['SUMR_User']); }

	if(!isN($__c)){ $__cl_dt = GtClDt($__c, 'enc'); }
	if(!isN($__u)){ $__us_dt = GtUsDt($__u, 'enc'); }


	//-------------- FOLDERS INTERNOS --------------//

	define('API_F_TWILIO', dirname(__FILE__).'/twilio/');

	//-------------- FOLDERS INTERNOS --------------//

	//ob_start("compress_code");

	if($__p3_o == 'touser'){

		if($__p4_o == 'save'){
			$_to_inc = 'tous_save.php';
		}elseif($__p4_o == 'phone_add'){
			$_to_inc = 'phone_add.php';
		}else{
			$_to_inc = 'tous.php';
		}

		/*$insertSQL = sprintf("INSERT INTO ____RQ (rq) VALUES (%s)",
					   GtSQLVlStr(json_encode($_POST), "text"));

		$Result = $__cnx->_prc($insertSQL);*/

	}elseif($__p3_o == 'whatsapp'){

		if($__p4_o == 'save'){
			$_to_inc = 'whatsapp_save.php';
		}
		/*
		$insertSQL = sprintf("INSERT INTO ____RQ (rq) VALUES (%s)",
					   GtSQLVlStr('WHTSAPP:'.json_encode($_POST), "text"));

		$Result = $__cnx->_prc($insertSQL);*/

	}elseif($__p3_o == 'mydvc'){

		$_to_inc = 'tomydvc.php';

	}elseif($__p3_o == 'touscnt'){

		$_to_inc = 'tous_cnt.php';

	}elseif($__p3_o == 'waitmusic'){

		$_to_inc = 'towait.php';

	}

    include(API_F_TWILIO.$_to_inc);

	//ob_end_flush();

?>