<!doctype html>
<html lang='es' class='no-js'>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<title><?php echo $_cl_dt->nm.SP.'Sistema' ?></title>
	<base href="<?php echo $__img ?>" target="_self">
	<meta property='fb:app_id' content='<?php echo APP_FB_ID ?>'/>
	<meta property='og:title' content='<?php  ?>'/>
	<meta property='og:type' content='website' />
	<meta property='og:url' content='<?php ?>' />
	<meta property='og:image' content='<?php ?>'/>
	<meta property='og:site_name' content='<?php  ?>' />
	<meta property='og:description' content='<?php ?>' />
	<meta name='keywords' content='<?php ?>'>
	<meta name='description' content='<?php ?>' />
	<link rel='image_src' type="image/jpeg" href='<?php ?>' />
	<meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0" />
	<link href="<?php echo DMN_EC; ?>inc/sty/sis.css?__c=<?php echo $_cl_dt->enc ?>" rel="stylesheet" type="text/css">
	<style>
		body ._prld{ z-index: 99999999; position: absolute; width:50px; height: 50px; left: 50%; top: 50%; margin-left:-25px; margin-top:-25px; background-size: 50px auto; background-repeat: no-repeat; }
		body ._prld{ background-image: url('<?php echo _iEtg(DMN_IMG_ESTR_SVG.'loader_black.svg') ?>'); }
	</style>
</head>
<body>
<?php

	$__ec = new API_CRM_ec();
	$__ec->id = $_vl;
	$__ec->id_t = $_tp;
	$__ec->snd_i = $__s;

	$__ec->ctj->cnt_nm = $__dtcnt->nm;
	$__ec->ctj->cnt_ap = $__dtcnt->ap;
	$__dte = $__ec->_GtInfo();

	$__cnt_attr = __LsDt([ 'k'=>'cnt_attr', 'cl'=>$_cl_dt->id ]);

	$__dtcnt_sndi = null; // By Default

	if(!isN($__dtcnt->plcy)){
		foreach($__dtcnt->plcy->ls as $_plcy_k=>$_plcy_v){
			if($_plcy_v->on == 'ok'){
				$__dtcnt_sndi = 'ok';
				$__dtcnt_sndi_on[] = $_plcy_v->id;
			}
		}
	}

?>

<div class="_prld _anm"></div>

<?php

	if(PrmLnk('rtn',2,'ok') == LNK_DEL /*&& !isN($__dtcnt->enc) && !isN($_cl_dt->enc)*/){

		$__tpp = 'del';
		include('cnt/dt/ec_del.php');

	}elseif(PrmLnk('rtn',2,'ok') == LNK_UPD){

		$__tpp = 'upd';
		include('cnt/dt/ec_upd.php');

	}else{

		echo 'No load '.LNK_DEL.' - '.PrmLnk('rtn',2,'ok');

	}

?>

<footer class="sumr_logo" style="opacity:0; filter: alpha(opacity=0);"></footer>
<noscript> <div class="_JvRc"> Su navegador NO tiene activo JAVA, puede representar dificultades para navegar </div> </noscript>

</body>
</html>

<?php ob_start("compress_code"); ?>

<script id="scrpt-main" type="text/javascript" <?php foreach($__scp_attr as $__scp_attr_k=>$__scp_attr_v){ if(!isN($__scp_attr_v)){ echo ' data-'.$__scp_attr_k.'="'.$__scp_attr_v.'" '; } } ?> >

	var __ldsnd={};

	var SUMR_Main={slc:{ sch:''}};

	function __ld_all(){

		SUMR_Ld.f.js({

			t:'c',
			u:'jquery.js',
			c:function(){


		    SUMR_Ld.f.js({ t:'c', u:'jquery-ui.js' });


	    		$(document).ready(function(){

					<?php echo $_CntJQ_Vld; ?>
					<?php echo $_CntJQ; ?>

		            SUMR_Ld.f.js({
			            u:'<?php echo DMN_JS ?>jquery.form.js',
			            c:function(){

							SUMR_Ld.f.js({
					            u:'https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.11.0/jquery.validate.min.js',
					            c:function(){

						        	SUMR_Ld.f.js({

										u:'https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.full.min.js',
										c:function(r){

											SUMR_Ld.f.js({
												u:'<?php echo DMN_JS ?>sweetalert.js',
												c:function(r){

													SUMR_Ld.f.js({
														u:'<?php echo DMN_JS ?>SpryTabbedPanels.js',
														c:function(r){

															<?php echo $_CntJQ_Spry; ?>

															SUMR_Ld.f.js({
																u:'<?php echo DMN_EC ?>inc/js/sis.js?_cl=<?php echo $_cl_dt->enc; ?>&_rnd=<?php echo $__ec->id_rnd; ?>',
																c:function(r){

																	$('body').addClass('SUMR_Sis');


																	if(!isN(r)){

																		if(!isN(r.isTrusted) && r.isTrusted){

																			if (jQuery.fn.select2) {

																				$.validator.messages.required = "Obligatorio";
																				$.validator.messages.email = "Formato erroneo";
																				$.validator.messages.digits = "Debe ser numero";

																				SUMR_Ld.f.css({ t:'p', h:'<?php echo DMN_CSS ?>sweetalert.css' });

																				SUMR_Ld.f.css({
																					t:'p',
																					h:'<?php echo DMN_CSS ?>select2.css',
																					c:function(){
																						<?php echo $_CntJQ_Slc2; ?>
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

					    }
				    });


				});

	            $(window).on('load',function(){
	            	<?php echo $_CntJQ_Ld; ?>
	            });


			}

		});

	}


	<?php echo $_CntJV; ?>


</script>



<script type="text/javascript" src="<?php echo DMN_JS ?>_ld.js<?php if(Dvlpr()){ echo '?__r='.Enc_Rnd('r'); } ?>" async></script>
<?php ob_end_flush(); ?>