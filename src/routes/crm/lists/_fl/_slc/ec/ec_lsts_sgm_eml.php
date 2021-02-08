<?php
	$wvar = 'ok';
	$mlt = 'ok';

	if(!isN($_POST['wvar'])){ $wvar = $_POST['wvar']; }
	if(!isN($_POST['mlt'])){ $mlt = $_POST['mlt']; }

	echo LsEcLstsSgm($__ts.$__t_s_e, 'eclstssgm_enc', $__i, '', 2, '', $mlt, [ 'lsts'=>$__t_s_i, 'wvar'=>$wvar ] );

	$CntWb .= JQ_Ls($__ts.$__t_s_e, FM_LS_SLPRC);
	
?>