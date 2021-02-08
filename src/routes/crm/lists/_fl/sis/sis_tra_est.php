<?php
if(class_exists('CRM_Cnx')){
	

	$___Ls->cnx->cl = 'ok';
	$___Ls->sch->f = 'sisslc_tt';

	
	$__id = 'id_sisslc';
	$__id_tra = 'id_tra';

	$__tt = MDL_SIS_TRA_EST;
	
	if(!isN($___Ls->gt->i)){	
		
		$___Ls->qrys = sprintf("SELECT * FROM ".DBM.".$__bd, ".DBM.".$__bd2, $__bd3 WHERE sisslctp_key = 'tra_est' AND sisslc_tp = 29 AND tra_est = id_sisslc AND ".$___Ls->ik." = %s ", GtSQLVlStr($___Ls->gt->i, "text"));
		
	}elseif($___Ls->_show_ls == 'ok'){  

		$Ls_Whr = "FROM ".DBM.".$__bd, ".DBM.".$__bd2, $__bd3 WHERE sisslctp_key = 'tra_est' AND sisslc_tp = 29 AND tra_est = id_sisslc  ".$___Ls->sch->cod." ORDER BY sisslc_tt ASC";
		$___Ls->qrys = "SELECT * , (SELECT COUNT(*) $Ls_Whr) AS ".QRY_RGTOT." $Ls_Whr";	  
		
	} 
	
	$___Ls->_bld(); 
?>
<?php if($___Ls->ls->chk=='ok'){ ?>
<?php $___Ls->_bld_l_hdr(); ?>
<?php if(($___Ls->qry->tot > 0)){ ?>
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="Ls_Rg">
	<tr>
    	<th width="4%" <?php echo NWRP ?>><?php echo TX_FM_No ?></th>
    	<th width="48%" <?php echo NWRP ?>><?php echo MDL_TRA ?></th>
    	<th width="48%" <?php echo NWRP ?>><?php echo MDL_TRA_EST ?></th>
    	<th width="1%" <?php echo NWRP ?>></th>
  	</tr>
  	<?php do { ?>
  	<tr>   	  
    	<td align="left" <?php echo $_clr_rw ?>><?php echo $___Ls->ls->rw[$__id_tra]; ?></td>
    	<td width="48%" align="left" <?php echo $_clr_rw ?>><?php echo ShortTx(ctjTx($___Ls->ls->rw['tra_tt'],'in'),40,'Pt', true);?></td>
    	<td width="48%" align="left" <?php echo $_clr_rw ?>><?php echo ShortTx(ctjTx($___Ls->ls->rw['sisslc_tt'],'in'),40,'Pt', true); ?></td>
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
  	<div id="<?php  echo DV_GNR_FM ?>">                        
	    <form method="POST" name="<?php echo $___Ls->fm->id; ?>" target="_self" id="<?php echo $___Ls->fm->id; ?>">
	      	<?php $___Ls->_bld_f_hdr(); ?>      
		  	<div id="<?php echo $___Ls->fm->fld->id ?>" class="<?php echo DV_GNR_FM_CMP ?>"><?php echo HTML_Fm_MMFM($__id_tra, $___Ls->dt->rw[$__id_tra], $___Ls->dt->tot, $__fmnm); ?>
	         <div class="ln_1">
	              <div class="col_1"> 
	                    <?php echo HTML_inp_tx('tra_tt', TX_NM, ctjTx($___Ls->dt->rw['tra_tt'],'in')); ?> 
	              </div>
	              <div class="col_2"> 
		              	<?php $l = __Ls(['k'=>'tra_est', 'id'=>'tra_est', 'va'=>$___Ls->dt->rw['tra_est'] , 'ph'=>FM_LS_SLGN]); 
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
