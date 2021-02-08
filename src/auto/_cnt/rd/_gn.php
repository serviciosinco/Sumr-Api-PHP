<?php 

$_g_alw = $this->tallw([ 't'=>'key', 'id'=>'rd' ]);

if( $_g_alw->est == 'ok' ){

	//-------------------- REQUEST FILE --------------------//

	define('GRP_FL_RD', '_cnt/rd/');

	if(!isN($this->g__t2)){

		$this->_Auto_Inc(GRP_FL_RD.$this->g__t2.'.php');
		
	}else{
			
		$this->_Auto_Inc(GRP_FL_RD.'rd_to_s3.php');
			
	}

}else{

	echo $this->nallw('Global Leads Off');

}
	
?>