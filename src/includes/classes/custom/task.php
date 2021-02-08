<?php

// Arreglar todas las auditorias ->Camilo

class CRM_Tra extends CRM_Main{


    function __construct($p=NULL) {

        $this->_aud = new CRM_Aud();
		$this->_Ntf = new CRM_Ntf();
		$this->_ws = new CRM_Ws;


		if(!isN($p['cl'])){
			$this->cl = GtClDt($p['cl']);
			if(!isN($this->cl->bd)){ $this->bd = _BdStr($this->cl->bd); }else{ $this->bd = ''; }
		}elseif(defined('DB_CL') && !isN(DB_CL)){
			$this->bd = DB_CL;
		}
    }

	public function MdlCnt(){

		global $__cnx;

		$rsp['e'] = 'no';

		$__chk = $this->MdlCnt_Chk();

		if($__chk->e == 'ok'){

			if(!isN($__chk->id)){

				$rsp['e'] = 'ok';

			}else{

				if(!isN($this->mdlcnttra_mdlcnt) && !isN($this->mdlcnttra_tra)){

					$insertSQL_RLC = sprintf("INSERT INTO "._BdStr($this->bd).TB_MDL_CNT_TRA." (mdlcnttra_mdlcnt, mdlcnttra_tra) VALUES (%s,%s)",
											GtSQLVlStr($this->mdlcnttra_mdlcnt, "int"),
											GtSQLVlStr($this->mdlcnttra_tra, "int"));

					$Result_RLC = $__cnx->_prc($insertSQL_RLC);

					if($Result_RLC){
						$rsp['e'] = 'ok';
					}else{
						$rsp['w'] = $__cnx->c_p->error;
					}

				}else{

					$rsp['w'] = 'No all data for process';

				}

			}

		}

		return _jEnc($rsp);

	}


	public function MdlCnt_Chk($p=NULL){

		global $__cnx;

		$Vl['e'] = 'no';

		if( !isN($this->mdlcnttra_mdlcnt) && !isN($this->mdlcnttra_tra)){

			$query_DtRg = sprintf('	SELECT id_mdlcnttra
								   	FROM '._BdStr($this->bd).TB_MDL_CNT_TRA.'
									WHERE mdlcnttra_mdlcnt=%s AND mdlcnttra_tra=%s
								  	LIMIT 1',
										GtSQLVlStr($this->mdlcnttra_mdlcnt,'int'),
										GtSQLVlStr($this->mdlcnttra_tra,'int'));

			$DtRg = $__cnx->_prc($query_DtRg);

			if($DtRg){

				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;

				$Vl['e'] = 'ok';
				$Vl['tot'] = $Tot_DtRg;

				if($Tot_DtRg > 0){
					$Vl['id'] = $row_DtRg['id_mdlcnttra'];
				}

			}else{

				$Vl['w'][] = 'Error on:'.$__cnx->c_p->error;

			}

			$__cnx->_clsr($DtRg);

		}

		return(_jEnc($Vl));

	}


	public function In_Tra(){

		global $__cnx;

		if(!isN($this->tra_col)){ $__col = $this->tra_col; }else{ $__col = NULL; }
		if(!isN($this->tra_cl)){ $__cl = $this->tra_cl; }else{ $__cl = DB_CL_ID; }

		$this->tra_enc = $__enc = Enc_Rnd(SISUS_ID.'-'.ctjTx( $this->tra_tt ,'out').'-'.ctjTx($this->tra_dsc,'out'));
		if(!isN($this->invk->by)){ $_invk = $this->invk->by; }else{ $_invk = _CId('ID_SISINVK_ND'); }

		$insertSQL = sprintf("INSERT INTO "._BdStr(DBM).TB_TRA." (tra_enc, tra_cl, tra_us, tra_tt, tra_dsc,tra_tp, tra_est, tra_col, tra_sbrnd, tra_chk_rsp, tra_f, tra_h, tra_invk, tra_fi) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
						GtSQLVlStr($__enc , "text"),
						GtSQLVlStr($__cl, "int"),
						GtSQLVlStr(SISUS_ID, "int"),
						GtSQLVlStr(strip_tags(ctjTx( $this->tra_tt ,'out') ), "text"),
						GtSQLVlStr(ctjTx($this->tra_dsc,'out'), "text"),
						GtSQLVlStr(($this->tra_tp!=NULL?$this->tra_tp:'1'), "int"),
						GtSQLVlStr(($this->tra_est!=NULL?$this->tra_est:_CId('ID_TRAEST_PRC')), "int"),
						GtSQLVlStr($__col, "int"),
						GtSQLVlStr($this->tra_sbrnd, "int"),
						GtSQLVlStr(2, "int"),
						GtSQLVlStr($this->tra_f, "date"),
						GtSQLVlStr($this->tra_h, "date"),
						GtSQLVlStr($_invk, "int"),
						GtSQLVlStr(SIS_F_TS, "date"));

		$Result = $__cnx->_prc($insertSQL);

 		if($Result){

			$this->id_tra = $rsp['i'] = $__cnx->c_p->insert_id;
			$this->tra__new = $rsp['i'];

			$rsp['e'] = 'ok';
			$rsp['m'] = 1;
			$rsp['t'] = $__t;
			$rsp['enc'] = $__enc;

			$this->_aud->In_Aud([ "aud"=>"419", "db"=>$this->db, "post"=>$this->post, "icn"=>"tra_add", "iddb"=>$rsp['i'] ]);

			$this->Tra_Ord_His([ "id"=>$rsp['i'], "ord"=>$this->tra_ord, "k"=>"_tra", "tp"=>"1" ]);
			$this->mdlcnttra_tra = $rsp['i'];

			if(!isN($this->mdlcnttra_mdlcnt)){

				$rsp['wm'][] = 'Lets process mdlcnt';

				$_mdlcntin = $this->MdlCnt();

				if($_mdlcntin->e != 'ok'){
					$rsp['e'] = 'no';
					$rsp['w'][] = 'Problem on save match tra and mdlcnt';
					$rsp['w'][] = $_mdlcntin->w;
				}else{
					$rsp['mdlcnt'] = $_mdlcntin;
				}

			}else{
				$rsp['wm'][] = '$this->mdlcnttra_mdlcnt empty';
			}

			$this->enc = $__enc;
			$this->trarsp_tp = _CId('ID_USROL_RSP');

			/* <---- Agregar responsable ---> */
			$__rsp = $this->In_Tra_Rsp([ 'tp'=>_CId('ID_USROL_RSP') ]);

			if($__rsp->e == 'ok'){

				$rsp['rsp'] = $__rsp;

				/*if($__rsp->e != 'ok'){
					$rsp['e'] = 'no';
					$rsp['m'] = 2;
					$rsp['w'] = $__rsp->w;
				}*/

				/* <---- Agregar observador ---> */
				if($this->trarsp_us != SISUS_ENC && !isN($this->trarsp_us)){

					$this->trarsp_tp = _CId('ID_USROL_OBS');
					$this->trarsp_us = SISUS_ENC;
					$__obs = $this->In_Tra_Rsp([ 'tp'=>_CId('ID_USROL_OBS') ]);

					if($__obs->e != 'ok'){
						$rsp['w'][] = 'Problem on save responsable';
						$rsp['w'][] = $__obs->w;
					}else{
						$rsp['obs'][] = $__obs;
					}

				}

				/* <---- Agregar observador desde ticket---> */
				if(!isN($this->traobs_us) && !isN($this->trarsp_us) && $this->traobs_us != SISUS_ENC){

					$this->trarsp_tp = _CId('ID_USROL_OBS');
					$this->trarsp_us = $this->traobs_us;
					$__obs = $this->In_Tra_Rsp([ 'tp'=>_CId('ID_USROL_OBS') ]);

					if($__obs->e != 'ok'){
						$rsp['w'][] = 'Problem on save observator';
						$rsp['w'][] = $__obs->w;
					}else{
						$rsp['obs'][] = $__obs;
					}
				}

			}else{

				$rsp['w'][] = 'Problem on save In_Tra_Rsp';
				$rsp['w'][] = $__rsp->w;

			}

		}else{

			$rsp['e'] = 'no';
			$rsp['m'] = 2;
			$rsp['w'][] = $__cnx->c_p->error;
			//$rsp['w'][] = compress_code($insertSQL);
			_ErrSis(['p'=>$insertSQL, 'd'=>$__cnx->c_p->error]);

		}

		return _jEnc($rsp);

    }

    public function In_MdlTraCnt($p=NULL){

		global $__cnx;

		$query_DtRg = sprintf("INSERT INTO "._BdStr($this->bd).TB_MDL_CNT_TRA." ( mdlcnttra_mdlcnt, mdlcnttra_tra) VALUES ( (SELECT id_mdlcnt FROM _mdl_cnt WHERE mdlcnt_enc = %s), %s) ",
					GtSQLVlStr($p['cnt'], 'text'),
					GtSQLVlStr($p['tra'], 'int'));

		$DtRg = $__cnx->_prc($query_DtRg);

		if($DtRg){
			$rsp['e'] = 'ok';
			$rsp['m'] = 1;
		}else{
			$rsp['e'] = 'no';
			$rsp['m'] = 2;
			$rsp['w'] = $__cnx->c_p->error;
		}


		return _jEnc($rsp);

	}


    public function In_Tra_Col_Ord($p=NULL){

		global $__cnx;

		if(!isN($this->tracolord_ord)){

			$__enc = Enc_Rnd(SISUS_ID.'-'.ctjTx( $p['col'] ,'out'));

			$query_DtRg = sprintf("INSERT INTO "._BdStr(DBM).TB_TRA_COL_ORD." ( tracolord_enc, tracolord_tracol, tracolord_us, tracolord_ord) VALUES (%s, %s, %s, %s) ",
							GtSQLVlStr($__enc, 'text'),
							GtSQLVlStr($p['col'], 'int'),
							GtSQLVlStr(SISUS_ID, 'int'),
							GtSQLVlStr($this->tracolord_ord, 'int'));

			$DtRg = $__cnx->_prc($query_DtRg);

			if($DtRg){
				$rsp['e'] = 'ok';
				$rsp['m'] = 1;
			}else{
				$rsp['e'] = 'no';
				$rsp['m'] = 2;
				$rsp['w'] = $__cnx->c_p->error;
			}

		}

		return _jEnc($rsp);

	}

	public function In_Tra_Ord($p=NULL){

		global $__cnx;

		$__enc = Enc_Rnd(SISUS_ID.'-'.ctjTx( $p['tra'] ,'out'));

		$query_DtRg = sprintf("INSERT INTO "._BdStr(DBM).TB_TRA_ORD." (traord_enc, traord_tra, traord_us, traord_ord) VALUES (%s, %s, %s, %s) ",
						GtSQLVlStr($__enc, 'text'),
						GtSQLVlStr($p['tra'], 'int'),
						GtSQLVlStr(SISUS_ID, 'int'),
						GtSQLVlStr($this->traord_ord, 'int'));

		$DtRg = $__cnx->_prc($query_DtRg);

		if($DtRg){
			$rsp['e'] = 'ok';
			$rsp['m'] = 1;
		}else{
			$rsp['e'] = 'no';
			$rsp['m'] = 2;
			$rsp['w'] = $__cnx->c_p->error;
		}

		return _jEnc($rsp);

	}

	public function In_Tra_Col_Grp($p=NULL){

		global $__cnx;

		$__enc = Enc_Rnd(SISUS_ID.'-'.ctjTx( $p['col'].'-'.$p['grp'] ,'out'));

		$query_DtRg = sprintf("INSERT INTO "._BdStr(DBM).TB_TRA_COL_GRP."
								( tracolgrp_enc, tracolgrp_tracol, tracolgrp_grp, tracolgrp_us )
									VALUES
								(%s, %s, (SELECT id_clgrp FROM "._BdStr(DBM).TB_CL_GRP." WHERE clgrp_enc = %s) , %s)
							",
						GtSQLVlStr($__enc, 'text'),
						GtSQLVlStr($p['col'], 'int'),
						GtSQLVlStr($p['grp'], 'text'),
						GtSQLVlStr(SISUS_ID, 'int'));

		$DtRg = $__cnx->_prc($query_DtRg);

		if($DtRg){
			$rsp['e'] = 'ok';
			$rsp['m'] = 1;
		}else{
			$rsp['e'] = 'no';
			$rsp['m'] = 2;
			$rsp['w'] = $__cnx->c_p->error;
		}

		return _jEnc($rsp);

	}

	public function Upd_Tra(){

		global $__cnx;

		if($this->tra_cls != ''){ $_upd_cls = $this->tra_cls; }else{ $_upd_cls = 2; }

		$updateSQL = sprintf("UPDATE "._BdStr(DBM).TB_TRA." SET tra_cls=%s, tra_tt=%s, tra_dsc=%s, tra_tp=%s, tra_est=%s, tra_f=%s, tra_h=%s, tra_chk_rsp='2' WHERE id_tra=%s",
						   GtSQLVlStr($_upd_cls, "int"),
						   GtSQLVlStr(strip_tags( ctjTx($this->tra_tt,'out') ), "text"),
						   GtSQLVlStr(ctjTx($this->tra_dsc,'out'), "text"),
						   GtSQLVlStr($this->tra_tp, "int"),
						   GtSQLVlStr($this->tra_est, "int"),
						   GtSQLVlStr($this->tra_f, "date"),
						   GtSQLVlStr($this->tra_h, "date"),
						   GtSQLVlStr($this->id_tra, "int"));

		$Result = $__cnx->_prc($updateSQL);

		//echo $updateSQL;
		if($Result){

			$_tra_dt = GtTraDt([ 'id'=>$this->id_tra ]);

			$rsp['i'] = $this->id_tra;
			$rsp['enc'] = $_tra_dt->enc;

			$rsp['e'] = 'ok';
			$rsp['m'] = 1;

			$this->_aud->In_Aud([ 'aud'=>_Cns('ID_AUDDSC_TRA_MOD'), "db"=>$this->db, "post"=>$this->post, "icn"=>"tra_up", "iddb"=>$rsp['i']]);

			if($this->__ntf != ''){
				$rsp['cl'] = " SUMR_Main.ntf.rmv(".$this->__ntf.", 'tra'); ";
			}

		}else{
			$rsp['e'] = 'no';
			$rsp['m'] = 2;
			$rsp['w'] = $__cnx->c_p->error;
			_ErrSis(['p'=>$updateSQL, 'd'=>$__cnx->c_p->error]);
		}

		return _jEnc($rsp);

	}


	public function Upd_Tra_F($p=NULL){

		global $__cnx;

		if( !isN($p['t']) && !isN($p['v']) && !isN($p['k']) && !isN($p['id']) ){

			if($p['t']=='tra'){
				$_bd = TB_TRA;
				$_prfx = 'tra';
			}elseif($p['t']=='col'){
				$_bd = TB_TRA_COL;
				$_prfx = 'tracol';
			}

			$updateSQL = sprintf("UPDATE "._BdStr(DBM).$_bd." SET ".$_prfx."_".$p['k']."=%s WHERE ".$_prfx."_enc=%s  ",
							GtSQLVlStr(ctjTx($p['v'],'out'), "text"),
							GtSQLVlStr(ctjTx($p['id'],'out'), "text"));

			$Result = $__cnx->_prc($updateSQL);

			//$rsp['sql'] = $updateSQL;

			if($Result){

				$rsp['e'] = 'ok';
				$rsp['enc'] = $p['id'];

				if($p['k'] == 'tt'){
					$this->_aud->In_Aud([ 'aud'=>_Cns('ID_AUDDSC_TRA_MOD_NM'), 'db'=>$this->db, 'post'=>$this->post, 'icn'=>'tra_mod' ]);
				}

				if($p['t']=='tra'){

					$_tra = GtTraDt([ 'id'=>$p['id'], 't'=>'enc' ]);

					if($p['k']=='est' && !isN($_tra->sac->tckid) && !isN($_tra->mdl_cnt->id)){
						$rsp['dthmlg'] = $__dthmlg = GtCntEstTra([ 'cl'=>DB_CL_ID, 'est'=>$p['v'] ]);
						$rsp['tmpupdmdlcntest'] = __MdlCntEst([ 'bd'=>$this->bd, 'c'=>$_tra->mdl_cnt->id, 'e'=>$__dthmlg->id ]);
					}

					$_rsp_ls = GtTraRspLs([ 't'=>'tra', 'k'=>'enc', 'tra'=>$p['id'] ]);
					$_rsp_i=1;
					$_rsp_a=$_rsp_ls->tot>1?'no':'ok';

					if($_rsp_ls->tot > 0){

						$_rsp_o=[];

						foreach($_rsp_ls->ls as $_rsp_k=>$_rsp_v){
							$_rsp_o = $_rsp_v->us->enc;
							$_rsp_i++;
							if($_rsp_i==$_rsp_ls->tot){ $_rsp_a=='ok'; }
						}

						$this->_ws->Send([
							'srv'=>'task',
							'act'=>'update_field',
							'to'=>$_rsp_o,
							'sadmin'=>$_rsp_a,
							'data'=>[
								'tra'=>[
									'id'=>$_tra->enc,
									'key'=>$p['k'],
									'val'=>$p['v']
								]
							]
						]);

					}

				}

			}else{

				$rsp['e'] = 'no';
				$rsp['m'] = 2;
				$rsp['w'] = $__cnx->c_p->error;
				_ErrSis(['p'=>$updateSQL, 'd'=>$__cnx->c_p->error]);

			}

		}else{
			$rsp['w'] = 'No all data';
		}

		return _jEnc($rsp);

	}


	//----------- Modificar Estado -----------//
	public function Upd_Tra_Est($p=NULL){

		global $__cnx;

		if(!isN($this->tra_est)){

			$updateSQL = sprintf("UPDATE "._BdStr(DBM).TB_TRA." SET tra_est=%s, tra_chk_rsp='2' WHERE id_tra=%s",
							GtSQLVlStr($this->tra_est, "int"),
							GtSQLVlStr($this->id_tra, "int"));

			$Result = $__cnx->_prc($updateSQL);
			if($Result){
				$rsp['e'] = 'ok';
				$rsp['m'] = 1;
				$this->_aud->In_Aud([ 'aud'=>_Cns('ID_AUDDSC_TRA_MOD'), "db"=>$this->db, "post"=>$this->post, "icn"=>"tra_up", "iddb"=>$rsp['i']]);
			}else{
				$rsp['e'] = 'no';
				$rsp['m'] = 2;
				$rsp['w'] = $__cnx->c_p->error;
				_ErrSis(['p'=>$updateSQL, 'd'=>$__cnx->c_p->error]);
			}
		}

		return _jEnc($rsp);

	}


	public function Tra_Ord_His($p=NULL){

		global $__cnx;

		if($p['id'] != NULL){

			$query_DtRg = sprintf("INSERT INTO "._BdStr(DBM).TB_TRA_ORD_HIS." (traordhis_id, traordhis_ord, traordhis_k, traordhis_tp) VALUES (%s, %s, %s, %s) ",
						GtSQLVlStr($p['id'], 'int'),
						GtSQLVlStr($p['ord'], 'int'),
						GtSQLVlStr(ctjTx($p['k'],'out'), "text"),
                       	GtSQLVlStr($p['tp'], 'int'));
			$DtRg = $__cnx->_prc($query_DtRg);

			if($DtRg){
				$rsp['e'] = 'ok';
				$rsp['m'] = 1;
			}else{
				$rsp['e'] = 'no';
				$rsp['m'] = 2;
				$rsp['w'] = $__cnx->c_p->error;
			}
		}

		return _jEnc($rsp);

	}

	public function In_Tra_Col(){

		global $__cnx;

		$query_DtRg = sprintf("INSERT INTO "._BdStr(DBM).TB_TRA_COL." (tracol_enc, tracol_tt, tracol_cl, tracol_tp, tracol_clr, tracol_icn, tracol_us, tracol_chk_pqr, tracol_chk_tck, tracol_chk_pblc) VALUES ("._BdStr(DBM)."f_Enc(),%s, %s, %s, %s, %s, %s, %s, %s, %s)",
					GtSQLVlStr(ctjTx($this->tracol_tt,'out'), "text"),
                   	GtSQLVlStr(DB_CL_ID, "int"),
					GtSQLVlStr($this->tracol_tp, "int"),
					GtSQLVlStr($this->tracol_clr, "int"),
                   	GtSQLVlStr($this->tracol_icn, "int"),
					GtSQLVlStr(SISUS_ID, 'int'),
					GtSQLVlStr($this->tracol_chk_pqr, "int"),
					GtSQLVlStr($this->tracol_chk_tck, "int"),
					GtSQLVlStr($this->tracol_chk_pblc, "int"));

		$DtRg = $__cnx->_prc($query_DtRg);

		if($DtRg){

			$__id = $__cnx->c_p->insert_id;
			$this->Tra_Ord_His(["id"=>$__id, "ord"=>$this->tracol_ord, "k"=>"_col", "tp"=>"2"]);

			$rsp['e'] = 'ok';
			$rsp['enc'] = $_enc;
			$rsp['id'] = $__id;

			$this->_aud->In_Aud([ 'aud'=>_Cns('ID_AUDDSC_TRA_COL_NEW'), "db"=>$this->db, "post"=>$this->post, "icn"=>"tra_up", "iddb"=>$__id]);

		}else{
			$rsp['e'] = 'no';
			$rsp['m'] = 2;
			$rsp['w'] = $__cnx->c_p->error;
		}

		return _jEnc($rsp);

	}

	public function Upd_Tra_Ord(){

		global $__cnx;

		$_dt_tra = GtTraDt([ 'id'=>$this->tra_enc, 't'=>'enc' ]);

		if(!isN($_dt_tra->id)){

			$__cnx->c_p->autocommit(FALSE);

			$rsp['e'] = 'no';

			//$_fl .= "AND tra_col IN (SELECT id_tracol FROM "._BdStr(DBM).TB_TRA_COL." WHERE tracol_enc = '".$this->tracol_enc."' )";
			//$_fl_old .= "AND tra_col IN (SELECT id_tracol FROM "._BdStr(DBM).TB_TRA_COL." WHERE tracol_enc = '".$this->oldtracol_enc."' )";

			$_fl .= "AND traord_tra IN ( SELECT id_tra FROM "._BdStr(DBM).TB_TRA." WHERE tra_col IN (SELECT id_tracol FROM "._BdStr(DBM).TB_TRA_COL." WHERE tracol_enc = '".$this->tracol_enc."') )";
			$_fl_old .= "AND traord_tra IN( SELECT id_tra FROM "._BdStr(DBM).TB_TRA." WHERE tra_col IN (SELECT id_tracol FROM "._BdStr(DBM).TB_TRA_COL." WHERE tracol_enc = '".$this->oldtracol_enc."') )";

			if($this->this_col == 'no'){

				$query_Mnr_ord = sprintf("UPDATE "._BdStr(DBM).TB_TRA_ORD." SET traord_ord = (traord_ord-1) WHERE traord_tra!=%s AND traord_ord >= %s $_fl_old",
									GtSQLVlStr($_dt_tra->id, "int"),
									GtSQLVlStr($this->old_position, "int"));

				$DtRg_Mnt_ord = $__cnx->_prc($query_Mnr_ord);

				$query_DtRg_ord = sprintf("UPDATE "._BdStr(DBM).TB_TRA_ORD." SET traord_ord = (traord_ord+1) WHERE traord_tra!=%s AND traord_ord >= %s $_fl",
									GtSQLVlStr($_dt_tra->id, "int"),
									GtSQLVlStr($this->new_position, "int"));

			}else{

				if($this->new_position > $this->old_position){

					$query_DtRg_ord = sprintf("UPDATE "._BdStr(DBM).TB_TRA_ORD." SET traord_ord = (traord_ord-1) WHERE traord_tra!=%s AND traord_ord <= %s AND traord_ord > %s $_fl",
										GtSQLVlStr($_dt_tra->id, "int"),
										GtSQLVlStr($this->new_position, 'int'),
										GtSQLVlStr($this->old_position, 'int'));

				}elseif($this->new_position < $this->old_position){

					$query_DtRg_ord = sprintf("UPDATE "._BdStr(DBM).TB_TRA_ORD." SET  traord_ord = (traord_ord+1) WHERE traord_tra!=%s AND traord_ord < %s AND traord_ord >= %s $_fl",
										GtSQLVlStr($_dt_tra->id, "int"),
										GtSQLVlStr($this->old_position, 'int'),
										GtSQLVlStr($this->new_position, 'int'));

				}else{

					$_noordupd='ok';

				}

			}

			if(!isN($query_DtRg_ord)){
				$DtRg_ord = $__cnx->_prc($query_DtRg_ord);
			}

			if($DtRg_ord || $_noordupd=='ok'){

				$_dt_tra_col = GtTraColDt(['id'=>$this->tracol_enc, 't'=>'enc', 'noord'=>'ok' ]);

				if(!isN($_dt_tra_col->id)){

					$query_DtRg = sprintf("UPDATE "._BdStr(DBM).TB_TRA." SET tra_col=%s, tra_lmve=%s, tra_chk_rsp=%s WHERE tra_enc=%s ",
											GtSQLVlStr($_dt_tra_col->id, "int"),
											GtSQLVlStr(SISUS_ID, "int"),
											GtSQLVlStr(2, "int"),
											GtSQLVlStr(ctjTx($this->tra_enc,'out'), "text"));

					$DtRg = $__cnx->_prc($query_DtRg);

					if(!$DtRg){

						$rsp['w2']['tc'] = $__cnx->c_p->error;
						$rsp['q'][] = $query_DtRg;

					}else{

						$Qry_DtRg_Org = sprintf("UPDATE "._BdStr(DBM).TB_TRA_ORD." SET traord_ord=%s WHERE traord_tra=%s",
												GtSQLVlStr($this->new_position, 'int'),
												GtSQLVlStr($_dt_tra->id, 'int'));

						$DtRg_Qry_Org = $__cnx->_prc($Qry_DtRg_Org);

						if(!$DtRg_Qry_Org){
							$rsp['w2']['to'] = $__cnx->c_p->error;
							$rsp['q'][] = $Qry_DtRg_Org;
						}

					}

				}else{

					$rsp['w2']['g'] = 'No GtTraColDt result';
					$rsp['w2']['g2'] = $_dt_tra_col;
				}

				if($__cnx->c_p->commit()){
					if(($DtRg) && ($DtRg_ord || $_noordupd=='ok') && $DtRg_Qry_Org){
						$rsp['e'] = 'ok';
						$rsp['m'] = 1;
					}else{
						$rsp['m'] = 2;
						$rsp['w']['nnt'] = $__cnx->c_p->error;
						$rsp['tmp'][] = $DtRg;
						$rsp['tmp'][] = $DtRg_ord;
						$rsp['tmp'][] = $DtRg_Qry_Org;
					}
				}else{
					$rsp['w2']['cmt'] = $__cnx->c_p->error;
				}

			}else{

				$rsp['w2']['tor'] = $__cnx->c_p->error;
				$rsp['q'][] = $query_DtRg_ord;

			}

			$__cnx->c_p->autocommit(TRUE);

		}else{

			$rsp['w'] = 'No tra id';

		}

		return _jEnc($rsp);

	}

	public function Upd_Tra_Us_Est(){

		global $__cnx;
		$_allw = 'ok';

		if(!_ChckMd('tra_arch') && $this->trausest_est == _CId('ID_TRAEST_ARCHV')){ $_allw = 'no'; }
		if(!_ChckMd('tra_eli') && $this->trausest_est == _CId('ID_TRAEST_ELI')){ $_allw = 'no'; }

		if(!isN($this->trausest_est) && $_allw == 'ok'){

			$__fl = sprintf("(SELECT id_tra FROM "._BdStr(DBM).TB_TRA." WHERE tra_enc = %s)", GtSQLVlStr(ctjTx($this->trausest_tra,'out'), "text"));

			$query_DtRg = sprintf("INSERT INTO "._BdStr(DBM).TB_TRA_US_EST."(trausest_us, trausest_tra, trausest_est) VALUES (%s, $__fl, %s)",
							GtSQLVlStr(SISUS_ID, 'int'),
						   	GtSQLVlStr($this->trausest_est, 'int'));

			$DtRg = $__cnx->_prc($query_DtRg);

			//$rsp['q'] = compress_code( $query_DtRg );

			if($DtRg){

				$rsp['e'] = 'ok';
				$rsp['m'] = 1;

				if($this->trausest_est == _CId('ID_TRAEST_CMPL')){
					$_aud = _Cns('ID_AUDDSC_TRA_CMPL'); $_icn = "tra_cmpl";
				}elseif($this->trausest_est == _CId('ID_TRAEST_ARCHV')){
					$_aud = _Cns('ID_AUDDSC_TRA_ARCH'); $_icn = "tra_ach";
				}elseif($this->trausest_est == _CId('ID_TRAEST_ELI')){
					$_aud = _Cns('ID_AUDDSC_TRA_ELI'); $_icn = "tra_elim";
				}elseif($this->trausest_est == _CId('ID_TRAEST_PRC')){
					$_aud = _Cns('ID_AUDDSC_TRA_ON'); $_icn = "tra_prc";
				}

				$this->_aud->In_Aud([ 'aud'=>$_aud, "db"=>$this->db, "post"=>$this->post, "icn"=>$_icn]);

			}else{
				$rsp['e'] = 'no';
				$rsp['m'] = 2;
				$rsp['w'] = $__cnx->c_p->error;
			}

			$__cnx->_clsr($DtRg);

		}else{

			if($_allw == 'no'){ $rsp['allw'] = 'no'; }

		}

		return _jEnc($rsp);
	}

	public function Upd_Tra_Col(){

		global $__cnx;

		if(!isN($this->tracol_enc)){

			if( !isN($this->tracol_clr) ){ $Vl['tracol_clr'] = $this->tracol_clr; }
			if( !isN($this->tracol_tp) ){ $Vl['tracol_tp'] = $this->tracol_tp; }
			if( !isN($this->tracol_icn) ){ $Vl['tracol_icn'] = $this->tracol_icn; }
			if( !isN($this->tracol_tt) ){ $Vl['tracol_tt'] = $this->tracol_tt; }
			if( !isN($this->tracol_chk_pqr) ){ $Vl['tracol_chk_pqr'] = $this->tracol_chk_pqr; }
			if( !isN($this->tracol_chk_tck) ){ $Vl['tracol_chk_tck'] = $this->tracol_chk_tck; }
			if( !isN($this->tracol_chk_pblc) ){ $Vl['tracol_chk_pblc'] = $this->tracol_chk_pblc; }

			$Vl_Ls = _jEnc($Vl);

			foreach($Vl_Ls as $_k=>$_v){

				if( !isN($_k) && !isN($_v) ){

					$query_DtRg = sprintf("UPDATE "._BdStr(DBM).TB_TRA_COL." SET ".$_k."=%s WHERE tracol_enc=%s",
								GtSQLVlStr(ctjTx($_v,'out'), "text"),
								GtSQLVlStr(ctjTx($this->tracol_enc,'out'), "text"));

					$DtRg = $__cnx->_prc($query_DtRg);

					//$rsp['q'] = compress_code( $query_DtRg );

					if($DtRg){
						$rsp['e'] = 'ok';
						$rsp['m'] = 1;
						$__id = $__cnx->c_p->insert_id;
						$this->_aud->In_Aud([ 'aud'=>_Cns('ID_AUDDSC_TRA_COL_MOD'), "db"=>$this->db, "post"=>$this->post, "icn"=>"tra_up", "iddb"=>$_k]);
					}else{
						$rsp['e'] = 'no';
						$rsp['m'] = 2;
						$rsp['w'] = $__cnx->c_p->error;
					}
				}

			}
		}

		return _jEnc($rsp);
	}

	public function Upd_Tra_Col_Ord(){

		global $__cnx;

		if($this->new_position > $this->old_position){

			$query_DtRg_ord = sprintf("
										UPDATE "._BdStr(DBM).TB_TRA_COL_ORD." SET tracolord_ord = (tracolord_ord-1)
										WHERE tracolord_tracol != (SELECT id_tracol FROM "._BdStr(DBM).TB_TRA_COL." WHERE tracol_enc = %s)
										AND tracolord_ord <= %s
										AND tracolord_ord > %s
										AND tracolord_us = %s
									  ",
							GtSQLVlStr(ctjTx($this->tracol_enc,'out'), "text"),
							GtSQLVlStr($this->new_position, 'int'),
	                       	GtSQLVlStr($this->old_position, 'int'),
	                       	GtSQLVlStr(SISUS_ID, 'int'));

		}elseif($this->new_position < $this->old_position){

			$query_DtRg_ord = sprintf("
										UPDATE "._BdStr(DBM).TB_TRA_COL_ORD." SET tracolord_ord = (tracolord_ord+1)
										WHERE tracolord_tracol != (SELECT id_tracol FROM "._BdStr(DBM).TB_TRA_COL." WHERE tracol_enc = %s)
										AND tracolord_ord < %s
										AND tracolord_ord >= %s
										AND tracolord_us = %s
									  ",
							GtSQLVlStr(ctjTx($this->tracol_enc,'out'), "text"),
							GtSQLVlStr($this->old_position, 'int'),
	                       	GtSQLVlStr($this->new_position, 'int'),
	                       	GtSQLVlStr(SISUS_ID, 'int'));

		}

		if(!isN($query_DtRg_ord)){
			$DtRg_ord = $__cnx->_prc($query_DtRg_ord);
			$rsp['tmp__ord'] = $query_DtRg_ord;
		}

		if($DtRg_ord){

			$query_DtRg = sprintf("
									UPDATE "._BdStr(DBM).TB_TRA_COL_ORD." SET tracolord_ord = %s
									WHERE tracolord_tracol IN (SELECT id_tracol FROM "._BdStr(DBM).TB_TRA_COL." WHERE tracol_enc = %s)
									AND tracolord_us = %s
								  ",
							GtSQLVlStr($this->new_position, 'int'),
	                       	GtSQLVlStr(ctjTx($this->tracol_enc,'out'), "text"),
	                       	GtSQLVlStr(SISUS_ID, 'int'));

			$DtRg = $__cnx->_prc($query_DtRg);

			$rsp['tmp__upd'] = $query_DtRg;

		}else{

			$rsp['w'][] = 'No query update order';

		}

		if($DtRg && $DtRg_ord){
			$rsp['e'] = 'ok';
			$rsp['m'] = 1;
		}else{
			$rsp['e'] = 'no';
			$rsp['m'] = 2;
			$rsp['w'][] = $__cnx->c_p->error;
		}

		return _jEnc($rsp);

	}

	public function Upd_Tra_Ctrl_Ord(){

		global $__cnx;

		if(!isN($this->tra_enc)){

			$_tradt = GtTraDt([ 'id'=>$this->tra_enc, 't'=>'enc' ]);

			if(!isN($_tradt->id)){

				if($this->new_position > $this->old_position){

					$query_DtRg_ord = sprintf("UPDATE "._BdStr(DBM).TB_TRA_CTRL." SET tractrl_ord = (tractrl_ord-1) WHERE tractrl_enc != %s AND tractrl_ord <= %s AND tractrl_ord > %s AND tractrl_tra=%s ",
									GtSQLVlStr(ctjTx($this->tractrl_enc,'out'), "text"),
									GtSQLVlStr($this->new_position, 'int'),
									GtSQLVlStr($this->old_position, 'int'),
									GtSQLVlStr($_tradt->id, 'int'));

				}elseif($this->new_position < $this->old_position){

					$query_DtRg_ord = sprintf("UPDATE "._BdStr(DBM).TB_TRA_CTRL." SET tractrl_ord = (tractrl_ord+1) WHERE tractrl_enc != %s AND tractrl_ord < %s AND tractrl_ord >= %s AND tractrl_tra=%s ",
									GtSQLVlStr(ctjTx($this->tractrl_enc,'out'), "text"),
									GtSQLVlStr($this->old_position, 'int'),
									GtSQLVlStr($this->new_position, 'int'),
									GtSQLVlStr($_tradt->id, 'int'));
				}

				if(!isN($query_DtRg_ord)){
					$rsp['q'][] = $query_DtRg_ord;
					$DtRg_ord = $__cnx->_prc($query_DtRg_ord);
				}

				if($DtRg_ord){

					$query_DtRg = sprintf("UPDATE "._BdStr(DBM).TB_TRA_CTRL." SET tractrl_ord = %s WHERE tractrl_enc = %s ",
									GtSQLVlStr($this->new_position, 'int'),
									GtSQLVlStr(ctjTx($this->tractrl_enc,'out'), "text"));

					$DtRg = $__cnx->_prc($query_DtRg);

					$rsp['q'][] = $query_DtRg;
				}

				if($DtRg && $DtRg_ord){
					$rsp['e'] = 'ok';
					$rsp['m'] = 1;
				}else{
					$rsp['e'] = 'no';
					$rsp['m'] = 2;
					$rsp['w'] = $__cnx->c_p->error;
				}

			}

		}

		return _jEnc($rsp);

	}

	public function Upd_Tra_Cmnt($p=null){

		global $__cnx;

		if(!isN($p['v']) && !isN($p['id'])){

			$query_DtRg = sprintf("UPDATE "._BdStr(DBM).TB_TRA_CMNT." SET tracmnt_tt = %s WHERE tracmnt_enc=%s",
							GtSQLVlStr(ctjTx($p['v'],'out'), "text"),
							GtSQLVlStr(ctjTx($p['id'],'out'), "text"));

			$DtRg = $__cnx->_prc($query_DtRg);

			if($DtRg){
				$rsp['e'] = 'ok';
				$rsp['m'] = 1;

			}else{
				$rsp['e'] = 'no';
				$rsp['m'] = 2;
				$rsp['w'] = $query_DtRg;

			}

		}

		return _jEnc($rsp);

	}

	public function Eli_Tra_Cmnt($p=null){

		global $__cnx;

		if(!isN($p['id'])){

			$query_DtRg = sprintf("DELETE FROM "._BdStr(DBM).TB_TRA_CMNT." WHERE tracmnt_enc = %s ",
							GtSQLVlStr($p['id'], "text"));

			$DtRg = $__cnx->_prc($query_DtRg);

			if($DtRg){
				$rsp['e'] = 'ok';
				$rsp['m'] = 1;
			}else{
				$rsp['e'] = 'no';
				$rsp['m'] = 2;
				$rsp['w'] = $query_DtRg;
			}

		}

		return _jEnc($rsp);
	}

	public function Ins_Tra_Cmnt(){

		global $__cnx;

		$query_DtRg = sprintf("INSERT INTO "._BdStr(DBM).TB_TRA_CMNT." (tracmnt_enc, tracmnt_tt, tracmnt_us, tracmnt_tra) VALUES ( %s, %s, %s, %s)",
						GtSQLVlStr(ctjTx(Gn_Rnd(20).Gn_Rnd(2), 'out'), "text"),
						GtSQLVlStr(compress_code(ctjTx($this->val,'out')), "text"),
						GtSQLVlStr(SISUS_ID, 'int'),
						GtSQLVlStr($this->tra, "int"));

		$DtRg = $__cnx->_prc($query_DtRg);

		if($DtRg){
			$rsp['e'] = 'ok';
			$rsp['m'] = 1;
			$rsp['id'] = $__cnx->c_p->insert_id;
			$this->_aud->In_Aud([ 'aud'=>_Cns('ID_AUDDSC_TRA_CMNT_ING'), "db"=>$this->db, "post"=>$this->post, "icn"=>"tra_add", "iddb"=>$rsp['id']]);

		}else{
			$rsp['e'] = 'no';
			$rsp['m'] = 2;
			$rsp['w'] = $__cnx->c_p->error;
		}

		return _jEnc($rsp);

	}


	public function Eli_Tra_Ctrl(){

		global $__cnx;

		$rsp['e'] = 'no';

		if(!isN($this->tra_enc)){

			$_tradt = GtTraDt([ 'id'=>$this->tra_enc, 't'=>'enc' ]);

			if(!isN($_tradt->id)){

				$query_DtRg_ord = sprintf("UPDATE "._BdStr(DBM).TB_TRA_CTRL." SET tractrl_ord = (tractrl_ord-1) WHERE tractrl_ord > %s AND tractrl_tra=%s ",
											GtSQLVlStr($this->ult, "int"),
											GtSQLVlStr($_tradt->id, "int"));

				$DtRg_ord = $__cnx->_prc($query_DtRg_ord);

				if($DtRg_ord){

					$query_DtRg = sprintf("DELETE FROM "._BdStr(DBM).TB_TRA_CTRL." WHERE tractrl_enc=%s ",
									GtSQLVlStr(ctjTx($this->tractrl_enc,'out'), "text"));
					$DtRg = $__cnx->_prc($query_DtRg);

					//echo ($this->$_enc); exit();

					if($DtRg){

						$TraDtCtrl = GtTraCtrlDt([ 'tp'=>'enc', 'id'=>$this->tractrl_enc ]);

						$rsp['e'] = 'ok';
						$rsp['m'] = 1;
						$rsp['i'] = 1;

						$this->_aud->In_Aud([ 'aud'=>_Cns('ID_AUDDSC_TRA_CTRL_ELI'), "db"=>"tra_ctrl", "iddb"=>$__id, "post"=>$_POST,  "dbrlc"=>"tra", "iddb"=>$rsp['i']]);
						//$this->_aud->In_Aud(array("aud"=>"446", "db"=>"tra_ctrl", "iddb"=>$__id, "post"=>$_POST["data"], "dbrlc"=>"tra", "iddbrlc"=>$TraDt->{$_enc}->id));

					}else{
						$rsp['e'] = 'no';
						$rsp['m'] = 2;
						$rsp['w'] = $__cnx->c_p->error;
					}

				}

			}

		}

		return _jEnc($rsp);

	}



	public function Chk_Tra_Rsp($p=NULL){

		global $__cnx;

		if(!isN($p['tra']) && !isN($p['us']) && !isN($p['tp'])){

			$query_DtRg = sprintf('	SELECT id_trarsp, trarsp_enc
									FROM '._BdStr(DBM).TB_TRA_RSP.'
									WHERE trarsp_tra=%s AND trarsp_us=%s AND trarsp_tp=%s',
									GtSQLVlStr($p['tra'],'int'),
									GtSQLVlStr($p['us'],'int'),
									GtSQLVlStr($p['tp'],'int')
							);

			$DtRg = $__cnx->_qry($query_DtRg);

			if($DtRg){

				$Vl['e'] = 'ok';
				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;

				if($Tot_DtRg > 0){
					$Vl['id'] = $row_DtRg['id_trarsp'];
					$Vl['tt'] = ctjTx($row_DtRg['trarsp_enc'],'in');
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


	public function In_Tra_Rsp($p=NULL){

		global $__cnx;

		$rsp['e'] = 'no';

		$_fl_tp_us = 'enc';

		if(!isN($this->trarsp_us)){
			if(is_numeric($this->trarsp_us)){ $_fl_tp_us = ''; }
			$__rsp_us = $this->trarsp_us;
		}else{
			$__rsp_us = SISUS_ENC;
		}

		$_us = GtUsDt($__rsp_us, $_fl_tp_us, [ 'all'=>'ok', 'cl_no'=>'ok' ]);
		$_tra = GtTraDt([ 'id'=>$this->tra_enc, 't'=>'enc', 'cmmt'=>'ok', 'bd'=>$this->bd ]);

		if(!isN($this->trarsp_us_asg)){ $_us_asg = $this->trarsp_us_asg; }else{ $_us_asg = SISUS_ID; }

		if(!isN($_us->id) && !isN($_tra->id) && !isN($this->trarsp_tp)){

			$_chk = $this->Chk_Tra_Rsp([ 'tra'=>$_tra->id, 'us'=>$_us->id, 'tp'=>$this->trarsp_tp ]);

			if($_chk->e == 'ok'){

				if(!isN($_chk->id)){

					$rsp['e'] = 'ok';
					$rsp['m'] = 1;
					$rsp['enc'] = $_chk->enc;

				}else{

					$_enc = Enc_Rnd($_tra->id.''.SISUS_ID);

					$query_DtRg =  sprintf("INSERT INTO "._BdStr(DBM).TB_TRA_RSP." (trarsp_enc, trarsp_tra, trarsp_us_asg, trarsp_us, trarsp_tp, trarsp_dsc) VALUES (%s, %s, %s, %s, %s, %s)",
												GtSQLVlStr($_enc, "text"),
												GtSQLVlStr($_tra->id, "int"),
												GtSQLVlStr($_us_asg, "int"),
												GtSQLVlStr($_us->id, "int"),
												GtSQLVlStr($this->trarsp_tp, "int"),
												GtSQLVlStr(ctjTx($this->trarsp_dsc,'out'), "text"));

					$Result = $__cnx->_prc($query_DtRg);

					if($Result){

						$rsp['e'] = 'ok';
						$rsp['m'] = 1;
						$rsp['enc'] = $_enc;

						//--------- Ingreso Responsable ---------//

						$this->_Ntf->ntf_acc = [ 't'=>_CId('ID_NTFACC_ARSP'), 'v1'=>SISUS_NM ];
						$this->_Ntf->ntf_tp = _CId('ID_NTFTP_TRA');
						$this->_Ntf->ntf_id_enc = $this->tra_enc;
						$this->_Ntf->ntf_id = $this->id_tra;
						$this->_Ntf->ntf_us = $_us->id;

						if($_us->id != SISUS_ID){
							$this->_Ntf->ntf_sub = 'rsp';
							$rsp['ntf'] = $this->_Ntf->Prc();
						}

						//--------- Ingreso Fecha Limite Tarea ---------//

						if( !isN($this->tra_f) ){
							if(!isN($this->tra_bfr)){ $this->_Ntf->ntf_bfro = $this->tra_bfr; }
							$this->_Ntf->ntf_ftrgr = $this->tra_f;
							$this->_Ntf->ntf_htrgr = $this->tra_h;
							$this->_Ntf->ntf_sub = "ffin";
							$this->_Ntf->Prc();
						}

						//--------- Actualizo via Socket ---------//

						$_rsp_ls = GtTraRspLs([ 't'=>'tra', 'tra'=>$_tra->id, 'cmmt'=>'ok' ]);
						$_rsp_i=1;
						$_rsp_a=$_rsp_ls->tot>1?'no':'ok';

						if($_rsp_ls->tot > 0){

							$_rsp_o=[];

							foreach($_rsp_ls->ls as $_rsp_k=>$_rsp_v){

								if($this->trarsp_tp == _CId('ID_USROL_RSP')){
									$_rsp_o[] = $_rsp_v->us->enc;
								}

								$_rsp_i++;

								if($_rsp_i==$_rsp_ls->tot){ $_rsp_a=='ok'; }

							}


							$this->_ws->Send([
								'srv'=>'task',
								'act'=>'responsable_new',
								'to'=>$_rsp_o,
								'sadmin'=>$_rsp_a,
								'data'=>[
									'tra'=>[
										'id'=>$_tra->enc,
										'est'=>'in',
										'rsp'=>[
											'tp'=>( $this->trarsp_tp==_CId('ID_USROL_RSP')?'rsp':'obs' ),
											'enc'=>$_us->enc,
											'nm'=>$_us->nm,
											'ap'=>$_us->ap,
											'img'=>$_us->img
										]
									]
								]
							]);

						}

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
			if(isN($_us->id)){ $rsp['w'][] = 'No us id detail for '.$__rsp_us; $rsp['w'][] = $_us; }
			if(isN($_tra->id)){ $rsp['w'][] = 'No tra id'; $rsp['w'][] = $_tra->w; }

		}

		return _jEnc($rsp);
	}


	public function Del_Tra_Rsp($p=NULL){

		global $__cnx;

		$rsp['e'] = 'no';

		if((!isN($p['tra']) && !isN($p['rsp'])) || !isN($p['id']) ){

			if($this->trarsp_us != ''){ $__rsp_us = $this->trarsp_us; }else{ $__rsp_us = SISUS_ID; }

			if( !isN( $p['id'] ) ){
				$__fl .= sprintf(' id_trarsp=%s ', GtSQLVlStr($p['id'], "int"));
			}else if( !isN( $p['tra'] ) && !isN( $p['rsp'] ) ){
				$__fl .= sprintf(" trarsp_tra=%s AND trarsp_us=%s ", GtSQLVlStr($p['tra'], "int"), GtSQLVlStr($p['rsp'], "int"));
			}

			if(!isN( $__fl )){

				$query_DtRg = sprintf("DELETE FROM "._BdStr(DBM).TB_TRA_RSP." WHERE $__fl");
				$Result = $__cnx->_prc($query_DtRg);

				if($Result){
					$rsp['e'] = 'ok';
					$rsp['m'] = 1;
					//$rsp['qry'] =$query_DtRg;
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

	public function Upd_Tra_Rsp($p=NULL){

		global $__cnx;

		$query_DtRg = sprintf("UPDATE "._BdStr(DBM).TB_TRA_RSP." SET trarsp_us=%s, trarsp_tp=%s, trarsp_us_asg=%s WHERE trarsp_tra = (SELECT id_tra FROM "._BdStr(DBM).TB_TRA." WHERE tra_enc = %s) AND trarsp_tp = '"._CId('ID_USROL_RSP')."'",
						GtSQLVlStr(ctjTx($this->trarsp_us,'out'), "text"),
						GtSQLVlStr($this->trarsp_tp, "int"),
						GtSQLVlStr(SISUS_ID, "int"),
						GtSQLVlStr(ctjTx($this->enc,'out'), "text"));

		$DtRg = $__cnx->_prc($query_DtRg);
		//echo $query_DtRg; exit();
		if($DtRg){
			$rsp['e'] = 'ok';
			$rsp['m'] = 1;
		}else{
			$rsp['e'] = 'no';
			$rsp['m'] = 2;
			//$rsp['w'] = $query_DtRg;
		}
		return _jEnc($rsp);
	}

	public function Eli_Col(){

		global $__cnx;

		$query_DtRg = sprintf("UPDATE "._BdStr(DBM).TB_TRA." SET
				tra_col = (SELECT id_tracol FROM tra_col WHERE tracol_enc = %s)
				WHERE tra_col = (SELECT id_tracol FROM tra_col WHERE tracol_enc = %s)",
						GtSQLVlStr(ctjTx($this->_id,'out'), "text"),
                       	GtSQLVlStr(ctjTx($this->_enc,'out'), "text"));

		$DtRg = $__cnx->_prc($query_DtRg);
		if($DtRg){
			$rsp['e'] = 'ok';
			$rsp['m'] = 1;

			$query_DtRg1 = sprintf("Delete from tra_col where tracol_enc =  %s",
                       	GtSQLVlStr(ctjTx($this->_enc,'out'), "text"));

            $DtRg1 = $__cnx->_prc($query_DtRg1);
            if($DtRg1){ $rsp['e1'] = 'ok';  }else{ $rsp['e1'] = 'no'; }

		}else{
			$rsp['e'] = 'no';
			$rsp['m'] = 2;
			$rsp['w'] = $__cnx->c_p->error;
		}

		return _jEnc($rsp);

	}

	public function Ins_Rsg_Tme(){

		global $__cnx;
		//$rsp['e'] = SIS_H.' '.$this->enc.' '.SISUS_ID;

		$est = $this->_v;

		if($est == 1){

			$est_l = 'AND s.id_tratmergs != p.id_tratmergs';
			$__enc = Enc_Rnd($this->tra.''.$this->_v);

			$query_DtRg = sprintf("INSERT INTO "._BdStr(DBM).TB_TRA_TME." (tratmergs_enc,  tratmergs_us, tratmergs_tra, tratmergs_est, tratmergs_act) VALUES ( %s, %s,(SELECT id_tra FROM "._BdStr(DBM).TB_TRA." WHERE tra_enc = %s), %s, %s )",
									GtSQLVlStr($__enc, "text"),
									GtSQLVlStr(SISUS_ID, 'int'),
									GtSQLVlStr(ctjTx($this->tra,'out'), "text"),
									GtSQLVlStr($this->_v, 'int'),
									GtSQLVlStr($this->_v, 'int'));

		}else if($est == 2){

			$__enc = $this->enc;
			$query_DtRg = sprintf("UPDATE "._BdStr(DBM).TB_TRA_TME." SET tratmergs_hf = %s WHERE id_tratmergs = %s", GtSQLVlStr(SIS_F_TS, "date"), GtSQLVlStr(ctjTx($this->enc,'out'), "text"));
			$est_l = '';

		}

		$DtRg = $__cnx->_prc($query_DtRg);

		if($DtRg){

			$rsp['e'] = 'ok';
			$rsp['m'] = 1;
			$rsp['id'] = $__cnx->c_p->insert_id;
			$rsp['enc'] = $__enc;

			$query_DtRg1 = sprintf("UPDATE "._BdStr(DBM).TB_TRA_TME." AS s, (SELECT id_tratmergs FROM "._BdStr(DBM).TB_TRA_TME." WHERE tratmergs_us = %s AND tratmergs_act = 1 ORDER BY id_tratmergs DESC LIMIT 1) AS p SET s.tratmergs_act = 2, s.tratmergs_hf = %s WHERE s.tratmergs_act = 1 AND s.tratmergs_us =  %s $est_l",GtSQLVlStr(SISUS_ID, 'int'),GtSQLVlStr(SIS_F_TS, "date"), GtSQLVlStr(SISUS_ID, 'int'));

			$rsp['id_r'] = $query_DtRg;
			$DtRg1 = $__cnx->_prc($query_DtRg1);

			if($DtRg1){	$rsp['e1'] = 'ok'; }else{ $rsp['e1'] = 'no'; }

		}else{
			$rsp['e'] = 'no';
			$rsp['m'] = 2;
			$rsp['w'] = $query_DtRg;
		}

		return _jEnc($rsp);

	}

	public function Cmp_Tra_All(){

		global $__cnx;

		$query_DtRg = sprintf("UPDATE "._BdStr(DBM).TB_TRA." SET
				tra_est = '"._CId('ID_TRAEST_CMPL')."'
				WHERE tra_col = (SELECT id_tracol FROM tra_col WHERE tracol_enc = %s) AND tra_est = '"._CId('ID_TRAEST_PRC')."'",
                       	GtSQLVlStr(ctjTx($this->enc,'out'), "text"));


		$DtRg = $__cnx->_prc($query_DtRg);

		if($DtRg){
			$rsp['e'] = 'ok';
		}else{
			$rsp['e'] = 'no';
		}



		return _jEnc($rsp);

	}

	public function Upd_Tra_Us_Est_All(){

		global $__cnx;

		foreach($this->trausest_tra as $v){
			$rs .= (',('.SISUS_ID.','.$v.','.$this->trausest_est.')');
		}

		$rs=substr($rs,1);

		$query_DtRg = sprintf("INSERT INTO "._BdStr(DBM).TB_TRA_US_EST." (trausest_us, trausest_tra, trausest_est) VALUES $rs");
		$DtRg = $__cnx->_prc($query_DtRg);

		if($DtRg){
			$rsp['e'] = 'ok';
			$rsp['m'] = 1;
		}else{
			$rsp['e'] = 'no';
			$rsp['m'] = 2;
			$rsp['w'] = $__cnx->c_p->error;
		}


		return _jEnc($rsp);
	}

	public function Arc_Tra_All(){

		global $__cnx;

		$query_DtRg = sprintf("UPDATE "._BdStr(DBM).TB_TRA." SET
				tra_est = '"._CId('ID_TRAEST_ARCHV')."'
				WHERE tra_col = (SELECT id_tracol FROM tra_col WHERE tracol_enc = %s AND tra_est= "._CId('ID_TRAEST_CMPL').")",
                       	GtSQLVlStr(ctjTx($this->enc,'out'), "text"));


		$DtRg = $__cnx->_prc($query_DtRg);

		if($DtRg){
			$rsp['e'] = 'ok';
		}else{
			$rsp['e'] = 'no';
		}

		return _jEnc($rsp);

	}

	public function GtTraColUs_Ls($p=NULL){

	    global $__cnx;

	    $Vl['e'] = 'no';

	    if(!isN($this->tra_col)){

			if(!isN($this->id_grp)){
				$_inner = " INNER JOIN "._BdStr(DBM).TB_CL_GRP_US." ON clgrpus_us = id_us";
				$_flt = " AND clgrpus_clgrp = (SELECT id_clgrp FROM "._BdStr(DBM).TB_CL_GRP." WHERE clgrp_enc = '".$this->id_grp."')";
			}

			if(!ChckSESS_superadm()){
				$_flt .= " AND us_nivel != 'superadmin' ";
			}

			$query_DtRg = "
					SELECT id_us, us_nm, us_ap, us_enc, us_img,
						(	SELECT COUNT(*)
							FROM "._BdStr(DBM).TB_TRA_COL_US."
								INNER JOIN "._BdStr(DBM).TB_TRA_COL." ON tracolus_tracol = id_tracol
							WHERE id_us = tracolus_us AND
									tracolus_tracol = '".$this->tra_col."' AND
									tracolus_tp = "._CId('ID_USROL_RSP')."
						) AS rsp,
						(	SELECT COUNT(*)
							FROM "._BdStr(DBM).TB_TRA_COL_US."
								INNER JOIN "._BdStr(DBM).TB_TRA_COL." ON tracolus_tracol = id_tracol
							WHERE id_us = tracolus_us AND
									tracolus_tracol = '".$this->tra_col."' AND
									tracolus_tp = "._CId('ID_USROL_OBS')."
						) AS obs,
						(	SELECT COUNT(*)
							FROM "._BdStr(DBM).TB_TRA_COL_US."
								INNER JOIN "._BdStr(DBM).TB_TRA_COL." ON tracolus_tracol = id_tracol
							WHERE id_us = tracolus_us AND
									tracolus_tracol = '".$this->tra_col."' AND
									tracolus_tp = "._CId('ID_USROL_RSP_DFT')."
						) AS rsp_d,
						(	SELECT COUNT(*)
							FROM "._BdStr(DBM).TB_TRA_COL_US."
								INNER JOIN "._BdStr(DBM).TB_TRA_COL." ON tracolus_tracol = id_tracol
							WHERE id_us = tracolus_us AND
									tracolus_tracol = '".$this->tra_col."' AND
									tracolus_tp = "._CId('ID_USROL_OBS_DFT')."
						) AS obs_d
					 FROM "._BdStr(DBM).TB_US."
							 INNER JOIN "._BdStr(DBM).TB_US_CL." ON uscl_us = id_us
							 $_inner
						WHERE uscl_cl = '".DB_CL_ID."' $_flt
						ORDER BY us_ap ASC, us_nm ASC";

			$DtRg = $__cnx->_qry($query_DtRg);

			if($DtRg){

				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;
				$Vl['tot'] = $Tot_DtRg;

				if($Tot_DtRg > 0){

					$Vl['e'] = 'ok';

					do{

						$Vl['ls'][$row_DtRg['us_enc']]['enc'] = $row_DtRg['us_enc'];
						$Vl['ls'][$row_DtRg['us_enc']]['nm'] = ctjTx($row_DtRg['us_nm'],'out').' '.ctjTx($row_DtRg['us_ap'],'out');
						$Vl['ls'][$row_DtRg['us_enc']]['rsp'] = ctjTx($row_DtRg['rsp'],'out');
						$Vl['ls'][$row_DtRg['us_enc']]['obs'] = ctjTx($row_DtRg['obs'],'out');
						$Vl['ls'][$row_DtRg['us_enc']]['rsp_d'] = ctjTx($row_DtRg['rsp_d'],'out');
						$Vl['ls'][$row_DtRg['us_enc']]['obs_d'] = ctjTx($row_DtRg['obs_d'],'out');

						if( !isN($row_DtRg['us_img']) ){

							$Vl['ls'][$row_DtRg['us_enc']]['img'] = _ImVrs([ 'img'=>$row_DtRg['us_img'], 'f'=>DMN_FLE_US ]);

						}else{

							$_img = GtUsImg([ 'img'=>$row_DtRg['us_img'], 'gnr'=>$row_DtRg['us_gnr'] ]);
							$Vl['ls'][$row_DtRg['us_enc']]['img'] = $_img;
						}


					}while($row_DtRg = $DtRg->fetch_assoc());

				}

			}
			$__cnx->_clsr($DtRg);

		}

		return _jEnc($Vl);
	}

	public function GtTraColUs($p=NULL){

	    $Vl['e'] = 'no';
		$__chk = $this->GtTraColUs_Chk();
		$Vl['chk'] = $__chk;

		if(isN($__chk->id)){
			$__in = $this->GtTraColUs_In();
			if($__in->e == 'ok'){ $Vl['e'] = 'ok'; }
		}

		if(!isN($__chk->id)){
			$__upd = $this->GtTraColUs_Del();
			if($__upd->e == 'ok'){ $Vl['upd']='ok'; $Vl['e']='ok'; }else{ $Vl['e']='no'; }
		}

		return(_jEnc($Vl));
	}

	public function GtTraColUs_Chk($p=NULL){

		global $__cnx;

		if( !isN($this->tra_col_us) && !isN($this->tra_col_tp) && !isN($this->tra_col)){

			$Vl['e'] = 'no';

			$query_DtRg = sprintf('SELECT id_tracolus, tracolus_enc
								   		FROM '._BdStr(DBM).TB_TRA_COL_US.'
									WHERE tracolus_tracol = %s AND
										  tracolus_us = %s AND
										  tracolus_tp = %s
								  	LIMIT 1',
										GtSQLVlStr($this->tra_col,'int'),
										GtSQLVlStr($this->tra_col_us,'int'),
										GtSQLVlStr($this->tra_col_tp,'int'));

			$DtRg = $__cnx->_qry($query_DtRg);

			if($DtRg){
				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;

				$Vl['tot'] = $Tot_DtRg;

				if($Tot_DtRg > 0){
					$Vl['e'] = 'ok';
					$Vl['id'] = $row_DtRg['id_tracolus'];
					$Vl['enc'] = ctjTx($row_DtRg['tracolus_enc'],'in');
				}
			}
			$__cnx->_clsr($DtRg);

		}

		return(_jEnc($Vl));
	}

	public function GtTraColUs_In($p=NULL){

		global $__cnx;

		$rsp['e'] = 'no';

		$__enc = Enc_Rnd( $this->tra_col_us.'-'.$this->tra_col_tp.'-'.$this->tra_col);

		$query_DtRg = sprintf("INSERT INTO "._BdStr(DBM).TB_TRA_COL_US."
							(tracolus_enc, tracolus_tracol, tracolus_us, tracolus_tp) VALUES
							(%s, %s, %s, %s)",
						GtSQLVlStr($__enc, "text"),
						GtSQLVlStr($this->tra_col, "int"),
						GtSQLVlStr($this->tra_col_us, "int"),
						GtSQLVlStr($this->tra_col_tp, "int"));

		$Result = $__cnx->_prc($query_DtRg);

		if($Result){
			$rsp['i'] = $__cnx->c_p->insert_id;
			$rsp['e'] = 'ok';
			$rsp['m'] = 1;
		}else{
			$rsp['m'] = 2;
			$rsp['w'] = $__cnx->c_p->error;
			$rsp['w_n'] = $__cnx->c_p->errno;
		}

		return _jEnc($rsp);
	}

	public function GtTraColUs_Del($p=NULL){

		global $__cnx;

		$rsp['e'] = 'no';

		$query_DtRg = sprintf("DELETE FROM "._BdStr(DBM).TB_TRA_COL_US."
									WHERE
										tracolus_tracol = %s AND
										tracolus_us = %s AND
										tracolus_tp = %s",
									GtSQLVlStr($this->tra_col, "int"),
									GtSQLVlStr($this->tra_col_us, "int"),
									GtSQLVlStr($this->tra_col_tp, "int"));

		$Result = $__cnx->_prc($query_DtRg);

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


	public function GtTraColRsp($p=NULL){

	    global $__cnx;

	    $Vl['e'] = 'no';

	    if(!isN($this->tra_col)){

			$query_DtRg = "
					SELECT id_us, us_nm, us_ap, us_enc,

							(
								SELECT COUNT(*)
								FROM "._BdStr(DBM).TB_TRA_RSP."
									 INNER JOIN "._BdStr(DBM).TB_TRA." ON trarsp_tra=id_tra
								WHERE trarsp_us=id_us AND tra_col = '".$this->tra_col."'
							) AS _tot_now,

							"._QrySisSlcF([ 'als'=>'t', 'als_n'=>'type' ]).",
							".GtSlc_QryExtra([ 't'=>'fld', 'p'=>'type', 'als'=>'t' ])."
					FROM	"._BdStr(DBM).TB_TRA_COL_US."
							INNER JOIN "._BdStr(DBM).TB_US." ON tracolus_us = id_us
							".GtSlc_QryExtra([ 't'=>'tb', 'col'=>'tracolus_tp', 'als'=>'t' ])."
					WHERE tracolus_tracol = '".$this->tra_col."'
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
							$Vl['us'][$__type_go['key']->vl]['ls'][ $__id ]['now']['tot'] = $row_DtRg['_tot_now'];
							$Vl['us'][$__type_go['key']->vl]['tot']++;
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

	public function Del_Tra_Fle($p=NULL){

		global $__cnx;

		$rsp['e'] = 'no';

		if( !isN($p['id']) ){

			if( !isN( $p['tp'] ) && $p['tp'] == 'id' ){
				$__fl .= sprintf(' id_mdlcntattch=%s ', GtSQLVlStr($p['id'], "int"));
			}else if( !isN( $p['tp'] ) && $p['tp'] == 'enc' ){
				$__fl .= sprintf(" mdlcntattch_enc=%s ", GtSQLVlStr($p['tra'], "int"));
			}

			if(!isN( $__fl )){

				$query_DtRg = sprintf("DELETE FROM ".TB_MDL_CNT_ATTCH." WHERE $__fl");
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

	public function TraColUsOrd($p=NULL){

		global $__cnx;

		$rsp['e'] = 'no';

		$TraColDt = GtTraColDt(['id'=>$p['id'], 't'=>'enc', 'prvt'=>'ok']);
		$__tra_ord = __LsDt(['k'=>'tra_ord', 'id'=>$p['tp_ord'], 'tp'=>'enc', 'no_lmt'=>'ok' ]);

		if( !isN($TraColDt->id) && !isN($__tra_ord->d->id) ){

			$_chk = $this->Chk_TraColUsOrd([ 'tracol'=>$TraColDt->id ]);

			if(isN($_chk->id)){
				$__in = $this->TraColUsOrd_In([ 'tracol'=>$TraColDt->id, 'tra_ord'=>$__tra_ord->d->id ]);
				if($__in->e == 'ok'){ $rsp['e'] = 'ok'; }
			}elseif(!isN($_chk->id)){
				$__upd = $this->TraColUsOrd_Upd([ 'tracol'=>$TraColDt->id, 'tra_ord'=>$__tra_ord->d->id ]);
				if($__upd->e == 'ok'){ $rsp['upd']='ok'; $rsp['e']='ok'; }else{ $rsp['e']='no'; }
			}

		}else{

			$rsp['w'] = 'No all data';

		}

		return _jEnc($rsp);
	}

	public function Chk_TraColUsOrd($p=NULL){

		global $__cnx;

		if(!isN($p['tracol'])){

			$query_DtRg = sprintf("	SELECT
										id_tracolus
									FROM "._BdStr(DBM).TB_TRA_COL_US."
										INNER JOIN "._BdStr(DBM).TB_SIS_SLC." ON tracolus_traord = id_sisslc
									WHERE
										tracolus_tracol=%s AND
										tracolus_us=%s
									LIMIT 1",
										GtSQLVlStr($p['tracol'],'int'),
										GtSQLVlStr(SISUS_ID,'int'));

			$DtRg = $__cnx->_prc($query_DtRg);

			if($DtRg){

				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;

				$rsp['e'] = 'ok';
				$rsp['tot'] = $Tot_DtRg;

				if($Tot_DtRg > 0){
					$rsp['id'] = $row_DtRg['id_tracolus'];
				}

			}else{

				$rsp['w'][] = 'Error on:'.$__cnx->c_p->error;

			}
		}

		return _jEnc($rsp);

		$__cnx->_clsr($DtRg);

	}

	public function TraColUsOrd_In($p=NULL){

		global $__cnx;

		$rsp['e'] = 'no';

		$__enc = Enc_Rnd( $p['tracol'].' - '.$p['tra_ord'] );

		$query_DtRg = sprintf("INSERT INTO "._BdStr(DBM).TB_TRA_COL_US." (tracolus_enc, tracolus_tracol, tracolus_tp, tracolus_us, tracolus_traord) VALUES (%s, %s, %s, %s, %s)",
						GtSQLVlStr($__enc, "text"),
						GtSQLVlStr($p['tracol'], "int"),
						GtSQLVlStr(_CId('ID_USROL_OBS'), "int"),
						GtSQLVlStr(SISUS_ID, "int"),
						GtSQLVlStr($p['tra_ord'], "int"));

		$Result = $__cnx->_prc($query_DtRg);

		if($Result){
			$rsp['i'] = $__cnx->c_p->insert_id;
			$rsp['e'] = 'ok';
			$rsp['m'] = 1;
		}else{
			$rsp['m'] = 2;
			$rsp['w'] = $__cnx->c_p->error;
			$rsp['w_n'] = $__cnx->c_p->errno;
		}

		return _jEnc($rsp);
	}

	public function TraColUsOrd_Upd($p=NULL){

		global $__cnx;

		$rsp['e'] = 'no';

		$updateSQL = sprintf("UPDATE "._BdStr(DBM).TB_TRA_COL_US." SET tracolus_traord=%s WHERE tracolus_tracol=%s AND tracolus_us=%s",
								GtSQLVlStr($p['tra_ord'], "int"),
								GtSQLVlStr($p['tracol'], "int"),
								GtSQLVlStr(SISUS_ID, "int")
							);

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

	public function In_TraCtrl(){

		global $__cnx;

		$rsp['e'] = 'no';

		$_tra = Php_Ls_Cln($this->tra);
		$_v = Php_Ls_Cln($this->vl);
		$_ord = Php_Ls_Cln($this->ord);
		$_id_cntrl = Php_Ls_Cln($this->id_cntrl);

		if(!isN($_v) && !isN($_tra)){

			$_enc_ctrl = Enc_Rnd($_v);

			$query_DtRg = sprintf("INSERT INTO "._BdStr(DBM).TB_TRA_CTRL." (tractrl_tt, tractrl_enc, tractrl_est, tractrl_ord, tractrl_tra, tractrl_mdlctrl) VALUES(%s, %s, %s, %s, %s, %s) ",
								GtSQLVlStr(ctjTx($_v,'out'), "text"),
								GtSQLVlStr(ctjTx( $_enc_ctrl ,'out'), "text"),
								GtSQLVlStr(2, "int"),
								GtSQLVlStr($_ord, "int"),
								GtSQLVlStr($_tra, "int"),
								GtSQLVlStr($_id_cntrl, "int"));

			$DtRg = $__cnx->_prc($query_DtRg);

			if($DtRg){
				$rsp['i'] = $__cnx->c_p->insert_id;
				$rsp['e'] = 'ok';
				$rsp['m'] = 1;
			}else{
				$rsp['m'] = 2;
				$rsp['w'] = $__cnx->c_p->error;
				$rsp['w_n'] = $__cnx->c_p->errno;
			}
		}else{
			$rsp['tra'] = $this->tra_enc;
		}

		return _jEnc($rsp);

	}

	//----------- Modificar Brand -----------//
	public function Upd_Tra_Sbrnd($p=NULL){

		global $__cnx;

		if(!isN($p['tra'])){

			$updateSQL = sprintf("UPDATE "._BdStr(DBM).TB_TRA." SET tra_sbrnd=%s WHERE id_tra=%s",
							GtSQLVlStr($p['brnd'], "int"),
							GtSQLVlStr($p['tra'], "int"));

			$Result = $__cnx->_prc($updateSQL);
			if($Result){
				$rsp['e'] = 'ok';
				$rsp['m'] = 1;
				/*$this->_aud->In_Aud([ 'aud'=>_Cns('ID_AUDDSC_TRA_MOD'), "db"=>$this->db, "post"=>$this->post, "icn"=>"tra_up", "iddb"=>$rsp['i']]);*/
			}else{
				$rsp['e'] = 'no';
				$rsp['m'] = 2;
				$rsp['w'] = $__cnx->c_p->error;
				_ErrSis(['p'=>$updateSQL, 'd'=>$__cnx->c_p->error]);
			}
		}

		return _jEnc($rsp);

	}

	//----------- Modificar Columna -----------//
	public function Upd_TraCol($p=NULL){

		global $__cnx;

		if(!isN($p['tra'])){

			$updateSQL = sprintf("UPDATE "._BdStr(DBM).TB_TRA." SET tra_col=%s, tra_chk_rsp=2 WHERE id_tra=%s",
							GtSQLVlStr($p['col'], "int"),
							GtSQLVlStr($p['tra'], "int"));

			$Result = $__cnx->_prc($updateSQL);
			if($Result){
				$rsp['e'] = 'ok';
				$rsp['m'] = 1;
				/*$this->_aud->In_Aud([ 'aud'=>_Cns('ID_AUDDSC_TRA_MOD'), "db"=>$this->db, "post"=>$this->post, "icn"=>"tra_up", "iddb"=>$rsp['i']]);*/
			}else{
				$rsp['e'] = 'no';
				$rsp['m'] = 2;
				$rsp['w'] = $__cnx->c_p->error;
				_ErrSis(['p'=>$updateSQL, 'd'=>$__cnx->c_p->error]);
			}
		}

		return _jEnc($rsp);

	}

}



function Tra_Tag_Html($t=NULL,$p=NULL){

	if($t == 'a-lft'){
		$__html = '<svg viewBox="0 0 14 24" style="height:16px;width:9px;color:'.$p['sty'].';" ><g fill="none" fill-rule="evenodd" stroke="none" stroke-width="1"><g fill="currentColor" transform="translate(-518 -405)"><g transform="translate(0 17)"><g transform="translate(460 54)"><g transform="translate(0 253)"><g transform="translate(58 81)"><path d="M14,0 L11.9906225,0 C10.897651,0 9.42841797,0.685898435 8.72333581,1.53199703 L1.27666419,10.468003 C0.573560353,11.3117276 0.571582029,12.6858984 1.27666419,13.531997 L8.72333581,22.468003 C9.42643965,23.3117276 10.8912321,24 11.9906225,24 L14,24 L14,-2.22044605e-16 Z"></path></g></g></g></g></g></g></svg>';
	}elseif($t == 'a-up'){
		$__html = '<svg width="26" height="15" style="transform: rotate(180deg); '.$p['sty'].'"><polygon fill="rgba(0,0,0,0.1)" points="0,0 26,0 13,15"></polygon> <polygon fill="#fff" points="1,0 25,0 13,13.5"></polygon></svg>';
	}elseif($t == 'a-dwn'){
		$__html = '<svg class="maxw-100% white icon-context-menu" viewBox="0 0 2048 2048" style="margin-top:14px; height:8px; width:8px;"><path d="M0 0l1024 1024 1024-1024h-2048z"></path></svg>';
	}

	return $__html;

}


?>