<?php 
		
	$__CallMod = new CRM_Call([ 'cl'=>$__cl_dt ]);
	
	$__CallMod->sid = $_POST['CallSid'];	
	$__CallMod->callstatus = $_POST['CallStatus'];
	$__CallMod->duration = $_POST['Duration'];
	$__CallMod->callduration = $_POST['CallDuration'];
	$__CallMod->SequenceNumber = $_POST['SequenceNumber'];

	$PrcDt = $__CallMod->Upd();
	
	$rsp = $PrcDt;
	
	
	ob_start("cmpr_fm"); Hdr_JSON();

	if(!isN($rsp)){ echo json_encode($rsp); }	

	ob_end_flush(); 	
		
?>