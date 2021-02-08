<?php
if ((isset($_POST["MM_Send"])) && ($_POST["MM_Send"] == "EcTll")) { 
	$as_adm = $_snd_nm.' compartio su PushMail';
	$as_us = $_snd_nm.' quiere compartir contigo ('.$__dtec->tt.')';
	
	if($_snd_cmnt != ''){
		$_html_cmnt = "<table width='100%' border='0' cellspacing='0' cellpadding='0'> <tr> <td style='color:#999; font-family:Tahoma, Geneva, sans-serif; font-size:11px; padding-top: 40px; padding-bottom: 40px;'>".$_snd_cmnt."</td> </tr> </table>";
	}
	
	$msj_adm = "Estimado usuario, <b style='color:#000; font-weight:bold;'>".$_snd_nm."</b> ha compartido con ".$_frnd_nm." el siguiente link: <table width='391' border='0' align='center' cellpadding='0' cellspacing='0'> <tr> <td style='padding-top:40px; padding-bottom:40px;'><a href='".DMN_EC.PrmLnk('bld', $__dtec->pml)."' target='_blank'><img src='".$__dtec->img_v->big."' width='100%' align='center'></a></td> </tr> </table> <table width='100%' border='0' cellspacing='0' cellpadding='0'> <tr> <td style='color:#00472A; font-family:Tahoma, Geneva, sans-serif; font-size:20px; padding-top: 40px; padding-bottom: 40px; border-top: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD;'>".$__dtec->tt."</td> </tr> </table> ".$_html_cmnt." ";
	$msj_adm = _htmlmail($msj_adm, $__dtec->tt, $__dtec->tp);
	
	$msj_us = "<b style='color:#000; font-weight:bold; font-size:18px;'><span style='font-size:12px;'></span>".$_frnd_nm."</b>, ".$_snd_nm." quiere compartir contigo el siguiente link: <table width='400' border='0' align='center' cellpadding='0' cellspacing='0'> <tr> <td style='padding-top:40px; padding-bottom:40px;'><a href='".DMN_EC.PrmLnk('bld', $__dtec->pml)."' target='_blank'><img src='".$__dtec->img_v->big."' width='100%' align='center'></a></td> </tr> </table> <table width='100%' border='0' cellspacing='0' cellpadding='0'> <tr> <td style='color: #000000; font-family: Tahoma, Geneva, sans-serif; font-size: 20px; padding-top: 40px; padding-bottom: 40px; border-top: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; line-height: 22px; font-weight: bold;'>".$__dtec->tt."</td> </tr> </table> ".$_html_cmnt." <table width='100%' border='0' cellpadding='0' cellspacing='0'> <tr> <td width='50%' align='right' valign='middle' style='width:50%; padding-right:50px; padding-bottom:15px; padding-top:15px;'><table width='119' border='0' align='right' cellpadding='0' cellspacing='0'> <tr> <td align='center' valign='middle' style='background-color: #000000; padding-top: 10px; padding-bottom: 10px; font-family: Tahoma, Geneva, sans-serif; color: #FFF; font-weight: bold; text-align: center; '><a href='".DMN_EC.PrmLnk('bld', $__dtec->pml)."' target='_blank' style='font-family:Tahoma, Geneva, sans-serif; color:#FFF; font-weight:bold; text-decoration:none;'>Ver Link</a></td> </tr> </table></td><td width='50%' align='left' valign='middle' style='width:50%; padding-left:50px; padding-bottom:15px; padding-top:15px;'><table width='119' border='0' align='left' cellpadding='0' cellspacing='0'><tr><td align='center' valign='middle' style='background-color: #009999; padding-top: 10px; padding-bottom: 10px; font-family: Tahoma, Geneva, sans-serif; color: #FFF; font-weight: bold; text-align: center;'><a href='".DMN_EC.PrmLnk('bld', $__dtec->pml)."?".DMN_EC_TLL."' target='_blank' style='font-family:Tahoma, Geneva, sans-serif; color:#FFF; font-weight:bold; text-decoration:none;'>Compartir</a></td></tr></table></td></tr> </table>";
	$msj_us = _htmlmail($msj_us, $__dtec->tt, $__dtec->tp);

	//------------ ENVIO EL CORREO ------------//
	
	$OnAdm = $_POST['SndEmad'];
	$OnUs = $_POST['SndUs'];
	$UsDest = $_frnd_eml;
	$AdmDest = $__dtec->eml;
	require('_snd.php');

}
?>