<?php 
	    
	global $__cnx;
	
	$Vl['e'] = 'no';
																			   
	$query_DtRg = "	SELECT 
						id_siscd, siscd_tt, siscddp_tt, sisps_tt
					FROM ".MDL_SIS_CD_BD."
						INNER JOIN ".TB_SIS_CD_DP." ON id_siscddp = siscd_dp
						INNER JOIN ".TB_SIS_PS." ON id_sisps = siscddp_ps
					ORDER BY id_siscd" ;
	
	$DtRg = $__cnx->_qry($query_DtRg);
			
	if($DtRg){
		
		$row_DtRg = $DtRg->fetch_assoc();
		$Tot_DtRg = $DtRg->num_rows;
		$Vl['tot'] = $Tot_DtRg;
		
		if($Tot_DtRg > 0){
			
			$Vl['e'] = 'ok';
			$Vl['ls']['l'][] =  [ 
								'ID', 
								'CIUDAD', 
								'DEPARTAMENTO', 
								'PAIS' 
							];
			
			do{

				$Vl['ls']['l'][] =  [ 
									$row_DtRg['id_siscd'], 
									$row_DtRg['siscd_tt'], 
									$row_DtRg['siscddp_tt'], 
									$row_DtRg['sisps_tt'] 
								];

			}while($row_DtRg = $DtRg->fetch_assoc());
		}
	}

	$__cnx->_clsr($DtRg);

	$rsp['ls'] = _jEnc($Vl); 
	
?>