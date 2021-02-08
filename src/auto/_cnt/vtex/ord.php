<?php

$_g_alw = $this->tallw([ 't'=>'key', 'id'=> 'vtex_ord' ]);

if( $_g_alw->est == 'ok' ){

    $this->_Auto_Inc(GRP_FL_VTEX.'ord/_gn.php');

}else{

	echo $this->nallw('Vtex - Orders - Off');

}

?>