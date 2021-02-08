<?php $pth = '../../includes/'; include($pth .'__inc.php'); ob_start("compress_code");


// Chequea si existe Publicacion

	$__dtrd = GtRdDt(PrmLnk('rtn', 1), 'pm');

if ($__dtrd->id != NULL){
	if((isset($_GET['rD']))){
		if($row_Dt_rD['rd_shln']){
			$Frw_Pth .= $row_Dt_rD['rd_shln'].'/';
			$Frw_PmLn = 'on';
		}
		if($row_Dt_rD['rd_shln']){
			$Frw_Pth .= $row_Dt_rD['rd_shln'];
			$Frw_PmLn = 'on';
		}else{
			$Frw_Pth .= DMN_RD_LNK.$row_Dt_rD['rd_enc'];
		}

	}

	$iD_rD = $row_Dt_rD['id_rd']; // Id de Revista
	$Tt = ctjTx($row_Dt_rD['rd_tt'],'in'); // Titulo de Sitio
	$Dsc = strip_tags(ctjTx($row_Dt_rD['rd_dsc'],'in')); // Descripcion del Sitio
	$Afl_Tt = SP.ctjTx($row_Dt_rD['aflsuc_nm'],'in'); // Afiliado
	$Fldr = $row_Dt_rD['rd_dir']; // Folder
	$Rd_W = $row_Dt_rD['rd_w']; // Ancho de Revista
	$Rd_H = $row_Dt_rD['rd_h']; // Ancho de Revista
	$Rd_Lnk = DMN_RD_BS.DMN_RD_LNK.$row_Dt_rD['rd_enc'];

	$Hd1_Rt = DIR_RD_FL.$Fldr.'/hd_1.jpg';
	$Hd2_Rt = DIR_RD_FL.$Fldr.'/hd_2.jpg';

	if(file_exists($Hd1_Rt)){ list($ancho, $alto, $tipo, $atributos) = getimagesize($Hd1_Rt); $Img_Hd_1 = '<img src="../'.$Hd1_Rt.'" '.$atributos.' id="Hd_1" />';}
	if(file_exists($Hd2_Rt)){ list($ancho, $alto, $tipo, $atributos) = getimagesize($Hd2_Rt); $Img_Hd_2 = '<img src="../'.$Hd2_Rt.'" '.$atributos.' id="Hd_2" />';}

	$bd_hd = '<div id="Sv_Hd"><div id="BtnBar"></div><div id="fbMenu">'.$Img_Hd_1.$Img_Hd_2.'<img src="../img/flippingbook/btnPrevious.png" width="20" height="20" id="fbBackButton" /><img src="../img/flippingbook/btnNext.png" width="20" height="20" id="fbForwardButton" /></div>'.Rd_Ilk($Rd_Lnk).'</div>';
	$bd_cd = $bd_hd.'<div id="fbContainer"><a class="altlink" href="http://www.adobe.com/shockwave/download/download.cgi?P1_Prod_Version=ShockwaveFlash"><div id="altmsg">Download Adobe Flash Player.</div></a></div>';

	$Img_th = DIR_IMG_RD_TH.$row_Dt_rD['rd_img'];
	$Img = DIR_IMG_RD.$row_Dt_rD['rd_img'];

	if($Lnk != ''){
		$LnkRdr = $Lnk; $ActRdrct = 'ok';
	}else{
		$ActRdrct = 'off';
	}

	if(($mobile)){
		include('cnt/rd_mbl.php');
	}elseif(($iPad)){
		include('cnt/rd_ipd.php');
	}else{
		include('cnt/rd.php');
	}

}else{
	if(($mobile)){
		include('cnt/ls_mbl.php');
	}else{
		include('cnt/ls.php');
	}
}
mysql_free_result($Dt_rD);
?>
<?php ob_end_flush(); ?>