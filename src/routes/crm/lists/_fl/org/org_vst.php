<?php if(class_exists('CRM_Cnx')){

	$___Ls->new->big = 'ok';
	$___Ls->edit->big = 'ok';
	$___Ls->cnx->cl = 'ok';

	$___Ls->_strt();
	$__tb = Php_Ls_Cln($_GET['Tb']);

	if(!isN($___Ls->gt->i)){

		$___Ls->qrys = sprintf("SELECT * FROM ".TB_ORG_VST." WHERE ".$___Ls->ik." = %s LIMIT 1", GtSQLVlStr($___Ls->gt->i, "text"));

	}elseif($___Ls->_show_ls == 'ok'){ 

		$Ls_Whr = "
			FROM ".TB_ORG_VST."
				INNER JOIN "._BdStr(DBM).TB_US." ON orgvst_us = id_us
				INNER JOIN "._BdStr(DBM).TB_ORG." ON id_org = orgvst_org
				INNER JOIN ".TB_CNT." ON orgvst_cnt = id_cnt
			WHERE ".$___Ls->ino." != '' ".$___Ls->sch->cod." $_fl
				ORDER BY ".$___Ls->ino." DESC
		";
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
				<th width="25%" <?php echo NWRP ?>><?php echo TX_RS ?></th>
				<th width="25%" <?php echo NWRP ?>><?php echo TX_NM ?></th>
				<th width="10%" <?php echo NWRP ?>><?php echo TX_F ?></th>
				<th width="10%" <?php echo NWRP ?>><?php echo TX_S ?></th>
				<th width="1%" <?php echo NWRP ?>></th>
				<!-- <th width="1%" <?php echo NWRP ?>></th> -->
			</tr>
			<?php do {  ?>
				<tr>  
					<td width="1%" align="left" <?php echo $_clr_rw ?>><?php echo ctjTx($___Ls->ls->rw['id_orgvst'],'in'); ?></td>
					<td width="25%" align="left" <?php echo $_clr_rw ?>><?php echo ctjTx($___Ls->ls->rw['org_nm'] ,'in'); ?></td>
					<td width="25%" align="left" <?php echo $_clr_rw ?>><?php echo ctjTx($___Ls->ls->rw['cnt_nm']." ".$___Ls->ls->rw['cnt_ap'],'in'); ?></td>
					<td width="10%" align="left" <?php echo $_clr_rw ?>><?php echo ctjTx($___Ls->ls->rw['orgvst_fi'],'in'); ?></td>
					<td align="10%" <?php echo $_clr_rw ?>><?php echo'Estable'; ?></td>
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
					$__tabs = [
						['n'=>'rsl_vst',  'l'=>'Resultado Visita']
					];
					$___Ls->_dvlsfl_all($__tabs, [ 'idb'=>'ok' ]);
				?>
				<form method="POST" name="<?php echo $___Ls->fm->id; ?>" target="_self" id="<?php echo $___Ls->fm->id; ?>" >
				<?php $___Ls->_bld_f_hdr(); ?>
					<div id="<?php echo $___Ls->fm->fld->id ?>" class="<?php echo DV_GNR_FM_CMP ?> lead_data"> 
						<div id="<?php echo $___Ls->tab->id ?>" class="VTabbedPanels TbGnrl mny  <?php if($___Ls->dt->tot == 0){ echo '_new'; } ?>">
							<ul class="TabbedPanelsTabGroup" style="display:block ">
								<?php echo $___Ls->tab->bsc->l ?>
								<?php echo $___Ls->tab->rsl_vst->l ?>
							</ul>
							<div class="TabbedPanelsContentGroup">
								<div class="TabbedPanelsContent">
									<div class="ln_1">  	
										<div class="col_1">
											<?php 
												echo h2(TX_DTSBSC);
												echo LsUs('orgvst_us','id_us', $___Ls->dt->rw['orgvst_us'], '', 2); $CntWb .= JQ_Ls('orgvst_us','');
												
												echo LsOrgCnt([
													'id'=>'orgvst_cnt', 
													'v'=>'id_orgsdscnt', 
													'va'=>$___Ls->dt->rw['orgvst_cnt'], 
													'id_org'=>$___Ls->gt->isb,
													'rq'=>1 
												]); $CntWb .= JQ_Ls('orgvst_cnt',FM_LS_SLCD);

												echo SlDt([ 'id'=>'orgvst_f', 'va'=>$___Ls->dt->rw['orgvst_f'], 'rq'=>'no', 'ph'=>'Fecha Programada', 'lmt'=>'no', 'yr'=>'ok', 'cls'=>CLS_CLND ]);
												echo SlDt([ 'id'=>'orgvst_h', 'va'=>$___Ls->dt->rw['orgvst_h'], 'rq'=>'no', 'ph'=>'Hora Programada', 'lmt'=>'no', 't'=>'hr', 'cls'=>CLS_CLND ]);
												
												$l = __Ls(['k'=>'vst_tp',
													'id'=>'orgvst_tp',
													'ph'=>'Tipo de visita',
													'va'=>$___Ls->dt->rw['orgvst_tp']
												]); echo $l->html; $CntWb .= $l->js;

												$l = __Ls(['k'=>'vst_est',
													'id'=>'orgvst_est',
													'ph'=>'Estado de visita',
													'va'=>$___Ls->dt->rw['orgvst_est']
												]); echo $l->html; $CntWb .= $l->js;
											?>
										</div>	
										<div class="col_2"> 
											<?php 
												echo HTML_textarea('orgvst_obs', TX_OBS, ctjTx($___Ls->dt->rw['orgvst_obs'],'in'), '', 'ok');
												echo OLD_HTML_chck('orgvst_pln', FM_LS_SLPLN, $___Ls->dt->rw['orgvst_pln'], 'in');
												echo OLD_HTML_chck('orgvst_rxc', TX_RXC, $___Ls->dt->rw['orgvst_rxc'], 'in');
												echo OLD_HTML_chck('orgvst_grn', TX_VGRN, $___Ls->dt->rw['orgvst_grn'], 'in');	
											?>   
										</div>
									</div>    
								</div>
								<div class="TabbedPanelsContent">
									<div class="ln_1">
										<div class="col_1">
											<?php if($___Ls->dt->rw['orgvst_fr'] != ''){ $_f_df = $___Ls->dt->rw['orgvst_fr']; }else{ $_f_df = $___Ls->dt->rw['orgvst_f']; } ?>
											<?php echo SlDt([ 'id'=>'orgvst_fr', 'va'=>$_f_df, 'rq'=>'no', 'ph'=>TX_FRL, 'lmt'=>'no', 'yr'=>'ok', 'cls'=>CLS_CLND ]); ?>
											<?php if($___Ls->dt->rw['orgvst_hr'] != ''){ $_h_df = $___Ls->dt->rw['orgvst_hr']; }else{ $_h_df = $___Ls->dt->rw['orgvst_h']; } ?>
											<?php echo SlDt([ 'id'=>'orgvst_hr', 'va'=>$_h_df, 'rq'=>'no', 'ph'=>TX_FRL, 't'=>'hr', 'lmt'=>'no', 'yr'=>'ok', 'cls'=>CLS_CLND ]); ?> 

											<?php 
												$l = __Ls(['k'=>'vst_aplz', 'id'=>'orgvst_aplz', 'va'=>$___Ls->dt->rw['orgvst_aplz'] , 'ph'=>FM_LS_SLMAPLZ]); 
												echo $l->html; $CntWb .= $l->js;    		
											?>
										</div>
										<div class="col_2">
											<?php echo HTML_textarea('orgvst_rsl', TX_RVST, ctjTx($___Ls->dt->rw['orgvst_rsl'],'in'), '', 'ok'); ?>
											<?php echo OLD_HTML_chck('orgvst_tra', TX_GNTRA, $___Ls->dt->rw['orgvst_tra'], 'in');?>	
											<?php echo OLD_HTML_chck('orgvst_ofr', TX_GNOFR, $___Ls->dt->rw['orgvst_ofr'], 'in'); ?>

											<?php echo HTML_inp_hd('orgvst_org', $___Ls->gt->isb); ?>
										</div>  
									</div> 
								</div>     
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	<?php } ?>
<?php } ?>