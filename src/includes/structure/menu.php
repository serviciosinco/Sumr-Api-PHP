<?php 
	
	
	//-------------- MENU BAR --------------//
	
		$__mnu_bar_rnd = '__mnu_bar_'.Gn_Rnd(20);
		${$__mnu_bar_rnd} = json_decode($_mnu_bar); 
		$__html_bar = _BldMnu( ${$__mnu_bar_rnd} );
	
	//-------------- MENU PRINCIPAL - PRIMERO --------------//
	
		$__mnu_main_rnd = '__mnu_main_'.Gn_Rnd(20);
		${$__mnu_main_rnd} = json_decode($_mnu_main); 
		$__html_main = _BldMnu( ${$__mnu_main_rnd} ); 
		
?>
<div class="hdr" id="_menu">
	
	<div style="display:none;">
        <audio id="__beep"><source src="<?php echo DMN_JS ?>_beep.mp3" type="audio/ogg"></audio>
		<audio id="__beep_chat"><source src="<?php echo DMN_JS ?>_beep_chat.mp3" type="audio/ogg"></audio>
    </div>
	                    
    <div class="wrap">
        <?php echo _Mn_Logo(); ?>
		
        <?php //if(isMobile()){ ?>
        	<div class="__mn_cmp_bx" style="display:none;">
            	<input id="__mn_cmp" name="__mn_cmp" type="button" value="" />
         	</div>
			<?php 
				$_CntJQ .= " $('#__mn_cmp').click(function(){ SUMR_Main.anm.mbl_mn(); }); ";
			?>   
		<?php //} ?>
                                    
        <div class="wrap" id="menu_wrap">
            <div id="menu" style="display:none;">
                <ul class="sf-menu" id="menu_sf">  
	                
	                <!-- // TEMPORAL -->
	                
	                <?php if(/*SISUS_ID == 181*/SISUS_ID > 0){ ?>	 
                   		<li class="_hme"><a href="<?php echo VoId() ?>" rel="indxTmp" s-cache="ok" class="_mtop __mn_dt"><?php echo bdiv([ 'cls'=>'mn-icon mn-icon-home' ]) ?><div class="tt-mbl">Dashboard</div></a></li>                 
                    <?php }else{ ?>
                    	<li class="_hme"><a href="<?php echo VoId() ?>" rel="indx" s-cache="ok" class="_mtop __mn_dt"><?php echo bdiv([ 'cls'=>'mn-icon mn-icon-home' ]) ?></a></li>
                    <?php } ?>
                    
                    
                    
                    <!-- TEMPORAL // -->
                    <?php if(ChckSESS_superadm()){ ?>
                    <li class="_news"><a href="<?php echo VoId() ?>" rel="news" s-cache="ok" class="_mtop __mn_dt"><?php echo bdiv([ 'cls'=>'mn-icon mn-icon-news', 'c'=>'<div class="_n"></div>' ]) ?><div class="tt-mbl">Notificaciones</div></a></li>
					<?php } ?>
					
                    <li class="__sep">
                    	<ul>
	                    	<?php echo $__html_main->m; ?>	
	                    </ul>
                    </li>
                    
                    <?php echo $__html_bar->b; ?>
                                        
                    <li class="__sht"> 
                    	<a href="<?php echo VoId() ?>" rel="sht" class="_mtop __mn_btn"><?php echo bdiv(['cls'=>'mn-icon mn-icon-sht']) ?></a> 
                    	<ul>
                        	<?php echo $__html_bar->s; ?>
                    	</ul> 
                    </li>	
                                	                  
                </ul>
                <div class="_othbtn">                         
                            
                    <div id="menu_cnfg">
                        <ul class="sf-menu-cnfg"> 
                            
                            <li class="__tt_btn">
                            	
                            	<?php echo bdiv(['c'=>TX_BTN_INDX, 'id'=>'tt_indx', 'cls'=>'']); ?>
                            	<?php echo $__html_bar->t.$__html_main->t ?>
                            	
                            	<?php 
                                	
                                	$_CntJQ .= "
                                	 
                                			$('._mtop.__mn_dt, ._mtop.__mn_ls, ._mtop.__mn_btn').hover(
	                                			
												  function() {
													  
													var __rl = $(this).attr('rel'),
														__rl_s = $(this).attr('rel-sub'),
														__rl_t = $(this).attr('rel-tp'),
														__rl_d = $(this).attr('rel-data'),
														__cche = $(this).attr('s-cache');
													
													if(!isN(__rl_s)){ var _sb='_'+__rl_s; }else{ var _sb=''; }
													if(!isN(__rl_t)){ var _tp='_'+__rl_t; }else{ var _tp=''; }
													if(!isN(__rl_d)){ var _data='_'+__rl_d; }else{ var _data=''; }
													if(!isN(__cche) && __cche == 'ok'){ var __cche_e = 'ok'; }else{ var __cche_e=''; }
													
												    $('#tt_'+__rl+_sb).fadeIn('fast');
												    $('#menu_cnfg').addClass('__shwtt');
												    
												  }, function() {
													  
												  	var __rl = $(this).attr('rel'); 
													var __rl_s = $(this).attr('rel-sub'); 
													if(!isN(__rl_s)){ var _sb='_'+__rl_s; }else{ var _sb=''; }
													
												    $('#tt_'+__rl+_sb).hide();
												    $('#menu_cnfg').removeClass('__shwtt');
												    
												  }
											);
											
											
											$('#menu_sf li, #menu_cnfg li').on('click', function (e) { 
												$('#menu_sf li, #menu_cnfg li').removeClass('_on');
											    $(this).addClass('_on');
											});
					
									";
									
                            	?>
                            </li>
                            
                            <?php if(!isMobile()){ ?>
                            <li><div id="_m_ldr" style="display:none"></div></li>
							<?php } ?>
							<?php echo _Mn_Logo_S([ 'rsllr'=>$__dt_cl->rsllr ]); ?>
							
							<?php include_once(dirname(dirname(dirname(__FILE__))).'/'.FL_ESTR_MNU_USER); ?>
							                                                    
							<?php if(ChckSESS_superadm()){ ?>
                            	<li class="br_rds _mnsis"><a href="<?php echo VoId() ?>" rel="cl_sis" s-cache="ok" class="__mn_dt cnf-sis br_rds grd_blue"><?php echo bdiv(['cls'=>'icon icon-sis']) . Spn(MDL_SIS,'','_cmp') ?></a></li>
                            <?php } ?>
							
                        </ul>
                    </div>        
                </div>    
            </div>
        </div>
    </div>
</div>

<!-- <input type="button" id="boton" value="Empezar Tour" onclick="SUMR_Main.tour()" /> -->

<!-- Inicia Tour -->

<div style="display:none;">
    <ol id="joyRideTipContent">
        
            <li data-id="bx_1_1" data-class="so-awesome" data-text="Siguiente" class="custom">
                <h2 class="font-economia">Aqui hace la primera parada</h2>
                <p>La primera parada.</p>
			</li>
			
			 <li data-id="LsFlstra" data-text="Siguiente" class="custom">
                <h2 class="font-economia">Aqui hace la segunda parada</h2>
                <p>La segunda parada.</p>
                
                <li data-id="bx_1_2" data-text="Cerrar" class="custom">
                <h2 class="font-economia">Aqui hace la ultima parada</h2>
                <p>La ultima parada.</p>
			</li>
			
        
    </ol>
</div>
<!-- Finaliza Tour -->
          
<?php //superadm_echo('<div style="background: white; color: black; width: 600px; margin : 0 auto; height: auto; word-wrap: break-word">'.SISUS_PRM.'</div>'); ?>
