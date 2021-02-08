<?php

	function GtCntEmlLs($p=NULL){

		global $__cnx;

		if(!isN($p['i'])){

			if(!isN($p['bd'])){ $_bd=$p['bd']; }else{ $_bd=''; }
			if($p['eml_allw']=='ok'){ $_f .= " AND cnteml_est='"._CId('ID_SISEMLEST_ACT')."' "; }

			$Ls_Qry = "		SELECT cnteml_enc, cnteml_eml, cnteml_cld, id_cnteml, cnteml_tp, cnteml_rjct, cnteml_est, cnteml_fi, cnteml_fa, cntplcy_sndi
							FROM "._BdStr($_bd).TB_CNT_EML."
								 LEFT JOIN "._BdStr($_bd).TB_CNT_PLCY." ON (cntplcy_cnt = cnteml_cnt AND cntplcy_sndi=1)
								 LEFT JOIN "._BdStr(DBM).TB_CL_PLCY." ON (cntplcy_plcy = id_clplcy AND clplcy_e=1)
							WHERE cnteml_cnt = ".$p['i']." {$_f}
							ORDER BY cnteml_fi DESC";

			$Ls_Rg = $__cnx->_qry($Ls_Qry);

			if($Ls_Rg){

				$row_Ls_Rg = $Ls_Rg->fetch_assoc();
				$Tot_Ls_Rg = $Ls_Rg->num_rows;

				$cld_m = 0;

				if($Tot_Ls_Rg > 0){

					do{

	                    $_r['ls'][$row_Ls_Rg['cnteml_enc']] = ( ($p['scre'] == "ok") ? __eml_scre([ 'v'=>$row_Ls_Rg['cnteml_eml'] ]) : $row_Ls_Rg['cnteml_eml']);

	                    if($row_Ls_Rg['cnteml_cld'] > $cld_m){ $cld_m = $row_Ls_Rg['cnteml_cld']; $cld_id = $row_Ls_Rg['cnteml_eml']; }


						$__eml_nrml = 	_plcy_scre([
											't'=>'eml',
											'v'=>$row_Ls_Rg['cnteml_eml'],
											'plcy'=>[ 'e'=>$row_Ls_Rg['cntplcy_sndi'] ]
										]);

						$_r[] = [
									'id'=>$row_Ls_Rg['id_cnteml'],
									'enc'=>$row_Ls_Rg['cnteml_enc'],
									'v'=>( ($p['scre'] == "ok")? __eml_scre([ 'v'=>$row_Ls_Rg['cnteml_eml'] ]) : $__eml_nrml),
									'tp'=>$row_Ls_Rg['cnteml_tp'],
									'cld'=>$row_Ls_Rg['cnteml_cld'],
									//'sndi'=>mBln($row_Ls_Rg['cnteml_sndi']),
									'rjct'=>mBln($row_Ls_Rg['cnteml_rjct']),
									'est'=>$row_Ls_Rg['cnteml_est'],
									'fi'=>$row_Ls_Rg['cnteml_fi'],
									'fa'=>$row_Ls_Rg['cnteml_fa'],
									'plcy'=>GtCntEmlPlcyLs([ 'bd'=>$_bd, 'cl'=>$p['cl'], 'eml'=>$row_Ls_Rg['id_cnteml'] ])
								];

						$_c[] = $row_Ls_Rg['cnteml_eml'];

					} while ($row_Ls_Rg = $Ls_Rg->fetch_assoc());

					$_r['clds']['cld_m'] = $cld_m;
					$_r['clds']['cld_eml'] = $cld_id;

				}

				if(is_array($_c)){ $__c = implode(',', $_c); } else{ $__c = $_c; }

			}else{

				$_r['w'] = 'GtCntEmlLs:'.$__cnx->c_r->error;

			}

			$__cnx->_clsr($Ls_Rg);

		}else{

			$_r['w2'] = 'GtCntEmlLs: no id cnt for search';

		}

		$rtrn = _jEnc($_r);

		if($p['r'] == 'c'){ return($__c); }else{ return($rtrn); }

	}



	function GtCntTelLs($p=NULL){

		global $__cnx;

		if(!isN($p['i'])){

			if(!isN($p['bd'])){ $_bd=$p['bd']; }else{ $_bd=''; }

			$Ls_Qry_His = "	SELECT id_cnttel, cnttel_tel, cnttel_enc, sisps_img, cnttel_est, cnttel_tp, sisps_tel, cnttel_fi, cnttel_fa, cntplcy_sndi
							FROM "._BdStr($_bd).TB_CNT_TEL."
								 INNER JOIN "._BdStr(DBM).TB_SIS_PS." ON cnttel_ps = id_sisps
								 INNER JOIN "._BdStr(DBM).MDL_SIS_TEL_BD." ON cnttel_tp = id_sistel
								 LEFT JOIN "._BdStr($_bd).TB_CNT_PLCY." ON (cntplcy_cnt = cnttel_cnt AND cntplcy_sndi=1)
								 LEFT JOIN "._BdStr(DBM).TB_CL_PLCY." ON (cntplcy_plcy = id_clplcy AND clplcy_e=1)

							WHERE cnttel_cnt = ".$p['i']." AND cnttel_est = '"._CId('ID_SISTELEST_ACTV')."'
							ORDER BY cnttel_fi ASC";

			$Ls_Rg = $__cnx->_qry($Ls_Qry_His);

			if($Ls_Rg){

				$row_Ls_Rg = $Ls_Rg->fetch_assoc();
				$Tot_Ls_Rg = $Ls_Rg->num_rows;

				if($Tot_Ls_Rg > 0){

                    do{

						$__tel_nrml = 	_plcy_scre([
							'v'=>$row_Ls_Rg['cnttel_tel'],
							'plcy'=>[ 'e'=>$row_Ls_Rg['cntplcy_sndi'] ]
						]);

	                    if($p['all']=="ok"){

							$_r['ls'][$row_Ls_Rg['id_cnttel']]['tel'] = $__tel_nrml;
			                	$_r['ls'][$row_Ls_Rg['id_cnttel']]['enc'] = $row_Ls_Rg['cnttel_enc'];
			                	$_r['ls'][$row_Ls_Rg['id_cnttel']]['img_ps'] = $row_Ls_Rg['sisps_img'];
			                	$_r['ls'][$row_Ls_Rg['id_cnttel']]['est'] = $row_Ls_Rg['cnttel_est'];
			                	//$_r['ls'][$row_Ls_Rg['id_cnttel']]['sndi'] = mBln($row_Ls_Rg['cnttel_sndi']);
			                	$_r['ls'][$row_Ls_Rg['id_cnttel']]['sms'] = mBln($row_Ls_Rg['cnttel_sms']);
			                	$_r['ls'][$row_Ls_Rg['id_cnttel']]['whtsp'] = mBln($row_Ls_Rg['cnttel_whtsp']);
								$_r['ls'][$row_Ls_Rg['id_cnttel']]['plcy'] = GtCntTelPlcyLs([ 'bd'=>$_bd, 'cl'=>$p['cl'], 'tel'=>$row_Ls_Rg['id_cnttel'] ]);
								$_r['ls'][$row_Ls_Rg['id_cnttel']]['tp'] = $row_Ls_Rg['cnttel_tp'];

	                    }else{

							$_r[] = [
										'id'=>$row_Ls_Rg['id_cnttel'],
										'enc'=>$row_Ls_Rg['cnttel_enc'],
										'v'=>( ($p['scre'] == "ok")? __tel_scre([ 'v'=>$row_Ls_Rg['cnttel_tel'] ]) : $__tel_nrml),
										'tp'=>[
											'id'=>$row_Ls_Rg['cnttel_tp']
										],
										'ps'=>[
											'cod'=>$row_Ls_Rg['sisps_tel'],
											'img'=>$row_Ls_Rg['sisps_img']
										],
										//'sndi'=>mBln($row_Ls_Rg['cnttel_sndi']),
										//'sms'=>mBln($row_Ls_Rg['cnttel_sms']),
										//'whtsp'=>mBln($row_Ls_Rg['cnttel_whtsp']),
										'fi'=>$row_Ls_Rg['cnttel_fi'],
										'fa'=>$row_Ls_Rg['cnttel_fa']
									];


							$_c[] = $__tel_nrml;

	                    }

                    } while ($row_Ls_Rg = $Ls_Rg->fetch_assoc());
	            }

            }


			if(is_array($_c)){ $__c = implode(',', $_c); } else{ $__c = $_c; }
			$__cnx->_clsr($Ls_Rg);

			$rtrn = _jEnc($_r);
			if($p['r'] == 'c'){ return($__c); }else{ return($rtrn); }

		}
	}




	function GtCntCdLs($p=NULL){

		global $__cnx;

		if(!isN($p['i'])){

			if(!isN($p['bd'])){ $_bd=$p['bd']; }else{ $_bd=''; }

			$Ls_Qry = "	SELECT cntcd_rel, id_cntcd, cntcd_enc, sisps_img, cntcd_cd, siscd_tt, id_sisps, sisps_tt, sisps_img, cntcd_fi, cntcd_fa,
								"._QrySisSlcF([ 'als'=>'rel', 'als_n'=>'relacion' ]).",
								".GtSlc_QryExtra(['t'=>'fld', 'p'=>'tp', 'als'=>'rel'])."

							FROM "._BdStr($_bd).TB_CNT_CD."
						   		 INNER JOIN "._BdStr(DBM).TB_SIS_CD." ON cntcd_cd = id_siscd
						   		 INNER JOIN "._BdStr(DBM).TB_SIS_CD_DP." ON siscd_dp = id_siscddp
						   		 INNER JOIN "._BdStr(DBM).TB_SIS_PS." ON siscddp_ps = id_sisps
						   		 ".GtSlc_QryExtra(['t'=>'tb', 'col'=>'cntcd_rel', 'als'=>'rel'])."
						   	WHERE cntcd_cnt = ".$p['i']."
						   	ORDER BY cntcd_fi ASC";

			$Ls_Rg = $__cnx->_qry($Ls_Qry);

			if($Ls_Rg){

				$row_Ls_Rg = $Ls_Rg->fetch_assoc();
				$Tot_Ls_Rg = $Ls_Rg->num_rows;

				if($Tot_Ls_Rg > 0){

                    do{

						$__relac = json_decode($row_Ls_Rg['___relacion']);
	                    $__relac_go = '';

	                    foreach($__relac as $__relac_k=>$__relac_v){
							$__relac_go->{$__relac_v->key} = $__relac_v;
						}

						$__relac_go->id = $row_Ls_Rg['cntcd_rel'];
						$__relac_go->tt = ctjTx($row_Ls_Rg['tp_sisslc_tt'],'in');

	                    $__id = $row_Ls_Rg['cntcd_enc'];


	                    $img_th = _ImVrs([ 'img'=>$row_Ls_Rg['sisps_img'], 'f'=>DMN_FLE_PS ]);

	                    $_r[ $__id ] = [
											'id'=>$row_Ls_Rg['id_cntcd'],
											'enc'=>$row_Ls_Rg['cntcd_enc'],
											'cd'=>[
												'id'=>$row_Ls_Rg['cntcd_cd'],
												'tt'=>ctjTx($row_Ls_Rg['siscd_tt'],'in')
											],
											'ps'=>[
												'id'=>$row_Ls_Rg['id_sisps'],
												'tt'=>ctjTx($row_Ls_Rg['sisps_tt'],'in'),
												'img'=>[
													'fle'=>$row_Ls_Rg['sisps_img'],
													'url'=>$img_th
												]
											],
											'rel'=>$__relac_go,
											'fi'=>$row_Ls_Rg['cntcd_fi'],
											'fa'=>$row_Ls_Rg['cntcd_fa']
										];


                    } while ($row_Ls_Rg = $Ls_Rg->fetch_assoc());

	            }

            }

			$__cnx->_clsr($Ls_Rg);

		}


		return _jEnc($_r);

	}

	function GtCntTpCntcLs($p=NULL){

		global $__cnx;

		if(!isN($p['i'])){

			if(!isN($p['bd'])){ $_bd=$p['bd']; }else{ $_bd=''; }

			$_r['e'] = 'no';

			$Ls_Qry = "	SELECT
							id_cnttpcntc, cnttpcntc_enc, cnttpcntc_tp
						FROM
							"._BdStr($_bd).TB_CNT_TP_CNTC."
						INNER JOIN "._BdStr(DBM).TB_SIS_SLC." ON cnttpcntc_tp = id_sisslc
						WHERE
							cnttpcntc_cnt = ".$p['i']."
						ORDER BY
							sisslc_tt ASC";

			$Ls_Rg = $__cnx->_qry($Ls_Qry);

			if($Ls_Rg){

				$row_Ls_Rg = $Ls_Rg->fetch_assoc();
				$Tot_Ls_Rg = $Ls_Rg->num_rows;

				if($Tot_Ls_Rg > 0){

	                $_r['e'] = 'ok';

                    do{

	                    $__id = $row_Ls_Rg['cnttpcntc_enc'];

	                    $_r['ls'][$__id] = [ 'id'=>$row_Ls_Rg['id_cnttpcntc'], 'tp'=>$row_Ls_Rg['cnttpcntc_tp'] ];

                    } while ($row_Ls_Rg = $Ls_Rg->fetch_assoc());
	            }
            }

			$__cnx->_clsr($Ls_Rg);
		}

		return _jEnc($_r);
	}

	function GtOrgCntLs($p=NULL){

		global $__cnx;

		if(!isN($p['i'])){

			if(!isN($p['bd'])){ $_bd=$p['bd']; }else{ $_bd=''; }

			$Ls_Qry_His = "SELECT org_enc, id_siscd, siscd_tt, orgsds_nm, org_nm, orgsdscnt_enc, org_img, org_clr, orgsdscnt_cnt, siscd_enc, id_sisps, sisps_tt, sisps_img, orgsdscnt_tpr,
								"._QrySisSlcF([ 'als'=>'tp', 'als_n'=>'tipo' ]).",
								".GtSlc_QryExtra(['t'=>'fld', 'p'=>'tp', 'als'=>'tp']).",
								".GtSlc_QryExtra(['t'=>'fld', 'p'=>'tpr', 'als'=>'tpr'])."
							FROM
								".$_bd.TB_ORG_SDS_CNT."
								INNER JOIN ".$_bd.TB_CNT." ON orgsdscnt_cnt = id_cnt
								INNER JOIN "._BdStr(DBM).TB_ORG_SDS." ON orgsdscnt_orgsds = id_orgsds
								INNER JOIN "._BdStr(DBM).TB_ORG." ON orgsds_org = id_org

								INNER JOIN "._BdStr(DBM).TB_SIS_CD." ON orgsds_cd = id_siscd
								INNER JOIN "._BdStr(DBM).TB_SIS_CD_DP." ON siscd_dp = id_siscddp
								INNER JOIN "._BdStr(DBM).TB_SIS_PS." ON siscddp_ps = id_sisps

							".GtSlc_QryExtra(['t'=>'tb', 'col'=>'orgsdscnt_tpr_o', 'als'=>'tp'])."
							".GtSlc_QryExtra(['t'=>'tb', 'col'=>'orgsdscnt_tpr', 'als'=>'tpr'])."


					   	   WHERE orgsdscnt_cnt = ".$p['i']."
					   	   ORDER BY org_nm, orgsdscnt_fi DESC";

			$Ls_Rg = $__cnx->_qry($Ls_Qry_His);

			if($Ls_Rg){

				$row_Ls_Rg = $Ls_Rg->fetch_assoc(); $Tot_Ls_Rg = $Ls_Rg->num_rows;

				if($Tot_Ls_Rg > 0){

                    do{

						$__idm = $row_Ls_Rg['org_enc'];
						$__idt = $row_Ls_Rg['tp_sisslc_cns'];

	                    $__attr = json_decode($row_Ls_Rg['___tipo']);


	                    foreach($__attr as $__attr_k=>$__attr_v){
							$__tipo_go->{$__attr_v->key} = $__attr_v;
						}

	                    $_nm_sfx = '';
	                    $_nm_prfx = '';

	                    if($row_Ls_Rg['id_siscd'] != '1'){ $_nm_prfx = '('.ctjTx($row_Ls_Rg['siscd_tt'], 'in').') '; }
	                    if(!isN($row_Ls_Rg['orgsds_nm']) && $row_Ls_Rg['orgsds_nm'] != TX_PC){ $_nm_sfx = ' - '.ctjTx($row_Ls_Rg['orgsds_nm'], 'in'); }


	                    $_r[$__idt]['id'] = $row_Ls_Rg['orgtp_tp'];
						$_r[$__idt]['tt'] = ctjTx($row_Ls_Rg['tp_sisslc_tt'],'in');
						$_r[$__idt]['enc'] = ctjTx($row_Ls_Rg['tp_sisslc_enc'],'in');
						$_r[$__idt]['cns'] = ctjTx($row_Ls_Rg['tp_sisslc_cns'],'in');
						$_r[$__idt]['img'] = DMN_FLE_SIS_SLC.$row_Ls_Rg['tp_sisslc_img'];


						$_r[$__idt]['ls'][$__idm]['nm'] = $_nm_prfx.ctjTx($row_Ls_Rg['org_nm'],'in').$_nm_sfx;
						$_r[$__idt]['ls'][$__idm]['r_enc'] = ctjTx($row_Ls_Rg['orgsdscnt_enc'],'in');

						$_r[$__idt]['ls'][$__idm]['enc'] = ctjTx($row_Ls_Rg['org_enc'],'in');


						$_r[$__idt]['ls'][$__idm]['img'] = _ImVrs(['img'=>$row_Ls_Rg['org_img'], 'f'=>DMN_FLE_ORG ]);
						$_r[$__idt]['ls'][$__idm]['clr'] = ctjTx($row_Ls_Rg['org_clr'],'in');

						$_r[$__idt]['ls'][$__idm]['cnt'] = $row_Ls_Rg['orgsdscnt_cnt'];




						//$Vl['id'] = $row_Ls_Rg['id_siscd'];

						$_r[$__idt]['ls'][$__idm]['cd']['enc'] = ctjTx($row_Ls_Rg['siscd_enc'], 'in');
						$_r[$__idt]['ls'][$__idm]['cd']['tt'] = ctjTx($row_Ls_Rg['siscd_tt'], 'in');


						$img_th = _ImVrs([ 'img'=>$row_Ls_Rg['sisps_img'], 'f'=>DMN_FLE_PS ]);

						$_r[$__idt]['ls'][$__idm]['ps'] =[
															'id'=>$row_Ls_Rg['id_sisps'],
															'tt'=>ctjTx($row_Ls_Rg['sisps_tt'],'in'),
															'img'=>[
																'fle'=>$row_Ls_Rg['sisps_img'],
																'url'=>$img_th
															]
														];




						$_r[$__idt]['ls'][$__idm]['tpr']['id'] = $row_Ls_Rg['orgsdscnt_tpr'];
						$_r[$__idt]['ls'][$__idm]['tpr']['tt'] = ctjTx($row_Ls_Rg['tpr_sisslc_tt'],'in');
						$_r[$__idt]['ls'][$__idm]['tpr']['cns'] = ctjTx($row_Ls_Rg['tpr_sisslc_cns'],'in');
						$_r[$__idt]['ls'][$__idm]['tpr']['img'] = DMN_FLE_SIS_SLC.$row_Ls_Rg['tpr_sisslc_img'];

						$_r[$__idt]['ls'][$__idm]['tp']['id'] = $row_Ls_Rg['orgtp_tp'];
						$_r[$__idt]['ls'][$__idm]['tp']['tt'] = ctjTx($row_Ls_Rg['tp_sisslc_tt'],'in');
						$_r[$__idt]['ls'][$__idm]['tp']['cns'] = ctjTx($row_Ls_Rg['tp_sisslc_cns'],'in');
						$_r[$__idt]['ls'][$__idm]['tp']['img'] = DMN_FLE_SIS_SLC.$row_Ls_Rg['tp_sisslc_img'];
						$_r[$__idt]['ls'][$__idm]['tp']['attr'] = $__tipo_go;



                    } while ($row_Ls_Rg = $Ls_Rg->fetch_assoc());

	            }

				if(is_array($_c)){ $__c = implode(',', $_c); } else{ $__c = $_c; }

			}else{

				$_r['w'] = 'GtOrgCntLs:'.$__cnx->c_r->error;

			}

			$__cnx->_clsr($Ls_Rg);

			$rtrn = _jEnc($_r);
			if($p['r'] == 'c'){ return($__c); }else{ return($rtrn); }
		}
	}

	function GtCntDcLs($p=NULL){

		global $__cnx;

		if(!isN($p['i'])){

			if(!isN($p['bd'])){ $_bd=$p['bd']; }else{ $_bd=''; }

			$Ls_Qry_His = " SELECT cntdc_dc, cntdc_tp, cntplcy_sndi, "._QrySisSlcF()."
							FROM "._BdStr($_bd).TB_CNT_DC."
								  INNER JOIN "._BdStr(DBM).TB_SIS_SLC." ON cntdc_tp = id_sisslc
								  LEFT JOIN ".$_bd.TB_CNT_PLCY." ON (cntplcy_cnt = cntdc_cnt AND cntplcy_sndi=1)
								  LEFT JOIN "._BdStr(DBM).TB_CL_PLCY." ON (cntplcy_plcy = id_clplcy AND clplcy_e=1)
							WHERE cntdc_cnt = ".$p['i']."
							ORDER BY cntdc_fi DESC";


			$Ls_Rg = $__cnx->_qry($Ls_Qry_His);

			if($Ls_Rg){

				$row_Ls_Rg = $Ls_Rg->fetch_assoc();
				$Tot_Ls_Rg = $Ls_Rg->num_rows;

				if($Tot_Ls_Rg > 0){

					do{

						$___col = CG_Array(['f'=>$row_Ls_Rg['___fld'], 'k'=>'key' ]);

						$__dc_nrml = 	_plcy_scre([
											'v'=>$row_Ls_Rg['cntdc_dc'],
											'plcy'=>[ 'e'=>$row_Ls_Rg['cntplcy_sndi'] ]
										]);


						$_r['r'][] .= $__dc_nrml;
						$_r['c'][] = $__dc_nrml;
						$_r['a'][] =['t'=>ctjTx($___col->sg->vl,'in'), 'n'=>$__dc_nrml];
						$_r['m'][] = ctjTx($___col->sg->vl,'in').$__dc_nrml;
						$_r['t'][] = $row_Ls_Rg['id_sisdoc'];


						if(($row_Ls_Rg['id_sisdoc'] == 1) && $p['r'] == 'l'){
							$_r['l']['dc'] = $__dc_nrml;
							$_r['l']['tp'] = ctjTx($___col->sg->vl,'in');
							$_r['l']['tp_id'] = $row_Ls_Rg['cntdc_tp'];
							break;
						}else{
							$_r['l']['dc'] = $__dc_nrml;
							$_r['l']['tp'] = ctjTx($___col->sg->vl,'in');
							$_r['l']['tp_id'] = $row_Ls_Rg['cntdc_tp'];
						}

					} while ($row_Ls_Rg = $Ls_Rg->fetch_assoc());

				}

			}

			$__cnx->_clsr($Ls_Rg);

			$rtrn = _jEnc($_r);
			return($rtrn);
		}
	}


	function GtCntPrntDt($p=NULL){

		global $__cnx;

		if(!isN($p['enc'])){
			$__fl .= "cntprnt_enc = ".GtSQLVlStr($p['enc'], "text");
		}elseif(!isN($p['cnt2'])){
			$__fl .= "cntprnt_cnt_2 = ".GtSQLVlStr($p['cnt2'], "text");
		}else{
			$__fl .= "id_cntprnt = ".GtSQLVlStr($p['id'], "text");
		}

		if( !isN($p['fnc']) && $p['fnc'] == 1 ){ $__fl .= " AND cntprnt_rsp_fnc = 1"; }
		if( !isN($p['est']) && $p['est'] == 1 ){ $__fl .= " AND cntprntest_est = 1"; $____fl = " LEFT JOIN "._BdStr($p['bd']).TB_CNT_PRNT_EST." ON id_cntprnt = cntprntest_cntprnt "; }

		$Ls_Qry_His = "	SELECT * FROM "._BdStr($p['bd']).TB_CNT_PRNT." $____fl WHERE $__fl ";

		$Ls_Rg = $__cnx->_qry($Ls_Qry_His);

		if($Ls_Rg){

			$row_Ls_Rg = $Ls_Rg->fetch_assoc(); $Tot_Ls_Rg = $Ls_Rg->num_rows;

			$Vl['tot'] = $Tot_Ls_Rg;

			if($Tot_Ls_Rg > 0){

                do{

	                $_id = $row_Ls_Rg['id_cntprnt'];
	                $Vl['id'] = $_id;
	                $Vl['enc'] = ctjTx($row_Ls_Rg['cntprnt_enc'],'in');
	                $Vl['cnt1'] = ctjTx($row_Ls_Rg['cntprnt_cnt_1'],'in');
	                $Vl['cnt2'] = ctjTx($row_Ls_Rg['cntprnt_cnt_2'],'in');

                } while ($row_Ls_Rg = $Ls_Rg->fetch_assoc());
           	}

       	}

       	$__cnx->_clsr($Ls_Rg);

		$rtrn = _jEnc($Vl);
		return($rtrn);
	}



	function GtCntTpDt($_p=NULL){

		global $__cnx;

		if(is_array($_p)){
			if(($_p['id']!=NULL)){


				if($_p['t']=='key'){ $__f = 'siscnttp_key'; $__ft = 'text'; }elseif($_p['t']=='enc'){ $__f = 'siscnttp_enc'; $__ft = 'text'; }else{ $__f = 'id_siscnttp'; $__ft = 'int'; }


				$query_DtRg = sprintf("SELECT * FROM "._BdStr(DBM).TB_SIS_CNT_TP." WHERE {$__f} = %s", GtSQLVlStr($_p['id'], $__ft)); //echo $query_DtRg;

				$DtRg = $__cnx->_qry($query_DtRg); //echo $__cnx->c_r->error;


				if($DtRg){

					$row_DtRg = $DtRg->fetch_assoc();
					$Tot_DtRg = $DtRg->num_rows;

					if($Tot_DtRg > 0){
						$Vl['id'] = $row_DtRg['id_siscnttp'];
						$Vl['tt'] = ctjTx($row_DtRg['siscnttp_nm'],'in');
					}

				}

				$__cnx->_clsr($DtRg);

			}
		}

		$rtrn = _jEnc($Vl);
		return($rtrn);

	}



	function GtCntTpGrpDt($_p=NULL){

		global $__cnx;

		$Vl['e'] = 'no';

		if(is_array($_p)){

			if(!isN($_p['id'])){

				if($_p['t']=='key'){ $__f = 'siscnttpgrp_key'; $__ft = 'text'; }
				elseif($_p['t']=='enc'){ $__f = 'siscnttpgrp_enc'; $__ft = 'text'; }
				else{ $__f = 'id_siscnttpgrp'; $__ft = 'int'; }


				$query_DtRg = sprintf("SELECT * FROM "._BdStr(DBM).TB_SIS_CNT_TP_GRP." WHERE {$__f} = %s", GtSQLVlStr($_p['id'], $__ft));

				//$Vl['q'] = $query_DtRg;

				$DtRg = $__cnx->_qry($query_DtRg); //echo $__cnx->c_r->error;

				if($DtRg){

					$row_DtRg = $DtRg->fetch_assoc();
					$Tot_DtRg = $DtRg->num_rows;

					if($Tot_DtRg > 0){
						$Vl['id'] = $row_DtRg['id_siscnttpgrp'];
						$Vl['enc'] = ctjTx($row_DtRg['siscnttpgrp_enc'],'in');
						$Vl['tt'] = ctjTx($row_DtRg['siscnttpgrp_nm'],'in');
					}

				}else{

					$Vl['w'] = $__cnx->c_r->error;

				}

				$__cnx->_clsr($DtRg);

			}else{

				$Vl['w'] = 'no data';

			}
		}

		$rtrn = _jEnc($Vl);
		return($rtrn);

	}


	function GtCntTot($p=NULL){

		global $__cnx;


		$Vl['e'] = 'no';

		if(!isN($p['id'])){


			if(!isN($p['bd'])){ $bd = _BdStr($p['bd']); }

			$Tot_Mdl = ', (SELECT COUNT(*) FROM '.$bd.TB_MDL_CNT.' WHERE mdlcnt_cnt = id_cnt ) AS __tot_pro';
			//$Tot_Mdl_Pay = ', (SELECT COUNT(*) FROM '.$bd.TB_MDL_CNT_PAY_BD.' WHERE mdlcntpay_cnt = id_cnt ) AS __tot_mdl_pay';


			$Tot_Tp = ', (SELECT COUNT(*) FROM '.$bd.TB_CNT_TP.' WHERE cnttp_cnt = id_cnt ) AS __tot_tp';
			//$Tot_Tag = ', (SELECT COUNT(*) FROM '.MDL_CNT_TAG_BD.' WHERE cnttag_cnt = id_cnt ) AS __tot_tag';
			$Tot_Eml = ', (SELECT COUNT(*) FROM '.$bd.TB_CNT_EML.' WHERE cnteml_cnt = id_cnt ) AS __tot_eml';
			$Tot_Dc = ', (SELECT COUNT(*) FROM '.$bd.TB_CNT_DC.' WHERE cntdc_cnt = id_cnt ) AS __tot_dc';
			$Tot_Tel = ', (SELECT COUNT(*) FROM '.$bd.TB_CNT_TEL.' WHERE cnttel_cnt = id_cnt ) AS __tot_tel';
			$Tot_Snd = ', (SELECT COUNT(*) FROM '.$bd.TB_EC_SND.' WHERE ecsnd_cnt = id_cnt ) AS __tot_snd';
			$Tot_Cref = ', (SELECT COUNT(*) FROM '.$bd.TB_CNT_CREF.' WHERE cntcref_cnt_ref = id_cnt ) AS __tot_cref';

			/* Trabajar despues
			$Tot_Fll_Org = ', (SELECT COUNT(*) FROM '.MDL_CNT_FLL_ORG_BD.' WHERE cntfllorg_cnt = id_cnt ) AS __tot_fll_org';
			$Tot_Fll_Pht = ', (SELECT COUNT(*) FROM '.MDL_CNT_FLL_PHT_BD.' WHERE cntfllpht_cnt = id_cnt ) AS __tot_fll_pht';
			$Tot_Fll_Scl = ', (SELECT COUNT(*) FROM '.MDL_CNT_FLL_SCL_BD.' WHERE cntfllscl_cnt = id_cnt ) AS __tot_fll_scl';
			$Tot_Fll_Tpc = ', (SELECT COUNT(*) FROM '.MDL_CNT_FLL_TPC_BD.' WHERE cntflltpc_cnt = id_cnt ) AS __tot_fll_tpc';

			$Tot_Mdl_Cdgc = ', (SELECT COUNT(*) FROM '.TB_MDL_CNT_CDGC_BD.','.TB_MDL_CNT.' WHERE mdlcntcdgc_cnt = id_mdlcnt AND mdlcnt_cnt = id_cnt ) AS __tot_mdl_cdgc';

			$Tot_Mdl_Ent = ', (SELECT COUNT(*) FROM '.TB_MDL_CNT_ENT_BD.','.TB_MDL_CNT.' WHERE mdlcntent_ent = id_mdlcnt AND mdlcnt_cnt = id_cnt ) AS __tot_mdl_ent';
			$Tot_Mdl_Est = ', (SELECT COUNT(*) FROM '.TB_MDL_CNT_EST_BD.','.TB_MDL_CNT.' WHERE mdlcntest_mdlcnt = id_mdlcnt AND mdlcnt_cnt = id_cnt ) AS __tot_mdl_est';
			$Tot_Mdl_His = ', (SELECT COUNT(*) FROM '.TB_MDL_CNT_HIS_BD.','.TB_MDL_CNT.' WHERE mdlcnthis_mdlcnt = id_mdlcnt AND mdlcnt_cnt = id_cnt ) AS __tot_mdl_his';
			$Tot_Mdl_Msj = ', (SELECT COUNT(*) FROM '.TB_MDL_CNT_MSJ_BD.','.TB_MDL_CNT.' WHERE mdlcntmsj_mdlcnt = id_mdlcnt AND mdlcnt_cnt = id_cnt ) AS __tot_mdl_msj';
			$Tot_Mdl_Vst = ', (SELECT COUNT(*) FROM '.TB_MDL_CNT_VST_BD.','.TB_MDL_CNT.' WHERE mdlcntvst_mdlcnt = id_mdlcnt AND mdlcnt_cnt = id_cnt ) AS __tot_mdl_vst';
			*/




			$query_DtRg = sprintf('SELECT * ' . $Tot_Mdl . $Tot_Mdl_Pay .
											    $Tot_Tp . $Tot_Tag . $Tot_Eml . $Tot_Dc . $Tot_Tel .
											    $Tot_Fll_Org . $Tot_Fll_Pht . $Tot_Fll_Scl . $Tot_Fll_Tpc . $Tot_Snd . $Tot_Cref .
												$Tot_Mdl_Cdgc . $Tot_Mdl_Ent . $Tot_Mdl_Est . $Tot_Mdl_His . $Tot_Mdl_Msj . $Tot_Mdl_Prd .  $Tot_Mdl_Vst .

								  ' FROM '.TB_CNT.'
								    WHERE id_cnt = %s
								    LIMIT 1', GtSQLVlStr($p['id'],'int'));

			$DtRg = $__cnx->_qry($query_DtRg);

			if($DtRg){

				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;

				if($Tot_DtRg > 0){

					$Vl['mdl'] = $row_DtRg['__tot_mdl'];
					$Vl['mdl_pay'] = $row_DtRg['__tot_mdl_pay'];

					$Vl['cnttp'] = $row_DtRg['__tot_tp'];
					$Vl['tag'] = $row_DtRg['__tot_tag'];
					$Vl['eml'] = $row_DtRg['__tot_eml'];
					$Vl['dc'] = $row_DtRg['__tot_dc'];
					$Vl['tel'] = $row_DtRg['__tot_tel'];
					$Vl['snd'] = $row_DtRg['__tot_snd'];
					$Vl['cref'] = $row_DtRg['__tot_cref'];

					$Vl['fll_org'] = $row_DtRg['__tot_fll_org'];
					$Vl['fll_pht'] = $row_DtRg['__tot_fll_pht'];
					$Vl['fll_scl'] = $row_DtRg['__tot_fll_scl'];
					$Vl['fll_tpc'] = $row_DtRg['__tot_fll_tpc'];



					$Vl['l1'] = $row_DtRg['__tot_evn']+
								$row_DtRg['__tot_tp']+$row_DtRg['__tot_tag']+$row_DtRg['__tot_eml']+$row_DtRg['__tot_dc']+$row_DtRg['__tot_tel']+$row_DtRg['__tot_clg']+$row_DtRg['__tot_act']+$row_DtRg['__tot_sds']+$row_DtRg['__tot_snd']+
								$row_DtRg['__tot_fll_org']+$row_DtRg['__tot_fll_pht']+$row_DtRg['__tot_fll_scl']+$row_DtRg['__tot_fll_tpc']+
								$row_DtRg['__tot_pro'];

					$Vl['mdl_cdgc'] = $row_DtRg['__tot_mdl_cdgc'];

					$Vl['mdl_ent'] = $row_DtRg['__tot_mdl_ent'];
					$Vl['mdl_est'] = $row_DtRg['__tot_mdl_est'];
					$Vl['mdl_his'] = $row_DtRg['__tot_mdl_his'];
					$Vl['mdl_msj'] = $row_DtRg['__tot_mdl_msj'];
					$Vl['mdl_prd'] = $row_DtRg['__tot_mdl_prd'];
					$Vl['mdl_vst'] = $row_DtRg['__tot_mdl_vst'];

					$Vl['l2'] = $row_DtRg['__tot_mdl_pay']+
								$row_DtRg['__tot_mdl_cdgc']+
								$row_DtRg['__tot_mdl_ent']+
								$row_DtRg['__tot_mdl_est']+
								$row_DtRg['__tot_mdl_his']+
								$row_DtRg['__tot_mdl_msj']+
								$row_DtRg['__tot_mdl_prd']+
								$row_DtRg['__tot_mdl_vst'];

					$Vl['l_t'] = $Vl['l1'] + $Vl['l2'];
				}

			}else{

				$Vl['w'] = $__cnx->c_r->error;

			}

			$__cnx->_clsr($DtRg);

		}else{

			$Vl['w'] = 'no data';

		}

		return(_jEnc($Vl));
	}



	function GtCntDcDt($_p=NULL){

		global $__cnx;

		if(is_array($_p)){

			if(!isN($_p['id'])){

				if(!isN($_p['bd'])){ $__bdprfx=_BdStr($_p['bd']); }

				if($_p['t'] == 'enc'){ $__f = 'cntdc_enc'; $__ft = 'text'; }
				elseif($_p['t'] == 'dc'){ $__f = 'cntdc_dc'; $__ft = 'text'; }
				else{ $__f = 'id_cntdc'; $__ft = 'int'; }

				$query_DtRg = sprintf("SELECT * FROM ".$__bdprfx.TB_CNT_DC." WHERE {$__f} = %s", GtSQLVlStr($_p['id'], $__ft));
				$DtRg = $__cnx->_qry($query_DtRg);

				if($DtRg){
					$row_DtRg = $DtRg->fetch_assoc();
					$Tot_DtRg = $DtRg->num_rows;

					if($Tot_DtRg > 0){
						$Vl['e'] = 'ok';
						$Vl['id'] = $row_DtRg['id_cntdc'];
						$Vl['enc'] = $row_DtRg['cntdc_enc'];
						$Vl['dc'] = $row_DtRg['cntdc_dc'];
					}else{
						$Vl['e'] = 'no';
					}
				}else{
					//echo $__cnx->c_r->error;
				}

				if(isN($_p['cnx'])){ $__cnx->_clsr($DtRg); }

			return _jEnc($Vl);
			}
		}
	}


	function GtCntTelDt($_p=NULL){

		global $__cnx;

		$Vl['e'] = 'no';

		if(is_array($_p)){

			if(!isN($_p['id'])){

				if(!isN($_p['bd'])){ $__bdprfx = _BdStr($_p['bd']); }

				if($_p['t'] == 'enc'){ $__f = 'cnttel_enc'; $__ft = 'text';
				}elseif($_p['t'] == 'no'){ $__f = 'cnttel_tel'; $__ft = 'text';
				}else{ $__f = 'id_cnttel'; $__ft = 'int'; }

				if(!isN($_p['ps'])){ $__fl .= ' AND cnttel_ps = "'.$_p['ps'].'" '; }

				$query_DtRg = sprintf("	SELECT *
										FROM ".$__bdprfx.TB_CNT_TEL."
											 NNER JOIN "._BdStr(DBM).TB_SIS_PS." ON cnttel_ps = id_sisps
										WHERE {$__f} = %s {$__fl}",
									GtSQLVlStr($_p['id'], $__ft));

				$DtRg = $__cnx->_qry($query_DtRg); //echo $query_DtRg.'->'.$__cnx->c_r->error;

				if($DtRg){
					$row_DtRg = $DtRg->fetch_assoc();
					$Tot_DtRg = $DtRg->num_rows;

					$Vl['tot'] = $Tot_DtRg;

					if($Tot_DtRg > 0){

						$Vl['e'] = 'ok';

						$Vl['id'] = $row_DtRg['id_cnttel'];
						$Vl['enc'] = $row_DtRg['cnttel_enc'];
						$Vl['cnt'] = [
							'id'=>$row_DtRg['cnttel_cnt']
						];

						$Vl['tel'] = $row_DtRg['cnttel_tel'];
						$Vl['ext'] = $row_DtRg['cnttel_ext'];

						//$Vl['sndi'] = mBln($row_DtRg['cnttel_sndi']);
						//$Vl['sms'] = mBln($row_DtRg['cnttel_sms']);
						//$Vl['whtsp'] = mBln($row_DtRg['cnttel_whtsp']);


						$img_th = _ImVrs([ 'img'=>$row_DtRg['sisps_img'], 'f'=>DMN_FLE_PS ]);


						$Vl['ps'] = [
							'id'=>$row_DtRg['cnttel_ps'],
							'cod'=>$row_DtRg['sisps_tel'],
							'img'=>[
								'fle'=>$row_DtRg['sisps_img'],
								'url'=>$img_th
							]
						];


						$Vl['teln'] = $row_DtRg['sisps_tel'].$row_DtRg['cnttel_tel'];
						$Vl['telc'] = '+'.$row_DtRg['sisps_tel'].$row_DtRg['cnttel_tel'];

						$Vl['plcy'] = GtCntTelPlcyLs([ 'bd'=>$__bdprfx, 'cl'=>$p['cl'], 'tel'=>$row_DtRg['id_cnttel'] ]);


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



	function GtCntRelData($_p=NULL){

		global $__cnx;

		$Vl['e'] = 'no';

		if(is_array($_p)){

			if(!isN($_p['ecsnd'])){

				if(!isN($_p['bd'])){ $__bdprfx= _BdStr($_p['bd']); }

				if($_p['cmpg']=='ok'){

					$__qry_get_cmp = ' , (
											SELECT ecsndcmpg_cmpg
											FROM '.$__bdprfx.TB_EC_SND_CMPG.'
											WHERE ecsndcmpg_snd = id_ecsnd
											LIMIT 1
										) AS __idcmpg
									';

				}

				$query_DtRg = sprintf("	SELECT
											id_ecsnd,
											(
												SELECT mdlcntec_mdlcnt
												FROM ".$__bdprfx.TB_CNT_SND."
												WHERE mdlcntec_ecsnd = id_ecsnd
												LIMIT 1
											) AS __mdlcnt,

											(
												SELECT id_cntdvrf
												FROM ".$__bdprfx.TB_CNT_DVRF."
												WHERE cntdvrf_eml_snd = id_ecsnd
												LIMIT 1
											) AS __iddvrf,

											(
												SELECT id_ecsndr
												FROM ".$__bdprfx.TB_EC_SND_R."
												WHERE ecsndr_ecsnd = id_ecsnd
												LIMIT 1
											) AS __idecsndr

											{$__qry_get_cmp}

										FROM ".$__bdprfx.TB_EC_SND."
										WHERE id_ecsnd=%s",
											  GtSQLVlStr($_p['ecsnd'], 'int')

									);

				$DtRg = $__cnx->_qry($query_DtRg);

				//$Vl['tmp_q'] = compress_code( $query_DtRg );

				if($DtRg){

					$row_DtRg = $DtRg->fetch_assoc();
					$Tot_DtRg = $DtRg->num_rows;

					if($Tot_DtRg > 0){

						$Vl['e'] = 'ok';
						$Vl['id'] = $row_DtRg['id_ecsnd'];

						if(!isN($row_DtRg['__mdlcnt'])){ $Vl['mdlcnt']['id'] = $row_DtRg['__mdlcnt']; }
						if(!isN($row_DtRg['__iddvrf'])){ $Vl['dvrf']['id'] = $row_DtRg['__iddvrf']; }
						if(!isN($row_DtRg['__idecsndr'])){ $Vl['sndr']['id'] = $row_DtRg['__idecsndr']; }
						if(!isN($row_DtRg['__idcmpg'])){ $Vl['cmpg']['id'] = $row_DtRg['__idcmpg']; }

					}else{
						$Vl['e'] = 'no';
					}

				}else{

					$Vl['q'] = $__cnx->c_r->error;

				}

				$__cnx->_clsr($DtRg);

			}else{

				$Vl['w'] = '$_p[ecsnd] is empty';

			}

		}else{

			$Vl['w'] = 'No data on array';

		}

		return _jEnc($Vl);

	}



	function GtCntDvrfDt($_p=NULL){

		global $__cnx;

		$Vl['e'] = 'no';

		if(is_array($_p)){

			if(!isN($_p['id']) || !isN($_p['cod'])){

				if(!isN($_p['bd'])){ $__bdprfx= _BdStr($_p['bd']); }

				if($_p['t'] == 'enc'){ $__f = 'cntdvrf_enc'; $__ft = 'text'; }
				elseif($_p['t'] == 'cod'){ $__f = 'cntdvrf_cod'; $__ft = 'text'; }
				else{ $__f = 'id_cntdvrf'; $__ft = 'int'; }

				if(!isN($_p['cnt'])){ $__fl .= ' AND cntdvrf_cnt='.GtSQLVlStr($_p['cnt'], 'text').' '; }

				$query_DtRg = sprintf("SELECT *  FROM ".$__bdprfx.TB_CNT_DVRF." WHERE {$__f} = %s {$__fl}", GtSQLVlStr($_p['id'], $__ft));
				$DtRg = $__cnx->_qry($query_DtRg);

				//$Vl['q'] = $query_DtRg;


				if($DtRg){

					$row_DtRg = $DtRg->fetch_assoc();
					$Tot_DtRg = $DtRg->num_rows;

					if($Tot_DtRg > 0){
						$Vl['e'] = 'ok';
						$Vl['id'] = $row_DtRg['id_cntdvrf'];
						$Vl['enc'] = $row_DtRg['cntdvrf_enc'];
						$Vl['cod'] = $row_DtRg['cntdvrf_cod'];
						$Vl['cnt'] = $row_DtRg['cntdvrf_cnt'];
						$Vl['hb'] = mBln($row_DtRg['cntdvrf_hb']);
					}else{
						$Vl['e'] = 'no';
					}

				}else{

					$Vl['w'] = $__cnx->c_r->error;

				}

				$__cnx->_clsr($DtRg);

			}else{

				$Vl['w'] = 'No all data';

			}

		}else{

			$Vl['w'] = 'No p data';

		}

		return _jEnc($Vl);
	}



	function GtCntDt($p=NULL){ //$Id, $p=NULL

		global $__cnx;

		$Vl['e'] = 'no';

		if(!isN($p['id'])){

			$__Cls_Cnt = new CRM_Cnt();

			if(!isN($p['bd'])){ $_bd=_BdStr($p['bd']); }else{ $_bd=''; }

			if($p['t']=='enc'){ $_fld='cnt_enc'; $_fld_t='text'; }else{ $_fld='id_cnt'; $_fld_t='int'; }

			//$query_DtRg = sprintf("CALL Dt_Cnt('%s')", GtSQLVlStr($c_DtRg,'int'));
			//$query_DtRg = sprintf("CALL Dt_Cnt('%s')", GtSQLVlStr($c_DtRg,'int'));

			$query_DtRg = sprintf("	SELECT id_cnt, cnt_enc, cnt_fn, cnt_nm, cnt_nm_chk, cnt_ap, cnt_ap_chk, cnt_dir, cnt_fi, cntplcy_sndi,
										   "._QrySisSlcF([ 'als'=>'c', 'als_n'=>'calidad' ]).",
										   ".GtSlc_QryExtra([ 't'=>'fld', 'p'=>'calidad', 'als'=>'c' ]).",
										   "._QrySisSlcF([ 'als'=>'s', 'als_n'=>'sexo' ]).",
										   ".GtSlc_QryExtra([ 't'=>'fld', 'p'=>'sexo', 'als'=>'s' ])."
									FROM ".$_bd.TB_CNT."
										 LEFT JOIN ".$_bd.TB_CNT_PLCY." ON (cntplcy_cnt = id_cnt AND cntplcy_sndi=1)
										 LEFT JOIN "._BdStr(DBM).TB_CL_PLCY." ON (cntplcy_plcy = id_clplcy AND clplcy_e=1)
										 ".GtSlc_QryExtra([ 't'=>'tb', 'col'=>'cnt_cld', 'als'=>'c' ])."
										 ".GtSlc_QryExtra([ 't'=>'tb', 'col'=>'cnt_sx', 'als'=>'s' ])."
									WHERE ".$_fld." = %s LIMIT 1", GtSQLVlStr($p['id'],$_fld_t) );

			//$Vl['qry'] = $query_DtRg;

			$__cnx->src_main = $_bd;

			if($p['cmmt']=='ok'){ //-- If use it on commit process --//
				$DtRg = $__cnx->_prc($query_DtRg);
			}else{
				$DtRg = $__cnx->_qry($query_DtRg);
			}

			if($DtRg){

				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;

				if($Tot_DtRg > 0){

					$Vl['id'] = $row_DtRg['id_cnt'];
					$Vl['enc'] = $row_DtRg['cnt_enc'];
					//Vl['cld'] = $row_DtRg['cnt_cld'];
					$Vl['fn'] = $row_DtRg['cnt_fn'];

					$__dc_f = GtCntDcLs([ 'i'=>$row_DtRg['id_cnt'], 'bd'=>$_bd ]);

					//============== Calidad del Lead ==============//

						$__calidad = json_decode($row_DtRg['___calidad']);

		                foreach($__calidad as $__tp_k=>$__tp_v){
							$__calidad_go[$__tp_v->key] = $__tp_v;
						}

						$Vl['cld'] = $__calidad_go;
						$Vl['cld']['id'] = ctjTx($row_DtRg['calidad_id_sisslc'],'in');
						$Vl['cld']['enc'] = ctjTx($row_DtRg['calidad_sisslc_enc'],'in');
						$Vl['cld']['tt'] = ctjTx($row_DtRg['calidad_sisslc_tt'],'in');

					//============== Genero Sexual ==============//

						$__sexo = json_decode($row_DtRg['___sexo']);

		                foreach($__sexo as $__tp_k=>$__tp_v){
							$__sexo_go[$__tp_v->key] = ctjTx($__tp_v,'in');
						}

						$Vl['sx'] = $__sexo_go;
						$Vl['sx']['id'] = ctjTx($row_DtRg['sexo_id_sisslc'],'in');
						$Vl['sx']['enc'] = ctjTx($row_DtRg['sexo_sisslc_enc'],'in');
						$Vl['sx']['tt'] = ctjTx($row_DtRg['sexo_sisslc_tt'],'in');


					//============== Documentos ==============//

					$Vl['dc'] = $__dc_f->l->dc;
					$Vl['dc_tp'] = $__dc_f->l->tp;

					$Vl['dc_c'] = $__dc_f->c;
					$Vl['dc_a'] = $__dc_f->a;
					$Vl['dc_m'] = $__dc_f->c;
					$Vl['dc_t'] = $__dc_f->t;

					if($row_DtRg['cntplcy_sndi'] == 1){
						$Vl['nm'] = ctjTx($row_DtRg['cnt_nm'],'in');
						$Vl['ap'] = ctjTx($row_DtRg['cnt_ap'],'in');
					}else{
						$Vl['nm'] = '-'._Cns('TX_ANYMUS').'-';
						$Vl['ap'] = '';
					}

					$Vl['chk']['nm'] = mBln($row_DtRg['cnt_nm_chk']);
					$Vl['chk']['ap'] = mBln($row_DtRg['cnt_ap_chk']);

					$Vl['dir'] = ctjTx($row_DtRg['cnt_dir'],'in');

					$__attr = GtAttrLs([ 't'=>'cnt', 'i'=>$row_DtRg['id_cnt'], 'bd'=>$_bd ]);

					$Vl['attr'] = $__attr->a;
					$Vl['attr_o'] = $__attr->o;

					$Vl['fll'] = Gt_FllCnt([ 'id'=>$row_DtRg['id_cnt'], 'bd'=>$_bd ]);

					$Vl['eml'] = GtCntEmlLs([ 'i'=>$row_DtRg['id_cnt'], 'bd'=>$_bd, 'cl'=>[ 'v'=>$p['cl'], 't'=>'enc' ], 'scre'=>( (!isN($p['scre']))? $p['scre'] : 'no'), 'eml_allw'=>$p['eml_allw'] ]);
					$Vl['eml_c'] = GtCntEmlLs([ 'i'=>$row_DtRg['id_cnt'], 'r'=>'c', 'cl'=>[ 'v'=>$p['cl'], 't'=>'enc' ], 'bd'=>$_bd ]);

					$Vl['org'] = GtOrgCntLs([ 'i'=>$row_DtRg['id_cnt'], 'bd'=>$_bd ]);
					$Vl['tel'] = GtCntTelLs([ 'i'=>$row_DtRg['id_cnt'], 'bd'=>$_bd, 'scre'=>( (!isN($p['scre']))? $p['scre'] : 'no') ]);
					$Vl['tel_c'] = GtCntTelLs([ 'i'=>$row_DtRg['id_cnt'], 'r'=>'c', 'bd'=>$_bd ]);
					$Vl['tel_all'] = GtCntTelLs([ 'i'=>$row_DtRg['id_cnt'], 'bd'=>$_bd, 'all'=>'ok' ]);
					$Vl['cd'] = GtCntCdLs([ 'i'=>$row_DtRg['id_cnt'], 'bd'=>$_bd ]);
					$Vl['tp_cntc'] = GtCntTpCntcLs([ 'i'=>$row_DtRg['id_cnt'], 'bd'=>$_bd ]);

					$Vl['bd'] = ctjTx($row_DtRg['sisbd_nm'],'in');
					$Vl['fi'] = ctjTx($row_DtRg['cnt_fi'],'in');
					$Vl['hi'] = ctjTx($row_DtRg['cnt_hi'],'in');

					if($p['count'] == 'ok'){ $Vl['count'] = GtCntTot([ 'bd'=>$_bd, 'id'=>$row_DtRg['id_cnt'] ]); };

					if($p['ls_tp'] == 'ok'){
						$__Cls_Cnt->cnt_enc = $row_DtRg['cnt_enc'];
						$Vl['ls_tp'] = $__Cls_Cnt->GtCntTpLs();
					}
					//if($p['ls_f_scl'] == 'ok'){ $Vl['ls_f_scl'] = GtFll_Scl_Dt(array('id'=>$row_DtRg['id_cnt'], 'f'=>'tag')); }
					//if($p['ls_f_org'] == 'ok'){ $Vl['ls_f_org'] = GtFll_Org_Dt(array('id'=>$row_DtRg['id_cnt'], 'f'=>'tag')); }
					//if($p['ls_f_tpc'] == 'ok'){ $Vl['ls_f_tpc'] = GtFll_Tpc_Dt(array('id'=>$row_DtRg['id_cnt'], 'f'=>'tag')); }


					$Vl['sndi'] = 'no';
					$Vl['plcy'] = $__plcy = GtCntPlcyLs([ 'bd'=>$_bd, 'cl'=>$p['cl'], 'cnt'=>$row_DtRg['id_cnt'] ]);

					if(!isN($__plcy->ls) && defined('SISUS_PLCY')){

						$_now_plcy = explode(',', SISUS_PLCY);

						foreach($__plcy->ls as $__plcy_k=>$__plcy_v){
							if(in_array($__plcy_v->id, $_now_plcy) && $__plcy_v->on == 'ok'){
								$Vl['sndi'] = 'ok';
							}
						}
					}


				}else{

					$Vl['w'] = 'No records';
					//$Vl['qry'] = compress_code($query_DtRg);

				}

			}else{

				if($p['cmmt']=='ok'){ //-- If use it on commit process --//
					$Vl['w'] = $__cnx->c_p->error;
				}else{
					$Vl['w'] = $__cnx->c_r->error;
				}

			}

			$__cnx->_clsr($DtRg);

		}else{

			$Vl['e_nodata'] = 'ok';

		}

		return _jEnc($Vl);

	}





	function GtCntEmlDt($_p=NULL){

		global $__cnx;

		if(!isN($_p['id'])){


			if(!isN($_p['bd'])){ $_bd=_BdStr($_p['bd']); }else{ $_bd=''; }

			if($_p['tp'] == 'enc'){ $__f = 'cnteml_enc'; $__ft = 'text'; }
			elseif($_p['tp'] == 'eml'){ $__f = 'cnteml_eml'; $__ft = 'text'; }
			else{ $__f = 'id_cnteml'; $__ft = 'int'; }

			$c_DtRg = "-1";if (isset($_p['id'])){$c_DtRg = $_p['id'];}


			$query_DtRg = sprintf('	SELECT 	id_cnteml, cnteml_enc, cnteml_eml,
											cnteml_rjct, cnteml_est, cnteml_cnt,
											cnteml_cld
									FROM '.$_bd.VW_CNT_EML.'
									WHERE '.$__f.'=%s
									LIMIT 1',
							GtSQLVlStr( strtolower($c_DtRg) , $__ft));

			$DtRg = $__cnx->_qry($query_DtRg,['cmps'=>'ok']);

			if($DtRg){

				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;

				$Vl['tot'] = $Tot_DtRg;

				if($Tot_DtRg > 0){

					$Vl['id'] = $row_DtRg['id_cnteml'];
					$Vl['eml'] = ctjTx($row_DtRg['cnteml_eml'],'in');
					$Vl['enc'] = ctjTx($row_DtRg['cnteml_enc'],'in');
					$Vl['rjct'] = mBln($row_DtRg['cnteml_rjct']);

					//$Vl['sndi'] = mBln($row_DtRg['cnteml_sndi']);

					$Vl['est'] = [
						'id'=>ctjTx($row_DtRg['cnteml_est'],'in')
					];

					$Vl['cnt'] = [
						'id'=>ctjTx($row_DtRg['cnteml_cnt'],'in')
					];

					$Vl['cld'] = ctjTx($row_DtRg['cnteml_cld'],'in');

				}

			}else{

				$_r['w'] = 'GtCntEmlDt:'.$__cnx->c_r->error;

			}

		}

		if(isN($_p["cnx"])){
			$__cnx->_clsr($DtRg);
		}

		if($_p['d']['plcy']=='ok' && !isN($row_DtRg['id_cnteml'])){
			$Vl['plcy'] = GtCntEmlPlcyLs([ 'bd'=>$_bd, 'cl'=>$_p['cl'], 'eml'=>$row_DtRg['id_cnteml'] ]);
		}

		return(_jEnc($Vl));

	}

	function GtCntAttrChkDt($_p=NULL){

		global $__cnx;

		$Vl['e'] = 'no';

		if(!isN($_p['id'])){

			if(!isN($_p['bd'])){ $_bd=_BdStr($_p['bd']); }else{ $_bd=''; }

			$c_DtRg = "-1";if (isset($_p['id'])){$c_DtRg = $_p['id'];}


			$query_DtRg = sprintf('	SELECT *
									FROM '.$_bd.'cnt_attr
									WHERE cntattr_cnt=(SELECT id_cnt FROM '.$_bd.'cnt WHERE cnt_enc = %s) AND cntattr_attr=%s
									LIMIT 1',
							GtSQLVlStr( $_p['cnt'] , 'text'), GtSQLVlStr( $_p['id'] , 'int') );

			$DtRg = $__cnx->_qry($query_DtRg);

			if($DtRg){

				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;

				$Vl['tot'] = $Tot_DtRg;

				if($Tot_DtRg > 0){

					$Vl['e'] = 'ok';
					$Vl['id'] = $row_DtRg['id_cntattr'];
					$Vl['enc'] = ctjTx($row_DtRg['cntattr_enc'],'in');
					$Vl['cnt'] = ctjTx($row_DtRg['cntattr_cnt'],'in');
					$Vl['attr'] = ctjTx($row_DtRg['cntattr_attr'],'in');

				}

			}

		}

		if(isN($_p["cnx"])){ $__cnx->_clsr($DtRg); }
		return(_jEnc($Vl));

	}

	function GtEmlAttrLs($p=NULL){

		global $__cnx;

		if(!isN($p['eml'])){ $_fl .= " AND emlattr_id = ".$p['eml'].""; }

		$Dt_Qry = "	SELECT *
						FROM "._BdStr(DBT).TB_THRD_EML_ATTR."
						WHERE emlattr_tp = 'eml' AND id_emlattr != '' {$_fl}";

		$DtRg = $__cnx->_qry($Dt_Qry);

		if($DtRg){

			$row_DtRg = $DtRg->fetch_assoc();
			$Tot_DtRg = $DtRg->num_rows;

			if($Tot_DtRg > 0){

	            do{

					if(is_numeric($row_DtRg['emlattr_vl'])){
						$__vl = _Nmb($row_DtRg['emlattr_vl'], 3);
					}else{
						$__vl = $row_DtRg['emlattr_vl'];
					}

					$_r[ $row_DtRg['emlattr_key'] ] = ctjTx($__vl,'in');

				} while ($row_DtRg = $DtRg->fetch_assoc());
	        }
        }

		$__cnx->_clsr($DtRg);
		return _jEnc($_r);

	}

	function GtVtexCmpgInsDt($p=NULL){

		global $__cnx;

		if(!isN($p["id"])){

			if(!isN($p['bd'])){
				$_bd=_BdStr($p['bd']);
			}elseif(defined('DB_CL') && !isN(DB_CL)){
				$_bd=_BdStr(DB_CL);
			}else{
				$_bd='';
			}

			if($p['t'] == 'enc'){ $__f = 'vtexcmpgins_enc'; $__ft = 'text'; }
			elseif($p['t'] == 'cnt'){ $__f = 'vtexcmpgins_cnt'; $__ft = 'int'; }
			else{ $__f = 'id_vtexcmpgins'; $__ft = 'int'; }

			if(!isN($p['m'])){
				$_mre=$p['m'];
				if(!isN($_mre['pss'])){
					$_s_inn = ", AES_DECRYPT(vtexcntpss_pss, '".ENCRYPT_PASSPHRASE."') AS vtexcntpss_pss ";
					$_bd_inn = " INNER JOIN ".$_bd.TB_VTEX_CNT_PSS." ON vtexcntpss_cnt = id_cnt ";
				}
			}

			if( !isN($p['cmpg']) ){ $__fl .= " AND vtexcmpgins_vtexcmpg = '".$p['cmpg']."' "; }

			$Dt_Qry = sprintf("
								SELECT id_vtexcmpgins, vtexcmpgins_enc, vtexcmpgins_coup, vtexcoup_coup AS vtexcmpgins_coup_v, cnt_nm, cnt_ap, cnteml_eml {$_s_inn}
								FROM ".$_bd.TB_VTEX_CMPG_INS."
									INNER JOIN "._BdStr(DBT).TB_VTEX_CMPG." ON vtexcmpgins_vtexcmpg = id_vtexcmpg
									INNER JOIN "._BdStr(DBT).TB_VTEX_COUP." ON vtexcmpgins_coup = id_vtexcoup
									INNER JOIN ".$_bd.TB_CNT." ON vtexcmpgins_cnt = id_cnt
									INNER JOIN ".$_bd.TB_CNT_EML." ON cnteml_cnt = id_cnt
									{$_bd_inn}
								WHERE ".$__f."=%s {$__fl}",
								GtSQLVlStr($p["id"], $__ft)
							);

			$DtRg = $__cnx->_qry($Dt_Qry);
			$_r['q'] = compress_code($Dt_Qry);

			if($DtRg){

				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;

				$_r['tot'] = $Tot_DtRg;

				if($Tot_DtRg > 0){

					$_r['e'] = 'ok';

					$_r['id'] = $row_DtRg['id_vtexcmpgins'];
					$_r['enc'] = $row_DtRg['vtexcmpgins_enc'];

					$_r['cnt']['nm'] = ctjTx($row_DtRg['cnt_nm'],'in');
					$_r['cnt']['ap'] = ctjTx($row_DtRg['cnt_ap'],'in');
					$_r['cnt']['eml'] = ctjTx($row_DtRg['cnteml_eml'],'in');

					if(!isN($row_DtRg['vtexcntpss_pss'])){
						$_r['cnt']['vtex']['pss'] = ctjTx($row_DtRg['vtexcntpss_pss'],'in');
					}

					$_r['coup']['id'] = ctjTx($row_DtRg['vtexcmpgins_coup'],'in');
					$_r['coup']['v'] = ctjTx($row_DtRg['vtexcmpgins_coup_v'],'in');

				}

			}else{

				$_r['w'] = $__cnx->c_r->error;

			}

			$__cnx->_clsr($DtRg);

		}

		return _jEnc($_r);

	}

	function GtVtexCmpgInsRfdDt($p=NULL){

		global $__cnx;

		if(!isN($p["id"])){

			if(!isN($p['bd'])){ $_bd=_BdStr($p['bd']); }else{ $_bd=''; }

			if($p['t'] == 'enc'){ $__f = 'vtexcmpginsrfd_enc'; $__ft = 'text'; }
			else{ $__f = 'id_vtexcmpginsrfd'; $__ft = 'int'; }

			$Dt_Qry = sprintf( "
								SELECT 	id_vtexcmpginsrfd,
										vtexcmpginsrfd_enc,
										vtexcmpginsrfd_chk_rdm,
										rfd_cnt.cnt_nm AS rfd_cnt_nm,
										rfd_cnt.cnt_ap AS rfd_cnt_ap,
										rfd_eml.cnteml_eml AS rfd_cnteml_eml,
										ins_cnt.cnt_nm AS ins_cnt_nm,
										ins_cnt.cnt_ap AS ins_cnt_ap,
										vtexcmpginsrfd_ins_coup,
										vtexcmpginsrfd_rfd_coup,
										coup_i.vtexcoup_coup AS vtexcmpginsrfd_ins_coup_v,
										coup_r.vtexcoup_coup AS vtexcmpginsrfd_rfd_coup_v

								FROM ".$_bd.TB_VTEX_CMPG_INS_RFD."
									INNER JOIN ".$_bd.TB_VTEX_CMPG_INS." ON vtexcmpginsrfd_ins = id_vtexcmpgins
									INNER JOIN "._BdStr(DBT).TB_VTEX_CMPG." ON vtexcmpgins_vtexcmpg = id_vtexcmpg
									INNER JOIN ".$_bd.TB_CNT." AS rfd_cnt ON vtexcmpginsrfd_rfd = rfd_cnt.id_cnt
									INNER JOIN ".$_bd.TB_CNT_EML." AS rfd_eml ON cnteml_cnt = id_cnt
									INNER JOIN ".$_bd.TB_CNT." AS ins_cnt ON vtexcmpgins_cnt = ins_cnt.id_cnt
									LEFT JOIN "._BdStr(DBT).TB_VTEX_COUP." AS coup_i ON vtexcmpginsrfd_ins_coup = coup_i.id_vtexcoup
									LEFT JOIN "._BdStr(DBT).TB_VTEX_COUP." AS coup_r ON vtexcmpginsrfd_rfd_coup = coup_r.id_vtexcoup

								WHERE ".$__f." = %s ",
								GtSQLVlStr($p["id"], $__ft)
							);

			$DtRg = $__cnx->_qry($Dt_Qry);
			//$_r['q'] = compress_code($Dt_Qry);

			if($DtRg){

				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;

				$_r['tot'] = $Tot_DtRg;

				if($Tot_DtRg > 0){

					$_r['e'] = 'ok';

					$_r['id'] = $row_DtRg['id_vtexcmpginsrfd'];
					$_r['enc'] = $row_DtRg['vtexcmpginsrfd_enc'];
					$_r['chk']['rdm'] = mBln($row_DtRg['vtexcmpginsrfd_chk_rdm']);

					$_r['cnt']['nm'] = ctjTx($row_DtRg['rfd_cnt_nm'],'in');
					$_r['cnt']['ap'] = ctjTx($row_DtRg['rfd_cnt_ap'],'in');
					$_r['cnt']['eml'] = ctjTx($row_DtRg['rfd_cnteml_eml'],'in');

					$_r['ins']['cnt']['nm'] = ctjTx($row_DtRg['ins_cnt_nm'],'in');
					$_r['ins']['cnt']['ap'] = ctjTx($row_DtRg['ins_cnt_ap'],'in');

					$_r['coup']['rfd']['id'] = ctjTx($row_DtRg['vtexcmpginsrfd_rfd_coup'],'in');
					$_r['coup']['rfd']['v'] = ctjTx($row_DtRg['vtexcmpginsrfd_rfd_coup_v'],'in');

					$_r['coup']['ins']['id'] = ctjTx($row_DtRg['vtexcmpginsrfd_ins_coup'],'in');
					$_r['coup']['ins']['v'] = ctjTx($row_DtRg['vtexcmpginsrfd_ins_coup_v'],'in');

				}

			}else{

				$_r['w'] = $__cnx->c_r->error;

			}

			$__cnx->_clsr($DtRg);

		}

		return _jEnc($_r);

	}

	function GtVtexCmpgInsRfdLs($p=NULL){

		global $__cnx;

		$__cl = $p['cl'];

		if(!isN($p['ins'])){
			$__fl = " AND vtexcmpgins_cnt='".$p["ins"]."' ";
		}

		$Dt_Qry = "
				SELECT 	id_vtexcmpginsrfd, vtexcmpginsrfd_enc, vtexcmpginsrfd_chk_rdm,
						vtexcmpgins_coup, vtexcmpginsrfd_ins_coup,
						cnt_nm, cnt_ap, cnteml_eml, cntdc_dc, vtexcmpginsrfd_chk_cmp,
						coup_m.vtexcoup_coup AS vtexcmpgins_coup_v,
						coup_i.vtexcoup_coup AS vtexcmpginsrfd_ins_coup_v,
						coup_r.vtexcoup_coup AS vtexcmpginsrfd_rfd_coup_v

				FROM "._BdStr($__cl->bd).TB_VTEX_CMPG_INS_RFD."
					 INNER JOIN "._BdStr($__cl->bd).TB_VTEX_CMPG_INS." ON vtexcmpginsrfd_ins = id_vtexcmpgins
					 INNER JOIN "._BdStr(DBT).TB_VTEX_CMPG." ON vtexcmpgins_vtexcmpg = id_vtexcmpg
					 INNER JOIN "._BdStr($__cl->bd).TB_CNT." ON vtexcmpginsrfd_rfd = id_cnt
					 INNER JOIN "._BdStr($__cl->bd).TB_CNT_EML." ON cnteml_cnt = id_cnt

					 LEFT JOIN "._BdStr(DBT).TB_VTEX_COUP." AS coup_m ON vtexcmpgins_coup = coup_m.id_vtexcoup
					 LEFT JOIN "._BdStr(DBT).TB_VTEX_COUP." AS coup_i ON vtexcmpginsrfd_ins_coup = coup_i.id_vtexcoup
					 LEFT JOIN "._BdStr(DBT).TB_VTEX_COUP." AS coup_r ON vtexcmpginsrfd_rfd_coup = coup_r.id_vtexcoup

					 LEFT JOIN "._BdStr($__cl->bd).TB_CNT_DC." ON cntdc_cnt = id_cnt

				WHERE vtexcmpg_enc = '".$p['cmpg']."' {$__fl}";

		$DtRg = $__cnx->_qry($Dt_Qry);
		//$_r['q'] = compress_code($Dt_Qry);

		if($DtRg){

			$row_DtRg = $DtRg->fetch_assoc();
			$Tot_DtRg = $DtRg->num_rows;

			$_r['tot'] = $Tot_DtRg;

			if($Tot_DtRg > 0){

				$_r['e'] = 'ok';

	            do{

					$_id = $row_DtRg['vtexcmpginsrfd_enc'];

					$_r['ins']['coup'] = $row_DtRg['vtexcmpgins_coup_v'];
					$_r['ls'][$_id]['id'] = $row_DtRg['id_vtexcmpginsrfd'];
					$_r['ls'][$_id]['enc'] = $_id;
					$_r['ls'][$_id]['chk']['rdm'] = mBln($row_DtRg['vtexcmpginsrfd_chk_rdm']);
					$_r['ls'][$_id]['chk']['cmp'] = mBln($row_DtRg['vtexcmpginsrfd_chk_cmp']);

					$_r['ls'][$_id]['cnt']['nm'] = ctjTx($row_DtRg['cnt_nm'],'in');
					$_r['ls'][$_id]['cnt']['ap'] = ctjTx($row_DtRg['cnt_ap'],'in');
					$_r['ls'][$_id]['cnt']['eml'] = ctjTx($row_DtRg['cnteml_eml'],'in');

					$_r['ls'][$_id]['ins']['coup'] = $row_DtRg['vtexcmpginsrfd_ins_coup_v'];


				} while ($row_DtRg = $DtRg->fetch_assoc());
			}

		}else{

			$_r['w'] = $__cnx->c_r->error;

		}

		$__cnx->_clsr($DtRg);
		return _jEnc($_r);

	}

	function GtVtexCmpgInsLs($p=NULL){

		global $__cnx;

		$__cl = __Cl([ 'id'=>$p['cl'], 't'=>'id' ]);

		$Dt_Qry = "	SELECT
						id_vtexcmpgins, vtexcmpg_enc, vtexcmpg_nm, vtexcmpg_pml
					FROM "._BdStr($__cl->bd).TB_VTEX_CMPG_INS."
						INNER JOIN "._BdStr(DBT).TB_VTEX_CMPG." ON vtexcmpgins_vtexcmpg = id_vtexcmpg
						INNER JOIN "._BdStr(DBT).TB_VTEX." ON vtexcmpg_vtex = id_vtex
					WHERE vtexcmpgins_cnt = '".$p["rfd"]."' AND vtex_cl = '".$p["cl"]."' ";


		$DtRg = $__cnx->_qry($Dt_Qry);

		if($DtRg){

			$row_DtRg = $DtRg->fetch_assoc();
			$Tot_DtRg = $DtRg->num_rows;

			$_r['tot'] = $Tot_DtRg;

			if($Tot_DtRg > 0){

				$_r['e'] = 'ok';

	            do{

					$_id = $row_DtRg['vtexcmpg_enc'];
					$_r['ls'][$_id]['id'] = $_id;
					$_r['ls'][$_id]['nm'] = ctjTx($row_DtRg['vtexcmpg_nm'],'in');
					$_r['ls'][$_id]['pml'] = ctjTx($row_DtRg['vtexcmpg_pml'],'in');

				} while ($row_DtRg = $DtRg->fetch_assoc());
	        }
		}

		$__cnx->_clsr($DtRg);
		return _jEnc($_r);

	}

	function GtCntNoiSubLs($p=NULL){

		global $__cnx;

		if(!isN($p['r'])){ $_r = $p['r']; }

		if(!isN($p['id'])){

			if($p['t'] == 'sub'){ $__f = 'siscntnoi_prnt'; $__ft = 'text'; }else{ $__f = 'id_siscntnoi'; $__ft = 'int'; }

			$Ls_Qry_His = sprintf("SELECT *,
										 (	SELECT siscntnoi_prnt
										 	FROM "._BdStr(DBM).TB_SIS_CNT_NOI."
										 	WHERE id_siscntnoi = _a.siscntnoi_prnt ) AS __sub

								   FROM "._BdStr(DBM).TB_SIS_CNT_NOI." AS _a
								   WHERE _a.$__f = %s
								   ORDER BY _a.siscntnoi_prnt ASC
								   LIMIT 1", GtSQLVlStr($p['id'], $__ft));


			$Ls_Rg = $__cnx->_qry($Ls_Qry_His);

			if($Ls_Rg){

				$row_Ls_Rg = $Ls_Rg->fetch_assoc();
				$Tot_Ls_Rg = $Ls_Rg->num_rows;


				if($Tot_Ls_Rg > 0){

					$_r['id'] = $row_Ls_Rg['id_siscntnoi'];
					$_r['prnt'] = $row_Ls_Rg['siscntnoi_prnt'];

		            if(defined('SISUS_ID') && SISUS_ID == 181){

			            if(!isN($row_Ls_Rg['siscntnoi_prnt'])){

							$_r['sub'] = GtCntNoiSubLs([ 'id'=>$row_Ls_Rg['siscntnoi_prnt'], 'r'=>$_r ]);

						}

					}else{

			            $__tot = 1;
			            $_r['id'] = $row_Ls_Rg['id_siscntnoi'];
			            $_r['ls']['sb1'] = $row_Ls_Rg['id_siscntnoi'];

						if(!isN($row_Ls_Rg['siscntnoi_prnt'])){
							$_r['ls']['sb2'] = $row_Ls_Rg['siscntnoi_prnt'];
							$__tot++;
						}
						if(!isN($row_Ls_Rg['__sub'])){
							$__dt = GtCntNoiSubLs(['id'=>$row_Ls_Rg['siscntnoi_prnt']]);
							$_r['ls']['sb3'] = $__dt->prnt;
							$__tot++;
							if(!isN($__dt->sb)){
								$_r['ls']['sb4'] = $__dt->sb; $__tot++;
							}
						}

					}


					$_r['tot'] = $__tot;
	            }

            }

			$__cnx->_clsr($Ls_Rg);
			$rtrn = _jEnc($_r);
			return($rtrn);
		}
	}



	function GtCntEstDt($p=NULL){

		global $__cnx;

		$Vl['e'] = 'no';

		if( !isN($p['id']) || !isN($p['dfl']) ){

			if($p['t']=='enc'){ $id='siscntest_enc'; $idt='text'; }else{ $id='id_siscntest'; $idt='int'; }

			if(!isN($p['dfl']) && !isN($p['cl'])){
				$__fl .= sprintf(' AND id_siscntest IN
									(	SELECT mdlstpest_cntest
										FROM '._BdStr(DBM).TB_MDL_S_TP_EST.'
											 INNER JOIN '._BdStr(DBM).TB_SIS_CNT_EST.' ON mdlstpest_cntest = id_siscntest
										WHERE siscntest_cl = %s AND mdlstpest_dfl = 1 AND mdlstpest_mdlstp = %s)',
										GtSQLVlStr($p['cl'], 'int'),
										GtSQLVlStr($p['dfl'], 'int'));
			}


			if(!isN($p['id']) && !isN($id)){ $__fl .= sprintf(' AND '.$id.'=%s ', GtSQLVlStr($p['id'],$idt)); }

			if(!isN($__fl)){

				$query_DtRg = sprintf('SELECT *
									   FROM '._BdStr(DBM).TB_SIS_CNT_EST.'
									   		 INNER JOIN '._BdStr(DBM).TB_SIS_CNT_EST_TP.' ON siscntest_tp = id_siscntesttp
									   WHERE id_siscntest != "" '.$__fl.' LIMIT 1', GtSQLVlStr($p['id'],$idt));

				$DtRg = $__cnx->_qry($query_DtRg);
				//$Vl['q'] = $query_DtRg;

			}

			if($DtRg){

				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;

				if($Tot_DtRg > 0){

					$Vl['e'] = 'ok';
					$Vl['id'] = $row_DtRg['id_siscntest'];
					$Vl['tt'] = ctjTx($row_DtRg['siscntest_tt'],'in').$icn;
					$Vl['clr'] = ctjTx($row_DtRg['siscntest_clr_bck'],'in');
					$Vl['buy'] = mBln($row_DtRg['siscntest_buy'],'in');
					$Vl['asis'] = mBln($row_DtRg['siscntest_asis'],'in');

					$Vl['tp']['id'] = ctjTx($row_DtRg['id_siscntesttp'],'in');
					$Vl['tp']['ord'] = ctjTx($row_DtRg['siscntesttp_ord'],'in');
					$Vl['tp']['buy'] = mBln($row_DtRg['siscntesttp_prch'],'in');
					$Vl['tp']['cntr'] = mBln($row_DtRg['siscntesttp_cntr'],'in');

					$Vl['tra']['archv'] = mBln($row_DtRg['siscntest_tra_archv'],'in');
					$Vl['tra']['cncl'] = mBln($row_DtRg['siscntest_tra_cncl'],'in');
					$Vl['tra']['cmpl'] = mBln($row_DtRg['siscntest_tra_cmpl'],'in');
					$Vl['tra']['eli'] = mBln($row_DtRg['siscntest_tra_eli'],'in');
					$Vl['tra']['prc'] = mBln($row_DtRg['siscntest_tra_prc'],'in');

				}

			}else{

				$Vl['w'] = 'Qry:'.$query_DtRg.$__cnx->c_r->error;

			}

			$__cnx->_clsr($DtRg);

		}


		return _jEnc($Vl);
	}


	function GtCntEstTra($p=NULL){

		global $__cnx;

		$Vl['e'] = 'no';

		if( !isN($p['est']) ){

			if($p['est']==_CId('ID_TRAEST_ARCHV')){
				$_fltr = 'archv';
			}elseif($p['est']==_CId('ID_TRAEST_CNCL')){
				$_fltr = 'cncl';
			}elseif($p['est']==_CId('ID_TRAEST_CMPL')){
				$_fltr = 'cmpl';
			}elseif($p['est']==_CId('ID_TRAEST_ELI')){
				$_fltr = 'eli';
			}elseif($p['est']==_CId('ID_TRAEST_PRC')){
				$_fltr = 'prc';
			}

			if(!isN($_fltr)){

				$query_DtRg = sprintf('SELECT id_siscntest
									   FROM '._BdStr(DBM).TB_SIS_CNT_EST.'
									   WHERE 	id_siscntest != "" AND
												siscntest_tra_'.$_fltr.'=1 AND
												siscntest_cl = %s
									   LIMIT 1', GtSQLVlStr($p['cl'], 'int'));

				$DtRg = $__cnx->_qry($query_DtRg);
				$Vl['q'] = compress_code( $query_DtRg );

			}

			if($DtRg){

				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;

				if($Tot_DtRg > 0){
					$Vl['e'] = 'ok';
					$Vl['id'] = $row_DtRg['id_siscntest'];
				}else{
					$Vl['e'] = 'no_records';
				}

			}else{

				$Vl['w'] = 'Qry:'.$query_DtRg.$__cnx->c_r->error;

			}

			$__cnx->_clsr($DtRg);

		}else{

			$Vl['w'] = 'No est id for search';

		}

		return _jEnc($Vl);

	}

	function GtCntEstMdlCntTra($p=NULL){

		global $__cnx;

		$Vl['e'] = 'no';

		if( !isN($p['est']) ){

			$query_DtRg = sprintf('	SELECT id_siscntest, siscntest_tra_archv, siscntest_tra_cncl, siscntest_tra_cmpl, siscntest_tra_eli, siscntest_tra_prc
								   	FROM '._BdStr(DBM).TB_SIS_CNT_EST.'
									WHERE 	id_siscntest != "" AND
											siscntest_cl = %s AND
											id_siscntest = %s
									LIMIT 1',
											GtSQLVlStr($p['cl'], 'int'),
											GtSQLVlStr($p['est'], 'int'));

			$DtRg = $__cnx->_qry($query_DtRg);

			if($DtRg){

				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;

				if($Tot_DtRg > 0){
					$Vl['e'] = 'ok';

					$Vl['est']['id'] = $row_DtRg['id_siscntest'];
					$Vl['est']['archv'] = $row_DtRg['siscntest_tra_archv'];
					$Vl['est']['cncl'] = $row_DtRg['siscntest_tra_cncl'];
					$Vl['est']['cmpl'] = $row_DtRg['siscntest_tra_cmpl'];
					$Vl['est']['eli'] = $row_DtRg['siscntest_tra_eli'];
					$Vl['est']['prc'] = $row_DtRg['siscntest_tra_prc'];
				}

				foreach($Vl['est'] as $k => $v){
					if($v == 1){
						if($k=='archv'){
							$_fltr = _CId('ID_TRAEST_ARCHV');
						}elseif($k=='cncl'){
							$_fltr = _CId('ID_TRAEST_CNCL');
						}elseif($k=='cmpl'){
							$_fltr = _CId('ID_TRAEST_CMPL');
						}elseif($k=='eli'){
							$_fltr = _CId('ID_TRAEST_ELI');
						}elseif($k=='prc'){
							$_fltr = _CId('ID_TRAEST_PRC');
						}
					}
				}

				$Vl['id_est'] = $_fltr;

			}else{

				$Vl['w'] = 'Qry:'.$query_DtRg.$__cnx->c_r->error;

			}

			$__cnx->_clsr($DtRg);

		}

		return _jEnc($Vl);

	}


	function GtCntEstTpLs($p=NULL){

		global $__cnx;

	    $Vl['e'] = 'no';

		if( !isN($p['mdlstp']) ){
			$__fl .= sprintf(' AND
								(	SELECT COUNT(*)
									FROM '._BdStr(DBM).TB_MDL_S_TP_EST.'
									WHERE siscntest_cl = id_cl AND mdlstpest_mdlstp=%s AND mdlstpest_est = 1 AND mdlstpest_cntest = id_siscntest ) > 0',
									GtSQLVlStr($p['mdlstp'], 'int'));
		}


		if(!isN($p['mdl'])){

			$__cntestare = LsCntEstAreAll([ 'mdl'=>$p['mdl'] ]);

			if(!isN($__cntestare) && !isN($__cntestare->ls)){
				foreach($__cntestare->ls as $__cntestare_k=>$__cntestare_v){
					$___are_in[] = $__cntestare_v->id;
				}
				if(is_array($___are_in)){ $___are_in_go = implode(',', $___are_in); }
			}

			if(!isN($___are_in_go)){
				$__fl .= " AND id_siscntest IN (	SELECT siscntestare_est
																FROM "._BdStr(DBM).TB_SIS_CNT_EST_ARE."
																WHERE siscntestare_are IN (".$___are_in_go.")
															) ";
			}
		}


		$query_DtRg = "
				SELECT *
				FROM "._BdStr(DBM).TB_SIS_CNT_EST."
					 INNER JOIN "._BdStr(DBM).TB_CL." ON siscntest_cl = id_cl
					 INNER JOIN "._BdStr(DBM).TB_SIS_CNT_EST_TP." ON siscntest_tp = id_siscntesttp
				WHERE cl_enc = '".DB_CL_ENC."' {$__fl}
				ORDER BY siscntesttp_ord ASC, siscntest_tt ASC";

		$DtRg = $__cnx->_qry($query_DtRg);

		if($DtRg){

			$row_DtRg = $DtRg->fetch_assoc();
			$Tot_DtRg = $DtRg->num_rows;

			$Vl['tot'] = $Tot_DtRg;

			if($Tot_DtRg > 0){

				$Vl['e'] = 'ok';

				do{

					if(isN( $Vl['ls'][$row_DtRg['siscntesttp_enc']]['ls'] )){
						$Vl['ls'][$row_DtRg['siscntesttp_enc']]['ls'] = [];
					}

					$Vl['ls'][$row_DtRg['siscntesttp_enc']]['id'] = $row_DtRg['id_siscntesttp'];
					$Vl['ls'][$row_DtRg['siscntesttp_enc']]['enc'] = $row_DtRg['siscntesttp_enc'];
					$Vl['ls'][$row_DtRg['siscntesttp_enc']]['nm'] = ctjTx($row_DtRg['siscntesttp_tt'],'in');
					$Vl['ls'][$row_DtRg['siscntesttp_enc']]['clr'] = ctjTx($row_DtRg['siscntesttp_clr_bck'],'in');

					$__ob = [
						'enc'=>$row_DtRg['siscntest_enc'],
						'nm'=>ctjTx($row_DtRg['siscntest_tt'],'in'),
						'clr'=>ctjTx($row_DtRg['siscntest_clr_bck'],'in'),
						'tot'=>$row_DtRg['tot']
					];

					array_push( $Vl['ls'][$row_DtRg['siscntesttp_enc']]['ls'], $__ob);


				}while($row_DtRg = $DtRg->fetch_assoc());

			}

		}

		$__cnx->_clsr($DtRg);
		return(_jEnc($Vl));
    }



	function GtCntActLs($p=NULL){

		global $__cnx;

		if(!isN($p['cnt'])){

			$_Ls_Qry = "SELECT * FROM ".TB_ACT_CNT.", "._BdStr(DBM).TB_ACT."
					   	   WHERE actcnt_act = id_act AND actcnt_cnt = ".$p['cnt']."
					   	   ORDER BY actcnt_fi DESC";

			$Ls_Rg = $__cnx->_qry($_Ls_Qry);

			if($Ls_Rg){

				$row_Ls_Rg = $Ls_Rg->fetch_assoc();
				$Tot_Ls_Rg = $Ls_Rg->num_rows;

				if($Tot_Ls_Rg > 0){
	                    do{

		                   	$_id = $row_Ls_Rg['id_act'];
		                   	$_r['t']['ActCnt'.$_id]['e'] = 'ok';
							$_r['t']['ActCnt'.$_id]['id'] = $_id;
							$_r['t']['ActCnt'.$_id]['tx'] = ctjTx($row_Ls_Rg['act_tt'].' - '.$row_Ls_Rg['act_fi'],'in');

	                    } while ($row_Ls_Rg = $Ls_Rg->fetch_assoc());
	            }

            }

			$__cnx->_clsr($Ls_Rg);
			$rtrn = _jEnc($_r);
			return($rtrn);
		}
	}




	function GtCntBdAllDt($Id){

		global $__cnx;

		$flt_cnt = ", (SELECT COUNT(*) )";
		$query_DtRg = sprintf('SELECT

								( 	SELECT COUNT(*)
									FROM '.TB_CNT_BD.', '.TB_CNT_TEL.'
									WHERE cnttel_cnt = cntbd_cnt AND cntbd_bd = id_sisbd ) AS __tot_tel,

								( 	SELECT COUNT(*)
									FROM '.TB_CNT_BD.', '.TB_CNT_EML.'
									WHERE cnteml_cnt = cntbd_cnt AND cntbd_bd = id_sisbd ) AS __tot_eml,

								( 	SELECT COUNT(*)
									FROM '.TB_CNT_BD.', '.TB_CNT_DC.'
									WHERE cntdc_cnt = cntbd_cnt AND cntbd_bd = id_sisbd ) AS __tot_dc,

								( 	SELECT COUNT(*)
									FROM '.TB_CNT_BD.', '.TB_CNT.'
									WHERE id_cnt = cntbd_cnt AND cntbd_bd = id_sisbd AND cnt_dir IS NOT NULL ) AS __tot_dir,

								( 	SELECT COUNT(*)
									FROM '.TB_CNT_BD.'
									WHERE cntbd_bd = id_sisbd )	AS __tot_lds

							 FROM '._BdStr(DBM).TB_SIS_BD.' WHERE sisbd_enc = %s LIMIT 1', GtSQLVlStr($Id,'text'));

		$DtRg = $__cnx->_qry($query_DtRg);

		if($DtRg){

			$row_DtRg = $DtRg->fetch_assoc();
			$Tot_DtRg = $DtRg->num_rows;

			if($Tot_DtRg > 0){

				$Vl['id'] = $row_DtRg['id_cntbd'];
				$Vl['tot']['cnt'] = $row_DtRg['__tot_lds'];
				$Vl['tot']['tel'] = $row_DtRg['__tot_tel'];
				$Vl['tot']['eml'] = $row_DtRg['__tot_eml'];
				$Vl['tot']['dc'] = $row_DtRg['__tot_dc'];
				$Vl['tot']['dir'] = $row_DtRg['__tot_dir'];
				$Vl['tot']['tp'] = GtCntBdTpDt($Id);
				//$Vl['tot']['tag'] = GtCntBdTagDt($Id);
				//$Vl['tot']['sx'] = GtSisSxDt($Id);

				$Vl['his']['cnt']['month'] = GtCntBdHis([ 'id'=>$Id, 't'=>'enc' ]);

			}else{
				$Vl['no'] = $query_DtRg;
			}

		}

		$__cnx->_clsr($DtRg);
		return(_jEnc($Vl));

	}




	function GtCntBdTpDt($Id){

			global $__cnx;

			$flt_cnt = ", (SELECT COUNT(*) )";

			$query_DtRg = sprintf('	SELECT  *,
										   COUNT(*) AS __tot
									FROM '.TB_CNT_TP.'
										 INNER JOIN '._BdStr(DBM).TB_SIS_CNT_TP.' ON cnttp_tp = id_siscnttp
										 INNER JOIN '.TB_CNT_BD.' ON cnttp_cnt = cntbd_cnt
										 INNER JOIN '._BdStr(DBM).TB_SIS_BD.' ON cntbd_bd = id_sisbd
				WHERE sisbd_enc = %s
				GROUP BY id_siscnttp', GtSQLVlStr($Id,'text'));

			$DtRg = $__cnx->_qry($query_DtRg);

			if($DtRg){

				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;

				if($Tot_DtRg > 0){

					do{

						if($row_DtRg['__tot'] > 0){
							$Vl[ $row_DtRg['id_siscnttp'] ] = ['tt'=>ctjTx($row_DtRg['siscnttp_nm'],'in'), 'tot'=>$row_DtRg['__tot']];
						}

					}while($row_DtRg = $DtRg->fetch_assoc());

				}else{

					$Vl['no'] = $query_DtRg;

				}

			}else{

				$_r['w'] = $__cnx->c_r->error;

			}



			$__cnx->_clsr($DtRg);
		return(_jEnc($Vl));

	}





	function GtCntBdChk($p=NULL){

		global $__cnx;

		$Vl['e'] = 'no';

		if(!isN($p) && !isN($p['sisbd']) && !isN($p['cnt'])){

			if(!isN($p['bd'])){ $_bd=_BdStr($p['bd']); }else{ $_bd=''; }

			$query_DtRg = sprintf('	SELECT  *
									FROM '.$_bd.TB_CNT_BD.'
									WHERE cntbd_cnt=%s AND cntbd_bd=%s
									LIMIT 1', GtSQLVlStr($p['cnt'],'text'), GtSQLVlStr($p['sisbd'],'text'));

			$DtRg = $__cnx->_qry($query_DtRg);

			if($DtRg){

				$Vl['e'] = 'ok';

				$row_DtRg = $DtRg->fetch_assoc();

				$Vl['tot'] = $Tot_DtRg = $DtRg->num_rows;

				if($Tot_DtRg > 0){

					$Vl['id'] = ctjTx($row_DtRg['id_cntbd'],'in');
					$Vl['enc'] = ctjTx($row_DtRg['cntbd_enc'],'in');

				}else{

					$Vl['no'] = $query_DtRg;

				}

			}else{

				$Vl['w'] = $__cnx->c_p->error;

			}

			$__cnx->_clsr($DtRg);

		}

		return _jEnc($Vl);

	}





	function GtCntBdHis($p=NULL){


			global $__cnx;

			if($p['t'] == 'enc'){ $__f = 'sisbd_enc'; $__ft = 'text'; }else{ $__f = 'id_sisbd'; $__ft = 'int'; }




			$flt_f_asc = ", sisbd_fi AS __f_asc";
			$flt_f_desc = ", ( 	SELECT a2.cntbd_fi
								FROM ".TB_CNT_BD." AS a2
								WHERE a2.cntbd_bd = id_sisbd
								ORDER BY a2.cntbd_fi DESC LIMIT 1 ) AS __f_desc";

			$query_DtRg = 'SELECT cntbd_fi, COUNT(DISTINCT cntbd_fi) AS __tot '.$flt_f_asc.' '.$flt_f_desc.' FROM '.TB_CNT_BD.' AS __t1, '._BdStr(DBM).TB_SIS_BD.'
				WHERE __t1.cntbd_bd = id_sisbd AND '.$__f.' = '.GtSQLVlStr($p['id'], $__ft).' AND cntbd_fi > sisbd_fi GROUP BY  DATE_FORMAT(__t1.cntbd_fi, "%Y-%m")';


			$DtRg = $__cnx->_qry($query_DtRg);

			if($DtRg){

				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;

				$Vl['tot'] = $Tot_DtRg;

				if($Tot_DtRg > 0){

					do{

						$Vl['f_start'] = ctjTx($row_DtRg['__f_asc'],'in');
						$Vl['f_end'] = ctjTx($row_DtRg['__f_desc'],'in');

						if($row_DtRg['__tot'] > 0){

							$fecha = date("Y-m", strtotime($row_DtRg['cntbd_fi']));
							$Vl['ls'][ $fecha ] = ['tt'=>ctjTx($fecha,'in'), 'tot'=>$row_DtRg['__tot']];

						}

					}while($row_DtRg = $DtRg->fetch_assoc());

				}else{
					$Vl['no'] = $query_DtRg;
				}

			}

		$__cnx->_clsr($DtRg);
		return(_jEnc($Vl));

	}



	function GtPlcyLs($p=NULL){

		global $__cnx;


		$Vl['e'] = 'no';

		if((defined('DB_CL_ENC') || !isN($p['cl'])) ){

			if(!isN($p['bd'])){ $_bd=_BdStr($p['bd']); }else{ $_bd=''; }
			if(!isN($p['cl'])){ $_cl=$p['cl']; }else{ $_cl=DB_CL_ENC; }

			$query_DtRg = sprintf("	SELECT *
									FROM "._BdStr(DBM).TB_CL_PLCY."
										 INNER JOIN "._BdStr(DBM).TB_CL." ON clplcy_cl = id_cl
									WHERE cl_enc = '".$_cl."'
									ORDER BY clplcy_fi DESC
									", GtSQLVlStr($p['cnt'], 'int'));

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

					}while($row_DtRg = $DtRg->fetch_assoc());

				}

			}else{

				$Vl['w'] = $__cnx->c_r->error;

			}

			$__cnx->_clsr($DtRg);

		}

		return _jEnc($Vl);

	}



	function GtCntPlcyLs($p=NULL){

		global $__cnx;

		$Vl['e'] = 'no';

		if(!isN($p['cnt']) && (defined('DB_CL_ENC') || !isN($p['cl'])) ){

			if(!isN($p['bd'])){ $_bd=_BdStr($p['bd']); }else{ $_bd=''; }
			if(!isN($p['cl'])){ $_cl=$p['cl']; }else{ $_cl=DB_CL_ENC; }

			$query_DtRg = sprintf("	SELECT id_clplcy, clplcy_enc, clplcy_nm, clplcy_tx, clplcy_v, clplcy_lnk, clplcy_lnk_tt,
											(
												SELECT COUNT(*)
												FROM ".$_bd.TB_CNT_PLCY."
												WHERE cntplcy_cnt=%s AND
													  cntplcy_plcy=id_clplcy AND
													  cntplcy_sndi=1
											) AS __tot

									FROM "._BdStr(DBM).TB_CL_PLCY."
										 INNER JOIN "._BdStr(DBM).TB_CL." ON clplcy_cl = id_cl
									WHERE cl_enc = '".$_cl."'
									ORDER BY clplcy_fi DESC
									", GtSQLVlStr($p['cnt'], 'int'));

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



		}else{

			$Vl['w'] = 'no all data '.print_r($p, true);

		}


		$__cnx->_clsr($DtRg);
		return _jEnc($Vl);

	}



	function GtCntEmlPlcyLs($p=NULL){

		global $__cnx;

		$Vl['e'] = 'no';

		if(!isN($p['eml'])){

			if(!isN($p['bd'])){ $_bd=_BdStr($p['bd']); }else{ $_bd=''; }

			if(!isN($p['cl'])){
				if(is_array($p['cl']) && !isN($p['cl']['v']) && $p['cl']['t'] == 'enc'){
					$_fl .= " AND cl_enc = '".$p['cl']['v']."' ";
				}else{
					$_fl .= " AND id_cl = '".$p['cl']."' ";
				}
			}elseif(defined('DB_CL_ENC') && !isN(DB_CL_ENC)){
				$_fl .= " AND cl_enc = '".DB_CL_ENC."' ";
			}

			$query_DtRg = sprintf("	SELECT clplcy_enc, id_clplcy, clplcy_nm, clplcy_tx, clplcy_v, clplcy_lnk, clplcy_lnk_tt, cntemlplcy_sndi,
											(
												SELECT COUNT(*)
												FROM ".$_bd.TB_CNT_EML_PLCY."
												WHERE cntemlplcy_cnteml=%s AND
													  cntemlplcy_plcy=id_clplcy AND
													  cntemlplcy_sndi=1
											) AS __tot

									FROM "._BdStr(DBM).TB_CL_PLCY."
										 INNER JOIN "._BdStr(DBM).TB_CL." ON clplcy_cl = id_cl
										 LEFT JOIN ".$_bd.TB_CNT_EML_PLCY." ON cntemlplcy_plcy = id_clplcy AND cntemlplcy_cnteml=".GtSQLVlStr($p['eml'], 'int')." AND cntemlplcy_sndi = 1
									WHERE id_cl != '' {$_fl}
									ORDER BY clplcy_fi DESC
									", GtSQLVlStr($p['eml'], 'int'));

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

						$Vl['ls'][$__id]['sndi'] = mBln($row_DtRg['cntemlplcy_sndi']);

					}while($row_DtRg = $DtRg->fetch_assoc());

				}

			}else{

				$Vl['w'] = $__cnx->c_r->error;

			}

			$__cnx->_clsr($DtRg);

		}

		return _jEnc($Vl);

	}








	function GtCntTelPlcyLs($p=NULL){

		global $__cnx;

		$Vl['e'] = 'no';

		if(!isN($p['tel'])){

			if(!isN($p['bd'])){ $_bd=$p['bd']; }else{ $_bd=''; }

			if(!isN($p['cl'])){
				$_fl .= " AND id_cl = '".$p['cl']."' ";
			}elseif(defined('DB_CL_ENC') && !isN(DB_CL_ENC)){
				$_fl .= " AND cl_enc = '".DB_CL_ENC."' ";
			}

			$query_DtRg = sprintf("	SELECT clplcy_enc, id_clplcy, clplcy_nm, clplcy_tx, clplcy_v, clplcy_lnk, clplcy_lnk_tt, cnttelplcy_sndi, cnttelplcy_sms, cnttelplcy_whtsp,
											(
												SELECT COUNT(*)
												FROM ".$_bd.TB_CNT_TEL_PLCY."
												WHERE cnttelplcy_cnttel=".GtSQLVlStr($p['tel'], 'int')." AND
													  cnttelplcy_plcy=id_clplcy AND
													  cnttelplcy_sndi=1
											) AS __tot

									FROM "._BdStr(DBM).TB_CL_PLCY."
										 INNER JOIN "._BdStr(DBM).TB_CL." ON clplcy_cl = id_cl
										 LEFT JOIN ".$_bd.TB_CNT_TEL_PLCY." ON cnttelplcy_plcy = id_clplcy AND cnttelplcy_cnttel=".GtSQLVlStr($p['tel'], 'int')." AND cnttelplcy_sndi = 1
									WHERE id_cl != '' {$_fl}
									ORDER BY clplcy_fi DESC
								");

			//$Vl['q'] = $query_DtRg;

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

						$Vl['ls'][$__id]['sndi'] = mBln($row_DtRg['cnttelplcy_sndi']);
						$Vl['ls'][$__id]['sms'] = mBln($row_DtRg['cnttelplcy_sms']);
						$Vl['ls'][$__id]['whtsp'] = mBln($row_DtRg['cnttelplcy_whtsp']);

					}while($row_DtRg = $DtRg->fetch_assoc());

				}

			}else{

				$Vl['w'] = $__cnx->c_r->error;

			}

			$__cnx->_clsr($DtRg);

		}else{

			$Vl['w'] = 'no data';

		}

		return _jEnc($Vl);

	}








	function GtEcLstsPlcyLs($p=NULL){

		global $__cnx;

		$Vl['e'] = 'no';

		if(!isN($p['eclsts']) && !isN($p['cl'])){

			if(defined('DB_CL_ENC')){ $_cl = DB_CL_ENC; }elseif(!isN($p['cl'])){ $_cl = $p['cl']; }

			if(!isN($_cl)){ $_fl .= " AND cl_enc = '".$_cl."' "; }
			if(!isN($p['e']) && $p['e']=='on'){ $_fl .= " AND clplcy_e='1' "; }
			if(!isN($p['rl']) && $p['rl']=='on'){ $_fl .= " AND eclstsplcy_e='1' "; }

			$query_DtRg = sprintf("	SELECT *,
											(
												SELECT COUNT(*)
												FROM "._BdStr(DBM).TB_EC_LSTS_PLCY."
												WHERE eclstsplcy_eclsts=".GtSQLVlStr($p['eclsts'], 'int')." AND
													  eclstsplcy_plcy=id_clplcy AND
													  eclstsplcy_e=1
											) AS __tot

									FROM "._BdStr(DBM).TB_CL_PLCY."
										 INNER JOIN "._BdStr(DBM).TB_CL." ON clplcy_cl = id_cl
										 LEFT JOIN "._BdStr(DBM).TB_EC_LSTS_PLCY." ON eclstsplcy_plcy = id_clplcy AND eclstsplcy_eclsts=".GtSQLVlStr($p['eclsts'], 'int')." AND eclstsplcy_e = 1
									WHERE id_cl != '' $_fl
									ORDER BY eclstsplcy_fi DESC
								");

			$DtRg = $__cnx->_qry($query_DtRg);


			//$Vl['q'] = $query_DtRg;


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
						$Vl['ls'][$__id]['sndi'] = mBln($row_DtRg['eclstsplcy_e']);

					}while($row_DtRg = $DtRg->fetch_assoc());

				}

			}else{

				$Vl['w'] = $__cnx->c_r->error;

			}

			$__cnx->_clsr($DtRg);

		}else{

			$Vl['w'] = 'No all data';

		}

		return _jEnc($Vl);

	}

	function GtClCntTpLs($p=NULL){

		global $__cnx;

		if(!isN($p['cl'])){

			$Ls_Qry = "	SELECT *
						FROM "._BdStr(DBM).TB_SIS_CNT_TP."
							 INNER JOIN "._BdStr(DBM).TB_CL." ON siscnttp_cl = id_cl
						WHERE id_siscnttp != '' AND id_cl = '".$p['cl']."' {$__fl}
						ORDER BY siscnttp_nm ASC";

			$Ls = $__cnx->_qry($Ls_Qry);

			if($Ls){

				$row_Ls = $Ls->fetch_assoc();
				$Tot_Ls = $Ls->num_rows;

				do {

					$__id=$row_Ls['id_siscnttp'];
					$Vl['ls'][$__id]['id'] = ctjTx($row_Ls['id_siscnttp'],'in');
					$Vl['ls'][$__id]['nm'] = ctjTx($row_Ls['siscnttp_nm'],'in');

				} while ($row_Ls = $Ls->fetch_assoc());

			}

			$__cnx->_clsr($Ls);

			return _jEnc($Vl);

		}
	}

	function GtClSdsLs($p=NULL){

		global $__cnx;

		if(!isN($p['cl'])){

			$Ls_Qry = "	SELECT id_clsds, clsds_enc, clsds_nm
						FROM "._BdStr(DBM).TB_CL_SDS."
						WHERE id_clsds != '' AND clsds_cl = '".$p['cl']."'
						ORDER BY clsds_nm ASC";

			$Ls = $__cnx->_qry($Ls_Qry);

			if($Ls){

				$row_Ls = $Ls->fetch_assoc();
				$Tot_Ls = $Ls->num_rows;

				if($Tot_Ls > 0){
					do {
						$__id=$row_Ls['id_clsds'];
						$Vl['ls'][$__id]['id'] = ctjTx($row_Ls['id_clsds'],'in');
						$Vl['ls'][$__id]['enc'] = ctjTx($row_Ls['clsds_enc'],'in');
						$Vl['ls'][$__id]['nm'] = ctjTx($row_Ls['clsds_nm'],'in');
					} while ($row_Ls = $Ls->fetch_assoc());
				}

			}

			$__cnx->_clsr($Ls);

			return _jEnc($Vl);

		}
	}

?>