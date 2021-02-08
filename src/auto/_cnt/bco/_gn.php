<?php 


$_g_alw = $this->tallw([ 't'=>'key', 'id'=>'bco' ]);

if( $_g_alw->est == 'ok' ){

	//-------------------- REQUEST FILE --------------------//

	define('GRP_FL_BCO', '_cnt/bco/');
	

	if(!isN($this->g__t2)){ 

		$this->_Auto_Inc(GRP_FL_BCO.$this->g__t2.'.php');
		
	}else{
			
		$this->_Auto_Inc(GRP_FL_BCO.'bco.php');
		$this->_Auto_Inc(GRP_FL_BCO.'bco_aws.php');
		$this->_Auto_Inc(GRP_FL_BCO.'bco_tag.php');
		$this->_Auto_Inc(GRP_FL_BCO.'bco_chk.php');
		$this->_Auto_Inc(GRP_FL_BCO.'bco_ornt.php');
			
	}	

}else{

	echo $this->nallw('Global Banco Off');

}
	
?>