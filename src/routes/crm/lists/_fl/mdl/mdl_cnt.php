<?php

if(class_exists('CRM_Cnx')){



	$__scrpt = GtClScrptLs([ 'tp'=>_CId('ID_SISSCRPTTP_SNDI') ]);

	$___Ls->sch->f = 'id_mdlcnt, id_cnt, mdlcnt_m, cnt_nm, cnt_ap, mdlcnt_est, mdlcnt_mdl, id_cnt';
	$___Ls->flt = 'ok';
	$___Ls->cnx->cl = 'ok';
	$___Ls->new->w = 500;
	$___Ls->new->h = 150;
	//$___Ls->new->scrl = 'no';
	$___Ls->edit->scrl = 'no';
	$___Ls->edit->big = 'ok';
	$___Ls->dwn = 'ok';
	$___Ls->grph->tot = 8; //5
	$___Ls->vw->rfrsh = 'no';

	if($___Ls->gt->pnl->e != 'ok'){
		$___Ls->ls->nxt->hb = 'ok';
	}

	$___Ls->sch->m = ' || (
		EXISTS (SELECT * FROM '.TB_CNT_EML.' WHERE cnteml_cnt = id_cnt AND cnteml_eml LIKE \'%[-SCH-]%\' )  ||
		EXISTS (SELECT * FROM '.TB_CNT_DC.' WHERE cntdc_cnt = id_cnt AND cntdc_dc LIKE \'%[-SCH-]%\' ) ||
		EXISTS (SELECT * FROM '.TB_CNT_TEL.' WHERE cnttel_cnt = id_cnt AND cnttel_tel LIKE \'%[-SCH-]%\' )
	)';

	$___Ls->_strt();


	if(!isN($___Ls->_fl->f1) && !isN($___Ls->_fl->f2)){
		$___Ls->qry_f .= ' AND DATE_FORMAT(mdlcnt_fi, "%Y-%m-%d") BETWEEN "'.$___Ls->_fl->f1.'" AND "'.$___Ls->_fl->f2.'" ';
	}elseif(!isN($___Ls->_fl->f1)){
		$___Ls->qry_f .= ' AND DATE_FORMAT(mdlcnt_fi, "%Y-%m-%d")  = "'.$___Ls->_fl->f1.'" ';
	}elseif(!isN($___Ls->_fl->f2)){
		$___Ls->qry_f .= ' AND DATE_FORMAT(mdlcnt_fi, "%Y-%m-%d")  = "'.$___Ls->_fl->f2.'" ';
	}

	$___Ls->qry_f .= " AND mdlst.mdlstp_tp = '".$___Ls->gt->tsb."' ";



	if(!isN($___Ls->gt->i)){

		$___Ls->qrys = sprintf("SELECT  mdlcnt_enc, mdlcnt_lck_us, mdl_img, mdlstp_clr, mdl_nm, mdlcnt_dsp, mdlcnt_ref, cnt_enc, id_mdlcnt, mdlcnt_mdl , mdl_enc,mdl_nm , cnt_nm, cnt_ap,
										mdlcnt_est, mdlcnt_m, mdlcnt_fnt, sisfnt_nm, sismd_tt, mdlcnt_m_k, mdlcnt_pgd, mdlcnt_dcto, mdlsprd_nm, siscntest_noi, mdlcnt_noi, mdlcnt_noi_otc ,
										sismd_tp, id_mdlstp, mdlcnt_cl_sds,
									(
										SELECT
											GROUP_CONCAT(id_clare)
										FROM
											".TB_MDL."
										INNER JOIN ".TB_MDL_ARE." ON mdlare_mdl = id_mdl
										INNER JOIN "._BdStr(DBM).TB_CL_ARE." ON mdlare_are = id_clare
										WHERE mdlcnt_mdl = id_mdl AND clare_est = 1
									) AS _are

								    FROM ".TB_MDL_CNT."
								   		INNER JOIN ".TB_MDL." ON mdlcnt_mdl = id_mdl
								   		INNER JOIN ".TB_CNT." ON mdlcnt_cnt = id_cnt
								   		INNER JOIN "._BdStr(DBM).TB_SIS_CNT_EST." ON mdlcnt_est = id_siscntest
								   		INNER JOIN "._BdStr(DBM).TB_SIS_MD." ON mdlcnt_m = id_sismd
								   		INNER JOIN "._BdStr(DBM).TB_MDL_S." ON mdl_mdls = id_mdls
								   		INNER JOIN "._BdStr(DBM).TB_MDL_S_TP." ON mdls_tp = id_mdlstp
								   		LEFT JOIN "._BdStr(DBM).TB_SIS_CNT_NOI." ON mdlcnt_noi = id_siscntnoi
								   		RIGHT JOIN "._BdStr(DBM).TB_SIS_FNT." ON mdlcnt_fnt = id_sisfnt
									   	LEFT JOIN "._BdStr(DBM).TB_MDL_S_PRD." ON mdlcnt_prd = id_mdlsprd
								   		LEFT JOIN ".TB_MDL_CNT_SCH." ON mdlcntsch_mdlcnt = id_mdlcnt

								    WHERE ".$___Ls->ik." = %s LIMIT 1", GtSQLVlStr($___Ls->gt->i, "text"));
		//echo $___Ls->qrys;

	}elseif($___Ls->_show_ls == 'ok'){

		if(_ChckMd('cnt_ord_asc') && !ChckSESS_superadm()){
			$SqlOrd = 'ASC';
		}else{
			$SqlOrd = 'DESC';
		}

		if(!isN($__t2) && $__t2 == 'sac'){
			$___Ls->qry_f .= ' AND EXISTS

									( 	SELECT mdlcnttra_mdlcnt
										FROM '.TB_MDL_CNT_TRA.'
										WHERE mdlcnttra_mdlcnt = id_mdlcnt
									) ';
		}

		if(!isN($___Ls->_fl->org)){
			$__all_org = implode(',', $___Ls->_fl->org);
			$___Ls->qry_f .= ' AND EXISTS

									( 	SELECT *
										FROM '.TB_ORG_SDS_CNT.'
											 INNER JOIN '._BdStr(DBM).TB_ORG_SDS.' ON orgsdscnt_orgsds = id_orgsds
											 INNER JOIN '._BdStr(DBM).TB_ORG.' ON orgsds_org = id_org
										WHERE orgsdscnt_cnt = mdlcnt_cnt AND org_enc IN ('.$__all_org.')
									) ';
		}

		if(!isN($___Ls->_fl->chk)){

			$___Ls->qry_f .= ' AND EXISTS ( SELECT *
												FROM '.TB_MDL_CNT_CHCK.'
												WHERE mdlcntchck_mdlcnt = id_mdlcnt AND mdlcntchck_sisslc IN ('.$___Ls->_fl->chk.') AND mdlcntchck_est = 1
											) ';
		}

		// ------ Filtros de Puhsmmail ---- //

		$__flt_ec = " INNER JOIN ".TB_MDL_CNT_EC." ON mdlcntec_mdlcnt = id_mdlcnt
						INNER JOIN ".TB_EC_SND." ON mdlcntec_ecsnd = id_ecsnd
						INNER JOIN "._BdStr(DBM).TB_EC." ON ecsnd_ec = id_ec";

		if(!isN($___Ls->_fl->fk->mdlcnt_ec)){
			$ls_qry_innr .= $__flt_ec;
			$___Ls->qry_f .= " AND ec_enc = '".$___Ls->_fl->fk->mdlcnt_ec."' ";
		}

		if(!isN($___Ls->_fl->fk->mdlcntec_op)){
			if(isN($___Ls->_fl->fk->mdlcnt_ec)){ $ls_qry_innr .= $__flt_ec;	}
			$ls_qry_innr .= " INNER JOIN "._BdStr(DBM).TB_EC_OP." ON ecop_snd = id_ecsnd";
		}

		if(!isN($___Ls->_fl->fk->mdlcntec_snd)){
			if(isN($___Ls->_fl->fk->mdlcnt_ec)){ $ls_qry_innr .= $__flt_ec; }
			$ls_qry_innr .= " INNER JOIN "._BdStr(DBM).TB_SIS_SLC." ON ecsnd_est = id_sisslc";
			$___Ls->qry_f .= " AND ecsnd_est = '"._CId('ID_SNDEST_SND')."' ";
		}

		if(!isN($___Ls->_fl->fk->mdlcntec_clk)){
			if(isN($___Ls->_fl->fk->mdlcnt_ec)){ $ls_qry_innr .= $__flt_ec;	}
			$ls_qry_innr .= " INNER JOIN ".TB_EC_TRCK." ON ectrck_snd = id_ecsnd";
		}

		// ------ Fin Filtros de Puhsmmail ---- //
		if(!isN($___Ls->_fl->cnteml_est)){
			$ls_qry_innr .= " INNER JOIN ".TB_CNT_EML." ON cnteml_cnt = id_cnt";
		}

		if(!isN($___Ls->_fl->fk->id_clare)){

			if(is_array($___Ls->_fl->fk->id_clare)){
				$__all_are = implode(',', $___Ls->_fl->fk->id_clare);
			}else{
				$__all_are = "'".$___Ls->_fl->fk->id_clare."'";
			}

			$___Ls->qry_f .= ' AND EXISTS( SELECT *
										FROM '.TB_MDL_ARE.'
											 INNER JOIN '._BdStr(DBM).TB_CL_ARE.' ON mdlare_are = id_clare
										WHERE mdlare_mdl = mdlcnt_mdl AND id_clare IN ('.$__all_are.') AND clare_est = 1
									) ';
		}



		if(!isN($___Ls->_fl->fk->mdlcnt_prd_wnt)){

			if(is_array( $___Ls->_fl->fk->mdlcnt_prd_wnt )){
				$__all_prd_w = implode(',', $___Ls->_fl->fk->mdlcnt_prd_wnt);
			}else{
				$__all_prd_w = '"'.$___Ls->_fl->fk->mdlcnt_prd_wnt.'"';
			}

			if(!isN($__all_prd_w)){

				$___Ls->qry_f .= ' AND EXISTS ( SELECT *
											FROM '.TB_MDL_CNT_PRD.'
												 INNER JOIN '._BdStr(DBM).TB_MDL_S_PRD.' ON mdlcntprd_mdlsprd = id_mdlsprd
											WHERE mdlcntprd_mdlcnt = id_mdlcnt AND mdlsprd_enc IN ('.$__all_prd_w.')
										) ';

			}

		}

		if(!isN($___Ls->_fl->fk->mdlcnt_prd_i)){

			if(is_array( $___Ls->_fl->fk->mdlcnt_prd_i )){
				$__all_prd_i = implode(',', $___Ls->_fl->fk->mdlcnt_prd_i);
			}else{
				$__all_prd_i = '"'.$___Ls->_fl->fk->mdlcnt_prd_i.'"';
			}

			if(!isN($__all_prd_i)){

				$___Ls->qry_f .= ' AND EXISTS (
												SELECT *
												FROM  '._BdStr(DBM).TB_MDL_S_PRD.'
												WHERE id_mdlsprd = mdlcnt_prd AND mdlcnt_prd = id_mdlsprd AND mdlsprd_enc IN ('.$__all_prd_i.')
										    ) ';

			}

		}

		if(!isN($___Ls->_fl->fk->us_enc)){

			if(is_array( $___Ls->_fl->fk->us_enc )){ $__all_prd_i = implode(',', $___Ls->_fl->fk->us_enc); }else{ $__all_prd_i = '"'.$___Ls->_fl->fk->us_enc.'"'; }

			if(!isN($__all_prd_i)){
				$___Ls->qry_f .= ' AND EXISTS (
											SELECT *
											FROM '._BdStr(DBM).TB_US.'
											WHERE id_us = mdlcnt_us AND us_enc IN ('.$__all_prd_i.')
										) ';
			}
		}

		if(!isN($___Ls->_fl->fk->act_enc)){

			if(is_array( $___Ls->_fl->fk->act_enc )){
				$__all_act = implode(',', $___Ls->_fl->fk->act_enc);
			}else{
				$__all_act = '"'.$___Ls->_fl->fk->act_enc.'"';
			}

			if(!isN($__all_act)){

				$___Ls->qry_f .= ' AND EXISTS (
											 SELECT *
											 FROM  '.TB_ACT_CNT.'
											 INNER JOIN '._BdStr(DBM).TB_ACT.'
											 ON (actcnt_act = id_act)
											 WHERE actcnt_cnt = mdlcnt_cnt AND act_enc  IN ('.$__all_act.')
									     ) ';

			}

		}

		if(!isN($___Ls->_fl->fk->mdl_s_hro)){

			if(is_array( $___Ls->_fl->fk->mdl_s_hro )){
				$__all_sch = implode(',', $___Ls->_fl->fk->mdl_s_hro);
			}else{
				$__all_sch = '"'.$___Ls->_fl->fk->mdl_s_hro.'"';
			}

			if(!isN($__all_sch)){

				$___Ls->qry_f .= ' AND EXISTS (
											 SELECT  *
											 FROM '.TB_MDL_CNT_SCH.'
											 INNER JOIN '._BdStr(DBM).TB_MDL_S_SCH.'
											 ON (id_mdlssch = mdlcntsch_mdlssch)
											 WHERE mdlcntsch_mdlssch = mdlcntsch_mdlssch AND mdlssch_enc  IN ('.$__all_sch.')
									     ) ';

			}

		}

		if(!isN($___Ls->_fl->fk->siscd_enc)){

			if(is_array( $___Ls->_fl->fk->siscd_enc )){
				$__all_cd = implode(',', $___Ls->_fl->fk->siscd_enc);
			}else{
				$__all_cd = '"'.$___Ls->_fl->fk->siscd_enc.'"';
			}

			if(!isN($__all_cd)){

				$___Ls->qry_f .= ' AND mdlcnt_cnt IN (
														SELECT cntcd_cnt FROM '.TB_CNT_CD.'
														INNER JOIN '._BdStr(DBM).TB_SIS_CD.' ON id_siscd = cntcd_cd
														WHERE siscd_enc IN ('.$__all_cd.')
													) ';

			}

		}

		//Nació
		if(!isN($___Ls->_fl->fk->_mdlfl_cd_nco)){
			if(is_array( $___Ls->_fl->fk->_mdlfl_cd_nco )){ $__all_prd_i = implode(',', $___Ls->_fl->fk->_mdlfl_cd_nco); }else{ $__all_prd_i = '"'.$___Ls->_fl->fk->_mdlfl_cd_nco.'"'; }

			if(!isN($__all_prd_i)){
				$___Ls->qry_f .= ' AND mdlcnt_cnt IN (
											SELECT cntcd_cnt
											FROM '.TB_CNT_CD.'
											INNER JOIN '._BdStr(DBM).TB_SIS_CD.' ON cntcd_cd = id_siscd
											WHERE siscd_enc IN ('.$__all_prd_i.')
											AND cntcd_rel = '._CId('ID_TPRLCC_NCO').'
										) ';
			}
		}

		//Vivió
		if(!isN($___Ls->_fl->fk->_mdlfl_cd_vvo)){
			if(is_array( $___Ls->_fl->fk->_mdlfl_cd_vvo )){ $__all_prd_i = implode(',', $___Ls->_fl->fk->_mdlfl_cd_vvo); }else{ $__all_prd_i = '"'.$___Ls->_fl->fk->_mdlfl_cd_vvo.'"'; }

			if(!isN($__all_prd_i)){
				$___Ls->qry_f .= ' AND mdlcnt_cnt IN (
											SELECT cntcd_cnt
											FROM '.TB_CNT_CD.'
											INNER JOIN '._BdStr(DBM).TB_SIS_CD.' ON cntcd_cd = id_siscd
											WHERE siscd_enc IN ('.$__all_prd_i.')
											AND cntcd_rel = '._CId('ID_TPRLCC_VVO').'
										) ';
			}
		}

		//Vive
		if(!isN($___Ls->_fl->fk->_mdlfl_cd_vve)){
			if(is_array( $___Ls->_fl->fk->_mdlfl_cd_vve )){ $__all_prd_i = implode(',', $___Ls->_fl->fk->_mdlfl_cd_vve); }else{ $__all_prd_i = '"'.$___Ls->_fl->fk->_mdlfl_cd_vve.'"'; }

			if(!isN($__all_prd_i)){
				$___Ls->qry_f .= ' AND mdlcnt_cnt IN (
											SELECT cntcd_cnt
											FROM '.TB_CNT_CD.'
											INNER JOIN '._BdStr(DBM).TB_SIS_CD.' ON cntcd_cd = id_siscd
											WHERE siscd_enc IN ('.$__all_prd_i.')
											AND cntcd_rel = '._CId('ID_TPRLCC_VVE').'
										) ';
			}
		}


		//Pais Relacionado
		if(!isN($___Ls->_fl->fk->_mdlfl_ps_rltd)){
			if(is_array( $___Ls->_fl->fk->_mdlfl_ps_rltd)){ $__all_prd_i = implode(',', $___Ls->_fl->fk->_mdlfl_ps_rltd); }else{ $__all_prd_i = '"'.$___Ls->_fl->fk->_mdlfl_ps_rltd.'"'; }

			if(!isN($__all_prd_i)){
				$___Ls->qry_f .= ' AND mdlcnt_cnt IN (
											SELECT cnttel_cnt
											FROM '.TB_CNT_TEL.'
												 INNER JOIN '._BdStr(DBM).TB_SIS_PS.' ON cnttel_ps = id_sisps
											WHERE sisps_enc IN ('.$__all_prd_i.')
										) ';
			}
		}


		if(!isN($___Ls->_fl->fk->cnt_tot_mdlcnt)){
            $___lsdt = __LsDt(['k'=>'num', 'id'=>$___Ls->_fl->fk->cnt_tot_mdlcnt, 'no_lmt'=>'ok' ]);
            $___Ls->qry_f .= " AND cnt_tot_mdlcnt = '".$___lsdt->d->tt."' ";
        }

		if(!ChckSESS_superadm() && !_ChckMd($___Ls->mdlstp->tp.'_cnt_all')){

			if(defined('SISUS_ARE') && !isN(SISUS_ARE)){

				$fl_are = ' EXISTS (	SELECT *
										FROM '.TB_MDL_ARE.'
										WHERE mdlare_mdl = id_mdl AND mdlare_are IN ('.SISUS_ARE.')
									) ';
			}

			if(defined('SISUS_MDL_N') && !isN(SISUS_MDL_N)){
				if(!isN($fl_are)){ $fl_mdl = ' || '; }
				$fl_mdl .= ' (	 id_mdl IN ( '.SISUS_MDL_N.' )	 ) ';
			}

			if(!isN($fl_mdl) || !isN($fl_are)){ $___Ls->qry_f .= ' AND ( '.$fl_are.$fl_mdl.' ) ';  }

			$___Ls->qry_f .= " AND mdl_est != '"._CId('ID_SISMDLEST_ELI')."' ";

		}


		if(!isN($___Ls->gt->tsb_m)){ $___Ls->qry_f .= " AND mdlt.mdlstp_tp = '".$___Ls->gt->tsb_m."' "; }


		if(!isN($___Ls->fl->siscnttp_enc)){

			$ls_qry_slct .= " , siscnttp_enc ";

			$ls_qry_innr .= " 	LEFT JOIN ".TB_CNT_TP." ON cnttp_cnt = id_cnt
								LEFT JOIN "._BdStr(DBM).TB_SIS_CNT_TP." ON cnttp_tp = id_siscnttp
							";

		}

		if(mBln($__dt_cl->tag->sis->asggstest->v) == 'ok' && !_ChckMd($___Ls->mdlstp->tp.'_cnt_all')){
			$___Ls->qry_f .= ' AND (mdlcntus_us="'.SISUS_ID.'" OR mdlcntus_us IS NULL) ';
		}

		if(!isN($___Ls->fl->siscntnoi_enc)){
			$ls_qry_slct .= " , siscntnoi_enc ";
			$ls_qry_innr .= " LEFT JOIN "._BdStr(DBM).TB_SIS_CNT_NOI." ON mdlcnt_noi = id_siscntnoi ";
		}

		if(!isN($__t2) && $__t2 == 'sac'){

			$ls_qry_innr .= "
				LEFT JOIN ".TB_MDL_CNT_TRA." ON mdlcnttra_mdlcnt = id_mdlcnt
				LEFT JOIN "._BdStr(DBM).TB_TRA." ON mdlcnttra_tra = id_tra
				LEFT JOIN "._BdStr(DBS).TB_STORE_BRND." ON tra_sbrnd = id_storebrnd
				LEFT JOIN "._BdStr(DBM).TB_TRA_COL." ON tra_col = id_tracol
				LEFT JOIN "._BdStr(DBM).TB_SIS_SLC_F." ON tracol_clr = sisslcf_slc
			";

			$ls_qry_slct .= ", tra_enc, storebrnd_nm, storebrnd_img, tracol_tt, tracol_icn, sisslcf_vl";

		}

		if(( $__dt_cl->mdlstp->{$__t2}->col->mdl_cnt_us->allw == 'ok' || isN($__t2) ) && _ChckMd('mdlcnt_us_vw')){

			$ls_qry_innr .= "
				LEFT JOIN "._BdStr(DBM).TB_US." ON mdlcntus_us = id_us
			";

			$ls_qry_slct .= ", us_nm, us_ap";

		}


		$Ls_FGst = " (
						SELECT CONCAT(mdlcnthis_fi,' ', mdlcnthis_hi)
						FROM ".TB_MDL_CNT_HIS."
						WHERE mdlcnthis_mdlcnt = id_mdlcnt
						ORDER BY id_mdlcnthis ASC
						LIMIT 1
					) AS __cnt_gst_frst, ";


		$Ls_Whr = "FROM ".TB_MDL_CNT."
						INNER JOIN ".TB_MDL." ON mdlcnt_mdl = id_mdl
						INNER JOIN "._BdStr(DBM).TB_SIS_CNT_EST." ON mdlcnt_est = id_siscntest
						INNER JOIN "._BdStr(DBM).TB_SIS_CNT_EST_TP." ON siscntest_tp = id_siscntesttp
						INNER JOIN ".TB_CNT." ON mdlcnt_cnt = id_cnt
						INNER JOIN "._BdStr(DBM).TB_MDL_S." ON mdl_mdls = id_mdls
						INNER JOIN "._BdStr(DBM).TB_MDL_S_TP." AS mdlst ON mdls_tp = mdlst.id_mdlstp
						INNER JOIN "._BdStr(DBM).TB_SIS_MD." ON mdlcnt_m = id_sismd
						LEFT JOIN "._BdStr(DBM).TB_SIS_FNT." ON mdlcnt_fnt = id_sisfnt
						LEFT JOIN "._BdStr(DBM).TB_MDL_S_PRD." ON mdlcnt_prd = id_mdlsprd
						LEFT JOIN "._BdStr(DBM).TB_MDL_S_TP." AS mdlt ON mdl_mdlstp = mdlt.id_mdlstp
						LEFT JOIN ".TB_MDL_CNT_SCH." ON mdlcntsch_mdlcnt = id_mdlcnt
						LEFT JOIN ".TB_MDL_CNT_US." ON mdlcntus_mdlcnt = id_mdlcnt

						{$ls_qry_innr}

				   WHERE ".$___Ls->ik." != '' ".$___Ls->qry_f."  ".$___Ls->sch->cod."
				";


		$___Ls->qrys_tot = "SELECT COUNT(DISTINCT id_mdlcnt) AS ".QRY_RGTOT." $Ls_Whr";

		if($___Ls->mdlstp->unq == 'no'){ $_grp_by='id_mdlcnt'; }else{ $_grp_by='mdlcnt_cnt, mdlcnt_mdl'; }

		$___Ls->qrys = "	SELECT DISTINCT id_mdlcnt,

									mdlcnt_cnt AS __tcnt,
									mdlcnt_enc,
									mdlcnt_m,
									mdlcnt_dsp,
									mdlcnt_ref,
									mdlcnt_est,
									mdlcnt_mdl,
									mdlcnt_fi,
									mdlcnt_fa,
									mdlcnt_cnt,
									mdlcnt_m_k,
									mdlcnt_chk_chi,
									mdlcnt_us,
									mdlcnt_prd,
									mdlcntus_us,

									id_cnt,
									cnt_nm,
									cnt_ap,
									cnt_sx,

									mdlst.mdlstp_tp AS __mdlstp_tp,
									mdlt.mdlstp_tp AS __mdlttp_tp,

									id_mdl,
									mdl_nm,
									mdl_enc,
									mdl_est,

									siscntest_enc,
									siscntest_tt,
									siscntest_clr_bck,
									siscntesttp_enc,

									sismd_enc,
									sismd_tt,
									sisfnt_enc,
									mdlcntsch_mdlssch,
									cnt_tot_mdlcnt
									{$ls_qry_slct}

							$Ls_Whr
							GROUP BY {$_grp_by}
							ORDER BY /*id_mdlcnt*/ mdlcnt_fi $SqlOrd, mdlcnt_fa $SqlOrd";

	}

	$___Ls->_bld();
	//echo $___Ls->qrys;

	if($___Ls->sql && !isN($___Ls->gt->i)){
		$__dt_mdlcnt = GtMdlCntDt([ 'id'=>$___Ls->dt->rw['mdlcnt_enc'], 't'=>'enc', 'shw'=>[ 'attr'=>'ok' ] ]);
		$__dt_cnt = $__dt_mdlcnt->cnt;
		MdlCntLck([ 'id'=>$___Ls->dt->rw['id_mdlcnt'], 'l'=>true ]);
		$__Mdl_R_Chk = _ChckMdlRel([ 'bd', 'mdl'=>$___Ls->dt->rw['id_mdl'], 'cnt'=>$___Ls->dt->rw['mdlcnt_cnt'], 'allw'=>'ok' ]);
	}

	if(!isN($___Ls->gt->main_cnv->id)){

		$__Cnt = new CRM_Cnt();
		$_GtMainCnvDt = GtMainCnvDt([ 'enc'=>$___Ls->gt->main_cnv->id, 'd'=>[ 'chnl'=>'ok' ] ]);


		if($___Ls->gt->main_cnv->t == 'eml'){

			foreach($_GtMainCnvDt->chnl->addr->from->ls as $_from_k=>$_from_v){
				$_cnt_key_sch = $_from_v->eml;
				$_cnt_key_nm = $_from_v->nm;
			}

			$_cnt_key_md = _CId('SIS_MD_MAIL');
			$__Cnt->cnt_eml = $_cnt_key_sch;
			$__Cnt->cnt_nm = $_cnt_key_nm;
			$__Cnt->NmAp();

		}else{

			if(substr($_GtMainCnvDt->chnl->from->id, 0, 2) == 57){
				$_cnt_key_sch = substr($_GtMainCnvDt->chnl->from->id, 2, 12);
				$__Cnt->cnt_tel = $_cnt_key_sch;
			}

			if($_GtMainCnvDt->tp == 'whtsp'){

				$_cnt_key_md = _CId('SIS_MD_WHTSP');

				if(!isN( $_GtMainCnvDt->chnl->from->id )){

					$_telpssch = _ChckCntTelPs([ 'no'=>'+'.$_GtMainCnvDt->chnl->from->id ]);

					if(!isN( $_telpssch->id )){
						$_cnt_dfl_ps = $_telpssch->id;
						$__Cnt->cnt_tel = $_telpssch->no;
					}

					if(!isN( $_GtMainCnvDt->chnl->from->nm )){
						$__Cnt->cnt_nm = $_GtMainCnvDt->chnl->from->nm;
						$__Cnt->NmAp();
					}

				}

			}

		}

		if(!isN($_cnt_key_sch)){
			$_cnt_key_nm_fx = $__Cnt->cnt_nm;
			$_cnt_key_ap_fx = $__Cnt->cnt_ap;
		}

	}

?>
<?php if($___Ls->ls->chk=='ok'){ ?>
<?php

	$___Ls->anm_no_data = 'ok';
	$___Ls->_bld_l_hdr();

	$CntWb .= "SUMR_Main.mdlcnt.tp = '".$___Ls->mdlstp->tp."'; ";

	$__grph_shw = "
		SUMR_Main.bxajx.__grph_fl = { fl:{ f:".json_encode($___Ls->c_f_g)."} };
		SUMR_Main.mdlcnt.f.grph.rqu({ t:'".$___Ls->gt->t."_grph', t3:'".$___Ls->gt->tsb_m."', sch:'".$_adsch."', vrall:'".$___Ls->ls->vrall."', gr:'".$___Ls->id_rnd."' });
	";

?>
<?php if(($___Ls->qry->tot > 0)){ ?>
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="Ls_Rg _t1">
  	<thead>
      	<tr>

        	<?php //if(ChckSESS_superadm()){ ?>
          		<th width="1%" <?php echo NWRP ?>><?php echo 'No' //TX_FM_No ?></th>
          	<?php //} ?>
            <th width="1%" <?php echo NWRP ?>><?php echo TX_FIN //TX_FM_No ?></th>
            <th width="1%" <?php echo NWRP ?>><?php echo TX_F_GST_LST ?></th>
            <th width="1%" <?php echo NWRP ?>><?php echo TX_ETD ?></th>

			<?php if($__dt_cl->mdlstp->{$__t2}->col->gst->allw == 'ok' || isN($__t2)){ ?>
			<th width="1%" <?php echo NWRP ?>><?php echo TX_GSTN ?></th>
			<?php } ?>

            <?php //if(ChckSESS_superadm()){ ?>
            <th widht="2%" <?php echo NWRP ?>><?php echo TX_TMPRM ?></th>
            <? // Aqui termina la vista solo de administrador ChckSESS_superadmin() ?>
            <?php // } ?>
            <th width="10%" <?php echo NWRP ?>><?php echo TT_FM_NM ?></th>
            <th width="20%" <?php echo NWRP ?>><?php echo $___Ls->tt; ?></th>
			<?php /* <th <?php echo NWRP ?>><?php echo MDL_PRG_GEN ?></th>*/ ?>

			<?php if($__dt_cl->mdlstp->{$__t2}->col->ints->allw == 'ok' || isN($__t2)){ ?>
			<th width="1%" <?php echo NWRP ?>><?php echo TX_CNTINTRS ?></th>
			<?php } ?>

			<?php if($__dt_cl->mdlstp->{$__t2}->col->buy->allw == 'ok' || isN($__t2)){ ?>
			<th width="1%" <?php echo NWRP ?>><?php echo TX_CNTCMPRS ?></th>
			<?php } ?>

			<?php if($__dt_cl->mdlstp->{$__t2}->col->cook->allw == 'ok' || isN($__t2)){ ?>
			<th width="1%" <?php echo NWRP ?>><?php echo TX_CNTPAGS ?></th>
			<?php } ?>

            <?php if($___Ls->gt->tsb == 'evn'){ ?>
		        <th width="1%" <?php echo NWRP ?>><?php echo 'Asistencia' ?></th>
			<?php } ?>

			<?php if($__dt_cl->mdlstp->{$__t2}->col->sac_brnd->allw == 'ok' || isN($__t2)){ ?>
		        <th width="1%" <?php echo NWRP ?>><?php echo 'Marca' ?></th>
			<?php } ?>

			<?php if($__dt_cl->mdlstp->{$__t2}->col->sac_col->allw == 'ok' || isN($__t2)){ ?>
		        <th width="1%" <?php echo NWRP ?>><?php echo 'Columna' ?></th>
			<?php } ?>

			<?php if(( $__dt_cl->mdlstp->{$__t2}->col->mdl_cnt_us->allw == 'ok' || isN($__t2) ) && _ChckMd('mdlcnt_us_vw')){ ?>
				<th width="1%" <?php echo NWRP ?>><?php echo 'Usuario' ?></th>
			<?php } ?>

			<th width="1%" <?php echo NWRP ?>>&nbsp;</th>



			<?php if(( $__dt_cl->mdlstp->{$__t2}->col->btn_gst->allw == 'ok' || isN($__t2) ) && _ChckMd($___Ls->gt->tsb.'_cnt_his_in')){ ?>

            <th width="1%" <?php echo NWRP ?>>&nbsp;</th>
            <th width="1%" <?php echo NWRP ?>>&nbsp;</th>
            <th width="1%" <?php echo NWRP ?>>&nbsp;</th>
			<?php } ?>


      	</tr>
  	</thead>
  	<tbody>
		  <?php do { ?>

		  <?php $__ls_json[] = $___Ls->ls->rw['mdlcnt_enc']; ?>
          <?php $_clr_rw = NULL; $_clr_rw = ' style="background-color:'.$___Ls->ls->rw['siscntest_clr_bck'].';" '; ?>
          <tr <?php echo $_clr_rw ?> class="<?php echo $___Ls->ls->nxt->cls; ?>" id="<?php echo $___Ls->ls->nxt->id.$___Ls->ls->rw['mdlcnt_enc'] ?>" id-enc="<?php echo $___Ls->ls->rw['mdlcnt_enc'] ?>" mdlcnt-id-no="<?php echo $___Ls->ls->rw['id_mdlcnt']; ?>">

            <?php //if(ChckSESS_superadm()){ ?>
	          		<td width="1%" <?php echo NWRP ?>><?php echo $___Ls->ls->rw['id_mdlcnt']; ?></td>
	        <?php //} ?>
            <td width="1%" <?php echo NWRP.$_clr_rw ?>><?php echo Spn(_Tme($___Ls->ls->rw['mdlcnt_fi'], 'sng')); ?></td>

			<td width="1%" <?php echo NWRP.$_clr_rw ?>><?php echo bdiv([ 'cls'=>'bx_gst' ]) ?></td>

            <td width="1%" <?php echo NWRP.$_clr_rw ?>>
	            <p class="__est_tt" style="margin: 0;">
	            <?php /*$__dtmd = GtSisMdDt([ 'id'=>$___Ls->ls->rw['mdlcnt_m'] ]);*/ echo ctjTx($___Ls->ls->rw['siscntest_tt'],'in'); ?> </p> <?php
				   echo Spn(ShortTx( ctjTx($___Ls->ls->rw['sismd_tt'],'in') ,20,'Pt', true).bdiv([ 'cls'=>'bx_md' ]),'ok','_md');
            ?></td>

			<?php if($__dt_cl->mdlstp->{$__t2}->col->gst->allw == 'ok' || isN($__t2)){ ?>
            <td width="1%" <?php echo $_clr_rw ?>><?php echo bdiv([ 'cls'=>'bx_tot_gst' ]) ?></td>
            <?php } ?>

            <td width="1%" <?php echo $_clr_rw ?>><?php echo bdiv([ 'cls'=>'bx_prm' ]) ?></td>
            <td align="left" <?php echo $_clr_rw ?>>

				<?php
					echo bdiv([ 'cls'=>'bx_cld', 'sty'=>'display:inline-block;' ]).
						 ctjTx($___Ls->ls->rw['cnt_nm'].' '.$___Ls->ls->rw['cnt_ap'],'in').
						 bdiv(['cls'=>'bx_icn', 'sty'=>'display:inline-block;']).bdiv([ 'cls'=>'bx_ps' ]). HTML_BR;

					if($___Ls->ls->rw['cnt_cd'] != '' || $___Ls->ls->rw['__dc'] != ''){
					   echo Spn(' '.ctjTx($___Ls->ls->rw['cnt_cd'],'in').(!isN($___Ls->ls->rw['__dc'])?' / '.__DcNw($___Ls->ls->rw['__dc']):'' ) , '', '_sft');
					}
				?>
            </td>
            <td align="left" <?php echo $_clr_rw ?>>
	            <?php
		        	echo ctjTx($___Ls->ls->rw['mdl_nm'],'in');
					echo Spn( ($___Ls->ls->rw['mdlcnt_m_k'] != '' ? HTML_BR.ShortTx($___Ls->ls->rw['mdlcnt_m_k'], 60, 'Pt') : false) ,'','_f');
					echo Spn( ($___Ls->ls->rw['mdlcnt_chk_chi'] == 1 ? HTML_BR.TX_CHID : false) ,'','_chi');
	            ?>
	        </td>

			<?php if($__dt_cl->mdlstp->{$__t2}->col->ints->allw == 'ok' || isN($__t2)){ ?>
				<td align="left" <?php echo $_clr_rw ?>>

					<?php echo (!isN($___Ls->ls->rw['cnt_tot_mdlcnt'])) ? '<div class="bx_tot_ints"><span class="_nmb">'.$___Ls->ls->rw['cnt_tot_mdlcnt'].'</span></div>' : ''; ?>
					<?php /*echo bdiv(['cls'=>'bx_tot_ints'])*/ ?>
				</td>
			<?php } ?>

			<?php if($__dt_cl->mdlstp->{$__t2}->col->buy->allw == 'ok' || isN($__t2)){ ?>
				<td align="left" <?php echo $_clr_rw ?>><?php echo bdiv(['cls'=>'bx_tot_cmpr']) ?></td>
			<?php } ?>

			<?php if($__dt_cl->mdlstp->{$__t2}->col->cook->allw == 'ok' || isN($__t2)){ ?>
            	<td align="left" <?php echo $_clr_rw ?>><?php echo bdiv(['cls'=>'bx_tot_ck']); ?></td>
			<?php } ?>

            <?php if($___Ls->gt->tsb == 'evn'){ ?>

		        <td align="left" <?php echo $_clr_rw ?>>
			        <?php

				        $__est = SisCntEst(['asis'=>'ok', 'id'=>$___Ls->ls->rw['mdlcnt_est']]);
				        if($__est->est == '1'){
					        $__est_c = 1;
					    }else{
						    echo OLD_HTML_chck('mdlcntest_chck'.$___Ls->ls->rw[$___Ls->ik], '', 2, 'in', ['c'=>'chck_asis', 'attr'=>['rel'=> $___Ls->ls->rw[$___Ls->ik] ]] );
						}
				       ?>

			    </td>

			    <?php
				    $CntJV .= "

						$('.chck_asis').click(function() {

					        if($(this).is(':checked')) { var est = 'ok'; } else { var est = 'no'; }

							var id_chck = $(this).attr('rel');


							swal({
								title: '".TX_ETSGR."',
								text: '".TX_SWAL_SVE."!',
								type: 'warning',
								showCancelButton: true,
								confirmButtonClass: 'btn-danger',
								confirmButtonText: '".TX_YSV."',
								confirmButtonColor: '#8fb360',
								cancelButtonText: '".TX_CNCLR."',
								closeOnConfirm: true
							},
							function(isConfirm){

								if (isConfirm) {
							    	_Rqu({
										t:'mdl_cnt_chck',
										d:'chck_asis',
										est: est,
										_id_mdl : '".Php_Ls_Cln($___Ls->gt->i)."',
										_id_chck: id_chck,
										_cl:function(_r){
											if(!isN(_r)){
												$('#rw_mdl_cnt_mod_'+id_chck+' .__est_tt').text(_r.est.est.nm);
												$('#rw_mdl_cnt_mod_'+id_chck+' td').css('background-color', _r.est.est.clr);
												$('#mdlcntest_chck'+id_chck+'_div').remove();

											}
										}
									});
							    } else {
							    	$('#mdlcntest_chck'+id_chck).attr('checked',false);
								}

							});
					    });
					";

			    ?>

	        <?php } ?>

			<?php if(( $__dt_cl->mdlstp->{$__t2}->col->sac_brnd->allw == 'ok' || isN($__t2) )){ ?>
			<td width="1%" align="left" <?php echo $_clr_rw ?> <?php echo NWRP ?>>
				<?php $_img_brnd = _ImVrs(['img'=>$___Ls->ls->rw['storebrnd_img'], 'f'=>DMN_FLE_CL_STORE_BRND ]); ?>
				<div class="brnd" style="background-image:url(<?php echo $_img_brnd->th_50; ?>);"></div>
	        	<?php echo ctjTx($___Ls->ls->rw['storebrnd_nm'],'in'); ?>
	        </td>
			<?php } ?>

			<?php if( $__dt_cl->mdlstp->{$__t2}->col->sac_col->allw == 'ok'){ ?>
			<td width="1%" align="left" <?php echo $_clr_rw ?> <?php echo NWRP ?>>
				<div class="tra_col" style="background-color:<?php echo $___Ls->ls->rw['sisslcf_vl']; ?>;background-image:url(<?php echo DMN_FLE_SIS_SLC.'slc_'.$___Ls->ls->rw['tracol_icn'].'.svg'; ?>);"></div>
	        	<?php echo ctjTx($___Ls->ls->rw['tracol_tt'],'in'); ?>
	        </td>
			<?php } ?>

			<?php if(( $__dt_cl->mdlstp->{$__t2}->col->mdl_cnt_us->allw == 'ok' || isN($__t2) ) && _ChckMd('mdlcnt_us_vw')){ ?>
			<td width="1%" align="left" <?php echo $_clr_rw ?> <?php echo NWRP ?>>
				<?php echo ctjTx($___Ls->ls->rw['us_nm'].' '.$___Ls->ls->rw['us_ap'],'in'); ?>
	        </td>
			<?php } ?>

			<?php if(!isN($__t2) && $__t2 == 'sac'){ ?>
				<td width="1%" align="left" nowrap="nowrap" <?php echo $_clr_rw ?> class="_btn">
					<?php echo HTML_Ls_Btn([ 't'=>'onl', 'rel'=>$___Ls->ls->rw['tra_enc'], 'cls'=>'shw_sac', 'l'=>Void() ]);  ?>
				</td>
			<?php }else{ ?>
				<td width="1%" align="left" <?php echo $_clr_rw ?> class="_btn"><?php echo $___Ls->_btn([ 'id'=>$___Ls->ls->rw['mdlcnt_enc'], 't'=>'mod', 'ttc'=>$__t2 ]); ?></td>
			<?php } ?>


            <?php if(( $__dt_cl->mdlstp->{$__t2}->col->btn_gst->allw == 'ok' || isN($__t2) ) && _ChckMd($___Ls->gt->tsb.'_cnt_his_in')){ ?>
            <td width="1%" align="left" <?php echo $_clr_rw ?> class="_btn">
	            <a href="javascript:_ldCnt({ u:'_cnt/_ls/_gn.php?_t=<?php echo $___Ls->mdlstp->tp ?>_his&_m=130&Pr=Ing<?php echo Fl_i($___Ls->ls->rw[$___Ls->ik]).$___Ls->ls->vrall ?>&__rnd=bcf<?php echo TXGN_POP ?>&_idtl=ok', pop:'ok', w:'<?php echo POP_HISTP_W ?>', h:'<?php echo POP_HISTP_H ?>', pf:'".$___Ls->gt->plct."' });" target="_self" style="background-image:url(<?php echo DMN_IMG_ESTR_SVG ?>cnt_his_tel.svg);"></a>
	        </td>
			<?php } ?>

	        <?php if(( $__dt_cl->mdlstp->{$__t2}->col->btn_gst->allw == 'ok' || isN($__t2) ) && _ChckMd($___Ls->gt->tsb.'_cnt_his_in')){ ?>
            <td width="1%" align="left" <?php echo $_clr_rw ?> class="_btn">
	            <a href="javascript:_ldCnt({ '_cnt/_ls/_gn.php?_t=<?php echo $___Ls->mdlstp->tp ?>_his&_m=131&Pr=Ing<?php echo Fl_i($___Ls->ls->rw[$___Ls->ik]).$___Ls->ls->vrall ?>&__rnd=bcf<?php echo TXGN_POP ?>&_idtl=ok', pop:'ok', w:'<?php echo POP_HISTP_W ?>', h:'<?php echo POP_HISTP_H ?>', pf:'".$___Ls->gt->plct."' });" target="_self" style="background-image:url(<?php echo DMN_IMG_ESTR_SVG ?>cnt_his_mail.svg);"></a>
	        </td>
			<?php } ?>

	        <?php if(( $__dt_cl->mdlstp->{$__t2}->col->btn_gst->allw == 'ok' || isN($__t2) ) && _ChckMd($___Ls->gt->tsb.'_cnt_his_in')){ ?>
				<td width="1%" align="left" <?php echo $_clr_rw ?> class="_btn">
					<a href="javascript:_ldCnt({ '_cnt/_ls/_gn.php?_t=<?php echo $___Ls->mdlstp->tp ?>_his&_m=132&Pr=Ing<?php echo Fl_i($___Ls->ls->rw[$___Ls->ik]).$___Ls->ls->vrall ?>&__rnd=bcf<?php echo TXGN_POP ?>&_idtl=ok', pop:'ok', w:'<?php echo POP_HISTP_W ?>', h:'<?php echo POP_HISTP_H ?>', pf:'".$___Ls->gt->plct."' });" target="_self" style="background-image:url(<?php echo DMN_IMG_ESTR_SVG ?>cnt_his_vst.svg);"></a>
				</td>
			<?php } ?>

          </tr>
          <?php } while ($___Ls->ls->rw = $___Ls->sql->fetch_assoc()); ?>
  </tbody>
</table>

<?php $___Ls->_bld_l_pgs(); ?>

<?php

	if(!isN($__t2) && $__t2 == 'sac'){

		$CntWb .= "

			$('.shw_sac').click(function(){
				var _enc = $(this).attr('rel');
				SUMR_Tra.bxajx.enc = _enc;
				SUMR_Tra.f.Shw({ o:'ok', oby:'"._BxRld_ID()."' });
			});

		";

	}

	$CntJV .=	"

		SUMR_Main.mdlcnt.o.ldnow = '".implode(',', $__ls_json)."';
        function __ShwDwn(){ ".PgRg($__ls, __t('dwn') )." }

	";

	$CntWb .= " setTimeout(function(){ SUMR_Main.mdlcnt.f.getext(); ".$__grph_shw." }, 1000); ";

?>
<?php } ?>
<?php $___Ls->_h_ls_nr(); ?>
<?php } ?>

<?php if($___Ls->fm->chk=='ok'){ ?>
<div class="FmTb">

	<div id="<?php echo $___Ls->fm->bx->id ?>" class="<?php echo DV_GNR_FM_BX ?>" >
		<form method="POST" name="<?php echo $___Ls->fm->id; ?>" target="_self" id="<?php echo $___Ls->fm->id; ?>">

		<?php $___Ls->_bld_f_hdr(); ?>

      	<?php if(($___Ls->dt->rw['mdlcnt_lck_us'] != SISUS_ID) && !isN($___Ls->dt->rw['mdlcnt_lck_us'])){ ?>
      		<?php $_dt_lck_us = GtUsDt($___Ls->dt->rw['mdlcnt_lck_us']); ?>
      		<h2 class="__advr"><?php echo TX_CNTGST ?> <?php echo Strn($_dt_lck_us->nm_fll) ?></h2>
      	<?php } ?>

      	<?php

	      	$__mdl_cnt_tabs = __LsDt([ 'k'=>'mdl_cnt_tabs', 'cl'=>$___Ls->cl->id ]);

			foreach($__mdl_cnt_tabs->ls->mdl_cnt_tabs as $_tab__k=>$_tab_v){
	      		$__tabs[] = ['n'=>$_tab_v->key->vl, 't'=>$_tab_v->rel->vl, 'l'=>$_tab_v->tt, 'bimg'=>$_tab_v->img];
      		}

      		$__tabs[] = ['n'=>'sis', 'l'=>TX_DTTEC];

			$_id_tbpnl = 'TabPnl_'.Gn_Rnd(20); $CntJV .= " SUMR_Main.bxajx.".$_id_tbpnl." = new Spry.Widget.TabbedPanels('".$_id_tbpnl."', {defaultTab:0}); ";
			$___Ls->_dvlsfl_all($__tabs,[ 'bsve'=>'no' ]);

			if($___Ls->dt->tot == 1){
				if($___Ls->dt->rw['mdlcnt_enc_us'] != 3){
					$__enc_us = ' - '.Spn($___Ls->dt->rw['us_nm'].' '.$___Ls->dt->rw['us_ap'],'','');
				}else{
					$__enc_us = '';
				}
            }

		?>
		<?php if(defined('DIR_IMG_WEB__BN')){ $__dt_img = BlImg(_Cns('DIR_IMG_WEB__BN').$___Ls->dt->rw['mdl_img'], '', $_fim, '../../../'); } ?>

		<!--
        <div class="imgbn_c">
			<?php echo $__dt_img->img; ?>
			<?php

				if($___Ls->dt->tot == 1){ $__btn_cln_go = '<input type="button" id="'.$__fmnm.'Cln" name="'.$__fmnm.'Cln" value="'.$__btn_cln.'" class="___cln_btn _anm" style="background-color:'.$___Ls->dt->rw['mdlstp_clr'].'">'; }

				echo h2(ctjTx($___Ls->dt->rw['mdl_nm'],'in')); ?>
        </div>-->

        <div class="ln_d_1 lead_detail dsh_cnt <?php if($___Ls->dt->tot !=1 ){ echo '_new _sch'; } ?> <?php if($___Ls->gt->pnl->e == 'ok'){ echo '__PnlDt';} ?>">

	        <div class="_c _c1">
				<div class="<?php if($___Ls->gt->pnl->e != 'ok'){ echo '_scrl'; } ?>">
					<section id="__cnt_dt" class="__cnt_dt"></section>
				</div>
	        </div>

	        <div class="_sp"></div>
	        <div class="_c _c2 ">

		        <div id="<?php echo $_id_tbpnl ?>" class="VTabbedPanels mny lead_detail_tb <?php if($___Ls->gt->pnl->e != 'ok' && $___Ls->dt->tot == 1){ echo '_scrl'; } ?>">
		          	<ul class="TabbedPanelsTabGroup">
			          	<?php echo $___Ls->tab->bsc->l; ?>
				  		<?php foreach($__mdl_cnt_tabs->ls->mdl_cnt_tabs as $_tab__k=>$_tab_v ){ ?>
				  			<?php if($_tab_v->key->vl != 'sis' && $_tab_v->key->vl != 'bsc'){ ?>
				  				<?php echo $___Ls->tab->{$_tab_v->key->vl}->l; ?>
				  			<?php } ?>
				  		<?php } ?>
				  		<?php if(ChckSESS_superadm()){ echo $___Ls->tab->sis->l; } ?>
		          	</ul>
				  	<div class="TabbedPanelsContentGroup">

					  	<div class="TabbedPanelsContent _bsc">
				            <div class="_scrl_main">
					            <?php include(DIR_EXT.'mdl_cnt_1.php'); ?>
				            </div>
			            </div>

					  	<?php foreach($__mdl_cnt_tabs->ls->mdl_cnt_tabs as $_tab__k=>$_tab_v ){ ?>
					  		<?php if($_tab_v->key->vl != 'sis' && $_tab_v->key->vl != 'bsc'){ ?>
				  			<div class="TabbedPanelsContent">
			                    <div class="ln <?php if($___Ls->gt->pnl->e != 'ok'){ echo '_scrl'; } ?>">
			                        <?php echo $___Ls->tab->{$_tab_v->key->vl}->d ?>
			                    </div>
				            </div>
				            <?php } ?>
				  		<?php } ?>


			            <?php if(ChckSESS_superadm()){ ?>
			            <div class="TabbedPanelsContent">
			             		<div class="ln_1">
									<?php if($___Ls->dt->tot == 1){ ?>
	                                    <?php


                                            $___j_dsp = json_decode($___Ls->dt->rw['mdlcnt_dsp']);

											if(count($___j_dsp) > 0){
												echo '<ul class="_sb">';
													foreach ($___j_dsp as $dsp_k => $dsp_v) { echo '<li>'.Strn($dsp_k.': ') . $dsp_v . '</li>'; }
												echo '</ul>';
											}

                                            $___j_dsp = json_decode($___Ls->dt->rw['mdlcnt_ref']);
                                            if(($___j_dsp != NULL) && count($___j_dsp) > 0){
                                                echo '<ul class="_sb">';
                                                    foreach ($___j_dsp as $dsp_k => $dsp_v) { echo '<li>'.Strn($dsp_k.': ') . $dsp_v . '</li>'; }
                                                echo '</ul>';
                                            }


	                                    ?>
		                           <?php } ?>
			                   </div>
			            </div>
			            <?php } ?>

		        	</div>

	        	</div>

	    </div>
        <div class="_c _c3 cnt_tml">
	        <?php include(DIR_EXT.'mdl_cnt_3.php'); ?>
	        <div class="grd_b"></div>
        </div>

	</div>

		<?php $_bx_wrn = __Bx_Wrn(['id'=>'_bx_nxt_tra', 't'=>TXCNF_NXTRA, 'js_ok'=>'__NxtTra_ok();']); echo $_bx_wrn->html; $CntWb .= $_bx_wrn->js; ?>
		<?php

			$CntJV .= "

				SUMR_Main.bxajx._mdl_slc_tt = $('#mdl_tt_".$___Ls->fm->id."');
                SUMR_Main.bxajx._mdl_slc_bx = $('#mdl_slct_".$___Ls->fm->id."');

				function __LdMdlCntPay(_id){
					/*
					if(!isN(_id)){ var __id = _id; }else{ var __id = '".$___Ls->dt->rw['id_mdlcnt']."'; }
					if(!isN(__id)){
						$('#__cnt_pay_dt').fadeOut().empty();
						var __u = '".Fl_Rnd(FL_DT_GN.__t('mdl_cnt_pay_lnk',true))."'+'".ADM_LNK_DT."'+ __id;
						_ldCnt({ u:__u , c:'__cnt_pay_dt', trs:false });
					}
					*/
				}

				function __NxtTra_ok(){
					"._DvLsFl([ 't'=>'s', 'i'=>$__idtp_tra ])."
					SUMR_Main.bxajx.".$_id_tbpnl.".showPanel('".TBGRP.$__idtp_tra."');
				}

				function __NxtTra(){ SUMR_Main.wrng('_pop_tra', '_bx_nxt_tra'); }

				function __NwMdlCnt(){
					".PgRg($__ls, __t($___Ls->mdlstp->tp).TXGN_ING."&__cnt=".(($___Ls->dt->rw['__cnt_dc'] !=  NULL) ? $___Ls->dt->rw['__cnt_dc'] : $___Ls->dt->rw['cnt_eml'] ) , 1)."
				}

				$('#_upd_pay').off('click').click(function(){
				    __LdMdlCntPay('".$___Ls->dt->rw['id_mdlcnt']."');
                });

                $('#{$__fmnm}Cln').off('click').click(function(){
				    __NwMdlCnt();
                });

                SUMR_Main.bxajx._mdl_slc_tt.off('click').click(function(e){
					e.preventDefault();
					if(e.target != this){
				    	e.stopPropagation(); return;
					}else{
						SUMR_Main.bxajx._mdl_slc_tt.hide();
						SUMR_Main.bxajx._mdl_slc_bx.show();
					}
				});

				$('#lnk_buy{$___Ls->id_rnd}').off('click').click(function(e){
				    e.preventDefault();
					if(e.target != this){
				    	e.stopPropagation(); return;
					}else{
						_ldCnt({
							u:'".FL_FM_GN.__t('mdl_cnt_pay_lnk', true).__t2('lnk', true)."&_i=".Fl_i($___Ls->gt->i)."',
							pop:'ok',
							pnl:{
								e:'ok',
								s:'l',
								tp:'h'
							}
						});
					}
				});

			";

			if($___Ls->dt->tot == 1){
				$CntWb .= "SUMR_Main.mdlcnt.cnt.id = '".$___Ls->dt->rw['cnt_enc']."'; ";
				$CntWb .= "SUMR_Main.mdlcnt.f.dt({ id:'".$___Ls->dt->rw['cnt_enc']."' }); __LdMdlCntPay('".$___Ls->dt->rw['id_mdlcnt']."');";
				$CntWb .= "SUMR_Main.mdlcnt.f.get.ext();";
				$CntWb .= "SUMR_Main.mdlcnt.tp = '".$__t2."'; ";
			}

			$__cnt_go = Php_Ls_Cln($_GET['__cnt']);
			if($__cnt_go != ''){ $CntWb .= "SUMR_Main.mdlcnt.f.sch_cnt({ id:'". $__cnt_go ."' });"; }

        ?>

    </form>
  </div>

</div>
<?php } ?>
<?php } ?>
<style>
	.cnt_wrap .Ls_Rg .icn_chck_1 {width: 20px;height: 20px;display: inline-block;font-size: 0;background-position: center center;vertical-align: middle;margin: 5px;background-color: white;border-radius: 50%;background-size: 70% auto;background-repeat: no-repeat;}
	.Ls_Rg span._md{ display:flex; width:100%; align-items: center; justify-content: center; }
	.Ls_Rg ._md .bx_md span img { width: 12px; height: 12px; border-radius: 10px; margin: 2px; display: inline-block; margin-left: 2px; margin-right: 2px; margin-bottom: -3px; }
</style>