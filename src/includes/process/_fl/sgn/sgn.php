<?php 
	
// Ingreso de Registro
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "EdSgn")) { 
		
		$__sng = new API_CRM_sgn();
		 			
				
		 							
		$__sng->sgn_tt = $_POST['sgn_tt'];
		$__sng->sgn_est = $_POST['sgn_est'];		
		$__sng->sgn_cd = $_POST['sgn_cd'];
		$__sng->sgn_dir = $_POST['sgn_dir'];
		
			
		
		
		
		$Result = $__sng->_SgnSve();
		
		if($Result->e == 'ok'){
	 		$rsp['i'] = $Result->i;
			$rsp['e'] = 'ok';
			$rsp['m'] = 1;
		}else{
			$rsp['e'] = 'no';
			$rsp['m'] = 2;
			$rsp['w'] = $Result->w;
		}
		
}

// Modificación de Registro
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "EdSgn")) { 
				
				$__sng = new API_CRM_sgn();
			
				$__sng->id_sgn =  $_POST['id_sgn'];
				$__sng->sgn_tt = $_POST['sgn_tt'];
				$__sng->sgn_tt = $_POST['sgn_tt'];
				$__sng->sgn_est = $_POST['sgn_est'];		
				$__sng->sgn_cd = $_POST['sgn_cd'];
				$__sng->dir = $_POST['sgn_dir'];
				
				$Result = $__sng->_SgnUpd();
				
	if($Result){
		$rsp['w'] = $__cnx->c_p->error;
		$rsp['i'] = $_POST['id_sgn'];
		$rsp['e'] = 'ok';
		$rsp['m'] = 1;
		//$rsp['qry'] = $updateSQL;
		
		//$rsp['a'] = Aud_Sis(Aud_Dsc(50, $_POST['ec_tt'], $_POST['id_ec']), $rsp['v']);
		
	}else{
		$rsp['e'] = 'no';
		$rsp['m'] = 2;
		_ErrSis(['p'=>$updateSQL, 'd'=>$__cnx->c_p->error]);
	}
}

// Elimino el Registro
if ((isset($_POST['id_sgn'])) && ($_POST['id_sgn'] != '') && ((isset($_POST['MM_delete']))&&($_POST['MM_delete'] == 'EdSgn'))) { 
	$deleteSQL = sprintf('DELETE FROM sgn WHERE id_sgn=%s', GtSQLVlStr($_POST['id_sgn'], 'int'));
	
	$Result = $__cnx->_prc($deleteSQL); 
	if($Result){
		$rsp['e'] = 'ok'; 
		$rsp['m'] = 1; 
		//$rsp['a'] = Aud_Sis(Aud_Dsc(51, $_POST['sgn_tt'], $_POST['id_sgn']), $rsp['v']); 
	}else{ 
		$rsp['e'] = 'no'; 
		$rsp['m'] = 2;
		$rsp['cm'] = $deleteSQL;  
		//_ErrSis(['p'=>$deleteSQL, 'd'=>$__cnx->c_p->error]);
	}
}
?>