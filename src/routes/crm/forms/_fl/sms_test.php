<?php 
	$_i = Php_Ls_Cln($_GET['_i']);	
	$__id_fm = 'FmEnc'.Gn_Rnd(20);
?>
<div class="_fm_fnc"> 
        <div class="wrp">  
				<div class="_img _hdr_sms" id="__url_end"></div>
						<div id="<?php echo $__id_fm ?>_ld" class="_ld" style="display:none;"></div>
						<div id="<?php echo $__id_fm ?>_rsl" class="_rsl" style="display:none;">
							<?php echo h2(Spn(TX_ENVMSN ).HTML_BR.TX_SCSFLL); ?>
						</div>
						<div id="<?php echo $__id_fm ?>_flds">	
					  		<form>
								 <?php echo HTML_inp_hd('___t_cnt', $__dt_cnt->cnt->id); ?>
								 <?php echo HTML_inp_hd('___t_rlc', $__dt_cnt->id); ?>
								 <?php echo HTML_inp_hd('telsnd_ec', 509); ?>
								<div class="ln_1">
										<div class="col_1">
											<div class="_MblBx">
												<div class="_Hdr"></div>
												<div class="_Bdy">
													<div class="_Lft"></div>
													<div class="_Msj">
														<div class="_MsjBx" id="_MsjBx"></div>
													</div>
													<div class="_Rgh"></div>
												</div>
												<div class="_MsjCountBx" id="_MsjCountBx">TX_SMS_CRCTR</div>
											</div>	
										</div>
										<div class="col_2">
											<?php 
												if($row_Dt_Rg['sms_ps'] == ''){ $__ps_id = 57; }else{ $__ps_id = $row_Dt_Rg['sms_ps']; }
												echo LsSis_PsOLD('sms_ps','id_sisps', $__ps_id, '-', 2, '', '', 'iso'); 
												$CntWb .= JQ_Ls('sms_ps', '-', '', 'psFlg'); 
											?>
											<?php echo HTML_inp_tx('sms_tel', TX_NMR, '', FMRQD_NMR, ' minlength="10" maxlenght="10" '); ?>	
											<?php echo HTML_inp_tx('sms_frm', 'De:', DB_CL_NM, '', ' minlength="15" maxlenght="15" '); ?>	
											<div class="__msj_cel"><?php echo HTML_textarea('sms_msj', '', '', FMRQD, 'ok', '', 5, 160); ?> </div>
											<div class="_snd_fnc"><input type="button" class="btn" id="SndPss" value="<?php echo TX_SNDSMS ?>" /></div>
										</div>
								</div>		                                	
							</form>	
				  		</div>
				  		
				  		<?php 	
								
							$CntWb .= "
										
								SUMR_Main.sms.bld({	
									btn:'SndPss',
									bx:{
										msj:'_MsjBx',
										cnt:'_MsjCountBx'
									},
									ps:'sms_ps',
									frm:'sms_frm',
									tel:'sms_tel',
									msj:'sms_msj',
									_c:function(){
										
										var __ps = $('#sms_ps').val();
										var __frm = $('#sms_frm').val();
										var __tel = $('#sms_tel').val();
										var __msj = $('#sms_msj').val();
									
									
										$.ajax({
											type: 'POST',
											dataType: 'json',
											beforeSend: function() {
												$('#{$__id_fm}_ld').fadeIn();
												$('#{$__id_fm}_flds').fadeOut(); 
											},
											url:'".Fl_Rnd(PRC_GN.'?')."&_t=sms_test',
											data: { 
												'MM_insert': 'EdSmsSnd',
												'telsnd_ps': __ps,
												'telsnd_frm': __frm,
												'telsnd_tel': __tel,
												'telsnd_msj': __msj
											},
											success: function(d) {
												if(d.e == 'ok'){
													$('#{$__id_fm}_rsl').fadeIn('fast');
													
													$.colorbox.resize({
														height: '350px'
														});

												}else{
													$('#{$__id_fm}_flds').fadeIn();
												}
												
												$('#{$__id_fm}_ld').fadeOut();
											}
										});
										
									}
								});
							";	
				  		
				  		?>
				</div>
    	</div>
</div>
