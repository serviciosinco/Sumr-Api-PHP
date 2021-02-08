<?php Hdr_HTML();?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title><?php echo $__dtbn->tt.SP.DB_CL_NM ?></title>
	<base href="<?php echo DMN_BN ?>" target="_self">
	
	<link rel="stylesheet" href="/_css/_gn.css?__t=jplayer" type="text/css"/>
	<script type="text/javascript" src="<?php echo DMN_JS."jquery.js" ?>"></script>
	<script type="text/javascript" src="<?php echo DMN_JS."jplayer.js" ?>"></script>

</head>

<div id="jp_container_1" class="jp-video jp-video-360p" role="application" aria-label="media player">
	<div class="jp-type-single">
		<div id="jquery_jplayer_1" class="jp-jplayer"></div>
		<div class="jp-gui">
			<div class="jp-video-play">
				<button class="jp-video-play-icon" role="button" tabindex="0">Iniciar</button>
			</div>
			<div class="jp-interface">
				<div class="jp-progress">
					<div class="jp-seek-bar">
						<div class="jp-play-bar"></div>
					</div>
				</div>
				<div class="jp-current-time" role="timer" aria-label="time">&nbsp;</div>
				<div class="jp-duration" role="timer" aria-label="duration">&nbsp;</div>
				<div class="jp-controls-holder">
					<div class="jp-controls">
						<button class="jp-play" role="button" tabindex="0">Iniciar</button>
						<button class="jp-stop" role="button" tabindex="0">Pausar</button>
					</div>
					<div class="jp-volume-controls">
						<button class="jp-mute" role="button" tabindex="0">Silenciar</button>
						<button class="jp-volume-max" role="button" tabindex="0">Maximo Volumen</button>
						<div class="jp-volume-bar">
							<div class="jp-volume-bar-value"></div>
						</div>
					</div>
					<div class="jp-toggles">
						<button class="jp-repeat" role="button" tabindex="0">Repetir</button>
						<button class="jp-full-screen" role="button" tabindex="0">Pantalla Completa</button>
					</div>
				</div>
				<!--
				<div class="jp-details">
					<div class="jp-title" aria-label="title">&nbsp;</div>
				</div>
				-->
			</div>
		</div>
		<!--
		<div class="jp-no-solution">
			<span>Actualización Requerida</span>
			Para reproducir los medios de comunicación, deberá actualizar su navegador a una versión reciente o actualizar su <a href="http://get.adobe.com/flashplayer/" target="_blank">Plugin de Flash</a>.
		</div>
		-->
	</div>
</div>

</body>
</html>


<script>
	$(document).ready(function(){
		
		$("#jquery_jplayer_1").jPlayer({
			ready: function () {
				$(this).jPlayer("setMedia", {
					title: "UExternado",
					m4v: "<?php echo DMN_BN_FLE.$__dtbn->dir."/src.mp4"; ?>",
					ogv: "<?php echo DMN_BN_FLE.$__dtbn->dir."/src.mp4"; ?>",
					webmv: "<?php echo DMN_BN_FLE.$__dtbn->dir."/src.mp4"; ?>",
					poster: "<?php echo DMN_IMG_ESTR_SVG."sumr.svg";  ?>"
				}).jPlayer("play", 0);
			},
			supplied: "webmv, ogv, m4v",
			size: {
				width: "100%",
				height: "100%",
				cssClass: "jp-video-360p"
			},
			useStateClassSkin: true,
			autoBlur: true,
			smoothPlayBar: true,
			keyEnabled: true,
			remainingDuration: true,
			toggleDuration: true
		});
		
		<?php /*$("#jquery_jplayer_1").jPlayer({
			ready: function () {
				$(this).jPlayer("setMedia", {
					title: "<?php echo $__dtbn->tt; ?>",
					m4v: "<?php echo DMN_BN_FLE.$__dtbn->dir."/src.mp4"; ?>",
					ogv: "<?php echo DMN_BN_FLE.$__dtbn->dir."/src.mp4"; ?>",
					webmv: "<?php echo DMN_BN_FLE.$__dtbn->dir."/src.mp4"; ?>",
					poster: "<?php /*echo DMN_IMG_ESTR_SVG."uexternado.svg";  ?>"
				}).jPlayer("play", 0);
			},
			supplied: "webmv, ogv, m4v, mp4",
			size: {
				width: "100%",
				height: "100%",
				cssClass: "jp-video-360p"
			},
			useStateClassSkin: true,
			autoBlur: true,
			smoothPlayBar: true,
			keyEnabled: true,
			remainingDuration: true,
			toggleDuration: true
		});*/ ?>
		
	});
</script>