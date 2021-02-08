<?php 
	
	$__in = Php_Ls_Cln($_POST['in']); // true para buscar solo los registros que estan relacionados
	$__sch = Php_Ls_Cln($_POST['sch']);
	$__btns = $_POST['btns'];
	$__sds = Php_Ls_Cln($_POST['sds']);

	
	$__schcod_pro = Sch_Cd('mdlstpprm_nm',$__sch, 2); // Codigo Armado
	if($__btns == '' || $__btns == NULL){$__schcod_btn = "";}else{$__schcod_btn = "AND mdlstpprm_tp =  {$__btns}";}

	if($__in == 'ok'){
		
		if($__sds != ''){
			$__f_pro = " AND usmdl_us = {$__sds} ";
		}
		$__in_pro =	'  id_mdlstpprm IN (SELECT usmdl_mdl FROM '.MDL_US_MDL_BD.' WHERE usmdl_mdl = id_mdlstpprm '.$__f_pro.' ) '; 
		$_clr = '#009999';
	}else{
		if($__sds != ''){
			$__f_pro = " AND usmdl_us = {$__sds} ";
		}
		$__in_pro =	'  id_mdlstpprm NOT IN (SELECT usmdl_mdl FROM '.MDL_US_MDL_BD.' WHERE usmdl_mdl = id_mdlstpprm '.$__f_pro.') ';
		$_clr = '#009999';
	}

	
	/* Programas */
	$LsTp_Qry = 'SELECT *  FROM '.TB_MDL_S_TP_PRM."
		
		INNER JOIN _mdl_s_tp ON mdlstpprm_mdlstp = id_mdlstp
		INNER JOIN _mdl_s_tp_cl ON mdlstpcl_mdlstp = id_mdlstp
		INNER JOIN _cl ON mdlstpcl_cl = id_cl
	
	 WHERE {$__in_pro} {$__schcod_pro} $__schcod_btn AND cl_enc = '".DB_CL_ENC."'"; 
	
	$LsTp = $__cnx->_qry($LsTp_Qry); 
	$row_LsTp = $LsTp->fetch_assoc();
	$Tot_LsTp = $LsTp->num_rows;	
	
	$rsp['mdd'] = $LsTp_Qry;

	if( ($Tot_LsTp>0) ){	
		$rsp['e'] = 'ok';
		$rsp['m'] = 1;
		
		/* Listado de Programa */
		$rsp['mdl']['tt'] = MDL_SIS_MDL;
		$rsp['mdl']['total'] = $Tot_LsTp;
		
		
		if($Tot_LsTp > 0){
			do {		
				$rsp['mdl']['list'][] = ['id'=>$row_LsTp['id_mdlstpprm'], 'tt'=>ctjTx(strip_tags($row_LsTp['mdlstpprm_nm']),'in'), 'clr'=>$_clr];	
			} while ($row_LsTp = $LsTp->fetch_assoc());
		}
		
	}else{
		$rsp['e'] = 'no';
	}
	

?>