<?php

	class CRM_Emblue{

        private $_endpoint = 'http://api.embluemail.com/Services/EmBlue3Service.svc/Json/';
        private $_endpoint_evnt = 'http://track.embluemail.com/contacts/event';
        private $_CNX_USER = EMBLE_USER;
        private $_CNX_PASS = EMBLE_PASS;
        private $_CNX_TKEN = EMBLE_TOKN;
        private $_CNX_KEY = EMBLE_KEY;


    	function __construct() {

        	$_tkn = $this->_auth();
        	if(!isN($_tkn->rsl->Token)){ $this->tkn = $_tkn->rsl->Token; }

        }

		function __destruct() {

        }


        public function _cnx($p=NULL){

	        if($p['trck']=='ok'){

				$url = $this->_endpoint_evnt;
				$url_hdr = [
					'Accept: application/json',
					'Content-Type:application/json',
					'Authorization: Basic '. base64_encode($this->_CNX_KEY)
				];

			}else{

				$url = $this->_endpoint.$p['p'];
				$url_hdr = ['Content-Type: application/json'];

			}



			$CurlRQ = new CRM_Out();
			$CurlRQ->o_header_http = $url_hdr;
			$CurlRQ->url = $url;
			$CurlRQ->out = 'json';

			if(!isN($this->data) || !isN($p['data'])){

				if(!isN($this->tkn) && $p['trck']!='ok'){
					$this->data['Token'] = $this->tkn;
				}

				$CurlRQ->o_post = true;

				if(!isN($p['data'])){ print_r($p['data']);
					$CurlRQ->o_post_f = json_encode($p['data']);
				}else{
					$CurlRQ->o_post_f = json_encode($this->data);
				}
			}

			$rsp = $CurlRQ->_Rq();

			return($rsp);
        }


        public function _auth(){
	        $data = ['User'=>$this->_CNX_USER, 'Pass'=>$this->_CNX_PASS, 'Token'=>$this->_CNX_TKEN];
	        $_r = $this->_cnx([ 'p'=>'Authenticate', 'data'=>$data ]);
	        return $_r;
        }

        public function _sndxprss($p=NULL){

	        if(!isN($this->tkn)){

		    	$this->data = ['ActionId'=>$p['ActionId'], 'Email'=>$p['Email']];
				$_r = $this->_cnx([ 'p'=>'ExecuteTriggerExpress' ]);
				return $_r;

			}

        }

        public function _getact($p=NULL){

	        if(!isN($this->tkn)){

		    	//OriginalsSent = 1,EffectivesSent = 2,TotalOpen = 3,UniqueOpen = 4,RecurrentOpen = 5,TotalClicks = 6,UniqueClicks = 7,RecurrentClicks = 8,Viral = 9,Suscribe = 10,Unsuscribe = 11,Bounces = 12,TotalSocial = 13,SocialFacebook = 14,SocialTwitter = 15

		    	$this->data = [
		    		'DateFrom'=>(!isN($p['DateFrom'])?$p['DateFrom']:NULL),
		    		'DateTo'=>(!isN($p['DateTo'])?$p['DateTo']:NULL),
		    	];

				$_r = $this->_cnx([ 'p'=>'SearchAction' ]);
				return $_r;

			}

        }

        public function _getactcnt($p=NULL){

	        if(!isN($this->tkn)){

		    	//OriginalsSent = 1,EffectivesSent = 2,TotalOpen = 3,UniqueOpen = 4,RecurrentOpen = 5,TotalClicks = 6,UniqueClicks = 7,RecurrentClicks = 8,Viral = 9,Suscribe = 10,Unsuscribe = 11,Bounces = 12,TotalSocial = 13,SocialFacebook = 14,SocialTwitter = 15

		    	$this->data = [
		    		'ActionId'=>$p['ActionId'],
		    		'FirstResult'=>(!isN($p['FirstResult'])?$p['FirstResult']:'0'),
		    		'Search'=>null,
		    		'Order'=>'asc',
		    		'ActivityId'=>(!isN($p['t'])?$p['t']:'1')
		    	];

				$_r = $this->_cnx([ 'p'=>'SearchContactsByActivity' ]);
				return $_r;

			}

        }


        public function _newcntc_flw($p=NULL){

	        if(!isN($this->tkn)){

		    	$data = [
		    		'email'=>$this->new_eml,
		    		'eventName'=>'evento_sumr',
		    		'attributes'=>[
			    		'EstadoSumr'=>$this->mdlcntest_est,
			    		'ProgramaSumr'=>$this->mdlcnt_mdl
		    		]
		    	];

				$_r = $this->_cnx([ 'p'=>'NewContact', 'data'=>$data, 'trck'=>'ok' ]);

				if($_r->rsl->result == 'Event Tracked.'){ $_r->e='ok'; }else{ $_r->e='no'; }

				return $_r;

			}

        }


        public function _newcntc($p=NULL){

	        if(!isN($this->tkn)){

				if(!isN($this->cnt_tel)){
					$_c=1;
					foreach($this->cnt_tel as $_tel_k=>$_tel_v){
						$__mr_cstm .= "|||telefono_".$_c.":|:".$_tel_v->ps->cod.$_tel_v->v.":|:1";
						$_c++;
					}
				}

		    	$this->data = [
			    	'Token'=>$this->tkn,
		    		'Email'=>$this->new_eml,
		    		'EditCustomFields'=>"EstadoSumr:|:".$this->mdlcntest_est.":|:1|||ProgramaSumr:|:".$this->mdlcnt_mdl.":|:1".$__mr_cstm
		    	];

		    	print_r($this->data);

				$_r = $this->_cnx([ 'p'=>'NewContact' ]);

				if(!isN($_r->rsl->EmailId)){
					$_r->e='ok';
					$this->_newcntc_flw();
				}else{
					$_r->e='no';
				}

				return $_r;

			}

        }




    }

?>