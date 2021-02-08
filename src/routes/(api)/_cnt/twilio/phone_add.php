<?php 

	$__idc = Php_Ls_Cln($_GET['_idc']);
	$__status = Php_Ls_Cln($_POST['VerificationStatus']);	
	
	if($__status == 'success'){
		
		$__Call = new CRM_Call();
		$PrcDt = $__Call->Upd_PhnAdd([ 'id'=>$__idc, 'est'=>'o' ]);

		$rsp = $PrcDt;
		
	}
		
	
?>