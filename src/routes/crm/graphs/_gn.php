<?php

	$Rt = '../../includes/'; $__tme_s = microtime(true); $__fbsrc = 'ok'; $__twsrc = 'ok'; $__inssrc = 'ok'; $__insslnkd = 'ok'; include($Rt.'inc.php');

	//---------------------- GROUP LIST ----------------------//

		define('GL', __f());
		define('GL_EC', __f('ec'));
		define('GL_MDL', __f('mdl'));
		define('GL_CNT', __f('cnt'));
		define('GL_BCO', __f('bco'));
		define('GL_ORG', __f('org'));
		define('GL_ACT', __f('act'));

	//---------------------- VARIABLES GET ----------------------//

		$___Dt = new CRM_Dt();

		$__i = Php_Ls_Cln($_GET['_i']);
		$__t = Php_Ls_Cln($_GET['_t']);
		$__t2 = Php_Ls_Cln($_GET['_t2']);
		$__t3 = Php_Ls_Cln($_GET['_t3']);
		$__d = Php_Ls_Cln($_GET['_d']);
		$__f = Php_Ls_Cln($_GET['_f']);

		$__fpck = Php_Ls_Cln($_GET['_fpck']);
		$__hpck = Php_Ls_Cln($_GET['_hpck']);
		$__prfx = _Fx_Prx([ 'v'=>$__t ]);


		$_u = Php_Ls_Cln($_GET['_u']); if($_u=='p'){$__u='%';}else{$__u='px';}
		$_w = Php_Ls_Cln($_GET['_w']); if($_w!=''){$__w=$_w.$__u;}else{$__w='700px';}
		$_h = Php_Ls_Cln($_GET['_h']); if($_h!=''){$__h=$_h.'px';}else{$__h='150px';}


	//-------------- GUARDA FILTRO --------------//


		$__flt_dt = $___Dt->_f_chk([ 't'=>Php_Ls_Cln($_GET['_t']), 't2'=>Php_Ls_Cln($_GET['_t2']) ]);
		$__f_g = $__flt_dt->f;

		if(!isN($__f_g)){ $___Dt->c_f_g = $__f_g; }

	//---------------------- INCLUSIÓN DE ARCHIVOS ----------------------//


		if(ChckSESS_adm() || ChckSESS_usr()){

			if($__t == 'mdl_cnt'){
				$___to_inc = GL_MDL.'mdl_cnt_grph.php';
			}elseif($__t == 'mdl_cnt_grph2'){
				$___to_inc = GL_MDL.'mdl_cnt_grph2.php';
			}elseif($__t == 'snd_ec_tmpl'){
				$___to_inc = GL_EC.'ec.php';
			}elseif($__t == 'snd_ec_cmpg'){
				$___to_inc = GL_EC.'ec_cmpg.php';
			}elseif($__t == 'snd_ec_cmpg_d'){
				$___to_inc = GL_EC.'ec_cmpg_d.php';
			}elseif($__t == 'ec_snd'){
				$___to_inc = GL_EC.'ec_snd.php';
			}elseif($__t == 'cnt'){
				$___to_inc = GL_CNT.'cnt_grph.php';
			}

			elseif($__t == 'bco'){
				$___to_inc = GL_BCO.'bco_grph.php';
			}elseif($__t == 'org'){
				$___to_inc = GL_ORG.'org.php';
			}elseif($__t == 'act'){
				$___to_inc = GL_ACT.'act.php';
			}elseif($__t == 'marks'){
				$___to_inc = GL_ORG.'org.php';
			}

			else{
				$___to_inc = '../../'.DR_AC.DMN_SB.'/'.FL_DT_GN;
			}

		}else{
			echo SESS_again();
 		}



	//---------------------- JS SCRIPTS ----------------------//

		$CntWb .= '';
		if($__non_c == 'ok'){ $CntJV .= "$('#cnt').addClass('_non');"; }

	//---------------------- COMPRIME E INCLUYE CONTENIDO --------------//

		if($__no_c != 'ok'){ ob_start("cmpr_fm"); }

			echo __popd([ 't'=>'o', 'notw'=>$__non_c, 'c'=>$___Dt ]);
			if($___to_inc != ''){ include($___to_inc); }
			echo __popd([ 't'=>'c', 'notw'=>$__non_c, 'c'=>$___Dt ]);

			if(!isN($CntJV) || !isN($___Dt->jv)){ echo CntJQ($___Dt->jv.$CntJV, 'ok'); }
			if(!isN($CntWb) || !isN($___Dt->js)){ echo CntJQ($_bldr->js.$___Dt->js.$CntWb); }

		if($__no_c != 'ok'){ ob_end_flush(); }

?>