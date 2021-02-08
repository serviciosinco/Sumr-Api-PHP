<?php

    class CRM_VTex{

        function __construct($p=NULL) {

            global $__dt_cl;

            if(!isN($__dt_cl) && !isN($__dt_cl->id)){
                $this->cl = $__dt_cl;
            }elseif(!isN($p['cl'])){
                $this->cl = $p['cl'];
            }

            if(!isN($this->cl->bd)){ $this->bd=_BdStr($this->cl->bd); }else{ $this->bd=''; }

            $this->out = new CRM_Out();

	    }

	    function __destruct() {
        }

        function init(){
            if(!isN($this->v_account) && !isN($this->v_environment)){
                $this->v_api_url = "https://".$this->v_account.".".$this->v_environment.".com.br/api/";
            }
        }

        public function _Tme($t=NULL){
            if(!isN($t)){
                $dt = new DateTime($t, new DateTimeZone('UTC'));
                //$dt->setTimezone(new DateTimeZone('America/Bogota'));
                return $dt->format('Y-m-d H:i:s.u');
            }
        }

        function ginfo(){

            if(!isN($this->acc) && $this->_vtex_acc->id != $this->acc){
                $this->_vtex_acc = GtVtexDt([ 'id'=>$this->acc ]);
            }

            if(!isN($this->_vtex_acc->id)){
                if($this->_vtex_acc->sndbx->e == 'ok'){
                    $this->v_account = $this->_vtex_acc->sndbx->acc;
                    $this->v_environment = 'vtexcommercestable';
                    $this->v_api_xapp_key = $this->_vtex_acc->sndbx->key;
                    $this->v_api_xapp_tkn = $this->_vtex_acc->sndbx->tkn;
                }else{
                    $this->v_account = $this->_vtex_acc->prd->acc;
                    $this->v_environment = 'vtexcommercestable';
                    $this->v_api_xapp_key = $this->_vtex_acc->prd->key;
                    $this->v_api_xapp_tkn = $this->_vtex_acc->prd->tkn;
                }
            }else{
                $this->v_account = NULL;
                $this->v_environment = NULL;
                $this->v_api_xapp_key = NULL;
                $this->v_api_xapp_tkn = NULL;
            }

            $this->init();

        }

        public function bld($_p=NULL){

            $this->out->o_crqst = NULL;
            $this->out->o_post = false;

			if($_p['t'] == 'mdata_cnt_in'){
                $this->rqu_url = $this->v_api_url.'dataentities/CL/documents/';
                $this->out->o_post = true;
			}elseif($_p['t'] == 'mdata_cnt_upd'){
                $this->rqu_url = $this->v_api_url.'dataentities/CL/documents/';
                $this->out->o_crqst = 'PATCH';
			}elseif($_p['t'] == 'mdata_cnt_chk'){
                $this->rqu_url = $this->v_api_url.'dataentities/CL/search?_fields=id,accountId,email,firstName,lastName';
                $this->out->o_crqst = 'GET';
			}elseif($_p['t'] == 'mdata_forms_ls'){
                $this->rqu_url = $this->v_api_url.'dataentities/';
                $this->out->o_crqst = 'GET';
			}elseif($_p['t'] == 'mdata_forms_estructure'){
                $this->rqu_url = $this->v_api_url.'dataentities/'.$_p['id'].'/';
                $this->out->o_crqst = 'GET';
			}elseif($_p['t'] == 'mdata_forms_leads'){

                if(!isN($_p['date'])){ $_date = '&createdIn='.$_p['date']; }else{ $_date=''; }
                $this->rqu_url = $this->v_api_url.'dataentities/'.$_p['id'].'/search?_fields='.$_p['fields'].'&_sort=createdIn%20ASC'.$_date;
                $this->out->o_crqst = 'GET';

			}elseif($_p['t'] == 'coup_new'){
                $this->rqu_url = $this->v_api_url.'rnb/pvt/coupon/';
                $this->out->o_post = true;
			}elseif($_p['t'] == 'orders_ls'){

                if(!isN($this->rqu_pge)){ $_pge = $this->rqu_pge; }else{ $_pge=1; }
                if($_p['ord']){ $_ord = $_p['ord']; }else{ $_ord='desc'; }
                if($_p['ppge']){ $_ppge = $_p['ppge']; }else{ $_ppge='500'; }
                if($_p['date']){ $_date = '&f_creationDate=creationDate:'.urlencode('['.$_p['date'].'T00:00:00.000Z TO '.$_p['date'].'T23:59:59.999Z]'); }else{ $_date=''; }
                $this->rqu_url = $this->v_api_url.'oms/pvt/orders?orderBy=creationDate,'.$_ord.'&page='.$_pge.'&per_page='.$_ppge.$_date;
                $this->out->o_crqst = 'GET';
                //echo $this->rqu_url;

			}elseif($_p['t'] == 'orders_dt'){
                $this->rqu_url = $this->v_api_url.'oms/pvt/orders/'.$_p['id'];
                $this->out->o_crqst = 'GET';
			}

		}

		public function rqu($_p=NULL){

            //if(isN( $this->_vtex_acc->id )){
                $this->ginfo();
            //}

            $_pdata = $_p['d'];
            $this->rqu_url = NULL;
            $this->out->o_post_f = NULL;

            $this->bld($_p);

            if($this->out->o_post || $this->out->o_crqst == 'PUT' || $this->out->o_crqst == 'PATCH'){
                $this->out->o_post_f = json_encode($_pdata);
                $param=NULL;
            }else{
                if(!isN( $_pdata )){ $param='&'.http_build_query($_pdata); }
            }

			$this->out->url = $this->rqu_url.$param ;
			$this->out->o_ctmout = 10;
            $this->out->o_tmout = 10;

            $this->out->o_header = true;
            $this->out->o_header_http = [
                'Content-Type:application/json',
                'Accept: application/json',
                'X-VTEX-API-AppKey:'.$this->v_api_xapp_key,
                'X-VTEX-API-AppToken:'.$this->v_api_xapp_tkn
            ];

			$this->out->out = 'json';

            if(!isN($this->v_api_xapp_key) && !isN($this->v_api_xapp_tkn)){

                $try=0;

                while($try < 3){
                    $rsp = $this->out->_Rq();
                    if($rsp->code == 200 || $rsp->code == 201){ break; }
                    sleep(5);
                    $try++;
                }

                $this->rqu_pge = '';
                return $rsp;

            }

        }

        public function mdata_cnt_in($p=NULL){

            $this->ginfo();

            if(!isN( $p['eml'] )){
                $_chk = $this->rqu([
                    't'=>'mdata_cnt_chk',
                    'd'=>[ '_keyword'=>$p['eml'] ]
                ]);
                $_r['tmp'][] = $_chk;
            }else{
                $_r['m'][] = 'No email data';
            }

            if( count($_chk->rsl) != 1 || isN($_chk->rsl[0]->id) ){
                if(!isN( $p['doc'] )){ // If not exists with email, check exists with document
                    $_chk = $this->rqu([
                        't'=>'mdata_cnt_chk',
                        'd'=>[ '_keyword'=>$p['doc'] ]
                    ]);
                }else{
                    $_r['m'][] = 'No doc data';
                }
            }

            if( count($_chk->rsl) != 1 || isN($_chk->rsl[0]->id) ){

                $_sve = $this->rqu([
                    't'=>'mdata_cnt_in',
                    'd'=>[
                        'email'=>$p['eml'],
                        'document'=>$p['doc'],
                        'firstName'=>$p['nm'],
                        'lastName'=>$p['ap'],
                        'FidelizacionN'=>true
                    ]
                ]);

                if(!isN( $_sve->rsl->Id ) && !isN( $_sve->rsl->DocumentId )){
                    $_r['e'] = 'ok';
                    $_r['id'] = $_sve->rsl->DocumentId;
                    $_r['eml'] = $p['eml'];
                    $_r['doc'] = $p['doc'];
                }

            }else{

                //$_f_tupd['email'] = $p['eml'];
                $_f_tupd['FidelizacionN'] = true;

                if(!isN( $_chk->rsl[0]->id ) && isN($_chk->rsl[0]->firstName) && !isN($p['nm'])){
                    $_f_tupd['firstName'] = $p['nm'];
                }
                if( !isN( $_chk->rsl[0]->id ) && isN($_chk->rsl[0]->lastName) && !isN($p['ap'])){
                    $_f_tupd['lastName'] = $p['ap'];
                }

                if(!isN($_f_tupd)){
                    $upd = $this->mdata_cnt_upd([
                        'eml'=>$p['eml'],
                        'f'=>$_f_tupd
                    ]);
                }else{
                    echo 'No fields to update';
                }

                if($upd->e == 'ok'){
                    $_r['e'] = 'ok';
                    $_r['id'] = $_chk->rsl[0]->id;
                    $_r['eml'] = $_chk->rsl[0]->email;
                    $_r['doc'] = $_chk->rsl[0]->document;
                }else{
                    $_r['w'] = $upd->w;
                    $_r['r'] = $upd;
                }

            }

            return _jEnc($_r);

        }


        public function mdata_cnt_upd($p=NULL){

            $this->ginfo();

            if(!isN($p['eml'])){ $_data['email'] = $p['eml']; }
            if(!isN($p['doc'])){ $_data['document'] = $p['doc']; }

            if(!isN($p) && !isN($p['f'])){
                foreach($p['f'] as $_f_k=>$_f_v){
                    $_data[$_f_k] = $_f_v;
                }
            }

            if(!isN( $_data )){
                $_sve = $this->rqu([
                    't'=>'mdata_cnt_upd',
                    'd'=>$_data
                ]);
            }

            if(!isN( $_sve->rsl->Id ) && !isN( $_sve->rsl->DocumentId )){
                $_r['e'] = 'ok';
                $_r['id'] = $_sve->rsl->DocumentId;
                $_r['eml'] = $p['eml'];
            }else{
                $_r['r'] = $_sve;
            }

            return _jEnc($_r);

        }



        public function coup_rnd($p=NULL){

            $chars = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
            if(!isN($p['n'])){ $_n=$p['n']; }else{ $_n=8; }

            for ($i=0; $i<$_n; $i++) {
                $res .= $chars[mt_rand(0, strlen($chars)-1)];
            }
            return $res;
        }


        public function pass_rnd($p=NULL){

            $chars = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
            if(!isN($p['n'])){ $_n=$p['n']; }else{ $_n=12; }

            for ($i=0; $i<$_n; $i++) {
                $res .= $chars[mt_rand(0, strlen($chars)-1)];
            }
            return $res;
        }


        public function coup_chk($p=NULL){

            global $__cnx;

            if(!isN($p)){

                $Vl['e'] = 'no';

                if(!isN($p['coup'])){ $__f .= sprintf(' AND vtexcoup_coup= %s ', GtSQLVlStr($p['coup'], 'text')); }
                $__f .= sprintf(' AND vtexcoup_vtex= %s ', GtSQLVlStr($this->_vtex_acc->id, 'int'));

                $query_DtRg = '	SELECT id_vtexcoup, vtexcoup_enc
                                FROM '._BdStr(DBT).TB_VTEX_COUP.'
                                WHERE id_vtexcoup != "" '.$__f;

                $DtRg = $__cnx->_qry($query_DtRg);

                if($DtRg){

                    $row_DtRg = $DtRg->fetch_assoc();
                    $Tot_DtRg = $DtRg->num_rows;

                    if($Tot_DtRg > 0){
                        $Vl['e'] = 'ok';
                        $Vl['id'] = $row_DtRg['id_vtexcoup'];
                        $Vl['enc'] = $row_DtRg['vtexcoup_enc'];
                    }
                }
                $__cnx->_clsr($DtRg);
            }

            return(_jEnc($Vl));

        }


        public function coup_new($p=NULL){

            global $__cnx;

            if(isN( $this->_vtex_acc->id )){
                $this->ginfo();
            }

            $_r['e'] = 'no';

            if(!isN( $this->_vtex_acc->id )){

                $this->ginfo();

                $_coup = $this->coup_rnd();

                if(!isN($_coup)){

                    if($p['norqu'] != 'ok'){

                        $_data['utmSource'] = $p['srce'];
                        if(!isN($p['cmpg'])){ $_data['utmCampaign'] = 'SUMR-VTEX-CMPG-'.$p['cmpg']; }
                        $_data['couponCode'] = $_coup;
                        $_data['isArchived'] = 'false';
                        //$_data['maxItemsPerClient'] = 1;
                        $_get = $this->rqu([ 't'=>'coup_new', 'd'=>$_data ]);
                        $_c_to_sve = $_get->rsl->couponCode;

                    }else{

                        $_c_to_sve = $p['coup'];

                    }



                    if(!isN( $_c_to_sve )){

                        $__enc = Enc_Rnd($p['srce'].'-'.$_coup);

                        if(!isN($p['sumr'])){ $_sumr=$p['sumr']; }else{ $_sumr=2; }

                        $insertSQL = sprintf("INSERT INTO "._BdStr(DBT).TB_VTEX_COUP." (vtexcoup_enc, vtexcoup_vtex, vtexcoup_coup, vtexcoup_sumr, vtexcoup_srce) VALUES (%s, %s, %s, %s, %s)",
                                                GtSQLVlStr($__enc, "text"),
                                                GtSQLVlStr($this->_vtex_acc->id, "int"),
                                                GtSQLVlStr($_c_to_sve, "text"),
                                                GtSQLVlStr($_sumr, "int"),
                                                GtSQLVlStr($p['srce'], "text")
                                            );

                        $Result = $__cnx->_prc($insertSQL);

                        if($Result){
                            $_r['e'] = 'ok';
                            $_r['id'] = $__cnx->c_p->insert_id;
                            $_r['coup'] = $_c_to_sve;
                        }else{
                            $_r['w'] = $__cnx->c_p->error;
                        }

                    }else{
                        $_r['w'] = 'No genera codigo VTEX';
                        $_r['r'] = $_get;
                    }

                }else{

                    $_r['w'] = 'No genera codigo random';
                    $_r['r'] = $_coup;

                }

            }else{
                $_r['w'] = 'no all data';
            }

            return _jEnc($_r);

        }



        public function coup($p=NULL){

            $__chk_coup = $this->coup_chk([ 'coup'=>$p['coup'] ]);

            if($__chk_coup->e != 'ok'){

                $__chk_coup = $this->coup_new([
                                'coup'=>$p['coup'],
                                'srce'=>$p['srce'],
                                'cmpg'=>$p['cmpg'],
                                'norqu'=>$p['norqu'],
                                'sumr'=>$p['sumr']
                            ]);

            }

            if($__chk_coup->e == 'ok'){
                $rsp['e'] = 'ok';
                $rsp['id'] = $__chk_coup->id;
                $rsp['enc'] = $__chk_coup->enc;
                $rsp['coup'] = $__chk_coup->coup;
                $rsp['upd'] = 'ok';
            }

            return _jEnc($rsp);

        }


        public function CmpgInsDt($p=NULL){

            global $__cnx;

            $Vl['e'] = 'no';

            if( (!isN($p['cnt']) && !isN($p['cmpg'])) || !isN($p['enc'])){

                if(!isN($p['cnt'])){ $_f .= sprintf(' AND vtexcmpgins_cnt=%s ', $p['cnt']); }
                if(!isN($p['cmpg'])){ $_f .= sprintf(' AND vtexcmpgins_vtexcmpg=%s ', $p['cmpg']); }
                if(!isN($p['enc'])){ $_f .= sprintf(' AND vtexcmpgins_enc=%s ', GtSQLVlStr($p['enc'], 'text')); }

                $query_DtRg = sprintf(" SELECT id_vtexcmpgins, vtexcmpgins_enc
                                        FROM ".$this->bd.TB_VTEX_CMPG_INS."
                                        WHERE id_vtexcmpgins != '' {$_f}
                                        LIMIT 1");

                $DtRg = $__cnx->_qry($query_DtRg);

                //$Vl['q'] = compress_code( $query_DtRg );

                if($DtRg){

                    $row_DtRg = $DtRg->fetch_assoc();
                    $Tot_DtRg = $DtRg->num_rows;

                    if($Tot_DtRg == 1){
                        $Vl['e'] = 'ok';
                        $Vl['id'] = $row_DtRg['id_vtexcmpgins'];
                        $Vl['enc'] = $row_DtRg['vtexcmpgins_enc'];
                    }else{
                        $Vl['w'] = 'ChckVtexCmpgCnt:'.$__cnx->c_r->error;
                    }
                }

                $__cnx->_clsr($DtRg);
            }

            return(_jEnc($Vl));
        }

        public function CmpgIns_In($p=NULL){

            global $__cnx;

            if(count($p) > 0 && is_array($p)){

                //-------------- DEFAULT VALUE --------------//

                $__enc = Enc_Rnd($p['cmpg'].'-'.$p['cnt']);

                $insertSQL = sprintf("INSERT INTO ".$this->bd.TB_VTEX_CMPG_INS." (vtexcmpgins_enc, vtexcmpgins_vtexcmpg, vtexcmpgins_cnt, vtexcmpgins_coup, vtexcmpgins_rfd) VALUES (%s, %s, %s, %s, %s)",
                           GtSQLVlStr($__enc, "text"),
                           GtSQLVlStr($p['cmpg'], "int"),
                           GtSQLVlStr($p['cnt'], "int"),
                           GtSQLVlStr($p['coup'], "text"),
                           GtSQLVlStr($p['rfd'], "int")
                        );

                $Result = $__cnx->_prc($insertSQL);

                $_r['q'] = $insertSQL;

            }

            if($Result){

                $_r['id'] = $__cnx->c_p->insert_id;
                $_r['e'] = 'ok';

            }else{
                $_r['e'] = 'no';
                $_r['q'] = $insertSQL;
                $_r['w'] = $__cnx->c_p->error;
                $this->w_all .= $__cnx->c_p->error;
            }

            return _jEnc($_r);
        }

        public function InsRfd_In($p=NULL){

            global $__cnx;

            if(count($p) > 0 && is_array($p) && !isN($p['rfd']) && !isN($p['ins'])){

                $_chk = $this->Chck_InsRfd([ 'ins'=>$p['ins'], 'rfd'=>$p['rfd'] ]);

                // $_r['tmp_chk']['ins'] = $p['ins'];
                // $_r['tmp_chk']['rfd'] = $p['rfd'];
                // $_r['tmp_chk']['r'] = $_chk;

                $_r['e'] = 'no';

                if($_chk->e != 'ok'){

                    $__enc = Enc_Rnd($p['ins'].'-'.$p['rfd']);

                    $insertSQL = sprintf("INSERT INTO ".$this->bd.TB_VTEX_CMPG_INS_RFD." (vtexcmpginsrfd_enc, vtexcmpginsrfd_ins, vtexcmpginsrfd_rfd) VALUES (%s, %s, %s)",
                            GtSQLVlStr($__enc, "text"),
                            GtSQLVlStr($p['ins'], "int"),
                            GtSQLVlStr($p['rfd'], "int")
                            );

                    $Result = $__cnx->_prc($insertSQL);

                    //$_r['q'] = $insertSQL;

                    if($Result){
                        $_r['id'] = $__cnx->c_p->insert_id;
                        $_r['e'] = 'ok';
                    }else{
                        $_r['e'] = 'no';
                        $_r['w'] = $__cnx->c_p->error;
                        $this->w_all .= $__cnx->c_p->error;
                    }

                }elseif($_chk->e == 'ok'){

                    $_r['id'] = $_chk->id;
                    $_r['e'] = 'ok';

                }

            }

            return _jEnc($_r);
        }


        public function Ins_Upd($p=NULL){

            global $__cnx;

            if(count($p) > 0 && is_array($p)){

                if($p['tp'] == 'enc'){
                    $__id = 'vtexcmpgins_enc';
                }else{
                    $__id = 'id_vtexcmpgins';
                }

                if(!isN($p['f'])){
                    foreach($p['f'] as $_f_k=>$_f_v){
                        if(!isN($_f_v)){
                            $_upd[] = sprintf($_f_k.'=%s', GtSQLVlStr($_f_v, "text"));
                        }
                    }
                }

                if(!isN($p['bd'])){ $__bd = _BdStr($p['bd']); }elseif(!isN($this->bd)){ $__bd = $this->bd; }

                if(!isN($p['id']) && !isN( $_upd )){
                    $updateSQL = sprintf("UPDATE ".$__bd.TB_VTEX_CMPG_INS." SET ".implode(',', $_upd)." WHERE $__id='".$p['id']."' " );
                    $Result = $__cnx->_prc($updateSQL);
                    //$_r['q'] = compress_code($updateSQL);
                }
            }

            if($Result){

                $_r['e'] = 'ok';

            }else{
                $_r['e'] = 'no';
                $_r['w'] = $__cnx->c_p->error;
                $this->w_all .= $__cnx->c_p->error;
            }

            return _jEnc($_r);
        }

        public function InsRfd_Upd($p=NULL){

            global $__cnx;

            if(count($p) > 0 && is_array($p)){

                if($p['tp'] == 'enc'){
                    $__id = 'vtexcmpginsrfd_enc';
                }else{
                    $__id = 'id_vtexcmpginsrfd';
                }

                if(!isN($p['f'])){
                    foreach($p['f'] as $_f_k=>$_f_v){
                        if(!isN($_f_v)){
                            $_upd[] = sprintf($_f_k.'=%s', GtSQLVlStr($_f_v, "text"));
                        }
                    }
                }

                if(!isN($p['bd'])){ $__bd = _BdStr($p['bd']); }elseif(!isN($this->bd)){ $__bd = $this->bd; }

                if(!isN($p['id']) && !isN( $_upd )){
                    $updateSQL = sprintf("UPDATE ".$__bd.TB_VTEX_CMPG_INS_RFD." SET ".implode(',', $_upd)." WHERE $__id='".$p['id']."' " );
                    $Result = $__cnx->_prc($updateSQL);
                    //$_r['q'] = compress_code($updateSQL);
                }
            }

            if($Result){

                $_r['e'] = 'ok';

            }else{
                $_r['e'] = 'no';
                $_r['w'] = $__cnx->c_p->error;
                $this->w_all .= $__cnx->c_p->error;
            }

            return _jEnc($_r);
        }

        public function CntPss_UPD($p=NULL){

            global $__cnx;

            if(!isN($p['id'])){

                if(!isN($p['sve'])){ $_upd[] = sprintf('vtexcntpss_sve=%s', GtSQLVlStr($p['sve'], "int")); }
                if(!isN($p['cid'])){ $_upd[] = sprintf('vtexcntpss_cid=%s', GtSQLVlStr($p['cid'], "text")); }

                if(count($_upd) > 0){

                    if(!isN($p['bd'])){ $__bd = _BdStr($p['bd']); }elseif(!isN($this->bd)){ $__bd = $this->bd; }

                    try {

                        $updateSQL = "UPDATE ".$__bd.TB_VTEX_CNT_PSS." SET ".implode(',', $_upd)." WHERE vtexcntpss_enc=".GtSQLVlStr( $p['id'] , "text")." LIMIT 1";
                        $ResultUPD = $__cnx->_prc($updateSQL);

                    }catch(Exception $e){

                        $rsp['w'] = $e->getMessage();

                    }

                }

                if($ResultUPD){
                    $rsp['e'] = 'ok';
                }else{
                    $rsp['w'] = $__cnx->c_p->error;
                    $rsp['e'] = 'no';
                }

            }else{
                $rsp['e'] = 'no';
                $rsp['w'] = 'no all data';
            }

            return _jEnc($rsp);

        }

        public function CntPss($p=NULL){

            global $__cnx;

            if(count($p) > 0 && is_array($p)){

                //-------------- DEFAULT VALUE --------------//

                $_chk = $this->Chck_Pss([ 'eml'=>$p['eml'], 'cnt'=>$p['i'] ]);

                $_r['tmp'] = $_chk;
                $_r['e'] = 'no';

                if($_chk->e != 'ok'){

                    $__enc = Enc_Rnd($p['eml'].'-');
                    $__enc_pss = $this->pass_rnd();

                    if(!isN($p['bd'])){ $__bd = _BdStr($p['bd']); }elseif(!isN($this->bd)){ $__bd = $this->bd; }

                    $insertSQL = sprintf("INSERT INTO ".$__bd.TB_VTEX_CNT_PSS."
                                    (vtexcntpss_enc, vtexcntpss_cnt, vtexcntpss_eml, vtexcntpss_pss, vtexcntpss_vtex, vtexcntpss_dc) VALUES
                                    (%s, %s, %s, AES_ENCRYPT( %s , '".ENCRYPT_PASSPHRASE."' ), %s, %s ) ",
                                GtSQLVlStr($__enc, "text"),
                                GtSQLVlStr($p['i'], "int"),
                                GtSQLVlStr($p['eml'], "text"),
                                GtSQLVlStr($__enc_pss, "text"),
                                GtSQLVlStr($p['vtex'], "text"),
                                GtSQLVlStr($p['dc'], "text")
                            );

                    $Result = $__cnx->_prc($insertSQL);

                    if($Result){
                        $_r['id'] = $__cnx->c_p->insert_id;
                        $_r['e'] = 'ok';
                        $_r['in'] = 'ok';
                    }else{
                        $_r['e'] = 'no';
                        $_r['w'] = $__cnx->c_p->error;
                        $this->w_all .= $__cnx->c_p->error;
                    }

                }else{

                    $_r['e'] = 'ok';
                    $_r['exst'] = 'ok';
                    $_r['id'] = $_chk->id;

                }

            }

            return _jEnc($_r);
        }

        public function Chck_Pss($p=NULL){

            global $__cnx;

            $Vl['e'] = 'no';

            if( !isN($p['eml']) && !isN($p['cnt']) ) {

                $query_DtRg = sprintf("SELECT id_vtexcntpss FROM ".$this->bd.TB_VTEX_CNT_PSS." WHERE vtexcntpss_cnt = '".$p['cnt']."' AND vtexcntpss_eml = '".$p['eml']."' LIMIT 1");
                $DtRg = $__cnx->_qry($query_DtRg);

                $Vl['q'] = compress_code($query_DtRg);

                if($DtRg){

                    $row_DtRg = $DtRg->fetch_assoc();
                    $Tot_DtRg = $DtRg->num_rows;

                    if($Tot_DtRg == 1){
                        $Vl['e'] = 'ok';
                        $Vl['id'] = $row_DtRg['id_vtexcntpss'];
                    }
                }

                $__cnx->_clsr($DtRg);
            }

            return(_jEnc($Vl));
        }

        public function Chck_InsRfd($p=NULL){

            global $__cnx;

            $Vl['e'] = 'no';

            if( !isN($p['ins']) && !isN($p['rfd']) ) {

                $query_DtRg = sprintf(" SELECT id_vtexcmpginsrfd
                                        FROM ".$this->bd.TB_VTEX_CMPG_INS_RFD."
                                        WHERE vtexcmpginsrfd_ins = '".$p['ins']."' AND vtexcmpginsrfd_rfd = '".$p['rfd']."'
                                        LIMIT 1");

                $DtRg = $__cnx->_qry($query_DtRg);

                if($DtRg){

                    $row_DtRg = $DtRg->fetch_assoc();
                    $Tot_DtRg = $DtRg->num_rows;

                    if($Tot_DtRg == 1){
                        $Vl['e'] = 'ok';
                        $Vl['id'] = $row_DtRg['id_vtexcmpginsrfd'];
                    }

                }else{
                    $Vl['w'] = $__cnx->c_r->error;
                }

                $__cnx->_clsr($DtRg);
            }

            return(_jEnc($Vl));
        }

        public function front_lgout(){

            unset($_SESSION[DB_CL_ENC_SES.MM_CNT]);
            session_destroy();

        }


        public function OrdChk($p=NULL){

            global $__cnx;

            if(!isN($p) && !isN($p['vtex']) && !isN($p['id'])){

                $Vl['e'] = 'no';

                if(!isN($p['vtex'])){ $__f .= sprintf(' AND vtexord_vtex= %s ', GtSQLVlStr($p['vtex'], 'text')); }
                if(!isN($p['id'])){ $__f .= sprintf(' AND vtexord_cid= %s ', GtSQLVlStr($p['id'], 'text')); }

                $query_DtRg = '	SELECT id_vtexord, vtexord_enc, vtexord_status
                                FROM '._BdStr(DBT).TB_VTEX_ORD.'
                                WHERE id_vtexord != "" '.$__f;

                                $Vl['q'] = compress_code($query_DtRg);

                $DtRg = $__cnx->_qry($query_DtRg);

                if($DtRg){

                    $Vl['e'] = 'ok';
                    $row_DtRg = $DtRg->fetch_assoc();
                    $Tot_DtRg = $DtRg->num_rows;

                    if($Tot_DtRg > 0){
                        $Vl['id'] = $row_DtRg['id_vtexord'];
                        $Vl['enc'] = $row_DtRg['vtexord_enc'];
                        $Vl['status'] = $row_DtRg['vtexord_status'];
                    }

                }

                $__cnx->_clsr($DtRg);
            }

            return(_jEnc($Vl));

        }

        public function Ord($p=NULL){

            global $__cnx;

            $rsp['e'] = 'no';

            if(
                ( !isN($this->vtexord_cid) && !isN($this->vtexord_vtex) && !isN($this->vtexord_status) ) ||
                ( !isN($this->vtexord_id_upd) )
            ){

                if($p['t'] != 'upd'){

                    $__enc = Enc_Rnd( $this->vtexord_cid.'-'.$this->vtexord_vtex.'-'.$this->vtexord_status );

                    $_sql_s = sprintf("INSERT INTO "._BdStr(DBT).TB_VTEX_ORD." (vtexord_enc, vtexord_cid, vtexord_vtex, vtexord_status, vtexord_date_creation) VALUES (%s, %s, %s, %s, %s)",
                                            GtSQLVlStr($__enc, "text"),
                                            GtSQLVlStr($this->vtexord_cid, "text"),
                                            GtSQLVlStr($this->vtexord_vtex, "int"),
                                            GtSQLVlStr($this->vtexord_status, "text"),
                                            GtSQLVlStr($this->vtexord_date_creation, "date"));

                }else{

                    if(!isN($this->vtexord_status)){ $_upd[] = sprintf('vtexord_status=%s', GtSQLVlStr($this->vtexord_status, 'text')); }
                    if(!isN($this->vtexord_coup)){ $_upd[] = sprintf('vtexord_coup=%s', GtSQLVlStr($this->vtexord_coup, 'int')); }
                    if(!isN($this->vtexord_api_dt)){ $_upd[] = sprintf('vtexord_api_dt=%s', GtSQLVlStr($this->vtexord_api_dt, 'int')); }

                    if(!isN($_upd)){
                        $_sql_s = sprintf("UPDATE "._BdStr(DBT).TB_VTEX_ORD." SET ".implode(',', $_upd)." WHERE id_vtexord=%s LIMIT 1",
                                        GtSQLVlStr($this->vtexord_id_upd, "int"));
                    }

                }

                if(!isN($_sql_s)){ $Result_RLC = $__cnx->_prc($_sql_s); }

                if($Result_RLC){

                    $rsp['e'] = 'ok';

                    if($p['t'] != 'upd'){
                        $rsp_i = $__cnx->c_p->insert_id;
                        $rsp['id'] = $rsp_i;
                    }else{
                        $rsp['id'] = $this->vtexord_id_upd;
                    }

                }else{
                    $rsp['w'] = 'No result:'.$__cnx->c_p->error;
                    $rsp['q'] = $_sql_s;
                }
            }else{
                $rsp['w'] = TX_FLTDTINC;
            }

            return _jEnc($rsp);

        }



        public function OrdAttrChk($p=NULL){

            global $__cnx;

            if(!isN($p) && !isN($p['vtexord']) && !isN($p['key'])){

                $Vl['e'] = 'no';

                if(!isN($p['vtexord'])){ $__f .= sprintf(' AND vtexordattr_vtexord= %s ', GtSQLVlStr($p['vtexord'], 'text')); }
                if(!isN($p['key'])){ $__f .= sprintf(' AND vtexordattr_key= %s ', GtSQLVlStr($p['key'], 'text')); }

                $query_DtRg = '	SELECT id_vtexordattr, vtexordattr_enc
                                FROM '._BdStr(DBT).TB_VTEX_ORD_ATTR.'
                                WHERE id_vtexordattr != "" '.$__f;

                $DtRg = $__cnx->_qry($query_DtRg);

                if($DtRg){

                    $row_DtRg = $DtRg->fetch_assoc();
                    $Tot_DtRg = $DtRg->num_rows;

                    if($Tot_DtRg > 0){
                        $Vl['e'] = 'ok';
                        $Vl['id'] = $row_DtRg['id_vtexordattr'];
                        $Vl['enc'] = $row_DtRg['vtexordattr_enc'];
                    }
                }
                $__cnx->_clsr($DtRg);
            }

            return(_jEnc($Vl));

        }

        public function OrdAttr($p=NULL){

            global $__cnx;

            $rsp['e'] = 'no';

            if(!isN($this->vtexordattr_key) && !isN($this->vtexordattr_vtexord)){

                if($p['t'] != 'upd'){

                    $__enc = Enc_Rnd( $this->vtexordattr_key.'-'.$this->vtexordattr_vtexord );

                    $_sql_s = sprintf("INSERT INTO "._BdStr(DBT).TB_VTEX_ORD_ATTR." (vtexordattr_enc, vtexordattr_key, vtexordattr_vtexord, vtexordattr_vl) VALUES (%s, %s, %s, %s)",
                                            GtSQLVlStr($__enc, "text"),
                                            GtSQLVlStr($this->vtexordattr_key, "text"),
                                            GtSQLVlStr($this->vtexordattr_vtexord, "int"),
                                            GtSQLVlStr($this->vtexordattr_vl, "text"));

                }else{

                    $_sql_s = sprintf("UPDATE "._BdStr(DBT).TB_VTEX_ORD_ATTR." SET vtexordattr_vl=%s WHERE id_vtexordattr=%s LIMIT 1",
                                    GtSQLVlStr($this->vtexordattr_vl, "text"),
                                    GtSQLVlStr($this->vtexordattr_id_upd, "int"));
                }

                if(!isN($_sql_s)){ $Result_RLC = $__cnx->_prc($_sql_s); }

                if($Result_RLC){

                    $rsp['e'] = 'ok';

                    if($p['t'] != 'upd'){
                        $rsp_i = $__cnx->c_p->insert_id;
                        $rsp['id'] = $rsp_i;
                    }else{
                        $rsp['id'] = $this->vtexordattr_id_upd;
                    }

                }else{
                    $rsp['w'] = 'No result:'.$__cnx->c_p->error;
                    $rsp['q'] = $_sql_s;
                }
            }else{
                $rsp['w'] = TX_FLTDTINC.' $this->vtexordattr_key:'.$this->vtexordattr_key.' $this->vtexordattr_vtexord:'.$this->vtexordattr_vtexord.' $this->vtexordattr_vl:'.$this->vtexordattr_vl;
            }
            return _jEnc($rsp);
        }


        public function In(){

            $rsp['e'] = 'no';

            if($this->__t == 'ord'){

                $__chk_ord = $this->OrdChk([ 'vtex'=>$this->vtexord_vtex, 'id'=>$this->vtexord_cid ]);

                $rsp['q'] = $__chk_ord;

                if($__chk_ord->e == 'ok'){

                    if(isN( $__chk_ord->id )){

                        $__chk_ord = $this->Ord();

                    }else{

                        $rsp['chk'] = $__chk_ord;

                        if(!isN($__chk_ord->id)){
                            $this->vtexord_id_upd = $__chk_ord->id;
                            $__chk_upd = $this->Ord(['t'=>'upd']);
                        }

                    }

                }

                if($__chk_ord->e == 'ok'){
                    $rsp['e'] = 'ok';
                    $rsp['id'] = $__chk_ord->id;
                    $rsp['enc'] = $__chk_ord->enc;
                    $rsp['upd'] = 'ok';
                }elseif(!isN($__chk_ord->w)){
                    $rsp['w'] = $__chk_ord->w;
                }

            }elseif($this->__t == 'ord_attr'){

                $__chk_ord_attr = $this->OrdAttrChk([ 'vtexord'=>$this->vtexordattr_vtexord, 'key'=>$this->vtexordattr_key ]);

                if($__chk_ord_attr->e == 'ok'){
                    if(!isN($__chk_ord_attr->id)){
                        $this->vtexordattr_id_upd = $__chk_ord_attr->id;
                        $__chk_upd = $this->OrdAttr(['t'=>'upd']);
                    }
                }else{
                    $__chk_ord_attr = $this->OrdAttr();
                }

                if($__chk_ord_attr->e == 'ok'){
                    $rsp['e'] = 'ok';
                    $rsp['id'] = $__chk_ord_attr->id;
                    $rsp['enc'] = $__chk_ord_attr->enc;
                    $rsp['upd'] = 'ok';
                }else{
                    $rsp['w'] = $__chk_ord_attr->w;
                }

            }

            return _jEnc($rsp);

        }


        public function mdata_forms($p=NULL){

            $this->ginfo();

            $_get = $this->rqu([
                't'=>'mdata_forms_ls'
            ]);

            if(!isN( $_get->rsl )){
                $_r['e'] = 'ok';
                $_r['ls'] = $_get->rsl;
            }else{
                $_r['r'] = $_sve;
            }

            return _jEnc($_r);

        }


        public function mdata_forms_estructure($p=NULL){

            $this->ginfo();

            $_get = $this->rqu([
                't'=>'mdata_forms_estructure',
                'id'=>$p['id']
            ]);

            if(!isN( $_get->rsl->fields )){
                $_r['e'] = 'ok';
                $_r['ls'] = $_get->rsl->fields;
            }else{
                $_r['r'] = $_sve;
            }

            return _jEnc($_r);

        }


        public function mdata_forms_leads($p=NULL){

            if(!isN($p['id']) && !isN($p['fields'])){

                $this->ginfo();

                $_get = $this->rqu([
                    't'=>'mdata_forms_leads',
                    'id'=>$p['id'],
                    //'date'=>$p['date'],
                    'fields'=>$p['fields']
                ]);

                if(!isN( $_get->rsl )){

                    $_r['e'] = 'ok';

                    foreach($_get->rsl as $_lead_k=>$_lead_v){

                        if(!isN( $_lead_v->Archivo )){
                            $_file = [
                                'name'=>$_lead_v->Archivo,
                                'url'=>'https://'.$this->v_account.'.vtexcrm.com.br/DynamicForm/GetFile?dataEntityInstanceId='.$p['id'].'-'.$_lead_v->id.'&fileName='.$_lead_v->Archivo
                            ];
                            $_lead_v->Archivo = $_file;
                        }elseif(!isN( $_lead_v->archivo )){
                            $_file = [
                                'name'=>$_lead_v->archivo,
                                'url'=>'https://'.$this->v_account.'.vtexcrm.com.br/DynamicForm/GetFile?dataEntityInstanceId='.$p['id'].'-'.$_lead_v->id.'&fileName='.$_lead_v->archivo
                            ];
                            $_lead_v->Archivo = $_file;
                        }

                        $_r['ls'][] = $_lead_v;

                    }

                }else{
                    $_r['r'] = $_sve;
                }

            }

            return _jEnc($_r);

        }



    }

?>