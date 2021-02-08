<?php

$__cmpg_snt = 1; // Start 1 record wrap on bulk

foreach($___datprcs as $___datprcs_k=>$___datprcs_v){

	if($__cmpg_snt == 50){ $__cmpg_snt=1; $__cmpg_snt_blk=[]; } // If wrap 50 records, build another group

	$___allw_snd_m = '';

	try {


		if(in_array($___datprcs_v['id_ecsnd'], $___otprcs)){

			//----------------------- CAMPAIGN DETAILS -----------------------//

				require('c_cmpg.php');

			//----------------------- NOT ALLOWED SEND BY DEFAULT - CHECK STATUS FOR ALLOW-----------------------//

				require('allw.php');

			//----------------------- SEND ALLOWED ? -----------------------//

			if($___allw_snd == 'ok'){

				$this->id_ecsnd = $___datprcs_v['id_ecsnd'];

				echo $this->li(':: '.$this->__btch_id.':: Check EcSnd Before Send');

				$___chk = $this->EcSnd_Chk([ 'bd'=>$_cl_v->bd ]);

				if( $___chk->e == 'ok' && ($___chk->btch === $this->__btch_id || (!isN($___chk->diff) && $___chk->diff->i > 10) )){

					echo $this->li(':: '.$this->__btch_id.':: Now its available and have to set to read state');

					try {

						//----------------------- SET DATA OF MAIL -----------------------//

							/* AWS BULK EMAIL - NEW WAY TO CONTINUE WORK */

							$__cmpg_snt_blk[] = [
								'Destination'=>[
									'ToAddresses'=>['icgarzon@servicios.in'],
								],
								'ReplacementTemplateData'=>json_encode([
									'nombre'=>'Ivan Garzon',
									'subject'=>'DEMO',
									'tckt_id'=>'SOME',
									'link_800'=>'non',
									'link_801'=>'non'
								])
							];



							$__snd_pxl = $___datprcs_v['ecsnd_enc'];
							$__us_eml = $___datprcs_v['ecsnd_eml'];
							$__snd_rply_eml = ctjTx($___datprcs_v['ecsnd_rply_eml'],'in');
							$__snd_rply_nm = ctjTx($___datprcs_v['ecsnd_rply_nm'],'in');
							$__us_as = ctjTx($___datprcs_v['ecsnd_sbj'],'in');

						//------------ BUILD HTML MAIL - START ------------/

							$__ec->_reset();
							$__ec->id = $__dtec->enc;
							$__ec->bd = $_cl_v->bd.'.';
							$__ec->id_t = 'enc';
							$__ec->snd_i = $__snd_pxl;
							$__ec->plcy_id = $___datprcs_v['ecsnd_plcy_id'];
							if(!isN($__cmpg_dt->prhdr)){ $__prhdr = $__cmpg_dt->prhdr; }

						//------------ ENVIO EL CORREO ------------/

							$__cmpg_snt++;
							$__snd_ml = '';
							$_rsl_snd = '';


					} catch (Exception $e) {

						$this->EcSnd_Rd([ 'bd'=>$_cl_v->bd, 'btch_c'=>'ok' ]);
					    echo 'Excepción capturada on second level: ',  $e->getMessage(), "\n";

					}

					$___chk = $this->EcSnd_Chk([ 'bd'=>$_cl_v->bd ]);
					if($___chk->rd == 'ok'){ $this->EcSnd_Rd([ 'bd'=>$_cl_v->bd , 'btch_c'=>'ok' ]); }

				}else{

					echo $this->err('Not allowed');
					echo $this->li('Check Send Status ('.$this->Spn($___chk->e).')');
					echo $this->li('Read ('.$this->Spn($___chk->rd).')');
					echo $this->li('Process Batch ('.$this->Spn($this->__btch_id).')');
					echo $this->li('Read Date After 3 Minutes ('.$this->Spn($___datprcs_v['__rd_aft']).')');
					echo $this->li('Chk Detail Batch ('.$this->Spn($___chk->btch).')');

				}

			}else{

				echo $this->h2($___allw_snd.' - SndEc ('.$__us_eml.')  Not allowed send'.$this->Spn( $___allw_snd_m  , 'ok'), '_error');

			}

		}


		//------- Here do we have the update of 50 records sended

		if($__cmpg_snt == 50){

			echo $this->h2('Send this 50 bulkmail');


			if(!isN($__us_msj) && !isN($__us_eml) && !isN($__us_as)){

				if(!isN($__cmpg_dt->id)){
					if($__us_as === $__cmpg_dt->sbj){
						require('c_send.php'); // Send campaign email
					}else{
						echo $this->err('Not same subject: '.$__us_as.' / '.$__cmpg_dt->sbj);
					}
				}else{
					require('c_send.php'); // Send campaign email
				}

			}


			if($_rsl_snd->us_est == 'ok'){

				echo $this->li('Update send record');

				$__snd_e = $this->EcSnd_Upd([ 'bd'=>$_cl_v->bd ]);

				echo $this->li('Change read status to NO');
				$this->EcSnd_Rd([ 'bd'=>$_cl_v->bd ]);

				echo $this->li('Change status and some data cause it was sended');

				$__rsl_ec = $__ec->_SndEc_UPD([
								'bd'=>$_cl_v->bd,
								'enc'=>$___datprcs_v['ecsnd_enc'],
								'snd_id'=>$_rsl_snd->us_id,
								'srv_id'=>(SUMR_ENV!='prd'?'Dev':'Prd')
							]);

				echo $this->scss('Ok... it was procesed');

			}else{

				$__snd_rstrt = $this->EcSnd_Upd([ 'bd'=>$_cl_v->bd, 'e'=>_CId('ID_SNDEST_PRG') ]);
				$this->EcSnd_Rd([ 'bd'=>$_cl_v->bd, 'btch_c'=>'ok' ]);

			}


			$___chk_long_time = $this->EcSnd_Chk([ 'bd'=>$_cl_v->bd ]);

			if(!isN($___chk_long_time->diff->i) && $___chk_long_time->diff->i > 10){
				$this->EcSnd_Rd([ 'bd'=>$_cl_v->bd, 'btch_c'=>'ok' ]);
			}

		}


	} catch (Exception $e) {

		$___lck = $this->Rqu([ 't'=>$__rqu_tp, 'cl'=>$_cl_v->id, 'lck'=>2 ]);

		if(!isN($this->id_ecsnd)){ $this->EcSnd_Rd([ 'bd'=>$_cl_v->bd, 'btch_c'=>'ok' ]); }

	    if($this->g__s3 == 'cmpg_snd'){ $__rd_cmpg_p = $this->EcCmpg_Rd(); }

	    if(!isN($__cmpg_to_work_id) && $__rd_cmpg_p->e == 'ok' && $this->g__s3 == 'cmpg_snd'){

	    	$__rd_cmpg_p = $this->EcCmpg_Rd();

	    }

	    echo $this->err($e->getMessage());

	}

}

?>