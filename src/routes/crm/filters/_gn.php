<?php

try {

	$Rt = '../../includes/'; $__tme_s = microtime(true); $__fbsrc = 'ok'; include($Rt.'inc.php'); Hdr_HTML();


	//---------------------- GROUP LIST ----------------------//

		define('GL', __f(''));
		define('GL_ACT', __f('act'));
		define('GL_CNT', __f('cnt'));
		define('GL_MDL', __f('mdl'));
		define('GL_EC', __f('ec'));
		define('GL_BCO', __f('bco'));
		define('GL_ORG', __f('org'));
		define('GL_SIS', __f('sis'));

	//---------------------- VARIABLES GET ----------------------//

		$_Crm_Aud = new CRM_Aud();
		$___Ls = new CRM_Ls();
		$_aws = new API_CRM_Aws();

		$__t = Php_Ls_Cln($_GET['_t']);
		$__t2 = Php_Ls_Cln($_GET['_t2']);
		$__t3 = Php_Ls_Cln($_GET['_t3']);
		$__t4 = Php_Ls_Cln($_GET['_t4']);

		if(Php_Ls_Cln($_GET['_pop'])=='ok'){ $_bxpop = 'ok';}


	//-------------- GUARDA FILTRO --------------//


		if(($__fsve == 'ok' || (!isN($__fsch)) && isN($__fpr))){
			$__flt_dt = $___Ls->_f_sve([ 't'=>Php_Ls_Cln($_GET['_t']), 't2'=>Php_Ls_Cln($_GET['_t2']) ]);
			$__f_g = $__flt_dt->d;
		}elseif($__fcln == 'ok' || $__fcln_g == 'ok'){
			$__flt_dt = $___Ls->_f_sve([ 't'=>Php_Ls_Cln($_GET['_t']), 't2'=>Php_Ls_Cln($_GET['_t2']), 'cln'=>'ok' ]);
			$__f_g = $__flt_dt->d;
		}else{
			$__flt_dt = $___Ls->_f_chk([ 't'=>Php_Ls_Cln($_GET['_t']), 't2'=>Php_Ls_Cln($_GET['_t2']) ]);
			$__f_g = $__flt_dt->f;
		}

		if(!isN($__f_g)){ $___Ls->c_f_g = $__f_g; }


	//---------------------- INCLUSIÓN DE ARCHIVOS ----------------------//

		if(ChckSESS_adm() || ChckSESS_usr()){

			$___to_inc = $__t;

			if($__t == 'act'){
				$___to_fld = GL_ACT;
			}elseif($__t == 'cnt'){
				$___to_fld = GL_CNT;
			}elseif($__t == 'mdl' || $__t == 'mdl_cnt'){
				$___to_fld = GL_MDL;
			}elseif($__t == 'snd_ec_cmpg' || $__t == 'snd_ec_lsts' || $__t == 'snd_ec_tmpl'){
				$___to_fld = GL_EC;
			}elseif($__t == 'org'){
				if($__t2 == 'marks'){ $___to_inc='marks'; }
				$___to_fld = GL_ORG;
			}elseif($__t == 'bco'){
				$___to_fld = GL_BCO;
			}elseif($__t == 'sis_slc_tp'){
				$___to_fld = GL_SIS;
			}

		}else{

			echo SESS_again();

		}

	//---------------------- COMPRIME E INCLUYE CONTENIDO --------------//

		if($__no_c != 'ok'){ ob_start("cmpr_fm"); }

			echo __popd([ 't'=>'o', 'show'=>$_wrpc, 'c'=>$___Ls ]);

			if(!isN($___to_inc)){
				$___Ls->_bld_f([ 'f'=>$___to_fld, 't'=>$___to_inc ]);
			}

			echo __popd([ 't'=>'c', 'show'=>$_wrpc, 'c'=>$___Ls ]);

			if(!isN($CntJV) || !isN($___Ls->jv)){ echo CntJQ($___Ls->jv.$CntJV, 'ok'); }
			if(!isN($CntWb) || !isN($___Ls->js)){ echo CntJQ($___Ls->js.$_bldr->js.$CntWb); }

		if($__no_c != 'ok'){ ob_end_flush(); }

} catch (Exception $e) {
    echo $e->getMessage();
}

?>