<?php
if(class_exists('CRM_Cnx')){	
	
	$___Ls->tt = _Cns('MDL_S');
	$___Ls->img->dir = DMN_FLE_MDL_S;
	$___Ls->fm->ing = $__md_ing;
	$___Ls->fm->mod = $__md_mod;
	
	$___Ls->new->w = 500;
	$___Ls->new->h = 350;
	$___Ls->edit->w = 500;
	$___Ls->edit->h = 350;
	
	$___Ls->sch->f = 'mdls_nm, mdlstp_nm';

	$___Ls->_strt();



	if(!isN($___Ls->gt->i)){	
		
		$___Ls->qrys = sprintf("SELECT * FROM ".TB_MDL_S.", ".TB_MDL_S_TP." WHERE ".$___Ls->ik." = %s AND mdls_tp = id_mdlstp LIMIT 1", GtSQLVlStr($___Ls->gt->i, "text"));
		
	}elseif($___Ls->_show_ls == 'ok'){ 

		$Ls_Whr = "FROM ".TB_MDL_S.", ".TB_MDL_S_TP." WHERE mdls_tp = id_mdlstp ".$___Ls->sch->cod." ORDER BY id_mdls DESC";
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
    <th width="40%" <?php echo NWRP ?>><?php echo TX_NM ?></th>
    <th width="10%" <?php echo NWRP ?>><?php echo TX_TP ?></th>
    <th width="10%" <?php echo NWRP ?>><?php echo TX_CLS ?></th>
	<th width="1%" <?php echo NWRP ?>></th>
  </tr>
  <?php do { ?>
    <tr>    	  
    	<td width="1%" <?php echo NWRP ?>><?php echo Spn($___Ls->ls->rw[$___Ls->ino]); ?></td>
		<td width="40%" align="left" nowrap="nowrap"><?php echo ShortTx(ctjTx($___Ls->ls->rw['mdls_nm'],'in'),150,'Pt', true); ?></td>
		<td width="10%" align="left" nowrap="nowrap"><?php echo ShortTx(ctjTx($___Ls->ls->rw['mdlstp_nm'],'in'),150,'Pt', true); ?></td>
		<td width="10%" align="left" nowrap="nowrap"><?php echo ShortTx(ctjTx($___Ls->ls->rw['mdls_cls'],'in'),150,'Pt', true); ?></td>
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
				<?php echo HTML_inp_tx('mdls_nm', TX_NM , ctjTx($___Ls->dt->rw['mdls_nm'],'in'), FMRQD); ?>
				<?php echo LsMdlSTp('mdls_tp','id_mdlstp', $___Ls->dt->rw['mdls_tp'], FM_LS_SLTP); $CntWb .= JQ_Ls('mdls_tp',FM_LS_SLTP); ?>
				<?php echo HTML_inp_tx('mdls_cls', TX_CLS , ctjTx($___Ls->dt->rw['mdls_cls'],'in')); ?>
	        </div>
      	</div>
    </form>
  </div>
</div>
<?php } ?>
<?php } ?>
