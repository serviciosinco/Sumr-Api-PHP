<?php 
	    
	global $__cnx;
	
	$Vl['e'] = 'no';
																			   
	$query_DtRg = "	SELECT
						id_mdls, mdls_nm
					FROM
						"._BdStr(DBM).TB_MDL_S."
					INNER JOIN "._BdStr(DBM).TB_MDL_S_TP." ON id_mdlstp = mdls_tp
					INNER JOIN "._BdStr(DBM).TB_MDL_S_TP_CL." ON id_mdlstp = mdlstpcl_mdlstp
					WHERE 
						mdlstpcl_cl = ".$_cl;
	
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
									$row_DtRg['id_mdls'], 
									$row_DtRg['mdls_nm']
								];

			}while($row_DtRg = $DtRg->fetch_assoc());
		}
	}

	$__cnx->_clsr($DtRg);

	$rsp['ls'] = _jEnc($Vl); 
	
?>