<?php $pth = '../../'; include('../../inc/_inc.php'); Hdr_HTML(); ob_start("compress_code");

 		$__t = Php_Ls_Cln($_GET['_t']);
 		$_vl = Php_Ls_Cln($_GET['_i']);
		$_hshtg_dt = Php_Ls_Cln($_GET['_h']);

			if($__t == 'qus'){
				include('tw_qus.php');
			}
?>
<?php if($_CntJQ != '' || $_CntJQ_Ld != ''){ ?>
<script type="text/javascript">

				<?php if($_CntJQ != ''){ ?>
				$(document).ready(function() {
                    <?php echo $_CntJQ; ?>
            	});
				<?php } ?>

</script>
<?php } ?>
<?php ob_end_flush(); ?>