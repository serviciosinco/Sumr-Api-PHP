<?php 


$_g_alw = $this->tallw([ 't'=>'key', 'id'=>'chat' ]);

if( $_g_alw->est == 'ok' ){

	//-------------------- REQUEST FILE --------------------//

	define('GRP_FL_CHAT', '_cnt/chat/');
	

	if(!isN($this->g__t2)){ 

		$this->_Auto_Inc(GRP_FL_CHAT.$this->g__t2.'.php');
		
	}else{
			
		$this->_Auto_Inc(GRP_FL_CHAT.'cnvr_us_exst.php');
			
	}	

}else{

	echo $this->nallw('Global Chat Off');

}
	
?>