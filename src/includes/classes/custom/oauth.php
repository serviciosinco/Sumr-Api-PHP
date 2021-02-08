<?php 
	
	class CRM_Oauth {
	         
	    function __construct() {	
		    
		    $this->__code = Php_Ls_Cln($_GET['code']);
		    $this->__cl = Php_Ls_Cln($_GET['_cl']);
			$this->__us = Php_Ls_Cln($_GET['_us']);
			$this->__eml = Php_Ls_Cln($_GET['_eml']);
	
			
			if(!isN($this->__cl)){ $_SESSION['oauth']['cl'] = $this->__cl; }
			if(!isN($this->__us)){ $_SESSION['oauth']['us'] = $this->__us; }
			if(!isN($this->__eml)){ $_SESSION['oauth']['eml'] = $this->__eml; }

			
			if(!isN($_SESSION['oauth']['cl']) && !isN($_SESSION['oauth']['us'])){
				setcookie(CKTRCK_OAUTH, json_encode($_SESSION['oauth']), time()+60, '/', Gt_DMN(), true, 'httponly');	
			}
			
	    }
	
		function __destruct() {
	   	}
	
		
	   	public function _Ses($p=NULL){	
		   	if(!isN($_SESSION['oauth'][$p])){
				return $_SESSION['oauth'][$p];
			}else{
				$__ck = json_decode($_COOKIE[CKTRCK_OAUTH]);
				return $__ck->{$p};
			}
	   	}
	   	
	   	
	   	public function _strt(){
			
			if(!isN( $this->_Ses('cl') )){ $__cl_get = $this->_Ses('cl'); }else{ $__cl_get = $this->__cl; }
			if(!isN($__cl_get)){ $this->dt->cl = GtClDt($__cl_get, 'enc'); }  
			
			if(!isN( $this->_Ses('us') )){ $__us_get = $this->_Ses('us'); }else{ $__us_get = $this->__us; }
			if(!isN($__cl_get)){ $this->dt->us = GtUsDt($$__us_get, 'enc'); }  
			
			if(!isN( $this->_Ses('eml') )){ $__eml_get = $this->_Ses('eml'); }else{ $__eml_get = $this->__eml; }
			if(!isN($__eml_get)){ $this->dt->eml = GtEmlDt([ 'id'=>$__eml_get, 't'=>'enc' ]); }  
				
		   	
	   	}
	   	
	} 
  
?>