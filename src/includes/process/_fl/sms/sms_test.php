<?php

		$rsp['e'] = 'no';
		
		
		
		$__SndSMS = new API_CRM_sms();
		$__SndSMS->snd_cel = $_POST['telsnd_tel'];
		$__SndSMS->snd_msj = $_POST['telsnd_msj'];
		$__SndSMS->snd_nm = $_POST['telsnd_frm'];
		$__SndSMS->snd_c = $_POST['telsnd_ps'];
		
		$__SndSMS_r = $__SndSMS->_SndSMS();

		
		if($__SndSMS_r->w){
			$rsp['w']['w'] = $__SndSMS_r->w;
		}elseif($__SndSMS_r->e == 'ok'){
			$rsp['api_id'] = $__SndSMS_r->snd->id;
			$rsp['e'] = 'ok';
		}else{
			$rsp['w']['cde'] = $__SndSMS_r->snd->error->code;
			$rsp['w']['dsc'] = $__SndSMS_r->snd->error->description;
		}
?>