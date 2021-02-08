<?php

    $_us = Php_Ls_Cln($_POST['user_form']);
    $_pss = Php_Ls_Cln($_POST['passwor_for']);

    if(!isN( $__cl->bd )){

        $__Cls_Org = new CRM_Org();
        $__Cls_Org->us = $_us;
        $__Cls_Org->pss = $_pss;

        $rpd = $__Cls_Org->ChckPssMarks();

        if($rpd->tot == 1){

            $_r['e'] = 'ok';
            $cnt = GtOrgSdsCntDt([ 'bd' => $__cl->bd, 'id' =>$rpd->cnt, 'tpro'=> ID_ORGTP_MARKS, 'orgsds'=> $rpd->org ]);

            if(!isN( $cnt->enc )){

                $_SESSION[DB_CL_ENC_SES.MM_CNT] = $cnt->enc;
                $_SESSION['eml_mrks'] = $_us;
                $_SESSION['org_mrks'] = $cnt->org->enc;

                $_r['ses'] = $_SESSION[DB_CL_ENC_SES.MM_CNT];
                $_r['data'] = $cnt;
                $_r['cnt'] = $cnt->enc;
            }

        }else{
            $_r['e'] = 'no';
        }
    }
?>