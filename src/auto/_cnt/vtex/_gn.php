<?php 

$_g_alw = $this->tallw([ 't'=>'key', 'id'=>'vtex' ]);

if( $_g_alw->est == 'ok' ){

	//------------------- REQUEST FILE ---------------------//	
		
	if(!isN($this->g__t2)){
		
		$this->_Auto_Inc(GRP_FL_VTEX.$this->g__t2.'.php');
	
	}else{
			
		$this->_Auto_Inc(GRP_FL_VTEX.'ord.php');
		$this->_Auto_Inc(GRP_FL_VTEX.'cnt.php');
		
	}

}else{

	echo $this->nallw('Global Vtex - Off');

}	
		
?>