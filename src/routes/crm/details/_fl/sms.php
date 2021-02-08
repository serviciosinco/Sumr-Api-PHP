<?php 
if(class_exists('CRM_Cnx')){
?>
<style>
._tt_icn{ background-position: center;background-repeat: no-repeat; }
._tt_icn_bsc{ background-image: url('<?php echo DMN_IMG_ESTR_SVG ?>snd_inicio.svg');background-size: 22px;background-position: 0 -1 ; }
._tt_icn_cmpg{ background-image: url('<?php echo DMN_IMG_ESTR_SVG ?>snd_campanas.svg');background-size: 26px; }
._tt_icn_tmpl{ background-image: url('<?php echo DMN_IMG_ESTR_SVG ?>snd_templates.svg');background-size: 26px; }
._tt_icn_lsts{ background-image: url('<?php echo DMN_IMG_ESTR_SVG ?>snd_listas.svg');background-size: 28px;background-position: -2px 2px ; }
</style>
<div class="Cvr_Sms">
	<section class="_cvr" style="background-color:#9879aa;">
        <iframe src="<?php echo DMN_ANM; ?>sms/index.html" frameborder="0" width="100%" scrolling="no" height="200"></iframe>
    </section>
    <div class="_ln">
    		
            
            <?php
	            $_id_tbpnl = 'TabPnl_'.Gn_Rnd(20); $CntJV .= " SUMR_Main.bxajx.".$_id_tbpnl." = new Spry.Widget.TabbedPanels('".$_id_tbpnl."', {defaultTab:0}); ";
	       		
	       		/*$__idtp_test = '_test';
	       		$__idtp_cmpg = '_cmpg';	
	       		$__idtp_tmpl = '_tmpl';	
	       		$__idtp_lsts = '_lsts';	
	       		$__idtp_sgus = '_sgus';*/	
			?>
			        <?php
						$___Dt->_dvlsfl_all([
							['n'=>'bsc', 'l'=>TX_INIC],
							['n'=> 'cmpg','t'=>'sms_cmpg', 'l'=>TX_CMPNS],
							['n'=> 'tmpl','t'=>'sms_tmpl', 'l'=>TX_TMPL],
							['n'=> 'lsts','t'=>'sms_lsts', 'l'=>TX_LS],
							['n'=> 'sgus','t'=>'sms_sgus', 'l'=>'Tracking']					
						],[
							'hd'=>'no',
							'sng'=>'ok',
							'icn_sty'=>'bsc',
						]);

					?>	
		
            <div id="<?php echo $_id_tbpnl ?>" class="VTabbedPanels TbSnd">
                  <ul class="TabbedPanelsTabGroup">
	                  	
	                  	<?php echo $___Dt->tab->bsc->l ?>
	                  	<?php echo $___Dt->tab->cmpg->l ?>
					  	<?php echo $___Dt->tab->tmpl->l ?>
					  	<?php echo $___Dt->tab->lsts->l ?>
					  	<?php //echo $___Dt->tab->sgus->l ?>
                       
                  <!--li< class="TabbedPanelsTab" id="TbGrp1"><?php echo Spn('','','_tt_icn _tt_icn_mdl').Spn(TX_INIC,'','_tx') ?></li>
                        <li class="TabbedPanelsTab" id="<?php echo TBGRP.$__idtp_cmpg ?>" ><?php echo Spn('','','_tt_icn _tt_icn_sms_cmpg').Spn(TX_CMPNS,'','_tx') ?></li>
                        <li class="TabbedPanelsTab" id="<?php echo TBGRP.$__idtp_tmpl ?>" ><?php echo Spn('','','_tt_icn _tt_icn_sms_tmpl').Spn(TX_TMPL,'','_tx') ?></li>
                        <li class="TabbedPanelsTab" id="<?php echo TBGRP.$__idtp_lsts ?>" ><?php echo Spn('','','_tt_icn _tt_icn_sms_lsts').Spn(TX_LS,'','_tx') ?></li>
                        <li class="TabbedPanelsTab" id="<?php echo TBGRP.$__idtp_sgus ?>" ><?php echo Spn('','','_tt_icn _tt_icn_sms_anly').Spn(Tracing,'','_tx') ?></li>-->
                        
                        
                  </ul>
                  <div class="TabbedPanelsContentGroup">
                        <div class="TabbedPanelsContent">
	                        
	                        <div class="_mn">
		                        
		                        <div class="_c _c_test"><?php echo Spn().h2(TX_RLZ.Strn(TX_PRB)); ?></div>
		                        <div class="_c _c_cmpg"><?php echo Spn().h2(TX_NV.' '.Strn(TX_CMPNS)); ?></div>
		                        <div class="_c _c_tmpl"><?php echo Spn().h2(TX_NV.' '.Strn(TX_TMPL)); ?></div>
		                        <div class="_c _c_lsts"><?php echo Spn().h2(TX_ADM.Strn(TX_LS)); ?></div>
		                        <div class="_c _c_sgus"><?php echo Spn().h2(TT_BTNVW.Strn(TX_INFRM)); ?></div>
		                        
                                   
                                
                                <?php 
	                                
	                                $CntWb .= "
	                                		
	                                		$('._c_test').click(function(){ 
	                                			".JQ__ldCnt([ 'u'=>FL_FM_GN.__t('sms_test',true).TXGN_ING, 'c'=>DV_LSFL.$__idtp_cmpg, 'p'=>'ok', 'w'=>'700', 'h'=>'650' ])."
	                                		});
	                                		
	                                		
	                                		$('._c_cmpg').click(function(){ 
		                                		SUMR_Main.ls.btn({i:'TbGrp1', i2:'".TBGRP.$__idtp_cmpg."', t:'".strtoupper('snd')."', tb:'{$_id_tbpnl}', opn:true });
		                                		SUMR_Main.bxajx.".$_id_tbpnl.".showPanel(1);
	                                			".JQ__ldCnt([ 'u'=>FL_LS_GN.__t('sms_cmpg',true).TXGN_ING, 'c'=>DV_LSFL.$__idtp_cmpg ])."
	                                		});
	                                		
	                                		
	                                		$('._c_tmpl').click(function(){ 
		                                		SUMR_Main.ls.btn({i:'TbGrp1', i2:'".TBGRP.$__idtp_tmpl."', t:'".strtoupper('snd')."', tb:'{$_id_tbpnl}', opn:true });
		                                		SUMR_Main.bxajx.".$_id_tbpnl.".showPanel(2);
	                                			".JQ__ldCnt([ 'u'=>FL_LS_GN.__t('sms_tmpl',true).TXGN_ING, 'c'=>DV_LSFL.$__idtp_tmpl ])."
	                                		});
	                                		
	                                		
	                                		$('._c_lsts').click(function(){ 
		                                		SUMR_Main.ls.btn({i:'TbGrp1', i2:'".TBGRP.$__idtp_lsts."', t:'".strtoupper('snd')."', tb:'{$_id_tbpnl}', opn:true });
		                                		SUMR_Main.bxajx.".$_id_tbpnl.".showPanel(3);
	                                			".JQ__ldCnt([ 'u'=>FL_LS_GN.__t('sms_lsts',true), 'c'=>DV_LSFL.$__idtp_lsts ])."
	                                		});
	                                		
	                                		
	                                		$('._c_sgus').click(function(){ 
		                                		SUMR_Main.ls.btn({i:'TbGrp1', i2:'".TBGRP.$__idtp_sgus."', t:'".strtoupper('snd')."', tb:'{$_id_tbpnl}', opn:true });
		                                		SUMR_Main.bxajx.".$_id_tbpnl.".showPanel(4);
	                                			".JQ__ldCnt([ 'u'=>FL_LS_GN.__t('sms_sgus',true), 'c'=>DV_LSFL.$__idtp_sgus ])."
	                                		});
	                                		
	                                ";
	                                
                                ?>
                                    
	                        </div>
	                        
                        </div>
                        <div class="TabbedPanelsContent">
	                        <!-- Inicia Campañas -->
                                <div class="ln">
                                    <!--<?php echo bdiv(array('id'=>DV_LSFL.$__idtp_cmpg, 'cls'=>'_sbls' )) ?>-->
                                    <?php echo $___Dt->tab->cmpg->d ?>
                                </div> 
                            <!-- Finaliza Campañas -->
                        </div>
                        <div class="TabbedPanelsContent">
	                        <!-- Inicia Templates -->
                                <div class="ln">
                                    <!--<?php echo bdiv(array('id'=>DV_LSFL.$__idtp_tmpl, 'cls'=>'_sbls' )) ?>-->
                                    <?php echo $___Dt->tab->tmpl->d ?>
                                </div> 
                            <!-- Finaliza Templates -->
                        </div>
                        <div class="TabbedPanelsContent">
							<!-- Inicia Listas -->
                                <div class="ln">
                                    <!--<?php echo bdiv(array('id'=>DV_LSFL.$__idtp_lsts, 'cls'=>'_sbls' )) ?>-->
                                    <?php echo $___Dt->tab->lsts->d ?>
                                </div> 
                            <!-- Finaliza Listas -->
                        </div>
                        <div class="TabbedPanelsContent">
							<!-- Inicia Seguimiento -->
                                <div class="ln">
                                    <!--<?php echo bdiv(array('id'=>DV_LSFL.$__idtp_sgus, 'cls'=>'_sbls' )) ?>-->
                                    <?php echo $___Dt->tab->sgus->d ?>
                                </div> 
                            <!-- Finaliza Seguimiento -->
                        </div>                               
                  </div>
                  
                  <?php       

                    						
						/*$___Dt->_dvlsfl_all([
							['n'=> $__idtp_cmpg,'t'=>$___Dt->mdlstp->tp.'_cmpg'],
							['n'=> $__idtp_tmpl,'t'=>$___Dt->mdlstp->tp.'_tmpl'],
							['n'=> $__idtp_lsts,'t'=>$___Dt->mdlstp->tp.'_lsts'],
							['n'=> $__idtp_sgus,'t'=>$___Dt->mdlstp->tp.'_sgus']					
						]);
						
						$CntWb .= "SUMR_Main.ls.btn({i:'TbGrp1', i2:'".TBGRP.$__idtp_cmpg."', t:'".strtoupper('snd')."', tb:'{$_id_tbpnl}' });	";
						$CntWb .= "SUMR_Main.ls.btn({i:'TbGrp1', i2:'".TBGRP.$__idtp_tmpl."', t:'".strtoupper('snd')."', tb:'{$_id_tbpnl}' });	";
						$CntWb .= "SUMR_Main.ls.btn({i:'TbGrp1', i2:'".TBGRP.$__idtp_lsts."', t:'".strtoupper('snd')."', tb:'{$_id_tbpnl}' });	";
						$CntWb .= "SUMR_Main.ls.btn({i:'TbGrp1', i2:'".TBGRP.$__idtp_sgus."', t:'".strtoupper('snd')."', tb:'{$_id_tbpnl}' });	";			  	  
	              
						$CntWb .= "SUMR_Main.ld.f.rtng();";*/
						
	              ?> 
              
            </div>

    </div>						
</div>                                                                  
<?php 
	
	$CntWb .= '$(".W_Fm").colorbox({width:"90%", height:"90%", overlayClose:false, escKey:false, onLoad:function(){$("#colorbox").removeAttr("tabindex");}, onClosed:function(){ } });';
	$CntWb .= JV_Blq().JV_HtmlEd($__jqte);
	 
?>
<?php } ?>