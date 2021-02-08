<?php 
	
	$__id = 'id_trarsp'; // Id de Datos
	$__bd = _BdStr(DBM).TB_TRA_RSP; // Base de Datos
	
	// Ingreso de Registro
	if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "EdTraRsp")) {
		
		global $__cnx;
		
		$insertSQL = sprintf("INSERT INTO $__bd (trarsp_us, trarsp_us_asg, trarsp_tra, trarsp_tp, trarsp_dsc) VALUES (%s, %s, %s, %s, %s)",
	                   GtSQLVlStr($_POST['trarsp_us'], "int"),
	                   GtSQLVlStr(SISUS_ID, "int"),
					   GtSQLVlStr($_POST['trarsp_tra'], "int"),
					   GtSQLVlStr($_POST['trarsp_tp'], "int"),
					   GtSQLVlStr(ctjTx($_POST['trarsp_dsc'],'out'), "text"));

		$Result = $__cnx->_prc($insertSQL); //$rsp['w'] = $insertSQL.' - '.$__cnx->c_p->error;
			if($Result){
			$rsp['e'] = 'ok';
			$rsp['m'] = 1;		
			$_Crm_Aud->In_Aud([ 'aud'=>_Cns('ID_AUDDSC_TRA_RSP_IN'), "db"=>$__t, "post"=>$_POST]);
			   
		}else{
			$rsp['e'] = 'no';
			$rsp['m'] = 2;
			if(ChckSESS_superadm()){ $rsp['w'] = $__cnx->c_p->error; }
			_ErrSis(['p'=>$insertSQL, 'd'=>$__cnx->c_p->error]);
		}
		
		$__cnx->_clsr($Result);
		
	}

	// Modificación de Registro
	if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "EdTraRsp")) { 
		$updateSQL = sprintf("UPDATE $__bd SET trarsp_us=%s, trarsp_us_asg=%s, trarsp_tra=%s, trarsp_tp=%s, trarsp_dsc=%s WHERE id_trarsp=%s",
						   GtSQLVlStr($_POST['trarsp_us'], "int"),
	                       GtSQLVlStr(SISUS_ID, "int"),
						   GtSQLVlStr($_POST['trarsp_tra'], "int"),
						   GtSQLVlStr($_POST['trarsp_tp'], "int"),
						   GtSQLVlStr(ctjTx($_POST['trarsp_dsc'],'out'), "text"),
						   GtSQLVlStr($_POST['id_trarsp'], "int"));
							   
		$Result = $__cnx->_prc($updateSQL);
		if($Result){
			$rsp['e'] = 'ok';
			$rsp['m'] = 1;
		}else{
			$rsp['e'] = 'no';
			$rsp['m'] = 2;
			$rsp['w'] = $__cnx->c_p->error;
			_ErrSis(['p'=>$updateSQL, 'd'=>$__cnx->c_p->error]);
		} 
		$__cnx->_clsr($Result);
	}

	// Elimino el Registro
	if ((isset($_POST['id_trarsp'])) && ($_POST['id_trarsp'] != '') && ((isset($_POST['MM_delete']))&&($_POST['MM_delete'] == 'EdTraRsp'))) { 
		$deleteSQL = sprintf("DELETE FROM $__bd WHERE id_trarsp=%s", GtSQLVlStr($_POST['id_trarsp'], "int")); $rsp['s'] = $deleteSQL;
		$Result = $__cnx->_prc($deleteSQL); 
		
		if($Result){
				$rsp['e'] = 'ok'; $rsp['m'] = 1;
				//$rsp['a'] = Aud_Sis(Aud_Dsc(27, $__cnx->c_p->insert_id, $__dt_abrcmp->tt), $rsp['v']);
				//$rsp['a'] = Aud_Sis(Aud_Dsc(537, 'Responsable de la tarea', $_POST['id_trarsp']), $rsp['v']);
		}else{
				$rsp['e'] = 'no';
				$rsp['m'] = 2; 
				$rsp['w'] = $__cnx->c_p->error;
				_ErrSis(['p'=>$deleteSQL, 'd'=>$__cnx->c_p->error]);
		}
		$__cnx->_clsr($Result);
	}
?>