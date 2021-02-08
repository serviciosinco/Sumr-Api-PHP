<?php 

$_g_alw = $this->tallw([ 't'=>'key', 'id'=>'mdl' ]);

if( $_g_alw->est == 'ok' ){

	//-------------------- REQUEST FILE --------------------//
	
	define('GRP_FL_MDL', '_cnt/mdl/');

	if(!isN($this->g__t2)){ 

		$this->_Auto_Inc(GRP_FL_MDL.$this->g__t2.'.php');
		
	}else{
			
        $this->_Auto_Inc(GRP_FL_MDL.'mdl_to_s3.php');
			
	}

}else{

	echo $this->nallw('Global Module - Tasks - Off');

}

?>