<?php
	
	
	
	//---------------- SETUP - START ----------------//
		
		
		$__q = Php_Ls_Cln($_POST['__q']);	
		
		
	//---------------- SETUP - END ----------------//
		
	
		
		if(!isN($__q)){ $__sch = $__q; }else{ $__sch = $__i; }
		if (isset($__sch)){$c_LsRg = preg_replace('/\s+/','',$__sch);}
		
		if(!isN($__q)){
			
			$___Dt = new CRM_Dt();
			$___Dt->sch->f = 'id_org, org_nm';
			$___Dt->gt->sch = $__q;
			$___Dt->_sch([ 't'=>'no' ]);
			if(!isN($___Dt->sch->cod)){ $__fl .= ' || '. $___Dt->sch->cod; }
			
		}
		
		
		if($__t == 'sch_emp'){  
			//$__tp_fl = 'ID_ORGTP_EMP';
		}elseif($__t == 'sch_uni'){  
			$__tp_fl = 'ID_ORGTP_UNI';
		}elseif($__t == 'sch_clg'){  
			$__tp_fl = 'ID_ORGTP_CLG';
		}
		
		if(!isN($__tp_fl)){
			$__fl .= ' AND id_org IN (SELECT orgtp_org FROM '._BdStr(DBM).TB_ORG_TP.' WHERE orgtp_tp="'._CId($__tp_fl).'" ) ';
		}
			
		$query_LsRg = '	
		
				SELECT 
					id_siscd, siscd_tt, orgsds_nm, orgsds_enc, org_nm
				FROM '._BdStr(DBM).TB_ORG.'
					 INNER JOIN '._BdStr(DBM).TB_ORG_SDS.' ON orgsds_org = id_org
					 INNER JOIN '._BdStr(DBM).TB_SIS_CD.' ON orgsds_cd = id_siscd
					 /*INNER JOIN '._BdStr(DBM).TB_SIS_CD_DP.' ON siscd_dp = id_siscddp
					 INNER JOIN '._BdStr(DBM).TB_SIS_PS.' ON siscddp_ps = id_sisps*/
					 
				WHERE 	EXISTS (SELECT orgsds_org FROM '._BdStr(DBM).TB_ORG_SDS_DC.' WHERE orgsdsdc_orgsds = id_orgsds AND orgsdsdc_dc LIKE "%'.$c_LsRg.'%" ) OR 
						EXISTS (SELECT orgweb_org FROM '._BdStr(DBM).TB_ORG_WEB.' WHERE orgweb_org = id_org AND orgweb_web LIKE "%'.$c_LsRg.'%")
						'.$__fl.'
				LIMIT 10	
			  ';

		//$rsp['q'] = $query_LsRg;

			
		$LsRg = $__cnx->_qry($query_LsRg);
		
		if($LsRg){
			
			$row_LsRg = $LsRg->fetch_assoc(); 
			$Tot_LsRg = $LsRg->num_rows;			
			
			if($Tot_LsRg > 0){
				
				$rsp['e'] = 'ok';	
				 
				do {
					
					$_nm_prfx = '';
					$_nm_sfx = '';
					
					if($row_LsRg['id_siscd'] != '0'){ $_nm_prfx = '('.ctjTx($row_LsRg['siscd_tt'], 'in').') '; }
					if(!isN($row_LsRg['orgsds_nm']) && $row_LsRg['orgsds_nm'] != TX_PC){ $_nm_sfx = ' - '.ctjTx($row_LsRg['orgsds_nm'], 'in'); }
					
					$rsp['items'][] = [
										'id'=>$row_LsRg['orgsds_enc'],
										'text'=>$_nm_prfx.ctjTx($row_LsRg['org_nm'],'in').$_nm_sfx
									];		
					
				} while ($row_LsRg = $LsRg->fetch_assoc());
				
				
			}
				
			if($Tot_LsRg == 0 || $Tot_LsRg > 5){;
				
				$rsp['items'][] = [
					'id'=>'-new-',
					'text'=>TX_LSNEWADD.' '.$__q
				];
			
			}	
				
		}

		$__cnx->_clsr($LsRg);
	
	//-------------- PRINT RESULTS --------------//

		
?>