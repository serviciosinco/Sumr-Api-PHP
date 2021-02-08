<?php

	//---------------------- INCLUSIÓN DE BASE ----------------------//

		$response['session'] = false; // Default is not

	//---------------------- CALCUATE TIME ----------------------//

		$time_executed = (microtime(true) - TIME_START)/60;
		$time_executed_format = number_format($time_executed, 5, '.', '');
		$response['execution']['time'] = $time_executed_format;

	//---------------------- MAIN HEADERS ----------------------//

		Hdr_JSON();
		header("Access-Control-Allow-Origin: *");
		header('Access-Control-Allow-Methods: GET, PUT, POST');
		header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With, x-app-key');

	//---------------------- ROUTER HANDLER ----------------------//

		include('handler.php');

	//---------------------- RENDER CONTENT ----------------------//

		ob_start('compress_code');
		if(!isN($response)){ echo json_encode($response, JSON_UNESCAPED_UNICODE | JSON_PARTIAL_OUTPUT_ON_ERROR); }
		ob_end_flush();