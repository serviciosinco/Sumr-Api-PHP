<?php
			
	function _hst(){
		
		$__host = str_replace('wdgt.', '', $_SERVER['HTTP_HOST']);
			
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
	
	
	
	function cmpr_js($buffer) {
		
		$_hst = _hst();
		
		$buffer = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', ' ', $buffer);
		$buffer = str_replace(["\r\n", "\r", "\n", "\t", ' ', '  ', '   ', '    '], ' ', $buffer);
		$buffer = str_replace(['  ', '   '], ' ', $buffer);
		$buffer = str_replace(['  '], ' ', $buffer);
		$_sch2 = ['if (', '{ ', ' }', '} }', '; }', '( ', ' )', ' = ', '; ', ', ', ' ,', ' != ', ' = ', ' == ', ': ', ' :', ' && ', '> <', ' ='];
		$_chn2 = ['if(', '{', '}', '}}', ';}', '(', ')', '=', ';', ',', ',', '!=', '=', '==', ':', ':', '&&', '><', '='];
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
	
	function Hdr_JSON(){
		header('Cache-Control: no-cache, must-revalidate');
		header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
		header('Content-type: application/json; charset: UTF-8');
	}
	
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
	
	
	function PClr($_p=NULL){
		return preg_replace('/[^-a-zA-Z0-9_]/', '', $_p);
	}
	
	$_id = PClr($_GET['id']);
	$_rnd = PClr($_GET['rnd']);


?>