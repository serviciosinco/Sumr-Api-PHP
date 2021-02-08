<?php 

$_g_alw = $this->tallw([ 't'=>'key', 'id'=>'eml' ]);

if( $_g_alw->est == 'ok' ){

	//-------------------- REQUEST FILE --------------------//

	define('GRP_FL_EML', 'eml/');
	define('GL_EML_IMAP', 'imap/'); // Actions

	if(!isN($this->g__s2)){ 
		
		$this->_Auto_Inc(DIR_CNT.GRP_FL_EML.$this->g__s2.'.php');
		
	}else{

		$this->_Auto_Inc(DIR_CNT.GRP_FL_EML.'gmail_box.php');
		$this->_Auto_Inc(DIR_CNT.GRP_FL_EML.'gmail_cnv.php');
		$this->_Auto_Inc(DIR_CNT.GRP_FL_EML.'gmail_cnv_empty.php');
		$this->_Auto_Inc(DIR_CNT.GRP_FL_EML.'gmail_cnv_msg.php');
		
		$this->_Auto_Inc(DIR_CNT.GRP_FL_EML.'imap_box.php');
		/*$this->_Auto_Inc(DIR_CNT.GRP_FL_EML.'imap_cnv_msg.php');
		$this->_Auto_Inc(DIR_CNT.GRP_FL_EML.'imap_cnv_msg_attr.php');
		$this->_Auto_Inc(DIR_CNT.GRP_FL_EML.'imap_cnv.php');
		$this->_Auto_Inc(DIR_CNT.GRP_FL_EML.'imap_msg_empty.php');
		
		$this->_Auto_Inc(DIR_CNT.GRP_FL_EML.'outlook_box.php');	*/
		
	}
	
}else{

	echo $this->nallw('Global Email Boxes Off');

}		
		
		
?>