<?php 
if(class_exists('CRM_Cnx')){

	$___Ls->ik = 'wthsp_enc';
	$___Ls->_strt();
	
	if(!isN($___Ls->gt->isb)){ $__fl .= $___Ls->_andsql([ 'f'=>'cl_enc', 'v'=>$___Ls->gt->isb ]); }
	
	if(!isN($___Ls->gt->i)){	

		$___Ls->qrys = sprintf("SELECT * FROM "._BdStr(DBT).TB_WHTSP."
                                    INNER JOIN "._BdStr(DBM).TB_CL." ON wthsp_cl = id_cl
								        WHERE ".$___Ls->ik." = %s 
								    LIMIT 1", GtSQLVlStr($___Ls->gt->i, "text"));				 
		
	}elseif($___Ls->_show_ls == 'ok'){

		$Ls_Whr = "	FROM "._BdStr(DBT).TB_WHTSP."
						INNER JOIN "._BdStr(DBM).TB_CL." ON wthsp_cl = id_cl
						INNER JOIN "._BdStr(DBM).TB_SIS_SLC." ON whtsp_api = id_sisslc
					WHERE cl_enc != '' $__fl ".$___Ls->sch->cod." 
					ORDER BY id_wthsp DESC";
				   
		$___Ls->qrys = "SELECT  *, (SELECT COUNT(*) $Ls_Whr) AS ".QRY_RGTOT." $Ls_Whr";
		
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
	        <th width="20%" <?php echo NWRP ?>><?php echo TX_DCNMR?></th>   
            <th width="20%" <?php echo NWRP ?>><?php echo TX_KEY_API?></th> 
	        <th width="20%" <?php echo NWRP ?>><?php echo TX_EST?></th>
            <th width="20%" <?php echo NWRP ?>><?php echo TX_FI?></th>
	        <th width="1%" <?php echo NWRP ?>></th>
	        
	    </tr>
  	</thead>
  	<tbody>
	<?php do { ?>
    	<tr>
	        <td width="1%" align="left" nowrap="nowrap"><?php echo $___Ls->ls->rw[$___Ls->ino]; ?></td>
	        <td width="20%" align="left" nowrap="nowrap"><?php echo ShortTx(ctjTx($___Ls->ls->rw['wthsp_no'],'in'),50); ?></td>
            <td width="20%" align="left" nowrap="nowrap"><?php echo ShortTx(ctjTx($___Ls->ls->rw['sisslc_tt'],'in'),50); ?></td>
            <td width="20%" align="left" nowrap="nowrap"><?php echo Spn(mBln($___Ls->ls->rw['whtsp_e']),'',mBln($___Ls->ls->rw['whtsp_e'])); ?></td>
            <td width="20" <?php echo NWRP.$_clr_rw ?>><?php echo Spn(_Tme($___Ls->ls->rw['wthsp_fi'], 'sng')); ?></td>
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
						<?php echo HTML_inp_tx('wthsp_no', TX_DCNMR, ctjTx($___Ls->dt->rw['wthsp_no'],'in'), FMRQD); ?>      
                        <?php echo OLD_HTML_chck('whtsp_e', TX_EST, $___Ls->dt->rw['whtsp_e'], 'in'); ?>
	          	    </div>
					<div class="col_2">
						<?php $l = __Ls([ 'k'=>'api_thrd', 'id'=>'whtsp_api', 'va'=>ctjTx($___Ls->dt->rw['whtsp_api'],'in'), 'ph'=>TX_KEY_API ]); echo $l->html; $CntWb .= $l->js; ?>						
                        <?php echo HTML_inp_hd('wthsp_cl', $___Ls->gt->isb); ?>
					</div>
                </div>        
		    </div>              
	    </form>
  	</div>
</div>
<?php } ?>
<?php } ?>