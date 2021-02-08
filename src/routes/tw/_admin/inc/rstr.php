<?php
if (!isset($_SESSION)) { session_start();}
$MM_authorizedUsers = "user,admin,superadmin";
$MM_donotCheckaccess = "false";

function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) {  
	$isValid = False; 
		 if (!empty($UserName)) {   
			$arrUsers = Explode(",", $strUsers);    
			$arrGroups = Explode(",", $strGroups);    
			 if (in_array($UserName, $arrUsers)) {      
				$isValid = true;
			 }    
			 if (in_array($UserGroup, $arrGroups)) {      
				$isValid = true;    
			 }    
			 if (($strUsers == "") && false) {      
				$isValid = true;    
			 }
	 	  }  
	return $isValid; 
}

if (!((isset($_SESSION['MM_UsSv'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['MM_UsSv'], $_SESSION['MM_UsGrp'])))) {    
	$MM_restrict = 'ok';
}else{
	$MM_restrict = 'no';
}
?>