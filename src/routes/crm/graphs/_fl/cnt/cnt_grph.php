<?php
		
	
	$_t2 = Php_Ls_Cln($_GET['_t2']);
	$_tp = Php_Ls_Cln($_GET['_tp']);
	$_gr = Php_Ls_Cln($_GET['_g_r']);
	
	
	$___Dt->sch->f = 'id_mdlcnt, id_cnt, mdlcnt_m, mdlcnt_dsp, mdlcnt_ref, cnt_nm, cnt_ap, mdlcnt_est, mdlcnt_mdl';
	
	$___Dt->sch->m = ' || (
		id_cnt IN (SELECT cnteml_cnt FROM '.TB_CNT_EML.' WHERE cnteml_eml LIKE \'%[-SCH-]%\' )  ||
		id_cnt IN (SELECT cntdc_cnt FROM '.TB_CNT_DC.' WHERE cntdc_dc LIKE \'%[-SCH-]%\' ) ||
		id_cnt IN (SELECT cnttel_cnt FROM '.TB_CNT_TEL.' WHERE cnttel_tel LIKE \'%[-SCH-]%\' ) 
	)';
	
	$___Dt->_strt();
	
	
	if( !isN($_tp) ){ 
		
		
		//-------------- START QUERYS AND BUILDERS  --------------//
	
		$__id_prfx = '_'.Gn_Rnd(20);
		

		if($_tp == "grph_1" && $_t2 == 'hbs'){
			
			if(defined('SISUS_PLCY') && !ChckSESS_superadm()){
				$___Dt->qry_f .= ' AND id_clplcy IN ('.SISUS_PLCY.') '; 
			}
		
			$Ls_Qry = " SELECT *, 
								COUNT(*) as _tot
						FROM ".TB_CNT."
							 LEFT JOIN ".TB_CNT_PLCY." ON cntplcy_cnt = id_cnt
							 LEFT JOIN "._BdStr(DBM).TB_CL_PLCY." ON cntplcy_plcy = id_clplcy							 
						WHERE id_cnt != '' ".$___Dt->qry_f."
						GROUP BY id_cnt
					"; echo $Ls_Qry;
				
			$LsRg = $__cnx->_qry($Ls_Qry);
			
			
			if($LsRg){ 
				
				$row_LsRg = $LsRg->fetch_assoc(); 
				$Tot_LsRg = $LsRg->num_rows;
				 
				if($Tot_LsRg > 0){
					
					do {
						
						if(mBln($row_LsRg['cntplcy_sndi'])=='ok'){ $_nm=TX_YES; $_clr='#277848'; }else{ $_nm=TX_NO; $_clr='#a0123a'; }
						$__data[] = [ 'nm'=>$_nm.' ('.$row_LsRg['_tot'].')', 'n'=>$row_LsRg['_tot'], 'clr'=>$_clr ];
					    $__data_tot = $__data_tot+$row_LsRg['_tot'];
					              
					} while ($row_LsRg = $LsRg->fetch_assoc());
					
					if(!isN($__data)){
						
						
						foreach($__data as $__data_k=>$__data_v){
							$__tot_grph = ($__data_v['n'] * 100) / $__data_tot;
							$__data_g[] = "{name: '".$__data_v['nm']."', y: "._Nmb( $__tot_grph , 5).", color:'".$__data_v['clr']."' }";	
						}
						
						$CntWb .= "
		
							SUMR_Grph.f.g2({ 
								id: '#bx_grph_".$_gr."_1',
								tt: ' ',
								d: [".implode(',', $__data_g)."]
							});
			
			
						";
						
						
					}
				}
				
			
			}	
				
		}elseif($_tp == "grph_2" && $_t2 == 'hbs'){
			
			$__dt_1 = !isN($___Dt->_fl->f1) ? $___Dt->_fl->f1 : date('Y-m-01');
			$__dt_2 = !isN($___Dt->_fl->f2) ? $___Dt->_fl->f2 : date('Y-m-d');
			
			if(isN($___Dt->_fl->f1) && isN($___Dt->_fl->f2)){
				$___Dt->qry_f .= ' AND DATE_FORMAT(datahis_fi, "%Y-%m-%d") BETWEEN "'.$__dt_1.'" AND "'.$__dt_2.'" ';
			}
			
			$Ls_Qry = " SELECT *, 
								datahis_v,
								DATE_FORMAT(datahis_fi, '%Y-%m-%d') as _f_i,
								COUNT(*) as _tot
							FROM ".TB_DATA_HIS."
							WHERE datahis_tp='cnt' ".$___Dt->qry_f." AND datahis_f='cnt_sndi'
							GROUP BY datahis_fi, datahis_v
						"; 
				
			$LsRg = $__cnx->_qry($Ls_Qry);
			
			
			if($LsRg){ 
				
				$row_LsRg = $LsRg->fetch_assoc(); 
				$Tot_LsRg = $LsRg->num_rows;
				
				if($Tot_LsRg > 0){
					
					do {
						
						if(mBln($row_LsRg['datahis_v'])=='ok'){ $_nm=TX_YES; $_clr='#277848'; }else{ $_nm=TX_NO; $_clr='#a0123a'; }
						
						$Vl['ctg_s'][$row_LsRg['datahis_v']]=['nm'=>$_nm, 'clr'=>$_clr];
						$Vl['ctg'][$row_LsRg['_f_i']]['d'] = $row_LsRg['_f_i'];
						$Vl['ctg'][$row_LsRg['_f_i']]['s'] = $_nm;
						
						$Vl['d'][$row_LsRg['_f_i']][$row_LsRg['datahis_v']]['nm']=$_nm;
						$Vl['d'][$row_LsRg['_f_i']][$row_LsRg['datahis_v']]['clr']=$_clr;
						$Vl['d'][$row_LsRg['_f_i']][$row_LsRg['datahis_v']]['tot']++;
					              
					} while ($row_LsRg = $LsRg->fetch_assoc());
					
					$Vl_Grph = _jEnc($Vl);
					
					for($i=$__dt_1;$i<=$__dt_2;$i = date("Y-m-d", strtotime($i ."+ 1 days"))){ 		
						$__ctg[] = '"'.$i.'"'; 
						foreach($Vl_Grph->ctg_s as $ctg_s_k=>$ctg_s_v){
							$_sndiopt[$ctg_s_k][] = (!isN($Vl_Grph->d->{$i}->{$ctg_s_k}->tot)?$Vl_Grph->d->{$i}->{$ctg_s_k}->tot:'0');	
						}	
					}
					
					foreach($Vl_Grph->ctg_s as $ctg_s_k=>$ctg_s_v){
						$_grph_d[] = "{ name:'".$ctg_s_v->nm."', data:[".implode(',', $_sndiopt[$ctg_s_k])."], color:'".$ctg_s_v->clr."' } ";
					}
			
					$CntWb .= "
						SUMR_Grph.f.g4({ 
							id: '#bx_grph_".$_gr."_2',
							c: [".implode(",", $__ctg)."],
							d: [".implode(',', $_grph_d)."],
							tt: 'Leads', 
							tt_sb: '".TX_HBSACCPT."',
							c_e: false,
							lgnd: false
						});
					";
			
			
				}
				
			}
			
				
		}
		
		
	} 
	
?>