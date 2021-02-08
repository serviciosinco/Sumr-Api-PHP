<?php  

class CRM_Emp {
		
	function __construct($p=NULL) { }

	
	// Empresas 
	public function ChckEmp($p=NULL){
		
		if(($p['nit'] != NULL)){
			
			$query_DtRg = sprintf('SELECT * FROM '.MDL_EMP_BD.' WHERE emp_nit = %s LIMIT 1', GtSQLVlStr($p['nit'], 'int')); 
			$DtRg = $__cnx->_qry($query_DtRg); 
			$row_DtRg = $DtRg->fetch_assoc(); 
			$Tot_DtRg = $DtRg->num_rows;	
			
			if($Tot_DtRg == 1){
				$Vl['r'] = 'ok';
				$Vl['id'] = $row_DtRg['id_emp'];
			}else{
				$Vl['r'] = 'no';
				$Vl['w'] = $__cnx->c_r->error;
			}
			$__cnx->_clsr($DtRg);	
			
		}else{
			$Vl['r'] = 'no';
		}
		
		$rtrn = json_decode(json_encode($Vl));
		return($rtrn);
	}

	public function EmpIn($p=NULL){
		
		global $__cnx;
			
		if(count($p) > 0){
				
			if($p['fi'] != NULL){ $_fi = $p['fi']; }else{ $_fi = SIS_F; }
			if($p['m'] != NULL){ $_m = $p['m']; }else{ $_m = 1; }
																			
			$insertSQL = sprintf("INSERT INTO ".MDL_EMP_BD." (emp_nit, emp_rs, emp_dir, emp_cd, emp_cls, emp_est, emp_sec) VALUES (%s, %s, %s, %s, %s, %s, %s)",
					   GtSQLVlStr($p['nit'], "int"),
					   GtSQLVlStr($p['rs'], "text"),
					   GtSQLVlStr($p['dir'], "text"),
					   GtSQLVlStr($p['cd'], "int"),
					   GtSQLVlStr($p['cls'], "int"),
					   GtSQLVlStr($p['est'], "int"),
					   GtSQLVlStr($p['sec'], "int"));
					   
			$Result = $__cnx->_prc($insertSQL);
			$this->w_all .= $__cnx->c_p->error;
				
		}
		
		if($Result){
			$_r['e'] = 'ok';
			$_r['id'] = $__cnx->c_p->insert_id;
		}else{
			$_r['e'] = 'no';
			$_r['s'] = $__cnx->c_p->error;
			$this->w_all .= $__cnx->c_p->error;
		}
		
		$rtrn = _jEnc($_r); 
		if(!isN($rtrn)){ return($rtrn); }	
	}

	public function ChckAlzInEmp($p=NULL){
		
		global $__cnx;
		
		if(($p['emp'] != NULL)){
			
			$query_DtRg = sprintf('SELECT * FROM '.MDL_ALZ_IN_EMP_BD.' WHERE alzinemp_emp = %s AND alzinemp_emp = %s', GtSQLVlStr($p['emp'], 'int'), GtSQLVlStr($p['alzin'], 'int')); 
			$DtRg = $__cnx->_prc($query_DtRg); 
			$row_DtRg = $DtRg->fetch_assoc(); 
			$Tot_DtRg = $DtRg->num_rows;	
			
			if($Tot_DtRg == 1){
				$Vl['r'] = 'ok';
				$Vl['id'] = $row_DtRg['id_alzinemp'];
			}else{
				$Vl['r'] = 'no';
				$Vl['w'] = $__cnx->c_p->error;
			}	
			$__cnx->_clsr($DtRg);
		}else{
			$Vl['r'] = 'no';
		}
		
		$rtrn = _jEnc($Vl); 
		if(!isN($rtrn)){ return($rtrn); }
	}
	

	public function AlzInEmpIn($p=NULL){
		
		global $__cnx;
			
		if(count($p) > 0){
				
			if($p['fi'] != NULL){ $_fi = $p['fi']; }else{ $_fi = SIS_F; }
			if($p['m'] != NULL){ $_m = $p['m']; }else{ $_m = 1; }
																			
			$insertSQL = sprintf("INSERT INTO ".MDL_ALZ_IN_EMP_BD." (alzinemp_emp,  alzinemp_us, alzinemp_alzin) VALUES (%s, %s, %s)",
					   GtSQLVlStr($p['emp'], "int"),
					   GtSQLVlStr($p['us'], "int"),
					   GtSQLVlStr($p['alzin'], "int"));

			$Result = $__cnx->_prc($insertSQL);
			$this->w_all .= $__cnx->c_p->error;
				
		}
		
		if($Result){
			$_r['e'] = 'ok';
			$_r['id'] = $__cnx->c_p->insert_id;
		}else{
			$_r['e'] = 'no';
			$_r['s'] = $__cnx->c_p->error;
			$this->w_all .= $__cnx->c_p->error;
		}
		
		$rtrn = _jEnc($_r); 
		if(!isN($rtrn)){ return($rtrn); }	
		
	}

}

	
?>