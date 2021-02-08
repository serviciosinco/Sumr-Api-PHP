
<?php

if(class_exists('CRM_Cnx')){
	
	$___Ls->sch->f = 'siscntesttp_tt, siscntesttp_clr_bck';
	$___Ls->img->dir = DMN_FLE_SIS_CNT_EST_TP;
	$___Ls->new->w = 500;
	$___Ls->new->h = 330;
	
	
	
	$___Ls->_strt();

	if(!isN($___Ls->gt->i)){	
		
		$___Ls->qrys = sprintf("SELECT * FROM ".TB_SIS_CNT_EST_TP." WHERE ".$___Ls->ik." = %s LIMIT 1", GtSQLVlStr($___Ls->gt->i, "text"));
		
	}elseif($___Ls->_show_ls == 'ok'){ 
		 
		$Ls_Whr = "FROM ".TB_SIS_CNT_EST_TP."
						INNER JOIN ".TB_CL." ON siscntesttp_cl = id_cl 
				   WHERE cl_enc = '".DB_CL_ENC."' ".$___Ls->sch->cod." 
				   ORDER BY siscntesttp_tt ASC";
		
		$___Ls->qrys = " SELECT *, 
							
							(
							SELECT COUNT(*)
								FROM ".TB_SIS_CNT_EST."
								WHERE siscntest_tp = id_siscntesttp
							)
							AS __tot_est,
						
						  (SELECT COUNT(*) $Ls_Whr) AS ".QRY_RGTOT."
						   
					$Ls_Whr";
	} 
	
	$___Ls->_bld();
	
?>
<?php if($___Ls->ls->chk=='ok'){ ?>
<?php $___Ls->_bld_l_hdr(); ?>
<?php if(($___Ls->qry->tot > 0)){ ?>
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="Ls_Rg">
	<tr>
    	<th width="1%" <?php echo NWRP ?>><?php echo TX_FM_No ?></th>
    	<th width="1%" <?php echo NWRP ?>></th>
		<th width="94%" <?php echo NWRP ?>><?php echo TX_NM ?></th>
		<th width="1%" <?php echo NWRP ?>><?php echo TX_ESTS ?></th>
		<th width="1%" <?php echo NWRP ?>><?php echo TX_ORD ?></th>
		<th width="1%" <?php echo NWRP ?>><?php echo TX_CNTCMPRS ?></th>
		<th width="1%" <?php echo NWRP ?>><?php echo TX_CNTR ?></th>
		<th width="1%" <?php echo NWRP ?>></th>
	</tr>
	<?php do { ?>
	<?php $__tt_img = fgr('<img src="'.DMN_FLE_SIS_CNT_EST_TP.$___Ls->ls->rw['siscntesttp_img'].'">', '_o'); ?>
   	<tr>    	        
	    <td align="left" <?php echo $_clr_rw ?>><?php echo $___Ls->ls->rw[$___Ls->ino]; ?></td>
	    <td width="1%"><?php echo $__tt_img; ?></td>
	    <td width="94%" align="left" <?php echo $_clr_rw ?>>
		    <?php     
			    echo Spn('','', '_clr_icn','background-color:'.$___Ls->ls->rw['siscntesttp_clr_bck'].'; ') . ctjTx($___Ls->ls->rw['siscntesttp_tt'],'in').HTML_BR.Spn(ctjTx($___Ls->ls->rw['siscntesttp_clr_bck'],'in'),'ok','_f');    
		    ?>
		</td>
	    <td align="left" <?php echo $_clr_rw ?>><?php echo $___Ls->ls->rw['__tot_est']; ?></td>
	    <td align="left" <?php echo $_clr_rw ?>><?php echo $___Ls->ls->rw['siscntesttp_ord']; ?></td> 
	    <td align="left" <?php echo $_clr_rw ?>><?php echo mBln($___Ls->ls->rw['siscntesttp_cntr']); ?></td> 
	    <td align="left" <?php echo $_clr_rw ?>><?php echo mBln($___Ls->ls->rw['siscntesttp_prch']); ?></td> 
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

	<div id="<?php echo $___Ls->fm->fld->id ?>" class="<?php echo DV_GNR_FM_CMP ?>">
        <div class="ln_1">
            
                    <?php echo HTML_inp_tx('siscntesttp_tt', TX_NM, ctjTx($___Ls->dt->rw['siscntesttp_tt'],'in')); ?>
                    <?php echo HTML_inp_tx('siscntesttp_ord', TX_ORD, ctjTx($___Ls->dt->rw['siscntesttp_ord'],'in')); ?> 
                    <?php echo HTML_inp_clr(['id'=>'siscntesttp_clr_bck', 'plc'=>TX_CLR, 'vl'=>ctjTx($___Ls->dt->rw['siscntesttp_clr_bck'],'in') ]); ?>
                    <?php echo OLD_HTML_chck('siscntesttp_prch',TX_CNTR, $___Ls->dt->rw['siscntesttp_prch'], 'in'); ?>
                    <?php echo OLD_HTML_chck('siscntesttp_cntr',TX_CNTCMPRS, $___Ls->dt->rw['siscntesttp_cntr'], 'in'); ?>
              
				  <!--<div class="col_2"> 
						<?php if($___Ls->dt->tot == 1){ ?>
							<?php echo OLD_HTML_chck('siscntesttp_pqt', MDL_S_TP_PQT, $___Ls->dt->rw['siscntesttp_pqt'], 'in'); ?>
	                        <?php echo OLD_HTML_chck('siscntesttp_acd', MDL_S_TP_ACMD, $___Ls->dt->rw['siscntesttp_acd'], 'in'); ?>
	                        <?php echo OLD_HTML_chck('siscntesttp_rst', MDL_S_TP_RSTR, $___Ls->dt->rw['siscntest	tp_rst'], 'in'); ?>
	                        <?php echo OLD_HTML_chck('siscntesttp_spa', MDL_S_TP_SPA, $___Ls->dt->rw['siscntesttp_spa'], 'in'); ?>
	                        <?php echo OLD_HTML_chck('siscntesttp_evns', MDL_S_TP_EVN, $___Ls->dt->rw['siscntesttp_evns'], 'in'); ?>
	                        <?php echo OLD_HTML_chck('siscntesttp_pqr', MDL_S_TP_PQR, $___Ls->dt->rw['siscntesttp_pqr'], 'in'); ?>
	                    <?php } ?>
	              </div>-->
        </div>
    </div>
    </form>
  </div>
</div>
<?php }?>
<?php }?>