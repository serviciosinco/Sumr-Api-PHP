<?php

	$pth = '../../../../includes/'; include($pth .'inc.php'); ob_start("compress_code"); Hdr_JSON();


	$rsp['e'] = 'no';
	$__t = Php_Ls_Cln($_GET['_t']);

	if($__t == 'aprb_cmnt'){
		include('aprb_cmnt.php');
	}elseif($__t == 'sch_cnt'){
		include('sch_cnt.php');
	}elseif($__t == 'sch_dovrf'){
		include('sch_dovrf.php');
	}elseif($__t == 'sch_dovrf_snd'){
		include('sch_dovrf_snd.php');
	}elseif($__t == 'cnt_sve'){
		include('cnt_sve.php');
	}elseif($__t == 'cnt_fld'){
		include('cnt_fld.php');
	}



	elseif($__t == 'sch_emp'){
		include('sch_org.php');
	}elseif($__t == 'sch_uni'){
		include('sch_org.php');
	}elseif($__t == 'sch_clg'){
		include('sch_org.php');
	}elseif($__t == 'new_add'){
		include('new_add.php');
	}



	$rtrn = json_encode($rsp);
	if(!isN($rtrn)){ echo $rtrn; }

	ob_end_flush();
?>