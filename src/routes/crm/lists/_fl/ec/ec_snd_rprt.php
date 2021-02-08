<?php 
if(class_exists('CRM_Cnx')){

    $___Ls->cnx->cl = 'ok';
    $___Ls->_strt();

    $_g_tot_tp = Php_Ls_Cln($_GET['_g_tot_tp']);

    if($___Ls->_show_ls == 'ok'){
        
        if($_g_tot_tp == 'g_tot_snd'){

            $Ls_Whr = "FROM ".$_bd.TB_EC_SND_CMPG."
                        INNER JOIN ".TB_EC_SND." ON ecsndcmpg_snd = id_ecsnd
                        INNER JOIN ".TB_CNT." ON ecsnd_cnt = id_cnt
                        INNER JOIN ".TB_CNT_PLCY." ON cntplcy_cnt = id_cnt
                        INNER JOIN ".TB_CNT_EML." ON cnteml_cnt = id_cnt
                    WHERE ecsnd_test = 2 AND ecsnd_eml = cnteml_eml AND
                        ecsndcmpg_cmpg IN ( SELECT id_eccmpg 
                                                FROM "._BdStr(DBM).TB_EC_CMPG."
                                            WHERE eccmpg_enc = '".$__i."') 
                        ORDER BY id_ecsndcmpg ASC";

        }else if($_g_tot_tp == 'g_tot_op'){
            
            $Ls_Whr = "FROM ".TB_EC_SND_CMPG."
                                INNER JOIN ".TB_EC_SND." ON ecsndcmpg_snd = id_ecsnd
                                INNER JOIN ".TB_CNT." ON ecsnd_cnt = id_cnt
                                INNER JOIN ".TB_CNT_PLCY." ON cntplcy_cnt = id_cnt
                                INNER JOIN ".TB_CNT_EML." ON cnteml_cnt = id_cnt
                        WHERE ecsndcmpg_cmpg IN ( SELECT id_eccmpg 
                                                        FROM "._BdStr(DBM).TB_EC_CMPG."
                                                    WHERE eccmpg_enc = '".$__i."') 
                                    AND ecsnd_eml = cnteml_eml
                                    AND EXISTS ( SELECT id_ecop FROM ".TB_EC_OP." WHERE ecop_snd = id_ecsnd )
                                    AND cntplcy_sndi = 1 

                        "; 
            $__fl = 'GROUP BY id_ecsnd DESC';

        }else if($_g_tot_tp == 'g_tot_trck'){
            
            $Ls_Whr = "FROM ".TB_EC_SND_CMPG."
                                INNER JOIN ".TB_EC_SND." ON ecsndcmpg_snd = id_ecsnd
                                INNER JOIN ".TB_CNT." ON ecsnd_cnt = id_cnt
                                INNER JOIN ".TB_CNT_PLCY." ON cntplcy_cnt = id_cnt
                                INNER JOIN ".TB_CNT_EML." ON cnteml_cnt = id_cnt
                        WHERE ecsndcmpg_cmpg IN ( SELECT id_eccmpg 
                                                        FROM "._BdStr(DBM).TB_EC_CMPG."
                                                    WHERE eccmpg_enc = '".$__i."') 
                                    AND ecsnd_eml = cnteml_eml
                                    AND EXISTS ( SELECT id_ectrck FROM ".TB_EC_TRCK." WHERE ectrck_snd = id_ecsnd )

                        "; 
            $__fl = 'GROUP BY id_ecsnd DESC';

        }else if($_g_tot_tp == 'g_tot_err'){

            $Ls_Whr = "FROM ".$_bd.TB_EC_SND_CMPG."
                        INNER JOIN ".TB_EC_SND." ON ecsndcmpg_snd = id_ecsnd
                        INNER JOIN ".TB_CNT." ON ecsnd_cnt = id_cnt
                        INNER JOIN ".TB_CNT_PLCY." ON cntplcy_cnt = id_cnt
                        INNER JOIN ".TB_CNT_EML." ON cnteml_cnt = id_cnt
                    WHERE ecsnd_test = 2 AND ecsnd_eml = cnteml_eml
                    AND (ecsnd_bnc_tp = '"._CId('ID_SISSNDBNCTP_PRMN')."') 
                    AND (ecsnd_bnc_tp_sub = '"._CId('ID_SISSNDBNCTPS_GEN')."' || ecsnd_bnc_tp_sub = '"._CId('ID_SISSNDBNCTPS_NOEML')."')
                    AND ecsndcmpg_cmpg IN ( SELECT id_eccmpg 
                                                FROM "._BdStr(DBM).TB_EC_CMPG."
                                            WHERE eccmpg_enc = '".$__i."') 
                        ORDER BY id_ecsndcmpg ASC";

        }else if($_g_tot_tp == 'g_tot_prc'){

            $Ls_Whr = " FROM ".$_bd.TB_EC_SND_CMPG."
                            INNER JOIN ".TB_EC_SND." ON ecsndcmpg_snd = id_ecsnd
                            INNER JOIN ".TB_CNT." ON ecsnd_cnt = id_cnt
                            INNER JOIN ".TB_CNT_PLCY." ON cntplcy_cnt = id_cnt
                            INNER JOIN ".TB_CNT_EML." ON cnteml_cnt = id_cnt
                        WHERE ecsnd_test = 2 AND 
                              ecsnd_eml = cnteml_eml AND
                              ecsndcmpg_cmpg IN ( SELECT id_eccmpg FROM "._BdStr(DBM).TB_EC_CMPG." WHERE eccmpg_enc = '".$__i."') AND
                              ecsnd_est = '"._CId('ID_SNDEST_PRG')."' 
                        ORDER BY id_ecsndcmpg ASC";

        }

        if(!isN($Ls_Whr)){
            $___Ls->qrys = "SELECT id_ecsnd, ecsnd_fi, id_ecsndcmpg, cnteml_cld, cntplcy_sndi, ecsnd_eml, cnt_nm, cnt_ap , (SELECT COUNT(*) $Ls_Whr) AS __rgtot $_fl $Ls_Whr $__fl";
        }
    }
    
    if(!isN($___Ls->qrys)){ $___Ls->_bld(); }

    ?>
    <?php if($___Ls->ls->chk=='ok'){ ?>
        <?php if(($___Ls->qry->tot > 0)){ ?>
            <table width="100%" border="0" cellpadding="0" cellspacing="0" class="Ls_Rg">
                <thead>
                    <tr>
                        <?php if(ChckSESS_superadm()){ ?><th width="1%" <?php echo NWRP ?>><?php echo TX_FM_No ?></th><?php } ?>
                        <th width="1%" <?php echo NWRP ?>><?php echo TX_FIN //TX_FM_No ?></th>
                        <th width="1%" <?php echo NWRP ?>>&nbsp;</th>
                        <th width="1%" <?php echo NWRP ?>><?php echo TX_CNTSNDI; ?></th>               
                        <th width="1%" <?php echo NWRP ?>><?php echo TX_EML ?></th>
                        <th width="25%" <?php echo NWRP ?>><?php echo TT_FM_NM ?></th>
                    </tr> 
                </thead>
                <tbody>
                    <?php do { ?>
                        <tr class="<?php echo $__cls_del; ?>">
                            <?php if(ChckSESS_superadm()){ ?>
                            <td width="1%" <?php echo NWRP.$_clr_rw ?>><?php echo Spn($___Ls->ls->rw['id_ecsnd'], '', '_f'); ?></td>
                            <?php } ?>
                            <td width="1%" <?php echo NWRP.$_clr_rw ?>><?php echo Spn(_DteHTML(['d'=>$___Ls->ls->rw['ecsnd_fi'], 'nd'=>'ok', 'br'=>'ok' ]), '', '_f'); ?></td>
                            <td width="1%" <?php echo NWRP.$_clr_rw ?> style="text-align: center; ">	
                                <?php 
                                    $__sis_cld = LsSis_Cld([ 'id'=>'St_'.$___Ls->ls->rw['id_ecsndcmpg'], 'v'=>'id', 'va'=>$___Ls->ls->rw['cnteml_cld'], 'rq'=>2, 'dsbl'=>'ok' ]); 

                                    $CntWb .= JQ_Ls('St_'.$___Ls->ls->rw['id_ecsndcmpg'],FM_LS_CLD); 
                                    echo $__sis_cld->html; $CntWb .= $__sis_cld->js;
                                ?>    
                            </td>
                            <td width="1%" align="center" <?php echo $_clr_rw ?>>
                                <?php echo mBln($___Ls->ls->rw['cntplcy_sndi'],'in'); ?> 
                            </td> 
                            <td width="25%" align="center" <?php echo $_clr_rw ?>>
                                <?php echo ctjTx($___Ls->ls->rw['ecsnd_eml'],'in'); ?>
                            </td> 
                            <td width="25%" align="center" <?php echo $_clr_rw ?>>
                                <?php echo ctjTx($___Ls->ls->rw['cnt_nm'].' '.$___Ls->ls->rw['cnt_ap'],'in'); ?>
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