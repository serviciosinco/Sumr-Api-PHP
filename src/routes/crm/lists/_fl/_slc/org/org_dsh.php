<?php 

    $_ls = Php_Ls_Cln($_POST['_ls']);
    $_ls_i = Php_Ls_Cln($_POST['_ls_i']);
    $_tp = Php_Ls_Cln($_POST['_tp']);
    $_vl = Php_Ls_Cln($_POST['_vl']);
    $_tpo = Php_Ls_Cln($_POST['_tpo']);

    if($_tpo == 'card'){
        $mlt = 'no';
        $_vl = $_vl;
    }else{
        $mlt = 'ok'; 
        $_vl = explode(",", $_vl);  
    }

    if(!isN($_ls_i)){
        $__dt_obj = __LsDt(['k'=>'org_dsh_otp', 'id'=>$_ls_i, 'tp'=>'id', 'no_lmt'=>'ok' ]);
        $_ls = $__dt_obj->d->lst->vl;
    }

    if($_ls == 'LsCntEst'){
        echo LsCntEst([ 'id'=>'orgdsh_vl', 'v'=>'id_siscntest', 'mlt'=>$mlt, 'mdlstp'=>$_tp, 'va'=>$_vl ]); 
        $CntWb .= JQ_Ls('orgdsh_vl', FM_LS_EST);    
    }elseif($_ls == 'LsCd'){
        echo LsCdOld([ 'id'=>'orgdsh_vl','v'=>'id_siscd', 'va'=>$_vl, 'mlt'=>$mlt ]);  
        $CntWb .= JQ_Ls('orgdsh_vl',FM_LS_SLCD);    
    }
    

?>