<?php 

	try{

		$_t = Php_Ls_Cln($_POST['t']);
		$_tp = Php_Ls_Cln($_POST['tp']);
		$_dt = Php_Ls_Cln($_POST['dt']);
		$_id_row = Php_Ls_Cln($_POST['d']['id']);

		$__Cls_Org = new CRM_Org(); 
		$__Cls_Org->tp_org = $_tp;

		if($_dt == 'ls'){
			$rsp['e'] = 'ok';
			$__Cls_Org->tp = Php_Ls_Cln($_POST['d']['_t2']);
			$__Cls_Org->i = Php_Ls_Cln($_POST['d']['_i']);
			$rsp['dash'] = $__Cls_Org->GtOrgDshRowLs();
		}else if($_dt == 'row_in'){
			$rsp['in'] = $__Cls_Org->GtOrgDshRowIn(); 
		}else if($_dt == 'col_in'){		
			$__Cls_Org->id_row = $_id_row;
			$rsp['in'] = $__Cls_Org->GtOrgDshColIn(); 
		}else if($_dt == 'row_del'){
			$__Cls_Org->id_row = $_id_row;
			$rsp['del'] = $__Cls_Org->GtOrgDshRowDel(); 
		}else if($_dt == 'col_del'){
			$_id_col = Php_Ls_Cln($_POST['d']['id']);
			$__Cls_Org->id_col = $_id_col;
			$rsp['del'] = $__Cls_Org->GtOrgDshColDel(); 
		}

	}catch(Exception $e){
		$rsp['e'] = 'no';
		$rsp['w'] = TX_NSPPCSR .$e->getMessage();
	}
	
?>