<?php 
	if (	
			_Chk_VLE('SndUs', 'p') && 
			_Chk_VLE('SndEmad', 'p') && 
			$_POST['SndUs'] == 'On' &&
			$_POST['SndEmad'] == 'On' &&
			_Chk_VLE('us_nm', 'p') &&
			_Chk_VLE('us_ap', 'p') &&
			_Chk_VLE('us_email', 'p')
		){
			
			
			$c_Rlc = '1,2,3,4,5'; if($__dtec->fm != NULL){ $c_Rlc = $__dtec->fm; }
			$Ls_Qry = "SELECT * FROM sis_fm WHERE id_sisfm IN (".$c_Rlc.") ORDER BY sisfm_or ASC";
			$Fld_Fm = $__cnx->_qry($Ls_Qry); 
			$row_Fld_Fm = $Fld_Fm->fetch_assoc(); 
			$Tot_Fld_Fm = $Fld_Fm->num_rows;
			
			$___us_nm = $_POST['us_nm'];
			$___us_ap = $_POST['us_ap'];
			$_usemail = $_POST['us_email'];
			
			do {	
				if((isset($_POST[$row_Fld_Fm['sisfm_cmp']]))&&($_POST[$row_Fld_Fm['sisfm_cmp']] != '')){	
					if($row_Fld_Fm['sisfm_cmp'] == 'us_msj'){ $__br= '<br>'; $__fntbld = 'normal'; }else{ $__fntbld = 'bold'; }			
					$__cmpct .= $__br."<span style=' font-size: 14px; font-weight: bold; color: #CAC9CB; font-family: Tahoma, Geneva, sans-serif; '>".ctjTx($row_Fld_Fm['sisfm_nm'],"in").":</span> <strong style='font-size: 16px; font-weight: ".$__fntbld."; color: #000; font-family: Tahoma, Geneva, sans-serif; '>".strip_tags($_POST[$row_Fld_Fm['sisfm_cmp']])."</strong><br>";
				}
			} while ($row_Fld_Fm = $Fld_Fm->fetch_assoc());
			
			include('em/html_cntc.php');

		if(($EmEst == 'ok')){
			$rsp['e'] = 'ok';
		}else{
			$rsp['e'] = 'no_send';
		}
		$__cnx->_clsr($Fld_Fm);
	}else{
		$rsp['e'] = 'no_data';
	}
?>