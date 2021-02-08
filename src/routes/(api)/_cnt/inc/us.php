<?php 
	    
	global $__cnx;
	
	$Vl['e'] = 'no';
																			   
	$query_DtRg = "	SELECT
						id_us, us_nm, us_ap, us_est, us_age, us_user, usest_clr
					FROM
						".TB_US."
					INNER JOIN ".TB_US_CL." ON uscl_us = id_us
					INNER JOIN "._BdStr(DBM).TB_US_EST." ON us_est = id_usest
					WHERE 
						uscl_cl = ".$_cl." AND us_nivel != 'superadmin' ";
	
	$DtRg = $__cnx->_qry($query_DtRg);
			
	if($DtRg){
		
		$row_DtRg = $DtRg->fetch_assoc();
		$Tot_DtRg = $DtRg->num_rows;
		$Vl['tot'] = $Tot_DtRg;
		
		if($Tot_DtRg > 0){
			
			$Vl['e'] = 'ok';
			$Vl['ls']['l'][] =  [ 
								'ID', 
								'USUARIO', 
								'NOMBRE',
								'APELLIDO'
							];
			
			do{

				$Vl['ls']['l'][] =  [ 
									$row_DtRg['id_us'], 
									$row_DtRg['us_user'],
									$row_DtRg['us_nm'],
									$row_DtRg['us_ap']
								];

			}while($row_DtRg = $DtRg->fetch_assoc());
		}
	}

	$__cnx->_clsr($DtRg);

	$rsp['ls'] = _jEnc($Vl); 
	
?>