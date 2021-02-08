<?php 
	
	function GtSgnCLs($p=NULL){
		
																	 
		$query_DtRg = " SELECT * FROM ".MDL_SGN_COD_BD." WHERE sgncod_est = 1 ORDER BY id_sgncod DESC";
		$DtRg = $__cnx->_qry($query_DtRg);
		
				
		if($DtRg){
			
			$row_DtRg = $DtRg->fetch_assoc();
			$Tot_DtRg = $DtRg->num_rows;
			
			
			$Vl['tot'] = $Tot_DtRg;
			
			if($Tot_DtRg > 0){
				
				$Vl['ls'] = [];
				
				do{
					
					if(!isN($row_DtRg['id_sgncod']) && !isN($row_DtRg['id_sgncod'])){
						array_push($Vl['ls'], 
							[
								'id'=>$row_DtRg['id_sgncod'],
								'enc'=>$row_DtRg['sgncod_enc'],
								'nm'=>$row_DtRg['sgncod_tt'],
								'sgn'=>$row_DtRg['sgncod_sgn'],
								'est'=>$row_DtRg['sgncod_est'],
								
								'sgn_asg'=>GtSgnDt($row_DtRg['sgncod_sgn'], 'id'),
								'sgn_sgm'=>GtSgnSgmLs($row_DtRg['id_sgncod'], 'id')
								
							]
						);	
					}
					
				}while($row_DtRg = $DtRg->fetch_assoc());
			}
		
		}
		
		$__cnx->_clsr($DtRg);
		return(_jEnc($Vl));
	
	}
	
	function GtSgnLs($p=NULL){
		
		if($p['id']){ $flt = 'WHERE id_sgn = '.$p['id']; }
		if($p['enc']){ $flt = 'WHERE sgn_enc = "'.$p['enc'].'"'; }
		
		
																	 
		$query_DtRg = " SELECT * FROM sgn $flt WHERE sgn_est = '1' ORDER BY id_sgn DESC";
		
		
		$DtRg = $__cnx->_qry($query_DtRg);
		
				
		if($DtRg){
			
			$row_DtRg = $DtRg->fetch_assoc();
			$Tot_DtRg = $DtRg->num_rows;
			
			
			$Vl['tot'] = $Tot_DtRg;
			
			if($Tot_DtRg > 0){
				
				$Vl['ls'] = [];
				
				do{
					
					if(!isN($row_DtRg['id_sgn']) && !isN($row_DtRg['id_sgn'])){
						array_push($Vl['ls'], 
							[
								'id'=>$row_DtRg['id_sgn'],
								'enc'=>$row_DtRg['sgn_enc'],
								'nm'=>$row_DtRg['sgn_tt'],
								'cd'=>$row_DtRg['sgn_cd'],
								'dir'=>$row_DtRg['sgn_dir']
							]
						);	
					}
					
				}while($row_DtRg = $DtRg->fetch_assoc());
			}
		
		}
		
		$__cnx->_clsr($DtRg);
		return(_jEnc($Vl));
	
	}
	
	function GtSgnCDt($Id, $tp){
		
		if($tp == 'id'){ 
			$flt = 'id_sgncod';
		}elseif($tp == 'enc'){ 
			$flt = 'sgncod_enc';
		}
		
		if(($Id!='')){
			
			$c_DtRg = "-1";if (isset($Id)){$c_DtRg = $Id;}
			 
			$query_DtRg = sprintf('SELECT * FROM sgn_cod WHERE '.$flt.' = %s', GtSQLVlStr($c_DtRg,'int'));
			
			$DtRg = $__cnx->_qry($query_DtRg); 
			$row_DtRg = $DtRg->fetch_assoc(); 
			$Tot_DtRg = $DtRg->num_rows;	
				
				$Vl['id'] = $row_DtRg['id_sgncod'];
				$Vl['tt'] = ctjTx($row_DtRg['sgncod_tt'],'in');
				$Vl['enc'] = ctjTx($row_DtRg['sgncod_enc'],'in');
				$Vl['sgn'] = ctjTx($row_DtRg['sgncod_sgn'],'in');
		
		
		
		}

		$__cnx->_clsr($DtRg);
		return(_jEnc($Vl));
	}


	
	
	
?>