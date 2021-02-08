<?php  

class API_CRM_sms{
	

	private $user='serviciosin';
	private $password='Servi555';	
	//private $host = "https://gateway.plusmms.net/"; // URL UR
	private $wbhkurl = "";




	public function __construct($p=NULL){	
		
		global $__cnx;    
        $this->c_r = $__cnx->c_r;
		$this->c_p = $__cnx->c_p;
		
		
     	if($this->snd_nm == NULL){ $this->snd_nm = 'SUMR'; }	
     	
     	$this->id_rnd = '_'.Gn_Rnd(20);
     	
     	if(!isN($p['cl'])){ 
			$this->cl = GtClDt($p['cl']);
			if(!isN($this->cl->bd)){ $this->bd = _BdStr($this->cl->bd); }else{ $this->bd = ''; }
		}
        
    }
    
    
    function __destruct() {

   	} 	
  
	

	
	public function _SndSms_Chk($p=NULL){
		
		global $__cnx; 
		
		$Vl['e'] = 'no';
		
		if( !isN($this->snd_f) && !isN($this->snd_h) && !isN($this->snd_sms) && !isN($this->snd_cnt) && !isN($this->snd_eml) ){
			
			if(!isN($p['bd'])){ $__bd = _BdStr($p['bd']); }elseif(!isN($this->bd)){ $__bd = $this->bd; }
			
			$query_DtRg = sprintf('	SELECT * 
								   	FROM '.$__bd.TB_MDL_SMS_SND.' 
								   	WHERE smssnd_f=%s AND smssnd_h=%s AND smssnd_sms=%s AND smssnd_cnt=%s AND smssnd_eml=%s
								   	LIMIT 1', 
								   	GtSQLVlStr($this->snd_f, 'date'),
								   	GtSQLVlStr($this->snd_h, 'date'),
								   	GtSQLVlStr($this->snd_sms, 'int'),
								   	GtSQLVlStr($this->snd_cnt, 'int'),
								   	GtSQLVlStr(strtolower($this->snd_eml), 'text')
								);
								   
			$DtRg = $__cnx->_qry($query_DtRg); 
			
			//$Vl['q'] = $query_DtRg;
			
			if($DtRg){
				
				$row_DtRg = $DtRg->fetch_assoc(); 
				$Tot_DtRg = $DtRg->num_rows;	
				$Vl['tot'] = $Tot_DtRg;
				
				if($Tot_DtRg > 0){	
					$Vl['e'] = 'ok';
					$Vl['id'] = $row_DtRg['id_smssnd'];
					$Vl['enc'] = $row_DtRg['smssnd_enc'];
				}
				
			}else{
				
				$Vl['w'] = $this->c_r->error;

			}

			$__cnx->_clsr($DtRg);

		}else{
			
			$Vl['m'] = 'No id';
			
		}

		return _jEnc($Vl);
	}
	
	
	
	public function _MdlCntSms_Chk($p=NULL){
		
		global $__cnx; 
		
		$Vl['e'] = 'no';
		
		if( !isN($p['mdlcnt']) && !isN($p['smssnd']) ){
			
			if(!isN($p['bd'])){ $__bd = _BdStr($p['bd']); }elseif(!isN($this->bd)){ $__bd = $this->bd; }
			
			$query_DtRg = sprintf('	SELECT * 
								   	FROM '.$__bd.TB_MDL_CNT_SMS.' 
								   	WHERE mdlcntsms_mdlcnt = %s AND mdlcntsms_smssnd = %s
								   	LIMIT 1', 
								   	GtSQLVlStr($p['mdlcnt'], 'int'),
								   	GtSQLVlStr($p['smssnd'], 'int')
								);
								   
			$DtRg = $__cnx->_qry($query_DtRg); 
			
			if($DtRg){
				
				$row_DtRg = $DtRg->fetch_assoc(); 
				$Tot_DtRg = $DtRg->num_rows;	
				$Vl['tot'] = $Tot_DtRg;
				
				if($Tot_DtRg > 0){	
					$Vl['e'] = 'ok';
					$Vl['id'] = $row_DtRg['id_mdlcntsms'];
				}
				
			}else{
				
				$Vl['w'] = $this->c_r->error;

			}

			$__cnx->_clsr($DtRg);

		}else{
			
			$Vl['m'] = 'No id';
			
		}

		return _jEnc($Vl);
	}
	
	
	
	
	public function _SmsSndCmpg_Chk($p=NULL){
		
		global $__cnx; 
		
		$Vl['e'] = 'no';
		
		if( !isN($p['cmpg']) && !isN($p['smssnd']) ){
			
			if(!isN($p['bd'])){ $__bd = _BdStr($p['bd']); }elseif(!isN($this->bd)){ $__bd = $this->bd; }
			
			$query_DtRg = sprintf('	SELECT * 
								   	FROM '.$__bd.TB_SMS_SND_CMPG.' 
								   	WHERE smssndcmpg_cmpg=%s AND smssndcmpg_snd=%s
								   	LIMIT 1', 
								   	GtSQLVlStr($p['cmpg'], 'int'),
								   	GtSQLVlStr($p['smssnd'], 'int')
								); 
								   
			$DtRg = $__cnx->_qry($query_DtRg); 
			
			if($DtRg){
				
				$row_DtRg = $DtRg->fetch_assoc(); 
				$Tot_DtRg = $DtRg->num_rows;	
				$Vl['tot'] = $Tot_DtRg;
				
				if($Tot_DtRg > 0){	
					$Vl['e'] = 'ok';
					$Vl['id'] = $row_DtRg['id_smssndcmpg'];
				}
				
			}else{
				
				$Vl['w'] = $this->c_r->error;

			}

			$__cnx->_clsr($DtRg);

		}else{
			
			$Vl['m'] = 'No id';
			
		}

		return _jEnc($Vl);
	}
	
	
	public function _SndSMS($p=NULL){
		
		global $__cnx; 
		
		$rsp['e'] = 'no';
		
		if(!isN($this->snd_sms) && !isN($this->snd_cel)){
			
			if(!isN($this->snd_f)){ $__snd_f = $this->snd_f; }else{ $__snd_f = SIS_F; }
			if(!isN($this->snd_h)){ $__snd_h = $this->snd_h; }else{ $__snd_h = SIS_H2; }
			if(!isN($this->snd_us)){ $__snd_us = $this->snd_us; }else{ $__snd_us = SISUS_ID; }
			if(!isN($this->snd_c)){ $__snd_c = $this->snd_c; }else{ $__snd_c = 57; }
			if(!isN($this->snd_est)){ $__snd_est = $this->snd_est; }else{ $__snd_est = _CId('ID_SNDEST_PRG'); }
			if(!isN($this->snd_prty)){ $_prty = $this->snd_prty; }else{ $_prty = 2; }

			$__snd_cel = $__snd_c.$this->snd_cel;
			
			$__enc = Enc_Rnd($__snd_f.'-'.$__snd_h.'-'.$this->snd_nm.'-'.$this->snd_sms.'-'.$__snd_cel);
								
			if(!isN($p['bd'])){ $__bd = _BdStr($p['bd']); }elseif(!isN($this->bd)){ $__bd = $this->bd; }

			
			$insertSQL = sprintf("INSERT INTO ".$__bd.TB_SMS_SND." (smssnd_enc, smssnd_cnt, smssnd_sms, smssnd_est, smssnd_f, smssnd_h, smssnd_from, smssnd_msj, smssnd_cel, smssnd_snd, smssnd_prty) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
					               GtSQLVlStr($__enc, "text"),
					               GtSQLVlStr($this->snd_cnt, "int"),
					               GtSQLVlStr($this->snd_sms, "int"),
					               GtSQLVlStr($__snd_est, "int"),
					               GtSQLVlStr($__snd_f, "date"),
					               GtSQLVlStr($__snd_h, "date"),
					               GtSQLVlStr( ctjTx($this->snd_nm,'out') , "text"),
					               GtSQLVlStr( ctjTx($this->snd_msj,'out') , "text"),
								   GtSQLVlStr($__snd_cel, "text"),
								   GtSQLVlStr($__snd_us, "int"),
								   GtSQLVlStr($_prty, "int"));
			
			$rsp['q'] = $insertSQL;	
						   		
			$Result = $__cnx->_prc($insertSQL);
	 		
	 		if($Result){
		 		
				$rsp['i'] = $__cnx->c_p->insert_id;
				$this->snd_nw_id = $rsp['i'];
				
				$rsp['e'] = 'ok';
				$rsp['m'] = 1;
					
			}else{
				
				$rsp['e'] = 'no';
				$rsp['m'] = 2;
				$rsp['w'] = $__cnx->c_p->error;
				_ErrSis(['p'=>$insertSQL, 'd'=>$__cnx->c_p->error]);
				
			}
			
			
			
			if(!isN($rsp['i'])){
	
				if($p['t'] == 'mdl'){
					
					$__chk = $this->_MdlCntSms_Chk([ 'mdlcnt'=>$this->snd_mdlcnt, 'smssnd'=>$rsp['i'] ]);
					
					if(isN($__chk->id)){
						
						$__enc = Enc_Rnd($this->snd_mdlcnt.'-'.$rsp['i']);
						
						$insertSQL_Rlc = sprintf("INSERT INTO ".$__bd.TB_MDL_CNT_SMS." (mdlcntsms_enc, mdlcntsms_mdlcnt, mdlcntsms_smssnd) VALUES (%s, %s, %s)",
				               GtSQLVlStr($__enc, "text"),
				               GtSQLVlStr($this->snd_mdlcnt, "int"),
							   GtSQLVlStr($rsp['i'], "int"));
					
					}	   
										   
				}elseif($p['t'] == 'cmpg'){
					
					$__chk = $this->_SmsSndCmpg_Chk([ 'cmpg'=>$this->snd_cmpg, 'smssnd'=>$rsp['i'] ]);
					
					if(isN($__chk->id)){
						
						$__enc = Enc_Rnd($this->snd_mdlcnt.'-'.$rsp['i']);
						
						$insertSQL_Rlc = sprintf("INSERT INTO ".$__bd.TB_SMS_SND_CMPG." (smssndcmpg_cmpg, smssndcmpg_snd) VALUES (%s, %s)",
				               GtSQLVlStr($this->snd_cmpg, "int"),
							   GtSQLVlStr($rsp['i'], "int"));
						   
					}	   
						   
				}elseif($p['t'] == 'dvrf'){
					
					if(!isN($this->snd_tel_dvrf)){
	
						$insertSQL_Rlc = sprintf("UPDATE ".$this->bd.TB_CNT_DVRF." SET cntdvrf_tel_snd=%s WHERE id_cntdvrf=%s",
												GtSQLVlStr( $rsp['i'] , "int"),
												GtSQLVlStr( $this->snd_tel_dvrf , "int"));	
						
						//$rsp['qqqq----'] = $insertSQL_Rlc;
					}	   
						   
				}	
	
									   
				if(!isN($insertSQL_Rlc)){ 
					
					$Result = $__cnx->_prc($insertSQL_Rlc);
					
					if(!$Result){
						$rsp['e'] = 'no';
						$rsp['w_rlc'] = $__cnx->c_p->error;
					}
				}
				
				if($p['auto']=='ok'){ $rsp['u_o'] = __AutoRUN([ 't'=>'snd', 's2'=>'sms', '__i'=>$rsp['i'] ]); }	
				
			}else{
			
				$rsp['e'] = 'no';
				$rsp['m'] = 2;
				$rsp['w'] = $__cnx->c_p->error;
				_ErrSis(['p'=>$insertSQL, 'd'=>$__cnx->c_p->error]);
				
			}		
			
		}else{
			
			$rsp['w'] = 'no data';
			
		}
			
		
		return _jEnc($rsp);
		
	}
	
	
	public function _Upd_e($p=NULL){
		
		global $__cnx; 
		
		if(!isN($p['id'])){
			$updateSQL = sprintf("UPDATE ".TB_SMS_SND." SET smssnd_est=%s WHERE id_smssnd=%s",
					   GtSQLVlStr( $p['e'] , "int"),
					   GtSQLVlStr( $p['id'], "int"));
			$Result_UPD = $__cnx->_prc($updateSQL);
		}
	}
	
	
	public function _Upd($p=NULL){
		
		global $__cnx; 
		
		if(!isN($p['id'])){
			$updateSQL = sprintf("UPDATE ".TB_SMS_SND." SET smssnd_est=%s, smssnd_api_id=%s, smssnd_api_r=%s, smssnd_api_r_c=%s WHERE id_smssnd=%s",
					   GtSQLVlStr( $p['e'] , "int"),
					   GtSQLVlStr( ctjTx($p['a_id'],'out') , "int"),
					   GtSQLVlStr( ctjTx($p['a_r'],'out') , "text"),
					   GtSQLVlStr( ctjTx($p['a_r_c'],'out') , "text"),
					   GtSQLVlStr( $p['id'], "int"));
			$Result_UPD = $__cnx->_prc($updateSQL);
		}
	}
	
	private function _SndDt($p=NULL){
		
		global $__cnx; 
		
		if(!isN($p['id'])){
			
			$c_DtRg = "-1";if (isset($p['id'])){$c_DtRg = $p['id'];}

			$query_DtRg = sprintf('SELECT * FROM '.TB_SMS_SND.' WHERE id_smssnd = %s LIMIT 1', GtSQLVlStr($c_DtRg,'int'));
			$DtRg = $__cnx->_qry($query_DtRg); 
			
			if($DtRg){
				
				$row_DtRg = $DtRg->fetch_assoc(); 
				$Tot_DtRg = $DtRg->num_rows;	
				
				if($Tot_DtRg > 0){
					$Vl['id'] = $row_DtRg['id_smssnd'];
					$Vl['enc'] = ctjTx($row_DtRg['smssnd_enc'],'in');
					$Vl['msj'] = ctjTx($row_DtRg['smssnd_msj'],'in');
					$Vl['cel'] = ctjTx($row_DtRg['smssnd_cel'],'in');
					$Vl['from'] = ctjTx($row_DtRg['smssnd_from'],'in');
				}
			
			}

			$__cnx->_clsr($DtRg);

		}
		
		return _jEnc($Vl);
	}
	
	
	public function _UpdCmpg_e($p=NULL){
		
		global $__cnx; 
		
		if(!isN($p['id'])){
			$updateSQL = sprintf("UPDATE ".MDL_TB_SMS_CMPG_BD." SET smscmpg_est=%s WHERE id_smscmpg=%s",
					   GtSQLVlStr( $p['e'] , "int"),
					   GtSQLVlStr( $p['id'], "int"));
			$Result_UPD = $__cnx->_prc($updateSQL);
		}
	}
	
	private function __Chk_Tx($_p=NULL){
		
		$__prg = '/^[a-zA-Z0-9 :!\[\]@#¿!¡<>&"()$%{}*+,.;=\/?-]+$/';
		
	    if ( !preg_match($__prg, $_p['t']) ){
	    	$Vl['e'] = 'no';
    	}else{
	    	$Vl['e'] = 'ok';
    	}
    	
		return _jEnc($Vl);
	}

    private function UR_Connect(){
   		$this->conection = $this->host.$this->host_t;
    }
	
	
	
	
	
	public function _bld(){
		$this->_GtInfo();
		$this->_Msj();	
		return $this->__msj_nw;						
	}
	
	
	
	
	
	public function _GtInfo(){
		
		$this->__dtsms = GtSmsDt([ 'id'=>$this->id, 't'=>$this->id_t ]);
		
		if(isN($this->bd) && !isN($this->__dtsms->cl->bd)){ $this->bd = _BdStr($this->__dtsms->cl->bd); }
		
		if(!isN($this->mdlc)){ 
			
			$__mdlcnt_rlc = GtMdlCntDt([ 'id'=>$this->mdlc, 'bd'=>str_replace('.','',$this->bd), 'shw'=>[ 'attr'=>'ok', 'cnt'=>'ok' ] ]);	
			$this->d_mdlcnt = $__mdlcnt_rlc;
			$this->d_cnt = $__mdlcnt_rlc->cnt; 
				
			if(!isN($__mdlcnt_rlc->mdl->id)){ $this->mdli = $__mdlcnt_rlc->mdl->enc; }
			if(!isN($__mdlcnt_rlc->w)){ echo 'MdlCnt:'.$__mdlcnt_rlc->w; exit(); }
			
		}
		
		
		if(!isN($this->mdli)){ 
			
			$__mdl_rlc = GtMdlDt([  'src_main'=>__FILE__,
									'bd'=>str_replace('.','',$this->bd), 
									'id'=>$this->mdli, 
									't'=>'enc', 
									'cl'=>$this->cl->id, 
									'ec_crt'=>'ok', 
									'ec_fle'=>'ok', 
									'ec_crt_id'=>$this->__dtsms->id 
								]);
								
			$this->d_mdl = $__mdl_rlc; 
			
			if(!isN($__mdl_rlc->w)){ echo 'Mdl:'.$__mdl_rlc->w; exit(); }
			
		}
		
		
		if(!isN($this->snd_i)){
			
			$this->__dt_snd_i = GtSmsSndDt([ 'id'=>$this->snd_i, 'tp'=>'enc', 'bd'=>$this->bd ]); 
			
			if(!isN($__mdlcnt_rlc->w)){ echo 'Sndi:'.$__mdlcnt_rlc->w; exit(); }
			
			if(!isN($this->__dt_snd_i->mdlcnt)){
				
				if(!isN($this->__dt_snd_i->mdlcnt)){
					$__mdlcnt_rlc = $this->__dt_snd_i->mdlcnt;
					$this->d_mdlcnt = $__mdlcnt_rlc; 
					$this->d_cnt = $__mdlcnt_rlc->cnt;
				}
				
			}
		}
		
		if(!isN($this->dvrf)){ 
			$__dvrf_rlc = GtCntDvrfDt([ 'id'=>$this->dvrf, 'bd'=>$this->bd ]);
			$this->d_cntdvrf = $__dvrf_rlc; 
		}
		
		if( !isN($this->__dtsms->id) ){			
			$this->sms_id = $this->__dtsms->id;
			$this->sms_enc = $this->__dtsms->enc;	
			$this->__msj_nw = $this->__dtsms->msj;
		}
		

		if(!isN($this->plcy_id)){ 
			$__plcy_rlc = GtClPlcyDt([ 'id'=>$this->plcy_id ]);
			$this->d_clplcy = $__plcy_rlc; 
		}
		
		if(!isN($__mdlcnt_rlc->id) || !isN($__mdl_rlc)){

			if(!isN($__mdlcnt_rlc->cnt->enc)){ $this->ctj->cnt_enc = $__mdlcnt_rlc->cnt->enc; }
			if(!isN($__mdlcnt_rlc->cnt->nm)){ $this->ctj->cnt_nm = $__mdlcnt_rlc->cnt->nm; }
			if(!isN($__mdlcnt_rlc->cnt->ap)){ $this->ctj->cnt_ap = $__mdlcnt_rlc->cnt->ap; }
			if(!isN($__mdlcnt_rlc->cnt->dc)){ $this->ctj->cnt_dc = $__mdlcnt_rlc->cnt->dc; }
			
			if(!isN($this->d_mdlcnt->attr_o)){ $this->mdlcnt_attr = $this->d_mdlcnt->attr_o; }
			if(!isN($this->d_cnt->attr_o)){ $this->cnt_attr = $this->d_cnt->attr_o; }
			
			if(!isN($this->mdli) && !isN($this->d_mdl)){
				
				$this->mdl_id = $this->d_mdl->id;
				$this->mdl_nm = $this->d_mdl->tt;						
				$this->mdl_img = $this->d_mdl->img;
				$this->mdl_eml = $this->d_mdl->eml;
				$this->mdl_are = $this->d_mdl->are;
				$this->mdl_attr = $this->d_mdl->attr_o;
				
			}else{

				$this->mdl_eml = $__mdlcnt_rlc->eml;
				
				$this->nm_cnt = $rs->nombre;
				$this->ap_cnt = $rs->apellido;
				$this->md_cnt = GtSisMdDt([ 'id'=>$rs->SndMed ]);
				$this->md_c = GtSisMdDt([ 'id'=>$__mdlcnt_rlc->m ]);
				$this->eml_cnt = $rs->correoElectronico;
				$this->eml_c = $__mdlcnt_rlc->cnt->eml[0]->v;
				$this->doc_cnt = $rs->documento;
				$this->tel_cnt = $rs->telefonos;
				$this->tel_c = $__mdlcnt_rlc->cnt->tel[0];
				$this->cd_cnt = $rs->ciudad;
				$this->cd_c = $__mdlcnt_rlc->cnt->cd;
				$this->msj_cnt = $rs->comentarios;
				
			}
			
		}else{

			if(!isN($this->__dt_snd_i->cnt->enc)){ $this->ctj->cnt_enc = $this->__dt_snd_i->cnt->enc; }
			if(!isN($this->__dt_snd_i->cnt->nm)){ $this->ctj->cnt_nm = $this->__dt_snd_i->cnt->nm; }
			if(!isN($this->__dt_snd_i->cnt->ap)){ $this->ctj->cnt_ap = $this->__dt_snd_i->cnt->ap; }
			if(!isN($this->__dt_snd_i->cnt->dc)){ $this->ctj->cnt_dc = $this->__dt_snd_i->cnt->dc; }
			
		}
		
		$this->mdlcnt_sms_id = $this->__dt_snd_i->id;
		$this->mdlcnt_sms_enc = $this->__dt_snd_i->enc;
		//$this->mdlcnt_sms_enc = print_r($this->__dt_snd_i, true);
	}
	
	
	
	private function _Msj(){
		
		$__cod_c = $this->__msj_nw;

		//--------------- Modifica Campos Personalizados ---------------//	
			
			if($this->__dt_snd_i->hdr->tot > 0){	
				foreach($this->__dt_snd_i->hdr->tags as $_k=>$_v){
					$__cod_c = str_replace($_v->t,$_v->v, $__cod_c);	
				}
			}

		//--------------- Modifica Etiquetas Base - Tags a Buscar ---------------//	

			$_s[0] = '[NOMBRE]';
			$_s[1] = '[APELLIDO]';
			$_s[2] = '[MODULO_FIRMA]';
			$_s[3] = '[MODULO_NOMBRE]';
			$_s[4] = $__p_html->sch;

			$_s[6] = '[MODULO_EMAIL]';
			$_s[7] = '[MODULO RESPUESTA]';
			$_s[9] = '[MODULO_PAGO_DESCRIPCION]';
			$_s[10] = '@@@MODULO_ID@@@';
			$_s[12] = '[PUSHMAIL_FIRMA]';
			$_s[15] = '[PUSHMAIL_CODIGO]';
			$_s[16] = '[NOMBRE_USUARIO]';
			$_s[17] = '[MODULO_COLOR]';

			$_s[19] = '[IMG_MDL]';
			$_s[20] = '[EC_CMPG_ID]';
			$_s[21] = '[EC_CMPG_FRM]';
			$_s[22] = '[EC_CMPG_SNDR]';
			$_s[23] = '[EC_CMPG_PRHDR]';
			$_s[24] = '[EC_CMPG_RPLY]';
			$_s[25] = '[EC_CMPG_SBJ]';
			$_s[26] = '[EC_CMPG_F]';
			$_s[27] = '[EC_CMPG_H]';
			$_s[28] = '[EC_CMPG_LST]';
			$_s[29] = '[EC_CMPG_SGM]';
			$_s[30] = '[LINK_ACTON]';
			$_s[31] = '[EC_ID]';
			$_s[32] = '';
			$_s[33] = '[DOCUMENTO]'; 
			$_s[34] = '[MODULO]';	
			$_s[36] = '[LEAD_ENC]';
			$_s[50] = '[DVRF_COD]';
			$_s[51] = '[TICKED_ID]';
			$_s[52] = '[POLICY_ID]';
			
			
		//--------------- Modifica Etiquetas Base - Tags a Reemplazar ---------------//	
		
			$_c[0] = ucfirst($this->ctj->cnt_nm);
			$_c[1] = ucfirst($this->ctj->cnt_ap);
			
			if($this->mdl_sgn_on == 'ok'){  $_c[2] = $this->mdl_sgn; }else{ $_c[2] = ''; }
			$_c[3] = $this->mdl_nm;
			
			if(!isN($this->mdl_pay_url) && $this->mdl_pay_on == 'ok'){
				$_c[4] = $__p_html->nw;	
			}else{ 
				$_c[4] = ''; 
			}
			
			$_c[6] = $this->mdl_eml;
			$_c[7] = $this->mdl_rsp;	
			
			if($this->mdl_pay_dsc == 'ok'){  $_c[9] = $this->mdl_pay_dsc; }else{ $_c[9] = ''; }
			if($this->mdl_id != ''){  $_c[10] = $this->mdl_id; }else{ $_c[10] = ''; }
	
			if($this->ec_sign_on == 'ok'){ $_c[12] = $this->ec_sign; }else{ $_c[12] = '';}
			
			$_c[15] = $this->myec_cod;
			$_c[16] = $this->us_nm;
			$_c[17] = !isN($this->mdl_clr)?$this->mdl_clr : '#000';

			$_c[19] = $this->d_img;
			$_c[20] = $this->ctj->id_eccmpg;
			$_c[21] = $this->ctj->eccmpg_frm;
			$_c[22] = $this->ctj->eccmpg_sndr;
			$_c[23] = $this->ctj->eccmpg_prhdr;
			$_c[24] = $this->ctj->eccmpg_rply;
			$_c[25] = $this->ctj->eccmpg_sbj;
			$_c[26] = $this->ctj->eccmpg_p_f;
			$_c[27] = $this->ctj->eccmpg_p_h;
			$_c[28] = $this->ctj->eccmpg_lsts;
			$_c[29] = $this->ctj->eccmpg_sgm;
			$_c[30] = $this->ctj->lnk_acton; 
			$_c[31] = $this->ctj->id_ec; 
			$_c[32] = '';
			$_c[33] = base64_encode($this->cnt_dc);
			$_c[34] = base64_encode($this->mdl_cdc);
			$_c[36] = $this->ctj->cnt_enc;
			$_c[50] = $this->d_cntdvrf->cod;
			$_c[50] = $this->d_cntdvrf->cod;
			
			if(!isN($this->mdl_id)){  $_c[51] = $this->mdl_id; }else{ $_c[51] = ''; }
			if(!isN($this->d_clplcy->id)){  $_c[52] = $this->d_clplcy->id; }else{ $_c[52] = ''; }
			
			
		//--------------- Setea la variable r con el codigo ---------------//
		
			$new__cod = $__cod_c;		
			
			for($i=0; $i<=10; $i++){	
				$new__cod = str_replace($_s,$_c,$new__cod); // Cambia el Codigo del Cuerpo HTML			 
			}		
			
		//--------------- Seteo el codigo final ---------------//
			
			$this->__msj_nw = $new__cod;	
			

	}
	
	
	
	public function _SndSms_UPD($p=NULL){
		
		global $__cnx; 
		
		if(!isN($p['enc'])){
			
			if(!isN($p['msj'])){ $_upd[] = sprintf('smssnd_msj=%s', GtSQLVlStr(ctjTx($p['msj'], 'out'), "text")); }
			if(!isN($p['snd_id'])){ $_upd[] = sprintf('smssnd_id=%s', GtSQLVlStr($p['snd_id'], "text")); }
			if(!isN($p['est'])){ $_upd[] = sprintf('smssnd_est=%s', GtSQLVlStr($p['est'], "text")); }
					
			if(count($_upd) > 0){
				
				try {	

					$updateSQL = "UPDATE ".$this->bd.TB_SMS_SND." SET ".implode(',', $_upd)." WHERE smssnd_enc=".GtSQLVlStr( $p['enc'] , "text");	
					$ResultUPD = $__cnx->_prc($updateSQL);
					
				} catch (Exception $e) {
			
					$rsp['w'] = $e->getMessage();
		
				}
			
			}
			
			if($ResultUPD){
				$rsp['e'] = 'ok';
			}else{
				$rsp['w'] = $__cnx->c_p->error;
				$rsp['e'] = 'no';
			}
			
		}else{
			
			$rsp['e'] = 'no';
			$rsp['w'] = 'no all data';
			
		}
			
		return _jEnc($rsp);	
	}
	
	
	
}
?>