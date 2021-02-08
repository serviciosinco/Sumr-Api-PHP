<?php 
 
	// Arreglar todas las auditorias ->Camilo
	 
	class CRM_Lnd {
	    
	    public $rnd_enc;
	    
	    function __construct($p=NULL) { 
		 
	        $this->_aud = new CRM_Aud();
	        
	        if(isN($p['cl'])){ 
		        $this->cl = GtClDt( Gt_SbDMN(), "sbd"); 
		        if(!isN($this->cl->bd)){ $this->bd = _BdStr($this->cl->bd); }else{ $this->bd = ''; }
		    }else{
			    $this->cl = $p['cl'];
		    }

	    }
	    
	    //------------- Ingresar Landing -------------//
	    
		public function In_Lnd($p=NULL){
			
			global $__cnx; 
			
			$this->rnd_enc = Gn_Rnd(20).Gn_Rnd(5);
			
			if(!isN($this->trarsp_us)){ $__rsp_us = $this->trarsp_us; }else{ $__rsp_us = SISUS_ID; }
			if(!isN($this->ec_dir)){ $_dir = $this->lnd_dir; }else{ $_dir = SIS_Y.'_'.strtolower(DMN_SB).'_'.Gn_Rnd(10); }
			
			
			$query_DtRg =  sprintf("INSERT INTO "._BdStr(DBM).TB_LND." (lnd_enc, lnd_cl, lnd_tt, lnd_dir, lnd_us) VALUES (%s, %s, %s, %s, %s)",
						GtSQLVlStr(ctjTx($this->rnd_enc, 'out'), "text"),
						GtSQLVlStr($this->cl->id, "int"),
						GtSQLVlStr(ctjTx($this->lnd_tt,'out'), "text"),
						GtSQLVlStr(ctjTx($_dir,'out'), "text"),
						GtSQLVlStr(SISUS_ID, "int"));		
			
			$Result = $__cnx->_prc($query_DtRg);
					
			if($Result){	
				
				$rsp['e'] = 'ok';
				$rsp['m'] = 1;
				
			}else{
				$rsp['e'] = 'no';
				$rsp['m'] = 2;
				$rsp['w'] = $__cnx->c_p->error;
			}
			
			return _jEnc($rsp); 
			
		}
		
		// ---------- Landing Js ---------- //
		
		public function LsLndJs(){
			
			global $__cnx; 
			
			$query_DtRg = "SELECT
								*,(
									SELECT
										COUNT(*)
									FROM
										"._BdStr(DBM).TB_LND_CDN."
										INNER JOIN "._BdStr(DBM).TB_LND." ON id_lnd = lndcdn_lnd
									WHERE
										id_siscdn = lndcdn_cdn
									AND lnd_enc = '".$this->id_lnd."' 									
								) AS __est
							FROM "._BdStr(DBM).TB_SIS_CDN."
								 LEFT JOIN "._BdStr(DBM).TB_LND_CDN." ON lndcdn_cdn = id_siscdn
							ORDER BY siscdn_tt ASC";

			$DtRg = $__cnx->_qry($query_DtRg);
			
			if($DtRg){
				
				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;
				$Vl['tot'] = $Tot_DtRg;
				
				if($Tot_DtRg > 0){
					
					$Vl['e'] = 'ok';
					
					do{	
						
						$Vl['ls'][$row_DtRg['siscdn_enc']]['enc'] = $row_DtRg['siscdn_enc'];	
						$Vl['ls'][$row_DtRg['siscdn_enc']]['nm'] = ctjTx($row_DtRg['siscdn_tt'],'in');
						$Vl['ls'][$row_DtRg['siscdn_enc']]['est'] = $row_DtRg['__est'];
						$Vl['ls'][$row_DtRg['siscdn_enc']]['ord'] = !isN($row_DtRg['lndcdn_ord'])?$row_DtRg['lndcdn_ord']:'-';
						$Vl['ls'][$row_DtRg['siscdn_enc']]['up'] = mBln($row_DtRg['lndcdn_up']);
						$Vl['ls'][$row_DtRg['siscdn_enc']]['js'] = mBln($row_DtRg['siscdn_js']);
						$Vl['ls'][$row_DtRg['siscdn_enc']]['css'] = mBln($row_DtRg['siscdn_css']);
						
					}while($row_DtRg = $DtRg->fetch_assoc());
					
				}
				
			}else{
				
				$Vl['w'] = $__cnx->c_r->error;
			}	
			
			$__cnx->_clsr($DtRg);
			return _jEnc($Vl);	
								
		}
		
		
		
		
		public function LsLndJs_In($p=NULL){
			
			global $__cnx; 
			
			if(!isN($this->id_lnd) && !isN($this->id_js)){
				$__enc = Enc_Rnd($this->id_lnd.' - '.$this->id_js);
			
				$Query_DtRg = sprintf("INSERT INTO "._BdStr(DBM).TB_LND_CDN." 
											(lndcdn_enc, lndcdn_lnd, lndcdn_cdn) VALUES 
											(
												%s,
												(SELECT id_lnd FROM "._BdStr(DBM).TB_LND." WHERE lnd_enc = %s), 
												(SELECT id_siscdn FROM "._BdStr(DBM).TB_SIS_CDN." WHERE siscdn_enc = %s)
											)",
											
											GtSQLVlStr(ctjTx($__enc,'out'), "text"),
											GtSQLVlStr(ctjTx($this->id_lnd,'out'), "text"),
											GtSQLVlStr(ctjTx($this->id_js,'out'), "text"));		

				$Result = $__cnx->_prc($Query_DtRg);
				
				if($Result){	
					
					$rsp['e'] = 'ok';
					$rsp['m'] = 1;
				}else{
					$rsp['e'] = 'no';
					$rsp['m'] = 2;
					$rsp['w'] = $__cnx->c_p->error.' <-> '.$Query_DtRg;
					$rsp['w_n'] = $__cnx->c_p->errno;
				}	
			}else{
				$rsp['e'] = 'no';	
			}
			
			
			
			return _jEnc($rsp); 
			
		} 
		
	    public function LsLndJs_Del($p=NULL){
			
			global $__cnx; 
			
			$query_DtRg = sprintf("	DELETE 
									FROM "._BdStr(DBM).TB_LND_CDN." 
									WHERE 	lndcdn_lnd IN (SELECT id_lnd FROM "._BdStr(DBM).TB_LND." WHERE lnd_enc = %s) AND 
											lndcdn_cdn IN (SELECT id_siscdn FROM "._BdStr(DBM).TB_SIS_CDN." WHERE siscdn_enc = %s)",
								GtSQLVlStr(ctjTx($this->id_lnd,'out'), "text"),
								GtSQLVlStr(ctjTx($this->id_js,'out'), "text"));		

			$Result = $__cnx->_prc($query_DtRg);
					
			if($Result){	
				
				$rsp['e'] = 'ok';
				$rsp['m'] = 1;
				
			}else{
				$rsp['e'] = 'no';
				$rsp['m'] = 2;
				$rsp['w'] = $__cnx->c_p->error;
				$rsp['w_n'] = $__cnx->c_p->errno;
			}
			
			return _jEnc($rsp); 
			
		}
		
		public function LsLndJs_Ord($p=NULL){
			
			global $__cnx; 
			
			if(!isN($this->id_lnd) && !isN($this->id_js)){
				$__enc = Enc_Rnd($this->id_lnd.' - '.$this->id_js);
				
				$Query_DtRg = sprintf("UPDATE "._BdStr(DBM).TB_LND_CDN." SET lndcdn_ord = %s 
											WHERE lndcdn_lnd = (SELECT id_lnd FROM "._BdStr(DBM).TB_LND." WHERE lnd_enc = %s) AND
											lndcdn_cdn = (SELECT id_siscdn FROM "._BdStr(DBM).TB_SIS_CDN." WHERE siscdn_enc = %s) ",
				
											GtSQLVlStr(ctjTx($this->vl,'out'), "text"),
											GtSQLVlStr(ctjTx($this->id_lnd,'out'), "text"),
											GtSQLVlStr(ctjTx($this->id_js,'out'), "text"));

				$Result = $__cnx->_prc($Query_DtRg);
				
				if($Result){	
					
					$rsp['e'] = 'ok';
					$rsp['m'] = 1;
				}else{
					$rsp['e'] = 'no';
					$rsp['m'] = 2;
					$rsp['w_n'] = $__cnx->c_p->errno;
				}	
			}else{
				$rsp['e'] = 'no';	
			}
			
			
			
			return _jEnc($rsp); 
			
		} 
		
		// -------- Landing Tipo ---------- //
		
		public function LsLndTp(){
		 	
		 	global $__cnx; 
		 	
			$query_DtRg = "SELECT
								*,(
									SELECT
										COUNT(*)
									FROM
										"._BdStr(DBM).TB_LND_TP."
									INNER JOIN "._BdStr(DBM).TB_LND." ON id_lnd = lndtp_lnd
									where
										lndtp_mdlstp = id_mdlstp
								) AS __est
							from
								"._BdStr(DBM).TB_MDL_S_TP."
							INNER JOIN "._BdStr(DBM).TB_MDL_S_TP_CL." ON mdlstpcl_mdlstp = id_mdlstp
							INNER JOIN "._BdStr(DBM).TB_CL." ON mdlstpcl_cl = id_cl
							WHERE
								cl_enc = '".CL_ENC."'";
			
			$DtRg = $__cnx->_qry($query_DtRg);
			
			if($DtRg){
				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;
				$Vl['tot'] = $Tot_DtRg;
				if($Tot_DtRg > 0){
					$Vl['e'] = 'ok';
					$Vl['id'] = $query_DtRg;
					do{	
						$Vl['ls'][$row_DtRg['mdlstp_enc']]['enc'] = $row_DtRg['mdlstp_enc'];	
						$Vl['ls'][$row_DtRg['mdlstp_enc']]['nm'] = ctjTx($row_DtRg['mdlstp_nm'],'in');
						$Vl['ls'][$row_DtRg['mdlstp_enc']]['est'] = $row_DtRg['__est'];
					}while($row_DtRg = $DtRg->fetch_assoc());
				}
			}	

			$__cnx->_clsr($DtRg);
			
			return _jEnc($Vl);	
								
		}
		
		
		public function LsLndTp_In($p=NULL){
			
			global $__cnx; 
			
			if(!isN($this->id_lnd) && !isN($this->id_tp)){
				$__enc = Enc_Rnd($this->id_lnd.' - '.$this->id_tp);
			
				$Query_DtRg = sprintf("INSERT INTO "._BdStr(DBM).TB_LND_TP." 
											(lndtp_enc, lndtp_lnd, lndtp_mdlstp) VALUES 
											(
												%s,
												(SELECT id_lnd FROM "._BdStr(DBM).TB_LND." WHERE lnd_enc = %s), 
												(SELECT id_mdlstp FROM "._BdStr(DBM).TB_MDL_S_TP." WHERE mdlstp_enc = %s)
											)",
											
											GtSQLVlStr(ctjTx($__enc,'out'), "text"),
											GtSQLVlStr(ctjTx($this->id_lnd,'out'), "text"),
											GtSQLVlStr(ctjTx($this->id_tp,'out'), "text"));		

				$Result = $__cnx->_prc($Query_DtRg);
				
				if($Result){	
					
					$rsp['e'] = 'ok';
					$rsp['m'] = 1;
				}else{
					$rsp['e'] = 'no';
					$rsp['m'] = 2;
					$rsp['w'] = $__cnx->c_p->error.' <-> '.$Query_DtRg;
					$rsp['w_n'] = $__cnx->c_p->errno;
				}	
			}else{
				$rsp['e'] = 'no';	
			}
			
			
			
			return _jEnc($rsp); 
			
		} 
		
		
	    public function LsLndTp_Del($p=NULL){
			
			global $__cnx; 
			
			$query_DtRg = sprintf("DELETE FROM "._BdStr(DBM).TB_LND_TP." WHERE 
							lndtp_lnd IN (SELECT id_lnd FROM "._BdStr(DBM).TB_LND." WHERE lnd_enc = %s) AND 
							lndtp_mdlstp IN (SELECT id_mdlstp FROM "._BdStr(DBM).TB_MDL_S_TP." WHERE mdlstp_enc = %s)",			
								GtSQLVlStr(ctjTx($this->id_lnd,'out'), "text"),
								GtSQLVlStr(ctjTx($this->id_tp,'out'), "text"));		

			$Result = $__cnx->_prc($query_DtRg);
					
			if($Result){	
				
				$rsp['e'] = 'ok';
				$rsp['m'] = 1;
				
			}else{
				$rsp['e'] = 'no';
				$rsp['m'] = 2;
				$rsp['w'] = $__cnx->c_p->error;
				$rsp['w_n'] = $__cnx->c_p->errno;
			}
			
			return _jEnc($rsp); 
			
		}
		
		// -------- Landing Font ---------- //
		
		public function LsLndFont(){
			
			global $__cnx; 
			
			$query_DtRg = "SELECT
								*,(
									SELECT
										COUNT(*)
									FROM
										"._BdStr(DBM).TB_LND_FONT."
									INNER JOIN "._BdStr(DBM).TB_LND." ON id_lnd = lndfont_lnd
									WHERE
										id_sisfont = lndfont_font
									AND lnd_enc = '".$this->id_lnd."'
								) AS __est
							from
								"._BdStr(DBM).TB_SIS_FONT." ";

			$DtRg = $__cnx->_qry($query_DtRg);
			
			if($DtRg){
				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;
				
				$Vl['tot'] = $Tot_DtRg;
				
				if($Tot_DtRg > 0){
					
					$Vl['e'] = 'ok';
					
					do{	
						$Vl['ls'][$row_DtRg['sisfont_enc']]['enc'] = $row_DtRg['sisfont_enc'];	
						$Vl['ls'][$row_DtRg['sisfont_enc']]['nm'] = ctjTx($row_DtRg['sisfont_tt'],'in');
						$Vl['ls'][$row_DtRg['sisfont_enc']]['est'] = $row_DtRg['__est'];
					}while($row_DtRg = $DtRg->fetch_assoc());
					
				}
			}	
			$__cnx->_clsr($DtRg);
			return _jEnc($Vl);	
								
		}
		
		
		public function LsLndFont_In($p=NULL){
			
			global $__cnx; 
			
			if(!isN($this->id_lnd) && !isN($this->id_font)){
				$__enc = Enc_Rnd($this->id_lnd.' - '.$this->id_font);
			
				$Query_DtRg = sprintf("INSERT INTO "._BdStr(DBM).TB_LND_FONT." 
											(lndfont_enc, lndfont_lnd, lndfont_font) VALUES 
											(
												%s,
												(SELECT id_lnd FROM "._BdStr(DBM).TB_LND." WHERE lnd_enc = %s), 
												(SELECT id_sisfont FROM "._BdStr(DBM).TB_SIS_FONT." WHERE sisfont_enc = %s)
											)",
											
											GtSQLVlStr(ctjTx($__enc,'out'), "text"),
											GtSQLVlStr(ctjTx($this->id_lnd,'out'), "text"),
											GtSQLVlStr(ctjTx($this->id_font,'out'), "text"));		

				$Result = $__cnx->_prc($Query_DtRg);
				
				if($Result){	
					
					$rsp['e'] = 'ok';
					$rsp['m'] = 1;
				}else{
					$rsp['e'] = 'no';
					$rsp['m'] = 2;
					$rsp['w_n'] = $__cnx->c_p->errno;
				}	
			}else{
				$rsp['e'] = 'no';	
			}
			
			
			
			return _jEnc($rsp); 
			
		} 
		
		
	    public function LsLndFont_Del($p=NULL){
			
			global $__cnx; 
			
			$query_DtRg = sprintf("DELETE FROM "._BdStr(DBM).TB_LND_FONT." WHERE 
			lndfont_lnd IN (SELECT id_lnd FROM "._BdStr(DBM).TB_LND." WHERE lnd_enc = %s) AND 
			lndfont_font IN (SELECT id_sisfont FROM "._BdStr(DBM).TB_SIS_FONT." WHERE sisfont_enc = %s)",
			
								GtSQLVlStr(ctjTx($this->id_lnd,'out'), "text"),
								GtSQLVlStr(ctjTx($this->id_font,'out'), "text"));		

			$Result = $__cnx->_prc($query_DtRg);
			
			if($Result){	
				
				$rsp['e'] = 'ok';
				$rsp['m'] = 1;
				
			}else{
				$rsp['e'] = 'no';
				$rsp['m'] = 2;
				$rsp['w'] = $__cnx->c_p->error;
				$rsp['w_n'] = $__cnx->c_p->errno;
			}
			
			return _jEnc($rsp); 
			
		}
		
		
		//------------- Modificar Landing -------------//
		public function Mod_Lnd($p=NULL){
			
			global $__cnx; 
			
			$this->rnd_enc = Gn_Rnd(20).Gn_Rnd(5);
			
			if($this->trarsp_us != ''){ $__rsp_us = $this->trarsp_us; }else{ $__rsp_us = SISUS_ID; }
			
			$query_DtRg =   sprintf("UPDATE "._BdStr(DBM).TB_LND." SET lnd_tt=%s WHERE lnd_enc=%s",
						GtSQLVlStr(ctjTx($this->lnd_tt, 'out'), "text"),
						GtSQLVlStr(ctjTx($this->lnd_enc, 'out'), "text"));		
			
			$Result = $__cnx->_prc($query_DtRg);
					
			if($Result){	
				
				$rsp['e'] = 'ok';
				$rsp['m'] = 1;
				
			}else{
				$rsp['e'] = 'no';
				$rsp['m'] = 2;
				$rsp['w'] = $__cnx->c_p->error;
			}
			
			return _jEnc($rsp); 
			
		}
		
		
		
		public function Chk_Lnd_Us_Tab($p=NULL){
			
			global $__cnx; 
			
			$Vl['e'] = 'no';
			
			if( !isN($p['us']) && !isN($p['mdl']) && !isN($p['lnd']) ){
				
				$query_DtRg = sprintf('	SELECT * 
									   	FROM '.MDL_LND_TAB_US_BD.' 
									   	WHERE lndtabus_us=%s AND lndtabus_mdl=(SELECT id_mdl FROM '.TB_MDL.' WHERE mdl_enc=%s) AND lndtabus_lnd=(SELECT id_lnd FROM '._BdStr(DBM).TB_LND.' WHERE lnd_enc=%s)
									   	LIMIT 1', 
									   	GtSQLVlStr($p['us'], 'int'),
									   	GtSQLVlStr($p['mdl'], 'text'),
									   	GtSQLVlStr($p['lnd'], 'text')
									);
									   
				$DtRg = $__cnx->_qry($query_DtRg); 
				
				if($DtRg){
					
					$row_DtRg = $DtRg->fetch_assoc(); 
					$Tot_DtRg = $DtRg->num_rows;	
					$Vl['tot'] = $Tot_DtRg;
					
					if($Tot_DtRg > 0){	
						$Vl['e'] = 'ok';
						$Vl['id'] = $row_DtRg['id_lndtabus'];
						$Vl['enc'] = $row_DtRg['lndtabus_enc'];
					}
					
				}else{
					
					$Vl['w'] = $__cnx->c_r->error;
	
				}
				$__cnx->_clsr($DtRg);
			}else{
				
				$Vl['m'] = 'No id';
				
			}
	
			return _jEnc($Vl);
		}
		
		
		
		//------------- Ingresar TabedPanel -------------//
		
		
		public function In_Lnd_Us_Tab($p=NULL){
			
			global $__cnx; 
			
			$_chk = $this->Chk_Lnd_Us_Tab([ 'us'=>SISUS_ID, 'mdl'=>$this->lndtabus_mdl, 'lnd'=>$this->lndtabus_lnd ]);
			
			$rsp['chk'] = $_chk;
			
			if($_chk->e != 'ok'){
				
				$this->rnd_enc = Gn_Rnd(20).Gn_Rnd(5);
				
				$query_DtRg = sprintf(" INSERT INTO ".MDL_LND_TAB_US_BD." (lndtabus_enc, lndtabus_us, lndtabus_mdl, lndtabus_ord, lndtabus_chk, lndtabus_lnd) VALUES (%s, %s, (SELECT id_mdl FROM ".TB_MDL." WHERE mdl_enc = %s), %s, %s, (SELECT id_lnd FROM "._BdStr(DBM).TB_LND." WHERE lnd_enc = %s)) ",
							GtSQLVlStr(ctjTx($this->rnd_enc, 'out'), "text"),
							GtSQLVlStr(SISUS_ID, "int"),
							GtSQLVlStr(ctjTx($this->lndtabus_mdl, 'out'), "text"),
							GtSQLVlStr($this->lndtabus_ord, "int"),
							GtSQLVlStr(1, "int"),
							GtSQLVlStr(ctjTx($this->lndtabus_lnd, 'out'), "text"));
								
				$Result = $__cnx->_prc($query_DtRg);
				
				$this->id_lndtabus = $__cnx->c_p->insert_id;
				
				if($Result){	
				
					$query_DtRgAll = sprintf("UPDATE ".MDL_LND_TAB_US_BD." SET lndtabus_chk = 2 WHERE lndtabus_us = %s 
												AND lndtabus_lnd IN ( SELECT id_lnd FROM "._BdStr(DBM).TB_LND." WHERE lnd_enc = %s ) 
												AND id_lndtabus != %s ",
							GtSQLVlStr(SISUS_ID, "int"),
							GtSQLVlStr(ctjTx($this->lndtabus_lnd, 'out'), "text"),
							GtSQLVlStr($this->id_lndtabus, "int"));
							
					$ResultAll = $__cnx->_prc($query_DtRgAll);
					
					$rsp['e'] = 'ok';
					$rsp['m'] = 1;
					
				}else{
					$rsp['e'] = 'no';
					$rsp['m'] = 2;
					$rsp['w'] = $query_DtRg.$__cnx->c_p->error;
				}
			
			}elseif($_chk->e == 'ok'){
				
				$rsp['e'] = 'ok';
				$rsp['m'] = 1;
				$rsp['upd'] = 'ok';
				
				$this->id_lndtabus = $_chk->id;
				$this->rnd_enc = $_chk->enc;
					
			}	
			
			
			return _jEnc($rsp); 
			
		}
		
		
		//------------- Eliminar TabedPanel -------------//
		public function Eli_Lnd_Us_Tab($p=NULL){
			
			global $__cnx; 
			
			if(!isN($this->lndtabus_enc)){
				
				$_LndTabUs = GtLndTabUsLs( ["id"=>$this->lndtabus_enc, "tp"=>"enc"] );
				$_LndTabUsDt = $_LndTabUs->ls['0'];
				
				//Cambiar el orden de los otros TabedPanel
				$query_DtRg = sprintf(" UPDATE ".MDL_LND_TAB_US_BD." SET lndtabus_ord = (lndtabus_ord-1) WHERE lndtabus_ord > %s AND lndtabus_lnd = %s AND lndtabus_us = %s ",
							GtSQLVlStr($_LndTabUsDt->ord, "int"),
							GtSQLVlStr($_LndTabUsDt->lnd, "int"),
							GtSQLVlStr(SISUS_ID, "int"));
				$Result = $__cnx->_prc($query_DtRg);
				
				//Eliminar TabedPanel
				$query_DtRgEli = sprintf(" DELETE FROM ".MDL_LND_TAB_US_BD." WHERE lndtabus_enc = %s AND lndtabus_us = %s ",
							GtSQLVlStr(ctjTx($this->lndtabus_enc, 'out'), "text"),
							GtSQLVlStr(SISUS_ID, "int"));
				$ResultEli = $__cnx->_prc($query_DtRgEli);
				
				
				$rsp['q'] = $query_DtRgEli;
			
			}
			
			if($ResultEli){	
			
				//Si el TabedPanel estaba seleccionado se le asigna el chk a otro
				if($_LndTabUsDt->chk == 1){
					$_LndTabUsUlt = GtLndTabUsLs( ["lnd"=>$this->lndtabus_lnd, "lnd_tp"=>"enc"] );
					$query_DtRgChk = sprintf(" UPDATE ".MDL_LND_TAB_US_BD." SET lndtabus_chk = 1 WHERE lndtabus_ord = %s AND lndtabus_lnd = %s AND lndtabus_us = %s ",
								GtSQLVlStr($_LndTabUsUlt->ult, "int"),
								GtSQLVlStr($_LndTabUsUlt->ls['0']->lnd, "int"),
								GtSQLVlStr(SISUS_ID, "int"));
					$ResultChk = $__cnx->_prc($query_DtRgChk);
					$this->ult_enc = $_LndTabUsUlt->ult_enc;
				}
				
				$rsp['e'] = 'ok';
				$rsp['m'] = 1;
				
			}else{
				$rsp['e'] = 'no';
				$rsp['m'] = 2;
				$rsp['w'] = $__cnx->c_p->error;
			}
			
			return _jEnc($rsp);
			
		}
		
		//------------- Ultimo TabedPanel Seleccionado -------------//
		public function Mod_Lnd_Tab_Us($p=NULL){
	
			global $__cnx; 
			
			if($this->tp == 'slc'){	
				$_qry = sprintf(" UPDATE ".MDL_LND_TAB_US_BD." SET lndtabus_chk = 1 WHERE lndtabus_us = %s AND lndtabus_enc = %s 
									AND lndtabus_lnd IN ( SELECT id_lnd FROM "._BdStr(DBM).TB_LND." WHERE lnd_enc = %s ) ",
						GtSQLVlStr(SISUS_ID, "int"),
						GtSQLVlStr(ctjTx($this->lndtabus_enc, 'out'), "text"),
						GtSQLVlStr(ctjTx($this->lndtabus_lnd, 'out'), "text"));
			}
	
			$query_DtRg = $_qry;
			$Result = $__cnx->_prc($query_DtRg);
					
			if($Result){	
				
				if($this->tp == 'slc'){	
					$query_DtRgAll = sprintf("UPDATE ".MDL_LND_TAB_US_BD." SET lndtabus_chk = 2 WHERE lndtabus_us = %s 
												AND lndtabus_lnd IN ( SELECT id_lnd FROM "._BdStr(DBM).TB_LND." WHERE lnd_enc = %s ) 
												AND lndtabus_enc != %s ",
							GtSQLVlStr(SISUS_ID, "int"),
							GtSQLVlStr(ctjTx($this->lndtabus_lnd, 'out'), "text"),
							GtSQLVlStr(ctjTx($this->lndtabus_enc, 'out'), "text"));		
							
					$ResultAll = $__cnx->_prc($query_DtRgAll);
				}
				
				$query_Dt = sprintf("SELECT * FROM  ".MDL_LND_TAB_US_BD.", ".TB_MDL." WHERE id_mdl = lndtabus_mdl AND lndtabus_enc = %s LIMIT 1",
							GtSQLVlStr(ctjTx($this->lndtabus_enc, 'out'), "text"));	
								
				$DtRg = $__cnx->_qry($query_Dt);
				$row_DtRg = $DtRg->fetch_assoc();
				
				$rsp['mdl_enc'] = $row_DtRg["mdl_enc"];
				$rsp['e'] = 'ok';
				$rsp['m'] = 1;
				$__cnx->_clsr($DtRg);
				
			}else{
				$rsp['e'] = 'no';
				$rsp['m'] = 2;
				$rsp['w'] = $__cnx->c_p->error;
			}
			
			return _jEnc($rsp); 
			
		}
		
		
		
		public function MdlSgm_Chk($p=NULL){
			
			global $__cnx; 
			
			$this->_GtInfo();
			
			$Vl['e'] = 'no';
			
			
			$Vl['lnd'] = $this->__dtlnd->id;
			$Vl['sgm'] = $this->__dtsgm->id;
			$Vl['mdl'] = $this->__dtmdl->id;
				
				
			if(!isN($this->__dtlnd->id) && !isN($this->__dtsgm->id) && !isN($this->__dtmdl->id)){
				
				$query_DtRg = sprintf('	SELECT * 
									   	FROM '.TB_LND_MDL_SGM.'
									   	WHERE lndmdlsgm_lnd=%s AND lndmdlsgm_sgm=%s AND lndmdlsgm_mdl=%s
									   	LIMIT 1',
									   	GtSQLVlStr($this->__dtlnd->id, "int"),
									   	GtSQLVlStr($this->__dtsgm->id, "int"),
									   	GtSQLVlStr($this->__dtmdl->id, "int"));
									   
				$DtRg = $__cnx->_qry($query_DtRg); 
				
				if($DtRg){
					
					$row_DtRg = $DtRg->fetch_assoc(); 
					$Tot_DtRg = $DtRg->num_rows;	
					$Vl['tot'] = $Tot_DtRg;
					
					if($Tot_DtRg > 0){	
						$Vl['e'] = 'ok';
						$Vl['id'] = $row_DtRg['id_lndmdlsgm'];
						$Vl['enc'] = $row_DtRg['lndmdlsgm_enc'];
					}
					
				}else{
					
					$Vl['w'] = $__cnx->c_r->error;
	
				}
				$__cnx->_clsr($DtRg);
			}else{
				
				$Vl['m'] = 'No id';
				
			}
	
			return _jEnc($Vl);
		}
		
		
		
		
		//------------- Ingresar Segmento -------------//
		
		public function MdlSgm_In($p=NULL){
			
			global $__cnx; 
			
			$this->_GtInfo();
			
			//Si es logo se guarda el nombre de la imagen
			
			if($this->sgm->tp == "lnd_sgm_sve_lgo"){
				$LgoLs = GtLgoLs([ "id"=>$this->lndmdlsgm_vle, "tp"=>"enc" ]);
				$_vle = ctjTx($LgoLs->ls['0']->fle, 'out');
			}else if($this->sgm->tp == "lnd_sgm_sve_img"){
				$ImgLs = GtImgLs([ "id"=>$this->lndmdlsgm_vle, "tp"=>"enc" ]);
				$_vle = ctjTx($ImgLs->ls['0']->fle, 'out');
			}else{
				$_vle = ctjTx($this->lndmdlsgm_vle, 'out', '', ['html'=>'ok','schr'=>'no','nl2'=>'no','qte'=>'no']);
			}
			
			$__enc = Enc_Rnd($this->__dtlnd->id.'-'.$this->__dtmdl->id.'-'.$this->__dtsgm->id);
			
			$query_DtRg = sprintf("INSERT INTO ".TB_LND_MDL_SGM." (lndmdlsgm_enc, lndmdlsgm_lnd, lndmdlsgm_mdl, lndmdlsgm_sgm, lndmdlsgm_vle) VALUES (%s, %s, %s, %s, %s)",
						GtSQLVlStr($__enc, "text"),
						GtSQLVlStr($this->__dtlnd->id, "int"),
						GtSQLVlStr($this->__dtmdl->id, "int"),
						GtSQLVlStr($this->__dtsgm->id, "int"),
						GtSQLVlStr($_vle, "text"));

			//$rsp['q'] =	$query_DtRg;	
						
			$Result = $__cnx->_prc($query_DtRg);
					
			if($Result){	
				
				$rsp['id'] = $__cnx->c_p->insert_id;
				
				$query_DtRg_His = sprintf("INSERT INTO ".TB_LND_MDL_SGM_HIS." (lndmdlsgmhis_enc, lndmdlsgmhis_lndmdlsgm, lndmdlsgmhis_vle, lndmdlsgmhis_us) VALUES (%s, %s, %s, %s)",
						GtSQLVlStr(ctjTx(Gn_Rnd(20), 'out'), "text"),
						GtSQLVlStr(ctjTx($__cnx->c_p->insert_id, 'out'), "text"),
						GtSQLVlStr($_vle, "text"),
						GtSQLVlStr(SISUS_ID, "int"));
						
				$Result_His = $__cnx->_prc($query_DtRg_His);
				$rsp['e'] = 'ok';
				$rsp['m'] = 1;
				
			}else{
				$rsp['e'] = 'no';
				$rsp['m'] = 2;
				$rsp['w'] = $__cnx->c_p->error;
			}
			

			return _jEnc($rsp); 
			
		}
		
		
		//------------- Modificar Segmento -------------//
		
		public function MdlSgm_Mod($p=NULL){
			
			global $__cnx; 
			
			if($this->sgm->tp == "lnd_sgm_sve_img"){ //Si es logo se guarda el nombre de la imagen
				$ImgLs = GtImgLs([ "id"=>$this->lndmdlsgm_vle, "tp"=>"enc" ]);
				$_vle = $ImgLs->ls['0']->fle;	
			}else{
				$_vle = ctjTx($this->lndmdlsgm_vle, 'out', '', ['html'=>'ok','schr'=>'no','nl2'=>'no','qte'=>'no']);
			}
			
			if(!isN($this->lndmdlsgm_enc)){
				$query_DtRg = sprintf("UPDATE ".TB_LND_MDL_SGM." SET lndmdlsgm_vle=%s WHERE lndmdlsgm_enc=%s",
							GtSQLVlStr($_vle, "text"),
							GtSQLVlStr(ctjTx($this->lndmdlsgm_enc, 'out'), "text"));
							
				$Result = $__cnx->_prc($query_DtRg);
			}
					
			if($Result){	
				
				$query_DtRg_His = sprintf("INSERT INTO ".TB_LND_MDL_SGM_HIS." (lndmdlsgmhis_enc, lndmdlsgmhis_lndmdlsgm, lndmdlsgmhis_vle, lndmdlsgmhis_us) VALUES (%s, (SELECT id_lndmdlsgm FROM ".TB_LND_MDL_SGM." WHERE lndmdlsgm_enc = %s LIMIT 1), %s, %s)",
						GtSQLVlStr(ctjTx(Gn_Rnd(20), 'out'), "text"),
						GtSQLVlStr(ctjTx($this->lndmdlsgm_enc, 'out'), "text"),
						GtSQLVlStr($_vle, "text"),
						GtSQLVlStr(SISUS_ID, "int"));
						
				$Result_His = $__cnx->_prc($query_DtRg_His);
				$rsp['e'] = 'ok';
				$rsp['m'] = 1;
				
			}else{
				$rsp['e'] = 'no';
				$rsp['m'] = 2;
				$rsp['w'] = $__cnx->c_p->error;
			}
			
			return _jEnc($rsp); 
			
		}
		
		//------------- Ingresar atributo al segmento -------------//
		public function MdlSgm_In_Attr($p=NULL){
			
			global $__cnx; 
			
			$this->lndmdlsgmattr_enc = Enc_Rnd($this->lndmdlsgmattr_vle);
			
			$query_DtRg = sprintf("INSERT INTO ".MDL_LND_MDL_SGM_ATTR_BD." (lndmdlsgmattr_enc, lndmdlsgmattr_sgm, lndmdlsgmattr_attr, lndmdlsgmattr_vle) VALUES (%s, (SELECT id_lndmdlsgm FROM ".TB_LND_MDL_SGM." WHERE lndmdlsgm_enc = %s), %s, %s)",
						GtSQLVlStr(ctjTx($this->lndmdlsgmattr_enc, 'out'), "text"),
						GtSQLVlStr(ctjTx($this->lndmdlsgmattr_sgm, 'out'), "text"),
						GtSQLVlStr($this->lndmdlsgmattr_attr, "int"),
						GtSQLVlStr(ctjTx($this->lndmdlsgmattr_vle, 'out'), "text"));

			$Result = $__cnx->_prc($query_DtRg);
				
			if($Result){	
				
				$rsp['e'] = 'ok';
				$rsp['m'] = 1;
				
			}else{
				$rsp['e'] = 'no';
				$rsp['m'] = 2;
				$rsp['w'] = $__cnx->c_p->error;
			}
			
			return _jEnc($rsp); 
			
		}
		
		//------------- Modificar atributo al segmento -------------//
		public function MdlSgm_Mod_Attr($p=NULL){
			
			global $__cnx; 
			
			$query_DtRg = sprintf("UPDATE ".MDL_LND_MDL_SGM_ATTR_BD." SET lndmdlsgmattr_vle = %s WHERE lndmdlsgmattr_sgm IN (SELECT id_lndmdlsgm FROM ".TB_LND_MDL_SGM." WHERE lndmdlsgm_enc = %s) AND lndmdlsgmattr_attr = %s",
						GtSQLVlStr(ctjTx($this->lndmdlsgmattr_vle, 'out'), "text"),
						GtSQLVlStr(ctjTx($this->lndmdlsgmattr_sgm, 'out'), "text"),
						GtSQLVlStr($this->lndmdlsgmattr_attr, "int"));
						
			$Result = $__cnx->_prc($query_DtRg);
				
			if($Result){		
				$rsp['e'] = 'ok';
				$rsp['m'] = 1;
			}else{
				$rsp['e'] = 'no';
				$rsp['m'] = 2;
				$rsp['w'] = $__cnx->c_p->error;
			}
			
			return _jEnc($rsp); 
			
		}
		
		
		
		
		
		public function _GtInfo(){
			
			if(!isN($this->mdl_gen->id)){
				if($this->mdl_gen->t){ $_mdlgen_t = $this->mdl_gen->t; }else{ $_mdlgen_t = 'pm'; }
				$this->__dtmdlgen = GtMdlGenDt([ 't'=>$_mdlgen_t, 'id'=>$this->mdl_gen->id, 'bd'=>$this->bd, 'lnd'=>'ok' ]);
				$this->html->tt = $this->__dtmdlgen->mdl;
				$this->dfl->lnd->id = $this->__dtmdlgen->lnd->id;
			}
			
			if(!isN($this->mdl->id)){
				if($this->mdl->t){ $_mdl_t = $this->mdl->t; }else{ $_mdl_t = 'pml'; }
				$this->__dtmdl = GtMdlDt([ 't'=>$_mdl_t, 'id'=>$this->mdl->id, 'bd'=>$this->bd, 'lnd'=>'ok' ]);
				$this->html->tt = $this->__dtmdl->mdl;
				$this->dfl->lnd->id = $this->__dtmdl->lnd->id;
			}
			
			
			if(!isN($this->sgm->id)){
				if($this->sgm->t){ $_sgm_t = $this->sgm->t; }else{ $_sgm_t = 'id'; }
				$this->__dtsgm = __LsDt([ 'k'=>'sgm', 'id'=>$this->sgm->id, 'tp'=>$_sgm_t ])->d;
			}
			
			
			if(!isN($this->lnd->id) || !isN($this->dfl->lnd->id)){
				
				if($this->lnd->id){
					if($this->lnd->t){ $_lnd_t = $this->lnd->t; }else{ $_lnd_t = 'id'; }
					$__lnd_i = $this->lnd->id;
				}elseif(!isN($this->dfl->lnd->id)){
					$__lnd_i = $this->dfl->lnd->id;
				}
				
				$this->__dtlnd = GtLndDt([ 'cnx'=>$this->c_r, 'id'=>$__lnd_i, 't'=>$_lnd_t ]);
				
				if(!isN($this->__dtlnd->id)){
					
					if($this->__dtlnd->cl != $this->cl->id){ exit(); }
						
					$this->lnd_html = ctjTx( utf8_decode($this->__dtlnd->html) ,'in','', ['html'=>'ok','schr'=>'no','nl2'=>'no','qte'=>'no']);
					$this->__cod_nw = $this->lnd_html;
					
					$this->lnd_dir = $this->__dtlnd->dir;
					
					$this->js->async = [
						'main'=>$this->__dtlnd->js,
						'rdy'=>$this->__dtlnd->js_rdy,
						'ld'=>$this->__dtlnd->js_ld,
						'scrl'=>$this->__dtlnd->js_scrl
					];
					
					//------------------ Set Fonts to Use ------------------//
	
						$this->font = $this->__dtlnd->font;
					
					//------------------ Set CD Libraries ------------------//
					
						$this->cdn = $this->__dtlnd->cdn;
				
					//------------------ Return ------------------//
			
			
				}
			
			}
			
		}
		
		
	
		public function _bld(){
			
			$this->_GtInfo();
			
			
			$this->_Sgm();
			
			$this->_Pxl();
			$this->_Fx_Html();
		
			return $this->__cod_nw;						
		}
		
		
		public function _Pxl(){
			
			if($this->__dtmdlgen->pxl->tot > 0){	
				foreach($this->__dtmdlgen->pxl->ls as $_pxl_k=>$_pxl_v){
					if($_pxl_v->hed->e == 'ok'){ $__c_lnd->_Add_Hdr($_pxl_v->hed->cod); }				
					if($_pxl_v->bdy->e == 'ok'){ $__c_lnd->_Add_Bdy($_pxl_v->bdy->cod, ['tt'=>$_pxl_v->attr->tt] ); }
				}	
			}elseif($this->__dtmdl->pxl->tot > 0){	
				foreach($this->__dtmdl->pxl->ls as $_pxl_k=>$_pxl_v){
					if($_pxl_v->hed->e == 'ok'){ $__c_lnd->_Add_Hdr($_pxl_v->hed->cod); }				
					if($_pxl_v->bdy->e == 'ok'){ $__c_lnd->_Add_Bdy($_pxl_v->bdy->cod, ['tt'=>$_pxl_v->attr->tt] ); }
				}	
			}
					
		}
		
		
		private function _Sgm(){
			
			$this->rnd_enc = Enc_Rnd($this->__dtlnd->id.'-'.$this->mod->tab);
			
			$__sgm = __LsDt([ 'k'=>'sgm' ]);
			
			$this->__lsmdlsgm = GtLndMdlSgmLs([ "id_lnd"=>$this->__dtlnd->id, "lnd_tp"=>'id', "id_tab"=>$this->mod->tab, "tab_tp"=>"enc" ]);
			
			$r .= $this->__cod_nw;
			$__cod_c = $this->__cod_nw;
			
			foreach($__sgm->ls->sgm as $_k=>$_v){
				
				if($this->mod->e == "ok"){ $_tt = $_tt = ''; }
				
				$_s_acrt[$_v->id] = $_v->key->vl;
				
				$_s_attr_c = " data-sgm-enc='".$_v->enc."' data-sgm-tp='".$_v->tp->vl."' data-mdl-enc='".$this->__dtmdl->enc."' data-lnd-enc='".$this->__dtlnd->enc."' ";
				
				if($_v->tp_key->vl == "img_mdl"){
					
					$_c_acrt[$_v->id] = "<div class='_c_p _c_p_".$_v->tp_key->vl."' id='_c_p_".$_v->enc."' {$_s_attr_c}>
											<img src='".DMN_IMG_ESTR."_cl/mdl/th/".$this->mdl_img."?Rnd=".$this->rnd_enc."' >
										</div>";
				
				}else{
					
					$_c_acrt[$_v->id] = "<div class='_c_p' id='_c_p_".$_v->enc."' {$_s_attr_c}><span>".$_tt."</span></div>";
					
				}
				
			}

			if($this->mod->e == "ok"){ 
				$_dsgn = "<div class='opt'><div class='_dsgn _anm'></div></div>";
			}
			
			$r = str_replace($_s_acrt,$_c_acrt, $__cod_c);
		
			if($this->__lsmdlsgm){
				
				foreach($this->__lsmdlsgm as $_k => $_v){
				
					if($_v->tt != '' && $_v->tt != NULL){
						
						$_attr_sty = " style=\" ";
						foreach($_v->attr->{$_v->enc} as $_k_attr => $_v_attr){
							$_attr_sty .= $_k_attr.":".$_v_attr.";";
						}
						$_attr_sty .= " \" ";
						
						$_attr_prnt = " id='_c_p_".$_v->enc."' data-sgm-enc='".$_v->sgm->enc."' data-sgm-tp='".$_v->tp->tp->vl."' data-mdl-enc='".$this->__dtmdl->enc."' data-lnd-enc='".$this->__dtlnd->enc."' ";
					
						if($_v->tp->tp_key->vl == "sgm"){
							$r = str_replace($_c_acrt[$_k], "<div $_attr_sty class='_c_p' {$_attr_prnt}>
																$_dsgn <span>".$_v->tt."</span>".
															"</div>", $r);
						}elseif($_v->tp->tp_key->vl == "img"){
							$r = str_replace($_c_acrt[$_k], "<div class='_c_p' {$_attr_prnt}>
																$_dsgn <img $_attr_sty src='".DMN_FLE_LND_IMG.$_v->tt."?Rnd=".$this->rnd_enc."' >
															</div>", $r);
						}elseif($_v->tp->tp_key->vl == "ifrm"){
							$r = str_replace($_c_acrt[$_k], "<div $_attr_sty class='_c_p' {$_attr_prnt}>
																$_dsgn ".ctjTx("oee",'out','',['html'=>'ok']).
															"</div>", $r);
						}elseif($_v->tp->tp_key->vl == "img_mdl"){
							$r = str_replace($_c_acrt[$_k], "<div class='_c_p _c_p_".$_v->tp->tp_key->vl."' {$_attr_prnt}>
																$_dsgn <img $_attr_sty src='".DMN_FLE_LND_IMG.$_v->tt."?Rnd=".$this->rnd_enc."' >
															</div>", $r);
						}
						
					}
								
				}
			}
			
			$this->__cod_nw = $_sty.$_dsgn_sty.$r;	
				
		}
		
		
		public function _Font($_p=NULL){
			
			if(!isN($this->font) && $this->font->tot > 0){
				
				foreach($this->font->ls as $font_k=>$font_v){
					$____fmly[] = ['name'=>$font_v->font->cod, 'size'=>$font_v->font->sze, 'subset'=>$font_v->font->sbst];
				}
				
				$_r = __font([ 'fly'=>$____fmly ]);
				
			}else{
				
				$_r = __font();
				
			}
			
			$this->font_o = $_r->js;
		}
		
		
		public function _Js($_p=NULL){
	        
	        $this->_Font();
	        
	        if(!isN($this->font_o)){ 
				$__wfcnfg = "var WebFontConfig = {  google: {families:".$this->font_o->string."}, timeout:2000 };";
			}
	        
	        if($this->mod->e == "ok"){      
				$_mod_g_m = '_mod=ok';
		    }
		        
	        if(!isN($this->__dtlnd->enc)){
		        $__rcsc .= " SUMR_Ld.f.js({ u:'".DMN_LND_JS.$this->__dtlnd->enc."/?$_mod_g_m', c:function(){ "; 
	       		$__rcsc .= " SUMR_Ld.f.css({ t:'p', h:'".DMN_LND_CSS.$this->__dtlnd->enc."/?$_mod_g_m', c:function(){ ";
	        }
	            
	            
			$__rcsc_domrdy = '
			
				$(document).ready(function(){
					'.$this->js->async['rdy'].'
				});
				
				$(window).on("load",function(){
					'.$this->js->async['ld'].'
				});
				
				$(window).scroll(function () {
					'.$this->js->async['scrl'].'
				});
	
			';
			
		                        
			if(!isN($this->cdn)){
				
				$_js_brks=2; // Increase two numbers counting opened before ton general css and js

				if($this->cdn->tot > 0){
										
					foreach($this->cdn->ls as $cdn_k=>$cdn_v){
						
						$_js_deep = $_js_brks+1;
						
						if($cdn_v->cdn->up == 'ok'){
							$js_lcl = DMN_JS;
							$css_lcl = DMN_CSS;
						}else{
							$js_lcl = '';
							$css_lcl = '';
						}
						
						if($cdn_v->cdn->js == 'ok'){
							
							$__rcsc .= " SUMR_Ld.f.js({
								            u:'".$js_lcl.$cdn_v->cdn->url."',
								            c:function(){ ";
						
						}elseif($cdn_v->cdn->css == 'ok'){
							
							$__rcsc .= " SUMR_Ld.f.css({       
									        h:'".$css_lcl.$cdn_v->cdn->url."',
									        c:function(){ ";
								        
						}	     
						
						if($_js_deep == $this->cdn->tot){
							$__rcsc .= $__rcsc_domrdy;
						}

						$_js_brks++;
					
					}
					
					
				
				}else{
					
					$__rcsc .= $__rcsc_domrdy;
					
				}
				
				
				if(!isN($_js_brks)){
					for ($i=1; $i<=$_js_brks; $i++){
						$__rcsc .= "}	});";	
					}
				}	
			
			}
			
			
			
			$__r = "
	
				function __ld_all(){
					
					try{
						
						SUMR_Ld.f.js({
				            u:'https://ajax.googleapis.com/ajax/libs/webfont/1/webfont.js',
				            c:function(){	            
					        	".$__rcsc."					
						    }	    
					    });	
				    
				    }catch(e) {
					    
						SUMR_Main.log.w(e);
						
					}	
					
				}
				
				".$__wfcnfg."
			
			";
			
			return $__r; 
		}
		
		
		
		
		
		public function _Gt_Form(){
			
			$__form = _IfBld([ 
							'cl'=>$this->cl->prfl,
							'id'=>!isN($this->__dtmdl->enc)?$this->__dtmdl->enc:$this->__dtmdlgen->enc, 
							'g'=>(!isN($this->__dtmdlgen->enc)?'ok':'no'),
							'opq'=>$this->__dtlnd->fm->opq,
							'icn'=>$this->__dtlnd->fm->icn 
						]);
			
			return($__form);				
			
		}
	
		public function _Add_Hdr($v=NULL, $o=NULL){
			$this->js->head[] = [ 'v'=>$v, 'o'=>$o ];
		}
		
		public function _Add_Bdy($v=NULL, $o=NULL){
			$this->js->body[] = [ 'v'=>$v, 'o'=>$o ];
		}
	
	
	
		public function _Fx_Html($_r=NULL){
			
			if(!isN($this->__cod_nw)){
				
				$doc = new DOMDocument();
				$doc->loadHTML(mb_convert_encoding( $this->__cod_nw , 'HTML-ENTITIES', 'UTF-8'));
				
				
				$form = $this->_Gt_Form();
				$head = $doc->getElementsByTagName('head')->item(0);
				$body = $doc->getElementsByTagName('body')->item(0);
				
				//------------- CHANGE HEAD INFORMATION -------------//
					
					if(!isN($head)){
						$head_title = $doc->getElementsByTagName("title");
					    
					    if($head_title->length > 0) {
					        $head_title->item(0)->nodeValue = $this->html->tt;
					    }else{
							$title = $doc->createElement('title', $this->html->tt);
							if($head->hasChildNodes()){
								$head->insertBefore($title, $head->firstChild);
							}else{
								$head->appendChild($title);
							}
						}
					}
					
				//------------- CHANGE BASE URL -------------//
					
					
					$base = $doc->createElement('base');
					
					if(!isN($this->html->bse)){
						$base->setAttribute('href', DMN_HTTP.$this->html->bse);
					}else{
						$base->setAttribute('href', DMN_LND);
					}
					
					if($head->hasChildNodes()){
						$head->insertBefore($base, $head->firstChild);
					}else{
						$head->appendChild($base);
					}	
				
				//------------- CHANGE STY SOURCES -------------//
				
					$t_img = $doc->getElementsByTagName('link');
					foreach ($t_img as $tag) {
						$old_src = $tag->getAttribute('href');
						if(!isN($old_src)){
							$new_src_url = DMN_FLE_LND_HTML.$this->lnd_dir.'/'.$old_src; 
							if(!preg_match('/http:/',$old_src) && !preg_match('/https:/',$old_src)){
								$tag->setAttribute('href', $new_src_url);
							}
						}
					}
					
				//------------- CHANGE SCRIPT SOURCES -------------//
				
					$t_img = $doc->getElementsByTagName('script');
					foreach ($t_img as $tag) {
						$old_src = $tag->getAttribute('src');
						if(!isN($old_src)){
							$new_src_url = DMN_FLE_LND_HTML.$this->lnd_dir.'/'.$old_src;
							if(!preg_match('/http:/',$old_src) && !preg_match('/https:/',$old_src)){
								$tag->setAttribute('src', $new_src_url);
							}
						}
					}
						
				//------------- CHANGE IMG SOURCES -------------//
				
					$t_img = $doc->getElementsByTagName('img');
					foreach ($t_img as $tag) {
						$old_src = $tag->getAttribute('src');
						if(!isN($old_src)){
							$new_src_url = DMN_FLE_LND_HTML.$this->lnd_dir.'/'.$old_src; 
							if(!preg_match('/http:/',$old_src) && !preg_match('/https:/',$old_src)){
								$tag->setAttribute('src', $new_src_url);
							}
						}
					}	
				
				
				
				//------------- ADD SCRIPTS TO HTMLS -------------//
					
					
					if(!isN($this->js->head)){
						foreach($this->js->head as $_head_k=>$_head_v){
	
							if(!isN($_head_v['o']) && $_head_v['o']['tag'] == 'ok'){
								$ownjs = $doc->createElement('script', $_head_v['v']);
							}else{
								$ownjs = $doc->createCDATASection($_head_v['v']);
							}
											
							$head->appendChild($ownjs);
						}
					}
					
					
					if(!isN($this->js->body)){
						foreach($this->js->body as $_body_k=>$_body_v){
	
							if($_GET['Camilo']=='ok'){ 
								$ownjs = $doc->createCDATASection($_body_v['v']);
								$body->appendChild($ownjs); 
							}
						}
					}
	
				//------------- Return New HTML -------------//
				
				
				$_r_n = $doc->saveHTML();
				
				
				//------------- Return New HTML -------------//
				
				$_r_n = str_replace('[FORM]', $form->all, $_r_n);
				
				$this->__cod_nw = $_r_n;
			
			}
			
			
			return $this->__cod_nw;
		}
	
	
	
	}
	
	
?>