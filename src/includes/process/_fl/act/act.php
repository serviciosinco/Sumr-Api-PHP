<?php 
			
	$__Act = new CRM_Act();
	
	if(
		( (isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "EdOrgAct") ) ||
		( (isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "EdAct") )
	){ 	
		
		$__Act->act_tt = $_POST['act_tt'];
		$__Act->act_pml = $_POST['act_pml'];
		$__Act->act_f_start = $_POST['act_f_start'];
		$__Act->act_f_end = $_POST['act_f_end'];
		$__Act->act_est = $_POST['act_est'];
		$__Act->act_dsc = $_POST['act_dsc'];
		$__Act->act_fctx = $_POST['act_fctx'];
		$__Act->act_us = $_POST['act_us'];
		$__Act->act_cd = $_POST['act_cd'];
		$__Act->act_estd_tot = $_POST['act_estd_tot'];
		$__Act->act_acmp_tot = $_POST['act_acmp_tot'];
		$__Act->act_lgr = $_POST['act_lgr'];
		$__Act->act_lgrtx = $_POST['act_lgrtx'];
		$__Act->act_lat = $_POST['act_lat'];
		$__Act->act_lng = $_POST['act_lng'];

		$__Act->act_fnt = $_POST['act_fnt'];
		$__Act->act_md = $_POST['act_md'];
		$__Act->act_mdlgen = $_POST['act_mdlgen'];
		
		if(!isN($_POST['org_act'])){
			$_org_sds_dt = GtOrgSdsDt([ 't'=>'enc', 'i'=>$_POST['org_act'] ]); 
			$__Act->orgsdsact_orgsds = $_org_sds_dt->id;
		}
				        	        
		$Result = $__Act->In();
 		
 		if($Result->e == 'ok'){
	 		$rsp['e'] = 'ok';
			$rsp['m'] = 1;

			if($_POST['t2'] != 'clg'){
				$__Act->tp = $_POST['t2'];
				$__Act->id_act = $Result->i;

				$Result_acttp = $__Act->ActTpIn();

				if($Result_acttp->e == 'ok'){
					$rsp['e'] = 'ok';
					$rsp['m'] = 1;
				}else{
					$rsp['e'] = 'no';
					$rsp['m'] = 2;
				}
			}
			

		}else{
			$rsp['e'] = 'no';
			$rsp['m'] = 2;
			$rsp['w'] = $insertSQL;
			_ErrSis(['p'=>$insertSQL, 'd'=>$__cnx->c_p->error]);
		}
		
	}
	
	
	if(
		( (isset($_POST["MM_update"])) && ($_POST["MM_update"] == "EdOrgAct") ) ||
		( (isset($_POST["MM_update"])) && ($_POST["MM_update"] == "EdAct") )
	){
		
		$updateSQL = sprintf("UPDATE "._BdStr(DBM).TB_ACT." SET 
								act_tt=%s, act_f_start=%s, act_f_end=%s, act_f_close=%s,
								act_dsc=%s, act_est=%s, 
								act_fctx=%s, act_us=%s, act_cd=%s,
								act_estd_tot=%s, act_acmp_tot=%s, act_lgr=%s, act_s3=%s,
								act_lgrtx=%s, act_lat=%s, act_lng=%s, act_mdlgen=%s, act_md=%s, act_fnt=%s
								WHERE act_enc = %s
							",
							GtSQLVlStr(ctjTx($_POST['act_tt'], 'out'), "text"),
							GtSQLVlStr($_POST['act_f_start'].' '.$_POST['act_h_start'], "date"),
							GtSQLVlStr($_POST['act_f_end'].' '.$_POST['act_h_end'], "date"),
							GtSQLVlStr($_POST['act_f_close'].' '.$_POST['act_h_close'], "date"),
							GtSQLVlStr(ctjTx($_POST['act_dsc'], 'out'), "text"),
							GtSQLVlStr($_POST['act_est'], "int"),
							GtSQLVlStr(ctjTx($_POST['act_fctx'], 'out'), "text"),
							GtSQLVlStr(ctjTx($_POST['act_us'], 'out'), "text"),
							GtSQLVlStr(ctjTx($_POST['act_cd'], 'out'), "text"),
							GtSQLVlStr(ctjTx($_POST['act_estd_tot'], 'out'), "text"),
							GtSQLVlStr(ctjTx($_POST['act_acmp_tot'], 'out'), "text"),
							GtSQLVlStr($_POST['act_lgr'], "int"),
							GtSQLVlStr(2, "int"),
							GtSQLVlStr(ctjTx($_POST['act_lgrtx'], 'out'), "text"),
							GtSQLVlStr(ctjTx($_POST['act_lat'], 'out'), "text"),
							GtSQLVlStr(ctjTx($_POST['act_lng'], 'out'), "text"),
							GtSQLVlStr($_POST['act_mdlgen'], "int"),
							GtSQLVlStr($_POST['act_md'], "int"),
							GtSQLVlStr($_POST['act_fnt'], "int"),
							GtSQLVlStr(ctjTx($_POST['act_enc'], 'out'), "text")
		);
                   
		$Result = $__cnx->_prc($updateSQL); 
		
		if($Result){

			$rsp['e'] = 'ok';
			$rsp['m'] = 1;

			$_aws = new API_CRM_Aws();
			//$__aws_cache = $_aws->_cfr_clr([ 'b'=>'frnt', 'fle'=>$_POST['act_enc'], 'all'=>'ok' ]);
			$rsp['cfr'] = $__aws_cache;

			$fecha_actual = date("Y-m-d H:i:s");
			$fecha_entrada = $_POST['act_f_close'].' '.$_POST['act_h_close'];

			if($fecha_actual > $fecha_entrada){
				$__Act->est = _CId('ID_ACTEST_FNZ');
				$__Act->enc = $_POST['act_enc'];
				$Prc_Est = $__Act->ActUpdEst(); 

				if($Prc_Est->e == 'ok'){
					$rsp['e'] = 'ok';
					$rsp['m'] = 1;		
				}else{
					$rsp['e'] = 'no';
					$rsp['m'] = 2;
					$rsp['w'] = $Prc_Est->w;	
				}

			}

		}else{
			$rsp['e'] = 'no';
			$rsp['m'] = 2;
			$rsp['w'] = $updateSQL;
			_ErrSis(['p'=>$updateSQL, 'd'=>$__cnx->c_p->error]);
		} 
		
	}
	
	
	if (
			( (isset($_POST['uid'])) && ($_POST['uid'] != '') && ((isset($_POST['MM_delete']))&&($_POST['MM_delete'] == 'EdOrgAct')) ) ||
			( (isset($_POST['uid'])) && ($_POST['uid'] != '') && ((isset($_POST['MM_delete']))&&($_POST['MM_delete'] == 'EdAct')) )
	){ 
		
		$deleteSQL = sprintf("DELETE FROM ".TB_ACT." WHERE act_enc=%s",
								GtSQLVlStr(ctjTx($_POST['uid'], 'out'), "text")
							);
		
		$Result = $__cnx->_prc($deleteSQL); 
		
		if($Result){
			$rsp['e'] = 'ok'; 
			$rsp['m'] = 1;
		}else{
			$rsp['e'] = 'no';
			$rsp['m'] = 2;
			$rsp['w'] = $__cnx->c_p->error;
		}
		
	}
	
?>