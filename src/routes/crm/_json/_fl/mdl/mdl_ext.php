<?php 

	$__mdls = Php_Ls_Cln($_POST['mdl']);
	$__tp = Php_Ls_Cln($_POST['tp']);

	if(!isN($__mdls)){

		$__mdls_a = explode(',', $__mdls);
		$__mdls_a = implode("','", $__mdls_a);

		if($__tp == 'evn'){
			//-------------------- Consulta Principal Leads --------------------//

			$_fl_attr = ",(
							SELECT mdlattr_vl FROM ".TB_MDL_ATTR."
								INNER JOIN "._BdStr(DBM).TB_SIS_SLC." ON mdlattr_attr = id_sisslc
							WHERE
								mdlattr_mdl = id_mdl
							AND sisslc_cns = 'vlr_unq'
						) AS precio";

			$Ls_Qry = "SELECT mdl_enc
							$_fl_attr
						FROM ".TB_MDL."
						WHERE mdl_enc IN ('{$__mdls_a}')";
						
			$Ls = $__cnx->_qry($Ls_Qry);

			if($Ls){
				
				$row_Ls = $Ls->fetch_assoc(); 
				$Tot_Ls = $Ls->num_rows;
				
				$rsp['total'] = $Tot_Ls;
				
				if($Tot_Ls>0){		
				
					$rsp['e'] = 'ok';	
					
					do {
						$ido = $row_Ls['mdl_enc'];
						$rsp['l'][$ido]['id'] = $row_Ls['mdl_enc'];
						$rsp['l'][$ido]['prc'] = cnVlrMon( '', $row_Ls["precio"] );
						
					} while ($row_Ls = $Ls->fetch_assoc());
				}			
			}else{				
				$rsp['w'] = $__cnx->c_r->error;				
			}
		}
		
		if($__tp == 'psg' || $__tp == 'prg' || $__tp == 'evn' ){

			//-------------------- Consulta de Areas --------------------//

				$Ls_Qry = "SELECT
								mdl_enc, clare_tt, clare_clr 
							FROM
								".TB_MDL." 
								INNER JOIN ".TB_MDL_ARE." ON mdlare_mdl = id_mdl
								INNER JOIN "._BdStr(DBM).TB_CL_ARE." ON mdlare_are = id_clare
							WHERE
								mdl_enc IN ('{$__mdls_a}')";
						
				$Ls = $__cnx->_qry($Ls_Qry);

				if($Ls){

					$row_Ls = $Ls->fetch_assoc(); 
					$Tot_Ls = $Ls->num_rows;

					$rsp['total'] = $Tot_Ls;

					if($Tot_Ls>0){		

						$rsp['e'] = 'ok';	
						
						do {
							$ido = $row_Ls['mdl_enc'];
							$rsp['l'][$ido]['id'] = $row_Ls['mdl_enc'];
							$rsp['l'][$ido]['are'][] = [
														'tt'=>$row_Ls["clare_tt"],
														'clr'=>$row_Ls["clare_clr"]
													 ];
							
							
						} while ($row_Ls = $Ls->fetch_assoc());
					}			
				}else{				
					$rsp['w'] = $__cnx->c_r->error;				
				}
		}

		if($__tp == 'psg' || $__tp == 'prg'){

			//-------------------- Consulta de Periodos --------------------//

				$Ls_Qry = "SELECT
								mdl_enc, mdlsprd_nm 
							FROM
								".TB_MDL." 
								INNER JOIN ".TB_MDL_PRD." ON mdlprd_mdl = id_mdl
								INNER JOIN "._BdStr(DBM).TB_MDL_S_PRD." ON mdlprd_prd = id_mdlsprd
							WHERE
								mdl_enc IN ('{$__mdls_a}') AND mdlprd_est = 1";
						
				$Ls = $__cnx->_qry($Ls_Qry);

				if($Ls){

					$row_Ls = $Ls->fetch_assoc(); 
					$Tot_Ls = $Ls->num_rows;

					$rsp['total'] = $Tot_Ls;

					if($Tot_Ls>0){		

						$rsp['e'] = 'ok';	
						
						do {
							$ido = $row_Ls['mdl_enc'];
							$rsp['l'][$ido]['id'] = $row_Ls['mdl_enc'];
							$rsp['l'][$ido]['prd'][] = $row_Ls["mdlsprd_nm"];
							
						} while ($row_Ls = $Ls->fetch_assoc());
					}			
				}else{				
					$rsp['w'] = $__cnx->c_r->error;				
				}
		}
			
		

		

	}else{					
		$rsp['w'] = 'No data';		
    }
    
?>