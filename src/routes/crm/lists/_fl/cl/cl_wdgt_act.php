<?php
if(class_exists('CRM_Cnx')){
	 	
	$___Ls->sch->f = 'clwdgtact_nm';
	$___Ls->new->w = 1000;
	$___Ls->new->h = 600;
	$___Ls->img->dir = DMN_FLE_CL_WDGT_ACT;
	$___Ls->img->svg = 'ok';
	$___Ls->_strt();

	if(!isN($___Ls->gt->isb)){ $__fl .= $___Ls->_andsql([ 'f'=>'clwdgt_enc', 'v'=>$___Ls->gt->isb ]); }
	
	if(!isN($___Ls->gt->i)){	
		
		$___Ls->qrys = sprintf("SELECT * 
								FROM "._BdStr(DBM).TB_CL_WDGT_ACT." 
									 INNER JOIN "._BdStr(DBM).TB_CL_WDGT." ON clwdgtact_clwdgt = id_clwdgt 
								WHERE ".$___Ls->ik." = %s 
								LIMIT 1", GtSQLVlStr($___Ls->gt->i, "text"));
		
	}elseif($___Ls->_show_ls == 'ok'){ 
	
		$Ls_Whr = "	FROM "._BdStr(DBM).TB_CL_WDGT_ACT."
						 INNER JOIN "._BdStr(DBM).TB_CL_WDGT." ON clwdgtact_clwdgt = id_clwdgt
						 ".GtSlc_QryExtra([ 't'=>'tb', 'col'=>'clwdgtact_chnl', 'als'=>'chnl' ])."
					WHERE ".$___Ls->ino." != '' $__fl ".$___Ls->sch->cod." 
					ORDER BY ".$___Ls->ino." DESC";
					
		$___Ls->qrys = "SELECT *, 
								(SELECT COUNT(*) $Ls_Whr) AS ".QRY_RGTOT.",
								"._QrySisSlcF([ 'als'=>'chnl', 'als_n'=>'channel' ]).", 
								".GtSlc_QryExtra([ 't'=>'fld', 'p'=>'channel', 'als'=>'chnl' ])."
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
				<th width="30%" <?php echo NWRP ?>><?php echo TX_NM ?></th>
				<th width="30%" <?php echo NWRP ?>><?php echo TX_CHNL ?></th>
				<th width="30%" <?php echo NWRP ?>><?php echo TX_BPO ?></th>
				<th width="1%" <?php echo NWRP ?>></th>
			</tr>
			<?php do { ?> 
				<tr>
					<td width="1%" <?php echo NWRP ?>><?php echo Spn($___Ls->ls->rw[$___Ls->ino]); ?></td>
					<td width="30%" align="left" nowrap="nowrap"><?php echo ShortTx(ctjTx($___Ls->ls->rw['clwdgtact_nm'],'in'),40,'Pt', true); ?></td>
					<td width="48%" align="left" <?php echo $_clr_rw ?>><?php echo ctjTx($___Ls->ls->rw['channel_sisslc_tt'],'in'); ?></td>
					<td width="48%" align="left" <?php echo $_clr_rw ?>><?php echo ctjTx($___Ls->ls->rw['clwdgtact_chnl_lne'],'in'); ?></td>
					<td width="1%" align="left" class="_btn"><?php echo $___Ls->_btn([ 't'=>'mod' ]); ?></td>
				</tr>
			<?php } while ($___Ls->ls->rw = $___Ls->sql->fetch_assoc()); ?>
		</table>
		<?php $___Ls->_bld_l_pgs(); ?>
	<?php } ?>
	<?php $___Ls->_h_ls_nr(); ?>
<?php } ?>
<?php if($___Ls->fm->chk=='ok'){ ?>
  	
	<div class="FmTb dsh_wdgt_action">
	  <div id="<?php  echo DV_GNR_FM ?>"> 
                                       
	    <form method="POST" name="<?php echo $___Ls->fm->id; ?>" target="_self" id="<?php echo $___Ls->fm->id; ?>" >
	      <?php $___Ls->_bld_f_hdr(); ?>      
		  <div id="<?php echo $___Ls->fm->fld->id ?>" class="<?php echo DV_GNR_FM_CMP ?>">			
	        <div class="ln_1">
			  	<div class="col_1">
				  	<?php echo HTML_inp_hd('clwdgtact_clwdgt', $__i); ?>
					<?php echo HTML_inp_tx('clwdgtact_nm', TX_NM, ctjTx($___Ls->dt->rw['clwdgtact_nm'],'in')); ?>
					<?php echo HTML_inp_tx('clwdgtact_dsc', TX_DSC, ctjTx($___Ls->dt->rw['clwdgtact_dsc'],'in')); ?>
					<?php echo HTML_inp_clr([ 'id'=>'clwdgtact_clr_bck', 'plc'=>'Fondo', 'vl'=>$___Ls->dt->rw['clwdgtact_clr_bck'] ]); ?>
					<?php echo HTML_inp_clr([ 'id'=>'clwdgtact_clr_fnt', 'plc'=>'Fuente', 'vl'=>$___Ls->dt->rw['clwdgtact_clr_fnt'] ]); ?>
					<?php echo OLD_HTML_chck('clwdgtact_e', TX_ACTV, $___Ls->dt->rw['clwdgtact_e'], 'in'); ?>
					<?php echo OLD_HTML_chck('clwdgtact_lnk_sms', 'SMS (Link)', $___Ls->dt->rw['clwdgtact_lnk_sms'], 'in'); ?>

					<?php
						if(mBln($___Ls->dt->rw['clwdgtact_lnk_sms']) == 'ok'){ 
							echo HTML_BR.LsClAwsAcc([ 'id'=>'clwdgtact_awsacc', 'v'=>'id_awsacc', 'va'=>$___Ls->dt->rw['clwdgtact_awsacc'], 'rq'=>2, 'cl'=>$___Ls->dt->rw['clwdgt_cl'] ]); $CntWb .= JQ_Ls('clwdgtact_awsacc','Cuenta Amazon');
						}
					?>
					
					<?php 
						
						if(!isN($___Ls->dt->rw['clwdgtact_enc'])){
							
							$___url_real = DMN_WDGT.'action/'.$___Ls->dt->rw['clwdgtact_enc'].'/';
							
							$ClsShorter = new CRM_Shrt();	
							$ClsShorter->shrt_url = $___url_real;
							$__shrt = $ClsShorter->get([ 'url'=>$ClsShorter->shrt_url ])->url;
							
							echo bdiv(['c'=>$__shrt, 'cls'=>'pml']);
							
						}
						
					?>
				</div>
				<div class="col_2">	
					<?php 
						$l = __Ls(['k'=>'wdgt_chnl', 'id'=>'clwdgtact_chnl', 'va'=>$___Ls->dt->rw['clwdgtact_chnl'] , 'ph'=>TX_CHNL]); 
						echo $l->html; $CntWb .= $l->js;
					?>
					<?php echo HTML_inp_tx('clwdgtact_chnl_acc', TX_ACC.' (Account)', ctjTx($___Ls->dt->rw['clwdgtact_chnl_acc'],'in')); ?>
					<?php echo HTML_inp_tx('clwdgtact_chnl_key', TX_KEY_API.' (Key)', ctjTx($___Ls->dt->rw['clwdgtact_chnl_key'],'in')); ?>
					<?php echo HTML_inp_tx('clwdgtact_chnl_lne', TX_BPO.' (Linea)', ctjTx($___Ls->dt->rw['clwdgtact_chnl_lne'],'in')); ?>
					<?php echo HTML_inp_tx('clwdgtact_chnl_que', TX_BPO.' (Cola)', ctjTx($___Ls->dt->rw['clwdgtact_chnl_que'],'in')); ?>
					<?php echo HTML_inp_tx('clwdgtact_tx_ph', TX_PLCH, ctjTx($___Ls->dt->rw['clwdgtact_tx_ph'],'in')); ?>
					<?php echo HTML_textarea('clwdgtact_wa_wlcm', TX_WAWLCM, ctjTx($___Ls->dt->rw['clwdgtact_wa_wlcm'],'in'), ''); ?> 
					
					<?php if($___Ls->dt->rw['clwdgtact_chnl'] == _Cns('ID_WDGTCHNL_MDLG')){ ?>
						<?php echo LsMdlGen([ 'id'=>'clwdgtact_mdlgen', 'v'=>'id_mdlgen', 'va'=>$___Ls->dt->rw['clwdgtact_mdlgen'], 'bd'=>DB_CL, 'prfx'=>'id_mdlgen', 'rq'=>2 ]); $CntWb .= JQ_Ls('clwdgtact_mdlgen'); ?>
					<?php } ?>
					
				</div>
			</div>
			
	      </div>
	    </form>
	  </div>
	</div>
	
	<style>
		
		.dsh_wdgt_action{ }
		.dsh_wdgt_action div.pml{ border-radius:8px;-moz-border-radius:8px;-webkit-border-radius:8px; margin-top: 30px; }
		
	</style>	
	
	   
<?php } ?>
<?php } ?>