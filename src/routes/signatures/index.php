<?php $Rt = '../../includes/'; $__https_off = 'off'; $__no_sbdmn = 'ok';  $__bdfrnt = 'ok'; include($Rt.'inc.php');




			$__s = Php_Ls_Cln($_GET['_sz']);
			$host= $_SERVER["HTTP_HOST"];
			$__f = $_SERVER['REQUEST_URI'];

			$__pm_1 = PrmLnk('rtn', 1, 'ok');
			$__pm_2 = PrmLnk('rtn', 2, 'ok');
			$__pm_3 = PrmLnk('rtn', 3, 'ok');
			$__pm_4 = PrmLnk('rtn', 4, 'ok');

			$__dt_cl = __Cl(['id'=>$__pm_1, 't'=>'sbd']);
			$__dt_sgn = GtSgnDt($__pm_2, 'enc');

			if($__dt_cl->sbd != NULL){ _StDbCl(['sbd'=>$__dt_cl->sbd, 'enc'=>$__dt_cl->enc, 'mre'=>$__dt_cl]); }
			_Cl_Lb(['sb'=>$__dt_cl->sbd]);


			//print_r($__dt_cl);
			//print_r($__dt_sgn);

			function isFle($_p=NULL){
				$__e = explode('.', $_p['f']);
				if(count($__e)>1){ return true; }else{ return false; }
			}


			if($__pm_1 != ''){



				$___cl = '../../'.DR_AC.$__pm_1.'/'.FL_SB_SGN;

				include($___cl.'index.php');

				/*if($__pm_2 != ''){

					if($__pm_3 != '' && !isFle(array('f'=>$__pm_3))){
						include($___cl.$__pm_2.'/'.$__pm_3.'/_gn.php');
					}else{
						include($___cl.$__pm_2.'/_gn.php');
					}

				}else{
					include($___cl.'index.php');
				}*/


			}else{
				echo 'no especificado';
			}



?>