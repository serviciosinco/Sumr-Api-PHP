<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title><?php echo $__dtrd->tt.SP.$__dtrd->fac_tt ?></title>
<base href="<?php echo DMN_DG ?>" target="_self">

<meta property='og:title' content='<?php echo $__dtrd->tt.SP.$__dtrd->fac_tt ?>'/>
<meta property='og:type' content='website' />
<meta property='og:url' content='<?php echo DMN_DG.PrmLnk('rtn', 1) ?>' />
<meta property='og:image' content='<?php echo $__img ?>'/>
<meta property='og:site_name' content='<?php echo $__dtrd->tt ?>' />
<meta property='og:description' content='<?php echo strip_tags($__dtrd->dsc); ?>' />
<meta name='keywords' content='<?php echo __kyw($__dtrd->dsc); ?>'>
<meta name='description' content='<?php echo strip_tags($__dtrd->dsc); ?>' />


<link href="<?php echo DMN_DG ?>inc/sty/all_rd.css?_i=<?php echo $iD_rD ?>" rel="stylesheet" type="text/css">

<script type="text/javascript" src="<?php echo DMN_DG ?>inc/js/flippingbook/liquid.js"></script>
<script type="text/javascript" src="<?php echo DMN_DG ?>inc/js/flippingbook/swfobject.js"></script>
<script type="text/javascript" src="<?php echo DMN_DG ?>inc/js/flippingbook/flippingbook.js"></script>
<script type="text/javascript" src="<?php echo DMN_DG ?>inc/js/flippingbook/bookSettings.js?_i=<?php echo $__dtrd->enc ?>"></script>

</head>
<body >
<?php echo $bd_cd.Anl(6); ?>
</body>
</html>
