<?php 
	if(class_exists('CRM_Cnx')){

	$___Ls->cnx->cl = 'ok';
	$___Ls->_strt();
	
	if(!isN($___Ls->gt->i)){
		
	$___Ls->qrys = sprintf("SELECT *  
								FROM ".TB_CNT_PRNT." 
								INNER JOIN ".TB_CNT."  ON cntprnt_cnt_2 = id_cnt
								INNER JOIN "._BdStr(DBM).TB_SIS_SLC."  ON id_sisslc = cntprnt_cnt_prnt_2
								WHERE ".$___Ls->ik." = %s 
								LIMIT 1", GtSQLVlStr($___Ls->gt->i, "text"));                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            
	}elseif($___Ls->_show_ls == 'ok'){ 

		$Ls_Whr = "FROM ".TB_CNT_PRNT."
				   INNER JOIN ".TB_CNT." me ON cntprnt_cnt_1 = me.id_cnt
				   INNER JOIN ".TB_CNT." oth ON cntprnt_cnt_2 = oth.id_cnt
				   INNER JOIN "._BdStr(DBM).TB_SIS_SLC."  ON id_sisslc = cntprnt_cnt_prnt_2
				   WHERE id_cntprnt != '' 
				   AND me.cnt_enc = '".$___Ls->gt->isb ."'   
				   ORDER BY cntprnt_fi DESC";
		$___Ls->qrys = "SELECT *, 
								(SELECT COUNT(*) $Ls_Whr) AS ".QRY_RGTOT.",
								oth.cnt_nm AS oth_cnt_nm 
						$Ls_Whr"; 
			}
		
		$___Ls->_bld();
?>
<?php if($___Ls->ls->chk=='ok'){ ?>
	<?php $___Ls->_bld_l_hdr(); ?>
	<?php if(($___Ls->qry->tot > 0)){  ?>
	
		<table width="100%" border="0" cellpadding="0" cellspacing="0" class="Ls_Rg">
			<tr>
			    <th width="1%" <?php echo NWRP ?>><?php echo TX_FM_No ?></th>
			    <th width="5%" <?php echo NWRP ?>><?php echo TX_NM?></th>
			    <th width="5%" <?php echo NWRP ?>><?php echo TX_PRNT1?></th>	  
			    <th width="1%" <?php echo NWRP ?>></th>
			</tr>
		    <?php do {  ?>                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                   
		  	<tr>  
				<td align="left" <?php echo $_clr_rw ?>><?php echo $___Ls->ls->rw[$___Ls->ino]; ?></td>
				<td width="30%" align="left" <?php echo $_clr_rw ?>><?php echo ctjTx($___Ls->ls->rw['oth_cnt_nm'],'in'); ?></td>
				<td width="30%" align="left" <?php echo $_clr_rw ?>><?php echo ctjTx($___Ls->ls->rw['sisslc_tt'],'in'); ?></td>
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
	  	
	  	<?php echo HTML_inp_hd('mdlcntvst_mdlcnt', $__i); ?>
	  	
     	<?php $___Ls->_bld_f_hdr(); ?>
	 	<div id="<?php echo $___Ls->fm->fld->id ?>" class="<?php echo DV_GNR_FM_CMP ?>">
	    <div class="ln_1">
		    
          <div class="col_1">	
		    <?php echo HTML_inp_tx('nm', TX_NM, ctjTx($___Ls->dt->rw['clftp_nm'],'in'), FMRQD); ?>      
            <?php echo HTML_inp_tx('hst',TX_HST, ctjTx($___Ls->dt->rw['clftp_hst'],'in'), FMRQD); ?> 
            <?php echo HTML_inp_tx('prt', TX_PRTO, ctjTx($___Ls->dt->rw['clftp_prt'],'in'), FMRQD); ?>
            <?php echo HTML_inp_tx('psv', TX_PRTO, ctjTx($___Ls->dt->rw['clftp_psv'],'in'), FMRQD); ?> 
            <?php echo HTML_inp_tx('tmout', TX_TMOT, ctjTx($___Ls->dt->rw['clftp_tmout'],'in'), FMRQD);?>             
          </div>
   
          <div class="col_2">
	      </div>


        </div>
      </div>
    </form>
  </div>
</div>
<?php } ?>
<?php } ?>