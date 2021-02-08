<?php 
	
	//-------------- VARIABLES GENERALES - START --------------//

		$i =  Php_Ls_Cln($_GET['i']);
		$_rfd_dt = GtVtexCmpgInsRfdDt([ 't'=>'enc', 'id'=>$i, 'bd'=>$__cl->bd ]);

		$__id_bx = 'FmBx'.$__id_rnd;
		$__id_fm = 'FmVtex'.$__id_rnd;
		$__id_fm_btn = 'FmVtexBtn'.$__id_rnd;

	//-------------- TARGET FORM --------------//

		$_CntJQ .= " 
				if(!SUMR_Ld.f.isN( SUMR_Vtex )){
					SUMR_Vtex.d.module = '".$_pm_module."';
					SUMR_Vtex.d.cmpg.on.id = '".$__cmpg_dt->enc."';
					SUMR_Vtex.rnd = '".$__id_rnd."';
				}
			";
		
?> 
	
	<section class="section refered">
		<div class="_wrp">
			<div class="sld">
				<div class="col1"> </div>
				<div class="col2">
					<div class="__fm" style="opacity:0;" id="<?php echo $__id_bx ?>">	
						<div class="ldr"></div>
						<h1 class="_msjrs">Texto error</h1>
								
						<?php 
							
							if(!isN($_rfd_dt) && $_rfd_dt->e == 'ok' && !isN($_rfd_dt->coup->rfd->v)){ ?>

								<div class="fm">
									<div class="check"></div>
									<p class="bono"> 
										Tu bono ya ha sido 
										<b style="font-weight: 700;">generado </b>
										<a href="https://www.miscelandia.com.co/login/" target="_self">Usar Código</a>
									</p>	
								</div>	

							<?php }else{ ?>

								<form action="<?php echo VoId(); ?>" id="<?php echo $__id_fm ?>" autocomplete="off" class="<?php if($__fm->shw->sch=='ok'){ echo '__sch'; } ?>">

									<?php echo HTML_inp_hd('____key', $__id_rnd); ?>
									<?php echo HTML_inp_hd('____tp', 'new_ins'); ?>
									<?php echo HTML_inp_hd('Cnt_VtexCmpg'.$__id_rnd, $__cmpg_dt->enc); ?>
									<?php echo HTML_inp_hd('Cnt_OnlyData', 'ok'); ?>
									<?php echo HTML_inp_hd('___i', $_rfd_dt->enc); ?>

									<div id="<?php echo $__id_fm ?>_ld" class="_ld"></div>
									<div id="<?php echo $__id_fm ?>_rsl" class="_rsl"></div>
									
									<!------------- SEARCH BY KEY - START ------------->

									<div id="<?php echo $__id_fm ?>_flds" class="_flds">

										<?php echo _HTML_Input('Cnt_Nm'.$__id_rnd, TX_NM, $_rfd_dt->cnt->nm.' '.$_rfd_dt->cnt->ap , FMRQD, 'text', ['ac'=>'off']); ?>
										<?php 
											echo '<p class="data">'.$_rfd_dt->cnt->eml.'</p>';
											echo HTML_inp_hd('Cnt_Eml'.$__id_rnd, $_rfd_dt->cnt->eml);
										?>

										<div class="checks">
											<input type="checkbox" id="terminos">
											<label id="_terminos" for="terminos">Acepto términos y condiciones</label>
										</div>

										<div class="checks">
											<input type="checkbox" id="habeas">
											<label id="_habeas" for="habeas">Acepto recibir el email y mensajes de texto con novedades y promociones.</label>
										</div>
												
										<div class="_btn_snd">	
											<button class="pin" id="<?php echo $__id_fm_btn ?>" name="<?php echo $__id_fm_btn ?>"><?php echo 'Redime Aquí'; ?></button>
										</div>

									</div>

								</form> 

								<div class="success_ok">
									<figure></figure>
									<h1 class="_tt"></h1>  
									<div class="_tx"></div> 
									<button id="Goto_Store<?php echo $__id_rnd ?>">Usar Código</button>
									<div class="_dscl"></div> 
								</div>
							<?php } ?>
					</div>
				</div>
			</div>
		</div>
	</section>

<?php

	$_CntJQ .= "
	
		function _rSz(p){
			var _h = '';	
			var _h_ov='';
			var _h_doc = parseInt(document.body.offsetHeight);
			
			if(!SUMR_Ld.f.isN(p)&&!SUMR_Ld.f.isN(p.h_ov)){ _h_ov=p.h_ov; }
			
			if(!SUMR_Ld.f.isN(_h_ov)){ 
				var _h = parseInt(_h_doc) + parseInt(_h_ov);
			}else{
				var _h = _h_doc;
			}
			
			var p_d = { 'id':'".(!isN($__mdlgen->enc)?$__mdlgen->enc:$__mdl->enc)."', 't':'rsze', 'height':_h };
			top.postMessage( JSON.stringify(p_d) , \"*\");	
		}
		
	";	
	

	$_CntJQ_Vld .= "

		var _ldr = $('#".$__id_fm."_ld');
        var _fm = $('#".$__id_fm."');
		var _fmflds = $('#".$__id_fm."_flds');
		var _fmrsl = $('#".$__id_fm."_rsl');
		
		var _fmrsl_tt = $('#".$__id_bx." .success_ok ._tt');
		var _fmrsl_tx = $('#".$__id_bx." .success_ok ._tx');
		var _fmrsl_dscl = $('#".$__id_bx." .success_ok ._dscl');
		var _fmrsl_msj = $('#".$__id_bx." ._msjrs');
			
		var _utt = 'Redime tu bono regalo usando el código: ';
		var _udscl = '* Hemos enviado este código tambien a tu correo';
		
		function _gOk(_r){
			if(!SUMR_Ld.f.isN(_r) && !SUMR_Ld.f.isN(_r.coup)){
				$(_fmrsl_tt).html(_utt);
				$(_fmrsl_tx).html(_r.coup);
				$(_fmrsl_dscl).html(_udscl);
				$('body').addClass('success');

				$('body .col1').off('click').click(function(event){
					event.preventDefault();
					window.location.href = 'https://www.miscelandia.com.co/';
				});

			}
		}

		function _gR(_r){
			if(_r.e == 'ok'){
				_gOk(_r);							
			}else{
				_gW();
			}
			_rSz();
		}
		
		
		function _gW(_r){
			_fmrsl_msj.html('Intenta de nuevo, por favor').show();	
			_rSz({ h_ov:'1' });
			
			setTimeout(function(){ _fmrsl_msj.fadeOut('slow',function(){ _rSz(); }); }, 6000);
		}
		
		function _sndData(){
			
			var __plcy_e = $('#terminos').is(':checked');
			var __hbas_e = $('#habeas').is(':checked');
			
			if(__plcy_e && __hbas_e){
				if(_fm.valid()){	

					console.log('Send data now');

					SUMR_Vtex.__snd({
						t:'mdl_cnt',
						d:_fm.serialize(),
						_bs:function(){ $('body').removeClass('on');  $('body').addClass('_ld');  },
						_cl:function(r){
							if(!SUMR_Ld.f.isN(r)){ _gR(r); }	
						},
						_cm:function(r){ $('body').addClass('on');  $('body').removeClass('_ld');  },
						_w:function(r){
							if(!SUMR_Ld.f.isN(r)){ _gW(r); }
						}
					});  

	            }else{
					console.log('Not valid form');
				}	
            }else{
				$('#_terminos').effect( 'shake', {times:2}, 1000 );
			}
			

				
           
		}
		
		$('#{$__id_fm_btn}').off('click').click(function(event){
			event.preventDefault();
			_sndData();
		});
		
		$('#Goto_Store{$__id_rnd}').off('click').click(function(event){
			event.preventDefault();
			window.open('https://www.miscelandia.com.co/login/', '_new');
        });
        
        $(window).resize(function(){
			_rSz();
		});
        
        _rSz();
        
	"; 
	
	
	if($_GET['Sv'] == 'ok' || $__e == 'ok' || $_____snt == 'ok'){ 
		$_CntJQ_Vld .= " _gOk(); ";
	}

?>
<style>
	.checks .ui-effects-wrapper {width: 100% !important;}
</style>