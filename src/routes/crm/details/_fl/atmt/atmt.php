<?php if(class_exists('CRM_Cnx')){ ?>
<div class="Cvr_Atmt">
    <div class="_ln">     
        <?php
								
			$___Dt->_dvlsfl_all([
				['n'=>'bsc', 'l'=>TX_INIC],
				['n'=>'flw', 't'=>'atmt', 'l'=>'Flujos'],
				['n'=>'tra_col', 't'=>'tra_col', 'l'=>'Tareas' ],
				['n'=>'mdl', 't'=>'mdl', 'l'=>'Leads' ]
			],[
				'idb'=>'ok',
				'hd'=>'no',
				'sng'=>'ok',
				'icn_sty'=>'bsc',
				'tomny'=>'ok',
				'dtb'=>1
			]);

		?>
	
        <div id="<?php echo $___Dt->tab->id ?>" class="VTabbedPanels mny">
            <ul class="TabbedPanelsTabGroup">	
            	<li class="TabbedPanelsTab" style="display: none;"></li>     	  	
                <?php echo $___Dt->tab->bsc->l ?>
                <?php echo $___Dt->tab->flw->l; ?>
                <?php echo $___Dt->tab->tra_col->l; ?>
                <?php echo $___Dt->tab->mdl->l; ?>
                <?php //if(_ChckMd('snd_ec_auto')){ echo $___Dt->tab->auto->l; } ?>
                <?php //if(_ChckMd('snd_ec_inf')){ echo $___Dt->tab->sgus->l; } ?>
            </ul>
            <div class="TabbedPanelsContentGroup">    
                <section class="_cvr" style="background-color:#6b9c93;">
                    <iframe src="<?php echo DMN_ANM; ?>Automatizacion/index.html" frameborder="0" width="100%" scrolling="no" height="200"></iframe>
                </section> 
                <div class="TabbedPanelsContent">     
					Dashboard     
                </div> 
                <div class="TabbedPanelsContent">
					<?php echo $___Dt->tab->flw->d; ?>	
                </div>
                <div class="TabbedPanelsContent">    
					<div style="padding:20px;"> 
						<?php echo $___Dt->tab->tra_col->d; ?>
					</div>
				</div>
                <div class="TabbedPanelsContent">
					<div style="padding:20px;"> 
						<?php echo $___Dt->tab->mdl->d ?>
					</div>
                </div>                          
            </div>
			<?php 
				$CntWb .= "

					SUMR_Main.ld.f.html(function(){ SUMR_Main.ld.f.rtng(); }); 
					
					if(!isN( $('.Cvr_Atmt ._tt_icn_tmpl_main') ) && $('.Cvr_Atmt ._tt_icn_tmpl_main').length > 0){
						$('.Cvr_Atmt ._tt_icn_tmpl').off('click').on('click', function(event){ 
							$('.Cvr_Atmt ._tt_icn_tmpl_main')[0].click();
						});
					}

				"; 
			?> 
        </div>
    </div>						
</div> 	     
                                                            
<?php 	
	//$CntWb .= '$("body").addClass("bx_informe");';
	$CntWb .= '$(".W_Fm").colorbox({width:"90%", height:"90%", overlayClose:false, escKey:false, onLoad:function(){$("#colorbox").removeAttr("tabindex");}, onClosed:function(){ } });'; 
?>
<?php } ?>