<?php

    class CRM_Wthsp extends CRM_Thrd{

        function __construct() { 
            $this->_massive = new API_CRM_Massive();
            $this->_ws = new CRM_Ws;
	    }
	    
	    function __destruct() {
		
        }

        public function rst(){

            $this->__new_cnv_id = null;
            $this->wthspcnvus_us = null;

        }

        public function GtFromDt($p=NULL){
            
            global $__cnx;
            
            if(!isN($p["id"])){ $_fl .= "AND wthspfrom_id = '".$p["id"]."' "; }

            $query_DtRg = sprintf('	SELECT * 
                                    FROM '._BdStr(DBT).TB_WHTSP_FROM.'
                                    WHERE id_wthspfrom != "" '.$_fl);
                                    
            $DtRg = $__cnx->_qry($query_DtRg); 
            
            if($DtRg){
            
                $row_DtRg = $DtRg->fetch_assoc(); 
                $Tot_DtRg = $DtRg->num_rows;	
                
                if($Tot_DtRg > 0){
                    $Vl['id'] = $row_DtRg['id_wthspfrom'];
                    $Vl['key'] = $row_DtRg['wthspfrom_id'];
                    $Vl['enc'] = ctjTx($row_DtRg['wthspfrom_enc'],'in');
                    $Vl['tt'] = ctjTx($row_DtRg['wthspfrom_nm'],'in');
                }
            
            }else{
                $Vl['e'] = $row_DtRg['no'];
            }
            
            $__cnx->_clsr($DtRg);
                    
            return(_jEnc($Vl));
            
        }

        public function GtCnvDt($p=NULL){
            
            global $__cnx;
            
            if(!isN($p['id'])){

                if(!isN($p["id"])){ $_fl .= " AND wthspcnv_id = '".$p['id']."' "; }

                $query_DtRg = sprintf('	SELECT id_wthspcnv, wthspcnv_enc, wthspcnv_id, wthspcnv_est
                                        FROM '._BdStr(DBT).TB_WHTSP_CNV.'
                                        WHERE id_wthspcnv != "" '.$_fl); 
                                        
                                        //echo $this->wthspcnvmsg_wthspcnv.'----->'.$query_DtRg;
                                        
                $DtRg = $__cnx->_qry($query_DtRg); 
            
            }

            if($DtRg){
            
                $row_DtRg = $DtRg->fetch_assoc(); 
                $Tot_DtRg = $DtRg->num_rows;	
                
                if($Tot_DtRg > 0){
                    $Vl['id'] = $row_DtRg['id_wthspcnv'];
                    $Vl['key'] = $row_DtRg['wthspcnv_id'];
                    $Vl['enc'] = ctjTx($row_DtRg['wthspcnv_enc'],'in');
                    $Vl['est'] = ctjTx($row_DtRg['wthspcnv_est'],'in');
                }
            
            }else{
                $Vl['e'] = $row_DtRg['no'];
            }
            
            $__cnx->_clsr($DtRg);
                    
            return(_jEnc($Vl));
            
        }


        public function GtCnvUsDt($p=NULL){
            
            global $__cnx;
            
            if(!isN($p["cnv"])){ $_fl .= "AND wthspcnvus_maincnv = '".$p["cnv"]."' "; }
            if(!isN($p["us"])){ $_fl .= "AND wthspcnvus_us = '".$p["us"]."' "; }

            $query_DtRg = sprintf('	SELECT * 
                                    FROM '._BdStr(DBT).TB_WHTSP_CNV_US.'
                                    WHERE id_wthspcnvus != "" '.$_fl);
                                    
            $DtRg = $__cnx->_qry($query_DtRg); 
            
            if($DtRg){
            
                $row_DtRg = $DtRg->fetch_assoc(); 
                $Tot_DtRg = $DtRg->num_rows;	
                
                if($Tot_DtRg > 0){
                    $Vl['id'] = $row_DtRg['id_wthspcnv'];
                    $Vl['key'] = $row_DtRg['wthspcnv_id'];
                    $Vl['enc'] = ctjTx($row_DtRg['wthspcnv_enc'],'in');
                }
            
            }else{
                $Vl['e'] = $row_DtRg['no'];
            }
            
            $__cnx->_clsr($DtRg);
                    
            return(_jEnc($Vl));
            
        }

        public function GtCnvMsgDt($p=NULL){
            
            global $__cnx;
            
            if(!isN($p["id"])){ $_fl .= "AND wthspcnvmsg_id = '".$p["id"]."' "; }
            elseif(!isN($p["enc"])){ $_fl .= "AND wthspcnvmsg_enc = '".$p["enc"]."' "; }

            $query_DtRg = sprintf('	SELECT id_wthspcnvmsg, wthspcnvmsg_snt, id_wthspcnv, wthspcnv_est, wthspcnvmsg_id, wthspcnvmsg_enc, wthspcnvmsg_message, wthspcnvmsg_created
                                    FROM '._BdStr(DBT).TB_WHTSP_CNV_MSG.'
                                         INNER JOIN '._BdStr(DBT).TB_WHTSP_CNV.' ON wthspcnvmsg_wthspcnv = id_wthspcnv
                                    WHERE wthspcnvmsg_id != "" '.$_fl.'
                                    LIMIT 1');
                                    
            $DtRg = $__cnx->_qry($query_DtRg); 
            
            if($DtRg){
            
                $row_DtRg = $DtRg->fetch_assoc(); 
                $Tot_DtRg = $DtRg->num_rows;	
                
                if($Tot_DtRg > 0){

                    $Vl['e'] = "ok";
                    $Vl['id'] = $row_DtRg['id_wthspcnvmsg'];
                    $Vl['snt'] = mBln($row_DtRg['wthspcnvmsg_snt']);

                    $Vl['cnv']['id'] = $row_DtRg['id_wthspcnv'];
                    $Vl['cnv']['est'] = $row_DtRg['wthspcnv_est'];

                    $Vl['key'] = $row_DtRg['wthspcnvmsg_id'];
                    $Vl['enc'] = ctjTx($row_DtRg['wthspcnvmsg_enc'],'in');
                    $Vl['msg'] = ctjTx($row_DtRg['wthspcnvmsg_message'],'in');

                    $Vl['f'] = [
                        'main'=>$row_DtRg['wthspcnvmsg_created'],
                        's1'=>date('H:i a', strtotime( $row_DtRg['wthspcnvmsg_created'] ))
                    ]; 
                    
                }
            
            }else{
                
                $Vl['w'] = $__cnx->c_r->error;
                $Vl['e'] = $row_DtRg['no'];

            }
            
            $__cnx->_clsr($DtRg);
                    
            return(_jEnc($Vl));

        }
        
        
        public function Chk_Us($p=NULL){
            
            $_r['e'] = 'no'; 

            $this->__usdt = GtUsDt($p['usr'], 'msv_usr'); //Valida que el usuario masive exista
            
            if(!isN($this->__usdt->id)){ 
                $_r['e'] = 'ok';
                $_r['id'] = $this->__usdt->id; 
            }else{
                $_r['r'] = $__dt_us;
            }

            return _jEnc($_r);
        }


        private function From_In($p=NULL){
            
            global $__cnx;

            if( !isN($this->wthspfrom_id) ){
                
                $_enc = Enc_Rnd($this->wthspfrom_id.'-'.$this->wthspfrom_nm);
                
                $insertSQL = sprintf("INSERT INTO "._BdStr(DBT).TB_WHTSP_FROM." (
                                                                    wthspfrom_enc,
                                                                    wthspfrom_id, 
                                                                    wthspfrom_nm
                                                                ) VALUES 
                                                                (
                                                                    %s,
                                                                    %s,
                                                                    %s
                                                                )",
                                    GtSQLVlStr($_enc, "text"),
                                    GtSQLVlStr(ctjTx($this->wthspfrom_id,'out'), "text"),
                                    GtSQLVlStr(ctjTx($this->wthspfrom_nm,'out'), "text"));
                
                $Result = $__cnx->_prc($insertSQL);

                if($Result){ 
                    $rsp['e'] = 'ok';
                    $rsp['id'] = $__cnx->c_p->insert_id;
                    $rsp['enc'] = $_enc;
                }else{
                    $rsp['e'] = 'no';
                }
                
            }else{
                $rsp['e'] = 'no';
            }
            
            return _jEnc($rsp);	
        }


        private function Cnv_In($p=NULL){ 
            
            global $__cnx;

            if( 
                !isN($this->wthspcnv_whtsp) && !isN($this->wthspcnv_id) && !isN($this->__new_from_id)  
            ){
                
                $_enc = Enc_Rnd($this->wthspcnv_whtsp.'-'.$this->wthspcnv_id);
                
                if( !isN($this->wthspcnv_est) ){ $_cnv_est = $this->wthspcnv_est; }else{ $_cnv_est = _CId('ID_SCLCNVEST_ON'); }

                $insertSQL = sprintf("INSERT INTO "._BdStr(DBT).TB_WHTSP_CNV." (
                                                                    wthspcnv_enc, 
                                                                    wthspcnv_est, 
                                                                    wthspcnv_whtsp, 
                                                                    wthspcnv_from,
                                                                    wthspcnv_cls,
                                                                    wthspcnv_id,
                                                                    wthspcnv_snpt,
                                                                    wthspcnv_unr
                                                                ) VALUES 
                                                                (
                                                                    %s,
                                                                    %s,
                                                                    %s, 
                                                                    %s, 
                                                                    %s,
                                                                    %s,
                                                                    %s,
                                                                    %s
                                                                )",
                                    GtSQLVlStr( $_enc, "text"),
                                    GtSQLVlStr(ctjTx($_cnv_est,'out'), "text"),
                                    GtSQLVlStr(ctjTx($this->wthspcnv_whtsp,'out'), "text"),
                                    GtSQLVlStr(ctjTx($this->__new_from_id,'out'), "text"),
                                    GtSQLVlStr(ctjTx($this->wthspcnv_cls,'out'), "date"),
                                    GtSQLVlStr(ctjTx($this->wthspcnv_id,'out'), "text"),
                                    GtSQLVlStr(ctjTx($this->wthspcnv_snpt,'out'), "text"),
                                    GtSQLVlStr(ctjTx($this->wthspcnv_unr,'out'), "text"));
                
                $Result = $__cnx->_prc($insertSQL);
                
                if($Result){

                    $rsp['e'] = 'ok';
                    $rsp['enc'] = $_enc;
                    $rsp['id'] = $__cnx->c_p->insert_id;

                    if($_cnv_est != _CId('ID_SCLCNVEST_RDY')){

                        $__cnv_main = GtMainCnvDt([ 'tp'=>'whtsp', 'enc'=>$_enc, 'us_asgn'=>'ok' ]);
                        $_GtWhtspFromDt = GtWhtspFromDt([ "maincnv_id"=>$this->wthspcnv_id ]);

                        $this->_ws->Send([
                            'srv'=>'chat',
                            'act'=>'chat_conversation_new',
                            'to'=>[$__cnv_main->us->enc], // Recibe
                            'data'=>[
                                'cnv'=>[
                                    'id'=>$rsp['id'],
                                    'tp'=>'whtsp',
                                    'enc'=>$_enc,
                                    'fa'=>SIS_F_TS
                                ],
                                'us'=>[
                                    'enc'=>$_GtWhtspFromDt->enc,
                                    'nm'=>$_GtWhtspFromDt->tt,
                                    'ap'=>"",
                                    'onl'=>"ok",
                                    'img'=>DMN_IMG_ESTR_SVG.'chat_whtsp_no.svg'
                                ],
                                'msj_lst'=>[
                                    'tx'=>$__cnv_main->lmsj->tx,
                                    'f'=>$__cnv_main->lmsj->f,
                                    'tot'=>0
                                ],
                                'tp'=>[
                                    'cls' => $row_Ls_Cnv['maincnv_tp']
                                ],
                                'svin'=>false



                            ]
                        ]);

                    }

                }else{
                    $rsp['e'] = 'no';
                }
                
            }else{
                $rsp['e'] = 'no';
            }
            
            return _jEnc($rsp);	
        }


        private function Cnv_Us_In($p=NULL){ 
            
            global $__cnx;

            if( !isN($this->__new_cnv_id) && !isN($this->wthspcnvus_us) ){
                
                $_enc = Enc_Rnd($this->__new_cnv_id.'-'.$this->wthspcnvus_us);
                
                $insertSQL = sprintf("INSERT INTO "._BdStr(DBT).TB_WHTSP_CNV_US." (
                                                                    wthspcnvus_enc,
                                                                    wthspcnvus_wthspcnv, 
                                                                    wthspcnvus_us
                                                                ) VALUES 
                                                                (
                                                                    %s,
                                                                    %s,
                                                                    %s
                                                                )",
                                    GtSQLVlStr( $_enc, "text"),
                                    GtSQLVlStr($this->__new_cnv_id, "int"),
                                    GtSQLVlStr($this->wthspcnvus_us, "int"));
                
                $Result = $__cnx->_prc($insertSQL);
                
                if($Result){
                    $rsp['e'] = 'ok';
                    $rsp['id'] = $__cnx->c_p->insert_id;
                    $rsp['enc'] = $_enc;
                }else{
                    $rsp['e'] = 'no';
                }
                
            }else{
                $rsp['e'] = 'no';
            }
            
            return _jEnc($rsp);	
        }


        public function Chk_Acc(){

            $this->_whtsp = GtWhtspDt([ 'id'=>$this->wthspcnv_whtsp ]);
            
        }

        public function Chk_From(){

            $this->__new_from_id = NULL;
            $_dt = $this->GtFromDt([ "id"=>$this->wthspcnvmsg_from ]); //Trae el detalle de wthsp_from

            if(!isN($_dt->id)){
                if($_dt->key != $this->_whtsp->no){
                    $this->__new_from_id = $_dt->id;
                }
            }else{
                $_in = $this->From_In(); 
                if(!isN($_in->id)){ $this->__new_from_id = $_in->id; }
            }
        }


        public function Chk_Cnv(){

            $this->__new_cnv_id = NULL; 
            //echo 'Sent to GtCnvDt:'.$this->wthspcnvmsg_wthspcnv;
            $this->__cnvdt = $this->GtCnvDt([ 'id'=>$this->wthspcnvmsg_wthspcnv ]); //Trae el detalle de wthsp_from

            if(!isN($this->__cnvdt->id)){
                $this->__new_cnv_id = $this->__cnvdt->id;
            }else{
                $_in = $this->Cnv_In(); 
                $this->__cnvdt = $this->GtCnvDt([ 'id'=>$this->wthspcnvmsg_wthspcnv ]);
                if(!isN($_in->id)){ $this->__new_cnv_id = $_in->id; }
            }

        }


        public function Chk_Cnv_Us(){

            $this->__new_cnv_us_id = NULL;

            if(!isN( $this->wthspcnvmsg_us )){

                $this->__cnvusdt = $this->GtCnvUsDt([ 'us'=>$this->wthspcnvmsg_us, 'cnv'=>$this->__new_cnv_id ]); //Trae el detalle de wthsp_from

                if(!isN($this->__cnvusdt->id)){
                    $this->__new_cnv_us_id = $this->__cnvusdt->id;
                }else{
                    $_in = $this->Cnv_Us_In(); 
                    $this->__cnvusdt = $this->GtCnvUsDt([ 'us'=>$this->wthspcnvmsg_us, 'cnv'=>$this->__new_cnv_id ]);
                    if(!isN($_in->id)){ $this->__new_cnv_us_id = $_in->id; }
                }

            }

        }


        public function Cnv_Msg_In($p=NULL){ //Ingresa mensajes a la BD
            
            global $__cnx;

            $__cnx->c_p->autocommit(FALSE); 

            if( $p['chat_snd'] != 'ok' ){ //No aplica cuando se envía por APP - Ionic
                $this->Chk_Acc();
                $this->Chk_From();
                $this->Chk_Cnv();
                $this->Chk_Cnv_Us();
            }

            if( !isN($this->wthspcnvmsg_message) && !isN($this->__new_from_id) && !isN($this->__new_cnv_id) ){
                
                if(!isN( $this->wthspcnvmsg_snt )){ $_snt=$this->wthspcnvmsg_snt; }else{ $_snt=2; }
                $_enc = Enc_Rnd($this->wthspcnvmsg_message.'-'.$this->__new_from_id);

                $insertSQL = sprintf("INSERT INTO "._BdStr(DBT).TB_WHTSP_CNV_MSG." (
                                                                    wthspcnvmsg_enc,
                                                                    wthspcnvmsg_snt,
                                                                    wthspcnvmsg_wthspcnv, 
                                                                    wthspcnvmsg_created, 
                                                                    wthspcnvmsg_from, 
                                                                    wthspcnvmsg_id, 
                                                                    wthspcnvmsg_message,
                                                                    wthspcnvmsg_us
                                                                ) VALUES 
                                                                (
                                                                    %s,
                                                                    %s,
                                                                    %s,
                                                                    %s,
                                                                    %s,
                                                                    %s,
                                                                    %s,
                                                                    %s
                                                                )",
                                    GtSQLVlStr( $_enc, "text"),
                                    GtSQLVlStr( $_snt, "int"),
                                    GtSQLVlStr($this->__new_cnv_id, "int"),
                                    GtSQLVlStr($this->wthspcnvmsg_created, "date"),
                                    GtSQLVlStr($this->__new_from_id, "int"),
                                    GtSQLVlStr($this->wthspcnvmsg_id, "int"),
                                    GtSQLVlStr(ctjTx($this->wthspcnvmsg_message,'out'), "text"),
                                    GtSQLVlStr($this->wthspcnvmsg_us, "int"));

                $Result = $__cnx->_prc($insertSQL);
                
                if($Result && !isN($__cnx->c_p->insert_id)){

                    $insertSQLMData = sprintf("INSERT INTO "._BdStr(DBT).TB_WHTSP_CNV_MSG_MDATA." (
                                            wthspcnvmsgmdata_wthspcnvmsg,
                                            wthspcnvmsgmdata_mdata
                                        ) VALUES 
                                        (
                                            %s,
                                            %s
                                        )",
                    GtSQLVlStr($__cnx->c_p->insert_id, "int"),
                    GtSQLVlStr(ctjTx($this->wthspcnvmsg_mdata,'out'), "text"));
                    $Result_MData = $__cnx->_prc($insertSQLMData);

                }

                if($__cnx->c_p->commit()){

                    $__cnv_main = GtMainCnvDt([ 'tp'=>'whtsp', 'maincnv_id'=>$this->__new_cnv_id, 'us_asgn'=>'ok' ]);
                    $__msg_dt = $this->GtCnvMsgDt([ 'id'=>$this->wthspcnvmsg_id ]);
                    $__from_dt = GtWhtspFromDt([ "maincnv_id"=>$this->wthspcnvmsg_id ]);

                    if(!isN($__msg_dt->w)){

                        $this->_ws->Send([
                            'srv'=>'chat',
                            'act'=>'error',
                            'to'=>[$__cnv_main->us->enc], // Recibe
                            'data'=>[
                                'tx'=>'error on GtCnvMsgDt',
                                'w'=>$__msg_dt->w
                            ]
                        ]);

                    }else{ 

                        if($__msg_dt->cnv->est != _CId('ID_SCLCNVEST_RDY')){

                            $this->_ws->Send([
                                'srv'=>'chat',
                                'act'=>'message_new',
                                'to'=>[$__cnv_main->us->enc], // Recibe
                                'data'=>[
                                    'cnv'=>[
                                        'id'=>$__cnv_main->enc,
                                        'tp'=>'whtsp'
                                    ],
                                    'us'=>[
                                        'enc'=>$__from_dt->enc,
                                        'nm'=>$__from_dt->tt,
                                        'ap'=>"",
                                        'onl'=>"ok",
                                        'img'=>DMN_IMG_ESTR_SVG.'chat_whtsp_no.svg'
                                    ],
                                    'us'=>$__cnv_main->us,
                                    'id'=>$_enc,
                                    'tx'=>ctjTx($this->wthspcnvmsg_message,'in'),
                                    'me'=>$this->wthspcnvmsg_me,
                                    'snt'=>$__msg_dt->snt,
                                    'f'=>$__msg_dt->f,
                                    'tp'=>'whtsp'
                                ]
                            ]);

                        }

                    }

                    $rsp['e'] = 'ok';
                    $rsp['enc'] = $_enc;
                    $rsp['snt'] = $__msg_dt->snt;
                    
                }else{
                    $rsp['e'] = 'no';
                    $rsp['w'] = $__cnx->c_p->error;
                    $__cnx->c_p->rollback();
                }
                

                
            }else{

                $rsp['e'] = 'no_all_data';

                if(isN( $this->wthspcnvmsg_message )){
                    $rsp['data']['message'] = 'blank';
                }

                if(isN( $this->__new_from_id )){
                    $rsp['data']['fomid'] = 'blank';
                }
                
                if(isN( $this->__new_cnv_id )){
                    $rsp['data']['conversationid'] = 'blank';
                }
            }
            
            $__cnx->c_p->autocommit(TRUE);

            return _jEnc($rsp);	

        }



        public function Cnv_Upd($p=NULL){ //Ingresa mensajes a la BD
            
            $this->Chk_From();
            $this->Chk_Cnv();
            $this->Chk_Cnv_Us();

            if( !isN($this->wthspcnv_est) && !isN($this->__new_cnv_id) ){
                
                $upd =  $this->UpdF([
                            't'=>'cnv',
                            'f'=>[
                                'wthspcnv_est'=>$this->wthspcnv_est,
                                'wthspcnv_cls'=>$this->wthspcnv_cls
                            ],
                            'id'=>$this->__new_cnv_id
                        ]);
                
                if($upd->e == 'ok'){
                    
                    $rsp['e'] = 'ok';

                    if($this->wthspcnv_est == _CId('ID_SCLCNVEST_RDY')){ 
                        $_wsact = 'chat_conversation_closed';
                    }else{
                        $_wsact = 'chat_conversation_change';
                    }

                    $__c_f1 = date('Y-m-d', strtotime( $this->wthspcnv_cls ));

                    if(isN( $this->wthspcnv_cls ) || $__c_f1 == SIS_F_2 ){

                        $this->_ws->Send([
                            'srv'=>'chat',
                            'act'=>$_wsact,
                            'to'=>[$this->wthspcnvmsg_us_enc], // Recibe
                            'data'=>[
                                'id'=>$this->__cnvdt->enc
                            ]
                        ]);
                    
                    }

                }else{

                    $rsp['e'] = 'no';
                    $rsp['w'] = $upd->w;
                    $rsp['q'] = $upd->q;

                }
                
            }else{

                $rsp['e'] = 'no';
                $rsp['w'] = 'no data';
                $rsp['data']['wthspcnv_est'] = $this->wthspcnv_est;
                $rsp['data']['__new_cnv_id'] = $this->__new_cnv_id;

            }
            
            return _jEnc($rsp);	
        }



        public function Cnv_Msg_Upd($p=NULL){ //Ingresa mensajes a la BD

            $_data = $p['d'];

            if( !isN( $_data->id ) ){
                
                if(
                    $this->wthspcnvmsg_created != $_data->f->main ||
                    mBln($this->wthspcnvmsg_snt) != $_data->est ||
                    isN( $_data->f->main )
                ){
                
                    $upd =  $this->UpdF([
                                't'=>'msg',
                                'f'=>[
                                    'wthspcnvmsg_created'=>$this->wthspcnvmsg_created,
                                    'wthspcnvmsg_snt'=>$this->wthspcnvmsg_snt
                                ],
                                'id'=>$_data->id
                            ]);
                
                    }

                if($upd->e == 'ok'){
                    
                    $rsp['e'] = 'ok';

                    if(!isN( $this->__cnvdt->enc )){
                        
                        if($this->__cnvdt->est == _CId('ID_SCLCNVEST_ON')){
                            
                            $this->_ws->Send([
                                'srv'=>'chat',
                                'act'=>'chat_message_change',
                                'tp'=>'whtsp',
                                '___est'=>$this->__cnvdt->est,
                                'to'=>[$this->wthspcnvmsg_us_enc], // Recibe
                                'data'=>[
                                    '___est'=>$this->__cnvdt->est,
                                    'id'=>$this->__cnvdt->enc
                                ]
                            ]);

                        }

                    }

                }else{
                    $rsp['e'] = 'no';
                }
                
            }else{
                $rsp['e'] = 'no';
            }
            
            return _jEnc($rsp);

        }


        function _Snd(){
            
            $rsp['e'] = 'no';

            if(isN( $this->_wthsp_cnv )){
                $this->_wthsp_cnv = GtWhtspCnvDt([ 'id'=>$this->id_wthspcnv ]);
            }

            if(!isN( $this->_wthsp_cnv ) && !isN( $this->_wthsp_cnv->whtsp->api )){

                if($this->_wthsp_cnv->whtsp->api == _CId('ID_APITHRD_MSVSPC')){

                    $this->_massive->wthspcnvsnd_us = $this->wthspcnvsnd_us;
                    $__rsl = $this->_massive->msg_snd([ 'channel'=>$this->_wthsp_cnv->cid, 'message'=>$this->wthspcnvmsg_message ]);

                    //$rsp['tmp'] = $__rsl->rsl;

                    if(!isN($__rsl->rsl->id) && $__rsl->code == 200){

                        $__usr = $this->Chk_Us([ 'usr'=>$__rsl->rsl->user->username ]);

                        $this->wthspcnvmsg_from = $this->_wthsp_cnv->whtsp->no;
                        $this->wthspcnvmsg_id = $__rsl->rsl->id;
                        $this->wthspcnvmsg_message = $this->wthspcnvmsg_message;
                        $this->wthspcnvmsg_wthspcnv = $this->_wthsp_cnv->cid;
                        $this->wthspcnvmsg_us = $__usr->id;
                        $this->wthspcnvmsg_me = 'ok';

                        $_in = $this->Cnv_Msg_In();
                        
                        if($_in->e == 'ok'){
                            $rsp['e'] = 'ok';
                            $rsp['id'] = $_in->enc;
                            $rsp['snt'] = $_in->snt;
                        }else{
                            $rsp['w'] = $_in->w;
                        }

                    }else{

                        $rsp['code'] = $__rsl->code;
                        $rsp['r'] = $__rsl;
                    
                    }
                
                }

            }

            return _jEnc($rsp);	

        }

        public function UpdF($p=NULL){
		
            global $__cnx;
            
            $rsp['e'] = 'no'; 
            //if($p['t']=='whtsp'){ echo '-----------UpdF---------'.HTML_BR.HTML_BR; }
    
            if(!isN($p)){

                if($p['t']=='msg'){ $tb=TB_WHTSP_CNV_MSG; $fld=$p['f']; $id='id_wthspcnvmsg'; }
                elseif($p['t']=='cnv'){ $tb=TB_WHTSP_CNV; $fld=$p['f']; $id='id_wthspcnv'; }
                elseif($p['t']=='whtsp'){ $tb=TB_WHTSP; $fld=$p['f']; $id='id_wthsp'; }

                if(!isN($p['f'])){
                    foreach($p['f'] as $_f_k=>$_f_v){
                        if(!isN($_f_v) || $_f_v == NULL){
                            $_upd[] = sprintf($_f_k.'=%s', GtSQLVlStr($_f_v, "text")); 
                        }
                    }
                }

                if(!isN($tb) && !isN( $p['id'] ) && !isN($_upd)){

                    $updateSQL = sprintf("UPDATE "._BdStr(DBT).$tb." SET ".implode(',', $_upd)."  WHERE ".$id."=%s",
                                       GtSQLVlStr($p['id'], "int"));
                    
                    //if($p['t']=='whtsp'){ echo $updateSQL; }

                    $Result = $__cnx->_prc($updateSQL);

                    if($Result){   
                        $rsp['e'] = 'ok';
                    }else{
                        $rsp['w'] = $__cnx->c_p->error;
                        $rsp['q'] = $updateSQL;
                    }

                } else{

                    $rsp['w'] = 'No tb/id data';
    
                }

            }else{

                $rsp['w'] = 'No p data';

            }
    
            return _jEnc($rsp);
        }

    }

?>