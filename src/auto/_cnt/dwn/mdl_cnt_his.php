<?php

if(class_exists('CRM_Cnx')){
	
	$_i_dwn_p = $this->g__i;
	
	if($_i_dwn_p != '' && $_i_dwn_p != NULL){ $_qry_p = 'AND id_dwn = '.$_i_dwn_p; }else{ $_qry_p = '';}
	
	$_fl_tt = _FleN(['tt'=>'Contactos']);
	$_gt_all_noi = GtSisNoi();
	 
	$pdo_d = CnRd_Pdo(['d'=>'dwn']);
	
	//$__F_FORCE = ' AND id_dwn = 305';
	
	$Ls_QC = "SELECT * FROM ".TB_DWN." WHERE dwn_tp = 'mdl_cnt_his' AND dwn_est != 1 AND dwn_est != 5 $__F_FORCE ORDER BY dwn_r ASC LIMIT 1 ";
	$Ls_ProCntHisRgC = $pdo_d->prepare($Ls_QC); 
	$Ls_ProCntHisRgC->execute(); 
	$row_Ls_ProCntHisRgC = 
	$Ls_ProCntHisRgC->fetchAll(PDO::FETCH_ASSOC); 
	$Tot_Ls_ProCntHisRgC = Pdo_Fix_RwTot($Ls_ProCntHisRgC); 
	

	echo $this->h1('Descargas Gestiones:'.$Tot_Ls_ProCntHisRgC);
	
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
					$Ls_ProCntHisRg->execute(); 
					$row_Ls_ProCntHisRg = $Ls_ProCntHisRg->fetchAll(PDO::FETCH_ASSOC); 
					$Tot_Ls_ProCntHisRg = Pdo_Fix_RwTot($Ls_ProCntHisRg); 
					
					
					echo $this->h2('Total Gestiones:'.$Tot_Ls_ProCntHisRg_His); 
					
					if($Tot_Ls_ProCntHisRg_His > 0){
						do { 	

							if($row_Ls_ProCntHisRg_His['mdlcnthis_dsc'] != ''){
								$_i_p = $row_Ls_ProCntHisRg_His['mdlcnthis_mdlcnt'];
								$_i_p_h = $row_Ls_ProCntHisRg_His['id_mdlcnthis'];
								$__col_his[ $_i_p ][] = ['id'=>$_i_p_h, 
														'f'=>strip_tags( html_entity_decode(	ctjTx($row_Ls_ProCntHisRg_His['mdlcnthis_fi'],'in')	) ),
														't'=>strip_tags( html_entity_decode(	ctjTx($row_Ls_ProCntHisRg_His['mdlcnthis_dsc'],'in')	) ),
														'u'=>ctjTx($row_Ls_ProCntHisRg_His['us_nm'].' '.$row_Ls_ProCntHisRg_His['us_ap'],'in') ];						  	
							}							  																										   												
						} while ($row_Ls_ProCntHisRg_His = $Ls_ProCntHisRg_His->fetch()); 			
						foreach ($__col_his as $k => $v) { if(count($v) > $__th_his){ $__th_his = count($v); } }
					}
					

					
					if (($Tot_Ls_ProCntHisRg > 0)&&($Tot_Ls_ProCntHisRg < 20001)) {

						
		
						//-------------------- Actualizacion de Rows --------------------//

							
							foreach ($row_Ls_ProCntHisRg as $r_p) {
								
								
								$_r_id = $r_p['id_dwnprc'];
								$_pc_i = $r_p['id_mdlcnthis'];
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
										
										$__th[] = 'Orden';
										$__th[] = TX_FI;
										$__th[] = TX_HING;
							            $__th[] = TX_GSTN;
							            $__th[] = 'Descripción';
							            $__th[] = 'Nombre de usuario';
							            $__th[] = 'Apellido de usuario';
							            
										$__th[] = 'Tipo Programa';
										$__th[] = 'Programa';
										$__th[] = 'Periodo';
										$__th[] = TX_FI.' contacto';
										$__th[] = TX_HING.' contacto';
										$__th[] = TT_FM_NM.' contacto';
										$__th[] = TT_FM_AP.' contacto';
										$__th[] = TT_FM_ID.' contacto (Tipo)';
										$__th[] = TT_FM_ID.' contacto';
										$__th[] = TT_FM_EML.' contacto';
										$__th[] = 'Estado final';
										
										$__th[] = 'Modulo';
										$__th[] = 'Centro de costos';
										$__th[] = 'Tipo';

										

										
										$sheet = $oPHPe->getActiveSheet();		
										$_tr_i = 1;		
										
										$__first_rw = $row_Ls_ProCntHisRg[0]['id_dwnprc'];
										
										echo $this->h2('Total de registros a excel: '.$Tot_Ls_ProCntHisRg. ' empezando desde: '. $__first_rw);
										
										$_mdl_cnt_his = 0;
										foreach ($row_Ls_ProCntHisRg as $r_p) {
													
													$_pc_to_del[] = $r_p['id_mdlcnthis'];
												
													
									 				$_clr_rw = NULL; if($r_p['siscntest_clr_bck'] != ''){ $_clr_rw = ' style="background-color:'.$r_p['siscntest_clr_bck'].';" '; }else{ $_clr_rw = $__xl_td; } 
													
													if($r_p['mdlcnthis_mdlcnt'] != $_mdl_cnt_his){
														$_ord = 1;
														$_mdl_cnt_his = $r_p['mdlcnthis_mdlcnt'];
													}else{
														$_ord = ($_ord+1);
													}
													
													if($r_p['__cnttp_all'] != ''){ $_cnttpa = explode('|', $r_p['__cnttp_all']); }else{ $_cnttpa = ''; }
													
												    $__td[$_tr_i][] = $_ord; 
												    $__td[$_tr_i][] = $r_p['mdlcnthis_fi']; 
												    $__td[$_tr_i][] = $r_p['mdlcnthis_hi']; 
												 	$__td[$_tr_i][] = ctjTx($r_p['histp_tt'],'in'); 
													$__td[$_tr_i][] = ctjTx($r_p['mdlcnthis_dsc'],'in'); 
												    $__td[$_tr_i][] = ctjTx($r_p['us_nm'],'in');
												    $__td[$_tr_i][] = ctjTx($r_p['us_ap'],'in');
												   
												    $__td[$_tr_i][] = ctjTx($r_p['sistp_nm'],'in');
												    $__td[$_tr_i][] = ctjTx($r_p['pro_nm'],'in');
												    $__td[$_tr_i][] = ctjTx($r_p['proprd_tt'],'in');
												    $__td[$_tr_i][] = ctjTx($r_p['mdlcnt_fi'],'in');
												    $__td[$_tr_i][] = ctjTx($r_p['mdlcnt_hi'],'in');
												    $__td[$_tr_i][] = ctjTx($r_p['cnt_nm'],'in'); 
												    $__td[$_tr_i][] = ctjTx($r_p['cnt_ap'],'in');
												    $__td[$_tr_i][] = ctjTx($r_p['__dc_tp'],'in'); 
												    $__td[$_tr_i][] = ctjTx($r_p['__dc'],'in'); 
												    $__td[$_tr_i][] = ctjTx($r_p['__eml'],'in'); 
												    $__td[$_tr_i][] = ctjTx($r_p['siscntest_tt'],'in'); 
												    
												    $__td[$_tr_i][] = ctjTx($r_p['pro_niro'],'in'); 
												    $__td[$_tr_i][] = ctjTx($r_p['pro_cdc'],'in'); 
												    $__td[$_tr_i][] = ctjTx($r_p['sistp_nm'],'in'); 
												    
											        	
										
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

//exit();  

?>