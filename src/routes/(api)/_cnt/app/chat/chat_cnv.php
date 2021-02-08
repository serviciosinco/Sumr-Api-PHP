<?php		

	$_chnl = _GetPost('chnl'); 
	
	if( $_chnl != "all" ){
		$__fl .= " AND maincnv_tp IN ({$_chnl}) ";
	}


	$Ls_UsCht_Qry  = sprintf("	SELECT id_maincnv, maincnvus_us, maincnv_id, maincnvus_maincnv, maincnv_lmsj, maincnv_ldte, maincnv_tp, maincnv_enc, us_enc, us_nm, us_ap, us_img, us_gnr, us_onl, maincnv_fi, maincnv_fa
								FROM "._BdStr(DBC).TB_MAIN_CNV_US."
									INNER JOIN "._BdStr(DBC).TB_MAIN_CNV." ON maincnvus_maincnv = id_maincnv
									INNER JOIN "._BdStr(DBM).TB_US." ON maincnvus_us = id_us 
								WHERE 	maincnvus_us = %s AND 
										maincnv_est != %s AND
										maincnvus_est = 1
										$__fl
								GROUP BY maincnvus_maincnv
								ORDER BY maincnv_fa ASC
							", 
							GtSQLVlStr($__dt_us->id, 'int'),
							GtSQLVlStr(_CId('ID_SCLCNVEST_RDY'), 'int')
					);

	$Ls_Cnv = $__cnx->_qry($Ls_UsCht_Qry);
	
	if($Ls_Cnv){
	 	
	 	$row_Ls_Cnv = $Ls_Cnv->fetch_assoc(); 
	 	$Tot_Ls_Cnv = $Ls_Cnv->num_rows;

	 	$rsp['tot'] = $Tot_Ls_Cnv;
	 	$rsp['e'] = 'ok';
	 	
	 	if($Tot_Ls_Cnv > 0){
		 	
		 	do {
				 
				$__ienc = $row_Ls_Cnv["maincnv_enc"];

				$_id = $row_Ls_Cnv['id_maincnv'];
				$__msg = json_decode( ctjTx($row_Ls_Cnv['maincnv_lmsj'], 'in') );
				$__diff = _Df_Dte($row_Ls_Cnv["maincnv_ldte"], SIS_F_TS); 

				if($__diff->d < 1){
					$_fgo = _HrHTML($row_Ls_Cnv["maincnv_ldte"]);
				}elseif($__diff->d == 1){
					$_fgo = 'Ayer';
				}elseif($__diff->d < 7){
					$_fgo = FechaESP_OLD($row_Ls_Cnv["maincnv_ldte"], 6);
				}else{
					$_fgo = _Dte_([ 'd'=>$row_Ls_Cnv["maincnv_ldte"] ])->f;
				}

				if( $row_Ls_Cnv['maincnv_tp'] == "whtsp" ){ //Conversaciones Whatsapp
					
					$_GtWhtspFromDt = GtWhtspFromDt([ "maincnv_id"=>$row_Ls_Cnv['maincnv_id'] ]);

					if(!isN($_GtWhtspFromDt->id)){

						$rsp['ls'][ $__ienc ] = [	
													'cnv'=>[
														'id'=>$_id,
														'tp'=>$row_Ls_Cnv['maincnv_tp'],
														'enc'=>$row_Ls_Cnv['maincnv_enc'],
														'fa'=>$row_Ls_Cnv['maincnv_fa']
													],
													'us'=>[
														'enc'=>$_GtWhtspFromDt->enc,
														'nm'=>$_GtWhtspFromDt->tt,
														'ap'=>"",
														'onl'=>"ok",
														'img'=>DMN_IMG_ESTR_SVG.'chat_whtsp_no.svg'
													],
													'msj_lst'=>[
														'tx'=>ctjTx($row_Ls_Cnv["maincnv_lmsj"], 'in'),
														'f'=>[
															'main'=>$row_Ls_Cnv['maincnv_ldte'],
															's1'=>$_fgo
														],
														'msj'=>ctjTx($row_Ls_Cnv["maincnv_lmsj"], 'in'),
														'tot'=>0
													],
													'tp'=>[
														'cls' => $row_Ls_Cnv['maincnv_tp']
													],
													'svin'=>false
													
												];
					
					}else{

						$rsp['ls'][ $__ienc ] = $_GtWhtspFromDt;

					}

				}else if( $row_Ls_Cnv['maincnv_tp'] == "sumr" ){ //Conversaciones SUMR

					$__dt_us_oth = GtMainCnvUsOthDt( [ "maincnvus_maincnv"=>$row_Ls_Cnv['maincnvus_maincnv'], "maincnvus_us"=>$row_Ls_Cnv['maincnvus_us'] ] );

					$dt_img = _ImVrs(['img'=>$__dt_us_oth->img, 'f'=>DMN_FLE_US]);
					
					if(!isN( $__dt_us_oth->img )){
						
						if( !isN($dt_img->bg_s) ){
							$__img_url = $dt_img->bg_s;
						}else{
							$__img_url = $dt_img->th_c_100p;
						}
						
					}else{
						$__img_url = GtUsImg([ 'img'=>$__dt_us_oth->img, 'gnr'=>$__dt_us_oth->gnr ]);
					}
					
					if($__dt_us_oth->lvl == 'superadmin'){ $__svin = true; }else{ $__svin = false; }

					$rsp['ls'][ $__ienc ] = [	
												'cnv'=>[
													'id'=>$_id,
													'enc'=>$row_Ls_Cnv['maincnv_enc'],
													'tp'=>$row_Ls_Cnv['maincnv_tp'], 
												],
												'us'=>[
													'enc'=>ctjTx($__dt_us_oth->enc, 'in'),
													'nm'=>ctjTx($__dt_us_oth->nm, 'in'),
													'ap'=>ctjTx($__dt_us_oth->ap, 'in'),
													'onl'=>mBln($__dt_us_oth->onl),
													'img'=>$__img_url
												],
												'msj_lst'=>[
													'tx'=>ctjTx($row_Ls_Cnv["maincnv_lmsj"], 'in'),
													'f'=>[
														'main'=>$row_DtRg['maincnv_ldte'],
														's1'=>$_fgo
													],
													'msj'=>ctjTx($row_Ls_Cnv["maincnv_lmsj"], 'in'),
													'count'=>0
												],
												'tp'=>[
													'cls' => $row_Ls_Cnv['maincnv_tp']
												],
												'svin'=>$__svin
												
											];
				
				}

			} while ($row_Ls_Cnv = $Ls_Cnv->fetch_assoc());
			
		}

	}else{
		
		$rsp['w'] = $__cnx->c_r->error;
		
	}
	
	$__cnx->_clsr($Ls_Cnv); 
	
	
	
?>