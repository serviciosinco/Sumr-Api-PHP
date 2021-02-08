<?php 

	$__q = Php_Ls_Cln($_POST['__q']);
	$__t = Php_Ls_Cln($_POST['__t']);

	if(!isN($__q)){
		
		$___Dt = new CRM_Dt();
		$___Dt->sch->f = 'id_org, org_nm';
		$___Dt->gt->sch = $__q;
		$___Dt->_sch([ 't'=>'no' ]);
		if(!isN($___Dt->sch->cod)){ $__fl .= ' AND '. $___Dt->sch->cod; }
		
	}	 
	
	if($__t == 'clg'){
		$__id = _CId('ID_ORGTP_CLG');	
	}elseif($__t == 'uni'){
		$__id = _CId('ID_ORGTP_UNI');	
	}elseif($__t == 'emp'){
		$__id = _CId('ID_ORGTP_EMP');	
	}elseif($__t == 'marks'){
		$__id = _CId('ID_ORGTP_MARKS');	
	}

	$query_DtRg = '	
	
			SELECT *
			FROM '._BdStr(DBM).TB_ORG.'
				 INNER JOIN '._BdStr(DBM).TB_ORG_SDS.' ON orgsds_org = id_org
				 INNER JOIN '._BdStr(DBM).TB_SIS_CD.' ON orgsds_cd = id_siscd
				 INNER JOIN '._BdStr(DBM).TB_SIS_CD_DP.' ON siscd_dp = id_siscddp
				 INNER JOIN '._BdStr(DBM).TB_SIS_PS.' ON siscddp_ps = id_sisps
				 
			WHERE id_org IN (
					SELECT orgtp_org 
					FROM '._BdStr(DBM).TB_ORG_TP.' 
					WHERE orgtp_tp="'.$__id.'" '.$__fl.'
				)			
		  '
		;
			
	$DtRg = $__cnx->_qry($query_DtRg);
	$row_DtRg = $DtRg->fetch_assoc(); 
	$Tot_DtRg = $DtRg->num_rows;

	if($Tot_DtRg > 0){
		
		$rsp['tot'] = $Tot_DtRg;
		$rsp['e'] = 'ok';
			
		do {
			
			$_nm_prfx = '';
			$_nm_sfx = '';
			
			if($row_DtRg['id_siscd'] != '0'){ $_nm_prfx = '('.ctjTx($row_DtRg['siscd_tt'], 'in').') '; }
			if(!isN($row_DtRg['orgsds_nm']) && $row_DtRg['orgsds_nm'] != TX_PC){ $_nm_sfx = ' - '.ctjTx($row_DtRg['orgsds_nm'], 'in'); }
			
			$rsp['items'][] = [
				'id'=>$row_DtRg['id_orgsds'],
				'text'=>$_nm_prfx.ctjTx($row_DtRg['org_nm'],'in').$_nm_sfx
			];		
			
		} while ($row_DtRg = $DtRg->fetch_assoc());

		$rsp['items'][] = [
			'id'=>'-new-',
			'text'=>TX_LSNEWADD.' '.$__q.' -'
		];

	}else{
		
		$rsp['e'] = 'no';
		
		$rsp['items'][] = [
			'id'=>'-new-',
			'text'=>TX_LSNEWADD.' '.$__q.' -'
		];
				
		if(!isN($__q)){ $rsp['q'] = $__q; }
		
	}

	$Dt_Rg->free; 
?>