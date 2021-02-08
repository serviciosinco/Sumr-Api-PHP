<?php 

$_g_alw = $this->tallw([ 't'=>'key', 'id'=>'fll_cnt_eml' ]);

if( $_g_alw->est == 'ok' ){
		
	//if(date("H") > 18 || $__t == 'call'){	

		if(class_exists('CRM_Cnx')){
			
			$___datprcs = [];

			$LsM_Qry = " SELECT id_fllcnt, fllcnt_eml,
								DATE_FORMAT(fllcnt_chk_f, '%Y-%m-%d') AS __chk,
								DATE_FORMAT(NOW(), '%Y-%m-%d') AS __nw
						FROM "._BdStr(DBM).TB_FLL_CNT." 
						WHERE fllcnt_est = 2 AND fllcnt_vrfd = 1 AND 
							( DATE_FORMAT(fllcnt_chk_f, '%Y-%m-%d') < DATE_FORMAT(NOW(), '%Y-%m-%d') ||
								(fllcnt_chk_f IS NULL)
							)
						LIMIT 10";		
							
			$LsM_Rg = $__cnx->_qry($LsM_Qry); 
			
			if($Ls_Rg){
				
				$row_LsM_Rg = $LsM_Rg->fetch_assoc();
				$Tot_LsM_Rg = $LsM_Rg->num_rows;
				
				echo $this->h1('Vinculo FullContact EMAILS Get Info: '.$Tot_LsM_Rg);
				
				if($Tot_LsM_Rg > 0){
					do { 
						$___datprcs[] = $row_LsM_Rg;
					} while ($row_LsM_Rg = $Ls_Rg->fetch_assoc()); 	
				}
				
			}else{
				
				echo $this->err($__cnx->c_r->error);
				
			}
			
			$__cnx->_clsr($LsM_Rg);

			if(!isN( $___datprcs ) && count($___datprcs) > 0){

				foreach($___datprcs as $___datprcs_k=>$___datprcs_v){

					$__id = $___datprcs_v['id_fllcnt'];
					$__eml = $___datprcs_v['fllcnt_eml'];	
					
					$__Fll = new CRM_Fll();
					$__Fll->c_eml = $__eml;
					$__Sve = $__Fll->sve();
					
					$__Rsl = $__Fll->_upd_cnt(['t'=>'chk_f', 'id'=>$__id]);
					
					$___fllcnt_info .= $this->li( $this->Strn($__eml).print_r($__Rsl, true) );	

				}

				echo $this->ul($___fllcnt_info);
				
			}

		}

	//}else{
				
	//	echo $this->h2('Actualiza después de las 6PM');
		
	//}	

}else{

	echo $this->nallw('Global FullContact - Leads Email Attach - Off');

}

?>