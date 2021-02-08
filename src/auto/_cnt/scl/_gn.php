<?php 

$_g_alw = $this->tallw([ 't'=>'key', 'id'=>'scl' ]);

if( $_g_alw->est == 'ok' ){


	//-------------------- AMOUNT AND BILLING CHECK --------------------//
		
		$fll = new API_FullContact();
		$fll_r = $fll->Status()->c;
		$__upd = UPD_Thrd(['id'=>5]); 
	
	//-------------------- REQUEST FILE --------------------//
		
		define('GRP_FL_SCL', 'scl/');
		define('GL_SCL_FB', 'fb/'); // Actions


		if(!isN($this->g__s2)){
			
			$this->_Auto_Inc(DIR_CNT.GRP_FL_SCL.$this->g__s2.'.php'); 
		
		}else{

			//----------// FACEBOOK DATA //----------//
			
			//$this->_Auto_Inc(DIR_CNT.GRP_FL_SCL.'fb_forms.php');
			//$this->_Auto_Inc(DIR_CNT.GRP_FL_SCL.'fb_acc.php');
			//$this->_Auto_Inc(DIR_CNT.GRP_FL_SCL.'fb_acc_cnv.php');
			//$this->_Auto_Inc(DIR_CNT.GRP_FL_SCL.'fb_post.php');
			$this->_Auto_Inc(DIR_CNT.GRP_FL_SCL.'fb_from.php');	
			//$this->_Auto_Inc(DIR_CNT.GRP_FL_SCL.'fb_acc_get.php');
			
			
			//----------// TWITTER DATA //----------//
				
			//_Auto_Inc(DIR_CNT.GRP_FL_SCL.'tw_acc_cnv.php');
	
			
		}

}else{

	echo $this->nallw('Global Social Media Off');

}

?>