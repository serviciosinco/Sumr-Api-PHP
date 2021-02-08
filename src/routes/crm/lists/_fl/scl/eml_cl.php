<div class="ln_1 sisslcf_dsh dsh_cnt _anm">
  	<div class="_c _anm _scrl" style="width: 100%;">
	  	<?php echo h2( TX_CL ); ?>
		<ul id="bx_cl_<?php echo $__Rnd; ?>" class="_ls dls _anm"></ul>	 
		<div class="_new_fm" id="bx_fm_cl_<?php echo $__Rnd; ?>"></div>
  	</div>
</div>
<?php 

						$CntJV .= " 
							__sisslc_bx_cl = $('#bx_cl_".$__Rnd."');				
							
							function MdlSTp_Dom_Rbld(){
								var __sisslc_bx_cl_itm = $('#bx_cl_".$__Rnd." > li.itm.cl .cl_dt');
								var __sisslc_bx_cl_itm_btn = $('#bx_cl_".$__Rnd." > li.itm.cl button');

								__sisslc_bx_cl_itm_btn.not('li.itm.cl').off('click').click(function(e){	
									e.preventDefault();

									if(e.target != this){
										e.stopPropagation(); return;
									}else{
										var est = $(this).hasClass('on') ? 'del' : 'in'; 	
										var _id = $(this).parent().attr('rel');
										
										_Rqu({ 
											t:'eml_cl', 
											d: 'cleml_dft',
											est: est,
											_id_eml : '".Php_Ls_Cln($___Ls->gt->isb)."',
											_id_cl : _id,
											_bs:function(){ __sisslc_bx_cl.addClass('_ld'); },
											_cm:function(){ __sisslc_bx_cl.removeClass('_ld'); },
											_cl:function(_r){ if(!isN(_r)){ if(!isN(_r.cl)){ SisSlcSet(_r.cl); } } } 
										});	
									}
								});

								__sisslc_bx_cl_itm.not('.sch, .nosnd').off('click').click(function(e){	
									e.preventDefault();				
									var est = $(this).parent().hasClass('on') ? 'del' : 'in'; 	
									var _id = $(this).parent().attr('rel');
									
									_Rqu({ 
										t:'eml_cl', 
										d:'cl',
										est: est,
										_id_eml : '".Php_Ls_Cln($___Ls->gt->isb)."',
										_id_cl : _id,
										_bs:function(){ __sisslc_bx_cl.addClass('_ld'); },
										_cm:function(){ __sisslc_bx_cl.removeClass('_ld'); },
										_cl:function(_r){ if(!isN(_r)){ if(!isN(_r.cl)){ SisSlcSet(_r.cl); } } } 
									});	
								});

								

								SUMR_Main.LsSch({ str:'#cl_sch_".$__Rnd."', ls:__sisslc_bx_cl_itm });	
							}
							
							function SisSlcF_Html(){
								__sisslc_bx_cl.html('');
								__sisslc_bx_cl.append('<li class=\"sch\">".HTML_inp_tx('cl_sch_'.$__Rnd, TX_SEARCH, '')."<button class=\"_new _anm\" new-tp=\"cl\"></button></li>');
								
								$.each(_sisslc['ls'], function(k, v) { 

									if(!isN(v.tot) && v.tot > 0){ var _cls = 'on'; }else{ var _cls = 'off'; }
									if(!isN(v.dft) && v.dft == 1){ var _cls_b = 'on'; }else{ var _cls_b = 'off'; }

									if(!isN(v.img)){ if(!isN(v.img.sm_s)){ img=v.img.sm_s; }else{ img=v.img; } }else{ img=''; }
									if(!isN(v.clr)){ var _bclr = v.clr; }else{ var _bclr = ''; }
									
									__sisslc_bx_cl.append('<li class=\"_anm itm cl us '+_cls+'\" cl-id=\"'+v.enc+'\" rel=\"'+v.enc+'\" style=\"background-color:'+_bclr+'\">
																<div class=\"cl_dt\">
																	<figure style=\"background-image:url('+img+')\" class=\"_bg\"></figure>
																	<span>'+v.nm+'</span>
																</div>
																<button class=\"'+_cls_b+'\"></button>
															</li>');
									
									MdlSTp_Dom_Rbld();
								});	
								 
							}
						";

						$CntJV .= "	
							function SisSlcSet(p){	
								if( !isN(p) ){	
									_sisslc = {};
									if( !isN(p) ){ _sisslc['ls'] = p.ls; _sisslc['tot'] = p.tot; }
									SisSlcF_Html();
								}
							}	
						";

												
							$CntJV .= "
								
								_Rqu({ 
									t:'eml_cl', 
									_id_eml : '".Php_Ls_Cln($___Ls->gt->isb)."',
									_cl:function(_r){ if(!isN(_r)){ if(!isN(_r)){ SisSlcSet(_r.cl); } } } 
								});
							";
								
					?>
					<style>
						.dsh_cnt ._c ul .itm.cl {display: flex;}
						.cl_dt{ width:100% }
						button.off {width: 20px;height: 20px;display: block;border-radius: 50%;background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>cancel.svg);border: 1px solid #fff;}
						button.on {width: 20px;height: 20px;display: block;border-radius: 50%;background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>checked.svg);border: 1px solid #fff;}
					</style>