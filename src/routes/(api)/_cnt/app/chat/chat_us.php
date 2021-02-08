<?php
		
	$_Qry_Msj_Lst = " ,(SELECT cnvrmsj_msj FROM "._BdStr(DBC).TB_CHAT_CNVR." 
					  INNER JOIN "._BdStr(DBC).TB_CHAT_CNVR_MSJ." ON cnvrmsj_cnvr = id_cnvr
					  WHERE id_cnvr IN( 
					  					SELECT cnvrus_cnvr FROM "._BdStr(DBC).TB_CHAT_CNVR_US."
					  					INNER JOIN "._BdStr(DBM).TB_US." ON id_us = cnvrus_us
					  					WHERE us_enc = '".$_cl_us."' 
					  				 )
					  AND id_cnvr IN( 
					  					SELECT cnvrus_cnvr FROM "._BdStr(DBC).TB_CHAT_CNVR_US."
					  					WHERE cnvrus_us = id_us
					  				)
					  ORDER BY cnvrmsj_fi DESC LIMIT 1) AS _qry_msj_lst ";
	
	$Ls_UsOnl_Qry  = " SELECT id_us, us_nm, us_enc, us_ap, us_crg, us_img, us_onl, us_nivel, us_gnr $_Qry_Msj_Lst
					  FROM "._BdStr(DBM).TB_US." 
						INNER JOIN "._BdStr(DBM).TB_US_CL." ON uscl_us = id_us 
						INNER JOIN "._BdStr(DBM).TB_CL." ON uscl_cl = id_cl
					  WHERE id_us != ''
						  	AND us_est = 1
							AND us_enc != ".GtSQLVlStr($_cl_us, 'text')."
							AND cl_enc = ".GtSQLVlStr($_cl_enc, 'text')."
							AND id_us != '".$__dt_us->id."'
							AND id_us NOT IN (
									SELECT cnvrus_us 
									FROM "._BdStr(DBC).TB_CHAT_CNVR."
										 INNER JOIN "._BdStr(DBC).TB_CHAT_CNVR_US." ON cnvrus_cnvr = id_cnvr
									WHERE cnvrus_us=".GtSQLVlStr($__dt_us->id, 'text')."
								)
								
								
					  ORDER BY us_nm ASC, us_ap ASC ";

	$Ls_UsOnl = $__cnx->_qry($Ls_UsOnl_Qry);
	
	if($Ls_UsOnl){
	 	
	 	$row_Ls_UsOnl = $Ls_UsOnl->fetch_assoc(); 
	 	$Tot_Ls_UsOnl = $Ls_UsOnl->num_rows;

	 	$rsp['online']['tot'] = $Tot_Ls_UsOnl;
 	
	 	if($Tot_Ls_UsOnl > 0){
		 	
		 	$rsp['e'] = 'ok';
		 	
		 	do {
			 	
				$_id = $row_Ls_UsOnl['id_us'];
				$rsp['online']['list'][ 'UsOnl_'.$_id ]['id'] = $_id;
				$rsp['online']['list'][ 'UsOnl_'.$_id ]['enc'] = $row_Ls_UsOnl['us_enc'];
				$rsp['online']['list'][ 'UsOnl_'.$_id ]['nm'] = ctjTx($row_Ls_UsOnl['us_nm'], 'in');
				$rsp['online']['list'][ 'UsOnl_'.$_id ]['ap'] = ctjTx($row_Ls_UsOnl['us_ap'], 'in');
				$rsp['online']['list'][ 'UsOnl_'.$_id ]['crg'] = ($row_Ls_UsOnl['us_iro']==1)?Spn('','','','color:#800303;'):ctjTx($row_Ls_UsOnl['us_crg'] ,'in');
				$rsp['online']['list'][ 'UsOnl_'.$_id ]['onl'] = mBln($row_Ls_UsOnl['us_onl']);
				$rsp['online']['list'][ 'UsOnl_'.$_id ]['msj_lst'] = ctjTx($row_Ls_UsOnl['_qry_msj_lst'], 'in');
				
				$dt_img = _ImVrs(['img'=>$row_Ls_UsOnl['us_img'], 'f'=>DMN_FLE_US]);
				
				if(!isN( $row_Ls_UsOnl['us_img'] )){
					
					if( !isN($dt_img->bg_s) ){
						$__img_url = $dt_img->bg_s;
					}else{
						$__img_url = $dt_img->th_c_100p;
					}
					
					$rsp['online']['list'][ 'UsOnl_'.$_id ]['rrr'] = "if";
					
				}else{
					$__img_url = GtUsImg([ 'img'=>$row_Ls_UsOnl['us_img'], 'gnr'=>$row_Ls_UsOnl['us_gnr'] ]);
				}
				
				$rsp['online']['list'][ 'UsOnl_'.$_id ]['img'] = $__img_url;
				
				
				if($row_Ls_UsOnl['us_nivel'] == 'superadmin'){ $rsp['online']['list'][ 'UsOnl_'.$_id ]['svin'] = true; }else{ $rsp['online']['list'][ 'UsOnl_'.$_id ]['svin'] = false; }
				
			} while ($row_Ls_UsOnl = $Ls_UsOnl->fetch_assoc());
			
		}

	}else{
		
		$rsp['w'] = $__cnx->c_r->error;
		
	}
	
	$__cnx->_clsr($Ls_UsOnl); 
	
	
	
?>