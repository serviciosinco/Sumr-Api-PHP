<?php
if(class_exists('CRM_Cnx')){
	
	$___Ls->_strt(); 
	
	if(!isN($___Ls->gt->i)){	
		$___Ls->qrys = sprintf("SELECT *
			FROM ".TB_CL_DMN."
			WHERE ".$___Ls->ik." = %s 
			LIMIT 1", GtSQLVlStr($___Ls->gt->i, "text"));
	}elseif($___Ls->_show_ls == 'ok'){ 
		$Ls_Count = "	
			(	SELECT COUNT(*) FROM 
			".TB_CL_DMN." 
			WHERE ".$___Ls->ino." != '' AND cldmn_cl = (SELECT id_cl FROM ".TB_CL." WHERE cl_enc = '$__i') ".$___Ls->sch->cod." 
			ORDER BY ".$___Ls->ino." DESC	
			) AS ".QRY_RGTOT;
			
		$___Ls->qrys = "	SELECT *, ".$Ls_Count."
			FROM 
			".TB_CL_DMN." 	
			WHERE ".$___Ls->ino." != '' AND cldmn_cl = (SELECT id_cl FROM ".TB_CL." WHERE cl_enc = '$__i') ".$___Ls->sch->cod." 
			ORDER BY ".$___Ls->ino." DESC";	
	} 

	$___Ls->_bld();

?>
	
	<?php if($___Ls->ls->chk=='ok'){ ?>
		<?php $___Ls->_bld_l_hdr(); ?>
		<?php if(($___Ls->qry->tot > 0)){ ?>
			<table width="100%" border="0" cellpadding="0" cellspacing="0" class="Ls_Rg">
				<tr>
					<th width="1%" <?php echo NWRP ?>><?php echo TX_FM_No ?></th>
					<th width="20%" <?php echo NWRP ?>><?php echo TX_DMNS ?></th>
					<th width="1%" <?php echo NWRP ?>></th>
				</tr>
				<?php do { ?>
				<tr>
					<td width="1%" <?php echo NWRP ?>><?php echo Spn($___Ls->ls->rw[$___Ls->ino]); ?></td>
					<td width="20%" align="left" nowrap="nowrap"><?php echo ctjTx($___Ls->ls->rw['cldmn_dmn'],'in'); ?></td> 
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
			<?php 
			$__idtp_bsc = '_bsc'.$___Ls->id_rnd;
			$__idtp_sub = '_sub'.$___Ls->id_rnd;
			$__tabs = [
				['n'=>'dmnsub', 't'=>'cl_dmn_sub', 'l'=>TX_EMAIL]
			];
			$___Ls->_dvlsfl_all($__tabs);
			?>
			<form method="POST" name="<?php echo $___Ls->fm->id; ?>" target="_self" id="<?php echo $___Ls->fm->id; ?>" >
				<?php $___Ls->_bld_f_hdr(); ?>
				<div id="<?php echo $___Ls->fm->fld->id ?>" class="<?php echo DV_GNR_FM_CMP ?> lead_data"> 
					<?php $_id_tbpnl = 'TabPnl_'.Gn_Rnd(20); $CntWb .= "SUMR_Main.bxajx.".$_id_tbpnl." = new Spry.Widget.TabbedPanels('".$_id_tbpnl."' {$_tb_dfl}); "; $CntWb .= _DvLsFl([ 'i'=>$___Ls->tb->eml ]);  ?>
					<?php echo HTML_inp_hd('cldmn_cl', $__i); ?>
					<div id="<?php echo $_id_tbpnl ?>" class="VTabbedPanels TbGnrl mny lead_data_tb">
						<ul class="TabbedPanelsTabGroup">
							<?php echo $___Ls->tab->bsc->l ?>
							<?php echo $___Ls->tab->dmnsub->l ?> 
						</ul>
						<div class="TabbedPanelsContentGroup">
							<div class="TabbedPanelsContent">
								<div class="ln_1">  	
									<div class="col_1"> 
										<?php if($_bxpop == 'ok'){ ?><input id="___pop" name="___pop" type="hidden" value="ok" /><?php } ?>
										<?php echo HTML_inp_tx('cldmn_dmn', TX_VLR , ctjTx($___Ls->dt->rw['cldmn_dmn'],'in'), FMRQD); ?>                                       
									</div>
									<div class="col_2"></div>
								</div>    
							</div>
							<div class="TabbedPanelsContent">
								<!-- Inicia Documentos -->
								<div class="ln">
									<?php echo $___Ls->tab->dmnsub->d ?>
								</div> 
								<!-- Finaliza Documentos -->
							</div>      
						</div>
					</div>
				</div>

			</form>
		</div>
	</div>
	<?php } ?>
<?php } ?>