<?php 
 
class CRM_Dvrf extends CRM_Main{
    
          
    function __construct($p=NULL) { 

        parent::__construct();
		
		global $__cnx;    
		
		if(!isN($p['cl'])){ 
			$this->cl = GtClDt($p['cl']); 
			if(!isN($this->cl->bd)){ $this->bd=$this->cl->bd.'.'; }else{ $this->bd=''; }
		}

    }
    
    function __destruct() {
	    parent::__destruct();       
   	}
     
     
    public function NewCod($p=NULL){
	    
	    global $__cnx;
	    
	    $rsp['e'] = 'no';
	    
        if($this->cntdvrf_cnt){
	        
	        $__cod = Gn_Rnd(6);
	        $__enc = Enc_Rnd($this->cntdvrf_cnt.'-'.$__cod);
	        
	        if(!isN($this->cntdvrf_eml)){ $_eml = $this->cntdvrf_eml; }else{ $_eml = 2; }
	        if(!isN($this->cntdvrf_tel)){ $_tel = $this->cntdvrf_tel; }else{ $_tel = 2; }
	        
            $insertSQL = sprintf("INSERT INTO ".$this->bd.TB_CNT_DVRF." (cntdvrf_enc, cntdvrf_tp, cntdvrf_cnt, cntdvrf_cod, cntdvrf_eml, cntdvrf_tel) VALUES (%s, %s, %s, %s, %s, %s)",
                           GtSQLVlStr( $__enc, "text"),
                           GtSQLVlStr( $this->cntdvrf_tp, "text"),
                           GtSQLVlStr( $this->cntdvrf_cnt, "int"),
                           GtSQLVlStr( $__cod, "text"),
						   GtSQLVlStr( $_eml, "int"),
						   GtSQLVlStr( $_tel, "text"));
                                   
            $Result = $__cnx->_prc($insertSQL);
             
            if($Result){
	            $rsp['id'] = $__cnx->c_p->insert_id;
                $rsp['e'] = 'ok';
                $rsp['cod'] = $__cod;
                $rsp['m'] = 1;
            }else{
	            $rsp['q'] = $__cnx->c_p->error;
            }
        }else{
	         $rsp['w'] = 'No all data';
        }
         
        return _jEnc($rsp);    
    }
    
    
    
    public function UpdCod($p=NULL){
		
		global $__cnx;
		
		if(!isN($p['id'])){	
			
			if(!isN($p['hb'])){ $_upd[] = sprintf('cntdvrf_hb=%s', GtSQLVlStr($p['hb'], "int")); }
			
			if(!isN($_upd)){ 
				
				$updateSQL = sprintf("UPDATE ".$this->bd.TB_CNT_DVRF." SET ".implode(',', $_upd)." WHERE id_cntdvrf=%s",
								   GtSQLVlStr( $p['id'] , "int"));
								   
				$ResultUPD = $__cnx->_prc($updateSQL);
				
			}
			
			if($ResultUPD){
				$rsp['e'] = 'ok';
			}else{
				$rsp['e'] = 'no';
				$rsp['w'] = $__cnx->c_p->error;
			}
			
		}else{
			$rsp['e'] = 'no';
		}
			
		return _jEnc($rsp);	
	}
	
    
	   
}
     
?>