<?php

//---------------- SETUP - START ----------------//
	
	$__q = Php_Ls_Cln($_POST['sch']);		
	$__d = Php_Ls_Cln($_POST['d']);
	$_id_act = Php_Ls_Cln($_POST['_id_act']);
	
	$__mdl = new CRM_Mdl();
	$__mdl->id_act = $_id_act;
	

//---------------- SETUP - END ----------------//

	if(!isN($__q)){
		
		$___Dt = new CRM_Dt();
		$___Dt->sch->f = 'id_org, org_nm';
		$___Dt->gt->sch = $__q;
		$___Dt->_sch([ 't'=>'no' ]);
		if(!isN($___Dt->sch->cod)){ $__fl .= ' AND '. $___Dt->sch->cod; }	

		$query_LsRg = '	
		
				SELECT *
				FROM '._BdStr(DBM).TB_ORG.'
					 INNER JOIN '._BdStr(DBM).TB_ORG_TP.' ON orgtp_org = id_org
					 INNER JOIN '._BdStr(DBM).TB_ORG_SDS.' ON orgsds_org = id_org
					 INNER JOIN '._BdStr(DBM).TB_SIS_CD.' ON orgsds_cd = id_siscd
					 INNER JOIN '._BdStr(DBM).TB_SIS_CD_DP.' ON siscd_dp = id_siscddp
					 INNER JOIN '._BdStr(DBM).TB_SIS_PS.' ON siscddp_ps = id_sisps
					 INNER JOIN sumr_bd.org_cl ON orgcl_org = id_org
					 LEFT JOIN '._BdStr(DBM).TB_ORG_SDS_ACT.' ON orgsdsact_orgsds = id_orgsds
					 
				WHERE orgtp_tp="'._CId('ID_ORGTP_CLG').'" AND orgcl_cl = "'.DB_CL_ID.'" AND id_orgsdsact IS NULL '.$__fl.' LIMIT 100			
			  ';
			  
			  $rsp['qry'] = $query_LsRg;	
		
		$LsRg = $__cnx->_qry($query_LsRg);
	
		if($LsRg){
		
			$rsp['e'] = 'ok';	
		
			$row_LsRg = $LsRg->fetch_assoc(); 
			$Tot_LsRg = $LsRg->num_rows;
		
			$rsp['tot'] = $Tot_LsRg;
			
		
			if($Tot_LsRg > 0){
			 	$rsp['clg']['tp'] = 'off';
				do {
					
					$_nm_prfx = '';
					$_nm_sfx = '';
					
					if(!isN($row_LsRg['orgsds_nm']) && $row_LsRg['orgsds_nm'] != TX_PC){ $_nm_sfx = ' - '.ctjTx($row_LsRg['orgsds_nm'], 'in'); }
					
					$rsp['clg']['ls'][$row_LsRg['orgsds_enc']] = [
									'id'=>$row_LsRg['orgsds_enc'],
									'nm'=>$_nm_prfx.ctjTx($row_LsRg['org_nm'],'in').$_nm_sfx,
									'img'=>_ImVrs(['img'=>$row_LsRg['org_img'], 'f'=>DMN_FLE_ORG ]),
									'cd'=>[
										'tt'=>ctjTx($row_LsRg['siscd_tt'],'in')
									]
								];		
					
				} while ($row_LsRg = $LsRg->fetch_assoc());
			}
			
		}

		$__cnx->_clsr($LsRg);
		
	}elseif(!isN($__d) && $__d == 'mod'){

		$_id_org = Php_Ls_Cln($_POST['_id_org']);

		
		$__mdl->id_org = $_id_org;
		
		$PrcDt = $__mdl->OrgAct();

		if($PrcDt->e == 'ok'){	
			$rsp['e'] = $PrcDt->e;
			$rsp['clg'] = $__mdl->OrgAct_Ls();
		}else{
			$rsp['e'] = $PrcDt;
		}	

	}else{
		$rsp['clg'] = $__mdl->OrgAct_Ls();	
	}
	
	
	
	//-------------- PRINT RESULTS --------------//
	
	if(!isN($_r)){ echo json_encode($_r); }
	
		
?>