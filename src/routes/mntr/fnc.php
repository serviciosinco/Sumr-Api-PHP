<?php 
	
	
	
	class CRM_Mntr{
		
		function __construct() {  
			$this->__rqur();
			$this->__insd(); 
			$this->__node_v(); 
	    }
	    
	    function __destruct() {
	   	}
		
		public function __rqur($p=NULL){
			
			$this->__rqu_modules = [
							    	[ 'name'=>'buffer', 'version'=>'5.2.1' ], 
							    	[ 'name'=>'express', 'version'=>'4.16.3' ], 
							    	[ 'name'=>'pm2', 'version'=>'3.1.2' ], 
							    	[ 'name'=>'fs', 'version'=>'0.0.1' ], 
							    	[ 'name'=>'http', 'version'=>'0.0.0' ], 
							    	[ 'name'=>'https', 'version'=>'1.0.0' ], 
							    	[ 'name'=>'minimist', 'version'=>'1.2.0' ], 
							    	[ 'name'=>'mysql', 'version'=>'2.16.0' ], 
							    	[ 'name'=>'socket.io', 'version'=>'2.1.1' ], 
							    	[ 'name'=>'utf8', 'version'=>'3.0.0' ], 
							    	[ 'name'=>'winston', 'version'=>'2.3.1' ],
							    	[ 'name'=>'xlsx-writestream' ]
							    ];
			
			$this->__rqu_modules = _jEnc($this->__rqu_modules);
		}
		
		
		public function __insd($p=NULL){
			
			exec("npm ls -g --depth 0", $modules); print_r($modules);

			foreach($modules as $modules_k=>$modules_v){
			    if (strpos($modules_v, '+--') !== false || strpos($modules_v, '@') !== false){
					
					if (strpos($modules_v, '+--') !== false){
						$__o = explode('+--', $modules_v);
					}
					
					if (strpos($modules_v, '`--') !== false){
						$__o = explode('`--', $modules_v);
					}
					
					
					$__o = explode('@', trim($__o[1])); 
					$__all_modules[$__o[0]] = [ 'name'=>$__o[0], 'version'=>$__o[1] ]; 	 
				}        
		    }
			
			$this->__all_modules = _jEnc($__all_modules);
			
		}	
		
		
		public function __node_v($p=NULL){
			
			exec('node -v', $version);
			$this->node_v = $version[0];
			
		}
		
		
		public function __node_install($p=NULL){
			
			$_r['nn'] = $p['nn'];

			if(!isN($p['nn'])){
				$_mdle = 'npm install '.$p['nn'].' -g';
				
				$r = shell_exec($_mdle);
				
				$_r['mdle'] = $_mdle;
				$_r['exec'] = $r;	
			}
			
			return _jEnc($_r);
		}
		
		
		
		
		public function __exst($p=NULL){    
			
			foreach($this->__rqu_modules as $_rqu_k=>$_rqu_v){
				
				$__v = $_rqu_v->version;
				
				
				if(!isN($this->__all_modules)){
					
					foreach($this->__all_modules as $_now_k=>$_now_v){
						
						if($_rqu_v->name == $_now_v->name){
							$__instaled_modules[$_rqu_v->name] = ['e'=>'ok', 'v'=>$__v];
							break;
						}else{
							$__instaled_modules[$_rqu_v->name] = ['e'=>'no', 'v'=>$__v];
						}
					}
					
				}else{
					
					$__instaled_modules[$_rqu_v->name] = ['e'=>'no', 'v'=>$__v];
					
				}

			}
			
			$this->__chk_modules = _jEnc($__instaled_modules);
		}	
		
	}
	
?>