<?php 

$_g_alw = $this->tallw([ 't'=>'key', 'id'=>'vtex_ord' ]);

if( $_g_alw->est == 'ok' ){

	//------------------- REQUEST FILE ---------------------//	
		
	if(!isN($this->g__s2)){ 
		
		$this->_Auto_Inc(GRP_FL_VTEX.'ord/'.$this->g__s2.'.php');
	
	}else{
			
		$this->_Auto_Inc(GRP_FL_VTEX.'ord/ls.php');
		$this->_Auto_Inc(GRP_FL_VTEX.'ord/dt.php');
		$this->_Auto_Inc(GRP_FL_VTEX.'ord/upd.php');
		
	}

}else{

	echo $this->nallw('Global Vtex - Orders - Off');

}	
		
?>