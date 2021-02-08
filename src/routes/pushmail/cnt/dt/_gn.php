<?php $pth = '../../../../includes/'; include($pth .'inc.php'); Hdr_HTML();

		$_compress_code = 'ok';
 		$__t = Php_Ls_Cln($_GET['_t']);
 		$__s = Php_Ls_Cln($_GET['_s']);
 		$_vl = Php_Ls_Cln($_GET['_i']);
		$_tp = 'enc';

		$__dtec = GtEcDt($_vl, $_tp, [ 'dtl'=>[ 'cl'=>'ok', 'tp'=>'ok', 'are'=>'ok' ] ]);

		if(!isN($__dtec)){

			if($__t == 'rlc'){
				$_fle_inc = 'ec_rlc.php';
			}elseif($__t == 'cmn'){
				$_fle_inc = 'ec_cmn.php';
			}elseif($__t == 'onl'){
				$_fle_inc = 'ec_online.php';
			}elseif($__t == 'stat'){
				$_fle_inc = 'ec_stat.php';
			}elseif($__t == 'html'){
				$_fle_inc = 'ec_html.php'; $_compress_code = 'no';
			}elseif($__t == 'cntc'){
				$_fle_inc = 'ec_cntc.php';
			}elseif($__t == 'tll'){
				$_fle_inc = 'ec_tll.php';
			}elseif($__t == 'del'){
				$_fle_inc = 'ec_del.php';
			}elseif($__t == 'upd'){
				$_fle_inc = 'ec_upd.php';
			}
		}


		if($_compress_code == 'ok'){ ob_start("compress_code"); }

		if(!isN($_fle_inc)){
			include($_fle_inc);
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
<?php if($_compress_code == 'ok'){ ob_end_flush(); } ?>