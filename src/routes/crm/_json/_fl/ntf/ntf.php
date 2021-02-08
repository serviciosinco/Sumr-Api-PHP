<?php 
	
	$_tp = Php_Ls_Cln($_POST["tp"]);
	$_enc = Php_Ls_Cln($_POST["enc"]);
	
	try {
		
		if($_tp == "est"){
			
			$_est = Php_Ls_Cln($_POST["est"]);
			
			/* <--- Modifica el estado de la notificación ---> */
			$_CRM_Ntf = new CRM_Ntf();
			$_CRM_Ntf->ntf_id_upd = $_enc; 
			$_Est = $_CRM_Ntf->Upd([ 'e'=>$_est ]);
			
			$rsp['e'] = $_Est->e;
			
		}
		
	}catch (Exception $e) {
	    echo 'Error desde el archivo ntf: ',  $e->getMessage(), "\n";
	}
	
?>