<?php 
	
if(class_exists('CRM_Cnx')){



$__bdtp = 'mdl_s_tp_cl'; 
$__fmtp = 'EdMdlTpCl';

$__id_div_act = 'Act_All_Rlc_'.Gn_Rnd(10);
$__id_div_psb = 'Psb_All_Rlc_'.Gn_Rnd(10);
$__get_ls_btn = '__get_ls_btn'.Gn_Rnd(10);
?>
	
<div class="ln_1">
	
    <div class="col_1 __rlc_e on" id="<?php echo $__id_div_act ?>">
            <?php echo h1(TX_SLCTD); ?>
			<?php echo $__li_act['tt'].ul('<div class="__ovly_w"></div>', '__cl_ls'); ?>
        	
    </div>
    <div class="col_2 __rlc_e off" id="<?php echo $__id_div_psb ?>">
          
            <?php echo h1(TX_DSPN); ?>
			<?php echo $__li_psb['tt'].ul('<div class="__ovly_w"></div>', '__cl_ls'); ?>
			
			 <?php 
											
					

					$CntWb .= '	$(".__btn_dwn").colorbox();
								$(".__rlc_i.off h1").hover( function() { $("#__get_ls").focus(); } ); 
								
								
								__getJs({});
								__getJs({_t:"r"});
					';
					
					$CntJV .=	"
							
							__set_clr_bck = '';
							__set_clr_fnt = '';
							__set_enc_id = '';

					       	
					       	function __fntcl_rbldom(){
			       	
					       		$('.__cl_item ._opt button').not('._add').off('click').on('click', function(e){ 
									
									e.preventDefault();
									
									
									__set_clr_bck = $(this).attr('clr-bck');
									__set_clr_fnt = $(this).attr('clr-fnt');
									__set_enc_id = $(this).attr('enc-id');
									
									$('#clfntr_clr_fnt').val( __set_clr_fnt );
									$('#clfntr_clr_bck').val( __set_clr_bck );
										
									var position = $(this).offset();
									
									$('.__cl_slc .more_opt ._bx').offset({	
										left: (position.left+10),
										top: (position.top+35)	
									});
									
									$('.__cl_slc .more_opt').addClass('_on');
									
										
								});
								
								
								$('.__cl_slc .more_opt ._ovr').off('click').on('click', function(e){	
									
									$('.__cl_slc .more_opt').removeClass('_on');
									
									__g_clr_fnt = $('#clfntr_clr_fnt').val(); 
									__g_clr_bck = $('#clfntr_clr_bck').val();
											
									if( __set_clr_fnt != __g_clr_fnt || __set_clr_bck != __g_clr_bck ){ 
										
										__set_clr_fnt = $('#clfntr_clr_fnt').val(); 
										__set_clr_bck = $('#clfntr_clr_bck').val();
										
										__fntcl_rqu({
											'MMR_attr':'EdFntCl',
					   						__enc:__set_enc_id,
					   						__bck:__set_clr_bck,
					   						__fnt:__set_clr_fnt,
					   						_cl:function(e){
						   						if(!isN(e)){ 
						   							
						   							$('[enc-id=\"'+__set_enc_id+'\"]').attr('clr-fnt', __set_clr_fnt);
						   							$('[enc-id=\"'+__set_enc_id+'\"]').attr('clr-bck', __set_clr_bck);
									
						   						}
					   						},
					   						_bf:function(){
					   							$('[rlc-id=\"'+__set_enc_id+'\"]').addClass('__ld');
					   						},
					   						_cmp:function(e){
						   						$('[rlc-id=\"'+__set_enc_id+'\"]').removeClass('__ld');
					   						}
										});
										
									}						   						
									
								});

					       	}
					       	
						   	function __fntcl_rqu(p=null){

								if (SUMR_Main.onl() && isN( SUMR_Main.ibx['fnt_cl'] ) ){
									
									SUMR_Main.ibx['fnt_cl'] = $.ajax({
															type:'POST',
															dataType: 'json',
															url: '".Fl_Rnd(PRC_GN.__t($__bdtp,true))."',
															data: p,
															beforeSend: function() {
																if(!isN(p._bf)){ p._bf(); }
												 			},
												 			error:function(xhr, ajaxOptions, thrownError){

												 			},
															success:function(e){
																if(!isN(p._cl)){ p._cl(e); }
															},
															complete:function(e){
																SUMR_Main.ibx['fnt_cl'] = '';
																if(!isN(p._cmp)){ p._cmp(e); }
															}
														});							
								}
							}
		
		
							
							function __getJs(_v){
									
									if(_v === undefined) { _v = false; }
									
									var __s = $('#__get_ls').val();
									if(__s != undefined && _v._t != 'r'){ var ___s = __s; }else{ ___s = ''; }	

										
									if(_v._t == 'r'){ 
										var __in_e = 'ok'; var __add_t = 'r'; 
										
										var __u = $('#{$__id_div_act} > ul');
										var __l = $('#{$__id_div_act} > ul li');
									}else{ 
										var __in_e = ''; var __add_t = 'a'; 
										var __s = $('#__get_ls').val();
										var __u = $('#{$__id_div_psb} > ul');
										var __l = $('#{$__id_div_psb} > ul li');
									}
									
									__u.addClass('__ld');
									
                               		$.post('".Fl_Rnd(FL_JSON_GN.__t($__bdtp,true))."', { 
                               			sch: ___s, 
                               			mdlstp:'"._SbLs_ID('i')."', 
                               			in:__in_e 
                               		},
                                    function(d, status){
	                                    
                                        __l.remove();
                                        
                                        if(d.e == 'ok'){
                                            

                                            if( d.us_cl.total > 0 ){
	                                            $.each(d.us_cl.list, function(_k, _v) { 
	                                           		__AddItm({ __t:__add_t, 
															   __i:_v.id,
															   __tt:_v.tt,
															   __enc:_v.enc,
															   __clr:_v.clr,
															   __prc:'us_cl',
															   __fnt:_v.fnt
											 	    });	
	                                            });
												
												__fntcl_rbldom(); 
                                            }
                                            
                                        }  
                                    });
                                    
                                    __u.removeClass('__ld');
	                                __fntcl_rbldom();   
                                    
                            }
                                            
                            
                                            
							
							function __AddItm(__v){
								
								if(__v.__t == 'a'){ 
		                   			var __li_id = 'Psb_'+__v.__prc+'_'+__v.__enc;
		                   			var _Uli = '{$__id_div_psb}';
		                   			var _b_c = 'add';
		                   		}else if(__v.__t == 'r'){ 
		                   			var __li_id = 'Act_'+__v.__prc+'_'+__v.__enc; 
		                   			var _Uli = '{$__id_div_act}';
		                   			var _b_c = 'rmv';
		                   		}
								
								if(__v.__sl){ var __cls_sl = '__slok'; }else{ var __cls_sl = ''; }
								
								if(!isN(__v.__fnt) && !isN(__v.__fnt.clr) && !isN( __v.__fnt.clr.bck) ){ 
									fnt_clr_bck = __v.__fnt.clr.bck 
								}else{
									fnt_clr_bck = '';
								}
								
								if(!isN(__v.__fnt) && !isN(__v.__fnt.clr) && !isN( __v.__fnt.clr.fnt) ){ 
									fnt_clr_fnt = __v.__fnt.clr.fnt 
								}else{
									fnt_clr_fnt = '';
								}
								
								
								if(!isN(__v.__fnt) && !isN(__v.__fnt.enc)){ 
									fnt_enc = __v.__fnt.enc
								}else{
									fnt_enc = '';
								}
								
								
								var __h = '<li id=\"'+__li_id+'\" class=\"__cl_item '+ __cls_sl +' '+ _b_c +'\" style=\"background-color:'+ __v.__clr +'\" rlc-id=\"'+ fnt_enc +'\">
													<div class=\"_opt\">
														<button type=\"button\" class=\"_add _anm '+ _b_c +'\" title=\"'+ __v.__tt +'\"  
															   onclick=\"__snd_upd({__t: \''+__v.__t+'\', 
															   						__t_prc: \''+__v.__prc+'\', 
															   						__i_rlc: \''+ __v.__i +'\', 
															   						__i_fnt: \'"._SbLs_ID('i')."\' }); \" /> 						
														</button>
													</div>
													<div class=\"_tt\">'+ __v.__tt +'</div>	   						
												
										   </li>';
								
								$('#'+ _Uli + ' > ul ').append(__h);		   
							}
							
							
							function __snd_upd(__v){
                   		
			                   		if(__v.__t == 'a'){ 
			                   			var _MM = 'MMR_insert'; 
			                   			var _IlI = 'Psb_'+__v.__t_prc+'_'+__v.__i_rlc;
			                   			var _Uli = '{$__id_div_act}';
			                   			var _t_go = 'r'; 
			                   		}else if(__v.__t == 'r'){ 
			                   			var _MM = 'MMR_delete'; 
			                   			var _IlI = 'Act_'+__v.__t_prc+'_'+__v.__i_fnt; 
			                   			var _Uli = '{$__id_div_psb}';
			                   			var _t_go = 'a'; 
			                   		}
			                   		
			                   		var __id_o = $('#'+_IlI); 
					                var __id_h = __id_o.html(); 
					                
					                __id_o.addClass('__ld');
					                			                   		
			                   		$.post('".Fl_Rnd(PRC_GN.__t($__bdtp,true))."',{
				                            id_tp: __v.__i_fnt,
				                            id_rlc: __v.__i_rlc,
				                            tp_prc: __v.__t_prc,
				                            [_MM]: '{$__fmtp}' 
				                        },
				                        function(d, status){
				                            if(d.e == 'ok'){
												__id_o.remove();
											 	__getJs({_t:'r'});
											 	__getJs({});
				                              	StTm_Est({ e:d.m });
				                              	 	   
				                            }
											
											__id_o.removeClass('__ld');		
				                            
			                        });
			                }
			         		
			         		
			         		
			         		       
			                
			       ";
				?>
    </div>
      
    
</div>
<?php } ?>
