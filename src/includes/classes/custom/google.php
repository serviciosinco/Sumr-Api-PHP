<?php


	use App\GmailEmail;

	if(defined('DMN_OAUTH')){
		define('GOAPI_URI' , DMN_OAUTH.'google/');
	}

	class API_GAPI{

		private $key='';

		public function __construct(){


	    }

	    public function get_data(){

			if($this->cl != NULL){ $this->get_cl = GtClDt($this->cl, 'enc'); }elseif(defined('DB_CL_ENC')){ $this->get_cl = GtClDt(DB_CL_ENC, 'enc'); }
			if($this->us != NULL){ $this->get_us = GtUsDt($this->us, 'enc'); }elseif(defined('SISUS_ENC')){ $this->get_us = GtUsDt(SISUS_ENC, 'enc'); }
			if($this->eml != NULL){ $this->get_eml = GtUsEmlDt($this->eml, 'enc'); }
	    }

	    public function tkn_chk($p=NULL){

		    $r['e'] = 'no';
		    $this->get_data();

		    if(!isN($this->get_eml->attr->access_token)){
			    $___tkng = $this->tkn_grnted([ 'tkn'=>$this->get_eml->attr ]);

			    $r['e'] = 'ok';
			    $r['tkn'] = $this->get_eml->attr->access_token;
			    $r['tknr'] = $this->get_eml->attr->refresh_token;
			    $r['cod'] = str_replace('\'','"',$this->get_eml->attr->cod);
			}



		    return _jEnc($r);
	    }


		public function tkn_grnted($p=NULL){

			$___c_json = $p['tkn']->access_token;

			try{

				$client = _gapi_str();
				$client->setAccessToken( $___c_json );

				if($client->isAccessTokenExpired()){

				    $client->refreshToken( $p['tkn']->refresh_token );
				    $actkn = $client->getAccessToken();

				    if(!isN($actkn)){

						$__Eml = new CRM_Eml();
				    	$__Eml->eml_id_upd = $this->get_eml->id;
						$__Eml->eml_attr = json_decode($actkn, true);
						$__Eml->eml_attr['cod'] = json_decode($actkn);
						$__Prc = $__Eml->Eml_Attr(['tp'=>'eml']);

					}

					if($__Prc->e == 'ok'){

						$r['nw']['tkn'] = $actkn->access_token;
						$r['e'] = 'ok';
						$r['p'] = 'c';
					}


			   	}else{

				   	$r['e'] = 'ok';

			   	}

		   	} catch (Exception $e) {

			   	$r['e'] = 'no';
			   	$r['w'] = $e->getMessage();

			}


		   	$rtrn = _jEnc($r);
			return($rtrn);
		}



    }



    function _gapi_str(){
	    $client = new Google_Client();
		$client->setClientId(GOAPI_ID);
		$client->setClientSecret(GOAPI_SCRT);
	    return $client;
    }



	function _gapi($p=NULL){

		$_ga_id = GA_PASSWORD;
		$_ga_eml = GA_EMAIL;
		$_p12_fle = dirname(__FILE__).'/sumr-182914-e15d517bdb67.p12';

		try {

			$__cl = new Google_Client();
			$__cl->setApplicationName("SUMR");
			$key = file_get_contents($_p12_fle);
			$_scp = "https://www.googleapis.com/auth/analytics.readonly";

			$cred = new Google_Auth_AssertionCredentials($_ga_eml, array($_scp), $key);
			$__cl->setAssertionCredentials($cred);

			if($__cl->getAuth()->isAccessTokenExpired()) {
				 $__cl->getAuth()->refreshTokenWithAssertion($cred);
			}

			$__mtr_arr = explode(',', str_replace(' ','',$p['m']));
			foreach ($__mtr_arr as &$valor) { $_metrics[] = 'ga:'.$valor; }

			$__dmn_arr = explode(',', str_replace(' ','',$p['d']));
			foreach ($__dmn_arr as &$valor) { $_dimensions[] = 'ga:'.$valor; }

			if($p['f1'] != NULL){ $_f1 =  $p['f1']; }else{ $_f1 = date('Y-m-d', strtotime('-30 days')); }
			if($p['f2'] != NULL){ $_f2 =  $p['f2']; }else{ $_f2 = date('Y-m-d'); }

			$ga = new Google_Service_Analytics($__cl);
			$_r['r'] = $ga->data_ga->get('ga:'.$p['i'], $_f1, $_f2, 'ga:city, ga:country', array('filters'=> $p['f'], 'dimensions'=>implode(',',$_dimensions), 'metrics'=>implode(',',$_metrics), 'sort'=> '-ga:pageviews'));
			$_r['t'] = json_decode( str_replace('ga:', '', json_encode($_r['r']['totalsForAllResults']) ) );

		}catch (apiServiceException $e) {
			$_r['e'] = $e->getMessage();
		}

		return($_r);
	}




	function _gmail_body($body) {
	    $rawData = $body;
	    $sanitizedData = strtr($rawData,'-_', '+/');
	    $decodedMessage = base64_decode($sanitizedData);
	    if(!$decodedMessage){
	        $decodedMessage = FALSE;
	    }
	    return $decodedMessage;
	}

	function _gmail_messages($gmail, $q) {

		try{
		    $list = $gmail->users_messages->listUsersMessages('me', array('q' => $q));
		    while ($list->getMessages() != null) {

		        foreach ($list->getMessages() as $mlist) {

		            $message_id = $mlist->id;
		            $optParamsGet2['format'] = 'full';
		            $single_message = $gmail->users_messages->get('me', $message_id, $optParamsGet2);
		            $payload = $single_message->getPayload();

		            // With no attachment, the payload might be directly in the body, encoded.
		            $body = $payload->getBody();
		            $__found_bdy = decodeBody($body['data']);

		            // If we didn't find a body, let's look for the parts
		            if(!$__found_bdy) {
		                $parts = $payload->getParts();
		                foreach ($parts  as $part) {
		                    if($part['body'] && $part['mimeType'] == 'text/html') {
		                        $__found_bdy = decodeBody($part['body']->data);
		                        break;
		                    }
		                }
		            } if(!$__found_bdy) {
		                foreach ($parts  as $part) {
		                    // Last try: if we didn't find the body in the first parts,
		                    // let's loop into the parts of the parts (as @Tholle suggested).
		                    if($part['parts'] && !$__found_bdy) {
		                        foreach ($part['parts'] as $p) {
		                            // replace 'text/html' by 'text/plain' if you prefer
		                            if($p['mimeType'] === 'text/html' && $p['body']) {
		                                $__found_bdy = decodeBody($p['body']->data);
		                                break;
		                            }
		                        }
		                    }
		                    if($__found_bdy) {
		                        break;
		                    }
		                }
		            }
		            // Finally, print the message ID and the body
		           // print_r($message_id . " <br> <br> <br> *-*-*- " . $__found_bdy);
		        }

		        if ($list->getNextPageToken() != null) {
		            $pageToken = $list->getNextPageToken();
		            $list = $gmail->users_messages->listUsersMessages('me', array('pageToken' => $pageToken));
		        } else {
		            break;
		        }
		    }
		} catch (Exception $e) {
		    echo $e->getMessage();
		}

	}

	function _gmail_emlfx($p=NULL){

		preg_match('/<(.*?)>/', $p['v'], $match);
		$m = $match[1];
		$r = $m;

		if($r == ''){
			$r = filter_var( htmlentities($p['v']), FILTER_SANITIZE_EMAIL);
		}

	    return $r;
	}

	function _gmail_msg_islbl($p=NULL){
		$r = 'no';
		if( is_array($p['lbl']) ){
			foreach($p['lbl'] as $k=>$v){
				if($v == $p['v']){ $r = 'ok'; }
			}
		}
		return $r;
	}

	function _gmail_labels($service, $userId) {


		try {

		  	$labelsResponse = $service->users_labels->listUsersLabels($userId);

			$r['e'] = 'ok';
			$i = 1;

			foreach ($labelsResponse->getLabels() as $label) {
			    if($label->getLabelListVisibility() == 'labelShow'){
				    $__m = _box_lbl(array( 'id'=>$label->getId() ));

				    if($__m->ord != ''){ $i = $__m->ord; }else{ $i++; }

				    $r['ls'][$i]['id'] = $label->getId();
				    $r['ls'][$i]['nm'] = $__m->nm;
				    $r['ls'][$i]['lbl'] = $label->getLabelListVisibility();
				    $r['ls'][$i]['msg']['tot'] = $label->getMessagesTotal();
				    $r['ls'][$i]['msg']['unr'] = $label->getMessagesUnread();
				    $r['ls'][$i]['tp'] = $label->getType();
				    $r['ls'][$i]['ord'] = $__m->ord;
				    $r['ls'][$i]['cls'] = $__m->cls;

					$i++;
			    }
			}

			ksort($r['ls']);


		} catch (Excetion $e) {
		    $r['w'] = $e->getMessage();
		}

	  	$rtrn = _jEnc($r);
		return($rtrn);
	}






	function _gmail_message_body($p=NULL) {


		try{

            $payload = $p['msg']->getPayload();
            $body = $payload->getBody();
            $__found_bdy = _gmail_decodeBody($body['data']);
			$__found_sze = $body['data']->size;

            if(!$__found_bdy) {
                $parts = $payload->getParts();
                foreach ($parts  as $part) {
                    if($part['body'] && $part['mimeType'] == 'text/html') {
                        $__found_bdy = _gmail_decodeBody($part['body']->data);
                        $__found_sze = $part['body']->size;
                        break;
                    }
                }
            }

            if(!$__found_bdy) {
                foreach ($parts  as $part) {
                    if($part['parts'] && !$__found_bdy) {
                        foreach ($part['parts'] as $p) {
                            if($p['mimeType'] === 'text/html' && $p['body']) {
                                $__found_bdy = _gmail_decodeBody($p['body']->data);
                                $__found_sze = $p['body']->size;
                                break;
                            }
                        }
                    }
                    if($__found_bdy) {
                        break;
                    }
                }
            }

			$r['sze'] = $__found_sze;
            $r['cod'] = $__found_bdy;

		} catch (Exception $e) {
		    $r['w'] = $e->getMessage();
		}


		$rtrn = _jEnc($r);
		return($rtrn);
	}




	function _gmail_message_dt($service, $msg, $box) {

    	$message_labels = $msg->labelIds;
        $headers = $msg->getPayload()->getHeaders();

        $_var_isstar = _gmail_msg_islbl(array('v'=>'STARRED', 'lbl'=>$message_labels));
        $_var_issent = _gmail_msg_islbl(array('v'=>'SENT', 'lbl'=>$message_labels));
        $_var_ischat = _gmail_msg_islbl(array('v'=>'CHAT', 'lbl'=>$message_labels));

        if($_var_isstar == 'ok'){ $r['isstar'] = 'ok'; }

        if(($box == 'CHAT' && $_var_ischat == 'ok') ||
           ($box == 'SENT' && $_var_issent == 'ok') ||
           ($box != 'SENT' && $_var_issent != 'ok')){


	        $r['thread'] =	$thread_id;
			$r['snippet'] = $msg->snippet;
			$r['body'] = _gmail_message_body(['gmail'=>$service, 'msg'=>$msg]);


			foreach($headers as $single){

	            if ($single->getName() == 'Subject') {

	                $r['sbj'] = $single->getValue()!=NULL?$single->getValue():TX_MAIL_NOSBJ;

	            }elseif($single->getName() == 'Reply-To') {

		            $message_rto = $single->getValue();
	                $r['rto']['nm'] = str_replace('"', '', $message_rto);
	                $r['rto']['eml'] = _gmail_emlfx(array('v'=>$single->value));
	                $r['attr']['RplyTo'] = _gmail_emlfx(array('v'=>$single->value));


	            }elseif($single->getName() == 'Date') {
	                $message_date = $single->getValue();
	                $message_date_dff = _DteDiff(array('f1'=>SIS_F2, 'f2'=>date('Y-m-d', strtotime($message_date))));

	                if($message_date_dff->n == 'no'){
	                	$r['dte'] = date('h:i A', strtotime($message_date));
	                }else{
		                if($message_date_dff->r > 7){
		                	$message_date_es = FechaESP_OLD($message_date, 7);
		                }else{
		                	$message_date_es = FechaESP_OLD($message_date, 6);
		                }
		                $r['dte'] = $message_date_es;
	                }

	            }elseif($single->getName() == 'From') {

	                $message_sender = $single->getValue();
	                $r['from']['nm'] = str_replace('"', '', $message_sender);
	                $r['from']['eml'] = _gmail_emlfx(array('v'=>$single->value));

	            }elseif($single->getName() == 'To') {


	                $message_to = $single->value;
	                $__ls = explode(',', $message_to);
	                $r['to'] = array();


	                foreach($__ls as $_msg_key => $_msg_vle){

		                $nm = str_replace('"', '', $_msg_vle );

		            	if (filter_var($nm, FILTER_VALIDATE_EMAIL)){ $nm = ''; }
		            	$r_to = [ 'nm'=>$nm, 'eml'=>_gmail_emlfx(array('v'=>$_msg_vle)) ];

		                array_push($r['to'], $r_to);

	                }

	            }elseif($single->getName() == 'Cc') {

	                $message_to = $single->value;
	                $__ls = explode(',', $message_to);
	                $r['cc'] = array();

	                foreach($__ls as $_msg_key => $_msg_vle){

		                $nm = str_replace('"', '', $_msg_vle );

		            	if (filter_var($nm, FILTER_VALIDATE_EMAIL)){ $nm = ''; }
		            	$r_cc = [ 'nm'=>$nm, 'eml'=>_gmail_emlfx(array('v'=>$_msg_vle)) ];

		                array_push($r['cc'], $r_cc);

	                }

	            }else{

		            //echo h2( $single->getName() );

	            }

	            $r['attr'][$single->getName()] = $single->getValue();
	        }

        }


        $rtrn = _jEnc($r);
		return($rtrn);
	}


	function _H_hdr(){
		$_r = '<!DOCTYPE html><html lang="es"><head><body>';
	}

	function _H_ftr(){
		$_r = '</body></html>';
	}


	function _DteDiff($_p=NULL){

		$datetime1 = new DateTime($_p['f1']);
		$datetime2 = new DateTime($_p['f2']);
		$interval = $datetime1->diff($datetime2);

		$r['d'] = $interval->format('%R%a días');
		$r['n'] = $interval->format('%R') == '-'?'ok':'no';
		$r['r'] = $interval->format('%a');
		if($interval->format('%R') == '+'){
			$r['n_d'] = $interval->format('%a');
		}

		return (object)$r;

	}

	function _gmail_decodeBody($body) {
	    $rawData = $body;
	    $sanitizedData = strtr($rawData,'-_', '+/');
	    $decodedMessage = base64_decode($sanitizedData);
	    if(!$decodedMessage){
	        $decodedMessage = FALSE;
	    }
	    return $decodedMessage;
	}

?>
