<?php 
	
	$rsp['e'] = 'no';
	
	if($__dt_cl->bd){
		
		$__mdlstp = Php_Ls_Cln($_GET['mdlstp']);
			
		$Ls_Qry = "	SELECT *
					FROM "._BdStr($__dt_cl->bd).TB_MDL_GEN."
						 INNER JOIN "._BdStr(DBM).TB_MDL_S_TP." ON mdlgen_tp = id_mdlstp
					WHERE id_mdlgen != '' AND mdlstp_enc = '".$__mdlstp."'
					ORDER BY mdlgen_tt ASC ";
		
		$Ls = $__cnx->_qry($Ls_Qry);
	
		if($Ls){
			
			$row_Ls = $Ls->fetch_assoc(); 
			$Tot_Ls = $Ls->num_rows; 
			
			$rsp['tot'] = $Tot_Ls;
			
			if($Tot_Ls > 0){	
				
				$rsp['e'] = 'ok';
				
				do {
					
					$ido = $row_Ls['mdlgen_enc'];
					
					$rsp['ls'][$ido]['id'] = $row_Ls['id_mdlgen'];
					$rsp['ls'][$ido]['enc'] = $ido;
					$rsp['ls'][$ido]['tt'] = ctjTx($row_Ls['mdlgen_tt'],'in');
					
				} while ($row_Ls = $Ls->fetch_assoc());
				
			}
		
		}
	
	}

?>