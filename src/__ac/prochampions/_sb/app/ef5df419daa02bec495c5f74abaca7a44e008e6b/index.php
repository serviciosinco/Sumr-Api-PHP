<?php

    ob_start("compress_code");

    define('SISUS_ID', 3 );

    $__cl = __Cl([ 'id'=>$__pm_1, 't'=>'sbd' ]);

    if(isN($__cl->id)){
        $__cl = __Cl([ 't'=>'dmn', 'id'=>$_SERVER['HTTP_HOST'] ]);
        if(!isN($__cl->id)){ $__owndmn='ok'; }
        else{ $__cl = __Cl([ 'id'=>$__pm_1, 't'=>'sbd' ]); }

        if(!isN($__cl)){
            _StDbCl([ 'sbd'=>$__cl->sbd, 'enc'=>$__cl->enc, 'mre'=>$__cl ]);
        }else{
            $__chk = GtClDmnSubDt([ 't'=>'tp', 'id'=>'vtex', 'dmn'=>DMN_S, 'sub'=>Gt_SbDMN() ]);
            if(!isN($__chk->cl) && !isN($__chk->cl->id)){ $__dt_cl = __Cl([ 'id'=>$__chk->cl->id ]); }
        }
    }

    if($__owndmn == 'ok'){
        $_sbd = '/';
        $_pm_module = $__pm_1;
        $_pm_section = $__pm_2;
        $_pm_action = $__pm_3;
    }else{
        $_sbd = '/'.$__cl->sbd;
        $_pm_module = $__pm_2;
        $_pm_section = $__pm_3;
        $_pm_action = $__pm_4;
    }

    if(!isN($_pm_module)){

		if($_pm_section == 'process' || $_pm_section == 'data'){

			require_once(DIR_CNT."prc.php");

		}else{

            Hdr_HTML([ 'cche'=>'ok' ]);
			include('_cnt/fm.php');

        }
	}

ob_end_flush(); ?>