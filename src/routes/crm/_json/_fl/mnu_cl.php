<?php 
	
	$__in = Php_Ls_Cln($_POST['in']); // true para buscar solo los registros que estan relacionados
	$__sch = Php_Ls_Cln($_POST['sch']);
	$__mnu = Php_Ls_Cln($_POST['mnu']);
	
	$__schcod_mnu = Sch_Cd('cl_nm',$__sch, 2); // Codigo Armado
	
	if($__in == 'ok'){
		
		if($__mnu != ''){
			$__f_mnu = " AND clmnu_enc = '{$__mnu}' ";
		}
		$__in_mnu =	'  id_cl IN (	SELECT clmnur_cl 
									FROM '._BdStr(DBM).TB_CL_MNU_R.' 
										 INNER JOIN '._BdStr(DBM).TB_CL_MNU.' ON clmnur_clmnu = id_clmnu 
									WHERE clmnur_cl = id_cl '.$__f_mnu.' 
								) ';
	}else{
		if($__mnu != ''){
			$__f_mnu = " AND clmnu_enc = '{$__mnu}' ";
		}
		$__in_mnu =	'  id_cl NOT IN (	SELECT clmnur_cl 
										FROM '._BdStr(DBM).TB_CL_MNU_R.' 
											 INNER JOIN '._BdStr(DBM).TB_CL_MNU.' ON clmnur_clmnu = id_clmnu 
										WHERE clmnur_cl = id_cl '.$__f_mnu.'
						) ';
	}

	
	
	
	/* Programas */
	
	$Sb_Qry = ", (SELECT cltag_vl FROM "._BdStr(DBM).TB_CL_TAG." WHERE cltag_sistag = 271 AND cltag_cl = id_cl ) AS _cl_clr";	
	$LsClMn_Qry = "	SELECT * $Sb_Qry
					FROM  "._BdStr(DBM).TB_CL."  
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
					
					$__mnu_o = GtMnuClDt([ 'cl'=>$row_LsClMn['id_cl'], 'mnu_enc'=>$__mnu ]);
					
					$rsp['us_cl']['list'][] = ['id'=>$row_LsClMn['id_cl'], 
												'tt'=>ctjTx(strip_tags($row_LsClMn['cl_nm']),'in'),
												'enc'=>ctjTx(strip_tags($row_LsClMn['cl_enc']),'in'), 
												'clr'=>$_clr,
												'mnu'=>$__mnu_o
											  ];
													
														
				} while ($row_LsClMn = $LsClMn->fetch_assoc());
			}
		}else{
			$rsp['e'] = 'no';
		}
	
	}else{
		
		$rsp['w'] = $LsClMn_Qry.' -> '.$__cnx->c_r->error;
		
	}
	
	$LsPro->free; 
?>