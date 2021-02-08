<?php

	function _GtLng($p=NULL){
		if(defined('DB_CL_ENC_SES') && !isN($_SESSION[DB_CL_ENC_SES.MM_ADM_SES_LNG])){
			$_r = $_SESSION[DB_CL_ENC_SES.MM_ADM_SES_LNG];
		}elseif(!isN($p['l'])){
			if(strpos( $p['l'], '-' ) !== false){
				$exp = explode('-', $p['l']);
				$_r = $exp[0];
			}else{
				$_r = $p['l'];
			}
		}else{
			$_r = 'es';
		}
		return($_r);
	}


	//-----------------	SISTEMA VARIABLES TEXTOS -----------------//


		$__lng = _GtLng([ 'l'=>Php_Ls_Cln($_GET['lng']) ]);
		$__sis_tt = dirname(__FILE__).'/system/_tt_'.$__lng.'.php';
		$__cl_tt = dirname(__FILE__).'/system/_tt_'.$__dt_cl->enc.'_'.$__lng.'.php';
		$__cl_mn = dirname(__FILE__).'/system/_mnu_'.$__dt_cl->enc.'.php';

		if(file_exists($__sis_tt)){ include_once($__sis_tt); }
		if(file_exists($__cl_tt)){ include_once($__cl_tt); }
		if(file_exists($__cl_mn)){ include_once($__cl_mn); }


	//-----------------	SISTEMA VARIABLES TEXTOS -----------------//

?>