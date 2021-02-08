<?php
if ((isset($_POST["MM_Send"])) && ($_POST["MM_Send"] == "EcCntc")) { 
	$as_adm = 'SOLICITUD RETIRO BASE DE DATOS';
	$as_us = $___us_nm.', hemos recibido su solicitud';
	
	list($_w, $_h, $_t, $_a) = getimagesize($__dtec->img_v->big);
	if ($_w < 400) { 
		$__mxhgimg = 'max-height:200px;';
		$__mxwdimg = '';
	}else{
		$__mxhgimg = '';
		$__mxwdimg = '100%';
	}
	
	$_img_all = "<table width='100%' border='0' align='center' cellpadding='0' cellspacing='0'> <tr> <td align='center' valign='middle' style='padding-top:40px; padding-bottom:20px;'><a href='".DMN_EC.PrmLnk('bld', $__dtec->pml)."' target='_blank'><img src='".$__dtec->img_v->big."' width='".$__mxwdimg."' align='center' style='".$__mxhgimg."'></a></td> </tr> </table>";
	
	$msj_adm = "Ha recibido una solicitud de retiro de la base de datos a través del e-Commerce <span style='color:#000;'>".$__dtec->tt."</span> , a continuación encontrará los detalles: ".$_img_all."<table width='100%' border='0' cellspacing='0' cellpadding='0'><tr><td style='padding-top:30px; padding-bottom:30px;'>".$__cmpct."</td></tr></table><table width='100%' border='0' align='center' cellpadding='0' cellspacing='0'><tr>  <td style='text-align:center;'><table width='119' border='0' align='center' cellpadding='0' cellspacing='0'><tr><td align='center' valign='middle' style='background-color:#00615B; padding-top:10px; padding-bottom:10px; font-family:Tahoma, Geneva, sans-serif; color:#FFF; font-weight:bold; text-align:center;'><a href='mailto:".$_usemail."' target='_blank' style='font-family:Tahoma, Geneva, sans-serif; color:#FFF; font-weight:bold; text-decoration:none;'>Responder</a></td></tr></table></td></tr> </table>";
	$msj_adm = _htmlmail($msj_adm, $__dtec->tt);
	
	$msj_us = $_img_all."".TX_HI." <b style='color:#000; font-weight:bold; font-size:18px;'>$___us_nm</b> ".TX_MSG_RSP;
	$msj_us = _htmlmail($msj_us, $__dtec->tt);

	//------------ ENVIO EL CORREO ------------//
	
	$OnAdm = $_POST['SndEmad'];
	$OnUs = $_POST['SndUs'];
	$UsDest = $_usemail;
	$AdmDest = $__dtec->eml;
	$AdmDestCpy = 'datospersonales@sumr.in';
	require('_snd.php');


}
?>