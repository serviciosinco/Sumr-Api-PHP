<?php 
if(class_exists('CRM_Cnx')){
	
	$___Ls->tt = MDL_TEX;
	$___Ls->sch->f = 'sistex_tt, sistex_dsc, sistex_var, sistex_vl_es, sistex_vl_en, sistex_vl_it, sistex_vl_fr, sistex_vl_gr, sistex_vl_krn, sistex_vl_jpn, sistex_vl_ptg, sistex_vl_mdn';
	
	$___Ls->new->w = 600;
	$___Ls->new->h = 600;
	
	$___Ls->_strt();
	
	if($__t == 'cl_tex'){ 
		$___Ls->cnx->cl = 'ok';
		$__bd = 'sis_tx';
	}else{
		$__bd = MDL_SIS_TEX_BD;
	}                   
	
	if(!isN($___Ls->gt->i)){	
		$___Ls->qrys = sprintf("SELECT * FROM $__bd WHERE ".$___Ls->ik." = %s LIMIT 1", GtSQLVlStr($___Ls->gt->i, "text"));
	}elseif($___Ls->_show_ls == 'ok'){
		$Ls_Whr = "FROM $__bd WHERE ".$___Ls->ino." != '' ".$___Ls->sch->cod." ORDER BY id_sistex DESC";
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
					<th width="10%" <?php echo NWRP ?>><?php echo TX_NM ?></th>
					<?php if(ChckSESS_superadm()){ ?>
						<th width="10%" <?php echo NWRP ?>><?php echo TX_VAR ?></th>
					<?php } ?>
					<th width="10%" <?php echo NWRP ?>><?php echo TX_VLE_ES ?></th>
					<th width="10%" <?php echo NWRP ?>><?php echo TX_VLE_EN ?></th>
					<th width="1%" <?php echo NWRP ?>></th>
				</tr>
			<?php do { ?>
				<tr>         
					<td width="1%" <?php echo NWRP ?>><?php echo Spn($___Ls->ls->rw[$___Ls->ino]); ?></td>
					<td width="10%" align="left" nowrap="nowrap"><?php echo ShortTx(ctjTx($___Ls->ls->rw['sistex_tt'],'in'),40,'Pt', true); ?></td>
					<?php if(ChckSESS_superadm()){ ?>
						<td width="10%" align="left" nowrap="nowrap"><?php echo ShortTx(ctjTx($___Ls->ls->rw['sistex_var'],'in'),40,'Pt', true); ?></td>
					<?php } ?>
					<td width="10%" align="left" nowrap="nowrap"><?php echo ShortTx(strip_tags(ctjTx($___Ls->ls->rw['sistex_vl_es'],'in')),30,'Pt', true); ?></td>
					<td width="10%" align="left" nowrap="nowrap"><?php echo ShortTx(strip_tags(ctjTx($___Ls->ls->rw['sistex_vl_en'],'in')),30,'Pt', true); ?></td>
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
				<form method="POST" name="<?php echo $___Ls->fm->id; ?>" target="_self" id="<?php echo $___Ls->fm->id; ?>">
				<?php $___Ls->_bld_f_hdr(); ?>      
	
					<div id="<?php echo $___Ls->fm->fld->id ?>" class="<?php echo DV_GNR_FM_CMP ?>">

						<div class="ln_1">
							<div class="col_1"> <?php echo HTML_inp_tx('sistex_tt', TX_NM, ctjTx($___Ls->dt->rw['sistex_tt'],'in'), FMRQD); ?>
							<?php 
								if(ChckSESS_superadm()){ 
									echo HTML_inp_tx('sistex_var', TX_VAR, ctjTx($___Ls->dt->rw['sistex_var'],'in'), FMRQD); 
								}else{ ?>
								<input name="tex_var" id="tex_var" type="hidden" value="<?php echo ctjTx($___Ls->dt->rw['sistex_var'],'in'); ?>" />
							<?php } ?>
								<?php echo HTML_inp_tx('sistex_dsc', TX_DSC, ctjTx($___Ls->dt->rw['sistex_dsc'],'in')); ?> 
								<?php echo LsTexTp('sistex_tp','id_textp', $___Ls->dt->rw['sistex_tp'], '', 2); $CntWb .= JQ_Ls('sistex_tp',FM_LS_SLTP); ?> 
							</div>
							<div class="col_2">
								<?php if($___Ls->dt->rw['sistex_tp'] == 2){ ?>
									<?php echo HTML_textarea('sistex_vl_es', TX_VLE_ES, ctjTx($___Ls->dt->rw['sistex_vl_es'],'in'), FMRQD, 'ok'); ?> 
									<?php echo HTML_textarea('sistex_vl_en', TX_VLE_EN, ctjTx($___Ls->dt->rw['sistex_vl_en'],'in')); ?> 
									<?php echo HTML_textarea('sistex_vl_it', TX_VLE_IT, ctjTx($___Ls->dt->rw['sistex_vl_it'],'in')); ?> 
									<?php echo HTML_textarea('sistex_vl_fr', TX_VLE_FR, ctjTx($___Ls->dt->rw['sistex_vl_fr'],'in')); ?> 
									<?php echo HTML_textarea('sistex_vl_gr', TX_VLE_GR, ctjTx($___Ls->dt->rw['sistex_vl_gr'],'in')); ?>
									<?php echo HTML_textarea('sistex_vl_krn', TX_VLE_KRN, ctjTx($___Ls->dt->rw['sistex_vl_krn'],'in')); ?>
									<?php echo HTML_textarea('sistex_vl_jpn', TX_VLE_JPN, ctjTx($___Ls->dt->rw['sistex_vl_jpn'],'in')); ?>
									<?php echo HTML_textarea('sistex_vl_ptg', TX_VLE_PTG, ctjTx($___Ls->dt->rw['sistex_vl_ptg'],'in')); ?>
									<?php echo HTML_textarea('sistex_vl_mdn', TX_VLE_MDN, ctjTx($___Ls->dt->rw['sistex_vl_mdn'],'in')); ?>
							<?php }else{ ?>
								<?php echo HTML_inp_tx('sistex_vl_es', TX_VLE_ES, ctjTx($___Ls->dt->rw['sistex_vl_es'],'in'), FMRQD); ?> 
								<?php echo HTML_inp_tx('sistex_vl_en', TX_VLE_EN, ctjTx($___Ls->dt->rw['sistex_vl_en'],'in')); ?> 
								<?php echo HTML_inp_tx('sistex_vl_it', TX_VLE_IT, ctjTx($___Ls->dt->rw['sistex_vl_it'],'in')); ?> 
								<?php echo HTML_inp_tx('sistex_vl_fr', TX_VLE_FR, ctjTx($___Ls->dt->rw['sistex_vl_fr'],'in')); ?> 
								<?php echo HTML_inp_tx('sistex_vl_gr', TX_VLE_GR, ctjTx($___Ls->dt->rw['sistex_vl_gr'],'in')); ?>
								<?php echo HTML_inp_tx('sistex_vl_krn', TX_VLE_KRN, ctjTx($___Ls->dt->rw['sistex_vl_krn'],'in')); ?>
								<?php echo HTML_inp_tx('sistex_vl_jpn', TX_VLE_JPN, ctjTx($___Ls->dt->rw['sistex_vl_jpn'],'in')); ?>
								<?php echo HTML_inp_tx('sistex_vl_ptg', TX_VLE_PTG, ctjTx($___Ls->dt->rw['sistex_vl_ptg'],'in')); ?>
								<?php echo HTML_inp_tx('sistex_vl_mdn', TX_VLE_MDN, ctjTx($___Ls->dt->rw['sistex_vl_mdn'],'in')); ?>
							<?php } ?>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	<?php } ?>
<?php } ?>