<?php

$_g_alw = $this->tallw([ 't'=>'key', 'id'=>'ec_aws' ]);

if( $_g_alw->est == 'ok' ){
			
    //------------------- Basic Parameters ---------------------//	
    
        echo $this->h1('Update Template on AWS SES');
        $__ec = new API_CRM_ec([ 'argv'=>$__argv ]);
        $__aws = new API_CRM_Aws();

    //------------------- Start ---------------------//	

    if($this->_s_cl->tot > 0){
        
        foreach($this->_s_cl->ls as $_cl_k=>$_cl_v){
            
            if( $this->tallw_cl([ 't'=>'key', 'id'=>'ec_aws', 'cl'=>$_cl_v->id ])->est == 'ok' ){
                
                //-------------------- AUTO TIME CHECK - START --------------------//
                
                    $_eaws_d = [];
                    $_AUTOP_d = $this->RquDt([ 't'=>'aws', 'cl'=>$_cl_v->id, 's'=>10 ]);
                            
                //-------------------- AUTO TIME CHECK - END --------------------//
    
                if($_AUTOP_d->e == 'ok' && ($_AUTOP_d->lck != 'ok' || $_AUTOP_d->hb == 'ok' )){                        
                    
                    $EcAwsQry = "   SELECT id_ec
                                    FROM "._BdStr(DBM).TB_EC."
                                    WHERE ec_aws=2 AND ec_cl='".$_cl_v->id."'   
                                    ORDER BY id_ec ASC
                                    LIMIT {$_g_alw->lmt}";

                    $___lck = $this->Rqu([ 't'=>'aws', 'cl'=>$_cl_v->id, 'lck'=>1 ]);				
                    
                    echo $this->h3('Lock '.$_cl_v->nm.' / e:'.$___lck->e);
                    
                    if($___lck->e == 'ok'){			

                        $EcAws = $__cnx->_qry($EcAwsQry);
                        
                        if($EcAws){
                            $rwEcAws = $EcAws->fetch_object(); 
                            $TotEcAws = $EcAws->num_rows;	
                            echo $this->h3($this->ttFgr($_cl_v).$TotEcAws.' pushmail of '.$_cl_v->nm.' to update on AWS SES Templates');
                        }else{	
                            $___lck = $this->Rqu([ 't'=>'aws', 'cl'=>$_cl_v->id, 'lck'=>2 ]);
                            echo $this->err($__cnx->c_r->error);
                            $__cnx->_clsr($EcAws);
                        }

                        if($TotEcAws > 0){	
                                
                            //---------- Get all Id For Read Mode Markup ----------//		
                            
                                do{    
                                    try{
                                        $_eaws_d[] = $rwEcAws;
                                    } catch (Exception $e) {    
                                        $___lck = $this->Rqu([ 't'=>'aws', 'cl'=>$_cl_v->id, 'lck'=>2 ]);
                                        echo $this->err($e->getMessage());  
                                    }
                                } while ($rwEcAws = $EcAws->fetch_object()); 
                            
                            
                            //---------- Free Query ----------//
                                
                                $__cnx->_clsr($EcAws);
                                
                            //---------- Start to update templates ----------//			
                                
                                foreach($_eaws_d as $_eaws_d_k=>$_eaws_d_v){
                                    
                                    $__ec->id = $_eaws_d_v->id_ec;
                                    $__ec->frm = 'Ml';
                                    $__ec->html = 'ok';
                                    $__ec->aws = 'ok';
                                    $__ec->btrck = 'ok';
                                    $__ec_cod = $__ec->_bld();

                                    if(!isN($__ec_cod)){ //echo $__ec_cod;
                                    
                                        $__upd = $__aws->_ses_tmpl([
                                            'id'=>'EC'.$_eaws_d_v->id_ec,
                                            'html'=>$__ec_cod,
                                            'sbj'=>'{{subject}}',
                                            'ptxt'=>''
                                        ]);
                                        
                                        if($__upd->e == 'ok'){

                                            $__prc = $__ec->_EcUpd_Fld([ 'id'=>$_eaws_d_v->id_ec, 'f'=>'ec_aws', 'v'=>1 ]);
                                            
                                            if($__prc->e == 'ok'){
                                                echo $this->scss('Update on AWS success');
                                            }else{
                                                echo $this->err(print_r($__prc ), true);
                                            }

                                        }else{
                                            print_r( $__upd );
                                        }

                                    }
                                    
                                }
                            
                            //---------- End - update templates ----------//		

                        }else{
                            
                            $___lck = $this->Rqu([ 't'=>'aws', 'cl'=>$_cl_v->id, 'lck'=>2 ]);		
                            echo $this->h3('0 records and $___lck dislock query ');
                            
                        }		
                    
                    }else{
                        
                        $___lck = $this->Rqu([ 't'=>'aws', 'cl'=>$_cl_v->id, 'lck'=>2 ]);
                        echo $this->err($__rqu_tt.' send for client '.$_cl_v->nm.' can not locked');
                        
                    }
                
                }else{
            
                    echo $this->h3($__rqu_tt.' send for client '.$_cl_v->nm. ' on read mode '.print_r($_AUTOP_d, true), '', '_onread');
                    
                }
            
            }else{

                echo $this->nallw($_cl_v->nm.' Bulk Mail - Update Template - Off');
            
            }
            
        }
        
    }

}else{

	echo $this->nallw('Global Bulk Mail - Update Template - Off');

}

?>