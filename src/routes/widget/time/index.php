<?php

    //----------- Get Parameters -----------//

        $_cbck = $_GET['callback'];

    //----------- Start Build Response -----------//

    include('../includes/inc.php');
    ob_start("cmpr_js");
    date_default_timezone_set('America/Bogota');

    $r['e'] = 'ok';
    $r['d']['date'] = date('Y-m-d');
    $r['d']['time'] = date('H:i:s');
    $r['d']['dayn'] = date('w')==0?'7':date('w');
    $r['d']['full'] = date('Y-m-d H:i:s');

    Hdr_JSON();

    if(isset($r)){ echo $_cbck . '(' .json_encode($r) . ')' ; }

    ob_end_flush();

?>