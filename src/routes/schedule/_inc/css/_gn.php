<?php

	$Rt = '../../../../includes/'; $__pbc='ok'; $__https_off = 'off'; include($Rt.'inc.php');

	Hdr_CSS();

	ob_start("cmpr_css");

		$_fl = basename($_SERVER['REQUEST_URI']);
		include( $_fl );

	ob_end_flush();


?>