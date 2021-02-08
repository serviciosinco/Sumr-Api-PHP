<?php

$_g_alw = $this->tallw([ 't'=>'key', 'id'=>'snd' ]);

if( $_g_alw->est == 'ok' ){

	//------------------- REQUEST FILE ---------------------//

	if(!isN($this->g__s2)){

		if(($this->g__s2=='ec' && !defined('SYS_AUTO')) && Dvlpr()){ $__allow='no'; }else{ $__allow='ok'; }

		if($__allow == 'ok'){
			$this->_Auto_Inc(GRP_FL_SND.$this->g__s2.'.php');
		}else{
			echo $this->h1(strtoupper($this->g__s2).' NOT INCLUDED '.$this->Spn('Only in production', 'ok'), '_warn');
		}

	}else{

		$this->_Auto_Inc(GRP_FL_SND.'ec.php');
		$this->_Auto_Inc(GRP_FL_SND.'sms.php');
		$this->_Auto_Inc(GRP_FL_SND.'cl_flj.php');
		$this->_Auto_Inc(GRP_FL_SND.'eml_chk.php');
		$this->_Auto_Inc(GRP_FL_SND.'ec_cmpg.php');
		$this->_Auto_Inc(GRP_FL_SND.'ec_cmpg_est.php');
		$this->_Auto_Inc(GRP_FL_SND.'ec_lsts.php');
		$this->_Auto_Inc(GRP_FL_SND.'ec_snd_fixest.php');

	}

}else{

	echo $this->nallw('Global Envios Masivos - Off');

}

?>