<?php 

	$__in = Php_Ls_Cln($_POST['in']); // true para buscar solo los registros que estan relacionados
	$__sch = Php_Ls_Cln($_POST['sch']);
	$__sds = Php_Ls_Cln($_POST['sds']);
	
	$__schcod_pro = Sch_Cd('empgrp_nit, empgrp_rs',$__sch, 2); // Codigo Armado

	if($__in == 'ok'){
		if($__sds != ''){
			$__f_pro = " AND empgrprlc_emp = {$__sds} ";
		}
		$__in_pro =	'  id_empgrp IN (SELECT empgrprlc_grp FROM '.MDL_EMP_GRP_BD.' WHERE empgrprlc_grp = id_empgrp '.$__f_pro.' ) ';
		$_clr = '#009999';
	}else{
		if($__sds != ''){
			$__f_pro = " AND empgrprlc_emp = {$__sds} ";
		}
		$__in_pro =	' id_empgrp NOT IN (SELECT empgrprlc_grp FROM '.MDL_EMP_GRP_BD.' WHERE empgrprlc_grp = id_empgrp '.$__f_pro.') ';
		$_clr = '#009999';
	}
	
	

	/* Programas */
	$LsPro_Qry = 'SELECT * FROM '.MDL_SIS_EMP_GRP_BD." WHERE {$__in_pro}  {$__schcod_pro} $__schcod_btn ";
	$LsPro = $__cnx->_qry($LsPro_Qry);
	$row_LsPro = $LsPro->fetch_assoc(); 
	
	$Tot_LsPro = $LsPro->num_rows;	
	
	if( ($Tot_LsPro>0) ){	
		$rsp['e'] = 'ok';
		
		
		/* Listado de Programa */
		$rsp['emp_grp']['tt'] = MDL_PRO;
		$rsp['emp_grp']['total'] = $Tot_LsPro;
		if($Tot_LsPro > 0){
			do {				
				$rsp['emp_grp']['list'][] = ['id'=>$row_LsPro['id_empgrp'], 'tt'=>ctjTx($_CcC.$row_LsPro['empgrp_nit']." - ".$row_LsPro['empgrp_rs'],'in'), 'clr'=>$_clr];	
			} while ($row_LsPro = $LsPro->fetch_assoc());
			
		}

		
	}else{
		$rsp['e'] = 'no';
	}
	
	$LsPro->free; 
?>