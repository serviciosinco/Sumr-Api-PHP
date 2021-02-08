<?php 	
	
$_g_alw = $this->tallw([ 't'=>'key', 'id'=>'whtsp' ]);

if( $_g_alw->est == 'ok' ){

	//-------------------- REQUEST FIhLE --------------------//
		
	define('GRP_WHTSP', DIR_CNT.'whtsp/');
	define('GL_WHTS_MSV', 'msv/'); // Messages

	echo $this->h1('All about Whatsapp APIs');
	
	if(!isN($this->g__s2)){
		
		$this->_Auto_Inc(GRP_WHTSP.$this->g__s2.'.php');
	
	}else{
		
		//----------// FACEBOOK DATA //----------//
		
		$this->_Auto_Inc(GRP_WHTSP.'msv_acc.php');
		$this->_Auto_Inc(GRP_WHTSP.'msv_cnv.php');
		$this->_Auto_Inc(GRP_WHTSP.'msv_cnv_msg.php');
		
	}

}else{

	echo $this->nallw('Global Whatsapp - Off');

}

?>