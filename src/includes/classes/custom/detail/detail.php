<?php 
	
	class CRM_Dt extends CRM_Main {
	         
	    function __construct() {
		    
		    parent::__construct();
				
	    }
	
		function __destruct() {
			
			parent::__destruct();
			 
	   	}
	   	
	   	
	   	public function _strt(){
		   	
			
			//-------------- SEARCH AND LOCK RELOAD  --------------//	
			
				$this->_sch();	
				$this->_bld_f_q();
					
			
		}

	} 
  
?>