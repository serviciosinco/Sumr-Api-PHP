<?php
if ((isset($_POST["MM_Send"])) && ($_POST["MM_Send"] == "EcRprt")) { 

	if(!isN($__dtec->ord)){
		$as_us = '[Orden '.$__dtec->ord.'] su e-commerce ya esta on-line';	
	}else{
		$as_us = $__dtec->tt;;	
	}
	
	$lnk_dwn = DMN_DWN.PrmLnk('bld', LNK_EC).$__dtec->enc;
	$__url = DMN_FLE_EC."ec_ste_".$__dtec->enc.'.jpg';	
	$msj_us = "<table width='100%' border='0' cellspacing='0' cellpadding='0'><tr> <td style='padding-top:40px; padding-bottom:20px;'><a href='".DMN_EC.PrmLnk('bld', $__dtec->pml)."' target='_blank'><img src='".$__url."' width='200' heigth='300' align='center'></a></td> </tr></table><table width='100%' border='0' align='center' cellpadding='0' cellspacing='0'><tr><td width='1%' style='color: #999; font-size: 12px; font-weight: bold; padding-top: 10px; padding-bottom: 10px; padding-right: 10px; padding-left: 20px; font-family: Tahoma, Geneva, sans-serif; text-align: left; border-bottom-width: 2px; border-bottom-style: solid; border-bottom-color: #999;'><span style=' font-size: 14px; font-weight: bold; color: #528EC3; font-family: Tahoma, Geneva, sans-serif; '>Nombre</span></td><td width='99%' align='left' style='font-weight: normal; color: #333; vertical-align: middle; padding-top: 10px; padding-right: 20px; padding-bottom: 10px; padding-left: 10px; font-family: Tahoma, Geneva, sans-serif; font-size: 12px; border-bottom-width: 2px; border-bottom-style: solid; border-bottom-color: #CCC;'><strong>".$__dtec->tt."</strong></td></tr><tr><td width='1%' style='color: #999; font-size: 12px; font-weight: bold; padding-top: 10px; padding-bottom: 10px; padding-right: 10px; padding-left: 20px; font-family: Tahoma, Geneva, sans-serif; text-align: left; border-bottom-width: 2px; border-bottom-style: solid; border-bottom-color: #999;'><span style='text-align: center;'><span style=' font-size: 14px; font-weight: bold; color: #528EC3; font-family: Tahoma, Geneva, sans-serif; '>Descripcion</span></span></td><td width='99%' align='left' style='font-weight: normal; color: #333; vertical-align: middle; padding-top: 10px; padding-right: 20px; padding-bottom: 10px; padding-left: 10px; font-family: Tahoma, Geneva, sans-serif; font-size: 12px; border-bottom-width: 2px; border-bottom-style: solid; border-bottom-color: #CCC; text-align: left;'>".$__dtec->dsc."</td></tr></table><table width='100%' border='0' align='center' cellpadding='0' cellspacing='0'><tr><td width='50%' align='center' valign='middle' style='color: #999; font-size: 12px; font-weight: bold; padding-top: 30px; padding-bottom: 10px; padding-right: 20px; font-family: Tahoma, Geneva, sans-serif; text-align: left; '><table width='119' border='0' align='right' cellpadding='0' cellspacing='0'> <tr> <td align='center' valign='middle' nowrap='nowrap' style='background-color:#c35181; padding-top:10px; padding-bottom:10px; padding-right:15px; padding-left:15px; font-family:Tahoma, Geneva, sans-serif; color:#FFF; font-weight:bold; text-align:center;'><a href='".$lnk_dwn."' target='_blank' style='font-family:Tahoma, Geneva, sans-serif; color:#FFF; font-weight:bold; text-decoration:none;'>Opciones de descarga</a></td> </tr> </table></td><td width='50%' align='center' valign='middle' style='color: #999; font-size: 12px; font-weight: bold; padding-top: 30px; padding-bottom: 10px; padding-right: 0px; padding-left: 20px; font-family: Tahoma, Geneva, sans-serif; text-align: left;'><table width='119' border='0' align='left' cellpadding='0' cellspacing='0'><tr><td align='center' valign='middle' nowrap='nowrap' style='background-color:#528EC3; padding-top:10px; padding-bottom:10px; padding-right:15px; padding-left:15px; font-family:Tahoma, Geneva, sans-serif; color:#FFF; font-weight:bold; text-align:center;'><a href='' target='_blank' style='font-family:Tahoma, Geneva, sans-serif; color:#FFF; font-weight:bold; text-decoration:none;'>Realizar seguimiento</a></td></tr></table></td></tr></table>";
	$msj_us = _htmlsismail($msj_us, $__dtec->tt);
	$__us_dt = GtUsDt($_us_eml,'');
	
	//------------ ENVIO EL CORREO ------------//
	
	$OnUs = $_POST['SndUs'];
	
	
	$__snd = new API_CRM_SndMail();
	
	$__snd->cl->id = DB_CL_ID;
	$__snd->from_n  = $__dt_cl->nm;
	$__snd->from_c  = $__snd_eml_from; // From Campaña 
	$__snd->us_as  = $as_us;
	$__snd->us_to  = $__us_dt->eml;
	$__snd->us_msj = $msj_us;
	$__snd->x_id = $__snd_pxl;
	$__snd->sndr_e  = $__snd_eml;
	$__snd->rply_eml = $__snd_rply_eml;
	$__snd->rply_nm = $__snd_rply_nm;
	$__snd->mdl_fle = $__mdl_fle;
	$__snd->sndr = 'sumr';
	
	$_rsl_snd = $__snd->__SndMl();
	

}
?>