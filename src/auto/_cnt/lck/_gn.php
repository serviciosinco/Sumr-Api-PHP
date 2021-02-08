<?php 

$_g_alw = $this->tallw([ 't'=>'key', 'id'=>'lck' ]);

if( $_g_alw->est == 'ok' ){

	//------------------- REQUEST FILE ---------------------//

	if(!isN($this->g__s2)){ 			
		
		$this->_Auto_Inc(GRP_FL_LCK.$this->g__s2.'.php'); 
	
	}else{
	
		if(isWrkr()){  
			$this->_Auto_Inc(GRP_FL_LCK.'auto_rqu.php');
		}
		
		$this->_Auto_Inc(GRP_FL_LCK.'tmp_fle.php');
		
	}
		
}else{

	echo $this->nallw('Global Lock Off');

}		
		
?>