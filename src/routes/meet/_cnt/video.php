<?php 

    //---------------------- GET / POST PARAMETERS ----------------------//

        $__room = Php_Ls_Cln($_GET['room']); // Id ROOM sumr
        $__burl = Php_Ls_Cln($_GET['burl']); // Url invoked by
        $__lead = Php_Ls_Cln($_GET['_c']);
        $__user = Php_Ls_Cln($_GET['_u']);
    
    //---------------------- INCLUDE FILES ----------------------//    

    if($_call_act=='token'){
        include(dirname(__FILE__).'/video/token.php');
    }else{
        
        $__vcall = $call->CallRoom_Chk([ 'enc'=>$__room ]);
        
        if(!isN( $__lead )){
            $__cnt = GtCntDt([ 't'=>'enc', 'id'=>$__lead, 'bd'=>$__dt_cl->bd ]);
        }

        if(!isN( $__user )){
            $__us = GtUsDt($__user, 'enc');
        }

        if(!isN($__vcall->id) && !isN($__vcall->unm) && (!isN($__cnt->id) || !isN($__us->id))){
            include(dirname(__FILE__).'/video/html.php');
        }else{
            $_rdrct = 'ok';
        }

    }
?>