<?php 
	
	
	
	$__dwn = Php_Ls_Cln($_POST['dwn']);

	
	if(!isN($__dwn) && count($__dwn) > 0){
		
		$_dwn_bd=1;
		
		foreach($__dwn as $__dwn_k=>$__dwn_v){
		
			$__idwn = $__dwn_v['id'];
			$__ibd = '';
			
			$__dt_dwn = GtDwnDt(['id'=>$__idwn , 't'=>'enc' ]);
			
			$rsp['ls'][$__idwn]['o'] = $__dt_dwn;		
			$rsp['ls'][$__idwn]['id'] = $__dwn_v['id'];
			$rsp['ls'][$__idwn]['f'] = $__dwn_v['f'];
			
			$__all_sved = $__dt_dwn->tot->ok_x; 			
			$__all_rest = $__dt_dwn->tot->no_x;
			$_clr = '6d7071';
			
			if($__dt_dwn->est == 4){
				$__myprc = 25;
			}elseif($__dt_dwn->est == 3){
				$__myprc = 50;
			}elseif($__dt_dwn->est == 2){
				$__myprc = 75;
			}elseif($__dt_dwn->est == 1){
				$__myprc = 100;
			}
			
			$___js_avnc = _Kn_Prcn([ 'id'=>$__dwn_v['id'], 'l'=>'ok', 'v'=>$__myprc, 'w'=>'27', 'di'=>'ok', 'clr'=>$_clr ]); 
			
			
			$rsp['ls'][$__idwn]['n']['saved'] = $__all_sved;
			$rsp['ls'][$__idwn]['n']['rest'] = $__all_rest;
			$rsp['ls'][$__idwn]['n']['total'] = $__dt_dwn->tot->all;
			$rsp['ls'][$__idwn]['n']['html'] = $___js_avnc->html;
			$rsp['ls'][$__idwn]['n']['js'] = $___js_avnc->js;
			$rsp['ls'][$__idwn]['n']['est'] = $__dt_dwn->est;
			
			$rsp['e'] = 'ok';
			
			$__prcnt_s = ( ($__all_sved*100)/$__all_rest );
			
			$rsp['ls'][$__idwn]['p']['saved'] = _Nmb($__prcnt_s, 1);
			$rsp['ls'][$__idwn]['p']['rest'] = _Nmb($__prcnt_n, 1);
			
		}
	
	}
	
?>