<?php
ini_set('display_errors', true);
error_reporting(E_ALL & ~E_NOTICE);
if (!isset($_SESSION)) { session_start();}
$Rt='../../includes/'; include($Rt.'inc.php');


function GtTotTw($id){
	if($id != ''){
			global $__cnx;

			$Ls_Qry = "SELECT * FROM hsh_msg WHERE hshmsg_est = 1 AND hshmsg_hsh = '".GtSQLVlStr($id,"int")."' ORDER BY id_hshmsg DESC";
			$Ls = $__cnx->_qry($Ls_Qry);
			$row_Ls = $Ls->fetch_assoc();
			$Tot_Ls = $Ls->num_rows;


			if($Tot_Ls > 0){
				return($Tot_Ls);
			}else{
				return(0);
			}

			$__cnx->_clsr($Ls);
	}
}

function ChckIdMsj($Id){
	if(($Id!='')){
		global $__cnx;
		$colname_DtRg = "-1"; if (isset($Id)){ $colname_DtRg = $Id; }
		$Dt_Qry = sprintf("SELECT * FROM hsh_msg WHERE hshmsg_id = %s", GtSQLVlStr($colname_DtRg, "text"));
		$Dt = $__cnx->_qry($Dt_Qry);
		$row_Dt = $Dt->fetch_assoc();
		$Tot_Dt = $Dt->num_rows;

		if($Tot_Dt == 1){$Vl = true;}else{$Vl = false;}


		$__cnx->_clsr($Dt);

		return($Vl);
	}
}

function Chck_ID_MsjTw_Sv($Id, $Tp=''){
	if(($Id!='')){
		$_sch = MyMn($Id);
		global $__cnx;
		$colname_DtRg = "-1";if (isset($_sch)){$colname_DtRg = $_sch;}
		$Dt_Qry = sprintf("SELECT * FROM hsh WHERE hsh_tx = %s", GtSQLVlStr($colname_DtRg, "text"));
		$Dt = $__cnx->_qry($Dt_Qry);
		$row_Dt = $Dt->fetch_assoc();
		$Tot_Dt = $Dt->num_rows;

		if($Tot_Dt == 1){

			$Vl['id'] = ctjTx($row_Dt['id_hsh'],'in');
			$Vl['tt'] = ctjTx($row_Dt['hsh_tt'],'in');
			$Vl['tx'] = ctjTx($row_Dt['hsh_tx'],'in');
			$Vl['bck_clr'] = ctjTx($row_Dt['hsh_bck_clr'],'in');
			$Vl['hdr_bd_clr'] = ctjTx($row_Dt['hsh_hdr_bdclr'],'in');
			$Vl['msg_bck'] = ctjTx($row_Dt['hsh_msg_bck'],'in');
			$Vl['msg_bd_clr'] = ctjTx($row_Dt['hsh_msg_bdclr'],'in');
			$Vl['msg_bd_wd'] = ctjTx($row_Dt['hsh_msg_bdwd'],'in');
			$Vl['frm'] = ctjTx($row_Dt['hsh_frm'],'in');
			$Vl['dsgn'] = ctjTx($row_Dt['hsh_dsgn'],'in');
			$Vl['tme_hdr'] = ctjTx($row_Dt['hsh_tme_hdr'],'in');
			$Vl['tme_hsh'] = ctjTx($row_Dt['hsh_tme_hsh'],'in');
			$Vl['emb'] = ctjTx($row_Dt['hsh_emb'],'in');
			$Vl['tme_hdr_drt'] = ctjTx($row_Dt['hsh_tme_hdr_drt'],'in');
			$Vl['tme_hsh_drt'] = ctjTx($row_Dt['hsh_tme_hsh_drt'],'in');

			if($row_Dt['hsh_sng'] == 1){ $Vl['sng'] = true; }else{ $Vl['sng'] = false; }

			return _jEnc($Vl);
		}else{
			$Vl = false;
		}
		$__cnx->_clsr($Dt);
		return($Vl);
	}
}

function GtDt_HSHTw($Id, $Tp=''){
	if(($Id!='')){
		global $__cnx;
		$colname_DtRg = "-1";if (isset($Id)){$colname_DtRg = $Id;}
		$Dt_Qry = sprintf("SELECT * FROM hsh WHERE id_hsh = %s", GtSQLVlStr($colname_DtRg, "int"));
		$Dt = $__cnx->_qry($Dt_Qry);
		$row_Dt = $Dt->fetch_assoc();
		$Tot_Dt = $Dt->num_rows;

		if($Tot_Dt == 1){
			if($Tp == 'est'){
				$Vl = $row_Dt['hsh_on'];
			}
		}else{
			$Vl = false;
		}
		$__cnx->_clsr($Dt);
		return($Vl);
	}
}

function GtLst_TwMsj($_h){
		global $__cnx;
		$Dt_Qry = "SELECT * FROM hsh_msg WHERE hshmsg_est = '2' AND hshmsg_hsh = '".GtSQLVlStr($_h,"int")."' ORDER BY id_hshmsg ASC LIMIT 1";
		$Dt = $__cnx->_qry($Dt_Qry);
		$row_Dt = $Dt->fetch_assoc();
		$Tot_Dt = $Dt->num_rows;

		if($Tot_Dt == 1){
			$Vl = $row_Dt['id_hshmsg'];
		}else{
			$Vl = false;
		}
		$__cnx->_clsr($Dt);
		return($Vl);
}

function MsjTw_UpdShw($_i='', $_h=''){
	global $__cnx;
	if($_i !=''){$__i = $_i;}else{$__i = GtLst_TwMsj($_h);}
	if ($__i != '') {
		$updateSQL = sprintf("UPDATE hsh_msg SET hshmsg_est=%s WHERE id_hshmsg=%s",
							   GtSQLVlStr(1, "int"),
							   GtSQLVlStr($__i, "int"));

		$Result =  $__cnx->_prc($updateSQL);
		if($Result){return(true);}else{return(false);}
		$__cnx->_clsr($Result);
	}
}

function GtTwBgImg($_i){
	$s  = array('normal');
	$r = array('bigger');
	$_out = str_replace($s, $r, $_i);
	return($_out);
}
?>