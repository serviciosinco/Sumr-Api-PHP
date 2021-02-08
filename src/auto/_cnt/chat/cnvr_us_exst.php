<?php 

try {
	
	
	//--------- GET AND POST DATA ---------//
		
		$_lmt = Php_Ls_Cln($_GET['lmt']);
	
	//--------- AUTO TIME CHECK - START ---------//

		$__Bco = new CRM_Bco();
		$_AUTOP_d = $this->RquDt([ 't'=>'cnvr_us_exst', 'm'=>1 ]); 
		
	//--------- AUTO TIME CHECK - END ---------//
	
	if($_AUTOP_d->e == 'ok' && $_AUTOP_d->hb == 'ok'){ 
	
		$this->Rqu([ 't'=>'cnvr_us_exst' ]);		
		
		if(class_exists('CRM_Cnx')){
			
			$Ls_Qry = " SELECT id_cnvrus, cnvrus_us
						FROM "._BdStr(DBC).TB_CHAT_CNVR_US."
						WHERE 	NOT EXISTS(
									SELECT *
									FROM "._BdStr(DBC).TB_MAIN_CNV_US."
										 INNER JOIN "._BdStr(DBC).TB_MAIN_CNV." ON maincnvus_maincnv = id_maincnv
									WHERE 	maincnvus_us = cnvrus_us AND 
											maincnv_tp = 'sumr' AND 
											maincnv_id = cnvrus_cnvr
								)
						ORDER BY id_cnvrus DESC
						LIMIT 50";
											
			$LCnvUsExs = $__cnx->_qry($Ls_Qry);
			
			if($LCnvUsExs){
				
				$row_LCnvUsExs = $LCnvUsExs->fetch_assoc(); 
				$Tot_LCnvUsExs = $LCnvUsExs->num_rows; 
				
				echo $this->h1('SUMR Conversations Not Inserted: '.$Tot_LCnvUsExs);
				
				if($Tot_LCnvUsExs > 0){					
					
					do {

						$updateSQL = "UPDATE "._BdStr(DBC).TB_CHAT_CNVR_US." SET cnvrus_fa=NOW() WHERE id_cnvrus='".GtSQLVlStr($row_LCnvUsExs->id_cnvrus, "int")."'"; 
						
						//echo $updateSQL.PHP_EOL;
						$Result = $__cnx->_prc($updateSQL);
						if(!$Result){ echo $this->scss($row_LCnvUsExs->id_cnvrus.' actualizado correctamente'); } 							
							
					} while ($row_LCnvUsExs = $LCnvUsExs->fetch_object()); 

				}
			
			}else{
				
				echo $this->err($__cnx->c_r->error);
				
			}
			
			$__cnx->_clsr($LCnvUsExs);
			
		}
		
		$this->Rqu([ 't'=>'cnvr_us_exst' ]);
	
	}else{
		
		echo $this->h1('SUMR Conversations Not Inserted After', 'Auto_Tme_Prg');
		
	}

} catch (Exception $e) {
    
    $this->Rqu([ 't'=>'cnvr_us_exst' ]);
    echo $e->getMessage();
    
}
	
?>