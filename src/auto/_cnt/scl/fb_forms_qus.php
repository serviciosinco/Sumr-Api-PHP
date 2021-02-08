<?php

$_g_alw = $this->tallw([ 't'=>'key', 'id'=>'scl_fb_forms_qus' ]);

if( $_g_alw->est == 'ok' ){

	try {


		//-------------------- AUTO TIME CHECK - START --------------------//

			$_AUTOP_d = $this->RquDt([ 't'=>'fb_forms_qus', 'm'=>1 ]);

		//-------------------- AUTO TIME CHECK - END --------------------//


		if($_AUTOP_d->e == 'ok' && $_AUTOP_d->hb == 'ok'){

			$_form = Php_Ls_Cln($_GET['_form']);
			$_lmt = Php_Ls_Cln($_GET['lmt']);

			if(class_exists('CRM_Cnx')){

				if($this->_s_cl->tot > 0){

					foreach($this->_s_cl->ls as $_cl_k=>$_cl_v){

						if( $this->tallw_cl([ 't'=>'key', 'id'=>'scl_fb_forms_qus', 'cl'=>$_cl_v->id ])->est == 'ok' ){

							echo $this->h3($_cl_v->nm);

							$___datprcs = [];
							$__fl = '';

							if(!isN($_form)){ $__fl .= ' AND id_sclaccform='.$_form.' '; }

							$Ls_Qry = " SELECT id_sclacc, id_sclaccform, scl_rds, sclaccform_id, sclacc_id, sclaccform_sclacc, sclacc_nm, sclaccform_tot_qus,

											(	SELECT COUNT(*)
												FROM "._BdStr(DBT).TB_SCL_ACC_FORM_QUS."
												WHERE id_sclaccform = sclaccformqus_sclaccform
											) AS __tot_qus,

											( sclacc_f_chk_form < NOW() - INTERVAL 3 MINUTE ) AS __rd_lst

										FROM "._BdStr(DBT).TB_SCL_ACC_FORM."
											INNER JOIN "._BdStr(DBT).TB_SCL_ACC." ON sclaccform_sclacc = id_sclacc
											INNER JOIN "._BdStr(DBT).TB_SCL_ACC_SCL." ON sclaccscl_acc = id_sclacc
											INNER JOIN "._BdStr(DBT).TB_SCL." ON sclaccscl_scl = id_scl
											INNER JOIN "._BdStr(DBM).TB_CL_SCL." ON clscl_scl = id_scl

										WHERE 	sclacc_id IS NOT NULL AND
												id_sclacc IN (SELECT clsclacc_sclacc FROM "._BdStr(DBM).TB_CL_SCL_ACC.") AND
												sclaccform_est = "._CId('ID_SISEST_OK')." AND
												sclacc_est = 1 AND
												clscl_cl = '".$_cl_v->id."'
												{$__fl}

										HAVING 	(
													__tot_qus < 1 OR
													sclaccform_tot_qus IS NULL OR
													sclaccform_tot_qus != __tot_qus
												) AND
												__rd_lst = 1

										LIMIT 20";

							echo compress_code( $Ls_Qry ); //exit();

							$LsAccFormsQus = $__cnx->_qry($Ls_Qry);


							if($LsAccFormsQus){

								$row_LsAccFormsQus = $LsAccFormsQus->fetch_assoc();
								$Tot_LsAccFormsQus = $LsAccFormsQus->num_rows;

								echo $this->h1('Facebook - FanPages Accounts - Form - Questions '.$Tot_LsAccFormsQus);

								if($Tot_LsAccFormsQus > 0){

									do {

										try {

											$___datprcs[] = $row_LsAccFormsQus;
											echo $this->li('Lock Before to ID '.$row_LsAccFormsQus['id_sclaccform']);

										} catch (Exception $e) {

											echo $this->err($e->getMessage());

										}

									} while ($row_LsAccFormsQus = $LsAccFormsQus->fetch_assoc());

								}

							}else{

								echo $this->err( $Ls_Qry.$__cnx->c_r->error );

							}

							$__cnx->_clsr($LsAccFormsQus);

							if(!isN( $___datprcs ) && count($___datprcs) > 0){

								foreach($___datprcs as $___datprcs_k=>$___datprcs_v){

									$__SclBd = new CRM_Thrd();

									$__RquDt = $__SclBd->RquDt(['tp'=>'forms_qus', 'acc'=>$___datprcs_v['sclaccform_sclacc'] ]);

									$___tkns = $__SclBd->SclAccTknLs([ 'acc'=>$___datprcs_v['id_sclacc'] ]);

									$___updchk = $__SclBd->UpdF(['t'=>'acc', 'f'=>'sclacc_f_chk_form_qus', 'id'=>$___datprcs_v['id_sclacc'], 'v'=>SIS_F_D2 ]);


									if($___tkns->tot > 0){

										foreach($___tkns->ls as $_tkn_k=>$_tkn_v){

											//---------- Try Tokens - Start ----------//

												echo $this->h1('Account '.ctjTx($___datprcs_v['sclacc_nm'],'in').' ('.$___datprcs_v['id_sclacc'].') - try with token '.$_tkn_v->vl);

												require(GL_SCL_FB.'fb_forms_qus_in.php');

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

			$this->Rqu([ 't'=>'fb_forms_qus' ]);

		}else{

			echo $this->h1('Facebook - FanPages Accounts'.$this->Spn('Form - Questions Run On Next'), 'Auto_Tme_Prg');

		}


	} catch (Exception $e) {


		$this->Rqu([ 't'=>'fb_forms_qus' ]);
		echo $e->getMessage();

	}

}else{

	echo $this->nallw('Global Social Media - Facebook - Forms - Questions - Off');

}

?>