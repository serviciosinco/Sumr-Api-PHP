<?php $pth = '../../../../includes/'; include($pth .'inc.php'); ob_start("compress_code");


	$rsp['e'] = 'no';

	$__t = Php_Ls_Cln($_GET['_t']);
	$_vl = Php_Ls_Cln($_POST['_i']);
	$_tp = 'enc';
	$__dtec = GtEcDt($_vl, $_tp);

	if(!isN($__dtec) && !isN($__dtec->id)){

		if($__t == 'tll'){
			include('tll.php');
		}elseif($__t == 'cntc'){
			include('cntc.php');
		}elseif($__t == 'del'){
			include('del.php');
		}

	}elseif($__t == 'del' || $__t == 'upd'){

		include('sis.php');

	}elseif($__t == 'aprb'){

		include('aprb.php');

	}else{

		$rsp['e'] = 'n_d';

	}

Hdr_JSON();

if(!isN($rsp)){
	$rtrn = json_encode($rsp);
	echo $rtrn;
}

ob_end_flush();
?>