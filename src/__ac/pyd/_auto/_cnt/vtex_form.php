<?php 

function DcTpHmlg($v=NULL){
	if($v == 'Ceduladeidentidad'){
		return _CId('ID_CNTDC_CC');
	}
}

$_g_alw = $this->tallw([ 't'=>'key', 'id'=>'vtex_form' ]);

if( $_g_alw->est == 'ok' ){

	//-------------- LEADS TO SEND --------------//
			
		$Qry = "SELECT id_vtex, vtex_nm
				FROM "._BdStr(DBT).TB_VTEX."
				WHERE vtex_e=1 AND vtex_cl='".$__cl_v->id."'
				LIMIT 1000";

		$VtexForm = $__cnx->_qry($Qry);

		if($VtexForm){

			$row_VtexForm = $VtexForm->fetch_assoc(); $Tot_VtexForm = $VtexForm->num_rows;
			
			do{
				$___datprcs[] = $row_VtexForm;
			}while($row_VtexForm = $VtexForm->fetch_assoc()); 

		}else{
			echo $__cnx->c_r->error; exit();
		}

		$__cnx->_clsr($VtexForm);


	//-------------- LEADS TO SEND --------------//
	
		if(!isN($___datprcs)){
			
			foreach($___datprcs as $___datprcs_k=>$___datprcs_v){

				//-------------------- AUTO TIME CHECK - START --------------------//
					
					$_date_start = NULL;
					$_date_next = NULL;
					$_AUTOP_d = $this->RquDt([ 't'=>'vtex_form', 'id'=>$___datprcs_v['id_vtex'], 'cl'=>$_cl_v->id, 'm'=>1 ]);
					//$_AUTOP_d->e = 'ok';
					//$_AUTOP_d->lck = 'no';
					
				//-------------------- AUTO TIME CHECK - END --------------------//

				if(($_AUTOP_d->e == 'ok' && $_AUTOP_d->lck != 'ok') || $_AUTOP_d->m_lck > 1){
					
					$___lck = $this->Rqu([ 't'=>'vtex_form', 'id'=>$___datprcs_v['id_vtex'], 'cl'=>$_cl_v->id, 'lck'=>1 ]);	

					echo $this->h1('Account '.ctjTx($___datprcs_v['vtex_nm'],'in').' ('.$___datprcs_v['id_vtex'].') ');
					$this->_vtex->acc = $___datprcs_v['id_vtex'];

					$_forms = $this->_vtex->mdata_forms();
					$_forms_a = [ 'CD', 'CO', 'RT', '' ];

					if(!isN($_forms) && !isN($_forms->ls)){

						foreach($_forms->ls as $_forms_k=>$_forms_v){

							$_fields_query=[]; // Reset Values
							$_leads=[]; // Reset Values

							if(in_array($_forms_v->acronym, $_forms_a)){
								
								echo $this->h2($_forms_v->name.' ('.$_forms_v->acronym.')');

								$_fields = $this->_vtex->mdata_forms_estructure([ 'id'=>$_forms_v->acronym ]);

								if(!isN($_fields) && !isN($_fields->ls)){
									foreach($_fields->ls as $_fields_k=>$_fields_v){
										$_fields_query[] = $_fields_v->name;
									}
									if(!isN($_fields_query)){
										$_fields_search = implode(',',$_fields_query);
										echo $this->li('Next on Query:'.$_AUTOP_d->date->next);
										$_leads = $this->_vtex->mdata_forms_leads([ 'id'=>$_forms_v->acronym, 'fields'=>$_fields_search, 'date'=>$_AUTOP_d->date->next ]);
									}
								}
								
								//print_r($_leads);

								if(!isN($_leads) && !isN($_leads->ls)){
									
									$_lead_i=1;
									$_lead_scss_all = 'ok';
									
									foreach($_leads->ls as $_leads_k=>$_leads_v){ //print_r( $_leads_v );
										
										if($_lead_i==1){

											if(	isN($_AUTOP_d->date) ||
												isN($_AUTOP_d->date->start)
											){

												$_date_start = $this->_vtex->_Tme($_leads_v->createdIn); 
												$_date_next = date('Y-m-d', strtotime($_date_start. ' + 1 days'));

											}elseif(isN($_AUTOP_d->date->next) && !isN($_AUTOP_d->date->start)){

												$_date_next = date('Y-m-d', strtotime($_AUTOP_d->date->start. ' + 1 days'));

											}

										}


										//-------------------- CHECK VALUES FIRST - START --------------------//

											$_FILES = [];
											$_chk = new CRM_Cnt_Up([ 'cl'=>$__dt_cl->id ]);
											
											if($_forms_v->acronym == 'RT'){
												if(Dvlpr()){ $_chk->mdl_id = 2; }else{ $_chk->mdl_id = 4520; }
											}elseif($_forms_v->acronym == 'CD'){
												if(Dvlpr()){ $_chk->mdl_id = 2; }else{ $_chk->mdl_id = 4525; }
											}elseif($_forms_v->acronym == 'CO'){
												if(Dvlpr()){ $_chk->mdl_id = 2; }else{ $_chk->mdl_id = 4527; }
											}

											$_chk->cnt_nm = !isN($_leads_v->nombre_completo)?$_leads_v->nombre_completo:$_leads_v->Nombre;
											$_chk->cnt_tel = ['no'=> ctjTx(!isN($_leads_v->telefono)?$_leads_v->telefono:$_leads_v->Telefono, 'in')];
											$_chk->cnt_eml = !isN($_leads_v->correo)?$_leads_v->correo:$_leads_v->Email;
											$_chk->cnt_dc = filter_var($_leads_v->NumeroDocumento, FILTER_SANITIZE_STRING);
											$_chk->cnt_dc_tp = DcTpHmlg($_chk->TipoDocumento);
											$_chk->cnt_dir = $_leads_v->Direccion;
											$_chk->plcy_id = Dvlpr()?9:14;

											$_chk->ext->mdl_cnt['noord'] = ctjTx($_leads_v->NumeroDeOrden, 'in');
											$_chk->ext->mdl_cnt['dts_prd'] = ctjTx($_leads_v->DescripcionProducto, 'in');
											$_chk->ext->mdl_cnt['rtrct_mtvo'] = ctjTx($_leads_v->MotivoRetracto, 'in');
											$_chk->ext->mdl_cnt['tll_cmpr'] = ctjTx($_leads_v->TallaComprada, 'in');
											$_chk->ext->mdl_cnt['newtall'] = ctjTx($_leads_v->TallaNueva, 'in');
											
											$_chk->cnt_cmn = ctjTx($_leads_v->Descripcion, 'in');
											$_chk->Run();

										//-------------------- LETS SAVE DATA - START --------------------//
											
											if($_chk->hb != 'no'){

												if(!isN($_leads_v->Archivo->url)){

													$_local_fle = '/var/www/.sumr_fle/vtex/form/'.$_leads_v->id.'/'.$_leads_v->Archivo->name;
													$__flrdt = explode('/', $_local_fle);

													if(!isN($__flrdt)){
														foreach($__flrdt as $_f_k=>$_f_v){
															$__fldr = !isN($__fldr) ? $__fldr.'/'.$_f_v : $_f_v.'/';
															if (!file_exists($__fldr)){
																mkdir($__fldr, 0777, true);
															}
														}
													}

													if( file_put_contents($_local_fle, fopen($_leads_v->Archivo->url, 'r')) ){
														$_FILES['upl']['name'][0] = $_leads_v->Archivo->name;
														$_FILES['upl']['tmp_name'][0] = $_local_fle;
													}

												}

												$__CntIn = new CRM_Cnt([ 'cl'=>$__dt_cl->id ]);
												$__CntIn->cnt_nm = $_chk->cnt_nm;
												$__CntIn->cnt_ap = $_chk->cnt_ap;
												$__CntIn->cnt_dc = filter_var($_chk->cnt_dc, FILTER_SANITIZE_STRING);
												$__CntIn->cnt_dc_tp = $_chk->cnt_dctp;
												$__CntIn->cnt_eml = filter_var($_chk->cnt_eml, FILTER_SANITIZE_EMAIL);
												$__CntIn->mdlcnt->attch = $_FILES;
												$__CntIn->plcy_id = $_chk->plcy_id;

												$__CntIn->cnt_tel = [	'no'=>$_chk->cnt_tel['no'], 
																		'tp'=>$_chk->cnt_tel_tp['tp'],
																		'ext'=>$_chk->cnt_tel_ext['ext'],
																		'ps'=>$_chk->cnt_tel_ps['ps']
																	];

												$__CntIn->ext_all = $_chk->ext_out;

												$PrcDt = $__CntIn->MdlCnt();

												if($PrcDt->e == 'ok'){
													echo $this->scss('');
												}else{
													$_lead_scss_all = 'no';
													echo $this->err($_chk->cnt_eml.' not saved '.print_r($PrcDt->w, true));
												}

											}else{

												echo $this->err( print_r($_chk->hb_w_all, true) );

											}

										//-------------------- INCREMENT VALUE --------------------//

										echo $this->li( 'Created In:'.$this->_vtex->_Tme($_leads_v->createdIn) );
										$_lead_i++;

									}

									if(!isN($_AUTOP_d->date->next) && $_lead_scss_all == 'ok'){
										$_date_next = date('Y-m-d', strtotime($_AUTOP_d->date->next. ' + 1 days'));
									}

								}

								//$_date_start

							}

						}

					}

					
					echo $this->li( '$_date_start:'.$_date_start );

					$___unlck = $this->Rqu([
						't'=>'vtex_form',
						'id'=>$___datprcs_v['id_vtex'],
						'cl'=>$_cl_v->id,
						'date_start'=>$_date_start,
						'date_next'=>$_date_next,
						'lck'=>2
					]);

				}

			}

		}

}else{

	echo $this->nallw('Vtex - Get Forms Data - Off');

}

?>