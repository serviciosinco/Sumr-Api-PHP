<?php 
if(class_exists('CRM_Cnx')){

$__lssb = _SbLs();
$__bxrld = _BxRld_ID();
$__bdtp = $__prfx->tp.'_atmt_trgr_sgm'; // Tipo de Datos
$__fmtp = 'EdEcAutoTrgrSgm'; // Nombre Formulario

$__id_div_act = 'Act_All_Rlc_'.Gn_Rnd(10);
$__id_div_psb = 'Psb_All_Rlc_'.Gn_Rnd(10);
?>
	
<div class="ln_1">
    <div class="col_1 __rlc_e on" id="<?php echo $__id_div_act ?>">
            <?php echo h1(TX_SLCTD); ?>
			<?php echo $__li_act['tt'].ul('<div class="__ovly_w"></div>'); ?>
        	
    </div>
    <div class="col_2 __rlc_e off" id="<?php echo $__id_div_psb ?>">
            <?php $__div_sch = '<div class="__bx_sch"> <input type="text" name="__get_ls" id="__get_ls" placeholder="" class="required" >  <input type="button" name="__get_ls_btn" id="__get_ls_btn" value="Enviar" > </div>'; ?>
            <?php echo h1(TX_DSPN.$__div_sch); ?>
			<?php echo $__li_psb['tt'].ul('<div class="__ovly_w"></div>'); ?>
			
			 <?php 
											
					

					$CntWb .= '	$(".__btn_dwn").colorbox();
								$(".__rlc_i.off h1").hover( function() { $("#__get_ls").focus(); } ); 
								$("#__get_ls_btn").click(function(){ __getJs(); });
								
								
								__getJs({});
								__getJs({_t:"r"});
					';
					
					$CntJV .=	"
    
							
							
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
									
                               		$.post('".Fl_Rnd(FL_JSON_GN.__t($__prfx->tp.'_atmt_trgr_sgm',true))."', { sch: ___s, trgr:"._SbLs_ID('i').", in:__in_e },
                                    function(d, status){
	                                    
                                        __l.remove();
                                        
                                        if(d.e == 'ok'){
                                            

                                            if( d.sgm.total > 0 ){
	                                            $.each(d.sgm.list, function(_k, _v) { 
	                                           		__AddItm({ __t:__add_t, 
															   __i:_v.id,
															   __tt:_v.tt,
															   __clr:_v.clr,
															   __prc:'pro'
											 	    });	
	                                            });
                                            }
                                            
                                        }  
                                    });
                                    
                                    __u.removeClass('__ld');
	                                   
                                    
                            }
                                            
                            
                                            
							
							function __AddItm(__v){
								
								if(__v.__t == 'a'){ 
		                   			var __li_id = 'Psb_'+__v.__prc+'_'+__v.__i;
		                   			var _Uli = '{$__id_div_psb}';
		                   			var _b_c = 'add';
		                   		}else if(__v.__t == 'r'){ 
		                   			var __li_id = 'Act_'+__v.__prc+'_'+__v.__i; 
		                   			var _Uli = '{$__id_div_act}';
		                   			var _b_c = 'rmv';
		                   		}
								
								if(__v.__sl){ var __cls_sl = '__slok'; }else{ var __cls_sl = ''; }
								
								var __h = '<li id=\"'+__li_id+'\" class=\"'+ __cls_sl +' '+ _b_c +'\">
													<input style=\"background-color:'+ __v.__clr +'\"
														   type=\"button\" class=\"'+ _b_c +'\" title=\"'+ __v.__tt +'\" value=\"'+ __v.__tt +'\" 
														   onclick=\"__snd_upd({__t: \''+__v.__t+'\', 
														   						__t_prc: \''+__v.__prc+'\', 
														   						__i_rlc: \''+ __v.__i +'\', 
														   						__i_trgr: \'"._SbLs_ID('i')."\' }); \" />
												
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
			                   			var _IlI = 'Act_'+__v.__t_prc+'_'+__v.__i_trgr; 
			                   			var _Uli = '{$__id_div_psb}';
			                   			var _t_go = 'a'; 
			                   		}
			                   		
			                   		var __id_o = $('#'+_IlI); 
					                var __id_h = __id_o.html(); 
					                
					                __id_o.addClass('__ld');
					                			                   		
			                   		$.post('".Fl_Rnd(PRC_GN.__t($__bdtp,true))."',{
				                            id_trgr: __v.__i_trgr,
				                            id_rlc: __v.__i_rlc,
				                            tp_prc: __v.__t_prc,
				                            [_MM]: '{$__fmtp}' 
				                        },
				                        function(d, status){

				                            if(d.e == 'ok'){
												
												__id_o.remove();
											 	__getJs({_t:'r'});
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

