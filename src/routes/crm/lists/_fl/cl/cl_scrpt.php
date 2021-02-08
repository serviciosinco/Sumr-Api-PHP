<?php
if(class_exists('CRM_Cnx')){

	$___Ls->_strt(); 
	
	if(!isN($___Ls->gt->i)){	
		 
		$___Ls->qrys = sprintf("SELECT *,
									"._QrySisSlcF([ 'als'=>'a', 'als_n'=>'accion' ])."	,
									"._QrySisSlcF([ 'als'=>'t', 'als_n'=>'tipo' ])."	
								FROM ".TB_CL_SCRPT."
									".GtSlc_QryExtra([ 't'=>'tb', 'col'=>'clscrpt_act', 'als'=>'a' ])."
									".GtSlc_QryExtra([ 't'=>'tb', 'col'=>'clscrpt_tp', 'als'=>'t' ])."
								WHERE ".$___Ls->ik." = %s 
								LIMIT 1", GtSQLVlStr($___Ls->gt->i, "text"));

	}elseif($___Ls->_show_ls == 'ok'){ 
			
		$Ls_Whr = " FROM ".TB_CL_SCRPT." 
						INNER JOIN ".TB_CL." ON clscrpt_cl = id_cl
						".GtSlc_QryExtra([ 't'=>'tb', 'col'=>'clscrpt_act', 'als'=>'a' ])."
						".GtSlc_QryExtra([ 't'=>'tb', 'col'=>'clscrpt_tp', 'als'=>'t' ])."
					WHERE ".$___Ls->ino." != '' ".$___Ls->sch->cod." AND cl_enc = '".$___Ls->gt->isb."' ORDER BY ".$___Ls->ino." DESC";
					
		$___Ls->qrys = "SELECT *, 
						"._QrySisSlcF([ 'als'=>'a', 'als_n'=>'accion' ]).",
						".GtSlc_QryExtra([ 't'=>'fld', 'p'=>'accion', 'als'=>'a' ]).",
						"._QrySisSlcF([ 'als'=>'t', 'als_n'=>'tipo' ]).",
						".GtSlc_QryExtra([ 't'=>'fld', 'p'=>'tipo', 'als'=>'t' ]).",
						(SELECT COUNT(*) $Ls_Whr) AS ".QRY_RGTOT." $Ls_Whr"; 

	} 
	
	
	$___Ls->_bld();

?>
<?php if($___Ls->ls->chk=='ok'){ ?>
<?php $___Ls->_bld_l_hdr(); ?>
<?php if(($___Ls->qry->tot > 0)){ ?>

<table width="100%" border="0" cellpadding="0" cellspacing="0" class="Ls_Rg">
  <tr>
    <th width="1%" <?php echo NWRP ?>><?php echo TX_FM_No ?></th>
    <th width="20%" <?php echo NWRP ?>><?php echo TX_NM ?></th>
    <th width="20%" <?php echo NWRP ?>><?php echo TX_TP ?></th>
    <th width="20%" <?php echo NWRP ?>><?php echo TX_VLE ?></th>
    <th width="20%" <?php echo NWRP ?>><?php echo TX_ORD ?></th>
    <th width="1%" <?php echo NWRP ?>><?php echo TX_RSPST ?></th> 
    <th width="1%" <?php echo NWRP ?>><?php echo TX_FNLZ ?></th> 
    <th width="1%" <?php echo NWRP ?>></th>
    <th width="1%" <?php echo NWRP ?>></th>
  </tr>
  <?php do { ?>

 
	<tr>
	    <td width="1%" <?php echo NWRP ?>><?php echo Spn($___Ls->ls->rw[$___Ls->ino]); ?></td>
	    <td width="20%" align="left" nowrap="nowrap"><?php echo ShortTx(ctjTx($___Ls->ls->rw['accion_sisslc_tt'],'in'),100,'Pt', true); ?></td>
	    <td width="20%" align="left" nowrap="nowrap"><?php echo ShortTx(ctjTx($___Ls->ls->rw['tipo_sisslc_tt'],'in'),100,'Pt', true); ?></td>  
	    <td width="20%" align="left"><?php echo ShortTx(ctjTx($___Ls->ls->rw['clscrpt_vl'],'in'),100,'Pt', true); ?></td>
	    <td width="20%" align="left" nowrap="nowrap"><?php echo ShortTx(ctjTx($___Ls->ls->rw['clscrpt_ord'],'in'),100,'Pt', true); ?></td>
	    <td width="1%" align="left" nowrap="nowrap"><?php echo Spn(mBln($___Ls->ls->rw['clscrpt_sino']),'',mBln($___Ls->ls->rw['clscrpt_sino'])); ?></td>
		<td width="1%" align="left" nowrap="nowrap"><?php echo Spn(mBln($___Ls->ls->rw['clscrpt_end']),'',mBln($___Ls->ls->rw['clscrpt_end'])); ?></td>
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

  	 <?php 
			
  			 
	?>             
    <form method="POST" name="<?php echo $___Ls->fm->id; ?>" target="_self" id="<?php echo $___Ls->fm->id; ?>">
     	<?php $___Ls->_bld_f_hdr(); ?>

      <div id="<?php echo $___Ls->fm->fld->id ?>" class="<?php echo DV_GNR_FM_CMP ?>">
	  
        <div class="ln_1">
          <div class="col_1">
                <?php 
	                echo HTML_inp_hd('clscrpt_cl', $___Ls->gt->isb);
	                
	                $l = __Ls(['k'=>'sis_scrpt_act', 'id'=>'clscrpt_act', 'va'=>$___Ls->dt->rw['clscrpt_act'] , 'ph'=>FM_LS_SLGN]); 
	                echo $l->html; $CntWb .= $l->js;
	                
	                $l = __Ls(['k'=>'sis_scrpt_tp', 'id'=>'clscrpt_tp', 'va'=>$___Ls->dt->rw['clscrpt_tp'] , 'ph'=>FM_LS_SLGN]); 
	                echo $l->html; $CntWb .= $l->js;
	                
	                echo HTML_inp_tx('clscrpt_ord', TX_ORD , ctjTx($___Ls->dt->rw['clscrpt_ord'],'in'), FMRQD);  
                ?> 
          </div>
          <div class="col_2">
	          	<?php 
					echo HTML_textarea('clscrpt_vl', '', ctjTx($___Ls->dt->rw['clscrpt_vl'],'in','', ['html'=>'ok','schr'=>'no','nl2'=>'no']), FMRQD, 'ok', '', 10);
					echo OLD_HTML_chck( 'clscrpt_sino', TX_RSPST, $___Ls->dt->rw['clscrpt_sino'], 'in');
					echo OLD_HTML_chck( 'clscrpt_end', TX_FNLZ, $___Ls->dt->rw['clscrpt_end'], 'in');
			  	?>
          </div>
        </div>
      </div>
    </form>
  </div>
</div>
<?php } ?>
<?php } ?>
