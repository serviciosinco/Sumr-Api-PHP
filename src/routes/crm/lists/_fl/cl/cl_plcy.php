<?php
if(class_exists('CRM_Cnx')){

	$___Ls->sch->f = 'clplcy_nm, clplcy_tx, clplcy_lnk, clplcy_lnk_tt';
	
	$___Ls->new->w = 800;
	$___Ls->new->h = 400;
	$___Ls->edit->w = 800;
	$___Ls->edit->h = 400;
	
	$___Ls->_strt();
	
	if(!isN($___Ls->gt->i)){	
	
		$___Ls->qrys = sprintf("SELECT * FROM ".TB_CL_PLCY." WHERE ".$___Ls->ik." = %s LIMIT 1", GtSQLVlStr($___Ls->gt->i, "text"));
	
	}elseif($___Ls->_show_ls == 'ok'){  
	
		$Ls_Whr = "	FROM "._BdStr(DBM).TB_CL_PLCY."
						 INNER JOIN "._BdStr(DBM).TB_CL." ON clplcy_cl = id_cl 
					WHERE  ".$___Ls->ino." != '' ".$___Ls->sch->cod." AND cl_enc = '".DB_CL_ENC."'
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
				<th width="35%" <?php echo NWRP ?>><?php echo TT_FM_NM ?></th>
				<th width="30%" <?php echo NWRP ?>><?php echo TX_ACTV ?></th>
				<th width="30%" <?php echo NWRP ?>><?php echo TX_PC ?></th>
				<th width="1%" <?php echo NWRP ?>></th>
			</tr>
			<?php do { ?>
				<tr>    
					<td width="1%" <?php echo NWRP ?>><?php echo Spn($___Ls->ls->rw[$___Ls->ino]); ?></td>
					<td width="35%" align="left" nowrap="nowrap"><?php echo ShortTx(ctjTx($___Ls->ls->rw['clplcy_nm'],'in'),40,'Pt', true); ?></td>
					<td width="30%" align="left" nowrap="nowrap"><?php echo Spn(mBln($___Ls->ls->rw['clplcy_e']),'',mBln($___Ls->ls->rw['clplcy_e'])); ?></td>
					<td width="30%" align="left" nowrap="nowrap"><?php echo Spn(mBln($___Ls->ls->rw['clplcy_main']),'',mBln($___Ls->ls->rw['clplcy_main'])); ?></td>
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
				<form method="POST" name="<?php echo $___Ls->fm->id; ?>" target="_self" id="<?php echo $___Ls->fm->id; ?>">
					<?php $___Ls->_bld_f_hdr(); ?>   
					<div id="<?php echo $___Ls->fm->fld->id ?>" class="<?php echo DV_GNR_FM_CMP ?>"> 
						<div class="ln_1">
							<div class="col_1">
								<?php echo HTML_inp_tx('clplcy_nm', TT_FM_NM , ctjTx($___Ls->dt->rw['clplcy_nm'],'in'), FMRQD); ?>
								<?php //echo HTML_inp_tx('clplcy_tx', TX_TXT , ctjTx($___Ls->dt->rw['clplcy_tx'],'in'), FMRQD); ?>  
								<?php echo HTML_textarea('clplcy_tx', TX_LNK, ctjTx($___Ls->dt->rw['clplcy_tx'],'in'), '', 'ok'); ?>  
								<?php echo HTML_inp_tx('clplcy_lnk', TX_LNK , ctjTx($___Ls->dt->rw['clplcy_lnk'],'in'), FMRQD); ?> 
								<?php echo HTML_inp_tx('clplcy_lnk_tt', TX_LNK.' (Link)' , ctjTx($___Ls->dt->rw['clplcy_lnk_tt'],'in')); ?> 
							</div>
							<div class="col_2">
								<?php echo HTML_inp_tx('clplcy_v', 'Valor' , ctjTx($___Ls->dt->rw['clplcy_v'],'in'), FMRQD); ?> 
								<?php echo OLD_HTML_chck('clplcy_e', TX_ACTV, $___Ls->dt->rw['clplcy_e'], 'in'); ?>
								<?php echo OLD_HTML_chck('clplcy_main', TX_PC, $___Ls->dt->rw['clplcy_main'], 'in').HTML_BR; ?>
								<?php echo LsEc('clplcy_ec','id_ec', $___Ls->dt->rw['clplcy_ec'], '', '2', '' ); ?>
	                        	<?php $CntWb .= JQ_Ls('clplcy_ec',FM_LS_TRSTP); ?>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	<?php } ?>
<?php } ?> 