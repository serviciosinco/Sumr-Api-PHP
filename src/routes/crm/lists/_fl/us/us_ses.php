<?php
if(class_exists('CRM_Cnx')){
	
	$___Ls->tt = MDL_US_RG;
	$___Ls->sch->ino = 'id_uses';
	$___Ls->sch->f = 'us_nm, us_ap, uses_b_v, uses_ip';
	
	
	if(_Chk_GET('fl_usesus')){ $__fl .= _AndSql('uses_us', $_GET['fl_usesus']); }
	

	if(!isN($___Ls->gt->i)){	
		
		$___Ls->qrys = sprintf("SELECT * FROM ".MDL_US_SES_BD." WHERE ".$___Ls->ik." = %s LIMIT 1", GtSQLVlStr($___Ls->gt->i, "text"));
		
	}elseif($___Ls->_show_ls == 'ok'){ 
		
		$Ls_Whr = "	FROM ".MDL_US_SES_BD."
						 INNER JOIN ".TB_US." ON uses_us = id_us 
					WHERE ".$___Ls->ino." != '' $__fl ".$___Ls->sch->cod." 
					ORDER BY ".$___Ls->ino." DESC";
					
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
    <th width="30%" <?php echo NWRP ?>><?php echo TX_USR ?></th>
    <th width="30%" <?php echo NWRP ?>><?php echo TX_IP ?></th>
    <th width="9%" <?php echo NWRP ?>><?php echo TX_F ?></th>
    <th width="9%" <?php echo NWRP ?>><?php echo TX_HR ?></th>
    <th width="1%" <?php echo NWRP ?>></th>
  </tr>
  <?php do { ?>

  <tr>
    <td width="1%" <?php echo NWRP ?>><?php echo Spn($___Ls->ls->rw[$___Ls->ino]); ?></td>

    <td width="30%" align="left" nowrap="nowrap"><?php echo ShortTx(ctjTx($___Ls->ls->rw['us_nm'].' '.$___Ls->ls->rw['us_ap'],'in'),100,'Pt', true); ?></td>
    <td width="30%" align="left" nowrap="nowrap"><?php echo ShortTx(ctjTx($___Ls->ls->rw['uses_ip'],'in'),100,'Pt', true); ?></td>
    <td width="9%" align="left" nowrap="nowrap"><?php echo Spn(ShortTx(ctjTx($___Ls->ls->rw['uses_f'],'in'),40,'Pt', true),'','_f'); ?></td>
    <td width="9%" align="left" nowrap="nowrap"><?php echo Spn(ShortTx(ctjTx($___Ls->ls->rw['uses_h'],'in'),40,'Pt', true),'','_f'); ?></td>

    <td width="1%" align="left" nowrap="nowrap" class="_btn"><?php echo $___Ls->_btn([ 't'=>'mod' ]); ?></td>
  </tr>
  <?php } while ($___Ls->ls->rw = $___Ls->sql->fetch_assoc()); ?>
</table>
<?php $___Ls->_bld_l_pgs(); ?>
<?php } ?>

<?php $___Ls->_h_ls_nr(); ?>
<?php } ?>

<?php } ?>
