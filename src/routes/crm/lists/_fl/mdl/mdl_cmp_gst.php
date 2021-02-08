<?php
	
if(class_exists('CRM_Cnx')){
	
	$___Ls->cnx->cl = 'ok';
	$___Ls->sch->f = 'mdlcmpgst_dsc';
	$___Ls->_strt();

	$__idtp_fle_fm = DV_LSFL.'_fle_fm';
	
	if(_SbLs_ID('i')){ $__fl .= _AndSql('mdlcmpgst_cmp', _SbLs_ID('i')); }
	
	if(!isN($___Ls->gt->i)){	
		
		$___Ls->qrys = sprintf("SELECT * FROM ".MDL_CMP_GST_BD." WHERE ".$___Ls->ik." = %s LIMIT 1", GtSQLVlStr($___Ls->gt->i, "text"));
		
	}elseif($___Ls->_show_ls == 'ok'){ 

		$Ls_Whr = "FROM ".MDL_CMP_GST_BD.", ".MDL_CMP_BD.", ".MDL_PRO_APR_BD."
				   WHERE mdlcmp_pro = id_proapr AND mdlcmpgst_cmp = id_mdlcmp $__fl ".$___Ls->sch->cod." ORDER BY ".$___Ls->ino." DESC";   
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
            <th width="1%" <?php echo NWRP ?>><?php echo TX_FM_No ?></th>            
            <th width="1%" <?php echo NWRP ?>><?php echo TX_RSPNS ?></th>
			<?php if($__lssb != 'ok'){ ?>
            <th width="49%" <?php echo NWRP ?>><?php echo TX_PRG ?></th>
            <?php } ?>  
            <th width="49%" <?php echo NWRP ?>><?php echo TX_CON_DSC ?></th>
            <th width="1%" <?php echo NWRP ?>><?php echo TX_FIN ?></th>
            <th width="1%" <?php echo NWRP ?>><?php echo TX_HR ?></th>
            <th width="1%" <?php echo NWRP ?>></th>
        </tr>
  	</thead>  
  	<tbody>
  	<?php do { ?>
  		<?php               
            $__gtusdt = GtUsDt($___Ls->ls->rw['mdlcmpgst_us']);
            $__gtusdt_rsp = GtUsDt($___Ls->ls->rw['mdlcmpgst_us_rsp']);
      	?>
        <tr>  
            <td width="1%" align="left" <?php echo $_clr_rw ?>><?php echo $___Ls->ls->rw[$___Ls->ino]; ?></td> 
            <td width="1%" align="left" nowrap="nowrap" <?php echo $_clr_rw ?>><?php echo Spn($__gtusdt->nm_fll); ?></td>
            <?php if($__lssb != 'ok'){ ?>
            <td width="49%" align="left" <?php echo $_clr_rw ?>><?php echo ctjTx($___Ls->ls->rw['mdlcmpgst_nm'],'in'); ?></td>
            <?php } ?>
            <?php if(ChckSESS_superadm() && $___Ls->ls->rw['mdlcmpgst_shw']==2){ ?>
				<td width="49%" align="left" <?php echo $_clr_rw ?>><?php echo ShortTx(ctjTx(strip_tags($___Ls->ls->rw['mdlcmpgst_dsc']),'in'),1000,'Pt', true); ?></td>
            <?php } else{ ?>
            	<td width="49%" align="left" <?php echo $_clr_rw ?>><?php echo ShortTx(ctjTx(strip_tags($___Ls->ls->rw['mdlcmpgst_dsc']),'in'),1000,'Pt', true); ?></td>
            <?php } ?>
            <td width="1%" align="left" <?php echo $_clr_rw ?>><?php echo Spn($___Ls->ls->rw['mdlcmpgst_fi'],'','_f') ?></td>
            <td width="1%" align="left" <?php echo $_clr_rw ?>><?php echo Spn($___Ls->ls->rw['mdlcmpgst_hi'],'','_f') ?></td>
            <td width="1%" align="left" nowrap="nowrap" class="_btn"><?php echo $___Ls->_btn([ 't'=>'mod' ]); ?></td>
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
    <form method="POST" name="<?php echo $___Ls->fm->id; ?>" target="_self" id="<?php echo $___Ls->fm->id; ?>">
      <?php $___Ls->_bld_f_hdr(); ?>

      <div id="<?php echo DV_GNR_FM_CMP.$__prfx_fm ?>">

				<div class="ln_1">
                            
                     <?php echo HTML_inp_hd('___t', $__prfx->prfx3_c); ?>
                     <?php 
							if(_SbLs_ID('i') != ''){ $__id_ky = _SbLs_ID('i'); }else{ $__id_ky = $___Ls->dt->rw['mdlcmpgst_cmp']; }

							
							if(($__lssb != 'ok' && ChckSESS_superadm()) || ($___Ls->dt->tot != 1)){
								if(_SbLs_ID('i') != ''){
									echo HTML_inp_hd('mdlcmpgst_cmp', _SbLs_ID('i'));
								}else{
									echo LsConCmp('mdlcmpgst_cmp','id_mdlcmp', $__id_ky, '', 1); $CntWb .= JQ_Ls('mdlcmpgst_cmp',FM_LS_SLCON);
								}
							}else{
								if($___Ls->dt->tot == 1){

									echo HTML_inp_hd('mdlcmpgst_cmp', $___Ls->dt->rw['mdlcmpgst_cmp']);

								}else{
									echo HTML_inp_hd('mdlcmpgst_cmp', _SbLs_ID('i'));
								}
							}
											
							if($__lssb != 'ok'){

								LsUs('mdlcmpgst_us','id_us', $___Ls->dt->rw['mdlcmpgst_us'], FM_LS_ASGNTRS, 2); $CntWb .= JQ_Ls('mdlcmpgst_us',FM_LS_ASGNTRS);
							}else{
								if($___Ls->dt->rw['mdlcmpgst_us'] != ''){
									echo HTML_inp_hd('mdlcmpgst_us', $___Ls->dt->rw['mdlcmpgst_us']);

								}else{
									echo HTML_inp_hd('mdlcmpgst_us', SISUS_ID);
								}
							}
					?>
                    <?php echo HTML_textarea('mdlcmpgst_dsc', '', ctjTx($___Ls->dt->rw['mdlcmpgst_dsc'],'in'), '', 'ok', $__jqte);  ?>
                    <?php echo LsSis_Shw('mdlcmpgst_shw', 'id_sisshw', $___Ls->dt->rw['mdlcmpgst_shw'], TX_PBLPR, 2); $CntWb .= JQ_Ls('mdlcmpgst_shw',TX_PBLPRV); ?>
                      
                </div>
                
      </div>
    </form>
  </div>

</div>
<?php } ?>
<?php } ?>