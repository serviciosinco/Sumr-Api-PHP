<?php 

    echo SlDt([ 't'=>'hr', 'id'=>'dwn_tm_prg_vl', 'va'=>'', 'rq'=>'no', 'ph'=>TX_HR, 'lmt'=>'no', 'yr'=>'ok', 'cls'=>CLS_CLND ]);
    echo OLD_HTML_chck('dwn_tm_prg_bfe', 'Día anterior ' ,'', 'in');

    $___days_week = _WkDays();

    foreach($___days_week as $_k => $_v){
        echo OLD_HTML_chck('dwn_tm_prg_d_'.$_v->id, $_v->tt,'', 'in');
    }

    echo HTML_BR;

    

?>
