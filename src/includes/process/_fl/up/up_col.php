<?php
	
	$__Up = new CRM_Up();	
	$__Up->tp = 'up_col';
	
	/* Modificación de Registro
	
	if((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "EdUpCol")){ 
	
			
		for ($i = 0; $i <= UPCOL_CNT; $i++) { $__s[] = sprintf( "upcol_".$i."=%s ", GtSQLVlStr(ctjTx( $_POST['upcol_'.$i],'out'), 'text') ); }
		$__qry_all = implode(',', $__s);
		
		$updateSQL = sprintf("UPDATE ".MDL_UP_COL_BD." SET upcol_up=%s, upcol_row=%s, upcol_w=%s, ".$__qry_all.", upcol_est=%s  WHERE id_upcol=%s",
							GtSQLVlStr($_POST['upcol_up'], "int"),
						    GtSQLVlStr($_POST['upcol_row'], "int"),
							GtSQLVlStr(ctjTx($_POST['upcol_'],'out'), "text"),
						    GtSQLVlStr($_POST['upcol_est'], "int"),
							GtSQLVlStr($_POST['id_upcol'], "int"));
	 
		$Result = $__cnx->_prc($updateSQL); 
		if($Result){
			$rsp['e'] = 'ok';
			$rsp['m'] = 1;
			
		}else{
			$rsp['e'] = 'no';
			$rsp['m'] = 2;
			$rsp['w'] = $__cnx->c_p->error;
			_ErrSis(['p'=>$updateSQL, 'd'=>$__cnx->c_p->error]);
		} 
	
	}*/
	
	if((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "EdUpCol")){ 
	
		global $__cnx;
			
		for ($i = 0; $i <= UPCOL_CNT; $i++) { $__s[] = sprintf( "upcol_".$i."=%s ", GtSQLVlStr(ctjTx( $_POST['upcol_'.$i],'out'), 'text') ); }
		$__qry_all = implode(',', $__s);
		
		$updateSQL = "UPDATE "._BdStr(DBP).MDL_UP_COL_BD." SET 
					  upcol_up = ".GtSQLVlStr($_POST['upcol_up'], "int").", 
					  upcol_row = ".GtSQLVlStr($_POST['upcol_row'], "int").",
					  upcol_w = ".GtSQLVlStr(ctjTx($_POST['upcol_'],'out'), "text").", 
					  ".$__qry_all.", 
					  upcol_est = ".GtSQLVlStr($_POST['upcol_est'], "int")."  
					  WHERE id_upcol = ".GtSQLVlStr($_POST['id_upcol'], "int")."  ";

		
		$__Up->_InUp_Est([ 'id'=>$_POST['upcol_up'], 'e'=>_CId('ID_UPEST_LD') ]);
	
	
		$Result = $__cnx->_prc($updateSQL); 

		if($Result){
			$rsp['e'] = 'ok';
			$rsp['m'] = 1;
			//$rsp['a'] = Aud_Sis(Aud_Dsc(538, 'UP COL', $_POST['id_upcol']), $rsp['v']);
		}else{
			$rsp['e'] = 'no';
			$rsp['m'] = 2;
			$rsp['w'][] = $__qry_all;
			$rsp['w'][] = $__cnx->c_p->error;
			_ErrSis(['p'=>$updateSQL, 'd'=>$__cnx->c_p->error]);
		} 
		
		$__cnx->_clsr($Result);
	
	}

?>