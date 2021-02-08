<?php 
	
	$__in = Php_Ls_Cln($_POST['in']); // true para buscar solo los registros que estan relacionados
	$__sch = Php_Ls_Cln($_POST['sch']);
	$__sds = Php_Ls_Cln($_POST['sds']);
	
	$__schcod_pro = Sch_Cd('cl_nm',$__sch, 2); // Codigo Armado
	
	if($__in == 'ok'){
		
		if($__sds != ''){
			$__f_pro = " AND uscl_us = {$__sds} ";
		}
		$__in_pro =	'  id_cl IN (SELECT uscl_cl FROM '._BdStr(DBM).TB_US_CL.' WHERE uscl_cl = id_cl '.$__f_pro.' ) ';
	}else{
		if($__sds != ''){
			$__f_pro = " AND uscl_us = {$__sds} ";
		}
		$__in_pro =	'  id_cl NOT IN (SELECT uscl_cl FROM '._BdStr(DBM).TB_US_CL.' WHERE uscl_cl = id_cl '.$__f_pro.') ';
	}

	
	$LsPro_Qry = "SELECT * FROM "._BdStr(DBM).TB_CL."  WHERE {$__in_pro} {$_cns}  {$__schcod_pro}";
	$LsPro = $__cnx->_qry($LsPro_Qry); $row_LsPro = $LsPro->fetch_assoc(); $Tot_LsPro = $LsPro->num_rows;	
	

	if( ($Tot_LsPro>0) ){	
		$rsp['e'] = 'ok';
		
		/* Listado de Programa */
		$rsp['us_cl']['tt'] = MDL_PRO;
		$rsp['us_cl']['total'] = $Tot_LsPro;
		if($Tot_LsPro > 0){
			do {		
				$rsp['us_cl']['list'][] = ['id'=>$row_LsPro['id_cl'], 'tt'=>ctjTx(strip_tags($row_LsPro['cl_nm']),'in'), 'clr'=>"#009999"];	
			} while ($row_LsPro = $LsPro->fetch_assoc());
		}

		
	}else{
		$rsp['e'] = 'no';
	}

?>