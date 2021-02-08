<?php

$__tme_s = microtime(true);
$Rt = '../../includes/';

$__https_off = 'off';
$__no_sbdmn = 'ok';
$__bdfrnt = 'ok';

require($Rt.'inc.php');

$__f = Php_Ls_Cln($_GET['_f']);
$__t = Php_Ls_Cln($_GET['_t']);


if ($__f != ''){

	$__dir_path = dirname(__FILE__, 4).'/';

	if((PrmLnk('rtn', 1, 'ok') == LNK_EC)){
		$__d = DIR_FLE_EC_HTML;
		$__dtfl = GtEcDt($__f, 'enc');
		$__dv = 1;
	}elseif((PrmLnk('rtn', 1, 'ok') == LNK_BN)){
		$__d = DIR_FLE_BN_HTML;
		$__dtfl = GtBnDt($__f, 'enc');
		$_f_nm = $__dtfl->ord.'-'.$__dtfl->tp.'-'.$__dtfl->w.'-'.$__dtfl->h;
	}


	if ($__dtfl->id == NULL){ exit(); }


	$_f = basename($__dtfl->dir);
	$_f_nm .= MyMn(trim(PmLn_Cl($__dtfl->tt)));

	if(!isN($__t)){

		if($__t == 'zip'){

			$_fle = new CRM_Fle();
			$_aws = new API_CRM_Aws(); //if($_GET['Camilo']=='ok'){ echo _TmpFixDir('../../'.$__d.$_f.'/src.zip'); exit(); }

			$_aws_pth = $_aws->_s3_get([ 'b'=>'fle', 'fle'=>_TmpFixDir('../../'.$__d.$_f.'/src.zip'), 'fdwn'=>$_f_nm.'.zip' ]);

			if(!isN($_aws_pth->uri)){
				header("Location: ".$_aws_pth->uri);
				die();
			}

		}else if($__t == 'html'){

			$_tp = 'text/html';
			$_ext = '.htm';

			$__ec = new API_CRM_ec();
			$__ec->id = $__f;
			$__ec->id_t = 'enc';
			$__ec->proc = $__proC;
			$__ec->evnc = $__evnC;
			$__ec->frm = 'Ml';
			$__ec->html = 'ok';
			$__body = $__ec->_bld();
			$_html = $__body;

		}else if($__t == 'html5'){

			$_tp = 'text/html';
			$_ext = '.html';

		}else{

			$_aws = new API_CRM_Aws();
			$_aws_pth = $_aws->_s3_get([ 'b'=>'fle', 'fle'=>_TmpFixDir($__d.$_f.'/src.pdf'), 'lcl'=>'ok' ]);

			$_pth = $__d.$_f.'/src.pdf';
			$_tp = 'application/pdf';
		}

		//echo $_pth; exit();


		if($__t == 'zip' && is_file($_pth) && file_exists($_pth) && $_zip == 'ok' && $__dv != 1){

			$zip = new ZipArchive();
			$zip->open($_fld."/_dwn.zip",ZipArchive::CREATE);
			$fls = scandir($_fld, 1);

			foreach($fls as $_v){
				 if($_v != '.' && $_v != '..' && $_v != '__MACOSX' && $_v != 'src.zip' && $_v != '_dwn.zip'){
					$zip->addFile($_fld."/".$_v, $_v);
				 }
			}


			$zip->close();
			header("Content-type: application/octet-stream");
			header("Content-disposition: attachment; filename=".$_f_nm.".zip");
			readfile($_fld.'/_dwn.zip');
			unlink($_fld.'/_dwn.zip');


		/* Inicia Proceso de Descarga V.1.0  */
		}elseif ( is_file($_pth) && file_exists($_pth) || ($__t == 'html') || ($__t == 'html5')) {

				$_sz = filesize($_pth);

				if (function_exists('mime_content_type')) {

					$_tp = mime_content_type($_pth);

			   	}elseif (function_exists('finfo_file')) {

				   	$_inf = finfo_open(FILEINFO_MIME);
				   	$_tp = finfo_file($_inf, $_pth);
				   	finfo_close($_inf);

			   	}

			   	if ($_tp == '') {  $_tp = "application/force-download"; }

				header("Status: 200");
				header("Content-Type: ".$_tp);
				header("Content-Disposition: attachment; filename=\"" . $_f_nm . $_ext ."\"");
				header("Content-Transfer-Encoding: binary");

				if($__t == 'html'){
					include('cnt/html.php');
				}elseif($__t == 'html5'){
					include('cnt/html5.php');
				}else{
					if(!isN($_aws_pth->e=='ok') && !isN($_aws_pth->tmp)){
						readfile($_aws_pth->tmp);
					}else{
						readfile($_pth);
					}
				}


		/* Finaliza Proceso de Descarga */

		} else {

			include('cnt/_nodata.php');

		}

		exit();
	}


}elseif((PrmLnk('rtn', 1, 'ok') == LNK_EC) && _ChkEc(PrmLnk('rtn', 2, 'ok'), 'ec_enc')){

	ob_start("compress_code"); Hdr_HTML();
	$__dtec = GtEcDt(PrmLnk('rtn', 2, 'ok'), 'enc', [ 'dtl'=>[ 'cl'=>'ok' ] ]);
	if($__dtec->id != NULL){ include('cnt/ec_detail.php'); }
	ob_end_flush();

}elseif((PrmLnk('rtn', 1, 'ok') == LNK_BN) && _ChkBn(PrmLnk('rtn', 2, 'ok'), 'bn_enc')){

	ob_start("compress_code"); Hdr_HTML();
	$__dtbn = GtBnDt(PrmLnk('rtn', 2, 'ok'), 'enc');
	if($__dtbn->id != NULL){ include('cnt/bn_detail.php'); }
	ob_end_flush();

}

?>