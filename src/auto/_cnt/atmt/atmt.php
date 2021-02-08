<?php

$_g_alw = $this->tallw([ 't'=>'key', 'id'=>'atmt' ]);

if( $_g_alw->est == 'ok' ){


	//------------------- Basic Parameters ---------------------//

		define('UNLCK_MIN', '3'); // Minutes Wait Unlock

	//--------- AUTO TIME CHECK - START ---------//

	$_AUTOP_d = $this->RquDt([ 't'=>'atmt', 's'=>10 ]);

	//$_AUTOP_d->e = 'ok';
	//$_AUTOP_d->hb = 'ok';

	if($_AUTOP_d->e == 'ok' && ($_AUTOP_d->hb == 'ok' || !isN($this->g__i))){

		$this->Rqu([ 't'=>'atmt' ]);

		if(!isN($this->g__i)){
			$qry_f = " AND id_atmt = '".$this->g__i ."'";
		}else{
			$qry_f = '';
		}

		try {

			echo $this->h1('Ejecuto Automation', '_cmpg');

			define('GL_ATMT_ACT', 'act/'); // Actions

			if($this->_s_cl->tot > 0){

				foreach($this->_s_cl->ls as $_cl_k=>$_cl_v){

					$_cl_dt = NULL;

					if( $this->tallw_cl([ 't'=>'key', 'id'=>'atmt', 'cl'=>$_cl_v->id ])->est == 'ok' ){

						//----------- SET VAR AGAIN FOR LOOP -----------//

							$___h_trgr = [];
							$_cl_dt = GtClDt($_cl_v->id);
							echo $this->h1('Proceso Automation '.$_cl_v->nm.' '.SIS_H2);

						//----------- CLIENT SPECIFIC -----------//

						$_AUTOP_d_cl = $this->RquDt([ 't'=>'atmt', 'cl'=>$_cl_v->id, 'm'=>2 ]);

						echo $this->h2($_AUTOP_d_cl->e.' - '.$_cl_v->nm.' - lock? '.$_AUTOP_d_cl->lck.' tot:'.$_AUTOP_d_cl->tot, '', '_check');

						//$_AUTOP_d_cl->e = 'ok';
						//$_AUTOP_d_cl->lck = 'ok';

						if($_AUTOP_d_cl->e == 'ok' && ($_AUTOP_d_cl->lck != 'ok' || $_AUTOP_d_cl->hb == 'ok' || !isN($this->g__i))){ //----------- CHECK CLIENT ALLOWED -----------//

							$___lck = $this->Rqu([ 't'=>'atmt', 'cl'=>$_cl_v->id, 'lck'=>1 ]);

							echo $this->h3('Lock '.$_cl_v->nm.' / e:'.$___lck->e);

							if($___lck->e == 'ok'){

								$__Atmt = new CRM_Atmt();

								//Define los dias
								setlocale(LC_ALL,"es_ES");
								$__day_now = strtolower(strftime("%A"));
								$__days = _WkDays();

								//Consulta automatización
								$Ls_QryAtmt = "

											SELECT
													id_atmt, id_cletp, id_atmttrgr, id_atmttrgract, atmttrgract_act,
													atmt_enc, atmt_cl, atmt_nm, atmt_allmdl,
													atmttrgr_enc, atmttrgr_nm, atmttrgr_trgr, atmttrgr_hbl, atmttrgr_ord, atmttrgr_rpt, atmttrgr_fi, atmttrgr_hbl, atmttrgr_v_ls, atmttrgr_v_vl, atmttrgr_dly, atmttrgr_lnl
													atmttrgr_dly_v, atmttrgr_sch_h1, atmttrgr_sch_h2,
													atmttrgr_sch_d_1, atmttrgr_sch_d_2, atmttrgr_sch_d_3, atmttrgr_sch_d_4, atmttrgr_sch_d_5, atmttrgr_sch_d_6, atmttrgr_sch_d_7,
													atmttrgr_invk_api, atmttrgr_invk_up, atmttrgr_invk_crm, atmttrgr_invk_auto, atmttrgr_invk_form, atmttrgract_fa,
													cletp_nm,

													( atmt_rd_f < NOW() - INTERVAL 3 MINUTE ) AS __rd_aft,

													(SELECT GROUP_CONCAT(CONCAT( atmttrgrcndc_cndc, '<->', atmttrgrcndc_v_vl ))
														FROM ".DBA.".".TB_ATMT_TRGR_CNDC." WHERE atmttrgrcndc_trgr = id_atmttrgr
													) AS _cndc,

													"._QrySisSlcF([ 'als'=>'t', 'als_n'=>'Trigger' ]).",
													"._QrySisSlcF([ 'als'=>'d', 'als_n'=>'Delay']).",
													"._QrySisSlcF([ 'als'=>'s', 'als_n'=>'Schedules']).",
													"._QrySisSlcF([ 'als'=>'a', 'als_n'=>'Action']).",
													".GtSlc_QryExtra([ 't'=>'fld', 'p'=>'Trigger', 'als'=>'t' ]).",
													".GtSlc_QryExtra([ 't'=>'fld', 'p'=>'Delay', 'als'=>'d' ]).",
													".GtSlc_QryExtra([ 't'=>'fld', 'p'=>'Schedules', 'als'=>'s' ]).",
													".GtSlc_QryExtra([ 't'=>'fld', 'p'=>'Action', 'als'=>'a' ])."

											FROM ".DBA.".".TB_ATMT."
												INNER JOIN "._BdStr(DBM).TB_CL." ON atmt_cl = id_cl
												INNER JOIN ".DBA.".".TB_ATMT_TRGR." ON atmttrgr_atmt = id_atmt
												INNER JOIN "._BdStr(DBM).TB_CL_ETP." ON atmttrgr_etp = id_cletp
												INNER JOIN ".DBA.".".TB_ATMT_TRGR_ACT." ON atmttrgract_trgr = id_atmttrgr
												INNER JOIN ".DBA.".".TB_ATMT_ETP." ON atmtetp_atmt = id_atmt
												".GtSlc_QryExtra([ 't'=>'tb', 'col'=>'atmttrgr_trgr', 'als'=>'t' ])."
												".GtSlc_QryExtra([ 't'=>'tb', 'col'=>'atmttrgr_dly', 'als'=>'d' ])."
												".GtSlc_QryExtra([ 't'=>'tb', 'col'=>'atmttrgr_sch', 'als'=>'s' ])."
												".GtSlc_QryExtra([ 't'=>'tb', 'col'=>'atmttrgract_act', 'als'=>'a' ])."
												LEFT JOIN ".DBA.".".TB_ATMT_TP." ON atmttp_atmt = id_atmt
												LEFT JOIN "._BdStr(DBM).TB_MDL_S_TP." ON atmttp_tp = id_mdlstp

											WHERE 	id_atmt != '' AND
													atmt_on = 1 AND
													atmtetp_on = 1 AND
													atmttrgract_hbl = 1 AND
													(atmt_rd = 2 || atmt_rd_f < NOW() - INTERVAL ".UNLCK_MIN." MINUTE) AND
													atmttrgr_hbl=1 AND
													cl_on=1 AND
													cl_enc = '".$_cl_v->enc."'
													{$qry_f}

											/*ORDER BY id_atmt ASC, atmttrgr_ord ASC*/
											ORDER BY RAND()
											/*ORDER BY id_atmt, id_cletp DESC*/
											LIMIT 20
								";

								//echo $this->h1( compress_code($Ls_QryAtmt) );

								$Ls_AtmtRg = $__cnx->_qry($Ls_QryAtmt);

								if($Ls_AtmtRg){

									$row_Ls_AtmtRg = $Ls_AtmtRg->fetch_assoc();
									$Tot_Ls_AtmtRg = $Ls_AtmtRg->num_rows;

									if ($Tot_Ls_AtmtRg > 0){

										echo $this->h2('Registros ('.$Tot_Ls_AtmtRg.') '.SIS_H2);

										do {

											$___atmtdt = GtAtmtDt([ 'id'=>$row_Ls_AtmtRg['atmt_enc'], 't'=>'enc' ]);

											$_vld = "ok";
											$this->id_atmt = $row_Ls_AtmtRg['id_atmt'];
											$___chk = $this->Atmt_Chk();

											$_fl = '';

											if($___atmtdt->cl->id == $row_Ls_AtmtRg['atmt_cl'] && $___chk->e == 'ok' && ($___chk->rd != 'ok' || $row_Ls_AtmtRg['__rd_aft'] || !isN($this->g__i))){

												$__rd_p = $this->Atmt_Rd(['e'=>'on', 'bd'=>$_bd]);

												try {

													$___trigger_a = GtSlcF_JAttr($row_Ls_AtmtRg['___Trigger']);
													$___delay_a = GtSlcF_JAttr($row_Ls_AtmtRg['___Delay']);
													$___schedule_a = GtSlcF_JAttr($row_Ls_AtmtRg['___Schedules']);
													$___action_a = GtSlcF_JAttr($row_Ls_AtmtRg['___Action']);
													$___action_d = __LsDt(['k'=>'sis_atmt_act', 'id'=>$row_Ls_AtmtRg['atmttrgract_act'], 'no_lmt'=>'ok' ]);
													$___action_t = GtAtmtTrgrActDt([ 'id'=>$row_Ls_AtmtRg['id_atmttrgract'], 'dt'=>'ok' ]);


													///--------- ID LEVELS ARRAY ----------///

														$____id_etp = $row_Ls_AtmtRg['id_cletp'];
														$____id_atmt = $row_Ls_AtmtRg['id_atmt'];
														$____id_trgr = $row_Ls_AtmtRg['id_atmttrgr'];
														$____id_act = $row_Ls_AtmtRg['id_atmttrgract'];


													///--------- CHECK DAYS ----------///

														foreach($__days as $__days_k=>$__days_v){ //Valida si el dia de hoy tiene check
															if($__day_now == strtolower($__days_v)){
																if($row_Ls_AtmtRg['atmttrgr_sch_d_'.$__days_k] != 1){
																	$_vld = "no";
																}
															}
														}


													///--------- CHECK SCHEDULES ----------///

														if($row_Ls_AtmtRg['Schedules_id_sisslc'] == _CId('ID_SISATMTSCH_HRA')){ //Valida si la hora de envio tiene una hora en especifico
															if(SIS_H2 < $row_Ls_AtmtRg['atmttrgr_sch_h1']){
																$_vld = "no";
															}
														}elseif($row_Ls_AtmtRg['Schedules_id_sisslc'] == _CId('ID_SISATMTSCH_RNG')){ //Valida si la hora de envio tiene un rango
															if(SIS_H2 < $row_Ls_AtmtRg['atmttrgr_sch_h1'] ||  SIS_H2 > $row_Ls_AtmtRg['atmttrgr_sch_h2']){
																$_vld = "no";
															}
														}

													///--------- CHECK TRIGGER ON ----------///

														if($row_Ls_AtmtRg['atmttrgr_hbl'] != 1){
															$_vld = "no";
														}

														if($_vld == "ok"){
															$_dte_sty = ""; $_dte_tx = "ok";
														}else{
															$_dte_sty = "_no_dte";
															$_dte_tx = "No se puede enviar";
														}


													///--------- CHECK SOURCE ON ----------///


														$_invk_api = mBln($row_Ls_AtmtRg['atmttrgr_invk_api']);
														$_invk_up = mBln($row_Ls_AtmtRg['atmttrgr_invk_up']);
														$_invk_crm = mBln($row_Ls_AtmtRg['atmttrgr_invk_crm']);
														$_invk_auto = mBln($row_Ls_AtmtRg['atmttrgr_invk_auto']);
														$_invk_form = mBln($row_Ls_AtmtRg['atmttrgr_invk_form']);


													///--------- IMPRIMO AUTOMATION ----------///


														if($_vld == 'ok'){

															include('atmt_ext_1.php');

														}else{

															$___h_trgr[$____id_trgr] = "<div class='auto atmt_blq ".$_dte_sty."'> No valid to start</div>";

														}

														$this->Atmt_Rd();

												} catch (Exception $e) {

													$this->Atmt_Rd();
													echo $this->err('Excepción capturada: '.$e->getMessage());

													//break;
												}

											}else{

												echo $this->err('Atmt '.$row_Ls_AtmtRg['id_atmt'].' check:'.$___chk->e.' || Read Mode:'.$___chk->rd.' || After:'.$row_Ls_AtmtRg['__rd_aft']);

											}


										} while ($row_Ls_AtmtRg = $Ls_AtmtRg->fetch_assoc());


										foreach($___h_trgr as $_h_k=>$_h_v){

											$_box_main = $___h_trgr[$_h_k]['bx']; //------- Main Html

											$__t = $___h_trgr[$_h_k]['trgr']; //------- Trigger

											foreach($__t as $_trgr_k=>$_trgr_v){ //------- Rebuild Trigger

												$__a = $___h_trgr[$_h_k]['trgr'][$_trgr_k]['act']; //------- Actions Inside

												foreach($__a as $_act_k=>$_act_v){ //------- Rebuild Actions

													$__l = $___h_trgr[$_h_k]['trgr'][$_trgr_k]['act'][$_act_k]['leads']; //------- Leads Inside

													$_act_v['bx'] = str_replace('[ACT-'.$_act_k.']', $__l, $_act_v['bx']);

													$_act[$_trgr_k] .= $_act_v['bx'];

												}

												$_trgr_v['bx'] = str_replace('[TRGR-'.$_trgr_k.']', $_act[$_trgr_k], $_trgr_v['bx']);

												$_trgr[$_h_k] .= $_trgr_v['bx']; //------- Return Html

											}

											$_box_main = str_replace('[ATMT-'.$_h_k.']', $_trgr[$_h_k], $_box_main);

											echo $_box_main;

										}

									}

								}else{

									echo $this->h2('First Level:'.$__cnx->c_r->error);

								}

								$__cnx->_clsr($Ls_AtmtRg);

							}


							$___lck = $this->Rqu([ 't'=>'atmt', 'cl'=>$_cl_v->id, 'lck'=>2 ]);


						}else{ //----------- END CHECK CLIENT ALLOWED -----------//

							echo $this->h3('Lock '.$_cl_v->nm.' not allow for this cron');

						}

					}else{

						echo $this->nallw($_cl_v->nm.' Automation Off');

					}

				}

			}

			$this->Rqu([ 't'=>'atmt' ]);

		} catch (Exception $e) {

			$this->Rqu([ 't'=>'atmt' ]);

			echo $this->err('Error Proceso Automation: '. $e->getMessage() );

		}

	}else{

		echo $this->h2('Automation On Next'.$this->Spn('Leads'), 'Auto_Tme_Prg');
		echo $this->err('Automation $_AUTOP_d->e:'.$_AUTOP_d->e.' $_AUTOP_d->hb:'.$_AUTOP_d->hb);

	}

}else{

	echo $this->nallw('Global Automation Off');

}

?>