<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Aws\Ses\SesClient;
use Aws\Ses\Exception\SesException;

//require dirname(dirname(__FILE__)).'/classes/PhpMailer/class.phpmailer.php';
//require dirname(dirname(__FILE__)).'/classes/PhpMailer/class.smtp.php';
//require dirname(dirname(__FILE__)).'/classes/PhpMailer/Exception.php';


class API_CRM_SndMail{

	private $key='';

	public function __construct($p=NULL){

		global $__cnx;

     	$this->_S_EML_NM = 'CRM - SUMR';

		$this->_aws = new API_CRM_Aws();
		$this->_out = new CRM_Out();
		$this->_imap = new CRM_Imap();
		$this->_eml = new CRM_Eml();
		$this->_cnt = new CRM_Cnt();

		$this->cnx = $this->_aws->cnx;
		$this->_rst();

    }

    public function _setbd($p=NULL){
		if(!isN($p['bd'])){
			$this->_cnt->bd = _BdStr($p['bd']);
		}
	}

    public function _rst(){

	    $this->_mail = new PHPMailer(true);
		$mail->SMTPKeepAlive = true;

		if(!isN($this->_S_EML_NM)){ $this->_S_EML_NM = NULL; }
		if(!isN($this->_S_EM_PRT)){ $this->_S_EM_PRT = NULL; }
		if(!isN($this->_S_EM_HOST)){ $this->_S_EM_HOST = NULL; }
		if(!isN($this->_S_EM_MAIL)){ $this->_S_EM_MAIL = NULL; }
		if(!isN($this->_S_EM_PSSW)){ $this->_S_EM_PSSW = NULL; }
		if(!isN($this->_S_EM_TP)){ $this->_S_EM_TP = NULL; }
		if(!isN($this->_S_EM_AWS_SES)){ $this->_S_EM_AWS_SES = NULL; }
		if(!isN($this->_S_EM_API_KEY)){ $this->_S_EM_API_KEY = NULL; }

    }

	public function __SndMl_Dfl($p=NULL){

		if(DMN_S == 'sumr.co'){

			$this->_S_EM_PRT = 465;
			$this->_S_EM_MAIL = 'notifications@sumr.co';
			$this->_S_EM_BCKUP = 'backup@sumr.co';
			$this->_S_EM_HOST = 'server.sumr.in';
			$this->_S_EML_SSL = 'ssl';
			$this->_S_EM_PSSW = 'cRKx[!L8l@EsfCq$$f';

		}else{

			$this->_S_EM_PRT = 25;
			$this->_S_EM_MAIL = 'notifications@sumrdev.com';
			$this->_S_EM_BCKUP = 'backup@sumrdev.com';
			$this->_S_EM_HOST = 'mail.sumrdev.com';
			$this->_S_EM_PSSW = 'cRKx[!L8l@EsfCq$$f';

		}

		if(defined('SUMR_ENV') && SUMR_ENV == 'prd'){
			//$this->_S_EM_BCKUP = 'backup@sumrdev.com';
		}elseif(defined('SUMR_ENV') && SUMR_ENV == 'dev'){
			//$this->_S_EM_BCKUP = 'backup@sumrdev.com';
		}


	}


	public function __out_aws_ses($p=NULL){

		global $__cnx;

		$__v['us_est'] = 'no';

		try {

			//echo h3(date("Y-m-d H:i:s").' Start Build').PHP_EOL;

			$mail = $this->_mail;
			$mail->Timeout = 30;
			$mail->SMTPDebug = 4;
			$mail->Debugoutput = 'html';
			$mail->setFrom($this->_S_EM_MAIL, $this->_S_EML_NM);
			$mail->addAddress($this->us_to);

			//if(!isN($this->_S_EM_BCKUP)){
				//$mail->addBCC('backup@sumr.co');
			//}
			//$mail->addAddress('success@simulator.amazonses.com');

			if(!isN($this->rply_eml)){ $mail->AddReplyTo($this->rply_eml,$this->rply_nm); }

			$mail->Subject = $this->us_as;
			$mail->MsgHTML($this->us_msj);
			$mail->CharSet = 'UTF-8';
			$mail->XMailer = 'SUMR-CRM';
			$mail->SMTPSecure = "tls";
			$mail->Port = 2587;

			$mail->SMTPOptions = [
			    'ssl'=>[
			        'verify_peer' => false ,
			        'verify_peer_name' => false,
			        'allow_self_signed' => false
			    ]
			];

			//$mail->AltBody = $textbody;

			if($this->sndr->flj == 'cl'){
				$mail->addCustomHeader('SUMR-FLJ', 'cl');
			}else{
				$mail->addCustomHeader('SUMR-FLJ', 'ec');

				if(!isN($this->g->cl) && !isN($this->g->cl->enc)){
					$mail->addCustomHeader('SUMR-CL', $this->g->cl->enc);
				}
			}

			if(!isN( $this->fle )){
				foreach($this->fle as $__ka=>$__va){
					if(!isN($__va->dir) && file_exists('../../'.$__va->dir)){
						$mail->AddAttachment('../../'.$__va->dir, $__va->nm);
					}
				}
			}
			//echo h3(date("Y-m-d H:i:s").' Start Presend').PHP_EOL;

			if(!$mail->preSend()){
			    $__v['us_w'] = $mail->ErrorInfo;
			}else{
			    $message = $mail->getSentMIMEMessage();
			}

			try {

				if(count( $mail->getToAddresses() ) === 1){

				    $__snd_e = 2;

				    if(isN($this->cmpgid)){

					    $result = $this->cnx->sendRawEmail([
					        'RawMessage' => [
					            'Data' => $message
					        ]
					    ]);

					    $messageId = $result->get('MessageId');

						if(!isN($messageId)){
							$__v['us_exito'] = true;
							$__v['us_est'] = 'ok';
							$__v['us_id'] = $messageId;
							 $__snd_e = 1;
						}else{
							$__v['us_est'] = 'no';
						}

						/*$insertSQL = sprintf("INSERT INTO ".DBM.".__SNDTEST (tmpsend_mail, tmpsend_cmpg, tmpsend_id, tmpsend_address, tmpsend_all, tmpsend_result, tmpsend_from, tmpsend_e) VALUES (%s,%s,%s,%s,%s,%s,%s,%s)",
							   GtSQLVlStr($__v['us_exito'].' '.$this->us_to, "text"),
							   GtSQLVlStr($this->cmpgid, "text"),
							   GtSQLVlStr($this->btchid.' - '.$messageId, "text"),
							   GtSQLVlStr(count($mail->getToAddresses()).print_r($mail->getToAddresses(), true), "text"),
							   GtSQLVlStr(print_r($mail, true), "text"),
							   GtSQLVlStr(print_r($result, true), "text"),
							   GtSQLVlStr($this->_S_EM_MAIL.'<'.$this->_S_EML_NM.'>', "text"),
							   GtSQLVlStr($__snd_e, "int"));

						$Result = $__cnx->_prc($insertSQL);*/

					}

					$mail->ClearAddresses();
	                $mail->ClearAllRecipients();

			    }

			} catch (SesException $error) {

				$mail->ClearAddresses();
                $mail->ClearAllRecipients();

			    $__v['us_w'] = "The email was not sent. Error message: " .$error->getAwsErrorMessage()."\n";

			}

		} catch (SesException $error) {

		    $__v['us_w'] = "The email was not sent. Error message: ".$error->getAwsErrorMessage()."\n";

		}

		return($__v);

	}




	public function __out_icommkt($p=NULL){

		global $__cnx;

		$__v['us_est'] = 'no';

		try {

			$_data['From'] = $this->_S_EML_NM.' '.$this->_S_EM_MAIL;
			$_data['To'] = $this->us_to;

			if(!isN($this->_S_EM_BCKUP)){ $_data['Bcc'] = $this->_S_EM_BCKUP; }
			if(!isN($this->rply_eml)){  $_data['ReplyTo'] = $this->rply_eml; }

			$_data['Subject'] = $this->us_as;
			$_data['HtmlBody'] = $this->us_msj;
			//$_data['TextBody'] = 'Som test';
			//$_data['Tag'] = 'campaign-1-momento-1';
			$_data['TrackOpens'] = true;

			$this->_out->out = 'json';
			$this->_out->url = 'https://api.trx.icommarketing.com/email/';
			$this->_out->o_post = true;
			$this->_out->o_post_f = json_encode($_data);
			$this->_out->o_crqst = 'POST';
			$this->_out->o_tmout = 60;
			$this->_out->o_ctmout = 60;
			$this->_out->o_header_http = [
                'Content-Type:application/json',
                'X-Trx-Api-Key:'.$this->_S_EM_API_KEY
			];

			try {

				$__snd_e = 2;

				if(isN($this->cmpgid)){

					$try=0;

					while($try < 3){
						$rsp = $this->_out->_Rq($_p);
						if($rsp->code == 200 || $rsp->code == 201){ break; }
						sleep(5);
						$try++;
					}

					if(!isN($rsp->rsl->MessageID)){
						$__v['us_exito'] = true;
						$__v['us_est'] = 'ok';
						$__v['us_id'] = $rsp->rsl->MessageID;
						$__snd_e = 1;
					}else{
						$__v['us_est'] = 'no';
					}

					/*
					$insertSQL = sprintf("INSERT INTO ".DBM.".__SNDTEST (tmpsend_mail, tmpsend_cmpg, tmpsend_id, tmpsend_address, tmpsend_all, tmpsend_result, tmpsend_from, tmpsend_e) VALUES (%s,%s,%s,%s,%s,%s,%s,%s)",
							GtSQLVlStr($__v['us_exito'].' '.$this->us_to, "text"),
							GtSQLVlStr($this->cmpgid, "text"),
							GtSQLVlStr($this->btchid.' - '.$rsp->rsl->MessageID, "text"),
							GtSQLVlStr(count($_data['To']).print_r($_data, true), "text"),
							GtSQLVlStr(print_r($mail, true), "text"),
							GtSQLVlStr(print_r($result, true), "text"),
							GtSQLVlStr($this->_S_EM_MAIL.'<'.$this->_S_EML_NM.'>', "text"),
							GtSQLVlStr($__snd_e, "int"));

					$Result = $__cnx->_prc($insertSQL);
					*/

				}

			} catch (SesException $error) {

			    $__v['us_w'] = "The email was not sent. Error message: " .$error->getAwsErrorMessage()."\n";

			}

		} catch (SesException $error) {

		    $__v['us_w'] = "The email was not sent. Error message: ".$error->getAwsErrorMessage()."\n";

		}

		return($__v);

	}



	public function __out_smtp($p=NULL){

		if(!isN($this->from_n)){ $__sis_emlnm = $this->from_n; }else{ $__sis_emlnm = $this->_S_EML_NM; }

		// Usuario //
		if (!isN($this->_S_EM_MAIL)){

			$mail = $this->_mail;
			$mail->IsSMTP();
			$mail->SMTPAuth = true;
			$mail->Host = $this->_S_EM_HOST;
			$mail->Port = $this->_S_EM_PRT;

			if(!isN($this->_S_EML_SSL) && $this->_S_EML_SSL != 'SIS_EML_SSL'){
				$mail->SMTPSecure = $this->_S_EML_SSL;
			}

			$mail->Username = $this->_S_EM_MAIL;
			$mail->Password = $this->_S_EM_PSSW;
			$mail->CharSet = 'UTF-8';
			$mail->FromName = $__sis_emlnm;
			$mail->From = $this->_S_EM_MAIL;
			$mail->Timeout = 30;
			$mail->XMailer = 'SUMR-CRM';

			if(!isN($this->in_reply_to)){
				$mail->addCustomHeader('In-Reply-To', $this->in_reply_to);
				$mail->addCustomHeader('References', $this->in_reply_to);
			}

			if(/*SISUS_ID == 1 || */$_GET['Camilo']=='ok'){
				$mail->SMTPDebug = 4;
			}

			if(!isN($this->x_id)){
				$mail->MessageID = $this->x_id;
				$mail->addCustomHeader('X-SendID', $this->x_id);
			}


			if(!isN($this->_S_EML_AUTH)){
				$mail->AuthType = $this->_S_EML_AUTH;
			}

			$mail->SMTPOptions = [
			    'ssl'=>[
			        'verify_peer' => false ,
			        'verify_peer_name' => false,
			        'allow_self_signed' => false
			    ]
			];

			if(!isN( $this->fle )){
				foreach($this->fle as $__ka=>$__va){
					if(!isN($__va->dir) && file_exists('../../../'.$__va->dir)){
						$mail->AddAttachment($__va->dir, $__va->nm);
					}
				}

			}

			$mail->AddAddress($this->us_to);
			if(!isN($this->rply_eml)){ $mail->AddReplyTo($this->rply_eml,$this->rply_nm); }

			$mail->Subject = $this->us_as;
			$mail->MsgHTML($this->us_msj);
			$mail_exito = $mail->Send();

			$__v['us_exito'] = $mail_exito;

			$mail_int=1;

			while ((!$mail_exito) && ($mail_int < 5)){
				sleep(5);
				$mail_exito = $mail->Send();
				$mail_int=$mail_int+1;
			}

			if(!$mail_exito){
				$__v['us_est'] = 'no';
				$__v['us_w'] = 'Message:'.$mail->getMessage().' / '.$mail->ErrorInfo;
			}else{
				$__v['us_id'] = $mail->getLastMessageID();
				$__v['us_est'] = 'ok';
				if($this->r_mime == 'ok'){
					$__v['mime'] = $mail->getSentMIMEMessage();
				}
			}

		}else{

			$__v['w'] = '__out_smtp error: _S_EM_MAIL empty';

		}

		return($__v);

	}


	public function __SndMl($p=NULL){

		$___snd_eml = null;

		if (!isN($this->us_to)){

			$this->us_to = strtolower(str_replace(' ','',trim($this->us_to)));

			if(!isN($this->cl) && !isN($this->cl->id) && $this->sndr->srv != 'aws'){

				if($this->cl->id != $this->g__cl->id || isN($this->g__cl->id)){
					$this->g__cl = GtClDt( $this->cl->id, '', [ 'dtl'=>[ 'eml'=>'ok' ] ]);
				}

				if(!isN($this->sndr_e)){

					$___snd_eml = GtClEmlDt([ 'id'=>$this->sndr_e, 'box'=>'ok' ]);

					if(!isN($___snd_eml->id)){

						if($___snd_eml->ssl == 'ok'){
							if($___snd_eml->tp == _CId('ID_SISEML_OFC')){
								$this->_S_EML_SSL = 'tls';
								$this->_S_EML_AUTH = 'CRAM-MD5';
							}else{
								$this->_S_EML_SSL = 'ssl';
							}
						}

						$this->_S_EML_NM = $___snd_eml->nm;
						$this->_S_EM_PRT = $___snd_eml->out->prt;
						$this->_S_EM_HOST = $___snd_eml->out->srv;
						$this->_S_EM_MAIL = $___snd_eml->usr;
						$this->_S_EM_PSSW = $___snd_eml->pss;
						$this->_S_EM_TP = $___snd_eml->tp;
						$this->_S_EM_AWS_SES = $___snd_eml->aws->ses;
						$this->_S_EM_API_KEY = $___snd_eml->api->key;

						if($___snd_eml->sndr == 'no'){ $__not_sndr='ok'; }
						if(!isN($___snd_eml->nm)){ $__sis_emlnm = $___snd_eml->nm; }

					}

				}elseif(!isN($this->g__cl->eml->dfl)){

					if($this->g__cl->eml->dfl->ssl == 'ok'){
						if($this->g__cl->eml->dfl->tp == _CId('ID_SISEML_OFC')){
							$this->_S_EML_SSL = 'tls';
							$this->_S_EML_AUTH = 'CRAM-MD5';
						}else{
							$this->_S_EML_SSL = 'ssl';
						}
					}

					$this->_S_EML_NM = $this->g__cl->eml->dfl->nm;
					$this->_S_EM_PRT = $this->g__cl->eml->dfl->out->prt;
					$this->_S_EM_HOST = $this->g__cl->eml->dfl->out->srv;
					$this->_S_EM_MAIL = $this->g__cl->eml->dfl->usr;
					$this->_S_EM_PSSW = $this->g__cl->eml->dfl->pss;
					$this->_S_EM_TP = $this->g__cl->eml->dfl->tp;
					$this->_S_EM_AWS_SES = $this->g__cl->eml->dfl->aws->ses;
					$this->_S_EM_API_KEY = $this->g__cl->eml->dfl->api->key;

					if($this->g__cl->eml->dfl->sndr == 'no'){ $__not_sndr='ok'; }
					if(!isN($this->g__cl->eml->dfl->nm)){ $__sis_emlnm = $this->g__cl->eml->dfl->nm; }

				}else{

					$this->__SndMl_Dfl();

				}

			}else{

				$this->g__cl = null;
				$this->__SndMl_Dfl();

			}

			if(!isN($this->cl->id) && !isN($this->g__cl->id) || $this->sndr->flj == 'cl'){

				if(($this->sndr->srv == 'aws' || $this->_S_EM_AWS_SES == 'ok' || isN($this->sndr->srv) /*|| isN($this->g__cl->eml->dfl)*/ ) ){  //Si es servicio AWS SES
					$__tsnd = 'aws';
					$__v = $this->__out_aws_ses();
				}elseif($this->sndr->srv == 'icmmkt' || $this->_S_EM_TP == _CId('ID_SISEML_ICOMM')){ //Si es servicio IcomMarketing
					$__tsnd = 'icmk';
					$__v = $this->__out_icommkt();
				}else{ //Si es servicio SMTP

					$__tsnd = 'smtp';
					if($this->iscnv=='ok'){ $this->r_mime = 'ok'; }

					$__v = $this->__out_smtp();

					if($this->iscnv=='ok'){

						$_box_out_s = [];

						if(!isN($___snd_eml->bx) && !isN($___snd_eml->bx->ls)){
							foreach($___snd_eml->bx->ls as $_bx_k=>$_bx_v){
								if(!isN($_bx_v->cid) && $_bx_v->out->sve == 'ok'){
									$_box_out_s[] = $_bx_v->cid;
								}
							}
						}

						$__v['sve'] = $this->sve_cnv([ 'box'=>$_box_out_s, 'data'=>$__v ]);

					}

				}

			}else{

				if(!isN($this->cl->id)){ $__v['w'][] = '$this->cl->id empty'; }
				if(!isN($this->g__cl->id)){ $__v['w'][] = '$this->g__cl->id empty'; }

			}

		}

		$rtrn = _jEnc($__v);
		return($rtrn);

	}


	public function __BnceId($p=NULL){

		if($p['t'] == 'sub'){
			$__bnc = __LsDt([ 'k'=>'sis_snd_bnc_tp_s' ]);
			$__bnc_ls = $__bnc->ls->sis_snd_bnc_tp_s;
		}else{
			$__bnc = __LsDt([ 'k'=>'sis_snd_bnc_tp' ]);
			$__bnc_ls = $__bnc->ls->sis_snd_bnc_tp;
		}

		foreach($__bnc_ls as $_k_tp=>$_v_tp){

			if($_v_tp->key->vl == $p['key']){

				if(!isN($p['prnt'])){
					$__prnt = mBln($_v_tp->{$p['prnt']}->vl);
				}

				if(isN($__prnt) || $__prnt == 'ok'){
					$__v['id'] = $_v_tp->id;
					$__v['cns'] = $_v_tp->cns;
					break;
				}

			}

		}

		return( _jEnc($__v) );

	}





	public function sve_cnv($p=null){

		global $__cnx;

		$__cnx->c_p->autocommit(FALSE);

		$box = $p['box'];
		$snd = $p['data'];

		if(!isN($snd)){

			$__prcall = 'ok';

			if($snd['us_exito']){

				$this->_imap->c_eml = $this->cnv->eml;
				//$this->_imap->box = $box;

				if(!isN($box)){
					foreach($box as $box_k=>$box_v){
						$this->_imap->server_lbl = $box_v;
						$this->_imap->box = $box_v;
						$__mvetosnt = $this->_imap->_snt([ 'mime'=>$snd['mime'] ]);
						$rsp['t_box'][] = [ 'b'=>$box_v, 'r'=>$__mvetosnt ];
					}
				}

				$this->_eml->__t = 'eml_cnv';
				$this->_eml->emlcnv_id = $snd['us_id'];
				$this->_eml->emlcnv_eml = $this->cnv->eml;
				$this->_eml->emlcnv_snpt = $this->cnv->sbj;

				$__Prc_In = $this->_eml->In();

				if($__Prc_In->e == 'ok' && !isN($__Prc_In->id)){

					$__cnv_dt = GtMainCnvDt([ 'tp'=>'eml', 'maincnv_id'=>$__Prc_In->id, 'cmmt'=>'ok' ]);

					if(!isN($this->cnv->mdlcnt )){

						if(!isN($__cnv_dt->enc)){

							$this->_cnt->maincnv_enc = $__cnv_dt->enc;
							$this->_cnt->nw_id_mdlcnt = $this->cnv->mdlcnt ;
							$_sve_mdlcnt_cnv = $this->_cnt->MdlCntCnv([ 'cmmt'=>'ok' ]);

							if($_sve_mdlcnt_cnv->e == 'ok'){
								$rsp['e'] = 'ok';
								$rsp['id'] = $_sve_mdlcnt_cnv->id;
							}else{
								$__prcall = 'no';
								$rsp['w'][] = '$_sve_mdlcnt_cnv error:'.print_r($_sve_mdlcnt_cnv, true);
							}

						}else{

							if(isN($__cnv_dt->enc)){ $rsp['w'][] = 'GtMainCnvDt error:'.print_r($__cnv_dt, true); }

						}

					}

				}else{

					$__prcall = 'no';
					$rsp['w'][] = '$__Prc_In error:'.print_r($__Prc_In, true);

				}

			}else{

				$__prcall = 'no';
				$rsp['w'][] = '__SndMl error:'.print_r($snd, true);

			}

			if($__prcall == 'ok'){

				if($__cnx->c_p->commit()){
					$rsp['e'] = 'ok';
				}else{
					$rsp['e'] = 'no';
					$rsp['w'][] = 'Commit fails'.$__cnx->c_p->error;
				}

			}else{

				if($snd['us_exito']){
					$rsp['e'] = 'ok';
					$rsp['m'] = 'Sended but it was not saved';
					$rsp['wm'] = $rsp['w'];
					unset($rsp['w']);
				}

			}

		}

		$__cnx->c_p->autocommit(TRUE);

		return _jEnc($rsp);

	}


}


?>