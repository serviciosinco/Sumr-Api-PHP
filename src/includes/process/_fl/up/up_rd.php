<?php 
	
$__tsim = Php_Ls_Cln($_POST['__tsim']);

if (((isset($_POST['MM_update_fle']))&&($_POST['MM_update_fle'] == 'FleUplNw'))) {
	
	if (!empty($_FILES)) {
		
		$__i_f = Php_Ls_Cln($_POST['_id_fle']);
		$__i_r = Php_Ls_Cln($_POST['_id_rlc']);
		$____fl_fld = DIR_FLE_SIM;
		$____fl_nm = 'fle';
		
		$Sch = array(DMN_BS);
		$Chn = array('');
		
		$Fldr_Rl = str_replace($Sch,$Chn,$____fl_fld);
		
		if($__tsim == 'rd_fle'){
			$allowed = ['pdf'];
		}else{
			$allowed = ['jpg','jpeg','gif','pdf','png'];
		}

		$__fl_nm_bfr = $_FILES['upl']['name'];

		if(isset($_FILES['upl']) && $_FILES['upl']['error'] == 0){
			
			$__fl_ext = pathinfo($_FILES['upl']['name'], PATHINFO_EXTENSION);
			
			if(!in_array(strtolower($__fl_ext), $allowed)){
				
				$rsp['status'] = 'error'; $rsp['w'] = TX_FLE_NO_SUP;
				
			}else{
				
				global $__cnx;
				
				$__fl_nm = $_FILES['upl']['name'];
				$__fl_sze = $_FILES['upl']['size'];
				$__tmp_nm = $_FILES['upl']['tmp_name'];

				if(!isN($__i_r)){
					
					$rsp['i'] = $__i_r;
					
					$__nw_nm = $____fl_nm.'_'.$__i_r.'.'.$__fl_ext;
					//$__nw_fld = '../../../../../../../'.DIR_RD_FLE;
					$__nw_fld = '../../../'.DIR_RD;
					try{	

						$_sve = $_aws->_s3_put([ 'b'=>'fle', 'fle'=>_TmpFixDir($__nw_fld.$__nw_nm), 'src'=>$__tmp_nm, 'ctp'=>mime_content_type($__tmp_nm), 'cfr'=>'ok' ]);
						$rsp['save'] = $_sve;

					}catch(Exception $e){
						$rsp['e'] = 'no';
						$rsp['w'] = $e->getMessage();
					}
					
					try{	

						if(move_uploaded_file($__tmp_nm, $__nw_fld.$__nw_nm) && $_sve->e == 'ok'){
						
							$updateSQL = sprintf("UPDATE "._BdStr(DBM).TB_RD." SET rd_fle=%s WHERE rd_enc=%s",
													GtSQLVlStr($__nw_nm, "text"),             						 			
													GtSQLVlStr($__i_r, "text"));	
	
							$Result = $__cnx->_prc($updateSQL);
							
							if(!$Result){ _ErrSis([ 'p'=>$updateSQL, 'd'=>$__cnx->c_p->error ]); }
							$rsp['w_update'] = $__cnx->c_p->error;
							$rsp['_enc'] = enCad($_i);
							$rsp['status'] = 'success';
						
						}else{
							$rsp['status'] = 'error'; 
							$rsp['w'] = TX_PRB_MOV_FLE;
							$rsp['err'] = $__nw_fld;
						}

					}catch(Exception $e){
						$rsp['status'] = 'error'; 
						$rsp['err'] = $_FILES["upl"]["error"];
						$rsp['w'] = $e->getMessage();
                    }
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