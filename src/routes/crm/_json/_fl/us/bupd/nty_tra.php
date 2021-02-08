<?php 
	
	
	/* $rsp['noty']['tot'] = 0;	
		
	$__id = 'id_tra';
	$__dsc = 'tra_dsc';
	$__hr = 'tra_h';
	$__f = 'tra_f';
	
	$__tmrw = new DateTime('tomorrow');
	$__tmrw = $__tmrw->format('Y-m-d');


	$_Hact = date("H:i:s",$m=strtotime('+1 minutes'));
	$_Hant = date("H:i:s",$m=strtotime('+15 minutes'));

	$Rsp_Tot_Nw .= " , COUNT(IF(trarsp_us = ".SISUS_ID.",  1, NULL)) AS __tot_rsp ";
	
	$__ntf = $___Ls->_ntf_qry([ 'tp'=>'tra', 'k'=>'id_tra' ]);
	
	
	$F_Prx = ", DATEDIFF(tra_f, CURDATE()) AS __f_dif";
	$H_Prx = ", TIMEDIFF(tra_h, CURTIME()) AS __h_dif";
	 */
	
	/*	
	$Ls_Whr = "	FROM ".TB_TRA_RSP."
					INNER JOIN ".TB_TRA." ON trarsp_tra = id_tra
					INNER JOIN "._BdStr(DBM).TB_US." ON tra_us = id_us 
				WHERE tra_cls != 1 $Rsp_All AND tra_est = '"._CId('ID_TRAEST_PRC')."' AND tra_us = ".SISUS_ID." ".$__ntf;
				
	$NtyLsTra_Qry = "	SELECT *, 
							(SELECT COUNT(*) $Ls_Whr LIMIT 1) AS ".QRY_RGTOT." 
							$Rsp_Tot_Nw $F_Prx $H_Prx 
						$Ls_Whr 
						GROUP BY trarsp_tra 
						HAVING 	( 
									(__f_dif <= 0 AND __h_dif <= 0) || ( __f_dif <= 0 ) 
								)  AND
								(
									__tot_rsp > 0 
								)
					  
						ORDER BY tra_f ASC, tra_h ASC";
	
	$Ls_Lmt = sprintf("%s LIMIT %d, %d", $NtyLsTra_Qry, $Ls_St, 2);
	
	$NtyLsTra_Rg = $__cnx->_qry($Ls_Lmt); 	

	
	if($NtyLsTra_Rg){
		
		$row_NtyLsTra_Rg = $NtyLsTra_Rg->fetch_assoc(); 
		$Tot_NtyLsTra_Rg = $NtyLsTra_Rg->num_rows;
		
		
		
		$horaBD = $row_NtyLsTra_Rg['tra_h'];
		$horaN = strtotime ( '-15 minute' , strtotime ( $horaBD ) ) ;
		$horaN = date ( 'H:i:s' , $horaN );
		$fechaN = date("Y-m-d");
		$horaA = date("H:i:s");

		
		if($Tot_NtyLsTra_Rg > 0){
			

			$rsp['noty']['tot'] = $rsp['noty']['tot']+$Tot_NtyLsTra_Rg;
			$rsp['e'] = 'ok';
			
			do {
				
				if(($fechaN > $row_NtyLsTra_Rg['tra_f']) || ($fechaN = $row_NtyLsTra_Rg['tra_f'] && $horaA >= $horaN)){
					
					$__ff = date_create($row_NtyLsTra_Rg['tra_f'].' '.$row_NtyLsTra_Rg['tra_h'] );
					$__dt_mdlcnt = GtMdlCntTraDt($row_NtyLsTra_Rg['id_tra'], 'tra');
					
					$_lnktr_l = FL_LS_GN.__t('tra',true).ADM_LNK_DT.$row_NtyLsTra_Rg['tra_enc'].TXGN_POP.TXGN_BX.$___Ls->bx_rld.ADM_LNK_NTF.$row_NtyLsTra_Rg['tra_enc']; 
					
					
					$rsp['noty']['list'][ 'Tra_'.$row_NtyLsTra_Rg['id_tra'] ]['id'] = $row_NtyLsTra_Rg['id_tra'];
					$rsp['noty']['list'][ 'Tra_'.$row_NtyLsTra_Rg['id_tra'] ]['id_obj'] = 'trantf_'.$row_NtyLsTra_Rg['id_tra'];
					$rsp['noty']['list'][ 'Tra_'.$row_NtyLsTra_Rg['id_tra'] ]['dsc'] = ShortTx(ctjTx( strip_tags($row_NtyLsTra_Rg['tra_dsc']) ,'in'),80,'Pt');
					$rsp['noty']['list'][ 'Tra_'.$row_NtyLsTra_Rg['id_tra'] ]['tt'] = ShortTx(ctjTx( strip_tags($row_NtyLsTra_Rg['tra_tt']) ,'in'),80,'Pt');
					$rsp['noty']['list'][ 'Tra_'.$row_NtyLsTra_Rg['id_tra'] ]['f'] = $__ff->format('Y-m-d');
					$rsp['noty']['list'][ 'Tra_'.$row_NtyLsTra_Rg['id_tra'] ]['h'] = $__ff->format('g:i a');
					$rsp['noty']['list'][ 'Tra_'.$row_NtyLsTra_Rg['id_tra'] ]['cnt'] = ($__dt_mdlcnt->mdl_cnt->cnt->nm != NULL) ? $__dt_mdlcnt->mdl_cnt->cnt->nm.' '.$__dt_mdlcnt->mdl_cnt->cnt->ap : "Tarea";
					$rsp['noty']['list'][ 'Tra_'.$row_NtyLsTra_Rg['id_tra'] ]['opn'] = $_lnktr_l;
					$rsp['noty']['list'][ 'Tra_'.$row_NtyLsTra_Rg['id_tra'] ]['tg'] = 'TraNtf_'.$row_NtyLsTra_Rg['id_tra'];
					$rsp['noty']['list'][ 'Tra_'.$row_NtyLsTra_Rg['id_tra'] ]['tp'] = 'information';
					$rsp['noty']['list'][ 'Tra_'.$row_NtyLsTra_Rg['id_tra'] ]['tp_c'] = 'tareas';
					$rsp['noty']['list'][ 'Tra_'.$row_NtyLsTra_Rg['id_tra'] ]['btn_1'] = TX_VRTRA;
					$rsp['noty']['list'][ 'Tra_'.$row_NtyLsTra_Rg['id_tra'] ]['btn_2'] = TX_CLSE;
					$rsp['noty']['list'][ 'Tra_'.$row_NtyLsTra_Rg['id_tra'] ]['hg'] = 600;
					$rsp['noty']['list'][ 'Tra_'.$row_NtyLsTra_Rg['id_tra'] ]['opn_pop'] = "no";
					$rsp['noty']['list'][ 'Tra_'.$row_NtyLsTra_Rg['id_tra'] ]['qry'] = $Ls_Lmt;
				
				}
				
				
			} while ($row_NtyLsTra_Rg = $NtyLsTra_Rg->fetch_assoc());
		
		}
	
	}	


*/
	
?>