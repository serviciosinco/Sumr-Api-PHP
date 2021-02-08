<?php
if(class_exists('CRM_Cnx')){
	
	$___Ls->tp = 'sis_slc_tp_f';
	$___Ls->sch->f = 'sisslctpf_tt';
	$___Ls->new->w = 600;
	$___Ls->new->h = 600;
	$___Ls->ls->lmt = 1000;
	
	if($___Ls->gt->tsb == 'cl'){
		 
		$___Ls->cnx->cl = 'ok';
		$__bd = TB_CL_SLC_TP_F; 
		$__bd2 = TB_CL_SLC_TP;
		
		
	}else{
	
		$__bd = TB_SIS_SLC_TP_F; 	
		$__bd2 = TB_SIS_SLC_TP;
		
	}	
	
	if(!ChckSESS_superadm()){ $__fl .= _AndSql('id_us', SISUS_ID); }
	$___Ls->_strt();	
	
	if(!isN($___Ls->gt->i)){
			
		$___Ls->qrys = sprintf("SELECT * FROM $__bd WHERE ".$___Ls->ik." = %s LIMIT 1", GtSQLVlStr($___Ls->gt->i, "text"));
		
	}elseif($___Ls->_show_ls == 'ok'){ 

		$Ls_Whr = "FROM $__bd
				   INNER JOIN "._BdStr(DBM).MDL_SIS_TP_DT_BD." ON sisslctpf_tpd = id_sistpdt
				   WHERE ".$___Ls->ino." != '' AND sisslctpf_tp = (SELECT id_sisslctp FROM ".$__bd2." WHERE sisslctp_enc = ".GtSQLVlStr($___Ls->gt->isb, "text").")".$___Ls->sch->cod." ORDER BY sisslctpf_ord, sisslctpf_tt ASC, sisslctpf_tt DESC";
		$___Ls->qrys = "SELECT *, (SELECT COUNT(*) $Ls_Whr) AS ".QRY_RGTOT." $Ls_Whr"; 

	} 

	$___Ls->_bld(); 
	
?>
<?php if($___Ls->ls->chk=='ok'){ ?>
<?php $___Ls->_bld_l_hdr(); ?>
<?php if(($___Ls->qry->tot > 0)){ ?>
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="Ls_Rg">
  	<tr>
    	<th width="1%" <?php echo NWRP ?>><?php echo TX_FM_No ?></th>
    	<th width="49%" <?php echo NWRP ?>><?php echo TX_TT ?></th>
    	<th width="49%" <?php echo NWRP ?>><?php echo TX_TP ?></th>
    	<th width="1%" <?php echo NWRP ?>><?php echo TX_ORD ?></th>
    	<th width="1%" <?php echo NWRP ?>></th>
  	</tr>
  	<?php do { ?>
  	<tr>
    	<td width="1%" <?php echo NWRP ?>><?php echo Spn($___Ls->ls->rw[$___Ls->ino]); ?></td>
		<td width="49%" align="left" nowrap="nowrap"><?php echo ShortTx(ctjTx($___Ls->ls->rw['sisslctpf_tt'],'in'),40,'Pt', true); ?></td>
		<td width="49%" align="left" nowrap="nowrap"><?php echo ShortTx(ctjTx($___Ls->ls->rw['sistpdt_tt'],'in'),40,'Pt', true); ?></td>
		<td width="1%" align="left" nowrap="nowrap"><?php echo ShortTx(ctjTx($___Ls->ls->rw['sisslctpf_ord'],'in'),40,'Pt', true); ?></td>
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
    <form method="POST" name="<?php echo $___Ls->fm->id; ?>" target="_self" id="<?php echo $___Ls->fm->id; ?>" >
      <?php $___Ls->_bld_f_hdr(); ?>

      <div id="<?php echo $___Ls->fm->fld->id ?>" class="<?php echo DV_GNR_FM_CMP ?>">
	  
        <div class="ln_1">
		  	<?php echo HTML_inp_tx('sisslctpf_tt', TX_TT , ctjTx($___Ls->dt->rw['sisslctpf_tt'],'in'), FMRQD); ?>
		  	<?php 
			  	if($___Ls->dt->tot != 1){
				  	if($__i != ''){
						echo HTML_inp_hd('sisslctpf_tp', $__i);	
				  	}else{
				  		echo LsSisSlcTp('sisslctpf_tp','id_sisslctpftp', $___Ls->dt->rw['sisslctpf_tp'], TX_SLCTP, 2); $CntWb .= JQ_Ls('sisslctpf_tp',TX_SLCTP);
				  	}   
			  	}	
			?>
			<?php echo HTML_inp_tx('sisslctpf_key', TX_KEY , ctjTx($___Ls->dt->rw['sisslctpf_key'],'in'), FMRQD); ?>
			<?php echo HTML_inp_tx('sisslctpf_cns', TX_CNST , ctjTx($___Ls->dt->rw['sisslctpf_cns'],'in')); ?>
			<?php echo HTML_inp_tx('sisslctpf_ord', TX_ORD , ctjTx($___Ls->dt->rw['sisslctpf_ord'],'in')); ?>
			<?php echo LsSisTpDt('sisslctpf_tpd','id_sistpdt', $___Ls->dt->rw['sisslctpf_tpd'], TX_SLCTPDT, 2, ''); $CntWb .= JQ_Ls('sisslctpf_tpd',TX_SLCTPDT); ?>
			<?php echo OLD_HTML_chck('sisslctpf_rqd', TX_CHK_RQR, $___Ls->dt->rw['sisslctpf_rqd'], 'in'); ?>
        </div>
      </div>
    </form>
  	</div>
</div>
<?php } ?>
<?php } ?> 
