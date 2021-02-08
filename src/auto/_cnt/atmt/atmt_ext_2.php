<?php


	//--------- Valida modulos seleccionados ----------//

		$_mdl_v_a='';
		$__atmt_a_tb_innr='';
		$has_trgr_allw = 'ok';

		if(!isN($___atmtdt->w)){

			echo $this->err('Atmt Detail Error');
			exit();

		}elseif($___atmtdt->e == 'ok' && $___atmtdt->mdl->tot > 0){

			$_mdl_v_a=[];

			foreach($___atmtdt->mdl->ls as $_mdl_k=>$_mdl_v){
				array_push($_mdl_v_a, $_mdl_v->id);
			}

			if(!isN($_mdl_v_a)){
				$_fl .= ' AND mdlcnt_mdl IN ('.implode(',', $_mdl_v_a).')';
			}

		}


	//--------- Valida fuentes seleccionadas ----------//

		if($_invk_api=='ok'){ $_fl_invk[] = ' mdlcnt_invk='._CId('ID_SISINVK_API').' '; }
		if($_invk_up=='ok'){ $_fl_invk[] = ' mdlcnt_invk='._CId('ID_SISINVK_UP').' '; }
		if($_invk_crm=='ok'){ $_fl_invk[] = ' mdlcnt_invk='._CId('ID_SISINVK_CRM').' '; }
		if($_invk_auto=='ok'){ $_fl_invk[] = ' mdlcnt_invk='._CId('ID_SISINVK_AUTO').' '; }
		if($_invk_form=='ok'){ $_fl_invk[] = ' mdlcnt_invk='._CId('ID_SISINVK_FORM').' '; }

		if(!isN($_fl_invk) && is_array($_fl_invk)){ $_fl .= ' AND ('.implode(' || ', $_fl_invk).')'; }

		$_fl_fi .= " AND mdlcnt_fi > DATE('".$row_Ls_AtmtRg['atmttrgract_fa']."') "; //Aplica para todos los casos excepto para cambio de estado

	//--------- Query filters in each trigger selected ----------//

		if($row_Ls_AtmtRg['atmttrgr_trgr'] == _CId('ID_SISATMTTRGR_SNDEC')){ //---- Pushmail Opened ----//

			$_fl .= ' AND id_cnt IN ( 	SELECT ecsnd_cnt
										FROM '._BdStr($_cl_v->bd).TB_EC_SND.'
											 INNER JOIN '._BdStr($_cl_v->bd).TB_MDL_CNT_EC.' ON mdlcntec_ecsnd = id_ecsnd
										WHERE ecsnd_ec = "'.$row_Ls_AtmtRg['atmttrgr_v_ls'].'" AND
											  CONCAT(ecsnd_f," ",ecsnd_h) > DATE("'.$row_Ls_AtmtRg['atmttrgract_fa'].'") AND
											  (
												ecsnd_est = "'._CId('ID_SNDEST_SND').'" ||
												ecsnd_est = "'._CId('ID_SNDEST_ACPT').'"
											  ) AND
											  mdlcntec_mdlcnt = id_mdlcnt
									) ';

			$__atmt_a_tp = 'mdl_cnt';
			$__atmt_a_tp_id = 'id_mdlcnt';

		}elseif($row_Ls_AtmtRg['atmttrgr_trgr'] == _CId('ID_SISATMTTRGR_SNDEC_OPN')){ //---- Pushmail Opened ----//

			$_fl .= ' AND id_cnt IN ( 	SELECT ecsnd_cnt
										FROM '._BdStr($_cl_v->bd).TB_EC_OP.'
											 INNER JOIN '._BdStr($_cl_v->bd).TB_EC_SND.' ON ecop_snd = id_ecsnd
											 INNER JOIN '._BdStr($_cl_v->bd).TB_MDL_CNT_EC.' ON mdlcntec_ecsnd = id_ecsnd
										WHERE ecsnd_ec = "'.$row_Ls_AtmtRg['atmttrgr_v_ls'].'" AND
											  CONCAT(ecop_f," ",ecop_h) > DATE("'.$row_Ls_AtmtRg['atmttrgract_fa'].'") AND
											  mdlcntec_mdlcnt = id_mdlcnt
									) ';

			$__atmt_a_tp = 'mdl_cnt';
			$__atmt_a_tp_id = 'id_mdlcnt';

		}elseif($row_Ls_AtmtRg['atmttrgr_trgr'] == _CId('ID_SISATMTTRGR_CNT_APPL')){ //---- Application Inserted ----//

			$_fl .= ' AND mdlcnt_cnt IN(
										SELECT cntappl_cnt
										FROM '._BdStr($_cl_v->bd).TB_CNT_APPL.'
										WHERE cntappl_mdl = mdlcnt_mdl AND
											  cntappl_cnt = mdlcnt_cnt AND
										      cntappl_fi > DATE("'.$row_Ls_AtmtRg['atmttrgract_fa'].'")
									) ';

			$__atmt_a_tp = 'mdl_cnt';
			$__atmt_a_tp_id = 'id_mdlcnt';

		}elseif($row_Ls_AtmtRg['atmttrgr_trgr'] == _CId('ID_SISATMTTRGR_MDLCNT_EST')){ //---- Cambio de estado ----//

			$_fl_fi = " ";

			$_fl .= ' AND id_mdlcnt IN ( 	SELECT mdlcntest_mdlcnt
											FROM '._BdStr($_cl_v->bd).TB_MDL_CNT_EST.'
											WHERE mdlcntest_est = "'.$row_Ls_AtmtRg['atmttrgr_v_ls'].'" AND
												  mdlcntest_fi > DATE("'.$row_Ls_AtmtRg['atmttrgract_fa'].'") AND
												  mdlcntest_est = mdlcnt_est AND
												  mdlcntest_mdlcnt = id_mdlcnt
										) ';

			$__atmt_a_tp = 'mdl_cnt';
			$__atmt_a_tp_id = 'id_mdlcnt';

		}elseif($row_Ls_AtmtRg['atmttrgr_trgr'] == _CId('ID_SISATMTTRGR_MDLCNT_EST_TP')){ //---- Cambio de etapa ----//

			$_fl_fi = " ";

			$_fl .= ' AND id_mdlcnt IN ( 	SELECT mdlcntest_mdlcnt
											FROM '._BdStr($_cl_v->bd).TB_MDL_CNT_EST.'
												 INNER JOIN '._BdStr(DBM).TB_SIS_CNT_EST.' ON mdlcntest_est = id_siscntest
											WHERE siscntest_tp = "'.$row_Ls_AtmtRg['atmttrgr_v_ls'].'" AND
												  mdlcntest_fi > DATE("'.$row_Ls_AtmtRg['atmttrgract_fa'].'") AND
												  mdlcntest_est = mdlcnt_est AND
												  mdlcntest_mdlcnt = id_mdlcnt
										) ';

			$__atmt_a_tp = 'mdl_cnt';
			$__atmt_a_tp_id = 'id_mdlcnt';

		}elseif($row_Ls_AtmtRg['atmttrgr_trgr'] == _CId('ID_SISATMTTRGR_LEAD_EML_IN')){ //---- Lead Inserted ----//



		}elseif($row_Ls_AtmtRg['atmttrgr_trgr'] == _CId('ID_SISATMTTRGR_LEAD_IN')){ //---- Lead Inserted ----//

			$__atmt_a_tp = 'mdl_cnt';
			$__atmt_a_tp_id = 'id_mdlcnt';

		}elseif($row_Ls_AtmtRg['atmttrgr_trgr'] == _CId('ID_SISATMTTRGR_MDLCNTPAY_IN')){ //---- Payment Inserted ----//

			$__atmt_a_tp = 'mdl_cnt_pay';
			$__atmt_a_tp_id = 'id_mdlcntpay';
			$__atmt_a_tb_innr = 'INNER JOIN '._BdStr($_cl_dt->bd).TB_MDL_CNT_PAY.' ON mdlcntpay_mdlcnt = id_mdlcnt';

		}elseif($row_Ls_AtmtRg['atmttrgr_trgr'] == _CId('ID_SISATMTTRGR_EML_CLCK')){ //---- Click en Email (Cualquier Link) ----//

			$_fl_fi = " AND mdlcnt_fa > DATE('".$row_Ls_AtmtRg['atmttrgract_fa']."') ";

			$_fl .= ' AND id_cnt IN ( 	SELECT ecsnd_cnt
										FROM '._BdStr($_cl_v->bd).TB_EC_TRCK.'
											 INNER JOIN '._BdStr($_cl_v->bd).TB_EC_SND.' ON ectrck_snd = id_ecsnd
										WHERE ecsnd_ec = "'.$row_Ls_AtmtRg['atmttrgr_v_ls'].'" AND
											  ectrck_f > DATE("'.$row_Ls_AtmtRg['atmttrgract_fa'].'")
									) ';

			$__atmt_a_tp = 'mdl_cnt';
			$__atmt_a_tp_id = 'id_mdlcnt';

		}elseif($row_Ls_AtmtRg['atmttrgr_trgr'] == _CId('ID_SISATMTTRGR_EML_OPNNO')){ //---- Email Not Opened ----//



		}elseif($row_Ls_AtmtRg['atmttrgr_trgr'] == _CId('ID_SISATMTTRGR_MDLCNT_CHK')){ //---- Check Seleccinado ----//

			$_fl_fi = " AND mdlcnt_fa > DATE('".$row_Ls_AtmtRg['atmttrgract_fa']."') ";

			$_fl .= ' AND id_mdlcnt IN ( 	SELECT mdlcntchck_mdlcnt
											FROM '._BdStr($_cl_v->bd).TB_MDL_CNT_CHCK.'
											WHERE mdlcntchck_sisslc = "'.$row_Ls_AtmtRg['atmttrgr_v_ls'].'" AND
											      mdlcntchck_mdlcnt = id_mdlcnt AND
												  mdlcntchck_fi > DATE("'.$row_Ls_AtmtRg['atmttrgract_fa'].'")
										) ';

			$__atmt_a_tp = 'mdl_cnt';
			$__atmt_a_tp_id = 'id_mdlcnt';

			echo $this->li('---------------------------- ID_SISATMTTRGR_MDLCNT_CHK:'.compress_code($_fl).' --------------------------------');

		}elseif($row_Ls_AtmtRg['atmttrgr_trgr'] == _CId('ID_SISATMTTRGR_TCKT_SAC_IN')){ //---- Check Seleccinado ----//

			$_fl_fi = " AND mdlcnt_fa > DATE('".$row_Ls_AtmtRg['atmttrgract_fa']."') ";

			$_fl .= ' AND id_mdlcnt IN ( 	SELECT mdlcnttra_mdlcnt
											FROM '._BdStr($_cl_v->bd).TB_MDL_CNT_TRA.'
											WHERE mdlcnttra_mdlcnt = id_mdlcnt AND
												  mdlcnttra_fi > DATE("'.$row_Ls_AtmtRg['atmttrgract_fa'].'")
										) ';

			$__atmt_a_tp = 'mdl_cnt';
			$__atmt_a_tp_id = 'id_mdlcnt';

			echo $this->li('---------------------------- ID_SISATMTTRGR_TCKT_SAC_IN:'.compress_code($_fl).' --------------------------------');

		}elseif($row_Ls_AtmtRg['atmttrgr_trgr'] == _CId('ID_SISATMTTRGR_MDLCNT_CHK')){ //---- Check Seleccinado ----//

			$_fl_fi = " AND mdlcnt_fa > DATE('".$row_Ls_AtmtRg['atmttrgract_fa']."') ";

			$_fl .= ' AND id_mdlcnt IN ( 	SELECT mdlcntchck_mdlcnt
											FROM '._BdStr($_cl_v->bd).TB_MDL_CNT_CHCK.'
											WHERE mdlcntchck_sisslc = "'.$row_Ls_AtmtRg['atmttrgr_v_ls'].'" AND
											      mdlcntchck_mdlcnt = id_mdlcnt AND
												  mdlcntchck_fi > DATE("'.$row_Ls_AtmtRg['atmttrgract_fa'].'")
										) ';

			$__atmt_a_tp = 'mdl_cnt';
			$__atmt_a_tp_id = 'id_mdlcnt';

		}else{

			echo $this->err('No trigger(atmttrgr_trgr:'.$row_Ls_AtmtRg['atmttrgr_trgr'].') for record (id_atmttrgr:'.$row_Ls_AtmtRg['id_atmttrgr'].') for atmt (id_atmt:'.$row_Ls_AtmtRg['id_atmttrgr'].') code writed ');
			$has_trgr_allw = 'no';

		}

	//--------- Execute Query ----------//

	if($has_trgr_allw == 'ok'){

		$Ls_Qry_Mdl = "	SELECT
								id_mdlcnt,
								mdlcnt_fi,
								mdl_nm,
								cnt_enc,
								cnt_nm,
								siscntest_tt

						FROM 	".$_cl_dt->bd.".".TB_MDL_CNT."
								INNER JOIN ".$_cl_dt->bd.".".TB_MDL." ON mdlcnt_mdl = id_mdl
								INNER JOIN "._BdStr(DBM).TB_SIS_CNT_EST." ON id_siscntest = mdlcnt_est
								INNER JOIN ".$_cl_dt->bd.".".TB_CNT." ON id_cnt = mdlcnt_cnt
								{$__atmt_a_tb_innr}

						WHERE   id_mdlcnt != '' $_fl

								AND ".$__atmt_a_tp_id." NOT IN (
																	SELECT atmtrg_id
																	FROM ".DBA.".".TB_ATMT_RG."
																	WHERE atmtrg_atmt = '".$row_Ls_AtmtRg['id_atmt']."' AND
																		atmtrg_trgr = '".$row_Ls_AtmtRg['id_atmttrgr']."' AND
																		atmtrg_act = '".$row_Ls_AtmtRg['id_atmttrgract']."' AND
																		atmtrg_tp = '".$__atmt_a_tp."'
																)

								AND id_cnt NOT IN (
													SELECT cnteml_cnt
													FROM ".$_cl_dt->bd.".".TB_CNT_EML."
													WHERE cnteml_est = '"._CId('ID_SISEMLEST_NOCHCK')."' OR cnteml_est = '"._CId('ID_SISEMLEST_SERV_NOCHCK')."'
												)

								$_fl_fi

						ORDER BY id_mdlcnt DESC
						LIMIT 50";

		$Ls_RgMdlCnt = $__cnx->_qry($Ls_Qry_Mdl);

		echo $this->li( compress_code( $Ls_Qry_Mdl ) );

		if($Ls_RgMdlCnt){

			$row_Ls_RgMdlCnt = $Ls_RgMdlCnt->fetch_assoc();
			$Tot_Ls_RgMdlCnt = $Ls_RgMdlCnt->num_rows;

			$__lead_h .= $this->h2( $Tot_Ls_RgMdlCnt.' records to process' );

			$Tot_Mdl_Cnt = 0;


			if($Tot_Ls_RgMdlCnt > 0){

				$__lead_h = '';

				do{

					$_vld = 'ok';
					$_vld_msg = '';
					$_exc_w = [];

					$__dt_mdlcnt = GtMdlCntDt([ 'id'=>$row_Ls_RgMdlCnt['id_mdlcnt'], 'cl'=>$_cl_v->enc, 'bd'=>$_cl_dt->bd, 'shw'=>[ 'cnt'=>'ok' ] ]);

					$__lead_h .= $this->li( $row_Ls_AtmtRg['atmttrgr_dly'].' -> Lead--------> '.$row_Ls_RgMdlCnt['id_mdlcnt'] );

					//--------- Valida si hay modulos o se aplica para todos los modulos ----------//

						if($___atmtdt->mdl->tot == 0 && mBln($row_Ls_AtmtRg['atmt_allmdl']) != 'ok'){
							$_vld = "no";
						}

					//--------- Valida si el tiempo de espera del triguer son dias ----------//

					if($row_Ls_AtmtRg['atmttrgr_dly'] == _CId('ID_SISATMTDLY_DAY') && $row_Ls_AtmtRg['atmttrgr_dly_v'] > 0){
						$_f1 = new DateTime($row_Ls_RgMdlCnt['mdlcnt_fi']);
						$_f2 = new DateTime(SIS_F2);
						$dif = $_f1->diff($_f2);
						if($dif->days < $row_Ls_AtmtRg['atmttrgr_dly_v']){
							$_vld = "no";
							$_vld_msg['dly_day'] = $dif->days.' < '.$row_Ls_AtmtRg['atmttrgr_dly_v'];
						}
					}

					//--------- Valida si el tiempo de espera del triguer son semanas ----------//

					if($row_Ls_AtmtRg['atmttrgr_dly'] == _CId('ID_SISATMTDLY_WEK') && $row_Ls_AtmtRg['atmttrgr_dly_v'] > 0){
						$_f1 = new DateTime($row_Ls_RgMdlCnt['mdlcnt_fi']);
						$_f2 = new DateTime(SIS_F2);
						$dif = $_f1->diff($_f2);
						$_wk = round( ($dif->days / 4) );
						if($_wk < $row_Ls_AtmtRg['atmttrgr_dly_v']){
							$_vld = "no";
							$_vld_msg['dly_wek'] = $_wk.' < '.$row_Ls_AtmtRg['atmttrgr_dly_v'];
						}
					}

					//--------- Valida si el tiempo de espera del triguer son horas ----------//

					if($row_Ls_AtmtRg['atmttrgr_dly'] == _CId('ID_SISATMTDLY_HRA') && $row_Ls_AtmtRg['atmttrgr_dly_v'] > 0){
						$_f1 = new DateTime($row_Ls_RgMdlCnt['mdlcnt_fi']);
						$_f2 = new DateTime(SIS_F_D2);
						$dif = $_f1->diff($_f2);
						if($dif->y == 0 && $dif->m == 0 && $dif->d == 0 && $dif->h < $row_Ls_AtmtRg['atmttrgr_dly_v']){
							$_vld = "no";
							$_vld_msg['dly_hra'] = print_r($dif, true).' - '.$row_Ls_AtmtRg['atmttrgr_dly_v'];
						}
					}


					//--------- Valida si se envia en este dia de la semana ----------//

					if(mBln($row_Ls_AtmtRg['atmttrgr_sch_d_'.date('N')]) != 'ok'){
						$_vld = "no";
						$_vld_msg['sch_day_'.date('w')] = 'Not allowed to send on this day';
					}


					//--------- Valida si es lineal ----------//

					if($row_Ls_AtmtRg['atmttrgr_lnl']){

						$MdlCntTrgrLnlChk = GtAtmtTrgrActLnlChk([

												'atmt'=>$row_Ls_AtmtRg['id_atmt'],
												'trgr'=>$row_Ls_AtmtRg['id_atmttrgr'],
												'id'=>$row_Ls_RgMdlCnt['id_mdlcnt'],
												'tp'=>$__atmt_a_tp
											]);

						if($MdlCntTrgrLnlChk->act->tot > 0){

							foreach($MdlCntTrgrLnlChk->act->ls as $_act_k=>$_act_v){

								if($_act_v->hbl == 'ok'){

									$MdlCntTrgrActChk_Bfr = GtAtmtTrgrActChk([

																'atmt'=>$row_Ls_AtmtRg['id_atmt'],
																'trgr'=>$MdlCntTrgrLnlChk->bfr,
																'act'=>$_act_v->id,
																'id'=>$row_Ls_RgMdlCnt['id_mdlcnt'],
																'tp'=>$__atmt_a_tp
															]);

									if($MdlCntTrgrActChk_Bfr->tot == 0){
										$_vld = 'no';
										$_vld_msg['trgr_lnl'] =	'Not finished triger before';
									}

								}

							}
						}

					}


					//--------- Continua si es valida ----------//


					if($_vld == 'ok'){

						$MdlCntTrgrActChk = GtAtmtTrgrActChk([

													'atmt'=>$row_Ls_AtmtRg['id_atmt'],
													'trgr'=>$row_Ls_AtmtRg['id_atmttrgr'],
													'act'=>$row_Ls_AtmtRg['id_atmttrgract'],
													'id'=>$row_Ls_RgMdlCnt['id_mdlcnt'],
													'tp'=>$__atmt_a_tp
												]);

						$__lead_h .= $this->li('GtAtmtTrgrActChk:'.$MdlCntTrgrActChk->tot);

						if($MdlCntTrgrActChk->tot == 0){


							//--------- Action - Send Email ----------//

								if($___action_d->d->key->vl == 'snd_eml'){

									include(GL_ATMT_ACT.'snd_eml.php');

							//--------- Action - Change Status ----------//

								}elseif($___action_d->d->key->vl == 'mdlcnt_est'){

									include(GL_ATMT_ACT.'mdlcnt_est.php');

							//--------- Action - Send SMS ----------//

								}elseif($___action_d->d->key->vl == 'snd_sms'){

									include(GL_ATMT_ACT.'snd_sms.php');

							//--------- Action - Change MQL (Lead Score) ----------//

								}elseif($___action_d->d->key->vl == 'cnt_cld'){

									include(GL_ATMT_ACT.'cnt_cld.php');

								}
						}

					}else{

						$__lead_h .= $this->li('Not ready on conditions');

						foreach($_vld_msg as $_vld_msg_k=>$_vld_msg_v){

							$__lead_h .= $this->li( $this->Strn($_vld_msg_k).':'.$_vld_msg_v );

						}

					}

				}while ($row_Ls_RgMdlCnt = $Ls_RgMdlCnt->fetch_assoc());

				$___h_trgr[$____id_atmt]['trgr'][$____id_trgr]['act'][$____id_act]['leads'] .= $__lead_h;

			}else{

				$___h_trgr[$____id_atmt]['trgr'][$____id_trgr]['act'][$____id_act]['leads'] .= $this->br(2).$this->err('Sin Leads');

			}

		}else{

			$___h_trgr[$____id_atmt]['trgr'][$____id_trgr]['act'][$____id_act]['leads'] .= $this->h2($__cnx->c_r->error);

		}

		$__cnx->_clsr($Ls_RgMdlCnt);

	}

	//echo $this->h2($Tot_Mdl_Cnt);
