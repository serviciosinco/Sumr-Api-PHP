<?php
// Ingreso de Registro
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "EdBn")) { 
	
	
	$__enc = Enc_Rnd($_POST['bn_tt'].'-'.$_POST['bn_tp']);
	$_dir = SIS_Y.'_'.$_POST['bn_tt'].'_'.Gn_Rnd(10);
	
$insertSQL = sprintf("INSERT INTO ".TB_BN." (bn_enc, 		bn_cl, 		bn_tp, 		bn_est, 
											 bn_frm, 		bn_prc, 	bn_ord, 	bn_tt, 
											 bn_dsc, 		bn_dir, 	bn_h, 		bn_w, 
											 bn_h_vd, 		bn_w_vd, 	bn_fps,  	bn_pay, 
											 bn_url_abs, 	bn_crsl, 	bn_wr, 		bn_edge_id, 
											 
											 bn_tag) VALUES (
												
											%s, (SELECT id_cl FROM "._BdStr(DBM).TB_CL." WHERE cl_enc = %s),( SELECT id_mdlstp FROM _mdl_s_tp WHERE mdlstp_tp = %s), %s, 
											%s, %s, %s, %s, 
											%s, %s, %s, %s, 
											%s, %s, %s, %s, 
											%s, %s, %s, %s, 
											%s)",
              
					   GtSQLVlStr($__enc, "text"),
					   GtSQLVlStr(DB_CL_ENC, "text"),
					   GtSQLVlStr(ctjTx($_POST['bn_tp'],'out'), "text"),
					   GtSQLVlStr($_POST['bn_est'], "int"),
					   
					   GtSQLVlStr($_POST['bn_frm'], "int"),
					   GtSQLVlStr($_POST['bn_prc'], "int"),
                       GtSQLVlStr(ctjTx($_POST['bn_ord'],'out'), "text"),
					   GtSQLVlStr(ctjTx($_POST['bn_tt'],'out'), "text"),
					   
					   GtSQLVlStr(ctjTx($_POST['bn_dsc'],'out'), "text"),
					   GtSQLVlStr(ctjTx($_dir,'out'), "text"),
					   GtSQLVlStr(ctjTx($_POST['bn_h'],'out'), "text"),
					   GtSQLVlStr(ctjTx($_POST['bn_w'],'out'), "text"),
					   
					   GtSQLVlStr(ctjTx($_POST['bn_h_vd'],'out'), "text"),
					   GtSQLVlStr(ctjTx($_POST['bn_w_vd'],'out'), "text"),
					   GtSQLVlStr(ctjTx($_POST['bn_fps'],'out'), "text"),
					   GtSQLVlStr($_POST['bn_pay'], "int"),
					   
					   GtSQLVlStr(ctjTx($_POST['bn_url_abs'],'out'), "text"), 
					   GtSQLVlStr($_POST['bn_crsl'], "int"),
					   GtSQLVlStr($_POST['bn_wr'], "int"),
					   GtSQLVlStr(ctjTx($_POST['bn_edge_id'],'out'), "text"), 
					   
					   GtSQLVlStr(ctjTx($_POST['bn_tag'],'out'), "text"));	
					   		
		$Result = $__cnx->_prc($insertSQL);
 		if($Result){
			$rsp['i'] = $__enc;
			$rsp['e'] = 'ok';
			$rsp['m'] = 1;
			$rsp['a'] = Aud_Sis(Aud_Dsc(189, $_POST['bn_tt'], $__cnx->c_p->insert_id), $rsp['v']);
		}else{
			$rsp['e'] = 'no';
			$rsp['m'] = 2;
			//$rsp['qry'] = $insertSQL;
			$rsp['w'] = $__cnx->c_p->error;
			_ErrSis(['p'=>$insertSQL, 'd'=>$__cnx->c_p->error]);
		}
}

// Modificación de Registro
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "EdBn")) { 
$updateSQL = sprintf("UPDATE ".TB_BN." SET bn_est=%s, bn_frm=%s, bn_prc=%s, bn_ord=%s, bn_tt=%s, bn_dsc=%s, bn_h=%s, bn_w=%s, bn_w_vd=%s, bn_h_vd=%s, bn_fps=%s, bn_pay=%s, bn_url_abs=%s,  bn_crsl=%s, bn_edge_id=%s, bn_tag=%s  WHERE bn_enc=%s",
				
					   GtSQLVlStr($_POST['bn_est'], "int"),
					   GtSQLVlStr($_POST['bn_frm'], "int"),
					   GtSQLVlStr($_POST['bn_prc'], "int"),
                       GtSQLVlStr(ctjTx($_POST['bn_ord'],'out'), "text"),
					   GtSQLVlStr(ctjTx($_POST['bn_tt'],'out'), "text"),
					   GtSQLVlStr(ctjTx($_POST['bn_dsc'],'out'), "text"),
					   GtSQLVlStr(ctjTx($_POST['bn_h'],'out'), "text"),  
					   GtSQLVlStr(ctjTx($_POST['bn_w'],'out'), "text"), 
					   
					   GtSQLVlStr(ctjTx($_POST['bn_h_vd'],'out'), "text"),
					   GtSQLVlStr(ctjTx($_POST['bn_w_vd'],'out'), "text"),
					   GtSQLVlStr(ctjTx($_POST['bn_fps'],'out'), "text"),
					   GtSQLVlStr($_POST['bn_pay'], "int"),
					   
					   GtSQLVlStr(ctjTx($_POST['bn_url_abs'],'out'), "text"), 
					   GtSQLVlStr($_POST['bn_crsl'], "int"),
					   GtSQLVlStr(ctjTx($_POST['bn_edge_id'],'out'), "text"), 
					   
					   GtSQLVlStr(ctjTx($_POST['bn_tag'],'out'), "text"), 
                       GtSQLVlStr(ctjTx($_POST['bn_enc'],'out'), "text"));
	
	$Result = $__cnx->_prc($updateSQL); 
	if($Result){
		$rsp['e'] = 'ok';
		$rsp['m'] = 1;
		$rsp['a'] = Aud_Sis(Aud_Dsc(190, $_POST['bn_tt'], $_POST['id_bn']), $rsp['v']);
	}else{
		$rsp['e'] = 'no';
		$rsp['m'] = 2;
		_ErrSis(['p'=>$updateSQL, 'd'=>$__cnx->c_p->error]);
	} 
}

// Elimino el Registro
if ((isset($_POST['id_bn'])) && ($_POST['id_bn'] != '') && ((isset($_POST['MM_delete']))&&($_POST['MM_delete'] == 'EdBn'))) { 
	$deleteSQL = sprintf('DELETE FROM '.MDL_BN_BD.' WHERE id_bn=%s', GtSQLVlStr($_POST['id_bn'], 'int'));
	$Result = $__cnx->_prc($deleteSQL); if($Result){
		$rsp['e'] = 'ok'; $rsp['m'] = 1;$rsp['a'] = Aud_Sis(Aud_Dsc(191, $_POST['bn_tt'], $_POST['id_bn']), $rsp['v']);}else{$rsp['e'] = 'no';$rsp['m'] = 2; _ErrSis(['p'=>$deleteSQL, 'd'=>$__cnx->c_p->error]);}
}
?>