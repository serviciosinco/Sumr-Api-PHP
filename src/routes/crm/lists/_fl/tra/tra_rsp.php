<?php 
if(class_exists('CRM_Cnx')){
	
	$___Ls->cnx->cl = 'ok';
	$___Ls->sch->f = 'tra_dsc'; 
	$___Ls->_strt();
	
	if(_SbLs_ID('i')){ $__fl .= _AndSql('trarsp_tra', _SbLs_ID('i')); }
	
	if(!isN($___Ls->gt->i)){	

		$___Ls->qrys = sprintf("SELECT * FROM "._BdStr(DBM).TB_TRA_RSP.", "._BdStr(DBM).TB_US.", "._BdStr(DBM).TB_TRA."
						   WHERE trarsp_us = id_us AND
						   		 trarsp_tra = id_tra AND 
								 ".$___Ls->ik." = %s LIMIT 1", GtSQLVlStr($___Ls->gt->i, "text"));				 
		
	}elseif($___Ls->_show_ls == 'ok'){ 


		$Ls_Whr = "FROM "._BdStr(DBM).TB_TRA_RSP.", "._BdStr(DBM).TB_US.", "._BdStr(DBM).TB_TRA."
				   WHERE trarsp_us = id_us AND
						 trarsp_tra = id_tra AND
						 trarsp_tra = '".GtSQLVlStr($___Ls->gt->isb, "int")."' ".$___Ls->sch->cod." 
				   ORDER BY ".$__prfx->prfx3."_fi DESC";
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
            <th width="1%" <?php echo NWRP ?>><?php echo TX_USROL ?></th>
            <th width="1%" <?php echo NWRP ?>><?php echo TX_RSPNS ?></th>
            <th width="15%" <?php echo NWRP ?>><?php echo TX_ASGN ?></th>
            <th width="15%" <?php echo NWRP ?>><?php echo TX_DTE ?></th>
            <th width="5%" <?php echo NWRP ?>><?phpn echo TX_DSC ?></th>
            <th width="1%" <?php echo NWRP ?>></th>
        </tr>
  	</thead>
  	<tbody>
		<?php do { ?>
		<?php $Us_Dt = GtUsDt($___Ls->ls->rw['trarsp_us_asg']); ?>
        <tr>
	        <td width="1%" align="left" nowrap="nowrap"><?php echo Spn(GtUsRolDt(['ldr'=>$___Ls->ls->rw['trarsp_r_ldr'], 'col'=>$___Ls->ls->rw['trarsp_r_col'], 'eje'=>$___Ls->ls->rw['trarsp_r_eje'], 'aud'=>$___Ls->ls->rw['trarsp_r_aud']]), '', '_f'); ?></td>
	        <td width="1%" align="left" nowrap="nowrap"><?php echo ctjTx($___Ls->ls->rw['us_nm'].' '.$___Ls->ls->rw['us_ap'],'in'); ?></td>
	        <td width="15%" align="left" nowrap="nowrap"><?php echo $Us_Dt->nm_fll; ?></td>
	        <td width="15%" align="left" nowrap="nowrap"><?php echo Spn($___Ls->ls->rw['trarsp_fi'],'','_f'); ?></td>
	        <td width="5%" align="left" nowrap="nowrap"><?php echo ctjTx($___Ls->ls->rw['trarsp_dsc'],'in'); ?></td>
	        <td width="1%" align="left" nowrap="nowrap" class="_btn"><?php echo $___Ls->_btn([ 't'=>'mod' ]); ?></td>
        </tr>
        <?php } while ($___Ls->ls->rw = $___Ls->sql->fetch_assoc()); ?>
  </tbody>
</table>
<?php $___Ls->_bld_l_pgs(); ?>
<?php } ?>

<?php $___Ls->_h_ls_nr(); ?>
<?php } ?>
<?php if($___Ls->fm->chk=='ok'){ ?>
<div class="FmTb">
  <div id="<?php echo DV_GNR_FM.DV_SBCNT ?>">
    <?php 
	    ?>
    <?php 
		$__fm_trg = ' target="_self" name="'.$__fmnm.'" id="'.$__fmnm.'" ';
		//$__fm_trg = ' target="_blank" ';
	?>
    <form action="<?php echo Fl_Rnd(PRC_GN.__t($__bdtp,true)) ?>" method="POST" <?php echo $__fm_trg ?> >


      <?php $___Ls->_bld_f_hdr(); ?>

	 
		<div class="ln_1">
            <div class="col_1"> 
                <?php echo HTML_inp_hd('trarsp_us_asg', SISUS_ID); ?>
                <?php echo HTML_inp_hd('trarsp_tra', _SbLs_ID('i')); ?>
                <?php echo LsUs('trarsp_us','id_us', $___Ls->dt->rw['trarsp_us'], FM_LS_SLUSRSP, 2); $CntWb .= JQ_Ls('trarsp_us',FM_LS_SLUSRSP); ?>
                <?php $l = __Ls(['k'=>'tra_rsp', 'id'=>'trarsp_tp', 'va'=>$___Ls->dt->rw['trarsp_tp'] , 'ph'=>FM_LS_SLGN]); echo $l->html; $CntWb .= $l->js; ?>
            </div>
            <div class="col_2"> 
                <?php echo HTML_textarea('trarsp_dsc', TX_OBS, ctjTx($___Ls->dt->rw['trarsp_dsc'],'in'), '', 'ok'); ?>   
            </div>
        </div>
    </form>
  </div>
</div>
<?php } ?>
<?php } ?>
