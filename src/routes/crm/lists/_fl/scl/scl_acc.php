<?php
if(class_exists('CRM_Cnx')){

	$___Ls->_strt(); 
	
	if($___Ls->_show_ls == 'ok'){ 			
		$Ls_Whr = "FROM "._BdStr(DBT).TB_SCL_ACC;
		$___Ls->qrys = "SELECT * , 
							(SELECT COUNT(*) $Ls_Whr) AS ".QRY_RGTOT.", 
							( SELECT COUNT(*) FROM "._BdStr(DBT).TB_SCL_ACC_FORM." 
						WHERE id_sclacc = sclaccform_sclacc ) AS _tot $Ls_Whr ORDER BY _tot DESC";
	} 
	$___Ls->_bld();
	
	?>
	<?php if($___Ls->ls->chk=='ok'){ ?>
		<?php if(($___Ls->qry->tot > 0)){ ?>
			<table width="100%" border="0" cellpadding="0" cellspacing="0" class="Ls_Rg">
				<tr>
					<th width="1%" <?php echo NWRP ?>><?php echo TX_FM_No ?></th>
					<th width="20%" <?php echo NWRP ?>><?php echo TX_NM ?></th>
					<th width="20%" <?php echo NWRP ?>><?php echo TX_TOT.' (Forms)' ?></th>
				</tr>
				<?php do { ?>
				<tr>
					<td width="1%" <?php echo NWRP ?>><?php echo Spn($___Ls->ls->rw[$___Ls->ino]); ?></td>
					<td width="20%" align="left" nowrap="nowrap"><?php echo ShortTx(ctjTx($___Ls->ls->rw['sclacc_nm'],'in'),100,'Pt', true); ?></td>
					<td width="20%" align="left" nowrap="nowrap"><?php echo ShortTx(ctjTx($___Ls->ls->rw['_tot'],'in'),100,'Pt', true); ?></td>
				</tr>
				<?php } while ($___Ls->ls->rw = $___Ls->sql->fetch_assoc()); ?>
			</table>
			<?php $___Ls->_bld_l_pgs(); ?>
		<?php } ?>
		<?php $___Ls->_h_ls_nr(); ?>
	<?php } ?>
<?php } ?>