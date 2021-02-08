<?php 
	
	
	try{
		

		$_tp = Php_Ls_Cln($_POST['t']);
		$_dt = Php_Ls_Cln($_POST['d']);
		$_est = Php_Ls_Cln($_POST['est']);

		$_vl_tag = Php_Ls_Cln($_POST['_vl_tag']);
		$_id_bco = Php_Ls_Cln($_POST['_id_bco']);
		$_id_bco_n = Php_Ls_Cln($_POST['_id_bco_n']);

		$__Cl = new CRM_Bco(); 
		$__Cl->post = $_POST; 
		$__Cl->db = $_tp;
		
		$__Cl->bco_id = $_id_bco;
		$__Cl->bco_id_n = $_id_bco_n;
		$__Cl->vl_tag = $_vl_tag;
		
			
		if($_dt == 'tag'){
			
			if($_est == 'in'){
				$__chk = GtBcoTagDt([ 'bco'=>$_id_bco_n, 'tag_es'=>$_vl_tag ]);
	
				if($__chk->e != 'ok'){
					$PrcDt = $__Cl->_Tag_In([ 'bco'=>$_id_bco_n, 'tag_es'=>$_vl_tag ]);
					
					if($PrcDt->e == 'ok'){	
						$rsp['e'] = $PrcDt->e;
					}else{
						throw new Exception((ChckSESS_superadm()) ? "- ".$PrcDt->w : "");
					}	
				}else{
					$rsp['e'] = 'no';	
				}	
				
			}elseif($_est == 'del'){
				$PrcDt = $__Cl->_Tag_Del([ 'bco'=>$_id_bco_n, 'tag'=>$_vl_tag ]);
					
				if($PrcDt->e == 'ok'){	
					$rsp['e'] = $PrcDt->e;
				}else{
					throw new Exception((ChckSESS_superadm()) ? "- ".$PrcDt->w : "");
				}	
			}

		}
		
		if(!isN($PrcDt->w_n)){ $rsp['w_n'] = $PrcDt->w_n; }
		
		$rsp['bco']['tag'] = $__Cl->BcoTag_Ls();
		
		
	}catch(Exception $e){
		$rsp['e'] = 'no';
		$rsp['w'] = TX_NSPPCSR .$e->getMessage();
	}
	
?>