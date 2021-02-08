<?php 

$_g_alw = $this->tallw([ 't'=>'key', 'id'=>'fll_cnt' ]);

if( $_g_alw->est == 'ok' ){

	if(class_exists('CRM_Cnx')){

		$___datprcs = [];

		$Ls_Qry = " SELECT id_fllcnt, fllcnt_eml FROM "._BdStr(DBM).TB_FLL_CNT." WHERE fllcnt_vrfd = 2 LIMIT 50";			
		$Ls_Rg = $__cnx->_qry($Ls_Qry); 
		
		if($Ls_Rg){
			
			$row_Ls_Rg = $Ls_Rg->fetch_assoc(); 
			$Tot_Ls_Rg = $Ls_Rg->num_rows;
			
			echo $this->h1('Vinculo FullContact EMAILS verified: '.$Tot_Ls_Rg);
			
			if($Tot_Ls_Rg > 0){
				
				do {
					$___datprcs[] = $row_Ls_Rg;		
				} while ($row_Ls_Rg = $Ls_Rg->fetch_assoc()); 
				
				echo $this->ul($___fllcnt_vrfd);
			}
		
		}else{
			
			echo $this->err($__cnx->c_r->error);
			
		}
		
		
		$__cnx->_clsr($Ls_Rg);


		if(!isN( $___datprcs ) && count($___datprcs) > 0){

			foreach($___datprcs as $___datprcs_k=>$___datprcs_v){

				$__id = $___datprcs_v['id_fllcnt'];
				$__eml = $___datprcs_v['fllcnt_eml'];	
				
				$fll = new API_FullContact();
				$fll->disposable = $__eml;
				$is_vldt = $fll->Get();
				$is_vldt_eml = $is_vldt->r->emails->{$__eml};
				
				if($is_vldt_eml->message == 'Valid email address'){
					
					$__Fll = new CRM_Fll();
					$__Rsl = $__Fll->_upd_cnt([
												'id'=>$__id,
												'vrfd'=>1,
												'vrfd_usr'=>$is_vldt_eml->username,
												'vrfd_dmn'=>$is_vldt_eml->domain,
												'vrfd_c_sntx'=>$is_vldt_eml->attributes->validSyntax,
												'vrfd_c_dlvr'=>$is_vldt_eml->attributes->deliverable,
												'vrfd_c_ctch'=>$is_vldt_eml->attributes->catchall,
											]);	
				}
				
				$___fllcnt_vrfd .= $this->li( $this->Strn($__eml).print_r($is_vldt, true) );

			}
		
		}

	}

}else{

	echo $this->nallw('Global FullContact - Get Leads Info - Off');

}

?>