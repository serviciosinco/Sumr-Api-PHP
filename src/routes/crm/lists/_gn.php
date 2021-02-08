<?php

try {


	$Rt = '../../includes/'; $__tme_s = microtime(true); $__fbsrc = 'ok'; include($Rt.'inc.php'); Hdr_HTML();


	//---------------------- GROUP LIST ----------------------//

		define('GL', __f(''));
		define('GL_ATMT', __f('atmt'));
		define('GL_CNT', __f('cnt'));
		define('GL_MDL', __f('mdl'));
		define('GL_MDL_WDGTS', GL_MDL.'wdgts/');

		define('GL_CNV', __f('cnv'));
		define('GL_EMP', __f('emp'));
		define('GL_TRA', __f('tra'));
		define('GL_SIS', __f('sis'));
		define('GL_CL', __f('cl'));
		define('GL_SMS', __f('sms'));
		define('GL_EC', __f('ec'));
		define('GL_ENC', __f('enc'));
		define('GL_US', __f('us'));
		define('GL_GRPH', __f('grph'));
		define('GL_DSH', __f('dsh'));
		define('GL_AUD', __f('aud'));
		define('GL_SGN', __f('sgn'));
		define('GL_LND', __f('lnd'));
		define('GL_ORG', __f('org'));
		define('GL_BN', __f('bn'));
		define('GL_ACT', __f('act'));
		define('GL_UPPRC', __f('up_prc'));
		define('GL_WBHK', __f('wbhk'));
		define('GL_DWN', __f('dwn'));
		define('GL_PLN', __f('pln'));
		define('GL_VST', __f('vst'));
		define('GL_LRN', __f('lrn'));
		define('GL_BCO', __f('bco'));
		define('GL_RD', __f('rd'));
		define('GL_HSH', __f('hsh'));
		define('GL_SCL', __f('scl'));
		define('GL_CNTR', __f('cntr'));
		define('GL_APPL', __f('appl'));
		define('GL_TPC', __f('tpc'));
		define('GL_EML', __f('eml'));
		define('GL_MDL_GEN', __f('mdl_gen'));
		define('GL_RSLLR', __f('rsllr'));
		define('GL_SORT', __f('sort'));
		define('GL_AUTO', __f('auto'));
		define('GL_VTEX', __f('vtex'));
		define('GL_STORE', __f('store'));

	//---------------------- VARIABLES GET ----------------------//

		$_Crm_Aud = new CRM_Aud();
		$___Ls = new CRM_Ls();
		$_aws = new API_CRM_Aws();

		$__t = Php_Ls_Cln($_GET['_t']);
		$__t2 = Php_Ls_Cln($_GET['_t2']);
		$__t3 = Php_Ls_Cln($_GET['_t3']);
		$__t4 = Php_Ls_Cln($_GET['_t4']);

		$__i = Php_Ls_Cln($_GET['__i']);
		$_i = Php_Ls_Cln($_GET['_i']);
		$__fpck = Php_Ls_Cln($_GET['_fpck']);
		$__hpck = Php_Ls_Cln($_GET['_hpck']);
		$__fsve = Php_Ls_Cln($_GET['___fl_s']);
		$__fsve = _GPJ([ 'v'=>'sve' ]);
		$__fcln = Php_Ls_Cln($_POST['fl']['p']['clr']);
		$__fcln_g = Php_Ls_Cln($_GET['___fl_c']);
		$__fsch = Php_Ls_Cln($_POST['fl']['sch']);
		$__fpr = Php_Ls_Cln($_GET["Pr"]);
		$__prfx = _Fx_Prx(['v'=>$__t]);

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

			if($__t == 'atmt'){
				$___to_inc = GL_ATMT.'atmt.php'; $__non_c = 'ok';
			}elseif($__t == 'atmt_etp'){
				$___to_inc = GL_ATMT.'atmt_etp.php';
			}elseif($__t == 'atmt_trgr'){
				$___to_inc = GL_ATMT.'atmt_trgr.php';
			}elseif($__t == 'atmt_trgr_act'){
				$___to_inc = GL_ATMT.'atmt_trgr_act.php';
			}elseif($__t == 'atmt_trgr_cndc'){
				$___to_inc = GL_ATMT.'atmt_trgr_cndc.php';
			}elseif($__t == 'atmt_mdl'){
				$___to_inc = GL_ATMT.'atmt_mdl.php';
			}elseif($__t == 'wbhk'){
				$___to_inc = GL_WBHK.'wbhk.php';
			}elseif($__t == 'cl'){
				$___to_inc = GL_CL.'cl.php';
			}elseif($__t == 'cl_tag'){
				$___to_inc = GL_CL.'cl_tag.php';
			}elseif($__t == 'cl_are'){
				$___to_inc = GL_CL.'cl_are.php';
			}elseif($__t == 'cl_grp' ){
				$___to_inc = GL_CL.'cl_grp.php';
			}elseif($__t == 'cl_mdl_are' ){
				$___to_inc = GL_CL.'cl_mdl_are.php';
			}elseif($__t == 'cl_dmn' ){
				$___to_inc = GL_CL.'cl_dmn.php';
			}elseif($__t == 'cl_dmn_sub' ){
				$___to_inc = GL_CL.'cl_dmn_sub.php';
			}elseif($__t == 'cl_ftp' ){
				$___to_inc = GL_CL.'cl_ftp.php';
			}elseif($__t == 'cl_flj' ){
				$___to_inc = GL_CL.'cl_flj.php';
			}elseif($__t == 'cl_bd' ){
				$___to_inc = GL_CL.'cl_bd.php';
			}elseif($__t == 'cl_lcl' ){
				$___to_inc = GL_CL.'cl_lcl.php';
			}



			elseif($__t == 'cl_aws_acc'){
				$___to_inc = GL_CL.'cl_aws_acc.php';
			}elseif($__t == 'cl_wthsp'){
				$___to_inc = GL_CL.'cl_wthsp.php';
			}elseif($__t == 'cl_wdgt'){
				$___to_inc = GL_CL.'cl_wdgt.php';
			}elseif($__t == 'cl_wdgt_act'){
				$___to_inc = GL_CL.'cl_wdgt_act.php';
			}elseif($__t == 'cl_gtwy_pay'){
				$___to_inc = GL_CL.'cl_gtwy_pay.php';
			}elseif($__t == 'cl_vtex'){
				$___to_inc = GL_CL.'cl_vtex.php';
			}



			elseif($__t == 'cnt'){
				$___to_inc = GL_CNT.'cnt.php';
			}elseif($__t == 'cnt_org_sds'){
				$___to_inc = GL_CNT.'cnt_org_sds.php';
			}elseif($__t == 'cnt_bd'){
				$___to_inc = GL_CNT.'cnt_bd.php';
			}elseif($__t == 'cnt_eml'){
				$___to_inc = GL_CNT.'cnt_eml.php';
			}elseif($__t == 'cnt_tp'){
				$___to_inc = GL_CNT.'cnt_tp.php';
			}elseif($__t == 'cnt_dc'){
				$___to_inc = GL_CNT.'cnt_dc.php';
			}elseif($__t == 'cnt_tel'){
				$___to_inc = GL_CNT.'cnt_tel.php';
			}elseif($__t == 'cnt_rlc'){
				$___to_inc = GL_CNT.MDL_CNT_RLC_LS;
			}elseif($__t == 'cnt_prnt'){
				$___to_inc = GL_CNT.'cnt_prnt.php';
			}elseif($__t == 'cnt_appl'){
				$___to_inc = GL_CNT.'cnt_appl.php';
			}elseif($__t == 'cnt_appl_attr'){
				$___to_inc = GL_CNT.'cnt_appl_attr.php';
			}elseif($__t == 'cnt_appl_romt'){
				$___to_inc = GL_CNT.'cnt_appl_romt.php';
			}elseif($__t == 'cnt_appl_tpc'){
				$___to_inc = GL_CNT.'cnt_appl_tpc.php';
			}elseif($__t == 'cnt_appl_anx'){
				$___to_inc = GL_CNT.'cnt_appl_anx.php';
			}elseif($__t == 'cnt_appl_rsp_fin'){
				$___to_inc = GL_CNT.'cnt_appl_rsp_fin.php';
			}elseif($__t == 'cnt_appl_serv_adc'){
				$___to_inc = GL_CNT.'cnt_appl_serv_adc.php';
			}elseif($__t == 'cnt_appl_lng'){
				$___to_inc = GL_CNT.'cnt_appl_lng.php';
			}elseif($__t == 'cnt_appl_cntr'){
				$___to_inc = GL_CNT.'cnt_appl_cntr.php';
			}elseif($__t == 'mdl'){
				$___to_inc = GL_MDL.'mdl.php';
			}elseif($__t == 'mdl_cnt'){
				$___to_inc = GL_MDL.'mdl_cnt.php';
				if($___Ls->gt->wrp == 'ok'){ $_wrpc = 'ok'; }
			}elseif($__t == 'mdl_sch'){
				$___to_inc = GL_MDL.'mdl_sch.php';
			}elseif($__t == 'mdl_cnt_his'){
				$___to_inc = GL_MDL.'mdl_cnt_his.php';
			}elseif($__t == 'mdl_gen'){
				$___to_inc = GL_MDL.'mdl_gen.php';
			}elseif($__t == 'mdl_cnt_vst'){
				$___to_inc = GL_VST.'vst.php';
			}elseif($__t == 'enc'){
				$___to_inc = GL_ENC.'enc.php';
			}elseif($__t == 'enc_fld'){
				$___to_inc = GL_ENC.'enc_fld.php';
			}elseif($__t == 'enc_dts' ){
				$___to_inc = GL_ENC.'enc_dts.php';
			}elseif($__t == 'emp' || $__prfx->lt == 'emp'){
				$___to_inc = GL_EMP.MDL_EMP_LS;
			}elseif($__t == 'emp_sub' || $__t == 'emp_sub' ||  $__prfx->lt == 'emp_sub'){
				$___to_inc = GL_EMP.MDL_EMP_SUB_LS;
			}elseif($__t == 'empsub_cnt' || $__t == 'emp_cnt' || $__prfx->lt == 'emp_cnt'){
				$___to_inc = GL_EMP.MDL_EMP_CNT_LS;
			}elseif($__t == 'empsub_vst' || $__t == 'emp_vst' || $__prfx->lt == 'emp_vst'){
				$___to_inc = GL_EMP.MDL_EMP_VST_LS;
			}elseif($__t == 'emp_vst_tra' ){
				$___to_inc = GL_EMP.'emp_vst_tra.php';
			}elseif($__t == 'empsub_ofr' || $__t == 'emp_ofr' || $__prfx->lt == 'emp_ofr'){
				$___to_inc = GL_EMP.MDL_EMP_OFR_LS;
			}elseif($__t == 'emp_grp' || $__t == 'emp_grp' || $__prfx->lt == 'emp_grp'){
				$___to_inc = GL_EMP.MDL_EMP_GRP_LS;
			}elseif($__t == 'pqt_emp_his' || $__t == 'emp_his' || $__prfx->lt == 'pqt_emp_his'){
				$___to_inc = GL_EMP.MDL_EMP_HIS_LS;
			}elseif($__t == 'pqt_emp_rsp' || $__t == 'emp_rsp' || $__prfx->lt == 'emp_rsp' || $__prfx->lt == 'org_rsp'){
				$___to_inc = GL_EMP.MDL_EMP_RSP_LS;
			}elseif($__t == 'up_col'){
				$___to_inc = GL.'up_col.php';
			}elseif($__t == 'wrk_cnt'){
				$___to_inc = GL.'wrk_cnt.php';
			}elseif($__t == 'mdl_cnt'){
				$___to_inc = GL_MDL.MDL_MDL_CNT_LS;
			}elseif($__t == 'cnt_his' || $__prfx->lt == 'cnt_his'){
				$___to_inc = GL_MDL.MDL_CNT_HIS_LS;
			}elseif($__prfx->lt == 'cnt_ec'){
				$___to_inc = GL_MDL.MDL_CNT_EC_LS;

			}elseif($__t == 'enc_cnt'){

				$___to_inc = GL_ENC.'enc_cnt.php';

			}elseif($__t == 'vst' || $__prfx->lt == 'cnt_vst'){
				$___to_inc = GL_MDL.MDL_CNT_VST_LS;
			}elseif($__t == 'us_cl' ){
				$___to_inc = GL_US.'uscustomer.php';
			}elseif($__t == 'us_tkn' ){
				$___to_inc = GL_US.'us_tkn.php';
			}elseif($__t == 'us_mdl' ){
				$___to_inc = GL_US.'us_mdl.php';
			}elseif($__t == 'us_ses' ){
				$___to_inc = GL_US.'us_ses.php';
			}elseif($__t == 'us' ){
				$___to_inc = GL_US.'us.php';
			}elseif($__t == 'mdl_s_tp_prm'){
				$___to_inc = GL_MDL.'mdl_s_tp_prm.php';
			}elseif($__t == 'mdl_s'){
				$___to_inc = GL_MDL.'mdl_s.php';
			}elseif($__t == 'mdl_s_tp'){
				$___to_inc = GL_MDL.'mdl_s_tp.php';
			}elseif($__t == 'mdl_s_tp_cl'){
				$___to_inc = GL_MDL.'mdl_s_tpcustomer.php';
			}elseif($__t == 'mdl_s_prd'){
				$___to_inc = GL_MDL.'mdl_s_prd.php';
			}elseif($__t == 'mdl_cnt_cntt'){
				$___to_inc = GL_MDL.'mdl_cnt_cntt.php';
			}
			elseif($__t == 'us_rg'){
				$___to_inc = GL_US.MDL_US_RG_LS;
			}elseif($__t == 'us_tel' ){
				$___to_inc = GL_US.'us_tel.php'; $__non_c = 'ok';
			}elseif($__t == 'us_eml' ){
				$___to_inc = GL_US.'us_eml.php'; $__non_c = 'ok';
			}elseif($__t == 'aud_key'){
				$___to_inc = GL_AUD.'aud_key.php';
			}elseif($__t == 'aud'){
				$___to_inc = GL_AUD.'aud.php';
			}elseif($__t == 'lnd'){
				$___to_inc = GL_LND.'lnd.php'; $__no_c = 'ok';
			}elseif($__t == 'lnd_cdn'){
				$___to_inc = GL_LND.'lnd_cdn.php';
			}elseif($__t == 'lnd_tp'){
				$___to_inc = GL_LND.'lnd_tp.php';
			}


			elseif($__t == 'sms'  || $__t == 'sms_tmpl' ){
				$___to_inc = GL_SMS.'sms.php';
			}elseif($__t == 'sms_cmpg' ){
				$___to_inc = GL_SMS.'sms_cmpg.php';
			}elseif($__t == 'sms_lsts'){
				$___to_inc = GL_SMS.'sms_lsts.php';
			}elseif($__t == 'sms_cmpg_up'){
				$___to_inc = GL_SMS.'sms_cmpg_up.php';
			}elseif($__t == 'sms_snd' ){
				$___to_inc = GL_SMS.'sms_snd.php';
			}elseif($__t == 'snd_ec_cmpg'){

				$___to_inc = GL_EC.'ec_cmpg.php'; $_wrpc = 'ok';


	        }elseif($__t == 'snd_ec_lsts'){
				$___to_inc = GL_EC.'ec_lsts.php'; $_wrpc = 'ok';
	        }elseif($__t == 'snd_ec_lsts_sgm'){
				$___to_inc = GL_EC.'ec_lsts_sgm.php';
	        }elseif($__t == 'snd_ec_lsts_sgm_var' || $__t == 'ec_lsts_sgm_var'){
				$___to_inc = GL_EC.'ec_lsts_sgm_var.php'; $_wrpc = 'ok';
			}elseif($__t == 'snd_ec_lsts_up'){
				$___to_inc = GL_EC.'ec_lsts_up.php';
			}elseif($__t == 'snd_ec_lsts_eml'){
				$___to_inc = GL_EC.'ec_lsts_eml.php';
			}elseif($__t == 'snd_ec_lsts_are'){
				$___to_inc = GL_EC.'ec_lsts_are.php';
			}elseif($__t == 'snd_ec_lsts_var'){
				$___to_inc = GL_EC.'ec_lsts_sgm_var.php';
			}









	        elseif($__t == 'ec' || $__t == 'snd_ec_tmpl' || $__t == 'ec_tmpl'){

				$___to_inc = GL_EC.'ec.php'; $_wrpc = 'ok';
				if(!isN($___Ls->gt->i)){ $__no_c='ok'; }

	        }elseif($__t == 'snd_ec_cmz'){

				$___to_inc = GL_EC.'ec_cmz.php'; $_wrpc = 'ok';

	        }elseif($__t == 'snd_ec_cmz_cmnt'){

				$___to_inc = GL_EC.'ec_cmz_cmnt.php'; //$_wrpc = 'ok';

			}

			elseif($__t == 'mdl_cnt_tra' || $__t == 'emp_tra'){
				$___to_inc = GL_TRA.MDL_TRA_CNT_LS;


			}elseif($__t == 'tra'){
				$___to_inc = GL_TRA.'tra.php'; $__non_c = 'ok';
			}elseif($__t == 'tra_rsp' || $__prfx->lt == 'cnt_tra_rsp'){
				$___to_inc = GL_TRA.MDL_TRA_RSP_LS;
			}elseif($__t == 'tra_col' || $__t == 'tra_col_grp' || $__prfx->lt == 'cnt_tra_rsp'){
				$___to_inc = GL_TRA.'tra_col.php';
			}elseif($__t == 'tra_eml'){
				$___to_inc = GL_TRA.'tra_eml.php';
			}


			elseif($__t == 'sis_tex' || $__t == 'cl_tex'){
				$___to_inc = GL_SIS.'sis_tex.php';
			}elseif($__t == 'sis_lng'){
				$___to_inc = GL_SIS.'sis_lng.php';
			}elseif($__t == 'cl_sis'){
				$___to_inc = GL_SIS.'sis.php';
			}elseif($__t == 'sis'){
				$___to_inc = GL_SIS.'sis.php';
			}elseif($__t == 'sis_emp_grp'){
				$___to_inc = GL_SIS.MDL_SIS_EMP_GRP_LS;
			}elseif($__t == 'empsub_ofr_fle' || $__t == 'emp_ofr_fle'){
				$___to_inc = GL_SIS.MDL_EMP_OFR_FLE_LS;
			}elseif($__t == 'sis_vst_aplz'){
				$___to_inc = GL_SIS.MDL_VST_APLZ_LS;
			}elseif($__t == 'sis_vst_est'){
				$___to_inc = GL_SIS.MDL_VST_EST_LS;
			}elseif($__t == 'sis_vst_tp'){
				$___to_inc = GL_SIS.MDL_VST_TP_LS;
			}elseif($__t == 'sis_cnt_est'){
				$___to_inc = GL_SIS.'sis_cnt_est.php';
			}elseif($__t == 'sis_cnt_est_tp'){
				$___to_inc = GL_SIS.'sis_cnt_est_tp.php';
			}elseif($__t == 'sis_ofr_cmp'){
				$___to_inc = GL_SIS.MDL_EMP_OFR_CMP_LS;
			}elseif($__t == 'sis_ofr_md'){
				$___to_inc = GL_SIS.MDL_EMP_OFR_MD_LS;
			}elseif($__t == 'sis_ofr_rch'){
				$___to_inc = GL_SIS.MDL_EMP_OFR_RCH_LS;
			}elseif($__t == 'sis_ofr_est'){
				$___to_inc = GL_SIS.MDL_EMP_OFR_EST_LS;
			}elseif($__t == 'sis_ofr_tp'){
				$___to_inc = GL_SIS.MDL_EMP_OFR_TP_LS;
			}elseif($__t == 'sis_cnt_noi'){
				$___to_inc = GL_SIS.MDL_NOI_LS;
			}elseif($__t == 'sis_cnt_tp'){
				$___to_inc = GL_SIS.'sis_cnt_tp.php';
			}elseif($__t == 'sis_cnt_tp_grp'){
				$___to_inc = GL_SIS.'sis_cnt_tp_grp.php';
			}elseif($__t == 'sis_cnt_tag'){
				$___to_inc = GL_SIS.'sis_cnt_tag.php';
			}elseif($__t == 'sis_md'){
				$___to_inc = GL_SIS.'sis_md.php';
			}elseif($__t == 'sis_md_cl'){
				$___to_inc = GL_SIS.'sis_mdcustomer.php';
			}elseif($__t == 'sis_fnt'){
				$___to_inc = GL_SIS.'sis_fnt.php';
			}elseif($__t == 'sis_fnt_cl'){
				$___to_inc = GL_SIS.'sis_fntcustomer.php';
			}elseif($__t == 'sis_cd'){
				$___to_inc = GL_SIS.'sis_cd.php';
			}elseif($__t == 'sis_qts'){
				$___to_inc = GL_SIS.'sis_qts.php';
			}elseif($__t == 'sis_ps'){
				$___to_inc = GL_SIS.'sis_ps.php';
			}elseif($__t == 'sis_aud' ){
				$___to_inc = GL_SIS.'sis_aud.php';
			}elseif($__t == 'sis_tra_est' ){
				$___to_inc = GL_SIS.'sis_tra_est.php';
			}elseif($__t == 'sis_tra_tp' ){
				$___to_inc = GL_SIS.'sis_tra_tp.php';
			}elseif($__t == 'sis_cdn' ){
				$___to_inc = GL_SIS.'sis_cdn.php';
			}elseif($__t == 'sis_font' ){
				$___to_inc = GL_SIS.'sis_font.php';






			}elseif($__t == 'dsh_mtrc'){
				$___to_inc = GL_DSH.'dsh_mtrc.php';
			}elseif($__t == 'dsh_dms'){
				$___to_inc = GL_DSH.'dsh_dms.php';
			}elseif($__t == 'cl_mnu'){
				$___to_inc = GL_CL.'cl_mnu.php';
			}elseif($__t == 'cl_mnu_cl'){
				$___to_inc = GL_CL.'cl_mnucustomer.php';
			}elseif($__t == '_grph'){
				$___to_inc = GL_GRPH.'_grph.php';
				$__no_c = 'ok';
			}elseif($__t == '_grph_chr'){
				$___to_inc = GL_GRPH.'_grph_chr.php';
			}elseif($__t == '_grph_chr_rlc'){
				$___to_inc = GL_GRPH.'_grph_chr_rlc.php';
			}
			elseif($__t == 'org'){
				$___to_inc = GL_ORG.'org.php';
			}

			elseif($__t == 'org_sds_zna'){
				$___to_inc = GL_ORG.'org_sds_zna.php';
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
			}elseif($__t == 'org_tp'){
				$___to_inc = GL_ORG.'org_tp.php';
			}elseif($__t == 'org_gst'){
				$___to_inc = GL_ORG.'org_gst.php';


			}elseif($__t == 'org_sds_cnt' || $__t == 'org_sds_etd'){

				$___to_inc = GL_ORG.'org_sds_cnt.php';


			}elseif($__t == 'org_dst'){
				$___to_inc = GL_ORG.'org_dst.php';
			}elseif($__t == 'org_acds'){
				$___to_inc = GL_ORG.'org_acds.php';
			}elseif($__t == 'org_sds'){
				$___to_inc = GL_ORG.'org_sds.php';
			}elseif($__t == 'org_act' || $__t == 'act'){
				$___to_inc = GL_ACT.'act.php';
			}elseif($__t == 'org_act_chk' || $__t == 'act_chk'){
				$___to_inc = GL_ACT.'act_chk.php';
			}elseif($__t == 'act_acttp'){
				$___to_inc = GL_ACT.'act_acttp.php';
			}
			elseif($__t == 'act_mdl'){
				$___to_inc = GL_ACT.'act_mdl.php';
			}
			elseif($__t == 'act_rsp'){
				$___to_inc = GL_ACT.'act_rsp.php';
			}elseif($__t == 'act_org'){
				$___to_inc = GL_ACT.'act_org.php';
			}elseif($__t == 'act_grds'){
				$___to_inc = GL_ACT.'act_grd.php';
			}
			elseif($__t == 'org_vst'){
				$___to_inc = GL_ORG.'org_vst.php';
			}
			elseif($__t == 'up_fld'){
				$___to_inc = GL_UPPRC.'up_fld.php';
			}elseif($__t == 'sis_slc' || $__t == 'cl_slc'){
				$___to_inc = GL_SIS.'sis_slc.php';
			}elseif($__t == 'sis_slc_tp' || $__t == 'cl_slc_tp'){
				$___to_inc = GL_SIS.'sis_slc_tp.php';
			}elseif($__t == 'sis_slc_tp_f' || $__t == 'cl_slc_tp_f'){
				$___to_inc = GL_SIS.'sis_slc_tp_f.php';
			}elseif($__t == 'sis_slc_f' || $__t == 'cl_slc_f'){
				$___to_inc = GL_SIS.'sis_slc_f.php';
			}elseif($__t == 'sgn'){
				$___to_inc = GL_SGN.'sgn.php';
			}elseif($__t == 'sgn_cod'){
				$___to_inc = GL_SGN.'sgn_cod.php';
			}elseif($__t == 'bn'){
				$___to_inc = GL_BN.'bn.php';
			}elseif($__t == 'sis_cd_dp'){
				$___to_inc = GL_SIS.'sis_cd_dp.php';
			}elseif($__t == 'dwn'){
				$___to_inc = GL_DWN.'dwn.php'; $__non_c='ok';
			}elseif($__t == 'lrn'){
				$___to_inc = GL_LRN.'lrn.php';
			}elseif($__t == 'lrn_vd'){
				$___to_inc = GL_LRN.'lrn_vd.php';
			}elseif($__t == 'lrn_vd_play'){
				$___to_inc = GL_LRN.'lrn_vd_play.php';
			}elseif($__t == 'lrn_vd_cl'){
				$___to_inc = GL_LRN.'lrn_vdcustomer.php';
			}elseif($__t == 'mdl_s_tp_fm'){
				$___to_inc = GL_MDL.'mdl_s_tp_fm.php'; $__non_c = 'ok';
			}elseif($__t == 'cnt_cd'){
				$___to_inc = GL_CNT.'cnt_cd.php';
			}elseif($__t == 'pln_cmp'){
				$___to_inc = GL_PLN.'pln_cmp.php'; $__non_c = 'ok';
			}elseif($__t == 'pln_cmp_gst'){
				$___to_inc = GL_PLN.'pln_cmp_gst.php'; $__non_c = 'ok';
			}elseif($__t == 'bco'){
				$___to_inc = GL_BCO.'bco.php';
			}elseif($__t == 'rd'){
				$___to_inc = GL_RD.'rd.php';
			}elseif($__t == 'hsh'){
				$___to_inc = GL_HSH.'hsh.php';
			}elseif($__t == 'atmt_mdl'){
				$___to_inc = GL_ATMT.'atmt_mdl.php';
			}elseif($__t == 'mdl_cnt_cntr'){
				$___to_inc = GL_MDL.'mdl_cnt_cntr.php';
			}elseif($__t == 'mdl_gen_fm'){
				$___to_inc = GL_MDL.'mdl_gen_fm.php';
			}elseif($__t == 'mdl_fle'){
				$___to_inc = GL_MDL.'mdl_fle.php';
			}elseif($__t == 'act_cnt'){
				$___to_inc = GL_ACT.'act_cnt.php';
			}elseif($__t == 'mdl_attr'){
				$___to_inc = GL_MDL.'mdl_attr.php';
			}elseif($__t == 'cl_row'){
				$___to_inc = GL_CL.'cl_row.php';
			}elseif($__t == 'mdl_fm'){
				$___to_inc = GL_MDL.'mdl_fm.php';
			}elseif($__t == 'scl_forms'){
				$___to_inc = GL_SCL.'scl_forms.php';
			}elseif($__t == 'scl_acc'){
				$___to_inc = GL_SCL.'scl_acc.php';
			}elseif($__t == 'cl_scrpt'){
				$___to_inc = GL_CL.'cl_scrpt.php';
			}elseif($__t == 'mdl_mdl'){
				$___to_inc = GL_MDL.'mdl_mdl.php';
			}elseif($__t == 'mdl_us'){
				$___to_inc = GL_MDL.'mdl_us.php';
			}



			elseif($__t == 'sis_ec_sgm'){
				$___to_inc = GL_SIS.'sis_ec_sgm.php';
			}elseif($__t == 'sis_ec_sgm_var'){
				$___to_inc = GL_SIS.'sis_ec_sgm_var.php';
			}elseif($__t == 'sis_ec_sgm_var_tp'){
				$___to_inc = GL_SIS.'sis_ec_sgm_var_tp.php';
			}elseif($__t == 'eml'){
				$___to_inc = GL_SCL.'eml.php';
			}elseif($__t == 'cntr_fm'){
				$___to_inc = GL_CNTR.'cntr_fm.php';
			}elseif($__t == 'appl_fm'){
				$___to_inc = GL_CNTR.'appl_fm.php';
			}elseif($__t == 'eml_cl'){
				$___to_inc = GL_SCL.'emlcustomer.php';
			}elseif($__t == 'tpc_tp'){
				$___to_inc = GL_TPC.'tpc_tp.php';
			}elseif($__t == 'tpc'){
				$___to_inc = GL_TPC.'tpc.php';
			}elseif($__t == 'lnd_font'){
				$___to_inc = GL_LND.'lnd_font.php';
			}elseif($__t == 'bco_are'){
				$___to_inc = GL_BCO.'bco_are.php';
			}elseif($__t == 'bco_tag'){
				$___to_inc = GL_BCO.'bco_tag.php';
			}elseif($__t == 'eml_us'){
				$___to_inc = GL_EML.'eml_us.php';
			}elseif($__t == 'eml_are'){
				$___to_inc = GL_EML.'eml_are.php';
			}elseif($__t == 'cl_plcy'){
				$___to_inc = GL_CL.'cl_plcy.php';
			}elseif($__t == 'cntrc'){
				$___to_inc = GL_CNTR.'cntrc.php';
			}elseif($__t == 'mdlgen_mdl'){
				$___to_inc = GL_MDL_GEN.'mdlgen_mdl.php';
			}elseif($__t == 'snd_ec_lsts_rel'){
				$___to_inc = GL_EC.'ec_lsts_rel.php';
			}elseif($__t == 'snd_ec_sgm_rel'){
				$___to_inc = GL_EC.'ec_sgm_rel.php';
			}elseif($__t == 'cnt_appl_cntrc'){
				$___to_inc = GL_CNT.'cnt_appl_cntrc.php';
			}elseif($__t == 'scl_acc_form_leads'){
				$___to_inc = GL_SCL.'scl_acc_form_leads.php';
			}elseif($__t == 'sis_bd'){
				$___to_inc = GL_SIS.'sis_bd.php';
			}elseif($__t == 'mdlgen_tp'){
				$___to_inc = GL_MDL_GEN.'mdlgen_tp.php';
			}elseif($__t == 'sort'){
				$___to_inc = GL_SORT.'sort.php'; $__no_c = 'ok';
			}elseif($__t == 'cl_app'){
				$___to_inc = GL_CL.'cl_app.php';
			}elseif($__t == 'cl_app_icn'){
				$___to_inc = GL_CL.'cl_app_icn.php';
			}elseif($__t == 'cl_app_tp'){
				$___to_inc = GL_CL.'cl_app_tp.php';
			}elseif($__t == 'org_grp'){
				$___to_inc = GL_ORG.'org_grp.php';
			}elseif($__t == 'org_org_grp'){
				$___to_inc = GL_ORG.'org_org_grp.php';
			}elseif($__t == 'cl_h_cntc'){
				$___to_inc = GL_CL.'cl_h_cntc.php';
			}elseif($__t == 'cnt_ec'){
				$___to_inc = GL_CNT.'cnt_ec.php';
			}elseif($__t == 'cnt_cntc'){
				$___to_inc = GL_CNT.'cnt_cntc.php';
			}elseif($__t == 'atmt_eml'){
				$___to_inc = GL_ATMT.'atmt_eml.php';
			}elseif($__t == 'mdl_s_prd_tp'){
				$___to_inc = GL_MDL.'mdl_s_prd_tp.php';
			}elseif($__t == 'api_dta'){
				$___to_inc = GL.'api_dta.php';
			}elseif($__t == 'org_sds_pass'){
				$___to_inc = GL_ORG.'org_sds_pass.php';
			}elseif($__t == 'act_grd'){
				$___to_inc = GL_ACT.'act_grd.php';
			}elseif($__t == 'org_scec'){
				$___to_inc = GL_ORG.'org_scec.php';
			}elseif($__t == 'mdlgen_grd'){
				$___to_inc = GL_MDL_GEN.'mdlgen_grd.php';
			}elseif($__t == 'auto_tp'){
				$___to_inc = GL_AUTO.'auto_tp.php';
			}elseif($__t == 'auto_cl'){
				$___to_inc = GL_AUTO.'autocustomer.php';
			}elseif($__t == 'vtex_cmpg'){
				$___to_inc = GL_VTEX.'vtex_cmpg.php';
			}elseif($__t == 'mdl_s_tp_fm_attr'){
				$___to_inc = GL_MDL.'mdl_s_tp_fm_attr.php';
			}elseif($__t == 'org_tag'){
				$___to_inc = GL_ORG.'org_tag.php';
			}elseif($__t == 'marks'){
				$___to_inc = GL_ORG.'marks.php';
			}elseif($__t == 'org_sds_arr_lcl'){
				$___to_inc = GL_ORG.'org_sds_arr_lcl.php';
			}elseif($__t == 'org_sds_cnt_tkn'){
				$___to_inc = GL_ORG.'org_sds_cnt_tkn.php';
			}elseif($__t == 'ec_snd_rprt'){
				$___to_inc = GL_EC.'ec_snd_rprt.php';
			}elseif($__t == 'mdl_cnt_inf'){
				$___to_inc = GL_MDL.'mdl_cnt_inf.php';
			}elseif($__t == 'mdl_s_tp_fm_exc'){
				$___to_inc = GL_MDL.'mdl_s_tp_fm_exc.php';
			}elseif($__t == 'mdl_s_tp_tra'){
				$___to_inc = GL_MDL.'mdl_s_tp_tra.php';
			}elseif($__t == 'org_dsh_pnl'){
				$___to_inc = GL_ORG.'org_dsh_pnl.php';
			}elseif($__t == 'tra_dsh'){
				$___to_inc = GL_TRA.'tra_dsh.php';
			}elseif($__t == 'rsllr_quot'){
				$___to_inc = GL_RSLLR.'rsllr_quot.php';

			}elseif($__t == 'store'){
				$___to_inc = GL_STORE.'store.php';
			}elseif($__t == 'store_brnd'){
				$___to_inc = GL_STORE.'store_brnd.php';


			}elseif($__t == 'cnv_tmlne'){
				$___to_inc = GL_CNV.'cnv_tmlne.php';


			}elseif($__t == 'dwn_col'){
				$___to_inc = GL_DWN.'dwn_col.php';
			}elseif($__t == 'mdl_s_tp_fm_ps'){
				$___to_inc = GL_MDL.'mdl_s_tp_fm_ps.php';
			}elseif($__t == 'mdl_s_tp_col'){
				$___to_inc = GL_MDL.'mdl_s_tp_col.php';
			}elseif($__t == 'scl_ld'){
				$___to_inc = GL_SCL.'scl_ld.php'; $__non_c = 'ok';
			}elseif($__t == 'scl_ld_flds'){
				$___to_inc = GL_SCL.'scl_ld_flds.php'; $__non_c = 'ok';
			}elseif($__t == 'eml_box'){
				$___to_inc = GL_SCL.'eml_box.php'; $__non_c = 'ok';
			}elseif($__t == 'bco_adv'){
				$___to_inc = GL_BCO.'bco_adv.php'; $__non_c = 'ok';
			}elseif($__t == 'mdl_grp'){
				$___to_inc = GL_MDL.'mdl_grp.php'; $__non_c = 'ok';
			}elseif($__t == 'mdl_ctrl'){
				$___to_inc = GL_MDL.'mdl_ctrl.php'; $__non_c = 'ok';
			}elseif($__t == 'cl_sds'){
				$___to_inc = GL_CL.'cl_sds.php'; $__non_c = 'ok';
			}elseif($__t == 'act_cnt'){
				$___to_inc = GL_ACT.'act_cnt.php'; $__non_c = 'ok';
			}elseif($__t == 'org_sds_cnt_crg'){
				$___to_inc = GL_ORG.'org_sds_cnt_crg.php'; $__non_c = 'ok';
			}elseif($__t == 'act_cnt_up'){
				$___to_inc = GL_ACT.'act_cnt_up.php'; $__non_c = 'ok';
			}elseif($__t == 'cnt_eml_sgm'){
				$___to_inc = GL_CNT.'cnt_eml_sgm.php'; $__non_c = 'ok';
			}elseif($__t == 'ec_chng'){
				$___to_inc = GL_EC.'ec_chng.php'; $__non_c = 'ok';
			}elseif($__t == 'us_grp'){
				$___to_inc = GL_US.'us_grp.php'; $__non_c = 'ok';
			}else{
				$___to_inc = '../../'.DR_AC.DMN_SB.'/'.FL_LS_GN;
			}

		}else{

			echo SESS_again();

		}

	//---------------------- JS SCRIPTS ----------------------//

		if($_if != 'ok'){

			$CntWb .= '

				$(".'.ID_HDRLS.'").hover(
					  function() {
						 $("#__logo").animate({ marginTop: -15 });
					  }, function() {
						 $("#__logo").animate({ marginTop: 0 });
					  }
				);';

			$CntWb .= "$('.chosen-select').chosen({width: '100%', allow_single_deselect: true});";
			if($__non_c == 'ok'){ $CntWb .= "$('#cnt').addClass('_non');"; }
		}

	//---------------------- COMPRIME E INCLUYE CONTENIDO --------------//

		if($__no_c != 'ok'){ ob_start("cmpr_fm"); }


			echo __popd([ 't'=>'o', 'show'=>$_wrpc, 'c'=>$___Ls ]);
			if(!isN($___to_inc)){ include($___to_inc); }
			echo __popd([ 't'=>'c', 'show'=>$_wrpc, 'c'=>$___Ls ]);


			if(!isN($CntJV) || !isN($___Ls->jv)){ echo CntJQ($___Ls->jv.$CntJV, 'ok'); }
			if(!isN($CntWb) || !isN($___Ls->js)){ echo CntJQ($___Ls->js.$_bldr->js.$CntWb); }

		if($__no_c != 'ok'){ ob_end_flush(); }

} catch (Exception $e) {
    echo $e->getMessage();
}

?>