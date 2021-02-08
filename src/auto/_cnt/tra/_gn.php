<?php 

$_g_alw = $this->tallw([ 't'=>'key', 'id'=>'tra' ]);

if( $_g_alw->est == 'ok' ){

	//-------------------- REQUEST FILE --------------------//
	
	define('GRP_FL_TRA', '_cnt/tra/');

	if(!isN($this->g__t2)){ 

		$this->_Auto_Inc(GRP_FL_TRA.$this->g__t2.'.php');
		
	}else{
			
        $this->_Auto_Inc(GRP_FL_TRA.'tra_rsp.php');
			
	}

}else{

	echo $this->nallw('Global Module - Tasks - Off');

}

?>