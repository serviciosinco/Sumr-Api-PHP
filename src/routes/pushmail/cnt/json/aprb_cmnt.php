<?php 

	
	$__usd = GtUsDt( Php_Ls_Cln($_POST['_us']), 'enc');
	$__ecd = GtEcDt( Php_Ls_Cln($_POST['_ec']), 'enc');

	
	if($__usd->id != NULL && $__ecd->id != NULL){
		
		$Ls_Qry = sprintf('SELECT * 
						   FROM '._BdStr(DBM).TB_EC_CMNT.' 
						   		 INNER JOIN '._BdStr(DBM).TB_US.' ON eccmnt_us = id_us 
						   WHERE eccmnt_ec = %s 
						   ORDER BY id_eccmnt DESC', GtSQLVlStr($__ecd->id, 'int'));
						   
		$Ls_Rg = $__cnx->_qry($Ls_Qry); 
		
		if($Ls_Rg){
			
			$row_Ls_Rg = $Ls_Rg->fetch_assoc(); 
			$Tot_Ls_Rg = $Ls_Rg->num_rows; 
			
			$rsp['tot'] = $Tot_Ls_Rg;
				
			if($Tot_Ls_Rg > 0){
			
				$rsp['e'] = 'ok';
				
		    	do { 
			    	
			    	$id = $row_Ls_Rg['id_eccmnt'];
			    	
			    	if(!isN($row_Ls_Rg['us_img'])){ 
				    	
				    	$img = _ImVrs([ 'img'=>$row_Ls_Rg['us_img'], 
				    					'f'=>DMN_FLE_US, 
				    					'img_ste'=>$row_Ls_Rg['us_enc'], 
				    					'img_ste_d'=>DMN_FLE_US
				    				]);
				    	
				    	$_img = $img->sm_s;
				    				
				    }else{
					    $_img = GtUsImg([ 'img'=>$row_Ls_Rg['us_img'], 'gnr'=>$row_Ls_Rg['us_gnr'] ]);
				    }
			    	
			    	/*
				    	$rsp['ls'][$id]['id'] = $row_Ls_Rg['id_eccmnt'];
						$rsp['ls'][$id]['tx'] = ctjTx($row_Ls_Rg['eccmnt_cmnt'],'in');
						$rsp['ls'][$id]['us']['nm'] = ctjTx($row_Ls_Rg['us_nm'],'in');
						$rsp['ls'][$id]['us']['img'] = $img;
			    	*/
			    	
			    	$date = new DateTime($row_Ls_Rg['eccmnt_f']);
	
			    	$li .= li('<div class="us" style="background-image:url('.$_img.');"></div>'. 
			    				'<div class="bx">'.
				    				Spn( FechaESP_OLD( $row_Ls_Rg['eccmnt_f'] ).' - '.$date->format('H:i a'), '', '_f').
				    				ctjTx( $row_Ls_Rg['us_nm'],'in').' dijo '. 
				    				'<div class="text">'.ctjTx( $row_Ls_Rg['eccmnt_cmnt'],'in' ).'</div>'.
			    				'</div>'
			    			);
			    	
		    	} while ($row_Ls_Rg = $Ls_Rg->fetch_assoc());
				
				
				$rsp['html'] = ul($li);
				
			}else{
				
				$rsp['e'] = 'no';
		
			}
		
		}
		
		$__cnx->_clsr($Ls_Rg);
		
	}
	


?>
