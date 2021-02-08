<?php 
if(class_exists('CRM_Cnx')){
	$___Ls->sch->f = 'bn_tt, bn_ord';
	$___Ls->new->w = 700;
	$___Ls->new->h = 700;

	$___Ls->_strt();

	if(!isN($___Ls->gt->i)){	
		$___Ls->qrys = sprintf("SELECT * FROM ".TB_BN." WHERE ".$___Ls->ik." = %s LIMIT 1", GtSQLVlStr($___Ls->gt->i, "text"));
	}elseif($___Ls->_show_ls == 'ok'){ 	

		$Ls_Whr = "FROM ".TB_BN."
				INNER JOIN ".TB_CL." ON bn_cl = id_cl
		        INNER JOIN ".TB_MDL_S_TP." ON bn_tp = id_mdlstp
		        ".GtSlc_QryExtra([ 't'=>'tb', 'col'=>'bn_est', 'als'=>'e' ])."
		        ".GtSlc_QryExtra([ 't'=>'tb', 'col'=>'bn_frm', 'als'=>'f' ])."
		        ".GtSlc_QryExtra([ 't'=>'tb', 'col'=>'bn_prc', 'als'=>'p' ])."
		        ".GtSlc_QryExtra([ 't'=>'tb', 'col'=>'bn_pay', 'als'=>'py' ])." 
		        WHERE ".$___Ls->ino." != '' $_f_tp $__fl  $_f_tmpl ".$___Ls->sch->cod." AND cl_enc = '".DB_CL_ENC."'
		        ORDER BY ".$___Ls->ino." DESC";
				        
				        
		 $___Ls->qrys = "SELECT *, 
		        "._QrySisSlcF([ 'als'=>'e', 'als_n'=>'estado' ]).",
		        "._QrySisSlcF([ 'als'=>'f', 'als_n'=>'formato' ]).",
		        "._QrySisSlcF([ 'als'=>'p', 'als_n'=>'proceso' ]).",
		        "._QrySisSlcF([ 'als'=>'py', 'als_n'=>'pago' ]).",
		        ".GtSlc_QryExtra([ 't'=>'fld', 'p'=>'estado', 'als'=>'e' ]).",
		        ".GtSlc_QryExtra([ 't'=>'fld', 'p'=>'formato', 'als'=>'f' ]).", 
		        ".GtSlc_QryExtra([ 't'=>'fld', 'p'=>'proceso', 'als'=>'p' ]).",
		        ".GtSlc_QryExtra([ 't'=>'fld', 'p'=>'pago', 'als'=>'py' ]).", 
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
		<th width="80%" <?php echo NWRP ?>><?php echo TX_NM ?></th>
		<th width="1%" <?php echo NWRP ?>><?php echo TX_COD ?></th>
		<th width="1%" <?php echo NWRP ?>><?php echo TX_PRC ?></th>
		<th width="1%" <?php echo NWRP ?>><?php echo TX_ORD ?></th>
		<th width="1%" <?php echo NWRP ?>><?php echo TX_WDT ?></th>
		<th width="1%" <?php echo NWRP ?>><?php echo TX_HGT ?></th>
		<th width="1%" <?php echo NWRP ?>><?php echo TX_PGD ?></th>
		<th width="1%" <?php echo NWRP ?>>&nbsp;</th>
		<th width="1%" <?php echo NWRP ?>>&nbsp;</th>
		<th width="1%" <?php echo NWRP ?>>&nbsp;</th>  
  	</tr>
  	<?php do { ?>
  	<tr>   
   		<td width="1%" <?php echo NWRP ?>><?php echo Spn($___Ls->ls->rw[$___Ls->ino]); ?></td>
        <td width="80%" align="left" nowrap="nowrap"><?php echo ShortTx(ctjTx($___Ls->ls->rw['bn_tt'],'in'),100,'Pt', true) . HTML_BR.Spn(ctjTx($___Ls->ls->rw['_fac_tt'],'in'), '', '_f'); ?> </td>
        <td width="1%" align="left" <?php echo $_clr_rw ?>><?php echo _sino($___Ls->ls->rw['bn_wr']); ?></td>
        <td width="1%" align="left" nowrap="nowrap"><?php echo ctjTx($___Ls->ls->rw['proceso_sisslc_tt'],'in').'</br>'.Spn($___Ls->ls->rw['formato_sisslc_tt']); ?></td>
        <td width="1%" align="left" nowrap="nowrap"><?php echo ctjTx($___Ls->ls->rw['bn_ord'],'in'); ?></td>
        <td width="1%" align="left" nowrap="nowrap"><?php echo $___Ls->ls->rw['bn_w']; ?></td>
        <td width="1%" align="left" nowrap="nowrap"><?php echo $___Ls->ls->rw['bn_h']; ?></td>
        <td width="1%" align="left" nowrap="nowrap"><?php echo _sino($___Ls->ls->rw['bn_pay'], ['r'=>'spn'] ); ?></td>

        <?php if($___Ls->ls->rw['bn_h_vd'] != ''){ $bn_h_vd = $___Ls->ls->rw['bn_h_vd']+30; }else{ $bn_h_vd = $___Ls->ls->rw['bn_h_vd']; }?>
        <?php if($___Ls->ls->rw['bn_w_vd'] != ''){ $bn_w_vd = $___Ls->ls->rw['bn_w_vd']+30; }else{ $bn_w_vd = $___Ls->ls->rw['bn_w_vd']; }?>
        
        <td width="1%" align="left" nowrap="nowrap" class="_btn"><?php echo $___Ls->_btn([ 't'=>'mod' ]); ?></td>
        <td width="1%" align="left" nowrap="nowrap" class="_btn"><?php echo HTML_Ls_Btn(['t'=>'dwn', 'l'=>DMN_DWN.PrmLnk('bld', LNK_BN).$___Ls->ls->rw['bn_enc'] , 'trg'=>'_blank']); ?></td>
        <td width="1%" align="left" nowrap="nowrap" class="_btn"><?php echo HTML_Ls_Btn(['t'=>'onl', 'l'=>Fl_Rnd(FL_DT_GN.__t('bn',true).Fl_i($___Ls->ls->rw['bn_enc'])), 'cls'=>($___Ls->ls->rw['bn_frm'] == 8) ? "_onlbnr_vd_".$row_Ls_Rg['id_bn'] :"_onlbnr"]); ?></td>
		<?php 
			$CntWb .= '
						 $("._onlbnr_vd_'.$___Ls->ls->rw['id_bn'].'").colorbox({ width:"'.$bn_w_vd.'px", height:"'.$bn_h_vd.'px", transition:"fade", speed:500, scalePhotos:true }); 
						 
			';  
			$CntWb .= '
				$("._rpr").colorbox({ width:"450px", height:"400px", overlayClose:false, escKey:false}); 
				$("._onlbnr").colorbox({ transition:"fade", speed:500, scalePhotos:true });
			'; 
		?>
        
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
			<form method="POST" name="<?php echo $___Ls->fm->id; ?>" target="_self" id="<?php echo $___Ls->fm->id; ?>" >
				<?php $___Ls->_bld_f_hdr(); ?>      
				<div id="<?php echo $___Ls->fm->fld->id ?>" class="<?php echo DV_GNR_FM_CMP ?>">
					<div class="ln_1">
						<?php echo HTML_inp_hd('bn_enc', $___Ls->dt->rw['bn_enc']); ?>
						<?php echo HTML_inp_hd('bn_tp', $___Ls->gt->tsb); ?>  
						<div class="col_1">

							<?php $l = __Ls(['k'=>'bn_frm', 'id'=>'bn_frm', 'va'=>$___Ls->dt->rw['bn_frm'] , 'ph'=>'Formato']); echo $l->html; $CntWb .= $l->js; ?>
							
							<?php echo HTML_inp_tx('bn_tt', TX_NM, ctjTx($___Ls->dt->rw['bn_tt'],'in'), FMRQD); ?>
							<?php echo HTML_inp_tx('bn_ord', 'Orden', ctjTx($___Ls->dt->rw['bn_ord'],'in'), FMRQD); ?>
							
							<?php $l = __Ls(['k'=>'bn_prc', 'id'=>'bn_prc', 'va'=>$___Ls->dt->rw['bn_prc'] , 'ph'=>'Proceso']); echo $l->html; $CntWb .= $l->js; ?>
							<?php $l = __Ls(['k'=>'bn_est', 'id'=>'bn_est', 'va'=>$___Ls->dt->rw['bn_est'] , 'ph'=>'Estado']); echo $l->html; $CntWb .= $l->js; ?>
							
							<?php echo HTML_inp_tx('bn_url_abs', 'URL Absoluto', ctjTx($___Ls->dt->rw['bn_url_abs'],'in'), FMRQD); ?>
							<?php echo HTML_inp_tx('bn_edge_id', 'Id Edge', ctjTx($___Ls->dt->rw['bn_edge_id'],'in'), FMRQD); ?>
							<?php echo HTML_inp_tx('bn_h', 'Height', ctjTx($___Ls->dt->rw['bn_h'],'in'), FMRQD); ?>
							<?php echo HTML_inp_tx('bn_w', 'Width', ctjTx($___Ls->dt->rw['bn_w'],'in'), FMRQD); ?>
							
							<?php echo HTML_inp_tx('bn_fps', 'FPS', ctjTx($___Ls->dt->rw['bn_fps'],'in'), FMRQD); ?>	
							<?php echo HTML_inp_tx('bn_crsl', 'Carrousel', ctjTx($___Ls->dt->rw['bn_crsl'],'in'), FMRQD); ?>
							
						</div>
						<div class="col_2">
							
							<?php $l = __Ls(['k'=>'sis_pay_est', 'id'=>'bn_pay', 'va'=>$___Ls->dt->rw['bn_pay'] , 'ph'=>'Pago']); echo $l->html; $CntWb .= $l->js; ?>
							<?php echo HTML_textarea('bn_dsc', TX_DSC, ctjTx($___Ls->dt->rw['bn_dsc'],'in'), FMRQD, 'ok');  ?>
							
							<?php if($___Ls->dt->tot > 0){ ?>
							<div id="_upl_fle"></div>
							<?php $CntWb .= "_ldCnt({ u:'".Fl_Rnd(FL_FM_GN.__t('up_bn',true)).Fl_i($___Ls->dt->rw[$___Ls->ik])."', c:'_upl_fle' });"; ?>
							<?php } ?>
							
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
<?php } ?>
<?php } ?>