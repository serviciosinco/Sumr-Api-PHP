<?php
	      
	$CntJV .= "	
			
			function SgnD(i){ if(!isN(i)){ return _sgns['dt'][i]; }else{ return false; } }
			function SgnS(i,c){ if(!isN(i) && !isN(c)){ _sgns['dt'][i] = c; } }
			function SgnLsS(i,c){ _sgns['ls'][i] = c; }
			
			function Sgn_DomRbld(){

			

				$('.sgn_tt').off('blur').blur(function(){
					if( !isN($(this).val().trim()) ){
					    var _enc = $(this).attr('autocomplete');
					   
					    if(SgnD(_enc).nm != $(this).val().trim()){
						    _Sgn_Mod({ '_enc':_enc, '_tt':$(this).val() });
					    }
					}
				});
				
				$('.sgn_tt').off('keyup').keyup(function(e) {
					if(e.which==13){
					    if( !isN($(this).val().trim()) ){
						    var _enc = $(this).attr('autocomplete');
						    
						
						    
						    if(SgnD(_enc).nm != $(this).val().trim()){
							    _Sgn_Mod({ '_enc':_enc, '_tt':$(this).val() });
						    }
						}
					}
				});
				
				function _Sgn_Mod(p){
					Sgn_Rqu({
				    	_tp:'_mod_sgn', 
				    	_tt:p._tt,
				    	_enc:p._enc,
						_cl:function(_r){ } 
					});
				}
				
				$('.__opc_sgn .eli').off('click').click(function(){
					
					
					var _id = $(this).parent().parent().parent().attr('rel');
					
					swal({
						title: '".TX_ETSGR."',              
						text: '".TX_DLTCLMN."!',  
						type: 'warning',                        
						showCancelButton: true,                 
						confirmButtonClass: 'btn-danger',       
						confirmButtonText: '".TX_YESDLT."',      
						confirmButtonColor: '#E1544A',          
						cancelButtonText: '".TX_CNCLR."',           
						closeOnConfirm: true
					}, function (e) {
						
							Sgn_Rqu({
						    	_tp:'_eli_sgn',
						    	_id: _id,
								_cl:function(_r){
							 		if(!isN(_r)){
								 		if(_r.e == 'ok'){
								 			$('._sgn_'+_id).remove();				
								 		}
							 		}
								}
							});					
									  
					});		
				});
				
				$('.__opc_sgn .edt').off('click').click(function(){
					
					var __enc_sgn = $(this).parent().parent().parent().attr('rel');
					
					$('._sgn_mod .atr .btn_atr').off('click').click(function(){
						$('._sgn_mod._anm.ok').removeClass('ok');
						$('._sgn_add').show();
					});
					
					$('._sgn_mod_vst .atr .btn_atr').off('click').click(function(){
						$('._sgn_mod_vst._anm.ok').removeClass('ok');
					});
					
					console.log(SgnD(__enc_sgn));
					
					if(isN(SgnD(__enc_sgn).sgn)){
						$('.orv_sgn').addClass('ok');
						$('._sgn_opc').addClass('ok');
						Sgn_Asig({_enc:__enc_sgn});	
					}else{
						$('._sgn_mod').addClass('ok');
				 		$('.orv_sgn').removeClass('ok');
						$('._sgn_opc').removeClass('ok');
						enc_1 = SgnD(__enc_sgn).sgn_asg.enc;
						
						Sgn_Rqu({
					    	_tp:'_shw_sgn', 
					    	_enc:enc_1,
					    	__id_cod:__enc_sgn,
							_cl:function(_r){
						 		if(!isN(_r)){
							 		if(_r.e == 'ok'){
								 		$.each(_r._dt, function(k, v) { SgnLsS(v.enc, v); });
								 			
								 		$('._sgn_cnt').html(_r.cd);
								 		
								 		$('.btn_vtp').off('click').click(function(){
									 		$('._sgn_mod_vst').addClass('ok');
									 		$('._sgn_mod_vst.ok ._sgn_vst').html('');
									 		$('._sgn_mod_vst.ok ._sgn_vst').html(_r.cd1);
								 		});
								 			
								 		$('._tt').off('click').click(function(){
									 		
									 		var id = $(this).parent().attr('id');
									 		$('input').remove();
									 		$('._tt').removeClass('no');
											$('._c_p').removeClass('on_edit'); 

											$('#'+id).addClass('on_edit');
											SUMR_Ec.cmz.edit.mre();
									 		
									 		if($('#'+id+' ._tt').hasClass('val_0')){ 
										   		_tp_s = 'ins_sgm';
										   		$('#'+id).append('<input type=\"text\" value=\"\">');
										   	}else if($('#'+id+' ._tt').hasClass('val_1')){ 
										   		_tp_s = 'upd_sgm';
										   		var __html_sgn = $('#'+id+' ._tt').html();
										   		$('#'+id).append('<input type=\"text\" value=\"'+__html_sgn+'\">');
										   	}
										   	
										   	$('#'+id+' ._tt').addClass('no');
										   	$('#'+id+' input').focus();
 	
										   	$('#'+id+' input').off('blur').blur(function(){
											   	$('input').remove();
														$('._tt').removeClass('no');
														$('#'+id).removeClass('on_edit');
														SUMR_Ec.cmz.edit.lss();
												if( !isN($(this).val().trim()) ){
													if($(this).val().trim() != $('#'+id+' ._tt').html()){	
														Sgn_Rqu({
															_tp: _tp_s, 
															_id: id,
															_enc: __enc_sgn,
															_vle: $(this).val(),
															_cl:function(_r){
																if(!isN(_r)){ 
																	$('#'+id+' ._tt').html(_r.vl)			
																}
															}
														});
													}  
												}	
											});
											
											$('#'+id+' input').off('keyup').keyup(function(e) {
												if(e.which==13){
													$('input').remove();
															$('._tt').removeClass('no');
															$('#'+id).removeClass('on_edit');
															SUMR_Ec.cmz.edit.lss();
													if( !isN($(this).val().trim()) ){
														if($(this).val().trim() != $('#'+id+' ._tt').html()){	
															Sgn_Rqu({
																_tp: _tp_s, 
																_id: id,
																_enc: __enc_sgn,
																_vle: $(this).val(),
																_cl:function(_r){
																	if(!isN(_r)){ 
																		$('#'+id+' ._tt').html(_r.vl)			
																	}
																}
															});
														} 
													}
												}
											});
										});					 		
								 	}	
						 		}
							} 
						});		
					}
				});
				
				function Shw_Asg(){
					
					
					
				}
				
				$('._sgn_new').off('click').click(function(){
					swal({
					  title: '".TX_NM."',
					  text: '".TX_INGRNMFRM."',
					  type: 'input',
					  showCancelButton: true,
					  cancelButtonText: '".TX_CNCLR."',
					  confirmButtonText: '".TXBT_GRDR."', 
					  closeOnConfirm: true,
					  inputPlaceholder: '".TX_NMFRMA."'
					}, function (e) {
						if (e === false) return false;
						if (isN(e.trim())) {
							swal.showInputError('".TX_NMBNPDVC."');
							return false
						}else{
							Sgn_Rqu({
						    	_tp:'_new_sgn', 
						    	_tt:e,
								_cl:function(_r){
							 		if(!isN(_r)){
								 		if(_r.e == 'ok'){
									 		$('.orv_sgn').addClass('ok');
									 		$('._sgn_opc').addClass('ok');
									 		_sgns['ls'] = {};

									 		$.each(_r._dt, function(k, v) { SgnLsS(k, v); });	
											SgnDsh_Bld();
											Sgn_Asig({_enc:_r.enc});	
								 		}
							 		}
								}
							});					
						}				  
					});	
				});
				
				$('.x').off('click').click(function(){
					$('.orv_sgn').removeClass('ok');
					$('._sgn_opc').removeClass('ok');	
				});
				
			}
			
			function Sgn_Asig(p=null){
				$('.opc_s').off('click').click(function(){							
					var __dt = $(this).attr('id');
					Sgn_Rqu({
				    	_tp:'_asg_sgn', 
				    	_sgn: p._enc,
				    	_id_sgn: __dt,
						_cl:function(_r){
					 		if(!isN(_r)){
						 		if(_r.e == 'ok'){
							 		
							 
							 		
						 			$.each(_r._dt1, function(k, v) { SgnLsS(v.enc, v); SgnS(v.enc, v); });
							 		$('._sgn_mod').addClass('ok');
							 		$('.orv_sgn').removeClass('ok');
									$('._sgn_opc').removeClass('ok');
									$('._sgn_new, ._sgn_add').hide();
									$('._sgn_'+p._enc+' ._opc_sgn_no').addClass('_opc_sgn_ok').removeClass('_opc_sgn_no');

										
										
									$('._sgn_cnt').html(_r.cd);	
									$('.btn_vtp').off('click').click(function(){
								 		$('._sgn_mod_vst').addClass('ok');
								 		$('._sgn_mod_vst.ok ._sgn_vst').html('');
								 		$('._sgn_mod_vst.ok ._sgn_vst').html(_r.cd1);
								 		$.each(_r._dt1, function(k, v) { SgnLsS(v.enc, v); SgnS(v.enc, v); });
							 		});
									
						 		}
						 	}
						}
					});	
				});
			}
			
			function Sgn_Rqu(p=null){
				if (SUMR_Main.onl() && isN( SUMR_Main.ibx['sgn_rq'] ) ){
						try{
							SUMR_Main.ibx['sgn_rq'] = $.ajax({
													type:'POST',
													url: '".Fl_Rnd(FL_JSON_GN.__t('sgn_cod',true))."',
													data: p,
													beforeSend: function() {
														if(!isN(p._bs)){ p._bs(); }
										 			},
										 			error:function(e){
											 			if(!isN(p._w)){ p._w(e); }
										 			},
													success:function(e){	
														SUMR_Main.ibx['sgn_rq'] = '';
														if(!isN(e.w)){ swal('Error!', e.w, 'error');  }
														if(!isN(p._cl)){ p._cl(e); }
													},
													complete:function(e){
														SUMR_Main.ibx['sgn_rq'] = '';
													}
												});	
						}catch(e) {
							SUMR_Main.log.f({ t:'Error sa', m:e });
						}					
				}
			}
			
			
			function Sgn_Add_Html(p){
				try{
					if(!isN(p) && !isN(p.enc)){
						if(SgnD(p.enc).sgn){ var n_sgn = '<div class=\"_opc_sgn_ok\"></div>'; }else{ var n_sgn = '<div class=\"_opc_sgn_no\"></div>'; }
						
						var __opc_sgn = '<div class=\"__opc_sgn\"><div class=\"edt\"></div><div class=\"eli\"></div></div>'; 
						
						var _v = SgnD(p.enc);
						var _html = '
				 			<div class=\"_sgn _sgn_'+p.enc+'\" rel=\"'+p.enc+'\">
									'+n_sgn+'	
								<div class=\"_sgn_img\"> '+__opc_sgn+' </div>
								<div class=\"_sgn_txt\">".HTML_inp_tx("sgn_tt_'+p.enc+'", '', "'+SgnD(p.enc).nm+'", '', '', "sgn_tt", "", "'+p.enc+'")."</div>
							</div>
				 		';
				 		$('._sgn_add').append(_html);
				 		Sgn_DomRbld();
					}
				}catch(e) {
					SUMR_Main.log.f({ t:'Error en Sgn_Add_Html: ', m:e });
				}
			}
		
	
	";
	
	$CntWb .= "
		
			Sgn_DomRbld(); 
		
	";
?>