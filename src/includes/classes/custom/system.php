<?php 
	 
	class CRM_Sis {
	    
	    function __construct() { 
		    
		    global $__cnx;
	        
	        $this->c_r = $__cnx->c_r;
			$this->c_p = $__cnx->c_p;
			     
	        $this->_aud = new CRM_Aud();
			
	    }
	    
	    function __destruct() {

	   	}	
			
	}
?>