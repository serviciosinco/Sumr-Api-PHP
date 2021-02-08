<?php

	use Twilio\Rest\Client;
	use Twilio\Jwt\ClientToken;
	use Twilio\Jwt\AccessToken;
    use Twilio\Jwt\Grants\VideoGrant;
	use Twilio\Twiml;



	define('CRM_CLL', DMN_API.'/webhook/twilio/' );

	if(defined('DB_CL_ENC')){
		define('API_CLL', CRM_CLL.'touser/phone_add/?SUMR_Cl='.DB_CL_ENC.'&__u='.DMN_US_CALL);
	}

	define('TWL', 'https://api.twilio.com');

	if(DMN_S == 'sumr.co'){
		define('TWL_APPSID', 'AP9590dd52910c5220f8f147223a1e8efa');
	}else{
		define('TWL_APPSID', 'APd94f3f65bb48d0c5133d8cf633001ce9');
	}

	define('TWL_N_1', '+14695572766');
	define('TWL_N_2', '+573043808678');

	function _CallMyDvc($_p=NULL){

		$client = new Client(TWL_ID, TWL_TKN);
		$call = $client->calls->create(
		    $_p['us_n'],
			TWL_N_1,
		    [
		    	"url" => CRM_CLL."mydvc/agent/?SUMR_Cl=".$_p['cl']."&SUMR_UserTel=".$_p['us_t']."&PhoneNumber_Id=".$_p['cnt_t'],
		    	"method" => "POST",
		    	"statusCallbackMethod" => "POST",
		        "statusCallback" => CRM_CLL."touser/save/",
		        "statusCallbackEvent" => array(
		            "initiated", "ringing", "answered", "completed"
		        )
			]
		);

		if($call->sid != NULL){
			$_r['c']['sid'] = $call->sid;
			$_r['c']['apiVersion'] = $call->apiVersion;
			$_r['c']['callerName'] = $call->callerName;
			$_r['c']['status'] = $call->status;
			$_r['c']['duration'] = $call->duration;
			$_r['e'] = 'ok';
		}else{
			$_r['e'] = 'no';
		}

		$_r['from'] = TWL_N_1;
		$_r['to'] = $_p['us_n'];

		return _jEnc($_r);
	}

	function _Call_R($_p=NULL){
		$client = new Client(TWL_ID, TWL_TKN);
		foreach ($client->recordings->read() as $recording) {
		    print_r($recording);
		    echo HTML_BR.HTML_BR;
		}
	}


	function _Call_Dt($_p=NULL){

		try {

			$client = new Client(TWL_ID, TWL_TKN);
			$call = $client->calls($_p['id'])->fetch();
			$call_r = $client->calls($_p['id'])->recordings->read();

			$_r['price'] = $call->price;
			$_r['duration'] = $call->duration;

			if($call_r[0]->uri != NULL){
				$_r['mp3'] = TWL.str_replace('.json', '.mp3', $call_r[0]->uri);
			}

		} catch (Exception $e) {

		    $_r['w'] = $e->getMessage();

		}

		return _jEnc($_r);
	}


	function _Call_Api($_p=NULL){

		try {

			$client = new Client(TWL_ID, TWL_TKN);
			$call = $client->accounts(TWL_ID)->fetch();
			$_r = $call;

			return $_r;

		} catch (Exception $e) {

		    return $e->getMessage();

		}
	}

	function _SMS_Api($_p=NULL){
		$client = new Client(TWL_ID, TWL_TKN);

		$sms = $client->account->messages->create(
            '+14695572766',
            array(
                'from' => TWL_N_1,
                'body' => "Try to use and integrate Twilio in replace of smsplus.net"
            )
        );

		$_r = $sms;

		return $_r;
	}


	function __ApTkn($_p=NULL){

		if ($_p['c'] && TWL_ID != '' && TWL_TKN != '' && TWL_APPSID != '') {
		    $capability = new ClientToken(TWL_ID, TWL_TKN);
			$capability->allowClientOutgoing(TWL_APPSID);
			$capability->allowClientIncoming($_p['c']);
			$token = $capability->generateToken();
			return $token;
		}

	}


	function _Call_PhnAdd($_p=NULL){

		$_ustel = GtUsTelDt([ 'id'=>$_p['id'] ]);

		if($_ustel->e == 'ok' && $_ustel->telc != NULL){

			try {

				$client = new Client(TWL_ID, TWL_TKN);
				$validationRequest = $client->validationRequests->create(
				    $_ustel->telc,
				    [
				        "friendlyName" =>$_ustel->us->nm_fll,
				        "statusCallback" => API_CLL.'&_idc='.$_ustel->id,
				        "extension"=>$_ustel->ext
				    ]
				);

			} catch (Exception $e) {

		        $_r['w']['m'] = $e->getMessage();
		        $_r['w']['c'] = $e->getCode();

		    }

		}

		if(!isN($validationRequest->validationCode)){
			$_r['e'] = 'ok';
			$_r['api'] = API_CLL.'&_idc='.$_ustel->id;
			$_r['code'] = $validationRequest->validationCode;
		}else{
			$_r['m'] = 'no code';
			$_r['r'] = $validationRequest;
			$_r['e'] = 'no';
		}

		return _jEnc($_r);
	}


	function Whtsp_Snd($p=null){

		$_r['e'] = 'no';

		if(!isN($p['to']) && !isN($p['msg'])){

			if(!isN($p['from'])){ $_from=$p['from']; }else{ $_from='14695572766'; }
			$twilio = new Client(TWL_ID, TWL_TKN);
			$message = [ 'from'=>'whatsapp:+14695572766', 'body'=>$p['msg'] ];//From SUMR
			$send = $twilio->messages->create('whatsapp:+'.$p['to'], $message);

			if(!isN($send->sid)){
				$_r['e'] = 'ok';
				$_r['sid'] = $send->sid;
				$_r['status'] = $send->status;
			}

		}

		return _jEnc($_r);

	}


	function _Vdo_Room_New($_p=NULL){

		if(!isN($_p['roomNme'])){

			$client = new Client(TWL_VDO_KEY_SID, TWL_VDO_KEY_SCRT);
			$room_nm = $_p['roomNme'];
			$room_chck = $client->video->rooms->read([ 'uniqueName'=>$room_nm ], 20);

			if(count( $room_chck ) == 0){

				$room = $client->video->rooms->create([
					'uniqueName'=>$room_nm,
					'type'=>'peer-to-peer',
					'enableTurn'=>true,
					'Duration'=>300,
					'MaxParticipants'=>2,
					'statusCallback'=>DMN_HTTPS.'webhook/twilio/'
				]);

				$sid = $room->sid;
				$status = $room->status;

			}else{

				$sid = $room_chck->sid;
				$status = $room_chck->status;

				foreach ($room_chck as $room) {
					$sid = $room->sid;
					$status = $room->status;
				}

			}

			if(!isN($sid)){
				$_r['e'] = 'ok';
				$_r['sid'] = $sid;
				$_r['status'] = $status;
				$_r['name'] = $room_nm;
			}else{
				$_r['e'] = 'no';
			}

		}

		return _jEnc($_r);
	}

	function _Vdo_Room_Set($_p=NULL){

		$_r['e'] = 'no';

		if(!isN($_p['usid']) && !isN($_p['roomNme'])){

			$token = new AccessToken(
				TWL_ID,
				TWL_VDO_KEY_SID,
				TWL_VDO_KEY_SCRT,
				3600,
				$_p['usid']
			);

			$grant = new VideoGrant();
			$grant->setRoom($_p['roomNme']);
			$token->addGrant($grant);

			$_r['tkn'] = $token->toJWT();
			if(!isN($_r['tkn'])){ $_r['e'] = 'ok'; }

		}

		return _jEnc($_r);

	}


?>