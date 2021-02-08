<?php

$_g_alw = $this->tallw([ 't'=>'key', 'id'=>'scl_fb_forms_leads_dwn' ]);

if( $_g_alw->est == 'ok' ){

	if($this->_s_cl->tot > 0){

		foreach($this->_s_cl->ls as $_cl_k=>$_cl_v){

			try {


				//--------- GET AND POST DATA ---------//

					$_form = Php_Ls_Cln($_GET['_form']);
					$_lmt = Php_Ls_Cln($_GET['lmt']);

				//--------- AUTO TIME CHECK - START ---------//

					$_AUTOP_d = $this->RquDt([ 't'=>'fb_forms_leads_dwn', 'm'=>1 ]);
					//$_AUTOP_d->e = 'ok';
					//$_AUTOP_d->hb = 'ok';

				//--------- AUTO TIME CHECK - END ---------//


				if($_AUTOP_d->e == 'ok' && $_AUTOP_d->hb == 'ok'){

					$__SclBd = new CRM_Thrd();

					if(class_exists('CRM_Cnx')){

						$___datprcs = [];
						$___formleadsin = '';

						if(!isN($_form)){ $__fl .= ' AND id_sclaccform='.$_form.' '; }

						$Ls_Qry = " SELECT 	id_sclacc,
											sclacc_id,
											id_sclaccform,
											sclacc_nm,
											sclaccform_id,
											sclaccform_name,
											sclaccform_leads,
											sclaccform_leads_expired,
											sclaccform_tot_leads
											/*(
												SELECT COUNT(*)
												FROM "._BdStr(DBT).TB_SCL_ACC_FORM_LEADS."
												WHERE sclaccformleads_form = id_sclaccform

											) AS __tot_leads*/

									FROM "._BdStr(DBT).TB_SCL_ACC_FORM."
										INNER JOIN "._BdStr(DBT).TB_SCL_ACC." ON sclaccform_sclacc = id_sclacc
										INNER JOIN "._BdStr(DBT).TB_SCL_ACC_SCL." ON sclaccscl_acc = id_sclacc
										INNER JOIN "._BdStr(DBM).TB_CL_SCL_ACC." ON clsclacc_sclacc = id_sclacc
										INNER JOIN "._BdStr(DBT).TB_SCL." ON sclaccscl_scl = id_scl
									WHERE 	sclacc_id IS NOT NULL AND
											(
												sclaccform_leads > 0 ||
												sclaccform_leads IS NULL

											) AND

											/*(
												sclaccform_leads != sclaccform_leads_expired ||
												sclaccform_leads_expired IS NULL
											) AND*/

											sclaccform_status = 1 AND
											sclacc_est = 1 AND
											(sclaccform_f_chk < NOW() - INTERVAL 5 MINUTE) AND
											sclaccform_est = "._CId('ID_SISEST_OK')." AND
											(
												sclaccform_tot_leads < sclaccform_leads OR
												(sclaccform_leads IS NULL || sclaccform_tot_leads IS NULL)
											) AND
											clsclacc_cl = '{$_cl_v->id}'
											{$__fl}

									GROUP BY id_sclaccform

									/*HAVING 	__tot_leads < 1 OR
											sclaccform_leads != __tot_leads OR
											sclaccform_leads IS NULL*/

									ORDER BY /*id_sclaccform DESC */ RAND()

									LIMIT 500"; //echo compress_code( $Ls_Qry );

						$LsFormLeadDwn = $__cnx->_qry($Ls_Qry);

						if($LsFormLeadDwn){

							$rwFmLeadDwn = $LsFormLeadDwn->fetch_assoc();
							$Tot_LsFormLeadDwn = $LsFormLeadDwn->num_rows;

							echo $this->h1('Facebook - FanPages Accounts - Form - Leads '.$Tot_LsFormLeadDwn.' on account '.$_cl_v->nm);

							if($Tot_LsFormLeadDwn > 0){

								do {

									//--------- RESET DATA ---------//

										$__leads = '';
										$__RquDt = '';

									//--------- START PROCESS ---------//

									$__RquDt = $__SclBd->RquDt([
																'tp'=>'forms_leads_dwn',
																'acc'=>$rwFmLeadDwn['id_sclacc'],
																'id'=>$rwFmLeadDwn['id_sclaccform']
															]);

									$__id_accform = $rwFmLeadDwn['id_sclaccform'];

									$___tkns = $__SclBd->SclAccTknLs([ 'acc'=>$rwFmLeadDwn['id_sclacc'] ]);

									if($___tkns->tot > 0){

										foreach($___tkns->ls as $_tkn_k=>$_tkn_v){

											//---------- Try Tokens - Start ----------//

												echo $this->h1('Form ('.$rwFmLeadDwn['sclaccform_name'].') Account '.ctjTx($rwFmLeadDwn['sclacc_nm'],'in').' ('.$rwFmLeadDwn['id_sclacc'].')'/*.' - try with token '.$_tkn_v->vl*/);

												require(GL_SCL_FB.'fb_forms_leads_dwn_in.php');

												if($__tkn_scss == 'ok'){
													//echo $this->scss('Token '.$_tkn_v->vl.' success, not need another');
													break;
												}

											//---------- Try Tokens - End ----------//

										}

									}

								} while ($rwFmLeadDwn = $LsFormLeadDwn->fetch_assoc());

								echo $this->ul($___formleadsin);

							}

						}else{

							echo $this->err($Ls_Qry.$__cnx->c_r->error);

						}

						$__cnx->_clsr($LsFormLeadDwn);

					}

					$this->Rqu([ 't'=>'fb_forms_leads_dwn' ]);

				}else{

					echo $this->h1('Facebook - FanPages Accounts '.$this->Spn('Form - Leads - Run On Next'), 'Auto_Tme_Prg');

				}

			} catch (Exception $e) {


				$this->Rqu([ 't'=>'fb_forms_leads_dwn' ]);
				echo $e->getMessage();

			}

		}

	}

}else{

	echo $this->nallw('Global Social Media - Facebook - Leads Down - Off');

}

?>