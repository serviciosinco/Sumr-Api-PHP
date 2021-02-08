<?php

    function PrmLnk($_t='', $_r_n='', $_pml=NULL){

		$__xpl = explode('?', $_SERVER['REQUEST_URI']);
		$prm_dt = explode('/', $__xpl[0]);

		if($_pml == 'ok'){
			$_prm_sb1 = $prm_dt[1];
			$_prm_sb2 = $prm_dt[2];
			$_prm_sb3 = $prm_dt[3];
			$_prm_sb4 = $prm_dt[4];
			$_prm_sb5 = $prm_dt[5];
		}

		if($_t == 'rtn'){
			$__val = ${'_prm_sb'.$_r_n};
		}

		return($__val);
    }

    if(PrmLnk('rtn', 1, 'ok') == 'api'){

        require dirname(__FILE__,4).'/includes/inc.php';

    }else{

        if(file_exists(dirname(__FILE__,4).'/includes/common.php')){
            require dirname(__FILE__,4).'/includes/common.php';
        }

        define('DMN_DG', $_SERVER['HTTP_X_FORWARDED_PROTO'].'://'.$_SERVER['HTTP_HOST'].'/');
        define('DMN_JS', 'https://js.'.(Dvlpr()?'sumrdev.com':'sumr.co').'/');
    }

?>