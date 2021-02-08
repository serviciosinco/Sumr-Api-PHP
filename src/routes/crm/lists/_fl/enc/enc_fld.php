<?php
if(class_exists('CRM_Cnx')){
	
	$___Ls->cnx->cl = 'ok';
	$___Ls->_strt();	

	$__idtp_fle_fm = DV_LSFL.'_fle_fm';	
	
	if(_SbLs_ID('i')){ $__fl .= _AndSql('encfld_enc', _SbLs_ID('i')); }
	
	if(!isN($___Ls->gt->i)){	
		
		$___Ls->qrys = sprintf("	SELECT * 
									FROM "._BdStr(DBM).TB_ENC_FLD." 
									WHERE ".$___Ls->ik." = %s 
									LIMIT 1", GtSQLVlStr($___Ls->gt->i, "text")
								);
		
	}elseif($___Ls->_show_ls == 'ok'){ 


		$Ls_Whr = "FROM "._BdStr(DBM).TB_ENC_FLD."
						INNER JOIN "._BdStr(DBM).TB_ENC." ON encfld_enc = id_enc
						INNER JOIN "._BdStr(DBM).TB_SIS_FLD." ON encfld_fld = id_sisfld
				   WHERE id_encfld != '' $__fl ".$___Ls->sch->cod." 
				   ORDER BY encfld_row ASC, encfld_ord ASC";	
				   	   
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
            <?php if(ChckSESS_superadm()){ ?>
            	<th width="3%" <?php echo NWRP ?>><?php echo TX_FM_No ?></th>
            <?php } ?>
            <th width="49%" <?php echo NWRP ?>><?php echo TX_ITM ?></th>
            <th width="49%" <?php echo NWRP ?>><?php echo TX_ORD ?></th>
            <th width="1%" <?php echo NWRP ?>><?php echo TX_FIN ?></th>
            <th width="1%" <?php echo NWRP ?>><?php echo TX_HR ?></th>
            <th width="1%" <?php echo NWRP ?>>&nbsp;</th>
        </tr>
  	</thead>  
  	<tbody>
	  	<?php do { ?>
        <tr>
        	<?php if(ChckSESS_superadm()){ ?>
	        <td width="3%" align="left" <?php echo $_clr_rw ?>><?php echo ctjTx($___Ls->ls->rw['id_fld'],'in'); ?></td>
	        <?php } ?>
	        <td width="49%" align="left" <?php echo $_clr_rw ?>><?php echo ShortTx(ctjTx(strip_tags($___Ls->ls->rw['sisfld_tt']),'in'),60,'Pt', true); ?></td>
	        <td width="1%" align="left" <?php echo $_clr_rw ?>><?php echo Spn($___Ls->ls->rw['encfld_row'].' - '.$___Ls->ls->rw['encfld_ord'],'','_f') ?></td>
	        <td width="1%" align="left" <?php echo $_clr_rw ?>><?php echo Spn($___Ls->ls->rw['encfld_fi'],'','_f') ?></td>
	        <td width="1%" align="left" <?php echo $_clr_rw ?>><?php echo Spn($___Ls->ls->rw['encfld_hi'],'','_f') ?></td>
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

  <div >
                                 
		<form method="POST" name="<?php echo $___Ls->fm->id; ?>" target="_self" id="<?php echo $___Ls->fm->id; ?>">

			<?php $___Ls->_bld_f_hdr(); ?>      
	  
			<div id="<?php echo $___Ls->fm->fld->id ?>" class="<?php echo DV_GNR_FM_CMP ?>">


				<div class="ln_1">
                            <div class="col_1"> 
                            	
								<?php echo HTML_inp_hd('encfld_enc', _SbLs_ID('i'));
										
										echo LsSisFld('encfld_fld','id_sisfld', $___Ls->dt->rw['encfld_fld'], FM_LS_ASGNTRS, 2, '', [ 'pfx'=>$___Ls->gt->tsb ]); 
										$CntWb .= JQ_Ls('encfld_fld',FM_LS_ASGNTRS);
										echo HTML_inp_tx('encfld_row', TX_ROW, ctjTx($___Ls->dt->rw['encfld_row'],'in'), FMRQD_NM);
										echo HTML_inp_tx('encfld_ord', TX_ORD, ctjTx($___Ls->dt->rw['encfld_ord'],'in'), FMRQD_NM); 
										echo HTML_inp_tx('encfld_max', TX_CRCTR , ctjTx($___Ls->dt->rw['encfld_max'],'in'),'');
										echo OLD_HTML_chck('encfld_rqr', TX_CHK_RQR, $___Ls->dt->rw['encfld_rqr'], 'in'); 
										
								?>
                            </div>
                            <div class="col_2"> 
								<?php $__lng = GtLngLs(); ?>
								<?php foreach ($__lng->ls as $_k=>$_v) { ?>
                                <div id="Fm_<?php echo $_v->cod ?>" class="CollapsiblePanel">
                                  <div class="CollapsiblePanelTab"><p class="fld_tt"><?php echo $_v->nm ?><p></div>
									<div class="CollapsiblePanelContent">
											<?php echo HTML_textarea('encfld_tt_'.$_v->cod, '', ctjTx($___Ls->dt->rw['encfld_tt_'.$_v->cod],'in'), '', 'ok',$__jqte); ?>
									</div>
                                </div>
                                <?php $CntWb .= 'var Fm_'.$_v->cod.' = new Spry.Widget.CollapsiblePanel("Fm_'.$_v->cod.'", {contentIsOpen:false});'; ?>
                                <?php } ?>
                            </div>
                
      </div>
    </form>
  </div>

</div>
<?php } ?>
<?php } ?>