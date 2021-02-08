<?php

	function TmeDctr_Tkn($p=NULL){

		$__tmedctr_rdrct = DMN_OAUTH.'timedoctor/?_api='.$p['api'].'&_us='.$p['us'].'&_cl='.$p['cl'];
		$__tmedctr_tknurl = 'https://webapi.timedoctor.com/oauth/v2/token?client_id='._TIMEDOCTOR_CLIENT_ID.'&client_secret='._TIMEDOCTOR_CLIENT_KEY.'&grant_type=authorization_code&redirect_uri='.urlencode($__tmedctr_rdrct).'&code='.		$p['code'].'&response_type=token';


		$CurlRQ = new CRM_Out();
		$CurlRQ->url = $__tmedctr_tknurl;
		$CurlRQ->o_tmout = 5;
		$rsp = $CurlRQ->_Rq();

		return _jEnc($rsp->rsl);

	}




	function TmeDctr_Us($p=NULL){

		$__tmedctr_us = 'https://webapi.timedoctor.com/v1.1/companies';

		$CurlRQ = new CRM_Out();
		$CurlRQ->url = $__tmedctr_us;
		$CurlRQ->o_tmout = 5;
		$CurlRQ->o_header_http = array( 'Authorization: Bearer '.$p['tkn'] );
		$rsp = $CurlRQ->_Rq();
		$user = json_decode($rsp->rsl);

		return _jEnc($user->user);

	}

?>