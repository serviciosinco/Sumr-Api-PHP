<?php

	$Rt = '../../includes/';
	$__https_off = 'off';
	$__no_sbdmn = 'ok';
	$__bdfrnt = 'ok';

	require($Rt.'inc.php');

	$_aws = new API_CRM_Aws();

	$Rts = '../../../_fle/xls/dwn/';
	$__p1 = PrmLnk('rtn', 1, 'ok');

	$__tme_s = microtime(true);
	$_cls_xls = 'ok'; $Rstr = 'adm'; $_cls_gapi = 'ok';

	$__dwn_dt = GtDwnDt(['id'=>$__p1, 't'=>'enc']);


	//$__ntfld = _Ntf_ID();
	//if($__ntfld == 'ok'){ UPD_NtfRd(['id'=>$__dwn_dt->id, 't'=>'dwn']); }

	if($__dwn_dt->tp == 'mdl_cnt'){
		$_fl_tt = 'Contactos Modulos';
	}elseif($__dwn_dt->tp == 'evn_cnt'){
		$_fl_tt = 'Contactos Eventos';
	}elseif($__dwn_dt->tp == 'act_cnt'){
		$_fl_tt = 'Contactos Actividades';
	}

	$_fl_tt = _FleN(['tt'=>$_fl_tt]);
	$__nw_tt = $_fl_tt->tt;

	/*if($__dwn_dt->frm == 724){
		$ext = '.csv';
	}elseif($__dwn_dt->frm == 722){
		$ext = '.xlsx';
	}elseif($__dwn_dt->frm == 723){
		$ext = '.xls';
	}*/

	$ext = '.xlsx';

	$__nw_tt_pxls = $_fl_tt->tt_csv.$ext;

	$_pth = $_aws->_s3_get([ 'b'=>'prvt', 'fle'=>DIR_PRVT_DWN.$__dwn_dt->id.'.xlsx', 'fdwn'=>$__nw_tt_pxls ]);

	if(!isN($_pth->uri)){
		header("Location: ".$_pth->uri);
		die();
	}else{
		//print_r($_pth);
	}

	/*if(!isN($__dwn_dt->fle) && file_exists($Rts.$__dwn_dt->id.$ext)){

		if($__dwn_dt->frm == _CId('ID_DWNFRMT_CSV')){
			$___tpdoc = 'application/octet-stream';
			header("Content-Transfer-Encoding: Binary");
			$ext = '.csv';
		}elseif($__dwn_dt->frm == _CId('ID_DWNFRMT_XLSX')){
			$___tpdoc = 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet';
			$ext = '.xlsx';
		}elseif($__dwn_dt->frm == _CId('ID_DWNFRMT_XLS')){
			$___tpdoc = 'application/vnd.ms-excel; charset=utf-8';
			$ext = '.xls';
		}

		header('Content-type: '.$___tpdoc);
		header("Content-Disposition: attachment; filename=".$__nw_tt_pxls);
		header("Pragma: no-cache");
		header("Expires: 0");
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
		header("Cache-Control: private", false);

		if(!readfile($Rts.$__dwn_dt->id.$ext)){
			//echo 'No read file problem';
			//print_r(error_get_last());
		}

		exit();

	}elseif(!isN($_pth->uri)){ //echo $_pth->uri; exit();

		header('Content-Type: application/octet-stream');
		header("Content-Transfer-Encoding: Binary");
		header("Content-disposition: attachment; filename=\"" . basename($__nw_tt_pxls) . "\"");
		readfile($_pth->uri);

		die();

	}*/


?>