<?php
	if(class_exists('CRM_Cnx') ){
		
		
	
		$___Ls->cnx->cl = 'ok';
		$___Ls->tp = 'cnt_ec';
		$___Ls->ino = 'id_ecsnd';
		$___Ls->ik = 'ecsnd_enc';
		$___Ls->_strt();

		if(!isN($___Ls->gt->i)){
		
			$___Ls->qrys = sprintf(" SELECT ecsndhtml_html FROM ".TB_EC_SND." INNER JOIN ".TB_EC_SND_HTML." ON ecsndhtml_ecsnd = id_ecsnd WHERE ".$___Ls->ik." = %s LIMIT 1", GtSQLVlStr($___Ls->gt->i, "text"));
			
			echo $___Ls->qrys;
		
		}elseif($___Ls->_show_ls == 'ok'){  
		
			$Ls_TotApr = ", (SELECT COUNT(*) FROM ".TB_EC_OP." WHERE ecop_snd = id_ecsnd) AS __tot_apr ";
		
			$Ls_Whr = "FROM ".TB_CNT."
							INNER JOIN ".TB_EC_SND." ON ecsnd_cnt = id_cnt
							INNER JOIN ".TB_EC_SND_HTML." ON ecsndhtml_ecsnd = id_ecsnd
							INNER JOIN "._BdStr(DBM).TB_EC." ON ecsnd_ec = id_ec
							INNER JOIN "._BdStr(DBM).TB_SIS_SLC." ON ecsnd_est = id_sisslc
							LEFT JOIN ".TB_MDL_CNT_EC." ON mdlcntec_ecsnd = id_ecsnd
							WHERE ".$___Ls->ino." AND cnt_enc = '".$___Ls->gt->isb."' ".$___Ls->sch->cod."";
			
			$___Ls->qrys = "SELECT id_mdlcntec,ec_tt,ecsnd_eml,ecsnd_f,ecsnd_h,id_ecsnd,ecsnd_enc, (SELECT COUNT(*) $Ls_Whr) AS ".QRY_RGTOT."  $Ls_TotApr $Ls_Whr";
		
		} 
		
		$___Ls->_bld();
		
?>
<?php if($___Ls->ls->chk=='ok'){ ?>
	<?php if(($___Ls->qry->tot > 0)){ ?>
		<table width="100%" border="0" cellpadding="0" cellspacing="0" class="Ls_Rg">
			<thead>
				<tr>
					<th width="5%" <?php echo NWRP ?>></th>
					<th width="30%" <?php echo NWRP ?>><?php echo TX_TP ?></th>
					<th width="20%" <?php echo NWRP ?>><?php echo TX_SND ?></th>
					<th width="40%" <?php echo NWRP ?>><?php echo TX_EML ?></th>
					<th width="1%" <?php echo NWRP ?>><?php echo TX_EML_APR ?></th>
					<th width="1%" <?php echo NWRP ?>><?php echo TX_FIN ?></th>
					<th width="1%" <?php echo NWRP ?>><?php echo TX_HR ?></th>
					<th width="1%" <?php echo NWRP ?>></th>
					<th width="1%" <?php echo NWRP ?>></th>
				</tr>
			</thead>  
			<tbody>
				<?php do { ?>
				<tr>
					<?php 
					
						$__toa_attr = NULL;
						
						if($___Ls->ls->rw['__tot_apr'] > 0){
							$__cls_snd = 'opn';
							$__tt_snd = 'Abierto';
						}
					
					?>
					
					<td width="5%" align="left"><?php echo Spn('','','_ec_snd _ec_snd_'.$__cls_snd); ?></td> 
					<td width="30%" align="left" nowrap="nowrap" ><?php if(!isN($___Ls->ls->rw['id_mdlcntec'])){ echo 'Envio Oportunidad'; }else{ echo 'Envio Masivo'; } ?></td>      
					<td width="20%" align="left" >
						<div style="text-overflow:ellipsis; overflow: hidden; width: 100%; ">
							<?php echo ctjTx($___Ls->ls->rw['ec_tt'],'in'); ?>
						</div>
					</td>
					<td width="40%" align="left" nowrap="nowrap" ><?php echo ctjTx($___Ls->ls->rw['ecsnd_eml'],'in').HTML_BR.Spn($__tt_snd, 'ok', '_tx'); ?></td>
					<td width="1%" align="left" nowrap="nowrap" ><?php echo Spn(ctjTx($___Ls->ls->rw['__tot_apr'],'in'),'','_nmb'); ?></td>
					<td width="1%" align="left" nowrap="nowrap" ><?php echo Spn($___Ls->ls->rw['ecsnd_f'],'','_f') ?></td>
					<td width="1%" align="left" nowrap="nowrap" ><?php echo Spn($___Ls->ls->rw['ecsnd_h'],'','_f') ?></td>
					<td width="1%" align="left" nowrap="nowrap" class="_btn"><?php echo $___Ls->_btn([ 't'=>'dtl', 'shw' => 'ok' ]); ?></td>
				</tr>
				<?php } while ($___Ls->ls->rw = $___Ls->sql->fetch_assoc()); ?>
				<?php $CntWb .= " $('#".TBGRP."_ec ._n').html(' (".$___Ls->qry->tot.")'); "; ?>
			</tbody>
		</table>
		<?php $___Ls->_bld_l_pgs(); ?>
	<?php } ?>
	<?php $___Ls->_h_ls_nr(); ?>
<?php } ?>
	<?php if($___Ls->fm->chk=='ok'){ ?>
		<div class=""> </div>
		<?php 


			echo h1(DIR_FLE_EC_SND.$_enc_s3.'.html');
			
			$___ec_html = $_aws->_s3_get([ 'b'=>'fle', 'fle'=> DIR_FLE_EC_SND.$_enc_s3.'.html' ]);

			print_r($___ec_html);

			/*$_hmtl = $___Ls->dt->rw['ecsndhtml_html'];
			
			$_img = DMN_TRCK.PXLNM;
			$_hmtl = str_replace($_img, "#", $___Ls->dt->rw['ecsndhtml_html']);

			echo $_hmtl;*/
		?>		
	<?php } ?>
<?php } ?>