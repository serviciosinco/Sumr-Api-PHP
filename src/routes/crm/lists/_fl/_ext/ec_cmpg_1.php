<?php 	
	
	$__cmpg_dt = GtEcCmpgDt([ 'id'=>$___Ls->dt->rw['id_eccmpg'], 'ec'=>'ok', 'q_tot'=>'ok', 'q_btch'=>'ok', 'sgm'=>['e'=>'ok'], 'lsts'=>['e'=>'ok'] ]);

	if($___Ls->dt->rw['eccmpg_sndr'] != _CId('ID_SISEML_OFC') && $___Ls->dt->rw['eccmpg_sndr'] != _CId('ID_SISEML_SUMR') && $___Ls->dt->rw['eccmpg_sndr'] != _CId('ID_SISEML_ICOMM')){
		
		$___cls_out = '__out';
		
	}
	
	
	$__tab = [
				['n'=>'sndd', 't'=>'snd_ec_snd', 'l'=>TX_SNTCMP],
				['n'=>'lst',  't'=>'snd_ec_lsts_rel', 'l'=>'Listas'],
				['n'=>'sgm',  't'=>'snd_ec_sgm_rel', 'l'=>'Segmentos']
			];
	
	$___Ls->_dvlsfl_all($__tab,[ 'idb'=>'ok' ]);	
	
	$__dtec = GtEcDt($___Ls->dt->rw['eccmpg_ec']);
		
?>	
<div id="<?php echo $___Ls->tab->id ?>" class="VTabbedPanels mny SndIn <?php echo $___cls_out; ?>">
    <ul class="TabbedPanelsTabGroup">
    	<?php echo $___Ls->tab->bsc->l ?>
    	<?php //echo $___Ls->tab->sndd->l ?>
    	<?php echo $___Ls->tab->lst->l ?> 
    	<?php echo $___Ls->tab->sgm->l ?>       
    </ul>
  	<div class="TabbedPanelsContentGroup">
        <div class="TabbedPanelsContent">
			
			<div class="__bx_dsh">
				
	        	<div class="col_1">
		        	
					<h1 title="<?php echo ctjTx($___Ls->dt->rw['eccmpg_nm'],'in'); ?>">
						<?php echo Spn('','','_icn').ctjTx($___Ls->dt->rw['eccmpg_nm'],'in').Spn($__cmpg_dt->cod, 'ok'); ?>
						
						<?php if(($___Ls->dt->rw['eccmpg_sndr'] == _CId('ID_SISEML_SUMR') || $___Ls->dt->rw['eccmpg_sndr'] == _CId('ID_SISEML_OFC')) &&
								  $___Ls->dt->rw['eccmpg_est'] == _CId('ID_ECCMPGEST_APRBD') ){ ?>
						
						<button class="run_code" id="run_code_<?php echo $___Ls->id_rnd; ?>">Enviar Prueba</button>
										
						<?php 
							
							$CntWb .= "
								
								$('#run_code_".$___Ls->id_rnd."').off('click').click(function(e){
										
									e.preventDefault();
									
									if(e.target != this){	
								    		e.stopPropagation(); return;	
									}else{
										
										var _cmpg = '".$___Ls->dt->rw['eccmpg_enc']."';
										
										if(!isN(_cmpg)){
											_ldCnt({ 
												u:'".FL_FM_GN.__t('snd_ec_cmpg_test',true)."', 
												d:{
													cmpg:_cmpg
												},
												pop:'ok', 
												pnl:{
													e:'ok',
													s:'l',
													tp:'h',
												},
												cls:'_fll'
											});
										}
											
									}
									
								});	
		
							";
							
						?>
						
						<?php } ?>

						
						<?php //if(isN($___cls_out)){ ?>
						
							<br>
							<div id="_status_<?php echo $___Ls->id_rnd; ?>" class="_status _anm" style="background-color:<?php echo $__cmpg_dt->est->clr; ?>">
								
								<?php if(!_ChckMd('snd_cmpg_mod')){ ?>
									<div class="_now _anm">
										<?php echo Strn(ctjTx($___Ls->dt->rw['Estado_sisslc_tt'],'in')) ; ?>
									</div>
								<?php }else{ ?>
									<div class="_chng _anm">
										<?php
											$l = __Ls([ 'k'=>'ec_cmpg_est', 'id'=>'cmpg_est'.$___Ls->id_rnd, 'va'=>$___Ls->dt->rw['eccmpg_est'], 'ph'=>TX_EST ]);
											echo $l->html;
											$CntWb .= $l->js;
										?>
									</div>
								<?php } ?>
								
							</div>
		
						<?php //} ?>
						
					</h1>
					
					<div class="_img">
						<?php if($__dtec->upd_img == 'no'){ ?>
							<div class="_src"><img src="<?php echo DMN_FLE_EC.'th/ec_ste_'.$__dtec->enc.'.jpg'; ?>"></div>
						<?php } ?>
						<div class="_opt _anm">
							<ul>
								<li class="prvw _anm"><button></button></li>
								<li class="dwn _anm"><button></button></li>
							</ul>	
						</div>
						<div class="_pem"><?php echo $__cmpg_dt->ec->pem.HTML_BR.Spn($__cmpg_dt->ec->us->nm.' '.$__cmpg_dt->ec->us->ap); ?></div>
					</div>

					<?php
	
						$CntWb .= '
						
							SUMR_Main.hdbrknimg({ s:"._cmpg_dtl img", a:"eli" });
							
							$("._img ._opt .dwn").off("click").click(function (){
								window.open("'.DMN_DWN.PrmLnk('bld', LNK_EC).$__dtec->enc.'/?__e=ec_dwn", "_blank");
							});
							
							$("._img ._opt .prvw").off("click").click(function (){
								
								_ldCnt({ 
									u:"'.Fl_Rnd(FL_DT_GN.__t('snd_ec',true)).Fl_i($__dtec->enc).'", 
									pop:"ok",
									pnl:{
										e:"ok",
										s:"l",
										tp:"h"
									}
								});
								
							});
						';
						
						$CntWb .= "
						
							$('._brd._sndr .eml_spn').off('click').click(function(e){
								$(this).addClass('ok');	
								$('._brd._sndr .styled-select-bx').addClass('ok');
							});
							
							$('._brd._rply .rply_spn').off('click').click(function(e){
								$(this).addClass('ok');	
								$('._brd._rply .___txar._anm').addClass('ok');
								$('.plcy_spn_save').addClass('ok');
							});
							
							$('._brd._dte .f_p_spn').not('.cmpg_npsd').off('click').click(function(e){
								$(this).addClass('ok');	
								$('._brd._dte .___txar._anm').addClass('ok');
								$('.f_p_spn_save').addClass('ok');
							});
							
							$('._brd._hra .h_p_spn').not('.cmpg_npsd').off('click').click(function(e){
								$(this).addClass('ok');	
								$('._brd._hra .___txar._anm').addClass('ok');
								$('.h_p_spn_save').addClass('ok');
							});

							$('._brd._sbj .sbj_spn').off('click').click(function(e){
								$(this).addClass('ok');	
								$('._brd._sbj .___txar._anm').addClass('ok');
								$('.__sbj_spn_save').addClass('ok');
							});
							
							
							$('.f_p_spn_save').off('click').click(function(e){
								
								swal({
									title: '¿Guardar?',
									text: '¿Estas seguro(a) que deseas hacer este cambio?',
									showCancelButton: true,
									confirmButtonColor: '#c59700',
									confirmButtonText:'Si, estoy seguro(a)',
									cancelButtonText: '".TX_CNCLR."',
									closeOnConfirm: true
								},
								function(){

									__id_f_eccmpg = $('#eccmpg_p_f').val();
								
									if(!isN(__id_f_eccmpg)){
										
										var __snd = function(p){
	
											_Rqu({ 
												t:'snd_ec_cmpg',
												f:'prc',
												eccmpg_enc:'".$__cmpg_dt->enc."',
												id_eccmpg:'".$___Ls->dt->rw['id_eccmpg']."',
												eccmpg_p_f : __id_f_eccmpg,
												MMM_update_f_eccmp:'EdSndEcCmpg',
									
												_bs:function(){ $('.f_p_spn_save').addClass('_ld'); },
												_cm:function(){ $('.f_p_spn_save').removeClass('_ld'); },
												_cl:function(_r){ 
													if(!isN(_r)){ 
														if(!isN(_r.e) && _r.e=='ok'){
															swal('Cambio Exitoso', '', 'success');	
																
															$('._brd._dte .f_p_spn').removeClass('ok').html(_r.nm);	
															$('._brd._dte .___txar._anm').removeClass('ok');
															$('.f_p_spn_save').removeClass('ok');
															
														}else{
															swal('Error', '".TX_NSAPRB."','error');		
														}									
													}
												} 
											});	
										};
										
										__snd();	
	
									}

								});

							});

							
							$('.h_p_spn_save').off('click').click(function(e){
								
								swal({
									title: '¿Guardar?',
									text: '¿Estas seguro(a) que deseas hacer este cambio?',
									showCancelButton: true,
									confirmButtonColor: '#c59700',
									confirmButtonText:'Si, estoy seguro(a)',
									cancelButtonText: '".TX_CNCLR."',
									closeOnConfirm: true
								},
								function(){

									var __id_h_eccmpg = $('#eccmpg_p_h').val();
								
									if(!isN(__id_h_eccmpg)){
										
										var __snd = function(p){
	
											_Rqu({ 
												t:'snd_ec_cmpg', 
												f:'prc',
												eccmpg_enc:'".$__cmpg_dt->enc."',
												id_eccmpg:'".$___Ls->dt->rw['id_eccmpg']."',
												eccmpg_p_h : __id_h_eccmpg,
												MMM_update_h_eccmp:'EdSndEcCmpg',
									
												_bs:function(){ $('.h_p_spn_save').addClass('_ld'); },
												_cm:function(){ $('.h_p_spn_save').removeClass('_ld'); },
												_cl:function(_r){ 
													if(!isN(_r)){ 
														if(!isN(_r.e) && _r.e=='ok'){
															swal('Cambio Exitoso', '', 'success');	
																
															$('._brd._hra .h_p_spn').removeClass('ok').html(_r.nm);	
															$('._brd._hra .___txar._anm').removeClass('ok');
															$('.h_p_spn_save').removeClass('ok');
															
														}else{
															swal('Error', '".TX_NSAPRB."','error');		
														}									
													}
												} 
											});	
										};	

										__snd();

									}

								});

							});


							$('.__sbj_spn_save').off('click').click(function(e){ 
								swal({
									title: '¿Guardar?',
									text: '¿Estas seguro(a) que deseas hacer este cambio?',
									showCancelButton: true,
									confirmButtonColor: '#c59700',
									confirmButtonText:'Si, estoy seguro(a)',
									cancelButtonText: '".TX_CNCLR."',
									closeOnConfirm: true
								},
								function(){
									__id_sbj_eccmpg = $('#eccmpg_sbj').val();
								
									if(!isN(__id_sbj_eccmpg)){
										
										var __snd = function(p){
	
											_Rqu({ 
												t:'snd_ec_cmpg', 
												f:'prc',
												eccmpg_enc:'".$__cmpg_dt->enc."',
												id_eccmpg:'".$___Ls->dt->rw['id_eccmpg']."',
												eccmpg_sbj : __id_sbj_eccmpg,
												MMM_update_sbj_eccmp:'EdSndEcCmpg',
									
												_bs:function(){ $('.__sbj_spn_save').addClass('_ld'); },
												_cm:function(){ $('.__sbj_spn_save').removeClass('_ld'); },
												_cl:function(_r){ 
													if(!isN(_r)){ 
														if(!isN(_r.e) && _r.e=='ok'){
															swal('Cambio Exitoso', '', 'success');	
																
															$('._brd._sbj .sbj_spn').removeClass('ok').html(_r.nm);	
															$('._brd._sbj .___txar._anm').removeClass('ok');
															$('.__sbj_spn_save').removeClass('ok');
															
														}else{
															swal('Error', '".TX_NSAPRB."','error');		
														}									
													}
												} 
											});	
										};									
										__snd();	
									}
								});
							});
							
							$('.plcy_spn_save').off('click').click(function(e){
								
								swal({
									title: '¿Guardar?',
									text: '¿Estas seguro(a) que deseas hacer este cambio?',
									showCancelButton: true,
									confirmButtonColor: '#c59700',
									confirmButtonText:'Si, estoy seguro(a)',
									cancelButtonText: '".TX_CNCLR."',
									closeOnConfirm: true
								},
								function(){
									__id_rply_eccmpg = $('#eccmpg_rply').val();
								
									if(!isN(__id_rply_eccmpg)){
										
										var __snd = function(p){
	
											_Rqu({ 
												t:'snd_ec_cmpg', 
												f:'prc',
												eccmpg_enc:'".$__cmpg_dt->enc."',
												id_eccmpg:'".$___Ls->dt->rw['id_eccmpg']."',
												eccmpg_rply : __id_rply_eccmpg,
												MMM_update_rply_eccmp:'EdSndEcCmpg',
									
												_bs:function(){ $('.plcy_spn_save').addClass('_ld'); },
												_cm:function(){ $('.plcy_spn_save').removeClass('_ld'); },
												_cl:function(_r){ 
													if(!isN(_r)){ 
														if(!isN(_r.e) && _r.e=='ok'){
															swal('Cambio Exitoso', '', 'success');	
																
															$('._brd._rply .rply_spn').removeClass('ok').html(_r.nm);	
															$('._brd._rply .___txar._anm').removeClass('ok');
															$('.plcy_spn_save').removeClass('ok');
															
														}else{
															swal('Error', '".TX_NSAPRB."','error');		
														}									
													}
												} 
											});	
										};									
										__snd();	
									}
								});
							});
						
							

							$('#sis_eml').change(function() {
						
								var __id_sndr = $(this).val();
								
								if(!isN(__id_sndr)){
									
									var __snd = function(p){

										_Rqu({ 
											t:'snd_ec_cmpg', 
											f:'prc',
											eccmpg_enc:'".$__cmpg_dt->enc."',
											eccmpg_sndr: __id_sndr,
											MMM_update_sndr:'EdSndEcCmpg',
								
											_bs:function(){ $('#sis_eml').addClass('_ld'); },
											_cm:function(){ $('#sis_eml').removeClass('_ld'); },
											_cl:function(_r){ 
												if(!isN(_r)){ 
													if(!isN(_r.e) && _r.e=='ok'){
														swal('Cambio Exitoso', '', 'success');	
														
														$('._brd._sndr .styled-select-bx').removeClass('ok');
														$('._brd._sndr .eml_spn').removeClass('ok').html(_r.nm);
														
													}else{
														swal('Error', '".TX_NSAPRB."','error');		
													}									
												}
											} 
										});
										
									};
									
									__snd();	

								}
					
							});
							
						";

						$CntWb .= "
							
							$('#cmpg_est".$___Ls->id_rnd."').change(function() {
						
								var __id_est = $(this).val();
								
								if(!isN(__id_est)){
									
									var __snd = function(p){
										
										if(!isN(p) && !isN(p.mtv)){ var _mtv=p.mtv; }else{ var _mtv=''; }
										
										_Rqu({ 
											t:'snd_ec_cmpg', 
											f:'prc',
											eccmpg_enc:'".$__cmpg_dt->enc."',
											eccmpg_est:__id_est,
											eccmpg_nprb_dsc:_mtv,
											MMM_update_est:'EdSndEcCmpg',
								
											_bs:function(){ $('#_status_".$___Ls->id_rnd."').addClass('_ld'); },
											_cm:function(){ $('#_status_".$___Ls->id_rnd."').removeClass('_ld'); },
											_cl:function(_r){ 
												if(!isN(_r)){ 
													if(!isN(_r.e) && _r.e=='ok'){
														swal('Cambio Exitoso', '', 'success');	
														if(!isN(_r.est) && !isN(_r.est.d) && !isN(_r.est.d.clr) && !isN(_r.est.d.clr.vl)){
															$('#_status_".$___Ls->id_rnd."').css('background-color', _r.est.d.clr.vl);	
														}
													}else{
														swal('Error', '".TX_NSAPRB."','error');		
													}									
												}
											} 
										});
										
									};
									
									
									if(__id_est == '"._CId('ID_ECCMPGEST_NAPRBD')."'){
										
										swal({
											title: '¿No Aprobado?',
											/*text: '¿Estas seguro(a) de marcar como no aprobada esta campaña?',*/
											type: 'input',
											showCancelButton: true,
											confirmButtonColor: '#c59700',
											confirmButtonText:'Si, estoy seguro(a)',
											cancelButtonText: '".TX_CNCLR."',
											showLoaderOnConfirm: true,
											inputPlaceholder: 'Ingresa el motivo de la no aprobación',
											closeOnConfirm: false
										},
										function(_iVle){
											
											if(_iVle === false){ return false; }
											if(!isN(_iVle)){ var _mtv = _iVle; }else{ var _mtv = ''; }
											__snd({ mtv:_mtv });
											
										});
										
										
									}else{
										
										__snd();	
										
									}
										
									
								}
					
							});
							
						";
	
					?>
						
						
					<div id="__grph_crsl_snd_<?php echo $___Ls->id_rnd; ?>" class="owl-carousel owl-theme no-draggable-area">
										
						<div class="item">
							<ul class="ls_2">
								<li class="_brd _frm"><?php echo Strn(Spn().TX_DRMTNT.' '). ctjTx($___Ls->dt->rw['eccmpg_frm'],'in') ; ?></li>
								<li class="_brd _sndr">
									<?php echo Strn(Spn().TX_PLTFRM.': '). Spn(ctjTx($___Ls->dt->rw['Sender_sisslc_tt'],'in'),'','eml_spn') ; ?>
									<?php 
										if(ChckSESS_superadm()){
											$l = __Ls(['k'=>'sis_eml', 'id'=>'sis_eml', 'va'=>$___Ls->dt->rw['Sender_id_sisslc'] , 'ph'=>'Sender']); echo $l->html; $CntWb .= $l->js;	
										}
									?>													
								</li>
								<li class="_brd _prhdr"><?php echo Strn(Spn().'Preheader: '). ctjTx($___Ls->dt->rw['eccmpg_prhdr'],'in') ; ?></li>
								
								<?php if(!isN($___Ls->dt->rw['eccmpg_rply'])){ ?>
										<li class="_brd _rply">
											<?php echo Strn(Spn().'Reply to: '). Spn(ctjTx($___Ls->dt->rw['eccmpg_rply'],'in'),'','rply_spn') ; ?>
											<?php 
												if(ChckSESS_superadm()){
													echo HTML_inp_tx('eccmpg_rply','', ctjTx($___Ls->dt->rw['eccmpg_rply'],'in'), '', '', '_nm');
													echo Spn('','','plcy_spn_save');			
												} 
											?>
										</li>
									
								<?php } ?>
								
								<li class="_brd _sbj">
									<?php echo Strn(Spn().TX_SBJCT.': '). Spn(ctjTx($___Ls->dt->rw['eccmpg_sbj'],'in'),'','sbj_spn') ; ?>
									<?php 
										if(ChckSESS_superadm()){
											echo HTML_inp_tx('eccmpg_sbj','', ctjTx($___Ls->dt->rw['eccmpg_sbj'],'in'), '', '', '_nm');
											echo Spn('','','__sbj_spn_save');			
										} 
									?>
								</li>

								<?php if($___Ls->dt->rw['eccmpg_est'] ==  _CId('ID_ECCMPGEST_PSD')){ $__psd = 'cmpg_psd'; }else{ $__psd = 'cmpg_npsd'; } ?>

								<?php if(isN($___Ls->dt->rw['eccmpg_p_f']) || $___Ls->dt->rw['eccmpg_p_f'] == '0000-00-00'){ $_nl = 'empty'; }else{ $_nl = ''; } ?>
								<li class="_brd _dte <?php echo $_nl; ?>">
									
									<?php echo Strn(Spn().TX_SCHDLDY.': '). Spn(FechaESP_OLD($___Ls->dt->rw['eccmpg_p_f']),'','f_p_spn '.$__psd) ; ?>
									<?php 
										if( (ChckSESS_superadm() || _ChckMd('eccmpg_p_f')) && $___Ls->dt->rw['eccmpg_est'] ==  _CId('ID_ECCMPGEST_PSD') ){
											echo SlDt([ 'id'=>'eccmpg_p_f', 'va'=>$___Ls->dt->rw['eccmpg_p_f'], 'rq'=>'no', 'ph'=>TX_F, 'lmt'=>'no', 'yr'=>'ok', 'cls'=>CLS_CLND ]);
											echo Spn('','','f_p_spn_save');
										}
									?>
								</li>
								<?php if(isN($___Ls->dt->rw['eccmpg_p_h']) || $___Ls->dt->rw['eccmpg_p_h'] == '00:00:00'){ $_nl = 'empty'; }else{ $_nl = ''; } ?>
								<li class="_brd _hra <?php echo $_nl; ?>">
									<?php echo Strn(Spn().TX_HP.': '). Spn(_DteHTML(['d'=>$___Ls->dt->rw['eccmpg_p_h'], 'nd'=>'no']),'','h_p_spn '.$__psd ) ; ?>
									<?php 
										if( (ChckSESS_superadm() || _ChckMd('eccmpg_p_h')) && $___Ls->dt->rw['eccmpg_est'] ==  _CId('ID_ECCMPGEST_PSD') ){
											echo SlDt([ 't'=>'hr', 'id'=>'eccmpg_p_h', 'va'=>$___Ls->dt->rw['eccmpg_p_h'], 'rq'=>'no', 'ph'=>TX_HR, 'lmt'=>'no', 'yr'=>'ok', 'cls'=>CLS_CLND ]);
											echo Spn('','','h_p_spn_save');
										}
									?>
								</li>
								
							</ul>	
						</div>
						
						<div class="item">	
							<ul class="ls_2">
								<?php if($___Ls->dt->rw['eccmpg_out_lsts']){ ?>
								<li class="_brd"><?php echo Strn(Spn().TX_LSTXTRN). ctjTx($___Ls->dt->rw['eccmpg_out_lsts'],'in') ; ?></li>
								<?php } ?>
			
								
								<?php if(!isN($__cmpg_dt->lsts)){ ?>
									<li class="_brd _pointto">
										<?php 
											
											
											//echo Strn('Lista ('.$__cmpg_dt->lsts->eml_allw.'): '); 
											echo h2(Spn().TX_LS, 'lsts'); 
											
											
											foreach($__cmpg_dt->lsts->ls as $_k=>$_v){
												if(!isN($_v->nm)){
													$__lst_shw[] = li($_v->nm,'','','',['tt'=>$_v->nm]);
												}
											}
											
											echo ul(implode('', $__lst_shw));
											
										?>
										
										<?php 
											
											
											if(!isN($__cmpg_dt->sgm->ls)){
												
												echo h2(Spn().TX_SGMNTS, 'sgm');
										
										?>		
										
											<ul>
										<?php		
												
												foreach($__cmpg_dt->sgm->ls as $_k){ 
													
													if(!isN($_k->nm)){
										?>
													<li title="<?php echo $_k->nm; ?>">
													<?php echo $_k->nm; /*.Strn($_k->nm.'Con: '). $_k->var->tot.' variable(s)'*/ ?>
													<?php if(!isN($_k->var->lsts)){ ?>
														<ul>
															<?php 											
																
																foreach($_k->var->ls as $_k2=>$_v2){ 
																	
																	$__tt_html = $_v2->sgm_nm.' '.Spn($_v2->var_nm.' '.$_v2->vl);
																	$__tt_hvr = $_v2->sgm_nm.' ('.$_v2->var_nm.' '.$_v2->vl.')';
																	
																	echo li( $__tt_html, '_brd','','',['tt'=>$__tt_hvr] );
																}
																
															?>
														</ul>
													<?php } ?>
													</li>
												
										<?php 
													
													}		
												} 	
										
										?>
													
											</ul>
												
										<?php
											
											}								
										
										?>	
								
								
									</li>
								<?php } ?>	
							</ul>
						</div>
						
						<?php
	
							$CntWb .= '
								SUMR_Main.ld.f.owl( function(){
									
									$("#__grph_crsl_snd_'.$___Ls->id_rnd.'").owlCarousel({
										items:1,
										margin: 10,
										nav:true
									});
								
								});
							';
	
						?>
					</div>
	
						<?php 
							
							if($___Ls->dt->rw['eccmpg_opn'] != 1 && !isN($__id_bx_dte)){ $CntWb .= " $('#".$__id_bx_dte."').hide(); "; }
							
							$CntWb .= "
						
								$('#eccmpg_opn').change(function() {
									
									if( $(this).is(':checked') ){ 
										$('#".$__id_bx_dte."').show();
										_est_cmpg = 'ok';
										eccmpg_opn(1);
									}else{
										$('#".$__id_bx_dte."').hide();
										_est_cmpg = 'no';
										eccmpg_opn(2);
									}
										
								});
									
								function eccmpg_opn(v){
									
									$.ajax({
										  type: 'POST',
										  dataType: 'json',
										  url: '".Fl_Rnd(PRC_GN.__t('ec_cmpg',true))."',
										  beforeSend: function() {
											 	
										  },
										  data: {
											    '_est': v,
											    '_est_cmpg': _est_cmpg,
					                            'id_eccmpg': '".$___Ls->dt->rw['id_eccmpg']."',
					                            'MMM_update_opn_est': 'EdEcCmpg'      
								          },
							              success: function(d){
								              if(d.e == 'ok'){
											  	msjAlrt({v : 'Bien', msj : 'Se actualizó con exito', tp : 'success'});
											  }else{
												msjAlrt({v : 'Error', msj : 'Error al actualizár', tp : 'error'});	            	
								              }
							              }
									});
									
								}
									
								
	                    		$('#eccmpg_p_fe, #eccmpg_p_he').change(function() {
									
									if($('#eccmpg_opn').is(':checked')){
										
										eccmpg_p_fe = $('#eccmpg_p_fe').val();
										eccmpg_p_he = $('#eccmpg_p_he').val();
										
										$.ajax({
											  type: 'POST',
											  dataType: 'json',
											  url: '".Fl_Rnd(PRC_GN.__t('ec_cmpg',true))."',
											  beforeSend: function() {
												 	
											  },
											  data: {
												  	'_fe': eccmpg_p_fe,
												  	'_he': eccmpg_p_he,
						                            'id_eccmpg': '".$___Ls->dt->rw['id_eccmpg']."',
						                            'MMM_update_opn': 'EdEcCmpg'      
									          },
								              success: function(d){
									              if(d.e == 'ok'){
												  	msjAlrt({v : 'Bien', msj : 'Se actualizó con exito', tp : 'success'});
												  }else{
													msjAlrt({v : 'Error', msj : 'Error al actualizár', tp : 'error'});	            	
									              }
								              }
										});
									}
									
				
								});
	                    		
		                    		
								function msjAlrt(e){
									sweetAlert(e.v, e.msj, e.tp);
								}
	                    		
	                    		
	                        ";  
							
						?>
	
				</div>
				<div class="col_2">
					
					<?php echo h2( Spn('','','_tt_icn _tt_icn_ec') . TX_STTSMRY ); ?>
					
					<?php 
						
						$date1 = new DateTime(SIS_F_TS); 
						$date2 = new DateTime($___Ls->dt->rw['eccmpg_p_f'].' '.$___Ls->dt->rw['eccmpg_p_h']); 	
						$dDiff = $date2->diff($date1);
						
						
						if($dDiff->i > 10 || $dDiff->h > 0 || $dDiff->d > 0 || $dDiff->m > 0 || $dDiff->y > 0){ 
							$___allow_g = 'ok'; 
						}else{ 
							$___allow_g = 'no'; 
						}
						
						if($___Ls->dt->rw['eccmpg_sndr'] == _CId('ID_SISEML_SUMR') || $___Ls->dt->rw['eccmpg_sndr'] == _CId('ID_SISEML_OFC')){ 
							$___allow_g = 'ok'; 
						}else{ 
							$___allow_g = 'no'; 
						}
						
						if($___Ls->dt->rw['eccmpg_est'] == _CId('ID_ECCMPGEST_SND') || $___Ls->dt->rw['eccmpg_est'] == _CId('ID_ECCMPGEST_SNDIN')){
							$___allow_g = 'ok'; 
						}else{ 
							$___allow_g = 'no'; 
						}
						
					?>
					
					<?php if($___allow_g == 'ok'){ ?>
					
					    <div id="bx_grph" class="__bl"></div>
					    
			  			<?php 
				  			$_grph_m = '&_h=500&_i='.$__cmpg_dt->enc;	
				  			$CntWb .= "_ldCnt({ u:'".Fl_Rnd(FL_GRPH_GN.__t('snd_ec_cmpg_d',true))."{$_grph_m}', c:'bx_grph' });";		
			  			?>
				    
				    <?php }else{ ?>
				    
					    <div class="no_data">
						    <div class="_icn"></div>
						    <?php if(!isN($___cls_out)){ ?>
					    		<h2><?php echo TX_SNDXTRN ?></h2>
								<p><?php echo TX_NHSTDSTCS ?></p>
					    	<?php }else{ ?>
					    		<h2><?php echo TX_NDTYT ?></h2>
								<p><?php echo TX_ITELYRLTDTA ?></p>
							<?php } ?>	
					    </div>	
					    
				    <?php } ?>
    
				</div>
        	
			</div>

        </div>
        
        <!--
        <div class="TabbedPanelsContent">
            <?php echo $___Ls->tab->sndd->d ?>     
        </div>
        -->
        
         <div class="TabbedPanelsContent">
            <?php echo $___Ls->tab->lst->d ?>      
        </div>
        
         <div class="TabbedPanelsContent">
            <?php echo $___Ls->tab->sgm->d ?>      
        </div>
                                           
 	</div>
             
</div>
<style>
	
	<?php 
		
		if($___Ls->dt->rw['Sender_sisslc_img'] != ''){ 
			$__sndr_img = DMN_FLE_SIS_SLC.ctjTx($___Ls->dt->rw['Sender_sisslc_img'],'in');
		}else{
			$__sndr_img = '';
		}
		
	?>
	
	._cmpg_dtl h1{ padding: 0px 0px 10px 0; white-space:nowrap; text-overflow: ellipsis; overflow: hidden; }	
	._cmpg_dtl h1 span._icn{ background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>snd_cmpg_nm.svg); width: 20px; height: 20px; display: inline-block;  background-repeat: no-repeat; background-position: center center; background-size: 100% auto; margin-right: 10px; margin-bottom: -1px; }
	
	
	._cmpg_dtl .VTabbedPanels.mny .TabbedPanelsTabGroup{ width: 5% !important; background-color:white; }
	._cmpg_dtl .VTabbedPanels.mny .TabbedPanelsTabGroup .TabbedPanelsTab{ width: 35px; min-width: 35px;  min-height: 35px; background-size: 70% auto; background-position: center center; border-color: #BABABA; background-repeat: no-repeat; }
	._cmpg_dtl .VTabbedPanels.mny .TabbedPanelsContentGroup{ width: 95% !important; }
	._cmpg_dtl .VTabbedPanels.mny .TabbedPanelsContentGroup .TabbedPanelsContent{ padding: 0 15px !important; }
	._cmpg_dtl .VTabbedPanels.mny .TabbedPanelsTabGroup .TabbedPanelsTabSelected{ border: none; }
	
	
	._cmpg_dtl .VTabbedPanels.mny .TabbedPanelsTabGroup .TabbedPanelsTab._bsc{ background-image:url('<?php echo $__sndr_img; ?>'); }
	._cmpg_dtl .VTabbedPanels.mny .TabbedPanelsTabGroup .TabbedPanelsTab._lst{ background-image:url(<?php echo DMN_IMG_ESTR_SVG ?>mdl_form.svg); }
	._cmpg_dtl .VTabbedPanels.mny .TabbedPanelsTabGroup .TabbedPanelsTab._sgm{ background-image:url(<?php echo DMN_IMG_ESTR_SVG ?>bco_are.svg); }
	
	
	._cmpg_dtl .VTabbedPanels.mny.__out .TabbedPanelsTabGroup{ display: none; }
	._cmpg_dtl .VTabbedPanels.mny.__out .TabbedPanelsContentGroup{ width: 100% !important; }
	
	
	._cmpg_dtl ._brd._pointto{ background-color: white; border: none; }
	._cmpg_dtl ._brd._pointto li{ font-family: Roboto; }
	
	._cmpg_dtl ._brd._pointto ul{ text-align: right; width: 100%; padding: 0; margin: 0; display: flex; }
	._cmpg_dtl ._brd._pointto ul li{ text-align: right; padding: 5px 10px !important; display: inline-block; vertical-align: top; border: 1px dotted #c6cdce; border-radius:10px; -moz-border-radius:10px; -webkit-border-radius:10px; width: auto; white-space: nowrap; max-width: 200px; text-overflow: ellipsis; overflow: hidden; }
	
	
	._cmpg_dtl ._brd._pointto h2{ text-transform: uppercase; font-size: 20px; font-weight: 300; }
	._cmpg_dtl ._brd._pointto h2 span{ width: 25px; height: 25px; display: inline-block; margin-right: 5px; background-size: 100%; auto; background-repeat: no-repeat; background-position: center center; }
	
	
	._cmpg_dtl ._brd._pointto .lsts span{ background-image: url('<?php echo DMN_IMG_ESTR_SVG ?>snd_listas_snd.svg'); }
	
	._cmpg_dtl ._brd._pointto .sgm{ font-size: 16px; }
	._cmpg_dtl ._brd._pointto .sgm span{ background-image: url('<?php echo DMN_IMG_ESTR_SVG ?>snd_ec_lsts_sgm.svg'); width: 15px; height: 15px; }




	._cmpg_dtl ._brd strong span{ width: 20px; height: 20px; display: inline-block; margin-right: 6px; margin-bottom: -7px; background-size: 70% auto; background-repeat: no-repeat; background-position: center center; }
    ._cmpg_dtl ._brd._sbj strong span{ background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>snd_cmpg_sbj.svg); } 
    ._cmpg_dtl ._brd._prhdr strong span{ background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>snd_cmpg_prhdr.svg); } 
    ._cmpg_dtl ._brd._frm strong span{ background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>snd_cmpg_frm.svg); } 
    ._cmpg_dtl ._brd._rply strong span{ background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>snd_cmpg_rply.svg); } 
    ._cmpg_dtl ._brd._dte strong span{ background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>snd_cmpg_dte.svg); } 
    ._cmpg_dtl ._brd._hra strong span{ background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>snd_cmpg_hra.svg); } 
	._cmpg_dtl ._brd._sndr strong span{ background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>snd_cmpg_sndr.svg); } 	            
		            
	
	._cmpg_dtl ._status{ display: inline-block; margin-left:5px; width: auto; color: white; border-radius:30px; -moz-border-radius:30px; -webkit-border-radius:30px; padding:8px 15px; cursor: pointer; position: relative; min-width: 80px; min-height: 28px; vertical-align: top; }
	._cmpg_dtl ._status:hover{ background-color: #1c1d1e !important; }
	
	
	._cmpg_dtl ._status._ld{ text-indent: -500px; overflow: hidden; min-width: 28px !important; width: 28px !important; max-width: 28px !important; background-image: url('<?php echo DMN_IMG_ESTR_SVG ?>loader_white.svg'); background-repeat: no-repeat; background-position: center center; background-size: auto 70%; }
	._cmpg_dtl ._status._ld ._chng,
	._cmpg_dtl ._status._ld ._now{ opacity: 0; top: -500px; pointer-events: none; }
	
	
	._cmpg_dtl ._status ._now{ font-size: 11px;  text-transform: uppercase; }
	._cmpg_dtl ._status ._now span,
	._cmpg_dtl ._status ._now strong{ color: white; }
	
	
	
	._cmpg_dtl ._status ._chng{ position: absolute; left: 0; top: 0; width: 100%; }
	._cmpg_dtl ._status ._chng .select2-container--default{ font-size: 11px; vertical-align: top; min-height: 29px; }
	._cmpg_dtl ._status ._chng .select2-container--default .select2-selection--single .select2-selection__rendered{ font-size: 11px; color: white; text-transform: uppercase; font-family: Economica; padding: 0; text-align: center; }
	._cmpg_dtl ._status ._chng .select2-container--default .select2-selection--single{ border: none; color: white; height: 0; }
	._cmpg_dtl ._status ._chng .select2-container--default .select2-selection--single .select2-selection__arrow{ display: none; }
	._cmpg_dtl ._status ._chng .select2-container--default .select2-selection--single .select2-selection__clear{ display: none; }
	
	._cmpg_dtl .VTabbedPanels.mny .no_data{ padding: 20px 30px 0 30px; }  
	._cmpg_dtl .VTabbedPanels.mny .no_data h2{ border:none; text-align: center; color: #100f0f; font-family: Roboto; font-size: 20px; font-weight: 500; }
	._cmpg_dtl .VTabbedPanels.mny .no_data ._icn{ background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>snd_cmpg_nodata.svg); background-position: center center; width: 100%; height: 200px; background-size: auto 70%; background-repeat: no-repeat;  }
	._cmpg_dtl .VTabbedPanels.mny .no_data p{ font-family: Roboto; text-align: center; font-size: 12px; color: #aaaeb0; }

	
	
	._cmpg_dtl .VTabbedPanels.mny.__out .no_data ._icn{ -webkit-filter: grayscale(100%); filter: grayscale(100%); opacity: 0.5; }
	
	
	._cmpg_dtl .__bx_dsh{ display: flex; }
	._cmpg_dtl .__bx_dsh .col_1{ width: 60% !important; }
	._cmpg_dtl .__bx_dsh .col_2{ width: 40% !important; }
	._cmpg_dtl .ls_2 > li{ white-space: nowrap; text-overflow: ellipsis; }
	._cmpg_dtl .ls_2 > li.empty{ border: 1px solid #e49b1c;background-color: #eed7b0; }
					
					
	
	<?php if(ChckSESS_superadm()){ ?>
			.eml_spn.ok,
			.rply_spn.ok,
			.sbj_spn.ok{ display: none; }		
			._brd._sndr .styled-select-bx{ display: none;width: 80% }	
			._brd._sndr .styled-select-bx.ok{ display: inline-block; }
	<?php } ?>	

	._cmpg_dtl .run_code{ margin-left: 10px; font-size: 12px; padding: 7px 8px 7px 30px; background-position: left 6px center; display: inline-block; margin-bottom: 0; }			
	.eml_spn.ok,
	.rply_spn.ok,
	.f_p_spn.ok,
	.h_p_spn.ok,
	.f_p_spn_save,
	.plcy_spn_save,
	.h_p_spn_save,
	.__sbj_spn_save{ display: none; }	
	
	.ui-datepicker{ z-index: 999999999 !important }
			
	._brd._sndr .styled-select-bx,
	._brd._dte .___txar._anm,
	._brd._rply .___txar._anm,
	._brd._hra .___txar._anm,
	._brd._sbj .___txar._anm{ display: none;width: 60% }	
	
	._brd._sndr .styled-select-bx.ok,
	._brd._dte .___txar._anm.ok,
	._brd._rply .___txar._anm.ok,
	._brd._hra .___txar._anm.ok,
	._brd._sbj .___txar._anm.ok,
	.plcy_spn_save.ok,
	.f_p_spn_save.ok,
	.h_p_spn_save.ok,
	.__sbj_spn_save.ok{ display: inline-block; vertical-align: top; }
	
	.plcy_spn_save.ok,
	.h_p_spn_save.ok,
	.f_p_spn_save.ok,
	.__sbj_spn_save.ok{ width: 20px;height: 20px;display: inline-block;vertical-align: top;margin: 8px 3px;cursor: pointer;font-size: 0;background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>save.svg); }

	
</style>