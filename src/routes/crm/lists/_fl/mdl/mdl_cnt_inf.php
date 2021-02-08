<?php
if(class_exists('CRM_Cnx')){

    $___Ls->cnx->cl = 'ok';
    $___Ls->_strt();

    $___tp = Php_Ls_Cln($_GET['___tp']);
    $___all = Php_Ls_Cln($_GET['___all']);

    $_f1 = Php_Ls_Cln($_GET['fl_f_in']);
	$_f2 = Php_Ls_Cln($_GET['fl_f_out']);
	$_tp = Php_Ls_Cln($_GET['_tp']);
	$_mdl = Php_Ls_Cln($_GET['fl_f_mdl']);
	$_md = Php_Ls_Cln($_GET['fl_f_md']);
	$_are = Php_Ls_Cln($_GET['fl_f_are']);
	$_prd_a = Php_Ls_Cln($_GET['fl_f_prd_a']);
	$_prd_i = Php_Ls_Cln($_GET['fl_f_prd_i']);
	$_fnt = Php_Ls_Cln($_GET['fl_f_fnt']);
	$_mdl_s = Php_Ls_Cln($_GET['fl_f_mdl_s']);

	$__dt_1 = !isN($_f1) ? $_f1 : date('Y-m-01');
    $__dt_2 = !isN($_f2) ? $_f2 : date('Y-m-d');

    // ------ Filtros ---- //

    if( !isN($_mdl) ){$__fl .= ' AND mdl_enc  = "'.$_mdl.'" ';}

    if( !isN($_md) ){$__fl .= ' AND mdlcnt_m  = '.$_md.' ';}

    if( !isN($_are) ){
        $__fl .= '  AND mdlcnt_mdl IN ( SELECT mdlare_mdl
                            FROM '.TB_MDL_ARE.'
                                 INNER JOIN '._BdStr(DBM).TB_CL_ARE.' ON mdlare_are = id_clare
                            WHERE id_clare IN ('.$_are.') AND clare_est = 1
                    )';
    }

    if( !isN($_prd_a) ){
        $__fl .= ' AND id_mdlcnt IN ( SELECT mdlcntprd_mdlcnt
                                FROM '.TB_MDL_CNT_PRD.'
                                     INNER JOIN '._BdStr(DBM).TB_MDL_S_PRD.'  ON id_mdlsprd =  mdlcntprd_mdlsprd
                                WHERE id_mdlsprd IN ('.$_prd_a.')
                        )';
    }

    if( !isN($_prd_i) ){$__fl .= ' AND  mdlcnt_prd = '.$_prd_i.'';}

    if( !isN($_tp) ){$__fl .= ' AND mdlstp_tp = "'.$_tp.'" ';}

    if( !isN($_fnt) ){$__fl .= ' AND mdlcnt_fnt  = '.$_fnt.' ';}

    if( !isN($_mdl_s) ){$__fl .= ' AND id_mdls  = '.$_mdl_s.' ';}

    if(!isN($_f1) && !isN($_f2)){
        $__fl .= ' AND DATE_FORMAT(mdlcnt_fi, "%Y-%m-%d") BETWEEN "'.$_f1.'" AND "'.$_f2.'" ';
    }elseif(!isN($_f1)){
        $__fl .= ' AND DATE_FORMAT(mdlcnt_fi, "%Y-%m-%d")  =  "'.$_f1.'" ';
    }elseif(!isN($_f2)){
        $__fl .= ' AND DATE_FORMAT(mdlcnt_fi, "%Y-%m-%d") = "'.$_f2.'" ';
    }

    // ------ Filtros ---- //

    if($___Ls->_show_ls == 'ok'){

        if($___tp == 'md'){

            if(isN($___all)){ $__flt = " AND id_sismd = '".$__i."'";  }

            $Ls_Whr = "FROM ".TB_MDL_CNT."
                                INNER JOIN ".TB_MDL." ON mdlcnt_mdl = id_mdl
                                INNER JOIN "._BdStr(DBM).TB_MDL_S." ON mdl_mdls = id_mdls
                                INNER JOIN "._BdStr(DBM).TB_MDL_S_TP." ON mdls_tp = id_mdlstp
                                INNER JOIN ".TB_CNT." ON mdlcnt_cnt = id_cnt
                                LEFT JOIN ".TB_CNT_EML." ON cnteml_cnt = id_cnt
                                LEFT JOIN ".TB_CNT_TEL." ON cnttel_cnt = id_cnt
                                LEFT JOIN ".TB_CNT_DC." ON cntdc_cnt = id_cnt
                                INNER JOIN "._BdStr(DBM).TB_SIS_MD." ON mdlcnt_m = id_sismd

                                LEFT JOIN ".TB_CNT_PLCY." ON (cntplcy_cnt = cnteml_cnt AND cntplcy_sndi=1)
                                LEFT JOIN "._BdStr(DBM).TB_CL_PLCY." ON (cntplcy_plcy = id_clplcy AND clplcy_e=1)

                        WHERE id_mdlcnt != '' $__fl
                        AND mdl_est != '"._CId('ID_SISMDLEST_ELI')."' $__flt
                        ";

        }else if($___tp == 'est'){

            if(isN($___all)){ $__flt = " AND id_siscntest = '".$__i."'";  }

            $Ls_Whr = "FROM ".TB_MDL_CNT."
                                INNER JOIN ".TB_MDL." ON mdlcnt_mdl = id_mdl
                                INNER JOIN "._BdStr(DBM).TB_MDL_S." ON mdl_mdls = id_mdls
                                INNER JOIN "._BdStr(DBM).TB_MDL_S_TP." ON mdls_tp = id_mdlstp
                                INNER JOIN ".TB_CNT." ON mdlcnt_cnt = id_cnt
                                LEFT JOIN ".TB_CNT_EML." ON cnteml_cnt = id_cnt
                                LEFT JOIN ".TB_CNT_TEL." ON cnttel_cnt = id_cnt
                                LEFT JOIN ".TB_CNT_DC." ON cntdc_cnt = id_cnt
                                INNER JOIN "._BdStr(DBM).TB_SIS_CNT_EST." ON mdlcnt_est = id_siscntest

                                LEFT JOIN ".TB_CNT_PLCY." ON (cntplcy_cnt = cnteml_cnt AND cntplcy_sndi=1)
                                LEFT JOIN "._BdStr(DBM).TB_CL_PLCY." ON (cntplcy_plcy = id_clplcy AND clplcy_e=1)

                        WHERE id_mdlcnt != '' $__fl
                        AND mdl_est != '"._CId('ID_SISMDLEST_ELI')."' $__flt
                        ";

        }else if($___tp == 'fnt'){

            if(isN($___all)){ $__flt = " AND id_sisfnt = '".$__i."'";  }

            $Ls_Whr = "FROM ".TB_MDL_CNT."
                                INNER JOIN ".TB_MDL." ON mdlcnt_mdl = id_mdl
                                INNER JOIN "._BdStr(DBM).TB_MDL_S." ON mdl_mdls = id_mdls
                                INNER JOIN "._BdStr(DBM).TB_MDL_S_TP." ON mdls_tp = id_mdlstp
                                INNER JOIN ".TB_CNT." ON mdlcnt_cnt = id_cnt
                                LEFT JOIN ".TB_CNT_EML." ON cnteml_cnt = id_cnt
                                LEFT JOIN ".TB_CNT_TEL." ON cnttel_cnt = id_cnt
                                LEFT JOIN ".TB_CNT_DC." ON cntdc_cnt = id_cnt
                                INNER JOIN "._BdStr(DBM).TB_SIS_FNT." ON mdlcnt_fnt = id_sisfnt

                                LEFT JOIN ".TB_CNT_PLCY." ON (cntplcy_cnt = cnteml_cnt AND cntplcy_sndi=1)
                                LEFT JOIN "._BdStr(DBM).TB_CL_PLCY." ON (cntplcy_plcy = id_clplcy AND clplcy_e=1)

                        WHERE id_mdlcnt != '' $__fl
                        AND mdl_est != '"._CId('ID_SISMDLEST_ELI')."' $__flt
                        ";

        }else if($___tp == 'etp'){

            if(isN($___all)){ $__flt = " AND id_siscntesttp = '".$__i."'";  }

            $Ls_Whr = "FROM ".TB_MDL_CNT."
                                INNER JOIN ".TB_MDL." ON mdlcnt_mdl = id_mdl
                                INNER JOIN "._BdStr(DBM).TB_MDL_S." ON mdl_mdls = id_mdls
                                INNER JOIN "._BdStr(DBM).TB_MDL_S_TP." ON mdls_tp = id_mdlstp
                                INNER JOIN ".TB_CNT." ON mdlcnt_cnt = id_cnt
                                LEFT JOIN ".TB_CNT_EML." ON cnteml_cnt = id_cnt
                                LEFT JOIN ".TB_CNT_TEL." ON cnttel_cnt = id_cnt
                                LEFT JOIN ".TB_CNT_DC." ON cntdc_cnt = id_cnt
                                INNER JOIN "._BdStr(DBM).TB_SIS_CNT_EST." ON mdlcnt_est = id_siscntest
                                INNER JOIN "._BdStr(DBM).TB_SIS_CNT_EST_TP." ON siscntest_tp = id_siscntesttp
                                LEFT JOIN ".TB_CNT_PLCY." ON (cntplcy_cnt = cnteml_cnt AND cntplcy_sndi=1)
						        LEFT JOIN "._BdStr(DBM).TB_CL_PLCY." ON (cntplcy_plcy = id_clplcy AND clplcy_e=1)

                        WHERE id_mdlcnt != '' $__fl
                        AND mdl_est != '"._CId('ID_SISMDLEST_ELI')."' $__flt
                        ";

        }


        $___Ls->qrys = "SELECT DISTINCT id_mdlcnt, mdlcnt_fi, cnt_nm, cnt_ap , mdl_nm, cnteml_eml, cnttel_tel, cntdc_dc, cntplcy_sndi, (SELECT COUNT(DISTINCT id_mdlcnt) $Ls_Whr) AS __rgtot $_fl $Ls_Whr GROUP BY id_mdlcnt ORDER BY mdlcnt_fi DESC, mdlcnt_fa DESC";

    }

    $___Ls->_bld();
    echo $___Ls->qry->tot;
    ?>
    <?php if($___Ls->ls->chk=='ok'){ ?>
        <?php if(($___Ls->qry->tot > 0)){ ?>
            <table width="100%" border="0" cellpadding="0" cellspacing="0" class="Ls_Rg">
                <thead>
                    <tr>
                        <th width="1%" <?php echo NWRP ?>><?php echo TX_FIN ?></th>
                        <th width="24%" <?php echo NWRP ?>><?php echo TX_TEL ?></th>
                        <th width="25%" <?php echo NWRP ?>><?php echo TX_EML ?></th>
                        <th width="25%" <?php echo NWRP ?>><?php echo TX_MDL; ?></th>
                        <th width="25%" <?php echo NWRP ?>><?php echo TT_FM_NM ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php

                        do {

                            $__eml_nrml = 	_plcy_scre([
                                't'=>'eml',
                                'v'=>$___Ls->ls->rw['cnteml_eml'],
                                'plcy'=>[ 'e'=>$___Ls->ls->rw['cntplcy_sndi'] ]
							]);

							$__fnm_nrml = 	_plcy_scre([
								't'=>'nm',
								'nm'=>$___Ls->ls->rw['cnt_nm'],
								'ap'=>$___Ls->ls->rw['cnt_ap'],
								'plcy'=>[ 'e'=>$___Ls->ls->rw['cntplcy_sndi'] ]
							]);


                    ?>
                        <tr class="<?php echo $__cls_del; ?>">
                            <td width="1%" <?php echo NWRP.$_clr_rw ?>><?php echo Spn(_DteHTML(['d'=>$___Ls->ls->rw['mdlcnt_fi'], 'nd'=>'ok', 'br'=>'ok' ]), '', '_f'); ?></td>
                            <td width="24%" <?php echo NWRP.$_clr_rw ?> style="text-align: center; ">
                                <?php echo ctjTx($___Ls->ls->rw['cnttel_tel'],'in'); ?>
                            </td>
                            <td width="25%" align="center" <?php echo $_clr_rw ?>>
                                <?php echo $__eml_nrml; ?>
                            </td>
                            <td width="25%" align="center" <?php echo $_clr_rw ?>>
                                <?php echo ctjTx($___Ls->ls->rw['mdl_nm'],'in'); ?>
                            </td>
                            <td width="25%" align="center" <?php echo $_clr_rw ?>>
                                <?php echo $__fnm_nrml['first']; if(!isN($__fnm_nrml['last'])){ echo ' '.$__fnm_nrml['last']; } echo HTML_BR; ?>
                                <?php echo Spn(ctjTx($___Ls->ls->rw['cntdc_dc'],'in')); ?>
                            </td>
                        </tr>
                    <?php } while ($___Ls->ls->rw = $___Ls->sql->fetch_assoc()); ?>
                </tbody>
            </table>
            <?php $___Ls->_bld_l_pgs(); ?>
        <?php } ?>
        <?php $___Ls->_h_ls_nr(); ?>
    <?php } ?>
<?php } ?>