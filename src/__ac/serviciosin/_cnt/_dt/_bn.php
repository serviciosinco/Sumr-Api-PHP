<?php $Rt = '../../includes/'; include($Rt.'inc.php'); ob_start("compress_code"); Hdr_HTML();

$__i = Php_Ls_Cln($_GET['__i']);
$__dtbn = json_decode(GtBnDt($__i, 'enc'));

$Dir = DMN_BN.'fl/'.$__dtbn->dir.'/src.swf?Rnd='.Gn_Rnd(20);
?>
<?php if(($__dtbn->id != NULL)){ ?>
<script type="text/javascript">


	$.fn.colorbox.resize({
			 innerHeight: "<?php echo ($__dtbn->h + 20) ?>px",
       		 innerWidth: "<?php echo $__dtbn->w ?>px",
			 title: "soe"
	});

	SUMR_Ld.f.js({ t:"j", u:"swfobject.js" });
</script>
<div class="__dt_bn">
    <object id="FlashID" classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" width="<?php echo $__dtbn->w ?>" height="<?php echo $__dtbn->h ?>">
      <param name="movie" value="<?php echo $Dir ?>" />
      <param name="quality" value="high" />
      <param name="wmode" value="opaque" />
      <param name="swfversion" value="9.0.45.0" />
      <!-- Esta etiqueta param indica a los usuarios de Flash Player 6.0 r65 o posterior que descarguen la versión más reciente de Flash Player. Elimínela si no desea que los usuarios vean el mensaje. -->
      <param name="expressinstall" value="ex.swf" />
      <!-- La siguiente etiqueta object es para navegadores distintos de IE. Ocúltela a IE mediante IECC. --> <!--[if !IE]>-->
      <object type="application/x-shockwave-flash" data="<?php echo $Dir ?>" width="<?php echo $__dtbn->w ?>" height="<?php echo $__dtbn->h ?>">
        <!--<![endif]-->
        <param name="quality" value="high" />
        <param name="wmode" value="opaque" />
        <param name="swfversion" value="9.0.45.0" />
        <param name="expressinstall" value="ex.swf" />
        <!-- El navegador muestra el siguiente contenido alternativo para usuarios con Flash Player 6.0 o versiones anteriores. -->
        <div>
          <h4>El contenido de esta página requiere una versión más reciente de Adobe Flash Player.</h4>
          <p><a href="https://www.adobe.com/go/getflashplayer"><img src="https://www.adobe.com/images/shared/download_buttons/get_flash_player.gif" alt="Obtener Adobe Flash Player" width="112" height="33" /></a></p>
        </div>
        <!--[if !IE]>-->
      </object>
      <!--<![endif]-->
    </object>
    <div class="__tt">
        <?php echo Strn(TX_NM.': '.Spn($__dtbn->tt)).
				   Strn(TX_WDTH.': '.Spn($__dtbn->w.'px')).
				   Strn(TX_HEGT.': '.Spn($__dtbn->h.'px')); ?>
    </div>
</div>
<?php } ?>
<?php ob_end_flush(); ?>