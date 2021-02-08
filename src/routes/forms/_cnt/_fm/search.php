<?php 
	
	$_CntJQ .= "
	
		/* Agregar telefonos */
		$('._tel ._new span, ._tel ._new ._icn').off('click').click(function(){
			$('._tel ._new').addClass('_new_tel');
			$('#_new_tel_".$__id_rnd."').focus();
		});
		
		/* Agregar correos */
		$('._eml ._new span, ._eml ._new ._icn').off('click').click(function(){
			$('._eml ._new').addClass('_new_eml');
			$('#_new_eml_".$__id_rnd."').focus();
		});
		
		/* Agregar telefonos */
		$('#_new_tel_".$__id_rnd."').off('blur').blur(function(){
			if( !isN($(this).val().trim()) ){
			
				var _tel = $(this).val();
				
				SUMR_Fm.f.rqu({
					p:'sch',
					t:'cnt',
					d:{
						tel: _tel,
						mdl: '".$__mdl_id."',
						mdl_gen_chk: '".$_mdl_gen_chk."',
						cnt: _cnt_enc,
						tp: '_new_tel'
					},
					_cl:function(r){
						if(!isN(r)){
							 
							if( !isN(r) ){
								if(r.e == 'ok'){
									$('._tel ._all').append('<span> '+_tel+' </span>');
									$('._tel ._new').removeClass('_new_tel');
								}else{
									SUMR_Fm.o.rsl.msj.html(r.w).show();	
									SUMR_Fm.f.rsz({ h_ov:'1' });
									setTimeout(function(){ SUMR_Fm.o.rsl.msj.fadeOut('slow',function(){ SUMR_Fm.f.rsz(); }); }, 6000);
								}
							}
							
						}
					}
				});
			
			}else{
				$('._tel ._new').removeClass('_new_tel');
			}
		});
		
		/* Agregar correos */
		$('#_new_eml_".$__id_rnd."').off('blur').blur(function(){
			if( !isN($(this).val().trim()) ){
			
				var _eml = $(this).val();
				
				SUMR_Fm.f.rqu({
					p:'sch',
					t:'cnt',
					d:{
						eml: _eml,
						mdl: '".$__mdl_id."',
						mdl_gen_chk: '".$_mdl_gen_chk."',
						cnt: _cnt_enc,
						tp: '_new_eml'
					},
					_cl:function(r){
						if(!isN(r)){
							
							if( !isN(r) ){
								if(r.e == 'ok'){
									$('._eml ._all').append('<span> '+_eml+' </span>');
									$('._eml ._new').removeClass('_new_eml');
								}else{
									SUMR_Fm.o.rsl.msj.html(r.w).show();	
									SUMR_Fm.f.rsz({ h_ov:'1' });
									setTimeout(function(){ SUMR_Fm.o.rsl.msj.fadeOut('slow',function(){ SUMR_Fm.f.rsz(); }); }, 6000);
								}
							}
							
						}
					}
				});
			
			}else{
				$('._eml ._new').removeClass('_new_eml');
			}
		});
		
		/*
		
		$('#_new_tel_".$__id_rnd."').off('keyup').keyup(function(e) {
			if(e.which==13){
			    console.log('Fuera');
			}
		});
		
		*/
		
		
		$('#Cnt_Doc_Sch_Btn".$__id_rnd."').off('click').click(function(e){ 
			
			e.preventDefault();
		
			if(e.target != this){
		       e.stopPropagation();
			   return;
			}else{
				
				var _vl_sch = $('#Cnt_Doc_Sch".$__id_rnd."').val(),
					_this = $(this);
				
				if(!isN(_vl_sch)){
					
					SUMR_Fm.f.rqu({
						p:'sch',
						t:'cnt',
						d:{
							sch:_vl_sch,
							mdl: '".$__mdl_id."',
							mdl_gen_chk: '".$_mdl_gen_chk."',
							tp: '_sch'
						},
						_bs:function(){ _this.addClass('on'); },
						_cl:function(r){
							if(!isN(r)){
								 
								$('#Cnt_Doc{$__id_rnd}').val(_vl_sch);
								 
								try{
								
									if(r.tp_v_e == 'no' && r.tp_v_ls.e == 'ok'){ console.log('Enter 1');
											
										SUMR_Fm.o.rsl.msj.html('Habilitado solo para ( <span></span> )').show();	
											
										$.each(r.tp_v_ls.ls, function(k, v) {
									 		if(!isN(v.nm)){
										 		$('._msjrs > span').append(' - '+v.nm);
								 			}
								 		});
								 		
										
										SUMR_Fm.f.rsz({ h_ov:'1' });
										setTimeout(function(){ SUMR_Fm.o.rsl.msj.fadeOut('slow',function(){ SUMR_Fm.f.rsz(); }); }, 6000);
										
									}else if(r.e == 'no_exist'){ console.log('Enter 2');
									
										$('#".$__id_fm."').removeClass('__sch');
										
									}else if(r.e == 'ok' && !isN(r.cnt) && !isN(r.cnt.enc) && !isN(r.cnt.sndi) && r.cnt.sndi == 'ok'){
										
										console.log('Enter 3');
										
										_cnt_enc = r.cnt.enc;
										
										$('#Cnt_Nm{$__id_rnd}').val(r.cnt.nm+' '+r.cnt.ap);			
										$('#Cnt_Doc_Sch_Rsl{$__id_rnd} ._nm').html('<h1>'+r.cnt.nm+' <span>'+r.cnt.ap+'</span></h1>');
										$('#Plcy_Chck{$__id_rnd}').attr('checked','checked');
										
										/* Agrega telefonos */
										if(!isN(r.cnt.tel)){
											$.each(r.cnt.tel, function(k_tel, v_tel){
												if( !isN(v_tel) ){
													$('._tel ._all').append('<span> '+v_tel.v+' </span>');
												}
									 		});
								 		}
								 		
								 		/* Agrega correos */
								 		if(!isN(r.cnt.eml)){
									 		$.each(r.cnt.eml, function(k_eml, v_eml) {
												if( !isN(v_eml) ){
													$('._eml ._all').append('<span> '+v_eml.v+' </span>');
												}
									 		});
								 		}
										
										
										/*
										if(!isN(r.cnt.tot) && ( r.cnt.tot.eml < 1 || r.cnt.tot.tel < 1 ) ){
											$('#".$__id_fm."').removeClass('__sch');
										}else{
											$('#".$__id_fm."').addClass('__sch_rdy');
										}
										*/
										
										$('#".$__id_fm."').addClass('__sch_rdy');
										$('#".$__id_fm."_sch_rsl').addClass('__wht');
										
										
										$('#sch_cnt').val('ok');
										
										$( $('#mdl_gen_slc_".$__id_rnd."') ).appendTo('#".$__id_fm."_sch_rsl ._mdl');
										$('#Cnt_Doc".$__id_rnd."').val( _vl_sch );
										
									}else{
										
										console.log('Enter 4');
										
										$('#".$__id_fm."').removeClass('__sch');
										
									}
								
								}catch(e) {
									
									SUMR_Main.log.f({ t:'Error en las validaciones:', m:e });
									
								}	
	
								SUMR_Fm.f.rsz();
							}	
						},
						_cm:function(r){ _this.removeClass('on'); },
						_w:function(r){
							if(!isN(r)){ 
								
							}
						}
					});
				
				}
			
			}
					
		});
		
		
	
		$('#Cnt_Sch_Sve".$__id_rnd."').off('click').click(function(e){ 

			e.preventDefault();
		
			if(e.target != this){
		       e.stopPropagation();
			   return;
			}else{
				SUMR_Fm.f.snd();
				/*SUMR_Fm.f.rqu({
					p:'prc',
					t:'cnt',
					d:{
						mdl: '".$__mdl_enc."',
						mdl_gen_chk: '".$_mdl_gen_chk."',
						cnt: _cnt_enc,
						tp: '_mdl_cnt'
					},
					_cl:function(r){
						if(!isN(r)){
							 
							if( !isN(r) ){
								if(r.e == 'ok'){
									
								}else{
									
								}
							}
							
						}
					}
				});*/
			}

		});


		
		
	";
	
?>

<style>
	
	._rsl ._tel, ._rsl ._eml{
		text-align: center; padding-bottom: 10px;
	}
	
	._sch ._rsl ._tel ._new span, ._tel ._new ._icn, ._eml ._new span, ._eml ._new ._icn{ cursor: pointer; }
	._sch ._rsl ._tel ._new span:Hover, ._tel ._new ._icn:Hover, ._eml ._new span:Hover, ._eml ._new ._icn:Hover{  opacity: 0.7; }
	._sch ._rsl ._tel ._new span, ._eml ._new span{ display: inline-block; font-family: Economica; }
	._sch ._rsl ._tel ._new ._icn, ._eml ._new ._icn{ background-image: url('<?php echo DMN_IMG_ESTR_SVG ?>new_black.svg'); width: 30px; height: 30px; display: inline-block; background-size: 20px; background-repeat: no-repeat; background-position: center; vertical-align: middle; }
	
	._sch ._rsl ._tel ._new #_new_tel_<?php echo $__id_rnd ?>, ._eml ._new #_new_eml_<?php echo $__id_rnd ?>{ display: none; width: 50%; margin: auto; }
	._sch ._rsl ._tel ._new._new_tel #_new_tel_<?php echo $__id_rnd ?>, ._eml ._new._new_eml #_new_eml_<?php echo $__id_rnd ?>{ display: block; }
	._sch ._rsl ._tel > ._icn{ background-image: url('<?php echo DMN_IMG_ESTR_SVG ?>tel.svg'); width: 30px; height: 30px; display: inline-block; background-size: 20px; background-repeat: no-repeat; background-position: center; vertical-align: middle; }
	
	._sch ._rsl ._eml > ._icn{ background-image: url('<?php echo DMN_IMG_ESTR_SVG ?>eml.svg'); width: 30px; height: 30px; display: inline-block; background-size: 20px; background-repeat: no-repeat; background-position: center; vertical-align: middle; }
	
	._sch ._rsl ._tel ._all, ._rsl ._eml ._all{ margin-top: 10px; }
	
	._sch ._rsl ._tel ._all span, ._rsl ._eml ._all span{ display: block; font-size: 12px; }
	
	._sch ._rsl ._tel h3, ._rsl ._eml h3{ font-family: Economica; display: inline-block;  vertical-align: middle; }
	
	._sch ._rsl ._mdl{ width: 60%; margin: auto; }
	
</style>
