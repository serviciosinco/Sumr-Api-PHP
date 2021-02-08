<?php

$_g_alw = $this->tallw([ 't'=>'key', 'id'=>'scl_fb_forms_leads' ]);

if( $_g_alw->est == 'ok' ){

	try {

		//-------------------- AUTO TIME CHECK - START --------------------//

			$_AUTOP_d = $this->RquDt([ 't'=>'fb_forms_leads', 'm'=>1 ]);
			//$_AUTOP_d->e = 'ok';
			//$_AUTOP_d->hb = 'ok';

		//-------------------- AUTO TIME CHECK - END --------------------//

		if(($_AUTOP_d->e == 'ok' && $_AUTOP_d->hb == 'ok') || !isN($this->g__i)){

			$__Form = new CRM_Thrd();

			/*function jRmvUnic($struct) {
				return preg_replace("/\\\\u([a-f0-9]{4})/e", "iconv('UCS-4LE','UTF-8',pack('V', hexdec('U$1')))", json_encode($struct));
			}*/


			if(!isN($this->_s_cl)){

				$_form = Php_Ls_Cln($_GET['_form']);
				$_lmt = Php_Ls_Cln($_GET['lmt']);

				foreach($this->_s_cl->ls as $_cl_k=>$_cl_v){

					if( $this->tallw_cl([ 't'=>'key', 'id'=>'scl_fb_forms_leads', 'cl'=>$_cl_v->id ])->est == 'ok' ){

						if(!isN($this->g__i)){
							$_fl = ' AND sclaccform_enc = "'.$this->g__i.'" ';
						}else{
							$_fl = '
								AND sclaccformleads_est = 2
								AND sclaccform_est = '._CId('ID_SISEST_OK').'
							';
						}

						$Ls_Qry = " SELECT 	id_sclaccform, id_sclaccformleads, sclaccformleads_enc, clsclacc_cl, sclaccform_name, sclaccform_mdl,
											sclaccformleads_lead, sclaccformleads_created, sclaccform_plcy, sclaccform_md, sclaccform_tot_qus,

											(	SELECT COUNT(*)
												FROM "._BdStr(DBT).TB_SCL_ACC_FORM_QUS."
													 INNER JOIN "._BdStr(DBT).TB_SCL_ACC_FORM_QUS_FLD." ON sclaccformqusfld_qus = id_sclaccformqus
												WHERE sclaccformqus_sclaccform = id_sclaccform
											) AS _tot_qus_rltd

									FROM "._BdStr(DBT).TB_SCL_ACC_FORM_LEADS."
										 INNER JOIN "._BdStr(DBT).TB_SCL_ACC_FORM." ON sclaccformleads_form = id_sclaccform
										 INNER JOIN "._BdStr(DBM).TB_CL_SCL_ACC." ON clsclacc_sclacc = sclaccform_sclacc
									WHERE
										clsclacc_cl = '".$_cl_v->id."' AND
										(
											sclaccform_mdl IS NOT NULL ||
											EXISTS(
												SELECT id_mdl
												FROM "._BdStr($_cl_v->bd).TB_SCL_ACC_FORM_QUS_OPT_MDL."
													 INNER JOIN "._BdStr($_cl_v->bd).TB_MDL." ON sclaccformqusoptmdl_mdl = id_mdl
													 INNER JOIN "._BdStr(DBT).TB_SCL_ACC_FORM_QUS_OPT." ON sclaccformqusoptmdl_qusopt = id_sclaccformqusopt
													 INNER JOIN "._BdStr(DBT).TB_SCL_ACC_FORM_QUS." ON sclaccformqusopt_sclaccformqus = id_sclaccformqus
												WHERE sclaccformqus_sclaccform = id_sclaccform
											)
										)/*AND
										sclaccform_cl IS NOT NULL*/
										{$_fl}
									HAVING _tot_qus_rltd = sclaccform_tot_qus
									ORDER BY RAND()
									LIMIT 20";

						$LsFormLead = $__cnx->_qry($Ls_Qry);

						echo $this->li('Qry:'.compress_code( $Ls_Qry ));

						if($LsFormLead){

							$row_LsFormLead = $LsFormLead->fetch_assoc();
							$Tot_LsFormLead = $LsFormLead->num_rows;

							echo $this->h1($this->ttFgr($_cl_v).$_cl_v->nm.' '.$Tot_LsFormLead );

							if($Tot_LsFormLead > 0){

								//echo '<ul class="lead">';

								do {

									$__cl_d = GtClDt($row_LsFormLead['clsclacc_cl'], '' );
									$__SclBd = new CRM_Thrd([ 'cl'=>$__cl_d ]);

									$__lead_d = json_decode( ctjTx( $row_LsFormLead['sclaccformleads_lead'], 'in', '', ['html'=>'ok','qte'=>'no']) );
									$__mdl_d = '';

									if(!isN($row_LsFormLead['sclaccform_mdl'])){
										$__mdl_d = GtMdlDt([ 'bd'=>$__cl_d->bd, 'id'=>$row_LsFormLead['sclaccform_mdl'] ]);
									}else{
										$__mdl_d = $__SclBd->SclFormQusOptGetMdlDt([
														'bd'=>$__cl_d->bd,
														'form'=>$row_LsFormLead['id_sclaccform'],
														'data'=>$__lead_d
													]);
									}

									if(!isN($__mdl_d->id)){

										if(!isN($__lead_d) && !isN($__mdl_d->id)){

											echo $this->li($this->Strn('Id Form:').$row_LsFormLead['id_sclaccform']);
											echo $this->li($this->Strn('Id Modulo:').$row_LsFormLead['sclaccform_mdl']);
											echo $this->li($this->Strn('Id Lead Scl:').$row_LsFormLead['id_sclaccformleads']);
											echo $this->li($this->Strn('Id Name:').$row_LsFormLead['sclaccform_name']);
											echo $this->li($this->Strn('Total Questions:').$row_LsFormLead['sclaccform_tot_qus']);
											echo $this->li($this->Strn('Total Questions Related:').$row_LsFormLead['_tot_qus_rltd']);
											echo $this->li( print_r( $__lead_d, true) );

											$__SclBd->__t = 'acc_form_lead';
											$__SclBd->formleads_enc = $row_LsFormLead['sclaccformleads_enc'];
											$__SclBd->form_id = $row_LsFormLead['id_sclaccform'];
											$__SclBd->form_mdl = $__mdl_d->id;
											$__SclBd->form_lead_created = $row_LsFormLead['sclaccformleads_created'];
											$__SclBd->form_lead_data = $__lead_d;
											$__SclBd->plcy_id = $row_LsFormLead['sclaccform_plcy'];
											$__SclBd->form_md = $row_LsFormLead['sclaccform_md'];

											$__Prc = $__SclBd->In();

											if($__Prc->e == 'ok'){
												echo $this->scss( 'Process success' );
											}else{
												echo $this->li( $this->err( print_r($__Prc, true) ) );
												echo $this->br(2);
											}

										}

									}

								} while ($row_LsFormLead = $LsFormLead->fetch_assoc());

								//echo '</ul>';
								echo $this->ul($___formin);

							}

						}else{

							echo $this->err($__cnx->c_r->error);

						}


						$__cnx->_clsr($LsFormLead);

					}else{

						echo $this->nallw($_cl_v->nm.' Social Media - Facebook - Leads Process - Off');

					}

				}

			}

			$this->Rqu([ 't'=>'fb_forms_leads' ]);

		}else{

			echo $this->h1('Facebook - Account'.$this->Spn('Form - Leads - Run On Next'), 'Auto_Tme_Prg');

		}

	} catch (Exception $e) {

		$this->Rqu([ 't'=>'fb_forms_leads' ]);
		echo $e->getMessage();

	}

}else{

	echo $this->nallw('Global Social Media - Facebook - Leads Process - Off');

}


?>