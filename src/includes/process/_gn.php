<?php


	//---------------------- VARIABLES GET ----------------------//

		$__t = strip_tags($_GET['_t']);
		$__r['v'] = $_POST;
		$rsp['e'] = 'no';

	//---------------------- INCLUSIÓN DE BASE ----------------------//

		$Rt = '../../includes/';

		if($__t != 'login' && $__t != 'logout' && $__t != 'us_frgt_pss' && $__t != 'us_rst_pss'){
			$Rstr = 'adm';
		}

		if($__t == 'scl'){  $__fbsrc = 'ok'; }
		if($__t == 'login'){ $__chksess = 'no'; }

		include($Rt.'inc.php');
		$__prfx = _Fx_Prx(['v'=>$__t]);

	//---------------------- Instancia de clases ----------------------//

		//CRM_Aud::In_Aud(array("aud"=>"416", "post"=>$_POST));
		$_Crm_Aud = new CRM_Aud();
		$___Prc = new CRM_Prc();
		$_aws = new API_CRM_Aws();


	//---------------------- GROUP LIST ----------------------//

		define('GL', __f());
		define('GL_ATMT', __f('atmt'));
		define('GL_CNT', __f('cnt'));
		define('GL_MDL', __f('mdl'));
		define('GL_EMP', __f('emp'));
		define('GL_TRA', __f('tra'));
		define('GL_SIS', __f('sis'));
		define('GL_CL', __f('cl'));
		define('GL_SMS', __f('sms'));
		define('GL_US', __f('us'));
		define('GL_UP', __f('up'));
		define('GL_GRPH', __f('grph'));
		define('GL_SCL', __f('scl'));
		define('GL_EC', __f('ec'));
		define('GL_ENC', __f('enc'));
		define('GL_AUD', __f('aud'));
		define('GL_SGN', __f('sgn'));
		define('GL_PRC', __f('up_prc'));
		define('GL_LND', __f('lnd'));
		define('GL_DSH', __f('dsh'));
		define('GL_MY', __f('my'));
		define('GL_ORG', __f('org'));
		define('GL_BN', __f('bn'));
		define('GL_ACT', __f('act'));
		define('GL_LRN', __f('lrn'));
		define('GL_WBHK', __f('wbhk'));
		define('GL_PLN', __f('pln'));
		define('GL_VST', __f('vst'));
		define('GL_BCO', __f('bco'));
		define('GL_RD', __f('rd'));
		define('GL_HSH', __f('hsh'));
		define('GL_TPC', __f('tpc'));
		define('GL_CNTR', __f('cntr'));
		define('GL_RSLLR', __f('rsllr'));
		define('GL_SORT', __f('sort'));
		define('GL_VTEX', __f('vtex'));
		define('GL_STORE', __f('store'));
		define('GL_DWN', __f('dwn'));
		define('GL_CNV', __f('cnv'));


	//---------------------- INCLUSIÓN DE ARCHIVOS ----------------------//


	if((ChckSESS_adm() || ChckSESS_usr()) && !isN($Rstr)){

		if($__t == 'atmt'){

			$___to_inc = GL_ATMT.'atmt.php';

		}elseif($__t == 'atmt_etp'){

			$___to_inc = GL_ATMT.'atmt_etp.php';

		}elseif($__t == 'atmt_trgr'){

			$___to_inc = GL_ATMT.'atmt_trgr.php';

		}elseif($__t == 'atmt_trgr_act'){

			$___to_inc = GL_ATMT.'atmt_trgr_act.php';

		}elseif($__t == 'atmt_trgr_cndc'){

			$___to_inc = GL_ATMT.'atmt_trgr_cndc.php';

		}elseif($__t == 'mdl_cnt_vst'){

			$___to_inc = GL_VST.'vst.php';

		}elseif($__t == 'pln_cmp'){

			$___to_inc = GL_PLN.'pln_cmp.php';

		}elseif($__t == 'pln_cmp_gst'){

			$___to_inc = GL_PLN.'pln_cmp_gst.php';

		}elseif($__t == 'wbhk'){

			$___to_inc = GL_WBHK.'wbhk.php';

		}elseif($__t == 'emp_cnt' || $__prfx->lt == 'emp_cnt'){
			$___to_inc = GL_EMP.PRC_EMP_CNT;
		}elseif($__t == 'cnt'){
			$___to_inc = GL_CNT.PRC_CNT;
	    }elseif($__t == 'cnt_rlc'){
			$___to_inc = GL_CNT.PRC_CNT_RLC;
	    }elseif($__t == 'cnt_eml'){
			$___to_inc = GL_CNT.'cnt_eml.php';
		}elseif($__t == 'cnt_org_sds'){

			$___to_inc = GL_CNT.'cnt_org_sds.php';

		}elseif($__t == 'cnt_prnt'){
			$___to_inc = GL_CNT.'cnt_prnt.php';

		}elseif($__t == 'cnt_dc'){
			$___to_inc = GL_CNT.'cnt_dc.php';
		}elseif($__t == 'cnt_tel'){

			$___to_inc = GL_CNT.'cnt_tel.php';

		}elseif($__t == 'cnt_cd'){
			$___to_inc = GL_CNT.'cnt_cd.php';

		}elseif($__t == 'cnt_appl'){
			$___to_inc = GL_CNT.'cnt_appl.php';

		}elseif($__t == 'cnt_appl_attr'){
			$___to_inc = GL_CNT.'cnt_appl_attr.php';

		}elseif($__t == 'cnt_appl_romt'){
			$___to_inc = GL_CNT.'cnt_appl_romt.php';

		}elseif($__t == 'cnt_appl_anx'){
			$___to_inc = GL_CNT.'cnt_appl_anx.php';

		}elseif($__t == 'appl_fm'){
			$___to_inc = GL_CNTR.'appl_fm.php';

		}elseif($__t == 'emp' || $__prfx->lt == 'emp'){
			$___to_inc = GL_EMP.PRC_EMP;
		}elseif($__t == 'emp_sub'){
			$___to_inc = GL_EMP.PRC_EMP_SUB;
		}elseif($__t == 'emp_grp'){
			$___to_inc = GL_EMP.PRC_EMPGRP;
		}elseif($__t == 'emp_vst' || $__prfx->lt == 'emp_vst'){
			$___to_inc = GL_EMP.PRC_EMP_VST;
		}elseif($__t == 'emp_ofr' || $__prfx->lt == 'emp_ofr'){
			$___to_inc = GL_EMP.PRC_EMP_OFR;
		}elseif($__t == 'emp_his' || $__prfx->lt == 'emp_his'){
			$___to_inc = GL_EMP.PRC_EMP_HIS;
		}elseif($__t == 'emp_rsp' || $__prfx->lt == 'emp_rsp'){
			$___to_inc = GL_EMP.PRC_EMP_RSP;
	    }elseif($__t == 'emp_ofr_fle'){
			$___to_inc = GL_EMP.PRC_EMP_OFR_FLE;


		}elseif($__t == 'tra' || $__t == 'emp_vst_tra' || $__prfx->lt == 'tra' ){
			$___to_inc = GL_TRA.PRC_TRA;
		}elseif($__t == 'tra_rsp'){
			$___to_inc = GL_TRA.MDL_TRA_RSP_LS;
		}elseif($__t == 'tra_col' || $__t == 'tra_col_grp'){
			$___to_inc = GL_TRA.'tra_col.php';
		}elseif($__t == 'sis' || $__t == 'cl_sis'){
			$___to_inc = GL_SIS.PRC_SIS; $__non_c = 'ok';
		}elseif($__t == 'sis_vst_aplz'){
			$___to_inc = GL_SIS.PRC_VST_APLZ;
		}elseif($__t == 'sis_vst_est'){
			$___to_inc = GL_SIS.PRC_VST_EST;
		}elseif($__t == 'sis_vst_tp'){
			$___to_inc = GL_SIS.PRC_VST_TP;
		}elseif($__t == 'sis_cnt_noi'){
			$___to_inc = GL_SIS.'sis_cnt_noi.php';
		}elseif($__t == 'sis_cnt_tag'){
			$___to_inc = GL_SIS.'sis_cnt_tag.php';
		}elseif($__t == 'sis_cnt_tp'){
			$___to_inc = GL_SIS.'sis_cnt_tp.php';
		}elseif($__t == 'sis_cnt_tp_grp'){
			$___to_inc = GL_SIS.'sis_cnt_tp_grp.php';
		}elseif($__t == 'sis_cnt_est'){
			$___to_inc = GL_SIS.'sis_cnt_est.php';
		}elseif($__t == 'sis_cnt_est_tp'){
			$___to_inc = GL_SIS.'sis_cnt_est_tp.php';
		}elseif($__t == 'sis_aud'){
			$___to_inc = GL_SIS.PRC_SIS_AUD;
		}elseif($__t == 'sis_tex' || $__t == 'cl_tex'){
			$___to_inc = GL_SIS.'sis_tex.php';
		}elseif($__t == 'sis_tra_tp' ){
			$___to_inc = GL_SIS.'sis_tra_tp.php';
		}elseif($__t == 'sis_tra_est' ){
			$___to_inc = GL_SIS.'sis_tra_est.php';
		}elseif($__t == 'sis_ps'){
			$___to_inc = GL_SIS.'sis_ps.php';
		}elseif($__t == 'sis_cd'){
			$___to_inc = GL_SIS.'sis_cd.php';
		}elseif($__t == 'sis_md' || $__t == 'sis_md_cl'){
			$___to_inc = GL_SIS.'sis_md.php';
		}elseif($__t == 'sis_fnt' || $__t == 'sis_fnt_cl'){
			$___to_inc = GL_SIS.'sis_fnt.php';
		}elseif($__t == 'sis_emp_grp'){
			$___to_inc = GL_EMP.'sis_emp_grp.php';
		}elseif($__t == 'sis_lng'){
			$___to_inc = GL_SIS.'sis_lng.php';
		}elseif($__t == 'sis_cdn'){
			$___to_inc = GL_SIS.'sis_cdn.php';
		}elseif($__t == 'sis_font'){
			$___to_inc = GL_SIS.'sis_font.php';






		}elseif($__t == 'aud_key'){
			$___to_inc = GL_AUD.'aud_key.php';
		}elseif($__t == 'us'){
			$___to_inc = GL_US.PRC_US;
		}elseif($__t == 'us_cl'){
			$___to_inc = GL_US.'uscustomer.php';
		}elseif($__t == 'us_mdl'){
			$___to_inc = GL_US.'us_mdl.php';
		}elseif($__t == 'us_grp_prm'){
			$___to_inc = GL_US.'us_grp_prm.php';
		}elseif($__t == 'us_tkn'){
			$___to_inc = GL_US.PRC_US_TKN;
		}elseif($__t == 'us_dvc'){
			$___to_inc = GL_US.PRC_US_DVC;
		}elseif($__t == 'us_tel'){
			$___to_inc = GL_US.'us_tel.php';
		}elseif($__t == 'us_eml'){
			$___to_inc = GL_US.'us_eml.php';
		}elseif($__t == 'us_rg'){
			$___to_inc = GL_US.PRC_US_RG;
		}elseif($__t == 'us_frce_lgin'){
			$___to_inc = GL_US.'us_frce_lgin.php';
		}
		elseif($__t == 'my_pss'){
			$___to_inc = GL_MY.'pss.php';
		}elseif($__t == 'my_lng'){
			$___to_inc = GL_MY.'lng.php';
		}elseif($__t == 'up'){
			$___to_inc = GL_UP.'_up.php';
		}elseif($__t == 'up_col'){
			$___to_inc = GL_UP.'up_col.php';
		}elseif($__t == 'dsh_mtrc'){
			$___to_inc = GL_DSH.'dsh_mtrc.php';
		}elseif($__t == 'dsh_dms'){

			$___to_inc = GL_DSH.'dsh_dms.php';

		}elseif($__t == '_grph'){

			$___to_inc = GL_GRPH.PRC_GRPH;

		}elseif($__t == '_grph_chr'){
			$___to_inc = GL_GRPH.'_grph_chr.php';

		}elseif($__t == '_grph_chr_rlc'){

			$___to_inc = GL_GRPH.'_grph_chr_rlc.php';

		}elseif($__t == 'mnu_cl' || $__t == 'cl_mnu' || $__t == 'cl_mnu_cl'){

			$___to_inc = GL_CL.'cl_mnu.php';

		}elseif($__t == 'cl_dmn'){

			$___to_inc = GL_CL.'cl_dmn.php';

		}elseif($__t == 'cl_dmn_sub'){

			$___to_inc = GL_CL.'cl_dmn_sub.php';

		}elseif($__t == 'cl_lcl'){

			$___to_inc = GL_CL.'cl_lcl.php';

		}elseif($__t == 'sis_slc' || $__t == 'cl_slc'){
			$___to_inc = GL_SIS.'sis_slc.php';
		}elseif($__t == 'sis_slc_tp' || $__t == 'cl_slc_tp'){
			$___to_inc = GL_SIS.'sis_slc_tp.php';
		}elseif($__t == 'sis_slc_tp_f' || $__t == 'cl_slc_tp_f'){
			$___to_inc = GL_SIS.'sis_slc_tp_f.php';
		}elseif($__t == 'sis_slc_f' || $__t == 'cl_slc_f'){
			$___to_inc = GL_SIS.'sis_slc_f.php';

		}elseif($__t == 'cl'){
			$___to_inc = GL_CL.'cl.php';
		}elseif($__t == 'cl_tag'){
			$___to_inc = GL_CL.'cl_tag.php';
		}elseif($__t == 'cl_are'){
			$___to_inc = GL_CL.'cl_are.php';
		}elseif($__t == 'cl_grp'){
			$___to_inc = GL_CL.'cl_grp.php';
		}elseif($__t == 'cl_ftp'){
			$___to_inc = GL_CL.'cl_ftp.php';
		}elseif($__t == 'cl_flj'){
			$___to_inc = GL_CL.'cl_flj.php';
		}elseif($__t == 'cl_bd'){
			$___to_inc = GL_CL.'cl_bd.php';
		}elseif($__t == 'cl_wdgt'){
			$___to_inc = GL_CL.'cl_wdgt.php';
		}elseif($__t == 'cl_wdgt_act'){
			$___to_inc = GL_CL.'cl_wdgt_act.php';
		}elseif($__t == 'cl_wthsp'){
			$___to_inc = GL_CL.'cl_wthsp.php';
		}elseif($__t == 'cl_aws_acc'){
			$___to_inc = GL_CL.'cl_aws_acc.php';
		}elseif($__t == 'cl_gtwy_pay'){
			$___to_inc = GL_CL.'cl_gtway_pay.php';
		}elseif($__t == 'cl_vtex'){
			$___to_inc = GL_CL.'cl_vtex.php';
		}









		elseif($__t == 'org'){
			$___to_inc = GL_ORG.'org.php';
		}elseif($__t == 'org_sds_etd'){
			$___to_inc = GL_ORG.'org_sds_etd.php';
		}elseif($__t == 'org_sds_dc'){
			$___to_inc = GL_ORG.'org_sds_dc.php';
		}elseif($__t == 'org_sds_tel'){
			$___to_inc = GL_ORG.'org_sds_tel.php';
		}elseif($__t == 'org_sds_eml'){
			$___to_inc = GL_ORG.'org_sds_eml.php';
		}elseif($__t == 'org_sds_arr'){
			$___to_inc = GL_ORG.'org_sds_arr.php';
		}elseif($__t == 'org_sds_arr_rg'){
			$___to_inc = GL_ORG.'org_sds_arr_rg.php';
		}elseif($__t == 'org_sds_arr_sls'){
			$___to_inc = GL_ORG.'org_sds_arr_sls.php';
		}elseif($__t == 'org_web'){
			$___to_inc = GL_ORG.'org_web.php';
		}elseif($__t == 'org_gst'){
			$___to_inc = GL_ORG.'org_gst.php';
		}elseif($__t == 'org_sds'){
			$___to_inc = GL_ORG.'org_sds.php';
		}elseif($__t == 'org_sds_cnt'){
			$___to_inc = GL_ORG.'org_sds_cnt.php';
		}elseif($__t == 'org_act' || $__t == 'act'){
			$___to_inc = GL_ACT.'act.php';
		}elseif($__t == 'act_chk'){
			$___to_inc = GL_ACT.'act_chk.php';
		}elseif($__t == 'act_rsp'){
			$___to_inc = GL_ACT.'act_chk.php';
		}elseif($__t == 'act_org'){
			$___to_inc = GL_ACT.'act_org.php';
		}elseif($__t == 'act_grds'){
			$___to_inc = GL_ACT.'act_grd.php';
		}

		elseif($__t == 'sms' || $__t == 'sms_tmpl' || $__prfx->lt == 'sms' || $__prfx->lt == 'sms_tmpl'){
			$___to_inc = GL_SMS.'sms.php';
		}elseif($__t == 'sms_lsts'){
			$___to_inc = GL_SMS.'sms_lsts.php';
		}elseif($__t == 'sms_test'){
			$___to_inc = GL_SMS.'sms_test.php';
		}elseif($__t == 'sms_cmpg' || $__prfx->lt == 'sms_cmpg' ){

			$___to_inc = GL_SMS.'sms_cmpg.php';

		}elseif($__t == 'mdl'){

			$___to_inc = GL_MDL.'mdl.php';

		}elseif($__t == 'mdl_gen'){

			$___to_inc = GL_MDL.'mdl_gen.php';

		}elseif($__t == 'mdl_s'){
			$___to_inc = GL_MDL.'mdl_s.php';
		}elseif($__t == 'mdl_s_tp'){
			$___to_inc = GL_MDL.'mdl_s_tp.php';
		}elseif($__t == 'mdl_s_tp_prm'){
			$___to_inc = GL_MDL.'mdl_s_tp_prm.php';
		}elseif($__t == 'mdl_s_prd'){

			$___to_inc = GL_MDL.'mdl_s_prd.php';

		}elseif($__t == 'mdl_cnt'){

			$___to_inc = GL_MDL.'mdl_cnt.php';

		}elseif($__t == 'mdl_cnt_his'){

			$___to_inc = GL_MDL.'mdl_cnt_his.php';

		}elseif($__t == 'enc'){
			$___to_inc = GL_ENC.'enc.php';
		}elseif($__t == 'enc_fld'){
			$___to_inc = GL_ENC.'enc_fld.php';
		}elseif($__t == 'enc_dts'){
			$___to_inc = GL_ENC.'enc_dts.php';
		}elseif($__t == 'enc_fld'){
			$___to_inc = GL_ENC.'enc_fld.php';
		}elseif($__t == 'mdl_s_tp_cl'){

				$___to_inc = GL_MDL.'mdl_s_tpcustomer.php';


		}elseif($__t == 'mdl_cnt_tra' || $__prfx->lt == 'cnt_tra'){

			$___to_inc = GL_TRA.'tra_cnt.php';

		}elseif($__t == 'scl'){

			$___to_inc = GL_SCL.'scl.php';

		}elseif($__t == 'ec'){

			$___to_inc = GL_EC.'ec.php';

		}elseif($__t == 'ec_dsgn'){

			$___to_inc = GL_EC.'ec_dsgn.php';

		}elseif($__t == 'snd_ec_cmpg'){

			$___to_inc = GL_EC.'ec_cmpg.php';

        }elseif($__t == 'snd_ec_cmpg_test'){

			$___to_inc = GL_EC.'ec_cmpg_test.php';

        }elseif($__t == 'snd_ec_lsts'){

			$___to_inc = GL_EC.'ec_lsts.php';

        }elseif($__t == 'snd_ec_lsts_sgm'){

			$___to_inc = GL_EC.'ec_lsts_sgm.php';

        }elseif($__t == 'snd_ec_lsts_sgm_var' || $__t == 'ec_lsts_sgm_var'){

			$___to_inc = GL_EC.'ec_lsts_sgm_var.php';

		}elseif($__t == 'snd_ec_tmpl'){

			$___to_inc = GL_EC.'ec.php';

		}elseif($__t == 'snd_ec_cmz' || $__t == 'ec_cmz' || $__t == '_ec_cmz'){

			$___to_inc = GL_EC.'ec_cmz.php';

		}elseif($__t == 'sgn'){

			$___to_inc = GL_SGN.'sgn.php';

		}elseif($__t == 'mdl_cnt_ec'){

			$___to_inc = GL_EC.'mdl_cnt_ec.php';

		}elseif($__t == 'bn'){

			$___to_inc = GL_BN.'bn.php';

		}elseif($__t == 'sis_cd_dp'){

			$___to_inc = GL_SIS.'sis_cd_dp.php';

		}elseif($__t == 'up_fld'){

			$___to_inc = GL_PRC.'up_fld.php';

		}elseif($__t == 'lnd'){

			$___to_inc = GL_LND.'lnd.php';

		}elseif($__t == 'ec_rpr'){

			$___to_inc = GL_EC.'ec_rpr.php';

		}elseif($__t == 'lrn'){

			$___to_inc = GL_LRN.'lrn.php';

		}elseif($__t == 'lrn_vd'){

			$___to_inc = GL_LRN.'lrn_vd.php';

		}elseif($__t == 'mdl_s_tp_fm'){

			$___to_inc = GL_MDL.'mdl_s_tp_fm.php';

		}elseif($__t == 'bco'){

			$___to_inc = GL_BCO.'bco.php';

		}elseif($__t == 'rd'){

			$___to_inc = GL_RD.'rd.php';

		}elseif($__t == 'hsh'){

			$___to_inc = GL_HSH.'hsh.php';

		}elseif($__t == 'up_tw'){

			$___to_inc = GL_UP.'up_tw.php';

		}elseif($__t == 'mdl_fle'){

			$___to_inc = GL_MDL.'mdl_fle.php';

		}elseif($__t == 'wnd_cls'){
			$___to_inc = GL.'wnd_cls.php';

		}elseif($__t == 'cl_scrpt'){

			$___to_inc = GL_CL.'cl_scrpt.php';

		}elseif($__t == 'mdl_attr'){

			$___to_inc = GL_MDL.'mdl_attr.php';

		}elseif($__t == 'sis_ec_sgm'){

			$___to_inc = GL_SIS.'sis_ec_sgm.php';

		}elseif($__t == 'sis_ec_sgm_var'){

			$___to_inc = GL_SIS.'sis_ec_sgm_var.php';

		}elseif($__t == 'sis_ec_sgm_var_tp'){

			$___to_inc = GL_SIS.'sis_ec_sgm_var_tp.php';

		}elseif($__t == 'eml'){

			$___to_inc = GL_SCL.'eml.php';

		}elseif($__t == 'tpc_tp'){

			$___to_inc = GL_TPC.'tpc_tp.php';

		}elseif($__t == 'tpc'){

			$___to_inc = GL_TPC.'tpc.php';

		}elseif($__t == 'cl_plcy'){

			$___to_inc = GL_CL.'cl_plcy.php';

		}elseif($__t == 'cntrc'){

			$___to_inc = GL_CNTR.'cntrc.php';

		}elseif($__t == 'sis_bd'){

			$___to_inc = GL_SIS.'sis_bd.php';

		}elseif($__t == 'org_vst'){

			$___to_inc = GL_ORG.'org_vst.php';

		}elseif($__t == 'cl_wdgt'){

			$___to_inc = GL_CL.'cl_wdgt.php';

		}elseif($__t == 'sort'){

			$___to_inc = GL_SORT.'sort.php';

		}elseif($__t == 'cl_app'){

			$___to_inc = GL_CL.'cl_app.php';

		}elseif($__t == 'cl_app_icn'){

			$___to_inc = GL_CL.'cl_app_icn.php';

		}elseif($__t == 'cl_app_tp'){

			$___to_inc = GL_CL.'cl_app_tp.php';

		}elseif($__t == 'rsllr_quot'){

			$___to_inc = GL_RSLLR.'rsllr_quot.php';

		}elseif($__t == 'org_grp'){

			$___to_inc = GL_ORG.'org_grp.php';

		}elseif($__t == 'cl_h_cntc'){

			$___to_inc = GL_CL.'cl_h_cntc.php';

		}elseif($__t == 'org_sds_pass'){

			$___to_inc = GL_ORG.'org_sds_pass.php';

		}elseif($__t == 'auto_tp'){

			$___to_inc = GL_SIS.'auto_tp.php';

		}elseif($__t == 'us_ntf'){

			$___to_inc = GL_US.'us_ntf.php';

		}elseif($__t == 'vtex_cmpg'){

			$___to_inc = GL_VTEX.'vtex_cmpg.php';

		}elseif($__t == 'marks'){

			$___to_inc = GL_ORG.'marks.php';

		}elseif($__t == 'org_sds_cnt_tkn'){

			$___to_inc = GL_ORG.'org_sds_cnt_tkn.php';

		}elseif($__t == 'org_dsh'){

			$___to_inc = GL_ORG.'org_dsh.php';

		}elseif($__t == 'store'){

			$___to_inc = GL_STORE.'store.php';

		}elseif($__t == 'store_brnd'){

			$___to_inc = GL_STORE.'store_brnd.php';

		}elseif($__t == 'dwn_col'){

			$___to_inc = GL_DWN.'dwn_col.php';

		}elseif($__t == 'mdl_s_tp_col'){

			$___to_inc = GL_MDL.'mdl_s_tp_col.php';

		}elseif($__t == 'mdl_us'){

			$___to_inc = GL_MDL.'mdl_us.php';

		}elseif($__t == 'cnv_eml'){

			$___to_inc = GL_CNV.'cnv_eml.php';

		}elseif($__t == 'scl_ld_flds'){

			$___to_inc = GL_SCL.'scl_ld_flds.php';

		}elseif($__t == 'bco_adv'){
			$___to_inc = GL_BCO.'bco_adv.php';
		}elseif($__t == 'mdl_grp'){
			$___to_inc = GL_MDL.'mdl_grp.php';
		}elseif($__t == 'mdl_ctrl'){
			$___to_inc = GL_MDL.'mdl_ctrl.php';
		}elseif($__t == 'cl_sds'){
			$___to_inc = GL_CL.'cl_sds.php';;
		}elseif($__t == 'cnt_eml_sgm'){
			$___to_inc = GL_CNT.'cnt_eml_sgm.php';;
		}elseif($__t == 'ec_chng'){
			$___to_inc = GL_EC.'ec_chng.php';;
		}else{

			$___to_inc = '../../'.DR_AC.DMN_SB.'/'.PRC_GN;

		}

	}elseif($__t == 'login'){

		$___to_inc = GL.PRC_GN_LOGIN;
		$nosess='ok';

	}elseif($__t == 'logout'){

		$___to_inc = GL.PRC_GN_LOGOUT;
		$nosess='ok';

	}elseif($__t == 'us_frgt_pss'){

		$___to_inc = GL_US.'us_frgt_pss.php';
		$nosess='ok';

	}elseif($__t == 'us_rst_pss'){

		$___to_inc = GL_US.'us_rst_pss.php';
		$nosess='ok';

	}else{

		$___401e='ok';

	}

	//---------------------- COMPRIME E INCLUYE CONTENIDO --------------//


		if($__no_c != 'ok'){ ob_start("compress_code"); }

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
			if(!isN($rtrn)){ echo $rtrn; }
			if($___401e=='ok' && $_GtSesDt->e != 'ok'){ header("HTTP/1.1 401 Unauthorized"); }

		if($__no_c != 'ok'){ ob_end_flush(); }


?>