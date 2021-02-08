<?php /*echo 'Fix Querys'; exit();*/

include('_fnc.php');

try{

	$_status = new CRM_Status();
	$rsp['dsh'] = GtTotMntrDt([ 't' => 'tp', 'i' => 'mntr' ]);
	$rsp['ls'] = $_status->GtMntrContDt();


}catch(Exception $e){

	$rsp['e'] = 'no';
	$rsp['w'] = TX_NSPPCSR.$e->getMessage();

}

?>