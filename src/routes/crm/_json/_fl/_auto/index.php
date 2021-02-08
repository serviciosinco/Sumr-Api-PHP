<?php 
	
	
	//@ini_set('display_errors', true); 
	//error_reporting(E_ALL & ~E_NOTICE /*&& ~E_WARNING*/);
			
			
	$__tp = Php_Ls_Cln($_POST['tp']);
	$__tp2 = Php_Ls_Cln($_POST['tp2']);
	$__up = Php_Ls_Cln($_POST['up']);
	$__cmpg = Php_Ls_Cln($_POST['cmpg']);
	$__dwn = Php_Ls_Cln($_POST['dwn']);
	
	
	
	if($__tp == 'up_ec_lsts' || $__tp == 'up_sms_cmpg' || $__tp == 'up'){
		
		$_auto_all = 'no';
		$_auto_fle = 'up.php';	
		
	}elseif($__tp == 'snd_sms_cmpg'){
		
		//$rsp['auto_snd'] = __AutoRUN([ 't'=>'snd', 's2'=>'sms', 'cl'=>'ok', 'lmt'=>40, 'id'=>$__cmpg ]);
		$_auto_fle = 'snd.php';
	
	}elseif($__tp == 'snd_ec_cmpg'){
		
		
		if(is_array($__cmpg)){ 
			foreach($__cmpg as $__cmpg_k=>$__cmpg_v){
				if($__cmpg_v['e'] == _CId('ID_ECCMPGEST_APRBD')){ $__s2='ec_cmpg'; }else{ $__s2='ec'; }
				//$rsp['auto_snd']['snd'][$__cmpg_k] = __AutoRUN(['t'=>'snd', 'cl'=>'ok', 's2'=>$__s2, 's3'=>'cmpg_snd', 'lmt'=>20, 'id'=>$__cmpg_v['id'], 'cmpg_snd'=>'ok' ]);
				//$rsp['auto_snd']['html'][$__cmpg_k] = __AutoRUN(['t'=>'snd', 'cl'=>'ok', 's2'=>'ec_html', 's3'=>'cmpg', 'lmt'=>20, 'id'=>$__cmpg_v['id'], 'cmpg_snd'=>'ok' ]); 
			}
		}
		
		$_auto_fle = 'snd.php';
		$_auto_all = 'no';
	
	}elseif($__tp == 'dwn'){

		if(is_array($__dwn)){ 
			
			foreach($__dwn as $__dwn_k=>$__dwn_v){ 
				
				$__dwn_dt = GtDwnDt([ 'id'=>$__dwn_v['id'], 't'=>'enc' ]);
				
				if($__dwn_dt->est != 1 || $__dwn_dt->est != 2 || $__dwn_dt->est != 5){
					if($__dwn_v['t'] == _CId('ID_UPEST_LD')){ $__t2='bd'; }else{ $__t2=$__tp2; } 
					
					if(ChckSESS_superadm()){
						//$rsp['auto_dwn'][$__dwn_k] = __AutoRUN(['t'=>'dwn', 'cl'=>'ok', 't2'=>$__dwn_v['tp2'], 'lmt'=>20, 'id'=>$__dwn_v['id']/*, 'o_rtrn'=>'no'*/ ]);
					}
					
				}
				
			}
			
		}
		
		$_auto_fle = 'dwn.php';
		$_auto_all = 'no';
	
	}
	
	if($_auto_all != 'no'){ 
		//$rsp['auto'] = __AutoRUN(['lmt'=>20, 'id'=>$__up]);
	}
	
	if(!isN($_auto_fle)){
		
		//$rsp['inc'] = GL_AUTO.$_auto_fle;
		include(GL_AUTO.$_auto_fle);
	
	}
	
?>