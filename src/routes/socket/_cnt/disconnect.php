<?php 
	
	$Crm_Ws = new CRM_Ws();
	$Crm_Ses = new CRM_SES();

	$_all_dt = json_decode(json_encode(_PostRw()));

	if( !isN($_all_dt->usdvc_us) || !isN($_POST["usdvc_us"]) ){
		
		if(!isN($_all_dt->usdvc_us)){
			$usdvc_us = $_all_dt->usdvc_us;
		}else if(!isN($_POST["usdvc_us"])){
			$usdvc_us = $_POST["usdvc_us"];
		}

		$__dt_us = GtUsDt($usdvc_us, 'enc');

		if(!isN( $__dt_us )){
			$rsp['e'] = 'ok';
			$rsp['upd'] = UPDus_Onl([ 'id'=>$__dt_us->enc, 'rst'=>'ok' ]);
		}else{
			$rsp['w']['us'] = $__dt_us;
		}

	}else{

		$rsp['e'] = "no";
		$rsp['w'] = "No Data";

	}
	
?>