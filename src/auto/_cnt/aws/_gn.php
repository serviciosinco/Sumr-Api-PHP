<?php 

//------------------- REQUEST FILE ---------------------//

$_g_alw = $this->tallw([ 't'=>'key', 'id'=>'aws' ]);

if( $_g_alw->est == 'ok' ){

	if(!isN($this->g__s2)){		
		$this->_Auto_Inc(GL_AWS.$this->g__s2.'.php'); 
	}else{
		$this->_Auto_Inc(GL_AWS.'aws_mtrc.php');
		$this->_Auto_Inc(GL_AWS.'aws_scale.php');
	}	

}else{

	echo $this->nallw('Global Aws Off');

}

?>