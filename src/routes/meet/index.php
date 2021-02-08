<?php

	//---------------------- INCLUSIÓN DE ARCHIVOS ----------------------//

		$__tme_s = microtime(true);
		$Rt = '../../includes/';

		$__twiliosrc = 'ok';
		$__bdfrnt = 'ok';

		require($Rt.'inc.php');
		ob_start("compress_code");
		No_Cache();

		$rsp['ses'] = false;
		$call = new CRM_Call();

	//---------------------- INCLUSIÓN DE ARCHIVOS ----------------------//

		$__p1 = PrmLnk('rtn', 1, 'ok');
		$__p2 = PrmLnk('rtn', 2, 'ok');
		$__p3 = PrmLnk('rtn', 3, 'ok');
		$__p4 = PrmLnk('rtn', 4, 'ok');

	//---------------------- GET ACCOUNT ----------------------//

		$__owndmn='no';
		$__dt_cl = __Cl([ 'id'=>$__p1, 't'=>'sbd' ]);

		if(isN($__dt_cl->id)){
			$__dt_cl = __Cl([ 't'=>'dmn', 'id'=>$_SERVER['HTTP_HOST'] ]);
			if(!isN($__dt_cl->id)){
				$__owndmn='ok';
				$_call_tp = $__p1;
				$_call_act = $__p2;
				$__path = $__p1.'/';
			}
		}else{
			$_call_tp = $__p2;
			$_call_act = $__p3;
			$__path = $__p1.'/'.$__p2.'/';
		}

		if(!isN($__dt_cl->id)){ $call->cl = $__dt_cl; }else{ $_rdrct='ok'; }

	//---------------------- CONEXIÓN DE API ----------------------//

		if($_rdrct == 'ok'){
			header('Location:https://usoft.co/crm/modulos/llamadas/');
		}else{
			if($_call_tp == 'video'){
				include(dirname(__FILE__).'/_cnt/video.php');
			}elseif($_call_tp == 'voice'){
				include(dirname(__FILE__).'/_cnt/voice.php');
			}else{
				echo 'Display Main SubDomain Subsite';
			}
		}


?>
<?php ob_end_flush(); ?>