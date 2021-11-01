<?php

	if($__dmn_dns=='ok'){
		define('DMN_DNS', 'ok');
	}

	//-------------- READ SESSION DATA AT START = START --------------//

		$evar = ['ENCRYPT_PASSPHRASE','DB_US','DB_US_PSS','DB_USPRC','DB_USPRC_PSS','MACHINE_DMN','DMN_CLOUD','SUMR_ENV','SUMR_TP','MACHINE_WRKR','MACHINE_WRKR_E','MACHINE_BCK_TP','RDS_HOSTNAME','RDS_HOSTNAME_WRT','RDS_HOSTNAME_PORT','SYS_AUTO','SYS_TMP_FREE','S3_PRVT_DIR','S3_FLE_DIR','AUTO_SND_EC','AUTO_BLD_EC','AUTO_SND_SMS','AUTO_SND_CL_FLJ','AUTO_CHK_EML','AUTO_CHK_EML_BNC','AUTO_CMPG_EC','AUTO_LSTS_EC','AUTO_LSTS_EC_VAR','AUTO_SVE','EC_SND_MAX','UP_BD_MAX','SYS_AUTO','SYS_TMP_FREE','GOAPI_ID','GOAPI_SCRT','AWS_KEY_ID','AWS_KEY_ACCESS','TWL_ID','TWL_TKN','TWL_VDO_KEY_SID','TWL_VDO_KEY_SCRT','MSV_KEY','MSV_SCRT','API_LYRNET_TKN','EMBLE_USER','EMBLE_PASS','EMBLE_TOKN','EMBLE_KEY','_MICROSOFT_CLIENT_ID','_MICROSOFT_CLIENT_SECRET','FULLCONTACT_KEY','FULLCONTACT_WBHK','_TIMEDOCTOR_CLIENT_ID','_TIMEDOCTOR_CLIENT_KEY', 'TW_CONSUMER_KEY', 'TW_CONSUMER_SECRET','TW_OAUTH_TOKEN','TW_OAUTH_TOKEN_SECRET','_INSTAGRAM_CLIENT_ID','_INSTAGRAM_CLIENT_SECRET','_LINKEDIN_CLIENT_ID','_LINKEDIN_CLIENT_SECRET', 'SUMR_AUTO_H', 'SUMR_AUTO_F', 'SUMR_AUTO_LOG', 'SUMR_AUTO_P'];

		_evar_set($evar);

	//-------------- READ SESSION DATA AT START = END --------------//

	if(Gt_DMN() == 'sumr.co'){
		define('PRFX_SERV', 'sumr');
		define('MACHINE_DMN', 'sumr.co');
	}elseif(Gt_DMN() == 'sumr.nz'){
		define('PRFX_SERV', 'sumr');
		define('MACHINE_DMN', 'sumr.nz');
	}elseif(Gt_DMN() == 'sumr.cloud'){
		define('PRFX_SERV', 'sumr');
		define('MACHINE_DMN', 'sumr.cloud');
	}elseif(Gt_DMN() == 'massivespace.rocks'){
		define('PRFX_SERV', 'sumr');
		define('MACHINE_DMN', 'sumr.cloud');
	}else{
		define('PRFX_SERV', 'sumr');
		define('SPR_DVLP', 'ok');
	}

	if(defined('SUMR_ENV')){
		if(SUMR_ENV == 'prd'){
			define('PBLC_HST', 'sumr-prd.cluster-ro-cevkibkbmeuq.us-east-1.rds.amazonaws.com');
			define('PBLC_HST_WRT', 'sumr-prd.cluster-cevkibkbmeuq.us-east-1.rds.amazonaws.com');
		}

	}

	if(SUMR_ENV == 'prd'){
		define('S3_FLE_DIR', 'prd');
		define('S3_PRVT_DIR', 'prd');
		define('DMN_CLOUD', 'sumr.cloud');
	}elseif(SUMR_ENV == 'qa'){
		define('S3_PRVT_DIR', 'dev');
		define('S3_FLE_DIR', 'dev');
		define('DMN_CLOUD', 'sumrdev.com');
	}

	if(	Gt_DMN() == 'sumr.co' ||
		Gt_DMN() == 'sumr.cloud' ||
		Gt_DMN() == 'sumr.nz' ||
		$_SERVER['HOSTNAME'] == 'server.sumr.in'
	){

		define('DB_PRFX_CL','sumr_c_');
		define('LOGO_MAIN', 'logo.svg');
		define('BRND_PRFX', '');

		if(	defined('MACHINE_WRKR') && MACHINE_WRKR == 'ok' ){
			define('SYS_AUTO', 'on');
		}

		if(	defined('MACHINE_WRKR_E') && !isN(MACHINE_WRKR_E)){
			define('MACHINE_WRKR_E', MACHINE_WRKR_E);
		}


		define('AUTO_SND_EC', 'on');
		define('AUTO_SND_SMS', 'on');

		define('AUTO_CHK_EML', 'on');


		define('AUTO_SND_SMS', 'on');
		define('AUTO_CHK_EML_BNC', 'on');

		define('AUTO_LSTS_EC', 'on');
		define('AUTO_LSTS_EC_VAR', 'on');
		define('AUTO_CMPG_EC', 'on');

		define('AUTO_SND_CL_FLJ', 'on');
		define('AUTO_UP_BD', 'on');




	}elseif(Gt_DMN() == 'sumr.cloud'){

		define('DB_PRFX_CL','sumr_c_');
		define('LOGO_MAIN', 'logo.svg');
		define('BRND_PRFX', '');
		//echo HST.' -------- '.HST_WRT;

	}elseif(Gt_DMN() == 'sumrdev.com'){

		define('DB_PRFX_CL','sumr_c_');
		define('LOGO_MAIN', 'logo.svg');
		define('BRND_PRFX', '');
		define('AUTO_BLD_EC', 'on');
		define('AUTO_SND_EC', 'on');
		define('AUTO_CHK_EML', 'on');
		define('AUTO_SND_SMS', 'on');
		define('AUTO_CHK_EML_BNC', 'on');
		define('AUTO_CMPG_EC', 'on');
		define('AUTO_LSTS_EC', 'on');
		define('AUTO_LSTS_EC_VAR', 'on');

	}

	define('DB_PRFX_CL','sumr_c_');
	define('PXLNM','pxl.jpg');

	define('DMN_HTTP', _http());
	define('DMN_HTTPS', 'https://');
	define('DMN', Gt_DMN().'/');
	define('DMN_S', Gt_DMN());

	define('DR_AC','__ac/');

	define('DR_IMG','_img/');
	define('DR_IMG_TH','th/');
	define('DR_IMG_GAL','gal/');
	define('DR_IMG_BN','bn/');
	define('DR_FL','_fl/');





	define('DIR_INC','includes/');
	define('DIR_INC_ESTR', DIR_INC.'structure/');
	define('DIR_INC_PRC', DIR_INC.'process/');
	define('DIR_INC_FNC', 'functions/');
	define('DIR_INC_FNC_DT', DIR_INC_FNC.'_dt/');
	define('DIR_INC_FNC_SCL', DIR_INC_FNC.'_scl/');


	define('DIR_INC_CLS', 'classes/');
	define('DIR_EXT', DR_FL.'_ext/');

	define('ESTR_GN', DIR_INC_ESTR.'_gn.php');


	/* Archivos absolutos SISTEMA */





	define('DIR_CNT','_cnt/');
	define('DIR_CNT_FM', DIR_CNT.'_fm/');
	define('DIR_CNT_FLT', DIR_CNT.'_flt/');
	define('DIR_CNT_LS', DIR_CNT.'_ls/');
	define('DIR_CNT_INF', DIR_CNT.'_inf/');
	define('DIR_CNT_DT', DIR_CNT.'_dt/');
	define('DIR_CNT_JSON', DIR_CNT.'_json/');
	define('DIR_CNT_UP', DIR_CNT.'_up/');
	define('DIR_CNT_GRPH', DIR_CNT.'_grph/');


	define('FL_FM_GN', DIR_CNT_FM.'_gn.php');
	define('FL_FM_UP', DIR_CNT_FM.'_up.php');
	define('FL_FM_DWN', DIR_CNT_FM.'_dwn.php');

	define('FL_LS_GN', DIR_CNT_LS.'_gn.php');
	define('FL_SLC_GN', DIR_CNT_LS.'_slc.php');
	define('FL_DT_GN', DIR_CNT_DT.'_gn.php');
	define('FL_DT_BN', DIR_CNT_DT.'_bn.php');
	define('FL_INF_GN', DIR_CNT_INF.'_gn.php');
	define('FL_JSON_GN', DIR_CNT_JSON.'_gn.php');
	define('FL_UP_GN', DIR_CNT_UP.'_gn.php');
	define('FL_GRPH_GN', DIR_CNT_GRPH.'_gn.php');


	define('DIR_EXT', '_ext/');


	define('FL_SB', '_sb/');
	define('FL_SB_ENC', FL_SB.'enc/');
	define('FL_SB_SGN', FL_SB.'sgn/');
	define('FL_SB_APP', FL_SB.'app/');


	/* Archivos absolutos SISTEMA */


	define('FL_ESTR_RSL', DIR_INC_ESTR.'rsl.php');
	define('FL_ESTR_SIS', DIR_INC_ESTR.'sis.php');

	define('FL_ESTR_MNU_USER', DIR_INC_ESTR.'mnu_user.php');


	define('PRC_GN', DIR_INC_PRC.'_gn.php');
	define('PRC_GN_LOGIN', 'login.php');
	define('PRC_GN_LOGOUT', 'logout.php');
	define('PRC_UPLD_GN', DIR_INC_PRC.'_up.php');
	define('PRC_CHAT', DIR_INC_PRC.'_chat.php');


	define('DIR_TMP_FLE', '.sumr_fle/');
	define('DIR_TMP_FLE_FLE', DIR_TMP_FLE.'fle/');
	define('DIR_TMP_BCO', '.sumr_bco/');

	define('DIR_RD', DIR_TMP_FLE.'rd/');
	define('DIR_RD_FLE', DIR_RD.'fle/');

	define('DIR_FLE_ANX', DIR_TMP_FLE.'anx/');
	define('DIR_FLE_TMP', DIR_TMP_FLE.'tmp/');

	define('DIR_FLE_OFR', DIR_TMP_FLE.'ofr/');
	define('DIR_FLE_PRO', DIR_TMP_FLE.'pro/');
	define('DIR_FLE_PS', DIR_TMP_FLE.'ps/');
	define('DIR_FLE_SIS', DIR_TMP_FLE.'sis/');
	define('DIR_FLE_BD', DIR_TMP_FLE.'bd/');
	define('DIR_FLE_ORG_GRP', DIR_TMP_FLE.'org_grp/');
	define('DIR_FLE_ACT', DIR_TMP_FLE.'act/');

	define('DIR_FLE_TPC', DIR_TMP_FLE.'tpc/');
	define('DIR_FLE_CNTRC', DIR_TMP_FLE.'cntrc/');

	define('DIR_PRVT', '');
	define('DIR_PRVT_UP', 'up/');
	define('DIR_PRVT_DWN', 'dwn/');
	define('DIR_PRVT_ATTCH', 'attch/');


	define('DIR_TMP_PRVT', DIR_TMP_FLE.'xls/');
	define('DIR_TMP_PRVT_UP', DIR_TMP_PRVT.'up/');
	define('DIR_TMP_PRVT_DWN', DIR_TMP_PRVT.'dwn/');


	define('DIR_FLE_SIS_SLC', DIR_FLE_SIS.'slc/');
	define('DIR_FLE_SIS_SLC_TP', DIR_FLE_SIS_SLC.'tp/');
	define('DIR_FLE_SIS_SLC_BCK', DIR_FLE_SIS_SLC.'bck/');


	define('DIR_FLE_SIS_CNT_EST', DIR_FLE_SIS.'cnt_est/');
	define('DIR_FLE_SIS_CNT_EST_TP', DIR_FLE_SIS.'cnt_est_tp/');


	define('DIR_FLE_SIS_MD', DIR_FLE_SIS.'md/');
	define('DIR_FLE_SIS_EC_SGM', DIR_FLE_SIS.'ec/sgm/');

	define('DIR_FLE_CL', DIR_TMP_FLE.'cl/');
	define('DIR_FLE_CL_MNU', DIR_FLE_CL.'mnu/');
	define('DIR_FLE_CL_TH', DIR_FLE_CL.'th/');
	define('DIR_FLE_CL_BCK', DIR_FLE_CL.'bck/');
	define('DIR_FLE_CL_BCK_APP', DIR_FLE_CL_BCK.'app/');
	define('DIR_FLE_CL_BCK_APP_CSTM', DIR_FLE_CL_BCK_APP.'cstm/');

	define('DIR_FLE_CL_LGO', DIR_FLE_CL.'lgo/');
	define('DIR_FLE_CL_LGO_LGHT', DIR_FLE_CL_LGO.'lght/');
	define('DIR_FLE_CL_LGO_ICO', DIR_FLE_CL_LGO.'ico/');
	define('DIR_FLE_CL_LGO_RSLLR', DIR_FLE_CL_LGO.'rsllr/');


	define('DIR_FLE_CL_ARE', DIR_FLE_CL.'are/');
	define('DIR_FLE_CL_ARE_LGO', DIR_FLE_CL_ARE.'lgo/');
	define('DIR_FLE_CL_ARE_HDR', DIR_FLE_CL_ARE.'hdr/');
	define('DIR_FLE_CL_WDGT', DIR_FLE_CL.'wdgt/');
	define('DIR_FLE_CL_WDGT_ACT', DIR_FLE_CL_WDGT.'act/');
	define('DIR_FLE_CL_WDGT_TEST', DIR_FLE_CL_WDGT.'test/');
	define('DIR_FLE_CL_STORE', DIR_FLE_CL.'store/');
	define('DIR_FLE_CL_STORE_BRND', DIR_FLE_CL_STORE.'brnd/');


	define('DIR_FLE_ORG', DIR_TMP_FLE.'org/');
	define('DIR_FLE_ORG_TH', DIR_FLE_ORG.'th/');

	define('DIR_FLE_MDL', DIR_TMP_FLE.'mdl/');
	define('DIR_FLE_MDL_TH', DIR_FLE_MDL.'th/');

	define('DIR_FLE_MDL_GEN', DIR_TMP_FLE.'mdl_gen/');
	define('DIR_FLE_MDL_GEN_TH', DIR_FLE_MDL_GEN.'th/');

	define('DIR_FLE_MDL_S', DIR_FLE_MDL.'s/');
	define('DIR_FLE_MDL_S_TH', DIR_FLE_MDL_S.'th/');

	define('DIR_FLE_MDL_TP', DIR_FLE_MDL.'tp/');
	define('DIR_FLE_MDL_TP_TH', DIR_FLE_MDL_TP.'th/');

	define('DIR_FLE_FLL', DIR_TMP_FLE.'fll/');
	define('DIR_FLE_FLL_TH', DIR_FLE_FLL.'th/');
	define('DIR_FLE_US', DIR_TMP_FLE.'us/');
	define('DIR_FLE_US_TH', DIR_FLE_US.'th/');

	define('DIR_FLE_EC', DIR_TMP_FLE.'ec/');
	define('DIR_FLE_EC_HTML', DIR_FLE_EC.'html/');
	define('DIR_FLE_EC_CMZ', DIR_FLE_EC.'cmz/');
	define('DIR_FLE_EC_TH', DIR_FLE_EC.'th/');
	define('DIR_FLE_EC_SND', DIR_FLE_EC.'snd/');

	define('DIR_FLE_LND', DIR_TMP_FLE.'lnd/');
	define('DIR_FLE_LND_HTML', DIR_FLE_LND.'html/');

	define('DIR_FLE_APP', DIR_TMP_FLE.'app/');
	define('DIR_FLE_APP_HTML', DIR_FLE_APP.'html/');


	define('DIR_FLE_TW', DIR_TMP_FLE.'tw/');
	define('DIR_FLE_TW_HTML', DIR_FLE_TW.'anm/');

	define('DIR_FLE_EC_IMG', DIR_FLE_EC.'img/');
	define('DIR_FLE_EC_IMG_TH', DIR_FLE_EC_IMG.'img/');
	define('DIR_FLE_BN', DIR_TMP_FLE.'bn/');
	define('DIR_FLE_BN_HTML', DIR_FLE_BN.'html/');
	define('DIR_FLE_LRN', DIR_TMP_FLE.'lrn/');


	define('DIR_BCO', DIR_TMP_BCO);
	define('DIR_BCO_TH', DIR_BCO.'th/');
	define('DIR_BCO_FCE', DIR_BCO.'fce/');
	define('DIR_BCO_FCE_TH', DIR_BCO_FCE.'th/');


	define('DIR_FLE_SCL', DIR_TMP_FLE.'scl/');
	define('DIR_FLE_SCL_FROM', DIR_FLE_SCL.'from/');
	define('DIR_FLE_SCL_ACC', DIR_FLE_SCL.'acc/');
	define('DIR_FLE_SCL_ACC_CVR', DIR_FLE_SCL_ACC.'cvr/');

	define('DIR_IMG', '_img/');
	define('DIR_IMG_WEB', DIR_IMG.'wb/');
	define('DIR_IMG_ESTR', DIR_IMG.'estr/');
	define('DIR_IMG_ESTR_SVG', DIR_IMG.'estr/svg/');


	define('DIR_FLE_TRA', DIR_TMP_FLE.'tra/');
	define('DIR_FLE_TRA_TH', DIR_FLE_TRA.'th/');
	define('DIR_FLE_TRA_COL', DIR_FLE_TRA.'col/');
	define('DIR_FLE_TRA_COL_TH', DIR_FLE_TRA_COL.'th/');

	define('DIR_FLE_EML', DIR_TMP_FLE.'eml/');

	define('DIR_FLE_CTRL', DIR_TMP_FLE.'ctrl/');

	define('DT_GN', DIR_CNT_DT.'_gn.php'); // General para includes de globales
	define('DT_GN_IMG', 'img.php');

	define('DV_SBCNT', 'SbCnt');
	define('IMG_NP', DIR_IMG_ESTR.'nonim.jpg');

	/* CAMBIA EN CADA CLIENTE */

		define('DIR_IMG_WEB_EC', DIR_IMG_WEB.'_ec/');
		define('DIR_IMG_WEB_EC_TH', DIR_IMG_WEB_EC.'th/');

		define('DIR_IMG_WEB_OG', DIR_IMG_WEB.'_og/');
		define('DIR_IMG_WEB_OG_TH', DIR_IMG_WEB_OG.'th/');

		define('DIR_IMG_WEB_BCO', DIR_IMG_WEB.'_bco/');
		define('DIR_IMG_WEB_BCO_TH', DIR_IMG_WEB_BCO.'th/');

		define('DIR_IMG_WEB_BCO_FCE', DIR_IMG_WEB_BCO.'_fce/');
		define('DIR_IMG_WEB_BCO_FCE_TH', DIR_IMG_WEB_BCO_FCE.'th/');


		define('DIR_IMG_WEB_UNI', DIR_IMG_WEB.'_uni/');
		define('DIR_IMG_WEB_UNI_TH', DIR_IMG_WEB_UNI.'th/');



	define('DMN_DG', DMN_HTTPS.'digital.'.DMN);


	//define('DMN_IMG', DMN_HTTPS.'img.'.DMN_CLOUD.'/');
	define('DMN_IMG', DMN_HTTPS.'img.'.DMN);

	define('DMN_IMG_ESTR', DMN_IMG.'estr/');
	define('DMN_IMG_ESTR_ICN', DMN_IMG_ESTR.'icn/');
	define('DMN_IMG_ESTR_SVG', DMN_IMG_ESTR.'svg/');
	define('DMN_IMG_ESTR_WDGT', DMN_IMG_ESTR.'wdgt/');
	define('DMN_IMG_ESTR_ERR', DMN_IMG_ESTR.'err/');
	define('DMN_IMG_ESTR_EC', DMN_IMG_ESTR.'ec/');
	define('DMN_IMG_ESTR_DW', DMN_IMG_ESTR.'dw/');

	//if($_GET['Camilo']=='ok'){
	//	define('DMN_JS', DMN_HTTPS.'js.'.DMN_CLOUD.'/');
	//}else{
		define('DMN_JS', DMN_HTTPS.'js.'.DMN);
	//}


	define('DMN_JS_SB', DMN_JS.'sb/');
	define('DMN_JS_SB_CLG', DMN_JS_SB.'clg/');
	define('DMN_JS_SB_VTEX', DMN_JS_SB.'vtex/');
	define('DMN_JS_SB_DWN', DMN_JS_SB.'dwn/');

	//define('DMN_CSS', DMN_HTTPS.'css.'.DMN_CLOUD.'/');
	define('DMN_CSS', DMN_HTTPS.'css.'.DMN);
	define('DMN_FONT', DMN_HTTPS.'font.'.DMN);
	define('DMN_SHRT', DMN_HTTPS.'s.'.DMN);

	define('DMN_AUTO', DMN_HTTPS.'auto.'.DMN);
	define('DMN_UPD', DMN_HTTPS.'upd.'.DMN);
	define('DMN_API', DMN_HTTPS.'api.'.DMN);
	define('DMN_TRCK', DMN_HTTPS.'trck.'.DMN);
	define('DMN_CK', DMN_HTTPS.'ck.'.DMN);

	define('DMN_ENC', DMN_HTTPS.'encuestas.'.DMN);
	define('DMN_APP', DMN_HTTPS.'app.'.DMN);

	if(defined('DMN_CLOUD')){
		define('DMN_ANM', DMN_HTTPS.'anm.'.DMN_CLOUD.'/');
	}

	//define('DMN_ANM', DMN_HTTPS.'anm.'.DMN);


	define('DMN_DWND', DMN_HTTPS.'dwn.'.DMN);
	//define('DMN_DWND', DMN_HTTPS.'dwn.'.DMN_CLOUD.'/');
	//define('DMN_DWN', DMN_HTTPS.'download.'.DMN);

	define('DMN_MNTR', DMN_HTTPS.'monitor.'.DMN);


	define('DMN_ACT', DMN_HTTPS.'actividad.'.DMN);


	define('DMN_ACC', DMN_HTTPS.'account.'.DMN);
	define('DMN_EC', DMN_HTTPS.'pushmail.'.DMN);
	define('DMN_EC_HTML', DMN_EC.'html/');
	define('DMN_EC_PRVW', DMN_HTTPS.'pushmail-preview.'.DMN);


	define('DMN_AFL', DMN_HTTPS.'afiliacion.'.DMN);

	define('DMN_DWN', DMN_HTTPS.'download.'.DMN);
	//define('DMN_DWN', DMN_HTTPS.'download.'.DMN_CLOUD.'/');

	define('DMN_CMP', DMN_HTTPS.'marketing.'.DMN);
	define('DMN_ICS', DMN_HTTPS.'ics.'.DMN);
	define('DMN_BN', DMN_HTTPS.'bn.'.DMN);
	define('DMN_SGN', DMN_HTTPS.'sign.'.DMN);
	define('DMN_LND', DMN_HTTPS.'landing.'.DMN);
	define('DMN_LND_CSS', DMN_LND.'css/');
	define('DMN_LND_JS', DMN_LND.'js/');

	define('DMN_CALL', DMN_HTTPS.'call.'.DMN);
	define('DMN_GOO', DMN_HTTPS.'goo.'.DMN);
	define('DMN_MEET', DMN_HTTPS.'meet.'.DMN);


	//define('DMN_FLE', DMN_HTTPS.'fle.'.DMN);
	if(defined('DMN_CLOUD')){
		define('DMN_FLE', DMN_HTTPS.'fle.'.DMN_CLOUD.'/');
		define('DMN_ANX', DMN_HTTPS.'anx.'.DMN_CLOUD.'/');
		define('DMN_BCO', DMN_HTTPS.'bco.'.DMN_CLOUD.'/');
	}

	define('DMN_WDGT', DMN_HTTPS.'wdgt.'.DMN);

	if(defined('DMN_FLE')){

		define('DMN_FLE_CL', DMN_FLE.'cl/');
		define('DMN_FLE_CL_TH', DMN_FLE_CL.DR_IMG_TH);
		define('DMN_FLE_CL_MNU', DMN_FLE_CL.'mnu/');
		define('DMN_FLE_CL_ARE', DMN_FLE_CL.'are/');
		define('DMN_FLE_CL_WDGT', DMN_FLE_CL.'wdgt/');
		define('DMN_FLE_CL_WDGT_ACT', DMN_FLE_CL_WDGT.'act/');
		define('DMN_FLE_CL_WDGT_TEST', DMN_FLE_CL_WDGT.'test/');
		define('DMN_FLE_CL_STORE', DMN_FLE_CL.'store/');
		define('DMN_FLE_CL_STORE_BRND', DMN_FLE_CL_STORE.'brnd/');

		define('DMN_FLE_ANX', DMN_FLE.'anx/');
		define('DMN_FLE_RD', DMN_FLE.'rd/');
		define('DMN_FLE_RD_BCK', DMN_FLE_RD.'bck/');

		define('DMN_FLE_CL_BCK', DMN_FLE_CL.'bck/');
		define('DMN_FLE_CL_BCK_APP', DMN_FLE_CL_BCK.'app/');
		define('DMN_FLE_CL_BCK_APP_CSTM', DMN_FLE_CL_BCK_APP.'cstm/');

		define('DMN_FLE_CL_LGO', DMN_FLE_CL.'lgo/');
		define('DMN_FLE_CL_LGO_LGHT', DMN_FLE_CL_LGO.'lght/');
		define('DMN_FLE_CL_LGO_ICO', DMN_FLE_CL_LGO.'ico/');
		define('DMN_FLE_CL_LGO_RSLLR', DMN_FLE_CL_LGO.'rsllr/');

		define('DMN_FLE_CL_ARE', DMN_FLE_CL.'are/');
		define('DMN_FLE_CL_ARE_LGO', DMN_FLE_CL_ARE.'lgo/');
		define('DMN_FLE_CL_ARE_HDR', DMN_FLE_CL_ARE.'hdr/');

		define('DMN_FLE_FLL', DMN_FLE.'fll/');
		define('DMN_FLE_US', DMN_FLE.'us/');
		define('DMN_FLE_ORG', DMN_FLE.'org/');
		define('DMN_FLE_ORG_TH', DMN_FLE_ORG.DR_IMG_TH);
		define('DMN_FLE_ORG_GRP', DMN_FLE.'org_grp/');

		define('DMN_FLE_LNG', DMN_FLE.'lng/');
		define('DMN_FLE_MDL', DMN_FLE.'mdl/');
		define('DMN_FLE_ACT', DMN_FLE.'act/');
		define('DMN_FLE_MDL_GEN', DMN_FLE.'mdl_gen/');
		define('DMN_FLE_MDL_S', DMN_FLE_MDL.'s/');
		define('DMN_FLE_MDL_TP', DMN_FLE_MDL.'tp/');

		define('DMN_FLE_TPC', DMN_FLE.'tpc/');
		define('DMN_FLE_CNTRC', DMN_FLE.'cntrc/');

		define('DMN_FLE_GRPH_MTRC', DMN_FLE.'grph/mtrc/');

		define('DMN_FLE_GRPH_DMS', DMN_FLE.'grph/dms/');
		define('DIR_FLE_GRPH_DMS', DIR_TMP_FLE.'grph/dms/');

		define('DMN_FLE_SIS', DMN_FLE.'sis/');
		define('DMN_FLE_SIS_SLC', DMN_FLE_SIS.'slc/');
		define('DMN_FLE_SIS_SLC_TP', DMN_FLE_SIS_SLC.'tp/');
		define('DMN_FLE_SIS_SLC_BCK', DMN_FLE_SIS_SLC.'bck/');

		define('DMN_FLE_SIS_CNT_EST', DMN_FLE_SIS.'cnt_est/');
		define('DMN_FLE_SIS_CNT_EST_TP', DMN_FLE_SIS.'cnt_est_tp/');

		define('DMN_FLE_SIS_MD', DMN_FLE_SIS.'md/');
		define('DMN_FLE_SIS_EC_SGM', DMN_FLE_SIS.'ec/sgm/');

		define('DMN_FLE_PS', DMN_FLE.'ps/');
		define('DMN_FLE_PS_TH', DMN_FLE_PS.DR_IMG_TH);

		define('DMN_FLE_BD', DMN_FLE.'bd/');
		define('DMN_FLE_BD_TH', DMN_FLE_BD.DR_IMG_TH);

		define('DMN_FLE_LND', DMN_FLE.'lnd/');
		define('DMN_FLE_LND_IMG', DMN_FLE_LND.'img/');
		define('DMN_FLE_LND_HTML', DMN_FLE_LND.'html/');

		define('DMN_FLE_EC', DMN_FLE.'ec/');
		define('DMN_FLE_EC_HTML', DMN_FLE_EC.'html/');
		define('DMN_FLE_EC_IMG', DMN_FLE_EC.'img/');
		define('DMN_FLE_EC_CMZ', DMN_FLE_EC.'cmz/');

		define('DMN_FLE_LRN', DMN_FLE.'lrn/');

		define('DMN_WRKR', DMN_HTTPS.'worker.'.DMN_CLOUD.'/');

		define('DMN_FLE_TRA', DMN_FLE.'tra/');
		define('DMN_FLE_TRA_COL', DMN_FLE_TRA.'col/');
		define('DMN_FLE_TRA_COL_TH', DMN_FLE_TRA_COL.DR_IMG_TH);

		//define('DMN_FLE_BCO', DMN_FLE.'bco/');
		define('DMN_FLE_BCO', DMN_BCO);

		define('DMN_FLE_BCO_TH', DMN_FLE_BCO.DR_IMG_TH);
		define('DMN_FLE_BCO_FCE', DMN_FLE_BCO.'fce/');
		define('DMN_FLE_BCO_FCE_TH', DMN_FLE_BCO_FCE.DR_IMG_TH);
		define('DMN_IMG_AC', DMN_HTTPS.'img-ac.'.DMN);
		define('DMN_OAUTH', DMN_HTTPS.'oauth.'.DMN);
		define('DMN_FORM', DMN_HTTPS.'form.'.DMN);
		define('DMN_LEGAL', DMN_HTTPS.'legal.'.DMN);
		define('DMN_FLE_SCL', DMN_FLE.'scl/');
		define('DMN_FLE_SCL_FROM', DMN_FLE_SCL.'from/');
		define('DMN_FLE_SCL_ACC', DMN_FLE_SCL.'acc/');
		define('DMN_FLE_SCL_ACC_CVR', DMN_FLE_SCL_ACC.'cvr/');

		define('DMN_FLE_APP', DMN_FLE.'app/');
		define('DMN_FLE_EML', DMN_FLE.'eml/');

		define('DMN_ERR', DMN_HTTPS.'err.'.DMN);
		define('HTML_BR', '</br>');

	}

	// Private Domains

	if(SUMR_ENV == 'prd'){

		define('PRV_DMN_BCK', 'bck.prvt-sumr');
		define('PRV_DMN_NDJS', 'node.prvt-sumr');
		define('PRV_DMN_WRKR', 'wrkr.prvt-sumr');
		define('DMN_WSS', 'wss://ws.'.DMN_CLOUD);

	}elseif(SUMR_ENV == 'dev'){

		define('PRV_DMN_BCK', 'bck.prvt-dev-sumr');
		define('PRV_DMN_NDJS', 'node.prvt-dev-sumr');
		define('PRV_DMN_WRKR', 'wrkr.prvt-dev-sumr');
		define('DMN_WSS', 'wss://ws.'.DMN);

	}else{

		define('PRV_DMN_WRKR', DMN_WRKR);
		define('PRV_DMN_NDJS', DMN_WRKR);
		define('PRV_DMN_WRKR', DMN_WRKR);
		define('DMN_WSS', 'wss://ws.'.DMN_CLOUD);

	}


	if(defined('SUMR_ENV') && (SUMR_ENV == 'prd' || SUMR_ENV == 'dev')){

		define('DBM','sumr_bd');
		define('DBD','sumr__dwn');
		define('DBC','sumr_chat');
		define('DBT','sumr_thrd');
		define('DBP','sumr_bdprc');
		define('DBA','sumr_auto');
		define('DBR','sumr_rsllr');
		define('DBS','sumr_store');

		define('DB', PRFX_SERV.'_bd');
		define('DB_PRC', PRFX_SERV.'_bdprc');
		define('DB_CHT', PRFX_SERV.'_chat');
		define('DB_AUT', PRFX_SERV.'_auto');
		define('DB_DWN', PRFX_SERV.'__dwn');
		define('DB_DWN', PRFX_SERV.'__dwn');

	}

?>