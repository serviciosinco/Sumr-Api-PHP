<?php  

class API_CRM_IT{

	
	//-------------- Datos de Conexion a ResellerClub --------------//
	
		private $rc_api = 'P0BNdf3bnpAMz4AbSiP5ZkW0tVj0UQY9';
		private $rc_usr = "405492";
		private $rc_url = "https://httpapi.com/api/";
	
	//-------------- Funciones Generales --------------//	
		
		public function Dtes_Btw($_p=NULL){
		
			$datetime1 = new DateTime($_p['f1']);
			$datetime2 = new DateTime($_p['f2']);
			$interval = $datetime1->diff($datetime2);
			
			$r['d'] = $interval->format('%R%a días');
			$r['n'] = $interval->format('%R') == '-'?'ok':'no';
			if($interval->format('%R') == '+'){
				$r['n_d'] = $interval->format('%a');
			}
			
			return (object)$r;
		}
		
		
		
	//-------------- Funciones ResellerClub --------------//
	
	
		public function _DmnS($_p=NULL){
			
			if(!isN($_p['dmn'])){	
				$this->RC_Connect([ 't'=>'d_dmn', 'dmn'=>$_p['dmn'] ]);
			}else{
				$this->RC_Connect([ 't'=>'a_dmn' ]);
			}
			
			$rc_url = $this->rc_conection;
			
			
			$CurlRQ = new CRM_Out();
			$CurlRQ->url = $rc_url;
			$CurlRQ->o_vrbs = true;
			$CurlRQ->o_tmout = 5;
			$rsp = $CurlRQ->_Rq();
			
			return json_decode($rsp->rsl);

		}
		
		public function _DmnDT(){
			foreach($this->dmn as $_k){
				$__r = $this->_DmnS([ 'dmn'=>$_k ]);
				if(!isN($__r->endtime)){ $rsp[] = (object)array('d'=>$__r->domainname, 't'=>$__r->endtime ); }
			}
			return (object)$rsp;
		}
		
		
		public function _DmnaLL(){
			$__r = $this->_DmnS();
			return $__r;
		}
		
		
	    private function RC_Connect($_p=NULL){
		    
		    if($_p['t'] == 'd_dmn'){
		    	$this->d_dmn = "domains/details-by-name.json?auth-userid=".$this->rc_usr."&api-key=".$this->rc_api."&domain-name=".$_p['dmn']."&options=OrderDetails";
	   		}elseif($_p['t'] == 'a_dmn'){
		   		$this->d_dmn = "domains/search.json?auth-userid=".$this->rc_usr."&api-key=".$this->rc_api."&no-of-records=500&page-no=1";
		   	}	
		   	
	   		
	   		$this->rc_conection = $this->rc_url.$this->d_dmn;
	    }
	
	
	
	//-------------- Funciones HostDime --------------//
	
		public function _ServerG($_d=NULL){
				
			$this->HDM_Connect([ 'm'=>'get' ]);
			$rc_url = $this->hdm_conection;
			$post['cuid'] = $this->hdm_srv;
	
			$_r2 = $this->HDM_Snd([ 'u'=>$rc_url, 'd'=>$post ]);		
			$rsp = (object)$_r2->response;
				
			return (object)$rsp;
	
		}
		
		
		public function _ServerS($_d=NULL){
				
			$this->HDM_Connect([ 'm'=>'mtr' ]);
			$rc_url = $this->hdm_conection;
			$post['cuid'] = $this->hdm_srv;
	
			$_r2 = $this->HDM_Snd([ 'u'=>$rc_url, 'd'=>$post ]);		
			$rsp['services'] = (object)$_r2->response->services;
			$rsp['filesystem'] = (object)$_r2->response->file_systems;
				
			return (object)$rsp;
	
		}
		
		
		public function _ServerB($_d=NULL){
				
			$this->HDM_Connect([ 'm'=>'bll' ]);
			$rc_url = $this->hdm_conection; 
			$post['status'] = 'open';

			$_r2 = $this->HDM_Snd([ 'u'=>$rc_url, 'd'=>$post ]);		
			$rsp = (object)$_r2->response;
			return (object)$rsp;
	
		}	
		
		public function HDM_Snd($_d=NULL){
				
			$_d['d']['api_key'] = $this->hdm_public_key;
			$_d['d']['api_timestamp'] = $this->hdm_tme;
			$_d['d']['api_unique'] = $this->hdm_unq; 
			$_d['d']['api_hash'] = $this->HDM_Hsh(
						[
							'd'=>$_d['d'],
							't'=>$this->hdm_tme,
							'u'=>$this->hdm_unq	
						]
					);
			
			$CurlRQ = new CRM_Out();
			$CurlRQ->url = $_d['u'];
			$CurlRQ->o_tmout = 5;
			$CurlRQ->o_post = true;
			$CurlRQ->o_post_f = $_d['d'];
			$CurlRQ->out = 'json';
			$rsp = $CurlRQ->_Rq();	
			
			$rsp = $rsp->rsl;
			return $rsp;
		}		
		
		public function HDM_Bld(){
			$tme = time();
			$unq = enCad(Gn_Rnd(20));
			$r['api_timestamp'] = $tme;
			$r['api_unique'] = $unq; 
			return (object)$r;	
		}
			
	    private function HDM_Connect($_p=NULL){
		    
		    if($_p['m'] == 'mtr'){
		    	$this->hdm_mtd = 'server/monitor';
				$this->hdm_mtdp = 'server.monitor';
			}elseif($_p['m'] == 'bll'){
		    	$this->hdm_mtd = 'billing/list';
				$this->hdm_mtdp = 'billing.list';
			}elseif($_p['m'] == 'get'){
		    	$this->hdm_mtd = 'server/get';
				$this->hdm_mtdp = 'server.get';
			}
			$__bld = $this->HDM_Bld();
			$this->hdm_tme = $__bld->api_timestamp;
			$this->hdm_unq = $__bld->api_unique;
	   		$this->hdm_conection = $this->hdm_url.$this->hdm_mtd.".json";
	    }    
		
		
		private function HDM_Hsh($_p=NULL){
			
		    $__api_a = ['api_key', 'api_timestamp', 'api_unique', 'api_hash'];

		    foreach($_p['d'] as $_k=>$_v){
			    if (!in_array($_k, $__api_a)) {
					$json[$_k] = $_v;
				}
			}

		    $__obj = json_encode(json_encode($json));
			
			$hsh_g = $_p['t'].':'.$_p['u'].':'.$this->hdm_private_key.':'.$this->hdm_mtdp.':'.$__obj;
			$hsh = hash('sha256', $hsh_g);
			
			return $hsh;
	    }
		
		
		
		//-------------- Funciones CloudFlare --------------//
		
		public function _CFR_Dtl($_d=NULL){	
			$this->CFR_Connect([ 'm'=>'dtl' ]);
			$rc_url = $this->cfr_conection;
			$_r2 = $this->CFR_Snd([ 'u'=>$rc_url, 'p_get'=>'ok' ]);		
			$rsp = (object)$_r2;
			return (object)$rsp->result;
		}
		
		public function CFR_Snd($_p=NULL){
				
			$CurlRQ = new CRM_Out();
			$CurlRQ->url = $_p['u'];
			$CurlRQ->o_tmout = 5;
			
			if(!isN($_p['d'])){
				$CurlRQ->o_post = true;
				$CurlRQ->o_post_f = json_encode($_p['d']);
			}
			if($_p['p_delete'] == 'ok'){
				$CurlRQ->o_crqst = "DELETE";
			}
			
			$CurlRQ->o_header_http = [
									    'X-Auth-Email: '.$this->cfr_eml,
									    'X-Auth-Key: '.$this->cfr_key,
									    'Content-Type: application/json'
									];
			$CurlRQ->out = 'json';
			$rsp = $CurlRQ->_Rq();
		
			return $rsp;		
		}
		

		
		private function CFR_Connect($_p=NULL){
		    
		    if($_p['m'] == 'prge'){
		    	$this->cfr_mtd = 'zones/'.$this->cfr_aco.'/purge_cache';
			}elseif($_p['m'] == 'dtl'){
		    	$this->cfr_mtd = 'zones/'.$this->cfr_aco;
			}
			

	   		$this->cfr_conection = $this->cfr_url.$this->cfr_mtd;
	    } 
	
	

}
?>