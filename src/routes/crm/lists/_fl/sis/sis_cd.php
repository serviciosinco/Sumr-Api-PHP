<?php
if(class_exists('CRM_Cnx')){
	
	$___Ls->sch->f = 'siscd_tt, siscddp_tt, sisps_tt';
	$___Ls->new->w = 400;
	$___Ls->new->h = 350;
	$___Ls->edit->w = 400;
	$___Ls->edit->h = 350;
	
	$___Ls->_strt();
	
	
	if(!isN($___Ls->gt->i)){	
		$___Ls->qrys = sprintf("SELECT * FROM "._BdStr(DBM).MDL_SIS_CD_BD." WHERE ".$___Ls->ik." = %s LIMIT 1", GtSQLVlStr($___Ls->gt->i, "text"));	
	}elseif($___Ls->_show_ls == 'ok'){ 	
		$Ls_Whr = " FROM "._BdStr(DBM).MDL_SIS_CD_BD." 
						INNER JOIN "._BdStr(DBM).TB_SIS_CD_DP." ON siscd_dp = id_siscddp
						INNER JOIN "._BdStr(DBM).TB_SIS_PS." ON siscddp_ps = id_sisps
					WHERE ".$___Ls->ino." != '' ".$___Ls->sch->cod." ORDER BY siscd_vrf DESC, ".$___Ls->ino." DESC";
		$___Ls->qrys = "SELECT *, (SELECT COUNT(*) $Ls_Whr) AS ".QRY_RGTOT." $Ls_Whr"; 

	} 
	$___Ls->_bld();
?>
<?php if($___Ls->ls->chk=='ok'){ ?>
<?php $___Ls->_bld_l_hdr();?>
<?php if(($___Ls->qry->tot > 0)){ ?>
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="Ls_Rg">
  	<tr>
    	<th width="1%" <?php echo NWRP ?>><?php echo TX_FM_No ?></th>
    	<th width="33%" <?php echo NWRP ?>><?php echo TT_FM_CD ?></th>
    	<th width="33%" <?php echo NWRP ?>><?php echo TX_DEPTO ?></th>
    	<th width="32%" <?php echo NWRP ?>><?php echo 'Verificado' ?></th>
    	<th width="1%" <?php echo NWRP ?>></th>
  	</tr>
  	<?php do { ?>
  	<tr> 
		<td width="1%" <?php echo NWRP ?>><?php echo Spn($___Ls->ls->rw[$___Ls->ino]); ?></td>
		<td width="33%" align="left" nowrap="nowrap"><?php echo ShortTx(ctjTx($___Ls->ls->rw['siscd_tt'],'in'),40,'Pt', true); ?></td>
		<td width="33%" align="left" nowrap="nowrap">
			<?php echo ShortTx(ctjTx($___Ls->ls->rw['siscddp_tt'],'in'),150,'Pt', true).HTML_BR; ?>
			<?php echo Spn(ctjTx($___Ls->ls->rw['sisps_tt'],'in'),'',$___Ls->ls->rw['sisps_tt']); ?>
		</td>
		<td width="32%" align="left" nowrap="nowrap"><?php echo Spn(mBln($___Ls->ls->rw['siscd_vrf']),'',mBln($___Ls->ls->rw['siscd_vrf'])); ?></td>
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
  	<div id="<?php echo $___Ls->fm->bx->id ?>" class="<?php echo DV_GNR_FM_BX ?>" >
    <form method="POST" name="<?php echo $___Ls->fm->id; ?>" target="_self" id="<?php echo $___Ls->fm->id; ?>">
      	<?php $___Ls->_bld_f_hdr(); ?>      
	  	<div id="<?php echo $___Ls->fm->fld->id ?>" class="<?php echo DV_GNR_FM_CMP ?>">
	  	<div id="<?php echo $___Ls->fm->fld->id ?>" class="<?php echo DV_GNR_FM_CMP ?>">
        <div class="ln_1">
	        <?php echo HTML_inp_hd('siscd_enc', $___Ls->dt->rw['siscd_enc']); ?> 
        	
				<?php echo HTML_inp_tx('siscd_tt', TT_FM_CD , ctjTx($___Ls->dt->rw['siscd_tt'],'in'), FMRQD); ?>
				<?php echo HTML_inp_tx('siscd_inc', TT_FM_CD_IND , ctjTx($___Ls->dt->rw['siscd_inc'],'in'), FMRQD_NMR); ?>
		  		<?php // echo $_bldr->UsNvl([ 'va'=>$___Ls->dt->rw['us_nivel'] ]); 
			  	 echo LsCdDp('siscd_dp','id_siscddp', $___Ls->dt->rw['siscd_dp'], '', 2); $CntWb .= JQ_Ls('siscd_dp',FM_LS_SLDP); ?>
			  	<?php echo OLD_HTML_chck('siscd_vrf', 'Verificado', $___Ls->dt->rw['siscd_vrf'], 'in'); ?> 
        </div>
      	</div>
    </form>
  	</div>
</div>
<?php } ?>
<?php } ?>