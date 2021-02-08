<?php 

$_g_alw = $this->tallw([ 't'=>'key', 'id'=>'cnt' ]);

if( $_g_alw->est == 'ok' ){

	//-------------------- REQUEST FILE --------------------//

	define('GRP_FL_CNT', '_cnt/cnt/');

	if(!isN($this->g__t2)){

		$this->_Auto_Inc(GRP_FL_CNT.$this->g__t2.'.php');
		
	}else{
			
		$this->_Auto_Inc(GRP_FL_CNT.'dvrf.php');
		$this->_Auto_Inc(GRP_FL_CNT.'hbs.php');
		$this->_Auto_Inc(GRP_FL_CNT.'mdl_lck.php');
			
	}

}else{

	echo $this->nallw('Global Leads Off');

}
	
?>