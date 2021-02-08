<?php

        $pth = '../../../includes/';
        $__https_off = 'off';
        $__no_sbdmn = 'ok';
        $__bdfrnt = 'ok';
        include($pth .'inc.php');

    //--------- POST Parameters ---------//

        $_id = Php_Ls_Cln($_POST['id']);

    //--------- Process Data ---------//

        $__dtrd = GtRdDt($_id, 'pm');

    //--------- Return Data ---------//

        $r['id'] = $__dtrd->enc;
