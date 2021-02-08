<?php

	namespace App;

	include("../../includes/inc.php");

	use phpseclib\Crypt\RSA;
	use phpseclib\Net\SSH2;

	$rsp['e'] = 'no';

	try{


		function __search($search,$string){
			$result = array();
		    preg_match_all('/' . preg_quote($search) . '\s+\w+/i', $string, $result);
		    return $result[0];
		}



		$key = new RSA();
		$key->loadKey(file_get_contents('private/MSDevelopers.pem'));
		$ssh = new SSH2('3.215.46.211');


		if (!$ssh->login('ubuntu', $key)) {

			$rsp['w'] = 'no_login';
			$rsp['msj'] = $ssh;

		}else{

			$_r = $ssh->write("vncserver \n");

			if($_r){
				$rsp['m'] = $ssh->read('[prompt]');
			}else{
				$rsp['w'] = $ssh->errors;
			}

		}


	}catch(Exception $e){

		$rsp['w'] = $e->getMessage();

	}



	Hdr_JSON();
	ob_start("compress_code");
	$rtrn = json_encode($rsp);
	if(!isN($rtrn)){ echo $rtrn; }
	ob_end_flush();



?>