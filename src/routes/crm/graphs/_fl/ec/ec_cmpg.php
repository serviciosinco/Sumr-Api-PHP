<?php 
		
	
	$_t2 = Php_Ls_Cln($_GET['_t2']);
	$_tp = Php_Ls_Cln($_GET['_tp']);
	$_gr = Php_Ls_Cln($_GET['_g_r']);
	$___Dt->_strt();
	
		
	//-------------- FILTERS OUT  --------------//
	
		$__dt_1 = !isN($___Dt->_fl->f1) ? $___Dt->_fl->f1 : date('Y-m-01');
		$__dt_2 = !isN($___Dt->_fl->f2) ? $___Dt->_fl->f2 : date('Y-m-d');
	
	//-------------- START QUERYS AND BUILDERS  --------------//

	$__id_prfx = '_'.Gn_Rnd(20);
	
	
	if($_tp == "grph_1"){
		
		
		
		if(isN($___Dt->_fl->f1) && isN($___Dt->_fl->f2)){
			$___Dt->qry_f .= ' AND DATE_FORMAT(eccmpg_fi, "%Y-%m-%d") BETWEEN "'.$__dt_1.'" AND "'.$__dt_2.'" ';
		}
        
		
		$Ls_Qry = " 		SELECT COUNT(*) AS __tot, 
							DATE_FORMAT(eccmpg_fi, '%Y-%m-%d') as _f_i
						FROM "._BdStr(DBM).TB_EC_CMPG."
							 INNER JOIN "._BdStr(DBM).TB_CL." ON eccmpg_cl = id_cl
						WHERE id_eccmpg != '' AND cl_enc = '".CL_ENC."' ".$___Dt->qry_f."
						GROUP BY _f_i
						ORDER BY id_eccmpg DESC, eccmpg_fa DESC
		";
	
			
		$Ls_Rg = $__cnx->_qry($Ls_Qry);
		
		if($Ls_Rg){ 
			
			$row_Ls_Rg = $Ls_Rg->fetch_assoc(); 
			$Tot_Ls_Rg = $Ls_Rg->num_rows; 
			
			
			if($Tot_Ls_Rg > 0){
				
				do {
					$Vl[$row_Ls_Rg['_f_i']]['date'] = $row_Ls_Rg['_f_i'];
					$Vl[$row_Ls_Rg['_f_i']]['tot'] = $row_Ls_Rg['__tot'];             
				} while ($row_Ls_Rg = $Ls_Rg->fetch_assoc());
				
				$Vl_Grph = _jEnc($Vl);
				
				
				for($i=$__dt_1;$i<=$__dt_2; $i=date("Y-m-d", strtotime($i ."+ 1 days"))){ 	
					$__ctg[] = '"'.$i.'"';
					if(!isN($Vl_Grph->{$i}->tot)){ $_tot=$Vl_Grph->{$i}->tot; }else{ $_tot=0; }
					$_medio_tot[] = $_tot;	
				}
				
				if(!isN($__ctg) && !isN($_medio_tot)){
					
					$_grph_d = "{ name:'Solicitudes', data:[".implode(",", $_medio_tot)."] } ";	
					$_grph_c = implode(",", $__ctg);
					
					if(!isN($_grph_d) && !isN($_grph_d)){
						
						$CntWb .= "
							SUMR_Grph.f.g4({ 
								id: '#bx_grph_".$_gr."_1',
								c: [".$_grph_c."],
								d: [".$_grph_d."],
								tt: ' ', 
								tt_sb: ' ',
								c_e: false
							});
						";
					
					}
				
				}
			
			}
			
		
		}else{
			
			echo $__cnx->c_r->error;
			
		}
		
		
			
	} 
		
	
	
?>