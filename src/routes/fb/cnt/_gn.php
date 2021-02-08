<?php
	$pth = '../../../includes/'; include($pth .'__inc.php'); ob_start("compress_code");
	$_ajax = 'ok'; include('ec.php');
?>
<script type="text/javascript" >

		   $(document).ready(function() {
				<?php echo $CntWb; ?>
		   });

		   $(window).on('load',function(){
				$("img.lazy").lazy();
		   });
</script>