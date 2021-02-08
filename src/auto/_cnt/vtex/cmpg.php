<?php

$_g_alw = $this->tallw([ 't'=>'key', 'id'=> 'vtex_cmpg' ]);

if( $_g_alw->est == 'ok' ){

    $this->_Auto_Inc(GRP_FL_VTEX.'cmpg/_gn.php');

}else{

	echo $this->nallw('Vtex - Campaigns - Off');

}

?>