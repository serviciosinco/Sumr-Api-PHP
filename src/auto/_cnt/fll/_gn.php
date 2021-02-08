<?php 

$_g_alw = $this->tallw([ 't'=>'key', 'id'=>'fll' ]);

if( $_g_alw->est == 'ok' ){

	//-------------------- AMOUNT AND BILLING CHECK --------------------//
		
	$fll = new API_FullContact();
	$fll_r = $fll->Status()->c;
	$__upd = UPD_Thrd(['id'=>3, 'status'=>json_encode($fll_r) ]); 

	//-------------------- REQUEST INFO --------------------//		
		
	define('GRP_FL', DIR_CNT.'fll/');
	
	$this->_Auto_Inc(GRP_FL.'cnt_chk.php');
	$this->_Auto_Inc(GRP_FL.'cnt_eml.php');
	$this->_Auto_Inc(GRP_FL.'org_info.php');
		

}else{

	echo $this->nallw('Global Fullcontact Off');

}