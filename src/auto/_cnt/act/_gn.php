<?php 

$_g_alw = $this->tallw([ 't'=>'key', 'id'=>'act' ]);

if( $_g_alw->est == 'ok' ){

	//-------------------- REQUEST FILE --------------------//
	
	define('GRP_FL_ACT', '_cnt/act/');

	if(!isN($this->g__t2)){ 

		$this->_Auto_Inc(GRP_FL_ACT.$this->g__t2.'.php');
		
	}else{
			
        $this->_Auto_Inc(GRP_FL_ACT.'act_to_s3.php');
			
	}

}else{

	echo $this->nallw('Global Module - Activities - Off');

}

?>