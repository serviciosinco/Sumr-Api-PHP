<?php 
	 
	class CRM_Bld extends CRM_Slc{
	    
	    function __construct() {      
			parent::__construct();
	    }
	    
	    function __destruct() {
			parent::__destruct();
	   	}
			
	}
	
	$_bldr = new CRM_Bld();
?>