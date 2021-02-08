<?php 
	
	$r['e'] = 'no';
	
	if(!isN($__dt_sort->data)){
		$r['e'] = 'ok';
		$r['data'] = json_decode($__dt_sort->data);
	}
	
	
	header('Content-Type: application/json');
	echo json_encode($r);
					
?>