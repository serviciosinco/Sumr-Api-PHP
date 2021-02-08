<?php  

class API_CRM_Cdn{

	
	//---------------- Datos de Conexion a Cloudflare ----------------//
	
		private $cfr_url = "https://api.cloudflare.com/client/v4/";
		private $cfr_key = CLDFL_API_KEY;
		private $cfr_eml = "dominios@servicios.in";
		private $cfr_aco = CLDFL_API_ZNE;	
		
		
	//---------------- Funciones CloudFlare ----------------//
		
		
		public function _CFR_Prg($_d=NULL){	
			$this->CFR_Connect([ 'm'=>'prge' ]);
			$rc_url = $this->cfr_conection; 
			$post['files'] = $_d['f'];
			$_r2 = $this->CFR_Snd([ 'u'=>$rc_url, 'd'=>$post, 'p_delete'=>'ok' ]);
			$rsp = (object)$_r2->rsl;
			return $rsp;
		}
		
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