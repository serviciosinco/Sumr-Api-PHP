<?php 

    $__gtwy->clgtwypay_enc = $_paylnk_d->gtwy->enc;
    
    if($_paylnk_d->sndbx == 'ok'){
        $__gtwy->mpgo_init_sndbx = 'ok';
    }else{
        $__gtwy->mpgo_init_prd = 'ok';
    }
    
    $__gtwy->mdlcntpay_mdlcnt = $_paylnk_d->mdlcnt->id;
    $__gtwy->mdlcntpay_lnk = $_paylnk_d->id;
    
    if($_paylnk_d->sndbx == 'ok'){
        $__gtwy->mdlcntpay_sndbx = 1;
    }else{
        $__gtwy->mdlcntpay_sndbx = 2;
    }

    $__mpgo_pay_r = $__gtwy->mrcpago_pay_dt([ 'id'=>$j_data->data->id, 'sve'=>'ok' ]);
    

    if( !isN($__mpgo_pay_r->save->id) ){
        $rsp['e'] = 'ok';
        $rsp['id'] = $__mpgo_pay_r->save->enc;
    }
    

?>