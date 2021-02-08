<?php Hdr_HTML(); ob_start("compress_code"); ?>
<!DOCTYPE html>
<html>
<head>
    <title></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<base href="/" target="_blank">
	<style>
		<?php include(DIR_INC.'css/hd.css'); ?>
	</style>
</head>
<body>
	<div class="_prld _anm"></div>
    <?php include(DIR_CNT."fm.php"); ?>
</body>
</html>
<script type="text/javascript">

	<?php $___font = __font(); ?>

	<?php if(!isN($___font->js->string)){ ?>

		var WebFontConfig = {  google: {families: <?php echo $___font->js->string; ?> },  timeout: 2000  };

	<?php } ?>


	var __ldsnd={};
	var SUMR_Main={slc:{ sch:''}};

	function __snd(p=null){

		if(!SUMR_Ld.f.isN(p) && !SUMR_Ld.f.isN(p.t) && !SUMR_Ld.f.isN(p.d)){
			if (SUMR_Ld.f.onl() && isN( __ldsnd[p.t] ) ){

				__ldsnd[p.t] = $.ajax({
									type:'POST',
									url: '/<?php echo $__cl->sbd; ?>/process/',
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

			t:'c',
			u:'jquery.js',
			c:function(){

		        $('body').addClass('SUMR_Agnd');


		       	SUMR_Ld.f.js({ u:'/js/base.js' });

		        SUMR_Ld.f.js({ t:'c', u:'jquery-ui.js' });

		        SUMR_Ld.f.css({

					t:'p',
			        h:'/css/base/?__c=<?php echo $__cl->enc; ?>',
			        c:function(){


			    		$(document).ready(function(){

							<?php echo $_CntJQ_Vld; ?>
							<?php echo $_CntJQ; ?>

				            SUMR_Ld.f.js({
					            u:'https://ajax.googleapis.com/ajax/libs/webfont/1/webfont.js',
					            c:function(){

									SUMR_Ld.f.js({
							            u:'https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.11.0/jquery.validate.min.js',
							            c:function(){

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
																SUMR_Ld.f.js({
																	u:'<?php echo DMN_JS ?>flatpickr.js',
																	c:function(){

																		SUMR_Ld.f.js({
																			u:'<?php echo DMN_JS ?>flatpicker/es.js',
																			c:function(){

																				flatpickr.localize(flatpickr.l10ns.es);
																				<?php echo $_CntJQ_S2; ?>

																				$('body').addClass('on');

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


						});

			            $(window).on('load',function(){

			            });


		            }

		        });

			}

		});

	}


</script>
<script type="text/javascript" src="<?php echo DMN_JS ?>_ld.js<?php if(Dvlpr()){ echo '?__r='.Enc_Rnd('r'); } ?>" async></script>
<?php ob_end_flush(); ?>