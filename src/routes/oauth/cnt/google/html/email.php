<?php echo _H_hdr(); ?>

<div class="msg">
	<?php echo h1(bdiv(['cls'=>'icn']).TX_APIESTOK); ?>
	<?php echo h2(TX_APIESTOK_MSG); ?>
	<div class="sumr_logo"></div>
</div>


<link href="<?php echo $___font->link->string ?>" rel="stylesheet">
<style>
	
	body{ font-family: 'Roboto'; font-weight: 300; padding: 0; margin: 0; }
	h1,h2,h3,h4{ font-family: 'Economica'; text-transform: uppercase; text-align: center; font-weight: 300; margin: 0; padding: 0; }
	
	h1 .icn{ background-repeat: no-repeat; background-position: center center; background-image: url('<?php echo DMN_IMG_ESTR_SVG; ?>api_ok.svg'); display:block; width: 100%; height:120px; background-size: auto 100%; margin-bottom: 20px; }
	
	.msg{ position: absolute; top: 50%; width: 100%; margin-top: -180px; background-color: rgba(0, 0, 0, 0.1); padding: 50px 0 0px 0; }
	
	.sumr_logo{ background-image: url(<?php echo DMN_IMG_ESTR ?>logo_gray.svg); ?>); background-repeat: no-repeat; background-position: center center; background-size: 80px auto; height: 100px; background-color: white; margin-top: 50px; }
	
	
</style>	
<?php echo _H_ftr(); ?>