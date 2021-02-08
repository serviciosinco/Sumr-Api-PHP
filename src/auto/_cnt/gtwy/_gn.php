<?php 

$_g_alw = $this->tallw([ 't'=>'key', 'id'=>'gtwy' ]);

if( $_g_alw->est == 'ok' ){

	//-------------------- REQUEST FILE --------------------//
	
	define('GRP_FL_GTWY', '_cnt/gtwy/');

	if(!isN($this->g__t2)){ 

		$this->_Auto_Inc(GRP_FL_GTWY.$this->g__t2.'.php');
		
	}else{
			
		$this->_Auto_Inc(GRP_FL_GTWY.'mdl_cnt.php');
			
	}

}else{

	echo $this->nallw('Global Monitor Gateway - Off');

}

?>