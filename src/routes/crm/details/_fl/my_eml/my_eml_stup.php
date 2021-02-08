<?php
	
	$_s = Php_Ls_Cln($_GET['_s']);
	$_scl = Php_Ls_Cln($_GET['_eml']);	
	
	if($_s == 'new'){
		$_eml_inc = 'new.php';
	}elseif($_s == 'upd'){
		$_eml_inc = 'upd.php';
	}
	
	if($_eml_inc != ''){ include('stup/'.$_eml_inc); }
?>