<?php

	function ChckSESS_superadm(){
		if(defined('SIS_TPUS')){
			if((SIS_TPUS == 'superadmin')){ return(true); }else{ return(false); }
		}else{
			return(false);
		}
	}

	function ChckSESS_adm(){
		if(defined('SIS_TPUS') && defined('DB_CL_ON') && DB_CL_ON == 'ok'){
			if((SIS_TPUS == 'admin') || (SIS_TPUS == 'superadmin')){ return(true); }else{ return(false); }
		}else{
			return(false);
		}
	}

	function ChckSESS_usr(){
		if(defined('SIS_TPUS') && defined('DB_CL_ON') && DB_CL_ON == 'ok'){
			if((SIS_TPUS == 'user') || (SIS_TPUS == 'admin') || (SIS_TPUS == 'superadmin')){
				return(true);
			}else{
				return(false);
			}
		}else{
			return(false);
		}
	}

	function ChckSESS_be(){ if(defined('SIS_TPUS')){ if((SIS_TPUS == 'bolsaempleo')){ return(true); }else{ return(false); }}else{ return(false); } }

	function ChckSESS_cnt(){
		if(defined('DB_CL_ENC_SES') && !isN(DB_CL_ENC_SES)){
			if(!isN( $_SESSION[DB_CL_ENC_SES.MM_CNT] )){
				return(true);
			}else{
				return(false);
			}
		}else{
			return(false);
		}
	}


	function superadm_echo($c){ if(_ChckMd('spr_ech', 'ok')){ echo $c; } }
	function superadm_show($c){ if(_ChckMd('spr_ech', 'ok')){ return $c; }}

	function _isFm($_p=NULL){
		$_ifm = Php_Ls_Cln($_GET['_iF']);
		if($_p['r'] == 'ok'){ if($_ifm == 'o'){ return '_iF=o'; } }elseif($_ifm == 'o'){ return true; }else{ return false; }
	}

	function URL_Data($_s=NULL){
		$_r = parse_url(str_replace('www.','',$_s));
		return($_r);
	}

	//Convertir entero a minutos y segundos
	function Cnv_Int_Tme($p=NULL){

		$_div = explode(',',($p/60));
		$_min = $_div[0];
		$_sec = $p - (60*$_min);
		return "$_min:$_sec";

	}

	function is_json($string) {
		json_decode($string);
		if(json_last_error() == JSON_ERROR_NONE){ return true; }else{ return false; }
	}

	function is_html($string) {
	  return preg_match('/<\s?[^\>]*\/?\s?>/i', $string);
	}


	function is_cel($n) {
		if(strlen($n) < 10){
            return false;
        }else{
            return true;
        }
	}



	// Camilo - Nueva función para verificar versión del sistema - Evitar errores sobre nuevos desarrollos ! Importante
	function ChckSIS_v($v){ if($v >= SIS_V || ChckSESS_superadm()){ return true; }else{ return false; } }

	function __Cche_Hdr() {
    	if (function_exists("apache_request_headers")){ if($headers = apache_request_headers()) { return $headers; } }
		$headers = array();
		if (isset($_SERVER['HTTP_IF_MODIFIED_SINCE'])){ $headers['If-Modified-Since'] = $_SERVER['HTTP_IF_MODIFIED_SINCE']; }
		return $headers;
	}

	function __DcNw($_p=NULL){
		$_js = json_decode($_p, true);
		foreach($_js as $k => $v){ $_r[] = $v['tp_s'].' '.$v['dc']; }

		$_r = implode(' | ', $_r);
		return $_r;
	}

	function _url($url){

		if(strpos($url, 'http') === false){ $url = 'https://'.$url; }

		$pieces = parse_url($url);
		$domain = !isN($pieces['host'])?$pieces['host']:'';

		if(!isN($domain)){
			if (preg_match('/(?P<domain>[a-z0-9][a-z0-9\-]{1,63}\.[a-z\.]{2,6})$/i', $domain, $regs)) {
				return $regs['domain'];
	  		}
	  	}

	  	return false;
	}

	function _Tme($t=NULL, $f=NULL){

	   	if(!isN($t)){

			$dt = new DateTime($t, new DateTimeZone('UTC'));
			//$dt->setTimezone(new DateTimeZone('America/Bogota'));

			if($f=='col'){
				$_dte = FechaESP_OLD($dt->format('Y-m-d'), 5);
				$_hra = $dt->format('h:i a');
				$_f= Spn($_dte,'','__date').HTML_BR.Spn($_hra,'','__time');
			}elseif($f=='sng'){
				$_dte = FechaESP_OLD($dt->format('Y-m-d'), 9);
				$_hra = $dt->format('h:i a');
				$_f= Spn($_dte,'','__date').HTML_BR.Spn($_hra,'','__time');
			}else{
				$_dte = FechaESP_OLD($dt->format('Y-m-d'));
				$_hra = $dt->format('H:i a');
				$_f= Spn($_dte,'','__date').' '.Spn($_hra,'','__time');
			}

			return $_f;

		}else{

			return null;

		}

    }


	function __Cche_Mdf($p=NULL){

		$__fle_mtm = $p['mtm'];
		if($p['n'] != NULL){ $__m_e = '.'.enCad($p['n']);}


		$__fle_hdr = __Cche_Hdr();
		if($p['etag_n'] != 'no'){ header("Etag: SUMR-".enCad(E_TAG.$__m_e)); }
		header('X-Powered-By: Servicios.in');

		if ((isset($__fle_hdr['If-Modified-Since']) && (strtotime($__fle_hdr['If-Modified-Since']) == $__fle_mtm))
			|| (isset($__fle_hdr['If-None-Match']) && enCad(E_TAG.$__m_e) == $__fle_hdr['If-None-Match'])) {

			if($__fle_mtm != ''){
				header('Last-Modified: '.gmdate('D, d M Y H:i:s', $__fle_mtm).' GMT', true, 304);
			}else{
				header('HTTP/1.1 202 SvIn Cache');
			}
			$_r['c'] = 'ok';

		}else {
			if($__fle_mtm != ''){
				header('Last-Modified: '.gmdate('D, d M Y H:i:s', $__fle_mtm).' GMT', true, 200);
			}else{
				header('HTTP/1.1 200 SvIn Loaded');
			}
		}

		return _jEnc( $_r );
	}

	function Hdr_JS(){

		header('Access-Control-Allow-Origin: *');

		$__xpl = explode('?', dirname(__FILE__).'/_js'.$_SERVER['PHP_SELF']);
		$__fle = $__xpl[0];
		$__fle_mtm = filemtime($__fle);
		__Cche_Mdf(['mtm'=>$__fle_mtm]);

		if($__fle != '' && $__cche->c != 'ok'){
			header('Content-type: text/javascript; charset: UTF-8');
			header('Content-transfer-encoding: binary');
			header('Content-length: '.filesize($__fle));
		}else{
			$_r['e'] = 'c';
			exit();
		}
	}

	function Hdr_CSS($p=NULL){

		if(!isN($p['f'])){ $__d = $p['f']; }else{ $__d = dirname(__FILE__).str_replace('includes/', '', $_SERVER['PHP_SELF']); }
		$__xpl = explode('?', $__d );

		$__fle = $__xpl[0];
		if($__fle != ''){ $__fle_mtm = filemtime($__fle); }

		__Cche_Mdf(['mtm'=>$__fle_mtm, 'n'=>$__d]);

		if(!isN($__fle) && $__cche->c != 'ok'){
			header('Content-type: text/css; charset: UTF-8');
			header('Content-transfer-encoding: binary');
			header('Content-length: '.filesize($__fle));
			$_r['e'] = 'l';
		}else{
			$_r['e'] = 'c';
			exit();
		}

		return json_decode(json_encode($_r));
	}

	function Hdr_IMG($__fle=NULL, $p=NULL) {

		if($__fle != ''){
			$__xpl = explode('?', $__fle);
			$__fle = $__xpl[0];
			$__fle_mtm = filemtime($__fle);
			$__fle_ext = pathinfo($__fle, PATHINFO_EXTENSION);
		}

		if($__fle_ext == 'svg'){ $__fle_ext = 'svg+xml'; } if($__fle_ext == 'php'){ exit(); }

		if($p['cche'] != 'no'){
			$__cche = __Cche_Mdf(['mtm'=>$__fle_mtm, 'n'=>$__fle]);
		}

		if($p['cche'] == 'no' || ($__cche->c != 'ok' && !isN($__fle_ext))){
			$__fp = fopen($__fle, 'rb');
			//header('Cache-Control: cache, max-age=0');
			header('Content-type: image/'.$__fle_ext);
			header('Content-transfer-encoding: binary');
			//header('Content-length: '.filesize($__fle));
			fpassthru($__fp);
		}

	}




	function Hdr_IMG_New($p=NULL) {

		if(!isN($p['f'])){
			$__xpl = explode('?', $p['f']);
			$__fle = $__xpl[0];
			$__fle_mtm = filemtime($p['f']);
			$__fle_ext = pathinfo($p['f'], PATHINFO_EXTENSION);
		}

		if($__fle_ext == 'svg'){ $__fle_ext = 'svg+xml'; } if($__fle_ext == 'php'){ exit(); }

		if($p['cche'] != 'no'){
			$__cche = __Cche_Mdf(['mtm'=>$__fle_mtm, 'n'=>$p['f']]);
		}

		if($p['cche'] == 'no' || ($__cche->c != 'ok' && !isN($__fle_ext))){

			header('Content-type: image/'.$__fle_ext);
			header('Content-transfer-encoding: binary');
			header('Content-length: '.filesize($p['f']));
			readfile($p['f']);
		}

	}



	function vld_tel_g($p=NULL){

		if(!isN($p['v'])){

			$__t = explode('+',$p['v']);

			for($i=1; $i <= 3; $i++){

			    $__s = substr($__t[1], 0, $i);

			    $__chk = GtPsDt([ 'tp'=>'tel', 'v'=>$__s ]);

			    if($__chk->e == 'ok'){

				    $_t = str_replace('+'.$__s, '', $p['v']);

				    $_r['ps'] = $__chk->id;
				    $_r['no'] = $_t;

				    break;
				}
			}


		}else{
			$_r['no'] = $p['v'];
		}

		return _jEnc($_r);
	}


	//Valida que el celular o telefono sean correctos
	function vld_tel($p=NULL){

		if($p['t'] == 'cel'){ $v_tp < 10; }
		elseif($p['t'] == 'tel'){ $v_tp = 7; }
		else{ $v_tp = ''; }

		if(strpos($p['no'], '+') !== false){
			$_r['spr'] = 'ok';
			$vg = vld_tel_g([ 'v'=>$p['no'] ]);
			$_r['new'] = $vg;
			$p['no'] = $vg->no;
		}

		$patrones = $sustituciones = array();
		$patrones[0] = '/-/';
		$patrones[1] = '/\s/';
		$sustituciones[0] = '';
		$sustituciones[1] = '';
		$p['no'] = preg_replace($patrones, $sustituciones, $p['no']);

		if(!isN($v_tp)){

			if(!isN($p['ps']) && $p['ps'] == 57){
				if(!preg_match("/^[0-9]{".$v_tp."}$/", $p['no'])){
					$_r['e'] = 'no';
				}else{
					$_r['e'] = 'ok';
				}
			}else{
				if(!preg_match("/^[0-9]+$/", $p['no'])){
					$_r['e'] = 'no';
				}else{
					$_r['e'] = 'ok';
				}
			}

		}else{

			if(!isN($p['ps']) && $p['ps'] == 57){
				if(!preg_match("/^[0-9]{7}$/", $v) && !preg_match("/^[0-9]{10}$/", $p['no'])){
					$_r['e'] = 'no';
				}else{
					$_r['e'] = 'ok';
				}
			}else{
				if(!preg_match("/^[0-9]+$/", $p['no'])){
					$_r['e'] = 'no';
					$_r['w'][] = 'Not valid match';
				}else{
					$_r['e'] = 'ok';
				}
			}

		}

		return(_jEnc($_r));
	}

	function LsCntTel($_p=NULL){

		global $__cnx;

		if(!isN($_p['id'])){

			$Ls_Qry = "	SELECT *
						FROM ".TB_CNT_TEL."
							 INNER JOIN "._BdStr(DBM).TB_SIS_PS." ON cnttel_ps = id_sisps
							 WHERE cnttel_cnt = ".GtSQLVlStr($_p['cnt'], "int")." ORDER BY cnttel_fi DESC";
			$Ls = $__cnx->_qry($Ls_Qry);

			$row_Ls = $Ls->fetch_assoc();
			$Tot_Ls = $Ls->num_rows;

			if($_p['ct'] != 'no'){ $LsBld .= HTML_OpVl(['ct'=>'off']); }


				do {
					if (!(strcmp($row_Ls['cnttel_tel'], $_p['va']))){$_slc = 'ok';}else{$_slc = 'no';}

					//Valida si trae indicativo
					if($_p["ps"] == "no"){
						$_v_tel = $row_Ls['cnttel_tel'];
					}else{
						$_v_tel = $row_Ls['sisps_tel'].$row_Ls['cnttel_tel'];
					}

					$LsBld .= HTML_OpVl(['t'=>$row_Ls['cnttel_tel'], 'rel'=>$row_Ls['cnttel_enc'], 'v'=>$_v_tel, 's'=>$_slc,  'attr'=>['ps'=>$row_Ls['id_sisps']] ]);
				} while ($row_Ls = $Ls->fetch_assoc());

				if($Tot_Ls > 0) { $Ls->data_seek(0); $row_Ls = $Ls->fetch_assoc(); }
				if($__mlt == 'ok'){ $_cls = DV_CLSS_SLCT_MLT; }else{  $_cls = DV_CLSS_SLCT_BX;}
				if($_p['ph'] != 'no'){ $__ph = FM_LS_SLTEL; }
				$_rtrn2 = bdiv(['c'=>HTML_Slct(['id'=>$_p['id'], 'ph'=>$__ph, 'rq'=>$_p['rq'], 'c'=>$LsBld, 'm'=>$__mlt]), 'cls'=>$_cls]);

			$__cnx->_clsr($Ls);

			return($_rtrn2);
		}
	}

	function Hdr_PDF($__fle, $__nm=NULL) {

		$__fle_hdr = __Cche_Hdr();
		$__fle_mtm = filemtime($__fle);
		$__fle_ext = pathinfo($__fle, PATHINFO_EXTENSION);

		if($__nm != NULL){$___nm=$__nm.'.'.$__fle_ext;}else{$___nm=$__fle;}

		if (isset($__fle_hdr['If-Modified-Since']) && (strtotime($__fle_hdr['If-Modified-Since']) == $__fle_mtm)) {
			header('Last-Modified: '.gmdate('D, d M Y H:i:s', $__fle_mtm).' GMT', true, 304);
		}else {
			$__fp = fopen($__fle, 'rb');
			header('Content-Description: File Transfer');
			header('Content-Disposition:attachment;filename="'.$___nm.'"');
			header('Content-transfer-encoding: binary');
			header('Content-length: '.filesize($__fle));
		}
	}

	//Valida que el celular o telefono sean correctos


	function _Gt_Srv_Ref(){
		$Vl['srv'] = $_SESSION["_srv_ref"];
		$Vl['pag'] = $_SESSION["_pag_ref"];
		return(_jEnc($Vl));
	}

	function _gtCal($p=NULL){
			if($p['t']=='inf'){
					$__r = 100 / $p['c'] - 1;
			}
			return($__r);
	}

	//	Genera los estilos en línea.
	function Html_Sty($p=NULL){		//	( Linea para estilizar )
		$__r = ' col_x_'.$p['w'].'';
		return($__r);
	}

	//	Genera el botón de informes.
	function _Inf_Btn($p=NULL){
		if($p['xls'] != 'no'){ $__h_xls = '<div class="grd_excel rd _anm"><input name="__inf_xls" type="button" class="e _anm" id="__inf_xls" value=""></div>'; }
		$__html = '
			<div class="col_btn">
					<div class="grd_cl rd _anm"><input name="__inf_ld" type="button" class="s _anm" id="__inf_ld" value=""></div>
					'.$__h_xls.'
					<div class="grd_black rd _anm"><input name="__inf_prnt" type="button" class="p _anm" id="__inf_prnt" value=""></div>
			</div>'; return($__html);
	}


	function __AutoRUN($_p=NULL){


		if(!isWrkr() || $_p['twrk'] == 'njs'){

			//---------- FIX TO SEND WITH AWS SQS ----------//

			if(!isN($_p['t'])){ $__tp_go = '_t='.$_p['t']; }
			if(!isN($_p['t2'])){ $__tp_go .= '&_t2='.$_p['t2']; }
			if($_p['t'] != 'sis_cns' && $_p['__e'] != 'no'){ $__tp_ses = '&'.TXGN_E.encAd(SIS_ENCI); }

			if(!isN($_p['lmt'])){ $__mre .= '&_lmt='.$_p['lmt']; }
			if(!isN($_p['id'])){ $__mre .= ADM_LNK_SB.$_p['id']; }
			if(!isN($_p['s'])){ $__mre .= '&_s='.$_p['s']; }
			if(!isN($_p['s2'])){ $__mre .= '&_s2='.$_p['s2']; }
			if(!isN($_p['s3'])){ $__mre .= '&_s3='.$_p['s3']; }

			if(!isN($_p['bd'])){ $__mre .= '&_bd='.$_p['bd']; }
			if(!isN($_p['cnv'])){ $__mre .= '&_cnv='.$_p['cnv']; }
			if(!isN($_p['__i'])){ $__mre .= '&__i='.$_p['__i']; }
			if(!isN($_p['_fst'])){ $__mre .= '&_fst='.$_p['_fst']; }
			if(!isN($_p['cmpg_snd'])){ $__mre .= '&cmpg_snd='.$_p['cmpg_snd']; }

			if(!isN($_p['tmout'])){ $__tmeout = $_p['tmout']; }else{ $__tmeout = 30; }

			if($_p['cl']=='ok'){ $__cl = DB_CL_FLD.'/'; }

			if(defined('SISUS_ENC') && SISUS_ENC != ''){ $__mre .= '&__us='.SISUS_ENC; }
			if($_p['exec'] != 'no'){ $__mre .= '&_exec=ok'; } // Temporal whitle fix for AWS
			if($_p['rndm'] != 'no'){ $__mre .= '&_Rnd='.Gn_Rnd(20); }

			$_datap = $__tp_go.$__tp_ses.$__mre;

			if(!isN($_datap)){
				$_datap_a = explode('&', $_datap);
				if(!isN($_datap_a)){

					foreach($_datap_a as $_datap_a_k => $_datap_a_v){
						$_vle = explode('=', $_datap_a_v);
						if(!isN($_vle[0])){
							$_datap_snd[ $_vle[0] ] = $_vle[1];
						}
					}

					if($_p['ssh'] != 'no'){
						$_datap_snd['ssh'] = 'on';
					}

				}
			}

			if(!isN( $_p['msg'] )){
				foreach($_p['msg'] as $_msg_k=>$_msg_v){
					$_datap_snd[$_msg_k] = $_msg_v;
				}
			}

			//Temporal
			if(/*(SUMR_ENV == 'prd' || SUMR_ENV == 'dev') && */(
				$_p['t'] != 'ec_cmz' && $_p['t'] != 'dwn' && $_p['t'] != 'up'
			)){

				//---- Conexion a Plataforma ----/

				try{

					$CurlRQ = new CRM_Out();

					if($_p['twrk'] == 'njs'){ // Node Js Machine

						$ch_u = PRV_DMN_NDJS;
						$CurlRQ->o_post = true;
						$CurlRQ->o_post_f = json_encode($_datap_snd);
						$CurlRQ->o_crqst = 'POST';
						$CurlRQ->o_tmout = 10;
						$CurlRQ->o_ctmout = 10;
						$CurlRQ->o_header_http = array(
							'Content-Type: application/json'
						);

					}else{

						$ch_u = PRV_DMN_BCK/*.'?'.$__tp_go.$__tp_ses.$__mre.'&_Rnd='.Gn_Rnd(20)*/;
						$CurlRQ->o_nobdy = 'ok';
						$CurlRQ->o_rtrn=false;
						$CurlRQ->nobck = 'ok';
						$CurlRQ->o_vrbs = 0;
						$CurlRQ->o_tmout = 10;
						$CurlRQ->o_ctmout = 10;

					}

					$rtrn['url'] = $ch_u;
					$rtrn['tmchn'] = 'aws';

					$CurlRQ->url = $ch_u;

					$rsp = $CurlRQ->_Rq($_p);

					$rtrn = _jEnc($rsp);

					return($rtrn);

				}catch(Exception $e){

					$rtrn['w'] = $e->getMessage();

				}

				return($rtrn);

			}else{

				if($_p['t'] == 'ec_cmz' || $_p['t'] == 'dwn' || $_p['t'] == 'up'){

					//---- Conexion a Plataforma ----/


					$ch_u = PRV_DMN_BCK.'/'.$__cl;

					$__mre .= '&cfrmt=json';

					$CurlRQ = new CRM_Out();
					$CurlRQ->url = $ch_u;

					if($_p['o_rtrn']=='no'){ $CurlRQ->o_rtrn=false; $CurlRQ->o_vrbs = 0; $CurlRQ->o_nobdy='ok'; }

					$CurlRQ->o_tmout = $__tmeout;
					$CurlRQ->o_ctmout = $__tmeout;
					$CurlRQ->o_vrbs = 0;
					//$CurlRQ->o_rtrn=true;
					//$CurlRQ->o_nobdy='ok';
					//$CurlRQ->o_tmout = 1;
					//$CurlRQ->nobck = 'ok';

					/*
					if($_p['o_rtrn']!='no'){
						$CurlRQ->out = 'json';
					}else{
						$CurlRQ->nobck = 'ok';
					}
					*/

					if(!isN($_datap_snd)){
						$CurlRQ->o_post_f = $_datap_snd;
					}

					$try=0;

					while($try<5){

						$rsp = $CurlRQ->_Rq();
						$__rjson = json_decode($rsp->rsl, true);

						if(!isN($__rjson) && !isN($__rjson['e']) && $__rjson['e'] == 'ok'){
							break;
						}

						$try++;
					}


					if($_p['o_rtrn']=='no'){ $data = $rsp->rsl;	}

					$_r['url'] = $ch_u;
					$_r['post'] = $_datap_snd;
					$_r['rsp'] = json_decode($rsp->rsl, true);

					$rtrn = _jEnc($_r);
					return($rtrn);

				}

			}


		}

	}


	//	Genera código JQuery para filtrar listados.
	function _JS_q($p=NULL){	//	( datos del filtro )
		$_f = explode(',',	str_replace(' ','',$p['f']));
		$_c = explode(',',	str_replace(' ','',$p['c']));
		$_f_t = count($_f);
		$_c_t = count($_c);

				for ($i = 0; $i <= $_f_t; $i++) {
					if(($_f[$i]!='')&&(strlen($_f[$i]) > 1)){
						$_var .= "var _".$_f[$i]." = $('#fl_".$_f[$i]."').val();";
						if($i>0){ $_q .= "+"; }
						$_q .= "'&_".$_f[$i]."='+_".$_f[$i];
					}
				}

				for ($i = 0; $i <= $_c_t; $i++) {
					if(($_c[$i]!='')&&(strlen($_c[$i]) > 2)){
						$_var .= "var _".$_c[$i]." = $('#fl_".$_c[$i].":checked').val();";
						if($i>0 || ($_q != NULL && $_q != '')){ $_q .= "+"; }
						$_q .= "'&_".$_c[$i]."='+_".$_c[$i];
					}
				}

				if(Php_Ls_Cln($_GET['__i']) != ''){
					if($_flds != ''){ $Vl['js_wb'] = " $_flds; "; }
					if($_fle != ''){ $Vl['js_wb'] .= " _ldCnt({ u:$_fle, c:'".$__id."' }); "; }
				}


		$Vl['js'] = $_var.' var _q = '.$_q.'; ';

		return(_jEnc($Vl));
	}


	function ClrBxLgout(){
		$_cls_opt = 'true';
		if(!ChckSESS_superadm()){ $_cls_opt = 'false'; }
		return('SUMR_Main.gt_out({ shcls:'.$_cls_opt.' });');
	}

	function ClrBxLgAgn(){
		$_cls_opt = 'true';
		if(!ChckSESS_superadm()){ $_cls_opt = 'false'; }

		return('SUMR_Main.gt_agn({ shcls:'.$_cls_opt.' });');
		//return('SUMR_Main.gt_out({ shcls:'.$_cls_opt.' });');
	}



	function SESS_again(){

		echo '	<script type="text/javascript">

					$(document).ready(function(){

						if(!isN( SUMR_Main.ws.ses )){
							SUMR_Main.ws.ses = null;
						}

						if(!isN( SUMR_Main.ws.cnx ) && SUMR_Main.is_f("SUMR_Ws.f._sckCls")){
							SUMR_Ws.f._sckCls({ ses_rst:"ok" }); /* Close all conecctions and refresh */
						}

						'.ClrBxLgout().'
					})

				</script>';

		header("HTTP/1.1 401 Unauthorized");
		//exit;

	}


	// Genera el Cargador de Contenidos
	function CntJQ($grp, $_noJQ=NULL, $_Ld=false){

		$Vr = explode(';',$grp);
		$Vr_Tot = count($Vr);

		for ($i = 0; $i <= $Vr_Tot; $i++) {
			if(($Vr[$i]!='')&&(strlen($Vr[$i]) > 2)){
				$Var .= $Vr[$i].';'."\n\r";
			}
		}

		if(!isN($Var)){

			$Fnsh = '<script type="text/javascript">';
			$Fnsh .= 'try{';

			if($_noJQ != 'ok'){
				if($_Ld){
					$Fnsh .= '$(document).on("load", function(){';
				}else{
					$Fnsh .= '$(document).ready(function(){';
				}
			}

			$Fnsh .= ''."\n\r".$Var.'';

			if($_noJQ != 'ok'){ $Fnsh .= '});'; }

			$Fnsh .= '}catch(e){ console.warn(e); console.warn("CntJQ Error:"+e.message+" line "+e); }';

			$Fnsh .= '</script>';

		}else{

			$Fnsh = '';

		}

		return($Fnsh);
	}


	function h1($_cnt, $_cls='', $_sty=''){ if($_cnt!=''){ if($_cls!=''){ $__cls = 'class="'.$_cls.'"'; } if($_sty!=''){ $__sty = 'style="'.$_sty.'"'; } return '<h1 '.$__sty.' '.$__cls.'>'.$_cnt.'</h1>'; }}
	function h2($_cnt, $_cls='', $_sty=''){ if($_cnt!=''){ if($_cls!=''){ $__cls = 'class="'.$_cls.'"'; } if($_sty!=''){ $__sty = 'style="'.$_sty.'"'; } return '<h2 '.$__sty.' '.$__cls.'>'.$_cnt.'</h2>'; }}
	function h3($_cnt, $_cls='', $_sty=''){ if($_cnt!=''){ if($_cls!=''){ $__cls = 'class="'.$_cls.'"'; } if($_sty!=''){ $__sty = 'style="'.$_sty.'"'; } return '<h3 '.$__sty.' '.$__cls.'>'.$_cnt.'</h3>'; }}
	function h4($_cnt, $_cls='', $_sty=''){ if($_cnt!=''){ if($_cls!=''){ $__cls = 'class="'.$_cls.'"'; } if($_sty!=''){ $__sty = 'style="'.$_sty.'"'; } return '<h4 '.$__sty.' '.$__cls.'>'.$_cnt.'</h4>'; }}
	function ul($_cnt, $_cls='', $_sty='', $_id=''){ if($_cls!=''){ $__cls = 'class="'.$_cls.'"'; } if($_sty!=''){ $__sty = 'style="'.$_sty.'"'; } if($_id!=''){ $__id = 'id="'.$_id.'"'; }  return('<ul '.$__id.$__cls.' '.$__sty.'>'.$_cnt.'</ul>');}

	function li($_cnt, $_cls='', $_sty='', $_id='', $_p=NULL){
		if($_cls!=''){ $__cls = 'class="'.$_cls.'"'; }
		if($_sty!=''){ $__sty = 'style="'.$_sty.'"'; }

		if(!isN($_p['rel'])){ $__rel = 'rel="'.$_p['rel'].'"'; }
		if(!isN($_p['tt'])){ $__tt = 'title="'.$_p['tt'].'"'; }
		if(!isN($_p['attr'])){
			foreach($_p['attr'] as $_attr_k=>$_attr_v){
				$__atttr .= ' '.$_attr_k.'="'.$_attr_v.'" ';
			}
		}

		if($_id!=''){ $__id = 'id="'.$_id.'"'; }

		return('<li '.$__id.$__cls.' '.$__sty.$__rel.$__tt.$__atttr.'>'.$_cnt.'</li>');
	}

	function fgr($_cnt, $_cls='', $_sty=''){ if($_cls!=''){ $__cls = 'class="'.$_cls.'"'; } if($_sty!=''){ $__sty = 'style="'.$_sty.'"'; } return('<figure '.$__cls.' '.$__sty.'>'.$_cnt.'</figure>');}

	// Construccion de Div
	function bdiv($p=NULL){
		if($p['id']!=NULL){ $_id = ' id="'.$p['id'].'" ';}
		if($p['sty']!=NULL){ $_sty = ' style="'.$p['sty'].'" ';}
		if($p['cls']!=NULL){ $_cls = ' class="'.$p['cls'].'" ';}
		if($p['tt']!=NULL){ $_tt = ' title="'.$p['tt'].'" alt="'.$p['tt'].'" ';}
		$_c = '<div'.$_id.$_sty.$_cls.$_tt.' >'.$p['c'].'</div>';
		return($_c);
	}

	function _Df_Dte($fend=NULL, $fsta=NULL){

		if(!isN($fend) && !isN($fsta)){

			$datetime1 = new DateTime($fend);
			$datetime2 = new DateTime($fsta);
			$interval = date_diff($datetime1, $datetime2);

				$_V['Y'] = $interval->format('%Y'); // Years
				$_V['m'] = $interval->format('%m'); // Months
				$_V['w'] = floor($datetime1->diff($datetime2)->days/7); // Weeks
				$_V['d'] = $interval->format('%d'); // Days
				$_V['H'] = $interval->format('%H'); // Hours
				$_V['i'] = $interval->format('%i'); // Minutes
				$_V['I'] = $interval->format('%I');
				$_V['s'] = $interval->format('%s');
				$_V['n'] = $interval->format('%r');

				if($interval->format("%r") == '-'){ $_V['ngtv'] = true; }else{ $_V['ngtv'] = false; }

			$__r = json_encode($_V);
			$r = json_decode($__r);

		}

		return($r);
	}


	function _Df_Dte_Wk($fend=NULL, $fsta=NULL, $p=NULL){

		if($fsta != NULL){
			$datetime1 = new DateTime ($fend);
			$datetime2 = new DateTime ($fsta);
			$interval = date_diff($datetime1, $datetime2);


				//---------------------------- Calcula Dias Sin Fin de Semana ----------------------------//

					$days = $interval->d;
					$period = new DatePeriod($datetime1, new DateInterval('P1D'), $datetime2);

					foreach($period as $dt) {
					    $curr = $dt->format('D');
					    if ($curr == 'Sat' || $curr == 'Sun') { $days--; }
					}

				//---------------------------- Calcula Dias Sin Fin de Semana ----------------------------//

				if(is_array($p) && $p['wkn'] == 'no'){ $__days = $days; }else{ $__days = $interval->d; }

				if(is_array($p) && $p['_fr'] == 'b'){


					if ($interval->m > 0) {
						if($interval->m > 1){ $__mth_s = ''; }
						$_dif_m = Spn($interval->m.' '.TX_MONTHS.$__mth_s, '', '_prm_m').HTML_BR;
					}

					if ($__days > 0) {
						if($__days > 1){ $__day_s = 's'; }
						$_dif_d = $_dif_m.Spn($__days.' '.TX_DAYS.$__day_s, '', '_d').HTML_BR;
					}
					$_dif_hm = $interval->format('%H').'(h) :'.$interval->format('%I').'(m)';
					$_V['_r'] = Spn($_dif_d.$_dif_hm, '', '_gstlst', '', '', $datetime2->format('Y-m-d').' / '.$datetime2->format('H:i:s'));


				}elseif(is_array($p) && $p['_fr'] == 'c'){

					if ($interval->m > 0) { if($interval->m > 1){ $__mth_s = ''; } $_dif_m = Spn($interval->m.' '.TX_MONTHS.$__mth_s, '', '_prm_m').HTML_BR; }
					if ($__days > 0) { if($__days > 1){ $__day_s = 's'; } $_dif_d = Spn($__days.' '.TX_DAYS.$__day_s, '', '_prm_d').HTML_BR; }
					if ($interval->m == 0){ $_dif_hm = Spn($interval->format('%H').'(h):'.$interval->format('%I').'(m)', '', '_prm_hr'); }
					if ($__days > 7 && $p['e'] == 4){ $_cls_wrn = '__w'; }
					$_V['_r'] = "<div class=\"_prm_bx ".$_cls_wrn."\">".$_dif_m.$_dif_d.$_dif_hm."</div>";
					$_V['_ds'] = $__days;
					$_V['_hrs'] = $interval->format('%H');
					$_V['_mnt'] = $interval->format('%I');

				}/*elseif(is_array($_V) && $_V != NULL && $_V != '' && !empty($_V)){

					$_V['Y'] = $interval->format('%Y');
					$_V['m'] = $interval->format('%m');
					$_V['d'] = $interval->format('%d');
					$_V['H'] = $interval->format('%H');
					$_V['i'] = $interval->format('%i');
					$_V['I'] = $interval->format('%I');
					$_V['s'] = $interval->format('%s');
					$_V['n'] = $interval->format('%r');
					if($interval->format("%r") == '-'){ $_V['ngtv'] = true; }else{ $_V['ngtv'] = false; }
				}	*/

			$__r = json_decode(json_encode($_V));
			return($__r);
		}
	}

	function _SbLs_Vst($p=NULL){
		$__i = Php_Ls_Cln($_GET['__vst']);
		if($__i!='' && $__i!=NULL){
			if($p == 'i'){  return($__i); }else{ return('&__vst='.$__i); }
		}else{
			return false;
		}
	}

	// Conversion Moneda //
	function cnVlrMon($lg=NULL, $valor=NULL){
		if($valor != NULL){
			if ($lg == "en"){
				$valRet = "US ".number_format($valor,2,',','.');
			}else if($lg == "non"){
				$valRet = number_format($valor,2,',','.');
			}else if($lg == "non_non"){
				$valRet = number_format($valor,0,',','.');
			}else{
				$valRet = "$".number_format($valor,0,',','.');
			}
			return $valRet;
		}
	}

	function Cod_Btw($p=NULL){

	    if($p['tag']){

		    $start = '{'.$p['tag'].'}';
		    $finish = '{/'.$p['tag'].'}';

		    $string = " ".$p['cod'];
		    $position = strpos($string, $start);
		    if ($position == 0) return "";
		    $position += strlen($start);
		    $length = strpos($string, $finish, $position) - $position;

		    $Vl['nw'] = substr($string, $position, $length);
		    $Vl['sch'] = $start.substr($string, $position, $length).$finish;

	    }

	    $rtrn = json_decode(json_encode($Vl));
		return($rtrn);
	}

	function __t($_v, $_q=false){
		if($_q){$_r = '?';}
		$_r .= '_t='.$_v;
		return($_r);
	}

	function __t2($_v, $_q=true){
		if($_q){$_r = '&';}
		$_r .= '_t2='.$_v;
		return($_r);
	}

	function __t3($_v, $_q=true){
		if($_q){$_r = '&';}
		$_r .= '_t3='.$_v;
		return($_r);
	}

	function __t4($_v, $_q=true){
		if($_q){$_r = '&';}
		$_r .= '_t4='.$_v;
		return($_r);
	}

	function __tsis($_v, $_q=true){
		if($_q){$_r = '&';}
		$_r .= '_tsis='.$_v;
		return($_r);
	}

	//Script MYJS
	function PgRg($Fl, $Vr='', $Tp='', $Pop='', $PopCls='', $p=NULL){
		if(($Fl != '')){
				if($PopCls=='ok'){ $_clsclr = JS_SCR_POPCLS; }
				if($Pop=='ok'){ $_clsp = TXGN_POP; }
				if(!isN($p['w'])){ $__w = $p['w']; }else{ $__w = '900'; }
				if(!isN($p['h'])){ $__h = $p['h']; }else{ $__h = '600'; }
				if(!isN($p['scrl'])){ $__scrl = $p['scrl']; }else{ $__scrl = $p['scrl']; }
				if(!isN($p['cl'])){ $__cl = ', _cl:'.$p['cl']; }
				if(!isN($p['cm'])){ $__cl = ', _cm:'.$p['cm']; }

				$_r = "_ldCnt({ u:'".$Fl."?".$Vr."&".$_clsp."&__rnd='+Math.random(), pop:'".$Pop."', w:'".$__w."', h:'".$__h."', scrl:'".$__scrl."' ".$__cl." });";
				$_r .= $_clsclr;

		}
		return($_r);
	}

	// Funcion para limpiar los permalinks
	function PmLn_Cl($tx){
		$Tx_Fn = MyMn(trim($tx));
		$Tx_Fn = preg_replace('/[^a-zA-Z\_\-\.0-9]/', '', $Tx_Fn);
		return($Tx_Fn);
	}

	function Sch_Cd($Cmp='',$Vl='',$t='',$p=NULL){
		if (($Cmp !='')&&($Vl != ''))  {
			if($t==2){$_u = ' AND ';}else{$_u = ' WHERE ';}
			$schGt = strtolower(MyMn(ctjTx($Vl,'in')));
			$schBsc = explode("*.",$schGt);
			$schBsc_2 = implode("%", $schBsc);
			$schBsc_sh = implode(" ", $schBsc);
			$Flds = explode(',',$Cmp);
			$Flds_Tot = count($Flds);
			for ($i = 0; $i <= $Flds_Tot; $i++) {
				$Nm = $i+1;
				if($Flds[$i] != ''){
						$Flds_Cd .= "(lower(".$Flds[$i].") LIKE '%".$schBsc_2."%')";
						$Cnct_Cd .= "lower(".$Flds[$i].")";
					if($Nm < $Flds_Tot){
						$Flds_Cd .=	" || ";
						$Cnct_Cd .=	",' ',";
					}
				}
			}
			$f_cnct = "(CONCAT(".$Cnct_Cd."))";
			$f_busq = $_u." (".$Flds_Cd." || (".$f_cnct." LIKE '%".$schBsc_2."%') ".$p['_mre'].")";
			return($f_busq);
		}
	}

	// Genera Query para Link
	function QuPgsi($TotRw='', $TotRwDB, $MxRws, $QStr){
	if($TotRwDB != ''){

		if (isset($TotRw)){
			$totRws = $TotRw;
		}else{
			$totRws = $TotRwDB;
		}
			$totPgs = ceil($totRws/$MxRws)-1;
			$qryStr = "";
			if (!empty($QStr)) {
			$params = explode("&", $QStr);
			$newParams = []; foreach ($params as $param) {
			if (stristr($param, "pgN") == false && stristr($param, "totRws") == false) {array_push($newParams, $param);}}
			if (count($newParams) != 0){$qryStr = "&" . htmlentities(implode("&", $newParams)); }}
			$qryStr = sprintf("&totRws=%d%s", $totRws, $qryStr);
			define('TT_RWS', $totRws);
			define('LS_QR', $qryStr);
			define('TT_PGS',$totPgs);
			return(true);
		}
	}


	function _ChckCntTp($_p=NULL){

		global $__cnx;

		if($_p['id']){
			$query_DtRg = sprintf('SELECT * FROM '.$_p['bd'].TB_CNT_TP.' WHERE cnttp_cnt = %s AND cnttp_tp = %s', GtSQLVlStr($_p['cnt'],'int'), GtSQLVlStr($_p['tp'],'int'));
			$DtRg = $__cnx->_qry($query_DtRg);
			if($DtRg){
				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;
				if($Tot_DtRg == 1){ $_v['id'] = $row_DtRg['id_cnttp']; $_v['e']='ok'; $_v['cnt'] = GtCntDt($row_DtRg['cnttp_cnt']); }else{  $_v['e']='no'; }
			}

			$__cnx->_clsr($DtRg);

		}

		$_r = json_decode(json_encode($_v));
		return $_r;
	}

	function _ChckCntTpMdl($_p=NULL){

		global $__cnx;

		if($_p['id']){
			$query_DtRg = sprintf('SELECT * FROM '.$_p['bd'].TB_CNT_TP.' WHERE cnttp_cnt = %s AND cnttp_tp = %s AND cnttp_mdl = (SELECT id_mdl FROM '.TB_MDL.' WHERE mdl_enc = %s)', GtSQLVlStr($_p['cnt'],'int'), GtSQLVlStr($_p['id'],'int'), GtSQLVlStr($_p['mdl'],'text'));
			$DtRg = $__cnx->_qry($query_DtRg);

			if($DtRg){
				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;
				if($Tot_DtRg == 1){ $_v['id'] = $row_DtRg['id_cnttp']; $_v['e']='ok'; $_v['cnt'] = GtCntDt($row_DtRg['cnttp_cnt']); }else{  $_v['e']='no'; }

			}

			$__cnx->_clsr($DtRg);

		}

		$_r = json_decode(json_encode($_v));
		return $_r;
	}

	function _DivLogoTM($p=NULL){

		if($p['mny']){ $_cls_mny = '_mny'; }
		if(!isN($p['cls'])){ $_cls_mny .= ' '.$p['cls']; }

		$_r = bdiv(['cls'=>'bnr__logo _anm '.$_cls_mny, 'c'=>'<div class="_clr" style="background-color:'.$p['c'].'"></div><div class="_im _anm" style="background-image:url('.$p['i'].');"></div>' ]);
		return $_r;

	}

	// Formato a Numero
	function NmFmNw($NmFm,$NmTp){
		if (($NmFm != "")&&($NmTp == "t1")) {
			$CompFu = number_format($NmFm, 2, ',', '')."%";
		}else if (($NmFm != "")&&($NmTp == "t2")) {
			$CompFu = number_format($NmFm, 1, ',', '');
		}else if (($NmFm != "")&&($NmTp == "t3")) {
			$CompFu = number_format($NmFm, 0, ',', '.');
		}else if (($NmFm != "")&&($NmTp == "t4")) {
			$CompFu = number_format($NmFm, 4, '', ',');
		}else if (($NmFm != "")&&($NmTp == "t5")) {
			$CompFu = number_format($NmFm, 2, '.', '');
		}else if (($NmFm != "")&&($NmTp == "t6")) {
			$CompFu = number_format($NmFm, 0, '.', '');
		}elseif(($NmFm != "")&&($NmTp == "t7")) {
			$CompFu = number_format($NmFm, 0, ',', '.')."%";
		}else{$CompFu = $NmFm;}
		return $CompFu;
	}

	// Recopila Datos para Paginar
	function RcPg($NmPg='',$Quer,$TotPgs='',$Ls='',$p=NULL){
		if(($Quer!='')){
			$var1 = 0;
					$MdPgs = SIS_NMPG / 2;
					$MxPgs = $NmPg + $MdPgs;
					$MzPgs = $MxPgs - $MdPgs;
					$a_Pg = $NmPg - $MdPgs;
					$b_Pg = $TotPgs+1;
			do {
				if($var1 == $NmPg){
					$StyDt = "Sl";
				}else{
					$StyDt = "";
				}

					$Sch = ['&Pr=Ls'];
					$Chn = [''];
					$NwTxPgd = str_replace($Sch,$Chn,$Quer);


					if(($var1 == $a_Pg)){

						$lnkDt = JQ__ldCnt([ 'u'=>$Ls.'?'.TXGN_LS.'&pgN='.($var1).$NwTxPgd, 'c'=>$p['r'] ]);

						//$lnkDt = $Ls.'javascript:'.PgRg($Ls,TXGN_LS.'&pgN='.($var1).$NwTxPgd,1);
						$data[] = "<a class=\"".$StyDt."\" href=\"".$lnkDt."\">".($var1+1)."</a>";
					}else if(($var1 > $a_Pg)&&($var1 < $b_Pg)){

						$lnkDt = JQ__ldCnt([ 'u'=>$Ls.'?'.TXGN_LS.'&pgN='.($var1).$NwTxPgd, 'c'=>$p['r'] ]);
						//$lnkDt = $Ls.'javascript:'.PgRg($Ls,TXGN_LS.'&pgN='.($var1).$NwTxPgd,1);

						$data[] = "<a class=\"".$StyDt."\" href=\"".$lnkDt."\">".($var1+1)."</a>";
					}

					$var1 ++;

			} while ($var1 <= $MxPgs);
		}
		return($data);
	}

	function __Cche_Img_Hdr() {
    	if (function_exists("apache_request_headers")){
			if($headers = apache_request_headers()) { return $headers; }
		}
		$headers = array();
		if (isset($_SERVER['HTTP_IF_MODIFIED_SINCE'])){ $headers['If-Modified-Since'] = $_SERVER['HTTP_IF_MODIFIED_SINCE']; }
		return $headers;
	}


	function __Cche_Img($graphicFileName, $fileType='jpeg') {
		$__xpl = explode('?',$graphicFileName);
		$graphicFileName = $__xpl[0];
		$fileModTime = filemtime($graphicFileName);
		$headers = __Cche_Img_Hdr();

		if (isset($headers['If-Modified-Since']) && (strtotime($headers['If-Modified-Since']) == $fileModTime)) {
			header('Last-Modified: '.gmdate('D, d M Y H:i:s', $fileModTime).' GMT', true, 304);
		}else {
			$__fp = fopen($graphicFileName, 'rb');
			header('Last-Modified: '.gmdate('D, d M Y H:i:s', $fileModTime).' GMT', true, 200);
			header('Content-type: image/'.$fileType);
			header('Content-transfer-encoding: binary');
			header('Content-length: '.filesize($graphicFileName));
			fpassthru($__fp);
		}
	}

	// Formulario Busqueda Lista
	/*function Inp_Sch($V,$N=''){
		if($V !=''){$V_v = $V; }else{$V_v = TX_SCH;}
		$chg = str_replace('*.', ' ', $V_v); if($V !=''){ $_vl = $chg; }
		$_rtrn = "<div><form id='Sch_".$N."' name='Sch_".$N."' method='post' action='javascript:Sch_Ls();'><input placeholder='".$chg."' type='text'  name='".$N."' id='".$N."' class='required _sch' value='".$_vl."' /></form></div>";
		$_rtrn .= "<script type='text/javascript'> $('#Sch_".$N."').validate(); </script>";
		return($_rtrn);
	}*/

	function Inp_Sch($p=NULL){ //$V,$N='',$prfx=NULL

		if(!isN($p['v'])){ $V_v=$p['v']; }else{ $V_v = TX_SCH; }

		$chg = str_replace('*.', ' ', $V_v); if($V !=''){ $_vl = $chg; }

		$_html = "<div><form id='Sch_".$p['n'].$p['prfx']."' name='Sch_".$p['n'].$p['prfx']."' method='post' action='javascript:Sch_Ls".$p['prfx']."();'><input placeholder='".$chg."' type='text' "/*value='".$chg."'*/." name='".$p['n'].$p['prfx']."' id='".$p['n'].$p['prfx']."' class='required _sch' value='".$_vl."' /></form></div>";

		$_js .= "
					$('#Sch_".$p['n'].$p['prfx']."').validate();

					$('#Sch_".$p['n'].$p['prfx']."').bind('keypress', function(e) {
						if(e.keyCode==13){
							Sch_Ls".$p['prfx']."();
						}
					});
				";

		if($p['a']=='ok'){
			$_r['html'] = $_html;
			$_r['js'] = $_js;
			$_rtrn = _jEnc($_r);
		}else{
			$_rtrn = $_html."<script type='text/javascript'>".$_js."</script>";
		}

		return($_rtrn);
	}

	function SchLs($p=NULL){
		//$Cnt, $Inp, $Fl='no', $VlGt=NULL, $Ld='', $MrVr=''

		if($p['ld']){$_ldwb = $p['ld'];}else{$_ldwb = ICN_LDR_SIS;}
		if($p['__i'] != '' && $p['__i'] != NULL){ $__i = ADM_LNK_SB.$p['__i']; }
		if($p['mre']){$_mrvr = $p['mre'].'&';}
		if($p['fl'] == 'ok'){$SrchGrp = "&_g='+Us_Grp.value+'&_ng='+No_Grp.checked+'";}
		$Rtrn_vl = "<script type='text/javascript'>

			function Sch_Ls".$p['prfx']."(){
					var _valinp = $('#".$p['inp'].$p['prfx']."').val();
					if((_valinp != '') && (_valinp != null) && (_valinp != 'undefined')){
						_ldCnt({ u:'".$p['l']."?".$_mrvr.ADM_LNK_SCH."'+ _valinp +'".$SrchGrp.$__i."&__rnd=".Gn_Rnd(3)."', c:'".$p['bxr']."' });
					}
			}
			function Sch_Cl".$p['prfx']."(){ _ldCnt({ u:'".$p['l']."?".$_mrvr."Rnd=".Gn_Rnd(3)."&___fl_c=ok', c:'".$p['bxr']."' }); }

			$('#".BTN_SCHCLN.$p['prfx']."').click(function() { Sch_Cl".$p['prfx']."(); });
			$('#".BTN_SCH.$p['prfx']."').click(function() { Sch_Ls".$p['prfx']."(); });



		</script>";

			$Rtrn_vl .= '<div><input class="s grd_blue" type="button" name="'.BTN_SCH.$p['prfx'].'" id="'.BTN_SCH.$p['prfx'].'" value="'.BTN_TX_SCH.'"></div>' ;
		if($p['vl'] != NULL){
			$Rtrn_vl .= '<div><input class="c grd_gray" type="button" name="'.BTN_SCHCLN.$p['prfx'].'" id="'.BTN_SCHCLN.$p['prfx'].'" value="'.BTN_TX_SCHCLN.'"></div>';
		}
		return($Rtrn_vl);
	}

	function BtnInRg($_ii='', $_vv=''){
		if($_vv != ''){$_tt=$_vv;}else{$_tt=BTN_TX_NW;}
		if($_ii != ''){$_id=$_ii;}else{$_id=BTN_INRG;}
		return('<input class="n grd_black" type="button" name="'.$_id.'" id="'.$_id.'" value="'.$_tt.'">');
	}

	function BtnUpl($_ii=NULL){
		if($_ii != ''){$_id=$_ii;}
		return('<input class="n grd_black" type="button" name="'.$_id.'" id="'.$_id.'" value="'.TX_UPLMSV.'">');
	}

	function BtnUpdRg(){return('<img src="'.BTN_UPD.'" height="20"/>');}
	function BtnInf(){ return('<input class="n grd_cl" type="button" name="'.BTN_INF.'" id="'.BTN_INF.'" value="'.BTN_TX_XLS.'">'); }

	// Intercala Celdas
	function Itc($Nm = ''){if($Nm == 2){return 1;}else{return 2;}}

	// Efecto Intercalado de Celdas
	function cl($Lnk, $RwN, $Tp='', $Ngtv='', $Cls='', $Rtn='no'){
		if($Tp != ''){$T = $Tp;}else{$T = 1;}
		if($Lnk != '#'){ $EfLn = cmpRwLnk($Lnk); }
		if($RwN==1){
		  if($Ngtv != 1){ $_cls = CLS_RW_IM.$Cls; }else{ $_cls = CLS_RW_NGT.$Cls; }
		  $__rt = $EfLn.' class="'.$_cls.'"'; $RwN="2";
		  if($Rtn == 'ok'){ return $__rt; }else{ echo $__rt; }
		}else{
		  if($Ngtv != 1){ $_cls = CLS_RW_PR.$Cls; }else{ $_cls = CLS_RW_NGT.$Cls; }
		  $__rt = $EfLn.' class="'.$_cls.'"'; $RwN = "1";
		  if($Rtn == 'ok'){ return $__rt; }else{  echo $__rt; }
		}
	}


	// Compongo el Click de Celda
	function cmpRwLnk($NmFm){
		if ($NmFm != "") {
		$CompFu = "onclick=\"".$NmFm."\"";}
		return $CompFu;
	}
	// Pagina de Registros
	function PrG($Str='', $MxRw='', $TtRw='', $TtPg='', $Dt=''){
		if(($Str != '')&&($MxRw != '')&&($TtRw != '')&&($TtPg != '')){
				$Vlr =  '<span>'.($Str + 1).'</span> a <span>'.min($Str + $MxRw, $TtRw).'</span> de <span>'.$TtRw.'</span>';
			}
			return $Vlr;
	}
	// Muestra el Numero de Paginas de Registros
	function PgsCnt($TtPg, $Dt, $_p=NULL){
		if (($TtPg > 0)&&($Dt != '')) {
			if($_p['tt']!='no'){ $Vlr = ' Explorador de <span >'.TX_RES.' </span>'; }
			$Vlr .= implode(' | ', $Dt);
			return($Vlr);
		}
	}


	function VlFm($_p=NULL){

		//$NmFm, $Tp='',$TpM='',$Pss='',$Ls='', $Vr='', $pop='', $ldrp='', $txcnf='', $cnt_2='', $_jscd='no', $_key=NULL, $_myprfx=NULL, $_p=NULL

		$_ldrsis = ICN_LDR_SIS;
		if(ChckSESS_superadm()){ $_shwalert = 'if(d.w != \'\' && d.w != null){ swal(\'Error\', d.w, \'error\'); };'; }

		/*if($_p['fm_el'] == 'pb_prg' || $_p['fm_el'] == 'el_prg' || $_p['fm_el'] == 'cmp_gst' || $_p['fm_el'] == 'el_cmp_gst'){
			$_prfx_vld = DV_SBCNT;
		}elseif($_p['fm_prfx'] != NULL){
			$_prfx_vld = $_p['fm_prfx'];
		} Se quita para nuevo POPUP puede haber conflictos */


		if($_p['fm_prfx'] != NULL){ $_prfx_vld .= $_p['fm_prfx']; }
		if($_p['fm_pop'] == 'ok' || $_p['fm_sbl'] == 'ok'){ $_prfx_vld .= DV_SBCNT; }


		if($_p['fm'] != ''){

			//if($_p['fm_el'] == 'pb_prg' || $_p['fm_el'] == 'el_prg' || ($_p['fm_el'] == 'cmp_gst') || $_p['fm_el'] == 'el_cmp_gst'){ $_cn2 = DV_SBCNT; }

			$_dvld = DV_GNR_FM.$_prfx_vld;

			if($_p['fm_el'] == 'ok' /*|| $_p['fm_el'] == 'el_prg'*/){

				if($_p['fm_pop'] != 'ok'){
					$Vl_Rfrsh .= '$(\'#'.ID_BTNRFR.$_p['fm_tp'].$_prfx_vld.'\').click(function(){

										swal({
											title: "'.TX_CFRFR.'",
											showCancelButton: true,
											confirmButtonColor: "'.BTN_OK_CLR.'",
											confirmButtonText: "'.TX_DSDLG.'",
											cancelButtonText: "'.TX_NTHNKS.'",
										},
										function(c){
											if(c){ _ldCnt({ u:\''.$_SERVER['REQUEST_URI'].'&__rnd='.Gn_Rnd(3).'\', c:\''.$_p['fm_cnt2'].'\' }); }
										});
								  });';
				}


				if($_p['fm_tx_cnf']!=''){$_txcnf=$_p['fm_tx_cnf'];}else{$_txcnf=TX_CFEL;}

				$ElBt = '

					$(\'#but_eli'.$_prfx_vld.'\').click(function(){
						SUMR_Main.btn_eli_c({
							tp:\'el\',
							_c:function(){
								$(\'#'.$_p['fm'].'\').submit();
							}
						})
					});

				';


				$__prfx_jv = '_el';


			}elseif($_p['fm_pss'] == 'ok'){

				$VldSpc = '{rules: {
									us_pass:{minlength: 5},
									us_passcnf:{minlength: 5, equalTo: "#us_pass"}
							},
							messages: {
									us_pass: {required: "'.TX_PSWRPRS.'",minlength:  "'.TX_CNTCRCT.'"},
									us_passcnf: {required: "'.TX_CNFPSWR.'",minlength: "'.TX_CNTCRCT.'", equalTo: "'.TX_CLVCND.'"}
									}
							}';
			}


			if($_p['fm_el'] != 'ok' /*&& $_p['fm_el'] != 'el_prg'*/){

				$Vl_Sve = '$(\'#'.ID_BTNSVE.$_p['fm_tp'].$_prfx_vld.'\').off(\'click\').click(function(){
								SUMR_Main.btn_sve_c({
									tp:\'ed\',
									_c:function(){
										$(\'#'.$_p['fm'].'\').submit();
									}
								})
							});';

			}

			$_shwalert = "if(d.w != '' && d.w != null){ swal('Error', d.w, 'error'); };";

			$CmPss = 'validate('.$VldSpc.')';

			$___rnd = Gn_Rnd(10);


			$Vl_Rtrn .= '$("#'.$_p['fm'].'").'.$CmPss.';'.$VldLst.$ElBt.'
			function ShLod_'.$___rnd.'(){';

				if($_p['fm_pop'] == 'ok'){
					$Vl_Rtrn .=	'SUMR_Main.anm.tld(\''.ICN_LDR_POP.'\',\'in\');';
				}
				if($_p['fm_cnt2'] != ''){
					$Vl_Rtrn .=	'$(\'#'.$_p['fm'].'\').fadeOut(\'fast\');';
				}else{
					$Vl_Rtrn .=	'SUMR_Main.anm.tld(\''.$_dvld.'\',\'out\'); ';
				}

				$Vl_Rtrn .=	$_ldrsissh;



			if($_p['fm_pop'] == 'ok'){
				$Vl_Err .=	'SUMR_Main.anm.tld(\''.ICN_LDR_POP.'\',\'out\');';
			}
			if($_p['fm_cnt2'] != ''){
				$Vl_Err .=	'$(\'#'.$_p['fm'].'\').fadeIn(\'fast\');';
			}else{
				$Vl_Err .=	'SUMR_Main.anm.tld(\''.$_dvld.'\',\'in\'); ';
			}

			if(!Dvlpr()){ $_tout = 20000; }else{ $_tout = 50000; }


			$Vl_Rtrn .=	'}

			var opc'.$_p['fm'].$__prfx_jv.' = {

					dataType:\'json\',
					beforeSubmit:ShLod_'.$___rnd.',
					timeout:'.$_tout.',
					error: function(x, t, m) {
				        if(t === \'timeout\') {
				            console.info(\'Serviciosin: Excede tiempo de carga\');
				        } else {
				            console.info(\'Serviciosin: \'+t);
				        }

				        swal({
					        type: "error",
				        	title: "Uups..",
				        	text: "'.TX_SMTAGN.'",
						});


				        '.$Vl_Err.'
				    },
					success: function (d){
						'.$_shwalert.'

						if(d.cl != \'\'){ var gtLdCnt = function(){ eval(d.cl); } }

					if(d.e == \'ok\'){

						';

							if($_p['fm_cnt2'] != ''){ $__cntwb = $_p['fm_cnt2']; }else{ $__cntwb = DV_LDR_WB; }

							if($_p['fm_pop'] == 'ok'){
								$__vl_aft = 'cls';
							}

							$Vl_Rtrn .=	'StTm_Est({ e:d.m, a:\''.$__vl_aft.'\' });';

							if($_p['fm_cnt2'] != ''){
								$Vl_Rtrn .=	'
									if(d.i != \'\' && d.i != null){	var __m_i = \''.ADM_LNK_DT.'\'+ d.i; }else{ var __m_i = \'\'; }
									_ldCnt({ u:_'.$_p['fm_cnt2'].'+__m_i, c:\''.$_p['fm_cnt2'].'\', _cl:gtLdCnt });
								';
								if($_p['fm_ls'] != '' ){ $Vl_Rtrn .=	'
									_ldCnt({
										u:\''.$_p['fm_ls'].'?'.$_p['fm_vr'].'&__rnd='.Gn_Rnd(3).'\',
										pop:\'pop\',
										_cl:gtLdCnt
									}); ';
								}
							}else{
								$Vl_Rtrn .=	'

									if(d.c != \'ok\'){
										if(d.i != \'\' && d.i != null){
											_ldCnt({
												u:\''.$_p['fm_ls'].'?'.$_p['fm_vr'].ADM_LNK_DT.'\'+ d.i +\'&__rnd='.Gn_Rnd(3).'\',
												c:\''.$_cn2.'\',
												_cl:gtLdCnt
											});
										}else{
											_ldCnt({
												u:\''.$_p['fm_ls'].'?'.$_p['fm_vr'].'&__rnd='.Gn_Rnd(3).'\',
												c:\''.$_cn2.'\',
												_cl:gtLdCnt
											});
										}
									}
								';
							}

							$Vl_Rtrn .=	$_ldrsishd;

			$Vl_Rtrn .=	'}else{

							if(gtLdCnt != \'\' && gtLdCnt != \'undefined\' && gtLdCnt != null){  gtLdCnt();	}

							';

							if($_p['fm_pop'] == 'ok'){
								$Vl_Rtrn .=	'SUMR_Main.anm.tld(\''.ICN_LDR_POP.'\',\'out\'); /*$.colorbox.resize({width:'.CLRBX_WD_POP.'});*/';
							}else{
								$Vl_Rtrn .=	' if(!isN(d)){ StTm_Est({ e:d.m }); }';
							}


							if($_p['fm_cnt2'] != ''){
								$Vl_Rtrn .=	'$(\'#'.$_p['fm'].'\').fadeIn(\'fast\');';
							}else{
								$Vl_Rtrn .=	'SUMR_Main.anm.tld(\''.DV_GNR_FM.$_prfx_vld.'\',\'in\');';
							}

							$Vl_Rtrn .=	$_ldrsishd;

			$Vl_Rtrn .= "}";
			$Vl_Rtrn .= "}";
			$Vl_Rtrn .= " };  $('#".$_p['fm']."').ajaxForm(opc".$_p['fm'].$__prfx_jv.");";

			if($_p['fm_el'] != 'ok'){

				if(!ismobile()){
					$_Qtp_Ps = 'bottom left';
				}else{
					$_Qtp_Ps = 'bottom left';
				}


					/*$Vl_Rtrn .= '
									$(\'input[type="text"], textarea\').each(function(){
										 $(this).qtip({
												 content: $(this).attr(\'placeholder\'),
												 position: { at: "'.$_Qtp_Ps.'" },
												 show: {
														effect: function(offset) {
															$(this).slideDown(100);
														}
												 }
										});
									});
					';*/

			}

			if($_p['fm_jscd'] != 'ok'){
				$Vl_All = '<script type="text/javascript">$(document).ready(function(){'	. $Vl_Sve . $Vl_Rfrsh .	$Vl_Rtrn.	'});</script>';
			}else{
				$Vl_All = $Vl_Sve . $Vl_Rtrn;
			}

			return($Vl_All);
		}
	}

	// Compongo Formulario para Cambiar Clave
	function VldChnPss($__fmnm,$Ldr,$Dv){
		$___rnd = Gn_Rnd(10);

		$Vl = '$("#'.$__fmnm.'").validate({rules: {us_pass:{required: true, minlength: 5}, us_passcnf:{required: true,minlength: 5, equalTo: "#us_pass"}},messages: {us_pass: {required: "'.TX_PSWRPRS.'",minlength: "'.TX_CNTCRCT.'"},us_passcnf: {required: "'.TX_CNFPSWR.'",minlength: "'.TX_CNTCRCT.'", equalTo: "'.TX_CLVCND.'"}}});

		function ShLod'.$___rnd.'(){
			SUMR_Main.anm.tld(\''.$Dv.'\',\'out\');
			SUMR_Main.anm.tld(\''.$Ldr.'\',\'in\');
		};

		var opc_'.$___rnd.' = {
			dataType:\'json\',

			beforeSubmit:ShLod'.$___rnd.',

			success: function (d){
				if(d.w != "" && d.w != null){ alert(d.w); }
				if(d.e == \'ok\'){
					swal(\'Super\', "'.TX_KWCHNGD.'", \'success\');
					StTm_Est({ e:d.m });
					SUMR_Main.anm.tld(\''.$Dv.'\',\'out\');
					'.JS_SCR_POPCLS.'
				}else{
					SUMR_Main.anm.tld(\''.$Ldr.'\',\'out\');
					SUMR_Main.anm.tld(\''.$Dv.'\',\'in\');
				}
			}
		};

		$(\'#'.$__fmnm.'\').ajaxForm(opc_'.$___rnd.');';

		return($Vl);
	}

	function Pss_Strn($p=NULL){ //$_cls='', $_id='', $_btnpop=''
		if(!isN($p['cls'])){ $__cls = $p['cls']; }else{$__cls = 'Pss_Gnr';}
		if(!isN($p['id'])){ $__id = $p['id']; }else{$__id = 'pwdMeter'; ;}
		if($p['pop']){ $__btn = '<a href="'.FM_GN.'?_t=pss_gnr'.TXGN_POP.'" class="PssGnr">'.TX_GNRR.'</a>'; }
		return('<div class="'.$__cls.'">'.$__btn.'<div id="'.$__id.'" class="neutral">'.TX_STRNK.'</div></div>');
	}

	// Puntos Suspensivos
	function ShortTx($text, $max, $actPts='', $_mobile=false){
		if (($text > substr($text,0,$max))&&($actPts == "Pt")) {
			$ptsspvs = "...";
		}else{
			$ptsspvs = "";
		}
		$newTx = trim(substr($text,0,$max)).$ptsspvs;

		if($_mobile && isMobile()){
			return $text;
		}else{
			return $newTx;
		}
	}

	function __BtnFnc($i, $f){
		if($i!='' && $f!=''){
			return('$("#'.$i.'").click(function() { '.$f.' });');
		}
	}

	function HTML_inp_tx($_id=NULL, $_plc=NULL, $_vl=NULL, $_rq=NULL, $_mr=NULL, $_cls=NULL, $_mx=NULL, $_auc=NULL, $_rel=NULL, $p=NULL){

		if(!isN($_rq)){ $__cls .= $_rq.' '; }
		if(!isN($_cls)){ $__cls .= $_cls.' '; }

		if(!isN($_rel)){ $__rel =  ' rel="'.$_rel.'" '; }
		if(!isN($_mx)){ $_mxln = 'maxlength="'.$_mx.'"'; }
		if(!isN($_auc)){ $_autoc = 'autocomplete="'.$_auc.'"'; }
		if(!isN($_vl) && !isN($_plc)){ $_ph = '<label for="'.$_id.'" '.$__cls.' '.$__rel.'>'.$_plc.'</label>'; }

		if(!isN($p['attr'])){
			foreach($p['attr'] as $_attr_k=>$_attr_v){
				$__attr .= ' '.$_attr_k.'="'.$_attr_v.'" ';
			}
		}
		if(!isN($p['tp'])){ $_tp=$p['tp']; }else{ $_tp='text'; }

		$_r .= '<div class="___txar _anm"><input name="'.$_id.'" class="'.$__cls.'" '.$__rel.' '.$_autoc.' type="'.$_tp.'" id="'.$_id.'" placeholder="'.$_plc.'" value="'.$_vl.'" '.$_fmrq . $_mxln .' '.$_mr.$__attr.' />'. $_ph .'</div>';
		return($_r);
	}

	function HTML_inp_clr($_p=NULL){

		if(!isN($_p['rq'])){ $_fmrq = $_p['rq']; }
		if(!isN($_p['plc'])){ $_ph = '<label for="'.$_id.'">'.$_p['plc'].'</label>'; }
		$_r .= '<div class="___txar _clr _anm">'.$_ph.'<input name="'.$_p['id'].'" type="color" id="'.$_p['id'].'" placeholder="'.$_p['plc'].'" value="'.$_p['vl'].'" '.$_fmrq.' '.$_p['mr'].' /> </div>';
		return($_r);
	}

	function HTML_textarea($_id=NULL, $_plc=NULL, $_vl=NULL, $_rq=NULL, $_html=NULL, $_html_cls=NULL, $_rws=5, $_mx=NULL, $_rel=NULL, $_mre=NULL, $p=NULL){

		if($_rq!=NULL){ $_fmrq = 'required'; }
		if($_mx!=NULL){ $_mxln = 'maxlength="'.$_mx.'"'; }

		if(!isN($p['cid'])){ $__id = $p['cid']; }else{ $__id = $_id; }

		$_nm = $_id;

		if($_html == 'ok'){
			$_r .= h2($_plc);
			if(!isN($_html_cls)){ $_cls = $_html_cls; }else{$_cls = 'jqte'; }
		}else{
			if(!isN($_html_cls)){ $_cls = $_html_cls; }
			$_plc_go = $_plc;
		}

		if(!isN($_rws)){ $_rows = ' rows="'.$_rws.'" '; }

		$_r .= '<div><textarea name="'.$_nm.'" '.$_rows.' id="'.$__id.'" placeholder="'.$_plc_go.'" rel="'.$_rel.'" class="'.$_cls.' '.$_fmrq.'" '.$_mxln.' '.$_mre.' >'.$_vl.'</textarea></div>';
		return($_r);
	}

	function HTML_inp_hd($_id=NULL, $_vl=NULL, $_cls=NULL, $_p=NULL){
		$_r = '<input name="'.(!isN($_p['n'])?$_p['n']:$_id).'" type="hidden" id="'.$_id.'" value="'.$_vl.'" class="'.$_cls.'" />';
		return($_r);
	}



	function OLD_HTML_chck($_id=NULL, $_plc=NULL, $_vl=NULL, $_tp=NULL, $p=NULL){ // Has to migrate to new HTML_chck()

		if($_vl == 1){ $__chck = ' checked="checked" '; }
		if($_tp == 'in'){ $__chck_tt = h3($_plc); }else{ $__chck_tt = h2($_plc); }
		if($p['mny'] == 'ok'){ $__tt_mny = $_plc; $__chck_tt = ''; }
		if(!isN($p['alt'])){ $__tt_alt = ' title="'.$p['alt'].'" '; $__tt_alt = ''; }

		if(!isN($p['attr'])){ foreach($p['attr'] as $_k=>$v){ $__attr .= ' '.$_k.'="'.$v.'" '; } }

		$_r = ' <div class="__slc_ok" id="'.$_id.'_div" title="'.$__tt_mny.'">
					  '.$__chck_tt.'
					  <div class="__slc">
								<div class="slideThree" '.$__tt_alt.'>'.$p['icn'].'
								  <input name="'.$_id.'" type="checkbox" id="'.$_id.'" value="1"  '.$__chck.' class="'.$p['c'].'" '.$__attr.' />
								  <label for="'.$_id.'"></label>
								</div>
					  </div>
				</div>';
		return($_r);
	}


	function HTML_chck($p=NULL){ //$_id=NULL, $_plc=NULL, $_vl=NULL, $_tp=NULL, $p=NULL

		if($p['v']==1){ $__chck = ' checked="checked" '; }
		if($p['tp']=='in'){ $__chck_tt = h3($p['ph']); }else{ $__chck_tt = h2($p['ph']); }
		if($p['mny'] == 'ok'){ $__tt_mny = $_plc; $__chck_tt = ''; }
		if(!isN($p['alt'])){ $__tt_alt = ' title="'.$p['alt'].'" '; $__tt_alt = ''; }
		if(!isN($p['attr'])){ foreach($p['attr'] as $_k=>$v){ $__attr .= ' '.$_k.'="'.$v.'" '; } }

		$_r = ' <div class="__slc_ok '.$p['dc'].'" id="'.$p['id'].'_div" title="'.$__tt_mny.'">
					  '.$__chck_tt.'
					  <div class="__slc">
								<div class="slideThree" '.$__tt_alt.'>'.$p['icn'].'
								  <input name="'.$p['id'].'" type="checkbox" id="'.$p['id'].'" value="1"  '.$__chck.' class="'.$p['c'].'" '.$__attr.' />
								  <label for="'.$p['id'].'"></label>
								</div>
					  </div>
				</div>';
		return($_r);
	}


	function Html_chck_vl($v){
		if($v == 1){ return 1; }else{ return 2; }
	}


	//Funcion Imagen ID
	function ImgId($id='',$src=''){
		if(($id!='')&&($src!='')){
		return('<img id="'.$id.'" name="'.$id.'" src="'.$src.'" />');
		}
	}

	// Seleccion de Fechas


	/*function SlDt($Id, $VlrAc='',$Rqd='',$Tp='',$PlcHld='', $LmtDt='ok', $_VldOnSl='', $SlYr='', $_empty='', $_c=NULL, $Only=NULL, $_p=NULL){
		if(($Id!='')){

			$_cls = '__clndr';
			if($LmtDt == 'ok'){ $_lmtdt = ", maxDate: '-1'";}elseif($LmtDt == 'minDte'){ $_lmtdt = ", minDate: '0'";}
			if($SlYr == 'ok'){ $_slyrdt = ", changeYear: true";}
			if($_empty != 'ok'){ $__rdonly = 'readonly="readonly"';}


			if($_p['_mdy'] != NULL){ $_mdy = ', minDate: \''.date('Y-m-d', strtotime('+'.$_p['_mdy'].' days')).'\' '; }


			if($Tp == 'hr'){
				$Cmp = '
					$("#'.$Id.'").timepicker({showSecond: true, timeFormat: \'hh:mm:ss\' });
					$("#'.$Id.'").timepicker(\'setTime\', \''.$VlrAc.'\');
				';
				$Img = ImgId($Id.'btn', ICN_RLJ); $_cls = '__hour';
			}elseif($Tp == 'dthr'){$Cmp = '$("#'.$Id.'").datetimepicker({ addSliderAccess: true, showSecond: true, dateFormat: \'yy-mm-dd\', timeFormat: \'hh:mm:ss\' });'; $Img = ImgId($Id.'btn', ICN_RLJ);
			}elseif($Tp == 'mthyr'){$Cmp = ' $("#'.$Id.'").datepicker({changeMonth: true, changeYear: true, showButtonPanel: true, dateFormat: \'yy-mm\', onClose:
												function(dateText, inst) {
													var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
													var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
													$(this).val($.datepicker.formatDate(\'yy-mm\', new Date(year, month, 1)));
												}}
											);


											$("#'.$Id.'").focus(function () {
												$(".ui-datepicker-calendar").hide();
												$("#ui-datepicker-div").position({
													my: "center top",
													at: "center bottom",
													of: $(this)
												});
											});

			';

			$Img = ImgId($Id.'btn', ICN_CLND);

			}else{
				if($_VldOnSl=='ok'){$_vldon = 'onSelect: function () {$("#'.$Id.'").valid();},';}
				if(!isN($_p['scls'])){ $__slct = '.'.$_p['scls']; }else{ $__slct = '#'.$Id.''; }

				$Cmp = '$("'.$__slct.'").datepicker({ '.$_vldon.' dateFormat: \'yy-mm-dd\' '.$_lmtdt.$_mdy.$_slyrdt.'});';
				$Img = ImgId($Id.'btn', ICN_CLND);
			}

			if($Rqd != 'no'){$Rqud = ' class="required '.$_c.'" ';}
			if($PlcHld!=''){$_plc=' placeholder="'.$PlcHld.'"';}
			if($Only!='ok'){$__scrpt = '<script>'.$Cmp.'</script>'; }



		return ('<input name="'.$Id.'" type="text" '.HTML_attr([ 'a'=>$_p['attr'] ]).' id="'.$Id.'" onFocus="blur()" '.$_plc.' '.$__rdonly.' value="'.$VlrAc.'" '.$Rqud.' style="'.$_p['sty'].'" class="'.$_cls.'" />'.$__scrpt);

		}

	}

	*/
	function SlDt($p=NULL){

		if(!isN($p['id'])){

			$_cls = '__clndr';

			if($p['lmt'] != 'no'){ $_lmtdt = ", maxDate: '-1'"; }elseif($p['lmt'] == 'minDte'){ $_lmtdt = ", minDate: '0'"; }
			if($p['mth'] == 'ok'){
				$_slmthdt = ", changeMonth: true";
				/*$_mxDte = ", maxDate: '-16Y'"; $_mnDte = ", minDate: '-100Y'";*/
				//$_yrRng = ", yearRange: '1950:2019' ";
			}
			if($p['yr'] == 'ok'){ $_slyrdt = ", changeYear: true";}
			if($p['rd'] != 'ok'){ $__rdonly = ' readonly="readonly" ';}

			if(!isN($p['_mdy'])){
				$_mdy = ', minDate: \''.date('Y-m-d', strtotime('+'.$p['_mdy'].' days')).'\' ';
				$_d_mdy[] = ' from: \''.date('Y-m-d', strtotime('+'.$p['_mdy'].' days')).'\' ';
			}

			if(!isN($p['attr'])){
				foreach($p['attr'] as $_attr_k=>$_attr_v){
					$__attr .= ' '.$_attr_k.'="'.$_attr_v.'" ';
				}
			}


			if($p['cls']!='no'){

				$_oncls = ', onClose: function (dateText, inst) {
						        if($(window.event.srcElement).hasClass(\'ui-datepicker-close\')) {
						            document.getElementById(this.id).value = \'\';
						        }
						   }';

			}

			if($p['t'] == 'hr'){

				if(!isN($p['onS'])){ $_onS = ', onSelect:function(sT){ '.$p['onS'].'} '; }

				$Cmp = '

					$("#'.$p['id'].'").timepicker({
						showSecond: true,
						timeFormat: \'hh:mm:ss\'
						'.$_onS.'
					});

					$("#'.$p['id'].'").timepicker(\'setTime\', \''.$p['va'].'\');
				';

				$Img = ImgId($p['id'].'btn', ICN_RLJ); $_cls = '__hour';

			}elseif($p['t'] == 'dthr'){

				$Cmp = '$("#'.$p['id'].'").datetimepicker({ addSliderAccess: true, showSecond: true, dateFormat: \'yy-mm-dd\', timeFormat: \'hh:mm:ss\' });';
				$Img = ImgId($p['id'].'btn', ICN_RLJ);

			}elseif($p['t'] == 'mthyr'){

				$Cmp = '

					$("#'.$p['id'].'").datepicker({
						changeMonth: true, changeYear: true,
						showButtonPanel: true,
						dateFormat: \'yy-mm\',
						onClose:function(dateText, inst) {
								var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
								var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
								$(this).val($.datepicker.formatDate(\'yy-mm\', new Date(year, month, 1)));
						}
					});

					$("#'.$p['id'].'").focus(function () {
						$(".ui-datepicker-calendar").hide();
						$("#ui-datepicker-div").position({
							my: "center top",
							at: "center bottom",
							of: $(this)
						});
					});

				';

				$Img = ImgId($p['id'].'btn', ICN_CLND);

			}else{

				if($p['vld']=='ok'){ $_vldon = 'onSelect: function (){ $("#'.$p['id'].'").valid(); },'; }
				if(!isN($p['onc'])){ $_vldon = 'onSelect: function (){ var __v = $("#'.$p['id'].'"); '.$p['onc'].' },'; }
				if(!isN($p['scls'])){ $__slct = '.'.$p['scls']; }else{ $__slct = '#'.$p['id'].''; }

				//Validacion temporal -- Felipe
				/*if(!isN($_lmtdt) || !isN($_mdy) || SISUS_ID > 0){*/
					$Cmp = '$("'.$__slct.'").datepicker({ '.$_vldon.' closeText:\''.TX_DLT.'\', showButtonPanel:true, dateFormat: \'yy-mm-dd\' '.$_oncls.$_lmtdt.$_mdy.$_slyrdt.$_slmthdt.$_yrRng.' });';
				/*}else{
					$Cmp = '$("'.$__slct.'").dateDropper({'.implode(',', $_d_mdy).'});';
				}*/


				$Img = ImgId($p['id'].'btn', ICN_CLND);

			}


			if($p['rq']!='no'){ $Rqud = ' class="required '.$p['cls'].' '.$_cls.'" '; }else{ $Rqud = ' class="'.$p['cls'].' '.$_cls.'" '; }
			if($p['ph']!=''){$_plc=' placeholder="'.$p['ph'].'"';}
			if($p['in']!='ok'){$__scrpt = '<script>'.$Cmp.'</script>'; }

			//$__fcs = 'onFocus="blur()"';
			if($p['drp']['data-l-d'] == 'ok'){ $__attr_drp .= "data-large-default=\"true\""; }




			$__input = '<input name="'. (!isN($p['n'])?$p['n']:$p['id']) .'" type="text" '.HTML_attr([ 'a'=>$p['attr'] ]).' id="'.$p['id'].'" '.$__fcs.' '.$_plc.' '.$__rdonly.' value="'.$p['va'].'" '.$Rqud.' style="'.$p['sty'].'" data-theme="cliente" data-lang="es" data-modal="true" data-large-mode="true" '.$__attr_drp.$__attr.' data-format="Y-m-d" />';

			if($p['a']=='ok'){

				$_r['html'] = '<div class="___txar _anm">'.$__input.'</div>';
				$_r['js'] = $Cmp;

				return _jEnc($_r);

			}else{
				return ('<div class="___txar _anm">'.$__input.'</div>'.$__scrpt);
			}

		}

	}

	function Fl_i($_v){if($_v!=''){$_r = ADM_LNK_SB.$_v;return($_r);}}
	function Fl_f($_v=NULL){ $_r = '&__f='.$_v; return($_r); }
	function Fl_etp($_v=NULL){ $_r = '&__etp='.$_v; return($_r); }
	function Fl_vst($_v=NULL){ $_r = '&__vst='.$_v; return($_r); }
	function Fl_Rnd($_v){$_r = $_v.'&__rnd='.Gn_Rnd(3);return($_r);}

	function VoId(){$_vl = "javascript:void(0)"; return($_vl);}

	// Script para Colorbox
	function ClBx($Clss='',$Wd='',$Hgh='', $Tp='',$e='on', $ifr='no', $cls='on'){
		if($e=='on'){$I_1 = '<script type="text/javascript">$(document).ready(function(){'; $I_2 ='});</script>';}elseif($e=='cd'){$I_1 = ''; $I_2 = '';}else{$I_1 = '<script>'; $I_2 ='</script>';}
		if($ifr == 'on'){$_vr_Ifr = ', iframe:true';}
		if($Clss!=''){$V1=$Clss;}else{$V1='ImTh';}
		if($Wd!=''){$V2= 'width:"'.$Wd.'px",';}else{$V2='width:"'.SIS_CLRBX_W.'",';}
		if($Hgh!=''){$V3= 'height:"'.$Hgh.'px",';}else{$V3='height:"'.SIS_CLRBX_H.'",';}
		if($cls!='off'){$_clsoff = ', overlayClose:false, escKey:false'; }
			if($Tp == 'gal'){
				return($I_1.'$(".gal").colorbox({transition:"fade", trapFocus:false, slideshow:true '.$_clsoff.'})'.$I_2);
			}elseif($Tp == 'dt'){
				return($I_1.'$(".'.$V1.'").colorbox({'.$V2.' '.$V3.' trapFocus:false, transition:"elastic"'.$_vr_Ifr.' '.$_clsoff.'});'.$I_2);
			}else{
				return($I_1.'$(".'.$V1.'").colorbox({'.$V2.' '.$V3.' trapFocus:false, transition:"elastic"'.$_clsoff.'})'.$I_2);
			}
	}

	// Funcion Reemplaza Tildes para Busquedas
	function MyMn($txt=''){
		$vr1 = ["á","é","í","ó","ú","ñ","Á","É","Í","Ó","Ú","Ñ"];
		$vr2 = ["a","e","i","o","u","&ntilde;","A","E","I","O","U","&ntilde;"];
		$chgall = str_replace($vr1, $vr2, $txt);
		//return $txt;
		return $chgall;
	}

	//Funcion Imagen Sencilla
	function BlImg($Rt, $Tp='', $Fm='', $Jqr='',$Rnd='',$Vn='',$Lnk='',$Gal=''){
		if($Rt != ''){
			if($Vn == TPIMG_VNT){$Hg = 'height="'.SIS_IMGHG.'"';}
			if($Gal == 'ok'){$Cls = 'gal';}else{$Cls = CLSCLRBX;}
			if($Rnd == 1){$Ext ='?Rnd='.Gn_Rnd(20);}
				if($Tp == TPIMG_TH){
					$Img = Hrf($Fm,'<img src="'.DMN_CRM.$Rt.$Ext.'" style="max-height:'.SIS_IMGTH.'px; max-width:'.SIS_IMGTH.'px;"  border="0"/>',1,'','',$Cls);
					$NoIm = Hrf($Fm,'<img src="'.IMG_NP.'" style="max-height:'.SIS_IMGTH.'px; max-width:'.SIS_IMGTH.'px;" border="0"/>',1,'','',$Cls);
				}else{
					$Img = '<img src="'.$Rt.$Ext.'" '.$Sz.' '.$Hg.' border="0"/>';
					$NoIm = '<img src="'.IMG_NP.$Ext.'" '.$Sz.' '.$Hg.' border="0"/>';
				}
			$Sch = [DMN_BS];
			$Chn = [$Jqr];
			$Im_Chk = str_replace($Sch,$Chn,$Rt);

			if ((file_exists($Jqr.$Im_Chk))&&(is_file($Jqr.$Im_Chk))){
				//$Im_Prn = RtGlbImg($Img);
				$Im_Prn = $Img;
				$_V['img'] = $Im_Prn;
				$_V['e'] = true;
			}else{
				$_V['img'] = $NoIm;
				$_V['e'] = false;
			}

		}

		return(_jEnc($_V));
	}

	// Construccion de Etiqueta <a>
	function Hrf($fl='',$nm, $tp='',$cnf ='',$spn ='',$clss ='',$mr=''){
		if(($nm != '')&&($tp != '')){if($tp == 1){$Tp_p = '_self';}elseif($tp == 2){$Tp_p = '_self';$Tp_Cl = 'onclick="return confirm(&quot;&iquest;'.$cnf.'?&quot;)"';}else{$Tp_p = '_blank';}if($spn != ''){$SPN_CD = '<span class="'.$clss.'">'; $SPN_CD_2 = '</span>';}	if($clss!= ''){$CLSS = ' class="'.$clss.'" ';} return ('<a '.$Tp_Cl.' '.$mr.' '.$CLSS.'href="'.$fl.'"  target="'.$Tp_p.'">'.$SPN_CD.$nm.$SPN_CD_2.'</a>');}
	}

	function JV_Blq($_e='on'){
		$_r = 'SUMR_Main.blq_cls.f("'.$_e.'");';
		return($_r);
	}

	function JV_HtmlEd($_cls=NULL){
		if($_cls != NULL && $_cls != ''){ $__cls=$_cls; }else{ $__cls='jqte';  }
		$_r = " $('.".$__cls."').jqte({'link': false, 'unlink': false, 'rule': false, 'format': false, 'formats': false, 'u': false, 'funit':false, 'strike':false, 'sub':false, 'sup':false, 'color':false, 'indent':false, 'outdent':false }); ";
		return($_r);
	}



	//Script MYJS
	function UpLdImg($p=NULL){ //$Icn,$Dv,$Fl,$Vr='',$Tp=''
		if(!isN($p['icn']) && !isN($p['dv']) && !isN($p['fl'])){
			if($p['tp'] != 1){
				$Inc = '<script type="text/javascript">$(document).ready(function(){';
				$Fnl = '});</script>';
			}
			if($p['pop']=='ok'){ $_clsclr = JS_SCR_POPCLS; }
			if(!isN($p['m'])){
				foreach($p['m'] as $_m_k=>$_m_v){
					if(!isN($_m_v)){ $__mre .= '&'.$_m_k.'='.$_m_v; }
				}
			}

		return $Inc."	SUMR_Main.upld_img({
							ld:'".$p['icn']."',
							c:'".$p['dv']."',
							l:'".$p['fl']."?".$__mre."'
						});
				".$_clsclr.$Fnl;
		}
	}

	//Script MYJS
	function UpLdImgTH($p=NULl){ // $Icn,$Dv,$Fl,$Vr='',$Tp=''
		if(!isN($p['icn']) && !isN($p['dv']) && !isN($p['fl'])){
			if($p['tp'] != 1){
				$Inc = '<script type="text/javascript">$(document).ready(function(){';
				$Fnl = '});</script>';
			}
			if($p['pop']=='ok'){ $_clsclr = JS_SCR_POPCLS; }
			if($p['f']=='th'){ $__mre .= TXGN_UPLTH; }elseif($p['f']=='bn'){ $__mre .= TXGN_UPLBN; }
			if(!isN($p['m'])){
				foreach($p['m'] as $_m_k=>$_m_v){
					if(!isN($_m_v)){ $__mre .= '&'.$_m_k.'='.$_m_v; }
				}
			}
			return $Inc."	SUMR_Main.upld_img({
								ld:'".$p['icn']."',
								c:'".$p['dv']."',
								l:'".$p['fl']."?".$__mre."'
							});
						".$_clsclr.$Fnl;
		}
	}

	/*Redimensionar Imagen*/
	function Rsz($imgsrc,$imgnew,$newx=130,$newy=100,$quality=50){
		if( file_exists($imgsrc) ) {
		list($srcx,$srcy,$ext) = getimagesize($imgsrc);
					   switch( $ext) {
					   case 1 : 	$old = imagecreatefromgif($imgsrc); 		/*gif*/
										$img = imagecreate($srcx,$srcy);			/*Crea una imagen*/
										imagecolorallocate($img, 255, 255, 255); 	/*Fondo blanco*/
										imagecopy($img,$old,0,0,0,0,$srcx,$srcy); break;
							case 2 : 	$img = imagecreatefromjpeg($imgsrc); break;	/*jpg*/
							case 3 : 	$img = imagecreatefrompng($imgsrc); break;	/*png*/
							default: print_r(getimagesize($imgsrc)); return false;
					   }
					   $tamx=$srcx;
					   $tamy=$srcy;
					   if($srcx>$newx)$pv=($srcx>$srcy)?$srcx/$newx:$srcy/$newy;
					   elseif($srcy>$newy)$pv=($srcy>$srcx)?$srcy/$newy:$srcx/$newx;
					   if(isset($pv)){	$srcx=ceil($srcx/$pv); 	$srcy=ceil($srcy/$pv); 	}
					   $new = imagecreatetruecolor ($srcx, $srcy);
					   imagecopyresampled ($new, $img, 0, 0, 0, 0, $srcx, $srcy, $tamx, $tamy);
					   imagejpeg($new,(substr($imgnew,0,strrpos($imgnew,"."))).".jpg",$quality);
					   imagedestroy($img);
					   return true;
		} else return false;
	}

	function Im_Fl($Fld){
		$Sch = [DMN_BS];
		$Chn = [''];
		$Fldr_Rl = str_replace($Sch,$Chn,$Fld);
		return($Fldr_Rl);
	}



	function RtGlbFle($img=NULL,$p=NULL){

		if($img!=''){

			if(!isN($p['fld'])){ $_fldr = $p['fld']; }else{ $_fldr = '_img/'; }

			if(!isN($p['dmn'])){
				$src_prnt = str_replace($_fldr, $p['dmn'] , $img);
			}else{
				$src_prnt = $img;
				$src_prnt = str_replace(DIR_TMP_FLE, DMN_FLE, $src_prnt);
				$src_prnt = str_replace(DIR_TMP_BCO, DMN_BCO, $src_prnt);
				$src_prnt = str_replace('_fle/', DMN_FLE , $src_prnt);
			}
			return($src_prnt);
		}
	}

	function RtGlbImg($img=NULL,$p=NULL){

		if(!isN($img)){

			if(!isN($p['fld'])){ $_fldr = $p['fld']; }else{ $_fldr = '_img/'; }

			if(!isN($p['dmn'])){
				$src_prnt = str_replace($_fldr, $p['dmn'] , $img);
			}else{
				$src_prnt = str_replace($_fldr, DMN_IMG , $img);
			}
			return($src_prnt);
		}
	}



	function ImTh($_p){

		$prts = pathinfo($_p['src']);

		$ext = $prts['extension'];

		if($_p['width'] != ''){$Sz = $_p['width'];}elseif($_p['tm'] == 'th_com'){$Sz = 30;}elseif($_p['tm'] == 'th'){$Sz = 50;}else{$Sz = 150;}
		if($_p['name']!=''){$NmAl = ' alt="'.$_p['name'].'" '.' title="'.$_p['name'].'" ';}
		if($_p['id']!=''){$Id = 'id="'.$_p['id'].'"';}else{$Id = 'id="th_pc"';}



		if((file_exists($_p['pth'].$_p['src']))&&(is_file($_p['pth'].$_p['src']))){

			$Im_Prnt = RtGlbFle($_p['src'], ['fld'=>$_p['fld'], 'dmn'=>$_p['dmn']]);
			$img = "<img ".$Id." src='".$Im_Prnt."?".Gn_Rnd(20)."' style='max-width:".$Sz."; ".$_p['style']." ' ".$NmAl." ".$_p['more']." />";

		}elseif((file_exists($_p['pth_o'].$_p['src']))&&(is_file($_p['pth_o'].$_p['src']))){

			$Im_Prnt = RtGlbFle($_p['src'], ['dmn'=>$_p['dmn']]);
			$img = "<img ".$Id." src='".$Im_Prnt."?".Gn_Rnd(20)."' style='max-width:".$Sz."; ".$_p['style']." ' ".$NmAl." ".$_p['more']." />";

		}elseif( !isN($_p['dmn']) ){

			$Im_Prnt = RtGlbFle($_p['src']);
			$img = "<img ".$Id." src='".$Im_Prnt."?".Gn_Rnd(20)."' style='max-width:".$Sz."; ".$_p['style']." ' ".$NmAl." ".$_p['more']." />";

		}else{
			$img = "<img ".$Id." src='".IMG_NP."' width='".$Sz."' style='max-width:".$Sz."; ".$_p['style']." ' ".$SAnx." ".$_p['more']." />";
		}
		return $img;
	}


	function _isempty($_vl){
		if($_vl != ''){ $_r = '<span class="ok">si</span>';}else{ $_r = '<span class="no">no</span>'; } return($_r);
	}

	function _sino($_vl){
		if($_vl == 1){ $_r = '<span class="ok">si</span>';}else{ $_r = '<span class="no">no</span>'; } return($_r);
	}

	function _sinoDwn($_vl){
		if($_vl == 1){ $_r = 'si';}else{ $_r = 'no'; } return($_r);
	}

	function Anl($n=15){

		if(!Dvlpr()){
			return("<script data-cfasync=\"false\">
			  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
			  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
			  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
			  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
			  ga('create', 'UA-54608627-".$n."', 'auto');
			  ga('send', 'pageview');
			</script>");
		}
	}

	function _Chk_GET($_v=NULL){
		if($_v != NULL){

			$__v = $_GET[$_v];

			switch($__v){
				case NULL:
					return false;
					break;
				case '':
					return false;
					break;
				case 'null':
					return false;
					break;
				default:
       				return true;
					break;
			}

		}else{
			return false;
		}
	}

	function _AndSql($_f=NULL, $_v=NULL, $_no=NULL){
		if($_f!= NULL && $_v!=NULL && $_f!= '' && $_v!='' && $_f!= 'null' && $_v!='null'){
			$_r = implode(',', explode(',', $_v));
			if($_no){ $_sql = ' AND '.$_f.' NOT IN ('.$_r.') /* <-- Filtro */ '; }else{ $_sql = ' AND '.$_f.' IN ('.$_r.') /* <-- Filtro */ '; }
			return($_sql);
		}
	}

	//Fecha en Espanol
	function FechaESP_OLD($fecha, $onl=''){
		$onl_f = $fecha; // convierte la fecha de formato mm/dd/yyyy a marca de tiempo
		$fecha= strtotime($fecha); // convierte la fecha de formato mm/dd/yyyy a marca de tiempo
		$diasemana=date("w", $fecha);// optiene el numero del dia de la semana. El 0 es domingo
			 switch ($diasemana){
				 case "0":$diasemana=TX_DMNG;break;
				 case "1":$diasemana=TX_LNS;break;
				 case "2":$diasemana=TX_MRTS;break;
				 case "3":$diasemana=TX_MRCLS;break;
				 case "4":$diasemana=TX_JVS;break;
				 case "5":$diasemana=TX_FRI;break;
				 case "6":$diasemana=TX_SAT;break;
			 }
		 $dia=date("d",$fecha); // dia del mes en numero
		 $mes = date("m",$fecha); // numero del mes de 01 a 12

			 switch($mes){
				 case "01":$mes=TX_JAN;break;
				 case "02":$mes=TX_FEB;break;
				 case "03":$mes=TX_MRZ;break;
				 case "04":$mes=TX_APRL;break;
				 case "05":$mes=TX_MAY;break;
				 case "06":$mes=TX_JUN;break;
				 case "07":$mes=TX_JLY;break;
				 case "08":$mes=TX_AUG;break;
				 case "09":$mes=TX_SPTMBR;break;
				 case "10":$mes=TX_OCT;break;
				 case "11":$mes=TX_NOV;break;
				 case "12":$mes=TX_DEC;break;
			 }
		$ano=date("Y",$fecha); // optenemos el ano en formato 4 digitos

		if(($onl == 2)){
			$fecha= $mes;
		}elseif(($onl == 3)){
			$fecha= $ano;
		}elseif(($onl == 4)){
			$fecha= $dia;
		}elseif(($onl == 5)){
			$fecha= $diasemana.'-'.$mes;
		}elseif(($onl == 6)){
			$fecha= $diasemana;
		}elseif(($onl == 7)){
			$fecha= $mes.' '.$dia;
		}elseif(($onl == 8)){
			$fecha= substr($mes, 0, 3).'-'.$dia;
		}elseif(($onl == 9)){
			$fecha= '('.$ano.') '.substr($mes, 0, 3).'-'.$dia;
		}elseif(($onl == 10)){
			$fecha= $mes.' ('.$ano.')';
		}elseif(($onl == 'yrdy')){
			$fecha= '('.$ano.') '.$diasemana.", ".$dia." de ".$mes;
		}elseif(($onl == 'all')){
			$fecha= $diasemana.", ".$dia." de ".$mes.' del '.$ano;
		}elseif(($onl == 's')){
			$fecha = [
				'ds'=>$diasemana,
				'd'=>$dia,
				'm'=>$mes,
				'a'=>$ano
			];
		}else{
			$fecha= $diasemana.", ".$dia." de ".$mes;
		}
		return $fecha;
	}


	//Fecha en Espanol
	function FechaESP($p=NULL){

		try{

			if(!isN($p['f'])){

				$onl_f = $p['f']; // convierte la fecha de formato mm/dd/yyyy a marca de tiempo
				$fecha= strtotime($p['f']); // convierte la fecha de formato mm/dd/yyyy a marca de tiempo
				$diasemana=date("w", $fecha);// optiene el numero del dia de la semana. El 0 es domingo
					switch ($diasemana){
						case "0":$diasemana=TX_DMNG;break;
						case "1":$diasemana=TX_LNS;break;
						case "2":$diasemana=TX_MRTS;break;
						case "3":$diasemana=TX_MRCLS;break;
						case "4":$diasemana=TX_JVS;break;
						case "5":$diasemana=TX_FRI;break;
						case "6":$diasemana=TX_SAT;break;
					}
				$dia=date("d",$fecha); // dia del mes en numero
				$mes = date("m",$fecha); // numero del mes de 01 a 12

					switch($mes){
						case "01":$mes=TX_JAN;break;
						case "02":$mes=TX_FEB;break;
						case "03":$mes=TX_MRZ;break;
						case "04":$mes=TX_APRL;break;
						case "05":$mes=TX_MAY;break;
						case "06":$mes=TX_JUN;break;
						case "07":$mes=TX_JLY;break;
						case "08":$mes=TX_AUG;break;
						case "09":$mes=TX_SPTMBR;break;
						case "10":$mes=TX_OCT;break;
						case "11":$mes=TX_NOV;break;
						case "12":$mes=TX_DEC;break;
					}
				$ano=date("Y",$fecha); // optenemos el ano en formato 4 digitos

				if($p['t'] == 2){
					$fecha= $mes;
				}elseif($p['t'] == 3){
					$fecha= $ano;
				}elseif($p['t'] == 4){
					$fecha= $dia;
				}elseif($p['t'] == 5){
					$fecha= $diasemana.'-'.$mes;
				}elseif($p['t'] == 6){
					$fecha= $diasemana;
				}elseif($p['t'] == 7){
					$fecha= $mes.' '.$dia;
				}elseif($p['t'] == 8){
					$fecha= substr($mes, 0, 3).'-'.$dia;
				}elseif($p['t'] == 9){
					$fecha= '('.$ano.') '.substr($mes, 0, 3).'-'.$dia;
				}elseif($p['t'] == 10){
					$fecha= $mes.' ('.$ano.')';
				}elseif($p['t'] == 'yrdy'){
					$fecha= '('.$ano.') '.$diasemana.", ".$dia." de ".$mes;
				}elseif($p['t'] == 'all'){
					$fecha= $diasemana.", ".$dia." de ".$mes.' del '.$ano;
				}elseif($p['t'] == 'cmpr'){

					if($p['brk']=='ok'){ $_brk=HTML_BR; }else{ $_brk=' '; }
					$__diff = _Df_Dte($onl_f, SIS_F_TS);

					if(date('Ymd', $fecha) == date('Ymd') ){
						$fecha = 'Hoy'.$_brk.Spn( date('H:i a', $fecha ),'','hour');
					}elseif(date('Ymd', $fecha) == date('Ymd', strtotime('yesterday')) ){
						$fecha = 'Ayer'.$_brk.Spn( date('H:i a', $fecha ),'','hour');
					}elseif($__diff->d < 7 && date('Ymd', $fecha) > date('Ymd')){
						$fecha = FechaESP_OLD($fecha, 6).$_brk.Spn( date('H:i a', $fecha ),'','hour');
					}else{
						$fecha = _Dte_([ 'd'=>$onl_f ])->f.$_brk.Spn( date('H:i a', $fecha ),'','hour');
					}

				}elseif($p['t'] == 's'){
					$fecha = [
						'ds'=>$diasemana,
						'd'=>$dia,
						'm'=>$mes,
						'a'=>$ano
					];
				}else{
					$fecha= $diasemana.", ".$dia." de ".$mes;
				}

			}

		}catch (Exception $e) {
            if(ChckSESS_superadm()){
				echo $e->getMessage().HTML_BR;
				print_r($e); echo HTML_BR;
				print_r($p);
			}
		}

		return $fecha;
	}


	function _mnth($_m=NULL){
			if($_m != NULL){ $r['dy'] = date('n' , strtotime('-'.$_m.' months')); }else{ $r['dy'] = date('n');}
			if($_m != NULL){ $r['tx'] = FechaESP_OLD( date('Y/m/d' , strtotime('-'.$_m.' months')), 2); }else{ $r['tx'] = FechaESP_OLD( date('Y/m/d'),  2) ;}
		$_r = json_encode($r); return($_r);
	}

	function _LdImg($p=NULL){ //$_s, $_i, $_c=NULL, $_w=30

		if(!isN($p['w'])){ $_w=$p['w']; }else{ $_w=30; }
		if(!isN($p['w'])){ $_pth=$p['pth']; }else{ $_pth='../../../'; }

		$_pr = [	'id'=>'Nw_'.$p['i'],
					'src'=>$p['s'],
					'pth'=>$_pth,
					'tm'=>'th_com',
					'width'=>$_w,
					'more'=>'onload="SUMR_Main.ld_imls(\''.$p['i'].'\'); "',
					'style'=>'display:none;'
				];

		$_r = ImTh($_pr);
		$_r .= "<div id='Old_".$p['i']."' class='Old".$p['c']."'></div>";
		return($_r);
	}


	function _ChckPml($_t=NULL, $_p=NULL){

		global $__cnx;

		if($_t!=NULL && $_p!=NULL){

			if($_t == 'ec'){ $__bd = 'ec'; $__f='ec_pml'; }elseif($_t == 'pb'){ $__bd = 'pb'; $__f='pb_pml'; }

			$c_DtRg = "-1";if (isset($_p)){$c_DtRg = $_p;}
			$query_DtRg = sprintf('SELECT * FROM '._BdStr(DBM).$__bd.' WHERE '.$__f.' = %s', GtSQLVlStr($c_DtRg,'text'));

			$DtRg = $__cnx->_qry($query_DtRg);

			$row_DtRg = $DtRg->fetch_assoc();
			$Tot_DtRg = $DtRg->num_rows;
			if($Tot_DtRg == 1){ $_r=true; }else{ $_r=false; }

			$__cnx->_clsr($DtRg);

			return($_r);
		}
	}

	function _ChckMd($_v=NULL, $_r=NULL){
		if(!isN($_v)){
			if($_r != 'ok'){ if(ChckSESS_superadm()){ $__hb = 'ok'; } }
			if( (in_array($_v, explode(',', SISUS_PRM))) || ($__hb == 'ok')){ $_r=true; }else{ $_r=false; }
			return($_r);
		}
	}



	function _ChckClChat($_v=NULL){
		if(defined('DB_CL_CHAT') && DB_CL_CHAT == 'ok'){ $_r=true; }else{ $_r=false; }
		return($_r);
	}

	function _cdgwrn($_src){
		$_wrds = ['<strong', 'colspan', 'rowspace', 'javascript', 'swf', 'script', 'plugin'];
		foreach ($_wrds as &$wrd) {
			if (strstr($_src, $wrd)){
				return true;
				exit;
			}
		}
		return false;
	}

	function _Chk_VLE($_v=NULL, $_t=NULL){
		if($_v != NULL){
			if($_t == 'p'){ $__v = $_POST[$_v]; }else{ $__v = $_GET[$_v];}
			if(isset($__v)){ $_r = true; }else{ $_r = false; }
			if($__v != ''){ $_r = true; }else{ $_r = false; }
			if($__v != 'null'){ $_r = true; }else{ $_r = false; }
			if($__v != NULL){ $_r = true; }else{ $_r = false; }
		}else{ $_r = false; }
		return ($_r);
	}

	function _PostR_JData(){
		$postedData = json_decode( str_replace(['[', ']'],'',$_POST['data_json']) );
		return $postedData;
	}

	function _PostRw(){
		$postedData = json_decode(file_get_contents('php://input'), TRUE);
		return $postedData;
	}


	function _HTML_Input($_i, $_p=NULL, $_v=NULL, $_r=NULL, $_t='text', $p=null){

		//print_r($p);

		if(!isN($_i)){

			$browser = new Browser();
			$_id = $_i; $_plc = $_p; $_vle = $_v;

			if(!isN($p['attr'])){
				foreach($p['attr'] as $_attr_k=>$_attr_v){
					$__atttr .= ' '.$_attr_k.'="'.$_attr_v.'" ';
				}
			}

			if(isN($p['attr']['placeholder'])){
				$_plc_v =  "placeholder='".$_plc."'";
			}

			if($_t != 'checkbox'){

				if($browser->getBrowser() == 'Internet Explorer' && $browser->getVersion() < 9){
					$_lb = "<label for='".$_id."'>".$_p."</label>";
				}

				if(!isN($p['ac'])){ $_ac = ' autocomplete="'.$p['ac'].'" '; }
				$_html = $_lb."<input type='".$_t."' name='".(!isN($p['n'])?$p['n']:$_id)."' class='".$p['cls']."' id='".$_id."' style='".$_sty."' value='".$_vle."' $_plc_v ".$_r." ".$_ac." ".$__atttr."/>";

			}else{

				$_html = $_lb."<div class='__chkslc'>
								<div class='_chk'>
									<input type='".$_t."' class='".$p['cls']."' name='".(!isN($p['n'])?$p['n']:$_id)."' style='".$_sty."' id='".$_id."' value='ok' ".$_r." ".$__atttr."/>
									<label for='".$_id."'></label>".Spn($_plc)."
								</div>
							</div>";

			}

			return($_html);

		}
	}

	function _HTML_Text($_i, $_p, $_v=NULL, $_r=NULL, $p=NULL){
		if($_i!= '' && $_p!= ''){

			$_id = $_i; $_plc = $_p; $_vle = $_v;

			if(!isN($p['nm'])){ $nm = $p['nm']; }else{ $nm = $_id; }

			$_html = $_lb."<textarea name='".$nm."' cols='40' rows='8' id='".$_id."' placeholder='".$_plc."'>".$_vle."</textarea>";
			return($_html);
		}
	}

	function _htmlsismail($_c=NULL, $_t=NULL){
		if($_c != NULL){ $__cnt = $_c; } if($_t != NULL){ $__tt = $_t; }
				$__cnt = "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'><html xmlns='http://www.w3.org/1999/xhtml'><head><meta http-equiv='Content-Type' content='text/html; charset=UTF-8' /><title>".$__tt."</title></head><body style='padding:0px; margin:0px; background-color:#EEEEEE;'><table width='100%' border='0' cellspacing='0' cellpadding='0'> <tr> <td align='center' valign='middle' style='background: #FFF; padding:0px; text-align:center;'><table style='display: inline-table;' bgcolor='#ffffff' border='0' cellpadding='0' cellspacing='0' width='100%'><tr><td width='49%' valign='top'><img style='display: block; width:100%; ' name='hdr_1' src='".DMN_IMG."html/hdr_1.jpg' width='100%' height='154' id='hdr_10' alt='' /></td><td colspan='2' valign='top'><a href='http://www.sumr.co' target='_blank'><img style='display: block;' name='hdr_2' src='".DMN_IMG."html/hdr_2.jpg' width='283' height='154' id='hdr_11' alt='' /></a></td><td valign='top'><a href='http://www.sumr.co' target='_blank'><img style='display: block;' name='hdr_3' src='".DMN_IMG."html/hdr_3.jpg' width='227' height='154' id='hdr_12' alt='' /></a></td><td valign='top'><a href='".LNK_RDS_FB."' target='_blank'><img style='display: block;' name='hdr_4' src='".DMN_IMG."html/hdr_4.jpg' width='36' height='154' id='hdr_13' alt='' /></a></td><td valign='top'><a href='".LNK_RDS_TW."' target='_blank'><img style='display: block;' name='hdr_5' src='".DMN_IMG."html/hdr_5.jpg' width='41' height='154' id='hdr_14' alt='' /></a></td><td valign='top'><a href='".LNK_RDS_LKDIN."' target='_blank'><img style='display: block;' name='hdr_6' src='".DMN_IMG."html/hdr_6.jpg' width='38' height='154' id='hdr_15' alt='' /></a></td><td valign='top'><a href='".LNK_RDS_GPLS."' target='_blank'><img style='display: block;' name='hdr_7' src='".DMN_IMG."html/hdr_7.jpg' width='37' height='154' id='hdr_16' alt='' /></a></td><td colspan='2' valign='top'><img style='display: block;' name='hdr_8' src='".DMN_IMG."html/hdr_8.jpg' width='122' height='154' id='hdr_17' alt='' /></td><td width='49%' valign='top'><img style='display: block; width:100%; 'name='hdr_9' src='".DMN_IMG."html/hdr_9.jpg' width='100%' height='154' id='hdr_18' alt='' /></td></tr></table></td> </tr> <tr> <td style='background-color:#EEEEEE;'><table width='543' border='0' align='center' cellpadding='0' cellspacing='0'> <tr> <td align='center' valign='middle' style='line-height:1px;'><table width='518' border='0' align='center' cellpadding='0' cellspacing='0' style='width:518px;'> <tr> <td style='background-color:#FFF; font-family:Tahoma, Geneva, sans-serif; font-size: 14px; line-height:16px; color:#666666; padding-top: 10px; padding-bottom:10px; padding-right:40px; padding-left:40px; text-align:center; border-right: 1px solid #DDDDDD; border-left: 1px solid #DDDDDD; '>".$__cnt."</td></tr> </table></td> </tr> <tr> <td align='center' valign='middle' style='line-height:1px;'><table border='0' align='center' cellpadding='0' cellspacing='0' bgcolor='#eeeeee' style='display: inline-table;'> <tr> <td style='line-height:1px;'><img style='display: block;'name='ftr' src='".DMN_IMG."html/ftr.jpg' width='600' height='109' id='ftr' alt='' /></td> </tr> </table></td> </tr> <tr> <td align='center' valign='middle' style='line-height:1px;'>&nbsp;</td> </tr></table></td> </tr> <tr> <td align='center' valign='middle' style='background-color:#EEEEEE; text-align:center; padding-top:120px; padding-bottom:50px; '><table width='218' border='0' align='center' cellpadding='0' cellspacing='0' bgcolor='#eeeeee' style='display: inline-table;'> <tr> <td style='line-height:1px;'><a href='http://www.servicios.in' target='_blank'><img name='n_sv' src='".DMN_EC."img/html/_sv.jpg' width='218' height='47' id='n_sv' style='display: block;' /></a></td> </tr> </table></td> </tr></table></body></html>";
		return($__cnt);
	}

	function _Cod_Clrn($p=null) {
		$p = str_replace(' ', '-', $p); // Replaces all spaces with hyphens.
		$p = preg_replace('/[^A-Za-z0-9\-]/', '', $p); // Removes special chars.
		return preg_replace('/-+/', ' ', trim($p)); // Replaces multiple hyphens with single one.
	}

	function _GrpArr($p=NULL){
		$__r = str_replace(' ', '', $p);
		$__v = explode(',', $__r);
		$_i=0;
		foreach ($__v as &$v) {
			$__all[] = ['id' =>$_i, 'tt' => $v];
			$_i++;
		}
		return($__all);
	}

	function Tx_Nce($_v=NULL){
		$__r = ucwords(strtolower(	MyMn($_v)	)	);
		return($__r);
	}

	// Genera un tipo de formato numérico.
	function _Nmb($n=NULL,$t=NULL,$d=FALSE){ 	//	( numero a formatear, formato q se asigna, xxxx )
		if($n >= 0){
			if($t == 1) {
				$_r = number_format($n, 2, ',', '')."%";
			}elseif($t == 2) {
				$_r = number_format($n, 1, ',', '');
			}elseif($t == 3) {
				$_r = number_format($n, 0, ',', '.');
			}elseif($t == 4) {
				$_r = number_format($n, 4, '', ',');
			}elseif($t == 5) {
				$_r = number_format($n, 2, '.', '');
			}elseif($t == 6) {
				$_r = number_format($n, 0, '.', '');
			}elseif($t == 7) {
				$_r = number_format($n, 0, ',', '.')."%";
			}elseif($t == 8) {
				$_r = '$'.number_format($n, 0, ',', '.');
			}else{
				$_r = $n;
			}
		}elseif($d) {
			$_r = $n;
		}else{
			return false;
		}
		return $_r;
	}

	//	Crea un botón superior.
	function __MnBtn($p){	//	especificaciones del botón en un arreglo.

		if($p['t'] == 'dt'){ $__t = FL_DT_GN;}
		elseif($p['t'] == 'fm'){ $__t = FL_FM_GN;}
		elseif($p['t'] == 'fm_up'){ $__t = FL_FM_UP;}
		elseif($p['t'] == 'inf'){ $__t = FL_INF_GN;}
		elseif($p['t'] == 'up'){ $__t = FL_UP_GN;}
		elseif($p['t'] == 'non'){ $__t = '';}
		else{ $__t = FL_LS_GN; }


		if($p['trg'] != ''){ $__trg = $p['trg']; }else{ $__trg = '_self'; }
		if($p['l']!=NULL){
			$_onc = 'href="'.VoId().'" onClick="javascript:_mn(\''.$__t.$p['l'].'\');"';
		}elseif($p['h']!=NULL){
			$_onc = 'href="'.Void().'" l-url="'.$__t.$p['h'].'" ';
		}else{
			$_onc = 'href="'.VoId().'"';
		}

		if(!isN($p['cls'])){ $_cls = 'class="'.$p['cls'].'"'; }
		if(!isN($p['lcls'])){ $_lcls = 'class="'.$p['lcls'].'"'; }
		if(!isN($p['sty'])){ $_sty = 'style="'.$p['sty'].'"'; }

		$_c = '<a '.$_onc.' id="'.$p['id'].'" target="'.$__trg.'" '.$_cls.' '.$_sty.'>'.$p['c'].'</a>';
		if($p['li']!='no'){ $_c = $_c = '<li '.$_lcls.'>'.$_c.'</li>'; }
		return($_c);
	}

	function _SbLs(){
		$__i = Php_Ls_Cln($_GET['__i']);
		if($__i!='' && $__i!=NULL){
			return('ok');
		}else{
			return false;
		}
	}

	function _DtV(){
		$__d = Php_Ls_Cln($_GET['DtV']);
		if($__d=='ok'){
			return true;
		}else{
			return false;
		}
	}

	function _SbLs_ID($p=NULL){

		$__i = Php_Ls_Cln($_GET['__i']);

		if(!isN($__i)){
			if($p=='i'){ return($__i); }else{ return(ADM_LNK_SB.$__i); }
		}else{
			return false;
		}
	}

	function _SbLs_Etp($p=NULL){
		$__i = Php_Ls_Cln($_GET['__etp']);
		if($__i!='' && $__i!=NULL){
			if($p == 'i'){  return($__i); }else{ return('&__etp='.$__i); }
		}else{
			return false;
		}
	}

	function _BxRld_ID(){
		if(isset($_GET['_bx']) && (GtSQLVlStr($_GET['_bx'], "text"))){ $_bx_rld = $_GET['_bx']; }
		return(trim($_bx_rld));
	}


	/*
	function JQ__ldCnt($_l=NULL, $_i=NULL, $_p=NULL, $_j=true, $_m=NULL, $p=NULL){
		if($_l != NULL){
			if($_i != NULL){ $__i = ", c:'".$_i."'"; }
			if($_p != NULL){ $__p = "'".$_p."'"; }else{ $__p = "''"; }
			if($p['w'] != NULL){ $__w = "'".$p['w']."'"; }else{ $__w = "''"; }
			if($p['h'] != NULL){ $__h = "'".$p['h']."'"; }else{ $__h = "''"; }

			if($_j){ $__j = "javascript:";}

			$_b = $__j."_ldCnt({ u:'".$_l."'".$_m.$__i.", p:".$__p.", w:".$__w.", h:".$__h." });" ;
			return($_b);
		}
	}
	*/

	function JQ__ldCnt($p=NULL){ // $_l=NULL, $_i=NULL, $_p=NULL, $_j=true, $_m=NULL, $p=NULL
		if(!isN($p['u'])){

			if(!isN($p['u'])){ $__bld[] = " u:'".$p['u']."'"; }
			if(!isN($p['c'])){ $__bld[] = " c:'".$p['c']."'"; }
			if(!isN($p['p'])){ $__bld[] = " pop:'".$p['p']."'"; }
			if(!isN($p['w'])){ $__bld[] = " w:'".$p['w']."'"; }
			if(!isN($p['h'])){ $__bld[] = " h:'".$p['h']."'"; }
			if(!isN($p['pnl'])){
				$__bld[] = " pnl:{
								e:'".$p['pnl']['e']."',
								tp:'".$p['pnl']['t']."',
								s:'".$p['pnl']['s']."',
								sw:'".$p['pnl']['sw']."',
								ss:'".$p['pnl']['ss']."'
							}"; }

			if($p['js']!='no'){ $__j = "javascript:";}

			$_b = $__j."_ldCnt({ ".implode(',', $__bld)." });" ;
			return($_b);
		}
	}


	//Script Compongo Filtros
	function PgRgFl($grp, $tp=''){
		$sch = [" ", "_"];
		$_l1 = str_replace($sch,'',$grp);
		$Vr = explode(',',$_l1);
		$Vr_Tot = count($Vr);
					if($tp == 'get'){
						for ($i = 0; $i <= $Vr_Tot; $i++) {
							$_l2 = str_replace("_",'',$Vr[$i]);
							if(($Vr[$i]!='')&&(strlen($Vr[$i]) > 2)&&(isset($_GET['fl_'.$_l2]))&&($_GET['fl_'.$_l2]!='')){
								$Var .= "&fl_".$Vr[$i]."=".$_GET['fl_'.$_l2];
							}
						}
					}else{
						for ($i = 0; $i <= $Vr_Tot; $i++) {
							if(($Vr[$i]!='')&&(strlen($Vr[$i]) > 2)){
								$Var .= '&fl_'.$Vr[$i]."=' + fl_".$Vr[$i]." + '";
							}
						}
					}
		return($Var);
	}


	//Script Compongo Query para Filtros
	function Qry_Fl($grp){
		$sch = [" "];
		$_l1 = str_replace($sch,'',$grp);
		$Vr = explode(',',$_l1);
			$Vr_Tot = count($Vr);
			for ($i = 0; $i <= $Vr_Tot; $i++) {
				$_l2 = str_replace("_",'',$Vr[$i]);
				if(($Vr[$i]!='')&&(strlen($Vr[$i]) > 2)&&(isset($_GET['fl_'.$_l2]))&&($_GET['fl_'.$_l2]!='')){
					$Var .= " AND ".$Vr[$i]." = ".$_GET['fl_'.$_l2];
				}
			}
		return($Var);
	}

	//Script Compongo Query para Filtros
	function Chck_Fl($grp){
		$sch = [" "];
		$_l1 = str_replace($sch,'',$grp);
		$Vr = explode(',',$_l1);
			$Vr_Tot = count($Vr);
			for ($i = 0; $i <= $Vr_Tot; $i++) {
				$_l2 = str_replace("_",'',$Vr[$i]);
				if((isset($_GET['fl_'.$_l2]))&&($_GET['fl_'.$_l2]!='')){
					$Chk = 'ok';
				}
			}
		if($Chk == 'ok'){
			return(true);
		}else{
			return(false);
		}
	}

	function _DvLs($p=NULL){
		$__id = '_'.$p['id'];
		$r['html'] = bdiv([ 'id'=>DV_LSFL.$__id ]);
		$r['jv'] = _DvLsFl_Vr([ 'i'=>$p['i'], 'n'=>$__id, 't'=>$p['t'], 't2'=>$p['t2'] ]);
		$r['js'] = _DvLsFl([ 'i'=>$__id, 't'=>'s' ]);

		return(_jEnc($r));
	}

	function _DvLsFl_Vr($p=NULL){

		$__pop = Php_Ls_Cln($_GET['_pop']);

		if($p['tp'] == 'dt'){
			$_fld = FL_DT_GN;
		}elseif($p['tp'] == 'inf'){
			$_fld = FL_INF_GN;
		}elseif($p['tp'] == 'up'){
			$_fld = FL_UP_GN;
		}else{
			$_fld = FL_LS_GN;
		}

		if(!isN($p['t2'])){ $_t2 = __t2($p['t2']); }
		if(!isN($p['m'])){ $_m = $p['m']; }
		if(!isN($__pop)){ $_m .= TXGN_POP; }
		if(!isN($p['sis'])){ $_m .= __tsis($p['sis']); }

		$__r = " SUMR_Main.bxajx._".DV_LSFL.$p['n']." = '".Fl_Rnd($_fld.__t($p['t'],true)).$_t2.Fl_i($p['i']).TXGN_BX.DV_LSFL.$p['n'].$_m."'; ";
		return($__r);
	}

	function _DvLsFl($p=NULL){

		if($p['g'] != NULL){ $_got = $p['g']; }else{ $_got = $p['i']; }
		if($p['t'] == 's'){
			$__r = " _ldCnt({ u:SUMR_Main.bxajx._".DV_LSFL.$_got.", c:'".DV_LSFL.$_got."' }); " ;
		}else{

			if($p['h'] != NULL){
				$__go = " window.open('".$p['h']."'); ";
			}else{
				$__go = "

					if( !isN( SUMR_Main.bxajx._".DV_LSFL.$_got." ) ){

						$(this).addClass('_ldp');

						_ldCnt({
							u:SUMR_Main.bxajx._".DV_LSFL.$_got.",
							c:'".DV_LSFL.$_got."',
							_cl:function(){
								$('#".TBGRP.$p['i']."').removeClass('_ldp');
							}
						});

					}
				";
			}

			$__r = "$('#".TBGRP.$p['i']."').off('click').on('click', function(e){

						e.preventDefault();
						".$__go."

					}); " ;
		}
		return($__r);
	}




	function _Kn_Prcn($p=NULL){

		if(!isN($p['w'])){ $__wd=$p['w']; }else{ $__wd=20; }

		if(!isN($p['clr'])){
			$__clr=$p['clr'];
		}elseif($p['l']=='ok'){
			$__clr='6C0';
		}elseif($p['v'] == 100){
			$__clr='6C0';
		}elseif($p['v'] > 40){
			$__clr='F90';
		}else{
			if($p['v'] == 100){ $__clr='6C0'; }elseif($p['v'] > 40){ $__clr='F90'; }else{ $__clr='C00'; }
		}

		if($p['di']=='ok'){ $__di=true; }else{ $__di=false; }
		if(!isN($p['ds'])){ $__ds='data-step="0.5"'; }
		if(!isN($p['v'])){ $__vl='value="'.$p['v'].'"'; }
		if(!isN($p['dt'])){ $__dt=$p['dt']; }else{ $__dt='4'; }
		if(!isN($p['bclr'])){ $__bclr=' bgColor:"#'.$p['bclr'].'" '; }


		$Vl['html'] = '<input type="text" data-linecap="round" data-fgColor="#'.$__clr.'" class="g_tot" id="'.$p['id'].'" '.$__vl.' data-displayInput="'.$__di.'" data-width="'.$__wd.'" data-height="'.$__wd.'" data-readonly="true" data-thickness=".'.$__dt.'" '.$__ds.'>';
		$Vl['js'] = '$("#'.$p['id'].'").knob({ '.$__bclr.' });';

		return(_jEnc($Vl));
	}

	function _Kn_Prcn_n($_n){
		$__tot = count($_n);
		$__tot_o = count(array_filter($_n,create_function('$a','return $a !== null;')));
		$_r = number_format(($__tot_o / $__tot * 100),  0, '', ' ');
		return($_r);
	}

	function Gn_Rnd_Clr() {
    	return sprintf('#%06X', mt_rand(0, 0xFFFFFF));
	}


	function Frc_LgIn($__us=NULL, $__enc=NULL){

		global $__cnx;

		$_r['e'] = 'no';
		if($__us != NULL && $__enc != NULL){
			$LoginRS__query = sprintf("SELECT id_us, us_user, us_nivel FROM us WHERE us_user=%s", GtSQLVlStr($__us, "text"));
			$LoginRS = $__cnx->_qry($LoginRS__query);
			$row_LoginRS = $LoginRS->fetch_assoc();
			$loginFoundUser = $LoginRS->num_rows;

			if (($loginFoundUser) && ($__enc == enCad($row_LoginRS['id_us'].$row_LoginRS['us_user'].$row_LoginRS['us_nivel']))){

				$___ses = new CRM_SES();
				$___ses->usr = enCad($row_LoginRS['id_us'].$row_LoginRS['us_user'].$row_LoginRS['us_nivel']);
				$___ses->usr_grp = enCad($row_LoginRS['us_nivel']);
				$___ses->usr_id = $row_LoginRS['id_us'];
				$__e = $___ses->__lgin_set_rg();


				//$_SESSION[DB_CL_ENC_SES.MM_ADM_TST] = SISUS_USER;

				$_r['e'] = 'ok';

			}

		$__cnx->_clsr($LoginRS);

		}
		$rtrn = _jEnc($_r);
		return($rtrn);
	}

	// Evalúa si una variable esta vacía o su contenido es mayor que 0.
	function __cam_vlNd($num=NULL){ // (valor a evaluar)
		if ($num > 0 && $num != "" && $num != NULL) {
			$num = $num;
		} else {
			$num = ND;
		}
		return $num;
	}

	function __Cmp_c($_p=NULL){

		$___cmp_f1 = new DateTime($_p['f_str']);
		$___cmp_f2 = new DateTime($_p['f_end']);
		$___cmp_f3 = new DateTime('now');
		$___cmp_diff = $___cmp_f1->diff($___cmp_f2);
		$___cmp_diff_rst = $___cmp_f3->diff($___cmp_f2);
		$_v['d'] = $___cmp_diff->format('%a')+1;
		$_v['d_rst'] = $___cmp_diff_rst->format('%a')+2;

		$_v['c_prs'] = $_p['prs']; // Presupuesto Cliente

		// Servicios.in
		if(ChckSESS_superadm() || $_p['adm'] == 'ok'){
			if($_p['gst_f']){ $_v['s_gst'] = $_p['gst_f']; }else{ $_v['s_gst'] = $_p['gst']; } // Valor Gastado Servicios.in
			$_v['s_inv'] = $_v['c_prs']-(($_v['c_prs']*$_p['utl'])/100); // Valor Total a Invertir por Servicios.in
			$_v['s_inv_d'] = $_v['s_inv']/$_v['d']; // Inversion por dia Servicios.in
			$_v['s_inv_rst'] = $_v['s_inv'] - $_p['gst']; if($_v['s_inv_rst'] == ''){ $_v['s_inv_rst'] = '0'; } // Valor Restante a Invertir por Servicios.in
			$_v['s_gnc_p'] = $_v['c_prs'] - $_v['s_inv']; // Ganancia Planeada
			$_v['s_gnc_r'] = $_v['c_prs'] - $_v['s_gst']; if($_v['s_gnc_r'] == ''){ $_v['s_gnc_r'] = '0'; } // Ganancia Real
		}
		if($_v['s_inv'] != NULL){
			if($_p['gst_f']){ $_v['c_inv_p'] = 100; }else{ $_v['c_inv_p'] = ($_p['gst']/$_v['s_inv'])*100; }
			$_v['s_inv_p'] = ($_v['s_gst']/$_v['s_inv'])*100;
			$_v['s_inv_r_p'] = 100-$_v['s_inv_p'];
		}else{
			$_v['s_inv_p'] = 0;
			$_v['s_inv_r_p'] = 0;
		} // Pocentaje de Gasto Servicios.in
		$_v['s_inv_rst_d'] = $_v['s_inv_rst']/$_v['d_rst']; if($_v['s_inv_rst_d'] == ''){ $_v['s_inv_rst_d'] = '0'; } // Valor Restante a Invertir por Servicios.in por dia

		// Cliente
		$_v['c_gst'] = (($_v['c_prs']*$_v['c_inv_p'])/100); // Pocentaje de Gasto Cliente
		$_v['c_prs_d'] = $_v['c_prs']/$_v['d']; // Inversion por dia Cliente


		if($_p['clc'] > 0){ $_v['c_cpc'] = $_v['c_gst']/$_p['clc']; } // Costo por Click
		if($_p['lds'] > 0){ $_v['c_cpl'] = $_v['c_gst']/$_p['lds']; } // Costo por Lead
		if($_p['alc'] > 0){ $_v['c_ctr'] = $_p['clc']/$_p['alc'] *100;} // Costo por Lead
		if($_p['clc'] > 0){ $_v['c_cnv'] = $_p['lds']/$_p['clc'] *100;} // Costo por Lead

		$rtrn = json_encode($_v);
		return($rtrn);
	}

	function __Cmp_wrn($_p=NULL){

		if($_p['md_l_v'] > 0){ $_v['lds_aprx'] = _Nmb($_p['prs'] / $_p['md_l_v'],6); }else{ $_v['lds_aprx'] = 0; }
		if($_v['lds_aprx'] > 0){ $_v['prc'] = ($_p['cnt_tot']/$_v['lds_aprx'])*100; }

		if(($_p['cnt_tot'] > $_v['lds_aprx']) || ($_p['est'] != 1)){
			$_v['est'] = 'ok';
			$_v['est_sty'] = '';
		}else{

			$_v['est'] = 'no';

			if($_v['prc'] > 80){
				$_v['est_sty'] = ' style="background-color:#EAFACA;" ';
			}elseif($_v['prc'] > 50 && $_p['ds'] > 10){
				$_v['est_sty'] = ' style="background-color:#FFFBB5;" ';
			}elseif(($_v['prc'] > 20 || $_p['ds'] > 15) && $_p['ds'] > 6){
				$_v['est_sty'] = ' style="background-color:#FBD9B5;" ';
			}else{
				$_v['est_sty'] = ' style="background-color:#FFBFBF;" ';
			}
		}

		if($_p['cnt_tot'] < $_v['lds_aprx']){
			$_v['cnt_est'] = 'no';
		}else{
			$_v['cnt_est'] = 'ok';
		}


		$rtrn = json_encode($_v);
		return($rtrn);
	}

	function _hgh_w($_desktop, $_mobile){
		if(isMobile()){ $__w = $_mobile; }else{ $__w = $_desktop; }
		return($__w);
	}

	function _mbl_js($_f){
		if(!isMobile()){
			return($_f);
		}else{
			return 'null';
		}
	}

	function _mbl_ses($_f){
		if ((isset($_SESSION[DB_CL_ENC_SES.MM_ADM]))){
			return 'null';
		}else{
			return($_f);
		}
	}

	function _Cnt_G($_v, $_t=NULL){
		if($_v != ''){
			$_r = Spn('G','ok','_gen','','',$_t);
			return($_r);
		}
	}

	function _dp($t){
		return($t.': ');
	}

	function _SvQry($p=NULL){

		global $__cnx;

		$insertSQL = sprintf("INSERT INTO sis_qry (sisqry_prc) VALUES (%s)",
							   GtSQLVlStr($p['qry'], "text"));

		$Result = $__cnx->_prc($insertSQL);
	}


	function UPDCnt_Cld($p=NULL){

		global $__cnx;

		if(!isN($p['bd'])){ $__bdprfx = $p['bd']; }elseif(defined('DB_CL')){ $__bdprfx = DB_CL.'.'; }
		if(!isN($p['c_a'])){ $cldnow = __LsDt([ 'k'=>'cld', 'id'=>$p['c_a'] ]); }

		if(!isN($p['c'])){

			$_cld = $p['c'];

		}else{

			$__dtest = GtCntEstDt([ 'id'=>$p['e'] ]);

			if(!isN($cldnow->d->ptje->vl)){

				$rsp['buy']['est'] = $__dtest->buy;
				$rsp['buy']['etp'] = $__dtest->tp->buy;

				if(($__dtest->buy == 'ok' || $__dtest->tp->buy == 'ok') && $cldnow->d->ptje->vl < 4){
					$_cld = _CId('ID_CLD_GOOD');
					$rsp['cld']['sve'] = _CId('ID_CLD_GOOD');
				}
			}

		}

		if(!isN($p['id']) && !isN($_cld)){

			$updateSQL = sprintf("UPDATE ".$__bdprfx.TB_CNT." SET cnt_cld=%s WHERE cnt_enc=%s",
					   GtSQLVlStr($_cld, "int"),
					   GtSQLVlStr($p['id'], "text"));

			//$rsp['q'] = $updateSQL;
			$Result_UPD = $__cnx->_prc($updateSQL);
			$rsp['e'] = 'ok';

		}else{

			$rsp['e'] = 'no';
			$rsp['w'] = $__cnx->c_p->error;
			_ErrSis(['p'=>$insertSQL, 'd'=>$__cnx->c_p->error]);

		}

		$__cnx->_clsr($Result_UPD);

		return _jEnc($rsp);
	}

	function _Fx_Prx($p=NULL){

		$__pc = explode('_', $p['v']);

		// PREFIX 1 PARTE
		$_r['tp'] = $__pc[0];
		$_r['tpc'] = strtoupper($__pc[0]);
		$_r['tpu'] = ucfirst($__pc[0]);

		// PREFIX 2 PARTES
		$_r['prfx2'] = $__pc[0].$__pc[1];
		$_r['prfx2_c'] = $__pc[0];
		if($__pc[1] != NULL && $__pc[1] != ''){ $_r['prfx2_c'] .= '_'.$__pc[1]; }
		$_r['prfx2_u'] = strtoupper($__pc[0]);
		if($__pc[1] != NULL && $__pc[1] != ''){ $_r['prfx2_u'] .= '_'.strtoupper($__pc[1]); }


		// PREFIX 3 PARTES
		$_r['prfx3'] = $__pc[0].$__pc[1].$__pc[2];
		$_r['prfx3_c'] = $__pc[0];
		if($__pc[1] != NULL && $__pc[1] != ''){ $_r['prfx3_c'] .= '_'.$__pc[1]; }
		if($__pc[2] != NULL && $__pc[2] != ''){ $_r['prfx3_c'] .= '_'.$__pc[2]; }
		$_r['prfx3_u'] = strtoupper($__pc[0]);
		if($__pc[1] != NULL && $__pc[1] != ''){ $_r['prfx3_u'] .= '_'.strtoupper($__pc[1]); }
		if($__pc[2] != NULL && $__pc[2] != ''){ $_r['prfx3_u'] .= '_'.strtoupper($__pc[2]); }




		// PREFIX 4 PARTES
		$_r['prfx4'] = $__pc[0].$__pc[1].$__pc[2].$__pc[3];
		$_r['prfx4_c'] = $__pc[0];
		if($__pc[1] != NULL && $__pc[1] != ''){ $_r['prfx4_c'] .= '_'.$__pc[1]; }
		if($__pc[2] != NULL && $__pc[2] != ''){ $_r['prfx4_c'] .= '_'.$__pc[2]; }
		if($__pc[3] != NULL && $__pc[3] != ''){ $_r['prfx4_c'] .= '_'.$__pc[3]; }
		$_r['prfx4_u'] = strtoupper($__pc[0]);
		if($__pc[1] != NULL && $__pc[1] != ''){ $_r['prfx4_u'] .= '_'.strtoupper($__pc[1]); }
		if($__pc[2] != NULL && $__pc[2] != ''){ $_r['prfx4_u'] .= '_'.strtoupper($__pc[2]); }
		if($__pc[3] != NULL && $__pc[3] != ''){ $_r['prfx4_u'] .= '_'.strtoupper($__pc[3]); }

		$r_t = 1;
		foreach($__pc as $_v){
			if($r_t != 1){ $r_t_v[] = $_v; }
			$r_t++;
		}

		if($r_t_v != NULL && $r_t_v != ''){ $_r['lt'] = implode('_', $r_t_v); }


		$rtrn = json_decode(json_encode($_r));
		if(!isN($rtrn)){ return($rtrn); }
	}




	function _Rg_Tme($_tme_s=NULL, $_tme_e=NULL, $p=NULL){

		global $__cnx;

		/*
		$r['e'] = 'no';

		if(!isN($_tme_s) && !isN($_tme_e)){

			if(defined('RGTME_ON') && RGTME_ON == 'ok'){
		*/



		$__qry_url = $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
		$__qry_exc_t = ($_tme_e - $_tme_s)/60;
		$__qry_exc = number_format($__qry_exc_t, 5, '.', '');


		$r['tme'] = Spn($__qry_exc.' Mins','ok','_f') ;



		/*
				$insertSQL = sprintf("INSERT INTO "._BdStr(DBM).TB_SIS_TME." (sistme_fle, sistme_tp, sistme_btch, sistme_url, sistme_tme, sistme_tme_s, sistme_tme_e, sistme_us) VALUES (%s, %s, %s, %s, %s, %s, %s, %s)",
							GtSQLVlStr($p['f'], "text"),
							GtSQLVlStr($p['tp'], "text"),
							GtSQLVlStr($p['btch'], "text"),
							GtSQLVlStr($__qry_url, "text"),
							GtSQLVlStr($__qry_exc, "text"),
							GtSQLVlStr($_tme_s, "text"),
							GtSQLVlStr($_tme_e, "text"),
							GtSQLVlStr(SISUS_ID, "int"));

				$Result = $__cnx->_prc($insertSQL);

				if($Result){ $r['i'] = $__cnx->c_p->insert_id; $r['e'] = 'ok'; $r['exc'] = $__qry_exc; }

			}

		}else{

			$r['m'] = 'Turn on RGTME_ON';

		}

		*/

		return _jEnc($r);

	}


	function __Bx_Wrn($_p=NULL){

			$r['html'] = '<div style="display:none;">
				<div id="'.$_p['id'].'" class="__pop_wrn">
					'.h1($_p['t']).'
					<p>
						<input name="'.$_p['id'].'_no" id="'.$_p['id'].'_no" type="button" class="_no"  value="No">
						<input name="'.$_p['id'].'_ok" id="'.$_p['id'].'_ok" type="button" class="_ok"  value="Si">
					</p>
				</div>
			</div';

			$r['js'] .= "$('#".$_p['id']."_ok').click(function(){ ".$_p['js_ok']." ".JS_SCR_POPCLS." }); ";
			$r['js'] .= "$('#".$_p['id']."_no').click(function(){ ".JS_SCR_POPCLS." }); ";

			$_r = _jEnc($r); return($_r);
	}

	function __XlsCmpr($a, $b){
		return strnatcmp( strtolower($a['t']), strtolower($b['t']));
    }

	function __NmFx($v){

	  	$tokens = explode(' ', trim($v));
	  	$names = [];
	  	$special_tokens = ['da', 'de', 'del', 'la', 'las', 'los', 'mac', 'mc', 'van', 'von', 'y', 'i', 'san', 'santa'];
	  	$prev = "";

		foreach($tokens as $token) {
			$_token = strtolower($token);
			if(in_array($_token, $special_tokens)) {
				$prev .= "$token ";
			} else {
				$names[] = $prev. $token;
				$prev = "";
			}
		}

		$num_nombres = count($names);
		$nombres = $apellidos = "";

		switch ($num_nombres) {
		  	case 0:
			  	$nombres = '';
			  	break;
			case 1:
			  	$nombres = $names[0];
			  	break;
			case 2:
			  	$nombres    = $names[0];
			  	$apellidos  = $names[1];
			  	break;
			case 3:
			  	$nombres = $names[0] . ' ' . $names[1];
			  	$apellidos = $names[2];
			  	break;
			case 4:
			  	$nombres = $names[0] . ' ' . $names[1];
			  	$apellidos = $names[2] . ' ' . $names[3];
				break;
			default:
				$nombres = $names[0] . ' ' . $names[1];
			  	unset($names[0]);
			  	unset($names[1]);
			  	$apellidos = implode(' ', $names);
			  	break;
	  	}

	  	$r['nm'] = mb_convert_case($nombres, MB_CASE_TITLE, 'UTF-8'); // Fix
	  	$r['ap'] = mb_convert_case($apellidos, MB_CASE_TITLE, 'UTF-8'); // Fix

	  	//$r['nm'] = $nombres;
	  	//$r['ap'] = $apellidos;

	  	return _jEnc($r);

	}




	function MdlCntLck($p=NULL){

		global $__cnx;

		if($p['l']){ $_lck_i = 1; $_lck_h = SIS_H2; $_lck_u = SISUS_ID; }else{ $_lck_i = 2; $_lck_h = ''; $_lck_u = NULL; }
		if(!isN($p['bd'])){ $__bdprfx=_BdStr($p['bd']); }

		if(!isN($p['id'])){

			$updateSQL = sprintf("UPDATE ".$__bdprfx.TB_MDL_CNT." SET mdlcnt_lck=%s, mdlcnt_lck_h=%s, mdlcnt_lck_us=%s WHERE id_mdlcnt=%s",
					   GtSQLVlStr($_lck_i, "int"),
					   GtSQLVlStr($_lck_h, "date"),
					   GtSQLVlStr($_lck_u, "int"),
					   GtSQLVlStr($p['id'], "int"));

			$Result_UPD = $__cnx->_prc($updateSQL);
			$rsp['e'] = 'ok';

		}else{
			$rsp['e'] = 'no';
			$rsp['w'] = $__cnx->c_p->error;
			_ErrSis(['p'=>$insertSQL, 'd'=>$__cnx->c_p->error]);
		}

		return _jEnc($rsp);
	}


	function _Dte_Cl($_p=NULL){
		if($_p != NULL){
			$__fcal = new DateTime($_p['f']);
			if($_p['d'] != '' || $_p['d'] != NULL){
				$__fcal->add(new DateInterval('P'.$_p['d'].'D'));
			}

			// Calcula si es fin de semana
			if($__fcal->format('N') == 6){ $__sum_d = 2; }elseif($__fcal->format('N') == 7){ $__sum_d = 1; }
			if($__sum_d != ''){ $__fcal->add(new DateInterval('P'.$__sum_d.'D')); $_v['r'] = Spn('R','ok','no'); }

				$_v['d'] = $__fcal->format('Y-m-d');
				$_v['t'] = FechaESP_OLD($__fcal->format('Y-m-d'), 6) . $_v['r'];

			$_r = json_decode(json_encode($_v));
			return $_r;
		}
	}


	function _DteHTML($_p=NULL){
		if($_p['d'] != ''){

			$date = new DateTime($_p['d']);

			if($_p['nd'] != 'no'){ $_r = $date->format('Y-m-d'); }

			if($_p['br']=='ok'){ $_br = HTML_BR; }
			elseif($_p['nd'] != 'no' && $_p['nh'] != 'no'){ $_r .= ' - '; }

			if($_p['nh'] != 'no'){ $_r .= $_br.Spn($date->format('h:i').Strn($date->format(' a')), '', '__dte'); }
			return $_r;
		}
	}

	function _HrHTML($_p=NULL){
		if($_p != ''){
			$date = new DateTime($_p);
			$_r = $date->format('h:i a');
			return $_r;
		}
	}


	function _Dte_($_p=NULL){
		if(!isN($_p['d'])){
			$date = new DateTime($_p['d']);
			$_v['f'] = $date->format('Y-m-d');
			$_v['h'] = $date->format('H:i:s');

			$_r = _jEnc($_v);
			return $_r;
		}
	}

	function _ChckCntEml($_p=NULL){

		global $__cnx;

		if($_p['id']){


			//-------------------- CONSULTA TIPOLOGIA * --------------//

				$_prts = explode("@", $_p['id']);
				$_tp = __LsDt([ 'k'=>'sis_eml_prs' ]);

				$_eml_tp = 2;

				foreach($_tp->ls->sis_eml_prs as $_tp_k=>$_tp_v){
					if($_tp_v->tt == $_prts[1]){
						$_eml_tp = 1;
					}
				}

				$_v['chk']['tp'] = $_eml_tp;

			//-------------------- CONSULTA REGULAR * --------------//

			if($_p['t'] == 'enc'){ $__f = 'cnteml_enc'; }else{ $__f= 'cnteml_eml'; }
			if(!isN($_p['bd'])){ $__bdprfx=$_p['bd'].'.'; }


			$c_DtRg = "-1";if (isset($_p['id'])){$c_DtRg = $_p['id'];}
			$query_DtRg = sprintf('SELECT * FROM '.$__bdprfx.TB_CNT_EML.' WHERE '.$__f.' = %s', GtSQLVlStr($c_DtRg,'text'));

			if($_p['cmmt']=='ok'){ //-- If use it on commit process --//
				$DtRg = $__cnx->_prc($query_DtRg);
			}else{
				$DtRg = $__cnx->_qry($query_DtRg);
			}

			if($DtRg){

				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;

				if($Tot_DtRg == 1){
					$_v['id'] = $row_DtRg['id_cnteml'];
					$_v['e']='ok';
					$_v['cnt'] = GtCntDt([  'bd' => $_p['bd'], 'id'=>$row_DtRg['cnteml_cnt'], 'cmmt'=>$_p['cmmt'] ]);
				}else{
					$_v['e']='no';
				}

			}

			$__cnx->_clsr($DtRg);

		}

		return _jEnc($_v);
	}


	function _ChckCntDc($_p=NULL){

		global $__cnx;

		if($_p['id']){

			if($_p['t'] == 'enc'){ $__f = 'cntdc_enc'; }else{ $__f= 'cntdc_dc'; }
			if(!isN($_p['tp'])){ $__fl = sprintf(' AND cntdc_tp=%s ', GtSQLVlStr($_p['tp'],'int') ); }
			if(!isN($_p['bd'])){ $__bdprfx=_BdStr($_p['bd']); }

			$c_DtRg = "-1";if (isset($_p['id'])){$c_DtRg = $_p['id'];}
			$query_DtRg = sprintf('SELECT * FROM '.$__bdprfx.TB_CNT_DC.' WHERE '.$__f.' = %s '.$__fl, GtSQLVlStr($c_DtRg,'text'));

			if($_p['cmmt']=='ok'){ //-- If use it on commit process --//
				$DtRg = $__cnx->_prc($query_DtRg);
			}else{
				$DtRg = $__cnx->_qry($query_DtRg);
			}

			if($DtRg){

				$_v['e']='ok';
				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;

				if($Tot_DtRg == 1){
					$_v['id'] = $row_DtRg['id_cntdc'];
					$_v['cnt'] = GtCntDt([ 'src_main'=>456, 'id'=>$row_DtRg['cntdc_cnt'], 'cmmt'=>$_p['cmmt'] ]);
				}

			}else{
				if($_p['cmmt']=='ok'){
					$_v['w']=$__cnx->c_p->error;
				}else{
					$_v['w']=$__cnx->c_r->error;
				}
			}



			$__cnx->_clsr($DtRg);

		}else{

			$_v['w']='No all data for process';

		}

		return _jEnc($_v);
	}


	function _ChckCntTel($_p=NULL){

		global $__cnx;

		$_v['e']='no';

		if(!isN($_p['id'])){

			if($_p['t'] == 'enc'){ $__f = 'cnttel_enc'; }else{ $__f= 'cnttel_tel'; }
			if(!isN($_p['cnt'])){ $__fcnt = sprintf(' AND cnttel_cnt = %s', GtSQLVlStr($_p['cnt'],'int')); }
			if(!isN($_p['bd'])){ $__bdprfx=$_p['bd'].'.'; }

			$c_DtRg = "-1";if (isset($_p['id'])){$c_DtRg = $_p['id'];}

			$query_DtRg = sprintf('	SELECT id_cnttel, cnttel_cnt
									FROM '.$__bdprfx.TB_CNT_TEL.'
									WHERE '.$__f.'=%s '.$__fcnt, GtSQLVlStr($c_DtRg,'text')
								);

			if($_p['cmmt']=='ok'){ //-- If use it on commit process --//
				$DtRg = $__cnx->_prc($query_DtRg);
			}else{
				$DtRg = $__cnx->_qry($query_DtRg);
			}

			//$_v['tmp_qry'] = compress_code($query_DtRg);

			if($DtRg){

				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;

				$_v['e']='ok';
				$_v['tot'] = $Tot_DtRg;

				if($Tot_DtRg == 1){

					$__cnt_dt = GtCntDt([ 'bd'=>$_p['bd'], 'id'=>$row_DtRg['cnttel_cnt'], 'cmmt'=>$_p['cmmt'] ]);

					$_v['id'] = $row_DtRg['id_cnttel'];

					if(!isN($__cnt_dt->id)){
						$_v['cnt'] = $__cnt_dt;
					}else{
						$_v['cnt']['id'] = $row_DtRg['cnttel_cnt'];
					}

				}else{
					//$_v['tmp_qry'] = compress_code($query_DtRg);
				}

			}else{

				if($_p['cmmt']=='ok'){ //-- If use it on commit process --//
					$_v['w'] = $__cnx->c_p->error.' on '.compress_code($query_DtRg);
				}else{
					$_v['w'] = $__cnx->c_r->error.' on '.compress_code($query_DtRg);
				}

			}

			$__cnx->_clsr($DtRg);

		}else{
			$_v['e']='no';
			$_v['w'] = 'No data for process';
		}

		return _jEnc($_v);

	}


	function _ChckCntTelPs($_p=NULL){

		global $__cnx;

		$_v['e']='no';

		if(!isN($_p['no'])){

			if(strpos($_p['no'],'+') !== false){

				$_chno = 5;

				for($i = 1; $i<=4; $i++){

					$_no_sch = $result = substr($_p['no'], 1, $_chno);

					$query_DtRg = sprintf('
											SELECT id_sisps
											FROM '._BdStr(DBM).TB_SIS_PS.'
											WHERE sisps_tel=%s
											LIMIT 1', GtSQLVlStr($_no_sch,'text')
										);

					if($_p['cmmt']=='ok'){ //-- If use it on commit process --//
						$DtRg = $__cnx->_prc($query_DtRg);
					}else{
						$DtRg = $__cnx->_qry($query_DtRg);
					}

					if($DtRg){

						$row_DtRg = $DtRg->fetch_assoc();
						$Tot_DtRg = $DtRg->num_rows;

						if($Tot_DtRg > 0){

							if($Tot_DtRg == 1){
								$_v['e']='ok';
								$_v['id'] = $row_DtRg['id_sisps'];
								$_v['no'] = str_replace('+'.$_no_sch,'',$_p['no']);
							}

							break;
						}

					}else{

						if($_p['cmmt']=='ok'){ //-- If use it on commit process --//
							$_v['w'] = $__cnx->c_p->error.' on '.compress_code($query_DtRg);
						}else{
							$_v['w'] = $__cnx->c_r->error.' on '.compress_code($query_DtRg);
						}

					}

					$__cnx->_clsr($DtRg);
					$_chno--;

				}

			}

		}else{
			$_v['e']='no';
			$_v['w'] = 'No data for process';
		}

		return _jEnc($_v);

	}

	function _ChckCntHCntc($_p=NULL){

		global $__cnx;

		if($_p['id']){

			if($_p['t'] == 'enc'){ $__f = 'cnthcntc_enc'; }else{ $__f= 'cnthcntc_clhcntc'; }
			if($_p['cnt'] != ''){ $__fcnt = sprintf(' AND cnthcntc_cnt = %s', GtSQLVlStr($_p['cnt'],'int')); }
			if(!isN($_p['bd'])){ $__bdprfx=$_p['bd'].'.'; }

			$c_DtRg = "-1";if (isset($_p['id'])){$c_DtRg = $_p['id'];}
			$query_DtRg = sprintf('SELECT * FROM '.$__bdprfx.'cnt_h_cntc WHERE '.$__f.' = %s '.$__fcnt, GtSQLVlStr($c_DtRg,'text'));
			$DtRg = $__cnx->_qry($query_DtRg);
			$row_DtRg = $DtRg->fetch_assoc();
			$Tot_DtRg = $DtRg->num_rows;

			if($Tot_DtRg == 1){
				$_v['id'] = $row_DtRg['id_cnthcntc'];
				$_v['e']='ok';
				$_v['cnt'] = GtCntDt([ 'src_main'=> __FILE__ , 'bd'=> $_p['bd'] , 'id'=>$row_DtRg['cnthcntc_cnt'] ]);
			}else{
				$_v['e']='no';
			}

			$__cnx->_clsr($DtRg);
		}

		return _jEnc($_v);
	}

	function _ChckCntTpCntc($_p=NULL){

		global $__cnx;

		if($_p['id']){

			if($_p['t'] == 'enc'){ $__f = 'cnttpcntc_enc'; }else{ $__f= 'cnttpcntc_tp'; }
			if($_p['cnt'] != ''){ $__fcnt = sprintf(' AND cnttpcntc_cnt = %s', GtSQLVlStr($_p['cnt'],'int')); }
			if(!isN($_p['bd'])){ $__bdprfx=$_p['bd'].'.'; }

			$c_DtRg = "-1";if (isset($_p['id'])){$c_DtRg = $_p['id'];}
			$query_DtRg = sprintf('SELECT * FROM '.$__bdprfx.TB_CNT_TP_CNTC.' WHERE '.$__f.' = %s '.$__fcnt, GtSQLVlStr($c_DtRg,'text'));

			if($_p['cmmt']=='ok'){ //-- If use it on commit process --//
				$DtRg = $__cnx->_prc($query_DtRg);
			}else{
				$DtRg = $__cnx->_qry($query_DtRg);
			}

			if($DtRg){

				$_v['e']='ok';
				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;

				if($Tot_DtRg == 1){
					$_v['id'] = $row_DtRg['id_cnttpcntc'];
					$_v['cnt'] = GtCntDt([ 'bd'=> $_p['bd'] , 'id'=>$row_DtRg['cnttpcntc_cnt'], 'cmmt'=>$_p['cmmt'] ]);
				}

			}



			$__cnx->_clsr($DtRg);
		}

		return _jEnc($_v);
	}

	function _ChkCntBdIn($_p=NULL){

		global $__cnx;

		if($_p['id']){

			if($_p['t'] == 'enc'){ $__f = 'cntbd_enc'; }else{ $__f= 'cntbd_bd'; }
			if($_p['cnt'] != ''){ $__fcnt = sprintf(' AND cntbd_cnt = %s', GtSQLVlStr($_p['cnt'],'int')); }
			if(!isN($_p['bd'])){ $__bdprfx=$_p['bd'].'.'; }

			$c_DtRg = "-1";if (isset($_p['id'])){$c_DtRg = $_p['id'];}
			$query_DtRg = sprintf('SELECT id_cntbd FROM '.$__bdprfx.TB_CNT_BD.' WHERE '.$__f.' = %s '.$__fcnt, GtSQLVlStr($c_DtRg,'text'));

			if($_p['cmmt']=='ok'){ //-- If use it on commit process --//
				$DtRg = $__cnx->_prc($query_DtRg);
			}else{
				$DtRg = $__cnx->_qry($query_DtRg);
			}

			if($DtRg){

				$_v['e']='ok';
				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;

				if($Tot_DtRg == 1){
					$_v['id'] = $row_DtRg['id_cntbd'];
				}
			}



			$__cnx->_clsr($DtRg);
		}

		return _jEnc($_v);
	}


	function __MdlCntEst($_p=NULL){

		global $__cnx;

		if(!isN($_p['c']) && !isN($_p['e'])){

			if(!isN($_p['us'])){ $_q_us = $_p['us']; }else{ $_q_us = SISUS_ID; }
			if(!isN($_p['bd'])){ $__bdprfx = $_p['bd']."."; }else{ $__bdprfx = NULL; }

			$updateSQL_UPD = sprintf("UPDATE ".$__bdprfx.TB_MDL_CNT." SET mdlcnt_est=%s WHERE id_mdlcnt=%s",
			   GtSQLVlStr($_p['e'], "int"),
			   GtSQLVlStr($_p['c'], "int"));

			$Result_UPD = $__cnx->_prc($updateSQL_UPD);

			if($Result_UPD && $_p['no_upd'] != 'ok'){

					$__enc = Enc_Rnd($_p['c'].'-'.$_p['e']);

					$insertSQL = sprintf("INSERT INTO ". $__bdprfx. TB_MDL_CNT_EST ." (mdlcntest_enc, mdlcntest_mdlcnt, mdlcntest_est, mdlcntest_us) VALUES (%s, %s, %s, %s)",
								GtSQLVlStr($__enc, "text"),
								GtSQLVlStr($_p['c'], "int"),
								GtSQLVlStr($_p['e'], "int"),
								GtSQLVlStr($_q_us, "int"));

					$Result_IN = $__cnx->_prc($insertSQL);

					if($Result_IN){
						$r['e'] = 'ok';
					}else{
						$r['e'] = 'no'; $r['w'] = $__cnx->c_p->error;
					}
			}else{
				$r['p'] = 'No actualiza';
				$r['e'] = 'no';
				$r['w'] = $insertSQL.' -> '.$__cnx->c_p->error;
			}


			$_r = _jEnc($r);
			return($_r);
		}
	}


	function UPDus_Onl($p=NULL){

		global $__cnx;

		if( !isN($p['id']) ){
			$__id = $p['id'];
		}elseif( defined('SISUS_ENC') && !isN( SISUS_ENC ) ){
			$__id = SISUS_ENC;
		}

		if(isN($p['rst'])){
			$updateSQL = sprintf("UPDATE "._BdStr(DBM).TB_US." SET us_onl=%s WHERE us_enc=%s LIMIT 1", GtSQLVlStr(1, 'int'), GtSQLVlStr( $__id, 'text' ));
		}elseif($p['rst'] == 'ok'){
			$updateSQL = sprintf("UPDATE "._BdStr(DBM).TB_US." SET us_onl=%s WHERE us_enc=%s LIMIT 1", GtSQLVlStr(2, 'int'), GtSQLVlStr( $__id, 'text' ));
		}

		if(!isN($updateSQL)){

			$Result_UPD = $__cnx->_prc($updateSQL);
			if($Result_UPD){ $rsp['e'] = 'ok'; }else{ $rsp['e'] = 'no'; }

		}else{

			$rsp['e'] = 'no';
			$rsp['w'] = $__cnx->c_p->error;
			_ErrSis(['p'=>$insertSQL, 'd'=>$__cnx->c_p->error]);

		}

		return _jEnc($rsp);
	}


	function _Cht_Moji($text) {
	    $icons = [
			'svin'=> '<div class="_chat_icon _serviciosin"></div>',
			':|'  => '<div class="_chat_icon _mellow"></div>',
			':-|' => '<div class="_chat_icon _mellow"></div>',
			':-o' => '<div class="_chat_icon _ohmy"></div>',
			':-O' => '<div class="_chat_icon _ohmy"></div>',
			':o'  => '<div class="_chat_icon _ohmy"></div>',
			':O'  => '<div class="_chat_icon _ohmy"></div>',
			';)'  => '<div class="_chat_icon _wink"></div>',
			';-)' => '<div class="_chat_icon _wink"></div>',
			':p'  => '<div class="_chat_icon _tongue"></div>',
			':-p' => '<div class="_chat_icon _tongue"></div>',
			':P'  => '<div class="_chat_icon _tongue"></div>',
			':-P' => '<div class="_chat_icon _tongue"></div>',
			':D'  => '<div class="_chat_icon _biggrin"></div>',
			'8)'  => '<div class="_chat_icon _cool"></div>',
			'8-)' => '<div class="_chat_icon _cool"></div>',
			':)'  => '<div class="_chat_icon _smile"></div>',
			':-)' => '<div class="_chat_icon _smile"></div>',
			':('  => '<div class="_chat_icon _sad"></div>',
			':-(' => '<div class="_chat_icon _sad"></div>',
			':-D' => '<div class="_chat_icon _biggrind"></div>',
	    ];

	    return strtr($text, $icons);
	}


	function ChkEml_Rle($_p=NULL){

		global $__cnx;

		if(is_array($_p)){

			if(!isN($_p['e'])){

				$query_DtRg = sprintf("SELECT * FROM "._BdStr(DBM).TB_SIS_SLC." WHERE (%s LIKE CONCAT('%', sisslc_tt, '%')) AND sisslc_tp = '1' ", GtSQLVlStr( $_p['e'], 'text' ));
				$DtRg = $__cnx->_qry($query_DtRg);

				if($DtRg){

					$row_DtRg = $DtRg->fetch_assoc();
					$Tot_DtRg = $DtRg->num_rows;

					$Vl['tot'] = $Tot_DtRg;

					if($Tot_DtRg > 0){
						$Vl['id'] = $row_DtRg['id_sisslc'];
						$Vl['tx'] = ctjTx($row_DtRg['sisslctp_tt'],'in');
						$Vl['e'] = 'ok';
					}else{
						$Vl['e'] = 'no';
					}

				}

				$__cnx->_clsr($DtRg);

				return _jEnc($Vl);
			}
		}
	}



	function _iEtg($s=NULL){
		if($s != ''){
			if (strpos($s, '?') !== false){ $_c = '&'; }else{ $_c = '?'; }
			$_r = $s.$_c.'_etag='.E_TAG;
			return $_r;
		}
	}

	/* Ya no se necesita, filtros con nueva metodologia
	function _pFl($p=NULL){

		//$grp, $tp=''

		$sch = array(" ", "_");
		$_l1 = str_replace($sch,'',$p['g']);
		$Vr = explode(',',$_l1);
		$Vr_Tot = count($Vr);

			$Var .= '&___fl_s=ok';

			if($p['t'] == 'get'){
				for ($i = 0; $i <= $Vr_Tot; $i++) {
					$_l2 = str_replace("_",'',$Vr[$i]);
					if(($Vr[$i]!='')&&(strlen($Vr[$i]) > 2)&&
					   (
					   		( _GPJ(array('j'=>$__f_g,'v'=>'fl_'.$_l2)) !='')
					   )
					){
						$Var .= "&fl_".$Vr[$i]."="._GPJ(array('j'=>$__f_g,'v'=>'fl_'.$_l2));
					}


				}
			}else{
				for ($i = 0; $i <= $Vr_Tot; $i++) {
					if(($Vr[$i]!='')&&(strlen($Vr[$i]) > 2)){
						$Var .= '&fl_'.$Vr[$i]."=' + fl_".$Vr[$i]." + '";
					}
				}
			}

		return($Var);
	}
	*/

	function _pFl($p=NULL){
		$_v=_GPJ(['v'=>'fl']);
		return _jEnc($_v);
	}

	function _ChckCntHis($_p=NULL){

		global $__cnx;

		if($_p['mdlcnt'] != NULL && $_p['dsc'] != NULL){

			if($_p['mdlcnt'] != NULL){ $__fl .= ' AND mdlcnthis_mdlcnt = '.GtSQLVlStr($_p['mdlcnt'],'int'); }
			if($_p['dsc'] != NULL){ $__fl .= ' AND mdlcnthis_dsc = '.GtSQLVlStr( ctjTx($_p['dsc'], 'out') ,'text'); }

			$c_DtRg = "-1";if (isset($_p['id'])){$c_DtRg = $_p['id'];}
			$query_DtRg = sprintf('SELECT * FROM '.MDL_PRO_CNT_HIS_BD.' WHERE id_mdlcnthis != "" '.$__fl, GtSQLVlStr($c_DtRg,'text'));
			$DtRg = $__cnx->_qry($query_DtRg);
			$row_DtRg = $DtRg->fetch_assoc();
			$Tot_DtRg = $DtRg->num_rows;
			if($Tot_DtRg == 1){ $_v['id'] = $row_DtRg['id_mdlcnthis']; $_v['e']='ok'; }else{  $_v['e']='no'; }
		}

		$__cnx->_clsr($DtRg);

		return _jEnc($_v);
	}

	function _Fm_Fld($p=NULL){

			//if($p['key'] == 'Cnt_Cd'){ $__get_city = json_decode(KnGEO()); $_va = $__get_city->city; }
			if($p['key'] == 'Cnt_Doc'){
					if($p['rq'] == 1){ $_v_r = FMRQD_NM; }else{ $_v_r = FMRQD_NMR; }
			}elseif($p['key'] == 'Cnt_Eml'){
					if($p['rq'] == 1){ $_v_r = FMRQD_EM; }else{ $_v_r = FMRQD_EML; }
			}elseif($p['rq'] == 1){ $_v_r = FMRQD; }
			if($p['tt_es'] != '' || $p['tt_es'] != NULL){
				$_tdf = $p['tt_es'];
			}else{
				$_tdf = $p['tt'];
			}

			if($p['tp'] == 'text' || $p['tp'] == 'email'){
				$_r['html'] = _HTML_Input($p['key'].$p['rnd'], $_tdf, $_va, $_v_r, $p['tp']);
				$_r['html'] .= HTML_inp_hd($p['key'].'_Fld'.$p['rnd'], $p['fl']);
			}elseif($p['tp'] == 'radio'){
				$_r['html'] .= LsSisLndRdb($_tdf, $p['key'].$p['rnd'], $p['fl'], $p['lng']);
				$_r['html'] .= HTML_inp_hd($p['key'].'_Fld'.$p['rnd'], $p['fl']);
			}elseif($p['tp'] == 'lista'){
				$_r['html'] .= LsSisLndLst($p['key'].$p['rnd'], '', '1', $_tdf, $p['rq'], $p['fl']);
				$_r['html'] .= HTML_inp_hd($p['key'].'_Fld'.$p['rnd'], $p['fl']);
			}elseif($p['tp'] == 'textarea'){
				$_r['html'] .= '<div class="_ta_bx">'.HTML_textarea($p['key'].$p['rnd'], $_tdf, '', $p['rq'], 'ok' ,'' , 15 ,$p['max']).'</div>';
				$_r['html'] .= HTML_inp_hd($p['key'].'_Fld'.$p['rnd'], $p['fl']);
			}elseif($p['tp'] == 'separador'){
				$_r['html'] .= '<h2 class="spr_fld">'.$_tdf.'</h2>';
			}

			$rtrn = _jEnc($_r);
			return($rtrn);
	}

	function _Fm_Fld_B($p=NULL){
		if( $p['a'] != NULL){
			$_row = 1;

			if($p['lng'] != '' || $p['lng'] != NULL){ $_lng = 'tt_'.$p['lng']; }else{ $_lng = 'tt_es'; }

			foreach ($p['a'] as &$_v) {

				$_col=0; $_row_c='';

				foreach ($_v as &$_v2) {
					$_f = _Fm_Fld( ['tp'=>$_v2->tp, 'key'=>$_v2->key, 'rnd'=>$p['r'], 'tt'=>$_v2->tt, 'lng'=>$p['lng'], 'tt_es'=>$_v2->$_lng, 'rq'=>$_v2->rqr, 'fl'=>$_v2->id, 'chk_irv'=>$_v2->chk_irv, 'max'=>$_v2->max] );
					$_row_c .= '<div class="_c'.$_v2->ord.'">'. $_f->html .'</div>';
					$_r['js'] .= $_f->js;
					$_col++;
				}

				if($_row === 2){
					$_r['html'] .= $p['p'];
				}
				if($_row != 1){
					$__nod = 'style="display:none;"';
				}

				$_r['html'] .= '<div class="_ln cx'.$_col.'" '.$__nod.' id="blq_'.$_row.'">'.$_row_c.'</div>';


				$_row++;
			}

			$_r['row'] = $_row;


			$rtrn = _jEnc($_r);
			return($rtrn);
		}
	}

	function LsDmc($p=NULL){

		$_p = _jEnc($p);

		//-------------------- Codigo Pipe --------------------//
		if( !isN($_p->attr) ){

			if( !isN($p['attr_tp']) ){
				$_attr_tp = $p['attr_tp'];
			}else{
				$_attr_tp = "appl_attr";
			}

			$_appl_attr = __LsDt([ 'k'=>$_attr_tp ]);
			if(defined('SISUS_ID') && SISUS_ID == 181){
				//echo json_encode($_appl_attr);
			}

			if( !isN($_appl_attr->ls->{$_attr_tp}->{$_p->attr}->key_tb->vl) ){ //Tabla de base de datos

				$_attr_vl = $_appl_attr->ls->$_attr_tp->{$p['attr']}->key_tb->vl;

				if($_attr_vl == 'LsCd'){

					if( $_p->tp == 'dt' ){
						$_r['tt'] = GtCdDt(['tp'=>'id', 'id'=>$_p->id])->tt;
					}else{
						$_r['html'] = LsCdOld(['id'=>$_p->id, 'v'=>'id_siscd', 'va'=>$_p->va, 'rq'=>$_p->rq, 'nm'=>$_p->nm, 'ph'=>$_p->ph, ]);
					}

				}elseif($_attr_vl == 'LsLng'){


					if( $_p->tp == 'dt' ){
						$_r['tt'] = GtLngLs([ 'id'=>$_p->id ])->tt;
					}else{
						$_r['html'] = LsLng(['id'=>$_p->id, 'v'=>'id_sislng', 'va'=>$_p->va, 'rq'=>$_p->rq, 'nm'=>$_p->nm, 'ph'=>$_p->ph, ]);
					}

				}elseif($_attr_vl == 'LsPs'){

					if( $_p->tp == 'dt' ){
						$_r['tt'] = GtPsDt([ 'tp'=>'id', 'v'=>$_p->id ])->tt;
					}else{
						$_r['html'] = LsSis_PsOLD($_p->id, 'id_sisps', $_p->va, $_p->ph , $_p->rq, '' , '', '' , [ 'nm'=>$_p->nm ]);
					}

				}elseif($_attr_vl == 'LsMdl'){

					if( $_p->tp == 'dt' ){
						$_r['tt'] = GtMdlDt([ 'id'=>$_p->id ])->tt;
					}else{
						$_r['html'] = LsMdl($_p->id, 'mdl_enc', $_p->va, $_p->ph , $_p->rq, '', [ 'mdlmdl_main'=>$_p->mdl ]);
					}

				}elseif($_attr_vl == 'LsSisCntTp'){

					if( $_p->tp == 'dt' ){
						$_r['tt'] = GtCntTpDt([ 'id'=>$_p->id ])->tt;
					}else{
						$_r['html'] = LsSisCntTp(['id'=>$_p->id,'v'=>'id_siscnttp', 'va'=>$_p->va,'rq'=>$_p->rq,'ph'=>$_p->ph,'cl'=>( (!isN($_p->cl))? $_p->cl : CL_ENC ), 'nm'=>$_p->nm]);
					}

				}elseif($_attr_vl == 'LsOrgUni'){

					if( $_p->tp == 'dt' ){
						$_r['tt'] = GtOrgDt([ 'i'=>$_p->id ])->nm;
					}else{
						$_r['html'] = LsOrg($_p->id, 'id_org', $_p->va, $_p->ph, $_p->rq, 'uni', '', '', [ 'nm'=>$_p->nm ]);
					}

				}

				$_r['js'] = JQ_Ls($_p->id, $_p->ph);
				$_r['e'] = "ok";

			}else if( !isN($_appl_attr->ls->{$_attr_tp}->{$_p->attr}->ls->vl) ){ //Lista de sistema

				$_attr_vl = $_appl_attr->ls->{$_attr_tp}->{$_p->attr}->ls->vl;

				if( $_p->tp == 'dt' ){

					$l = __LsDt([ 'id'=>$_p->id ]);
					$_r['tt'] = $l->d->tt;

				}else{

					$l = __Ls([ 'cl'=>$_p->cl,
							'fcl'=>$_p->fcl,
							'n'=>$_p->nm,
							'idt'=>$_attr_vl,
							'lbl'=>'ok',
							'f'=>$_p->rto,
	            			'id'=>$_p->id,
	            			'ph'=>$_p->ph,
	            			'rq'=>$_p->rq,
	            			'va'=>$_p->va,
	            		]);
					$_r['html'] = $l->html;
					$_r['js'] = $l->js;

				}

				$_r['e'] = "ok";

			}else{
				$_r['e'] = "no";
			}
		//-------------------- Codigo Pipe --------------------//
		}else{

			//-------------------- Codigo Lady --------------------//
			if( $_p->data == 'Tb' ){

				if($_p->tp == 'LsCd'){

					$_r['html'] = LsCdOld(['id'=>$_p->id, 'v'=>'id_siscd', 'va'=>'', 'rq'=>$_p->rq, 'nm'=>$_p->nm, 'ph'=>$_p->ph, 'oth'=>$_p->oth]);
					$_r['js'] = JQ_Ls($_p->id, $_p->ph);

				}elseif($_p->tp == 'LsLng'){

					$_r['html'] = LsLng(['id'=>$_p->id, 'v'=>'id_sislng', 'va'=>'', 'rq'=>$_p->rq, 'nm'=>$_p->nm, 'ph'=>$_p->ph ]);
					$_r['js'] = JQ_Ls($_p->id, $_p->ph);

				}elseif($_p->tp == 'LsPs'){

					$_r['html'] = LsSis_PsOLD($_p->id, 'id_sisps', '', $_p->ph , $_p->rq, '' , '', '' , [ 'nm'=>$_p->nm ]);
					$_r['js'] = JQ_Ls($_p->id, $_p->ph);

				}elseif($_p->tp == 'LsMdl'){

					$_r['html'] = LsMdl($_p->id, 'mdl_enc', '', $_p->ph , $_p->rq, '',
									[ 'tp_k'=>$_p->flt_tp,

										'mdlmdl_main'=>$_p->mdl,
										'mdl_exc'=>$_p->flt_exc,
										'shw_attr'=>[ $_p->vl_adc ]

									]);
					$_r['js'] = JQ_Ls($_p->id, $_p->ph);

				}elseif($_p->tp == 'LsSisCntTp'){

					$_r['html'] = LsSisCntTp(['id'=>$_p->id,'v'=>'id_siscnttp','rq'=>$_p->rq,'ph'=>$_p->ph,'cl'=>$_p->cl,'nm'=>$_p->nm]);
					$_r['js'] = JQ_Ls($_p->id, $_p->ph);

				}elseif($_p->tp == 'LsOrgUni'){

					$_r['html'] = LsOrg($_p->id, 'id_org', '', $_p->ph, $_p->rq, 'uni', '', '', [ 'nm'=>$_p->nm ]);
					$_r['js'] = JQ_Ls($_p->id, $_p->ph);

				}

			}elseif( $_p->data == 'Ls' ){

				$l = __Ls([ 'cl'=>$_p->cl,
							'fcl'=>$_p->fcl,
							'n'=>$_p->nm,
							'idt'=>$_p->tp,
							'lbl'=>'ok',
							'f'=>$_p->rto,
	            			'id'=>$_p->id,
	            			'ph'=>$_p->ph,
	            			'rq'=>$_p->rq
	            		]);

	            $_r['html'] = $l->html;
	            $_r['js'] = $l->js;

			}
			//-------------------- Codigo Lady --------------------//

		}

		$rtrn = _jEnc($_r);
		return($rtrn);
	}

	function GtClTexLng($lng){

		global $__cnx;

		$Ls_Sis = $__cnx->_qry($Sis_Qry);

		if($Ls_Sis){

			$row_Ls_Sis = $Ls_Sis->fetch_assoc(); $Tot_Ls_Sis = $Ls_Sis->num_rows;
			if($lng != '' || $lng != NULL){ $_lng = $lng; }else{ $_lng = 'es'; }
			if($Tot_Ls_Sis > 0){
				do {
					define($row_Ls_Sis['sistex_var'], ctjTx($row_Ls_Sis['sistex_vl_'.$_lng],'in'));
				} while ($row_Ls_Sis = $Ls_Sis->fetch_assoc()); $_r = true;
			}else{ $_r = false; }

		}

		$__cnx->_clsr($Ls_Sis);

		return($_r);
	}


	function _myURL() {
		 $pageURL = 'http';
		 if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
		  		$pageURL .= "://";
		 if ($_SERVER["SERVER_PORT"] != "80") {
		  		$pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
		 }else{
		  		$pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
		 }
		 return $pageURL;
	}

	// Analytics
	function TagMgr($_id='GTM-KM6TCM'){
		return('<!-- Google Tag Manager -->
<noscript><iframe src="//www.googletagmanager.com/ns.html?id=GTM-P6V8DC"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<script data-cfasync=\"false\">(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({\'gtm.start\':
new Date().getTime(),event:\'gtm.js\'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!=\'dataLayer\'?\'&l=\'+l:\'\';j.async=true;j.src=
\'//www.googletagmanager.com/gtm.js?id=\'+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,\'script\',\'dataLayer\',\''.$_id.'\');</script>
<!-- End Google Tag Manager -->');
	}

	function Fb_PbObj($p=NULL){

		if($p['id'] != NULL){ $_id = $p['id']; }else{ $_id = '669801116457723'; }
		$_r = '<!-- Facebook Pixel Code -->
						<script data-cfasync=\"false\">
						!function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod?
						n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!f._fbq)f._fbq=n;
						n.push=n;n.loaded=!0;n.version="2.0";n.queue=[];t=b.createElement(e);t.async=!0;
						t.src=v;s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)}(window,
						document,"script","//connect.facebook.net/en_US/fbevents.js");

						fbq("init", "'.$_id.'");
						fbq("track", "PageView");</script>
						<noscript><img height="1" width="1" style="display:none"
						src="https://www.facebook.com/tr?id='.$_id.'&ev=PageView&noscript=1"
						/></noscript>
				<!-- End Facebook Pixel Code -->';

		return($_r);
	}

	function CrmAnl(){
		$_r = "(function(w,d,s,l){
					var f=d.getElementsByTagName(s)[0], j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';
					j.async=true;
					j.src= '".DMN_CK."gtm.js';
					f.parentNode.insertBefore(j,f);}
				)(window,document,'script','dataLayer');";
		return($_r);
	}

	function _Mn_Logo(){
		$_h = '<div class="logo" id="__logo">
			   		<div class="_w">
			   			<div class="cl_logo" style="background-image: url('.DMN_FLE_CL_LGO.CL_ENC.'.svg); "></div>
			   		</div>
			   </div>';
		return $_h;
	}


	function _Mn_Logo_S($p=NULL){

		if(!isN($p['rsllr']) && $p['rsllr']->e == 'ok'){ $_sbcls = 'rsllr'; }
		if(!isN($p['rsllr']) && !isN($p['rsllr']->lgo->rsllr->big)){ $_rsllr = $p['rsllr']->lgo->rsllr->big; }

		$_h = '<li class="sis_brand '.$_sbcls.' _anm"><div class="sumr_logo"></div><div class="rsllr_logo" style="background-image:url('.$_rsllr.');"></div></li>';

		return $_h;
	}

	function __b_tbd($_d=NULL, $_o=NULL){

        $_d = (object) $_d;
        $_o = (object) $_o;

        $_id_tbpnl = 'TabPnl_'.Gn_Rnd(20);
        $_id_cvr= 'TabCvr'.Gn_Rnd(20);

        $rtrn['id'] = $_id_tbpnl;

        if($_o->frst == 'ok'){
        	$__tb_t = '<li class="TabbedPanelsTab" style="display: none;"></li>';
			$__tb_c = '<section class="_cvr" style="background-color:#2d363c;" id="'.$_id_cvr.'">
		        			<iframe src="'.DMN_ANM.'sistema/index.html" frameborder="0" width="100%" scrolling="no" height="200"></iframe>
						</section>';
        }


        foreach($_d as $_k){

            $_v = (object)$_k;
            $___tdup='';

            $__id_rnd = '_'.$_v->id;
            $__id_tb = '';

            if( $_v->tb != NULL ){
                $__id_tb = ' id="'.TBGRP.$_v->tb.$__id_rnd.'" ';
            }else if( $_v->tbs != NULL ){
                $__id_tb = ' id="'.TBGRP.$_v->tbs.$__id_rnd.'" ';
            }


            if(!isN($_v->icn)){ $_icn = $_v->icn; }else{ $_icn = 'strt'; }

            $__tb_t .= '<li class="TabbedPanelsTab"'.$__id_tb.' title="'.$_v->id.'">
                            '.Spn('','','_tt_icn ','background-image:url(\''.$_v->img.'\');').$___tdup.Spn($_v->tt,'','_tx').'
                        </li>';

            if( !isN($_v->tb) ){

                $rtrn['js'] .=  _DvLsFl_Vr([
                								'n'=>$_v->tb.$__id_rnd,
                								'tp'=>$_v->tcnt,
                								't'=>($_v->tp!=NULL?$_v->tp:$_v->tb),
                								't2'=>(!isN($_v->tbs_go_s)?$_v->tbs_go_s:''),
                								'sis'=>(!isN($_v->tbs_sis)?'ok':''),
                								'i'=>$_v->id,
                								'm'=>$_v->lm
                						]);

                $rtrn['js'] .=  _DvLsFl([ 'i'=>$_v->tb.$__id_rnd, 'h'=>$_v->h ]);

                if($_v->l == 'ok'){ $rtrn['js'] .= _DvLsFl([ 'i'=>$_v->tb.$__id_rnd, 't'=>'s' ]); }

            }elseif($_v->tbs != NULL){

                $rtrn['js'] .=  _DvLsFl([ 'i'=>$_v->tbs.$__id_rnd, 'g'=>$_v->tbs_go.$__id_rnd, 'h'=>$_v->h ]);

            }

            if(!isN($_v->sb)){
                $_gt = __b_tbd( $_v->sb, ['scnd'=>'ok'] );
                $_dv = $_gt->html;
                $rtrn['js'] .= $_gt->js;
            }else{
                $_dv = bdiv([ 'id'=>DV_LSFL.$_v->tb.$__id_rnd, 'cls'=>'_sbls' ]);
            }

            $__tb_c .= '<div class="TabbedPanelsContent">
                            <div class="ln">'.$_dv.'</div>
                        </div>';
        }


        if($_o->mny == 'ok'){ $__b_clss = 'mny'; }

        $rtrn['html'] = '<div id="'.$_id_tbpnl.'" class="_anm VTabbedPanels '.$__b_clss.'">
                              <ul class="TabbedPanelsTabGroup">'.$__tb_t.'</ul>
                              <div class="TabbedPanelsContentGroup">'.$__tb_c.'</div>
                         </div>';

        $rtrn['js'] .= " SUMR_Main.bxajx.".$_id_tbpnl." = new Spry.Widget.TabbedPanels('".$_id_tbpnl."', {defaultTab:0}); ";


        if($_o->frst == 'ok'){

			$rtrn['js'] .= "

							SUMR_Main.bxajx.".$_id_tbpnl."__cvr = $('#".$_id_cvr."');
							SUMR_Main.bxajx.".$_id_tbpnl."__cvr_if = $('#".$_id_cvr." iframe');

							$('#".$_id_tbpnl." .TabbedPanelsTab').on('click', function(e){

								if( !isN(SUMR_Main.bxajx.".$_id_tbpnl."__cvr)){

									setTimeout(function(){

										if(SUMR_Main.bxajx.".$_id_tbpnl."__cvr.length > 0){
											SUMR_Main.bxajx.".$_id_tbpnl."__cvr.delay(300).show();
											$('#".$_id_tbpnl."').addClass('_cmpct');

											if( SUMR_Main.bxajx.".$_id_tbpnl."__cvr_if.length){
												SUMR_Main.bxajx.".$_id_tbpnl."__cvr_if.height(130);
											}
										}

									}, 100);

								}

							}); " ;

        }


        return( (object)$rtrn );
    }

	function _mJi($_t=NULL){
		$html = preg_replace("/\\\\u([0-9A-F]{2,5})/i", "&#x$1;", $_t);
		return $html;
	}


	function __f($d=''){
		if($d != ''){ $_m = $d.'/'; }
		$r = DR_FL.$_m;
		return $r;
	}

	function __popd($p=''){

		$__c_o = '<div class="pop_cnt">'.bdiv([ 'id'=>ICN_LDR_POP ]);
		$__c_c = '</div>';

		if((($p['notw']!='ok' && $p['c']->fpop()) || $p['show'] ) && $p['t']=='o'){ return $__c_o; }
		elseif((($p['notw']!='ok' && $p['c']->fpop()) || $p['show'] ) && $p['t']=='c'){ return $__c_c; }

	}


	function CG_Array($p=NULL){

		$___col = json_decode( _jBty([ 'v'=>'['.$p['f'].']' ]) , true);

		foreach($___col as $k=>$v){
			foreach($v as $k2=>$v2){
				$__col_bld[$v[ $p['k'] ]][$k2] = $v2;
			}
		}

		return _jEnc($__col_bld);
	}



	function UPD_Thrd($p=NULL){

		global $__cnx;

		$updateSQL = sprintf("UPDATE "._BdStr(DBM).TB_SIS_THIRD." SET sisthird_status=%s, sisthird_fa=%s WHERE id_sisthird=%s",
								GtSQLVlStr($p['status'], "text"),
								GtSQLVlStr(SIS_F2.' '.SIS_H2, "date"),
								GtSQLVlStr($p['id'], "int"));

		if($updateSQL != ''){

			$Result_UPD = $__cnx->_prc($updateSQL);
			if($Result_UPD){ $rsp['e'] = 'ok'; }else{ $rsp['e'] = 'no'; }

		}else{
			$rsp['e'] = 'no';
			$rsp['w'] = $__cnx->c_p->error;
			_ErrSis(['p'=>$insertSQL, 'd'=>$__cnx->c_p->error]);
		}
		$rtrn = json_decode(json_encode($rsp));
		if(!isN($rtrn)){ return($rtrn); }

	}


	function _SveSngImg($_p=NULL){

        $_v['e'] =  $url = DMN_GOO.'/save/sgn/'.$_p['id'];

        /*try{
            if($_p['id'] != NULL){
                $url = DMN_GOO.'/save/ec/'.$_p['id'];
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0 );
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $__c_r = json_decode( curl_exec($ch) );
                curl_close($ch);

                if($__c_r->e == 'ok'){
                    $_v['e'] = 'ok';
                }
            }else{
                $_v['e'] = 'no';
                $_v['w'] = 'No envia ID';
            }
        }catch (Exception $e) {
            $_v['e'] = 'no';
            $_v['w'] = $e->getMessage();
        }*/

        $_r = _jEnc($_v);
        return $_r;
    }


	function Chk_EmlRle($_p=NULL){


		if(!isN($_p['eml'])){

			$__dmn = explode('@', $_p['eml']);

			$__rle = __LsDt([ 'k'=>'eml_rle' ]);

			foreach($__rle->ls->eml_rle as $__rle_k=>$__rle_v){

				$_s_cmpr = strtolower($__rle_v->tt);

				if(strpos( strtolower($__dmn[1]), $_s_cmpr) !== false){
				    $_v['e'] = 'ok';
				    break;
				}else{
					$_v['e'] = 'no';
				}

			}

		}

		return _jEnc($_v);

	}




	function _FxMdlBdTp($m=NULL,$t=NULL){
		$_sgm = explode('_',$m); $i=1; $_new='';

		if(count($_sgm) > 1 && !isN($t)){
			foreach($_sgm as $k=>$v){
				if(!isN($_new)){ $_new .= '_'; }
				if($i==1 && $v=='mdl'){ $v = str_replace('mdl', $t, $v); }
				$_new .= $v;
				$i++;
			}
		}else{
			$_new = $m;
		}
		return $_new;
	}



	function _SvCkTrck($p=NULL){

		global $__cnx;
		global $__dt_cl;

		$_v['e'] = 'no';

		if(!isN($p['id']) && !isN($p['c']) && !isN($p['u'])){

			if(isN($__dt_cl)){ $__dt_cl = GtClDt( $p['id'], 'prfl' ); }

			if($p['m'] != NULL && $p['m'] != 0){ $_q_m = $p['m']; }else{ $_q_m = NULL; }

			if(!isN( $__dt_cl->id )){

				$browser = new Browser();
				$IpUs = KnIp("on");

				$_brws_pltf = $browser->getPlatform();
				$_brws_n = $browser->getBrowser();
				$_brws_v = $browser->getVersion();
				$_dsp = LgnDsp();

				$insertSQL = sprintf("INSERT INTO ".DB_PRFX_CL."".$__dt_cl->sbd.".".TB_CNT_CK_TRCK." (cntcktrck_ck, cntcktrck_tt, cntcktrck_url, cntcktrck_m, cntcktrck_ip, cntcktrck_dsp, cntcktrck_b_p, cntcktrck_b_t, cntcktrck_b_v) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s)",
									   GtSQLVlStr($p['c'], "text"),
									   GtSQLVlStr(ctjTx($p['t'], 'out'), "text"),
									   GtSQLVlStr($p['u'], "text"),
									   GtSQLVlStr($_q_m, "text"),
									   GtSQLVlStr($IpUs, "text"),
									   GtSQLVlStr($_dsp, "text"),
									   GtSQLVlStr($_brws_pltf, "text"),
									   GtSQLVlStr($_brws_n, "text"),
									   GtSQLVlStr($_brws_v, "text"));

				$Result = $__cnx->_prc($insertSQL); $_v['w'] = $__cnx->c_p->error;
				if($Result){ $_v['e'] = 'ok'; }

			}
		}

		return _jEnc($_v);
	}


	function __CkCod($p=NULL){

		$_cod = "

			<!-- Tracking Site - SUMR CRM -->
			<script data-cfasync=\"false\">

				(function(w,d,s,l){
					var f=d.getElementsByTagName(s)[0], j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';
					j.async=true;
					j.src= '".DMN_CK."main.js?id=".$p['prfl']."';
					f.parentNode.insertBefore(j,f);
				})(window,document,'script','dataLayer');

			</script>

		";

		return $_cod;

	}


	function __WdgtCod($p=NULL){

		if($p['async']=='ok'){ $_async='j.async=true;'; }
		if($p['notag']!='ok'){
			$_cod_o = "<!-- Widget - SUMR CRM --><script>";
			$_cod_c = "</script>";
		}

		$_cod = $_cod_o."(function(w,d,s,l,i){ var f=d.getElementsByTagName(s)[0], j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:''; ".$_async." j.src='".DMN_JS."wdgt/'+i+'.js'; f.parentNode.insertBefore(j,f); })(window,document,'script','dataLayer','".$p['id']."');".$_cod_c;

		return $_cod;

	}


	function LsNum($__id, $__cant, $__rq=NULL){
		if($__id!=''){
			$LsBld .= HTML_OpVl(['ct'=>'off']);
			for($i = 1; $i <= $__cant; $i++){
				$LsBld .= HTML_OpVl(['t'=>$i, 'v'=>$i]);
			}
			$_rtrn2 = bdiv(['c'=>HTML_Slct(['id'=>$__id, 'ph'=>TX_NMCLMNS, 'rq'=>$__rq, 'c'=>$LsBld]), 'cls'=>$_cls]);
			return($_rtrn2);
		}
	}


    function _GtUrl_Img($_p=NULL){

		$_v['e'] = 'no';

		try{

			$url = 'https://www.googleapis.com/pagespeedonline/v5/runPagespeed?url='.$_p['u'].'&strategy=mobile&screenshot=true&key=AIzaSyCz2vfUPpsgYFdqxtGi5xtRtYJ8OQx9-sM';
			$ch = curl_init();

			$_v['url'] = $url;

			curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 500);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0 );
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_TIMEOUT_MS, 20000);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

			$__exc = curl_exec($ch); //print_r( json_decode($__exc) /*['lighthouseResult']['audits']['final-screenshot']*/ ); exit();
			curl_close($ch);
			$__c_r = json_decode($__exc);

			if(!isN($__c_r)){
				$_v['e'] = 'ok';
				$_v['data'] = $__c_r->lighthouseResult->audits->{'final-screenshot'}->details->data;
			}

		}catch (Exception $e) {
		    $_v['w'] = $e->getMessage();
		}

		return _jEnc($_v);
	}

	// Convertir en Keywords con Coma
	function __kyw($Str){
		if($Str != ''){
			$All = strip_tags(trim(MyMn($Str)));
			$TxFn = strtolower(str_replace($Sch,$Chn,$All));
			$TxFn = preg_replace("/s(w+s)1/i", "$1", $TxFn);
			$TxFn = preg_replace('/[^a-zA-Z]/', ',', $TxFn);
			$TxFn = str_replace($Sch,',',$TxFn);
			$TxFn = explode(',', $TxFn);
			foreach($TxFn as $valor){
				$caracteres = strlen($valor);
				if($caracteres > 5){
					$etiquetas[] = $valor;
				}
			}
			return(implode(',', array_unique($etiquetas)));
		}
	}


	function _anl($_i=1){
		$_scrp = "
				<!-- Global site tag (gtag.js) - Google Analytics -->
				<script async src=\"https://www.googletagmanager.com/gtag/js?id=UA-120392890-".$_i."\"></script>
				<script>
				  window.dataLayer = window.dataLayer || [];
				  function gtag(){dataLayer.push(arguments);}
				  gtag('js', new Date());

				  gtag('config', 'UA-120392890-".$_i."');
				</script>

				";
		return($_scrp);
	}


    function _href($_u){
		$browser = new Browser();
		if($browser->getBrowser() != 'Firefox'){
			$_bld = 'href="javascript:void(0); return false" onclick="'.$_u.'" ';
		}else{
			$_bld = 'href="javascript:void(0); return false" onclick="'.$_u.'" ';
		}
		return($_bld);
	}


	function _onl_isbot(){  /* This function will check whether the visitor is a search engine robot */
		$botlist = ["Teoma", "alexa", "froogle", "Gigabot", "inktomi",
		"looksmart", "URL_Spider_SQL", "Firefly", "NationalDirectory",
		"Ask Jeeves", "TECNOSEEK", "InfoSeek", "WebFindBot", "girafabot",
		"crawler", "www.galaxy.com", "Googlebot", "Scooter", "Slurp",
		"msnbot", "appie", "FAST", "WebBug", "Spade", "ZyBorg", "rabaz",
		"Baiduspider", "Feedfetcher-Google", "TechnoratiSnoop", "Rankivabot",
		"Mediapartners-Google", "Sogou web spider", "WebAlta Crawler","TweetmemeBot",
		"Butterfly","Twitturls","Me.dium","Twiceler"];
		foreach($botlist as $bot){
			if(strpos($_SERVER['HTTP_USER_AGENT'],$bot)!==false)
			return true;
		}
			return false;
	}

	//Obtener Usuarios Online
	function _onl_tot($_i){

		global $__cnx;

		if($_i != ''){
			$c_DtRg = "-1"; if (isset($_i)){$c_DtRg = $_i;}
			$query_DtRg = sprintf('SELECT COUNT(*) AS _tot FROM '.TB_EC_ONL.' WHERE econl_idobj = %s', GtSQLVlStr($c_DtRg, 'int'));
			$DtRg = $__cnx->_qry($query_DtRg);

			if($DtRg){
				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;
				if($row_DtRg['_tot'] > 0){ $_v = $row_DtRg['_tot']; }else{ $_v = 1; } return($_v);
			}

			$__cnx->_clsr($DtRg);

		}
	}

	//Obtener IP online
	function _onl_IP($_i, $_i_o){

		global $__cnx;

		if(($_i!='') && ($_i_o!='')){
			$c_DtRg = "-1";if (isset($_i)){$c_DtRg = $_i;}
			$query_DtRg = sprintf('SELECT * FROM '.TB_EC_ONL.' WHERE econl_ip = %s AND econl_idobj = '.$_i_o, GtSQLVlStr($c_DtRg, 'int'));
			$DtRg = $__cnx->_qry($query_DtRg);

			if($DtRg){
				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;
				if($Tot_DtRg > 0){ $_v = true; }else{ $_v = false; } return($_v);
			}

			$__cnx->_clsr($DtRg);

		}
	}


	function _Hs_GET($p=NULL){
		$_url = $p['u'];
		if (strpos($_url, '?') !== false) { $_r = 'ok'; }else{ $_r = 'no'; }
		return $_r;
	}



	function _IfBld($p=null){

		if(!isN($p['id']) && !isN($p['cl'])){

			if($p['opq']=='ok'){ $__url_attr .= '&opaque=ok'; }
			if($p['icn']=='ok'){ $__url_attr .= '&icon=ok'; }
			if(!isN($p['w'])){ $__url_attr .= '&w='.$p['w']; }else{ $__url_attr .= '&w=100%'; }


			$__if_attr_async .= 'data-cfasync="false"';
			if($p['g']=='ok'){ $__mgen = '&g=ok'; }

			$__cod['html'] = "<!-- Form - SUMR CRM --><iframe id='SUMR-FM-".$p['id']."' ".$__if_attr." border='0'></iframe>";
			$__cod['js'] = "<script ".$__if_attr_async.">(function(w,d,s,l){ var f=d.getElementsByTagName(s)[0], j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:''; j.async=true; j.src= '".DMN_JS."mdl/b.js?f=".$p['id']."&id=".$p['cl'].$__mgen.$__url_attr."'; f.parentNode.insertBefore(j,f); })(window,document,'script','dataLayer');</script>";
			$__cod['all'] = $__cod['html'].$__cod['js'];

			return(_jEnc($__cod));

		}

	}



	function _MdlTx($_t=NULL){

		$_sub = Php_Ls_Cln($_GET['_t2']);
		$_mdl = 'MDL_S_TP_'.strtoupper($_sub);
		$_mdlo = 'MDL_'.strtoupper($_sub);


		if(defined($_mdl)){
			$_tx = str_replace('[MODULO]', constant($_mdl),$_t);
		}elseif(defined($_mdlo)){
			$_tx = str_replace('[MODULO]', constant($_mdlo),$_t);
		}else{
			$_tx = $_t;
		}

		return $_tx;
	}


	function _FleN($p=NULL){

		$_fl_tt = $p['tt'];
		$__tget = '?__t=inf';
		$_fl_dt = date('h-i-s-j-m-y');

		$__nw['tt'] = str_replace(' ','-',$_fl_tt).$_fl_dt;
		$__nw['tt_pxls'] = str_replace(' ','-',$_fl_tt).$_fl_dt;
		$__nw['tt_csv'] = str_replace(' ','-',$_fl_tt).$_fl_dt;
		$__nw['tt_bty'] = str_replace(' ',' ',$_fl_tt);

		return(_jEnc($__nw));
	}


	function GtSisNoi($p=NULL){

		global $__cnx;

		if(!isN($p['cl'])){ $__fl .= " AND siscntnoi_cl = '".$p['cl']."' " ; }

		$query_DtRg = "SELECT * FROM "._BdStr(DBM).TB_SIS_CNT_NOI." WHERE id_siscntnoi != '' ".$__fl;
		$DtRg = $__cnx->_qry($query_DtRg);

		if($DtRg){

			$row_DtRg = $DtRg->fetch_assoc();
			$Tot_DtRg = $DtRg->num_rows;

			do{

				$Vl[$row_DtRg['id_siscntnoi']]['id'] = $row_DtRg['id_siscntnoi'];
				$Vl[$row_DtRg['id_siscntnoi']]['nm'] = ctjTx($row_DtRg['siscntnoi_nm'],'in');
				$Vl[$row_DtRg['id_siscntnoi']]['sub'] = $row_DtRg['siscntnoi_prnt'];

			} while ($row_DtRg = $DtRg->fetch_assoc());

		$__cnx->_clsr($DtRg);

		}

		$rtrn = _jEnc($Vl);
		return  $rtrn;
	}



	function GtAllProCntNoi($_p=NULL){
		if($_p['noi'] != NULL && $_p['obj'] != NULL){

			foreach($_p['obj'] AS $_k => $_v){
				if($_v->sub != '' && $_k == $_p['noi']){
					$_i = 1;
					$_c = 5;
					$Vl[$_i] = ['tt'=>$_v->nm, 'pos'=>$_c];
					foreach($_p['obj'] AS $_k2 => $_v2){
						if($_k2 == $_v->sub){
							$_i = 2;
							$_c = 4;
							$Vl[$_i] = ['tt'=>$_v2->nm, 'pos'=>$_c];
							foreach($_p['obj'] AS $_k3 => $_v3){
								if($_k3 == $_v2->sub){
									$_i = 3;
									$_c = 3;
									$Vl[$_i] = ['tt'=>$_v3->nm, 'pos'=>$_c];
									foreach($_p['obj'] AS $_k4 => $_v4){
										if($_k4 == $_v3->sub){
											$_i = 4;
											$_c = 2;
											$Vl[$_i] = ['tt'=>$_v4->nm, 'pos'=>$_c];
											foreach($_p['obj'] AS $_k5 => $_v5){
												if($_k5 == $_v4->sub){
													$_i = 5;
													$_c = 1;
													$Vl[$_i] = ['tt'=>$_v5->nm, 'pos'=>$_c];
												}
											}
										}
									}
								}
							}
						}
					}
				}
			}
		return $Vl;
		}
	}

	function __org_noi($_arr=NULL){
		foreach($_arr as $_k => $_v){
			$__nw[] = $_v['tt'];
		}
		return $__nw;
	}

	function _SrtAsc($array, $on, $order=SORT_ASC){
		$new_array = [];
	    $sortable_array = [];

	    if (count($array) > 0) {
	        foreach ($array as $k => $v) {
	            if (is_array($v)) {
	                foreach ($v as $k2 => $v2) {
	                    if ($k2 == $on) {
	                        $sortable_array[$k] = $v2;
	                    }
	                }
	            } else {
	                $sortable_array[$k] = $v;
	            }
	        }

	        switch ($order) {
	            case SORT_ASC:
	                asort($sortable_array);
	                break;
	            case SORT_DESC:
	                arsort($sortable_array);
	                break;
	        }

	        foreach ($sortable_array as $k => $v) {
	            $new_array[$k] = $array[$k];
	        }
	    }

	    return $new_array;
	}

	function IFrm($p=NULL){

		if($p['sty']!= ''){ $_sty = $p['sty']; }
		if($p['w']!= ''){ $_w = $p['w']; }
		if($p['h']!= ''){ $_h = $p['h']; }

		return "<iframe width='".$_w."' height='".$_h."' style='".$_sty."' src='".$p['url']."'></iframe>";

	}

	function _WkDays(){
		$days[1] = ['id'=>1, 'tt'=>'Lunes', 'sgl'=>'L'];
		$days[2] = ['id'=>2, 'tt'=>'Martes', 'sgl'=>'M'];
		$days[3] = ['id'=>3, 'tt'=>'Miércoles', 'sgl'=>'M'];
		$days[4] = ['id'=>4, 'tt'=>'Jueves', 'sgl'=>'J'];
		$days[5] = ['id'=>5, 'tt'=>'Viernes', 'sgl'=>'V'];
		$days[6] = ['id'=>6, 'tt'=>'Sábado', 'sgl'=>'S'];
		$days[7] = ['id'=>7, 'tt'=>'Domingo', 'sgl'=>'D'];

		return _jEnc($days);
	}



	function UPDCntEml_Cld($p=NULL){

		global $__cnx;

		if(!isN($p['id']) && !isN($p['cld'])){


			//-------------------- DETALLES ACTUALES --------------------//

				if(!isN($p['bd'])){ $__bdprfx=_BdStr($p['bd']); }
				$_now_dt = GtCntEmlDt([ 'id'=>$p['id'], 'tp'=>'enc', 'bd'=>_BdStr($p['bd']), 'd'=>['plcy'=>'ok'] ]);
				$cldnow = __LsDt([ 'k'=>'cld', 'id'=>$_now_dt->cld ]);
				$cldnew = __LsDt([ 'k'=>'cld', 'id'=>$p['cld'] ]);

			//-------------------- LOGICA EN EL CAMBIO DE CALIDAD --------------------//

				if(!isN($cldnew->d->ptje->vl) && !isN($cldnow->d->ptje->vl)){

					if( $cldnew->d->ptje->vl > $cldnow->d->ptje->vl){ $_hb_cld = 'ok'; }
					if( $p['cld'] == '-1'){ $_hb_cld = 'ok'; $p['rjct']=1; $p['sndi']=2; }

					if($_hb_cld == 'ok'){
						$_upd[] = sprintf('cnteml_cld=%s', GtSQLVlStr($p['cld'], "text"));
					}

				}

			//-------------------- OTROS PARAMETROS A MODIFICAR --------------------//


			if(!isN($p['rjct'])){ $_upd[] = sprintf('cnteml_rjct=%s', GtSQLVlStr($p['rjct'], "text")); }
			if(!isN($p['dnc'])){ $_upd[] = sprintf('cnteml_dnc=%s', GtSQLVlStr($p['dnc'], "text")); }

			if(!isN($_upd) && !isN($_now_dt->id)){

				$updateSQL = sprintf("UPDATE ".$__bdprfx.TB_CNT_EML." SET ".implode(',', $_upd)." WHERE cnteml_enc=%s LIMIT 1",
						   GtSQLVlStr($_now_dt->enc, "text"));
				$Result_UPD = $__cnx->_prc($updateSQL);

			}

			if($Result_UPD){

				$rsp['e'] = 'ok';

				if(!isN($p['sndi'])){
					//$_upd[] = sprintf('cnteml_sndi=%s', GtSQLVlStr($p['sndi'], "text"));
					// W	ork to update all policy
				}

				if($p['lck'] == 'ok'){

					$__prc = UPDCntEml([ 'bd'=>$p['bd'], 'id'=>$_now_dt->enc, 'est'=>_CId('ID_SISEMLEST_BLQU') ]);

					if($__prc->e == 'ok'){
						$rsp['lckd'] = 'ok';
					}
				}

			}else{
				$rsp['w'] = $__cnx->c_p->error;
			}

		}else{
			$rsp['e'] = 'no';
			$rsp['w'] = 'No all data';
			_ErrSis(['p'=>$insertSQL, 'd'=>$__cnx->c_p->error ]);
		}

		return( _jEnc($rsp) );
	}



	function UPDCntEml($p=NULL){

		global $__cnx;

		if(!isN($p['id'])){

			if(!isN($p['bd'])){ $__bdprfx=_BdStr($p['bd']); }
			if(!isN($p['est'])){ $_upd[] = sprintf('cnteml_est=%s', GtSQLVlStr($p['est'], "text")); }

			if(count($_upd) > 0){

				$updateSQL = sprintf("UPDATE ".$__bdprfx.TB_CNT_EML." SET ".implode(',', $_upd)." WHERE cnteml_enc=%s LIMIT 1",
					   				GtSQLVlStr($p['id'], "text"));

				$rsp['q'] = $updateSQL;

			}

			if(!isN($updateSQL)){
				$Result_UPD = $__cnx->_prc($updateSQL);
				$rsp['e'] = 'ok';
			}

		}else{

			$rsp['e'] = 'no';
			$rsp['w'] = $__cnx->c_p->error;
			_ErrSis([ 'p'=>$insertSQL, 'd'=>$__cnx->c_p->error ]);

		}

		return _jEnc($rsp);

	}



	function Scrpt($t=NULL,$s=NULL){

		$hr = date('H');
		if($hr == '00' || ($hr > 0 && $hr < 12)){ $_day_now = 'buenos días'; }
		if($hr > 12 && $hr < 18){ $_day_now = 'buenas tardes'; }
		if($hr > 18){ $_day_now = 'buenas noches'; }

		$t = str_replace('[US_NM]', SISUS_NM, $t);
		$t = str_replace('[DAY_NOW]', $_day_now, $t);

		if(!isN($s['sve'])){
			$t = str_replace('[NOMBRE]', $s['sve']->cnt_nm, $t);
		}

		return $t;

	}


	function _CSS_Rsp($p=NULL){

		if(!isN($p['nm'])){
			$nme = $p['nm'];
		}

		if(!isN($p['f'])){
			$pth = dirname(__FILE__).$p['f'];
		}else{
			$pth = dirname(__FILE__).'/_sty/_fl/__responsive/';
			$pth_r = '__responsive/';
		}

		$_sze = [
			'hd'=>[ 'min_w'=>'1200' ], // Extra large devices (large laptops and desktops, 1200px and up)
			'large'=>[ 'max_w'=>'1199' ], // Large devices (laptops/desktops, 992px and up)
			'medium'=>[ 'max_w'=>'768' ], // Medium devices (landscape tablets, 768px and up)
			'small'=>[ 'max_w'=>'600' ], // Small devices (portrait tablets and large phones, 600px and up)
		];


		foreach($_sze as $_k=>$_v){

			if(isN($p['nm'])){ $ext='.css'; }
			$nm = $pth.$_k.'/'.$nme.$ext;
			$nm_r = $pth_r.$_k.'/'.$nme.$ext;

			if($_v['min_w']){ $_qry = 'min-width:'.$_v['min_w'].'px'; }
			if($_v['max_w']){ $_qry = 'max-width:'.$_v['max_w'].'px'; }

			if(file_exists($nm)){
				$_r[] = [
					'strt'=>'@media only screen and ('.$_qry.') {',
					'end'=>'}',
					'fle'=>$nm_r
				];
			}

		}

		return _jEnc($_r);

	}



	function __eml_scre($p=NULL){

		if(!isN($p['v'])){

			$__expld = explode('@', $p['v']);

			if(count($__expld) > 1){

				//------------ Hide First Fragment ------------//

					$f_1_1 = substr($__expld[0], 0, 2);
					$f_1_2 = substr($__expld[0], -2);
					$f_1_3 = substr($__expld[0], 2, -3);

					for($i=1; $i<=strlen($f_1_3); $i++){ $f_1_hd .= '*'; }

					$f_1_str = $f_1_1.$f_1_hd.$f_1_2;

				//------------ Hide Second Fragment ------------//

					$f_2_1 = substr($__expld[1], 0, 2);
					$f_2_2 = substr($__expld[1], -2);
					$f_2_3 = substr($__expld[1], 2, -3);

					for($i=1; $i<=strlen($f_2_3); $i++){ $f_2_hd .= '*'; }

					$f_2_str = $f_2_1.$f_2_hd.$f_2_2;

				//------------ Build The Return ------------//

					$_r = $f_1_str.'@'.$f_2_str;

			}


		}else{

			$_r = $p['v'];

		}

		return $_r;

	}





	function __tel_scre($p=NULL){

		if(!isN($p['v'])){

			$f_1_1 = substr($p['v'], 0, 3);
			$f_1_2 = substr($p['v'], -2);
			$f_1_3 = substr($p['v'], 2, -3);

			for($i=1; $i<=strlen($f_1_3); $i++){ $f_1_hd .= '*'; }

			$_r = $f_1_1.$f_1_hd.$f_1_2;


		}else{

			$_r = $p['v'];

		}

		return $_r;

	}


	function _plcy_scre($p=NULL){

		if($p['plcy']['e'] != 1){
			if($p['t']=='eml'){
				$r = __eml_scre([ 'v'=>ctjTx($p['v'],'in') ]);
			}elseif($p['t']=='nm'){
				$r['first'] = '- '._Cns('TX_ANYMUS').' -';
				$r['last'] = '';
			}else{
				$r = __tel_scre([ 'v'=>ctjTx($p['v'],'in') ]);
			}
		}else{
			if($p['t']=='nm'){
				$r['first'] = ctjTx($p['nm'],'in');
				$r['last'] = ctjTx($p['ap'],'in');
			}else{
				$r = ctjTx($p['v'],'in');
			}
		}

		return $r;

	}

	function _TmpFixDir($f=NULL){
		$_p = str_replace('/home/sumr/public_html/_fle/', '', $f);
		$_p = str_replace('/var/www/html/.sumr_fle/', '', $_p);
		$_p = str_replace('/var/www/.sumr_fle/', '', $_p);

		if(Dvlpr()){ $_p = str_replace('/var/www/sumrdev/.sumr_fle/', '', $_p); }
		$_p = str_replace(DIR_TMP_FLE, '', $_p);
		$_p = str_replace(DIR_TMP_BCO, '', $_p);
		$_p = str_replace('_fle/', '', $_p);
		$_p = str_replace('../', '', $_p);
		return $_p;
	}


	function Mme_C_Typ($_f=NULL){

		$__type = mime_content_type($_f);

		if($__type == 'text/plain'){
			$extension = pathinfo($_f, PATHINFO_EXTENSION);

			if($extension == 'css'){
				$__type = 'text/css';
			}elseif($extension == 'js'){
				$__type = 'text/javascript';
			}

		}

		return $__type;

	}


	function MyPssU($p=NULL){
		if($p['t'] == 'evn'){ $__dmn = DMN_EVN_U; $__vrmre = '__c=ok';  }
		elseif($p['t'] == 'act'){ $__dmn = DMN_ACT; }

		$__url = $__dmn.$p['enc'].'/?'.$__vrmre;
		return($__url);
	}




	function _SvWdgtTrck($p=NULL){
		/*
		global $__cnx;

		$_v['e'] = 'no';

		if(!isN($p['id']) && !isN($p['u'])){

			$browser = new Browser();
			$IpUs = KnIp("on");

			$_brws_pltf = $browser->getPlatform();
			$_brws_n = $browser->getBrowser();
			$_brws_v = $browser->getVersion();
			$_dsp = LgnDsp();

			$insertSQL = sprintf("INSERT INTO "._BdStr(DBM).TB_CL_WDGT_TRCK." (clwdgttrck_clwdgt, clwdgttrck_url, clwdgttrck_ip, clwdgttrck_dsp, clwdgttrck_b_p, clwdgttrck_b_t, clwdgttrck_b_v) VALUES (%s, %s, %s, %s, %s, %s, %s)",
								   GtSQLVlStr($p['id'], "text"),
								   GtSQLVlStr($p['u'], "text"),
								   GtSQLVlStr($IpUs, "text"),
								   GtSQLVlStr($_dsp, "text"),
								   GtSQLVlStr($_brws_pltf, "text"),
								   GtSQLVlStr($_brws_n, "text"),
								   GtSQLVlStr($_brws_v, "text"));

			$Result = $__cnx->_prc($insertSQL); $_v['w'] = $__cnx->c_p->error;
			if($Result){ $_v['e'] = 'ok'; }

		}

		return _jEnc($_v);
		*/

	}

	function _MemSz(){
		$_v =  (memory_get_usage(true)/1024/1024);
		return $_v;
	}

	function SesPblc($p=NULL){
		if(!isN($p)){
			if(!isN($p->id)){ unset($p->id); }
			if(!isN($p->us)){ unset($p->us); }
			if(!isN($p->dvc)){unset($p->dvc); }
		}
		return $p;
	}

	function UPD_UsSes($p=NULL){

		global $__cnx;

		if(!isN($p['id'])){

			if(!isN($p['est'])){ $_upd[] = sprintf('uses_est=%s', GtSQLVlStr($p['est'], "text")); }

			if(count($_upd) > 0){

				$updateSQL = sprintf("UPDATE "._BdStr(DBM).TB_US_SES." SET ".implode(',', $_upd)." WHERE uses_enc=%s LIMIT 1",
					   				GtSQLVlStr($p['id'], "text"));

				//$rsp['q'] = $updateSQL;

			}

			if(!isN($updateSQL)){
				$Result_UPD = $__cnx->_prc($updateSQL);
				$rsp['e'] = 'ok';
			}

		}else{

			$rsp['e'] = 'no';
			$rsp['w'] = $__cnx->c_p->error;
			_ErrSis([ 'p'=>$updateSQL, 'd'=>$__cnx->c_p->error ]);

		}

		return _jEnc($rsp);

	}

	function GtLsBcoAdv($p=NULL){

		global $__cnx;

		$query_DtRg = "SELECT
							id_bcoadv, bcoadv_tx, bcoadv_chk, bcoadv_ord
						FROM
							"._BdStr(DBM).TB_BCO_ADV."
						WHERE
							bcoadv_cl = '".DB_CL_ID."'
						ORDER BY bcoadv_chk ASC, bcoadv_ord ASC";

		$DtRg = $__cnx->_qry($query_DtRg);

		if($DtRg){

			$row_DtRg = $DtRg->fetch_assoc();
			$Tot_DtRg = $DtRg->num_rows;

			do{

				$Vl[$row_DtRg['id_bcoadv']]['id'] = $row_DtRg['id_bcoadv'];
				$Vl[$row_DtRg['id_bcoadv']]['tx'] = ctjTx($row_DtRg['bcoadv_tx'],'in');
				$Vl[$row_DtRg['id_bcoadv']]['chk'] = $row_DtRg['bcoadv_chk'];
				$Vl[$row_DtRg['id_bcoadv']]['ord'] = $row_DtRg['bcoadv_ord'];

			} while ($row_DtRg = $DtRg->fetch_assoc());

		$__cnx->_clsr($DtRg);

		}

		$rtrn = _jEnc($Vl);
		return  $rtrn;
	}



?>