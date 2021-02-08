<?php 
	
	
	//--------- Post Data ----------//
	
		
		if(!isN($_POST['trgr'])){ $__trgr = Php_Ls_Cln($_POST['trgr']); }
		if(!isN($_POST['v_ls'])){ $__v_ls = Php_Ls_Cln($_POST['v_ls']); }
		if(!isN($_POST['v_vl'])){ $__v_vl = Php_Ls_Cln($_POST['v_vl']); }
	
	
	//--------- Detail of Trigger ----------//
	
		
		$__trgrdt = GtEcTrgrDt([ 'id'=>$__trgr, 'ls'=>$__v_ls, 'vl'=>$__v_vl ]);
	
	
	//--------- Show List ----------//
	
	
		if(!isN($__trgrdt->ls)){
			
			if(!isN($__trgrdt->ls->c)){
				echo $__trgrdt->ls->c->html;
				$CntWb .= $__trgrdt->ls->c->js;
			}
	        
		}elseif($__trgrdt->rvle == 'ok'){
			
			echo HTML_inp_tx('atmttrgr_v_vl', '', $__v_vl, '', $__rd_vl); 
			
		}
		
		
		if(!isN($__trgrdt->sbls)){ 
				
			$CntWb .= "
				
				
				function ShwTrgSlcSub(p){
					
					SUMR_Main.ld.f.slc({
						i:p.i, 
						t:'atmt_trgr_vl', 
						b:'atmt_trgr_vl_bx',
						d:p
					});
					
				}
										
										
				$('#atmttrgr_v_ls').change(function() {
					
					var v_vl = $(this).val();
					
					ShwTrgSlcSub({ 
            			trgr:'".$__trgrdt->id."', 
            			v_ls:'".$__v_ls."', 
            			v_vl:v_vl 
            		});
                                		
        		});
        		
        		
        		ShwTrgSlcSub({ 
        			trgr:'".$__trgrdt->id."', 
        			v_ls:'".$__v_ls."', 
        			v_vl:'".$__v_vl."' 
        		});
	        
	        ";	  
	        
		}	
	
?>