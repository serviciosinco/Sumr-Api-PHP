<?php


	if($__dtec->id != $___datprcs_v['ecsnd_ec']){
		$__dtec = '';
	}

	try {

		$__snd_dt = GtEcSndDt([ 'id'=>$___datprcs_v['id_ecsnd'], 'bd'=>$_cl_v->bd.'.' ]);

		if($__snd_dt->html->e != 'ok' && in_array($___datprcs_v['id_ecsnd'], $___otprcs) && !isN($___datprcs_v['id_ecsnd'])){

		//----------------------- RELATED DATA -----------------------//

			$__us_as = NULL;

			$__reldata = GtCntRelData([
				'bd'=>$_cl_v->bd,
				'ecsnd'=>$___datprcs_v['id_ecsnd'],
				'cmpg'=>$__reldata_c
			]);

			if(!isN($__reldata->w)){
				print_r( $__reldata );
				exit();
			}else{
				//----------------------- ID Related to oportunity -----------------------//
				if(!isN($__reldata->cmpg->id)){ $__rlc_mdlc = $__reldata->cmpg->id; }else{ $__rlc_mdlc = NULL; }
				//----------------------- ID Related to oportunity -----------------------//
				if(!isN($__reldata->mdlcnt->id)){ $__rlc_mdlc = $__reldata->mdlcnt->id; }else{ $__rlc_mdlc = NULL; }
				//----------------------- ID Related to oportunity -----------------------//
				if(!isN($__reldata->dvrf->id)){ $__rlc_dvrf = $__reldata->dvrf->id; }else{ $__rlc_dvrf = NULL; }
				//----------------------- ID Related to any object -----------------------//
				if(!isN($__reldata->sndr->id)){ $__rlc_main = $__reldata->sndr->id; }else{ $__rlc_main = NULL; }
			}

		//----------------------- CAMPAIGN DETAILS -----------------------//

			if(!isN( $__reldata->cmpg->id ) || !isN($__cmpg_to_work_id)){

				if(!isN($__cmpg_to_work_id)){

					$___cmpg_to_dt = $__cmpg_to_work_id;

					if(!isN($this->g__i)){
						$___cmpg_to_dt_t = 'enc';
						$___cmpg_to_dt_compare = $__cmpg_dt->enc;
					}else{
						$___cmpg_to_dt_t = '';
						$___cmpg_to_dt_compare = $__cmpg_dt->id;
					}

				}elseif(!isN($__reldata->cmpg->id)){
					$___cmpg_to_dt = $__reldata->cmpg->id;
					$___cmpg_to_dt_t = '';
					$___cmpg_to_dt_compare = $__cmpg_dt->id;
				}

				if($___cmpg_to_dt != $___cmpg_to_dt_compare){

					echo $this->h2($this->__btch_id.' Check campaign details of '.$___cmpg_to_dt);

					$__cmpg_dt = GtEcCmpgDt([ 'id'=>$___cmpg_to_dt, 't'=>$___cmpg_to_dt_t, 'bd'=>$_cl_v->bd ]);

					echo $this->li($this->__btch_id.' No we get the campaign details');

					if(isN($__cmpg_dt->id)){
						$__cmpg_dt = '';
					}


				}

			}else{

				$__cmpg_dt = '';

			}

		//----------------------- SEND ALLOWED ? -----------------------//

			$this->id_ecsnd = $___datprcs_v['id_ecsnd'];

		//----------------------- SEND ALLOWED ? -----------------------//


			echo $this->li('Process EcSndId:'.$this->id_ecsnd );
			echo $this->li($this->__btch_id.':: Now its available and have to set to read state');
			echo $this->li( 'Memory Usage:'._MemSz().'Mb' );


			try{

				$__cnx->c_p->autocommit(FALSE);
				$__prcall = 'ok';
				$__prcall_w = [];
				$__us_msj = '';

				//----------------------- PUSHMAIL DETAILS -----------------------//

				echo $this->li('Now get pushmail detail');
				//echo $this->li($__dtec->id.' different to '.$___datprcs_v['ecsnd_ec']);

				if($__dtec->id != $___datprcs_v['ecsnd_ec']){
					$__dtec = GtEcDt($___datprcs_v['ecsnd_ec'], 'id', [ 'dtl'=>[ 'are'=>'ok', 'cod_trck'=>'ok' ] ]);
				}

				if(!isN($__dtec->enc) && !isN($__dtec->cod) && !isN($__dtec->fld)){

					echo $this->li('Now we have pushmail details');

					//$__us_eml = $___datprcs_v['ecsnd_eml'];
					$__snd_pxl = $___datprcs_v['ecsnd_enc'];


					//----------------------- SET REPLY MAIL -----------------------//

						if(isN($__cmpg_to_work_id)){

							if(!isN($__cmpg_dt->rply)){

								$__snd_rply_eml = $__cmpg_dt->rply;
								$__snd_rply_nm = $__cmpg_dt->sndr->from;

							}elseif(!isN($__cmpg_dt->sndr->rply)){

								$__snd_rply_eml = $__cmpg_dt->sndr->rply;
								$__snd_rply_nm = $__cmpg_dt->sndr->from;

							}elseif(!isN($_cl_v->nm) && !isN($__dtec->eml) && filter_var($__dtec->eml, FILTER_VALIDATE_EMAIL)){

								$__snd_rply_eml = $__dtec->eml;
								$__snd_rply_nm = $_cl_v->nm;

							}elseif(!isN($___datprcs_v['us_user']) && filter_var($___datprcs_v['us_user'], FILTER_VALIDATE_EMAIL)){

								//$__snd_rply_eml = $___datprcs_v['us_user'];
								//$__snd_rply_nm = ctjTx($___datprcs_v['us_nm'].' '.$___datprcs_v['us_ap'],'in');

							}else{

								$__snd_rply_eml = '';
								$__snd_rply_nm = '';

							}

						}else{

							$__snd_rply_eml = '';
							$__snd_rply_nm = '';

						}


					//------------ BUILD HTML MAIL - START ------------/

					$__ec->_reset();
					$__ec->id = $__dtec->enc;
					$__ec->bd = $_cl_v->bd.'.';
					$__ec->id_t = 'enc';

					if(!isN($__rlc_mdlc)){ $__ec->mdlc = $__rlc_mdlc; }else{ $__ec->mdlc=NULL; }
					if(!isN($__rlc_evnc)){ $__ec->evnc = $__rlc_evnc; }else{ $__ec->evnc=NULL; }
					if(!isN($__rlc_dvrf)){ $__ec->dvrf = $__rlc_dvrf; }else{ $__ec->dvrf=NULL; }
					if(!isN($__rlc_main)){ $__ec->rlcm = $__rlc_main; }else{ $__ec->rlcm=NULL; } // Id Relacionado General

					$__ec->frm = 'Ml';
					$__ec->html = 'ok';
					$__ec->btrck = 'ok'; echo $this->li('Let mask the urls');
					$__ec->snd_i = $__snd_pxl;
					$__ec->plcy_id = $___datprcs_v['ecsnd_plcy_id'];

					if($__cmpg_dt->scl == 'no'){ $__ec->ec_scl = 'no'; }
					if($__cmpg_dt->tll == 'no'){ $__ec->ec_tll = 'no'; }

					if(!isN($__cmpg_dt->prhdr)){
						$__ec->cmpg_prhdr = $__cmpg_dt->prhdr;
					}elseif(!isN($__dtec->prhdr)){
						$__ec->cmpg_prhdr = $__dtec->prhdr;
					}else{
						$__ec->cmpg_prhdr = NULL;
					}

					echo $this->li('Lets build html code of pushmail');
					echo $this->li('Memory Usage:'._MemSz().'Mb');

					$__us_msj = $__ec->_bld([ 'info'=>[ 'ec'=>$__dtec ] ]);

					echo $this->li('Lets build subject of pushmail');
					echo $this->li('Memory Usage:'._MemSz().'Mb');

					if(!isN($__cmpg_to_work_id) || !isN($__cmpg_dt->id)){

						echo $this->li('Search subject on campaign');

						if(!isN($__cmpg_dt->sbj)){
							echo $this->li( 'Set Subject Here 1' );
							$__us_as = $__ec->_sbj([ 't'=>$__cmpg_dt->sbj ]);
						}elseif(!isN($__dtec->sbj)){
							echo $this->li( 'Set Subject Here 2' );
							$__us_as = $__ec->_sbj([ 't'=>$__dtec->sbj ]);
						}elseif(!isN($__dtec->tt)){
							echo $this->li( 'Set Subject Here 3' );
							$__us_as = $__ec->_sbj([ 't'=>$__dtec->tt ]);
						}

					}else{

						if(!isN($__dtec->sbj)){
							echo $this->li( 'Set Subject Here 2' );
							$__us_as = $__ec->_sbj([ 't'=>$__dtec->sbj ]);
						}elseif(!isN($__dtec->tt)){
							echo $this->li( 'Set Subject Here 3' );
							$__us_as = $__ec->_sbj([ 't'=>$__dtec->tt ]);
						}else{
							echo $this->li('No subject at all');
						}

					}

					echo $this->li( 'Set Subject Value:'.$__us_as);

				}else{

					echo $this->err('No all data for pushmail');
					$__prcall = 'no';
					$__prcall_w[] = 'No all data for pushmail';

					if(isN($__dtec->enc)){ echo $this->err('No enc pushmail'); $__prcall_w[] = 'No enc pushmail'; }
					if(isN($__dtec->cod)){ echo $this->err('No code'); $__prcall_w[] = 'No code'; }
					if(isN($__dtec->fld)){ echo $this->err('No folder'); $__prcall_w[] = 'No folder'; }
					//print_r( $__dtec );

				}


				//------------ ENVIO EL CORREO ------------/

				if(!isN($__us_msj) && !isN($__dtec->cod) && !isN($__us_as)){

					$__uhtml = $__ec->_SndEcHtml([ 'cmmt'=>'ok', 'id'=>$___datprcs_v['id_ecsnd'], 'html'=>$__us_msj, 'invk'=>'ec_html_1' ]);

					if($__uhtml->e == 'ok'){

						$__rsl_ec = $__ec->_SndEc_UPD([
												'cmmt'=>'ok',
												'bd'=>$_cl_v->bd,
												'enc'=>$___datprcs_v['ecsnd_enc'],
												'sbj'=>$__us_as,
												'rply_eml'=>$__snd_rply_eml,
												'rply_nm'=>$__snd_rply_nm,
												'html'=>1
											]);

						if($__rsl_ec->e == 'ok' && isN($__ec->w)){

							echo $this->li('HTML creado exitosamente');

						}else{

							$__prcall = 'no';
							$__prcall_w[] = 'Error on $__rsl_ec: '.print_r($__rsl_ec, true);
							$__prcall_w[] = 'Error on $__ec->w: '.print_r($__ec->w, true);

							if(!isN($__rsl_ec->w)){
								echo $this->err('Problemas al actualizar '.print_r($__rsl_ec->w, true));
								echo $this->err(print_r($__rsl_ec, true));
								$__prcall_w[] = 'Problemas al actualizar '.print_r($__rsl_ec->w, true);
							}

							if(!isN($__rsl_ec->w)){
								echo $this->err('Problemas on $__ec->w '.print_r($__ec->w, true));
							}

						}

					}else{

						$__prcall = 'no';
						echo $this->err('Problemas al guardar HTML '.print_r($__uhtml, true));
						$__prcall_w[] = 'Problemas al guardar HTML '.print_r($__uhtml, true);

						if(!isN($__rsl_ec->w)){
							echo $this->err('Problemas on $__ec->w '.print_r($__ec->w, true));
						}

					}

				}else{

					$__prcall = 'no';
					echo $this->err('No all data');
					$__prcall_w[] = 'No all data';
					if(isN($__dtec->cod)){ echo $this->err('No all data'); $__prcall_w[] = 'No html code'; }
					if(isN($__us_msj)){ echo $this->err('No code HTML on $__us_msj'); $__prcall_w[] = 'No code HTML on $__us_msj'; }
					if(isN($__us_as)){ echo $this->err('No subject on $__us_as'); $__prcall_w[] = 'No subject on $__us_as'; }

				}


				if($__prcall == 'ok' && (isN($__prcall_w) || count($__prcall_w) == 0 ) ){

					if($__cnx->c_p->commit()){
						echo $this->scss('Commit - HTML creado exitosamente');
					}else{
						echo $this->err( $__cnx->c_p->error );
                        $__cnx->c_p->rollback();
					}

				}else{

					echo $this->err( 'Error $__prcall:'.$__prcall.print_r($__cnx->c_p->error, true) );
                    $__cnx->c_p->rollback();
					echo $this->err( print_r( $__prcall_w, true ) );

				}

				$__cnx->c_p->autocommit(TRUE);

			} catch (Exception $e) {

				$___lck = $this->Rqu([ 't'=>$__rqu_tp, 'cl'=>$_cl_v->id, 'lck'=>2 ]);
			    echo $e->getMessage();

			}

			$___chk = $this->EcSnd_Chk([ 'bd'=>$_cl_v->bd ]);

		}


	} catch (Exception $e) {

		$___lck = $this->Rqu([ 't'=>$__rqu_tp, 'cl'=>$_cl_v->id, 'lck'=>2 ]);
	    echo $this->err($e->getMessage());

	}


?>