<?php


    //-------------- GET PARAMETERS --------------//

        $_t2 = Php_Ls_Cln($_GET['_t2']);
        $_tp = Php_Ls_Cln($_GET['_tp']);
        $_gr = Php_Ls_Cln($_GET['_g_r']);

    //-------------- OBTIENE FILTRO --------------//

        $__flt_dt = $___Ls->_f_chk([ 't'=>'mdl_cnt', 't2'=>$_t2 ]);
        $__f_g = $__flt_dt->f;
        if(!isN($__f_g)){ $___Ls->c_f_g = $__f_g; }

    //-------------- LETS PROCESS --------------//

    $___Ls->gt->t = 'mdl_cnt';
	$___Ls->sch->f = 'id_mdlcnt, id_cnt, mdlcnt_m, mdlcnt_dsp, mdlcnt_ref, cnt_nm, cnt_ap, mdlcnt_est, mdlcnt_mdl';

	$___Ls->sch->m = ' || (
		EXISTS (SELECT cnteml_cnt FROM '.TB_CNT_EML.' WHERE cnteml_cnt = id_cnt AND cnteml_eml LIKE \'%[-SCH-]%\' )  ||
		EXISTS (SELECT cntdc_cnt FROM '.TB_CNT_DC.' WHERE cntdc_cnt = id_cnt AND cntdc_dc LIKE \'%[-SCH-]%\' ) ||
		EXISTS (SELECT cnttel_cnt FROM '.TB_CNT_TEL.' WHERE cnttel_cnt = id_cnt AND cnttel_tel LIKE \'%[-SCH-]%\' )
	)';

	$___Ls->_strt();

	if( !isN($_t2) ){

        //$rsp['tmppppp']['fl'][] = $___Ls->_fl;
        //$rsp['tmppppp']['fl'][] = $___Ls->sch->cod;

		//-------------- FILTERS OUT  --------------//

			if(!isN($___Ls->_fl->f1) && !isN($___Ls->_fl->f2)){
				$___Ls->qry_f .= ' AND DATE_FORMAT(mdlcnt_fi, "%Y-%m-%d") BETWEEN "'.$___Ls->_fl->f1.'" AND "'.$___Ls->_fl->f2.'" ';
			}elseif(!isN($___Ls->_fl->f1)){
				$___Ls->qry_f .= ' AND DATE_FORMAT(mdlcnt_fi, "%Y-%m-%d")  = "'.$___Ls->_fl->f1.'" ';
			}elseif(!isN($___Ls->_fl->f2)){
				$___Ls->qry_f .= ' AND DATE_FORMAT(mdlcnt_fi, "%Y-%m-%d")  = "'.$___Ls->_fl->f2.'" ';
			}

			//$___Ls->qry_f .= " AND mdlst.mdlstp_tp = '".$___Ls->gt->tsb."' ";
			if(!isN($___Ls->gt->tsb_m)){ $___Ls->qry_f .= " AND mdlt.mdlstp_tp = '".$___Ls->gt->tsb_m."' "; }


			if(!isN($___Ls->_fl->org)){
				$__all_org = implode(',', $___Ls->_fl->org);
				$___Ls->qry_f .= ' AND EXISTS ( SELECT *
											FROM '.TB_ORG_SDS_CNT.'
												 INNER JOIN '._BdStr(DBM).TB_ORG_SDS.' ON orgsdscnt_orgsds = id_orgsds
												 INNER JOIN '._BdStr(DBM).TB_ORG.' ON orgsds_org = id_org
											WHERE orgsdscnt_cnt = mdlcnt_cnt AND org_enc IN ('.$__all_org.')
										) ';
			}


			if(!isN($___Ls->_fl->fk->id_clare)){

				if(is_array($___Ls->_fl->fk->id_clare)){
                    $__all_are = implode(',', $___Ls->_fl->fk->id_clare);
                }else{
                    $__all_are = "'".$___Ls->_fl->fk->id_clare."'";
                }

				$___Ls->qry_f .= ' AND EXISTS ( SELECT *
											FROM '.TB_MDL_ARE.'
												 INNER JOIN '._BdStr(DBM).TB_CL_ARE.' ON mdlare_are = id_clare
											WHERE mdlare_mdl = mdlcnt_mdl AND id_clare IN ('.$__all_are.') AND clare_est = 1
										) ';
			}

			if(!isN($___Ls->_fl->fk->mdlcnt_prd_wnt)){

				$__all_prd_w = implode(',', $___Ls->_fl->fk->mdlcnt_prd_wnt);

				$___Ls->qry_f .= ' AND EXISTS ( SELECT *
											FROM '.TB_MDL_CNT_PRD.'
												 INNER JOIN '._BdStr(DBM).TB_MDL_S_PRD.' ON mdlcntprd_mdlsprd = id_mdlsprd
											WHERE mdlcntprd_mdlcnt = id_mdlcnt AND  mdlsprd_enc IN ('.$__all_prd_w.')
										) ';

			}



			if(!ChckSESS_superadm()){
				if(defined('SISUS_ARE') && !isN(SISUS_ARE)){

					$fl_are = ' EXISTS (	SELECT *
											FROM '.TB_MDL_ARE.'
											WHERE mdlare_mdl = id_mdl AND mdlare_are IN ('.SISUS_ARE.')
										) ';
				}

				if(defined('SISUS_MDL_N') && !isN(SISUS_MDL_N)){

					if(!isN($fl_are)){ $fl_mdl = ' || '; }

					$fl_mdl .= ' (	 EXISTS (	SELECT *
												FROM '.TB_MDL_US.'
												WHERE mdlus_mdl = id_mdl AND mdlus_mdl IN ('.SISUS_MDL_N.') )
											) ';
				}

				if(!isN($fl_mdl) || !isN($fl_are)){ $___Ls->qry_f .= ' AND ( '.$fl_are.$fl_mdl.' ) ';  }

				$fl_mdl .= " AND mdl_est != '"._CId('ID_SISMDLEST_ELI')."' ";
			}



		//-------------- START QUERYS AND BUILDERS  --------------//


            $__id_prfx = '_'.Gn_Rnd(20);


            //--------------------- Daily ---------------------//

                $__dt_1 = !isN($___Ls->_fl->f1) ? $___Ls->_fl->f1 : date('Y-m-01');
                $__dt_2 = !isN($___Ls->_fl->f2) ? $___Ls->_fl->f2 : date('Y-m-d');

                if(isN($___Ls->_fl->f1) && isN($___Ls->_fl->f2)){
                    $___Ls->qry_f .= ' AND DATE_FORMAT(mdlcnt_fi, "%Y-%m-%d") BETWEEN "'.$__dt_1.'" AND "'.$__dt_2.'" ';
                }

                $Qry = "    SELECT COUNT(DISTINCT id_mdlcnt) AS _tot, DATE_FORMAT(mdlcnt_fi, '%Y-%m-%d') as _f_i
                            FROM ".VW_MDL_CNT."
                                LEFT JOIN "._BdStr(DBM).TB_MDL_S_TP." AS mdlt ON mdl_mdlstp = mdlt.id_mdlstp
                            WHERE ".VW_MDL_CNT.".mdlstp_tp = '".$_t2."' ".$___Ls->qry_f." ".$___Ls->sch->cod."
                            GROUP BY _f_i
                            ORDER BY id_mdlcnt DESC, mdlcnt_fa DESC
                        ";
                //$rsp['q'][] = compress_code($Qry);

                $Rg = $__cnx->_qry($Qry);

                if($Rg){

                    $rw = $Rg->fetch_assoc();
                    $tot = $Rg->num_rows;

                    if($tot > 0){
                        do {
                            $_a_day[] = $rw;
                        } while ($rw = $Rg->fetch_assoc());
                    }

                }else{

                    $rsp['w'][] = $__cnx->c_r->error;

                }


            //--------------------- Medium ---------------------//

                $Qry = " SELECT sismd_tt,
                                COUNT(*) AS __tot_m
                                FROM ".VW_MDL_CNT."
                                     LEFT JOIN "._BdStr(DBM).TB_MDL_S_TP." AS mdlt ON mdl_mdlstp = mdlt.id_mdlstp
                                WHERE ".VW_MDL_CNT.".mdlstp_tp = '".$_t2."' ".$___Ls->qry_f." ".$___Ls->sch->cod."
                                GROUP BY mdlcnt_m
                                ORDER BY id_mdlcnt DESC, mdlcnt_fa DESC
                            ";

                $Rg = $__cnx->_qry($Qry);

                if($Rg){
                    $rw = $Rg->fetch_assoc();
                    $tot = $Rg->num_rows;
                    if($tot > 0){
                        do {
                            $_a_md[] = $rw;
                        } while ($rw = $Rg->fetch_assoc());
                    }
                }else{
                    $rsp['w'][] = $__cnx->c_r->error;
                }

		    //--------------------- Module ---------------------//

                $Qry = " SELECT mdl_nm,
                                COUNT(*) AS __tot_mdl
                                FROM ".VW_MDL_CNT."
                                    LEFT JOIN "._BdStr(DBM).TB_MDL_S_TP." AS mdlt ON mdl_mdlstp = mdlt.id_mdlstp
                                WHERE ".VW_MDL_CNT.".mdlstp_tp = '".$_t2."' ".$___Ls->qry_f." ".$___Ls->sch->cod."
                                AND mdl_est != '"._CId('ID_SISMDLEST_ELI')."'
                                GROUP BY mdlcnt_mdl
                                ORDER BY id_mdlcnt DESC, mdlcnt_fa DESC
                            ";

                $Rg = $__cnx->_qry($Qry);

                if($Rg){
                    $rw = $Rg->fetch_assoc();
                    $tot = $Rg->num_rows;
                    if($tot > 0){
                        do {
                            $_a_mdl[] = $rw;
                        } while ($rw = $Rg->fetch_assoc());
                    }
                }

            //--------------------- Funnel ---------------------//

                $Qry = "    SELECT siscntesttp_tt, siscntesttp_clr_bck, COUNT(*) AS __tot_fnl
                            FROM ".VW_MDL_CNT."
                                 LEFT JOIN "._BdStr(DBM).TB_MDL_S_TP." AS mdlt ON mdl_mdlstp = mdlt.id_mdlstp
                            WHERE ".VW_MDL_CNT.".mdlstp_tp = '".$_t2."' ".$___Ls->qry_f." ".$___Ls->sch->cod."
                            GROUP BY siscntest_tp
                            ORDER BY siscntesttp_ord ASC
                        ";

                $Rg = $__cnx->_qry($Qry);

                if($Rg){
                    $rw = $Rg->fetch_assoc();
                    $tot = $Rg->num_rows;
                    if($tot > 0){
                        do {
                            $_a_fnl[] = $rw;
                        } while ($rw = $Rg->fetch_assoc());
                    }

                }

		    //--------------------- Keywords ---------------------//

                $Qry = " SELECT mdlcnt_m_k,
                                COUNT(*) AS __tot_kyw
                                FROM ".VW_MDL_CNT."
                                    LEFT JOIN "._BdStr(DBM).TB_MDL_S_TP." AS mdlt ON mdl_mdlstp = mdlt.id_mdlstp
                                WHERE ".VW_MDL_CNT.".mdlstp_tp = '".$_t2."' ".$___Ls->qry_f." ".$___Ls->sch->cod."
                                AND mdlcnt_m_k IS NOT NULL
                                GROUP BY mdlcnt_m_k
                                ORDER BY id_mdlcnt DESC, mdlcnt_fa DESC
                            ";

                $Rg = $__cnx->_qry($Qry);
                if($Rg){
                    $rw = $Rg->fetch_assoc();
                    $tot = $Rg->num_rows;
                    if($tot > 0){
                        do {
                            $_a_kyw[] = $rw;
                        } while ($rw = $Rg->fetch_assoc());
                    }
                }


            //--------------------- Source ---------------------//

                $Qry = " SELECT sisfnt_nm,
                                COUNT(*) AS __tot_fnt
                                FROM ".VW_MDL_CNT."
                                    LEFT JOIN "._BdStr(DBM).TB_MDL_S_TP." AS mdlt ON mdl_mdlstp = mdlt.id_mdlstp
                                WHERE ".VW_MDL_CNT.".mdlstp_tp = '".$_t2."' ".$___Ls->qry_f." ".$___Ls->sch->cod."
                                GROUP BY mdlcnt_fnt
                                ORDER BY id_mdlcnt DESC, mdlcnt_fa DESC
                            ";

                $Rg = $__cnx->_qry($Qry);

                if($Rg){
                    $rw = $Rg->fetch_assoc();
                    $tot = $Rg->num_rows;
                    if($tot > 0){
                        do {
                            $_a_fnt[] = $rw;
                        } while ($rw = $Rg->fetch_assoc());
                    }
                }


            //--------------------- Organization ---------------------//

                $Qry = " SELECT org_nm,
                                COUNT(*) AS __tot_org
                                FROM ".TB_MDL_CNT."
                                    INNER JOIN "._BdStr(DBM).TB_ORG." ON mdlcnt_noi_otc = id_org
                                WHERE id_org != 19
                                GROUP BY mdlcnt_noi_otc
                                ORDER BY id_mdlcnt DESC, mdlcnt_fa DESC
                            ";

                $Rg = $__cnx->_qry($Qry);

                if($Rg){
                    $rw = $Rg->fetch_assoc();
                    $tot = $Rg->num_rows;
                    if($tot > 0){
                        do {
                            $_a_org[] = $rw;
                        } while ($rw = $Rg->fetch_assoc());
                    }
                }

            //--------------------- Period ---------------------//

                $Qry = " SELECT mdlsprd_nm,
                                COUNT(*) AS __tot_prd
                                FROM
                                    "._BdStr(DBM).TB_MDL_S_PRD."
                                    INNER JOIN ".TB_MDL_CNT_PRD." ON mdlcntprd_mdlsprd = id_mdlsprd
                                    INNER JOIN ".TB_MDL_CNT." ON mdlcntprd_mdlcnt = id_mdlcnt
                                    INNER JOIN ".TB_MDL." ON mdlcnt_mdl = id_mdl
                                    INNER JOIN "._BdStr(DBM).TB_MDL_S." ON mdl_mdls = id_mdls
                                    INNER JOIN "._BdStr(DBM).TB_MDL_S_TP." ON mdls_tp = id_mdlstp
                                WHERE mdlsprd_cl = ".DB_CL_ID." AND
                                    mdlsprd_est = 1 AND
                                    mdlstp_tp = '".$_t2."' ".$___Ls->qry_f."
                                GROUP BY id_mdlsprd";

                $Rg = $__cnx->_qry($Qry);

                if($Rg){
                    $rw = $Rg->fetch_assoc();
                    $tot = $Rg->num_rows;
                    if($tot > 0){
                        do {
                            $_a_prd[] = $rw;
                        } while ($rw = $Rg->fetch_assoc());
                    }
                }

        //--------------------- Post Data Process ---------------------//


            $__cnx->_clsr($Rg);


            //--------------------- Daily ---------------------//

                foreach($_a_day as $_a_day_k=>$_a_day_v){
                    $_a_day_vl['ctg'][$_a_day_v['_f_i']] = $_a_day_v['_f_i'];
                    $_a_day_vl['d'][$_a_day_v['_f_i']]['tot'] = $_a_day_v['_tot'];
                }

                $_a_day_grph = _jEnc($_a_day_vl);

                for($i=$__dt_1;$i<=$__dt_2;$i = date("Y-m-d", strtotime($i ."+ 1 days"))){
                    $_a_day_grph_c[] = $i;
                    $_a_day_grph_d[] = (int)(!isN($_a_day_grph->d->{$i}->tot)?$_a_day_grph->d->{$i}->tot:'0');
                }

                $rsp['data']['day'] = [
                    'c'=>$_a_day_grph_c,
                    'd'=>[
                        [
                            'name'=>'Total',
                            'data'=>$_a_day_grph_d
                        ]
                    ]
                ];


            //--------------------- Medium ---------------------//

                foreach($_a_md as $_a_md_k=>$_a_md_v){
                    if($_a_md_v['__tot_m'] < 1){ $_prnt = 0; }else{ $_prnt = $_a_md_v['__tot_m']; }
                    $rsp['data']['md']['d'][] = [
                            'name'=>ctjTx(str_replace("'", "",$_a_md_v['sismd_tt']),'in'),
                            'data'=>[
                                (int)$_prnt
                            ]
                    ];
                }

            //--------------------- Module ---------------------//

                foreach($_a_mdl as $_a_mdl_k=>$_a_mdl_v){
                    if($_a_mdl_v['__tot_mdl'] < 1){ $_prnt = 0; }else{ $_prnt = $_a_mdl_v['__tot_mdl']; }
                    $rsp['data']['mdl']['d'][] = [
                            'name'=>ctjTx(str_replace("'", "",$_a_mdl_v['mdl_nm']),'in'),
                            'data'=>[
                                (int)$_prnt
                            ]
                    ];
                }

            //--------------------- Funnel ---------------------//

                $_sum_tot = 0;

                foreach($_a_fnl as $_a_fnl_k=>$_a_fnl_v){
                    if($_a_fnl_v['__tot_fnl'] < 1){ $_prnt = 0; }else{ $_prnt = $_a_fnl_v['__tot_fnl']; }
                    if(!isN($_a_fnl_v['siscntesttp_clr_bck']) ){ $_clr = $_a_fnl_v['siscntesttp_clr_bck']; }else{ $_clr=''; }
                    $_sum_tot = ($_sum_tot+$_prnt);

                    $rsp['data']['fnl']['d'][] = [
                            'name'=>ctjTx(str_replace("'", "",$_a_fnl_v['siscntesttp_tt']),'in'),
                            'y_lbl'=>(int)$_prnt,
                            'y'=>1,
                            'color'=>$rw['siscntesttp_clr_bck'],
                            'className'=>$__cls
                    ];

                }

                $rsp['data']['fnl']['tot'] = $_sum_tot;

            //--------------------- Keywords ---------------------//

                foreach($_a_kyw as $_a_kyw_k=>$_a_kyw_v){
                    if($_a_kyw_v['__tot_kyw'] < 1){ $_prnt = 0; }else{ $_prnt = $_a_fnt_v['__tot_kyw']; }
                    $rsp['data']['kyw']['d'][] = [
                            'name'=>ctjTx(str_replace("'", "",$_a_kyw_v['mdlcnt_m_k']),'in'),
                            'data'=>[
                                (int)$_prnt
                            ]
                    ];
                }

            //--------------------- Source ---------------------//

                foreach($_a_fnt as $_a_fnt_k=>$_a_fnt_v){
                    if($_a_fnt_v['__tot_fnt'] < 1){ $_prnt = 0; }else{ $_prnt = $_a_fnt_v['__tot_fnt']; }
                    $rsp['data']['fnt']['d'][] = [
                            'name'=>ctjTx(str_replace("'", "",$_a_fnt_v['sisfnt_nm']),'in'),
                            'data'=>[
                                (int)$_prnt
                            ]
                    ];
                }

            //--------------------- Organization ---------------------//

                foreach($_a_org as $_a_org_k=>$_a_org_v){
                    if($_a_org_v['__tot_org'] < 1){ $_prnt = 0; }else{ $_prnt = $_a_fnt_v['__tot_org']; }
                    $rsp['data']['org']['d'][] = [
                            'name'=>ctjTx(str_replace("'", "",$_a_org_v['org_nm']),'in'),
                            'data'=>[
                                (int)$_prnt
                            ]
                    ];
                }


            //--------------------- Period ---------------------//


             if($rw['__tot_mdl'] < 1){ $_prnt = 0; }else{ $_prnt = $rw['__tot_mdl']; }

                $_sum_tot = 0;

                foreach($_a_prd as $_a_prd_k=>$_a_prd_v){
                    if($_a_prd_v['__tot_prd'] < 1){ $_prnt = 0; }else{ $_prnt = $_a_prd_v['__tot_prd']; }
                    if(!isN($_a_fnl_v['siscntesttp_clr_bck']) ){ $_clr = $_a_prd_v['siscntesttp_clr_bck']; }else{ $_clr=''; }
                    $_sum_tot = ($_sum_tot+$_prnt);

                    $rsp['data']['prd']['d'][] = [
                            'name'=>ctjTx(str_replace("'", "",$_a_prd_v['mdlsprd_nm']),'in'),
                            'y_lbl'=>(int)$_prnt,
                            'y'=>1
                    ];

                }

                $rsp['data']['prd']['tot'] = $_sum_tot;



	}

?>