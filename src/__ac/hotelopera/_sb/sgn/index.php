<?php 
	
	$__sng = new API_CRM_sgn();
	$__sng->id_sgn = $__dt_sgn->id; 
	$__sng->sgn_cd = $__dt_sgn->cd;
	$__sng->sgn_fl = $__dt_sgn->dir;
	$__body = $__sng->_bld();
	
	echo $__body;
?>