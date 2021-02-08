<?php  
    $rsp['e'] = 'ok';

    
    $_fchs = [];
    if(!isN($_POST['data']['fi']) && !isN($_POST['data']['ff'])){

        $_fchs = [ 'fi'=>$_POST['data']['fi'], 'ff'=>$_POST['data']['ff'] ];

        $_Ec_Snd_All = GtEcSndTot(array_merge([ 't'=>'all', 'bd'=>'sumr_c_uexternado' ], $_fchs ))->tot; //Total
        $_Ec_Snd_Acpt = GtEcSndTot(array_merge([ 't'=>'snd', 'bd'=>'sumr_c_uexternado' ], $_fchs ))->tot; //Enviados
        $_Ec_Snd_Op = GtEcSndTot(array_merge([ 't'=>'op', 'bd'=>'sumr_c_uexternado' ], $_fchs ))->tot; //Abiertos
        $_Ec_Snd_Err = GtEcSndTot(array_merge([ 't'=>'err', 'bd'=>'sumr_c_uexternado' ], $_fchs ))->tot; //Rebotes
        $_Ec_Snd_Efct = ($_Ec_Snd_Acpt-$_Ec_Snd_Err); //Efectivos
        $_Ec_Snd_Trck = GtEcSndTot(array_merge([ 't'=>'trck', 'bd'=>'sumr_c_uexternado' ], $_fchs ))->tot; //Clicks únicos
        $_Ec_Snd_Rmv = GtEcSndTot(array_merge([ 't'=>'rmv', 'bd'=>'sumr_c_uexternado' ], $_fchs ))->tot; //Removidos

    }else{
        $_Ec_Snd_All = GtTotDt([ 't'=>'key', 'i'=>'ec_snd_all' ])->vl; //Total
        $_Ec_Snd_Acpt = GtTotDt([ 't'=>'key', 'i'=>'ec_snd_snd' ])->vl; //Enviados
        $_Ec_Snd_Op = GtTotDt([ 't'=>'key', 'i'=>'ec_snd_op' ])->vl; //Abiertos
        $_Ec_Snd_Err = GtTotDt([ 't'=>'key', 'i'=>'ec_snd_err' ])->vl; //Rebotes
        $_Ec_Snd_Efct = GtTotDt([ 't'=>'key', 'i'=>'ec_snd_efct' ])->vl; //Efectivos
        $_Ec_Snd_Trck = GtTotDt([ 't'=>'key', 'i'=>'ec_snd_trck' ])->vl; //Clicks únicos
        $_Ec_Snd_Rmv = GtTotDt([ 't'=>'key', 'i'=>'ec_snd_rmv' ])->vl; //Removidos
    } 

    $rsp['dsp'] = GtEcDlvr_T_Ls(array_merge([ 't'=>'dsp' ], $_fchs )); //Dispositivos
    $rsp['os'] = GtEcDlvr_T_Ls(array_merge([ 't'=>'os' ], $_fchs )); //Moviles
    $rsp['brws'] = GtEcDlvr_T_Ls(array_merge([ 't'=>'brws' ], $_fchs )); //Browers
    $rsp['clnt'] = GtEcDlvr_T_Ls(array_merge([ 't'=>'clnt' ], $_fchs )); //Browers
    $rsp['bnct'] = GtEcDlvr_T_Ls(array_merge([ 't'=>'bnct' ], $_fchs )); //Browers

    $rsp['ec_cmpg'] = GtDshEcCmpg($_fchs);
    $rsp['ec_snd'] = GtDshEcSnd($_fchs);

    $rsp['ls']['all']['id'] = 'g_tot_glb';
    $rsp['ls']['all']['tt'] = 'Total';
    $rsp['ls']['all']['vl'] = _Nmb(100, 5);
    $rsp['ls']['all']['lbl'] = _Nmb($_Ec_Snd_All, 3);

    $rsp['ls']['acpt']['id'] = 'g_tot_snd_glb';
    $rsp['ls']['acpt']['tt'] = 'Enviados';
    $rsp['ls']['acpt']['vl'] = _Nmb(( ($_Ec_Snd_Acpt*100)/$_Ec_Snd_All ), 5);
    $rsp['ls']['acpt']['lbl'] = _Nmb($_Ec_Snd_Acpt, 3);

    $rsp['ls']['op']['id'] = 'g_tot_op_glb';
    $rsp['ls']['op']['tt'] = 'Abiertos';
    $rsp['ls']['op']['vl'] = _Nmb(( ($_Ec_Snd_Op*100)/$_Ec_Snd_All ), 5);
    $rsp['ls']['op']['lbl'] = _Nmb($_Ec_Snd_Op, 3);

    $rsp['ls']['err']['id'] = 'g_tot_err_glb';
    $rsp['ls']['err']['tt'] = 'Rebotes';
    $rsp['ls']['err']['vl'] = _Nmb(( ($_Ec_Snd_Err*100)/$_Ec_Snd_All ), 5);
    $rsp['ls']['err']['lbl'] = _Nmb($_Ec_Snd_Err, 3);

    $rsp['ls']['efct']['id'] = 'g_tot_efct_glb';
    $rsp['ls']['efct']['tt'] = 'Efectivos';
    $rsp['ls']['efct']['vl'] = _Nmb(( ($_Ec_Snd_Efct*100)/$_Ec_Snd_All ), 5);
    $rsp['ls']['efct']['lbl'] = _Nmb($_Ec_Snd_Efct, 3);

    $rsp['ls']['trck']['id'] = 'g_tot_trck_glb';
    $rsp['ls']['trck']['tt'] = 'Clicks únicos';
    $rsp['ls']['trck']['vl'] = _Nmb(( ($_Ec_Snd_Trck*100)/$_Ec_Snd_All ), 5);
    $rsp['ls']['trck']['lbl'] = _Nmb($_Ec_Snd_Trck, 3);

    $rsp['ls']['rmv']['id'] = 'g_tot_rmv_glb';
    $rsp['ls']['rmv']['tt'] = 'Removidos';
    $rsp['ls']['rmv']['vl'] = _Nmb(( ($_Ec_Snd_Rmv*100)/$_Ec_Snd_All ), 5);
    $rsp['ls']['rmv']['lbl'] = _Nmb($_Ec_Snd_Rmv, 3);

?>