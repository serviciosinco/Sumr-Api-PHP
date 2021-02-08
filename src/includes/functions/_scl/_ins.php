<?php

	use MetzWeb\Instagram\Instagram;

	function _InsTkn($p=NULL){
		$instagram = new Instagram([ 'apiKey'=>_INSTAGRAM_CLIENT_ID, 'apiSecret'=>_INSTAGRAM_CLIENT_SECRET, 'apiCallback'=>$p['cll'] ]);
		$data = $instagram->getOAuthToken($p['code']);
		return $data;
	}

?>