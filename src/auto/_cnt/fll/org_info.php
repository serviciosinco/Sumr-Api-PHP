<?php 

$_g_alw = $this->tallw([ 't'=>'key', 'id'=>'fll_org' ]);

if( $_g_alw->est == 'ok' ){

	try {	

	//if(date("H") > 18 || $__t == 'call'){	
		$__Fll = new CRM_Fll();
		$__Fll->c_dmn = $row_Dt_Rg['emp_web'];
		$__Fll->sve();
		
		
		if(class_exists('CRM_Cnx')){
			
			$LsOrg_Qry = " SELECT *, 
								DATE_FORMAT(fllorg_chk_f, '%Y-%m-%d') AS __chk,
								DATE_FORMAT(NOW(), '%Y-%m-%d') AS __nw
						FROM "._BdStr(DBM).TB_FLL_ORG." 
						WHERE fllorg_est = 2 AND fllorg_vrfd = 1 AND 
							( DATE_FORMAT(fllorg_chk_f, '%Y-%m-%d') < DATE_FORMAT(NOW(), '%Y-%m-%d') ||
								(fllorg_chk_f IS NULL)
							)
						LIMIT 50";	
								
			$LsOrg_Rg = $__cnx->_qry($LsOrg_Qry); 
			
			if($Ls_Rg){
				
				$row_LsOrg_Rg = $LsOrg_Rg->fetch_assoc(); 
				$Tot_LsOrg_Rg = $LsOrg_Rg->num_rows;

				echo $this->h1('Vinculo FullContact EMPRESAS Get Info: '.$Tot_LsOrg_Rg);
				
				if($Tot_LsOrg_Rg > 0){
					
					do { 
						
						$__id = $row_LsOrg_Rg['id_fllorg'];
						$__dmn = $row_LsOrg_Rg['fllorg_web'];	
						
						$__Fll = new CRM_Fll();
						$__Fll->c_dmn = $__dmn;
						$__Sve = $__Fll->sve();
						
						$__Rsl = $__Fll->_upd_org(['t'=>'chk_f', 'id'=>$__id]);
						
						
						$___fllorg_info .= $this->li( $this->Strn($__dmn) );	
							
					} while ($row_Ls_Rg = $Ls_Rg->fetch_assoc()); 
					
					echo $this->ul($___fllorg_info);
				}
			
			}else{
				
				echo $this->err($__cnx->c_r->error);
				
			}
			
			
			
			
			$__cnx->_clsr($LsOrg_Rg);
		
			
		}

	//}else{
				
	//	echo $this->h2('Actualiza después de las 6PM');
		
	//}	

	} catch (Exception $e) {
		echo 'Excepción capturada: ',  $e->getMessage(), "\n";
	}
	
}else{

	echo $this->nallw('Global FullContact - Get Organization Info - Off');

}

?>