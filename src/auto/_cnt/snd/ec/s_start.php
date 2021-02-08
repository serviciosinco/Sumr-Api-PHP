<?php

foreach($___datprcs as $___datprcs_k=>$___datprcs_v){

	if($__dtec->id != $___datprcs_v['ecsnd_ec']){ $__dtec = ''; }

	$___allw_snd_m = '';

	try {

		if(in_array($___datprcs_v['id_ecsnd'], $___otprcs)){

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

						$__us_msj = '';

						//----------------------- PUSHMAIL DETAILS -----------------------//

						echo $this->li('Now get pushmail detail');
						//echo $this->li($__dtec->id.' different to '.$___datprcs_v['ecsnd_ec']);

						if($__dtec->id != $___datprcs_v['ecsnd_ec']){

							$__dtec = GtEcDt($___datprcs_v['ecsnd_ec'], 'id', [ 'dtl'=>[ 'cl'=>'ok' ] ]);

						}

						if(!isN($__dtec->enc) && !isN($__dtec->cod) && !isN($__dtec->fld)){

							echo $this->li('Now we have pushmail details - ext 1');

							//----------------------- SET DATA OF MAIL -----------------------//

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

								$___ec_html = $this->_aws->_s3_get([ 'b'=>'fle', 'gcnt'=>'ok', 'fle'=>_TmpFixDir(DIR_FLE_EC_SND.$___datprcs_v['ecsndhtml_enc'].'.html') ]);

								if(!isN($___ec_html->html)){
									$__us_msj = $___ec_html->html;
								}else{
									$__us_msj = NULL;
								}


						}else{

							echo $this->err('No pushmail detail');

						}

						//------------ ENVIO EL CORREO ------------/

						$__snd_ml = '';
						$_rsl_snd = '';

						//require('s_send.php'); // Send single email

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

	} catch (Exception $e) {

		$___lck = $this->Rqu([ 't'=>$__rqu_tp, 'cl'=>$_cl_v->id, 'lck'=>2 ]);

		if(!isN($this->id_ecsnd)){ $this->EcSnd_Rd([ 'bd'=>$_cl_v->bd, 'btch_c'=>'ok' ]); }

	    echo $this->err($e->getMessage());


	}

}

?>