<?php

	if(defined('DMN_OAUTH')){
		define('_MICROSOFT_MYURL', DMN_OAUTH.'microsoft/');
		define('_MICROSOFT_API_URL', 'https://login.microsoftonline.com/');
		define('_MICROSOFT_API_OAUTH', 'oauth2');
		define('_MICROSOFT_API_OAUTH_V', '/v2.0/');
		define('_MICROSOFT_API_GRAPH_V', '/v1.0/');

		define('_MICROSOFT_CLIENT_TENANT', 'common/');
		define('_MICROSOFT_CLIENT_RESOURCE', 'https://graph.microsoft.com');
	}

	class CRM_Microsoft {

		function __construct($p=NULL){

			$this->url->scope = _MICROSOFT_API_URL._MICROSOFT_CLIENT_TENANT._MICROSOFT_API_OAUTH._MICROSOFT_API_OAUTH_V.
								'authorize?client_id='._MICROSOFT_CLIENT_ID.
								'&response_type=code&redirect_uri='._MICROSOFT_MYURL.
								'&response_mode=query&scope=openid&state='.Enc_Rnd('r');

			$this->url->token = _MICROSOFT_API_URL._MICROSOFT_CLIENT_TENANT._MICROSOFT_API_OAUTH._MICROSOFT_API_OAUTH_V.'token';
			$this->url->api = _MICROSOFT_CLIENT_RESOURCE._MICROSOFT_API_GRAPH_V;

			$this->rqu = new CRM_Out();
			$this->rqu->o_auth->host = 'graph.microsoft.com';
			$this->eml_bld = new CRM_Eml();

		}

		public function _Tkn($p=NULL){

			try{

				$__url = $this->url->token;

				$post['grant_type'] = 'authorization_code';
				$post['client_id'] = _MICROSOFT_CLIENT_ID;
				$post['redirect_uri'] = _MICROSOFT_MYURL;
				$post['client_secret'] = _MICROSOFT_CLIENT_SECRET;
				$post['scope'] = 'openid';
				$post['code'] = $p['code'];

				$this->rqu->url = $__url;
				$this->rqu->o_tmout = 5;
				$this->rqu->o_post = true;
				$this->rqu->o_post_f = http_build_query($post);

				$rsp = $this->rqu->_Rq();

				return _jEnc($rsp->rsl);

			} catch (Exception $e) {

				$r['w'] = $e;
				return _jEnc($r);

			}

		}



		public function _Tkn_R($p=NULL){ // Refresh

			$__url = $this->url->token;

			$post['grant_type'] = 'refresh_token';
			$post['client_id'] = _MICROSOFT_CLIENT_ID;
			$post['redirect_uri'] = _MICROSOFT_MYURL;
			$post['refresh_token'] = $this->refresh_token;
			$post['client_secret'] = _MICROSOFT_CLIENT_SECRET;

			$this->rqu->url = $__url;
			$this->rqu->o_tmout = 5;
			$this->rqu->o_post = true;
			$this->rqu->o_post_f = http_build_query($post);

			$rsp = $this->rqu->_Rq();

			$_r = _jEnc($rsp->rsl);

			if(!isN($rsp->rsl)){

				if(!isN($this->d->eml->id)){

					$__Thrd = new CRM_Thrd();
					$__Thrd->eml_id_upd = $this->d->eml->id;
					$__Thrd->eml_attr = json_decode($_r, true);
					$__Prc = $__Thrd->Eml_Attr(['tp'=>'eml']);

					$this->access_token	= $_r->access_token;

					if($__Prc->e == 'ok'){
						$rsp['e'] = 'ok';
					}

				}

			}


			$_r = _jEnc($rsp->rsl);
			return $_r;

		}


		public function _TknChk($p){

			if($p->error->code == 'InvalidAuthenticationToken'){

				$__Tkn = $this->_Tkn([ 'code'=>$this->access_token ]);
				$data = json_decode($__Tkn);

				if(!isN($data->access_token)){

					$this->access_token	= $data->access_token;

				}else{

					$this->_Tkn_R();

				}

			}

		}

		public function _Rqu($p=NULL){

			if(!isN($this->access_token)){

				try{

					$__url = $this->url->api.$p['t'].'/';
					if(!isN($p['mre'])){ $__url .= $p['mre'].'/'; }

					$this->rqu->url = $__url;
					$this->rqu->o_auth->v = $this->access_token;
					$this->rqu->o_crqst = 'GET';
					$rsp = $this->rqu->_Rq();

					return $rsp->rsl;

				} catch (Exception $e) {

					$r['w'] = $e;

					return _jEnc($r);

				}

			}

		}


		public function _Box($p=NULL){

			if(!isN($this->access_token)){

				if($p['t']=='sb' && !isN($p['prnt'])){ $_rqmre .= '/'.$p['prnt'].'/childFolders'; }

				$__rsp = json_decode( $this->_Rqu([ 't'=>'me', 'mre'=>'mailFolders'.$_rqmre ]));

				$this->_TknChk($__rsp);


				foreach($__rsp->value as $_bx_k=>$_bx_v){

					$_r[$_bx_v->id]['data'] = $_bx_v;

					if($_bx_v->childFolderCount > 0){

						//$_r[$_bx_v->id]['child'] = $this->_Box([ 'id'=>$_bx_v->id, 't'=>'sb', 'r'=>'a' ]);
						$_sub_get = $this->_Box([ 'prnt'=>$_bx_v->id, 't'=>'sb' ]);
						foreach($_sub_get as $k_sb=>$v_sb){
							$_r[$v_sb->data->id]['sb'] = 'ok';
							$_r[$v_sb->data->id]['data'] = $v_sb->data;
						}
					}

				}

				if($p['r'] == 'a'){ $_go = $_r; }else{ $_go = _jEnc($_r); }

				return $_go;
			}

		}


		public function _Msg($p=NULL){

			if(!isN($this->access_token)){


				$this->_TknChk($__rsp);

				$__rsp = json_decode( $this->_Rqu([ 't'=>'me', 'mre'=>'messages?$skiptoken'.$_rqmre ]));



				//print_r($__rsp);
				/*

				foreach($__rsp->value as $_bx_k=>$_bx_v){

					$_r[$_bx_v->id]['data'] = $_bx_v;

					if($_bx_v->childFolderCount > 0){

						foreach($_sub_get as $k_sb=>$v_sb){
							$_r[$v_sb->data->id]['sb'] = 'ok';
							$_r[$v_sb->data->id]['data'] = $v_sb->data;
						}
					}

				}
				*/

				if($p['r'] == 'a'){ $_go = $_r; }else{ $_go = _jEnc($_r); }

				return $_go;
			}

		}



	}

?>