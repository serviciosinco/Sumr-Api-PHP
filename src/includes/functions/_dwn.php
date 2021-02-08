<?php

	function _Dwn_S($p=NULL){

		global $__cnx;

		if(!isN($p['t'])){

			if($p['e_s'] == 1){ $_snd_e = '1'; }else{ $_snd_e = '2'; }
			if($p['vl_p'] == 1){ $_vl_p = '1'; }else{ $_vl_p = '2'; }
			if(!isN($p['vl_t_p'])){ $_vl_t_p = $p['vl_t_p']; }else{ $_vl_t_p = ''; }

			if($p['vl_t_d_1'] == 1){ $_vl_p_d_1 = '1'; }else{ $_vl_p_d_1 = '2'; }
			if($p['vl_t_d_2'] == 1){ $_vl_p_d_2 = '1'; }else{ $_vl_p_d_2 = '2'; }
			if($p['vl_t_d_3'] == 1){ $_vl_p_d_3 = '1'; }else{ $_vl_p_d_3 = '2'; }
			if($p['vl_t_d_4'] == 1){ $_vl_p_d_4 = '1'; }else{ $_vl_p_d_4 = '2'; }
			if($p['vl_t_d_5'] == 1){ $_vl_p_d_5 = '1'; }else{ $_vl_p_d_5 = '2'; }
			if($p['vl_t_d_6'] == 1){ $_vl_p_d_6 = '1'; }else{ $_vl_p_d_6 = '2'; }
			if($p['vl_t_d_7'] == 1){ $_vl_p_d_7 = '1'; }else{ $_vl_p_d_7 = '2'; }

			if($p['vl_t_bfr'] == 1){ $_vl_t_bfr = '1'; }else{ $_vl_t_bfr = '2'; }

			if(!isN($p['us'])){ $_us = $p['us']; }else{ $_us = SISUS_ID; }


			$Qry = sprintf("INSERT INTO "._BdStr(DBD).TB_DWN."
										(dwn_enc, dwn_cl, dwn_tp, dwn_us, dwn_eml,
										dwn_tm_prg, dwn_tm_prg_vl, dwn_tm_prg_d_1,
										dwn_tm_prg_d_2, dwn_tm_prg_d_3, dwn_tm_prg_d_4,
										dwn_tm_prg_d_5, dwn_tm_prg_d_6, dwn_tm_prg_d_7,
										dwn_tm_prg_bfe)
									VALUES (%s, (SELECT id_cl FROM "._BdStr(DBM).TB_CL." WHERE cl_enc=%s) ,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s)",
								   GtSQLVlStr(Enc_Rnd($p['t'].'-'.SISUS_ID), "text"),
								   GtSQLVlStr(DB_CL_ENC, "text"),
								   GtSQLVlStr($p['t'], "text"),
								   GtSQLVlStr($_us, "int"),
								   GtSQLVlStr($_snd_e, "int"),
								   GtSQLVlStr($_vl_p, "int"),
								   GtSQLVlStr($_vl_t_p, "text"),
								   GtSQLVlStr($_vl_p_d_1, "int"),
								   GtSQLVlStr($_vl_p_d_2, "int"),
								   GtSQLVlStr($_vl_p_d_3, "int"),
								   GtSQLVlStr($_vl_p_d_4, "int"),
								   GtSQLVlStr($_vl_p_d_5, "int"),
								   GtSQLVlStr($_vl_p_d_6, "int"),
								   GtSQLVlStr($_vl_p_d_7, "int"),
								   GtSQLVlStr($_vl_t_bfr, "int"));

			$Result1 = $__cnx->_prc($Qry);

			if($Result1){

				$Vl['e'] = true;
				$Vl['id'] = $__cnx->c_p->insert_id;
				$Vl['tab'] = '_d_'.$Vl['id'];
				$Vl['tb'] = $Vl['id'];

				$updateSQL = sprintf("UPDATE "._BdStr(DBD).TB_DWN." SET dwn_tab=%s, dwn_tt=%s WHERE id_dwn=%s LIMIT 1",
						   	 GtSQLVlStr(ctjTx($Vl['tab'],'out'), "text"),
						   	 GtSQLVlStr(ctjTx(MDL_CNT.' '.$___Ls->tt.' - '.$_POST['_f_in'].'-'.$_POST['_f_out'],'out'), "text"),
						   	 GtSQLVlStr($Vl['id'], "int"));

				$Result_UPD = $__cnx->_prc($updateSQL);

			}else{
				$Vl['e'] = false;
				$Vl['w'] = $__cnx->c_p->error;
			}

		}else{
			$Vl['e'] = false;
		}

		return(_jEnc($Vl));
	}

	function _Dwn_His_S($p=NULL){

		global $__cnx;

		if(!isN($p['dwn'])){

			if($p['e_s'] == 1){ $_snd_e = '1'; }else{ $_snd_e = '2'; }

			$Qry = sprintf("INSERT INTO "._BdStr(DBD).TB_DWN_HIS." (dwnhis_enc, dwnhis_dwn, dwnhis_main, dwnhis_his) VALUES (%s, %s, %s, %s)",
								   GtSQLVlStr(Enc_Rnd($p['dwn'].'-'.SISUS_ID), "text"),
								   GtSQLVlStr($p['dwn'], "int"),
								   GtSQLVlStr(trim(compress_code($p['main'])), "text"),
								   GtSQLVlStr(trim(compress_code($p['his'])), "text"));

			$Result1 = $__cnx->_prc($Qry);

			if($Result1){

				$Vl['e'] = true;

			}else{
				$Vl['e'] = false;
				$Vl['w'] = $__cnx->c_p->error;
			}

		}else{
			$Vl['e'] = false;
		}

		return(_jEnc($Vl));
	}

	function UPD_Dwn_R($p=NULL){

		global $__cnx;

		if(!isN($p['d']) && !isN($p['r'])){

			if(!isN($p['e'])){
				$__upd_e = $p['e']; $__upd_f = 'id_dwnprc';
			}else{
				$__upd_e = 2; $__upd_f = '__dwn_i';
			}

			if(!isN($p['r_to'])){
				$__whr = sprintf('BETWEEN %s AND %s', GtSQLVlStr($p['r'], "int"), GtSQLVlStr($p['r_to'], "int"));
			}else{
				$__whr = sprintf('= %s LIMIT 1', GtSQLVlStr($p['r'], "int"));
			}

			$updateSQL = sprintf("UPDATE "._BdStr(DBD).$p['d']." SET __dwn_e=%s WHERE $__upd_f $__whr ",
					   GtSQLVlStr($__upd_e, "int"),
					   GtSQLVlStr($p['r'], "int")); echo compress_code( $updateSQL );

			$Result_UPD = $__cnx->_prc($updateSQL);

			if($Result_UPD){
				$rsp['e'] = 'ok';
			}else{
				$rsp['e'] = 'no'; $rsp['w'] = $updateSQL.' -> '.$__cnx->c_p->error;
			}

		}else{
			$rsp['e'] = 'no';
			$rsp['w'] = 'no data';
		}
		$rtrn = _jEnc($rsp);
		if(!isN($rtrn) && !isN($rtrn) && !empty($rtrn)){ return($rtrn); }
	}

	function UPD_Dwn($p=NULL){

		global $__cnx;

		if(!isN($p['i']) && (!isN($p['e']) || !isN($p['t_r']) || !isN($p['b']) || !isN($p['eli']) )){

			if(!isN( $p['tot'] )){ $_fld_u .= sprintf(', dwn_tot=%s', GtSQLVlStr($p['tot'], "text")); }

			if(!isN($p['e'])){

				if($p['e'] == 1){ $prc=1; }else{ $prc=2; }

				$updateSQL = sprintf("UPDATE "._BdStr(DBD).TB_DWN." SET dwn_est=%s, dwn_w=%s, dwn_prc=%s {$_fld_u} WHERE id_dwn=%s LIMIT 1",
						   GtSQLVlStr($p['e'], "int"),
						   GtSQLVlStr(ctjTx($p['w'],'out'), "text"),
						   GtSQLVlStr($prc, "int"),
						   GtSQLVlStr($p['i'], "int"));

			}elseif(!isN($p['eli'])){

				$updateSQL = sprintf("UPDATE "._BdStr(DBD).TB_DWN." SET dwn_eli=%s WHERE id_dwn=%s LIMIT 1",
						   GtSQLVlStr($p['eli'], "int"),
						   GtSQLVlStr($p['i'], "int"));

			}elseif(!isN($p['t_r'])){

				$updateSQL = sprintf("UPDATE "._BdStr(DBD).TB_DWN." SET dwn_tt=%s, dwn_r=%s, dwn_g=%s {$_fld_u} WHERE id_dwn=%s LIMIT 1",
						   GtSQLVlStr(ctjTx($p['tt'],'out'), "text"),
						   GtSQLVlStr($p['t_r'], "int"),
						   GtSQLVlStr(ctjTx($p['g'],'out'), "text"),
						   GtSQLVlStr($p['i'], "int"));

			}elseif(!isN($p['b'])){

				$updateSQL = sprintf("UPDATE "._BdStr(DBD).TB_DWN." SET dwn_blq=%s, dwn_blq_f=%s {$_fld_u} WHERE id_dwn=%s LIMIT 1",
						   GtSQLVlStr($p['b'], "int"),
						   GtSQLVlStr(SIS_F_D, "date"),
						   GtSQLVlStr($p['i'], "int"));

			}

			$Result_UPD = $__cnx->_prc($updateSQL);

			if($Result_UPD){

				$rsp['e'] = 'ok';

				$__dwn_u_dt = GtDwnDt([ 'id'=>$p['i'] ]);

				if(!isN($__dwn_u_dt->id)){

					$_ws = new CRM_Ws;

					$_ws->Send([
						'srv'=>'download',
						'act'=>'status',
						'to'=>[$__dwn_u_dt->us->enc],
						'sadmin'=>'ok',
						'data'=>[
							'dwn'=>[
								'id'=>$__dwn_u_dt->enc,
								'status'=>[
									'id'=>$__dwn_u_dt->est,
									'tt'=>$__dwn_u_dt->est_tt,
									'clr'=>$__dwn_u_dt->est_clr
								],
								'tot'=>$__dwn_u_dt->tot
							]
						]
					]);

				}

			}else{
				$rsp['e'] = 'no';
			}

			if($p['e'] == 1 && !Dvlpr()){

				$deleteSQL = sprintf('DROP TABLE IF EXISTS '._BdStr(DBD).'_d_'.$p['i']);
				$Result = $__cnx->_prc($deleteSQL);

				if($Result){
					$deleteSQL_His = sprintf('DROP TABLE IF EXISTS '._BdStr(DBD).'_d_'.$p['i'].'_his');
					$__cnx->_prc($deleteSQL_His);
				}

			}

		}else{
			$rsp['e'] = 'no';
		}

		$rtrn = _jEnc($rsp);
		if(!isN($rtrn) && !isN($rtrn) && !empty($rtrn)){ return($rtrn); }
	}


	function GtDwnDt_Tot($_p=NULL){

		global $__cnx;

		if(is_array($_p)){

			if(!isN($_p['d'])){

				$query_DtRg = "SELECT
							   		  (SELECT COUNT(*) FROM "._BdStr(DBD).$_p['d']." WHERE __dwn_e = '3' ) AS __tot_no_u,
							   		  (SELECT COUNT(*) FROM "._BdStr(DBD).$_p['d']." WHERE __dwn_e = '2' ) AS __tot_no_x,
							   		  (SELECT COUNT(*) FROM "._BdStr(DBD).$_p['d']." WHERE __dwn_e = '1' ) AS __tot_x,
							   		  (SELECT COUNT(*) FROM "._BdStr(DBD).$_p['d'].") AS __tot_no_all  /* Registros Total */
							   FROM "._BdStr(DBD).$_p['d']." LIMIT 1";

				$DtRg = $__cnx->_qry($query_DtRg);

				if($DtRg){

					$Vl['e']='ok';
					$row_DtRg = $DtRg->fetch_assoc();
					$Tot_DtRg = $DtRg->num_rows;

					if($Tot_DtRg > 0){

						$Vl['all'] = $_p['r'];
						$Vl['no_u'] = $row_DtRg['__tot_no_u']; // Generando BD
						$Vl['no_x'] = $row_DtRg['__tot_no_x']; // Generando Archivo
						$Vl['ok_x'] = $row_DtRg['__tot_x']; // Completo
						$Vl['no_all'] = $row_DtRg['__tot_no_all'];

					}

				}else{

					$Vl['w'] = $__cnx->c_p->error;

				}

				$__cnx->_clsr($DtRg);

			}
		}


		return _jEnc($Vl);

	}

	function GtDwnDt($_p=NULL){

		global $__cnx;

		if(is_array($_p)){

			if(!isN($_p['id'])){

				if($_p['t'] == 'enc'){ $__f = 'dwn_enc'; $__ft = 'text'; }else{ $__f = 'id_dwn'; $__ft = 'int'; }

				$c_DtRg = "-1";if(!isN($_p['id'])){ $c_DtRg = $_p['id']; }

				$query_DtRg = sprintf("SELECT id_dwn, dwn_enc, dwn_tt, dwn_cl, dwn_est, dwn_tp, dwn_eml, dwn_prc, dwn_blq, dwn_blq_f,
											  dwnest_tt, dwnest_clr, dwn_frm,
											  dwn_est_col, dwn_his_col, dwn_tab, us_enc, dwn_us, dwn_r,
											(SELECT COUNT(*) FROM information_schema.tables WHERE table_name = dwn_tab) AS __tb_e,
											( dwn_blq_f < NOW() - INTERVAL 5 MINUTE ) AS __rd_aft

										FROM "._BdStr(DBD).TB_DWN."
											 INNER JOIN "._BdStr(DBD).TB_DWN_EST." ON id_dwnest = dwn_est
											 INNER JOIN "._BdStr(DBM).TB_US." ON dwn_us = id_us
										WHERE ".$__f." = %s
										LIMIT 1", GtSQLVlStr($c_DtRg, $__ft));

				$DtRg = $__cnx->_qry($query_DtRg);

				if($DtRg){


					$row_DtRg = $DtRg->fetch_assoc();
					$Tot_DtRg = $DtRg->num_rows;


					if($Tot_DtRg > 0){

						$Vl['id'] = $row_DtRg['id_dwn'];
						$Vl['enc'] = ctjTx($row_DtRg['dwn_enc'],'in');
						$Vl['tt'] = ctjTx($row_DtRg['dwn_tt'],'in');
						$Vl['est'] = $row_DtRg['dwn_est'];
						$Vl['est_tt'] = $row_DtRg['dwnest_tt'];
						$Vl['est_clr'] = $row_DtRg['dwnest_clr'];
						$Vl['frm'] = $row_DtRg['dwn_frm'];
						$Vl['fle'] = $row_DtRg['id_dwn'].'.xlsx';
						$Vl['tp'] = $row_DtRg['dwn_tp'];
						$Vl['tbe'] = $row_DtRg['__tb_e'];

						if($row_DtRg['dwn_eml'] == 1){ $Vl['eml'] = 'ok'; }else{ $Vl['eml'] = 'no'; }

						if($row_DtRg['__tb_e'] > 0){
							$Vl['tot'] = GtDwnDt_Tot([ 'd'=>$row_DtRg['dwn_tab'], 'r'=>$row_DtRg['dwn_r'] ]);
						}else{
							$Vl['tot'] = 0;
						}

						$Vl['est_col'] = ctjTx($row_DtRg['dwn_est_col'],'in');
						$Vl['his_col'] = ctjTx($row_DtRg['dwn_his_col'],'in');
						$Vl['tab'] = ctjTx($row_DtRg['dwn_tab'],'in');
						$Vl['us'] = GtUsDt($row_DtRg['dwn_us']);
						$Vl['us_enc'] = GtUsDt($row_DtRg['us_enc']);

						$Vl['prc'] = mBln($row_DtRg['dwn_prc']);

						if($_p['d']['col']=='ok'){
							$Vl['col'] = GtDwnCol([ 'cl'=>$row_DtRg['dwn_cl'], 'id'=>$row_DtRg['id_dwn'] ]);
						}

						if( $row_DtRg['dwn_blq'] == 1 ){

							if( $row_Ls_Ec['__rd_aft'] ){
								$Vl['blq'] = 'no';
							}else{
								$Vl['blq'] = 'ok';
							}

						}else{
							$Vl['blq'] = 'no';
						}

						$Vl['blq_f'] = $row_DtRg['dwn_blq_f'];

					}else{
						$Vl['w'] = 'No records';
					}

				}else{

					$Vl['w'] = $__cnx->c_r->error;

				}

				$__cnx->_clsr($DtRg);

			}
		}

		return _jEnc($Vl);

	}

	function GtDwnTotDt($_p=NULL){

		global $__cnx;

		$GDwn_Qry = "SELECT COUNT(*) AS __tot FROM "._BdStr(DBD)."_d_".$_p['id'];
		$GDwn = $__cnx->_qry($GDwn_Qry);

		if($GDwn){
			$rwGDwn = $GDwn->fetch_assoc();
			$totGDwn = $GDwn->num_rows;
			return $rwGDwn['__tot'];
		}

	}


	function GtClDwnTot($_p=NULL){

		global $__cnx;

		$Vl['e'] = 'no';

		if(!isN($_p['cl'])){

			$query_DtRg = sprintf("	SELECT dwn_tot AS __tot
									FROM "._BdStr(DBD).TB_DWN."
									WHERE dwn_cl='".$_p['cl']."' AND
										  dwn_prc = 2 AND
										  dwn_eli = 2
									ORDER BY id_dwn DESC
								");

			$DtRg = $__cnx->_qry($query_DtRg);

			//$Vl['q'] = compress_code($query_DtRg);

			if($DtRg){

				$Tot_DtRg = $DtRg->num_rows;
				$row_DtRg = $DtRg->fetch_assoc();

				if($Tot_DtRg > 0){

					do{
						if(!isN($row_DtRg['__tot'])){
							$Vl['tot'] = $Vl['tot'] + $row_DtRg['__tot'];
						}
					}while($row_DtRg = $DtRg->fetch_assoc());

				}else{
					$Vl['tot'] = 0;
				}

			}else{

				$Vl['w'] = $__cnx->c_r->error.' / Problem executing:'.compress_code($query_DtRg);

			}

			$__cnx->_clsr($DtRg);

		}else{

			$Vl['w'] = 'No bd to execute';

		}

		return(_jEnc($Vl));

	}




	function GtClTraRspTot($_p=NULL){

		global $__cnx;

		$Vl['e'] = 'no';

		if(!isN($_p['cl'])){

			$query_DtRg = sprintf("	SELECT COUNT(*) AS __tot
									FROM "._BdStr(DBM).TB_TRA."
									WHERE tra_cl='".$_p['cl']."' AND
										  tra_chk_rsp = '1' AND
										  tra_col IS NOT NULL AND
										  tra_est='"._CId('ID_TRAEST_PRC')."'
								");

			$DtRg = $__cnx->_qry($query_DtRg);

			//$Vl['q'] = compress_code($query_DtRg);

			if($DtRg){

				$Tot_DtRg = $DtRg->num_rows;
				$row_DtRg = $DtRg->fetch_assoc();

				if($Tot_DtRg > 0){

					do{
						$Vl['tot'] = $Vl['__tot']+$Vl['tot'];
					}while($row_DtRg = $DtRg->fetch_assoc());

				}else{
					$Vl['no'] = $query_DtRg;
					$Vl['w'] = 'No recors on:'.compress_code($query_DtRg);
				}

			}else{
				$Vl['w'] = $__cnx->c_r->error.' / Problem executing:'.compress_code($query_DtRg);
			}

			$__cnx->_clsr($DtRg);

		}else{
			$Vl['w'] = 'No bd to execute';
		}

		return(_jEnc($Vl));

	}



	function GtDwnCol($_p=NULL){

		global $__cnx;

		$Vl['e'] = 'no';

		if(!isN($_p['cl'])){

			$query_DtRg = sprintf("	SELECT 	id_dwncol, dwncol_e,
											"._QrySisSlcF([ 'als'=>'c', 'als_n'=>'column' ]).",
											".GtSlc_QryExtra([ 't'=>'fld', 'p'=>'column', 'als'=>'c' ])."
									FROM "._BdStr(DBD).TB_DWN_COL."
										 ".GtSlc_QryExtra([ 't'=>'tb', 'col'=>'dwncol_col', 'als'=>'c' ])."
									WHERE 	dwncol_cl='".$_p['cl']."' AND
											dwncol_e = 1
									ORDER BY id_dwncol DESC
								");

			$DtRg = $__cnx->_qry($query_DtRg);

			if($DtRg){

				$Vl['e'] = 'ok';
				$Tot_DtRg = $DtRg->num_rows;
				$row_DtRg = $DtRg->fetch_assoc();

				if($Tot_DtRg > 0){

					do{

						$__column = json_decode($row_DtRg['___column']);

						foreach($__column as $__tp_k=>$__tp_v){
							$__column_go[$__tp_v->key] = $__tp_v;
						}

						$_key = $__column_go['key']->vl;
						$Vl['ls'][$_key]['id'] = $row_DtRg['id_dwncol'];
						$Vl['ls'][$_key]['attr'] = $__column_go;
						$Vl['ls'][$_key]['e'] = mBln($row_DtRg['dwncol_e']);

					}while($row_DtRg = $DtRg->fetch_assoc());

				}

			}else{
				$Vl['w'] = $__cnx->c_r->error;
			}

			$__cnx->_clsr($DtRg);

		}else{
			$Vl['w'] = 'No CL id';
		}

		return(_jEnc($Vl));

	}


?>