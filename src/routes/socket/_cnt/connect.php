<?php 
	
	$Crm_Ws = new CRM_Ws();
	$Crm_Ses = new CRM_SES();

	$rsp['sadmin'] = 'no';
	$_all_dt = json_decode(json_encode(_PostRw()));

	//if( !isN($_all_dt['connectionId']) && !isN($_all_dt['event']['queryStringParameters']['_us']) ){ //Api GateWay

	if( !isN($_all_dt->usdvc_us) && !isN($_all_dt->uses_enc) || !isN($_POST["usdvc_us"]) && !isN($_POST["uses_enc"]) ){
		
		if(!isN($_all_dt->usdvc_us) && !isN($_all_dt->uses_enc)){
			$usdvc_us = $_all_dt->usdvc_us; //$_all_dt['event']['queryStringParameters']['_us']; //Api GateWay
			$uses_enc = $_all_dt->uses_enc; //$_all_dt['connectionId']; //Api GateWay
		}else if(!isN($_POST["usdvc_us"]) && !isN($_POST["uses_enc"])){
			$usdvc_us = $_POST["usdvc_us"]; 
			$uses_enc = $_POST["uses_enc"];
		}

		$__dt_us = GtUsDt($usdvc_us, 'enc');
		$__dt_ses = $Crm_Ses->GtSesDt([ 'i'=>$uses_enc ]);
		$__dt_dvc = GtUsDvcDt([ 'id'=>$__dt_ses->dvc->id ]);

		if(!isN( $__dt_us ) && !isN( $__dt_ses ) && !isN( $__dt_dvc ) && !isN( $__dt_dvc->enc )){
			$rsp['e'] = "ok";
			$rsp['dvc'] = $__dt_dvc->enc;
			$rsp['sadmin'] = ($__dt_us->lvl=='superadmin')?'ok':'no';
			$rsp['upd'] = UPDus_Onl([ 'id'=>$__dt_us->enc ]);
		}else{
			$rsp['w']['us'] = $__dt_us;
			$rsp['w']['ses'] = $__dt_ses;
			$rsp['w']['dvc'] = $__dt_dvc;
			$rsp['sadmin'] = ($__dt_us->lvl=='superadmin')?'ok':'no';
		}

	}else{

		$rsp['e'] = "no";
		$rsp['w'] = "No Data";

	}
	
?>