<?php 


    if(!isN($rsp_now_v->id) && $__mdlstp->us != $rsp_now_v->id){   

        echo $this->li('Set user ('.$__mdlstp->us.') from mdlstp');
        
        $_rsp_sme = 'ok';

        $__tra->tra_enc = $rwTraRsp['tra_enc'];
        $__tra->trarsp_us = $__mdlstp->us;
        $__tra->trarsp_us_asg = 3;
        $__tra->trarsp_tp = _CId('ID_USROL_RSP');

        $PrcDtSve = $__tra->In_Tra_Rsp([ 'tp'=>_CId('ID_USROL_RSP') ]);

        if($PrcDtSve->e != 'ok'){
            $__prc_all = 'no';
            $__w .= '$PrcDtSve error:'.print_r($PrcDtSve->w, true);
            $_rsp_ls .= $this->err('Responsable for task '.$rwTraRsp['tra_enc'].' Changed Problem ');
            $_rsp_ls .= $this->err( print_r($PrcDtSve->w, true) );
        }else{
            $rspnw++;
        }

    }

?>