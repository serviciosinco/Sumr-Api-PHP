<?php

$actE =$_POST['__i'];	   
$chkE = $_POST['chk_enc'];
$actE = $_POST['act_enc'];
$actO= $_POST['chk_obs'];



if($_POST['d'] == "chk"){
	if($_POST['tp'] == "_ing"){
		$insertSQL = sprintf("INSERT INTO ".TB_ACT_CHK_RLC." 
			(
				actchkrlc_chk,
				actchkrlc_act, 
				actchkrlc_obs
			) 
			VALUES
			( 
				( SELECT id_actchk FROM act_chk WHERE actchk_enc = %s ),
				( SELECT id_act  FROM act WHERE act_enc = %s ),
				%s
			)",
			GtSQLVlStr(ctjTx($chkE, 'out'), "text"),
			GtSQLVlStr(ctjTx($actE, 'out'), "text"),
			GtSQLVlStr(ctjTx('', 'out'), "text"));
		
		
		$Result = $__cnx->_prc($insertSQL);
		
		if($Result){
			$rsp['e'] = 'ok';
			$rsp['m'] = 1;
		}else{
			$rsp['e'] = 'no';
			$rsp['h'] = $__cnx->c_p->error;
			$rsp['m'] = 2;
			_ErrSis(['p'=>$updateSQL, 'd'=>$__cnx->c_p->error]);
		} 
		
		
	}else if($_POST['tp'] == "_eli"){
		$DeleteSQL = sprintf("DELETE FROM ".TB_ACT_CHK_RLC." WHERE 
				actchkrlc_chk = ( SELECT id_actchk FROM act_chk WHERE actchk_enc = %s ) AND 
				actchkrlc_act = ( SELECT id_act FROM act WHERE act_enc = %s )",
				GtSQLVlStr(ctjTx($chkE, 'out'), "text"),
				GtSQLVlStr(ctjTx($actE, 'out'), "text"));
	
		
		$Result = $__cnx->_prc($DeleteSQL);
		
		if($Result){
			$rsp['e'] = 'ok';
			$rsp['m'] = 1;
		}else{
			$rsp['e'] = 'no';
			$rsp['h'] = $__cnx->c_p->error;
			$rsp['m'] = 2;
			_ErrSis(['p'=>$DeleteSQL, 'd'=>$__cnx->c_p->error]);
		}		
	}
}elseif($_POST['d'] == "txt"){

		$updateSQL = sprintf("UPDATE ".TB_ACT_CHK_RLC." SET actchkrlc_obs = %s WHERE	
								actchkrlc_chk = ( SELECT id_actchk FROM act_chk WHERE actchk_enc = %s ) AND 
								actchkrlc_act = ( SELECT id_act FROM act WHERE act_enc = %s )",
								GtSQLVlStr(ctjTx($actO, 'out'), "text"),
								GtSQLVlStr(ctjTx($chkE, 'out'), "text"),
								GtSQLVlStr(ctjTx($actE, 'out'), "text")
							);
					
							  
		$Result = $__cnx->_prc($updateSQL); 
		if($Result){
			$rsp['e'] = 'ok';
			$rsp['m'] = 1;
		}else{
			$rsp['e'] = 'no';
			$rsp['h'] = $__cnx->c_p->error;
			$rsp['m'] = 2;
			_ErrSis(['p'=>$DeleteSQL, 'd'=>$__cnx->c_p->error]);
		}	
		
								
}

?>