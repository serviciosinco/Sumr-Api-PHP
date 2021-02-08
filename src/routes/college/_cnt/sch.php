<?php

//---------------- SETUP - START ----------------//
	
	
	$__q = Php_Ls_Cln($_POST['sch']);	
	
	
//---------------- SETUP - END ----------------//
	
	
	if(!isN($__q)){
		$___Dt = new CRM_Dt();
		$___Dt->sch->f = 'id_org, org_nm';
		$___Dt->gt->sch = $__q;
		$___Dt->_sch([ 't'=>'no' ]);
		if(!isN($___Dt->sch->cod)){ $__fl .= ' AND '. $___Dt->sch->cod; }	
	}
		
	$query_LsRg = '	
	
			SELECT *
			FROM '._BdStr(DBM).TB_ORG.'
				 INNER JOIN '._BdStr(DBM).TB_ORG_SDS.' ON orgsds_org = id_org
				 INNER JOIN '._BdStr(DBM).TB_SIS_CD.' ON orgsds_cd = id_siscd
				 INNER JOIN '._BdStr(DBM).TB_SIS_CD_DP.' ON siscd_dp = id_siscddp
				 INNER JOIN '._BdStr(DBM).TB_SIS_PS.' ON siscddp_ps = id_sisps
				 
			WHERE id_org IN (
					SELECT orgtp_org 
					FROM '._BdStr(DBM).TB_ORG_TP.' 
					WHERE orgtp_tp="'._CId('ID_ORGTP_CLG').'" '.$__fl.'
				)			
		  ';	
						
	$LsRg = $__cnx->_qry($query_LsRg);
	
	if($LsRg){
		
		$_r['e'] = 'ok';	
		
		$row_LsRg = $LsRg->fetch_assoc(); 
		$Tot_LsRg = $LsRg->num_rows;
		
		$_r['tot'] = $Tot_LsRg;
		
		if($Tot_LsRg > 0){
			 
			do {
				
				$_nm_prfx = '';
				$_nm_sfx = '';
				
				if(!isN($row_LsRg['orgsds_nm']) && $row_LsRg['orgsds_nm'] != TX_PC){ $_nm_sfx = ' - '.ctjTx($row_LsRg['orgsds_nm'], 'in'); }
				
				$_r['ls'][] = [
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
	
	
	//-------------- PRINT RESULTS --------------//
	
	if(!isN($_r)){ echo json_encode($_r); }
	
		
?>