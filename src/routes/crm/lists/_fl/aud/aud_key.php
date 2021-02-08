<?php
if(class_exists('CRM_Cnx')){
	

	$___Ls->tt = TX_AUD_KEY;
	$___Ls->sch->f = 'audkey_post, audkey_key';
	
	$___Ls->new->w = 400;
	$___Ls->new->h = 350;
	$___Ls->edit->w = 400;
	$___Ls->edit->h = 350;
	
	$___Ls->_strt();
	
	if(!isN($___Ls->gt->i)){
		
		$___Ls->qrys = sprintf("SELECT * FROM ".MDL_AUD_KEY_BD." WHERE ".$___Ls->ik." = %s LIMIT 1", GtSQLVlStr($___Ls->gt->i, "text"));

		
	}elseif($___Ls->_show_ls == 'ok'){ 	
		 
		$_fl_aud .= ", ( SELECT sisslcf_vl FROM ".TB_SIS_SLC_F." WHERE sisslcf_slc = audkey_auddsc AND sisslcf_f = 39 ) AS _aud_dsc";

		$Ls_Whr = "FROM ".MDL_AUD_KEY_BD." WHERE ".$___Ls->ino." != '' ".$___Ls->sch->cod." ORDER BY _aud_dsc DESC, audkey_key ASC";

		$___Ls->qrys = "SELECT * $_fl_aud , (SELECT COUNT(*) $Ls_Whr) AS ".QRY_RGTOT." $Ls_Whr"; 
		
	} 
	
	$___Ls->_bld();
	
?>
<?php if($___Ls->ls->chk=='ok'){ ?>

<?php $___Ls->_bld_l_hdr();?>
<?php if(($___Ls->qry->tot > 0)){ ?>
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="Ls_Rg">
  	<tr>
	    <th width="1%" <?php echo NWRP ?>><?php echo TX_FM_No ?></th>
	    <th width="60%" <?php echo NWRP ?>><?php echo MDL_AUD ?></th>
		<th width="20%" <?php echo NWRP ?>><?php echo TX_SISAUDKEY ?></th>
		<th width="20%" <?php echo NWRP ?>><?php echo TX_ADS_PST ?></th>
		<th width="1%" <?php echo NWRP ?>></th>
  	</tr>
  	<?php do { ?>
   	<tr>
	    <td width="1%" <?php echo NWRP ?>><?php echo Spn($___Ls->ls->rw[$___Ls->ino]); ?></td>
	    <td width="60%" align="left" nowrap="nowrap"><?php echo ctjTx($___Ls->ls->rw['_aud_dsc'],'in'); ?></td>
		<td width="20%" align="left" nowrap="nowrap"><?php echo ShortTx(ctjTx($___Ls->ls->rw['audkey_key'],'in'),40,'Pt', true); ?></td>
		<td width="20%" align="left" nowrap="nowrap"><?php echo ShortTx(ctjTx($___Ls->ls->rw['audkey_post'],'in'),40,'Pt', true); ?></td>
		<td width="1%" align="left" nowrap="nowrap" class="_btn"><?php echo $___Ls->_btn([ 't'=>'mod' ]); ?></td>
  	</tr>
  <?php } while ($___Ls->ls->rw = $___Ls->sql->fetch_assoc()); ?>
</table>
<?php $___Ls->_bld_l_pgs(); ?>
<?php } ?>
<?php $___Ls->_h_ls_nr(); ?>
<?php } ?>
<?php if($___Ls->fm->chk=='ok'){ ?>
<?php if($___Ls->dt->tot > 0){ $__cls_divcol = '_col_sm'; } ?>
<div class="FmTb">
  	<div id="<?php echo $___Ls->fm->bx->id ?>" class="<?php echo DV_GNR_FM_BX ?>" >
	    <form method="POST" name="<?php echo $___Ls->fm->id; ?>" target="_self" id="<?php echo $___Ls->fm->id; ?>" >
	    	<?php $___Ls->_bld_f_hdr(); ?>
			<div id="<?php echo $___Ls->fm->fld->id ?>" class="<?php echo DV_GNR_FM_CMP ?>">
		  
		        <div class="ln_1 <?php echo $__cls_divcol; ?>">
		          
			        <?php echo Ls_Vl_Key('audkey_key', 'audkey_key', $___Ls->dt->rw['audkey_key'], ''); $CntWb .= JQ_Ls('audkey_key','');  ?>
				  	<?php echo HTML_inp_tx('audkey_post', 'Post', ctjTx($___Ls->dt->rw['audkey_post'],'in'), FMRQD); ?>
		         
		          
			            <?php $l = __Ls(['k'=>'aud_dsc', 'id'=>'audkey_auddsc', 'va'=>$___Ls->dt->rw['audkey_auddsc'] , 'ph'=>FM_LS_SLGN]);  echo $l->html; $CntWb .= $l->js; ?>
		       
		        </div>
		        
	      	</div>
	    </form>
 	</div>

</div>
<?php } ?>
<?php } ?> 