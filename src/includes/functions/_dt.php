<?php

	$__mre_dt = ['tra', 'store'];

	foreach($__mre_dt as $k=>$v){

		if(PHP_VERSION > 6){
			$___pth = dirname(__FILE__, 2);
		}else{
			$___pth = dirname(dirname(__FILE__));
		}

		if (file_exists($___pth.'/'.DIR_INC_FNC_DT.$v.'.php')) {
			include_once($___pth.'/'.DIR_INC_FNC_DT.$v.'.php');
		}
	}

	function GtSisThrdDt($p=NULL){

		global $__cnx;

		$Vl['e'] = 'no';

		$query_DtRg = sprintf("SELECT * FROM "._BdStr(DBM).TB_SIS_THIRD." WHERE id_sisthird = %s LIMIT 1", GtSQLVlStr($p['id'], "int"));

		$DtRg = $__cnx->_qry($query_DtRg);

		if($DtRg){

			$row_DtRg = $DtRg->fetch_assoc();
			$Tot_DtRg = $DtRg->num_rows;

			if($Tot_DtRg > 0){

				$Vl['e'] = 'ok';
				$Vl['id'] = $row_DtRg['id_sisthird'];
				$Vl['tt'] = ctjTx($row_DtRgp['sisthird_tt'],'in');
				$Vl['key'] = ctjTx($row_DtRg['sisthird_key'],'in');
				$Vl['status'] = ctjTx($row_DtRg['sisthird_status'],'in');
				$Vl['fa']['all'] = ctjTx($row_DtRg['sisthird_fa'],'in');


				$date1 = new DateTime("now");

				if($row_DtRg['sisthird_fa'] != ''){
					$date2 = new DateTime($row_DtRg['sisthird_fa']);
					$dteDiff  = $date2->diff($date1);
					$Vl['fa']['day'] = $date2->format('Y-m-d');
					$Vl['fa']['updt'] = ($Vl['fa']['day']==SIS_F2)?'ok':'no'; // Updated today?
					$Vl['fa']['diff'] = $dteDiff->format("%h");
				}

			}

		}

		$__cnx->_clsr($DtRg);

		return(_jEnc($Vl));

	}

	function GtSgnDt($Id, $tp){

		if($tp == 'id'){

			$flt = 'id_sgn';

		}elseif($tp == 'enc'){

			$flt = 'sgn_enc';

		}

		if(!isN($Id)){

			global $__cnx;

			$c_DtRg = "-1";if (isset($Id)){$c_DtRg = $Id;}
			$query_DtRg = sprintf('SELECT * FROM '.DBM.'.sgn WHERE '.$flt.' = %s', GtSQLVlStr($c_DtRg,'int'));

			$DtRg = $__cnx->_qry($query_DtRg);

			if($DtRg){

				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;

				$Vl['id'] = $row_DtRg['id_sgn'];
				$Vl['tt'] = ctjTx($row_DtRg['sgn_tt'],'in');
				$Vl['enc'] = ctjTx($row_DtRg['sgn_enc'],'in');
				$Vl['est'] = ctjTx($row_DtRg['sgn_est'],'in');
				$Vl['cd'] = ctjTx($row_DtRg['sgn_cd'],'out','',['html'=>'ok']);
				$Vl['dir'] = ctjTx($row_DtRg['sgn_dir'],'in');

			}

			$__cnx->_clsr($DtRg);

			return(_jEnc($Vl));

		}

	}

	function LsEc($__id, $__v='id_ec', $__va=NULL, $__lbl=NULL, $__rq=NULL, $__mlt=NULL, $_p=NULL){

		global $__cnx;

		if(!isN($__id)){

			if($_p['ord'] == 'i'){ $___ord = 'id_ec DESC'; }else{ $___ord = 'ec_fi DESC'; }
			if(!isN($_p['tp'])){ $__fl .= " AND mdlstp_tp = '".$_p['tp']."' "; }


			if($_p['frm'] == 'ec_cmz'){
				$__fl .= " AND ec_cmzrlc IS NOT NULL ";
			}elseif(!ChckSESS_superadm()){
				$__fl .= " AND (ec_frm='"._CId('ID_SISECFRM_CDG')."' ) ";
			}

			$Ls_Qry = "SELECT *,
							  ".GtSlc_QryExtra(['t'=>'fld', 'p'=>'format', 'als'=>'f'])."
						FROM "._BdStr(DBM).TB_EC."
							 INNER JOIN "._BdStr(DBM).TB_CL." ON ec_cl = id_cl
							 ".GtSlc_QryExtra(['t'=>'tb', 'col'=>'ec_frm', 'als'=>'f'])."
							 LEFT JOIN "._BdStr(DBM).TB_EC_TP." ON ecmdlstp_ec = id_ec
							 LEFT JOIN "._BdStr(DBM).TB_MDL_S_TP." ON ecmdlstp_mdlstp = id_mdlstp
						WHERE
							cl_enc = '".DB_CL_ENC."' AND
							ec_est != "._CId('ID_SISEST_OBSL')." AND
							(ec_est='"._CId('ID_SISEST_OK')."' || ec_est='"._CId('ID_SISEST_APRB')."') {$__fl}

						ORDER BY ".$___ord;

			$Ls = $__cnx->_qry($Ls_Qry);

			if($Ls){

				$row_Ls = $Ls->fetch_assoc();
				$Tot_Ls = $Ls->num_rows;
				$LsBld .= HTML_OpVl(['ct'=>'off']);

				if($Tot_Ls > 0){

					do {

						if (!(strcmp($row_Ls[$__v], $__va))){ $_slc = 'ok';}else{$_slc = 'no';}

						if($_p['frm']=='ec_cmz'){
							$__prfx = '('.CODNM_EC.$row_Ls['id_ec'].') ';
						}elseif(!isN($_p['tp'])){
							$__prfx = '('.$row_Ls['mdlstp_nm'].') ';
						}else{
							$__prfx = '['.$row_Ls['ec_fi'].'] ';
						}

						$LsBld .= HTML_OpVl(['t'=>$__prfx.$row_Ls['ec_tt'], 'rel'=>$row_Ls['ec_tt'], 'v'=>$row_Ls[$__v], 's'=>$_slc]);

					} while ($row_Ls = $Ls->fetch_assoc());

					if($Tot_Ls > 0) { $Ls->data_seek(0); $row_Ls = $Ls->fetch_assoc(); }
					if($__mlt == 'ok'){ $_cls = DV_CLSS_SLCT_MLT; }else{  $_cls = DV_CLSS_SLCT_BX;}
					$_rtrn2 = bdiv(['c'=>HTML_Slct(['id'=>$__id, 'ph'=>FM_LS_SLEC, 'rq'=>$__rq, 'c'=>$LsBld, 'm'=>$__mlt, 'attr'=>$_p['attr'] ]), 'cls'=>$_cls]);
				}

			}else{

				echo $__cnx->c_r->error;

			}

			$__cnx->_clsr($Ls);

			return($_rtrn2);

		}
	}

	function LsEcLnk($_p=NULL){ // $__id, $__v='id_ec', $__va=NULL, $__lbl, $__rq=NULL, $__mlt=NULL, $_p=NULL

		global $__cnx;

		if( !isN($_p['id']) ){

			if(!isN($_p['ec'])){ $__fl .= " AND eclnk_ec = '".$_p['ec']."' "; }

			$Ls_Qry = "	SELECT *
						FROM "._BdStr(DBM).TB_EC_LNK."
						WHERE id_eclnk != '' {$__fl}";

			$Ls = $__cnx->_qry($Ls_Qry);

			if($Ls){

				$row_Ls = $Ls->fetch_assoc();
				$Tot_Ls = $Ls->num_rows;
				$LsBld .= HTML_OpVl(['ct'=>'off']);

				if($Tot_Ls > 0){
					do {
						if (!(strcmp($row_Ls[$_p['v']], $_p['va']))){ $_slc = 'ok';}else{$_slc = 'no';}
						$LsBld .= HTML_OpVl(['t'=>$row_Ls['eclnk_lnk'], 'v'=>$row_Ls[$_p['v']], 's'=>$_slc]);
					} while ($row_Ls = $Ls->fetch_assoc());

					if($Tot_Ls > 0) { $Ls->data_seek(0); $row_Ls = $Ls->fetch_assoc(); }
					if($__mlt == 'ok'){ $_cls = DV_CLSS_SLCT_MLT; }else{  $_cls = DV_CLSS_SLCT_BX;}
					$_rtrn2 = bdiv(['c'=>HTML_Slct(['id'=>$_p['id'], 'ph'=>FM_LS_SLECLNK, 'rq'=>$_p['rq'], 'c'=>$LsBld, 'm'=>$_p['mlt'] ]), 'cls'=>$_cls]);
				}

			}

			$__cnx->_clsr($Ls);

		}

		return($_rtrn2);
	}

	function LsCntEml($_p=NULL){

		global $__cnx;

		if(!isN($_p['id'])){

			if(!isN( $_p['v'] )){ $__v = $_p['v']; }else{ $__v = 'cnteml_eml'; }

			if($_p['actv'] != 'no'){
				$_fl .= "
					AND clplcy_e = 1
					AND (
							cntemlplcy_sndi !=2 AND
							cnteml_rjct !=1 AND
							cnteml_cld > 0
					)
					AND cntplcy_sndi = 1
					AND cnteml_est="._CId('ID_SISEMLEST_ACT')."
				";
			}

			$Ls_Qry = "	SELECT *
						FROM ".TB_CNT_EML."
							 INNER JOIN ".TB_CNT_EML_PLCY." ON cntemlplcy_cnteml = id_cnteml
							 INNER JOIN ".TB_CNT." ON cnteml_cnt = id_cnt
							 INNER JOIN ".TB_CNT_PLCY." ON cntplcy_cnt = id_cnt
							 INNER JOIN "._BdStr(DBM).TB_CL_PLCY." ON cntemlplcy_plcy = id_clplcy
						WHERE
								cnteml_cnt = ".GtSQLVlStr($_p['cnt'], "int")."
								{$_fl}

						GROUP BY id_cnteml
					";

			$Ls = $__cnx->_qry($Ls_Qry);

			if($Ls){

				$row_Ls = $Ls->fetch_assoc();
				$Tot_Ls = $Ls->num_rows;

				if($Tot_Ls > 0){

					$LsBld .= HTML_OpVl(['ct'=>'off']);

					do {
						if (!(strcmp($row_Ls[$__v], $__va)) || $Tot_Ls==1 ){ $_slc = 'ok';}else{$_slc = 'no';}
						$LsBld .= HTML_OpVl(['t'=>$row_Ls['cnteml_eml'], 'v'=>$row_Ls[$__v], 's'=>$_slc]);
					} while ($row_Ls = $Ls->fetch_assoc());

					if($Tot_Ls > 0) { $Ls->data_seek(0); $row_Ls = $Ls->fetch_assoc(); }

				}

				if($__mlt == 'ok'){ $_cls = DV_CLSS_SLCT_MLT; }else{  $_cls = DV_CLSS_SLCT_BX;}

				$_rtrn2 = bdiv(['c'=>HTML_Slct(['id'=>$_p['id'], 'ph'=>FM_LS_SLEML, 'rq'=>$__rq, 'c'=>$LsBld, 'm'=>$__mlt]), 'cls'=>$_cls]);

			}

			$__cnx->_clsr($Ls);

			return($_rtrn2);
		}
	}


	function LsCntDc($_p=NULL){

		global $__cnx;

		if(!isN($_p['id'])){

			if(!isN( $_p['v'] )){ $__v = $_p['v']; }else{ $__v = 'cntdc_dc'; }

			$Ls_Qry = "	SELECT *
						FROM ".TB_CNT_DC."
							 INNER JOIN ".TB_CNT." ON cntdc_cnt = id_cnt
						WHERE cntdc_cnt = ".GtSQLVlStr($_p['cnt'], "int")."
						GROUP BY id_cntdc
					";

			$Ls = $__cnx->_qry($Ls_Qry);

			if($Ls){

				$row_Ls = $Ls->fetch_assoc();
				$Tot_Ls = $Ls->num_rows;

				if($Tot_Ls > 0){

					$LsBld .= HTML_OpVl(['ct'=>'off']);

					do {
						if (!(strcmp($row_Ls[$__v], $__va))){ $_slc = 'ok';}else{$_slc = 'no';}
						$LsBld .= HTML_OpVl(['t'=>$row_Ls['cntdc_dc'], 'v'=>$row_Ls[$__v], 's'=>$_slc]);
					} while ($row_Ls = $Ls->fetch_assoc());


					if($Tot_Ls > 0) { $Ls->data_seek(0); $row_Ls = $Ls->fetch_assoc(); }
					if($__mlt == 'ok'){ $_cls = DV_CLSS_SLCT_MLT; }else{  $_cls = DV_CLSS_SLCT_BX;}

				}

				$_rtrn2 = bdiv(['c'=>HTML_Slct(['id'=>$_p['id'], 'ph'=>FM_LS_SLDOC, 'rq'=>$__rq, 'c'=>$LsBld, 'm'=>$__mlt]), 'cls'=>$_cls]);

			}

			$__cnx->_clsr($Ls);

			return($_rtrn2);
		}
	}

	function GtSgnSgmLs($Id, $tp){

		if($tp == 'id'){

			$flt = 'id_sgncod';

		}elseif($tp == 'enc'){

			$flt = 'sgncod_enc';

		}

		if(!isN($Id)){

			global $__cnx;

			$c_DtRg = "-1";if (isset($Id)){$c_DtRg = $Id;}
			$query_DtRg = sprintf('SELECT
										*
									FROM
										sgn_cod,
										sgn,
										sgn_cod_sgm
										INNER JOIN '.DBM.'._sis_slc ON sgncodsgm_sgm = id_sisslc
									WHERE
										sgncod_sgn = id_sgn
									AND sgncodsgm_sgncod = id_sgncod
									AND '.$flt.' = %s', GtSQLVlStr($c_DtRg,'text'));

			$DtRg = $__cnx->_qry($query_DtRg);

			if($DtRg){

				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;

				if($Tot_DtRg > 0){

					do{

						$Vl[$row_DtRg['id_sisslc']] = [ 'id'=>ctjTx($row_DtRg['id_sgncodsgm'],'out'),
															 'tt'=>ctjTx($row_DtRg['sgncodsgm_vle'],'out','',['html'=>'ok'])
															  ];


					} while ($row_DtRg = $DtRg->fetch_assoc());

				}

			}

			$__cnx->_clsr($DtRg);

		return(_jEnc($Vl));
		}
	}

	function _pay($Id, $p=NULL){

		global $__cnx;

		if(!isN($Id)){
			$c_DtRg = "-1";if (isset($Id)){$c_DtRg = $Id;}
			$query_DtRg = sprintf('SELECT * FROM '.TB_SIS_PAY_EST.' WHERE id_sispayest = %s LIMIT 1', GtSQLVlStr($c_DtRg,'int'));
			$DtRg = $__cnx->_qry($query_DtRg);

			if($DtRg){

				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;

				if($Tot_DtRg > 0){
					$Vl['id'] = $row_DtRg['id_sispayest'];
					$Vl['tt'] = ctjTx($row_DtRg['sispayest_tt'],'in');
					$Vl['sty'] = ctjTx($row_DtRg['sispayest_sty'],'in');
				}

			}

			$__cnx->_clsr($DtRg);

			$rtrn = json_encode($Vl);
			if($p['r'] == 'spn'){ return(Spn($Vl['tt'], 'ok', $Vl['sty'])); }else{ return($rtrn); }
		}
	}



	function GtBcoDt($p=NULL){

		global $__cnx;

		$Vl['e'] = 'no';

		if(!isN($p['id'])){

			if($p['t'] == 'org'){ $__f = 'bco_org'; $__ft = 'text'; }
			elseif($p['t'] == 'enc'){ $__f = 'bco_enc'; $__ft = 'text'; }
			else{ $__f = 'id_bco'; $__ft = 'int'; }

			if(defined('CL_ENC') && !isN(CL_ENC)){ $_fl .= " AND cl_enc = '".CL_ENC."' "; }


			$query_DtRg = sprintf("	SELECT *
									FROM "._BdStr(DBM).TB_BCO."
										 INNER JOIN "._BdStr(DBM).TB_CL." ON bco_cl = id_cl
									WHERE ".$__f." = %s {$_fl} LIMIT 1", GtSQLVlStr($p['id'], $__ft));

			$DtRg = $__cnx->_qry($query_DtRg);

			if($DtRg){

				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;;

				$Vl['tot'] = $Tot_DtRg;

				if($Tot_DtRg > 0){
					$Vl['id'] = $row_DtRg['id_bco'];
					$Vl['tt'] = ctjTx($row_DtRg['bco_tt'],'in');
					$Vl['img'] = ctjTx($row_DtRg['bco_img'],'in');
					$Vl['ext'] = ctjTx($row_DtRg['bco_ext'],'in');
					$Vl['out'] = mBln($row_DtRg['bco_out']);
					$Vl['fce'] = GtBcoFceLs([ 'bco'=>$row_DtRg['id_bco'] ]);
				}

			}

			$__cnx->_clsr($DtRg);

		}else{

			$Vl['w'] = 'no data';

		}

		return _jEnc($Vl);
	}

	function GtBcoLs($p){

		global $__cnx;

		if(!isN($p)){


			if(defined('CL_ENC') && !isN(CL_ENC)){ $_fl .= " AND cl_enc = '".CL_ENC."' "; }
			if(!isN($p['idm']) && is_array($p['idm'])){
				foreach($p['idm'] as $_idm_k=>$_idm_v){
					$_idm[] = "'".$_idm_v."'";
				}
				$_fl .= " AND id_bco IN (".implode(',',$_idm).")";
			}

			$query_DtRg = sprintf("	SELECT *
									FROM "._BdStr(DBM).TB_BCO."
										 INNER JOIN "._BdStr(DBM).TB_CL." ON bco_cl = id_cl
									WHERE id_bco != '' {$_fl} ");

			$DtRg = $__cnx->_qry($query_DtRg);

			if($DtRg){

				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;

				$Vl['tot'] = $Tot_DtRg;

				if($Tot_DtRg > 0){

					do{

						$__id = $row_DtRg['bco_enc'];

						if(!isN($__id)){
							$Vl['ls'][$__id]['id'] = $row_DtRg['id_bco'];
							$Vl['ls'][$__id]['enc'] = $row_DtRg['bco_enc'];
							$Vl['ls'][$__id]['img'] = ctjTx($row_DtRg['bco_img'],'in');
						}

					}while($row_DtRg = $DtRg->fetch_assoc());

				}

			}

			$__cnx->_clsr($DtRg);

		}

		return _jEnc($Vl);

	}

	function GtBcoChkTpLs($p){

		global $__cnx;

		$query_DtRg = sprintf("	SELECT *
								FROM "._BdStr(DBM).TB_BCO_CHK_TP."
								WHERE id_bcochktp != '1' ");

		$DtRg = $__cnx->_qry($query_DtRg);

		if($DtRg){

			$row_DtRg = $DtRg->fetch_assoc();
			$Tot_DtRg = $DtRg->num_rows;

			$Vl['tot'] = $Tot_DtRg;

			if($Tot_DtRg > 0){

				do{

					$__id = $row_DtRg['id_bcochktp'];

					$Vl[$__id]['id'] = $row_DtRg['id_bcochktp'];
					$Vl[$__id]['tt'] = $row_DtRg['bcochktp_tt'];
					$Vl[$__id]['key'] = ctjTx($row_DtRg['bcochktp_key'],'in');
					$Vl[$__id]['sze'] = ctjTx($row_DtRg['bcochktp_sze'],'in');


				}while($row_DtRg = $DtRg->fetch_assoc());

			}

		}

		$__cnx->_clsr($DtRg);

		return _jEnc($Vl);

	}


	/* Temporal */
	function GtEmlEcLstsSgmVar($p){

		global $__cnx;

		$query_DtRg = sprintf("
								SELECT * FROM ec_lsts_sgm_var
								INNER JOIN ec_lsts_sgm ON eclstssgmvar_sgm = id_eclstssgm /* Lista de segmentos relacionados a listas */
								INNER JOIN _sis_ec_sgm_var ON eclstssgmvar_var = id_sisecsgmvar /* Variables - Querys */
								WHERE id_eclstssgm = ".$p["id_eclstssgm"]."
							");

		$DtRg = $__cnx->_qry($query_DtRg);

		if($DtRg){

			$row_DtRg = $DtRg->fetch_assoc();
			$Tot_DtRg = $DtRg->num_rows;

			$Vl['tot'] = $Tot_DtRg;

			if($Tot_DtRg > 0){

				do{

					$__id = $row_DtRg['id_bcochktp'];

					$Vl[$__id]['id'] = $row_DtRg['id_bcochktp'];
					$Vl[$__id]['tt'] = $row_DtRg['bcochktp_tt'];
					$Vl[$__id]['key'] = ctjTx($row_DtRg['bcochktp_key'],'in');
					$Vl[$__id]['sze'] = ctjTx($row_DtRg['bcochktp_sze'],'in');


				}while($row_DtRg = $DtRg->fetch_assoc());

			}

		}

		$__cnx->_clsr($DtRg);

		return _jEnc($Vl);

	}
	/* Temporal */

	function GtBcoFceLs($p){

		global $__cnx;

		if(!isN($p['bco'])){


			$query_DtRg = sprintf("	SELECT *
									FROM "._BdStr(DBM).TB_BCO_FCE."
									WHERE bcofce_bco = %s", GtSQLVlStr($p['bco'], 'int'));

			$DtRg = $__cnx->_qry($query_DtRg);

			if($DtRg){

				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;

				$Vl['tot'] = $Tot_DtRg;

				if($Tot_DtRg > 0){

					do{

						$__id = $row_DtRg['bcofce_enc'];

						$Vl['ls'][$__id]['id'] = $row_DtRg['id_bcofce'];
						$Vl['ls'][$__id]['enc'] = $row_DtRg['bcofce_enc'];
						$Vl['ls'][$__id]['cid'] = $row_DtRg['bcofce_id'];
						$Vl['ls'][$__id]['attr'] = GtBcoFceAttrLs([ 'bco_fce'=>$row_DtRg['id_bcofce'] ]);
						$Vl['ls'][$__id]['img']['main'] = DMN_FLE_BCO_FCE.$row_DtRg['bcofce_img'];
						$Vl['ls'][$__id]['img']['th'] = DMN_FLE_BCO_FCE_TH.$row_DtRg['bcofce_img'];

					}while($row_DtRg = $DtRg->fetch_assoc());

				}

			}

			$__cnx->_clsr($DtRg);

			return _jEnc($Vl);

		}

	}

	function GtBcoFceAttrLs($p){

		global $__cnx;

		if(!isN($p['bco_fce'])){


			$query_DtRg = sprintf("	SELECT *
									FROM "._BdStr(DBM).TB_BCO_FCE_ATTR."
										 INNER JOIN "._BdStr(DBM).TB_BCO_FCE." ON bcofceattr_bcofce = id_bcofce
										 INNER JOIN "._BdStr(DBM).TB_BCO." ON bcofce_bco = id_bco
										 INNER JOIN "._BdStr(DBM).TB_BCO_CHK." ON bcochk_bco = id_bco
										 INNER JOIN "._BdStr(DBM).TB_BCO_CHK_TP." ON bcochk_chktp = id_bcochktp
									WHERE bcofceattr_bcofce = %s", GtSQLVlStr($p['bco_fce'], 'int'));

			$DtRg = $__cnx->_qry($query_DtRg);

			if($DtRg){

				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;

				$Vl['tot'] = $Tot_DtRg;

				if($Tot_DtRg > 0){

					do{

						$__id = $row_DtRg['bcofceattr_key'];
						$__idt = $row_DtRg['bcochktp_key'];

						$Vl['ls'][$__id]['id'] = $row_DtRg['id_bcofceattr'];
						$Vl['ls'][$__id]['enc'] = $row_DtRg['bcofceattr_enc'];
						$Vl['ls'][$__id]['key'] = ctjTx($row_DtRg['bcofceattr_key'],'in');

						if($row_DtRg['id_bcochktp'] != 1){
							$width = $row_DtRg['bcochk_w'];
							$height = $row_DtRg['bcochk_h'];
						}else{
							$width = $row_DtRg['bco_w'];
							$height = $row_DtRg['bco_h'];
						}

						//echo $__id.' ---- '.$row_DtRg['id_bcochktp'].' ----- '.$row_DtRg['bcochktp_key'].' ----- '.$width.' = '.$height.HTML_BR;

						$___code = ctjTx( $row_DtRg['bcofceattr_vl'] ,'in','', ['html'=>'ok','schr'=>'no','nl2'=>'no','qte'=>'no']);

						if(is_json($___code)){

							$___code_v = json_decode($___code);

							if($__id == 'BoundingBox'){

								$__left = number_format( $___code_v->Left * $width , 0, '.', '');
								$__top = number_format( $___code_v->Top * $height , 0, '.', '');
								$__width = number_format( $___code_v->Width * $width , 0, '.', '');
								$__height = number_format( $___code_v->Height * $height , 0, '.', '');
								$__divs_faces[$__idt] .= '<div class="bounding _anm" data-fce-id="'.ctjTx($row_DtRg['bcofce_enc'],'in').'" style="position:absolute; left:'.$__left.'px; top:'.$__top.'px; width:'.$__width.'px; height:'.$__height.'px;"></div>';


							}elseif($__id == 'Landmarks'){

								foreach($___code_v as $_lndmrk_k=>$_lndmrk_v){

									if(	$_lndmrk_v->Type == 'eyeLeft' ||
										$_lndmrk_v->Type == 'eyeRight' ||
										$_lndmrk_v->Type == 'mouthLeft' ||
										$_lndmrk_v->Type == 'mouthRight' ||
										$_lndmrk_v->Type == 'nose'){

											$__l_left = number_format( ($_lndmrk_v->X * $width) - 2 , 0, '.', '');
											$__l_top = number_format( ($_lndmrk_v->Y * $height) - 2 , 0, '.', '');
											$__divs_faces[$__idt] .= '<div class="landmark _anm" style="position:absolute; left:'.$__l_left.'px; top:'.$__l_top.'px;"></div>';

									}
								}

							}

							if(!isN($__divs_faces)){

								$Vl['div'][ $__idt ]['vl'] = htmlentities( $__divs_faces[$__idt] );

							}

						}else{

							$___code_v = $___code;

						}

						$Vl['ls'][$__id]['vl'] = $___code_v;

					}while($row_DtRg = $DtRg->fetch_assoc());

				}

			}

			$__cnx->_clsr($DtRg);

			return _jEnc($Vl);

		}

	}


	function GtSisPrcDt($Id){

		global $__cnx;

		if(!isN($Id)){
			$c_DtRg = "-1";if (isset($Id)){$c_DtRg = $Id;}
			$query_DtRg = sprintf('SELECT * FROM '._BdStr(DBM).TB_SIS_PRC.' WHERE id_sisprc = %s', GtSQLVlStr($c_DtRg,'int'));
			$DtRg = $__cnx->_qry($query_DtRg);

			if($DtRg){

				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;

				$Vl['id'] = $row_DtRg['id_sisprc'];
				$Vl['tt'] = ctjTx($row_DtRg['sisprc_nm'],'in');
				$Vl['tp'] = ctjTx($row_DtRg['sisprc_tp'],'in');

			}

			$__cnx->_clsr($DtRg);

		return(_jEnc($Vl));
		}
	}

	function GtUpColTot($_p=NULL){

		global $__cnx;

		if(is_array($_p)){

			if(!isN($_p['id'])){

				$query_DtRg = sprintf("SELECT *, COUNT(*) AS __tot_lds_u
									   FROM ".DBP.".".MDL_UP_COL_BD."
									   WHERE upcol_up = %s
									   GROUP BY upcol_0, upcol_1, upcol_2, upcol_3, upcol_4, upcol_5 HAVING __tot_lds_u > 1", GtSQLVlStr($_p['id'], 'int'));

				$DtRg = $__cnx->_qry($query_DtRg);

				if($DtRg){

					$row_DtRg = $DtRg->fetch_assoc();
					$Tot_DtRg = $DtRg->num_rows;

					$Vl['tot'] = $Tot_DtRg;

					if($Tot_DtRg > 0){
						$Vl['e'] = 'ok';
					}else{
						$Vl['e'] = 'no';
					}

					do{

	                	if($row_DtRg['__tot_lds_u'] > 1){
	                		$__tot_reg =  $__tot_reg+$row_DtRg['__tot_lds_u'];
	                	}

	                } while ($row_DtRg = $DtRg->fetch_assoc());

	                $Vl['tot_all'] = $__tot_reg;

				}

				$__cnx->_clsr($DtRg);

				return _jEnc($Vl);
			}

		}
	}

	/* Encuestas */
	function GtEncDt_Fld($p=NULL){

		global $__cnx;

			$query_LsFld = sprintf("SELECT * FROM ".TB_ENC_FLD.", ".TB_SIS_FLD.", "._BdStr(DBM).TB_SIS_FLD_TP." WHERE encfld_fld = id_fld AND fld_tp = id_fldtp AND encfld_enc = %s ORDER BY encfld_row ASC, encfld_ord ASC", GtSQLVlStr( $p['id'] , 'int'));
			$LsFld = $__cnx->_qry($query_LsFld);

			if($LsFld){

				$row_LsFld = $LsFld->fetch_assoc();
				$Tot_LsFld = $LsFld->num_rows;

				if($Tot_LsFld > 0){
					do{
						$_row=$row_LsFld['encfld_row'];
						$_key=$row_LsFld['fld_key'];
						$Vl_Fld[$_row][$_key] = ['id'=>ctjTx($row_LsFld['id_fld'],'in'),
													'tt'=>ctjTx($row_LsFld['sisfld_tt'],'in'),
													'tt_es'=>ctjTx($row_LsFld['encfld_tt_es'],'in'),
													'tt_en'=>ctjTx($row_LsFld['encfld_tt_en'],'in'),
													'tt_it'=>ctjTx($row_LsFld['encfld_tt_it'],'in'),
													'tt_fr'=>ctjTx($row_LsFld['encfld_tt_fr'],'in'),
													'tt_gr'=>ctjTx($row_LsFld['encfld_tt_gr'],'in'),
													'tt_krn'=>ctjTx($row_LsFld['encfld_tt_krn'],'in'),
													'tt_jpn'=>ctjTx($row_LsFld['encfld_tt_jpn'],'in'),
													'tt_ptg'=>ctjTx($row_LsFld['encfld_tt_ptg'],'in'),
													'tt_mdn'=>ctjTx($row_LsFld['encfld_tt_mdn'],'in'),
													'tp'=>ctjTx($row_LsFld['fldtp_nm'],'in'),
													'key'=>ctjTx($row_LsFld['fld_key'],'in'),
													'rqr'=>ctjTx($row_LsFld['encfld_rqr'],'in'),
													'ord'=>ctjTx($row_LsFld['encfld_ord'],'in'),
													'row'=>ctjTx($row_LsFld['encfld_row'],'in'),
													'max'=>ctjTx($row_LsFld['encfld_max'],'in'),
													'chk_irv'=>ctjTx($row_LsFld['fld_chk_irv'],'in')
											  ];
					} while ($row_LsFld = $LsFld->fetch_assoc());
				}
			}

			$__cnx->_clsr($LsFld);

			$rtrn = _jEnc($Vl_Fld);
			return($rtrn);
			/* Fin Información Formulario 	*/
	}

	function GtEncDt($_p=NULL){

		if(!isN($_p['id'])){

			global $__cnx;

			$__qry_bd = TB_ENC;

			$query_DtRg = sprintf("SELECT * FROM {$__qry_bd} WHERE id_enc != '' AND id_enc = %s LIMIT 1 ", GtSQLVlStr($_p['id'], 'int'));

			$DtRg = $__cnx->_qry($query_DtRg);

			if($DtRg){

				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;

				if($Tot_DtRg > 0){

					$Vl['cod'] = $row_DtRg['id_enc'];
					$Vl['tt'] = $row_DtRg['enc_tt'];
					$Vl['fld'] = GtEncDt_Fld(['id'=>$row_DtRg['id_enc']]);

				}

			}

			$__cnx->_clsr($DtRg);

			return _jEnc($Vl);
		}
	}

		 /* Encuestas */

	function GtFldLstDt($_p=NULL){

		global $__cnx;

		if(!isN($_p['id'])){

			$query_DtRg = sprintf("SELECT * FROM ".TB_SIS_FLD_LST." WHERE id_fldlst != '' AND id_fldlst = %s LIMIT 1 ", GtSQLVlStr($_p['id'], 'int'));
			$DtRg = $__cnx->_qry($query_DtRg);

			if($DtRg){

				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;

				if($Tot_DtRg > 0){

					$Vl['tt'] = $row_DtRg['fldlst_tt'];

				}

			}

			$__cnx->_clsr($DtRg);

			return _jEnc($Vl);
		}
	}

	function GtMdlCntCll($_p=NULL){

		global $__cnx;

		if(is_array($_p)){

			if(!isN($_p['id'])){

				if($_p['tp'] == 'his'){ $__f = 'mdlcntcall_his'; $__ft = 'int'; }else{ $__f = 'id_mdlcntcall'; $__ft = 'int'; }

				$query_DtRg = sprintf("SELECT *
									   FROM ".TB_CALL_MDL_CNT."
									   WHERE ".$__f." = %s", GtSQLVlStr($_p['id'], $__ft));

				$DtRg = $__cnx->_qry($query_DtRg);

				if($DtRg){

					$row_DtRg = $DtRg->fetch_assoc();
					$Tot_DtRg = $DtRg->num_rows;

					if($Tot_DtRg > 0){
						$Vl['e'] = 'ok';
						$Vl['id'] = $row_DtRg['id_mdlcntcall'];

						$__CallIn = new CRM_Call();
						$__CallDt = $__CallIn->ChckCall([ 'id'=>$row_DtRg['mdlcntcall_call']] );

						$Vl['call'] = $__CallDt;

					}else{
						$Vl['e'] = 'no';
					}

				}

				$__cnx->_clsr($DtRg);

			return _jEnc($Vl);
			}
		}
	}

	function GtGrph_Chr($_p=NULL){

		global $__cnx;

		if(!isN($_p['grph'])){

			$Ls_Qry = sprintf("SELECT *
							   FROM "._BdStr(DBM).MDL_GRPH_CHR_RLC_BD."
							   		INNER JOIN "._BdStr(DBM).MDL_GRPH_CHR_BD." ON grphchrrlc_chr = id_grphchr
							   		INNER JOIN "._BdStr(DBM).MDL_SIS_TP_DT_BD." ON grphchr_tp = id_sistpdt
							   WHERE grphchrrlc_grph = %s
							   ORDER BY id_grphchrrlc ASC", GtSQLVlStr($_p['grph'], 'int'));

			$LsTp_Rg = $__cnx->_qry($Ls_Qry);

			if($LsTp_Rg){

				$row_LsTp_Rg = $LsTp_Rg->fetch_assoc();
				$Tot_LsTp_Rg = $LsTp_Rg->num_rows;

				$_r['tot'] = $Tot_LsTp_Rg;

			    if($Tot_LsTp_Rg > 0){

	                do{

						$_v[ $row_LsTp_Rg['id_grphchrrlc'] ] = ['id'=>ctjTx($row_LsTp_Rg['id_grphchrrlc'],'in'),
															    	 'tt'=>ctjTx($row_LsTp_Rg['grphchr_tt'],'in'),
																	 'k'=>$row_LsTp_Rg['grphchr_key'],
																	 'dfl'=>ctjTx($row_LsTp_Rg['grphchr_dfl'],'in'),
																	 'vle'=>$row_LsTp_Rg['grphchrrlc_vl_es'],
																	 'tp'=>$row_LsTp_Rg['sistpdt_sqv']
														  ];

					} while ($row_LsTp_Rg = $LsTp_Rg->fetch_assoc());

				}

	          	$_r['ls'] = $_v;

          	}

		    $__cnx->_clsr($LsTp_Rg);

		    $rtrn = _jEnc($_r);
		    return($rtrn);
		}
	}

	function GtUpFld_Js($p=NULL){

		global $__cnx;

		$Ls_Qry = "SELECT * FROM ".DBP.".".TB_UP_FLD." ORDER BY id_upfld ASC";
		$LsTp_Rg = $__cnx->_qry($Ls_Qry);

		if($LsTp_Rg){

			$row_LsTp_Rg = $LsTp_Rg->fetch_assoc();
			$Tot_LsTp_Rg = $LsTp_Rg->num_rows;

			$_r['tot'] = $Tot_LsTp_Rg;

		    if($Tot_LsTp_Rg > 0){
                do{

					$_v[ $row_LsTp_Rg['upfld_vl'] ] = ['id'=>ctjTx($row_LsTp_Rg['id_upfld'],'in'),
														    'tt'=>ctjTx($row_LsTp_Rg['upfld_tt'],'in'),
														    'vl'=>$row_LsTp_Rg['upfld_vl'],
														    'ext'=>[
														    	'cnt'=>mBln($row_LsTp_Rg['upfld_ext_cnt']),
														    	'mdl_cnt'=>mBln($row_LsTp_Rg['upfld_ext_mdlcnt'])
														    ],
														    'fk'=>$row_LsTp_Rg['upfld_fk'],
														    'dte'=>$row_LsTp_Rg['upfld_dte']
													  ];

				} while ($row_LsTp_Rg = $LsTp_Rg->fetch_assoc());
			}

          	$_r['ls'] = $_v;

	    }

	    $__cnx->_clsr($LsTp_Rg);

	    $rtrn = _jEnc($_r);
	    return($rtrn);
	}

	function GtMdlDt_Crt($p=NULL){

		global $__cnx;

		if(!isN($p['ec'])){ $_f .= ' AND mdleccrt_ec = '.GtSQLVlStr($p['ec'], 'int'); }
		if(!isN($p['bd'])){ $__bdprfx=_BdStr($p['bd']); }

		$query_LsFld = sprintf("SELECT *,
										"._QrySisSlcF([ 'als'=>'tp', 'als_n'=>'tipo' ]).",
										".GtSlc_QryExtra(['t'=>'fld', 'p'=>'tp', 'als'=>'tp'])."
								FROM ".$__bdprfx.TB_MDL_EC_CRT."
									 ".GtSlc_QryExtra(['t'=>'tb', 'col'=>'mdleccrt_eccrt', 'als'=>'tp'])."
								WHERE mdleccrt_mdl = %s {$_f}", GtSQLVlStr( $p['id'] , 'int'));

		$LsFld = $__cnx->_qry($query_LsFld);

		if($LsFld){

			$row_LsFld = $LsFld->fetch_assoc();
			$Tot_LsFld = $LsFld->num_rows;

			if($Tot_LsFld > 0){

				do{

					$__attr = json_decode($row_LsFld['___tipo']);

					foreach($__attr as $__attr_k=>$__attr_v){
						$__tipo_go->{$__attr_v->key} = $__attr_v;
					}

					$Vl_Fld[$row_LsFld['id_mdleccrt']] = [ 'id'=>ctjTx($row_LsFld['id_mdleccrt'],'in'),
															'tt'=>ctjTx($row_LsFld['tp_sisslc_tt'],'in'),
															'key'=>$__tipo_go->key->vl,
															'keyc'=>!isN($__tipo_go->keyc)?$__tipo_go->keyc->vl:'',
															'keyd'=>ctjTx($row_LsFld['mdleccrt_keyd'],'in'),
															'tp'=>$__tipo_go->tp->vl,
															'vl'=>ctjTx($row_LsFld['mdleccrt_vl_es'],'in','',['html'=>'ok','schr'=>'no','nl2'=>'no']),
															'tag'=>ctjTx($row_LsFld['mdleccrt_tag_es'],'in')
														];


				} while ($row_LsFld = $LsFld->fetch_assoc());

			}

		}

		$__cnx->_clsr($LsFld);

		return _jEnc($Vl_Fld);

	}

	function GtMdlDt_Fle($p=NULL){

		global $__cnx;

		if(!isN($p['ec'])){ $_f .= ' AND mdlecfle_ec = '.GtSQLVlStr($p['ec'], 'int'); }
		if(!isN($p['bd'])){ $__bdprfx=_BdStr($p['bd']); }

		$query_LsFld = sprintf("SELECT *
								FROM ".$__bdprfx.TB_MDL_EC_FLE."
									 INNER JOIN "._BdStr(DBM).TB_FLE." ON mdlecfle_fle = id_fle
								WHERE mdlecfle_mdl = %s {$_f}", GtSQLVlStr( $p['id'] , 'int'));

		$LsFld = $__cnx->_qry($query_LsFld);

		if($LsFld){

			$row_LsFld = $LsFld->fetch_assoc();
			$Tot_LsFld = $LsFld->num_rows;

			if($Tot_LsFld > 0){

				do{

					$Vl_Fld[$row_LsFld['id_mdlecfle']] = [
															'id'=>ctjTx($row_LsFld['id_mdlecfle'],'in'),
															'enc'=>ctjTx($row_LsFld['mdlecfle_enc'],'in'),
															'fle'=>ctjTx($row_LsFld['fle_fle'],'in'),
															'dir'=>DIR_TMP_FLE_FLE.ctjTx($row_LsFld['fle_fle'],'in'),
															'nm'=>ctjTx($row_LsFld['fle_nm'],'in')
														];

				} while ($row_LsFld = $LsFld->fetch_assoc());

			}

		}

		$__cnx->_clsr($LsFld);

		return _jEnc($Vl_Fld);

	}

	function GtMdlLs($_p=NULL){

		global $__cnx;

		if(!isN($_p["tp"]) && !isN($_p["tp"])){ $_fl .= "AND mdl_mdls = ".GtSQLVlStr($_p['tp'], 'int')." "; }

		if(!ChckSESS_superadm() && defined('SISUS_ARE') && !isN(SISUS_ARE)){
			$_fl .= " AND id_mdl IN ( SELECT mdlare_mdl FROM ".TB_MDL_ARE." WHERE mdlare_are IN (".SISUS_ARE.") ) ";
		}

		$query_DtRg = "	SELECT *
						FROM ".TB_MDL."
						WHERE id_mdl != ''
							  AND mdl_est != '"._CId('ID_SISMDLEST_ELI')."' $_fl";

		$DtRg = $__cnx->_qry($query_DtRg);

		if($DtRg){

			$row_DtRg = $DtRg->fetch_assoc();
			$Tot_DtRg = $DtRg->num_rows;

			if($Tot_DtRg > 0){

				$Vl['e'] = 'ok';
				$Vl['tot'] = $Tot_DtRg;

				do{

					if(!isN($row_DtRg['id_mdl'])){
						$Vl[ $row_DtRg['id_mdl'] ]['id'] = ctjTx($row_DtRg['id_mdl'], 'in');
						$Vl[ $row_DtRg['id_mdl'] ]['enc'] = ctjTx($row_DtRg['mdl_enc'], 'in');
						$Vl[ $row_DtRg['id_mdl'] ]['nm'] = ctjTx($row_DtRg['mdl_nm'], 'in');
						$Vl[ $row_DtRg['id_mdl'] ]['tp'] = ctjTx($row_DtRg['mdl_mdls'], 'in');
						$Vl[ $row_DtRg['id_mdl'] ]['pml'] = ctjTx($row_DtRg['mdl_pml'], 'in');
					}

				}while($row_DtRg = $DtRg->fetch_assoc());

			}else{
				$Vl['e'] = 'no';
				$Vl['w'] = TX_NXTMDL;
			}

		}

		$__cnx->_clsr($DtRg);

		return(_jEnc($Vl));
	}

	function GtLngLs($_p=NULL){

		global $__cnx;

		if( !isN($_p['id']) ){
			$_fl = " AND id_sislng = ".$_p['id']."  ";
		}

		$query_DtRg = "	SELECT id_sislng, sislng_enc, sislng_nm, sislng_cod, sislng_cod_aws, sislng_flg, sislng_iso_6391
						FROM "._BdStr(DBM).TB_SIS_LNG."
						WHERE id_sislng != '' $_fl";

		$DtRg = $__cnx->_qry($query_DtRg);

		if($DtRg){

			$row_DtRg = $DtRg->fetch_assoc();
			$Tot_DtRg = $DtRg->num_rows;

			if($Tot_DtRg > 0){

				$Vl['e'] = 'ok';
				$Vl['tot'] = $Tot_DtRg;

				$Vl['tt'] = ctjTx($row_DtRg['sislng_nm'], 'in'); //Titulo para detalle

				do{

					$Vl['ls'][ $row_DtRg['id_sislng'] ]['id'] = ctjTx($row_DtRg['id_sislng'], 'in');
					$Vl['ls'][ $row_DtRg['id_sislng'] ]['enc'] = ctjTx($row_DtRg['sislng_enc'], 'in');
					$Vl['ls'][ $row_DtRg['id_sislng'] ]['nm'] = ctjTx($row_DtRg['sislng_nm'], 'in');
					$Vl['ls'][ $row_DtRg['id_sislng'] ]['cod'] = ctjTx($row_DtRg['sislng_cod'], 'in');
					$Vl['ls'][ $row_DtRg['id_sislng'] ]['cod_aws'] = ctjTx($row_DtRg['sislng_cod_aws'], 'in');

					$Vl['ls'][ $row_DtRg['id_sislng'] ]['iso']['6391'] = ctjTx($row_DtRg['sislng_iso_6391'], 'in');

					if($row_DtRg['sislng_cod'] == 'es' && !isN( CRM_SES::GtSess('ctry') ) ){
						$__flg = str_replace('.', '_'.CRM_SES::GtSess('ctry').'.', $row_DtRg['sislng_flg']);
					}elseif(!isN($row_DtRg['sislng_flg'])){
						$__flg = $row_DtRg['sislng_flg'];
					}else{
						$__flg = 'es.svg';
					}

					if(!isN($__flg)){
						$Vl['ls'][ $row_DtRg['id_sislng'] ]['flg'] = DMN_FLE_LNG.$__flg;
					}

				}while($row_DtRg = $DtRg->fetch_assoc());

			}else{
				$Vl['e'] = 'no';
				$Vl['w'] = TX_NXTMDL;
			}

		}

		$__cnx->_clsr($DtRg);

		return(_jEnc($Vl));
	}

	function GtMdlTpLs($_p=NULL){

		global $__cnx;

		if(!isN($_p["tp"]) && !isN($_p["tp"])){ $_fl = "AND mdls_tp = ".GtSQLVlStr($_p['tp'], 'int')." "; }

		$query_DtRg = "SELECT *  FROM "._BdStr(DBM).TB_MDL_S." WHERE id_mdls != '' $_fl ";
		$DtRg = $__cnx->_qry($query_DtRg);

		if($DtRg){

			$row_DtRg = $DtRg->fetch_assoc();
			$Tot_DtRg = $DtRg->num_rows;

			if($Tot_DtRg > 0){

				$Vl['e'] = 'ok';
				$Vl['tot'] = $Tot_DtRg;

				do{

					if(!isN($row_DtRg['id_mdls']) && !isN($row_DtRg['id_mdls'])){
						$Vl[ $row_DtRg['id_mdls'] ]['id'] = ctjTx($row_DtRg['id_mdls'], 'in');
						$Vl[ $row_DtRg['id_mdls'] ]['nm'] = ctjTx($row_DtRg['mdls_nm'], 'in');
						$Vl[ $row_DtRg['id_mdls'] ]['tp'] = ctjTx($row_DtRg['mdls_tp'], 'in');
					}

				}while($row_DtRg = $DtRg->fetch_assoc());

			}else{
				$Vl['e'] = 'no';
				$Vl['w'] = TX_NTEXT;
			}

		}

		$__cnx->_clsr($DtRg);

		return(_jEnc($Vl));

	}


	function GtMdlDt($_p=NULL){

		global $__cnx;

		$Vl['e'] = 'no';

		if(is_array($_p) && !isN($_p['id'])){

			if($_p['t'] == 'enc'){
				$__f = 'mdl_enc'; $__ft = 'text';
			}elseif($_p['t'] == 'pml'){
				$__f = 'mdl_pml'; $__ft = 'text';
			}else{
				$__f = 'id_mdl'; $__ft = 'int';
			}

			$c_DtRg = "-1";if(!isN($_p['id'])){ $c_DtRg = $_p['id']; }

			if(!isN($_p['bd'])){
				$__bdprfx=_BdStr($_p['bd']);
			}elseif(defined('DB_CL') && !isN(DB_CL)){
				$__bdprfx=_BdStr(DB_CL);
			}

			$__qry_bd = $__bdprfx.TB_MDL_CNT;
			$__qry_bd2 = $__bdprfx.TB_MDL;
			$__qry_bd3 = $__bdprfx.TB_MDL_S_TP;
			$__qry_bd4 = $__bdprfx.TB_MDL_SCH;
			$__qry_bd5 = $__bdprfx.TB_MDL_PRD;

			if(!isN($_p['m'])){ $_fl .= " AND mdlcnt_m = ".$_p['m']." "; }
			if(!isN($_p['_f1']) && !isN($_p['_f2'])){ $_fl .= " AND mdlcnt_fi BETWEEN '".$_p['_f1']."' AND '".$_p['_f2']."' "; }
			if(!isN($_p['tp'])){ $__flm .= " AND mdls_tp = ".$_p['tp']." "; }

			/*$Mdl_Are = " ( SELECT GROUP_CONCAT( mdlare_are SEPARATOR ',' )
							FROM ".TB_MDL_ARE."
							WHERE mdlare_mdl = id_mdl ) AS _are ";*/

			if(!isN($_p['tot']['cnt'])){

				$Tot_Cnt = ", (	SELECT COUNT(*)
								FROM {$__qry_bd}
									 INNER JOIN {$__qry_bd2} ON mdlcnt_mdl = id_mdl
								WHERE ISNULL(mdlcnt_gen) ".$_fl." LIMIT 1) AS __cnttot ";

			}

			if(!isN($_p['tot']['sch'])){

				$Tot_Sch = ", (	SELECT COUNT(*)
								FROM {$__qry_bd4}
								WHERE mdlsch_mdl = id_mdl LIMIT 1) AS __schtot ";

			}

			$Tot_Prd = ", (	SELECT id_mdlsprd
							FROM "._BdStr(DBM).TB_MDL_S_PRD."
							INNER JOIN {$__qry_bd5} ON id_mdlsprd = mdlprd_prd
							WHERE mdlprd_mdl = id_mdl AND mdlprd_est = 1 ORDER BY id_mdlprd DESC LIMIT 1) AS __prd ";



			$query_DtRg = sprintf("
									SELECT * {$Tot_Cnt} {$Tot_Sch} {$Tot_Prd}
									FROM {$__qry_bd2}
								   	     INNER JOIN "._BdStr(DBM).TB_MDL_S." ON mdl_mdls = id_mdls
										 INNER JOIN "._BdStr(DBM).TB_MDL_S_TP." ON mdls_tp = id_mdlstp
									WHERE {$__f} = %s {$__flm}
									LIMIT 1

								", GtSQLVlStr($c_DtRg, $__ft));

			$__cnx->src_main = $_p['src_main'];

			$DtRg = $__cnx->_qry($query_DtRg);

			if($DtRg){

				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;

				if($Tot_DtRg > 0){

					$Vl['e'] = 'ok';

					$Vl['id'] = $row_DtRg['id_mdl'];
					$Vl['enc'] = ctjTx($row_DtRg['mdl_enc'],'in');
					$Vl['tt'] = ctjTx($row_DtRg['mdl_nm'],'in');
					$Vl['pml'] = ctjTx($row_DtRg['mdl_pml'],'in');

					$Vl['tp']['id'] = $row_DtRg['id_mdlstp'];
					$Vl['tp']['nm'] = ctjTx($row_DtRg['mdlstp_nm'],'in');
					$Vl['tp']['unq'] = mBln($row_DtRg['mdlstp_unq']);
					$Vl['tp']['tp'] = $row_DtRg['mdlstp_tp'];

					$Vl['est'] = ctjTx($row_DtRg['mdl_est'],'in');

					//$Vl['mdl_mdlstp'] = $row_DtRg['mdl_mdlstp'];

					$Vl['tot']['ctrl'] = ctjTx($row_DtRg['mdl_tot_ctrl'],'in');

					if(!isN($row_DtRg['__cnttot'])){
						$Vl['tot']['cnt'] = ctjTx($row_DtRg['__cnttot'],'in');
					}

					if(!isN($row_DtRg['__schtot'])){
						$Vl['tot']['sch'] = ctjTx($row_DtRg['__schtot'],'in');
					}

					if(!isN($_p['sbd'])){ $sbd=$_p['sbd']; }else{ $sbd=Gt_SbDMN(); }

					if($_p['fm']=='ok'){
						$__Forms = new CRM_Forms([ 'bd'=>$_p['bd'] ]);
						$__Forms->cnscnv = $_p['cnscnv'];
						$__Forms->mdlfm_mdl = $row_DtRg['id_mdl'];
						$__Forms->mdlfm_lst = 'ok';
						$Vl['tp']['fm']= $__Forms->_mdlfm_dt([ 'fldt'=>'ok' ]);
					}

					$Vl['url']['fm'] = DMN_FORM.''.PrmLnk('bld', $sbd).PrmLnk('bld', ctjTx($row_DtRg['mdl_enc'],'in'));
					$Vl['url']['lnd'] = DMN_LND.''.PrmLnk('bld', $sbd).PrmLnk('bld', ctjTx($row_DtRg['mdl_pml'],'in'));

					$Vl['cl']['sbdm'] = $sbd;

					if($_p['lnd']=='ok'){
						$Vl['lnd'] = GtLndDt([ 'id'=>$row_DtRg['mdl_lnd'] ]);
					}

					$Vl['pxl'] = GtPxlLs([ 'bd'=>$_p['bd'],'t'=>'mdl', 'id'=>$row_DtRg['id_mdl'] ]);
					$Vl['img'] = _ImVrs([ 'img'=>ctjTx($row_DtRg['mdl_img'],'in'), 'f'=>DMN_FLE_MDL ]);
					$Vl['dt_act'] = GtMdlAttrDt([ 'bd'=>$_p['bd'], 'id'=>$row_DtRg['id_mdl'] ]);

					if( !isN($_p['t2']) && $_p['t2'] == 'act' ){

						$__fch_main = $Vl['dt_act'];

						if(!isN( $__fch_main->{_CId('ID_MDLSTPATTR_HINI')}->vl )){
							$__h_i = new DateTime ($__fch_main->{_CId('ID_MDLSTPATTR_HINI')}->vl);
							$__h = $__h_i->format('h:i a');
							$__h_full = $__h_i->format('h:i:s');
						}else{
							$__h = $__dte_f->format('h:i a');
							$__h_full = $__dte_f->format('H:i:s');
						}

						$Vl['act']['f'] = $__fch_main->{_CId('ID_MDLSTPATTR_FINI')}->vl;
						$Vl['act']['h'] = $__h;

					}

					$Vl['prd']['id'] = ctjTx($row_DtRg['__prd'],'in');


					if($_p['ec_crt'] == 'ok'){
		            	$Vl['ec_crt'] = GtMdlDt_Crt([ 'bd'=>$_p['bd'], 'id'=>$row_DtRg['id_mdl'], 'ec'=>$_p['ec_crt_id'] ]);
	                }

	                if($_p['ec_fle'] == 'ok'){
						$Vl['ec_fle'] = GtMdlDt_Fle([ 'bd'=>$_p['bd'], 'id'=>$row_DtRg['id_mdl'], 'ec'=>$_p['ec_crt_id'] ]);
	                }

					$Vl['are'] = GtMdlAreLs([ 'mdl'=>$row_DtRg['id_mdl'], 'bd'=>$_p['bd'] ]);

					$__attr = GtAttrLs([ 't'=>'mdl', 'i'=>$row_DtRg['id_mdl'], 'bd'=>$_p['bd'] ]);

					$Vl['tmp_attr'] = $__attr;
					$Vl['attr'] = $__attr->a;
					$Vl['attr_o'] = $__attr->o;

				}else{

					$Vl['e'] = 'no';

				}

			}else{

				$Vl['w']['m'] = $__cnx->c_r->error;

			}

			$__cnx->_clsr($DtRg);

		}else{

			$Vl['w']['m'] = 'No data';

		}

		return(_jEnc($Vl));

	}



	function GtMdlGenMdlLs($p=NULL){

		global $__cnx;

		if( (
				!isN($p['gen']) || !isN($p['tp'])
			) ||
			(
				!isN($p['all']) && !isN($p['tp'])
			)
		){

			if(!isN($p['bd'])){ $bd = _BdStr($p['bd']); }
			if(!isN($p['gen'])){
				$fld_f .= 'mdlgenmdl_gen'; $fld_id=$p['gen'];
				$innr_f .= "INNER JOIN ".$bd.TB_MDL_GEN_MDL." ON mdlgenmdl_mdl = id_mdl";
			}

			if(!isN($p['tp'])){ $fld_f .= 'id_mdlstp'; $fld_id=$p['tp']; }

			$query_DtRg = sprintf("	SELECT mdl_enc, mdl_nm
									FROM ".$bd.TB_MDL."
										 {$innr_f}
							 			 INNER JOIN "._BdStr(DBM).TB_MDL_S." ON mdl_mdls = id_mdls
										 INNER JOIN "._BdStr(DBM).TB_MDL_S_TP." ON mdls_tp = id_mdlstp
										 {$__innr}
									WHERE {$fld_f}=%s", GtSQLVlStr($fld_id,'int') );

			$DtRg = $__cnx->_qry($query_DtRg);

			if($DtRg){

				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;

				if($Tot_DtRg > 0){

					$Vl['e'] = 'ok';
					$Vl['tot'] = $Tot_DtRg;

					do{

						$_id_mdl = $row_DtRg['mdl_enc'];

						$Vl['ls'][ $_id_mdl ] = [
							'id'=>$_id_mdl,
							'tt'=>ctjTx($row_DtRg['mdl_nm'], 'in')
						];

					}while($row_DtRg = $DtRg->fetch_assoc());

				}else{

					$Vl['e'] = 'no';
					$Vl['w'] = TX_NXTMDL;

					if(Dvlpr()){
						$Vl['q'] = compress_code($query_DtRg);
					}

				}

			}else{

				$Vl['w'] = $__cnx->c_r->error.' on '.compress_code($query_DtRg);

			}

		}else{

			$Vl['w'][] = 'No data';
			if(isN($p['gen'])){ $Vl['w'][] = 'No gen parameter'; }
			if(isN($p['tp'])){ $Vl['w'][] = 'No tp parameter'; }

		}

		$__cnx->_clsr($DtRg);
		return(_jEnc($Vl));

	}



	function GtMdlGenRelLs($p=NULL){

		global $__cnx;

		if(
			!isN($p['gen']) || !isN($p['tp'])
		){

			if(!isN($p['bd'])){ $bd = _BdStr($p['bd']); }
			if(!isN($p['gen'])){
				$fld_f .= 'mdlgenrel_mdlgen'; $fld_id=$p['gen'];
				$innr_f .= "INNER JOIN ".$bd.TB_MDL_GEN_REL." ON mdlgenrel_mdl = id_mdl";
			}

			$query_DtRg = sprintf("	SELECT mdl_enc, mdl_nm
									FROM ".$bd.TB_MDL."
										 {$innr_f}
									WHERE {$fld_f}=%s", GtSQLVlStr($fld_id,'int') );

			$DtRg = $__cnx->_qry($query_DtRg);

			if($DtRg){

				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;

				if($Tot_DtRg > 0){

					$Vl['e'] = 'ok';
					$Vl['tot'] = $Tot_DtRg;

					do{

						$_id_mdl = $row_DtRg['mdl_enc'];

						$Vl['ls'][ $_id_mdl ] = [
							'id'=>$_id_mdl,
							'tt'=>ctjTx($row_DtRg['mdl_nm'], 'in')
						];

					}while($row_DtRg = $DtRg->fetch_assoc());

				}else{

					$Vl['e'] = 'no';
					$Vl['w'] = TX_NXTMDL;

					if(Dvlpr()){
						$Vl['q'] = compress_code($query_DtRg);
					}

				}

			}else{

				$Vl['w'] = $__cnx->c_r->error.' on '.compress_code($query_DtRg);

			}

		}else{

			$Vl['w'][] = 'No data';
			if(isN($p['gen'])){ $Vl['w'][] = 'No gen parameter'; }
			if(isN($p['tp'])){ $Vl['w'][] = 'No tp parameter'; }

		}

		$__cnx->_clsr($DtRg);
		return(_jEnc($Vl));

	}


	function GtMdlMdlLs($p=NULL){

		global $__cnx;

		if(!isN($p['tp']) || !isN($p['mdlm'])){

			if(!isN($p['bd'])){ $bd = _BdStr($p['bd']); }
			if(!isN($p['tp'])){ $fld_f .= sprintf(' AND id_mdlstpn=%s', GtSQLVlStr($p['mdlm'], "int")); }
			if(!isN($p['mdlm'])){ $fld_f .= sprintf(' AND mdlmdl_main=%s', GtSQLVlStr($p['mdlm'], "int")); }

			$query_DtRg = sprintf("	SELECT mdl_enc, mdl_nm
									FROM ".$bd.TB_MDL_MDL."
										 INNER JOIN ".$bd.TB_MDL." ON mdlmdl_mdl = id_mdl
							 			 INNER JOIN "._BdStr(DBM).TB_MDL_S." ON mdl_mdls = id_mdls
										 INNER JOIN "._BdStr(DBM).TB_MDL_S_TP." ON mdls_tp = id_mdlstp
										 {$__innr}
									WHERE mdl_enc IS NOT NULL {$fld_f}" );

			$DtRg = $__cnx->_qry($query_DtRg);

			if($DtRg){

				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;

				if($Tot_DtRg > 0){

					$Vl['e'] = 'ok';
					$Vl['tot'] = $Tot_DtRg;

					do{

						$_id_mdl = $row_DtRg['mdl_enc'];

						$Vl['ls'][ $_id_mdl ] = [
							'id'=>$_id_mdl,
							'tt'=>ctjTx($row_DtRg['mdl_nm'], 'in')
						];

					}while($row_DtRg = $DtRg->fetch_assoc());

				}else{

					$Vl['e'] = 'no';
					$Vl['w'] = TX_NXTMDL;

					if(Dvlpr()){
						$Vl['q'] = compress_code($query_DtRg);
					}

				}

			}else{

				$Vl['w'] = $__cnx->c_r->error;

			}

		}else{

			$Vl['w'][] = 'No data';
			if(isN($p['tp'])){ $Vl['w'][] = 'No tp parameter'; }
			if(isN($p['mdlm'])){ $Vl['w'][] = 'No mdlm parameter'; }

		}

		$__cnx->_clsr($DtRg);
		return(_jEnc($Vl));

	}


	function GtMdlGenDt($_p=NULL){

		global $__cnx;

		if(is_array($_p) && !isN($_p['id'])){

			if(!isN($_p['bd'])){ $__bdprfx=_BdStr($_p['bd']); }

			if($_p['t'] == 'pm'){
				$__f = 'mdlgen_pml'; $__ft = 'text';
			}elseif($_p['t'] == 'enc'){
				$__f = 'mdlgen_enc'; $__ft = 'text';
			}else{
				$__f = 'id_mdlgen'; $__ft = 'int';
			}


			if(!isN($_p['m'])){ $_fl .= " AND mdlcnt_m = ".$_p['m']." "; }
			if(!isN($_p['_f1']) && !isN($_p['_f2'])){
				$_fl .= " AND mdlcnt_fi BETWEEN '".$_p['_f1']."' AND '".$_p['_f2']."' ";
			}

			if($_p['tot']['cnt'] == 'ok'){

				$Tot_Cnt = sprintf(", (	SELECT COUNT(*)
										FROM {$__bdprfx}".TB_MDL_CNT."
											INNER JOIN {$__bdprfx}".TB_MDL_GEN." ON mdlcnt_gen = id_mdlgen
										WHERE id_mdlcnt != '' AND {$__f} = %s {$_fl} LIMIT 1
									) AS __cnttot", GtSQLVlStr($_p['id'], $__ft));

			}

			$query_DtRg = sprintf('	SELECT 	id_mdlgen, mdlgen_tt, mdlgen_enc, mdlgen_all, mdlgen_s_ph, mdlgen_pml, mdlgen_lnd, mdlgen_fi, mdlgen_fa,
											id_mdlstp, mdlstp_nm, mdlstp_tp, mdlstp_tp
											'.$Tot_Cnt.'
									FROM '.$__bdprfx.TB_MDL_GEN.'
										 INNER JOIN '._BdStr(DBM).TB_MDL_S_TP.' ON mdlgen_tp = id_mdlstp
									WHERE id_mdlgen != "" AND '.$__f.' = %s
									LIMIT 1', GtSQLVlStr($_p['id'], $__ft));

			$DtRg = $__cnx->_qry($query_DtRg);

			//$Vl['q'] = compress_code($query_DtRg);

			if($DtRg){

				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;

				if($Tot_DtRg > 0){

					$Vl['id'] = $row_DtRg['id_mdlgen'];
					$Vl['tt'] = ctjTx($row_DtRg['mdlgen_tt'],'in');
					$Vl['enc'] = ctjTx($row_DtRg['mdlgen_enc'],'in');
					$Vl['all'] = mBln($row_DtRg['mdlgen_all']);

					$Vl['fi'] = $row_DtRg['mdlgen_fi'];
					$Vl['fa'] = $row_DtRg['mdlgen_fa'];

					$Vl['tp']['id'] = $row_DtRg['id_mdlstp'];
					$Vl['tp']['nm'] = ctjTx($row_DtRg['mdlstp_nm'],'in');
					$Vl['tp']['key'] = ctjTx($row_DtRg['mdlstp_tp'],'in');
					$Vl['tp']['key_upper'] = strtoupper( ctjTx($row_DtRg['mdlstp_tp'],'in') );

					$Vl['s']['ph'] = ctjTx($row_DtRg['mdlgen_s_ph'],'in');

					if($Vl['tp']['key'] == 'act'){
						$Vl['tp']['act'] = GtMdlGenTpDt([ 'id'=>$row_DtRg['id_mdlgen'] ]);
					}

					if(!isN($_p['sbd'])){$sbd=$_p['sbd'];}else{$sbd=Gt_SbDMN();}

					$Vl['url']['fm'] = DMN_FORM.''.PrmLnk('bld', $sbd).PrmLnk('bld','g').PrmLnk('bld', ctjTx($row_DtRg['mdlgen_enc'],'in'));
					$Vl['url']['lnd'] = DMN_LND.''.PrmLnk('bld', $sbd).PrmLnk('bld','g').PrmLnk('bld', ctjTx($row_DtRg['mdlgen_pml'],'in'));

					$Vl['cl']['sbdm'] = $sbd;

					if($_p['lnd']=='ok'){
						$Vl['lnd'] = GtLndDt([ 'id'=>$row_DtRg['mdlgen_lnd'] ]);
					}

					if($_p['d']['pxl'] == 'ok'){
						$Vl['pxl'] = GtPxlLs([ 'bd'=>$_p['bd'], 't'=>'mdl_gen', 'id'=>$row_DtRg['id_mdlgen'] ]);
					}

					if($_p['fm']=='ok'){

						$__Forms = new CRM_Forms([ 'bd'=>$_p['bd'] ]);
						$__Forms->cnscnv = $_p['cnscnv'];
						$__Forms->mdlfmgen_mdlgen = $row_DtRg['id_mdlgen'];
						$__Forms->mdlfmgen_lst = 'ok';

						$Vl['tp']['fm'] = $__fm_dt = $__Forms->_mdlfm_dt([ 'fldt'=>'ok' ]);

					}

					if($_p['shw_mdl']=='ok'){

						if($__fm_dt->shw->mdl_all == 'ok' || $Vl['all'] == 'ok'){
							$__tp = $row_DtRg['id_mdlstp'];
						}else{
							$__gen = $row_DtRg['id_mdlgen'];
						}

						$_ls_mdl = GtMdlGenMdlLs([ 'bd'=>$_p['bd'], 'gen'=>$__gen, 'tp'=>$__tp, 'all'=>mBln($row_DtRg['mdlgen_all']) ]);

						if($_ls_mdl->tot > 0){
							$Vl['mdl']['tot'] = $_ls_mdl->tot;
							$Vl['mdl']['ls'] = $_ls_mdl->ls;
						}/*elseif(Dvlpr()){
							$Vl['mdl']['debug'] = $_ls_mdl;
						}*/
						else{
							$Vl['mdl']['debug'] = $_ls_mdl;
						}

					}

				}

			}else{

				$Vl['w'] = $__cnx->c_r->error;

			}

			$__cnx->_clsr($DtRg);

		}else{

			$Vl['w'][] = 'No id data';

		}

		return( _jEnc($Vl) );

	}

	function GtMdlGenTpDt($_p=NULL){

		global $__cnx;

		if(is_array($_p) && !isN($_p['id'])){

			$query_DtRg = sprintf('	SELECT *
									FROM '.TB_MDL_GEN_TP.'
									INNER JOIN '._BdStr(DBM).TB_MDL_S_TP.' ON mdlgentp_mdlstp = id_mdlstp
									WHERE id_mdlgentp != "" AND mdlgentp_mdlgen = %s', GtSQLVlStr($_p['id'], 'int'));
			$DtRg = $__cnx->_qry($query_DtRg);

			if($DtRg){

				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;

				if($Tot_DtRg > 0){

					$Vl['ls']['id'] = 'ok';

					do{

						$Vl['ls']['ids'][] = ctjTx($row_DtRg['mdlgentp_mdlstp'],'in');

						$Vl['ls'][$row_DtRg['mdlstp_enc']]['id'] = $row_DtRg['id_mdlstp'];
						$Vl['ls'][$row_DtRg['mdlstp_enc']]['mdl_gen'] = ctjTx($row_DtRg['id_mdlgentp'],'in');
						$Vl['ls'][$row_DtRg['mdlstp_enc']]['mdl_s_tp'] = ctjTx($row_DtRg['mdlgentp_mdlstp'],'in');

					}while($row_DtRg = $DtRg->fetch_assoc());
				}

			}else{
				$Vl['e'] = 'no';
				$Vl['w'] = TX_NXTMDL;
			}

		}

		$__cnx->_clsr($DtRg);

		return( _jEnc($Vl) );

	}


	//Valida el vinculo del cnt con el vinculo del mdlgen
	function GtChkMdlGenCntTpV($p=null){

		global $__cnx;

		if(!isN($p['bd'])){ $__bdprfx=_BdStr($p['bd']); }

		$query_DtRg = sprintf(" SELECT * FROM "._BdStr(DBM).TB_SIS_CNT_TP."
								WHERE id_siscnttp IN( SELECT cnttp_tp FROM {$__bdprfx}".TB_CNT_TP." WHERE cnttp_cnt = %s )
								AND id_siscnttp IN (
														SELECT mdlstpfmcnttp_siscnttp
														FROM "._BdStr(DBM).TB_MDL_S_TP_FM_CNT_TP."
														WHERE mdlstpfmcnttp_mdlstpfm  IN (
																						SELECT mdlfmgen_mdlstpfm
																						FROM {$__bdprfx}".TB_MDL_GEN_FM."
																						WHERE mdlfmgen_mdlgen = %s
																					)
													)
							",
								GtSQLVlStr($p['cnt'], "int"),
								GtSQLVlStr($p['mdl'], "int")
							);

		$DtRg = $__cnx->_qry($query_DtRg);

		if($DtRg){

			$row_DtRg = $DtRg->fetch_assoc();
			$Tot_DtRg = $DtRg->num_rows;

			$Vl['tt'] = ctjTx($row_DtRg['_tp_v_all'], 'in');

			if($Tot_DtRg > 0){
				$Vl['e'] = 'ok';
			}else{
				$Vl['e'] = 'no';
			}

		}else{
			$Vl['e'] = 'no';
		}

		$__cnx->_clsr($DtRg);

		return( _jEnc($Vl) );

	}

	//Valida el vinculo del cnt con el vinculo del mdl
	function GtChkMdlCntTpV($p=null){

		global $__cnx;

		if(!isN($p['bd'])){ $__bdprfx=_BdStr($p['bd']); }

		$query_DtRg = sprintf(" SELECT * FROM "._BdStr(DBM).TB_SIS_CNT_TP."
								WHERE id_siscnttp IN( SELECT cnttp_tp FROM {$__bdprfx}".TB_CNT_TP." WHERE cnttp_cnt = %s )
								AND id_siscnttp IN (
														SELECT mdlstpfmcnttp_siscnttp
														FROM "._BdStr(DBM).TB_MDL_S_TP_FM_CNT_TP."
														WHERE mdlstpfmcnttp_mdlstpfm  IN (
																						SELECT mdlfm_mdlstpfm
																						FROM {$__bdprfx}".TB_MDL_FM."
																						WHERE mdlfm_mdl = %s
																					)
													)
							",
								GtSQLVlStr($p['cnt'], "int"),
								GtSQLVlStr($p['mdl'], "int")
							);

		$DtRg = $__cnx->_qry($query_DtRg);

				if($DtRg){

			$row_DtRg = $DtRg->fetch_assoc();
			$Tot_DtRg = $DtRg->num_rows;

			$Vl['tt'] = ctjTx($row_DtRg['_tp_v_all'], 'in');

			if($Tot_DtRg > 0){
				$Vl['e'] = 'ok';
			}else{
				$Vl['e'] = 'no';
			}

		}else{
			$Vl['e'] = 'no';
		}

		$__cnx->_clsr($DtRg);

		return( _jEnc($Vl) );

	}

	function GtApplRowFldDt($p=NULL){

		global $__cnx;

		$Vl['e'] = 'no';

		if(!isN($p['id'])){

			if($p['t'] == 'enc'){
				$__f = 'applfmrowfld_enc'; $__ft = 'text';
			}else{
				$__f = 'id_applfmrowfld'; $__ft = 'int';
			}

			$c_DtRg = "-1";if (isset($p['id'])){$c_DtRg = $p['id'];}
			$query_DtRg = sprintf('SELECT * FROM '._BdStr(DBM).TB_APPL_FM_ROW_FLD.' WHERE '.$__f.' = %s', GtSQLVlStr($c_DtRg, $__ft));

			$DtRg = $__cnx->_qry($query_DtRg);

			if($DtRg){

				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;

				if($Tot_DtRg > 0){
					$Vl['e'] = 'ok';
					$Vl['id'] = $row_DtRg['id_applfmrowfld'];
					$Vl['enc'] = $row_DtRg['applfmrowfld_enc'];
					$Vl['tt'] = $row_DtRg['applfmrowfld_tt'];
					$Vl['rqd'] = ctjTx($row_DtRg['applfmrowfld_rqd'],'in');
					$Vl['flt_tp'] = ctjTx($row_DtRg['applfmrowfld_flttp'],'in');
					$Vl['flt_exc'] = ctjTx($row_DtRg['applfmrowfld_fltexc'],'in');
					$Vl['flt_val'] = ctjTx($row_DtRg['applfmrowfld_vladc'],'in');
				}
			}

		}

		$__cnx->_clsr($DtRg);

		return( _jEnc($Vl) );

	}

	function GtMdlSTpFmDt($p=NULL){

		global $__cnx;

		$Vl['e'] = 'no';

		if(!isN($p['id'])){

			if($p['t'] == 'enc'){
				$__f = 'mdlstpfm_enc'; $__ft = 'text';
			}else{
				$__f = 'id_mdlstpfm'; $__ft = 'int';
			}

			$c_DtRg = "-1";if (isset($p['id'])){$c_DtRg = $p['id'];}
			$query_DtRg = sprintf('SELECT id_mdlstpfm, mdlstpfm_enc, mdlstpfm_nm FROM '._BdStr(DBM).TB_MDL_S_TP_FM.' WHERE '.$__f.' = %s', GtSQLVlStr($c_DtRg, $__ft));

			$DtRg = $__cnx->_qry($query_DtRg);

			if($DtRg){

				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;

				if($Tot_DtRg > 0){
					$Vl['e'] = 'ok';
					$Vl['id'] = $row_DtRg['id_mdlstpfm'];
					$Vl['enc'] = $row_DtRg['mdlstpfm_enc'];
					$Vl['nm'] = $row_DtRg['mdlstpfm_nm'];
				}
			}

		}

		$__cnx->_clsr($DtRg);

		return( _jEnc($Vl) );

	}


	function GtMdlSTpFmRowFldDt($p=NULL){

		global $__cnx;

		$Vl['e'] = 'no';

		if(!isN($p['id'])){

			if($p['t'] == 'enc'){
				$__f = 'mdlstpfmrowfld_enc'; $__ft = 'text';
			}else{
				$__f = 'id_mdlstpfmrowfld'; $__ft = 'int';
			}

			$c_DtRg = "-1";if (isset($p['id'])){$c_DtRg = $p['id'];}
			$query_DtRg = sprintf('SELECT * FROM '._BdStr(DBM).TB_MDL_S_TP_FM_ROW_FLD.' WHERE '.$__f.' = %s', GtSQLVlStr($c_DtRg, $__ft));

			$DtRg = $__cnx->_qry($query_DtRg);

			if($DtRg){

				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;

				if($Tot_DtRg > 0){
					$Vl['e'] = 'ok';
					$Vl['id'] = $row_DtRg['id_mdlstpfmrowfld'];
					$Vl['enc'] = $row_DtRg['mdlstpfmrowfld_enc'];
					$Vl['tt'] = $row_DtRg['mdlstpfmrowfld_tt'];
				}
			}

		}

		$__cnx->_clsr($DtRg);

		return( _jEnc($Vl) );

	}


	function GtMdlSPrdDt($p=NULL){

		global $__cnx;

		$Vl['e'] = 'no';

		if(!isN($p['id'])){


			if($p['t'] == 'enc'){
				$__f = 'mdlsprd_enc'; $__ft = 'text';
			}else{
				$__f = 'id_mdlsprd'; $__ft = 'int';
			}

			$c_DtRg = "-1";if (isset($p['id'])){$c_DtRg = $p['id'];}
			$query_DtRg = sprintf('	SELECT id_mdlsprd, mdlsprd_enc, mdlsprd_nm, mdlsprd_y, mdlsprd_s, mdlsprd_fi, mdlsprd_fa
									FROM '._BdStr(DBM).TB_MDL_S_PRD.'
									WHERE '.$__f.' = %s
									LIMIT 1', GtSQLVlStr($c_DtRg, $__ft));

			$DtRg = $__cnx->_qry($query_DtRg);

			if($DtRg){

				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;

				if($Tot_DtRg > 0){
					$Vl['e'] = 'ok';
					$Vl['id'] = $row_DtRg['id_mdlsprd'];
					$Vl['enc'] = $row_DtRg['mdlsprd_enc'];
					$Vl['nm'] = ctjTx($row_DtRg['mdlsprd_nm'],'in');
					$Vl['y'] = ctjTx($row_DtRg['mdlsprd_y'],'in');
					$Vl['s'] = ctjTx($row_DtRg['mdlsprd_s'],'in');
					$Vl['fi'] = $row_DtRg['mdlsprd_fi'];
					$Vl['fa'] = $row_DtRg['mdlsprd_fa'];
				}
			}

			$__cnx->_clsr($DtRg);

		}

		return( _jEnc($Vl) );

	}

	function GtMdlSSchDt($p=NULL){

		global $__cnx;

		$Vl['e'] = 'no';

		if(!isN($p['id'])){


			if($p['t'] == 'enc'){
				$__f = 'mdlssch_enc'; $__ft = 'text';
			}else{
				$__f = 'id_mdlssch'; $__ft = 'int';
			}

			$c_DtRg = "-1";if (isset($p['id'])){$c_DtRg = $p['id'];}

			$query_DtRg = sprintf('	SELECT id_mdlssch, mdlssch_enc, mdlssch_nm, mdlssch_fi, mdlssch_fa
									FROM '._BdStr(DBM).TB_MDL_S_SCH.'
									WHERE '.$__f.' = %s
									LIMIT 1', GtSQLVlStr($c_DtRg, $__ft));

			$DtRg = $__cnx->_qry($query_DtRg);

			if($DtRg){

				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;

				if($Tot_DtRg > 0){
					$Vl['e'] = 'ok';
					$Vl['id'] = $row_DtRg['id_mdlssch'];
					$Vl['enc'] = $row_DtRg['mdlssch_enc'];
					$Vl['nm'] = ctjTx($row_DtRg['mdlssch_nm'],'in');
					$Vl['fi'] = $row_DtRg['mdlssch_fi'];
					$Vl['fa'] = $row_DtRg['mdlssch_fa'];
				}
			}

			$__cnx->_clsr($DtRg);

		}

		return( _jEnc($Vl) );

	}

	function GtMdlAreLs($p=NULL){

		global $__cnx;

		if(!isN($p['mdl'])){

			if(!isN($p['bd'])){ $bd = _BdStr($p['bd']); }

			$query_DtRg = sprintf("	SELECT *
							FROM ".$bd.TB_MDL_ARE."
								 INNER JOIN "._BdStr(DBM).TB_CL_ARE." ON mdlare_are = id_clare
							WHERE id_mdlare != '' AND mdlare_mdl= %s", GtSQLVlStr($p['mdl'],'int') );

			$DtRg = $__cnx->_qry($query_DtRg);

			//$Vl['q'] = $query_DtRg;

			if($DtRg){

				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;

				if($Tot_DtRg > 0){

					$Vl['e'] = 'ok';
					$Vl['tot'] = $Tot_DtRg;

					do{

						$_ob = [
							'id'=>ctjTx($row_DtRg['id_mdlare'], 'in'),
							'enc'=>ctjTx($row_DtRg['mdlare_enc'], 'in'),
							'are'=>[
								'id'=>ctjTx($row_DtRg['mdlare_are'], 'in'),
								'tt'=>ctjTx($row_DtRg['clare_tt'], 'in'),
								'cod'=>ctjTx($row_DtRg['clare_cod'], 'in'),
								'clr'=>ctjTx($row_DtRg['clare_clr'], 'in')
							]
						];

						$Vl['ls'][] = $_ob;
						$Vl['last'] = $_ob;

					}while($row_DtRg = $DtRg->fetch_assoc());

				}else{
					$Vl['e'] = 'no';
					$Vl['w'] = TX_NXTMDL;
				}

			}

			$__cnx->_clsr($DtRg);
			return(_jEnc($Vl));

		}
	}

	function GtMdlEmlSndLs($p=NULL){

		global $__cnx;

		$Vl['e'] = 'no';

		if(!isN($p['mdl'])){

			if(!isN($p['bd'])){ $bd = _BdStr($p['bd']); }

			$query_DtRg = sprintf("	SELECT *
							FROM ".$bd.TB_MDL_US_SND."
								 INNER JOIN "._BdStr(DBM).TB_US." ON mdlussnd_us = id_us
							WHERE id_mdlussnd != '' AND mdlussnd_mdl= %s", GtSQLVlStr($p['mdl'],'int') );

			$DtRg = $__cnx->_qry($query_DtRg);

			//$Vl['q'] = $query_DtRg;

			if($DtRg){

				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;

				if($Tot_DtRg > 0){

					$Vl['e'] = 'ok';
					$Vl['tot'] = $Tot_DtRg;

					do{

						$_ob = [
							'id'=>ctjTx($row_DtRg['id_mdlussnd'], 'in'),
							'enc'=>ctjTx($row_DtRg['mdlussnd_enc'], 'in'),
							'us'=>[
								'id'=>ctjTx($row_DtRg['id_us'], 'in'),
								'user'=>ctjTx($row_DtRg['us_user'], 'in'),
							]
						];

						$Vl['ls'][] = $_ob;
						$Vl['last'] = $_ob;

					}while($row_DtRg = $DtRg->fetch_assoc());

				}else{
					$Vl['w'] = TX_NXTMDL;
				}

			}

		}

			$__cnx->_clsr($DtRg);

		return(_jEnc($Vl));

	}

	function GtMdlCntDt($p=NULL){

		global $__cnx;

		$Vl['e'] = 'no';

		if(!isN($p['id'])){

			if(!isN($p['bd'])){ $bd = _BdStr( $p['bd'] ); }

			$c_DtRg = "-1"; if (isset($p['id'])){$c_DtRg = $p['id'];}

			if($p['t'] == 'enc'){
				$__f = 'mdlcnt_enc'; $__ft = 'text';
			}else{
				$__f = 'id_mdlcnt'; $__ft = 'int';
			}

			if(!isN($p['cnt'])){ $_fl = " AND mdlcnt_cnt = ".$p['cnt']." "; }

			$query_DtRg = sprintf('	SELECT id_mdlcnt, mdlcnt_enc, mdlcnt_cnt, mdlcnt_fi, mdlcnt_m, mdlcnt_est, mdlcnt_noi, mdlcnt_noi_otc, id_mdl, mdl_enc, mdl_nm, mdlstp_tp, mdlstp_img, id_cnt, cnt_nm, cnt_ap
									FROM '.$bd.TB_MDL_CNT.'
										 INNER JOIN '.$bd.TB_CNT.' ON mdlcnt_cnt = id_cnt
										 INNER JOIN '.$bd.TB_MDL.' ON mdlcnt_mdl = id_mdl
									     INNER JOIN '._BdStr(DBM).TB_MDL_S.' ON mdl_mdls = id_mdls
										 INNER JOIN '._BdStr(DBM).TB_MDL_S_TP.' ON mdls_tp = id_mdlstp
									WHERE '.$__f.' = %s '.$_fl.'
									LIMIT 1', GtSQLVlStr($c_DtRg,$__ft));


			if($p['cmmt']=='ok'){ //-- If use it on commit process --//
				$DtRg = $__cnx->_prc($query_DtRg);
			}else{
				$DtRg = $__cnx->_qry($query_DtRg);
			}

			if($DtRg){

				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;

				if($Tot_DtRg > 0){

					$Vl['id'] = $row_DtRg['id_mdlcnt'];
					$Vl['enc'] = $row_DtRg['mdlcnt_enc'];

					if($p['shw']['cnt'] == 'ok'){
						$Vl['cnt'] = GtCntDt([ 'bd'=>$bd, 'id'=>$row_DtRg['mdlcnt_cnt'], 'cl'=>$p['cl']]);
					}else{
						$Vl['cnt']['id'] = ctjTx($row_DtRg['id_cnt'],'in');
						$Vl['cnt']['nm'] = ctjTx($row_DtRg['cnt_nm'],'in');
						$Vl['cnt']['ap'] = ctjTx($row_DtRg['cnt_ap'],'in');
					}

					$Vl['fi'] = $row_DtRg['mdlcnt_fi'];

					$time = new DateTime($row_DtRg['mdlcnt_fi']);
					$date = $time->format('Y-m-d');
					$time = $time->format('H:i a');

					if(date('Ymd', strtotime($date)) == date('Ymd', strtotime('yesterday')) ){
						$_fgo = 'Ayer';
					}elseif(date('Ymd', strtotime($date)) == date('Ymd', strtotime('today')) ){
						$_fgo = 'Hoy';
					}else{
						$_fgo = $date;
					}

					$Vl['f']['d'] = $_fgo;
					$Vl['f']['h'] = $time;

					$Vl['f']['in']['d'] = $date;
					$Vl['f']['in']['h'] = $time;

					//$Vl['fnt'] = GtSisFntDt($row_DtRg['mdlcnt_fnt']);
					$Vl['m'] = $row_DtRg['mdlcnt_m'];
					$Vl['est'] = $row_DtRg['mdlcnt_est'];
					$Vl['noi'] = $row_DtRg['mdlcnt_noi'];

					$Vl['noi_otu'] = $row_DtRg['mdlcnt_noi_otc'];

					$Vl['mdl']['id'] = ctjTx($row_DtRg['id_mdl'],'in');
					$Vl['mdl']['enc'] = ctjTx($row_DtRg['mdl_enc'],'in');
					$Vl['mdl']['nm'] = ctjTx($row_DtRg['mdl_nm'],'in');

					if($p['shw']['eml'] == 'ok'){
						$Vl['mdl']['eml'] = GtMdlEmlSndLs([ 'mdl'=>$row_DtRg['id_mdl'] ]);
					}

					$__img = _ImVrs(['img'=>ctjTx($row_DtRg['mdlstp_img'],'in'), 'f'=>DMN_FLE_MDL_TP ]);

					$Vl['mdl']['tp']['img'] = $__img;
					$Vl['mdl']['tp']['key'] = $row_DtRg['mdlstp_tp'];

					if($p['shw']['are'] == 'ok'){

						$__are = GtMdlAreLs([ 'mdl'=>$row_DtRg['id_mdl'], 'bd'=>$p['bd'] ]);

						if($__are->tot > 0){
							$Vl['mdl']['are'] = $__are;
						}

					}

					if($p['shw']['msj'] == 'ok'){
						$Vl['msj'] = GtMdlCntMsj([ 'i'=>$row_DtRg['id_mdlcnt'] ]);
					}

					if($p['shw']['attr'] == 'ok'){

						$__attr = GtAttrLs([ 't'=>'mdl_cnt', 'i'=>$row_DtRg['id_mdlcnt'], 'bd'=>$p['bd'] ]);

						$Vl['attr'] = $__attr->a;
						$Vl['attr_o'] = $__attr->o;
						$Vl['attr_edt'] = $__attr->edt;

					}

					if($p['shw']['attch'] == 'ok'){
						$Vl['attch'] = GtMdlCntAttch([ 'i'=>$row_DtRg['id_mdlcnt'] ]);
						if(_ChckMd('up_fle_mdlcnt')){ $Vl['attch_fle'] = 'ok'; }
					}

				}

			}

			$__cnx->_clsr($DtRg);

		}

		return(_jEnc($Vl));
	}

	function GtClAreMdlDt($p=NULL){
		global $__cnx;

		$Vl['e'] = 'no';

		if(!isN($p['mdl'])){

			if(!isN($p['bd'])){ $bd = _BdStr($p['bd']); }

			$query_DtRg = sprintf("	SELECT id_clare  FROM ".TB_MDL."
										INNER JOIN ".TB_MDL_ARE." ON mdlare_mdl = id_mdl
										INNER JOIN "._BdStr(DBM).TB_CL_ARE." ON mdlare_are = id_clare
									WHERE
										clare_est = 1 AND mdlare_mdl = %s", GtSQLVlStr($p['mdl'],'int') );

			$DtRg = $__cnx->_qry($query_DtRg);

			if($DtRg){

				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;

				if($Tot_DtRg > 0){

					$Vl['e'] = 'ok';
					$Vl['tot'] = $Tot_DtRg;

					do{

						$Vl['ls'][] = ctjTx($row_DtRg['id_clare'], 'in');

					}while($row_DtRg = $DtRg->fetch_assoc());

				}else{
					$Vl['w'] = TX_NXTMDL;
				}
			}

			$__cnx->_clsr($DtRg);
		}

		return(_jEnc($Vl));
	}

	function GtMdlCntHisDt($p=NULL){

		global $__cnx;

		$Vl['e'] = 'no';

		if(!isN($p['id'])){

			if(!isN($p['bd'])){ $bd = _BdStr($p['bd']); }

			$c_DtRg = "-1"; if (isset($p['id'])){$c_DtRg = $p['id'];}

			if($p['t'] == 'enc'){
				$__f = 'mdlcnthis_enc'; $__ft = 'text';
			}else{
				$__f = 'id_mdlcnthis'; $__ft = 'int';
			}

			$query_DtRg = sprintf('	SELECT *
									FROM '.$bd.TB_MDL_CNT_HIS.'
										 INNER JOIN '.$bd.TB_MDL_CNT.' ON mdlcnthis_mdlcnt = id_mdlcnt

									WHERE '.$__f.' = %s', GtSQLVlStr($c_DtRg,$__ft));

			$DtRg = $__cnx->_qry($query_DtRg);

			if($DtRg){

				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;

				if($Tot_DtRg > 0){

					$Vl['e'] = 'ok';

					$Vl['id'] = $row_DtRg['id_mdlcnthis'];
					$Vl['enc'] = $row_DtRg['mdlcnthis_enc'];

					$Vl['mdlcnt']['id'] = $row_DtRg['id_mdlcnt'];
					$Vl['mdlcnt']['enc'] = $row_DtRg['mdlcnt_enc'];

				}

			}

		}

		$__cnx->_clsr($DtRg);

		return(_jEnc($Vl));
	}

	function GtPsDt($p=NULL){

		global $__cnx;

		if(!isN($p['tp'])){

			if($p['tp']=='id'){ $_bd='id_sisps'; $v = $p['v']; }
			elseif($p['tp']=='enc'){ $_bd='sisps_enc'; $v = $p['v']; }
			elseif($p['tp']=='tel'){ $_bd='sisps_tel'; $v = $p['v']; }

			$Ls_Qry_His = "SELECT * FROM "._BdStr(DBM).TB_SIS_PS." WHERE $_bd = '$v'";
			$Ls_Rg = $__cnx->_qry($Ls_Qry_His);

			if($Ls_Rg){
				$row_Ls_Rg = $Ls_Rg->fetch_assoc();
				$Tot_Ls_Rg = $Ls_Rg->num_rows;

				if($Tot_Ls_Rg > 0){
					$_r['e'] = 'ok';
					$_r['id'] = $row_Ls_Rg['id_sisps'];
	            	$_r['tel'] = $row_Ls_Rg['sisps_tel'];
	            	$_r['tt'] = $row_Ls_Rg['sisps_tt'];
	            }else{
		        	$_r['e'] = 'no';
	            }

            }

            $__cnx->_clsr($Ls_Rg);

			$rtrn = _jEnc($_r);
			return($rtrn);
		}
	}

	function GtAttrLs($p=NULL){

		global $__cnx;

		$_r['e'] = 'no';

		if(!isN($p['i'])){

			if(!isN($p['bd'])){ $_bd = _BdStr($p['bd']); }else{ $_bd=''; }

			if($p['t']=='cnt'){
				$_tb=TB_CNT_ATTR;
				$_rlc='cntattr_attr';
				$_rlc_m='cntattr_cnt';
				$_rlc_f='cntattr_fi';
				$_prfx='cntattr';
				$_key = 'cnt_attr';
			}elseif($p['t']=='mdl'){
				$_tb=TB_MDL_ATTR;
				$_rlc='mdlattr_attr';
				$_rlc_m='mdlattr_mdl';
				$_rlc_f='mdlattr_fi';
				$_prfx='mdlattr';
				$_key = 'mdls_tp_attr';
			}elseif($p['t']=='mdl_cnt'){
				$_tb=TB_MDL_CNT_ATTR;
				$_rlc='mdlcntattr_attr';
				$_rlc_m='mdlcntattr_mdlcnt';
				$_rlc_f='mdlcntattr_fi';
				$_prfx='mdlcntattr';
				$_key = 'mdl_cnt_attr';
			}

			$Ls_Qry_Max = "SET SESSION group_concat_max_len=18446744073709551615";
			$__cnx->_prc($Ls_Qry_Max);

			/*$Ls_Qry_His = "	SELECT *,
								   "._QrySisSlcF([ 'als'=>'a', 'als_n'=>'attribute' ]).",
								   ".GtSlc_QryExtra([ 't'=>'fld', 'p'=>'attribute', 'als'=>'a' ])."
							FROM ".$_bd.$_tb."
								 ".GtSlc_QryExtra([ 't'=>'tb', 'col'=>$_rlc, 'als'=>'a' ])."
							WHERE ".$_rlc_m." = ".$p['i']."
							ORDER BY ".$_rlc_f." DESC";*/

			$Ls_Qry_His = "	SELECT a.id_sisslc, id_{$_prfx}, {$_prfx}_enc, {$_prfx}_vl, {$_prfx}_attr,
								"._QrySisSlcF([ 'als'=>'a', 'als_n'=>'attribute' ]).",
								".GtSlc_QryExtra([ 't'=>'fld', 'p'=>'attribute', 'als'=>'a' ])."
						FROM "._BdStr(DBM).TB_SIS_SLC." as a
								INNER JOIN "._BdStr(DBM).TB_SIS_SLC_TP." ON sisslc_tp = id_sisslctp
								INNER JOIN "._BdStr(DBM).TB_SIS_SLC_CL." ON sisslccl_sisslc = id_sisslc
								LEFT JOIN ".$_bd.$_tb." ON ".$_rlc." = id_sisslc AND ".$_rlc_m." = ".$p['i']."
						WHERE sisslctp_key = '".$_key."' AND
							sisslccl_cl = (SELECT id_cl FROM "._BdStr(DBM).TB_CL." WHERE cl_enc = '".CL_ENC."')
						ORDER BY ".$_rlc_f." DESC";

			$Ls_Rg = $__cnx->_qry($Ls_Qry_His);

			//$_r['q'] = compress_code( $Ls_Qry_His );

			if($Ls_Rg){

				$row_Ls_Rg = $Ls_Rg->fetch_assoc();
				$Tot_Ls_Rg = $Ls_Rg->num_rows;

				$_r['tot'] = $Tot_Ls_Rg;

				if($Tot_Ls_Rg > 0){

					$_r['e'] = 'ok';

	                do{

	                    $__attr_go = '';
	                    $__vlreal = '';
						$__attr = json_decode($row_Ls_Rg['___attribute']);
						$___sislc_key = '';

	                    foreach($__attr as $__attr_k=>$__attr_v){
							$__attr_go->{$__attr_v->key} = _jEnc($__attr_v);
							if($__attr_v->key == 'key' && !isN($__attr_v->vl)){
								$___sislc_key = ctjTx($__attr_v->vl,'in');
							}
						}

						$__vlreal = ctjTx($row_Ls_Rg[$_prfx.'_vl'],'in');

						if(!isN($row_Ls_Rg['attribute_sisslc_img'])){
							$__imgreal = DMN_FLE_SIS_SLC.ctjTx($row_Ls_Rg['attribute_sisslc_img'],'in');
						}

						if(mBln($__attr_go->cl_ls->vl) == 'ok'){
							$__slcdt = __LsDt([ 'id'=>$row_Ls_Rg[$_prfx.'_vl'] ]);
							if(!isN($__slcdt->d->tt)){ $__vlreal = $__slcdt->d->tt;	}
							if(!isN($__slcdt->d->img)){ $__imgreal = $__slcdt->d->img;	}
						}

						if(!isN($__attr_go->edt->vl) && mBln($__attr_go->edt->vl) == 'ok'){

							$_r['a'][] = [
								'id'=>$row_Ls_Rg['id_'.$_prfx],
								'attr'=>$row_Ls_Rg[$_prfx.'_attr'],
								'vl'=>$__vlreal,
								'tt'=>ctjTx($row_Ls_Rg['attribute_sisslc_tt'],'in'),
								'key'=>$___sislc_key,
								'img'=>$__imgreal,
								'all'=>$__attr_go,
								'edt'=>'ok',
								'id_alt'=>$row_Ls_Rg['id_sisslc']
							];

						}else{

							if(!isN($__vlreal)){
								$_r['a'][] = [
									'id'=>$row_Ls_Rg['id_'.$_prfx],
									'attr'=>$row_Ls_Rg[$_prfx.'_attr'],
									'vl'=>$__vlreal,
									'tt'=>ctjTx($row_Ls_Rg['attribute_sisslc_tt'],'in'),
									'key'=>$___sislc_key,
									'img'=>$__imgreal,
									'all'=>$__attr_go
								];
							}
						}

						if(!isN($___sislc_key)){

							$_r['o'][$___sislc_key] = [
								'id'=>$row_Ls_Rg['id_'.$_prfx],
								'enc'=>$row_Ls_Rg[$_prfx.'_enc'],
								'attr'=>$row_Ls_Rg[$_prfx.'_attr'],
								'vl'=>$__vlreal,
								'tt'=>ctjTx($row_Ls_Rg['attribute_sisslc_tt'],'in'),
								'key'=>$___sislc_key,
								'img'=>$__imgreal,
								'all'=>$__attr_go
							];

						}

	                } while ($row_Ls_Rg = $Ls_Rg->fetch_assoc());

	            }

            }else{

				$_r['w'] = $__cnx->c_r->error;

			}

			if(isN($p["cnx"])){ $__cnx->_clsr($Ls_Rg); }

		}else{

            $_r['w'] = 'No ID';

        }

		return _jEnc($_r);

	}



	function GtApplFmDt($p=NULL){

		global $__cnx;

		$Ls_Qry_His = "	SELECT * FROM "._BdStr(DBM).TB_APPL_FM." WHERE applfm_enc = ".GtSQLVlStr($p['enc'], "text")." ";

		$Ls_Rg = $__cnx->_qry($Ls_Qry_His);

		if($Ls_Rg){

			$row_Ls_Rg = $Ls_Rg->fetch_assoc(); $Tot_Ls_Rg = $Ls_Rg->num_rows;

			$Vl['tot'] = $Tot_Ls_Rg;

			if($Tot_Ls_Rg > 0){

                do{

	                $_id = $row_Ls_Rg['id_applfm'];
	                $Vl['id'] = $_id;
	                $Vl['enc'] = ctjTx($row_Ls_Rg['applfm_enc'],'in');
	                $Vl['romt'] = ctjTx($row_Ls_Rg['applfm_romt'],'in');

                } while ($row_Ls_Rg = $Ls_Rg->fetch_assoc());
           	}

       	}

       	$__cnx->_clsr($Ls_Rg);

		$rtrn = _jEnc($Vl);
		return($rtrn);
	}

    function GtMdlCntOth($p=NULL){

		global $__cnx;

		if(!isN($p['i2'])){ $__fl .= ' AND id_mdlcnt != '.GtSQLVlStr($p['i2'], "int").' '; }
		if(!isN($p['mdlstp'])){ $__fl .= ' AND mdls_tp = '.GtSQLVlStr($p['mdlstp'], "int").' '; }
		if(!isN($p['est'])){ $__fl .= ' AND mdlcnt_est = '.GtSQLVlStr($p['est'], "int").' '; }
		if($p['mdlstp'] == _Cns('SIS_MDLSTP_SAC')){ $_innr .= 'INNER JOIN '.TB_MDL_CNT_TRA.' ON mdlcnttra_mdlcnt = id_mdlcnt'; }

		$Ls_Qry_His = "	SELECT id_mdlcnt, mdlcnt_enc, mdl_nm, siscntest_tt, siscntest_clr_bck, mdlcnt_fi
						FROM ".TB_MDL_CNT."
							 INNER JOIN ".TB_MDL." ON mdlcnt_mdl = id_mdl
							 INNER JOIN "._BdStr(DBM).TB_MDL_S." ON mdl_mdls = id_mdls
							 INNER JOIN "._BdStr(DBM).TB_SIS_CNT_EST." ON mdlcnt_est = id_siscntest
							 {$_innr}
						WHERE mdlcnt_cnt = ".GtSQLVlStr($p['i'], "int")." $__fl
						ORDER BY mdlcnt_fi DESC";

		$Ls_Rg = $__cnx->_qry($Ls_Qry_His);

		if($Ls_Rg){

			$row_Ls_Rg = $Ls_Rg->fetch_assoc();
			$Tot_Ls_Rg = $Ls_Rg->num_rows;

			$_r['tot'] = $Tot_Ls_Rg;

			if($Tot_Ls_Rg > 0){

                do{

	                $_id = $row_Ls_Rg['mdlcnt_enc'];

	                $_r['ls'][$_id]['id'] = $_id;
	                $_r['ls'][$_id]['nm'] = ctjTx($row_Ls_Rg['mdl_nm'],'in');
	                $_r['ls'][$_id]['tp']['id'] = ctjTx($row_Ls_Rg['mdltp_nm'],'in');
	                $_r['ls'][$_id]['est']['nm'] = ctjTx($row_Ls_Rg['siscntest_tt'],'in');
	                $_r['ls'][$_id]['est']['clr'] = $row_Ls_Rg['siscntest_clr_bck'];
	                $_r['ls'][$_id]['fi']['d'] = $row_Ls_Rg['mdlcnt_fi'];
					$_r['ls'][$_id]['fi']['b'] = _Tme($row_Ls_Rg['mdlcnt_fi']);

					if($p['d']['mdlcntmdl']=='ok'){
						$_r['ls'][$_id]['mdl'] = GtMdlCntMdl([ 'id'=>$row_Ls_Rg['id_mdlcnt'] ]);
					}

                } while ($row_Ls_Rg = $Ls_Rg->fetch_assoc());
           	}

       	}

	   	$__cnx->_clsr($Ls_Rg);
	   	return _jEnc($_r);
	}

	function GtMdlCntMdl($p=NULL){

		global $__cnx;

		$Ls_Qry = "	SELECT
							id_mdlcntmdl, mdl_nm, mdlstp_img
						FROM
							".TB_MDL_CNT_MDL."
							INNER JOIN ".TB_MDL_CNT." ON mdlcntmdl_mdlcnt = id_mdlcnt
							INNER JOIN ".TB_MDL." ON mdlcntmdl_mdl = id_mdl
							INNER JOIN "._BdStr(DBM).TB_MDL_S." ON mdl_mdls = id_mdls
							INNER JOIN "._BdStr(DBM).TB_MDL_S_TP." ON mdls_tp = id_mdlstp
						WHERE id_mdlcnt = ".$p['id'];

		$Ls_Rg = $__cnx->_qry($Ls_Qry);

		if($Ls_Rg){

			$row_Ls_Rg= $Ls_Rg->fetch_assoc();
			$Tot_Ls_Rg = $Ls_Rg->num_rows;

			$_r['e'] = 'ok';
			$_r['tot'] = $Tot_Ls_Rg;

		    if($Tot_Ls_Rg > 0){

                do{

					$_id = $row_Ls_Rg['id_mdlcntmdl'];

					$_r['ls'][$_id]['id'] = $_id;
					$_r['ls'][$_id]['nm'] = $row_Ls_Rg['mdl_nm'];
					$_r['ls'][$_id]['img'] = DMN_FLE_MDL_TP.$row_Ls_Rg['mdlstp_img'];

				} while ($row_Ls_Rg = $Ls_Rg->fetch_assoc());

			}
		}

		$__cnx->_clsr($Ls_Rg);

	    $rtrn = _jEnc($_r);
	    return($rtrn);
	}

    function GtMdlCnt($p=NULL){

		global $__cnx;

		$Ls_Qry_MdlCnt = "	SELECT
								id_mdlcnt, mdlcnt_mdl, mdlcnt_cnt, mdlcnt_m, mdlcnt_fi, mdlcnt_enc
							FROM
								"._BdStr($p['cl']).TB_MDL_CNT."
							WHERE
							mdlcnt_mdl = ".GtSQLVlStr($p['mdl'], "int")." ";

		$_r['e'] = $Ls_Qry_MdlCnt;

		$LsMdlCnt_Rg = $__cnx->_qry($Ls_Qry_MdlCnt);

		if($LsMdlCnt_Rg){

			$row_LsMdlCnt_Rg = $LsMdlCnt_Rg->fetch_assoc();
			$Tot_LsMdlCnt_Rg = $LsMdlCnt_Rg->num_rows;

			$_r['e'] = 'ok';
			$_r['tot'] = $Tot_LsMdlCnt_Rg;

		    if($Tot_LsMdlCnt_Rg > 0){

                do{

					$_id = $row_LsMdlCnt_Rg['id_mdlcnt'];

					$_r['ls'][$_id]['id'] = $_id;
					$_r['ls'][$_id]['fi'] = $row_LsMdlCnt_Rg['mdlcnt_fi'];
					$_r['ls'][$_id]['mdl'] = ctjTx($row_LsMdlCnt_Rg['mdlcnt_mdl'],'in');
					$_r['ls'][$_id]['cnt'] = ctjTx($row_LsMdlCnt_Rg['mdlcnt_cnt'],'in');
					$_r['ls'][$_id]['m'] = ctjTx($row_LsMdlCnt_Rg['mdlcnt_m'],'in');
					$_r['ls'][$_id]['enc'] = ctjTx($row_LsMdlCnt_Rg['mdlcnt_enc'],'in');

				} while ($row_LsMdlCnt_Rg = $LsMdlCnt_Rg->fetch_assoc());

			}

		}

		$__cnx->_clsr($LsEst_Rg);

	    $rtrn = _jEnc($_r);
	    return($rtrn);
	}

	function GtMdlCntUs($p=NULL){

		global $__cnx;

		$id_mdlcnt = $p['id_mdlcnt'];

		if($p['tp'] == 'rsp' ){ $__fl .= " AND  mdlcntus_tp = "._CId('ID_USROL_RSP')." ";
		}elseif($p['tp'] == 'obs' ){ $__fl .= " AND  mdlcntus_tp = "._CId('ID_USROL_OBS')." "; }

		if( !isN($p['us']) ){
			$__fl .= " AND mdlcntus_us IN ( SELECT id_us FROM "._BdStr(DBM).TB_US." WHERE us_enc = '".$p['us']."' ) ";
		}

		$query_DtRg = "	SELECT
							id_mdlcntus, mdlcntus_enc, mdlcntus_us_asg, mdlcntus_tp
						FROM "._BdStr($p['cl']).TB_MDL_CNT_US."
							INNER JOIN "._BdStr($p['cl']).TB_MDL_CNT." ON mdlcntus_mdlcnt = id_mdlcnt
						WHERE
							id_mdlcntus != '' $__fl AND mdlcntus_mdlcnt = $id_mdlcnt
						ORDER BY
							id_mdlcntus ASC";

		$DtRg = $__cnx->_qry($query_DtRg);
		$Vl['e'] = $query_DtRg;
		if($DtRg){

			$Vl['e'] = "ok";

			$row_DtRg = $DtRg->fetch_assoc();
			$Tot_DtRg = $DtRg->num_rows;

			$Vl['tot'] = $Tot_DtRg;

			if($Tot_DtRg > 0){

				do{

					if(!isN($row_DtRg['id_mdlcntus'])){

						$Vl['ls'][$row_DtRg['id_mdlcntus']]['id'] = $row_DtRg['id_mdlcntus'];
						$Vl['ls'][$row_DtRg['id_mdlcntus']]['us_id'] = $row_DtRg['mdlcntus_us'];

					}

				}while($row_DtRg = $DtRg->fetch_assoc());

			}else{
				$Vl['e'] = "no";
			}
		}


		$__cnx->_clsr($DtRg);

		return(_jEnc($Vl));

	}

	function GtMdlCntEst($p=NULL){

		global $__cnx;

		$Ls_Qry_Est = "	SELECT id_mdlcntest, siscntest_tt, siscntest_clr_bck, mdlcntest_fi, us_nm, us_ap, mdlcntest_eml
						FROM ".TB_MDL_CNT_EST."
							 INNER JOIN "._BdStr(DBM).TB_SIS_CNT_EST." ON mdlcntest_est = id_siscntest
							 INNER JOIN "._BdStr(DBM).TB_US." ON mdlcntest_us = id_us
						WHERE mdlcntest_mdlcnt = ".GtSQLVlStr($p['i'], "int")."
						ORDER BY mdlcntest_fi DESC
						LIMIT 10";

		$LsEst_Rg = $__cnx->_qry($Ls_Qry_Est);

		if($LsEst_Rg){

			$row_LsEst_Rg = $LsEst_Rg->fetch_assoc();
			$Tot_LsEst_Rg = $LsEst_Rg->num_rows;

			$_r['e'] = 'ok';
			$_r['tot'] = $Tot_LsEst_Rg;

		    if($Tot_LsEst_Rg > 0){

                do{
                    /*
                    if($row_LsEst_Rg[$_prfx.'siscntest_eml'] == 1){ $icn = Spn('','','_tt_icn _tt_icn_ec'); }else{ $icn = ''; }

					$_r_li .= li( Spn(ctjTx($row_LsEst_Rg['siscntest_tt'],'in'),'ok','__e','font-weight:bolder; color:'.$row_LsEst_Rg['siscntest_clr_bck'].';') . $icn  .
							  ' por '. ctjTx($row_LsEst_Rg['us_nm'].' '.$row_LsEst_Rg['us_ap'],'in') . HTML_BR.
							  Spn($row_LsEst_Rg[$_prfx.'mdlcntest_fi'],'','_f') .' - '.Spn($row_LsEst_Rg[$_prfx.'mdlcntest_fi'],'','_h') );
					*/

					$_id = $row_LsEst_Rg['id_mdlcntest'];

					$_r['ls'][$_id]['id'] = $_id;


					$_r['ls'][$_id]['fi'] = $row_LsEst_Rg['mdlcntest_fi'];

					$_r['ls'][$_id]['est']['nm'] = ctjTx($row_LsEst_Rg['siscntest_tt'],'in');
					$_r['ls'][$_id]['est']['clr'] = $row_LsEst_Rg['siscntest_clr_bck'];

					$_r['ls'][$_id]['us']['nm'] = ctjTx($row_LsEst_Rg['us_nm'].' '.$row_LsEst_Rg['us_ap'],'in');
					$_r['ls'][$_id]['eml']['icn'] = mBln($row_LsEst_Rg['mdlcntest_eml']);

				} while ($row_LsEst_Rg = $LsEst_Rg->fetch_assoc());

			}

		}

		$__cnx->_clsr($LsEst_Rg);

	    $rtrn = _jEnc($_r);
	    return($rtrn);
	}

	function GtMdlCntEst_Lst($_p){

		global $__cnx;

		$Vl['e'] = 'no';

		if(!isN($_p['id'])){

			if(!isN($_p['bd'])){ $_bd=$_p['bd']; }else{ $_bd=''; }

			$c_DtRg = "-1";if (!isN($_p['id'])){$c_DtRg = $_p['id'];}

			$query_DtRg = sprintf('	SELECT *
									FROM '._BdStr($_bd).TB_MDL_CNT_EST.'
										 INNER JOIN '._BdStr(DBM).TB_SIS_CNT_EST.' ON mdlcntest_est = id_siscntest
										 INNER JOIN '._BdStr(DBM).TB_SIS_CNT_EST_TP.' ON siscntest_tp = id_siscntesttp
									WHERE mdlcntest_mdlcnt = %s
									ORDER BY id_mdlcntest DESC
									LIMIT 1', GtSQLVlStr($c_DtRg,'int'));

			$DtRg = $__cnx->_qry($query_DtRg);

			if($DtRg){

				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;

				if($Tot_DtRg > 0){

					$Vl['i'] = $row_DtRg['id_mdlcntest'];
					$Vl['e'] = $row_DtRg['mdlcntest_est'];

					$Vl['est']['id'] = ctjTx($row_DtRg['id_siscntest'],'in');
					$Vl['est']['tt'] = ctjTx($row_DtRg['siscntest_tt'],'in');

					$Vl['est']['tp']['id'] = ctjTx($row_DtRg['id_siscntesttp'],'in');
					$Vl['est']['tp']['tt'] = ctjTx($row_DtRg['siscntesttp_tt'],'in');
					$Vl['est']['tp']['ord'] = ctjTx($row_DtRg['siscntesttp_ord'],'in');

			if($DtRg){

				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;

				if($Tot_DtRg > 0){

					$Vl['e'] = 'ok';
					$Vl['id'] = $row_DtRg['id_siscntest'];
					$Vl['tt'] = ctjTx($row_DtRg['siscntest_tt'],'in').$icn;
					$Vl['clr'] = ctjTx($row_DtRg['siscntest_clr_bck'],'in');
					$Vl['tp']['id'] = ctjTx($row_DtRg['id_siscntesttp'],'in');
					$Vl['tp']['ord'] = ctjTx($row_DtRg['siscntesttp_ord'],'in');

				}

			}

					if($row_DtRg['mdlcntest_est'] != $_p['nw']){
						$Vl['df'] = 'ok';
					}else{
						$Vl['df'] = 'no';
					}

				}else{
					$Vl['df'] = 'ok';
				}

			}

			$__cnx->_clsr($DtRg);

			return(_jEnc($Vl));
		}
	}

	function GtMdlCntMsj($p=NULL){

		global $__cnx;

		if(!isN($p['i'])){

			if(!isN($p['bd'])){ $_bd=$p['bd']; }else{ $_bd=''; }

			$Ls_Qry_His = "	SELECT id_mdlcntmsj, mdlcntmsj_msj, mdlcntmsj_fi
							FROM ".$_bd.TB_MDL_CNT_MSJ."
								INNER JOIN ".$_bd.TB_MDL_CNT." ON mdlcntmsj_mdlcnt = id_mdlcnt
						WHERE mdlcntmsj_mdlcnt = ".$p['i']."
						ORDER BY mdlcntmsj_fi DESC";

			$Ls_Rg = $__cnx->_qry($Ls_Qry_His);

			if($Ls_Rg){

				$_r['e'] = 'ok';

				$row_Ls_Rg = $Ls_Rg->fetch_assoc();
				$Tot_Ls_Rg = $Ls_Rg->num_rows;

				$_r['tot'] = $Tot_Ls_Rg;

				if($Tot_Ls_Rg > 0){

					$_id = $row_Ls_Rg['id_mdlcntmsj'];;
					$_r['ls'][$_id]['id'] = $_id;
					$_r['ls'][$_id]['msj'] = html_entity_decode(  ctjTx(	strip_tags($row_Ls_Rg['mdlcntmsj_msj'])	,'in') )	;
					$_r['ls'][$_id]['fi'] = $row_Ls_Rg['mdlcntmsj_fi'];

					$_r['all'] .= $_r['ls'][$_id]['msj'].' - '.$_r['ls'][$_id]['fi'].'---';

				}
			}

			$__cnx->_clsr($DtRg);

		}

		$rtrn = _jEnc($_r);
		return($rtrn);
	}


	function GtMdlCntAttch($p=NULL){

		global $__cnx;

		if(!isN($p['i'])){

			if(!isN($p['bd'])){ $_bd=$p['bd']; }else{ $_bd=''; }

			$Ls_Qry_His = "	SELECT id_mdlcntattch, mdlcntattch_fle, mdlcntattch_fle_nm, mdlcntattch_fi
							FROM ".$_bd.TB_MDL_CNT_ATTCH."
								INNER JOIN ".$_bd.TB_MDL_CNT." ON mdlcntattch_mdlcnt = id_mdlcnt
						WHERE mdlcntattch_mdlcnt = '".$p['i']."'
						ORDER BY mdlcntattch_fi ASC";

			$Ls_Rg = $__cnx->_qry($Ls_Qry_His);

			if($Ls_Rg){

				$_r['e'] = 'ok';

				$row_Ls_Rg = $Ls_Rg->fetch_assoc();
				$Tot_Ls_Rg = $Ls_Rg->num_rows;

				$_r['tot'] = $Tot_Ls_Rg;

				if($Tot_Ls_Rg > 0){

					$_aws = new API_CRM_Aws();

					do{

						$_ext = strtolower( pathinfo(ctjTx($row_Ls_Rg['mdlcntattch_fle_nm'],'in'), PATHINFO_EXTENSION) );
						$_pth = $_aws->_s3_get([ 'b'=>'prvt', 'fle'=>DIR_PRVT_ATTCH.$row_Ls_Rg['mdlcntattch_fle'] ]);

						if(in_array($_ext, ['jpg','png','jpeg'])){ $is_img='ok'; }else{ $is_img=''; }

						$_id = $row_Ls_Rg['id_mdlcntattch'];

						$_r['ls'][] = [
							'id'=>$_id,
							'img'=>$is_img,
							'fle'=>[
								'u'=>$_pth->uri,
								'n'=>ctjTx($row_Ls_Rg['mdlcntattch_fle_nm'],'in'),
								'e'=>$_ext
							]
						];


					}while($row_Ls_Rg = $Ls_Rg->fetch_assoc());

				}
			}

			$__cnx->_clsr($DtRg);

		}

		return _jEnc($_r);

	}

	function GtStoreBrnd($_p=NULL){

		global $__cnx;

		$_r['e'] = 'no';

		$Ls_Qry = "	SELECT id_storebrnd, storebrnd_enc, storebrnd_nm, storebrnd_img
					FROM "._BdStr(DBS).TB_STORE_BRND."
							INNER JOIN "._BdStr(DBS).TB_STORE." ON storebrnd_store = id_store
							INNER JOIN "._BdStr(DBM).TB_CL." ON store_cl = id_cl
					WHERE cl_enc = '".DB_CL_ENC."'
					ORDER BY storebrnd_nm ASC";

		$Ls = $__cnx->_qry($Ls_Qry);

		if($Ls){

			$_r['e'] = 'ok';

			$row_Ls = $Ls->fetch_assoc();
			$Tot_Ls = $Ls->num_rows;

			if($Tot_Ls > 0){

				$_r['tot'] = $Tot_Ls;

				do {

					$_r['ls'][$row_Ls['storebrnd_enc']]['id'] = $row_Ls['id_storebrnd'];
					$_r['ls'][$row_Ls['storebrnd_enc']]['enc'] = $row_Ls['storebrnd_enc'];
					$_r['ls'][$row_Ls['storebrnd_enc']]['nm'] = $row_Ls['storebrnd_nm'];
					$_r['ls'][$row_Ls['storebrnd_enc']]['img'] = DMN_IMG_ESTR_SVG.'tra_nobrand.svg';

					if(!isN($row_Ls['storebrnd_img'])){
						$_img_brnd = _ImVrs(['img'=>$row_Ls['storebrnd_img'], 'f'=>DMN_FLE_CL_STORE_BRND ]);
						$_r['ls'][$row_Ls['storebrnd_enc']]['img'] = $_img_brnd->th_100;
					}

				} while ($row_Ls = $Ls->fetch_assoc());

			}else{

				$_r['tot'] = 0;

			}
		}

		$__cnx->_clsr($Ls);
		return _jEnc($_r);
	}

	function GtDshDt($id=NULL, $tp=NULL){

		global $__cnx;

		$_fl_us = "AND dsh_us = ".SISUS_ID."";
		if($tp['tp']=="dsh_mod"){ $_fl = "AND id_dsh = ".$id." "; }
		$query_DtRg = "SELECT *,
								(SELECT id_dsh FROM ".DBM.".dsh ORDER BY id_dsh DESC LIMIT 1) as _ult,
								(SELECT COUNT(*) FROM ".DBM.".dsh_col WHERE dshcol_dsh = id_dsh) as _dsh_col_tot,
								(SELECT GROUP_CONCAT(id_dshcol SEPARATOR ',') FROM ".DBM.".dsh_col WHERE dshcol_dsh = id_dsh ) as _dsh_col,
								(SELECT dshcol_ord FROM ".DBM.".dsh_col WHERE dshcol_dsh = id_dsh ORDER BY dshcol_ord DESC LIMIT 1 ) as _ord_ult
						FROM ".DBM.".dsh WHERE id_dsh != '' $_fl $_fl_us";

		$DtRg = $__cnx->_qry($query_DtRg);

		if($DtRg){

			do{
				$Vl[$row_DtRg['id_dsh']]['id'] = $row_DtRg['id_dsh'];
				$Vl[$row_DtRg['id_dsh']]['html'] = $row_DtRg['dsh_html'];
				$Vl[$row_DtRg['id_dsh']]['tp'] = $row_DtRg['dsh_coltp'];
				$Vl[$row_DtRg['id_dsh']]['dsh_col'] = $row_DtRg['_dsh_col'];
				$Vl[$row_DtRg['id_dsh']]['ord_ult'] = $row_DtRg['_ord_ult'];
				$Vl['ult'] = $row_DtRg['_ult'];
				$Vl['html'] = $row_DtRg['dsh_html'];
				$Vl[$row_DtRg['id_dsh']]['col_tot'] = $row_DtRg['_dsh_col_tot'];
			}while($row_DtRg = $DtRg->fetch_assoc());

		}

		$__cnx->_clsr($DtRg);

		return(_jEnc($Vl));

	}

	function GtDshLs($p=NULL){

		global $__cnx;

		$_fl_us = "AND dsh_us = ".SISUS_ID."";
		if($p['id']!=''){ $_fl .= " AND dshcol_dsh = ".$p['id']." "; }
		if($p['tp']=='dsh'){ $_fl .= "AND dsh_prnt IS NULL"; }
		if($p['tp']=='dsh_prnt'){  $_fl .= $_fl_sub = "AND dsh_prnt = ".$p['dsh_prnt'].""; }
		if($p['tp']=='null'){ $_fl .= "AND dsh_prnt IS NULL"; }
		if($p['tp']=='no_null'){ $_fl .= "AND dsh_prnt NOT IS NULL"; }

		$query_DtRg = "SELECT *,
						(SELECT dshcol_ord FROM "._BdStr(DBM).TB_DSH_COL." WHERE dshcol_dsh = id_dsh ORDER BY dshcol_ord DESC LIMIT 1 ) as _ord_ult,
						(SELECT COUNT(*) FROM "._BdStr(DBM).TB_DSH_COLTP_PRS." WHERE dshcoltpprs_dsh = id_dsh) AS _coltp_prs,
						(SELECT dsh_ord FROM "._BdStr(DBM).TB_DSH." WHERE dsh_us = ".SISUS_ID." $_fl_sub ORDER BY dsh_ord DESC LIMIT 1) AS _dsh_ord_ult
						FROM "._BdStr(DBM).TB_DSH."
							LEFT JOIN "._BdStr(DBM).TB_DSH_COL." ON dshcol_dsh = id_dsh
							LEFT JOIN "._BdStr(DBM).TB_DSH_COL_BX." ON dshcolbx_dshcol = id_dshcol
							LEFT JOIN "._BdStr(DBM).TB_SIS_COL_TP." ON dsh_coltp = id_coltp
							LEFT JOIN "._BdStr(DBM).TB_DSH_COLTP_PRS." ON dshcoltpprs_dsh = id_dsh
						WHERE id_dsh != '' $_fl_us {$_fl} ORDER BY dsh_ord, id_dsh, id_dshcolbx ASC";


		//$Vl['q'] = compress_code($query_DtRg);

		$DtRg = $__cnx->_qry($query_DtRg);

		if($DtRg){

			$Vl['ls'] = [];

			do{

				if(!isN($row_DtRg['id_dsh'])){

					//Version anterior
					$Vl['dsh_ord_ult'] = $row_DtRg['_dsh_ord_ult'];
					$Vl['qry'] = $row_DtRg['id_dsh'];

					/*$_tp = ["dt"=>"id_dsh", "ls"=>"dsh_ord"];
					foreach($_tp as $_k => $_v){

						$Vl[$_k][$row_DtRg[$_v]]['coltp_prs'] = $row_DtRg['_coltp_prs'];
						$Vl[$_k][$row_DtRg[$_v]]['ord_ult'] = $row_DtRg['_ord_ult'];
						$Vl[$_k][$row_DtRg[$_v]]['dsh_ord'] = $row_DtRg['dsh_ord'];
						$Vl[$_k][$row_DtRg[$_v]]['id'] = $row_DtRg['id_dsh'];
						$Vl[$_k][$row_DtRg[$_v]]['enc'] = $row_DtRg['dsh_enc'];
						$Vl[$_k][$row_DtRg[$_v]]['ord'] = $row_DtRg['dsh_ord'];
						$Vl[$_k][$row_DtRg[$_v]]['tot'] = $row_DtRg['coltp_v'];

						//-------------------- COLUMNAS PERSONALIZADAS --------------------//

						/*$Vl[$_k][$row_DtRg[$_v]]['c']['w']['1'] = $row_DtRg['coltp_w1'];
						$Vl[$_k][$row_DtRg[$_v]]['c']['w']['2'] = $row_DtRg['coltp_w2'];
						$Vl[$_k][$row_DtRg[$_v]]['c']['w']['3'] = $row_DtRg['coltp_w3'];
						$Vl[$_k][$row_DtRg[$_v]]['c']['w']['4'] = $row_DtRg['coltp_w4'];
						$Vl[$_k][$row_DtRg[$_v]]['c']['w']['5'] = $row_DtRg['coltp_w5'];
						$Vl[$_k][$row_DtRg[$_v]]['c']['w']['6'] = $row_DtRg['coltp_w6'];

						$Vl[$_k][$row_DtRg[$_v]]['c_prs']['w']['1'] = $row_DtRg['dshcoltpprs_w1'];
						$Vl[$_k][$row_DtRg[$_v]]['c_prs']['w']['2'] = $row_DtRg['dshcoltpprs_w2'];
						$Vl[$_k][$row_DtRg[$_v]]['c_prs']['w']['3'] = $row_DtRg['dshcoltpprs_w3'];
						$Vl[$_k][$row_DtRg[$_v]]['c_prs']['w']['4'] = $row_DtRg['dshcoltpprs_w4'];
						$Vl[$_k][$row_DtRg[$_v]]['c_prs']['w']['5'] = $row_DtRg['dshcoltpprs_w5'];
						$Vl[$_k][$row_DtRg[$_v]]['c_prs']['w']['6'] = $row_DtRg['dshcoltpprs_w6'];

						//-------------------- COLUMNAS --------------------//

						/*$Vl[$_k][$row_DtRg[$_v]]['col'][$row_DtRg['dshcol_ord']]['id'] = $row_DtRg['id_dshcol'];
						$Vl[$_k][$row_DtRg[$_v]]['col'][$row_DtRg['dshcol_ord']]['ord'] = $row_DtRg['dshcol_ord'];
						$Vl[$_k][$row_DtRg[$_v]]['col'][$row_DtRg['dshcol_ord']]['dsh'] = GtDshLs(array("tp"=>"dsh_prnt", "dsh_prnt"=>$row_DtRg['id_dshcol']));
						$Vl[$_k][$row_DtRg[$_v]]['col'][$row_DtRg['dshcol_ord']]['bx'][$row_DtRg['id_dshcolbx']] = $row_DtRg['id_dshcolbx'];
						$Vl[$_k][$row_DtRg[$_v]]['col'][$row_DtRg['dshcol_ord']]['col']['tp']['id'] = $row_DtRg['id_coltp'];
						$Vl[$_k][$row_DtRg[$_v]]['col'][$row_DtRg['dshcol_ord']]['col']['tp']['tt'] = $row_DtRg['coltp_tt'];
						$Vl[$_k][$row_DtRg[$_v]]['col'][$row_DtRg['dshcol_ord']]['col']['tp']['v'] = $row_DtRg['coltp_v'];

					}*/

					$Vl['dt'][$row_DtRg['id_dsh']]['dsh_ord_ult'] = $row_DtRg['_dsh_ord_ult'];
					$Vl['dt'][$row_DtRg['id_dsh']]['qry'] = $row_DtRg['id_dsh'];

					$Vl['dt'][$row_DtRg['id_dsh']]['coltp_prs'] = $row_DtRg['_coltp_prs'];
					$Vl['dt'][$row_DtRg['id_dsh']]['ord_ult'] = $row_DtRg['_ord_ult'];
					$Vl['dt'][$row_DtRg['id_dsh']]['dsh_ord'] = $row_DtRg['dsh_ord'];
					$Vl['dt'][$row_DtRg['id_dsh']]['id'] = $row_DtRg['id_dsh'];
					$Vl['dt'][$row_DtRg['id_dsh']]['enc'] = $row_DtRg['dsh_enc'];
					$Vl['dt'][$row_DtRg['id_dsh']]['ord'] = $row_DtRg['dsh_ord'];
					$Vl['dt'][$row_DtRg['id_dsh']]['tot'] = $row_DtRg['coltp_v'];


					$Vl['ls'][$row_DtRg['id_dsh']]['dsh_ord_ult'] = $row_DtRg['_dsh_ord_ult'];
					$Vl['ls'][$row_DtRg['id_dsh']]['qry'] = $row_DtRg['id_dsh'];

					$Vl['ls'][$row_DtRg['dsh_ord']]['coltp_prs'] = $row_DtRg['_coltp_prs'];
					$Vl['ls'][$row_DtRg['dsh_ord']]['ord_ult'] = $row_DtRg['_ord_ult'];
					$Vl['ls'][$row_DtRg['dsh_ord']]['dsh_ord'] = $row_DtRg['dsh_ord'];
					$Vl['ls'][$row_DtRg['dsh_ord']]['id'] = $row_DtRg['id_dsh'];
					$Vl['ls'][$row_DtRg['dsh_ord']]['enc'] = $row_DtRg['dsh_enc'];
					$Vl['ls'][$row_DtRg['dsh_ord']]['ord'] = $row_DtRg['dsh_ord'];
					$Vl['ls'][$row_DtRg['dsh_ord']]['tot'] = $row_DtRg['coltp_v'];

					//-------------------- COLUMNAS PERSONALIZADAS --------------------//

					$Vl['dt'][$row_DtRg['id_dsh']]['c']['w']['1'] = $row_DtRg['coltp_w1'];
					$Vl['dt'][$row_DtRg['id_dsh']]['c']['w']['2'] = $row_DtRg['coltp_w2'];
					$Vl['dt'][$row_DtRg['id_dsh']]['c']['w']['3'] = $row_DtRg['coltp_w3'];
					$Vl['dt'][$row_DtRg['id_dsh']]['c']['w']['4'] = $row_DtRg['coltp_w4'];
					$Vl['dt'][$row_DtRg['id_dsh']]['c']['w']['5'] = $row_DtRg['coltp_w5'];
					$Vl['dt'][$row_DtRg['id_dsh']]['c']['w']['6'] = $row_DtRg['coltp_w6'];

					$Vl['dt'][$row_DtRg['id_dsh']]['c_prs']['w']['1'] = $row_DtRg['dshcoltpprs_w1'];
					$Vl['dt'][$row_DtRg['id_dsh']]['c_prs']['w']['2'] = $row_DtRg['dshcoltpprs_w2'];
					$Vl['dt'][$row_DtRg['id_dsh']]['c_prs']['w']['3'] = $row_DtRg['dshcoltpprs_w3'];
					$Vl['dt'][$row_DtRg['id_dsh']]['c_prs']['w']['4'] = $row_DtRg['dshcoltpprs_w4'];
					$Vl['dt'][$row_DtRg['id_dsh']]['c_prs']['w']['5'] = $row_DtRg['dshcoltpprs_w5'];
					$Vl['dt'][$row_DtRg['id_dsh']]['c_prs']['w']['6'] = $row_DtRg['dshcoltpprs_w6'];


					$Vl['ls'][$row_DtRg['dsh_ord']]['c']['w']['1'] = $row_DtRg['coltp_w1'];
					$Vl['ls'][$row_DtRg['dsh_ord']]['c']['w']['2'] = $row_DtRg['coltp_w2'];
					$Vl['ls'][$row_DtRg['dsh_ord']]['c']['w']['3'] = $row_DtRg['coltp_w3'];
					$Vl['ls'][$row_DtRg['dsh_ord']]['c']['w']['4'] = $row_DtRg['coltp_w4'];
					$Vl['ls'][$row_DtRg['dsh_ord']]['c']['w']['5'] = $row_DtRg['coltp_w5'];
					$Vl['ls'][$row_DtRg['dsh_ord']]['c']['w']['6'] = $row_DtRg['coltp_w6'];

					$Vl['ls'][$row_DtRg['dsh_ord']]['c_prs']['w']['1'] = $row_DtRg['dshcoltpprs_w1'];
					$Vl['ls'][$row_DtRg['dsh_ord']]['c_prs']['w']['2'] = $row_DtRg['dshcoltpprs_w2'];
					$Vl['ls'][$row_DtRg['dsh_ord']]['c_prs']['w']['3'] = $row_DtRg['dshcoltpprs_w3'];
					$Vl['ls'][$row_DtRg['dsh_ord']]['c_prs']['w']['4'] = $row_DtRg['dshcoltpprs_w4'];
					$Vl['ls'][$row_DtRg['dsh_ord']]['c_prs']['w']['5'] = $row_DtRg['dshcoltpprs_w5'];
					$Vl['ls'][$row_DtRg['dsh_ord']]['c_prs']['w']['6'] = $row_DtRg['dshcoltpprs_w6'];


					//-------------------- COLUMNAS --------------------//

					$Vl['dt'][$row_DtRg['id_dsh']]['col'][$row_DtRg['dshcol_ord']]['id'] = $row_DtRg['id_dshcol'];
					$Vl['dt'][$row_DtRg['id_dsh']]['col'][$row_DtRg['dshcol_ord']]['ord'] = $row_DtRg['dshcol_ord'];
					$Vl['dt'][$row_DtRg['id_dsh']]['col'][$row_DtRg['dshcol_ord']]['dsh'] = GtDshLs(["tp"=>"dsh_prnt", "dsh_prnt"=>$row_DtRg['id_dshcol']]);
					$Vl['dt'][$row_DtRg['id_dsh']]['col'][$row_DtRg['dshcol_ord']]['bx'][$row_DtRg['id_dshcolbx']] = $row_DtRg['id_dshcolbx'];
					$Vl['dt'][$row_DtRg['id_dsh']]['col'][$row_DtRg['dshcol_ord']]['col']['tp']['id'] = $row_DtRg['id_coltp'];
					$Vl['dt'][$row_DtRg['id_dsh']]['col'][$row_DtRg['dshcol_ord']]['col']['tp']['tt'] = $row_DtRg['coltp_tt'];
					$Vl['dt'][$row_DtRg['id_dsh']]['col'][$row_DtRg['dshcol_ord']]['col']['tp']['v'] = $row_DtRg['coltp_v'];


					$Vl['ls'][$row_DtRg['dsh_ord']]['col'][$row_DtRg['dshcol_ord']]['id'] = $row_DtRg['id_dshcol'];
					$Vl['ls'][$row_DtRg['dsh_ord']]['col'][$row_DtRg['dshcol_ord']]['ord'] = $row_DtRg['dshcol_ord'];
					$Vl['ls'][$row_DtRg['dsh_ord']]['col'][$row_DtRg['dshcol_ord']]['dsh'] = GtDshLs(["tp"=>"dsh_prnt", "dsh_prnt"=>$row_DtRg['id_dshcol']]);
					$Vl['ls'][$row_DtRg['dsh_ord']]['col'][$row_DtRg['dshcol_ord']]['bx'][$row_DtRg['id_dshcolbx']] = $row_DtRg['id_dshcolbx'];
					$Vl['ls'][$row_DtRg['dsh_ord']]['col'][$row_DtRg['dshcol_ord']]['col']['tp']['id'] = $row_DtRg['id_coltp'];
					$Vl['ls'][$row_DtRg['dsh_ord']]['col'][$row_DtRg['dshcol_ord']]['col']['tp']['tt'] = $row_DtRg['coltp_tt'];
					$Vl['ls'][$row_DtRg['dsh_ord']]['col'][$row_DtRg['dshcol_ord']]['col']['tp']['v'] = $row_DtRg['coltp_v'];

				}

			}while($row_DtRg = $DtRg->fetch_assoc());

		}

		$__cnx->_clsr($DtRg);

		return(_jEnc($Vl));

	}

	function GtDshColBxDt($p=NULL){

		global $__cnx;

		if(!isN($p['id']) && !isN($p['id'])){ $_fl = "AND id_dshcolbx = ".$p['id']." "; }
		if(!isN($p['dsh_col']) && !isN($p['dsh_col'])){ $_fl = "AND dshcolbx_dshcol = ".$p['dsh_col']." "; }
		$query_DtRg = "SELECT * FROM dsh_col_bx WHERE id_dshcolbx != '' $_fl";
		$DtRg = $__cnx->_qry($query_DtRg);

		if($DtRg){
			do{
				$Vl[$row_DtRg['id_dshcolbx']]['id'] = $row_DtRg['id_dshcolbx'];
				$Vl[$row_DtRg['id_dshcolbx']]['tt'] = $row_DtRg['dshcolbx_tt'];
				$Vl[$row_DtRg['id_dshcolbx']]['dsh_col'] = $row_DtRg['dshcolbx_dshcol'];
			}while($row_DtRg = $DtRg->fetch_assoc());
		}

		$__cnx->_clsr($DtRg);

		return(_jEnc($Vl));

	}


	function GtVtexDt($p){

		global $__cnx;

		$Vl['e'] = "no";

		if(!isN($p['id'])){

			if($p['t'] == 'enc'){
				$__f = 'vtex_enc'; $__ft = 'text';
			}else{
				$__f = 'id_vtex'; $__ft = 'int';
			}

			$query_DtRg = sprintf("	SELECT *,
											AES_DECRYPT(vtex_sndbx_key, '".ENCRYPT_PASSPHRASE."') AS vtex_sndbx_key,
											AES_DECRYPT(vtex_sndbx_tkn, '".ENCRYPT_PASSPHRASE."') AS vtex_sndbx_tkn,
											AES_DECRYPT(vtex_prd_key, '".ENCRYPT_PASSPHRASE."') AS vtex_prd_key,
											AES_DECRYPT(vtex_prd_tkn, '".ENCRYPT_PASSPHRASE."') AS vtex_prd_tkn
									FROM "._BdStr(DBT).TB_VTEX."
									WHERE ".$__f." = %s
									LIMIT 1", GtSQLVlStr($p['id'], $__ft));

			$DtRg = $__cnx->_qry($query_DtRg);

			if($DtRg){

				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;

				$Vl['tot'] = $Tot_DtRg;

				if($Tot_DtRg > 0){

					$Vl = [
						'id'=>ctjTx($row_DtRg['id_vtex'],'in'),
						'enc'=>ctjTx($row_DtRg['vtex_enc'],'in'),
						'nm'=>ctjTx($row_DtRg['vtex_nm'],'in'),
						'sndbx'=>[
							'e'=>mBln($row_DtRg['vtex_sndbx']),
							'acc'=>ctjTx($row_DtRg['vtex_sndbx_acc'],'in'),
							'key'=>ctjTx($row_DtRg['vtex_sndbx_key'],'in'),
							'tkn'=>ctjTx($row_DtRg['vtex_sndbx_tkn'],'in')
						],
						'prd'=>[
							'acc'=>ctjTx($row_DtRg['vtex_prd_acc'],'in'),
							'key'=>ctjTx($row_DtRg['vtex_prd_key'],'in'),
							'tkn'=>ctjTx($row_DtRg['vtex_prd_tkn'],'in')
						],
						'e'=>mBln($row_DtRg['vtex_e'])
					];

				}

			}

			$__cnx->_clsr($DtRg);
			return _jEnc($Vl);

		}

	}



	function GtVtexCmpgDt($_p=NULL){

		global $__cnx;

		$Vl['e'] = 'no';

		if(!isN($_p['id'])){

			if($_p['tp'] == 'enc'){ $__f = 'vtexcmpg_enc'; $__ft = 'text'; }
			elseif($_p['tp'] == 'id'){ $__f = 'id_vtexcmpg'; $__ft = 'text'; }
			elseif($_p['tp'] == 'pml'){ $__f = 'vtexcmpg_pml'; $__ft = 'text'; }
			else{ $__f = 'id_vtexcmpg'; $__ft = 'int'; }

			$query_DtRg = sprintf('	SELECT id_vtexcmpg, vtexcmpg_enc, vtex_cl, vtexcmpg_nm, vtexcmpg_pml,
											vtexcmpg_ec_rfd, vtexcmpg_ec_rfd_in, vtexcmpg_ec_ins, vtexcmpg_ec_rfd_coup,
											vtexcmpg_vlr_mnd, vtexcmpg_vlr_cod, id_vtex, vtexcmpg_vtex

									FROM '._BdStr(DBT).TB_VTEX_CMPG.'
										INNER JOIN '._BdStr(DBT).TB_VTEX.' ON vtexcmpg_vtex = id_vtex
								    WHERE '.$__f.' = %s LIMIT 1', GtSQLVlStr($_p['id'], $__ft));

			$DtRg = $__cnx->_qry($query_DtRg);

			if($DtRg){

				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;

				if($Tot_DtRg > 0){

					$Vl['e'] = 'ok';
					$Vl['id'] = $row_DtRg['id_vtexcmpg'];
					$Vl['pml'] = ctjTx($row_DtRg['vtexcmpg_pml'],'in');
					$Vl['nm'] = ctjTx($row_DtRg['vtexcmpg_nm'],'in');
					$Vl['enc'] = ctjTx($row_DtRg['vtexcmpg_enc'],'in');
					$Vl['acc']['cl'] = ctjTx($row_DtRg['vtex_cl'],'in');
					$Vl['acc']['id'] = ctjTx($row_DtRg['id_vtex'],'in');

					$Vl['ec']['rfd'] = ctjTx($row_DtRg['vtexcmpg_ec_rfd'],'in');
					$Vl['ec']['rfd_in'] = ctjTx($row_DtRg['vtexcmpg_ec_rfd_in'],'in');
					$Vl['ec']['cnt'] = ctjTx($row_DtRg['vtexcmpg_ec_ins'],'in');
					$Vl['ec']['rfd_bn'] = ctjTx($row_DtRg['vtexcmpg_ec_rfd_coup'],'in');

					$Vl['vlr']['mnd'] = ctjTx($row_DtRg['vtexcmpg_vlr_mnd'],'in');
					$Vl['vlr']['cod'] = ctjTx($row_DtRg['vtexcmpg_vlr_cod'],'in');

				}

			}else{
				$Vl['w'] = $__cnx->c_r->error;
			}

			$__cnx->_clsr($DtRg);
		}else{
			$Vl['w'] = 'No all data';
		}

		return(_jEnc($Vl));
	}

	function GtEmpDt($Id){

		if(!isN($Id)){

			global $__cnx;

			$c_DtRg = "-1";if (isset($Id)){$c_DtRg = $Id;}

			$Dt_Logo = ", (SELECT fllorg_logo FROM  "._BdStr(DBM).TB_FLL_ORG." WHERE fllorg_web = SUBSTRING_INDEX(SUBSTRING_INDEX(REPLACE(REPLACE(LOWER(emp_web), 'https://', ''), 'http://', ''), '/', 1), '?', 1) ) AS __logo ";

			$Dt_Tot_Cnt = ", (SELECT COUNT(*) FROM  ".TB_EMP_CNT." WHERE empcnt_emp = id_emp) AS __tot_cnt ";
			$Dt_Tot_Vst = ", (SELECT COUNT(*) FROM  ".MDL_EMP_VST_BD.", ".TB_EMP_CNT." WHERE empvst_cnt = id_empcnt AND empcnt_emp = id_emp) AS __tot_vst ";
			$Dt_Tot_Ofr = ", (SELECT COUNT(*) FROM  ".MDL_EMP_OFR_BD." WHERE ofr_emp = id_emp) AS __tot_ofr ";

			$query_DtRg = sprintf("SELECT * $Dt_Logo $Dt_Tot_Cnt $Dt_Tot_Vst $Dt_Tot_Ofr,
											 _c.sisslc_tt AS empest_nm

									FROM ".MDL_EMP_BD."
										 INNER JOIN "._BdStr(DBM).MDL_SIS_CD_BD." _a ON emp_cd = id_siscd
										 INNER JOIN "._BdStr(DBM).TB_SIS_SLC." _c ON emp_est = _c.id_sisslc
									WHERE id_emp = %s", GtSQLVlStr($c_DtRg,'int'));
			$DtRg = $__cnx->_qry($query_DtRg);

			if($DtRg){

				//echo $query_DtRg;
				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;

				if($Tot_DtRg > 0){

					$Vl['id'] = $row_DtRg['id_emp'];
					$Vl['nit'] = $row_DtRg['emp_nit'];
					$Vl['rs'] = ctjTx($row_DtRg['emp_rs'],'in');
					$Vl['dir'] = ctjTx($row_DtRg['emp_dir'],'in');
					$Vl['fnt'] = ctjTx($row_DtRg['emp_fnt'],'in');
					$Vl['cd'] = ctjTx($row_DtRg['cd_tt'],'in');
					$Vl['est'] = ctjTx($row_DtRg['empest_nm'],'in');
					$Vl['web'] = ctjTx($row_DtRg['emp_web'],'in');

					$Vl['tot_cnt'] = ctjTx($row_DtRg['__tot_cnt'],'in');
					$Vl['tot_vst'] = ctjTx($row_DtRg['__tot_vst'],'in');
					$Vl['tot_ofr'] = ctjTx($row_DtRg['__tot_ofr'],'in');

					$Vl['logo_s'] = _ImVrs(['img'=>$row_DtRg['__logo'], 'f'=>DMN_FLE_FLL ]);
					$Vl['clr'] = ctjTx($row_DtRg['emp_clr'],'in');

					$Vl['fll'] = Gt_FllCnt([ 't'=>'org', 'id'=>$row_DtRg['emp_web'], 'f'=>'tag']);
				}

			}

			$__cnx->_clsr($DtRg);

			return _jEnc($Vl);
		}
	}

	function GtEmpCntDt($Id){

		global $__cnx;

		if(!isN($Id)){
			$c_DtRg = "-1";if (isset($Id)){$c_DtRg = $Id;}
			$query_DtRg = sprintf('SELECT * FROM '.TB_EMP_CNT.' WHERE id_empcnt = %s LIMIT 1', GtSQLVlStr($c_DtRg,'int'));
			$DtRg = $__cnx->_qry($query_DtRg);

			if($DtRg){

				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;

				if($Tot_DtRg > 0){
					$_emp_dt = GtEmpDt($row_DtRg['empcnt_emp']);

					$Vl['id'] = $row_DtRg['id_empcnt'];
					$Vl['nm'] = ctjTx($row_DtRg['empcnt_nm'],'in');
					$Vl['ap'] = ctjTx($row_DtRg['empcnt_ap'],'in');

					$Vl['cel'] = ctjTx($row_DtRg['empcnt_cel'],'in');
					$Vl['tel'] = ctjTx($row_DtRg['empcnt_tel'],'in');
					$Vl['ext'] = ctjTx($row_DtRg['empcnt_ext'],'in');
					$Vl['depto'] = ctjTx($row_DtRg['empcnt_depto'],'in');
					$Vl['crg'] = ctjTx($row_DtRg['empcnt_crg'],'in');
					$Vl['eml'] = ctjTx($row_DtRg['empcnt_mail'],'in');

					$Vl['emp'] = GtEmpDt($_dt_emp->emp);


					$Vl['nm_fll'] = ctjTx($row_DtRg['empcnt_nm'].' '.$row_DtRg['empcnt_ap'],'in');

					$Vl['emp_rs'] = $_emp_dt->rs;
				}

			}

			$__cnx->_clsr($DtRg);

			return _jEnc($Vl);
		}
	}

	function GtSisFntDt($p=NULL){

		global $__cnx;

		if(!isN($p)){

			if(!isN($p['id'])){
				if(!isN($p['enc'])){
					$__fl .= " AND sisfnt_enc = ".GtSQLVlStr($p['enc'],'text')." ";
				}else{
					$__fl .= " AND id_sisfnt = ".GtSQLVlStr($p['id'],'int')." ";
				}
			}

			$query_DtRg = sprintf('SELECT * FROM '.DBM.'.'.TB_SIS_FNT.' WHERE id_sisfnt != "" '.$__fl.' LIMIT 1', GtSQLVlStr($c_DtRg, $__ft));
			$DtRg = $__cnx->_qry($query_DtRg);

			if($DtRg){

				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;

				if($Tot_DtRg > 0){
					$Vl['id'] = $row_DtRg['id_sisfnt'];
					$Vl['nm'] = ctjTx($row_DtRg['sisfnt_tt'],'in');
				}

			}

			$__cnx->_clsr($DtRg);

			return _jEnc($Vl);
		}
	}

	function GtSisMdDt($p){

		global $__cnx;

		if( !isN($p['id']) || !isN($p['dfl']) ){

			if($p['t'] == 'enc'){
				$__fl .= " AND sismd_enc = ".GtSQLVlStr($p['id'],'text')." ";
			}else{
				$__fl .= " AND id_sismd = ".GtSQLVlStr($p['id'],'int')." ";
			}

			//TRABAJAR MEDIO POR DEFECTO - if( !isN($p['dfl']) ){ $__fl .= " AND id_sismd IN (SELECT FROM ".TB_SIS_MD_CL." ".GtSQLVlStr($p['dfl'],'text').") "; }



			$query_DtRg = sprintf('SELECT * FROM '._BdStr(DBM).TB_SIS_MD.' WHERE id_sismd IS NOT NULL '.$__fl.' LIMIT 1');
			$DtRg = $__cnx->_qry($query_DtRg);

			if($DtRg){

				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;

				if($Tot_DtRg > 0){
					$Vl['id'] = $row_DtRg['id_sismd'];
					$Vl['nm'] = ctjTx($row_DtRg['sismd_tt'],'in');
					$Vl['enc'] = ctjTx($row_DtRg['sismd_enc'],'in');
					$Vl['cdg'] = ctjTx($row_DtRg['sismd_cdg'],'in');
					$Vl['dflt'] = mBln($row_DtRg['sismd_dflt']);
					$Vl['sndi'] = mBln($row_DtRg['sismd_sndi']);

					if(!isN($row_DtRg['sismd_img'])){
						$Vl['img_chk'] = 'ok';
						$Vl['img'] = DMN_FLE_SIS_MD.$row_DtRg['sismd_img'];
					}else{
						$Vl['img_chk'] = 'no';
						$Vl['img'] = DMN_IMG_ESTR_SVG.'scl_mn_chkno.svg';
					}
				}

			}

			$__cnx->_clsr($DtRg);


		}else{
			$Vl['img'] = DMN_IMG_ESTR_SVG.'broken.svg';
		}

		return(_jEnc($Vl));

	}

	function GtSisColTpDt($p=NULL){

		global $__cnx;

		if(!isN($p['id']) && !isN($p['id'])){ $_fl .= "AND id_coltp = ".$p['id']." "; }
		if(!isN($p['v']) && !isN($p['v'])){ $_fl .= "AND coltp_v = ".$p['v']." LIMIT 1 "; }

		$query_DtRg = "	SELECT id_coltp, coltp_enc, coltp_tt, coltp_v, coltp_w1, coltp_w2, coltp_w3, coltp_w4, coltp_w5, coltp_w6
						FROM "._BdStr(DBM).TB_SIS_COL_TP."
						WHERE id_coltp != '' $_fl";

		$DtRg = $__cnx->_qry($query_DtRg);

		if($DtRg){

			do{

				if(!isN($row_DtRg['id_coltp'])){

					$Vl[$row_DtRg['id_coltp']]['id'] = $row_DtRg['id_coltp'];
					$Vl[$row_DtRg['id_coltp']]['enc'] = $row_DtRg['coltp_enc'];
					$Vl[$row_DtRg['id_coltp']]['tt'] = $row_DtRg['coltp_tt'];
					$Vl[$row_DtRg['id_coltp']]['v'] = $row_DtRg['coltp_v'];

					$Vl[$row_DtRg['id_coltp']]['w']['1'] = $row_DtRg['coltp_w1'];
					$Vl[$row_DtRg['id_coltp']]['w']['2'] = $row_DtRg['coltp_w2'];
					$Vl[$row_DtRg['id_coltp']]['w']['3'] = $row_DtRg['coltp_w3'];
					$Vl[$row_DtRg['id_coltp']]['w']['4'] = $row_DtRg['coltp_w4'];
					$Vl[$row_DtRg['id_coltp']]['w']['5'] = $row_DtRg['coltp_w5'];
					$Vl[$row_DtRg['id_coltp']]['w']['6'] = $row_DtRg['coltp_w6'];
				}

			}while($row_DtRg = $DtRg->fetch_assoc());

		}

		$__cnx->_clsr($DtRg);

		return(_jEnc($Vl));

	}

	function GtRowDt($id=NULL, $tp=NULL){

		global $__cnx;

		$_fl_us = "AND row_us = ".SISUS_ID."";
		if($tp['tp']=="row_mod"){ $_fl = "AND id_row = ".$id." "; }
		$query_DtRg = "SELECT *, (SELECT id_row FROM row ORDER BY id_row DESC LIMIT 1) as _ult  FROM row WHERE id_row != '' $_fl $_fl_us";
		$DtRg = $__cnx->_qry($query_DtRg);

		if($DtRg){

			do{
				$Vl[$row_DtRg['id_row']]['k'] = $row_DtRg['row_k'];
				$Vl[$row_DtRg['id_row']]['id'] = $row_DtRg['id_row'];
				$Vl[$row_DtRg['id_row']]['html'] = $row_DtRg['row_html'];
				$Vl[$row_DtRg['id_row']]['tt'] = $row_DtRg['row_tt'];
				$Vl['ult'] = $row_DtRg['_ult'];
				$Vl['html'] = $row_DtRg['row_html'];
			}while($row_DtRg = $DtRg->fetch_assoc());

		}

		$__cnx->_clsr($DtRg);

		return(_jEnc($Vl));

	}

	function GtGrphRowDt($id=NULL, $tp=NULL){

		global $__cnx;

		$_fl_us = "AND dshgrphbx_us = ".SISUS_ID."";
		if($tp['tp'] == "grph_bx_mod"){ $_fl = "AND dshgrphbx_bx = ".$id." "; }
		$query_DtRg = "SELECT * FROM "._BdStr(DBM).TB_DSH_GRPH_BX.", "._BdStr(DBM).TB_DSH_MTRC.", "._BdStr(DBM).TB_DSH_DMS_MTRC.", "._BdStr(DBM).TB_DSH_DMS.", "._BdStr(DBM).TB_DSH_GRPH_DMS."
		 	WHERE id_dshgrphbx != ''
		 	AND dshgrphbx_mtrc = id_dshmtrc
		 	AND dshdmsmtrc_mtrc = id_dshmtrc
		 	AND dshdmsmtrc_dms = id_dshdms
		 	AND dshgrphdms_dms = id_dshdms
		 	$_fl $_fl_us";
		$DtRg = $__cnx->_qry($query_DtRg);

		if($DtRg){

			$row_DtRg = $DtRg->fetch_assoc();

			do{
				if(!isN($row_DtRg['dshgrphbx_bx'])){
					//Anterior id_dshgrphbx
					$Vl[$row_DtRg['dshgrphbx_bx']]['id'] = $row_DtRg['id_dshgrphbx'];
					$Vl[$row_DtRg['dshgrphbx_bx']]['enc'] = $row_DtRg['dshgrphbx_enc'];
					$Vl[$row_DtRg['dshgrphbx_bx']]['tt'] = ctjTx($row_DtRg['dshgrphbx_tt'], 'in');
					$Vl[$row_DtRg['dshgrphbx_bx']]['mtrc'] = $row_DtRg['dshgrphbx_mtrc'];
					$Vl[$row_DtRg['dshgrphbx_bx']]['dms'] = $row_DtRg['id_dshdms'];
					$Vl[$row_DtRg['dshgrphbx_bx']]['grph'] = $row_DtRg['dshgrphbx_grph'];
					$Vl[$row_DtRg['dshgrphbx_bx']]['bx'] = $row_DtRg['dshgrphbx_bx'];
					$Vl[$row_DtRg['dshgrphbx_bx']]['id_grphbx'] = $row_DtRg['id_dshgrphbx'];
					$Vl[$row_DtRg['dshgrphbx_bx']]['qry'] = $row_DtRg['dshgrphbx_qry'];

					$Vl[$row_DtRg['dshgrphbx_bx']]['clr_bc'] = $row_DtRg['dshgrphbx_clr_bc'];
					$Vl[$row_DtRg['dshgrphbx_bx']]['clr'] = $row_DtRg['dshgrphbx_clr'];
				}

			}while($row_DtRg = $DtRg->fetch_assoc());

		}

		$__cnx->_clsr($DtRg);

		return(_jEnc($Vl));

	}

		function Chk_SlcF($_p=NULL){

			global $__cnx;

			if(is_array($_p)){
				if($_p['cl'] == 'ok'){
					$__bd = TB_CL_SLC_F;
				}else{
					$__bd = TB_SIS_SLC_F;
				}

				$query_DtRg = sprintf("SELECT * FROM ".DBM.".$__bd WHERE sisslcf_slc = (SELECT id_sisslc FROM ".DBM."._sis_slc WHERE sisslc_enc = %s) AND sisslcf_f = %s", GtSQLVlStr(ctjTx($_p['slc'],'out'), "text"), GtSQLVlStr($_p['f'], "int") );

				$DtRg = $__cnx->_qry($query_DtRg);

				if($DtRg){

					$row_DtRg = $DtRg->fetch_assoc();
					$Tot_DtRg = $DtRg->num_rows;

					$Vl['tot'] = $Tot_DtRg;

					if($Tot_DtRg > 0){
						$Vl['id'] = $row_DtRg['id_sisslcf'];
						$Vl['e'] = 'ok';
					}else{
						$Vl['e'] = 'no';
						//$Vl['qry'] =  $query_DtRg;
					}

				}

				$__cnx->_clsr($DtRg);

				return _jEnc($Vl);

			}
		}

		function GtSmsCmpgDt($_p=NULL){

			global $__cnx;

			if(!isN($_p['id'])){

				if(!isN($_p['bd'])){ $__bd = _BdStr($_p['bd']); }

				if($_p['t'] == 'enc'){ $__f = 'smscmpg_enc'; $__ft = 'text'; }else{ $__f = 'id_smscmpg'; $__ft = 'int'; }


				$query_DtRg = sprintf("SELECT *,
											 (  SELECT DISTINCT COUNT(*)
											 	FROM ".$__bd.".".MDL_TB_SMS_CMPG_UP_BD.", ".DB_PRC.".".MDL_UP_COL_BD."
											 	WHERE upcol_up = smscmpgup_up AND smscmpgup_cmpg = id_smscmpg
											 ) AS ___up_tot_in,
											 (  SELECT DISTINCT COUNT(*)
											 	FROM ".$__bd.".".MDL_TB_SMS_CMPG_UP_BD.", ".DB_PRC.".".MDL_UP_COL_BD."
											 	WHERE upcol_up = smscmpgup_up AND smscmpgup_cmpg = id_smscmpg AND upcol_est = 615
											 ) AS ___up_tot_w,
											 (  SELECT DISTINCT COUNT(*)
											 	FROM ".$__bd.".".MDL_TB_SMS_CMPG_UP_BD.", ".DB_PRC.".".MDL_UP_COL_BD."
											 	WHERE upcol_up = smscmpgup_up AND smscmpgup_cmpg = id_smscmpg AND upcol_est = 352
											 ) AS ___up_tot_l,
											 (  SELECT DISTINCT COUNT(*)
											 	FROM ".$__bd.".".MDL_TB_SMS_CMPG_UP_BD.", ".DB_PRC.".".MDL_UP_COL_BD."
											 	WHERE upcol_up = smscmpgup_up AND smscmpgup_cmpg = id_smscmpg AND upcol_est = 353
											 ) AS ___up_tot_p,


										     (SELECT smscmpgsgm_sgm FROM ".MDL_TB_SMS_CMPG_SGM_BD." WHERE smscmpgsgm_cmpg = id_smscmpg) AS ___sgm_rlc,

										     (SELECT DISTINCT COUNT(*) FROM "._BdStr(DBM).MDL_SMS_SND_CMPG_BD." WHERE smssndcmpg_cmpg = id_smscmpg) AS ___btch_tot_in,

										     (SELECT DISTINCT COUNT(*)
										      FROM "._BdStr(DBM).MDL_SMS_SND_CMPG_BD.", ".$__bd.".".TB_SMS_SND."
										      WHERE smssndcmpg_snd = id_smssnd AND smssndcmpg_cmpg = id_smscmpg) AS ___btch_tot_l,

										     (SELECT DISTINCT COUNT(*)
										      FROM "._BdStr(DBM).MDL_SMS_SND_CMPG_BD.", ".$__bd.".".TB_SMS_SND."
										      WHERE smssndcmpg_snd = id_smssnd AND smssndcmpg_cmpg = id_smscmpg AND smssnd_est = 1) AS ___btch_tot_snd,

										     (SELECT DISTINCT COUNT(*)
										      FROM "._BdStr(DBM).MDL_SMS_SND_CMPG_BD.", ".$__bd.".".TB_SMS_SND."
										      WHERE smssndcmpg_snd = id_smssnd AND smssndcmpg_cmpg = id_smscmpg AND smssnd_est = 2) AS ___btch_tot_p,

										     (SELECT DISTINCT COUNT(*)
										      FROM "._BdStr(DBM).MDL_SMS_SND_CMPG_BD.", ".$__bd.".".TB_SMS_SND."
										      WHERE smssndcmpg_snd = id_smssnd AND smssndcmpg_cmpg = id_smscmpg AND smssnd_est = 3) AS ___btch_tot_w

									   FROM "._BdStr(DBM).MDL_TB_SMS_CMPG_BD."
									   WHERE {$__f} = %s", GtSQLVlStr($_p['id'], $__ft));
				//echo $query_DtRg;
				$DtRg = $__cnx->_qry($query_DtRg);

				if($DtRg){

					//echo $query_DtRg;
					$row_DtRg = $DtRg->fetch_assoc();
					$Tot_DtRg = $DtRg->num_rows;

					if($Tot_DtRg > 0){

						$Vl['e'] = 'ok';
						$Vl['id'] = $row_DtRg['id_smscmpg'];
						$Vl['est'] = $row_DtRg['smscmpg_est'];
						$Vl['enc'] = $row_DtRg['smscmpg_enc'];
						$Vl['nm'] = ctjTx($row_DtRg['smscmpg_nm'],'in');
						$Vl['msj'] = ctjTx($row_DtRg['smscmpg_msj'],'in');
						$Vl['p_f'] = ctjTx($row_DtRg['smscmpg_p_f'],'in');
						$Vl['p_h'] = ctjTx($row_DtRg['smscmpg_p_h'],'in');
						$Vl['fi'] = ctjTx($row_DtRg['smscmpg_fi'],'in');

						//$Vl['lsts'] = GtSmsLstsDt(array('id'=>$row_DtRg['smscmpg_lsts']));
						//$Vl['sndr'] = GtSisTelDt(array('id'=>$row_DtRg['smscmpg_sndr']));

						$Vl['ls']['snd'] = GtSmsCmpgSndLs(['cmpg'=>$row_DtRg['id_smscmpg'], 'lmt'=>3]);
						$Vl['rpt'] = GtSmsCmpgSndRpt(['cmpg'=>$row_DtRg['id_smscmpg'] ]);


						$Vl['up']['in'] = $row_DtRg['___up_tot_in']; // En Excel
						$Vl['up']['p'] = $row_DtRg['___up_tot_p']; // En proceso
						$Vl['up']['w'] = $row_DtRg['___up_tot_w']; // Con errores
						$Vl['up']['l'] = $row_DtRg['___up_tot_l']; // Cargados


						$Vl['btch']['l'] = $row_DtRg['___btch_tot_l'];
						$Vl['btch']['in'] = $row_DtRg['___btch_tot_in'];
						$Vl['btch']['snd'] = $row_DtRg['___btch_tot_snd']; //Enviados
						$Vl['btch']['p'] = $row_DtRg['___btch_tot_p'];
						$Vl['btch']['w'] = $row_DtRg['___btch_tot_w'];


					}else{
						$Vl['e'] = 'no';
					}

				}

				$__cnx->_clsr($DtRg);
				return _jEnc($Vl);

			}

		}

		function __LsDt($p=NULL){

			global $__cnx;
			$_prvt = $p['prvt'];

			$Vl['e'] = 'no';

			if(is_array($p)){

				if(!isN($p['max'])){ $__fl .= " LIMIT ".$p['max']." "; }

				if(!isN($p['k'])){ $__fli .= sprintf(" AND sisslctp_key = %s ", GtSQLVlStr($p['k'], "text")); }

				if(!isN($p['id'])){

					$__frmt = 's'; // Formato Sencillo
					if($p['no_lmt']!='ok'){ $__fl .= " LIMIT 1"; }

					if($p['tp'] == 'enc'){
						$__fli = sprintf(" AND sisslc_enc = %s ", GtSQLVlStr($p['id'], "text"));
					}else{
						$__fli = sprintf(" AND id_sisslc = %s ", GtSQLVlStr($p['id'], "int"));
					}
				}

				if($p['attr'] != ''){ $__frmt = 's'; $__fli .= sprintf(" AND sisslctpf_key = %s ", GtSQLVlStr($p['attr'], "text")); }
				if($p['f_vl'] != ''){ $__fli .= sprintf(" AND sisslcf_vl = %s ", GtSQLVlStr($p['f_vl'], "text")); }
				if($p['rnd'] != ''){ $_o_by = ' RAND() '; }else{ $_o_by = ' id_sisslctp DESC '; }

				$__bd = _BdStr(DBM).TB_SIS_SLC;
				$__bd2 = _BdStr(DBM).TB_SIS_SLC_TP;
				$__bd3 = _BdStr(DBM).TB_SIS_SLC_F;
				$__bd4 = _BdStr(DBM).TB_SIS_SLC_TP_F;

				if(!isN($p['cl'])){ $__fli .= sprintf(" AND id_sisslc IN ( SELECT sisslccl_sisslc
																			FROM "._BdStr(DBM).TB_SIS_SLC_CL."
																			WHERE sisslccl_cl=%s) ", GtSQLVlStr($p['cl'], "text")); }


				if(!isN($p['mdl_s_tp'])){ $__fli .= sprintf(" AND id_sisslc IN ( SELECT sisslcmdlstp_sisslc
																			FROM "._BdStr(DBM).TB_SIS_SLC_MDLSTP."
																			WHERE sisslcmdlstp_mdlstp=(
																										SELECT
																											id_mdlstp
																										FROM
																											"._BdStr(DBM).TB_MDL_S_TP."
																										WHERE
																											mdlstp_tp = %s
																									) ) ", GtSQLVlStr($p['mdl_s_tp'], "text")); }
				$Ls_Qry = sprintf("
							SELECT 	id_sisslc, id_sisslcf, sisslc_enc, sisslc_tp,
									sisslctpf_tpd, sisslcf_enc, sisslc_cns, sisslctp_key,
									sisslctpf_key, sisslc_tt, sisslc_img, sisslctp_img, sisslcf_vl
							FROM ".$__bd."
								 INNER JOIN ".$__bd2." ON sisslc_tp = id_sisslctp
								 LEFT JOIN ".$__bd3." ON sisslcf_slc = id_sisslc
								 LEFT JOIN ".$__bd4." ON sisslcf_f = id_sisslctpf
							WHERE id_sisslctp != '' {$__fli}
							ORDER BY
								CASE WHEN sisslctp_ord = 1 AND sisslctp_ord_desc = 1 THEN sisslc_ord END DESC,
								CASE WHEN sisslctp_ord = 1 AND sisslctp_ord_desc = 2 THEN sisslc_ord END ASC,
								CASE WHEN sisslctp_ord = 2 AND sisslctp_ord_desc = 2 THEN sisslc_tt END ASC,
								CASE WHEN sisslctp_ord = 2 AND sisslctp_ord_desc = 1 THEN sisslc_tt END DESC {$__fl}");

				$Ls = $__cnx->_qry($Ls_Qry);

				//$Vl['q'] = compress_code($Ls_Qry);

				if($Ls){

					$row_Ls = $Ls->fetch_assoc();
					$Tot_Ls = $Ls->num_rows;

					$Vl['tot'] = $Tot_Ls;

					if($Tot_Ls > 0){

						if($_prvt!='ok'){ $Vl['id'] = $row_Ls['id_sisslcf']; }

						$Vl['e'] = 'ok';

						do{

							if(!isN($row_Ls['id_sisslc'])){

								$__key_ls = $row_Ls['sisslctp_key'];
								$__key_f_ls = $row_Ls['sisslctpf_key'];
								$__key_id = $row_Ls['id_sisslc'];

								//$Vl['tmp-s'] = $__frmt;

								if($__frmt == 's'){

									if($_prvt!='ok'){ $Vl['d']['id'] = ctjTx($row_Ls['id_sisslc'],'in'); }
									$Vl['d']['tt'] = ctjTx($row_Ls['sisslc_tt'],'in');
									$Vl['d']['enc'] = ctjTx($row_Ls['sisslc_enc'],'in');
									$Vl['d']['cns'] = ctjTx($row_Ls['sisslc_cns'],'in');

									if(!isN($row_Ls['sisslc_img'])){ $Vl['d']['img'] = DMN_FLE_SIS_SLC.ctjTx($row_Ls['sisslc_img'],'in'); }
									elseif(!isN($row_Ls['sisslctp_img'])){ $Vl['d']['img'] = DMN_FLE_SIS_SLC_TP.ctjTx($row_Ls['sisslctp_img'],'in'); }

									//echo h1($__key_f_ls.'->'.$row_Ls['sisslctpf_tpd'].HTML_BR);

									if($_prvt!='ok'){ $Vl['d'][$__key_f_ls]['id'] = ctjTx($row_Ls['id_sisslcf'],'in'); }
									$Vl['d'][$__key_f_ls]['enc'] = ctjTx($row_Ls['sisslcf_enc'],'in');

									//$Vl['d'][$__key_f_ls]['vl'] = ctjTx($row_Ls['sisslcf_vl'],'in');

									if($row_Ls['sisslctpf_tpd'] == 11){
										$Vl['d'][$__key_f_ls]['vl'] = _jBty([ 't'=>'o', 'v'=>ctjTx($row_Ls['sisslcf_vl'],'in','',['html'=>'ok','schr'=>'no','nl2'=>'no','sslh'=>'no','qte'=>'no']) ]);
									}elseif($row_Ls['sisslctpf_tpd'] == 10){
										$Vl['d'][$__key_f_ls]['vl'] = _jBty([ 't'=>'o', 'v'=>ctjTx($row_Ls['sisslcf_vl'],'in') ]);
									}elseif($row_Ls['sisslctpf_tpd'] == 7){
										$Vl['d'][$__key_f_ls]['vl'] = ctjTx($row_Ls['sisslcf_vl'],'in','',['html'=>'ok','schr'=>'no','nl2'=>'no'] );
									}else{
										$Vl['d'][$__key_f_ls]['vl'] = ctjTx($row_Ls['sisslcf_vl'],'in','',['html'=>'ok']);
									}

								}else{

									if($_prvt!='ok'){ $Vl['ls'][$__key_ls][$__key_id]['id'] = $__key_id; }
									$Vl['ls'][$__key_ls][$__key_id]['tt'] = ctjTx($row_Ls['sisslc_tt'],'in');
									$Vl['ls'][$__key_ls][$__key_id]['enc'] = ctjTx($row_Ls['sisslc_enc'],'in');
									$Vl['ls'][$__key_ls][$__key_id]['cns'] = ctjTx($row_Ls['sisslc_cns'],'in');

									if($row_Ls['sisslc_img'] != ''){
										$Vl['ls'][$__key_ls][$__key_id]['img'] = DMN_FLE_SIS_SLC.ctjTx($row_Ls['sisslc_img'],'in');
										$Vl['ls'][$__key_ls][$__key_id]['img_v'] = _ImVrs(['img'=>ctjTx($row_Ls['sisslc_img'],'in'), 'f'=>DMN_FLE_SIS_SLC ]);
									}

									if($_prvt!='ok'){ $Vl['ls'][$__key_ls][$__key_id][$__key_f_ls]['id'] = ctjTx($row_Ls['id_sisslcf'],'in'); }
									$Vl['ls'][$__key_ls][$__key_id][$__key_f_ls]['enc'] = ctjTx($row_Ls['sisslcf_enc'],'in');
									//$Vl['ls'][$__key_ls][$__key_id][$__key_f_ls]['vl'] = ctjTx($row_Ls['sisslcf_vl'],'in');

									if($row_Ls['sisslctpf_tpd'] == 11){
										$Vl['ls'][$__key_ls][$__key_id][$__key_f_ls]['vl'] = _jBty([ 't'=>'o', 'v'=>ctjTx($row_Ls['sisslcf_vl'],'in','',['html'=>'ok','schr'=>'no','nl2'=>'no','sslh'=>'no','qte'=>'no']) ]);
									}elseif($row_Ls['sisslc_tp'] == 10){
										$Vl['ls'][$__key_ls][$__key_id][$__key_f_ls]['vl'] = _jBty([ 't'=>'o', 'v'=>ctjTx($row_Ls['sisslcf_vl'],'in') ]);
									}elseif($row_Ls['sisslc_tp'] == 7){
										$Vl['ls'][$__key_ls][$__key_id][$__key_f_ls]['vl'] = ctjTx($row_Ls['sisslcf_vl'],'in','',['html'=>'ok','schr'=>'no','nl2'=>'no'] );
									}else{
										$Vl['ls'][$__key_ls][$__key_id][$__key_f_ls]['vl'] = ctjTx($row_Ls['sisslcf_vl'],'in','',['html'=>'ok']);
									}

									$Vl['ls'][$__key_ls][$__key_id][$__key_f_ls]['slc'] = [

										'id'=>$_prvt!='ok'?ctjTx($row_Ls['id_sisslc'],'in'):'',
										'enc'=>ctjTx($row_Ls['sisslc_enc'],'in'),
										'tt'=>ctjTx($row_Ls['sisslc_tt'],'in'),
										'cns'=>ctjTx($row_Ls['sisslc_cns'],'in'),
										'img'=>(!isN($row_Ls['sisslc_img']) ? DMN_FLE_SIS_SLC.ctjTx($row_Ls['sisslc_img'],'in'):''),
										'img_v'=>(!isN($row_Ls['sisslc_img']) ? _ImVrs(['img'=>ctjTx($row_Ls['sisslc_img'],'in'), 'f'=>DMN_FLE_SIS_SLC ]):'')

									];

									$___id_arr[$__key_ls][$__key_id] = '';
								}

							}

						}while($row_Ls = $Ls->fetch_assoc());

						if($__frmt != 's'){
							$rndm = array_rand($___id_arr[$p['k']], 1);
							$Vl['ls']['rnd'] = $Vl['ls'][ $p['k'] ][ $rndm ];
						}

					}else{
						$Vl['e'] = 'no';
					}

				}

				$__cnx->_clsr($Ls);

			}

			return _jEnc($Vl);

		}

		function GtSmsCmpgSndLs($p=NULL){

			global $__cnx;

			if($p['cmpg'] != ''){ $_f .= ' AND smssndcmpg_cmpg = '.$p['cmpg'].' '; }
			if($p['lmt'] != ''){ $_lmt = ' LIMIT '.$p['lmt'].' '; }

			$Ls_Qry = "SELECT * FROM ".MDL_SMS_SND_CMPG_BD.", ".TB_SMS_SND." WHERE smssndcmpg_snd = id_smssnd $_f ORDER BY id_smssndcmpg ASC $_lmt";
			//echo  $Ls_Qry;
			$LsTp_Rg = $__cnx->_qry($Ls_Qry);

			if($LsTp_Rg){

				$row_LsTp_Rg = $LsTp_Rg->fetch_assoc();
				$Tot_LsTp_Rg = $LsTp_Rg->num_rows;
				$_r['tot'] = $Tot_LsTp_Rg;

			    if($Tot_LsTp_Rg > 0){
	                do{

						$_v[] = ['id'=>ctjTx($row_LsTp_Rg['id_smssnd'],'in'), 'msj'=>ctjTx($row_LsTp_Rg['smssnd_msj'],'in'), 'cel'=>$row_LsTp_Rg['smssnd_cel']];

					} while ($row_LsTp_Rg = $LsTp_Rg->fetch_assoc());
				}


	          	$_r['ls'] = $_v;

          	}

          	$__cnx->_clsr($LsTp_Rg);

		    $rtrn = _jEnc($_r);
		    return($rtrn);
		}

		function GtSmsCmpgSndRpt($p=NULL){

			global $__cnx;

			if($p['cmpg'] != ''){ $_f .= ' AND smssndcmpg_cmpg = '.$p['cmpg'].' '; }
			if($p['lmt'] != ''){ $_lmt = ' LIMIT '.$p['lmt'].' '; }

			$Ls_Qry = " SELECT *, COUNT(*) AS _tot
						FROM ".MDL_SMS_SND_CMPG_BD.", ".TB_SMS_SND."
						WHERE smssndcmpg_snd = id_smssnd $_f
						GROUP BY smssnd_cel
						HAVING _tot > 1
					    ORDER BY id_smssndcmpg ";

			$LsTp_Rg = $__cnx->_qry($Ls_Qry);

			if($LsTp_Rg){

				$row_LsTp_Rg = $LsTp_Rg->fetch_assoc();
				$Tot_LsTp_Rg = $LsTp_Rg->num_rows;

				$_r['tot'] = $Tot_LsTp_Rg;

			    if($Tot_LsTp_Rg > 0){
	                do{

						$_v[] = ['id'=>ctjTx($row_LsTp_Rg['id_smssnd'],'in'), 'msj'=>ctjTx($row_LsTp_Rg['smssnd_msj'],'in'), 'cel'=>$row_LsTp_Rg['smssnd_cel']];

					} while ($row_LsTp_Rg = $LsTp_Rg->fetch_assoc());
				}

	          	$_r['ls'] = $_v;

          	}

          	$__cnx->_clsr($LsTp_Rg);

		    $rtrn = _jEnc($_r);
		    return($rtrn);
		}

		function GtUpDt($p=NULL){ // $Id, $Tp=NULL

			global $__cnx;

			$Vl['e'] = 'no';

			if(!isN($p)){

				if($p['t'] == 'enc'){ $__f = 'up_enc'; $__ft = 'text'; }else{ $__f = 'id_up'; $__ft = 'int'; }

				$c_DtRg = "-1";if (isset($p['id'])){$c_DtRg = $p['id'];}

				$Ls_TotLds = ", (SELECT COUNT(*) FROM ".DB_PRC.".up_col WHERE upcol_up = id_up) AS __tot_l ";
				$Ls_TotLds_P = ", (SELECT COUNT(*) FROM ".DB_PRC.".up_col WHERE upcol_up = id_up AND upcol_est = 353) AS __tot_p ";
				$Ls_TotLds_O = ", (SELECT COUNT(*) FROM ".DB_PRC.".up_col WHERE upcol_up = id_up AND upcol_est = 352) AS __tot_o ";
				$Ls_TotLds_W = ", (SELECT COUNT(*) FROM ".DB_PRC.".up_col WHERE upcol_up = id_up AND upcol_est = 615) AS __tot_w ";


				$query_DtRg = sprintf('SELECT *,

										'._QrySisSlcF([ 'als'=>'e', 'als_n'=>'estado' ]).',
										'.GtSlc_QryExtra([ 't'=>'fld', 'p'=>'estado', 'als'=>'e' ]).'

										'.$Ls_TotLds.' '.$Ls_TotLds_P.' '.$Ls_TotLds_O.' '.$Ls_TotLds_W.'
									   FROM '.DB_PRC.'.'.MDL_UP_BD.'
									   		INNER JOIN '._BdStr(DBM).TB_US.' ON up_us = id_us
									   		'.GtSlc_QryExtra([ 't'=>'tb', 'col'=>'up_est', 'als'=>'e' ]).'
									   WHERE '.$__f.' = %s LIMIT 1', GtSQLVlStr($c_DtRg, $__ft));

				$DtRg = $__cnx->_qry($query_DtRg);


				if($DtRg){

					$row_DtRg = $DtRg->fetch_assoc();
					$Tot_DtRg = $DtRg->num_rows;

					if($Tot_DtRg > 0){

						$Vl['e'] = 'ok';

						$__estado = json_decode($row_DtRg['___estado']);

		                foreach($__estado as $__tp_k=>$__tp_v){
							$__estado_go[$__tp_v->key] = $__tp_v;
						}

						$Vl['id'] = $row_DtRg['id_up'];
						$Vl['enc'] = $row_DtRg['up_enc'];
						$Vl['nm'] = ctjTx($row_DtRg['up_nm'],'in');
						$Vl['fle'] = ctjTx($row_DtRg['up_fle'],'in');
						$Vl['fld'] = ctjTx($row_DtRg['up_fld'],'in');
						$Vl['fld_c'] = GtUpFldLs([ 'c'=>$row_DtRg['up_fld'] ]);

						$Vl['est'] = $row_DtRg['up_est'];
						$Vl['row'] = $row_DtRg['up_row'];
						$Vl['col'] = $row_DtRg['up_col'];
						$Vl['est_cls'] = $__estado_go['cls']->vl;

						$Vl['tp'] = ctjTx($row_DtRg['up_tp'],'in');
						$Vl['ext'] = ctjTx($row_DtRg['up_ext'],'in');

						$Vl['rd'] = mBln($row_DtRg['up_rd']);
						$Vl['lrow'] = ctjTx($row_DtRg['up_lrow'],'in');

						$Vl['us']['id'] = ctjTx($row_DtRg['id_us'],'in');
						$Vl['us']['enc'] = ctjTx($row_DtRg['us_enc'],'in');

						$Vl['tot']['l'] = $row_DtRg['__tot_l'];
						$Vl['tot']['p'] = $row_DtRg['__tot_p'];
						$Vl['tot']['o'] = $row_DtRg['__tot_o'];
						$Vl['tot']['w'] = $row_DtRg['__tot_w'];

					}

				}

				$__cnx->_clsr($DtRg);


			}else{

				$Vl['w'] = 'No data';

			}

			return( _jEnc($Vl) );
		}

		function GtUpFldDt($Id, $Tp=NULL){

			if(!isN($Id)){

				global $__cnx;

				if($Tp == 'vl'){ $__f = 'upfld_vl'; $__ft = 'text'; }else{ $__f = 'id_upfld'; $__ft = 'int'; }
				$c_DtRg = "-1";if (isset($Id)){$c_DtRg = $Id;}

				$query_DtRg = sprintf('	SELECT *
										FROM '.DBP.'.'.TB_UP_FLD.'
										WHERE id_upfld != "" AND '.$__f.' = %s LIMIT 1', GtSQLVlStr($c_DtRg, $__ft));

				$DtRg = $__cnx->_qry($query_DtRg);

				if($DtRg){

					$row_DtRg = $DtRg->fetch_assoc();
					$Tot_DtRg = $DtRg->num_rows;

					if($Tot_DtRg > 0){
						$Vl['id'] = $row_DtRg['id_upfld'];
						$Vl['tt'] = ctjTx($row_DtRg['upfld_tt'],'in');
						$Vl['vl'] = ctjTx($row_DtRg['upfld_vl'],'in');
					}

				}

				$__cnx->_clsr($DtRg);

				return _jEnc($Vl);
			}
		}

		function GtUpFldLs($p=NULL){
			if(!isN($p['c'])){

				$_o = json_decode($p['c']);

				foreach($_o as $_k => $_v){
					$_fx = explode('_', $_k);
					$Vl[$_v] = 'upcol_'.$_fx[1];
				}

				return _jEnc($Vl);
			}
		}



	function GtEmlDt($p=NULL){ //$Id, $Tp=NULL, $p=NULL

		global $__cnx;

		$Vl['e'] = "no";

		if(!isN($p['id'])){

			if($p['t'] == 'enc'){
				$__f = 'eml_enc'; $__ft = 'text';
			}else{
				$__f = 'id_eml'; $__ft = 'int';
			}

			$query_DtRg = sprintf('SELECT *,
									AES_DECRYPT(eml_pss, \''.ENCRYPT_PASSPHRASE.'\') AS __pss,
									'._QrySisSlcF(['als'=>'t', 'als_n'=>'tipo']).',
								    '._QrySisSlcF(['als'=>'a', 'als_n'=>'avatar']).',
								    '.GtSlc_QryExtra(['t'=>'fld', 'p'=>'tipo', 'als'=>'t']).',
								    '.GtSlc_QryExtra(['t'=>'fld', 'p'=>'avatar', 'als'=>'a']).'

								   FROM '._BdStr(DBT).TB_THRD_EML.'
								   		/*RIGHT JOIN '._BdStr(DBT).TB_THRD_EML_ATTR.' ON emlattr_id = id_eml*/
								   		'.GtSlc_QryExtra(['t'=>'tb', 'col'=>'eml_tp', 'als'=>'t']).'
										'.GtSlc_QryExtra(['t'=>'tb', 'col'=>'eml_avtr', 'als'=>'a']).'
								   WHERE '.$__f.' = %s '.$__fl.' '.$__ord.' LIMIT 1', GtSQLVlStr($p['id'], $__ft));

			$DtRg = $__cnx->_qry($query_DtRg);
			//echo compress_code($query_DtRg).HTML_BR.HTML_BR;

			if($DtRg){

				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;

				if($Tot_DtRg > 0){

					$Vl['e'] = "ok";
					$Vl['id'] = $row_DtRg['id_eml'];
					$Vl['nm'] = ctjTx($row_DtRg['eml_nm'],'in');
					$Vl['eml'] = ctjTx($row_DtRg['eml_eml'],'in');
					$Vl['enc'] = ctjTx($row_DtRg['eml_enc'],'in');

					$Vl['dfl']['id'] = $row_DtRg['eml_dfl'];
					$Vl['dfl']['v'] = mBln($row_DtRg['eml_dfl']);
					$Vl['onl']['id'] = $row_DtRg['eml_onl'];
					$Vl['onl']['v'] = mBln($row_DtRg['eml_onl']);
					$Vl['ssl']['id'] = $row_DtRg['eml_ssl'];
					$Vl['ssl']['v'] = mBln($row_DtRg['eml_ssl']);

					$__avtr_img = DMN_FLE_SIS_SLC.ctjTx($row_DtRg['avatar_sisslc_img'],'in');

					if(!isN($row_DtRg['___tipo'])){

					    $__tipo_attr = json_decode($row_DtRg['___tipo']);

					    if(!isN($__tipo_attr) && is_array($__tipo_attr)){
						    foreach($__tipo_attr as $_attr_k=>$_attr_v){
							    $__toa_attr[ $_attr_v->key ] = $_attr_v;
						    }
						}

				    }else{
					    $__toa_attr = NULL;
				    }

					$Vl['avtr'] = $__avtr_img;


					$Vl['tp']['id'] = ctjTx($row_DtRg['tipo_id_sisslc'],'in');
					$Vl['tp']['nm'] = ctjTx($row_DtRg['tipo_sisslc_tt'],'in');
					$Vl['tp']['attr'] = $__toa_attr;

					$Vl['in']['srv'] = ctjTx($row_DtRg['eml_srv_in'],'in');
					$Vl['in']['prt'] = ctjTx($row_DtRg['eml_prt_in'],'in');

					$Vl['out']['srv'] = ctjTx($row_DtRg['eml_srv_out'],'in');
					$Vl['out']['prt'] = ctjTx($row_DtRg['eml_prt_out'],'in');

					$Vl['user'] = ctjTx($row_DtRg['eml_usr'],'in');
					if($p['pss']=='ok'){ $Vl['pass'] = ctjTx($row_DtRg['__pss'],'in'); }

					$Vl['attr'] = GtEmlAttrLs([ 'eml'=>$row_DtRg['id_eml'] ]);

				}

			}

		}

		$__cnx->_clsr($DtRg);

		return(_jEnc($Vl));
	}

	function _ChkSgn($_d='', $_t='sgn_dir'){

		global $__cnx;

		if(($_d!='')){
			$c_DtRg = "-1";if (isset($_d)){$c_DtRg = $_d;}
			$query_DtRg = sprintf('SELECT * FROM sgn WHERE id_sgn != "" AND '.$_t.' = %s', GtSQLVlStr($c_DtRg, 'text'));
			$DtRg = $__cnx->_qry($query_DtRg);

			if($DtRg){

				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;

			}

			$__cnx->_clsr($DtRg);

			if($Tot_DtRg==1){$_r =true;}else{$_r=false;}
			return($_r);

		}
	}



	function GtMnuDt($p=NULL){

		global $__cnx;

		if(!isN($p['id'])){ $_fl .= " AND id_clmnu = ".$p['id'].""; }
		if(!isN($p['enc'])){ $_fl .= " AND clmnu_enc = ".$p['enc'].""; }
		if(!isN($p['prnt'])){ $_fl .= " AND clmnu_prnt = ".$p['prnt'].""; }

		$Dt_Qry = "	SELECT *,
							(SELECT _sub.clmnu_ord
							 FROM "._BdStr(DBM).TB_CL_MNU." AS _sub
							 WHERE _sub.clmnu_ord IS NOT NULL AND _sub.clmnu_prnt = _main.id_clmnu
							 ORDER BY _sub.clmnu_ord DESC
							 LIMIT 1) AS __ord_lst
						FROM "._BdStr(DBM).TB_CL_MNU." AS _main
						WHERE _main.id_clmnu != '' {$_fl} LIMIT 1";

		$DtRg = $__cnx->_qry($Dt_Qry);

		if($DtRg){

			$row_DtRg = $DtRg->fetch_assoc();
			$Tot_DtRg = $DtRg->num_rows;

			if($Tot_DtRg > 0){

				$_r['id'] = $row_DtRg['id_clmnu'];
				$_r['enc'] = $row_DtRg['clmnu_enc'];
				$_r['lst']['ord'] = $row_DtRg['__ord_lst'];

	        }

        }

		$__cnx->_clsr($DtRg);

		return _jEnc($_r);

	}


	/*

	function GtSisTpDt($_p=NULL){

		global $__cnx;

		if(is_array($_p)){
			if(!isN($_p['id'])){

				$c_DtRg = "-1";if(!isN($_p['id'])){$c_DtRg = $_p['id'];}

				if($_p['t'] == 'tp'){ $__f = 'mdlstp_tp'; $__ft = 'text'; }else{ $__f = 'id_mdlstp'; $__ft = 'int'; }

				$query_DtRg = sprintf("SELECT * FROM ".TB_MDL_S_TP." WHERE {$__f} = %s", GtSQLVlStr($c_DtRg, $__ft));

				$DtRg = $__cnx->_qry($query_DtRg);
				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;

					$Vl['id'] = $row_DtRg['id_mdlstp'];
					$Vl['tt'] = ctjTx($row_DtRg['mdlstp_nm'],'in');
					$Vl['tp'] = ctjTx($row_DtRg['mdlstp_tp'],'in');
					$Vl['tp_u'] = strtoupper(ctjTx($row_DtRg['mdlstp_tp'],'in'));
					$Vl['imk_pky'] = ctjTx($row_DtRg['mdlstp_imk_pky'],'in');

			}

			$__cnx->_clsr($DtRg);

			return _jEnc($Vl);

		}
	}
	*/

	function GtMdlSTpPrmDt($_p=NULL){

		global $__cnx;

		$Vl['e'] = 'no';

		if(is_array($_p)){
			if(!isN($_p['id'])){

				$c_DtRg = "-1";if(!isN($_p['id'])){$c_DtRg = $_p['id'];}

				if($_p['t'] == 'tp'){ $__f = 'mdlstpprm_tp'; $__ft = 'text'; }
				elseif($_p['t'] == 'enc'){ $__f = 'mdlstpprm_enc'; $__ft = 'text'; }
				else{ $__f = 'id_mdlstpprm'; $__ft = 'int'; }

				$query_DtRg = sprintf("SELECT * FROM "._BdStr(DBM).TB_MDL_S_TP_PRM." WHERE {$__f} = %s", GtSQLVlStr($c_DtRg, $__ft));
				$DtRg = $__cnx->_qry($query_DtRg);

				if($DtRg){
					$row_DtRg = $DtRg->fetch_assoc();
					$Tot_DtRg = $DtRg->num_rows;

					$Vl['id'] = $row_DtRg['id_mdlstpprm'];
					$Vl['tt'] = ctjTx($row_DtRg['mdlstpprm_nm'],'in');

				}

				$__cnx->_clsr($DtRg);

			}
		}

		return(_jEnc($Vl));

	}

	function GtMdlSTpDt($_p=NULL){

		global $__cnx;

		$Vl['e'] = 'no';
		//$Vl['p'] = $_p;

		if(is_array($_p)){

			if(!isN($_p['id']) || !isN($_p['tp']) || !isN($_p['enc'])){

				if(!isN($_p['id'])){ $__f .= sprintf(' AND id_mdlstp = %s ', GtSQLVlStr($_p['id'], 'int') ); }
				if(!isN($_p['enc'])){ $__f .= sprintf(' AND mdlstp_enc = %s ', GtSQLVlStr($_p['enc'], 'text') ); }
				if(!isN($_p['tp'])){ $__f .= sprintf(' AND mdlstp_tp = %s ', GtSQLVlStr($_p['tp'], 'text') ); }

				$query_DtRg = sprintf("	SELECT *
										FROM "._BdStr(DBM).TB_MDL_S_TP."
										WHERE id_mdlstp != '' {$__f} LIMIT 1", GtSQLVlStr($c_DtRg, $__ft));
				$DtRg = $__cnx->_qry($query_DtRg);

				if($DtRg){

					$row_DtRg = $DtRg->fetch_assoc();
					$Tot_DtRg = $DtRg->num_rows;

					$Vl['tot'] = $Tot_DtRg;

					$__img = _ImVrs(['img'=>ctjTx($row_DtRg['mdlstp_img'],'in'), 'f'=>DMN_FLE_MDL_TP ]);

					if($Tot_DtRg > 0){

						$Vl['e'] = 'ok';
						$Vl['id'] = $row_DtRg['id_mdlstp'];
						$Vl['enc'] = $row_DtRg['mdlstp_enc'];
						$Vl['tt'] = ctjTx($row_DtRg['mdlstp_nm'],'in');
						$Vl['tp'] = ctjTx($row_DtRg['mdlstp_tp'],'in');
						$Vl['unq'] = mBln($row_DtRg['mdlstp_unq']);

						$Vl['tp_u'] = strtoupper(ctjTx($row_DtRg['mdlstp_tp'],'in'));
						$Vl['img'] = $__img;
						$Vl['ctg'] = GtMdlSTpCtgLs([ 'mdlstp'=>$row_DtRg['id_mdlstp'] ]);

						$Vl['clg'] = ctjTx($row_DtRg['mdlstp_clg'],'in');
						$Vl['uni'] = ctjTx($row_DtRg['mdlstp_uni'],'in');
						$Vl['emp'] = ctjTx($row_DtRg['mdlstp_emp'],'in');
						$Vl['tra'] = ctjTx($row_DtRg['mdlstp_tra'],'in');
						$Vl['mdls'] = ctjTx($row_DtRg['mdlstp_mdls'],'in');

						if(mBln($row_DtRg['mdlstp_tra']) == 'ok'){
							$Vl['dt'] = GtMdlSTpTraLs([ 'id'=>$row_DtRg['id_mdlstp'], 'cl' => $_p['cl'] ]);
						}

					}else{

						$Vl['q'] = $query_DtRg;

					}

				}

				$__cnx->_clsr($DtRg);

			}

		}else{

			$Vl['w'] = 'No all data for process';

		}

		return(_jEnc($Vl));
	}

	function GtMdlSTpCtgLs($p=NULL){

		global $__cnx;

		$_r['e'] = 'no';

		if(!isN($p['mdlstp'])){ $_fl .= " AND mdlstpctg_mdlstp = ".$p['mdlstp'].""; }

		$Dt_Qry = "	SELECT *,
							"._QrySisSlcF([ 'als'=>'l', 'als_n'=>'categoria' ]).",
							".GtSlc_QryExtra([ 't'=>'fld', 'p'=>'categoria', 'als'=>'l' ])."
					FROM "._BdStr(DBM).TB_MDL_S_TP_CTG."
						 ".GtSlc_QryExtra([ 't'=>'tb', 'col'=>'mdlstpctg_ctg', 'als'=>'l' ])."
					WHERE id_mdlstpctg != '' {$_fl}
					ORDER BY mdlstpctg_fi DESC";

		$DtRg = $__cnx->_qry($Dt_Qry);

		if($DtRg){

			$row_DtRg = $DtRg->fetch_assoc();
			$Tot_DtRg = $DtRg->num_rows;

			$_r['e'] = 'ok';
			$_r['tot'] = $Tot_DtRg;

			if($Tot_DtRg > 0){

				$__i = 1;

	            do{

		            $__slcdt = __LsDt([ 'id'=>$row_DtRg['categoria_id_sisslc'], 'no_lmt'=>'ok' ]);
					$__enc = $row_DtRg['mdlstpctg_enc'];

					$__ob = [
						'id'=>$row_DtRg['id_mdlstpctg'],
						'enc'=>$row_DtRg['mdlstpctg_enc'],
						'attr'=>$__slcdt->d,
						'fi'=>$row_DtRg['mdlstpctg_fi'],
						'fa'=>$row_DtRg['mdlstpctg_fa']
					];

					$_r['ls'][$__enc] = $__ob;

					if($__i == 1){
						$_r['main'] = $__ob;
					}

				} while ($row_DtRg = $DtRg->fetch_assoc());
	        }

		}

		$__cnx->_clsr($DtRg);
		return _jEnc($_r);

	}

	function GtMdlSTpTraLs($p=NULL){

		global $__cnx;

		$_r['e'] = 'no';

		if(!isN($p['cl'])){ $_cl = $p['cl']; }else{ $_cl = DB_CL_ID; }

		$Dt_Qry = "	SELECT
						mdlstptra_us,
						mdlstptra_col,
						mdlstptra_cl,
						mdlstptra_tt_dft
					FROM
						"._BdStr(DBM).TB_MDL_S_TP_TRA."
						INNER JOIN "._BdStr(DBM).TB_CL." ON mdlstptra_cl = id_cl
					WHERE
						id_mdlstptra != ''
						AND mdlstptra_mdlstp = ".$p['id']."
						AND id_cl = '".$_cl."'
					LIMIT 1";

		$DtRg = $__cnx->_qry($Dt_Qry);

		if($DtRg){

			$row_DtRg = $DtRg->fetch_assoc();
			$Tot_DtRg = $DtRg->num_rows;

			$_r['e'] = 'ok';
			$_r['tot'] = $Tot_DtRg;

			if($Tot_DtRg > 0){

				$__i = 1;

	            do{

					$_r['us'] = $row_DtRg['mdlstptra_us'];
					$_r['col'] = $row_DtRg['mdlstptra_col'];
					$_r['cl'] = $row_DtRg['mdlstptra_cl'];
					$_r['tt'] = $row_DtRg['mdlstptra_tt_dft'];

				} while ($row_DtRg = $DtRg->fetch_assoc());
	        }

		}

		$__cnx->_clsr($DtRg);
		return _jEnc($_r);

	}

	function GtMdlSTpCl_Ls($p=NULL){

		global $__cnx;

		$_r['e'] = 'no';

		if(!isN($p['cl'])){ $_fl .= " AND mdlstpcl_cl = ".$p['cl'].""; }
		if(!isN($p['mdlstp'])){ $_fl .= " AND mdlstpcl_mdlstp = ".$p['mdlstp'].""; }

		$Dt_Qry = "	SELECT *
						FROM "._BdStr(DBM).TB_MDL_S_TP_CL."
							 INNER JOIN "._BdStr(DBM).TB_CL." ON mdlstpcl_cl = id_cl
						WHERE id_mdlstpcl != '' {$_fl}";

		$DtRg = $__cnx->_qry($Dt_Qry);

		if($DtRg){

			$row_DtRg = $DtRg->fetch_assoc();
			$Tot_DtRg = $DtRg->num_rows;

			$_r['e'] = 'ok';
			$_r['tot'] = $Tot_DtRg;

			if($Tot_DtRg > 0){

	            do{
					$__cl_img = _ImVrs(['img'=>ctjTx($row_DtRg['cl_img'],'in'), 'f'=>DMN_FLE_CL ]);

					$__enc = $row_DtRg['cl_enc'];

					$_r['ls'][$__enc]['r']['id'] = $row_DtRg['id_mdlstpcl'];
					$_r['ls'][$__enc]['r']['enc'] = $row_DtRg['mdlstpcl_enc'];


					$_r['ls'][$__enc]['cl']['id'] = ctjTx($row_DtRg['id_cl'],'in');
					$_r['ls'][$__enc]['cl']['enc'] = ctjTx($row_DtRg['cl_enc'],'in');
					$_r['ls'][$__enc]['cl']['nm'] = ctjTx($row_DtRg['cl_nm'],'in');
					$_r['ls'][$__enc]['cl']['img'] = $__cl_img;


				} while ($row_DtRg = $DtRg->fetch_assoc());
	        }

        }

		$__cnx->_clsr($DtRg);
		return _jEnc($_r);

	}

	function GtSisSlcTpCl_Ls($p=NULL){

		global $__cnx;

		$_r['e'] = 'no';

		if(!isN($p['sisslctp'])){ $_fl .= " AND sisslctpcl_sisslctp = ".$p['sisslctp'].""; }

		$Dt_Qry = "	SELECT *
						FROM "._BdStr(DBM).TB_SIS_SLC_TP_CL."
							 INNER JOIN "._BdStr(DBM).TB_CL." ON sisslctpcl_cl = id_cl
						WHERE id_sisslctpcl != '' {$_fl}";

		$DtRg = $__cnx->_qry($Dt_Qry);

		if($DtRg){

			$row_DtRg = $DtRg->fetch_assoc();
			$Tot_DtRg = $DtRg->num_rows;

			$_r['e'] = 'ok';
			$_r['tot'] = $Tot_DtRg;

			if($Tot_DtRg > 0){

	            do{
					$__cl_img = _ImVrs(['img'=>ctjTx($row_DtRg['cl_img'],'in'), 'f'=>DMN_FLE_CL ]);

					$__enc = $row_DtRg['cl_enc'];

					$_r['ls'][$__enc]['r']['id'] = $row_DtRg['id_sisslctpcl'];
					$_r['ls'][$__enc]['r']['enc'] = $row_DtRg['sisslctpcl_enc'];


					$_r['ls'][$__enc]['cl']['id'] = ctjTx($row_DtRg['id_cl'],'in');
					$_r['ls'][$__enc]['cl']['enc'] = ctjTx($row_DtRg['cl_enc'],'in');
					$_r['ls'][$__enc]['cl']['nm'] = ctjTx($row_DtRg['cl_nm'],'in');
					$_r['ls'][$__enc]['cl']['img'] = $__cl_img;


				} while ($row_DtRg = $DtRg->fetch_assoc());
	        }

        }

		$__cnx->_clsr($DtRg);
		return _jEnc($_r);

	}

	function GtMdlSTpLs($p=NULL){

		global $__cnx;

		$_r['e'] = 'no';

		if(!isN($p['cl'])){ $_fl .= " AND id_cl = ".$p['cl'].""; }else{ $_fl .= " AND cl_enc = '".DB_CL_ENC."' "; }
		if(!isN($p['app'])){ $_fl .= " AND mdlstp_app = 1 "; }
		if(!isN($p['fl'])){ $_fl .= $p['fl']; }

		$Dt_Qry = "	SELECT *
						FROM "._BdStr(DBM).TB_MDL_S_TP_CL."
							 INNER JOIN "._BdStr(DBM).TB_MDL_S_TP." ON mdlstpcl_mdlstp = id_mdlstp
							 INNER JOIN "._BdStr(DBM).TB_CL." ON mdlstpcl_cl = id_cl
						WHERE id_mdlstpcl != '' {$_fl}";

		$DtRg = $__cnx->_qry($Dt_Qry);

		if($DtRg){

			$row_DtRg = $DtRg->fetch_assoc();
			$Tot_DtRg = $DtRg->num_rows;

			$_r['e'] = 'ok';
			$_r['tot'] = $Tot_DtRg;

			if($Tot_DtRg > 0){

	            do{

					$__img = _ImVrs(['img'=>ctjTx($row_DtRg['mdlstp_img'],'in'), 'f'=>DMN_FLE_MDL_TP ]);
					$__enc = $row_DtRg['mdlstp_enc'];

					$_r['ls'][$__enc]['id'] = $row_DtRg['id_mdlstp'];
					$_r['ls'][$__enc]['enc'] = $row_DtRg['mdlstp_enc'];
					$_r['ls'][$__enc]['nm'] = ctjTx($row_DtRg['mdlstp_nm'],'in');
					$_r['ls'][$__enc]['tp'] = ctjTx($row_DtRg['mdlstp_tp'],'in');
					$_r['ls'][$__enc]['clr'] = ctjTx($row_DtRg['mdlstp_clr'],'in');
					$_r['ls'][$__enc]['img'] = $__img;


				} while ($row_DtRg = $DtRg->fetch_assoc());
	        }

        }

		$__cnx->_clsr($DtRg);
		return _jEnc($_r);

	}



	function GtMdlSPrdLs($p=NULL){

		global $__cnx;

		$_r['e'] = 'no';

		if(!isN($p['cl'])){ $_fl .= " AND id_cl = ".$p['cl'].""; }
		if(!isN($p['tp'])){ $_fl .= " AND id_mdlstp = ".$p['tp'].""; }

		$Dt_Qry = "	SELECT id_mdlsprd, mdlsprd_enc, mdlsprd_nm
						FROM "._BdStr(DBM).TB_MDL_S_PRD."
							 INNER JOIN "._BdStr(DBM).TB_CL." ON mdlsprd_cl = id_cl
							 INNER JOIN "._BdStr(DBM).TB_MDL_S_PRD_TP." ON mdlsprdtp_prd = id_mdlsprd
							 INNER JOIN "._BdStr(DBM).TB_MDL_S_TP." ON mdlsprdtp_tp = id_mdlstp
						WHERE id_mdlsprd != '' {$_fl}";

		$DtRg = $__cnx->_qry($Dt_Qry);

		if($DtRg){

			$row_DtRg = $DtRg->fetch_assoc();
			$Tot_DtRg = $DtRg->num_rows;

			$_r['e'] = 'ok';
			$_r['tot'] = $Tot_DtRg;

			if($Tot_DtRg > 0){

	            do{

					$__enc = $row_DtRg['mdlsprd_enc'];
					$_r['ls'][$__enc]['id'] = $row_DtRg['id_mdlsprd'];
					$_r['ls'][$__enc]['enc'] = $row_DtRg['mdlsprd_enc'];
					$_r['ls'][$__enc]['nm'] = ctjTx($row_DtRg['mdlsprd_nm'],'in');

				} while ($row_DtRg = $DtRg->fetch_assoc());

	        }

        }else{

			$_r['w'] = $__cnx->c_r->error;

		}

		$__cnx->_clsr($DtRg);
		return _jEnc($_r);

	}



	function GtSisMdClLs($p=NULL){

		global $__cnx;

		if(!isN($p['cl'])){ $_fl .= " AND sismdcl_cl = ".$p['cl'].""; }
		if(!isN($p['sismd'])){ $_fl .= " AND sismdcl_sismd = ".$p['sismd'].""; }

		$Dt_Qry = "	SELECT *
						FROM "._BdStr(DBM).TB_SIS_MD_CL."
							 INNER JOIN "._BdStr(DBM).TB_CL." ON sismdcl_cl = id_cl
						WHERE id_sismdcl != '' {$_fl}";

		$DtRg = $__cnx->_qry($Dt_Qry);

		if($DtRg){

			$row_DtRg = $DtRg->fetch_assoc();
			$Tot_DtRg = $DtRg->num_rows;

			$_r['e'] = 'ok';
			$_r['tot'] = $Tot_DtRg;

			if($Tot_DtRg > 0){

	            do{
					$__cl_img = _ImVrs(['img'=>ctjTx($row_DtRg['cl_img'],'in'), 'f'=>DMN_FLE_CL ]);

					$__enc = $row_DtRg['cl_enc'];

					$_r['ls'][$__enc]['r']['id'] = $row_DtRg['id_sismdcl'];
					$_r['ls'][$__enc]['r']['enc'] = $row_DtRg['sismdcl_enc'];

					$_r['ls'][$__enc]['cl']['id'] = ctjTx($row_DtRg['id_cl'],'in');
					$_r['ls'][$__enc]['cl']['enc'] = ctjTx($row_DtRg['cl_enc'],'in');
					$_r['ls'][$__enc]['cl']['nm'] = ctjTx($row_DtRg['cl_nm'],'in');
					$_r['ls'][$__enc]['cl']['img'] = $__cl_img;

				} while ($row_DtRg = $DtRg->fetch_assoc());
	        }
		}

		$__cnx->_clsr($DtRg);
		return _jEnc($_r);

	}

	function GtSisFntCl_Ls($p=NULL){

		global $__cnx;

		if(!isN($p['cl'])){ $_fl .= " AND sisfntcl_cl = ".$p['cl'].""; }
		if(!isN($p['sisfnt'])){ $_fl .= " AND sisfntcl_sisfnt = ".$p['sisfnt'].""; }

		$Dt_Qry = "	SELECT *
						FROM "._BdStr(DBM).TB_SIS_FNT_CL."
							 INNER JOIN "._BdStr(DBM).TB_CL." ON sisfntcl_cl = id_cl
						WHERE id_sisfntcl != '' {$_fl}";

		$DtRg = $__cnx->_qry($Dt_Qry);

		if($DtRg){

			$row_DtRg = $DtRg->fetch_assoc();
			$Tot_DtRg = $DtRg->num_rows;

			$_r['e'] = 'ok';
			$_r['tot'] = $Tot_DtRg;

			if($Tot_DtRg > 0){

	            do{
					$__cl_img = _ImVrs(['img'=>ctjTx($row_DtRg['cl_img'],'in'), 'f'=>DMN_FLE_CL ]);

					$__enc = $row_DtRg['cl_enc'];

					$_r['ls'][$__enc]['r']['id'] = $row_DtRg['id_sisfntcl'];
					$_r['ls'][$__enc]['r']['enc'] = $row_DtRg['sisfntcl_enc'];


					$_r['ls'][$__enc]['cl']['id'] = ctjTx($row_DtRg['id_cl'],'in');
					$_r['ls'][$__enc]['cl']['enc'] = ctjTx($row_DtRg['cl_enc'],'in');
					$_r['ls'][$__enc]['cl']['nm'] = ctjTx($row_DtRg['cl_nm'],'in');
					$_r['ls'][$__enc]['cl']['img'] = $__cl_img;


				} while ($row_DtRg = $DtRg->fetch_assoc());
	        }
        }

		$__cnx->_clsr($DtRg);
		return _jEnc($_r);

	}

	function GtImgLs($p=NULL){

		global $__cnx;
		global $__dt_cl;

		if(isN($__dt_cl)){ $__dt_cl = GtClDt( Gt_SbDMN(), 'sbd' ); }

		if(!isN($p["id"]) && !isN($p["id"])){
			if($p["tp"] == "enc"){
				$_fl .= "AND climg_enc = '".$p["id"]."' ";
			}
		}

		$query_DtRg = " SELECT * FROM "._BdStr(DBM).TB_CL_IMG." WHERE id_climg != '' AND climg_cl = ".$__dt_cl->id." $_fl ORDER BY id_climg DESC";
		$DtRg = $__cnx->_qry($query_DtRg);

		if($DtRg){

			$row_DtRg = $DtRg->fetch_assoc();
			$Tot_DtRg = $DtRg->num_rows;

			$Vl['tot'] = $Tot_DtRg;

			if($Tot_DtRg > 0){

				$Vl['e'] = "ok";
				$Vl['ls'] = [];

				do{

					if(!isN($row_DtRg['id_climg']) && !isN($row_DtRg['id_climg'])){
						array_push($Vl['ls'],
							[
								'id'=>$row_DtRg['id_climg'],
								'enc'=>$row_DtRg['climg_enc'],
								'nm'=>$row_DtRg['climg_tt'],
								'fle'=>$row_DtRg['climg_fle']
							]
						);
					}

				}while($row_DtRg = $DtRg->fetch_assoc());

			}else{
				$Vl['e'] = "no";
			}

		}

		$__cnx->_clsr($DtRg);

		return(_jEnc($Vl));

	}

	function GtDshDmsLs($p=NULL){

		global $__cnx;
		global $__dt_cl;

		if(isN($__dt_cl)){ $__dt_cl = GtClDt( Gt_SbDMN(), 'sbd' ); }

		if(!isN($p["id"]) && !isN($p["id"])){
			if($p["tp"] == "enc"){
				$_fl .= "AND dshdms_enc = '".$p["id"]."' ";
			}
		}

		if(!isN($p["id_grph"]) && !isN($p["id_grph"])){
			$_fl = sprintf('AND id_dshdms IN (SELECT dshgrphdms_dms FROM '._BdStr(DBM).TB_DSH_GRPH_DMS.' WHERE dshgrphdms_grph = %s) ', GtSQLVlStr($p["id_grph"], 'int'));
		}

		$query_DtRg = " SELECT * FROM "._BdStr(DBM).TB_DSH_DMS." WHERE id_dshdms != '' $_fl ORDER BY id_dshdms DESC";
		$DtRg = $__cnx->_qry($query_DtRg);

		if($DtRg){

			$row_DtRg = $DtRg->fetch_assoc();
			$Tot_DtRg = $DtRg->num_rows;

			$Vl['tot'] = $Tot_DtRg;

			if($Tot_DtRg > 0){

				$Vl['e'] = "ok";
				$Vl['ls'] = [];

				do{

					if(!isN($row_DtRg['id_dshdms']) && !isN($row_DtRg['id_dshdms'])){
						array_push($Vl['ls'],
							[
								'id'=>$row_DtRg['id_dshdms'],
								'enc'=>$row_DtRg['dshdms_enc'],
								'nm'=>$row_DtRg['dshdms_tt']
							]
						);
					}

				}while($row_DtRg = $DtRg->fetch_assoc());

			}else{
				$Vl['e'] = "no";
				$Vl['w'] = TX_NXTVLRS;
			}

		}

		$__cnx->_clsr($DtRg);

		return(_jEnc($Vl));

	}

	function GtDshMtrcLs($p=NULL){

		global $__cnx;
		global $__dt_cl;
		if(isN($__dt_cl)){ $__dt_cl = GtClDt( Gt_SbDMN(), 'sbd' ); }


		$_Cl_Dt_Id = $__dt_cl->id;
		$__fl_cl = sprintf(' AND dshmtrccl_cl = '.$_Cl_Dt_Id.' ');

		if(!isN($p["id"]) && !isN($p["id"])){
			$_fl .= "AND id_dshmtrc = '".$p["id"]."' ";
		}

		if(!isN($p["id_dms"]) && !isN($p["id_dms"])){
			$_fl = sprintf('AND id_dshmtrc IN (SELECT dshdmsmtrc_mtrc FROM '._BdStr(DBM).TB_DSH_DMS_MTRC.' WHERE dshdmsmtrc_dms = %s) ', GtSQLVlStr($p["id_dms"], 'int'));
		}

		$query_DtRg = " SELECT *
						FROM "._BdStr(DBM).TB_DSH_MTRC.", "._BdStr(DBM).TB_DSH_MTRC_CL."
						WHERE id_dshmtrc != '' AND dshmtrccl_mtrc = id_dshmtrc $_fl $__fl_cl
						GROUP BY dshmtrc_tt
						ORDER BY id_dshmtrc DESC";

		$DtRg = $__cnx->_qry($query_DtRg);

		if($DtRg){

			$row_DtRg = $DtRg->fetch_assoc();
			$Tot_DtRg = $DtRg->num_rows;

			$Vl['tot'] = $Tot_DtRg;

			if($Tot_DtRg > 0){

				$Vl['e'] = "ok";
				$Vl['ls'] = [];

				do{

					if(!isN($row_DtRg['id_dshmtrc']) && !isN($row_DtRg['id_dshmtrc'])){
						array_push($Vl['ls'],
							[
								'id'=>$row_DtRg['id_dshmtrc'],
								'nm'=>$row_DtRg['dshmtrc_tt']
							]
						);
					}

				}while($row_DtRg = $DtRg->fetch_assoc());

			}else{
				$Vl['e'] = "no";
				$Vl['w'] = TX_NXTVLRS;
			}

		}

		$__cnx->_clsr($DtRg);

		return(_jEnc($Vl));

	}

	function GtTpcLs($p = NULL){

		global $__cnx;

		$query_DtRg = "SELECT
							*
						FROM
							"._BdStr(DBM).TB_TPC."
						INNER JOIN "._BdStr(DBM).TB_TPC_TP." ON tpc_tp = id_tpctp
						INNER JOIN "._BdStr(DBM).TB_TPC_CL." ON tpccl_tpc = id_tpc
						WHERE tpctp_key IN ('".$p['tp']."') AND tpccl_cl = ".$p['cl']." ORDER BY id_tpc DESC";

		$DtRg = $__cnx->_qry($query_DtRg);

		if($DtRg){

			$row_DtRg = $DtRg->fetch_assoc();
			$Tot_DtRg = $DtRg->num_rows;

			$Vl['tot'] = $Tot_DtRg;

			if($Tot_DtRg > 0){

				$Vl['e'] = "ok";

				do{

					if(!isN($row_DtRg['id_tpc']) && !isN($row_DtRg['id_tpc'])){

						$Vl['ls'][$row_DtRg['tpc_enc']]['id'] = $row_DtRg['id_tpc'];
						$Vl['ls'][$row_DtRg['tpc_enc']]['enc'] = $row_DtRg['tpc_enc'];
						$Vl['ls'][$row_DtRg['tpc_enc']]['tt'] = ctjTx($row_DtRg['tpc_tt'],'in');
						$Vl['ls'][$row_DtRg['tpc_enc']]['img'] = $row_DtRg['tpc_img'];
						$Vl['ls'][$row_DtRg['tpc_enc']]['key'] = $row_DtRg['tpc_key'];

					}

				}while($row_DtRg = $DtRg->fetch_assoc());

			}else{
				$Vl['e'] = "no";
			}

		}

		$__cnx->_clsr($DtRg);

		return(_jEnc($Vl));
	}

    function GtBnDt($Id, $Tp=''){

	    global $__cnx;

		if(!isN($Id)){
			if($Tp == 'enc'){ $__f = 'bn_enc'; $__ft = 'text'; }elseif($Tp == 'fld'){ $__f = 'bn_dir'; $__ft = 'text'; }else{ $__f = 'id_bn'; $__ft = 'int'; }
			$c_DtRg = "-1";if (isset($Id)){$c_DtRg = $Id;}

		   $query_DtRg = sprintf(' SELECT
					*,
			        '._QrySisSlcF([ 'als'=>'f', 'als_n'=>'formato' ]).',
			        '.GtSlc_QryExtra([ 't'=>'fld', 'p'=>'formato', 'als'=>'f' ]).'
				FROM
					bn
					'.GtSlc_QryExtra([ 't'=>'tb', 'col'=>'bn_frm', 'als'=>'f' ]).'
				WHERE
					 '.$__f.' = %s LIMIT 1', GtSQLVlStr($c_DtRg, $__ft));

			$DtRg = $__cnx->_qry($query_DtRg);

			if($DtRg){

				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;

				if($Tot_DtRg > 0){
					$Vl['id'] = $row_DtRg['id_bn'];
					$Vl['tt'] = ctjTx($row_DtRg['bn_tt'],'in');
					$Vl['dsc'] = ctjTx($row_DtRg['bn_dsc'],'in');
					$Vl['dir'] = ctjTx($row_DtRg['bn_dir'],'in');
					$Vl['enc'] = ctjTx($row_DtRg['bn_enc'],'in');
					$Vl['img'] = ctjTx($row_DtRg['bn_img'],'in');
					$Vl['ord'] = ctjTx($row_DtRg['bn_ord'],'in');
					$Vl['tp'] = ctjTx($row_DtRg['formato_sisslc_tt'],'in');
					$Vl['tp_id'] = ctjTx($row_DtRg['formato_id_sisslc'],'in');

					$Vl['w'] = $row_DtRg['bn_w'];
					$Vl['h_vd'] = $row_DtRg['bn_h_vd'];
					$Vl['w_vd'] = $row_DtRg['bn_w_vd'];
					$Vl['h'] = $row_DtRg['bn_h'];
					$Vl['crsl'] = $row_DtRg['bn_crsl'];
					$Vl['prc'] = ctjTx($row_DtRg['bnprc_tt'],'in');
				}

			}

			$__cnx->_clsr($DtRg);

		return(_jEnc($Vl));
		}
	}

	function _HtmlCln($v=NULL){

		$_v['domp'] = $v;

		if(!isN($v['cod']) && !isN($v['cod'])){

			$_ec_bld = new API_CRM_ec();
			//$_ec_bld->btrck = 'ok';
			$_ec_html = $_ec_bld->_GtNLn([
				'v'=>$v['cod'],
				'bsc'=>'ok',
				'no_mso'=>'ok',
				'tags'=>!isN($v['tag'])?$v['tag']:['img'],
				'pst'=>$v['pst']
			]);

			$_breaks_1 = ["\r\n"];
			$_breaks_2 = ["\n"];
			$_breaks_3 = ["\r"];

			$_v['dom'] = $_ec_html;

			if(!isN($_ec_html->cod)){

				$__b1 = str_replace($_breaks_1, '</br>', $_ec_html->cod);
				$__b1 = str_replace($_breaks_2, '', $__b1);
				$__b1 = str_replace($_breaks_3, '&nbsp;', $__b1);

				$_v['cod'] = $__b1;

			}

			$_v['e'] = 'ok';

		}else{

			$_v['e'] = 'no';

		}

		return _jEnc($_v);
	}



	function __SbT($p=NULL){
		return('<div class="__SbT"><div class="_bx"><span style="background-image:url('.DMN_IMG_ESTR_SVG.''.$p['i'].'.svg);"></span>'.$p['t'].'</div></div>');
	}

	function _ChkEc($_d='', $_t='ec_dir'){

		global $__cnx;

		if(($_d!='')){
			$c_DtRg = "-1";if (isset($_d)){$c_DtRg = $_d;}
			$query_DtRg = sprintf('SELECT * FROM '.TB_EC.' WHERE id_ec != "" AND '.$_t.' = %s', GtSQLVlStr($c_DtRg, 'text'));
			$DtRg = $__cnx->_qry($query_DtRg);

			if($DtRg){
				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;
			}

			$__cnx->_clsr($DtRg);

			if($Tot_DtRg==1){$_r =true;}else{$_r=false;}
			return($_r);
		}
	}

	function _ChkBn($_d='', $_t='bn_dir'){

		global $__cnx;

		if(($_d!='')){
			$c_DtRg = "-1";if (isset($_d)){$c_DtRg = $_d;}
			$query_DtRg = sprintf('SELECT * FROM '.TB_BN.' WHERE id_bn != "" AND '.$_t.' = %s', GtSQLVlStr($c_DtRg, 'text'));
			$DtRg = $__cnx->_qry($query_DtRg);

			if($DtRg){
				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;
			}

			$__cnx->_clsr($DtRg);

			if($Tot_DtRg==1){$_r =true;}else{$_r=false;}
			return($_r);
		}
	}





	function Chk_TbCol($_p=NULL){

		global $__cnx;

		if(!isN($_p['bd']) && !isN($_p['tb']) && !isN($_p['cl'])){

			if($_p['bd'] == 'dwn'){ $_p['bd_q'] = DB_DWN; }else{ $_p['bd_q'] = DB; }

			$query_DtRg = sprintf("SELECT column_name FROM information_schema.columns WHERE table_schema = %s AND table_name = %s AND column_name  = %s",
								  GtSQLVlStr($_p['bd_q'], 'text'),
								  GtSQLVlStr($_p['tb'], 'text'),
								  GtSQLVlStr($_p['cl'], 'text'));

			$DtRg = $__cnx->_qry($query_DtRg);

			if($DtRg){

				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;

				if($Tot_DtRg > 0){

					$e = 'ok';

				}else{
					$e = 'no';
				}

			}

			$__cnx->_clsr($DtRg);

			return($e);
		}

	}

	function _ChckMdlRel($_p=NULL){ // Modulo relacionado a otro modulo - Dependencias

		global $__cnx;

		if( !isN($_p['mdl']) ){

			if(!isN($_p['bd'])){ $__bdprfx=_BdStr($_p['bd']); }

			$c_DtRg = "-1";if (isset($_p['mdl'])){$c_DtRg = $_p['mdl'];}

			$_fl_tot_cnt = " ,( SELECT COUNT(*) FROM ".$__bdprfx.TB_MDL_CNT." WHERE mdlcnt_cnt = ".$_p['cnt']." AND mdlcnt_mdl = mdlmdl_main ) AS _tot_cnt ";
			$query_Ls = sprintf('SELECT * '.$_fl_tot_cnt.'
								 FROM '.$__bdprfx.TB_MDL.'
								 	INNER JOIN '._BdStr(DBM).TB_MDL_S.' ON id_mdls = mdl_mdls
								 	INNER JOIN '._BdStr(DBM).TB_MDL_S_TP.' ON id_mdlstp = mdls_tp
								 	INNER JOIN '.$__bdprfx.TB_MDL_MDL.' ON mdlmdl_main = id_mdl
								 WHERE mdlmdl_mdl = %s '.$_f, GtSQLVlStr($c_DtRg,'text'));

			$Ls = $__cnx->_qry($query_Ls);

			if(!isN($Ls)){

				$row_Ls = $Ls->fetch_assoc();
				$Tot_Ls = $Ls->num_rows;

				if($Tot_Ls > 0){

					$_v['e']='ok';

					do {

						$_id = $row_Ls['id_mdl'];
						$__dte_f = new DateTime ($row_Ls['mdl_fi']);

						$_v['ls'][$_id]['mdl_enc'] = $row_Ls['mdl_enc'];

						//$_v['ls'][$_id]['act'] = $row_Ls['actmdl_act'];
						$_v['ls'][$_id]['tx'] = ctjTx($row_Ls['mdl_nm'].' - '.$row_Ls['mdl_fi'],'in');
						$_v['ls'][$_id]['tt'] = ctjTx($row_Ls['mdl_nm'],'in');
						$_v['ls'][$_id]['fi'] = ctjTx($row_Ls['mdl_fi'],'in');

						//Hora de inicio de la actividad
						$__fch_main = GtMdlAttrDt([ 'bd'=>$_p['bd'], 'id' => $row_Ls['mdlmdl_main']/*, 'vl' => 'ok'*/ ]);


						if(!isN( $__fch_main->{_CId('ID_MDLSTPATTR_HINI')}->vl )){
							$__h_i = new DateTime ($__fch_main->{_CId('ID_MDLSTPATTR_HINI')}->vl);
							$__h = $__h_i->format('h:i a');
							$__h_full = $__h_i->format('h:i:s');
						}else{
							$__h = $__dte_f->format('h:i a');
							$__h_full = $__dte_f->format('H:i:s');
						}

						$_v['ls'][$_id]['date']['f'] = $__fch_main->{_CId('ID_MDLSTPATTR_FINI')}->vl;
						$_v['ls'][$_id]['date']['h'] = $__h;

						$_v['ls'][$_id]['date']['full'] = $__fch_main->{_CId('ID_MDLSTPATTR_FINI')}->vl.' '.$__h_full;


						if(new DateTime( $_v['ls'][$_id]['date']['full'] ) > new DateTime()) {
							$_v['ls'][$_id]['date']['est'] = 'on';
						}


						$_v['f'][] = FechaESP_OLD($row_Ls['mdl_fi']);
						$_v['ls'][$_id]['cnt'] = $row_Ls['_tot_cnt'];

					} while ($row_Ls = $Ls->fetch_assoc());

					$_v['cnts'] = $_p['cnt'];

				}else{
					$_v['e']='no';
				}

			}

		}

				$__cnx->_clsr($Ls);


		return _jEnc($_v);
	}

	function GtMdlAttrDt($p=NULL){

		global $__cnx;


		if(!isN($p['bd'])){ $__bdprfx=_BdStr($p['bd']); }


		if($p['vl'] == 'ok'){
			$_fl .=  "AND mdlattr_attr = ".ID_MDLSTPATTR_FINI;
		}

		$_Ls_Qry = "SELECT * FROM ".$__bdprfx.TB_MDL_ATTR."
				   	   WHERE mdlattr_mdl = ".$p['id']." $_fl";

		$Ls_Rg = $__cnx->_qry($_Ls_Qry);

		if($Ls_Rg){

			$row_Ls_Rg = $Ls_Rg->fetch_assoc();
			$Tot_Ls_Rg = $Ls_Rg->num_rows;

			if($Tot_Ls_Rg > 0){
	            do{
		            $_r[$row_Ls_Rg['mdlattr_attr']]['vl'] = ctjTx($row_Ls_Rg['mdlattr_vl'],'in');
	            } while ($row_Ls_Rg = $Ls_Rg->fetch_assoc());
	        }

        }

        $__cnx->_clsr($Ls_Rg);

		$rtrn = _jEnc($_r);
		return($rtrn);

	}

	function GtSisEcCrt_Ls($p=NULL){

		$_Ls_Enf = __LsDt([ 'k'=>'sgm' ]);

		foreach($_Ls_Enf->ls->sgm as $_k => $_v){
			$Vl[$_v->id] = [ 'id'=>ctjTx($_v->id,'in'),
							 'tt'=>ctjTx($_v->tt, 'in'),
							 'key'=>ctjTx($_v->key->vl, 'in'),
							 'keyi'=>ctjTx($_v->keyi->vl, 'in'),
							 'keyc'=>ctjTx($_v->keyc->vl, 'in'),
							 'tp'=>ctjTx($_v->tp->vl, 'in')
							];
		}

		return(_jEnc($Vl));
	}

	function GtCdDt($p=NULL){

		global $__cnx;

		if( $p['tp']=="enc" ){ $_fl = " AND siscd_enc = '".$p['id']."' "; }else{ $_fl = " AND id_siscd = ".$p['id']." "; }

		$Dt_Qry = "	SELECT *
					FROM "._BdStr(DBM).TB_SIS_CD."
						 INNER JOIN "._BdStr(DBM).TB_SIS_CD_DP." ON siscd_dp = id_siscddp
						 INNER JOIN "._BdStr(DBM).TB_SIS_PS." ON siscddp_ps = id_sisps
					WHERE id_siscd != '' $_fl ";

		$Ls_Rg = $__cnx->_qry($Dt_Qry);

		if($Ls_Rg){
			$row_Ls_Rg = $Ls_Rg->fetch_assoc();
			$Tot_Ls_Rg = $Ls_Rg->num_rows;

			if($Tot_Ls_Rg > 0){

				$img_th = _ImVrs([ 'img'=>$row_Ls_Rg['sisps_img'], 'f'=>DMN_FLE_PS ]);

				$Vl['id'] = $row_Ls_Rg['id_siscd'];
				$Vl['enc'] = ctjTx($row_Ls_Rg['siscd_enc'], 'in');
				$Vl['tt'] = ctjTx($row_Ls_Rg['siscd_tt'], 'in');

				$Vl['ps'] =	[
								'id'=>$row_Ls_Rg['id_sisps'],
								'tt'=>ctjTx($row_Ls_Rg['sisps_tt'],'in'),
								'img'=>[
									'fle'=>$row_Ls_Rg['sisps_img'],
									'url'=>$img_th
								]
							];

	        }
		}

		$__cnx->_clsr($Ls_Rg);

		return(_jEnc($Vl));;
	}


	function GtCdDpDt($p=NULL){

		global $__cnx;

		if( $p['tp']=="enc" ){ $_fl = " AND siscddp_enc = '".$p['id']."' "; }else{ $_fl = " AND id_siscddp = ".$p['id']." "; }

		$Dt_Qry = "	SELECT *
					FROM "._BdStr(DBM).TB_SIS_CD_DP."
					WHERE id_siscddp != '' $_fl ";

		$Ls_Rg = $__cnx->_qry($Dt_Qry);

		if($Ls_Rg){
			$row_Ls_Rg = $Ls_Rg->fetch_assoc();
			$Tot_Ls_Rg = $Ls_Rg->num_rows;

			if($Tot_Ls_Rg > 0){

				//$img_th = _ImVrs([ 'img'=>$row_Ls_Rg['sisps_img'], 'f'=>DMN_FLE_PS ]);

				$Vl['id'] = $row_Ls_Rg['id_siscddp'];
				$Vl['enc'] = ctjTx($row_Ls_Rg['siscddp_enc'], 'in');
				$Vl['tt'] = ctjTx($row_Ls_Rg['siscddp_tt'], 'in');

				/*$Vl['ps'] =	[
								'id'=>$row_Ls_Rg['id_sisps'],
								'tt'=>ctjTx($row_Ls_Rg['sisps_tt'],'in'),
								'img'=>[
									'fle'=>$row_Ls_Rg['sisps_img'],
									'url'=>$img_th
								]
							];*/

	        }
		}

		$__cnx->_clsr($Ls_Rg);

		return(_jEnc($Vl));;
	}

	function GtCntEstTpDt($p=NULL){

		global $__cnx;

		if( $p['tp']=="enc" ){ $_fl = " AND siscntesttp_enc = '".$p['id']."' "; }else{ $_fl = " AND id_siscntesttp = ".$p['id']." "; }

		$Dt_Qry = "	SELECT *
						FROM "._BdStr(DBM).TB_SIS_CNT_EST_TP."
					INNER JOIN "._BdStr(DBM).TB_CL." ON siscntesttp_cl = id_cl
					WHERE id_siscntesttp != '' $_fl AND cl_enc = '".CL_ENC."' ";

		$Ls_Rg = $__cnx->_qry($Dt_Qry);

		if($Ls_Rg){
			$row_Ls_Rg = $Ls_Rg->fetch_assoc();
			$Tot_Ls_Rg = $Ls_Rg->num_rows;

			if($Tot_Ls_Rg > 0){

				$Vl['id'] = $row_Ls_Rg['id_siscntesttp'];
				$Vl['enc'] = ctjTx($row_Ls_Rg['siscntesttp_enc'], 'in');
				$Vl['tt'] = ctjTx($row_Ls_Rg['siscntesttp_tt'], 'in');

	        }
		}

		$__cnx->_clsr($Ls_Rg);

		return(_jEnc($Vl));;
	}


	function GtLrnDt($p=NULL){

		global $__cnx;

		if($p['tp'] == 'id'){
			$_fl .= "AND id_lrn = ".$p['id']." ";
		}

		$query_DtRg = sprintf('SELECT * FROM '._BdStr(DBM).TB_LRN.'
					INNER JOIN '._BdStr(DBM).TB_LRN_VD.' ON id_lrn = lrnvd_lrn
					INNER JOIN '._BdStr(DBM).TB_LRN_VD_CL.' ON id_lrnvd = lrnvdcl_lrnvd
					INNER JOIN '._BdStr(DBM).TB_CL.' ON id_cl = lrnvdcl_cl
					WHERE id_lrn != "" '.$_fl.' AND lrn_e = 1 AND cl_enc = "'.CL_ENC.'" AND lrnvd_e = 1 GROUP BY id_lrn ORDER BY lrn_ord ASC');
		$Vl['qry'] = $query_DtRg;
		$DtRg = $__cnx->_qry($query_DtRg);

		if($DtRg){

			$row_DtRg = $DtRg->fetch_assoc();
			$Tot_DtRg = $DtRg->num_rows;

			if($Tot_DtRg > 0){

				do{

					$Vl[$row_DtRg['id_lrn']]['id'] = $row_DtRg['id_lrn'];
					$Vl[$row_DtRg['id_lrn']]['tt'] = ctjTx($row_DtRg['lrn_tt'],'in');
					$Vl[$row_DtRg['id_lrn']]['dsc'] = ctjTx($row_DtRg['lrn_dsc'],'in');
					$Vl[$row_DtRg['id_lrn']]['enc'] = ctjTx($row_DtRg['lrn_enc'],'in');
					$Vl[$row_DtRg['id_lrn']]['img'] = _ImVrs([ 'img'=>$row_DtRg['lrn_img'], 'f'=>DMN_FLE_LRN ]);
					$Vl[$row_DtRg['id_lrn']]['vds'] = GtLrnVdDt(["tp"=>"lrn", "id"=>$row_DtRg['id_lrn']]);

				}while($row_DtRg = $DtRg->fetch_assoc());

			}

		}

		$__cnx->_clsr($DtRg);

		return(_jEnc($Vl));
	}

	function GtLrnVdDt($p=NULL){

		global $__cnx;

		if($p['tp'] == 'enc'){ $_fl .= "AND lrnvd_enc = '".$p['id']."' "; }
		elseif($p['tp'] == 'lrn'){ $_fl .= "AND lrnvd_lrn = ".$p['id']." "; }
		elseif($p['tp'] == 'lrn_enc'){ $_fl .= "AND lrnvd_lrn IN (SELECT id_lrn FROM ".TB_LRN." WHERE lrn_enc = '".$p['id']."' ) "; }
		else{  }

		$query_DtRg = sprintf('SELECT * FROM '._BdStr(DBM).TB_LRN_VD.'
									INNER JOIN '._BdStr(DBM).TB_LRN.' ON lrnvd_lrn = id_lrn
									INNER JOIN '._BdStr(DBM).TB_LRN_VD_CL.' ON lrnvdcl_lrnvd = id_lrnvd
									INNER JOIN '._BdStr(DBM).TB_CL.' ON lrnvdcl_cl = id_cl
									LEFT JOIN '._BdStr(DBM).TB_LRN_VD_CMNT.' ON lrnvdcmnt_lrnvd = id_lrnvd
									LEFT JOIN '._BdStr(DBM).TB_US.' ON lrnvdcmnt_us = id_us
									WHERE id_lrnvd != "" '.$_fl.' AND lrnvd_e = 1 AND cl_enc = "'.CL_ENC.'"');

		$DtRg = $__cnx->_qry($query_DtRg);

		//$Vl['qry'] = $query_DtRg;

		if($DtRg){

			$Vl['e'] = 'ok';

			$row_DtRg = $DtRg->fetch_assoc();
			$Tot_DtRg = $DtRg->num_rows;

			if($Tot_DtRg > 0){

				do{

					$Vl['id'] = $row_DtRg['id_lrnvd'];
					$Vl['url'] = ctjTx($row_DtRg['lrnvd_url'],'in');

					$Vl[$row_DtRg['id_lrnvd']]['id'] = $row_DtRg['id_lrnvd'];
					$Vl[$row_DtRg['id_lrnvd']]['tt'] = ctjTx($row_DtRg['lrnvd_tt'],'in');
					$Vl[$row_DtRg['id_lrnvd']]['url'] = ctjTx($row_DtRg['lrnvd_url'],'in');
					$Vl[$row_DtRg['id_lrnvd']]['dsc'] = ctjTx($row_DtRg['lrnvd_dsc'],'in');
					$Vl[$row_DtRg['id_lrnvd']]['enc'] = ctjTx($row_DtRg['lrnvd_enc'],'in');
					$Vl[$row_DtRg['id_lrnvd']]['fle'] = ctjTx($row_DtRg['lrnvd_fle'],'in');

					if( !isN($row_DtRg['id_lrnvdcmnt']) ){
						$Vl['cmnt'][$row_DtRg['id_lrnvdcmnt']]['tx'] = ctjTx($row_DtRg['lrnvdcmnt_cmnt'],'in');
						$Vl['cmnt'][$row_DtRg['id_lrnvdcmnt']]['us'] = ctjTx($row_DtRg['us_nm']." ".$row_DtRg['us_ap'],'in');
						$Vl['cmnt'][$row_DtRg['id_lrnvdcmnt']]['fi'] = ctjTx($row_DtRg['lrnvdcmnt_fi'],'in');
					}

				}while($row_DtRg = $DtRg->fetch_assoc());

			}

		}

		$__cnx->_clsr($DtRg);

		return(_jEnc($Vl));
	}

	function GtSisSlcFDt($p){

		global $__cnx;

		$Vl['e'] = 'no';

		if( !isN($p['id'])){

			if($p['t'] == 'enc'){
				$__fl .= " AND sisslcf_enc = ".GtSQLVlStr($p['id'],'text')." ";
			}else{
				$__fl .= " AND id_sisslcf = ".GtSQLVlStr($p['id'],'int')." ";
			}

			$query_DtRg = sprintf('SELECT * FROM '._BdStr(DBM).TB_SIS_SLC_F.' WHERE id_sisslcf IS NOT NULL '.$__fl.'  LIMIT 1');
			$DtRg = $__cnx->_qry($query_DtRg);

			if($DtRg){

				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;

				if($Tot_DtRg > 0){
					$Vl['e'] = 'ok';
					$Vl['id'] = $row_DtRg['id_sisslcf'];
					$Vl['nm'] = ctjTx($row_DtRg['sisslcf_tt'],'in');
					//$Vl['vl'] = ctjTx($row_DtRg['sisslcf_vl'],'in','',['html'=>'ok','schr'=>'no','nl2'=>'no'] );
				}

			}

			$__cnx->_clsr($DtRg);

		}

		return(_jEnc($Vl));

	}

	function GtPxlLs($_p=NULL){

		global $__cnx;

		$Vl['e'] = 'no';

		if(!isN($_p['bd'])){ $_bd=_BdStr($_p['bd']); }else{ $_bd=''; }

		if($_p['t']=='mdl_gen'){
			$__inr = " INNER JOIN ".$_bd.TB_MDL_GEN_PXL." ON mdlgenpxl_pxl = id_sispxl";
			$__inr_id = "mdlgenpxl_mdlgen";
		}elseif($_p['t']=='mdl'){
			$__inr = " INNER JOIN ".$_bd.TB_MDL_PXL." ON mdlpxl_pxl = id_sispxl";
			$__inr_id = "mdlpxl_mdl";
		}

		if(!isN($_p["id"])){ $_fl .= "AND ".$__inr_id." = ".GtSQLVlStr($_p['id'], 'int')." "; }

		$query_DtRg = "	SELECT *,
								"._QrySisSlcF([ 'als'=>'t', 'als_n'=>'tipo' ]).",
								".GtSlc_QryExtra([ 't'=>'fld', 'p'=>'tipo', 'als'=>'t' ])."
						FROM "._BdStr(DBM).TB_SIS_PXL."
							 ".GtSlc_QryExtra([ 't'=>'tb', 'col'=>'sispxl_tp', 'als'=>'t' ])."
							 {$__inr}
						WHERE id_sispxl != '' $_fl ";

		$DtRg = $__cnx->_qry($query_DtRg);

		//$Vl['q'] = $query_DtRg;

		if($DtRg){

			$row_DtRg = $DtRg->fetch_assoc();
			$Tot_DtRg = $DtRg->num_rows;

			$Vl['tot'] = $Tot_DtRg;

			if($Tot_DtRg > 0){

				$Vl['e'] = 'ok';

				do{

					$__slcdt = __LsDt([ 'id'=>$row_DtRg['tipo_id_sisslc'], 'no_lmt'=>'ok' ]);

					$__cod_hed = $__slcdt->d->head->vl;
					$__cod_bdy = $__slcdt->d->body->vl;


					$Vl['ls'][] = [
									'id'=>ctjTx($row_DtRg['id_sispxl'], 'in'),
									'enc'=>ctjTx($row_DtRg['sispxl_enc'], 'in'),
									'tp'=>ctjTx($row_DtRg['sispxl_tp'], 'in'),
									'vl'=>[
										'v1'=>ctjTx($row_DtRg['sispxl_vl_1'], 'in'),
										'v2'=>ctjTx($row_DtRg['sispxl_vl_2'], 'in'),
										'v3'=>ctjTx($row_DtRg['sispxl_vl_3'], 'in'),
										'v4'=>ctjTx($row_DtRg['sispxl_vl_4'], 'in'),
										'v5'=>ctjTx($row_DtRg['sispxl_vl_5'], 'in'),
										'v6'=>ctjTx($row_DtRg['sispxl_vl_6'], 'in')
									],
									'thk'=>mBln($row_DtRg['sispxl_thk']),
									'hed'=>[
										'e'=>mBln($row_DtRg['sispxl_hed']),
										'cod'=>$__cod_hed
									],
									'bdy'=>[
										'e'=>mBln($row_DtRg['sispxl_bdy']),
										'cod'=>$__cod_bdy
									],
									'attr'=>$__slcdt->d
								];

				}while($row_DtRg = $DtRg->fetch_assoc());

			}else{
				$Vl['e'] = 'no';
				$Vl['w'] = TX_NTEXT;
			}
		}

		$__cnx->_clsr($DtRg);

		return(_jEnc($Vl));
	}

	function LsCntEstAreAll($p=NULL){

		global $__cnx;

		if( defined('DB_CL_ENC') || !isN($p['cl_enc']) ){

			if( !isN($p['cl_enc']) ){
				$_cl_enc = $p['cl_enc'];
			}else{
				$_cl_enc = DB_CL_ENC;
			}

			$___ses = new CRM_SES();
			$_arethree = $___ses->GtClAreAll($p);

			if(!isN($p['mdl'])){ $_fl .= sprintf(" AND mdlare_mdl = %s", GtSQLVlStr($p['mdl'],'text')); }


			$query_Ls = sprintf('SELECT *
									  FROM '.$p['bd'].TB_MDL_ARE.'
									  	   INNER JOIN '._BdStr(DBM).TB_CL_ARE.' ON mdlare_are = id_clare
									  	   INNER JOIN '._BdStr(DBM).TB_CL.' ON clare_cl = id_cl
									  WHERE cl_enc = %s '.$_fl, GtSQLVlStr($_cl_enc,'text'));

			$Ls = $__cnx->_qry($query_Ls);

			if($Ls){

				$row_Ls = $Ls->fetch_assoc();
				$Tot_Ls = $Ls->num_rows;

				if($Tot_Ls > 0){

					$Vl['tot'] = $Tot_Ls;

					do {

						$___id = $row_Ls['id_clare'];
						$___prnt = $_arethree->ls->p->{'are-'.$___id}->prnt;

						$___b[$___id] = [
											'id'=>$___id,
											'tt'=>ctjTx($row_Ls['clare_tt'],'in'),
											'clr'=>ctjTx($row_Ls['clare_clr'],'in'),
											'logo'=>ctjTx($row_Ls['clare_logo'],'in'),
											'tp'=>[
												'id'=>ctjTx($row_Ls['tipo_id_sisslc'],'in'),
												'tt'=>ctjTx($row_Ls['tipo_sisslc_tt'],'in'),
												'enc'=>ctjTx($row_Ls['tipo_sisslc_enc'],'in')
											],
											'prnt'=>$row_Ls['clare_prnt']
										];

						if(!isN($___prnt) && is_array($___prnt)){
							foreach($___prnt as $___prnt_k=>$___prnt_v){
								$___b[$___prnt_v->id] = $___prnt_v;
							}
						}

					}while($row_Ls = $Ls->fetch_assoc());

					$Vl['e'] = 'ok';
					$Vl['ls'] = $___b;

				}else{

					$Vl['e'] = 'no';

				}
			}

			$__cnx->_clsr($DtRg);

		}

		return(_jEnc($Vl));
	}

	function GtSisCntEstAreLs($p){

		global $__cnx;

		$Vl['e'] = 'no';

		if( !isN($p)){

			if(!isN($p['est'])){ $__fl .= " AND siscntestare_est = ".GtSQLVlStr($p['est'],'int')." "; }

			$query_DtRg = sprintf('	SELECT *
									FROM '._BdStr(DBM).TB_SIS_CNT_EST_ARE.'
										 INNER JOIN '._BdStr(DBM).TB_CL_ARE.' ON siscntestare_are = id_clare
									WHERE id_clare IS NOT NULL '.$__fl);

			$DtRg = $__cnx->_qry($query_DtRg);

			if($DtRg){

				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;

				if($Tot_DtRg > 0){

					$Vl['e'] = 'ok';

					do {

						$___id = $row_DtRg['id_clare'];

						$Vl['ls'][$___id] = [
												'id'=>$___id,
												'tt'=>ctjTx($row_DtRg['clare_tt'],'in'),
												'clr'=>ctjTx($row_DtRg['clare_clr'],'in'),
												'logo'=>ctjTx($row_DtRg['clare_logo'],'in'),
												'tp'=>[
													'id'=>ctjTx($row_DtRg['tipo_id_sisslc'],'in'),
													'tt'=>ctjTx($row_DtRg['tipo_sisslc_tt'],'in'),
													'enc'=>ctjTx($row_DtRg['tipo_sisslc_enc'],'in')
												]
											];

						$_html_li .= li(ctjTx($row_DtRg['clare_tt'],'in'));

					}while($row_DtRg = $DtRg->fetch_assoc());


					$Vl['html'] = ul($_html_li, 'are_ls');

				}

			}

			$__cnx->_clsr($DtRg);

		}

		return(_jEnc($Vl));

	}

	function GtSisBcoUseTot($_p=NULL){

		global $__cnx;

		if(($_p['id_bco']!=NULL)){
			$c_DtRg = "-1";if($_p['id_bco']!=NULL){$c_DtRg = $_p['id'];}

			$query_DtRg = sprintf("	SELECT COUNT(*) AS _tot FROM "._BdStr(DBM).TB_BCO_USD." WHERE bcouse_bco = %s ",
									GtSQLVlStr($_p['id_bco'], 'int'));
			$DtRg = $__cnx->_qry($query_DtRg);

			if($DtRg){
				$Tot_DtRg = $DtRg->num_rows;
				$row_DtRg = $DtRg->fetch_assoc();
				$Vl['tot'] = $Tot_DtRg;

				if($Tot_DtRg > 0){
					$Vl['_tot'] = $row_DtRg['_tot'];
				}
			}

			$__cnx->_clsr($DtRg);

			return(_jEnc($Vl));
		}
	}

	function GtBcoAttrDt($_p=NULL){

		global $__cnx;

		if(($_p['id']!=NULL)){


			$query_DtRg = sprintf("SELECT * FROM "._BdStr(DBM).TB_BCO_ATTR." WHERE bcoattr_bco = %s ORDER BY bcoattr_k ASC", GtSQLVlStr($_p['id'], 'int'));
			$DtRg = $__cnx->_qry($query_DtRg);

			if($DtRg){

				$Tot_DtRg = $DtRg->num_rows;

				if($Tot_DtRg > 0){
					do{
		                $Vl[$row_DtRg['id_bcoattr']]['e'] = 'ok';
						$Vl[$row_DtRg['id_bcoattr']]['id'] = $row_DtRg['id_bcoattr'];
						$Vl[$row_DtRg['id_bcoattr']]['bco'] = $row_DtRg['id_bcoattr'];
						$Vl[$row_DtRg['id_bcoattr']]['k'] = $row_DtRg['bcoattr_k'];
						$Vl[$row_DtRg['id_bcoattr']]['v'] = $row_DtRg['bcoattr_v'];
					} while ($row_DtRg = $DtRg->fetch_assoc());
				}else{
					$Vl['e'] = 'no';
				}

			}

			$__cnx->_clsr($DtRg);

		return(_jEnc($Vl));
		}
	}

	function GtBcoAreDt($_p=NULL){

		global $__cnx;

		if(!isN($_p['bco']) && !isN($_p['are'])){


			$query_DtRg = sprintf("SELECT * FROM "._BdStr(DBM).TB_BCO_ARE." WHERE bcoare_bco = %s AND bcoare_are = %s",
						GtSQLVlStr($_p['bco'], 'int'),
						GtSQLVlStr($_p['are'], 'int'));
			$DtRg = $__cnx->_qry($query_DtRg);

			if($DtRg){

				$Tot_DtRg = $DtRg->num_rows;

				if($Tot_DtRg > 0){
		                $Vl['e'] = 'ok';
						$Vl['id'] = $row_DtRg['id_bcoare'];
				}else{
					$Vl['e'] = 'no';
				}

			}

			$__cnx->_clsr($DtRg);

		return(_jEnc($Vl));
		}
	}

	function GtBcoCdDt($_p=NULL){

		global $__cnx;

		if(!isN($_p['bco']) && !isN($_p['cd'])){

			$query_DtRg = sprintf("SELECT * FROM "._BdStr(DBM).TB_BCO_CD." WHERE bcocd_bco = %s  AND bcocd_cd = %s",
						GtSQLVlStr($_p['bco'], 'int'),
						GtSQLVlStr($_p['cd'], 'int'));

			$DtRg = $__cnx->_qry($query_DtRg);

			if($DtRg){
				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;

				if($Tot_DtRg > 0){
		                $Vl['e'] = 'ok';
						$Vl['id'] = $row_DtRg['id_bcocd'];
				}else{
					$Vl['e'] = 'no';
				}

			}

			$__cnx->_clsr($DtRg);

		return(_jEnc($Vl));
		}
	}

	function GtBcoTagDt($_p=NULL){

		global $__cnx;

		if(!isN($_p['bco']) && !isN($_p['tag_es'])){


			$query_DtRg = sprintf("SELECT * FROM "._BdStr(DBM).TB_BCO_TAG." WHERE bcotag_bco=%s  AND bcotag_tag_es=%s",
						GtSQLVlStr($_p['bco'], 'int'),
						GtSQLVlStr(ctjTx($_p['tag_es'],'out'), 'text'));

			$DtRg = $__cnx->_qry($query_DtRg);

			if($DtRg){
				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;

				if($Tot_DtRg > 0){
		                $Vl['e'] = 'ok';
						$Vl['id'] = $row_DtRg['id_bcotag'];
				}else{
					$Vl['e'] = 'no';
				}

			}

			$__cnx->_clsr($DtRg);

		return(_jEnc($Vl));
		}
	}

	function GtBcoFceDt($_p=NULL){

		global $__cnx;

		if(!isN($_p)){


			if(!isN($_p['cid'])){ $__fl .= " AND bcofce_id = ".GtSQLVlStr($_p['cid'],'text')." "; }
			if(!isN($_p['bco'])){ $__fl .= " AND bcofce_bco = ".GtSQLVlStr($_p['bco'],'int')." "; }
			if(!isN($_p['enc'])){ $__fl .= " AND bcofce_enc = ".GtSQLVlStr($_p['enc'],'text')." "; }

			$query_DtRg = sprintf("SELECT * FROM "._BdStr(DBM).TB_BCO_FCE." WHERE id_bcofce != '' {$__fl}");

			$DtRg = $__cnx->_qry($query_DtRg);

			if($DtRg){
				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;

				if($Tot_DtRg > 0){
	                $Vl['e'] = 'ok';
					$Vl['id'] = $row_DtRg['id_bcofce'];
					$Vl['enc'] = $row_DtRg['bcofce_enc'];
					$Vl['cid'] = $row_DtRg['bcofce_id'];
					$Vl['img']['main'] = DMN_FLE_BCO_FCE.$row_DtRg['bcofce_img'];
					$Vl['img']['th'] = DMN_FLE_BCO_FCE_TH.$row_DtRg['bcofce_img'];
				}else{
					$Vl['e'] = 'no';
				}

			}

			$__cnx->_clsr($DtRg);

		return(_jEnc($Vl));
		}
	}

	function GtBcoFceAttrDt($_p=NULL){

		global $__cnx;

		if(!isN($_p['bco_fce']) && !isN($_p['key'])){


			$query_DtRg = sprintf("SELECT * FROM "._BdStr(DBM).TB_BCO_FCE_ATTR." WHERE bcofceattr_bcofce=%s AND bcofceattr_key=%s",
						GtSQLVlStr($_p['bco_fce'], 'int'),
						GtSQLVlStr(ctjTx($_p['key'],'out'), 'int'));

			$DtRg = $__cnx->_qry($query_DtRg);

			if($DtRg){
				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;

				if($Tot_DtRg > 0){
		                $Vl['e'] = 'ok';
						$Vl['id'] = $row_DtRg['id_bcofce'];
				}else{
					$Vl['e'] = 'no';
				}

			}

			$__cnx->_clsr($DtRg);

		return(_jEnc($Vl));
		}
	}

	function GtBcoChkDt($_p=NULL){

		global $__cnx;

		if(!isN($_p['bco']) && !isN($_p['chk'])){


			$query_DtRg = sprintf("SELECT * FROM "._BdStr(DBM).TB_BCO_CHK." WHERE bcochk_bco=%s  AND bcochk_chktp=%s",
						GtSQLVlStr($_p['bco'], 'int'),
						GtSQLVlStr(ctjTx($_p['chk'],'out'), 'text'));

			$DtRg = $__cnx->_qry($query_DtRg);

			if($DtRg){

				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;

				if($Tot_DtRg > 0){
		                $Vl['e'] = 'ok';
						$Vl['id'] = $row_DtRg['id_bcochk'];
				}else{
					$Vl['e'] = 'no';
				}

			}

			$__cnx->_clsr($DtRg);

		}

		return(_jEnc($Vl));

	}

	function GtSisBcoTot($_p=NULL){

		global $__cnx;

			$query_DtRg = "SELECT COUNT(*) AS _tot FROM "._BdStr(DBM).TB_BCO." ";
			$DtRg = $__cnx->_qry($query_DtRg);

			if($DtRg){

				$Tot_DtRg = $DtRg->num_rows;
				$row_DtRg = $DtRg->fetch_assoc();

				if($Tot_DtRg > 0){
					$Vl['tot'] = $row_DtRg['_tot'];
				}

			}

			$__cnx->_clsr($DtRg);

			return(_jEnc($Vl));

	}

	function GtDt_HSHTwD($Id, $Tp=''){

		global $__cnx;

		if(!isN($Id)){

			$colname_DtRg = "-1";if (isset($Id)){$colname_DtRg = $Id;}
			$Dt_Qry = sprintf("SELECT * FROM "._BdStr(DBM).TB_HSH." WHERE hsh_enc = %s", GtSQLVlStr($colname_DtRg, "text"));
			$DtRg = $__cnx->_qry($Dt_Qry);

			if($DtRg){

				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;

				if($Tot_DtRg > 0){

					$Vl['e'] = 'ok';
					$Vl['tot'] = $Tot_DtRg;

					do{

						$Vl['id'] = $row_DtRg['id_hsh'];
						$Vl['enc'] = ctjTx($row_DtRg['hsh_enc'],'in');
						$Vl['tx'] = ctjTx($row_DtRg['hsh_tx'],'in');
						$Vl['dsgn'] = ctjTx($row_DtRg['hsh_dsgn'],'in');

					} while ($row_DtRg = $DtRg->fetch_assoc());

				}

			}

			$__cnx->_clsr($DtRg);

			return(_jEnc($Vl));
		}
	}


	function GtRdDt($Id, $Tp=''){

		global $__cnx;

		if(!isN($Id)){

			if($Tp == 'pm'){ $__f = 'rd_pml'; $__ft = 'text'; }
			elseif($Tp == 'enc'){ $__f = 'rd_enc'; $__ft = 'text'; }
			elseif($Tp == 'fld'){ $__f = 'rd_dir'; $__ft = 'text'; }
			else{ $__f = 'id_rd'; $__ft = 'int'; }

			$c_DtRg = "-1";if (isset($Id)){$c_DtRg = $Id;}
			$query_DtRg = sprintf('	SELECT 	id_rd, rd_enc, rd_tt, rd_dsc, rd_img, rd_fle,
											rd_w, rd_tp, rd_dir, rd_fnd, rd_pml, rd_issuu,
											rd_authid, rd_tp, rd_logo, rd_bckg, rd_thme, rd_fa, cl_enc,
											'._QrySisSlcF([ 'als'=>'thme', 'als_n'=>'theme' ]).',
											'.GtSlc_QryExtra(['t'=>'fld', 'p'=>'thme', 'als'=>'thme']).',
											'._QrySisSlcF([ 'als'=>'bckg', 'als_n'=>'backg' ]).',
											'.GtSlc_QryExtra(['t'=>'fld', 'p'=>'bckg', 'als'=>'bckg']).'
									FROM '.TB_RD.'
										  INNER JOIN '.TB_CL_ARE.' ON id_clare = rd_are
										  INNER JOIN '.TB_CL.' ON rd_cl = id_cl
										  '.GtSlc_QryExtra(['t'=>'tb', 'col'=>'rd_thme', 'als'=>'thme']).'
										  '.GtSlc_QryExtra(['t'=>'tb', 'col'=>'rd_bckg', 'als'=>'bckg']).'
									WHERE  	id_rd != "" AND
											'.$__f.' = %s
									LIMIT 1', GtSQLVlStr($c_DtRg, $__ft));

			$DtRg = $__cnx->_qry($query_DtRg);

			if($DtRg){

				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;

				if($Tot_DtRg > 0){

					$Vl['id'] = $row_DtRg['id_rd'];
					$Vl['tt'] = ctjTx($row_DtRg['rd_tt'],'in');

					$Vl['dsc'] = ctjTx($row_DtRg['rd_dsc'],'in');
					$Vl['enc'] = ctjTx($row_DtRg['rd_enc'],'in');
					$Vl['img'] = $row_DtRg['rd_img'];
					$Vl['fle'] = ctjTx($row_DtRg['rd_fle'],'in');
					$Vl['w'] = $row_DtRg['rd_w'];

					$Vl['tp'] = $row_DtRg['rd_tp'];
					$Vl['fld'] = ctjTx($row_DtRg['rd_dir'],'in');
					$Vl['fnd'] = ctjTx($row_DtRg['rd_fnd'],'in');
					$Vl['pml'] = ctjTx($row_DtRg['rd_pml'],'in');

					$Vl['logo'] = mBln($row_DtRg['rd_logo']);

					$Vl['issuu'] = $row_DtRg['rd_issuu'];
					$Vl['auth'] = $row_DtRg['rd_authid'];
					$Vl['tp'] = $row_DtRg['rd_tp'];

					$Vl['fa'] = $row_DtRg['rd_fa'];

					$Vl['cl']['lgo']['ico'] = _ImVrs([ 'img'=>$row_DtRg['cl_enc'].'.ico', 'f'=>DMN_FLE_CL_LGO_ICO ]);

					$Vl['url'] = !isN($row_DtRg['rd_fle']) ? DMN_FLE_RD.ctjTx($row_DtRg['rd_fle'],'in') : '';

					$__thme = json_decode($row_DtRg['___theme']);

					foreach($__thme as $__thme_k=>$__thme_v){
						$__theme_go->{$__thme_v->key} = $__thme_v;
					}

					$Vl['thme'] = $__theme_go->key->vl;
					$Vl['bckg'] = !isN($row_DtRg['bckg_sisslc_img_bck']) ? DMN_FLE_SIS_SLC_BCK.$row_DtRg['bckg_sisslc_img_bck'] : '';

				}

			}else{

				echo $__cnx->c_r->error;

			}

		}

		$__cnx->_clsr($DtRg);

		return _jEnc($Vl);

	}

	function GtLsChckDt($p=NULL){

		global $__cnx;

		$query_DtRg = sprintf('	SELECT *
								FROM '.TB_MDL_CNT_CHCK.'
									 INNER JOIN '._BdStr(DBM).TB_SIS_SLC.' ON id_sisslc = mdlcntchck_sisslc
								WHERE mdlcntchck_sisslc = %s AND
									  mdlcntchck_mdlcnt = (SELECT id_mdlcnt FROM '.TB_MDL_CNT.' WHERE mdlcnt_enc = %s)',GtSQLVlStr($p['id_chk'], "int"), GtSQLVlStr($p['id'], "text") );

		$DtRg = $__cnx->_qry($query_DtRg);

		if($DtRg){

			$row_DtRg = $DtRg->fetch_assoc();
			$Tot_DtRg = $DtRg->num_rows;

			if($Tot_DtRg > 0){
				$Vl['est'] = ctjTx($row_DtRg['mdlcntchck_est'],'in');
			}

		}

		$__cnx->_clsr($DtRg);

		$rtrn = _jEnc($Vl);
		return($rtrn);
	}

	function GtOrgSdsCntDt($p=NULL){

		global $__cnx;

		$_r['e'] = 'no';

		if((!isN($p['cnt']) && !isN($p['orgsds'])) || !isN($p['id'])){

			if(!isN($p['bd'])){ $_bd=_BdStr($p['bd']); }else{ $_bd=''; }

			if(!isN($p['tpro'])){ $__fl .= ' AND orgsdscnt_tpr_o="'.$p['tpro'].'" ' ; }
			if(!isN($p['cnt'])){ $__fl .= ' AND orgsdscnt_cnt ="'.$p['cnt'].'" ' ; }
			if(!isN($p['orgsds'])){ $__fl .= ' AND orgsdscnt_orgsds ="'.$p['orgsds'].'" ' ; }

			if(!isN($p['id']) && $p['t']=='enc'){ $__fl .= ' AND orgsdscnt_enc ="'.$p['id'].'" ' ; }
			elseif(!isN($p['id'])){ $__fl .= ' AND id_orgsdscnt ="'.$p['id'].'" ' ; }

			$Ls_Qry_His = "SELECT *,
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

								LEFT JOIN "._BdStr(DBM).TB_ORG_TP." ON orgtp_org = id_org

								".GtSlc_QryExtra(['t'=>'tb', 'col'=>'orgtp_tp', 'als'=>'tp'])."
								".GtSlc_QryExtra(['t'=>'tb', 'col'=>'orgsdscnt_tpr', 'als'=>'tpr'])."

							WHERE id_orgsdscnt != '' $__fl
							LIMIT 1";

			$Ls_Rg = $__cnx->_prc($Ls_Qry_His);

			//$_r['tmp_qry'] = compress_code($Ls_Qry_His);

			if($Ls_Rg){

				$row_Ls_Rg = $Ls_Rg->fetch_assoc();
				$Tot_Ls_Rg = $Ls_Rg->num_rows;

				if($Tot_Ls_Rg > 0){

					$_r['e'] = 'ok';

					do {

						$__idm = $row_Ls_Rg['org_enc'];
						$__idt = $row_Ls_Rg['tp_sisslc_cns'];
	                    $__attr = json_decode($row_Ls_Rg['___tipo']);

	                    foreach($__attr as $__attr_k=>$__attr_v){
							$__tipo_go->{$__attr_v->key} = $__attr_v;
						}

	                    $_r['id'] = $row_Ls_Rg['id_orgsdscnt'];
	                    $_r['enc'] = ctjTx($row_Ls_Rg['orgsdscnt_enc'],'in');

						$_r['org']['nm'] = ctjTx($row_Ls_Rg['org_nm'],'in');
						$_r['org']['enc'] = ctjTx($row_Ls_Rg['org_enc'],'in');

						$_nm_prfx = '';
						$_nm_sfx = '';

						if($row_Ls_Rg['id_siscd'] != '1'){ $_nm_prfx = '('.ctjTx($row_Ls_Rg['siscd_tt'], 'in').') '; }
		                if(!isN($row_Ls_Rg['orgsds_nm']) && $row_Ls_Rg['orgsds_nm'] != TX_PC){ $_nm_sfx = ' - '.ctjTx($row_Ls_Rg['orgsds_nm'], 'in'); }

		                $_r['org']['nm_fll'] = $_nm_prfx.ctjTx($row_Ls_Rg['org_nm'],'in').$_nm_sfx;

						$_r['org']['img'] = _ImVrs(['img'=>$row_Ls_Rg['org_img'], 'f'=>DMN_FLE_ORG ]);
						$_r['org']['clr'] = ctjTx($row_Ls_Rg['org_clr'],'in');

						$_r['org']['sds']['id'] = $row_Ls_Rg['id_orgsds'];
						$_r['org']['sds']['enc'] = ctjTx($row_Ls_Rg['orgsds_enc'],'in');


						$_r['cnt']['id'] = $row_Ls_Rg['orgsdscnt_cnt'];

						$_r['tpr']['id'] = $row_Ls_Rg['orgsdscnt_tpr'];
						$_r['tpr']['tt'] = ctjTx($row_Ls_Rg['tpr_sisslc_tt'],'in');
						$_r['tpr']['cns'] = ctjTx($row_Ls_Rg['tpr_sisslc_cns'],'in');
						$_r['tpr']['img'] = DMN_FLE_SIS_SLC.$row_Ls_Rg['tpr_sisslc_img'];

						$_r['tp'][$__idt]['id'] = $row_Ls_Rg['orgtp_tp'];
						$_r['tp'][$__idt]['enc'] = ctjTx($row_Ls_Rg['tp_sisslc_enc'],'in');
						$_r['tp'][$__idt]['tt'] = ctjTx($row_Ls_Rg['tp_sisslc_tt'],'in');
						$_r['tp'][$__idt]['img'] = DMN_FLE_SIS_SLC.$row_Ls_Rg['tp_sisslc_img'];
						$_r['tp'][$__idt]['attr'] = $__tipo_go;

					} while ($row_Ls_Rg = $Ls_Rg->fetch_assoc());

	            }

				if(is_array($_c)){ $__c = implode(',', $_c); } else{ $__c = $_c; }

			}

			$__cnx->_clsr($Ls_Rg);

		}else{

			$_r['w'] = 'No all data to check';

		}

		$rtrn = _jEnc($_r);
		if($p['r'] == 'c'){ return($__c); }else{ return($rtrn); }
	}

	function GtOrgDt($p=NULL){

		global $__cnx;

		$__org = new CRM_Org();

		$_r['e'] = 'no';

		if(!isN($p['i'])){

			if(!isN($p['bd'])){ $_bd=$p['bd']; }else{ $_bd=''; }

			if($p['t'] == 'enc'){ $__f = 'org_enc'; $__ft = 'text'; }else{ $__f = 'id_org'; $__ft = 'int'; }

			$_fl_sds = ", (SELECT COUNT(*) FROM "._BdStr(DBM).TB_ORG_SDS." WHERE orgsds_org = id_org) AS _sds";
			$_fl_gst = ", (SELECT COUNT(*) FROM ".$_bd.TB_ORG_GST." WHERE orggst_org = id_org) AS _gst";

			$_fl_sds_cnt = ", (SELECT COUNT(*) FROM ".$_bd.TB_ORG_SDS_CNT." INNER JOIN "._BdStr(DBM).TB_ORG_SDS." ON orgsdscnt_orgsds = id_orgsds WHERE orgsdscnt_orgsds = id_orgsds AND orgsdscnt_tpr = '"._CId('ID_ORGCNTRTP_TRB_PRST')."') AS _cnt";

			$_fl_eml = ", (SELECT COUNT(*) FROM "._BdStr(DBM).TB_ORG_SDS_EML." INNER JOIN "._BdStr(DBM).TB_ORG_SDS." ON orgsdseml_orgsds = id_orgsds WHERE orgsds_org = id_org) AS _eml";
			$_fl_tel = ", (SELECT COUNT(*) FROM "._BdStr(DBM).TB_ORG_SDS_TEL." INNER JOIN "._BdStr(DBM).TB_ORG_SDS." ON orgsdstel_orgsds = id_orgsds WHERE orgsds_org = id_org) AS _tel";
			$_fl_doc = ", (SELECT COUNT(*) FROM "._BdStr(DBM).TB_ORG_SDS_DC." INNER JOIN "._BdStr(DBM).TB_ORG_SDS." ON orgsdsdc_orgsds = id_orgsds WHERE orgsds_org = id_org) AS _dc";
			$_fl_web = ", (SELECT COUNT(*) FROM "._BdStr(DBM).TB_ORG_WEB." WHERE orgweb_org = id_org) AS _web";


			if(in_array('clg', $p['tp'])){
				$_fl_enf = ", (SELECT COUNT(*) FROM "._BdStr(DBM).TB_ORG_ENF." WHERE orgenf_org = id_org) AS _enf";
				$_fl_lng = ", (SELECT COUNT(*) FROM "._BdStr(DBM).TB_ORG_LNG." WHERE orglng_org = id_org) AS _lng";
				$_fl_bch = ", (SELECT COUNT(*) FROM "._BdStr(DBM).TB_ORG_BCH." WHERE orgbch_org = id_org) AS _bch";
				$_fl_exa = ", (SELECT COUNT(*) FROM "._BdStr(DBM).TB_ORG_EXA." WHERE orgexa_org = id_org) AS _exa";
			}

			$Ls_Qry = "SELECT *,
								"._QrySisSlcF([ 'als'=>'tp', 'als_n'=>'tipo' ]).",
								".GtSlc_QryExtra(['t'=>'fld', 'p'=>'tp', 'als'=>'tp'])."
								$_fl_cty $_fl_eml $_fl_tel $_fl_sds $_fl_gst $_fl_sds_cnt $_fl_eml $_fl_doc $_fl_web $_fl_enf $_fl_lng $_fl_bch $_fl_exa
							FROM
								"._BdStr(DBM).TB_ORG."
								LEFT JOIN "._BdStr(DBM).TB_ORG_TP." ON orgtp_org = id_org
								".GtSlc_QryExtra([ 'l'=>'ok', 't'=>'tb', 'col'=>'orgtp_tp', 'als'=>'tp'])."
							WHERE ".$__f." = '".$p['i']."'
							LIMIT 1";

			//$_r['q'] = $Ls_Qry;

			$Ls_Rg = $__cnx->_qry($Ls_Qry);

			if($Ls_Rg){

				$row_Ls_Rg = $Ls_Rg->fetch_assoc(); $Tot_Ls_Rg = $Ls_Rg->num_rows;

				if($Tot_Ls_Rg > 0){

					$_r['e'] = 'ok';

					$__idm = $row_Ls_Rg['org_enc'];

					$__idt = $row_Ls_Rg['tp_sisslc_cns'];

                    $__attr = json_decode($row_Ls_Rg['___tipo']);

                    foreach($__attr as $__attr_k=>$__attr_v){
						$__tipo_go->{$__attr_v->key} = $__attr_v;
					}

                    $_r['id'] = $row_Ls_Rg['id_org'];
                    $_r['enc'] = ctjTx($row_Ls_Rg['org_enc'],'in');

					$_r['nm'] = ctjTx($row_Ls_Rg['org_nm'],'in');

					$_r['img'] = _ImVrs(['img'=>$row_Ls_Rg['org_img'], 'f'=>DMN_FLE_ORG ]);
					$_r['clr'] = ctjTx($row_Ls_Rg['org_clr'],'in');

					$_r['cmpl'] = $__org->pinfo([ 't'=>$__tipo_go->key->vl, 'drw'=>$row_Ls_Rg ]);

	            }

				if(is_array($_c)){ $__c = implode(',', $_c); } else{ $__c = $_c; }

			}else{

				$_r['w'] = $__cnx->c_r->error;

			}

			$__cnx->_clsr($Ls_Rg);

		}else{

			$_r['w'] = 'no data';

		}

		$rtrn = _jEnc($_r);
		if($p['r'] == 'c'){ return($__c); }else{ return($rtrn); }

	}


	function GtOrgSdsDt($p=NULL){

		global $__cnx;

		if(!isN($p['i'])){

			if($p['t'] == 'enc'){ $__f = 'orgsds_enc'; $__ft = 'text'; }else{ $__f = 'id_orgsds'; $__ft = 'int'; }
			if(!isN($p['bd'])){ $_bd = _BdStr($p['bd']); }

			$Ls_Qry_His = "SELECT 	id_orgsds, orgsds_enc, orgsds_nm, orgsds_org,
									id_siscd, siscd_tt, id_sisps, sisps_tt, sisps_img,
									id_org, org_enc, org_nm
							FROM
								"._BdStr(DBM).TB_ORG_SDS."
								INNER JOIN "._BdStr(DBM).TB_ORG." ON orgsds_org = id_org
								INNER JOIN "._BdStr(DBM).TB_SIS_CD." ON orgsds_cd = id_siscd
								INNER JOIN "._BdStr(DBM).TB_SIS_CD_DP." ON siscd_dp = id_siscddp
								INNER JOIN "._BdStr(DBM).TB_SIS_PS." ON siscddp_ps = id_sisps
							WHERE ".$__f." = '".$p['i']."'
							LIMIT 1";

			$Ls_Rg = $__cnx->_qry($Ls_Qry_His);

			if($Ls_Rg){

				$row_Ls_Rg = $Ls_Rg->fetch_assoc(); $Tot_Ls_Rg = $Ls_Rg->num_rows;

				if($Tot_Ls_Rg > 0){

					$_r['e'] = 'ok';

                    $_r['id'] = $row_Ls_Rg['id_orgsds'];
                    $_r['enc'] = ctjTx($row_Ls_Rg['orgsds_enc'],'in');
					$_r['nm'] = ctjTx($row_Ls_Rg['orgsds_nm'],'in');


					$_nm_prfx = '';
					$_nm_sfx = '';

					if($row_Ls_Rg['id_siscd'] != '1'){

						$_nm_prfx = '('.ctjTx($row_Ls_Rg['siscd_tt'], 'in').') ';

						$_r['cd']['id'] = ctjTx($row_Ls_Rg['id_siscd'], 'in');
						$_r['cd']['nm'] = ctjTx($row_Ls_Rg['siscd_tt'], 'in');

						$_r['ps']['id'] = ctjTx($row_Ls_Rg['id_sisps'], 'in');
						$_r['ps']['nm'] = ctjTx($row_Ls_Rg['sisps_tt'], 'in');
						$_r['ps']['img'] = _ImVrs([ 'img'=>$row_Ls_Rg['sisps_img'], 'f'=>DMN_FLE_PS ]);

					}

	                if(!isN($row_Ls_Rg['orgsds_nm']) && $row_Ls_Rg['orgsds_nm'] != TX_PC){
		                $_nm_sfx = ' - '.ctjTx($row_Ls_Rg['orgsds_nm'], 'in');
		            }

	                $_r['nm_fll'] = $_nm_prfx.ctjTx($row_Ls_Rg['org_nm'],'in').$_nm_sfx;

					if($p['d']['org'] == 'ok'){
						$_r['org'] = GtOrgDt([ 'i'=>$row_Ls_Rg['orgsds_org'], 'bd'=>$_bd ]);
					}else{
						$_r['org']['id'] = $row_Ls_Rg['id_org'];
						$_r['org']['enc'] = ctjTx($row_Ls_Rg['org_enc'],'in');
						$_r['org']['nm'] = ctjTx($row_Ls_Rg['org_nm'],'in');
					}

	            }

				if(is_array($_c)){ $__c = implode(',', $_c); } else{ $__c = $_c; }

			}

			$__cnx->_clsr($Ls_Rg);

			$rtrn = _jEnc($_r);
			if($p['r'] == 'c'){ return($__c); }else{ return($rtrn); }
		}
	}

	function GtTotDt($p=NULL){

		global $__cnx;

		if(!isN($p['i'])){

			if($p['t'] == 'key'){ $__f = 'tot_key'; $__ft = 'text'; }else{ $__f = 'id_tot'; $__ft = 'int'; }
			if(!isN($p['bd'])){ $_bd = _BdStr($p['bd']); }

			$Ls_Qry_His = "	SELECT *
							FROM "._BdStr(DBP).TB_TOT."
							WHERE ".$__f." = '".$p['i']."' AND
								  tot_cl = '".DB_CL_ID."'
							ORDER BY id_tot DESC
							LIMIT 1
						";

			$Ls_Rg = $__cnx->_qry($Ls_Qry_His);

			if($Ls_Rg){

				$row_Ls_Rg = $Ls_Rg->fetch_assoc(); $Tot_Ls_Rg = $Ls_Rg->num_rows;

				if($Tot_Ls_Rg > 0){

					$_r['e'] = 'ok';

                    $_r['id'] = $row_Ls_Rg['id_tot'];
                    $_r['enc'] = ctjTx($row_Ls_Rg['tot_enc'],'in');
					$_r['nm'] = ctjTx($row_Ls_Rg['tot_tt'],'in');
					$_r['key'] = ctjTx($row_Ls_Rg['tot_key'],'in');
					$_r['vl'] = ctjTx($row_Ls_Rg['tot_vl'],'in');
					$_r['tp'] = ctjTx($row_Ls_Rg['tot_tp'],'in');

	            }

			}

			$__cnx->_clsr($Ls_Rg);

			$rtrn = _jEnc($_r);
			if($p['r'] == 'c'){ return($__c); }else{ return($rtrn); }
		}

	}

	function GtOrgSdsArrDt($p=NULL){

		global $__cnx;

		if(!isN($p['i'])){

			if($p['t'] == 'enc'){ $__f = 'orgsdsarr_enc'; $__ft = 'text'; }else{ $__f = 'id_orgsdsarr'; $__ft = 'int'; }

			if($p['t'] == 'org_enc'){ $__f = 'orgsdsarr_est = 1 AND org_enc'; $__ft = 'text'; }
			if($p['t'] == 'orgsds_enc'){ $__f = 'orgsdsarr_est = 1 AND orgsds_enc'; $__ft = 'text'; }

			if(!isN($p['bd'])){ $_bd = _BdStr($p['bd']); }

			$Ls_Qry_His = "SELECT * FROM "._BdStr(DBM).TB_ORG_SDS_ARR."
							INNER JOIN "._BdStr(DBM).TB_ORG_SDS." ON orgsdsarr_orgsds = id_orgsds
							INNER JOIN "._BdStr(DBM).TB_ORG."  ON orgsds_org = id_org
							WHERE ".$__f." = '".$p['i']."'
							LIMIT 1";

			$Ls_Rg = $__cnx->_qry($Ls_Qry_His);

			if($Ls_Rg){

				$row_Ls_Rg = $Ls_Rg->fetch_assoc(); $Tot_Ls_Rg = $Ls_Rg->num_rows;

				if($Tot_Ls_Rg > 0){

					$_r['e'] = 'ok';

					$_r['id'] = $row_Ls_Rg['id_orgsdsarr'];
					$_r['enc_sds'] = ctjTx($row_Ls_Rg['orgsds_enc'],'in');
                    $_r['enc'] = ctjTx($row_Ls_Rg['orgsdsarr_enc'],'in');
					$_r['nm'] = ctjTx($row_Ls_Rg['orgsdsarr_nm'],'in');
					$_r['vl'] = ctjTx($row_Ls_Rg['orgsdsarr_vl'],'in');
					$_r['mnt'] = ctjTx($row_Ls_Rg['orgsdsarr_vl_mnt'],'in');
					$_r['img_org'] = ctjTx($row_Ls_Rg['org_img'],'in');

	            }

				if(is_array($_c)){ $__c = implode(',', $_c); } else{ $__c = $_c; }

			}

			$__cnx->_clsr($Ls_Rg);

			$rtrn = _jEnc($_r);
			if($p['r'] == 'c'){ return($__c); }else{ return($rtrn); }
		}
	}

	function CntrDt($p){

		global $__cnx;

		if($p['tp']=='enc'){ $__fl = 'cntrcappl_enc'; $__tp = 'text'; }else{ $__fl = 'id_cntrcappl'; $__tp = 'int'; }

		$Vl['e'] = 'no';

		$query_DtRg = sprintf(" SELECT
									id_cntrcsht, cntrcsht_enc, cntrcsht_html,
									cntrcappl_cntrc, cntrcappl_cntappl, cntrc_lgo,
									cntappl_mdl, cntappl_cnt, cntappl_idcntrc, cntappl_idappl, id_cntappl
								FROM
									"._BdStr($p['bd']).TB_CNTRC_APPL."
								INNER JOIN "._BdStr(DBM).TB_CNTRC." ON cntrcappl_cntrc = id_cntrc
								INNER JOIN "._BdStr(DBM).TB_CNTRC_SHT." ON id_cntrc = cntrcsht_cntrc
								INNER JOIN "._BdStr($p['bd']).TB_CNT_APPL." ON id_cntappl = cntrcappl_cntappl
								WHERE id_cntrcappl != '' AND $__fl = %s ORDER BY cntrcsht_ord ASC", GtSQLVlStr(ctjTx($p['id'],'out'), $__tp));

		$DtRg = $__cnx->_qry($query_DtRg);

		if($DtRg){

			$row_DtRg = $DtRg->fetch_assoc();
			$Tot_DtRg = $DtRg->num_rows;

			$Vl['tot'] = $Tot_DtRg;

			if($Tot_DtRg > 0){

				$Vl['lgo'] = $row_DtRg['cntrc_lgo'];
				$Vl['mdl'] = $row_DtRg['cntappl_mdl'];

				$Vl['cntrc_id'] = $row_DtRg['cntappl_idcntrc'];
				$Vl['appl_id'] = $row_DtRg['cntappl_idappl'];

				$Vl['cnt'] = GtCntDt([ 't'=>'id', 'id'=>$row_DtRg['cntappl_cnt'], 'bd'=>$p['bd'] ]);

				$cnt_act = GtCntPrntDt([ "cnt2" => $row_DtRg['cntappl_cnt'], 'fnc' => 1, 'est' => 1, 'bd'=>$p['bd'] ]);
				$Vl['fnc_act'] = GtCntDt([ 't'=>'id', 'id'=>$cnt_act->cnt1, 'bd'=>$p['bd'] ]);


				$Vl['appl_attr'] = GtCntApplAttrDt(['id'=>$row_DtRg['id_cntappl']]);
				$Vl['cnt_attr'] = GtCntAttrDt(['id'=> $row_DtRg['cntappl_cnt'] ]);

				$Vl['cnt_attr_prnt'] = GtCntAttrDt(['id'=> $cnt_act->cnt1 ]);




				do{

					$__id = $row_DtRg['cntrcsht_enc'];
					$Vl['ls'][$__id]['id'] = $row_DtRg['id_cntrcsht'];
					$Vl['ls'][$__id]['html'] = ctjTx($row_DtRg['cntrcsht_html'],'in', '', ['html'=>'ok','schr'=>'no','nl2'=>'no','qte'=>'no']);

				}while($row_DtRg = $DtRg->fetch_assoc());
			}

		}else{


		}

		$__cnx->_clsr($DtRg);

		return(_jEnc($Vl));
	}

	function GtCntApplDt($p=NULL){

		global $__cnx;

		$Vl['e'] = 'no';

		if(!isN($p['id'])){

			if(!isN($p['bd'])){ $bd = _BdStr( $p['bd'] ); }

			$c_DtRg = "-1"; if (isset($p['id'])){$c_DtRg = $p['id'];}

			if($p['t'] == 'enc'){
				$__f = 'cntappl_enc'; $__ft = 'text';
			}else{
				$__f = 'id_cntappl'; $__ft = 'int';
			}

			$query_DtRg = sprintf('	SELECT *
									FROM '.$bd.'.cnt_appl
									INNER JOIN _mdl ON cntappl_mdl = id_mdl
									WHERE '.$__f.' = %s '.$_fl.' ', GtSQLVlStr($c_DtRg,$__ft));

			$DtRg = $__cnx->_qry($query_DtRg);

			if($DtRg){

				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;

				if($Tot_DtRg > 0){

					$Vl['id'] = $row_DtRg['id_cntappl'];
					$Vl['enc'] = $row_DtRg['cntappl_enc'];
					$Vl['cnt'] = GtCntDt([  'bd'=>$bd, 'id'=>$row_DtRg['cntappl_cnt'], 'cl'=>$p['cl']]);

					$Vl['mdl']['id'] = ctjTx($row_DtRg['id_mdl'],'in');
					$Vl['mdl']['enc'] = ctjTx($row_DtRg['mdl_enc'],'in');
					$Vl['mdl']['nm'] = ctjTx($row_DtRg['mdl_nm'],'in');

					if($p['shw']['eml'] == 'ok'){
						$Vl['mdl']['eml'] = GtMdlEmlSndLs([ 'mdl'=>$row_DtRg['id_mdl'] ]);
					}

				}

			}

		}

			$__cnx->_clsr($DtRg);

		return(_jEnc($Vl));
	}

	function GtCntAttrDt($_p=NULL){

		global $__cnx;

		if($p['tp']=='enc'){ $__fl = 'cntrcappl_enc'; $__tp = 'text'; }else{ $__fl = 'id_cntrcappl'; $__tp = 'int'; }

		$Vl['e'] = 'no';

		$query_DtRg = sprintf(" SELECT * FROM ".TB_CNT_ATTR."
									INNER JOIN "._BdStr(DBM).TB_SIS_SLC." ON cntattr_attr = id_sisslc
								WHERE cntattr_cnt = ".$_p['id']." ");

		$DtRg = $__cnx->_qry($query_DtRg);

		if($DtRg){

			$row_DtRg = $DtRg->fetch_assoc();
			$Tot_DtRg = $DtRg->num_rows;
			$Vl['tot'] = $Tot_DtRg;

			if($Tot_DtRg > 0){
				do{

					$l_dt = LsDmc([ 'attr'=>$row_DtRg['cntattr_attr'], 'id'=>$row_DtRg['cntattr_vl'], 'tp'=>'dt' ]);
					$__id = $row_DtRg['cntattr_attr'];
					$Vl['ls'][$__id]['attr'] = $row_DtRg['cntattr_attr'];
					$Vl['ls'][$__id]['dt'] = $l_dt;

				}while($row_DtRg = $DtRg->fetch_assoc());
			}
		}

		$__cnx->_clsr($DtRg);
		return(_jEnc($Vl));
	}

	function GtCntApplAttrDt($_p=NULL){

		global $__cnx;

		if($p['tp']=='enc'){ $__fl = 'cntrcappl_enc'; $__tp = 'text'; }else{ $__fl = 'id_cntrcappl'; $__tp = 'int'; }

		$Vl['e'] = 'no';

		$query_DtRg = sprintf(" select
									*
								from
									cnt_appl_attr
								INNER JOIN sumr_bd._sis_slc ON cntapplattr_attr = id_sisslc
								where
									cntapplattr_cntappl = ".$_p['id']." ");

		$DtRg = $__cnx->_qry($query_DtRg);

		if($DtRg){

			$row_DtRg = $DtRg->fetch_assoc();
			$Tot_DtRg = $DtRg->num_rows;

			$Vl['tot'] = $Tot_DtRg;

			if($Tot_DtRg > 0){



				do{

					$l_dt = LsDmc([ 'attr'=>$row_DtRg['cntapplattr_attr'], 'id'=>$row_DtRg['cntapplattr_vl'], 'tp'=>'dt' ]);

					$__id = $row_DtRg['cntapplattr_attr'];
					$Vl['ls'][$__id]['attr'] = $row_DtRg['cntapplattr_attr'];
					$Vl['ls'][$__id]['dt'] = $l_dt;

				}while($row_DtRg = $DtRg->fetch_assoc());
			}

		}

		$__cnx->_clsr($DtRg);

		return(_jEnc($Vl));

	}

	function GtSisEcSgmLs($_p=NULL){

		global $__cnx;

		if(!isN($_p['id'])){	}

		$Ls_Qry = "	SELECT *
					FROM "._BdStr(DBM).TB_SIS_EC_SGM_VAR."
						 INNER JOIN "._BdStr(DBM).TB_SIS_EC_SGM_VAR_TP." ON sisecsgmvar_tp = id_sisecsgmvartp
						 INNER JOIN "._BdStr(DBM).TB_SIS_EC_SGM." ON sisecsgmvar_sgm = id_sisecsgm
					WHERE id_sisecsgm != 1
					ORDER BY sisecsgm_nm ASC, sisecsgmvar_nm ASC";

		$Ls = $__cnx->_qry($Ls_Qry);

		if($Ls){

			$row_Ls = $Ls->fetch_assoc();
			$Tot_Ls = $Ls->num_rows;

			$_r['tot'] = $Tot_Ls;

			if($Tot_Ls > 0){

				$_r['e'] = 'ok';

				do {

					$__id = $row_Ls['sisecsgm_enc'];
					$__id_var = $row_Ls['sisecsgmvar_enc'];

					$_r['ls'][$__id]['id'] = $row_Ls['id_sisecsgm'];
					$_r['ls'][$__id]['enc'] = $__id;
					$_r['ls'][$__id]['nm'] = ctjTx($row_Ls['sisecsgm_nm'], 'in');
					$_r['ls'][$__id]['img'] = _ImVrs([ 'img'=>$row_Ls['sisecsgm_img'], 'f'=>DMN_FLE_SIS_EC_SGM ]);
					$_r['ls'][$__id]['key'] = ctjTx($row_Ls['sisecsgm_key'], 'in');

					$_r['ls'][$__id]['var'][ $__id_var ]['id'] = ctjTx($row_Ls['id_sisecsgmvar'], 'in');
					$_r['ls'][$__id]['var'][ $__id_var ]['enc'] = $__id_var;
					$_r['ls'][$__id]['var'][ $__id_var ]['nm'] = ctjTx($row_Ls['sisecsgmvar_nm'], 'in');
					$_r['ls'][$__id]['var'][ $__id_var ]['ls'] = ctjTx($row_Ls['sisecsgmvar_ls'], 'in');
					$_r['ls'][$__id]['var'][ $__id_var ]['dt'] = ctjTx($row_Ls['sisecsgmvar_dt'], 'in');


					$_r['ls'][$__id]['var'][ $__id_var ]['tp']['id'] = ctjTx($row_Ls['id_sisecsgmvartp'], 'in');
					$_r['ls'][$__id]['var'][ $__id_var ]['tp']['nm'] = ctjTx($row_Ls['sisecsgmvartp_nm'], 'in');
					$_r['ls'][$__id]['var'][ $__id_var ]['tp']['gts'] = ctjTx($row_Ls['sisecsgmvartp_gts'], 'in');
					$_r['ls'][$__id]['var'][ $__id_var ]['tp']['ls'] = ctjTx($row_Ls['sisecsgmvar_ls'], 'in');
					$_r['ls'][$__id]['var'][ $__id_var ]['tp']['dt'] = ctjTx($row_Ls['sisecsgmvar_dt'], 'in');

				} while ($row_Ls = $Ls->fetch_assoc());

			}

		}

		$__cnx->_clsr($Ls);

		return _jEnc($_r);

	}

	function GtSisBdDt($_p=NULL){

		global $__cnx;

		$Vl['e'] = 'no';

		if(is_array($_p)){

			if(!isN($_p['id'])){

				if($_p['t']=='key'){ $__f = 'sisbd_key'; $__ft = 'text'; }
				elseif($_p['t']=='enc'){ $__f = 'sisbd_enc'; $__ft = 'text'; }
				else{ $__f = 'id_sisbd'; $__ft = 'int'; }


				$query_DtRg = sprintf("SELECT * FROM "._BdStr(DBM).TB_SIS_BD." WHERE {$__f} = %s", GtSQLVlStr($_p['id'], $__ft));

				//$Vl['q'] = $query_DtRg;

				$DtRg = $__cnx->_qry($query_DtRg); //echo $__cnx->c_r->error;

				if($DtRg){

					$row_DtRg = $DtRg->fetch_assoc();
					$Tot_DtRg = $DtRg->num_rows;

					if($Tot_DtRg > 0){
						$Vl['id'] = $row_DtRg['id_sisbd'];
						$Vl['enc'] = ctjTx($row_DtRg['sisbd_enc'],'in');
						$Vl['tt'] = ctjTx($row_DtRg['sisbd_nm'],'in');
						$Vl['img'] = ctjTx($row_DtRg['sisbd_img'],'in');

						$Vl['tabs'] = mBln($row_DtRg['sisbd_tabs']);
						$Vl['eml'] = mBln($row_DtRg['sisbd_eml']);
						$Vl['dc'] = mBln($row_DtRg['sisbd_dc']);
						$Vl['tel'] = mBln($row_DtRg['sisbd_tel']);
						$Vl['cd'] = mBln($row_DtRg['sisbd_cd']);
						$Vl['uni'] = mBln($row_DtRg['sisbd_uni']);
						$Vl['clg'] = mBln($row_DtRg['sisbd_clg']);
						$Vl['emp'] = mBln($row_DtRg['sisbd_emp']);

						$Vl['md'] = mBln($row_DtRg['sisbd_md']);
						$Vl['fnt'] = mBln($row_DtRg['sisbd_fnt']);

						$Vl['fn'] = mBln($row_DtRg['sisbd_fn']);
						$Vl['gnr'] = mBln($row_DtRg['sisbd_gnr']);
						$Vl['comp'] = mBln($row_DtRg['sisbd_comp']);

						$Vl['fld_nm'] = mBln($row_DtRg['sisbd_fld_nm']);
						$Vl['fld_ap'] = mBln($row_DtRg['sisbd_fld_ap']);

					}

				}else{

					$Vl['w'] = $__cnx->c_r->error;

				}



			}else{

				$Vl['w'] = 'no data';

			}
		}

		$__cnx->_clsr($DtRg);
		$rtrn = _jEnc($Vl);
		return($rtrn);

	}

	function SisCntEst($p=NULL){

		global $__cnx;

		if($p['tp'] == 'enc' && !isN($p['id'])){ $__flt .= "AND siscntest_enc = ".$p['id']." "; }
		elseif(!isN($p['id'])){ $__flt .= "AND id_siscntest = ".$p['id']." "; }

		if(!isN($p['asis'])){ $__flt .= "AND siscntest_asis = 1"; }

		$Vl['e'] = 'no';

		$query_DtRg = sprintf("SELECT * FROM "._BdStr(DBM).TB_SIS_CNT_EST." WHERE id_siscntest IS NOT NULL $__flt ");
		$Vl['qry'] = $query_DtRg;

		$DtRg = $__cnx->_qry($query_DtRg);

		if($DtRg){

			$row_DtRg = $DtRg->fetch_assoc();
			$Tot_DtRg = $DtRg->num_rows;
			$Vl['tot'] = $Tot_DtRg;

			if($Tot_DtRg > 0){

				$Vl['e'] = 'ok';

				do{
					$Vl['enc'] = $row_DtRg['siscntest_enc'];
					$Vl['id'] = ctjTx($row_DtRg['id_siscntest'],'in');
					$Vl['nm'] = ctjTx($row_DtRg['siscntest_tt'],'in');
					$Vl['est'] = $row_DtRg['siscntest_asis'];
					$Vl['clr'] = $row_DtRg['siscntest_clr_bck'];
				}while($row_DtRg = $DtRg->fetch_assoc());
			}

		}else{ $Vl['w'] = $this->c_r->error; }

		$__cnx->_clsr($DtRg);

		$rtrn = _jEnc($Vl);
		return($rtrn);
	}







	function GtSortDt($p=NULL){

		global $__cnx;

		$Vl['e'] = 'no';

		if(!isN($p['id'])){

			if($p['t'] == 'enc'){ $__f = 'sort_enc'; $__ft = 'text'; }
			elseif($p['t'] == 'pml'){ $__f = 'sort_pml'; $__ft = 'text'; }
			else{ $__f = 'id_sort'; $__ft = 'int'; }

			$query_DtRg = sprintf('	SELECT *
									FROM '._BdStr(DBM).TB_SORT.'
										 INNER JOIN '._BdStr(DBM).TB_CL.' ON sort_cl = id_cl
									WHERE '.$__f.' = %s
									LIMIT 1', GtSQLVlStr($p['id'], $__ft));

			$DtRg = $__cnx->_qry($query_DtRg);

			if($DtRg){

				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;

				if($Tot_DtRg > 0){

					$Vl['e'] = 'ok';

					$Vl['id'] = $row_DtRg['id_sort'];
					$Vl['enc'] = ctjTx($row_DtRg['sort_enc'],'in');
					$Vl['nm'] = ctjTx($row_DtRg['sort_nm'],'in');
					$Vl['snce'] = ctjTx($row_DtRg['sort_snce'],'in');
					$Vl['html'] = ctjTx($row_DtRg['sort_html'],'in', '', ['html'=>'ok','schr'=>'no','nl2'=>'no','qte'=>'no']);
					$Vl['data'] = ctjTx($row_DtRg['sort_data'],'in', '', ['html'=>'ok','schr'=>'no','nl2'=>'no','qte'=>'no']);
					$Vl['msv']['cid'] = ctjTx($row_DtRg['sort_msv_cid'],'in');

				}

			}

			$__cnx->_clsr($DtRg);

		}else{

			$Vl['w'] = 'No all data';

		}

		return(_jEnc($Vl));
	}


	function GtWhtspDt($p=NULL){

		global $__cnx;

		if(!isN($p["id"])){ $_fl .= " AND id_wthsp = '".$p["id"]."' "; }
		elseif(!isN($p["no"])){ $_fl .= " AND wthsp_no = '".$p["no"]."' "; }

		$query_DtRg = sprintf('	SELECT *
								FROM '._BdStr(DBT).TB_WHTSP.'
								WHERE id_wthsp IS NOT NULL '.$_fl);

		$DtRg = $__cnx->_qry($query_DtRg);

		if($DtRg){

			$row_DtRg = $DtRg->fetch_assoc();
			$Tot_DtRg = $DtRg->num_rows;

			if($Tot_DtRg > 0){
				$Vl['id'] = $row_DtRg['id_wthsp'];
				$Vl['enc'] = ctjTx($row_DtRg['wthsp_enc'],'in');
				$Vl['no'] = ctjTx($row_DtRg['wthsp_no'],'in');
			}

		}else{

			$Vl['e'] = $row_DtRg['no'];
			$Vl['w'] = $row_DtRg['no'];
		}

		$__cnx->_clsr($DtRg);

		return(_jEnc($Vl));

	}


	function GtWhtspFromDt($p=NULL){

		global $__cnx;

		if(!isN($p["id"])){ $_fl .= " AND wthspfrom_id = '".$p["id"]."' "; }
		if(!isN($p["maincnv_id"])){
			$_fl .= " AND EXISTS ( 	SELECT wthspcnv_from
									FROM "._BdStr(DBT).TB_WHTSP_CNV."
									WHERE 	wthspcnv_from = id_wthspfrom AND
											id_wthspcnv = ".$p["maincnv_id"]."
					) ";
		}

		$query_DtRg = sprintf('	SELECT *
								FROM '._BdStr(DBT).TB_WHTSP_FROM.'
								WHERE id_wthspfrom != "" '.$_fl);

		$DtRg = $__cnx->_qry($query_DtRg); $Vl['q'] = compress_code( $query_DtRg );

		if($DtRg){

			$row_DtRg = $DtRg->fetch_assoc();
			$Tot_DtRg = $DtRg->num_rows;

			$Vl['id'] = $row_DtRg['id_wthspfrom'];
			$Vl['key'] = $row_DtRg['wthspfrom_id'];
			$Vl['enc'] = ctjTx($row_DtRg['wthspfrom_enc'],'in');
			$Vl['tt'] = ctjTx($row_DtRg['wthspfrom_nm'],'in');

		}else{

			$Vl['e'] = $row_DtRg['no'];
			$Vl['w'] = $__cnx->c_r->error;
			$Vl['q'] = compress_code( $query_DtRg );

		}

		$__cnx->_clsr($DtRg);

		return(_jEnc($Vl));

	}

	function GtWhtspCnvDt($p=NULL){

		global $__cnx;

		if(!isN( $p['id'] )){
			$_fl .= "AND id_wthspcnv = '".$p["id"]."' ";
		}elseif(!isN( $p['enc'] )){
			$_fl .= "AND wthspcnv_enc = '".$p['enc']."' ";
		}elseif(!isN( $p['cid'] )){
			$_fl .= "AND wthspcnv_id = '".$p['cid']."' ";
		}

		$query_DtRg = sprintf('	SELECT 	id_wthspcnv,
										wthspcnv_enc,
										wthspcnv_id,
										wthsp_no,
										wthspfrom_id,
										wthspfrom_nm,
										whtsp_api
								FROM '._BdStr(DBT).TB_WHTSP_CNV.'
								INNER JOIN '._BdStr(DBT).TB_WHTSP.' ON id_wthsp = wthspcnv_whtsp
								INNER JOIN '._BdStr(DBT).TB_WHTSP_FROM.' ON id_wthspfrom = wthspcnv_from
								WHERE id_wthspcnv != "" '.$_fl);

		if($p['cmmt']=='ok'){
			$DtRg = $__cnx->_prc($query_DtRg);
		}else{
			$DtRg = $__cnx->_qry($query_DtRg);
		}

		if($DtRg){

			$row_DtRg = $DtRg->fetch_assoc();
			$Tot_DtRg = $DtRg->num_rows;

			if($Tot_DtRg > 0){
				$Vl['id'] = $row_DtRg['id_wthspcnv'];
				$Vl['cid'] = $row_DtRg['wthspcnv_id'];
				$Vl['enc'] = ctjTx($row_DtRg['wthspcnv_enc'],'in');
				$Vl['whtsp']['api'] = ctjTx($row_DtRg['whtsp_api'],'in');
				$Vl['whtsp']['no'] = ctjTx($row_DtRg['wthsp_no'],'in');
				$Vl['from']['id'] = ctjTx($row_DtRg['wthspfrom_id'],'in');
				$Vl['from']['nm'] = ctjTx($row_DtRg['wthspfrom_nm'],'in');
			}

		}else{

			$Vl['e'] = $row_DtRg['no'];

		}

		$__cnx->_clsr($DtRg);

		return(_jEnc($Vl));

	}

	function GtWhtspCnvMsgDt($p=NULL){

		global $__cnx;

		if(!isN($p["id"])){ $_fl .= "AND wthspcnvmsg_id = '".$p["id"]."' "; }

		$query_DtRg = sprintf('	SELECT id_wthspcnvmsg, wthspcnvmsg_id, wthspcnvmsg_enc, wthspcnvmsg_message
								FROM '._BdStr(DBT).TB_WHTSP_CNV_MSG.'
								WHERE wthspcnvmsg_id != "" '.$_fl. '
								LIMIT 1');

		$DtRg = $__cnx->_qry($query_DtRg);

		if($DtRg){

			$row_DtRg = $DtRg->fetch_assoc();
			$Tot_DtRg = $DtRg->num_rows;

			$Vl['e'] = "ok";
			$Vl['id'] = $row_DtRg['id_wthspcnvmsg'];
			$Vl['key'] = $row_DtRg['wthspcnvmsg_id'];
			$Vl['enc'] = ctjTx($row_DtRg['wthspcnvmsg_enc'],'in');
			$Vl['tt'] = ctjTx($row_DtRg['wthspcnvmsg_message'],'in');

		}else{
			$Vl['e'] = $row_DtRg['no'];
		}

		$__cnx->_clsr($DtRg);

		return(_jEnc($Vl));

	}

	function GtWhtspCnvMsgLs($p=NULL){

		global $__cnx;

		if(!isN($p["cnv"])){

			$_fl .= "AND wthspcnvmsg_wthspcnv = '".$p["cnv"]."' ";

			$query_LsRg = sprintf('	SELECT id_wthspcnvmsg, wthspcnvmsg_id, wthspcnvmsg_enc, wthspcnvmsg_message
									FROM '._BdStr(DBT).TB_WHTSP_CNV_MSG.'
									WHERE wthspcnvmsg_id != "" '.$_fl. '
									ORDER BY wthspcnvmsg_created DESC
									LIMIT 50');

			$LsRg = $__cnx->_qry($query_LsRg);

			if($LsRg){

				$Vl['e'] = "ok";
				$row_LsRg = $LsRg->fetch_assoc();
				$Tot_LsRg = $LsRg->num_rows;

				$Vl['tot'] = $Tot_LsRg;

				if($Tot_LsRg > 0){

					do{

						$_id = $row_LsRg['wthspcnvmsg_enc'];
						$Vl['ls'][$_id]['id'] = $row_LsRg['id_wthspcnvmsg'];
						$Vl['ls'][$_id]['key'] = $row_LsRg['wthspcnvmsg_id'];
						$Vl['ls'][$_id]['enc'] = ctjTx($row_LsRg['wthspcnvmsg_enc'],'in');
						$Vl['ls'][$_id]['msg'] = ctjTx($row_LsRg['wthspcnvmsg_message'],'in');

					}while($row_LsRg = $LsRg->fetch_assoc());

				}

			}else{
				$Vl['e'] = $row_DtRg['no'];
			}

			$__cnx->_clsr($LsRg);

		}

		return(_jEnc($Vl));

	}

	function GtMainCnvUsChkDt($p=NULL){

		global $__cnx;

		if( !isN($p["maincnvus_us"]) && !isN($p["maincnvus_us_oth"]) ){

			$query_DtRg = sprintf('SELECT maincnv_enc
									FROM '._BdStr(DBC).TB_MAIN_CNV.'
											INNER JOIN '._BdStr(DBC).TB_MAIN_CNV_US.' ON maincnvus_maincnv = id_maincnv
									WHERE maincnvus_us != ""
									AND maincnvus_us = %s
									AND maincnvus_maincnv IN ( SELECT maincnvus_maincnv FROM '._BdStr(DBC).TB_MAIN_CNV_US.' WHERE maincnvus_us = %s ) ',
								   GtSQLVlStr($p["maincnvus_us"], "int"),
								   GtSQLVlStr($p["maincnvus_us_oth"], "int")
								);

			$DtRg = $__cnx->_qry($query_DtRg);

			if($DtRg){

				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;

				if($Tot_DtRg > 0){

					do{

						$Vl['tot'] = $Tot_DtRg;
						$Vl['id'] = $row_DtRg['id_maincnv'];
						$Vl['cnv_enc'] = $row_DtRg['maincnv_enc'];

					} while ($row_DtRg = $DtRg->fetch_assoc());


				}else{
					$Vl['e'] = "no";
				}

			}

			$__cnx->_clsr($DtRg);

		}

		return(_jEnc($Vl));

	}

	function GtMainCnvUsOthDt($p=NULL){

		global $__cnx;

		$Vl['e'] = "no";

		if( !isN($p["maincnvus_us"]) && !isN($p["maincnvus_maincnv"]) ){

			$query_DtRg = sprintf('SELECT id_us, us_enc, us_user, us_gnr, us_nm us_ap, us_img, us_fn, us_nivel, us_ntf, us_onl, us_msv_user
									FROM '._BdStr(DBM).TB_US.'
											INNER JOIN '._BdStr(DBC).TB_MAIN_CNV_US.' ON maincnvus_us = id_us
									WHERE id_us != ""
									AND maincnvus_maincnv = %s AND maincnvus_us != %s',
								   GtSQLVlStr($p["maincnvus_maincnv"], "int"),
								   GtSQLVlStr($p["maincnvus_us"], "int")
								);

			$DtRg = $__cnx->_qry($query_DtRg);

			$Vl['q'] = compress_code( $query_DtRg );

			if($DtRg){

				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;

				if($Tot_DtRg > 0){

					do{

						$Vl['tot'] = $Tot_DtRg;
						$Vl['id'] = $row_DtRg['id_us'];
						$Vl['nm'] = ctjTx($row_DtRg['us_nm'],'in');
						$Vl['ap'] = ctjTx($row_DtRg['us_ap'],'in');
						$Vl['enc'] = ctjTx($row_DtRg['us_enc'],'in');
						$Vl['img_nm'] = ctjTx($row_DtRg['us_img'],'in');
						$Vl['fn'] = $row_DtRg['us_fn'];
						$Vl['lvl'] = $row_DtRg['us_nivel'];
						$Vl['frgpss'] = "ok";
						$Vl['ntf'] = mBln($row_DtRg['us_ntf']);
						$Vl['onl'] = $row_DtRg['us_onl'];

						$Vl['nm_fll'] = ctjTx($row_DtRg['us_nm'].' '.$row_DtRg['us_ap'],'in');
						if($p['prvt']!='ok'){ $Vl['eml'] = ctjTx($row_DtRg['us_user'],'in'); }

						$Vl['gnr'] = $row_DtRg['us_gnr'];


						if($p['prvt']!='ok'){ $Vl['e'] = "ok"; }
						if($p['prvt']!='ok'){ $Vl['mdl'] = $__sisusmdl->mdl; }

						$Vl['img'] = $row_DtRg['us_img'];

						$Vl['msv_usr'] = ctjTx($row_DtRg['us_msv_user'],'in');

					} while ($row_DtRg = $DtRg->fetch_assoc());


				}

			}else{

				$Vl['w'] = $__cnx->c_r->error;

			}

			$__cnx->_clsr($DtRg);

		}else{

			$Vl['w'] = 'no_data';

		}


		return(_jEnc($Vl));

	}


	function GtMainCnvDt($p=NULL){

		global $__cnx;

		if(!isN($p["enc"])){ $_fl .= "AND maincnv_enc = '".$p["enc"]."' "; }
		if(!isN($p["tp"])){ $_fl .= "AND maincnv_tp = '".$p["tp"]."' "; }
		if(!isN($p["maincnv_id"])){ $_fl .= "AND maincnv_id = '".$p["maincnv_id"]."' "; }

		$query_DtRg = sprintf('	SELECT id_maincnv, maincnv_enc, maincnv_tp, maincnv_id, maincnv_lmsj, maincnv_ldte
								FROM '._BdStr(DBC).TB_MAIN_CNV.'
								WHERE id_maincnv != "" '.$_fl);

		if($p['cmmt']=='ok'){ //-- If use it on commit process --//
			$DtRg = $__cnx->_prc($query_DtRg);
		}else{
			$DtRg = $__cnx->_qry($query_DtRg);
		}

		//$Vl['q'] = compress_code($query_DtRg);

		if($DtRg){

			$row_DtRg = $DtRg->fetch_assoc();
			$Tot_DtRg = $DtRg->num_rows;

			if($Tot_DtRg > 0){

				$Vl['e'] = "ok";
				$Vl['id'] = $row_DtRg['id_maincnv'];
				$Vl['enc'] = ctjTx($row_DtRg['maincnv_enc'],'in');
				$Vl['tp'] = ctjTx($row_DtRg['maincnv_tp'],'in');
				$Vl['cid'] = $row_DtRg['maincnv_id'];
				$Vl['lmsj'] = [
					'tx'=>ctjTx($row_DtRg["maincnv_lmsj"], 'in'),
					'f'=>[
						'main'=>$row_DtRg['maincnv_ldte'],
						's1'=>date('H:i a', strtotime( $row_DtRg['maincnv_ldte'] ))
					]
				];

				if($p['d']['chnl']=='ok' && !isN($row_DtRg['maincnv_id'])){
					if($row_DtRg['maincnv_tp'] == 'whtsp'){
						$Vl['chnl'] = GtWhtspCnvDt([ 'id'=>$row_DtRg['maincnv_id'], 'cmmt'=>$p['cmmt'] ]);
					}elseif($row_DtRg['maincnv_tp'] == 'eml'){
						$__Eml = new CRM_Eml();
						$Vl['chnl'] = $__Eml->EmlCnvDt([ 'id'=>$row_DtRg['maincnv_id'], 'd'=>[ 'addr'=>'ok' ], 'cmmt'=>$p['cmmt'] ]);
					}
				}

				if($p['us_asgn'] == 'ok'){
					$Vl['us'] = GtMainCnvUsDt([ 'cnv'=>$row_DtRg['id_maincnv'], 'cmmt'=>$p['cmmt'] ]);
				}

				//$Vl['qry'] = $query_DtRg;
			}else{

				$Vl['e'] = "no";
				$Vl['w'] = 'No records';

			}

		}else{

			$Vl['e'] = $row_DtRg['no'];

			if($p['cmmt']=='ok'){
				$Vl['w'] = $__cnx->c_p->error;
			}else{
				$Vl['w'] = $__cnx->c_r->error;
			}

		}

		$__cnx->_clsr($DtRg);

		return(_jEnc($Vl));

	}


	function GtMainCnvUsDt($p=NULL){

		global $__cnx;

		if(!isN($p["cnv"])){

			$query_DtRg = sprintf('	SELECT id_us, us_enc
									FROM '._BdStr(DBC).TB_MAIN_CNV_US.'
										 INNER JOIN '._BdStr(DBM).TB_US.' ON maincnvus_us = id_us
									WHERE maincnvus_maincnv = "'.$p['cnv'].'" AND
										  maincnvus_est=1
								');

			if($_p['cmmt']=='ok'){ //-- If use it on commit process --//
				$DtRg = $__cnx->_prc($query_DtRg);
			}else{
				$DtRg = $__cnx->_qry($query_DtRg);
			}

			if($DtRg){

				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;

				if($Tot_DtRg > 0){
					$Vl['id'] = $row_DtRg['id_us'];
					$Vl['enc'] = $row_DtRg['us_enc'];
				}
			}

			$__cnx->_clsr($DtRg);

		}

		return(_jEnc($Vl));

	}

	function GtEcEstLs($p=NULL){

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

	function GtCmpgClaLs($p=NULL){

		global $__cnx;

		$Vl['e'] = 'no';

		$__Cl = GtClLs([ 'on'=>'ok' ]);

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

		foreach($__Cl->ls as $_cl_k=>$_cl_v){

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

	function GtEcSndCmpgLs($p=NULL){

			global $__cnx;

			$Vl['e'] = 'ok';

			$__Cl = GtClLs([ 'on'=>'ok' ]);

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

			foreach($__Cl->ls as $_cl_k=>$_cl_v){

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

	function GtEcCmpgPndLs($p=NULL){

		global $__cnx;

		$Vl['e'] = 'no';

		$__Cl = GtClLs([ 'on'=>'ok' ]);

		if($__Cl->tot > 0){

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

	function GtCdVrfLs($p=NULL){
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

	function GtSisErr($p=NULL){
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

	function GtCntEmlEst($p=NULL){

		global $__cnx;

		$Vl['e'] = 'no';

		$__Cl = GtClLs([ 'on'=>'ok' ]);

		foreach($__Cl->ls as $_cl_k=>$_cl_v){

			$query_Cls = "SELECT COUNT(*) AS count FROM information_schema.tables WHERE table_schema = '".$_cl_v->bd."' AND table_name = '".TB_CNT_EML."'";
			$ClRgs = $__cnx->_qry($query_Cls);

			if($ClRgs){

				$row_DtCls = $ClRgs->fetch_assoc();
				$Tot_DtCls = $ClRgs->num_rows;

				if($row_DtCls['count'] > 0){

					$query_Cl = "SELECT
						(SELECT COUNT(DISTINCT id_cnteml) as __rgtot FROM ".$_cl_v->bd.".".TB_CNT_EML." WHERE cnteml_est = "._CId('ID_SISEMLEST_BADFRMT').") AS bad_w,
						(SELECT COUNT(DISTINCT id_cnteml) as __rgtot FROM ".$_cl_v->bd.".".TB_CNT_EML." WHERE cnteml_est = "._CId('ID_SISEMLEST_NOCHCK').") AS no_chck ";
					$ClRg = $__cnx->_qry($query_Cl);

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

	function GtOrgVrfLs($p=NULL){
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

	function GtDwnEstLs($p=NULL){
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

	function GtLeadAd($p=NULL){
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

	function GtSclRcl($p=NULL){
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

	function GtApiRqu($p=NULL){

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

	function GtTotMntrDt($p=NULL){

		global $__cnx;

		if(!isN($p['i'])){

			if($p['t'] == 'key'){ $__f = 'tot_key'; $__ft = 'text'; }
			elseif($p['t'] == 'tp'){ $__f = 'tot_tp'; $__ft = 'text'; }
			else{ $__f = 'id_tot'; $__ft = 'int'; }

			if(!isN($p['bd'])){ $_bd = _BdStr($p['bd']); }

			$Ls_Qry_His = "SELECT * FROM "._BdStr(DBP).TB_TOT."
							WHERE ".$__f." = '".$p['i']."'
							ORDER BY id_tot DESC
						";

			$Ls_Rg = $__cnx->_qry($Ls_Qry_His);

			if($Ls_Rg){

				$row_Ls = $Ls_Rg->fetch_assoc();
				$Tot_Ls = $Ls_Rg->num_rows;

				do {

					$_r[ $row_Ls['tot_key'] ] = $row_Ls['tot_vl'];


				} while ($row_Ls = $Ls_Rg->fetch_assoc());

			}

			$__cnx->_clsr($Ls_Rg);

			$rtrn = _jEnc($_r);
			if($p['r'] == 'c'){ return($__c); }else{ return($rtrn); }
		}

	}

	function GtBcoPayDt($p=NULL){

		$_dt = __LsDt([ 'k'=>'gtwy_pay_est', 'id'=>$p['id'] ]);
		return $_dt;

	}

	function GtOrgDshLs($p=NULL){

		global $__cnx;

		if(!isN($p['cl']) && !isN($p['tp'])){

			$Ls_Qry_His = " SELECT id_orgdsh,
								   "._QrySisSlcF([ 'als'=>'t', 'als_n'=>'Type']).",
								   "._QrySisSlcF([ 'als'=>'tob', 'als_n'=>'Object']).",
								   ".GtSlc_QryExtra([ 't'=>'fld', 'p'=>'Type', 'als'=>'t' ]).",
								   ".GtSlc_QryExtra([ 't'=>'fld', 'p'=>'Object', 'als'=>'tob' ])."
							FROM "._BdStr(DBM).TB_ORG_DSH."
							     ".GtSlc_QryExtra([ 't'=>'tb', 'col'=>'orgdsh_tp', 'als'=>'t' ])."
								 ".GtSlc_QryExtra([ 't'=>'tb', 'col'=>'orgdsh_otp', 'als'=>'tob' ])."
							WHERE orgdsh_cl = '".$p['cl']."' AND
								  orgdsh_tp = '".$p['tp']."'
						";

			$Ls_Rg = $__cnx->_qry($Ls_Qry_His);

			if($Ls_Rg){

				$row_Ls_Rg = $Ls_Rg->fetch_assoc();
				$Tot_Ls_Rg = $Ls_Rg->num_rows;

				$_r['tot'] = $Tot_Ls_Rg;

				if($Tot_Ls_Rg > 0){

					do{
						$__tipo = json_decode($row_Ls_Rg['___Object']);

						foreach($__tipo as $__tipo_k=>$__tipo_v){
							$__tipo_attr[$__tipo_v->key] = $__tipo_v->vl;
						}

						if($__tipo_attr['grph'] == 1){
							$__tp = 'grph';
						}else if($__tipo_attr['card'] == 1){
							$__tp = 'card';
						}

						$_r['ls'][$__tp][$__tipo_attr['id']]['e'] = 'ok';
						$_r['ls'][$__tp][$__tipo_attr['id']]['id'] = $row_Ls_Rg['id_orgdsh'];
						$_r['ls'][$__tp][$__tipo_attr['id']]['vl'] = $row_Ls_Rg['orgdsh_vl'];
						$_r['ls'][$__tp][$__tipo_attr['id']]['tt'] = $__tipo_attr['lbl'];
						$_r['ls'][$__tp][$__tipo_attr['id']]['img'] = DMN_FLE_SIS_SLC.$row_Ls_Rg['Object_sisslc_img'];

					}while($row_Ls_Rg = $Ls_Rg->fetch_assoc());

				}

			}

			$__cnx->_clsr($Ls_Rg);

		}

		$rtrn = _jEnc($_r);
		if($p['r'] == 'c'){ return($__c); }else{ return($rtrn); }
	}

	function GtOrgDshDt($p=NULL){

		global $__cnx;

		if(!isN($p['cl']) && !isN($p['tp'])){

			$Ls_Qry_His = " SELECT id_orgdsh, orgdsh_vl,
								   "._QrySisSlcF([ 'als'=>'t', 'als_n'=>'Type']).",
								   "._QrySisSlcF([ 'als'=>'tob', 'als_n'=>'Object']).",
								   ".GtSlc_QryExtra([ 't'=>'fld', 'p'=>'Type', 'als'=>'t' ]).",
								   ".GtSlc_QryExtra([ 't'=>'fld', 'p'=>'Object', 'als'=>'tob' ])."
							FROM "._BdStr(DBM).TB_ORG_DSH."
							     ".GtSlc_QryExtra([ 't'=>'tb', 'col'=>'orgdsh_tp', 'als'=>'t' ])."
								 ".GtSlc_QryExtra([ 't'=>'tb', 'col'=>'orgdsh_otp', 'als'=>'tob' ])."
							WHERE orgdsh_cl = '".$p['cl']."' AND
								  orgdsh_tp = '".$p['tp']."' AND
								  id_orgdsh = '".$p['id']."'
							LIMIT 1
						";

			$Ls_Rg = $__cnx->_qry($Ls_Qry_His);

			if($Ls_Rg){

				$row_Ls_Rg = $Ls_Rg->fetch_assoc();
				$Tot_Ls_Rg = $Ls_Rg->num_rows;

				$_r['tot'] = $Tot_Ls_Rg;

				if($Tot_Ls_Rg > 0){


					$__object = json_decode($row_Ls_Rg['___Object']);

					foreach($__object as $__object_k=>$__object_v){
						$__object_attr[$__object_v->key] = $__object_v->vl;
					}

					$__lista = json_decode($row_Ls_Rg['___List']);

					foreach($__lista as $__lista_k=>$__lista_v){
						$__lista_attr[$__lista_v->key] = $__lista_v->vl;
					}

					$_r['dt']['e'] = 'ok';
					$_r['dt']['id'] = $row_Ls_Rg['id_orgdsh'];
					$_r['dt']['vl'] = $row_Ls_Rg['orgdsh_vl'];

					$_r['dt']['obj'] = $__object_attr;
					$_r['dt']['ls'] = $__lista_attr;

				}

			}

			$__cnx->_clsr($Ls_Rg);

		}

		$rtrn = _jEnc($_r);
		if($p['r'] == 'c'){ return($__c); }else{ return($rtrn); }
	}

	function GtMdlCntAttchDt($p=NULL){

		global $__cnx;

		if(!isN($p['i'])){

			if($p['t'] == 'mdl_cnt'){ $__f = 'mdlcntattch_mdlcnt'; $__ft = 'int'; }
			else{ $__f = 'id_mdlcntattch'; $__ft = 'int'; }

			$Ls_Qry_His = "SELECT id_mdlcntattch, mdlcntattch_enc, mdlcntattch_mdlcnt, mdlcntattch_fle, mdlcntattch_fle_nm FROM ".TB_MDL_CNT_ATTCH."
							WHERE ".$__f." = '".$p['i']."'
							ORDER BY id_mdlcntattch DESC
						";

			$Ls_Rg = $__cnx->_qry($Ls_Qry_His);

			if($Ls_Rg){

				$row_Ls = $Ls_Rg->fetch_assoc();
				$Tot_Ls = $Ls_Rg->num_rows;

				$_r['tot'] = $Tot_Ls;

				if($Tot_Ls > 0){

					$_aws = new API_CRM_Aws();

					do {

						$_pth = $_aws->_s3_get([ 'b'=>'prvt', 'fle'=>DIR_PRVT_ATTCH.$row_Ls['mdlcntattch_fle'] ]);

						$_r['ls'][$row_Ls['mdlcntattch_enc']]['enc'] = $row_Ls['mdlcntattch_enc'];
						$_r['ls'][$row_Ls['mdlcntattch_enc']]['fle'] = $row_Ls['mdlcntattch_fle'];
						$_r['ls'][$row_Ls['mdlcntattch_enc']]['nm'] = $row_Ls['mdlcntattch_fle_nm'];

					} while ($row_Ls = $Ls_Rg->fetch_assoc());
				}
			}

			$__cnx->_clsr($Ls_Rg);

			$rtrn = _jEnc($_r);
			if($p['r'] == 'c'){ return($__c); }else{ return($rtrn); }
		}

	}

	function isBscData($v=NULL){

		$_v['e']='no';

		$_sch_eml = '/([a-zA-Z0-9._-]+@[a-zA-Z0-9._-]+\.[a-zA-Z0-9._-]+)/';
		$_sch_no = '/\d+/';

		if(preg_match($_sch_eml,$v)){ $_v['e']='ok'; }
		if(preg_match($_sch_no,$v)){ $_v['e']='ok'; }

		$_r = preg_replace($_sch_eml, "<span class='eml'>$1</span>", $v);
		$_r = preg_replace($_sch_no,"<span class='nm'>$0</span>", $_r);

		if($_v['e'] == 'ok'){ $_v['v'] = $_r; }

		return _jEnc($_v);

	}

	function GtMdlCtrlLs($p=NULL){

		global $__cnx;

		if(!isN($p['id'])){

			$Ls_Qry_His = "SELECT
								id_mdlctrl, mdlctrl_mdl, mdlctrl_tx, mdlctrl_enc, mdlctrl_ord
							FROM
								".TB_MDL_CTRL."
							WHERE
								mdlctrl_mdl = '".$p['id']."'";

			$Ls_Rg = $__cnx->_qry($Ls_Qry_His);

			if($Ls_Rg){

				$row_Ls = $Ls_Rg->fetch_assoc();
				$Tot_Ls = $Ls_Rg->num_rows;

				$_r['tot'] = $Tot_Ls;

				if($Tot_Ls > 0){

					do {

						$_r['ls'][$row_Ls['mdlctrl_enc']]['id'] 	= $row_Ls['id_mdlctrl'];
						$_r['ls'][$row_Ls['mdlctrl_enc']]['enc'] 	= $row_Ls['mdlctrl_enc'];
						$_r['ls'][$row_Ls['mdlctrl_enc']]['mdl'] 	= $row_Ls['mdlctrl_mdl'];
						$_r['ls'][$row_Ls['mdlctrl_enc']]['tx'] 	= $row_Ls['mdlctrl_tx'];
						$_r['ls'][$row_Ls['mdlctrl_enc']]['ord'] 	= $row_Ls['mdlctrl_ord'];

					} while ($row_Ls = $Ls_Rg->fetch_assoc());
				}
			}

			$__cnx->_clsr($Ls_Rg);

			$rtrn = _jEnc($_r);
			if($p['r'] == 'c'){ return($__c); }else{ return($rtrn); }
		}

	}



	function GtMdlSchLs($p=NULL){

		global $__cnx;

		if(!isN($p['id'])){

			if(!isN($p['bd'])){
				$__bd = _BdStr($p['bd']);
			}

			$Ls_Qry = "SELECT id_mdlssch, mdlssch_enc, mdlssch_nm, id_mdl
							FROM "._BdStr(DBM).TB_MDL_S_SCH."
								 INNER JOIN ".$__bd.TB_MDL_SCH." ON id_mdlssch = mdlsch_sch
								 INNER JOIN ".$__bd.TB_MDL." ON id_mdl = mdlsch_mdl
							WHERE mdlsch_mdl = '".$p['id']."'";

			$Ls_Rg = $__cnx->_qry($Ls_Qry);

			if($Ls_Rg){

				$row_Ls = $Ls_Rg->fetch_assoc();
				$Tot_Ls = $Ls_Rg->num_rows;

				$_r['tot'] = $Tot_Ls;

				if($Tot_Ls > 0){

					do {

						$_r['ls'][$row_Ls['mdlssch_enc']]['id'] 	= $row_Ls['id_mdlssch'];
						$_r['ls'][$row_Ls['mdlssch_enc']]['enc'] 	= $row_Ls['mdlssch_enc'];
						$_r['ls'][$row_Ls['mdlssch_enc']]['nm'] 	= $row_Ls['mdlssch_nm'];

					} while ($row_Ls = $Ls_Rg->fetch_assoc());
				}

			}else{

				$_r['w'][] = $__cnx->c_r->error;

			}

			$__cnx->_clsr($Ls_Rg);

		}

		return _jEnc($_r);

	}



	function Ls_to_Json($_p=NULL){

		global $__cnx;

		$r['tp'] = $_p['f'];

		if($_p['cl'] == 'ok'){
			$__bd = TB_CL_SLC;
			$_prfx = 'sis';
			$__bd2 = TB_CL_SLC_TP;
		}else{
			$__bd = _BdStr(DBM).TB_SIS_SLC;
			$_prfx = 'sis';
			$__bd2 = _BdStr(DBM).TB_SIS_SLC_TP;
		}

		if(!isN($_p['k'])){ $_fl .= sprintf(" AND ".$_prfx."slctp_key = %s", GtSQLVlStr($_p['k'], "text")); }
		if(!isN($_p['idt'])){ $_fl .= sprintf(" AND id_".$_prfx."slctp = %s", GtSQLVlStr($_p['idt'], "int")); }

		if($_p['fcl']=='ok' && !isN($_p['icl'])){
			$_fl .= sprintf(" AND id_sisslc IN ( 	SELECT sisslccl_sisslc
													FROM "._BdStr(DBM).TB_SIS_SLC_CL."
															INNER JOIN "._BdStr(DBM).TB_CL." ON sisslccl_cl = id_cl
													WHERE id_cl=%s
												) ", GtSQLVlStr($_p['icl'], "int")
							);
		}

		if(!isN($_p['ord']) && $_p['ord']=='ok'){ $__ord = $_prfx."slc_tt ASC"; }else{ $__ord = "id_".$_prfx."slc DESC";  }

		$Ls_Qry = sprintf("	SELECT * {$__slcf}
					FROM $__bd
						 INNER JOIN $__bd2 ON ".$_prfx."slc_tp = id_".$_prfx."slctp
					WHERE ".$_prfx."slctp_key != '' {$_fl}
					ORDER BY
						CASE WHEN sisslctp_ord = 1 AND sisslctp_ord_desc = 1 THEN sisslc_ord END DESC,
						CASE WHEN sisslctp_ord = 1 AND sisslctp_ord_desc = 2 THEN sisslc_ord END ASC,
						CASE WHEN sisslctp_ord = 2 AND sisslctp_ord_desc = 2 THEN sisslc_tt END ASC,
						CASE WHEN sisslctp_ord = 2 AND sisslctp_ord_desc = 1 THEN sisslc_tt END DESC");

		$Ls = $__cnx->_qry($Ls_Qry);

		if($Ls){

			$row_Ls = $Ls->fetch_assoc();
			$Tot_Ls = $Ls->num_rows;
			if(!isN($_p['v'])){ $__pv = $_p['v']; }else{ $__pv = 'id_'.$_prfx.'slc'; }

			do {

				$r['opt'][] = [
					'tt'=>$__lbl = $row_Ls[$_prfx.'slc_tt'],
					'vl'=>$row_Ls[$__pv]
				];

			} while ($row_Ls = $Ls->fetch_assoc());

			if($Tot_Ls > 0) { $Ls->data_seek(0); $row_Ls = $Ls->fetch_assoc(); }
			if(!isN($_p['ph'])){ $r['ph'] = $_p['ph']; }else{ $r['ph'] = _Cns('FM_SISSLC_'.strtoupper($row_Ls[''.$_prfx.'slctp_key'])); }

		}

		$__cnx->_clsr($Ls);

		return _jEnc($r);

	}



?>