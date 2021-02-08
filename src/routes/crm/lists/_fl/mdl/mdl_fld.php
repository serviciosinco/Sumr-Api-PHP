<?php
if(class_exists('CRM_Cnx')){
	
	$___Ls->cnx->cl = 'ok';
	$___Ls->sch->f = 'mdlfld_dsc';
	$___Ls->_strt();
	
	$__mdl_id = 'id_mdl';
	$__mdl_rlc = 'mdlfld_mdl';
	$__mdl_fld = 'id_lndfld';
	$__lnd_rlc = 'mdlfld_fld';
	
	$__idtp_fle_fm = DV_LSFL.'_fle_fm';
	
	
	if(_SbLs_ID('i')){ $__fl .= _AndSql('mdlfld_mdl', _SbLs_ID('i')); }
	
	if(!isN($___Ls->gt->i)){	
		
		$___Ls->qrys = sprintf("SELECT * FROM ".MDL_MDL_FLD_BD." WHERE ".$___Ls->ik." = %s LIMIT 1", GtSQLVlStr($___Ls->gt->i, "text"));
		
	}elseif($___Ls->_show_ls == 'ok'){ 

		$Ls_Whr = "FROM ".MDL_MDL_FLD_BD.", ".TB_MDL.", ".TB_SIS_FLD."
				   WHERE {$__lnd_rlc} = {$__mdl_fld} AND {$__mdl_rlc} = {$__mdl_id} $__fl ".$___Ls->sch->cod." ORDER BY mdlfld_row ASC, mdlfld_ord ASC";		   
		$___Ls->qrys = "SELECT *, (SELECT COUNT(*) $Ls_Whr) AS ".QRY_RGTOT." $Ls_Whr";  
		
	} 
	
	$___Ls->_bld(); 
?>
<?php if($___Ls->ls->chk=='ok'){ ?>

<?php $___Ls->_bld_l_hdr(); ?>
<?php if(($___Ls->qry->tot > 0)){ ?>



<table width="100%" border="0" cellpadding="0" cellspacing="0" class="Ls_Rg">
  <thead>
            <tr>
				<?php /*?>
                <th width="1%" <?php echo NWRP ?>><?php echo TX_FM_No ?></th>
                <?php */?>
                <?php if($__lssb != 'ok'){ ?>
                <th width="49%" <?php echo NWRP ?>><?php echo TX_PRG ?></th>
                <?php } ?>
                <th width="49%" <?php echo NWRP ?>><?php echo TX_ITM ?></th>
                <th width="49%" <?php echo NWRP ?>><?php echo TX_ORD ?></th>
                <th width="1%" <?php echo NWRP ?>><?php echo TX_FIN ?></th>
                <th width="1%" <?php echo NWRP ?>><?php echo TX_HR ?></th>
            </tr>
  </thead>  
  <tbody>
		  <?php do { ?>
          <tr <?php 
                             

                            if((SISUS_ID == $___Ls->ls->rw['mdlfld_fld']) || (ChckSESS_superadm())){
                                $_lnktr_l = FL_LS_GN.__t($__bdtp,true).PgRgFl($Flt_Cmp.$Flt_CmpND, 'get')._SbLs_ID().ADM_LNK_DT.$___Ls->ls->rw[$___Ls->ino].PgRgFl($Flt_Cmp.$Flt_CmpND, 'get').$___Ls->ls->vrall.$_adsch;

                            }
                            $_lnktr = _Ls_Lnk_Rw(['l'=>$_lnktr_l, 'sb'=>''/*$__lssb*/, 'r'=>$___Ls->bx_rld]);
                            cl($_lnktr); 
                            
                            
          ?>>
            <?php /*?>

            <td width="1%" align="left" <?php echo $_clr_rw ?>><?php echo $___Ls->ls->rw[$___Ls->ino]; ?></td>

            <?php */?>
            <?php if($__lssb != 'ok'){ ?>
            <td width="49%" align="left" <?php echo $_clr_rw ?>><?php echo ctjTx($___Ls->ls->rw[$___Ls->mdlstp->tp.'_nm'],'in'); ?></td>
            <?php } ?>
            <td width="49%" align="left" <?php echo $_clr_rw ?>><?php echo ShortTx(ctjTx(strip_tags($___Ls->ls->rw['lndfld_tt']),'in'),60,'Pt', true); ?></td>

            <td width="1%" align="left" <?php echo $_clr_rw ?>><?php echo Spn($___Ls->ls->rw['mdlfld_row'].' - '.$___Ls->ls->rw['mdlfld_ord'],'','_f') ?></td>
            <td width="1%" align="left" <?php echo $_clr_rw ?>><?php echo Spn($___Ls->ls->rw['mdlfld_fi'],'','_f') ?></td>
            <td width="1%" align="left" <?php echo $_clr_rw ?>><?php echo Spn($___Ls->ls->rw['mdlfld_hi'],'','_f') ?></td>

            </tr>
          <?php } while ($___Ls->ls->rw = $___Ls->sql->fetch_assoc()); ?>
  </tbody>
</table>

<?php $___Ls->_bld_l_pgs(); ?>
<?php } ?>

<?php $___Ls->_h_ls_nr(); ?>
<?php } ?>
<?php if($___Ls->fm->chk=='ok'){ ?>
<div class="FmTb">
  <div id="<?php echo DV_GNR_FM.$__prfx_fm ?>">
  	<?php 
			

			
  			 
	?>
                       
                             
    <form method="POST" name="<?php echo $___Ls->fm->id; ?>" target="_self" id="<?php echo $___Ls->fm->id; ?>" >
      <?php $___Ls->_bld_f_hdr(); ?>

      <div id="<?php echo DV_GNR_FM_CMP.$__prfx_fm ?>">

				<div class="ln_1">
                            <div class="col_1"> 
                            	
								<?php echo HTML_inp_hd('___t', $__prfx->prfx3_c); ?>
								<?php 

										if(_SbLs_ID('i') != ''){ $__id_ky = _SbLs_ID('i'); }else{ $__id_ky = $___Ls->dt->rw['mdlfld_mdl']; }

										
										if(($__lssb != 'ok' && ChckSESS_superadm()) || ($___Ls->dt->tot != 1)){
											if(_SbLs_ID('i') != ''){
												echo HTML_inp_hd('mdlfld_mdl', _SbLs_ID('i'));
											}else{
												echo LsMdl($___Ls->mdlstp->tp, 'mdlfld_mdl',$__id, $__id_ky, '', 1); $CntWb .= JQ_Ls('mdlfld_mdl',FM_LS_SLPRO);
											}
										}else{
											if($___Ls->dt->tot == 1){

												echo HTML_inp_hd('mdlfld_mdl', $___Ls->dt->rw['mdlfld_mdl']);

											}else{
												echo HTML_inp_hd('mdlfld_mdl', _SbLs_ID('i'));
											}
										}
														

										echo LsSisFld('mdlfld_fld','id_lndfld', $___Ls->dt->rw['mdlfld_fld'], FM_LS_ASGNTRS, 2); $CntWb .= JQ_Ls('mdlfld_fld',FM_LS_ASGNTRS);
										
										echo HTML_inp_tx('mdlfld_ord', TX_ORD, ctjTx($___Ls->dt->rw['mdlfld_ord'],'in'), FMRQD_NM); 
										echo HTML_inp_tx('mdlfld_row', TX_ROW, ctjTx($___Ls->dt->rw['mdlfld_row'],'in'), FMRQD_NM); 
										echo OLD_HTML_chck('mdlfld_rqr', TX_CHK_RQR, $___Ls->dt->rw['mdlfld_rqr'], 'in'); 

										
								?>
                            </div>
                            <div class="col_2"> 
								<?php foreach ($__lngall as &$_l) { ?>
                                <div id="Fm_<?php echo $_l['id'] ?>" class="CollapsiblePanel">
                                  <div class="CollapsiblePanelTab"><?php echo $_l['tt'] ?></div>
                                              <div class="CollapsiblePanelContent">

                                                        <?php echo HTML_textarea('mdlfld_tt_'.$_l['id'], '', ctjTx($___Ls->dt->rw['mdlfld_tt_'.$_l['id']],'in'), '', 'ok',$__jqte); ?>

                                               </div>
                                </div>
                                <?php $CntWb .= 'var Fm_'.$_l['id'].' = new Spry.Widget.CollapsiblePanel("Fm_'.$_l['id'].'", {contentIsOpen:false});'; ?>
                                <?php } ?>
                            </div>
                
      </div>
    </form>
  </div>

</div>
<?php } ?>
<?php } ?>