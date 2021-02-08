<div id="<?php echo $___Ls->fm->bx->id ?>" class="<?php echo DV_GNR_FM_BX; if($___Ls->dt->tot != 1){ echo ' _EcNew'; } ?>" >

   		<?php $__idtp_ecctc = '_ctc'; ?>

		 

    	<form method="POST" name="<?php echo $___Ls->fm->id; ?>" target="_self" id="<?php echo $___Ls->fm->id; ?>" >
		<?php $___Ls->_bld_f_hdr(); ?>

	      
		<div id="<?php echo $___Ls->fm->fld->id ?>" class="<?php echo DV_GNR_FM_CMP ?>">
      
        <div class="ln_1 _anm" id="dv_col">
          
          <div class="col_1 _anm" style="position: relative; ">
	          	
          	<a href="<?php echo Void(); ?>" id="cmp_col" class="__cmpc"></a>
            <?php 
	            
	             $CntWb .= "
	             		$('#cmp_col').click(function() {
		             		if( $('#dv_col').hasClass('_mny') ){
			             		$('#dv_col').removeClass('_mny');
		             		}else{
			             		$('#dv_col').addClass('_mny');
		             		} 
						});
	             ";
	            
            ?>
            <div class="ln_1 _anm">
	            <?php 
		            if(!isN($___Ls->dt->rw['ec_key'])){ 
		            	$__key = HTML_BR.Spn( "_CId('".strtoupper( 'EC_'.str_replace('_','',$___Ls->dt->rw['ec_key']) ."');" ), '', '_key'); 
		            } 
		        ?>
	            <?php if($___Ls->dt->tot == 1){ echo bdiv(['c'=>$___Ls->dt->rw['ec_shr'].$__key, 'cls'=>'pml']); } ?>
            	<?php if($___Ls->dt->tot == 1){ ?><iframe id="__html_ec" width="100%" height="1200" frameborder="0"></iframe> <?php } ?>
            	
            	<style>
	            	
	            	#__html_ec:not(.__rdy){
		            	background-image: url(<?php echo _iEtg(DMN_IMG_ESTR_SVG.'loader_black.svg') ?>); background-repeat: no-repeat; background-position: center top 50px ;
	            	}
	            	
	            	.FmTb .pml ._key{ color: #9ca7aa; font-family: Economica; font-size: 13px; }
	            	
            	</style>	
            </div>
            <?php 
                
                $CntWb .= "
                
					function __ifr_ec(_i, _p){
					
						var __js_ls = '".Fl_Rnd(FL_JSON_GN.__t('ec',true))."&__ec_i='+_i+'&Rd='+Math.random();
					  	
					  	$.ajax({
							url: __js_ls,
							dataType: 'json',
				            cache: false,
				            success: function(d) {
					          
					          	var __if_url = '".DMN_EC.LNK_HTML."/'+d.enc+'/?_mdlC='+_p+'&__l=ok&__edit=ok&Rnd='+Math.random();  
					          
					          	var __if_box = $('#__html_ec');
					          
					          	__if_box.on('load',function() {  
									
									$('#__html_ec').addClass('__rdy');
									
									var iframe = $('#__html_ec')[0];

									if ( iframe.innerHTML() ) {
										console.log(ifTitle);
									}
		
							    });
		    
								$('#__html_ec').attr('src', __if_url);
						    }
						});
					}
					
					$('#__html_ec').contents().find('img').click(function(){ 
						console.log('Some'); 
					});					
					
                 ";
                
                if($___Ls->dt->rw['ec_sis'] == 1){ $_vl_d = '1'; }
				if($___Ls->dt->tot > 0){  $CntWb .= "__ifr_ec('".$___Ls->dt->rw['id_ec']."', '".$_vl_d."');"; }
				 
           	?>
          	</div>
          
          	<div class="col_2 _anm">
            <?php //if(ChckSESS_superadm()){ ?>
            	<input id="ec_us" name="ec_us" type="hidden" value="<?php echo SISUS_ID ?>" />
				<input id="ec_pml_UPD" name="ec_pml_UPD" type="hidden" value="<?php echo ctjTx($___Ls->dt->rw['ec_pml'],'in') ?>" />

				
				<?php echo HTML_inp_tx('ec_sbj', TX_MAIL_SBJ, ctjTx($___Ls->dt->rw['ec_sbj'],'in') ); ?>
				<?php echo HTML_inp_tx('ec_prhdr', TX_PRHDR, ctjTx($___Ls->dt->rw['ec_prhdr'],'in') ) . HTML_BR; ?>

				<?php 
		
					$__tabs = [
						['n'=>'ec_chng', 't'=>'ec_chng', 'l'=> 'Cambios']
					];

					$___Ls->_dvlsfl_all($__tabs);

				?>  

                <?php 
					  	$_id_tbpnl = 'TabPnl_'.Gn_Rnd(20); 
						$CntWb .= " SUMR_Main.bxajx.".$_id_tbpnl." = new Spry.Widget.TabbedPanels('".$_id_tbpnl."'); "; 
						
				?>
			<?php //} ?>
			
				  <div id="<?php echo $_id_tbpnl ?>" class="VTabbedPanels mny _bld_ec">
			              <ul class="TabbedPanelsTabGroup">
				              
			                
							<li class="TabbedPanelsTab"><?php echo Spn('','','_tt_icn _tt_icn_bsc').Spn(TX_DTSBSC,'','_tx') ?></li>
							
							<?php if(ChckSESS_superadm()){  ?>
							<li class="TabbedPanelsTab"><?php echo Spn('','','_tt_icn _tt_icn_wrl').Spn(TX_DSC,'','_tx') ?></li> 
							<?php } ?>
							
							<li class="TabbedPanelsTab"><?php echo Spn('','','_tt_icn _tt_icn_cod').Spn(TX_COD,'','_tx') ?></li> 
							
							<li class="TabbedPanelsTab"><?php echo Spn('','','_tt_icn _tt_icn_fac').Spn(TX_HTML,'','_tx') ?></li> 
							
							<?php if(ChckSESS_superadm()){ ?>
							<li class="TabbedPanelsTab"><?php echo Spn('','','_tt_icn _tt_icn_chck').Spn(TX_ATMZCN,'','_tx') ?></li>
							<?php } ?>
							
							<?php if($___Ls->dt->tot > 0){ ?>
							<li class="TabbedPanelsTab"><?php echo Spn('','','_tt_icn _tt_icn_up').Spn(TX_GUP,'','_tx') ?></li>
							<!-- <li class="TabbedPanelsTab"><?php echo Spn('','','_tt_icn _tt_icn_mre').Spn(TX_ESTD,'','_tx') ?></li> --> 
							<?php } ?>
							
							
							
							<?php if(ChckSESS_superadm()){ ?>
							<!-- <li class="TabbedPanelsTab" id="<?php echo TBGRP.$__idtp_ecctc ?>"><?php echo Spn('','','_tt_icn _tt_icn_strt').Spn(TX_CDCMBS,'','_tx') ?></li> -->
							<?php } ?>
							
							<?php if($___Ls->dt->tot == 1){ ?>
							<li class="TabbedPanelsTab"><?php echo Spn('','','_tt_icn _tt_icn_stp').Spn('Tipo','','_tx') ?></li>
							<?php } ?>
							<?php if($___Ls->dt->tot == 1){ ?>
							<li class="TabbedPanelsTab"><?php echo Spn('','','_tt_icn _tt_icn_are').Spn('Area','','_tx') ?></li>
							<?php } ?>
							<?php if(ChckSESS_superadm() || _ChckMd('ec_chng')){ ?>
								<?php echo $___Ls->tab->ec_chng->l ?>
							<?php } ?>
			              </ul>
			              <div class="TabbedPanelsContentGroup">
				              

		                        <div class="TabbedPanelsContent">
									
									<?php  
										
										echo HTML_inp_hd('ec_tp', $___Ls->mdlstp->id);
										echo HTML_inp_tx('ec_tt', TX_TT, ctjTx($___Ls->dt->rw['ec_tt'],'in'), FMRQD, 'onblur="SUMR_Main.pml.input({ tt:\'#ec_tt\', pml:\'#ec_pml\' });"');
										
						                if(ChckSESS_superadm()){ 
							                echo HTML_inp_tx('ec_sbt', TT_FM_SBT, ctjTx($___Ls->dt->rw['ec_sbt'],'in'));  
							            }else{
								            echo HTML_inp_hd('ec_sbt', $___Ls->dt->rw['ec_sbt']!=''?ctjTx($___Ls->dt->rw['ec_sbt'],'in'):'');
							            }
						                
							            echo HTML_inp_tx('ec_pml', TX_PML, ctjTx($___Ls->dt->rw['ec_pml'],'in'), FMRQD, 'onfocus="SUMR_Main.pml.input({ tt:\'ec_tt\', pml:\'ec_pml\' });"');
						               
						                if(ChckSESS_superadm()){ 
							                echo HTML_inp_tx('ec_lnk', TX_URL, ctjTx($___Ls->dt->rw['ec_lnk'],'in'), FMRQD_URL);
											
											if($___Ls->dt->tot > 0){	
												echo HTML_inp_tx('ec_lnk_nxt', TX_URL.' Next', ctjTx($___Ls->dt->rw['ec_lnk_nxt'],'in'), FMRQD_URL);
											}
											
							            }else{
								            echo HTML_inp_hd('ec_lnk', ctjTx($___Ls->dt->rw['ec_lnk'],'in'));
								            echo HTML_inp_hd('ec_lnk_nxt', ctjTx($___Ls->dt->rw['ec_lnk_nxt'],'in'));
							            }
						                
						                if(ChckSESS_superadm()){ 
							                echo HTML_inp_tx('ec_w', TX_WDT, ctjTx($___Ls->dt->rw['ec_w'],'in'), FMRQD_NM);
							            }else{
								            echo HTML_inp_hd('ec_w', $___Ls->dt->rw['ec_w']!=''?$___Ls->dt->rw['ec_w']:'600');
							            }
						                  
						                $l = __Ls(['k'=>'sis_est', 'id'=>'ec_est', 'va'=>$___Ls->dt->rw['ec_est'] , 'ph'=>TX_ETD]); 
						                echo $l->html; $CntWb .= $l->js;
							            
							            
							            if(ChckSESS_superadm()){ 
							                $l = __Ls(['k'=>'sis_pay_est', 'id'=>'ec_pay', 'va'=>$___Ls->dt->rw['ec_pay'] , 'ph'=>TX_PG]); 
							                echo $l->html; $CntWb .= $l->js;  
							            }else{
								            echo HTML_inp_hd('ec_pay', $___Ls->dt->rw['ec_pay']!=''?$___Ls->dt->rw['ec_pay']:187);
							            }

							            
							            $l = __Ls(['k'=>'sis_ec_frm', 'id'=>'ec_frm', 'va'=>$___Ls->dt->rw['ec_frm'] , 'ph'=>TX_FRMT]); 
							            
							            echo $l->html; $CntWb .= $l->js;
							            
							            
						                if($___Ls->dt->tot > 0){
						                	echo HTML_inp_tx('ec_dmo',TX_PLTLLDM, ctjTx($___Ls->dt->rw['ec_dmo'],'in'), '');
						                }
						                
										if(ChckSESS_superadm()){ echo OLD_HTML_chck('ec_oth', TX_MSTROTRS , $___Ls->dt->rw['ec_oth'] ); }  
										
										
										echo OLD_HTML_chck('ec_chk_hdr', 'Mostrar Header' , $___Ls->dt->rw['ec_chk_hdr'] ); 
										echo OLD_HTML_chck('ec_chk_ftr', 'Mostrar Footer' , $___Ls->dt->rw['ec_chk_ftr'] );
										
						                
						                
						                if(isN($___Ls->gt->tmpl) || $___Ls->dt->rw['ec_frm'] == _CId('ID_SISECFRM_SIS')){
						                	echo OLD_HTML_chck('ec_cmz', TX_PRSNLZB , $___Ls->dt->rw['ec_cmz'] ); 
											echo OLD_HTML_chck('ec_flj', TX_FLJ , $___Ls->dt->rw['ec_flj'] ); 
											echo OLD_HTML_chck('ec_pst_fb', TX_TBFB , $___Ls->dt->rw['ec_pst_fb'] ); 
						                }else{    
							                echo HTML_inp_hd('ec_cmz', ($___Ls->gt->tmpl=='cmz'?1:2) );
											echo HTML_inp_hd('ec_flj', ($___Ls->gt->tmpl=='data'?1:2) );
											echo HTML_inp_hd('ec_pst_fb', ($___Ls->gt->tmpl=='cmz'?1:2) );
						                }
						                
						                
						         	?> 	
						         	
		                        </div>
		                        
		                        <?php if(ChckSESS_superadm()){  ?>
			                        <div class="TabbedPanelsContent">
										<?php echo HTML_textarea('ec_dsc', TX_DSC, ctjTx($___Ls->dt->rw['ec_dsc'],'in'), FMRQD, '', '', 30); ?>
			                        </div> 
		                        <?php } ?>
		                        
		                        <div class="TabbedPanelsContent">
		                        	

									<?php echo HTML_textarea('ec_cd', '', ctjTx($___Ls->dt->rw['ec_cd'],'in','', ['html'=>'ok','schr'=>'no','nl2'=>'no','qte'=>'no']), FMRQD, 'ok', '', 30);  ?>
									
								    <?php $__ec_tags = GtSisTagCnctLs(['id'=>'EcTagList']); echo $__ec_tags->html; ?>
		                            <?php $CntWb .= " SUMR_Main.ld.f.html(function(){ SUMR_Ec.f.tags({ id:'#EcTagList li' }); }); "; ?>
									         
		                        </div>
		                        <div class="TabbedPanelsContent">
									<?php 
						                
						                if(ChckSESS_superadm()){ 
							                echo HTML_inp_tx('ec_em', TX_EML, ctjTx($___Ls->dt->rw['ec_em'],'in')); 
							            }else{
								            echo HTML_inp_hd('ec_em', ctjTx($___Ls->dt->rw['ec_em'],'in'));
							            }

							            if(ChckSESS_superadm() && $___Ls->dt->tot > 0){ 
							                echo HTML_inp_tx('ec_fnd', TX_FND, ctjTx($___Ls->dt->rw['ec_fnd'],'in') ); 
							            }else{
								            echo HTML_inp_hd('ec_fnd', $___Ls->dt->rw['ec_fnd']!=''?ctjTx($___Ls->dt->rw['ec_fnd'],'in'):'fff' );
							            }     
						                
						                if(ChckSESS_superadm() && $___Ls->dt->tot > 0){ 
							                echo HTML_inp_tx('ec_spn', TX_SPN, ctjTx($___Ls->dt->rw['ec_spn'],'in'));
							            }else{
								            echo HTML_inp_hd('ec_spn', $___Ls->dt->rw['ec_spn']!=''?ctjTx($___Ls->dt->rw['ec_spn'],'in'):'' );
							            }  
						                
						                if(ChckSESS_superadm()){ 
							                echo HTML_inp_tx('ec_nmr', TX_NMR, ctjTx($___Ls->dt->rw['ec_nmr'],'in'));
							            }else{
								            echo HTML_inp_hd('ec_nmr', $___Ls->dt->rw['ec_nmr']!=''?ctjTx($___Ls->dt->rw['ec_nmr'],'in'):'' );
							            } 
							            
							            if(ChckSESS_superadm()){ 
							                echo HTML_inp_tx('ec_ord', TX_ORD, ctjTx($___Ls->dt->rw['ec_ord'],'in'));
							            }else{
								            echo HTML_inp_hd('ec_ord', $___Ls->dt->rw['ec_ord']!=''?ctjTx($___Ls->dt->rw['ec_ord'],'in'):'' );
							            }
						                
						                
						                if(ChckSESS_superadm()){ 
							                echo LsSis_SiNo('ec_pdf', 'id_sissino', $___Ls->dt->rw['ec_pdf'], FM_LS_PDF); $CntWb .= JQ_Ls('ec_pdf',FM_LS_PDF); 
							            }else{
								            echo HTML_inp_hd('ec_pdf', $___Ls->dt->rw['ec_pdf']!=''?$___Ls->dt->rw['ec_pdf']:2 );
							            }
						               
										if(ChckSESS_superadm()){ 
							                //echo LsSisFm('ec_fm', 'id_sisfm', $___Ls->dt->rw['ec_fm'], '', 2, 'ok'); $CntWb .= JQ_Ls('ec_fm',FM_LS_CMP);
							                echo HTML_inp_hd('ec_fm', $___Ls->dt->rw['ec_fm']!=''?$___Ls->dt->rw['ec_fm']:'' );
							            }else{
								            echo HTML_inp_hd('ec_fm', $___Ls->dt->rw['ec_fm']!=''?$___Ls->dt->rw['ec_fm']:'' );
							            }
							            
										
						                echo HTML_inp_tx('ec_frw', TX_FRW, ctjTx($___Ls->dt->rw['ec_frw'],'in'));
						                echo HTML_inp_tx('ec_key', TX_KEY, ctjTx($___Ls->dt->rw['ec_key'],'in'));
						                
						                
						        	?>
		                                 
		                        </div> 
		                        
		                        <?php if(ChckSESS_superadm()){ ?>
		                        <div class="TabbedPanelsContent">
									<?php 
						                
						                echo OLD_HTML_chck('ec_act_frm', TX_FRMA, $___Ls->dt->rw['ec_act_frm'] );
						                
						                echo h2(MDL_SIS);
						                echo LsSis_SiNo('ec_sis', 'id_sissino', $___Ls->dt->rw['ec_sis'], FM_LS_ECSIS); $CntWb .= JQ_Ls('ec_sis', FM_LS_ECSIS);
						        	?>
		                        </div> 
		                        <?php } ?>
		                        
		                        <?php if($___Ls->dt->tot > 0){ ?>
		                        <div class="TabbedPanelsContent">
									<div id="_upl_fle"></div>
									
					                <?php $CntWb .= "_ldCnt({ u:'".Fl_Rnd(FL_FM_GN.__t('up_ec',true)).Fl_i($___Ls->dt->rw[$___Ls->ik])."', c:'_upl_fle' });"; ?>
					                
					            	
		                        </div>   
		                        
		                        
		                        <!-- <div class="TabbedPanelsContent">
									<?php //$_ls_lnk = GtEcLnkLs(array('i'=>$___Ls->dt->rw['id_ec'])); echo $_ls_lnk->html; ?>
		                        </div> -->
		                        
		                        <?php } ?>
		                        
		                        <?php if(ChckSESS_superadm()){  ?>
		                        <!-- <div class="TabbedPanelsContent">

                                    <div class="ln">
                                        <?php echo bdiv(['id'=>DV_LSFL.$__idtp_ecctc]) ?>
                                    </div> 

                    			</div> --> 
                    			<?php } ?> 
                    			<?php if($___Ls->dt->tot == 1){  ?>
		                        <div class="TabbedPanelsContent">

                                    <div class="ln">
                                        <?php include('ec_tp.php'); ?>
                                    </div> 

                    			</div> 
                    			<?php } ?>  
                    			<?php if($___Ls->dt->tot == 1){  ?>
		                        <div class="TabbedPanelsContent">

                                    <div class="ln">
                                        <?php include('ec_are.php'); ?>
                                    </div> 

                    			</div> 
                    			<?php } ?> 
								<?php if(ChckSESS_superadm() || _ChckMd('ec_chng')){ ?>
									<div class="TabbedPanelsContent">
										<div class="ln">
											<?php echo $___Ls->tab->ec_chng->d ?>
										</div> 
									</div>
								<?php } ?>
			                                                                
			              	</div>
						  	<?php       
								
								$___Ls->_dvlsfl_all([
									['n'=>$__idtp_ecctc,'t'=>'ec_ctc']				
								]);
										  
							?> 
            
			        </div>
                
                
                <style>
	                
	                ._EcNew{}   
	                ._EcNew .col_1{ display: none; }
	                ._EcNew .col_2{ width: 100% !important; }
	                
                </style>
            
          </div>

        </div>
      </div>
    </form>
</div>
<style>
	.TabbedPanelsTab._ec_chng{background-image: url(https://img.sumrdev.com/estr/svg/wrl_dscr.svg);}
</style>