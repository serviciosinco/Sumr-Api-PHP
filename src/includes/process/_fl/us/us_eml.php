<?php

	$__avtr = __LsDt(['k'=>'emoji', 'rnd'=>'ok']);

	// Ingreso de Registro
	if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "EdUsEml")) {

			$insertSQL = sprintf("INSERT INTO "._BdStr(DBT).TB_THRD_EML." (eml_enc, eml_cl, eml_us, eml_nm, eml_eml, eml_usr, eml_srv_in, eml_pss, eml_prt_in, eml_tp, eml_ssl, eml_avtr, eml_api_key) VALUES (%s, %s, %s, %s, %s, %s, %s, AES_ENCRYPT(%s, '".ENCRYPT_PASSPHRASE."'), %s, %s, %s, %s, AES_ENCRYPT(%s, '".ENCRYPT_PASSPHRASE."'))",
							GtSQLVlStr(Enc_Rnd( $rsp['i'].$_POST['eml_cl'].$_POST['eml_us'] ), "text"),
							GtSQLVlStr($_POST['eml_cl'], "int"),
	                       	GtSQLVlStr($_POST['eml_us'], "int"),
	                       	GtSQLVlStr(ctjTx($_POST['eml_nm'],'out'), "text"),
	                       	GtSQLVlStr(ctjTx($_POST['eml_eml'],'out'), "text"),
	                       	GtSQLVlStr(ctjTx($_POST['eml_usr'],'out'), "text"),
	                       	GtSQLVlStr(ctjTx($_POST['eml_srv_in'],'out'), "text"),
	                       	GtSQLVlStr(ctjTx($_POST['eml_pss'],'out'), "text"),
	                       	GtSQLVlStr(ctjTx($_POST['eml_prt_in'],'out'), "text"),
	                       	GtSQLVlStr($_POST['eml_tp'], "int"),
	                       	GtSQLVlStr(Html_chck_vl($_POST['eml_ssl']), "int"),
						  	GtSQLVlStr($__avtr->id, "int"),
						   	GtSQLVlStr(ctjTx($_POST['eml_api_key'],'out'), "text"));

			$Result = $__cnx->_prc($insertSQL);

	 		if($Result){

				$rsp['i'] = $__cnx->c_p->insert_id;
				$rsp['e'] = 'ok';
				$rsp['m'] = 1;
				//$rsp['a'] = Aud_Sis(Aud_Dsc(460, $_POST['dnctp_tt'], $__cnx->c_p->insert_id), $rsp['v']);

			}else{
				$rsp['w'] = $__cnx->c_p->error;
				$rsp['e'] = 'no';
				$rsp['m'] = 2;
				_ErrSis(['p'=>$insertSQL, 'd'=>$__cnx->c_p->error]);
			}

			$__cnx->_clsr($RsltClQry);
			$__cnx->_clsr($Result);

	}

	// Modificación de Registro
	if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "EdUsEml")) {

		$updateSQL = sprintf("UPDATE "._BdStr(DBT).TB_THRD_EML." SET eml_eml=%s, eml_nm=%s, eml_usr=%s, eml_srv_in=%s, eml_prt_in=%s, eml_api_key=AES_ENCRYPT(%s, '".ENCRYPT_PASSPHRASE."'), eml_tp=%s, eml_ssl=%s WHERE eml_enc=%s LIMIT 1",
										GtSQLVlStr(ctjTx($_POST['eml_eml'],'out'), "text"),
										GtSQLVlStr(ctjTx($_POST['eml_nm'],'out'), "text"),
										GtSQLVlStr(ctjTx($_POST['eml_usr'],'out'), "text"),
										GtSQLVlStr(ctjTx($_POST['eml_srv_in'],'out'), "text"),
										GtSQLVlStr(ctjTx($_POST['eml_prt_in'],'out'), "text"),
										GtSQLVlStr(ctjTx($_POST['eml_api_key'],'out'), "text"),
										GtSQLVlStr($_POST['eml_tp'], "int"),
										GtSQLVlStr(Html_chck_vl($_POST['eml_ssl']), "int"),
										GtSQLVlStr($_POST['eml_enc'], "text")
							);

		//$rsp['q'] = compress_code( $updateSQL );
		$Result = $__cnx->_prc($updateSQL);

		if($Result){
			$rsp['e'] = 'ok';
			$rsp['m'] = 1;
			//$rsp['a'] = Aud_Sis(Aud_Dsc(461, $_POST['sisexa_tt'], $_POST['id_sisexa']), $rsp['v']);
		}else{
			$rsp['e'] = 'no';
			$rsp['m'] = 2;
			$rsp['w'] = $__cnx->c_p->error;
			_ErrSis(['p'=>$updateSQL, 'd'=>$__cnx->c_p->error]);
		}
		$__cnx->_clsr($Result);
	}

	// Elimino el Registro
	if ((isset($_POST['id_useml'])) && ($_POST['id_useml'] != '') && ((isset($_POST['MM_delete']))&&($_POST['MM_delete'] == 'EdUsEml'))) {

		$deleteSQL = sprintf('DELETE FROM '.TB_THRD_EML.' WHERE eml_enc=%s', GtSQLVlStr($_POST['eml_enc'], 'text'));
		$Result = $__cnx->_prc($deleteSQL); if($Result){$rsp['e'] = 'ok'; $rsp['m'] = 1;
			 //$rsp['a'] = Aud_Sis(Aud_Dsc(462, $_POST['dnctp_tt'], $_POST['id_dnctp']), $rsp['v']);
		 }else{$rsp['e'] = 'no';$rsp['m'] = 2; _ErrSis(['p'=>$deleteSQL, 'd'=>$__cnx->c_p->error]);}
		 $__cnx->_clsr($Result);
	}

?>