<?php 
	
	try{

        $_c_org = new CRM_Org();
	    $__org = Php_Ls_Cln($_POST['_org']);
	    $__tp = Php_Ls_Cln($_POST['_tp']);

        if($__tp == 'marks'){
            $grf = $_c_org->OrgGrphMarks([ 'org'=>$__org ]);
            $rsp['org']['grph1'] = $grf;
        }

        

		
		
	
	}catch(Exception $e){
		
		$rsp['e'] = 'no';
		$rsp['w'] = TX_NSPPCSR.$e->getMessage();
		
	}
	
?>