<?php
if(class_exists('CRM_Cnx')){
	$___Ls->sch->f = 'siscddp_tt, sisps_tt';
	$___Ls->new->w = 500;
	$___Ls->new->h = 500;
	
	$___Ls->edit->w = 500;
	$___Ls->edit->h = 500;
	
	$___Ls->_strt();
	if(!isN($___Ls->gt->i)){	
		$___Ls->qrys = sprintf("SELECT * FROM "._BdStr(DBM).TB_SIS_CD_DP." WHERE ".$___Ls->ik." = %s LIMIT 1", GtSQLVlStr($___Ls->gt->i, "text"));	
	}elseif($___Ls->_show_ls == 'ok'){ 	
		$Ls_Whr = " FROM "._BdStr(DBM).TB_SIS_CD_DP." 
						INNER JOIN "._BdStr(DBM).TB_SIS_PS." ON siscddp_ps = id_sisps
					WHERE ".$___Ls->ino." != '' ".$___Ls->sch->cod." ORDER BY ".$___Ls->ino." DESC";
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
    	<th width="49%" <?php echo NWRP ?>><?php echo TX_DEPTO ?></th>
    	<th width="48%" <?php echo NWRP ?>><?php echo TX_PS ?></th>
    	<th width="1%" <?php echo NWRP ?>></th>
  	</tr>
  	<?php do { ?>
  	<tr> 
		<td width="1%" <?php echo NWRP ?>><?php echo Spn($___Ls->ls->rw[$___Ls->ino]); ?></td>
		<td width="49%" align="left" nowrap="nowrap"><?php echo ShortTx(ctjTx($___Ls->ls->rw['siscddp_tt'],'in'),40,'Pt', true); ?></td>
		<td width="48%" align="left" nowrap="nowrap"><?php echo ShortTx(ctjTx($___Ls->ls->rw['sisps_tt'],'in'),150,'Pt', true); ?></td>
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
	        <?php echo HTML_inp_hd('siscddp_enc', $___Ls->dt->rw['siscddp_enc']); ?> 
        	<div class="col_1">
			<?php echo HTML_inp_tx('siscddp_tt', MDL_SIS_CD_DP , ctjTx($___Ls->dt->rw['siscddp_tt'],'in'), FMRQD); ?>
			<?php echo HTML_inp_tx('siscddp_pml', TX_PML , ctjTx($___Ls->dt->rw['siscddp_pml'],'in'), FMRQD); ?>
			<?php echo HTML_inp_tx('siscddp_indc', TT_FM_CD_IND , ctjTx($___Ls->dt->rw['siscddp_indc'],'in'), FMRQD_NMR); ?>
          	</div>
		  	<div class="col_2"> 
		  	<?php // echo $_bldr->UsNvl([ 'va'=>$___Ls->dt->rw['us_nivel'] ]); 
			  	 echo LsPs([ 'id'=>'siscddp_ps', 'v'=>'id_sisps', 'va'=>$___Ls->dt->rw['siscddp_ps'], 'rq'=>2 ]); $CntWb .= JQ_Ls('siscddp_ps',TX_SLCPS); ?>
          	</div>
        </div>
      	</div>
    </form>
  	</div>
</div>
<?php } ?>
<?php } ?>