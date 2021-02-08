<?php 
if(class_exists('CRM_Cnx')){

	$___Ls->_strt();
	
	if(!isN($___Ls->gt->isb)){ $__fl .= $___Ls->_andsql([ 'f'=>'cldmn_enc', 'v'=>$___Ls->gt->isb ]); }
	
	if(!isN($___Ls->gt->i)){	

		$___Ls->qrys = sprintf("SELECT * 
								FROM ".TB_CL_DMN_SUB." 
									 INNER JOIN ".TB_CL_DMN." ON cldmnsub_cldmn = id_cldmn
								WHERE ".$___Ls->ik." = %s 
								LIMIT 1", GtSQLVlStr($___Ls->gt->i, "text"));				 
		
	}elseif($___Ls->_show_ls == 'ok'){ 


		$Ls_Whr = "FROM ".TB_CL_DMN_SUB."
						INNER JOIN ".TB_CL_DMN." ON cldmnsub_cldmn = id_cldmn
				   WHERE id_cldmnsub != '' $__fl ".$___Ls->sch->cod." 
				   ORDER BY cldmnsub_sub DESC";
				   
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
	        <th width="98%" <?php echo NWRP ?>><?php echo TX_EML; ?></th>   
	        <th width="1%" <?php echo NWRP ?>><?php echo TX_TP; ?></th>
	        <th width="1%" <?php echo NWRP ?>></th>
	    </tr>
  	</thead>
  	<tbody>
	<?php do { ?>
    	<tr>
	        <td width="1%" align="left" nowrap="nowrap"><?php echo $___Ls->ls->rw[$___Ls->ino]; ?></td>
	        <td width="98%" align="left" nowrap="nowrap"><?php echo ShortTx(ctjTx($___Ls->ls->rw['cldmnsub_sub'],'in'),50); ?></td>
	        <td width="1%" align="left" nowrap="nowrap"><?php echo Spn($___Ls->ls->rw['cldmnsub_tp'],'','_f'); ?></td> 
	        <td width="1%" align="left" nowrap="nowrap" class="_btn"><?php echo $___Ls->_btn([ 't'=>'mod' ]); ?></td>  
      </tr>
      <?php } while ($___Ls->ls->rw = $___Ls->sql->fetch_assoc()); ?>
      <?php $CntWb .= " $('#".TBGRP."_gst ._n').html('".$___Ls->qry->tot."'); "; ?>
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
	                    
	                    <?php echo HTML_inp_hd('cldmnsub_cldmn', _SbLs_ID('i')); ?>	
                        <?php echo HTML_inp_tx('cldmnsub_sub', TX_SBDM, ctjTx($___Ls->dt->rw['cldmnsub_sub'],'in'), FMRQD); ?> 
                        
                    </div>
					<div class="col_2">
						<?php echo HTML_inp_tx('cldmnsub_tp', TX_TP, ctjTx($___Ls->dt->rw['cldmnsub_tp'],'in'), FMRQD); ?> 
					</div>
                </div>
	                    
		  </div>              
	    </form>
  	</div>
</div>
<?php } ?>
<?php } ?>
