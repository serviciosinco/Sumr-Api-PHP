<?php
if(class_exists('CRM_Cnx')){
	
	$___Ls->tt = MDL_VST_EST;
	$___Ls->cnx->cl = 'ok';
	$___Ls->sch->f = 'emp_rs, sisslc_tt';
	$___Ls->_strt();
	
	if(!isN($___Ls->gt->i)){	
		
		$___Ls->qrys = sprintf(" SELECT * 
								 FROM ".MDL_EMP_BD."
								 	  INNER JOIN "._BdStr(DBM).TB_SIS_SLC." ON empvst_est = id_sisslc
								 	  INNER JOIN "._BdStr(DBM).TB_SIS_SLC_TP." 
								 WHERE ".$___Ls->ik." = %s ", GtSQLVlStr($___Ls->gt->i, "text"));
		
	}elseif($___Ls->_show_ls == 'ok'){ 
		  
		$Ls_Whr = "	FROM ".MDL_EMP_BD."
						 INNER JOIN ".MDL_EMP_VST_BD."
						 INNER JOIN "._BdStr(DBM).TB_SIS_SLC."
						 INNER JOIN "._BdStr(DBM).TB_SIS_SLC_TP." 
					WHERE 
					AND empvst_cnt = id_empcnt
					AND empvst_est = id_sisslc
					AND sisslctp_key = 'vst_est'
					AND sisslc_tp = 22 ".$___Ls->sch->cod." ORDER BY sisslc_tt ASC";
		$___Ls->qrys = "SELECT id_empvst, sisslc_tt, emp_rs , (SELECT COUNT(*) $Ls_Whr) AS ".QRY_RGTOT." $Ls_Whr";  
		
	} 
	
	$___Ls->_bld();
	
?>
<?php if($___Ls->ls->chk=='ok'){ ?>
<?php $___Ls->_bld_l_hdr();?>
<?php if(($___Ls->qry->tot > 0)){ ?>
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="Ls_Rg">
  	<tr>
    	<th width="4%" <?php echo NWRP ?>><?php echo TX_FM_No ?></th>
		<th width="48%" <?php echo NWRP ?>><?php echo TX_ESTVST ?></th>
		<th width="48%" <?php echo NWRP ?>><?php echo TX_EMP ?></th>
  	</tr>
  	<?php do { ?>
	<tr>   	  
    	<td align="left" <?php echo $_clr_rw ?>><?php echo $___Ls->ls->rw[$__id_vst]; ?></td>
		<td width="48%" align="left" <?php echo $_clr_rw ?>><?php echo ShortTx(ctjTx($___Ls->ls->rw['sisslc_tt'],'in'),40,'Pt', true);?></td>
		<td width="48%" align="left" <?php echo $_clr_rw ?>><?php echo ShortTx(ctjTx($___Ls->ls->rw['emp_rs'],'in'),40,'Pt', true); ?></td>
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
	  <?php 

			echo HTML_Fm_Del($__id_vst, $___Ls->dt->rw[$__id_vst], Fl_Rnd(PRC_GN.__t($__bdtp,true)), $__fmnm, ['f1'=>'___t', 'f1_v'=>$__prfx->prfx2_c]); 
  			
	?>
                       
                             
    <form method="POST" name="<?php echo $___Ls->fm->id; ?>" target="_self" id="<?php echo $___Ls->fm->id; ?>">

      <?php $___Ls->_bld_f_hdr(); ?>   

      <div id="<?php echo $___Ls->fm->fld->id ?>" class="<?php echo DV_GNR_FM_CMP ?>"><?php echo HTML_Fm_MMFM($__id_vst, $___Ls->dt->rw[$__id_aplz], $___Ls->dt->tot, $__fmnm); ?>
         <div class="ln_1">
              <div class="col_1"> 
                    <?php echo HTML_inp_tx('emp_rs', TX_NM, ctjTx($___Ls->dt->rw['emp_rs'],'in')); ?> 
              </div>
              <div class="col_2"> 
	              	<?php $l = __Ls(['k'=>'vst_aplz', 'id'=>'vst_aplz', 'va'=>$___Ls->dt->rw['vst_aplz'] , 'ph'=>FM_LS_SLGN]); 
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
