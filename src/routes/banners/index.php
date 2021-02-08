<?php $pth = '../../includes/'; $__bdfrnt = 'ok'; include($pth .'inc.php'); ob_start("compress_code");



$__p1 = PrmLnk('rtn', 1, 'ok');
$__p2 = PrmLnk('rtn', 2, 'ok');
$__dtbn = GtBnDt($__p1, 'enc');
$__d = Php_Ls_Cln($_GET['__d']);

if(($__dtbn->url_abs != NULL) && ($__d != '')){
	$Dir = $__dtbn->url_abs;
	$DirJS = $__dtbn->url_abs;
}else{
	$Dir = DMN_BN.'fl/'.$__dtbn->dir.'/';
	$Dir_JS = DMN_BN.$__p1.'/';
}


$Dir_Swf = 'fl/'.$__dtbn->dir.'/src.swf?Rnd='.Gn_Rnd(20);
$Dir_Html = DMN_BN.'fl/'.$__dtbn->dir.'/src.html';

if(($__dtbn->id != NULL)){

	if($__dtbn->tp_id == 578){

		$__js = explode('.',$__p2);

		if($__js[1] != ''){
			include('_cnt/js.php');
		}else{
			include('_cnt/html5.php');
		}

	}elseif($__dtbn->tp_id == 581){

		$__js = explode('.',$__p2);

		if($__js[1] != ''){
			include('_cnt/js.php');
		}else{
			include('_cnt/html5.php');
		}

	}elseif($__dtbn->tp_id == 577){

		include('_cnt/jpg.php');

	}elseif($__dtbn->tp_id == 579){

		include('_cnt/jpg_crsl.php');

	}elseif($__dtbn->tp_id == 582){

		$__js = explode('.',$__p2);

		include('_cnt/video.php');


	}else{

		include('_cnt/swf.php');

	}

}

?>
<?php ob_end_flush(); ?>