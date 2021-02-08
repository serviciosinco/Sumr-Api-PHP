<?php 

    $__Cls_Org = new CRM_Org(); 
    $__Cls_Org->post = $_POST;

    if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "EdMarks")) {

        $vlt = $__Cls_Org->OrgSds_Sls_Chck(); 

        if($vlt->e != 'ok'){
            $Result = $__Cls_Org->OrgSds_Sls_In(); 
        }else{
            $rsp['w'] = 'Esta fecha ya cuenta con información de ventas y transacciones';
        }
        
    }

    if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "EdMarks")) { 

        if( $_POST['orgsdsarrsls_f'] == $_POST['orgsdsarrsls_f_hd'] ){
            $Result = $__Cls_Org->OrgSds_Sls_Upd();
        }else{
            $vlt = $__Cls_Org->OrgSds_Sls_Chck(); 

            if($vlt->e != 'ok'){
                $Result = $__Cls_Org->OrgSds_Sls_Upd();
            }else{
                $rsp['w'] = 'Esta fecha ya cuenta con información de ventas y transacciones';
            }   
        }

        
  
    }

    if($Result->e == 'ok'){
        $rsp['e'] = 'ok';
        $rsp['m'] = 1;
        $rsp['aud'] = $Result;
    }else{
        $rsp['e'] = 'no';
        $rsp['m'] = 2;
    }

?>