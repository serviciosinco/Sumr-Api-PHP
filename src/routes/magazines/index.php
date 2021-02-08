<?php

	include('inc/inc.php');

	if(PrmLnk('rtn', 1, 'ok') == 'api'){
		
		Hdr_JSON();
		include('_cnt/api.php');
		echo json_encode($r);

	}else{

		include('_cnt/html.php');

	}
	
	
	
?>