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
                
                $__CntIn = new CRM_Cnt([ 'cl'=>$__cl->id ]);
                $__CntIn->_vtex->acc = $__r->vtex_cmpg->acc->id;

                //------------------ DATOS BASICOS DE LEAD ------------------//
                
                    $__CntIn->tp = $__t_p;
                    $__CntIn->cnt_nm = $__r->cnt_nm;
                    $__CntIn->cnt_eml = $__r->cnt_eml;
                    $__CntIn->cnt_dc = $__r->cnt_dc;
                    $__CntIn->cnt_dc_tp = $__r->cnt_dc_tp;
                    $__CntIn->cnt_cd[] = [		
                                            'id'=>ctjTx($__r->cnt_cd,'out'),
                                            'rel'=>ctjTx($__r->cnt_cd_rel,'out')
                                        ];
                    
                    $__CntIn->cnt_tel =[ 'no'=>$__r->cnt_tel ];
                    $__CntIn->cnt_cel =[ 'no'=>$__r->cnt_cel ];
                    $__CntIn->cnt_sndi = 1;
                    $__CntIn->plcy_id = $__r->plcy_id;
                    
                //------------------ DATOS BASICOS DE RELACION CON LEAD ------------------//

                    $__CntIn->gt_cl_id = $__Forms->gt_cl->id;
                    $__CntIn->gt_vtexcmpg_id = $__r->vtex_cmpg->id;

                    if($__Forms->data->Cnt_OnlyData == 'ok'){
                        $__CntIn->gt_vtexcmpg_rfd = 1;
                    }else{
                        $__CntIn->gt_vtexcmpg_rfd = 2;
                    }

                    $__CntIn->invk->by = _CId('ID_SISINVK_FORM');
                    $__CntIn->ext_all = $__r->{'_ext_'};
                                        
                //------------------ PROCESA REGISTRO - START ------------------//
                
                    $_CmpgIns_In = $__CntIn->_Cnt();
                    

                    if( $_CmpgIns_In->e == 'ok' && !isN($_CmpgIns_In->i) && isN($__r->cnt_rfd) && ($__Forms->data->Cnt_OnlyData != 'ok' || isN($__Forms->data->Cnt_OnlyData)) ){

                        $PrcDt_Pss = $__CntIn->_vtex->CntPss([ 'i'=>$_CmpgIns_In->i, 'eml'=>$__r->cnt_eml, 'vtex'=>$__r->vtex_cmpg->id, 'dc'=>$__r->cnt_dc ]);

                        if($PrcDt_Pss->exst == 'ok'){
                            $_r['pss_exst'] = 'ok';
                        }else{
                            $_r['pss_new'] = 'ok';
                        }

                        if($PrcDt_Pss->e == 'ok'){
                            if(!isN( $PrcDt_Pss->id ) && !isN( $_CmpgIns_In->in->vtex_all->ins->id )){
                                $__next_rfrd = 'ok';
                            }
                        }else{
                            $_r['w2'] = $PrcDt_Pss->w;
                            $_r['r'] = $PrcDt_Pss;
                        }
                        
                    } 
                    
                    //$_r['tmp_nxt_rfd'] = $__next_rfrd;

                    if( $__next_rfrd == 'ok' && 
                        !isN($_CmpgIns_In->i) && 
                        ($__Forms->data->Cnt_OnlyData != 'ok' || isN($__Forms->data->Cnt_OnlyData) )
                    ){

                        if(!isN($__r->cnt_ins_t)){ 
                            
                            foreach($__r->cnt_ins_t as $k=>$v){

                                if(!isN($v->eml)){

                                    $__CntRfdIn = new CRM_Cnt([ 'cl'=>$__cl->id ]);
                                    
                                    $__CntRfdIn->cnt_nm = $v->nm;
                                    $__CntRfdIn->cnt_eml = $v->eml;
                                    //$__CntRfdIn->gt_vtexcmpg_id = $__r->vtex_cmpg->id;
                                    $_CmpgInsRfdCnt_In = $__CntRfdIn->_Cnt();
                                    
                                    // $_r['tmp_rfd']['ls'][] = $v->eml;
                                    // $_r['tmp_rfd']['in'][] = $_CmpgInsRfdCnt_In;

                                    if(!isN($_CmpgInsRfdCnt_In->i)){

                                        $_CmpgInsRfd_In = $__CntRfdIn->_vtex->InsRfd_In([ 'ins'=>$_CmpgIns_In->in->vtex_all->ins->id, 'rfd'=>$_CmpgInsRfdCnt_In->i ]);
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

                                }

                            }	

                        }else{

                            $_CmpgInsRfd_In = $__CntIn->_vtex->InsRfd_In([ 'ins'=>$_CmpgIns_In->in->vtex_all->ins->id , 'rfd'=>$rfd ]);

                            if($_CmpgInsRfd_In->e == 'ok'){
                                $_r['e'] = 'ok';
                            }
                        } 

                    }else if(!isN($_CmpgIns_In->i) && ($__Forms->data->Cnt_OnlyData == 'ok' || !isN($__Forms->data->Cnt_OnlyData) )){ 
                        
                        $__rfrd = GtVtexCmpgInsRfdDt([ 't'=>'enc', 'id'=>Php_Ls_Cln($_POST['___i']), 'bd'=>$__cl->bd ]);

                        if(!isN($__rfrd) && $__rfrd->e == 'ok' && isN($__rfrd->coup->rfd->v)){

                            $__CntRfdUpd = new CRM_Cnt([ 'cl'=>$__cl->id ]);
                            $__CntRfdUpd->cnt_eml = $__rfrd->cnt->eml;
                            $__CntRfdUpd->gt_vtexcmpg_id = $__r->vtex_cmpg->id;
                            $__CntRfdUpd->gt_vtexcmpg_rfd = 1;
                            $__CntRfdUpd->plcy_id = $__r->plcy_id;
                            $_CmpgRfd_Upd = $__CntRfdUpd->_Cnt();

                            //$_r['tmp_rfd'] = $_CmpgRfd_Upd;

                            if($_CmpgRfd_Upd->e == 'ok'){

                                $__gcoup = $__CntIn->_vtex->coup_new([ 
                                    'srce'=>'START-CMPG',
                                    'cmpg'=>$__r->vtex_cmpg->id,
                                    'sumr'=>1
                                ]);

                                if(!isN($__gcoup->id)){

                                    $_CmpgInsRfd_In = $__CntIn->_vtex->InsRfd_Upd([ 
                                                    'id'=>Php_Ls_Cln($_POST['___i']), 
                                                    'tp'=>'enc',
                                                    'f'=>[
                                                        'vtexcmpginsrfd_rfd_coup'=>$__gcoup->id
                                                    ]
                                                ]);

                                    if($_CmpgInsRfd_In->e == 'ok' && !isN($__gcoup->id)){

                                        $_CmpgIns_Upd = $__CntIn->_vtex->Ins_Upd([ 
                                            'id'=>$_CmpgIns_In->in->vtex_all->ins->id, 
                                            'f'=>[
                                                'vtexcmpgins_coup'=>$__gcoup->id
                                            ]
                                        ]);

                                        if($_CmpgInsRfd_In->e == 'ok'){
                                            $_r['e'] = 'ok';
                                            $_r['enc'] = $__gcoup->enc;
                                            $_r['coup'] = $__gcoup->coup;
                                        }

                                    }else{
                                        $_r['r'] = $__snd;
                                    }

                                }

                            }

                        }else{
                            
                            if(!isN($__rfrd->coup->rfd->v)){
                                $_r['e'] = 'ok';
                                $_r['coup'] = $__rfrd->coup->rfd->v;
                            }else{
                                $_r['w'] = $__rfrd;
                            }
                        }
                    
                    }else{

                        $_r['w'] = 'No cnt main id';

                    }

                //------------------ PROCESA REGISTRO - END ------------------//
                    
                //$_r['e'] = 'no'; //Tempo

        }else{
            $_r['e'] = 'no';
        }	

    }else{

        $_r['e'] = 'no_data';
        $_r['cmpg'] = $__r->vtex_cmpg;	
        
    }

?>