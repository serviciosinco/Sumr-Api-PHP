<?php 
	
	$c_DtRg = "-1";
	
	if(!isN($__q)){ $__sch = $__q; }else{ $__sch = $__i; }
	
	if (isset($__sch)){ $c_DtRg = preg_replace('/\s+/','',$__sch); }
	
	if(!isN($__q)){	
		$___Dt = new CRM_Dt();
		$___Dt->sch->f = 'id_org, org_nm';
		$___Dt->gt->sch = $__q;
		$___Dt->_sch([ 't'=>'no' ]);
		if(!isN($___Dt->sch->cod)){ $__fl .= ' || '. $___Dt->sch->cod; }	
	}	 
		
	$query_DtRg = '	
			SELECT *,
				   '._QrySisSlcF([ 'als'=>'tp', 'als_n'=>'tipo' ]).',
				   '.GtSlc_QryExtra(['t'=>'fld', 'p'=>'tp', 'als'=>'tp']).'
				   
			FROM '._BdStr(DBM).TB_ORG.'
				 INNER JOIN '._BdStr(DBM).TB_ORG_SDS.' ON orgsds_org = id_org
				 INNER JOIN '._BdStr(DBM).TB_SIS_CD.' ON orgsds_cd = id_siscd
				 INNER JOIN '._BdStr(DBM).TB_SIS_CD_DP.' ON siscd_dp = id_siscddp
				 INNER JOIN '._BdStr(DBM).TB_SIS_PS.' ON siscddp_ps = id_sisps
				 LEFT JOIN '._BdStr(DBM).TB_ORG_TP.' ON orgtp_org = id_org
				 '.GtSlc_QryExtra(['t'=>'tb', 'col'=>'orgtp_tp', 'als'=>'tp']).'
				 		 
			WHERE id_orgsds IN (SELECT orgsds_org FROM '._BdStr(DBM).TB_ORG_SDS_DC.' WHERE orgsdsdc_dc LIKE "%'.$c_DtRg.'%" ) OR 
				  id_org IN (SELECT orgweb_org FROM '._BdStr(DBM).TB_ORG_WEB.' WHERE orgweb_web LIKE "%'.$c_DtRg.'%")
				'.$_fl_enc.' '.$__fl.'
			LIMIT 10
		  '
		;
						
	$DtRg = $__cnx->_qry($query_DtRg);
	
	if($DtRg){
		
		$row_DtRg = $DtRg->fetch_assoc(); 
		$Tot_DtRg = $DtRg->num_rows;
		$rsp['tot'] = $Tot_DtRg;
		
		if($Tot_DtRg > 0){	
			
			$rsp['e'] = 'ok';
				
			do {			
							
				$_iod = $row_DtRg['orgsds_enc'];
				$rsp['ls'][$_iod]['enc'] = $row_DtRg['orgsds_enc'];
				$rsp['ls'][$_iod]['tt'] = ctjTx($row_DtRg['org_nm'],'in');
				$rsp['ls'][$_iod]['cd'] = ctjTx($row_DtRg['siscd_tt'], 'in');
				$rsp['ls'][$_iod]['sds'] = ctjTx($row_DtRg['orgsds_nm'], 'in');
				
				if(!isN($row_DtRg['org_img'])){
					$rsp['ls'][$_iod]['img'] = _ImVrs(['img'=>$row_DtRg['org_img'], 'f'=>DMN_FLE_ORG ]);
				}
				
				if(!isN($row_DtRg['tp_id_sisslc'])){		
					$_iotp = $row_DtRg['tp_sisslc_enc'];
					$rsp['ls'][$_iod]['tp'][$_iotp]['tt'] = ctjTx($row_DtRg['tp_sisslc_tt'],'in');
					$rsp['ls'][$_iod]['tp'][$_iotp]['img'] = DMN_FLE_SIS_SLC.ctjTx($row_DtRg['tp_sisslc_img'],'in');
				}		
				
				
			} while ($row_DtRg = $DtRg->fetch_assoc());
			
		}
	
	}else{
			
		$rsp['w'] = 'ok';
	}
	
?>