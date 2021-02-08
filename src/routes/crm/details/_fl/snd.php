<?php if(class_exists('CRM_Cnx')){ ?>
<div class="Cvr_Snd">
    <div class="_ln">
        <?php

       		$__idtp_cmpg = '_cmpg';
       		$__idtp_tmpl = '_tmpl';
       		$__idtp_tmpl_main = '_tmpl_main';
       		$__idtp_tmpl_mycmz = '_tmpl_mycmz';
		    $__idtp_tmpl_cmz = '_tmpl_cmz';
		    $__idtp_tmpl_data = '_tmpl_data';
       		$__idtp_lsts = '_lsts';
       		$__idtp_auto = '_auto';
       		$__idtp_sgus = '_sgus';
       		$__idtp_cmz = '_cmz';


			$___Dt->_dvlsfl_all([
				['n'=>'bsc', 'l'=>TX_INIC],
				['n'=>'cmpg', 't'=>'snd_ec_cmpg', 'l'=>TX_CMPS, 's'=> (!_ChckMd('snd_grph') ? 'ok':''), 's_click'=> (!_ChckMd('snd_grph') ? 'ok':'') ],
				['n'=>'tmpl', 't'=>'snd_ec_tmpl', 'l'=>TX_TMPLS, 'm'=>'&_op=ok' ],

				['n'=>'tmpl_main', 't'=>'snd_ec_tmpl', 't2'=>'main', 'l'=>TX_CODE, 'm'=>'&_op=ok', 's'=>'no', 'ldr'=>'no' ],
				['n'=>'tmpl_mycmz', 't'=>'snd_ec_tmpl', 't2'=>'mycmz', 'l'=>TX_PHM, 'm'=>'&_tmpl=mycmz&_op=ok' ],
				['n'=>'tmpl_cmz', 't'=>'snd_ec_tmpl', 't2'=>'cmz', 'l'=>TX_EDTBLS, 'm'=>'&_tmpl=cmz' ],
				['n'=>'tmpl_sis', 't'=>'snd_ec_tmpl', 't2'=>'sis', 'l'=>MDL_SIS, 'm'=>'&_tmpl=sis' ],
				['n'=>'tmpl_data', 't'=>'snd_ec_tmpl', 't2'=>'data', 'l'=>TX_FLJ, 'm'=>'&_tmpl=data' ],

				['n'=>'lsts', 't'=>'snd_ec_lsts', 'l'=>TX_LS ],
				['n'=>'auto', 't'=>'snd_ec_auto', 'l'=>TX_ATMZCN ],
				/*['n'=>'sgus', 't'=>'snd_ec_sgus', 'l'=>TX_SGMT], */
				['n'=>'cmz', 't'=>'snd_ec_cmz']
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
                <?php if(_ChckMd('snd_grph')){ echo $___Dt->tab->bsc->l; } ?>
                <?php if(_ChckMd('snd_ec_cmpg') || _ChckMd('snd_ec_cmpg_ing')){ echo $___Dt->tab->cmpg->l; } ?>
                <?php if(_ChckMd('snd_ec_tmpl') || _ChckMd('snd_ec_tmpl_ing')){ echo $___Dt->tab->tmpl->l; } ?>
                <?php if(_ChckMd('snd_ec_lsts')){ echo $___Dt->tab->lsts->l; } ?>
                <?php //if(_ChckMd('snd_ec_auto')){ echo $___Dt->tab->auto->l; } ?>
                <?php //if(_ChckMd('snd_ec_inf')){ echo $___Dt->tab->sgus->l; } ?>
            </ul>
            <div class="TabbedPanelsContentGroup">        
	            
                <section class="_cvr"><iframe src="<?php echo DMN_ANM; ?>envios_masivos/index.html" frameborder="0" width="100%" scrolling="no" height="200"></iframe></section> 
                
				<?php if(_ChckMd('snd_grph')){ ?>
					<div class="TabbedPanelsContent">
							
							<div class="_mn">
								
								<!--<div class="_box">
									<div class="_c _c_cmpg <?php if(!_ChckMd('snd_ec_cmpg_ing')){ echo 'off'; } ?>"><?php echo Spn().h2(TX_NV.Strn(TX_CAMP)); ?></div>
									<div class="_c _c_tmpl <?php if(!_ChckMd('snd_ec_tmpl_ing')){ echo 'off'; } ?>"><?php echo Spn().h2(TX_NVO.Strn(TX_TMPL)); ?></div>
									<div class="_c _c_lsts <?php if(!_ChckMd('snd_ec_lsts')){ echo 'off'; } ?>"><?php echo Spn().h2(TX_ADM.Strn(TX_LS)); ?></div>
									<div class="_c _c_segm <?php if(!_ChckMd('snd_ec_inf')){ echo 'off'; } ?>"><?php echo Spn().h2(TX_VR.Strn(TX_RPRTS)); ?></div>
								</div>-->

								<!-- Informes -->
								<style>
									.dsh_flt{display: flex;margin: 10px;}
									.dsh_flt .___txar{margin: 0px 10px;}
									.flt_grph{display: inline-block;vertical-align: top;background-color: #eaebed;border: 0;width: 25px;height: 25px;margin-top: 5px;margin-left: 7px;border-radius: 12px;background-size: 56%;background-repeat: no-repeat;background-position: center;background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>filtro.svg);}
								</style>
								<div class="dsh_flt">
									<?php echo SlDt([ 'id'=>'grph_fi', 'va'=>'', 'rq'=>'no', 'ph'=>'Fecha Inicial', 'lmt'=>'no' ]); ?> 
									<?php echo SlDt([ 'id'=>'grph_ff', 'va'=>'', 'rq'=>'no', 'ph'=>'Fecha Final', 'lmt'=>'no' ]); ?>     
									<button class="flt_grph"></button>	
								</div>
								<div class="_box" style="width: 39% !important;">
									<div id="dsh_ec_cmpg"></div>
									<div id="dsh_ec_snd"></div>
								</div>
								<div class="_grph" style="width: 60% !important;">
									<div class="rsmn_p">
										<div class="asd"><ul></ul></div>
										<?php 
											$___g_c = str_replace('#','',TAG_CLR_MAIN);

											$CntWb .= "

												$('.flt_grph').off('click').click(function(){

													var fi = $('#grph_fi').val();
													var ff = $('#grph_ff').val();
								
													Rqu({ fi: fi, ff: ff });
											   
												   });
												   
												function _Kn_Prcn(p){

													if(!isN(p.w)){ var __wd = p.w; }else{ var __wd = 20; }

													if(!isN(p.clr)){ 
														var __clr = p.clr; 
													}else if( p.l == 'ok' ){ 
														var __clr = '6C0'; 
													}else if( p.v == 100 ){ 
														var __clr = '6C0'; 
													}else if( p.v > 40){ 
														var __clr = 'F90'; 
													}else{ 
														if( p.v == 100){ 
															var __clr = '6C0'; 
														}else if( p.v > 40){ 
															var __clr = 'F90'; 
														}else{ 
															var __clr = 'C00'; 
														} 
													}
													
													if( p.di == 'ok' ){ var __di = true; }else{ var __di = false; }
													if(!isN(p.ds)){ var __ds = 'data-step=\"0.5\"'; }
													if(!isN(p.v)){ var __vl = 'value=\"'+p.v+'\"'; }
													if(!isN(p.dt)){ var __dt=p.dt; }else{var __dt='4'; }
													if(!isN(p.bclr)){ var __bclr=' bgColor:\"#'+p.bclr+'\" '; }

													var html = '<input type=\"text\" data-linecap=\"round\" data-fgColor=\"#'+__clr+'\" class=\"g_tot\" id=\"'+p.id+'\" value=\"'+p.v+'\" data-displayInput=\"'+__di+'\" data-width=\"'+__wd+'\" data-height=\"'+__wd+'\" data-readonly=\"true\" data-thickness=\"'+__dt+'\" '+__ds+'>';
													

													return html;

												}

												function Rqu(p){
													
													_Rqu({ 
														t:'snd', 
														d:'tot',
														data:p,
														_bs:function(){  },
														_cm:function(){  },
														_cl:function(_r){

															if(!isN(_r)){

																if(!isN(_r.e)){
																	
																	$('.asd ul').html('');	
																	$.each(_r.ls, function(k, v) { 

																		var li = '';

																		if(!isN(v.id)){
																			var html = _Kn_Prcn({ 
																				id: v.id, 
																				l:'ok', 
																				v:v.vl, 
																				clr:'${$___g_c}', 
																				w:'80',
																				di:'ok',
																				ds:'0.01',
																				dt:'.1' 
																			});

																			li = '<li class=\"list_ec\"><div class=\"_g\">'+html+'</div><strong>'+v.tt+'</strong><br>'+v.lbl+'<li>';
																			$('.asd ul').append(li);
																			$('#'+v.id).knob();
																		}
																	});

																	if(!isN(_r.dsp)){
																		
																		if(!isN(_r.dsp.e == 'ok')){ 

																			if(!isN(_r.dsp.ls)){
																				
																				var data=[];
											
																				for(var k in _r.dsp.ls){
																					var v = _r.dsp.ls[k];
																					if(!isN(v.nm)){
																						data.push({ name:v.nm, y: parseInt(v.tot) });
																					}
																				}
																				
																				if(!isN(data)){
																					SUMR_Grph.f.g2({ 
																						id: '#_grph_3_glb',
																						g_h: 350,
																						g_mrg_t:0,
																						g_mrg_b:0,
																						d: data,
																						tt: 'Aperturas',
																						tt_sb: 'Unicas por dispositivo',
																						dt_lbl: false,
																						lgnd:true,
																						dt_lbl_frmt: '{pint.percentage:.1f}%',
																						lgnd_frmt: function() {
																							return '<span>' + this.name +' </span> <span style=\"color:#727272;font-size:10px;\"> ' + this.percentage.toFixed(2) + ' %</span>';
																						},
																						i_s:'50%',
																						lgnd_lyt: 'horizontal',
																						lgnd_valgn: 'bottom',
																						lgnd_algn: 'center',
																						lgnd_y: 0
																					});
																					$('#_grph_3_glb').parent().removeClass('_ld');
																				}
																			}else{
																				$('#_grph_3_glb').html(0);
																			}
																		}
																	}

																	if(!isN(_r.os)){
																		if(!isN(_r.os.e == 'ok')){
																			if(!isN(_r.os.ls)){
											
																				var data=[];
											
																				for(var k in _r.os.ls){
																					var v = _r.os.ls[k];
																					if(!isN(v.nm)){
																						data.push({ name:v.nm, y: parseInt(v.tot) });
																					}
																				}
																				
																				if(!isN(data)){
																					SUMR_Grph.f.g2({ 
																						id: '#_grph_4_glb',
																						g_h: 350,
																						g_mrg_t:0,
																						g_mrg_b:0,
																						d: data,
																						tt: 'Aperturas Movil',
																						tt_sb: 'Sistema Operativo',
																						dt_lbl: false,
																						lgnd:true,
																						lgnd_frmt: function() {
																								return '<span>' + this.name +' </span> <span style=\"color:#727272;font-size:10px;\"> ' + this.percentage.toFixed(2) + ' %</span>';
																						},
																						i_s:'50%',
																						lgnd_lyt: 'horizontal',
																						lgnd_valgn: 'bottom',
																						lgnd_algn: 'center',
																						lgnd_y: 0
																					});
																					$('#_grph_4_glb').parent().removeClass('_ld');
																				}
											
																			}else{
																				$('#_grph_4_glb').html(0);
																			}
																		}
																	}

																	if(!isN(_r.brws)){
																		if(!isN(_r.brws.e == 'ok')){
																			if(!isN(_r.brws.ls)){
											
																				var data=[];
											
																				for(var k in _r.brws.ls){
																					var v = _r.brws.ls[k];
																					if(!isN(v.nm)){
																						data.push({ name:v.nm, y: parseInt(v.tot) });
																					}
																				}
																				
																				if(!isN(data)){
																					SUMR_Grph.f.g2({ 
																						id: '#_grph_5_glb',
																						g_h: 350,
																						g_mrg_t:0,
																						g_mrg_b:0,
																						g_spc_t:0,
																						d: data,
																						tt: 'Aperturas',
																						tt_sb: 'Navegador',
																						dt_lbl: false,
																						lgnd:true,
																						lgnd_frmt: function() {
																								return '<span>' + this.name +' </span> <span style=\"color:#727272;font-size:10px;\"> ' + this.percentage.toFixed(2) + ' %</span>';
																						},
																						i_s:'50%',
																						lgnd_lyt: 'horizontal',
																						lgnd_valgn: 'bottom',
																						lgnd_algn: 'center',
																						lgnd_y: 0
																					});
																					$('#_grph_5_glb').parent().removeClass('_ld');
																				}
											
																			}else{
																				$('#_grph_5_glb').html(0);
																			}
																		}
																	}

																	if(!isN(_r.clnt)){
																		if(!isN(_r.clnt.e == 'ok')){
																			if(!isN(_r.clnt.ls)){
											
																				var data=[];
																				var data_c=[];
											
																				for(var k in _r.clnt.ls){
																					var v = _r.clnt.ls[k];
																					if(!isN(v.nm)){
																						data_c[v.nm] = v.nm;
																						data.push( parseInt(v.tot) );
																					}
																				}
																				
																				if(!isN(data)){
																					
																					SUMR_Grph.f.g7({ 
																						id: '#_grph_6_glb',
																						g_spc_b: 80,
																						tt: 'Aperturas',
																						tt_sb: 'Cliente Email',
																						d: [{ name: 'Aperturas', data:[ data ] }]	
																					});
																					$('#_grph_6_glb').parent().removeClass('_ld');
																				}
											
																			}
																		}
																	}else{
																		$('#_grph_6_glb').html(0);
																	}

																	if(!isN(_r.bnct)){
																		if(!isN(_r.bnct.e == 'ok')){
																			if(!isN(_r.bnct.ls)){
											
																				var data=[];
											
																				for(var k in _r.bnct.ls){
																					var v = _r.bnct.ls[k];
																					if(!isN(v.nm)){
																						data.push({ name:v.nm, y: parseInt(v.tot) });
																					}
																				}
																				
																				if(!isN(data)){
																					SUMR_Grph.f.g2({ 
																						id: '#_grph_7_glb',
																						g_h: 350,
																						g_mrg_t:0,
																						g_mrg_b:0,
																						g_spc_t:0,
																						d: data,
																						tt: 'Rebotes',
																						tt_sb: 'por tipologia',
																						dt_lbl: false,
																						lgnd:true,
																						lgnd_frmt: function() {
																								return '<span>' + this.name +' </span> <span style=\"color:#727272;font-size:10px;\"> ' + this.percentage.toFixed(2) + ' %</span>';
																						},
																						i_s:'50%',
																						lgnd_lyt: 'horizontal',
																						lgnd_valgn: 'bottom',
																						lgnd_algn: 'center',
																						lgnd_y: 0
																					});
																					$('#_grph_7_glb').parent().removeClass('_ld');
																				}
											
																			}
																		}
																	}else{
																		$('#_grph_7_glb').html(0);
																	}

																	if(!isN(_r.ec_cmpg)){
																		if(!isN(_r.ec_cmpg.e == 'ok')){
																			if(!isN(_r.ec_cmpg.o)){
											
																				var data=[];
											
																				for(var k in _r.ec_cmpg.o){
																					
																					var v = _r.ec_cmpg.o[k];
																					data.push( parseInt(v) );
																					
																				}
																				
																				if(!isN(data)){

																					SUMR_Grph.f.g1({
																						id: '#dsh_ec_cmpg',
																						d: [
																								{
																									name: '', 
																									data: data,
																									color: '".TAG_CLR_MAIN."'  
																								}
																							], 
																						tt: 'Cantidad de campañas',
																						tt_sb: 'por mes',
																						c: _r.ec_cmpg.c,
																						tp: 'pie',
																						g_spc_t: 0,
																						g_h: 150,
																						c_e: true
																					});	
																				}
											
																			}
																		}
																	}

																	if(!isN(_r.ec_snd)){
																		if(!isN(_r.ec_snd.e == 'ok')){
																			if(!isN(_r.ec_snd.o)){
											
																				var data=[];
											
																				for(var k in _r.ec_snd.o){
																					
																					var v = _r.ec_snd.o[k];
																					data.push( parseInt(v) );
																					
																				}
																				
																				if(!isN(data)){

																					SUMR_Grph.f.g1({
																						id: '#dsh_ec_snd',
																						d: [
																								{
																									name: '', 
																									data: data,
																									color: '".TAG_CLR_MAIN."' 
																								}
																							], 
																						tt: 'Cantidad de Envios',
																						tt_sb: 'por mes',
																						c: _r.ec_snd.c,
																						tp: 'pie',
																						g_spc_t: 0,
																						g_h: 150,
																						c_e: true
																					});	
																				}
											
																			}
																		}
																	}
																}
															}
														} 
													});
												}

												Rqu();
											
											";

											?>
											
												<style>
													.Cvr_Snd ._mn ._grph .rsmn_p ul li{display: none}
													.Cvr_Snd ._mn ._grph .rsmn_p ul li.list_ec{display: inline-block !important}
												</style>

											<?php

											
											/*$_Ec_Snd_All = GtTotDt([ 't'=>'key', 'i'=>'ec_snd_all' ])->vl; //Total
											$_Ec_Snd_Acpt = GtTotDt([ 't'=>'key', 'i'=>'ec_snd_snd' ])->vl; //Enviados
											$_Ec_Snd_Op = GtTotDt([ 't'=>'key', 'i'=>'ec_snd_op' ])->vl; //Abiertos
											$_Ec_Snd_Err = GtTotDt([ 't'=>'key', 'i'=>'ec_snd_err' ])->vl; //Rebotes
											$_Ec_Snd_Efct = GtTotDt([ 't'=>'key', 'i'=>'ec_snd_efct' ])->vl; //Efectivos
											$_Ec_Snd_Trck = GtTotDt([ 't'=>'key', 'i'=>'ec_snd_trck' ])->vl; //Clicks únicos
											$_Ec_Snd_Rmv = GtTotDt([ 't'=>'key', 'i'=>'ec_snd_rmv' ])->vl; //Removidos*/

											/*$_Ec_Snd_All = GtEcSndTot([ 't'=>'all' ])->tot; //Total
											$_Ec_Snd_Acpt = GtEcSndTot([ 't'=>'snd' ])->tot; //Enviados
											$_Ec_Snd_Op = GtEcSndTot([ 't'=>'op' ])->tot; //Abiertos
											$_Ec_Snd_Err = GtEcSndTot([ 't'=>'err' ])->tot; //Rebotes
											$_Ec_Snd_Efct = ($_Ec_Snd_Acpt-$_Ec_Snd_Err); //Efectivos
											$_Ec_Snd_Trck = GtEcSndTot([ 't'=>'trck' ])->tot; //Clicks únicos
											$_Ec_Snd_Rmv = GtEcSndTot([ 't'=>'rmv' ])->tot; //Removidos*/
											
											
											
											
											/*$___g_tot = _Kn_Prcn([ 
												'id'=>'g_tot_glb', 
												'l'=>'ok', 
												'v'=>_Nmb(100, 5), 
												'clr'=>$___g_c, 
												'w'=>'80', 
												'di'=>'ok', 
												'ds'=>'0.01',
												'dt'=>'1'
											]);

											$___g_snd = _Kn_Prcn([ 
												'id'=>'g_tot_snd_glb', 
												'l'=>'ok', 
												'v'=>_Nmb(( ($_Ec_Snd_Acpt*100)/$_Ec_Snd_All ), 5), 
												'clr'=>$___g_c, 
												'w'=>'80', 
												'di'=>'ok', 
												'ds'=>'0.01',
												'dt'=>'1'
											]); 
											
											$___g_op = _Kn_Prcn([ 
												'id'=>'g_tot_op_glb', 
												'l'=>'ok', 
												'v'=>_Nmb(( ($_Ec_Snd_Op*100)/$_Ec_Snd_All ), 5),
												'clr'=>$___g_c, 
												'w'=>'80', 
												'di'=>'ok', 
												'ds'=>'0.01',
												'dt'=>'1'
											]); 
											
											$___g_err = _Kn_Prcn([ 
												'id'=>'g_tot_err_glb', 
												'l'=>'ok', 
												'v'=>_Nmb(( ($_Ec_Snd_Err*100)/$_Ec_Snd_All ), 5),
												'clr'=>$___g_c, 
												'w'=>'80', 
												'di'=>'ok', 
												'ds'=>'0.01',
												'dt'=>'1'
											]); 
											
											$___g_efct = _Kn_Prcn([ 
												'id'=>'g_tot_efct_glb', 
												'l'=>'ok', 
												'v'=>_Nmb(( ($_Ec_Snd_Efct*100)/$_Ec_Snd_All ), 5), 
												'clr'=>$___g_c, 
												'w'=>'80', 
												'di'=>'ok', 
												'ds'=>'0.01',
												'dt'=>'1'
											]); 
											
											$___g_trck = _Kn_Prcn([ 
												'id'=>'g_tot_trck_glb', 
												'l'=>'ok', 
												'v'=>_Nmb(( ($_Ec_Snd_Trck*100)/$_Ec_Snd_All ), 5), 
												'clr'=>$___g_c, 
												'w'=>'80', 
												'di'=>'ok', 
												'ds'=>'0.01',
												'dt'=>'1'
											]); 
							
											$___g_rmv = _Kn_Prcn([ 
												'id'=>'g_tot_rmv_glb', 
												'l'=>'ok', 
												'v'=>_Nmb(( ($_Ec_Snd_Rmv*100)/$_Ec_Snd_All ), 5),
												'clr'=>$___g_c, 
												'w'=>'80', 
												'di'=>'ok', 
												'ds'=>'0.01',
												'dt'=>'1'
											]); 
											
											$CntWb .= $___g_tot->js.$___g_snd->js.$___g_op->js.$___g_err->js.$___g_efct->js.$___g_trck->js.$___g_rmv->js;
											
											$__btch .= li(bdiv([ 'cls'=>'_g', 'c'=>$___g_tot->html ]).Strn('Total').HTML_BR._Nmb($_Ec_Snd_All, 3) );
											$__btch .= li(bdiv([ 'cls'=>'_g', 'c'=>$___g_snd->html ]).Strn('Enviados').HTML_BR._Nmb($_Ec_Snd_Acpt, 3) );
											$__btch .= li(bdiv([ 'cls'=>'_g', 'c'=>$___g_op->html ]).Strn('Abiertos').HTML_BR._Nmb($_Ec_Snd_Op, 3) );
											$__btch .= li(bdiv([ 'cls'=>'_g', 'c'=>$___g_err->html ]).Strn('Rebotes').HTML_BR._Nmb($_Ec_Snd_Err, 3) );
											$__btch .= li(bdiv([ 'cls'=>'_g', 'c'=>$___g_efct->html ]).Strn('Efectivos').HTML_BR._Nmb($_Ec_Snd_Efct, 3) );
											$__btch .= li(bdiv([ 'cls'=>'_g', 'c'=>$___g_trck->html ]).Strn('Clicks únicos').HTML_BR._Nmb($_Ec_Snd_Trck, 3) );
											$__btch .= li(bdiv([ 'cls'=>'_g', 'c'=>$___g_rmv->html ]).Strn('Removidos').HTML_BR._Nmb($_Ec_Snd_Rmv, 3) );
											
											echo ul($__btch);*/
											
										?>		
									</div>
								
									<!-- Panel graficas -->
									<div class="_chrt ec_cmpg_dsh_inf">
										
										<?php 
											//Trae los datos de las graficas
											include('_ext/snd_grph.php');
										?>

										<!-- Grafica mapa -->
										<div class="_ln cx1">
											<div class="_c1 _grph _ld">
												<div id="_grph_map_glb"></div>
												<?php 	
													$CntWb .= " 
										
														SUMR_Grph.f.g9({ 
															id: '#_grph_map_glb', 
															d: [".implode(',', $__grph_opnp)."],
															tt: 'Aperturas',
															tt_sb: 'por País',
															g_spc_b: 80,
															lgnd_algn: 'left',
															lgnd_valgn: 'middle',
															lgnd_lyt: 'vertical',
														});

													"; 
												?>
											</div>
										</div>
										<!-- Grafica mapa -->


										<?php 
											echo h2('Top Países '.Spn('con aperturas','ok'));
											
											$_col = _Nmb( $__cmpg_dt->ls->snd->opnp->grp->tot/3, 6 );
											$_c = 1;
											$_i = 1;
											
											foreach($__cmpg_dt->ls->snd->opnp->grp->ls as $_k => $_v){
												$__opnp[$_c] .= li(Strn($_v->tot).bdiv(array( 'c'=> $_v->nm, 'sty'=>'background-image:url('.$_v->img->th_c_100p.');' )));
												$_i++;
												if($_i > $_col){ $_i = 1; $_c++; }
											}
										?>
										

										<div class="_ln cx3">
											<div class="_c1 _ls_s_2">
												<?php echo ul($__opnp[1]); ?>
											</div>
											<div class="_c2 _ls_s_2">
												<?php echo ul($__opnp[2]); ?>
											</div>
											<div class="_c3 _ls_s_2">
												<?php echo ul($__opnp[3]); ?>
											</div>	
										</div>

										<!-- Aperturas Tortas -->
										<div class="_ln cx3">
											<div class="_c1 _grph _ld">
												<div id="_grph_3_glb"></div>
											</div>
											<div class="_c2 _grph _ld">
												<div id="_grph_4_glb"></div>
											</div>
											<div class="_c3 _grph _ld">
												<div id="_grph_5_glb"></div>
											</div>
										</div>
										<!-- Aperturas Tortas --> 
										
										<!-- Aperturas barras horizontales -->
										<div class="_ln cx2">
											<div class="_c1 _grph _ld">
												<div id="_grph_6_glb"></div>
											</div>
											<div class="_c2 _grph _ld">
												<div id="_grph_7_glb"></div>
											</div>
										</div>
									
									</div>
									<!-- Panel graficas -->
									

								</div>
								<!-- Informes -->
								
								
									
									
							</div>
							
					</div>
				<?php } ?>
				<?php 
					
					if(_ChckMd('snd_ec_cmpg')){ 

						
						$CntWb .= "
								
								$('._c_cmpg').off('click').click(function(){ 
									SUMR_Main.bxajx.".$___Dt->tab->id.".showPanel(2);
									".$___Dt->tab->cmpg->f."({ mre:'&_opnw=ok' });
								});";
					} 
				?>
				<?php 
					if(_ChckMd('snd_ec_tmpl_ing') || _ChckMd('snd_ec_ing')){ 
						
						$_id_tbpnl_sb = 'TabPnl_'.Gn_Rnd(20); 
						$CntJV .= "SUMR_Main.bxajx.".$_id_tbpnl_sb." = new Spry.Widget.TabbedPanels('".$_id_tbpnl_sb."', {defaultTab:0}); ";	
					
						
						if(_ChckMd('snd_ec_ing')){
							$_goto = $___Dt->tab->tmpl_main->f.'({ mre:\'&_opnw=ok\' });';
						}elseif(_ChckMd('snd_ec_tmpl_ing')){
							$_goto = $___Dt->tab->tmpl_mycmz->f.'({ mre:\'&_opnw=ok\' });';
						} 

						$CntWb .= "		
								
								$('._c_tmpl').off('click').click(function(){ 

									SUMR_Main.bxajx.".$___Dt->tab->id.".showPanel(3);
									SUMR_Main.bxajx.".$_id_tbpnl_sb.".showPanel(1);
									".$_goto."
									
								}); ";
								
					}
				?>
				<?php 
					if(_ChckMd('snd_ec_lsts')){ 
						$CntWb .= "		
								
								$('._c_lsts').off('click').click(function(){ 
									
									SUMR_Main.bxajx.".$___Dt->tab->id.".showPanel(4);
									SUMR_Main.bxajx.".$___Dt->tab->lsts->f."();
									
								});";
					}
				?>
				<?php 
					if(_ChckMd('snd_ec_auto')){ 
						$CntWb .= "		
								
								$('._c_segm').off('click').click(function(){ 
									SUMR_Main.bxajx.".$___Dt->tab->id.".showPanel(4);
									".JQ__ldCnt(FL_LS_GN.__t('snd_ec_sgus',true), DV_LSFL.$__idtp_sgus, '', false)."
								});";
					}
				?>
				<?php 
					if(_ChckMd('snd_ec_inf')){ 
						$CntWb .= "		
								$('._c_segm').off('click').click(function(){ 			                                		
									SUMR_Main.bxajx.".$___Dt->tab->id.".showPanel(4);
									".JQ__ldCnt(FL_LS_GN.__t('snd_ec_cmz',true), DV_LSFL.$__idtp_cmz, '', false)."
								});";
					}
				?>
                <?php if(_ChckMd('snd_ec_cmpg')){ ?>
                <div class="TabbedPanelsContent">
                    <?php echo $___Dt->tab->cmpg->d; ?>
                </div>
                <?php } ?>
                <?php if(_ChckMd('snd_ec_tmpl')){ ?>
                <div class="TabbedPanelsContent">

					<div id="<?php echo $_id_tbpnl_sb ?>" class="VTabbedPanels Tb<?php echo $___Dt->mdlstp->tpu ?> mny clr">
					    <ul class="TabbedPanelsTabGroup">
						    <?php if(_ChckMd('ec') || _ChckMd('snd_ec')){ echo $___Dt->tab->tmpl_main->l; } ?>
					      	<?php if(_ChckMd('snd_ec_tmpl')){ echo $___Dt->tab->tmpl_mycmz->l; } ?>
					        <?php if(_ChckMd('snd_ec_cmz')){ echo $___Dt->tab->tmpl_cmz->l; } ?>
					        <?php if(_ChckMd('snd_ec_data')){ echo $___Dt->tab->tmpl_data->l; } ?>
					        <?php if(_ChckMd('snd_ec_sis')){ echo $___Dt->tab->tmpl_sis->l; } ?>
					    </ul>
					    <div class="TabbedPanelsContentGroup">

				            <?php if(_ChckMd('ec') || _ChckMd('snd_ec') ){ ?>
				            <div class="TabbedPanelsContent">
		                    	<?php echo $___Dt->tab->tmpl_main->d ?>
				            </div>
				            <?php } ?>
				            <?php if(_ChckMd('snd_ec_tmpl') ){ ?>
				            <div class="TabbedPanelsContent">
		                        <?php echo $___Dt->tab->tmpl_mycmz->d ?>
				            </div>
				            <?php } ?>
				            <?php if(_ChckMd('snd_ec_cmz')){ ?>
				            <div class="TabbedPanelsContent">
								<?php echo $___Dt->tab->tmpl_cmz->d ?>
				            </div>
				            <?php } ?>

				            <?php if(_ChckMd('snd_ec_data')){ ?>
				            <div class="TabbedPanelsContent">
								<?php echo $___Dt->tab->tmpl_data->d ?>
				            </div>
				            <?php } ?>
				             <?php if(_ChckMd('snd_ec_sis')){ ?>
				            <div class="TabbedPanelsContent">
								<?php echo $___Dt->tab->tmpl_sis->d ?>
				            </div>
				            <?php } ?>

					    </div>
					</div>

				</div>
				<?php } ?>
                <?php if(_ChckMd('snd_ec_lsts')){ ?>
                <div class="TabbedPanelsContent">
					<?php echo $___Dt->tab->lsts->d ?>
                </div>
                <?php } ?>
            </div>
			<?php
				$CntWb .= "

					SUMR_Main.ld.f.html(function(){ SUMR_Main.ld.f.rtng(); });

					if(!isN( $('.Cvr_Snd ._tt_icn_tmpl_main') ) && $('.Cvr_Snd ._tt_icn_tmpl_main').length > 0){
						$('.Cvr_Snd ._tt_icn_tmpl').off('click').on('click', function(event){
							$('.Cvr_Snd ._tt_icn_tmpl_main')[0].click();
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