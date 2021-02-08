<?php 

	if (((isset($_POST['MM_update_fle']))&&($_POST['MM_update_fle'] == 'FleUplNw'))) {
		
		
		$_fle = new CRM_Fle();
		
		
		if (!empty($_FILES)) {
			
			$__i_f = Php_Ls_Cln($_POST['id_appl']);
			$__i_r = Php_Ls_Cln($_POST['id_tp']);
			$__i_cl = Php_Ls_Cln($_POST['___cl']);
			$____fl_nm = 'fle';
			
			$Sch = array(DMN_BS);
			$Chn = array('');
			
			$allowed = array('jpg','jpeg','pdf');

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
						$__nw_nm = $____fl_nm.'_'.$_i /*.'.'.$__fl_ext*/;						
						
						// New Class (CRM_Fle) To Upload Files
						
						$_fle->_nw_fld = DIR_FLE_ANX;
						$_fle->_tt = $__nw_nm;
						$_fle->_srce = $_FILES;
						$_flem = $_fle->_SumrToFle();
						$_NEW = $_flem->sze;

						$_sve = $_aws->_s3_put([ 'b'=>'anx', 'fle'=>$_NEW->main->sve, 'src'=>$_flem->rpth, 'ctp'=>$_flem->fle->tp ]);

						if($_flem->e == 'ok' && $_sve->e == 'ok'){

							$__dtcl = GtClDt($__i_cl, 'enc');
							
							$__enc = Enc_Rnd($__fl_nm.'-'.$_flem->name->new);
						
							$insertSQL = sprintf("INSERT INTO ".$__dtcl->bd.".".TB_CNT_APPL_ANX." (cntapplanx_enc, cntapplanx_fle, cntapplanx_cntappl, cntapplanx_attr, cntapplanx_est) VALUES (%s, %s, (SELECT id_cntappl FROM ".$__dtcl->bd.".".TB_CNT_APPL." WHERE cntappl_enc = %s), (SELECT id_sisslc FROM ".TB_SIS_SLC." WHERE sisslc_enc = %s ), %s)",
									GtSQLVlStr($__enc, "text"),
									GtSQLVlStr($_flem->name->new, "text"),
									GtSQLVlStr($__i_f, "text"),
									GtSQLVlStr($__i_r, "text"),
									GtSQLVlStr(_CId('ID_SISSINO_SI'), "int"));	

							$Result = $__cnx->_prc($insertSQL);		
							$_i = $__cnx->c_p->insert_id;
							
							$rsp['status'] = 'success';
						
						}else{
							$rsp['status'] = 'error'; $rsp['w'] = TX_PRB_MOV_FLE;
						}
	
					}else{
						$rsp['status'] = 'error'; $rsp['w'] = TX_NO_GRN_DB;
						_ErrSis([ 'p'=>$insertSQL, 'd'=> $__cnx->c_p->error ]);	
					}
				}			
			}else{
				$rsp['status'] = 'error'; $rsp['w'] = TX_NO_RCV_FLE; 
			}
		}

	}else{
		$rsp['e'] = 'no'; $rsp['m'] = 2; $rsp['status'] = 'error';	$rsp['w'] = 'No Upd File';
	}
?>