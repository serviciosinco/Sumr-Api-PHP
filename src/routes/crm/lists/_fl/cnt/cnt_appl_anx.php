<?php
	
if(class_exists('CRM_Cnx')){

	$___Ls->cnx->cl = 'ok';
	$___Ls->_strt();

	if(!isN($___Ls->gt->i)){
		
		$___Ls->qrys = sprintf("SELECT *
								FROM ".TB_CNT_APPL_ANX."
						   		WHERE  ".$___Ls->ik." = %s LIMIT 1", GtSQLVlStr($___Ls->gt->i, "text"));
						   		
	}elseif($___Ls->_show_ls == 'ok' || !isN($_i)){

		if( !isN($__i) ){ $_fl = " AND cntapplanx_cntappl IN ( SELECT id_cntappl FROM ".TB_CNT_APPL." WHERE cntappl_enc = '".$__i."' ) "; }

		$Ls_Whr = " FROM ".TB_CNT_APPL_ANX."
						".GtSlc_QryExtra(['t'=>'tb', 'col'=>'cntapplanx_attr', 'als'=>'t'])."
						".GtSlc_QryExtra(['t'=>'tb', 'col'=>'cntapplanx_est', 'als'=>'t2'])."
						WHERE id_cntapplanx != '' $_fl ".$___Ls->sch->cod." ";
		$___Ls->qrys = "SELECT *,
						".GtSlc_QryExtra(['t'=>'fld', 'p'=>'attr', 'als'=>'t']).",
						".GtSlc_QryExtra(['t'=>'fld', 'p'=>'est', 'als'=>'t2']).",
						(SELECT COUNT(*) $Ls_Whr) AS ".QRY_RGTOT." $Ls_Whr";

	}
	
	$___Ls->_bld();
?>

<?php if($___Ls->ls->chk=='ok'){

	$__blq = 'off'; ?>
	<?php //$___Ls->_bld_l_hdr(); ?>

	<?php if(($___Ls->qry->tot > 0)){ ?>
	
		<table width="100%" border="0" cellpadding="0" cellspacing="0" class="Ls_Rg">
			<thead>
		        <tr>
		        	<th width="32%" <?php echo NWRP ?>><?php echo TX_TT; ?></th>
		        	<th width="32%" <?php echo NWRP ?>><?php echo TX_ACTV; ?></th>
		            <th width="32%" <?php echo NWRP ?>><?php echo TX_FI; ?></th>
					<th width="1%" <?php echo NWRP ?>></th>
					<th width="1%" <?php echo NWRP ?>></th>
		        </tr>
			</thead>
			<tbody>
				<?php do { ?>
			        <tr>
			        	<td width="32%" align="left" nowrap="nowrap"><?php echo ctjTx($___Ls->ls->rw['attr_sisslc_tt'], 'in'); ?></td>
			        	<td width="32%" align="left" nowrap="nowrap"><?php echo ctjTx($___Ls->ls->rw['est_sisslc_tt'], 'in'); ?></td>
			        	<td width="32%" align="left" nowrap="nowrap"><?php echo ctjTx($___Ls->ls->rw['cntapplanx_fi'], 'in'); ?></td>
			        	<td width="1%" align="left" nowrap="nowrap" class="_btn"><?php echo $___Ls->_btn([ 't'=>'mod' ]); ?></td>
			        	<td width="1%" align="left" nowrap="nowrap" class="_btn"><?php echo $___Ls->_btn([ 't'=>'dtl' ]); ?></td>
			        </tr>
		        <?php } while ($___Ls->ls->rw = $___Ls->sql->fetch_assoc()); ?>
		        <?php $CntWb .= " $('#".TBGRP."_gst ._n').html('".$___Ls->qry->tot."'); "; ?>
		  	</tbody>
		</table>
		<?php $___Ls->_bld_l_pgs(); ?>
	
	<?php } ?>
	
	<div id="_upl_fle"></div>
	<?php $CntWb .= "_ldCnt({ u:'".Fl_Rnd(FL_FM_GN.__t('up_anx',true))."', c:'_upl_fle', d: { __i: '".$___Ls->gt->isb."', __box:'".$___Ls->bx_rld."' } });"; ?>
	
	<?php $___Ls->_h_ls_nr(); ?>
	
<?php } ?>

<?php if($___Ls->fm->chk=='ok'){ ?> 
<div class="FmTb">
  <div id="<?php echo $___Ls->fm->bx->id ?>" class="<?php echo DV_GNR_FM_BX ?>" >
    <form method="POST" name="<?php echo $___Ls->fm->id; ?>" target="_self" id="<?php echo $___Ls->fm->id; ?>" >
      	
      	<?php $___Ls->_bld_f_hdr(); ?>
      	<?php //$___Ls->_bld_f_hdr(); ?>
	  	
	  	<div id="<?php echo $___Ls->fm->fld->id ?>" class="<?php echo DV_GNR_FM_CMP ?>">
			<div class="ln_1">
				<?php
					$l = __Ls(['k'=>'Sis_SiNo',
								'id'=>'cntapplanx_est',
								'ph'=>	TX_ACTV	,
								'va'=>$___Ls->dt->rw['cntapplanx_est']
							]);
					echo $l->html; $CntWb .= $l->js;		
				?>
            </div>
		</div>   
	           
    </form>
  </div>
</div>

<?php } ?>
<?php } ?>
