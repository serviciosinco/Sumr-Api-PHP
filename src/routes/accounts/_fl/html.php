<?php

	ob_start("compress_code");
	Hdr_HTML();

	$__main_bck = DMN_IMG_ESTR.'sis_fnd_acc.svg';
	$__main_logo = DMN_IMG_ESTR.'logo_acc.svg';
	$__main_map = DMN_IMG_ESTR.'sis_fnd_acc.jpg';

	$__id_rnd = '_'.Gn_Rnd(20);

?>
<!DOCTYPE html>
<html lang='es'>
    <head>
        <meta charset="utf-8">
        <title>CRM - Cuentas</title>
        <meta name="google" content="notranslate" />

        <meta http-equiv="Cache-control" content="max-age=0">
        <link rel="apple-touch-icon-precomposed" href="<?php echo DMN_IMG_ESTR ?>touch-icon-iphone.png" />
        <link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php echo DMN_IMG_ESTR ?>touch-icon-ipad.png" />
        <link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?php echo DMN_IMG_ESTR ?>touch-icon-iphone-retina.png" />
        <link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?php echo DMN_IMG_ESTR ?>touch-icon-ipad-retina.png" />
        <link rel="apple-touch-startup-image" href="<?php echo DMN_IMG_ESTR ?>ios-startup.png" />

        <link rel="shortcut icon" sizes="196x196" href="<?php echo DMN_IMG_ESTR ?>icon-chrome-196.png" />
        <link rel="shortcut icon" sizes="128x128" href="<?php echo DMN_IMG_ESTR ?>icon-chrome-128.png" />

        <meta name="apple-mobile-web-app-status-bar-style" content="black">
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="mobile-web-app-capable" content="yes">



        <?php if (isMobile()) { ?>
            <meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0" />
        <?php } ?>

        <base href="/" target="_self">

        <?php if(_isDsk()){ ?>
            <script>
				delete window.module;

				<?php

					$_CntLd .= "

						const ipcRenderer = require('electron').ipcRenderer;
						ipcRenderer.send('_rSze');


					";

				?>


			</script>
        <?php } ?>

        <style>

			<?php if(_isDsk()){ ?>

				.draggable-area{ -webkit-app-region: drag; }

				input[type="submit"],
				input[type="reset"],
				input[type="button"],
				input[type="text"],
				input[type="email"],
				input[type="password"],
				button,
				textarea {
					-webkit-app-region: no-drag !important;
				}

			<?php } ?>


			.__main_ldr{ height: 100%; width: 100%; display:block; position: absolute; z-index: 9999999999; color: white; font-family: Economica; text-transform: uppercase; text-align: center; left: 0; top: 0; }
			.__main_ldr ._tx{ margin-top: -30px; }
			.__main_ldr ._tx span{ color: var(--main-bg-color); }

			.__main_ldr .arc-rotate2{ position: absolute; width: 80px;height: 80px; left: 50%; top: 50%; margin-left: -40px; margin-top: -40px; }
			.__main_ldr .arc-rotate2 .loader { width: 100px; height: 100px; }
			.__main_ldr .arc-rotate2 .loader .arc { position: absolute; width: 100%; height: 100%; }
			.__main_ldr .arc-rotate2 .loader .arc::before, .arc-rotate2 .loader .arc::after { content: ''; position: absolute; top: 32%; left: 32%; border: 3px solid; border-radius: 50%; width: 36%; height: 36%; }

			.__main_ldr .arc-rotate2 .loader .load { position: relative;border: 3px solid #707070;border-radius: 50%;border-top: 3px solid var(--main-bg-color);width: 35px;height: 35px;top: 22%;left: 22%;-webkit-animation: lder 2s linear infinite;animation: lder 2s linear infinite;}
			.__main_ldr .arc-rotate2 .loader .arc::before { border-color: #FFF; opacity: .3; }
			.__main_ldr .arc-rotate2 .loader .arc::after { border-color: transparent; border-bottom-color: #FFF; -webkit-animation: rotate 1s infinite linear; animation: 	rotate 1s infinite linear; }


			.bx_wrp .c_acc{ left: -2000px; opacity: 0; pointer-events: none; }
			.bx_wrp .c_brnd{ right: -2000px; opacity: 0; pointer-events: none; }
			.bx_wrp .c_brnd .logout{ position: absolute; right: 20px; bottom: 20px; width: 30px; height: 30px; background-color: transparent; background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>acc_logout.svg); background-repeat: no-repeat; background-size: 70% auto; background-position: center center; border: none; cursor: pointer; opacity: 0.6; }
			.bx_wrp .c_brnd .logout:hover{ background-size: 100% auto; opacity: 1; }

			<?php if (Dvlpr()){ ?>

				._dvlp_hdr{ font-size:14px; font-weight:bolder; color:#FFF; background:#0CF; width:100%; padding: 5px 0px 5px 0px; position:absolute; left:0px; top:0px; text-align:center; z-index:99999999999; text-transform:uppercase; font-family: "Economica"; }

			<?php } ?>

		</style>

		<script type="text/javascript">
			function _p_l(imgs){var pA=[];for(i=0;i<imgs.length;i++){pA[i]=new Image(100,100);pA[i].src=imgs[i];}}
			_p_l(['<?php echo $__main_bck ?>', '<?php echo DMN_IMG_ESTR_SVG ?>loader_black.svg']);
		</script>

</head>
<body class="draggable-area">

	<?php if (Dvlpr()) { ?><div class="_dvlp_hdr"><?php echo TX_PLTFDSLL ?></div><?php } ?>

	<div class="__main_ldr _anm">
   		<div class="arc-rotate2">
			<div class="loader">
				<div class="load"></div>
			</div>
			<?php /*?><div class="_tx"><?php echo TX_LDING ?> <span><?php echo TX_CNTND ?></span></div><?php*/ ?>
		</div>
	</div>

    <div class="bx_wrp draggable-area _anm">
		<div class="c_acc draggable-area _anm" style="background-image:url('<?php echo $__main_bck ?>');">
			<div class="_ovr draggable-area"></div>
			<div class="_ls _anm" id="_acc_bx_<?php echo $__id_rnd; ?>">
				<button class="new _anm" id="_acc_add_<?php echo $__id_rnd; ?>"><?php echo TX_CNNCT; ?></button>

				<div id="_acc_ls_<?php echo $__id_rnd; ?>" class="_bx _anm">
					<h1><?php echo Strn(TX_SLC).' '.Spn(TX_ACC); ?></h1>
					<div class="_wrp">
						<ul></ul>
					</div>
				</div>

				<div id="_cnct_<?php echo $__id_rnd; ?>" class="_cnct _anm">
					<?php include(GL_HTML.'fm.php'); ?>
				</div>

			</div>
		</div>
		<div class="c_brnd draggable-area _anm" style="background-image:url('<?php echo $__main_map ?>');">
			<div class="logo" style="background-image: url('<?php echo $__main_logo; ?>');"></div>
			<button class="logout _anm" id="_acc_logout_<?php echo $__id_rnd; ?>"></button>
		</div>
    </div>


</body>
</html>
<script type="text/javascript">

	var SUMR_Main={slc:{ sch:''}};

	function __ld_all(){

		SUMR_Ld.f.css({
		    tag:'ok',
	        h:'sb/acc/main',
	        c:function(){

           		<?php $___font = __font(); ?>
		        var WebFontConfig = {google: {families: <?php echo $___font->js->string; ?>}, timeout: 2000};

				SUMR_Ld.f.js({
					t:'c',
					u:'jquery.js',
					c:function(){

						SUMR_Ld.f.js({

							t:'c',
							u:'_all.js',
							c:function(){

								<?php if(!_isDsk()){ ?>

									SUMR_Ld.f.js({
										t:'c',
										u:'js_app_mbl.js',
										c:function(){
											if(!SUMR_Ld.f.isN(SUMR_App)){
												SUMR_App.dmn = '<?php echo DMN; ?>';
												SUMR_App.acc_rnd = '<?php echo $__id_rnd; ?>';
											}
										}
									});

								<?php }else{ ?>

									SUMR_Ld.f.js({
										t:'c',
										u:'js_app_dsktp.js',
										c:function(){
											setTimeout(function(){
												if( typeof SUMR_App != 'undefined' && !SUMR_Ld.f.isN(SUMR_App)){
													SUMR_App.dmn = '<?php echo DMN; ?>';
													SUMR_App.acc_rnd = '<?php echo $__id_rnd; ?>';
												}
												<?php echo $_CntScrptLd; ?>
											}, 300);
										}
									});

								<?php } ?>

								$(document).ready(function(){
									<?php echo $_CntJQ; ?>
								});

			                    $(window).on('load',function(){
									<?php echo $_CntLd; ?>
									$('body').addClass('rdy');
			                    });

							}

			            });

		            }

		        });
            }
        });
    }


    <?php echo $_CntJV; ?>

</script>
<script type="text/javascript" src="<?php echo DMN_JS ?>_ld.js<?php if(Dvlpr()){ echo '?__r='.Enc_Rnd('r'); } ?>" async></script>