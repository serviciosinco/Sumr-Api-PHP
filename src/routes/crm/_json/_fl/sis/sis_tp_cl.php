<?php 
	
	$__in = Php_Ls_Cln($_POST['in']); // true para buscar solo los registros que estan relacionados
	$__sch = Php_Ls_Cln($_POST['sch']);
	$__sistp = Php_Ls_Cln($_POST['sistp']);
	
	$__schcod_sistp = Sch_Cd('mdlstp_nm',$__sch, 2); // Codigo Armado
	
	if($__in == 'ok'){
		
		if($__sistp != ''){
			$__f_sistp = " AND sistpcl_sistp = {$__sistp} ";
		}
		$__in_sistp =	'  id_cl IN (SELECT sistpcl_cl FROM '._BdStr(DBM).TB_MDL_S_TP_CL.' WHERE sistpcl_cl = id_cl '.$__f_sistp.' ) ';
	}else{
		if($__sistp != ''){
			$__f_sistp = " AND sistpcl_sistp = {$__sistp} ";
		}
		$__in_sistp =	'  id_cl NOT IN (SELECT sistpcl_cl FROM '._BdStr(DBM).TB_MDL_S_TP_CL.' WHERE sistpcl_cl = id_cl '.$__f_sistp.') ';
	}

	
	
	
	/* Programas */
	
	$Sb_Qry = ", (SELECT cltag_vl FROM ".TB_CL_TAG." WHERE cltag_sistag = 271 AND cltag_cl = id_cl ) AS _cl_clr";	
	$LsClMn_Qry = "	SELECT * $Sb_Qry
					FROM  "._BdStr(DBM).TB_CL."  
					WHERE {$__in_sistp} {$__schcod_sistp} 
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
				
				$__mdlstp_o = GtMnuClDt([ 'cl'=>$row_LsClMn['id_cl'], 'sistp'=>$__sistp ]);
				
				$rsp['us_cl']['list'][] = ['id'=>$row_LsClMn['id_cl'], 
												'tt'=>ctjTx(strip_tags($row_LsClMn['cl_nm']),'in'),
												'enc'=>ctjTx(strip_tags($row_LsClMn['cl_enc']),'in'), 
												'clr'=>$_clr,
												'sistp'=>$__mdlstp_o
											];
												
													
			} while ($row_LsClMn = $LsClMn->fetch_assoc());
		}
	}else{
		$rsp['e'] = 'no';
	}
	
	$LsPro->free; 
?>