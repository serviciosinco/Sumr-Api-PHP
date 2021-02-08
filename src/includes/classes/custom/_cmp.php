<?php 
	 
	class CRM_Cmp extends CRM_Cl{
	    
	    function __construct($p=NULL) {      
	        
	        global $__cnx;
	        $this->c_r = $__cnx->c_r;
			$this->c_p = $__cnx->c_p;
			
	        $this->_aud = new CRM_Aud();
			
			$this->cl = GtClDt( Gt_SbDMN(), "sbd");
	    }
	    
	    function __destruct() {
		}
		
		public function PlnCmpLs($p=NULL){
		
			$Vl['e'] = 'ok';	
			
			if( !isN($this->id_cmp) ){
			
				$query_DtRg = sprintf('SELECT * FROM '.TB_PLN_CMP.' WHERE plncmp_enc = %s LIMIT 1', GtSQLVlStr($this->id_cmp,'text'));
					   
				$DtRg = $__cnx->_qry($query_DtRg);
				
				if($DtRg){
					$row_DtRg = $DtRg->fetch_assoc(); 
					$Tot_DtRg = $DtRg->num_rows;	
					
					$Vl['tot'] = $Tot_DtRg;
			
					if($Tot_DtRg > 0){	
						$Vl['e'] = 'ok';
						$Vl['id'] = $row_DtRg['id_plncmp'];
						$Vl['enc'] = ctjTx($row_DtRg['plncmp_enc'],'in');
						$Vl['cod'] = ctjTx($row_DtRg['plncmp_cod'],'in');
						$Vl['kyw'] = $this->PlnCmpKyw_Ls();
					}
				}
				$__cnx->_clsr($DtRg);
			}
			
			return _jEnc($Vl);  	
		}
		public function PlnCmpKyw_Ls($p=NULL){
			$Vl['e'] = 'ok';	
			
			if( !isN($this->id_cmp) ){
			
				$query_DtRg = sprintf('SELECT * FROM '.TB_PLN_CMP_KYW.' 
												INNER JOIN '.TB_PLN_CMP_KYW_REL.' ON id_plncmpkyw = plncmpkywrel_kyw
												INNER JOIN '.TB_PLN_CMP.' ON id_plncmp = plncmpkywrel_plncmp
										WHERE plncmpkywrel_plncmp = (SELECT id_plncmp FROM '.TB_PLN_CMP.' WHERE plncmp_enc = %s)', 
										GtSQLVlStr($this->id_cmp,'text'));
					   
				$DtRg = $__cnx->_qry($query_DtRg);
				
				if($DtRg){
					$row_DtRg = $DtRg->fetch_assoc(); 
					$Tot_DtRg = $DtRg->num_rows;	
					
					$Vl['tot'] = $Tot_DtRg;
			
					if($Tot_DtRg > 0){	
						$Vl['e'] = 'ok';
						do{
							$Vl['ls'][$row_DtRg['plncmpkyw_enc']]['id'] = $row_DtRg['id_plncmpkyw'];
							$Vl['ls'][$row_DtRg['plncmpkyw_enc']]['enc'] = ctjTx($row_DtRg['plncmpkyw_enc'],'in');
							$Vl['ls'][$row_DtRg['plncmpkyw_enc']]['tt'] = ctjTx($row_DtRg['plncmpkyw_tt'],'in');
						}while($row_DtRg = $DtRg->fetch_assoc());
					}
				}
				$__cnx->_clsr($DtRg);
			}
			
			return _jEnc($Vl);    	
		}
		
		public function PlnCmpKyw_In($p=NULL){
			
			global $__cnx;
			
			$Vl['e'] = 'no';	
			
			if( !isN($this->id_cmp) ){
			
				$__enc = Enc_Rnd($this->id_cmp.' - Keyword');
			
				$insertSQL = sprintf("INSERT INTO ".TB_PLN_CMP_KYW." (plncmpkyw_enc, plncmpkyw_tt, plncmpkyw_plncmp) VALUES (%s, %s, (SELECT id_plncmp FROM ".TB_PLN_CMP." WHERE plncmp_enc = %s))",
			           GtSQLVlStr($__enc, "text"),
			           GtSQLVlStr(ctjTx($this->kyw_tt,'out'), "text"),
					   GtSQLVlStr($this->id_cmp, "text"));	
			
				$Result = $__cnx->_prc($insertSQL);
		
				if($Result){		
					$rsp['e'] = 'ok';
					$rsp['m'] = 1;
					$rsp['i'] = $__cnx->c_p->insert_id;
					
					$insertSQL = sprintf("INSERT INTO ".TB_PLN_CMP_KYW_REL." (plncmpkywrel_kyw, plncmpkywrel_plncmp) VALUES (%s,(SELECT id_plncmp FROM ".TB_PLN_CMP." WHERE plncmp_enc = %s))",
			           GtSQLVlStr(ctjTx($__cnx->c_p->insert_id,'out'), "int"),
					   GtSQLVlStr($this->id_cmp, "text"));	
					$Result = $__cnx->_prc($insertSQL);
					
				}else{
					$rsp['e'] = 'no';
					$rsp['m'] = 2;
					$rsp['w'] = $__cnx->c_p->error;
					$rsp['w_n'] = $__cnx->c_p->errno;
				}
				
				$rtrn = _jEnc($rsp);
				return($rtrn); 
			}   	
		}
		
			
		public function PlnCmpKyw_Eli($p=NULL){
			
			global $__cnx;
			
			$Vl['e'] = 'no';	
			
			if( !isN($this->id_cmp) ){
			
				$query_DtRg =   sprintf("DELETE FROM ".TB_PLN_CMP_KYW_REL." WHERE 
										plncmpkywrel_plncmp = (SELECT id_plncmp FROM ".TB_PLN_CMP." WHERE plncmp_enc = %s) 
										AND plncmpkywrel_kyw = (SELECT id_plncmpkyw FROM ".TB_PLN_CMP_KYW." WHERE plncmpkyw_enc = %s)",
								GtSQLVlStr($this->id_cmp, "text"),
								GtSQLVlStr($this->enc, "text"));	
				
				$Result = $__cnx->_prc($query_DtRg);	
					
				if($Result){	
					$rsp['e'] = 'ok';
					$rsp['m'] = 1;	
					$rsp['w_nd'] = $query_DtRg;
				}else{
					$rsp['e'] = 'no';
					$rsp['m'] = 2;
					$rsp['w'] = $__cnx->c_p->error;
					$rsp['w_n'] = $__cnx->c_p->errno;
					$rsp['w_nd'] = $query_DtRg;
				}
				
			}  
			
			return _jEnc($rsp);  
				 	
		}	
		
		
		public function PlnCmpKyw_Edt($p=NULL){
			
			global $__cnx;
			
			$Vl['e'] = 'no';	
			
			if( !isN($this->id_cmp) ){
			
				$updateSQL = sprintf("UPDATE ".TB_PLN_CMP_KYW." SET plncmpkyw_tt = %s WHERE 
										plncmpkyw_enc = %s AND plncmpkyw_plncmp = (SELECT id_plncmp FROM ".TB_PLN_CMP." WHERE plncmp_enc = %s)",
											GtSQLVlStr($this->tx, "text"),
											GtSQLVlStr($this->enc, "text"),
											GtSQLVlStr($this->id_cmp, "text"));	
				
				$Result = $__cnx->_prc($updateSQL);	
					
				if($Result){	
					$rsp['e'] = 'ok';
					$rsp['m'] = 1;	
					$rsp['qry'] = $updateSQL;	
				}else{
					$rsp['e'] = 'no';
					$rsp['m'] = 2;
					$rsp['w'] = $__cnx->c_p->error;
					$rsp['w_n'] = $__cnx->c_p->errno;
					$rsp['w_nd'] = $query_DtRg;
				}
				
			}   	
			
			return _jEnc($rsp);  
				
		}
		
				
		public function PlnCmpKyw_Sch($p=NULL){
		
			$Vl['e'] = 'ok';	
			
			
			if( !isN($this->id_cmp) ){
			
				$query_DtRg = 'SELECT * FROM '.TB_PLN_CMP_KYW.' LEFT JOIN '.TB_PLN_CMP_KYW_REL.' ON id_plncmpkyw = plncmpkywrel_kyw WHERE plncmpkyw_tt LIKE "%'.$this->tx.'%" AND id_pnlcmpkywrel IS NULL LIMIT 10';
				$DtRg = $__cnx->_qry($query_DtRg);
				$Vl['ec'] = $query_DtRg;
				if($DtRg){
					$row_DtRg = $DtRg->fetch_assoc(); 
					$Tot_DtRg = $DtRg->num_rows;	
					
					$Vl['tot'] = $Tot_DtRg;
			
					if($Tot_DtRg > 0){	 
						do{
							$Vl['ls'][$row_DtRg['plncmpkyw_enc']]['id'] = $row_DtRg['id_plncmpkyw'];
							$Vl['ls'][$row_DtRg['plncmpkyw_enc']]['enc'] = ctjTx($row_DtRg['plncmpkyw_enc'],'in');
							$Vl['ls'][$row_DtRg['plncmpkyw_enc']]['tt'] = ctjTx($row_DtRg['plncmpkyw_tt'],'in');
						}while($row_DtRg = $DtRg->fetch_assoc());
					}
				}
				$__cnx->_clsr($DtRg);
			}
			
			return _jEnc($Vl);  	
		} 
		public function PlnCmpKywMod_In($p=NULL){
			$Vl['e'] = 'no';	
			
			if( !isN($this->id_cmp) ){
				$insertSQL = sprintf("INSERT INTO ".TB_PLN_CMP_KYW_REL." (plncmpkywrel_kyw, plncmpkywrel_plncmp) VALUES ((SELECT id_plncmpkyw FROM ".TB_PLN_CMP_KYW." WHERE plncmpkyw_enc = %s),(SELECT id_plncmp FROM ".TB_PLN_CMP." WHERE plncmp_enc = %s))",
			           GtSQLVlStr($this->key_rel, "text"),
					   GtSQLVlStr($this->id_cmp, "text"));	
			
				$Result = $__cnx->_prc($insertSQL);
		
				if($Result){		
					$rsp['e'] = 'ok';
					$rsp['m'] = 1;
					$rsp['i'] = $__cnx->c_p->insert_id;
				}else{
					$rsp['e'] = 'no';
					$rsp['m'] = 2;
					$rsp['w'] = $__cnx->c_p->error;
					$rsp['w_n'] = $__cnx->c_p->errno;
				}
				
				$rtrn = _jEnc($rsp);
				return($rtrn); 
			}   	
		}
	}
?>