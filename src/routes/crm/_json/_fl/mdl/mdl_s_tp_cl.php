<?php 
	
	$__in = Php_Ls_Cln($_POST['in']); // true para buscar solo los registros que estan relacionados
	$__sch = Php_Ls_Cln($_POST['sch']);
	$__mdlstp = Php_Ls_Cln($_POST['mdlstp']);
	
	$__schcod_mdlstp = Sch_Cd('cl_nm',$__sch, 2); // Codigo Armado
	
	if($__in == 'ok'){
		
		if($__mdlstp != ''){
			$__f_mdlstp = " AND mdlstpcl_mdlstp = {$__mdlstp} ";
		}
		$__in_mdlstp =	'  id_cl IN (SELECT mdlstpcl_cl FROM '._BdStr(DBM).TB_MDL_S_TP_CL.' WHERE mdlstpcl_cl = id_cl '.$__f_mdlstp.' ) ';
	}else{
		if($__mdlstp != ''){
			$__f_mdlstp = " AND mdlstpcl_mdlstp = {$__mdlstp} ";
		}
		$__in_mdlstp =	'  id_cl NOT IN (SELECT mdlstpcl_cl FROM '._BdStr(DBM).TB_MDL_S_TP_CL.' WHERE mdlstpcl_cl = id_cl '.$__f_mdlstp.') ';
	}
	
	$Sb_Qry = ", (SELECT cltag_vl FROM "._BdStr(DBM).TB_CL_TAG." WHERE cltag_sistag = 271 AND cltag_cl = id_cl ) AS _cl_clr";	
	$LsClMn_Qry = "	SELECT * $Sb_Qry
					FROM  "._BdStr(DBM).TB_CL."  
					WHERE {$__in_mdlstp} {$__schcod_mdlstp} 
					ORDER BY cl_nm ASC
				"; 
			
	$LsClMn = $__cnx->_qry($LsClMn_Qry);
	
	if($LsClMn){
		
		$row_LsClMn = $LsClMn->fetch_assoc(); 
		$Tot_LsClMn = $LsClMn->num_rows;
			
		if(($Tot_LsClMn>0)){	
			
			$rsp['e'] = 'ok';
			
			/* Listado de Clientes */
			$rsp['us_cl']['tt'] = TX_CL;
			$rsp['us_cl']['total'] = $Tot_LsClMn;
			
			if($Tot_LsClMn > 0){
				
				do {	
					if($row_LsClMn['_cl_clr'] == '' && $row_LsClMn['_cl_clr'] == NULL){ $_clr = "#000"; } else{ $_clr = $row_LsClMn['_cl_clr']; }
					
					$__mdlstp_o = GtMnuClDt([ 'cl'=>$row_LsClMn['id_cl'], 'md'=>$__mdlstp ]);
					
					$rsp['us_cl']['list'][] = ['id'=>$row_LsClMn['id_cl'], 
													'tt'=>ctjTx(strip_tags($row_LsClMn['cl_nm']),'in'),
													'enc'=>ctjTx(strip_tags($row_LsClMn['cl_enc']),'in'), 
													'clr'=>$_clr,
													'md'=>$__mdlstp_o
												];
													
														
				} while ($row_LsClMn = $LsClMn->fetch_assoc());
			}
			
		}else{
			
			$rsp['e'] = 'no';
		
		}
	
	}
	
	
	
	$__cnx->_clsr($LsClMn);
	
	
	
	
	
?>