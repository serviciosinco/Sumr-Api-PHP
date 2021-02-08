<?php 
	
	class CRM_Prc extends CRM_Main{
	         
	    function __construct() {
		    
		    parent::__construct();
	        
	        global $__cnx;	
	        
	        if(!isN($_POST['MM_insert'])){ $this->pst->mm_insert = Php_Ls_Cln($_POST['MM_insert']); }
	        if(!isN($_POST['MM_rndm'])){ $this->pst->rndm=Php_Ls_Cln($_POST['MM_rndm']); }else{ $this->pst->rndm=''; }
	        if(!isN($_POST["t2"])){ 
		        $this->pst->tsb = Php_Ls_Cln($_POST['t2']); 
				$this->mdlstp = GtMdlSTpDt([ 'tp'=>$this->pst->tsb ]);
		    }
				
	    }
	
		function __destruct() {
			parent::__destruct();
	   	}
	
		

	} 
  
?>