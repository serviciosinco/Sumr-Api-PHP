<?php 

if(class_exists('CRM_Cnx') && SISUS_ID == 163){
  
    $___Ls->sch->f = 'sis_tt, sis_var, sis_vl';
    $___Ls->ino = 'id_apirq';
    $___Ls->ik = 'apirq_enc';
    
    $___Ls->new->big= 'ok';
	
	  $___Ls->_strt();
	
	  if(!isN($___Ls->gt->i)){	
		
		    $___Ls->qrys = sprintf("SELECT apirq_raw, apirq_post, apirq_get, apirq_rsp FROM sumr_bd._api_rq WHERE ".$___Ls->ik." = %s LIMIT 1", GtSQLVlStr($___Ls->gt->i, "text"));

	  }elseif($___Ls->_show_ls == 'ok'){ 	

		    $Ls_Whr = "FROM sumr_bd._api_rq WHERE ".$___Ls->ino." != '' ".$___Ls->sch->cod." ORDER BY ".$___Ls->ino." DESC";
        $___Ls->qrys = "SELECT id_apirq, apirq_enc, apirq_e, apirq_tp, apirq_fi, (SELECT COUNT(*) $Ls_Whr) AS ".QRY_RGTOT." $Ls_Whr";
    
    } 
	
	  $___Ls->_bld();
?>
<?php if($___Ls->ls->chk=='ok'){ ?>
<?php if(($___Ls->qry->tot > 0)){ ?>

<table width="100%" border="0" cellpadding="0" cellspacing="0" class="Ls_Rg">
  <tr>
    <th width="1%" <?php echo NWRP ?>><?php echo TX_FM_No ?></th>
    <th width="33%" <?php echo NWRP ?>><?php echo TX_EST ?></th>
    <th width="33%" <?php echo NWRP ?>><?php echo TX_TP ?></th>
    <th width="33%" <?php echo NWRP ?>><?php echo TX_FI ?></th>
    <th width="1%" <?php echo NWRP ?>></th>
  </tr>
  <?php do { ?>
   <tr>   
    <td width="1%" <?php echo NWRP ?>><?php echo Spn($___Ls->ls->rw[$___Ls->ino]); ?></td>
    <td width="33%" align="left" nowrap="nowrap"><?php echo Spn(mBln($___Ls->ls->rw['apirq_e']),'',mBln($___Ls->ls->rw['apirq_e'])); ?></td>
    <td width="33%" align="left" nowrap="nowrap"><?php echo ShortTx(ctjTx($___Ls->ls->rw['apirq_tp'],'in'),40,'Pt', true); ?></td>
    <td width="33%" align="left" nowrap="nowrap"><?php echo ShortTx(ctjTx($___Ls->ls->rw['apirq_fi'],'in'),40,'Pt', true); ?></td>
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
	  <div id="<?php echo $___Ls->fm->fld->id ?>" class="<?php echo DV_GNR_FM_CMP ?>">
        <div class="ln_1">
            <?php echo h2('Raw'); ?>
            <?php echo $___Ls->dt->rw['apirq_raw']; ?>
            <?php echo h2('Post'); ?>
            <?php echo $___Ls->dt->rw['apirq_post']; ?>
            <?php echo h2('Get'); ?>
            <?php echo $___Ls->dt->rw['apirq_get']; ?>
            <?php echo h2('Respuesta'); ?>
            <?php echo $___Ls->dt->rw['apirq_rsp']; ?>
        </div>
      </div>
    </form>
  </div>
</div>
<?php } ?>
<?php } ?>