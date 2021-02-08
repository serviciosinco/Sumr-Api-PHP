<?php

	try {

	//---------------------- INCLUSIÓN DE BASE ----------------------//

		include('includes/main.php');

	//---------------------- PROCESS INFORMATION ----------------------//

		ob_start('compress_code');
		include('routes/main.php');
		ob_end_flush();

	} catch (Exception $e) {

		header("HTTP/1.1 401 Unauthorized");

	}



?>