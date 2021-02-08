<?php

	require_once dirname(__FILE__).'/classes/browser.php';
	require_once dirname(__FILE__).'/system/_cl_id.php';
	require_once dirname(__FILE__).'/system/_cl_data.php';

	define('HTML_BR', '</br>');

	if(file_exists( dirname(__FILE__).'/system/_sis.php' )){
		include_once( dirname(__FILE__).'/system/_sis.php' );
	}

	function isN($v){

		if(is_array($v) && !isN($v['a'])){
			foreach($v as $v_k=>$v_v){
				if(!isset($v_v) || $v_v==NULL || $v_v=='null' || $v_v=='NULL' || $v_v=='' || $v_v=='undefined' || empty($v_v)){
					$_arrn='ok';
					break;
				}
			}
			if($_arrn=='ok'){ return (bool) true; }else{ return (bool) false; }
		}else{

			$v_f = $v;

			if(!isset($v_f) || $v_f==NULL || $v_f=='null' || $v_f=='NULL' || $v_f=='' || $v_f=='undefined' || empty($v_f)){
				return (bool) true;
			}else{
				return (bool) false;
			}

		}

	}


	function _jEnc($r=NULL,$p=NULL){

		if(!isN($p)){ // Special In of Data

			if($p['s_in']=='ok'){ // Special In of Data
				$je = json_encode($r, JSON_UNESCAPED_UNICODE);
			}elseif($p['s_nerr']=='ok'){ // No error
				$je = json_encode($r, JSON_UNESCAPED_UNICODE | JSON_PARTIAL_OUTPUT_ON_ERROR);
			}

			if(!isN( json_last_error() ) && json_last_error() == 5 || mb_detect_encoding($r) != 'UTF-8'){
				$r = mb_convert_encoding($r, 'UTF-8', 'UTF-8');
				$je = json_encode($r, JSON_UNESCAPED_UNICODE | JSON_PARTIAL_OUTPUT_ON_ERROR);
			}

			if(!isN( json_last_error() ) && isWrkr()){
				echo SYS_AUTO.MACHINE_WRKR.' Encode ERROR ('.json_last_error().'):'.json_last_error_msg().PHP_EOL;
				//echo print_r($r, true).PHP_EOL;
			}

		}else{

			$je = json_encode($r);

			if(!isN( json_last_error() ) && isWrkr()){

				if(!isN( json_last_error() ) && json_last_error() == 5 || mb_detect_encoding($r) != 'UTF-8'){
					//$r = mb_convert_encoding($r, 'UTF-8', 'UTF-8');
					$je = json_encode($r, JSON_UNESCAPED_UNICODE | JSON_PARTIAL_OUTPUT_ON_ERROR);
				}

				if(!isN( json_last_error() ) && isWrkr()){
					echo SYS_AUTO.MACHINE_WRKR.' Encode ERROR:'.json_last_error_msg().PHP_EOL;
					//echo print_r($r, true).PHP_EOL;
				}
			}

		}

		$_go = json_decode($je);

		if(!isN( json_last_error() ) && isWrkr()){ echo 'Decode ERROR:'.json_last_error_msg().PHP_EOL; }

		return $_go;
	}


	function Gt_DMN($p=NULL){

		if(defined('MACHINE_DMN') && !isN(MACHINE_DMN) && isN($p['sbd'])){
			$_dmn=MACHINE_DMN;
		}elseif(defined('DMN_DNS') && DMN_DNS == 'ok' && isN($p['sbd'])){
			$_dmn='sumr.co';
		}elseif(!isN($p['sbd'])){
			$_dmn=$_SERVER['HTTP_HOST'];
		}else{
			$_dmn=$_SERVER['HTTP_HOST'];
		}

		if(isN($p['sbd'])){
			$_jd = preg_replace("/^(.*\.)?([^.]*\..*)$/", "$2", $_dmn);
		}else{
			$_jd = $_dmn;
		}

		return($_jd);
	}

	function Gt_SbDMN(){
		if(defined('DMN_DNS') && DMN_DNS == 'ok'){ $_dmn='sumr.co'; }
		else{ $_dmn=$_SERVER['HTTP_HOST']; }
		$_jd = array_shift((explode(".",$_dmn)));
		return($_jd);
	}

	function isWrkr(){
		if(	(defined('MACHINE_WRKR') && MACHINE_WRKR == 'ok') ||
			(defined('SYS_AUTO') && SYS_AUTO == 'on')){
			return(true);
		}else{
			return(false);
		}
	}

	function br($n=NULL){

		if( isWrkr()){ $_r = PHP_EOL; }else{ $_r = HTML_BR; }
		return $_r;

	}

	if(!function_exists("Gt_DMNR")){
		if(defined('MACHINE_DMN') && !isN(MACHINE_DMN)){ $_dmn=MACHINE_DMN; }
		else{ $_dmn=$_SERVER['HTTP_HOST']; }
		function Gt_DMNR(){ $_jd = preg_replace("/^(.*\.)?([^.]*\..*)$/", "$2", $_dmn); return($_jd); }
	}

	if(!function_exists("_Cns")){
		function _Cns($c=NULL){
			if($c!=NULL){
				if(defined($c)){
					$r = constant($c);
				}else{
					if(ChckSESS_superadm()){
						$r = TX_NOCNS.$c;
					}
				}
			}else{
				return false;
			}
			return $r;
		}
	}

	function is_https(){
	    if(isset($_SERVER['HTTPS']) && mb_strtolower($_SERVER['HTTPS']) == "on") { return true; }
	    elseif(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 1){ return true; }
	    elseif(isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https'){ return true; }
	    elseif(isset($_SERVER['SERVER_PORT']) && $_SERVER["SERVER_PORT"] == 443){ return true;}
	    else{ return false;}
	}

	function _http(){ if(is_https()){ $_r = 'https://'; }else{ $_r = 'http://'; } return $_r; }

	function _argv($argv){
		if(!isN($argv)){
			foreach ($argv as $arg) {
		        $e=explode("=",$arg);

		        if(count($e)==2){
			        if(!isN($e[1])){
			            $_r[$e[0]]=$e[1];
		            }
		        }

		    }
	    }
	    return _jEnc( $_r );
    }



	function _jBty($p=NULL){

		if($p['s']=='html'){
			$__mn = ["<script>","</script>"];
			$__tmp = ["1@@@1","2@@@2"];
		}else{
			$__mn = ["\n","\r"];
			$__tmp = ["1@@@1","2@@@2"];
		}

		if($p['t']=='o'){
			$v =  str_replace($__tmp,$__mn,$p['v']);
		}else{
			$v = str_replace($__mn,$__tmp,$p['v']);
		}

		return $v;
	}

	function _BdStr($v=NULL){
		if(!isN($v)){
			if(strpos($v, '.') !== false){ $r = $v; }else{ $r = $v.'.'; }
		}else{
			$r='';
		}
		return $r;
	}


	function Sbdmn($_t='', $_r_n=''){ $expldt = explode(".",$_SERVER['HTTP_HOST']); $sbd_dt = array_shift($expldt); if($_t == 'rtn'){ $__val = $sbd_dt; }elseif($_t == 'chck'){ if(($sbd_dt != '')){ $__val = true; }else{ $__val = false; } }else{ $__val = false; } return($__val);}

	// Cifrado //
	function enCad($id){ return sha1(md5($id));}

	// Numero Aleatorio //
	function Gn_Rnd($longitud=3){  $exp_reg="[^A-Z0-9]"; return substr(preg_replace($exp_reg, "", sha1(md5(rand()))) . preg_replace($exp_reg, "", sha1(md5(rand()))) .  preg_replace($exp_reg, "", sha1(md5(rand()))),0, $longitud); }

	function Enc_Rnd($i=NULL){ if(!isN($i)){ return enCad($i.'-'.Gn_Rnd().'-'.SIS_F_TS); } }


	function _GPJ($_v=NULL){

		//echo json_encode($_v);

		if(!isN($_v['v'])){

			$_f = Php_Ls_Cln($_POST['fl'][ $_v['v'] ]);
			$_fp = Php_Ls_Cln($_POST['fl']['p'][ $_v['v'] ]);
			$_ff = Php_Ls_Cln($_POST['fl']['f'][ $_v['v'] ]);
			$_fk = Php_Ls_Cln($_POST['fl']['fk'][ $_v['v'] ]);

			$_p = Php_Ls_Cln($_POST[ $_v['v'] ]);
			$_g = Php_Ls_Cln($_GET[ $_v['v'] ]);
			$_j = $_v['j']->{$_v['v']} ;


			if(!isN($_v['j']->fk)){ $_jfk = $_v['j']->fk->{$_v['v']}; }


			if(!isN($_f)){ return $_f; }
			elseif(!isN($_fp)){ return $_fp; }
			elseif(!isN($_ff)){ return $_ff; }
			elseif(!isN($_fk)){ return $_fk; }
			elseif(!isN($_p)){ return $_p; }
			elseif(!isN($_g)){ return $_g; }
			elseif(!isN($_j)){ return $_j; }
			elseif(!isN($_jfk)){ return $_jfk; }

		}else{
			return false;
		}
	}


	function __AdSch(){
		$v = Php_Ls_Cln($_GET[GT_SCH]);
		if(!isN($v) && !isN($v)){ $r=ADM_LNK_SCH.$v; }else{ $r=false; } return $r;
	}

	function _crypt($p=null){

		$rvalue='';

		if(isset($p['v'])){

			$cryptype = 'AES256';

			if(defined('ENCRYPT_PASSPHRASE')){
				if(isset($p['e']) && $p['e'] == 'on'){
					$rvalue = openssl_encrypt($p['v'], $cryptype, ENCRYPT_PASSPHRASE);
				}else{
					$rvalue = openssl_decrypt($p['v'], $cryptype, ENCRYPT_PASSPHRASE);
				}
			}else{
				echo 'ENCRYPT_PASSPHRASE not defined'; die();
			}

		}

		return $rvalue;

	}

	function _evar($v=NULL,$opt=[]){

		global $argv;
		global $_ENV;
		$gvlue = '';

		$__gargv = _argv($argv);

		if( !isN($__gargv->{$v}) ){ $gvlue = $__gargv->{$v}; }
		if( !isN($_ENV[$v]) ){ $gvlue = $_ENV[$v]; }
		if( !isN($_SERVER[$v]) ){ $gvlue = $_SERVER[$v]; }
		if( !isN(getenv($v)) ){ $gvlue = getenv($v); }
		if( !isN($_GET[$v]) ){ $gvlue = $_GET[$v]; }

		if(!isN($opt) && $opt['crpt']){ $gvlue = _crypt([ 'v'=>$gvlue ]); }
		if(!isN($gvlue)){ define($v,$gvlue); }

	}


	function _evar_set($set=NULL){
		if(!isN($set)){
			foreach($set as $k=>$v){
				if($v=='DB_US_PSS' || $v=='DB_USPRC_PSS'){ $_opt = ['crpt'=>true]; }else{ $_opt=[]; }
				_evar($v,$_opt);
			}
		}
	}


	function cmpr_js($buffer){

		$buffer = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', ' ', $buffer);
		$buffer = str_replace(["\r\n", "\r", "\n", "\t", ' ', '  ', '   ', '    '], ' ', $buffer);
		$buffer = str_replace(['  ', '   '], ' ', $buffer);
		$buffer = str_replace(['  '], ' ', $buffer);
		$_sch2 = ['if (', '} if(', ' {', '{ ', ' }', '} }', '; }', '( ', ' )', ' = ', '; ', ', ', ' ,', ' != ', ' = ', ' == ', ': ', ' :', ' && ', '> <', ' =', ' + '];
		$_chn2 = ['if(', '}if(', '{', '{', '}', '}}', ';}', '(', ')', '=', ';', ',', ',', '!=', '=', '==', ':', ':', '&&', '><', '=', '+'];
		$buffer = str_replace($_sch2, $_chn2, $buffer);
		$buffer = str_replace('NaN|{2}', 'NaN| {2}', $buffer); // Fixing Highcharts Error Compress
		$buffer = str_replace([' > ',' < ',' || ','[ i ]',' === ','[ ',' ]',' (',' ? ',',}'], ['>','<','||','[i]','===','[',']','(','?','}'], $buffer);
		$buffer = str_replace('[[permalink]]','{{permalink_${i}}}', $buffer);

		return $buffer;
	}

	function compress_code($buffer) {
		$buffer = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $buffer);
		$buffer = str_replace(["\r\n", "\r", "\n", "\t", ' ', '  ', '   ', '    '], ' ', $buffer);
		$buffer = str_replace(['  ', '   '], ' ', $buffer);
		$buffer = str_replace(['  '], ' ', $buffer);
		$_sch2 = ['  ', '> <', '>  <', '" >', ' > ', '; <', '" />', ': ', ', ', '; ', '{ ', ' {', '} ', ' }', ' = ', ' && '];
		$_chn2 = [' ', '><', '><', '">', '>', ';<', '"/>', ':', ',', ';', '{', '{', '}', '}', '=', '&&'];
		$buffer = str_replace($_sch2, $_chn2, $buffer);
		return $buffer;
	}

	function compress_code_b($buffer) {
		$buffer = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $buffer);
		$buffer = preg_replace('/<!--(.|\s)*?-->/', '', $buffer);
		$buffer = str_replace(["\r\n", "\r", "\n", "\t", ' ', '  ', '   ', '    '], ' ', $buffer);
		$buffer = str_replace('</div>   <div','</div><div',$buffer);
		$buffer = str_replace('</div>  </div>','</div></div>',$buffer);
		$buffer = str_replace('</div>        <div','</div><div',$buffer);
		$buffer = str_replace('>   <div','><div',$buffer);
		$buffer = str_replace(['[FSVG]'],[DMN_IMG_ESTR_SVG],$buffer);
		$buffer = str_replace($_sch2, $_chn2, $buffer);
		return $buffer;
	}

	function cmpr_fm($buffer) {
		$buffer = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $buffer);
		$buffer = str_replace(["\r\n", "\r", "\n", "\t", ' ', '  ', '   ', '    '], ' ', $buffer);
		$buffer = str_replace(['  ', '   '], ' ', $buffer);
		$buffer = str_replace(['  '], ' ', $buffer);
		$buffer = str_replace($_sch2, $_chn2, $buffer);
		return $buffer;
	}


	function cmpr_css($buffer,$p=NULL){

		$buffer = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', ' ', $buffer);
		$buffer = str_replace(array("\r\n", "\r", "\n", "\t", ' ', ' ', ' '), ' ', $buffer);

		//--------- Random Class ---------//

		$_rnd = $p['rnd'];

		//--------- Random Class ---------//

		$_sch_rnd = [
			'--sumr-clr',
			'SUMR-Wdgt-Btn',
			'SUMR-Wdgt-Opt',
			'smr_btn_popup',
			'smr_popup',
			'smr_btn_opt'
		];

		$_chn_rnd = [
			'--sumr-'.$_rnd.'-clr',
			'SUMR-Wdgt-Btn_'.$_rnd,
			'SUMR-Wdgt-Opt_'.$_rnd,
			'smr_btn_popup_'.$_rnd,
			'smr_popup_'.$_rnd,
			'smr_btn_opt_'.$_rnd
		];

		$buffer = str_replace($_sch_rnd, $_chn_rnd, $buffer);


		$_sch2 = ['  ',' {', '{ ', ' }', '; ', ': ', '} .', '} #', ', '];
		$_chn2 = ['','{', '{','}', ';', ':', '}.', '}#', ','];
		$buffer = str_replace($_sch2, $_chn2, $buffer);

		return $buffer;

	}

	function Hdr_HTML($p=NULL){

		header('Content-type: text/html; charset: UTF-8');

		if($p['cche']=='ok' || isset($_GET['cachev'])){
			header("Etag: SUMR-".enCad(E_TAG. (!isN($p['fa'])?$p['fa']:'') ));
			header('X-Powered-By: Servicios.in');
		}else{
			header('Cache-Control: no-cache, must-revalidate');
			header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
		}

	}

	function Hdr_JSON(){
		header('Cache-Control: no-cache, must-revalidate');
		header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
		header('Content-type: application/json; charset: UTF-8');
	}

	function No_Cache() {
	    header("Expires: Tue, 01 Jul 2001 06:00:00 GMT");
	    header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
	    header('Cache-Control: no-cache, must-revalidate');
	    header("Cache-Control: post-check=0, pre-check=0", false);
	    header("Pragma: no-cache");
	}

	function _isDsk($_p=NULL){
		$_dsk = $_GET['_dsktp'];
		if($_dsk=='ok'){ return true; }else{ return false; }
	}


	//-------------- FUENTES --------------//

	function __font($p=NULL){

		if(!isN($p['fly'])){
			$____fmly = $p['fly'];
		}else{
			$____fmly[] = ['name'=>'Economica','size'=>'400,700'];
			$____fmly[] = ['name'=>'Roboto','size'=>'400,300,100,500', 'subset'=>'latin'];
			$____fmly[] = ['name'=>'Source+Sans+Pro', 'size'=>'200,300,400,600,700,900'];
			$____fmly[] = ['name'=>'Work+Sans', 'size'=>'100,300,400,500,700'];
			$____fmly[] = ['name'=>'Anonymous+Pro','size'=>'400,700'];
		}

		if(!isN($p['m'])){
			$____fmly[] = $p['m'];
		}

		$_i = 0;

		foreach($____fmly as $k=>$v){

			if($v['name']){
				$__obj['js-s'][$_i][] = $v['name'];
				$__obj['link-s']['f'][$_i][] = str_replace(' ','+',$v['name']);
			}
			if($v['size']){
				$__obj['js-s'][$_i][] = $v['size'];
				$__obj['link-s']['f'][$_i][] = $v['size'];
			}
			if($v['subset']){
				$__obj['js-s'][$_i][] = $v['subset'];
				$__obj['link-s']['s'][] = $v['subset'];
			}


			$__d['js-s'][$_i] = "'".implode(':', $__obj['js-s'][$_i] )."'";
			$__d['js-a'][$_i] = $v['name'].':'.$v['size'].(!isN( $v['subset'] )?':'.$v['subset']:'');
			$__d['link-s']['f'][$_i] = implode(':', $__obj['link-s']['f'][$_i] );

			$_i++;
		}


		$__r['js']['string'] = "[".implode(',', $__d['js-s'])."]";
		$__r['js']['array'] = $__d['js-a'];

		$__r['link']['string'] = "https://fonts.googleapis.com/css?family=".implode('|', $__d['link-s']['f']);
		if($__obj['link-s']['s'] != NULL){ $__r['link']['string'] .= "&subset=".implode(',', $__obj['link-s']['s']); }

		return _jEnc($__r);

	}

	function _LclDte($d=NULL){
		return date('c', strtotime($d) );
	}

	function _LclTme($d=NULL){
		return date('H:i:sP', strtotime($d) );
	}

	function Dvlpr(){
		_evar('SUMR_ENV');
		if(defined('SUMR_ENV') && SUMR_ENV == 'dev'){ define('SPR_DVLP', 'ok'); }
		if(defined('SPR_DVLP') && SPR_DVLP == 'ok'){ return true; }else{ return false; }
	}

	function ClMain(){
		if(defined('DB_CL_SVIN') && DB_CL_SVIN=='ok'){ return true; }else{ return false; }
	}

	function GtUsImg($p=NULL){
		if( !isN($p['img']) ){
			$_img = _ImVrs(['img'=>$p['img'], 'f'=>DMN_FLE_US ]);
		}else{
			if($p['gnr'] == _CId('ID_SX_H')){
				$_img = DMN_IMG_ESTR_SVG.'myp_nopic_m.svg';
			}elseif($p['gnr'] == _CId('ID_SX_M')){
				$_img = DMN_IMG_ESTR_SVG.'myp_nopic_w.svg';
			}else{
				$_img = DMN_IMG_ESTR_SVG.'myp_nopic_n.svg';
			}
		}
		return $_img;
	}


	function Cl_CData($p=null){

		if(!isN($p['id']) || !isN($p['prfl'])){
			if(!isN($p['prfl'])){
				$_vb = strtoupper('CL_DATAID_'.$p['prfl']);
			}else{
				$_vb = strtoupper('CL_DATA_'.$p['id']);
			}
			if(defined($_vb)){
				$v = constant($_vb);
				return _jEnc($v);
			}
		}

	}


	date_default_timezone_set('America/Bogota');

	define('SIS_F',date("y/m/d"));
	define('SIS_H',date("H:i a"));
	define('SIS_F_D',date("y-m-d H:i:s"));
	define('SIS_F_D2',date("Y-m-d H:i:s"));
	define('SIS_Y',date("Y"));
	define('SIS_F_DMY',date("d-m-Y"));
	define('SIS_F_ALL',date("y-m-d H:i a"));
	define('SIS_F2',date("Y-m-d"));
	define('SIS_H2',date("H:i:s"));
	define('SIS_F_TS',date("Y-m-d H:i:s"));
	define('SIS_F_TS_M',date("Y-m-d H:i:s v"));
	define('SIS_Y',date("Y"));
