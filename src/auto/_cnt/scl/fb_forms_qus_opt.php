<?php

$_g_alw = $this->tallw([ 't'=>'key', 'id'=>'scl_fb_forms_qus_opt' ]);

if( $_g_alw->est == 'ok' ){

	try {

		//-------------------- GET PARAMETERS --------------------//

			$_form = Php_Ls_Cln($_GET['_form']);
			$_qus = Php_Ls_Cln($_GET['_qus']);
			$_lmt = Php_Ls_Cln($_GET['lmt']);

		//-------------------- AUTO TIME CHECK - START --------------------//

			$_AUTOP_d = $this->RquDt(['t'=>'fb_forms_qus_opt', 'm'=>5]);

		//-------------------- AUTO TIME CHECK - END --------------------//


		if(($_AUTOP_d->e == 'ok' && $_AUTOP_d->hb == 'ok') || !isN($_form )){

			if($this->_s_cl->tot > 0){

				foreach($this->_s_cl->ls as $_cl_k=>$_cl_v){

					if( $this->tallw_cl([ 't'=>'key', 'id'=>'scl_fb_forms_qus_opt', 'cl'=>$_cl_v->id ])->est == 'ok' ){

						echo $this->h3($_cl_v->nm);

						if(class_exists('CRM_Cnx')){

							$___datprcs = [];
							$__fl = '';

							if(!isN($_form)){ $__fl .= ' AND id_sclaccform='.$_form.' '; }

							$Ls_Qry = " SELECT id_sclacc, id_sclaccform, sclaccform_id, sclacc_id, id_sclaccformqus, sclaccformqus_id, sclacc_nm, sclaccform_sclacc, scl_rds, sclaccformqus_tot_opt,
											(	SELECT COUNT(*)
												FROM "._BdStr(DBT).TB_SCL_ACC_FORM_QUS_OPT."
												WHERE sclaccformqusopt_sclaccformqus = id_sclaccformqus
											) AS __tot_qus_opt

										FROM "._BdStr(DBT).TB_SCL_ACC_FORM_QUS."
											INNER JOIN "._BdStr(DBT).TB_SCL_ACC_FORM." ON sclaccformqus_sclaccform = id_sclaccform
											INNER JOIN "._BdStr(DBT).TB_SCL_ACC." ON sclaccform_sclacc = id_sclacc
											INNER JOIN "._BdStr(DBT).TB_SCL_ACC_SCL." ON sclaccscl_acc = id_sclacc
											INNER JOIN "._BdStr(DBT).TB_SCL." ON sclaccscl_scl = id_scl
											INNER JOIN "._BdStr(DBM).TB_CL_SCL." ON clscl_scl = id_scl

										WHERE 	sclacc_id IS NOT NULL AND
												id_sclacc IN (SELECT clsclacc_sclacc FROM "._BdStr(DBM).TB_CL_SCL_ACC.") AND
												sclacc_est = 1 AND
												sclaccformqus_tot_opt > 0 AND
												sclaccform_est = "._CId('ID_SISEST_OK')." AND
												clscl_cl = '".$_cl_v->id."'
												{$__fl}

										HAVING 	__tot_qus_opt < 1 OR
												sclaccformqus_tot_opt IS NULL OR
												sclaccformqus_tot_opt != __tot_qus_opt

										LIMIT 10";

							//echo compress_code( $Ls_Qry );

							$LsAccFormsQusOpt = $__cnx->_qry($Ls_Qry);


							if($LsAccFormsQusOpt){

								$rwAccFmQusOpt = $LsAccFormsQusOpt->fetch_assoc();
								$Tot_LsAccFormsQusOpt = $LsAccFormsQusOpt->num_rows;

								echo $this->h1('Facebook - FanPages Accounts - Form - Questions '.$Tot_LsAccFormsQusOpt);

								if($Tot_LsAccFormsQusOpt > 0){

									do {

										try {

											$___datprcs[] = $rwAccFmQusOpt;
											echo $this->li('Lock Before to ID '.$rwAccFmQusOpt['id_sclaccform']);

										} catch (Exception $e) {

											echo $this->err($e->getMessage());

										}

									} while ($rwAccFmQusOpt = $LsAccFormsQusOpt->fetch_assoc());

								}

							}else{

								echo $this->err($Ls_Qry.$__cnx->c_r->error);

							}

							$__cnx->_clsr($LsAccFormsQusOpt);

							if(!isN( $___datprcs ) && count($___datprcs) > 0){

								foreach($___datprcs as $___datprcs_k=>$___datprcs_v){

									$__SclBd = new CRM_Thrd();
									$__RquDt = $__SclBd->RquDt(['tp'=>'forms_qus', 'acc'=>$___datprcs_v['id_sclaccform'] ]);

									$__id_accformqus = $___datprcs_v['id_sclaccformqus'];
									$__accformqus_id = $___datprcs_v['sclaccformqus_id'];

									$___tkns = $__SclBd->SclAccTknLs([ 'acc'=>$___datprcs_v['id_sclacc'] ]);

									if($___tkns->tot > 0){

										foreach($___tkns->ls as $_tkn_k=>$_tkn_v){

											//---------- Try Tokens - Start ----------//

												echo $this->h1('Account '.ctjTx($___datprcs_v['sclacc_nm'],'in').' ('.$___datprcs_v['id_sclacc'].') - try with token '.$_tkn_v->vl);

												require(GL_SCL_FB.'fb_forms_qus_opt_in.php');

												if($__tkn_scss == 'ok'){
													echo $this->scss('Token '.$_tkn_v->vl.' success, not need another');
													break;
												}

											//---------- Try Tokens - End ----------//

										}

									}

								}

								echo $this->ul($___formin);

							}

						}

					}

				}

			}

			$this->Rqu([ 't'=>'fb_forms_qus_opt' ]);

		}else{

			echo $this->h1('Facebook - FanPages Accounts'.$this->Spn('Form - Questions - Run On Next'), 'Auto_Tme_Prg');

		}



	} catch (Exception $e) {


		$this->Rqu([ 't'=>'fb_forms_qus_opt' ]);
		echo $e->getMessage();

	}

}else{

	echo $this->nallw('Global Social Media - Facebook - Forms - Questions Options - Off');

}


?>