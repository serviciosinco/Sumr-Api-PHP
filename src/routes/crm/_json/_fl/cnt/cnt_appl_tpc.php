<?php 
	
	
	try{
		
		
		$_tp = Php_Ls_Cln($_POST['t']);
		$_dt = Php_Ls_Cln($_POST['d']);
		$_est = Php_Ls_Cln($_POST['est']);
		
		$_cntappl_enc = Php_Ls_Cln($_POST['cntappl_enc']);
		$_tpc_enc = Php_Ls_Cln($_POST['tpc_enc']);
		
		if($_est == "in"){
			
			$__enc = Enc_Rnd($_cntappl_enc.'-'.$_tpc_enc);
			
			$insertSQL = sprintf("
									INSERT INTO ".TB_CNT_APPL_TPC." 
										(
											cntappltpc_enc, 
											cntappltpc_cntappl, 
											cntappltpc_tpc
										) VALUES 
										(
											%s, 
											(SELECT id_cntappl FROM ".TB_CNT_APPL." WHERE cntappl_enc = %s),
											(SELECT id_tpc FROM "._BdStr(DBM).TB_TPC." WHERE tpc_enc = %s)
										)
								",
		                       GtSQLVlStr($__enc, "text"),
		                       GtSQLVlStr($_cntappl_enc, "text"),
							   GtSQLVlStr($_tpc_enc, "text")
						   );
			
			$Result = $__cnx->_prc($insertSQL);
			
		}else if($_est == "del"){
			
			$EliSQL = sprintf("
								DELETE FROM ".TB_CNT_APPL_TPC."
								WHERE cntappltpc_cntappl IN (SELECT id_cntappl FROM ".TB_CNT_APPL." WHERE cntappl_enc = %s) 
								AND cntappltpc_tpc IN (SELECT id_tpc FROM "._BdStr(DBM).TB_TPC." WHERE tpc_enc = %s)
							",
		                       GtSQLVlStr($_cntappl_enc, "text"),
							   GtSQLVlStr($_tpc_enc, "text")
						   );
			
			$Result = $__cnx->_prc($EliSQL);
			
		}else{
			$rsp['e'] = "no";
		}
		
		
		if(!isN($PrcDt->w_n)){ $rsp['w_n'] = $PrcDt->w_n; }
		
		if( !isN($_cntappl_enc) ){
		
			$_Sb_Qry_Tot = " ( 
								SELECT COUNT(*) FROM ".TB_CNT_APPL_TPC." 
								WHERE cntappltpc_cntappl IN ( 
																SELECT id_cntappl 
																FROM ".TB_CNT_APPL." 
																WHERE cntappl_enc = '".$_cntappl_enc."' 
															) AND cntappltpc_tpc = id_tpc ) AS tot 
							";
							
			$query_DtRg = "
							SELECT *, $_Sb_Qry_Tot
							FROM "._BdStr(DBM).TB_TPC."
							INNER JOIN "._BdStr(DBM).TB_TPC_TP." ON id_tpctp = tpc_tp
							INNER JOIN "._BdStr(DBM).TB_TPC_CL." ON tpccl_tpc = id_tpc
					   		WHERE tpccl_cl = ".DB_CL_ID." AND tpctp_key = 'cmpt'     
					   	";
			
			$DtRg = $__cnx->_qry($query_DtRg);
			
			if($DtRg){
				
				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;
				$Vl['tot'] = $Tot_DtRg;
				
				
				if($Tot_DtRg > 0){
					$rsp['e'] = "ok";
					do{
						if( !isN($row_DtRg['id_tpc']) ){
							$Vl['ls'][$row_DtRg['tpc_enc']]['enc'] = $row_DtRg['tpc_enc'];	
							$Vl['ls'][$row_DtRg['tpc_enc']]['nm'] = ctjTx($row_DtRg['tpc_tt'],'in');
							$Vl['ls'][$row_DtRg['tpc_enc']]['img'] = $row_DtRg['tpc_img'];
							$Vl['ls'][$row_DtRg['tpc_enc']]['tot'] = $row_DtRg['tot'];
						}
					}while($row_DtRg = $DtRg->fetch_assoc());
				}
			}
			
			$__cnx->_clsr($DtRg);
			
			$rtrn = _jEnc($Vl);
			$rsp['tpc'] = $rtrn;
			//$rsp['org']['zna'] = $__Cls_Org->GtOrgSdsZnaLs();
		
		}
		
		
	}catch(Exception $e){
		$rsp['e'] = 'no';
		$rsp['w'] = TX_NSPPCSR .$e->getMessage();
	}
	
?> 