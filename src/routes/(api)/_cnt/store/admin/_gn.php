<?php

	if($__p3_o == 'login'){

        $__dvc = Php_Ls_Cln($_POST['____dvc']);
        $__sve = Php_Ls_Cln($_POST['securepc_ok']);
        $__usr = Php_Ls_Cln($_POST['usr']);
        $__pss = Php_Ls_Cln($_POST['pss']);

        if($__usr && $__pss) {

            $___ses = new CRM_SES();

            $rsp['token'] = $_jwt->set();

            $___ses->lgin_user = strtolower($__usr);
            $___ses->lgin_pass = $__pss;
            $___ses->lgin_sve = $__sve;
            $___ses->lgin_dvc = $__dvc;
            $___ses->lgin_dvc_web = 'ok';
            $___ses->lgin_usdt = 'ok';
            $rsp = $___ses->_Lgin();

        } else {

            $rsp['e'] = 'no';
            $rsp['m'] = 2;

        }

    }

?>