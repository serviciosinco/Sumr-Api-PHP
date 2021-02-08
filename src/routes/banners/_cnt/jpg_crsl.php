<?php Hdr_HTML(); //ob_start("compress_code");

	$__w = Php_Ls_Cln($_GET['_w']);

	if($__w != ''){ $__w_g = $__w; }else{ $__w_g = 'device-width'; }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $__dtbn->tt.SP.DB_CL_NM ?></title>

<?php /*
<meta name="viewport" content="width=<?php echo $__w_g ?>, initial-scale=1.0"> */ ?>

<base href="<?php echo DMN_BN ?>" target="_self">

<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.0.0-beta.2.4/owl.carousel.min.js"></script>

<link rel="stylesheet" href="/_css/_gn.css?__t=owl.carousel" type="text/css" />

<style>
	body{ background-color: #ffffff; }
	/*._wrp{ width: 600px; overflow: hidden; display: inline-block; margin-left: auto; margin-right: auto; }	*/
</style>
</head>
<body>


	<div class="owl-carousel">
	    <?php
			for ($i = 1; $i <= $__dtbn->crsl; $i++) {
				echo '<div class="item">
							<img /*class="owl-lazy"*/ src="fl/'.$__dtbn->dir.'/src'.$i.'.jpg">
					  </div>';
			}
		?>
	</div>


</body>
</html>


<script type="text/javascript">

$(window).on('load',function(){

    $('.owl-carousel').owlCarousel({
	    loop: false,
	    margin: 10,
	    nav: true,
	    center: true,
	    items:2
	});

});



</script>



<?php //ob_end_flush(); ?>