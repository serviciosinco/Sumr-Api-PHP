<?php

class CRM_Chat{

	public $_chat_d;

	function __construct(){
		$this->_ws = new CRM_Ws;
		$this->_ntf = new CRM_Ntf();
    }

    function __destruct() {
	}

	public function _gtDt($_p=NULL){
		$this->_main_cnv = $this->MainCnvDt();
	}

    public function MainCnvDt($_p=NULL){

        global $__cnx;

		$Vl['e'] = 'no';

		if(!isN( $this->maincnv_enc )){

			$query_DtRg = sprintf("	SELECT *
									FROM "._BdStr(DBC).TB_MAIN_CNV."
									WHERE maincnv_enc=%s
									LIMIT 1", GtSQLVlStr($this->maincnv_enc, 'text')
								);

			$DtRg = $__cnx->_qry($query_DtRg);

			if($DtRg){

				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;

				if($Tot_DtRg > 0){

					$Vl['e'] = 'ok';
					$Vl['id'] = $row_DtRg['id_maincnv'];
					$Vl['enc'] = $row_DtRg['maincnv_enc'];
					$Vl['id'] = $row_DtRg['maincnv_id'];
					$Vl['tp'] = $row_DtRg['maincnv_tp'];

					if($Vl['tp'] == 'eml'){

					}elseif($Vl['tp'] == 'sumr'){
						$Vl['d'] = GtChtDt([ 'id'=>$Vl['id'] ]);
					}elseif($Vl['tp'] == 'whtsp'){
						$Vl['d'] = GtWhtspCnvDt([ 'id'=>$Vl['id'] ]);
					}elseif($Vl['tp'] == 'fb'){

					}elseif($Vl['tp'] == 'ins'){

					}

				}

			}else{

				$Vl['w'] = $__cnx->c_r->error;

			}

			$__cnx->_clsr($DtRg);

		}

		return _jEnc($Vl);

	}

	public function MainCnvMsgRd($_p=NULL){

		global $__cnx;

		$Vl['e'] = 'no';

		if(!isN( $this->_main_cnv->enc )){

			if($this->_main_cnv->tp == 'sumr' && !isN($this->_main_cnv->d->id) ){

				$updateSQL = sprintf("UPDATE "._BdStr(DBC).TB_CHAT_CNVR_MSJ." SET cnvrmsj_rd=%s WHERE cnvrmsj_rd!=%s AND cnvrmsj_cnvr=%s",
									GtSQLVlStr(1, "int"),
									GtSQLVlStr(2, "int"),
									GtSQLVlStr($this->_main_cnv->d->id, "int")
							);

			}

		}

		if(!isN($updateSQL)){

			$Result = $__cnx->_prc($updateSQL);

			if($Result){
				$Vl['e'] = 'ok';
			}

		}

		return _jEnc($Vl);

	}








	public function _Cht_Info(){
		$this->_chat_d = GtChtDt(['id'=>$this->cnvr_enc, 't'=>'enc']);
	}


	public function _Cht_Exst($p=NULL){

		$rsp['enc'] = $this->cnvr_enc = _Cht_Nw_B_Enc([ 'u1'=>$this->cnvr_us_1, 'u2'=>$this->cnvr_us_2 ])->enc;
		$this->_Cht_Info();

		if( $this->_chat_d->e != 'ok' ){

			$sve = $this->_Cht_Nw([ 'enc'=>$this->cnvr_enc ]);

			if($sve->e == 'ok'){
				$rsp['e'] = 'ok';
				$this->_Cht_Info();
			}

		}else{

			$rsp['e'] = 'ok';

			$__rlc_1 = $this->_Cht_Rlc_Us(['u'=>$this->cnvr_us_1, 'c'=>$this->_chat_d->id ]);
			$__rlc_2 = $this->_Cht_Rlc_Us(['u'=>$this->cnvr_us_2, 'c'=>$this->_chat_d->id ]);

			//$rsp['tmp_d'] = $this->_chat_d;
		}

		return _jEnc( $rsp );
	}


	public function _Cht_Nw($p=NULL){

		global $__cnx;

		if(!isN($p['enc'])){

			$__enc_cht = $p['enc'];

			if(!isN($__enc_cht)){

				$Qry = sprintf("INSERT INTO "._BdStr(DBC).TB_CHAT_CNVR." (cnvr_enc, cnvr_est) VALUES (%s, %s)",
									GtSQLVlStr( $__enc_cht , "text"),
									GtSQLVlStr( _Cns('ID_SCLCNVEST_ON') , "text")
								);
				$Result = $__cnx->_prc($Qry);

			}

			if($Result){

				$Vl['e'] = 'ok';
				$Vl['id'] = $__cnx->c_p->insert_id;
				$Vl['enc'] = $__enc_cht;

				$__rlc_1 = $this->_Cht_Rlc_Us(['u'=>$this->cnvr_us_1, 'c'=>$Vl['id']]);
				$__rlc_2 = $this->_Cht_Rlc_Us(['u'=>$this->cnvr_us_2, 'c'=>$Vl['id']]);

				if($__rlc_1->e == 'ok' && $__rlc_2->e == 'ok'){ $Vl['e'] = 'ok'; }else{ $Vl['e'] = 'no'; }

			}else{

				$Vl['e'] = 'no';
				$Vl['w'] = $__cnx->c_p->error;

			}

		}else{

			$Vl['e'] = 'no';

		}

		return _jEnc($Vl);

	}


	public function GtCnvMsgDt($p=NULL){

		global $__cnx;

		if(!isN($p["id"])){ $_fl .= "AND id_cnvrmsj = '".$p["id"]."' "; }
		elseif(!isN($p["enc"])){ $_fl .= "AND cnvrmsj_enc = '".$p["enc"]."' "; }

		$query_DtRg = sprintf('	SELECT id_cnvrmsj, id_cnvr, cnvrmsj_enc, cnvrmsj_msj, cnvrmsj_fi
								FROM '._BdStr(DBC).TB_CHAT_CNVR_MSJ.'
									 INNER JOIN '._BdStr(DBC).TB_CHAT_CNVR.' ON cnvrmsj_cnvr = id_cnvr
								WHERE cnvrmsj_enc != "" '.$_fl.'
								LIMIT 1');

		$DtRg = $__cnx->_qry($query_DtRg);

		if($DtRg){

			$row_DtRg = $DtRg->fetch_assoc();
			$Tot_DtRg = $DtRg->num_rows;

			if($Tot_DtRg > 0){

				$Vl['e'] = "ok";
				$Vl['id'] = $row_DtRg['id_cnvrmsj'];
				$Vl['cnv']['id'] = $row_DtRg['id_cnvr'];
				$Vl['enc'] = ctjTx($row_DtRg['cnvrmsj_enc'],'in');
				$Vl['msg'] = ctjTx($row_DtRg['cnvrmsj_msj'],'in');

				$Vl['f'] = [
					'main'=>$row_DtRg['cnvrmsj_fi'],
					's1'=>date('H:i a', strtotime( $row_DtRg['cnvrmsj_fi'] ))
				];

			}

		}else{

			$Vl['w'] = $__cnx->c_r->error;
			$Vl['e'] = $row_DtRg['no'];

		}

		$__cnx->_clsr($DtRg);

		return(_jEnc($Vl));

	}


	public function _Cht_Msg_Nw($p=NULL){

		$this->_Cht_Info();

		global $__cnx;

		$__enc = Enc_Rnd($this->cnvrmsj_msj.'-'.$this->_chat_d->id.'-'.$this->cnvrmsj_us);

		$insertSQL = sprintf("INSERT INTO "._BdStr(DBC).TB_CHAT_CNVR_MSJ." (cnvrmsj_enc, cnvrmsj_msj, cnvrmsj_cnvr, cnvrmsj_us) VALUES (%s, %s, %s, %s)",
								GtSQLVlStr($__enc, "text"),
								GtSQLVlStr(ctjTx($this->cnvrmsj_msj,'out'), "text"),
								GtSQLVlStr($this->_chat_d->id, "int"),
								GtSQLVlStr($this->cnvrmsj_us, "int"));

		$Result = $__cnx->_prc($insertSQL);

		if($Result){

			$rsp['e'] = 'ok';
			$rsp['enc'] = $__enc;
			$rsp['id'] = $__cnx->c_p->insert_id;

			$this->_Cht_UPD_Us([ 'c'=>$this->_chat_d->id, 'us'=>$this->cnvrmsj_us, 't'=>'nw' ]);
			$__cnv_main = GtMainCnvDt([ 'tp'=>'sumr', 'maincnv_id'=>$this->_chat_d->id, 'us_asgn'=>'ok' ]);
			$__msg_dt = $this->GtCnvMsgDt([ 'enc'=>$__enc ]);

			$rsp['d'] = $__msg_dt;

			if(!isN( $this->_chat_d->us )){
				foreach($this->_chat_d->us as $_us_k=>$_us_v){
					if($_us_v->id != $this->cnvrmsj_us){
						$_to = $_us_v;
					}else{
						$_from = $_us_v;
					}
				}
			}

			$rsp['to'] = $_to;
			$rsp['from'] = $_from;

			$this->_ws->Send([
				'srv'=>'chat',
				'act'=>'message_new',
				'to'=>[$_to->enc],
				'data'=>[
					'cnv'=>[
						'id'=>$__cnv_main->enc,
						'tp'=>'sumr'
					],
					'us'=>[
						'enc'=>$_from->enc,
						'nm'=>$_from->nm,
						'ap'=>$_from->ap,
						'onl'=>'ok',
						'img'=>$_from->img
					],
					'id'=>$__enc,
					'me'=>'no',
					'tx'=>ctjTx($this->cnvrmsj_msj,'in'),
					'snt'=>'ok',
					'f'=>$__msg_dt->f,
					'tp'=>'sumr'
				]
			]);


			$this->_ws->Send([
				'srv'=>'chat',
				'act'=>'message_new',
				'to'=>[$_from->enc],
				'data'=>[
					'cnv'=>[
						'id'=>$__cnv_main->enc,
						'tp'=>'sumr'
					],
					'us'=>[
						'enc'=>$_to->enc,
						'nm'=>$_to->nm,
						'ap'=>$_to->ap,
						'onl'=>'ok',
						'img'=>$_to->img
					],
					'id'=>$__enc,
					'me'=>'ok',
					'tx'=>ctjTx($this->cnvrmsj_msj,'in'),
					'snt'=>'ok',
					'f'=>$__msg_dt->f,
					'tp'=>'sumr'
				]
			]);

			$this->_ntf->ntf_acc = [ 't'=>_CId('ID_NTFACC_NW_MSG'), 'v1'=>$_from->nm, 'v2'=>$this->cnvrmsj_msj ];
			$this->_ntf->ntf_tp  = _CId('ID_NTFTP_CHAT');
			$this->_ntf->ntf_sub = 'sumr';
			$this->_ntf->cl = DB_CL_ID;
			$this->_ntf->ntf_id_enc = $__msg_dt->enc;
			$this->_ntf->ntf_id = $__msg_dt->id;
			$this->_ntf->ntf_us = $_to->id;
			$__sve = $this->_ntf->Prc();

			$this->_ntf->send([ 'id'=>$__sve->in->id ]);

		}else{

			$rsp['e'] = 'no';
			$rsp['m'] = 2;

		}

		return _jEnc( $rsp );

	}



	public function _Cht_Rlc_Us_Chk($p=NULL){

		if(!isN($p['us']) && !isN($p['cnvr'])){

			global $__cnx;

			$query_DtRg = sprintf('	SELECT id_cnvrus
									FROM '._BdStr(DBC).TB_CHAT_CNVR_US.'
									WHERE cnvrus_cnvr="'.$p['cnvr'].'" AND cnvrus_us="'.$p['us'].'"
									LIMIT 1');

			$DtRg = $__cnx->_qry($query_DtRg);

			if($DtRg){

				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;

				if($Tot_DtRg > 0){
					$Vl['e'] = "ok";
					$Vl['id'] = $row_DtRg['id_cnvrus'];
				}

			}else{
				$Vl['w'] = $__cnx->c_r->error;
				$Vl['e'] = $row_DtRg['no'];
			}

			$__cnx->_clsr($DtRg);

		}

		return(_jEnc($Vl));

	}


	public function _Cht_Rlc_Us($p=NULL){

		global $__cnx;

		if(!isN($p['u']) && !isN($p['c'])){

			$_chk = $this->_Cht_Rlc_Us_Chk([ 'cnvr'=>$p['c'], 'us'=>$p['u'] ]);
			//$Vl['tmp_chk'] = $_chk;

			if($_chk->e != 'ok'){

				$Qry = sprintf("INSERT INTO "._BdStr(DBC).TB_CHAT_CNVR_US." (cnvrus_us, cnvrus_cnvr) VALUES (%s,%s)",
											GtSQLVlStr($p['u'], "int"),
											GtSQLVlStr($p['c'], "int"));

				$Result = $__cnx->_prc($Qry);

				if($Result){
					$Vl['e'] = 'ok';
					$Vl['id'] = $__cnx->c_p->insert_id;
				}else{
					$Vl['e'] = 'no';
					$Vl['w'] = $__cnx->c_p->error;
				}

			}else{

				$Vl['e'] = 'ok';

			}

		}else{

			$Vl['e'] = 'no';
			$Vl['w'] = 'no all data';
		}

		return _jEnc($Vl);

	}


	public function _Cht_UPD_Us($p=NULL){

		global $__cnx;

		if(!isN($p['c']) && !isN($p['t'])){

			if($p['t'] == 'nw'){

				$updateSQL = sprintf("UPDATE "._BdStr(DBC).TB_CHAT_CNVR_US." SET cnvrus_shw=%s WHERE cnvrus_us!=%s AND cnvrus_cnvr=%s",
	                       GtSQLVlStr(2, "int"),
	                       GtSQLVlStr($p['us'], "int"),
	                       GtSQLVlStr($p['c'], "int"));

		    }elseif($p['t'] == 'od'){

				$updateSQL = sprintf("UPDATE "._BdStr(DBC).TB_CHAT_CNVR_US." SET cnvrus_shw=%s WHERE cnvrus_us=%s AND cnvrus_cnvr=%s",
	                       GtSQLVlStr(1, "int"),
	                       GtSQLVlStr($p['us'], "int"),
	                       GtSQLVlStr($p['c'], "int"));

		    }

			$Result = $__cnx->_prc($updateSQL);

			if($Result){ $Vl['e'] = 'ok'; }else{ $Vl['e'] = 'no'; }

		}

		return _jEnc($Vl);
	}





	public function _Cht_UPD_Opn($p=NULL){

		global $__cnx;

		$rsp['e'] = 'no';

		if(!isN($this->cnvr_us_1) && !isN($this->cnvr_us_2)){
			$this->cnvr_enc = _Cht_Nw_B_Enc([ 'u1'=>$this->cnvr_us_1, 'u2'=>$this->cnvr_us_2 ])->enc;
		}

		$this->_Cht_Info();

		if($this->cnvrus_opn == 'ok'){ $_e = 1; }else{ $_e = 2; }

		if(!isN( $this->cnvr_enc )){

			if(!isN($this->_chat_d->id) && !isN($this->cnvrus_us)){

				$updateSQL = sprintf("UPDATE "._BdStr(DBC).TB_CHAT_CNVR_US." SET cnvrus_opn=%s WHERE cnvrus_cnvr=%s AND cnvrus_us=%s",
								GtSQLVlStr($_e, "int"),
								GtSQLVlStr($this->_chat_d->id, "int"),
								GtSQLVlStr($this->cnvrus_us, "int"));

				//$rsp['q'] = compress_code( $updateSQL );
				$Result = $__cnx->_prc($updateSQL);

				if($Result){
					$rsp['e'] = 'ok';
					$rsp['m'] = 1;
				}else{
					$rsp['e'] = 'no';
					$rsp['m'] = 2;
					$rsp['w'] = $updateSQL.$__cnx->c_p->error;
				}

			}else{

				$rsp['w'] = 'No id chat '.$__dt_chat->w.' '.$__dt_chat->q;

			}

		}else{

			$rsp['w'] = 'No result on _Cht_Nw_B_Enc';

		}

		return _jEnc($rsp);

	}



}

?>