<?php
if(class_exists('CRM_Cnx')){
	
	$___Ls->tt = MDL_EMP_OFR_TP;
	$___Ls->cnx->cl = 'ok';
	$___Ls->sch->f = 'ofrtp_nm';
	$___Ls->_strt();
	
	if(!isN($___Ls->gt->i)){	
		
		$___Ls->qrys = sprintf("SELECT * FROM ".MDL_EMP_OFR_TP_BD." WHERE ".$___Ls->ik." = %s LIMIT 1", GtSQLVlStr($___Ls->gt->i, "text"));
		
	}elseif($___Ls->_show_ls == 'ok'){ 


		$Ls_Whr = "FROM ".MDL_EMP_OFR_TP_BD." WHERE ".$___Ls->ino." != '' ".$___Ls->sch->cod." ORDER BY ".$___Ls->ino." DESC";
		$___Ls->qrys = "SELECT *, (SELECT COUNT(*) $Ls_Whr) AS ".QRY_RGTOT." $Ls_Whr";
		
	} 
	
	$___Ls->_bld(); 
?>
<?php if($___Ls->ls->chk=='ok'){ ?>
<?php $___Ls->_bld_l_hdr(); ?>
<?php if(($___Ls->qry->tot > 0)){ ?>
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="Ls_Rg">
  	<tr>
    	<th width="1%" <?php echo NWRP ?>><?php echo TX_FM_No ?></th>
		<th width="0%" <?php echo NWRP ?>><?php echo TX_NM ?></th>
		<th width="1%" <?php echo NWRP ?>>&nbsp;</th>
  	</tr>
  	<?php do { ?>
  	<tr>
    	<td align="left" <?php echo $_clr_rw ?>><?php echo $___Ls->ls->rw[$___Ls->ino]; ?></td>
		<td align="left" <?php echo $_clr_rw ?>><?php echo ctjTx($___Ls->ls->rw['ofrtp_nm'],'in'); ?></td>
		<td width="1%" align="left" nowrap="nowrap"><?php echo $___Ls->_btn([ 't'=>'mod' ]); ?></td>
  	</tr>
  	<?php } while ($___Ls->ls->rw = $___Ls->sql->fetch_assoc()); ?>
</table>
<?php $___Ls->_bld_l_pgs(); ?>
<?php } ?>

<?php $___Ls->_h_ls_nr(); ?>
<?php } ?>
<?php if($___Ls->fm->chk=='ok'){ ?>
<div class="FmTb">

  <div id="<?php  echo DV_GNR_FM ?>">
    
    
    <form method="POST" name="<?php echo $___Ls->fm->id; ?>" target="_self" id="<?php echo $___Ls->fm->id; ?>">
      	<?php $___Ls->_bld_f_hdr(); ?>
	  	<div id="<?php echo $___Ls->fm->fld->id ?>" class="<?php echo DV_GNR_FM_CMP ?>">

        <div class="ln_1">

                <?php echo HTML_inp_tx('ofrtp_nm', TX_NM, ctjTx($___Ls->dt->rw['ofrtp_nm'],'in')); ?> 
                
      </div>
    </form>
  </div>

</div>
<?php } ?>
<?php } ?>
