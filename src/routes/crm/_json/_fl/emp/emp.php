<?php 
	$c_DtRg = "-1";if (isset($__i)){$c_DtRg = preg_replace('/\s+/','',$__i);}
	
	$query_DtRg = sprintf('SELECT * FROM '.MDL_EMP_BD.' WHERE emp_nit = %s', GtSQLVlStr($c_DtRg,'text'));
	$DtRg = $__cnx->_qry($query_DtRg);// echo $query_DtRg.$__cnx->c_r->error; 
	$row_DtRg = $DtRg->fetch_assoc(); 
	$Tot_DtRg = $DtRg->num_rows;	
	
	//$rsp['qry'] = $query_DtRg;
	
	if(filter_var($__i, FILTER_VALIDATE_EMAIL)){ $rsp['t_s'] = 'eml'; }
	
	if($Tot_DtRg > 0){	
		
		//$__dt_cnt = GtCntDt([ 'id'=>$row_DtRg['id_cnt'] ]);
		
		
		$rsp['e'] = 'ok';
		$rsp['id'] = $row_DtRg['id_emp'];
		$rsp['nit'] = ctjTx($row_DtRg['emp_nit'],'in');
		$rsp['rs'] = ctjTx($row_DtRg['emp_rs'],'in');
		
	}else{
		
		$rsp['e'] = 'no';
		
	}
	
	$Dt_Rg->free; 
?>