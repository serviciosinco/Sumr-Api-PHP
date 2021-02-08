<?php
	
class CRM_Shrt extends CRM_Main {		
		
	function __construct($p=NULL) { 
		
		global $__cnx;    
		
		if(!isN($p['cl'])){ 
	        $this->cl = GtClDt($p['cl'], 'enc');
	        if(!isN($this->cl->bd)){ $this->bd = _BdStr($this->cl->bd); }else{ $this->bd = ''; }
	    }
	    
	}
	
	
	function __destruct() {
		parent::__destruct();
	}
	

	public function in(){
		
		global $__cnx;
		
		$_r['e'] = 'no';
		
		if(!isN($this->urlw)){	
			
			$tryC = 1;		
			$Result = false;
			
			while($tryC <= 20){	
				
				$__cod = Gn_Rnd(4);
				$__enc = Enc_Rnd($__cod.'-'.$this->urlw);
				
				$insertSQL = sprintf("INSERT INTO "._BdStr(DBM).TB_SHRT." (shrt_enc, shrt_cod, shrt_url) VALUES (%s, %s, %s)",
				               GtSQLVlStr( ctjTx($__enc,'out') , "text"),
				               GtSQLVlStr( ctjTx($__cod,'out') , "text"),
				               GtSQLVlStr( ctjTx($this->urlw,'out') , "text"));
				               
				$Result = $__cnx->_prc($insertSQL);
				
				$tryC = $tryC + 1;
				
				if($Result){ break; }
				
			}
			
	 		if($Result){
		 		$_r['i'] = $__cnx->c_p->insert_id;
				$_r['e'] = 'ok';
				$_r['enc'] = $__enc;
				$_r['cod'] = $__cod;
			}else{
				$_r['w'] = $__cnx->c_p->error; 
			}
		
		}
		
		return _jEnc($_r);
	}	
	
	
	public function chk($p=NULL){
		
		global $__cnx;
		
		$_r['e'] = 'no';
		
		if( !isN($this->urlw) || !isN($this->cod) ){ 
			
			if(!isN($this->urlw)){ $__f .= sprintf(' AND shrt_url=%s ', GtSQLVlStr( ctjTx($this->urlw,'out') , "text")); }
			if(!isN($this->cod)){ $__f .= sprintf(' AND shrt_cod=%s ', GtSQLVlStr( ctjTx($this->cod,'out') , "text")); }
			
			$query_DtRg = sprintf('	SELECT * 
									FROM '._BdStr(DBM).TB_SHRT.'
									WHERE id_shrt != "" '.$__f.'
									LIMIT 1');		
		
			$DtRg = $__cnx->_qry($query_DtRg); 
		
			if($DtRg){
			
				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;
			
				if($Tot_DtRg == 1){
					$_r['e'] = 'ok';
					$_r['id'] = $row_DtRg['shrt_cod'];
					$_r['cod'] = $row_DtRg['shrt_cod'];
					$_r['url'] = ctjTx($row_DtRg['shrt_url'],'in');
					$_r['urls'] = $this->dmn.$row_DtRg['shrt_cod'];
				}else{
					$_r['e'] = 'no_exst';
				}
				
			}else{
				$_r['w'] = $__cnx->c_r->error; 
			}

			$__cnx->_clsr($DtRg);
			
		}else{
			
			$_r['w'] = 'No data on P';	
			
		}
		
		return _jEnc($_r);
	
	}
	
	public function gdmn(){
		
		$__chk = GtClDmnSubDt([ 'cl'=>$this->cl->enc, 't'=>'tp', 'id'=>'shrt' ]);
		
		if(isN($__chk->id) && !isN($this->cl->rsllr->enc)){
			$__chk = GtClDmnSubDt([ 'cl'=>$this->cl->rsllr->enc, 't'=>'tp', 'id'=>'shrt' ]);
		}
		
		if(!isN($__chk->id)){ $this->dmn = $__chk->url; }
		elseif(!isN($__chk->id)){ $this->dmn = $__chk->url; }
		else{ $this->dmn = DMN_SHRT; }
		
		return $__chk;
	}
	
	
	public function get($p=NULL){
		
		$_r['e'] = 'no';
		
		$this->gdmn();
		
		$this->urlw = $p['url']; // Url to work with
		$url_c = strlen($this->urlw);
		
		if($url_c <= 999){
			
			$__chk = $this->chk();
			
			if($__chk->e == 'no_exst'){
				
				$__chk = $this->in();
				
				if($__chk->e == 'ok'){
					$_r['e'] = 'ok';
					$_r['url'] = $this->dmn.$__chk->cod;	
				}else{
					$_r['w'] = 'no_prcs';
				}
				
			}else{
				
				$_r['url'] = $__chk->urls;
				
			}
			
		}else{
			
			$_r['w'] = 'Excede longitud'; 
			
		}
		
		
		return _jEnc($_r);
	}
	
}
	
	
?>