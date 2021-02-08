<?php 
	
	$__p3_o = PrmLnk('rtn', 3, 'ok');
	
	$_cl_us = _GetPost('cl_us'); //Usuario
	$_cl_enc = _GetPost('cl_enc'); //Cliente
	$_uses_enc = _GetPost('uses_enc'); //Cliente
	$_usdvc_tp = _GetPost('usdvc_tp'); //Device tipo
	$_usdvc_tkn = _GetPost('usdvc_tkn'); //Token tipo
	
	if(!isN($_cl_us)){ $__dt_us = GtUsDt($_cl_us, 'enc'); }
	if(!isN($_cl_us_oth)){ $__dt_us_oth = GtUsDt($_cl_us_oth, 'enc'); }
	
	if($__p3_o == 'dvc_psh'){
		
		include(GL_APP."dvc/dvc_psh.php");
		
	}
	
?>