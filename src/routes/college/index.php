<?php

	$Rt = '../../includes/'; $__pbc='ok'; $__https_off = 'off'; $__bdfrnt = 'ok';

	include($Rt.'inc.php'); header('Access-Control-Allow-Origin: *');

	//-------------------- GLOBAL - START --------------------//

		$__f = substr($_SERVER['REQUEST_URI'],  1);


		$__g_opq = Php_Ls_Cln($_GET['opaque']); //opaque=true
		$__g_icn = Php_Ls_Cln($_GET['icon']); //icon=true
		$__g_app = Php_Ls_Cln($_GET['app']); //app=true
		$__g_url = Php_Ls_Cln($_GET['url']); //icon=true
		$__g_trck = Php_Ls_Cln($_GET['trck']); //icon=true
		$__g_act = Php_Ls_Cln($_GET['act']); //act-related

		$__pm_1 = PrmLnk('rtn', 1, 'ok');
		$__pm_2 = PrmLnk('rtn', 2, 'ok');
		$__pm_3 = PrmLnk('rtn', 3, 'ok');
		$__pm_4 = PrmLnk('rtn', 4, 'ok');



		$__dt_cl = __Cl([ 'id'=>$__pm_1, 't'=>'clg' ]);



		if(isN($__dt_cl->id)){
			$__dt_cl = __Cl([ 't'=>'dmn', 'id'=>$_SERVER['HTTP_HOST'] ]);
			if(!isN($__dt_cl->id)){ $__owndmn='ok'; }
		}elseif(!isN( Gt_SbDMN() )){
			$__chk = GtClDmnSubDt([ 't'=>'tp', 'id'=>'clg', 'dmn'=>DMN_S, 'sub'=>Gt_SbDMN() ]);
			if(!isN($__chk->cl) && !isN($__chk->cl->id)){ $__dt_cl = __Cl([ 'id'=>$__chk->cl->id ]); }
		}else{
			$__dt_cl = __Cl([ 'id'=>$__pm_1, 't'=>'sbd' ]);
		}

		if(!isN($__dt_cl->sbd)){
			_StDbCl([ 'sbd'=>$__dt_cl->sbd, 'enc'=>$__dt_cl->enc, 'mre'=>$__dt_cl ]); _Cl_Lb([ 'sb'=>$__dt_cl->sbd ]);
			$__head_tt .= $__dt_cl->nm;
		}

	//-------------------- BUILD PRECLASS --------------------//

		if($__g_opq){ $_bdcss=' _opq '; }
		if(isN($__g_icn)){ $_bdcss.=' no-icn '; }
		if(!isN($__g_app)){ $_bdcss.=' app '; }

	//-------------------- BUILD HTML --------------------//

	if($__pm_1 != ''){

		if($__pm_1 == 'css'){

			require_once(DIR_INC."_css.php");

		}elseif($__pm_1 == 'process'){

			require_once(DIR_CNT."prc.php");

		}elseif($__pm_1 == 'search'){

			require_once(DIR_CNT."sch.php");

		}

	}else{

		require_once(DIR_CNT."html.php");

	}


?>