<?php
/*
@ini_set('display_errors', true); 
error_reporting(E_ALL);
define('DSERR','on');*/

	if( !isN($__dt_chat->id) && !isN($__dt_us->id) || !isN($__dt_us->id) ){ 
		
		if( !isN($__dt_chat->id) && !isN($__dt_us->id) ){ //Valida si existe conversacion
			//$_cnvrmsj_cnvr_enc = $_cnvrmsj_cnvr;
			//$_cnvrmsj_cnvr_enc = $__dt_chat->enc;
			$_cnvrmsj_cnvr_id = $__dt_chat->id;
		}

		if($_MainCnvDt->tp == 'sumr'){ //Guarda mensaje - CRM

			if($_MainCnvDt->d->e == 'ok'){
				
				$__chat->cnvrmsj_us = $__us_dt->id;
				$__chat->cnvrmsj_msj = $_cnvrmsj_msj;
				$__chat->cnvr_enc = $_MainCnvDt->d->enc;
				$__chat_sve = $__chat->_Cht_Msg_Nw();

				if($__chat_sve->e == 'ok'){
					$rsp['e'] = 'ok';
					$rsp['d']['id'] = $__chat_sve->id;
					$rsp['d']['snt'] = 'ok';
					$rsp['d']['f']['main'] = SIS_F_TS;
					$rsp['d']['f']['s1'] = _HrHTML(SIS_F_TS);
					$rsp['d']['me'] = 'ok';	
				}

			}

		}elseif($_MainCnvDt->tp == 'whtsp'){ //Guarda mensaje - Whatsapp
			
			$_CRM_Wthsp = new CRM_Wthsp();
			$_CRM_Wthsp->wthspcnvsnd_us = $__us_dt->msv_usr;
			$_CRM_Wthsp->_wthsp_cnv = $__dt_chat;
			$_CRM_Wthsp->wthspcnvmsg_message = $_cnvrmsj_msj;
			$_Cnv_Msg_In = $_CRM_Wthsp->_Snd();

			if($_Cnv_Msg_In->e == 'ok'){
				
				$rsp['d']['id'] = $_Cnv_Msg_In->id;
				$rsp['d']['snt'] = $_Cnv_Msg_In->snt;
				$rsp['d']['f']['main'] = SIS_F_TS;
				$rsp['d']['f']['s1'] = '[rcnt]';

				if($row_Ls_Rg['wthspfrom_id'] == $row_Ls_Rg['wthspfrom_no']){  
					$rsp['d']['me'] = 'ok';	
				}

			}else{

				$rsp['w'] = $_Cnv_Msg_In->w;

			}
			
		}
		
		if($Result || $__chat_sve->e == "ok" || $_Cnv_Msg_In->e == "ok"){
			
			/* No borrar */
			$rsp['e'] = 'ok';
			$rsp['tp'] = $__p3_o;

			$rsp['d']['tx'] = $_cnvrmsj_msj;
			$rsp['d']['us_enc'] = ctjTx($_cl_us, 'in');
			$rsp['d']['us_nm'] = ctjTx($__dt_us->nm." ".$__dt_us->ap, 'in');
			$rsp['d']['from'] = $_cl_us;

			if($_MainCnvDt->tp == 'sumr'){
			
			}

		}else{
	
			$rsp['e'] = 'no';
	
		}
	
	}else{

		$rsp['e'] = 'no';
		$rsp['w'] = 'falta data';

	}
	
?>