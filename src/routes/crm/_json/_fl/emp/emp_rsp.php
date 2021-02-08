<?php 
	
	$__in = Php_Ls_Cln($_POST['in']); // true para buscar solo los registros que estan relacionados
	$__sch = Php_Ls_Cln($_POST['sch']);
	$__sds = Php_Ls_Cln($_POST['sds']);
	
	$__schcod_pro = Sch_Cd('us_nm, us_ap',$__sch, 2); // Codigo Armado

	if($__t == 'acd_emp_rsp'){
		$_bd = ', '.MDL_US_MDL_BD.', '.TB_MDL_S_TP_PRM;
		$_cns = 'AND usmdl_us = id_us AND usmdl_mdl = id_mdlstpprm AND mdlstpprm_tp = 17 GROUP BY id_us';
	}elseif($__t == 'evns_emp_rsp'){
		$_bd = ', '.MDL_US_MDL_BD.', '.TB_MDL_S_TP_PRM.', '.MDL_GRP_US_BD;
		$_cns = 'AND ((usmdl_us = id_us AND usmdl_mdl = id_mdlstpprm AND mdlstpprm_tp = 16) OR (usgrpus_us = id_us AND usgrpus_grp = 10)) GROUP BY id_us';
	}elseif($__t == 'spa_emp_rsp'){
		$_bd = ', '.MDL_US_MDL_BD.', '.TB_MDL_S_TP_PRM.', '.MDL_GRP_US_BD;
		$_cns = 'AND ((usmdl_us = id_us AND usmdl_mdl = id_mdlstpprm AND mdlstpprm_tp = 15) OR (usgrpus_us = id_us AND usgrpus_grp = 3)) GROUP BY id_us';
	}elseif($__t == 'rst_emp_rsp'){
		$_bd = ', '.MDL_US_MDL_BD.', '.TB_MDL_S_TP_PRM.', '.MDL_GRP_US_BD;
		$_cns = 'AND ((usmdl_us = id_us AND usmdl_mdl = id_mdlstpprm AND mdlstpprm_tp = 14) OR (usgrpus_us = id_us AND usgrpus_grp = 1)) GROUP BY id_us';
	}elseif($__t == 'pqt_emp_rsp'){
		$_bd = ', '.MDL_US_MDL_BD.', '.TB_MDL_S_TP_PRM.', '.MDL_GRP_US_BD;
		$_cns = 'AND usmdl_us = id_us AND usmdl_mdl = id_mdlstpprm AND mdlstpprm_tp = 18 GROUP BY id_us';
	}elseif($__t == 'acd_emp_pqr'){
		$_bd = ', '.MDL_US_MDL_BD.', '.TB_MDL_S_TP_PRM.', '.MDL_GRP_US_BD;
		$_cns = 'AND ((usmdl_us = id_us AND usmdl_mdl = id_mdlstpprm AND mdlstpprm_tp = 19) OR (usgrpus_us = id_us AND usgrpus_grp = 12)) GROUP BY id_us';
	}else{
		$_bd = '';
		$_cns = '';
	}
	if($__in == 'ok'){
		
		if($__sds != ''){
			$__f_pro = " AND emprsp_emp = {$__sds} ";
		}
		
		$__in_pro =	'  id_us IN (SELECT emprsp_rsp FROM '.TB_EMP_RSP.' WHERE emprsp_rsp = id_us '.$__f_pro.' ) ';
		$_clr = '#009999';
	}else{
		if($__sds != ''){
			$__f_pro = " AND emprsp_emp = {$__sds} ";
		}
		$__in_pro =	'  id_us NOT IN (SELECT emprsp_rsp FROM '.TB_EMP_RSP.' WHERE emprsp_rsp = id_us '.$__f_pro.') ';
		$_clr = '#009999';
	}

	
	
	
	/* Programas */
	$LsPro_Qry = 'SELECT *  FROM '._BdStr(DBM).TB_US." {$_bd} WHERE {$__in_pro} {$_cns}  {$__schcod_pro}";	
	$LsPro = $__cnx->_qry($LsPro_Qry); 
	$row_LsPro = $LsPro->fetch_assoc(); 
	$Tot_LsPro = $LsPro->num_rows;	
	
	
	

	if( ($Tot_LsPro>0) ){	
		$rsp['e'] = 'ok';
		
		
		/* Listado de Programa */
		$rsp['emp']['tt'] = MDL_PRO;
		$rsp['emp']['total'] = $Tot_LsPro;
		if($Tot_LsPro > 0){
			do {				
				$rsp['emp']['list'][] = ['id'=>$row_LsPro['id_us'], 'tt'=>ctjTx(strip_tags($row_LsPro['us_nm']." ".$row_LsPro['us_ap']),'in'), 'clr'=>$_clr];	
			} while ($row_LsPro = $LsPro->fetch_assoc());
		}

		
	}else{
		$rsp['e'] = 'no';
	}
	
	$LsPro->free; 
?>