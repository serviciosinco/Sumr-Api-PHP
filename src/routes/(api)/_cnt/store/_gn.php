<?php

    $_jwt = new CRM_JWT();
    $_store = new CRM_Store();

    //---------------------- POST - GET DATA ----------------------//

      $__s_id = _GetPost('store');
      $__start = _GetPost('start');

    //---------------------- GET INFO TROUGH DOMAIN ----------------------//

      if(!isN($__s_id)){
        $_s_i = $__s_id;
        $_s_t = 'pml';
      }

      //$rsp['headersssssss'] = $_SERVER['HTTP_X_APP_KEY'];

      $__s_dt = $_store->GtDt([ 'id'=>$_s_i, 't'=>$_s_t, 'strt'=>$__start ]);

      if(!isN($__s_dt->enc)){
        //_StDbCl([ 'sbd'=>$__s_dt->cl->sbd, 'enc'=>$__s_dt->cl->enc ]);
        $rsp['store_id'] = $__s_dt->enc;
      }

    //---------------------- INCLUSIÓN DE ARCHIVOS ----------------------//


	if($__p2_o == 'admin'){

      include(GL_STRE."admin/_gn.php");

    }elseif($__p2_o == 'd'){

      include(GL_STRE."store.php");

    }

?>