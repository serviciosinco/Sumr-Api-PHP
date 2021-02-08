<?php

$Rt = '../../includes/';
$__pbc='ok';
$__https_off = 'off';
$__bdfrnt = 'ok';

include($Rt.'inc.php');
Hdr_HTML();
ob_start("compress_code");

$__pm_1 = PrmLnk('rtn', 1, 'ok');
$__pm_2 = PrmLnk('rtn', 2, 'ok');
$__pm_3 = PrmLnk('rtn', 3, 'ok');
$__snd_e = Php_Ls_Cln($_GET['__e']);


$__dt_act = GtActDt([ 'id'=>$__pm_2, 'tp'=>'pml' ]);

if(isN($__dt_act->id)){
	$__dt_act = GtActDt([ 'id'=>$__pm_1, 'tp'=>'enc' ]);
}
if(!isN($__dt_act->cl) && !isN($__dt_act->cl->id)){
	$__cl = __Cl([ 'id'=>$__dt_act->cl->id ]);
}

//-------------------- BUILD HTML --------------------//



	if($__pm_1 != ''){

		if($__pm_1 == 'css'){

			require_once(DIR_INC."_css.php");

		}elseif($__pm_2 == 'process'){

			require_once(DIR_CNT."prc.php");

		}elseif($__pm_2 == 'search'){

			require_once(DIR_CNT."sch.php");

		}else{

			require_once(DIR_CNT."html.php");

		}

	}



?>
<?php ob_end_flush(); ?>