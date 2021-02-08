<?php 
	Hdr_JSON();
	$_tp = Php_Ls_Cln($_POST['_tp']);
	$_qry = Php_Ls_Cln($_POST['_qry']);
	$_tt = Php_Ls_Cln($_POST['_tt']);
	$_vl = Php_Ls_Cln($_POST['_vl']);
	$_id = Php_Ls_Cln($_POST['_id']);
	$_ctg = Php_Ls_Cln($_POST['_ctg']);
	
	
	
	
	
	if($_tp == "mtrc_qry"){
		//Convertir en costantes
		preg_match_all('/\[.*?\]/', $_qry, $__all);
		foreach($__all[0] as $Key_sch){
			$key_cln = str_replace(['[',']'],'', $Key_sch);
			$_qry = str_replace($Key_sch, _Cns($key_cln),  $_qry);
		}
		
		$Dt_Rg = $__cnx->_qry($_qry);
		//echo $Dt_Rg; exit();
		if($Dt_Rg){
			do{
				if($row_Dt_Rg[$_tt] != '' && $row_Dt_Rg[$_tt] != NULL){
					if($row_Dt_Rg[$_tt] != '' && $row_Dt_Rg[$_tt] != NULL){ $rsp['_tt'][] = ctjTx($row_Dt_Rg[$_tt],'in'); }else{ $rsp['_tt'][] = '-NA-'; }
					if($row_Dt_Rg[$_vl] != '' && $row_Dt_Rg[$_vl] != NULL){ $rsp['_vl'][] = ctjTx($row_Dt_Rg[$_vl],'in'); }else{ $rsp['_vl'][] = '-NA-'; }
					if($row_Dt_Rg[$_id] != '' && $row_Dt_Rg[$_id] != NULL){ $rsp['_id'][] = ctjTx($row_Dt_Rg[$_id],'in'); }else{ $rsp['_id'][] = '-NA-'; }
					if($row_Dt_Rg[$_ctg] != '' && $row_Dt_Rg[$_ctg] != NULL){ $rsp['_ctg'][] = ctjTx($row_Dt_Rg[$_ctg],'in'); }else{ $rsp['_ctg'][] = '-NA-'; }
				}
			}while($row_Dt_Rg = $Dt_Rg->fetch_assoc());
			
			$rsp['_tot'][] = $Dt_Rg->num_rows;
			if($Dt_Rg->num_rows > 0){
				$rsp['e'] = 'ok';
			}else{
				$rsp['e'] = 'no';
				$rsp['w'] = TX_NEXTDT;
			}
			
		}else{
			$rsp['e'] = 'no';
			$rsp['w'] = $__cnx->c_r->error;
		}
		
	}else{
		$rsp['e'] = 'no';
		$rsp['w'] = TX_NEXTP;
	} 
?>