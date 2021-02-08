<?php

	class CRM_Mney extends CRM_Cl{

	    function __construct($p=NULL) {
	        parent::__construct();
			$this->__out = new CRM_Out();
	    }

	    function __destruct() {
		    parent::__destruct();
	   	}



		public function Cnvrt_Crrcy($p=NULL){

			$this->__out->url = API_LYRNET_TKN;
			$this->__out->out = 'json';

			$rsp = $this->__out->_Rq();

			return($rsp);

		}
	}

?>