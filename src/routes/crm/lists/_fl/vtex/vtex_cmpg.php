<?php
if(class_exists('CRM_Cnx')){

    $___Ls->_strt();

    if(!isN($___Ls->gt->i)){	

        $___Ls->qrys = sprintf("SELECT 
                                    id_vtexcmpg, vtexcmpg_enc, vtexcmpg_nm, vtexcmpg_pml, vtexcmpg_sndr, vtexcmpg_ec_rfd, vtexcmpg_ec_rfd_in,
                                    vtexcmpg_ec_ins, vtexcmpg_ec_ins_ord, vtexcmpg_vlr_mnd, vtexcmpg_vlr_cod, vtexcmpg_plcy, vtexcmpg_ec_rfd_coup
                                FROM "._BdStr(DBT).TB_VTEX_CMPG." 
                                    WHERE ".$___Ls->ik." = %s LIMIT 1", GtSQLVlStr($___Ls->gt->i, "text"));	

    }elseif($___Ls->_show_ls == 'ok'){ 	

    } 
    $___Ls->_bld();
    ?>
    <?php if($___Ls->ls->chk=='ok'){ ?>
        <?php $___Ls->_bld_l_hdr();?>
            <?php if(($___Ls->qry->tot > 0)){ ?>
            <?php } ?>
        <?php $___Ls->_h_ls_nr(); ?>
    <?php } ?>
    <?php if($___Ls->fm->chk=='ok'){ ?>
        <div class="FmTb">
            <div id="<?php echo $___Ls->fm->bx->id ?>" class="<?php echo DV_GNR_FM_BX ?>" >
                <form method="POST" name="<?php echo $___Ls->fm->id; ?>" target="_self" id="<?php echo $___Ls->fm->id; ?>">
                    <?php $___Ls->_bld_f_hdr(); ?>      
                    <div id="<?php echo $___Ls->fm->fld->id ?>" class="<?php echo DV_GNR_FM_CMP ?>">
                        <div class="ln_1">
                            <div class='col_1'>
                                <?php echo HTML_inp_tx('vtexcmpg_nm', TT_FM_NM , ctjTx($___Ls->dt->rw['vtexcmpg_nm'],'in'), FMRQD); ?>
                                <?php echo HTML_inp_tx('vtexcmpg_pml', TX_PML , ctjTx($___Ls->dt->rw['vtexcmpg_pml'],'in'), FMRQD); ?>

                                <?php echo HTML_inp_tx('vtexcmpg_vlr_mnd', 'Valor Moneda' , ctjTx($___Ls->dt->rw['vtexcmpg_vlr_mnd'],'in'), ''); ?>
                                <?php echo HTML_inp_tx('vtexcmpg_vlr_cod', 'Valor Codigo' , ctjTx($___Ls->dt->rw['vtexcmpg_vlr_cod'],'in'), ''); ?>

                                <?php 
							                    	
                                    if(_ChckMd('snd_ec_slc_eml')){
                                        echo LsClEml('vtexcmpg_sndr','id_eml', $___Ls->dt->rw['vtexcmpg_sndr'], 'Seleccione Sender', 2, '', 'Width'); 
                                        $CntWb .= JQ_Ls('vtexcmpg_sndr', '- seleccione sender -');	
                                    }

                                    echo LsPlcy('vtexcmpg_plcy', 'id_clplcy', $___Ls->dt->rw['vtexcmpg_plcy'], FM_LS_PLCY, 'ok', '', [ 'cl'=>CL_ENC ] ); $CntWb .= JQ_Ls('vtexcmpg_plcy', '');
                                    
                                ?>
                            </div>
                            <div class='col_2'>
                                <?php 

                                    echo h1('Referido');

                                    echo h2('(Referido) Pushmail Bienvenido');
                                    echo LsEc('vtexcmpg_ec_rfd','id_ec', $___Ls->dt->rw['vtexcmpg_ec_rfd'], '', 2, ''); 
                                    $CntWb .= JQ_Ls('vtexcmpg_ec_rfd',FM_LS_TRSTP);

                                    echo h2('(Referido) Pushmail Completa Datos');
                                    echo LsEc('vtexcmpg_ec_rfd_in','id_ec', $___Ls->dt->rw['vtexcmpg_ec_rfd_in'], '', 2, ''); 
                                    $CntWb .= JQ_Ls('vtexcmpg_ec_rfd_in',FM_LS_TRSTP);

                                    echo h2('(Referido) - Pushmail Cupon');
                                    echo LsEc('vtexcmpg_ec_rfd_coup','id_ec', $___Ls->dt->rw['vtexcmpg_ec_rfd_coup'], '', 2, '2'); 
                                    $CntWb .= JQ_Ls('vtexcmpg_ec_rfd_coup',FM_LS_TRSTP);

                                    echo h1('Inscrito');

                                    echo h2('(Inscrito) Pushmail Cupon');
                                    echo LsEc('vtexcmpg_ec_ins','id_ec', $___Ls->dt->rw['vtexcmpg_ec_ins'], '', 2, ''); 
                                    $CntWb .= JQ_Ls('vtexcmpg_ec_ins',FM_LS_TRSTP);

                                    echo h2('(Inscrito) Pushmail - Nueva Compra');
                                    echo LsEc('vtexcmpg_ec_ins_ord','id_ec', $___Ls->dt->rw['vtexcmpg_ec_ins_ord'], '', 2, ''); 
                                    $CntWb .= JQ_Ls('vtexcmpg_ec_ins_ord',FM_LS_TRSTP);

                                    
                                ?>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    <?php } ?>
<?php } ?>