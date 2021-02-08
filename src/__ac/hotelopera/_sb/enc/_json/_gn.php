<?php Hdr_JSON();

$__i = Php_Ls_Cln($_POST['_i']);	
$__t = Php_Ls_Cln($_GET['_t']);

if($__t == 'enc'){
	include('enc.php');
}

$rtrn = json_encode($rsp); 
if(!isN($rtrn)){ echo $rtrn; }	

ob_end_flush(); 
?>