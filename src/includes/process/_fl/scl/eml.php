<?php 

// Ingreso de Registro
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "EdEml")) { 
		
	$__Enc = Enc_Rnd($_POST['eml_nm'].'-'.$_POST['eml_eml']);
	
	$insertSQL = sprintf("INSERT INTO "._BdStr(DBT).TB_THRD_EML." (eml_enc, eml_nm, eml_tp, eml_eml, eml_usr, 
													eml_pss, eml_ssl, eml_srv_in, eml_prt_in, eml_srv_out, 
													eml_prt_out, eml_dfl, eml_avtr, eml_onl, eml_sndr, eml_sac,
													eml_img, eml_aws_ses ) VALUES (%s,%s,%s,%s,%s, AES_ENCRYPT(%s, '".ENCRYPT_PASSPHRASE."') ,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s)",
	
                   GtSQLVlStr(ctjTx($__Enc,'out'), "text"),
                   GtSQLVlStr(ctjTx($_POST['eml_nm'],'out'), "text"),
                   GtSQLVlStr($_POST['eml_tp'], "int"),
                   GtSQLVlStr(ctjTx($_POST['eml_eml'],'out'), "text"),
                   GtSQLVlStr(ctjTx($_POST['eml_usr'],'out'), "text"),                 
                   GtSQLVlStr(ctjTx($_POST['eml_pss'],'out'), "text"),
                   GtSQLVlStr(ctjTx($_POST['eml_ssl'],'out'), "text"),
                   GtSQLVlStr(ctjTx($_POST['eml_srv_in'],'out'), "text"),
                   GtSQLVlStr(ctjTx($_POST['eml_prt_in'],'out'), "text"),
                   GtSQLVlStr(ctjTx($_POST['eml_srv_out'],'out'), "text"),                   
                   GtSQLVlStr(ctjTx($_POST['eml_prt_out'],'out'), "text"), 
                   GtSQLVlStr( _NoNll(Html_chck_vl($_POST['eml_dfl'])) , "int"),            
                   GtSQLVlStr($_POST['eml_avtr'], "int"),
                   GtSQLVlStr( _NoNll(Html_chck_vl($_POST['eml_onl'])) , "int"),
				   GtSQLVlStr( _NoNll(Html_chck_vl($_POST['eml_sndr'])) , "int"),   
				   GtSQLVlStr( _NoNll(Html_chck_vl($_POST['eml_sac'])) , "int"),
                   GtSQLVlStr(ctjTx($_POST['eml_img'],'out'), "text"),
                   GtSQLVlStr( _NoNll(Html_chck_vl($_POST['eml_aws_ses'])) , "int"));		 
	
	$Result = $__cnx->_prc($insertSQL); 
	
	
	if($Result){

		$__id = $__cnx->c_p->insert_id;

		$__Form = new CRM_Thrd();		
		$__Form->id_eml = $__Enc;
		$__Form->id_cl = DB_CL_ENC;
		$PrcDt = $__Form->ClEml_In();

		if($PrcDt->e == 'ok'){
			$rsp['e'] = 'ok';
			$rsp['m'] = 1;
		}

	}else{
		$rsp['e'] = 'no';	 
		$rsp['m'] = 2;	
		$rsp['w'] = $__cnx->c_p->error;
		_ErrSis(['p'=>$insertSQL, 'd'=>$__cnx->c_p->error]);
	}
}



// Modificación de Registro
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "EdEml")) { 
	
	$updateSQL = sprintf("UPDATE "._BdStr(DBT).TB_THRD_EML." SET eml_nm=%s, eml_tp=%s, eml_eml=%s, eml_usr=%s, 
													eml_pss=AES_ENCRYPT(%s, '".ENCRYPT_PASSPHRASE."'), eml_ssl=%s, eml_srv_in=%s, eml_prt_in=%s, eml_srv_out=%s, 
													eml_prt_out=%s, eml_dfl=%s, eml_avtr=%s, eml_onl=%s, eml_sndr=%s, eml_sac=%s, 
													eml_img=%s, eml_aws_ses=%s  WHERE eml_enc = %s ",				
					GtSQLVlStr(ctjTx($_POST['eml_nm'],'out'), "text"),
					GtSQLVlStr($_POST['eml_tp'], "int"),
					GtSQLVlStr(ctjTx($_POST['eml_eml'],'out'), "text"),
					GtSQLVlStr(ctjTx($_POST['eml_usr'],'out'), "text"),          
					GtSQLVlStr(ctjTx($_POST['eml_pss'],'out'), "text"),
					GtSQLVlStr(ctjTx($_POST['eml_ssl'],'out'), "text"),
					GtSQLVlStr(ctjTx($_POST['eml_srv_in'],'out'), "text"),
					GtSQLVlStr(ctjTx($_POST['eml_prt_in'],'out'), "text"),
					GtSQLVlStr(ctjTx($_POST['eml_srv_out'],'out'), "text"),            
					GtSQLVlStr(ctjTx($_POST['eml_prt_out'],'out'), "text"), 
					GtSQLVlStr( _NoNll(Html_chck_vl($_POST['eml_dfl'])) , "int"),            
					GtSQLVlStr($_POST['eml_avtr'], "int"),
					GtSQLVlStr( _NoNll(Html_chck_vl($_POST['eml_onl'])) , "int"),
					GtSQLVlStr( _NoNll(Html_chck_vl($_POST['eml_sndr'])) , "int"), 
					GtSQLVlStr( _NoNll(Html_chck_vl($_POST['eml_sac'])) , "int"), 
					GtSQLVlStr(ctjTx($_POST['eml_img'],'out'), "text"),
					GtSQLVlStr( _NoNll(Html_chck_vl($_POST['eml_aws_ses'])) , "int"),
					GtSQLVlStr(ctjTx($_POST['eml_enc'],'out'), "text"));
  	
	$Result = $__cnx->_prc($updateSQL);

	if($Result){	
		$rsp['e'] = 'ok';		
		$rsp['m'] = 1;
	}else{
		$rsp['m'] = 2;
		$rsp['e'] = 'no';
		$rsp['qry'] = $__cnx->c_p->error;
		_ErrSis(['p'=>$updateSQL,'d'=>$__cnx->c_p->error]);
	} 
}

if ((isset($_POST['uid'])) && ($_POST['uid'] != '') && ((isset($_POST['MM_delete']))&&($_POST['MM_delete'] == 'EdEml'))) { 
	
	$deleteSQL = sprintf("DELETE FROM "._BdStr(DBT).TB_THRD_EML."  WHERE eml_enc=%s",
	GtSQLVlStr($_POST['uid'], 'text'));
	$Result = $__cnx->_prc($deleteSQL); 

	if($Result){
		$rsp['e'] = 'ok'; $rsp['m'] = 1;
		//$rsp['a'] = Aud_Sis(Aud_Dsc(417, $_POST['clare_dsc'], $_POST['id_clare']), $rsp['v']);
		//$rsp['auto'] = __AutoRUN([ 't'=>'sis_cns', 'bd'=>'_cl_mnu' ]);
	}else{
		$rsp['e'] = 'no';$rsp['m'] = 2; 
		_ErrSis(['p'=>$deleteSQL, 'd'=>$__cnx->c_p->error]);
	}
}



// Modificación de Registro
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "EdEmlCnv")) { 
	
	$__Cnt = new CRM_Cnt();
	$__est = Php_Ls_Cln($_POST['est']);

	if(is_array($_POST["emlcnv_enc"])){
		
		$_cnvupd_e='ok';

		foreach($_POST["emlcnv_enc"] as $_cnv_k=>$_cnv_v){
			$_GtMainCnvDt = GtMainCnvDt([ 'enc'=>$_cnv_v, 'd'=>[ 'chnl'=>'ok' ] ]);
			if(!isN($_GtMainCnvDt->chnl->enc)){
				$_cnvupd[] = '"'.$_GtMainCnvDt->chnl->enc.'"';
			}else{
				$_cnvupd_e='no'; break;
			}
		}

		$_cnvupd = ' IN('.implode(',',$_cnvupd).') ';
	}

	if($_cnvupd_e == 'ok'){

		if($__est=='ignr'){ $__est='3'; }

		$updateSQL = sprintf("UPDATE "._BdStr(DBT).TB_THRD_EML_CNV." SET emlcnv_sac=%s WHERE emlcnv_enc".$_cnvupd,				
						GtSQLVlStr($__est, "int"));

		//$rsp['q'] = $updateSQL;
		$Result = $__cnx->_prc($updateSQL);

	}

	if($Result){	
		$rsp['e'] = 'ok';		
		$rsp['m'] = 1;
	}else{
		$rsp['m'] = 2;
		$rsp['e'] = 'no';
		$rsp['w'] = $__cnx->c_p->error;
		_ErrSis(['p'=>$updateSQL,'d'=>$__cnx->c_p->error]);
	} 

}




// Modificación de Registro
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "EdEmlUsView")) { 
	
	$_emldt = GtEmlDt([ 't'=>'enc', 'id'=>$_POST['eml_enc'] ]); 

	if(!isN($_emldt->id)){

		$_eml = new CRM_Eml();
		$_usemldt = $_eml->EmlUsChk([ 'eml'=>$_emldt->id, 'us'=>SISUS_ID, 'cl'=>DB_CL_ID ]);

		if(!isN($_usemldt->id)){

			$updateSQL = sprintf("UPDATE "._BdStr(DBM).TB_US_EML." SET useml_view=%s WHERE id_useml=%s",
							GtSQLVlStr($_POST['useml_view'], "int"),
							GtSQLVlStr($_usemldt->id, "int"));
			
			$Result = $__cnx->_prc($updateSQL);

			if($Result){	
				$rsp['e'] = 'ok';		
				$rsp['m'] = 1;
			}else{
				$rsp['m'] = 2;
				$rsp['e'] = 'no';
				$rsp['qry'] = $__cnx->c_p->error;
				_ErrSis(['p'=>$updateSQL,'d'=>$__cnx->c_p->error]);
			}

		}

	}

}


?>