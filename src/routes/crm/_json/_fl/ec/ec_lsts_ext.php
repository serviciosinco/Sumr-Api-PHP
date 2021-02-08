<?php 
	
	$rsp['e'] = 'no';
	
	$__eclsts = Php_Ls_Cln($_POST['eclsts']);

	
	if(!isN($__eclsts)){
		
		$__eclsts_a = explode(',', $__eclsts);
		$__eclsts_a = implode("','", $__eclsts_a);
		
		
		//-------------------- Consulta Totales Listas --------------------//
			
			$Ls_TotLds = ", ( 	SELECT COUNT(DISTINCT id_cnteml) 
							FROM ".TB_EC_LSTS_EML." 
								 INNER JOIN ".TB_CNT_EML." ON eclstseml_eml = id_cnteml
								 INNER JOIN ".TB_CNT." ON cnteml_cnt = id_cnt
							WHERE eclstseml_lsts = _m_eclsts.id_eclsts
						) AS __tot_lds ";
					
			$Ls_TotLds_On = ", ( 	SELECT COUNT(DISTINCT id_cnteml) 
								FROM ".TB_EC_LSTS_EML."  
									 INNER JOIN ".TB_CNT_EML." ON eclstseml_eml = id_cnteml
									 INNER JOIN ".TB_CNT_EML_PLCY." ON cntemlplcy_cnteml = id_cnteml
									 INNER JOIN ".TB_CNT." ON cnteml_cnt = id_cnt
									 INNER JOIN ".TB_CNT_PLCY." ON cntplcy_cnt = id_cnt
									 INNER JOIN "._BdStr(DBM).TB_CL_PLCY." ON cntemlplcy_plcy = id_clplcy
									 INNER JOIN "._BdStr(DBM).TB_EC_LSTS_PLCY." ON eclstsplcy_eclsts = eclstseml_lsts
								WHERE eclstseml_lsts = _m_eclsts.id_eclsts AND
									  clplcy_e = 1 AND
									  eclstsplcy_e = 1 AND 
									  cntemlplcy_sndi = 1 AND 
									  cntplcy_sndi = 1 AND 
									  cnteml_rjct = 2 AND 
									  cnteml_est = "._CId('ID_SISEMLEST_ACT')."
									  
							) AS __tot_lds_on ";
			
			$Ls_TotLds_NoSndi = ", ( 	SELECT COUNT(DISTINCT id_cnteml) 
									FROM ".TB_EC_LSTS_EML." 
										 INNER JOIN ".TB_CNT_EML." ON eclstseml_eml = id_cnteml
										 INNER JOIN ".TB_CNT_EML_PLCY." ON cntemlplcy_cnteml = id_cnteml
										 INNER JOIN ".TB_CNT." ON cnteml_cnt = id_cnt
										 INNER JOIN ".TB_CNT_PLCY." ON cntplcy_cnt = id_cnt
										 INNER JOIN "._BdStr(DBM).TB_CL_PLCY." ON cntemlplcy_plcy = id_clplcy
										 INNER JOIN "._BdStr(DBM).TB_EC_LSTS_PLCY." ON eclstsplcy_eclsts = eclstseml_lsts
									WHERE eclstseml_lsts = _m_eclsts.id_eclsts AND 
										  (
										  	cntemlplcy_sndi = 2 OR
										  	cntplcy_sndi = 2
										  )
								) AS __tot_lds_nosndi ";
										
			$Ls_TotLds_Rjct = ", ( 	SELECT COUNT(DISTINCT id_cnteml) 
									FROM ".TB_EC_LSTS_EML." 
										 INNER JOIN ".TB_CNT_EML." ON eclstseml_eml = id_cnteml
										 INNER JOIN ".TB_CNT_EML_PLCY." ON cntemlplcy_cnteml = id_cnteml
										 INNER JOIN ".TB_CNT." ON cnteml_cnt = id_cnt
										 INNER JOIN ".TB_CNT_PLCY." ON cntplcy_cnt = id_cnt
										 INNER JOIN "._BdStr(DBM).TB_EC_LSTS_PLCY." ON eclstsplcy_eclsts = eclstseml_lsts
									WHERE eclstseml_lsts = _m_eclsts.id_eclsts AND cnteml_rjct=1
								) AS __tot_lds_rjct ";
			
			
			$Ls_TotLds_Nexst = ", ( 	SELECT COUNT(DISTINCT id_cnteml) 
									FROM ".TB_EC_LSTS_EML." 
										 INNER JOIN ".TB_CNT_EML." ON eclstseml_eml = id_cnteml
										 INNER JOIN ".TB_CNT." ON cnteml_cnt = id_cnt
									WHERE eclstseml_lsts = _m_eclsts.id_eclsts AND (cnteml_est="._CId('ID_SISEMLEST_NOEXST')." || cnteml_est != "._CId('ID_SISEMLEST_ACT').")
								) AS __tot_lds_nexst ";										
			
			$Ls_TotLds_OnVrf = ", ( 	SELECT COUNT(DISTINCT id_cnteml) 
									FROM ".TB_EC_LSTS_EML." 
										 INNER JOIN ".TB_CNT_EML." ON eclstseml_eml = id_cnteml
										 INNER JOIN ".TB_CNT." ON cnteml_cnt = id_cnt
									WHERE eclstseml_lsts = _m_eclsts.id_eclsts AND cnteml_est="._CId('ID_SISEMLEST_NOCHCK')."
								) AS __tot_lds_onvrf ";
			$Ls_TotLds_Rmv = ", (
									SELECT
										COUNT(DISTINCT id_cnteml)
									FROM
										".TB_EC_LSTS_EML."
									INNER JOIN ".TB_CNT_EML." ON eclstseml_eml = id_cnteml
									INNER JOIN ".TB_CNT_EML_RMV." ON cntemlrmv_cnteml = id_cnteml
									WHERE
										eclstseml_lsts = _m_eclsts.id_eclsts
								) AS __tot_lds_rmv";
			
		//-------------------- Consulta Principal Listas --------------------//
		
			$Ls_Qry = "SELECT
							_m_eclsts.id_eclsts,
							_m_eclsts.eclsts_enc
							$Ls_TotLds $Ls_TotLds_On $Ls_TotLds_NoSndi $Ls_TotLds_Rjct $Ls_TotLds_Nexst $Ls_TotLds_OnVrf $Ls_TotLds_Rmv
						FROM "._BdStr(DBM).TB_EC_LSTS." AS _m_eclsts
						WHERE _m_eclsts.eclsts_enc IN ('{$__eclsts_a}')"; 
						
			$Ls = $__cnx->_qry($Ls_Qry, ['cmps'=>'ok']);
			
			//$rsp['q'] = $Ls_Qry;
			
			if($Ls){
				
				$row_Ls = $Ls->fetch_assoc(); 
				$Tot_Ls = $Ls->num_rows;
				
				if($Tot_Ls>0){
							
					$rsp['e'] = 'ok';
					$rsp['total'] = $Tot_Ls;	
					
					do {
							
						$ido = $row_Ls['id_eclsts'];
						$rsp['l'][$ido]['id'] = $row_Ls['id_eclsts'];
						$rsp['l'][$ido]['tt'] = ctjTx($row_Ls["eclsts_nm"],'in');
						$rsp['l'][$ido]['tot']['lds']['all'] = _Nmb($row_Ls['__tot_lds'],3);
						$rsp['l'][$ido]['tot']['lds']['on'] = _Nmb($row_Ls['__tot_lds_on'],3);
						$rsp['l'][$ido]['tot']['lds']['nosndi'] = _Nmb($row_Ls['__tot_lds_nosndi'],3);
						$rsp['l'][$ido]['tot']['lds']['rmv'] = _Nmb($row_Ls['__tot_lds_rmv'],3);
						$rsp['l'][$ido]['tot']['lds']['rjct'] = _Nmb($row_Ls['__tot_lds_rjct'],3);
						$rsp['l'][$ido]['tot']['lds']['nexst'] = _Nmb($row_Ls['__tot_lds_nexst'],3);
						$rsp['l'][$ido]['tot']['lds']['onvrf'] = _Nmb($row_Ls['__tot_lds_onvrf'],3);
						$rsp['l'][$ido]['fi'] = $row_Ls['eclsts_fi'];
						
					} while ($row_Ls = $Ls->fetch_assoc());
			
				}
			
			}else{
				
				$rsp['w'] = $__cnx->c_r->error; 
				
			}	
	
	}else{
		
		$rsp['w'] = 'No data'; 
		
	}


?>