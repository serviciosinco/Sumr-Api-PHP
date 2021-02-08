<?php
if(ChckSESS_superadm() || ChckSESS_adm() || ChckSESS_usr()){
	
	$__old = enCad($_POST['us_passold']);
	$__mypsskey = Php_Ls_Cln($_POST['_mypsskey']);
	
	
	if(!isN($_POST['_i'.$__mypsskey])){
		if ((SISUS_PSS == $__old || $_POST['us_passold'] == 'no') && 
			(isset($_POST["MM_update"])) && ($_POST["MM_update"] == "EdUsPss") && 
			($_POST['us_pass'] != '') && ($_POST['us_pass'] == $_POST['us_passcnf'])) { 
			
				if($_POST['us_passold'] == 'no') { $_whr = 'us_enc'; }else{ $_whr = 'id_us'; }
			
			$updateSQL = sprintf("UPDATE "._BdStr(DBM).TB_US." SET us_pass=%s, us_pass_chn=%s WHERE ".$_whr." = %s ",
							   GtSQLVlStr(enCad($_POST['us_pass']), "text"),
							   GtSQLVlStr(2, "text"),
							   GtSQLVlStr($_POST['_i'], "text"));
			
			//$rsp['a'] = $updateSQL;
			
			$Result = $__cnx->_prc($updateSQL);
			 
			if($Result){
				$rsp['e'] = 'ok'; 
				$rsp['m'] = 1; 
				//$_dt_c = json_decode(GtUsDt($_POST['_i']));
				//$rsp['a'] = Aud_Sis(Aud_Dsc(33, $_dt_c->nm_all), $rsp['v']);	 
			}else{
				$rsp['e'] = 'nos';
				$rsp['m'] = 2;
				$rsp['w'] = $__cnx->c_p->error;
			} 	
		}else{		
			if((SISUS_PSS != $__old)){ $rsp['a'] = 'La clave ingresada no es igual a la actual'; }
			$rsp['e'] = 'no ay :(';
		}
	}
}
?>