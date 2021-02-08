<?php 
	
	
	//---------------------- SET DEFAULT E --------------//	
	
		$this->print_json['e'] = 'no';
	
	//---------------------- PROCESS REQUEST --------------//
	
		$this->_Auto_Inc(DIR_CNT.'_gn.php');
	
	//---------------------- COMPRIME E IMPRIME RESULTADO --------------//	


		ob_start("cmpr_fm"); 
		Hdr_JSON();			
		$rtrn = json_encode( $this->print_json );
		if(!isN($rtrn)){ echo $rtrn; }	
		ob_end_flush(); 
		header("HTTP/1.1 200 OK"); 
	
?>