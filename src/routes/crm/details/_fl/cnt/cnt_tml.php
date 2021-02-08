<?php
		
		$__dt_cnt = GtCntDt([  'id'=> GtSQLVlStr($_GET['_i'], "int") ]);
		
		
		/* Programas de Interes */
		
		$Ls_Pro_Qry  = sprintf("SELECT * 
								FROM ".TB_MDL_CNT."
									 INNER JOIN ".TB_BD." ON mdlcnt_mdl = id_mdl 
									 INNER JOIN "._BdStr(DBM).TB_MDL_S." ON mdl_mdls = id_mdls
									 INNER JOIN "._BdStr(DBM).TB_MDL_S_TP." ON mdls_tp = id_mdlstp
								WHERE mdlcnt_cnt = %s ORDER BY mdlcnt_fi DESC", GtSQLVlStr($_GET['_i'], "int"));
								
		 
				  
		$Ls_Pro = $__cnx->_qry($Ls_Pro_Qry);
	 	$row_Ls_Pro = $Ls_Pro->fetch_assoc(); 
	 	$Tot_Ls_Pro = $Ls_Pro->num_rows;

	    
		if($Tot_Ls_Pro > 0){
		 	do {
		 		
		 		
		 		
		 		if($row_Ls_Pro['mdl_nm'] != ''){
					
					$_id = $row_Ls_Pro['id_mdlcnt'];
					$__ff = date_create($row_Ls_Pro['mdlcnt_fi'] );
					
					
					
					$_idf = $__ff->format('Y-m-d');
					
					$_r[$_idf]['date'] = $_idf;
					$_r[$_idf]['pro-'.$_id]['nm'] = Spn(TX_INT_EN, '', '', 'color:'.$row_Ls_Pro['mdlstp_clr']).' '.
													ctjTx( $row_Ls_Pro['mdlstp_nm'] .' '. $row_Ls_Pro['mdl_nm'] ,'in');
													
					$_r[$_idf]['pro-'.$_id]['f'] = FechaESP_OLD($_idf, 'yrdy');
					$_r[$_idf]['pro-'.$_id]['fi'] = $_idf;
					$_r[$_idf]['pro-'.$_id]['hi'] = $__ff->format('g:i a');
					$_r[$_idf]['pro-'.$_id]['icn'] = str_replace(' ','',strtolower($row_Ls_Pro['mdlstp_nm']));
					$_r[$_idf]['pro-'.$_id]['clr'] = $row_Ls_Pro['mdlstp_clr'];
					
					
					
				}
				
			} while ($row_Ls_Pro = $Ls_Pro->fetch_assoc());
		}
		
		
		
		
		
		/* Gestiónes */
		
		$Ls_Pro_His_Qry  = sprintf("SELECT * 
									FROM ".TB_MDL_CNT." 
										 INNER JOIN ".TB_MDL_CNT_HIS." ON mdlcnthis_mdlcnt = id_mdlcnt
										 INNER JOIN ".TB_BD." ON mdlcnt_mdl = id_mdl
										 INNER JOIN "._BdStr(DBM).TB_US." ON mdlcnthis_us = id_us
										 INNER JOIN "._BdStr(DBM).TB_MDL_S." ON mdl_mdls = id_mdls
										 INNER JOIN "._BdStr(DBM).TB_MDL_S_TP." ON mdls_tp = id_mdlstp
										 
									WHERE mdlcnt_cnt = %s ORDER BY mdlcnthis_fi DESC, mdlcnthis_hi DESC", GtSQLVlStr($_GET['_i'], "int"));
		
					
											
		$Ls_Pro_His = $__cnx->_qry($Ls_Pro_His_Qry);
	 	$row_Ls_Pro_His = $Ls_Pro_His->fetch_assoc(); 
	 	$Tot_Ls_Pro_His = $Ls_Pro_His->num_rows;
	 	
	 	
	
		if($Tot_Ls_Pro_His > 0){
		 	do {
		 		
		 		if($row_Ls_Pro_His['mdlcnthis_dsc'] != ''){
			 		
					$_id = $row_Ls_Pro_His['id_mdlcnt'];
					$_id2 = $row_Ls_Pro_His['id_mdlcnthis'];
					$__ff = date_create($row_Ls_Pro_His['mdlcnthis_fi'].' '.$row_Ls_Pro_His['mdlcnthis_hi'] );
					$_idf = $__ff->format('Y-m-d');

					
					$_r[$_idf]['date'] = $_idf;
					
					$_r[$_idf]['pro-'.$_id]['nm'] = ctjTx( $row_Ls_Pro_His['mdlstp_nm'] .' '. $row_Ls_Pro_His['mdl_nm'] ,'in');
					$_r[$_idf]['pro-'.$_id]['f'] = FechaESP_OLD($_idf, 'yrdy');
					$_r[$_idf]['pro-'.$_id]['fi'] = $_idf;
					$_r[$_idf]['pro-'.$_id]['hi'] = $__ff->format('g:i a');
					$_r[$_idf]['pro-'.$_id]['icn'] = str_replace(' ','',strtolower($row_Ls_Pro_His['mdlstp_nm']));
					$_r[$_idf]['pro-'.$_id]['clr'] = $row_Ls_Pro_His['mdlstp_clr'];
					
					
					$_r[$_idf]['pro-'.$_id]['his'][$_id]['nm'] = Spn(TX_GST_IN, '', '', 'color:'.$row_Ls_Pro_His['mdlstp_clr']).' '.
												    			 ctjTx( $row_Ls_Pro_His['us_nm'].' '.$row_Ls_Pro_His['us_ap'] ,'in');
												    
					$_r[$_idf]['pro-'.$_id]['his'][$_id]['tx'] = strip_tags( ctjTx( $row_Ls_Pro_His['mdlcnthis_dsc'],'in') );
					$_r[$_idf]['pro-'.$_id]['his'][$_id]['f'] = FechaESP_OLD($_idf, 'yrdy');
					$_r[$_idf]['pro-'.$_id]['his'][$_id]['fi'] = $_idf;
					$_r[$_idf]['pro-'.$_id]['his'][$_id]['hi'] = $__ff->format('g:i a');
					$_r[$_idf]['pro-'.$_id]['his'][$_id]['icn'] = 'gestion';
					$_r[$_idf]['pro-'.$_id]['his'][$_id]['clr'] = $row_Ls_Pro_His['mdlstp_clr'];
					
				}
				
			} while ($row_Ls_Pro_His = $Ls_Pro_His->fetch_assoc());
		}
		
		
		
		/* Cambios de Estado */
		
		$Ls_Mdl_Est_Qry  = sprintf("SELECT * 
									FROM ".TB_MDL_CNT."
										 INNER JOIN ".TB_MDL_CNT_EST." ON mdlcntest_mdlcnt = id_mdlcnt
										 INNER JOIN "._BdStr(DBM).TB_SIS_CNT_EST." ON mdlcntest_est = id_siscntest
										 INNER JOIN ".TB_BD." ON mdlcnt_mdl = id_mdl
										 INNER JOIN "._BdStr(DBM).TB_US." ON mdlcntest_us = id_us
										 INNER JOIN "._BdStr(DBM).TB_MDL_S." ON mdl_mdls = id_mdls
										 INNER JOIN "._BdStr(DBM).TB_MDL_S_TP." ON mdls_tp = id_mdlstp
									
									WHERE mdlcnt_cnt = %s ORDER BY mdlcntest_fi DESC", GtSQLVlStr($_GET['_i'], "int"));
		
		
	
		
		$Ls_Mdl_Est = $__cnx->_qry($Ls_Mdl_Est_Qry);
	 	$row_Ls_Mdl_Est = $Ls_Mdl_Est->fetch_assoc(); 
	 	$Tot_Ls_Mdl_Est = $Ls_Mdl_Est->num_rows;
	 	
	
		if($Tot_Ls_Mdl_Est > 0){
		 	do {
		 		
		 		if($row_Ls_Mdl_Est['id_mdlcntest'] != ''){
			 		
					$_id = $row_Ls_Mdl_Est['id_mdlcnt'];
					$_id2 = $row_Ls_Mdl_Est['id_mdlcntest'];
					$__ff = date_create($row_Ls_Mdl_Est['mdlcntest_fi']); 
					$_idf = $__ff->format('Y-m-d');
					
					$_r[$_idf]['date'] = $_idf;
					
					$_r[$_idf]['pro-'.$_id]['nm'] = ctjTx( $row_Ls_Pro_His['mdlstp_nm'] .' '. $row_Ls_Pro_His['mdl_nm'] ,'in');
					$_r[$_idf]['pro-'.$_id]['icn'] = str_replace(' ','',strtolower($row_Ls_Mdl_Est['mdlstp_nm']));
					$_r[$_idf]['pro-'.$_id]['clr'] = $row_Ls_Mdl_Est['mdlstp_clr'];
					
					
					$_r[$_idf]['pro-'.$_id]['his'][$_id2]['time'] = $__ff->format('gi');
					$_r[$_idf]['pro-'.$_id]['his'][$_id2]['nm'] =   Spn(TX_CMB_EST, '', '', 'color:'.$row_Ls_Mdl_Est['mdlstp_clr']).' '.
																    ctjTx( $row_Ls_Mdl_Est['us_nm'].' '.$row_Ls_Mdl_Est['us_ap'] ,'in');
												    
					$_r[$_idf]['pro-'.$_id]['his'][$_id2]['tx'] = Spn('', '', '_icn_est', 'background-color:'.$row_Ls_Mdl_Est['siscntest_clr_bck']) . ctjTx( $row_Ls_Mdl_Est['siscntest_tt'], 'in');
					$_r[$_idf]['pro-'.$_id]['his'][$_id2]['f'] = FechaESP_OLD($_idf, 'yrdy');
					$_r[$_idf]['pro-'.$_id]['his'][$_id2]['fi'] = $_idf;
					$_r[$_idf]['pro-'.$_id]['his'][$_id2]['hi'] = $__ff->format('g:i a');
					$_r[$_idf]['pro-'.$_id]['his'][$_id2]['icn'] = 'gestion';
					$_r[$_idf]['pro-'.$_id]['his'][$_id2]['clr'] = $row_Ls_Mdl_Est['mdlstp_clr'];
					
				}
				
			} while ($row_Ls_Mdl_Est = $Ls_Mdl_Est->fetch_assoc());
		}
		
		
		
		
		/* Comentarios Usuario */
		
		$Ls_Pro_Msj_Qry  = sprintf("SELECT * 
									FROM ".TB_MDL_CNT_MSJ."
										 INNER JOIN ".TB_MDL_CNT." ON mdlcntmsj_mdlcnt = id_mdlcnt
										 INNER JOIN ".TB_BD." ON mdlcnt_mdl = id_mdl
										 INNER JOIN "._BdStr(DBM).TB_MDL_S." ON mdl_mdls = id_mdls
										 INNER JOIN "._BdStr(DBM).TB_MDL_S_TP." ON mdls_tp = id_mdlstp
										 
									WHERE mdlcnt_cnt = %s ORDER BY mdlcntmsj_fi DESC", GtSQLVlStr($_GET['_i'], "int"));
		
		$Ls_Pro_Msj = $__cnx->_qry($Ls_Pro_Msj_Qry);
	 	$row_Ls_Pro_Msj = $Ls_Pro_Msj->fetch_assoc(); 
	 	$Tot_Ls_Pro_Msj = $Ls_Pro_Msj->num_rows;
	 	
	
		if($Tot_Ls_Pro_Msj > 0){
		 	do {
		 		
		 		if($row_Ls_Pro_Msj['id_mdlcntmsj'] != ''){
			 		
					$_id = $row_Ls_Pro_Msj['id_mdlcnt'];
					$_id2 = $row_Ls_Pro_Msj['id_mdlcntmsj'];
					$__ff = date_create($row_Ls_Pro_Msj['mdlcntmsj_fi']); 
					$_idf = $__ff->format('Y-m-d');
					
					$_r[$_idf]['date'] = $_idf;
					
					$_r[$_idf]['pro-'.$_id]['nm'] = ctjTx( $row_Ls_Pro_His['mdlstp_nm'] .' '. $row_Ls_Pro_His['mdl_nm'] ,'in');
					$_r[$_idf]['pro-'.$_id]['icn'] = str_replace(' ','',strtolower($row_Ls_Pro_Msj['mdlstp_nm']));
					$_r[$_idf]['pro-'.$_id]['clr'] = $row_Ls_Pro_Msj['mdlstp_clr'];
					$_r[$_idf]['pro-'.$_id]['msj'] .= strip_tags(ctjTx($row_Ls_Pro_Msj['mdlcntmsj_msj'] ,'in')).HTML_BR.'por: '.Strn($__dt_cnt->nm.' '.$__dt_cnt->ap);

				}
				
			} while ($row_Ls_Pro_Msj = $Ls_Pro_Msj->fetch_assoc());
		}
		
		
		
		
		//print_r($_r);

		function do_srt_dte($a, $b) {
		    $aval = strtotime($a['date']);
		    $bval = strtotime($b['date']);
		    if ($aval == $bval) { return 0; }
		    return $aval > $bval ? -1 : 1;
		}
		
		function do_srt_tme($a=NULL, $b) {
			if($a != NULL){
			    $aval = strtotime($a['time']);
			    $bval = strtotime($b['time']);
			    if ($aval == $bval) { return 0; }
			    return $aval > $bval ? -1 : 1;
			}
		}
		
		usort($_r, 'do_srt_dte');
		$__r = json_decode(json_encode( $_r ));
		
?>
	<header class="cd-container-hdr">
		<h1> 
				<div class="_icn"> 
					<?php if($__dt_cnt->fll->pht->{1}->url != NULL){ ?><img src="<?php echo $__dt_cnt->fll->pht->{1}->url ?>" /><?php } ?>
				</div> 
				<div class="_nm">
					<?php echo $__dt_cnt->nm.' '.$__dt_cnt->ap.
							   Spn($__dt_cnt->dc_tp.' '.$__dt_cnt->dc).
							   Spn(TX_FIN.' '.FechaESP_OLD($__dt_cnt->fi, 'yrdy'), '', '_in') ?> 
				</div>
		</h1>
	</header>

	<section id="cd-timeline" class="cd-container">
		
		
		<?php foreach($__r as $_d){ ?>
			
			<?php foreach($_d as $_d_ls){ ?>
				<?php if($_d_ls->nm != '' && $_d_ls != NULL){ if(is_array($_d_ls) && $_d_ls != NULL){ usort($_d_ls, 'do_srt_tme'); } ?>
					<div class="cd-timeline-block">
						<div class="cd-timeline-img cd-<?php echo $_d_ls->icn ?>">
							<img src="<?php echo DMN_IMG_ESTR_SVG.'icon_'.$_d_ls->icn.'.svg' ?>" >
						</div> 
			
						<div class="cd-timeline-content">
							<h2><?php echo $_d_ls->nm; ?></h2>
							<p><?php print_r($_d_ls->msj); ?></p>
							<?php if($_d_ls->f != NULL){ ?> <span class="cd-date"><?php echo $_d_ls->f.' '.Spn($_d_ls->hi, 'ok'); ?></span> <?php } ?>
							
							<?php if($_d_ls->his != NULL){ ?>
							
									
									<?php foreach($_d_ls->his as $_d_his){ ?>
										<?php if($_d_his->tx != ''){ ?>
											<div class="history">
												<div class="cd-timeline-img-sub cd-<?php echo $_d_his->icn ?>">
													<img src="<?php echo DMN_IMG_ESTR_SVG.'icon_'.$_d_his->icn.'.svg' ?>" >
												</div> 
												<h2><?php echo $_d_his->nm; ?></h2>
												<p><?php echo $_d_his->tx; ?></p>
												<?php if($_d_his->hi != NULL){ ?> <span class="cd-date-sub"><?php echo $_d_his->hi; ?></span> <?php } ?>
											</div>
										<?php } ?>
										
									<?php } ?>
							<?php } ?>
							
							
						</div> 
					</div> 
				<?php } ?>	
			<?php } ?>
				
		<?php } ?>

		
	</section>