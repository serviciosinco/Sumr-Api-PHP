<?php
	
	
	$__c = Php_Ls_Cln($_GET['__c']);
	
	
	$__id_fm = 'FmEnc'.Gn_Rnd(20);
	$__dtmdl = GtMdlDt([ 'id'=>$___Ls->gt->isb, 't'=>'enc' ]);
	$__dt_cnt = GtCntDt([  'id'=>$__c, 't'=>'enc' ]);
	
?>
<div class="_fm_fnc"> 
    <div class="wrp">  
              
						
			<div id="<?php echo $__id_fm ?>_ld" class="_ld" style="display:none;"></div>
			<div id="<?php echo $__id_fm ?>_rsl" class="_rsl" style="display:none">
				<input type="button" class="btn_ok" id="Nw_Enc" value=<?php echo TX_CNTNR ?>/>
				<input type="button" class="btn_nw" id="Nw_Sre" value=<?php echo TX_NWSR ?>/>
			</div>
			
		
							
  			<div id="<?php echo $__id_fm ?>_flds">
          	
          	<div class="_img" id="__url_end">
              	<iframe src="<?php echo DMN_ANM; ?>encuestas/index.html" frameborder="0" width="100%" scrolling="no" height="200"></iframe>
          	</div>
          	<?php if($__dtmdl->sds_p->id != NULL){ echo h1($__dtmdl->sds_p->clg->nm); } ?>
         
          	
          	<?php if(isN($__dtmdl->id)){ ?>
				  		
				  		<form action="<?php echo PRC_GN.__t('act', true) ?>" method="POST" <?php if($_GET['Sv'] != 'ok'){ ?>name="<?php echo $__id_fm ?>" id="<?php echo $__id_fm ?>" <?php }else{ ?> target="_blank" <?php } ?> >
							
							
							
							<div class="_d _cod">
                                    <div class="_d1">E</div>
                                    <div class="_d2"><?php echo _HTML_Input('Sch_Cod', '000', '', FMRQD_NM); ?></div>
                            </div>
									                                
									                                	
							<div class="_snd_fnc"><input type="button" class="btn" id="SchAct" value="Iniciar" /></div>	
				  		</form>	
				  		
				  		<?php
					  		
								$CntWb .= "
										
										
										function __SchEnc(){
											
											if( $('#Sch_Cod').valid() ){
												
												_Rqu({ 
													t:'act_sch', 
													_i:$('#Sch_Cod').val(),
													_cl:function(_r){
														if(!isN(_r)){
															
															if(_r.e == 'ok'){
																var __lnk = '".Fl_Rnd(FL_FM_GN.'?')."&_t=act_enc&__i='+_r.i+'&".$___Ls->ls->vrall."';
																_ldCnt({
																	u:__lnk, 
																	pop:'ok',
																	pop_rst:'no',
																	pnl_frce:'ok',
																	w:'484', 
																	h:'270', 
																	cls:'_fm_fncPop'
																});	
														    }else{
															    swal('Error', 'El código no existe en nuestra BD', 'error');
														    }
													    
													    
														}
													} 
												});
												
											}	
												
										}
										
										
										$('#SchAct').off('click').click(function() {	
											
											__SchEnc();
											
										});
										
										
										$('#Sch_Cod').keypress(function(e) {
											if (e.keyCode == 13){ 
												e.preventDefault();
												__SchEnc();									    
											}
										});
						
						
								";	
				  	
				  		?>
		  		
		  	</div>
		  		
		  		
		  	<?php }else{ ?>

                  		
              		<?php if(isN($__dt_cnt->id) && $__n != 'ok'){ ?>
              			
                          <div class="__sch_json _sch_enc" id="__sch_json">
                                <?php 
                                    
                                    $CntWb .= "
                                        
                                        function __sch_cnt(__i){
                                            	
                                        	var __i = $('#__id_sch').val();
                                        	
                                        	if(!isN(__i)){
                                            	
	                                        	$('#__sch_json').addClass('__ld');
	                                            
	                                            _Rqu({ 
													t:'cnt', 
													_i:__i,
													_cm:function(){  $('#__sch_json').removeClass('__ld'); },
													_cl:function(_r){
														if(!isN(_r)){
															
															if(_r.e == 'ok' && !isN(_r.enc)){
																var __frw = '&__c='+_r.enc;
			                                                }else if(_r.e == 'no'){	
																var __frw = '&__n=ok';     
			                                                }
			                                                
			                                                var __lnk = '".Fl_Rnd(FL_FM_GN.'?')."&_t=act_enc&__i=".$__dtmdl->enc."'+__frw+'&".$___Ls->ls->vrall."';
															
															_ldCnt({
																u:__lnk, 
																pop:'ok', 
																pop_rst:'no',
																pnl_frce:'ok',
																w:'700', 
																h:'550',
																cls:'_fm_fncPop'
															});			                                                
													    
														}
													} 
												});
											
											}
												
                                        }
                                        
                                        
                                        $('#__sch_json_btn').off('click').click(function(){
										    __sch_cnt();
                                        });
										
										
										$('#__id_sch').keypress(function(e) {
											if (e.keyCode == 13){ 
												e.preventDefault();
												__sch_cnt();									    
											}
										});
										
										
										
                                ";
                                
                                
                                ?>
                                <div class="_c1"><?php echo HTML_inp_tx('__id_sch', TX_DCID.' / '.TT_FM_EML, '', FMRQD); ?></div>
                                <div class="_c2"><input id="__sch_json_btn" name="__sch_json_btn" type="button" class="br_rds grd_blue" value="" /></div>
                        </div>
                          
					<?php }else{ ?> 
					
						<form action="" method="POST" <?php if($_GET['Sv'] != 'ok'){ ?>name="<?php echo $__id_fm ?>" id="<?php echo $__id_fm ?>" <?php }else{ ?> target="_blank" <?php } ?> >
						 	<div class="cnt_frst">
			               		<div id="<?php echo $__id_fm ?>_flds">        
								    
			                        <input id="____key" name="____key" type="hidden" value="<?php echo $__id_rnd ?>" />        
									<input name="SndUs<?php echo $__id_rnd ?>" id="SndUs<?php echo $__id_rnd ?>" type="hidden" value="On" />
				                    <input name="SndEmad<?php echo $__id_rnd ?>" id="SndEmad<?php echo $__id_rnd ?>" type="hidden" value="On" />
				                    <input name="MM_Send<?php echo $__id_rnd ?>" id="MM_Send<?php echo $__id_rnd ?>" type="hidden" value="WebLndg" />
				                    <input name="SndFnt<?php echo $__id_rnd ?>" id="SndFnt<?php echo $__id_rnd ?>" type="hidden" value="16"> 
				                    <input name="SndMed<?php echo $__id_rnd ?>" id="SndMed<?php echo $__id_rnd ?>" type="hidden" value="341">
									<input name="Act<?php echo $__id_rnd ?>" id="Act<?php echo $__id_rnd ?>" type="hidden" value="<?php echo $__dtmdl->enc ?>" />
									
									<input id="mdlcnt_cnt" name="mdlcnt_cnt" type="hidden" value="<?php echo $__dt_cnt->id ?>" />	
											<ul>				
			                                    <li>
			                                    	<div class="_c3">
														<div class="_d1"><?php echo _HTML_Input('cnt_nm', TX_NM, $__dt_cnt->nm, FMRQD); ?></div>
														<div class="_d2"><?php echo _HTML_Input('cnt_ap', TT_FM_AP, $__dt_cnt->ap, FMRQD); ?></div>
														<div class="_d3"><?php echo _HTML_Input('cnt_eml', TT_FM_EML, $__dt_cnt->eml[0]->v, FMRQD_EM ); ?></div>
													</div>
												</li>
									            <li>	
										            <div class="_d">
											            
					                                        <div class="_d1">
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
					                                        <div class="_d2"><?php echo _HTML_Input('cnt_dc', 'Documento', $__dt_cnt->dc_m['0'], FMRQD); ?></div>
					                                        <?php echo HTML_inp_hd('mdlcnt_enc_us', SISUS_ID); ?>
					                                </div>
									            </li>
												<?php if($__dtmdl->sds_p->id == NULL){ print_r($__dtmdl->sds_p); ?>
													<li id="bx_clg_1">
														<?php echo '<div class="_sl">
																	<select id="cnt_clg" name="cnt_clg" class="required"></select>
																</div>'; $CntWb .= JQ_Ls('cnt_clg', FM_LS_TPDOC); ?>
													</li>
													<li id="bx_clg_2" style="display:none">
														<?php echo _HTML_Input('cnt_clgwrt', TX_CLG, '', FMRQD); ?>
													</li>
													<?php 	
														$CntWb .= "	
														
															$('#cnt_clg').change(function() {
																var _t__v = $(this).val();
																if(_t__v == '-wrt-'){
																	
																	$('#bx_clg_1').fadeOut();
																	$('#bx_clg_2').fadeIn();
																	
																}
															});
															
															
															SUMR_Main.slc_sch({ id:'cnt_clg', ph:'- selecciona tu colegio -', t:'slc_clg', w:'cnt_clgwrt' });
																	
														";
													?>
												<?php }else{ ?>
													
													<input name="cnt_clg" id="cnt_clg" type="hidden" value="<?php echo $__dtmdl->sds_p->id ?>">				
															
												<?php } ?>
												
												 
												
												
												<li><div class="_d2">
													<?php echo Ls_GrdClg('cnt_grd', 'clgkey', $___Ls->dt->rw['cnt_grd'], FM_LS_SLGRD,'2'); $CntWb .= JQ_Ls('cnt_grd','');  ?>
												</div></li>
												
												
												
												<li>
													<div class="_c3">

														<div class="_d1">
														<?php echo LsSis_Tel('cnt_tel_tp','id_sistel', '', FM_LS_SLTEL, 2); $CntWb .= JQ_Ls('cnt_tel_tp', FM_LS_SLTEL); ?>
														</div>
														<div class="_d2">
															
														<?php 
															

															echo LsSis_PsOLD('cnt_tel_ps','id_sisps', 57, '-', 2, '', '', 'iso'); 
															$CntWb .= JQ_Ls('cnt_tel_ps', '-', '', 'psFlg'); 
															
															
															$CntWb .= "
																
																
																$('#cnt_tel_tp').change(function() {
																	
																	var __id_tp = $(this).val(); 
																	var __id_ext = $('#cnt_tel_ext');
																	var __id_tel = $('#cnt_tel'); 
																	var __sl = $('#cnt_tel_tp option:selected');
																	var __sl_r = __sl.attr('rel');
																	var __sl_r_o = eval('('+__sl_r+')');
																	
																	if( __id_tp != 2 ){
																	 	__id_ext.fadeOut();  
																	}else{
																  		__id_ext.fadeIn();   
																  	}
																  	
																  	__id_tel.attr({
																       'maxlenght' : __sl_r_o._min,
																       'minlenght' : __sl_r_o._max 
																    });
																  
																});
						
						
						
															";
														?>

														</div>
														<div class="_d3">
															<?php echo _HTML_Input('cnt_tel', TX_NMR, $__dt_cnt->tel[0]->v, FMRQD_NMR); ?>	
														</div>
														
														<?php echo HTML_inp_tx('cnt_tel_ext', TX_EXT, '', FMRQD_NMR, ' style="display:none;" '); ?>
								

													</div>
												</li>
												
												
												<li id="bx_mdl_1">
													<?php 															
														echo LsMdl('mdl_1', 'mdl_enc', '', '', 1, '', [ 'tp'=>$___Ls->mdlstp->id ]);                           
														$CntWb .= JQ_Ls('mdl_1', TX_SLCNMDL); 
													?>
												</li>
												<li id="bx_mdl_2" style="display:none;">
													<?php 	
														echo LsMdl('mdl_2', 'mdl_enc', '', '', 2, '', [ 'tp'=>$___Ls->mdlstp->id ]);                           
														$CntWb .= JQ_Ls('mdl_2', TX_SLCNMDL); 
													?>
												</li>
												<li id="bx_mdl_4" style="display:none;">
													<?php echo _HTML_Input('mdl_wrt', TT_FM_NM, '', FMRQD); ?>
												</li>
												<li class="_snd_fnc"><input type="button" class="btn" id="Sve_Enc" value="<?php echo TXBT_GRDR ?>" /></li>		           	   
											</ul>
											<?php 	
												
												$CntWb .= "	
																				
																					
															setTimeout(function(){
															   $('#cnt_nm').focus();
															}, 1000);

															
															$('#mdl_1').change(function() {
																var _t__v = $(this).val();
																if( _t__v != '-oth-'){
																	$('#bx_mdl_2').fadeIn();
																}else{
																	$('#bx_mdl_1').fadeOut();	
																	$('#bx_mdl_2').fadeOut();
																	$('#bx_mdl_3').fadeIn();		
																}								
															});
															
															$('#mdl_oth').change(function() {
																var _t__v = $(this).val();
																if(_t__v == '-wrt-'){
																	$('#bx_mdl_3').fadeOut();
																	$('#bx_mdl_4').fadeIn();
																}
															}); 
															
															
															
															SUMR_Main.slc_sch({ id:'mdl_oth', ph:'- escribe el mdlgrama de tu interés -', t:'slc_mdl_o', w:'mdl_wrt' });
															
																			
															$('#Sve_Enc').off('click').click(function() {
																
																if( $('#{$__id_fm}').valid() ){
																	
																	$.ajax({
																		type: 'POST',
																		dataType: 'json',
																		url:'".PRC_GN.__t('enc', true)."',
																		data: $('#{$__id_fm}').serialize(),
																		beforeSend: function() {
																			$('#{$__id_fm}_ld').fadeIn();
																			$('#{$__id_fm}_flds').fadeOut(); 
																		},
																		success: function(d) {
																		    
																		    $('#{$__id_fm}_ld').fadeOut();
																		    
																		    if(d.e == 'ok'){
																				
																				$('#{$__id_fm}_rsl').fadeIn('slow', function(){
																					$(this).colorbox.resize();	
																				});
																				
																				$('#Nw_Enc').off('click').click(function() {
																				var __lnk = '".Fl_Rnd(FL_FM_GN.'?')."&_t=enc&__i=".$__dtmdl->enc."';
																				_ldCnt(__lnk, '', 'ok', '484', '360', '', '', {cls:'_fm_fncPop'});
																				});
				
																				$('#Nw_Sre').off('click').click(function() {
																					var __lnk = '".Fl_Rnd(FL_FM_GN.'?')."&_t=enc';
																					_ldCnt(__lnk, '', 'ok', '484', '360', '', '', {cls:'_fm_fncPop'});
																				});	 
																					
																		    }else{
																			    $('#{$__id_fm}_flds').fadeIn();
																		    }
																		    
																		}
																	});
								
																}
														}); 

															
												";
											?>       		
						
								
								</div> 	 
							</div>
						</form> 
				
				<?php } ?>
			<?php } ?>
     
            <?php $CntWb .= ""; ?>             
    </div>
</div>

<style>
	
	.__sch_json._sch_enc input[type=text]{ padding: 15px 10px; border: none; }
	.__sch_json._sch_enc input[type=button]{ width: 100%; background-size: auto 70%; }
	
</style>	