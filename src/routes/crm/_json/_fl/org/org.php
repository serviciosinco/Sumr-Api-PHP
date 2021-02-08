<?php 
	
	$c_DtRg = "-1";
	
	
		
	
	
		$_enc = $_POST["enc"];
		
		if(!isN($__q)){ $__sch = $__q; }else{ $__sch = $__i; }
		
		if (isset($__sch)){ $c_DtRg = preg_replace('/\s+/','',$__sch); }
		
		if(!isN($__q)){
			
			$___Dt = new CRM_Dt();
			$___Dt->sch->f = 'id_org, org_nm';
			$___Dt->gt->sch = $__q;
			$___Dt->_sch([ 't'=>'no' ]);
			if(!isN($___Dt->sch->cod)){ $__fl .= ' || '. $___Dt->sch->cod; }
			
		}	 
		
		if( !isN($_enc) ){ $_fl_enc = " OR org_enc = '".$_enc."' "; }
		
		$_fl_dc = ", (SELECT GROUP_CONCAT(orgsdsdc_dc) FROM "._BdStr(DBM).TB_ORG_SDS_DC." WHERE orgsdsdc_orgsds = id_orgsds) as _dc ";
		$_fl_tel = ", (SELECT GROUP_CONCAT(orgsdstel_tel) FROM "._BdStr(DBM).TB_ORG_SDS_TEL." WHERE orgsdstel_orgsds = id_orgsds) as _tel ";
		$_fl_eml = ", (SELECT GROUP_CONCAT(orgsdseml_eml) FROM "._BdStr(DBM).TB_ORG_SDS_EML." WHERE orgsdseml_orgsds = id_orgsds) as _eml ";
		$_fl_web = ", (SELECT GROUP_CONCAT(orgweb_web) FROM "._BdStr(DBM).TB_ORG_WEB." WHERE orgweb_org = id_org) as _web ";
		
		
		if( isN($__q) && !isN($_enc) ){
			$__lmt = "LIMIT 1";
		}
			
		$query_DtRg = '	
				SELECT * '.$_fl_dc.' '.$_fl_tel.' '.$_fl_eml.' '.$_fl_web.' 
				FROM '._BdStr(DBM).TB_ORG.'
					INNER JOIN '._BdStr(DBM).TB_ORG_SDS.' ON orgsds_org = id_org
					INNER JOIN '._BdStr(DBM).TB_SIS_CD.' ON orgsds_cd = id_siscd
					INNER JOIN '._BdStr(DBM).TB_SIS_CD_DP.' ON siscd_dp = id_siscddp
					INNER JOIN '._BdStr(DBM).TB_SIS_PS.' ON siscddp_ps = id_sisps
						 
				WHERE 
					EXISTS (SELECT * FROM '._BdStr(DBM).TB_ORG_SDS_DC.' WHERE orgsdsdc_orgsds = id_orgsds AND orgsdsdc_dc LIKE "%'.$c_DtRg.'%" ) OR 
					EXISTS (SELECT * FROM '._BdStr(DBM).TB_ORG_WEB.' WHERE orgweb_org = id_org AND orgweb_web LIKE "%'.$c_DtRg.'%")
					'.$_fl_enc.' '.$__fl.'
				'.$__lmt.'
			  '
			;

	if(SISUS_ID  == 161233){

		$query_DtRg = '	
				SELECT * '.$_fl_dc.' '.$_fl_tel.' '.$_fl_eml.' '.$_fl_web.' 
				FROM '._BdStr(DBM).TB_ORG.'
					 INNER JOIN '._BdStr(DBM).TB_ORG_SDS.' ON orgsds_org = id_org
					 INNER JOIN '._BdStr(DBM).TB_SIS_CD.' ON orgsds_cd = id_siscd
					 INNER JOIN '._BdStr(DBM).TB_SIS_CD_DP.' ON siscd_dp = id_siscddp
					 INNER JOIN '._BdStr(DBM).TB_SIS_PS.' ON siscddp_ps = id_sisps
						 
				WHERE 
							EXISTS (SELECT * FROM '._BdStr(DBM).TB_ORG_SDS_DC.' WHERE orgsdsdc_orgsds = id_orgsds AND orgsdsdc_dc LIKE "%'.$c_DtRg.'%" ) OR 
							EXISTS (SELECT * FROM '._BdStr(DBM).TB_ORG_WEB.' WHERE orgweb_org = id_org AND orgweb_web LIKE "%'.$c_DtRg.'%")
					
					'.$_fl_enc.' '.$__fl.'
				'.$__lmt.'
			  '
			;
		
		$rsp['e'] = $query_DtRg;	

	}else{
			
		//$rsp['qry'] = $query_DtRg;
							
		$DtRg = $__cnx->_qry($query_DtRg);
		$row_DtRg = $DtRg->fetch_assoc(); 
		$Tot_DtRg = $DtRg->num_rows;
		
		if(filter_var($__i, FILTER_VALIDATE_EMAIL)){ $rsp['t_s'] = 'eml'; }
		
		
		if($Tot_DtRg > 0){
			
			$rsp['tot'] = $Tot_DtRg;
			
			$rsp['e'] = 'ok';
				
			if( !isN($__q) && isN($_enc) ){
				
				do {
					
					$_nm_prfx = '';
					$_nm_sfx = '';
					
					if($row_DtRg['id_siscd'] != '0'){ $_nm_prfx = '('.ctjTx($row_DtRg['siscd_tt'], 'in').') '; }
					if(!isN($row_DtRg['orgsds_nm']) && $row_DtRg['orgsds_nm'] != TX_PC){ $_nm_sfx = ' - '.ctjTx($row_DtRg['orgsds_nm'], 'in'); }
					
					$rsp['items'][] = [
						'id'=>$row_DtRg['org_enc'],
						'text'=>$_nm_prfx.ctjTx($row_DtRg['org_nm'],'in').$_nm_sfx
					];		
					
				} while ($row_DtRg = $DtRg->fetch_assoc());
				
				
				$rsp['items'][] = [
					'id'=>'-new-',
					'text'=>TX_LSNEWADD.' '.$__sch.' -'
				];
			
				
			}else{
			
				$rsp['id'] = $row_DtRg['id_org'];
				$rsp['enc'] = ctjTx($row_DtRg['org_enc'],'in');
				$rsp['dc'] = ctjTx($row_DtRg['org_dc'],'in');
				$rsp['dc_nm'] = ctjTx($row_DtRg['sisdoc_nm'],'in');
				$rsp['nm'] = ctjTx($row_DtRg['org_nm'],'in');		
		
				$rsp['clr'] = ctjTx($row_DtRg['org_clr'],'in');
				$rsp['web'] = ctjTx($row_DtRg['org_web'],'in');
				$rsp['dir'] = ctjTx($row_DtRg['org_dir'],'in');
				
				//traer documentos, telefonos, email -- Felipe
				$rsp['_dc'] = explode( ",", ctjTx($row_DtRg['_dc'],'in') );
				$rsp['_tel'] = explode( ",", ctjTx($row_DtRg['_tel'],'in') );
				$rsp['_eml'] = explode( ",", ctjTx($row_DtRg['_eml'],'in') );
				$rsp['_web'] = explode( ",", ctjTx($row_DtRg['_web'],'in') );
				
				$_eml = explode(",", $___Ls->dt->rw['_eml']); $i_eml = 1;
				
				foreach($_eml as $_v_eml){
					if(!isN($_v_eml)){ ?><li class="" id="_li_nm"><?php echo Strn(TX_EML."-".$i_eml,'',true).ctjTx($_v_eml, 'in'); ?></li><?php $i_eml++; }
				}
			}
			
		}else{
			
			$rsp['e'] = 'no';
			
			$rsp['items'][] = [
				'id'=>'-new-',
				'text'=>TX_LSNEWADD.' '.$__sch.' -'
			];
					
			if(!isN($__q)){ $rsp['q'] = $__q; }
			
		}
	
		$Dt_Rg->free; 
	}
?>