<?php

	header("Access-Control-Allow-Origin: *");

	$__p2_o = PrmLnk('rtn', 2, 'ok');


	$__chat = new CRM_Chat();

	$_cl_us = _GetPost('cl_us'); //Mi usuario.
	$_cl_us_oth = _GetPost('cl_us_oth'); //Usuario con quien converso.
	$_usdvc_id = _GetPost('usdvc_id'); //Usuario con quien converso.

	$_cl_enc = _GetPost('cl_enc');
	$_uses_enc = _GetPost('_uses_enc');

	$_cnv_enc = _GetPost('cnv_enc');
	$_cnvrmsj_msj = _GetPost('cnvrmsj_msj');
	$_cnvrmsj_cnvr = _GetPost('cnvrmsj_cnvr');

	$_sess_enc = _GetPost('_ses');

	if( !isN($_sess_enc) ){
		$_GtSesDt = $___ses->GtSesDt([ 'i'=>$_sess_enc ]);
	}

	if(!isN( $_cl_us )){ $__us_dt = GtUsDt( $_cl_us, 'enc' ); }

	if(!isN( $__us_dt->msv_usr )){
		$__massive = new API_CRM_Massive();
		$__lgin = $__massive->us_actv([ 'us'=>$__us_dt->msv_usr, 'actv'=>'on' ]);
	}

	if($__p2_o == 'login'){

		include(GL_APP."lgin/login.php");

	}elseif($__p2_o == 'login_cl'){

		include(GL_APP."lgin/logincustomer.php");

	}elseif($__p2_o == 'tra'){

		include(GL_APP."tra/_gn.php");

	}else if($__p2_o == 'chat'){

		include(GL_APP."chat/_gn.php");

	}else if($__p2_o == 'mdl_cnt'){

		include(GL_APP."mdl_cnt/_gn.php");

	}else if($__p2_o == 'dvc'){

		include(GL_APP."dvc/_gn.php");

	}



?>