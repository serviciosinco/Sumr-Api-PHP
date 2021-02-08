<?php

class CRM_Ntf extends CRM_Main {

	function __construct($p=NULL) {

		parent::__construct();

		$this->_aud = new CRM_Aud();
		$this->_out = new CRM_Out();

		if(!isN($p['cl'])){
			$this->cl = $p['cl'];
		}else{
			$this->cl = DB_CL_ID;
		}

	}


	function __destruct() {
		parent::__destruct();
	}



	public function _ntf_qry($p=NULL){

		if(!isN($p['k']) && !isN($p['tp'])){

			if(!isN($p['k'])){ $__k=$p['k']; }
			if(!isN($p['tp'])){ $__tp=$p['tp']; }else{ $__tp='-1'; }
			if(!isN($p['in'])){ $__in='IN'; }else{ $__in='NOT IN'; }

			$_qry = " AND $__k ".$__in." 	(	SELECT ntf_id
												FROM "._BdStr(DBM).TB_NTF."
													 INNER JOIN "._BdStr(DBM).TB_CL." ON ntf_cl = id_cl
												WHERE cl_enc = '".DB_CL_ENC."' AND
													  ntf_tp='".$__tp."' AND
													  ntf_us = '".SISUS_ID."'
											) ";

			return $_qry;

		}

	}


	public function _ntf_dt($p=NULL){

		global $__cnx;

		$Vl['e'] = 'no';

		if(!isN($p['id'])){

			if($p['t'] == 'enc'){
				$__f = 'ntf_enc'; $__ft = 'text';
			}else{
				$__f = 'id_ntf'; $__ft = 'int';
			}

			$query_DtRg = sprintf("	SELECT id_ntf, ntf_enc
									FROM "._BdStr(DBM).TB_NTF."
									WHERE ".$__f."=%s", GtSQLVlStr($p['id'],$__ft));

			$DtRg = $__cnx->_qry($query_DtRg);

			$Vl['q'] = compress_code($query_DtRg);

			if($DtRg){

				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;

				if($Tot_DtRg > 0){
					$Vl['e'] = 'ok';
					$Vl['id'] = $row_DtRg['id_ntf'];
					$Vl['enc'] = ctjTx($row_DtRg['ntf_enc'],'in');
				}

			}else{
				$Vl['w'] = $__cnx->c_r->error;
			}

			$__cnx->_clsr($DtRg);

		}else{

			$Vl['w'] = 'No id for query';

		}

		return _jEnc($Vl);
	}

	public function _ntf_dvc_chk($p){

		global $__cnx;

		$Vl['e']='no';

		if(!isN($p['ntf']) && !isN($p['cid'])){

			$query_DtRg = sprintf('SELECT id_ntfdvc FROM '._BdStr(DBM).TB_NTF_DVC.' WHERE ntfdvc_cid=%s AND ntfdvc_ntf=%s',
							GtSQLVlStr($p['cid'],'text'),
							GtSQLVlStr($p['ntf'],'text'));

			$DtRg = $__cnx->_qry($query_DtRg);

			if($DtRg){

				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;

				if($Tot_DtRg == 1){
					$Vl['e']='ok';
					$Vl['id']=$row_DtRg['id_ntfdvc'];
				}else{
					$Vl['e']='no';
				}
			}

			$__cnx->_clsr($DtRg);

		}

		return(_jEnc($Vl));
	}


	public function _ntf_chk($p){

		global $__cnx;

		$Vl['e']='no';

		if(!isN($p['tp']) && !isN($p['id'])){

			$query_DtRg = sprintf('SELECT * FROM '._BdStr(DBM).TB_NTF.' WHERE ntf_tp=%s AND ntf_cl=%s AND ntf_id=%s AND ntf_us=%s',
						 GtSQLVlStr($p['tp'],'text'),
						 GtSQLVlStr(DB_CL_ID,'int'),
						 GtSQLVlStr($p['id'],'text'),
						 GtSQLVlStr(SISUS_ID,'int'));

			$DtRg = $__cnx->_qry($query_DtRg);

			if($DtRg){

				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;

				if($Tot_DtRg == 1){
					$Vl['e']='ok';
					$Vl['id']=$row_DtRg['id_ntf'];
				}else{
					$Vl['e']='no';
				}
			}

			$__cnx->_clsr($DtRg);

		}

		return(_jEnc($Vl));
	}



	public function _ntf_rd($p=NULL){

		global $__cnx;

		$rsp['e'] = 'no';

		if(!isN($this->gt->ntf)){

			if(!isN($p['tp'])){

				if($p['tp'] == 'tra'){
					$_dt = GtTraDt([ 'id'=>$this->gt->ntf, 't'=>'enc' ]);
				}

				if(!isN($_dt->id)){

					$_chk = $this->_ntf_chk([ 'tp'=>$p['tp'], 'id'=>$_dt->id ]);

					if($_chk->e == 'no'){

						$__enc = Enc_Rnd($p['tp'].'-'.$_dt->id.'-'.SISUS_ID);

						$insertSQL = sprintf("INSERT INTO "._BdStr(DBM).TB_NTF." (ntf_enc, ntf_tp, ntf_cl, ntf_id, ntf_us) VALUES (%s, %s, %s, %s, %s)",
									  GtSQLVlStr($__enc, "text"),
									  GtSQLVlStr($p['tp'], "text"),
									  GtSQLVlStr(DB_CL_ID, "text"),
									  GtSQLVlStr($_dt->id, "text"),
									  GtSQLVlStr(SISUS_ID, "int"));

						$Result_UPD = $__cnx->_prc($insertSQL);

						if($Result_UPD){
							$rsp['e'] = 'ok';
						}else{
							$rsp['w'] = $__cnx->c_r->error;
							_ErrSis(['p'=>$insertSQL, 'd'=>$__cnx->c_r->error]);
						}

					}
				}


			}

		}

		if(!isN($rsp)){ return _jEnc($rsp); }
	}


	public function DtC(){

		if( !isN([ 'a'=>[$this->ntf_ftrgr, $this->ntf_htrgr, $this->ntf_bfro] ]) ){

			$dateTime = new DateTime($this->ntf_ftrgr.' '.$this->ntf_htrgr);
			$dateTime->modify('-'.$this->ntf_bfro.' minutes');
			$this->ntf_f_go = $dateTime->format("Y-m-d");
			$this->ntf_h_go = $dateTime->format("H:i:s");

		}else{

			$this->ntf_f_go = SIS_F2;
			$this->ntf_h_go = SIS_H2;

		}

	}

	public function Dsc(){

		$__ntf_acc = __LsDt([ 'k'=>'ntf_acc', 'id'=>$this->ntf_acc->t, 'no_lmt'=>'ok' ]);
		$this->ntf_dsc = $__ntf_acc->d->dsc->vl;
		$this->ntf_tt = $__ntf_acc->d->ttv->vl;

		for ($i=1; $i<=10; $i++) {
			$this->ntf_dsc = str_replace('[V'.$i.']', $this->ntf_acc->{'v'.$i}, $this->ntf_dsc);
			$this->ntf_tt = str_replace('[V'.$i.']', $this->ntf_acc->{'v'.$i}, $this->ntf_tt);
		}

	}

	public function chk($p=NULL){

		global $__cnx;

		$Vl['e'] = 'no';
		$this->_ntf_upd = '';

		if( !isN([ 'a'=>[ $this->ntf_tp, $this->ntf_sub, $this->ntf_id, $this->ntf_us] ]) ){

			$query_DtRg = '
							SELECT *
							FROM '._BdStr(DBM).TB_NTF.'
							WHERE 	ntf_cl="'.$this->cl.'" AND
									ntf_tp = "'.$this->ntf_tp.'" AND
									ntf_id = "'.$this->ntf_id.'" AND
									ntf_us = "'.$this->ntf_us.'" AND
									ntf_sub = "'.$this->ntf_sub.'"
							LIMIT 1
						';

			$Vl['q'] = compress_code($query_DtRg);

			$DtRg = $__cnx->_qry($query_DtRg);

			if($DtRg){

				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;

				if($Tot_DtRg == 1){
					$Vl['e'] = 'ok';
					$Vl['id'] = $this->ntf_id_upd = $row_DtRg['ntf_enc'];
				}

			}else{

				$Vl['w'] = $__cnx->c_r->error;

			}

			$__cnx->_clsr($DtRg);

		}else{

			$Vl['w'] = 'No data on P';
		}

		return(_jEnc($Vl));

	}

	public function In(){

		global $__cnx;

		if( !isN($this->ntf_tp) ){

			$__enc = Enc_Rnd($this->ntf_tp.'-'.$this->ntf_sub.'-'.$this->ntf_id.'-'.$this->ntf_us);

			$query_DtRg = sprintf("INSERT INTO "._BdStr(DBM).TB_NTF." (ntf_enc, ntf_tp, ntf_sub, ntf_acc, ntf_cl, ntf_id, ntf_id_enc, ntf_us, ntf_tt, ntf_dsc, ntf_ftrgr, ntf_htrgr) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s) ",
					GtSQLVlStr($__enc, 'text'),
					GtSQLVlStr($this->ntf_tp, 'int'),
					GtSQLVlStr($this->ntf_sub, 'text'),
					GtSQLVlStr($this->ntf_acc->t, 'int'),
					GtSQLVlStr($this->cl, 'int'),
					GtSQLVlStr($this->ntf_id, 'int'),
					GtSQLVlStr($this->ntf_id_enc, 'text'),
					GtSQLVlStr($this->ntf_us, 'text'),
					GtSQLVlStr(ctjTx($this->ntf_tt,'out'), 'text'),
					GtSQLVlStr(ctjTx($this->ntf_dsc,'out'), 'text'),
					GtSQLVlStr($this->ntf_f_go, 'text'),
					GtSQLVlStr($this->ntf_h_go, 'text'));

			$DtRg = $__cnx->_prc($query_DtRg);

			if($DtRg){
				$rsp['e'] = 'ok';
				$rsp['m'] = 1;
				$rsp['id'] = $__cnx->c_p->insert_id;
			}else{
				$rsp['e'] = 'no';
				$rsp['m'] = 2;
				$rsp['w'] = $__cnx->c_p->error;
				$rsp['q'] = compress_code($query_DtRg);
			}

		}

		return _jEnc($rsp);

	}

	public function Upd($p=NULL){

		global $__cnx;

		if( !isN($this->ntf_id_upd) ){

			if(!isN($p['e'])){ $_upd[] = sprintf('ntf_e=%s', GtSQLVlStr($p['e'], "int")); }
			if(!isN($p['trgr'])){ $_upd[] = sprintf('ntf_trgr=%s', GtSQLVlStr($p['trgr'], "text")); }

			if(!isN($_upd)){

				$query_DtRg = "UPDATE "._BdStr(DBM).TB_NTF." SET ".implode(',', $_upd)." WHERE ntf_enc='".$this->ntf_id_upd."' ";
				$DtRg = $__cnx->_prc($query_DtRg);

				$rsp['q'] = compress_code( $query_DtRg );

				if($DtRg){
					$rsp['e'] = 'ok';
				}else{
					$rsp['e'] = 'no';
					$rsp['w'] = $__cnx->c_p->error;
					$rsp['q'] = compress_code( $query_DtRg );
				}

			}else{
				$rsp['w'] = 'No update files';
			}



		}else{
			$rsp['w'] = 'No ntf_id_upd data';
		}

		return _jEnc($rsp);

	}

	public function Prc(){

		$rsp['e'] = 'no';

		if( !isN([ 'a'=>[$this->ntf_tp, $this->ntf_sub, $this->ntf_id, $this->ntf_us] ]) ){

			$this->ntf_acc = _jEnc($this->ntf_acc);

			$this->DtC();
			$this->Dsc();

			$__chk = $rsp['chk'] = $this->chk();

			if($__chk->e != 'ok' && isN($__chk->id)){
				$__in = $rsp['in'] = $this->In();
				if($__in->e == 'ok'){ $rsp['e']='ok'; }
			}else{
				$rsp['e']='ok';
			}

		}else{

			$rsp['w'] = TX_FLTDTINC;

		}

		return _jEnc($rsp);

	}


	public function fcm_send($p=NULL){

		global $__cnx;

		if(!isN($p['to']) && !isN($p['tt']) && !isN($p['sbt']) && !isN($p['bdy'])){

			try {

				$_data['notification'] = [
					'title'=>$p['tt'],
					'subtitle'=>$p['sbt'],
					'body'=>$p['bdy'],
					'icon'=>$p['img'],
					'sound'=>'default',
					'requireInteraction'=>true,
					'click_action'=>'https://'.$p['sbd'].'.'.Gt_DMN().'/',
					'tag'=>'require-interaction',
					'data'=>[
						'requireInteraction'=>true,
						'id'=>$p['id']
					]
				];

				$_data['to'] = $p['to'];
				$_data['time_to_live'] = 6000;
				$_data['badge'] = '1';


				$this->_out->out = 'json';
				$this->_out->url = 'https://fcm.googleapis.com/fcm/send';
				$this->_out->o_post = true;
				$this->_out->o_post_f = json_encode($_data);
				$this->_out->o_tmout = 60;
				$this->_out->o_ctmout = 60;
				$this->_out->o_header_http = [
					'Content-Type:application/json',
					'Authorization:key='._Cns('GOO_FCM_KEY')
				];

				try {

					$__snd_e = 2;

					$try=0;

					while($try < 3){
						$rsp = $this->_out->_Rq($_p);
						if($rsp->code == 200 || $rsp->code == 201){ break; }
						sleep(5);
						$try++;
					}

					if(!isN( $rsp->rsl->results[0]->message_id )){
						$__v['e'] = 'ok';
						$__v['id'] = $rsp->rsl->results[0]->message_id;
						$__snd_e = 1;
					}else{
						$__v['e'] = 'no';
						$__v['r'] = $rsp;
					}

				}catch(Exception $e){
					$__v['w'] =$e->getMessage();
				}

			}catch(Exception $e){
				$__v['w'] =$e->getMessage();
			}

		}

		return _jEnc($__v);

	}



	public function InDvc($p=NULL){

		global $__cnx;

		$rsp['e'] = 'no';

		if(!isN( $this->ntf_id_upd )){

			if(!isN($p['cid'])){

				$__dt = $this->_ntf_dt([ 't'=>'enc', 'id'=>$this->ntf_id_upd ]);

				if(!isN($__dt->id)){

					$_chk = $this->_ntf_dvc_chk([ 'ntf'=>$__dt->id, 'cid'=>$p['cid'] ]);

					if($_chk->e == 'no'){

						$__enc = Enc_Rnd($__dt->id.'-'.$p['cid']);

						$insertSQL = sprintf("INSERT INTO "._BdStr(DBM).TB_NTF_DVC." (ntfdvc_enc, ntfdvc_ntf, ntfdvc_dvc, ntfdvc_cid) VALUES (%s, %s, %s, %s)",
									  GtSQLVlStr($__enc, "text"),
									  GtSQLVlStr($__dt->id, "text"),
									  GtSQLVlStr($p['dvc'], "text"),
									  GtSQLVlStr($p['cid'], "text"));

						$prc = $__cnx->_prc($insertSQL);

						$rsp['q'] = compress_code( $insertSQL );

						if($prc){
							$rsp['e'] = 'ok';
							$rsp['id'] = $__cnx->c_p->insert_id;
						}else{
							$rsp['w'] = $__cnx->c_p->error;
							_ErrSis(['p'=>$insertSQL, 'd'=>$__cnx->c_p->error]);
						}

					}else{
						$rsp['e'] = 'ok';
						$rsp['id'] = $_chk->id;
					}

				}else{

					$rsp['w'] = 'No detail of notification for '.$this->ntf_id_upd.' '.$__dt->w;

				}

			}else{

				$rsp['w'] = 'cid empty';

			}

		}else{

			$rsp['w'] = '$this->ntf_id_upd empty';

		}

		if(!isN($rsp)){ return _jEnc($rsp); }
	}

	public function send($_p=NULL){

		global $__cnx;

		$Qry = "    SELECT  id_ntf, ntf_enc, ntf_tp, ntf_acc, ntf_htrgr, ntf_tt, ntf_dsc, ntf_e, id_usdvc, usdvc_gcm_tkn, id_us, cl_sbd,
								"._QrySisSlcF([ 'als'=>'t', 'als_n'=>'tipo' ]).",
								".GtSlc_QryExtra([ 't'=>'fld', 'p'=>'tipo', 'als'=>'t' ])."
						FROM "._BdStr(DBM).TB_NTF."
								INNER JOIN "._BdStr(DBM).TB_CL." ON ntf_cl = id_cl
								INNER JOIN "._BdStr(DBM).TB_US." ON ntf_us = id_us
								INNER JOIN "._BdStr(DBM).TB_US_DVC." ON usdvc_us = id_us
								".GtSlc_QryExtra([ 't'=>'tb', 'col'=>'ntf_tp', 'als'=>'t' ])."
						WHERE id_ntf = '".$_p['id']."' AND usdvc_cl = id_cl
						LIMIT 100
					";

		$Rsl = $__cnx->_qry($Qry);

		if($Rsl){

			$rw = $Rsl->fetch_assoc();
			$tot = $Rsl->num_rows;

			if($tot > 0){

				do{

					$_in_dvc = 'ok';

					$__send =   $this->fcm_send([
									'id'=>$rw['ntf_enc'],
									'to'=>$rw['usdvc_gcm_tkn'],
									'tt'=>ctjTx($rw['ntf_tt'],'in'),
									'sbt'=>'Subtitle',
									'bdy'=>ctjTx($rw['ntf_dsc'],'in'),
									'img'=>DMN_FLE_SIS_SLC.ctjTx($rw['tipo_sisslc_img'],'in'),
									'sbd'=>ctjTx($rw['cl_sbd'],'in')
								]);

					$this->ntf_id_upd = $rw['ntf_enc'];

					if($__send->e == 'ok'){

						$_in_dvc_p = $this->InDvc([ 'e'=>1, 'dvc'=>$rw['id_usdvc'], 'cid'=>$__send->id ]);

						if($_in_dvc_p->e != 'ok'){
							$_in_dvc = 'no';
							$rsp['w'][] = 'Problem on insert device sended '.$_in_dvc_p->w;
						}

					}else{
						$_in_dvc = 'no';
						$rsp['w'][] = 'Problem on send '.$__send->w;
						$rsp['w'][] = $__send;
					}

					if($_in_dvc == 'ok'){

						$_ntf_e_upd = $this->Upd([ 'e'=>1 ]); //print_r( $_ntf_e_upd );

						if($_ntf_e_upd->e == 'ok'){
							$rsp['e'] = 'ok';
							$rsp['m'] = 'Updated success';
						}else{
							$rsp['w'][] = 'Problem on process '.$_ntf_e_upd->w;
						}

					}

				} while ($rw = $Rsl->fetch_assoc());

			}

		}else{
			$rsp['w'][] = $__cnx->c_p->error;
		}

		$__cnx->_clsr($Rsl);

		if(!isN($rsp)){ return _jEnc($rsp); }

	}


}

?>