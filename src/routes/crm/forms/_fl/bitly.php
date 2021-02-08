<?php 
	
	$_i = Php_Ls_Cln($_GET['_i']);
	$__id_r = Gn_Rnd(20);
	$__id_fm = 'FmEnc'.$__id_r;
?>
<div class="_fm_fnc"> 
        <div class="wrp">  
              
						<!--<div class="_img _hdr_bitly" id="__url_end"></div>-->

						<section class="_cvr" style="background-color:#7fddff;">
							<iframe src="<?php echo DMN_ANM; ?>anm_bitly/index.html" frameborder="0" width="100%" scrolling="no" height="200"></iframe>
						</section>
							
							
						<div id="<?php echo $__id_fm ?>_ld" class="_ld" style="display:none;"></div>	
						<div style="display: none" id="UrlS_<?php echo $__id_r ?>"><h2></h2></div>
							
              			<div id="<?php echo $__id_fm ?>_flds">
	              			
                        <form action="" method="POST" <?php if($_GET['Sv'] != 'ok'){ ?>name="<?php echo $__id_fm ?>" id="<?php echo $__id_fm ?>" <?php }else{ ?> target="_blank" <?php } ?> >

									<input name="MM_download" id="MM_download" type="hidden" value="Shrtr" />
									<?php echo HTML_inp_hd('_tp', $__prfx->tp); ?>
									
									
					                <div id="<?php echo $__id_fm ?>_flds">        
											 
											<div class="_ln1">  
												<div class="_d1"><?php echo _HTML_Input('_url', TX_LNK_EJM, '', FMRQD_URL); ?></div>
                                            </div>

											<ul>	
												<li class="_snd_fnc"><input type="button" class="btn" id="Do_Rqu<?php echo $__id_r; ?>" value="<?php echo 'Generar' ?>" /></li>		           	   
											</ul>
                                        
											<?php 	
												
												$CntWb .= "	


															
																			
															$('#Do_Rqu$__id_r').click(function() {
																if( $('#{$__id_fm}').valid() ){
																	
																	$.ajax({
																		type: 'POST',
																		dataType: 'json',
																		url:'".FL_JSON_GN.__t('bitly', true)."',
																		data: $('#{$__id_fm}').serialize(),
																		beforeSend: function() {
																			$('#{$__id_fm}_ld').fadeIn();
																			$('#{$__id_fm}_flds').fadeOut(); 
																		},
																		success: function(d) {
																		    
																		    $('#{$__id_fm}_ld').fadeOut();
																		    
																		    if(d.e == 'ok'){
																				$('#UrlS_$__id_r h2').html( d.url_s );
																				$('#UrlS_$__id_r').fadeIn();
																		    }else{
																			    $('#{$__id_fm}_flds').fadeIn();
																			    swal('¡Error!', d.m, 'error');
																		    }
																		    
																		}
																	});
								
																}
															}); 

															
												";
											?>       		
										
										
									</div> 	 
								
						</form> 
							
              
            <?php $CntWb .= ""; ?>             
    </div>
</div>
