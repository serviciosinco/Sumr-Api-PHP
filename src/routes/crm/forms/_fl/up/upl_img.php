<?php
if((isset($_GET['_t2']))){
	
	$__t2 = Php_Ls_Cln($_GET['_t2']);
	$__t3 = Php_Ls_Cln($_GET['_t3']);
	$__id = Php_Ls_Cln($_GET['_i']);
	$__cll = Php_Ls_Cln($_GET['cll']);
	
	
	if($__t2 == 'bco'){
		
		$IdEl = 'id_bco'; // Id de Comparacion en Where
		$BdEl = TB_BCO; // Base de Datos de Consulta
		$ImNm = 'bco_img'; // Nombre del Campo de la Imagen
		$DrIm = DIR_IMG_WEB_BCO; // Directorio de la Imagen 
		$SzBg_W = 10000;
		$SzBg_H = 10000;
		
	}elseif($__t2 == 'cl'){

		$IdEl = 'id_cl'; // Id de Comparacion en Where
		$IdEnc = 'cl_enc';
		$IdT = 't';
		$BdEl = TB_CL; // Base de Datos de Consulta
		$ImNm = 'cl_img'; // Nombre del Campo de la Imagen
		$DrIm = DIR_FLE_CL; // Directorio de la Imagen 
		$SzBg_W = 500;
		$SzBg_H = 500;
		$SzTh = 200;
		
		$CrpRto = 1;
		
		$CrpRtoBn = 1;
		
	}elseif($__t2 == 'cl_bck'){

		$IdEl = 'id_cl'; // Id de Comparacion en Where
		$IdEnc = 'cl_enc';
		$IdT = 't';
		$BdEl = TB_CL; // Base de Datos de Consulta
		$DrIm = DIR_FLE_CL_BCK; // Directorio de la Imagen 
		$SzBg_W = 500;
		$SzBg_H = 500;
		$SzTh = 200;
		
		$CrpRto = 1;
		$CrpRtoBn = 1;
		
		$NoUpd = 'ok'; // No update database
		
	}elseif($__t2 == 'cl_bck_app'){

		$IdEl = 'id_cl'; // Id de Comparacion en Where
		$IdEnc = 'cl_enc';
		$IdT = 't';
		$BdEl = TB_CL; // Base de Datos de Consulta
		$DrIm = DIR_FLE_CL_BCK_APP; // Directorio de la Imagen 
		$SzBg_W = 500;
		$SzBg_H = 500;
		$SzTh = 200;
		
		$CrpRto = 1;
		$CrpRtoBn = 1;
		
		$NoUpd = 'ok'; // No update database
		
	}elseif($__t2 == 'cl_app'){


		$IdEl = 'id_clapp'; // Id de Comparacion en Where
		$IdEnc = 'clapp_enc';
		$BdEl = TB_CL_APP; // Base de Datos de Consulta
		$ImNm = 'clapp_img'; // Nombre del Campo de la Imagen
		$DrIm = DIR_FLE_CL_BCK_APP_CSTM; // Directorio de la Imagen 
		$DmnI = 'ok';
		
		$SzBg_W = 10000;
		$SzBg_H = 10000;
			
		
	}elseif($__t2 == 'cl_lgo'){

		$IdEl = 'id_cl'; // Id de Comparacion en Where
		$IdEnc = 'cl_enc';
		
		$IdT = 't';
		$BdEl = TB_CL; // Base de Datos de Consulta
		$DrIm = DIR_FLE_CL_LGO; // Directorio de la Imagen 
		$SzBg_W = 500;
		$SzBg_H = 500;
		$SzTh = 200;
		$CrpRto = 1;
		$CrpRtoBn = 1;
		$NoUpd = 'ok'; // No update database
		
	}elseif($__t2 == 'cl_lgo_lght'){

		$IdEl = 'id_cl'; // Id de Comparacion en Where
		$IdEnc = 'cl_enc';
		$IdT = 't';
		$BdEl = TB_CL; // Base de Datos de Consulta
		$DrIm = DIR_FLE_CL_LGO_LGHT; // Directorio de la Imagen 
		$SzBg_W = 500;
		$SzBg_H = 500;
		$SzTh = 200;
		$CrpRto = 1;
		$CrpRtoBn = 1;
		$NoUpd = 'ok'; // No update database
		
	}elseif($__t2 == 'cl_lgo_ico'){

		$IdEl = 'id_cl'; // Id de Comparacion en Where
		$IdEnc = 'cl_enc';
		$IdT = 't';
		$BdEl = TB_CL; // Base de Datos de Consulta
		$DrIm = DIR_FLE_CL_LGO_ICO; // Directorio de la Imagen 
		$SzBg_W = 500;
		$SzBg_H = 500;
		$SzTh = 200;
		$CrpRto = 1;
		$CrpRtoBn = 1;
		$NoUpd = 'ok'; // No update database
		
	}elseif($__t2 == 'cl_lgo_rsllr'){

		$IdEl = 'id_cl'; // Id de Comparacion en Where
		$IdEnc = 'cl_enc';
		
		$IdT = 't';
		$BdEl = TB_CL; // Base de Datos de Consulta
		$DrIm = DIR_FLE_CL_LGO_RSLLR; // Directorio de la Imagen 
		$SzBg_W = 500;
		$SzBg_H = 500;
		$SzTh = 200;
		
		$CrpRto = 1;
		
		$CrpRtoBn = 1;
		
		$NoUpd = 'ok'; // No update database
		
	}elseif($__t2 == 'cl_mnu'){
		
		$IdEl = 'id_clmnu'; // Id de Comparacion en Where
		$IdEnc = 'clmnu_enc';
		$BdEl = TB_CL_MNU; // Base de Datos de Consulta
		$ImNm = 'clmnu_img'; // Nombre del Campo de la Imagen
		$DrIm = DIR_FLE_CL_MNU; // Directorio de la Imagen 
		$DmnI = 'ok';
		
		$SzBg_W = 10000;
		$SzBg_H = 10000;
		
		
	}elseif($__t2 == 'cl_are'){
		
		$IdEl = 'id_clare'; // Id de Comparacion en Where
		$IdEnc = 'clare_enc';
		$BdEl = TB_CL_ARE; // Base de Datos de Consulta
		$ImNm = 'clare_img'; // Nombre del Campo de la Imagen
		$DrIm = DIR_FLE_CL_ARE; // Directorio de la Imagen 
		$DmnI = 'ok';
		
		$SzBg_W = 10000;
		$SzBg_H = 10000;
		
		
	}elseif($__t2 == 'cl_wdgt'){
		
		$IdEl = 'id_clwdgt'; // Id de Comparacion en Where
		$IdEnc = 'clwdgt_enc';
		$BdEl = TB_CL_WDGT; // Base de Datos de Consulta
		$ImNm = 'clwdgt_img'; // Nombre del Campo de la Imagen
		$DrIm = DIR_FLE_CL_WDGT; // Directorio de la Imagen 
		$DmnI = 'ok';
		
		$SzBg_W = 10000;
		$SzBg_H = 10000;
		
		
	}elseif($__t2 == 'cl_wdgt_test'){
		
		$IdEl = 'id_clwdgt'; // Id de Comparacion en Where
		$IdEnc = 'clwdgt_enc';
		$IdT = 't';
		$BdEl = TB_CL_WDGT; // Base de Datos de Consulta
		$DrIm = DIR_FLE_CL_WDGT_TEST; // Directorio de la Imagen 
		$SzBg_W = 500;
		$SzBg_H = 500;
		$SzTh = 200;
		
		$CrpRto = 1;
		$CrpRtoBn = 1;
		
		$NoUpd = 'ok'; // No update database
		
		
	}elseif($__t2 == 'cl_wdgt_bck'){

		$IdEl = 'id_cl'; // Id de Comparacion en Where
		$IdEnc = 'cl_enc';
		$IdT = 't';
		$BdEl = TB_CL; // Base de Datos de Consulta
		$DrIm = DIR_FLE_CL_BCK; // Directorio de la Imagen 
		$SzBg_W = 500;
		$SzBg_H = 500;
		$SzTh = 200;
		
		$CrpRto = 1;
		$CrpRtoBn = 1;
		
		$NoUpd = 'ok'; // No update database
		
	}elseif($__t2 == 'cl_wdgt_act'){

		$IdEl = 'id_clwdgtact'; // Id de Comparacion en Where
		$IdEnc = 'clwdgtact_enc';
		$BdEl = TB_CL_WDGT_ACT; // Base de Datos de Consulta
		$ImNm = 'clwdgtact_img'; // Nombre del Campo de la Imagen
		$DrIm = DIR_FLE_CL_WDGT_ACT; // Directorio de la Imagen 
		$DmnI = 'ok';
		
		$SzBg_W = 10000;
		$SzBg_H = 10000;

		
	}elseif($__t2 == 'cl_are_lgo'){

		$IdEl = 'id_clare'; // Id de Comparacion en Where
		$IdEnc = 'clare_enc';
		$IdT = 't';
		$BdEl = TB_CL_ARE; // Base de Datos de Consulta
		$ImNm = 'clare_logo'; // Nombre del Campo de la Imagen
		$DrIm = DIR_FLE_CL_ARE_LGO; // Directorio de la Imagen 
		$SzBg_W = 500;
		$SzBg_H = 500;
		$SzTh = 200;
		
		$CrpRto = 1;
		$CrpRtoBn = 1;

		
	}elseif($__t2 == 'cl_are_hdr'){

		$IdEl = 'id_clare'; // Id de Comparacion en Where
		$IdEnc = 'clare_enc';
		$IdT = 't';
		$BdEl = TB_CL_ARE; // Base de Datos de Consulta
		$ImNm = 'clare_hdr'; // Nombre del Campo de la Imagen
		$DrIm = DIR_FLE_CL_ARE_HDR; // Directorio de la Imagen 
		$SzBg_W = 500;
		$SzBg_H = 500;
		$SzTh = 200;
		
		$CrpRto = 1;
		$CrpRtoBn = 1;
		
		$NoUpd = 'ok'; // No update database
		
	}elseif($__t2 == 'store'){
		
		$BdStre = 'ok';
		$IdEl = 'id_store'; // Id de Comparacion en Where
		$IdEnc = 'store_enc';
		$BdEl = TB_STORE; // Base de Datos de Consulta
		$ImNm = 'store_img'; // Nombre del Campo de la Imagen
		$DrIm = DIR_FLE_CL_STORE; // Directorio de la Imagen 
		$DmnI = 'ok';
		
		$SzBg_W = 10000;
		$SzBg_H = 10000;
		
		
	}elseif($__t2 == 'store_brnd'){
		
		$BdStre = 'ok';
		$IdEl = 'id_storebrnd'; // Id de Comparacion en Where
		$IdEnc = 'storebrnd_enc';
		$BdEl = TB_STORE_BRND; // Base de Datos de Consulta
		$ImNm = 'storebrnd_img'; // Nombre del Campo de la Imagen
		$DrIm = DIR_FLE_CL_STORE_BRND; // Directorio de la Imagen 
		$DmnI = 'ok';
		
		$SzBg_W = 10000;
		$SzBg_H = 10000;
		
		
	}elseif($__t2 == 'sis_slc_f'){
		
		$IdEl = 'id_sisslc'; // Id de Comparacion en Where
		$BdEl = TB_SIS_SLC; // Base de Datos de Consulta
		$ImNm = 'sisslc_img'; // Nombre del Campo de la Imagen
		$DrIm = DIR_FLE_SIS_SLC; // Directorio de la Imagen 
		$SzBg_W = 10000;
		$SzBg_H = 10000;
		
		$_mynm = 'slc';
		
	}elseif($__t2 == 'sis_slc_f_bck'){

		$IdEl = 'id_sisslc'; // Id de Comparacion en Where
		$IdEnc = 'sisslc_enc';
		$IdT = 't';
		$BdEl = TB_SIS_SLC; // Base de Datos de Consulta
		$DrIm = DIR_FLE_SIS_SLC_BCK; // Directorio de la Imagen 
		$ImNm = 'sisslc_img_bck'; // Nombre del Campo de la Imagen
		$SzBg_W = 500;
		$SzBg_H = 500;
		$SzTh = 200;
		
		$CrpRto = 1;
		$CrpRtoBn = 1;
		//$NoUpd = 'ok'; // No update database
		
	}elseif($__t2 == 'sis_slc_tp'){
		
		$IdEl = 'id_sisslctp'; // Id de Comparacion en Where
		$BdEl = TB_SIS_SLC_TP; // Base de Datos de Consulta
		$ImNm = 'sisslctp_img'; // Nombre del Campo de la Imagen
		$DrIm = DIR_FLE_SIS_SLC_TP; // Directorio de la Imagen 
		$SzBg_W = 10000;
		$SzBg_H = 10000;
		
		$_mynm = 'slctp';
		
	}elseif($__t2 == 'prf'){

		$IdEl = 'id_prf'; // Id de Comparacion en Where
		$BdEl = MDL_PRF_BD; // Base de Datos de Consulta
		$ImNm = 'prf_img'; // Nombre del Campo de la Imagen
		$DrIm = DIR_IMG_WEB_PRF; // Directorio de la Imagen 
		$SzBg_W = 500;
		$SzBg_H = 500;
		$SzTh = 200;
		
		$CrpRto = 1;
		$CrpRtoBn = 1;
		
	}elseif($__t2 == 'mdl_s_tp'){
		
		$_mynm = 'mdl_s_tp';
		$IdEl = 'id_mdlstp'; // Id de Comparacion en Where
		$IdEnc = 'cl_enc';
		$IdT = 't';
		$BdEl = TB_MDL_S_TP; // Base de Datos de Consulta
		$ImNm = 'mdlstp_img'; // Nombre del Campo de la Imagen
		$DrIm = DIR_FLE_MDL_TP; // Directorio de la Imagen 
		$SzBg_W = 500;
		$SzBg_H = 500;
		$SzTh = 200;
		
		$CrpRto = 1;
		
		$CrpRtoBn = 1;
		
		
	}elseif($__t2 == 'mdl'){
		
		$IdEl = 'id_mdl'; // Id de Comparacion en Where
		$IdEnc = 'mdl_enc';
		$IdT = 't';
		
		$BdCl = 'ok';
		$BdEl = TB_MDL; // Base de Datos de Consulta
		$ImNm = 'mdl_img'; // Nombre del Campo de la Imagen
		$DrIm = DIR_FLE_MDL; // Directorio de la Imagen 
		$DmnIm = 'DMN_FLE_MDL';
		
		$SzBg_W = 10000;
		$SzBg_H = 10000;
		$SzTh = 200;
		$CrpRto = 1;
		$CrpRtoBn = 1;		
		
		
	}elseif($__t2 == 'us'){

		$IdEl = 'us_enc'; // Id de Comparacion en Where
		if($__id == ''){ $__id = SISUS_ENC; }
		$IdT = 't';
		$BdEl = TB_US; // Base de Datos de Consulta
		$ImNm = 'us_img'; // Nombre del Campo de la Imagen
		$DrIm = DIR_FLE_US; // Directorio de la Imagen 
		$SzBg_W = 500;
		$SzBg_H = 500;
		$SzTh = 200;	
		$CrpRto = 1;
		$CrpRtoBn = 1;
		
	}elseif($__t2 == 'emp'){

		$IdEl = 'id_fllorg'; // Id de Comparacion en Where
		if($__id == ''){ $__id = SISUS_ENC; }
		$IdT = 't';
		$BdEl = TB_FLL_ORG; // Base de Datos de Consulta
		$ImNm = 'fllorg_logo'; // Nombre del Campo de la Imagen
		$DrIm = DIR_FLE_FLL; // Directorio de la Imagen 
		$SzBg_W = 500;
		$SzBg_H = 500;
		$SzTh = 200;
		
		$CrpRto = 1;
		$CrpRtoBn = 1;
	
	}elseif($__t2 == 'org'){

		$IdEl = 'id_org'; // Id de Comparacion en Where
		$IdEnc = 'org_enc';
		$IdT = 't';
		$BdEl = TB_ORG; // Base de Datos de Consulta
		$ImNm = 'org_img'; // Nombre del Campo de la Imagen
		$DrIm = DIR_FLE_ORG; // Directorio de la Imagen 
		$DmnIm = 'DMN_FLE_ORG';

		$SzBg_W = 500;
		$SzBg_H = 500;
		$SzTh = 200;
		
		$CrpRto = 1;
		
		$CrpRtoBn = 1;
		
	}elseif($__t2 == 'sis_md'){

		$IdEl = 'id_sismd'; // Id de Comparacion en Where
		$IdEnc = 'sismd_enc';
		$IdT = 't';
		$BdEl = TB_SIS_MD; // Base de Datos de Consulta
		$ImNm = 'sismd_img'; // Nombre del Campo de la Imagen
		$DrIm = DIR_FLE_SIS_MD; // Directorio de la Imagen 
		$SzBg_W = 500;
		$SzBg_H = 500;
		$SzTh = 200;
		
		$CrpRto = 1;
		
		$CrpRtoBn = 1;
		
	}elseif($__t2 == 'sis_cnt_est'){

		$IdEl = 'id_siscntest'; // Id de Comparacion en Where
		$IdEnc = 'siscntest_enc';
		$IdT = 't';
		$BdEl = TB_SIS_CNT_EST; // Base de Datos de Consulta
		$ImNm = 'siscntest_img'; // Nombre del Campo de la Imagen
		$DrIm = DIR_FLE_SIS_CNT_EST; // Directorio de la Imagen 
		$SzBg_W = 500;
		$SzBg_H = 500;
		$SzTh = 200;
		
		$CrpRto = 1;
		
		$CrpRtoBn = 1;
		
	}elseif($__t2 == 'sis_cnt_est_tp'){

		$IdEl = 'id_siscntesttp'; // Id de Comparacion en Where
		$IdEnc = 'siscntesttp_enc';
		$IdT = 't';
		$BdEl = TB_SIS_CNT_EST_TP; // Base de Datos de Consulta
		$ImNm = 'siscntesttp_img'; // Nombre del Campo de la Imagen
		$DrIm = DIR_FLE_SIS_CNT_EST_TP; // Directorio de la Imagen 
		$SzBg_W = 500;
		$SzBg_H = 500;
		$SzTh = 200;
		
		$CrpRto = 1;
		
		$CrpRtoBn = 1;
		
	}elseif($__t2 == 'snd_ec_tmpl'){

		$IdEl = 'id_ec'; // Id de Comparacion en Where
		$IdEnc = 'ec_enc';
		$IdT = 't';
		$BdEl = TB_EC; // Base de Datos de Consulta
		$ImNm = 'ec_img'; // Nombre del Campo de la Imagen
		$DrIm = DIR_FLE_EC_IMG; // Directorio de la Imagen 
		$DmnIm = 'DMN_FLE_EC_IMG';
		$SzBg_W = 500;
		$SzBg_H = 500;
		$SzTh = 200;
		
		$CrpRto = 1;
		
		$CrpRtoBn = 1;
		
		$_mynm = 'ec';
		
	}elseif($__t2 == 'lrn'){

		$IdEl = 'id_lrn'; // Id de Comparacion en Where
		$IdEnc = 'lrn_enc';
		$IdT = 't';
		$BdEl = TB_LRN; // Base de Datos de Consulta
		$ImNm = 'lrn_img'; // Nombre del Campo de la Imagen
		$DrIm = DIR_FLE_LRN; // Directorio de la Imagen 
		$SzBg_W = 500;
		$SzBg_H = 500;
		$SzTh = 200;
		
		$CrpRto = 1;
		
		$CrpRtoBn = 1;
		
	}elseif($__t2 == 'sis_ec_sgm'){

		$IdEl = 'id_sisecsgm'; // Id de Comparacion en Where
		$IdEnc = 'sisecsgm_enc';
		$IdT = 't';
		$BdEl = TB_SIS_EC_SGM; // Base de Datos de Consulta
		$ImNm = 'sisecsgm_img'; // Nombre del Campo de la Imagen
		$DrIm = DIR_FLE_SIS_EC_SGM; // Directorio de la Imagen 
		$SzBg_W = 500;
		$SzBg_H = 500;
		$SzTh = 200;
		
		
		$CrpRto = 1;
		$CrpRtoBn = 1;
		
	}elseif($__t2 == 'tpc'){

		$IdEl = 'id_tpc'; // Id de Comparacion en Where
		$IdEnc = 'tpc_enc';
		$IdT = 't';
		$BdEl = TB_TPC; // Base de Datos de Consulta
		$ImNm = 'tpc_img'; // Nombre del Campo de la Imagen
		$DrIm = DIR_FLE_TPC; // Directorio de la Imagen 
		$SzBg_W = 500;
		$SzBg_H = 500;
		$SzTh = 200;
		
		
		$CrpRto = 1;
		$CrpRtoBn = 1;
		
	}elseif($__t2 == 'sis_ps'){

		$IdEl = 'id_sisps'; // Id de Comparacion en Where
		$IdEnc = 'sisps_enc';
		$IdT = 't';
		$BdEl = TB_SIS_PS; // Base de Datos de Consulta
		$ImNm = 'sisps_img'; // Nombre del Campo de la Imagen
		$DrIm = DIR_FLE_PS; // Directorio de la Imagen 
		$SzBg_W = 500;
		$SzBg_H = 500;
		$SzTh = 200;
		
		$CrpRto = 1;
		
		$CrpRtoBn = 1;
		
	}elseif($__t2 == 'cntrc'){

		$IdEl = 'id_cntrc'; // Id de Comparacion en Where
		$IdEnc = 'cntrc_enc';
		$IdT = 't';
		$BdEl = 'cntrc'; // Base de Datos de Consulta
		$ImNm = 'cntrc_lgo'; // Nombre del Campo de la Imagen
		$DrIm = DIR_FLE_CNTRC; // Directorio de la Imagen 
		$SzBg_W = 500;
		$SzBg_H = 500;
		$SzTh = 200;
		
		
		$CrpRto = 1;
		$CrpRtoBn = 1;
		
	}elseif($__t2 == 'mdl_gen'){
		
		$IdEl = 'id_mdlgen'; // Id de Comparacion en Where
		$IdEnc = 'mdlgen_enc';
		$IdT = 't';
		
		$BdCl = 'ok';
		$BdEl = TB_MDL_GEN; // Base de Datos de Consulta
		$ImNm = 'mdlgen_img'; // Nombre del Campo de la Imagen
		$DrIm = DIR_FLE_MDL_GEN; // Directorio de la Imagen 
		$DmnIm = 'DMN_FLE_MDL_GEN';
		
		$SzBg_W = 10000;
		$SzBg_H = 10000;
		$SzTh = 200;
		
		$CrpRto = 1;
		
		$CrpRtoBn = 1;		
		
		
	}elseif($__t2 == 'dsh_mtrc'){
		
		$IdEl = 'id_dshmtrc'; // Id de Comparacion en Where
		$IdEnc = 'dshmtrc_enc';
		$IdT = 't';
		$BdEl = TB_DSH_MTRC; // Base de Datos de Consulta
		$ImNm = 'dshmtrc_img'; // Nombre del Campo de la Imagen
		$DrIm = DIR_FLE_GRPH_MTRC; // Directorio de la Imagen 
		$SzBg_W = 500;
		$SzBg_H = 500;
		$SzTh = 200;
		
		
		$CrpRto = 1;
		$CrpRtoBn = 1;		
		
	}elseif($__t2 == 'sis_bd'){

		$IdEl = 'id_sisbd'; // Id de Comparacion en Where
		$IdEnc = 'sisbd_enc';
		$IdT = 't';
		$BdEl = TB_SIS_BD; // Base de Datos de Consulta
		$ImNm = 'sisbd_img'; // Nombre del Campo de la Imagen
		$DrIm = DIR_FLE_BD; // Directorio de la Imagen 
		$SzBg_W = 500;
		$SzBg_H = 500;
		$SzTh = 200;
		
		$CrpRto = 1;
		
		$CrpRtoBn = 1;
		
	}elseif($__t2 == 'org_grp'){

		$IdEl = 'id_orggrp'; // Id de Comparacion en Where
		$IdEnc = 'orggrp_enc';
		$IdT = 't';
		$BdEl = TB_ORG_GRP; // Base de Datos de Consulta
		$ImNm = 'orggrp_img'; // Nombre del Campo de la Imagen
		$DrIm = DIR_FLE_ORG_GRP; // Directorio de la Imagen 
		$SzBg_W = 500;
		$SzBg_H = 500;
		$SzTh = 200;
		
		$CrpRto = 1;
		
		$CrpRtoBn = 1;
		
	}elseif($__t2 == 'act'){

		$IdEl = 'id_act'; // Id de Comparacion en Where
		$IdEnc = 'act_enc';
		$IdT = 't';
		$BdEl = TB_ACT; // Base de Datos de Consulta
		$ImNm = 'act_img'; // Nombre del Campo de la Imagen
		$DrIm = DIR_FLE_ACT; // Directorio de la Imagen 
		$SzBg_W = 500;
		$SzBg_H = 500;
		$SzTh = 200;
		
		$CrpRto = 1;
		
		$CrpRtoBn = 1;
		
	}elseif($__t2 == 'tra_col' || $__t2 == 'tra_col_grp'){

		$IdEl = 'tracol_enc'; // Id de Comparacion en Where
		$IdT = 't';
		$BdEl = TB_TRA_COL; // Base de Datos de Consulta
		$ImNm = 'tracol_img'; // Nombre del Campo de la Imagen
		$DrIm = DIR_FLE_TRA_COL; // Directorio de la Imagen 
		$SzBg_W = 500;
		$SzBg_H = 500;
		$SzTh = 200;	
		$CrpRto = 1;
		$CrpRtoBn = 1;
		$_mynm = 'tra_col';

	}elseif($__t2 == 'eml'){

		$BdThrd = 'ok';
		$IdEl = 'id_eml'; // Id de Comparacion en Where
		$IdEnc = 'eml_enc';
		$IdT = 't';
		$BdEl = TB_THRD_EML; // Base de Datos de Consulta
		$ImNm = 'eml_img'; // Nombre del Campo de la Imagen
		$DrIm = DIR_FLE_EML; // Directorio de la Imagen 
		$SzBg_W = 500;
		$SzBg_H = 500;
		$SzTh = 200;
		
		$CrpRto = 1;
		
		$CrpRtoBn = 1;
		
	}elseif($__t2 == 'mdl_ctrl'){

		$BdThrd = 'ok';
		$IdEl = 'id_mdlctrl'; // Id de Comparacion en Where
		$IdEnc = 'mdlctrl_enc';
		$IdT = 't';
		$BdCl = 'ok';
		$BdEl = TB_MDL_CTRL; // Base de Datos de Consulta
		$ImNm = 'mdlctrl_img'; // Nombre del Campo de la Imagen
		$DrIm = DIR_FLE_CTRL; // Directorio de la Imagen 
		$SzBg_W = 500;
		$SzBg_H = 500;
		$SzTh = 200;
		
		$CrpRto = 1;
		
		$CrpRtoBn = 1;
		
	}elseif($__t2 == 'rd'){

		$IdEl = 'id_rd'; // Id de Comparacion en Where
		$IdEnc = 'rd_enc';
		$IdT = 't';
		$BdEl = TB_RD; // Base de Datos de Consulta
		$DrIm = DIR_FLE_RD; // Directorio de la Imagen 
		$SzBg_W = 500;
		$SzBg_H = 500;
		$SzTh = 200;
		
		$CrpRto = 1;
		$CrpRtoBn = 1;
		
		$NoUpd = 'ok'; // No update database
		
	}elseif($__t2 == 'rd_bck'){

		$IdEl = 'id_rd'; // Id de Comparacion en Where
		$IdEnc = 'rd_enc';
		$IdT = 't';
		$BdEl = TB_RD; // Base de Datos de Consulta
		$DrIm = DIR_FLE_RD_BCK; // Directorio de la Imagen 
		$ImNm = 'rd_img_bck'; // Nombre del Campo de la Imagen
		$SzBg_W = 500;
		$SzBg_H = 500;
		$SzTh = 200;
		$CrpRto = 1;
		$CrpRtoBn = 1;
		
		//$NoUpd = 'ok'; // No update database
		
	}
	
}

if(!isN($BdCl)){ $_prfx_bd = _BdStr(DB_CL); }
elseif(!isN($BdStre)){ $_prfx_bd = _BdStr(DBS); }
elseif(!isN($BdThrd)){ $_prfx_bd = _BdStr(DBT); }
else{ $_prfx_bd = _BdStr(DBM); }
 
$Dt_Qry = sprintf("SELECT * FROM ".$_prfx_bd.$BdEl." WHERE ".$IdEl." = %s LIMIT 1", GtSQLVlStr($__id, ($IdT=='t'?"text":"int") ));
$Dt_Rg = $__cnx->_qry($Dt_Qry); 

if($Dt_Rg){
	$row_Dt_Rg = $Dt_Rg->fetch_assoc();
	$Tot_Dt_Rg = $Dt_Rg->num_rows;
}else{
	echo h1($__cnx->c_r->error);
}

if(!isN($_mynm)){ $__t_gt=$_mynm; }else{ $__t_gt=$__t2; } 
if(!isN($__cll)){ $__cll_js = " eval($__cll); "; }

$_bx_rnd = '';
?>
<div id="UplImg" class="UplImg">
    <div class="Btn">
    <?php echo bdiv(['id'=>'ImLdr_Icn']); ?>
    <?php echo bdiv(['id'=>'LdEdtImgTh']); ?>
    <?php echo bdiv(['id'=>'LdEdtImgBn']); ?>
    <?php echo bdiv(['id'=>ID_LDR_PRC.'_Img']); ?>
        <div class="Opc">
			<?php 
				
				if($Tot_Dt_Rg > 0){
					
					$IdIm = $row_Dt_Rg[$IdEl];
					
				}else{
					
					$IdIm = $_GET['id_pl'];
				} 
				
				if($row_Dt_Rg[$ImNm] != ''){ 
					
					$ImgGoTo = $row_Dt_Rg[$ImNm];
					
				}else{
					
					$ImgGoTo = $__t2.'_'.$row_Dt_Rg[$IdEl].'.jpg?';
				
				} 
				
				
				
				if(!isN($IdEnc)){
					$__id_el = $row_Dt_Rg[$IdEnc];
					$__id_el_t = $IdEnc;
				}else{
					$__id_el = $row_Dt_Rg[$IdEl];
					$__id_el_t = $IdEl;
				}
			?>
			<?php echo Hrf('javascript:Upl_Bx();',TX_UPL,1,'','','vla _anm'); ?>
            <?php echo Hrf(Void(),TX_EDTH,1,'','','edTh _anm'); ?>
            <?php echo Hrf(Void(),TX_EDBN,1,'','','edBn _anm'); ?>
        </div>
    </div>
</div>




<div id="UplImg_Bx" class="UplImg_Bx" <?php if($row_Dt_Rg[$ImNm] != ''){ ?> style="display:none;" <?php } ?>>
		
		<form id="UplNwB" class="UplNwB" method="post" action="<?php echo PRC_UPLD_GN.'?'.TXGN_UPL ?>" enctype="multipart/form-data">
			<div id="drop" class="_drop">
				<?php echo TX_ARRTRAQ ?>

				<a><?php echo TX_EXPLR ?></a>
				<input type="file" name="upl" multiple />
                <input id="_i" name="_i" type="hidden" value="<?php echo $row_Dt_Rg[$IdEl] ?>" />
                <input id="_enc" name="_enc" type="hidden" value="<?php echo $row_Dt_Rg[$IdEnc] ?>" />
                <input id="_nm" name="_nm" type="hidden" value="<?php echo $__t_gt ?>" />
                <input id="_bd" name="_bd" type="hidden" value="<?php echo $BdEl ?>" />

				<?php if(!isN($BdCl)){ ?>
                <input id="_bd_cl" name="_bd_cl" type="hidden" value="<?php echo $BdCl ?>" />
				<?php }elseif(!isN($BdStre)){ ?>
                <input id="_bd_store" name="_bd_store" type="hidden" value="<?php echo $BdStre ?>" />
				<?php }elseif(!isN($BdThrd)){ ?>
                <input id="_bd_store" name="_bd_thrd" type="hidden" value="<?php echo $BdThrd ?>" />
				<?php } ?>

                <input id="_id" name="_id" type="hidden" value="<?php echo $IdEl ?>" />
                <input id="_fl" name="_fl" type="hidden" value="<?php echo $ImNm ?>" />
                <input id="_dr" name="_dr" type="hidden" value="<?php echo $DrIm ?>" />
                <input id="_idt" name="_idt" type="hidden" value="<?php echo $IdT ?>" />
                
                <?php if($NoUpd == 'ok'){ ?>
                <input id="_noupd" name="_noupd" type="hidden" value="ok" />
                <?php } ?>
                
                <input name="MM_update" type="hidden" value="ImgUpl" />
			</div>

			<ul></ul>

		</form>
</div> 


<div id="Img_Crp_Ok" class="Img_Crp_Ok" style="display:none"><?php echo Spn(TX_IMGSML).' '.TX_WSVDSCF ?></div>
<div id="Img_Crp_No" class="Img_Crp_No" style="display:none"><?php echo Spn(TX_IMGSML).' '.TX_WNTSCSF ?></div>

<div id="Dt_Im" class="Dt_Im" <?php if($row_Dt_Rg[$ImNm] == ''){ ?> style="display:none;" <?php } ?>>
	<div id="LdEdtPbImg"></div>
	<?php 
		
		echo bdiv([ 'id'=>DV_IMG.'_Img' ]); 
		
		$___vrgo =	[ 
						'icn'=>ID_LDR_PRC.'_Img',
						'dv'=>DV_IMG.'_Img', 
						'fl'=>DT_GN,
						'm'=>[
							'_t'=>'img'
						], 
						'tp'=>2 	
					];
		
		if(!isN($DmnI)){ $___vrgo['m']['dmn_im'] = $DmnI; }
		if(!isN($DmnIm)){ $___vrgo['m']['dmn'] = urlencode($DmnIm); }
		if(!isN($row_Dt_Rg[$ImNm])){ $___vrgo['m']['Img'] = $row_Dt_Rg[$ImNm]; }
		if(!isN($DrIm)){ $___vrgo['m']['Dir'] = $DrIm; }
		
		echo UpLdImg($___vrgo);
	
	?>
</div>

<div id="UplImg_Rqu" class="UplImg_Rqu">
	<h2><?php echo TX_RQSTS ?></h2>
    <ul>
    	<li><?php echo Spn(TX_FRMT).'JPG, SVG, PNG' ?></li>
        <li><?php echo Spn(TX_TMNMB).'Máximo 5 Mb' ?></li>
        <li><?php echo Spn(TX_TMNPX).'Máximo 1200 x 1080 px' ?></li>
    </ul> 
</div>
<script>
	function Upl_Bx(){
		$('#Dt_Im').fadeOut('slow', function(){
			$('#UplImg_Bx').fadeIn();
		});
	}
</script>
<?php 

$CntWb .= "							
	
	
	SUMR_Main.ld.f.upl( function(){			
		
		var e = $('#UplNwB ul');	
		
		$('#drop a').off('click').click(function() {
			$(this).parent().find('input').click()
		});
		
		$('.UplImg .edTh').off('click').on('click', function(event){ 
			
			".
			UpLdImgTH([
				'f'=>'th',
				'tp'=>1,
				'icn'=>ID_LDR_PRC.'_Img',
				'dv'=>DV_IMG.'_Img',
				'fl'=>FL_FM_GN,
				'm'=>[
					'i'=>$__id_el,
					't'=>$__t_gt,
					'id_el'=>$__id_el_t,
					'bd_el'=>$BdEl,
					'bd_cl'=>$BdCl,
					'ImNm'=>$ImNm,
					'dr_im'=>urlencode($DrIm),
					'dmn'=>urlencode($DmnIm),
					'dmn_im'=>$DmnI,
					'Sz_Th'=>$SzTh,
					'Crp_Img'=>$CrpRto
				]
			])
			
			."
			
		});
		
		
		$('.UplImg .edBn').off('click').on('click', function(event){ 
			
			".UpLdImgTH([
				'f'=>'bn',
				'tp'=>1,
				'icn'=>ID_LDR_PRC.'_Img',
				'dv'=>DV_IMG.'_Img', 
				'fl'=>FL_FM_GN, 
				'm'=>[
					'i'=>$__id_el,
					't'=>$__t_gt,
					'id_el'=>$__id_el_t,
					'bd_el'=>$BdEl,
					'bd_cl'=>$BdCl,
					'ImNm'=>$ImNm,
					'dr_im'=>urlencode($DrIm),
					'dmn'=>urlencode($DmnIm),
					'dmn_im'=>$DmnI,
					'Sz_Th'=>$SzTh,
					'Crp_Img'=>$CrpRtoBn		
				]
			])."
			
		});
		
		SUMR_Main.ld.f.upl( function(){

			if(jQuery().fileupload){

				$('#UplNwB').fileupload({
			
					dataType: 'json',
					sequentialUploads: true,
					maxNumberOfFiles: 50,
					dropZone: $('#drop'),
					add: 
					
						function(n, r) {
							var i = $('<li class=\"working\"><input type=\"text\" value=\"0\" data-width=\"48\" data-height=\"48\"' + ' data-fgColor=\"#0788a5\" data-readOnly=\"1\" data-bgColor=\"#3e4043\" /><p></p><span></span></li>');
							i.find('p').text(r.files[0].name).append('<i>' + SUMR_Ld.f.nSz(r.files[0].size) + '</i>');
							r.context = i.appendTo(e);
							i.find('input').knob();
							i.find('span').click(function() {
								if (i.hasClass('working')) {
									s.abort()
								}
								i.fadeOut(function() {
									i.remove()
								})
						});
						var s = r.submit()
					},
					progress: function(e, t) {
						var n = parseInt(t.loaded / t.total * 100, 10);
						t.context.find('input').val(n).change();								
					},
					progressall: function (e, data) {
						var n = parseInt(data.loaded / data.total * 100, 10);
						$('#UplNwB ._bar').fadeIn('fast').css(
							'width',n + '%'
						);
					},
					fail: function(e, t) {
						SUMR_Main.log.f({ m:e });
					},
					done: function (e, t) {
						
						if(!isN(t) && !isN(t.result) && !isN(t.result.status)){

							var n = parseInt(t.loaded / t.total * 100, 10);

							if (n == 100 && t.result.status == 'success') {	
								t.context.removeClass('working').delay(1000).fadeOut('fast');
								$('#UplImg_Bx').fadeOut('fast', function(){
									".UpLdImg([ 
										'icn'=>ID_LDR_PRC.'_Img',
										'dv'=>DV_IMG.'_Img', 
										'fl'=>DT_GN,
										'm'=>[
											'_t'=>'img',
											'dmn_im'=>$DmnI,
											'Img'=>$DrIm.$row_Dt_Rg[$ImNm],
										], 
										'tp'=>1 
									]).";
									$('#Dt_Im').fadeIn('fast');
									{$__cll_js}
								});
								
							}else{
								t.context.addClass('error');
								if(!isN(t.result.w)){ SUMR_Main.log.f({ m:t.result.w }); }
							}
						
						}
						
					}
				});	

			}
		
		});	
			
		
		/*$(document).on('drop dragover', function(e) {
			e.preventDefault();
		});*/
		
		SUMR_Main.log.f({ m:'Ready to show' });
	
	});


"; 


?>