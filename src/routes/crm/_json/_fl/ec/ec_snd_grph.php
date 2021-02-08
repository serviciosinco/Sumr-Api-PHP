<?php 

   try{
    /*
        $__t = _GetPost('__t'); 

        if( !isN($__t) ){

            $_ls_dsp = GtEcDlvr_T_Ls([ 't'=>$__t ]);
            
            if( $_ls_dsp->tot > 0 ){

                foreach($_ls_dsp->ls as $_k => $_v){
                    $__grph_dsp[$_k]["name"] = $_v->nm;
                    $__grph_dsp[$_k]["y"] = $_v->tot;
                }

                $rsp['e'] = 'ok';
                $rsp['_d'] = $__grph_dsp;

            }else{
                $rsp['e'] = 'no';
            }
            
        }else{
            $rsp['e'] = 'no';
        }*/
        
    }catch(Exception $e){
        $rsp['e'] = 'no';
        $rsp['w'] = TX_NSPPCSR .$e->getMessage();
    }

?>