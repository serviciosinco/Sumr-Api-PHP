<?php 
	  	$_id_tbpnl = 'TabPnl_'.Gn_Rnd(20); 
		$CntWb .= " SUMR_Main.bxajx.".$_id_tbpnl." = new Spry.Widget.TabbedPanels('".$_id_tbpnl."'); "; 
		
	    $__idtp_bsc = '_cmpg_bsc';
		$__idtp_up = '_cmpg_up';
		$__idtp_snd = '_sms_snd';
		
		$__cmpg_dt = GtSmsCmpgDt(['id'=>$___Ls->dt->rw['id_smscmpg']]);
 ?>
  <div id="<?php echo $_id_tbpnl ?>" class="VTabbedPanels SndIn">
          <ul class="TabbedPanelsTabGroup">
            <li class="TabbedPanelsTab" id="<?php echo TBGRP.$__idtp_bsc ?>"><?php echo Spn('','','_tt_icn _tt_icn_lsts').TX_DTSBSC ?></li>
            
            <li class="TabbedPanelsTab <?php if($___Ls->dt->tot == 0){ ?>_hd<?php } ?>" id="<?php echo TBGRP.$__idtp_snd ?>"><?php echo Spn('','','_tt_icn _tt_icn_sms_tmpl').TX_ENV ?></li>
            <?php if($___Ls->dt->rw['smscmpg_est'] != 1 || _ChckMd('sms_cmpg_up') ){ ?>
            	<li class="TabbedPanelsTab <?php if($___Ls->dt->tot == 0){ ?>_hd<?php } ?>" id="<?php echo TBGRP.$__idtp_up ?>"><?php echo Spn('','','_tt_icn _tt_icn_up').TX_UPLMSV ?></li>
            <?php } ?>
          </ul>
          <div class="TabbedPanelsContentGroup">
                    <div class="TabbedPanelsContent">
                    	
                    	<div class="ln_1">
                        	<div class="col_1">
	                        	<?php include(DIR_EXT.'_cmpg_2.php'); ?>	
                        	</div>
                        	<div class="col_2">
	                        	<ul>
									<li>
										<span class="_icn <?php if($___Ls->dt->rw['__tot_lds'] > 0){ echo '_ok'; }else{ echo '_no'; } ?>"></span>
										<?php
											
										?>
										<h2>
											<?php echo TX_DSTNT ?>
											<p>

												<?php 
													
													if($___Ls->dt->rw['__tot_lds'] > 0){
														
														echo TX_ENVMSNA .$___Ls->dt->rw['__tot_lds']. TX_NMSTALTCNTIN;
														
														if($__cmpg_dt->ls->snd->tot > 0){
															foreach($__cmpg_dt->ls->snd->ls as $_k => $_v){
																
																if($_v->msj != NULL){ $_t_msj = $_v->msj; }else{ $_t_msj = ctjTx($___Ls->dt->rw['smscmpg_msj'],'in'); }
																
																$__li_tst .= li(Spn( 
																					Spn('','','_tt_icn _tt_icn_sms_tmpl') 
																				,'','_icn _cel').
																					Strn($_v->cel.HTML_BR.
																						 Spn($_t_msj,'','_msj') 
																						)
																				);
																$__msj_up = $_v->msj;				
															}
															echo ul($__li_tst);
														}
														
													}else{
															
															echo TX_NAGRMT;
														
													}
													
												?>
											</p>
										</h2>	
									</li>
									
									<?php //if($__msj_up == ''){ ?>
									<li>
										<span class="_icn _ok"></span>
										<h2>
											<?php echo TX_MSJ ?>
											<p><?php echo TX_CNMSN ?> <?php echo ctjTx($___Ls->dt->rw['smscmpg_msj'],'in') ?></p>
										</h2>
										
									</li>
									<?php //} ?>
									
									<li>
										<span class="_icn _ok"></span>
										<h2>
											<?php echo TX_FYH ?>
											<p><?php echo TX_ELDIA ?> <?php echo ctjTx($___Ls->dt->rw['smscmpg_p_f'],'in') ?> a las <?php echo ctjTx($___Ls->dt->rw['smscmpg_p_h'],'in') ?></p>
										</h2>	
									</li>
									
									<?php if($___Ls->dt->rw['cmpg_ctg'] != NULL){  ?>
									<li>
										<span class="_icn _ok"></span>
										<h2>
											<?php echo TX_CTGR ?>
											<?php if($___Ls->dt->rw['cmpg_ctg'] != NULL){ ?>
												<p><?php echo ctjTx($___Ls->dt->rw['cmpg_ctg'],'in') ?></p>
											<?php }else{ ?>
												<p>-NA-</p>
											<?php } ?>
										</h2>	
									</li>
									<?php } ?>
									
									<?php if($___Ls->dt->rw['__tot_lds'] > 0){ ?>
									<li>
										<span class="_icn <?php if($__cmpg_dt->rpt->tot > 0){ echo '_no'; }else{ echo '_ok'; } ?>"></span>
										<h2>
											<?php echo TX_DPLC ?>
											<p>
												<?php 
													
													if($__cmpg_dt->rpt->tot > 0){ 
														echo TX_SENCTR .Strn($__cmpg_dt->rpt->tot). TX_DPLC; 
													}else{
														echo Strn('No').  TX_EXDPLC; 
													}  
												?> 
											</p>
										</h2>	
									</li>
									<?php } ?>
									
									<?php if($___Ls->dt->rw['smscmpg_est'] != 1 && $__cmpg_dt->rpt->tot == 0 && $___Ls->dt->rw['__tot_lds'] > 0 ){ ?>
									<li>
										<span class="_icn _wh">
											<span class="_tt_icn _tt_icn_sms_cmpg"></span>
										</span>
										<h2>
											<?php 
												if($___Ls->dt->rw['smscmpg_est'] == 2){ $__chk_est = 1; }else{ $__chk_est = 2; }
												echo OLD_HTML_chck('smscmpg_est_c', '', $__chk_est, 'in'); 
												
												
												
												$CntWb .= " 
												
												$('#smscmpg_est_c').change(function() {
													
													if(this.checked){
														var __e = 2;
														var __m = '".TX_CMPCL."';
													}else{
														var __e = 4;
														var __m = '".TX_CMPPASD."';
													}									
													
													__snd_upd({
														id:'".$___Ls->dt->rw['id_smscmpg']."', 
														e:__e, 
														c:function(d){	
															if(d.e == 'ok'){																																								swal('".TX_MBN."', __m, 'success');
															}
														}
													});
												
												});"
												
													
											?>
										</h2>	
									</li>
									<?php } ?>
									
								</ul>
								
										
                        	</div> 
                    	</div>	

                    </div>
                    
                    <div class="TabbedPanelsContent">
                             <!-- Inicia Carga -->
                                    <div class="ln">
                                        <?php echo bdiv(['id'=>DV_LSFL.$__idtp_snd, 'cls'=>'_sbls']) ?>
                                    </div> 
                             <!-- Finaliza Carga -->      
                    </div>
                    
                    <div class="TabbedPanelsContent">
                             <!-- Inicia Carga -->
                                    <div class="ln">
                                        <?php echo bdiv(['id'=>DV_LSFL.$__idtp_up, 'cls'=>'_sbls']) ?>
                                    </div> 
                             <!-- Finaliza Carga -->      
                    </div>
                     
                                                         
          </div>
          <?php      
	          
	            $___Ls->_dvlsfl_all([
					['n'=>$__idtp_up, 't'=>'sms_cmpg_up'],
					['n'=>$__idtp_snd, 't'=>'sms_snd']
				]);
	 	  
			?>               
    </div>
