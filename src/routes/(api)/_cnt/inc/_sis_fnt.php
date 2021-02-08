<?php 
	    
	global $__cnx;
	
	$Vl['e'] = 'no';
																			   
	$query_DtRg = "	SELECT
						id_sisfnt, sisfnt_nm
					FROM
						".TB_SIS_FNT."
					INNER JOIN ".TB_SIS_FNT_CL." ON id_sisfnt = sisfntcl_sisfnt
					WHERE 
						sisfntcl_cl = ".$_cl." ORDER BY sisfnt_nm DESC";
	
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
							];
			
			do{
				
				$Vl['ls']['l'][] =  [ 
									$row_DtRg['id_sisfnt'], 
									$row_DtRg['sisfnt_nm']
								];

			}while($row_DtRg = $DtRg->fetch_assoc());
		}
	}

	$__cnx->_clsr($DtRg);

	$rsp['ls'] = _jEnc($Vl); 
	
?>