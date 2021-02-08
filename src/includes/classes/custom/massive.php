<?php

class API_CRM_Massive{

	//---------------- Funciones Generales ----------------//


		public function __construct($p=NULL){
			$this->out = new CRM_Out();

			//---------------- Datos de Conexion a Api ----------------//

			/*if(Dvlpr()){
				$this->api_url = "https://api-qa.massivespace.rocks/v1/";
				$this->api_url_s = "https://back-qa.massivespace.rocks/";
				$this->api_xapp_key = "TREE8ZoJfYF3aSl0Ta6giJ8ucWWwdhFf";
				$this->api_xapp_scrt = "CfeMFXGWQP2e0m9ObTIsngjz1ZRtyJT3";
			}else{*/
				$this->api_url = "https://api.massivespace.rocks/v1/";
				$this->api_url_s = "https://back.massivespace.rocks/";
				$this->api_xapp_key = MSV_KEY;
				$this->api_xapp_scrt = MSV_SCRT;
			//}

	    }

		function __destruct() {
	   	}

		public function bld($_p=NULL){

			$this->api_srce = '';

			if($_p['t'] == 'user_login'){

				$__url = $this->api_url_s.'accounts/generate_token/';
				$this->api_srce = 'srv';

			}elseif($_p['t'] == 'user_online'){

				$__url = $this->api_url_s.'accounts/settings/online/';
				$this->api_srce = 'srv';

			}elseif($_p['t'] == 'account_detail'){

				$__url = $this->api_url.'whatsapp/me/';

			}elseif($_p['t'] == 'messages_list'){

				$__url = $this->api_url.'whatsapp/messages/get/';

			}elseif($_p['t'] == 'channel_status'){

				$__url = $this->api_url.'whatsapp/channel/status/';

			}elseif($_p['t'] == 'messages_send'){

				if(!isN($_p['chnl'])){
					$__url = $this->api_url_s.'chat/channels/'.$_p['chnl'].'/plain/send_message/';
					$this->api_srce = 'srv';
				}

			}

			return $__url;
		}

		public function rqu($_p=NULL){

			$this->out->url = $this->bld($_p);
			$this->out->o_ctmout = 10;
			$this->out->o_tmout = 10;

			$_pdata = $_p['d'];

			if($this->api_srce == 'srv'){

				$_pdata['app_secret'] = $this->api_xapp_scrt;

				$this->out->o_header_http = [
										    'x-app-key: '.$this->api_xapp_key
										];

				if(!isN($_p['h'])){
					foreach($_p['h'] as $_hdr_k=>$_hdr_v){
						$this->out->o_header_http[] = $_hdr_k.': '.$_hdr_v;
					}
				}

			}else{

				$_pdata['__s'] = $this->api_xapp_scrt;
				$_pdata['__k'] = $this->api_xapp_key;
				$_pdata['order'] = 'ASC';

			}

			$this->out->o_post = true;
			$this->out->o_post_f = $_pdata;
			$this->out->o_ipv4 = true;
			$this->out->out = 'json';

			$try=0;

			while($try < 3){
				$rsp = $this->out->_Rq();
				if($rsp->code == 200 || $rsp->code == 201){ break; }
				sleep(5);
				$try++;
			}

			return $rsp;

		}


		public function us_lgin($_p=NULL){
			return $this->rqu([ 't'=>'user_login', 'd'=>[ 'username'=>$_p['us'] ] ]);
		}

		public function us_actv($_p=NULL){
			$__lgin_tkn = $this->rqu([ 't'=>'user_login', 'd'=>[ 'username'=>$_p['us'] ] ]);
			return $this->rqu([ 't'=>'user_online', 'h'=>[ 'Authorization'=>'JWT '.$__lgin_tkn->rsl->token ] ]);
		}

		public function acc_dtl($_p=NULL){
			return $this->rqu([ 't'=>'account_detail', 'd'=>[ '__a'=>$_p['acc'] ] ]);
		}

		public function msg_ls($_p=NULL){
			return $this->rqu([ 't'=>'messages_list', 'd'=>[ '__a'=>$_p['acc'], '__app'=>$_p['app'], 'channel'=>$_p['chnl'], 'message'=>$_p['msg'], 'after_id'=>$_p['nxt'], 'limit'=>$_p['lmt'] ] ]);
		}

		public function chnl_est($_p=NULL){
			return $this->rqu([ 't'=>'channel_status', 'd'=>[ '__a'=>$_p['acc'], '__app'=>$_p['app'], 'channel'=>$_p['chnl'], 'after_id'=>$_p['nxt'], 'limit'=>$_p['lmt'] ] ]);
		}

		public function msg_snd($_p=NULL){

			$__lgin_tkn = $this->us_lgin([ 'us'=>$this->wthspcnvsnd_us ]);

			if(!isN($__lgin_tkn->rsl->token)){

				return $this->rqu([
							't'=>'messages_send',
							'chnl'=>$_p['channel'],
							'd'=>[
								'text'=>$_p['message']
							],
							'h'=>[ 'Authorization'=>'JWT '.$__lgin_tkn->rsl->token ]
						]);

			}else{

				$_r['w'] = 'No JWT Token for '.$this->wthspcnvsnd_us;
				return _jEnc($_r);

			}

		}

}
?>