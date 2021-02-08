<?php 
if(class_exists('CRM_Cnx')){
	$___Ls->cnx->cl = 'ok';
	$___Ls->_strt();
	
	if(!isN($___Ls->gt->isb)){ $__fl .= $___Ls->_andsql([ 'f'=>'plncmp_enc', 'v'=>$___Ls->gt->isb ]); }
	
	if(!isN($___Ls->gt->i)){

		$___Ls->qrys = sprintf("SELECT *
								FROM  ".TB_PLN_CMP_GST."
								WHERE ".$___Ls->ik." = %s 
								LIMIT 1", GtSQLVlStr($___Ls->gt->i, "text")
							);	
		
	}elseif($___Ls->_show_ls == 'ok'){

		$Ls_Whr = " FROM ".TB_PLN_CMP_GST."
						INNER JOIN ".TB_PLN_CMP." ON plncmpgst_plncmp = id_plncmp
						INNER JOIN "._BdStr(DBM).TB_US." ON plncmpgst_us = id_us
					WHERE id_plncmpgst != '' $__fl ".$___Ls->sch->cod." 
					ORDER BY id_plncmpgst DESC";
					
		$___Ls->qrys = "SELECT *, (SELECT COUNT(*) $Ls_Whr) AS ".QRY_RGTOT." $Ls_Whr";

	} 
	
	$___Ls->_bld();

?>
<?php if($___Ls->ls->chk=='ok'){ $__blq = 'off'; ?>
<?php $___Ls->_bld_l_hdr(); ?>
<?php if(($___Ls->qry->tot > 0)){ ?>
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="Ls_Rg">
	<thead>
        <tr>
        	<th width="1%" <?php echo NWRP ?>></th>
            <th width="10%" <?php echo NWRP ?>><?php echo TX_RSP; ?></th>
            <th width="58%" <?php echo NWRP ?>><?php echo TX_DSC; ?></th>
            <th width="1%" <?php echo NWRP ?>><?php echo TX_FI; ?></th>
            <th width="1%" <?php echo NWRP ?>></th>
        </tr>
	</thead>
	<tbody>
		<?php do { ?>
        <tr>
	        <td width="1%" align="left" nowrap="nowrap"><?php echo $row_Dt_Rg[$__id]; ?></td>
            <td width="10%" align="left" nowrap="nowrap"><?php echo ctjTx($___Ls->ls->rw['us_nm'].' '.$___Ls->ls->rw['us_ap'],'in'); ?></td>
            <td style="white-space: normal; padding: 8px 20px;" width="58%" align="left" nowrap="nowrap"><?php echo ctjTx($___Ls->ls->rw['plncmpgst_dsc'],'in'); ?></td>
            <td width="1%" align="left" nowrap="nowrap"><?php echo Spn($___Ls->ls->rw['plncmpgst_fi'],'','_f'); ?></td> 
            <td width="1%" align="left" nowrap="nowrap" class="_btn"><?php echo $___Ls->_btn([ 't'=>'mod' ]); ?></td>
        </tr>
        <?php } while ($___Ls->ls->rw = $___Ls->sql->fetch_assoc()); ?>

  	</tbody>
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
						<?php echo HTML_inp_hd('plncmpgst_plncmp', $___Ls->gt->isb); ?>
						<?php echo HTML_textarea('plncmpgst_dsc', TX_DSC, ctjTx($___Ls->dt->rw['plncmpgst_dsc'],'in'), '', '', '', 2); ?><br>	
					</div>
					<div class="col_2"> 
						<?php echo LsSis_SiNo('plncmpgst_shw','id_sissino', $___Ls->dt->rw['plncmpgst_shw'], TX_PBL);  $CntWb .=JQ_Ls('plncmpgst_shw',TX_PBL);?> 
					</div>   
				</div>
			</div>   
		</form>
	</div>
</div>
<?php } ?>
<?php } ?>
