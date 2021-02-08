<?php 	
	
	
	$_f1 = Php_Ls_Cln($_GET['_f_in']); 
	$_f2 = Php_Ls_Cln($_GET['_f_out']);
	$_tp = Php_Ls_Cln($_GET['_tp']);
	$_f = Php_Ls_Cln($_GET['_f']);
	$_mdl = Php_Ls_Cln($_GET['_f_mdl']);
	$_md = Php_Ls_Cln($_GET['_f_md']);
	$_us = Php_Ls_Cln($_GET['_f_us']);
	$_are = Php_Ls_Cln($_GET['_f_are']);
	$_prd_a = Php_Ls_Cln($_GET['_f_prd_a']);
	$_ftp = Php_Ls_Cln($_GET['_f_tp']);
	$_prd_i = Php_Ls_Cln($_GET['_f_prd_i']);
	$_fnt = Php_Ls_Cln($_GET['_f_fnt']);
	$_mdl_s = Php_Ls_Cln($_GET['_f_mdl_s']);
	
	
	$__dt_1 = !isN($_f1) ? $_f1 : date('Y-m-01');
	$__dt_2 = !isN($_f2) ? $_f2 : date('Y-m-d');
				
				

	if( !isN($__t2)){
		
		$__id_prfx = '_'.Gn_Rnd(20);
		
		/* Filtros */
		if( !isN($_mdl) ){

            $_mdl = str_replace(",", "','", $_mdl);

            $__fl .= " AND mdl_enc IN ('".$_mdl."')";
        }
				
		if( !isN($_md) ){
			$__fl .= ' AND mdlcnt_m  = '.$_md.' ';
		}
		
		if( !isN($_are) ){
			$__fl .= '  AND mdlcnt_mdl IN ( SELECT mdlare_mdl 
								FROM '.TB_MDL_ARE.' 
									 INNER JOIN '._BdStr(DBM).TB_CL_ARE.' ON mdlare_are = id_clare
								WHERE id_clare IN ('.$_are.') AND clare_est = 1
						)';
		}
		if( !isN($_prd_a) ){
			$__fl .= ' AND id_mdlcnt IN ( SELECT mdlcntprd_mdlcnt 
									FROM '.TB_MDL_CNT_PRD.' 
										 INNER JOIN '._BdStr(DBM).TB_MDL_S_PRD.'  ON id_mdlsprd =  mdlcntprd_mdlsprd 
									WHERE id_mdlsprd IN ('.$_prd_a.')
							)';
		}
		if( !isN($_prd_i) ){
			$__fl .= ' AND  mdlcnt_prd = '.$_prd_i.'';
		}
		
		if( !isN($_tp) ){
			$__fl .= ' AND mdlstp_tp = "'.$_tp.'" ';
		}

		if( !isN($_fnt) ){
			$__fl .= ' AND mdlcnt_fnt  = '.$_fnt.' ';
		}

		
		if( !isN($_mdl_s) ){
			$__fl .= ' AND id_mdls  = '.$_mdl_s.' ';
		}

		if(!isN($_us) && $__t2 == 'gst'){
			$__fl .= ' AND mdlcnthis_us IN ('.$_us.') ';
		}elseif( !isN($_us) ){
			$__fl .= ' AND mdlcnt_us IN ('.$_us.') ';
		}

		$CntWb .= "
					$('._row_clk').off('click').click(function(){

						var id = $(this).attr('rel');

						if( id == '_all' ){
							var _all = '&___all=ok';	
						}else{
							var _all = '';
						}

						var flt = $('#_inf_fm').serialize();

						_ldCnt({ 
							u:'".Fl_Rnd(FL_LS_GN.__t('mdl_cnt_inf', true)).TXGN_POP.TXGN_BX.$___Ls->bx_rld.ADM_LNK_SB."'+id+'&___tp=".$__t2."&'+flt+'&_tp=".$_tp."'+_all, 
							w:'98%',
							h:'98%',
							pop:'ok',
							pnl:{
								e:'ok',
								tp:'h',
								s:'l'
							}
						});
					});
				";
		
		
		//Leads por medio
		if($__t2 == "md"){
			
			if( $_ftp != "f_his" ){
			
				if(!isN($_f1) && !isN($_f2)){ 
					$__fl .= ' AND DATE_FORMAT(mdlcnt_fi, "%Y-%m-%d") BETWEEN "'.$_f1.'" AND "'.$_f2.'" ';
				}elseif(!isN($_f1)){
					$__fl .= ' AND DATE_FORMAT(mdlcnt_fi, "%Y-%m-%d")  =  "'.$_f1.'" ';
				}elseif(!isN($_f2)){
					$__fl .= ' AND DATE_FORMAT(mdlcnt_fi, "%Y-%m-%d") = "'.$_f2.'" ';
				}
			
			}
			
			$Ls_Cnt_Qry = " 
							SELECT id_sismd, sismd_tt, 
					  		COUNT(*) AS __tot_m 
							FROM ".TB_MDL_CNT."
								 INNER JOIN ".TB_MDL." ON mdlcnt_mdl = id_mdl 
								 INNER JOIN "._BdStr(DBM).TB_MDL_S." ON mdl_mdls = id_mdls
								 INNER JOIN "._BdStr(DBM).TB_MDL_S_TP." ON mdls_tp = id_mdlstp
								 INNER JOIN ".TB_CNT." ON mdlcnt_cnt = id_cnt
								 INNER JOIN "._BdStr(DBM).TB_SIS_MD." ON mdlcnt_m = id_sismd
							WHERE id_mdlcnt != '' $__fl
							AND mdl_est != '"._CId('ID_SISMDLEST_ELI')."'
							GROUP BY mdlcnt_m
							ORDER BY id_mdlcnt DESC, mdlcnt_fa DESC
						"; 

			$Ls_Cnt_Rg = $__cnx->_qry($Ls_Cnt_Qry);
			
			if($Ls_Cnt_Rg){ 

				$row_Ls_Cnt_Rg = $Ls_Cnt_Rg->fetch_assoc(); 
				$Tot_Ls_Cnt_Rg = $Ls_Cnt_Rg->num_rows; 

				if($Tot_Ls_Cnt_Rg > 0){
					
					$_tot = 0;
					
					do {
						$Vl['ls'][$row_Ls_Cnt_Rg['id_sismd']]['id'] = ctjTx($row_Ls_Cnt_Rg['id_sismd'], 'in');
						$Vl['ls'][$row_Ls_Cnt_Rg['id_sismd']]['nm'] = ctjTx($row_Ls_Cnt_Rg['sismd_tt'], 'in');
						$Vl['ls'][$row_Ls_Cnt_Rg['id_sismd']]['tot'] = $row_Ls_Cnt_Rg['__tot_m'];
						
						if($row_Ls_Cnt_Rg['__tot_m'] < 1){ $_prnt = 0; }else{ $_prnt = $row_Ls_Cnt_Rg['__tot_m']; }
						$_tot = ($_tot+$_prnt);
						
						$_medio[] = "{ name:'".ctjTx(str_replace("'", "", $row_Ls_Cnt_Rg['sismd_tt']),'in')."', data:[". number_format($_prnt, 2, '.', '') ."] } "; 
						$_tabla .= '<tr><td>'.ctjTx($row_Ls_Cnt_Rg['sismd_tt'], 'in').'</td><td>'. number_format($_prnt, 2, '.', '') .'</td></tr>';  
						                    
					} while ($row_Ls_Cnt_Rg = $Ls_Cnt_Rg->fetch_assoc());
					
					$Vl_Grph = _jEnc($Vl);
				}
			}
			$_grph_tag = implode(",", $_medio);
			
			$CntWb .= "
				SUMR_Grph.f.g1({ 
					id: '#_grph1',
					d: [".$_grph_tag."],
					tt: 'Leads', 
					tt_sb: 'Leads por medio',
					c_e: false
				});
			";
			
			?>
				<div class="__grph <?php echo $_f ?>">
					<?php echo h2('Leads por medio'); ?>
					<div class="_grph_inf" >
					    <div id="_grph1" class="_grph1"></div>
					</div>
					
					<table width="100%" border="0" cellpadding="0" cellspacing="0" class="Ls_Rg _grph_tb"> 
				    	<tr>
					    	<th nowrap="nowrap" class="_sb" width="70%"><?php echo TX_MDL ?></th>
				    	    <th nowrap="nowrap" width="30%"><?php echo TX_CNT ?></th>
					    </tr>
					    <?php 
						    $_i_nm = 1;
						    foreach($Vl_Grph->ls as $_k => $_v){
							    echo "
							    	<tr rel='".$_v->id."' class='_row_clk Rw_".$_i_nm."'>
							    		<td nowrap='nowrap' class='_sb' width='30%'>".$_v->nm."</td>
								    	<td nowrap='nowrap' width='70%'>".$_v->tot."</td>
									</tr>
							    ";
							    if($_i_nm == 1){ $_i_nm = 2; }else{ $_i_nm = 1; }
						    }
						    echo "
						    		<tr rel='_all' class='_row_clk Rw_".$_i_nm."'>
							    		<td nowrap='nowrap' class='_sb' width='30%'>Total</td>
								    	<td nowrap='nowrap' width='70%'>".$_tot."</td>
									</tr>
								";
					    ?>
					</table>
				</div>
			<?php


		//Leads por usuarios
		}elseif($__t2 == "us"){
			
			if( $_ftp != "f_his" ){
			
				if(!isN($_f1) && !isN($_f2)){ 
					$__fl .= ' AND DATE_FORMAT(mdlcnt_fi, "%Y-%m-%d") BETWEEN "'.$_f1.'" AND "'.$_f2.'" ';
				}elseif(!isN($_f1)){
					$__fl .= ' AND DATE_FORMAT(mdlcnt_fi, "%Y-%m-%d")  =  "'.$_f1.'" ';
				}elseif(!isN($_f2)){
					$__fl .= ' AND DATE_FORMAT(mdlcnt_fi, "%Y-%m-%d") = "'.$_f2.'" ';
				}
			
			}
			
			$Ls_Cnt_Qry = " 
							SELECT id_us, us_nm, us_ap,
					  		COUNT(*) AS __tot_m 
							FROM ".TB_MDL_CNT."
								 INNER JOIN ".TB_MDL." ON mdlcnt_mdl = id_mdl 
								 INNER JOIN "._BdStr(DBM).TB_MDL_S." ON mdl_mdls = id_mdls
								 INNER JOIN "._BdStr(DBM).TB_MDL_S_TP." ON mdls_tp = id_mdlstp
								 INNER JOIN "._BdStr(DBM).TB_US." ON mdlcnt_us = id_us
							WHERE id_mdlcnt != '' $__fl
							AND mdl_est != '"._CId('ID_SISMDLEST_ELI')."'
							GROUP BY us_nm
							ORDER BY __tot_m DESC
						";
				
			$Ls_Cnt_Rg = $__cnx->_qry($Ls_Cnt_Qry);
			
			if($Ls_Cnt_Rg){ 
				$row_Ls_Cnt_Rg = $Ls_Cnt_Rg->fetch_assoc(); 
				$Tot_Ls_Cnt_Rg = $Ls_Cnt_Rg->num_rows; 
				if($Tot_Ls_Cnt_Rg > 0){
					
					$_tot = 0;
					
					do {
						
						$Vl['ls'][$row_Ls_Cnt_Rg['id_us']]['nm'] = ctjTx($row_Ls_Cnt_Rg['us_nm'].' '.$row_Ls_Cnt_Rg['us_ap'], 'in');
						$Vl['ls'][$row_Ls_Cnt_Rg['id_us']]['tot'] = $row_Ls_Cnt_Rg['__tot_m'];
						
						if($row_Ls_Cnt_Rg['__tot_m'] < 1){ $_prnt = 0; }else{ $_prnt = $row_Ls_Cnt_Rg['__tot_m']; }
						$_tot = ($_tot+$_prnt);
						
						$_medio[] = "{ name:'".ctjTx(str_replace("'", "", $row_Ls_Cnt_Rg['us_nm'].' '.$row_Ls_Cnt_Rg['us_ap']),'in')."', data:[". number_format($_prnt, 2, '.', '') ."] } "; 
						$_tabla .= '<tr><td>'.ctjTx($row_Ls_Cnt_Rg['us_nm'], 'in').'</td><td>'. number_format($_prnt, 2, '.', '') .'</td></tr>';  
						                    
					} while ($row_Ls_Cnt_Rg = $Ls_Cnt_Rg->fetch_assoc());
					
					$Vl_Grph = _jEnc($Vl);
				}
			}
			$_grph_tag = implode(",", $_medio);
			
			$CntWb .= "
				SUMR_Grph.f.g1({ 
					id: '#_grph1',
					d: [".$_grph_tag."],
					tt: 'Leads', 
					tt_sb: 'Leads por usuario',
					c_e: false
				});
			";
			
			?>
				<div class="__grph <?php echo $_f ?>">
					<?php echo h2('Leads por usuario'); ?>
					<div class="_grph_inf" >
					    <div id="_grph1" class="_grph1"></div>
					</div>
					
					<table width="100%" border="0" cellpadding="0" cellspacing="0" class="Ls_Rg _grph_tb"> 
				    	<tr>
					    	<th nowrap="nowrap" class="_sb" width="70%"><?php echo TX_MDL ?></th>
				    	    <th nowrap="nowrap" width="30%"><?php echo TX_CNT ?></th>
					    </tr>
					    <?php 
						    $_i_nm = 1;
						    foreach($Vl_Grph->ls as $_k => $_v){
							    echo "
							    	<tr class='Rw_".$_i_nm."'>
							    		<td nowrap='nowrap' class='_sb' width='30%'>".$_v->nm."</td>
								    	<td nowrap='nowrap' width='70%'>".$_v->tot."</td>
									</tr>
							    ";
							    if($_i_nm == 1){ $_i_nm = 2; }else{ $_i_nm = 1; }
						    }
						    echo "
						    		<tr class='Rw_".$_i_nm."'>
							    		<td nowrap='nowrap' class='_sb' width='30%'>Total</td>
								    	<td nowrap='nowrap' width='70%'>".$_tot."</td>
									</tr>
								";
					    ?>
					</table>
				</div>
			<?php
		
		//Leads por medios - fechas
		}elseif($__t2 == "md_f"){
			
			if( $_ftp != "f_his" ){
			
				$__dt_1 = !isN($_f1) ? $_f1 : date('Y-m-01');
				$__dt_2 = !isN($_f2) ? $_f2 : date('Y-m-d');
				
				if(!isN($_f1) && !isN($_f2)){
					$__fl .= ' AND DATE_FORMAT(mdlcnt_fi, "%Y-%m-%d") BETWEEN "'.$__dt_1.'" AND "'.$__dt_2.'" ';
				}
			}
			
			$Ls_Cnt_Qry = " 
							SELECT *, DATE_FORMAT(mdlcnt_fi, '%Y-%m-%d') as _f_i
							FROM ".TB_MDL_CNT."
								 INNER JOIN ".TB_MDL." ON mdlcnt_mdl = id_mdl 
								 INNER JOIN "._BdStr(DBM).TB_MDL_S." ON mdl_mdls = id_mdls
								 INNER JOIN "._BdStr(DBM).TB_MDL_S_TP." ON mdls_tp = id_mdlstp
								 INNER JOIN ".TB_CNT." ON mdlcnt_cnt = id_cnt
								 INNER JOIN "._BdStr(DBM).TB_SIS_MD." ON mdlcnt_m = id_sismd
							WHERE id_mdlcnt != '' ".$__fl."
							AND mdl_est != '"._CId('ID_SISMDLEST_ELI')."'
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
						
						$Vl['d'][$row_Ls_Cnt_Rg['id_sismd']]['nm'] = ctjTx($row_Ls_Cnt_Rg['sismd_tt'], 'in');
						$Vl['d'][$row_Ls_Cnt_Rg['id_sismd']]['f'][$row_Ls_Cnt_Rg['_f_i']]['tot']++;
						
						$Vl['ls'][$row_Ls_Cnt_Rg['_f_i']][$row_Ls_Cnt_Rg['id_sismd']]['nm'] = ctjTx($row_Ls_Cnt_Rg['sismd_tt'], 'in');
						$Vl['ls'][$row_Ls_Cnt_Rg['_f_i']][$row_Ls_Cnt_Rg['id_sismd']]['tot']++;
						
					} while ($row_Ls_Cnt_Rg = $Ls_Cnt_Rg->fetch_assoc());
					$Vl_Grph = _jEnc($Vl);
				}
			}
			
			for($i=$__dt_1;$i<=$__dt_2;$i = date("Y-m-d", strtotime($i ."+ 1 days"))){ 
				
				$__ctg[] = '"'.$i.'"';
				
				foreach($Vl_Grph->d as $_k => $_v){
					$_d[$_k]['nm'] = $_v->nm;
					$_d[$_k]['tot'][] = ( !isN($_v->f->{$i}->tot) ) ? $_v->f->{$i}->tot : 0 ;
				}
				
			}
			
			//Construye los datos
			foreach(_jEnc($_d) as $_k_d => $_v_d){
				$_medio[] = "{ name:'".$_v_d->nm."', data:[".implode(',', $_v_d->tot)."] } ";
			}
			
			$_grph_d = implode(",", $_medio);
			$_grph_c = implode(",", $__ctg);
			
			$CntWb .= "
				SUMR_Grph.f.g4({ 
					id: '#_grph1',
					c: [".$_grph_c."],
					d: [".$_grph_d."],
					tt: 'Leads', 
					tt_sb: 'Leads por medios - Fechas',
					c_e: false
				});
			";
			
			?>
				<div class="__grph <?php echo $_f ?>">
					<?php echo h2('Leads por medios - Fechas'); ?>
					<div class="_grph_inf" >
					    <div id="_grph1" class="_grph1"></div>
					</div>
					
					<table width="100%" border="0" cellpadding="0" cellspacing="0" id="_grph_tb" class="Ls_Rg _grph_tb">
				    	<tr>
					    	<th nowrap="nowrap" width="70%"><?php echo TX_MD ?></th>
					    	<?php
						    	$i_n = 1;
						    	foreach($__ctg as $_k_c => $_v_c){
							    	echo '<th nowrap="nowrap" class="'.(($i_n%2==0)? "" : "_sb" ).'" width="70%">'.str_replace('"', "", $_v_c).'</th>';
							    	$i_n++;
						    	}
					    	?>
					    	<th nowrap="nowrap" width="70%">Total</th> <!-- Total derecha -> -->
					    </tr>
					    <?php
						    $_i_nm = 1;
						    foreach($Vl_Grph->d as $_k => $_v){
							    
							    $_td = NULL; $_tot_all = 0;
							    foreach($__ctg as $_k_c => $_v_c){
								    $_tot = $Vl_Grph->ls->{str_replace('"', "", $_v_c)}->{$_k}->tot;
								    if( isN($_tot) ){ $_tot = 0; }
								    $_td .= " <td nowrap='nowrap' width='70%'>".$_tot."</td> ";
								    
								    $_tot_all = ($_tot_all+$_tot);
								    $_tot_all_td[$_v_c][] = $_tot;
								    $_tot_all_sum = ($_tot_all_sum+$_tot);
								    
							    }
							    
							    $_td .= " <td nowrap='nowrap' width='70%'>$_tot_all</td> "; /* Total derecha -> */
							    
							    echo "
							    	<tr class='Rw_".$_i_nm."'>
							    		<td nowrap='nowrap' width='70%'>".$_v->nm."</td>
							    		".$_td."
									</tr>
							    ";
							    if($_i_nm == 1){ $_i_nm = 2; }else{ $_i_nm = 1; }
							    
						    }
						    
						    /* Total abajo  */
						    foreach($_tot_all_td as $_k_tot => $_v_tot){
							   $_new_sum = 0;
							   foreach($_v_tot as $_v_tot_sum){
								   $_new_sum = ($_new_sum+$_v_tot_sum);
							   }
							   $_td_tot .= "<td nowrap='nowrap' width='70%'>$_new_sum</td>";
						    }
						    
						    echo "
						    		<tr class='Rw_".$_i_nm."'>
							    		<td nowrap='nowrap' class='_sb' width='30%'>Total</td>
								    	$_td_tot
								    	<td nowrap='nowrap' width='70%'>$_tot_all_sum</td>
									</tr>
								";
							/* Total abajo */
							
					    ?>
					</table>
				</div>
			<?php
			
		//Etapas
		}elseif($__t2 == "etp"){
			
			if( $_ftp != "f_his" ){
				
				if(!isN($_f1) && !isN($_f2)){ 
					$__fl .= ' AND DATE_FORMAT(mdlcnt_fi, "%Y-%m-%d") BETWEEN "'.$_f1.'" AND "'.$_f2.'" ';  
				}elseif(!isN($_f1)){
					$__fl .= ' AND DATE_FORMAT(mdlcnt_fi, "%Y-%m-%d")  = "'.$_f1.'" ';
				}elseif(!isN($_f2)){
					$__fl .= ' AND DATE_FORMAT(mdlcnt_fi, "%Y-%m-%d")  = "'.$_f2.'" ';
				}
			}
				
			/* Graficas - Etapas */
			$Ls_Cnt_Qry = "
							SELECT siscntesttp_enc, siscntesttp_tt, siscntesttp_clr_bck, id_siscntesttp,
					  		COUNT(*) AS __tot_mdl 
							FROM ".TB_MDL_CNT."
								 INNER JOIN ".TB_MDL." ON mdlcnt_mdl = id_mdl
								 INNER JOIN "._BdStr(DBM).TB_MDL_S." ON mdl_mdls = id_mdls
								 INNER JOIN "._BdStr(DBM).TB_MDL_S_TP." ON mdls_tp = id_mdlstp
								 INNER JOIN "._BdStr(DBM).TB_SIS_CNT_EST." ON mdlcnt_est = id_siscntest
								 INNER JOIN "._BdStr(DBM).TB_SIS_CNT_EST_TP." ON siscntest_tp = id_siscntesttp
								 INNER JOIN ".TB_CNT." ON mdlcnt_cnt = id_cnt 
							WHERE id_mdlcnt != '' $__fl
							AND mdl_est != '"._CId('ID_SISMDLEST_ELI')."'
							GROUP BY siscntest_tp 
							ORDER BY siscntesttp_ord ASC
						"; 
						
			$Ls_Cnt_Rg = $__cnx->_qry($Ls_Cnt_Qry);
			
			if($Ls_Cnt_Rg){ 
				$row_Ls_Cnt_Rg = $Ls_Cnt_Rg->fetch_assoc(); 
				$Tot_Ls_Cnt_Rg = $Ls_Cnt_Rg->num_rows; 
				if($Tot_Ls_Cnt_Rg > 0){
					do {
						$Vl['ls'][$row_Ls_Cnt_Rg['id_siscntesttp']]['id'] = ctjTx($row_Ls_Cnt_Rg['id_siscntesttp'], 'in');
						$Vl['ls'][$row_Ls_Cnt_Rg['id_siscntesttp']]['nm'] = ctjTx($row_Ls_Cnt_Rg['siscntesttp_tt'], 'in');
						$Vl['ls'][$row_Ls_Cnt_Rg['id_siscntesttp']]['tot'] = ctjTx($row_Ls_Cnt_Rg['__tot_mdl'], 'in');
						$Vl['ls'][$row_Ls_Cnt_Rg['id_siscntesttp']]['enc'] = ctjTx($row_Ls_Cnt_Rg['siscntesttp_enc'], 'in');
						
						if($row_Ls_Cnt_Rg['__tot_mdl'] < 1){ $_prnt = 0; }else{ $_prnt = $row_Ls_Cnt_Rg['__tot_mdl']; }
						if( !isN($row_Ls_Cnt_Rg['siscntesttp_clr_bck']) ){ $_clr = $row_Ls_Cnt_Rg['siscntesttp_clr_bck']; }
						
						$_tot[] = $_prnt;
						
						$__grph_est[] = "{ name:'".ctjTx($row_Ls_Cnt_Rg['siscntesttp_tt'], 'in')."', y_lbl:".$_prnt.", y:1, color:'".$row_Ls_Cnt_Rg['siscntesttp_clr_bck']."', className:'".$__cls."', est_tp:'".$row_Ls_Cnt_Rg['siscntesttp_enc']."', enc:'".$row_Ls_Cnt_Rg['siscntesttp_enc']."' }";
						             
					} while ($row_Ls_Cnt_Rg = $Ls_Cnt_Rg->fetch_assoc());
					$Vl_Grph = _jEnc($Vl);
				}
			}
			
			$_sum_tot = 0;
			foreach($_tot as $_v_tot){
				$_sum_tot = ($_sum_tot+$_v_tot);
			}
			/* Graficas etapas */
			
			/* Graficas estados */
			
			$Ls_Cnt_Qry_Est = " 
							SELECT siscntest_tt , siscntest_clr_bck, id_siscntest, siscntesttp_enc, siscntest_enc, siscntesttp_tt, siscntesttp_clr_bck,
					  		COUNT(*) AS __tot_mdl 
							FROM ".TB_MDL_CNT."
								 INNER JOIN ".TB_MDL." ON mdlcnt_mdl = id_mdl 
								 INNER JOIN "._BdStr(DBM).TB_MDL_S." ON mdl_mdls = id_mdls
								 INNER JOIN "._BdStr(DBM).TB_MDL_S_TP." ON mdls_tp = id_mdlstp
								 INNER JOIN "._BdStr(DBM).TB_SIS_CNT_EST." ON mdlcnt_est = id_siscntest
								 INNER JOIN "._BdStr(DBM).TB_SIS_CNT_EST_TP." ON id_siscntesttp = siscntest_tp
								 INNER JOIN ".TB_CNT." ON mdlcnt_cnt = id_cnt 
							WHERE id_mdlcnt != '' $__fl
							AND mdl_est != '"._CId('ID_SISMDLEST_ELI')."'
							GROUP BY id_siscntest 
							ORDER BY id_mdlcnt DESC, mdlcnt_fa DESC
						";
			$Ls_Cnt_Rg_Est = $__cnx->_qry($Ls_Cnt_Qry_Est);				
			
			if($Ls_Cnt_Rg_Est){ 
				$row_Ls_Cnt_Rg_Est = $Ls_Cnt_Rg_Est->fetch_assoc(); 
				$Tot_Ls_Cnt_Rg_Est = $Ls_Cnt_Rg_Est->num_rows; 
				if($Tot_Ls_Cnt_Rg_Est > 0){
					
					do {
						
						if($row_Ls_Cnt_Rg_est['__tot_mdl'] < 1){ $_prnt_est = 0; }else{ $_prnt_est = $row_Ls_Cnt_Rg_est['__tot_mdl']; }
						if( !isN($row_Ls_Cnt_Rg_est['siscntest_clr_bck']) ){ $_clr_est = $row_Ls_Cnt_Rg_est['siscntest_clr_bck']; }
						
						if( !isN($row_Ls_Cnt_Rg_est['siscntesttp_enc']) ){
							
							//Detalle del sis_cnt_est_tp
							$Vl_Est['pie'][$row_Ls_Cnt_Rg_est['siscntesttp_enc']]['dt']['tt'] = ctjTx($row_Ls_Cnt_Rg_est['siscntesttp_tt'], 'in');
							$Vl_Est['pie'][$row_Ls_Cnt_Rg_est['siscntesttp_enc']]['dt']['clr'] = ctjTx($row_Ls_Cnt_Rg_est['siscntesttp_clr_bck'], 'in');
							
							//Datos que construyen el pie
							$Vl_Est['pie'][$row_Ls_Cnt_Rg_est['siscntesttp_enc']]['ls'][] = "{ name:'".ctjTx($row_Ls_Cnt_Rg_est['siscntest_tt'], 'in')."', y:".$_prnt_est.", color:'".$row_Ls_Cnt_Rg_est['siscntest_clr_bck']."' }";
						}
						         
					} while ($row_Ls_Cnt_Rg_est = $Ls_Cnt_Rg_Est->fetch_assoc());
					$Vl_Grph_Est = _jEnc($Vl_Est);
				}
			}
			
			$CntWb .= "
				var _pie = [];
			";
			
			foreach($Vl_Grph_Est->pie as $__k => $__v){
				$_grph_tag = "";
				$_grph_tag = implode(",", $__v->ls);
				$CntWb .= "
					_pie['$__k'] = [];
					_pie['$__k']['est'] = [".$_grph_tag."];
					_pie['$__k']['dt'] = ".json_encode($__v->dt).";
				";
			}
			
			/* Graficas estados */
			
			$CntWb .= "
			
				function _shw_pie(p=null){
					console.log(_pie[p.est_tp]);
					SUMR_Grph.f.g2({ 
						id: '#_grph2 > ._bdy',
						d: _pie[p.est_tp].est,
						tt: ' ', 
						tt_sb: '  ',
						c_e: false,
						lbl: false,
						tlt_frmt: '{series.name}: <b> Total: {point.y} - Porcentaje: {point.percentage:.1f}% </b>'
					});
				}
				
				function _shw_fnl(p=null){
					setTimeout(function(){
						_chrt = new Highcharts.chart('_grph1', {
						    chart: {  type: 'funnel' },
						    title:{ text: 'Total: ".$_sum_tot."' },
						    plotOptions: {
							    funnel: {
						            borderWidth: 4
						        },
						        series: {
						            dataLabels: {
						                enabled: true,
						                softConnector: true,
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
						            width: '60%',
						            height: '70%',
						            point: {
							            events: {
							                click: function(e) {
								                $('._grph_inf').addClass('_pie');
								                var _img_url = 'https://fle.sumr.co/sis/cnt_est_tp/'+this.enc+'.svg';
								                $('._grph_inf ._grph2 ._hd').html(this.name).css({ 'background-color': this.color, 'background-image':'url(\"'+_img_url+'\")' });
								                _shw_pie({ est_tp: this.est_tp });
							                    _shw_fnl();
							                }
							            }
							        },
							        cursor: 'pointer'
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
				}
				
				_shw_fnl();
				
				$('.btn_pnl').off('click').click(function(){
					$('._grph_inf').removeClass('_pie');
					_shw_fnl();
				});
				
				$('.__grph ._etp').off('click').click(function(){
					var _enc = $(this).attr('rel');
					$('._grph_inf').addClass('_pie');
					var _img_url = 'https://fle.sumr.co/sis/cnt_est_tp/'+_enc+'.svg';
	                $('._grph_inf ._grph2 ._hd').html(_pie[_enc].dt.tt).css({ 'background-color': _pie[_enc].dt.clr, 'background-image':'url(\"'+_img_url+'\")' });
	                _shw_pie({ est_tp: $(this).attr('rel') });
                    _shw_fnl();
				});
				
			";
			
			?>
				<div class="__grph <?php echo $_f ?>">
					<?php echo h2('Leads por etapas'); ?>
					<div class="_grph_inf">
						<div id="_grph1" class="_grph1 _anm"></div>
					    <div id="_grph2" class="_grph2 _anm">
						    <div class="_hd"></div>
						    <div class="_bdy"></div>
					    </div>
					</div>
					
					<table width="100%" border="0" cellpadding="0" cellspacing="0" class="Ls_Rg _grph_tb"> 
				    	<tr>
					    	<th nowrap="nowrap" class="_sb" width="50%"><?php echo TX_ETP ?></th>
				    	    <th nowrap="nowrap" width="50%"><?php echo TX_CNT ?></th>
					    </tr>
					    <?php 
						    $_i_nm = 1;
						    foreach($Vl_Grph->ls as $_k => $_v){
							    echo "
							    	<tr rel='".$_v->id."' class='_row_clk Rw_".$_i_nm."'>
							    		<td nowrap='nowrap' rel='".$_v->enc."' class='_sb _etp' width='50%'>".$_v->nm."</td>
								    	<td nowrap='nowrap' rel='".$_v->enc."' class='_etp' width='50%'>".$_v->tot."</td>
									</tr>
							    ";
							    if($_i_nm == 1){ $_i_nm = 2; }else{ $_i_nm = 1; }
						    }
					    ?>
					</table>
				</div>
				
				<style>
					
					.__grph ._grph_inf{ height: 400px!important; display: flex!important; }
					
					.__grph ._grph_inf > div{ display: inline-block!important; border: 1px solid #a7a7a7; height: 100%; }
					
					.__grph ._grph_inf > #_grph1{ width: 99.5%; }
					
					.__grph ._grph_inf > #_grph2{ display: 0%; border: 0; }
					
					.__grph ._grph_inf._pie > #_grph1{ width: 30%!important; }
					.__grph ._grph_inf._pie > #_grph2{ width: 69.5%!important; border: 1px solid #a7a7a7; }
					.__grph ._grph_inf._pie > #_grph2 ._hd{ display: block!important; font-family: Economica; font-size: 20px; height: 8%; color: white; background-repeat: no-repeat; background-position: 65%; background-size: 25px; }
					.__grph ._grph_inf._pie > #_grph2 ._bdy{ display: block!important; height: 91.5%; }
					
					.__grph .fnl-on{ animation: _blnk 0.8s cubic-bezier(.5, 0, 1, 1) infinite alternate; opacity: 1; }
					
				</style>
				
			<?php
			
		//Leads por estado
		}elseif($__t2 == "est"){
			
			if( $_ftp != "f_his" ){
				
				if(!isN($_f1) && !isN($_f2)){ 
					$__fl .= ' AND DATE_FORMAT( mdlcnt_fi, "%Y-%m-%d" ) BETWEEN "'.$_f1.'" AND "'.$_f2.'" ';  
				}elseif(!isN($_f1)){
					$__fl .= ' AND DATE_FORMAT( mdlcnt_fi, "%Y-%m-%d" ) = "'.$_f1.'" ';
				}elseif(!isN($_f2)){
					$__fl .= ' AND DATE_FORMAT( mdlcnt_fi, "%Y-%m-%d" ) = "'.$_f2.'" ';
				}
			
			}
			$Ls_Cnt_Qry = " 
							SELECT siscntest_tt , siscntest_clr_bck, id_siscntest,
					  		COUNT(*) AS __tot_mdl 
							FROM ".TB_MDL_CNT."
								 INNER JOIN ".TB_MDL." ON mdlcnt_mdl = id_mdl 
								 INNER JOIN "._BdStr(DBM).TB_MDL_S." ON mdl_mdls = id_mdls
								 INNER JOIN "._BdStr(DBM).TB_MDL_S_TP." ON mdls_tp = id_mdlstp
								 INNER JOIN "._BdStr(DBM).TB_SIS_CNT_EST." ON mdlcnt_est = id_siscntest
								 INNER JOIN ".TB_CNT." ON mdlcnt_cnt = id_cnt 
							WHERE id_mdlcnt != ''  $__fl
							AND mdl_est != '"._CId('ID_SISMDLEST_ELI')."'
							GROUP BY id_siscntest 
							ORDER BY id_mdlcnt DESC, mdlcnt_fa DESC
						";
						
			$Ls_Cnt_Rg = $__cnx->_qry($Ls_Cnt_Qry);
			
			if($Ls_Cnt_Rg){ 
				$row_Ls_Cnt_Rg = $Ls_Cnt_Rg->fetch_assoc(); 
				$Tot_Ls_Cnt_Rg = $Ls_Cnt_Rg->num_rows; 
				if($Tot_Ls_Cnt_Rg > 0){
					
					$_tot = 0;
					do {
						
						$Vl['ls'][$row_Ls_Cnt_Rg['id_siscntest']]['id'] = ctjTx($row_Ls_Cnt_Rg['id_siscntest'], 'in');
						$Vl['ls'][$row_Ls_Cnt_Rg['id_siscntest']]['nm'] = ctjTx($row_Ls_Cnt_Rg['siscntest_tt'], 'in');
						$Vl['ls'][$row_Ls_Cnt_Rg['id_siscntest']]['tot'] = ctjTx($row_Ls_Cnt_Rg['__tot_mdl'], 'in');
						
						if($row_Ls_Cnt_Rg['__tot_mdl'] < 1){ $_prnt = 0; }else{ $_prnt = $row_Ls_Cnt_Rg['__tot_mdl']; }
						$_tot = ($_tot+$_prnt);
						if( !isN($row_Ls_Cnt_Rg['siscntest_clr_bck']) ){ $_clr = $row_Ls_Cnt_Rg['siscntest_clr_bck']; }
						
						$_medio[] = "{ name:'".ctjTx(str_replace("'", "", $row_Ls_Cnt_Rg['siscntest_tt']),'in')."', data:[". number_format($_prnt, 2, '.', '') ."], color:'".$_clr."' } "; 
						$_tabla .= '<tr><td>'.ctjTx($row_Ls_Cnt_Rg['id_siscntest'], 'in').'</td><td>'. number_format($_prnt, 2, '.', '') .'</td></tr>';
						                    
					} while ($row_Ls_Cnt_Rg = $Ls_Cnt_Rg->fetch_assoc());
					$Vl_Grph = _jEnc($Vl);
				}
			}
			$_grph_tag = implode(",", $_medio);
			
			$CntWb .= "
				SUMR_Grph.f.g1({ 
					id: '#_grph1',
					d: [".$_grph_tag."],
					tt: 'Leads', 
					tt_sb: 'Leads por estados',
					c_e: false
				});
			";
			
			?>
				<div class="__grph <?php echo $_f ?>">
					<?php echo h2('Leads por estados'); ?>
					<div class="_grph_inf" >
					    <div id="_grph1" class="_grph1"></div>
					</div>
					
					<table width="100%" border="0" cellpadding="0" cellspacing="0" class="Ls_Rg _grph_tb"> 
				    	<tr>
				    	    <th nowrap="nowrap" width="70%"><?php echo TX_CNT ?></th>
				            <th nowrap="nowrap" class="_sb" width="30%"><?php echo TX_ETP ?></th>
					    </tr>
					    <?php 
						    $_i_nm = 1;
						    foreach($Vl_Grph->ls as $_k => $_v){
							    echo "
							    	<tr rel='".$_v->id."' class='_row_clk Rw_".$_i_nm."'>
								    	<td nowrap='nowrap' width='70%'>".$_v->tot."</td>
										<td nowrap='nowrap' class='_sb' width='30%'>".$_v->nm."</td>
									</tr>
							    ";
							    if($_i_nm == 1){ $_i_nm = 2; }else{ $_i_nm = 1; }
						    }
						    echo "
						    		<tr rel='_all' class='_row_clk Rw_".$_i_nm."'>
							    		<td nowrap='nowrap' class='_sb' width='30%'>Total</td>
								    	<td nowrap='nowrap' width='70%'>".$_tot."</td>
									</tr>
								";
					    ?>
					</table>
				</div>
			<?php
			
		//Leads por modulos
		}elseif($__t2 == "mdl"){
			
			if( $_ftp != "f_his" ){
			
				$__dt_1 = !isN($_f1) ? $_f1 : date('Y-m-01');
				$__dt_2 = !isN($_f2) ? $_f2 : date('Y-m-d');
			
				if(!isN($_f1) && !isN($_f2)){
					$__fl .= ' AND DATE_FORMAT(mdlcnt_fi, "%Y-%m-%d") BETWEEN "'.$__dt_1.'" AND "'.$__dt_2.'" ';
				}
			}
			
			
			
			$Ls_Cnt_Qry = " 
							SELECT id_mdl, mdl_nm, DATE_FORMAT(mdlcnt_fi, '%Y-%m-%d') as _f_i
							FROM ".TB_MDL_CNT."
								 INNER JOIN ".TB_MDL." ON mdlcnt_mdl = id_mdl 
								 INNER JOIN "._BdStr(DBM).TB_MDL_S." ON mdl_mdls = id_mdls
								 INNER JOIN "._BdStr(DBM).TB_MDL_S_TP." ON mdls_tp = id_mdlstp
								 INNER JOIN "._BdStr(DBM).TB_SIS_CNT_EST." ON mdlcnt_est = id_siscntest
								 INNER JOIN "._BdStr(DBM).TB_SIS_CNT_EST_TP." ON siscntest_tp = id_siscntesttp
								 INNER JOIN ".TB_CNT." ON mdlcnt_cnt = id_cnt 
								 INNER JOIN "._BdStr(DBM).TB_SIS_MD." ON mdlcnt_m = id_sismd
								 RIGHT JOIN "._BdStr(DBM).TB_SIS_FNT." ON mdlcnt_fnt = id_sisfnt
							WHERE id_mdlcnt != '' $__fl
							AND mdl_est != '"._CId('ID_SISMDLEST_ELI')."'
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
						
						$Vl['d'][$row_Ls_Cnt_Rg['id_mdl']]['nm'] = ctjTx($row_Ls_Cnt_Rg['mdl_nm'], 'in');
						$Vl['d'][$row_Ls_Cnt_Rg['id_mdl']]['f'][$row_Ls_Cnt_Rg['_f_i']]['tot']++;
						
						$Vl['ls'][$row_Ls_Cnt_Rg['_f_i']][$row_Ls_Cnt_Rg['id_mdl']]['nm'] = ctjTx($row_Ls_Cnt_Rg['mdl_nm'], 'in');
						$Vl['ls'][$row_Ls_Cnt_Rg['_f_i']][$row_Ls_Cnt_Rg['id_mdl']]['tot']++;
						
					} while ($row_Ls_Cnt_Rg = $Ls_Cnt_Rg->fetch_assoc());
					$Vl_Grph = _jEnc($Vl);
				}
			}
			
			for($i=$__dt_1;$i<=$__dt_2;$i = date("Y-m-d", strtotime($i ."+ 1 days"))){ 
				
				$__ctg[] = '"'.$i.'"';
				
				foreach($Vl_Grph->d as $_k => $_v){
					$_d[$_k]['nm'] = $_v->nm;
					$_d[$_k]['tot'][] = ( !isN($_v->f->{$i}->tot) ) ? $_v->f->{$i}->tot : 0 ;
				}
				
			}
			
			//Construye los datos
			foreach(_jEnc($_d) as $_k_d => $_v_d){
				$_medio[] = "{ name:'".$_v_d->nm."', data:[".implode(',', $_v_d->tot)."] } ";
			}
			
			$_grph_d = implode(",", $_medio);
			$_grph_c = implode(",", $__ctg);
			
			$CntWb .= "
				SUMR_Grph.f.g4({ 
					id: '#_grph1',
					c: [".$_grph_c."],
					d: [".$_grph_d."],
					tt: 'Leads', 
					tt_sb: 'Leads por Modulos',
					c_e: false
				});
			";
			
			?>
				<div class="__grph <?php echo $_f ?>">
					<?php echo h2('Leads por modulos'); ?>
					<div class="_grph_inf" >
					    <div id="_grph1" class="_grph1"></div>
					</div>
					
					<table width="100%" border="0" cellpadding="0" cellspacing="0" class="Ls_Rg _grph_tb">
				    	<tr>
					    	<th nowrap="nowrap" width="70%"><?php echo TX_MDL ?></th>
					    	<?php
						    	$i_n = 1;
						    	foreach($__ctg as $_k_c => $_v_c){
							    	echo '<th nowrap="nowrap" class="'.(($i_n%2==0)? "" : "_sb" ).'" width="70%">'.str_replace('"', "", $_v_c).'</th>';
							    	$i_n++;
						    	}
					    	?>
					    	<th nowrap="nowrap" width="70%">Total</th> <!-- Total derecha -> -->
					    </tr>
					    <?php
						    $_i_nm = 1;
						    foreach($Vl_Grph->d as $_k => $_v){
							    
							    $_td = NULL; $_tot_all = 0;
							    foreach($__ctg as $_k_c => $_v_c){
								    $_tot = $Vl_Grph->ls->{str_replace('"', "", $_v_c)}->{$_k}->tot;
								    if( isN($_tot) ){ $_tot = 0; }
								    $_td .= " <td nowrap='nowrap' width='70%'>".$_tot."</td> ";
								    
								    $_tot_all = ($_tot_all+$_tot);
								    $_tot_all_td[$_v_c][] = $_tot;
								    $_tot_all_sum = ($_tot_all_sum+$_tot);
							    }
							    
							    $_td .= " <td nowrap='nowrap' width='70%'>$_tot_all</td> "; /* Total derecha -> */
							    
							    echo "
							    	<tr class='Rw_".$_i_nm."'>
							    		<td nowrap='nowrap' width='70%'>".$_v->nm."</td>
							    		".$_td."
									</tr>
							    ";
							    if($_i_nm == 1){ $_i_nm = 2; }else{ $_i_nm = 1; }
							    
						    }
						    
						    /* Total abajo  */
						    foreach($_tot_all_td as $_k_tot => $_v_tot){
							   $_new_sum = 0;
							   foreach($_v_tot as $_v_tot_sum){
								   $_new_sum = ($_new_sum+$_v_tot_sum);
							   }
							   $_td_tot .= "<td nowrap='nowrap' width='70%'>$_new_sum</td>";
						    }
						    
						    echo "
						    		<tr class='Rw_".$_i_nm."'>
							    		<td nowrap='nowrap' class='_sb' width='30%'>Total</td>
								    	$_td_tot
								    	<td nowrap='nowrap' width='70%'>$_tot_all_sum</td>
									</tr>
								";
							/* Total abajo */
					    ?>
					</table>
				</div>
			<?php
			
		//Usuarios gestión
		}elseif($__t2 == "gst"){
			
			$__dt_1 = $_f1 != '' ? $_f1 : date('Y-m-01');
			$__dt_2 = $_f2 != '' ? $_f2 : date('Y-m-d');
			
			if( $_ftp == "f_his" ){
								
				$__fl .= ' AND DATE_FORMAT(mdlcnthis_fi, "%Y-%m-%d") BETWEEN "'.$__dt_1.'" AND "'.$__dt_2.'" ';
			
			}else{
								
				$__fl .= ' AND DATE_FORMAT(mdlcnt_fi, "%Y-%m-%d") BETWEEN "'.$__dt_1.'" AND "'.$__dt_2.'" ';
			
			}
			
			/*if(!isN($_f1) && !isN($_f2)){ 
				$__fl .= ' AND mdlcnthis_fi BETWEEN "'.$_f1.'" AND "'.$_f2.'" ';  
			}elseif(!isN($_f1)){
				$__fl .= ' AND mdlcnthis_fi  = "'.$_f1.'" ';
			}elseif(!isN($_f2)){
				$__fl .= ' AND mdlcnthis_fi  = "'.$_f2.'" ';
			}*/
			
			
			$Ls_Cnt_Qry = " 
							SELECT * FROM ".TB_MDL_CNT_HIS."
							INNER JOIN "._BdStr(DBM).TB_US." ON id_us = mdlcnthis_us
							INNER JOIN ".TB_MDL_CNT." ON id_mdlcnt = mdlcnthis_mdlcnt
							INNER JOIN ".TB_MDL." ON mdlcnt_mdl = id_mdl 
							INNER JOIN "._BdStr(DBM).TB_MDL_S." ON mdl_mdls = id_mdls
							INNER JOIN "._BdStr(DBM).TB_MDL_S_TP." ON mdls_tp = id_mdlstp
							WHERE id_mdlcnt != '' $__fl
							AND mdl_est != '"._CId('ID_SISMDLEST_ELI')."'
							ORDER BY id_mdlcnthis DESC
						";  
						
			$Ls_Cnt_Rg = $__cnx->_qry($Ls_Cnt_Qry);
			
			if($Ls_Cnt_Rg){ 
				$row_Ls_Cnt_Rg = $Ls_Cnt_Rg->fetch_assoc(); 
				$Tot_Ls_Cnt_Rg = $Ls_Cnt_Rg->num_rows; 
				if($Tot_Ls_Cnt_Rg > 0){
					
					do {
						
						//Lista la tabla
						$Vl['ls'][$row_Ls_Cnt_Rg['id_mdlcnthis']]['us'] = ctjTx($row_Ls_Cnt_Rg['us_nm']." ".$row_Ls_Cnt_Rg['us_ap'], 'in');
						$Vl['ls'][$row_Ls_Cnt_Rg['id_mdlcnthis']]['gst'] = ctjTx($row_Ls_Cnt_Rg['mdlcnthis_dsc'], 'in');
						$Vl['ls'][$row_Ls_Cnt_Rg['id_mdlcnthis']]['fi'] = _LclDte($row_Ls_Cnt_Rg['mdlcnthis_fi']);
						
						//Construye la grafica
						$Vl['ctg'][$row_Ls_Cnt_Rg['mdlcnthis_fi']] = $row_Ls_Cnt_Rg['mdlcnthis_fi'];
						
						$Vl['d'][$row_Ls_Cnt_Rg['id_us']]['nm'] = ctjTx($row_Ls_Cnt_Rg['us_nm']." ".$row_Ls_Cnt_Rg['us_ap'], 'in');
						$Vl['d'][$row_Ls_Cnt_Rg['id_us']]['f'][$row_Ls_Cnt_Rg['mdlcnthis_fi']]['tot']++;
						
					} while ($row_Ls_Cnt_Rg = $Ls_Cnt_Rg->fetch_assoc());
					$Vl_Grph = _jEnc($Vl);
					
				}
			}
			
			for($i=$__dt_1;$i<=$__dt_2;$i = date("Y-m-d", strtotime($i ."+ 1 days"))){ 
				
				$__ctg[] = '"'.$i.'"';
				
				foreach($Vl_Grph->d as $_k => $_v){
					$_d[$_k]['nm'] = $_v->nm;
					$_d[$_k]['tot'][] = ( !isN($_v->f->{$i}->tot) ) ? $_v->f->{$i}->tot : 0 ;
				}
				
			}
			
			//Construye los datos
			foreach(_jEnc($_d) as $_k_d => $_v_d){
				$_medio[] = "{ name:'".$_v_d->nm."', data:[".implode(',', $_v_d->tot)."]  } ";
			}
			//echo json_encode($__ctg);
			$_grph_d = implode(",", $_medio);
			$_grph_c = implode(",", $__ctg);
			
			$CntWb .= "
				SUMR_Grph.f.g4({ 
					id: '#_grph1',
					c: [".$_grph_c."],
					d: [".$_grph_d."],
					tt: 'Gestiones', 
					tt_sb: 'Gestiones - Usuarios',
					c_e: false
				});
			";
			
			?>
				<div class="__grph <?php echo $_f ?>">
					<?php echo h2('Usuarios - Gestiones'); ?>
					<div class="_grph_inf" >
					    <div id="_grph1" class="_grph1"></div>
					</div>
					
					<table width="100%" border="0" cellpadding="0" cellspacing="0" class="Ls_Rg _grph_tb"> 
				    	<tr>
					    	<th nowrap="nowrap" class="20%"><?php echo TX_F ?></th>
				    	    <th nowrap="nowrap" width="50%"><?php echo TX_GST ?></th>
				            <th nowrap="nowrap" class="30%"><?php echo TX_USR ?></th>
					    </tr>
					    <?php 
						    $_i_nm = 1;
						    foreach($Vl_Grph->ls as $_k => $_v){
							    echo "
							    	<tr class='Rw_".$_i_nm."'>
								    	<td nowrap='nowrap' width='20%'>".Spn(FechaESP([ 'f'=>$_v->fi, 't'=>9 ]))."</td>
										<td nowrap='nowrap' class='50%'>".$_v->gst."</td>
										<td nowrap='nowrap' class='30%'>".$_v->us."</td>
									</tr>
							    ";
							    if($_i_nm == 1){ $_i_nm = 2; }else{ $_i_nm = 1; }
						    }
						    echo "
						    		<tr class='Rw_".$_i_nm."'>
							    		<td nowrap='nowrap' class='20%'>Total</td>
								    	<td nowrap='nowrap' width='50%'></td>
								    	<td nowrap='nowrap' width='30%'>".$Tot_Ls_Cnt_Rg."</td>
									</tr>
								";
					    ?>
					</table>
				</div>
			<?php
		//Contactos gestiones
		
		}elseif($__t2 == "cnt_gst"){
			
			if( $_ftp == "f_his" ){
		
				if(!isN($_f1) && !isN($_f2)){ 
					$__fl_his .= ' AND DATE_FORMAT(mdlcnthis_fi, "%Y-%m-%d") BETWEEN "'.$_f1.'" AND "'.$_f2.'" ';  
				}elseif(!isN($_f1)){
					$__fl_his .= ' AND DATE_FORMAT(mdlcnthis_fi, "%Y-%m-%d")  = "'.$_f1.'" ';
				}elseif(!isN($_f2)){
					$__fl_his .= ' AND DATE_FORMAT(mdlcnthis_fi, "%Y-%m-%d")  = "'.$_f2.'" ';
				}
			
			}else{
				if(!isN($_f1) && !isN($_f2)){ 
					$__fl .= ' AND DATE_FORMAT(mdlcnt_fi, "%Y-%m-%d") BETWEEN "'.$_f1.'" AND "'.$_f2.'" ';  
				}elseif(!isN($_f1)){
					$__fl .= ' AND DATE_FORMAT(mdlcnt_fi, "%Y-%m-%d")  = "'.$_f1.'" ';
				}elseif(!isN($_f2)){
					$__fl .= ' AND DATE_FORMAT(mdlcnt_fi, "%Y-%m-%d")  = "'.$_f2.'" ';
				}
			}
			
			$Ls_Cnt_Qry = " 
			
							SELECT id_us, us_nm, us_ap, id_us as __us, 
							COUNT(*) AS __tot_his,
							( 
								SELECT COUNT(*)
								FROM ".TB_MDL_CNT."
								INNER JOIN ".TB_MDL." ON mdlcnt_mdl = id_mdl
								INNER JOIN "._BdStr(DBM).TB_MDL_S." ON mdl_mdls = id_mdls
								INNER JOIN "._BdStr(DBM).TB_MDL_S_TP." ON mdls_tp = id_mdlstp
								WHERE id_mdlcnt != '' $__fl $__fl_his
							) AS __tot_cnt,
							(
								SELECT
									COUNT(DISTINCT(mdlcnthis_mdlcnt))
								FROM
									".TB_MDL_CNT_HIS."
								INNER JOIN ".TB_MDL_CNT." ON mdlcnthis_mdlcnt = id_mdlcnt
								INNER JOIN ".TB_MDL." ON mdlcnt_mdl = id_mdl
								INNER JOIN "._BdStr(DBM).TB_MDL_S." ON mdl_mdls = id_mdls
								INNER JOIN "._BdStr(DBM).TB_MDL_S_TP." ON mdls_tp = id_mdlstp
								WHERE
									 id_mdlcnt != '' AND mdlcnthis_us = __us  $__fl $__fl_his
							) AS __tot_cnt_unq
							FROM
								".TB_MDL_CNT_HIS."
							INNER JOIN "._BdStr(DBM).TB_US." ON mdlcnthis_us = id_us
							INNER JOIN ".TB_MDL_CNT." ON mdlcnthis_mdlcnt = id_mdlcnt
							INNER JOIN ".TB_MDL." ON mdlcnt_mdl = id_mdl
							INNER JOIN "._BdStr(DBM).TB_MDL_S." ON mdl_mdls = id_mdls
							INNER JOIN "._BdStr(DBM).TB_MDL_S_TP." ON mdls_tp = id_mdlstp
							WHERE 
							id_mdlcnt != ''$__fl $__fl_his
							AND mdl_est != '"._CId('ID_SISMDLEST_ELI')."'
							GROUP BY id_us
							ORDER BY __tot_his DESC
						";
				
			$Ls_Cnt_Rg = $__cnx->_qry($Ls_Cnt_Qry);
			
			
			
			if($Ls_Cnt_Rg){ 
				$row_Ls_Cnt_Rg = $Ls_Cnt_Rg->fetch_assoc(); 
				$Tot_Ls_Cnt_Rg = $Ls_Cnt_Rg->num_rows;  
				if($Tot_Ls_Cnt_Rg > 0){
					do {
						
						//Lista Estados
						$Ls_Qry_Est = " 
							SELECT
								id_siscntest,
								siscntest_tt,
								siscntest_clr_bck,
								COUNT(*) _tot_est
							FROM
								".TB_MDL_CNT_EST."
								INNER JOIN "._BdStr(DBM).TB_SIS_CNT_EST." ON id_siscntest = mdlcntest_est
								INNER JOIN ".TB_MDL_CNT." ON mdlcntest_mdlcnt = id_mdlcnt
								INNER JOIN ".TB_MDL_CNT_HIS." ON (mdlcnthis_mdlcnt = mdlcntest_mdlcnt)
								INNER JOIN ".TB_MDL." ON mdlcnt_mdl = id_mdl
								INNER JOIN "._BdStr(DBM).TB_MDL_S." ON mdl_mdls = id_mdls
								INNER JOIN "._BdStr(DBM).TB_MDL_S_TP." ON mdls_tp = id_mdlstp
							WHERE mdlcntest_us = ".$row_Ls_Cnt_Rg['id_us']." AND id_mdlcnt != '' $__fl $__fl_his
							AND mdl_est != '"._CId('ID_SISMDLEST_ELI')."'
							GROUP BY id_siscntest
						"; 
						$Ls_Rg_Est = $__cnx->_qry($Ls_Qry_Est);
						do{
							if( !isN($row_Ls_Rg_Est['_tot_est']) ){
								
								$Vl['ls']['est'][$row_Ls_Rg_Est['id_siscntest']]['nm'] = ctjTx($row_Ls_Rg_Est['siscntest_tt'], 'in');
								$Vl['ls']['est'][$row_Ls_Rg_Est['id_siscntest']]['clr'] = ctjTx($row_Ls_Rg_Est['siscntest_clr_bck'], 'in');
								$Vl['ls']['est'][$row_Ls_Rg_Est['id_siscntest']]['tot'] = $row_Ls_Rg_Est['_tot_est'];
								
								$Vl['ls'][$row_Ls_Cnt_Rg['id_us']]['est'][$row_Ls_Rg_Est['id_siscntest']]['nm'] = ctjTx($row_Ls_Rg_Est['siscntest_tt'], 'in');
								$Vl['ls'][$row_Ls_Cnt_Rg['id_us']]['est'][$row_Ls_Rg_Est['id_siscntest']]['tot'] = $row_Ls_Rg_Est['_tot_est'];
							}
						} while ($row_Ls_Rg_Est = $Ls_Rg_Est->fetch_assoc());
						
						//Lista
						$Vl['ls'][$row_Ls_Cnt_Rg['id_us']]['nm'] = ctjTx($row_Ls_Cnt_Rg['us_nm']." ".$row_Ls_Cnt_Rg['us_ap'], 'in');
						$Vl['ls'][$row_Ls_Cnt_Rg['id_us']]['tot_his'] = ctjTx($row_Ls_Cnt_Rg['__tot_his'], 'in');
						$Vl['ls'][$row_Ls_Cnt_Rg['id_us']]['tot_cnt'] = ctjTx($row_Ls_Cnt_Rg['__tot_cnt'], 'in');
						$Vl['ls'][$row_Ls_Cnt_Rg['id_us']]['tot_cnt_unq'] = ctjTx($row_Ls_Cnt_Rg['__tot_cnt_unq'], 'in');
						
						//Grafica
						if($row_Ls_Cnt_Rg['__tot_his'] < 1){ $_prnt = 0; }else{ $_prnt = $row_Ls_Cnt_Rg['__tot_his']; }
						$_medio[] = "{ name:'".ctjTx(str_replace("'", "", $row_Ls_Cnt_Rg['us_nm']." ".$row_Ls_Cnt_Rg['us_ap']),'in')."', data:[". number_format($_prnt, 2, '.', '') ."] } "; 
						
					} while ($row_Ls_Cnt_Rg = $Ls_Cnt_Rg->fetch_assoc());
					$Vl_Grph = _jEnc($Vl);
				}
			}
			$_grph_tag = implode(",", $_medio);
			
			$CntWb .= "
				SUMR_Grph.f.g1({
					id: '#_grph1',
					d: [".$_grph_tag."],
					tt: 'Gestiones',
					tt_sb: 'Gestión de leads',
					c_e: false
				});
			";
			
			?>
				<div class="__grph <?php echo $_f ?>">
					<?php echo h2('Leads por estados'); ?>
					<div class="_grph_inf" >
					    <div id="_grph1" class="_grph1" style="height: 250px!important;"></div>
					</div>
					
					<table width="100%" border="0" cellpadding="0" cellspacing="0" class="Ls_Rg _grph_tb">
				    	<tr>
				    	    <th nowrap="nowrap" height="100px" width="70%"><?php echo TX_RSPNS ?></th>
				    	    <th nowrap="nowrap" height="100px" width="1px"><?php echo "Registro Gestión (Leads)" ?></th>
				    	    <th nowrap="nowrap" height="100px" width="1px"><?php echo "Leads gestionados" ?></th>
				    	    <th nowrap="nowrap" height="100px" width="1px"><?php echo "Promedio Gestión por (Leads)" ?></th>
				    	    <?php 
					    	    foreach($Vl_Grph->ls->est as $_k_est => $_v_est){
						    	   echo ' <th nowrap="nowrap" class="_sb" height="100px" style="background:'.$_v_est->clr.'; color:#605a5a" width="1px">'.$_v_est->nm.'</th> '; 
					    	    }
				    	    ?>
				    	    <th nowrap="nowrap" height="100px" width="70%"><?php echo "Total (Estados)" ?></th>
					    </tr>
					    <?php 
						    $_i_nm = 1;
						    foreach($Vl_Grph->ls as $_k => $_v){
							    
							    if($_k == 'est'){
								    foreach($_v as $_k_est_us => $_v_est_us){
									    $_est_id[] = $_k_est_us;
									}
								}
								
								if($_k != 'est'){
									$_td = NULL;
									$_tot_est = 0;
									for($i = 0; $i < count($_est_id); $i++){
										$_td .= "<td nowrap='nowrap' class='_sb' width='30%'>".( (!isN($_v->est->{$_est_id[$i]}->tot))? $_v->est->{$_est_id[$i]}->tot : 0 )."</td>";
										$_tot_est = ($_tot_est+$_v->est->{$_est_id[$i]}->tot);
									}
								}
								
								//Promedio de gestiones por leads
							    $_p_his_cnt = ($_v->tot_his/$_v->tot_cnt_unq);
							    
							    $_tot_his = ($_tot_his+$_v->tot_his);
							    
							    echo "
							    	<tr class='Rw_".$_i_nm."'>
								    	<td nowrap='nowrap' width='70%'>".$_v->nm."</td>
										<td nowrap='nowrap' class='_sb' width='30%'>".$_v->tot_his."</td>
										<td nowrap='nowrap' class='_sb' width='30%'>".$_v->tot_cnt_unq."</td>
										<td nowrap='nowrap' class='_sb' width='30%'>".$_p_his_cnt."</td>
										".$_td."
										<td nowrap='nowrap' class='_sb' width='30%'>".$_tot_est."</td>
									</tr>
							    ";
							    if($_i_nm == 1){ $_i_nm = 2; }else{ $_i_nm = 1; }
								    
						    }
						    echo " 
						    	<th nowrap='nowrap' width='1px'></th>
						    	<th nowrap='nowrap' width='1px'></th>
						    	<th nowrap='nowrap' width='1px'></th>
						    	<th nowrap='nowrap' width='1px'></th>
						    	<th nowrap='nowrap' width='1px'></th>
						    ";
					    ?>
					</table>
				</div>
			<?php
			
		//Usuarios gestión
		}elseif($__t2 == "md_est"){
			
			if( $_ftp != "f_his" ){
			
				if(!isN($_f1) && !isN($_f2)){ 
					$__fl .= ' AND DATE_FORMAT(mdlcnt_fi, "%Y-%m-%d") BETWEEN "'.$_f1.'" AND "'.$_f2.'" ';  
				}elseif(!isN($_f1)){
					$__fl .= ' AND DATE_FORMAT(mdlcnt_fi, "%Y-%m-%d") = "'.$_f1.'" ';
				}elseif(!isN($_f2)){
					$__fl .= ' AND DATE_FORMAT(mdlcnt_fi, "%Y-%m-%d") = "'.$_f2.'" ';
				}
			
			}
			
			$Ls_Cnt_Qry = " 
							SELECT  id_sismd ,
									sismd_tt ,
									id_siscntest ,
									siscntest_tt ,
									mdlcnt_m ,
									cnt_enc ,
									COUNT(*) AS __tot_m
							FROM ".TB_MDL_CNT."
								 INNER JOIN ".TB_MDL." ON mdlcnt_mdl = id_mdl 
								 INNER JOIN "._BdStr(DBM).TB_MDL_S." ON mdl_mdls = id_mdls
								 INNER JOIN "._BdStr(DBM).TB_MDL_S_TP." ON mdls_tp = id_mdlstp
								 INNER JOIN "._BdStr(DBM).TB_SIS_CNT_EST." ON mdlcnt_est = id_siscntest
								 INNER JOIN ".TB_CNT." ON mdlcnt_cnt = id_cnt
								 INNER JOIN "._BdStr(DBM).TB_SIS_MD." ON mdlcnt_m = id_sismd
							WHERE id_mdlcnt != ''  $__fl
							AND mdl_est != '"._CId('ID_SISMDLEST_ELI')."'
							GROUP BY
								siscntest_tt ,
								sismd_tt
							ORDER BY
								id_sismd DESC
						";
						
			$Ls_Cnt_Rg = $__cnx->_qry($Ls_Cnt_Qry);
			
			if($Ls_Cnt_Rg){ 
				$row_Ls_Cnt_Rg = $Ls_Cnt_Rg->fetch_assoc(); 
				$Tot_Ls_Cnt_Rg = $Ls_Cnt_Rg->num_rows; 
				if($Tot_Ls_Cnt_Rg > 0){
					do {
						
						$Vl['ls'][$row_Ls_Cnt_Rg['cnt_enc']]['nm'] = ctjTx($row_Ls_Cnt_Rg['sismd_tt'], 'in');
						$Vl['ls'][$row_Ls_Cnt_Rg['cnt_enc']]['tot'] = $row_Ls_Cnt_Rg['__tot_m'];
						$Vl['ls'][$row_Ls_Cnt_Rg['cnt_enc']]['est'] = ctjTx($row_Ls_Cnt_Rg['siscntest_tt'], 'in');
						
						$Vl['md'][$row_Ls_Cnt_Rg['mdlcnt_m']]['id'] = ctjTx($row_Ls_Cnt_Rg['id_sismd'], 'in');
						$Vl['md'][$row_Ls_Cnt_Rg['mdlcnt_m']]['nm'] = ctjTx($row_Ls_Cnt_Rg['sismd_tt'], 'in');

						$Vl['est'][$row_Ls_Cnt_Rg['id_siscntest']]['id'] = ctjTx($row_Ls_Cnt_Rg['id_siscntest'], 'in');
						$Vl['est'][$row_Ls_Cnt_Rg['id_siscntest']]['nm'] = ctjTx($row_Ls_Cnt_Rg['siscntest_tt'], 'in');

						$Vl['ctg'][$row_Ls_Cnt_Rg['mdlcnt_m']]['nm'] = ctjTx($row_Ls_Cnt_Rg['sismd_tt'], 'in');

						$Vl['d'][$row_Ls_Cnt_Rg['id_siscntest']]['id'] = ctjTx($row_Ls_Cnt_Rg['id_siscntest'], 'in');
						$Vl['d'][$row_Ls_Cnt_Rg['id_siscntest']]['nm'] = ctjTx($row_Ls_Cnt_Rg['siscntest_tt'], 'in');
						$Vl['d'][$row_Ls_Cnt_Rg['id_siscntest']]['m'][$row_Ls_Cnt_Rg['mdlcnt_m']]['tot'] = ctjTx($row_Ls_Cnt_Rg['__tot_m'], 'in') ;
						                    
					} while ($row_Ls_Cnt_Rg = $Ls_Cnt_Rg->fetch_assoc());

					$Vl_Grph = _jEnc($Vl);

					foreach($Vl_Grph->est as $k_est_e => $v_est_e){
						foreach($Vl_Grph->md as $k_est_m => $v_est_m){

							$Vla['d'][$v_est_e->id]['nm'] = $v_est_e->nm;

							if(!isN($Vl_Grph->d->{$v_est_e->id}->m->{$v_est_m->id}->tot)){
								$Vla['d'][$v_est_e->id]['m'][$v_est_m->id]['tot'] = $Vl_Grph->d->{$v_est_e->id}->m->{$v_est_m->id}->tot;	
							}else{
								$Vla['d'][$v_est_e->id]['m'][$v_est_m->id]['tot'] = 0;
							}
						}	
					}

					$Vl_Grpha = _jEnc($Vla);

				}
			} 
			//Datos
			foreach($Vl_Grpha->d as $_k_da => $_v_da){
				$_da[$_k_da]['nm'] = $_v_da->nm;
				
				foreach($_v_da->m as $_k_da_2 => $_v_da_2){
					$_da[$_k_da]['tot'][] = $_v_da_2->tot;
				}
			} 
			
			foreach(_jEnc($_da) as $_k_da_3 => $_v_da_3){
				$_medio[] = "{ name:'".$_v_da_3->nm."', data:[".implode(',', $_v_da_3->tot)."]  } ";
			}
			$_grph_da = implode(",", $_medio);
			
			//Categorias
			foreach($Vl_Grph->ctg as $_k => $_v){
				$__ctg[] = '"'.$_v->nm.'"';
			}
			$_grph_c = implode(",", $__ctg);
			
			$CntWb .= "
			
				Highcharts.chart('_grph1', {
				    chart: {
				        type: 'column'
				    },
				    title: {
				        text: ''
				    },
				    xAxis: {
				        categories: [".$_grph_c."]
				    },
				    yAxis: {
				        min: 0,
				        title: {
				            text: ''
				        },
				        stackLabels: {
				            enabled: true,
				            style: {
				                fontWeight: 'bold',
				                color: (Highcharts.theme && Highcharts.theme.textColor) || 'gray'
				            }
				        }
				    },
				    legend: {
				    	enabled: false
				    },
				    tooltip: {
				        headerFormat: '<b>{point.x}</b><br/>',
				        pointFormat: '{series.name}: {point.y}<br/>Total: {point.stackTotal}'
				    },
				    plotOptions: {
				        column: {
				            stacking: 'normal',
				            dataLabels: {
				                enabled: true,
				                color: (Highcharts.theme && Highcharts.theme.dataLabelsColor) || 'white'
				            }
				        }
				    },
				    series: [".$_grph_da."]
				});
				
			";
			
			?>
				<div class="__grph <?php echo $_f ?>">
					<?php echo h2('Medios y estados'); ?>
					<div class="_grph_inf" >
					    <div id="_grph1" class="_grph1"></div>
					</div>
					
					<table width="100%" border="0" cellpadding="0" cellspacing="0" class="Ls_Rg _grph_tb"> 
				    	<tr>
				    	    <th nowrap="nowrap" width="30%"><?php echo TX_MD ?></th>
							<th nowrap="nowrap" width="30%"><?php echo TX_EST ?></th>
				            <th nowrap="nowrap" class="_sb" width="30%"><?php echo TX_TOT ?></th>
					    </tr>
					    <?php 
						    $_i_nm = 1;
						    foreach($Vl_Grph->ls as $_k => $_v){
							    echo "
							    	<tr class='Rw_".$_i_nm."'>
								    	<td nowrap='nowrap' width='30%'>".$_v->nm."</td>
										<td nowrap='nowrap' width='30%'>".$_v->est."</td>
										<td nowrap='nowrap' class='_sb' width='30%'>".$_v->tot."</td>
									</tr>
							    ";
							    if($_i_nm == 1){ $_i_nm = 2; }else{ $_i_nm = 1; }
						    }
					    ?>
					</table>
				</div>
			<?php
		//Uso por area
		}elseif($__t2 == "gst_are"){
			
			if( $_ftp != "f_his" ){
			
				$__dt_1 = !isN($_f1) ? $_f1 : date('Y-m-01');
				$__dt_2 = !isN($_f2) ? $_f2 : date('Y-m-d');
			
				if(!isN($_f1) && !isN($_f2)){
					$__fl .= ' AND id_mdlcnt, DATE_FORMAT(mdlcnthis_fi, "%Y-%m-%d") BETWEEN "'.$__dt_1.'" AND "'.$__dt_2.'" ';
				}
			}
			
			
			$Ls_Cnt_Qry = " 
							SELECT id_clare, clare_tt, id_mdlcnt, DATE_FORMAT(mdlcnthis_fi, '%Y-%m-%d') as _f_i
							FROM ".TB_MDL_CNT_HIS."
									INNER JOIN ".TB_MDL_CNT." ON id_mdlcnt = mdlcnthis_mdlcnt
									INNER JOIN ".TB_MDL." ON id_mdl = mdlcnt_mdl
									INNER JOIN ".TB_MDL_ARE." ON mdlare_mdl = id_mdl
									INNER JOIN "._BdStr(DBM).TB_CL_ARE." ON mdlare_are = id_clare
									INNER JOIN "._BdStr(DBM).TB_MDL_S." ON mdl_mdls = id_mdls
									INNER JOIN "._BdStr(DBM).TB_MDL_S_TP." ON mdls_tp = id_mdlstp
							WHERE id_clare != '' $__fl
							AND mdl_est != '"._CId('ID_SISMDLEST_ELI')."' AND clare_est = 1
							ORDER BY mdlcnthis_mdlcnt
						";	 
			 
			
			 					
			$Ls_Cnt_Rg = $__cnx->_qry($Ls_Cnt_Qry);
			
			if($Ls_Cnt_Rg){ 
				$row_Ls_Cnt_Rg = $Ls_Cnt_Rg->fetch_assoc(); 
				$Tot_Ls_Cnt_Rg = $Ls_Cnt_Rg->num_rows; 
				
				if($Tot_Ls_Cnt_Rg > 0){		
					
					do {
						
						$__id_are = $row_Ls_Cnt_Rg['id_clare'];
						$__id_fi = $row_Ls_Cnt_Rg['_f_i'];
						
						$Vl['d'][$__id_are]['nm'] = ctjTx($row_Ls_Cnt_Rg['clare_tt'], 'in');
						$Vl['d'][$__id_are]['tot']++;
						$Vl['d'][$__id_are]['f'][$__id_fi]['tot']++;
						
						$Vl['p'][$__id_are]['tt'] = $row_Ls_Cnt_Rg['clare_tt'];
						$Vl['p'][$__id_are]['tot'][$row_Ls_Cnt_Rg['id_mdlcnt']] = $row_Ls_Cnt_Rg['id_mdlcnt'];					
							
						$Vl['ls'][$__id_fi][$__id_are]['nm'] = ctjTx($row_Ls_Cnt_Rg['clare_tt'], 'in');
						$Vl['ls'][$__id_fi][$__id_are]['tot']++;
						
						$Vl['ctg'][$__id_fi] = $__id_fi;
						
						                    
					} while ($row_Ls_Cnt_Rg = $Ls_Cnt_Rg->fetch_assoc());
					
					$Vl_Grph = _jEnc($Vl);
				}
				
			}else{
				
				echo $__cnx->c_r->error;
				
			}
			
			//echo count((array)$Vl_Grph->p->{4}->tot);
			
			foreach($Vl_Grph->d as $_k_d_3 => $_v_d_3){
				$_medio[] = "{ name:'".$_v_d_3->nm."', data:[". number_format($_v_d_3->tot, 2, '.', '') ."]  } ";
			}
			
			foreach($Vl_Grph->p as $_k_d_p3 => $_v_d_p3){
				$_medio2[] = "{ name:'".ctjTx($_v_d_p3->tt,'in')."', y: ".count((array)$_v_d_p3->tot)." } ";	
			}

			
			$_grph_tag = implode(",", $_medio);
			$_grph_tag2 = implode(",", $_medio2);
			
			$CntWb .= "
				SUMR_Grph.f.g1({ 
					id: '#_grph1',
					d: [".$_grph_tag."],
					tt: 'Gestión', 
					tt_sb: 'Gestión por area',
					c_e: false
				});
			";
			
			?>
				<div class="__grph <?php echo $_f ?>">
					<?php echo h2('Gestión por area'); ?>
					<div class="_grph_inf" >
					    <div id="_grph1" class="_grph1"></div>
					</div>
					
					<table width="100%" border="0" cellpadding="0" cellspacing="0" class="Ls_Rg _grph_tb"> 
				    	<tr>
					    	<th nowrap="nowrap" class="_sb" width="70%"><?php echo TX_MDL ?></th>
				    	    <th nowrap="nowrap" width="30%"><?php echo TX_CNT ?></th>
					    </tr>
					    <?php 
						    $_i_nm = 1;
						    foreach($Vl_Grph->d as $_k => $_v){
							    echo "
							    	<tr class='Rw_".$_i_nm."'>
							    		<td nowrap='nowrap' class='_sb' width='30%'>".$_v->nm."</td>
								    	<td nowrap='nowrap' width='70%'>".$_v->tot."</td>
									</tr>
							    ";
							    if($_i_nm == 1){ $_i_nm = 2; }else{ $_i_nm = 1; }
						    }
					    ?>
					</table>
				</div>
			<?php
			/*----------------------------------*/

				
			for($dte_i=$__dt_1;$dte_i<=$__dt_2; $dte_i=date("Y-m-d", strtotime($dte_i ."+ 1 days"))){ 
				
				$__ctg[] = '"'.$dte_i.'"'; 

				foreach($Vl_Grph->d as $_k=>$_v){
					$_d[$_k]['nm'] = $_v->nm;	
					if(!isN($_v)){ 
						$_d[$_k]['tot'][] = ( !isN($_v->f->{$dte_i}->tot) ) ? $_v->f->{$dte_i}->tot : 0 ;
					}
				}
				
			}
			
			//Construye los datos
			foreach(_jEnc($_d) as $_k_d => $_v_d){
				$_medio1[] = "{ name:'".$_v_d->nm."', data:[".implode(',', $_v_d->tot)."] } ";
			}
			
			$_grph_d = implode(",", $_medio1);
			$_grph_c = implode(",", $__ctg);
			
			$CntWb .= "
				SUMR_Grph.f.g4({ 
					id: '#_grph2',
					c: [".$_grph_c."],
					d: [".$_grph_d."],
					tt: 'Fechas', 
					tt_sb: 'Gestión por area - Fechas',
					c_e: false
				});
				
				SUMR_Grph.f.g2({ 
					id: '#_grphw',
					d: [".$_grph_tag2."],
					tt: ' ', 
					tt_sb: '',
					c_e: false,
					lbl: true,
					tt: 'Leads por Áreas'
				});
			";
			
			?>
			<div id="_grphw" class="_grphw"></div>
				<div class="__grph <?php echo $_f ?>">
					<?php echo h2('Gestión por area - Fechas'); ?>
					<div class="_grph_inf" >
					    <div id="_grph2" class="_grph2"></div>
					</div>
					
					<table width="100%" border="0" cellpadding="0" cellspacing="0" id="_grph_tb" class="Ls_Rg _grph_tb">
				    	<tr>
					    	<th nowrap="nowrap" width="70%"><?php echo TX_MD ?></th>
					    	<?php
						    	$i_n = 1;
						    	foreach($__ctg as $_k_c => $_v_c){
							    	echo '<th nowrap="nowrap" class="'.(($i_n%2==0)? "" : "_sb" ).'" width="70%">'.str_replace('"', "", $_v_c).'</th>';
							    	$i_n++;
						    	}
					    	?>
					    </tr>
					    <?php
						    $_i_nm = 1;
						    foreach($Vl_Grph->d as $_k => $_v){
							    
							    $_td = NULL;
							    foreach($__ctg as $_k_c => $_v_c){
								    $_tot = $Vl_Grph->ls->{str_replace('"', "", $_v_c)}->{$_k}->tot;
								    if( isN($_tot) ){ $_tot = 0; }
								    $_td .= " <td nowrap='nowrap' width='70%'>".$_tot."</td> ";
							    }
							    
							    echo "
							    	<tr class='Rw_".$_i_nm."'>
							    		<td nowrap='nowrap' width='70%'>".$_v->nm."</td>
							    		".$_td."
									</tr>
							    ";
							    if($_i_nm == 1){ $_i_nm = 2; }else{ $_i_nm = 1; }				    
						    }
					    ?>
					</table>
				</div>
			<?php
		}elseif($__t2 == "fac"){
			//Leads por leads - fecultad
			if( $_ftp != "f_his" ){
			
				if(!isN($_f1) && !isN($_f2)){ 
					$__fl .= ' AND DATE_FORMAT(mdlcnt_fi, "%Y-%m-%d") BETWEEN "'.$_f1.'" AND "'.$_f2.'" ';
				}elseif(!isN($_f1)){
					$__fl .= ' AND DATE_FORMAT(mdlcnt_fi, "%Y-%m-%d")  =  "'.$_f1.'" ';
				}elseif(!isN($_f2)){
					$__fl .= ' AND DATE_FORMAT(mdlcnt_fi, "%Y-%m-%d") = "'.$_f2.'" ';
				}
			
			}
					
			$Ls_Cnt_Qry = " 
							SELECT
								id_clare ,
								clare_tt ,
								COUNT(*) AS __tot_m
							FROM
								".TB_MDL_CNT."
							INNER JOIN ".TB_MDL." ON mdlcnt_mdl = id_mdl 
							INNER JOIN "._BdStr(DBM).TB_MDL_S." ON mdl_mdls = id_mdls
							INNER JOIN "._BdStr(DBM).TB_MDL_S_TP." ON mdls_tp = id_mdlstp
							INNER JOIN ".TB_CNT." ON mdlcnt_cnt = id_cnt
							INNER JOIN ".TB_MDL_ARE." ON mdlare_mdl = id_mdlcnt
							INNER JOIN "._BdStr(DBM).TB_CL_ARE." ON mdlare_are = id_clare
							WHERE
								id_mdlcnt != '' $__fl
							AND mdl_est != '"._CId('ID_SISMDLEST_ELI')."'
							AND clare_tp = '"._CId('ID_CLARETP_FAC')."' AND clare_est = 1
							GROUP BY
								clare_tt
							ORDER BY
								__tot_m DESC
						";
				
			$Ls_Cnt_Rg = $__cnx->_qry($Ls_Cnt_Qry);
			
			if($Ls_Cnt_Rg){ 
				$row_Ls_Cnt_Rg = $Ls_Cnt_Rg->fetch_assoc(); 
				$Tot_Ls_Cnt_Rg = $Ls_Cnt_Rg->num_rows; 
				if($Tot_Ls_Cnt_Rg > 0){
					
					$_tot = 0;
					
					do {
						
						$Vl['ls'][$row_Ls_Cnt_Rg['id_clare']]['nm'] = ctjTx($row_Ls_Cnt_Rg['clare_tt'], 'in');
						$Vl['ls'][$row_Ls_Cnt_Rg['id_clare']]['tot'] = $row_Ls_Cnt_Rg['__tot_m'];
						
						if($row_Ls_Cnt_Rg['__tot_m'] < 1){ $_prnt = 0; }else{ $_prnt = $row_Ls_Cnt_Rg['__tot_m']; }
						$_tot = ($_tot+$_prnt);
						
						$_medio[] = "{ name:'".ctjTx(str_replace("'", "", $row_Ls_Cnt_Rg['clare_tt']),'in')."', data:[". number_format($_prnt, 2, '.', '') ."] } "; 
						$_tabla .= '<tr><td>'.ctjTx($row_Ls_Cnt_Rg['clare_tt'], 'in').'</td><td>'. number_format($_prnt, 2, '.', '') .'</td></tr>';  
						                    
					} while ($row_Ls_Cnt_Rg = $Ls_Cnt_Rg->fetch_assoc());
					
					$Vl_Grph = _jEnc($Vl);
				}
			}
			$_grph_tag = implode(",", $_medio);
			
			$CntWb .= "
				SUMR_Grph.f.g1({ 
					id: '#_grph1',
					d: [".$_grph_tag."],
					tt: 'Leads', 
					tt_sb: 'Leads por facultad',
					c_e: false
				});
			";
			
			?>
				<div class="__grph <?php echo $_f ?>">
					<?php echo h2('Leads por usuario'); ?>
					<div class="_grph_inf" >
					    <div id="_grph1" class="_grph1"></div>
					</div>
					
					<table width="100%" border="0" cellpadding="0" cellspacing="0" class="Ls_Rg _grph_tb"> 
				    	<tr>
					    	<th nowrap="nowrap" class="_sb" width="70%"><?php echo TX_MDL ?></th>
				    	    <th nowrap="nowrap" width="30%"><?php echo TX_CNT ?></th>
					    </tr>
					    <?php 
						    $_i_nm = 1;
						    foreach($Vl_Grph->ls as $_k => $_v){
							    echo "
							    	<tr class='Rw_".$_i_nm."'>
							    		<td nowrap='nowrap' class='_sb' width='30%'>".$_v->nm."</td>
								    	<td nowrap='nowrap' width='70%'>".$_v->tot."</td>
									</tr>
							    ";
							    if($_i_nm == 1){ $_i_nm = 2; }else{ $_i_nm = 1; }
						    }
						    echo "
						    		<tr class='Rw_".$_i_nm."'>
							    		<td nowrap='nowrap' class='_sb' width='30%'>Total</td>
								    	<td nowrap='nowrap' width='70%'>".$_tot."</td>
									</tr>
								";
					    ?>
					</table>
				</div>
			<?php
		
		
		}else//Leads por fuente
		if($__t2 == "fnt"){
			
			if( $_ftp != "f_his" ){
			
				if(!isN($_f1) && !isN($_f2)){ 
					$__fl .= ' AND DATE_FORMAT(mdlcnt_fi, "%Y-%m-%d") BETWEEN "'.$_f1.'" AND "'.$_f2.'" ';
				}elseif(!isN($_f1)){
					$__fl .= ' AND DATE_FORMAT(mdlcnt_fi, "%Y-%m-%d")  =  "'.$_f1.'" ';
				}elseif(!isN($_f2)){
					$__fl .= ' AND DATE_FORMAT(mdlcnt_fi, "%Y-%m-%d") = "'.$_f2.'" ';
				}
			
			}
			
			$Ls_Cnt_Qry = " 
							SELECT id_sisfnt, sisfnt_nm, 
					  		COUNT(*) AS __tot_fnt 
							FROM ".TB_MDL_CNT."
								 INNER JOIN ".TB_MDL." ON mdlcnt_mdl = id_mdl 
								 INNER JOIN "._BdStr(DBM).TB_MDL_S." ON mdl_mdls = id_mdls
								 INNER JOIN "._BdStr(DBM).TB_MDL_S_TP." ON mdls_tp = id_mdlstp
								 INNER JOIN ".TB_CNT." ON mdlcnt_cnt = id_cnt
								 INNER JOIN "._BdStr(DBM).TB_SIS_FNT." ON mdlcnt_fnt = id_sisfnt
							WHERE id_mdlcnt != '' $__fl
							AND mdl_est != '"._CId('ID_SISMDLEST_ELI')."'
							GROUP BY mdlcnt_fnt
							ORDER BY id_mdlcnt DESC, mdlcnt_fa DESC
						";

			$Ls_Cnt_Rg = $__cnx->_qry($Ls_Cnt_Qry);
			
			if($Ls_Cnt_Rg){ 
				$row_Ls_Cnt_Rg = $Ls_Cnt_Rg->fetch_assoc(); 
				$Tot_Ls_Cnt_Rg = $Ls_Cnt_Rg->num_rows; 
				if($Tot_Ls_Cnt_Rg > 0){
					
					$_tot = 0;
					
					do {
						$Vl['ls'][$row_Ls_Cnt_Rg['id_sisfnt']]['id'] = ctjTx($row_Ls_Cnt_Rg['id_sisfnt'], 'in');
						$Vl['ls'][$row_Ls_Cnt_Rg['id_sisfnt']]['nm'] = ctjTx($row_Ls_Cnt_Rg['sisfnt_nm'], 'in');
						$Vl['ls'][$row_Ls_Cnt_Rg['id_sisfnt']]['tot'] = $row_Ls_Cnt_Rg['__tot_fnt'];
						
						if($row_Ls_Cnt_Rg['__tot_fnt'] < 1){ $_prnt = 0; }else{ $_prnt = $row_Ls_Cnt_Rg['__tot_fnt']; }
						$_tot = ($_tot+$_prnt);
						
						$_medio[] = "{ name:'".ctjTx(str_replace("'", "", $row_Ls_Cnt_Rg['sisfnt_nm']),'in')."', data:[". number_format($_prnt, 2, '.', '') ."] } "; 
						$_tabla .= '<tr><td>'.ctjTx($row_Ls_Cnt_Rg['sisfnt_nm'], 'in').'</td><td>'. number_format($_prnt, 2, '.', '') .'</td></tr>';  
						                    
					} while ($row_Ls_Cnt_Rg = $Ls_Cnt_Rg->fetch_assoc());
					
					$Vl_Grph = _jEnc($Vl);
				}
			}
			$_grph_tag = implode(",", $_medio);
			
			$CntWb .= "
				SUMR_Grph.f.g1({ 
					id: '#_grph1',
					d: [".$_grph_tag."],
					tt: 'Leads', 
					tt_sb: 'Leads por fuente',
					c_e: false
				});
			";
			
			?>
				<div class="__grph <?php echo $_f ?>">
					<?php echo h2('Leads por fuente'); ?>
					<div class="_grph_inf" >
					    <div id="_grph1" class="_grph1"></div>
					</div>
					
					<table width="100%" border="0" cellpadding="0" cellspacing="0" class="Ls_Rg _grph_tb"> 
				    	<tr>
					    	<th nowrap="nowrap" class="_sb" width="70%"><?php echo TX_MDL ?></th>
				    	    <th nowrap="nowrap" width="30%"><?php echo TX_CNT ?></th>
					    </tr>
					    <?php 
						    $_i_nm = 1;
						    foreach($Vl_Grph->ls as $_k => $_v){
							    echo "
							    	<tr rel='".$_v->id."' class='_row_clk Rw_".$_i_nm."'>
							    		<td nowrap='nowrap' class='_sb' width='30%'>".$_v->nm."</td>
								    	<td nowrap='nowrap' width='70%'>".$_v->tot."</td>
									</tr>
							    ";
							    if($_i_nm == 1){ $_i_nm = 2; }else{ $_i_nm = 1; }
						    }
						    echo "
						    		<tr rel='_all' class='_row_clk Rw_".$_i_nm."'>
							    		<td nowrap='nowrap' class='_sb' width='30%'>Total</td>
								    	<td nowrap='nowrap' width='70%'>".$_tot."</td>
									</tr>
								";
					    ?>
					</table>
				</div>
			<?php

		}elseif($__t2 == "us_mnt"){

			$__dt_2 = date('Y-m-d');

			if( !isN($_f2) ){
				$__dt_2 = $_f2;
			}else{
				$__dt_2 = strtotime ( '- 1 days' , strtotime ( $__dt_2 ) ) ;
				$__dt_2 = date ( 'Y-m-d' , $__dt_2 );
			}

			$__dt_1 = !isN($_f1) ? $_f1 : date('Y-m-01');

			if( $_ftp != "f_his" ){
			
				if(!isN($__dt_1) && !isN($__dt_2)){ 
					$__fl .= ' AND DATE_FORMAT(mdlcnt_fi, "%Y-%m-%d") BETWEEN "'.$__dt_1.'" AND "'.$__dt_2.'" ';
				}elseif(!isN($__dt_1)){
					$__fl .= ' AND DATE_FORMAT(mdlcnt_fi, "%Y-%m-%d")  =  "'.$__dt_1.'" ';
				}elseif(!isN($__dt_2)){
					$__fl .= ' AND DATE_FORMAT(mdlcnt_fi, "%Y-%m-%d") = "'.$__dt_2.'" ';
				}
			
			}
			
			$Ls_Cnt_Qry = " 
							SELECT id_us, us_nm, us_ap, DATE_FORMAT( mdlcnt_fi, '%Y-%m-%d' ) as mdlcnt_fi,
					  		COUNT(*) AS __tot_m 
							FROM ".TB_MDL_CNT."
								 INNER JOIN ".TB_MDL." ON mdlcnt_mdl = id_mdl 
								 INNER JOIN "._BdStr(DBM).TB_MDL_S." ON mdl_mdls = id_mdls
								 INNER JOIN "._BdStr(DBM).TB_MDL_S_TP." ON mdls_tp = id_mdlstp
								 INNER JOIN "._BdStr(DBM).TB_US." ON mdlcnt_us = id_us
							WHERE id_mdlcnt != '' $__fl
							AND mdl_est != '"._CId('ID_SISMDLEST_ELI')."'
							GROUP BY DATE_FORMAT( mdlcnt_fi, '%Y-%m-%d' ), id_us
							ORDER BY __tot_m DESC
						";
				
			$Ls_Cnt_Rg = $__cnx->_qry($Ls_Cnt_Qry);
			
			if($Ls_Cnt_Rg){ 
				$row_Ls_Cnt_Rg = $Ls_Cnt_Rg->fetch_assoc(); 
				$Tot_Ls_Cnt_Rg = $Ls_Cnt_Rg->num_rows; 
				if($Tot_Ls_Cnt_Rg > 0){
					
					$_tot = 0;
					
					do {
						
						$Vl['ctg'][$row_Ls_Cnt_Rg['mdlcnt_fi']] = $row_Ls_Cnt_Rg['mdlcnt_fi'];
						
						$Vl['d'][$row_Ls_Cnt_Rg['id_us']]['nm'] = ctjTx($row_Ls_Cnt_Rg['us_nm'].' '.$row_Ls_Cnt_Rg['us_ap'], 'in');
						$Vl['d'][$row_Ls_Cnt_Rg['id_us']]['f'][$row_Ls_Cnt_Rg['mdlcnt_fi']]['tot'] = $row_Ls_Cnt_Rg['__tot_m'];
						
						$Vl['ls'][$row_Ls_Cnt_Rg['mdlcnt_fi']][$row_Ls_Cnt_Rg['id_us']]['nm'] = ctjTx($row_Ls_Cnt_Rg['us_nm'].' '.$row_Ls_Cnt_Rg['us_ap'], 'in');
						$Vl['ls'][$row_Ls_Cnt_Rg['mdlcnt_fi']][$row_Ls_Cnt_Rg['id_us']]['tot'] = $row_Ls_Cnt_Rg['__tot_m'];
						                    
					} while ($row_Ls_Cnt_Rg = $Ls_Cnt_Rg->fetch_assoc());
					
					$Vl_Grph = _jEnc($Vl);

				}
			}

			for($i=$__dt_1;$i<=$__dt_2;$i = date("Y-m-d", strtotime($i ."+ 1 days"))){ 

				$__ctg[] = '"'.$i.'"';
				
				foreach($Vl_Grph->d as $_k => $_v){
					$_d[$_k]['nm'] = $_v->nm;
					$_d[$_k]['tot'][] = ( !isN($_v->f->{$i}->tot) ) ? $_v->f->{$i}->tot : 0 ;
				}
				
			}

			

			//Construye los datos
			foreach(_jEnc($_d) as $_k_d => $_v_d){
				$_medio[] = "{ name:\"".$_v_d->nm."\", data:[".implode(',', $_v_d->tot)."] } ";
			}
			
			$_grph_d = implode(",", $_medio);
			$_grph_c = implode(",", $__ctg);
			
			$CntWb .= "
				SUMR_Grph.f.g4({ 
					id: '#_grph1',
					c: [".$_grph_c."],
					d: [".$_grph_d."],
					tt: 'Leads', 
					tt_sb: 'Leads por usuario',
					c_e: false
				});
			";
			
			?>
				<div class="__grph">
					<?php echo h2('Leads por usuario'); ?>
					<div class="_grph_inf" >
						<div id="_grph1" class="_grph6"></div>
					</div>
					
					<table width="100%" border="0" cellpadding="0" cellspacing="0" id="_grph_tb" class="Ls_Rg _grph_tb">
						<tr>
							<th nowrap="nowrap" width="70%"><?php echo 'Marcas' ?></th>
							<?php
								$i_n = 1;
								foreach($__ctg as $_k_c => $_v_c){
									echo '<th nowrap="nowrap" class="'.(($i_n%2==0)? "" : "_sb" ).'" width="70%">'.str_replace('"', "", $_v_c).'</th>';
									$i_n++;
								}
							?>
							<th nowrap="nowrap" width="70%">Total</th> <!-- Total derecha -> -->
						</tr>
						<?php
							$_i_nm = 1;
							foreach($Vl_Grph->d as $_k => $_v){
								
								$_td = NULL; $_tot_all = 0;
								foreach($__ctg as $_k_c => $_v_c){
									$_tot = $Vl_Grph->ls->{str_replace('"', "", $_v_c)}->{$_k}->tot;
									if( isN($_tot) ){ $_tot = 0; }
									$_td .= " <td nowrap='nowrap' width='70%'>".$_tot."</td> ";
									
									$_tot_all = ($_tot_all+$_tot);
									$_tot_all_td[$_v_c][] = $_tot;
									$_tot_all_sum = ($_tot_all_sum+$_tot);
									
								}
								
								$_td .= " <td nowrap='nowrap' width='70%'>".$_tot_all."</td> "; /* Total derecha -> */
								
								echo "
									<tr class='Rw_".$_i_nm."'>
										<td nowrap='nowrap' width='70%'>".$_v->nm."</td>
										".$_td."
									</tr>
								";
								if($_i_nm == 1){ $_i_nm = 2; }else{ $_i_nm = 1; }
								
							}
							
							/* Total abajo  */
							foreach($_tot_all_td as $_k_tot => $_v_tot){
								$_new_sum = 0;
								foreach($_v_tot as $_v_tot_sum){
									$_new_sum = ($_new_sum+$_v_tot_sum);
								}
								$_td_tot .= "<td nowrap='nowrap' width='70%'>".$_new_sum."</td>";
							}
							
							echo "
									<tr class='Rw_".$_i_nm."'>
										<td nowrap='nowrap' class='_sb' width='30%'>Total</td>
										$_td_tot
										<td nowrap='nowrap' width='70%'>".$_tot_all_sum."</td>
									</tr>
								";
							/* Total abajo */
							
						?>
					</table>
				</div>
			<?php

		}
	}
?>

<style>
	
	::-webkit-scrollbar {
	      width: 15px;
	} /* this targets the default scrollbar (compulsory) */
	
	::-webkit-scrollbar-track {
      background-color: #E2E1E3;
	} /* the new scrollbar will have a flat appearance with the set background color */
	 
	::-webkit-scrollbar-thumb {
	      background-color: #aeadb0; 
	} /* this will style the thumb, ignoring the track */
	 
	::-webkit-scrollbar-button {
	      background-color: #aeadb0;
	} /* optionally, you can style the top and the bottom buttons (left and right for horizontal bars) */
	 
	::-webkit-scrollbar-corner {
	      background-color: #aeadb0;
	}
	
	.__grph{ border: 1px solid #E4E5E8; width: 100%; margin-top: 5%; overflow-x: scroll!important; overflow-y: hidden!important; }
	.__grph ._grph_inf{ margin-top: 5%; }
	.__grph ._grph_tb{ margin-top: 5%; width: 100%!important; }
	.__grph ._grph_tb.Ls_Rg .Rw_1{ background: #FFF!important; }
	.__grph ._grph_tb.Ls_Rg .Rw_2{ background: #CFECFF!important; }
	.__grph ._grph_tb.Ls_Rg .Rw_1:Hover, .Ls_Rg .Rw_2:Hover{ background: #FFC!important; }
	.__grph ._grph_tb td{ /*white-space: unset!important;*/ white-space: normal; }
	.__grph ._grph_inf{ display: block; margin: auto; text-align: center; }
	.__grph h2{ text-align: center; font-size: 18px; }
	
</style>