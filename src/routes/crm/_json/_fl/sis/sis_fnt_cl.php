<?php 
	
	$__in = Php_Ls_Cln($_POST['in']); // true para buscar solo los registros que estan relacionados
	$__sch = Php_Ls_Cln($_POST['sch']);
	$__fnt = Php_Ls_Cln($_POST['fnt']);
	
	$__schcod_mnu = Sch_Cd('cl_nm',$__sch, 2); // Codigo Armado
	
	if($__in == 'ok'){
		
		if($__fnt != ''){
			$__f_mnu = " AND sisfnt_enc = '{$__fnt}' ";
		}
		$__in_mnu =	'  id_cl IN (	SELECT sisfntcl_cl 
									FROM '.TB_SIS_FNT_CL.' 
										 INNER JOIN '.TB_SIS_FNT.' ON sisfntcl_sisfnt = id_sisfnt
									WHERE sisfntcl_cl = id_cl '.$__f_mnu.' ) ';
	}else{
		if($__fnt != ''){
			$__f_mnu = " AND sisfnt_enc = '{$__fnt}' ";
		}
		$__in_mnu =	'  id_cl NOT IN (	SELECT sisfntcl_cl 
										FROM '.TB_SIS_FNT_CL.' 
											 INNER JOIN '.TB_SIS_FNT.' ON sisfntcl_sisfnt = id_sisfnt
										WHERE sisfntcl_cl = id_cl '.$__f_mnu.') ';
	}

	
	
	
	/* Programas */
	
	$Sb_Qry = ", (SELECT cltag_vl FROM ".TB_CL_TAG." WHERE cltag_sistag = 271 AND cltag_cl = id_cl ) AS _cl_clr";	
	$LsClMn_Qry = "	SELECT * $Sb_Qry
					FROM  ".TB_CL."  
					WHERE {$__in_mnu} {$__schcod_mnu} 
				"; 
				
	$LsClMn = $__cnx->_qry($LsClMn_Qry); 
	
	if($LsClMn){
		
		$row_LsClMn = $LsClMn->fetch_assoc(); 
		$Tot_LsClMn = $LsClMn->num_rows;
			
		if( ($Tot_LsClMn>0) ){	
			
			$rsp['e'] = 'ok';
			
			/* Listado de Clientes */
			$rsp['us_cl']['tt'] = TX_CL;
			$rsp['us_cl']['total'] = $Tot_LsClMn;
			
			if($Tot_LsClMn > 0){
				do {	
					if($row_LsClMn['_cl_clr'] == '' && $row_LsClMn['_cl_clr'] == NULL){ $_clr = "#000"; } else{ $_clr = $row_LsClMn['_cl_clr']; }
					
					$__fnt_o = GtMnuClDt([ 'cl'=>$row_LsClMn['id_cl'], 'mnu'=>$__fnt ]);
					
					$rsp['us_cl']['list'][] = ['id'=>$row_LsClMn['id_cl'], 
													'tt'=>ctjTx(strip_tags($row_LsClMn['cl_nm']),'in'),
													'enc'=>ctjTx(strip_tags($row_LsClMn['cl_enc']),'in'), 
													'clr'=>$_clr,
													'mnu'=>$__fnt_o
												];
													
														
				} while ($row_LsClMn = $LsClMn->fetch_assoc());
			}
		}else{
			$rsp['e'] = 'no';
		}
		
	}
	
	$LsPro->free; 
?>