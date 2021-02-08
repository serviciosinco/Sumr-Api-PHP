<?php 
	  	$_id_tbpnl = 'TabPnl_'.Gn_Rnd(20); 
		$CntWb .= " SUMR_Main.bxajx.".$_id_tbpnl." = new Spry.Widget.TabbedPanels('".$_id_tbpnl."'); "; 
		
	    $__idtp_bsc = '_cmpg_bsc';
		//$__idtp_up = '_cmpg_up';
		$__idtp_snd = '_ec_snd';
		$__idtp_eml = '_cmpg_lsts';
		$__idtp_sgm = '_cmpg_sgm';
		
		
		//$__cmpg_dt = GtEcCmpgDt([ 'id'=>$___Ls->dt->rw['id_eccmpg'], 'q_tot'=>'ok', 'q_btch'=>'ok' ]);

		
 ?>
  <div id="<?php echo $_id_tbpnl ?>" class="VTabbedPanels SndIn mny __snd_ec_cmpg_detail ">
        <ul class="TabbedPanelsTabGroup">
            <li class="TabbedPanelsTab" id="<?php echo TBGRP.$__idtp_bsc ?>"><?php echo Spn('','','_tt_icn _tt_icn_lsts').TX_DTSBSC ?></li>
            
            <li class="TabbedPanelsTab <?php if($___Ls->dt->tot == 0){ ?>_hd<?php } ?>" id="<?php echo TBGRP.$__idtp_snd ?>"><?php echo Spn('','','_tt_icn _tt_icn_cmpg').'Correos' ?></li>
            <li class="TabbedPanelsTab <?php if($___Ls->dt->tot == 0){ ?>_hd<?php } ?>" id="<?php echo TBGRP.$__idtp_eml ?>"><?php echo Spn('','','_tt_icn _tt_icn_lsts').'Listas' ?></li>
            <li class="TabbedPanelsTab <?php if($___Ls->dt->tot == 0){ ?>_hd<?php } ?>" id="<?php echo TBGRP.$__idtp_sgm ?>"><?php echo Spn('','','_tt_icn _tt_icn_lsts_sgm').'Segmentos' ?></li>
            <!--<?php if($___Ls->dt->rw['eccmpg_est'] != 1){ ?>
            	<li class="TabbedPanelsTab <?php if($___Ls->dt->tot == 0){ ?>_hd<?php } ?>" id="<?php echo TBGRP.$__idtp_up ?>"><?php echo Spn('','','_tt_icn _tt_icn_up').TX_UPLMSV ?></li>
            <?php } ?>-->
            
        </ul>
        <div class="TabbedPanelsContentGroup">
                <div class="TabbedPanelsContent">
                	
                	
                    	
                	<?php if($___Ls->dt->tot > 0){ ?>
                	<div class="col_1 ">
                    	<?php include(DIR_EXT.'_cmpg_2.php'); ?>	
                	</div>
                	<?php } ?>
                	

                	<div class="<?php if($___Ls->dt->tot > 0){ ?>col_2<?php } ?>">
                    	
                    	<ul>
							
							<li>
								<span class="_icn _ok"></span>
								<h2>
									Destinatarios
									<p>
										Se enviará el correo a  &nbsp;<strong id="snd_to_tot<?php echo $___Ls->id_rnd; ?>"></strong>&nbsp; personas
										<div class="end_show_lsts" id="snd_to_lsts<?php echo $___Ls->id_rnd; ?>"></div>
										<div class="end_show_sgm" id="snd_to_sgm<?php echo $___Ls->id_rnd; ?>"></div>
									</p>
								</h2>	
							</li>
							
							
							<?php if($__msj_up == ''){ ?>
							<li>
								<span class="_icn _ok"></span>
								<h2>
									Mensaje </br><p>con el asunto&nbsp;<span id="rsmn_sbj"><?php echo ctjTx($___Ls->dt->rw['eccmpg_sbj'],'in') ?></span> </p>
								</h2>	
							</li>
							<?php } ?>
							
							<li>
								<span class="_icn _ok"></span>
								<h2>
									Fecha y hora </br><p>el dia&nbsp;<span id="rsmn_dte"><?php echo ctjTx($___Ls->dt->rw['eccmpg_p_f'],'in') ?></span>&nbsp;a las &nbsp;<span id="rsmn_hra"><?php echo ctjTx($___Ls->dt->rw['eccmpg_p_h'],'in') ?></span></p>
								</h2>	
							</li>
								
							<li style="display: none;" id="li_run_code_<?php echo $___Ls->id_rnd; ?>" >
							
								<span class="_icn _ok"></span>
								<h2>Prueba
									<button class="run_code" id="run_code_<?php echo $___Ls->id_rnd; ?>">Enviar</button>
									
									<?php 
										
										$CntWb .= "
											
											$('#run_code_".$___Ls->id_rnd."').off('click').click(function(e){
												
												e.preventDefault();
												
												if(e.target != this){
													
											    	e.stopPropagation(); return;
											    	
												}else{
													
													var _cmpg = $('#eccmpg_nwid').val();
													
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
									
								</h2>	
							</li>

							<?php 
																
								//echo $___Ls->fm->btn->sve; 
								echo $___Ls->_h_fm_mmfm(); 
								
							?> 

						</ul>
						
						
						<button id="lets_go_<?php echo $___Ls->id_rnd; ?>" class="lets_go">
							<?php
								if(_ChckMd('snd_noaprb')){
									echo 'Finalizar';
								}else{
									echo 'Solicitar Aprobación';
								}
							?>
						</button>
						
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
                            <?php echo bdiv(['id'=>DV_LSFL.$__idtp_eml, 'cls'=>'_sbls']) ?>
                        </div> 
                    <!-- Finaliza Carga -->      
                </div>
                
                <div class="TabbedPanelsContent">
                    <!-- Inicia Carga -->
                        <div class="ln">
                            <?php echo bdiv(['id'=>DV_LSFL.$__idtp_sgm, 'cls'=>'_sbls']) ?>
                        </div> 
                    <!-- Finaliza Carga -->      
                </div>
                
             
                
                <!--<div class="TabbedPanelsContent">
                                <div class="ln">
                                    <?php echo bdiv(array('id'=>DV_LSFL.$__idtp_up, 'cls'=>'_sbls')) ?>
                                </div>      
                </div>-->
                    
                    
                     
                                                         
          </div>
          <?php       
					$CntJV .= _DvLsFl_Vr(['i'=>$___Ls->dt->rw[$__id], 'n'=>$__idtp_eml, 't'=>'ec_cmpg_lsts']);
					$CntJV .= _DvLsFl_Vr(['i'=>$___Ls->dt->rw[$__id], 'n'=>$__idtp_sgm, 't'=>'ec_cmpg_sgm']);
					//$CntJV .= _DvLsFl_Vr(array('i'=>$___Ls->dt->rw[$__id], 'n'=>$__idtp_up, 't'=>'ec_cmpg_up'));
					$CntJV .= _DvLsFl_Vr(['i'=>$___Ls->dt->rw[$__id], 'n'=>$__idtp_snd, 't'=>'ec_snd']);	
					
					$CntWb .= _DvLsFl(['i'=>$__idtp_eml]);	
					$CntWb .= _DvLsFl(['i'=>$__idtp_sgm]);			    		  
					//$CntWb .= _DvLsFl(array('i'=>$__idtp_up));
					$CntWb .= _DvLsFl(['i'=>$__idtp_snd]);	  
			?>               
    </div>
<style>
	
	.__snd_ec_cmpg_detail.VTabbedPanels.mny > ul.TabbedPanelsTabGroup{ background-color: white; width: 6%; display: none; }
    .__snd_ec_cmpg_detail.VTabbedPanels.mny > div.TabbedPanelsContentGroup{ border: none; width: 100%; }
    .__snd_ec_cmpg_detail.VTabbedPanels.mny > div.TabbedPanelsContentGroup .TabbedPanelsContent{ padding-top: 30px; }
    
    
    .__snd_ec_cmpg_detail.VTabbedPanels .TabbedPanelsTab{ background-size: 60% auto; background-position: center center; min-height: 40px; min-width: 40px; max-width: 40px; background-repeat: no-repeat; opacity: 0.3; } 
    .__snd_ec_cmpg_detail.VTabbedPanels .TabbedPanelsTabSelected,
    .__snd_ec_cmpg_detail.VTabbedPanels .TabbedPanelsTabHover{ opacity: 1; background-color: white !important; }
	
	

	
	
	
</style>	
	