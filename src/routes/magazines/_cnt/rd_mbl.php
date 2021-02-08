<!DOCTYPE HTML>
<html lang="es">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
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

<meta name='viewport' content='width=<?php echo $Rd_W/2 ?>'/>

<meta name='MobileOptimized' content='<?php echo $Rd_W/2 ?>'/>
<meta name='HandheldFriendly' content='True'/>
<meta name='format-detection' content='telephone=no'/>
<meta name="apple-mobile-web-app-capable" content="yes"/>
<meta name="apple-mobile-web-app-status-bar-style" content="black"/>

<link href="<?php echo DMN_DG ?>inc/sty/all_rd_mbl.php?_i=<?php echo $iD_rD ?>" rel="stylesheet" type="text/css">
<script type="text/javascript" src="<?php echo DIR_JS ?>jquery.js"></script>
<script type="text/javascript" src="<?php echo DIR_JS ?>swipe.js"></script>

</head>
<body class='page-swipe'>
    <header>
      <nav>
            <?php /*?><ul id='position'>
              <li class='on'></li>
              <?php for ($_i = 2; $_i <= $row_Dt_rD['rd_pg']; $_i++){ ?>  
                    <li></li>
              <?php } ?>  
            </ul><?php */?>
      </nav>
      <div id='slider' class='swipe'>
        <div class='swipe-wrap'>
            <?php for ($i = 1; $i <= $row_Dt_rD['rd_pg']; $i++){ ?>
              <figure>
                <div class='wrap'>
                    <div class='image' style='background:url(<?php echo DMN_RD_2_BS.DIR_RD_FL.$row_Dt_rD['rd_dir'].'/pag'.$i.'.jpg'; ?>) center no-repeat; background-size: cover'> </div>
                </div>
              </figure>
            <?php }; ?>   
        </div>
      </div>
    </header>

<div id="Sv_Hd">
        <div id="BtnBar"></div>
        <?php echo iLk_RD($Rd_Lnk) ?>
</div>

<script>
	var slider =
	  Swipe(document.getElementById('slider'), {
		auto: false,
		continuous: false
	  });
	var bullets = document.getElementById('position').getElementsByTagName('li');
</script> 

<?php echo Anl(6); ?>
</body>
</html>