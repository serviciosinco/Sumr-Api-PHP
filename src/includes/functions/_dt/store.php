<?php 
    
    function GtStoreBrndLs($p=NULL){

		global $__cnx;
																	 
		$query_DtRg = "SELECT id_storebrnd, storebrnd_enc, storebrnd_nm, storebrnd_img
						FROM "._BdStr(DBS).TB_STORE_BRND."
                             INNER JOIN "._BdStr(DBS).TB_STORE." ON storebrnd_store = id_store 
                             INNER JOIN "._BdStr(DBM).TB_CL." ON store_cl = id_cl	 
						WHERE cl_enc = '".CL_ENC."'
						ORDER BY storebrnd_nm ASC";
						
		$DtRg = $__cnx->_qry($query_DtRg);
		
		if($DtRg){
			
			$row_DtRg = $DtRg->fetch_assoc();
			$Tot_DtRg = $DtRg->num_rows;
			
			$Vl['tot'] = $Tot_DtRg;
			
			if($Tot_DtRg > 0){
				do{	
					$Vl['ls'][$row_DtRg['storebrnd_enc']]['id'] = $row_DtRg['id_storebrnd']; 
					$Vl['ls'][$row_DtRg['storebrnd_enc']]['enc'] = $row_DtRg['storebrnd_enc'];	
                    $Vl['ls'][$row_DtRg['storebrnd_enc']]['nm'] = $row_DtRg['storebrnd_nm'];
                    $Vl['ls'][$row_DtRg['storebrnd_enc']]['img'] = $_img = _ImVrs(['img'=>$row_DtRg['storebrnd_img'], 'f'=>DMN_FLE_CL_STORE_BRND ]);	
				}while($row_DtRg = $DtRg->fetch_assoc());
			}
		
		}
		
		$__cnx->_clsr($DtRg);
		
		return(_jEnc($Vl));		
	}
	
	

	function GtStoreBrndDt($p=NULL){ //$Id, $tp=NULL, $p=NULL
		
		global $__cnx;
		
		$Vl['e'] = 'no';

		if(!isN($p['id'])){

			if($p['t'] == 'enc'){ $__fl = 'storebrnd_enc'; }
			else{ $__fl = 'id_storebrnd'; }
			
			$c_DtRg = "-1";if (isset($p['id'])){$c_DtRg = $p['id'];}
			
			$query_DtRg = sprintf('	SELECT id_storebrnd, storebrnd_enc
									FROM '._BdStr(DBS).TB_STORE_BRND.'
									WHERE '.$__fl.' = %s 
									LIMIT 1', GtSQLVlStr($c_DtRg,'text'));
			
			$DtRg = $__cnx->_qry($query_DtRg); 
			
			if($DtRg){
				
				$row_DtRg = $DtRg->fetch_assoc(); 
				$Tot_DtRg = $DtRg->num_rows;	
					
				if($Tot_DtRg > 0){	
					$Vl['e'] = 'ok';
					$Vl['id'] = $row_DtRg['id_storebrnd'];
					$Vl['enc'] = $row_DtRg['storebrnd_enc'];	
				}
	
			}else{
			
				$Vl['w'] = $__cnx->c_r->error;
				
			}
			
			$__cnx->_clsr($Ls);	

		}else{
			
			$Vl['w'] = 'No get ID';
			
		}
		
		return _jEnc($Vl);
		
	}


?>