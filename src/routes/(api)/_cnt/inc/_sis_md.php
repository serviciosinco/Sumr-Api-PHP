<?php 
	    
	global $__cnx;
	
	$Vl['e'] = 'no';
																			   
	$query_DtRg = "	SELECT
						id_sismd, sismd_tt
					FROM
						"._BdStr(DBM).TB_SIS_MD."
					INNER JOIN "._BdStr(DBM).TB_SIS_MD_CL." ON id_sismd = sismdcl_sismd
					WHERE 
						sismdcl_cl = ".$_cl." ORDER BY sismd_tt ASC";
	
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
									$row_DtRg['id_sismd'], 
									$row_DtRg['sismd_tt']
								];

			}while($row_DtRg = $DtRg->fetch_assoc());
		}
	}

	$__cnx->_clsr($DtRg);

	$rsp['ls'] = _jEnc($Vl); 
	
?>