<?php

	include('../includes/incc.php');

	//-------------------- BUILD HTML --------------------//

	ob_start('compress_code_b');

?>
<?php Hdr_HTML([ 'cche'=>'ok', 'fa'=>$__fm->fa ]); ?>
<?php

	include('fm.php');

	$_CntJQ .= '
		SUMR_Fm.c.jq = function(){
			'.$_CntJQ.'
		};
		SUMR_Fm.c.jq2 = function(){
			'.$_CntJQ_S2.'
		};
	';
?>
<script type="text/javascript" id="sumr-form-html-scrpt">
	"use strict";
	<?php echo cmpr_js($_CntJQ); ?>
</script>
<?php ob_end_flush(); ?>