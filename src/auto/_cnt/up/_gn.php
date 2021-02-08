<?php

$_g_alw = $this->tallw([ 't'=>'key', 'id'=>'up' ]);

if( $_g_alw->est == 'ok' ){

	//------------------- REQUEST FILE ---------------------//

	if(!isN($this->g__t2)){

		$this->_Auto_Inc(GRP_FL_UP.$this->g__t2.'.php');

	}else{

		$this->_Auto_Inc(GRP_FL_UP.'bd.php');
		$this->_Auto_Inc(GRP_FL_UP.'cnt.php');
		$this->_Auto_Inc(GRP_FL_UP.'mdl_cnt.php');
		$this->_Auto_Inc(GRP_FL_UP.'mdl_cnt_tra.php');
		$this->_Auto_Inc(GRP_FL_UP.'ec_lsts.php');
		$this->_Auto_Inc(GRP_FL_UP.'ec_snd.php');
		$this->_Auto_Inc(GRP_FL_UP.'sms_cmpg.php');

	}

}else{

	echo $this->nallw('Global Monitor Uploads - Off');

}

?>