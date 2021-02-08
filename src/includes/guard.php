<?php
if (!session_id() && $__tp != 'js') {session_start();}

$MM_authorizedUsers = enCad('user').','.enCad('admin').','.enCad('superadmin');
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

$MM_restrictGoTo = '/';
if (!((isset($_SESSION[DB_CL_ENC_SES.MM_ADM])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION[DB_CL_ENC_SES.MM_ADM], $_SESSION[DB_CL_ENC_SES.MM_ADM_GRP])))) {	
  if((isset($_GET['UsMl']))&&($_GET['UsMl']!='')){ $MM_restrictGoTo .= '?UsMl='.$_GET['UsMl'];}  
  header("Location: ". $MM_restrictGoTo); 
  exit;
}
?>