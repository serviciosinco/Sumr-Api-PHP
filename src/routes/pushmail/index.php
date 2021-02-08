<?php

	$pth = '../../includes/';
	$__https_off = 'off';
	$__no_sbdmn = 'ok';
	$__bdfrnt = 'ok';

	include($pth .'inc.php'); //ob_start("compress_code");

	if($_GET['Camilo']=='ok'){ echo 'Here i am on HT'; exit(); }

	$browser = new Browser();

	//---------------- Get Parameters ----------------//

		$__mdlC = Php_Ls_Cln($_GET['_mdlC']);
		$__evnC = Php_Ls_Cln($_GET['_evnC']);
		$__mdlI = Php_Ls_Cln($_GET['_mdlI']);
		$__evnI = Php_Ls_Cln($_GET['_evnI']);

		$__eC = Php_Ls_Cln($_GET['eC']);
		$__c = Php_Ls_Cln($_GET['_c']);
		$__l = Php_Ls_Cln($_GET['__l']);
		$__s = Php_Ls_Cln($_GET['__s']);

		$_t = Php_Ls_Cln($_GET['_t']);
		$_s = Php_Ls_Cln($_GET['_s']);
		$_cnt = Php_Ls_Cln($_GET['_cnt']);
		$_cnt_tp = Php_Ls_Cln($_GET['_cnt_tp']);
		$_cnt_tp_grp = Php_Ls_Cln($_GET['_cnt_tp_grp']);
		$_cnt_bd = Php_Ls_Cln($_GET['_cnt_bd']);


		$_drvf = Php_Ls_Cln($_GET['_dvrf']);
		$_ref = Php_Ls_Cln($_GET['_rf']);

		$__edit = Php_Ls_Cln($_GET['__edit']);
		$__sc = Php_Ls_Cln($_GET['_sc']);

		$__scl = Php_Ls_Cln($_GET['_scl']);
		$__tll = Php_Ls_Cln($_GET['_tll']);


	//---------------- Get Data Global ----------------//

		$__tab_thm = 'ok';

		if(!isN($__c)){

			$_cl_dt = GtClDt($__c, 'enc', ['dtl'=>['tag'=>'ok']] );

		}else{

			$_cl_dt = GtClDt(PrmLnk('rtn', 1, 'ok'), 'sbd', ['dtl'=>['tag'=>'ok']] );

		}

		if(!isN($_cnt_tp_grp)){
			$___cnttpgrpdt = GtCntTpGrpDt([ 't'=>'enc', 'id'=>$_cnt_tp_grp ]); $__scp_attr['cnt-tp-grp'] = $___cnttpgrpdt->enc;
			if(!isN($___cntbddt->tabs)){ $__tab_thm = $___cntbddt->tabs; }
		}

		if(!isN($_cnt_bd)){ $___cntbddt = GtSisBdDt([ 't'=>'enc', 'id'=>$_cnt_bd ]); $__scp_attr['cnt-bd'] = $___cntbddt->enc; if(!isN($___cntbddt->tabs)){ $__tab_thm = $___cntbddt->tabs; } }

		if(!isN($_s)){ $__dtsnd = GtEcSndDt([ 'bd'=>$_cl_dt->bd.'.', 'cl'=>$_cl_dt->enc, 'id'=>$_s, 'tp'=>'enc', 'dtl'=>[ 'cmpg'=>'ok', 'eml'=>'ok', 'cnt'=>'ok', 'plcy'=>'ok' ] ]); }

	//---------------- Start Process ----------------//



	if(strpos($_SERVER['REQUEST_URI'], 'sv.php')){

		$_frw_pm = 'on';
		$_frw_url = DMN_EC.LNK_HTML.'/'.$_GET['eC'];

	}elseif(PrmLnk('rtn', 2, 'ok') == LNK_DEL || PrmLnk('rtn', 2, 'ok') == LNK_UPD){

		if(!isN($_cl_dt->bd)){

			_StDbCl(['sbd'=>$_cl_dt->sbd, 'enc'=>$_cl_dt->enc, 'mre'=>$_cl_dt ]);

			if(!isN($_cnt)){

				$__dtcnt = GtCntDt([  'bd'=>$_cl_dt->bd, 'cl'=>$_cl_dt->enc, 'id'=>$_cnt, 't'=>'enc' ]);

				if(isN($__dtcnt->tel_all->ls)){ $___cnt_no_tel='ok'; }
				if(isN($__dtcnt->eml)){ $___cnt_no_eml='ok'; }

			}else{

				if(!isN($__dtsnd)){
					$__dtcnt = $__dtsnd->cnt;
				}

			}

			if(!isN($_drvf)){
				$__dtdvrf = GtCntDvrfDt([ 't'=>'enc', 'id'=>$_drvf, 'cnt'=>$__dtcnt->id, 'bd'=>$_cl_dt->bd ]);
				if($__dtdvrf->e != 'ok'){ exit(); }
			}


			include('cnt/sis.php');
		}

	}elseif(PrmLnk('rtn', 1, 'ok') == 'a'){

		include('cnt/aprb.php');

	}elseif(PrmLnk('rtn', 1, 'ok') == 'verify'){

		$_vrf_tp = PrmLnk('rtn', 2, 'ok');
		if(!isN($_vrf_tp)){ include('cnt/verify.php'); }

	}elseif(PrmLnk('rtn', 2, 'ok') == 'policy'){

		$_vrf_tp = PrmLnk('rtn', 3, 'ok');
		if(!isN($_vrf_tp)){ include('cnt/policy.php'); }

	}elseif(PrmLnk('rtn', 1, 'ok') == LNK_HTML){


		$__ec = new API_CRM_ec();

		$__ec->id = PrmLnk('rtn',2,'ok');
		$__ec->id_t = 'enc';
		$__ec->mdlc = $__mdlC;
		$__ec->evnc = $__evnC;

		if(!isN($__mdlI)){
			$__ec->mdli = $__mdlI;
			$__ec->btrck = 'ok';
		}

		$__ec->evni = $__evnI;
		$__ec->frm = 'Ml';
		$__ec->html = 'ok';
		if($__scl == 'no'){ $__ec->ec_scl = 'no'; }
		if($__tll == 'no'){ $__ec->ec_tll = 'no'; }
		$__ec->sve_url = $__l;
		$__ec->snd_i = $__s;
		$__ec->edt = $__edit;
		$__ec->sc = $__sc;


		$__body = $__ec->_bld();
		$__html = 'ok';


		if(PrmLnk('rtn', 3, 'ok') == 'demo'){

			$__dir = '../../../'.DIR_FLE_EC_HTML.$__ec->__dtec->dir.'/demo/index.html';
			$__dmn = DMN_FLE_EC_HTML.$__ec->__dtec->dir.'/demo/';
			$__html = file_get_contents($__dir);
			echo str_replace(["src='",'src="'], ["src='".$__dmn, 'src="'.$__dmn], $__html);

		}else{

			if($__edit == 'ok'){

				$__ec->_EcUpd_Fld([ 'id'=>$__ec->__dtec->id, 'f'=>'ec_upd_img', 'v'=>1 ]);

			}

			echo $__body;

		}


	}elseif(isset($_GET['eC'])&&($_GET['eC']!='')){

		$_vl = $_GET['eC'];
		$_tp = 'enc';
		$__dtec = GtEcDt($_vl, $_tp, [ 'dtl'=>[ 'cl'=>'ok' ] ]);
		if(!isN($__dtec->id)){ exit(); }else{$_frw_pm = 'on'; $_frw_url = DMN_EC.$__dtec->pml; }

	}elseif(_ChkEc(PrmLnk('rtn',1,'ok'))){

		/* Codigo especial para no perder rutas de imagenes */
		if((preg_match('/.jpg/', PrmLnk('rtn', 2, 'ok')))){
			$__dtec = GtEcDt(PrmLnk('rtn', 1, 'ok'), 'fld');
			$__p = explode('?', PrmLnk('rtn', 2, 'ok'));
			$__f = DR_FL.$__dtec->fld.'/'.$__p[0];
			$__fp = fopen($__f, 'rb');
			header("Content-Type: image/png");
			header("Content-Length: " . filesize($__f));
			fpassthru($__fp);
			exit();
		}
		/* Final de codigo especial */

	}elseif(PrmLnk('rtn', 1, 'ok') == 'sumr'){

		$_vl = PrmLnk('rtn', 2, 'ok');
		$_tp = 'pm';
		$_frw_pm = 'on';
		$__dtec = GtEcDt($_vl, $_tp);
		if($__dtec->id == NULL){ exit(); }else{$_frw_pm = 'on'; $_frw_url = DMN_EC.$__dtec->pml; }

	}elseif(PrmLnk('rtn', 1, 'ok') != ''){

		$_vl = PrmLnk('rtn', 1, 'ok');
		$_tp = 'pm';
		$__dtec = GtEcDt($_vl, $_tp);
		if($__dtec->id == NULL){ exit(); }

	}else{

		exit();

	}

	Hdr_HTML([ 'cche'=>'ok' ]);

if($_GET['_c'] == 'ok'){
	$Frw_Pth .= '/?_c=ok';
}

if($_frw_pm == 'on' && ($_frw_url != NULL)){

    header(sprintf("Location: %s", $_frw_url.$Frw_Pth));

}elseif(!empty($__dtec)&&($__html!='ok')){

	$__url = DMN_EC.PrmLnk('bld',$__dtec->pml,'ok');
    $__lnk = $__dtec->lnk;

    if(!isN($__dtec->img_v->th_50)){ $__img = $__dtec->img_v->big; }


?>
<!doctype html>
<html lang='es' class='no-js'>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title><?php echo $__dtec->tt ?></title>
<base href="/" target="_self">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, user-scalable=no">
<meta property='fb:app_id' content='<?php echo APP_FB_ID ?>'/>
<meta property='og:title' content='<?php echo $__dtec->tt ?>'/>
<meta property='og:type' content='website' />
<meta property='og:url' content='<?php echo $__url ?>' />
<meta property='og:image' content='<?php echo $__img ?>'/>
<meta property='og:image:secure_url' content='<?php echo $__img ?>'/>
<meta property='og:image:width' content='<?php echo $__dtec->img_w ?>'/>
<meta property='og:image:height' content='<?php echo $__dtec->img_h ?>'/>
<meta property='og:image:type' content='image/jpeg'/>

<meta property='og:site_name' content='<?php echo $__dtec->tt ?>' />
<meta property='og:description' content='<?php echo strip_tags($__dtec->dsc); ?>' />
<meta name='keywords' content='<?php echo __kyw($__dtec->dsc); ?>'>
<meta name='description' content='<?php echo strip_tags($__dtec->dsc); ?>' />
<link rel='image_src' type="image/jpeg" href='<?php echo $__img ?>' />

	<?php include('cnt/web.php'); ?>

<?php echo _anl(2); ?>
<noscript> <div class="_JvRc"> Su navegador NO tiene activo JAVA, puede representar dificultades para navegar </div> </noscript>
</body>
</html>
<?php } ?>
<?php //ob_end_flush(); ?>