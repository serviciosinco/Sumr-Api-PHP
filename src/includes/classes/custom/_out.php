<?php 

ini_set("allow_url_fopen", 'On');
	
class CRM_Out {
	
	public $o_ctmout=5;
	public $o_tmout=30;
	public $o_header=array();
	public $o_vrbs=false;
	public $o_rtrn=true;
	public $o_vrfp=false;
	public $o_vrfh=2;
	public $o_post=false;
	
	function __construct() { 
		
		
	}
	
	
	function _Hdrs($r){
	    
	    $headers = array();
	    $header_text = substr($r, 0, strpos($r, "\r\n\r\n"));
	
	    foreach (explode("\r\n", $header_text) as $i => $line)
	        if ($i === 0){
	            $headers['http_code'] = $line;
			}else{
	            list ($key, $value) = explode(': ', $line);
	            $headers[$key] = $value;
	        }
	
	    return $headers;
	}
	
	
	public function _Rq($_p=null){

		try {
			
			if(!isN($this->o_auth->v)){
				$this->o_header_http[] = 'Authorization:Bearer '.$this->o_auth->v;
			}
			
			$c = curl_init();
			
			//Temporal - Arreglando descargas
			if( !isN($_p["twrk"]) && $_p["twrk"] == "njs" ){				
				$this->o_rtrn = true;
				$this->url = PRV_DMN_WRKR;
			}

			curl_setopt($c, CURLOPT_URL, $this->url);
			
			if(!isN($this->o_header)){ curl_setopt($c, CURLOPT_HEADER, $this->o_header);}
			curl_setopt($c, CURLOPT_CONNECTTIMEOUT, $this->o_ctmout);
			curl_setopt($c, CURLOPT_TIMEOUT, $this->o_tmout);
			curl_setopt($c, CURLOPT_SSL_VERIFYPEER, $this->o_vrfp);
			curl_setopt($c, CURLOPT_SSL_VERIFYHOST, $this->o_vrfh);
			curl_setopt($c, CURLOPT_VERBOSE, $this->o_vrbs);
			curl_setopt($c, CURLOPT_RETURNTRANSFER, $this->o_rtrn);

			if(!isN($this->o_ipv4) && $this->o_ipv4 == true){
				curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4 );
			}


			if($this->o_nobdy=='ok'){ curl_setopt($c, CURLOPT_NOBODY, true); }
			
			if($this->o_post){ 
				curl_setopt($c, CURLOPT_POST, $this->o_post);
			}
			
			if($this->o_encnull=='ok'){ curl_setopt($c, CURLOPT_ENCODING, ''); }
			
			if( !isN( $this->o_post_f ) ){
				if(!isN($this->o_post_f)){ curl_setopt($c, CURLOPT_POSTFIELDS, $this->o_post_f); }
			}

			if(!isN($this->o_crqst)){ curl_setopt($c, CURLOPT_CUSTOMREQUEST, $this->o_crqst); }
			if(!isN($this->o_header_http)){ curl_setopt($c, CURLOPT_HTTPHEADER, $this->o_header_http); }
			if(!isN($this->o_fllwlct)){ curl_setopt($c, CURLOPT_FOLLOWLOCATION, $this->o_fllwlct); }
			if($this->o_uagent_s == true){ curl_setopt($c, CURLOPT_USERAGENT, self::USER_AGENT); }
			
			if($this->demo!='ok'){ $__bck = curl_exec($c); }
			if($this->nobck != 'ok' && !isN($__bck)){ $r['rsl'] = $__bck; }
			
			$r['epnt'] = $this->url;
			$r['data'] = $this->o_post_f;
			$r['post'] = $this->o_post;

			$r['shdrs'] = $this->o_header_http;
			$r['rhdrs'] = $this->c_hdrs = $this->_Hdrs($__bck);
			$r['info'] = $this->c_info = curl_getinfo($c);
			$r['code'] = curl_getinfo($c, CURLINFO_HTTP_CODE);
			$r['type'] = $this->c_type = curl_getinfo($c, CURLINFO_CONTENT_TYPE);
			$r['error'] = $this->c_error = curl_error($c);
			$r['error_no'] = $this->c_error_no = curl_error($c);
			$r['error_msg'] = $this->c_error_msg = curl_strerror( $r['error_no'] );															
															
			if($this->out == 'json'){ $r['rsl'] = json_decode($r['rsl']); }
			
			curl_close($c);
			
			if($this->sve != 'no'){ $r['save'] = $this->_Sve(); }
		
		} catch (Exception $e) {
			    
		    $r['w'] = $e;
		    
		}

		return _jEnc($r);
	}
	
	public function _Sve($p=NULL){
		
		global $__cnx;
		
		if(!isN($p)){
			
			if(is_array($this->r_hdr)){ $__hdr = json_encode($this->r_hdr); }else{ $__hdr = $this->r_hdr; }
			if(is_array($this->r_post)){ $__post = json_encode($this->r_post); }else{ $__post = $this->r_post; }
			if(is_array($this->r_rsl)){ $__rsp = json_encode($this->r_rsl); }else{ $__rsp = $this->r_rsl; }
			if(is_array($this->r_info)){ $__info = json_encode($this->r_info); }else{ $__info = $this->r_info; }
			if(is_array($this->r_error)){ $__error = json_encode($this->r_error); }else{ $__error = $this->r_error; }
			
			$insertSQL = sprintf("INSERT INTO "._BdStr(DBM).TB_API_C." (apic_url, apic_us, apic_hdr, apic_info, apic_post, apic_rsp, apic_error, apic_ip) VALUES (%s, %s, %s, %s, %s, %s, %s, %s)",
								   GtSQLVlStr( $this->url, "text"),
								   GtSQLVlStr( ($this->r_us!=NULL?$this->r_us:3) , "int"),
								   GtSQLVlStr( $__hdr, "text"),
								   GtSQLVlStr( $__info, "text"),
								   GtSQLVlStr( $__post, "text"),
								   GtSQLVlStr( $__rsp, "text"),
								   GtSQLVlStr( $__error, "text"),
								   GtSQLVlStr(KnIp("on"), "text"));
								   
			$Result = $__cnx->_prc($insertSQL);
			
			if($Result){
				$rsp['e'] = 'ok';
			}else{
				$rsp['e'] = 'no';
			}	
		
		}
		
		return _jEnc($rsp);	

	}
}
	
?>