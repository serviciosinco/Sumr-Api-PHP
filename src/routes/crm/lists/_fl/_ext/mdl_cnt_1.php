<?php if($__Mdl_R_Chk->e == 'ok'){ ?> 
	
	<div class="adv_mdlr_div">
		<?php foreach($__Mdl_R_Chk->ls as $_k=>$v){ ?>
			<?php if($v->date->est == 'on'){ ?>
				<?php if($v->cnt > 0){ ?>
					<div class="adv_chi _ok" rel="<?php echo $v->mdl_enc; ?>">
						<?php echo TX_CFRASTC." "; ?><?php echo Strn($v->tx) ?>
						<input type="button" rel="<?php echo $v->mdl_enc; ?>" id="MdlR_Dt<?php echo $___Ls->id_rnd; ?>" class="MdlR_Dt">
					</div>
				<?php }else{ ?>
					<?php if(!isN($v->date->f)){ ?>
						<div class="adv_chi">
							<?php echo $v->tt." " ?><?php echo Strn(FechaESP_OLD($v->date->f)).' a las '.Strn($v->date->h). ( ($v->act_lgrtx != NULL) ? $v->act_lgrtx : '' ) ?> 
							<input type="button" value="<?php echo TX_CNFR ?>" rel="<?php echo $v->mdl_enc; ?>" id="MdlR_Cnfr" name="MdlR_Cnfr">
							<input type="button" rel="<?php echo $v->mdl_enc; ?>" id="MdlR_Dt<?php echo $___Ls->id_rnd; ?>" class="MdlR_Dt">
						</div> 
					<?php } ?>
				<?php } ?>
				<?php //if(SISUS_ID == 163){ print_r($__Mdl_R_Chk->ls); echo SIS_F; } ?>
			<?php } ?>
		<?php } ?>
	</div>
	
	<?php   

		$CntJV .= "
    			
			function __MdlCntAct(){
				var __act = '".$___Ls->dt->rw['id_mdl']."';
				var __cnt = '".$___Ls->dt->rw['mdlcnt_cnt']."';	
				var __u = '".Fl_Rnd(FL_FM_GN.__t('act_mdl',true))."'+'&_act='+ __act + '&_cnt=' + __cnt;
				_ldCnt({ u:__u , c:'__cnt_dt', pop:'ok', w:'500', h:'340', trs:false });
			}
			
			function __UpdMdlCnt(){
				".PgRg($__ls, __t($__bdtp).ADM_LNK_DT.$___Ls->dt->rw[$___Ls->ino].PgRgFl($__lsgt_flt_cmp.$__lsgt_flt_cmp_nd, 'get').$_adsch.$___Ls->ls->vrall)."
			}

        ";
        
        $CntWb .= " 
        
        	_Dom_Rbld();
        
			function _Dom_Rbld(){
				
		        $('#MdlR_Dt".$___Ls->id_rnd."').off('click').click( function(){
			       
			    	var _enc = $(this).attr('rel');
			       
			       	_ldCnt({
				        u:'".FL_DT_GN.__t('mdl', true)."&_i='+_enc+'".TXGN_ING.Fl_i($___Ls->gt->i).'&_m=130&__rnd=bcf'.TXGN_POP.$___Ls->ls->vrall."',
						c:'',
						pop:'ok',
						pnl:{
							e:'ok',
							s:'l',
							tp:'h'
						}
					});
			       
		        });
	        
				$('#MdlR_Cnfr').off('click').click(function(){
					 
			        var _mdl = $(this).attr('rel');
			        
			        swal({
						  title: 'Estas seguro(a)?',
						  text: 'Desea confirmar la asistencia',
						  type: 'info',
						  showCancelButton: true,
						  confirmButtonColor: '#589833',
						  confirmButtonText: 'Aceptar',
						  cancelButtonText: 'Cancelar',
						  closeOnConfirm: true
					},
					function(){
						
						$.ajax({
							type:'POST',
							url: '".Fl_Rnd(PRC_GN.__t('mdl_cnt',true))."',
							data: {'mdlcnt_mdl':_mdl, 'mdlcnt_cnt':'".$___Ls->dt->rw['cnt_enc']."', t2:'act', 'MM_insert':'EdMdlCnt'},
							beforeSend: function() {
								
							},
							success:function(r){	
								if(r.e == 'ok'){
									$('.adv_chi').addClass('_ok').html('".TX_CFRASTC." ".Strn("'+r.tx+' - '+r.f+' '+r.h+'")." <input type=\"button\" rel=\"'+_mdl+'\" id=\"MdlR_Dt".$___Ls->id_rnd."\" class=\"MdlR_Dt\"> ');
									_Dom_Rbld();
								}
							},
							complete:function(e){
								
							}
						});	
						
					});
			        
		        });
	        }
	        
	    "; 
	?>
        
<?php } ?>
 
 
 <?php if($___Ls->dt->rw['mdlcnt_lat'] != '' && $___Ls->dt->rw['mdlcnt_lon'] != ''){  ?>  
	<div class="mapbck" id="mapback" style="height:200px;">
		<div id="mapdt" class="mapbx" style="height:200px;"></div>
												
			<?php   $CntWb .= "
							function __MdlCntMap(){
								SUMR_Main.ld.f.maps(function(){
										__Map({i:'mapdt', prfx:'mdlcnt', shw:'true', i_w:'mapback', bg_h:600 });
								});
							}
							
							__MdlCntMap();
					";
			?>
	</div>
	<?php echo HTML_inp_hd('mdlcnt_lat', $___Ls->dt->rw['mdlcnt_lat']); ?> 
	<?php echo HTML_inp_hd('mdlcnt_lng', $___Ls->dt->rw['mdlcnt_lon']); ?> 
	<?php echo HTML_inp_hd('mdlcnt_zom', 17); ?>    
<?php } ?>
    
    
<div id="<?php echo $___Ls->fm->fld->id ?>" class="<?php echo DV_GNR_FM_CMP ?>">
 		
	<?php echo HTML_inp_hd('___t', $__prfx->prfx2_c); ?>
	<?php //echo HTML_inp_hd('mdlcnt_enc', $___Ls->dt->rw['mdlcnt_enc']); ?> 		

	<?php if($___Ls->dt->tot == 0){ 

		if($___Ls->mdlstp->clg == 1  || $___Ls->mdlstp->uni == 1|| $___Ls->mdlstp->emp == 1){ 
			$__rsz_h = 540;
		}else{ 
			$__rsz_h = 420;
		}
		
	?>
		<div class="__sch_json <?php if(!isN($_cnt_key_sch)){ ?>__ld<?php } ?>" id="__sch_json">
			<?php 
				if(!isN($_cnt_key_sch)){
					$CntWb .= "		 
						setTimeout(function(){ 
							SUMR_Main.mdlcnt.f.setcntk('".$_cnt_key_sch."');
							SUMR_Main.mdlcnt.f.sch_cnt(); 
						}, 800);
					";
				}

				if(!isN($_cnt_key_md)){
					$CntWb .= "
						$('#mdlcnt_m').val(".$_cnt_key_md.").trigger('change');
					";
				}

				if($__scrpt->tot > 0){
					$OptInCnt = '<button class="call_plcy_btn _anm" id="Call_Plcy_'.$___Ls->id_rnd.'"></button>';
				}
				if($__dt_cl->tag->chk->docscan->v == 'ok'){
					$OptInCnt .= '<button class="call_docscan_btn _anm" id="Call_DocScan_'.$___Ls->id_rnd.'"></button>';
				}
			
			?>
			<div class="_c1"><?php echo HTML_inp_tx($___Ls->fm->id.'_nm_sch', TX_DCID.' / '.TT_FM_EML.' / '.TX_CEL, '', FMRQD, !isN($_cnt_key_sch)?$_cnt_key_sch:'' ); ?></div>
			<div class="_c2"><input id="__sch_json_btn" name="__sch_json_btn" type="button" class="_anm" title="<?php echo TX_SCH ?>" /></div>
			<div class="_c3"><?php echo $OptInCnt; ?></div>
			<div class="_c4 <?php if(isN($OptInCnt)){ echo '_sngl'; } ?>" id="tpteldoc_slct_<?php echo $___Ls->fm->id; ?>">
				<div class="ps _anm">
					<?php   	
						echo LsSis_PsOLD('cnttel_ps','id_sisps', '57', '-', 2, '', '', 'iso'); 	
						$CntWb .= JQ_Ls('cnttel_ps', TX_SLCPS, '', 'psFlg');     
					?>
				</div>
				<div class="dc _anm">
					<?php 
						$l = __Ls([ 'k'=>'cnt_dc', 
									'opt_v'=>'itm-sg', 
									'id'=>'cntdc_tp_p', 
									'va'=>_CId('ID_CNTDC_CC'), 
									'ph'=>FM_LS_TPDOC, 
									'slc'=>[ 
										'opt'=>[
												'attr'=>[
													'itm-sg'=>'sg'
												]	
											] 
										]   
								]); 
						echo $l->html; $CntWb .= $l->js;  
					?>
				</div>
			</div>
		</div>
		<?php include(DIR_EXT.'mdl_cnt_sac.php'); ?>

	<?php } ?> 
		
		<div class="lnbsc_1" id="__fm_col" <?php if($___Ls->dt->tot == 0){ ?>style="display:none;"<?php } ?>> 
				
			<?php if($___Ls->dt->tot > 0){ ?>
				<div id="_hdr_<?php echo $__Rnd; ?>">
					<?php 
						
						$__mdl_dt = GtMdlDt([ 'id'=>$___Ls->dt->rw['mdlcnt_mdl'], 'tot'=>[ 'sch'=>'ok' ] ]);
						
						if($___Ls->dt->tot > 0){ 
							
							$__mdl_chng = '<div class="mdl_slct" id="mdl_slct_'.$___Ls->fm->id.'">'.LsMdl('mdlcnt_mdl', 'mdl_enc', $___Ls->dt->rw['mdl_enc'], '', 1, '', [ 'tp'=>$___Ls->mdlstp->id, 'flt_are'=>'ok' ]).'</div>';                           
							$CntWb .= JQ_Ls('mdlcnt_mdl', TX_SLCNMDL); 
						
						} 
						
						if( !_DtV() ){ 
							echo h2(Spn($__mdl_dt->tp_nm.' '.ctjTx($___Ls->dt->rw['mdl_nm'],'in'),'','','','mdl_tt_'.$___Ls->fm->id).$__chng_pro.$__mdl_chng); 
						} 
						
					?> 
				</div> 
				
				<?php if( mBln($___Ls->mdlstp->ctg->main->attr->tml_buy->vl) == 'ok'){ include(GL_MDL_WDGTS.'mdl_cnt_fnl_shop.php'); } ?>
			
			<?php } ?>
			
			<?php
				
				if(!isN($_GtMainCnvDt->tp) && $_GtMainCnvDt->tp == 'whtsp'){
					$_whtsp_msgs = GtWhtspCnvMsgLs([ 'cnv'=>$_GtMainCnvDt->chnl->id ]);
					$__rsz_w = '70%';
				}else{
					$__rsz_w = '';
				}

			?>

			<div class="dtl <?php //_scrl ?> <?php if($_whtsp_msgs->tot > 0){ echo 'maincnv_on'; } ?>">
				
				<div class="_c _c1">
					
					<?php /*<div class="ln ln_x2">
							<div class="col_1">
								<?php echo h2('Fecha inicio de actividad'); ?>
								<?php echo SlDt([ 'id'=>'mdlcnt_fiact', 'va'=>$___Ls->dt->rw['mdlcnt_fiact'], 'rq'=>'no', 't'=>'dt', 'ph'=>'Fecha inicio de actividad', 'lmt'=>'no', 'cls'=>CLS_CLND ]);   ?> 	
							</div>
							<div class="col_2">
								<?php echo h2('Fecha final de actividad'); ?>
								<?php echo SlDt([ 'id'=>'mdlcnt_feact', 'va'=>$___Ls->dt->rw['mdlcnt_feact'], 'rq'=>'no', 't'=>'dt', 'ph'=>'Fecha final de actividad', 'lmt'=>'no', 'cls'=>CLS_CLND ]); ?> 	
							</div>
					</div> */ ?>
					
					<div class="_csub _c1 ">

						<div class="mdlcnt_main _anm" id="mdlcnt_main_<?php echo $___Ls->id_rnd; ?>">
							
							<div class="mdlcnt_prd _anm">
								<div class="mdl_cnt_prd dsh_cnt">
									<ul id="bx_prd_<?php echo $___Ls->id_rnd; ?>" class="_ls _anm dls"></ul>
									<div class="_new_fm" id="bx_fm_prd_<?php echo $___Ls->id_rnd; ?>"></div>
								</div> 	
							</div>

							<div class="mdlcnt_sch _anm">
								<div class="mdl_cnt_sch dsh_cnt">
									<ul id="bx_sch_<?php echo $___Ls->id_rnd; ?>" class="_ls _anm dls"></ul>
									<div class="_new_fm" id="bx_fm_sch_<?php echo $___Ls->id_rnd; ?>"></div>
								</div> 	
							</div>

							<div class="mdlcnt_h_cntc _anm">
								<div class="mdl_cnt_h_cntc dsh_cnt">
									<ul id="bx_h_cntc_<?php echo $___Ls->id_rnd; ?>" class="_ls _anm dls"></ul>
									<div class="_new_fm" id="bx_fm_h_cntc_<?php echo $___Ls->id_rnd; ?>"></div>
								</div> 
							</div>

							<div class="mdlcnt_bsc _anm">	
								<?php include(DIR_EXT.'mdl_cnt_2.php'); ?> 
							</div>
							
						</div>

						<input id="mdlcnt_cnt" name="mdlcnt_cnt" type="hidden" value="<?php  echo $__dt_cnt->id ?>" />

						<?php if(!isN($___Ls->gt->main_cnv->id)){ ?>
							<input id="maincnv_t" name="maincnv_t" type="hidden" value="<?php  echo $___Ls->gt->main_cnv->t ?>" />
							<input id="maincnv_enc" name="maincnv_enc" type="hidden" value="<?php  echo $___Ls->gt->main_cnv->id ?>" />
						<?php } ?>

						<?php if( mBln($___Ls->mdlstp->ctg->main->attr->buy_link->vl) == 'ok' && $___Ls->dt->tot > 0){ include(GL_MDL_WDGTS.'mdl_cnt_pay_lnk.php'); } ?>

						<div class="_chk_all">
							
							<?php 

								$Ls_Chk = __LsDt(['k'=>'sis_chk','cl'=>DB_CL_ID]);

								if($Ls_Chk->tot > 0){
								
									echo h2(Spn('','','_tt_icn _tt_icn_chck' ).MDL_CHCK);
									
									foreach($Ls_Chk->ls->sis_chk as $chk_k => $chk_v){	
										$__ls_val = GtLsChckDt(['id'=>$___Ls->gt->i,'id_chk'=>$chk_v->id]);								
										echo OLD_HTML_chck($chk_v->cns, $chk_v->tt, $__ls_val->est, 'in',['c'=>'chck', 'attr'=>['rel'=>$chk_v->id]]); 
									}						
								
									$CntJV .= "SUMR_Main.mdlcnt.f.chck_all();";
								
								}
							
							?>
							
						</div>
						
						
						<?php if($___Ls->dt->tot > 0){ ?>
							<?php 
								
								if( mBln($___Ls->mdlstp->ctg->main->attr->itms->vl) == 'ok' ||
									mBln($___Ls->mdlstp->ctg->main->attr->tml_sort->vl) == 'ok'){ 	
									include(GL_MDL_WDGTS.'mdl_cnt_score.php'); 	
								} 
							?>
						<?php } ?>

						<?php 
							
							//$__Cl = new CRM_Cl();
							
							$CntJV .= "
								
								SUMR_Main.bxajx._mdlcntprd = {};
								SUMR_Main.bxajx._mdlcntsch = {};
								SUMR_Main.bxajx._mdlcnthcntc = {};
								
								SUMR_Main.bxajx.__mdlcnt_main = $('#mdlcnt_main_".$___Ls->id_rnd."');
								SUMR_Main.bxajx.__mdlcnt_bx_prd_now = $('#mdl_cnt_prd_".$___Ls->id_rnd."');
								SUMR_Main.bxajx.__mdlcnt_bx_prd_opt = $('#bx_prd_".$___Ls->id_rnd."');
								SUMR_Main.bxajx.__mdlcnt_bx_sch_now = $('#mdl_cnt_sch_".$___Ls->id_rnd."');
								SUMR_Main.bxajx.__mdlcnt_bx_sch_opt = $('#bx_sch_".$___Ls->id_rnd."');
								SUMR_Main.bxajx.__mdlcnt_bx_h_cntc_now = $('#mdl_cnt_h_cntc_".$___Ls->id_rnd."');
								SUMR_Main.bxajx.__mdlcnt_bx_h_cntc_opt = $('#bx_h_cntc_".$___Ls->id_rnd."');
								
							";
														
						?>
					
					</div>
					
					<div class="_csub _c2">
						
						<div class="cnt_frst" style="display:none;">
							
							<div class="fld dc">
								<div class="c1">
									<?php 
										$l = __Ls([ 'k'=>'cnt_dc', 
													'opt_v'=>'itm-sg', 
													'id'=>'cntdc_tp', 
													'va'=>$___Ls->dt->rw['cnt_dctp'], 
													'ph'=>FM_LS_TPDOC,
													'slc'=>[ 
														'opt'=>[
																'attr'=>[
																	'itm-sg'=>'sg'
																]	
															] 
														],
													'rq'=>2
												]); 
												
										echo $l->html; $CntWb .= $l->js;    
									?>	 
								</div>
								
								<div class="c2">
									<?php echo HTML_inp_tx('cnt_dc', TT_FM_ID, ctjTx($___Ls->dt->rw['cnt_dc'],'in'), ''); ?>
								</div>
							</div>
							<div class="fld nm">
								<div class="c1">
									<?php echo HTML_inp_tx('cnt_nm', TT_FM_NM, !isN($_cnt_key_nm_fx)?$_cnt_key_nm_fx:ctjTx($___Ls->dt->rw['cnt_nm'],'in'), FMRQD); ?> 
								</div>
								<div class="c2">
									<?php echo HTML_inp_tx('cnt_ap', TT_FM_AP, !isN($_cnt_key_ap_fx)?$_cnt_key_ap_fx:ctjTx($___Ls->dt->rw['cnt_ap'],'in'), FMRQD); ?>
								</div>
							</div>
							
							<?php if( mBln($___Ls->mdlstp->ctg->main->attr->in_cnt_cd->vl) == 'ok' ){ ?>
							<div class="fld cd">
								<div class="c1">
									<?php 
										
											$l = __Ls(['k'=>'tprlcc',
													'id'=>'cnt_cd_rel',
													'ph'=>TX_TPR,
													'cls'=>'cntcd_rel'.$___Ls->gt->tsb,
													'va'=>_CId('ID_TPRLCC_VVE'),
													'slc'=>[ 
														'opt'=>[
																'attr'=>[
																	'itm-key'=>'key'
																]	
															] 
														]
											]);
															
										echo $l->html;
										$CntWb .= $l->js;
										
									?> 
								</div>
								<div class="c2">
									<?php 
										echo LsCdOld([ 'id'=>'cnt_cd_id', 'v'=>'id_siscd', 'va'=>'', 'rq'=>2, 'mlt'=>'no' ]);
										$CntWb .= JQ_Ls('cnt_cd_id',FM_LS_SLCD); 
									?>
								</div>
							</div>
							<?php } ?>


							<?php echo HTML_inp_tx('cnt_eml', TT_FM_EML,'', ''); ?> 
							
							<div class="_intel">
								
								<?php echo __SbT([ 't'=>TX_TLFN, 'i'=>'cnt_tel' ]); ?>
								<?php echo LsSis_Tel('cnt_tel_tp','id_sistel', '', FM_LS_SLTEL, 2); $CntWb .= JQ_Ls('cnt_tel_tp', FM_LS_SLTEL); ?>
								<?php $CntWb .= " SUMR_Main.mdlcnt.f.cnttel_tp();"; ?>
									
								<div class="fld tel">
									<div class="c1">	
										<?php 
											echo LsSis_PsOLD('cnt_tel_ps','id_sisps', !isN($_cnt_dfl_ps)?$_cnt_dfl_ps:'', '-', 2, '', '', 'iso'); 
											$CntWb .= JQ_Ls('cnt_tel_ps', '-', '', 'psFlg', ['ac'=>'no']); 	
										?>	
									</div>
									<div class="c2">
										<div class="tel"><?php echo HTML_inp_tx('cnt_tel', TX_NMR, '', ''); ?></div>
										<div class="ext"><?php echo HTML_inp_tx('cnt_tel_ext', TX_EXT, '', FMRQD_NMR, ' style="display:none;" '); ?></div>
									</div>
								</div>
							
							</div>

							<?php if(!isN($__t2) && $__t2 == 'sac' ){ ?>
								<div class="c_mdlcnt_tracmnt"></div>
							<?php } ?>

							<?php 
								if($___Ls->dt->tot == 0 && $___Ls->mdlstp->tp == 'prg'){
									
									if($___Ls->mdlstp->clg == 1){ ?>
									
										<div class="_fm_spc __cnt_fnt">
											<?php echo '<div class="tt_slc">'.'Colegio'.'</div>' ?>
											<div class="_d<?php echo $i+1; ?>"> 
												<?php echo LsOrgSds(['cl'=>'ok','id'=>'orgsdscnt_clg', 'v'=>'orgsds_enc', 'va'=>$___Ls->dt->rw['orgsdstel_orgsds'], 'rq'=>2, 'org_tp_k'=>'clg' ]); $CntWb .= JQ_Ls('orgsdscnt_clg'); ?> 
											</div>
										</div>
										
										<div class="_fm_spc __cnt_fnt grados_slc">
											<?php echo '<div class="tt_slc">'.'Curso'.'</div>' ?>
											<div class="_d<?php echo $i+1; ?>"> 
												
												<?php echo Ls_GrdClg('orgsdscnt_crs', 'clgkey', $___Ls->dt->rw['orgsdscnt_crs'],'Curso','2'); $CntWb .= JQ_Ls('orgsdscnt_crs','');  ?>
											</div>
										</div>
										<?php $CntJV .= "$('#orgsdscnt_clg').change(function(){ $('.grados_slc').addClass('act'); });"; ?>
										<style>
											.grados_slc{ display: none !important }
											.grados_slc.act{ display: flex !important  }
											.grados_slc ._d3{ width: 42%; }
										</style>
									<?php }
										
									if($___Ls->mdlstp->emp == 1){  
										?>
									
										<div class="_fm_spc __cnt_fnt">
											<?php echo '<div class="tt_slc">'.'Empresa'.'</div>' ?>
											<div class="_d<?php echo $i+1; ?>"> 
												<?php echo LsOrgSds(['cl'=>'ok','id'=>'orgsdscnt_emp', 'v'=>'orgsds_enc', 'va'=>$___Ls->dt->rw['orgsdstel_orgsds'], 'rq'=>2, 'org_tp_k'=>'emp' ]); $CntWb .= JQ_Ls('orgsdscnt_emp'); ?> 
											</div>
										</div>
										
									<?php	
									}
									if($___Ls->mdlstp->uni == 1){  
										?>
									
											<div class="_fm_spc __cnt_fnt">
												<?php echo '<div class="tt_slc">'.'Universidad'.'</div>' ?>
												<div class="_d<?php echo $i+1; ?>"> 
													<?php echo LsOrgSds([ 'cl'=>'ok','id'=>'orgsdscnt_uni', 'v'=>'orgsds_enc', 'va'=>$___Ls->dt->rw['orgsdstel_orgsds'], 'rq'=>2, 'org_tp_k'=>'uni' ]); $CntWb .= JQ_Ls('orgsdscnt_uni'); ?> 
												</div>
											</div>
											
										<?php		
									}
								} 
							?>                        
						</div>
					</div>
				</div>
				
				<div class="_c _c2">
						
					<?php if( mBln($___Ls->mdlstp->ctg->main->attr->fnl->vl) == 'ok'){ include(GL_MDL_WDGTS.'mdl_cnt_fnl.php'); } ?>
					
					<?php if( mBln($___Ls->mdlstp->ctg->main->attr->itms->vl) == 'ok'){ include(GL_MDL_WDGTS.'mdl_cnt_items.php'); } ?>
					
					<?php if( mBln($___Ls->mdlstp->ctg->main->attr->sort_invce->vl) == 'ok'){ include(GL_MDL_WDGTS.'mdl_cnt_sort_invce.php'); } ?>
					
					
					
					<?php if( mBln($___Ls->mdlstp->ctg->main->attr->cmnt->vl) == 'ok'){ ?>
					<?php echo h2( Spn('','','_tt_icn _tt_icn_msj'). (mBln($___Ls->mdlstp->ctg->main->attr->itms->vl)=='ok' ? 'Observaciones':TT_FM_CMN ), '__cmnt'); ?>
					<div id="Lead_Msj_Bx">
						<div class="_empty"><?php echo SCL_MSG_NOLS; ?></div>
					</div>
					<?php } ?>
					
					<?php if( mBln($___Ls->mdlstp->ctg->main->attr->fnl->vl) == 'ok'){ ?>
						<?php echo h2( Spn('','','_tt_icn _tt_icn_fnl').TX_HSTR, '__cmnt'); ?>
						<div id="Lead_Est_Bx" class="cnt_est">
							<div class="_empty"><?php echo TX_NHACTRGS; ?></div>
						</div> 
					<?php } ?>
					<?php if(!isN($__t2) && $__t2 == 'sac' && !isN($___Ls->gt->i) ){

						$_aws = new API_CRM_Aws();
						$_attch = GtMdlCntAttchDt([ 't'=>'mdl_cnt', 'i'=>$___Ls->dt->rw['id_mdlcnt'] ]);

						if($_attch->tot > 0){
							
					?> 
							<div id="fld_tra" class="owl-carousel owl-theme"><?php
								foreach($_attch->ls as $_k_a => $_v_a){
									$_pth = $_aws->_s3_get([ 'b'=>'prvt', 'fle'=>DIR_PRVT_ATTCH.$_v_a->fle ]);
									echo '<div class="item flds">
												<a target="_blank" href="'.$_pth->uri.'">'.$_v_a->nm.'</a>
											</div>';
								}
							?></div><?php 

							$CntWb .= '
								$("#fld_tra").owlCarousel({
									loop:false,
									margin:10,
									nav:true,
									items:1
								});
							';
						}

						$__dtmdlcnttra = GtMdlCntTraDt([ 'tp'=>'mdl_cnt', 'id'=>$___Ls->dt->rw['id_mdlcnt'], 'shw'=>[ 'tra'=>'ok', 'obs'=>'ok', 'cmnt'=>'ok' ] ]);

						foreach($__dtmdlcnttra->ls as $k => $v){
							?>
								<div class="dlt_tra">
									<span class="brnd" style=" background-image:url(<?php echo $v->tra->store->brnd->img ?>)">  </span>
									<ul class="lst">
										<?php 

										if(!isN($v->tra->tt)){ ?> <li class="itm"><h2 class="tt">Titulo:</h2><span class="tx"><?php echo $v->tra->tt; ?></span></li> <?php }
										if(!isN($v->tra->dsc)){ ?> <li class="itm"><h2 class="tt">Descripcion:</h2><span class="tx"><?php echo $v->tra->dsc; ?></span></li> <?php }
										if(!isN($v->tra->rsp->nm)){ ?> <li class="itm"><h2 class="tt">Responsable:</h2><span class="tx"><?php echo $v->tra->rsp->nm.' '.$v->tra->rsp->ap; ?></span></li> <?php }
										if($v->tra->obs->tot > 0){ ?>
											<li class="itm obs">
												<h2 class="tt">Observadores:</h2>
												<ul>
													<?php
														foreach($v->tra->obs->ls as $_k => $_v){
															echo '<li class="_anm us-itm" id="obs_us_f796eb5e6a029bc3b52431e8e5cab5036ec1f1ec" title="'.$_v->nm.'" style="background-image:url('.$_v->img->th_50.')"><div class="flg _anm"><div class="wrp">'.$_v->nm.'</div></div></li>';
														}
													?>
												</ul>
											</li>
										<?php } ?>

										<?php if($v->tra->cmnt->tot > 0){ ?>
											<li class="itm cmnt">
												<h2 class="tt">Comentarios:</h2>
												<ul>
													<?php
														foreach($v->tra->cmnt->ls as $__k => $__v){
															echo '<li><span class="tx">'.$__v->tt.'</span></li>';	
														}
													?>
												</ul>
											</li>
										<?php } ?>
									</ul>
								</div>
							<?php
						}
					?>	
						<style>

							.item.flds{padding: 5px;}
							.item.flds a{height: 85px;display: block;margin: 0 auto;border: 1px dotted #cccccc;background-image: url(<?php echo DMN_IMG_ESTR_SVG.'file.svg'; ?>);background-position: center top 5px;background-size: 50px auto;background-repeat: no-repeat;color: #565656;padding: 60px 10px 0px;text-decoration: none;white-space: nowrap;overflow: hidden;text-overflow: ellipsis;}
							.lst_fld{ list-style-type: none;padding: 0; }
							.lst_fld li{ padding: 10px 0;border-bottom: 1px dotted #ccc;position:relative;cursor:pointer; }
							.lst_fld li a{color: #ccc;text-decoration: none;white-space: nowrap;overflow: hidden;text-overflow: ellipsis;width: 90%;display: block; }
							.lst_fld li:hover{background-color: #cecece;border-radius: 12px;padding: 10px; }
							.lst_fld li:hover a{ color: black }

							.dlt_tra{width:100%;border:2px dashed #ccc;margin:10px 0;border-radius:12px;position: relative;}
							.dlt_tra .brnd{width:40px;height:40px;display:block;border-radius:50%;background-position:center center;background-repeat:no-repeat;background-size:100% auto;position:absolute;right:-10px;top:-10px}
							.dlt_tra .lst{padding:0;list-style-type:none}	
							.dlt_tra .lst .itm{font-size:14px;text-align:left;padding:5px 10px;margin:0 5px;border-bottom:1px dotted #c2b9b9}
							.dlt_tra .lst .itm .tt{border:0!important;display:inline;padding:0 4px!important;color:#ccc!important;width:115px;display:inline-block;text-transform:capitalize!important;text-align:center;vertical-align:top !important}
							.dlt_tra .lst .itm .tx{width:190px;display:inline-block;font-family:Economica;font-size:14px;text-align:center!important;vertical-align:sub}
							.dlt_tra .lst .itm ul{padding:0 0 0 40px;display:inline-block}

							.dlt_tra .lst .itm.obs ul li{border:0!important;margin:0 6px 10px 0;width:25px;height:25px;border-radius:200px;-moz-border-radius:200px;-webkit-border-radius:200px;background-color:#ecf1f2;cursor:pointer;display:inline-block;vertical-align:top;padding:0;background-repeat:no-repeat;background-position:center center;background-size:auto 100%;position:relative}
							.dlt_tra .lst .itm.obs ul li .flg{position:absolute;width:70px;top:-40px;opacity:0;left:-26px;pointer-events:none}
							.dlt_tra .lst .itm.obs ul li .flg .wrp{background-color:var(--tra_dt_clr);color:#fff;padding:3px 2px;white-space:nowrap;text-align:center;text-overflow:ellipsis;width:70px;border-radius:8px;-moz-border-radius:8px;-webkit-border-radius:8px;font-size:9px;position:relative;overflow:hidden;display:block;-webkit-line-clamp:2;-webkit-box-orient:vertical;text-overflow:ellipsis;white-space:nowrap}
							.dlt_tra .lst .itm.obs ul li:hover{border:2px solid var(--tra_dt_clr)}
							.dlt_tra .lst .itm.obs ul li:hover .flg{top:-24px;opacity:1;z-index:999}

							.dlt_tra .lst .itm.cmnt ul{padding:0;list-style-type:none}

						</style>
					<?php } ?>
					<?php echo h2( Spn('','','_tt_icn _tt_icn_crss')._Cns('TX_MREOTH_'.strtoupper($___Ls->gt->tsb)), '__cmnt'); ?>
					<div id="Lead_Oth_Bx" class="cnt_oth">
						<div class="_empty"><?php echo TX_NHTHRINTRS; ?></div>
					</div>
				</div>
				
				<div class="_c _c3">
					<ul class="msgs">
						<?php 
							if(!isN($_whtsp_msgs->ls)){
								foreach($_whtsp_msgs->ls as $_whtsp_msgs_k=>$_whtsp_msgs_v){
									if(!isN($_whtsp_msgs_v->msg)){
										$_txv = isBscData($_whtsp_msgs_v->msg);
										if($_txv->e == 'ok'){ echo li( $_txv->v ); }
									}
								}
							}
						?>
					</ul>
				</div>

			</div>
	</div>
</div>
<?php

	$CntWb .= "	
		SUMR_Main.mdlcnt.id = '".$___Ls->gt->i."';
		SUMR_Main.mdlcnt.mdlstp = '".$___Ls->mdlstp->tp."';
		SUMR_Main.mdlcnt.mdl = '".$___Ls->dt->rw['mdlcnt_mdl']."';
		SUMR_Main.mdlcnt.pop = '".$___Ls->pop()."';
		SUMR_Main.mdlcnt.rnd = '".$___Ls->id_rnd."';
		SUMR_Main.mdlcnt.fm.id = '".$___Ls->fm->id."';
		SUMR_Main.mdlcnt.fm.rsze.h = '".$__rsz_h."'; 
		SUMR_Main.mdlcnt.fm.rsze.w = '".$__rsz_w."';  
	";

	if($___Ls->dt->tot == 0){ 
		$CntWb .= "	
			SUMR_Main.mdlcnt.f.init();   
		";
	}

?>