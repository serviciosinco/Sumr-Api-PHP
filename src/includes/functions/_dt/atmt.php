<?php


	function GtAtmtDt($p=NULL){

		global $__cnx;

		$Vl['e'] = 'no';

		if($p['t'] == 'enc'){ $__f = 'atmt_enc'; $__ft = 'text'; }else{ $__f = 'id_atmt'; $__ft = 'int'; }

		if(!isN($p['id'])){

			$query_DtRg = sprintf('	SELECT *,
										(SELECT COUNT(*) FROM '.DBA.'.'.TB_ATMT_ETP.' WHERE atmtetp_atmt = id_atmt) __tot_etp
									FROM '.DBA.'.'.TB_ATMT.'
										 INNER JOIN '._BdStr(DBM).TB_CL.' ON atmt_cl = id_cl
									WHERE '.$__f.' = %s LIMIT 1', GtSQLVlStr($p['id'],$__ft));

			$DtRg = $__cnx->_qry($query_DtRg);

		}

		if($DtRg){

			$row_DtRg = $DtRg->fetch_assoc();
			$Tot_DtRg = $DtRg->num_rows;

			$Vl['tot'] = $Tot_DtRg;

			if($Tot_DtRg > 0){

				$Vl['e'] = 'ok';

				$__Atmt = new CRM_Atmt([ 'cl'=>$row_DtRg['atmt_cl'] ]);

				$Vl['id'] = $row_DtRg['id_atmt'];
				$Vl['enc'] = $row_DtRg['atmt_enc'];
				$Vl['nm'] = ctjTx($row_DtRg['atmt_nm'],'in');
				$Vl['on'] = $row_DtRg['atmt_on'];
				$Vl['all']['mdl'] = $row_DtRg['atmt_allmdl'];
				$Vl['fi'] = $row_DtRg['atmt_fi'];
				$Vl['etp']['tot'] = $row_DtRg['__tot_etp'];
				$Vl['ec_etp'] = GtSisEcEtpDt($row_DtRg['id_atmt']);
				$Vl['mdl'] = $__Atmt->_Mdl([ 'atmt'=>$row_DtRg['id_atmt'] ]);
				$Vl['plcy'] = GtAtmtPlcyLs([ 'atmt'=>$row_DtRg['id_atmt'], 'cl'=>$row_DtRg['cl_enc'], 'e'=>'on' ]);
				$Vl['eml'] = GtEmlDt([ 'id'=>$row_DtRg['atmt_sndr'] ]);
				$Vl['cl']['id'] = $row_DtRg['atmt_cl'];

			}

		}else{

			$Vl['w'] = $__cnx->c_r->error;

		}

		$__cnx->_clsr($DtRg);

		return _jEnc($Vl);

	}


	function GtAtmtTrgr($Id){

		global $__cnx;

		$query_DtRg = '	SELECT atmttrgr_nm, id_atmttrgr,
								(SELECT COUNT(*)) AS __tot
						FROM '.DBA.'.'.TB_ATMT_TRGR.'
							 INNER JOIN '.DBA.'.'.TB_ATMT_ETP.' ON atmtetp_atmt = atmttrgr_atmt
						WHERE atmttrgr_atmt = '.GtSQLVlStr($Id['auto'],'int').' AND atmttrgr_etp = '.GtSQLVlStr($Id['etp'],'int').'
						GROUP BY id_atmttrgr';
		$DtRg = $__cnx->_qry($query_DtRg);
		$row_DtRg = $DtRg->fetch_assoc();
		$Tot_DtRg = $DtRg->num_rows;

		if($Tot_DtRg > 0){
			$_i = 1;
			do{

				//$Vl[ $row_DtRg['id_atmttrgr'] ] = array('nm'=>ctjTx($row_DtRg['atmttrgr_nm'],'in'), '__tot'=>$row_DtRg['__tt']);
				$Vl[$_i]['nm'] = $row_DtRg['atmttrgr_nm'];
				$Vl[$_i]['__tot'] = $row_DtRg['__tot'];

				$_i ++;
			}while($row_DtRg = $DtRg->fetch_assoc());
		}else{
			$Vl['no'] = $query_DtRg;
		}

		$__cnx->_clsr($DtRg);

		return(_jEnc($Vl));

	}



	function GtAtmtTrgrAct_Cde($_p=NULL){

		if($_p['f'] == 'l'){ //--------- Códigos Listas ----------//

			if($_p['t'] == 'LsCntEst'){

				$_r['html'] = LsCntEst([ 'id'=>$_p['id'], 'v'=>'id_siscntest', 'va'=>$_p['ls'], 'rq'=>1, 'attr'=>$_p['attr'] ]);
				$_r['js'] = JQ_Ls($_p['id'], '', '', '_slcClr', ['ac'=>'no']);

			}elseif($_p['t'] == 'LsCntEstTp'){

				$_r['html'] = LsCntEstTp($_p['id'], 'id_siscntesttp', $_p['ls'], TX_SLCETP);
				$_r['js'] = JQ_Ls($_p['id'], '', '', '_slcClr', ['ac'=>'no']);

			}elseif($_p['t'] == 'LsBcoPay'){

				$_r['html'] = LsBcoPay([ 'id'=>$_p['id'], 'v'=>'id_sisslc', 'va'=>$_p['ls'], 'rq'=>1, 'attr'=>$_p['attr'] ]);
				$_r['js'] = JQ_Ls($_p['id'], '', '', '', ['ac'=>'no']);

			}elseif($_p['t'] == 'LsGtStoreBrnd'){
				//$_r['html'] = 'Some';
				$_r['html'] .= LsGtStoreBrnd([ 'id'=>$_p['id'], 'v'=>'id_storebrnd', 'va'=>$_p['ls'], 'rq'=>1, 'attr'=>$_p['attr'] ]);
				$_r['js'] = JQ_Ls($_p['id'], '', '', '', ['ac'=>'no']);

			}elseif($_p['t'] == 'LsCld'){

				$_r['html'] = LsSis_Cld([ 'id'=>$_p['id'], 'v'=>'id', 'va'=>$_p['ls'], 'rq'=>1, 'attr'=>$_p['attr'] ]);
				$_r['js'] = JQ_Ls($_p['id'], '', '', '', ['ac'=>'no']);

			}


		}elseif($_p['f'] == 'd'){ //--------- Códigos Detalles ----------//

			if($_p['t'] == 'GtCntEstDt'){
				$_r = GtCntEstDt([ 'id'=>$_p['cid'] ]);
			}elseif($_p['t'] == 'GtCntEstTpDt'){
				$_r = GtCntEstTpDt([ 'id'=>$_p['cid'] ]);
			}elseif($_p['t'] == 'GtEcDt'){
				$_r = GtEcDt($_p['cid']);
			}elseif($_p['t'] == 'GtMdlCntChkDt'){
				$_r = __LsDt([ 'k'=>'sis_chk', 'id'=>$_p['cid'] ]);
			}elseif($_p['t'] == 'GtStoreBrndDt'){
				$_r = GtStoreBrndDt(['id'=>$_p['cid']]);
			}elseif($_p['t'] == 'GtCldDt'){
				$_r = __LsDt([ 'k'=>'cld', 'id'=>$_p['cid'] ]);
			}

		}

		return _jEnc($_r);

	}


	function GtAtmtTrgrActDt($_p=NULL){

		global $__cnx;

		if(is_array($_p)){

			if(!isN($_p['id'])){

				if($p['t'] == 'enc'){ $__f = 'atmttrgract_enc'; $__ft = 'text'; }else{ $__f = 'id_atmttrgract'; $__ft = 'int'; }

				$query_DtRg = sprintf(" SELECT id_atmttrgract, atmttrgract_enc, atmttrgract_v_ls, atmttrgract_act,
											   "._QrySisSlcF([ 'als'=>'a', 'als_n'=>'action' ]).",
											   ".GtSlc_QryExtra([ 't'=>'fld', 'p'=>'action', 'als'=>'a' ])."
										FROM ".DBA.".".TB_ATMT_TRGR_ACT."
											 ".GtSlc_QryExtra([ 't'=>'tb', 'col'=>'atmttrgract_act', 'als'=>'a' ])."
										WHERE id_atmttrgract = %s", GtSQLVlStr($_p['id'], $__ft));

				$DtRg = $__cnx->_qry($query_DtRg);

				//$Vl['q'] = compress_code($query_DtRg);

				if($DtRg){

					$row_DtRg = $DtRg->fetch_assoc();
					$Tot_DtRg = $DtRg->num_rows;

					if($Tot_DtRg > 0){

						$Vl['e'] = 'ok';
						$Vl['id'] = $row_DtRg['id_atmttrgract'];
						$Vl['vl'] = $row_DtRg['atmttrgract_v_ls'];

						$__act = __LsDt(['k'=>'sis_atmt_act', 'id'=>$row_DtRg['atmttrgract_act'], 'no_lmt'=>'ok' ]);

						if(!isN($__act->d->ls->vl)){

							$__op_g = [ 'id'=>'atmttrgr_v_ls' ];

							$ls = array_merge($__op_g, [ 'f'=>'l', 't'=>$_l_t->d->ls->vl ]);
							$Vl['ls']['l'] = $_l_t->d->ls->vl;
							$Vl['ls']['c'] = GtAtmtTrgrAct_Cde($ls);

							if(!isN($__act->d->ls_dt->vl)){
								$dt = array_merge($__op_g, [ 'cid'=>$row_DtRg['atmttrgract_v_ls'], 'f'=>'d', 't'=>$__act->d->ls_dt->vl ]);
								$Vl['dt']['d'] = $__act->d->ls_dt->vl;
								$Vl['dt']['c'] = GtAtmtTrgrAct_Cde($dt);
							}
						}

					}else{
						$Vl['e'] = 'no';
					}

				}else{

					$Vl['w'] = $__cnx->c_r->error.' on '.$query_DtRg;

				}

				$__cnx->_clsr($DtRg);

			}

		}

		$rtrn = _jEnc($Vl);
		return($rtrn);

	}


	function GtAtmtTrgrCndcDt($_p=NULL){

		global $__cnx;

		if(is_array($_p)){

			if(!isN($_p['id'])){

				$query_DtRg = sprintf(" SELECT *,
												"._QrySisSlcF([ 'als'=>'t', 'als_n'=>'Conditions' ]).",
												".GtSlc_QryExtra(['t'=>'fld', 'p'=>'cndc', 'als'=>'t'])."
										FROM "._BdStr(DBA).TB_ATMT_TRGR_CNDC."
											 ".GtSlc_QryExtra(['t'=>'tb', 'col'=>'atmttrgrcndc_cndc', 'als'=>'t'])."
										WHERE id_atmttrgrcndc = %s", GtSQLVlStr($_p['id'], 'int'));

				$DtRg = $__cnx->_qry($query_DtRg);

				if($DtRg){

					$row_DtRg = $DtRg->fetch_assoc();
					$Tot_DtRg = $DtRg->num_rows;

					if($Tot_DtRg > 0){

						$Vl['e'] = 'ok';
						$Vl['id'] = $row_DtRg['id_atmttrgrcndc'];
						$Vl['vl'] = $row_DtRg['atmttrgrcndc_v_vl'];

						$__cndc = json_decode($row_DtRg['___Conditions']);

						if(!isN( $__cndc )){

							foreach($__cndc as $__cndc_k=>$__cndc_v){

								if($__cndc_v->key == 'ls'){ //--------- Códigos Listas ----------//
									/*
									if($_p['t'] == 'LsCntEst'){

										$_r['html'] = LsCntEst([ 'id'=>$_p['id'], 'v'=>'id_siscntest', 'va'=>$_p['ls'], 'rq'=>1, 'attr'=>$_p['attr'] ]);
										$_r['js'] = JQ_Ls($_p['id'], '', '', '_slcClr', ['ac'=>'no']);

									}*/

								}elseif($__cndc_v->key == 'dt'){ //--------- Códigos Detalles ----------//

									if($__cndc_v->vl == 'GtBcoPayDt'){
										$Vl['d'] = GtBcoPayDt([ 'id'=>$Vl['vl'] ])->d;
									}elseif($__cndc_v->vl == 'GtStoreBrndDt'){
										$Vl['d'] = GtStoreBrndDt([ 'id'=>$Vl['vl'] ]);
									}

								}

							}
						}

					}else{

						$Vl['e'] = 'no';

					}

				}else{

					$Vl['w'] = $__cnx->c_r->error;

				}

				$__cnx->_clsr($DtRg);

			}

		}

		return _jEnc($Vl);
	}



	function GtEcTrgr_Cde($_p=NULL){



		if($_p['f'] == 'l'){ //--------- Códigos Listas ----------//

			if($_p['t'] == 'LsCntEst'){

				$_r['html'] = LsCntEst([ 'id'=>$_p['id'], 'v'=>'id_siscntest', 'va'=>$_p['ls'], 'rq'=>1, 'attr'=>$_p['attr'] ]);
				$_r['js'] = JQ_Ls($_p['id'], '', '', '_slcClr', ['ac'=>'no']);

			}elseif($_p['t'] == 'LsCntEstTp'){

				$_r['html'] = LsCntEstTp($_p['id'], 'id_siscntesttp', $_p['ls'], TX_SLCETP);
				$_r['js'] = JQ_Ls($_p['id'], '', '', '_slcClr', ['ac'=>'no']);

			}elseif($_p['t'] == 'LsEcCmpg'){

				$_r['html'] = LsEcCmpg([ 'id'=>$_p['id'], 'v'=>'id_eccmpg', 'va'=>$_p['ls'], 'rq'=>1, 'attr'=>$_p['attr'] ]);
				$_r['js'] = JQ_Ls($_p['id'], '');

			}elseif($_p['t'] == 'LsEc'){

				$_r['html'] = LsEc($_p['id'], 'id_ec', $_p['ls'], '', '', '' , [ 'attr'=>$_p['attr'] ]);
				$_r['js'] = JQ_Ls($_p['id'], '');

			}elseif($_p['t'] == 'LsEcLnk'){

				$_r['html'] = LsEcLnk([ 'id'=>$_p['id'], 'v'=>'id_eclnk', 'va'=>$_p['vl'], 'ec'=>$_p['ls'], 'attr'=>$_p['attr'] ]);
				$_r['js'] = JQ_Ls($_p['id'], '');

			}elseif($_p['t'] == 'LsMdlCntChk'){

				$l = __Ls(['k'=>'sis_chk', 'id'=>$_p['id'], 'va'=>$_p['ls'] , 'attr'=>$_p['attr'], 'fcl'=>'ok' ]);
				$_r['html']=$l->html;
				$_r['js']= $l->js;

			}

		}elseif($_p['f'] == 'd'){ //--------- Códigos Detalles ----------//


		}

		return _jEnc($_r);

	}


	function GtEcTrgrDt($_p=NULL){

		global $__cnx;

		$Vl['e'] = 'no';

		if(is_array($_p)){

			if(!isN($_p['id'])){

				$_l_t = __LsDt([ 'k'=>'sis_atmt_trgr', 'id'=>$_p['id'], 'no_lmt'=>'ok' ]);

				if(!isN( $_l_t->d->id )){

					$__op_g = [ 'ls'=>$_p['ls'], 'vl'=>$_p['vl'], 'id'=>'atmttrgr_v_ls' ];
					$__op_g_s = [ 'ls'=>$_p['ls'], 'vl'=>$_p['vl'], 'id'=>'atmttrgr_v_vl' ];


					$Vl['e'] = 'ok';
					$Vl['id'] = $_l_t->d->id;
					$Vl['rvle'] = ($_l_t->d->rvle->vl==1)?'ok':'no';


					//--------- Lista Desplegable ----------//

					if(!isN( $_l_t->d->ls->vl )){
						$ls = array_merge($__op_g, [ 'f'=>'l', 't'=>$_l_t->d->ls->vl ]);
						$Vl['ls']['l'] = $_l_t->d->ls->vl;
						$Vl['ls']['c'] = GtEcTrgr_Cde($ls);
					}

					//--------- Detalle de Lista Desplegada ----------//

					if(!isN( $_l_t->d->ls_dt->vl )){
						$ls_d = array_merge($__op_g, [ 'f'=>'d', 't'=>$_l_t->d->ls_dt->vl ]);
						$Vl['ls_dt']['d'] = $_l_t->d->ls_dt->vl;
						if(!isN($_p['ls'])){ $Vl['ls_dt']['c'] = GtEcTrgr_Cde($ls_d); }
					}

					//--------- Lista Desplegable - Segunda Opción ----------//

					if(!isN( $_l_t->d->sbls->vl )){
						$sbls = array_merge($__op_g_s, [ 'f'=>'l', 't'=>$_l_t->d->sbls->vl ]);
						$Vl['sbls']['l'] = $_l_t->d->sbls->vl;
						$Vl['sbls']['c'] = GtEcTrgr_Cde($sbls);
					}

					//--------- Detalle de Lista Desplegada - Segunda Opción ----------//

					if(!isN( $_l_t->d->sbls_dt->vl )){
						$sbls_d = array_merge($__op_g_s, [ 'f'=>'d', 't'=>$_l_t->d->sbls_dt->vl ]);
						$Vl['sbls_dt']['d'] = $_l_t->d->sbls_dt->vl;
						$Vl['sbls_dt']['c'] = GtEcTrgr_Cde($sbls_d);
					}

				}

			}
		}

		return _jEnc($Vl);

	}


	function GtAtmtEtpDt($_p=NULL){

		global $__cnx;

		if(is_array($_p)){
			if(!isN($_p['id'])){

				$query_DtRg = sprintf(" SELECT *

										FROM ".DBA.".".TB_ATMT_ETP."
											 INNER JOIN "._BdStr(DBM).TB_CL_ETP." ON atmtetp_etp = id_cletp

										WHERE id_atmtetp = %s", GtSQLVlStr($_p['id'], $__ft));

				$DtRg = $__cnx->_qry($query_DtRg);
				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;

				if($Tot_DtRg > 0){

					$Vl['e'] = 'ok';
					$Vl['id'] = $row_DtRg['id_atmtetp'];
					$Vl['tt'] = ctjTx($row_DtRg['cletp_nm'],'in');


				}else{
					$Vl['e'] = 'no';
				}

				$__cnx->_clsr($DtRg);

			}
		}

		$rtrn = _jEnc($Vl);
		return($rtrn);

	}



	function GtAtmtTrgrDt($_p=NULL){

		global $__cnx;

		if(is_array($_p)){

			if(!isN($_p['id'])){

				$query_DtRg = sprintf(" SELECT *,
											  "._QrySisSlcF([ 'als'=>'t', 'als_n'=>'Trigger' ]).",
											  "._QrySisSlcF([ 'als'=>'d', 'als_n'=>'Delay']).",
											  "._QrySisSlcF([ 'als'=>'s', 'als_n'=>'Schedules']).",
											  ".GtSlc_QryExtra([ 't'=>'fld', 'p'=>'Trigger', 'als'=>'t' ]).",
											  ".GtSlc_QryExtra([ 't'=>'fld', 'p'=>'Delay', 'als'=>'d' ]).",
											  ".GtSlc_QryExtra([ 't'=>'fld', 'p'=>'Schedules', 'als'=>'s' ])."

										FROM ".DBA.".".TB_ATMT_TRGR."
											 INNER JOIN ".DBA.".".TB_ATMT." ON atmttrgr_atmt = id_atmt
											 INNER JOIN "._BdStr(DBM).TB_CL_ETP." ON atmttrgr_etp = id_cletp
											 ".GtSlc_QryExtra([ 't'=>'tb', 'col'=>'atmttrgr_trgr', 'als'=>'t' ])."
											 ".GtSlc_QryExtra([ 't'=>'tb', 'col'=>'atmttrgr_dly', 'als'=>'d' ])."
											 ".GtSlc_QryExtra([ 't'=>'tb', 'col'=>'atmttrgr_sch', 'als'=>'s' ])."
										WHERE id_atmttrgr = %s", GtSQLVlStr($_p['id'], 'int'));

				$DtRg = $__cnx->_qry($query_DtRg);

				if($DtRg){

					$row_DtRg = $DtRg->fetch_assoc();
					$Tot_DtRg = $DtRg->num_rows;

					if($Tot_DtRg > 0){

						$Vl['e'] = 'ok';
						$Vl['id'] = $row_DtRg['id_atmttrgr'];
						$Vl['enc'] = $row_DtRg['atmttrgr_enc'];
						$Vl['ord'] = $row_DtRg['atmttrgr_ord'];
						$Vl['hbl'] = mBln($row_DtRg['atmttrgr_hbl']);

						$Vl['v']['ls'] = $row_DtRg['atmttrgr_v_ls'];
						$Vl['v']['vl'] = $row_DtRg['atmttrgr_v_vl'];

						$Vl['trgr'] = GtEcTrgrDt(['id'=>$row_DtRg['atmttrgr_trgr'], 'dt'=>'ok', 'ls'=>$row_DtRg['atmttrgr_v_ls'], 'vl'=>$row_DtRg['atmttrgr_v_vl']]);

						$Vl['etp']['id'] = $row_DtRg['id_cletp'];
						$Vl['etp']['tt'] = ctjTx($row_DtRg['cletp_nm'],'in');

						$Vl['dly']['id'] = $row_DtRg['Delay_id_sisslc'];
						$Vl['dly']['tt'] = ctjTx($row_DtRg['Delay_sisslc_tt'],'in');

						$Vl['sch']['id'] = $row_DtRg['Schedules_id_sisslc'];
						$Vl['sch']['tt'] = ctjTx($row_DtRg['Schedules_sisslc_tt'],'in');

						if($_p['ls'] == 'ok'){

							$Vl['ls']['act'] = GtAtmtTrgrActLs(['id'=>$row_DtRg['id_atmttrgr']]);
							$Vl['ls']['sgm'] = GtAtmtTrgrSgmLs(['id'=>$row_DtRg['id_atmttrgr']]);
							$Vl['ls']['cndc'] = GtAtmtTrgrCndcLs(['id'=>$row_DtRg['id_atmttrgr']]);

						}

					}else{
						$Vl['e'] = 'no';
					}

				}else{

					$Vl['w'] = $__cnx->c_r->error;

				}

				$__cnx->_clsr($DtRg);

			}
		}

		$rtrn = _jEnc($Vl);
		return($rtrn);
	}


	function GtAtmtTrgrActLs($p=NULL){

		global $__cnx;

		if(!isN($p['id'])){

			$Ls_Qry = " SELECT *,
								"._QrySisSlcF([ 'als'=>'a', 'als_n'=>'Action' ]).",
								".GtSlc_QryExtra([ 't'=>'fld', 'p'=>'Action', 'als'=>'a' ])."

						FROM ".DBA.".".TB_ATMT_TRGR_ACT."
							 ".GtSlc_QryExtra([ 't'=>'tb', 'col'=>'atmttrgract_act', 'als'=>'a' ])."

					   	WHERE atmttrgract_trgr = ".$p['id']."
					   	ORDER BY atmttrgract_fi DESC";

			$Ls_Rg = $__cnx->_qry($Ls_Qry);

			if($Ls_Rg){

				$row_Ls_Rg = $Ls_Rg->fetch_assoc();
				$Tot_Ls_Rg = $Ls_Rg->num_rows;

				$_r['tot'] = $Tot_Ls_Rg;

				if($Tot_Ls_Rg > 0){

                    do{

	                    $__attr = json_decode($row_Ls_Rg['___Action']);

	                    foreach($__attr as $__attr_k=>$__attr_v){
							$__tipo_go->{$__attr_v->key} = $__attr_v;
						}

						$__code = GtAtmtTrgrAct_Cde([ 'f'=>'d', 'cid'=>$row_Ls_Rg['atmttrgract_v_ls'], 't'=>$__tipo_go->ls_dt->vl ]);

						$_r['ls'][] = [
										'id'=>$row_Ls_Rg['id_atmttrgract'],
										'nm'=>ctjTx($row_Ls_Rg['Action_sisslc_tt'],'in').' ('.$__code->tt.')',
										'hbl'=>mBln($row_Ls_Rg['atmttrgract_hbl']),
										'attr'=>$__tipo_go
									];


                    } while ($row_Ls_Rg = $Ls_Rg->fetch_assoc());
	            }

			}else{

				$_r['w'] = $__cnx->c_r->error;

			}

			$__cnx->_clsr($Ls_Rg);

		}


		return _jEnc($_r);

	}



	function GtAtmtTrgrSgmLs($p=NULL){

		global $__cnx;

		if(!isN($p['id'])){

			$Ls_Qry = " SELECT id_atmttrgrsgm, eclstssgm_nm, eclsts_nm

						FROM ".DBA.".".TB_ATMT_TRGR_SGM."
							 INNER JOIN "._BdStr(DBM).TB_EC_LSTS_SGM." ON atmttrgrsgm_sgm = id_eclstssgm
							 INNER JOIN "._BdStr(DBM).TB_EC_LSTS." ON eclstssgm_lsts = id_eclsts

					   	WHERE atmttrgrsgm_trgr = ".$p['id']."
					   	ORDER BY atmttrgrsgm_fi DESC";

			$Ls_Rg = $__cnx->_qry($Ls_Qry);

			if($Ls_Rg){

				$row_Ls_Rg = $Ls_Rg->fetch_assoc();
				$Tot_Ls_Rg = $Ls_Rg->num_rows;

				$_r['tot'] = $Tot_Ls_Rg;

				if($Tot_Ls_Rg > 0){

                    do{

						$_r['ls'][] = ['id'=>$row_Ls_Rg['id_atmttrgrsgm'], 'nm'=>ctjTx($row_Ls_Rg['eclstssgm_nm'].' ('.$row_Ls_Rg['eclsts_nm'].')','in') ];

                    } while ($row_Ls_Rg = $Ls_Rg->fetch_assoc());
	            }

			}

			$__cnx->_clsr($Ls_Rg);

		}

		$rtrn = _jEnc($_r);
		return($rtrn);
	}



	function GtAtmtTrgrCndcLs($p=NULL){

		global $__cnx;

		if(!isN($p['id'])){

			$Ls_Qry = " SELECT *

						FROM ".DBA.".".TB_ATMT_TRGR_CNDC."
							 INNER JOIN ".TB_SIS_EC_CNDC." ON atmttrgrcndc_cndc = id_eccndc

					   	WHERE atmttrgrcndc_trgr = ".$p['id']."
					   	ORDER BY atmttrgrcndc_fi DESC";

			$Ls_Rg = $__cnx->_qry($Ls_Qry);

			if($Ls_Rg){

				$row_Ls_Rg = $Ls_Rg->fetch_assoc();
				$Tot_Ls_Rg = $Ls_Rg->num_rows;

				$_r['tot'] = $Tot_Ls_Rg;

				if($Tot_Ls_Rg > 0){

                    do{

						$_ls_j = json_decode($row_Ls_Rg['eccndc_ls']);

						if(!isN($_ls_j->d) && function_exists($_ls_j->d) ){
							$myf = $_ls_j->d;
							$__data = $myf($row_Ls_Rg['atmttrgrcndc_v_vl']);
						}

						$_r['ls'][] = ['id'=>$row_Ls_Rg['id_atmttrgrcndc'], 'nm'=>ctjTx($row_Ls_Rg['eccndc_nm'],'in').' ('.$__data->tt.')' ];

                    } while ($row_Ls_Rg = $Ls_Rg->fetch_assoc());

	            }

			}

			$__cnx->_clsr($Ls_Rg);

		}

		return _jEnc($_r);
	}


	function GtAtmtEtpLs($p=NULL){

		global $__cnx;

		if(!isN($p['id']) || !isN($p['auto'])){

			if(!isN($p['id'])){ $_id = $p['id']; $_f = 'id_atmtetp'; }
			if(!isN($p['auto'])){ $_id = $p['auto']; $_f = 'atmtetp_atmt'; }

			$Ls_Qry = sprintf(" SELECT *
								FROM ".DBA.".".TB_ATMT_ETP."
								     INNER JOIN "._BdStr(DBM).TB_CL_ETP." ON atmtetp_etp = id_cletp
								WHERE ".$_f." = %s
								ORDER BY atmtetp_ord ASC", GtSQLVlStr($_id, 'int'));

			$LsTp_Rg =$__cnx->_qry($Ls_Qry);

			if($LsTp_Rg){

				$row_LsTp_Rg = $LsTp_Rg->fetch_assoc();
				$Tot_LsTp_Rg = $LsTp_Rg->num_rows;

				$_r['tot'] = $Tot_LsTp_Rg;

			    if($Tot_LsTp_Rg > 0){
	                do{


						$_v[] = [   'id'=>ctjTx($row_LsTp_Rg['id_atmtetp'],'in'),
									'enc'=>ctjTx($row_LsTp_Rg['atmtetp_enc'],'in'),
								    'tt'=>$row_LsTp_Rg['atmtetp_nm']!=''?ctjTx($row_LsTp_Rg['atmtetp_nm'],'in'):ctjTx($row_LsTp_Rg['cletp_nm'],'in'),
								    'etp'=>[
									  	'id'=>ctjTx($row_LsTp_Rg['id_cletp'],'in'),
									  	'enc'=>ctjTx($row_LsTp_Rg['cletp_enc'],'in'),
									  	'tt'=>ctjTx($row_LsTp_Rg['cletp_nm'],'in'),
									  	'key'=>$row_LsTp_Rg['cletp_key']
									]
								];


					} while ($row_LsTp_Rg = $LsTp_Rg->fetch_assoc());
				}

	          	$_r['ls'] = $_v;

          	}

		    $__cnx->_clsr($LsTp_Rg);

		}

		return _jEnc($_r);

	}


	function GtSisEcEtpDt($Id){

		global $__cnx;

		$query_DtRg = sprintf('	SELECT *,
									(SELECT COUNT(*) FROM '.DBA.'.atmt_trgr WHERE atmttrgr_etp = id_cletp AND atmttrgr_atmt = atmtetp_atmt) AS __tt_trgr
								FROM '.DBA.'.'.TB_ATMT_ETP.', '._BdStr(DBM).TB_CL_ETP.'
								WHERE atmtetp_etp = id_cletp AND atmtetp_atmt = %s ', GtSQLVlStr($Id,'int'));

		$DtRg = $__cnx->_qry($query_DtRg);

		if($DtRg){

			$row_DtRg = $DtRg->fetch_assoc();
			$Tot_DtRg = $DtRg->num_rows;

			if($Tot_DtRg > 0){
				do{

					$Vl[ $row_DtRg['id_cletp'] ] = ['tt'=>ctjTx($row_DtRg['cletp_nm'],'in'), 'trgr'=>ctjTx($row_DtRg['__tt_trgr'],'in'), 'atmtetp_etp'=>ctjTx($row_DtRg['atmtetp_etp'],'in')];

				}while($row_DtRg = $DtRg->fetch_assoc());
			}else{
				$Vl['no'] = $query_DtRg;
			}

		}

		$__cnx->_clsr($DtRg);

		return(_jEnc($Vl));

	}


	function GtAtmtTrgrActChk($_p=NULL){

		global $__cnx;

		$Vl['e'] = 'no';

		if(is_array($_p)){

			$query_DtRg = sprintf("	SELECT *
									FROM ".DBA.".".TB_ATMT_RG."
									WHERE 	atmtrg_atmt=%s AND
											atmtrg_trgr=%s AND
											atmtrg_act=%s AND
											atmtrg_id=%s AND
											atmtrg_tp=%s
										",
									GtSQLVlStr($_p['atmt'], 'int'),
									GtSQLVlStr($_p['trgr'], 'int'),
									GtSQLVlStr($_p['act'], 'int'),
									GtSQLVlStr($_p['id'], 'text'),
									GtSQLVlStr($_p['tp'], 'text')
								);

			$DtRg = $__cnx->_qry($query_DtRg);

			if($DtRg){

				$Vl['e'] = 'ok';
				//$Vl['q'] = $query_DtRg;

				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;
				$Vl['tot'] = $Tot_DtRg;

			}else{

				$Vl['w'] = $__cnx->c_r->error;

			}

			$__cnx->_clsr($DtRg);

		}

		return(_jEnc($Vl));
	}


	function GtAtmtTrgrActLnlChk($_p=NULL){

		global $__cnx;

		$Vl['e'] = 'no';

		if(is_array($_p)){

			$atmttrgrdt = GtAtmtTrgrDt([ 'id'=>$_p['trgr'], 'ls'=>'ok' ]);

			$query_DtRg = sprintf("	SELECT *
									FROM ".DBA.".".TB_ATMT_TRGR."
										 INNER JOIN ".DBA.".".TB_ATMT." ON atmttrgr_atmt = id_atmt
										 INNER JOIN "._BdStr(DBM).TB_CL_ETP." ON atmttrgr_etp = id_cletp
									WHERE atmttrgr_atmt=%s AND
										  atmttrgr_ord < %s AND
										  id_atmttrgr != %s AND
										  atmttrgr_hbl = 1
									ORDER BY atmttrgr_ord DESC
									LIMIT 1
									",
									GtSQLVlStr($_p['atmt'], 'int'),
									GtSQLVlStr($atmttrgrdt->ord, 'int'),
									GtSQLVlStr($atmttrgrdt->id, 'int')
								);

			$DtRg = $__cnx->_qry($query_DtRg);

			if($DtRg){

				$Vl['e'] = 'ok';
				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;
				$Vl['tot'] = $Tot_DtRg;

				$atmttrgrdt = GtAtmtTrgrDt([ 'id'=>$row_DtRg['id_atmttrgr'], 'ls'=>'ok' ]);

				$Vl['bfr'] = $row_DtRg['id_atmttrgr'];
				$Vl['act'] = $atmttrgrdt->ls->act;


			}else{

				$Vl['w'] = $__cnx->c_r->error;

			}

			$__cnx->_clsr($DtRg);

		}

		return(_jEnc($Vl));
	}


	function GtAtmtPlcyLs($p=NULL){

		global $__cnx;

		$Vl['e'] = 'no';

		if(!isN($p['atmt'])){

			if(defined('DB_CL_ENC')){ $_cl = DB_CL_ENC; }elseif(!isN($p['cl'])){ $_cl = $p['cl']; }

			$query_DtRg = sprintf("	SELECT *,
											(
												SELECT COUNT(*)
												FROM ".DBA.".".TB_ATMT_PLCY."
												WHERE atmtplcy_atmt=%s AND
													  atmtplcy_clplcy=id_clplcy AND
													  atmtplcy_e=1
											) AS __tot

									FROM "._BdStr(DBM).TB_CL_PLCY."
										 INNER JOIN "._BdStr(DBM).TB_CL." ON clplcy_cl = id_cl
									WHERE cl_enc = '".$_cl."'
									ORDER BY clplcy_fi DESC
									", GtSQLVlStr($p['atmt'], 'int'));

			$DtRg = $__cnx->_qry($query_DtRg);

			if($DtRg){

				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;

				$Vl['e'] = 'ok';
				$Vl['tot'] = $Tot_DtRg;

				if($Tot_DtRg > 0){

					do{

						$__id=$row_DtRg['clplcy_enc'];

						$Vl['ls'][$__id]['id'] = $row_DtRg['id_clplcy'];
						$Vl['ls'][$__id]['enc'] = ctjTx($row_DtRg['clplcy_enc'],'in');
						$Vl['ls'][$__id]['nm'] = ctjTx($row_DtRg['clplcy_nm'],'in');
						$Vl['ls'][$__id]['tx'] = ctjTx($row_DtRg['clplcy_tx'],'in');
						$Vl['ls'][$__id]['v'] = ctjTx($row_DtRg['clplcy_v'],'in');

						$Vl['ls'][$__id]['lnk']['url'] = ctjTx($row_DtRg['clplcy_lnk'],'in');
						$Vl['ls'][$__id]['lnk']['tt'] = ctjTx($row_DtRg['clplcy_lnk_tt'],'in');

						$Vl['ls'][$__id]['tot'] = ctjTx($row_DtRg['__tot'],'in');
						$Vl['ls'][$__id]['on'] = mBln($row_DtRg['__tot']);

					}while($row_DtRg = $DtRg->fetch_assoc());

				}

			}else{

				$Vl['w'] = $__cnx->c_r->error;

			}

			$__cnx->_clsr($DtRg);

		}

		return _jEnc($Vl);

	}


