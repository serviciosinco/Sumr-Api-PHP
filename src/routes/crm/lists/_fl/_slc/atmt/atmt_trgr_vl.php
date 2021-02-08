<?php 
	
	
	//--------- Post Data ----------//
	
		
		if(!isN($_POST['trgr'])){ $__trgr = Php_Ls_Cln($_POST['trgr']); }
		if(!isN($_POST['v_ls'])){ $__v_ls = Php_Ls_Cln($_POST['v_ls']); }
		if(!isN($_POST['v_vl'])){ $__v_vl = Php_Ls_Cln($_POST['v_vl']); }


	//--------- Detail of Trigger ----------//
		
		
		$__trgrdt = GtEcTrgrDt([ 'id'=>$__trgr, 'ls'=>$__v_ls, 'vl'=>$__v_vl ]);
	
	
	//--------- Show List ----------//
	
		
		if(!isN($__trgrdt->sbls)){
			
			if(!isN($__trgrdt->sbls->c)){
				echo $__trgrdt->sbls->c->html;
				$CntWb .= $__trgrdt->sbls->c->js;
			}
	        
		}elseif($__trgrdt->rvle == 'ok'){ 
			
			echo HTML_inp_tx('atmttrgr_v_vl', '', $__v_vl, '', $__rd_vl); 
			
		}
	
?>