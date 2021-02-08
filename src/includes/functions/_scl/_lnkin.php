<?php


	function Lnkin_Tkn($p=NULL){

		$__url = 'https://www.linkedin.com/oauth/v2/accessToken';

		$post['grant_type'] = 'authorization_code';
		$post['code'] = $p['code'];
		$post['client_id'] = _LINKEDIN_CLIENT_ID;
		$post['client_secret'] = _LINKEDIN_CLIENT_SECRET;
		$post['redirect_uri'] = $p['cll'];

		$CurlRQ = new CRM_Out();
		$CurlRQ->url = $__url;
		$CurlRQ->o_tmout = 5;
		$CurlRQ->o_post = true;
		$CurlRQ->o_post_f = http_build_query($post);
		$CurlRQ->o_header_http = array(
										'Content-Type: application/x-www-form-urlencoded'
									);

		$rsp = $CurlRQ->_Rq();

		return _jEnc($rsp->rsl);

	}


	function Lnkin_Us($p=NULL){

		$__url = 'https://api.linkedin.com/v2/me?projection=(id,firstName,lastName,profilePicture(displayImage~:playableStreams))';

		$CurlRQ = new CRM_Out();
		$CurlRQ->url = $__url;
		$CurlRQ->o_tmout = 5;
		$CurlRQ->o_header_http = array( 'Authorization: Bearer '.$p['tkn'] );
		$rsp = $CurlRQ->_Rq();
		$user = json_decode($rsp->rsl);

		return _jEnc($user);

	}

	function Lnkin_Emp($p=NULL){

		$__url = 'https://api.linkedin.com/v2/companies?format=json&is-company-admin=true';

		$CurlRQ = new CRM_Out();
		$CurlRQ->url = $__url;
		$CurlRQ->o_tmout = 5;
		$CurlRQ->o_header_http = array( 'Authorization: Bearer '.$p['tkn'] );
		$rsp = $CurlRQ->_Rq();
		$user = json_decode($rsp->rsl);

		return _jEnc($user);

	}


	function Lnkin_EmpDt($p=NULL){

		$__url = 'https://api.linkedin.com/v2/companies/'.$p['id'].':(id,name,ticker,description,logo-url)?format=json';

		$CurlRQ = new CRM_Out();
		$CurlRQ->url = $__url;
		$CurlRQ->o_tmout = 5;
		$CurlRQ->o_header_http = array( 'Authorization: Bearer '.$p['tkn'] );
		$rsp = $CurlRQ->_Rq();
		$user = json_decode($rsp->rsl);

		return _jEnc($user);

	}


?>