<?php Hdr_HTML(); ?>
<!DOCTYPE HTML>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<title><?php echo $__head_tt; ?></title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<base href="/" target="_blank">
		<style>
			<?php include(DIR_INC.'css/hd.css'); ?>
	
			:root {
		    
			    --font-s-prgddr: <?php echo $__cl->tag->clr->main->v; ?>;
			}
			
			.tooltiptext{ background-color: var( --font-s-prgddr); }
			
		</style>
	</head>
	<body class="<?php echo $_bdcss; if(!isN($__fm_thm)){ echo $__fm_thm; } ?>">
		<header>
			<nav><ul><li></li></ul></nav>
		</header>
		<section>
			<div class="_prld _anm"></div>
			
			<?php if($__pm_2 == 'anx'){

				include(DIR_CNT."anx.php");
				
			}else{ ?>
				<?php $___fm = $__Forms->ApplFm_Ls(); ?>
				<?php include(DIR_CNT."fm.php"); ?>		
			<?php } ?>
			
			
		</section>
		<footer></footer>
	</body>
</html>
<script type="text/javascript">
	
	<?php $___font = __font(); ?>
	
	<?php if(!isN($___font->js->string)){ ?> 

		var WebFontConfig = {  google: {families: <?php echo $___font->js->string; ?> },  timeout: 2000  };
			
	<?php } ?>

	var __ldsnd={};
	
	function __snd(p=null){
		
		if(!SUMR_Ld.f.isN(p) && !SUMR_Ld.f.isN(p.t) && !SUMR_Ld.f.isN(p.d)){
			if (SUMR_Ld.f.onl() && isN( __ldsnd[p.t] ) ){
				
				if(!SUMR_Ld.f.isN(p.p) && p.p == 'sch'){ var _u = 'search'; }else if(!SUMR_Ld.f.isN(p.p)){ var _u = p.p; }else{ var _u = 'process'; }
				
				__ldsnd[p.t] = $.ajax({
									type:'POST',
									url: '/<?php echo $__cl->sbd; ?>/'+_u+'/',
									data: p.d,
									dataType: 'json',
									beforeSend: function() {
										if(!SUMR_Ld.f.isN(p._bs)){ p._bs(); }
						 			},
						 			error:function(e){
							 			if(!SUMR_Ld.f.isN(p._w)){ p._w(e); }
						 			},
									success:function(e){	
										if(!SUMR_Ld.f.isN(p._cl)){ p._cl(e); }
									},
									complete:function(e){
										__ldsnd[p.t] = '';
										if(!SUMR_Ld.f.isN(p._cm)){ p._cm(e); }
									}
							});							
			}
		}
	}	
	
	function SUMR_Main.ld.f.knob(_c){
		
		SUMR_Ld.f.js({ 
			u:'<?php echo DMN_JS ?>uploadnew/jquery.knob.js',
			c:function(){ 
				if(!SUMR_Ld.f.isN(_c)){ _c(); }	 
			}
		});
	}
	
	function SUMR_Main.ld.f.upl(_c){
    	SUMR_Main.ld.f.knob( function(){
	    	SUMR_Ld.f.css({ 
				t:'p',
		    	h:'<?php echo DMN_CSS; ?>uploadify.css',
		    	c:function(){ 	
				    SUMR_Ld.f.css({ 
						t:'p',
				    	h:'<?php echo DMN_CSS; ?>jquery.upload.css',
				    	c:function(){
					    	SUMR_Ld.f.js({ 
						    	
						    	u:'<?php echo DMN_JS ?>uploadnew/jquery.ui.widget.js',
								c:function(){ 
									
									
									SUMR_Ld.f.js({ 
										u:'<?php echo DMN_JS ?>uploadnew/jquery.iframe-transport.js',
										c:function(){
											SUMR_Ld.f.js({ 
												u:'<?php echo DMN_JS ?>uploadnew/jquery.fileupload.js',
												c:function(){
													SUMR_Ld.f.js({ 
										
														u:'<?php echo DMN_JS ?>jquery.Jcrop.min.js',
														c:function(){
										
															if(!SUMR_Ld.f.isN(_c)){ _c(); }
															
														}
										
													});
												}		
											});	
										}
									});
								}	
					    	});
				    	}		
					});	
		    	}
	    	});	
		});
	}
	
	function __ld_all(){
		
		SUMR_Ld.f.js({
			
			t:'c',
			u:'jquery.js',
			c:function(){
		        
		        $('body').addClass('SUMR_Form');
		        
		        SUMR_Ld.f.js({ 
					t:'c',
			        u:'jquery-ui.js',
			        c:function(){
				        
				        <?php if(!isN($__fm_thm)){ $__url_thm = '?_thm='.$__fm_thm; } ?>
  
				        SUMR_Ld.f.css({ 
							
							t:'p',
					        h:'/css/base/<?php echo $__url_thm; ?>',
					        c:function(){ 
				                	
				                $('body').addClass('on');
				                		
					    		$(document).ready(function(){
									<?php echo $_CntJQ_Vld; ?>
									<?php echo $_CntJQ; ?>
									SUMR_Main.ld.f.upl( function(){ <?php echo $CntWb ?> });
									
		
						            SUMR_Ld.f.js({
							            u:'https://ajax.googleapis.com/ajax/libs/webfont/1/webfont.js',
							            c:function(){
								            
								            SUMR_Ld.f.js({
									            u:'https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.11.0/jquery.validate.min.js',
									            c:function(){
										        	
										        	SUMR_Ld.f.js({ u:'<?php echo DMN_JS ?>sweetalert.js' });
														
										        	SUMR_Ld.f.js({
														u:'https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.full.min.js', 
														c:function(r){ 
															
															if(!SUMR_Ld.f.isN(r)){
																
																if(!SUMR_Ld.f.isN(r.isTrusted) && r.isTrusted){
																	
																	if (jQuery.fn.select2) {
																		
																		$.validator.messages.required = "Obligatorio"; 
																		$.validator.messages.email = "Formato erroneo"; 
																		$.validator.messages.digits = "Debe ser numero"; 
													        	
																		
																		SUMR_Ld.f.css({ t:'p', h:'https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/css/select2.min.css' });
																		SUMR_Ld.f.css({ t:'p', h:'<?php echo DMN_CSS; ?>ui/jquery-ui-all.css' });
																		SUMR_Ld.f.css({ t:'p', h:'<?php echo DMN_CSS; ?>sweetalert.css' });
																		<?php echo $_CntJQ_S2; ?>
																		
																		
																		
																	}else{
																		
																		console.log('No select2 library');
																		
																	}
																
																}else{
																	
																	console.log('No trusted library');
																	
																}
																
															}
														}   
												    });
									            }
								            });	 
									    }	    
								    });
								});
							
					            $(window).on('load',function(){
					                   
					            });    
				            }                                     
				        });
				        
			        }
			    });
      
			}
		});		
	}
		
</script>
<script type="text/javascript" src="<?php echo DMN_JS ?>_ld.js<?php if(Dvlpr()){ echo '?__r='.Enc_Rnd('r'); } ?>" async></script>