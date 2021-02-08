<?php 
	
	$__in = Php_Ls_Cln($_POST['in']); // true para buscar solo los registros que estan relacionados
	$__sch = Php_Ls_Cln($_POST['sch']);
	$__md = Php_Ls_Cln($_POST['md']);
	
	$__schcod_md = Sch_Cd('cl_nm',$__sch, 2); // Codigo Armado
	
	if($__in == 'ok'){
		
		if($__md != ''){
			$__f_md = " AND sismdcl_sismd = {$__md} ";
		}
		$__in_md =	'  id_cl IN (SELECT sismdcl_cl FROM '._BdStr(DBM).TB_SIS_MD_CL.' WHERE sismdcl_cl = id_cl '.$__f_md.' ) ';
	}else{
		if($__md != ''){
			$__f_md = " AND sismdcl_sismd = {$__md} ";
		}
		$__in_md =	'  id_cl NOT IN (SELECT sismdcl_cl FROM '._BdStr(DBM).TB_SIS_MD_CL.' WHERE sismdcl_cl = id_cl '.$__f_md.') ';
	}

	
	
	
	/* Programas */
	
	$Sb_Qry = ", (SELECT cltag_vl FROM "._BdStr(DBM).TB_CL_TAG." WHERE cltag_sistag = 271 AND cltag_cl = id_cl ) AS _cl_clr";	
	$LsClMn_Qry = "	SELECT * $Sb_Qry
					FROM  "._BdStr(DBM).TB_CL."  
					WHERE {$__in_md} {$__schcod_md} 
					ORDER BY cl_nm ASC
				"; 
	//echo $LsClMn_Qry; exit();			
	$LsClMn = $__cnx->_qry($LsClMn_Qry); $row_LsClMn = $LsClMn->fetch_assoc(); $Tot_LsClMn = $LsClMn->num_rows;	
	if(($Tot_LsClMn>0)){	
		
		$rsp['e'] = 'ok';
		
		/* Listado de Clientes */
		$rsp['us_cl']['tt'] = TX_CL;
		$rsp['us_cl']['total'] = $Tot_LsClMn;
		
		if($Tot_LsClMn > 0){
			do {	
				if($row_LsClMn['_cl_clr'] == '' && $row_LsClMn['_cl_clr'] == NULL){ $_clr = "#000"; } else{ $_clr = $row_LsClMn['_cl_clr']; }
				
				$__md_o = GtMnuClDt([ 'cl'=>$row_LsClMn['id_cl'], 'md'=>$__md ]);
				
				$rsp['us_cl']['list'][] = ['id'=>$row_LsClMn['id_cl'], 
												'tt'=>ctjTx(strip_tags($row_LsClMn['cl_nm']),'in'),
												'enc'=>ctjTx(strip_tags($row_LsClMn['cl_enc']),'in'), 
												'clr'=>$_clr,
												'md'=>$__md_o
											];
												
													
			} while ($row_LsClMn = $LsClMn->fetch_assoc());
		}
	}else{
		$rsp['e'] = 'no';
	}
	
	$LsPro->free; 
?>