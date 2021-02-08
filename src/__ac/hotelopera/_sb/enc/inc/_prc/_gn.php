<?php 
	$__t = Php_Ls_Cln($_POST['_t']);
	
	if($__t == 'enc'){
		include('enc.php');
	}
	
	$rtrn = json_encode($rsp); 
	if(!isN($rtrn)){ echo $rtrn; }	
	
?>