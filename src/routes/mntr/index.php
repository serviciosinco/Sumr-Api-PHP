<?php

	$Rt = '../../includes/';
	$__pbc='ok';
	$__https_off = 'off';
	$__no_sbdmn = 'ok';
	$__bdapi = 'ok';

	include($Rt.'inc.php');
	include('fnc.php');
	header('Access-Control-Allow-Origin: *');


	/*

	if($_SERVER['SERVER_NAME']=='monitor.sumr.cloud'){

		header('Location: https://monitor.sumr.co/status/');

	}
	*/

	//-------------------- GLOBAL - START --------------------//

		$__pm_1 = PrmLnk('rtn', 1, 'ok');
		$__pm_2 = PrmLnk('rtn', 2, 'ok');
		$__pm_3 = PrmLnk('rtn', 3, 'ok');
		$__pm_4 = PrmLnk('rtn', 4, 'ok');

	//-------------------- BUILD HTML --------------------//

	if($__pm_1 != ''){

		if($__pm_1 == 'css'){

			require_once(DIR_INC."_css.php");

		}elseif($__pm_1 == 'process'){

			require_once(DIR_CNT."prc.php");

		}elseif($__pm_1 == 'status'){

			echo 'Fix';
			/*require_once(DIR_CNT."status.php");*/

		}elseif($__pm_1 == 'socket'){

			require_once(DIR_CNT."socket.php");

		}elseif($__pm_1 == 'json'){

			require_once("json.php");

		}

	}else{

		require_once(DIR_CNT."html.php");

	}


?>