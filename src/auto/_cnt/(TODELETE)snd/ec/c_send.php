<?php

	try {


		if(!isN($__us_eml) && !isN($__us_as)){

			if($__dtec->cl->id == $_cl_v->id || $__dtec->frm->id == _CId('ID_SISECFRM_SIS')){

				echo $this->li('Start API_CRM_SndMail Instance');

				$__snd_ml = new API_CRM_SndMail();
				$__snd_ml->_setbd([ 'bd'=>$_cl_v->bd ]);

				$__snd_ml->_rst();
				$__snd_ml->cl->id = $_cl_v->id;
				$__snd_ml->from_n = $_cl_v->nm;
				$__snd_ml->from_c = $__snd_eml_from;
				$__snd_ml->us_as = $__us_as;
				$__snd_ml->us_to = $__us_eml;
				$__snd_ml->x_id = $__snd_pxl;
				$__snd_ml->sndr_e = $__snd_eml;
				$__snd_ml->rply_eml = $__snd_rply_eml;
				$__snd_ml->rply_nm = $__snd_rply_nm;
				$__snd_ml->prhdr = $__prhdr;
				$__snd_ml->cmpgid = $__cmpg_dt->id;
				$__snd_ml->btchid = $this->__btch_id;

				$__snd_ml->iscnv = 'no';
				$__snd_ml->sndr->srv = null;
				$__imap_s = null;


				$snd_mail_f->fle = (!isN($__ec->fle)?$__ec->fle:'');

				echo $this->li('Check EcSnd Once Again Before Send');

				$___chk_again = $this->EcSnd_Chk([ 'bd'=>$_cl_v->bd ]);

				if(	$___chk_again->e == 'ok' &&
					$___chk_again->rd == 'ok' &&
					!isN($___chk_again->btch) &&
					!isN($this->__btch_id) &&
					$___chk_again->btch == $this->__btch_id &&
					isN($___chk_again->cid) &&
					$___chk_again->est != _CId('ID_SNDEST_SND')
				){

					echo $this->li('Update status to sended before send, to prevent duplicated');

					$__snd_e = $this->EcSnd_Upd([ 'bd'=>$_cl_v->bd ]);

					if($__snd_e->e == 'ok'){
						echo $this->li('Now we connect to send mail');
						$_rsl_snd = $__snd_ml->__SndMl([ 'imap'=>$__imap_s ]);
					}else{
						$this->EcSnd_Upd([ 'bd'=>$_cl_v->bd, 'e'=>_CId('ID_SNDEST_PRG') ]);
						$_rsl_snd = '';
					}

					if($_rsl_snd->us_exito){
						$TotEcSnd_Snd++;
					}

				}else{

					$__snd_api = '';

				}

			}else{

				echo $this->err('Id pushmail not same $__dtec->cl->id ('.$__dtec->cl->id.') == $_cl_v->id ('.$_cl_v->id.')');
				//print_r( $__dtec );

			}

		}else{

			echo $this->err('No HTML code on Send');

			$__rsl_ec = $__ec->_SndEc_UPD([
				'bd'=>$_cl_v->bd,
				'enc'=>$___datprcs_v['ecsnd_enc'],
				'html'=>2
			]);

		}

	} catch (Exception $e) {

	    $___lck = $this->Rqu([ 't'=>$__rqu_tp, 'cl'=>$_cl_v->id, 'lck'=>2 ]);
	    if($this->g__s3 == 'cmpg_snd'){ $__rd_cmpg_p = $this->EcCmpg_Rd(); }
	    echo $this->err($e->getMessage());

	}


?>