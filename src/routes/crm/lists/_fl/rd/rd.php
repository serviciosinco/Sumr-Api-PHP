<?php
if(class_exists('CRM_Cnx')){
	
	$___Ls->sch->f = 'rd_tt, rd_ord';
	$___Ls->new->w = 800;
	$___Ls->new->h = 820;
	$___Ls->edit->w = 800;
	$___Ls->edit->h = 820;
	
	$___Ls->_strt();
	
	
	if(!isN($___Ls->gt->i)){	
		$___Ls->qrys = sprintf("SELECT * FROM ".TB_RD." WHERE ".$___Ls->ik." = %s LIMIT 1", GtSQLVlStr($___Ls->gt->i, "text"));	
	}elseif($___Ls->_show_ls == 'ok'){ 	
		$Ls_Whr = " FROM ".TB_RD." 
						INNER JOIN ".TB_CL." ON id_cl = rd_cl
						INNER JOIN ".TB_CL_ARE." ON id_clare = rd_are
						".GtSlc_QryExtra([ 't'=>'tb', 'col'=>'rd_est', 'als'=>'est' ])."
						".GtSlc_QryExtra([ 't'=>'tb', 'col'=>'rd_pay', 'als'=>'pay' ])."
			 
					WHERE ".$___Ls->ino." != '' ".$___Ls->sch->cod." AND cl_enc = '".CL_ENC."' ORDER BY ".$___Ls->ino." DESC";

		$___Ls->qrys = "SELECT id_rd, rd_enc, rd_fi, rd_ord, rd_tt, rd_fle, rd_pml,
						
						"._QrySisSlcF([ 'als'=>'est', 'als_n'=>'estado' ]).",
						".GtSlc_QryExtra([ 't'=>'fld', 'p'=>'estado', 'als'=>'est' ]).",
						
						"._QrySisSlcF([ 'als'=>'pay', 'als_n'=>'pago' ]).",
						".GtSlc_QryExtra([ 't'=>'fld', 'p'=>'pago', 'als'=>'pay' ]).",
		
						(SELECT COUNT(*) $Ls_Whr) AS ".QRY_RGTOT." $Ls_Whr"; 
			
	} 
	$___Ls->_bld();
?>
<?php if($___Ls->ls->chk=='ok'){ ?>
<?php $___Ls->_bld_l_hdr();?>
<?php if(($___Ls->qry->tot > 0)){ ?>
<?php 
	$__dmn = GtClDmnSubDt([ 't'=>'tp', 'id'=>'rd' ]);
?>
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="Ls_Rg">
  	<tr>
    	<th width="1%" <?php echo NWRP ?>><?php echo TX_FM_No ?></th>
    	<th width="5%" <?php echo NWRP ?>><?php echo TX_FING ?></th>
    	<th width="5%" <?php echo NWRP ?>><?php echo TX_ORDN ?></th>
    	<th width="48%" <?php echo NWRP ?>><?php echo TX_TTLO ?></th>
		<th width="1%" <?php echo NWRP ?>><?php echo 'PDF' ?></th>
    	<th width="5%" <?php echo NWRP ?>><?php echo TX_TP ?></th>
    	<th width="5%" <?php echo NWRP ?>><?php echo TX_ETD ?></th>
    	<th width="5%" <?php echo NWRP ?>><?php echo TX_PGD ?></th>
    	<th width="1%" <?php echo NWRP ?>></th>
    	<th width="1%" <?php echo NWRP ?>></th>
  	</tr>
  	<?php do { ?> 
  	<tr> 
		<td width="1%" <?php echo NWRP ?>><?php echo Spn($___Ls->ls->rw[$___Ls->ino]); ?></td>
		
		<td width="5%" align="left" nowrap="nowrap"><?php echo ShortTx(ctjTx($___Ls->ls->rw['rd_fi'],'in'),40,'Pt', true); ?></td>
		<td width="5%" align="left" nowrap="nowrap"><?php echo ShortTx(ctjTx($___Ls->ls->rw['rd_ord'],'in'),150,'Pt', true); ?></td>
		<td width="48%" align="left" nowrap="nowrap"><?php echo ShortTx(ctjTx($___Ls->ls->rw['rd_tt'],'in'),40,'Pt', true); ?></td>
		<td width="1%" align="left" nowrap="nowrap">
			<?php if(!isN($___Ls->ls->rw['rd_fle'])){
				echo Spn('','','_rd_est','background-color:#00ffa1;');
			}else{
				echo Spn('','','_rd_est','background-color:#f16464;');
			} ?>
		</td>
		<td width="5%" align="left" nowrap="nowrap"><?php echo ShortTx(ctjTx($___Ls->ls->rw['estado_sisslc_tt'],'in'),40,'Pt', true); ?></td>
		<td width="5%" align="left" nowrap="nowrap"><?php echo ShortTx(ctjTx($___Ls->ls->rw['pago_sisslc_tt'],'in'),150,'Pt', true); ?></td>
		
		<td width="1%" align="left" nowrap="nowrap" class="_btn"><?php echo $___Ls->_btn([ 't'=>'mod' ]); ?></td>
		<td width="1%" align="left" nowrap="nowrap" class="_btn"><?php echo HTML_Ls_Btn(['t'=>'onl', 'l'=>( !isN($__dmn->url) ? $__dmn->url : DMN_DG ).$___Ls->ls->rw['rd_pml'],'trg'=>'_blank', 'cls'=>($___Ls->ls->rw['bn_frm'] == 8) ? "_onlbnr_vd_".$row_Ls_Rg['id_bn'] :"_onlbnr"]); ?></td>
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
    <form method="POST" name="<?php echo $___Ls->fm->id; ?>" target="_self" id="<?php echo $___Ls->fm->id; ?>">
      	<?php $___Ls->_bld_f_hdr(); ?>      
	  	<div id="<?php echo $___Ls->fm->fld->id ?>" class="<?php echo DV_GNR_FM_CMP ?>">
	  	<div id="<?php echo $___Ls->fm->fld->id ?>" class="<?php echo DV_GNR_FM_CMP ?>">
        <div class="ln_1">
	        <div class="col_1">
		        
		        <?php 
			        echo LsClAre([
							        'id'=>'rd_are',
							        'v'=>'id_clare',
							        'va'=>$___Ls->dt->rw['rd_are'],
							        'rq'=>2,
							        'mlt'=>'no'
						        ]); 
			        
			        $CntWb .= JQ_Ls('rd_are',MDL_CL_ARE); 
			        
			        echo HTML_inp_tx('rd_ord', TX_ORDN , ctjTx($___Ls->dt->rw['rd_ord'],'in'), FMRQD);
			        echo HTML_inp_tx('rd_tt', TX_TT, ctjTx($___Ls->dt->rw['rd_tt'],'in'), FMRQD, 'onblur="SUMR_Main.pml.input({ tt:\'rd_tt\', pml:\'rd_pml\' });"');  
			        echo HTML_inp_tx('rd_st', TT_FM_SBT , ctjTx($___Ls->dt->rw['rd_st'],'in'), FMRQD); 
			        echo HTML_inp_tx('rd_pml', TX_PML, ctjTx($___Ls->dt->rw['rd_pml'],'in'), FMRQD, 'onfocus="SUMR_Main.pml.input({ tt:\'rd_tt\', pml:\'rd_pml\' });"');
			        echo HTML_inp_tx('rd_pg', TX_N_PG , ctjTx($___Ls->dt->rw['rd_pg'],'in'), FMRQD);
			        
			        echo SlDt([ 'id'=>'rd_fp', 'va'=>ctjTx($___Ls->dt->rw['rd_fp'],'in'), 'rq'=>'no', 'ph'=>TX_FCH_PBL, 'lmt'=>'no', 'yr'=>'ok', 'cls'=>CLS_CLND ]);
			        
			        echo HTML_inp_tx('rd_dir', TX_DIR , ctjTx($___Ls->dt->rw['rd_dir'],'in'), FMRQD);
			        
			        $l = __Ls(['k'=>'rd_tp', 'id'=>'rd_tp', 'v'=>'id_sisslc', 'va'=>$___Ls->dt->rw['rd_tp'] , 'ph' => TX_TP]); echo $l->html; $CntWb .= $l->js;
			        
			        
			        /*echo HTML_inp_tx('rd_authid', ID_AUTHID , ctjTx($___Ls->dt->rw['rd_authid'],'in'), FMRQD);
			        echo HTML_inp_tx('rd_issuu', TX_ID , ctjTx($___Ls->dt->rw['rd_issuu'],'in'), FMRQD);*/
			        echo HTML_textarea('rd_dsc', TX_DSC, ctjTx($___Ls->dt->rw['rd_dsc'], 'in'));
			        
			        
		        ?>
				
				<ul class="upl_img_opt">
					<li><button class="_anm upl_img upl_bck" id="<?php echo 'upl_bck_'.$___Ls->fm->id; ?>"> <span class="_anm">Background</span></button></li>
				</ul>
				<?php 				
					$_f = HTML_ClrBxImg('rd_bck').$___Ls->uidn;
					$CntWb .= $___Ls->_h_fm_img([ 'b'=>'upl_bck_'.$___Ls->fm->id, 'u'=>$_f ]);
				?>
	        </div>
	        <div class="col_2">
		        
				<?php 
					
					/*echo HTML_inp_tx('rd_w', TX_WDTH , ctjTx($___Ls->dt->rw['rd_w'],'in'), FMRQD);
					echo HTML_inp_tx('rd_h', TX_HEGT , ctjTx($___Ls->dt->rw['rd_h'],'in'), FMRQD);
					echo HTML_inp_tx('rd_w_z', TX_WDTH_Z , ctjTx($___Ls->dt->rw['rd_w_z'],'in'), FMRQD);
					echo HTML_inp_tx('rd_h_z', TX_HEGT_Z , ctjTx($___Ls->dt->rw['rd_h_z'],'in'));
					echo HTML_inp_tx('rd_fnd', TX_BCKG , ctjTx($___Ls->dt->rw['rd_fnd'],'in'), FMRQD);
					
					echo HTML_inp_tx('rd_clr', TX_CLR , ctjTx($___Ls->dt->rw['rd_clr'],'in'), FMRQD); */
					
					$l = __Ls(['k'=>'sis_est', 'id'=>'rd_est', 'v'=>'id_sisslc', 'va'=>$___Ls->dt->rw['rd_est'] , 'ph' => TX_ETD]); echo $l->html; $CntWb .= $l->js;
					$l = __Ls(['k'=>'sis_pay_est', 'id'=>'rd_pay', 'v'=>'id_sisslc', 'va'=>$___Ls->dt->rw['rd_pay'] , 'ph' => TX_PGD]); echo $l->html; $CntWb .= $l->js;
					
					if($___Ls->dt->tot > 0){ ?>
						
						<div id="_upl_fle"></div>
						<?php $CntWb .= "_ldCnt({ u:'".Fl_Rnd(FL_FM_GN.__t('up_rd',true))."', c:'_upl_fle', d: { __i: '".$___Ls->gt->i."', _t: 'rd_fle' } });"; ?> 
						
					<?php }
				?>

				<?php echo h2('Opciones'); ?>
				<?php echo OLD_HTML_chck('rd_logo', 'Logo', $___Ls->dt->rw['rd_logo'], 'in'); ?>

				<?php echo h2('Theme'); ?>
				<?php $l = __Ls(['k'=>'rd_thme', 'id'=>'rd_thme', 'v'=>'id_sisslc', 'va'=>$___Ls->dt->rw['rd_thme'] , 'ph' => TX_THME]); echo $l->html; $CntWb .= $l->js; ?>


				<?php echo h2('Background'); ?>
				<?php $l = __Ls(['k'=>'rd_bckg', 'id'=>'rd_bckg', 'v'=>'id_sisslc', 'va'=>$___Ls->dt->rw['rd_bckg'] , 'ph' => TX_THME]); echo $l->html; $CntWb .= $l->js; ?>
		        
	        </div>
	       
          	
        </div>
      	</div>
    </form>
  	</div>
</div>
<?php } ?>
<?php } ?>
<style>
	span._rd_est {width: 20px;height: 20px;display: block;border-radius: 25px;margin: 0 auto;}
</style>