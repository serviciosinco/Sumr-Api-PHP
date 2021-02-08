<?php 
	
	//@ini_set('display_errors', true); 
	//error_reporting(E_ALL & ~E_NOTICE);
	
	if (((isset($_POST['MM_update_fle']))&&($_POST['MM_update_fle'] == 'FleUplNw'))) {
		
		if (!empty($_FILES)) {
			
			$__i_f = Php_Ls_Cln($_POST['id_appl']);
			$__i_r = Php_Ls_Cln($_POST['cntapplanx_attr']);
			$__i_cl = Php_Ls_Cln($_POST['___cl']);
			$____fl_nm = 'fle';
			
			$Sch = [DMN_BS];
			$Chn = [''];
			
			$allowed = ['jpg','jpeg','pdf'];

			$__fl_nm_bfr = $_FILES['upl']['name'];

			
			if(isset($_FILES['upl']) && $_FILES['upl']['error'] == 0){
				
				$__fl_ext = pathinfo($_FILES['upl']['name'], PATHINFO_EXTENSION);
				
				if(!in_array(strtolower($__fl_ext), $allowed)){
					
					$rsp['status'] = 'error'; $rsp['w'] = TX_FLE_NO_SUP;
					
				}else{
					
					
					$__fl_nm = $_FILES['upl']['name'];
					$__fl_sze = $_FILES['upl']['size'];
					$__tmp_nm = $_FILES['upl']['tmp_name'];
					
					$_i = $__i_f;
					
					
					if(!isN($_i)){
						
						$rsp['i'] = $__i_f;
						
						$__nw_nm = $____fl_nm.'_'.$_i.'.'.$__fl_ext;
						$__nw_fld = '../../../'.DIR_FLE_ANX;
						
						//$rsp['move_to'] = $__nw_fld.$__nw_nm;
						
						//echo "ei"; exit();
						
						$_sve = $_aws->_s3_put([ 'b'=>'anx', 'fle'=>_TmpFixDir($__nw_nm), 'src'=>$__tmp_nm, 'ctp'=>mime_content_type($__tmp_nm) ]);
						
						if(move_uploaded_file($__tmp_nm, $__nw_fld.$__nw_nm) && $_sve->e == "ok"){
							
							$__dtcl = GtClDt($__i_cl, 'enc');
							
							$__enc = Enc_Rnd($__fl_nm.'-'.$__nw_nm);
						
							
							$insertSQL = sprintf("INSERT INTO ".TB_CNT_APPL_ANX." (
																					cntapplanx_enc, 
																					cntapplanx_fle, 
																					cntapplanx_cntappl, 
																					cntapplanx_attr, 
																					cntapplanx_est
																				) VALUES 
																				(
																					%s,
																					%s, 
																					(SELECT id_cntappl FROM ".TB_CNT_APPL." WHERE cntappl_enc = %s), 
																					%s,
																					%s
																				)",
									GtSQLVlStr($__enc, "text"),
									GtSQLVlStr($__nw_nm, "text"),
									GtSQLVlStr($__i_f, "text"),
									GtSQLVlStr($__i_r, "int"),
									GtSQLVlStr(_CId('ID_SISSINO_SI'), "int"));

							/*$Result =$__cnx->_prc($insertSQL);		
							$_i = $__cnx->c_p->insert_id;*/
							
							$Result = $__cnx->_prc($insertSQL);		
							$_i = $__cnx->c_p->insert_id;
							
							$rsp['e'] = 'ok';
							$rsp['status'] = 'success';
							$rsp['statuddds'] = $__cnx->c_p->error;
						
							
						
						}else{
							$rsp['status'] = 'error'; $rsp['w'] = TX_PRB_MOV_FLE;
						}
						
						
						//$__cnx->_clsr($Result);
						
						
					}else{
						$rsp['status'] = 'error'; $rsp['w'] = TX_NO_GRN_DB;
						_ErrSis([ 'p'=>$insertSQL, 'd'=>$__cnx->c_p->error ]);	
					}
				}			
				
				
			}else{
				$rsp['status'] = 'error'; $rsp['w'] = TX_NO_RCV_FLE; 
			}
		}

	}else{
		$rsp['e'] = 'no'; $rsp['m'] = 2; $rsp['status'] = 'error';	$rsp['w'] = 'No Upd File';
	}

	Hdr_JSON();
	$rtrn = json_encode($rsp); echo $rtrn;

?>