<?php $Rt = '../../includes/'; $__tme_s = microtime(true); $__fbsrc = 'ok'; include($Rt.'inc.php'); ob_start("cmpr_fm"); Hdr_HTML();


	//---------------------- GROUP LIST ----------------------//

		define('GL', __f());
		define('GL_UP', __f('up'));

	//---------------------- VARIABLES GET ----------------------//

	$__t = Php_Ls_Cln($_GET['_t']);
	$__i = Php_Ls_Cln($_GET['__i']);
	$__prfx = _Fx_Prx([ 'v'=>$__t ]);


	if($__t == 'bco'){

		include(GL_UP.'upl_bco.php');

	}else{

		include(GL_UP.'_gn.php');

	}

?>
 <script type="text/javascript">
	<?php echo $_CntJV; ?>
    $(function() {

		SUMR_Main.ld.f.upl( function(){
			<?php echo $CntWb ?>
		});

    });
</script>
<?php ob_end_flush(); ?>