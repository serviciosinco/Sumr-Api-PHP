<?php $Rt = '../../includes/'; $__https_off = 'off'; $__bdfrnt = 'ok'; include($Rt.'inc.php');


				//-------------------- GLOBAL - START --------------------//

				$__pm_1 = PrmLnk('rtn', 1, 'ok');
				$__pm_2 = PrmLnk('rtn', 2, 'ok');
				$__pm_3 = PrmLnk('rtn', 3, 'ok');
				$__pm_4 = PrmLnk('rtn', 4, 'ok');


				//-------------------- BUILD HTML --------------------//

				if($__pm_1 != ''){

					if($__pm_1 == 'process'){

						require_once("cnt/prc.php");

					}

				}else{

					require_once("cnt/html.php");

				}

?>