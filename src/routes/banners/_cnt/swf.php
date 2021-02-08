<?php Hdr_HTML(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $__dtbn->tt.SP.DB_CL_NM ?></title>
<base href="<?php echo DMN_BN ?>" target="_self">
<script type="text/javascript" src="<?php echo DMN_JS ?>swfobject.js"></script>
</head>
<body>
<object id="FlashID" classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" width="<?php echo $__dtbn->w ?>" height="<?php echo $__dtbn->h ?>">
  <param name="movie" value="<?php echo $Dir_Swf ?>" />
  <param name="quality" value="high" />
  <param name="wmode" value="opaque" />
  <param name="swfversion" value="9.0.45.0" />
  <!-- Esta etiqueta param indica a los usuarios de Flash Player 6.0 r65 o posterior que descarguen la versión más reciente de Flash Player. Elimínela si no desea que los usuarios vean el mensaje. -->
  <param name="expressinstall" value="ex.swf" />
  <!-- La siguiente etiqueta object es para navegadores distintos de IE. Ocúltela a IE mediante IECC. --> <!--[if !IE]>-->
  <object type="application/x-shockwave-flash" data="<?php echo $Dir_Swf ?>" width="<?php echo $__dtbn->w ?>" height="<?php echo $__dtbn->h ?>">
    <!--<![endif]-->
    <param name="quality" value="high" />
    <param name="wmode" value="opaque" />
    <param name="swfversion" value="9.0.45.0" />
    <param name="expressinstall" value="ex.swf" />
    <!-- El navegador muestra el siguiente contenido alternativo para usuarios con Flash Player 6.0 o versiones anteriores. -->
    <div>
      <h4>El contenido de esta página requiere una versión más reciente de Adobe Flash Player.</h4>
      <p><a href="http://www.adobe.com/go/getflashplayer"><img src="http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif" alt="Obtener Adobe Flash Player" width="112" height="33" /></a></p>
    </div>
    <!--[if !IE]>-->
  </object>
  <!--<![endif]-->
</object>
<script type="text/javascript">swfobject.registerObject("FlashID");</script>
</body>
</html>