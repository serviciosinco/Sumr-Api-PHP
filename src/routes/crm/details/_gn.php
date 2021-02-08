<?php

	$Rt = '../../includes/'; $__tme_s = microtime(true); $__fbsrc = 'ok'; $__twsrc = 'ok'; $__inssrc = 'ok'; $__insslnkd = 'ok'; include($Rt.'inc.php'); Hdr_HTML();

	//---------------------- GROUP LIST ----------------------//


		define('GL', __f());
		define('GL_ATMT', __f('atmt'));
		define('GL_CNT', __f('cnt'));
		define('GL_MDL', __f('mdl'));
		define('GL_PNL', __f('pnl'));
		define('GL_MYEML', __f('my_eml'));
		define('GL_EMP', __f('emp'));
		define('GL_US', __f('us'));
		define('GL_CNV', __f('cnv'));
		define('GL_SCL', __f('scl'));
		define('GL_CK', __f('ck'));
		define('GL_INF', __f('inf'));
		define('GL_DSH', __f('dsh'));
		define('GL_UP', __f('up'));
		define('GL_ORG', __f('org'));
		define('GL_ACT', __f('act'));
		define('GL_LND', __f('lnd'));
		define('GL_SIS', __f('sis'));
		define('GL_LRN', __f('lrn'));
		define('GL_EC', __f('ec'));
		define('GL_SCRPT', __f('scrpt'));
		define('GL_TRA', __f('tra'));
		define('GL_WHTSP', __f('whtsp'));
		define('GL_SHOP', __f('shop'));
		define('GL_SCAN', __f('scan'));
		define('GL_NEWS', __f('news'));
		define('GL_RSLLR', __f('rsllr'));
		define('GL_BCO', __f('bco'));
		define('GL_AWS', __f('aws'));
		define('GL_VTEX', __f('vtex'));




	//---------------------- VARIABLES GET ----------------------//

		$___Dt = new CRM_Dt();
		$_aws = new API_CRM_Aws();

		$__i = Php_Ls_Cln($_GET['_i']);
		$__t = Php_Ls_Cln($_GET['_t']);
		$__t2 = Php_Ls_Cln($_GET['_t2']);
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


		if($__t == 'lgout'){

			$___to_inc = GL.'lgout.php';

		}elseif($__t == 'lgagn'){

			$___to_inc = GL.'lgagn.php';

		}else{

			if(ChckSESS_adm() || ChckSESS_usr()){

				if($__t == 'atmt'){
					$___to_inc = GL_ATMT.'atmt.php'; $__non_c = 'ok';
				}elseif($__t == 'snd_ec'){
					$___to_inc = GL_EC.'ec.php'; $__non_c = 'ok';
				}elseif($__t == 'ec_snd_rprt'){
					$___to_inc = GL_EC.'ec_snd_rprt.php';
				}elseif($__t == 'us_myp'){
					$___to_inc = GL_US.DT_US_MYP; $__non_c = 'ok';
				}elseif($__t == 'us_tkn'){
					$___to_inc = GL_US.'us_tkn.php';
				}elseif($__t == 'cl_sis'){
					$___to_inc = GL.'sis.php'; $__non_c = 'ok';
				}elseif($__t == 'indx' || $__t == 'indxTmp'){
					$___to_inc = GL.DT_GN_INDX; $__non_c = 'ok';
				}elseif($__t == 'news'){
					$___to_inc = GL_NEWS.'news.php'; $__non_c = 'ok';
				}elseif($__t == 'news_pop'){
					$___to_inc = GL_NEWS.'news_pop.php'; $__non_c = 'ok';


				}elseif($__t == 'cnt'){
					$___to_inc = GL_CNT.'cnt.php';
				}elseif($__t == 'cnt_ck'){
					$___to_inc = GL_CNT.'cnt_ck.php'; $__non_c = 'ok';
				}elseif($__t == 'cnt_appl_anx'){
					$___to_inc = GL_CNT.'cnt_appl_anx.php'; $__non_c = 'ok';
				}elseif($__t == 'cnt_opt'){
					$___to_inc = GL_CNT.'cnt_opt.php'; $__non_c = 'ok';
				}

				elseif($__t == 'mdl'){
					$___to_inc = GL_MDL.'mdl.php';
				}elseif($__t == 'mdl_cnt_his'){
					$___to_inc = GL_MDL.'mdl_cnt_his.php';
				}elseif($__t == 'mdl_fle'){
					$___to_inc = GL_MDL.'mdl_fle.php'; $__non_c = 'ok';
				}elseif($__t == 'cnt_tml'){
					$___to_inc = GL_CNT.'cnt_tml.php';
				}elseif($__t == 'cnt_cntr'){
					$___to_inc = GL_CNT.'cnt_cntr.php';
				}elseif($__t == 'dsh'){

					$___to_inc = GL.'dsh.php';

				}elseif($__t == 'my_eml'){
					$___to_inc = GL_MYEML.'my_eml.php';
				}elseif($__t == 'my_eml_cnv'){
					$___to_inc = GL_MYEML.'my_eml_cnv.php';
				}elseif($__t == 'my_eml_msg_dt'){
					$___to_inc = GL_MYEML.'my_eml_msg_dt.php'; $__no_c = 'ok';
				}elseif($__t == 'my_eml_stup'){
					$___to_inc = GL_MYEML.'my_eml_stup.php'; $__non_c = 'ok';
				}


				elseif($__t == 'emp_cnt'){
					$___to_inc = GL_EMP.'emp_cnt.php';
				}elseif($__t == 'sms'){
					$___to_inc = GL.'sms.php'; $__non_c = 'ok';


				}elseif($__t == 'img'){
					$___to_inc = GL.'img.php'; $__non_c = 'ok';

				}elseif($__t == 'scl'){
					$___to_inc = GL_SCL.'scl.php'; $__non_c = 'ok';
				}elseif($__t == 'scl_stup'){
					$___to_inc = GL_SCL.'scl_stup.php'; $__non_c = 'ok';
				}elseif($__t == 'scl_acc'){
					$___to_inc = GL_SCL.'scl_acc.php'; $__non_c = 'ok';
				}elseif($__t == 'scl_acc_form'){
					$___to_inc = GL_SCL.'scl_acc_form.php'; $__non_c = 'ok';
				}


				elseif($__t == 'scl_from_lnk'){
					$___to_inc = GL_SCL.'scl_from_lnk.php'; $__non_c = 'ok';
				}elseif($__t == 'scl_acc_cnv_rsp'){
					$___to_inc = GL_SCL.'scl_acc_cnv_rsp.php'; $__non_c = 'ok';

				}elseif($__t == 'cnv'){
					$___to_inc = GL_CNV.'cnv.php'; $__non_c = 'ok';

				}elseif($__t == 'ck_cod'){

					$___to_inc = GL_CK.'ck_cod.php';

				}elseif($__t == 'inf'){

					$___to_inc = GL_INF.'inf.php'; $__non_c = 'ok';

				}elseif($__t == 'inf_dsc'){

					$___to_inc = GL_INF.'inf_dsc.php'; $__non_c = 'ok';

				}elseif($__t == 'mdl_cnt_grph' || $__t == 'mdl_cnt'){
					$___to_inc = GL_GRPH.'_mdl_cnt_grph.php';
				}elseif($__t == 'mdl_cnt_grph2'){
					$___to_inc = GL_GRPH.'_mdl_cnt_grph2.php';
				}elseif($__t == 'mdl_cnt_grph3'){
					$___to_inc = GL_GRPH.'_mdl_cnt_grph3.php';
				}elseif($__t == 'mdl_cnt_grph4'){
					$___to_inc = GL_GRPH.'_mdl_cnt_grph4.php';
				}elseif($__t == 'mdl_cnt_grph5'){
					$___to_inc = GL_GRPH.'_mdl_cnt_grph5.php';
				}elseif($__t == 'mdl_cnt_grph6'){
					$___to_inc = GL_GRPH.'_mdl_cnt_grph6.php';
				}elseif($__t == 'mdl_cnt_grph7'){
					$___to_inc = GL_GRPH.'_mdl_cnt_grph7.php';
				}elseif($__t == 'mdl_cnt_grph8'){
					$___to_inc = GL_GRPH.'_mdl_cnt_grph8.php';

				}elseif($__t == 'org'){
					$___to_inc = GL_GRPH.'org.php';
				}elseif($__t == 'org_attr'){
					$___to_inc = GL_ORG.'org_attr.php';
				}elseif($__t == 'snd'){
					$___to_inc = GL.'snd.php'; $__non_c = 'ok';
				}elseif($__t == 'up_db'){
					$___to_inc = GL_UP.'up_db.php'; $__non_c = 'ok';
				}elseif($__t == 'bn'){
					$___to_inc = GL.'bn.php';
				}elseif($__t == 'org_sds_cnt'){
					//$___to_inc = GL_ORG.'org_sds_cnt.php';

					$___to_inc = GL_CNT.'cnt.php';

				}elseif($__t == 'org_act' || $__t == 'act'){
					$___to_inc = GL_ACT.'act.php';
				}elseif($__t == 'lnd'){
					$___to_inc = GL_LND.'lnd.php';
				}elseif($__t == 'lnd_dt'){
					$___to_inc = GL_LND.'lnd_dt.php'; $__non_c = 'ok';
				}elseif($__t == 'lnd_sgm_his'){
					$___to_inc = GL_LND.'lnd_sgm_his.php';
				}elseif($__t == 'lnd_html'){
					$___to_inc = GL_LND.'lnd_html.php';
					$_if = 'ok';
				}elseif($__t == 'lnd_img_up'){
					$___to_inc = GL_LND.'lnd_img_up.php';
				}elseif($__t == 'lnd_view'){
					$___to_inc = GL_LND.'lnd_view.php';
				}elseif($__t == 'lnd_img'){
					$___to_inc = GL_LND.'lnd_img.php';
				}elseif($__t == 'sis_bd'){
					$___to_inc = GL_SIS.'sis_bd.php'; $__non_c = 'ok';
				}elseif($__t == 'lrn'){
					$___to_inc = GL_LRN.'lrn.php'; $__non_c = 'ok';
				}elseif($__t == 'api_docs'){
					$___to_inc = GL.'api_docs.php'; $__non_c = 'ok';
				}elseif($__t == 'scrpt_plcy'){
					$___to_inc = GL_SCRPT.'scrpt_plcy.php';
				}elseif($__t == 'tra'){
					$___to_inc = GL_TRA.'tra.php'; $__non_c = 'ok';
				}elseif($__t == 'tra_us'){
					$___to_inc = GL_TRA.'tra_us.php'; $__non_c = 'ok';
				}elseif($__t == 'tra_tmlne'){
					$___to_inc = GL_TRA.'tra_tmlne.php'; $__non_c = 'ok';
				}elseif($__t == 'tra_tme'){
					$___to_inc = GL_TRA.'tra_tme.php'; $__non_c = 'ok';
				}elseif($__t == 'tra_flmt'){
					$___to_inc = GL_TRA.'tra_flmt.php';
				}elseif($__t == 'tra_oth'){
					$___to_inc = GL_TRA.'tra_oth.php';
				}elseif($__t == 'tra_cmnt'){
					$___to_inc = GL_TRA.'tra_cmnt.php';
				}elseif($__t == 'whtsp_ifr'){
					$___to_inc = GL_WHTSP.'whtsp_ifr.php';  $__non_c = 'ok';
				}elseif($__t == 'shop_ord'){
					$___to_inc = GL_SHOP.'shop_ord.php';
				}elseif($__t == 'mdl_cnt_his_whtp'){
					$___to_inc = GL_MDL.'mdl_cnt_his_whtp.php';
				}elseif($__t == 'mdl_fle'){
					$___to_inc = GL_MDL.'mdl_fle.php';
				}



				elseif($__t == 'scan_doc'){
					$___to_inc = GL_SCAN.'scan_doc.php';
				}elseif($__t == 'rsllr'){
					$___to_inc = GL_RSLLR.'rsllr.php';
				}elseif($__t == 'rsllr_itm'){
					$___to_inc = GL_RSLLR.'rsllr_itm.php';
				}elseif($__t == 'bco_face'){
					$___to_inc = GL_BCO.'bco_face.php';
				}elseif($__t == 'aws'){
					$___to_inc = GL_AWS.'aws.php';
				}elseif($__t == 'mdl_cnt_ec'){
					$___to_inc = GL_MDL.'mdl_cnt_ec.php';
				}elseif($__t == 'cnt_ec'){
					$___to_inc = GL_CNT.'cnt_ec.php';
				}elseif($__t == 'tra_tag'){
					$___to_inc = GL_TRA.'tra_tag.php';
				}elseif($__t == 'vtex'){
					if($__t2 == 'fdlz'){
						$___to_inc = GL_VTEX.'vtex_fdlz.php';
					}elseif($__t2 == 'sles'){
						$___to_inc = GL_VTEX.'vtex_sles.php';
					}
				}elseif($__t == 'scl_ld'){
					$___to_inc = GL_SCL.'scl_ld.php'; $__non_c = 'ok';
				}


				else{
					$___to_inc = '../../'.DR_AC.DMN_SB.'/'.FL_DT_GN;
				}

			}else{

				echo SESS_again();

	 		}

 		}


	//---------------------- JS SCRIPTS ----------------------//

		$CntWb .= '';
		if($__non_c == 'ok'){ $CntJV .= "$('#cnt').addClass('_non');"; }

	//---------------------- COMPRIME E INCLUYE CONTENIDO ----------------------//

		if($__no_c != 'ok'){ ob_start("cmpr_fm"); }

			echo __popd([ 't'=>'o', 'notw'=>$__non_c, 'c'=>$___Dt ]);
			if($___to_inc != ''){ include($___to_inc); }
			echo __popd([ 't'=>'c', 'notw'=>$__non_c, 'c'=>$___Dt ]);

			if(!isN($CntJV) || !isN($___Dt->jv)){ echo CntJQ($___Dt->jv.$CntJV, 'ok'); }
			if(!isN($CntWb) || !isN($___Dt->js)){ echo CntJQ($_bldr->js.$___Dt->js.$CntWb); }

		if($__no_c != 'ok'){ ob_end_flush(); }

?>