<?php 
	
$_g_alw = $this->tallw([ 't'=>'key', 'id'=>'lck_tmp' ]);

if( $_g_alw->est == 'ok' ){

	if(class_exists('CRM_Cnx')){ 	
		
		echo $this->h1('CLEAN TMP FOLDER - Hour '.date('H'));
		
		if( (date('H') >= 23 || date('H') <= 2)){		
				
			$tmp_fle = dirname(__FILE__, 5).'/'.DIR_TMP_FLE;
			
			$tmp_bco = dirname(__FILE__, 5).'/'.DIR_TMP_BCO;
			
			echo $this->h1('CLEAN FLE - Hour '.date('H'));	
			$this->_cln_fldr_tmp($tmp_fle);
			
			echo $this->h1('CLEAN BCO - Hour '.date('H'));	
			$this->_cln_fldr_tmp($tmp_bco);	
		
		}			
		
	}

}else{

	echo $this->nallw('Global Delete Temp Files Off');

}	

?>