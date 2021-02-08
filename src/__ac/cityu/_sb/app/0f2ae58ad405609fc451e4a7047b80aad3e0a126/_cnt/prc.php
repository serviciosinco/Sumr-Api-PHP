<?php
	// @ini_set('display_errors', true);
	// error_reporting(E_ALL);
	// define('DSERR','on');
	//------------------* SETUP - START ------------------//

		Hdr_JSON();
		ob_start("compress_code");
		$_r['e']='no';




		//------------------* SETUP - START ------------------//

			$_r['e']='no';

		//------------------* SETUP - END ------------------//

			$__Forms = new CRM_Forms();
			$__Forms->data = Php_Ls_Cln($_POST);
			$__r = $__Forms->_pdata();

		//------------------* PROCESS DATA ------------------//

		if($_pm_action == 'login'){

			require_once(dirname(__FILE__).'/process/login.php');

		}elseif($_pm_section == 'process'){

			require_once(dirname(__FILE__).'/process/process.php');

		}elseif($_pm_section == 'data'){

			require_once(dirname(__FILE__).'/process/data.php');

		}

		if(!isN($_r)){ echo json_encode($_r); }else{  }
		ob_end_flush();

?>