 <?php
	
	try{
		
		$Ls_UsOnl_Qry  = " 	SELECT id_us, us_nm, us_ap, us_enc, us_crg, us_gnr, us_img, us_onl, us_nivel
						  	FROM "._BdStr(DBM).TB_US." 
								 INNER JOIN "._BdStr(DBM).TB_US_CL." ON uscl_us = id_us 
								 INNER JOIN "._BdStr(DBM).TB_CL." ON uscl_cl = id_cl
							WHERE 	id_us != '' AND 
									us_est = 1 AND
									cl_enc = ".GtSQLVlStr(DB_CL_ENC, 'text')." AND 
									id_us != '".SISUS_ID."'	
						  ORDER BY us_onl ASC, us_nm ASC, us_ap ASC ";
		
		$Ls_UsOnl = $__cnx->_qry($Ls_UsOnl_Qry);
		
		if($Ls_UsOnl){
		 	
		 	$row_Ls_UsOnl = $Ls_UsOnl->fetch_assoc(); 
		 	$Tot_Ls_UsOnl = $Ls_UsOnl->num_rows;
	
		 	$rsp['tot'] = $Tot_Ls_UsOnl;
	 	
		 	if($Tot_Ls_UsOnl > 0){
			 	
			 	$rsp['e'] = 'ok';
			 	
			 	do {					
					
					$_id = $row_Ls_UsOnl['us_enc'];
					//$rsp['ls'][ 'UsOnl_'.$_id ]['id'] = $_id;
					$rsp['ls'][ 'UsOnl_'.$_id ]['enc'] = $row_Ls_UsOnl['us_enc'];
					$rsp['ls'][ 'UsOnl_'.$_id ]['nm'] = ctjTx($row_Ls_UsOnl['us_nm'], 'in');
					$rsp['ls'][ 'UsOnl_'.$_id ]['ap'] = ctjTx($row_Ls_UsOnl['us_ap'], 'in');
					$rsp['ls'][ 'UsOnl_'.$_id ]['crg'] = ctjTx($row_Ls_UsOnl['us_crg'] ,'in');
					$rsp['ls'][ 'UsOnl_'.$_id ]['onl'] = mBln($row_Ls_UsOnl['us_onl']);	
									
					$dt_img = _ImVrs(['img'=>$row_Ls_UsOnl['us_img'], 'f'=>DMN_FLE_US]);
					
					if(!isN( $row_Ls_UsOnl['us_img'] )){
						
						if( !isN($dt_img->bg_s) ){
							$__img_url = $dt_img->bg_s;
						}else{
							$__img_url = $dt_img->th_c_100p;
						}
						
					}else{
						
						$__img_url = GtUsImg([ 'img'=>$row_Ls_UsOnl['us_img'], 'gnr'=>$row_Ls_UsOnl['us_gnr'] ]);
						
					}
					
					$rsp['ls'][ 'UsOnl_'.$_id ]['img'] = $__img_url;
					
					
					if($row_Ls_UsOnl['us_nivel'] == 'superadmin'){ 
						$rsp['ls'][ 'UsOnl_'.$_id ]['svin'] = true; 
					}else{ 
						$rsp['ls'][ 'UsOnl_'.$_id ]['svin'] = false; 
					}
					
				} while ($row_Ls_UsOnl = $Ls_UsOnl->fetch_assoc());
				
			}
	
		}else{
			
			$rsp['w'] = $__cnx->c_r->error;
			
		}
		
		$__cnx->_clsr($Ls_UsOnl); 

	
	}catch(Exception $e){
		$rsp['e'] = 'no';
		$rsp['w'] = TX_NSPPCSR .$e->getMessage();
	}
	
?>