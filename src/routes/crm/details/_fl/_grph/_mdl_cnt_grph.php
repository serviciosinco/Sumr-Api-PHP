<?php 
		
	$_t2 = Php_Ls_Cln($_GET['_t2']);
	$_tp = Php_Ls_Cln($_GET['_tp']);
	
	if( !isN($_t2) ){
		
		$__id_prfx = '_'.Gn_Rnd(20);
		
		
		if($_tp == "grph_1"){
			
			$Ls_Cnt_Qry = " SELECT mdl_nm, 
					  		COUNT(*) AS __tot_mdl 
							FROM ".TB_MDL_CNT."
								 INNER JOIN ".TB_MDL." ON mdlcnt_mdl = id_mdl 
								 INNER JOIN "._BdStr(DBM).TB_MDL_S." ON mdl_mdls = id_mdls
								 INNER JOIN "._BdStr(DBM).TB_MDL_S_TP." ON mdls_tp = id_mdlstp
								 INNER JOIN "._BdStr(DBM).TB_SIS_CNT_EST." ON mdlcnt_est = id_siscntest
								 INNER JOIN ".TB_CNT." ON mdlcnt_cnt = id_cnt 
							WHERE mdlstp_tp = '".$_t2."'
							GROUP BY mdlcnt_mdl 
							ORDER BY id_mdlcnt DESC, mdlcnt_fa DESC
						";
				
				
			$Ls_Cnt_Rg = $__cnx->_qry($Ls_Cnt_Qry);
			if($Ls_Cnt_Rg){ 
				$row_Ls_Cnt_Rg = $Ls_Cnt_Rg->fetch_assoc(); 
				$Tot_Ls_Cnt_Rg = $Ls_Cnt_Rg->num_rows; 
				if($Tot_Ls_Cnt_Rg > 0){
					do {
						
						if($row_Ls_Cnt_Rg['__tot_mdl'] < 1){ $_prnt = 0; }else{ $_prnt = $row_Ls_Cnt_Rg['__tot_mdl']; }
						
						$_medio[] = "{ name:'".ctjTx(str_replace("'", "",$row_Ls_Cnt_Rg['mdl_nm']),'in')."',   data:[". number_format($_prnt, 2, '.', '') ."] } "; 
						$_tabla .= '<tr><td>'.ctjTx($row_Ls_Cnt_Rg['mdl_nm'],'in').'</td><td>'. number_format($_prnt, 2, '.', '') .'</td></tr>';  
						                    
					} while ($row_Ls_Cnt_Rg = $Ls_Cnt_Rg->fetch_assoc());
				}
			}
			$_grph_tag = implode(",", $_medio);
			
			$CntWb .= "
				SUMR_Grph.f.g1({ 
					id: '#bx_grph_1',
					d: [".$_grph_tag."],
					tt: 'Leads por modulos', 
					tt_sb: 'Leads por modulos',
					c_e: false
				});
			";
				
		}
		
	}
	
?>