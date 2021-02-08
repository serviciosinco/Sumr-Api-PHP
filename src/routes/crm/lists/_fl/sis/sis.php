<?php 
if(class_exists('CRM_Cnx')){
	$___Ls->sch->f = 'sis_tt, sis_var, sis_vl';
	$___Ls->tp = 'sis';
	
	$___Ls->new->w = 400;
	$___Ls->new->h = 350;
	$___Ls->edit->w = 450;
	$___Ls->edit->h = 350;
	
	$___Ls->_strt();
	
	if($__t == 'sis'){ 
		$__bd = MDL_SIS_BD;
	}else{
		
		$__bd = MDL_CL_SIS_BD;
		$___Ls->cnx->cl = 'ok';
	}	
	
	if(!isN($___Ls->gt->i)){	
		
		$___Ls->qrys = sprintf("SELECT * FROM $__bd WHERE ".$___Ls->ik." = %s LIMIT 1", GtSQLVlStr($___Ls->gt->i, "text"));
		
	}elseif($___Ls->_show_ls == 'ok'){ 	
		$Ls_Whr = "FROM $__bd WHERE ".$___Ls->ino." != '' ".$___Ls->sch->cod." ORDER BY ".$___Ls->ino." DESC";
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
    <th width="33%" <?php echo NWRP ?>><?php echo TX_NM ?></th>
    <th width="33%" <?php echo NWRP ?>><?php echo TX_VAR ?></th>
    <th width="33%" <?php echo NWRP ?>><?php echo TX_VLE ?></th>
    <th width="1%" <?php echo NWRP ?>></th>
  </tr>
  <?php do { ?>
   <tr>   
    <td width="1%" <?php echo NWRP ?>><?php echo Spn($___Ls->ls->rw[$___Ls->ino]); ?></td>
    <td width="33%" align="left" nowrap="nowrap"><?php echo ShortTx(ctjTx($___Ls->ls->rw['sis_tt'],'in'),40,'Pt', true); ?></td>
    <td width="33%" align="left" nowrap="nowrap"><?php echo ShortTx(ctjTx($___Ls->ls->rw['sis_var'],'in'),40,'Pt', true); ?></td>
    <td width="33%" align="left" nowrap="nowrap"><?php echo ShortTx(ctjTx($___Ls->ls->rw['sis_vl'],'in'),40,'Pt', true); ?></td>
    <td width="1%" align="left" class="_btn"><?php echo $___Ls->_btn([ 't'=>'mod' ]); ?></td>
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
    <form method="POST" name="<?php echo $___Ls->fm->id; ?>" target="_self" id="<?php echo $___Ls->fm->id; ?>" >
      <?php $___Ls->_bld_f_hdr(); ?>      
	  <div id="<?php echo $___Ls->fm->fld->id ?>" class="<?php echo DV_GNR_FM_CMP ?>">
        <div class="ln_1">
	        <?php //echo HTML_inp_hd('sis_enc', $___Ls->dt->rw['sis_enc']); ?> 
          <?php echo HTML_inp_tx('sis_tt', TX_NM, ctjTx($___Ls->dt->rw['sis_tt'],'in'), FMRQD); ?>
          <?php echo HTML_inp_tx('sis_var', TX_VAR, ctjTx($___Ls->dt->rw['sis_var'],'in'), FMRQD); ?><?php echo HTML_inp_tx('sis_vl', TX_VLE, ctjTx($___Ls->dt->rw['sis_vl'],'in'), FMRQD); ?>
          <?php if($___Ls->dt->rw['sis_var'] == 'E_TAG'){ echo Enc_Rnd(SIS_TT.Gn_Rnd().E_TAG); } ?>
        </div>
      </div>
    </form>
  </div>
</div>
<?php } ?>
<?php } ?>