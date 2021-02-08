<?php 
		global $__cnx;
	
		$__t = Php_Ls_Cln($_GET['_t']);
		$__idc = Php_Ls_Cln($_GET['_idc']);
		$__status = Php_Ls_Cln($_POST['VerificationStatus']);
		
		
		
		if($__t == 'PhnAdd' && $__status == 'success'){
			
			$__Call = new CRM_Call();
			$PrcDt = $__Call->Upd_PhnAdd(['id'=>$__idc, 'est'=>'o' ]);
				
				
			$insertSQL = sprintf("INSERT INTO _____RSP (fllrsp_post, fllrsp_server) VALUES (%s,%s)",
						   GtSQLVlStr( print_r($PrcDt, true).json_encode($_GET).'<- CID'.json_encode($_POST)  , "text"),
						   GtSQLVlStr( json_encode($_SERVER), "text"));

			$Result = $__cnx->_prc($insertSQL);
			
	 		if($Result && $PrcDt->e == 'ok'){
				$rsp['e'] = 'ok';
				$rsp['m'] = 1; 
			}
			
			$__cnx->_clsr($Result);
			
		}
	
									
?>