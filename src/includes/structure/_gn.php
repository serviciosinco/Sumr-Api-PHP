<?php $Rt = '../../includes/'; $__tme_s = microtime(true); $__fbsrc = 'ok'; include($Rt.'inc.php'); Hdr_HTML(); ob_start("cmpr_fm");


//if(ChckSESS_adm() || ChckSESS_usr()){

		$__t = Php_Ls_Cln($_GET['_t']);

		if($__t == 'dmnu'){
			$___inc_go = 'dmnu.php';
		}else{
			exit();
		}


//}else{

 	//echo SESS_again();

//}

?>
<?php if($___inc_go != ''){ include( $___inc_go ); echo CntJQ($CntJV, 'ok').CntJQ($CntWb);  } ?>
<?php $__tmexc = _Rg_Tme($__tme_s, microtime(true)); ?>
<?php ob_end_flush(); ?>