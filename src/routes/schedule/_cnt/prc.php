<?php 
	
	$time = $_POST['time'];
	$date = $_POST['date'];
	$hour = $_POST['hour'];
 
	foreach($_POST['input'] as $k => $v){ $rsp['ls'][$k] = $v; }

	$rsp['ls']['time'] = $time;
	$rsp['ls']['date'] = $date;
	$rsp['ls']['hour'] = $hour;
	
	
	
	
	$rtrn = json_encode($rsp);
	if(!isN($rtrn)){ echo $rtrn; }
	
?>