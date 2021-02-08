<?php  $__bdfrnt = 'ok'; include('inc/_inc.php'); ob_start("compress_code");


	$__d = Php_Ls_Cln($_GET['_d']);
	$_hsh = PrmLnk('rtn', 1, 'ok');
	$_dttw = Chck_ID_MsjTw_Sv($_hsh);
	$_hshtg_tt = $_dttw->tt; $_hshtg_tx = $_dttw->tx;
	$_hshtg_tx_svclr = $_dttw->clr;



	if($_dttw->emb != ''){
		include('cnt/index_col_mtd.php');
	}else{
		if($_dttw->dsgn == 1 || $__d == 1){
			include('cnt/index_col_derecha.php'); // 2 Columna
		}elseif($_dttw->dsgn == 2 || $__d == 2){
			include('cnt/index_col_der.php');// Pantalla Completa
		}elseif($_dttw->dsgn == 3 || $__d == 3){
			include('cnt/index_col_centro.php'); // 2 Columna
		}elseif($_dttw->dsgn == 4 || $__d == 4){
			include('cnt/index_bar_top.php'); // Barra Horizontal Superior
		}

	}

ob_end_flush(); ?>