<?php
if(class_exists('CRM_Cnx')){

	$___Ls->tt = TX_SISSLC;
	$___Ls->sch->f = 'sisslc_tt';
	$___Ls->ls->lmt = 1000;
	$___Ls->_strt();
	
	if($___Ls->gt->tsb == 'cl'){ 
		$___Ls->cnx->cl = 'ok';
		$__bd = TB_CL_SLC;
		$__bd2 = TB_CL_SLC_TP;
	}else{
		$__bd = TB_SIS_SLC;
		$__bd2 = TB_SIS_SLC_TP;
	}

	if(!isN($___Ls->gt->i)){	
		
		$___Ls->qrys = sprintf("SELECT * FROM $__bd WHERE ".$___Ls->ik." = %s LIMIT 1", GtSQLVlStr($___Ls->gt->i, "text"));
		
	}elseif($___Ls->_show_ls == 'ok'){ 
	
		$Ls_Whr = "FROM $__bd, $__bd2 WHERE id_sisslctp = sisslc_tp AND ".$___Ls->ino." != '' ".$___Ls->sch->cod." ORDER BY sisslctp_tt ASC, sisslc_tt DESC";
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
    	<th width="49%" <?php echo NWRP ?>><?php echo TT_FM_PS ?></th>
		<th width="49%" <?php echo NWRP ?>><?php echo TX_TP ?></th>
		<th width="1%" <?php echo NWRP ?>></th>
  	</tr>
  	<?php do { ?>
  	<tr>
    	<td width="1%" <?php echo NWRP ?>><?php echo Spn($___Ls->ls->rw[$___Ls->ino]); ?></td>
		<td width="49%" align="left" nowrap="nowrap"><?php echo ShortTx(ctjTx($___Ls->ls->rw['sisslc_tt'],'in'),40,'Pt', true); ?></td>
		<td width="49%" align="left" nowrap="nowrap"><?php echo ShortTx(ctjTx($___Ls->ls->rw['sisslctp_tt'],'in'),40,'Pt', true); ?></td>
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

	
    <form method="POST" name="<?php echo $___Ls->fm->id; ?>" target="_self" id="<?php echo $___Ls->fm->id; ?>" >
      <?php $___Ls->_bld_f_hdr(); ?>

      <div id="<?php echo $___Ls->fm->fld->id ?>" class="<?php echo DV_GNR_FM_CMP ?>">
	  
        <div class="ln_1">
          <div class="col_1">
		  	<?php echo HTML_inp_tx('sisslc_tt', TX_CON_TT , ctjTx($___Ls->dt->rw['sisslc_tt'],'in'), FMRQD); ?>
       
          </div>
          <div class="col_2">
		  	<?php echo LsSisSlcTp('sisslc_tp','id_sisslctp', $___Ls->dt->rw['sisslc_tp'], '', 2); $CntWb .= JQ_Ls('sisslc_tp',TX_SLCTP); ?>
          </div>
        </div>
      </div>
    </form>
  </div>
</div>
<?php } ?>
<?php } ?> 
