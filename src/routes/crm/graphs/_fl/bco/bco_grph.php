<?php 
		
	$_t2 = Php_Ls_Cln($_GET['_t2']);
	$_tp = Php_Ls_Cln($_GET['_tp']);
	$_gr = Php_Ls_Cln($_GET['_g_r']);
	
	$___Dt->sch->f = 'id_bco';
	
	
	$___Ls->sch->m = ' || (
		id_bco IN (	SELECT bcotag_bco FROM '._BdStr(DBM).TB_BCO_TAG.' WHERE bcotag_tag_es LIKE \'%[-SCH-]%\' || 
																bcotag_tag_en LIKE \'%[-SCH-]%\' ||
																bcotag_tag_it LIKE \'%[-SCH-]%\' ||
																bcotag_tag_fr LIKE \'%[-SCH-]%\' ||
																bcotag_tag_gr LIKE \'%[-SCH-]%\' ||
																bcotag_tag_krn LIKE \'%[-SCH-]%\' ||
																bcotag_tag_jpn LIKE \'%[-SCH-]%\' ||
																bcotag_tag_ptg LIKE \'%[-SCH-]%\' ||
																bcotag_tag_mdn LIKE \'%[-SCH-]%\'
					)
	)';
	
	
	$___Dt->_strt();
	
	
	if( !isN($_tp) ){
		
		
		//-------------- START QUERYS AND BUILDERS  --------------//
	
		$__id_prfx = '_'.Gn_Rnd(20);
		
		
		if($_tp == "grph_1"){
			
			
			$__dt_1 = !isN($___Dt->_fl->f1) ? $___Dt->_fl->f1 : date('Y-m-01');
			$__dt_2 = !isN($___Dt->_fl->f2) ? $___Dt->_fl->f2 : date('Y-m-d');
			
			if(isN($___Dt->_fl->f1) && isN($___Dt->_fl->f2)){
				$___Dt->qry_f .= ' AND DATE_FORMAT(bco_fi, "%Y-%m-%d") BETWEEN "'.$__dt_1.'" AND "'.$__dt_2.'" ';
			}
			
			
			$Ls_Cnt_Qry = " 
							SELECT COUNT(*) AS __tot_m, DATE_FORMAT(bco_fi, '%Y-%m-%d') as _f_i, us_enc, us_nm, us_ap
							FROM "._BdStr(DBM).TB_BCO."
								INNER JOIN "._BdStr(DBM).TB_CL." ON bco_cl = id_cl
								INNER JOIN "._BdStr(DBM).TB_US." ON id_us = bco_us
							WHERE id_bco != '' ".$___Dt->qry_f." AND cl_enc = '".DB_CL_ENC."'
							GROUP BY bco_us, DATE_FORMAT(bco_fi, '%Y-%m-%d')
						";

			$Ls_Cnt_Rg = $__cnx->_qry($Ls_Cnt_Qry);
			
			if($Ls_Cnt_Rg){ 
				$row_Ls_Cnt_Rg = $Ls_Cnt_Rg->fetch_assoc(); 
				$Tot_Ls_Cnt_Rg = $Ls_Cnt_Rg->num_rows; 
				if($Tot_Ls_Cnt_Rg > 0){
					
					do {
						$_us_enc = $row_Ls_Cnt_Rg['us_enc'];
						
						$Vl['user'][ $_us_enc ] = ctjTx($row_Ls_Cnt_Rg['us_nm']." ".$row_Ls_Cnt_Rg['us_ap'],'in');
						$Vl['ctg'][$row_Ls_Cnt_Rg['_f_i']];
						$Vl['d'][ $_us_enc ][$row_Ls_Cnt_Rg['_f_i']]['tot'] = $row_Ls_Cnt_Rg['__tot_m'];
						                    
					} while ($row_Ls_Cnt_Rg = $Ls_Cnt_Rg->fetch_assoc());
					
					$Vl_Grph = _jEnc($Vl);
				}
			}
			
			for($i=$__dt_1;$i<=$__dt_2;$i = date("Y-m-d", strtotime($i ."+ 1 days"))){ 	
				$__ctg[] = '"'.$i.'"'; 
				foreach($Vl_Grph->user as $_user_k=>$_user_v){					
					$_user[$_user_k][] = (!isN($Vl_Grph->d->{$_user_k}->{$i}->tot)?$Vl_Grph->d->{$_user_k}->{$i}->tot:'0');
				}
			}
			
			foreach($Vl_Grph->user as $_user_k=>$_user_v){
				$_grph_d[] = '{name:"'.$_user_v.'", data:['.implode(",", $_user[$_user_k]).'] }';
			}

			$_grph_c = implode(",", $__ctg); 
			
			$CntWb .= "
				SUMR_Grph.f.g4({ 
					id: '#bx_grph_".$_gr."_1',
					c: [".$_grph_c."],
					d: [".implode(",", $_grph_d)."],
					tt: 'Cargas', 
					tt_sb: 'Cargas por Usuario',
					c_e: false,
					lgnd: false
				});
			";
				
		}
		
		
	} 
	
?>