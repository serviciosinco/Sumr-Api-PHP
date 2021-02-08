<?php 
	 
	class CRM_Sgn {
	    
	    public $rnd_enc;
	    
	    function __construct() { 
	         
	        $this->_aud = new CRM_Aud();
	        
	    }
	    
	    //----------- Ingresar Landing -----------//
	    
		public function In_Sgn($p=NULL){
			
			global $__cnx;
			
			$this->rnd_enc = Gn_Rnd(20).Gn_Rnd(5);
			
			$query_DtRg = sprintf("INSERT INTO ".MDL_SGN_COD_BD." (sgncod_enc, sgncod_tt) VALUES ( %s, %s )",
							GtSQLVlStr(ctjTx($this->rnd_enc, 'out'), "text"),
							GtSQLVlStr(ctjTx($this->_tt,'out'), "text"));		
			
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
		
		public function Mod_Sgn($p=NULL){
			
			global $__cnx;
			
			$query_DtRg = sprintf("UPDATE ".MDL_SGN_COD_BD." SET sgncod_tt=%s WHERE sgncod_enc=%s",
							GtSQLVlStr(ctjTx($this->_tt, 'out'), "text"),
							GtSQLVlStr(ctjTx($this->_enc, 'out'), "text"));		
			
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
		
		public function Asg_Sgn($p=NULL){
			
			global $__cnx;
			
			$query_DtRg = sprintf("UPDATE ".MDL_SGN_COD_BD." SET sgncod_sgn=(SELECT id_sgn FROM sgn WHERE sgn_enc = %s) WHERE sgncod_enc=%s",
							GtSQLVlStr(ctjTx($this->id_sgn, 'out'), "text"),
							GtSQLVlStr(ctjTx($this->sgn, 'out'), "text"));		
			
			
			$Result = $__cnx->_prc($query_DtRg);
					
			if($Result){	
				
				$rsp['e'] = 'ok';
				$rsp['m'] = $query_DtRg;
				
			}else{
				$rsp['e'] = 'no';
				$rsp['m'] = 2;
				$rsp['w'] = $__cnx->c_p->error;
			}
			
			return _jEnc($rsp); 
		
			
			
		}
		
		public function Ins_Sgn_Sgm($p=NULL){
			
			global $__cnx;
			
			$this->rnd_enc = Gn_Rnd(20).Gn_Rnd(5);
			
			$query_DtRg = sprintf("INSERT INTO sgn_cod_sgm (sgncodsgm_enc, sgncodsgm_sgncod, sgncodsgm_sgm, sgncodsgm_vle ) VALUES ( %s, %s, %s, %s  )",
							GtSQLVlStr(ctjTx($this->rnd_enc, 'in'), "text"),
							GtSQLVlStr(ctjTx($this->enc, 'in'), "text"),
							GtSQLVlStr(ctjTx($this->id, 'in'), "text"),
							GtSQLVlStr(ctjTx($this->vle,'in'), "text"));
			
			
			
			$Result = $__cnx->_prc($query_DtRg);
			
				
			if($Result){	
				
				$rsp['e'] = 'ok';
				$rsp['m'] = 1;
				$rsp['vl'] = $this->vle;
				
			}else{
				$rsp['e'] = 'no';
				$rsp['m'] = 2;
				$rsp['w'] = $__cnx->c_p->error;
			}
			
			return _jEnc($rsp); 
		
			
			
		}
		
		public function Upd_Sgn_Sgm($p=NULL){
			
			global $__cnx;
			
			$query_DtRg = sprintf("UPDATE sgn_cod_sgm SET sgncodsgm_vle =%s WHERE sgncodsgm_sgm=%s AND sgncodsgm_sgncod=%s",
							GtSQLVlStr(ctjTx($this->vle, 'in'), "text"),
							GtSQLVlStr(ctjTx($this->id, 'in'), "int"),
							GtSQLVlStr(ctjTx($this->enc, 'in'), "int"));		
			
			
			$Result = $__cnx->_prc($query_DtRg);
			
				
			if($Result){	
				
				$rsp['e'] = 'ok';
				$rsp['m'] = $query_DtRg;
				$rsp['vl'] = $this->vle;
				
			}else{
				$rsp['e'] = 'no';
				$rsp['m'] = 2;
				$rsp['w'] = $__cnx->c_p->error;
			}
			
			return _jEnc($rsp); 
		
			
			
		}
		
		public function Eli_Sgn($p=NULL){
			
			global $__cnx;
			
			$query_DtRg = sprintf("UPDATE sgn_cod SET sgncod_est = 2 WHERE sgncod_enc=%s",
								GtSQLVlStr(ctjTx($this->id, 'in'), "text"));		
			
			
			$Result = $__cnx->_prc($query_DtRg);
			
				
			if($Result){	
				
				$rsp['e'] = 'ok';
				$rsp['m'] = $query_DtRg;
				$rsp['vl'] = $this->vle;
				
			}else{
				$rsp['e'] = 'no';
				$rsp['m'] = 2;
				$rsp['w'] = $__cnx->c_p->error;
			}
			
			return _jEnc($rsp); 
		
		
			
		}
		
	}
?>