<?php
		require('twitteroauth.php');

		function getConnectionWithAccessToken() {
            $connection = new TwitterOAuth(TW_CONSUMER_KEY, TW_CONSUMER_SECRET, TW_OAUTH_TOKEN, TW_OAUTH_TOKEN_SECRET);
            return $connection;
        }

		function TwChckCrdn() {
           $connection = getConnectionWithAccessToken();
		   $credentials = $connection->get("account/verify_credentials");
		   $rtrn = _jEnc($credentials);
		   return($rtrn);
        }

		function TwPbsh($msj, $_pic=''){
				$connection = getConnectionWithAccessToken();
				$twitter = $connection->post('statuses/update', array('status' =>$msj));
				$_err = _jEnc($twitter->errors);

				if (!empty($_err)){
					foreach(json_decode($_err) as $obj){
							$__c = $obj->code;
							$__m = $obj->message;
					}
				}


			if(($twitter) && ($rsp['id'] != NULL) && !empty($rsp['id']) ){
				$rsp['id'] = $twitter->id;
				$rsp['status'] = $__m;
				$rsp['status2'] = 'Publicado Exitosamente en Twitter';
				$rsp['err'] = $__c;
			}else{
				$rsp['id'] = $twitter->id;
				$rsp['status'] = $__m;
				$rsp['status2'] = 'No se realizo la conexion con la API de Twitter';
				$rsp['err'] = $__c;
			}
			return _jEnc($rsp);
		}


		function TwGtDt($_i){
				$connection = getConnectionWithAccessToken();
				$twitter = $connection->get('statuses/show/', array('id' =>$_i));
				return($twitter);
		}
?>