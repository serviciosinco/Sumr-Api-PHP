<?php 
	
	function GtLndLs($p=NULL){
		
		global $__cnx;	
		
		if(!isN($p["id"]) && !isN($p["id"])){ 
			if($p["tp"] == "enc"){
				$_fl .= "AND lnd_enc = '".$p["id"]."' ";
			}else{
				$_fl .= "AND id_lnd = ".$p["id"]." ";
			}
		}
															 
		$query_DtRg = " SELECT * 
						FROM "._BdStr(DBM).TB_LND."
							 INNER JOIN "._BdStr(DBM).TB_CL." ON lnd_cl = id_cl 
						WHERE id_lnd != '' AND cl_enc = '".DB_CL_ENC."' $_fl 
						ORDER BY id_lnd DESC";
				
		$DtRg = $__cnx->_qry($query_DtRg);
		
		if($DtRg){
			
			$row_DtRg = $DtRg->fetch_assoc();
			$Tot_DtRg = $DtRg->num_rows;
			
			$Vl['tot'] = $Tot_DtRg;
			
			if($Tot_DtRg > 0){
				
				$Vl['ls'] = [];
				
				do{
					
					if(!isN($row_DtRg['id_lnd']) && !isN($row_DtRg['id_lnd'])){
						array_push($Vl['ls'], 
							[
								'id'=>$row_DtRg['id_lnd'],
								'enc'=>$row_DtRg['lnd_enc'],
								'nm'=>ctjTx($row_DtRg['lnd_tt'], 'in'),
								'dir'=>$row_DtRg['lnd_dir'],
								'html'=>$__body
							]
						);	
					}
					
				}while($row_DtRg = $DtRg->fetch_assoc());
			}
		
		}
		
		$__cnx->_clsr($DtRg);
		return(_jEnc($Vl));
	
	}
	
	
	
	function GtLndCdnLs($p=NULL){
		
		global $__cnx;
		
		if(!isN($p['lnd'])){
			
			$query_DtRg = sprintf("	SELECT * 
							FROM "._BdStr(DBM).TB_LND_CDN."
								 LEFT JOIN "._BdStr(DBM).TB_SIS_CDN." ON lndcdn_cdn = id_siscdn 
							WHERE id_lndcdn != '' AND lndcdn_lnd= %s
							ORDER BY lndcdn_ord ASC", GtSQLVlStr($p['lnd'],'int') );
							
			$DtRg = $__cnx->_qry($query_DtRg);
			
			if($DtRg){
				
				$row_DtRg = $DtRg->fetch_assoc(); 
				$Tot_DtRg = $DtRg->num_rows;	
				
				if($Tot_DtRg > 0){
						
					$Vl['e'] = 'ok';
					$Vl['tot'] = $Tot_DtRg;
					
					do{
						
						$__id = $row_DtRg['lndcdn_ord'];
						
						$Vl['ls'][$__id] = [
												'id'=>ctjTx($row_DtRg['id_lndcdn'], 'in'),
												'enc'=>ctjTx($row_DtRg['lndcdn_enc'], 'in'),
												'cdn'=>[
													'id'=>ctjTx($row_DtRg['id_siscdn'], 'in'),
													'tt'=>ctjTx($row_DtRg['siscdn_tt'], 'in'),
													'url'=>ctjTx($row_DtRg['siscdn_url'], 'in'),
													'v'=>ctjTx($row_DtRg['siscdn_v'], 'in'),
													'up'=>mBln($row_DtRg['siscdn_up']),
													'js'=>mBln($row_DtRg['siscdn_js']),
													'css'=>mBln($row_DtRg['siscdn_css'])
												]
											];
						
					}while($row_DtRg = $DtRg->fetch_assoc());
					
				}else{
					$Vl['e'] = 'no';
					$Vl['w'] = TX_NXTMDL;
				}
			
			}
		
			$__cnx->_clsr($DtRg);
				
			return(_jEnc($Vl));
		
		}
	}
	
	
	
	
	function GtLndFontLs($p=NULL){
		
		global $__cnx;
		
		$Vl['e'] = 'no';
		
		if(!isN($p['lnd'])){	
			
			$query_DtRg = sprintf("	SELECT * 
									FROM "._BdStr(DBM).TB_LND_FONT."
										 LEFT JOIN "._BdStr(DBM).TB_SIS_FONT." ON lndfont_font = id_sisfont
									WHERE id_lndfont != '' AND lndfont_lnd= %s
								", GtSQLVlStr($p['lnd'],'int') );
							
			$DtRg = $__cnx->_qry($query_DtRg);
			
			if($DtRg){
				
				$row_DtRg = $DtRg->fetch_assoc(); 
				$Tot_DtRg = $DtRg->num_rows;	
				
				if($Tot_DtRg > 0){
						
					$Vl['e'] = 'ok';
					$Vl['tot'] = $Tot_DtRg;
					
					do{
						
						$__id = $row_DtRg['lndfont_enc'];
						
						$Vl['ls'][$__id] = [
												'id'=>ctjTx($row_DtRg['id_lndfont'], 'in'),
												'enc'=>ctjTx($row_DtRg['lndfont_enc'], 'in'),
												'font'=>[
													'id'=>ctjTx($row_DtRg['id_sisfont'], 'in'),
													'tt'=>ctjTx($row_DtRg['sisfont_tt'], 'in'),
													'cod'=>ctjTx($row_DtRg['sisfont_cod'], 'in'),
													'sze'=>ctjTx($row_DtRg['sisfont_sze'], 'in'),
													'sbst'=>ctjTx($row_DtRg['sisfont_sbst'], 'in')
												]
											];
						
					}while($row_DtRg = $DtRg->fetch_assoc());
					
				}else{

					$Vl['w'] = 'No records';
					
				}
			
			}else{
				
				$Vl['w'] = $__cnx->c_r->error;
				
			}
			
			$__cnx->_clsr($DtRg);
		
		}
				
		return(_jEnc($Vl));
	}
	
	
	function GtLndDt($p=NULL){
		
		global $__cnx;
		
		if(!isN($p['id'])){ 
			
			if($p['t'] == 'enc'){ 
				$__fl = 'lnd_enc'; $__t='text'; 
			}else{ 
				$__fl = 'id_lnd'; $__t='int'; 
			}

			$c_DtRg = "-1";if (isset($p['id'])){$c_DtRg = $p['id'];}
			
			
			$query_DtRg = sprintf('	SELECT * 
									FROM '._BdStr(DBM).TB_LND.'
										 INNER JOIN '._BdStr(DBM).TB_CL.' ON lnd_cl = id_cl
									WHERE '.$__fl.' = %s 
									LIMIT 1', GtSQLVlStr($c_DtRg,$__t));
			
			$DtRg = $__cnx->_qry($query_DtRg); 
			
			if($DtRg){
				
				$row_DtRg = $DtRg->fetch_assoc(); 
				$Tot_DtRg = $DtRg->num_rows;
				
				if($Tot_DtRg > 0){
				
					$r['e'] = 'ok';
					
					$r['id'] = $row_DtRg['id_lnd'];
					$r['enc'] = $row_DtRg['lnd_enc'];
					$r['cl'] = $row_DtRg['lnd_cl'];
					$r['tt'] = ctjTx($p['lnd_tt'],'in');
					$r['html'] = utf8_encode( $row_DtRg['lnd_html'] ) ;
					$r['js'] = utf8_encode( $row_DtRg['lnd_js'] ) ;
					$r['js_rdy'] = utf8_encode( $row_DtRg['lnd_js_rdy'] ) ;
					$r['js_ld'] = utf8_encode( $row_DtRg['lnd_js_ld'] ) ;
					$r['js_scrl'] = utf8_encode( $row_DtRg['lnd_js_scrl'] ) ;
					$r['css'] = utf8_encode( $row_DtRg['lnd_css'] ) ;
					$r['cdn'] = GtLndCdnLs([ 'lnd'=>$row_DtRg['id_lnd'] ]);
					$r['font'] = GtLndFontLs([ 'lnd'=>$row_DtRg['id_lnd'] ]);
					
					$r['fm'] = [
						'opq'=>mBln($row_DtRg['lnd_fm_opq']),
						'icn'=>	mBln($row_DtRg['lnd_fm_icn'])
					];
					
					$r['opt'] = [
						'cmprs'=>mBln($row_DtRg['lnd_opt_cmprs'])
					];
					
					$r['dir'] = $row_DtRg['lnd_dir'];
					$r['fi'] = $row_DtRg['lnd_fi'];
					$r['fa'] = $row_DtRg['lnd_fa'];
					
				}	
			}	
			
			$__cnx->_clsr($DtRg);
		}
		
		return _jEnc($r);
		
	}
	
	
	
	function GtLndTabUsLs($p=NULL){
		
		global $__cnx;
		
		if(!isN($p['bd'])){ $__bd=_BdStr($p['bd']); }
		
															
		if(!isN($p["lnd"]) && !isN($p["lnd"])){
			if($p["lnd_tp"] == "enc"){
				$_fl .= "AND lndtabus_lnd IN (SELECT id_lnd FROM "._BdStr(DBM).TB_LND." WHERE lnd_enc = '".$p["lnd"]."')";
			}
			
			//Ultimo
			$_fl_ult = sprintf(", (SELECT lndtabus_ord FROM ".$__bd.MDL_LND_TAB_US_BD." WHERE lndtabus_us = %s AND lndtabus_lnd IN (SELECT id_lnd FROM "._BdStr(DBM).TB_LND." WHERE lnd_enc = %s) ORDER BY lndtabus_ord DESC LIMIT 1) AS _ult ",
				GtSQLVlStr(SISUS_ID, "int"),
				GtSQLVlStr(ctjTx($p["lnd"], 'out'), "text"));
				
			//Ultimo
			$_fl_ult_enc = sprintf(", (SELECT lndtabus_enc FROM ".$__bd.MDL_LND_TAB_US_BD." WHERE lndtabus_us = %s AND lndtabus_lnd IN (SELECT id_lnd FROM "._BdStr(DBM).TB_LND." WHERE lnd_enc = %s) ORDER BY lndtabus_ord DESC LIMIT 1) AS _ult_enc ",
				GtSQLVlStr(SISUS_ID, "int"),
				GtSQLVlStr(ctjTx($p["lnd"], 'out'), "text"));
			
		}
		 
		 if(!isN($p["mdl"])){
			if($p["mdl_tp"] == "enc"){
				$_fl .= " AND lndtabus_mdl IN (SELECT id_mdl FROM ".$__bd.TB_MDL." WHERE mdl_enc = '".$p["mdl"]."')";
			}
		}
		 
		if(!isN($p["id"]) && !isN($p["id"])){
			if($p["tp"]=="enc"){
				$_fl .= " AND lndtabus_enc = '".$p["id"]."' ";
			}else{
				$_fl .= " AND id_lndtabus = ".$p["id"]." ";
			}
		}
		 
		//Valida el usuario
		if(SISUS_ID > 0){
			$_fl .= " AND lndtabus_us = ".SISUS_ID." ";
		}
		 
		$query_DtRg = sprintf("	SELECT * $_fl_ult $_fl_ult_enc 
								FROM ".$__bd.MDL_LND_TAB_US_BD."
									 INNER JOIN ".$__bd.TB_MDL." ON lndtabus_mdl = id_mdl
									 INNER JOIN "._BdStr(DBM).TB_LND." ON lndtabus_lnd = id_lnd
								WHERE id_lndtabus != '' $_fl 
								ORDER BY lndtabus_ord ASC");
		
		$DtRg = $__cnx->_qry($query_DtRg);
		
		if($DtRg){
			
			$row_DtRg = $DtRg->fetch_assoc();
			$Tot_DtRg = $DtRg->num_rows;
			
			
			$Vl['tot'] = $Tot_DtRg;
			
			if($Tot_DtRg > 0){
				
				$Vl['ult'] = $row_DtRg['_ult'];
				$Vl['ult_enc'] = $row_DtRg['_ult_enc'];
				$Vl['ls'] = [];
				
				do{
					
					/*
					$__lnd = new CRM_Lnd();
					$__lnd->id_lnd = $row_DtRg['id_lnd']; 
					$__lnd->lnd_html = ctjTx($row_DtRg['lnd_html'],'in','',['html'=>'ok']);
					$__lnd->lnd_dir = $row_DtRg['lnd_dir'];
					$__lnd->lndtabus_enc = Php_Ls_Cln($row_DtRg['lndtabus_enc']);
					$__lnd->mdl_img = Php_Ls_Cln($row_DtRg['mdl_img']);
					if($p["lnd_mod"] == "ok"){ $__lnd->lnd_mod = "ok"; }else{ $__lnd->lnd_mod = "no"; }
					$__body = $__lnd->_bld();
					*/
					
					if(!isN($row_DtRg['id_lndtabus']) && !isN($row_DtRg['id_lndtabus'])){
						array_push($Vl['ls'], 
							[
								'id'=>$row_DtRg['id_lndtabus'],
								'enc'=>$row_DtRg['lndtabus_enc'],
								'lnd'=>[
									'id'=>$row_DtRg['lndtabus_lnd'],
									'enc'=>$row_DtRg['lnd_enc'],
								],
								'mdl'=>[
									'id'=>$row_DtRg['id_mdl'],
									'mdl_enc'=>ctjTx($row_DtRg['mdl_enc'],'in'),
									'pml'=>ctjTx($row_DtRg['mdl_pml'],'in'),
									'nm'=>ctjTx($row_DtRg['mdl_nm'],'in'),
								],
								'fm'=>[
									'opq'=>mBln($row_DtRg['lnd_fm_opq']),
									'icn'=>mBln($row_DtRg['lnd_fm_icn'])
								],
								'us'=>$row_DtRg['lndtabus_us'],
								'ord'=>$row_DtRg['lndtabus_ord'],
								'chk'=>$row_DtRg['lndtabus_chk'],
								//'dir'=>$row_DtRg['lnd_dir'],
								
								//'html'=>$__body
							]
						);	
					}
					
				}while($row_DtRg = $DtRg->fetch_assoc());
				
			}
		
		}
		
		$__cnx->_clsr($DtRg);
		return(_jEnc($Vl));
	
	}
	
	
	
	
	function GtLndMdlSgmDt($p=NULL){
		
		global $__cnx;
		
		$r['e'] = 'no';
		
		if(!isN($p['id']) || !isN($p['sgm_enc'])){ 
			
			if($p['t'] == 'enc'){ $__fl = 'lndmdlsgm_enc'; $__t='text'; }else{ $__fl = 'id_lndmdlsgm'; $__t='int'; }
			if(!isN($p['id'])){ $_fl .= ' AND '.$__fl.'="'.$p['id'].'" '; }
			if(!isN($p['sgm_enc'])){ $_fl .= ' AND sisslc_enc="'.$p['sgm_enc'].'" '; }
			if(!isN($p['mdl_enc'])){ $_fl .= ' AND mdl_enc="'.$p['mdl_enc'].'" '; }
			if(!isN($p['lnd_enc'])){ $_fl .= ' AND lnd_enc="'.$p['lnd_enc'].'" '; }

			if(!isN($p['bd'])){ $__bd=_BdStr($p['bd']); }
			
			$query_DtRg = sprintf('	SELECT * 
									FROM '.$__bd.TB_LND_MDL_SGM.'
										 INNER JOIN '.$__bd.TB_MDL.' ON lndmdlsgm_mdl = id_mdl
										 INNER JOIN '._BdStr(DBM).TB_LND.' ON lndmdlsgm_lnd = id_lnd
										 INNER JOIN '._BdStr(DBM).TB_SIS_SLC.' ON lndmdlsgm_sgm = id_sisslc
									WHERE id_lndmdlsgm != "" '.$_fl.'
									LIMIT 1');
			
			$DtRg = $__cnx->_qry($query_DtRg); 
			
			if($DtRg){
				
				$row_DtRg = $DtRg->fetch_assoc(); 
				$Tot_DtRg = $DtRg->num_rows;
				
				$r['tot'] = $Tot_DtRg;
				
				if($Tot_DtRg > 0){
				
					$r['e'] = 'ok';
					
					$r['id'] = $row_DtRg['id_lndmdlsgm'];
					$r['enc'] = $row_DtRg['lndmdlsgm_enc'];
					
					$r['html'] = ctjTx($row_DtRg['lndmdlsgm_vle'],'in', '', ['html'=>'ok','schr'=>'no','nl2'=>'no','qte'=>'no']);

					$r['fi'] = $row_DtRg['lndmdlsgm_fi'];
					$r['fa'] = $row_DtRg['lndmdlsgm_fa'];
					
				}	
				
			}else{
				
				$r['w'] = $__cnx->c_r->error;
				
			}	
			
			$__cnx->_clsr($DtRg);
			
		}
		
		return _jEnc($r);
		
	}
	
	
	function GtLndMdlSgmHisLs($p=NULL){
		
		global $__cnx;	
		
		if(!isN($p["fl"]) && !isN($p["fl"])){ 
			$_fl .= $p["fl"];
		}
		
		if(!isN($p["id"]) && !isN($p["id"])){ 
			$_fl .= "AND lndmdlsgmhis_lndmdlsgm = ".$p["id"]." ";
		}	
		
		$query_DtRg = " SELECT * FROM ".TB_LND_MDL_SGM_HIS.", "._BdStr(DBM).TB_US." WHERE lndmdlsgmhis_us = id_us AND id_lndmdlsgmhis != '' $_fl ORDER BY id_lndmdlsgmhis DESC";
		
		$DtRg = $__cnx->_qry($query_DtRg);
		
		if($DtRg){
			
			$row_DtRg = $DtRg->fetch_assoc();
			$Tot_DtRg = $DtRg->num_rows;
			
			$Vl['tot'] = $Tot_DtRg;
			
			if($Tot_DtRg > 0){
				
				$Vl['ls'] = [];
				
				do{
					
					$date = new DateTime( $row_DtRg['lndmdlsgmhis_fi'] );
					
					if(!isN($row_DtRg['id_lndmdlsgmhis']) && !isN($row_DtRg['id_lndmdlsgmhis'])){
						array_push($Vl['ls'], 
							[
								'id'=>$row_DtRg['id_lndmdlsgmhis'],
								'enc'=>$row_DtRg['lndmdlsgmhis_enc'],
								'tt'=>ctjTx($row_DtRg['lndmdlsgmhis_vle'],'in','', /*["html"=>"ok", "schr"=>"no"]*/ ''),
								'fi'=>Spn( FechaESP_OLD( $row_DtRg['lndmdlsgmhis_fi'] ).' - '.Spn($date->format('H:i a'),'','_h'), '', '_f'),
								'us'=>ctjTx($row_DtRg['us_nm']." ".$row_DtRg['us_ap'],'in'),
								'us_img'=>ctjTx($row_DtRg['us_img'],'in')
							]
						);	
					}
					
				}while($row_DtRg = $DtRg->fetch_assoc());
			}
		
		}
		
		$__cnx->_clsr($DtRg);
		return(_jEnc($Vl));
		
	}
	
	function GtLndMdlSgmAttrLs($p=NULL){
		
		global $__cnx;	
		
		if(!isN($p["sgm"]) && !isN($p["sgm"])){ 
			if($p["sgm_tp"] == 'enc'){ 
				$_fl .= "AND lndmdlsgmattr_sgm IN (SELECT id_lndmdlsgm FROM ".TB_LND_MDL_SGM." WHERE lndmdlsgm_enc = '".$p["sgm"]."') ";
			}
		}
		
		if(!isN($p["attr"]) && !isN($p["attr"])){ 
			$_fl .= "AND lndmdlsgmattr_attr = ".$p["attr"]." ";
		}
															 
		$query_DtRg = " SELECT * FROM ".MDL_LND_MDL_SGM_ATTR_BD." WHERE id_lndmdlsgmattr != '' $_fl ORDER BY id_lndmdlsgmattr DESC";
		
		$DtRg = $__cnx->_qry($query_DtRg);
		
		if($DtRg){
			
			$row_DtRg = $DtRg->fetch_assoc();
			$Tot_DtRg = $DtRg->num_rows;
			
			$Vl['tot'] = $Tot_DtRg;
			
			if($Tot_DtRg > 0){
				
				$Vl['e'] = 'ok';
				$Vl['ls'] = [];
				
				do{
					
					if(!isN($row_DtRg['id_lndmdlsgmattr']) && !isN($row_DtRg['id_lndmdlsgmattr'])){
						array_push($Vl['ls'], 
							[
								'id'=>$row_DtRg['id_lndmdlsgmattr'],
								'enc'=>$row_DtRg['lndmdlsgmattr_enc'],
								'tt'=>$row_DtRg['lndmdlsgmattr_vle'],
								'sgm'=>$row_DtRg['lndmdlsgmattr_sgm'],
								'attr'=>$row_DtRg['lndmdlsgmattr_attr']
							]
						);	
					}
					
				}while($row_DtRg = $DtRg->fetch_assoc());
			}else{
				$Vl['e'] = 'no';
			}
		
		}
		
		$__cnx->_clsr($DtRg);
		return(_jEnc($Vl));
		
	}
	
	function GtLndMdlSgmLs($p=NULL){
		
		global $__cnx;
		
		if(!isN($p["id"]) && !isN($p["id"])){
			if($p["tp"] == 'enc'){  
				$_fl .= "AND lndmdlsgm_enc = '".$p["id"]."' ";
			}
			elseif($p["tp"] == 'id'){  
				$_fl .= "AND id_lndmdlsgm = ".$p["id"]." ";
			}
		}
		
		if(!isN($p["id_lnd"]) && !isN($p["id_lnd"])){
			if($p["lnd_tp"] == 'enc'){  
				$_fl .= "AND lnd_enc = '".$p["id_lnd"]."' ";
			}
			elseif($p["lnd_tp"] == 'id'){  
				$_fl .= "AND id_lnd = ".$p["id_lnd"]." ";
			}
		}
		
		if(!isN($p["id_tab"]) && !isN($p["id_tab"])){
			if($p["tab_tp"] == "enc"){
				$_fl_inr .= " INNER JOIN ".MDL_LND_TAB_US_BD." ON lndmdlsgm_lnd = lndtabus_lnd AND lndmdlsgm_mdl = lndtabus_mdl AND lndtabus_enc = '".$p["id_tab"]."' ";
			}
		}	
				
		 
		
		$query_DtRg = sprintf('SELECT *,
		
								'._QrySisSlcF(['als'=>'t', 'als_n'=>'tp']).',
								'.GtSlc_QryExtra(['t'=>'fld', 'p'=>'tp', 'als'=>'t', 'l'=>'ok']).',
								
								'._QrySisSlcF(['als'=>'a', 'als_n'=>'attr']).',
								'.GtSlc_QryExtra(['t'=>'fld', 'p'=>'attr', 'als'=>'a', 'l'=>'ok']).'
										
								FROM '.TB_LND_MDL_SGM.'
									 INNER JOIN '._BdStr(DBM).TB_LND.' ON lndmdlsgm_lnd = id_lnd
									 INNER JOIN '.TB_MDL.' ON lndmdlsgm_mdl = id_mdl
									 LEFT JOIN '.MDL_LND_MDL_SGM_ATTR_BD.' ON lndmdlsgmattr_sgm = id_lndmdlsgm
								
								'.$_fl_inr.'
								
								'.GtSlc_QryExtra(['t'=>'tb', 'col'=>'lndmdlsgmattr_attr', 'als'=>'a', 'l'=>'ok']).'
								'.GtSlc_QryExtra(['t'=>'tb', 'col'=>'lndmdlsgm_sgm', 'als'=>'t']).'
																
								WHERE id_lndmdlsgm != "" '.$_fl.'
									
							');
			
		$DtRg = $__cnx->_qry($query_DtRg); 
		
		if($DtRg){
			
			$row_DtRg = $DtRg->fetch_assoc(); 
			$Tot_DtRg = $DtRg->num_rows;	
	
			if($Tot_DtRg > 0){
				
				do{
					
					$__attr = json_decode($row_DtRg['___attr']); 
					foreach($__attr as $__attr_k=>$__attr_v){	
						if(!empty($row_DtRg['lndmdlsgmattr_vle']) && !is_numeric($__attr_v->vl)){
							$__attr_sgm[$row_DtRg['lndmdlsgm_enc']][$__attr_v->vl] = $row_DtRg['lndmdlsgmattr_vle'];
						}
					}
					
					$__tp = json_decode($row_DtRg['___tp']); 
					foreach($__tp as $__tp_k=>$__tp_v){	
						$__tp_go[$__tp_v->key] = $__tp_v;
					}
					
					$Vl[$row_DtRg['id_sisslc']] = [ 'id'=>ctjTx($row_DtRg['id_lndmdlsgm'],'in'),
													'enc'=>ctjTx($row_DtRg['lndmdlsgm_enc'],'in'),
													'tt'=>ctjTx($row_DtRg['lndmdlsgm_vle'],'in','',['html'=>'ok','schr'=>'no','nl2'=>'no','qte'=>'no']),
													'tp'=>$__tp_go,
													'sgm'=>[
														'id'=>$row_DtRg['tp_id_sisslc'],
														'enc'=>$row_DtRg['tp_sisslc_enc']
													],
													'attr'=>$__attr_sgm
												];
														
				} while ($row_DtRg = $DtRg->fetch_assoc());
			}
		
		}else{
			
			echo $__cnx->c_r->error.'-'.$query_DtRg;
			
		}
		
		$__cnx->_clsr($DtRg);
		return(_jEnc($Vl));
		
	}
	
?>