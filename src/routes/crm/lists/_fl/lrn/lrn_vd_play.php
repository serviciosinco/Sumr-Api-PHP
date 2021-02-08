<?php
if(class_exists('CRM_Cnx')){
	
	$___Ls->tt = _Cns('TX_VD');
	$___Ls->_strt();
	
	if(!isN($___Ls->gt->i)){	
		 
		$___Ls->qrys = sprintf("SELECT *
								FROM  ".TB_LRN_VD_PLAY."
								WHERE ".$___Ls->ik." = %s 
								LIMIT 1", GtSQLVlStr($___Ls->gt->i, "text")
							);
		
	}elseif($___Ls->_show_ls == 'ok'){
		
		$_fl = " AND lrnvdplay_lrnvd IN ( SELECT id_lrnvd FROM ".TB_LRN_VD." WHERE lrnvd_lrn IN (SELECT id_lrn FROM ".TB_LRN." WHERE lrn_enc = '{$__i}') ) ";
		$Ls_Whr = "	FROM ".TB_LRN_VD_PLAY."
					INNER JOIN ".TB_LRN_VD." ON id_lrnvd = lrnvdplay_lrnvd
					INNER JOIN ".TB_US." ON id_us = lrnvdplay_us
					WHERE ".$___Ls->ino." != '' $_fl
					ORDER BY ".$___Ls->ino." DESC";
		$___Ls->qrys = "SELECT *,
				   		(SELECT COUNT(*) $Ls_Whr) AS ".QRY_RGTOT." $Ls_Whr";
		
	} 

	$___Ls->_bld();
?>
<?php if($___Ls->ls->chk=='ok'){ ?>

	<?php $___Ls->_bld_l_hdr(); ?>
	<?php if(($___Ls->qry->tot > 0)){  ?>
	
		<table width="100%" border="0" cellpadding="0" cellspacing="0" class="Ls_Rg">
			<tr>
			    <th width="1%" <?php echo NWRP ?>><?php echo TX_FM_No ?></th>
	            <th width="30%" <?php echo NWRP ?>><?php echo TX_VD ?></th>
	            <th width="30%" <?php echo NWRP ?>><?php echo TX_US ?></th>
	            <th width="10%" <?php echo NWRP ?>><?php echo TX_FI ?></th>
			</tr>
			<?php do {  ?>
		  		<tr>  
					<td align="left" width="1%"><?php echo $___Ls->ls->rw[$___Ls->ino]; ?></td>
			        <td width="30%" align="left"><?php echo ctjTx($___Ls->ls->rw['lrnvd_tt'],'in'); ?></td>
			        <td width="30%" align="left"><?php echo ctjTx($___Ls->ls->rw['us_nm']." ".$___Ls->ls->rw['us_ap'],'in'); ?></td>
					<td width="10%" align="left"><?php echo ctjTx($___Ls->ls->rw['lrnvdplay_fi'],'in'); ?></td>
				</tr>
		  	<?php } while ($___Ls->ls->rw = $___Ls->sql->fetch_assoc()); ?>
		</table>
		<?php $___Ls->_bld_l_pgs(); 
		
	}
	$___Ls->_h_ls_nr(); 
} ?>

<?php if($___Ls->fm->chk=='ok'){ ?>
<div class="FmTb">
  <div id="<?php echo $___Ls->fm->bx->id ?>" class="<?php echo DV_GNR_FM_BX ?>" >
  	<form method="POST" name="<?php echo $___Ls->fm->id; ?>" target="_self" id="<?php echo $___Ls->fm->id; ?>">

     	<?php $___Ls->_bld_f_hdr(); ?>
	 	<div id="<?php echo $___Ls->fm->fld->id ?>" class="<?php echo DV_GNR_FM_CMP ?>">

	    <div class="ln_1"></div>
      </div>
    </form>
  </div>
</div>
<?php } ?>
<?php } ?>
