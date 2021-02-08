<?php

	require_once dirname(__FILE__,4).'/includes/system/_cl_id.php';
	require_once dirname(__FILE__,4).'/includes/system/_cl_data.php';

    if(file_exists(dirname(__FILE__,4).'/includes/system/_sis.php')){
        require dirname(__FILE__,4).'/includes/system/_sis.php';
    }

    if(file_exists(dirname(__FILE__,4).'/includes/')){
        require dirname(__FILE__,4).'/includes/_lib/vendor/autoload.php';
    }

	function Dvlpr(){
		if(getenv('SUMR_ENV') == 'dev'){ define('SPR_DVLP', 'ok'); }
		if(SPR_DVLP == 'ok'){ return true; }else{ return false; }
	}

    function _hst(){

		$__host = str_replace('form.', '', $_SERVER['HTTP_HOST']);

		if($__host == 'massivespace.rocks'){

			$_r['chng'] = 'ok';
			$_r['prfx'] = 'MSVSPC';
			$_r['prfx_c'] = 'massivespace';
			$_r['hst'] = $__host;
			$_r['pwdby'] = 'Massive Space';
            $_r['pwdby_lnk'] = 'https://massivespace.rocks';

		}else{

			if($__host == 'sumr.co' || $__host == 'sumr.cloud' || $__host == 'sumr.nz'){
				$_r['dev'] = 'no';
			}elseif($__host == 'sumrdev.com'){
				$_r['dev'] = 'ok';
			}

			$_r['hst'] = $__host;
			$_r['pwdby'] = 'SUMR';
			$_r['pwdby_lnk'] = 'https://www.facebook.com/sumr.crm/';
		}

		return json_decode(json_encode($_r));
	}


	function compress_code($buffer) {

		$_hst = _hst();

		$buffer = str_replace(['[FSVG]'],['https://img.[DOMAIN]/estr/svg/'],$buffer);
		$buffer = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $buffer);
		$buffer = str_replace(["\r\n", "\r", "\n", "\t", ' ', '  ', '   ', '    '], ' ', $buffer);
		$buffer = str_replace(['  ', '   '], ' ', $buffer);
		$buffer = str_replace(['  '], ' ', $buffer);
		$_sch2 = ['  ', '> <', '>  <', '" >', ' > ', '; <', '" />', ': ', ', ', '; ', '{ ', ' {', '} ', ' }', ' = ', ' && '];
		$_chn2 = [' ', '><', '><', '">', '>', ';<', '"/>', ':', ',', ';', '{', '{', '}', '}', '=', '&&'];
		$buffer = str_replace($_sch2, $_chn2, $buffer);

		$buffer = str_replace(
			[
				'[DOMAIN]',
				'[PWD]',
				'[PWD_LNK]',
				'[ENV]',
				'[ETAG]',
				//'SUMR_Wdg',
			], [
				$_hst->hst,
				$_hst->pwdby,
				$_hst->pwdby_lnk,
				($_hst->dev=='ok'?'dev':'prd'),
				E_TAG,
				//($_hst->dev=='ok'?'SUMR_Wdg_Dev':'SUMR_Wdg')
			],
			$buffer
		);



		return $buffer;
	}

	function cmpr_js($buffer) {

		$_hst = _hst();

		$buffer = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', ' ', $buffer);
		$buffer = str_replace(["\r\n", "\r", "\n", "\t", ' ', '  ', '   ', '    '], ' ', $buffer);
		$buffer = str_replace(['  ', '   '], ' ', $buffer);
		$buffer = str_replace(['  '], ' ', $buffer);
		$_sch2 = ['if (', ' {', '{ ', '} ', ' }', '} }', '; }', '( ', ' )', ' = ', '; ', ', ', ' ,', ' != ', ' = ', ' == ', ': ', ' :', ' && ', '> <', ' ='];
		$_chn2 = ['if(', '{', '{', '}', '}', '}}', ';}', '(', ')', '=', ';', ',', ',', '!=', '=', '==', ':', ':', '&&', '><', '='];
		$buffer = str_replace($_sch2, $_chn2, $buffer);
		$buffer = str_replace('NaN|{2}', 'NaN| {2}', $buffer); // Fixing Highcharts Error Compress
		$buffer = str_replace([' > ',' < ',' || ','[ i ]',' === ','[ ',' ]',' (',' ? ',',}'], ['>','<','||','[i]','===','[',']','(','?','}'], $buffer);
		$buffer = str_replace(['=== '], ['==='], $buffer);
		$buffer = str_replace([' !== '], ['!=='], $buffer);

		$buffer = str_replace(
					[
						'[DOMAIN]',
						'[PWD]',
						'[PWD_LNK]',
						'[ENV]',
						'[ETAG]',
						//'SUMR_Wdg',
					], [
						$_hst->hst,
						$_hst->pwdby,
						$_hst->pwdby_lnk,
						($_hst->dev=='ok'?'dev':'prd'),
						E_TAG,
						//($_hst->dev=='ok'?'SUMR_Wdg_Dev':'SUMR_Wdg')
					],
						$buffer
					);

		if($_hst->chng == 'ok'){
			$buffer = str_replace(['SUMR', 'sumr'], [$_hst->prfx, $_hst->prfx_c], $buffer);
		}

		return $buffer;
	}

	function enCad($id){ return sha1(md5($id));}

	function Enc_Rnd($i=NULL){ if(!isN($i)){ return enCad($i.'-'.Gn_Rnd().'-'.SIS_F_TS); } }

	function Hdr_JS($p=NULL){
		header('Access-Control-Allow-Origin: *');
		header('Content-type: text/javascript; charset: UTF-8');
		header('Content-transfer-encoding: binary');

		if($p['cche']=='ok'){
			header("Etag: SUMR-".enCad(E_TAG));
			header('X-Powered-By: Servicios.in');
		}else{
			header('Cache-Control: no-cache, must-revalidate');
			header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
		}
	}

	if(!function_exists("PrmLnk")){
		function PrmLnk($_t='', $_r_n='', $_pml=NULL){

			$__xpl = explode('?', $_SERVER['REQUEST_URI']);
			$prm_dt = explode('/', $__xpl[0]);

			if($_pml == 'ok'){
				$_prm_sb1 = $prm_dt[1];
				$_prm_sb2 = $prm_dt[2];
				$_prm_sb3 = $prm_dt[3];
				$_prm_sb4 = $prm_dt[4];
				$_prm_sb5 = $prm_dt[5];
			}

			if($_t == 'rtn'){
				$__val = ${'_prm_sb'.$_r_n};
			}

			return($__val);
		}
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

    function Gn_Rnd($longitud=3){  $exp_reg="[^A-Z0-9]"; return substr(preg_replace($exp_reg, "", sha1(md5(rand()))) . preg_replace($exp_reg, "", sha1(md5(rand()))) .  preg_replace($exp_reg, "", sha1(md5(rand()))),0, $longitud); }

    function Php_Ls_Cln($_v){
        if(GtSQLVlStr($_v, 'text')){ $_r = $_v; }
        return($_r);
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

?>