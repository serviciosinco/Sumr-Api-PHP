<?php
	
if(class_exists('CRM_Cnx')){

	$___Ls->cnx->cl = 'ok';
	$___Ls->_strt();

	if(!isN($___Ls->gt->i)){

		/*$___Ls->qrys = sprintf("SELECT * FROM ".TB_CNT_DC."
								INNER JOIN ".TB_CNT." ON cntdc_cnt = id_cnt
						   		WHERE cntdc_cnt = id_cnt AND 
								 ".$___Ls->ik." = %s LIMIT 1", GtSQLVlStr($___Ls->gt->i, "text"));*/			 

	}elseif($___Ls->_show_ls == 'ok'){

		if( !isN($__i) ){ $_fl = " AND cntappl_cnt IN ( SELECT mdlcnt_cnt FROM ".TB_MDL_CNT." WHERE mdlcnt_enc = '".$__i."' ) "; }

		$Ls_Whr = "FROM ".TB_CNT_APPL."
						/*".GtSlc_QryExtra(['t'=>'tb', 'col'=>'cntapplattr_attr', 'als'=>'t'])."*/
						WHERE id_cntappl != '' $_fl ".$___Ls->sch->cod."
						ORDER BY id_cntappl DESC";
		$___Ls->qrys = "SELECT *,
						/*".GtSlc_QryExtra(['t'=>'fld', 'p'=>'attr', 'als'=>'t']).",*/
						(SELECT COUNT(*) $Ls_Whr) AS ".QRY_RGTOT." $Ls_Whr";

	}

	$___Ls->_bld();
	
	$___Ls->tp = "cnt_appl_attr";
	
?>

<?php if($___Ls->ls->chk=='ok'){

	$__blq = 'off'; ?>
	<?php //$___Ls->_bld_l_hdr(); ?>

	<?php if(($___Ls->qry->tot > 0)){ ?>
	
	
		<table width="100%" border="0" cellpadding="0" cellspacing="0" class="Ls_Rg">
			<thead>
		        <tr>
		        	<th width="19%" <?php echo NWRP ?>><?php echo TX_DCNMR; ?></th>
		            <th width="80%" <?php echo NWRP ?>><?php echo TX_FI; ?></th>
					<th width="1%" <?php echo NWRP ?>></th>
		        </tr>
			</thead>
			<tbody>
				<?php do { ?>
		        <tr>
		        	<td width="19%" align="left" nowrap="nowrap"><?php echo ctjTx($___Ls->ls->rw['id_cntappl'], 'in'); ?></td>
					<td width="80%" align="left" nowrap="nowrap"><?php echo Spn( ctjTx($___Ls->ls->rw['cntappl_fi'], 'in') ,'','_f'); ?></td>
					<td width="1%" align="left" nowrap="nowrap" class="_btn"><?php echo $___Ls->_btn([ 't'=>'mod' ]); ?></td>
		        </tr>
		        <?php } while ($___Ls->ls->rw = $___Ls->sql->fetch_assoc()); ?>
		        <?php $CntWb .= " $('#".TBGRP."_gst ._n').html('".$___Ls->qry->tot."'); "; ?>
		  	</tbody>
		</table>
		<?php //$___Ls->_bld_l_pgs(); ?>
	
	
	<?php } ?>
	<?php //$___Ls->_h_ls_nr(); ?>
	
<?php } ?>

<?php if($___Ls->fm->chk=='ok'){ ?>
<div class="FmTb">
  <div id="<?php echo $___Ls->fm->bx->id ?>" class="<?php echo DV_GNR_FM_BX ?>" >
    <form method="POST" name="<?php echo $___Ls->fm->id; ?>" target="_self" id="<?php echo $___Ls->fm->id; ?>" >
      	<?php $___Ls->_bld_f_hdr(); ?>

	  	<div id="<?php echo $___Ls->fm->fld->id ?>" class="<?php echo DV_GNR_FM_CMP ?>">
			<div class="ln_1">
				  
            </div>
	  </div>   
	           
    </form>
  </div>
</div>

<?php } ?>
<?php } ?>
