<?php

	/*require('../_lib/vendor/autoload.php');
	use ElephantIO\Client;
	use ElephantIO\Engine\SocketIO\Version2X;

	try{

	$client = new Client(new Version2X('DMN_WSS:2053', [
	    'headers' => [
	        'X-My-Header: websocket',
	        'Authorization: Bearer 12b3c4d5e6f7g8h9i'
	    ]
	]));

	$client->initialize();
	$client->emit('dwn', ['tp' => 'dwn_goss', 'tb'=>'sss', 'tb_id'=>'eee']);
	$client->close();*/

	$Rt = '../../../includes/'; include($Rt."inc.php");

	$_us = $_POST["us"];
	$updateSQL = sprintf("UPDATE "._BdStr(DBM).TB_US." SET us_onl=%s WHERE us_enc=%s",
						   GtSQLVlStr(2, "int"),
						   GtSQLVlStr($_us, "text"));

	$Result = $__cnx->_prc($updateSQL);

	if($Result){
		$rsp['e'] = 'ok';
		$rsp['m'] = 1;
		//$rsp['qry'] = $updateSQL;
	}else{
		$rsp['e'] = 'no';
		$rsp['m'] = 2;
		//$rsp['qry'] = $updateSQL;
	}

?>