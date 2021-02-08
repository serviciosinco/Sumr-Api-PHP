<?php

$_g_alw = $this->tallw([ 't'=>'key', 'id'=>'dwn_mdl' ]);

if( $_g_alw->est == 'ok' ){

	//------------------- REQUEST FILE ---------------------//
	
	if(!isN($this->g__s3)){ 			
		
		$this->_Auto_Inc(GRP_FL_DWN.'mdl/'.$this->g__s3.'.php'); 

	}else{
		
		$this->_Auto_Inc(GRP_FL_DWN.'mdl/mdl_cnt.php');
		
	}
		
}else{

	echo $this->nallw('Global Downloads Off');

}		
		
?>