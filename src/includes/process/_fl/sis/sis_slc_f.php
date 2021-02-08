<?php


if($___Prc->pst->tsb == 'cl'){ 
	
	$__bd_go = ['d'=>'cl']; 
	$__bd = _BdStr(DBM).TB_CL_SLC;
	$__bd2 = _BdStr(DBM).TB_CL_SLC_F;
	$__bd3 = _BdStr(DBM).TB_CL_SLC_TP;
	$cl = 'ok';
	
		
}else{
	
	$__bd = _BdStr(DBM).TB_SIS_SLC;
	$__bd2 = _BdStr(DBM).TB_SIS_SLC_F;
	$__bd3 = _BdStr(DBM).TB_SIS_SLC_TP;
	$cl = 'no';
	
}

 
// Ingreso de Registro
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "EdSisSlcF")) { 
		
	$insertSQL = sprintf("INSERT INTO ".$__bd." (sisslc_enc, sisslc_tt, sisslc_tp, sisslc_cns, sisslc_ord) VALUES (%s, %s, (SELECT id_sisslctp FROM ".$__bd3." WHERE sisslctp_enc = %s), %s, %s)",
					GtSQLVlStr(Enc_Rnd($_POST['sisslc_tt'].'-'.$_POST['sisslc_tp']), "text"),
					GtSQLVlStr(ctjTx($_POST['sisslc_tt'],'out'), "text"),
					GtSQLVlStr(ctjTx($_POST['sisslc_tp'],'out'), "text"),
					GtSQLVlStr(ctjTx($_POST['sisslc_cns'],'out'), "text"),
					GtSQLVlStr(ctjTx($_POST['sisslc_ord'],'out'), "text"));		
					
	
	$Result = $__cnx->_prc($insertSQL);
	
		if($Result){
 		
		$__idmain = $__cnx->c_p->insert_id;
		$rsp['e'] = 'ok';
		$rsp['m'] = 1;
		//$rsp['a'] = Aud_Sis(Aud_Dsc(142, $_POST['cd_tt'], $__cnx->c_p->insert_id), $rsp['v']);
		
		//-------------- ENC VALOR --------------// 
		
		foreach($_POST['sisslc_fld'] as $k=>$v){
			
			if($v['tpd_vl'] == 10){ $Tpd_Vl = [ 'html'=>'no', 'nl2'=>'no' ]; }
			elseif($v['tpd_vl'] == 7){ $Tpd_Vl = ['html'=>'ok','schr'=>'no','nl2'=>'no']; }
			elseif($v['tpd_vl'] == 9){ 
				if(isN($v['vl']['v'])){ $v['vl']['v']=2; }
			}
		
			if($v['tpd_vl'] == 11){
				$__vl_sve = $v['vl']['v'];
			}else{
				$__vl_sve = ctjTx($v['vl']['v'],'out','',$Tpd_Vl );
			}
			
		
			$__chk = Chk_SlcF([ 'slc'=>$__idmain, 'f'=>$v['tp']['id'] ]);
			
			if($__chk->e != 'ok' && $v['vl']['v'] != ''){
				
				$__enc = enCad($__idmain.$v['tp']['id'].'-'.Gn_Rnd(20));
				
				$insertSQLA = sprintf('INSERT INTO '.$__bd2.' (sisslcf_enc, sisslcf_slc, sisslcf_f, sisslcf_vl) VALUES (%s, %s, %s, %s)',
	                       GtSQLVlStr($__enc, "text"),
	                       GtSQLVlStr($__idmain, "int"),
	                       GtSQLVlStr($v['tp']['id'], "int"),
						  // GtSQLVlStr(strip_tags(ctjTx($v['vl']['v'],'out'), $v['vl']['c']))
						   GtSQLVlStr($__vl_sve, $v['vl']['c']) );	
						   
				//$rsp['qry_f'][] = $insertSQLA;		   		   	
				$ResultA = $__cnx->_prc($insertSQLA);
				if(!($ResultA)){ 
					$rsp['e'] = 'no'; 
					$rsp['w'] = $__cnx->c_p->error; 
				}
			}
		}
		
		
	}else{
		
		$rsp['e'] = 'no';
		$rsp['m'] = 2;
		$rsp['d'] = $insertSQL;
		$rsp['w'] = $__cnx->c_p->error;
		
		_ErrSis(['p'=>$insertSQL, 'd'=>$__cnx->c_p->error]);
	}
}

// Modificación de Registro
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "EdSisSlcF")) { 
	
	$updateSQL = sprintf("UPDATE ".$__bd." SET sisslc_tt=%s, sisslc_cns=%s, sisslc_ord=%s WHERE sisslc_enc=%s",
					   GtSQLVlStr(ctjTx($_POST['sisslc_tt'],'out'), "text"),
					   GtSQLVlStr(ctjTx($_POST['sisslc_cns'],'out'), "text"),
					   GtSQLVlStr(ctjTx($_POST['sisslc_ord'],'out'), "text"),
					   GtSQLVlStr($_POST['sisslc_enc'], "text"));

	 
	$Result = $__cnx->_prc($updateSQL); 
	
	if($Result){
	
		$rsp['e'] = 'ok';
		$rsp['m'] = 1;
		
		$_i_upd = 0;
				
		foreach($_POST['sisslc_fld'] as $k=>$v){			
			
			if($v['tpd_vl'] == 10){ $Tpd_Vl = [ 'html'=>'no', 'nl2'=>'no']; }
			elseif($v['tpd_vl'] == 7){ $Tpd_Vl = ['html'=>'ok','schr'=>'no','nl2'=>'no']; }
			elseif($v['tpd_vl'] == 9){ 
				if(isN($v['vl']['v'])){ $v['vl']['v']=2; }
			}
			
			if($v['tpd_vl'] == 11){
				$__vl_sve = $v['vl']['v'];
			}else{
				$__vl_sve = ctjTx($v['vl']['v'],'out','',$Tpd_Vl );
			}
			
			$__chk = Chk_SlcF([ 'slc'=>$_POST['sisslc_enc'], 'f'=>$v['tp']['id'], 'cl'=>$cl ]);
			
			if($__chk->e != 'ok'){
				
				$__enc = enCad($_POST['id_sisslc'].$v['tp']['id'].'-'.Gn_Rnd(20));
				
				$insertSQLA = sprintf('INSERT INTO '.$__bd2.' (sisslcf_enc, sisslcf_slc, sisslcf_f, sisslcf_vl) VALUES (%s, (SELECT id_sisslc FROM '.DBM.'._sis_slc WHERE sisslc_enc = %s), %s, %s)',
	                       GtSQLVlStr($__enc, "text"),
	                       GtSQLVlStr(ctjTx($_POST['sisslc_enc'],'out'), "text"),
	                       GtSQLVlStr($v['tp']['id'], "int"),
						   GtSQLVlStr($__vl_sve, $v['vl']['c'])
						   );	
					   
				//$rsp['qry_f'][] = $insertSQLA;		   		   	
				$ResultA = $__cnx->_prc($insertSQLA);
				$rsp['w'] = $__cnx->c_p->error;
				
			}else{
				
				$__enc = enCad( $_POST['id_sisslc'].$v['tp']['id'].'-'.Gn_Rnd(20) );

				$updateSQLA = sprintf("UPDATE ".$__bd2." SET sisslcf_enc=%s, sisslcf_f=%s, sisslcf_vl=%s WHERE id_sisslcf=%s",
									GtSQLVlStr($__enc, "text"),
									GtSQLVlStr($v['tp']['id'], "int"),					
									GtSQLVlStr($__vl_sve, $v['vl']['c']), 
									GtSQLVlStr($__chk->id, "int"));
									
				$ResultA = $__cnx->_prc($updateSQLA); 
				
				
				if(ChckSESS_superadm()){
					
					$rsp['qry_u'][$_i_upd]['q'] = $updateSQLA;
					$rsp['qry_u'][$_i_upd]['w'] = $__cnx->c_p->error;
				}
				
			}
			
			$_i_upd++;
			
			if(!($ResultA)){ $rsp['e'] = 'no'; }
			
		}
		
	}else{
		
		$rsp['e'] = 'no';
		$rsp['m'] = 2;
		$rsp['w'] = $__cnx->c_p->error;
		_ErrSis(['p'=>$updateSQL, 'd'=>$__cnx->c_p->error]);
		
	} 
}

// Elimino el Registro
if ((isset($_POST['uid'])) && ($_POST['uid'] != '') && ((isset($_POST['MM_delete']))&&($_POST['MM_delete'] == 'EdSisSlcF'))) { 
	$deleteSQL = sprintf('DELETE FROM '.$__bd.' WHERE sisslc_enc=%s', GtSQLVlStr($_POST['uid'], 'text'));
	  $Result = $__cnx->_prc($deleteSQL); if($Result){$rsp['e'] = 'ok'; $rsp['m'] = 1; 
	 //$rsp['a'] = Aud_Sis(Aud_Dsc(144, $_POST['lndfld_tt'], $_POST['id_lndfld']), $rsp['v']);
	 }else{$rsp['e'] = 'no';$rsp['m'] = 2; $rsp['mss'] = $deleteSQL.' <--> '.$__cnx->c_p->error; _ErrSis(['p'=>$deleteSQL, 'd'=>$__cnx->c_p->error]);}
}
?>