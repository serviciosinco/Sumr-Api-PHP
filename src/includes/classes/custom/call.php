<?php

class CRM_Call {
		
	function __construct($p=NULL){ 
		
		global $__cnx;    
        $this->c_r = $__cnx->c_r;
		$this->c_p = $__cnx->c_p;

		if(!isN($p['cl'])){ 
			if(is_array($p['cl'])){ 
				$this->cl = $p['cl'];
			}else{
				$this->cl = GtClDt($p['cl']); 
			}
			if(!isN($this->cl->bd)){ $this->bd = _BdStr($this->cl->bd); }else{ $this->bd=''; }
		}

	}

	function __destruct() {

   	}
	
	public function Sve(){
		
		$_r['sve']['main'] = $this->Call_In();
		
		if(!isN($this->mdlcnt)){
			$_r['sve']['mdlcnt'] = $this->Call_MdlCnt_In();
		}elseif(!isN($this->cnt)){
			$_r['sve']['cnt'] = $this->Call_Cnt_In();
		}
		
		$_r['i'] = $this->nw_id_call;
		$_r['u_all'] = $this->u_all;
			
		return _jEnc($_r);
	}
	
	
	public function Upd(){

		$_p = $this->Call_Audio_Est_Upd();
		
		$_r['call'] = $_p; 
		//$_r['u_all'] = $this->u_all;
			
		return _jEnc($_r);
	}
	
	public function Call_In($p=NULL){
		
		global $__cnx;
		
		$rsp['e'] = 'no';
		
		if(!isN($this->tel)){

			$__dtdc = $this->ChckCall([ 'sid'=>$this->sid ]);
			
			if($__dtdc->e == 'no'){
				
				$insertSQL = sprintf("INSERT INTO "._BdStr(DBT).TB_CALL." (call_us, call_tp, call_api, call_cl, call_enc, call_tel, call_sid, call_appsid, call_apiversion, call_caller, call_callstatus, call_phonenumber, call_duration, call_callduration) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
							   GtSQLVlStr($this->user, "int"),
							   GtSQLVlStr(_Cns('ID_CALLTP_A'), "int"),
							   GtSQLVlStr(_Cns('ID_APITHRD_TWL'), "int"),
		                       GtSQLVlStr($this->cl->id, "int"),
		                       GtSQLVlStr(enCad($this->sid), "text"),
		                       GtSQLVlStr($this->tel, "int"),
							   GtSQLVlStr($this->sid, "text"),
							   GtSQLVlStr($this->appsid, "text"),
							   GtSQLVlStr($this->apiversion, "text"),
							   GtSQLVlStr($this->caller, "text"),
							   GtSQLVlStr($this->callstatus, "text"),
							   GtSQLVlStr($this->phonenumber, "text"),
							   GtSQLVlStr($this->duration, "text"),
							   GtSQLVlStr($this->callduration, "text")); 		
				
				$Result = $__cnx->_prc($insertSQL); $this->u_all .= $insertSQL.' - '.$__cnx->c_p->error;
				
		 		if($Result){   		
			 		$this->nw_id_call = $__cnx->c_p->insert_id;		   
					$rsp['e'] = 'ok';
					$rsp['m'] = 1;
				}else{
					
					$rsp['m'] = 2;
					$this->w_all .= $__cnx->c_p->error;
				}	
			}else{
				$this->w_all .= TX_CLLRGST;
			}
			
		}else{	
			$rsp['m'] = 8;		
		}
		
		$rtrn = _jEnc($rsp); 
		if(!isN($rtrn)){ return($rtrn); }	
	}
	
	
	public function Call_MdlCnt_In(){ 
		
		global $__cnx;
		
		$Vl['e'] = 'no';
		
		if(!isN($this->mdlcnt)){
			
			$__HisIn = new CRM_Cnt([ 'cl'=>$this->cl->id ]);
			$__HisIn->mdlcnthis_mdlcnt = $this->mdlcnt;
			$__HisIn->mdlcnthis_tp = _CId('ID_HISTP_CALL');
			$__HisIn->mdlcnthis_us = $this->user;
			$__HisIn->mdlcnthis_dsc = TX_CLLCRM .' '. SIS_H;
			
			$PrcDt = $__HisIn->HisIn([ 't'=>'mdl' ]);
					
			if($PrcDt->e == 'ok'){	

				$insertSQL = sprintf("INSERT INTO ".$this->bd.TB_MDL_CNT_CALL." (mdlcntcall_mdlcnt, mdlcntcall_call, mdlcntcall_his) VALUES ( (SELECT id_mdlcnt FROM ".$this->bd.TB_MDL_CNT." WHERE mdlcnt_enc=%s) , %s, %s)",
				                       GtSQLVlStr($this->mdlcnt, "text"),
									   GtSQLVlStr($this->nw_id_call, "int"),
									   GtSQLVlStr($PrcDt->i, "int"));		

				$Result = $__cnx->_prc($insertSQL); 
				//$Vl['q'] = $insertSQL;
				
				$this->u_all .= $insertSQL.' - '.$__cnx->c_p->error;
				
				if($Result){   
					$Vl['e'] = 'ok';
					$Vl['id'] = $__cnx->c_p->insert_id;
				}else{
					$Vl['w'] = $__cnx->c_p->error;
				}	
			}
			
			
		}else{
			$Vl['r'] = 'no';
		}

		$rtrn = _jEnc($Vl);
		return($rtrn);
	}
	
	
	
	public function Call_Cnt_In(){
		
		global $__cnx;
		
		if(!isN($this->cnt)){
			
			$__HisIn = new CRM_Cnt();
			$__HisIn->cnthis_cnt = $this->cnt;
			$__HisIn->cnthis_tp = 1;
			$__HisIn->cnthis_us = $this->user;
			$__HisIn->cnthis_dsc = TX_CLLCRM . SIS_H;
			
			$PrcDt = $__HisIn->HisIn(['t'=>'cnt']);
					
			if($PrcDt->e == 'ok'){	

				$insertSQL = sprintf("INSERT INTO ".MDL_CALL_CNT_BD." (callcnt_cnt, callcnt_call, callcnt_his) VALUES (%s, %s, %s)",
				                       GtSQLVlStr($this->cnt, "int"),
									   GtSQLVlStr($this->nw_id_call, "int"),
									   GtSQLVlStr($PrcDt->i, "int"));			
						
				$Result = $__cnx->_prc($insertSQL); $this->u_all .= $insertSQL.' - '.$__cnx->c_p->error;
				
				if($Result){   
					$Vl['e'] = 'ok';
					$Vl['id'] = $__cnx->c_p->insert_id;
				}else{
					$Vl['e'] = 'no';
					$Vl['w'] = $__cnx->c_p->error;
				}	
			}
			
			
		}else{
			$Vl['r'] = 'no';
		}

		$rtrn = _jEnc($Vl);
		return($rtrn);
	}
	
	
	public function Call_Audio_Upd($_p=NULL){	
		
		global $__cnx;
		
		if(!isN($this->sid)){
			
			$_r['e'] = 'no';
			
			$__dtdc = $this->ChckCall([ 'sid'=>$this->sid ]);
			$__call = SUMR_Call.f.dt(['id'=>$this->sid]); 
			
			if(!isN($__call->mp3) && $__dtdc->est->id == 'completed'){ $__e = 1; }else{ $__e = 2; }
			
			if($__dtdc->est->id == 'completed'){

				$updateSQL = sprintf("UPDATE "._BdStr(DBT).TB_CALL." SET call_price=%s, call_audio=%s, call_audio_e=%s WHERE call_sid=%s",
									GtSQLVlStr( $__call->price, "text"),
									GtSQLVlStr( $__call->mp3, "text"),
								   	GtSQLVlStr( $__e, "int"),
								   	GtSQLVlStr( $this->sid, "text"));	
								   			   
				$ResultUPD = $__cnx->_prc($updateSQL);
				if($ResultUPD){ $_r['e'] = 'ok'; }

			}	
						
			$rtrn = _jEnc($Vl); return($_r);
		}
	}
	
	
	private function Call_Audio_Est_Upd(){	
		
		global $__cnx;
		
		$_r['e'] = 'no'; 

		if(!isN($this->sid)){
			
			$_r['upd']['audio'] = $this->Call_Audio_Upd();

			$updateSQL = sprintf("UPDATE "._BdStr(DBT).TB_CALL." SET call_callstatus=%s, call_duration=%s, call_callduration=%s WHERE call_sid=%s",
							   GtSQLVlStr( $this->callstatus, "text"),
							   GtSQLVlStr( $this->duration, "text"),
							   GtSQLVlStr( $this->callduration, "text"),
							   GtSQLVlStr( $this->sid, "text"));
							   				   
			$ResultUPD = $__cnx->_prc($updateSQL); 
			$this->u_all .= $__cnx->c_p->error.$updateSQL;
			
			if($ResultUPD){ $_r['e'] = 'ok'; }
			
		}
		
		$rtrn = _jEnc($_r); return($rtrn);
	}
	
	
	public function Upd_PhnAdd($_p=NULL){	
		
		global $__cnx;
		
		if($_p['id'] != NULL){
			if($_p['est'] == 'o'){ $__e = 1; }else{ $__e = 2; }

			$updateSQL = sprintf("UPDATE ".MDL_US_TEL_BD." SET ustel_est=%s WHERE id_ustel=%s",
							   GtSQLVlStr( $__e, "int"),
							   GtSQLVlStr( $_p['id'], "int"));				   
			$ResultUPD = $__cnx->_prc($updateSQL);
			if($ResultUPD){ $_r['e'] = 'ok'; }else{ $_r['e'] = 'no'; }
			$rtrn = _jEnc($Vl); return($rtrn);
			
		}
	}
	
	public function ChckCall($p=NULL){
		
		global $__cnx;
		
		$Vl['e'] = 'no';
		
		if(!isN($p['sid']) || !isN($p['id'])){	
				
			if(!isN($p['sid'])){ 
				$__f = 'call_sid'; $__ft = 'text'; $__id = $p['sid'];
			}elseif(!isN($p['id'])){  
				$__f = 'id_call'; $__ft = 'int'; $__id = $p['id'];
			}

			$query_DtRg = sprintf('SELECT * FROM '._BdStr(DBT).TB_CALL.' WHERE '.$__f.' = %s LIMIT 1', GtSQLVlStr($__id, $__ft));
			$DtRg = $__cnx->_qry($query_DtRg);
			
			if($DtRg){
				
				$row_DtRg = $DtRg->fetch_assoc(); 
				$Tot_DtRg = $DtRg->num_rows;
				
				$Vl['q_e'] = $__cnx->c_p->error;
				$this->w_all .= $__cnx->c_p->error;
				
				if($Tot_DtRg == 1){
					$Vl['e'] = 'ok';
					$Vl['id'] = $row_DtRg['id_call'];
					$Vl['est']['id'] = ctjTx($row_DtRg['call_callstatus'],'in');
					$Vl['tel'] = GtCntTelDt([ 'bd'=>$this->cl->bd, 'id'=>$row_DtRg['call_tel' ]]);
					$Vl['audio']['e'] = ctjTx($row_DtRg['call_audio_e'],'in');
					$Vl['audio']['f'] = ctjTx($row_DtRg['call_audio'],'in');
					
					if($row_DtRg['call_callstatus'] == 'initiated'){
						$Vl['est']['tt'] = TX_INICNDLL;	
						$Vl['est']['stt'] = TX_NUMBER.$Vl['tel']->telc;	
					}elseif($row_DtRg['call_callstatus'] == 'ringing'){
						$Vl['est']['tt'] = 'Timbrando';	
						$Vl['est']['stt'] = TX_NUMBER.$row_DtRg['call_phonenumber'];
					}elseif($row_DtRg['call_callstatus'] == 'in-progress'){
						$Vl['est']['tt'] = TX_CLLANSWR;	
						$Vl['est']['stt'] = TX_CLLNUMBR.$Vl['tel']->telc. TX_INPRGRS;
					}elseif($row_DtRg['call_callstatus'] == 'in-busy'){
						$Vl['est']['tt'] = TX_OCPD;	
						$Vl['est']['stt'] = TX_INTDNV;
					}
					
					
					$this->nw_id_call = $row_DtRg['id_call'];
					
				}	
			
			}else{
				
				$Vl['w'] = $__cnx->c_p->error;
				
			}

			$__cnx->_clsr($DtRg);
				
		}else{
			$Vl['e'] = 'no';
		}
		
		$rtrn = _jEnc($Vl);
		return($rtrn);
	}	
	

	public function CallRoom_Chk($p=NULL){
		
		global $__cnx;
		
		$Vl['e'] = 'no';
		
		if(!isN($p['unm']) || !isN($p['id']) || !isN($p['enc'])){	
				
			if(!isN($p['unm'])){
				$__f = 'callroom_unm'; $__ft = 'text'; $__id = $p['unm'];
			}elseif(!isN($p['enc'])){
				$__f = 'callroom_enc'; $__ft = 'text'; $__id = $p['enc'];
			}elseif(!isN($p['id'])){  
				$__f = 'id_callroom'; $__ft = 'int'; $__id = $p['id'];
			}

			$query_DtRg = sprintf('	SELECT id_callroom, callroom_enc, callroom_unm 
									FROM '._BdStr(DBT).TB_CALL_ROOM.' 
									WHERE '.$__f.' = %s 
									LIMIT 1', GtSQLVlStr($__id, $__ft));

			$DtRg = $__cnx->_qry($query_DtRg);
			
			if($DtRg){
				
				$row_DtRg = $DtRg->fetch_assoc(); 
				$Tot_DtRg = $DtRg->num_rows;
				
				if($Tot_DtRg == 1){
					$Vl['e'] = 'ok';
					$Vl['id'] = $row_DtRg['id_callroom'];
					$Vl['enc'] = $row_DtRg['callroom_enc'];
					$Vl['unm'] = $row_DtRg['callroom_unm'];
				}	
			
			}else{	
				$Vl['w'] = $__cnx->c_p->error;
			}

			$__cnx->_clsr($DtRg);
				
		}else{
			$Vl['w'] = 'No id for query';
		}
		
		return _jEnc($Vl);
	}


	public function CallRoom_In($p=NULL){
		
		global $__cnx;
		
		$rsp['e'] = 'no';
		
		if(!isN( $p['unm'] )){
				
			$__enc = Enc_Rnd(_Cns('ID_APITHRD_TWL').'-'.$p['unm'].'-'.$this->cl->id);

			$insertSQL = sprintf("INSERT INTO "._BdStr(DBT).TB_CALL_ROOM." (callroom_enc, callroom_api, callroom_cl, callroom_unm) VALUES (%s, %s, %s, %s)",
							GtSQLVlStr($__enc, "text"),
							GtSQLVlStr(_Cns('ID_APITHRD_TWL'), "int"),
							GtSQLVlStr($this->cl->id, "int"),
							GtSQLVlStr($p['unm'], "text")); 		
			
			$Result = $__cnx->_prc($insertSQL);
			
			if($Result){   		
				$this->nw_id_callroom = $rsp['id'] = $__cnx->c_p->insert_id;
				$rsp['enc'] = $__enc;	
				$rsp['unm'] = $p['unm'];	   
				$rsp['e'] = 'ok';
				$rsp['m'] = 1;
			}else{	
				$rsp['m'] = 2;
				$rsp['w'] = $__cnx->c_p->error;
			}
			
		}else{	
			$rsp['m'] = 8;		
		}
		
		if(!isN($rsp)){ return _jEnc($rsp); }	
	
	}


	public function CallRoom($p=NULL){

		if(!isN($p['cnt']) && !isN($this->cl->sbd)){

			$_nm_room = $this->cl->sbd.'-'.$p['cnt'];
			$_chk = $this->CallRoom_Chk([ 'unm'=>$_nm_room ]);

			if($_chk->e != 'ok'){
				$_in = $this->CallRoom_In([ 'unm'=>$_nm_room ]);
				if($_in->e == 'ok'){
					$rsp['id'] = $_in->id;
					$rsp['enc'] = $_in->enc;	
					$rsp['unm'] = $_in->unm;
				}else{
					$rsp['w'] = $_in->w;
				}

			}else{
				$rsp['id'] = $_chk->id;
				$rsp['enc'] = $_chk->enc;
				$rsp['unm'] = $_chk->unm;
			}

			if(!isN( $rsp['id'] )){
				if(!isN($p['url']) && $p['url']['cnt'] == 'ok'){ $_mre='&_c='.$p['cnt']; }
				if(!isN($p['url']) && $p['url']['us'] == 'ok'){ $_mre='&_us='.$p['us']; }
				$rsp['url'] = DMN_MEET.$this->cl->sbd.'/video/?room='.$rsp['enc'].$_mre;
			}

		}

		return _jEnc($rsp);

	}

}

	
?>