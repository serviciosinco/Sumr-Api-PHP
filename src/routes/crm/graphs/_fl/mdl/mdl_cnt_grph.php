<?php 
		
	
	$_t2 = Php_Ls_Cln($_GET['_t2']);
	$_tp = Php_Ls_Cln($_GET['_tp']);
	$_gr = Php_Ls_Cln($_GET['_g_r']);
	
	
	$___Dt->sch->f = 'id_mdlcnt, id_cnt, mdlcnt_m, mdlcnt_dsp, mdlcnt_ref, cnt_nm, cnt_ap, mdlcnt_est, mdlcnt_mdl';
	
	$___Dt->sch->m = ' || (
		EXISTS (SELECT cnteml_cnt FROM '.TB_CNT_EML.' WHERE cnteml_cnt = id_cnt AND cnteml_eml LIKE \'%[-SCH-]%\' )  ||
		EXISTS (SELECT cntdc_cnt FROM '.TB_CNT_DC.' WHERE cntdc_cnt = id_cnt AND cntdc_dc LIKE \'%[-SCH-]%\' ) ||
		EXISTS (SELECT cnttel_cnt FROM '.TB_CNT_TEL.' WHERE cnttel_cnt = id_cnt AND cnttel_tel LIKE \'%[-SCH-]%\' ) 
	)';
	
	$___Dt->_strt();
	
	
	if( !isN($_t2) ){

		
		//-------------- FILTERS OUT  --------------//
		
		
			if(!isN($___Dt->_fl->f1) && !isN($___Dt->_fl->f2)){ 
				$___Dt->qry_f .= ' AND DATE_FORMAT(mdlcnt_fi, "%Y-%m-%d") BETWEEN "'.$___Dt->_fl->f1.'" AND "'.$___Dt->_fl->f2.'" '; 
			}elseif(!isN($___Dt->_fl->f1)){
				$___Dt->qry_f .= ' AND DATE_FORMAT(mdlcnt_fi, "%Y-%m-%d")  = "'.$___Dt->_fl->f1.'" ';
			}elseif(!isN($___Dt->_fl->f2)){
				$___Dt->qry_f .= ' AND DATE_FORMAT(mdlcnt_fi, "%Y-%m-%d")  = "'.$___Dt->_fl->f2.'" '; 
			}
		
			//$___Dt->qry_f .= " AND mdlst.mdlstp_tp = '".$___Dt->gt->tsb."' ";
			if(!isN($___Dt->gt->tsb_m)){ $___Dt->qry_f .= " AND mdlt.mdlstp_tp = '".$___Dt->gt->tsb_m."' "; }
			
			
			if(!isN($___Dt->_fl->org)){ 
				$__all_org = implode(',', $___Dt->_fl->org);
				$___Dt->qry_f .= ' AND EXISTS ( SELECT * 
											FROM '.TB_ORG_SDS_CNT.'
												 INNER JOIN '._BdStr(DBM).TB_ORG_SDS.' ON orgsdscnt_orgsds = id_orgsds
												 INNER JOIN '._BdStr(DBM).TB_ORG.' ON orgsds_org = id_org
											WHERE orgsdscnt_cnt = mdlcnt_cnt AND org_enc IN ('.$__all_org.')
										) ';					
			}
			
			
			if(!isN($___Dt->_fl->fk->clare_enc)){ 

				$__all_are = implode(',', $___Dt->_fl->fk->clare_enc);
				
				$___Dt->qry_f .= ' AND EXISTS ( SELECT *
											FROM '.TB_MDL_ARE.' 
												 INNER JOIN '._BdStr(DBM).TB_CL_ARE.' ON mdlare_are = id_clare
											WHERE mdlare_mdl = mdlcnt_mdl AND clare_enc IN ('.$__all_are.') AND clare_est = 1
										) ';					
			}
			
			if(!isN($___Ls->_fl->fk->mdlcnt_prd_wnt)){ 
			
				$__all_prd_w = implode(',', $___Ls->_fl->fk->mdlcnt_prd_wnt);
				
				$___Ls->qry_f .= ' AND EXISTS ( SELECT * 
											FROM '.TB_MDL_CNT_PRD.' 
												 INNER JOIN '._BdStr(DBM).TB_MDL_S_PRD.' ON mdlcntprd_mdlsprd = id_mdlsprd
											WHERE mdlcntprd_mdlcnt = id_mdlcnt AND  mdlsprd_enc IN ('.$__all_prd_w.')
										) ';
												
			}
		
		
				
			if(!ChckSESS_superadm()){	
				if(defined('SISUS_ARE') && !isN(SISUS_ARE)){
				
					$fl_are = ' EXISTS (	SELECT *  
											FROM '.TB_MDL_ARE.'  
											WHERE mdlare_mdl = id_mdl AND mdlare_are IN ('.SISUS_ARE.')	 
										) '; 
				}	
				
				if(defined('SISUS_MDL_N') && !isN(SISUS_MDL_N)){
					
					if(!isN($fl_are)){ $fl_mdl = ' || '; }
					
					$fl_mdl .= ' (	 EXISTS (	SELECT *  
												FROM '.TB_MDL_US.' 
												WHERE mdlus_mdl = id_mdl AND mdlus_mdl IN ('.SISUS_MDL_N.') )	 
											) '; 
				}	
			
				if(!isN($fl_mdl) || !isN($fl_are)){ $___Dt->qry_f .= ' AND ( '.$fl_are.$fl_mdl.' ) ';  }
				
				$fl_mdl .= " AND mdl_est != '"._CId('ID_SISMDLEST_ELI')."' ";  		
			}
		
		
		
		//-------------- START QUERYS AND BUILDERS  --------------//
	
		$__id_prfx = '_'.Gn_Rnd(20);
		
		
		if($_tp == "grph_1"){
			
			$__dt_1 = !isN($___Dt->_fl->f1) ? $___Dt->_fl->f1 : date('Y-m-01');
			$__dt_2 = !isN($___Dt->_fl->f2) ? $___Dt->_fl->f2 : date('Y-m-d');
			
			if(isN($___Dt->_fl->f1) && isN($___Dt->_fl->f2)){
				$___Dt->qry_f .= ' AND DATE_FORMAT(mdlcnt_fi, "%Y-%m-%d") BETWEEN "'.$__dt_1.'" AND "'.$__dt_2.'" ';
			}
			
			$Ls_Cnt_Qry = " SELECT *, DATE_FORMAT(mdlcnt_fi, '%Y-%m-%d') as _f_i
							FROM ".TB_MDL_CNT."
								 INNER JOIN ".TB_MDL." ON mdlcnt_mdl = id_mdl 
								 INNER JOIN "._BdStr(DBM).TB_MDL_S." ON mdl_mdls = id_mdls
								 INNER JOIN "._BdStr(DBM).TB_MDL_S_TP." AS mdlst ON mdls_tp = mdlst.id_mdlstp
								 INNER JOIN "._BdStr(DBM).TB_SIS_CNT_EST." ON mdlcnt_est = id_siscntest
								 INNER JOIN "._BdStr(DBM).TB_SIS_CNT_EST_TP." ON siscntest_tp = id_siscntesttp
								 INNER JOIN ".TB_CNT." ON mdlcnt_cnt = id_cnt 
								 INNER JOIN "._BdStr(DBM).TB_SIS_MD." ON mdlcnt_m = id_sismd
								 RIGHT JOIN "._BdStr(DBM).TB_SIS_FNT." ON mdlcnt_fnt = id_sisfnt
								 LEFT JOIN "._BdStr(DBM).TB_MDL_S_TP." AS mdlt ON mdl_mdlstp = mdlt.id_mdlstp
								 
							WHERE mdlst.mdlstp_tp = '".$_t2."' ".$___Dt->qry_f."
							ORDER BY id_mdlcnt DESC, mdlcnt_fa DESC
						";
				
			$Ls_Cnt_Rg = $__cnx->_qry($Ls_Cnt_Qry);
			
			
			if($Ls_Cnt_Rg){ 
				
				$row_Ls_Cnt_Rg = $Ls_Cnt_Rg->fetch_assoc(); 
				$Tot_Ls_Cnt_Rg = $Ls_Cnt_Rg->num_rows; 
				
				if($Tot_Ls_Cnt_Rg > 0){
					
					do {
						
						//Construye la grafica
						$Vl['ctg'][$row_Ls_Cnt_Rg['_f_i']] = $row_Ls_Cnt_Rg['_f_i'];
						
						//$Vl['d'][$row_Ls_Cnt_Rg['id_mdl']]['nm'] = ctjTx($row_Ls_Cnt_Rg['mdl_nm'], 'in');
						//$Vl['d'][$row_Ls_Cnt_Rg['id_mdl']]['f'][$row_Ls_Cnt_Rg['_f_i']]['tot']++;
						
						$Vl['d'][$row_Ls_Cnt_Rg['_f_i']]['tot']++;
					              
					} while ($row_Ls_Cnt_Rg = $Ls_Cnt_Rg->fetch_assoc());
					$Vl_Grph = _jEnc($Vl);
				}
				
			}
			
			for($i=$__dt_1;$i<=$__dt_2;$i = date("Y-m-d", strtotime($i ."+ 1 days"))){ 
				
				$__ctg[] = '"'.$i.'"'; 
				$_medio[] = (!isN($Vl_Grph->d->{$i}->tot)?$Vl_Grph->d->{$i}->tot:'0');
				
			}
			
			$_grph_d = "{ name:'Total ', data:[".implode(',', $_medio)."] } ";	
			
			$_grph_c = implode(",", $__ctg); 
			
			$CntWb .= "
				SUMR_Grph.f.g4({ 
					id: '#bx_grph_".$_gr."_1',
					c: [".$_grph_c."],
					d: [".$_grph_d."],
					tt: 'Leads', 
					tt_sb: 'Leads por Modulos',
					c_e: false,
					lgnd: false
				});
			";

				
		}elseif($_tp == "grph_2"){
			
			$Ls_Cnt_Qry = " SELECT sismd_tt, 
					  		COUNT(*) AS __tot_m 
							FROM ".TB_MDL_CNT."
								 INNER JOIN ".TB_MDL." ON mdlcnt_mdl = id_mdl 
								 INNER JOIN "._BdStr(DBM).TB_MDL_S." ON mdl_mdls = id_mdls
								 INNER JOIN "._BdStr(DBM).TB_MDL_S_TP." AS mdlst ON mdls_tp = mdlst.id_mdlstp
								 INNER JOIN ".TB_CNT." ON mdlcnt_cnt = id_cnt
								 INNER JOIN "._BdStr(DBM).TB_SIS_CNT_EST." ON mdlcnt_est = id_siscntest
								 INNER JOIN "._BdStr(DBM).TB_SIS_CNT_EST_TP." ON siscntest_tp = id_siscntesttp
								 INNER JOIN "._BdStr(DBM).TB_SIS_MD." ON mdlcnt_m = id_sismd
								 RIGHT JOIN "._BdStr(DBM).TB_SIS_FNT." ON mdlcnt_fnt = id_sisfnt
								 LEFT JOIN "._BdStr(DBM).TB_MDL_S_TP." AS mdlt ON mdl_mdlstp = mdlt.id_mdlstp
								 
							WHERE mdlst.mdlstp_tp = '".$_t2."' ".$___Dt->qry_f."
							GROUP BY mdlcnt_m 
							ORDER BY id_mdlcnt DESC, mdlcnt_fa DESC
						";
				
			$Ls_Cnt_Rg = $__cnx->_qry($Ls_Cnt_Qry);
			
			if($Ls_Cnt_Rg){ 
				
				$row_Ls_Cnt_Rg = $Ls_Cnt_Rg->fetch_assoc(); 
				$Tot_Ls_Cnt_Rg = $Ls_Cnt_Rg->num_rows; 
				
				if($Tot_Ls_Cnt_Rg > 0){
					
					do {
						
						if($row_Ls_Cnt_Rg['__tot_m'] < 1){ $_prnt = 0; }else{ $_prnt = $row_Ls_Cnt_Rg['__tot_m']; }
						
						$_medio[] = "{ name:'".ctjTx(str_replace("'", "",$row_Ls_Cnt_Rg['sismd_tt']),'in')."',   data:[". number_format($_prnt, 2, '.', '') ."] } "; 
						$_tabla .= '<tr><td>'.ctjTx($row_Ls_Cnt_Rg['sismd_tt'],'in').'</td><td>'. number_format($_prnt, 2, '.', '') .'</td></tr>';  
						                    
					} while ($row_Ls_Cnt_Rg = $Ls_Cnt_Rg->fetch_assoc());
				}
			}
			
			$_grph_tag = implode(",", $_medio);
			
			
			$CntWb .= "
				SUMR_Grph.f.g1({ 
					id: '#bx_grph_".$_gr."_2',
					d: [".$_grph_tag."],
					tt: 'Leads por medios', 
					tt_sb: 'Leads por medios',
					c_e: false,
					lgnd: true,
					lgnd_vrt: 'top'
				});
			";
			
		}elseif($_tp == "grph_3"){
			
			$Ls_Cnt_Qry = " SELECT mdl_nm, 
					  		COUNT(*) AS __tot_mdl 
							FROM ".TB_MDL_CNT."
								 INNER JOIN ".TB_MDL." ON mdlcnt_mdl = id_mdl 
								 INNER JOIN "._BdStr(DBM).TB_MDL_S." ON mdl_mdls = id_mdls
								 INNER JOIN "._BdStr(DBM).TB_MDL_S_TP." AS mdlst ON mdls_tp = mdlst.id_mdlstp
								 INNER JOIN "._BdStr(DBM).TB_SIS_CNT_EST." ON mdlcnt_est = id_siscntest
								 INNER JOIN "._BdStr(DBM).TB_SIS_CNT_EST_TP." ON siscntest_tp = id_siscntesttp
								 INNER JOIN ".TB_CNT." ON mdlcnt_cnt = id_cnt 
								 INNER JOIN "._BdStr(DBM).TB_SIS_MD." ON mdlcnt_m = id_sismd
								 RIGHT JOIN "._BdStr(DBM).TB_SIS_FNT." ON mdlcnt_fnt = id_sisfnt
								 LEFT JOIN "._BdStr(DBM).TB_MDL_S_TP." AS mdlt ON mdl_mdlstp = mdlt.id_mdlstp
								 
							WHERE mdlst.mdlstp_tp = '".$_t2."' ".$___Dt->qry_f."
							AND mdl_est != '"._CId('ID_SISMDLEST_ELI')."'
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
					id: '#bx_grph_".$_gr."_3',
					d: [".$_grph_tag."],
					tt: 'Leads por modulos', 
					tt_sb: 'Leads por modulos',
					c_e: false,
					lgnd: true,
					lgnd_vrt: 'top'
				});
			";
				
		}elseif($_tp == "grph_4"){
			
			$Ls_Cnt_Qry = " SELECT siscntesttp_tt, siscntesttp_clr_bck,
					  		COUNT(*) AS __tot_mdl 
							FROM ".TB_MDL_CNT."
								 INNER JOIN ".TB_MDL." ON mdlcnt_mdl = id_mdl 
								 INNER JOIN "._BdStr(DBM).TB_MDL_S." ON mdl_mdls = id_mdls
								 INNER JOIN "._BdStr(DBM).TB_MDL_S_TP." AS mdlst ON mdls_tp = mdlst.id_mdlstp
								 INNER JOIN "._BdStr(DBM).TB_SIS_CNT_EST." ON mdlcnt_est = id_siscntest
								 INNER JOIN "._BdStr(DBM).TB_SIS_CNT_EST_TP." ON siscntest_tp = id_siscntesttp
								 INNER JOIN ".TB_CNT." ON mdlcnt_cnt = id_cnt 
								 INNER JOIN "._BdStr(DBM).TB_SIS_MD." ON mdlcnt_m = id_sismd
								 RIGHT JOIN "._BdStr(DBM).TB_SIS_FNT." ON mdlcnt_fnt = id_sisfnt
								 LEFT JOIN "._BdStr(DBM).TB_MDL_S_TP." AS mdlt ON mdl_mdlstp = mdlt.id_mdlstp
								 
							WHERE mdlst.mdlstp_tp = '".$_t2."' ".$___Dt->qry_f."
							GROUP BY siscntest_tp 
							ORDER BY siscntesttp_ord ASC
						";
								
			$Ls_Cnt_Rg = $__cnx->_qry($Ls_Cnt_Qry);
			if($Ls_Cnt_Rg){ 
				$row_Ls_Cnt_Rg = $Ls_Cnt_Rg->fetch_assoc(); 
				$Tot_Ls_Cnt_Rg = $Ls_Cnt_Rg->num_rows; 
				if($Tot_Ls_Cnt_Rg > 0){
					do {
						
						if($row_Ls_Cnt_Rg['__tot_mdl'] < 1){ $_prnt = 0; }else{ $_prnt = $row_Ls_Cnt_Rg['__tot_mdl']; }
						
						if( !isN($row_Ls_Cnt_Rg['siscntesttp_clr_bck']) ){
							$_clr = $row_Ls_Cnt_Rg['siscntesttp_clr_bck'];
						}
						
						$_medio[] = "{ name:'".ctjTx(str_replace("'", "",$row_Ls_Cnt_Rg['siscntesttp_tt']),'in')."',   data:[". number_format($_prnt, 2, '.', '') ."], color:'".$_clr."' } "; 
						$_tabla .= '<tr><td>'.ctjTx($row_Ls_Cnt_Rg['siscntesttp_tt'],'in').'</td><td>'. number_format($_prnt, 2, '.', '') .'</td></tr>';  
						
						$_tot[] = $_prnt;
						$__grph_est[] = "{ name:'".ctjTx($row_Ls_Cnt_Rg['siscntesttp_tt'], 'in')."', y_lbl:".$_prnt.", y:1, color:'".$row_Ls_Cnt_Rg['siscntesttp_clr_bck']."', className:'".$__cls."' }";  
						
					} while ($row_Ls_Cnt_Rg = $Ls_Cnt_Rg->fetch_assoc());
				}
			}
			
			$_grph_tag = implode(",", $_medio);
			
			$_sum_tot = 0;
			
			foreach($_tot as $_v_tot){
				$_sum_tot = ($_sum_tot+$_v_tot);
			}
			
			$CntWb .= "
				setTimeout(function(){
					Highcharts.chart('bx_grph_".$_gr."_4', {
					    chart: {  type: 'funnel' },
					    title:{ text: 'Total ".$_sum_tot."' },
					    plotOptions: {
						    funnel: {
					            borderWidth: 4
					        },
					        series: {
					            dataLabels: {
					                enabled: true,
					                format: '<b>{point.name}</b> ({point.y_lbl:,.0f})',
					                color: 'black',
					                shadow: false,
					                distance: -30,
					                softConnector: true,
					                style:{
						                color: 'black',
						                fontSize: '11px',
						                fontWeight: 'lighter',
						                textOutline: null
					                }
					            },
					            center: ['50%', '50%'],
					            width: '50%',
					            height: '100%'
					        }
					    },
					    tooltip: {
						    formatter: function() {
						        return this.point.name+' ('+this.point.y_lbl+')';
						    }
						},
					    legend: {
					        enabled: false
					    },
					    credits: { enabled: false },
					    series: [{
					        data: [".(!isN($__grph_est)?implode(",", $__grph_est):'')."]
					    }]
					});
				
				}, 500);
			";
			
			/*$CntWb .= "
				SUMR_Grph.f.g1({ 
					id: '#bx_grph_3',
					d: [".$_grph_tag."],
					tt: 'Leads por estado', 
					tt_sb: 'Leads por estado',
					c_e: false
				});
			";*/

		}elseif($_tp == "grph_5"){
			
			/*
			$Ls_Cnt_Qry = " SELECT mdlcnt_m_k, 
					  		COUNT(*) AS __tot_m 
							FROM ".TB_MDL_CNT."
								 INNER JOIN ".TB_MDL." ON mdlcnt_mdl = id_mdl 
								 INNER JOIN "._BdStr(DBM).TB_MDL_S." ON mdl_mdls = id_mdls
								 INNER JOIN "._BdStr(DBM).TB_MDL_S_TP." AS mdlst ON mdls_tp = mdlst.id_mdlstp
								 INNER JOIN ".TB_CNT." ON mdlcnt_cnt = id_cnt
								 INNER JOIN "._BdStr(DBM).TB_SIS_CNT_EST." ON mdlcnt_est = id_siscntest
								 INNER JOIN "._BdStr(DBM).TB_SIS_CNT_EST_TP." ON siscntest_tp = id_siscntesttp
								 INNER JOIN "._BdStr(DBM).TB_SIS_MD." ON mdlcnt_m = id_sismd
								 RIGHT JOIN "._BdStr(DBM).TB_SIS_FNT." ON mdlcnt_fnt = id_sisfnt
								 LEFT JOIN "._BdStr(DBM).TB_MDL_S_TP." AS mdlt ON mdl_mdlstp = mdlt.id_mdlstp
								 
							WHERE mdlst.mdlstp_tp = '".$_t2."' ".$___Dt->qry_f."
							AND mdlcnt_m_k IS NOT NULL
							GROUP BY mdlcnt_m_k 
							ORDER BY id_mdlcnt DESC, mdlcnt_fa DESC
						";
				
			$Ls_Cnt_Rg = $__cnx->_qry($Ls_Cnt_Qry);
			if($Ls_Cnt_Rg){ 
				$row_Ls_Cnt_Rg = $Ls_Cnt_Rg->fetch_assoc(); 
				$Tot_Ls_Cnt_Rg = $Ls_Cnt_Rg->num_rows; 
				if($Tot_Ls_Cnt_Rg > 0){
					do {
						
						if($row_Ls_Cnt_Rg['__tot_m'] < 1){ $_prnt = 0; }else{ $_prnt = $row_Ls_Cnt_Rg['__tot_m']; }
						
						$_medio[] = "{ name:'".ctjTx(str_replace("'", "",$row_Ls_Cnt_Rg['mdlcnt_m_k']),'in')."',   data:[". number_format($_prnt, 2, '.', '') ."] } "; 
						$_tabla .= '<tr><td>'.ctjTx($row_Ls_Cnt_Rg['mdlcnt_m_k'],'in').'</td><td>'. number_format($_prnt, 2, '.', '') .'</td></tr>';  
						                    
					} while ($row_Ls_Cnt_Rg = $Ls_Cnt_Rg->fetch_assoc());
				}
			}
			$_grph_tag = implode(",", $_medio);
			
			$CntWb .= "
				SUMR_Grph.f.g1({ 
					id: '#bx_grph_".$_gr."_5',
					d: [".$_grph_tag."],
					tt: ' - Keywords - ', 
					tt_sb: 'Leads por Keyword',
					c_e: false
				});
			";
			
			*/
			
		}elseif($_tp == "grph_6"){
			
			$Ls_Cnt_Qry = " SELECT sisfnt_nm, 
					  		COUNT(*) AS __tot_m 
							FROM ".TB_MDL_CNT."
								 INNER JOIN ".TB_MDL." ON mdlcnt_mdl = id_mdl 
								 INNER JOIN "._BdStr(DBM).TB_MDL_S." ON mdl_mdls = id_mdls
								 INNER JOIN "._BdStr(DBM).TB_MDL_S_TP." AS mdlst ON mdls_tp = mdlst.id_mdlstp
								 INNER JOIN ".TB_CNT." ON mdlcnt_cnt = id_cnt
								 INNER JOIN "._BdStr(DBM).TB_SIS_FNT." ON mdlcnt_fnt = id_sisfnt
								 LEFT JOIN "._BdStr(DBM).TB_MDL_S_TP." AS mdlt ON mdl_mdlstp = mdlt.id_mdlstp
								 
							WHERE mdlst.mdlstp_tp = '".$_t2."' ".$___Dt->qry_f."
							GROUP BY mdlcnt_fnt
							ORDER BY id_mdlcnt DESC, mdlcnt_fa DESC
						";
				
			$Ls_Cnt_Rg = $__cnx->_qry($Ls_Cnt_Qry);
			
			if($Ls_Cnt_Rg){ 
				
				$row_Ls_Cnt_Rg = $Ls_Cnt_Rg->fetch_assoc(); 
				$Tot_Ls_Cnt_Rg = $Ls_Cnt_Rg->num_rows; 
				
				if($Tot_Ls_Cnt_Rg > 0){
					
					do {
						
						if($row_Ls_Cnt_Rg['__tot_m'] < 1){ $_prnt = 0; }else{ $_prnt = $row_Ls_Cnt_Rg['__tot_m']; }
						
						$_medio[] = "{ name:'".ctjTx(str_replace("'", "",$row_Ls_Cnt_Rg['sisfnt_nm']),'in')."',   data:[". number_format($_prnt, 2, '.', '') ."] } "; 
						$_tabla .= '<tr><td>'.ctjTx($row_Ls_Cnt_Rg['sisfnt_nm'],'in').'</td><td>'. number_format($_prnt, 2, '.', '') .'</td></tr>';  
						                    
					} while ($row_Ls_Cnt_Rg = $Ls_Cnt_Rg->fetch_assoc());
				}
			}
			
			$_grph_tag = implode(",", $_medio);
			
			
			$CntWb .= "
				SUMR_Grph.f.g1({ 
					id: '#bx_grph_".$_gr."_6',
					d: [".$_grph_tag."],
					tt: ' ', 
					tt_sb: ' Leads por fuentes ',
					c_e: false,
					lgnd: true,
					lgnd_vrt: 'top'
				});
			";
			
		}elseif($_tp == "grph_7"){

			$Ls_Cnt_Qry = " SELECT org_nm, 
					  		COUNT(*) AS __tot_m 
							FROM ".TB_MDL_CNT."
								 INNER JOIN "._BdStr(DBM).TB_ORG." ON mdlcnt_noi_otc = id_org
							WHERE id_org != 19
							GROUP BY mdlcnt_noi_otc
							ORDER BY id_mdlcnt DESC, mdlcnt_fa DESC
						";
				
			$Ls_Cnt_Rg = $__cnx->_qry($Ls_Cnt_Qry);
			
			if($Ls_Cnt_Rg){ 
				
				$row_Ls_Cnt_Rg = $Ls_Cnt_Rg->fetch_assoc(); 
				$Tot_Ls_Cnt_Rg = $Ls_Cnt_Rg->num_rows; 
				
				if($Tot_Ls_Cnt_Rg > 0){
					
					do {
						
						if($row_Ls_Cnt_Rg['__tot_m'] < 1){ $_prnt = 0; }else{ $_prnt = $row_Ls_Cnt_Rg['__tot_m']; }
						
						$_medio[] = "{ name:'".ctjTx(str_replace("'", "",$row_Ls_Cnt_Rg['org_nm']),'in')."',   data:[". number_format($_prnt, 2, '.', '') ."] } "; 
						$_tabla .= '<tr><td>'.ctjTx($row_Ls_Cnt_Rg['org_nm'],'in').'</td><td>'. number_format($_prnt, 2, '.', '') .'</td></tr>';  
						                    
					} while ($row_Ls_Cnt_Rg = $Ls_Cnt_Rg->fetch_assoc());
				}
			}
			
			$_grph_tag = implode(",", $_medio);
			
			
			$CntWb .= "
				SUMR_Grph.f.g1({ 
					id: '#bx_grph_".$_gr."_7',
					d: [".$_grph_tag."],
					tt: ' ', 
					tt_sb: ' Leads por fuentes ',
					c_e: false,
					lgnd: true,
					lgnd_vrt: 'top'
				});
			";
			
		}elseif($_tp == "grph_8" && $_t2 == 'prg' ){

			?> 
				<style>
					#bx_grph_<?php echo $_gr; ?>_8{
						display:flex;
					}
					.grph_8 {
						flex: 1 1 0px;
					}
				</style> <?php

			$Ls_Cnt_Qry = " SELECT mdlsprd_enc, mdlsprd_nm, siscntesttp_tt, siscntesttp_enc, siscntesttp_clr_bck , 
							COUNT(*) AS __tot_mdl
							FROM ".TB_MDL_CNT."
								 INNER JOIN ".TB_MDL." ON mdlcnt_mdl = id_mdl
								 INNER JOIN ".TB_MDL_CNT_PRD." ON mdlcntprd_mdlcnt = id_mdlcnt
								 INNER JOIN "._BdStr(DBM).TB_MDL_S_PRD." ON mdlcntprd_mdlsprd = id_mdlsprd
								 INNER JOIN "._BdStr(DBM).TB_MDL_S." ON mdl_mdls = id_mdls
								 INNER JOIN "._BdStr(DBM).TB_MDL_S_TP." AS mdlst ON mdls_tp = mdlst.id_mdlstp
								 INNER JOIN "._BdStr(DBM).TB_SIS_CNT_EST." ON mdlcnt_est = id_siscntest
								 INNER JOIN "._BdStr(DBM).TB_SIS_CNT_EST_TP." ON siscntest_tp = id_siscntesttp
							WHERE mdlsprd_est = 1 AND mdlst.mdlstp_tp = '".$_t2."' ".$___Dt->qry_f."
							GROUP BY siscntest_tp , id_mdlsprd
							ORDER BY mdlsprd_nm, mdlsprd_y
						";

			$Ls_Cnt_Rg = $__cnx->_qry($Ls_Cnt_Qry);
			if($Ls_Cnt_Rg){ 
				$row_Ls_Cnt_Rg = $Ls_Cnt_Rg->fetch_assoc(); 
				$Tot_Ls_Cnt_Rg = $Ls_Cnt_Rg->num_rows; 
				if($Tot_Ls_Cnt_Rg > 0){
					do {
						
						if($row_Ls_Cnt_Rg['__tot_mdl'] < 1){ $_prnt = 0; }else{ $_prnt = $row_Ls_Cnt_Rg['__tot_mdl']; }

						$__Vl['ls'][$row_Ls_Cnt_Rg['mdlsprd_enc']]['enc'] = $row_Ls_Cnt_Rg['mdlsprd_enc'];
						$__Vl['ls'][$row_Ls_Cnt_Rg['mdlsprd_enc']]['prd'] = $row_Ls_Cnt_Rg['mdlsprd_nm'];
						$__Vl['ls'][$row_Ls_Cnt_Rg['mdlsprd_enc']]['est'][$row_Ls_Cnt_Rg['siscntesttp_enc']]['nm'] = $row_Ls_Cnt_Rg['siscntesttp_tt'];
						$__Vl['ls'][$row_Ls_Cnt_Rg['mdlsprd_enc']]['est'][$row_Ls_Cnt_Rg['siscntesttp_enc']]['tot'] = $_prnt;
						$__Vl['ls'][$row_Ls_Cnt_Rg['mdlsprd_enc']]['est'][$row_Ls_Cnt_Rg['siscntesttp_enc']]['clr'] = $row_Ls_Cnt_Rg['siscntesttp_clr_bck'];

					} while ($row_Ls_Cnt_Rg = $Ls_Cnt_Rg->fetch_assoc());
				}
			}

			$vl = _jEnc($__Vl);

			foreach($vl->ls as $k => $v){

				$d['est'] = [];

				foreach($v->est as $_k => $_v){
					$d['est'][] = "{ name:'".ctjTx($_v->nm, 'in')."', y_lbl:".$_v->tot.", y:1, color:'".$_v->clr."' }";	
				}

				echo bdiv([ 'id'=>'bx_grph_'.$v->enc, 'cls'=>'grph_8' ]);

				$CntWb .= "

				setTimeout(function(){
					Highcharts.chart('bx_grph_".$v->enc."', {
					    chart: {  type: 'funnel' },
					    title:{ 
							text: '".$v->prd."',
							style: {
								fontSize:'12px'
							}
						},
					    plotOptions: {
						    funnel: {
					            borderWidth: 4
					        },
					        series: {
					            dataLabels: {
					                enabled: false,
					                format: '<b>{point.name}</b> ({point.y_lbl:,.0f})',
					                color: 'black',
					                shadow: false,
					                softConnector: true,
					                style:{
						                color: 'black',
						                fontSize: '11px',
						                fontWeight: 'lighter',
						                textOutline: null
					                }
								},
								center: ['50%', '0%'],
								neckWidth: '30%',
								neckHeight: '25%',
								width: '50%',
								height: '50%'
					        }
					    },
					    tooltip: {
						    formatter: function() {
						        return this.point.name+' ('+this.point.y_lbl+')';
						    }
						},
					    legend: {
					        enabled: false
					    },
					    credits: { enabled: false },
					    series: [{
					        data: [".(!isN($d['est'])?implode(",", $d['est']):'')."]
						}],
						responsive: {
							rules: [{
								condition: {
									maxWidth: 500
								},
								chartOptions: {
									plotOptions: {
										series: {
											dataLabels: {
												inside: true
											},
											center: ['50%', '50%'],
											width: '100%'
										}
									}
								}
							}]
						}
					});
				
				}, 500);
			";

			}
			

		}
		
	} 
	
?>