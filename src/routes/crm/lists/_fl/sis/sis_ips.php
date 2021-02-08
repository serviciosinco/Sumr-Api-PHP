<?php
if(class_exists('CRM_Cnx')){
	
	$___Ls->sch->f = 'ip_ip';
	$__bd = MDL_SIS_IPS_BD
	
	if(!isN($___Ls->gt->i)){
		
		$___Ls->qrys = sprintf("SELECT * FROM $__bd  WHERE ".$___Ls->ik." = %s LIMIT 1", GtSQLVlStr($___Ls->gt->i, "text"));
		
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
		<th width="60%" <?php echo NWRP ?>><?php echo TX_IP ?></th>
		<th width="60%" <?php echo NWRP ?>><?php echo TX_APRB ?></th>
		<th width="60%" <?php echo NWRP ?>><?php echo TX_FING ?></th>
		<th width="60%" <?php echo NWRP ?>><?php echo TX_FACT ?></th>
		<th width="1%" <?php echo NWRP ?>></th>
  	</tr>
  	<?php do { ?>
  	<tr>
    	<td width="1%" <?php echo NWRP ?>><?php echo Spn($___Ls->ls->rw[$___Ls->ino]); ?></td>
		<td width="20%" align="left" nowrap="nowrap"><?php echo ShortTx(ctjTx($___Ls->ls->rw['ip_ip'],'in'),150,'Pt', true); ?></td>
		<td width="1%" align="left" <?php echo $_clr_rw ?>><?php echo _sino($___Ls->ls->rw['ip_est']); ?></td>
		<?php 
          	$___date = date_create($___Ls->ls->rw['ip_fi']);  	
          	$___fecha=date_format($___date, 'Y-m-d');
          	$___hora=date_format($___date, 'h:i:s');

		  	$___date = date_create($___Ls->ls->rw['ip_fa']);  	
          	$___fact=date_format($___date, 'Y-m-d');
          	$___hact=date_format($___date, 'h:i:s');
		?>
		<td width="20%" align="left" nowrap="nowrap"><?php echo $___fecha.'-'.Spn($___hora,'', '_f'); ?></td>
		<td width="20%" align="left" nowrap="nowrap"><?php echo $___fact.'-'.Spn($___hact,'', '_f'); ?></td>
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
					<?php
						echo HTML_inp_tx('ip_enc', TX_COD , ctjTx($___Ls->dt->rw['ip_enc'],'in')); 
						echo HTML_inp_tx('ip_ip', TX_IP , ctjTx($___Ls->dt->rw['ip_ip'],'in') ); 
						echo HTML_inp_tx('ip_p', TX_EQP , ctjTx($___Ls->dt->rw['ip_p'],'in') ); 
						echo HTML_inp_tx('ip_b', TX_NVGDR , ctjTx($___Ls->dt->rw['ip_b'],'in') ); 
						echo h2(Spn('','','_tt_icn _tt_icn_chck' ).MDL_CHCK.HTML_BR.HTML_BR.HTML_BR.TX_ETD);                                                                 
						echo OLD_HTML_chck('ip_est', TX_APRBD, $___Ls->dt->rw['ip_est'] );
		            ?>
		          	</div>
				  	<div class="col_2">	   
				  	<?php 
					  	echo HTML_inp_tx('ip_v', '', ctjTx($___Ls->dt->rw['ip_v'],'in') ); 
					  	echo HTML_inp_tx('ip_d', '' , ctjTx($___Ls->dt->rw['ip_d'],'in') ); 
				    ?>
		          	</div>
		        </div>
      		</div>
    	</form>
  	</div>
</div>
<?php } ?>
<?php } ?>
