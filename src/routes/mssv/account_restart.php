<?php

	namespace App;

	include("../../includes/inc.php");

	use phpseclib\Crypt\RSA;
	use phpseclib\Net\SSH2;

	define('SUMASSIVE_PSSW', 'massive5430');


	$rsp['e'] = 'no';

	try{


		function __search($search,$string){
			$result = array();
		    preg_match_all('/' . preg_quote($search) . '\s+\w+/i', $string, $result);
		    return $result[0];
		}


		$key = new RSA();
		$key->loadKey(file_get_contents('private/LightsailDefaultPrivateKey-us-east-1.pem'));
		$ssh = new SSH2('54.167.81.46');


		if (!$ssh->login('ubuntu', $key)) {

			$rsp['w'] = 'no_login';
			$rsp['msj'] = $ssh;

		}else{
			//echo 'Connected';

			//echo h1('Login User Massive');
			$_r = $ssh->write("su - massive \n");
			if($_r){ $_r2 = $ssh->write(SUMASSIVE_PSSW." \n"); }
			if($_r2){ $_r3 = $ssh->read('[prompt]'); }
			if($_r3){ $_r4 = $ssh->write("ps -ef | grep -E 'crontab.*dda10df417864f02e873535df9834678' \n"); }

			if($_r4){


				$rsp['r']['1'] = $_r;
				$rsp['r']['2'] = $_r2;
				$rsp['r']['3'] = $_r3;
				$rsp['r']['4'] = $_r4;

				$____list = $ssh->read('[prompt]');

				if($____list){


					$rsp['____list'] = $____list;


					$__pid = __search("root", $____list);
					$__ubuntu = __search("ubuntu", $____list);
					$__massive = __search("massive", $____list);

					$__pid = array_merge($__pid, $__ubuntu);
					$__pid = array_merge($__pid, $__massive);

					foreach($__pid as $__pid_k=>$__pid_v){
						$__id = trim(str_replace(['root','ubuntu','massive'],'',$__pid_v));
						$__all .= $__id.' ';
						$rsp['pid'][] =  $__id;
					}

					if(!isN($__all)){

						$_r5 = $ssh->write("sudo kill -9 ".$__all." \n");

						if($_r5){

							$ssh->read('[prompt]');
							$_r6 = $ssh->write(SUMASSIVE_PSSW."\n");

							if($_r6){

								$rsp['kill']['gd'] = $_r7 = $ssh->write("sudo killall geckodriver \n");
								$rsp['kill']['frfx'] = $_r8 = $ssh->write("sudo killall firefox \n");

								if($_r7 && $_r8){
									$rsp['e'] = 'ok';
								}

							}
						}
						//echo h2($__all);
					}

					$_rdsip = gethostbyname('massive-db1.cd437whamugk.us-east-1.rds.amazonaws.com');
					$_rdsip_s = explode('.', $_rdsip);

					$_r7 = $ssh->write("sudo route add -net ".$_rdsip_s[0].".".$_rdsip_s[1].".".$_rdsip_s[2].".0/24 dev eth0 \n");


				}else{

					$rsp['w'] = $ssh->errors;

				}




			}else{

				$rsp['w'] = 'Problem on connection';

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