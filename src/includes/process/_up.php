<?php
	$Rt = '../../includes/';  $Rstr = 'adm'; $_cls_xls = 'ok'; include($Rt.'inc.php');


	//---------------------- GROUP LIST ----------------------//

		define('GL', __f(''));
		define('GL_UP', __f('up'));


	//---------------------- VARIABLES GET ----------------------//


		$__t = Php_Ls_Cln($_GET['_t']);
		$_aws = new API_CRM_Aws();

	//---------------------- INCLUSIÓN DE ARCHIVOS ----------------------//



		if($__t == 'upl_img'){
			$___to_inc = GL_UP.PRC_GN_UPL_IMG;
		}elseif($__t == 'upl_imgth'){
			$___to_inc = GL_UP.PRC_GN_UPL_IMG_TH;
		}elseif($__t == 'upl_imgbn'){
			$___to_inc = GL_UP.PRC_GN_UPL_IMG_BN;
		}elseif($__t == 'upl_nw'){
			$___to_inc = GL_UP.PRC_GN_UPL_NEW;
		}elseif($__t == 'upl_fle'){
			$___to_inc = GL_UP.PRC_GN_UPL_FLE;
		}elseif($__t == 'upl_fle_ls'){
			$___to_inc = GL_UP.PRC_GN_UPL_FLE_LS;
		}elseif($__t == 'upl_db'){
			$___to_inc = GL_UP.PRC_GN_UPL_DB;
		}elseif($__t == 'up_mdl_cnt'){
			$___to_inc = GL_UP.'up_mdl_cnt.php';
		}elseif($__t == 'up_sgn'){
			$___to_inc = GL_UP.'up_sgn.php';
		}elseif($__t == 'up_img_lnd'){
			$___to_inc = GL_UP.'up_img_lnd.php';
		}elseif($__t == 'up_ec'){
			$___to_inc = GL_UP.'up_ec.php';
		}elseif($__t == 'up_bn'){
			$___to_inc = GL_UP.'up_bn.php';
		}elseif($__t == 'up_lnd'){
			$___to_inc = GL_UP.'up_lnd.php';
		}elseif($__t == 'up_app'){
			$___to_inc = GL_UP.'up_app.php';
		}elseif($__t == 'upl_img_cmz'){
			$___to_inc = GL_UP.'upl_img_cmz.php';
		}elseif($__t == 'upl_bco'){
			$___to_inc = GL_UP.'upl_bco.php';
		}elseif($__t == 'up_tw'){
			$___to_inc = GL_UP.'up_tw.php';
		}elseif($__t == 'up_mdl'){
			$___to_inc = GL_UP.'up_mdl.php';
		}elseif($__t == 'up_anx'){
			$___to_inc = GL_UP.'up_anx.php';
		}elseif($__t == 'up_rd'){
			$___to_inc = GL_UP.'up_rd.php';
		}elseif($__t == 'up_tra_fle'){
			$___to_inc = GL_UP.'up_tra_fle.php';
		}

	//---------------------- COMPRIME E INCLUYE CONTENIDO --------------//

		Hdr_JSON();
		ob_start("compress_code");

		if($___to_inc != ''){ include($___to_inc); }


		ob_end_flush();

?>