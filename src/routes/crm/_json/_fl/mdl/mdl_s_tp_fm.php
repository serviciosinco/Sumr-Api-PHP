<?php 
	try{
		$_tp = Php_Ls_Cln($_POST['t']);
		$_dt = Php_Ls_Cln($_POST['d']);
		$_est = Php_Ls_Cln($_POST['est']);
		$_id_fm = Php_Ls_Cln($_POST['_id_fm']);
		$_pos = Php_Ls_Cln($_POST['pos']);
		$_id_row = Php_Ls_Cln($_POST['id_row']);
		$_id_newfld = Php_Ls_Cln($_POST['_id_newfld']);
		$_id_old = Php_Ls_Cln($_POST['id_old']);
		$_id_start_int =  Php_Ls_Cln($_POST['id_start_int']);
		
		$__Cl = new CRM_Cl(); 
		$__Cl->post = $_POST; 
		$__Cl->db = $_tp;
		$__Cl->fm_id = $_id_fm;
		$__Cl->dt = $_dt;
		
		if($_dt == 'row' && $_est == 'in'){
			$PrcDt = $__Cl->MdlSTpFmRow_In();
		
			if($PrcDt->e == 'ok'){	
				$rsp['e'] = $PrcDt->e;
			}else{
				$rsp['w_n'] = $PrcDt->w_n;
				throw new Exception((ChckSESS_superadm()) ? "- ".$PrcDt->w : "");
			}
		}elseif($_dt == 'row_fld' && $_est == 'edt'){
			
			$__Cl->tt = Php_Ls_Cln($_POST['data']);
			$__Cl->fld = Php_Ls_Cln($_POST['id_row']);
			$__Cl->tp = Php_Ls_Cln($_POST['tp']);
			
			$PrcDt = $__Cl->MdlSTpFmRowFld_Edt();
		
			if($PrcDt->e == 'ok'){	
				$rsp['e'] = $PrcDt->e;
				$rsp['QRY'] = $PrcDt;
			}else{
				$rsp['w_n'] = $PrcDt->w_n;
				$rsp['all'] = $PrcDt;
				throw new Exception((ChckSESS_superadm()) ? "- ".$PrcDt->w : "");
			}
		}elseif($_dt == 'row_fld' && $_est == 'mod'){	
			

			$i = 0;
			if(Php_Ls_Cln($_POST['tp']) == 'fld_y'){
				$rsp['ord'] = 1;
				$PrcDt = $__Cl->MdlSTpFmRowFldOrd_Mod([ 'row' => $_id_row  ]);
				$PrcDt1 = $__Cl->MdlSTpFmRowFld_Mod([ 'ord' => 'NULL', 'enc' => $_id_start_int, 'row' => $_id_row , 'old' => $_id_old  ]);
				
		 
				if($PrcDt->e == 'ok'){
					foreach($_pos as $_k => $v){
					 	
					 	if(!isN($v)){
						 	$i++;	
						 
							$PrcDt = $__Cl->MdlSTpFmRowFld_Mod([ 'ord' => $i, 'enc' => $v, 'row' => $_id_row ]);
							$rsp['k'][$i] = $PrcDt;
 	
					 	}
					 						 	
					}	
				}	
				
				$PrcDt = $__Cl->MdlSTpFmRow_ModCols([ 'col' => count($_pos), 'row' => $_id_row ]);
				
				
				$rsp['row1'] = $__Cl->MdlSTpFmRowCol_Dt([ 'row' => $_id_row  ]);
				$row1 = $rsp['row1'];
				$PrcDt = $__Cl->MdlSTpFmRow_ModCols([ 'col' => $row1->tot, 'row' => $_id_row ]);
				
				
				$rsp['row2'] = $__Cl->MdlSTpFmRowCol_Dt([ 'row' => $_id_old  ]);
				$row2 = $rsp['row2'];
				$PrcDt = $__Cl->MdlSTpFmRow_ModCols([ 'col' => $row2->tot, 'row' => $_id_old ]);
				
								
			}else{
				$rsp['pos1'] = count($_pos);
				$PrcDt = $__Cl->MdlSTpFmRowFld_In([ 'enc' => $_id_newfld, 'row' => $_id_row  ]);
				foreach($_pos as $_k => $v){
				 	$i++;
				 	$PrcDt = $__Cl->MdlSTpFmRowFld_Mod([ 'ord' => $i, 'enc' => $v, 'row' => $_id_row  ]);
				 	$rsp['k'][$i] = $PrcDt;
				}
				$PrcDt = $__Cl->MdlSTpFmRow_ModCols([ 'col' => count($_pos), 'row' => $_id_row ]);
				
				
			}
		}elseif($_dt == 'row' && $_est == 'mod'){
		
			$PrcDt = $__Cl->MdlSTpFmRow_Mod([ 'enc' => $_id_fm, 'tp'=>'ord_null'  ]);
			$rsp['k'] = $PrcDt;	
			if($PrcDt->e == true){
				foreach($_pos as $_k => $v){
				 	$i++;
				 	$PrcDt1 = $__Cl->MdlSTpFmRow_Mod([ 'ord' => $i, 'enc' => $_id_fm, 'row' => $v  ]);
				 	$rsp['kx'][$i] = $PrcDt1;
				}	
			}
		}else if($_dt == 'row' && $_est == 'eli'){
			$rsp['id_row'] = $_id_row;	
			$PrcDt = $__Cl->MdlSTpFmRowFld_Eli([ 'enc' => $_id_row ]);
		
		}else if($_dt == 'row_fll' && $_est == 'eli'){
			$rsp['id_row'] = $_id_row;	
			$PrcDt = $__Cl->MdlSTpFmRow_Eli([ 'enc' => $_id_row ]);
			
		}else if($_dt == 'cnt_tp'){
			
			$_id =  Php_Ls_Cln($_POST['_id']);
			
			if($_est == 'ok'){
				$PrcDt = $__Cl->MdlSTpFmCntTp_In([ 'id_fm' => $_id_fm,  'id_cnttp' => $_id ]);		
			}else{
				$PrcDt = $__Cl->MdlSTpFmCntTp_Eli([ 'id_fm' => $_id_fm,  'id_cnttp' => $_id ]);	
			}	
		}
		$rsp['mdl_tp']['fm'] = $__Cl->MdlSTpFm_Ls();
	}catch(Exception $e){
		$rsp['e'] = 'no';
		$rsp['w'] = TX_NSPPCSR.$e->getMessage();
	}
?>