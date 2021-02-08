<?php 
	
	if($_POST['_tp'] == 1 && $_POST['_tp_txt'] != '' && $_POST['_tp_txt'] != NULL){
		$query_DtRg = sprintf('INSERT INTO '.DBM.'.bco_use_tp (bcousetp_tt) VALUES (%s)', 
		GtSQLVlStr(ctjTx($_POST['_tp_txt'] ,'out'), 'text'));
		$DtRg = $__cnx->_prc($query_DtRg);
	}
	
	$_id_tp = $__cnx->c_p->insert_id;
	
	if($_id_tp != '' && $_id_tp != NULL){
		$_tp = $_id_tp;
	}else{
		$_tp = $_POST['_tp'];
	}
	
	
	$c_DtRg = "-1";if (isset($__i)){$c_DtRg = preg_replace('/\s+/','',$__i);}
	$query_DtRg = sprintf('INSERT INTO '.DBM.'.bco_use (bcouse_bco, bcouse_dsc, bcouse_tp, bcouse_us) VALUES (%s, %s, %s, %s)', 
	GtSQLVlStr(ctjTx($_POST['_bco'],'out'), 'int'),
	GtSQLVlStr(ctjTx($_POST['_desc'],'out'), 'text'),
	GtSQLVlStr(ctjTx($_tp,'out'), 'text'),
	GtSQLVlStr(ctjTx(SISUS_ID,'out'), 'int'));
	
	$DtRg = $__cnx->_prc($query_DtRg);
	$Tot_DtRg = $DtRg->num_rows;	
	
	if($DtRg){	
		
		$rsp['e'] = 'ok';
		if($_id_tp != '' && $_id_tp != NULL){
			$rsp['_tp_nw'] = 'ok';
			$rsp['_id'] = $_id_tp;
			$rsp['_vlr'] = $_POST['_tp_txt'];
		}
		
	}else{
		
		$rsp['e'] = 'no';
		$rsp['qry'] = $query_DtRg;
		$rsp['error'] = $__cnx->c_p->error;
		
	}
	
	$Dt_Rg->free; 
?>