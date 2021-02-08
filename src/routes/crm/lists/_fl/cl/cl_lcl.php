<?php
if(class_exists('CRM_Cnx')){
	
	$___Ls->sch->f = 'cllcl_tt';
	$___Ls->new->w = 600;
	$___Ls->new->h = 450;
	$___Ls->edit->w = 600;
	$___Ls->edit->h = 450;
	
	$___Ls->_strt();
	
	
	if(!isN($___Ls->gt->i)){	
		
		$___Ls->qrys = sprintf("SELECT * FROM "._BdStr(DBM).TB_CL_LCL." WHERE ".$___Ls->ik." = %s LIMIT 1", GtSQLVlStr($___Ls->gt->i, "text"));	
		
	}elseif($___Ls->_show_ls == 'ok'){ 
		
		$Ls_Whr = " FROM "._BdStr(DBM).TB_CL_LCL."
					".GtSlc_QryExtra(['t'=>'tb', 'col'=>'cllcl_lvl', 'als'=>'t'])."
					WHERE ".$___Ls->ino." != '' AND cllcl_cl = ".$__dt_cl->id." ".$___Ls->sch->cod." ORDER BY ".$___Ls->ino." DESC";
		$___Ls->qrys = "SELECT *,
						( 
							SELECT org_img FROM 
							"._BdStr(DBM).TB_ORG_SDS_ARR." 
							INNER JOIN "._BdStr(DBM).TB_ORG_SDS." ON orgsdsarr_orgsds = id_orgsds
							INNER JOIN "._BdStr(DBM).TB_ORG."  ON orgsds_org = id_org
							WHERE orgsdsarr_est = 1 AND orgsdsarr_lcl = id_cllcl LIMIT 1
						) as _org_img,
						".GtSlc_QryExtra(['t'=>'fld', 'p'=>'lvl', 'als'=>'t']).",
						(SELECT COUNT(*) $Ls_Whr) AS ".QRY_RGTOT." $Ls_Whr";

	} 
	$___Ls->_bld();
?>
<?php if($___Ls->ls->chk=='ok'){ ?>
	<?php $___Ls->_bld_l_hdr();?>
	<?php if(($___Ls->qry->tot > 0)){ ?>
		<table width="100%" border="0" cellpadding="0" cellspacing="0" class="Ls_Rg">
		  	<tr>
		    	<th width="1%" <?php echo NWRP ?>><?php echo TX_FM_No ?></th>
				<th width="1%" <?php echo NWRP ?>></th>
		    	<th width="33%" <?php echo NWRP ?>><?php echo "Titulo" ?></th>
		    	<th width="33%" <?php echo NWRP ?>><?php echo "Metros cuadrados" ?></th>
		    	<th width="32%" <?php echo NWRP ?>><?php echo 'Piso' ?></th>
		    	<th width="1%" <?php echo NWRP ?>></th>
		  	</tr>
		  	<?php do { ?>
		  	<tr> 
				<td width="1%" <?php echo NWRP ?>><?php echo Spn($___Ls->ls->rw[$___Ls->ino]); ?></td>
				<td width="1%" <?php echo NWRP ?>>
					<div class="_img_o" style="background-image: url(<?php echo DMN_FLE_ORG.$___Ls->ls->rw['_org_img'] ?>);"></div>
				</td>
				<td width="33%" align="left" nowrap="nowrap"><?php echo ShortTx(ctjTx($___Ls->ls->rw['cllcl_tt'],'in'),40); ?></td>
				<td width="33%" align="left" nowrap="nowrap"><?php echo ShortTx(ctjTx($___Ls->ls->rw['cllcl_m2'],'in'),40); ?></td>
				<td width="33%" align="left" nowrap="nowrap"><?php echo ShortTx(ctjTx($___Ls->ls->rw['lvl_sisslc_tt'],'in'),40); ?></td>
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
	  	<div id="<?php echo $___Ls->fm->fld->id ?>" class="<?php echo DV_GNR_FM_CMP ?>">
        <div class="ln_1">
	        	<?php echo HTML_inp_hd('cllcl_enc', $___Ls->dt->rw['cllcl_enc']); ?> 
				<?php echo HTML_inp_tx('cllcl_tt', "Titulo" , ctjTx($___Ls->dt->rw['cllcl_tt'],'in'), FMRQD); ?>
				<?php echo HTML_inp_tx('cllcl_m2', "Metros cuadrados" , ctjTx($___Ls->dt->rw['cllcl_m2'],'in'), FMRQD); ?>
				<?php //echo HTML_inp_tx('cllcl_lvl', "Piso" , ctjTx($___Ls->dt->rw['cllcl_lvl'],'in'), FMRQD); ?>
				<?php 
					$l = __Ls([ 'k'=>'lcl_lvl', 'id'=>'cllcl_lvl', 'va'=>$___Ls->dt->rw['cllcl_lvl'], 'ph'=>'Piso' ]);
					echo $l->html; $CntWb .= $l->js;
				?>
        </div>
      	</div>
    </form>
  	</div>
</div>
<?php } ?>
<?php } ?>