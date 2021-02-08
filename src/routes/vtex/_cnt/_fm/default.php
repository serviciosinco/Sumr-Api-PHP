<?php 
	
	//-------------- VARIABLES GENERALES - START --------------//

		if( ChckSESS_cnt() && $_pm_action != 'dashboard'){
			header('Location:/'.$_pm_module.'/'.$__cmpg_dt->pml.'/dashboard/');
			die();
		}
	
		$__e = Php_Ls_Cln($_GET['_e']);
		
		if(isN($_____md_key) && $_____md_key == '{keyword}'){ $_____md_key = ''; }
		
		$__id_bx = 'FmBx'.$__id_rnd;
		$__id_fm = 'FmVtex'.$__id_rnd;
		$__id_fm_btn = 'FmVtexBtn'.$__id_rnd;

	//-------------- CLASS FORM --------------//

		$__Forms = new CRM_Forms();
		$__Forms->_rnd = $__id_rnd;

	//-------------- TARGET FORM --------------//

		if(!_isFm()){ $__trg_a = "_self"; }else{ $__trg_a = "_parent"; }
?>
			<section class="section default" id="main_content<?php echo $__id_rnd; ?>">
                <div class="_wrp">
                    <div class="sld">
                        <div class="col1">
							<div class="image_d"></div>
							<div class="texto_d"></div>
						</div>
						<div class="col2">
							<div class="__fm" style="opacity:0;" id="<?php echo $__id_bx ?>">	
								<div class="ldr"></div>
								<h1 class="_msjrs">Texto error</h1>
								<form action="<?php echo VoId(); ?>" id="<?php echo $__id_fm ?>" autocomplete="off" class="<?php if($__fm->shw->sch=='ok'){ echo '__sch'; } ?>">
									
									<?php if($_GET['__Sv'] == 'ok'){ echo HTML_inp_hd('__Sv', 'ok'); } ?>
									
									<?php echo HTML_inp_hd('____key', $__id_rnd); ?>
									<?php echo HTML_inp_hd('____tp', 'new_ins'); ?>
									<?php echo HTML_inp_hd('sch_cnt', "no"); ?>
									<?php echo HTML_inp_hd('Cnt_VtexCmpg'.$__id_rnd, $__cmpg_dt->enc); ?>
									<div id="<?php echo $__id_fm ?>_ld" class="_ld"></div>
									<div id="<?php echo $__id_fm ?>_rsl" class="_rsl"></div>
									
									<!------------- SEARCH BY KEY - START ------------->
							
									<div id="<?php echo $__id_fm ?>_flds" class="_flds">
										<p class="text">Ingresa tu nombre,&nbsp;correo y documento</p>
										<div class="_ln cx1"> 
											<div class="_fd">
												<?php echo _HTML_Input('Cnt_Nm'.$__id_rnd, TT_FM_FLLNM, '', FMRQD, 'text', ['ac'=>'name']); ?>
											</div> 
										</div>
										<div class="_ln cx1"> 
											<div class="_fd">
												<?php echo _HTML_Input('Cnt_Eml'.$__id_rnd, TT_FM_EML, '', FMRQD, 'email', ['ac'=>'name']); ?>
											</div>
										</div>
										<div class="_ln cx2">
											<div class="_blq _c1"> 
												<div class="_fd">
													<?php 
														
														$l = __Ls([ 'k'=>'cnt_dc', 
																	'id'=>'Cnt_DocTp'.$__id_rnd, 
																	'opt_v'=>'itm-sg',
																	'va'=>177, 
																	'ph'=>_cns('FM_LS_TPDOC'),
																	'slc'=>[ 
																			'opt'=>[
																					'attr'=>[
																						'itm-sg'=>'sg'
																					]	
																				] 
																			] 
																]); 
																
														echo $l->html; 
														
														if($browser->getBrowser() == 'Chrome'){
															$_CntJQ_S2 .= $l->js;
														}else{

															$_CntJQ .= " 

																$('#Cnt_DocTp".$__id_rnd."').addClass('cnt_dc_sfri');
															
															";

															
														}

													?>
												</div> 
											</div>
											<div class="_blq _c2">
												<div class="_fd">
													<?php echo _HTML_Input('Cnt_Doc'.$__id_rnd, TX_DCNMR, '', FMRQD_NM, 'text', ['ac'=>'off']); ?>
												</div>
											</div>
										</div>

										<p class="text">Ingresa el nombre y correo de todos tus amig@s</p>
		
										<?php for ($i = 1; $i <= 5; $i++) { 

												$__f_rnd = '_'.Gn_Rnd(15); 

												if($i == 1){
													$rq_nm = FMRQD;
													$rq_eml = FMRQD;
												}else{
													$rq_nm = '';
													$rq_eml = '';	
												}
										?>
											<div class="_ln cx2">
												<div class="_blq _c1">
													<div class="_fd">
														<?php echo _HTML_Input('Cnt_Ins_Nm'.$__f_rnd, 'Nombre', '', $rq_nm, 'text', ['ac'=>'off', 'n' => 'cnt_ins[cnt_'.$i.'][nm]' ]); ?>
													</div>
												</div>
												<div class="_blq _c2">
													<div class="_fd">
														<?php echo _HTML_Input('Cnt_Ins_Eml'.$__f_rnd, TT_FM_EML, '', $rq_eml, 'email', ['ac'=>'off', 'n' => 'cnt_ins[cnt_'.$i.'][eml]']); ?>
													</div>
												</div>
											</div>	
										<?php } ?> 
										<div class="checks">
											<input type="checkbox" id="terminos">
											<label id="_terminos" for="terminos">Acepto términos y condiciones</label>
										</div>
										<div class="_btn_snd">	
											<button class="pin" id="<?php echo $__id_fm_btn ?>" name="<?php echo $__id_fm_btn ?>"><?php echo 'Invitar Ahora'; ?></button>
										</div>
									</div>
								</form> 

								<div class="box_success">
									<div class="scss_res rcrd_exst">
										<h1>¡Ya estás inscrito!</h1>
										<p>Puedes ingresar al panel de fidelización con tu correo y contraseña</p>
										<button class="goto_dash">Ingresar a mi Cuenta</button>
									</div>

									<div class="scss_res rcrd_new">
										<h1>Registro Exitoso</h1>
										<p>Tu clave de acceso ya está en tu correo electrónico! Utiliza tu correo y clave para ingresar a tu cuenta.</p>
										<button class="goto_dash">Ingresar a mi Cuenta</button>
									</div>
								</div>

							</div>
						</div>
					</div>
				</div>
			</section>  
<?php

	

	if (Dvlpr()){
		$_CntJQ .= " 

			if(!SUMR_Ld.f.isN( SUMR_Vtex )){
				SUMR_Vtex.d.module = '".$_sbdo."/".$_pm_module."';
				SUMR_Vtex.d.cmpg.on.id = '".$__cmpg_dt->enc."';
				SUMR_Vtex.rnd = '".$__id_rnd."';
			}
		
		";
	}else{
		$_CntJQ .= " 

			if(!SUMR_Ld.f.isN( SUMR_Vtex )){
				SUMR_Vtex.d.module = '".$_pm_module."';
				SUMR_Vtex.d.cmpg.on.id = '".$__cmpg_dt->enc."';
				SUMR_Vtex.rnd = '".$__id_rnd."';
			}
		
		";
	}

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
		var _fmrsl_msj = $('#".$__id_bx." ._msjrs');
			
		var _utt = '".TX_SCSS."';
		var _utx = '".TX_SCSS_MSJ."';
		
		function _gOk(_r){
			$('body').addClass('success');	
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
			
			if(__plcy_e){
				if(_fm.valid()){	
					SUMR_Vtex.__snd({
						t:'cmpg_ins',
						d:_fm.serialize(),
						_bs:function(){ $('body').removeClass('on'); $('body').addClass('_ld'); },
						_cl:function(r){ 
							if(!SUMR_Ld.f.isN(r)){ 

								if( !SUMR_Ld.f.isN(r.pss_new) && r.pss_new == 'ok' && r.e == 'ok' ){
									$('#main_content{$__id_rnd}').addClass('r_scss new');
								}else if( !SUMR_Ld.f.isN(r.pss_exst) && r.pss_exst == 'ok' && r.e == 'ok' ){
									$('#main_content{$__id_rnd}').addClass('r_scss exst');
								}

								_gR(r); 
								
							}	 
						},
						_cm:function(r){ $('body').addClass('on'); $('body').removeClass('_ld'); },
						_w:function(r){ if(!SUMR_Ld.f.isN(r)){ _gW(r); } }
					});    
	            }	
            }else{
				$('#_terminos').effect( 'shake', {times:2}, 1000 );
			}
		}
		
		$('#{$__id_fm_btn}').off('click').click(function(event){
			event.preventDefault();
			_sndData();	
		});
		

		$('.box_success .goto_dash').off('click').click(function(event){
			event.preventDefault();
			location.href = '".$_pm_module."/login'
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

	.cnt_dc_sfri{ background-color: white !important; border-radius: 10px !important; }
	.checks .ui-effects-wrapper {width: 100% !important;}
</style>