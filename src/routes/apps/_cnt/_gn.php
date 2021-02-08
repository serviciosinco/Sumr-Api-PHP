<?php $Rt = '../../../includes/'; $__https_off = 'off'; $__no_sbdmn = 'ok'; include($Rt.'inc.php'); $_txt = GtClTexLng($_GET['lng']);



	//-------------------- GLOBAL - START --------------------//

		$__t = Php_Ls_Cln($_GET['_t']);
		$__i = Php_Ls_Cln($_GET['_i']);
		$__c = Php_Ls_Cln($_GET['_c']);
		$__a = Php_Ls_Cln($_GET['_a']);

		$__dt_cl = __Cl(['id'=>$__c, 't'=>'enc']);
		$__dt_app = GtClAppDt(['id'=>$__a, 't'=>'enc']);


	//-------------------- BUILD HTML / JSON --------------------//


		if($__t == 'stup'){
			$__inc = 'stup.php';
		}elseif($__t == 'mdl_s_tp'){
			$__inc = 'mdl_s_tp.php';
		}elseif($__t == 'mdl_gen'){
			$__inc = 'mdl_gen.php';
		}elseif($__t == 'enc'){
			$__inc = 'enc.php';
		}elseif($__t == 'pqr'){
			$__inc = 'pqr.php';
		}


	//-------------------- RENDER --------------------//

		Hdr_HTML();
		ob_start("compress_code");

			if(!isN($__inc)){ include('fl/'.$__inc); }

			$CntWb .= "SUMR_App.f.dom();";
			if(!isN($CntJV)){ echo CntJQ($CntJV, 'ok'); }
			if(!isN($CntWb)){ echo CntJQ($CntWb); }

		ob_end_flush();



?>