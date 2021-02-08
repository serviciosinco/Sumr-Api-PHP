<?php

class CRM_Gtwy {

	function __construct($p=NULL){

		global $__dt_cl;

		$this->pay_id_bfr = NULL;

		if(!isN($__dt_cl) && !isN($__dt_cl->id)){
			$this->cl = $__dt_cl;
		}elseif(!isN($p['cl'])){
			$this->cl = $p['cl'];
		}

		if(!isN($this->cl->bd)){ $this->bd=_BdStr($this->cl->bd); }else{ $this->bd=''; }

	}


	public function pay_init($p=NULL){

		$this->_clgtwy = GtClGtwyPayDt([ 't'=>'enc', 'id'=>$this->clgtwypay_enc ]);
		$this->_mdlcnt = GtMdlCntDt([ 't'=>'enc', 'id'=>$this->mdlcnt_enc ]);
		$this->_cnteml = GtCntEmlDt([ 'tp'=>'enc', 'id'=>$this->cnteml_enc, 'd'=>['plcy'=>'ok'] ]);
		$this->_cntdc = GtCntDcDt([ 't'=>'enc', 'id'=>$this->cntdc_enc ]);

		if($this->_mdlcnt->mdl->id){
			$this->_mdl = GtMdlDt([ 'id'=>$this->_mdlcnt->mdl->id ]);
		}

		$this->pay_id_bfr = Enc_Rnd( $this->_clgtwy->id );

	}

	public function pay_est_eq($p=NULL){

		$_gt = $p['g'];
		$_gs = $p['gs'];

		if($_gt == 'pending'){
			$id = _CId('ID_GTWYPAYEST_PNDT');
		}elseif($_gt == 'approved'){
			$id = _CId('ID_GTWYPAYEST_APRBD');
		}elseif($_gt == 'in_process'){
			$id = _CId('ID_GTWYPAYEST_INPRCS');
		}elseif($_gt == 'rejected'){
			if($_gs == 'cc_rejected_bad_filled_card_number'){
				$id = _CId('ID_GTWYPAYEST_RCHZ');
			}elseif($_gs == 'cc_rejected_bad_filled_date'){
				$id = _CId('ID_GTWYPAYEST_RCHZ_FEXPR');
			}elseif($_gs == 'cc_rejected_bad_filled_security_code'){
				$id = _CId('ID_GTWYPAYEST_RCHZ_CDGSCRTY');
			}else{
				$id = _CId('ID_GTWYPAYEST_RCHZ');
			}
		}

		return $id;
	}

	public function pay_lnk_dt($p=NULL){

		global $__cnx;

		if(!isN($p["id"])){ $_fl .= " AND mdlcntpaylnk_cid = '".$p["id"]."' "; }
		if(!isN($p["enc"])){ $_fl .= " AND mdlcntpaylnk_enc = '".$p["enc"]."' "; }

		$query_DtRg = sprintf('	SELECT id_mdlcntpaylnk, mdlcntpaylnk_enc, mdlcntpaylnk_cid, mdlcntpaylnk_gtwy, mdlcntpaylnk_lnk, mdlcntpaylnk_exp, mdlcntpaylnk_sndbx, clgtwypay_enc, mdlcntpaylnk_mdlcnt
								FROM '.$this->bd.TB_MDL_CNT_PAY_LNK.'
									 INNER JOIN '._BdStr(DBM).TB_CL_GTWY_PAY.' ON mdlcntpaylnk_gtwy = id_clgtwypay
								WHERE id_mdlcntpaylnk != "" '.$_fl);

		$DtRg = $__cnx->_qry($query_DtRg);

		if($DtRg){

			$row_DtRg = $DtRg->fetch_assoc();
			$Tot_DtRg = $DtRg->num_rows;

			if($Tot_DtRg > 0){
				$Vl['id'] = $row_DtRg['id_mdlcntpaylnk'];
				$Vl['enc'] = $row_DtRg['mdlcntpaylnk_enc'];
				$Vl['cid'] = $row_DtRg['mdlcntpaylnk_cid'];
				$Vl['gtwy']['id'] = ctjTx($row_DtRg['mdlcntpaylnk_gtwy'],'in');
				$Vl['gtwy']['enc'] = ctjTx($row_DtRg['clgtwypay_enc'],'in');
				$Vl['lnk']['url'] = ctjTx($row_DtRg['mdlcntpaylnk_lnk'],'in');
				$Vl['lnk']['exp'] = ctjTx($row_DtRg['mdlcntpaylnk_exp'],'in');
				$Vl['mdlcnt']['id'] = ctjTx($row_DtRg['mdlcntpaylnk_mdlcnt'],'in');
				$Vl['sndbx'] = mBln($row_DtRg['mdlcntpaylnk_sndbx']);
			}

		}else{
			$Vl['e'] = 'no';
			$Vl['w'] = $__cnx->c_r->error;
		}

		$__cnx->_clsr($DtRg);

		return(_jEnc($Vl));

	}


	private function pay_lnk_in($p=NULL){

		global $__cnx;

		if( !isN($this->mdlcntpaylnk_cid) && !isN( $this->pay_id_bfr )){

			if($this->_clgtwy->sndbx->e == 'ok'){ $___sndbx = 1; }else{ $___sndbx = 2; }
			if(!isN($p['us'])){ $___us = $p['us']; }else{ $___us = SISUS_ID; }

			$insertSQL = sprintf("INSERT INTO ".$this->bd.TB_MDL_CNT_PAY_LNK." (
																mdlcntpaylnk_enc,
																mdlcntpaylnk_cid,
																mdlcntpaylnk_gtwy,
																mdlcntpaylnk_mdlcnt,
																mdlcntpaylnk_qty,
																mdlcntpaylnk_vlr,
																mdlcntpaylnk_vlr_tot,
																mdlcntpaylnk_lnk,
																mdlcntpaylnk_exp,
																mdlcntpaylnk_payer,
																mdlcntpaylnk_items,
																mdlcntpaylnk_attr,
																mdlcntpaylnk_sndbx,
																mdlcntpaylnk_us
															) VALUES
															(
																%s,
																%s,
																%s,
																%s,
																%s,
																%s,
																%s,
																%s,
																%s,
																%s,
																%s,
																%s,
																%s,
																%s
															)",
								GtSQLVlStr($this->pay_id_bfr, "text"),
								GtSQLVlStr(ctjTx($this->mdlcntpaylnk_cid,'out'), "text"),
								GtSQLVlStr($this->mdlcntpaylnk_gtwy, "int"),
								GtSQLVlStr($this->mdlcntpaylnk_mdlcnt, "int"),
								GtSQLVlStr($this->mdlcntpaylnk_qty, "int"),
								GtSQLVlStr(ctjTx($this->mdlcntpaylnk_vlr,'out'), "text"),
								GtSQLVlStr(ctjTx($this->mdlcntpaylnk_vlr_tot,'out'), "text"),
								GtSQLVlStr(ctjTx($this->mdlcntpaylnk_lnk,'out'), "text"),
								GtSQLVlStr($this->mdlcntpaylnk_exp, "text"),
								GtSQLVlStr(ctjTx($this->mdlcntpaylnk_payer,'out', '', ['html'=>'ok', 'qte'=>'no' ]), "text"),
								GtSQLVlStr(ctjTx($this->mdlcntpaylnk_items,'out', '', ['html'=>'ok', 'qte'=>'no' ]), "text"),
								GtSQLVlStr(ctjTx($this->mdlcntpaylnk_attr,'out', '', ['html'=>'ok', 'qte'=>'no' ]), "text"),
								GtSQLVlStr($___sndbx, "int"),
								GtSQLVlStr($___us, "int"));

			$Result = $__cnx->_prc($insertSQL);

			if($Result){
				$rsp['e'] = 'ok';
				$rsp['id'] = $__cnx->c_p->insert_id;
				$rsp['enc'] = $_enc;
			}else{
				$rsp['e'] = 'no';
				$rsp['w'] = $__cnx->c_p->error;
			}

		}else{
			$rsp['e'] = 'no';
		}

		return _jEnc($rsp);
	}


	public function pay_lnk(){

		$this->__new_mdlcntpaylnk_id = NULL;
		$_dt = $this->pay_lnk_dt([ 'id'=>$this->mdlcntpaylnk_cid ]); //Trae el detalle de wthsp_from

		if(!isN($_dt->id)){
			$rsp['id'] = $this->__new_mdlcntpaylnk_id = $_dt->id;
		}else{
			$_in = $this->pay_lnk_in();
			if(!isN($_in->id)){
				$rsp['id'] = $this->__new_mdlcntpaylnk_id = $_in->id;
			}else{
				$rsp['w'] = $_in;
			}
		}

		return _jEnc($rsp);
	}










	public function pay_dt($p=NULL){

		global $__cnx;

		if(!isN($p["id"])){ $_fl .= " AND mdlcntpay_cid = '".$p["id"]."' "; }
		if(!isN($p["est"])){ $_fl .= " AND mdlcntpay_est = '".$p["est"]."' "; }
		if(!isN($p["enc"])){ $_fl .= " AND mdlcntpay_enc = '".$p["enc"]."' "; }

		$query_DtRg = sprintf('	SELECT id_mdlcntpay, mdlcntpay_enc, mdlcntpay_cid, mdlcntpay_gtwy, mdlcntpay_sndbx, clgtwypay_enc
								FROM '.$this->bd.TB_MDL_CNT_PAY.'
									 INNER JOIN '._BdStr(DBM).TB_CL_GTWY_PAY.' ON mdlcntpay_gtwy = id_clgtwypay
								WHERE id_mdlcntpay != "" '.$_fl);

		$DtRg = $__cnx->_qry($query_DtRg);

		if($DtRg){

			$row_DtRg = $DtRg->fetch_assoc();
			$Tot_DtRg = $DtRg->num_rows;

			if($Tot_DtRg > 0){
				$Vl['id'] = $row_DtRg['id_mdlcntpay'];
				$Vl['enc'] = $row_DtRg['mdlcntpay_enc'];
				$Vl['cid'] = $row_DtRg['mdlcntpay_cid'];
				$Vl['gtwy']['id'] = ctjTx($row_DtRg['mdlcntpay_gtwy'],'in');
				$Vl['gtwy']['enc'] = ctjTx($row_DtRg['clgtwypay_enc'],'in');
				$Vl['sndbx'] = mBln($row_DtRg['mdlcntpay_sndbx']);
			}

		}else{
			$Vl['e'] = 'no';
			$Vl['w'] = $__cnx->c_r->error;
		}

		$__cnx->_clsr($DtRg);

		return(_jEnc($Vl));

	}


	private function pay_in($p=NULL){

		global $__cnx;

		if( !isN($this->mdlcntpay_cid) && !isN($this->mdlcntpay_est) ){

			$_enc = Enc_Rnd($this->mdlcntpay_cid);

			$insertSQL = sprintf("INSERT INTO ".$this->bd.TB_MDL_CNT_PAY." (
																mdlcntpay_enc,
																mdlcntpay_cid,
																mdlcntpay_gtwy,
																mdlcntpay_mdlcnt,
																mdlcntpay_est,
																mdlcntpay_mthd,
																mdlcntpay_type,
																mdlcntpay_date,
																mdlcntpay_mnd,
																mdlcntpay_vlr,
																mdlcntpay_status,
																mdlcntpay_status_detail,
																mdlcntpay_lnk,
																mdlcntpay_sndbx
															) VALUES
															(
																%s,
																%s,
																%s,
																%s,
																%s,
																%s,
																%s,
																%s,
																%s,
																%s,
																%s,
																%s,
																%s,
																%s
															)",
								GtSQLVlStr($_enc, "text"),
								GtSQLVlStr(ctjTx($this->mdlcntpay_cid,'out'), "text"),
								GtSQLVlStr($this->mdlcntpay_gtwy, "int"),
								GtSQLVlStr($this->mdlcntpay_mdlcnt, "int"),
								GtSQLVlStr($this->mdlcntpay_est, "int"),
								GtSQLVlStr(ctjTx($this->mdlcntpay_mthd,'out'), "text"),
								GtSQLVlStr(ctjTx($this->mdlcntpay_type,'out'), "text"),
								GtSQLVlStr($this->mdlcntpay_date, "date"),
								GtSQLVlStr(ctjTx($this->mdlcntpay_mnd,'out'), "text"),
								GtSQLVlStr(ctjTx($this->mdlcntpay_vlr,'out'), "text"),
								GtSQLVlStr(ctjTx($this->mdlcntpay_status,'out'), "text"),
								GtSQLVlStr(ctjTx($this->mdlcntpay_status_detail,'out'), "text"),
								GtSQLVlStr($this->mdlcntpay_lnk, "int"),
								GtSQLVlStr($this->mdlcntpay_sndbx, "int"));

			$Result = $__cnx->_prc($insertSQL);

			if($Result){
				$rsp['e'] = 'ok';
				$rsp['id'] = $__cnx->c_p->insert_id;
				$rsp['enc'] = $_enc;
			}else{
				$rsp['e'] = 'no';
				$rsp['w'] = $__cnx->c_p->error.' on '.compress_code( $insertSQL );
			}

		}else{
			$rsp['w'] = 'no cid';
			$rsp['e'] = 'no';
		}

		return _jEnc($rsp);
	}


	public function pay(){

		$this->pay_init();

		$this->__new_mdlcntpay_id = NULL;
		$_dt = $this->pay_dt([ 'id'=>$this->mdlcntpay_cid, 'est'=>$this->mdlcntpay_est ]); //Trae el detalle de wthsp_from

		if(!isN($_dt->id)){
			$rsp['id'] = $this->__new_mdlcntpay_id = $_dt->id;
			$rsp['enc'] = $_dt->enc;
		}else{
			$_in = $this->pay_in();
			if(!isN($_in->id)){
				$rsp['id'] = $this->__new_mdlcntpay_id = $_in->id;
				$rsp['enc'] = $_in->enc;
			}else{
				$rsp['in']['w'] = $_in;
			}
		}

		return _jEnc($rsp);
	}







	function mrcpago_init(){

		$this->pay_init();

		if(!isN($this->_clgtwy->id)){
			$this->mpgo_cl_id = $this->_clgtwy->cid;
		}

		if(!isN($this->_clgtwy->scrt)){
			$this->mpgo_cl_scrt = $this->_clgtwy->scrt;
		}

		if($this->mpgo_init_sndbx == 'ok'){
			$this->mpgo_cl_tkn = $this->_clgtwy->sndbx->tkn;
		}elseif($this->mpgo_init_prd == 'ok'){
			$this->mpgo_cl_tkn = $this->_clgtwy->prd->tkn;
		}elseif($this->_clgtwy->sndbx->e == 'ok'){
			$this->mpgo_cl_tkn = $this->_clgtwy->sndbx->tkn;
		}else{
			$this->mpgo_cl_tkn = $this->_clgtwy->prd->tkn;
		}

		if(!isN( $this->mpgo_cl_id )){ MercadoPago\SDK::setClientId($this->mpgo_cl_id); }
		if(!isN( $this->mpgo_cl_scrt )){ MercadoPago\SDK::setClientSecret($this->mpgo_cl_scrt); }
		if(!isN( $this->mpgo_cl_tkn )){ MercadoPago\SDK::setAccessToken($this->mpgo_cl_tkn); }

	}

	function mrcpago_pay_lnk(){

		$this->mrcpago_init();

		if(!isN( $this->_clgtwy->id ) && !isN( $this->_mdl->id ) && !isN( $this->_cnteml->eml )){

			if(isN($this->mdlcntpaylnk_qty)){
				$this->mdlcntpaylnk_qty = 1;
			}

			if(isN($this->mdlcntpaylnk_exp)){
				$dte_expre = date("Y-m-d\TH:i:s", strtotime('+48 hours'));
				$this->mdlcntpaylnk_exp = $dte_expre;
			}


			try{

				$preference = new MercadoPago\Preference();

				if(!isN( $this->_clgtwy->url->scss )){ $preference->back_urls['success'] = $this->_clgtwy->url->scss; }
				if(!isN( $this->_clgtwy->url->flr )){ $preference->back_urls['failure'] = $this->_clgtwy->url->flr; }
					if(!isN( $this->_clgtwy->url->pndg )){ $preference->back_urls['pending'] = $this->_clgtwy->url->pndg; }

				$item = new MercadoPago\Item;
				$item->id = $this->_mdlcnt->mdl->enc;
				$item->title = $this->_mdlcnt->mdl->nm;
				$item->description = $this->_mdl->nm;
				$item->picture_url = $this->_mdl->img->big;
				$item->quantity = $this->mdlcntpaylnk_qty;


				if(!isN( $this->_mdl->attr_o ) && !isN( $this->_mdl->attr_o->vlr_unq ) && !isN( $this->_mdl->attr_o->vlr_unq->vl )){

					$this->mdlcntpaylnk_vlr = $item->unit_price = $this->_mdl->attr_o->vlr_unq->vl;
					$this->mdlcntpaylnk_vlr_tot = $this->mdlcntpaylnk_vlr * $this->mdlcntpaylnk_qty;

					$payer = new MercadoPago\Payer();
					$payer->name = $this->_mdlcnt->cnt->nm;
					$payer->surname = $this->_mdlcnt->cnt->ap;

					if(!isN( $this->_cnteml->id ) && !isN( $this->_cnteml->eml )){
						$payer->email = $this->_cnteml->eml;
					}

					//$payer->phone = [ 'area_code'=>'57', 'number'=>'' ];

					if(!isN( $this->_cntdc->id ) && !isN( $this->_cntdc->dc )){
						$payer->identification = [ 'type'=>'DNI', 'number'=>$this->_cntdc->dc ];
					}

					$preference->taxes = [
						[ 'type'=>'IVA', 'value'=>0 ]
					];

					$preference->notification_url = DMN_API.'webhook/gateway/mercadopago/?paylnk='.$this->pay_id_bfr.'&cl='.$this->cl->enc;
					$preference->expires = true;
					$preference->expiration_date_from = date("Y-m-d\TH:i:s");
					$preference->expiration_date_to = $this->mdlcntpaylnk_exp;
					$preference->external_reference = 'SUMR-'.$this->pay_id_bfr;

					$this->mdlcntpaylnk_payer = json_encode([
						'name'=>$this->_mdlcnt->cnt->nm,
						'surname'=>$this->_mdlcnt->cnt->ap,
						'email'=>$this->_cnteml->eml,
						'identification'=>[
							'type'=>'DNI',
							'number'=>$this->_cntdc->dc
						]
					]);

					$this->mdlcntpaylnk_items = json_encode([
						'id'=>$this->_mdlcnt->mdl->enc,
						'title'=>$this->_mdlcnt->mdl->nm,
						'description'=>$this->_mdl->nm,
						'picture_url'=>$this->_mdl->img->big,
						'quantity'=>$this->mdlcntpaylnk_qty
					]);

					$this->mdlcntpaylnk_attr = json_encode([
						'notification_url'=>DMN_API.'webhook/gateway/mercadopago/?paylnk='.$this->pay_id_bfr.'&cl='.$this->cl->enc,
						'expires'=>true,
						'expiration_date_from'=>date("Y-m-d\TH:i:s"),
						'expiration_date_to'=>$this->mdlcntpaylnk_exp,
						'external_reference'=>'SUMR-'.$this->pay_id_bfr,
						'taxes'=>[
							[
								'type'=>'IVA',
								'value'=>0
							]
						],
						'back_urls'=>[
							'success'=>$this->_clgtwy->url->scss,
							'failure'=>$this->_clgtwy->url->flr,
							'pending'=>$this->_clgtwy->url->pndg
						]
					]);

					$preference->items = [$item];
					$preference->payer = $payer;
					$preference->save();

					if(!isN( $preference->id )){

						$this->mdlcntpaylnk_gtwy = $this->_clgtwy->id;
						$this->mdlcntpaylnk_cid = $preference->id;
						$this->mdlcntpaylnk_lnk = $preference->init_point;
						$this->mdlcntpaylnk_mdlcnt = $this->_mdlcnt->id;
						$_sve = $this->pay_lnk();

						if(!isN($_sve) && !isN($_sve->id)){
							$_r['e'] = 'ok';
							$_r['id'] = $_sve->enc;
							$_r['lnk']['url'] = $this->mdlcntpaylnk_lnk;
							$_r['tp'] = $this->_clgtwy->gtwy;
						}else{
							$_r['w'] = $_sve;
						}

					}else{

						$_r['wr'] = $preference;

					}

				}else{

					$_r['mdl_cnt'] = $this->_mdlcnt;
					$_r['mdl_iddddd'] = $this->_mdlcnt->mdl->id;
					$_r['mdl_attr_o'] = $this->_mdl;
					$_r['w'] = 'No value to pay';

				}

			}catch(Exception $e){

				$_r['tmp'] = $this->_clgtwy;
				$_r['w'] = 'Error:'.$e->getMessage();

			}

		}else{

			$_r['w'] = 'No basic data to process';

		}

		return _jEnc($_r);

	}


	function mrcpago_pay_dt($p=NULL){

		if(!isN( $p['id'] )){

			try{

				$this->mrcpago_init();
				$payment = MercadoPago\Payment::find_by_id($p['id']);

				if(!isN( $payment->id )){

					$_r['id'] = $payment->id;
					$_r['status'] = $payment->status;
					$_r['status_detail'] = $payment->status_detail;
					$_r['currency_id'] = $payment->currency_id;
					$_r['external_reference'] = $payment->external_reference;
					$_r['payment_method_id'] = $payment->payment_method_id;
					$_r['payment_type_id'] = $payment->payment_type_id;
					$_r['date_created'] = $payment->date_created;
					$_r['transaction_amount'] = $payment->transaction_amount;

					if($p['sve'] == 'ok'){
						$this->mdlcntpay_gtwy = $this->_clgtwy->id;
						$this->mdlcntpay_mthd = $_r['payment_method_id'];
						$this->mdlcntpay_type = $_r['payment_type_id'];
						$this->mdlcntpay_date = $_r['date_created'];
						$this->mdlcntpay_mnd = $_r['currency_id'];
						$this->mdlcntpay_status = $_r['status'];
						$this->mdlcntpay_status_detail = $_r['status_detail'];
						$this->mdlcntpay_vlr = $_r['transaction_amount'];
						$this->mdlcntpay_est = $this->pay_est_eq([ 'g'=>$_r['status'], 'gs'=>$_r['status_detail'] ]);
						$this->mdlcntpay_cid = $_r['id'];
						$_r['save'] = $this->pay();
					}

				}

			}catch(Exception $e){

				$_r['w'] = 'Error:'.$e->getMessage();

			}

		}else{
			$_r['w'] = 'No Id';
		}

		return _jEnc($_r);

	}

}



?>