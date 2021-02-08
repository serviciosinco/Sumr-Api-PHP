<?php
	
	try{
	
		$r['e'] = 'no';
		
		if(DMN == 'massivespace.rocks/'){
			$_prfx = 'massivespace';	
		}else{
			$_prfx = 'sumr';
		}
		
		
	
		if(PrmLnk('rtn', 2, 'ok') == 'widget'){
		
			include(DIR_CNT.'json/widget.php');
			
		}elseif(PrmLnk('rtn', 2, 'ok') == 'callme'){
		
			include(DIR_CNT.'json/callme.php');
			
		}elseif(PrmLnk('rtn', 2, 'ok') == 'callv'){
		
			include(DIR_CNT.'json/callv.php');
			
		}elseif(PrmLnk('rtn', 2, 'ok') == 'whtsp'){
		
			include(DIR_CNT.'json/whtsp.php');
			
		}
	
		
		//---------------------- COMPRIME - INCLUYE CONTENIDO ----------------------//	
		
		ob_start("cmpr_fm"); 
		Hdr_JSON();
		
		if($_prfx != 'sumr'){
			$r = str_replace(['sumr'], [$_prfx], $r);			
		}
		
		if(!isN($r)){ echo $_cbck . '(' .json_encode($r) . ')' ; }	
		ob_end_flush(); 
	
	
	}catch(Exception $e){    
        
        echo $e->getMessage();    
            
    }
                
                
?>