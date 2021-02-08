<?php

	class CRM_Us {

	    function __construct() {

		    /*global $__cnx;

	        $this->c_r = $__cnx->c_r;
			$this->c_p = $__cnx->c_p;*/

			$this->cl = GtClDt(Gt_SbDMN(), "sbd");
	    }

	    function __destruct() {

	   	}


	   	public function UsChk($p=NULL){

		   	global $__cnx;

			   $Vl['e'] = 'no';

			if(!isN($p)){

				if($p['user'] != NULL){ $__f .= sprintf(' AND us_user=%s ', GtSQLVlStr($p['user'], 'text')); }

				$query_DtRg = '	SELECT * FROM '._BdStr(DBM).TB_US.' WHERE id_us != "" '.$__f;

				$DtRg = $__cnx->_qry($query_DtRg);

				if($DtRg){
					$row_DtRg = $DtRg->fetch_assoc();
					$Tot_DtRg = $DtRg->num_rows;
					if($Tot_DtRg > 0){
						$Vl['e'] = 'ok';
						$Vl['id'] = $row_DtRg['id_us'];
						$Vl['enc'] = $row_DtRg['us_enc'];
					}
				}

				$__cnx->_clsr($DtRg);
			}

			return _jEnc($Vl);
		}



		public function UsClChk($p=NULL){

			global $__cnx;

			if(!isN($p)){
				$Vl['e'] = 'no';

				if($p['us'] != NULL){ $__f .= sprintf(' AND uscl_us= %s ', GtSQLVlStr($p['us'], 'int')); }
				if($p['cl'] != NULL){ $__f .= sprintf(' AND uscl_cl= %s ', GtSQLVlStr($p['cl'], 'int')); }

				$query_DtRg = '	SELECT * FROM '._BdStr(DBM).TB_US_CL.' WHERE id_uscl != "" '.$__f;

				$DtRg = $__cnx->_qry($query_DtRg);

				if($DtRg){
					$row_DtRg = $DtRg->fetch_assoc();
					$Tot_DtRg = $DtRg->num_rows;
					if($Tot_DtRg > 0){
						$Vl['e'] = 'ok';
						$Vl['id'] = $row_DtRg['id_uscl'];
					}
				}
				$__cnx->_clsr($DtRg);
			}
			return _jEnc($Vl);
		}


		public function UsCl($p=NULL){

			global $__cnx;

			$rsp['e'] = 'no';
			$rsp['cl_id'] = $this->cl->id;
			$rsp['us_id_upd'] = $this->us_id_upd;

			if(!isN($this->cl->id) && !isN($this->us_id_upd)){

				$_chk = $this->UsClChk([ 'us'=>$this->us_id_upd, 'cl'=>$this->cl->id ]);

				if($_chk->e != 'ok'){

					$_sql_s = sprintf("INSERT INTO "._BdStr(DBM).TB_US_CL." (uscl_us, uscl_cl) VALUES (%s, %s)",
										   GtSQLVlStr($this->us_id_upd, "int"),
										   GtSQLVlStr($this->cl->id, "int"));

					if(!isN($_sql_s)){ $Result_RLC = $__cnx->_prc($_sql_s); }

					if($Result_RLC){
						$rsp['e'] = 'ok';
					}else{
						$rsp['w'] = 'No result:'.$__cnx->c_p->error;
					}

				}

			}

			return _jEnc($rsp);

		}

		public function UsP($p=NULL){

		    global $__cnx;

		    $rsp['e'] = 'no';

		    if(!isN($this->us_user)){

				$this->us_user = strtolower($this->us_user);

				if($p['t'] != 'upd'){

	                $__enc = Enc_Rnd( $this->us_user );

	                $_sql_s = sprintf("INSERT INTO "._BdStr(DBM).TB_US." (us_enc, us_user, us_clr, us_nm, us_ap, us_fn, us_pass, us_nivel, us_est, us_age, us_frm, us_crg, us_gnr, us_chk_pqr, us_chk_tck, us_msv_user) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
				                       GtSQLVlStr(ctjTx($__enc,'out'), "text"),
									   GtSQLVlStr(ctjTx($this->us_user,'out'), "text"),
									   GtSQLVlStr(Gn_Rnd_Clr(), "text"),
									   GtSQLVlStr(ctjTx($this->us_nm,'out'), "text"),
									   GtSQLVlStr(ctjTx($this->us_ap,'out'), "text"),
									   GtSQLVlStr($this->us_fn, "date"),
									   GtSQLVlStr(enCad($this->us_pass), "text"),
									   GtSQLVlStr(ctjTx($this->us_nivel,'out'), "text"),
									   GtSQLVlStr($this->us_est, "int"),
									   GtSQLVlStr($this->us_age, "int"),
									   GtSQLVlStr(ctjTx($this->us_frm,'out'), "text"),
									   GtSQLVlStr(ctjTx($this->us_crg,'out'), "text"),
									   GtSQLVlStr($this->us_gnr, "int"),
									   GtSQLVlStr($this->tracol_chk_pqr, "int"),
									   GtSQLVlStr($this->tracol_chk_tck, "int"),
									   GtSQLVlStr($this->us_msv_user, "text"));

					$_t = "ing";

				}else{

					$_sql_s = sprintf("UPDATE "._BdStr(DBM).TB_US." SET us_user=%s, us_fn=%s, us_nm=%s, us_ap=%s, us_gnr=%s, us_est=%s, us_nivel=%s, us_chk_pqr=%s, us_chk_tck=%s, us_chk_obs=%s, us_msv_user=%s WHERE id_us=%s",
										GtSQLVlStr(ctjTx($this->us_user,'out'), "text"),
										GtSQLVlStr($this->us_fn, "date"),
									   	GtSQLVlStr(ctjTx($this->us_nm,'out'), "text"),
									  	GtSQLVlStr(ctjTx($this->us_ap,'out'), "text"),
									   	GtSQLVlStr($this->us_gnr, "int"),
									   	GtSQLVlStr($this->us_est, "int"),
									   	GtSQLVlStr($this->us_nivel, "text"),
									   	GtSQLVlStr($this->us_chk_pqr, "int"),
									   	GtSQLVlStr($this->us_chk_tck, "int"),
									  	GtSQLVlStr($this->us_chk_obs, "int"),
									   	GtSQLVlStr($this->us_msv_user, "text"),
									   	GtSQLVlStr($this->us_id_upd, "int"));

				}

				if(!isN($_sql_s)){ $Result_RLC = $__cnx->_prc($_sql_s); }

				if($Result_RLC){

					if($p['t'] != 'upd'){ $rsp['i'] = $this->us_id_upd = $__cnx->c_p->insert_id; }
					$rsp['t'] = $_t;

					$__enc_us = $__enc = enCad( $this->us_id_upd . $this->us_user . $this->us_nivel );

					$_sql_u = sprintf("UPDATE "._BdStr(DBM).TB_US." SET us_enc=%s WHERE id_us=%s",
				                       GtSQLVlStr($__enc, "text"),
									   GtSQLVlStr($this->us_id_upd, "int"));

					$__upd_q = $__cnx->_prc($_sql_u);

					if($__upd_q){

						$rsp['e'] = 'ok';

						if($p['t'] != 'upd'){
							$rsp['enc'] = $__enc_us;
						}

					}else{
						$rsp['w'][] = $__cnx->c_p->error;
					}

				}else{
					$rsp['w'][] = 'No result:'.$__cnx->c_p->error;
				}
			}else{
				$rsp['w'][] = TX_FLTDTINC;
			}
			return _jEnc($rsp);
	    }


		public function Us($p=NULL){

			$__chk = $this->UsChk([ 'user'=>$this->us_user ]);
			$rsp['inf'] = $__chk;

			if($__chk->e == 'ok'){
				$rsp['in'] = 'out';
			}else{
				$rsp['in'] = 'ok';
				$__chk = $this->UsP();
			}

			if(!isN($__chk->id)){
				$this->us_id_upd = $__chk->id;
				$__chk_upd = $this->UsP([ 't'=>'upd' ]);

				if($__chk_upd->e == 'ok'){
					$rsp['e'] = 'ok';
				}else{
					$rsp['w'] = $__chk_upd->w;
				}
			}


			if($__chk->e == 'ok'){

				$__us_cl = $this->UsCl();

				if($__us_cl->e == 'ok'){

					$rsp['e'] = 'ok';
					$rsp['prc'] = $__chk;
					$rsp['id'] = $__chk->id;
					$rsp['i'] = $__chk->i;

					if($__chk->t == "ing"){
						$this->i = $__chk->i;
						$rsp['cc'] = $this->i;
						$__chk_dsh = $this->Us_Dsh();
					}

					$rsp['enc'] = $__chk->enc;
					$rsp['upd'] = 'ok';

				}else{

					$rsp['w'] = $__us_cl->w;

				}

			}else{
				$rsp['w'] = $__chk->w;
			}

			return _jEnc($rsp);

		}




		public function GtUsActLs(){

			global $__cnx;

		     if(!isN($this->act_enc)){


				$query_DtRg =  sprintf("
										SELECT *,(
											SELECT COUNT(*)
											FROM "._BdStr(DBM).TB_ACT_RSP."
											WHERE  actrsp_us = id_us
											AND actrsp_act IN(
												SELECT
													id_act
												FROM
													"._BdStr(DBM).TB_ACT."
												WHERE
													act_enc = %s
											)
										) AS tot
										FROM "._BdStr(DBM).MDL_US_BD."
							",
							GtSQLVlStr(ctjTx($this->act_enc,'out'), "text"));


				$DtRg = $__cnx->_qry($query_DtRg);

				if($DtRg){
					$row_DtRg = $DtRg->fetch_assoc();
					$Tot_DtRg = $DtRg->num_rows;
					$Vl['tot'] = $Tot_DtRg;

					if($Tot_DtRg > 0){
						$Vl['e'] = 'ok';
						do{
							$Vl['ls'][$row_DtRg['us_enc']]['enc'] = $row_DtRg['us_enc'];
							$Vl['ls'][$row_DtRg['us_enc']]['nm'] = $row_DtRg['us_nm'];
							$Vl['ls'][$row_DtRg['us_enc']]['eml'] = $row_DtRg['us_user'];
							$Vl['ls'][$row_DtRg['us_enc']]['ap'] = ctjTx($row_DtRg['us_ap'],'in');
							$Vl['ls'][$row_DtRg['us_enc']]['tot'] = $row_DtRg['tot'];
						}while($row_DtRg = $DtRg->fetch_assoc());
					}
				}
				$__cnx->_clsr($DtRg);
			}

			return _jEnc($Vl);

		}

		public function _Us_In($p=NULL){

			global $__cnx;

			$__enc = Enc_Rnd($this->mdlsprd_cl.'-'.$this->mdlsprd_nm);

			$query_DtRg =   sprintf("INSERT INTO "._BdStr(DBM).TB_ACT_RSP." (actrsp_act, actrsp_us)
									VALUES
									(
										(SELECT id_act from "._BdStr(DBM).TB_ACT." where act_enc = %s),
										(SELECT id_us  from "._BdStr(DBM).TB_US." where us_enc = %s)
									)
							",
							GtSQLVlStr(ctjTx($this->act_enc,'out'), "text"),
							GtSQLVlStr(ctjTx($this->us_enc,'out'), "text"));

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


		public function _Us_Eli($p=NULL){

			global $__cnx;

			$query_DtRg =   sprintf("DELETE FROM "._BdStr(DBM).TB_ACT_RSP."  WHERE
								actrsp_act = (SELECT id_act FROM "._BdStr(DBM).TB_ACT." WHERE act_enc = %s)
								AND actrsp_us = (SELECT id_us  from "._BdStr(DBM).TB_US." where us_enc = %s)",
								GtSQLVlStr($this->act_enc, "text"),
								GtSQLVlStr($this->us_enc, "text"));

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


		public function Us_Dsh($p=NULL){

			global $__cnx;

			$___id_us = $this->i;

			$GtDshDt = GtDshLs([ "tp"=>"null" ]);

			if($GtDshDt->dsh_ord_ult > 0 && $GtDshDt->dsh_ord_ult != '' && $GtDshDt->dsh_ord_ult != NULL){
				$_ult = ($GtDshDt->dsh_ord_ult+1);
			}else{
				$_ult = 1;
			}

			//Insertar una fila DashBoard
			$__enc_1 = Enc_Rnd($___id_us.$_ult);

			$query_DtRg = "INSERT INTO "._BdStr(DBM).TB_DSH." (dsh_us, dsh_ord, dsh_enc) VALUES (".$___id_us.", ".$_ult.", '".$__enc_1."')";
			$DtRg = $__cnx->_prc($query_DtRg);
			$_id_prnt = $__cnx->c_p->insert_id;

			if($DtRg){

				//Insertar una Columna
				$__enc_2 = Enc_Rnd($___id_us.$_id_prnt);

				$_qry_col = "INSERT INTO "._BdStr(DBM).TB_DSH_COL." (dshcol_dsh, dshcol_ord, dshcol_us, dshcol_enc) VALUES (".$_id_prnt.", 1, ".$___id_us.", '".$__enc_2."')";
				$query_upd = "UPDATE  "._BdStr(DBM).TB_DSH." SET dsh_coltp = 1 WHERE id_dsh = ".$_id_prnt."";
				$DtRg_col = $__cnx->_prc($_qry_col);
				$_id_prnt = $__cnx->c_p->insert_id;

				$DtRg_upd = $__cnx->_prc($query_upd);

				//Segunda Fila

				$GtDshDtPrnt = GtDshLs([ "tp"=>"dsh_prnt", "dsh_prnt"=>$_id_prnt ]);

				if($GtDshDtPrnt->dsh_ord_ult > 0 && $GtDshDtPrnt->dsh_ord_ult != '' && $GtDshDtPrnt->dsh_ord_ult != NULL){
					$_ultPrnt = ($GtDshDtPrnt->dsh_ord_ult+1);
				}else{
					$_ultPrnt = 1;
				}

				//Insertar segunda fila
				$__enc_3 = Enc_Rnd($_id_prnt.$___id_us.$_ultPrnt);

				$query_DtRgPrnt = "INSERT INTO "._BdStr(DBM).TB_DSH." (dsh_us, dsh_prnt, dsh_ord, dsh_enc) VALUES (".$___id_us.", ".$_id_prnt.", ".$_ultPrnt.", '".$__enc_3."')";

				$DtRgPrnt = $__cnx->_prc($query_DtRgPrnt);
				$_id_dsh = $__cnx->c_p->insert_id;

				if($DtRg){



					$__enc_4 = Enc_Rnd($_id_dsh.'1'.$___id_us);

					$_qry_col_prnt = "INSERT INTO "._BdStr(DBM).TB_DSH_COL." (dshcol_dsh, dshcol_ord, dshcol_us, dshcol_enc) VALUES (".$_id_dsh.", 1, ".$___id_us.", '".$__enc_4."')";
					$DtRg_col_prnt = $__cnx->_prc($_qry_col_prnt);
					      $_id_col = $__cnx->c_p->insert_id;

					$__enc_5 = Enc_Rnd($_id_dsh.'2'.$___id_us);

					$_qry_col_prnt1 = "INSERT INTO "._BdStr(DBM).TB_DSH_COL." (dshcol_dsh, dshcol_ord, dshcol_us, dshcol_enc) VALUES (".$_id_dsh.", 2, ".$___id_us.", '".$__enc_5."')";
					$DtRg_col_prnt1 = $__cnx->_prc($_qry_col_prnt1);
						  $_id_col1 = $__cnx->c_p->insert_id;

					$query_upd_prnt = "UPDATE  "._BdStr(DBM).TB_DSH." SET dsh_coltp = 2 WHERE id_dsh = ".$_id_dsh."";

					$DtRg_upd_prnt = $__cnx->_prc($query_upd_prnt);



					$__enc_6 = Enc_Rnd($_id_col.'3'.$___id_us);

					$query_DtRg = "INSERT INTO "._BdStr(DBM).TB_DSH_COL_BX." (dshcolbx_dshcol, dshcolbx_us, dshcolbx_enc) VALUES (".$_id_col.", ".$___id_us.", '".$__enc_6."')";

					$DtRg = $__cnx->_prc($query_DtRg);
					$_id_col_grf1 = $__cnx->c_p->insert_id;

					$__enc_7 = Enc_Rnd($_id_col1.'4'.$___id_us);

					$query_DtRg = "INSERT INTO "._BdStr(DBM).TB_DSH_COL_BX." (dshcolbx_dshcol, dshcolbx_us, dshcolbx_enc) VALUES (".$_id_col1.", ".$___id_us.", '".$__enc_7."')";

					$DtRg = $__cnx->_prc($query_DtRg);
					$_id_col_grf2 = $__cnx->c_p->insert_id;


					$_enc_dsh = enCad($_id_col.'DsH');
					$_enc_dsh1 = enCad($_id_col1.'DsH');

					$query_DtRg_Grf = sprintf("INSERT INTO "._BdStr(DBM).TB_DSH_GRPH_BX." (
					dshgrphbx_enc, dshgrphbx_tt, dshgrphbx_bx, dshgrphbx_grph,
					dshgrphbx_mtrc, dshgrphbx_us, dshgrphbx_clr_bc, dshgrphbx_clr) VALUES
					(%s, %s, %s, %s, %s, %s, %s, %s) , (%s, %s, %s, %s, %s, %s, %s, %s)",
						GtSQLVlStr($_enc_dsh, "text"),
						GtSQLVlStr('Usuarios Activos', "text"),
						GtSQLVlStr($_id_col_grf1, "int"),
						GtSQLVlStr(2, "int"),
						GtSQLVlStr(15, "int"),
						GtSQLVlStr($___id_us, "int"),
						GtSQLVlStr('#dadada', "text"),
						GtSQLVlStr('#000000', "text"),
						GtSQLVlStr($_enc_dsh1, "text"),
						GtSQLVlStr('Usuarios Ingreso', "text"),
						GtSQLVlStr($_id_col_grf2, "int"),
						GtSQLVlStr(5, "int"),
						GtSQLVlStr(9, "int"),
						GtSQLVlStr($___id_us, "int"),
						GtSQLVlStr('#dadada', "text"),
						GtSQLVlStr('#000000', "text"));

					$DtRg = $__cnx->_prc($query_DtRg_Grf);

				}
			}

		}


		public function UsFrgtChk($p=NULL){

			global $__cnx;

			$Vl['e'] = 'no';

		 	if(!isN($p) && !isN($p['id'])){

				if($p['t'] == 'enc'){ $__f = 'usfrgt_enc'; $__ft = 'text'; }

			 	$query_DtRg = sprintf("	SELECT id_usfrgt, usfrgt_enc, usfrgt_e, usfrgt_fi, usfrgt_fa, id_us, us_enc
										FROM "._BdStr(DBM).TB_US_FRGT."
											 INNER JOIN "._BdStr(DBM).TB_US." ON usfrgt_us=id_us
										WHERE {$__f} = %s", GtSQLVlStr($p['id'], $__ft));

				$DtRg = $__cnx->_qry($query_DtRg);

				if($DtRg){

					$row_DtRg = $DtRg->fetch_assoc();
					$Tot_DtRg = $DtRg->num_rows;

				 	if($Tot_DtRg > 0){

						$Vl['e'] = 'ok';
						$Vl['id'] = $row_DtRg['id_usfrgt'];
						$Vl['us']['id'] = $row_DtRg['id_us'];
						$Vl['us']['enc'] = $row_DtRg['us_enc'];
						$Vl['enc'] = $row_DtRg['usfrgt_enc'];
						$Vl['on'] = mBln($row_DtRg['usfrgt_e']);
						$Vl['fi'] = $row_DtRg['usfrgt_fi'];
						$Vl['fa'] = $row_DtRg['usfrgt_fa'];

						$_f1 = new DateTime($row_DtRg['usfrgt_fi']);
						$_f2 = new DateTime(SIS_F_TS);
						$dif = $_f1->diff($_f2);

						if($dif->days > 0 || $dif->h > 0 || $dif->i > 59 || mBln($row_DtRg['usfrgt_e']) == 'no'){
							$Vl['hb'] = 'no';
						}else{
							$Vl['hb'] = 'ok';
						}

				 	}
			 	}

				$__cnx->_clsr($DtRg);
		 	}

			return _jEnc($Vl);

	 	}

		public function UsFrgt($p=NULL){

		    global $__cnx;

		    $rsp['e'] = 'no';

		    if(!isN($p['us'])){

				$__enc = Enc_Rnd($p['us']);

				$_sql_s = sprintf("INSERT INTO "._BdStr(DBM).TB_US_FRGT." (usfrgt_enc, usfrgt_us, usfrgt_eml, usfrgt_tel) VALUES (%s, %s, %s, %s)",
									GtSQLVlStr(ctjTx($__enc,'out'), "text"),
									GtSQLVlStr($p['us'], "int"),
									GtSQLVlStr(!isN($p['eml'])?$p['eml']:2, "int"),
									GtSQLVlStr(!isN($p['tel'])?$p['tel']:2, "int"));

				$Result_RLC = $__cnx->_prc($_sql_s);

				if($Result_RLC){
					$rsp['e'] = 'ok';
					$rsp['id'] = $__enc;
					//$rsp['i'] = $__cnx->c_p->insert_id;
				}else{
					$rsp['w'] = $__cnx->c_p->error;
				}

			}else{
				$rsp['w'] = TX_FLTDTINC;
			}
			return _jEnc($rsp);
		}


		public function UsFrgtUpd($p=NULL){

			global $__cnx;

			if(!isN($p['id'])){

				$insertSQL = sprintf("UPDATE "._BdStr(DBM).TB_US_FRGT." SET usfrgt_e=%s WHERE usfrgt_enc=%s",
												GtSQLVlStr(2, "text"),
												GtSQLVlStr($p['id'], "text"));

				$Result = $__cnx->_prc($insertSQL);

				if($Result){
					$rsp['e'] = 'ok';
				}else{
					$rsp['e'] = 'no';
				}

			}

			return _jEnc($rsp);
		}


	}
?>