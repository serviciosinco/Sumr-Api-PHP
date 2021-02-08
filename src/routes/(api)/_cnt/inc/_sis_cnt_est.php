<?php 
	    
	global $__cnx;
	
	$Vl['e'] = 'no';
																			   
	$query_DtRg = "	SELECT
						id_siscntest, siscntest_tt, siscntesttp_tt
					FROM
						".TB_SIS_CNT_EST."
					INNER JOIN ".TB_SIS_CNT_EST_TP." ON id_siscntesttp = siscntest_tp
					WHERE 
						siscntest_cl = ".$_cl;
	
	$DtRg = $__cnx->_qry($query_DtRg);
			
	if($DtRg){
		
		$row_DtRg = $DtRg->fetch_assoc();
		$Tot_DtRg = $DtRg->num_rows;
		$Vl['tot'] = $Tot_DtRg;
		
		if($Tot_DtRg > 0){
			
			$Vl['e'] = 'ok';
			$Vl['ls']['l'][] =  [ 
								'ID', 
								'NOMBRE', 
								'TIPO'
							];
			
			do{
				
				$Vl['ls']['l'][] =  [ 
									$row_DtRg['id_siscntest'], 
									$row_DtRg['siscntest_tt'], 
									$row_DtRg['siscntesttp_tt']
								];

			}while($row_DtRg = $DtRg->fetch_assoc());
		}
	}

	$__cnx->_clsr($DtRg);

	$rsp['ls'] = _jEnc($Vl); 
	
?>