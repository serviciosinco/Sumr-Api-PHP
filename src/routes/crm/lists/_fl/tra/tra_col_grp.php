<?php
if(class_exists('CRM_Cnx')){

	$___Ls->tt = _Cns('TX_TRA_COL');
	$___Ls->cnx->cl = 'ok';
	$___Ls->ino = "id_tracol";
	$___Ls->ik = "tracol_enc";
	$___Ls->img->enc = 'ok';
	$___Ls->img->dir = DMN_FLE_TRA_COL;

	$___Ls->_strt();
	
	if(!isN($___Ls->gt->i)){	
		 
		$___Ls->qrys = sprintf("SELECT *
								FROM  "._BdStr(DBM).TB_TRA_COL."
								WHERE ".$___Ls->ik." = %s 
								LIMIT 1", GtSQLVlStr($___Ls->gt->i, "text")
							);
									
	}elseif($___Ls->_show_ls == 'ok'){
		
		$_fl = "AND id_tracol IN( SELECT tracolgrp_tracol FROM "._BdStr(DBM).TB_TRA_COL_GRP." WHERE tracolgrp_grp IN ( SELECT id_clgrp FROM "._BdStr(DBM).TB_CL_GRP." WHERE clgrp_enc = '{$__i}' ) )";
		$Ls_Whr = "	FROM  "._BdStr(DBM).TB_TRA_COL."
					WHERE ".$___Ls->ino." != '' $_fl 
					ORDER BY ".$___Ls->ino." DESC";
		$___Ls->qrys = "SELECT *,
				   	(SELECT COUNT(*) $Ls_Whr) AS ".QRY_RGTOT." $Ls_Whr";
		
	} 

	$__clr_dt = __LsDt(['k'=>'tra_col_clr']);
	$__tp_dt = __LsDt(['k'=>'tra_col_tp']);

	$___Ls->_bld();
?>
<?php if($___Ls->ls->chk=='ok'){ ?>

	<?php $___Ls->_bld_l_hdr(); ?>
	<?php if(($___Ls->qry->tot > 0)){  ?>
		<table width="100%" border="0" cellpadding="0" cellspacing="0" class="Ls_Rg">
			<tr>
			    <th width="1%" <?php echo NWRP ?>><?php echo TX_FM_No ?></th>
			    <th width="5%" <?php echo NWRP ?>><?php echo TX_TT ?></th>
				<th width="5%" <?php echo NWRP ?>><?php echo TX_CLR ?></th>
				<th width="5%" <?php echo NWRP ?>><?php echo TX_TP ?></th>
			    <th width="1%" <?php echo NWRP ?>></th>
			</tr>
			<?php do {  ?>
		  		<tr>  
					<td align="left" <?php echo $_clr_rw ?>><?php echo $___Ls->ls->rw[$___Ls->ino]; ?></td>
				    <td width="30%" align="left" <?php echo $_clr_rw ?>><?php echo ctjTx($___Ls->ls->rw['tracol_tt'],'in'); ?></td>
				    <?php $_clr = $__clr_dt->ls->tra_col_clr->{$___Ls->ls->rw['tracol_clr']}->clr->vl; ?>
					<td width="10%" align="left" <?php echo $_clr_rw ?>><?php echo Spn('','', '_clr_icn','background-color:'.$_clr.'; ') . ctjTx($_clr,'in'); ?></td>
					<?php $_tp = $__tp_dt->ls->tra_col_tp->{$___Ls->ls->rw['tracol_tp']}; ?>
					<td width="10%" align="left"><?php echo $_tp->tt; ?></td>
				    <td width="1%" align="left" nowrap="nowrap" class="_btn"><?php echo $___Ls->_btn([ 't'=>'mod' ]); ?></td>
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
		    <div class="ln_1">
	        	<div class="col_1">
		        	<?php echo HTML_inp_hd('tracolgrp_grp', $__i); ?>
	            	<?php echo HTML_inp_tx('tracol_tt', TX_TT , ctjTx($___Ls->dt->rw['tracol_tt'],'in'), FMRQD); ?>
	            	
	            	<?php echo OLD_HTML_chck('tracol_chk_pqr', 'Default PQR', $___Ls->dt->rw['tracol_chk_pqr'], 'in'); ?>
	            	<?php echo OLD_HTML_chck('tracol_chk_tck', 'Default Ticket', $___Ls->dt->rw['tracol_chk_tck'], 'in'); ?>
	            	<?php echo OLD_HTML_chck('tracol_chk_pblc', 'Publica', $___Ls->dt->rw['tracol_chk_pblc'], 'in'); ?>
	            	
	        	</div>
				<div class="col_2">
		          <?php 
				  		$l = __Ls(['k'=>'tra_col_clr',
											'id'=>'tracol_clr',
											'ph'=>TX_CLR,
											'va'=>$___Ls->dt->rw['tracol_clr']
									]);
						echo $l->html; $CntWb .= $l->js;

						$l = __Ls(['k'=>'tra_col_tp',
											'id'=>'tracol_tp',
											'ph'=>TX_TP,
											'va'=>$___Ls->dt->rw['tracol_tp']
									]);
						echo $l->html; $CntWb .= $l->js;

			  	  ?>
	          	</div>
	        </div>
    	</div>
    </form>
  </div>
</div>
<?php } ?>
<?php } ?>
