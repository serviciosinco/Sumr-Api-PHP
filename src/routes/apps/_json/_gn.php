<?php $Rt = '../../../includes/'; $__https_off = 'off'; $__no_sbdmn = 'ok'; include($Rt.'inc.php');

Hdr_JSON();

$__i = Php_Ls_Cln($_POST['_i']);
$__t = Php_Ls_Cln($_GET['_t']);
$__c = Php_Ls_Cln($_GET['_c']);

if(!isN($__c)){
	$__dt_cl = __Cl(['id'=>$__c, 't'=>'enc']);
}

if($__t == 'enc'){
	include('enc.php');
}elseif($__t == 'stup_mdlgen'){
	include('stup_mdlgen.php');
}

$rtrn = json_encode($rsp);
if(!isN($rtrn)){ echo $rtrn; }

ob_end_flush();
?>