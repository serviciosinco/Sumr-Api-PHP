<?php 
	$_i = Php_Ls_Cln($_GET['_i']);
	$__id_fm = 'FmEnc'.Gn_Rnd(20);
?>
<div class="_fm_fnc"> 
        <div class="wrp">  
              
						<div class="_img _hdr_dwn" id="__url_end"></div>
							
							
						<div id="<?php echo $__id_fm ?>_ld" class="_ld" style="display:none;"></div>		
              			<div id="<?php echo $__id_fm ?>_flds">

                      
                        <form action="" method="POST" <?php if($_GET['Sv'] != 'ok'){ ?>name="<?php echo $__id_fm ?>" id="<?php echo $__id_fm ?>" <?php }else{ ?> target="_blank" <?php } ?> >

									<input name="MM_download" id="MM_download" type="hidden" value="MdlCnt" />
									<?php echo HTML_inp_hd('_tp', $___Ls->mdlstp->tp); ?>   
									
					                <div id="<?php echo $__id_fm ?>_flds">        
											 
											<div class="_c3">  
												<div class="_d1">
													
												</div>	
									            <div class="_d2">
									            </div>
									            <div class="_d3">
										            
									            </div>
                                            </div>
											<div class="_c3">  
												<div class="_d1">        
													<?php if($__f_tp == 'm'){ $__dt_tp = 'mthyr'; $__dt_fr = 'yy-mm'; } ?>  
												</div>	
									            <div class="_d2"><?php echo SlDt([ 'id'=>'_f_in', 'rq'=>'no', 't'=>$__dt_tp, 'ph'=>TX_ORD_FIN, 'lmt'=>'no' ]); ?></div>
												<div class="_d3"><?php echo SlDt([ 'id'=>'_f_out', 'rq'=>'no', 't'=>$__dt_tp, 'ph'=>TX_ORD_FOU, 'lmt'=>'no' ]); ?></div>
                                            </div>
                                            
                                            <?php echo OLD_HTML_chck('_eml_snd', TX_SNDML,'', 'in');  ?>
                                            
											<ul>	
												<li class="_snd_fnc"><input type="button" class="btn" id="Sve_Dwn" value="<?php echo TX_DWNL ?>" /></li>		           	   
											</ul>
                                        
											<?php 	
												
												$CntWb .= "	


															
																			
															$('#Sve_Dwn').click(function() {
																if( $('#{$__id_fm}').valid() ){
																	
																	SUMR_Main.ld_abrt({ p:'enc' });
						
																	SUMR_Main.ibx['enc'] =$.ajax({
																						type: 'POST',
																						dataType: 'json',
																						url:'".FL_JSON_GN.__t('enc_cnt_dwn', true)."',
																						data: $('#{$__id_fm}').serialize(),
																						beforeSend: function() {
																							$('#{$__id_fm}_ld').fadeIn();
																							$('#{$__id_fm}_flds').fadeOut(); 
																						},
																						success: function(d) {
																						    
																						    $('#{$__id_fm}_ld').fadeOut();
																						    
																						    if(d.e == 'ok'){
																								__ShwDwn();
																								$.colorbox.close();	
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
								
						</form> 
							
              
            <?php $CntWb .= ""; ?>             
    </div>
</div>
