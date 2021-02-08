<?php
if(class_exists('CRM_Cnx')){

    $___Ls->cnx->cl = 'ok';
    $___Ls->tt = 'Listas y Segmentos';
    $___Ls->_strt();
    $___Ls->ino = "id_cnteml";
    $___Ls->ik = "cnteml_enc";

    if(!isN($___Ls->gt->i)){	

        $___Ls->qrys = sprintf("SELECT *
                                FROM ".TB_EC_LSTS_EML_SGM."
                                    INNER JOIN ".TB_CNT_EML." ON eclstsemlsgm_eml = id_cnteml
                                WHERE ".$___Ls->ik." = %s
                                    LIMIT 1" , GtSQLVlStr($___Ls->gt->i, "text"));
                
    }elseif($___Ls->_show_ls == 'ok'){

        $Ls_Whr = "	FROM ".TB_EC_LSTS_EML_SGM."
                        INNER JOIN ".TB_CNT_EML." ON eclstsemlsgm_eml = id_cnteml
                        INNER JOIN "._BdStr(DBM).TB_EC_LSTS_SGM." ON eclstsemlsgm_lstssgm = id_eclstssgm
                    WHERE ".$___Ls->ino." != ''  AND cnteml_enc = '".$__i."'
                        ORDER BY ".$___Ls->ino." DESC";

        $___Ls->qrys = "SELECT *, (SELECT COUNT(*) $Ls_Whr) AS ".QRY_RGTOT." $Ls_Whr";

    }  

    $___Ls->_bld();

    ?>
    <?php if($___Ls->ls->chk=='ok'){ ?>
        <?php $___Ls->_bld_l_hdr(); ?>

        <?php if(($___Ls->qry->tot > 0)){  ?>	
            <table width="100%" border="0" cellpadding="0" cellspacing="0" class="Ls_Rg">
                <tr>
                    <th width="20%" <?php echo NWRP ?>><?php echo 'Segmento'; ?></th>
                    <th width="1%" <?php echo NWRP ?>></th>
                </tr>		
                <?php do {  ?>	
                <tr>  
                    <td width="20%" align="left" <?php echo $_clr_rw ?>><?php echo ctjTx($___Ls->ls->rw['eclstssgm_nm'],'in'); ?></td>
                    <td width="1%" align="left" nowrap="nowrap" class="_btn"><?php echo $___Ls->_btn([ 't'=>'mod' ]); ?></td>
                </tr>
                <?php } while ($___Ls->ls->rw = $___Ls->sql->fetch_assoc()); ?>
            </table>
            <?php $___Ls->_bld_l_pgs(); 
        }
        $___Ls->_h_ls_nr(); 
    } ?>
    <?php if($___Ls->fm->chk=='ok'){ ?>
        <div class="FmTb">	
            <div id="<?php echo $___Ls->fm->bx->id ?>" class="<?php echo DV_GNR_FM_BX ?>" > 
                <form method="POST" name="<?php echo $___Ls->fm->id; ?>" target="_self" id="<?php echo $___Ls->fm->id; ?>">	
                    	
                    <?php $___Ls->_bld_f_hdr(); ?>
                    <div id="<?php echo $___Ls->fm->fld->id ?>" class="<?php echo DV_GNR_FM_CMP ?>">
                        <div class="ln_1">
                            <div class="col_1">
                                <?php
                                    echo HTML_inp_hd('cnteml_eml', _SbLs_ID('i'));
                                    echo LsEcLsts('eccmpg_lsts','eclsts_enc', '', '', 1, '', '', [ 'ord'=>'i' ] ); 
                                    $CntWb .= JQ_Ls('eccmpg_lsts',FM_LS_SLCD); 

                                    $CntWb .= " 
    
                                        $('#eccmpg_lsts').change(function(){
                                            var __id = $(this).val();	
                                            SUMR_Main.ld.f.slc({
                                                i: __id, 
                                                t_i: __id, 
                                                t:'ec_lsts_sgm_eml', 
                                                b:'ec_lsts_sgm_bx',
                                                d:{
                                                    wvar: 'no',
                                                    mlt: 'no'
                                                }
                                            });
                                        });
                                    ";
                                ?>
                            </div>
                            <div class="col_2">
                                <div id="ec_lsts_sgm_bx"></div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    <?php } ?>
<?php } ?>