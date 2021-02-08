<?php
if(class_exists('CRM_Cnx')){

	$___Ls->cnx->cl = 'ok';
	$___Ls->sch->f = 'mdlctrl_tx';	
	$___Ls->img->dir = DMN_FLE_MDL;
	$___Ls->_strt();
    

	if(!isN($___Ls->gt->i)){
	
		$___Ls->qrys = sprintf("SELECT * FROM ".TB_MDL_CTRL." WHERE ".$___Ls->ik." = %s LIMIT 1", GtSQLVlStr($___Ls->gt->i, "text"));
	
	}elseif($___Ls->_show_ls == 'ok'){  

		$Ls_Whr = "	FROM ".TB_MDL_CTRL."
                        INNER JOIN ".TB_MDL." ON mdlctrl_mdl = id_mdl
                    WHERE 
                        ".$___Ls->ino." != '' 
                        ".$___Ls->sch->cod." AND 
                        mdl_enc = '".$___Ls->gt->isb."'
					ORDER BY ".$___Ls->ino." DESC";
					
        $___Ls->qrys = "SELECT id_mdlctrl, mdlctrl_enc, mdlctrl_tx, mdlctrl_ord, (SELECT COUNT(*) $Ls_Whr) AS ".QRY_RGTOT." $Ls_Whr";
        
	} 
	
	$___Ls->_bld();
	
?>

<?php if($___Ls->ls->chk=='ok'){ ?>
	<?php $___Ls->_bld_l_hdr(); ?>
	<?php if(($___Ls->qry->tot > 0)){ ?>
		<table width="100%" border="0" cellpadding="0" cellspacing="0" class="Ls_Rg">
			<tr>
				<th width="1%" <?php echo NWRP ?>><?php echo TX_FM_No ?></th>
				<th width="95%" <?php echo NWRP ?>><?php echo TX_TXT ?></th>
				<th width="95%" <?php echo NWRP ?>><?php echo TX_ORD ?></th>
                <th width="1%" <?php echo NWRP ?>></th>
			</tr>
			<?php do { ?>
				<tr>    
					<td width="1%" <?php echo NWRP ?>><?php echo Spn($___Ls->ls->rw[$___Ls->ino]); ?></td>
					<td width="95%" align="left"><?php echo ctjTx($___Ls->ls->rw['mdlctrl_tx'],'in'); ?></td>
					<td width="1%" <?php echo NWRP ?>><?php echo ctjTx($___Ls->ls->rw['mdlctrl_ord'],'in'); ?></td>
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
			<div id="<?php echo $___Ls->fm->bx->id ?>" class="<?php echo DV_GNR_FM_BX ?>" >
				<form method="POST" name="<?php echo $___Ls->fm->id; ?>" target="_self" id="<?php echo $___Ls->fm->id; ?>">
					<?php $___Ls->_bld_f_hdr(); ?>   
					<div id="<?php echo $___Ls->fm->fld->id ?>" class="<?php echo DV_GNR_FM_CMP ?>"> 
						<div class="ln_1">

							<?php 
							
								echo HTML_inp_hd('mdlctrl_mdl', $___Ls->gt->isb);
								
								echo HTML_textarea('mdlctrl_tx', 'Texto de la lista de Control', $___Ls->dt->rw['mdlctrl_tx']);
								echo HTML_inp_tx('mdlctrl_ord', "Orden" , ctjTx($___Ls->dt->rw['mdlctrl_ord'],'in'), FMRQD_NM);

							?> 
						</div>
					</div>
				</form>
			</div>
		</div>
	<?php } ?>
<?php } ?> 