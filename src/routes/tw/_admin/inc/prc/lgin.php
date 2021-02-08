<?php $pth = '../../'; include('../_inc.php');

if (isset($_POST['TwLgIn_User']) && isset($_POST['TwLgIn_Pass'])) {
  $loginUsername=$_POST['TwLgIn_User']; 
  $password=enCad($_POST['TwLgIn_Pass']); 
  $MM_fldUserAuthorization = "us_nvl";
  $MM_redirecttoReferrer = true;
  
  $LoginRS__query = sprintf("SELECT * FROM us WHERE us_user=%s AND us_pass=%s", GtSQLVlStr($loginUsername, "text"), GtSQLVlStr($password, "text"));
  $LoginRS = $__cnx->_qry($LoginRS__query);
  $row_LoginRS = $LoginRS->fetch_assoc(); 
  $loginFoundUser = $LoginRS->num_rows;

	  if ($loginFoundUser) {   
		mysqli_data_seek($LoginRS, 0);
        $loginStrGroup = $row_LoginRS['us_nivel'];
		
		if (PHP_VERSION >= 5.1) {session_regenerate_id(true);} else {session_regenerate_id();}
		//$_SESSION['SisHsh']= $row_LoginRS['us_tw_per'] ; //ctjTx($row_LoginRS['us_tw_per'],'text');
		$_SESSION['us_nivel']= $row_LoginRS['us_nivel'] ; 
		$_SESSION['MM_UsSv'] = $loginUsername;   
		$_SESSION['MM_UsGrp'] = $loginStrGroup;
			 
		$ActRdrUs = 'on';
		// Registro el Ingreso del Usuario				 
			$rsp['est'] = 'ok';		
	   }else{
			$rsp['est'] = 'no';
	   }
}else{
	$rsp['est'] = 'no';
}

$rtrn = json_encode($rsp); header('Content-type: application/json'); echo $rtrn;
$__cnx->_clsr($LoginRS);
?>