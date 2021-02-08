<?php 	
	
	
	$_f1 = Php_Ls_Cln($_GET['_f_in']); 
	$_f2 = Php_Ls_Cln($_GET['_f_out']);
	$_cd = Php_Ls_Cln($_GET['_f_cd']);

	$_fch_act = Php_Ls_Cln($_GET['_fch_act']);

	$_cllcl_lvl = Php_Ls_Cln($_GET['_cllcl_lvl']);
	$_orgtag = Php_Ls_Cln($_GET['_orgtag']);
	$_orgls = Php_Ls_Cln($_GET['_orgls']);

	if( $_fch_act == 'ok' || !isN($_f1) ){
		
		$__dt_2 = date('Y-m-d');

		if( !isN($_f2) ){
			$__dt_2 = $_f2;
		}else{
			$__dt_2 = strtotime ( '- 1 days' , strtotime ( $__dt_2 ) ) ;
			$__dt_2 = date ( 'Y-m-d' , $__dt_2 );
		}

		$__dt_1 = !isN($_f1) ? $_f1 : date('Y-m-01');
	}
	

	if( !isN($__t2)){
		
		$__id_prfx = '_'.Gn_Rnd(20);
		
		/* Filtros */
		if( !isN($_cd) ){
			$__fl .= ' AND org_cd  IN ('.$_cd.') ';
		}
		
		//Leads por medio
		if($__t2 == "sls"){
			
			if( $_ftp != "f_his" ){
			
				if(!isN($__dt_1) && !isN($__dt_2)){ 
					$__fl .= ' AND DATE_FORMAT(orgsdsarrsls_f, "%Y-%m-%d") BETWEEN "'.$__dt_1.'" AND "'.$__dt_2.'" ';
				}elseif(!isN($__dt_1)){
					$__fl .= ' AND DATE_FORMAT(orgsdsarrsls_f, "%Y-%m-%d")  =  "'.$__dt_1.'" ';
				}elseif(!isN($__dt_2)){
					$__fl .= ' AND DATE_FORMAT(orgsdsarrsls_f, "%Y-%m-%d") = "'.$__dt_2.'" ';
				}
			
			}

			if(!isN($_cllcl_lvl)){
				$__fl .= " AND id_org IN ( SELECT id_org FROM "._BdStr(DBM).TB_ORG." 
							INNER JOIN "._BdStr(DBM).TB_ORG_SDS." ON orgsds_org = id_org
							INNER JOIN "._BdStr(DBM).TB_ORG_SDS_ARR." ON orgsdsarr_orgsds = id_orgsds
							INNER JOIN "._BdStr(DBM).TB_CL_LCL." ON orgsdsarr_lcl = id_cllcl WHERE cllcl_lvl = ".$_cllcl_lvl." )";	
			}
	
			if(!isN($_orgtag)){
	
				$__fl .= " AND id_org IN ( SELECT id_org FROM "._BdStr(DBM).TB_ORG." 
							INNER JOIN "._BdStr(DBM).TB_ORG_TAG." ON orgtag_org = id_org
								WHERE orgtag_tag = ".$_orgtag." )";
	
			}

			if(!isN($_orgls)){
				$__fl .= " AND id_org IN ( ".$_orgls." )";	
			}
			
			$LsQry = " 
                            SELECT  org_enc, org_nm, org_clr, orgsds_nm, org_img, SUM(orgsdsarrsls_vl) AS _t_sls
                            FROM "._BdStr(DBM).TB_ORG_SDS_ARR_SLS."
                                INNER JOIN "._BdStr(DBM).TB_ORG_SDS_ARR." ON orgsdsarrsls_arr = id_orgsdsarr 
                                INNER JOIN "._BdStr(DBM).TB_ORG_SDS." ON orgsdsarr_orgsds = id_orgsds
                                INNER JOIN "._BdStr(DBM).TB_ORG." ON orgsds_org = id_org
                            WHERE id_orgsdsarrsls != '' AND org_est = 1 AND orgsdsarr_vl_rpt = 2 ".$__fl."     
                            GROUP BY orgsdsarr_orgsds
                            ORDER BY org_nm ASC
						"; 
                        
            $LsRg = $__cnx->_qry($LsQry);
			
			if($LsRg){

                $rwLsRg = $LsRg->fetch_assoc(); 
                $TotLsRg = $LsRg->num_rows; 

				if($TotLsRg > 0){
					
					$_tot = 0;
					
					do {

						$Vl['ls'][$rwLsRg['org_enc']]['nm'] = ctjTx($rwLsRg['org_nm'], 'in');
						$Vl['ls'][$rwLsRg['org_enc']]['tot'] = $rwLsRg['_t_sls'];

                        $__img = _ImVrs(['img'=>$rwLsRg['org_img'], 'f'=>DMN_FLE_ORG ]);
        
                        $_mark[] = "{ 
                                        name:\"".ctjTx($rwLsRg['org_nm'],'in')."\",   
                                        data:[{
                                            y:". number_format($rwLsRg['_t_sls'], 0, '.', '') .",
                                            logo: '".$__img->th_50 ."'
                                        }], 
                                        color:'".$rwLsRg['org_clr']."' 
                                    } "; 
                   
                    } while ($rwLsRg = $LsRg->fetch_assoc());
					
					$_grph_tag = implode(",", $_mark);
                }
                
			}

			$CntWb .= "
                SUMR_Grph.f.g1({ 
                    id: '#_grph1',
                    d: [".$_grph_tag."],
                    tt: 'Ventas Totales', 
                    c_e: false,
                    ttip_frmt:function(d){
                        if(!isN(d) && !isN(d.point)){
							return '<b>'+d.series.name+'</b> : $' + Highcharts.numberFormat(d.y, 0, ',', '.');
							
							

                        }
					},
                    plot_dl_uhtml: true,
                    plot_dl_allwovlp: true,
                    plot_dl_y: -5,
                    plot_dl_frmt:function(d){
                        if(!isN(d) && !isN(d.point)){
                            
                            var point = d.point;

                            window.setTimeout(function () {
                                point.dataLabel.attr({
                                    y: point.plotY - 50
                                });
                            });

                            return '$ ' + Highcharts.numberFormat(d.y, 0, ',', '.') + '<br><br><div class=\"HiChrt_Logo_Th\"><div class=\"_imgf\" style=\"background-image:url(' + d.point.logo + ');margin-left:auto;margin-right:auto;\"></div></div>';

                        }
                    },
                    plot_dl_gpdng:0
                });
            ";
			
			?>
				<div class="__grph <?php echo $_f ?>">
					<?php echo h2('Ventas'); ?>
					<div class="_grph_inf" >
					    <div id="_grph1" class="_grph1"></div>
					</div>
					
					<table width="100%" border="0" cellpadding="0" cellspacing="0" class="Ls_Rg _grph_tb"> 
				    	<tr>
					    	<th nowrap="nowrap" class="_sb" width="70%"><?php echo 'Marca' ?></th>
				    	    <th nowrap="nowrap" width="30%"><?php echo 'Total' ?></th>
					    </tr>
					    <?php 
						    $_i_nm = 1;
						    foreach($Vl['ls'] as $_k => $_v){
							    echo "
							    	<tr class='Rw_".$_i_nm."'>
							    		<td nowrap='nowrap' class='_sb' width='30%'>".$_v['nm']."</td>
								    	<td nowrap='nowrap' width='70%'>".cnVlrMon('', $_v['tot'])."</td>
									</tr>
								";
								$_tot += $_v['tot'];
							    if($_i_nm == 1){ $_i_nm = 2; }else{ $_i_nm = 1; }
						    }
						    echo "
						    		<tr class='Rw_".$_i_nm."'>
							    		<td nowrap='nowrap' class='_sb' width='30%'>Total</td>
								    	<td nowrap='nowrap' width='70%'> ".cnVlrMon('', $_tot)."</td>
									</tr>
								";
					    ?>
					</table>
				</div>
			<?php
		}elseif($__t2 == "sls_spln"){
			
			if( $_ftp != "f_his" ){
			
				if(!isN($_f1) && !isN($_f2)){ 
					$__fl .= ' AND DATE_FORMAT(orgsdsarrsls_f, "%Y-%m-%d") BETWEEN "'.$_f1.'" AND "'.$_f2.'" ';
				}elseif(!isN($_f1)){
					$__fl .= ' AND DATE_FORMAT(orgsdsarrsls_f, "%Y-%m-%d")  =  "'.$_f1.'" ';
				}elseif(!isN($_f2)){
					$__fl .= ' AND DATE_FORMAT(orgsdsarrsls_f, "%Y-%m-%d") = "'.$_f2.'" ';
				}
			
			}
			
			$LsQry = " 
						SELECT  org_enc,
								org_nm,
								org_clr,
								orgsds_nm,
								org_img,
								id_orgsds,
								SUM(orgsdsarrsls_vl) AS _t_sls,
								DATE_FORMAT(orgsdsarrsls_f, '%Y-%m') as _f_i
						FROM "._BdStr(DBM).TB_ORG_SDS_ARR_SLS."
							INNER JOIN "._BdStr(DBM).TB_ORG_SDS_ARR." ON orgsdsarrsls_arr = id_orgsdsarr 
							INNER JOIN "._BdStr(DBM).TB_ORG_SDS." ON orgsdsarr_orgsds = id_orgsds
							INNER JOIN "._BdStr(DBM).TB_ORG." ON orgsds_org = id_org
						WHERE id_orgsdsarrsls != '' AND org_est = 1 AND orgsdsarr_vl_rpt = 2 ".$__fl."     
						GROUP BY _f_i, orgsdsarr_orgsds
						ORDER BY org_nm ASC
					"; 
                        
            $LsRg = $__cnx->_qry($LsQry);
			
			if($LsRg){

                $rwLsRg = $LsRg->fetch_assoc(); 
                $TotLsRg = $LsRg->num_rows; 

				if($TotLsRg > 0){
					
					$_tot = 0;
					
					do {

						$Vl['ls'][$rwLsRg['org_enc']]['nm'] = ctjTx($rwLsRg['org_nm'], 'in');
						$Vl['ls'][$rwLsRg['org_enc']]['tot'] = $rwLsRg['_t_sls'];

                        $__img = _ImVrs(['img'=>$rwLsRg['org_img'], 'f'=>DMN_FLE_ORG ]);

						$__v['g'][$rwLsRg['_f_i']]['date'] = $rwLsRg['_f_i'];
						$__v['g'][$rwLsRg['_f_i']]['tot'] = $__v['g'][$rwLsRg['_f_i']]['tot'] + $rwLsRg['_t_sls']; 

						$__v['m'][ $rwLsRg['id_orgsds'] ]['nm'] = $rwLsRg['org_nm'];
						$__v['m'][ $rwLsRg['id_orgsds'] ]['clr'] = $rwLsRg['org_clr'];
						$__v['m'][ $rwLsRg['id_orgsds'] ]['img'] = $__img;
						$__v['m'][ $rwLsRg['id_orgsds'] ]['f'][$rwLsRg['_f_i']]['date'] = $rwLsRg['_f_i'];
						$__v['m'][ $rwLsRg['id_orgsds'] ]['f'][$rwLsRg['_f_i']]['tot'] = $__v[$rwLsRg['_f_i']]['tot'] + $rwLsRg['_t_sls'];  
                   
                    } while ($rwLsRg = $LsRg->fetch_assoc());
					
					for($i=$__dt_1; $i<=$__dt_2; $i=date("Y-m", strtotime($i ."+ 1 month"))){ 	
              
						$__fkey = date("Y-m", strtotime($i) );
						$__ctg[] = '"'.FechaESP_OLD($__fkey, 10).'"';
						$__data_g[ $__fkey ] = !isN($__v['g'][ $__fkey ]['tot'])?$__v['g'][ $__fkey ]['tot']:0;
		
						foreach($__v['m'] as $__marks_k=>$__marks_v){
							$__data_bmrk[ $__marks_k ][] = "
								{
									y:".(!isN( $__marks_v['f'][ $__fkey ]['tot'] ) ? $__marks_v['f'][ $__fkey ]['tot'] : 0).",
									logo:'".$__marks_v['img']->th_50."'
								}
							";
						}
					}

					foreach($__v['m'] as $__marks_k=>$__marks_v){

						$__data_mrk[ $__marks_k ] = "
							{
								name:'".$__marks_v['nm']."',   
								data:[".implode(",", $__data_bmrk[$__marks_k])."], 
								color:'".$__marks_v['clr']."'
							}
						";
					}


					$_grph_c = implode(",", $__ctg);            
					$_grph_data_g = implode(",", $__data_g);
					$_grph_data_m = implode(",", $__data_mrk);



                }
                
			}

			$CntWb .= "
					SUMR_Grph.f.g3({ 
						id: '#_grph2',
						tt: 'Ventas Totales', 
						tt_sb: '".$_grph_subt."',
						c:[".$_grph_c."],
						c_e: false,
						d:[
							{
								name:'Total General',   
								data:[".$_grph_data_g."], 
								color:'#000'
							},
							".$_grph_data_m."
						],
						plot_dl_uhtml: true,
						plot_dl_allwovlp: true,
						plot_dl_y: -1,
						plot_dl_frmt:function(d){
							if(!isN(d) && !isN(d.point)){
								
								if(!isN( d.point.logo )){
									var point = d.point;

									window.setTimeout(function () {
										point.dataLabel.attr({
											y: point.plotY - 20
										});
									});

									return '<div class=\"HiChrt_Logo_Th _smll\"><div class=\"_imgf\" style=\"background-image:url(' + d.point.logo + ');margin-left:auto;margin-right:auto;\"></div></div>';
								}

							}
						}
					});
            ";
			
			?>
				<div class="__grph <?php echo $_f ?>">
					<?php echo h2('Ventas'); ?>
					<div class="_grph_inf" >
					    <div id="_grph2" class="_grph2"></div>
					</div>
					
					<table width="100%" border="0" cellpadding="0" cellspacing="0" class="Ls_Rg _grph_tb"> 
				    	<tr>
					    	<th nowrap="nowrap" class="_sb" width="70%"><?php echo 'Marca' ?></th>
				    	    <th nowrap="nowrap" width="30%"><?php echo 'Total' ?></th>
					    </tr>
					    <?php 
						    $_i_nm = 1;
						    foreach($Vl['ls'] as $_k => $_v){
							    echo "
							    	<tr class='Rw_".$_i_nm."'>
							    		<td nowrap='nowrap' class='_sb' width='30%'>".$_v['nm']."</td>
								    	<td nowrap='nowrap' width='70%'>".cnVlrMon('', $_v['tot'])."</td>
									</tr>
								";
								$_tot += $_v['tot'];
							    if($_i_nm == 1){ $_i_nm = 2; }else{ $_i_nm = 1; }
						    }
						    echo "
						    		<tr class='Rw_".$_i_nm."'>
							    		<td nowrap='nowrap' class='_sb' width='30%'>Total</td>
								    	<td nowrap='nowrap' width='70%'>".cnVlrMon('', $_tot)."</td>
									</tr>
								";
					    ?>
					</table>
				</div>
			<?php
		}elseif($__t2 == "sls_x_day"){
			if( $_ftp != "f_his" ){
			
				if(!isN($__dt_1) && !isN($__dt_2)){ 
					$__fl .= ' AND DATE_FORMAT(orgsdsarrsls_f, "%Y-%m-%d") BETWEEN "'.$__dt_1.'" AND "'.$__dt_2.'" ';
				}elseif(!isN($__dt_1)){
					$__fl .= ' AND DATE_FORMAT(orgsdsarrsls_f, "%Y-%m-%d")  =  "'.$__dt_1.'" ';
				}elseif(!isN($__dt_2)){
					$__fl .= ' AND DATE_FORMAT(orgsdsarrsls_f, "%Y-%m-%d") = "'.$__dt_2.'" ';
				}
			
			}

			if(!isN($_cllcl_lvl)){
				$__fl .= " AND id_org IN ( SELECT id_org FROM "._BdStr(DBM).TB_ORG." 
							INNER JOIN "._BdStr(DBM).TB_ORG_SDS." ON orgsds_org = id_org
							INNER JOIN "._BdStr(DBM).TB_ORG_SDS_ARR." ON orgsdsarr_orgsds = id_orgsds
							INNER JOIN "._BdStr(DBM).TB_CL_LCL." ON orgsdsarr_lcl = id_cllcl WHERE cllcl_lvl = ".$_cllcl_lvl." )";	
			}
	
			if(!isN($_orgtag)){
	
				$__fl .= " AND id_org IN ( SELECT id_org FROM "._BdStr(DBM).TB_ORG." 
							INNER JOIN "._BdStr(DBM).TB_ORG_TAG." ON orgtag_org = id_org
								WHERE orgtag_tag = ".$_orgtag." )";
	
			}

			if(!isN($_orgls)){
				$__fl .= " AND id_org IN ( ".$_orgls." )";	
			}

			$Ls_Cnt_Qry = " SELECT
								id_orgsdsarrsls,
								orgsdsarr_orgsds,
								org_nm,
								orgsdsarrsls_vl,
								orgsdsarrsls_f
							FROM "._BdStr(DBM).TB_ORG_SDS_ARR_SLS."
								INNER JOIN "._BdStr(DBM).TB_ORG_SDS_ARR." ON orgsdsarrsls_arr = id_orgsdsarr 
								INNER JOIN "._BdStr(DBM).TB_ORG_SDS." ON orgsdsarr_orgsds = id_orgsds
								INNER JOIN "._BdStr(DBM).TB_ORG." ON orgsds_org = id_org
							WHERE
								id_orgsdsarrsls != '' $__fl AND org_est = 1 AND orgsdsarr_vl_rpt = 2 AND orgsdsarr_vl_mnt = 2 ORDER BY org_nm, orgsdsarrsls_f ASC
						"; 
			
			$Ls_Cnt_Rg = $__cnx->_qry($Ls_Cnt_Qry);
		
			
			if($Ls_Cnt_Rg){ 
				$row_Ls_Cnt_Rg = $Ls_Cnt_Rg->fetch_assoc(); 
				$Tot_Ls_Cnt_Rg = $Ls_Cnt_Rg->num_rows; 
				if($Tot_Ls_Cnt_Rg > 0){
					do {
						
						//Construye la grafica
						$Vl['ctg'][$row_Ls_Cnt_Rg['orgsdsarrsls_f']] = $row_Ls_Cnt_Rg['orgsdsarrsls_f'];
						
						$Vl['d'][$row_Ls_Cnt_Rg['orgsdsarr_orgsds']]['nm'] = ctjTx($row_Ls_Cnt_Rg['org_nm'], 'in');
						$Vl['d'][$row_Ls_Cnt_Rg['orgsdsarr_orgsds']]['f'][$row_Ls_Cnt_Rg['orgsdsarrsls_f']]['tot'] = $row_Ls_Cnt_Rg['orgsdsarrsls_vl'];
						
						$Vl['ls'][$row_Ls_Cnt_Rg['orgsdsarrsls_f']][$row_Ls_Cnt_Rg['orgsdsarr_orgsds']]['nm'] = ctjTx($row_Ls_Cnt_Rg['org_nm'], 'in');
						$Vl['ls'][$row_Ls_Cnt_Rg['orgsdsarrsls_f']][$row_Ls_Cnt_Rg['orgsdsarr_orgsds']]['tot'] = $row_Ls_Cnt_Rg['orgsdsarrsls_vl'];
						
					} while ($row_Ls_Cnt_Rg = $Ls_Cnt_Rg->fetch_assoc());
					$Vl_Grph = _jEnc($Vl);
				}
			}

			for($i=$__dt_1;$i<=$__dt_2;$i = date("Y-m-d", strtotime($i ."+ 1 days"))){ 
				
				$__ctg[] = '"'.$i.'"';
				$__ctgs[] = '"'.FechaESP_OLD($i, 'yrdy').'"';
				
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
					id: '#_grph3',
					c: [".$_grph_c."],
					d: [".$_grph_d."],
					tt: 'Ventas', 
					tt_sb: 'Ventas por día',
					c_e: false
				});
			";
			
			?>
				<div class="__grph <?php echo $_f ?>">
					<?php echo h2('Ventas'); ?>
					<div class="_grph_inf" >
					    <div id="_grph3" class="_grph3"></div>
					</div>
					
					<table width="100%" border="0" cellpadding="0" cellspacing="0" id="_grph_tb" class="Ls_Rg _grph_tb">
				    	<tr>
					    	<th nowrap="nowrap" width="70%"><?php echo 'Marcas' ?></th>
					    	<?php
						    	$i_n = 1;
						    	foreach($__ctg as $_k_c => $_v_c){

									$_tt = str_replace('"', "", $_v_c);

							    	echo '<th nowrap="nowrap" class="'.(($i_n%2==0)? "" : "_sb" ).'" width="70%">'.FechaESP_OLD($_tt, 6).' '.FechaESP_OLD($_tt, 4).HTML_BR.FechaESP_OLD($_tt, 2).' '.FechaESP_OLD($_tt, 3).'</th>';
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
								    $_td .= " <td nowrap='nowrap' width='70%'>".cnVlrMon('', $_tot)."</td> ";
								    
								    $_tot_all = ($_tot_all+$_tot);
								    $_tot_all_td[$_v_c][] = $_tot;
								    $_tot_all_sum = ($_tot_all_sum+$_tot);
								    
							    }
							    
							    $_td .= " <td nowrap='nowrap' width='70%'>".cnVlrMon('', $_tot_all)."</td> "; /* Total derecha -> */
							    
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
							   $_td_tot .= "<td nowrap='nowrap' width='70%'>".cnVlrMon('', $_new_sum)."</td>";
						    }
						    
						    echo "
						    		<tr class='Rw_".$_i_nm."'>
							    		<td nowrap='nowrap' class='_sb' width='30%'>Total</td>
								    	$_td_tot
								    	<td nowrap='nowrap' width='70%'>".cnVlrMon('', $_tot_all_sum)."</td>
									</tr>
								";
							/* Total abajo */
							
					    ?>
					</table>
				</div>
			<?php
		}elseif($__t2 == "sls_x_week"){

			if( $_ftp != "f_his" ){
			
				if(!isN($__dt_1) && !isN($__dt_2)){ 
					$__fl .= ' AND DATE_FORMAT(orgsdsarrsls_f, "%Y-%m-%d") BETWEEN "'.$__dt_1.'" AND "'.$__dt_2.'" ';
				}elseif(!isN($__dt_1)){
					$__fl .= ' AND DATE_FORMAT(orgsdsarrsls_f, "%Y-%m-%d")  =  "'.$__dt_1.'" ';
				}elseif(!isN($__dt_2)){
					$__fl .= ' AND DATE_FORMAT(orgsdsarrsls_f, "%Y-%m-%d") = "'.$__dt_2.'" ';
				}
			
			}

			if(!isN($_cllcl_lvl)){
				$__fl .= " AND id_org IN ( SELECT id_org FROM "._BdStr(DBM).TB_ORG." 
							INNER JOIN "._BdStr(DBM).TB_ORG_SDS." ON orgsds_org = id_org
							INNER JOIN "._BdStr(DBM).TB_ORG_SDS_ARR." ON orgsdsarr_orgsds = id_orgsds
							INNER JOIN "._BdStr(DBM).TB_CL_LCL." ON orgsdsarr_lcl = id_cllcl WHERE cllcl_lvl = ".$_cllcl_lvl." )";	
			}
	
			if(!isN($_orgtag)){
	
				$__fl .= " AND id_org IN ( SELECT id_org FROM "._BdStr(DBM).TB_ORG." 
							INNER JOIN "._BdStr(DBM).TB_ORG_TAG." ON orgtag_org = id_org
								WHERE orgtag_tag = ".$_orgtag." )";
	
			}

			if(!isN($_orgls)){
				$__fl .= " AND id_org IN ( ".$_orgls." )";	
			}

			$Ls_Cnt_Qry = " SELECT
								id_org, org_nm,
								SUM(CASE WHEN WEEKDAY(orgsdsarrsls_f) = 6 THEN orgsdsarrsls_vl ELSE 0 END) AS D,		 
								SUM(CASE WHEN WEEKDAY(orgsdsarrsls_f) = 0 THEN orgsdsarrsls_vl ELSE 0 END) AS L,
								SUM(CASE WHEN WEEKDAY(orgsdsarrsls_f) = 1 THEN orgsdsarrsls_vl ELSE 0 END) AS M,
								SUM(CASE WHEN WEEKDAY(orgsdsarrsls_f) = 2 THEN orgsdsarrsls_vl ELSE 0 END) AS Mi,
								SUM(CASE WHEN WEEKDAY(orgsdsarrsls_f) = 3 THEN orgsdsarrsls_vl ELSE 0 END) AS J,
								SUM(CASE WHEN WEEKDAY(orgsdsarrsls_f) = 4 THEN orgsdsarrsls_vl ELSE 0 END) AS V,
								SUM(CASE WHEN WEEKDAY(orgsdsarrsls_f) = 5 THEN orgsdsarrsls_vl ELSE 0 END) AS S
							FROM "._BdStr(DBM).TB_ORG."
								INNER JOIN "._BdStr(DBM).TB_ORG_SDS." ON id_org = orgsds_org	
								INNER JOIN "._BdStr(DBM).TB_ORG_SDS_ARR." ON id_orgsds = orgsdsarr_orgsds
								INNER JOIN "._BdStr(DBM).TB_ORG_SDS_ARR_SLS." ON id_orgsdsarr = orgsdsarrsls_arr
							WHERE
								id_orgsdsarrsls != '' AND org_est = 1 AND orgsdsarr_vl_rpt = 2 AND orgsdsarr_vl_mnt = 2 $__fl GROUP BY org_nm
						"; 

			
			$Ls_Cnt_Rg = $__cnx->_qry($Ls_Cnt_Qry);
		
			
			if($Ls_Cnt_Rg){ 
				$row_Ls_Cnt_Rg = $Ls_Cnt_Rg->fetch_assoc(); 
				$Tot_Ls_Cnt_Rg = $Ls_Cnt_Rg->num_rows; 
				if($Tot_Ls_Cnt_Rg > 0){
					do {
						
						//Construye la grafica

						$Vl['ctg']['f']['Domingo'] = 'Domingo';
						$Vl['ctg']['f']['Lunes'] = 'Lunes';
						$Vl['ctg']['f']['Martes'] = 'Martes';
						$Vl['ctg']['f']['Miercoles'] = 'Miercoles';
						$Vl['ctg']['f']['Jueves'] = 'Jueves';
						$Vl['ctg']['f']['Viernes'] = 'Viernes';
						$Vl['ctg']['f']['Sabado'] = 'Sabado';
						
						$Vl['d'][$row_Ls_Cnt_Rg['id_org']]['nm'] = ctjTx($row_Ls_Cnt_Rg['org_nm'], 'in');
						$Vl['d'][$row_Ls_Cnt_Rg['id_org']]['f']['Domingo']['tot'] = $row_Ls_Cnt_Rg['D'];
						$Vl['d'][$row_Ls_Cnt_Rg['id_org']]['f']['Lunes']['tot'] = $row_Ls_Cnt_Rg['L'];
						$Vl['d'][$row_Ls_Cnt_Rg['id_org']]['f']['Martes']['tot'] = $row_Ls_Cnt_Rg['M'];
						$Vl['d'][$row_Ls_Cnt_Rg['id_org']]['f']['Miercoles']['tot'] = $row_Ls_Cnt_Rg['Mi'];
						$Vl['d'][$row_Ls_Cnt_Rg['id_org']]['f']['Jueves']['tot'] = $row_Ls_Cnt_Rg['J'];
						$Vl['d'][$row_Ls_Cnt_Rg['id_org']]['f']['Viernes']['tot'] = $row_Ls_Cnt_Rg['V'];
						$Vl['d'][$row_Ls_Cnt_Rg['id_org']]['f']['Sabado']['tot'] = $row_Ls_Cnt_Rg['S'];
	
					} while ($row_Ls_Cnt_Rg = $Ls_Cnt_Rg->fetch_assoc());
					$Vl_Grph = _jEnc($Vl);
				}
			}

			foreach($Vl_Grph->ctg->f as $k => $v){
				$__ctg[] = '"'.$v.'"';

				foreach($Vl_Grph->d as $_k => $_v){
					$_d[$_k]['nm'] = $_v->nm;
					$_d[$_k]['tot'][] = ( !isN($_v->f->{$v}->tot) ) ? $_v->f->{$v}->tot : 0 ;
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
					id: '#_grph4',
					c: [".$_grph_c."],
					d: [".$_grph_d."],
					tt: 'Ventas', 
					tt_sb: 'Ventas por dia de la semana',
					c_e: false
				});
			";

			?> 
				<div class="__grph <?php echo $_f ?>">
					<?php echo h2('Ventas'); ?>
					<div class="_grph_inf" >
					    <div id="_grph4" class="_grph4"></div>
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
								
								
								foreach($_v->f as $__k => $__v){
									
									if( isN($__v->tot) ){ $__v->tot = 0; }
								    $_td .= " <td nowrap='nowrap' width='70%'>".cnVlrMon('', $__v->tot)."</td> ";
								    
								    $_tot_all = ($_tot_all+$__v->tot);
								    $_tot_all_td[$__k][] = $__v->tot;
								}
							    
							    $_td .= " <td nowrap='nowrap' width='70%'>".cnVlrMon('', $_tot_all)."</td> "; /* Total derecha -> */
							    
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

							   $_tot_all_sum = $_tot_all_sum+$_new_sum;

							   $_td_tot .= "<td nowrap='nowrap' width='70%'>".cnVlrMon('', $_new_sum)."</td>";
						    }
						    
						    echo "
						    		<tr class='Rw_".$_i_nm."'>
							    		<td nowrap='nowrap' class='_sb' width='30%'>Total</td>
								    	$_td_tot
								    	<td nowrap='nowrap' width='70%'>".cnVlrMon('', $_tot_all_sum)."</td>
									</tr>
								";
							/* Total abajo */
							
					    ?>
					</table>
				</div>
			<?php
		}elseif($__t2 == "sls_x_week_2"){

			if( $_ftp != "f_his" ){
			
				if(!isN($__dt_1) && !isN($__dt_2)){ 
					$__fl .= ' AND DATE_FORMAT(orgsdsarrsls_f, "%Y-%m-%d") BETWEEN "'.$__dt_1.'" AND "'.$__dt_2.'" ';
				}elseif(!isN($__dt_1)){
					$__fl .= ' AND DATE_FORMAT(orgsdsarrsls_f, "%Y-%m-%d")  =  "'.$__dt_1.'" ';
				}elseif(!isN($__dt_2)){
					$__fl .= ' AND DATE_FORMAT(orgsdsarrsls_f, "%Y-%m-%d") = "'.$__dt_2.'" ';
				}
			
			}

			if(!isN($_cllcl_lvl)){
				$__fl .= " AND id_org IN ( SELECT id_org FROM "._BdStr(DBM).TB_ORG." 
							INNER JOIN "._BdStr(DBM).TB_ORG_SDS." ON orgsds_org = id_org
							INNER JOIN "._BdStr(DBM).TB_ORG_SDS_ARR." ON orgsdsarr_orgsds = id_orgsds
							INNER JOIN "._BdStr(DBM).TB_CL_LCL." ON orgsdsarr_lcl = id_cllcl WHERE cllcl_lvl = ".$_cllcl_lvl." )";	
			}
	
			if(!isN($_orgtag)){
	
				$__fl .= " AND id_org IN ( SELECT id_org FROM "._BdStr(DBM).TB_ORG." 
							INNER JOIN "._BdStr(DBM).TB_ORG_TAG." ON orgtag_org = id_org
								WHERE orgtag_tag = ".$_orgtag." )";
	
			}

			if(!isN($_orgls)){
				$__fl .= " AND id_org IN ( ".$_orgls." )";	
			}

			$Ls_Cnt_Qry = " SELECT
								id_org,
								SUM(CASE WHEN WEEKDAY(orgsdsarrsls_f) = 6 THEN orgsdsarrsls_vl ELSE 0 END) AS D,		 
								SUM(CASE WHEN WEEKDAY(orgsdsarrsls_f) = 0 THEN orgsdsarrsls_vl ELSE 0 END) AS L,
								SUM(CASE WHEN WEEKDAY(orgsdsarrsls_f) = 1 THEN orgsdsarrsls_vl ELSE 0 END) AS M,
								SUM(CASE WHEN WEEKDAY(orgsdsarrsls_f) = 2 THEN orgsdsarrsls_vl ELSE 0 END) AS Mi,
								SUM(CASE WHEN WEEKDAY(orgsdsarrsls_f) = 3 THEN orgsdsarrsls_vl ELSE 0 END) AS J,
								SUM(CASE WHEN WEEKDAY(orgsdsarrsls_f) = 4 THEN orgsdsarrsls_vl ELSE 0 END) AS V,
								SUM(CASE WHEN WEEKDAY(orgsdsarrsls_f) = 5 THEN orgsdsarrsls_vl ELSE 0 END) AS S
							FROM "._BdStr(DBM).TB_ORG."
								INNER JOIN "._BdStr(DBM).TB_ORG_SDS." ON id_org = orgsds_org	
								INNER JOIN "._BdStr(DBM).TB_ORG_SDS_ARR." ON id_orgsds = orgsdsarr_orgsds
								INNER JOIN "._BdStr(DBM).TB_ORG_SDS_ARR_SLS." ON id_orgsdsarr = orgsdsarrsls_arr
							WHERE
								id_orgsdsarrsls != '' AND org_est = 1 AND orgsdsarr_vl_rpt = 2 $__fl
						"; 

			
			$Ls_Cnt_Rg = $__cnx->_qry($Ls_Cnt_Qry);
		
			
			if($Ls_Cnt_Rg){ 
				$row_Ls_Cnt_Rg = $Ls_Cnt_Rg->fetch_assoc(); 
				$Tot_Ls_Cnt_Rg = $Ls_Cnt_Rg->num_rows; 
				if($Tot_Ls_Cnt_Rg > 0){
					do {
						
						//Construye la grafica

						$Vl['ctg']['f']['Domingo'] = 'Domingo';
						$Vl['ctg']['f']['Lunes'] = 'Lunes';
						$Vl['ctg']['f']['Martes'] = 'Martes';
						$Vl['ctg']['f']['Miercoles'] = 'Miercoles';
						$Vl['ctg']['f']['Jueves'] = 'Jueves';
						$Vl['ctg']['f']['Viernes'] = 'Viernes';
						$Vl['ctg']['f']['Sabado'] = 'Sabado';
						
						$Vl['d'][$row_Ls_Cnt_Rg['id_org']]['nm'] = 'Totales';
						$Vl['d'][$row_Ls_Cnt_Rg['id_org']]['f']['Domingo']['tot'] = $row_Ls_Cnt_Rg['D'];
						$Vl['d'][$row_Ls_Cnt_Rg['id_org']]['f']['Lunes']['tot'] = $row_Ls_Cnt_Rg['L'];
						$Vl['d'][$row_Ls_Cnt_Rg['id_org']]['f']['Martes']['tot'] = $row_Ls_Cnt_Rg['M'];
						$Vl['d'][$row_Ls_Cnt_Rg['id_org']]['f']['Miercoles']['tot'] = $row_Ls_Cnt_Rg['Mi'];
						$Vl['d'][$row_Ls_Cnt_Rg['id_org']]['f']['Jueves']['tot'] = $row_Ls_Cnt_Rg['J'];
						$Vl['d'][$row_Ls_Cnt_Rg['id_org']]['f']['Viernes']['tot'] = $row_Ls_Cnt_Rg['V'];
						$Vl['d'][$row_Ls_Cnt_Rg['id_org']]['f']['Sabado']['tot'] = $row_Ls_Cnt_Rg['S'];

					} while ($row_Ls_Cnt_Rg = $Ls_Cnt_Rg->fetch_assoc());
					$Vl_Grph = _jEnc($Vl);
				}
			}

			foreach($Vl_Grph->ctg->f as $k => $v){
				$__ctg[] = '"'.$v.'"';

				foreach($Vl_Grph->d as $_k => $_v){
					$_d[$_k]['nm'] = $_v->nm;
					$_d[$_k]['tot'][] = ( !isN($_v->f->{$v}->tot) ) ? $_v->f->{$v}->tot : 0 ;
				}
			}

			//Construye los datos
			foreach(_jEnc($_d) as $_k_d => $_v_d){
				$_medio[] = "{ name:\"".$_v_d->nm."\", data:[".implode(',', $_v_d->tot)."] } ";
			}

			$_grph_d = implode(",", $_medio);
			$_grph_c = implode(",", $__ctg);
			
			$CntWb .= "
				SUMR_Grph.f.g1({ 
					id: '#_grph5',
					c: [".$_grph_c."],
					d: [".$_grph_d."],
					tt: 'Ventas', 
					tt_sb: 'Ventas totales por día de la semana',
					c_e: true
				});
			";

			?> 
				<div class="__grph <?php echo $_f ?>">
					<?php echo h2('Ventas'); ?>
					<div class="_grph_inf" >
					    <div id="_grph5" class="_grph5"></div>
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

								foreach($_v->f as $__k => $__v){
									
									if( isN($__v->tot) ){ $__v->tot = 0; }
								    $_td .= " <td nowrap='nowrap' width='70%'>".cnVlrMon('', $__v->tot)."</td> ";
								    
								    $_tot_all = ($_tot_all+$__v->tot);
								    $_tot_all_td[$__k][] = $__v->tot;
								    $_tot_all_sum = ($_tot_all_sum+$_tot);
								}
							    
							    $_td .= " <td nowrap='nowrap' width='70%'>".cnVlrMon('', $_tot_all)."</td> "; /* Total derecha -> */
							    
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
							   $_td_tot .= "<td nowrap='nowrap' width='70%'>".cnVlrMon('', $_new_sum)."</td>";
						    }

					    ?>
					</table>
				</div>
			<?php
		}elseif($__t2 == "sls_x_mes_y"){

			if( $_ftp != "f_his" ){
			
				if(!isN($__dt_1) && !isN($__dt_2)){ 
					$__fl .= ' AND DATE_FORMAT(orgsdsarrsls_f, "%Y-%m-%d") BETWEEN "'.$__dt_1.'" AND "'.$__dt_2.'" ';
				}elseif(!isN($__dt_1)){
					$__fl .= ' AND DATE_FORMAT(orgsdsarrsls_f, "%Y-%m-%d")  =  "'.$__dt_1.'" ';
				}elseif(!isN($__dt_2)){
					$__fl .= ' AND DATE_FORMAT(orgsdsarrsls_f, "%Y-%m-%d") = "'.$__dt_2.'" ';
				}
			
			}

			if(!isN($_cllcl_lvl)){
				$__fl .= " AND id_org IN ( SELECT id_org FROM "._BdStr(DBM).TB_ORG." 
							INNER JOIN "._BdStr(DBM).TB_ORG_SDS." ON orgsds_org = id_org
							INNER JOIN "._BdStr(DBM).TB_ORG_SDS_ARR." ON orgsdsarr_orgsds = id_orgsds
							INNER JOIN "._BdStr(DBM).TB_CL_LCL." ON orgsdsarr_lcl = id_cllcl WHERE cllcl_lvl = ".$_cllcl_lvl." )";	
			}
	
			if(!isN($_orgtag)){
	
				$__fl .= " AND id_org IN ( SELECT id_org FROM "._BdStr(DBM).TB_ORG." 
							INNER JOIN "._BdStr(DBM).TB_ORG_TAG." ON orgtag_org = id_org
								WHERE orgtag_tag = ".$_orgtag." )";
	
			}

			if(!isN($_orgls)){
				$__fl .= " AND id_org IN ( ".$_orgls." )";	
			}

			$Ls_Cnt_Qry = " SELECT
								id_org, org_nm, DATE_FORMAT(orgsdsarrsls_f, '%Y-%m') as mes, SUM(orgsdsarrsls_vl) as tot
							FROM "._BdStr(DBM).TB_ORG."
								INNER JOIN "._BdStr(DBM).TB_ORG_SDS." ON id_org = orgsds_org	
								INNER JOIN "._BdStr(DBM).TB_ORG_SDS_ARR." ON id_orgsds = orgsdsarr_orgsds
								INNER JOIN "._BdStr(DBM).TB_ORG_SDS_ARR_SLS." ON id_orgsdsarr = orgsdsarrsls_arr
							WHERE
							id_org != '' AND orgsdsarr_vl_rpt = 2 AND org_est = 1 $__fl GROUP BY DATE_FORMAT(orgsdsarrsls_f, '%Y-%m'), id_org
						"; 
			
			$Ls_Cnt_Rg = $__cnx->_qry($Ls_Cnt_Qry);


			if($Ls_Cnt_Rg){ 
				$row_Ls_Cnt_Rg = $Ls_Cnt_Rg->fetch_assoc(); 
				$Tot_Ls_Cnt_Rg = $Ls_Cnt_Rg->num_rows; 
				if($Tot_Ls_Cnt_Rg > 0){
					do {
						
						//Construye la grafica
						$Vl['ctg'][$row_Ls_Cnt_Rg['mes']] = $row_Ls_Cnt_Rg['mes'];
						
						$Vl['d'][$row_Ls_Cnt_Rg['id_org']]['nm'] = ctjTx($row_Ls_Cnt_Rg['org_nm'], 'in');
						$Vl['d'][$row_Ls_Cnt_Rg['id_org']]['f'][$row_Ls_Cnt_Rg['mes']]['tot'] = $row_Ls_Cnt_Rg['tot'];
						
						$Vl['ls'][$row_Ls_Cnt_Rg['mes']][$row_Ls_Cnt_Rg['id_org']]['nm'] = ctjTx($row_Ls_Cnt_Rg['org_nm'], 'in');
						$Vl['ls'][$row_Ls_Cnt_Rg['mes']][$row_Ls_Cnt_Rg['id_org']]['tot'] = $row_Ls_Cnt_Rg['tot'];
						
					} while ($row_Ls_Cnt_Rg = $Ls_Cnt_Rg->fetch_assoc());
					$Vl_Grph = _jEnc($Vl);
				}
			}

			
			
			foreach($Vl_Grph->ctg as $k => $v){	
				$__ctg[] = '"'.$k.'"';
				
				foreach($Vl_Grph->d as $_k => $_v){
					$_d[$_k]['nm'] = $_v->nm;
					$_d[$_k]['tot'][] = ( !isN($_v->f->{$k}->tot) ) ? $_v->f->{$k}->tot : 0 ;
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
					id: '#_grph6',
					c: [".$_grph_c."],
					d: [".$_grph_d."],
					tt: 'Ventas', 
					tt_sb: 'Ventas por mes totales',
					c_e: false
				});
			";
			
			?>
				<div class="__grph <?php echo $_f ?>">
					<?php echo h2('Ventas'); ?>
					<div class="_grph_inf" >
						<div id="_grph6" class="_grph6"></div>
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
									$_td .= " <td nowrap='nowrap' width='70%'>".cnVlrMon('', $_tot)."</td> ";
									
									$_tot_all = ($_tot_all+$_tot);
									$_tot_all_td[$_v_c][] = $_tot;
									$_tot_all_sum = ($_tot_all_sum+$_tot);
									
								}
								
								$_td .= " <td nowrap='nowrap' width='70%'>".cnVlrMon('', $_tot_all)."</td> "; /* Total derecha -> */
								
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
								$_td_tot .= "<td nowrap='nowrap' width='70%'>".cnVlrMon('', $_new_sum)."</td>";
							}
							
							echo "
									<tr class='Rw_".$_i_nm."'>
										<td nowrap='nowrap' class='_sb' width='30%'>Total</td>
										$_td_tot
										<td nowrap='nowrap' width='70%'>".cnVlrMon('', $_tot_all_sum)."</td>
									</tr>
								";
							/* Total abajo */
							
						?>
					</table>
				</div>
			<?php
		}elseif($__t2 == "sls_x_mes_y_2"){

			if( $_ftp != "f_his" ){
			
				if(!isN($__dt_1) && !isN($__dt_2)){ 
					$__fl .= ' AND DATE_FORMAT(orgsdsarrsls_f, "%Y-%m-%d") BETWEEN "'.$__dt_1.'" AND "'.$__dt_2.'" ';
				}elseif(!isN($__dt_1)){
					$__fl .= ' AND DATE_FORMAT(orgsdsarrsls_f, "%Y-%m-%d")  =  "'.$__dt_1.'" ';
				}elseif(!isN($__dt_2)){
					$__fl .= ' AND DATE_FORMAT(orgsdsarrsls_f, "%Y-%m-%d") = "'.$__dt_2.'" ';
				}
			
			}

			if(!isN($_cllcl_lvl)){
				$__fl .= " AND id_org IN ( SELECT id_org FROM "._BdStr(DBM).TB_ORG." 
							INNER JOIN "._BdStr(DBM).TB_ORG_SDS." ON orgsds_org = id_org
							INNER JOIN "._BdStr(DBM).TB_ORG_SDS_ARR." ON orgsdsarr_orgsds = id_orgsds
							INNER JOIN "._BdStr(DBM).TB_CL_LCL." ON orgsdsarr_lcl = id_cllcl WHERE cllcl_lvl = ".$_cllcl_lvl." )";	
			}
	
			if(!isN($_orgtag)){
	
				$__fl .= " AND id_org IN ( SELECT id_org FROM "._BdStr(DBM).TB_ORG." 
							INNER JOIN "._BdStr(DBM).TB_ORG_TAG." ON orgtag_org = id_org
								WHERE orgtag_tag = ".$_orgtag." )";
	
			}

			if(!isN($_orgls)){
				$__fl .= " AND id_org IN ( ".$_orgls." )";	
			}


			$Ls_Cnt_Qry .= "SELECT id_org, 
								DATE_FORMAT(orgsdsarrsls_f, '%Y-%m') AS mes, SUM(orgsdsarrsls_vl) AS tot
							FROM "._BdStr(DBM).TB_ORG."
								INNER JOIN "._BdStr(DBM).TB_ORG_SDS." ON id_org = orgsds_org	
								INNER JOIN "._BdStr(DBM).TB_ORG_SDS_ARR." ON id_orgsds = orgsdsarr_orgsds
								INNER JOIN "._BdStr(DBM).TB_ORG_SDS_ARR_SLS." ON id_orgsdsarr = orgsdsarrsls_arr
							WHERE
							id_org != '' AND orgsdsarr_vl_rpt = 2 AND org_est = 1 $__fl GROUP BY DATE_FORMAT(orgsdsarrsls_f, '%Y-%m');
						"; 

			$Ls_Cnt_Rg = $__cnx->_qry($Ls_Cnt_Qry);

			if($Ls_Cnt_Rg){ 
				$row_Ls_Cnt_Rg = $Ls_Cnt_Rg->fetch_assoc(); 
				$Tot_Ls_Cnt_Rg = $Ls_Cnt_Rg->num_rows; 
				if($Tot_Ls_Cnt_Rg > 0){
					do {
						
						//Construye la grafica
						$Vl['ctg'][$row_Ls_Cnt_Rg['mes']] = $row_Ls_Cnt_Rg['mes'];
						
						$Vl['d']['m_a']['nm'] = 'Total';
						$Vl['d']['m_a']['f'][$row_Ls_Cnt_Rg['mes']]['tot'] = $row_Ls_Cnt_Rg['tot'];
						
						$Vl['ls'][$row_Ls_Cnt_Rg['mes']]['m_a']['nm'] = 'Total';
						$Vl['ls'][$row_Ls_Cnt_Rg['mes']]['m_a']['tot'] = $row_Ls_Cnt_Rg['tot'];
						
					} while ($row_Ls_Cnt_Rg = $Ls_Cnt_Rg->fetch_assoc());
					$Vl_Grph = _jEnc($Vl);
				}
			}

			
			
			foreach($Vl_Grph->ctg as $k => $v){	
				$__ctg[] = '"'.$v.'"';
				$__ctgs[] = '"'.FechaESP_OLD($v, 10).'"';

				foreach($Vl_Grph->d as $_k => $_v){
					$_d[$_k]['nm'] = $_v->nm;
					$_d[$_k]['tot'][] = ( !isN($_v->f->{$k}->tot) ) ? $_v->f->{$k}->tot : 0 ;
				}
				
			}

			//Construye los datos
			foreach(_jEnc($_d) as $_k_d => $_v_d){
				$_medio[] = "{ name:\"".$_v_d->nm."\", data:[".implode(',', $_v_d->tot)."] } ";
			}
			
			$_grph_d = implode(",", $_medio);
			$_grph_c = implode(",", $__ctgs);
			
			$CntWb .= "
				SUMR_Grph.f.g1({ 
					id: '#_grph7',
					c: [".$_grph_c."],
					d: [".$_grph_d."],
					tt: 'Ventas', 
					tt_sb: 'Ventas por mes y año',
					c_e: true,
					ttip_frmt:function(d){
                        if(!isN(d) && !isN(d.point)){
							return '$' + Highcharts.numberFormat(d.y, 0, ',', '.');
                        }
					},
				});
			";
			
			?>
				<div class="__grph <?php echo $_f ?>">
					<?php echo h2('Ventas'); ?>
					<div class="_grph_inf" >
						<div id="_grph7" class="_grph7"></div>
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
									$_td .= " <td nowrap='nowrap' width='70%'>".cnVlrMon('', $_tot)."</td> ";
									
									$_tot_all = ($_tot_all+$_tot);
									$_tot_all_td[$_v_c][] = $_tot;
									$_tot_all_sum = ($_tot_all_sum+$_tot);
									
								}
								
								$_td .= " <td nowrap='nowrap' width='70%'>".cnVlrMon('', $_tot_all)."</td> "; /* Total derecha -> */
								
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
		}elseif($__t2 == "sls_esf"){

			if( $_ftp != "f_his" ){

				if(!isN($__dt_1) && !isN($__dt_2)){ 
					$__fl_f .= ' AND DATE_FORMAT(orgsdsarrrg_f, "%Y-%m-%d") BETWEEN "'.$__dt_1.'" AND "'.$__dt_2.'" ';
					$__fl .= ' AND DATE_FORMAT(orgsdsarrsls_f, "%Y-%m-%d") BETWEEN "'.$__dt_1.'" AND "'.$__dt_2.'" ';
				}elseif(!isN($__dt_1)){
					$__fl_f .= ' AND DATE_FORMAT(orgsdsarrrg_f, "%Y-%m-%d")  =  "'.$__dt_1.'" ';
					$__fl .= ' AND DATE_FORMAT(orgsdsarrsls_f, "%Y-%m-%d")  =  "'.$__dt_1.'" ';
				}elseif(!isN($__dt_2)){
					$__fl_f .= ' AND DATE_FORMAT(orgsdsarrrg_f, "%Y-%m-%d") = "'.$__dt_2.'" ';
					$__fl .= ' AND DATE_FORMAT(orgsdsarrsls_f, "%Y-%m-%d") = "'.$__dt_2.'" ';
				}
			
			}

			if(!isN($_cllcl_lvl)){
				$__fl .= " AND id_org IN ( SELECT id_org FROM "._BdStr(DBM).TB_ORG." 
							INNER JOIN "._BdStr(DBM).TB_ORG_SDS." ON orgsds_org = id_org
							INNER JOIN "._BdStr(DBM).TB_ORG_SDS_ARR." ON orgsdsarr_orgsds = id_orgsds
							INNER JOIN "._BdStr(DBM).TB_CL_LCL." ON orgsdsarr_lcl = id_cllcl WHERE cllcl_lvl = ".$_cllcl_lvl." )";	
			}
	
			if(!isN($_orgtag)){
	
				$__fl .= " AND id_org IN ( SELECT id_org FROM "._BdStr(DBM).TB_ORG." 
							INNER JOIN "._BdStr(DBM).TB_ORG_TAG." ON orgtag_org = id_org
								WHERE orgtag_tag = ".$_orgtag." )";
	
			}

			if(!isN($_orgls)){
				$__fl .= " AND id_org IN ( ".$_orgls." )";	
			}


			$Ls_Cnt_Qry .= "SELECT id_org, org_nm, org_clr, SUM(orgsdsarrrg_vl) AS vl,  SUM(orgsdsarrrg_vl_adm) AS vl_adm
							FROM "._BdStr(DBM).TB_ORG."
								INNER JOIN "._BdStr(DBM).TB_ORG_SDS." ON id_org = orgsds_org	
								INNER JOIN "._BdStr(DBM).TB_ORG_SDS_ARR." ON id_orgsds = orgsdsarr_orgsds
								INNER JOIN "._BdStr(DBM).TB_ORG_SDS_ARR_RG." ON id_orgsdsarr = orgsdsarrrg_arr
							WHERE
							id_org != '' AND orgsdsarr_vl_rpt = 2 AND org_est = 1 $__fl_f GROUP BY id_orgsds ORDER BY org_nm
						"; 

			$Ls_Cnt_Rg = $__cnx->_qry($Ls_Cnt_Qry);

			if($Ls_Cnt_Rg){ 
				$row_Ls_Cnt_Rg = $Ls_Cnt_Rg->fetch_assoc(); 
				$Tot_Ls_Cnt_Rg = $Ls_Cnt_Rg->num_rows; 
				if($Tot_Ls_Cnt_Rg > 0){
					do {
						
						//Construye la grafica
						$Vl['ls'][$row_Ls_Cnt_Rg['id_org']]['id'] = ctjTx($row_Ls_Cnt_Rg['id_org'], 'in');
						$Vl['ls'][$row_Ls_Cnt_Rg['id_org']]['nm'] = ctjTx($row_Ls_Cnt_Rg['org_nm'], 'in');
						$Vl['ls'][$row_Ls_Cnt_Rg['id_org']]['clr'] = ctjTx($row_Ls_Cnt_Rg['org_clr'], 'in');
						$Vl['ls'][$row_Ls_Cnt_Rg['id_org']]['vl'] = $row_Ls_Cnt_Rg['vl'];
						$Vl['ls'][$row_Ls_Cnt_Rg['id_org']]['vl_adm'] = $row_Ls_Cnt_Rg['vl_adm'];
						
					} while ($row_Ls_Cnt_Rg = $Ls_Cnt_Rg->fetch_assoc());

					$Vl_Grph = _jEnc($Vl);
				}
			}

			$Ls_Cnt_Qry_2 .= "SELECT id_org, org_nm, org_clr, SUM(orgsdsarrsls_vl) AS vl_sls
							FROM "._BdStr(DBM).TB_ORG."
								INNER JOIN "._BdStr(DBM).TB_ORG_SDS." ON id_org = orgsds_org	
								INNER JOIN "._BdStr(DBM).TB_ORG_SDS_ARR." ON id_orgsds = orgsdsarr_orgsds
								INNER JOIN "._BdStr(DBM).TB_ORG_SDS_ARR_SLS." ON id_orgsdsarr = orgsdsarrsls_arr
							WHERE
							id_org != '' AND orgsdsarr_vl_rpt = 2 AND org_est = 1 $__fl GROUP BY id_orgsds
						"; 

			$Ls_Cnt_Rg_2 = $__cnx->_qry($Ls_Cnt_Qry_2);

			if($Ls_Cnt_Rg_2){ 
				$row_Ls_Cnt_Rg_2 = $Ls_Cnt_Rg_2->fetch_assoc(); 
				$Tot_Ls_Cnt_Rg_2 = $Ls_Cnt_Rg_2->num_rows; 
				if($Tot_Ls_Cnt_Rg_2 > 0){
					do {
						
						$Vl_2['ls'][$row_Ls_Cnt_Rg_2['id_org']]['nm'] = ctjTx($row_Ls_Cnt_Rg_2['org_nm'], 'in');
						$Vl_2['ls'][$row_Ls_Cnt_Rg_2['id_org']]['vl_sls'] = $row_Ls_Cnt_Rg_2['vl_sls'];
						
					} while ($row_Ls_Cnt_Rg_2 = $Ls_Cnt_Rg_2->fetch_assoc());

					$Vl_Grph_2 = _jEnc($Vl_2);
				}
			}

			foreach($Vl_Grph->ls as $k => $v){
				$__tot = $v->vl + $v->vl_adm;
				$__tots = $Vl_Grph_2->ls->{$k}->vl_sls;


				if(!isN($__tots)){

					$_rel = ($__tot / $__tots)*100;

					$_mark[] = "{ 
						name:\"".ctjTx($v->nm,'in')."\",   
						data:[{
							y:". number_format($_rel, 0, '.', '') .",
						}], 
						color:'".$v->clr."' 
					} "; 

					$_Vl['ls'][$v->id]['nm'] = $v->nm;
					$_Vl['ls'][$v->id]['tot'] = $_rel;
					$_Vl['ls'][$v->id]['vl'] = $v->vl;
					$_Vl['ls'][$v->id]['vl_adm'] = $v->vl_adm;
					$_Vl['ls'][$v->id]['tot_arr'] = $__tot;
					$_Vl['ls'][$v->id]['sls'] = $__tots;

				}

			}

			$_grph_tag = implode(",", $_mark);

			$CntWb .= "

				(function (H) {
					H.wrap(H.Tick.prototype, 'render', function (p, index, old, opacity) {
					p.call(this, index, old, opacity);
					var gridLine = this.gridLine;
					
					if (!this.axis.horiz && this.pos == 30 && gridLine) {
						gridLine.attr({
							stroke: 'red'
						});
					}
				});
				})(Highcharts);


                SUMR_Grph.f.g1({ 
					id: '#_grph8',
                    d: [".$_grph_tag."],
                    tt: 'Esfuerzo por marca', 
					c_e: false,
                    ttip_frmt:function(d){
                        if(!isN(d) && !isN(d.point)){
							return '<b>'+d.series.name+': </b>' + Highcharts.numberFormat(d.y, 0, ',', '.') +'%';
                        }
					},
                    plot_dl_uhtml: true,
                    plot_dl_allwovlp: true,
                    plot_dl_y: -5,
                    plot_dl_frmt:function(d){
                        if(!isN(d) && !isN(d.point)){
                            
                            var point = d.point;

                            window.setTimeout(function () {
                                point.dataLabel.attr({
                                    y: point.plotY - 50
                                });
                            });

                            return '$ ' + Highcharts.numberFormat(d.y, 0, ',', '.') + '<br><br><div class=\"HiChrt_Logo_Th\"><div class=\"_imgf\" style=\"background-image:url(' + d.point.logo + ');margin-left:auto;margin-right:auto;\"></div></div>';

                        }
                    },
                    plot_dl_gpdng:0
                });
			";
			
			?>
				<div class="__grph <?php echo $_f ?>">
					<?php echo h2('Esfuerzo por marca'); ?>
					<div class="_grph_inf" >
					    <div id="_grph8" class="_grph8"></div>
					</div>
					
					<table width="100%" border="0" cellpadding="0" cellspacing="0" class="Ls_Rg _grph_tb"> 
				    	<tr>
					    	<th nowrap="nowrap" class="_sb" width="30%"><?php echo 'Mes y Año' ?></th>
							<th nowrap="nowrap" class="_sb" width="15%"><?php echo 'Arriendo' ?></th>
							<th nowrap="nowrap" class="_sb" width="15%"><?php echo 'Administración' ?></th>
							<th nowrap="nowrap" class="_sb" width="15%"><?php echo 'Total arriendo' ?></th>
							<th nowrap="nowrap" class="_sb" width="15%"><?php echo 'Total ventas' ?></th>
				    	    <th nowrap="nowrap" width="10%"><?php echo 'Esfuerzo' ?></th>
					    </tr>
					    <?php 
						    $_i_nm = 1;
						    foreach($_Vl['ls'] as $_k => $_v){
							    echo "
							    	<tr class='Rw_".$_i_nm."'>
										<td nowrap='nowrap' class='_sb' width='30%'>".$_v['nm']."</td>
										<td nowrap='nowrap' width='15%'>".cnVlrMon('', $_v['vl'])."</td>
										<td nowrap='nowrap' width='15%'>".cnVlrMon('', $_v['vl_adm'])."</td>
										<td nowrap='nowrap' width='15%'>".cnVlrMon('', $_v['tot_arr'])."</td>
										<td nowrap='nowrap' width='15%'>".cnVlrMon('', $_v['sls'])."</td>
								    	<td nowrap='nowrap' width='10%'>".number_format($_v['tot'],0)."%</td>
									</tr>
								";

								$_tot_1 += $_v['vl'];
								$_tot_2 += $_v['vl_adm'];
								$_tot_3 += $_v['tot_arr'];
								$_tot_4 += $_v['sls'];

							    if($_i_nm == 1){ $_i_nm = 2; }else{ $_i_nm = 1; }
							}
							
							$_tot_p = ( $_tot_3/$_tot_4 ) * 100;

						    echo "
						    		<tr class='Rw_".$_i_nm."'>
							    		<td nowrap='nowrap' class='_sb' width='30%'>Total</td>
										<td nowrap='nowrap' width='15%'> ".cnVlrMon('', $_tot_1)."</td>
										<td nowrap='nowrap' width='15%'> ".cnVlrMon('', $_tot_2)."</td>
										<td nowrap='nowrap' width='15%'> ".cnVlrMon('', $_tot_3)."</td>
										<td nowrap='nowrap' width='15%'> ".cnVlrMon('', $_tot_4)."</td>
								    	<td nowrap='nowrap' width='10%'> ".number_format($_tot_p, 0)."%</td>
									</tr>
								";
					    ?>
					</table>
				</div>
			<?php

		}elseif($__t2 == "sls_esf_x_mes"){

			if( $_ftp != "f_his" ){
			
				if(!isN($__dt_1) && !isN($__dt_2)){ 
					$__fl_sls .= ' AND DATE_FORMAT(orgsdsarrsls_f, "%Y-%m-%d") BETWEEN "'.$__dt_1.'" AND "'.$__dt_2.'" ';
					$__fl_rg .= ' AND DATE_FORMAT(orgsdsarrrg_f, "%Y-%m-%d") BETWEEN "'.$__dt_1.'" AND "'.$__dt_2.'" ';
				}elseif(!isN($__dt_1)){
					$__fl_sls .= ' AND DATE_FORMAT(orgsdsarrsls_f, "%Y-%m-%d")  =  "'.$__dt_1.'" ';
					$__fl_rg .= ' AND DATE_FORMAT(orgsdsarrrg_f, "%Y-%m-%d")  =  "'.$__dt_1.'" ';
				}elseif(!isN($__dt_2)){
					$__fl_sls .= ' AND DATE_FORMAT(orgsdsarrsls_f, "%Y-%m-%d") = "'.$__dt_2.'" ';
					$__fl_rg .= ' AND DATE_FORMAT(orgsdsarrrg_f, "%Y-%m-%d") = "'.$__dt_2.'" ';
				}
			
			}

			if(!isN($_cllcl_lvl)){
				$__fl .= " AND id_org IN ( SELECT id_org FROM "._BdStr(DBM).TB_ORG." 
							INNER JOIN "._BdStr(DBM).TB_ORG_SDS." ON orgsds_org = id_org
							INNER JOIN "._BdStr(DBM).TB_ORG_SDS_ARR." ON orgsdsarr_orgsds = id_orgsds
							INNER JOIN "._BdStr(DBM).TB_CL_LCL." ON orgsdsarr_lcl = id_cllcl WHERE cllcl_lvl = ".$_cllcl_lvl." )";	
			}
	
			if(!isN($_orgtag)){
	
				$__fl .= " AND id_org IN ( SELECT id_org FROM "._BdStr(DBM).TB_ORG." 
							INNER JOIN "._BdStr(DBM).TB_ORG_TAG." ON orgtag_org = id_org
								WHERE orgtag_tag = ".$_orgtag." )";
	
			}

			if(!isN($_orgls)){
				$__fl .= " AND id_org IN ( ".$_orgls." )";	
			}


			$Ls_Cnt_Qry .= "SELECT id_org, 
								DATE_FORMAT(orgsdsarrrg_f, '%Y-%m') AS mes, SUM( orgsdsarrrg_vl ) AS vl, SUM( orgsdsarrrg_vl_adm ) AS vl_adm
							FROM "._BdStr(DBM).TB_ORG."
								INNER JOIN "._BdStr(DBM).TB_ORG_SDS." ON id_org = orgsds_org	
								INNER JOIN "._BdStr(DBM).TB_ORG_SDS_ARR." ON id_orgsds = orgsdsarr_orgsds
								INNER JOIN "._BdStr(DBM).TB_ORG_SDS_ARR_RG." ON id_orgsdsarr = orgsdsarrrg_arr
							WHERE
							id_org != '' AND orgsdsarr_vl_rpt = 2 AND org_est = 1 $__fl_rg $__fl GROUP BY DATE_FORMAT(orgsdsarrrg_f, '%Y-%m')
						"; 

			$Ls_Cnt_Rg = $__cnx->_qry($Ls_Cnt_Qry);

			if($Ls_Cnt_Rg){ 
				$row_Ls_Cnt_Rg = $Ls_Cnt_Rg->fetch_assoc(); 
				$Tot_Ls_Cnt_Rg = $Ls_Cnt_Rg->num_rows; 
				if($Tot_Ls_Cnt_Rg > 0){
					do {
						
						//Construye la grafica
						$Vl['ctg'][$row_Ls_Cnt_Rg['mes']] = $row_Ls_Cnt_Rg['mes'];
						
						$Vl['d']['m_a']['nm'] = 'Total';
						$Vl['d']['m_a']['f'][$row_Ls_Cnt_Rg['mes']]['vl_adm'] = number_format($row_Ls_Cnt_Rg['vl_adm'], 0, '.', '');
						$Vl['d']['m_a']['f'][$row_Ls_Cnt_Rg['mes']]['vl'] = number_format($row_Ls_Cnt_Rg['vl'], 0, '.', '');

						$Vl['ls'][$row_Ls_Cnt_Rg['mes']]['m_a']['nm'] = 'Total';
						$Vl['ls'][$row_Ls_Cnt_Rg['mes']]['m_a']['tot'] = $row_Ls_Cnt_Rg['tot'];
						
					} while ($row_Ls_Cnt_Rg = $Ls_Cnt_Rg->fetch_assoc());
					$Vl_Grph = _jEnc($Vl);
				}
			}

			$Ls_Cnt_Qry_2 .= "SELECT id_org, 
								DATE_FORMAT(orgsdsarrsls_f, '%Y-%m') AS mes, SUM( orgsdsarrsls_vl ) AS vl
							FROM "._BdStr(DBM).TB_ORG."
								INNER JOIN "._BdStr(DBM).TB_ORG_SDS." ON id_org = orgsds_org	
								INNER JOIN "._BdStr(DBM).TB_ORG_SDS_ARR." ON id_orgsds = orgsdsarr_orgsds
								INNER JOIN "._BdStr(DBM).TB_ORG_SDS_ARR_SLS." ON id_orgsdsarr = orgsdsarrsls_arr
							WHERE
							id_org != '' AND orgsdsarr_vl_rpt = 2 AND org_est = 1 $__fl GROUP BY DATE_FORMAT(orgsdsarrsls_f, '%Y-%m')
						"; 

			$Ls_Cnt_Rg_2 = $__cnx->_qry($Ls_Cnt_Qry_2);

			if($Ls_Cnt_Rg_2){ 
				$row_Ls_Cnt_Rg_2 = $Ls_Cnt_Rg_2->fetch_assoc(); 
				$Tot_Ls_Cnt_Rg_2 = $Ls_Cnt_Rg_2->num_rows; 
				if($Tot_Ls_Cnt_Rg_2 > 0){
					do {
						
						//Construye la grafica
						$Vl_2['ctg'][$row_Ls_Cnt_Rg_2['mes']] = $row_Ls_Cnt_Rg_2['mes'];
						
						$Vl_2['d']['m_a']['nm'] = 'Total';
						$Vl_2['d']['m_a']['f'][$row_Ls_Cnt_Rg_2['mes']]['tot'] = number_format($row_Ls_Cnt_Rg_2['vl'], 0, '.', '');
						
						$Vl_2['ls'][$row_Ls_Cnt_Rg_2['mes']]['m_a']['nm'] = 'Total';
						$Vl_2['ls'][$row_Ls_Cnt_Rg_2['mes']]['m_a']['tot'] = $row_Ls_Cnt_Rg_2['tot'];
						
					} while ($row_Ls_Cnt_Rg_2 = $Ls_Cnt_Rg_2->fetch_assoc());
					$Vl_Grph_2 = _jEnc($Vl_2);
				}
			}

			foreach($Vl_Grph->ctg as $k => $v){	
				

				foreach($Vl_Grph->d as $_k => $_v){
					$_d[$_k]['nm'] = $_v->nm;

					$__tot = $_v->f->{$k}->vl + $_v->f->{$k}->vl_adm;
					$__tots = $Vl_Grph_2->d->m_a->f->{$v}->tot;

					if($__tots > 0){
						$_rel = ($__tot / $__tots)*100;

						$_d[$_k]['tot'][] = number_format($_rel, 0, '.', '');

						$__Vl['ls'][$v]['tot'] = number_format($_rel, 0, '.', '');
						$__Vl['ls'][$v]['vl'] = number_format($_v->f->{$k}->vl, 0, '.', '');
						$__Vl['ls'][$v]['vl_adm'] = number_format($_v->f->{$k}->vl_adm, 0, '.', '');
						$__Vl['ls'][$v]['tot_arr'] = number_format($__tot, 0, '.', '');
						$__Vl['ls'][$v]['sls'] = number_format($__tots, 0, '.', '');

						$__ctg[] = '"'.$v.'"';
						$__ctgs[] = '"'.FechaESP_OLD($v, 10).'"';
					}

				}
			}

			$_Vl_Ls = _jEnc($__Vl);

			//Construye los datos
			foreach(_jEnc($_d) as $_k_d => $_v_d){
				$_medio[] = "{ name:\"".$_v_d->nm."\", data:[".implode(',', $_v_d->tot)."] } ";
			}
			
			$_grph_d = implode(",", $_medio);
			$_grph_c = implode(",", $__ctgs);
			
			$CntWb .= "
				SUMR_Grph.f.g1({ 
					id: '#_grph9',
					c: [".$_grph_c."],
					d: [".$_grph_d."],
					tt: 'Esfuerzo por mes', 
					tt_sb: 'General',
					c_e: true,
					ttip_frmt:function(d){
                        if(!isN(d) && !isN(d.point)){
							return '' + Highcharts.numberFormat(d.y, 0, ',', '.')+'%';
                        }
					},
				});
			";
			
			?>
				<div class="__grph <?php echo $_f ?>">
					<?php echo h2('Esfuerzo'); ?>
					<div class="_grph_inf" >
						<div id="_grph9" class="_grph9"></div>
					</div>
					
					<table width="100%" border="0" cellpadding="0" cellspacing="0" id="_grph_tb" class="Ls_Rg _grph_tb">
						<tr>
							<th nowrap="nowrap" class="_sb" width="30%"><?php echo 'Marca' ?></th>
							<th nowrap="nowrap" class="_sb" width="15%"><?php echo 'Arriendo' ?></th>
							<th nowrap="nowrap" class="_sb" width="15%"><?php echo 'Administración' ?></th>
							<th nowrap="nowrap" class="_sb" width="15%"><?php echo 'Total arriendo' ?></th>
							<th nowrap="nowrap" class="_sb" width="15%"><?php echo 'Total ventas' ?></th>
				    	    <th nowrap="nowrap" width="10%"><?php echo 'Esfuerzo' ?></th>
						</tr>
						<?php 

							foreach($__ctg as $_k_c => $_v_c){

								$_tt = str_replace('"', "", $_v_c);

								echo "<tr>";

									echo "<td nowrap='nowrap' class='_sb' width='30%'>".FechaESP_OLD($_tt, 10)."</td>";
									echo "<td nowrap='nowrap' class='_sb' width='15%'>".cnVlrMon('', $_Vl_Ls->ls->{$_tt}->vl)."</td>";
									echo "<td nowrap='nowrap' class='_sb' width='15%'>".cnVlrMon('', $_Vl_Ls->ls->{$_tt}->vl_adm)."</td>";
									echo "<td nowrap='nowrap' class='_sb' width='15%'>".cnVlrMon('', $_Vl_Ls->ls->{$_tt}->tot_arr)."</td>";
									echo "<td nowrap='nowrap' class='_sb' width='15%'>".cnVlrMon('', $_Vl_Ls->ls->{$_tt}->sls)."</td>";
									echo "<td nowrap='nowrap' class='_sb' width='10%'>".$_Vl_Ls->ls->{$_tt}->tot."%</td>";

								echo '</tr>';

								$_tot_1 += $_Vl_Ls->ls->{$_tt}->vl;
								$_tot_2 += $_Vl_Ls->ls->{$_tt}->vl_adm;
								$_tot_3 += $_Vl_Ls->ls->{$_tt}->tot_arr;
								$_tot_4 += $_Vl_Ls->ls->{$_tt}->sls;

							}

						?>
						<?php
							
							$_tot_p = ( $_tot_3/$_tot_4 ) * 100;

						    echo "
						    		<tr class='Rw_".$_i_nm."'>
							    		<td nowrap='nowrap' class='_sb' width='30%'>Total</td>
										<td nowrap='nowrap' width='15%'> ".cnVlrMon('', $_tot_1)."</td>
										<td nowrap='nowrap' width='15%'> ".cnVlrMon('', $_tot_2)."</td>
										<td nowrap='nowrap' width='15%'> ".cnVlrMon('', $_tot_3)."</td>
										<td nowrap='nowrap' width='15%'> ".cnVlrMon('', $_tot_4)."</td>
								    	<td nowrap='nowrap' width='10%'> ".number_format($_tot_p, 0)."%</td>
									</tr>
								";		
						?>
					</table>
				</div>
			<?php
		}elseif($__t2 == "sls_tck"){

			if( $_ftp != "f_his" ){

				if(!isN($__dt_1) && !isN($__dt_2)){ 
					$__fl_f .= ' AND DATE_FORMAT(orgsdsarrrg_f, "%Y-%m-%d") BETWEEN "'.$__dt_1.'" AND "'.$__dt_2.'" ';
					$__fl .= ' AND DATE_FORMAT(orgsdsarrsls_f, "%Y-%m-%d") BETWEEN "'.$__dt_1.'" AND "'.$__dt_2.'" ';
				}elseif(!isN($__dt_1)){
					$__fl_f .= ' AND DATE_FORMAT(orgsdsarrrg_f, "%Y-%m-%d")  =  "'.$__dt_1.'" ';
					$__fl .= ' AND DATE_FORMAT(orgsdsarrsls_f, "%Y-%m-%d")  =  "'.$__dt_1.'" ';
				}elseif(!isN($__dt_2)){
					$__fl_f .= ' AND DATE_FORMAT(orgsdsarrrg_f, "%Y-%m-%d") = "'.$__dt_2.'" ';
					$__fl .= ' AND DATE_FORMAT(orgsdsarrsls_f, "%Y-%m-%d") = "'.$__dt_2.'" ';
				}
			
			}

			if(!isN($_cllcl_lvl)){
				$__fl .= " AND id_org IN ( SELECT id_org FROM "._BdStr(DBM).TB_ORG." 
							INNER JOIN "._BdStr(DBM).TB_ORG_SDS." ON orgsds_org = id_org
							INNER JOIN "._BdStr(DBM).TB_ORG_SDS_ARR." ON orgsdsarr_orgsds = id_orgsds
							INNER JOIN "._BdStr(DBM).TB_CL_LCL." ON orgsdsarr_lcl = id_cllcl WHERE cllcl_lvl = ".$_cllcl_lvl." )";	
			}
	
			if(!isN($_orgtag)){
	
				$__fl .= " AND id_org IN ( SELECT id_org FROM "._BdStr(DBM).TB_ORG." 
							INNER JOIN "._BdStr(DBM).TB_ORG_TAG." ON orgtag_org = id_org
								WHERE orgtag_tag = ".$_orgtag." )";
	
			}

			if(!isN($_orgls)){
				$__fl .= " AND id_org IN ( ".$_orgls." )";	
			}

			$Ls_Cnt_Qry_2 .= "SELECT id_org, org_nm, org_clr, SUM(orgsdsarrsls_vl) AS vl_sls, SUM(orgsdsarrsls_trs) AS trs
							FROM "._BdStr(DBM).TB_ORG."
								INNER JOIN "._BdStr(DBM).TB_ORG_SDS." ON id_org = orgsds_org	
								INNER JOIN "._BdStr(DBM).TB_ORG_SDS_ARR." ON id_orgsds = orgsdsarr_orgsds
								INNER JOIN "._BdStr(DBM).TB_ORG_SDS_ARR_SLS." ON id_orgsdsarr = orgsdsarrsls_arr
							WHERE
							id_org != '' AND orgsdsarr_vl_rpt = 2 AND org_est = 1 $__fl GROUP BY id_orgsds
						"; 

			$Ls_Cnt_Rg_2 = $__cnx->_qry($Ls_Cnt_Qry_2);

			if($Ls_Cnt_Rg_2){ 
				$row_Ls_Cnt_Rg_2 = $Ls_Cnt_Rg_2->fetch_assoc(); 
				$Tot_Ls_Cnt_Rg_2 = $Ls_Cnt_Rg_2->num_rows; 
				if($Tot_Ls_Cnt_Rg_2 > 0){
					do {

						if(!isN($row_Ls_Cnt_Rg_2['trs']) && $row_Ls_Cnt_Rg_2['trs'] > 0){
							$Vl_2['ls'][$row_Ls_Cnt_Rg_2['id_org']]['nm'] = ctjTx($row_Ls_Cnt_Rg_2['org_nm'], 'in');
							$Vl_2['ls'][$row_Ls_Cnt_Rg_2['id_org']]['vl_sls'] = number_format($row_Ls_Cnt_Rg_2['vl_sls'], 0, '.', '');
							$Vl_2['ls'][$row_Ls_Cnt_Rg_2['id_org']]['trs'] = number_format($row_Ls_Cnt_Rg_2['trs'], 0, '.', '');
							$Vl_2['ls'][$row_Ls_Cnt_Rg_2['id_org']]['clr'] = ctjTx($row_Ls_Cnt_Rg_2['org_clr'], 'in');
						}
						
						
						
					} while ($row_Ls_Cnt_Rg_2 = $Ls_Cnt_Rg_2->fetch_assoc());

					$Vl_Grph_2 = _jEnc($Vl_2);
				}
			}

			foreach($Vl_Grph_2->ls as $k => $v){
				
				$__tot = $v->vl_sls/$v->trs;	
				$_mark[] = "{ 
					name:\"".ctjTx($v->nm,'in')."\",   
					data:[{
						y:". number_format($__tot, 0, '.', '') .",
					}], 
					color:'".$v->clr."' 
				} ";

			}

			$_grph_tag = implode(",", $_mark);

			$CntWb .= "

                SUMR_Grph.f.g1({ 
                    id: '#_grph10',
                    d: [".$_grph_tag."],
                    tt: 'Ticket promedio total', 
                    c_e: false,
                    ttip_frmt:function(d){
                        if(!isN(d) && !isN(d.point)){
							return '<b>'+d.series.name+': </b> $' + Highcharts.numberFormat(d.y, 0, ',', '.') +'';
                        }
					},
                    plot_dl_uhtml: true,
                    plot_dl_allwovlp: true,
                    plot_dl_y: -5,
                    plot_dl_frmt:function(d){
                        if(!isN(d) && !isN(d.point)){
                            
                            var point = d.point;

                            window.setTimeout(function () {
                                point.dataLabel.attr({
                                    y: point.plotY - 50
                                });
                            });

                            return '$ ' + Highcharts.numberFormat(d.y, 0, ',', '.') + '<br><br><div class=\"HiChrt_Logo_Th\"><div class=\"_imgf\" style=\"background-image:url(' + d.point.logo + ');margin-left:auto;margin-right:auto;\"></div></div>';

                        }
                    },
                    plot_dl_gpdng:0
                });
			";
			
			?>
				<div class="__grph <?php echo $_f ?>">
					<?php echo h2('Ticket promedio total'); ?>
					<div class="_grph_inf" >
					    <div id="_grph10" class="_grph10"></div>
					</div>
					
					<table width="100%" border="0" cellpadding="0" cellspacing="0" class="Ls_Rg _grph_tb"> 
				    	<tr>
					    	<th nowrap="nowrap" class="_sb" width="30%"><?php echo 'Marca' ?></th>
							<th nowrap="nowrap" class="_sb" width="15%"><?php echo 'Ventas' ?></th>
							<th nowrap="nowrap" class="_sb" width="15%"><?php echo 'Transacciones' ?></th>
							<th nowrap="nowrap" class="_sb" width="15%"><?php echo 'Total arriendo' ?></th>
					    </tr>
					    <?php 
						    $_i_nm = 1;
						    foreach($Vl_Grph_2->ls as $_k => $_v){

								$____tot = $_v->vl_sls/$_v->trs;

							    echo "
							    	<tr class='Rw_".$_i_nm."'>
										<td nowrap='nowrap' class='_sb' width='30%'>".$_v->nm."</td>
										<td nowrap='nowrap' width='15%'>".cnVlrMon('', $_v->vl_sls)."</td>
										<td nowrap='nowrap' width='15%'>".$_v->trs."</td>
								    	<td nowrap='nowrap' width='10%'>".cnVlrMon('', $____tot)."</td>
									</tr>
								";

								$_tot_1 += $_v->vl_sls;
								$_tot_2 += $_v->trs;

							    if($_i_nm == 1){ $_i_nm = 2; }else{ $_i_nm = 1; }
							}


							$_tot_3 = $_tot_1/$_tot_2;

						    echo "
						    		<tr class='Rw_".$_i_nm."'>
							    		<td nowrap='nowrap' class='_sb' width='30%'>Total</td>
										<td nowrap='nowrap' width='15%'> ".cnVlrMon('', $_tot_1)."</td>
										<td nowrap='nowrap' width='15%'> ".$_tot_2."</td>
										<td nowrap='nowrap' width='15%'> ".cnVlrMon('', $_tot_3)."</td>
									</tr>
								";	
						
					    ?>
					</table>
				</div>
			<?php

		}elseif($__t2 == "sls_tck_2"){

			if( $_ftp != "f_his" ){
			
				if(!isN($__dt_1) && !isN($__dt_2)){ 
					$__fl_sls .= ' AND DATE_FORMAT(orgsdsarrsls_f, "%Y-%m-%d") BETWEEN "'.$__dt_1.'" AND "'.$__dt_2.'" ';
					$__fl_rg .= ' AND DATE_FORMAT(orgsdsarrrg_f, "%Y-%m-%d") BETWEEN "'.$__dt_1.'" AND "'.$__dt_2.'" ';
				}elseif(!isN($__dt_1)){
					$__fl_sls .= ' AND DATE_FORMAT(orgsdsarrsls_f, "%Y-%m-%d")  =  "'.$__dt_1.'" ';
					$__fl_rg .= ' AND DATE_FORMAT(orgsdsarrrg_f, "%Y-%m-%d")  =  "'.$__dt_1.'" ';
				}elseif(!isN($__dt_2)){
					$__fl_sls .= ' AND DATE_FORMAT(orgsdsarrsls_f, "%Y-%m-%d") = "'.$__dt_2.'" ';
					$__fl_rg .= ' AND DATE_FORMAT(orgsdsarrrg_f, "%Y-%m-%d") = "'.$__dt_2.'" ';
				}
			
			}

			if(!isN($_cllcl_lvl)){
				$__fl .= " AND id_org IN ( SELECT id_org FROM "._BdStr(DBM).TB_ORG." 
							INNER JOIN "._BdStr(DBM).TB_ORG_SDS." ON orgsds_org = id_org
							INNER JOIN "._BdStr(DBM).TB_ORG_SDS_ARR." ON orgsdsarr_orgsds = id_orgsds
							INNER JOIN "._BdStr(DBM).TB_CL_LCL." ON orgsdsarr_lcl = id_cllcl WHERE cllcl_lvl = ".$_cllcl_lvl." )";	
			}
	
			if(!isN($_orgtag)){
	
				$__fl .= " AND id_org IN ( SELECT id_org FROM "._BdStr(DBM).TB_ORG." 
							INNER JOIN "._BdStr(DBM).TB_ORG_TAG." ON orgtag_org = id_org
								WHERE orgtag_tag = ".$_orgtag." )";
	
			}

			if(!isN($_orgls)){
				$__fl .= " AND id_org IN ( ".$_orgls." )";	
			}

			$Ls_Cnt_Qry_2 .= "SELECT id_org, 
								DATE_FORMAT(orgsdsarrsls_f, '%Y-%m') AS mes, SUM( orgsdsarrsls_vl ) AS vl,  SUM( orgsdsarrsls_trs ) AS trs
							FROM "._BdStr(DBM).TB_ORG."
								INNER JOIN "._BdStr(DBM).TB_ORG_SDS." ON id_org = orgsds_org	
								INNER JOIN "._BdStr(DBM).TB_ORG_SDS_ARR." ON id_orgsds = orgsdsarr_orgsds
								INNER JOIN "._BdStr(DBM).TB_ORG_SDS_ARR_SLS." ON id_orgsdsarr = orgsdsarrsls_arr
							WHERE
							id_org != '' AND orgsdsarr_vl_rpt = 2 AND org_est = 1 $__fl GROUP BY DATE_FORMAT(orgsdsarrsls_f, '%Y-%m')
						"; 

			$Ls_Cnt_Rg_2 = $__cnx->_qry($Ls_Cnt_Qry_2);

			if($Ls_Cnt_Rg_2){ 
				$row_Ls_Cnt_Rg_2 = $Ls_Cnt_Rg_2->fetch_assoc(); 
				$Tot_Ls_Cnt_Rg_2 = $Ls_Cnt_Rg_2->num_rows; 
				if($Tot_Ls_Cnt_Rg_2 > 0){
					do {
						
						//Construye la grafica
						$Vl_2['ctg'][$row_Ls_Cnt_Rg_2['mes']] = $row_Ls_Cnt_Rg_2['mes'];
						
						$Vl_2['d']['m_a']['nm'] = 'Total';
						$Vl_2['d']['m_a']['f'][$row_Ls_Cnt_Rg_2['mes']]['vl'] = number_format($row_Ls_Cnt_Rg_2['vl'], 0, '.', '');
						$Vl_2['d']['m_a']['f'][$row_Ls_Cnt_Rg_2['mes']]['trs'] = number_format($row_Ls_Cnt_Rg_2['trs'], 0, '.', '');
						
						$Vl_2['ls'][$row_Ls_Cnt_Rg_2['mes']]['m_a']['nm'] = 'Total';
						$Vl_2['ls'][$row_Ls_Cnt_Rg_2['mes']]['m_a']['vl'] = $row_Ls_Cnt_Rg_2['vl'];
						$Vl_2['ls'][$row_Ls_Cnt_Rg_2['mes']]['m_a']['trs'] = $row_Ls_Cnt_Rg_2['trs'];
						
					} while ($row_Ls_Cnt_Rg_2 = $Ls_Cnt_Rg_2->fetch_assoc());
					$Vl_Grph_2 = _jEnc($Vl_2);
				}
			}

			foreach($Vl_Grph_2->ctg as $k => $v){	

				foreach($Vl_Grph_2->d as $_k => $_v){

					if( !isN($_v->f->{$k}->trs) && $_v->f->{$k}->trs > 0){

						$__tot = $_v->f->{$k}->vl / $_v->f->{$k}->trs;

						$_d[$_k]['nm'] = $_v->nm;
						$_d[$_k]['tot'][] = number_format($__tot, 0, '.', '');

						$__Vl['ls'][$v]['tot'] = number_format($__tot, 0, '.', '');
						$__Vl['ls'][$v]['vl'] = number_format($_v->f->{$k}->vl, 0, '.', '');
						$__Vl['ls'][$v]['trs'] = number_format($_v->f->{$k}->trs, 0, '.', '');

						$__ctg[] = '"'.$v.'"';
						$__ctgs[] = '"'.FechaESP_OLD($v, 10).'"';
					}
				}
			}

			$_Vl_Ls = _jEnc($__Vl);

			//Construye los datos
			foreach(_jEnc($_d) as $_k_d => $_v_d){
				$_medio[] = "{ name:\"".$_v_d->nm."\", data:[".implode(',', $_v_d->tot)."] } ";
			}
			
			$_grph_d = implode(",", $_medio);
			$_grph_c = implode(",", $__ctgs);
			
			$CntWb .= "
				SUMR_Grph.f.g1({ 
					id: '#_grph9',
					c: [".$_grph_c."],
					d: [".$_grph_d."],
					tt: 'Tickets por mes', 
					tt_sb: 'General',
					c_e: true,
					ttip_frmt:function(d){
                        if(!isN(d) && !isN(d.point)){
							return '$' + Highcharts.numberFormat(d.y, 0, ',', '.')+'';
                        }
					},
				});
			";
			
			?>
				<div class="__grph <?php echo $_f ?>">
					<?php echo h2('Esfuerzo'); ?>
					<div class="_grph_inf" >
						<div id="_grph9" class="_grph9"></div>
					</div>
					
					<table width="100%" border="0" cellpadding="0" cellspacing="0" id="_grph_tb" class="Ls_Rg _grph_tb">
						<tr>
							<th nowrap="nowrap" class="_sb" width="30%"><?php echo 'Fecha' ?></th>
							<th nowrap="nowrap" class="_sb" width="15%"><?php echo 'Ventas' ?></th>
							<th nowrap="nowrap" class="_sb" width="15%"><?php echo 'Transacciones' ?></th>
							<th nowrap="nowrap" class="_sb" width="15%"><?php echo 'Total' ?></th>
						</tr>
						<?php 

							foreach($__ctg as $_k_c => $_v_c){

								$_tt = str_replace('"', "", $_v_c);

								echo "<tr>";

									echo "<td nowrap='nowrap' class='_sb' width='30%'>".FechaESP_OLD($_tt, 10)."</td>";
									echo "<td nowrap='nowrap' class='_sb' width='15%'>".cnVlrMon('', $_Vl_Ls->ls->{$_tt}->vl)."</td>";
									echo "<td nowrap='nowrap' class='_sb' width='15%'>".$_Vl_Ls->ls->{$_tt}->trs."</td>";
									echo "<td nowrap='nowrap' class='_sb' width='15%'>".cnVlrMon('', $_Vl_Ls->ls->{$_tt}->tot)."</td>";

								echo '</tr>';

								$_tot_1 += $_Vl_Ls->ls->{$_tt}->vl;
								$_tot_2 += $_Vl_Ls->ls->{$_tt}->trs;

							}

						?>
						<?php
							
							$_tot_p = ( $_tot_1/$_tot_2 );

						    echo "
						    		<tr class='Rw_".$_i_nm."'>
							    		<td nowrap='nowrap' class='_sb' width='30%'>Total</td>
										<td nowrap='nowrap' width='15%'> ".cnVlrMon('', $_tot_1)."</td>
										<td nowrap='nowrap' width='15%'> ".$_tot_2."</td>
								    	<td nowrap='nowrap' width='10%'> ".cnVlrMon('',$_tot_p)."</td>
									</tr>
								";		
						?>
					</table>
				</div>
			<?php
		}elseif($__t2 == "sls_trs"){

			if( $_ftp != "f_his" ){

				if(!isN($__dt_1) && !isN($__dt_2)){ 
					$__fl_f .= ' AND DATE_FORMAT(orgsdsarrrg_f, "%Y-%m-%d") BETWEEN "'.$__dt_1.'" AND "'.$__dt_2.'" ';
					$__fl .= ' AND DATE_FORMAT(orgsdsarrsls_f, "%Y-%m-%d") BETWEEN "'.$__dt_1.'" AND "'.$__dt_2.'" ';
				}elseif(!isN($__dt_1)){
					$__fl_f .= ' AND DATE_FORMAT(orgsdsarrrg_f, "%Y-%m-%d")  =  "'.$__dt_1.'" ';
					$__fl .= ' AND DATE_FORMAT(orgsdsarrsls_f, "%Y-%m-%d")  =  "'.$__dt_1.'" ';
				}elseif(!isN($__dt_2)){
					$__fl_f .= ' AND DATE_FORMAT(orgsdsarrrg_f, "%Y-%m-%d") = "'.$__dt_2.'" ';
					$__fl .= ' AND DATE_FORMAT(orgsdsarrsls_f, "%Y-%m-%d") = "'.$__dt_2.'" ';
				}
			
			}

			if(!isN($_cllcl_lvl)){
				$__fl .= " AND id_org IN ( SELECT id_org FROM "._BdStr(DBM).TB_ORG." 
							INNER JOIN "._BdStr(DBM).TB_ORG_SDS." ON orgsds_org = id_org
							INNER JOIN "._BdStr(DBM).TB_ORG_SDS_ARR." ON orgsdsarr_orgsds = id_orgsds
							INNER JOIN "._BdStr(DBM).TB_CL_LCL." ON orgsdsarr_lcl = id_cllcl WHERE cllcl_lvl = ".$_cllcl_lvl." )";	
			}
	
			if(!isN($_orgtag)){
	
				$__fl .= " AND id_org IN ( SELECT id_org FROM "._BdStr(DBM).TB_ORG." 
							INNER JOIN "._BdStr(DBM).TB_ORG_TAG." ON orgtag_org = id_org
								WHERE orgtag_tag = ".$_orgtag." )";
	
			}

			if(!isN($_orgls)){
				$__fl .= " AND id_org IN ( ".$_orgls." )";	
			}

			$Ls_Cnt_Qry_2 .= "SELECT id_org, org_nm, org_clr, SUM(orgsdsarrsls_trs) AS trs
							FROM "._BdStr(DBM).TB_ORG."
								INNER JOIN "._BdStr(DBM).TB_ORG_SDS." ON id_org = orgsds_org	
								INNER JOIN "._BdStr(DBM).TB_ORG_SDS_ARR." ON id_orgsds = orgsdsarr_orgsds
								INNER JOIN "._BdStr(DBM).TB_ORG_SDS_ARR_SLS." ON id_orgsdsarr = orgsdsarrsls_arr
							WHERE
							id_org != '' AND orgsdsarr_vl_rpt = 2 AND org_est = 1 $__fl GROUP BY id_orgsds
						"; 

			$Ls_Cnt_Rg_2 = $__cnx->_qry($Ls_Cnt_Qry_2);

			if($Ls_Cnt_Rg_2){ 
				$row_Ls_Cnt_Rg_2 = $Ls_Cnt_Rg_2->fetch_assoc(); 
				$Tot_Ls_Cnt_Rg_2 = $Ls_Cnt_Rg_2->num_rows; 
				if($Tot_Ls_Cnt_Rg_2 > 0){
					do {

						if(!isN($row_Ls_Cnt_Rg_2['trs']) && $row_Ls_Cnt_Rg_2['trs'] > 0){
							$Vl_2['ls'][$row_Ls_Cnt_Rg_2['id_org']]['nm'] = ctjTx($row_Ls_Cnt_Rg_2['org_nm'], 'in');
							$Vl_2['ls'][$row_Ls_Cnt_Rg_2['id_org']]['trs'] = number_format($row_Ls_Cnt_Rg_2['trs'], 0, '.', '');
							$Vl_2['ls'][$row_Ls_Cnt_Rg_2['id_org']]['clr'] = ctjTx($row_Ls_Cnt_Rg_2['org_clr'], 'in');
						}
						
						
						
					} while ($row_Ls_Cnt_Rg_2 = $Ls_Cnt_Rg_2->fetch_assoc());

					$Vl_Grph_2 = _jEnc($Vl_2);
				}
			}

			foreach($Vl_Grph_2->ls as $k => $v){

				$_mark[] = "{ 
					name:\"".ctjTx($v->nm,'in')."\",   
					data:[{
						y:". number_format($v->trs, 0, '.', '') .",
					}], 
					color:'".$v->clr."' 
				} ";

			}

			$_grph_tag = implode(",", $_mark);

			$CntWb .= "

                SUMR_Grph.f.g1({ 
                    id: '#_grph10',
                    d: [".$_grph_tag."],
                    tt: 'transacciones', 
                    c_e: false,
                    ttip_frmt:function(d){
                        if(!isN(d) && !isN(d.point)){
							return '<b>'+d.series.name+': </b> $' + Highcharts.numberFormat(d.y, 0, ',', '.') +'';
                        }
					},
                    plot_dl_uhtml: true,
                    plot_dl_allwovlp: true,
                    plot_dl_y: -5,
                    plot_dl_frmt:function(d){
                        if(!isN(d) && !isN(d.point)){
                            
                            var point = d.point;

                            window.setTimeout(function () {
                                point.dataLabel.attr({
                                    y: point.plotY - 50
                                });
                            });

                            return '$ ' + Highcharts.numberFormat(d.y, 0, ',', '.') + '<br><br><div class=\"HiChrt_Logo_Th\"><div class=\"_imgf\" style=\"background-image:url(' + d.point.logo + ');margin-left:auto;margin-right:auto;\"></div></div>';

                        }
                    },
                    plot_dl_gpdng:0
                });
			";
			
			?>
				<div class="__grph <?php echo $_f ?>">
					<?php echo h2('Transacciones'); ?>
					<div class="_grph_inf" >
					    <div id="_grph10" class="_grph10"></div>
					</div>
					
					<table width="100%" border="0" cellpadding="0" cellspacing="0" class="Ls_Rg _grph_tb"> 
				    	<tr>
					    	<th nowrap="nowrap" class="_sb" width="30%"><?php echo 'Marca' ?></th>
							<th nowrap="nowrap" class="_sb" width="15%"><?php echo 'Transacciones' ?></th>
					    </tr>
					    <?php 
						    $_i_nm = 1;
						    foreach($Vl_Grph_2->ls as $_k => $_v){

							    echo "
							    	<tr class='Rw_".$_i_nm."'>
										<td nowrap='nowrap' class='_sb' width='30%'>".$_v->nm."</td>
										<td nowrap='nowrap' width='15%'>".$_v->trs."</td>
									</tr>
								";

								$_tot_2 += $_v->trs;

							    if($_i_nm == 1){ $_i_nm = 2; }else{ $_i_nm = 1; }
							}

						    echo "
						    		<tr class='Rw_".$_i_nm."'>
							    		<td nowrap='nowrap' class='_sb' width='30%'>Total</td>
										<td nowrap='nowrap' width='15%'> ".$_tot_2."</td>
									</tr>
								";	
						
					    ?>
					</table>
				</div>
			<?php

		}elseif($__t2 == "sls_trs_2"){

			if( $_ftp != "f_his" ){
			
				if(!isN($__dt_1) && !isN($__dt_2)){ 
					$__fl_sls .= ' AND DATE_FORMAT(orgsdsarrsls_f, "%Y-%m-%d") BETWEEN "'.$__dt_1.'" AND "'.$__dt_2.'" ';
					$__fl_rg .= ' AND DATE_FORMAT(orgsdsarrrg_f, "%Y-%m-%d") BETWEEN "'.$__dt_1.'" AND "'.$__dt_2.'" ';
				}elseif(!isN($__dt_1)){
					$__fl_sls .= ' AND DATE_FORMAT(orgsdsarrsls_f, "%Y-%m-%d")  =  "'.$__dt_1.'" ';
					$__fl_rg .= ' AND DATE_FORMAT(orgsdsarrrg_f, "%Y-%m-%d")  =  "'.$__dt_1.'" ';
				}elseif(!isN($__dt_2)){
					$__fl_sls .= ' AND DATE_FORMAT(orgsdsarrsls_f, "%Y-%m-%d") = "'.$__dt_2.'" ';
					$__fl_rg .= ' AND DATE_FORMAT(orgsdsarrrg_f, "%Y-%m-%d") = "'.$__dt_2.'" ';
				}
			
			}

			if(!isN($_cllcl_lvl)){
				$__fl .= " AND id_org IN ( SELECT id_org FROM "._BdStr(DBM).TB_ORG." 
							INNER JOIN "._BdStr(DBM).TB_ORG_SDS." ON orgsds_org = id_org
							INNER JOIN "._BdStr(DBM).TB_ORG_SDS_ARR." ON orgsdsarr_orgsds = id_orgsds
							INNER JOIN "._BdStr(DBM).TB_CL_LCL." ON orgsdsarr_lcl = id_cllcl WHERE cllcl_lvl = ".$_cllcl_lvl." )";	
			}
	
			if(!isN($_orgtag)){
	
				$__fl .= " AND id_org IN ( SELECT id_org FROM "._BdStr(DBM).TB_ORG." 
							INNER JOIN "._BdStr(DBM).TB_ORG_TAG." ON orgtag_org = id_org
								WHERE orgtag_tag = ".$_orgtag." )";
	
			}

			if(!isN($_orgls)){
				$__fl .= " AND id_org IN ( ".$_orgls." )";	
			}

			$Ls_Cnt_Qry_2 .= "SELECT id_org, 
								DATE_FORMAT(orgsdsarrsls_f, '%Y-%m') AS mes,  SUM( orgsdsarrsls_trs ) AS trs
							FROM "._BdStr(DBM).TB_ORG."
								INNER JOIN "._BdStr(DBM).TB_ORG_SDS." ON id_org = orgsds_org	
								INNER JOIN "._BdStr(DBM).TB_ORG_SDS_ARR." ON id_orgsds = orgsdsarr_orgsds
								INNER JOIN "._BdStr(DBM).TB_ORG_SDS_ARR_SLS." ON id_orgsdsarr = orgsdsarrsls_arr
							WHERE
							id_org != '' AND orgsdsarr_vl_rpt = 2 AND org_est = 1 $__fl GROUP BY DATE_FORMAT(orgsdsarrsls_f, '%Y-%m')
						"; 

			$Ls_Cnt_Rg_2 = $__cnx->_qry($Ls_Cnt_Qry_2);

			if($Ls_Cnt_Rg_2){ 
				$row_Ls_Cnt_Rg_2 = $Ls_Cnt_Rg_2->fetch_assoc(); 
				$Tot_Ls_Cnt_Rg_2 = $Ls_Cnt_Rg_2->num_rows; 
				if($Tot_Ls_Cnt_Rg_2 > 0){
					do {
						
						//Construye la grafica
						$Vl_2['ctg'][$row_Ls_Cnt_Rg_2['mes']] = $row_Ls_Cnt_Rg_2['mes'];
						
						$Vl_2['d']['m_a']['nm'] = 'Total';
						$Vl_2['d']['m_a']['f'][$row_Ls_Cnt_Rg_2['mes']]['trs'] = number_format($row_Ls_Cnt_Rg_2['trs'], 0, '.', '');
						
						$Vl_2['ls'][$row_Ls_Cnt_Rg_2['mes']]['m_a']['nm'] = 'Total';
						$Vl_2['ls'][$row_Ls_Cnt_Rg_2['mes']]['m_a']['trs'] = $row_Ls_Cnt_Rg_2['trs'];
						
					} while ($row_Ls_Cnt_Rg_2 = $Ls_Cnt_Rg_2->fetch_assoc());
					$Vl_Grph_2 = _jEnc($Vl_2);
				}
			}

			foreach($Vl_Grph_2->ctg as $k => $v){	

				foreach($Vl_Grph_2->d as $_k => $_v){

					if( !isN($_v->f->{$k}->trs) && $_v->f->{$k}->trs > 0){

						$__tot = $_v->f->{$k}->trs;

						$_d[$_k]['nm'] = $_v->nm;
						$_d[$_k]['tot'][] = number_format($__tot, 0, '.', '');

						$__Vl['ls'][$v]['trs'] = number_format($__tot, 0, '.', '');

						$__ctg[] = '"'.$v.'"';
						$__ctgs[] = '"'.FechaESP_OLD($v, 10).'"';

					}
				}
			}

			$_Vl_Ls = _jEnc($__Vl);

			//Construye los datos
			foreach(_jEnc($_d) as $_k_d => $_v_d){
				$_medio[] = "{ name:\"".$_v_d->nm."\", data:[".implode(',', $_v_d->tot)."] } ";
			}
			
			$_grph_d = implode(",", $_medio);
			$_grph_c = implode(",", $__ctgs);
			
			$CntWb .= "
				SUMR_Grph.f.g1({ 
					id: '#_grph9',
					c: [".$_grph_c."],
					d: [".$_grph_d."],
					tt: 'Tickets por mes', 
					tt_sb: 'General',
					c_e: true,
					ttip_frmt:function(d){
                        if(!isN(d) && !isN(d.point)){
							return '$' + Highcharts.numberFormat(d.y, 0, ',', '.')+'';
                        }
					},
				});
			";
			
			?>
				<div class="__grph <?php echo $_f ?>">
					<?php echo h2('Esfuerzo'); ?>
					<div class="_grph_inf" >
						<div id="_grph9" class="_grph9"></div>
					</div>
					
					<table width="100%" border="0" cellpadding="0" cellspacing="0" id="_grph_tb" class="Ls_Rg _grph_tb">
						<tr>
							<th nowrap="nowrap" class="_sb" width="30%"><?php echo 'Fecha' ?></th>
							<th nowrap="nowrap" class="_sb" width="15%"><?php echo 'Transacciones' ?></th>
						</tr>
						<?php 

							foreach($__ctg as $_k_c => $_v_c){

								$_tt = str_replace('"', "", $_v_c);

								echo "<tr>";

									echo "<td nowrap='nowrap' class='_sb' width='30%'>".FechaESP_OLD($_tt, 10)."</td>";
									echo "<td nowrap='nowrap' class='_sb' width='15%'>".$_Vl_Ls->ls->{$_tt}->trs."</td>";

								echo '</tr>';

								$_tot_2 += $_Vl_Ls->ls->{$_tt}->trs;

							}

						?>
						<?php
							
							$_tot_p = $_tot_2;

						    echo "
						    		<tr class='Rw_".$_i_nm."'>
							    		<td nowrap='nowrap' class='_sb' width='30%'>Total</td>
										<td nowrap='nowrap' width='15%'> ".$_tot_2."</td>
									</tr>
								";		
						?>
					</table>
				</div>
			<?php
		}elseif($__t2 == "sls_mtr_c"){

			if( $_ftp != "f_his" ){

				if(!isN($__dt_1) && !isN($__dt_2)){ 
					$__fl_e .= ' AND DATE_FORMAT(orgsdsarrsls_f, "%Y-%m-%d") BETWEEN "'.$__dt_1.'" AND "'.$__dt_2.'" ';
				}elseif(!isN($__dt_1)){
					$__fl_e .= ' AND DATE_FORMAT(orgsdsarrsls_f, "%Y-%m-%d")  =  "'.$__dt_1.'" ';
				}elseif(!isN($__dt_2)){
					$__fl_e .= ' AND DATE_FORMAT(orgsdsarrsls_f, "%Y-%m-%d") = "'.$__dt_2.'" ';
				}
			
			}

			if(!isN($_cllcl_lvl)){
				$__fl .= " AND id_org IN ( SELECT id_org FROM "._BdStr(DBM).TB_ORG." 
							INNER JOIN "._BdStr(DBM).TB_ORG_SDS." ON orgsds_org = id_org
							INNER JOIN "._BdStr(DBM).TB_ORG_SDS_ARR." ON orgsdsarr_orgsds = id_orgsds
							INNER JOIN "._BdStr(DBM).TB_CL_LCL." ON orgsdsarr_lcl = id_cllcl WHERE cllcl_lvl = ".$_cllcl_lvl." )";	
			}
	
			if(!isN($_orgtag)){
	
				$__fl .= " AND id_org IN ( SELECT id_org FROM "._BdStr(DBM).TB_ORG." 
							INNER JOIN "._BdStr(DBM).TB_ORG_TAG." ON orgtag_org = id_org
								WHERE orgtag_tag = ".$_orgtag." )";
	
			}

			if(!isN($_orgls)){
				$__fl .= " AND id_org IN ( ".$_orgls." )";	
			}
			
			$Ls_Cnt_Qry .= "SELECT 
								id_org, org_nm, org_clr, 
								t.id_cllcl AS id_lcl1, t.cllcl_tt AS lcl1, t.cllcl_m2 AS lcl_m_1, 
								e.id_cllcl AS id_lcl2, e.cllcl_tt AS lcl2, e.cllcl_m2 AS lcl_m_2 
							FROM "._BdStr(DBM).TB_ORG."
								INNER JOIN "._BdStr(DBM).TB_ORG_SDS." ON id_org = orgsds_org	
								INNER JOIN "._BdStr(DBM).TB_ORG_SDS_ARR." ON id_orgsds = orgsdsarr_orgsds
								INNER JOIN "._BdStr(DBM).TB_CL_LCL." AS t ON t.id_cllcl = orgsdsarr_lcl
								LEFT JOIN "._BdStr(DBM).TB_ORG_SDS_ARR_LCL." ON id_orgsdsarr = orgsdsarrlcl_orgsdsarr
								LEFT JOIN "._BdStr(DBM).TB_CL_LCL." AS e ON e.id_cllcl = orgsdsarrlcl_cllcl 
							WHERE
							id_org != '' AND orgsdsarr_vl_rpt = 2 AND org_est = 1 $__fl_t $__fl GROUP BY orgsdsarr_lcl, orgsdsarr_orgsds, e.id_cllcl ORDER BY org_nm
						"; 

			

			$Ls_Cnt_Rg = $__cnx->_qry($Ls_Cnt_Qry);

			if($Ls_Cnt_Rg){ 
				$row_Ls_Cnt_Rg = $Ls_Cnt_Rg->fetch_assoc(); 
				$Tot_Ls_Cnt_Rg = $Ls_Cnt_Rg->num_rows; 
				if($Tot_Ls_Cnt_Rg > 0){
					do {
						$Vl['ls'][$row_Ls_Cnt_Rg['id_org']]['id'] = ctjTx($row_Ls_Cnt_Rg['id_org'], 'in');
						$Vl['ls'][$row_Ls_Cnt_Rg['id_org']]['nm'] = ctjTx($row_Ls_Cnt_Rg['org_nm'], 'in');
						$Vl['ls'][$row_Ls_Cnt_Rg['id_org']]['clr'] = ctjTx($row_Ls_Cnt_Rg['org_clr'], 'in');

						$Vl['ls'][$row_Ls_Cnt_Rg['id_org']]['lcl'][$row_Ls_Cnt_Rg['id_lcl1']]['lcl'] = ctjTx($row_Ls_Cnt_Rg['lcl_m_1'], 'in');
						$Vl['ls'][$row_Ls_Cnt_Rg['id_org']]['lcl'][$row_Ls_Cnt_Rg['id_lcl2']]['lcl'] = ctjTx($row_Ls_Cnt_Rg['lcl_m_2'], 'in');
						
					} while ($row_Ls_Cnt_Rg = $Ls_Cnt_Rg->fetch_assoc());

					$Vl_Grph = _jEnc($Vl);
				}
			}

			$Ls_Cnt_Qry_2 .= "SELECT id_org, org_nm, org_clr, SUM(orgsdsarrsls_vl) AS vl_sls
							FROM "._BdStr(DBM).TB_ORG."
								INNER JOIN "._BdStr(DBM).TB_ORG_SDS." ON id_org = orgsds_org	
								INNER JOIN "._BdStr(DBM).TB_ORG_SDS_ARR." ON id_orgsds = orgsdsarr_orgsds
								INNER JOIN "._BdStr(DBM).TB_ORG_SDS_ARR_SLS." ON id_orgsdsarr = orgsdsarrsls_arr
							WHERE
							id_org != '' AND orgsdsarr_vl_rpt = 2 AND org_est = 1 $__fl_e $__fl GROUP BY id_orgsds
						"; 
						
			$Ls_Cnt_Rg_2 = $__cnx->_qry($Ls_Cnt_Qry_2);

			if($Ls_Cnt_Rg_2){ 
				$row_Ls_Cnt_Rg_2 = $Ls_Cnt_Rg_2->fetch_assoc(); 
				$Tot_Ls_Cnt_Rg_2 = $Ls_Cnt_Rg_2->num_rows; 
				if($Tot_Ls_Cnt_Rg_2 > 0){
					do {
						
						$Vl_2['ls'][$row_Ls_Cnt_Rg_2['id_org']]['nm'] = ctjTx($row_Ls_Cnt_Rg_2['org_nm'], 'in');
						$Vl_2['ls'][$row_Ls_Cnt_Rg_2['id_org']]['vl_sls'] = $row_Ls_Cnt_Rg_2['vl_sls'];
						
					} while ($row_Ls_Cnt_Rg_2 = $Ls_Cnt_Rg_2->fetch_assoc());

					$Vl_Grph_2 = _jEnc($Vl_2);
				}
			}

			foreach($Vl_Grph->ls as $k => $v){

				$m2 = 0;

				foreach($v->lcl as $_k => $_v){
					$m2 += $_v->lcl;
				}

				$__tots = $Vl_Grph_2->ls->{$k}->vl_sls / $m2;

				if(!isN($__tots)){

					$_mark[] = "{ 
						name:\"".ctjTx($v->nm,'in')."\",   
						data:[{
							y:". number_format($__tots, 0, '.', '') .",
						}], 
						color:'".$v->clr."' 
					} "; 

					$_Vl['ls'][$v->id]['nm'] = $v->nm;
					$_Vl['ls'][$v->id]['tot'] = $__tots;
					$_Vl['ls'][$v->id]['vl'] = $Vl_Grph_2->ls->{$k}->vl_sls;
					$_Vl['ls'][$v->id]['m2'] = $m2;

				}

			}

			$_grph_tag = implode(",", $_mark);

			$CntWb .= "

                SUMR_Grph.f.g1({ 
					id: '#_grph8',
                    d: [".$_grph_tag."],
                    tt: '', 
					c_e: false,
                    ttip_frmt:function(d){
                        if(!isN(d) && !isN(d.point)){
							return '<b>'+d.series.name+': </b> $' + Highcharts.numberFormat(d.y, 0, ',', '.') +'';
                        }
					},
                    plot_dl_uhtml: true,
                    plot_dl_allwovlp: true,
                    plot_dl_y: -5,
                    plot_dl_frmt:function(d){
                        if(!isN(d) && !isN(d.point)){
                            
                            var point = d.point;

                            window.setTimeout(function () {
                                point.dataLabel.attr({
                                    y: point.plotY - 50
                                });
                            });

                            return '$ ' + Highcharts.numberFormat(d.y, 0, ',', '.') + '<br><br><div class=\"HiChrt_Logo_Th\"><div class=\"_imgf\" style=\"background-image:url(' + d.point.logo + ');margin-left:auto;margin-right:auto;\"></div></div>';

                        }
                    },
                    plot_dl_gpdng:0
                });
			";
			
			?>
				<div class="__grph <?php echo $_f ?>">
					<?php echo h2('Metro cuadrado'); ?>
					<div class="_grph_inf" >
					    <div id="_grph8" class="_grph8"></div>
					</div>
					
					<table width="100%" border="0" cellpadding="0" cellspacing="0" class="Ls_Rg _grph_tb"> 
				    	<tr>
					    	<th nowrap="nowrap" class="_sb" width="30%"><?php echo 'Marca' ?></th>
							<th nowrap="nowrap" class="_sb" width="15%"><?php echo 'Ventas' ?></th>
							<th nowrap="nowrap" class="_sb" width="15%"><?php echo 'm<sup>2</sup>' ?></th>
							<th nowrap="nowrap" class="_sb" width="15%"><?php echo 'Total' ?></th>
					    </tr>
					    <?php 
						    $_i_nm = 1;
						    foreach($_Vl['ls'] as $_k => $_v){
							    echo "
							    	<tr class='Rw_".$_i_nm."'>
										<td nowrap='nowrap' class='_sb' width='30%'>".$_v['nm']."</td>
										<td nowrap='nowrap' width='15%'>".cnVlrMon('', $_v['vl'])."</td>
										<td nowrap='nowrap' width='15%'>".$_v['m2']."</td>
										<td nowrap='nowrap' width='15%'>".cnVlrMon('', $_v['tot'])."</td>
									</tr>
								";

								$_tot_1 += $_v['vl'];
								$_tot_2 += $_v['m2'];
								

							    if($_i_nm == 1){ $_i_nm = 2; }else{ $_i_nm = 1; }
							}
							
							$_tot_p = ( $_tot_1/$_tot_2 );

						    echo "
						    		<tr class='Rw_".$_i_nm."'>
							    		<td nowrap='nowrap' class='_sb' width='30%'>Total</td>
										<td nowrap='nowrap' width='15%'> ".cnVlrMon('', $_tot_1)."</td>
										<td nowrap='nowrap' width='15%'> ".$_tot_2."</td>
								    	<td nowrap='nowrap' width='10%'> ".cnVlrMon('',$_tot_p)."</td>
									</tr>
								";
					    ?>
					</table>
				</div>
			<?php

		}elseif($__t2 == "sls_mtr_c_2"){

			if( $_ftp != "f_his" ){
			
				if(!isN($__dt_1) && !isN($__dt_2)){ 
					$__fl_sls .= ' AND DATE_FORMAT(orgsdsarrsls_f, "%Y-%m-%d") BETWEEN "'.$__dt_1.'" AND "'.$__dt_2.'" ';
					$__fl_rg .= ' AND DATE_FORMAT(orgsdsarrrg_f, "%Y-%m-%d") BETWEEN "'.$__dt_1.'" AND "'.$__dt_2.'" ';
				}elseif(!isN($__dt_1)){
					$__fl_sls .= ' AND DATE_FORMAT(orgsdsarrsls_f, "%Y-%m-%d")  =  "'.$__dt_1.'" ';
					$__fl_rg .= ' AND DATE_FORMAT(orgsdsarrrg_f, "%Y-%m-%d")  =  "'.$__dt_1.'" ';
				}elseif(!isN($__dt_2)){
					$__fl_sls .= ' AND DATE_FORMAT(orgsdsarrsls_f, "%Y-%m-%d") = "'.$__dt_2.'" ';
					$__fl_rg .= ' AND DATE_FORMAT(orgsdsarrrg_f, "%Y-%m-%d") = "'.$__dt_2.'" ';
				}
			
			}

			if(!isN($_cllcl_lvl)){
				$__fl .= " AND id_org IN ( SELECT id_org FROM "._BdStr(DBM).TB_ORG." 
							INNER JOIN "._BdStr(DBM).TB_ORG_SDS." ON orgsds_org = id_org
							INNER JOIN "._BdStr(DBM).TB_ORG_SDS_ARR." ON orgsdsarr_orgsds = id_orgsds
							INNER JOIN "._BdStr(DBM).TB_CL_LCL." ON orgsdsarr_lcl = id_cllcl WHERE cllcl_lvl = ".$_cllcl_lvl." )";	
			}
	
			if(!isN($_orgtag)){
	
				$__fl .= " AND id_org IN ( SELECT id_org FROM "._BdStr(DBM).TB_ORG." 
							INNER JOIN "._BdStr(DBM).TB_ORG_TAG." ON orgtag_org = id_org
								WHERE orgtag_tag = ".$_orgtag." )";
	
			}

			if(!isN($_orgls)){
				$__fl .= " AND id_org IN ( ".$_orgls." )";	
			}

			$Ls_Cnt_Qry .= "SELECT 
						id_org, org_nm, org_clr, 
						t.id_cllcl AS id_lcl1, t.cllcl_tt AS lcl1, t.cllcl_m2 AS lcl_m_1, 
						e.id_cllcl AS id_lcl2, e.cllcl_tt AS lcl2, e.cllcl_m2 AS lcl_m_2 
					FROM "._BdStr(DBM).TB_ORG."
						INNER JOIN "._BdStr(DBM).TB_ORG_SDS." ON id_org = orgsds_org	
						INNER JOIN "._BdStr(DBM).TB_ORG_SDS_ARR." ON id_orgsds = orgsdsarr_orgsds
						INNER JOIN "._BdStr(DBM).TB_CL_LCL." AS t ON t.id_cllcl = orgsdsarr_lcl
						LEFT JOIN "._BdStr(DBM).TB_ORG_SDS_ARR_LCL." ON id_orgsdsarr = orgsdsarrlcl_orgsdsarr
						LEFT JOIN "._BdStr(DBM).TB_CL_LCL." AS e ON e.id_cllcl = orgsdsarrlcl_cllcl 
					WHERE
					id_org != '' AND orgsdsarr_vl_rpt = 2 AND org_est = 1 $__fl_t $__fl GROUP BY orgsdsarr_lcl, orgsdsarr_orgsds, e.id_cllcl ORDER BY org_nm
				"; 

			echo $Ls_Cnt_Qry;

			$Ls_Cnt_Rg = $__cnx->_qry($Ls_Cnt_Qry);

			if($Ls_Cnt_Rg){ 
				$row_Ls_Cnt_Rg = $Ls_Cnt_Rg->fetch_assoc(); 
				$Tot_Ls_Cnt_Rg = $Ls_Cnt_Rg->num_rows; 
				if($Tot_Ls_Cnt_Rg > 0){
					do {
						
						//Construye la grafica
						$Vl['ctg'][$row_Ls_Cnt_Rg['mes']] = $row_Ls_Cnt_Rg['mes'];
						
						$Vl['d']['m_a']['nm'] = 'Total';
						$Vl['d']['m_a']['f'][$row_Ls_Cnt_Rg['mes']]['vl_adm'] = number_format($row_Ls_Cnt_Rg['vl_adm'], 0, '.', '');
						$Vl['d']['m_a']['f'][$row_Ls_Cnt_Rg['mes']]['vl'] = number_format($row_Ls_Cnt_Rg['vl'], 0, '.', '');

						$Vl['ls'][$row_Ls_Cnt_Rg['mes']]['m_a']['nm'] = 'Total';
						$Vl['ls'][$row_Ls_Cnt_Rg['mes']]['m_a']['tot'] = $row_Ls_Cnt_Rg['tot'];
						
					} while ($row_Ls_Cnt_Rg = $Ls_Cnt_Rg->fetch_assoc());
					$Vl_Grph = _jEnc($Vl);
				}
			}

			$Ls_Cnt_Qry_2 .= "SELECT id_org, 
								DATE_FORMAT(orgsdsarrsls_f, '%Y-%m') AS mes, SUM( orgsdsarrsls_vl ) AS vl
							FROM "._BdStr(DBM).TB_ORG."
								INNER JOIN "._BdStr(DBM).TB_ORG_SDS." ON id_org = orgsds_org	
								INNER JOIN "._BdStr(DBM).TB_ORG_SDS_ARR." ON id_orgsds = orgsdsarr_orgsds
								INNER JOIN "._BdStr(DBM).TB_ORG_SDS_ARR_SLS." ON id_orgsdsarr = orgsdsarrsls_arr
							WHERE
							id_org != '' AND orgsdsarr_vl_rpt = 2 AND org_est = 1 $__fl GROUP BY DATE_FORMAT(orgsdsarrsls_f, '%Y-%m')
						"; 

			$Ls_Cnt_Rg_2 = $__cnx->_qry($Ls_Cnt_Qry_2);

			if($Ls_Cnt_Rg_2){ 
				$row_Ls_Cnt_Rg_2 = $Ls_Cnt_Rg_2->fetch_assoc(); 
				$Tot_Ls_Cnt_Rg_2 = $Ls_Cnt_Rg_2->num_rows; 
				if($Tot_Ls_Cnt_Rg_2 > 0){
					do {
						
						//Construye la grafica
						$Vl_2['ctg'][$row_Ls_Cnt_Rg_2['mes']] = $row_Ls_Cnt_Rg_2['mes'];
						
						$Vl_2['d']['m_a']['nm'] = 'Total';
						$Vl_2['d']['m_a']['f'][$row_Ls_Cnt_Rg_2['mes']]['tot'] = number_format($row_Ls_Cnt_Rg_2['vl'], 0, '.', '');
						
						$Vl_2['ls'][$row_Ls_Cnt_Rg_2['mes']]['m_a']['nm'] = 'Total';
						$Vl_2['ls'][$row_Ls_Cnt_Rg_2['mes']]['m_a']['tot'] = $row_Ls_Cnt_Rg_2['tot'];
						
					} while ($row_Ls_Cnt_Rg_2 = $Ls_Cnt_Rg_2->fetch_assoc());
					$Vl_Grph_2 = _jEnc($Vl_2);
				}
			}

			foreach($Vl_Grph->ctg as $k => $v){	
				

				foreach($Vl_Grph->d as $_k => $_v){
					$_d[$_k]['nm'] = $_v->nm;

					$__tot = $_v->f->{$k}->vl + $_v->f->{$k}->vl_adm;
					$__tots = $Vl_Grph_2->d->m_a->f->{$v}->tot;

					if($__tots > 0){
						$_rel = ($__tot / $__tots)*100;

						$_d[$_k]['tot'][] = number_format($_rel, 0, '.', '');

						$__Vl['ls'][$v]['tot'] = number_format($_rel, 0, '.', '');
						$__Vl['ls'][$v]['vl'] = number_format($_v->f->{$k}->vl, 0, '.', '');
						$__Vl['ls'][$v]['vl_adm'] = number_format($_v->f->{$k}->vl_adm, 0, '.', '');
						$__Vl['ls'][$v]['tot_arr'] = number_format($__tot, 0, '.', '');
						$__Vl['ls'][$v]['sls'] = number_format($__tots, 0, '.', '');

						$__ctg[] = '"'.$v.'"';
						$__ctgs[] = '"'.FechaESP_OLD($v, 10).'"';
					}

				}
			}

			$_Vl_Ls = _jEnc($__Vl);

			//Construye los datos
			foreach(_jEnc($_d) as $_k_d => $_v_d){
				$_medio[] = "{ name:\"".$_v_d->nm."\", data:[".implode(',', $_v_d->tot)."] } ";
			}
			
			$_grph_d = implode(",", $_medio);
			$_grph_c = implode(",", $__ctgs);
			
			$CntWb .= "
				SUMR_Grph.f.g1({ 
					id: '#_grph9',
					c: [".$_grph_c."],
					d: [".$_grph_d."],
					tt: 'Esfuerzo por mes', 
					tt_sb: 'General',
					c_e: true,
					ttip_frmt:function(d){
                        if(!isN(d) && !isN(d.point)){
							return '' + Highcharts.numberFormat(d.y, 0, ',', '.')+'%';
                        }
					},
				});
			";
			
			?>
				<div class="__grph <?php echo $_f ?>">
					<?php echo h2('Esfuerzo'); ?>
					<div class="_grph_inf" >
						<div id="_grph9" class="_grph9"></div>
					</div>
					
					<table width="100%" border="0" cellpadding="0" cellspacing="0" id="_grph_tb" class="Ls_Rg _grph_tb">
						<tr>
							<th nowrap="nowrap" class="_sb" width="30%"><?php echo 'Marca' ?></th>
							<th nowrap="nowrap" class="_sb" width="15%"><?php echo 'Arriendo' ?></th>
							<th nowrap="nowrap" class="_sb" width="15%"><?php echo 'Administración' ?></th>
							<th nowrap="nowrap" class="_sb" width="15%"><?php echo 'Total arriendo' ?></th>
							<th nowrap="nowrap" class="_sb" width="15%"><?php echo 'Total ventas' ?></th>
				    	    <th nowrap="nowrap" width="10%"><?php echo 'Esfuerzo' ?></th>
						</tr>
						<?php 

							foreach($__ctg as $_k_c => $_v_c){

								$_tt = str_replace('"', "", $_v_c);

								echo "<tr>";

									echo "<td nowrap='nowrap' class='_sb' width='30%'>".FechaESP_OLD($_tt, 10)."</td>";
									echo "<td nowrap='nowrap' class='_sb' width='15%'>".cnVlrMon('', $_Vl_Ls->ls->{$_tt}->vl)."</td>";
									echo "<td nowrap='nowrap' class='_sb' width='15%'>".cnVlrMon('', $_Vl_Ls->ls->{$_tt}->vl_adm)."</td>";
									echo "<td nowrap='nowrap' class='_sb' width='15%'>".cnVlrMon('', $_Vl_Ls->ls->{$_tt}->tot_arr)."</td>";
									echo "<td nowrap='nowrap' class='_sb' width='15%'>".cnVlrMon('', $_Vl_Ls->ls->{$_tt}->sls)."</td>";
									echo "<td nowrap='nowrap' class='_sb' width='10%'>".$_Vl_Ls->ls->{$_tt}->tot."%</td>";

								echo '</tr>';

								$_tot_1 += $_Vl_Ls->ls->{$_tt}->vl;
								$_tot_2 += $_Vl_Ls->ls->{$_tt}->vl_adm;
								$_tot_3 += $_Vl_Ls->ls->{$_tt}->tot_arr;
								$_tot_4 += $_Vl_Ls->ls->{$_tt}->sls;

							}

						?>
						<?php
							
							$_tot_p = ( $_tot_3/$_tot_4 ) * 100;

						    echo "
						    		<tr class='Rw_".$_i_nm."'>
							    		<td nowrap='nowrap' class='_sb' width='30%'>Total</td>
										<td nowrap='nowrap' width='15%'> ".cnVlrMon('', $_tot_1)."</td>
										<td nowrap='nowrap' width='15%'> ".cnVlrMon('', $_tot_2)."</td>
										<td nowrap='nowrap' width='15%'> ".cnVlrMon('', $_tot_3)."</td>
										<td nowrap='nowrap' width='15%'> ".cnVlrMon('', $_tot_4)."</td>
								    	<td nowrap='nowrap' width='10%'> ".number_format($_tot_p, 0)."%</td>
									</tr>
								";		
						?>
					</table>
				</div>
			<?php
		}elseif($__t2 == "sls_year"){

			if( $_ftp != "f_his" ){
			
				if(!isN($__dt_1) && !isN($__dt_2)){ 
					$__fl .= ' AND DATE_FORMAT(orgsdsarrsls_f, "%Y-%m-%d") BETWEEN "'.$__dt_1.'" AND "'.$__dt_2.'" ';
				}elseif(!isN($__dt_1)){
					$__fl .= ' AND DATE_FORMAT(orgsdsarrsls_f, "%Y-%m-%d")  =  "'.$__dt_1.'" ';
				}elseif(!isN($__dt_2)){
					$__fl .= ' AND DATE_FORMAT(orgsdsarrsls_f, "%Y-%m-%d") = "'.$__dt_2.'" ';
				}
			
			}

			if(!isN($_cllcl_lvl)){
				$__fl .= " AND id_org IN ( SELECT id_org FROM "._BdStr(DBM).TB_ORG." 
							INNER JOIN "._BdStr(DBM).TB_ORG_SDS." ON orgsds_org = id_org
							INNER JOIN "._BdStr(DBM).TB_ORG_SDS_ARR." ON orgsdsarr_orgsds = id_orgsds
							INNER JOIN "._BdStr(DBM).TB_CL_LCL." ON orgsdsarr_lcl = id_cllcl WHERE cllcl_lvl = ".$_cllcl_lvl." )";	
			}
	
			if(!isN($_orgtag)){
	
				$__fl .= " AND id_org IN ( SELECT id_org FROM "._BdStr(DBM).TB_ORG." 
							INNER JOIN "._BdStr(DBM).TB_ORG_TAG." ON orgtag_org = id_org
								WHERE orgtag_tag = ".$_orgtag." )";
	
			}

			if(!isN($_orgls)){
				$__fl .= " AND id_org IN ( ".$_orgls." )";	
			}

			$Ls_Cnt_Qry = " SELECT
								DATE_FORMAT( orgsdsarrsls_f, '%Y' ) AS anio,
								DATE_FORMAT( orgsdsarrsls_f, '%m' ) AS mes,
								DATE_FORMAT( orgsdsarrsls_f, '%Y-%m' ) AS all_f,
								SUM( orgsdsarrsls_vl ) AS tot 
							FROM "._BdStr(DBM).TB_ORG."
								INNER JOIN "._BdStr(DBM).TB_ORG_SDS." ON id_org = orgsds_org	
								INNER JOIN "._BdStr(DBM).TB_ORG_SDS_ARR." ON id_orgsds = orgsdsarr_orgsds
								INNER JOIN "._BdStr(DBM).TB_ORG_SDS_ARR_SLS." ON id_orgsdsarr = orgsdsarrsls_arr
							WHERE
							id_org != '' AND orgsdsarr_vl_rpt = 2 AND org_est = 1 $__fl GROUP BY DATE_FORMAT(orgsdsarrsls_f, '%Y-%m') ORDER BY mes ASC, anio DESC
						"; 

			$Ls_Cnt_Rg = $__cnx->_qry($Ls_Cnt_Qry);


			if($Ls_Cnt_Rg){ 
				$row_Ls_Cnt_Rg = $Ls_Cnt_Rg->fetch_assoc(); 
				$Tot_Ls_Cnt_Rg = $Ls_Cnt_Rg->num_rows; 
				if($Tot_Ls_Cnt_Rg > 0){
					do {
						
						//Construye la grafica
						$Vl['ctg'][$row_Ls_Cnt_Rg['mes']]['mes'] = $row_Ls_Cnt_Rg['mes'];
						$Vl['ctg'][$row_Ls_Cnt_Rg['mes']]['all_f'] = $row_Ls_Cnt_Rg['all_f'];
						
						$Vl['d'][$row_Ls_Cnt_Rg['anio']]['nm'] = ctjTx($row_Ls_Cnt_Rg['anio'], 'in');
						$Vl['d'][$row_Ls_Cnt_Rg['anio']]['f'][$row_Ls_Cnt_Rg['mes']]['tot'] = $row_Ls_Cnt_Rg['tot'];
						
						$Vl['ls'][$row_Ls_Cnt_Rg['mes']][$row_Ls_Cnt_Rg['anio']]['nm'] = ctjTx($row_Ls_Cnt_Rg['anio'], 'in');
						$Vl['ls'][$row_Ls_Cnt_Rg['mes']][$row_Ls_Cnt_Rg['anio']]['tot'] = $row_Ls_Cnt_Rg['tot'];
						
					} while ($row_Ls_Cnt_Rg = $Ls_Cnt_Rg->fetch_assoc());
					$Vl_Grph = _jEnc($Vl);
				}
			}

			foreach($Vl_Grph->ctg as $k => $v){	
				$__ctg[] = '"'.$k.'"';
				$__ctgs[] = '"'.FechaESP_OLD($v->all_f, 2).'"';
				
				foreach($Vl_Grph->d as $_k => $_v){
					$_d[$_k]['nm'] = $_v->nm;
					$_d[$_k]['tot'][] = ( !isN($_v->f->{$k}->tot) ) ? $_v->f->{$k}->tot : 0 ;
				}
				
			} 
			
			//Construye los datos
			foreach(_jEnc($_d) as $_k_d => $_v_d){
				$_medio[] = "{ name:\"".$_v_d->nm."\", data:[".implode(',', $_v_d->tot)."] } ";
			}
			
			$_grph_d = implode(",", $_medio);
			$_grph_c = implode(",", $__ctgs);
			
			$CntWb .= "
				SUMR_Grph.f.g3({ 
					id: '#_grph6',
					d: [".$_grph_d."],
					c: [".$_grph_c."],
					tt: 'Ventas', 
					tt_sb: 'Ventas por año',
					c_e: false
				});
			";
			
			?>
				<div class="__grph <?php echo $_f ?>">
					<?php echo h2('Ventas'); ?>
					<div class="_grph_inf" >
						<div id="_grph6" class="_grph6"></div>
					</div>
					
					<table width="100%" border="0" cellpadding="0" cellspacing="0" id="_grph_tb" class="Ls_Rg _grph_tb">
						<tr>
							<th nowrap="nowrap" width="70%"><?php echo 'Año' ?></th>
							<?php
								$i_n = 1;
								foreach($__ctgs as $_k_c => $_v_c){
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
									$_td .= " <td nowrap='nowrap' width='70%'>".cnVlrMon('', $_tot)."</td> ";
									
									$_tot_all = ($_tot_all+$_tot);
									$_tot_all_td[$_v_c][] = $_tot;
									$_tot_all_sum = ($_tot_all_sum+$_tot);
									
								}
								
								$_td .= " <td nowrap='nowrap' width='70%'>".cnVlrMon('', $_tot_all)."</td> "; /* Total derecha -> */
								
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
								$_td_tot .= "<td nowrap='nowrap' width='70%'>".cnVlrMon('', $_new_sum)."</td>";
							}
							
							echo "
									<tr class='Rw_".$_i_nm."'>
										<td nowrap='nowrap' class='_sb' width='30%'>Total</td>
										$_td_tot
										<td nowrap='nowrap' width='70%'>".cnVlrMon('', $_tot_all_sum)."</td>
									</tr>
								";
							/* Total abajo */
							
						?>
					</table>
				</div>
			<?php
		}elseif($__t2 == "sls_fac"){

			if( $_ftp != "f_his" ){
			
				if(!isN($__dt_1) && !isN($__dt_2)){ 
					$__fl_sls .= ' AND DATE_FORMAT(orgsdsarrsls_f, "%Y-%m-%d") BETWEEN "'.$__dt_1.'" AND "'.$__dt_2.'" ';
					$__fl_rg .= ' AND DATE_FORMAT(orgsdsarrrg_f, "%Y-%m-%d") BETWEEN "'.$__dt_1.'" AND "'.$__dt_2.'" ';
				}elseif(!isN($__dt_1)){
					$__fl_sls .= ' AND DATE_FORMAT(orgsdsarrsls_f, "%Y-%m-%d")  =  "'.$__dt_1.'" ';
					$__fl_rg .= ' AND DATE_FORMAT(orgsdsarrrg_f, "%Y-%m-%d")  =  "'.$__dt_1.'" ';
				}elseif(!isN($__dt_2)){
					$__fl_sls .= ' AND DATE_FORMAT(orgsdsarrsls_f, "%Y-%m-%d") = "'.$__dt_2.'" ';
					$__fl_rg .= ' AND DATE_FORMAT(orgsdsarrrg_f, "%Y-%m-%d") = "'.$__dt_2.'" ';
				}
			
			}

			if(!isN($_cllcl_lvl)){
				$__fl .= " AND id_org IN ( SELECT id_org FROM "._BdStr(DBM).TB_ORG." 
							INNER JOIN "._BdStr(DBM).TB_ORG_SDS." ON orgsds_org = id_org
							INNER JOIN "._BdStr(DBM).TB_ORG_SDS_ARR." ON orgsdsarr_orgsds = id_orgsds
							INNER JOIN "._BdStr(DBM).TB_CL_LCL." ON orgsdsarr_lcl = id_cllcl WHERE cllcl_lvl = ".$_cllcl_lvl." )";	
			}
	
			if(!isN($_orgtag)){
	
				$__fl .= " AND id_org IN ( SELECT id_org FROM "._BdStr(DBM).TB_ORG." 
							INNER JOIN "._BdStr(DBM).TB_ORG_TAG." ON orgtag_org = id_org
								WHERE orgtag_tag = ".$_orgtag." )";
	
			}

			if(!isN($_orgls)){
				$__fl .= " AND id_org IN ( ".$_orgls." )";	
			}


			$Ls_Cnt_Qry .= "SELECT id_org, 
								DATE_FORMAT(orgsdsarrrg_f, '%Y-%m') AS mes, SUM( orgsdsarrrg_vl ) AS vl, SUM( orgsdsarrrg_vl_adm ) AS vl_adm
							FROM "._BdStr(DBM).TB_ORG."
								INNER JOIN "._BdStr(DBM).TB_ORG_SDS." ON id_org = orgsds_org	
								INNER JOIN "._BdStr(DBM).TB_ORG_SDS_ARR." ON id_orgsds = orgsdsarr_orgsds
								INNER JOIN "._BdStr(DBM).TB_ORG_SDS_ARR_RG." ON id_orgsdsarr = orgsdsarrrg_arr
							WHERE
							id_org != '' AND org_est = 1 $__fl_rg $__fl GROUP BY DATE_FORMAT(orgsdsarrrg_f, '%Y-%m')
						"; 

			$Ls_Cnt_Rg = $__cnx->_qry($Ls_Cnt_Qry);

			if($Ls_Cnt_Rg){ 
				$row_Ls_Cnt_Rg = $Ls_Cnt_Rg->fetch_assoc(); 
				$Tot_Ls_Cnt_Rg = $Ls_Cnt_Rg->num_rows; 
				if($Tot_Ls_Cnt_Rg > 0){
					do {
						
						//Construye la grafica
						$Vl['ctg'][$row_Ls_Cnt_Rg['mes']] = $row_Ls_Cnt_Rg['mes'];
						
						$Vl['d']['m_a']['nm'] = 'Total';
						$Vl['d']['m_a']['f'][$row_Ls_Cnt_Rg['mes']]['vl_adm'] = number_format($row_Ls_Cnt_Rg['vl_adm'], 0, '.', '');
						$Vl['d']['m_a']['f'][$row_Ls_Cnt_Rg['mes']]['vl'] = number_format($row_Ls_Cnt_Rg['vl'], 0, '.', '');

						$Vl['ls'][$row_Ls_Cnt_Rg['mes']]['m_a']['nm'] = 'Total';
						$Vl['ls'][$row_Ls_Cnt_Rg['mes']]['m_a']['tot'] = $row_Ls_Cnt_Rg['tot'];
						
					} while ($row_Ls_Cnt_Rg = $Ls_Cnt_Rg->fetch_assoc());
					$Vl_Grph = _jEnc($Vl);
				}
			}

			$Ls_Cnt_Qry_2 .= "SELECT id_org, 
								DATE_FORMAT(orgsdsarrsls_f, '%Y-%m') AS mes, SUM( orgsdsarrsls_vl ) AS vl
							FROM "._BdStr(DBM).TB_ORG."
								INNER JOIN "._BdStr(DBM).TB_ORG_SDS." ON id_org = orgsds_org	
								INNER JOIN "._BdStr(DBM).TB_ORG_SDS_ARR." ON id_orgsds = orgsdsarr_orgsds
								INNER JOIN "._BdStr(DBM).TB_ORG_SDS_ARR_SLS." ON id_orgsdsarr = orgsdsarrsls_arr
							WHERE
							id_org != '' AND org_est = 1 $__fl GROUP BY DATE_FORMAT(orgsdsarrsls_f, '%Y-%m')
						"; 

			$Ls_Cnt_Rg_2 = $__cnx->_qry($Ls_Cnt_Qry_2);

			if($Ls_Cnt_Rg_2){ 
				$row_Ls_Cnt_Rg_2 = $Ls_Cnt_Rg_2->fetch_assoc(); 
				$Tot_Ls_Cnt_Rg_2 = $Ls_Cnt_Rg_2->num_rows; 
				if($Tot_Ls_Cnt_Rg_2 > 0){
					do {
						
						//Construye la grafica
						$Vl_2['ctg'][$row_Ls_Cnt_Rg_2['mes']] = $row_Ls_Cnt_Rg_2['mes'];
						
						$Vl_2['d']['m_a']['nm'] = 'Total';
						$Vl_2['d']['m_a']['f'][$row_Ls_Cnt_Rg_2['mes']]['tot'] = number_format($row_Ls_Cnt_Rg_2['vl'], 0, '.', '');
						
						$Vl_2['ls'][$row_Ls_Cnt_Rg_2['mes']]['m_a']['nm'] = 'Total';
						$Vl_2['ls'][$row_Ls_Cnt_Rg_2['mes']]['m_a']['tot'] = $row_Ls_Cnt_Rg_2['tot'];
						
					} while ($row_Ls_Cnt_Rg_2 = $Ls_Cnt_Rg_2->fetch_assoc());
					$Vl_Grph_2 = _jEnc($Vl_2);
				}
			}

			foreach($Vl_Grph->ctg as $k => $v){	
				

				foreach($Vl_Grph->d as $_k => $_v){
					$_d[$_k]['nm'] = $_v->nm;

					$__tot = $_v->f->{$k}->vl + $_v->f->{$k}->vl_adm;
					$__tots = $Vl_Grph_2->d->m_a->f->{$v}->tot;

					if($__tots > 0){
						$_rel = number_format($__tot, 0, '.', '');

						$_d[$_k]['tot'][] = number_format($_rel, 0, '.', '');

						$__Vl['ls'][$v]['tot'] = number_format($_rel, 0, '.', '');
						$__Vl['ls'][$v]['vl'] = number_format($_v->f->{$k}->vl, 0, '.', '');
						$__Vl['ls'][$v]['vl_adm'] = number_format($_v->f->{$k}->vl_adm, 0, '.', '');
						$__Vl['ls'][$v]['tot_arr'] = number_format($__tot, 0, '.', '');
						$__Vl['ls'][$v]['sls'] = number_format($__tots, 0, '.', '');

						$__ctg[] = '"'.$v.'"';
						$__ctgs[] = '"'.FechaESP_OLD($v, 10).'"';
					}

				}
			}

			$_Vl_Ls = _jEnc($__Vl);

			//Construye los datos
			foreach(_jEnc($_d) as $_k_d => $_v_d){
				$_medio[] = "{ name:\"".$_v_d->nm."\", data:[".implode(',', $_v_d->tot)."] } ";
			}
			
			$_grph_d = implode(",", $_medio);
			$_grph_c = implode(",", $__ctgs);
			
			$CntWb .= "
				SUMR_Grph.f.g1({ 
					id: '#_grph9',
					c: [".$_grph_c."],
					d: [".$_grph_d."],
					tt: 'Facturación', 
					tt_sb: 'Facturación mensual',
					c_e: true,
					ttip_frmt:function(d){
                        if(!isN(d) && !isN(d.point)){
							return '$' + Highcharts.numberFormat(d.y, 0, ',', '.');
                        }
					},
				});
			";
			
			?>
				<div class="__grph <?php echo $_f ?>">
					<?php echo h2('Facturación'); ?>
					<div class="_grph_inf" >
						<div id="_grph9" class="_grph9"></div>
					</div>
					
					<table width="100%" border="0" cellpadding="0" cellspacing="0" id="_grph_tb" class="Ls_Rg _grph_tb">
						<tr>
							<th nowrap="nowrap" class="_sb" width="30%"><?php echo 'Marca' ?></th>
							<th nowrap="nowrap" class="_sb" width="15%"><?php echo 'Arriendo' ?></th>
							<th nowrap="nowrap" class="_sb" width="15%"><?php echo 'Administración' ?></th>
							<th nowrap="nowrap" class="_sb" width="15%"><?php echo 'Total arriendo' ?></th>
						</tr>
						<?php 

							foreach($__ctg as $_k_c => $_v_c){

								$_tt = str_replace('"', "", $_v_c);

								echo "<tr>";

									echo "<td nowrap='nowrap' class='_sb' width='30%'>".FechaESP_OLD($_tt, 10)."</td>";
									echo "<td nowrap='nowrap' class='_sb' width='15%'>".cnVlrMon('', $_Vl_Ls->ls->{$_tt}->vl)."</td>";
									echo "<td nowrap='nowrap' class='_sb' width='15%'>".cnVlrMon('', $_Vl_Ls->ls->{$_tt}->vl_adm)."</td>";
									echo "<td nowrap='nowrap' class='_sb' width='15%'>".cnVlrMon('', $_Vl_Ls->ls->{$_tt}->tot_arr)."</td>";

								echo '</tr>';

								$_tot_1 += $_Vl_Ls->ls->{$_tt}->vl;
								$_tot_2 += $_Vl_Ls->ls->{$_tt}->vl_adm;
								$_tot_3 += $_Vl_Ls->ls->{$_tt}->tot_arr;

							}

						?>
						<?php
						
						    echo "
						    		<tr class='Rw_".$_i_nm."'>
							    		<td nowrap='nowrap' class='_sb' width='30%'>Total</td>
										<td nowrap='nowrap' width='15%'> ".cnVlrMon('', $_tot_1)."</td>
										<td nowrap='nowrap' width='15%'> ".cnVlrMon('', $_tot_2)."</td>
										<td nowrap='nowrap' width='15%'> ".cnVlrMon('', $_tot_3)."</td>
									</tr>
								";		
						?>
					</table>
				</div>
			<?php
		}elseif($__t2 == "sls_fac_year"){

			if( $_ftp != "f_his" ){
			
				if(!isN($__dt_1) && !isN($__dt_2)){ 
					$__fl .= ' AND DATE_FORMAT(orgsdsarrsls_f, "%Y-%m-%d") BETWEEN "'.$__dt_1.'" AND "'.$__dt_2.'" ';
				}elseif(!isN($__dt_1)){
					$__fl .= ' AND DATE_FORMAT(orgsdsarrsls_f, "%Y-%m-%d")  =  "'.$__dt_1.'" ';
				}elseif(!isN($__dt_2)){
					$__fl .= ' AND DATE_FORMAT(orgsdsarrsls_f, "%Y-%m-%d") = "'.$__dt_2.'" ';
				}
			
			}

			if(!isN($_cllcl_lvl)){
				$__fl .= " AND id_org IN ( SELECT id_org FROM "._BdStr(DBM).TB_ORG." 
							INNER JOIN "._BdStr(DBM).TB_ORG_SDS." ON orgsds_org = id_org
							INNER JOIN "._BdStr(DBM).TB_ORG_SDS_ARR." ON orgsdsarr_orgsds = id_orgsds
							INNER JOIN "._BdStr(DBM).TB_CL_LCL." ON orgsdsarr_lcl = id_cllcl WHERE cllcl_lvl = ".$_cllcl_lvl." )";	
			}
	
			if(!isN($_orgtag)){
	
				$__fl .= " AND id_org IN ( SELECT id_org FROM "._BdStr(DBM).TB_ORG." 
							INNER JOIN "._BdStr(DBM).TB_ORG_TAG." ON orgtag_org = id_org
								WHERE orgtag_tag = ".$_orgtag." )";
	
			}

			if(!isN($_orgls)){
				$__fl .= " AND id_org IN ( ".$_orgls." )";	
			}

			$Ls_Cnt_Qry = " SELECT
								DATE_FORMAT( orgsdsarrrg_f, '%Y' ) AS anio,
								DATE_FORMAT( orgsdsarrrg_f, '%m' ) AS mes,
								DATE_FORMAT( orgsdsarrrg_f, '%Y-%m' ) AS all_f,
								SUM( orgsdsarrrg_vl ) AS tot_rg,
								SUM( orgsdsarrrg_vl_adm ) AS tot_adm
							FROM "._BdStr(DBM).TB_ORG."
								INNER JOIN "._BdStr(DBM).TB_ORG_SDS." ON id_org = orgsds_org	
								INNER JOIN "._BdStr(DBM).TB_ORG_SDS_ARR." ON id_orgsds = orgsdsarr_orgsds
								INNER JOIN "._BdStr(DBM).TB_ORG_SDS_ARR_RG." ON id_orgsdsarr = orgsdsarrrg_arr
							WHERE
							id_org != '' AND org_est = 1 $__fl GROUP BY DATE_FORMAT(orgsdsarrrg_f, '%Y-%m') ORDER BY mes ASC, anio DESC
						"; 
						

			$Ls_Cnt_Rg = $__cnx->_qry($Ls_Cnt_Qry);


			if($Ls_Cnt_Rg){ 
				$row_Ls_Cnt_Rg = $Ls_Cnt_Rg->fetch_assoc(); 
				$Tot_Ls_Cnt_Rg = $Ls_Cnt_Rg->num_rows; 
				if($Tot_Ls_Cnt_Rg > 0){
					do {
						
						//Construye la grafica
						$Vl['ctg'][$row_Ls_Cnt_Rg['mes']]['mes'] = $row_Ls_Cnt_Rg['mes'];
						$Vl['ctg'][$row_Ls_Cnt_Rg['mes']]['all_f'] = $row_Ls_Cnt_Rg['all_f'];
						
						$Vl['d'][$row_Ls_Cnt_Rg['anio']]['nm'] = ctjTx($row_Ls_Cnt_Rg['anio'], 'in');

						$__tot = number_format($row_Ls_Cnt_Rg['tot_rg'], 0, '.', '');
						$__tot_adm = number_format($row_Ls_Cnt_Rg['tot_adm'], 0, '.', '');

						$Vl['d'][$row_Ls_Cnt_Rg['anio']]['f'][$row_Ls_Cnt_Rg['mes']]['tot'] = $__tot+$__tot_adm;
						
						$Vl['ls'][$row_Ls_Cnt_Rg['mes']][$row_Ls_Cnt_Rg['anio']]['nm'] = ctjTx($row_Ls_Cnt_Rg['anio'], 'in');
						$Vl['ls'][$row_Ls_Cnt_Rg['mes']][$row_Ls_Cnt_Rg['anio']]['tot'] = $__tot+$__tot_adm;
						
					} while ($row_Ls_Cnt_Rg = $Ls_Cnt_Rg->fetch_assoc());
					$Vl_Grph = _jEnc($Vl);
				}

				
			}

			foreach($Vl_Grph->ctg as $k => $v){	
				$__ctg[] = '"'.$k.'"';
				$__ctgs[] = '"'.FechaESP_OLD($v->all_f, 2).'"';
				
				foreach($Vl_Grph->d as $_k => $_v){
					$_d[$_k]['nm'] = $_v->nm;
					$_d[$_k]['tot'][] = ( !isN($_v->f->{$k}->tot) ) ? $_v->f->{$k}->tot : 0 ;
				}
				
			} 
			
			//Construye los datos
			foreach(_jEnc($_d) as $_k_d => $_v_d){
				$_medio[] = "{ name:\"".$_v_d->nm."\", data:[".implode(',', $_v_d->tot)."] } ";
			}
			
			$_grph_d = implode(",", $_medio);
			$_grph_c = implode(",", $__ctgs);
			
			$CntWb .= "
				SUMR_Grph.f.g3({ 
					id: '#_grph6',
					d: [".$_grph_d."],
					c: [".$_grph_c."],
					tt: 'Facturación comparativo',
					c_e: false
				});
			";
			
			?>
				<div class="__grph <?php echo $_f ?>">
					<?php echo h2('Facturación'); ?>
					<div class="_grph_inf" >
						<div id="_grph6" class="_grph6"></div>
					</div>
					
					<table width="100%" border="0" cellpadding="0" cellspacing="0" id="_grph_tb" class="Ls_Rg _grph_tb">
						<tr>
							<th nowrap="nowrap" width="70%"><?php echo 'Año' ?></th>
							<?php
								$i_n = 1;
								foreach($__ctgs as $_k_c => $_v_c){
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
									$_td .= " <td nowrap='nowrap' width='70%'>".cnVlrMon('', $_tot)."</td> ";
									
									$_tot_all = ($_tot_all+$_tot);
									$_tot_all_td[$_v_c][] = $_tot;
									$_tot_all_sum = ($_tot_all_sum+$_tot);
									
								}
								
								$_td .= " <td nowrap='nowrap' width='70%'>".cnVlrMon('', $_tot_all)."</td> "; /* Total derecha -> */
								
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
								$_td_tot .= "<td nowrap='nowrap' width='70%'>".cnVlrMon('', $_new_sum)."</td>";
							}
							
							echo "
									<tr class='Rw_".$_i_nm."'>
										<td nowrap='nowrap' class='_sb' width='30%'>Total</td>
										$_td_tot
										<td nowrap='nowrap' width='70%'>".cnVlrMon('', $_tot_all_sum)."</td>
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