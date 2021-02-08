<?php 
	    
	global $__cnx;
	
	$Vl['e'] = 'no';
																			   
	$query_DtRg = "	SELECT
						id_mdl, mdl_nm, mdlstp_nm
					FROM
						".$_ClDt->bd.".".TB_MDL."
					INNER JOIN "._BdStr(DBM).TB_MDL_S." ON id_mdls = mdl_mdls
					INNER JOIN "._BdStr(DBM).TB_MDL_S_TP." ON id_mdlstp = mdls_tp
					INNER JOIN "._BdStr(DBM).TB_MDL_S_TP_CL." ON id_mdlstp = mdlstpcl_mdlstp
					WHERE 
						mdlstpcl_cl = ".$_cl." AND mdl_est = "._CId('ID_SISMDLEST_ACTV');
	
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
									$row_DtRg['id_mdl'], 
									$row_DtRg['mdl_nm'],
									$row_DtRg['mdlstp_nm']
								];

			}while($row_DtRg = $DtRg->fetch_assoc());
		}
	}

	$__cnx->_clsr($DtRg);

	$rsp['ls'] = _jEnc($Vl); 
	
?>