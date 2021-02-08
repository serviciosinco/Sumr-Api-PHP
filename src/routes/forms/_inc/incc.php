<?php

    $Rt = '../../../includes/'; $__pbc='ok'; $__https_off = 'off'; $__bdfrnt = 'ok';
    include($Rt.'inc.php');
    header('Access-Control-Allow-Origin: *');

    //-------------------- GLOBAL - START --------------------//

		$__f = substr($_SERVER['REQUEST_URI'], 1);
		$__pm_1 = PrmLnk('rtn', 1, 'ok');
		$__pm_2 = PrmLnk('rtn', 2, 'ok');
		$__pm_3 = PrmLnk('rtn', 3, 'ok');
        $__pm_4 = PrmLnk('rtn', 4, 'ok');

    //-------------------- PROCESS --------------------//

    $__cl = __Cl([ 'id'=>$__pm_1, 't'=>'sbd' ]);

    if(!isN($__cl->sbd)){
        _StDbCl([ 'sbd'=>$__cl->sbd, 'enc'=>$__cl->enc, 'mre'=>$__dt_cl ]);
        _Cl_Lb([ 'sb'=>$__cl->sbd ]);
        $__head_tt .= $__dt_cl->nm;
    }

?>