<?php 

$_g_alw = $this->tallw([ 't'=>'key', 'id'=>'vtex_cmpg' ]);

if( $_g_alw->est == 'ok' ){

	//------------------- REQUEST FILE ---------------------//	
		
	if(!isN($this->g__s2)){  
		
		$this->_Auto_Inc(GRP_FL_VTEX.'cmpg/'.$this->g__s2.'.php');
	
	}else{
			
		$this->_Auto_Inc(GRP_FL_VTEX.'cmpg/ins_coup.php');
		$this->_Auto_Inc(GRP_FL_VTEX.'cmpg/ins_rfd.php');
		$this->_Auto_Inc(GRP_FL_VTEX.'cmpg/ins_rfd_coup.php');
		$this->_Auto_Inc(GRP_FL_VTEX.'cmpg/ins_rfd_ord.php');
		
	}

}else{

	echo $this->nallw('Global Vtex - Campaigns - Off');

}	
		
?>