<?php 

//$__me = $rsp['me']['onl'] = UPDus_Onl([ 'id'=>SISUS_ENC ]);	

//if($__me->e == 'ok'){
	
	$__Auto = new API_CRM_Auto();
	
	$rsp['live']['last'] = $__last;
	$rsp['session']['e'] = $_GtSesDt->e;
	$rsp['session']['est'] = $_GtSesDt->est;
	
	//$__usfa_lst = $__Auto->_UsBupd_Dt();

	$__lssb = _SbLs();
	$__frst = Php_Ls_Cln($_GET['_frst']);
	$__live = _jEnc( Php_Ls_Cln($_POST['_live']) );

	if( isN($___dir) ){
		$___dir = '/bupd/';
	}
	
	$___mdl = [/*'nty', 'nty_tra',*/ 'cht', 'onl'];
	
	//if($__live->scl->get == 'ok'){ $___mdl_lve[] = 'scl'; }
	if($__live->tra->get == 'ok'){ $___mdl_lve[] = 'tra'; }
	
	//---------------------  INCLUIR DATOS GENERALES ---------------------//
		
		
		if($_GtSesDt->est == 'ok'){
			
			foreach($___mdl as $k=>$v){
				try{
					$_fle = dirname(__FILE__).$___dir.$v.'.php';
					if(file_exists($_fle)){ include($_fle); }
				}catch(Exception $e){
					$rsp['w'] = $e->getMessage();
				}
			}
			
			
			if(!isN($___mdl_lve)){
				foreach($___mdl_lve as $k=>$v){
					try{
						$_fle = dirname(__FILE__).$___dir.$v.'.php';
						if(file_exists($_fle)){ include($_fle); }
					}catch(Exception $e){
						$rsp['w'] = $e->getMessage();
					}
				}
			}
			
		}
	
	//---------------------  INCLUYO PARTICULARIDADES DE CLIENTE ---------------------//
	
		//$___fl_cl = '../../'.DR_AC.DMN_SB.'/'.DIR_CNT_JSON.'us_bupd.php';
		//if(file_exists($___fl_cl)){ include($___fl_cl); }
	
	//---------------------  ACTUALIZO ULTIMA FECHA DE PETICION CLIENTE ---------------------//
		
		
		//$rsp['db']['upd'] = $__Auto->_UsBupd_Rq();	
	
	
	//--------------------- TOTAL DE REGISTROS NOTIFY ---------------------//	
		
		/*
		$dt_img = _ImVrs(['img'=>SISUS_IMG, 'f'=>DMN_FLE_US]);
			
		if(!isN( SISUS_IMG )){	
			if( !isN($dt_img->bg_s) ){
				$__img_url = $dt_img->bg_s;
			}else{
				$__img_url = $dt_img->th_c_100p;
			}	
		}else{	
			if(SISUS_GNR == _CId('ID_SX_H')){
				$__img_url = DIR_IMG_ESTR_SVG.'myp_nopic_m.svg';
			}elseif(SISUS_GNR == _CId('ID_SX_M')){
				$__img_url = DIR_IMG_ESTR_SVG.'myp_nopic_w.svg';
			}	
		}
		*/
		
		$rsp['live']['now'] = SIS_F_TS;

		/*
		$rsp['us']['enc'] = SISUS_ENC;
		$rsp['us']['img'] = $__img_url;
		$rsp['us']['nm'] = SISUS_NM." ".SISUS_AP;
		
//}






?>