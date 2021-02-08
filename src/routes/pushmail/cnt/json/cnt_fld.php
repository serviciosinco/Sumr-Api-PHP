<?php
	
	//---------------- SETUP - START ----------------//
		
		$__rnd = Php_Ls_Cln($_POST['rnd']); 
		$__tp = Php_Ls_Cln($_POST['tp']); 
		$__id = Php_Ls_Cln($_POST['id']); 
		$__rel = Php_Ls_Cln($_POST['rel']); 
		$__vl = Php_Ls_Cln($_POST['vl']); 
		$__in = _jEnc(Php_Ls_Cln($_POST['in'])); 
		
	//---------------- SETUP - END ----------------//
		
		if($__in->tp == 'sis-list'){
			
			if($__id == 'sx'){	
				$l = __Ls([ 'k'=>'sx', 'id'=>'fld_'.$__rnd, 'v'=>'sisslc_enc', 'va'=>$__vl , 'ph'=>FM_LS_SISSX ]);	
			}	
			
			$rsp['html'] = $l->html;
			$rsp['js'] = $l->js;
			
		}elseif($__in->tp == 'date'){
			
			$rsp['html'] = SlDt([ 'id'=>'fld_'.$__rnd, 'rq'=>'no', 'va'=>$__vl, 'yr'=>'ok', 'ph'=>'', 'lmt'=>'no', 'cls'=>CLS_CLND ]);
			
		}elseif($__in->tp == 'city'){
			

			$rsp['html'] = LsCdOld(['id'=>'fld_'.$__rnd, 'v'=>'id_siscd', 'va'=>$__vl, 'rq'=>1 ]); 
			$rsp['js'] = JQ_Ls('fld_'.$__rnd, FM_LS_SLCD);
					                        
					                        
		}else{
			
			$rsp['html'] = '<input type="text" name="fld_'.$__rnd.'" class="" id="fld_'.$__rnd.'" style="" placeholder="" value="'.$__vl.'" required="" autocomplete="off">';
			
		}
		
		
	//-------------- PRINT RESULTS --------------//
	
		
		if(!isN( $rsp['html'] )){ $rsp['e'] = 'ok'; }
		
?>