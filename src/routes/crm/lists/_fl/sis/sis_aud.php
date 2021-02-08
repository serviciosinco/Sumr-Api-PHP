<?php	
if(class_exists('CRM_Cnx')){

	
	$___Ls->sch->f = 'audtx_dsc, obs_audtx';
	
	$___Ls->new->w = 500;
	$___Ls->new->h = 350;
	$___Ls->_strt();

	if(!isN($___Ls->gt->i)){	
		
		$___Ls->qrys = sprintf("SELECT * FROM ".MDL_SIS_AUD_BD." WHERE ".$___Ls->ik." = %s LIMIT 1", GtSQLVlStr($___Ls->gt->i, "text"));
		
	}elseif($___Ls->_show_ls == 'ok'){ 	
		 
		$Ls_Whr = "FROM ".MDL_SIS_AUD_BD." WHERE ".$___Ls->ino." != '' ".$___Ls->sch->cod." ORDER BY ".$___Ls->ino." DESC";
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
    	<th width="66%" <?php echo NWRP ?>><?php echo TX_MSJ ?></th>
    	<th width="33%" <?php echo NWRP ?>><?php echo TX_PRC ?></th>
    	<th width="1%" <?php echo NWRP ?>></th>
  	</tr>
  	<?php do { ?>
  	<tr>    	  
    	<td width="1%" <?php echo NWRP ?>><?php echo Spn($___Ls->ls->rw[$___Ls->ino]); ?></td>
		<td width="66%" align="left" nowrap="nowrap"><?php echo ShortTx(ctjTx($___Ls->ls->rw['audtx_dsc'],'in'),150,'Pt', true); ?></td>
		<td width="33%" align="left" nowrap="nowrap"><?php echo ShortTx(ctjTx($___Ls->ls->rw['obs_audtx'],'in'),40,'Pt', true); ?></td>
		<td width="1%" align="left" nowrap="nowrap" class="_btn"><?php echo $___Ls->_btn([ 't'=>'mod' ]); ?></td>
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
		        	
				    	<?php echo HTML_inp_tx('audtx_dsc', TX_MSJ, ctjTx($___Ls->dt->rw['audtx_dsc'],'in'), FMRQD); ?>
						<?php echo HTML_inp_tx('obs_audtx', TX_PRC, ctjTx($___Ls->dt->rw['obs_audtx'],'in'), FMRQD); ?>
					
					
					  	<?php $l = __Ls(['k'=>'_sis_aud_tp', 'id'=>'aud_tp', 'va'=>$___Ls->dt->rw['aud_tp'] , 'ph'=>FM_LS_SLGN]);  echo $l->html; $CntWb .= $l->js; ?>
		        	
		        </div>
	      	</div>
    	</form>
  	</div>

</div>
<?php } ?>
<?php } ?>
