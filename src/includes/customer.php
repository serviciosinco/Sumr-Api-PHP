<?php

	define('DMN_US_CALL', 'sumr@servicios.in');

	/* Cliente Subdominio */

	if($__no_sbdmn == 'ok'){
		$__sbdmn = PrmLnk('rtn', 1, 'ok');
	}else{
		$__sbdmn = Gt_SbDMN();
	}

	if(!isN($__sbdmn)){
		$__dt_cl = __Cl(['id'=>$__sbdmn, 't'=>'sbd', 'dtl'=>[ 'tag'=>'ok', 'dmn'=>'ok', 'eml'=>'ok' ] ]);
	}

	$___ses = new CRM_SES([ 'cl'=>$__dt_cl ]);

	function _LgAcc(){
		$__sbdmn = Gt_SbDMN();
		if($__sbdmn == 'account'){ return true; }else{ return false; }
	}

	function _StDbCl($_p=NULL){

		if(is_array($_p) && !isN($_p['sbd']) && !isN($_p['enc'])){

			define('DMN_BS_ADM', DMN_HTTP.$_p['sbd'].'.'. DMN);

			define('DB_CL', PRFX_SERV.'_c_'.$_p['sbd']);

			if($_p['sbd'] == 'serviciosin'){
				define('DB_CL_SVIN', 'ok');
			}

			define('DB_CL_ON', $_p['mre']->on);
			define('DB_CL_ID', $_p['mre']->id);
			define('DB_CL_NM', $_p['mre']->nm);
			define('DB_CL_PRC', PRFX_SERV.'_bdprc');
			define('DB_CL_FLD', $_p['sbd']);
			define('DB_CL_ENC', $_p['enc']);
			define('DB_CL_ENC_SES', DB_CL_ENC.'_');
			define('DB_CL_PRFL', $_p['prfl']);

			if(!isN($_p['mre'])){

				define('DB_CL_LGO', $_p['mre']->lgo->main->big);
				define('DB_CL_LGO_LGHT', $_p['mre']->lgo->lght->big);
				define('DB_CL_LGO_ICO', $_p['mre']->lgo->ico->big);

				define('DB_CL_CHAT', $_p['mre']->chat);

				if(!isN($_p['mre']->tag->ec_cmpg->days_aprb->v)){
					define('TAG_EC_CMPG_DAYS_APRB', $_p['mre']->tag->ec_cmpg->days_aprb->v);
				}

				if(!isN($_p['mre']->tag->clr->main->v)){
					define('TAG_CLR_MAIN', $_p['mre']->tag->clr->main->v);
				}

			}

			if(defined('DB_CL_FLD')){
				define('CL_IMG', DMN_HTTP. $_p['sbd'].'.'. DMN.'__ac/'.DB_CL_FLD.'/_img/');
			}

			define('CL_IMG_ESTR', CL_IMG.'estr/');
			define('CL_IMG_ESTR_ICN', CL_IMG.'icn/');


			define('URL_IMG_AC_WEB_PQR', DMN_IMG_AC.$_p['sbd'].'/_pqr/');
			define('URL_IMG_AC_WEB_PQR_TH', URL_IMG_AC_WEB_PQR.'th/');
			define('URL_IMG_AC_WEB_PQR_BN', URL_IMG_AC_WEB_PQR.'bn/');

			if(defined('DMN_DNS') && DMN_DNS == 'ok'){
				$_SERVER['HTTP_HOST'];
			}


		}

		if(function_exists('GtSis')) { $_cn = GtSis([ 't'=>'cl' ]); }

	}

	define('CL_ENC', $__dt_cl->enc);
	define('CL_SBD', $__dt_cl->sbd);


	define('DMN_SB', Gt_SbDMN());
	define('DMN_BS', DMN_HTTP.DMN);
	define('DMN_BS_PB', DMN_HTTP.'pb.'.DMN);
	define('DMN_CRM', DMN_HTTP.DMN_SB.'.'.DMN);
	define('DMN_CRM_B', DMN_SB.'.'.DMN_S);
	define('DMN_R', Gt_DMNR());

	if(defined('DB_CL_FLD')){
		define('DIR_CL_IMG', DR_AC.DB_CL_FLD.'/_img/');
		define('DIR_CL_IMG_ESTR', DIR_CL_IMG.'estr/');
	}

	if(isN($__dt_cl) && isN($__no_sbdmn)){

		$__sbdmn = Gt_SbDMN();
		$__dt_cl = __Cl([ 'id'=>$__sbdmn, 't'=>'sbd', 'dtl'=>[ 'tag'=>'ok', 'dmn'=>'ok', 'eml'=>'ok' ] ]);

		if(isN($__dt_cl->id) && $__pbc == 'ok'){
			$__dt_cl = __Cl([ 'id'=>PrmLnk('rtn', 1, 'ok'), 't'=>'sbd', 'dtl'=>[ 'tag'=>'ok', 'dmn'=>'ok', 'eml'=>'ok' ] ]);
		}

	}

	if(!isN($__dt_cl->sbd)){
		_StDbCl([ 'sbd'=>$__dt_cl->sbd, 'enc'=>$__dt_cl->enc, 'prfl'=>$__dt_cl->prfl, 'mre'=>$__dt_cl ]);
	}


	define('AWS_S3_JS', 'js.'.DMN_S);
	define('AWS_S3_CSS', 'css.'.DMN_S);

	if(defined('DMN_CLOUD')){
		define('AWS_S3_FLE', 'fle.'.DMN_CLOUD);
		define('AWS_S3_BCO', 'bco.'.DMN_CLOUD);
		define('AWS_S3_ANX', 'anx.'.DMN_CLOUD);
	}

?>