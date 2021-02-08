<?php 

$_g_alw = $this->tallw([ 't'=>'key', 'id'=>'us' ]);

if( $_g_alw->est == 'ok' ){

	//------------------- REQUEST FILE ---------------------//	
		
	if(!isN($this->g__t2)){
		
		$this->_Auto_Inc(GRP_FL_US.$this->g__t2.'.php');
	
	}else{
		
		$this->_Auto_Inc(GRP_FL_US.'ntf.php');
		$this->_Auto_Inc(GRP_FL_US.'ntf_exp.php');
		
	}

}else{

	echo $this->nallw('Global Monitor - User Tasks - Off');

}	
		
?>