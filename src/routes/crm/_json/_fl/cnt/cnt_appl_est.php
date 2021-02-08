<?php 
	
	try{
		
		$_tp = Php_Ls_Cln($_POST['t']);
		$_est = Php_Ls_Cln($_POST['est']);
		$_enc = Php_Ls_Cln($_POST['_id_chck']);
		$_mdl = Php_Ls_Cln($_POST['_id_mdl']);
		$_cnt = Php_Ls_Cln($_POST['_id_cnt']);
       
		if($_tp == 'cnt_appl_est'){

			$__sbdmn = Gt_SbDMN();	
			$__dt_cl = __Cl(['id'=>$__sbdmn, 't'=>'sbd' ]);

			if($_est == 'ok'){ 
				$__est = 1; 
				$SelectSQL = sprintf("SELECT COUNT(*) AS __rgtot FROM ".$__dt_cl->bd.".".TB_CNT_APPL." WHERE cntappl_est = 1 
									AND cntappl_mdl = %s AND 
									cntappl_cnt = (SELECT mdlcnt_cnt FROM ".$__dt_cl->bd.".".TB_MDL_CNT." WHERE mdlcnt_enc = %s )", 
									GtSQLVlStr($_mdl, "int"),
									GtSQLVlStr($_cnt, "text"));

				$DtRg = $__cnx->_qry($query_DtRg);

				if($DtRg){
					$row_DtRg = $DtRg->fetch_assoc();
					$Tot_DtRg = $DtRg->num_rows;
					$__tot = $row_DtRg['__rgtot'];	
				}else{ $rsp['w'] = $__cnx->c_r->error; }	

				if($__tot == 0){
					$rsp['__tot'] = $__tot;	
				}else{
					$rsp['__tot'] = $__tot;
				}
				
			}else{ 
				$__est = 2; 
			}	

			$updateSQL = sprintf("UPDATE ".$__dt_cl->bd.".".TB_CNT_APPL." SET cntappl_est = %s WHERE cntappl_enc = %s ", 
									GtSQLVlStr($__est, "int"),
									GtSQLVlStr($_enc, "text"));

			$Result = $__cnx->_prc($updateSQL);	

			if($Result){
				$rsp['e'] = 'ok';	
			}
		}

	}catch(Exception $e){
		$rsp['e'] = 'no';
		$rsp['w'] = TX_NSPPCSR.$e->getMessage();
	}
	
?>