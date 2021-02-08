<?php   

$_g_alw = $this->tallw([ 't'=>'key', 'id'=>'up_bd' ]);

if( $_g_alw->est == 'ok' ){

	if(class_exists('CRM_Cnx')){ 
		
		$___datprcs = [];

		//--------- AUTO TIME CHECK - START ---------//

		$_AUTOP_d = $this->RquDt([ 't'=>'up_bd', 's'=>10 ]); 
		
		//$_AUTOP_d->e = 'ok';
		//$_AUTOP_d->hb = 'ok';

		if($_AUTOP_d->e == 'ok' && $_AUTOP_d->hb == 'ok'){ 	
			
			$this->Rqu([ 't'=>'up_bd' ]);
				
			try {
				
				$this->_up->tp = 'up_bd';
				
				ini_set("max_execution_time", 300);
				
				if(defined('UP_BD_MAX') && !isN(UP_BD_MAX)){ $__max_row_rd = UP_BD_MAX; }else{ $__max_row_rd = 500; }
				
				echo $this->h2('Carga de Archivo a BD ');
				
				if(!isN($this->g__i)){ 
					$_up_id = $this->g__i; 
					$__f_q = " up_enc = '{$_up_id}' ";
				}else{
					$__f_q = " (up_est = "._CId('ID_UPEST_LD')." AND (up_rd = 2 || up_rd_f < NOW() - INTERVAL 10 MINUTE ) ) AND up_fld != '' 
								/*AND (up_tp = 'cnt' || up_tp = 'mdl_cnt' || up_tp = 'ec_lsts_up' || up_tp = 'dnc' || up_tp = 'sms_cmpg_up')*/ ";
				}
				
				$Ls_Up_Qry = " 	SELECT up_enc, up_fld, up_tp,
										( up_rd_f < NOW() - INTERVAL 5 MINUTE ) AS __rd_aft
								FROM ".DBP.".".MDL_UP_BD." 
								WHERE {$__f_q} 
								ORDER BY RAND()
								LIMIT 5000";
						
				$Ls_Up_Rg = $__cnx->_qry($Ls_Up_Qry); 
				
				
				if($Ls_Up_Rg){
				
					$row_Ls_Up_Rg = $Ls_Up_Rg->fetch_assoc();
					$Tot_Ls_Up_Rg = $Ls_Up_Rg->num_rows;
			
					//if($Tot_Ls_Up_Rg == 0){  $this->_up->_InUp_Est([ 'id'=>$__i, 't'=>'enc', 'e'=>_CId('ID_UPEST_ON') ]);  }
									
					if($Tot_Ls_Up_Rg > 0){
						
						echo $this->h3('Archivos a cargar en BD: '.$Tot_Ls_Up_Rg);
						
						$___fle = GtUpDt([ 'id'=>$row_Ls_Up_Rg['up_enc'], 't'=>'enc' ]);
						
						//echo $this->h3('Details of '.$row_Ls_Up_Rg['up_enc'].': '.print_r($___fle, true));
						
						if(!isN($___fle->id)){	
							
							//----------------- File Properties -----------------//
								
								//$___fle_pth = '../../'.DIR_PRVT_UP.$___fle->fle;
								//echo $this->h3('Up Enc: '.$row_Ls_Up_Rg['up_enc'].' -> File Details'.print_r($___fle, true));
								$_pth = $this->_aws->_s3_get([ 'b'=>'prvt', 'lcl'=>'ok', 'upd'=>'ok', 'fle'=>DIR_PRVT_UP.$___fle->fle ]);
								if($_pth->tmp){ $___fle_pth = $_pth->tmp; }

								print_r( $_pth );

								$___hdr = json_decode($row_Ls_Up_Rg['up_fld']);
								$___hdr_f = GtUpFld_Js()->ls;	
							
							//----------------- File Properties -----------------//
						
							
							if($___fle->ext == 'xlsx'){ $__ioF='Excel2007'; }elseif($___fle->ext == 'xls'){ $__ioF='Excel2003XML'; }
		
							try {
								
								$inputFileType = PHPExcel_IOFactory::identify($___fle_pth);
								$objReader = PHPExcel_IOFactory::createReader($__ioF);
								$objReader->setReadDataOnly(true);
								//if($___fle->ext == 'xls'){ $objReader->setPreCalculateFormulas(false); }
								$objPHPExcel = $objReader->load($___fle_pth); 
								
							} catch (Exception $e) {
								
								echo $this->err('Error loading file "' . $___fle_pth . '": ' . $e->getMessage() );
								
							}
						
							if(!isN($objPHPExcel)){
							
								foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {
									
									$worksheetTitle = $worksheet->getTitle();
									$highestRow = $worksheet->getHighestRow();
									$highestColumn = $worksheet->getHighestColumn();
									$highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);
									$nrColumns = ord($highestColumn) - 64;
									
									echo $this->h3( 'Title: '.$___fle_pth.':'.$worksheetTitle );
									echo $this->h3( 'Highest Row: '.$___fle_pth.':'.$highestRow );
									echo $this->h3( 'Highest Column: '.$___fle_pth.':'.$highestColumn );
		
								}
								
								$rsp['rws'] = $highestRow;
								
							}else{
								
								echo $this->err('Problem on $objPHPExcel creation ' . $___fle_pth );
								
							}
							
							try {
								
								
								if(!isN($highestRow)){
								
								
									if(!isN($___fle->lrow)){ $row = $___fle->lrow; $__max_row_rd=$__max_row_rd+$___fle->lrow; }else{ $row = 1; }
									
									$this->_up->_InUp_Rd([ 'id'=>$___fle->id, 'e'=>'on' ]);
									
									
									if($row_Ls_Up_Rg['up_tp'] == 'sms_cmpg_up'){
										for ($col = 0; $col < $highestColumnIndex; ++ $col) { 
										$cell = $worksheet->getCellByColumnAndRow($col, 1);
										$data = $cell->getValue();
											if (strpos($data, '[') !== false && strpos($data, ']') !== false) {
												$__hdr[] = ['key'=>$data,'col'=>$col];
												$__hdr_s[$col] = $data;
												$__hdr_col[] = $col;
											}
										}
									}
									
					
									while ($row<=$__max_row_rd && $row <= $highestRow){ 
											
										for($col = 0; $col<$highestColumnIndex; ++$col) { 
										
											$cell = $worksheet->getCellByColumnAndRow($col, $row);
											$data = $cell->getValue(); 
										
											$__data_col = $___hdr->{'c_'.$col}->id;
											
									
											if(!isN($__data_col)){ 
											$__data_col_f = $___hdr_f->{$__data_col}; 
											}
											
											if( $__data_col_f->dte == 1 ){
												$val = PHPExcel_Style_NumberFormat::toFormattedString( $data , 'YYYY-MM-DD');
											}else{
												$val = strip_tags( $data );	
											}
											
											if($row > 1){ $_ins[$row][$col] = stripslashes($val); }
										
											if($row_Ls_Up_Rg['up_tp'] == 'sms_cmpg_up'){
												if (is_array($__hdr_col) && in_array($col, $__hdr_col)) {
													$__hdr_c[$col] = $val;	
												}
												if($__data_col_f->vl =='smssnd_msj' && $__data_col != ''){ 
												$__sms_msj = $val;
												$__col_data = $col; 
												}
											} 
										
										}
										
													
									if($row > 1){ 
										
											if($row_Ls_Up_Rg['up_tp'] == 'sms_cmpg_up'){
											$__goc = str_replace($__hdr_s, $__hdr_c, $__sms_msj);
											$_ins[$row][ $__col_data ] = $__goc;  
											}
											
											$_InUpChk = $this->_up->_InUpCol_Chk([ 'up'=>$___fle->id, 'row'=>$row ]);
											
											echo $this->h3('Row '.$row.' existe en bd?');
											
											if($_InUpChk->e == 'no'){	
												$_InUpRsl = $this->_up->_InUpCol([ 'up'=>$___fle->id, 'row'=>$row, 'd'=>$_ins[$row] ]); 
												if($_InUpRsl->e != 'ok'){ $_InUpRsl_e = 'no'; $_InUpRsl_w .= $_InUpRsl->w_m; }
												echo $this->h3('Row '.$row.' ingresada proceso ');
											}
											
									} 
				
									$row++;
									
									}
									
									
									echo $this->li('$_InUpRsl_e: '.$_InUpRsl_e);
									echo $this->li('lrow: '.$___fle->lrow);
									echo $this->li('row: '.$___fle->row);
									
									if($_InUpRsl_e != 'no' && !isN($___fle->row) && $___fle->lrow >= $___fle->row){
										
										$rsp['u_e'] = $this->_up->_InUp_Est([ 'id'=>$___fle->id, 'e'=>_CId('ID_UPEST_PRC') ]);
										$rsp['e'] = 'ok';
										
									}else{
										
										echo $this->h2('$_InUpRsl_e:'.$_InUpRsl_e);
										echo $this->h3('Update to 613 Cargado (Archivo en Servidor)');
										echo $this->h3('$___fle->row:'.$___fle->row);
										echo $this->h3('$___fle->lrow >= $___fle->row:'.$___fle->lrow.' >= '.$___fle->row);
										
										$rsp['u_e'] = $this->_up->_InUp_Est([ 'id'=>$___fle->id, 'e'=>_CId('ID_UPEST_LD'), 'w'=>$_InUpRsl_w ]);
										
										/*
										$_CRM_Ntf = new CRM_Ntf(); 
										
										$_CRM_Ntf->ntf_acc = [ 't'=>_CId('ID_NTFACC_UPDRDY'), 'v1'=>$___fle->id ];
										$_CRM_Ntf->ntf_tp  = _CId('ID_NTFTP_UPD');
										$_CRM_Ntf->ntf_sub = "upd";
										$_CRM_Ntf->cl = DB_CL_ID;
										$_CRM_Ntf->ntf_id_enc = $___fle->enc;
										$_CRM_Ntf->ntf_id = $___fle->id
										$_CRM_Ntf->ntf_us = SISUS_ID; 
										
										$_CRM_Ntf->Prc();
										
										*/
										
									}
				
									$this->_up->_InUp_Rd([ 'id'=>$___fle->id ]);
								
								}else{
									
									echo $this->err('No get highest row for ' . $___fle_pth );
									
								}
								
								
							} catch (Exception $e) {
								
								$rsp['e'] = 'no';
								$rsp['e_m'] = $e->getMessage();
								
								echo $this->err('Error procesing file "' . $___fle_pth . '": ' . $e->getMessage());
								
								$this->_up->_InUp_Rd([ 'id'=>$___fle->id ]);					
								
							}
							
						}else{
							
							echo $this->err('No detail data of file "' . $___fle_pth . '"');
							
						}
							
					}else{
						
						echo $this->h3('No Databases To Load');
						
					}	
				
				}else{
					
					echo $this->err($__cnx->c_r->error.' -> Qry:'.$Ls_Up_Qry);
					
				}	
			
				$__cnx->_clsr($Ls_Up_Rg);
				
				$this->Rqu([ 't'=>'up_bd' ]);
				
				
			} catch (Exception $e) {
				
				$this->Rqu([ 't'=>'up_bd' ]);
				
				echo 'Error Carga de Archivo a BD: ',  $e->getMessage(), "\n";
				
			}	
		
		
		}else{
			
			echo $this->h2('Upload '.$this->Spn('XLS to DataBase - Run On Next'), 'Auto_Tme_Prg');
			
		}	
						
	}


}else{

	echo $this->nallw('Global Monitor Upload - To DataBase Temp - Off');

}


?>	