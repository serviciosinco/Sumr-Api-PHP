<?php



//@ini_set('display_errors', true);
//error_reporting(E_ALL & ~E_NOTICE);

if(class_exists('CRM_Cnx')){

	/* Valida si el usuario tiene grupo */
	if(!ChckSESS_superadm()){
		$LsGrpUs = LsGrpUs([ "cl"=>$__dt_cl->bd, "us"=>SISUS_ID ]);
		$rsp['www'] = $LsGrpUs;

		/*if( $LsGrpUs->e == "ok" ){
			if(defined('SISUS_MDL_N') && !isN(SISUS_MDL_N)){
				if(!isN($fl_are)){ $fl_mdl = ' || '; }
				$__fl .= ' AND mdlcnt_mdl IN ( '.SISUS_MDL_N.' )';
			}else{
				$__fl .= " AND mdlcnt_mdl IN (".implode(",", $LsGrpUs->{SISUS_ID}->mdl).") ";
			}
		}else if( SISUS_ARE != '' ){
			$__fl .= ' AND mdlcnt_mdl IN (
										SELECT mdlare_mdl  FROM '.$__dt_cl->bd.'.'.TB_MDL_ARE.'
										INNER JOIN '._BdStr(DBM).TB_CL_ARE.' ON mdlare_are = id_clare
										WHERE id_clare IN ( '.SISUS_ARE.' ) AND clare_est = 1
									)';
		}*/

		if(defined('SISUS_ARE') && !isN(SISUS_ARE)){

			$fl_are = ' EXISTS (	SELECT *
									FROM '.$__dt_cl->bd.'.'.TB_MDL_ARE.'
									WHERE mdlare_mdl = id_mdl AND mdlare_are IN ('.SISUS_ARE.')
								) ';
		}

		if(defined('SISUS_MDL_N') && !isN(SISUS_MDL_N)){
			if(!isN($fl_are)){ $fl_mdl = ' || '; }
			$fl_mdl .= ' (	 id_mdl IN ( '.SISUS_MDL_N.' )	 ) ';
		}

		if(!isN($fl_mdl) || !isN($fl_are)){ $__fl .= ' AND ( '.$fl_are.$fl_mdl.' ) ';  }

	}


	/*if(!ChckSESS_adm() && SISUS_MDL_N != ''){
		$__fl .= ' AND mdlcnt_mdl IN (
										SELECT mdlus_mdl  FROM '.$__dt_cl->bd.'.'.TB_MDL_US.'
										INNER JOIN '._BdStr(DBM).TB_MDL.' ON mdlus_mdl = id_mdl
										WHERE id_mdlIN ( '.SISUS_MDL_N.' )
									) '; }*/




	if(_Chk_VLE('_are', 'p')){ $__fl .= _AndSql('mdl_are', ctjMlt(_GetPost('_are'))); }
	if(_Chk_VLE('_est', 'p')){ $__fl .= _AndSql('siscntest_enc', ctjMlt(_GetPost('_est'), ['s'=>'ok']) ); }
	if(_Chk_VLE('_cntEst', 'p')){ $__fl .= _AndSql('siscntest_tp', ctjMlt(_GetPost('_cntEst')) ); }
	if(_Chk_VLE('_cntMd', 'p')){ $__fl .= _AndSql('mdlcnt_m', ctjMlt(_GetPost('_cntMd'))); }
	if(_Chk_VLE('_cntMdl', 'p')){ $__fl .= _AndSql('mdlcnt_mdl', ctjMlt(_GetPost('_cntMdl'))); }


	if(_Chk_VLE('_cntSch', 'p')){ $__fl .= ' AND id_mdlcnt IN (SELECT mdlcntsch_mdlcnt FROM '.$__dt_cl->bd.'.'.TB_MDL_CNT_SCH.' INNER JOIN '._BdStr(DBM).TB_MDL_S_SCH.' ON id_mdlssch = mdlcntsch_mdlssch WHERE mdlssch_enc = "'._GetPost('_cntSch').'")'; }
	if(_Chk_VLE('_cntUs', 'p')){ $__fl .= 'AND mdlcnt_us IN ( SELECT id_us FROM  '._BdStr(DBM).TB_US.' WHERE us_enc IN ("'.ctjMlt(_GetPost('_cntUs')).'") )'; }



	if(_Chk_VLE('_cntPrdI', 'p')){ $__fl .= ' AND mdlcnt_prd IN ( SELECT id_mdlsprd FROM '._BdStr(DBM).TB_MDL_S_PRD.' WHERE mdlsprd_enc = "'._GetPost('_cntPrdI').'" )'; }
	if(_Chk_VLE('_cntPrdA', 'p')){ $__fl .= ' AND id_mdlcnt IN ( SELECT mdlcntprd_mdlcnt FROM '._BdStr($__dt_cl->bd).TB_MDL_CNT_PRD.' INNER JOIN '._BdStr(DBM).TB_MDL_S_PRD.' ON id_mdlsprd = mdlcntprd_mdlsprd WHERE mdlcntprd_est = 1 AND mdlsprd_enc = "'._GetPost('_cntPrdA').'" ) '; }



	if(_Chk_VLE('_u', 'p')){ $__fl .= ' AND id_cnt IN (SELECT cnttp_cnt FROM '.TB_CNT_TP.' WHERE cnttp_tp IN ('.$_POST['_u'].') )'; }

	//Datos incoherentes
	if(_Chk_VLE('_inc_dc', 'p')){ $__fl .= ' AND mdlcnt_cnt NOT IN (SELECT cntdc_cnt FROM cnt_dc WHERE cntdc_cnt = mdlcnt_cnt)'; }
	if(_Chk_VLE('_inc_eml', 'p')){ $__fl .= ' AND mdlcnt_cnt NOT IN (SELECT cnteml_cnt FROM cnt_eml WHERE cnteml_cnt = mdlcnt_cnt)'; }
	if(_Chk_VLE('_inc_tel', 'p')){ $__fl .= ' AND mdlcnt_cnt NOT IN (SELECT cnttel_cnt FROM cnt_tel WHERE cnttel_cnt = mdlcnt_cnt)'; }
	if(_Chk_VLE('_eml_bad', 'p')){ $__fl .= ' AND mdlcnt_cnt IN (SELECT cnteml_cnt FROM cnt_eml WHERE cnteml_f = 2 AND cnteml_cnt = mdlcnt_cnt)'; }
	if(_Chk_VLE('_tel_bad', 'p')){ $__fl .= ' AND mdlcnt_cnt IN (SELECT cnttel_cnt FROM cnt_tel WHERE cnttel_f = 2 AND cnttel_cnt = mdlcnt_cnt)'; }
	if(_Chk_VLE('_cntAre', 'p')){ $__fl .= ' AND mdlcnt_mdl IN (SELECT mdlare_mdl FROM '.$__dt_cl->bd.'.'.TB_MDL_ARE.' INNER JOIN '._BdStr(DBM).TB_CL_ARE.' ON mdlare_are = id_clare WHERE id_clare IN ( '.$_POST['_cntAre'].' ) )'; }


	if(_Chk_VLE('_ord', 'p') && _GetPost('_ord') == 'gst'){

		$__f_dte = 'mdlcnthis_fi';

		if(_Chk_VLE('_f_in', 'p') && _Chk_VLE('_f_out', 'p')){
			$__fl .= ' AND id_mdlcnt IN (SELECT mdlcnthis_mdlcnt FROM '.$__bd6.' WHERE DATE_FORMAT(mdlcnthis_fi, "%Y-%m-%d") BETWEEN '.GtSQLVlStr($_POST['_f_in'], 'date').' AND '.GtSQLVlStr($_POST['_f_out'], 'date').')';
		}elseif(_Chk_VLE('_f_in', 'p')){
			$__fl .= ' AND id_mdlcnt IN (SELECT mdlcnthis_mdlcnt FROM '.$__bd6.' WHERE DATE_FORMAT(mdlcnthis_fi, "%Y-%m-%d") = '.GtSQLVlStr($_POST['_f_in'], 'date').')';
		}elseif(_Chk_VLE('_f_out', 'p')){
			$__fl .= ' AND id_mdlcnt IN (SELECT mdlcnthis_mdlcnt FROM '.$__bd6.' WHERE DATE_FORMAT(mdlcnthis_fi, "%Y-%m-%d") = '.GtSQLVlStr($_POST['_f_out'], 'date').')';
		}

	}else{

		if(_Chk_VLE('_f_in', 'p') && _Chk_VLE('_f_out', 'p')){
			$__fl .= ' AND DATE_FORMAT(mdlcnt_fi, "%Y-%m-%d") BETWEEN '.GtSQLVlStr($_POST['_f_in'], 'date').' AND '.GtSQLVlStr($_POST['_f_out'], 'date');
		}elseif(_Chk_VLE('_f_in', 'p')){
			$__fl .= ' AND DATE_FORMAT(mdlcnt_fi, "%Y-%m-%d") = '.GtSQLVlStr($_POST['_f_in'], 'date');
		}elseif(_Chk_VLE('_f_out', 'p')){
			$__fl .= ' AND DATE_FORMAT(mdlcnt_fi, "%Y-%m-%d") = '.GtSQLVlStr($_POST['_f_out'], 'date');
		}

	}

	if(_Chk_VLE('_f_in', 'p') && _Chk_VLE('_f_out', 'p')){
		$__fl .= ' AND DATE_FORMAT(mdlcnt_fi, "%Y-%m-%d") BETWEEN '.GtSQLVlStr($_POST['_f_in'], 'date').' AND '.GtSQLVlStr($_POST['_f_out'], 'date');
	}elseif(_Chk_VLE('_f_in', 'p')){
		$__fl .= ' AND DATE_FORMAT(mdlcnt_fi, "%Y-%m-%d") = '.GtSQLVlStr($_POST['_f_in'], 'date');
	}elseif(_Chk_VLE('_f_out', 'p')){
		$__fl .= ' AND DATE_FORMAT(mdlcnt_fi, "%Y-%m-%d") = '.GtSQLVlStr($_POST['_f_out'], 'date');
	}


	$__dwn = _Dwn_S([ 't'=>'mdl_cnt', 'e_s'=>_GetPost('_eml_snd'), 'frm'=>_GetPost('_frm'), 'us'=>_GetPost('_us') ]);

	//$rsp['qry'] = $__dwn;

	if(!isN($__dwn->id)){

		if(!isN($___Ls->tpg)){ $__fl .= " AND mdlstp_tp = '".$___Ls->tpg."' "; }

		//$pdo = CnPrc_Pdo();

		$Ls_Whr = "FROM ".$__dt_cl->bd.".".TB_MDL_CNT."
						INNER JOIN ".$__dt_cl->bd.".".TB_MDL." ON mdlcnt_mdl = id_mdl
						INNER JOIN ".$__dt_cl->bd.".".TB_CNT." ON mdlcnt_cnt = id_cnt
						INNER JOIN "._BdStr(DBM).TB_SIS_CNT_EST." ON mdlcnt_est = id_siscntest
						INNER JOIN "._BdStr(DBM).TB_SIS_CNT_EST_TP." ON siscntest_tp = id_siscntesttp
						INNER JOIN "._BdStr(DBM).TB_SIS_MD." ON mdlcnt_m = id_sismd
						INNER JOIN "._BdStr(DBM).TB_MDL_S." ON mdl_mdls = id_mdls
						INNER JOIN "._BdStr(DBM).TB_MDL_S_TP." ON mdls_tp = id_mdlstp
						INNER JOIN "._BdStr(DBM).TB_SIS_FNT." ON id_sisfnt = mdlcnt_fnt

						LEFT JOIN "._BdStr($__dt_cl->bd).TB_CNT_PLCY." AS cplcy ON (cplcy.cntplcy_cnt = mdlcnt_cnt AND cplcy.cntplcy_sndi=1)
						LEFT JOIN "._BdStr(DBM).TB_CL_PLCY." AS clplcy ON (cplcy.cntplcy_plcy = clplcy.id_clplcy AND clplcy.clplcy_e=1)

				   WHERE id_mdlcnt != '' ";

		$Ls_WhrO = " ORDER BY id_mdlcnt DESC ";

		$__dwn_col = GtDwnCol([ 'cl'=>DB_CL_ID ]);


		if($__dwn_col->ls->sch->e == 'ok'){
			$_dwn_flds_col .= " (SELECT GROUP_CONCAT(".DBD.".ctjTx(mdlssch_nm) SEPARATOR ' | ') FROM "._BdStr(DBM).TB_MDL_S_SCH." INNER JOIN ".$__dt_cl->bd.".".TB_MDL_CNT_SCH." ON id_mdlssch = mdlcntsch_mdlssch WHERE mdlcntsch_mdlcnt = id_mdlcnt ) AS Horario , ";
		}

		if($__dwn_col->ls->prdi->e == 'ok'){
			$_dwn_flds_col .= " (SELECT ".DBD.".ctjTx(mdlsprd_nm) FROM "._BdStr(DBM).TB_MDL_S_PRD." WHERE id_mdlsprd = mdlcnt_prd) as Periodo_Ingresa, ";
		}

		if($__dwn_col->ls->prda->e == 'ok'){
			$_dwn_flds_col .= " (SELECT mdlsprd_nm FROM "._BdStr(DBM).TB_MDL_S_PRD." INNER JOIN "._BdStr($__dt_cl->bd).TB_MDL_CNT_PRD." ON id_mdlsprd = mdlcntprd_mdlsprd WHERE mdlcntprd_mdlcnt = id_mdlcnt AND mdlcntprd_est = 1 ORDER BY id_mdlcntprd DESC LIMIT 1 ) Periodo_Aplica, ";
		}

		$Ls_Qry = "

			CREATE TABLE IF NOT EXISTS "._BdStr(DBD).$__dwn->tab." ENGINE=InnoDB CHARSET=utf8mb4 COLLATE utf8mb4_unicode_520_ci ROW_FORMAT=COMPACT AS (

				SELECT

					DISTINCT id_mdlcnt AS ID,
					mdlcnt_fi AS Ingreso,

					".DBD.".ctjTx(siscntest_tt) AS Estado,
					".DBD.".ctjTx(siscntesttp_tt) AS Etapa,
					".DBD.".ctjTx(sismd_tt) AS Medio,
					".DBD.".ctjTx(sisfnt_nm) AS Fuente,

					".DBD.".ctjTx( IF(cntplcy_sndi=1, cnt_nm, '-anonimo-') ) AS Nombres,
					".DBD.".ctjTx( IF(cntplcy_sndi=1, cnt_ap, '') ) AS Apellidos,

					".DBD.".ctjTx(mdlstp_nm) AS Tipo_modulo,
					".DBD.".ctjTx(mdl_nm) AS Modulo,
					{$_dwn_flds_col}

					(SELECT GROUP_CONCAT(".DBD.".ctjTx(act_tt) SEPARATOR ' | ') FROM "._BdStr(DBM).TB_ACT." INNER JOIN ".$__dt_cl->bd.".".TB_ACT_CNT." ON id_act = actcnt_act WHERE actcnt_cnt = id_cnt ) AS Actividad,


					(	SELECT GROUP_CONCAT( DISTINCT IF(cntplcy_sndi=1, cntdc_dc, '-anonimo-') SEPARATOR ' | ')
						FROM ".$__dt_cl->bd.".".TB_CNT_DC."
							 LEFT JOIN "._BdStr($__dt_cl->bd).TB_CNT_PLCY." AS cplcy_dc ON (cplcy_dc.cntplcy_cnt = cntdc_cnt AND cplcy_dc.cntplcy_sndi=1)
							 LEFT JOIN "._BdStr(DBM).TB_CL_PLCY." AS clplcy_dc ON (cplcy_dc.cntplcy_plcy = clplcy_dc.id_clplcy AND clplcy_dc.clplcy_e=1)
						WHERE cntdc_cnt = id_cnt
					) AS Documento,

					(
						SELECT GROUP_CONCAT( DISTINCT IF(cntplcy_sndi=1, cnttel_tel, '-anonimo-') SEPARATOR ' | ')
						FROM ".$__dt_cl->bd.".".TB_CNT_TEL."
							 LEFT JOIN "._BdStr($__dt_cl->bd).TB_CNT_PLCY." AS cplcy_tel ON (cplcy_tel.cntplcy_cnt = cnttel_cnt AND cplcy_tel.cntplcy_sndi=1)
							 LEFT JOIN "._BdStr(DBM).TB_CL_PLCY." AS clplcy_tel ON (cplcy_tel.cntplcy_plcy = clplcy_tel.id_clplcy AND clplcy_tel.clplcy_e=1)
						WHERE cnttel_cnt = id_cnt
					) AS Telefonos,

					(
						SELECT GROUP_CONCAT( DISTINCT IF(cntplcy_sndi=1, cnteml_eml, '-anonimo-') SEPARATOR ' | ')
						FROM "._BdStr($__dt_cl->bd).TB_CNT_EML."
							 LEFT JOIN "._BdStr($__dt_cl->bd).TB_CNT_PLCY." AS cplcy_eml ON (cplcy_eml.cntplcy_cnt = cnteml_cnt AND cplcy_eml.cntplcy_sndi=1)
							 LEFT JOIN "._BdStr(DBM).TB_CL_PLCY." AS clplcy_eml ON (cplcy_eml.cntplcy_plcy = clplcy_eml.id_clplcy AND clplcy_eml.clplcy_e=1)
						WHERE cnteml_cnt = id_cnt
					) AS Correos,

					(SELECT ".DBD.".ctjTx(siscd_tt) FROM "._BdStr($__dt_cl->bd).TB_CNT_CD." INNER JOIN "._BdStr(DBM).TB_SIS_CD." ON cntcd_cd = id_siscd WHERE cntcd_cnt = id_cnt AND cntcd_rel = "._CId('ID_TPRLCC_NCO')." ORDER BY cntcd_fi DESC LIMIT 1 ) AS Ciudad_Nacimiento,
					(SELECT ".DBD.".ctjTx(siscd_tt) FROM "._BdStr($__dt_cl->bd).TB_CNT_CD." INNER JOIN "._BdStr(DBM).TB_SIS_CD." ON cntcd_cd = id_siscd WHERE cntcd_cnt = id_cnt AND cntcd_rel = "._CId('ID_TPRLCC_VVE')." ORDER BY cntcd_fi DESC LIMIT 1 ) AS Ciudad_Vive,

					(SELECT COUNT(*) FROM ".$__dt_cl->bd.".".TB_MDL_CNT." WHERE mdlcnt_cnt = id_cnt) AS Intereses,
					'3' as __dwn_e,

					id_mdlcnt AS __dwn_i,

					(SELECT COUNT(*) FROM ".$__dt_cl->bd.".".TB_MDL_CNT_HIS." WHERE mdlcnthis_mdlcnt = id_mdlcnt) AS Total_gestiones,

					(SELECT CONCAT(".DBD.".ctjTx(us_nm),' ', ".DBD.".ctjTx(us_ap) ) FROM sumr_bd.us WHERE id_us = mdlcnt_us ) as Usuario,
					(SELECT GROUP_CONCAT( siscnttp_nm SEPARATOR ' | ') FROM "._BdStr(DBM).TB_SIS_CNT_TP." INNER JOIN ".$__dt_cl->bd.".".TB_CNT_TP." ON cnttp_tp = id_siscnttp WHERE cnttp_cnt = id_cnt) AS Vinculos





				   $Ls_Whr $__fl $Ls_WhrO

			);


			ALTER TABLE "._BdStr(DBD).$__dwn->tab." ADD id_dwnprc INT(10) NOT NULL AUTO_INCREMENT PRIMARY KEY AFTER __dwn_i;
			CREATE INDEX __indx_id ON "._BdStr(DBD).$__dwn->tab." (__dwn_i) USING BTREE;

		";



		$Ls_Qry_His = "

			CREATE TABLE IF NOT EXISTS "._BdStr(DBD).$__dwn->tab."_his ENGINE=InnoDB CHARSET=utf8mb4 COLLATE utf8mb4_unicode_520_ci ROW_FORMAT=COMPACT AS (
				SELECT
					id_mdlcnt AS ID,
				   	$Ls_Whr $__fl $Ls_WhrO
			);

			ALTER TABLE "._BdStr(DBD).$__dwn->tab."_his ADD id_dwnprc INT(10) NOT NULL AUTO_INCREMENT PRIMARY KEY AFTER __dwn_i;
			CREATE INDEX __indx_id ON "._BdStr(DBD).$__dwn->tab."_his (__dwn_i) USING BTREE;

		";


		//Ingresa el historial de la descarga
		_Dwn_His_S([ "dwn"=>$__dwn->id, "main"=>$Ls_Qry, 'his'=>$Ls_Qry_His ]);
		//$rsp['qry'] = $Ls_Qry;

		if(!isN($__dwn->id) && $__sve_qry->e == 'ok'){

			$updateSQL_UPD = sprintf("UPDATE "._BdStr(DBD).TB_DWN." SET dwn_est=%s, WHERE id_dwn=%s",
                               GtSQLVlStr(6, "int"),
                               GtSQLVlStr($__dwn->id, "int"));

            $Ls_RgC = $__cnx->_prc($updateSQL_UPD);

			/*$Ls_RgC = $pdo->prepare($updateSQL_UPD);
			$Ls_RgC->execute();*/

			//$__dwn_dt = GtDwnDt([ 'id'=>$__dwn->id ]);
			//$rsp['err'] = $Ls_RgC->errorInfo();

			$rsp['err'] = $__cnx->c_p->error;

			$__dwntot = GtDwnTotDt([ 'id'=>$__dwn_dt->id, 'tot'=>$__dwntot ]);

			if(!$Ls_RgC){

				UPD_Dwn([ 'i'=>$__dwn_dt->id, 'e'=>5, 'tot'=>$__dwntot, 'w'=>json_encode($Ls_RgC->errorInfo(), true) ]);

			}else{

				$rsp['e'] = 'ok';
				$rsp['tb'] = $__dwn->tab;
				$rsp['tb_id'] = $__dwn->id;

				if(!isN($__dwn_dt->id)){

					$__upd = UPD_Dwn([
								'i'=>$__dwn_dt->id,
								'tt'=>MDL_CNT.' '.$___Ls->tt.' - '.$_POST['_f_in'].'-'.$_POST['_f_out'], 't_r'=>$__dwn_dt->tot->no_u,
								'g'=>json_encode($_POST, true),
								'tot'=>$__dwntot
							]);

				}

			}


		}

	}


	/*$pdo=null;*/


}

?>