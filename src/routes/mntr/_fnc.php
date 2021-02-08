<?php

    class CRM_Status{

		function __construct($p=NULL) {
	        $this->_s_cl = GtClLs([ 'on'=>'ok', 'rnd'=>'ok' ]); // System Clientes
		}

		function __destruct() { }

        public function GtMntrContDt($p=NULL){

			/*$Vl['ec_prc_aprb'] = $this->GtEcEstLs([ 'est' => _CId('ID_SISEST_PAPRB') ]);
			$Vl['eml_rbt']['tot'] = '0%';
			$Vl['cmpg_cla'] = $this->GtCmpgClaLs();
			$Vl['cds_vrf'] = $this->GtCdVrfLs();
			$Vl['sis_err'] = $this->GtSisErr();
			$Vl['emls_wrg'] = $this->GtCntEmlEst();
			$Vl['org_vrf'] = $this->GtOrgVrfLs();
			$Vl['tck'] = $this->GtTckLs();
			$Vl['ec_snd_cmpg'] = $this->GtEcSndCmpgLs();
			$Vl['ec_snd_pnd'] = $this->GtEcCmpgPndLs();
			$Vl['dwn_est'] = $this->GtDwnEstLs();
			$Vl['lead_ads'] = $this->GtLeadAd();
			$Vl['scl_rcl'] = $this->GtSclRcl();*/

			$Vl['api_rqu'] = $this->GtApiRqu();
			$Vl['server'] = $this->GtEstdAws();
			$Vl['tck'] = $this->GtTckLs();
			$Vl['time'] = date("d-m-Y h:i A", time());

			$rtrn = _jEnc($Vl);
			return($rtrn);
		}

		public function GtEcEstLs($p=NULL){

			global $__cnx;

            $Vl['e'] = 'no';

            $__fl = "FROM "._BdStr(DBM).TB_EC." WHERE id_ec != '' AND ec_est IN('".$p['est']."') AND ec_frm != '"._CId('ID_SISECFRM_SIS')."' AND ec_cmzrlc IS NOT NULL ORDER BY id_ec DESC";
			$query_DtRg = "SELECT COUNT( DISTINCT id_ec ) AS __rgtot ".$__fl."";

			$DtRg = $__cnx->_qry($query_DtRg);

			if($DtRg){

				$Vl['e'] = 'ok';
				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;
				$Vl['tot'] = $row_DtRg['__rgtot'];

			}else{ $Vl['w'] = $__cnx->c_r->error; }

			$__cnx->_clsr($DtRg);

			$rtrn = _jEnc($Vl);
			return($rtrn);
		}

		public function GtCmpgClaLs($p=NULL){

			global $__cnx;

			$Vl['e'] = 'no';

			$query_Cl_Cmpg = "SELECT
									COUNT(DISTINCT id_eccmpg) AS __rgtot
								FROM
									"._BdStr(DBM).TB_EC_CMPG."
								WHERE
									eccmpg_est = "._CId('ID_ECCMPGEST_APRBD')."
								AND eccmpg_sndr = "._CId('ID_SISEML_SUMR')." ";

			$Cl_Cmpg = $__cnx->_prc($query_Cl_Cmpg);

			if($Cl_Cmpg){
				$row_Cmpg = $Cl_Cmpg->fetch_assoc();
				$Tot_Cmpg = $row_Cmpg['__rgtot'];
				$tots = $Tot_Cmpg;
			}

			foreach($this->_s_cl->ls as $_cl_k=>$_cl_v){

				$query_Cls = "SELECT COUNT(*) AS count FROM information_schema.tables WHERE table_schema = '".$_cl_v->bd."' AND table_name = '".TB_EC_SND."'";
				$ClRgs = $__cnx->_qry($query_Cls);

				if($ClRgs){

					$row_DtCls = $ClRgs->fetch_assoc();
					$Tot_DtCls = $ClRgs->num_rows;

					if($row_DtCls['count'] > 0){

						$query_Cl_EcSnd =  "SELECT
													COUNT(DISTINCT id_ecsnd) AS __rgtot
												FROM
													".$_cl_v->bd.".".TB_EC_SND."
												INNER JOIN ".$_cl_v->bd.".".TB_EC_SND_CMPG." ON ecsndcmpg_snd = id_ecsnd
												INNER JOIN "._BdStr(DBM).TB_EC_CMPG." ON ecsndcmpg_cmpg = id_eccmpg
												WHERE
													eccmpg_sndr = "._CId('ID_SISEML_SUMR')."
												AND eccmpg_est = "._CId('ID_ECCMPGEST_APRBD')."
												AND ecsnd_est = "._CId('ID_SNDEST_PRG')."
												AND ecsnd_test = 2
											";

						$Cl_EcSnd = $__cnx->_prc($query_Cl_EcSnd);

						if($Cl_EcSnd){
							$row_EcSnd = $Cl_EcSnd->fetch_assoc();
							$Tot_EcSnd = $row_EcSnd['__rgtot'];
							$tot = $tot + $Tot_EcSnd;
							$Vl['ec_cmpg'][$_cl_v->bd] = $Tot_EcSnd;
						}
					}
				}

				$__cnx->_clsr($Cl_EcSnd);
			}

			$__cnx->_clsr($Cl_Cmpg);
			$Vl['tot'] = $tots;
			$Vl['tots'] = $tot;

			return _jEnc($Vl);
		}

		public function GtEcSndCmpgLs($p=NULL){

				global $__cnx;

				$Vl['e'] = 'ok';

				$query_Cl_Cmpg = "SELECT
										COUNT(DISTINCT id_eccmpg) AS __rgtot
									FROM
										"._BdStr(DBM).TB_EC_CMPG."
									WHERE
										eccmpg_est = "._CId('ID_ECCMPGEST_SNDIN')."
									AND eccmpg_sndr = "._CId('ID_SISEML_SUMR')." ";

				$Cl_Cmpg = $__cnx->_prc($query_Cl_Cmpg);

				if($Cl_Cmpg){
					$row_Cmpg = $Cl_Cmpg->fetch_assoc();
					$Tot_Cmpg = $row_Cmpg['__rgtot'];
					$tot = $Tot_Cmpg;
				}

				foreach($this->_s_cl->ls as $_cl_k=>$_cl_v){

					$query_Cls = "SELECT COUNT(*) AS count FROM information_schema.tables WHERE table_schema = '".$_cl_v->bd."' AND table_name = '".TB_EC_SND."'";
					$ClRgs = $__cnx->_qry($query_Cls);

					if($ClRgs){

						$row_DtCls = $ClRgs->fetch_assoc();
						$Tot_DtCls = $ClRgs->num_rows;

						if($row_DtCls['count'] > 0){

							$query_Cl_EcSnd =  "SELECT
														COUNT(DISTINCT id_ecsnd) AS __rgtot
													FROM
														".$_cl_v->bd.".".TB_EC_SND."
													INNER JOIN ".$_cl_v->bd.".".TB_EC_SND_CMPG." ON ecsndcmpg_snd = id_ecsnd
													INNER JOIN "._BdStr(DBM).TB_EC_CMPG." ON ecsndcmpg_cmpg = id_eccmpg
													WHERE
														eccmpg_sndr = "._CId('ID_SISEML_SUMR')."
													AND eccmpg_est = "._CId('ID_ECCMPGEST_SNDIN')."
													AND ecsnd_est = "._CId('ID_SNDEST_PRG')."
													AND ecsnd_test = 2
												";

							$Cl_EcSnd = $__cnx->_prc($query_Cl_EcSnd);

							if($Cl_EcSnd){
								$row_EcSnd = $Cl_EcSnd->fetch_assoc();
								$Tot_EcSnd = $row_EcSnd['__rgtot'];
								$tots = $tots + $Tot_EcSnd;
								$Vl['ec_cmpg'][$_cl_v->bd] = $Tot_EcSnd;
							}
						}
					}

					$Vl['tots'] = $tots;
				}


			$Vl['tot'] = $tot;

			$__cnx->_clsr($Cl_EcSnd);
			$__cnx->_clsr($Cl_Cmpg);

			$rtrn = _jEnc($Vl);
			return($rtrn);
		}

		public function GtEcCmpgPndLs($p=NULL){

			global $__cnx;

			$Vl['e'] = 'no';

			if($this->_s_cl->tot > 0){

				$Vl['e'] = 'ok';

				$query_Cl_Cmpg = "SELECT
										COUNT(DISTINCT id_eccmpg) AS __rgtot
									FROM
										"._BdStr(DBM).TB_EC_CMPG."
									WHERE
										eccmpg_est = "._CId('ID_ECCMPGEST_PSD')."
									AND eccmpg_sndr = "._CId('ID_SISEML_SUMR')." ";

				$Cl_Cmpg = $__cnx->_qry($query_Cl_Cmpg);

				if($Cl_Cmpg){
					$row_Cmpg = $Cl_Cmpg->fetch_assoc();
					$Tot_Cmpg = $row_Cmpg['__rgtot'];
					$tot = $Tot_Cmpg;
				}

				$Vl['tot'] = $tot;
			}

			$__cnx->_clsr($Cl_EcSnd);
			$__cnx->_clsr($Cl_Cmpg);

			$rtrn = _jEnc($Vl);
			return($rtrn);
		}

		public function GtCdVrfLs($p=NULL){
			global $__cnx;

            $Vl['e'] = 'no';

            $__fl = "FROM "._BdStr(DBM).TB_SIS_CD." WHERE siscd_vrf = 2";
			$query_DtRg = "SELECT COUNT(DISTINCT id_siscd) AS __rgtot ".$__fl."";

			$DtRg = $__cnx->_qry($query_DtRg);

			if($DtRg){
				$Vl['e'] = 'ok';
				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;
				$Vl['tot'] = $row_DtRg['__rgtot'];

			}else{ $Vl['w'] = $__cnx->c_r->error; }

			$__cnx->_clsr($DtRg);

			$rtrn = _jEnc($Vl);
			return($rtrn);
		}

		public function GtSisErr($p=NULL){
			global $__cnx;

            $Vl['e'] = 'no';

			$__fl = "FROM "._BdStr(DBM).TB_SIS_ERR;
			$query_DtRg = "SELECT COUNT(DISTINCT id_siserr) AS __rgtot ".$__fl."";

			$DtRg = $__cnx->_qry($query_DtRg);

			if($DtRg){
				$Vl['e'] = 'ok';
				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;
				$Vl['sb_tot'] = $row_DtRg['__rgtot'];

				if($Tot_DtRg > 0){

					$Vl['e'] = 'ok';

					$e =  strlen($row_DtRg['__rgtot']);

					if($e >= 4 && $e <= 6){
						$Vl['tot'] = intval($row_DtRg['__rgtot'] / 1000).'K';
					}elseif($e >= 7){
						$Vl['tot'] = intval($row_DtRg['__rgtot'] / 1000000).'M';
					}else{
						$Vl['tot'] = $row_DtRg['__rgtot'];
					}

				}

			}else{ $Vl['w'] = $__cnx->c_r->error; }

			$__cnx->_clsr($DtRg);

			$rtrn = _jEnc($Vl);
			return($rtrn);
		}

		public function GtCntEmlEst($p=NULL){

			global $__cnx;

            $Vl['e'] = 'no';

			foreach($this->_s_cl->ls as $_cl_k=>$_cl_v){

				$query_Cls = "SELECT COUNT(*) AS count FROM information_schema.tables WHERE table_schema = '".$_cl_v->bd."' AND table_name = '".TB_CNT_EML."'";
				$ClRgs = $__cnx->_qry($query_Cls);

				if($ClRgs){

					$row_DtCls = $ClRgs->fetch_assoc();
					$Tot_DtCls = $ClRgs->num_rows;

					if($row_DtCls['count'] > 0){

						$query_Cl = "SELECT
							(SELECT COUNT(DISTINCT id_cnteml) as __rgtot FROM ".$_cl_v->bd.".".TB_CNT_EML." WHERE cnteml_est = "._CId('ID_SISEMLEST_BADFRMT').") AS bad_w,
							(SELECT COUNT(DISTINCT id_cnteml) as __rgtot FROM ".$_cl_v->bd.".".TB_CNT_EML." WHERE cnteml_est = "._CId('ID_SISEMLEST_NOCHCK').") AS no_chck ";
						$ClRg = $__cnx->_prc($query_Cl);

						if($ClRg){
							$row_DtCl = $ClRg->fetch_assoc();
							$Tot_DtCl = $ClRg->num_rows;

							$_bad_w = $row_DtCl['bad_w'];
							$_no_chck = $row_DtCl['no_chck'];

							$Vl['ls'][$_cl_v->enc]['nm'] = $_cl_v->nm;
							$Vl['ls'][$_cl_v->enc]['bad_w'] = $_bad_w;
							$Vl['ls'][$_cl_v->enc]['no_chck'] = $_no_chck;
							$tot_b_w = $tot_b_w + $_bad_w;
							$tot_n_c = $tot_n_c + $_no_chck;
						}

						$Vl['bad_w'] = $tot_b_w;
						$Vl['no_chck'] = $tot_n_c;

					}
				}
			}

			$__cnx->_clsr($DtRg);
			$rtrn = _jEnc($Vl);
			return($rtrn);
		}

		public function GtOrgVrfLs($p=NULL){
			global $__cnx;

            $Vl['e'] = 'no';

            $__fl = "FROM "._BdStr(DBM).TB_ORG." where org_vrf = 2";
			$query_DtRg = "SELECT COUNT(DISTINCT id_org) AS __rgtot ".$__fl."";

			$DtRg = $__cnx->_qry($query_DtRg);

			$Vl['es'] = $query_DtRg;
			if($DtRg){
				$Vl['e'] = 'ok';
				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;
				$Vl['tot'] = $row_DtRg['__rgtot'];

			}else{ $Vl['w'] = $__cnx->c_r->error; }

			$__cnx->_clsr($DtRg);

			$rtrn = _jEnc($Vl);
			return($rtrn);
		}

		public function GtTckLs($p=NULL){
			global $__cnx;

			$Vl['e'] = 'no';

			$query_DtRg = "SELECT
								id_tra
								tra_enc,
								tra_tt,
								u.us_nm AS nm_us,
								u.us_ap AS ap_us,
								u.us_img,
								cl_img,
								tracol_chk_pqr,
								tracol_chk_tck,
								asig.us_img AS img_asg,
								asig.us_nm,
								asig.us_ap
							FROM
								"._BdStr(DBM).TB_TRA."
							INNER JOIN "._BdStr(DBM).TB_CL." ON id_cl = tra_cl
							INNER JOIN "._BdStr(DBM).TB_US." AS u ON id_us = tra_us
							INNER JOIN "._BdStr(DBM).TB_TRA_COL." ON id_tracol = tra_col
							INNER JOIN "._BdStr(DBM).TB_TRA_RSP." ON trarsp_tra = id_tra
							INNER JOIN "._BdStr(DBM).TB_US." AS asig ON trarsp_us = asig.id_us
							WHERE tra_est = "._CId('ID_TRAEST_PRC')."
							AND (tracol_chk_pqr = 1 OR tracol_chk_tck = 1 OR u.us_nivel = 'superadmin')

							GROUP BY
								id_tra
							ORDER BY
								tracol_chk_pqr ASC, tracol_chk_tck ASC, id_tra DESC
							LIMIT 7";


			$DtRg = $__cnx->_qry($query_DtRg);

			if($DtRg){
				$Vl['e'] = 'ok';
				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;
				$Vl['tot'] = $Tot_DtRg;

				if($Tot_DtRg > 0){

					$Vl['e'] = 'ok';

					do{
						$Vl['ls'][$row_DtRg['tra_enc']]['tt'] = ctjTx($row_DtRg['tra_tt'], 'in');
						$Vl['ls'][$row_DtRg['tra_enc']]['us_nm'] = $row_DtRg['nm_us'].' '.$row_DtRg['ap_us'];
						$Vl['ls'][$row_DtRg['tra_enc']]['us_img'] = $row_DtRg['img_asg'];
						$Vl['ls'][$row_DtRg['tra_enc']]['cl_img'] = $row_DtRg['cl_img'];
						$Vl['ls'][$row_DtRg['tra_enc']]['pqr'] = $row_DtRg['tracol_chk_pqr'];
						$Vl['ls'][$row_DtRg['tra_enc']]['tck'] = $row_DtRg['tracol_chk_tck'];

					}while($row_DtRg = $DtRg->fetch_assoc());
				}

			}else{ $Vl['w'] = $__cnx->c_r->error; }

			$__cnx->_clsr($DtRg);

			$rtrn = _jEnc($Vl);
			return($rtrn);
		}

		public function GtDwnEstLs($p=NULL){
			global $__cnx;

            $Vl['e'] = 'no';

			$query_DtRg = "SELECT COUNT(DISTINCT id_dwn) AS __rgtot FROM ".DBD.".".TB_DWN." WHERE dwn_est = 3";

			$DtRg = $__cnx->_qry($query_DtRg);

			if($DtRg){
				$Vl['e'] = 'ok';
				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;
				$Vl['tot'] = $row_DtRg['__rgtot'];
			}else{ $Vl['w'] = $__cnx->c_r->error; }

			$__cnx->_clsr($DtRg);

			$rtrn = _jEnc($Vl);
			return($rtrn);
		}

		public function GtLeadAd($p=NULL){
			global $__cnx;

            $Vl['e'] = 'no';

            $__fl = "FROM "._BdStr(DBT).TB_SCL_ACC_FORM_LEADS." WHERE sclaccformleads_fi LIKE '%".date("Y-m-d ", time())."%'";
			$query_DtRg = "SELECT COUNT(DISTINCT id_sclaccformleads) AS __rgtot ".$__fl."";

			$__fl = "FROM "._BdStr(DBT).TB_SCL_ACC_FORM_LEADS." WHERE sclaccformleads_fi LIKE '%".date("Y-m", time())."%'";
			$query_DtRg_1 = "SELECT COUNT(DISTINCT id_sclaccformleads) AS __rgtot ".$__fl."";

			$DtRg = $__cnx->_qry($query_DtRg);
			$DtRg_1 = $__cnx->_qry($query_DtRg_1);

			if($DtRg){
				$Vl['e'] = 'ok';
				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;
				$Vl['sb_tot'] = $row_DtRg['__rgtot'];

				if($Tot_DtRg > 0){  $Vl['tot'] = $row_DtRg['__rgtot']; }
			}

			if($DtRg_1){
				$Vl['e'] = 'ok';
				$row_DtRg_1 = $DtRg_1->fetch_assoc();
				$Tot_DtRg_1 = $DtRg_1->num_rows;

				if($Tot_DtRg_1 > 0){  $Vl['tots'] = $row_DtRg_1['__rgtot']; }
			}

			$__cnx->_clsr($DtRg);
			$__cnx->_clsr($DtRg_1);

			$rtrn = _jEnc($Vl);
			return($rtrn);
		}

		public function GtSclRcl($p=NULL){
			global $__cnx;

            $Vl['e'] = 'no';

			$query_DtRg_1 = "SELECT
										COUNT(*) AS mdl
									FROM
										"._BdStr(DBT).TB_SCL_ACC_FORM."
									INNER JOIN "._BdStr(DBT).TB_SCL_ACC." ON sclaccform_sclacc = id_sclacc
									INNER JOIN ".DBM."._cl_scl_acc ON clsclacc_sclacc = sclaccform_sclacc
									WHERE
										clsclacc_cl = 15
									AND
										sclaccform_mdl IS NULL AND sclaccform_est = "._CId('ID_SISEST_OK')."
								";

			$query_DtRg_2 = "SELECT
										COUNT(*)  AS plcy
									FROM
										"._BdStr(DBT).TB_SCL_ACC_FORM."
									INNER JOIN "._BdStr(DBT).TB_SCL_ACC." ON sclaccform_sclacc = id_sclacc
									INNER JOIN ".DBM."._cl_scl_acc ON clsclacc_sclacc = sclaccform_sclacc
									WHERE
										clsclacc_cl = 15
									AND
										sclaccform_plcy IS NULL AND sclaccform_est = "._CId('ID_SISEST_OK')."
								";

			$DtRg_1 = $__cnx->_qry($query_DtRg_1);
			$DtRg_2 = $__cnx->_qry($query_DtRg_2);

			if($DtRg_1){
				$row_DtRg_1 = $DtRg_1->fetch_assoc();
				$Tot_DtRg = $DtRg_1->num_rows;
				$Vl['mdl'] = $row_DtRg_1['mdl'];
			}

			if($DtRg_2){
				$row_DtRg_2 = $DtRg_2->fetch_assoc();
				$Tot_DtRg = $DtRg_2->num_rows;
				$Vl['plcy'] = $row_DtRg_2['plcy'];
			}

			$__cnx->_clsr($DtRg_1);
			$__cnx->_clsr($DtRg_2);

			$rtrn = _jEnc($Vl);
			return($rtrn);
		}

		public function GtApiRqu($p=NULL){

			global $__cnx;

			$Vl['e'] = 'no';

			$__dt_1 = date('Y-m-01');
			$__dt_2 = date('Y-m-d');

			$__dt_2 = date("Y-m-d",strtotime($__dt_2."+ 1 days"));

			$query_DtRg_1 = "SELECT
								DATE_FORMAT(apirq_fi , '%Y-%m-%d') as fecha ,
								COUNT( DISTINCT id_apirq ) AS tot
							FROM
								_api_rq
							WHERE
								apirq_e = '1' AND apirq_fi BETWEEN '".$__dt_1."' AND '".$__dt_2."'
							GROUP BY DATE_FORMAT(apirq_fi , '%Y-%m-%d') ORDER BY fecha DESC";

			$query_DtRg_2 = "SELECT
								DATE_FORMAT(apirq_fi , '%Y-%m-%d') as fecha ,
								COUNT( DISTINCT id_apirq ) AS tot
							FROM _api_rq
							WHERE
								apirq_e = '2' AND apirq_fi BETWEEN '".$__dt_1."' AND '".$__dt_2."'
							GROUP BY DATE_FORMAT(apirq_fi , '%Y-%m-%d') ORDER BY fecha DESC";

			$DtRg_1 = $__cnx->_qry($query_DtRg_1);
			$DtRg_2 = $__cnx->_qry($query_DtRg_2);

		   	if($DtRg_1){

				$Vl['e'] = 'ok';
				$row_DtRg_1 = $DtRg_1->fetch_assoc();
				$Tot_DtRg_1 = $DtRg_1->num_rows;

				if($Tot_DtRg_1 > 0){

					do{
						$Vl1[$row_DtRg_1['fecha']]['date'] = $row_DtRg_1['fecha'];
						$Vl1[$row_DtRg_1['fecha']]['tot'] = $row_DtRg_1['tot'];
					}while($row_DtRg_1 = $DtRg_1->fetch_assoc());

					$Vl_Grph_1 = _jEnc($Vl1);
				}
			}

			if($DtRg_2){

				$Vl['e'] = 'ok';
				$row_DtRg_2 = $DtRg_2->fetch_assoc();
				$Tot_DtRg_2 = $DtRg_2->num_rows;

				if($Tot_DtRg_2 > 0){

					do{
						$Vl2[$row_DtRg_2['fecha']]['date'] = $row_DtRg_2['fecha'];
						$Vl2[$row_DtRg_2['fecha']]['tot'] = $row_DtRg_2['tot'];
					}while($row_DtRg_2 = $DtRg_2->fetch_assoc());

					$Vl_Grph_2 = _jEnc($Vl2);
				}
			}

			for( $i = $__dt_1 ; $i <= $__dt_2 ; $i = date("Y-m-d", strtotime($i ."+ 1 days")) ){
				$__ctg[] = $i;

				if(!isN($Vl_Grph_1->{$i}->tot)){ $_tot_1 = $Vl_Grph_1->{$i}->tot; }else{ $_tot_1 = 0; }

				if(!isN($Vl_Grph_2->{$i}->tot)){ $_tot_2 = $Vl_Grph_2->{$i}->tot; }else{ $_tot_2 = 0; }

				$_medio_tot_1[] = intval($_tot_1);
				$_medio_tot_2[] = intval($_tot_2);
			}

			$_grph_d_1 = $_medio_tot_1;
			$_grph_d_2 = $_medio_tot_2;
			$_grph_c = $__ctg;

			array_pop($_grph_d_1);
			array_pop($_grph_d_2);
			array_pop($_grph_c);

			$_Vl['act1']['d1'] = $_grph_d_1;
			$_Vl['act1']['d2'] = $_grph_d_2;
			$_Vl['act1']['c'] = $_grph_c;

			$_Vl['act1']['d_1'] = end($_grph_d_1);
			$_Vl['act1']['d_2'] = end($_grph_d_2);

			$rtrn = _jEnc($_Vl);
			return($rtrn);
		}


		public function GtEstdAws($p=NULL){

			global $__cnx;

			$Vl['e'] = 'no';

			$query_DtRg = "	SELECT id_awsrsrc, awsrsrc_nm, awsrsrc_enc FROM ".DBT.".aws_rsrc ";

			$DtRg = $__cnx->_qry($query_DtRg);

			if($DtRg){

				$Vl['e'] = 'ok';
				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;
				$Vl['tot'] = $Tot_DtRg;

				if($Tot_DtRg > 0){
					$Vl['e'] = 'ok';
					do{

						$query_Aws = "SELECT
										awsrsrcsta_value
									FROM
										".DBT.".aws_rsrc_sta
									WHERE
										awsrsrcsta_awsaccrsrc = ".$row_DtRg['id_awsrsrc']."
									ORDER BY id_awsrsrcsta DESC LIMIT 1";
						$DtAws = $__cnx->_qry($query_Aws);

						if($DtAws){

							$Vl['e'] = 'ok';
							$row_DtAws = $DtAws->fetch_assoc();
							$Tot_DtAws = $DtAws->num_rows;
							$Vl['tot'] = $Tot_DtAws;

							if($Tot_DtAws > 0){
								$Vl['ls'][$row_DtRg['awsrsrc_enc']]['nm'] = $row_DtRg['awsrsrc_nm'];
								$Vl['ls'][$row_DtRg['awsrsrc_enc']]['vl'] = round($row_DtAws['awsrsrcsta_value'], 2);

								if($row_DtAws['awsrsrcsta_value'] > 90){
									$Vl['ls'][$row_DtRg['awsrsrc_enc']]['est'] = 2;
								}elseif($row_DtAws['awsrsrcsta_value'] < 90 && $row_DtAws['awsrsrcsta_value'] >= 50 ){
									$Vl['ls'][$row_DtRg['awsrsrc_enc']]['est'] = 3;
								}else{
									$Vl['ls'][$row_DtRg['awsrsrc_enc']]['est'] = 1;
								}
							}

						}

					}while($row_DtRg = $DtRg->fetch_assoc());
				}

			}else{ $Vl['w'] = $__cnx->c_r->error; }

			$__cnx->_clsr($DtRg);

			$rtrn = _jEnc($Vl);

			return($rtrn);

		}

    }
?>