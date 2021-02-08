<?php 
	
	$_i = Php_Ls_Cln($_GET['_i']);
	$__id_r = Gn_Rnd(20);
	$__id_fm = 'FmEnc'.$__id_r;
	
	$_p_cmpg = Php_Ls_Cln($_POST['cmpg']);
	
?>
<div class="_fm_fnc dash_snd_test"> 
	<div class="wrp">  
              
		<div class="_hdr"></div>
			
			
		<div id="<?php echo $__id_fm ?>_ld" class="_ld" style="display:none;"></div>	
		<div style="display: none" id="UrlS_<?php echo $__id_r ?>"><h2></h2></div>
			
		<div id="<?php echo $__id_fm ?>_flds" class="_wrp">
  			

	
			<input name="MM_download" id="MM_download" type="hidden" value="ProCnt" />
			<?php echo HTML_inp_hd('_tp', $__prfx->tp); ?>   
			
			
            <div id="<?php echo $__id_fm ?>_flds" class="_flds">        
					 
					<h2>Realice una prueba de su campaña <span>antes de enviarla a todos sus destinatarios.</span></h2> 
					 
					<div class="_ln1">  
						<div class="_d1 nm"><?php echo HTML_inp_tx('eccmpg_test_nm', TX_NM, '', FMRQD); ?> </div>
						<div class="_d1 eml"><?php echo HTML_inp_tx('eccmpg_test_eml', TT_FM_EML, '', FMRQD_EML); ?> </div>
                    </div>

					<ul>	
						<li class="_snd_fnc"><button class="btn" id="Do_Rqu_<?php echo $___Ls->id_rnd; ?>"><?php echo 'Enviar' ?></button>		          
					</ul>
                
					
					
					<?php
		  		
						$CntWb .= "
							
								$('#Do_Rqu_".$___Ls->id_rnd."').off('click').click(function(e) {
									
									
									e.preventDefault();
									
									
									if(e.target != this){
														
								    	e.stopPropagation(); return;
								    	
									}else{
										
										var __nm = $('#eccmpg_test_nm').val();
										var __eml = $('#eccmpg_test_eml').val();
										
										if( !isN(__nm) && !isN(__eml) ){
											
											_Rqu({ 
												f:'prc',
												t:'snd_ec_cmpg_test', 
												MM_insert: 'EdEcCmpgTest',
												eml:__eml,
												nm:__nm,
												cmpg:'".$_p_cmpg."',
												_bs:function(){ 
													$('#{$__id_fm}_ld').fadeIn();
													$('#{$__id_fm}_flds').fadeOut();
												},
												_cm:function(){
													$('#{$__id_fm}_ld').fadeOut();
													$('#{$__id_fm}_flds').fadeIn();	
												},
												_cl:function(_r){
													if(!isN(_r)){
														if(!isN(_r.e) && _r.e == 'ok'){
															SUMR_Main.pnl.f.shw();
															_Rqu_Msg({ t:'sndok' });				
														}else{	
															_Rqu_Msg({ t:'w' });		
														}
													}
												} 
											});
											
										
										}else{
											
											swal('Error', 'Faltan datos para la solicitud', 'error');
											
										}
	
										
											
									}
									
													
																		
								});
								
								
								
						";	
					
				?>		
				
				
			</div> 	 
		
		</div>
       
    </div>
</div>
<style>
	
	.dash_snd_test{}
	.dash_snd_test ._hdr{ background-color: #d8eff6; height: 250px; min-height: 250px; position: relative; overflow: hidden; }
	.dash_snd_test ._hdr::before{ background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>send_cover_test.svg); width: 200px; height: 200px; background-repeat: no-repeat; background-position: center center; background-size: auto 100%; display: block; position: absolute; left: 50%; bottom:-12px; margin-left: -100px; }

	
	
	.dash_snd_test ._wrp{ width: 100%; padding: 60px 50px; }
	.dash_snd_test ._wrp ._flds{ width: 60%; margin-left: auto; margin-right: auto; }
	.dash_snd_test ._wrp ._flds input[type=text]{ padding: 12px 0; text-align: center; background-color: transparent; margin-bottom: 0; }
	
	.dash_snd_test ._wrp ._flds ._d1::before{ width: 50px; height: 50px; position: absolute; left:-10px; top:0; transform: rotate(20deg); background-repeat: no-repeat; background-position: center center; background-size: auto 100%; opacity: 0.2; }
	.dash_snd_test ._wrp ._flds ._d1.nm::before{ background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>snd_test_nm.svg); }
	.dash_snd_test ._wrp ._flds ._d1.eml::before{ background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>snd_test_email.svg); }
	
	
	.dash_snd_test ._ln1 ._d1{ margin-bottom: 15px; position: relative; overflow: hidden; z-index: 1; }
	.dash_snd_test ._ln1 ._d1 .___txar{ z-index: 2; }
	
	.dash_snd_test button{ padding: 15px 10px; font-size: 16px; background-color:var(--main-bg-color); text-align: center; color: white; width: 100%; margin-left: auto; margin-right: auto; display: block; font-family: Economica; text-transform: uppercase; font-size: 16px; border-radius:8px; -moz-border-radius:8px; -webkit-border-radius:8px; }
	.dash_snd_test button:hover{ background-color:var(--second-bg-color); color: white; }
	
	
	
	
	
	.dash_snd_test h2{ color: #333030; font-weight: 400; font-family: Economica; font-size: 26px; width: 100%; display: block; margin-bottom: 20px; margin: 0 0 60px 0; padding: 0; }
	.dash_snd_test h2 span{ color: #afacac; width: 100%; display: block; font-size: 20px; font-weight: 300; }
	
	
	
</style>	