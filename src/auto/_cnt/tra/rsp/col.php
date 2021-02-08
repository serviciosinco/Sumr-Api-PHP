<?php 

    foreach($__rsp->us as $__rsptp_k=>$__rsptp_v){

        if($__rsptp_v->id == _CId('ID_USROL_RSP_DFT') || $__rsptp_v->id == _CId('ID_USROL_OBS_DFT')){

            echo $this->li('Process '.$__rsptp_v->nm);

            //print_r($__rsptp_v);
            
            if(!isN($__rsptp_v->ls)){

                //------------------------ SEARCH FOR LESS ASIGNMENTS ------------------------//
                
                if($__rsptp_v->id == _CId('ID_USROL_RSP_DFT')){

                    $_rsp_less_tot = null;
                    $_rsp_less_id = null;
                    $_rsp_less_nm = null;

                    foreach($__rsptp_v->ls as $__rsp_less_k=>$__rsp_less_v){
                        echo $this->li( 'User '.$__rsp_less_v->nm.' has '.$__rsp_less_v->now->tot );
                        if($__rsp_less_v->now->tot < $_rsp_less_tot || isN($_rsp_less_tot)){ 
                            $_rsp_less_tot = $__rsp_less_v->now->tot; 
                            $_rsp_less_id = $__rsp_less_v->enc;
                            $_rsp_less_nm = $__rsp_less_v->nm;
                        }
                    }

                    echo $this->li('The user that hass less tasks is '.$_rsp_less_nm.' ('.$_rsp_less_id.')' );

                }

                foreach($__rsptp_v->ls as $__rsp_k=>$__rsp_v){

                    //------------------------ PROCESS RESPONSABLE ------------------------//

                    if($__rsptp_v->id == _CId('ID_USROL_RSP_DFT') && !isN($__rsp_v->id)){ 

                        $_tprsp = 'rsp';
                        echo $this->li('There is another responsable now?');
                    
                        $_rsp_now = GtTraRspDt([ 't'=>'tra', 'k'=>'enc', 'id_tra'=>$rwTraRsp['tra_enc'], 'tp'=>$_tprsp ]);
                        $_rsp_ls = ''; 
                        $_rsp_sme = '';

                        echo $this->li('Responsables:'.$_rsp_now->tot);
                        $_rsp_del_go = 'ok'; 

                        if($_rsp_now->tot > 0){

                            foreach($_rsp_now->ls as $rsp_now_k=>$rsp_now_v){

                                $_rsp_ls .= $this->li('Responsable before '.$rsp_now_v->us_nm.' ('.$rsp_now_v->us_id.')');

                                if(!isN($rsp_now_v->id) && $_rsp_less_id != $rsp_now_v->us_id /*$__rsp_v->id != $rsp_now_v->us_id*/){
                                    
                                    $PrcDtEli = $__tra->Del_Tra_Rsp(['id'=>$rsp_now_v->id]);
                                    
                                    if($PrcDtEli->e != 'ok'){ 
                                        $__w .= '$PrcDtEli error:'.$PrcDtEli->w;
                                        $_lets_in = 'no'; 
                                        $__prc_all = 'no';
                                        $_rsp_del_go = 'no';
                                        $_rsp_ls .= $this->li('Responsables match record '.$rsp_now_vp->id.' not deleted');
                                        break;
                                    }else{
                                        $_rsp_ls .= $this->li('Responsables match record '.$rsp_now_vp->id.' deleted');
                                    }

                                }else{
                                    
                                    if(isN($rsp_now_v->id)){ $_rsp_ls .= $this->li('$rsp_now_v->id empty'); $_rsp_ls .= print_r($rsp_now_v->id, true); }
                                    if(isN($__rsp_v->id)){ $_rsp_ls .= $this->li('$__rsp_v->id empty'); }
                                    
                                    $_rsp_sme = 'ok';

                                }

                            }

                        }else{
                            
                            $_rsp_ls .= $this->li('There are not responsables yet ('.$_rsp_now->tot.')');

                        }

                        $_rsp_ls .= $this->li('Responsable now '.$__rsp_v->nm.' ('.$__rsp_v->id.')');

                        if($_rsp_sme != 'ok' && $rspnw == 0){

                            if($_rsp_del_go == 'ok'){
                                
                                $__tra->tra_enc = $rwTraRsp['tra_enc'];
                                $__tra->trarsp_us = $__rsp_v->id;
                                $__tra->trarsp_us_asg = 3;
                                $__tra->trarsp_tp = _CId('ID_USROL_RSP');

                                $PrcDtSve = $__tra->In_Tra_Rsp([ 'tp'=>_CId('ID_USROL_RSP') ]);
                            
                                if($PrcDtSve->e != 'ok'){
                                    $__w .= '$PrcDtSve error'.$PrcDtSve->w;
                                    $__prc_all = 'no';
                                    $_rsp_ls .= $this->err('Responsable for task '.$rwTraRsp['tra_enc'].' Changed Problem ');
                                    $_rsp_ls .= $this->err( print_r($PrcDtSve->w, true) );
                                }else{
                                    $rspnw++;
                                }

                            }  

                        }

                        echo $this->ul($_rsp_ls);


                    //------------------------ PROCESS OBSERVATOR ------------------------//
                    
                    
                    }elseif($__rsptp_v->id == _CId('ID_USROL_OBS_DFT')){ 

                        $_tprsp = 'obs';

                        //echo $this->li('There is another observator now?');
                    
                        $_obs_now = GtTraRspDt([ 't'=>'tra', 'k'=>'enc', 'id_tra'=>$rwTraRsp['tra_enc'], 'tp'=>$_tprsp ]);
                        $_obs_ls = ''; 
                        $_obs_sme = '';

                        //echo $this->li('Observators:'.$_obs_now->tot);
                        $_obs_del_go = 'ok'; 

                        if($_obs_now->tot > 0){

                            foreach($_obs_now->ls as $obs_now_k=>$obs_now_v){

                                //$_obs_ls .= $this->li('Observator before '.$obs_now_v->us_nm.' ('.$obs_now_v->us_id.')');

                                if(!isN($obs_now_v->id) && $__rsp_v->id == $obs_now_v->us_id){                                    
                                    if(isN($obs_now_v->id)){ $_obs_ls .= $this->li('$obs_now_v->id empty'); $_obs_ls .= print_r($obs_now_v->id, true); }
                                    if(isN($__rsp_v->id)){ $_obs_ls .= $this->li('$__rsp_v->id empty'); }                                 
                                    $_obs_sme = 'ok';
                                }

                            }

                        }else{
                            
                            $_obs_ls .= $this->li('There are not observators yet ('.$_obs_now->tot.')');

                        }

                        //$_obs_ls .= $this->li('Observator now '.$__rsp_v->nm.' ('.$__rsp_v->id.')');

                        if($_obs_sme != 'ok'){

                            if($_obs_del_go == 'ok'){
                                
                                $__tra->tra_enc = $rwTraRsp['tra_enc'];
                                $__tra->trarsp_us = $__rsp_v->id;
                                $__tra->trarsp_us_asg = 3;
                                $__tra->trarsp_tp = _CId('ID_USROL_OBS');

                                $PrcDtSve = $__tra->In_Tra_Rsp([ 'tp'=>_CId('ID_USROL_OBS') ]);
                            
                                if($PrcDtSve->e != 'ok'){
                                    $__w .= '$PrcDtSve error'.$PrcDtSve->w;
                                    $__prc_all = 'no';
                                    //$_obs_ls .= $this->err('Observator for task '.$rwTraRsp['tra_enc'].' Changed Problem ');
                                    $_obs_ls .= $this->err('OBS-In_Tra_Rsp Us('.$__rsp_v->id.') err:'. print_r($PrcDtSve->w, true) );
                                }

                            }  

                        }

                        echo $this->ul($_obs_ls);

                    }

                }

            }else{

                echo $this->err('$__rsptp_v->ls is null');
    
            }

        }else{

            echo $this->err('Error, the type response with id '.$__rsptp_v->id.' not exists');

        }

    }

?>