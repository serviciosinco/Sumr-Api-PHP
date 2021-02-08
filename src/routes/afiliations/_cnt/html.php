<?php Hdr_HTML(); ob_start("compress_code"); ?>
<!DOCTYPE HTML>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<title><?php echo $__head_tt; ?></title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<base href="/" target="_blank">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<link href="<?php echo DMN_AFL; ?>inc/sty/sis.css?__c=<?php echo $__cl->enc ?>" rel="stylesheet" type="text/css">
		<style>
			<?php include(DIR_INC.'css/hd.css'); ?>

			<?php

				$__cl_tag = $__cl->tag;
				$__cl_clr = $__cl_tag->clr;

				if(!isN($__cl_clr->main->v)){ $__root_v .= ' --main-bg-color: '.$__cl_clr->main->v.'; '; }else{ $__root_v .= ' --main-bg-color:#4f006f;'; }
				if(!isN($__cl_clr->second->v)){ $__root_v .= ' --second-bg-color: '.$__cl_clr->second->v.'; '; }else{ $__root_v .= ' --second-bg-color:#de86d4; '; }

				echo '
					:root {
						'.$__root_v.'
					}
				';

	        ?>

		</style>
	</head>
	<body class="<?php echo $_bdcss; if(!isN($__fm_thm)){ echo $__fm_thm; } ?>">
		<header>
			<div class="logo"><img src="http://aplicaciones.uexternado.edu.co/asoantalumnos/images/logopeqe.jpg"/> </div>
			<div class="asoc"><img src="http://aplicaciones.uexternado.edu.co/asoantalumnos/images/asociaion.jpg"/> </div>
		</header>
		<section>
			<div class="_prld _anm"></div>
			<?php include(DIR_CNT."fm.php"); ?>
		</section>
		<footer></footer>
	</body>
</html>
<script type="text/javascript">

	"use strict";

	<?php $___font = __font(); ?>

	<?php if(!isN($___font->js->string)){ ?>

		var WebFontConfig = {  google: {families: <?php echo $___font->js->string; ?> },  timeout:2000  };

	<?php } ?>


	var __ldsnd={};
	var SUMR_Main={slc:{ sch:''}};

	function __snd(p){

		if(!SUMR_Ld.f.isN(p) && !SUMR_Ld.f.isN(p.t) && !SUMR_Ld.f.isN(p.d)){

			if(SUMR_Ld.f.onl() && isN(__ldsnd[p.t])){

				if(!SUMR_Ld.f.isN(p.p) && p.p == 'sch'){ var _u = 'search'; }else{ var _u = 'process'; }

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

	function __ld_all(){

		SUMR_Ld.f.js({

			u:'https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js',
			c:function(){

		        $('body').addClass('SUMR_Form');

		        SUMR_Ld.f.js({ u:'<?php echo DMN_JS; ?>jquery-ui.js' });


			    <?php if(!isN($__fm_thm)){ $__url_thm = '?_thm='.$__fm_thm; } ?>


		        SUMR_Ld.f.css({

					t:'p',
			        h:'/css/base/<?php echo $__url_thm; ?>',
			        c:function(){

		                $('body').addClass('on');

			    		$(document).ready(function(){
							<?php echo $_CntJQ_Vld; ?>
							<?php echo $_CntJQ; ?>

				            SUMR_Ld.f.js({
					            u:'https://ajax.googleapis.com/ajax/libs/webfont/1/webfont.js',
					            c:function(){
						            SUMR_Ld.f.js({
										u:'<?php echo DMN_JS ?>SpryTabbedPanels.js',
										c:function(r){
								            SUMR_Ld.f.js({
									            u:'https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.11.0/jquery.validate.min.js',
									            c:function(){

										            SUMR_Ld.f.js({
														u:'<?php echo DMN_JS ?>sweetalert.js',
														c:function(r){

												        	SUMR_Ld.f.js({
																u:'https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.full.min.js',
																c:function(r){

																	if(!SUMR_Ld.f.isN(r)){

																		if(!SUMR_Ld.f.isN(r.isTrusted) && r.isTrusted){

																			if (jQuery.fn.select2) {

																				$.validator.messages.required = "Obligatorio";
																				$.validator.messages.email = "Formato erroneo";
																				$.validator.messages.digits = "Debe ser numero";

																				SUMR_Ld.f.css({ t:'p', h:'<?php echo DMN_CSS ?>sweetalert.css' });


																				SUMR_Ld.f.css({ t:'p', h:'https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/css/select2.min.css' });
																				SUMR_Ld.f.css({ t:'p', h:'<?php echo DMN_CSS; ?>ui/jquery-ui-all.css' });
																				SUMR_Ld.f.js({
																					u:'<?php echo DMN_JS; ?>js.js',
																					c:function(){
																						SUMR_Ld.f.js({ u:'<?php echo DMN_JS; ?>_lng/es.js' });
																						SUMR_Ld.f.js({
																							u:'<?php echo DMN_JS; ?>jquery-ui-timepicker.js',
																							c:function(){
																								<?php echo $_CntJQ_S2; ?>
																								<?php echo $_CntJQ_Spry; ?>
																							}
																						});
																					}
																				});

																			}
																		}
																	}
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

			            $(window).on('load',function(){

			            });


		            }

		        });

			}

		});

	}



</script>
<script type="text/javascript" src="<?php echo DMN_JS ?>_ld.js<?php if(Dvlpr()){ echo '?__r='.Enc_Rnd('r'); } ?>" id="main-scrpt" data-id="<?php echo $__id_rnd; ?>"async></script>
<style>

	header{width: 600px;display: block;margin: 20px auto;position: relative;}
	header .logo{display: inline-block;vertical-align: middle;}
	header .asoc{display: inline-block;vertical-align: middle;position: absolute;right: 0;top: 15px;}

</style>

<?php ob_end_flush(); ?>