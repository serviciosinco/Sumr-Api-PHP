<?php

$_g_alw = $this->tallw([ 't'=>'key', 'id'=>'scl_fb_forms' ]);

if( $_g_alw->est == 'ok' ){

	try {

		//@ini_set('display_errors', true);
		//error_reporting(E_ALL);

		//--------- GET AND POST DATA ---------//

			$_form = Php_Ls_Cln($_GET['_form']);
			$_lmt = Php_Ls_Cln($_GET['lmt']);

		//--------- AUTO TIME CHECK - START ---------//

			$_AUTOP_d = $this->RquDt([ 't'=>'fb_forms', 's'=>10 ]);
			//$_AUTOP_d->e = 'ok';
			//$_AUTOP_d->hb = 'ok';

		//--------- AUTO TIME CHECK - END ---------//


		if($_AUTOP_d->e == 'ok' && $_AUTOP_d->hb == 'ok'){

			$this->Rqu([ 't'=>'fb_forms' ]);

			if(class_exists('CRM_Cnx')){

				if($this->_s_cl->tot > 0){

					foreach($this->_s_cl->ls as $_cl_k=>$_cl_v){

						if( $this->tallw_cl([ 't'=>'key', 'id'=>'scl_fb_form', 'cl'=>$_cl_v->id ])->est == 'ok' ){


							//-------------------- AUTO TIME CHECK - START --------------------//

								$___datprcs = [];
								$_AUTOP_d = $this->RquDt([ 't'=>'scl_fb_forms', 'cl'=>$_cl_v->id, 'm'=>5 ]);

							//-------------------- AUTO TIME CHECK - END --------------------//

							if($_AUTOP_d->e == 'ok' && ($_AUTOP_d->lck != 'ok' || $_AUTOP_d->hb == 'ok' )){

								$___lck = $this->Rqu([ 't'=>'scl_fb_forms', 'cl'=>$_cl_v->id, 'lck'=>1 ]);

								echo $this->h3('Lock '.$_cl_v->nm.' / e:'.$___lck->e);

								if($___lck->e == 'ok'){

									$Ls_Qry = " SELECT id_sclacc, sclacc_nm, sclacc_id, scl_rds, sclacc_f_chk_form,

													/*
													(
														SELECT sclaccform_fa
														FROM "._BdStr(DBT).TB_SCL_ACC_FORM."
														WHERE sclaccform_sclacc = id_sclacc
														ORDER BY sclaccform_fa DESC
														LIMIT 1
													) AS ___lst_form_fa,
													*/

													( sclacc_f_chk_form < NOW() - INTERVAL 5 MINUTE ) AS __rd_lst

												FROM "._BdStr(DBT).TB_SCL_ACC."
														INNER JOIN "._BdStr(DBT).TB_SCL_ACC_SCL." ON sclaccscl_acc = id_sclacc
														INNER JOIN "._BdStr(DBT).TB_SCL." ON sclaccscl_scl = id_scl
														INNER JOIN "._BdStr(DBM).TB_CL_SCL." ON clscl_scl = id_scl

												WHERE 	sclacc_id IS NOT NULL AND
														id_sclacc IN (SELECT clsclacc_sclacc FROM "._BdStr(DBM).TB_CL_SCL_ACC.") AND
														sclacc_est = 1 {$__fl} AND
														clscl_cl = '".$_cl_v->id."'

												GROUP BY sclaccscl_acc DESC
												HAVING __rd_lst = 1
												ORDER BY RAND()
												LIMIT 5"; //echo compress_code( $Ls_Qry ); //exit();

									$LsAccForms = $__cnx->_qry($Ls_Qry);


									if($LsAccForms){

										$row_LsAccForms = $LsAccForms->fetch_assoc();
										$Tot_LsAccForms = $LsAccForms->num_rows;

										echo $this->h1('Facebook - FanPages Accounts - Form '.$Tot_LsAccForms);

										if($Tot_LsAccForms > 0){

											do {

												try {

													$___datprcs[] = $row_LsAccForms;
													echo $this->li('Lock Before to ID '.$row_LsAccForms['id_sclacc']);

												} catch (Exception $e) {

													echo $this->err($e->getMessage());

												}

											} while ($row_LsAccForms = $LsAccForms->fetch_assoc());

										}else{

											//echo $this->li( '$LsAccForms: '.compress_code('Query Executed:'.$Ls_Qry) );

										}

									}else{

										echo $this->err($__cnx->c_r->error);

									}


									$__cnx->_clsr($LsAccForms);

									if(!isN( $___datprcs ) && count($___datprcs) > 0){

										foreach($___datprcs as $___datprcs_k=>$___datprcs_v){

											echo $this->h1('Process ID '.$___datprcs_v['id_sclacc'].' Name: '.$___datprcs_v['sclacc_nm']);

											$_AUTOP_a = $this->RquDt([ 't'=>'fb_forms', 'id'=>$___datprcs_v['id_sclacc'], 's'=>30 ]);

											$__SclBd = new CRM_Thrd();

											$__RquDt = $__SclBd->RquDt(['tp'=>'forms', 'acc'=>$___datprcs_v['sclaccform_sclacc'] ]);

											$___tkns = $__SclBd->SclAccTknLs([ 'acc'=>$___datprcs_v['id_sclacc'] ]);

											$___updchk = $__SclBd->UpdF(['t'=>'acc', 'f'=>'sclacc_f_chk_form', 'id'=>$___datprcs_v['id_sclacc'], 'v'=>SIS_F_D2 ]);

											echo $this->li('Update date of check -> '.$___updchk->e);

											if($___tkns->tot > 0){

												foreach($___tkns->ls as $_tkn_k=>$_tkn_v){

													//---------- Try Tokens - Start ----------//

														echo $this->h1('Account '.ctjTx($___datprcs_v['sclacc_nm'],'in').' ('.$___datprcs_v['id_sclacc'].') - try with token '.$_tkn_v->vl);

														require(GL_SCL_FB.'fb_forms_in.php');

														if($__tkn_scss == 'ok'){
															echo $this->scss('Token success, not need another');
															break;
														}

													//---------- Try Tokens - End ----------//

												}

											}

										}

									}

								}


								$___lck = $this->Rqu([ 't'=>'scl_fb_forms', 'cl'=>$_cl_v->id, 'lck'=>2 ]);


							}

						}

					}

				}

			}

			$this->Rqu([ 't'=>'fb_forms' ]);

		}else{

			echo $this->h1('Facebook - FanPages Accounts'.$this->Spn('Forms - Run On Next'), 'Auto_Tme_Prg');

		}



	} catch (Exception $e) {

		$this->Rqu([ 't'=>'fb_forms' ]);
		echo $e->getMessage();

	}

}else{

	echo $this->nallw('Global Social Media - Facebook - Forms - Off');

}

?>