<?php

if(class_exists('CRM_Cnx')){
	
	$_fl_tt = _FleN(['tt'=>'Contactos']);
	
	
	$pdo_d = CnRd_Pdo(['d'=>'dwn']);
	
	//$__F_FORCE = ' AND id_dwn = 305';
	
	$Ls_QC = "SELECT * FROM ".TB_DWN." WHERE dwn_tp = 'clg' AND dwn_est != 1 AND dwn_est != 5 $__F_FORCE ORDER BY dwn_r ASC LIMIT 1 ";
	$Ls_ProCntHisRgC = $pdo_d->prepare($Ls_QC); 
	$Ls_ProCntHisRgC->execute(); 
	$row_Ls_ProCntHisRgC = $Ls_ProCntHisRgC->fetchAll(PDO::FETCH_ASSOC); 
	$Tot_Ls_ProCntHisRgC = Pdo_Fix_RwTot($Ls_ProCntHisRgC); 
	

	echo $this->h1('Descargas de Colegios:'.$Tot_Ls_ProCntHisRgC);
	if($Tot_Ls_ProCntHisRgC > 0){
	
		foreach ($row_Ls_ProCntHisRgC as $rC) {
			
			
			$pdo_d = CnRd_Pdo(['d'=>'dwn']);
			$pdo = CnRd_Pdo();
	
	
			$Ls_Mdfy_His_A = '';	 
			$Ls_Mdfy_Est_A = '';
			$update_f_go = '';
			$updateSQL != '';
			$__dwn_dt = GtDwnDt(['id'=>$rC['id_dwn'] ]);

				
			if($__dwn_dt->tot == 0){
			
				UPD_Dwn(['i'=>$__dwn_dt->id, 'e'=>'5', 'w'=>'No existe tabla' ]);
			
				
			}elseif($__dwn_dt->tot->no_u > 0){

					
					echo $this->h1('Procesa registro '.$__dwn_dt->id);
					
					UPD_Dwn(['i'=>$__dwn_dt->id, 'e'=>'3']); 
					
					
					if($__dwn_dt->est == 3){ $__c_prcs = '20000'; }else{ $__c_prcs = '5000'; }
				
					$Ls_ProCntHis_Qry = " SELECT * FROM ".$__dwn_dt->tab." WHERE __dwn_e = 3 ORDER BY id_dwnprc ASC LIMIT $__c_prcs";
				
					
					$Ls_ProCntHisRg = $pdo_d->prepare($Ls_ProCntHis_Qry); 
					$Ls_ProCntHisRg->execute(); $row_Ls_ProCntHisRg = $Ls_ProCntHisRg->fetchAll(PDO::FETCH_ASSOC); 
					$Tot_Ls_ProCntHisRg = Pdo_Fix_RwTot($Ls_ProCntHisRg); 
					
					echo $this->h2('Total Leads:'.$Tot_Ls_ProCntHisRg_His); 
					
					if($Tot_Ls_ProCntHisRg_His > 0){
						do { 	

							if($row_Ls_ProCntHisRg_His['id_clgsds'] != ''){
								$_i_p = $row_Ls_ProCntHisRg_His['id_clgsds'];
								$_i_p_h = $row_Ls_ProCntHisRg_His['id_clgsds'];
								$__col_his[ $_i_p ][] = ['id'=>$_i_p_h, 
														'f'=>strip_tags( html_entity_decode(	ctjTx($row_Ls_ProCntHisRg_His['ecsnd_fi'],'in')	) ),
														't'=>strip_tags( html_entity_decode(	ctjTx($row_Ls_ProCntHisRg_His['id_clgsds'],'in')	) ),
														'u'=>ctjTx($row_Ls_ProCntHisRg_His['clg_nm'],'in') ];						  	
							}							  																										   												
						} while ($row_Ls_ProCntHisRg_His = $Ls_ProCntHisRg_His->fetch()); 			
						foreach ($__col_his as $k => $v) { if(count($v) > $__th_his){ $__th_his = count($v); } }
					}
					

					
					if (($Tot_Ls_ProCntHisRg > 0)&&($Tot_Ls_ProCntHisRg < 20001)) {

						
		
						//-------------------- Actualizacion de Rows --------------------//

							
							foreach ($row_Ls_ProCntHisRg as $r_p) {
								
								
								$_r_id = $r_p['id_dwnprc'];
								$_pc_i = $r_p['id_clgsds'];
								$__r_e = 'ok';
								$update_f = '';
								$update_f_go = '';

								$_upd_rw = UPD_Dwn_R(['d'=>$__dwn_dt->tab, 'r'=>$_pc_i]);
								//print_r($_upd_rw);
		
							}
		
						//-------------------- Finaliza actualizacion de Rows --------------------//
						
					}

					$Ls_ProCntHisRg->closeCursor();
					
					if($__r_all != 'no'){ UPD_Dwn(['i'=>$__dwn_dt->id, 'e'=>'2']); }
					
			}elseif($__dwn_dt->tot->no_u == 0  && $__dwn_dt->tot != 'no' && $__dwn_dt->blq == 'no'){
				
							$__Rcrd_Xls = 1000;
			
							$Ls_ProCntHis_Qry = " SELECT * FROM ".$__dwn_dt->tab." WHERE __dwn_e = 2 ORDER BY id_dwnprc ASC LIMIT $__Rcrd_Xls";
							$pdo_d = CnRd_Pdo(['d'=>'dwn']);								    
							$Ls_ProCntHisRg = $pdo_d->prepare($Ls_ProCntHis_Qry); 
							$Ls_ProCntHisRg->execute(); 
							$row_Ls_ProCntHisRg = $Ls_ProCntHisRg->fetchAll(PDO::FETCH_ASSOC); 
							$Tot_Ls_ProCntHisRg = Pdo_Fix_RwTot($Ls_ProCntHisRg);
							
							$Ls_ProCntHisRg->closeCursor();
							$pdo=null;				
							
							
							$__tpcnt_th = GtSisCntTpLs();
							
							
							$xls_sty = [
							    'font' => [
							        'name' => 'Verdana',
							        'color' => ['rgb' => '000000'],
							        'size' => 10
							    ],
							    'alignment' => [
							        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
							        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
							    ],
							    'borders' => [
							        'allborders' => [
							            'style' => PHPExcel_Style_Border::BORDER_THIN,
							            'color' => ['rgb' => '000000']
							        ]
							    ]
							];
							
							
							$td_sty = [
							    'font'  => [
							        'bold' => true,
							        'color' => ['rgb' => 'FFFFFF']
								]
							];
							
							
							
							//$cacheMethod = PHPExcel_CachedObjectStorageFactory:: cache_to_phpTemp;
							$cacheSettings = [ 'memoryCacheSize' => '256MB'];
							PHPExcel_Settings::setCacheStorageMethod($cacheMethod, $cacheSettings);
							
							
							
							$__fle_nme = '../_cnt/_inf/xls/'.$__dwn_dt->id.'.xlsx';
							UPD_Dwn(['i'=>$__dwn_dt->id, 'b'=>'1' ]);
							
								
							if( file_exists($__fle_nme) || $__dwn_dt->tot->ok_x > 0){
								echo 'Yes, it exist';
								
								
								$oPHPe = PHPExcel_IOFactory::createReader('Excel2007');
								$oPHPe = $oPHPe->load($__fle_nme);
								$oPHPe->setActiveSheetIndex(0);
						
							}else{
								
								echo 'Create File';
								$oPHPe = new PHPExcel();
								$oPHPe->
									getProperties()
										->setCreator("Servicios.in")
										->setLastModifiedBy("Servicios.in")
										->setTitle("Informe")
										->setSubject("Informe")
										->setDescription("Informe")
										->setKeywords("informe")
										->setCategory("reportes");
								
								$oPHPe->getActiveSheet()->getDefaultStyle()->applyFromArray($xls_sty);
							}
							
									
		
							if (($Tot_Ls_ProCntHisRg > 0)) {
								
								try { 
										
										/* TITULOS COLUMNAS EXCEL */
										$__th[] = 'Nombre';
										$__th[] = 'Icfes';
										$__th[] = 'Dane';
										$__th[] = 'Web';
										$__th[] = 'Tipo';
										$__th[] = 'Nivel';
										$__th[] = 'Tamaño';
										$__th[] = 'Tipo de bachillerato';
										$__th[] = 'Rendimiento';
										$__th[] = 'Nivel Socioeconimico';
										$__th[] = 'Ciudad';
										$__th[] = 'Calendario';
										$__th[] = 'Sexo';
										
										$__th[] = 'Mañana';
										$__th[] = 'Tarde';
										$__th[] = 'Noche';
										$__th[] = 'Completa';
										$__th[] = 'Sabatina';
										$__th[] = 'Unica';
										$__th[] = 'Portafolio';
										$__th[] = 'Estado sedes';
										$__th[] = 'Ultimo grado';
										

										$sheet = $oPHPe->getActiveSheet();		
										$_tr_i = 1;		
										
										$__first_rw = $row_Ls_ProCntHisRg[0]['id_dwnprc'];
										
										echo $this->h2('Total de registros a excel: '.$Tot_Ls_ProCntHisRg. ' empezando desde: '. $__first_rw);
										
										
										foreach ($row_Ls_ProCntHisRg as $r_p) {
													
													$_pc_to_del[] = $r_p['id_clgsds'];
												
													
									 				$_clr_rw = NULL; if($r_p['siscntest_clr_bck'] != ''){ $_clr_rw = ' style="background-color:'.$r_p['siscntest_clr_bck'].';" '; }else{ $_clr_rw = $__xl_td; } 
													
													
													if($r_p['__cnttp_all'] != ''){ $_cnttpa = explode('|', $r_p['__cnttp_all']); }else{ $_cnttpa = ''; }
													
													$__td[$_tr_i][] = ctjTx($r_p['clgsds_tt'],'in');
													$__td[$_tr_i][] = ctjTx($r_p['clgsds_icf'],'in');
													$__td[$_tr_i][] = ctjTx($r_p['clgsds_dne'],'in');
													$__td[$_tr_i][] = ctjTx($r_p['clg_web'],'in');
													$__td[$_tr_i][] = ctjTx($r_p['clgtp_tt'],'in');
													$__td[$_tr_i][] = ctjTx($r_p['clgnvl_tt'],'in');
													$__td[$_tr_i][] = ctjTx($r_p['clgtmn_tt'],'in');
													$__td[$_tr_i][] = ctjTx($r_p['clgbchtp_tt'],'in');
													$__td[$_tr_i][] = ctjTx($r_p['clgrdm_tt'],'in');
													$__td[$_tr_i][] = ctjTx($r_p['sisese_tt'],'in');
													$__td[$_tr_i][] = ctjTx($r_p['cd_tt'],'in');
													$__td[$_tr_i][] = ctjTx($r_p['prgcln_nm'],'in');
													$__td[$_tr_i][] = ctjTx($r_p['clgsdssx_nm'],'in');
													
													$__td[$_tr_i][] = _sinoDwn($r_p['clgsds_jrd_mna']);
													$__td[$_tr_i][] = _sinoDwn($r_p['clgsds_jrd_trd']);
													$__td[$_tr_i][] = _sinoDwn($r_p['clgsds_jrd_nch']);
													$__td[$_tr_i][] = _sinoDwn($r_p['clgsds_jrd_cmp']);
													$__td[$_tr_i][] = _sinoDwn($r_p['clgsds_jrd_sbt']);
													$__td[$_tr_i][] = _sinoDwn($r_p['clgsds_jrd_unc']);
													$__td[$_tr_i][] = ctjTx($r_p['sisyr_tt'],'in');
													$__td[$_tr_i][] = ctjTx($r_p['clgsdsest_tt'],'in');
													$__td[$_tr_i][] = ctjTx($r_p['sisgrd_tt'],'in');
													
													
													 
											        	
										
											$_tr_i++;
												
									    }
										
										
										
		    			
										$c_s1 = 1; 
										for($i=0,$j='A';$i<count($__th);$i++,$j++) {
										    $sheet->setCellValue($j.'1', $__th[$i]);  
										    $sheet->getStyle($j.'1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('000000');
										    $sheet->getStyle($j.'1')->applyFromArray( $td_sty);   
										    $c_s1++;
										}
										
										
										
										
										if($__first_rw != '' && $__first_rw != 0){ $_rw = $__first_rw+1; }else{ $_rw = 2; }
										
										
										$sheet->fromArray($__td, NULL, 'A'.$_rw);
					
									
								}catch(Exception $e){
								    echo $e->getMessage();
								}	
			   		
							}	
							
							if($oPHPe != ''){
								try {
								    
								    $_fle = '../_cnt/_inf/xls/'.$__dwn_dt->id.'.xlsx';
								    $objWriter = new PHPExcel_Writer_Excel2007($oPHPe); 
									$objWriter->save($_fle);
									//$objWriter->disconnectWorksheets();
									unset($objWriter, $oPHPe);
									
									UPD_Dwn_R(['d'=>$__dwn_dt->tab, 'r'=>($_rw-1), 'r_to'=>($_rw-1)+($__Rcrd_Xls-1), 'e'=>1]);
									
									echo 'Create on:'.$_fle.$this->br();
									
									$__dwn_dt = GtDwnDt(['id'=>$rC['id_dwn'] ]);
									
									if($__dwn_dt->tot->no_x == 0){
										
										UPD_Dwn(['i'=>$__dwn_dt->id, 'e'=>'1']);
										include('_em/html_dwn_fle.php');
									
										if($__dwn_dt->eml == 'ok' && $__us_msj != ''){

											if($_rsl_snd->us_est == 'ok'){ } 
			
										}
									}
											
											
								} catch (Exception $e) {	
									
									for($r = 1; $r <= $Tot_Ls_ProCntHisRg; $r++){
										UPD_Dwn_R(['d'=>$__dwn_dt->tab, 'r'=>($_rw-1), 'e'=>2]);
										$_rw++;
									}	
										
								    UPD_Dwn(['i'=>$__dwn_dt->id, 'e'=>'5', 'w'=>$e->getMessage() ]);
								    die();
								}
							}
							
							
							UPD_Dwn(['i'=>$__dwn_dt->id, 'b'=>'2' ]);
							
			}				
		
		
		}
	
	}
					
} 

$Ls_ProCntHisRgC->closeCursor();
$pdo_d = '';
$pdo = '';

?>