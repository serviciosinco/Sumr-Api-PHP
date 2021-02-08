<?php

define('RDS_IC_1', 'img/ic1.jpg');
define('RDS_IC_2', 'img/ic2.jpg');
define('RDS_IC_3', 'img/ic3.jpg');
define('RDS_IC_4', 'img/ic4.jpg');
define('RDS_IC_5', 'img/ic5.jpg');
define('RDS_IC_6', 'img/ic6.jpg');
define('RDS_IC_7', 'img/ic7.jpg');
define('RDS_IC_PDF', 'img/pdf.jpg');


function _htmlmail($_c=NULL, $_t=NULL, $__tp=NULL){
		if($_c != NULL){ $__cnt = $_c; } 
		if($_t != NULL){ $__tt = $_t; } 
		if($__tp == 'psg'){
				$__html = "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'><html xmlns='http://www.w3.org/1999/xhtml'><head><meta http-equiv='Content-Type' content='text/html; charset=UTF-8' /><title>".$__tt."</title></head><body style='padding:0px; margin:0px; background-color:#EEEEEE;'><table width='100%' border='0' cellspacing='0' cellpadding='0'> <tr> <td align='center' valign='middle' style='background: #000; padding: 0px; text-align:center;'><table width='100%' border='0' align='center' cellpadding='0' cellspacing='0' bgcolor='#EEEEEE' style='display: inline-table; width:100%;'><tr><td width='49%'><table width='100%' border='0' cellspacing='0' cellpadding='0'><tr><td><img name='enc_2_1' src='".DMN_EC."img/html/enc_2_1.jpg' width='100%' height='179' id='enc_2_1' alt='' style='width:100%;'/></td></tr></table></td><td><img name='enc_2_2' src='".DMN_EC."img/html/enc_2_2.jpg' width='550' height='179' id='enc_2_2' alt='' /></td><td width='49%'><table width='100%' border='0' cellspacing='0' cellpadding='0'><tr><td><img name='enc_2_3' src='".DMN_EC."img/html/enc_2_3.jpg' width='100%' height='179' id='enc_2_3' alt='' style='width:100%;'/></td></tr></table></td></tr></table></td> </tr> <tr> <td style='background-color:#EEEEEE;'><table width='543' border='0' align='center' cellpadding='0' cellspacing='0'> <tr> <td align='center' valign='middle' style='line-height:1px;'><table width='516' border='0' align='center' cellpadding='0' cellspacing='0'> <tr> <td style='background-color:#FFF; font-family:Tahoma, Geneva, sans-serif; font-size: 14px; line-height:16px; color:#666666; padding-top: 10px; padding-bottom:10px; padding-right:40px; padding-left:40px; text-align:center; '>".$__cnt."</td> </tr> </table></td> </tr> </table></td> </tr> <tr> <td align='center' valign='middle' style='background-color:#EEEEEE; text-align:center; padding-top:50px; padding-bottom:50px; '>&nbsp;</td> </tr></table></body></html>";
		}elseif($__tp == 'prg'){
				$__html = "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'><html xmlns='http://www.w3.org/1999/xhtml'><head><meta http-equiv='Content-Type' content='text/html; charset=UTF-8' /><title>".$__tt."</title></head><body style='padding:0px; margin:0px; background-color:#EEEEEE;'><table width='100%' border='0' cellspacing='0' cellpadding='0'> <tr> <td align='center' valign='middle' style='background: #000; padding: 0px; text-align:center;'><table width='100%' border='0' align='center' cellpadding='0' cellspacing='0' bgcolor='#EEEEEE' style='display: inline-table; width:100%;'><tr><td width='49%'><table width='100%' border='0' cellspacing='0' cellpadding='0'><tr><td><img name='enc_2_1' src='".DMN_EC."img/html/enc_2_1.jpg' width='100%' height='179' id='enc_2_1' alt='' style='width:100%;'/></td></tr></table></td><td><img name='enc_2_2' src='".DMN_EC."img/html/enc_2_2.jpg' width='550' height='179' id='enc_2_2' alt='' /></td><td width='49%'><table width='100%' border='0' cellspacing='0' cellpadding='0'><tr><td><img name='enc_2_3' src='".DMN_EC."img/html/enc_2_3.jpg' width='100%' height='179' id='enc_2_3' alt='' style='width:100%;'/></td></tr></table></td></tr></table></td> </tr> <tr> <td style='background-color:#EEEEEE;'><table width='543' border='0' align='center' cellpadding='0' cellspacing='0'> <tr> <td align='center' valign='middle' style='line-height:1px;'><table width='516' border='0' align='center' cellpadding='0' cellspacing='0'> <tr> <td style='background-color:#FFF; font-family:Tahoma, Geneva, sans-serif; font-size: 14px; line-height:16px; color:#666666; padding-top: 10px; padding-bottom:10px; padding-right:40px; padding-left:40px; text-align:center; '>".$__cnt."</td> </tr> </table></td> </tr> </table></td> </tr> <tr> <td align='center' valign='middle' style='background-color:#EEEEEE; text-align:center; padding-top:50px; padding-bottom:50px; '>&nbsp;</td> </tr></table></body></html>";
		}else{
				$__html = "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'><html xmlns='http://www.w3.org/1999/xhtml'><head><meta http-equiv='Content-Type' content='text/html; charset=UTF-8' /><title>".$__tt."</title></head><body style='padding:0px; margin:0px; background-color:#EEEEEE;'><table width='100%' border='0' cellspacing='0' cellpadding='0'> <tr> <td align='center' valign='middle' style='background: #000; padding: 0px; text-align:center;'><table width='100%' border='0' align='center' cellpadding='0' cellspacing='0' bgcolor='#EEEEEE' style='display: inline-table; width:100%;'><tr><td width='49%'><table width='100%' border='0' cellspacing='0' cellpadding='0'><tr><td><img name='enc_1_1' src='".DMN_EC."img/html/enc_1_1.jpg' width='100%' height='179' id='enc_1_1' alt='' style='width:100%;'/></td></tr></table></td><td><img name='enc_1_2' src='".DMN_EC."img/html/enc_1_2.jpg' width='550' height='179' id='enc_1_2' alt='' /></td><td width='49%'><table width='100%' border='0' cellspacing='0' cellpadding='0'><tr><td><img name='enc_1_3' src='".DMN_EC."img/html/enc_1_3.jpg' width='100%' height='179' id='enc_1_3' alt='' style='width:100%;'/></td></tr></table></td></tr></table></td> </tr> <tr> <td style='background-color:#EEEEEE;'><table width='543' border='0' align='center' cellpadding='0' cellspacing='0'> <tr> <td align='center' valign='middle' style='line-height:1px;'><table width='516' border='0' align='center' cellpadding='0' cellspacing='0'> <tr> <td style='background-color:#FFF; font-family:Tahoma, Geneva, sans-serif; font-size: 14px; line-height:16px; color:#666666; padding-top: 10px; padding-bottom:10px; padding-right:40px; padding-left:40px; text-align:center; '>".$__cnt."</td> </tr> </table></td> </tr> </table></td> </tr> <tr> <td align='center' valign='middle' style='background-color:#EEEEEE; text-align:center; padding-top:50px; padding-bottom:50px; '>&nbsp;</td> </tr></table></body></html>"; 
		}
		return($__html);
}


// Construccion de Tabla
function _html_btable($nm,$cnt='',$F='FFF',$Tp=''){
	if($nm != ''){
		if($Tp=='Ml'){ $StyMl = ' style="width: 100%;" '; }
		if($F!=''){ $_bgtb = "bgcolor=\"#".$F."\"";}
		$NwBod .= "<table $_bgtb ".$StyMl." align=\"center\" width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\"><tr><td align=\"center\">".$cnt."</td></tr></table>";
		return($NwBod);
	}
}


// Encabezado HTML Mails
function _html_head($_i=NULL){
	$__dtec = GtEcDt($_i);
	$__spn = '#00482B';
	$__shr_lnk = urlencode($__dtec->shr);
    $__shr_tt = urlencode($__dtec->tt);							
	$_shr_fb = "https://www.facebook.com/sharer/sharer.php?u=".$__shr_lnk."&display=popup";
    $_shr_tw = "https://twitter.com/intent/tweet?text=".$__shr_tt."&tw_p=&url=".$__shr_lnk."&via=SUMR";
    $_shr_ld = "http://www.linkedin.com/shareArticle?mini=true&url=".$__shr_lnk."&title=".$__shr_tt."&source=SUMR";
    $_shr_go = "https://plus.google.com/share?url=".$__shr_lnk;
    $_shr_pn = "http://pinterest.com/pin/create/button/?url=".$__shr_lnk."&media=".urlencode($__dtec->img_v->big)."&description=".$__shr_tt;
	$_pml = DMN_EC.PrmLnk('bld', $__dtec->pml);
	
	if($__dtec->pdf == 1){ $_pdf .= '<td><a title="Pdf" href="" target="_blank"><img title="Pdf" alt="Pdf" src="'.DMN_EC.RDS_IC_6.'" width="25" height="25"></a></td>'; }		
	$Cod = '<table width="600" border="0" cellspacing="0" cellpadding="0" style="margin-left:auto;margin-right:auto;">
				<tr>
					<td bgcolor="#FFFFFF" style=" padding-top: 4px; padding-bottom: 4px; border-bottom-width: 1px; border-bottom-style: solid; border-bottom-color: #999; background-color: #FFF;">
						<table cellSpacing="0" cellPadding="0" align="center" style="margin-left:auto;margin-right:auto;">
							<tbody>
								<tr>
									<td valign="center" nowrap style="text-align: center;vertical-align: middle; font-family: Tahoma, Geneva, sans-serif; font-size:11px; font-style:normal;font-weight: normal; color: #999; padding-right:15px;">&iquest;'.TX_CNTML.'<b><br><a title="On-Line" href="'.$_pml.'" target="_blank" style="font-family: Tahoma, Geneva, sans-serif; font-size: 11px;font-style: normal;font-weight: 300;color:#'.$__dtec->spn.'; text-decoration: none;">Ver Online</a></b></td>
									<td valign="center" style="padding-left: 15px; /* padding-right: 15px; border-right: 1px solid #CCC; */ border-left: 1px solid #CCC;">
										<table cellSpacing="0" cellPadding="4">
											<tbody>
												<tr>
													<td><a href="'.$_shr_fb.'" target="_blank"><img src="'.DMN_EC.RDS_IC_1.'" width="25" height="25"></a></td> 
													<td><a href="'.$_shr_tw.'" target="_blank"><img src="'.DMN_EC.RDS_IC_2.'?Rnd='.Gn_Rnd(5).'" width="25" height="25"></a></td>
													<td><a href="'.$_shr_ld.'" target="_blank"><img src="'.DMN_EC.RDS_IC_3.'" width="25" height="25"></a></td>
													<td><a href="'.$_shr_go.'" target="_blank"><img src="'.DMN_EC.RDS_IC_4.'" width="25" height="25"></a></td>
													<td><a href="'.$_shr_pn.'" target="_blank"><img src="'.DMN_EC.RDS_IC_5.'" width="25" height="25"></a></td>
													'.$_pdf.'
												</tr>
											</tbody>
										</table>
									</td>
									<!--<td valign="center" style="padding-left:15px;">
										<table cellSpacing="0" cellPadding="4">
											<tbody>
												<tr>
													<td nowrap style="text-align: center;vertical-align: middle; font-family: Tahoma, Geneva, sans-serif;font-size: 11px;font-style: normal; font-weight: normal; color: #999;"><b><a href="'.$_pml.'?'.DMN_EC_TLL.'" target="_blank" style="font-family: Tahoma, Geneva, sans-serif;font-size: 11px;font-style: normal;font-weight:300;color:#'.$__spn.'; text-decoration: none; line-height:10px;">'.TX_FRWRD.' <br>'.TX_FRND.'</a></b></td>
													<td nowrap ><img src="'.DMN_EC.RDS_IC_7.'" width="25" height="25"></td>
												</tr>
											</tbody>
										</table>
									</td>-->
								</tr>
							</tbody> 
						</table>
					</td>
				</tr>
			</table>';
	return($Cod);
}


//No Deseado
function _html_nomore($_i=NULL){
	$__dtec = GtEcDt($_i);
	$_pml = DMN_EC.PrmLnk('bld', $__dtec->pml);

	$Cod = '<table align="center" style="align: center; width:600px; max-width:600px;" width="600">
				<tr>
					<td style="text-align:center; vertical-align: middle; font-family: Tahoma, Geneva, sans-serif;font-size: 10px;font-style: normal;line-height: normal;font-weight: normal;color: #333333;">&nbsp;</td>
				</tr>
				<tr>
					<td style="text-align: justify;vertical-align: middle; font-family: Tahoma, Geneva, sans-serif;font-size: 11px;font-style: normal;line-height: normal;font-weight: normal;color: #999999;">'.TX_ECHBSDT.'</td>
				</tr>
				<tr>
					<td style="text-align: center;vertical-align: middle; font-family: Tahoma, Geneva, sans-serif;font-size: 9px;font-style: normal;line-height: normal;font-weight: normal;color: #333333;">&nbsp;</td>
				</tr>
				<!--<tr>
					<td style="text-align: center;vertical-align: middle; font-family: Tahoma, Geneva, sans-serif;font-size: 11px;font-style: normal;line-height: normal;font-weight: normal;color: #333333;"><a href="'.$_pml.'?'.DMN_EC_DEL.'" style="color:#'.$sp.'">'.TX_CNDLLST.' (Remove)</a> | <a href="'.$_pml.'?'.DMN_EC_UPD.'" style="color:#'.$sp.'">'.TX_UPDTDT.'</a> | <a href="'.$_pml.'?'.DMN_EC_TLL.'" style="color:#'.$sp.'">'.TX_FRWRD.TX_FRND.'</a></td>
				</tr>-->
			</table>';

	return($Cod);
}

?>