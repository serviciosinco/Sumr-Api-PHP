<?php 
	
class CRM_Webhook {
	
	
	function __construct() { 

    }
    
    function __destruct() {

    }
	
	
	public function _snd(){
		
		$CurlRQ = new CRM_Out();
		$CurlRQ->o_header_http = $this->o_header_http;
		$CurlRQ->demo = 'ok';
		$CurlRQ->url = $this->endpoint;
		$CurlRQ->out = 'json';
		
		if(!isN($this->data)){
			
			if(!isN($this->tkn)){
				$this->data['Token'] = $this->tkn;
			}
			
			$CurlRQ->o_post = true;
			$CurlRQ->o_post_f = json_encode($this->data); 
		}
	
		$rsp['rq'] = $CurlRQ->_Rq();
		
			
		return _jEnc($rsp);
		
				
	}
	
	
	public function _chk($p=NULL){
			
		if( !isN($this->wbhksnd_wbhk) && !isN($this->wbhksnd_id) && !isN($this->wbhksnd_d)){
			
			$Vl['e'] = 'no';
			
			$query_DtRg = sprintf('SELECT * 
								   FROM '.DBP.'.'.TB_WBHK_SND.' 
								   WHERE wbhksnd_wbhk = %s AND wbhksnd_id = %s AND wbhksnd_d = %s 
								   LIMIT 1', 
								   GtSQLVlStr($this->wbhksnd_wbhk,'int'), 
								   GtSQLVlStr($this->wbhksnd_id,'text'), 
								   GtSQLVlStr($this->wbhksnd_d,'text'));
								   
			$DtRg = $__cnx->_qry($query_DtRg);
			
			if($DtRg){
				
				$row_DtRg = $DtRg->fetch_assoc(); 
				$Tot_DtRg = $DtRg->num_rows;	
				
				$Vl['tot'] = $Tot_DtRg;

				if($Tot_DtRg > 0){	
					$Vl['e'] = 'ok';
					$Vl['id'] = $this->gt_id_wbhksnd = $row_DtRg['id_wbhksnd'];
					$Vl['enc'] = $this->wbhksnd_enc = ctjTx($row_DtRg['wbhksnd_enc'],'in').$icn;
					$Vl['rd'] = mBln($row_DtRg['wbhksnd_rd']);	
				}else{
					$_sve = $this->_sve();
					
					if(!isN($_sve->enc)){
						$Vl['e'] = 'ok';
						$Vl['enc'] = $this->wbhksnd_enc = $_sve->enc;
						$Vl['rd'] = mBln(2);
					}
				}
			}

			$__cnx->_clsr($DtRg);

		}

		return(_jEnc($Vl));
	}
		
		
	public function _sve($p=NULL){
		
		$rsp['e'] = 'no';
		
		if(!isN($this->wbhksnd_wbhk) && !isN($this->wbhksnd_id) && !isN($this->wbhksnd_d)){
			
			$_enc = Enc_Rnd($this->wbhksnd_wbhk.'-'.$this->wbhksnd_id);
			
			$insertSQL = sprintf("INSERT INTO ".TB_WBHK_SND." (wbhksnd_enc, wbhksnd_wbhk, wbhksnd_id, wbhksnd_d) VALUES (%s, %s, %s, %s)",
								   GtSQLVlStr( $_enc, "text"),
								   GtSQLVlStr( $this->wbhksnd_wbhk, "int"),
								   GtSQLVlStr( $this->wbhksnd_id, "int"),
								   GtSQLVlStr( $this->wbhksnd_d, "text"));

			$Result = $__cnx->_qry($insertSQL);
			
			//$rsp['q'] = $insertSQL;
			
			if($Result){
				$rsp['e'] = 'ok';
				$rsp['enc'] = $_enc;
			}
			
		}
		
		return _jEnc($rsp);	

	}
	
	
	public function _upd($p=NULL){
		
		$rsp['e'] = 'no';
		
		if(!isN($this->wbhksnd_enc)){
			
			if($this->wbhksnd_soap == 'ok'){
				$__rqu = ctjTx( $this->wbhksnd_rqu, 'out', '', ['html'=>'ok','schr'=>'no','nl2'=>'no']);
				$__r = ctjTx( $this->wbhksnd_r, 'out', '', ['html'=>'ok','schr'=>'no','nl2'=>'no']);
			}else{
				if(is_array($this->wbhksnd_rqu)){
					$__rqu = ctjTx(json_encode($this->wbhksnd_rqu), 'out');
					$__r = ctjTx(json_encode($this->wbhksnd_r), 'out');
				}else{
					$__rqu = ctjTx($this->wbhksnd_rqu, 'out');
					$__r = ctjTx($this->wbhksnd_r, 'out');
				}
			}
			
			$insertSQL = sprintf("UPDATE ".TB_WBHK_SND." SET wbhksnd_rqu=%s, wbhksnd_err_no=%s, wbhksnd_err_msg=%s, wbhksnd_err_str=%s, wbhksnd_r=%s, wbhksnd_r_info=%s, wbhksnd_r_code=%s, wbhksnd_r_hdrs=%s WHERE wbhksnd_enc=%s",
								   GtSQLVlStr( $__rqu, "text"),
								   GtSQLVlStr( ctjTx($this->wbhksnd_err_no, 'out'), "text"),
								   GtSQLVlStr( ctjTx($this->wbhksnd_err_msg, 'out'), "text"),
								   GtSQLVlStr( ctjTx($this->wbhksnd_err_str, 'out'), "text"),
								   GtSQLVlStr( ctjTx( $__r , 'out'), "text"),
								   GtSQLVlStr( ctjTx( json_encode($this->wbhksnd_r_info) , 'out'), "text"),
								   GtSQLVlStr( ctjTx($this->wbhksnd_r_code, 'out'), "text"),
								   GtSQLVlStr( ctjTx( json_encode($this->wbhksnd_r_hdrs) , 'out'), "text"),
								   GtSQLVlStr( $this->wbhksnd_enc, "text"));

			$Result = $__cnx->_qry($insertSQL);
			
			$rsp['q'] = $insertSQL;
			
			if($Result){
				$rsp['e'] = 'ok';
			}
			
		}
		
		return _jEnc($rsp);	

	}


	
	public function _rd($p=NULL){
		
		$rsp['e'] = 'no';
		
		if(!isN($this->wbhksnd_enc)){
			
			if($p['o']=='ok'){$__rd=1;}else{$__rd=2;}
			
			$insertSQL = sprintf("UPDATE ".TB_WBHK_SND." SET wbhksnd_rd=%s, wbhksnd_rd_f=%s WHERE wbhksnd_enc=%s",
								   GtSQLVlStr($__rd, "int"),
								   GtSQLVlStr(SIS_F_D2, "date"),
								   GtSQLVlStr($this->wbhksnd_enc, "text"));
								   
			$Result = $__cnx->_qry($insertSQL);
			
			$rsp['q'] = $insertSQL;
			
			if($Result){
				$rsp['e'] = 'ok';
			}
			
		}
		
		return _jEnc($rsp);	

	}



	
	
	function _r_hdrs($r){
	    
	    $headers = array();
	    $header_text = substr($r, 0, strpos($r, "\r\n\r\n"));
	
	    foreach (explode("\r\n", $header_text) as $i => $line)
	        if ($i === 0)
	            $headers['http_code'] = $line;
	        else
	        {
	            list ($key, $value) = explode(': ', $line);
	
	            $headers[$key] = $value;
	        }
	
	    return $headers;
	}
	
}
	
?>