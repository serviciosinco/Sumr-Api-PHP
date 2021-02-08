<?php
	$__https_off = 'off'; ini_set("max_execution_time", 300);
	include('../includes/inc.php');

	$__i = json_decode(GtPrgGenDt(PrmLnk('rtn', 2), 'enc'));
	$__f = PrmLnk('rtn', 1).'/'.$__i->fle;

	Hdr_PDF($__f, $__i->fle_nm);
?>