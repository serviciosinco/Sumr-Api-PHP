<?php

    try {		
											
        //-------------------- GLOBAL VAR FOR EML INSIDE - START --------------------//

            //$__box = $__Imap->_box([ 'eml'=>$___datprcs_v['id_eml'], 'fchk'=>'ok', 'fchk_f'=>'emlbox_msg_chk' , 'lmt'=>3 ]);
            $__emlid = $___datprcs_v['id_eml'];
            $_not_all = '';
            $msg = [];

        //-------------------- GLOBAL VAR FOR EML INSIDE - END --------------------//
        
        //if($__box->tot > 0){
            
            //foreach($__box->ls as $box_key=>$box_val){

                //-------------------- CHECK IS IN / OUT - START --------------------// 
                
                    if($___datprcs_v['emlbox_id'] == 'INBOX.Sent'){ 
                        $_f_inp='out'; 
                    }else{ 
                        $_f_inp='in';
                    }
                
                //-------------------- CHECK IS IN / OUT - END --------------------//
                
                echo $this->li('Email:'.$___datprcs_v['eml_eml'].' - Box:'.$___datprcs_v['emlbox_id']. ' - ' . $___datprcs_v['id_emlbox']. ' - ' . $___datprcs_v['emlbox_enc'].'');
                
                $__rqudt = $__Eml->RquDt([ 'md'=>'eml', 'box'=>$___datprcs_v['emlbox_id'], 'tp'=>'cnv_msg', 'eml'=>$__emlid ]);
                    
                $__Imap->c_eml = $__emlid;
                $__Imap->box = $___datprcs_v['emlbox_id'];
                
                if(/*$__rqudt->all != 'ok' &&*/ !isN( $__rqudt->nxt ) ){
                    $_msg_nxt = $__rqudt->nxt;
                }else{
                    $_msg_nxt = NULL;
                }
                
                //echo $this->h2('Next ($_msg_nxt):'.$_msg_nxt);
                $msg = $__Imap->_msg([ 'all'=>$__rqudt->all, 'maxuid'=>$___datprcs_v['emlbox_luid'], 'nxt'=>$_msg_nxt, 'lmt'=>50 ]);
                //print_r($msg);
                
                echo $this->li('Sequence ('.$___datprcs_v['emlbox_id'].') of get '.$msg->sqnc);

                if(!isN($msg) && !isN($msg->ls)){
                    
                    $msg_test=0;
                    
                    foreach($msg->ls as $msg_k=>$msg_v){ //print_r($msg_v);
                        
                        //print_r($msg_v);
                        //echo $this->h2( '$msg_v->id:'.$msg_v->id.' | '.$msg_v->date->date.' | with date '.$msg_v->date->date );

                        $__Eml->__t = 'eml_msg';
                        $__Eml->emlmsg_id = $msg_v->id;
                        $__Eml->emlmsg_no = $msg_v->no;
                        $__Eml->emlmsg_uid = $msg_v->attr->uid;
                        $__Eml->emlmsg_sbj = $msg_v->sbj;
                        
                        //----------------- IF THERE IS NOT ATTACHMENTS MARK AS SAVED -----------------//

                        if($msg_v->hattch && count( $msg_v->attch ) > 0){
                            $__Eml->emlmsg_attch_sve = 2;
                            $__Eml->emlmsg_attch_tot = count( $msg_v->attch );
                        }else{
                            $__Eml->emlmsg_attch_sve = 1;
                            $__Eml->emlmsg_attch_tot = 0;
                        }

                        try {
                            $__Eml->emlmsg_f = $__Eml->_Tme($msg_v->date->date);
                        }catch(Exception $e) {
                            print_r( $msg_v );
                            $__Eml->emlmsg_f = $__Eml->_Tme($msg_v->datem, [ 'lcl'=>'ok' ]);
                        }

                        $__Eml->emlmsg_inp = $_f_inp;
                        $__Eml->emlmsg_eml = $__emlid;										
                        //$__Eml->emlmsg_bdy_sze = $msg_v->body->sze;

                        if(isN($msg_v->attr) && $_f_inp != 'out'){
                            echo $this->err('No attributes');
                            break;
                        }

                        //----------------- IF THERE IS NOT ATTRIBUTES MARK AS SAVED -----------------//

                        $__Eml->emlmsg_attr = $msg_v->attr;

                        if(count($msg_v->attr) > 0){
                            $__Eml->emlmsg_attr_sve = 1;
                            $__Eml->emlmsg_attr_tot = count( $msg_v->ref );
                        }else{
                            $__Eml->emlmsg_attr_sve = 2;
                            $__Eml->emlmsg_attr_tot = 0;
                        }

                        if(isN($msg_v->from) && $_f_inp != 'out'){
                            echo $this->err('No from addresses');
                            break;
                        }

                        $__Eml->emlmsg_box = $___datprcs_v['id_emlbox'];
                        
                        
                        //----------------- IF THERE IS NOT REFERENCES MARK AS SAVED -----------------//

                        $__Eml->emlmsg_ref = $msg_v->ref;

                        if(count( $msg_v->ref ) > 0){
                            $__Eml->emlmsg_ref_sve = 1;
                            $__Eml->emlmsg_ref_tot = count( $msg_v->ref );
                        }else{
                            $__Eml->emlmsg_ref_sve = 1;
                            $__Eml->emlmsg_ref_tot = 0;
                        }

                        //----------------- PROCESS EMAIL ADDRESS RELATED -----------------//

                        $__Eml->emlmsg__addr =[
                            'from'=>$msg_v->from,
                            'to'=>$msg_v->to,
                            'cc'=>$msg_v->cc,
                            'bcc'=>$msg_v->bcc,
                            'reply'=>$msg_v->rply
                        ];
                        
                        $__Prc_Msg = $__Eml->In();

                        if($__Prc_Msg->e == 'ok'){

                            echo $this->scss('Saved all from message '.$msg_v->sbj);

                            echo $this->ul(
                                $this->li('emlmsg_id:'.$msg_v->id).
                                $this->li('emlmsg_f:'.$__Eml->emlmsg_f).
                                $this->li('emlmsg_inp:'.$_f_inp).
                                $this->li('emlmsg_eml:'.$__emlid).
                                $this->li('emlmsg_bdy_sze:'.$msg_v->body->sze).
                                $this->li('emlmsg_box:'.$___datprcs_v['emlbox_id']).
                                $this->li('subject:'.$msg_v->sbj)
                            );

                        }else{

                            $_not_all = 'ok';
                            echo $this->err('Not saved all for box ('.$___datprcs_v['id_emlbox'].') '.print_r($__Prc_Msg->w, true));
                            //print_r($msg_v);
                            print_r( $__Prc_Msg );

                        }
                        
                        $msg_test++;
                        
                    }

                }else{

                    echo $this->err('No messages on result imap on '.$___datprcs_v['emlbox_id']);
                    echo $this->err('Query:'.$msg->q);
                    //print_r( $msg );

                }
                
                echo $this->h2( '------ Tot All:'.$msg->tot->b );
                echo $this->h2( '------ Tot Fetched:'.$msg->tot->s );
                echo $this->h2( '------ Next Uid:'.$msg->luid );

                if(!isN($msg->w)){
                    echo $this->err('Error:'.$msg->w);
                }
                
                if(isN( $msg->w ) || strpos($msg->w,'Invalid sequence') !== false ){

                    if($_not_all != 'ok'){

                        $__rqu = $__Eml->Rqu([
                                    'md'=>'eml',
                                    'tp'=>'cnv_msg',
                                    'box'=>$___datprcs_v['emlbox_id'],
                                    'eml'=>$___datprcs_v['id_eml'],
                                    'nxt'=>$msg->luid,
                                    //'all'=>$__rqu_all,
                                    'no_all'=>'ok',
                                    'npge'=>'ok'
                                ]);
                        
                        if($__rqu->e == 'ok'){
                            echo $this->scss('Saved rqu from box '.$___datprcs_v['emlbox_id'].' with last uid '.$msg->luid);
                        }else{
                            echo $this->err('Not update rqu batch for '.$___datprcs_v['emlbox_id']);
                        }

                    }else{

                        echo $this->err('Not update request batch for '.$___datprcs_v['emlbox_id']);

                    }
                    
                }else{

                    echo $this->err('On End Process:'.print_r($msg->w, true));

                }

                echo $this->h2( '------ $__Eml->Rqu:' );
                //print_r( $__rqu );

                $__upd_chk = $__Eml->Upd_Eml_Fld([
                                        't'=>'box', 
                                        'id'=>$___datprcs_v['emlbox_enc'], 
                                        'fld'=>[[
                                            'k'=>'emlbox_msg_chk',
                                            'v'=>SIS_F_TS
                                        ]],
                                    ]);

                $__upd_chk = $__Eml->Upd_Eml_Fld([
                                        't'=>'eml', 
                                        'id'=>$___datprcs_v['eml_enc'], 
                                        'fld'=>[[
                                            'k'=>'eml_msg_chk',
                                            'v'=>SIS_F_TS
                                        ]],
                                    ]);

                //print_r($__upd_chk);

            
            //}
            
        //}
    
    }catch(LoopingMsg $w){	
        echo 'Excepción capturada: ',  $w->getMessage(), "\n";
    }

?>