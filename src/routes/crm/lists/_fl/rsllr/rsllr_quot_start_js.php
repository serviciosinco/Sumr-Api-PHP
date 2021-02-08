<?php 					
						
	$CntWb .= "
	
		var _bx_hdr = $('#".$___Ls->id_hdr."');
		var _bx_main = $('#quote_start');
		var _bx_stps = $('#quote_start_steps');
		var _bx_isch = $('#quote_start_isch');
		var _bx_isch_org = $('#quote_start_sch_org');
		
		
		function IschOrg_Rst(){
			_bx_isch_org.html('<div id=\"__grph_crsl_org_".$___Ls->id_rnd."\" class=\"owl-carousel org-found owl-theme _anm\"></div>');	
		}
										
		function __ld_org_owl(p){	
			
			SUMR_Main.ld.f.owl( function(){
				
				if(!isN(p) && !isN(p.ls)){
						
					$('#__grph_crsl_org_".$___Ls->id_rnd."').owlCarousel({
						autoPlay:true,
						autoplayHoverPause: true,
						items:4,
						margin:5,
						nav: true
					});
					
					
					$.each(p.ls, function(_k, _v) {
																					
						var _bck_url='';
						var _tp_icn='';
						
						if(isN(_v.img)){ 
							var _cls='_non'; 
						}else{ 
							var _cls=''; 	
							if(!isN(_v.img.th_200)){
								var _bck_url = ' background-image:url('+ _v.img.th_200 + ');  ' ;
							}
						}
						
						if(!isN(_v.tp)){
							
							$.each(_v.tp, function(_tp_k, _tp_v) {
								if(!isN(_tp_v.tt)){
									if(!isN(_tp_v.img)){ var _img = _tp_v.img; }else{ var _img = ''; }
									_tp_icn = _tp_icn+'<li style=\"background-image:url('+_img+');\" title=\"'+_tp_v.tt+'\">'+_tp_v.tt+'</li>';
								}
							});
							
						}
						
						$('#__grph_crsl_org_".$___Ls->id_rnd."').owlCarousel('add', '
							<div class=\"item renc _anm _opt no-draggable-area\" data-enc=\"'+_v.enc+'\" title=\"'+_v.tt+'\" alt=\"'+_v.tt+'\">
								<div class=\"_bx\">
									<figure class=\"_anm '+_cls+'\">
										<img style=\"'+_bck_url+'\">
										<div class=\"_anm _tp\"><ul>'+_tp_icn+'</ul></div>
									</figure>
									<h2>'+_v.tt+'
										<span class=\"_sds\">Sede '+_v.sds+'</span>
										<span class=\"_cd\">'+_v.cd+'</span>
									</h2>
									
								</div>
							</div>																				
						').owlCarousel('update');
						 
						
					});	
					
					Quot_DomRbld();															
				
				}

			});
		
		}	
		
		
								
		
		function SchOrg(){
			
			IschOrg_Rst();
			
			var _vl = $('#quot_org_sch').val();
				
			if(!isN(_vl) && _vl.length > 3){

            	_Rqu({ 
                	
					t:'rsllr_sch_org', 
					__q:_vl,
					_bs:function(){ _bx_main.addClass('__ld'); },
					_cm:function(){ _bx_main.removeClass('__ld'); },
					_cl:function(d){
						
						if(!isN(d)){
							
							try{
								
								if(!isN(d.ls)){
									_bx_main.addClass('mny');
									$.colorbox.resize({ height:'390' });
									__ld_org_owl({ ls:d.ls });
								}
                           
							}catch(e) {
								
								SUMR_Main.log.f({ t:'Error en _Rqu :', m:e });
								
							}
                            
						}
					} 
				});
	
			}else{
				
				console.log('No value for search');
				
			}
					
					
		}
		
		
		function Quot_DomRbld(){
			
				
			$('#quote_start_sch').off('click').click(function(e){	
				_bx_main.addClass('sch');
				$.colorbox.resize({ height:'250' });
				IschOrg_Rst();	
			});
			
			
			$('#quote_start_sve').off('click').click(function(e){			
				_bx_main.addClass('sve');
				$.colorbox.resize({ height:'250' });	
			});
			
			
			
			$('#quote_start_isch_btn').off('click').click(function(e){
				
				e.preventDefault();
				
				if(e.target != this){
					
			    	e.stopPropagation(); return;
			    	
				}else{
					
					SchOrg();
					
				}	
				
			});
			
			
			$('#quot_org_sch').on('keyup', function (e) {
				e.preventDefault();
				
				if(e.keyCode == 13){
			    	SchOrg();
			    }
			    
			});
							
							
			
			
			$('#__grph_crsl_org_".$___Ls->id_rnd." .item.renc').off('click').click(function(e){ 
														
				e.preventDefault();
				
				if(e.target != this){ 
					
			    	e.stopPropagation(); return false;
			    	
				}else{
					
					var __id = $(this).attr('data-enc');
					
					$('#quot_org').val(__id);
					$('#quote_start_sch').removeClass('on').addClass('scss');
					$('#quote_start_sve').removeClass('off').addClass('on');
				
					_bx_main.removeClass('sch mny').addClass('step-2');
					$.colorbox.resize({ height:'300' });
				}
															
			});
		
		
		}
		
		
		Quot_DomRbld();
		
		_bx_hdr.hide();
		
				
	";
	
	
	
?>