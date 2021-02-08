<?php 
	
	
	try{
		
		$_tp = Php_Ls_Cln($_POST['t']);
		$_dt = Php_Ls_Cln($_POST['d']);
		$_est = Php_Ls_Cln($_POST['est']);
		
		$_id_cl = Php_Ls_Cln($_POST['_id_mdl']);
		$_id_row = Php_Ls_Cln($_POST['_id_row']);
		$_ord = Php_Ls_Cln($_POST['_ord']);
		$_ord_old = Php_Ls_Cln($_POST['_order_old']);
		$__Cl = new CRM_Cl(); 
		$__Cl->post = $_POST; 
		$__Cl->db = $_tp;
		$__Cl->mdlstp = $_id_cl;
	
		if(!isN($_id_row) && $_dt == 'row'){
			$PrcDt = $__Cl->ClRow_Mod([ 'tp'=>'ord_null'  ]);
			if($PrcDt->e == true){
				foreach($_ord as $_k => $v){
				 	$i++;
				 	$PrcDt1 = $__Cl->ClRow_Mod([ 'ord' => $i, 'enc' => $_id_fm, 'row' => $v  ]);
				}	
			}
		}elseif(!isN($_id_row) && $_dt == 'self_row'){
			$PrcDt = $__Cl->ClRowFld_Mod([ 'enc'=>$_id_row, 'tp'=>'ord_null'  ]);
			if($PrcDt->e == true){
				foreach($_ord as $_k => $v){
				 	$i++;
				 	$PrcDt1 = $__Cl->ClRowFld_Mod([ 'ord' => $i, 'enc' => $_id_row, 'row' => $v  ]);
				}

				if($PrcDt1->e == true){
					$PrcCol= $__Cl->ClRowCol_Mod([ 'old' => 'no', 'cols' => count($_ord), 'enc' => $_id_row  ]);	
				
				}
			} 
		}elseif(!isN($_id_row) && $_dt == 'oth_row'){
		
			$PrcDt = $__Cl->ClRowFld_ModOth([ 'old'=>$_POST['old'], '_id'=>$_POST['_id'], '_id_row'=>$_POST['_id_row']  ]);
			if($PrcDt->e == true){
				
				foreach($_ord as $_k => $v){
				 	$i++;
				 	$PrcDt1 = $__Cl->ClRowFld_Mod([ 'ord' => $i, 'enc' => $_id_row, 'row' => $v  ]);
				 	
				}
				
				if($PrcDt1->e == true){
					
					$PrcCol= $__Cl->ClRowCol_Mod([ 'old' => 'ok' , 'cols' => count($_ord_old)-1, 'enc' => $_POST['old']  ]);
					$PrcCol2= $__Cl->ClRowCol_Mod([ 'old' => 'no', 'cols' => count($_ord), 'enc' => $_id_row  ]);	
				}
			}
		}elseif(!isN($_id_cl) && $_dt == 'new_row'){
			
			$_mdlstp_dt = GtMdlSTpDt(['enc'=>$_id_cl]);
			$PrcRow= $__Cl->ClRow_In([  'id'=>$_mdlstp_dt->id  ]);
				
		}elseif(!isN($_id_cl) && $_dt == 'nw_row'){
			
			$__Cl->clrow_enc = $_id_row;
			$__Cl->fld_enc = $_POST['_id']; 
			
			$PrcCol2= $__Cl->ClRowFld_In();
			if($PrcCol2->e == true){
				foreach($_ord as $_k => $v){
				 	$i++;
				 	$PrcDt1 = $__Cl->ClRowFld_Mod([ 'ord' => $i, 'enc' => $_id_row, 'row' => $v  ]);
				}

				if($PrcDt1->e == true){
					$PrcCol= $__Cl->ClRowCol_Mod([ 'old' => 'no', 'cols' => count($_ord), 'enc' => $_id_row  ]);	
				}
			}
		}elseif(!isN($_id_cl) && ($_dt == 'eli_row' || $_dt == 'eli_fld')){

			$__Cl->enc_eli = $_POST['_id']; 

			if($_dt == 'eli_row'){
				$PrcDel= $__Cl->ClRow_Del();	
			}else{
				$PrcDel= $__Cl->ClRowFld_Del();	
			}
			
			if($PrcDel->e){
				$rsp['e'] = 'ok';
				$rsp['tp'] = 'del -> '.$_dt;	
			}
		}
		
		if(!isN($PrcDt->w_n)){ $rsp['w_n'] = $PrcDt->w_n; }
		
		$rsp['cl']['in'] = $__Cl->ClRow_Ls();
		$rsp['cl']['out'] = $__Cl->ClRowAttr();
		
	}catch(Exception $e){
		$rsp['e'] = 'no';
		$rsp['w'] = TX_NSPPCSR.$e->getMessage();
	}
?>