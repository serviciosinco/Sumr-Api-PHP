<?php include('inc/_inc.php'); Hdr_HTML(); ob_start("compress_code");

if(PrmLnk('rtn', 1) != '' && !isset($_GET['Sv']) && PrmLnk('rtn', 1) != 'dv'){  }
?>
<?php
	$_hsh = PrmLnk('rtn', 1);
	$_dttw = Chck_ID_MsjTw_Sv($_hsh);
	$_hshtg = $_dttw->tx;
	$_hshtg_svid = $_dttw->id;

	$__rnd = '?___r'.Gn_Rnd(10);

	if($_dttw->id != NULL){
		$__title = $_dttw->tx.' - Admin';
	}else{
		$__title = 'Hashtag - UEC';
	}
?>
<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title><?php echo $__title; ?></title>
<base href="<?php echo DMN_TW_ADM ?>" target="_self">
<meta http-equiv="Expires" content="0">
<meta http-equiv="Last-Modified" content="0">
<meta http-equiv="Cache-Control" content="no-cache, mustrevalidate">
<meta name="google" content="notranslate" />

<meta http-equiv="Pragma" content="no-cache">
<?php if(isMobile()){ ?>
<meta name="viewport" content="width=device-width"/>
<?php } ?>

<link href="<?php echo DMN_TW_ADM ?>inc/sty/all.css" rel="stylesheet" type="text/css">

<script type="text/javascript" src="<?php echo DMN_CRM_JS ?>jquery.js<?php echo $__rnd ?>"></script>
<script type="text/javascript" src="<?php echo DMN_CRM_JS ?>jquery-ui.js<?php echo $__rnd ?>"></script>
<script type="text/javascript" src="inc/js/js.js<?php echo $__rnd ?>"></script>
<script type="text/javascript" src="inc/js/my.js<?php echo $__rnd ?>"></script>
<script type="text/javascript" src="<?php echo DMN_JS ?>modernizr.js<?php echo $__rnd ?>&ver=2.0.6"></script>
<script type="text/javascript" src="<?php echo DMN_CRM_JS ?>jquery.form.js"></script>
<script type="text/javascript" src="<?php echo DMN_CRM_JS ?>jquery.validate.js<?php echo $__rnd ?>"></script>
<script type="text/javascript" src="<?php echo DMN_CRM_JS ?>SpryTabbedPanels.js<?php echo $__rnd ?>"></script>
<script type="text/javascript" src="<?php echo DMN_CRM_JS ?>SpryCollapsiblePanel.js<?php echo $__rnd ?>"></script>
<script type="text/javascript" src="<?php echo DMN_CRM_JS ?>jquery.colorbox-min.js<?php echo $__rnd ?>"></script>

</head>
<body>
<?php
?>
<?php
	if(PrmLnk('rtn', 1) != ''){
		if(ChckSESS_usr() && $_hshtg_svid != ''){
			include('cnt/hsh.php');
		}else{
			include('cnt/login.php');
		}
	}else{
		if(ChckSESS_usr()){
			include('cnt/ls/hsh.php');
		}else{
			include('cnt/login.php');
		}
	}
?>

</body>
</html>
<?php ob_end_flush(); ?>