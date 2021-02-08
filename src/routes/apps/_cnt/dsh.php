<?php

	Hdr_HTML();
	ob_start("compress_code");

	if($appdt->e == 'ok'){

		if(!isN($__l)){ $_lng = $__l; }else{ $_lng='es'; }
?>
<!DOCTYPE HTML>
<html lang="<?php echo $_lng; ?>">
	<head>
		<title><?php echo 'APP | '.$__dt_cl->nm; ?></title>
		<base href="<?php echo DMN_APP.$__pm_1; ?>" target="_self">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<meta name="apple-mobile-web-app-status-bar-style" content="black">
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="mobile-web-app-capable" content="yes">
		<link rel="icon" href="img/touch-icon-iphone.png" type="image/x-icon" />
		<link rel="apple-touch-icon-precomposed" href="<?php echo $__dt_cl->img->th_400 ?>"/>
		<link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php echo $__dt_cl->img->th_100 ?>"/>
		<link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?php echo $__dt_cl->img->th_200 ?>"/>
		<link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?php echo $__dt_cl->img->th_200 ?>"/>
		<link rel="shortcut icon" href="<?php echo $__dt_cl->lgo->ico->big; ?>" type="image/x-icon"/>
		<link rel="manifest" href="/manifest.json">
		<style>


			*{ box-sizing: border-box; outline: none; background-repeat: no-repeat; background-position: center center; font-weight: 300; }
			body{ padding: 0; margin: 0; font-family: Tahoma, Verdana, Arial, Helvetica, sans-serif;  }

			body:not(.on) header,
			body:not(.on) footer,
			body:not(.on) .app-main{ display: none; }

			body ._prld{ z-index: 99999999; position: absolute; width: 100%; height: 100%; left: 0; top: 0; background-size: 50px auto; }
			body ._prld{ background-image: url('<?php echo DMN_APP; ?>img/estr/loader_white.svg'); }


			body.on ._prld{ display: none; }
			body.on .app-main,
			body.on header,
			body.on footer{ display: block; }


			<?php

				$__cl_tag = $__dt_cl->tag;
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
	<body>

		<div class="_bcki"></div>

		<header>
			<div class="wrp">
				<div class="lg _anm">
					<div class="lg_cl"></div>
				</div>
			</div>
			<div class="lng">
				<ul>
					<li><a href="<?php echo $__dt_cl->sbd.'/'.$appdt->enc; ?>/?lng=es"><div class="es"></div></a></li>
					<li><a href="<?php echo $__dt_cl->sbd.'/'.$appdt->enc; ?>/?lng=en"><div class="en"></div></a></li>
					<li><a href="<?php echo $__dt_cl->sbd.'/'.$appdt->enc; ?>/?lng=fr"><div class="fr"></div></a></li>
					<li><a href="<?php echo $__dt_cl->sbd.'/'.$appdt->enc; ?>/?lng=ptg"><div class="po"></div></a></li>
					<li>
						<div class="opt">
							<button class="config" id="btn-config">Config</button>
							<button class="reload" id="btn-reload"></button>
						</div>
					</li>
				</ul>
			</div>
		</header>

		<section class="app-main">

			<div class="wrp">

				<div class="app-cnt _anm" id="app-cnt">
					<div class="_ldr _anm"><div class="_spn"></div></div>
					<div class="_clse _anm"></div>
					<div class="_bxhtt _anm">
						<div class="_bxhtt_cnt"></div>
					</div>
				</div>


				<div class="dsh-main" id="dsh-main">
					<div class="fil">
						<?php if($appdt->icn->tot > 0){ ?>
							<?php foreach($appdt->icn->ls as $_icn_k=>$_icn_v){ //print_r($_icn_v); ?>
							<div class="col _anm app-opt" data-rel="<?php echo $_icn_v->rel; ?>" style="background-image: url(<?php echo $_icn_v->img; ?>);">
								<div class="tt"><p><?php echo $_icn_v->tt; ?></p></div>
							</div>
							<?php } ?>
						<?php } ?>
					</div>
				</div>


			</div>

		</section>
		<footer>
			<div class="lg_sumr"></div>
			<div class="sis_set" id="bx-sis-set">
				<ul>
					<li class="md"><strong>Medio</strong> <span>-</span></li>
					<li class="fnt"><strong>Fuente</strong> <span>-</span></li>
					<li class="mdlstp"><strong>Tipo</strong> <span>-</span></li>
					<li class="mdlgen"><strong>Formulario</strong> <span>-</span></li>
					<li class="act"><strong>Actividad</strong> <span>-</span></li>
				</ul>
			</div>
		</footer>

		<div class="_optm _anm"><button id="btn-optm">Options</button></div>

		<div class="_ovly _anm"></div>
		<div class="_prld _anm"></div>

	</body>
</html>
<script type="text/javascript">

	var SUMR_Main={slc:{sch:''}};

	function __ld_all(){

		SUMR_Ld.f.css({
			t:'p',
	        h:'/css/?_c=<?php echo $__dt_cl->enc; ?>&_app=<?php echo $appdt->enc; ?>&Rd='+Math.random(),
	        c:function(){

				SUMR_Ld.f.js({

					t:'c',
					u:'jquery.js',
					c:function(){

				        SUMR_Ld.f.js({
							t:'c',
					        u:'jquery-ui.js',
					        c:function(){

						        SUMR_Ld.f.js({ u:'/js/?_c=<?php echo $__dt_cl->enc; ?>&_a=<?php echo $appdt->enc; ?>&Rd='+Math.random() });

						    	SUMR_Ld.f.js({
							    	u:'<?php echo DMN_JS ?>jquery.colorbox-min.js',
									c:function(){
										SUMR_Ld.f.css({ t:'p', h:'<?php echo DMN_CSS ?>colorbox.css' });
									}
							    });

							    SUMR_Ld.f.js({
							    	u:'<?php echo DMN_JS ?>select2.js',
									c:function(){
										SUMR_Ld.f.css({ t:'p', h:'<?php echo DMN_CSS ?>select2.css' });
									}
							    });

					    		$(document).ready(function(){

									<?php echo $_CntJQ_Vld; ?>
									<?php echo $_CntJQ; ?>
									<?php echo $CntJV; ?>

							        $('body').addClass('on');

						            SUMR_Ld.f.js({
							            u:'https://ajax.googleapis.com/ajax/libs/webfont/1/webfont.js',
							            c:function(){


											if(!SUMR_Ld.f.isN(SUMR_App) && !SUMR_Ld.f.isN(SUMR_App.form.mdlstp) && !SUMR_Ld.f.isN(SUMR_App.form.mdlstp.vl) && !SUMR_Ld.f.isN(SUMR_App.form.mdlgen) && !SUMR_Ld.f.isN(SUMR_App.form.mdlgen.vl)){


												$('#dsh-main .fil').html('').html('
												<div class="col _anm app-opt" data-rel="mdl_gen" style="background-image:url(\'img/start.svg\');">
													<div class="tt"><p>Registrar</p></div>
												</div>');

												SUMR_App.f.dom();

												/*
												SUMR_App.f.getPnl();
												SUMR_App.f.getJs({ _tp:'mdl_gen', _data:{ mdl_gen:SUMR_App.form.mdlgen.vl, mdl_s_tp:SUMR_App.form.mdlstp.vl } });
												*/
											}


									    }
								    });


								});
					        }
					    });

					}

				});

			}

		});

	}


</script>
<script type="text/javascript" id="main-script" src="<?php echo DMN_JS ?>_ld.js<?php if(Dvlpr()){ echo '?__r='.Enc_Rnd('r'); } ?>" async></script>

<?php } ?>
<?php ob_end_flush(); ?>