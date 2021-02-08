<?php $pth = '../../'; include('../../inc/_inc.php'); Hdr_HTML(); ob_start("compress_code");

 		$__t = Php_Ls_Cln($_GET['_t']);
 		$_vl = Php_Ls_Cln($_GET['_i']);
		$_dttw = Chck_ID_MsjTw_Sv($_GET['_h']);
		$_hshtg_svid = $_dttw->id;

			if($__t == 'tw_msg'){
				include('tw_msg.php');
			}elseif($__t == 'igr_msg'){
				include('igr_msg.php');
			}elseif($__t == 'tw_nxt'){
				include('hsh_nxt.php');
			}elseif($__t == 'tw_qus'){
				include('hsh_qus.php');
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