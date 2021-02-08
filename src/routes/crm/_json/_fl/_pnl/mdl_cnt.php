<?php 

	
	$__grph_id = Gn_Rnd(20);
	
	
	$Ls_Cnt_Qry = "	SELECT mdlstp_nm, COUNT(*)AS __tot_rst 
				FROM ".TB_MDL_CNT."
					 INNER JOIN ".TB_BD." ON mdlcnt_mdl = id_mdl
					 INNER JOIN "._BdStr(DBM).TB_MDL_S." ON mdl_mdls = id_mdls
					 INNER JOIN "._BdStr(DBM).TB_MDL_S_TP." ON mdls_tp = id_mdlstp 
				WHERE id_mdlcnt != '' GROUP BY mdlstp_tp";
				
	$Ls_Cnt_Rg = $__cnx->_qry($Ls_Cnt_Qry);  $row_Ls_Cnt_Rg = $Ls_Cnt_Rg->fetch_assoc(); $Tot_Ls_Cnt_Rg = $Ls_Cnt_Rg->num_rows; 	

	do {
		
		$_tot = (int)$row_Ls_Cnt_Rg['__tot_rst'];
		$_js_v[] = ['name'=>$row_Ls_Cnt_Rg['mdlstp_nm'], 'data'=>[$_tot], 'color'=>Gn_Rnd_Clr()];  
		  
	} while ($row_Ls_Cnt_Rg = $Ls_Cnt_Rg->fetch_assoc()); 

	$pnl[$__k_r]['d'] = $_js_v;
	
	
?>