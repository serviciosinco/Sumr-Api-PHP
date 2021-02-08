<?php 
	
	
	
	
	$arrays = $_POST;
	$id_rel = Php_Ls_Cln($_POST['mdl_rel']);
	
	unset($arrays['mdl_rel']);



	foreach($arrays as $k => $v){

		$__enc = Enc_Rnd($k.'-'.$v);
		
		$query_DtRg = "	SELECT * 
						FROM ".TB_MDL_ATTR." 
						WHERE mdlattr_mdl = (SELECT id_mdl FROM ".TB_MDL." WHERE mdl_enc = '".$id_rel."') AND mdlattr_attr = ( SELECT id_sisslc FROM "._BdStr(DBM).TB_SIS_SLC." WHERE sisslc_enc='".$k."') ";
		
		$Result = $__cnx->_qry($query_DtRg);	

		if($Result){

			$row_DtRg = $Result->fetch_assoc();
			$Tot_DtRg = $Result->num_rows;

			if($Tot_DtRg > 0){
				
				$updateSQL = sprintf("UPDATE ".TB_MDL_ATTR." SET mdlattr_vl=%s WHERE mdlattr_mdl=(SELECT id_mdl FROM ".TB_MDL." WHERE mdl_enc = %s) AND mdlattr_attr = ( SELECT id_sisslc FROM "._BdStr(DBM).TB_SIS_SLC." WHERE sisslc_enc=%s)",				
							GtSQLVlStr(ctjTx($v,'out'), "text"),
							GtSQLVlStr($id_rel, "text"),
							GtSQLVlStr(ctjTx($k,'out'), "text"));
							
				$Result_Upd = $__cnx->_prc($updateSQL);
				
				
				$rsp['q'] = $updateSQL;

				if($Result_Upd){
					$_e = 'ok';
					$rsp[$k]['e'] = 'ok';
					$rsp[$k]['tp'] = 'Upd';
					$rsp['e'] = 'ok';
				}else{
					$_e = 'no';
					$rsp[$k]['e'] = 'no';
					$rsp[$k]['tp'] = 'Upd';
					$rsp['e'] = 'no';
				}	
				
				if($_e == 'no'){
					$rsp['e'] = 'no';	
				}
			
			}else{
				
				$insertSQL = sprintf("INSERT INTO ".TB_MDL_ATTR." (mdlattr_enc, mdlattr_mdl, mdlattr_attr, mdlattr_vl) VALUES (%s,(SELECT id_mdl FROM ".TB_MDL." WHERE mdl_enc = %s), ( SELECT id_sisslc FROM "._BdStr(DBM).TB_SIS_SLC." WHERE sisslc_enc=%s), %s)",
	            			GtSQLVlStr($__enc, "text"),
							GtSQLVlStr($id_rel, "text"),
							GtSQLVlStr($k, "text"),
							GtSQLVlStr(ctjTx($v,'out'), "text"));
							
				$Result_Ins = $__cnx->_prc($insertSQL);	
	                 
	            //$rsp['q'] = $Result_Ins;
	                  
	            if($Result_Ins){
					$_e = 'ok';
					$rsp[$k]['e'] = 'ok';
					$rsp[$k]['tp'] = 'Ins';	
					$rsp['e'] = 'ok';		
				} else{
					$_e = 'no';
					$rsp[$k]['e'] = 'no';
					$rsp[$k]['tp'] = 'Ins';
					$rsp[$k]['q'] = $insertSQL;
					$rsp[$k]['w'] = $__cnx->c_p->error;
					$rsp['e'] = 'no';
				}
				
				
					
			}
			
			if($_e == 'no'){
				$rsp['e'] = 'no';
			}

		}else{
			
		}
		
		
	}
	
	
?>