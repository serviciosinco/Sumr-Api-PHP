<?php

$_g_alw = $this->tallw([ 't'=>'key', 'id'=>'snd' ]);

if( $_g_alw->est == 'ok' ){

	//------------------- REQUEST FILE ---------------------//

	if(!isN($this->g__s2)){

		$this->_Auto_Inc(GL_EC.$this->g__s2.'.php');

	}else{

		$this->_Auto_Inc(GL_EC.'ec_aws.php');
		$this->_Auto_Inc(GL_EC.'ec_img.php');
		$this->_Auto_Inc(GL_EC.'ec_cmz.php');
		$this->_Auto_Inc(GL_EC.'ec_lsts_sgm.php');
		$this->_Auto_Inc(GL_EC.'ec_lsts_var.php');

	}

}else{

	echo $this->nallw('Global Pushmail - Off');

}

?>