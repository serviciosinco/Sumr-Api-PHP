<?php
	
	if(!isN($_cnv_enc)){ $__chat->MainCnvMsgRd(); }
	
	if( !isN( $__chat->_main_cnv->d->id ) ){
		
		if($__chat->_main_cnv->tp == 'sumr'){
			
			$Ls_Qry = "	SELECT 	cnvr_enc,
								cnvrmsj_enc,
								cnvrmsj_msj,
								cnvrmsj_fi,
								us_enc AS __enc,
								CONCAT(us_nm,' ',us_ap) AS __nm
						FROM "._BdStr(DBC).TB_CHAT_CNVR." 
							INNER JOIN "._BdStr(DBC).TB_CHAT_CNVR_MSJ." ON cnvrmsj_cnvr = id_cnvr
							INNER JOIN "._BdStr(DBM).TB_US." ON cnvrmsj_us = id_us
						WHERE cnvrmsj_cnvr='".$__chat->_main_cnv->d->id."'
						ORDER BY cnvrmsj_fi DESC 
						LIMIT 500";
			
			$__cnv_enc = 'cnv_enc';			
			$__msj_enc = 'cnvrmsj_enc';
			$__msj_snt = 'cnvrmsj_est';
			$__msj_txt = 'cnvrmsj_msj';
			$__msj_dte = 'cnvrmsj_fi';
			$__msj_fid = '__enc';

		}else{
			
			$Ls_Qry = "	SELECT 
								wthsp_no,
								wthspcnv_enc,	
								wthspcnvmsg_enc,
								wthspcnvmsg_message,
								wthspcnvmsg_created,
								wthspcnvmsg_snt,
								
								_cnvf.wthspfrom_id AS cnvf_wthspfrom_id,
								_cnvf.wthspfrom_nm AS cnvf_wthspfrom_nm,
								_msgf.wthspfrom_id AS msgf_wthspfrom_id,

								us_enc AS __enc,
								CONCAT(us_nm,' ',us_ap) AS __nm

						FROM "._BdStr(DBT).TB_WHTSP_CNV." 
							INNER JOIN "._BdStr(DBT).TB_WHTSP." ON wthspcnv_whtsp = id_wthsp
							INNER JOIN "._BdStr(DBT).TB_WHTSP_CNV_MSG." ON wthspcnvmsg_wthspcnv = id_wthspcnv
							INNER JOIN "._BdStr(DBM).TB_US." ON wthspcnvmsg_us = id_us
							INNER JOIN "._BdStr(DBT).TB_WHTSP_FROM." _cnvf ON wthspcnv_from = _cnvf.id_wthspfrom
							INNER JOIN "._BdStr(DBT).TB_WHTSP_FROM." _msgf ON wthspcnvmsg_from = _msgf.id_wthspfrom

						WHERE wthspcnvmsg_wthspcnv='".$__chat->_main_cnv->d->id."'
						ORDER BY wthspcnvmsg_created ASC, wthspcnvmsg_fi ASC
						LIMIT 500";
			
			$__cnv_enc = 'wthspcnv_enc';			
			$__msj_enc = 'wthspcnvmsg_enc';
			$__msj_snt = 'wthspcnvmsg_snt';
			$__msj_txt = 'wthspcnvmsg_message';
			$__msj_dte = 'wthspcnvmsg_created';
			$__msj_fid = 'msgf_wthspfrom_id';

		} 
					
		if(!isN($Ls_Qry)){

			$Ls_Rg = $__cnx->_qry($Ls_Qry); 
			
			if($Ls_Rg){
				
				$row_Ls_Rg = $Ls_Rg->fetch_assoc(); 
				$Tot_Ls_Rg = $Ls_Rg->num_rows;
				
				$rsp['tot'] = $Tot_Ls_Rg;

				if($Tot_Ls_Rg > 0){
					
					$rsp['e'] = 'ok';
					$rsp['tp'] = $__p3_o;
					$_i = 0;

					do{
						
						if($__chat->_main_cnv->tp == 'whtsp' && $row_Ls_Rg['msgf_wthspfrom_id'] == $row_Ls_Rg['wthsp_no']){  
							$_me = 'ok';	
						}elseif( $__chat->_main_cnv->tp == 'sumr' && $row_Ls_Rg['__enc'] == $__us_dt->enc){
							$_me = 'ok';
						}else{
							$_me = 'no';
						}
						
						$rsp['ls']['msj'][ $row_Ls_Rg[ $__msj_enc ] ] = [
																			'enc'=>$row_Ls_Rg[$__msj_enc],
																			'me'=>$_me,
																			'snt'=>mBln($row_Ls_Rg[$__msj_snt]),
																			'tx'=>ctjTx($row_Ls_Rg[$__msj_txt], 'in'),
																			'f'=>[
																				'main'=>$row_Ls_Rg[$__msj_dte],
																				's1'=>date('H:i a', strtotime( $row_Ls_Rg[$__msj_dte] ))
																			],
																			'us'=>[
																				'enc'=>ctjTx($row_Ls_Rg['__enc'], 'in'),
																				'nm'=>ctjTx($row_Ls_Rg['cnvf_wthspfrom_nm'], 'in')
																			]
																		];

						$rsp['ls']['cnvr']['enc'] = ctjTx($row_Ls_Rg[ $__cnv_enc ], 'in');
						$rsp['ls']['tp'] = $__chat->_main_cnv->tp;

						if(!isN( $row_Ls_Rg[ $__msj_fid ] )){
							$__nxt_bfr = $row_Ls_Rg[ $__msj_fid ];
						}

						$_i++;

					} while ($row_Ls_Rg = $Ls_Rg->fetch_assoc());
				}

			}else{

				$rsp['w'] = $__cnx->c_r->error;
	
			}

		}else{

			$rsp['w'] = 'No query';

		}
	
	}

?>