<?php $Rt = '../../includes/'; $__bdfrnt = 'ok'; require($Rt.'inc.php'); ob_start("compress_code"); No_Cache(); Hdr_HTML(); ?>
<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Actualización codificada</title>
<base href="<?php echo DMN_UPD ?>" target="_self">
<?php if(isMobile()){ ?>
        <meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0" />
<?php } ?>
<link href="/includes/sty/all.css" rel="stylesheet" type="text/css" />
</head>
<body>
	<?php
			$__t = Php_Ls_Cln($_GET['_t']);

			$__i = Php_Ls_Cln($_GET['__i']);
			if($__t == 'vst_emp'){
				include(DIR_CNT.'vst_emp.php');
			}
	?>
</body>
</html>
<?php ob_end_flush(); ?>