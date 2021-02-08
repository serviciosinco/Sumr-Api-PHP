<?php 
	
$_g_alw = $this->tallw([ 't'=>'key', 'id'=>'tot' ]);

if( $_g_alw->est == 'ok' ){

	//------------------- REQUEST FILE ---------------------//
	
	if(!isN($this->g__s2)){ 	

		$this->_Auto_Inc(GRP_FL_TOT.$this->g__s2.'.php');
		
	}else{

		$this->_Auto_Inc(GRP_FL_TOT.'mntr.php');
		$this->_Auto_Inc(GRP_FL_TOT.'ec_snd.php');
		
	}

}else{

	echo $this->nallw('Global Totals Calculate - Off');

}

?>