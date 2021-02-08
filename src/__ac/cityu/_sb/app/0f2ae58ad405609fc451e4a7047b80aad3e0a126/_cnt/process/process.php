<?php 

    $__Cls_Org = new CRM_Org(); 
    $__Cls_Org->post = $_POST;

    if($_POST['orgsdsarr_sls_tp_bd'] == 'Insert'){

        $vlt = $__Cls_Org->OrgSds_Sls_Chck(); 

        if($vlt->e != 'ok'){

            $__Cls_Org->post['dsc'] = 'Se ingreso la venta';
        
            $Result = $__Cls_Org->OrgSds_Sls_In(); 

            if($Result->e == 'ok'){
                $__Cls_Org->cl = $__cl->bd;
                $Results = $__Cls_Org->OrgSds_Aud_In(); 
                $_r['aud'] = $Results;
            }
        }else{
            $_r['msj'] = 'Esta fecha ya cuenta con información de ventas y transacciones';
        }
        
    }else if($_POST['orgsdsarr_sls_tp_bd'] == 'Update'){
        $Result = $__Cls_Org->OrgSds_Sls_Upd(); 

        if($Result->e == 'ok'){

            $__Cls_Org->post['dsc'] = 'Se actualizo la venta';

            $__Cls_Org->cl = $__cl->bd;
            $Results = $__Cls_Org->OrgSds_Aud_In(); 
            $_r['aud'] = $Results;
        }

    }

    if($Result->e == 'ok'){
        $_r['e'] = 'ok';
        $_r['m'] = 1;
    }else{
        $_r['e'] = 'no';
        $_r['m'] = 2;
    }
	
?>