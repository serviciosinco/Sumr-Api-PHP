<?php

    $__tra = GtTraDhsLs([
        'fl_tra'=>'AND tra_est NOT IN ('._CId('ID_TRAEST_ARCHV').', '._CId('ID_TRAEST_ELI').')',
        't_id_tra'=>'enc',
        'dtl'=>'no',
        'prvt'=>'ok',
        'd'=>[ 'tra'=>'ok' ]
    ]);

    if(!isN($__tra->ls)){

        $__tra_col_ls = GtTraDshColLs([ 'prvt'=>'ok' ]);

       //$rsp['tmp__'] = $__tra_col_ls->q;

        if(!isN($__tra_col_ls->ls)){
            foreach($__tra_col_ls->ls as $tracol_k=>$tracol_v){
                $rsp['s']['cols'][$tracol_v->enc] = $tracol_v;
            }
        }

        foreach($__tra->ls as $tra_k=>$tra_v){
            if(!isN($tra_v->enc)){
                //$rsp['s']['q'][] = $__tra->q;
                $rsp['s']['cols'][$tra_v->enc] = $tra_v;
            }
        }

    }else{

        $__tra_col_ls = GtTraDshColLs([ 'prvt'=>'ok' ]);

        if(!isN($__tra_col_ls->ls)){
            foreach($__tra_col_ls->ls as $tracol_k=>$tracol_v){
                $rsp['s']['cols'][$tracol_v->enc] = $tracol_v;
            }
        }

    }

    //$rsp['tmp__'] = $__tra;
    $rsp['e'] = 'ok';

?>