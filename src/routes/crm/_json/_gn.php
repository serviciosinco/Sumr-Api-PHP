<?php
	//---------------------- VARIABLES GET ----------------------//

		$__t = strip_tags($_GET['_t']);

		if($__t == 'us_ses'){
			$NoSes = 'ok';
		}

	//---------------------- INCLUSIÓN DE BASE ----------------------//

		$Rt = '../../includes/';
		$__tme_s = microtime(true);
		$__fbsrc = 'ok';
		include($Rt.'inc.php');

	try{

		//@ini_set('display_errors', true);
		//error_reporting(E_ALL);

	//---------------------- GROUP LIST ----------------------//

		define('GL', __f());
		define('GL_BCO', __f('bco'));
		define('GL_CNT', __f('cnt'));
		define('GL_MDL', __f('mdl'));
		define('GL_CALL', __f('call'));
		define('GL_EMP', __f('emp'));
		define('GL_US', __f('us'));
		define('GL_TRA', __f('tra'));
		define('GL_LND', __f('lnd'));
		define('GL_SCL', __f('scl'));
		define('GL_EC', __f('ec'));
		define('GL_SGN', __f('sgn'));
		define('GL_SIS', __f('sis'));
		define('GL_DSH', __f('dsh'));
		define('GL_MYEML', __f('my_eml'));
		define('GL_CL', __f('cl'));
		define('GL_MY', __f('my'));
		define('GL_ORG', __f('org'));
		define('GL_ACT', __f('act'));
		define('GL_AUTO', __f('_auto'));
		define('GL_DWN', __f('dwn'));
		define('GL_LRN', __f('lrn'));
		define('GL_PLN', __f('pln'));
		define('GL_ATMT', __f('atmt'));
		define('GL_SCRPT', __f('scrpt'));
		define('GL_NTF', __f('ntf'));
		define('GL_CNTR', __f('cntr'));
		define('GL_THRD', __f('thrd'));
		define('GL_TPC', __f('tpc'));
		define('GL_CNTRC', __f('cntrc'));
		define('GL_CHAT', __f('chat'));
		define('GL_RSLLR', __f('rsllr'));
		define('GL_AWS', __f('aws'));
		define('GL_VTEX', __f('vtex'));
		define('GL_UP', __f('up'));

	//---------------------- VARIABLES GET ----------------------//

		$__i = Php_Ls_Cln($_POST['_i']);
		$__q = Php_Ls_Cln($_POST['__q']);

		$__t = Php_Ls_Cln($_GET['_t']);
		$__prfx = _Fx_Prx(['v'=>$__t]);
		$__last = Php_Ls_Cln($_POST['_last']);
		$__fltr = Php_Ls_Cln($_GET['_fltr']);

		$_dr_nm = dirname(__FILE__);
		$rsp['e'] = 'no';

	//---------------------- ACCOUNT DATA ----------------------//

		$_Crm_Aud = new CRM_Aud();
		$___Ls = new CRM_Ls();
		$_aws = new API_CRM_Aws();

	//---------------------- INCLUSIÓN DE ARCHIVOS ----------------------//


		if((ChckSESS_adm() || ChckSESS_usr()) && $NoSes != 'ok'){

			if($__t == 'cnt'){

				$___to_inc = GL_CNT.'cnt.php';

			}elseif($__t == 'cnt_bd'){

				$___to_inc = GL_CNT.'cnt_bd.php';

			}elseif($__t == 'cnt_tp'){

				$___to_inc = GL_CNT.'cnt_tp.php';

			}elseif($__t == 'cnt_sndi'){

				$___to_inc = GL_CNT.'cnt_sndi.php';

			}elseif($__t == 'cnt_appl_tpc'){

				$___to_inc = GL_CNT.'cnt_appl_tpc.php';

			}elseif($__t == 'cnt_eml_sndi'){

				$___to_inc = GL_CNT.'cnt_eml_sndi.php';

			}elseif($__t == 'cnt_tel_sndi'){

				$___to_inc = GL_CNT.'cnt_tel_sndi.php';

			}elseif($__t == 'mdl'){

				$___to_inc = GL_MDL.'mdl.php';

			}elseif($__t == 'act_sch'){

				$___to_inc = GL_ACT.'act_sch.php';

			}elseif($__t == 'mdl_cnt'){

				$___to_inc = GL_MDL.'mdl_cnt.php';

			}elseif($__t == 'mdl_cnt_ext'){

				$___to_inc = GL_MDL.'mdl_cnt_ext.php';

			}elseif($__t == 'mdl_cnt_prd'){

				$___to_inc = GL_MDL.'mdl_cnt_prd.php';

			}elseif($__t == 'mdl_cnt_sch'){

				$___to_inc = GL_MDL.'mdl_cnt_sch.php';

			}elseif($__t == 'mdl_cnt_pay_lnk'){

				$___to_inc = GL_MDL.'mdl_cnt_pay_lnk.php';

			}elseif($__t == 'mdl_cnt_grph'){

				$___to_inc = GL_MDL.'mdl_cnt_grph.php';

			}elseif($__t == 'mdl_gen'){

				$___to_inc = GL_MDL.'mdl_gen.php';

			}elseif($__t == 'mdl_sch'){

				$___to_inc = GL_MDL.'mdl_sch.php';

			}elseif($__t == 'us_grp'){

				$___to_inc = GL_US.'us_grp.php';

			}elseif($__t == 'us'){

				$___to_inc = GL_US.'us.php';

			}elseif($__t == 'cl_grp'){

				$___to_inc = GL_CL.'cl_grp.php';

			}elseif($__t == 'emp'){

				$___to_inc = GL_EMP.'emp.php';

			}elseif($__t == 'emp_grp'){

				$___to_inc = GL_EMP.'emp_grp.php';

			}elseif($__t == 'emp_rsp' || $__prfx->lt == 'emp_rsp'){

				$___to_inc = GL_EMP.'emp_rsp.php';


			}elseif($__t == 'emp_upd'){

				$___to_inc = GL_EMP.'emp_upd.php';

			}elseif($__t == 'mnu_cl'){

				$___to_inc = GL.'mnucustomer.php';

			}elseif($__t == 'call'){

				$___to_inc = GL_CALL.'call.php';

			}elseif($__t == '_auto'){

				$___to_inc = GL_AUTO.'index.php';

			}elseif($__t == 'call_phnadd'){

				$___to_inc = GL_CALL.'call_phnadd.php';

			}elseif($__t == 'call_mydvc'){

				$___to_inc = GL_CALL.'call_mydvc.php';

			}elseif($__t == 'us_bupd'){

				$___to_inc = GL_US.'us_bupd.php';

			}elseif($__t == 'us_mdl'){

				$___to_inc = GL_US.'us_mdl.php';

			}elseif($__t == 'us_cl'){

				$___to_inc = GL_US.'uscustomer.php';

			}elseif($__t == 'us_nvgt'){

				$___to_inc = GL_US.'us_nvgt.php';

			}elseif($__t == 'pnl'){

				$___to_inc = GL.'pnl.php';

			}elseif($__t == 'dsh_mtrc'){

				$___to_inc = GL_DSH.'dsh_mtrc.php';

			}elseif($__t == 'grph_bx'){

				$___to_inc = GL.'grph_row.php';

			}elseif($__t == 'dsh'){

				$___to_inc = GL_DSH.'dsh.php';

			}elseif($__t == 'tra'){

				$___to_inc = GL.'tra.php';

			}elseif($__t == 'lnd'){

				$___to_inc = GL_LND.'lnd.php';

			}elseif($__t == 'scl'){

				$___to_inc = GL_SCL.'scl.php';

			}elseif($__t == 'scl_acc'){

				$___to_inc = GL_SCL.'scl_acc.php';

			}elseif($__t == 'scl_acc_attr'){

				$___to_inc = GL_SCL.'scl_acc_attr.php';

			}elseif($__t == 'ec'){

				$___to_inc = GL_EC.'ec.php';

			}elseif($__t == 'ec_dsgn' || $__prfx->lt == 'ec_dsgn'){

				$___to_inc = GL_EC.'ec_dsgn.php';

			}elseif($__t == 'ec_dsgn_crt' || $__prfx->lt == 'ec_dsgn_crt'){

				$___to_inc = GL_EC.'ec_dsgn_crt.php';

			}elseif($__t == 'ec_snd_grph'){

				$___to_inc = GL_EC.'ec_snd_grph.php';

			}elseif($__t == 'sgn'){

				$___to_inc = GL_SGN.'sgn.php';

			}elseif($__t == 'sgn_cod'){

				$___to_inc = GL_SGN.'sgn_cod.php';

			}elseif($__t == 'my_eml'){

				$___to_inc = GL_MYEML.'_gn.php';

			}elseif($__t == 'sis_fnt_cl'){

				$___to_inc = GL_SIS.'sis_fntcustomer.php';

			}elseif($__t == 'sis_cnt_noi_are'){

				$___to_inc = GL_SIS.'sis_cnt_noi_are.php';

			}elseif($__t == 'sis_cnt_est'){

				$___to_inc = GL_SIS.'sis_cnt_est.php';

			}elseif($__t == 'sis_md_cl'){

				$___to_inc = GL_SIS.'sis_mdcustomer.php';

			}elseif($__t == 'mdl_s_tp'){

				$___to_inc = GL_MDL.'mdl_s_tp.php';

			}elseif($__t == 'mdl_s_tp_cl'){

				$___to_inc = GL_MDL.'mdl_s_tpcustomer.php';

			}elseif($__t == 'html_scan'){

				$___to_inc = GL.'html_scan.php'; $__no_c='ok';

			}elseif($__t == 'sis_slc_f'){

				$___to_inc = GL_SIS.'sis_slc_f.php';

			}elseif($__t == 'sis_prc_rsl'){

				$___to_inc = GL_SIS.'sis_prc_rsl.php';

			}elseif($__t == 'sql_btf'){

				$___to_inc = GL.'sql_btf.php';





			}elseif($__t == 'org'){

				$___to_inc = GL_ORG.'org.php';

			}elseif($__t == 'org_tp'){

				$___to_inc = GL_ORG.'org_tp.php';

			}elseif($__t == 'org_sds_zna'){

				$___to_inc = GL_ORG.'org_sds_zna.php';

			}elseif($__t == 'org_dst'){

				$___to_inc = GL_ORG.'org_dst.php';

			}elseif($__t == 'org_acds'){

				$___to_inc = GL_ORG.'org_acds.php';

			}elseif($__t == 'org_ext'){

				$___to_inc = GL_ORG.'org_ext.php';

			}elseif($__t == 'mdl_ext'){

				$___to_inc = GL_MDL.'mdl_ext.php';

			}





			elseif($__t == 'act_mdl'){

				$___to_inc = GL_ACT.'act_mdl.php';

			}elseif($__t == 'act_rsp'){

				$___to_inc = GL_ACT.'act_rsp.php';

			}elseif($__t == 'act_grds'){

				$___to_inc = GL_ACT.'act_grd.php';


			}elseif($__t == 'act_cnt'){

				$___to_inc = GL_ACT.'act_cnt.php';


			}elseif($__t == 'act_org'){


				$___to_inc = GL_ACT.'act_org.php';


			}
			elseif($__t == 'enc_dts'){

				$___to_inc = GL_MDL.'enc_dts.php';


			}elseif($__t == 'cl_mdl_are'){

				$___to_inc = GL_CL.'cl_mdl_are.php';


			}elseif($__t == 'dwn_mdl_cnt'){

				//if(SUMR_ENV != 'prd' &&  SUMR_ENV != 'dev'){
					$___to_inc = GL_DWN.'dwn_mdl_cnt_tmp.php';
				//}else{
				//	$___to_inc = GL_DWN.'dwn_mdl_cnt.php';
				//}

			}elseif($__t == 'dwn_cnt_appl'){

				$___to_inc = GL_DWN.'dwn_cnt_appl.php';


			}elseif($__t == 'sis_cnt_est_are'){

				$___to_inc = GL_SIS.'sis_cnt_est_are.php';


			}elseif($__t == 'ec_tp'){

				$___to_inc = GL_EC.'ec_tp.php';


			}elseif($__t == 'snd_ec_cpy'){

				$___to_inc = GL_EC.'ec_cpy.php';


			}elseif($__t == 'ec_are'){

				$___to_inc = GL_EC.'ec_are.php';


			}elseif($__t == 'snd_ec_cmz'){

				$___to_inc = GL_EC.'ec_cmz.php'; $__no_c='ok';

			}elseif($__t == 'snd_ec'){

				$___to_inc = GL_EC.'ec.php';

			}elseif($__t == 'snd_ec_cpy'){

				$___to_inc = GL_EC.'ec_cpy.php';

			}elseif($__t == 'snd_ec_cmpg'){

				$___to_inc = GL_EC.'ec_cmpg.php';

			}elseif($__t == 'lrn'){

				$___to_inc = GL_LRN.'lrn.php';

			}elseif($__t == 'lrn_vd_cl'){
				$___to_inc = GL_LRN.'lrn_vdcustomer.php';

			}elseif($__t == 'mdl_s_tp_fm'){

				$___to_inc = GL_MDL.'mdl_s_tp_fm.php';


			}elseif($__t == 'pln_cmp'){

				$___to_inc = GL_PLN.'pln_cmp.php';


			}elseif($__t == 'bco'){

				$___to_inc = GL_BCO.'bco.php';

			}elseif($__t == 'bco_rote'){

				$___to_inc = GL_BCO.'bco_rote.php';

			}elseif($__t == 'bco_to_eccmz'){

				$___to_inc = GL_BCO.'bco_to_eccmz.php';

			}elseif($__t == 'sis_fnt'){

				$___to_inc = GL_SIS.'sis_fnt.php';




			}elseif($__t == 'atmt_mdl'){

				$___to_inc = GL_ATMT.'atmt_mdl.php';

			}elseif($__t == 'atmt_sndi'){

				$___to_inc = GL_ATMT.'atmt_sndi.php';

			}


			elseif($__t == 'mdl_cnt_chck'){

				$___to_inc = GL_MDL.'mdl_cnt_chck.php';

			}elseif($__t == 'cl_row'){

				$___to_inc = GL_CL.'cl_row.php';

			}elseif($__t == 'cnt_prnt'){

				$___to_inc = GL_CNT.'cnt_prnt.php';

			}elseif($__t == 'scrpt_plcy'){

				$___to_inc = GL_SCRPT.'scrpt_plcy.php';

			}elseif($__t == 'ntf'){

				$___to_inc = GL_NTF.'ntf.php';

			}elseif($__t == 'mdl_tabs'){

				$___to_inc = GL_MDL.'mdl_tabs.php';

			}




			elseif($__t == 'ec_cmpg_ext'){

				$___to_inc = GL_EC.'ec_cmpg_ext.php';

			}elseif($__t == 'ec_lsts_sgm'){

				$___to_inc = GL_EC.'ec_lsts_sgm.php';

			}elseif($__t == 'ec_lsts_are'){

				$___to_inc = GL_EC.'ec_lsts_are.php';

			}elseif($__t == 'ec_lsts_sndi'){

				$___to_inc = GL_EC.'ec_lsts_sndi.php';

			}elseif($__t == 'ec_lsts_ext'){

				$___to_inc = GL_EC.'ec_lsts_ext.php';

			}




			elseif($__t == 'sis_slc_tp'){

				$___to_inc = GL_SIS.'sis_slc_tp.php';

			}elseif($__t == 'mdl_fle'){

				$___to_inc = GL_MDL.'mdl_fle.php';

			}elseif($__t == 'appl_fm'){

				$___to_inc = GL_CNTR.'appl_fm.php';

			}elseif($__t == 'eml_vrfc'){

				$___to_inc = GL_THRD.'eml_vrfc.php';

			}elseif($__t == 'eml_cl'){

				$___to_inc = GL_SCL.'emlcustomer.php';

			}elseif($__t == 'tpc'){

				$___to_inc = GL_TPC.'tpc.php';

			}elseif($__t == 'bitly'){

				$___to_inc = GL.'bitly.php';

			}elseif($__t == 'bco_are'){

				$___to_inc = GL_BCO.'bco_are.php';

			}elseif($__t == 'new_cd'){

				$___to_inc = GL.'new_cd.php';

			}elseif($__t == 'bco_tag'){

				$___to_inc = GL_BCO.'bco_tag.php';

			}elseif($__t == 'eml'){

				$___to_inc = GL_THRD.'eml.php';

			}elseif($__t == 'cntrc'){

				$___to_inc = GL_CNTRC.'cntrc.php';

			}elseif($__t == 'ec_lsts'){
				$___to_inc = GL_EC.'ec_lsts.php';
			}elseif($__t == 'ec_sgm'){
				$___to_inc = GL_EC.'ec_sgm.php';
			}elseif($__t == 'cnt_appl'){
				$___to_inc = GL_CNT.'cnt_appl.php';
			}elseif($__t == 'cnt_appl_cntrc'){
				$___to_inc = GL_CNT.'cnt_appl_cntrc.php';
			}elseif($__t == 'cnt_appl_est'){
				$___to_inc = GL_CNT.'cnt_appl_est.php';


			}elseif($__t == 'chat_cnvr_msj'){

				$___to_inc = GL_CHAT.'chat_cnvr_msj.php';

			}elseif($__t == 'chat_cnvr_msj_new'){

				$___to_inc = GL_CHAT.'chat_cnvr_msj_new.php';

			}elseif($__t == 'chat_us'){

				$___to_inc = GL_CHAT.'chat_us.php';

			}elseif($__t == 'act_tp'){
				$___to_inc = GL_ACT.'act_tp.php';
			}elseif($__t == 'act_ext'){
				$___to_inc = GL_ACT.'act_ext.php';
			}




			elseif($__t == 'rsllr_sch_org'){
				$___to_inc = GL_RSLLR.'rsllr_sch_org.php';
			}elseif($__t == 'org_grp'){
				$___to_inc = GL_ORG.'org_grp.php';
			}elseif($__t == 'cnt_eml_ext'){

				$___to_inc = GL_CNT.'cnt_eml_ext.php';

			}elseif($__t == 'cnt_tel_ext'){

				$___to_inc = GL_CNT.'cnt_tel_ext.php';

			}elseif($__t == 'cnt_cntc'){

				$___to_inc = GL_CNT.'cnt_cntc.php';

			}elseif($__t == 'mdl_cnt_h_cntc'){

				$___to_inc = GL_MDL.'mdl_cnt_h_cntc.php';

			}elseif($__t == 'mdl_cnt_attr'){

				$___to_inc = GL_MDL.'mdl_cnt_attr.php';

			}elseif($__t == 'mdl_s_prd_tp'){

				$___to_inc = GL_MDL.'mdl_s_prd_tp.php';

			}elseif($__t == 'mdl_s_prd_ext'){

				$___to_inc = GL_MDL.'mdl_s_prd_ext.php';

			}elseif($__t == 'org_sds_pass'){

				$___to_inc = GL_ORG.'org_sds_pass.php';

			}elseif($__t == 'org_cnt'){

				$___to_inc = GL_ORG.'org_cnt.php';

			}elseif($__t == 'aws'){

				$___to_inc = GL_AWS.'aws.php';

			}elseif($__t == 'act_grd'){

				$___to_inc = GL_ACT.'act_grd.php';

			}elseif($__t == 'org_scec'){

				$___to_inc = GL_ORG.'org_scec.php';

			}elseif($__t == 'act_gen_grd'){

				$___to_inc = GL_ACT.'act_gen_grd.php';

			}elseif($__t == 'tra_tag'){

				$___to_inc = GL_TRA.'tra_tag.php';

			}elseif($__t == 'auto_tp_ext'){

				$___to_inc = GL_SIS.'auto_tp_ext.php';

			}elseif($__t == 'auto_cl'){

				$___to_inc = GL_SIS.'autocustomer.php';

			}elseif($__t == 'org_grph'){

				$___to_inc = GL_ORG.'org_grph.php';

			}elseif($__t == 'mdl_s_tp_fm_attr'){

				$___to_inc = GL_MDL.'mdl_s_tp_fm_attr.php';

			}elseif($__t == 'org_tag'){

				$___to_inc = GL_ORG.'org_tag.php';

			}elseif($__t == 'org_sds_arr_lcl'){

				$___to_inc = GL_ORG.'org_sds_arr_lcl.php';

			}elseif($__t == 'mdl_s_tp_fm_exc'){

				$___to_inc = GL_MDL.'mdl_s_tp_fm_exc.php';

			}elseif($__t == 'mdl_s_tp_tra'){

				$___to_inc = GL_MDL.'mdl_s_tp_tra.php';

			}elseif($__t == 'tra_dsh'){

				$___to_inc = GL_TRA.'tra_dsh.php';

			}elseif($__t == 'org_dsh'){

				$___to_inc = GL_ORG.'org_dsh.php';

			}elseif($__t == 'tra_col_us'){

				$___to_inc = GL_TRA.'tra_col_us.php';

			}elseif($__t == 'mdl_s_tp_fm_ps'){

				$___to_inc = GL_MDL.'mdl_s_tp_fm_ps.php';

			}elseif($__t == 'vtex_fdlz'){

				$___to_inc = GL_VTEX.'vtex_fdlz.php';

			}elseif($__t == 'up_cnt'){

				$___to_inc = GL_UP.'up_cnt.php';

			}elseif($__t == 'org_sds_cnt_ext'){

				$___to_inc = GL_ORG.'org_sds_cnt_ext.php';

			}elseif($__t == 'snd'){

				$___to_inc = GL.'snd.php';

			}elseif($__t == 'ec_lsts_dt'){
				$___to_inc = GL_EC.'ec_lsts_dt.php';
			}elseif($__t == 'mdl_json'){
				$___to_inc = GL_MDL.'mdl_json.php';
			}elseif($__t == 'dwn'){
				$___to_inc = GL_DWN.'dwn.php';
			}elseif($__t == 'act'){
				$___to_inc = GL_ACT.'act.php';
			}elseif($__t == 'us_mod'){
				$___to_inc = GL_US.'us_mod.php';
			}elseif($__t == 'act_cnt_ext'){
				$___to_inc = GL_ACT.'act_cnt_ext.php';
			}elseif($__t == 'org_sds_cnt_crg'){
				$___to_inc = GL_ORG.'org_sds_cnt_crg.php';
			}elseif($__t == 'us_grp'){
				$___to_inc = GL_US.'us_grp.php';
			}else{

				$___to_inc = '../../'.DR_AC.DMN_SB.'/'.FL_JSON_GN;

			}

		}elseif($__t == 'us_ses'){

			$___to_inc = GL_US.'us_ses.php';
			$nosess='ok';

		}else{

			$___401e = 'ok';

		}


	//---------------------- COMPRIME E INCLUYE CONTENIDO --------------//

		if($__no_c != 'ok'){ ob_start("cmpr_fm"); }

			Hdr_JSON();

			if($___to_inc != ''){ include($___to_inc); }

			//---------------------- SESSION DATA ----------------------//

				if( $nosess != 'ok'){
					if(is_object($rsp)){
						$rsp->ses = SesPblc($_GtSesDt);
					}else{
						$rsp['ses'] = SesPblc($_GtSesDt);
					}
				}

			//---------------------- RETURN JSON DATA ----------------------//

			$rtrn = json_encode($rsp);

			if($rtrn != '' && $rtrn != NULL && !empty($rtrn)){ echo $rtrn; }
			if(!isN( json_last_error() )){
				echo ' Encode ERROR ('.json_last_error().'):'.json_last_error_msg();
			}

			if($___401e == 'ok' && $_GtSesDt->e != 'ok'){ header("HTTP/1.1 401 Unauthorized"); }

		if($__no_c != 'ok'){ ob_end_flush(); }

	}catch(Exception $e){

        echo $e->getMessage();

    }


?>