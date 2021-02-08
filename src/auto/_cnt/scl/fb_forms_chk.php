<?php

$_g_alw = $this->tallw([ 't'=>'key', 'id'=>'scl_fb_forms_chk' ]);

if( $_g_alw->est == 'ok' ){

	try {

		//--------- GET AND POST DATA ---------//

			$__SclBd = new CRM_Thrd();
			$_form = Php_Ls_Cln($_GET['_form']);
			$_lmt = Php_Ls_Cln($_GET['lmt']);

		//--------- AUTO TIME CHECK - START ---------//

			$_AUTOP_d = $this->RquDt([ 't'=>'fb_forms_chk', 's'=>10 ]);
			$_AUTOP_d->e = 'ok';
			$_AUTOP_d->hb = 'ok';

		//--------- AUTO TIME CHECK - END ---------//


		if($_AUTOP_d->e == 'ok' && $_AUTOP_d->hb == 'ok'){

			$this->Rqu([ 't'=>'fb_forms_chk' ]);

			if(class_exists('CRM_Cnx')){

				if($this->_s_cl->tot > 0){

					foreach($this->_s_cl->ls as $_cl_k=>$_cl_v){


						//-------------------- AUTO TIME CHECK - START --------------------//

							$___datprcs = [];
							$_AUTOP_d = $this->RquDt([ 't'=>'scl_fb_forms_chk', 'cl'=>$_cl_v->id, 'm'=>2 ]);

						//-------------------- AUTO TIME CHECK - END --------------------//

						if($_AUTOP_d->e == 'ok' && ($_AUTOP_d->lck != 'ok' || $_AUTOP_d->hb == 'ok' )){

							$___lck = $this->Rqu([ 't'=>'scl_fb_forms_chk', 'cl'=>$_cl_v->id, 'lck'=>1 ]);

							echo $this->h3('Lock '.$_cl_v->nm.' / e:'.$___lck->e);

							$___datprcs = [];

							$Ls_Qry = " SELECT id_sclaccform, id_sclacc, sclacc_id, sclaccform_enc, sclaccform_name, sclaccform_fa, sclaccform_leads, sclaccform_leads_expired,

												( sclacc_f_chk_form < NOW() - INTERVAL 5 MINUTE ) AS __rd_lst

										FROM "._BdStr(DBT).TB_SCL_ACC_FORM."
											INNER JOIN "._BdStr(DBT).TB_SCL_ACC." ON sclaccform_sclacc = id_sclacc
											INNER JOIN "._BdStr(DBT).TB_SCL_ACC_SCL." ON sclaccscl_acc = id_sclacc
											INNER JOIN "._BdStr(DBT).TB_SCL." ON sclaccscl_scl = id_scl
											INNER JOIN "._BdStr(DBM).TB_CL_SCL." ON clscl_scl = id_scl

										WHERE 	sclacc_id IS NOT NULL AND
												EXISTS (SELECT clsclacc_sclacc FROM "._BdStr(DBM).TB_CL_SCL_ACC." WHERE clsclacc_sclacc = id_sclacc) AND
												sclacc_est = 1 {$__fl} AND
												sclaccform_est = "._CId('ID_SISEST_OK')." AND
												clscl_cl = '".$_cl_v->id."'

										GROUP BY id_sclaccform

										/*HAVING __rd_lst = 1*/
										ORDER BY RAND()

										LIMIT 20";

							//echo compress_code( $Ls_Qry ); //exit();

							$LsFmChk = $__cnx->_qry($Ls_Qry);


							if($LsFmChk){

								$rwLsFmChk = $LsFmChk->fetch_assoc();
								$totLsFmChk = $LsFmChk->num_rows;

								echo $this->h1($_cl_v->nm.' Facebook - FanPages Accounts - Form Check '.$totLsFmChk);

								if($totLsFmChk > 0){

									do {

										try {

											$___datprcs[] = $rwLsFmChk;
											//echo $this->li('Lock Before to ID '.$rwLsFmChk['id_sclaccform']);

										} catch (Exception $e) {

											echo $this->err($e->getMessage());

										}

									} while ($rwLsFmChk = $LsFmChk->fetch_assoc());

								}


							}else{

								echo $this->err($__cnx->c_r->error);

							}


							$__cnx->_clsr($LsFmChk);


							if(!isN( $___datprcs )){

								foreach($___datprcs as $___datprcs_k=>$___datprcs_v){

									$_AUTOP_a = $this->RquDt([ 't'=>'fb_forms_chk', 'id'=>$___datprcs_v['id_sclaccform'], 'm'=>1 ]);

									$___updchk = $__SclBd->UpdF(['t'=>'acc', 'f'=>'sclacc_f_chk_form', 'id'=>$___datprcs_v['id_sclacc'], 'v'=>SIS_F_D2 ]);

									if($_AUTOP_a->hb == 'ok'){

										$_acc_dt = GtSclAccDt([ 'acc_id'=>$___datprcs_v['sclacc_id'] ]);

										if(!isN($_acc_dt->id)){
											foreach($_acc_dt->acc_scl as $_acc_k=>$_acc_v){
												if(!isN($_acc_v->tlvd)){
													$_tkn_lvd = $_acc_v->tlvd;
													break;
												}
											}
										}

										$_diffd = _Df_Dte($___datprcs_v['sclaccform_fa'], SIS_F_TS, ['_fr'=>'c', 'wkn'=>'no'] );

										$__form = _NwFb_Acc_Form_Dt([
											'id'=>$___datprcs_v['sclaccform_id'],
											'access_token'=>$_tkn_lvd
										]);


										if(!isN($__form->data)){

											$___datprcs_v['id_sclaccform'].' '.$__form['status'];

											if(
												(
													(
														(!isN($_diffd->m) && $_diffd->m > 6) ||
														$___datprcs_v['sclaccform_leads'] == $___datprcs_v['sclaccform_leads_expired']
													)
													&&
													(
														$___datprcs_v['sclaccform_leads'] > 0
													)
												) ||
												(
													$__form->data->status == 'ARCHIVED' && $___datprcs_v['sclaccform_leads'] == 0
												) ||
												(
													$__form->data->status == 'ARCHIVED' && $___datprcs_v['sclaccform_leads'] == 0
												)
											){

												echo $this->li( 'Status:'.$__form->data->status );
												echo $this->li( 'Leads:'.$___datprcs_v['sclaccform_leads'] );
												echo $this->li( 'Leads Expired:'.$___datprcs_v['sclaccform_leads_expired'] );
												echo $this->li( 'Last Updated Form:'.$___datprcs_v['sclaccform_fa'] );

												$__prc = $__SclBd->SclFormUpdFld([ 'enc'=>$___datprcs_v['sclaccform_enc'], 'est'=>_CId('ID_SISEST_NO') ]);

												if($__prc->e == 'ok'){
													echo $this->scss( '('.$___datprcs_v['sclaccform_name'].') '.$___datprcs_v['id_sclaccform'].' cambiado a inactivo' );
												}else{
													echo $this->err( '('.$___datprcs_v['sclaccform_name'].') '.$___datprcs_v['id_sclaccform'].' no cambiado a inactivo' );
												}

											}else{

												echo $this->li( '('.$___datprcs_v['sclaccform_name'].') '.$___datprcs_v['id_sclaccform'].' no ha cambiado de status' );

											}

										}else{

											echo $this->err( compress_code( print_r($__form,true) ) );

										}

									}

									$this->Rqu([ 't'=>'fb_forms_chk', 'id'=>$___datprcs_v['id_sclaccform'] ]);

								}

								echo $this->ul($___formin);

							}

						}

					}

				}

			}

			$this->Rqu([ 't'=>'fb_forms_chk' ]);


		}else{

			echo $this->h1('Facebook - FanPages Accounts'.$this->Spn('Forms - Run On Next'), 'Auto_Tme_Prg');

		}



	} catch (Exception $e) {

		$this->Rqu([ 't'=>'fb_forms_chk' ]);
		echo $e->getMessage();

	}

	if($_GET['_only'] != 'ok'){
		//$this->_Auto_Inc(DIR_CNT.GRP_FL_SCL.'fb_forms_leads_dwn.php');
		//$this->_Auto_Inc(DIR_CNT.GRP_FL_SCL.'fb_forms_leads.php');
		//$this->_Auto_Inc(DIR_CNT.GRP_FL_SCL.'fb_forms_qus.php');
		//$this->_Auto_Inc(DIR_CNT.GRP_FL_SCL.'fb_forms_qus_opt.php');
	}

}else{

	echo $this->nallw('Global Social Media - Facebook - Forms Status - Off');

}

?>