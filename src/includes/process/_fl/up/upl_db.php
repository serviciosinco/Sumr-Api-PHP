<?php 
	
	//@ini_set('display_errors', true); 
	//error_reporting(E_ALL);
	$_fle = new CRM_Fle();		
			
	if (((isset($_POST['MM_update_fle']))&&($_POST['MM_update_fle'] == 'FleUpDb'))) {
		

		if (!empty($_FILES)) {
						
			$__i = Php_Ls_Cln($_POST['_id']);
			$____fl_fld = DIR_FLE_SIS;
			$____fl_nm = 'up';
				
				
			$Sch = [DMN_BS];
			$Chn = [''];
			$Fldr_Rl = str_replace($Sch,$Chn,$____fl_fld);
			$allowed = ['xls','xlsx','csv'];
			
			if(isset($_FILES['upl']) && $_FILES['upl']['error'] == 0){
				
				$__fl_ext = pathinfo($_FILES['upl']['name'], PATHINFO_EXTENSION);
				
				if(!in_array(strtolower($__fl_ext), $allowed)){
					
					$rsp['status'] = 'error'; $rsp['w'] = 'Tipo de archivo no soportado';
					
				}else{
					
					$__enc = Enc_Rnd($__tmp_nm.'-'.SISUS_ID);		
					$__fl_nm = $_FILES['upl']['name'];
					$__fl_sze = $_FILES['upl']['size'];
					$__tmp_nm = $_FILES['upl']['tmp_name'];
					$__nw_nm = $____fl_nm.'_'.$__enc.'.'.$__fl_ext;
					
					if(isN($__i)){
						
						$insertSQL = sprintf("INSERT INTO ".DBP.".".TB_UP_BD." (up_enc, up_fle, up_us, up_tp, up_ext, up_cl) VALUES (%s, %s, %s, %s, %s, %s)",
								   GtSQLVlStr($__enc, "text"),
								   GtSQLVlStr($__nw_nm, "text"),
								   GtSQLVlStr(SISUS_ID, "int"),
								   GtSQLVlStr($_POST['__tup'], "text"),
								   GtSQLVlStr($__fl_ext, "text"),
								   GtSQLVlStr($__dt_cl->id, "int"));

						$Result = $__cnx->_prc($insertSQL);
						
						$_i = $__cnx->c_p->insert_id;
						
						$rsp['inw'] = $_i;
						
						if($Result){
							
							if($_POST['__ec_lsts_rlc'] != ''){
								
								$__enc_lsts = Enc_Rnd($_POST['__ec_lsts_rlc'].'-'.$_i);

								$insertSQL = sprintf("INSERT INTO "._BdStr(DBM).TB_EC_LSTS_UP." (eclstsup_enc, eclstsup_lsts, eclstsup_up) VALUES (%s, ( SELECT id_eclsts FROM "._BdStr(DBM).TB_EC_LSTS." WHERE eclsts_enc=%s), %s)",
						                       GtSQLVlStr($__enc_lsts, "text"),
						                       GtSQLVlStr($_POST['__ec_lsts_rlc'], "text"),
						                       GtSQLVlStr($_i, "int"));	
						                       	
								$Result = $__cnx->_prc($insertSQL);
								
							}elseif($_POST['__sms_cmpg_rlc'] != ''){
								
								$__enc_sms = Enc_Rnd($_POST['__sms_cmpg_rlc'].'-'.$_i);

								$insertSQL = sprintf("INSERT INTO "._BdStr(DBM).TB_TB_SMS_CMPG_UP." (smscmpgup_enc, smscmpgup_cmpg, smscmpgup_up) VALUES (%s, ( SELECT id_eclsts FROM "._BdStr(DBM).TB_TB_SMS_CMPG." WHERE eclsts_enc=%s), %s)",
												GtSQLVlStr($__enc_sms, "text"),
												GtSQLVlStr($_POST['__sms_cmpg_rlc'], "text"),
												GtSQLVlStr($_i, "int"));	
														
								$Result = $__cnx->_prc($insertSQL);
								
							}elseif($_POST['__act_rlc'] != ''){
								
								$__enc_act = Enc_Rnd($_POST['__act_rlc'].'-'.$_i);

								$insertSQL = sprintf("INSERT INTO "._BdStr(DBM).TB_ACT_UP." (actup_enc, actup_act, actup_up) VALUES (%s, ( SELECT id_eclsts FROM "._BdStr(DBM).TB_ACT." WHERE act_enc=%s), %s)",
												GtSQLVlStr($__enc_act, "text"),
												GtSQLVlStr($_POST['__act_rlc'], "text"),
												GtSQLVlStr($_i, "int"));	
														
								$Result = $__cnx->_prc($insertSQL);
								
							}
							
							
							
						}
						
					}else{
						$_i = $__i;
					}
					
					$rsp['w_i'] = $__cnx->c_p->error;
					
					if(!isN($_i)){
								
						//$rsp['i'] = $_i;
						
						$__nw_fld = DIR_PRVT_UP;
						
						$rsp['move_to'] = $__nw_fld.$__nw_nm;
												
						$_aws = new API_CRM_Aws();
						$result_sve = $_aws->_s3_put([ 'b'=>'prvt', 'fle'=>$__nw_fld.$__nw_nm, 'src'=>$__tmp_nm ]);

						//echo $__tmp_nm."   ".$__nw_fld.$__nw_nm;
						if($result_sve->e == 'ok'){
		    
							$rsp['status'] = 'ok';

							$rsp['enc'] = $__enc;
							
						}else{
							
							$rsp['rutas'] = $__nw_fld.$__nw_nm." -- ".$rsp['move_to'];
							$rsp['status'] = 'error'; 
							$rsp['w'] = 'Problema al mover el archivo';
							//$rsp['error_move'] = $__tmp_nm."   ".$__nw_fld.$__nw_nm;;
							
						}
							
						
					}else{
						
						$rsp['status'] = 'error'; $rsp['w'] = 'No genera registro en BD';
						//$rsp['qry'] = 'errores '.$_i;
						_ErrSis(['p'=>$insertSQL, 'd'=>$__cnx->c_p->error]);	
						
					}
							
				}	
						
			}else{
				$rsp['status'] = 'error'; $rsp['w'] = 'No recibe archivo'; 
			}
					
		}
		
	}else{
		$rsp['e'] = 'no'; $rsp['m'] = 2; $rsp['status'] = 'error';	$rsp['w'] = 'No Upd File';
	}

	Hdr_JSON();
	$rtrn = json_encode($rsp); echo $rtrn;

?>