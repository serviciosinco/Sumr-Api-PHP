<?php $pth = '../../'; include('../../inc/_inc.php'); Hdr_HTML(); ob_start("compress_code");

 		$__t = Php_Ls_Cln($_GET['_t']);
 		$_vl = Php_Ls_Cln($_GET['_i']);
		$_dttw = Chck_ID_MsjTw_Sv($_GET['_h']);
		$_hshtg_svid = $_dttw->id;

			if($__t == 'msg_ok'){
				include('hsh_msg_ok.php');
			}elseif($__t == 'qus_ok'){
				include('hsh_qus_ok.php');
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