
<?php
if(class_exists('CRM_Cnx')){

	$___Ls->ino = 'id_mdlcntcnv';
    $___Ls->ik = 'mdlcntcnv_enc';
	$___Ls->cnx->cl = 'ok';
	$___Ls->_strt();

	if($___Ls->gt->tsb_d == 'tra'){
		$_dt_tra = GtTraDt([ 'id'=>$___Ls->gt->isb, 't'=>'enc' ]);
		$__dt_mdlcnt = GtMdlCntDt([ 'id'=>$_dt_tra->mdl_cnt->id, 'shw'=>[ 'cnt'=>'ok' ] ]);
	}
	
	if($___Ls->_show_ls == 'ok'){  
		
		$Ls_Whr = "FROM ".TB_MDL_CNT_CNV."
						INNER JOIN ".TB_MDL_CNT." ON mdlcntcnv_mdlcnt = id_mdlcnt
						INNER JOIN "._BdStr(DBC).TB_MAIN_CNV." ON mdlcntcnv_cnv = id_maincnv
				   WHERE (".$___Ls->ino." IS NOT NULL) AND mdlcntcnv_mdlcnt='".$__dt_mdlcnt->id."'		
				   ORDER BY ".$___Ls->ino." DESC";
				   		   
		$___Ls->qrys = "SELECT id_maincnv, maincnv_enc, maincnv_id, maincnv_tp, maincnv_lmsj,
								(SELECT COUNT(*) $Ls_Whr) AS ".QRY_RGTOT."
						$Ls_Whr";
		
	}
	
	if($___Ls->gt->m == 'eml'){
		$___Ls->tt = 'Enviar email a cliente';
	}

	$___Ls->_bld();
?>
<?php if($___Ls->ls->chk=='ok'){ ?>

	<?php if(_SbLs_ID('i')){ ?>
	<div class="<?php echo ID_HDRLS ?> lead_pushmail_list">
		
		<div class="btn" style="text-align:right; display:block; width:100%; padding-bottom: 10px;">
			<?php if(ChckSESS_superadm()){ ?>
				<button id="_INRG_EcCmz_SbCnt" class="_anm _fll" style="padding-right:10px; background-image:url(<?php echo DMN_IMG_ESTR_SVG ?>ec_tp_cmz.svg);" class="_tel"><span alt="Mis Pushmail">Básicas (Solo Texto)</span></button>
				<button id="_INRG_Ec_SbCnt" class="_anm _fll" style="padding-right:10px; background-image:url(<?php echo DMN_IMG_ESTR_SVG ?>ec_tp_all.svg);" class="_mail"><span alt="Código">Plantillas (Diseñadas)</span></button> 
			<?php } ?>
			<button id="_INRG_Eml_SbCnt" class="_anm" style="padding-right:10px; background-image:url(<?php echo DMN_IMG_ESTR_SVG ?>ec_new_mail.svg);" class="_visit"><span alt="Email">Redactar</span></button>	 
		</div>
		
	<?php 
			
		$CntWb .= '
			
			$("#_INRG_Ec_SbCnt").off("click").click(function(e) { 
				
				e.preventDefault();
			
				if(e.target != this){
					e.stopPropagation(); return;
				}else{
					_ldCnt({ 
						u:\''.FL_DT_GN.__t('my_eml_cnv', true).'&mdlcnt='.$__dt_mdlcnt->enc.'&tra='.$_dt_tra->enc.'&_m=ec'.TXGN_POP.$___Ls->ls->vrall.'&_t4='.$___Ls->gt->tsb_d.'\',
						pop:\'ok\',
						cls:\'_fll _thdr\',
						pnl:{
							e:\'ok\',
							s:\'l\',
							tp:\'h\'
						}
					});
				} 

			});
			
			
			$("#_INRG_EcCmz_SbCnt").off("click").click(function(e) { 
				
				e.preventDefault();
			
				if(e.target != this){
					e.stopPropagation(); return;
				}else{
					_ldCnt({
						u:\''.FL_DT_GN.__t('my_eml_cnv', true).'&mdlcnt='.$__dt_mdlcnt->enc.'&tra='.$_dt_tra->enc.'&_m=ec_cmz'.TXGN_POP.$___Ls->ls->vrall.'&_t4='.$___Ls->gt->tsb_d.'\',
						pop:\'ok\',
						cls:\'_fll _thdr\',
						pnl:{
							e:\'ok\',
							s:\'l\',
							tp:\'h\'
						}
					}); 
				}
					
			});
			
			$("#_INRG_Eml_SbCnt").off("click").click(function(e) { 
				
				e.preventDefault();
			
				if(e.target != this){
					e.stopPropagation(); return;
				}else{
					_ldCnt({ 
						u:\''.FL_DT_GN.__t('my_eml_cnv', true).'&mdlcnt='.$__dt_mdlcnt->enc.'&tra='.$_dt_tra->enc.'&_m=eml'.TXGN_POP.$___Ls->ls->vrall.'&_t4='.$___Ls->gt->tsb_d.'\',
						pop:\'ok\',
						cls:\'_fll _thdr\',
						pnl:{
							e:\'ok\',
							s:\'l\',
							tp:\'h\'
						}
					}); 
				}	
				
			});
		'; 

	?>
	</div>
	<?php 
		}else{
			$___Ls->_bld_l_hdr(); 
		} 
	?>
		<?php if(($___Ls->qry->tot > 0)){ ?>
			<table width="100%" border="0" cellpadding="0" cellspacing="0" class="Ls_Rg LsRgNw">
				<thead>
					<tr>
						<th width="1%" <?php echo NWRP ?>></th>
						<th width="98%" <?php echo NWRP ?>><?php echo 'Asunto' ?></th>
						<th width="1%" <?php echo NWRP ?>></th>
					</tr>
				</thead>
				<tbody>
					<?php do { ?>
						<?php $_GtMainCnvDt = GtMainCnvDt([ 'tp'=>'eml', 'maincnv_id'=>$___Ls->ls->rw['maincnv_id'], 'd'=>['chnl'=>'ok'] ]); ?>
						<td width="1%" align="left" nowrap="nowrap" >
							<?php echo /*$___Ls->ls->rw['maincnv_id'].*/Spn(!isN($_GtMainCnvDt->chnl->tot->msg)?$_GtMainCnvDt->chnl->tot->msg:0,'','_nmb'); ?>
						</td>
						<td width="98%" align="left" nowrap="nowrap" style="padding-top:15px; padding-bottom:15px;">
							<?php 
								if(!isN($___Ls->ls->rw['maincnv_lmsj'])){
									echo ctjTx($___Ls->ls->rw['maincnv_lmsj'],'in');
								}else{	
									if(!isN($_GtMainCnvDt->chnl->snpt)){
										echo $_GtMainCnvDt->chnl->snpt;
									}else{
										echo 'Procesando...';
									}
								}	
								
								if(ChckSESS_superadm()){ echo HTML_BR.'Id:'.$___Ls->ls->rw['id_maincnv']; }
							?>
						</td>
						<td width="1%" align="left" nowrap="nowrap" class="_btn">
							<?php if($_GtMainCnvDt->chnl->tot->msg > 0){ echo HTML_Ls_Btn([ 't'=>'onl', 'rel'=>$___Ls->ls->rw['maincnv_enc'], 'cls'=>'shw_eml_cnv', 'l'=>Void() ]); }  ?>	
						</td>
					</tr>
					<?php } while ($___Ls->ls->rw = $___Ls->sql->fetch_assoc()); ?>
					<?php $CntWb .= " $('#".TBGRP."_ec ._n').html(' (".$___Ls->qry->tot.")'); "; ?>
				</tbody>
			</table>
			<?php $___Ls->_bld_l_pgs(); ?>
			<?php 

					$CntWb .= "
							
						$('.shw_eml_cnv').click(function(){

							var _enc = $(this).attr('rel');
							
							_ldCnt({
								u:'".FL_DT_GN.__t('my_eml_cnv', true)."&cnv_id='+_enc+'&mdlcnt=".$__dt_mdlcnt->enc."&tra=".$_dt_tra->enc."',
								c:'',
								pop:'ok',
								cls:'_fll _thdr',
								pnl:{
									e:'ok',
									s:'l',
									tp:'h'
								}
							});

						});
						
					";
			?>

			<?php } ?>
		<?php $___Ls->_h_ls_nr(); ?>
	<?php } ?>
<?php } ?>