<?php

$_g_alw = $this->tallw([ 't'=>'key', 'id'=>'dwn' ]);

if( $_g_alw->est == 'ok' ){

	//------------------- REQUEST FILE ---------------------//
	
	if(!isN($this->g__s2)){ 			
		
		$this->_Auto_Inc(GRP_FL_DWN.$this->g__s2.'.php'); 

	}else{
		
		$this->_Auto_Inc(GRP_FL_DWN.'cnt_appl.php');
		$this->_Auto_Inc(GRP_FL_DWN.'bd_rmv.php'); // Remove Table Ready	
		
	}

}else{

	echo $this->nallw('Global Downloads Off');

}		
		
?>