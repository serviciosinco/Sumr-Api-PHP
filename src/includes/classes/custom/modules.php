<?php

	class CRM_Mdl extends CRM_Cl{

	    function __construct($p=NULL) {

			global $__cnx;
			global $__dt_cl;
			global $__argv;

	        $this->c_r = $__cnx->c_r;
			$__cnx->c_p = $__cnx->c_p;

	        $this->_aud = new CRM_Aud();
			$this->_aws = new API_CRM_Aws();
			$this->_auto = new API_CRM_Auto([ 'argv'=>$__argv ]);

			if(!isN($__dt_cl) && !isN($__dt_cl->id)){
				$this->cl = $__dt_cl;
			}elseif(!isN($p['cl'])){
				$this->cl = GtClDt($p['cl']);
			}else{
				$this->cl = GtClDt( Gt_SbDMN(), "sbd");
			}


			if(!isN($this->cl->bd)){ $this->bd = _BdStr($this->cl->bd); }else{ $this->bd = ''; }
	    }

	    function __destruct() {
	       parent::__destruct();
	   	}


	   	public function MdlCntPrd($p=NULL){

			$Vl['e'] = 'no';

			$__chk = $this->MdlCntPrd_Chk();

			$Vl['chk'] = $__chk;

			if(isN($__chk->id)){
				$__in = $this->MdlCntPrd_In();
				$Vl['in'] = $__in;
				if($__in->e == 'ok'){ $Vl['e'] = 'ok'; }
			}
			if(!isN($__in) || !isN($__chk->id)){
				$__upd = $this->MdlCntPrd_Upd();
				$Vl['upd'] = $__upd;
				if($__upd->e == 'ok'){ $Vl['upd']='ok'; $Vl['e']='ok'; }else{ $Vl['e']='no'; }
			}

			return(_jEnc($Vl));
		}

		public function MdlCntPrd_In($p=NULL){

			global $__cnx;

			$__enc = Enc_Rnd($this->mdlprd_prd.'-'.$this->mdlprd_mdl);

			$query_DtRg = sprintf("INSERT INTO ".$this->bd.TB_MDL_CNT_PRD." (mdlcntprd_enc, mdlcntprd_mdlsprd, mdlcntprd_mdlcnt, mdlcntprd_est) VALUES (%s, %s, %s, %s)",
							GtSQLVlStr($__enc, "text"),
							GtSQLVlStr($this->mdlprd_prd, "int"),
							GtSQLVlStr($this->mdlprd_mdl, "int"),
							GtSQLVlStr($this->mdlprd_est, "int"));

			$Result = $__cnx->_prc($query_DtRg);

			if($Result){
				$rsp['i'] = $this->gt_id_mdlprd = $__cnx->c_p->insert_id;
				$rsp['e'] = 'ok';
				$rsp['m'] = 1;
			}else{
				$rsp['e'] = 'no';
				$rsp['m'] = 2;
				$rsp['w'] = $__cnx->c_p->error;
				$rsp['w_n'] = $__cnx->c_p->errno;
			}

			return _jEnc($rsp);

		}


		public function MdlCntPrd_Upd($p=NULL){

			global $__cnx;

			$rsp['e'] = 'no';

			if(!isN($this->gt_id_mdlprd)){

				if(!isN($this->mdlprd_est)){
					$upd_f[] = sprintf('mdlcntprd_est=%s', GtSQLVlStr($this->mdlprd_est, "int"));
				}

				if(!isN($upd_f)){

					$updateSQL = sprintf("UPDATE ".$this->bd.TB_MDL_CNT_PRD." SET ".implode(',', $upd_f)." WHERE id_mdlcntprd=%s",
		                                 GtSQLVlStr($this->gt_id_mdlprd, "int"));

					$Result = $__cnx->_prc($updateSQL);

					if($Result){
						$rsp['e'] = 'ok';
						$rsp['m'] = 1;
					}else{
						$rsp['m'] = 2;
						$rsp['w'] = $__cnx->c_p->error;
						$rsp['w_n'] = $__cnx->c_p->errno;
					}
				}

			}

			return _jEnc($rsp);

		}

		public function MdlCntPrd_Chk($p=NULL){

			global $__cnx;

			if( !isN($this->mdlprd_prd) && !isN($this->mdlprd_mdl) ){

				$Vl['e'] = 'no';

				$query_DtRg = sprintf('SELECT *
									   FROM '.$this->bd.TB_MDL_CNT_PRD.'
									   WHERE mdlcntprd_mdlsprd = %s AND mdlcntprd_mdlcnt = %s
									   LIMIT 1', GtSQLVlStr($this->mdlprd_prd,'int'), GtSQLVlStr($this->mdlprd_mdl,'int'));

				$DtRg = $__cnx->_qry($query_DtRg);

				if($DtRg){

					$row_DtRg = $DtRg->fetch_assoc();
					$Tot_DtRg = $DtRg->num_rows;

					$Vl['tot'] = $Tot_DtRg;

					if($Tot_DtRg > 0){
						$Vl['e'] = 'ok';
						$Vl['id'] = $this->gt_id_mdlprd =$row_DtRg['id_mdlcntprd'];
						$Vl['enc'] = ctjTx($row_DtRg['mdlcntprd_enc'],'in').$icn;
						$Vl['est'] = mBln($row_DtRg['mdlcntprd_est']);
					}
				}

				$__cnx->_clsr($DtRg);

			}


			return(_jEnc($Vl));
		}

		public function MdlCntHCntc($p=NULL){

			$Vl['e'] = 'no';

			$__chk = $this->MdlCntHCntc_Chk();

			if(isN($__chk->id)){
				$__in = $this->MdlCntHCntc_In();
				$Vl['in'] = $__in;
				if($__in->e == 'ok'){ $Vl['e'] = 'ok'; }
			}else{
				$__upd = $this->MdlCntHCntc_Upd();
				$Vl['upd'] = $__upd;
				if($__upd->e == 'ok'){ $Vl['upd']='ok'; $Vl['e']='ok'; }else{ $Vl['e']='no'; }
			}

			return(_jEnc($Vl));
		}
		public function MdlCntHCntc_Chk($p=NULL){

			global $__cnx;

			if( !isN($this->mdlcntc_cnt) && !isN($this->mdlcntc_cntc) ){

				$Vl['e'] = 'no';

				$query_DtRg = sprintf('SELECT *
									   FROM '.$this->bd.TB_CNT_H_CNTC.'
									   WHERE cnthcntc_cnt = %s AND cnthcntc_clhcntc = (SELECT id_clhcntc FROM '._BdStr(DBM).TB_CL_H_CNTC.' WHERE clhcntc_enc = %s)
									   LIMIT 1', GtSQLVlStr($this->mdlcntc_cnt,'int'), GtSQLVlStr($this->mdlcntc_cntc,'text'));

				$DtRg = $__cnx->_qry($query_DtRg);

				if($DtRg){

					$row_DtRg = $DtRg->fetch_assoc();
					$Tot_DtRg = $DtRg->num_rows;

					$Vl['tot'] = $Tot_DtRg;

					if($Tot_DtRg > 0){
						$Vl['e'] = 'ok';
						$Vl['id'] = $this->gt_id_mdlprd =$row_DtRg['id_cnthcntc'];
						$Vl['enc'] = ctjTx($row_DtRg['cnthcntc_enc'],'in');
					}
				}

				$__cnx->_clsr($DtRg);

			}


			return(_jEnc($Vl));
		}
		public function MdlCntHCntc_In($p=NULL){

			global $__cnx;

			$__enc = Enc_Rnd($this->mdlcntc_cnt.'-'.$this->mdlcntc_cntc);

			$query_DtRg = sprintf("INSERT INTO ".$this->bd.TB_CNT_H_CNTC." (cnthcntc_enc, cnthcntc_cnt, cnthcntc_clhcntc) VALUES (%s, %s, (SELECT id_clhcntc FROM "._BdStr(DBM).TB_CL_H_CNTC." WHERE clhcntc_enc = %s))",
							GtSQLVlStr($__enc, "text"),
							GtSQLVlStr($this->mdlcntc_cnt, "int"),
							GtSQLVlStr($this->mdlcntc_cntc, "text"));

			$Result = $__cnx->_prc($query_DtRg);
				$rsp['edd'] = $query_DtRg;
			if($Result){
				$rsp['i'] = $__cnx->c_p->insert_id;
				$rsp['e'] = 'ok';
				$rsp['m'] = 1;
			}else{
				$rsp['e'] = 'no';
				$rsp['m'] = 2;
				$rsp['w'] = $__cnx->c_p->error;
				$rsp['w_n'] = $__cnx->c_p->errno;
			}

			return _jEnc($rsp);

		}
		public function MdlCntHCntc_Upd($p=NULL){

			global $__cnx;

			$rsp['e'] = 'no';


			if( !isN($this->mdlcntc_cnt) && !isN($this->mdlcntc_cntc) ){


				$query_DtRg = sprintf("DELETE FROM ".$this->bd.TB_CNT_H_CNTC."  WHERE
								cnthcntc_cnt = %s AND
								cnthcntc_clhcntc IN (SELECT id_clhcntc FROM "._BdStr(DBM).TB_CL_H_CNTC." WHERE clhcntc_enc = %s)",

					GtSQLVlStr($this->mdlcntc_cnt, "int"),
					GtSQLVlStr(ctjTx($this->mdlcntc_cntc,'out'), "text"));

				$Result = $__cnx->_prc($query_DtRg);

				if($Result){
					$rsp['e'] = 'ok';
					$rsp['m'] = 1;
				}else{
					$rsp['m'] = 2;
					$rsp['w'] = $query_DtRg;
					$rsp['w_n'] = $__cnx->c_p->errno;
				}

			}


			return _jEnc($rsp);

		}

		public function MdlPrd($p=NULL){

			$Vl['e'] = 'no';
			$__chk = $this->MdlPrd_Chk();

			if(isN($__chk->id)){
				$__in = $this->MdlPrd_In();
				if($__in->e == 'ok'){ $Vl['e'] = 'ok'; }
			}
			if(!isN($__in) || !isN($__chk->id)){
				$__upd = $this->MdlPrd_Upd();
				if($__upd->e == 'ok'){ $Vl['upd']='ok'; $Vl['e']='ok'; }else{ $Vl['e']='no'; }
			}

			return(_jEnc($Vl));
		}

		public function MdlFle_Ls($p=NULL){

		    global $__cnx;

		    $Vl['e'] = 'no';

		    if(!isN($this->mdlfle_mdl)){

				$query_DtRg = "SELECT
								*,
									(
										SELECT COUNT(*)
										FROM ".$this->bd.TB_MDL_EC_FLE."
											 INNER JOIN ".$this->bd.TB_MDL." ON mdlecfle_mdl = id_mdl
											 INNER JOIN "._BdStr(DBM).TB_EC." ON mdlecfle_ec = id_ec

										WHERE id_fle = mdlecfle_fle AND
											  mdlfle_mdl = ( SELECT id_mdl FROM ".$this->bd.TB_MDL." WHERE mdl_enc = '".$this->mdlfle_mdl."' ) AND
											  id_ec = (SELECT id_ec FROM "._BdStr(DBM).TB_EC." WHERE ec_enc = '".$this->mdlfle_ec."')
									) as __est
							FROM
								"._BdStr(DBM).TB_FLE."
							INNER JOIN ".$this->bd.TB_MDL_FLE." ON mdlfle_fle = id_fle
								WHERE mdlfle_mdl = (SELECT id_mdl FROM ".$this->bd.TB_MDL." WHERE mdl_enc = '".$this->mdlfle_mdl."')
							";

				$DtRg = $__cnx->_qry($query_DtRg);

				if($DtRg){

					$row_DtRg = $DtRg->fetch_assoc();
					$Tot_DtRg = $DtRg->num_rows;
					$Vl['tot'] = $Tot_DtRg;

					if($Tot_DtRg > 0){

						$Vl['e'] = 'ok';

						do{
							$Vl['ls'][$row_DtRg['fle_enc']]['enc'] = $row_DtRg['fle_enc'];
							$Vl['ls'][$row_DtRg['fle_enc']]['nm'] = ctjTx($row_DtRg['fle_nm'],'in');
							$Vl['ls'][$row_DtRg['fle_enc']]['est'] = $row_DtRg['__est'];;
						}while($row_DtRg = $DtRg->fetch_assoc());
					}

				}else{

					$Vl['w'] = $this->c_r->error;

				}

				$__cnx->_clsr($DtRg);

			}

			return _jEnc($Vl);
        }


	    public function MdlFle_In($p=NULL){

			global $__cnx;

			$__enc = Enc_Rnd($this->mdlfle_mdl.'-'.$this->mdlfle_ec.'-'.$this->mdlfle_fle);

			$query_DtRg =   sprintf("INSERT INTO ".$this->bd.TB_MDL_EC_FLE." (mdlecfle_enc, mdlecfle_fle, mdlecfle_mdl, mdlecfle_ec) VALUES
									(
										%s,
										(SELECT id_fle FROM "._BdStr(DBM).TB_FLE." WHERE fle_enc = %s),
										(SELECT id_mdl FROM ".TB_MDL." WHERE mdl_enc = %s),
										(SELECT id_ec FROM "._BdStr(DBM).TB_EC." WHERE ec_enc = %s)
									)",
						GtSQLVlStr(ctjTx($__enc,'out'), "text"),
						GtSQLVlStr(ctjTx($this->mdlfle_fle,'out'), "text"),
						GtSQLVlStr(ctjTx($this->mdlfle_mdl,'out'), "text"),
						GtSQLVlStr(ctjTx($this->mdlfle_ec,'out'), "text"));


			$Result = $__cnx->_prc($query_DtRg);

			if($Result){

				$rsp['e'] = 'ok';
				$rsp['m'] = 1;
			}else{
				$rsp['e'] = 'no';
				$rsp['m'] = 2;
				$rsp['w'] = $__cnx->c_p->error;
				$rsp['w_n'] = $__cnx->c_p->errno;
			}

			return _jEnc($rsp);

		}


	    public function MdlFle_Del($p=NULL){

			global $__cnx;

			$query_DtRg = sprintf("DELETE FROM ".$this->bd.TB_MDL_EC_FLE."  WHERE
									mdlecfle_fle IN (SELECT id_fle FROM "._BdStr(DBM).TB_FLE." WHERE fle_enc = %s) AND
									mdlecfle_mdl IN (SELECT id_mdl FROM ".TB_MDL." WHERE mdl_enc = %s) AND
									mdlecfle_ec IN (SELECT id_ec FROM "._BdStr(DBM).TB_EC." WHERE ec_enc = %s)",

						GtSQLVlStr(ctjTx($this->mdlfle_fle,'out'), "text"),
						GtSQLVlStr(ctjTx($this->mdlfle_mdl,'out'), "text"),
						GtSQLVlStr(ctjTx($this->mdlfle_ec,'out'), "text"));


			$Result = $__cnx->_prc($query_DtRg);

			if($Result){

				$rsp['e'] = 'ok';
				$rsp['m'] = 1;

			}else{
				$rsp['e'] = 'no';
				$rsp['m'] = 2;
				$rsp['w'] = $__cnx->c_p->error.' <-> '.$query_DtRg;
				$rsp['w_n'] = $__cnx->c_p->errno;

			}

			return _jEnc($rsp);

		}

		public function MdlSPrdTp_Ls($p=NULL){

		    global $__cnx;

		    $_cl = $this->GtCl();

		    $Vl['e'] = 'no';

			$query_DtRg = "
					SELECT *,(
							SELECT
								COUNT(*)
							FROM
								"._BdStr(DBM).TB_MDL_S_PRD_TP.",
								"._BdStr(DBM).TB_MDL_S_PRD."
							WHERE
								mdlsprdtp_prd = id_mdlsprd
							AND id_mdlstp = mdlsprdtp_tp
							AND id_mdlsprd = '".$this->mdl_prd."'
						) as __est

					FROM "._BdStr(DBM).TB_MDL_S_TP."
						INNER JOIN "._BdStr(DBM).TB_MDL_S_TP_CL." ON mdlstpcl_mdlstp = id_mdlstp
						INNER JOIN "._BdStr(DBM).TB_CL." ON mdlstpcl_cl = id_cl
						WHERE
							cl_enc = '".CL_ENC."'
						ORDER BY
							mdlstp_nm ASC";

			$DtRg = $__cnx->_qry($query_DtRg);

			if($DtRg){

				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;
				$Vl['tot'] = $Tot_DtRg;

				if($Tot_DtRg > 0){

					$Vl['e'] = 'ok';

					do{

						$id_ob = $row_DtRg['mdlstp_enc'];
						$Vl['ls'][$id_ob]['enc'] = $id_ob;
						$Vl['ls'][$id_ob]['nm'] = ctjTx($row_DtRg['mdlstp_nm'],'in');
						$Vl['ls'][$id_ob]['est'] = ctjTx($row_DtRg['__est'],'in');


					}while($row_DtRg = $DtRg->fetch_assoc());

				}

			}
			$__cnx->_clsr($DtRg);
			return _jEnc($Vl);
	    }
	    public function MdlSPrdTp($p=NULL){

			$Vl['e'] = 'no';
			$__chk = $this->MdlSPrdTp_Chk();

			if(isN($__chk->id)){
				$__in = $this->MdlSPrdTp_In();
				if($__in->e == 'ok'){ $Vl['e'] = 'ok'; }
			}elseif(!isN($__chk->id)){
				$__upd = $this->MdlSPrdTp_Del();
				if($__upd->e == 'ok'){ $Vl['upd']='ok'; $Vl['e']='ok'; }else{ $Vl['e']='no'; }
			}

			return(_jEnc($Vl));
		}
	    public function MdlSPrdTp_Chk($p=NULL){

			global $__cnx;


			if( !isN($this->mdl_prd) && !isN($this->mdl_tp) ){

				$Vl['e'] = 'no';

				$query_DtRg = sprintf("SELECT id_mdlsprdtp, mdlsprdtp_enc
									   FROM "._BdStr(DBM).TB_MDL_S_PRD_TP."
									   WHERE mdlsprdtp_prd = %s AND mdlsprdtp_tp = %s
									   LIMIT 1", GtSQLVlStr($this->mdl_prd,'int'), GtSQLVlStr($this->mdl_tp,'int'));

				$DtRg = $__cnx->_qry($query_DtRg);

				if($DtRg){
					$row_DtRg = $DtRg->fetch_assoc();
					$Tot_DtRg = $DtRg->num_rows;

					$Vl['tot'] = $Tot_DtRg;
					$Vl['totddd'] = $query_DtRg;

					if($Tot_DtRg > 0){
						$Vl['e'] = 'ok';
						$Vl['id'] = $this->gt_id_mdlsch =$row_DtRg['id_mdlsprdtp'];
						$Vl['enc'] = ctjTx($row_DtRg['mdlsprdtp_enc'],'in');
					}
				}
				$__cnx->_clsr($DtRg);
			}

			return(_jEnc($Vl));
		}
		public function MdlSPrdTp_In($p=NULL){

			global $__cnx;

			$__enc = Enc_Rnd($this->mdl_prd.'-'.$this->mdl_tp);

			$query_DtRg =   sprintf("INSERT INTO "._BdStr(DBM).TB_MDL_S_PRD_TP." (mdlsprdtp_enc, mdlsprdtp_prd, mdlsprdtp_tp) VALUES (%s, %s, %s)",
							GtSQLVlStr($__enc, "text"),
							GtSQLVlStr($this->mdl_prd, "int"),
							GtSQLVlStr($this->mdl_tp, "int"));

			$Result = $__cnx->_prc($query_DtRg);

			if($Result){
				$rsp['i'] = $this->gt_id_mdlsch = $__cnx->c_p->insert_id;
				$rsp['e'] = 'ok';
				$rsp['m'] = 1;
			}else{
				$rsp['e'] = 'no';
				$rsp['m'] = 2;
				$rsp['w'] = $__cnx->c_p->error;
				$rsp['w_n'] = $__cnx->c_p->errno;
			}

			return _jEnc($rsp);

		}
		public function MdlSPrdTp_Del($p=NULL){

			global $__cnx;

			$query_DtRg = sprintf("DELETE FROM "._BdStr(DBM).TB_MDL_S_PRD_TP." WHERE mdlsprdtp_prd = %s AND mdlsprdtp_tp = %s ",
								GtSQLVlStr(ctjTx($this->mdl_prd, 'out'), "text"),
								GtSQLVlStr(ctjTx($this->mdl_tp, 'out'), "text"));


			$Result = $__cnx->_prc($query_DtRg);

			if($Result){
				$rsp['e'] = 'ok';
				$rsp['m'] = 1;

			}else{
				$rsp['e'] = 'no';
				$rsp['m'] = 2;
				$rsp['w'] = $__cnx->c_p->error.' <-> '.$query_DtRg;
				$rsp['w_n'] = $__cnx->c_p->errno;
			}

			return _jEnc($rsp);

		}

		public function MdlMdl($p=NULL){

			$Vl['e'] = 'no';
			$__chk = $this->MdlMdl_Chk();
			$Vl['es'] = $__chk;
			if(isN($__chk->id)){
				$__in = $this->MdlMdl_In();
				if($__in->e == 'ok'){ $Vl['e'] = 'ok';  }

			}else if(!isN($__in) || !isN($__chk->id)){
				$__upd = $this->MdlMdl_Eli();
				if($__upd->e == 'ok'){ $Vl['eli']='ok'; $Vl['e']='ok'; }else{ $Vl['e']='no'; }
			}

			return(_jEnc($Vl));
		}

		public function MdlMdl_Chk($p=NULL){

			global $__cnx;

			if( !isN($this->mdlmdl_main) && !isN($this->mdlmdl_mdl) ){

				$Vl['e'] = 'no';

				$query_DtRg = sprintf('SELECT *
									   FROM '.$this->bd.TB_MDL_MDL.'
									   WHERE mdlmdl_main = %s AND mdlmdl_mdl = %s
									   LIMIT 1', GtSQLVlStr($this->mdlmdl_main,'int'), GtSQLVlStr($this->mdlmdl_mdl,'int'));

				$DtRg = $__cnx->_qry($query_DtRg);

				if($DtRg){
					$row_DtRg = $DtRg->fetch_assoc();
					$Tot_DtRg = $DtRg->num_rows;

					$Vl['tot'] = $Tot_DtRg;

					if($Tot_DtRg > 0){
						$Vl['e'] = 'ok';
						$Vl['id'] = $this->gt_id_mdlmdl = $row_DtRg['id_mdlmdl'];
						$Vl['enc'] = ctjTx($row_DtRg['mdlmdl_enc'],'in').$icn;
					}
				}

				$__cnx->_clsr($DtRg);

			}

			return(_jEnc($Vl));
		}

		public function MdlMdl_In($p=NULL){

			global $__cnx;

			$__enc = Enc_Rnd($this->mdlmdl_mdl.'-'.$this->mdlmdl_main);

			$query_DtRg = sprintf("INSERT INTO ".$this->bd.TB_MDL_MDL." (mdlmdl_enc, mdlmdl_mdl, mdlmdl_main) VALUES (%s, %s, %s) ",
								GtSQLVlStr(ctjTx($__enc, 'out'), "text"),
								GtSQLVlStr(ctjTx($this->mdlmdl_mdl, 'out'), "text"),
								GtSQLVlStr(ctjTx($this->mdlmdl_main, 'out'), "text"));


			$Result = $__cnx->_prc($query_DtRg);

			if($Result){
				$rsp['e'] = 'ok';
				$rsp['m'] = 1;

			}else{
				$rsp['e'] = 'no';
				$rsp['m'] = 2;
				$rsp['w'] = $__cnx->c_p->error.' <-> '.$query_DtRg;
				$rsp['w_n'] = $__cnx->c_p->errno;
			}

			return _jEnc($rsp);
		}


		public function MdlMdl_Eli($p=NULL){

			global $__cnx;

			$query_DtRg = sprintf("DELETE FROM ".$this->bd.TB_MDL_MDL." WHERE mdlmdl_mdl = %s AND mdlmdl_main = %s ",
								GtSQLVlStr(ctjTx($this->mdlmdl_mdl, 'out'), "text"),
								GtSQLVlStr(ctjTx($this->mdlmdl_main, 'out'), "text"));


			$Result = $__cnx->_prc($query_DtRg);

			if($Result){
				$rsp['e'] = 'ok';
				$rsp['m'] = 1;

			}else{
				$rsp['e'] = 'no';
				$rsp['m'] = 2;
				$rsp['w'] = $__cnx->c_p->error.' <-> '.$query_DtRg;
				$rsp['w_n'] = $__cnx->c_p->errno;
			}

			return _jEnc($rsp);
		}

		public function MdlPrd_Chk($p=NULL){

			global $__cnx;

			if( !isN($this->mdlprd_prd) && !isN($this->mdlprd_mdl) ){

				$Vl['e'] = 'no';

				$query_DtRg = sprintf('SELECT *
									   FROM '.$this->bd.TB_MDL_PRD.'
									   WHERE mdlprd_prd = %s AND mdlprd_mdl = %s
									   LIMIT 1', GtSQLVlStr($this->mdlprd_prd,'int'), GtSQLVlStr($this->mdlprd_mdl,'int'));

				$DtRg = $__cnx->_qry($query_DtRg);

				if($DtRg){

					$row_DtRg = $DtRg->fetch_assoc();
					$Tot_DtRg = $DtRg->num_rows;

					$Vl['tot'] = $Tot_DtRg;

					if($Tot_DtRg > 0){
						$Vl['e'] = 'ok';
						$Vl['id'] = $this->gt_id_mdlprd =$row_DtRg['id_mdlprd'];
						$Vl['enc'] = ctjTx($row_DtRg['mdlprd_enc'],'in').$icn;
						$Vl['est'] = mBln($row_DtRg['mdlprd_est']);
					}

				}

				$__cnx->_clsr($DtRg);

			}

			return(_jEnc($Vl));
		}


		public function MdlPrd_In($p=NULL){

			global $__cnx;

			$__enc = Enc_Rnd($this->mdlprd_prd.'-'.$this->mdlprd_mdl);

			$query_DtRg =   sprintf("INSERT INTO ".$this->bd.TB_MDL_PRD." (mdlprd_enc, mdlprd_prd, mdlprd_mdl, mdlprd_est) VALUES (%s, %s, %s, %s)",
							GtSQLVlStr($__enc, "text"),
							GtSQLVlStr($this->mdlprd_prd, "int"),
							GtSQLVlStr($this->mdlprd_mdl, "int"),
							GtSQLVlStr($this->mdlprd_est, "int"));


			$Result = $__cnx->_prc($query_DtRg);

			if($Result){
				$rsp['i'] = $this->gt_id_mdlprd = $__cnx->c_p->insert_id;
				$rsp['e'] = 'ok';
				$rsp['m'] = 1;
			}else{
				$rsp['e'] = 'no';
				$rsp['m'] = 2;
				$rsp['w'] = $__cnx->c_p->error;
				$rsp['w_n'] = $__cnx->c_p->errno;
			}

			return _jEnc($rsp);

		}


		public function MdlPrd_Upd($p=NULL){


			global $__cnx;

			$rsp['e'] = 'no';

			if(!isN($this->gt_id_mdlprd)){

				if(!isN($this->mdlprd_est)){
					$upd_f[] = sprintf('mdlprd_est=%s', GtSQLVlStr($this->mdlprd_est, "int"));
				}

				if(!isN($upd_f)){

					$updateSQL = sprintf("UPDATE ".$this->bd.TB_MDL_PRD." SET ".implode(',', $upd_f)." WHERE id_mdlprd=%s",
		                                 GtSQLVlStr($this->gt_id_mdlprd, "int"));

					$Result = $__cnx->_prc($updateSQL);

					if($Result){
						$rsp['e'] = 'ok';
						$rsp['m'] = 1;
					}else{
						$rsp['m'] = 2;
						$rsp['w'] = $__cnx->c_p->error;
						$rsp['w_n'] = $__cnx->c_p->errno;
					}
				}

			}

			return _jEnc($rsp);

		}


		public function MdlSPrd($p=NULL){


			$Vl['e'] = 'no';

			if(isN($this->mdlsprd_cl)){ $this->mdlsprd_cl = $this->cl->id; }
			$Vl['chk'] = $__chk = $this->MdlSPrd_Chk();

			if(isN($__chk->id)){
				$__in = $this->MdlSPrd_In();
				if($__in->e == 'ok'){ $Vl['e'] = 'ok'; }
			}
			if(!isN($__in) || !isN($__chk->id)){
				$__upd = $this->MdlSPrd_Upd();
				if($__upd->e == 'ok'){ $Vl['upd']='ok'; $Vl['e']='ok'; }else{ $Vl['e']='no'; }
			}

			return(_jEnc($Vl));
		}


		public function MdlSAre($p=NULL){

			$Vl['e'] = 'no';

			if( $this->est == 'ok'){
				$__in = $this->MdlSAre_In();
				if($__in->e == 'ok'){ $Vl['e'] = 'ok'; }
			}
			if( $this->est == 'no'){
				$__upd = $this->MdlSAre_Del();
				if($__upd->e == 'ok'){ $Vl['upd']='ok'; $Vl['e']='ok'; }else{ $Vl['e']='no'; }
			}



			return(_jEnc($Vl));
		}

		public function MdlSUs($p=NULL){

			$Vl['e'] = 'no';

			if( $this->est == 'ok'){
				$__in = $this->MdlSUs_In();
				if($__in->e == 'ok'){ $Vl['e'] = 'ok'; }else{ $Vl['esss'] = $__in; }
			}
			if( $this->est == 'no'){
				$__upd = $this->MdlSUs_Del();
				if($__upd->e == 'ok'){ $Vl['upd']='ok'; $Vl['e']='ok'; }else{ $Vl['e']='no'; }
			}

			return(_jEnc($Vl));
		}


		public function MdlSFm($p=NULL){

			$Vl['e'] = 'no';

			if( $this->est == 'in'){
				$__in = $this->MdlSFm_In();
				if($__in->e == 'ok'){ $Vl['e'] = 'ok'; }else{ $Vl['esss'] = $__in; }
			}
			if( $this->est == 'del'){
				$__upd = $this->MdlSFm_Del();
				if($__upd->e == 'ok'){ $Vl['upd']='ok'; $Vl['e']='ok'; }else{ $Vl['e']='no'; }
			}

			return(_jEnc($Vl));
		}


		public function MdlSFm_In($p=NULL){

			global $__cnx;

			$__enc = Enc_Rnd($this->id_mdlfm.'-'.$this->id_mdl);

			$query_DtRg =   sprintf("INSERT INTO ".$this->bd.TB_MDL_FM." (mdlfm_enc, mdlfm_mdlstpfm, mdlfm_mdl) VALUES
								 (%s, (SELECT id_mdlstpfm FROM "._BdStr(DBM).TB_MDL_S_TP_FM." WHERE mdlstpfm_enc = %s),
								 (SELECT id_mdl FROM ".$this->bd.TB_MDL." WHERE mdl_enc = %s))",
							GtSQLVlStr($__enc, "text"),
							GtSQLVlStr($this->id_mdlfm, "text"),
							GtSQLVlStr($this->id_mdl, "text"));


			$Result = $__cnx->_prc($query_DtRg);

			if($Result){
				$rsp['i'] = $__cnx->c_p->insert_id;
				$rsp['e'] = 'ok';
				$rsp['m'] = 1;
			}else{
				$rsp['e'] = 'no';
				$rsp['m'] = 2;
				$rsp['w'] = $__cnx->c_p->error;
				$rsp['w_n'] = $__cnx->c_p->errno;
			}

			return _jEnc($rsp);

		}


		public function MdlSFm_Del($p=NULL){

			global $__cnx;

			$query_DtRg =   sprintf("DELETE FROM ".$this->bd.TB_MDL_FM." WHERE
								mdlfm_mdlstpfm = (SELECT id_mdlstpfm FROM "._BdStr(DBM).TB_MDL_S_TP_FM." WHERE mdlstpfm_enc = %s)
								AND mdlfm_mdl = (SELECT id_mdl FROM ".$this->bd.TB_MDL." WHERE mdl_enc = %s)",
							GtSQLVlStr($this->id_mdlfm, "text"),
							GtSQLVlStr($this->id_mdl, "text"));


			$Result = $__cnx->_prc($query_DtRg);

			if($Result){
				$rsp['e'] = 'ok';
				$rsp['m'] = 1;
			}else{
				$rsp['e'] = 'no';
				$rsp['m'] = 2;
				$rsp['w'] = $__cnx->c_p->error;
				$rsp['w_n'] = $__cnx->c_p->errno;
			}

			return _jEnc($rsp);

		}
		/* - - - Proceso Formulario Modulo  - - - */

		public function MdlSUs_In($p=NULL){

			global $__cnx;

			$__enc = Enc_Rnd($this->id_us.'-'.$this->id_mdl);

			$query_DtRg =   sprintf("INSERT INTO ".$this->bd.TB_MDL_US_SND." (mdlussnd_enc, mdlussnd_us, mdlussnd_mdl) VALUES
								(%s, (SELECT id_us FROM "._BdStr(DBM).TB_US." WHERE us_enc = %s),
								 (SELECT id_mdl FROM ".$this->bd.TB_MDL." WHERE mdl_enc = %s))",
							GtSQLVlStr($__enc, "text"),
							GtSQLVlStr($this->id_us, "text"),
							GtSQLVlStr($this->id_mdl, "text"));


			$Result = $__cnx->_prc($query_DtRg);

			if($Result){
				$rsp['i'] = $__cnx->c_p->insert_id;
				$rsp['e'] = 'ok';
				$rsp['m'] = 1;
			}else{
				$rsp['e'] = 'no';
				$rsp['m'] = 2;
				$rsp['w'] = $__cnx->c_p->error;
				$rsp['w_n'] = $__cnx->c_p->errno;
			}

			return _jEnc($rsp);

		}

		public function MdlSUs_Del($p=NULL){

			global $__cnx;

			$query_DtRg =   sprintf("DELETE FROM ".$this->bd.TB_MDL_US_SND." WHERE
								mdlussnd_us = (SELECT id_us FROM "._BdStr(DBM).TB_US." WHERE us_enc = %s)
								AND mdlussnd_mdl = (SELECT id_mdl FROM ".$this->bd.TB_MDL." WHERE mdl_enc = %s)",
							GtSQLVlStr($this->id_us, "text"),
							GtSQLVlStr($this->id_mdl, "text"));


			$Result = $__cnx->_prc($query_DtRg);

			if($Result){
				$rsp['e'] = 'ok';
				$rsp['m'] = 1;
			}else{
				$rsp['e'] = 'no';
				$rsp['m'] = 2;
				$rsp['w'] = $__cnx->c_p->error;
				$rsp['w_n'] = $__cnx->c_p->errno;
			}

			return _jEnc($rsp);

		}

		public function MdlSPrd_Chk($p=NULL){

			global $__cnx;

			if( !isN($this->mdlsprd_nm) && !isN($this->mdlsprd_cl) ){

				$Vl['e'] = 'no';

				$query_DtRg = sprintf('SELECT *
									   FROM '._BdStr(DBM).TB_MDL_S_PRD.'
									   WHERE mdlsprd_cl=%s, mdlsprd_y=%s AND mdlsprd_s=%s
									   LIMIT 1', GtSQLVlStr($this->mdlsprd_cl,'int'),
									   			 GtSQLVlStr($this->mdlsprd_y,'int'),
									   			 GtSQLVlStr($this->mdlsprd_s,'int'));

				$DtRg = $__cnx->_qry($query_DtRg);

				if($DtRg){
					$row_DtRg = $DtRg->fetch_assoc();
					$Tot_DtRg = $DtRg->num_rows;

					$Vl['tot'] = $Tot_DtRg;

					if($Tot_DtRg > 0){
						$Vl['e'] = 'ok';
						$Vl['id'] = $this->gt_id_mdlsprd =$row_DtRg['id_mdlsprd'];
						$Vl['enc'] = ctjTx($row_DtRg['mdlsprd_enc'],'in').$icn;
					}
				}

				$__cnx->_clsr($DtRg);

			}

			return(_jEnc($Vl));
		}


		public function MdlSAre_In($p=NULL){

			global $__cnx;

			$__dt_are = GtClAreDt([ 'enc'=>$this->id_are ]);
			$__dt_mdl = GtMdlDt([ 't'=>'enc', 'id'=>$this->id_mdl ]);

			$query_DtRg =   sprintf("INSERT INTO ".$this->bd.TB_MDL_ARE." (mdlare_are, mdlare_mdl) VALUES ( %s, %s )",
										GtSQLVlStr($__dt_are->id, "int"),
										GtSQLVlStr($__dt_mdl->id, "int"));


			$Result = $__cnx->_prc($query_DtRg);

			if($Result){
				$rsp['i'] = $__cnx->c_p->insert_id;
				$rsp['e'] = 'ok';
				$rsp['m'] = 1;
			}else{
				$rsp['e'] = 'no';
				$rsp['m'] = 2;

				$rsp['w_n'] = $__cnx->c_p->errno;
			}

			return _jEnc($rsp);

		}

		public function MdlSAre_Del($p=NULL){

			global $__cnx;

			$__dt_are = GtClAreDt([ 'enc'=>$this->id_are ]);
			$__dt_mdl = GtMdlDt([ 't'=>'enc', 'id'=>$this->id_mdl ]);

			$query_DtRg =   sprintf("DELETE FROM ".$this->bd.TB_MDL_ARE." WHERE mdlare_are = %s AND mdlare_mdl = %s",
									GtSQLVlStr($__dt_are->id, "int"),
									GtSQLVlStr($__dt_mdl->id, "int"));


			$Result = $__cnx->_prc($query_DtRg);

			if($Result){
				$rsp['e'] = 'ok';
				$rsp['m'] = 1;
			}else{
				$rsp['e'] = 'no';
				$rsp['m'] = 2;
				$rsp['w'] = $__cnx->c_p->error;
				$rsp['w_n'] = $__cnx->c_p->errno;
			}

			return _jEnc($rsp);

		}

		public function MdlSPrd_In($p=NULL){

			global $__cnx;

			$__enc = Enc_Rnd($this->mdlsprd_cl.'-'.$this->mdlsprd_nm);

			$query_DtRg =   sprintf("INSERT INTO "._BdStr(DBM).TB_MDL_S_PRD." (mdlsprd_enc, mdlsprd_cl, mdlsprd_nm, mdlsprd_y, mdlsprd_s, mdlsprd_tp)
									VALUES (%s, %s, %s, %s, %s,(SELECT id_sisslc FROM "._BdStr(DBM).TB_SIS_SLC." WHERE sisslc_enc= %s ))",
							GtSQLVlStr($__enc, "text"),
							GtSQLVlStr($this->mdlsprd_cl, "int"),
							GtSQLVlStr(ctjTx($this->mdlsprd_nm,'out'), "text"),
							GtSQLVlStr($this->mdlsprd_y, "int"),
							GtSQLVlStr($this->mdlsprd_s, "int"),
							GtSQLVlStr(ctjTx($this->mdlsprd_tp,'out'), "text"));


			$Result = $__cnx->_prc($query_DtRg);

			if($Result){
				$rsp['i'] = $this->gt_id_mdlsprd = $__cnx->c_p->insert_id;
				$rsp['e'] = 'ok';
				$rsp['m'] = 1;
			}else{
				$rsp['e'] = 'no';
				$rsp['m'] = 2;
				$rsp['w'] = $__cnx->c_p->error;
				$rsp['w_n'] = $__cnx->c_p->errno;
			}

			return _jEnc($rsp);

		}


		public function MdlSPrd_Upd($p=NULL){

			global $__cnx;

			$rsp['e'] = 'no';

			if(!isN($this->gt_id_mdlsprd)){

				if(!isN($this->mdlsprd_nm)){
					$upd_f[] = sprintf('mdlsprd_nm=%s', GtSQLVlStr(ctjTx($this->mdlsprd_nm,'out'), "text"));
				}

				if(!isN($this->mdlsprd_y)){
					$upd_f[] = sprintf('mdlsprd_y=%s', GtSQLVlStr($this->mdlsprd_y, "int"));
				}

				if(!isN($this->mdlsprd_s)){
					$upd_f[] = sprintf('mdlsprd_s=%s', GtSQLVlStr($this->mdlsprd_s, "int"));
				}

				if(!isN($this->mdlsprd_tp)){
					$upd_f[] = sprintf('mdlsprd_tp=%s', GtSQLVlStr($this->mdlsprd_tp, "int"));
				}

				if(!isN($upd_f)){

					$updateSQL = sprintf("UPDATE "._BdStr(DBM).TB_MDL_S_PRD." SET ".implode(',', $upd_f)." WHERE id_mdlsprd=%s",
		                                 GtSQLVlStr($this->gt_id_mdlsprd, "int"));

					$Result = $__cnx->_prc($updateSQL);

					if($Result){
						$rsp['e'] = 'ok';
						$rsp['m'] = 1;
					}else{
						$rsp['m'] = 2;
						$rsp['w'] = $__cnx->c_p->error;
						$rsp['w_n'] = $__cnx->c_p->errno;
					}
				}

			}

			return _jEnc($rsp);

		}

		//Lista las Actividades

	   	public function GtMdlActLs($p=NULL){

		   	global $__cnx;

		    $Vl['e'] = 'no';

		    if(!isN($this->act_enc)){

			    if( !isN($this->mdlstp_tp) ){
				    $_fl = " AND mdlstp_tp = '".$this->mdlstp_tp."' ";
			    }

				$query_DtRg = "
						SELECT *,
								(	SELECT COUNT(*)
									FROM ".$this->bd.TB_ACT_MDL."
									WHERE actmdl_mdl = id_mdl AND actmdl_act = (SELECT id_act FROM "._BdStr(DBM).TB_ACT." WHERE act_enc = '".$this->act_enc."')
								) AS tot
						FROM ".TB_MDL."
						INNER JOIN "._BdStr(DBM).TB_MDL_S." ON mdl_mdls = id_mdls
						INNER JOIN "._BdStr(DBM).TB_MDL_S_TP." ON mdls_tp = id_mdlstp
						WHERE id_mdl != '' $_fl
						ORDER BY mdl_nm ASC";

				$DtRg = $__cnx->_qry($query_DtRg);

				if($DtRg){
					$row_DtRg = $DtRg->fetch_assoc();
					$Tot_DtRg = $DtRg->num_rows;
					$Vl['tot'] = $Tot_DtRg;

					if($Tot_DtRg > 0){
						$Vl['e'] = 'ok';
						do{
							$Vl['ls'][$row_DtRg['mdl_enc']]['enc'] = $row_DtRg['mdl_enc'];
							$Vl['ls'][$row_DtRg['mdl_enc']]['nm'] = ctjTx($row_DtRg['mdl_nm'],'in');
							$Vl['ls'][$row_DtRg['mdl_enc']]['tot'] = $row_DtRg['tot'];
						}while($row_DtRg = $DtRg->fetch_assoc());
					}
				}

				$__cnx->_clsr($DtRg);

			}

			return _jEnc($Vl);

        }


        // Modulos - Actividades Ingresar
		public function _Act_In($p=NULL){

			global $__cnx;

			$__enc = Enc_Rnd($this->act_enc.'-'.$this->mdl_enc);

			$query_DtRg = sprintf("INSERT INTO ".$this->bd.TB_ACT_MDL." (
																actmdl_enc,
																actmdl_mdl,
																actmdl_act
															  )
															  VALUES
															  (
															  	%s,
															  	(SELECT id_mdl FROM ".TB_MDL." WHERE mdl_enc = %s),
															  	(SELECT id_act FROM	"._BdStr(DBM).TB_ACT." WHERE act_enc = %s)
															  )
								",
								GtSQLVlStr(ctjTx($__enc, 'out'), "text"),
								GtSQLVlStr(ctjTx($this->mdl_enc, 'out'), "text"),
								GtSQLVlStr(ctjTx($this->act_enc, 'out'), "text"));


			$Result = $__cnx->_prc($query_DtRg);

			if($Result){
				$rsp['e'] = 'ok';
				$rsp['m'] = 1;
			}else{
				$rsp['e'] = 'no';
				$rsp['m'] = 2;
				$rsp['w'] = $__cnx->c_p->error.' <-> '.$query_DtRg;
				$rsp['w_n'] = $__cnx->c_p->errno;
			}

			return _jEnc($rsp);

		}


		public function _Act_Eli($p=NULL){

			global $__cnx;

			$query_DtRg = sprintf("DELETE FROM ".$this->bd.TB_ACT_MDL." WHERE
																actmdl_mdl = (SELECT id_mdl FROM ".TB_MDL." WHERE mdl_enc = %s) AND
																actmdl_act = (SELECT id_act FROM	"._BdStr(DBM).TB_ACT." WHERE act_enc = %s)
								",
								GtSQLVlStr(ctjTx($this->mdl_enc, 'out'), "text"),
								GtSQLVlStr(ctjTx($this->act_enc, 'out'), "text"));


			$Result = $__cnx->_prc($query_DtRg);

			if($Result){
				$rsp['e'] = 'ok';
				$rsp['m'] = 1;
			}else{
				$rsp['e'] = 'no';
				$rsp['m'] = 2;
				$rsp['w'] = $__cnx->c_p->error.' <-> '.$query_DtRg;
				$rsp['w_n'] = $__cnx->c_p->errno;
			}

			return _jEnc($rsp);

		}





		public function MdlCntSch_In($p=NULL){

			global $__cnx;

			$__enc = Enc_Rnd($this->mdlsch_sch.'-'.$this->mdlsch_mdl);

			$query_DtRg = sprintf("INSERT INTO ".$this->bd.TB_MDL_CNT_SCH." (mdlcntsch_enc, mdlcntsch_mdlssch, mdlcntsch_mdlcnt, mdlcntsch_est) VALUES (%s, %s, %s, %s)",
							GtSQLVlStr($__enc, "text"),
							GtSQLVlStr($this->mdlsch_sch, "int"),
							GtSQLVlStr($this->mdlsch_mdl, "int"),
							GtSQLVlStr($this->mdlsch_est, "int"));


			$Result = $__cnx->_prc($query_DtRg);

			if($Result){
				$rsp['i'] = $this->gt_id_mdlprd = $__cnx->c_p->insert_id;
				$rsp['e'] = 'ok';
				$rsp['m'] = 1;
			}else{
				$rsp['e'] = 'no';
				$rsp['m'] = 2;
				$rsp['w'] = $__cnx->c_p->error;
				$rsp['w_n'] = $__cnx->c_p->errno;
			}

			return _jEnc($rsp);

		}


		public function MdlCntSch_Upd($p=NULL){

			global $__cnx;

			$rsp['e'] = 'no';

			if(!isN($this->gt_id_mdlsch)){

				if(!isN($this->mdlsch_est)){
					$upd_f[] = sprintf('mdlcntsch_est=%s', GtSQLVlStr($this->mdlsch_est, "int"));
				}

				if(!isN($upd_f)){

					$updateSQL = sprintf("UPDATE ".$this->bd.TB_MDL_CNT_SCH." SET ".implode(',', $upd_f)." WHERE id_mdlcntsch=%s",
		                                 GtSQLVlStr($this->gt_id_mdlsch, "int"));

					$Result = $__cnx->_prc($updateSQL);

					if($Result){
						$rsp['e'] = 'ok';
						$rsp['m'] = 1;
					}else{
						$rsp['m'] = 2;
						$rsp['w'] = $__cnx->c_p->error;
						$rsp['w_n'] = $__cnx->c_p->errno;
					}
				}

			}

			return _jEnc($rsp);

		}


		public function MdlCntSch_Chk($p=NULL){

			global $__cnx;

			if( !isN($this->mdlsch_sch) && !isN($this->mdlsch_mdl) ){

				$Vl['e'] = 'no';

				$query_DtRg = sprintf('SELECT *
									   FROM '.$this->bd.TB_MDL_CNT_SCH.'
									   WHERE mdlcntsch_mdlssch = %s AND mdlcntsch_mdlcnt = %s
									   LIMIT 1', GtSQLVlStr($this->mdlsch_sch,'int'), GtSQLVlStr($this->mdlsch_mdl,'int'));

				$DtRg = $__cnx->_qry($query_DtRg);

				if($DtRg){

					$row_DtRg = $DtRg->fetch_assoc();
					$Tot_DtRg = $DtRg->num_rows;

					$Vl['tot'] = $Tot_DtRg;

					if($Tot_DtRg > 0){
						$Vl['e'] = 'ok';
						$Vl['id'] = $this->gt_id_mdlsch =$row_DtRg['id_mdlcntsch'];
						$Vl['enc'] = ctjTx($row_DtRg['mdlcntsch_enc'],'in').$icn;
						$Vl['est'] = mBln($row_DtRg['mdlcntsch_est']);
					}
				}

				$__cnx->_clsr($DtRg);

			}

			return(_jEnc($Vl));
		}


		public function MdlCntSch($p=NULL){

			$Vl['e'] = 'no';
			$__chk = $this->MdlCntSch_Chk();
			$Vl['chk'] = $__chk;

			if(isN($__chk->id)){
				$__in = $this->MdlCntSch_In();
				$Vl['in'] = $__in;
				if($__in->e == 'ok'){ $Vl['e'] = 'ok'; }
			}
			if((!isN($__in) || !isN($__chk->id)) && $Vl['e'] != 'ok'){
				$__upd = $this->MdlCntSch_Upd();
				$Vl['upd'] = $__upd;
				if($__upd->e == 'ok'){ $Vl['upd']='ok'; $Vl['e']='ok'; }else{ $Vl['e']='no'; }
			}

			return(_jEnc($Vl));
		}


		public function MdlCntChck($p=NULL){

			$Vl['e'] = 'no';
			$__chk = $this->MdlCntChck_Chk();
			$Vl['de'] = $__chk;

			if(isN($__chk->id)){
				$__in = $this->MdlCntChck_In();
				if($__in->e == 'ok'){ $Vl['e'] = 'ok'; }
			}

			if(!isN($__in) || !isN($__chk->id) && $Vl['e'] != 'ok'){
				$__upd = $this->MdlCntChck_Upd();
				if($__upd->e == 'ok'){ $Vl['upd']='ok'; $Vl['e']='ok'; }else{ $Vl['e']=$__upd->e; }
			}

			return(_jEnc($Vl));
		}

		public function MdlCntChck_In($p=NULL){

			global $__cnx;

			$__enc = Enc_Rnd($this->mdlchck_chck.'-'.$this->mdlchck_mdlcnt);

			$query_DtRg = sprintf("INSERT INTO ".$this->bd.TB_MDL_CNT_CHCK." (mdlcntchck_enc, mdlcntchck_sisslc, mdlcntchck_mdlcnt, mdlcntchck_est) VALUES (%s, %s, %s, %s)",
							GtSQLVlStr($__enc, "text"),
							GtSQLVlStr($this->mdlchck_chck, "int"),
							GtSQLVlStr($this->mdlchck_mdlcnt, "int"),
							GtSQLVlStr($this->mdlchck_est, "int"));


			$Result = $__cnx->_prc($query_DtRg);

			if($Result){
				$rsp['i'] = $this->gt_id_mdlcntchck = $__cnx->c_p->insert_id;
				$rsp['e'] = 'ok';
				$rsp['m'] = 1;
			}else{
				$rsp['e'] = 'no';
				$rsp['m'] = 2;
				$rsp['w'] = $__cnx->c_p->error;
				$rsp['w_n'] = $__cnx->c_p->errno;
			}

			return _jEnc($rsp);

		}

		public function MdlCntChck_Upd($p=NULL){

			global $__cnx;

			$rsp['e'] = 'no';

			if(!isN($this->gt_id_mdlcntchck)){

				if(!isN($this->mdlchck_est)){
					$upd_f[] = sprintf('mdlcntchck_est=%s', GtSQLVlStr($this->mdlchck_est, "int"));
				}

				if(!isN($upd_f)){

					$updateSQL = sprintf("UPDATE ".$this->bd.TB_MDL_CNT_CHCK." SET ".implode(',', $upd_f)." WHERE id_mdlcntchck=%s",
		                                 GtSQLVlStr($this->gt_id_mdlcntchck, "int"));


					$Result = $__cnx->_prc($updateSQL);

					if($Result){
						$rsp['e'] = 'ok';
						$rsp['m'] = 1;
					}else{
						$rsp['m'] = 2;
						$rsp['w'] = $__cnx->c_p->error;
						$rsp['w_n'] = $__cnx->c_p->errno;
					}
				}

			}

			return _jEnc($rsp);

		}

		public function MdlCntChck_Chk($p=NULL){

			global $__cnx;

			if( !isN($this->mdlchck_chck) && !isN($this->mdlchck_mdlcnt) ){

				$Vl['e'] = 'no';

				$query_DtRg = sprintf('SELECT *
									   FROM '.$this->bd.TB_MDL_CNT_CHCK.'
									   WHERE mdlcntchck_sisslc = %s AND mdlcntchck_mdlcnt = %s
									   LIMIT 1', GtSQLVlStr($this->mdlchck_chck,'int'), GtSQLVlStr($this->mdlchck_mdlcnt,'int'));

				$DtRg = $__cnx->_qry($query_DtRg);

				if($DtRg){

					$row_DtRg = $DtRg->fetch_assoc();
					$Tot_DtRg = $DtRg->num_rows;

					$Vl['tot'] = $Tot_DtRg;

					if($Tot_DtRg > 0){
						$Vl['e'] = 'ok';
						$Vl['id'] = $this->gt_id_mdlcntchck = $row_DtRg['id_mdlcntchck'];
						$Vl['enc'] = ctjTx($row_DtRg['mdlcntchck_enc'],'in').$icn;
						$Vl['est'] = mBln($row_DtRg['mdlcntchck_est']);
					}
				}

				$__cnx->_clsr($DtRg);

			}

			return(_jEnc($Vl));
		}


		public function MdlCntEst_Upd($p=NULL){

			global $__cnx;

			if(!isN($this->mdlchck_chck) && !isN($this->mdlchck_est)){

				$updateSQL = sprintf("UPDATE ".TB_MDL_CNT." SET mdlcnt_est = %s WHERE mdlcnt_enc=%s",
				 						GtSQLVlStr($this->mdlchck_est, "int"),
	                                	GtSQLVlStr($this->mdlchck_chck, "text"));

				$Result = $__cnx->_prc($updateSQL);

				if($Result){
					$rsp['e'] = 'ok';
					$rsp['m'] = 1;

					$rsp['est'] = SisCntEst([ 'id'=>$this->mdlchck_est ]);

					//$_Crm_Aud->In_Aud([ 'aud'=>_Cns('ID_AUDDSC_TRA_MOD_NM'), "db"=>TB_MDL_CNT, "post"=>$__TraIn->post, "icn"=>"tra_mod"]);
				}else{
					$rsp['m'] = 2;
					$rsp['w'] = $__cnx->c_p->error;
					$rsp['w_n'] = $__cnx->c_p->errno;
				}

			}

			return _jEnc($rsp);

		}

		public function ActTp_Ls($p=NULL){

		    global $__cnx;

			$Vl['e'] = 'no';

			$_mdlstp_dt = GtMdlSTpDt(['tp'=>$this->mdls_tp]);

		    if(!isN($this->mdls_act)){

				$query_DtRg = "SELECT
									*,(
										SELECT
											COUNT(*)
										FROM
											".TB_ACT_ACT_TP."
										INNER JOIN "._BdStr(DBM).TB_ACT." ON id_act = actacttp_act
										WHERE
											id_mdl = actacttp_acttp
										AND act_enc = '".$this->mdls_act."'
									) AS __est
									FROM
										".TB_MDL."
								INNER JOIN "._BdStr(DBM).TB_MDL_S." ON id_mdls = mdl_mdls
								INNER JOIN "._BdStr(DBM).TB_MDL_S_TP." ON id_mdlstp = mdls_tp
								WHERE
									mdlstp_tp = 'act' AND mdl_mdlstp = $_mdlstp_dt->id ORDER BY __est DESC";

				$DtRg = $__cnx->_qry($query_DtRg);

				if($DtRg){

					$row_DtRg = $DtRg->fetch_assoc();
					$Tot_DtRg = $DtRg->num_rows;
					$Vl['tot'] = $Tot_DtRg;

					if($Tot_DtRg > 0){

						$Vl['e'] = 'ok';

						do{
							$Vl['ls'][$row_DtRg['mdl_enc']]['enc'] = $row_DtRg['mdl_enc'];
							$Vl['ls'][$row_DtRg['mdl_enc']]['nm'] = ctjTx($row_DtRg['mdl_nm'],'in');
							$Vl['ls'][$row_DtRg['mdl_enc']]['est'] = $row_DtRg['__est'];;
						}while($row_DtRg = $DtRg->fetch_assoc());
					}

				}else{

					$Vl['w'] = $this->c_r->error;

				}

				$__cnx->_clsr($DtRg);

			}

			return _jEnc($Vl);
		}

		public function ActTp($p=NULL){

			$Vl['e'] = 'no';
			$__chk = $this->ActTp_Chk();

			if(isN($__chk->id)){
				$__in = $this->ActTp_In();
				if($__in->e == 'ok'){ $Vl['e'] = 'ok'; }
			}elseif(!isN($__in) || !isN($__chk->id)){
				$__upd = $this->ActTp_Del();
				$Vl['_upd']=$__upd;
				if($__upd->e == 'ok'){ $Vl['upd']='ok'; $Vl['e']='ok'; }else{ $Vl['e']='no'; }
			}

			return(_jEnc($Vl));
		}

		public function ActTp_Chk($p=NULL){

			global $__cnx;

			if( !isN($this->mdls_act) && !isN($this->mdls_acttp) ){

				$Vl['e'] = 'no';

				$query_DtRg = sprintf("SELECT * FROM ".TB_ACT_ACT_TP."
									   WHERE actacttp_acttp = (SELECT id_mdl FROM ".TB_MDL." WHERE mdl_enc = %s) AND
									   actacttp_act = (SELECT id_act FROM "._BdStr(DBM).TB_ACT." WHERE act_enc = %s)
									   LIMIT 1", GtSQLVlStr($this->mdls_acttp,'text'), GtSQLVlStr($this->mdls_act,'text'));

				$DtRg = $__cnx->_qry($query_DtRg);

				if($DtRg){
					$row_DtRg = $DtRg->fetch_assoc();
					$Tot_DtRg = $DtRg->num_rows;

					$Vl['tot'] = $Tot_DtRg;

					if($Tot_DtRg > 0){
						$Vl['e'] = 'ok';
						$Vl['id'] = $this->gt_id_mdlsch =$row_DtRg['id_actacttp'];
						$Vl['enc'] = ctjTx($row_DtRg['actacttp_enc'],'in');
					}
				}
				$__cnx->_clsr($DtRg);

			}

			return(_jEnc($Vl));
		}

		public function ActTp_In($p=NULL){

			global $__cnx;

			$__enc = Enc_Rnd($this->mdls_acttp.'-'.$this->mdls_act);

			$query_DtRg =   sprintf("INSERT INTO ".TB_ACT_ACT_TP." (actacttp_enc, actacttp_act, actacttp_acttp)
						VALUES (%s,(SELECT id_act FROM "._BdStr(DBM).TB_ACT." WHERE act_enc = %s),
						(SELECT id_mdl FROM ".TB_MDL." WHERE mdl_enc = %s))",
							GtSQLVlStr($__enc, "text"),
							GtSQLVlStr($this->mdls_act, "text"),
							GtSQLVlStr($this->mdls_acttp, "text"));

			$Result = $__cnx->_prc($query_DtRg);

			if($Result){
				$rsp['i'] = $this->gt_id_mdlsch = $__cnx->c_p->insert_id;
				$rsp['e'] = 'ok';
				$rsp['m'] = 1;
			}else{
				$rsp['e'] = 'no';
				$rsp['m'] = 2;
				$rsp['w'] = $__cnx->c_p->error;
				$rsp['w_n'] = $__cnx->c_p->errno;
			}

			return _jEnc($rsp);

		}

		public function ActTp_Del($p=NULL){

			global $__cnx;

			$query_DtRg = sprintf("DELETE FROM ".TB_ACT_ACT_TP."  WHERE
									actacttp_act = (SELECT id_act FROM "._BdStr(DBM).TB_ACT." WHERE act_enc = %s) AND
									actacttp_acttp = (SELECT id_mdl FROM ".TB_MDL." WHERE mdl_enc = %s)",

									GtSQLVlStr($this->mdls_act, "text"),
									GtSQLVlStr($this->mdls_acttp, "text")
								);


			$Result = $__cnx->_prc($query_DtRg);

			if($Result){

				$rsp['e'] = 'ok';
				$rsp['m'] = 1;

			}else{
				$rsp['e'] = 'no';
				$rsp['m'] = 2;
				$rsp['w'] = $__cnx->c_p->error.' <-> '.$query_DtRg;
				$rsp['w_n'] = $__cnx->c_p->errno;

			}

			return _jEnc($rsp);

		}

		public function MdlAct_Ls($p=NULL){

		    global $__cnx;

		    $Vl['e'] = 'no';

		    if(!isN($this->mdls_act)){

				$query_DtRg = "SELECT
									*,(
										SELECT
											COUNT(*)
										FROM
											".TB_MDL_ACT."
										INNER JOIN "._BdStr(DBM).TB_ACT." ON id_act = mdlact_act
										WHERE
											id_mdl = mdlact_mdl
										AND act_enc = '".$this->mdls_act."'
									) AS __est
								FROM
									".TB_MDL."
								INNER JOIN "._BdStr(DBM).TB_MDL_S." ON id_mdls = mdl_mdls
								INNER JOIN "._BdStr(DBM).TB_MDL_S_TP." ON id_mdlstp = mdls_tp
								WHERE
									mdlstp_tp = '".$this->mdls_tp."'
								ORDER BY
									__est DESC";

				$DtRg = $__cnx->_qry($query_DtRg);
				//$Vl['qry'] = $query_DtRg;

				if($DtRg){

					$row_DtRg = $DtRg->fetch_assoc();
					$Tot_DtRg = $DtRg->num_rows;
					$Vl['tot'] = $Tot_DtRg;

					if($Tot_DtRg > 0){

						$Vl['e'] = 'ok';

						do{
							$Vl['ls'][$row_DtRg['mdl_enc']]['enc'] = $row_DtRg['mdl_enc'];
							$Vl['ls'][$row_DtRg['mdl_enc']]['nm'] = ctjTx($row_DtRg['mdl_nm'],'in');
							$Vl['ls'][$row_DtRg['mdl_enc']]['est'] = $row_DtRg['__est'];;
						}while($row_DtRg = $DtRg->fetch_assoc());
					}

				}else{

					$Vl['w'] = $this->c_r->error;

				}

				$__cnx->_clsr($DtRg);

			}

			return _jEnc($Vl);
		}

		public function MdlAct($p=NULL){

			$Vl['e'] = 'no';
			$__chk = $this->MdlAct_Chk();

			if(isN($__chk->id)){
				$__in = $this->MdlAct_In();
				if($__in->e == 'ok'){ $Vl['e'] = 'ok'; }
			}elseif(!isN($__in) || !isN($__chk->id)){
				$__upd = $this->MdlAct_Del();
				$Vl['_upd']=$__upd;
				if($__upd->e == 'ok'){ $Vl['upd']='ok'; $Vl['e']='ok'; }else{ $Vl['e']='no'; }
			}

			return(_jEnc($Vl));
		}

		public function MdlAct_Chk($p=NULL){

			global $__cnx;

			if( !isN($this->mdls_act) && !isN($this->mdls_mdl) ){

				$Vl['e'] = 'no';

				$query_DtRg = sprintf("SELECT *
									   FROM ".TB_MDL_ACT."
									   WHERE mdlact_act = (SELECT id_act FROM "._BdStr(DBM).TB_ACT." WHERE act_enc = %s) AND
									   mdlact_mdl = (SELECT id_mdl FROM ".TB_MDL." WHERE mdl_enc = %s)
									   LIMIT 1", GtSQLVlStr($this->mdls_act,'text'), GtSQLVlStr($this->mdls_mdl,'text'));

				$DtRg = $__cnx->_qry($query_DtRg);

				if($DtRg){
					$row_DtRg = $DtRg->fetch_assoc();
					$Tot_DtRg = $DtRg->num_rows;

					$Vl['tot'] = $Tot_DtRg;

					if($Tot_DtRg > 0){
						$Vl['e'] = 'ok';
						$Vl['id'] = $row_DtRg['id_mdlact'];
						$Vl['enc'] = ctjTx($row_DtRg['mdlact_enc'],'in');
					}
				}
				$__cnx->_clsr($DtRg);

			}

			return(_jEnc($Vl));
		}

		public function MdlAct_In($p=NULL){

			global $__cnx;

			$__enc = Enc_Rnd($this->mdls_mdl.'-'.$this->mdls_act);

			$query_DtRg =   sprintf("INSERT INTO ".TB_MDL_ACT." (mdlact_enc, mdlact_act, mdlact_mdl)
						VALUES (%s,(SELECT id_act FROM "._BdStr(DBM).TB_ACT." WHERE act_enc = %s),
						(SELECT id_mdl FROM ".TB_MDL." WHERE mdl_enc = %s))",
							GtSQLVlStr($__enc, "text"),
							GtSQLVlStr($this->mdls_act, "text"),
							GtSQLVlStr($this->mdls_mdl, "text"));

			$Result = $__cnx->_prc($query_DtRg);

			if($Result){
				$rsp['i'] = $__cnx->c_p->insert_id;
				$rsp['e'] = 'ok';
				$rsp['m'] = 1;
			}else{
				$rsp['e'] = 'no';
				$rsp['m'] = 2;
				$rsp['w'] = $__cnx->c_p->error;
				$rsp['w_n'] = $__cnx->c_p->errno;
			}

			return _jEnc($rsp);

		}

		public function MdlAct_Del($p=NULL){

			global $__cnx;

			$query_DtRg = sprintf("DELETE FROM ".TB_MDL_ACT."  WHERE
									mdlact_act = (SELECT id_act FROM "._BdStr(DBM).TB_ACT." WHERE act_enc = %s) AND
									mdlact_mdl = (SELECT id_mdl FROM ".TB_MDL." WHERE mdl_enc = %s)",

									GtSQLVlStr($this->mdls_act, "text"),
									GtSQLVlStr($this->mdls_mdl, "text")
								);


			$Result = $__cnx->_prc($query_DtRg);

			if($Result){

				$rsp['e'] = 'ok';
				$rsp['m'] = 1;

			}else{
				$rsp['e'] = 'no';
				$rsp['m'] = 2;
				$rsp['w'] = $__cnx->c_p->error.' <-> '.$query_DtRg;
				$rsp['w_n'] = $__cnx->c_p->errno;

			}

			return _jEnc($rsp);

		}

		public function ActGrd_Ls($p=NULL){

		    global $__cnx;

		    $Vl['e'] = 'no';

		    if(!isN($this->mdls_act)){

				$query_DtRg = "SELECT
									*,(
										SELECT
											COUNT(*)
										FROM
											"._BdStr(DBM).TB_ACT_GRD."
											INNER JOIN "._BdStr(DBM).TB_ACT." ON id_act = actgrd_act
										WHERE
											id_sisslc = actgrd_grd
										AND act_enc = '".$this->mdls_act."'
									) AS __est
								FROM
									"._BdStr(DBM).TB_SIS_SLC."
									INNER JOIN "._BdStr(DBM).TB_SIS_SLC_TP." ON sisslc_tp = id_sisslctp
								WHERE
									sisslctp_key = 'crs_o_smst'
								ORDER BY
									__est DESC, id_sisslc DESC";

				$DtRg = $__cnx->_qry($query_DtRg);

				//$Vl['qry'] = $query_DtRg;

				if($DtRg){

					$row_DtRg = $DtRg->fetch_assoc();
					$Tot_DtRg = $DtRg->num_rows;
					$Vl['tot'] = $Tot_DtRg;

					if($Tot_DtRg > 0){

						$Vl['e'] = 'ok';

						do{
							$Vl['ls'][$row_DtRg['sisslc_enc']]['enc'] = $row_DtRg['sisslc_enc'];
							$Vl['ls'][$row_DtRg['sisslc_enc']]['nm'] = ctjTx($row_DtRg['sisslc_tt'],'in');
							$Vl['ls'][$row_DtRg['sisslc_enc']]['est'] = $row_DtRg['__est'];;
						}while($row_DtRg = $DtRg->fetch_assoc());
					}

				}else{

					$Vl['w'] = $this->c_r->error;

				}

				$__cnx->_clsr($DtRg);

			}

			return _jEnc($Vl);
		}

		public function ActGrd($p=NULL){

			$Vl['e'] = 'no';
			$__chk = $this->ActGrd_Chk();
			$Vl['sse'] = $__chk;
			if(isN($__chk->id)){
				$__in = $this->ActGrd_In();
				if($__in->e == 'ok'){ $Vl['e'] = 'ok'; }
			}elseif(!isN($__in) || !isN($__chk->id)){
				$__upd = $this->ActGrd_Del();
				$Vl['_upd']=$__upd;
				if($__upd->e == 'ok'){ $Vl['upd']='ok'; $Vl['e']='ok'; }else{ $Vl['e']='no'; }
			}

			return(_jEnc($Vl));
		}

		public function ActGrd_Chk($p=NULL){

			global $__cnx;

			if( !isN($this->mdls_act) && !isN($this->mdls_mdl) ){

				$Vl['e'] = 'no';

				$query_DtRg = sprintf("SELECT * FROM "._BdStr(DBM).TB_ACT_GRD."
										WHERE actgrd_act = (SELECT id_act FROM "._BdStr(DBM).TB_ACT." WHERE act_enc = %s) AND
									  			  actgrd_grd = (SELECT id_sisslc FROM "._BdStr(DBM).TB_SIS_SLC." WHERE sisslc_enc = %s)
									   LIMIT 1", GtSQLVlStr($this->mdls_act,'text'), GtSQLVlStr($this->mdls_mdl,'text'));

				$DtRg = $__cnx->_qry($query_DtRg);

				if($DtRg){
					$row_DtRg = $DtRg->fetch_assoc();
					$Tot_DtRg = $DtRg->num_rows;

					$Vl['tot'] = $Tot_DtRg;

					if($Tot_DtRg > 0){
						$Vl['e'] = 'ok';
						$Vl['id'] = $row_DtRg['id_actgrd'];
						$Vl['enc'] = ctjTx($row_DtRg['actgrd_enc'],'in');
					}
				}
				$__cnx->_clsr($DtRg);

			}

			return(_jEnc($Vl));
		}

		public function ActGrd_In($p=NULL){

			global $__cnx;

			$__enc = Enc_Rnd($this->mdls_mdl.'-'.$this->mdls_act);

			$query_DtRg =   sprintf("INSERT INTO "._BdStr(DBM).TB_ACT_GRD." (actgrd_enc, actgrd_act, actgrd_grd)
										VALUES (%s,(SELECT id_act FROM "._BdStr(DBM).TB_ACT." WHERE act_enc = %s),
										(SELECT id_sisslc FROM "._BdStr(DBM).TB_SIS_SLC." WHERE sisslc_enc = %s))",
							GtSQLVlStr($__enc, "text"),
							GtSQLVlStr($this->mdls_act, "text"),
							GtSQLVlStr($this->mdls_mdl, "text"));

			$Result = $__cnx->_prc($query_DtRg);

			if($Result){
				$rsp['i'] = $__cnx->c_p->insert_id;
				$rsp['e'] = 'ok';
				$rsp['m'] = 1;
			}else{
				$rsp['e'] = 'no';
				$rsp['m'] = 2;
				$rsp['w'] = $__cnx->c_p->error;
				$rsp['w_n'] = $__cnx->c_p->errno;
			}

			return _jEnc($rsp);

		}

		public function ActGrd_Del($p=NULL){

			global $__cnx;

			$query_DtRg = sprintf("DELETE FROM "._BdStr(DBM).TB_ACT_GRD." WHERE
									actgrd_act = (SELECT id_act FROM "._BdStr(DBM).TB_ACT." WHERE act_enc = %s) AND
									actgrd_grd = (SELECT id_sisslc FROM "._BdStr(DBM).TB_SIS_SLC." WHERE sisslc_enc = %s)",

									GtSQLVlStr($this->mdls_act, "text"),
									GtSQLVlStr($this->mdls_mdl, "text")
								);


			$Result = $__cnx->_prc($query_DtRg);

			if($Result){

				$rsp['e'] = 'ok';
				$rsp['m'] = 1;

			}else{
				$rsp['e'] = 'no';
				$rsp['m'] = 2;
				$rsp['w'] = $__cnx->c_p->error.' <-> '.$query_DtRg;
				$rsp['w_n'] = $__cnx->c_p->errno;

			}

			return _jEnc($rsp);

		}


		// ------ Relacion Actividad General Grado ---- //

		public function ActGenGrd_Ls($p=NULL){

		    global $__cnx;

		    $Vl['e'] = 'no';

		    if(!isN($this->mdls_mdl)){

				$query_DtRg = "SELECT
									*,(
										SELECT
											COUNT(*)
										FROM
											".TB_MDL_GEN_GRD."
											INNER JOIN ".TB_MDL_GEN." ON id_mdlgen = mdlgengrd_mdlgen
										WHERE
											id_sisslc = mdlgengrd_grd
										AND mdlgen_enc = '".$this->mdls_mdl."'
									) AS __est
								FROM
									"._BdStr(DBM).TB_SIS_SLC."
									INNER JOIN "._BdStr(DBM).TB_SIS_SLC_TP." ON sisslc_tp = id_sisslctp
								WHERE
									sisslctp_key = 'crs_o_smst'
								ORDER BY
									__est DESC, id_sisslc DESC";

				$DtRg = $__cnx->_qry($query_DtRg);

				//$Vl['qry'] = $query_DtRg;

				if($DtRg){

					$row_DtRg = $DtRg->fetch_assoc();
					$Tot_DtRg = $DtRg->num_rows;
					$Vl['tot'] = $Tot_DtRg;

					if($Tot_DtRg > 0){

						$Vl['e'] = 'ok';

						do{
							$Vl['ls'][$row_DtRg['sisslc_enc']]['enc'] = $row_DtRg['sisslc_enc'];
							$Vl['ls'][$row_DtRg['sisslc_enc']]['nm'] = ctjTx($row_DtRg['sisslc_tt'],'in');
							$Vl['ls'][$row_DtRg['sisslc_enc']]['est'] = $row_DtRg['__est'];;
						}while($row_DtRg = $DtRg->fetch_assoc());
					}

				}else{

					$Vl['w'] = $this->c_r->error;

				}

				$__cnx->_clsr($DtRg);

			}

			return _jEnc($Vl);
		}

		public function ActGenGrd($p=NULL){

			$Vl['e'] = 'no';
			$__chk = $this->ActGenGrd_Chk();
			$Vl['sse'] = $__chk;
			if(isN($__chk->id)){
				$__in = $this->ActGenGrd_In();
				if($__in->e == 'ok'){ $Vl['e'] = 'ok'; }
			}elseif(!isN($__in) || !isN($__chk->id)){
				$__upd = $this->ActGenGrd_Del();
				$Vl['_upd']=$__upd;
				if($__upd->e == 'ok'){ $Vl['upd']='ok'; $Vl['e']='ok'; }else{ $Vl['e']='no'; }
			}

			return(_jEnc($Vl));
		}

		public function ActGenGrd_Chk($p=NULL){

			global $__cnx;

			if( !isN($this->mdls_mdl) && !isN($this->mdls_grd) ){

				$Vl['e'] = 'no';

				$query_DtRg = sprintf("SELECT * FROM ".TB_MDL_GEN_GRD."
										WHERE mdlgengrd_mdlgen = (SELECT id_mdlgen FROM ".TB_MDL_GEN." WHERE mdlgen_enc = %s) AND
									  			  mdlgengrd_grd = (SELECT id_sisslc FROM "._BdStr(DBM).TB_SIS_SLC." WHERE sisslc_enc = %s)
									   LIMIT 1", GtSQLVlStr($this->mdls_mdl,'text'), GtSQLVlStr($this->mdls_grd,'text'));

				$DtRg = $__cnx->_qry($query_DtRg);

				if($DtRg){
					$row_DtRg = $DtRg->fetch_assoc();
					$Tot_DtRg = $DtRg->num_rows;

					$Vl['tot'] = $Tot_DtRg;

					if($Tot_DtRg > 0){
						$Vl['e'] = 'ok';
						$Vl['id'] = $row_DtRg['id_mdlgengrd'];
						$Vl['enc'] = ctjTx($row_DtRg['mdlgengrd_enc'],'in');
					}
				}
				$__cnx->_clsr($DtRg);

			}

			return(_jEnc($Vl));
		}

		public function ActGenGrd_In($p=NULL){

			global $__cnx;

			$__enc = Enc_Rnd($this->mdls_mdl.'-'.$this->mdls_grd);

			$query_DtRg =   sprintf("INSERT INTO ".TB_MDL_GEN_GRD." (mdlgengrd_enc, mdlgengrd_mdlgen, mdlgengrd_grd)
										VALUES (%s,(SELECT id_mdlgen FROM ".TB_MDL_GEN." WHERE mdlgen_enc = %s),
										(SELECT id_sisslc FROM "._BdStr(DBM).TB_SIS_SLC." WHERE sisslc_enc = %s))",
							GtSQLVlStr($__enc, "text"),
							GtSQLVlStr($this->mdls_mdl, "text"),
							GtSQLVlStr($this->mdls_grd, "text"));

			$Result = $__cnx->_prc($query_DtRg);

			if($Result){
				$rsp['i'] = $__cnx->c_p->insert_id;
				$rsp['e'] = 'ok';
				$rsp['m'] = 1;
			}else{
				$rsp['e'] = 'no';
				$rsp['m'] = 2;
				$rsp['w'] = $__cnx->c_p->error;
				$rsp['w_n'] = $__cnx->c_p->errno;
			}

			return _jEnc($rsp);

		}

		public function ActGenGrd_Del($p=NULL){

			global $__cnx;

			$query_DtRg = sprintf("DELETE FROM _mdl_gen_grd WHERE
									mdlgengrd_mdlgen = (SELECT id_mdlgen FROM ".TB_MDL_GEN." WHERE mdlgen_enc = %s) AND
									mdlgengrd_grd = (SELECT id_sisslc FROM "._BdStr(DBM).TB_SIS_SLC." WHERE sisslc_enc = %s)",

									GtSQLVlStr($this->mdls_mdl, "text"),
									GtSQLVlStr($this->mdls_grd, "text")
								);


			$Result = $__cnx->_prc($query_DtRg);

			if($Result){

				$rsp['e'] = 'ok';
				$rsp['m'] = 1;

			}else{
				$rsp['e'] = 'no';
				$rsp['m'] = 2;
				$rsp['w'] = $__cnx->c_p->error.' <-> '.$query_DtRg;
				$rsp['w_n'] = $__cnx->c_p->errno;

			}

			return _jEnc($rsp);

		}

		// ------ Listado de campos formulario - incluir / excluir -------- //

		public function MdlSTpFmExc_Ls($p=NULL){

		    global $__cnx;

		    $Vl['e'] = 'no';

		    if(!isN($this->tp)){

				$query_DtRg = "SELECT
									*
								FROM
										"._BdStr(DBM).TB_SIS_SLC."
									LEFT JOIN "._BdStr(DBM)."_mdl_s_tp_fm_row_fld_exc ON mdlstpfmrowfldexc_sisslc = id_sisslc
									AND mdlstpfmrowfldexc_fld IN (
										SELECT id_mdlstpfmrowfld
											FROM "._BdStr(DBM)."_mdl_s_tp_fm_row_fld
										WHERE mdlstpfmrowfld_enc = '$this->fld' )
								WHERE
									sisslc_tp = $this->tp
								ORDER BY sisslc_tt ASC";

				$DtRg = $__cnx->_qry($query_DtRg);

				$Vl['qry'] = $query_DtRg;

				if($DtRg){

					$row_DtRg = $DtRg->fetch_assoc();
					$Tot_DtRg = $DtRg->num_rows;
					$Vl['tot'] = $Tot_DtRg;

					if($Tot_DtRg > 0){

						$Vl['e'] = 'ok';

						do{
							$Vl['ls'][$row_DtRg['sisslc_enc']]['enc'] = $row_DtRg['mdlstpfmrowfldexc_enc'];
							$Vl['ls'][$row_DtRg['sisslc_enc']]['id'] = $row_DtRg['id_mdlstpfmrowfldexc'];
							$Vl['ls'][$row_DtRg['sisslc_enc']]['nm'] = ctjTx($row_DtRg['sisslc_tt'],'in');
							$Vl['ls'][$row_DtRg['sisslc_enc']]['sis_enc'] = $row_DtRg['sisslc_enc'];
							$Vl['ls'][$row_DtRg['sisslc_enc']]['exc'] = ctjTx($row_DtRg['mdlstpfmrowfldexc_exc'],'in');
							$Vl['ls'][$row_DtRg['sisslc_enc']]['inc'] = ctjTx($row_DtRg['mdlstpfmrowfldexc_inc'],'in');

						}while($row_DtRg = $DtRg->fetch_assoc());
					}

				}else{

					$Vl['w'] = $this->c_r->error;

				}

				$__cnx->_clsr($DtRg);

			}

			return _jEnc($Vl);
		}

		public function MdlSTpFmExc($p=NULL){
			$Vl['e'] = 'no';

			$__chk = $this->MdlSTpFmExc_Chk();

			$Vl['sse'] = $__chk;

			if(isN($__chk->id)){
				$__in = $this->MdlSTpFmExc_In();
				$Vl['_in']= $__in;
				if($__in->e == 'ok'){ $Vl['e'] = 'ok'; }
			}elseif(!isN($__in) || !isN($__chk->id)){
				$__upd = $this->MdlSTpFmExc_Upd();
				$Vl['_upd']= $__upd;
				if($__upd->e == 'ok'){ $Vl['upd']='ok'; $Vl['e']='ok'; }else{ $Vl['e']='no'; }
			}

			return(_jEnc($Vl));
		}

		public function MdlSTpFmExc_Chk($p=NULL){

			global $__cnx;

			if( !isN($this->c_enc) && !isN($this->c_tp) ){

				$Vl['e'] = 'no';

				$query_DtRg = sprintf("SELECT * FROM "._BdStr(DBM)."_mdl_s_tp_fm_row_fld_exc
										WHERE mdlstpfmrowfldexc_enc = %s AND
												mdlstpfmrowfldexc_fld = (SELECT id_mdlstpfmrowfld FROM "._BdStr(DBM).TB_MDL_S_TP_FM_ROW_FLD." WHERE mdlstpfmrowfld_enc = %s) AND
												mdlstpfmrowfldexc_sisslc = (SELECT id_sisslc FROM "._BdStr(DBM).TB_SIS_SLC." WHERE sisslc_enc = %s)
									   LIMIT 1",

									   GtSQLVlStr($this->c_id, 'text'),
									   GtSQLVlStr($this->fld,'text'),
									   GtSQLVlStr($this->c_enc,'text'));

				$DtRg = $__cnx->_qry($query_DtRg);

				if($DtRg){
					$row_DtRg = $DtRg->fetch_assoc();
					$Tot_DtRg = $DtRg->num_rows;

					$Vl['tot'] = $Tot_DtRg;

					if($Tot_DtRg > 0){
						$Vl['e'] = 'ok';
						$Vl['id'] = $row_DtRg['id_mdlstpfmrowfldexc'];
						$Vl['enc'] = ctjTx($row_DtRg['mdlstpfmrowfldexc_enc'],'in');
					}
				}
				$__cnx->_clsr($DtRg);

			}

			return(_jEnc($Vl));
		}

		public function MdlSTpFmExc_In($p=NULL){

			global $__cnx;

			$inc = '2'; $exc = '2';

			if( $this->c_tp == 'inc' ){
				if( $this->c_est == 'no'){
					$inc = '1';
				}
			}elseif( $this->c_tp == 'exc' ) {
				if( $this->c_est == 'no'){
					$exc = '1';
				}
			}

			$__enc = Enc_Rnd($this->fld.'-'.$this->tp);

			$query_DtRg =   sprintf("INSERT INTO "._BdStr(DBM)."_mdl_s_tp_fm_row_fld_exc (
												mdlstpfmrowfldexc_enc, mdlstpfmrowfldexc_fld, mdlstpfmrowfldexc_sisslc,
												mdlstpfmrowfldexc_inc, mdlstpfmrowfldexc_exc)

										VALUES (%s,
												(SELECT id_mdlstpfmrowfld FROM "._BdStr(DBM)."_mdl_s_tp_fm_row_fld WHERE mdlstpfmrowfld_enc = %s),
												(SELECT id_sisslc FROM "._BdStr(DBM).TB_SIS_SLC." WHERE sisslc_enc = %s),
												%s, %s)",
							GtSQLVlStr($__enc, "text"),
							GtSQLVlStr($this->fld, "text"),
							GtSQLVlStr($this->c_enc, "text"),
							GtSQLVlStr($inc, "text"),
							GtSQLVlStr($exc, "text"));

			$Result = $__cnx->_prc($query_DtRg);

			if($Result){
				$rsp['i'] = $__cnx->c_p->insert_id;
				$rsp['e'] = 'ok';
				$rsp['m'] = 1;
			}else{
				$rsp['e'] = 'no';
				$rsp['m'] = 2;
				$rsp['w'] = $__cnx->c_p->error;
				$rsp['w_n'] = $__cnx->c_p->errno;
			}

			return _jEnc($rsp);

		}

		public function MdlSTpFmExc_Upd($p=NULL){

			global $__cnx;

			$rsp['e'] = 'no';

			$inc = '2'; $exc = '2';

			if( $this->c_tp == 'inc' ){
				if( $this->c_est == 'ok'){
					$inc = '2';
				}else{
					$inc = '1';
				}
			}elseif( $this->c_tp == 'exc' ) {
				if( $this->c_est == 'ok'){
					$exc = '2';
				}else{
					$exc = '1';
				}
			}

			$updateSQL = sprintf("UPDATE "._BdStr(DBM)."_mdl_s_tp_fm_row_fld_exc SET mdlstpfmrowfldexc_inc = %s, mdlstpfmrowfldexc_exc = %s
										WHERE mdlstpfmrowfldexc_enc = %s",
									GtSQLVlStr($inc, "int"),
									GtSQLVlStr($exc, "int"),
									GtSQLVlStr($this->c_id, "text"));

			$Result = $__cnx->_prc($updateSQL);

			if($Result){
				$rsp['e'] = 'ok';
				$rsp['m'] = 1;
			}else{
				$rsp['m'] = 2;
				$rsp['w'] = $__cnx->c_p->error;
				$rsp['w_n'] = $__cnx->c_p->errno;
			}

			return _jEnc($rsp);

		}

		// ------  Relacion colegio Actividad --------//

		public function OrgAct_Ls($p=NULL){

		    global $__cnx;

		    $Vl['e'] = 'no';

		    if(!isN($this->id_act)){

				$query_DtRg = '
								SELECT *
									FROM '._BdStr(DBM).TB_ORG.'
										 INNER JOIN '._BdStr(DBM).TB_ORG_SDS.' ON orgsds_org = id_org
										 INNER JOIN '._BdStr(DBM).TB_SIS_CD.' ON orgsds_cd = id_siscd
										 INNER JOIN '._BdStr(DBM).TB_SIS_CD_DP.' ON siscd_dp = id_siscddp
										 INNER JOIN '._BdStr(DBM).TB_SIS_PS.' ON siscddp_ps = id_sisps
										 INNER JOIN '._BdStr(DBM).TB_ORG_SDS_ACT.' ON orgsdsact_orgsds = id_orgsds
									WHERE orgsdsact_act IN (
											SELECT id_act
											FROM '._BdStr(DBM).TB_ACT.'
											WHERE act_enc="'.$this->id_act.'"
							)';

				$LsRg = $__cnx->_qry($query_DtRg);

				if($LsRg){

					$rsp['e'] = 'ok';

					$row_LsRg = $LsRg->fetch_assoc();
					$Tot_LsRg = $LsRg->num_rows;

					$rsp['tot'] = $Tot_LsRg;

					if($Tot_LsRg > 0){

						do {



							$rsp['tp'] = 'on';

							$_nm_prfx = '';
							$_nm_sfx = '';

							if(!isN($row_LsRg['orgsds_nm']) && $row_LsRg['orgsds_nm'] != TX_PC){ $_nm_sfx = ' - '.ctjTx($row_LsRg['orgsds_nm'], 'in'); }

							$rsp['ls'][$row_LsRg['orgsds_enc']] = [
											'id'=>$row_LsRg['orgsds_enc'],
											'nm'=>$_nm_prfx.ctjTx($row_LsRg['org_nm'],'in').$_nm_sfx,
											'img'=>_ImVrs(['img'=>$row_LsRg['org_img'], 'f'=>DMN_FLE_ORG ]),
											'cd'=>[
												'tt'=>ctjTx($row_LsRg['siscd_tt'],'in')
											]
										];



						} while ($row_LsRg = $LsRg->fetch_assoc());


					}

				}

				$__cnx->_clsr($LsRg);

			}

			return _jEnc($rsp);
		}

		public function OrgAct($p=NULL){

			$Vl['e'] = 'no';
			$__chk = $this->OrgAct_Chk();
			if(isN($__chk->id)){
				$__in = $this->OrgAct_In();
				if($__in->e == 'ok'){ $Vl['e'] = 'ok'; }
			}elseif(!isN($__in) || !isN($__chk->id)){
				$__upd = $this->OrgAct_Del();
				$Vl['_upd']=$__upd;
				if($__upd->e == 'ok'){ $Vl['upd']='ok'; $Vl['e']='ok'; }else{ $Vl['e']='no'; }
			}

			return(_jEnc($Vl));
		}

		public function OrgAct_Chk($p=NULL){

			global $__cnx;

			if( !isN($this->id_org) && !isN($this->id_act) ){

				$Vl['e'] = 'no';

				$query_DtRg = sprintf("SELECT *
									   FROM "._BdStr(DBM).TB_ORG_SDS_ACT."
									   WHERE orgsdsact_orgsds = (SELECT id_orgsds FROM "._BdStr(DBM).TB_ORG_SDS." WHERE orgsds_enc = %s) AND
									   		 orgsdsact_act = (SELECT id_act FROM "._BdStr(DBM).TB_ACT." WHERE act_enc = %s)
									   LIMIT 1", GtSQLVlStr($this->id_org,'text'), GtSQLVlStr($this->id_act,'text'));

				$DtRg = $__cnx->_qry($query_DtRg);

				if($DtRg){
					$row_DtRg = $DtRg->fetch_assoc();
					$Tot_DtRg = $DtRg->num_rows;

					$Vl['tot'] = $Tot_DtRg;

					if($Tot_DtRg > 0){
						$Vl['e'] = 'ok';
						$Vl['id'] = $row_DtRg['orgsdsact_act'];
						$Vl['enc'] = ctjTx($row_DtRg['orgsdsact_enc'],'in');
					}
				}
				$__cnx->_clsr($DtRg);
			}

			return(_jEnc($Vl));
		}

		public function OrgAct_In($p=NULL){

			global $__cnx;

			$__enc = Enc_Rnd($this->id_org.'-'.$this->id_act);

			$query_DtRg =   sprintf("INSERT INTO "._BdStr(DBM).TB_ORG_SDS_ACT." (orgsdsact_enc, orgsdsact_act, orgsdsact_orgsds)
						VALUES (%s,(SELECT id_act FROM "._BdStr(DBM).TB_ACT." WHERE act_enc = %s),
						(SELECT id_orgsds FROM "._BdStr(DBM).TB_ORG_SDS." WHERE orgsds_enc = %s))",
							GtSQLVlStr($__enc, "text"),
							GtSQLVlStr($this->id_act, "text"),
							GtSQLVlStr($this->id_org, "text"));

			$Result = $__cnx->_prc($query_DtRg);

			if($Result){
				$rsp['i'] = $__cnx->c_p->insert_id;
				$rsp['e'] = 'ok';
				$rsp['m'] = 1;
			}else{
				$rsp['e'] = 'no';
				$rsp['m'] = 2;
				$rsp['w'] = $__cnx->c_p->error;
				$rsp['w_n'] = $__cnx->c_p->errno;
			}

			return _jEnc($rsp);

		}

		public function OrgAct_Del($p=NULL){

			global $__cnx;

			$query_DtRg = sprintf("DELETE FROM "._BdStr(DBM).TB_ORG_SDS_ACT."  WHERE
									orgsdsact_orgsds = (SELECT id_orgsds FROM "._BdStr(DBM).TB_ORG_SDS." WHERE orgsds_enc = %s) AND
									orgsdsact_act = (SELECT id_act FROM "._BdStr(DBM).TB_ACT." WHERE act_enc = %s)",

									GtSQLVlStr($this->id_org, "text"),
									GtSQLVlStr($this->id_act, "text")
								);


			$Result = $__cnx->_prc($query_DtRg);

			if($Result){

				$rsp['e'] = 'ok';
				$rsp['m'] = 1;

			}else{
				$rsp['e'] = 'no';
				$rsp['m'] = 2;
				$rsp['w'] = $__cnx->c_p->error.' <-> '.$query_DtRg;
				$rsp['w_n'] = $__cnx->c_p->errno;

			}

			return _jEnc($rsp);

		}

		// ------  Fin Relacion colegio Actividad --------//
		public function ActClgSds_Ls($p=NULL){

		    global $__cnx;

		    $Vl['e'] = 'no';

		    if(!isN($this->mdls_clg)){

				$query_DtRg = 'SELECT
									*
								FROM
									'.DBM.'.'.TB_ORG_SDS.'
								INNER JOIN '.DBM.'.'.TB_ORG.' ON orgsds_org = id_org
								WHERE
									org_enc = "'.$this->mdls_clg.'" ';

				$DtRg = $__cnx->_qry($query_DtRg);

				if($DtRg){

					$row_DtRg = $DtRg->fetch_assoc();
					$Tot_DtRg = $DtRg->num_rows;
					$Vl['tot'] = $Tot_DtRg;

					if($Tot_DtRg > 0){

						$Vl['e'] = 'ok';

						do{
							$Vl['ls'][$row_DtRg['orgsds_enc']]['enc'] = $row_DtRg['orgsds_enc'];
							$Vl['ls'][$row_DtRg['orgsds_enc']]['nm'] = ctjTx($row_DtRg['orgsds_nm'],'in');
							$Vl['ls'][$row_DtRg['orgsds_enc']]['est'] = $row_DtRg['orgsds_cd'];;
						}while($row_DtRg = $DtRg->fetch_assoc());
					}

				}else{

					$Vl['w'] = $this->c_r->error;

				}

				$__cnx->_clsr($DtRg);

			}

			return _jEnc($Vl);
		}

		function MdlSTp_Tra(){

			$Vl['e'] = 'no';

			$__chk = $this->MdlSTpTra_Chk();

			$Vl['chk'] = $__chk;

			if(isN($__chk->id)){
				$__in = $this->MdlSTpTra_In();
				$Vl['in'] = $__in;
				if($__in->e == 'ok'){ $Vl['e'] = 'ok'; }
			}
			if(!isN($__in) || !isN($__chk->id)){
				$__upd = $this->MdlSTpTra_Upd();
				$Vl['updh'] = $__upd;
				if($__upd->e == 'ok'){ $Vl['upd']='ok'; $Vl['e']='ok'; }else{ $Vl['e']='no'; }
			}

			return(_jEnc($Vl));

		}

		function MdlSTpTra_Chk(){
			global $__cnx;

			if( !isN($this->id)){

				$Vl['e'] = 'no';

				$query_DtRg = sprintf('SELECT id_mdlstptra, mdlstptra_enc
											FROM '._BdStr(DBM).TB_MDL_S_TP_TRA.'
										INNER JOIN '._BdStr(DBM).TB_CL.' ON mdlstptra_cl = id_cl
										INNER JOIN '._BdStr(DBM).TB_MDL_S_TP.' ON mdlstptra_mdlstp = id_mdlstp
									   WHERE cl_enc = %s AND mdlstp_enc = %s
									   LIMIT 1',

									   GtSQLVlStr(DB_CL_ENC,'text'),
									   GtSQLVlStr($this->id,'text')
								);

				$DtRg = $__cnx->_qry($query_DtRg);

				if($DtRg){

					$row_DtRg = $DtRg->fetch_assoc();
					$Tot_DtRg = $DtRg->num_rows;

					$Vl['tot'] = $Tot_DtRg;

					if($Tot_DtRg > 0){
						$Vl['e'] = 'ok';
						$Vl['id'] = $this->gt_id_mdlprd =$row_DtRg['id_mdlstptra'];
						$Vl['enc'] = ctjTx($row_DtRg['mdlstptra_enc'],'in');
					}
				}

				$__cnx->_clsr($DtRg);

			}


			return(_jEnc($Vl));
		}

		public function MdlSTpTra_In($p=NULL){

			global $__cnx;

			$__enc = Enc_Rnd($this->id.'-'.DB_CL_ENC);

			$query_DtRg = sprintf("INSERT INTO "._BdStr(DBM).TB_MDL_S_TP_TRA."
							(mdlstptra_enc, mdlstptra_cl, mdlstptra_mdlstp, mdlstptra_us, mdlstptra_col, mdlstptra_tt_dft) VALUES
							(%s,
								(SELECT id_cl FROM "._BdStr(DBM).TB_CL." WHERE cl_enc = %s),
								(SELECT id_mdlstp FROM "._BdStr(DBM).TB_MDL_S_TP." WHERE mdlstp_enc = %s),
							%s, %s, %s)",
							GtSQLVlStr($__enc, "text"),
							GtSQLVlStr(DB_CL_ENC, "text"),
							GtSQLVlStr($this->id, "text"),
							GtSQLVlStr($this->pst['mdlstptra_us'], "int"),
							GtSQLVlStr($this->pst['mdlstptra_col'], "int"),
							GtSQLVlStr($this->pst['mdlstptra_tt_dft'], "text"));

			$Result = $__cnx->_prc($query_DtRg);

			if($Result){
				$rsp['e'] = 'ok';
				$rsp['m'] = 1;
			}else{
				$rsp['e'] = 'no';
				$rsp['esss'] = $query_DtRg;
				$rsp['m'] = 2;
				$rsp['w'] = $__cnx->c_p->error;
				$rsp['w_n'] = $__cnx->c_p->errno;
			}

			return _jEnc($rsp);

		}

		public function MdlSTpTra_Upd($p=NULL){

			global $__cnx;

			$rsp['e'] = 'no';

			$updateSQL = sprintf("UPDATE "._BdStr(DBM).TB_MDL_S_TP_TRA." SET mdlstptra_us=%s, mdlstptra_col=%s, mdlstptra_tt_dft=%s WHERE mdlstptra_enc=%s",
									GtSQLVlStr($this->pst['mdlstptra_us'], "int"),
									GtSQLVlStr($this->pst['mdlstptra_col'], "int"),
									GtSQLVlStr($this->pst['mdlstptra_tt_dft'], "text"),
									GtSQLVlStr($this->pst['mdlstptra_enc'], "text"));

			$Result = $__cnx->_prc($updateSQL);

			$rsp['es'] = $updateSQL;

			if($Result){
				$rsp['e'] = 'ok';
				$rsp['m'] = 1;
			}else{
				$rsp['es'] = $query_DtRg;
				$rsp['m'] = 2;
				$rsp['w'] = $__cnx->c_p->error;
				$rsp['w_n'] = $__cnx->c_p->errno;
			}

			return _jEnc($rsp);

		}

		public function GtMdlSTpFmPs_Ls($p=NULL){

			global $__cnx;

			$Vl['e'] = 'no';

			if(!isN($this->mdlstpfmps_mdlstpfm)){

				$query_DtRg = "
						SELECT id_sisps, sisps_tt, sisps_enc,
							(	SELECT COUNT(*)
									FROM "._BdStr(DBM).TB_MDL_S_TP_FM_PS." AS _sub
									WHERE 	id_sisps = _sub.mdlstpfmps_ps AND
											_sub.mdlstpfmps_mdlstpfm = '".$this->mdlstpfmps_mdlstpfm."'
							) AS tot
						 FROM "._BdStr(DBM).TB_SIS_PS."
							ORDER BY tot DESC, sisps_tt ASC";

				$DtRg = $__cnx->_qry($query_DtRg);

				if($DtRg){

					$row_DtRg = $DtRg->fetch_assoc();
					$Tot_DtRg = $DtRg->num_rows;
					$Vl['tot'] = $Tot_DtRg;

					if($Tot_DtRg > 0){

						$Vl['e'] = 'ok';

						do{

							$Vl['ls'][$row_DtRg['sisps_enc']]['id'] = $row_DtRg['id_sisps'];
							$Vl['ls'][$row_DtRg['sisps_enc']]['enc'] = $row_DtRg['sisps_enc'];
							$Vl['ls'][$row_DtRg['sisps_enc']]['nm'] = ctjTx($row_DtRg['sisps_tt'],'out');
							$Vl['ls'][$row_DtRg['sisps_enc']]['tot'] = $row_DtRg['tot'];

						}while($row_DtRg = $DtRg->fetch_assoc());

					}

				}
				$__cnx->_clsr($DtRg);

			}

			return _jEnc($Vl);
		}

		public function GtMdlSTpFmPs($p=NULL){

			$Vl['e'] = 'no';
			$__chk = $this->GtMdlSTpFmPs_Chk();
			$Vl['chk'] = $__chk;

			if(isN($__chk->id)){
				$__in = $this->GtMdlSTpFmPs_In();
				if($__in->e == 'ok'){ $Vl['e'] = 'ok'; }else{ $Vl['w'] = $__in->w; $Vl['q'] = $__in->q; }
			}

			if(!isN($__chk->id)){
				$__upd = $this->GtMdlSTpFmPs_Del();
				if($__upd->e == 'ok'){ $Vl['upd']='ok'; $Vl['e']='ok'; }else{ $Vl['e']='no'; }
			}

			return(_jEnc($Vl));
		}

		public function GtMdlSTpFmPs_Chk($p=NULL){

			global $__cnx;

			if( !isN($this->mdlstpfmps_mdlstpfm) && !isN($this->mdlstpfmps_ps)){

				$Vl['e'] = 'no';

				$query_DtRg = sprintf('SELECT id_mdlstpfmps, mdlstpfmps_enc
											   FROM '._BdStr(DBM).TB_MDL_S_TP_FM_PS.'
										WHERE mdlstpfmps_mdlstpfm=%s AND mdlstpfmps_ps=%s
										LIMIT 1',
											GtSQLVlStr($this->mdlstpfmps_mdlstpfm,'text'),
											GtSQLVlStr($this->mdlstpfmps_ps,'text'));

				$DtRg = $__cnx->_qry($query_DtRg);

				if($DtRg){
					$row_DtRg = $DtRg->fetch_assoc();
					$Tot_DtRg = $DtRg->num_rows;

					$Vl['tot'] = $Tot_DtRg;

					if($Tot_DtRg > 0){
						$Vl['e'] = 'ok';
						$Vl['id'] = $row_DtRg['id_mdlstpfmps'];
						$Vl['enc'] = ctjTx($row_DtRg['mdlstpfmps_enc'],'in');
					}
				}
				$__cnx->_clsr($DtRg);

			}

			return(_jEnc($Vl));
		}

		public function GtMdlSTpFmPs_In($p=NULL){

			global $__cnx;

			$rsp['e'] = 'no';

			if(!isN($this->mdlstpfmps_mdlstpfm) && !isN($this->mdlstpfmps_ps)){

				$__enc = Enc_Rnd( $this->mdlstpfmps_mdlstpfm.'-'.$this->mdlstpfmps_ps);

				$query_DtRg = sprintf("INSERT INTO "._BdStr(DBM).TB_MDL_S_TP_FM_PS." (mdlstpfmps_enc, mdlstpfmps_mdlstpfm, mdlstpfmps_ps) VALUES (%s,%s,%s)",
								GtSQLVlStr($__enc, "text"),
								GtSQLVlStr($this->mdlstpfmps_mdlstpfm, "text"),
								GtSQLVlStr($this->mdlstpfmps_ps, "text"));

				$Result = $__cnx->_prc($query_DtRg);

				if($Result){
					$rsp['i'] = $__cnx->c_p->insert_id;
					$rsp['e'] = 'ok';
					$rsp['m'] = 1;
				}else{
					$rsp['m'] = 2;
					$rsp['q'] = compress_code( $query_DtRg );
					$rsp['w'] = $__cnx->c_p->error;
					$rsp['w_n'] = $__cnx->c_p->errno;
				}

			}

			return _jEnc($rsp);
		}

		public function GtMdlSTpFmPs_Del($p=NULL){

			global $__cnx;

			$rsp['e'] = 'no';

			if(!isN($this->mdlstpfmps_mdlstpfm) && !isN($this->mdlstpfmps_ps)){

				$query_DtRg = sprintf("DELETE FROM "._BdStr(DBM).TB_MDL_S_TP_FM_PS." WHERE mdlstpfmps_mdlstpfm=%s AND mdlstpfmps_ps=%s",
											GtSQLVlStr($this->mdlstpfmps_mdlstpfm, "text"),
											GtSQLVlStr($this->mdlstpfmps_ps, "text"));

				$Result = $__cnx->_prc($query_DtRg);

				if($Result){
					$rsp['e'] = 'ok';
					$rsp['m'] = 1;
				}else{
					$rsp['m'] = 2;
					$rsp['w'] = $__cnx->c_p->error;
					$rsp['w_n'] = $__cnx->c_p->errno;
				}

			}

			return _jEnc($rsp);

		}


		function bld_json(){

			$__org_tp = __LsDt([ 'k'=>'org_tp', 'cl'=>$this->cl->id ]);
			echo $this->_auto->li( 'Get data on __LsDt for key org_tp' );

			$__dc_tp = __LsDt([ 'k'=>'cnt_dc', 'cl'=>$this->cl->id ]);
			echo $this->_auto->li( 'Get data on __LsDt for key cnt_dc' );

			$__crs_o_smst = __LsDt([ 'k'=>'crs_o_smst', 'cl'=>$this->cl->id ]);
			echo $this->_auto->li( 'Get data on __LsDt for key crs_o_smst' );

			$__cnt_tp = GtClCntTpLs([ 'cl'=>$this->cl->id ]);
			echo $this->_auto->li( 'Get data on GtClCntTpLs' );

			$__cl_sds = GtClSdsLs([ 'cl'=>$this->cl->id ]);
			echo $this->_auto->li( 'Get data on GtClSdsLs' );

			$__mdld = __LsDt([ 'k'=>'mdld', 'cl'=>$this->cl->id ]);
			echo $this->_auto->li( 'Get data on __LsDt for key mdld' );

			if($this->cl->enc != $__Forms->gt_cl->enc){
				$__Forms = new CRM_Forms([ 'bd'=>$this->bd, 'cl'=>$this->cl->enc ]);
				echo $this->_auto->li( 'Get data on Forms' );
			}else{
				echo $this->_auto->li( 'Use same data on Forms' );
			}

			$__Forms->_fields()->hdn;
			echo $this->_auto->li( 'Get hidden fields' );

			//----------- Common Data for Basic Module or General - Start -----------//

				$r['data']['account']['name'] = $this->cl->nm;
				$r['data']['account']['prfl'] = $this->cl->prfl;
				$r['data']['account']['tags']['color']['main'] = !isN($this->cl->tag->clr->main->v)?$this->cl->tag->clr->main->v:'#4f006f';
				$r['data']['account']['tags']['color']['second'] = !isN($this->cl->tag->clr->second->v)?$this->cl->tag->clr->main->v:'#de86d4';

				if(!isN($__org_tp->ls->org_tp)){
					$r['data']['form']['ext']['org']['tp'] = $__org_tp->ls->org_tp;
				}

				if(!isN($__dc_tp->ls->cnt_dc)){
					$r['data']['form']['ext']['dc']['tp'] = $__dc_tp->ls->cnt_dc;
				}

				if(!isN($__crs_o_smst->ls->crs_o_smst)){
					$r['data']['form']['ext']['crsosmst'] = $__crs_o_smst->ls->crs_o_smst;
				}

				$r['data']['form']['ext']['cnt']['tp'] = $__cnt_tp->ls;
				$r['data']['form']['ext']['cl']['sds'] = $__cl_sds->ls;
				$r['data']['form']['ext']['mdl']['mdld'] = $__mdld->ls;
				$r['data']['form']['hdn'] = $__Forms->_fields()->hdn_f;

				echo $this->_auto->li( 'Execute _fields()->hdn_f ' );

			//----------- Common Data for Basic Module or General - End -----------//

			if(!isN($this->id_mdl)){

				$_data_mdl = $this->_mdl_d = GtMdlDt([ 'bd'=>$this->bd, 'id'=>$this->id_mdl, 'sbd'=>$this->cl->sbd ]);
				echo $this->_auto->li( 'Get GtMdlDt data' );


				if(!isN( $this->_mdl_d->id )){

					$__Forms->cnscnv = 'ok';
					$__Forms->mdlfm_mdl = $this->id_mdl;
					$__Forms->mdlfm_lst = 'ok';
					$__mdlfm_dt = $__Forms->_mdlfm_dt([ 'fldt'=>'ok' ]);

					$_data_mdl->tp->fm = $__mdlfm_dt;
					echo $this->_auto->li( 'Execute $__Forms->_mdlfm_dt' );

					$__hro = GtMdlSchLs([ 'bd'=>$this->bd, 'id'=>$this->_mdl_d->id ]);
					echo $this->_auto->li( 'Get GtMdlSchLs data' );

					$r['e'] = 'ok';
					$r['data']['id'] = $this->_mdl_d->enc;
					$r['data']['cid'] = $this->_mdl_d->id;
					$r['data']['name'] = $this->_mdl_d->tt;
					$r['data']['permalink'] = $this->_mdl_d->pml;
					$r['data']['url'] = $this->_mdl_d->url;

					if($__hro->tot > 0){
						$r['data']['modules']['schedule'] = $__hro;
					}else{
						if(Dvlpr()){
							$r['data']['modules']['schedule_Tmp'] = $__hro;
						}
					}

					//$r['data']['cl'] = compress_code($this->_mdl_d->cl);
				}

			}else if(!isN($this->id_mdlgen)){

				$__Forms->mdlfm_mdl = NULL;
				$__Forms->mdlfm_lst = NULL;
				$_data_mdl = $this->_mdl_gen_d = GtMdlGenDt([ 'bd'=>$this->bd, 'id'=>$this->id_mdlgen, 'sbd'=>$this->cl->sbd, 'shw_mdl'=>'ok', 'cnscnv'=>'ok' ]);
				echo $this->_auto->li( 'Get GtMdlGenDt data' );

				if(!isN( $this->_mdl_gen_d->id )){

					$__Forms->cnscnv = 'ok';
					$__Forms->mdlfmgen_mdlgen = $this->_mdl_gen_d->id;
					$__Forms->mdlfmgen_lst = 'ok';
					$__fm_dt = $__Forms->_mdlfm_dt([ 'fldt'=>'ok' ]);

					$_data_mdl->tp->fm = $__fm_dt;
					echo $this->_auto->li( 'Execute $__Forms->_mdlfm_dt' );

					$r['e'] = 'ok';
					$r['data']['id'] = $this->_mdl_gen_d->enc;
					$r['data']['cid'] = $this->_mdl_gen_d->id;
					$r['data']['name'] = $this->_mdl_gen_d->tt;
					$r['data']['permalink'] = $this->_mdl_gen_d->pml;
					$r['data']['url'] = $this->_mdl_gen_d->url;
					$r['data']['modules'] = $this->_mdl_gen_d->mdl;

				}

			}


			//----------- Common Data for Forms - Start -----------//

				if(!isN($_data_mdl)){

					if($_data_mdl->tp->fm->shw->mdltp == 'ok'){
						$__mdlstp = GtMdlSTpLs([ 'cl'=>$this->cl->id ]);
						echo $this->_auto->li( 'Get GtMdlSTpLs data' );
						if($__mdlstp->tot > 0){
							foreach($__mdlstp->ls as $__mdlstp_k=>$__mdlstp_v){
								$r['data']['modules']->type->ls->{$__mdlstp_v->enc}['id'] = $__mdlstp_v->enc;
								$r['data']['modules']->type->ls->{$__mdlstp_v->enc}['name'] = $__mdlstp_v->nm;
							}
						}
					}

					if($_data_mdl->tp->fm->shw->mdl_s_prd == 'ok'){
						$__mdlsprd = GtMdlSPrdLs([ 'cl'=>$this->cl->id, 'tp'=>$_data_mdl->tp->id ]);
						echo $this->_auto->li( 'Get GtMdlSPrdLs data' );
						if($__mdlsprd->tot > 0){
							foreach($__mdlsprd->ls as $__mdlsprd_k=>$__mdlsprd_v){
								$r['data']['modules']->period->ls->{$__mdlsprd_v->enc}['id'] = $__mdlsprd_v->enc;
								$r['data']['modules']->period->ls->{$__mdlsprd_v->enc}['name'] = $__mdlsprd_v->nm;
							}
						}
					}

					if(!isN($_data_mdl->s->ph)){
						$r['data']['form']['ph'] = $_data_mdl->s->ph;
					}else{
						$r['data']['form']['ph'] = TX_FMSLC.' '._cns('MDL_'.$_data_mdl->tp->key_upper);
					}

					$r['data']['form']['shw'] = $_data_mdl->tp->fm->shw;
					$r['data']['form']['e'] = $_data_mdl->tp->fm->e;

					if(!isN( $_data_mdl->tp->fm->plcy->enc )){
						$r['data']['form']['plcy']['id'] = $_data_mdl->tp->fm->plcy->enc;
						$r['data']['form']['plcy']['tx'] = $_data_mdl->tp->fm->plcy->tx;
						$r['data']['form']['plcy']['lnk'] = $_data_mdl->tp->fm->plcy->lnk;
					}else{
						$__plcy = GtClPlcyDflt([ 'cl'=>$this->cl->id ]);
						echo $this->_auto->li( 'Get GtClPlcyDflt data' );
						$r['data']['form']['plcy']['id'] = $__plcy->enc;
						$r['data']['form']['plcy']['tx'] = $__plcy->tx;
						$r['data']['form']['plcy']['lnk'] = $__plcy->lnk;
					}

					//print_r($_data_mdl->tp->fm);

					$r['data']['form']['thx']['top'] = !isN($_data_mdl->tp->fm->thx->top)?$_data_mdl->tp->fm->thx->top:'no';
					$r['data']['form']['thx']['url'] = !isN($_data_mdl->tp->fm->thx->url)?$_data_mdl->tp->fm->thx->url:'';
					$r['data']['form']['thx']['tt'] = !isN($_data_mdl->tp->fm->thx->tt)?$_data_mdl->tp->fm->thx->tt:TX_SCSS;
					$r['data']['form']['thx']['sbt'] = !isN($_data_mdl->tp->fm->thx->sbt)?$_data_mdl->tp->fm->thx->sbt:TX_SCSS_MSJ;
					$r['data']['form']['thx']['dsc'] = !isN($_data_mdl->tp->fm->thx->dsc)?$_data_mdl->tp->fm->thx->dsc:'';

					$r['data']['form']['dft'] = !isN($_data_mdl->tp->fm->dft)?$_data_mdl->tp->fm->dft:'';
					$r['data']['form']['clr'] = !isN($_data_mdl->tp->fm->dft)?$_data_mdl->tp->fm->clr:'';

					if(!isN($_data_mdl->tp->fm->cstm) && !isN($_data_mdl->tp->fm->cstm->font)){
						$r['data']['form']['thm']['font-family'] = $_data_mdl->tp->fm->cstm->font;
					}elseif(!isN($_data_mdl->tp->fm->thm->attr->{'font-family'}->vl)){
						$r['data']['form']['thm']['font-family'] = $_data_mdl->tp->fm->thm->attr->{'font-family'}->vl;
					}else{
						$r['data']['form']['thm']['font-family'] = "['Economica:400,700','Roboto:400,300,100,500:latin']";
					}

					$r['data']['form']['css'] = !isN($_data_mdl->tp->fm->cstm->css)?$_data_mdl->tp->fm->cstm->css:'';

					if(!isN($_data_mdl->tp->fm->thm) && $_data_mdl->tp->fm->thm->attr->key->vl != 'bsc'){
						$r['data']['form']['thm']['name'] = $_data_mdl->tp->fm->thm->attr->key->vl;
					}

					$r['data']['form']['row'] = $_data_mdl->tp->fm->row;

					$__mdl_ls_a['bd'] = $this->bd;


					if(!isN($this->id_mdl)){

						$__mdl_ls_a['mdlm'] = $this->_mdl_d->id;

						$_ls_mdl_rel = GtMdlMdlLs($__mdl_ls_a);
						echo $this->_auto->li( 'Get GtMdlMdlLs data' );

					}else if(!isN($this->id_mdlgen)){

						$__mdl_ls_a['tp'] = $this->_mdl_gen_d->tp->act->ls->ids;
						$__mdl_ls_a['all'] = $this->_mdl_gen_d->all;

						if($_data_mdl->tp->fm->shw->mdl_s_tp == 'ok'){
							if($_data_mdl->tp->fm->shw->mdl_all != 'ok'){
								$__mdl_ls_a['gen'] = $this->_mdl_gen_d->id;
							}
						}else{
							$__mdl_ls_a['gen'] = $this->_mdl_gen_d->id;
						}

						//$r['data']['tmp____mdlsa'] = $__mdl_ls_a;

						$_ls_mdl_rel = GtMdlGenRelLs($__mdl_ls_a);
						echo $this->_auto->li( 'Get GtMdlGenRelLs data' );

						$__grd = GtActGenGrdLs([ 'bd'=>$this->bd, 'mdlgen'=>$this->_mdl_gen_d->enc ]);
						echo $this->_auto->li( 'Get GtActGenGrdLs data' );

						if(!isN($__grd->ls)){
							$r['data']['form']['ext']['grd'] = $__grd;
						}elseif(Dvlpr()){
							$r['data']['form']['ext']['grd'] = $__grd;
						}

					}

					if(!isN($_ls_mdl_rel)){

						if($_ls_mdl_rel->tot > 0){
							$r['data']['form']['ext']['rel']['tot'] = $_ls_mdl_rel->tot;
							$r['data']['form']['ext']['rel']['ls'] = $_ls_mdl_rel->ls;
						}elseif(Dvlpr()){
							$r['data']['form']['ext']['rel'] = $_ls_mdl_rel;
						}

					}

				}

			//----------- Common Data for Forms - End -----------//

			return _jEnc( $r );

		}

		function sve_json($p=NULL){

			if($p['t'] == 'mdl'){

				$__json = $this->bld_json([ 't'=>$p['t'] ]);

				if(!isN( $this->_mdl_d->id )){

					if(!isN($this->_mdl_d->enc)){

						$_json_lite_b = $__json->data;
						$_json_lite = cmpr_fm( json_encode( $_json_lite_b  ) );
						$_r['s']['json']['lte'] = $_sve_json = $this->_aws->_s3_put([ 'b'=>'js', 'fle'=>'mdl/'.$this->cl->sbd.'/'.$this->_mdl_d->enc.'.json', 'cbdy'=>$_json_lite, 'ctp'=>'application/json' ]);

						echo $this->_auto->li( 'Save mdl/'.$this->cl->sbd.'/'.$this->_mdl_d->enc.'.json' );


						$__json = $this->bld_json([ 't'=>$p['t'] ]);
						$_json_full = cmpr_fm( json_encode( $__json->data ) );
						$_r['s']['json']['fll'] = $_sve_json = $this->_aws->_s3_put([ 'b'=>'js', 'fle'=>'mdl/'.$this->cl->sbd.'/'.$this->_mdl_d->enc.'_full.json', 'cbdy'=>$_json_full, 'ctp'=>'application/json' ]);

						echo $this->_auto->li( 'Save mdl/'.$this->cl->sbd.'/'.$this->_mdl_d->enc.'_full.json' );
						//echo $this->_auto->li( compress_code(print_r($_sve_json,true)) );

						$_js_pth = dirname(__FILE__, 3).'/_js/sb/fm/main.js';

						if(!isN($_js_pth)){

							$_js = cmpr_js( file_get_contents( $_js_pth ), [ 'rnd'=>$this->_mdl_d->enc ] );

							if(!isN($_js)){

								$__usch = [ '[DOMAIN]', '[ID]', '[FMG]', '[ETAG]', '[SBD]', '[CKTRCK_FM]', '[PUG]', '[PSFX]' ];
								$__uchn = [ DMN_S, $this->_mdl_d->enc, 'no', E_TAG, $this->cl->sbd, CKTRCK_FM, '', '' ];
								$__js = str_replace($__usch, $__uchn, $_js);
								$_sve_js = $this->_aws->_s3_put([ 'b'=>'js', 'fle'=>'mdl/'.$this->cl->sbd.'/'.$this->_mdl_d->enc.'.js', 'cbdy'=>$__js ]);
								$_r['s']['js'] = $this->_aws->_cfr_clr([ 'b'=>'js', 'fle'=>'mdl/'.$this->cl->sbd.'/'.$this->_mdl_d->enc.'.js' ]);

							}

						}

						if($_sve_json->e == 'ok' && $_sve_js->e == 'ok'){
							$_r['e'] = 'ok';
						}
					}

				}else{
					$_r['w'][] = 'No data on mdl_d';
					$_r['w'][] = $this->_mdl_d;
				}

			}elseif($p['t'] == 'mdl_gen'){

				$__json = $this->bld_json([ 't'=>$p['t'] ]);

				if(!isN( $this->_mdl_gen_d->id )){

					if(!isN($this->_mdl_gen_d->enc)){

						$_json_lite_b = $__json->data;
						if(!isN($_json_lite_b->modules)){ unset($_json_lite_b->modules); }
						$_json_lite = cmpr_fm( json_encode( $_json_lite_b  ) );
						$_r['s']['json']['lte'] = $_sve_json = $this->_aws->_s3_put([ 'b'=>'js', 'fle'=>'mdl/'.$this->cl->sbd.'/g/'.$this->_mdl_gen_d->enc.'_lite.json', 'cbdy'=>$_json_lite, 'ctp'=>'application/json' ]);


						$__json = $this->bld_json([ 't'=>$p['t'] ]);
						$_json_full = cmpr_fm( json_encode( $__json->data ) );
						$_r['s']['json']['fll'] = $_sve_json = $this->_aws->_s3_put([ 'b'=>'js', 'fle'=>'mdl/'.$this->cl->sbd.'/g/'.$this->_mdl_gen_d->enc.'_full.json', 'cbdy'=>$_json_full, 'ctp'=>'application/json' ]);


						$_g='ok';
						$_js_pth = dirname(__FILE__, 3).'/_js/sb/fm/main.js';

						if(!isN($_js_pth)){

							$_js = cmpr_js( file_get_contents( $_js_pth ), [ 'rnd'=>$this->_mdl_d->enc ] );

							if(!isN($_js)){

								$__usch = [ '[DOMAIN]', '[ID]', '[FMG]', '[ETAG]', '[SBD]', '[CKTRCK_FM]', '[PUG]', '[PSFX]' ];
								$__uchn = [ DMN_S, $this->_mdl_gen_d->enc, 'ok', E_TAG, $this->cl->sbd, CKTRCK_FM, 'g/', '_lite' ];
								$__js = str_replace($__usch, $__uchn, $_js);
								$_sve_js = $this->_aws->_s3_put([ 'b'=>'js', 'fle'=>'mdl/'.$this->cl->sbd.'/g/'.$this->_mdl_gen_d->enc.'.js', 'cbdy'=>$__js ]);
								$_r['s']['js'] = $this->_aws->_cfr_clr([ 'b'=>'js', 'fle'=>'mdl/'.$this->cl->sbd.'/g/'.$this->_mdl_gen_d->enc.'.js' ]);

							}

						}

						if($_sve_json->e == 'ok' && $_sve_js->e == 'ok'){
							$_r['e'] = 'ok';
						}
					}

				}else{
					$_r['w'][] = 'No data on mdl_gen_d for '.$this->id_mdlgen;
					$_r['w'][] = $this->_mdl_gen_d;
				}

			}

			return _jEnc($_r);

		}

		public function GtMdlGrp($p=NULL){

			global $__cnx;

			$Vl['e'] = 'no';

			if(!isN($this->id_mdl)){

				$query_DtRg = "
						SELECT
							id_us, us_nm, us_ap, us_enc,
							"._QrySisSlcF([ 'als'=>'t', 'als_n'=>'type' ]).",
							".GtSlc_QryExtra([ 't'=>'fld', 'p'=>'type', 'als'=>'t' ])."
						FROM
							"._BdStr($this->cl).TB_MDL_GRP."
							INNER JOIN "._BdStr(DBM).TB_CL_GRP." ON mdlgrp_clgrp = id_clgrp
							INNER JOIN "._BdStr(DBM).TB_CL_GRP_US." ON clgrpus_clgrp = id_clgrp
							INNER JOIN "._BdStr(DBM).TB_US." ON clgrpus_us = id_us
							".GtSlc_QryExtra([ 't'=>'tb', 'col'=>'mdlgrp_tp', 'als'=>'t' ])."
						WHERE mdlgrp_mdl = '".$this->id_mdl."'
						ORDER BY us_ap ASC, us_nm ASC";

				$DtRg = $__cnx->_qry($query_DtRg);

				if($DtRg){

					$row_DtRg = $DtRg->fetch_assoc();
					$Tot_DtRg = $DtRg->num_rows;

					$Vl['tot'] = $Tot_DtRg;

					if($Tot_DtRg > 0){

						$Vl['e'] = 'ok';

						do{

							$__type = json_decode($row_DtRg['___type']);

							foreach($__type as $__tp_k=>$__tp_v){
								$__type_go[$__tp_v->key] = $__tp_v;
							}

							$__id = $row_DtRg['us_enc'];

							if(!isN( $__type_go['key']->vl )){
								$Vl['us'][$__type_go['key']->vl]['nm'] = ctjTx($row_DtRg['type_sisslc_tt'],'out');
								$Vl['us'][$__type_go['key']->vl]['id'] = $row_DtRg['type_id_sisslc'];
								$Vl['us'][$__type_go['key']->vl]['ls'][ $__id ]['id'] = $row_DtRg['id_us'];
								$Vl['us'][$__type_go['key']->vl]['ls'][ $__id ]['enc'] = $row_DtRg['us_enc'];
								$Vl['us'][$__type_go['key']->vl]['ls'][ $__id ]['nm'] = ctjTx($row_DtRg['us_nm'],'out').' '.ctjTx($row_DtRg['us_ap'],'out');
							}

						}while($row_DtRg = $DtRg->fetch_assoc());

					}

				}else{
					$Vl['w'] = $__cnx->c_r->error;
				}

				$__cnx->_clsr($DtRg);

			}

			return _jEnc($Vl);
		}

		public function GtMdlUs($p=NULL){

			global $__cnx;

			$Vl['e'] = 'no';

			if(!isN($this->id_mdl)){

				$query_DtRg = "
						SELECT
							id_us, us_nm, us_ap, us_enc,
							"._QrySisSlcF([ 'als'=>'t', 'als_n'=>'type' ]).",
							".GtSlc_QryExtra([ 't'=>'fld', 'p'=>'type', 'als'=>'t' ])."
						FROM
							"._BdStr($this->cl).TB_MDL_US."
							INNER JOIN "._BdStr(DBM).TB_US." ON mdlus_us = id_us
							".GtSlc_QryExtra([ 't'=>'tb', 'col'=>'mdlus_tp', 'als'=>'t' ])."
						WHERE mdlus_mdl = '".$this->id_mdl."'
						ORDER BY us_ap ASC, us_nm ASC";
				$DtRg = $__cnx->_qry($query_DtRg);

				if($DtRg){

					$row_DtRg = $DtRg->fetch_assoc();
					$Tot_DtRg = $DtRg->num_rows;

					$Vl['tot'] = $Tot_DtRg;

					if($Tot_DtRg > 0){

						$Vl['e'] = 'ok';

						do{

							$__type = json_decode($row_DtRg['___type']);

							foreach($__type as $__tp_k=>$__tp_v){
								$__type_go[$__tp_v->key] = $__tp_v;
							}

							$__id = $row_DtRg['us_enc'];

							if(!isN( $__type_go['key']->vl )){
								$Vl['us'][$__type_go['key']->vl]['nm'] = ctjTx($row_DtRg['type_sisslc_tt'],'out');
								$Vl['us'][$__type_go['key']->vl]['id'] = $row_DtRg['type_id_sisslc'];
								$Vl['us'][$__type_go['key']->vl]['ls'][ $__id ]['id'] = $row_DtRg['id_us'];
								$Vl['us'][$__type_go['key']->vl]['ls'][ $__id ]['enc'] = $row_DtRg['us_enc'];
								$Vl['us'][$__type_go['key']->vl]['ls'][ $__id ]['nm'] = ctjTx($row_DtRg['us_nm'],'out').' '.ctjTx($row_DtRg['us_ap'],'out');
							}

						}while($row_DtRg = $DtRg->fetch_assoc());

					}

				}else{

					$Vl['w'] = $__cnx->c_r->error;

				}

				$__cnx->_clsr($DtRg);

			}

			return _jEnc($Vl);
		}

		public function Chk_MdlCnt_Us($p=NULL){

			global $__cnx;

			if(!isN($p['mdlcnt']) && !isN($p['us']) && !isN($p['tp'])){

				$query_DtRg = sprintf('	SELECT id_mdlcntus, mdlcntus_enc
										FROM '._BdStr($this->cl).TB_MDL_CNT_US.'
										WHERE mdlcntus_mdlcnt=%s AND mdlcntus_us=%s AND mdlcntus_tp=%s',
										GtSQLVlStr($p['mdlcnt'],'int'),
										GtSQLVlStr($p['us'],'int'),
										GtSQLVlStr($p['tp'],'int')
								);

				$DtRg = $__cnx->_qry($query_DtRg);

				if($DtRg){

					$Vl['e'] = 'ok';
					$row_DtRg = $DtRg->fetch_assoc();
					$Tot_DtRg = $DtRg->num_rows;

					if($Tot_DtRg > 0){
						$Vl['id'] = $row_DtRg['id_mdlcntus'];
						$Vl['enc'] = ctjTx($row_DtRg['mdlcntus_enc'],'in');
					}

				}else{

					$Vl['w'][] = compress_code($query_DtRg).' '.$__cnx->c_r->error;

				}

				$__cnx->_clsr($DtRg);

			}else{

				$Vl['w'][] = 'No all data';

			}

			return(_jEnc($Vl));

		}

		public function In_MdlCnt_Us($p=NULL){

			global $__cnx;

			$rsp['e'] = 'no';

			$_fl_tp_us = 'enc';

			if(!isN($this->us)){
				if(is_numeric($this->us)){
					$_fl_tp_us = '';
					$_us->id = $this->us;
				}else{
					$__rsp_us = $this->us;
					$_us = GtUsDt($__rsp_us, $_fl_tp_us);
				}
			}else{
				$__rsp_us = SISUS_ENC;
				$_us = GtUsDt($__rsp_us, $_fl_tp_us);
			}

			if(!isN($this->us_asg)){ $_us_asg = $this->us_asg; }else{ $_us_asg = SISUS_ID; }

			if(!isN($_us->id) && !isN($this->mdlcnt) && !isN($this->tp)){

				$_chk = $this->Chk_MdlCnt_Us([ 'mdlcnt'=>$this->mdlcnt, 'us'=>$_us->id, 'tp'=>$this->tp ]);

				if($_chk->e == 'ok'){

					if(!isN($_chk->id)){

						$rsp['e'] = 'ok';
						$rsp['m'] = 1;
						$rsp['enc'] = $_chk->enc;


					}else{

						$_enc = Enc_Rnd($this->mdlcnt.''.$_us_asg);

						$query_DtRg =  sprintf("INSERT INTO "._BdStr($this->cl).TB_MDL_CNT_US." (mdlcntus_enc, mdlcntus_mdlcnt, mdlcntus_us_asg, mdlcntus_us, mdlcntus_tp) VALUES (%s, %s, %s, %s, %s)",
													GtSQLVlStr($_enc, "text"),
													GtSQLVlStr($this->mdlcnt, "int"),
													GtSQLVlStr($_us_asg, "int"),
													GtSQLVlStr($_us->id, "int"),
													GtSQLVlStr($this->tp, "int"));

						$Result = $__cnx->_prc($query_DtRg);

						if($Result){

							$rsp['e'] = 'ok';
							$rsp['m'] = 1;
							$rsp['enc'] = $_enc;
							$rsp['i'] = $__cnx->c_p->insert_id;

						}else{
							$rsp['e'] = 'no';
							$rsp['m'] = 2;
							$rsp['w'][] = $__cnx->c_p->error.'  '.$query_DtRg;
						}
					}

				}else{

					$rsp['w'][] = $_chk;

				}

			}else{

				$rsp['w'][] = 'No all data for process';
				if(isN($_us->id)){ $rsp['w'][] = 'No us id'; }

			}

			return _jEnc($rsp);
		}

		public function Del_MdlCnt_Us($p=NULL){

			global $__cnx;

			$rsp['e'] = 'no';

			if((!isN($p['mdl']) && !isN($p['us'])) || !isN($p['id']) ){

				if($this->us != ''){ $__rsp_us = $this->us; }else{ $__rsp_us = SISUS_ID; }

				if( !isN( $p['id'] ) ){
					$__fl .= sprintf(' id_mdlcntus=%s ', GtSQLVlStr($p['id'], "int"));
				}else if( !isN( $p['mdl'] ) && !isN( $p['us'] ) ){
					$__fl .= sprintf(" mdlcntus_mdlcnt=%s AND  mdlcntus_us=%s ", GtSQLVlStr($p['mdl'], "int"), GtSQLVlStr($p['us'], "int"));
				}

				if(!isN( $__fl )){

					$query_DtRg = sprintf("DELETE FROM "._BdStr($this->cl).TB_MDL_CNT_US." WHERE $__fl");
					$Result = $__cnx->_prc($query_DtRg);

					if($Result){
						$rsp['e'] = 'ok';
						$rsp['m'] = 1;
					}else{
						$rsp['e'] = 'no';
						$rsp['m'] = 2;
						$rsp['w'] = $__cnx->c_p->error.'  '.$query_DtRg;
					}

				}

			}else{

				$rsp['w'] = 'No all data';

			}

			return _jEnc($rsp);
		}

		public function ActClnd_Ls($p=NULL){

		    global $__cnx;

			$Vl['e'] = 'no';

			$_mdlstp_dt = GtMdlSTpDt(['tp'=>$this->tp]);

			$query_DtRg = "SELECT
								*,
								"._QrySisSlcF([ 'als'=>'e', 'als_n'=>'est', 'no_enc'=>'ok' ]).",
								".GtSlc_QryExtra(['t'=>'fld', 'p'=>'est', 'als'=>'e'])."
							FROM
								"._BdStr(DBM).TB_ACT."
								INNER JOIN "._BdStr(DBM).TB_ACT_TP." ON acttp_act = id_act
								INNER JOIN "._BdStr(DBM).TB_MDL_S_TP." ON acttp_mdlstp = id_mdlstp
								".GtSlc_QryExtra(['t'=>'tb', 'col'=>'act_est', 'als'=>'e'])."
							WHERE
								id_act != '' AND
								mdlstp_tp = '".$_mdlstp_dt->tp."' AND
								act_cl = '".DB_CL_ID."'
							ORDER BY id_act DESC";

				$DtRg = $__cnx->_qry($query_DtRg);

				if($DtRg){

					$row_DtRg = $DtRg->fetch_assoc();
					$Tot_DtRg = $DtRg->num_rows;
					$Vl['tot'] = $Tot_DtRg;

					if($Tot_DtRg > 0){

						$Vl['e'] = 'ok';

						do{
							$__act_attr_prop = [];
							$Vl['ls'][$row_DtRg['act_enc']]['id'] = $row_DtRg['id_act'];
							$Vl['ls'][$row_DtRg['act_enc']]['enc'] = $row_DtRg['act_enc'];
							$Vl['ls'][$row_DtRg['act_enc']]['nm'] = ctjTx($row_DtRg['act_tt'],'in');
							$Vl['ls'][$row_DtRg['act_enc']]['f_i'] = $row_DtRg['act_f_start'];
							$Vl['ls'][$row_DtRg['act_enc']]['f_f'] = $row_DtRg['act_f_end'];

							$__act_attr = GtSlcF_JAttr($row_DtRg['___est']);

							foreach($__act_attr as $__act_attr_k=>$__act_attr_v){
								$__act_attr_prop[$__act_attr_v->key] = $__act_attr_v;
							}

							$Vl['ls'][$row_DtRg['act_enc']]['attr'] = $__act_attr_prop;

						}while($row_DtRg = $DtRg->fetch_assoc());
					}

				}else{

					$Vl['w'] = $this->c_r->error;

				}

				$__cnx->_clsr($DtRg);


			return _jEnc($Vl);
		}


	}

?>