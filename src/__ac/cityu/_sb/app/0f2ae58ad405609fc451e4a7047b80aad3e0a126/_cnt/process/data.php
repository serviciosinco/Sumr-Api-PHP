<?php 

    $__Cls_Org = new CRM_Org(); 
    

    if(!isN($_POST['i'])){
        $__Cls_Org->id_org = $_POST['i'];
        $_r['app'] = $__Cls_Org->OrgSds_Sls_Ls();
    }else if(!isN($_POST['t']) && $_POST['t'] == 'logout' ){
        unset($_SESSION[DB_CL_ENC_SES.MM_CNT]);
        session_destroy();
        $_r['e'] = 'ok';
    }
   
    
	
?>