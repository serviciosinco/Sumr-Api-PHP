<?php 

$_g_alw = $this->tallw([ 't'=>'key', 'id'=>'wbhk' ]);

if( $_g_alw->est == 'ok' ){

	//-------------------- REQUEST FILE --------------------//
	
	define('GRP_FL_WBHK', '_cnt/wbhk/');

	if(!isN($this->g__t2)){ 

		$this->_Auto_Inc(GRP_FL_WBHK.$this->g__t2.'.php');
		
	}else{
			
		$this->_Auto_Inc(GRP_FL_WBHK.'mdl_cnt.php');
		$this->_Auto_Inc(GRP_FL_WBHK.'mdl_cnt_est.php');
			
	}

}else{

	echo $this->nallw('Global Monitor Upload - Campaña de Envio - Off');

}

?>