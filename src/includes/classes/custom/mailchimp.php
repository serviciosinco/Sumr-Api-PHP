<?php

use \DrewM\MailChimp\MailChimp;


class API_CRM_Mailchimp{


	function __construct($p=NULL){
	}

	function init(){
		$this->cnx = new MailChimp('0c62e0fe9276c4d04530902f6d7dacf4-us20');
	}


}




?>