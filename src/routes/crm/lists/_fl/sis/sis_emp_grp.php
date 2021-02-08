<?php
if(class_exists('CRM_Cnx')){
	
	$___Ls->tt = MDL_EMP_GRP;
	$___Ls->ino = 'id_empgrp'
	$___Ls->cnx->cl = 'ok';
	$___Ls->img->dir = DIR_IMG_WEB_EMP;
	$___Ls->img->f = 'empgrp_logo';
	$___Ls->sch->f = 'empgrp_rs, empgrp_nit';
	$___Ls->_strt();
	
	if(!isN($___Ls->gt->i)){	
		
		$___Ls->qrys = sprintf("SELECT * FROM ".MDL_SIS_EMP_GRP_BD." WHERE ".$___Ls->ik." = %s LIMIT 1", GtSQLVlStr($___Ls->gt->i, "text"));
		$__tt_mre = ctjTx($___Ls->dt->rw['empgrp_rs'],'in'); 
		
	}else{ 

		$Ls_Whr = "FROM ".MDL_SIS_EMP_GRP_BD." WHERE ".$___Ls->ino." != '' $__fl ".$___Ls->sch->cod." ORDER BY ".$___Ls->ino." DESC";
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
	        <th width="0%" <?php echo NWRP ?>><?php echo TX_RS ?></th>
	        <th width="1%" <?php echo NWRP ?>><?php echo TX_FIN ?></th>
	        <th width="1%" <?php echo NWRP ?>><?php echo TX_FA ?></th>
	        <th width="1%" <?php echo NWRP ?>>&nbsp;</th>
      	</tr>
    </thead>
    <tbody>
      	<?php do { ?>
        <tr>
            <td align="left" <?php echo $_clr_rw ?>><?php echo $___Ls->ls->rw[$___Ls->ino]; ?></td>
            <td align="left" <?php echo $_clr_rw ?>><?php echo ctjTx($___Ls->ls->rw['empgrp_rs'],'in').HTML_BR.Spn(ctjTx($___Ls->ls->rw['empgrp_nit'],'in'),'','_f'); ?></td>
            <td width="1%" align="left" nowrap="nowrap" <?php echo $_clr_rw ?>><?php echo Spn($___Ls->ls->rw['empgrp_fi']) ?></td>
            <td width="1%" align="left" nowrap="nowrap" <?php echo $_clr_rw ?>><?php echo Spn($___Ls->ls->rw['empgrp_fa']) ?></td>
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
  <div id="<?php  echo DV_GNR_FM ?>">
    
    <form method="POST" name="<?php echo $___Ls->fm->id; ?>" target="_self" id="<?php echo $___Ls->fm->id; ?>">
       <?php $___Ls->_bld_f_hdr(); ?>
                   	
      <div id="<?php echo $___Ls->fm->fld->id ?>" class="<?php echo DV_GNR_FM_CMP ?>">
	  

        <div class="ln_1">         
              <div class="col_1"> 
                    <?php echo HTML_inp_tx('empgrp_nit', TX_NIT, ctjTx($___Ls->dt->rw['empgrp_nit'],'in'), FMRQD_NM); ?> 
              </div>
              <div class="col_2">
              		<?php echo HTML_inp_tx('empgrp_rs', TX_RS, ctjTx($___Ls->dt->rw['empgrp_rs'],'in')); ?>
              		<?php echo HTML_inp_clr(['id'=>'empgrp_clr', 'plc'=>TX_NM, 'vl'=>ctjTx($___Ls->dt->rw['empgrp_clr'],'in') ]); ?>
              		<?php //echo HTML_inp_clr('empgrp_clr', TX_NM, ctjTx($___Ls->dt->rw['empgrp_clr'],'in')); ?> 
               </div>
        </div> 
        
        
        
      </div>
    </form>
  </div>
  

</div>
<?php } ?>
<?php } 

?>

  