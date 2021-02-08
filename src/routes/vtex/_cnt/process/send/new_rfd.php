<?php 


    if(
        ( !isN($__r->vtex_cmpg->id) ) &&
        (
            (
                !isN($__r->cnt_nm) &&
                (!isN($__r->cnt_eml) || !isN($__r->cnt_dc))
            ) ||
            $___allow_all == 'ok'
        )
    ){	
        
        if(isN($__r->cnt_eml->w)){

                //------------------ Check Data Before Insert ------------------//
                
                $__CntRfdIn = new CRM_Cnt([ 'cl'=>$__cl->id ]);
 
                //------------------ DATOS BASICOS DE LEAD ------------------//  
                                    
                $__CntRfdIn->cnt_nm = $__r->cnt_nm;
                $__CntRfdIn->cnt_eml = $__r->cnt_eml;
                $_CmpgInsRfdCnt_In = $__CntRfdIn->_Cnt();

                if(!isN($_CmpgInsRfdCnt_In->i)){

                    $_CmpgInsRfd_In = $__CntRfdIn->_vtex->InsRfd_In([ 'ins'=>$__r->vtex_ins->id, 'rfd'=>$_CmpgInsRfdCnt_In->i ]);
                    $_CmpgInsRfd_Pss = $__CntRfdIn->_vtex->CntPss([ 'i'=>$_CmpgInsRfdCnt_In->i, 'eml'=>$v->eml, 'vtex'=>$__r->vtex_cmpg->id ]);

                    if($_CmpgInsRfd_In->e == 'ok'){
                        $_r['e'] = 'ok';
                    }else{
                        $_r['e'] = 'no';
                        $_r['rfi'][] = $_CmpgInsRfd_In;
                        $_r['w'][] = $_CmpgInsRfd_In->w;
                    }

                }else{
                    
                    $_r['w'][] = 'Email lead '.$v->eml.' not created or exists in bd';

                }

                //------------------ PROCESA REGISTRO - END ------------------//

        }else{
            $_r['e'] = 'no';
        }	

    }else{	

        $_r['e'] = 'no_data';
        $_r['cmpg'] = $__r->vtex_cmpg;	
        
    }

?>