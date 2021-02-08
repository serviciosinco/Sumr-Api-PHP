<?php

class API_CRM_Snd{

	
	public function __construct($p=NULL){	
		
		global $__cnx;    
        $this->c_r = $__cnx->c_r;
		$this->c_p = $__cnx->c_p;
			
     	$this->id_rnd = '_'.Gn_Rnd(20);
        
     	if(!isN($p['cl'])){ 
			$this->cl = GtClDt($p['cl'], '', [ 'cnx'=>$this->c_r ]); 
			if(!isN($this->cl->bd)){ $this->bd = _BdStr($this->cl->bd); }else{ $this->bd = ''; }
		}   
		
    }


	function __destruct() {    

   	}



   	public function SgmVar($p=NULL){
   		
		$Vl['e'] = 'no';
		
		if( !isN($this->eclstsvar_enc) || !isN($this->id_eclstsvar) ){ 
			$__chk = $this->EcLstsVar_Chk();
			if(!isN($__chk->id)){
				$Vl['upd_prc'] = $__upd = $this->LstsVar_Upd();	
				if($__upd->e == 'ok'){ $Vl['upd']='ok'; $Vl['e']='ok'; }else{ $Vl['e']='no'; }
			}
		}else{ 
			$__chk = $this->SgmVar_Chk();
			if(!isN($__chk->id)){
				$Vl['upd_prc'] = $__upd = $this->SgmVar_Upd();	
				if($__upd->e == 'ok'){ $Vl['upd']='ok'; $Vl['e']='ok'; }else{ $Vl['e']='no'; }
			}
		}
		
		return(_jEnc($Vl));
	}
		
		
	public function SgmVar_Chk($p=NULL){
		
		global $__cnx;
		
		$Vl['e'] = 'no';
		
		if( !isN($this->id_eclstssgmvar) ){
			
			$query_DtRg = sprintf('	SELECT * 
								   	FROM '._BdStr(DBM).TB_EC_LSTS_SGM_VAR.' 
								   	WHERE id_eclstssgmvar = %s
								   	LIMIT 1', 
								   	GtSQLVlStr($this->id_eclstssgmvar,'int'));
								   
			$DtRg = $__cnx->_qry($query_DtRg);
			
			if($DtRg){
				
				$row_DtRg = $DtRg->fetch_assoc(); 
				$Tot_DtRg = $DtRg->num_rows;	
				$Vl['tot'] = $Tot_DtRg;
				
				if($Tot_DtRg > 0){	
					$Vl['e'] = 'ok';
					$Vl['id'] = $this->gt_id_eclstssgmvar = $row_DtRg['id_eclstssgmvar'];
					$Vl['enc'] = ctjTx($row_DtRg['eclstssgmvar_enc'],'in');
					$Vl['vl'] = ctjTx($row_DtRg['eclstssgmvar_vl'],'in');	
				}
			}
			
			$__cnx->_clsr($DtRg);

		}

		return _jEnc($Vl);
	}

	/* Filtro de listas para cargar leads */
	public function EcLstsVar_Chk($p=NULL){
		
		global $__cnx;
		
		$Vl['e'] = 'no';
		
		if( !isN($this->eclstsvar_enc) || !isN($this->id_eclstsvar) ){
			
			if( !isN($this->id_eclstsvar) ){
				$__fl = " AND id_eclstsvar = ".$this->id_eclstsvar." ";
			}else{
				$__fl = " AND eclstsvar_enc = '".$this->eclstsvar_enc."' ";
			}
			
			$query_DtRg = sprintf('	SELECT * 
								   	FROM '._BdStr(DBM).TB_EC_LSTS_VAR.' 
								   	WHERE id_eclstsvar != "" '.$__fl.'
								   	LIMIT 1 ');
			$DtRg = $__cnx->_qry($query_DtRg);
			
			if($DtRg){
				
				$row_DtRg = $DtRg->fetch_assoc(); 
				$Tot_DtRg = $DtRg->num_rows;	
				$Vl['tot'] = $Tot_DtRg;
				
				if($Tot_DtRg > 0){	
					$Vl['e'] = 'ok';
					$Vl['id'] = $this->gt_id_eclstsvar = $row_DtRg['id_eclstsvar'];
					$Vl['enc'] = ctjTx($row_DtRg['eclstsvar_enc'],'in');
					$Vl['vl'] = ctjTx($row_DtRg['eclstsvar_vl'],'in');	
				}
			}
			
			$__cnx->_clsr($DtRg);

		}

		return _jEnc($Vl);
	}

	/* Filtro de listas para cargar leads */
	public function LstsVar_In($p=NULL){
		
		global $__cnx;
		
		$rsp['e'] = 'no';
		
		if( !isN($this->eclstsvar_var) ){
	
			$__enc = Enc_Rnd( $this->eclstsvar_var.'-'.$this->eclstsvar_vl );
			
			$query_DtRg = sprintf("INSERT INTO "._BdStr(DBM).TB_EC_LSTS_VAR." (eclstsvar_enc, eclstsvar_lsts, eclstsvar_var, eclstsvar_vl) VALUES (%s, (SELECT id_eclsts FROM "._BdStr(DBM).TB_EC_LSTS." WHERE eclsts_enc = %s), %s, %s)",
							GtSQLVlStr($__enc, "text"),
							GtSQLVlStr($this->eclstsvar_lsts, "text"),
							GtSQLVlStr($this->eclstsvar_var, "int"),
							GtSQLVlStr( ctjTx($this->eclstsvar_vl,'out'),'text'));
				//echo $query_DtRg;
			$Result = $__cnx->_prc($query_DtRg);
					
			if($Result){
				$rsp['i'] = $this->gt_id_eclstsvar = $__cnx->c_p->insert_id;	
				$rsp['e'] = 'ok';
				$rsp['enc'] = $__enc;
				$rsp['m'] = 1;
			}else{
				$rsp['m'] = 2;
				$rsp['w'] = $__cnx->c_p->error;
				$rsp['w_n'] = $__cnx->c_p->errno;
			}
		
		}else{
			
			$rsp['w_m'] = 'No get data';
			
		}

		return _jEnc($rsp); 	
	}
		
	public function SgmVar_In($p=NULL){
		
		global $__cnx;
		
		$rsp['e'] = 'no';
		
		if( !isN($this->eclstssgmvar_sgm) && !isN($this->eclstssgmvar_var) ){
	
			$__enc = Enc_Rnd( $this->eclstssgmvar_sgm.'-'.$this->eclstssgmvar_var.'-'.$this->eclstssgmvar_vl );
			
			$query_DtRg = sprintf("INSERT INTO "._BdStr(DBM).TB_EC_LSTS_SGM_VAR." (eclstssgmvar_enc, eclstssgmvar_sgm, eclstssgmvar_var, eclstssgmvar_vl) VALUES (%s, %s, %s, %s)",
							GtSQLVlStr($__enc, "text"),
							GtSQLVlStr($this->eclstssgmvar_sgm, "int"),
							GtSQLVlStr($this->eclstssgmvar_var, "int"),
							GtSQLVlStr( ctjTx($this->eclstssgmvar_vl,'out'),'text'));
				
			$Result = $__cnx->_prc($query_DtRg);
					
			if($Result){
				$rsp['i'] = $this->gt_id_eclstssgmvar = $__cnx->c_p->insert_id;	
				$rsp['e'] = 'ok';
				$rsp['enc'] = $__enc;
				$rsp['m'] = 1;
			}else{
				$rsp['m'] = 2;
				$rsp['w'] = $__cnx->c_p->error;
				$rsp['w_n'] = $__cnx->c_p->errno;
			}
		
		}else{
			
			$rsp['w_m'] = 'No get data';
			
		}

		return _jEnc($rsp); 	
	}
	
	
	/* Filtro de listas para cargar leads */
	public function LstsVar_Upd($p=NULL){
	
		global $__cnx;
		
		$rsp['e'] = 'no';
		
		if(!isN($this->gt_id_eclstsvar)){							
			
			if(!isN($this->eclstsvar_vl)){ 
				$upd_f[] = sprintf('eclstsvar_vl=%s', GtSQLVlStr( ctjTx($this->eclstsvar_vl,'out'), "text")); 
			}
			
			if(!isN($this->eclstsvar_vl_sub)){ 
				$upd_f[] = sprintf('eclstsvar_vl_sub=%s', GtSQLVlStr( ctjTx($this->eclstsvar_vl_sub,'out'), "text")); 
			}
			
			if(!isN($upd_f)){
						
				$updateSQL = sprintf("UPDATE "._BdStr(DBM).TB_EC_LSTS_VAR." SET ".implode(',', $upd_f)." WHERE id_eclstsvar=%s",
	                                 GtSQLVlStr($this->gt_id_eclstsvar, "int")); 
	                                 
				$Result = $__cnx->_prc($updateSQL);
						
				if($Result){	
					$rsp['e'] = 'ok';
					$rsp['m'] = 1;	
				}else{
					$rsp['m'] = 2;
					$rsp['w'] = $__cnx->c_p->error;
					$rsp['w_n'] = $__cnx->c_p->errno;
				}
				
			}else{
			
				$rsp['w_m'] = 'No fields to update';
				
			}
		
		}else{
			
			$rsp['w_m'] = 'No get id';
			
		}
		
		return _jEnc($rsp);
	
	}
	
	public function SgmVar_Upd($p=NULL){
		
		global $__cnx;
		
		$rsp['e'] = 'no';
		
		if(!isN($this->gt_id_eclstssgmvar)){							
			
			if(!isN($this->eclstssgmvar_vl)){ 
				$upd_f[] = sprintf('eclstssgmvar_vl=%s', GtSQLVlStr( ctjTx($this->eclstssgmvar_vl,'out'), "text")); 
			}
			
			if(!isN($this->eclstssgmvar_vl_sub)){ 
				$upd_f[] = sprintf('eclstssgmvar_vl_sub=%s', GtSQLVlStr( ctjTx($this->eclstssgmvar_vl_sub,'out'), "text")); 
			}
			
			if(!isN($upd_f)){
						
				$updateSQL = sprintf("UPDATE "._BdStr(DBM).TB_EC_LSTS_SGM_VAR." SET ".implode(',', $upd_f)." WHERE id_eclstssgmvar=%s",
	                                 GtSQLVlStr($this->gt_id_eclstssgmvar, "int")); 
	                                 
				$Result = $__cnx->_prc($updateSQL);
						
				if($Result){	
					$rsp['e'] = 'ok';
					$rsp['m'] = 1;	
				}else{
					$rsp['m'] = 2;
					$rsp['w'] = $__cnx->c_p->error;
					$rsp['w_n'] = $__cnx->c_p->errno;
				}
				
			}else{
			
				$rsp['w_m'] = 'No fields to update';
				
			}
		
		}else{
			
			$rsp['w_m'] = 'No get id';
			
		}
		
		return _jEnc($rsp);
		
	}
	
	
	public function SgmVar_Del($p=NULL){
		
		global $__cnx;
		
		$rsp['e'] = 'no';
		
		if(!isN($this->eclstssgmvar_enc)){							
								
			$updateSQL = sprintf("DELETE FROM "._BdStr(DBM).TB_EC_LSTS_SGM_VAR." WHERE eclstssgmvar_enc=%s",
								 		 GtSQLVlStr($this->eclstssgmvar_enc, "text"));	
			$Result = $__cnx->_prc($updateSQL);
					
			if($Result){	
				$rsp['e'] = 'ok';
				$rsp['m'] = 1;	
			}else{
				$rsp['m'] = 2;
				$rsp['w'] = $__cnx->c_p->error;
				$rsp['w_n'] = $__cnx->c_p->errno;
			}
		
		}else{
			
			$rsp['w_m'] = 'No get id';
			
		}
		
		return _jEnc($rsp);
		
	}
	
	
	
	public function EcLstsVar_Del($p=NULL){
		
		global $__cnx;
		
		$rsp['e'] = 'no';
		
		if(!isN($this->eclstsvar_enc)){							
								
			$updateSQL = sprintf("DELETE FROM "._BdStr(DBM).TB_EC_LSTS_VAR." WHERE eclstsvar_enc=%s",
								 		 GtSQLVlStr($this->eclstsvar_enc, "text"));	
			$Result = $__cnx->_prc($updateSQL);
					
			if($Result){	
				$rsp['e'] = 'ok';
				$rsp['m'] = 1;	
			}else{
				$rsp['m'] = 2;
				$rsp['w'] = $__cnx->c_p->error;
				$rsp['w_n'] = $__cnx->c_p->errno;
			}
		
		}else{
			
			$rsp['w_m'] = 'No get id';
			
		}
		
		return _jEnc($rsp);
		
	}
	
	
	public function SisSgmVarTp_Dt($_p=NULL){	
		
		$_p = _jEnc($_p);
		
		
		$_sgm = GtEcSgmDt([ 'id'=>$_p->sgm, 't'=>'enc' ]);
		
		if( $_p->eclstsvar == 'ok' ){
			$_var = GtEcLstsVar([ 'id'=>$_p->var, 't'=>'enc' ]);
		}else{
			$_var = GtEcSgmVarDt([ 'id'=>$_p->var, 't'=>'enc' ]);
		}
		
		$_sis_sgm = GtSisEcSgmDt([ 'id'=>$_p->sis_sgm, 't'=>'enc' ]);
		$_sis_var = GtSisEcSgmVarDt([ 'id'=>$_p->sis_var, 't'=>'enc' ]);

		if(!isN($_sgm->id)){ $_r['sgm'] = $_sgm; }
		if(!isN($_var->id)){ $_r['var'] = $_var; }
		if(!isN($_sis_var->id)){ $_r['sis_var'] = $_sis_var; }
		
		
		if($_sis_var->tp->id == '3'){
			
			if($_sis_var->tp->dt == 'GtMdlDt'){
				
				$__dt = GtMdlDt([ 't'=>'enc', 'id'=>$_p->vle ]);
					
			}elseif($_sis_var->tp->dt == 'GtCntEstDt'){
				
				$__dt = GtCntEstDt([ 't'=>'enc', 'id'=>$_p->vle ]);
				
			}elseif($_sis_var->tp->dt == 'GtSisMdDt'){
				
				$__dt = GtSisMdDt([ 't'=>'enc', 'id'=>$_p->vle ]);
				
			}elseif($_sis_var->tp->dt == 'GtSisPsDt'){
				
				$__dt = GtSisPsDt([ 't'=>'enc', 'id'=>$_p->vle ]);
				
			}elseif($_sis_var->tp->dt == 'GtSisCdDt'){
				
				$__dt = GtCdDt([ 'tp'=>'enc', 'id'=>$_p->vle ]);
				
			}elseif($_sis_var->tp->dt == 'GtSisCdDpDt'){
				
				$__dt = GtCdDpDt([ 'tp'=>'enc', 'id'=>$_p->vle ]);
				
			}elseif($_sis_var->tp->dt == 'GtEcCmpgDt'){
				
				$__dt = GtEcCmpgDt([ 't'=>'enc', 'id'=>$_p->vle ]);
				
			}elseif($_sis_var->tp->dt == 'GtAtmtDt'){
				
				$__dt = GtAtmtDt([ 't'=>'enc', 'id'=>$_p->vle ]);
				
			}elseif($_sis_var->tp->dt == 'GtMdlSTpDt'){
				
				$__dt = GtMdlSTpDt([ 'id'=>$_p->vle ]);
				
			}elseif($_sis_var->tp->dt == 'GtClAreDt'){
				
				$__dt = GtClAreDt([ 'id'=>$_p->vle ]);
				
			}elseif($_sis_var->tp->dt == 'GtSisCntAttr'){
				
				$__dt = __LsDt(['k'=>'cnt_attr', 'id'=>$_p->vle, 'no_lmt'=>'ok'])->d;
				
			}elseif($_sis_var->tp->dt == 'GtMdlSPrdDt'){
				
				$__dt = GtMdlSPrdDt([ 'tp'=>'enc', 'id'=>$_p->vle ]);
				
			}elseif($_sis_var->tp->dt == 'GtCntTpDt'){
				
				$__dt = GtCntTpDt([ 't'=>'enc', 'id'=>$_p->vle ]);
				
			}elseif($_sis_var->tp->dt == 'GtCntEstTpDt'){
				
				$__dt = GtCntEstTpDt([ 't'=>'enc', 'id'=>$_p->vle ]);
				
			}
			
		}elseif($_sis_var->tp->id == '6'){
		
			$__dt = __LsDt([ 'k'=>'cld', 'id'=>$_p->vle, 'tp'=>'enc' ])->d;
			
		}elseif($_sis_var->tp->id == '2' || $_sis_var->tp->id == '7' || $_sis_var->tp->id == '9'){
			
			$_r['vle'] = $_p->vle;
				
		}
		
		
		if(!isN($__dt->id)){
			$_r['vle'] = $__dt->id;
		}
			
		
		//$_r['tmp']['vle'] = $__dt;
		
		
		//echo " --- ".json_encode($_r)." --- ";
		
		return _jEnc($_r);
	}
	
	
	
	
	
	public function _ec_cmpg_upd($p=NULL){
		
		global $__cnx;
		
		$rsp['e'] = 'no';
		
		if(!isN( $this->eccmpg_enc )){

			if(!isN( $this->eccmpg_tot_lds ) || $this->eccmpg_tot_lds == 0){ $_upd[] = sprintf('eccmpg_tot_lds=%s', GtSQLVlStr( $this->eccmpg_tot_lds , "int")); }
			if(!isN( $this->eccmpg_tot_nallw ) || $this->eccmpg_tot_nallw == 0){ $_upd[] = sprintf('eccmpg_tot_nallw=%s', GtSQLVlStr( $this->eccmpg_tot_nallw , "int")); }
					
			if(count($_upd) > 0){
				
				try {	

					$updateSQL = "UPDATE "._BdStr(DBM).TB_EC_CMPG." SET ".implode(',', $_upd)." WHERE eccmpg_enc=".GtSQLVlStr( $this->eccmpg_enc , "text");	
					$ResultUPD = $__cnx->_prc($updateSQL);
					
					//$rsp['qry'] = $updateSQL;
					
				} catch (Exception $e) {
			
					$rsp['w'] = $e->getMessage();
		
				}
			
			}else{
				
				$rsp['w'] = 'No data to update';
				
			}
			
			if($ResultUPD){
				$rsp['e'] = 'ok';
			}else{
				$rsp['w'] = $__cnx->c_p->error;
			}
			
		}else{

			$rsp['w'] = 'no all data';
			
		}
			
		return _jEnc($rsp);	
	}
	
	
	
	
}


?>