<?php 
	
	try{
		
		//--------- Valores Post ---------//
		
			$_tp = Php_Ls_Cln($_POST['tp']);
			$_ord = Php_Ls_Cln($_POST['ord']);
			$_sino = Php_Ls_Cln($_POST['sino']);
			$_nxt = Php_Ls_Cln($_POST['nxt']);
			$_sve = _jEnc(Php_Ls_Cln($_POST['sve']));	
		
		//--------- Busco Siguiente Texto ---------//
			
			if(!isN($_ord)){ $__ord = $_ord; }elseif(isN($_nxt)){ $__ord = 1; }
		
		//--------- Tipo de Texto y Accion a Mostrar ---------//
		
			if($_tp == 'sndi'){ $__t = _CId('ID_SISSCRPTTP_SNDI'); }
		
		//--------- Información de Script ---------//
			
			$__scrpt = GtClScrptLs([ 'tp'=>$__t, 'ord'=>$__ord, 'nxt'=>$_nxt, 'sino'=>$_sino ]);
			$rsp['tmp'] = $__scrpt;
		
		//--------- Recorro Consulta ---------//
		
		
			if(!isN($__scrpt->ls)){			
				
				foreach($__scrpt->ls as $__scrpt_k=>$__scrpt_v){
					
						
					//--------- Tipo de Diligenciamiento o Selección ---------//
						
						$_ord_nxt = $__scrpt_v->ord;
						$_end = $__scrpt_v->end;
					
						if(mBln($__scrpt_v->act->nm->vl)=='ok'){ 
							$__fld_fll .= HTML_inp_tx('__sndi_cnt_nm'.$___Ls->id_rnd, TT_FM_NM, '', FMRQD);
							$__fld_fll_sve .= " var _val_nm = $('#__sndi_cnt_nm".$___Ls->id_rnd."').val(); ";
							$__fld_fll_sve .= " SUMR_Main.bxajx.mdlcnt.cnt_nm = _val_nm;"; 
						}
						
						if(mBln($__scrpt_v->act->doc->vl)=='ok'){ 
							$__fld_fll .= HTML_inp_tx('__sndi_cnt_doc'.$___Ls->id_rnd, TT_FM_DC, '', FMRQD); 
							$__fld_fll_sve .= " 
								var _val_dc = $('#__sndi_cnt_doc".$___Ls->id_rnd."').val();
								if(!isN(_val_dc)){ SUMR_Main.bxajx.mdlcnt.cnt_dc = _val_dc; }
							"; 
						}
						
						if(mBln($__scrpt_v->act->eml->vl)=='ok'){ 
							$__fld_fll .= HTML_inp_tx('__sndi_cnt_eml'.$___Ls->id_rnd, TT_FM_EML, '', FMRQD_EML); 
							$__fld_fll_sve .= " 
									var _val_eml = $('#__sndi_cnt_eml".$___Ls->id_rnd."').val();
									if(!isN(_val_eml)){ SUMR_Main.bxajx.mdlcnt.cnt_eml = _val_eml; }
							"; 
						}
						
						if(mBln($__scrpt_v->act->sino->vl)=='ok'){ 
							
							$__fld_fll .= '	<div class="_yesno">
												<ul>
													<li><button class="_yes _anm" scrpt-chs="Si" scrpt-v="1">Si</button></li>
													<li><button class="_no _anm" scrpt-chs="No" scrpt-v="2">No</button></li>
												</ul>
											</div>'; 
							
							$__fld_fll_sve .= " SUMR_Main.bxajx.mdlcnt.cnt_sndi = _val;";
											
							$__fld_fll_sino = 'ok';				
						}
					
					
					//--------- Construyo HTML ---------//
					
					
						$rsp['html'][] = [
											'id'=>$__scrpt_v->id,
											'tx'=>Scrpt($__scrpt_v->tx, ['sve'=>$_sve] ),
											'fll'=>$__fld_fll,
											'nxt'=>($__fld_fll_sino=='ok'?'no':'ok')
										];
					
					
					//--------- Construyo Animación de Texto ---------//
					
						$rsp['js'] .= "
										SUMR_Main.bxajx.typed['".$__scrpt_v->enc."'] =  new Typed('#_scrpt_sndi_".$__scrpt_v->id." .bx', {
											strings: [ $('#_scrpt_sndi_".$__scrpt_v->id." .inp').html() ],
											typeSpeed: 3,
											smartBackspace: true,
											cursorChar: '_',
											onComplete: function(self){ 
												$('#_scrpt_sndi_".$__scrpt_v->id."').addClass('_rdy');	
												$('#crm-panel-".$___Ls->gt->pnl->id." .crm-panel-content').mCustomScrollbar('scrollTo', 'bottom', { scrollInertia:0 });
											}
										});
		
						";
					
					//--------- Si se diligencia campo se muestra en seguida ---------//	
					
						if(!isN($__fld_fll)){
							$__show_rsp = "$('.dsh_scrpt ._txt').append('<div class=\"usrsp\"><div class=\"bx\"><span class=\"_icn\"></span>'+_val+'</div></div>');";
						}
					
					
					//--------- Si requiere accion en boton si / no ---------//
					
						if($__fld_fll_sino == 'ok' && $_end != 'ok'){
							
							$rsp['js'] .= "
							
								$('#_scrpt_sndi_".$__scrpt_v->id." button._yes, #_scrpt_sndi_".$__scrpt_v->id." button._no').off('click').click(function(e){		
									
									if(e.target != this){
								    	e.stopPropagation(); return;
									}else{
										
										var _val = $(this).attr('scrpt-chs');
										var _val_n = $(this).attr('scrpt-v');
										
										$('#_scrpt_sndi_".$__scrpt_v->id."').addClass('_chk');	
										".$__fld_fll_sve."
										".$__show_rsp."
										Scrpt_Gt({ nxt:'".$_ord_nxt."', t:'sndi', sino:_val_n, pnl_id:'".$___Ls->gt->pnl->id."' });	
									
									}	
									
								});	
								
							";
					
					//--------- Si debe finalizar al oprimir next ---------//
					
						}elseif($_end == 'ok'){  
							
							$rsp['js'] .= "
							
								$('#_scrpt_sndi_".$__scrpt_v->id." button.nxt').off('click').click(function(e){		
									
									if(e.target != this){
								    	e.stopPropagation(); return;
									}else{		
																											
										$('#_scrpt_sndi_".$__scrpt_v->id."').addClass('_chk');		
										".$__fld_fll_sve."
										
										if(!isN(SUMR_Main.bxajx.mdlcnt.dcstart) && (!isN(SUMR_Main.bxajx.mdlcnt.cnt_dc) || !isN(SUMR_Main.bxajx.mdlcnt.cnt_eml))){
											if(!isN(SUMR_Main.bxajx.mdlcnt.cnt_dc)){
												var _start = SUMR_Main.bxajx.mdlcnt.cnt_dc;
												$('#cnt_dc').val( SUMR_Main.bxajx.mdlcnt.cnt_dc );
											}
											
											if(!isN(SUMR_Main.bxajx.mdlcnt.cnt_eml)){
												var _start = SUMR_Main.bxajx.mdlcnt.cnt_eml;	
												$('#cnt_eml').val( SUMR_Main.bxajx.mdlcnt.cnt_eml );
											}
											
											$('#'+SUMR_Main.bxajx.mdlcnt.dcstart).val( _start );
											$('#cnt_nm').val( SUMR_Main.bxajx.mdlcnt.cnt_nm );
											$('#cnt_sndi').attr('checked', true);
											
											
										}

										SUMR_Main.pnl.f.shw();
										
									}	
									
								});	
								
							";
								
							
					//--------- Si requiere accion en boton next ---------//
							
						}else{
							
							$rsp['js'] .= "
							
								$('#_scrpt_sndi_".$__scrpt_v->id." button.nxt').off('click').click(function(e){		
									
									if(e.target != this){
								    	e.stopPropagation(); return;
									}else{		
																		
										$('#_scrpt_sndi_".$__scrpt_v->id."').addClass('_chk');	
										".$__fld_fll_sve."
										
										var _ls = $('#_scrpt_sndi_".$__scrpt_v->id." :input');
										
										_ls.each(function(e){
											var _val = $(this).val();	
											if(!isN(_val)){ ".$__show_rsp." }
										});
																			
										Scrpt_Gt({ nxt:'".$_ord_nxt."', t:'sndi', pnl_id:'".$___Ls->gt->pnl->id."' });	
									
									}	
									
								});	
								
							";
						
						}
					
					
				
					
				}
	
	
			}
				
	
	}catch(Exception $e){
		$rsp['e'] = 'no';
		$rsp['w'] = "No se pudo procesar ".$e->getMessage();
	}
	
?>