<?php
	require('autoload.php');
	use Abraham\TwitterOAuth\TwitterOAuth;

	define('_TW_CLLBCK',DMN_API.'twitter/callback/');
	define('_TW_LOGIN',DMN_API.'twitter/login/');

	class CRM_Twitter {

		function __construct($p=NULL){
			try{
				if($p['conn_tkn'] != NULL){ $TKN = $p['conn_tkn']; }else{ $TKN = TW_OAUTH_TOKEN; }
				if($p['conn_tkns'] != NULL){ $TKNS = $p['conn_tkns']; }else{ $TKNS = TW_OAUTH_TOKEN_SECRET; }
			    $this->conn = new TwitterOAuth(TW_CONSUMER_KEY, TW_CONSUMER_SECRET, $TKN, $TKNS);
			    $this->conn->setTimeouts(10, 15);
		    }catch(Exception $e){
				$rsp['w'] = $e->getMessage();
			}
			return _jEnc($rsp);
		}

		public function _ChckCrdn() {
			try{
				$credentials = $this->conn->get("account/verify_credentials");
				return(_jEnc($credentials));
			}catch(Exception $e){
				$rsp['w'] = $e->getMessage();
				return _jEnc($rsp);
			}
	    }

	    public function _oAuth($p=NULL) {
		    try{
			    if($this->o_cllbck != NULL){ $parameters['oauth_callback'] = $this->o_cllbck; }
			    if($this->o_vrfr != NULL){ $parameters['oauth_verifier'] = $this->o_vrfr; }
				if($p['t'] == 'a'){ $_t = 'oauth/access_token'; }elseif($p['t'] == 'r'){ $_t = 'oauth/request_token'; }
		    	$request_token = $this->conn->oauth($_t, $parameters);
		    	return(_jEnc($request_token));
	    	}catch(Exception $e){
				$rsp['w'] = $e->getMessage();
				return _jEnc($rsp);
			}
	    }

		public function _Auth() {
			try{
				$_tkn = $this->_oAuth(['t'=>'r']);

				$r['oauth_token'] = $_tkn->oauth_token;
				$r['oauth_token_secret'] = $_tkn->oauth_token_secret;
				$r['url'] = $this->conn->url('oauth/authorize', ['oauth_token'=>$_tkn->oauth_token]);
				return(_jEnc($r));

			}catch(Exception $e){
				$rsp['w'] = $e->getMessage();
				return _jEnc($rsp);
			}
		}


		public function _Msg($p=NULL) {
			try{
				$opt = [];
				//if($p['t']=='snt'){ $url.='/sent'; }
				if(!isN($p['max'])){ $opt['max_id']=$p['max']; }
				if(!isN($p['snc'])){ $opt['since_id']=$p['snc']; }
				if(!isN($p['lmt'])){ $opt['count']=$p['lmt']; }else{ $opt['count']=200; } print_r($this->conn); exit();


				$messages = $this->conn->get("direct_messages/events/list");  print_r($messages); exit();

				//$messages = $this->conn->get("direct_messages/events/list/".$url, $opt);
				return(_jEnc($messages));

			}catch(Exception $e){
				$rsp['w'] = $e->getMessage();
				return _jEnc($rsp);
			}
		}

	}
?>