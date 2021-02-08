<?php 
	
//$_g_alw = $this->tallw([ 't'=>'key', 'id'=>'tmp' ]);

//if( $_g_alw->est == 'ok' ){

	//------------------- REQUEST FILE ---------------------//
	
	if(!isN($this->g__s2)){ 	

		$this->_Auto_Inc(GRP_FL_TMP.$this->g__s2.'.php'); 
		
	}else{

		$this->_Auto_Inc(GRP_FL_TMP.'fixaccents.php');
		
	}

//}else{

	//echo $this->nallw('Global Envios Masivos - Off');

//}

?>