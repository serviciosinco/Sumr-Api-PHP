<?php 
	if (	
			_Chk_VLE('SndUs', 'p') && 
			$_POST['SndUs'] == 'On' &&
			_Chk_VLE('us', 'p')
		){

			$_vl = Php_Ls_Cln($_POST['_i']);
			$__dtec = GtEcDt($_vl);
		
			$_us_eml = $_POST['us'];		
			if(!isN($__dtec->id)){ include('_fl/em/html_ec_rpr.php');}

		if($_rsl_snd->us_est == 'ok' && $_rsl_snd->us_exito == true){
			$rsp['e'] = 'ok';
		}else{
			$rsp['e'] = 'no_send';
			$rsp['es'] = $_rsl_snd;
		}

		$rsp['__url'] = $__url;
	}else{
		$rsp['e'] = 'no_data';
	}
?>