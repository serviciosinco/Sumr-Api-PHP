<?php

$Rt = '../../includes/'; $Rstr = 'adm'; include($Rt.'inc.php');

$__chat = new CRM_Chat();

$___k = Php_Ls_Cln($_POST['____key']);

$rsp['e'] = 'no';

// Ingreso de Registro
if ((isset($_POST["MM_insert".$___k])) && ($_POST["MM_insert".$___k] == "SndChat") && !isN($_POST['chat_tx_snd'])) {
	$__chat->cnvrmsj_us = SISUS_ID;
	$__chat->cnvr_enc = $_POST['cht_id'.$___k];
	$__chat->cnvrmsj_msj = $_POST['chat_tx_snd'];
	$rsp = $__chat->_Cht_Msg_Nw();
}



// Modificación de Registro
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "SndUpdOpn")) {

	$__tp = Php_Ls_Cln($_POST['tp']);
	$__opn = Php_Ls_Cln($_POST['opn']);
	$__cnv = Php_Ls_Cln($_POST['cnv']);

	if(!isN( $__cnv )){
		$__chat->maincnv_enc = $__cnv;
		$__mcnv = $__chat->MainCnvDt();
	}

	if($__tp == 'sumr'){

		$__us = Php_Ls_Cln($_POST['us']);

		if(!isN($__us)){

			$__dt_us = GtUsDt($__us, 'enc');
			$__chat->cnvr_us_1 = SISUS_ID;
			$__chat->cnvr_us_2 = $__dt_us->id;
			$__exst = $__chat->_Cht_Exst(); //Valida que no exista conversacion para crear una

			//$rsp['tmp_exst'] = $__exst;

			$__chat->cnvr_us_1 = $__dt_us->id;
			$__chat->cnvr_us_2 = SISUS_ID;

		}elseif(!isN( $__mcnv->d->enc )){

			$__chat->cnvr_enc = $__mcnv->d->enc;

		}

		$__chat->cnvrus_opn = $__opn;
		$__chat->cnvrus_us = SISUS_ID;
		$__chat_r = $__chat->_Cht_UPD_Opn();

		$rsp['tmp_chtr'] = $__chat_r;
		//$rsp['chtd'] = $__chat->_chat_d;

	}

	if($__chat_r->e == 'ok'){

		$_GtMainCnvDt = GtMainCnvDt([ 'tp'=>$__tp, 'maincnv_id'=>$__chat->_chat_d->id ]);

		//$rsp['dt'] = $_GtMainCnvDt;

		if(!isN( $_GtMainCnvDt->enc )){
			$rsp['e'] = 'ok';
			$rsp['id'] = $_GtMainCnvDt->enc;
			$rsp['tp'] = $_GtMainCnvDt->tp;
		}

	}else{

		$rsp['w'] = $__chat_r->w;

	}

}

Hdr_JSON();
ob_start("compress_code");

	$rtrn = json_encode($rsp);
	if(!isN($rtrn)){ echo $rtrn; }

ob_end_flush();

?>