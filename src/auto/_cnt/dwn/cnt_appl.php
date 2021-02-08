<?php 

if(class_exists('CRM_Cnx')){ 
	
	
	//-------------------- PARAMETROS GET --------------------//
	
	
		$_i_dwn_p = $this->g__i;
	     
	    if(!isN($_i_dwn_p)){ $_qry_p = 'AND dwn_enc = "'.$_i_dwn_p.'" '; }else{ $_qry_p = ''; }
	     
	    $_fl_tt = _FleN([ 'tt'=>'Aplicaciones - Contactos' ]);
	    $_gt_all_noi = GtSisNoi();
	    $pdo_d = CnRd_Pdo([ 'd'=>'dwn' ]);
	    
	    //$__F_FORCE = ' AND id_dwn = 305';
      
    //-------------------- QUERY --------------------//
    
	    $Ls_QC = "	SELECT *,
	    				"._QrySisSlcF([ 'als'=>'f', 'als_n'=>'format' ]).",
						".GtSlc_QryExtra([ 't'=>'fld', 'p'=>'format', 'als'=>'f' ])."
						   
	    			FROM "._BdStr(DBD).TB_DWN."
	    				 ".GtSlc_QryExtra([ 't'=>'tb', 'col'=>'dwn_frm', 'als'=>'f' ])."
	    				 
	    			WHERE dwn_tp = 'cnt_appl' {$_qry_p} AND dwn_est != 1 AND dwn_est != 5
	    			ORDER BY dwn_r ASC
	    			LIMIT 1 ";
	    			
	    $Ls_RgC = $pdo_d->prepare($Ls_QC);
	    $Ls_RgC->execute();
	    $row_Ls_RgC = $Ls_RgC->fetchAll(PDO::FETCH_ASSOC);
	    $Tot_Ls_RgC = Pdo_Fix_RwTot($Ls_RgC);
 
    //-------------------- TITULO --------------------//
     
    echo $this->h1('Descargas Programas:'.$Tot_Ls_RgC);
	

    if($Tot_Ls_RgC > 0){
     
        foreach ($row_Ls_RgC as $rC) {

            $__format = json_decode($rC['___format']); 
				                
            foreach($__format as $__tp_k=>$__tp_v){
				$__format_go[$__tp_v->key] = $__tp_v;
			}

            $pdo_d = CnRd_Pdo([ 'd'=>'dwn' ]);
            $pdo = CnRd_Pdo();
			$_cl_dt = GtClDt($rC['dwn_cl']);
     
            $Ls_Mdfy_Attr_A = [];
            $Ls_Mdfy_Fnc_A = [];
            $Ls_Mdfy_Romt_A = [];

            $update_f_go = '';
            $updateSQL != '';
            $__dwn_dt = GtDwnDt([ 'id'=>$rC['id_dwn'] ]);
            
			$__dwn_frmt = $__format_go['ext']->vl;
			
            $__li .= $this->li('Id:'.$__dwn_dt->enc);
            $__li .= $this->li('Tot:'.json_encode($__dwn_dt->tot)); 
                 
             
            if(!isN($__dwn_dt->id) && $__dwn_dt->tot == 0){
             	
             	$__li_clr = '#ffa300'; 
             	$__li .= $this->li('No existe tabla');
                UPD_Dwn(['i'=>$__dwn_dt->id, 'e'=>'5', 'w'=>'No existe tabla' ]);
                 
            }elseif(!isN($__dwn_dt->id) && $__dwn_dt->tot->no_u > 0){
                
                
                $__li_clr = '#00d7d4';     
                $__li .= $this->li('Inicia procesa registro '.$__dwn_dt->id);
                 
                UPD_Dwn(['i'=>$__dwn_dt->id, 'e'=>'3']); 
                  
                if($__dwn_dt->est == 3){ $__c_prcs = '20000'; }else{ $__c_prcs = '5000'; }
                 
                $Ls_Qry = " SELECT * FROM "._BdStr(DBD).$__dwn_dt->tab." WHERE __dwn_e = 3 ORDER BY id_dwnprc ASC LIMIT $__c_prcs";
               
                
                //Atributos
                $Ls_Qry_Attr = "
                				SELECT *,
                				/*(SELECT sisslc_tt FROM "._BdStr(DBM).TB_SIS_SLC." WHERE id_sisslc = cntapplattr_attr) AS _attr_tt,*/
            					(SELECT ".DBD.".ctjTx(sisslc_tt) FROM "._BdStr(DBM).TB_SIS_SLC." WHERE id_sisslc = cntapplattr_attr) AS _attr_tt,
							"._QrySisSlcF([ 'als'=>'t', 'als_n'=>'attr' ]).",
							".GtSlc_QryExtra(['t'=>'fld', 'p'=>'attr', 'als'=>'t'])."
							
							FROM ".$_cl_dt->bd.".".TB_CNT_APPL_ATTR."
							".GtSlc_QryExtra(['t'=>'tb', 'col'=>'cntapplattr_attr', 'als'=>'t'])."
							WHERE id_cntapplattr != ''
							AND cntapplattr_cntappl IN ( SELECT __dwn_i
                           								FROM "._BdStr(DBD).$__dwn_dt->tab."
                           								WHERE __dwn_e = 3
                           							)
						    ORDER BY attr_sisslc_tt ASC
							 ";
							   
				
				//Responsable financiero
				$Ls_Qry_Fnc = "
								SELECT *
								FROM ".$_cl_dt->bd.".".TB_CNT_PRNT."
								INNER JOIN ".$_cl_dt->bd.".".TB_CNT." ON cntprnt_cnt_1 = id_cnt
								INNER JOIN "._BdStr(DBM).TB_SIS_SLC." ON cntprnt_cnt_prnt_1 = id_sisslc
								INNER JOIN ".$_cl_dt->bd.".".TB_CNT_APPL." ON cntappl_cnt = cntprnt_cnt_2
								WHERE id_cntappl IN ( 
														SELECT __dwn_i
                           								FROM "._BdStr(DBD).$__dwn_dt->tab."
                           								WHERE __dwn_e = 3
                           							) AND cntprnt_rsp_fnc = 1
							";
							   
				
				//Roomats
				$Ls_Qry_Romt = "
                				SELECT *
								FROM ".$_cl_dt->bd.".".TB_CNT_APPL_ROMT."
								WHERE id_cntapplromt != ''
								AND cntapplromt_cntappl IN ( SELECT __dwn_i
                               								FROM "._BdStr(DBD).$__dwn_dt->tab."
                               								WHERE __dwn_e = 3
                               							)
							   ";
				
				
				//Topics		   
				$Ls_Qry_Tpc = "
                				SELECT *
								FROM ".$_cl_dt->bd.".".TB_CNT_APPL_TPC."
								INNER JOIN "._BdStr(DBM).TB_TPC." ON id_tpc = cntappltpc_tpc
								WHERE id_cntappltpc != ''
								AND cntappltpc_cntappl IN ( SELECT __dwn_i
                               								FROM "._BdStr(DBD).$__dwn_dt->tab."
                               								WHERE __dwn_e = 3
                               							)
							   ";
                
                //-------------------- Main Query --------------------//			   
                $Ls_Rg = $pdo_d->prepare($Ls_Qry); 
                $Ls_Rg->execute(); 
                $row_Ls_Rg = $Ls_Rg->fetchAll(PDO::FETCH_ASSOC); 
                $Tot_Ls_Rg = Pdo_Fix_RwTot($Ls_Rg);
                
                //-------------------- Atributos --------------------//
                $Ls_Rg_Attr = $pdo->prepare($Ls_Qry_Attr); 
                $Ls_Rg_Attr->execute(); 
                $row_Ls_Rg_Attr = $Ls_Rg_Attr->fetch(PDO::FETCH_ASSOC); 
                $Tot_Ls_Rg_Attr = Pdo_Fix_RwTot($Ls_Rg_Attr);
                //print_r($Ls_Rg_Attr->errorInfo());
                
                //-------------------- Responsable financiero --------------------//
                $Ls_Rg_Fnc = $pdo->prepare($Ls_Qry_Fnc); 
                $Ls_Rg_Fnc->execute(); 
                $row_Ls_Rg_Fnc = $Ls_Rg_Fnc->fetch(PDO::FETCH_ASSOC); 
                $Tot_Ls_Rg_Fnc = Pdo_Fix_RwTot($Ls_Rg_Fnc);
                
                //-------------------- Roomats --------------------//
                $Ls_Rg_Romt = $pdo->prepare($Ls_Qry_Romt);
                $Ls_Rg_Romt->execute();
                $row_Ls_Rg_Romt = $Ls_Rg_Romt->fetch(PDO::FETCH_ASSOC);
                $Tot_Ls_Rg_Romt = Pdo_Fix_RwTot($Ls_Rg_Romt);
                
                //-------------------- Topics --------------------//
                $Ls_Rg_Tpc = $pdo->prepare($Ls_Qry_Tpc);
                $Ls_Rg_Tpc->execute();
                $row_Ls_Rg_Tpc = $Ls_Rg_Tpc->fetch(PDO::FETCH_ASSOC);
                $Tot_Ls_Rg_Tpc = Pdo_Fix_RwTot($Ls_Rg_Tpc);
                
                
                //-------------------- Atributos --------------------//
                $__li .= $this->li('Total Atributos:'.$Tot_Ls_Rg_Attr);
                if($Tot_Ls_Rg_Attr > 0){
	                
                    do {

                        if($row_Ls_Rg_Attr['cntapplattr_vl'] != ''){
                            $_i_p = $row_Ls_Rg_Attr['cntapplattr_cntappl'];
                            $_i_p_a = $row_Ls_Rg_Attr['id_cntapplattr'];
                            $__col_attr[ $_i_p ][] = [	
	                            							'id'=>$_i_p_a,
														't'=>$row_Ls_Rg_Attr['_attr_tt'], //Titulo Atributo
														'v'=>$row_Ls_Rg_Attr['cntapplattr_vl'], //valor Atributo
														'attr'=>$row_Ls_Rg_Attr['cntapplattr_attr'] //Atributo
													 ];
                        }
                                                                                                                                                                                                   
                    } while ($row_Ls_Rg_Attr = $Ls_Rg_Attr->fetch());
                    foreach ($__col_attr as $k => $v) { if(count($v) > $__mdl_th_attr){ $__mdl_th_attr = count($v); } }
                }
				
				//-------------------- Responsable financiero --------------------//
                $__li .= $this->li('Total Responsable financiero:'.$Tot_Ls_Rg_Fnc);
                if($Tot_Ls_Rg_Fnc > 0){
	                
                    do {

                        if($row_Ls_Rg_Fnc['id_cntprnt'] != ''){
                            $_i_p = $row_Ls_Rg_Fnc['id_cntappl'];
                            $_i_p_f = $row_Ls_Rg_Fnc['id_cntprnt'];
                            
                            $__dt_cnt = GtCntDt([ 't'=>'id', 'id'=>$row_Ls_Rg_Fnc['cntprnt_cnt_1'], 'ls_tp'=>'ok', 'ls_f_scl'=>'ok', 'ls_f_org'=>'ok', 'ls_f_tpc'=>'ok', 'count'=>'ok', 'bd'=>$_cl_dt->bd ]);
                            
                            $__col_fnc[ $_i_p ][] = [	
                            							'id'=>$_i_p_f,
												  	'dt'=>$__dt_cnt
												];
                        }
                                                                                                                                                                                                   
                    } while ($row_Ls_Rg_Fnc = $Ls_Rg_Fnc->fetch());
                    foreach ($__col_fnc as $k => $v) { if(count($v) > $__mdl_th_fnc){ $__mdl_th_fnc = count($v); } }
                }
				
				//-------------------- Roomats --------------------//
				$__li .= $this->li('Total Roomats:'.$Tot_Ls_Rg_Romt);
                if($Tot_Ls_Rg_Romt > 0){
	                
                    do {

                        if($row_Ls_Rg_Romt['cntapplromt_wtlve'] != ''){
                            $_i_p = $row_Ls_Rg_Romt['cntapplromt_cntappl'];
                            $_i_p_r = $row_Ls_Rg_Romt['id_cntapplromt'];
                            $__col_romt[ $_i_p ][] = [	
                        								'id'=>$_i_p_r,
													't'=>$row_Ls_Rg_Romt['cntapplromt_nm'], //Titulo Atributo
												  	'v'=>( ($row_Ls_Rg_Romt['cntapplromt_wtlve'] == 1)? "Si" : "No" ) //valor Atributo
												 ];
                        }
                                                                                                                                                                                                   
                    } while ($row_Ls_Rg_Romt = $Ls_Rg_Romt->fetch());
                    foreach ($__col_romt as $k => $v) { if(count($v) > $__mdl_th_romt){ $__mdl_th_romt = count($v); } }
                
                }
                
                //-------------------- Topics --------------------//
                $__li .= $this->li('Total Topics:'.$Tot_Ls_Rg_Tpc);
                if($Tot_Ls_Rg_Tpc > 0){
	                
                    do {

                        if($row_Ls_Rg_Tpc['cntappltpc_tpc'] != ''){
                            $_i_p = $row_Ls_Rg_Tpc['cntappltpc_cntappl'];
                            $_i_p_t = $row_Ls_Rg_Tpc['id_cntappltpc'];
                            $__col_tpc[ $_i_p ][] = [
                        								'id'=>$_i_p_t,
													't'=>$row_Ls_Rg_Tpc['tpc_tt'], //Titulo Atributo
												  	'v'=>"x" //valor Atributo
												];
                        }
                                                                                                                                                                                                   
                    }while ($row_Ls_Rg_Tpc = $Ls_Rg_Tpc->fetch());
                    foreach ($__col_tpc as $k => $v) { if(count($v) > $__mdl_th_tpc){ $__mdl_th_tpc = count($v); } }
                
                }
                
				
				//-------------------- Inicia Procesamiento --------------------//
				if (($Tot_Ls_Rg > 0)/*&&($Tot_Ls_Rg < 20001)*/) {
                    
                    //-------------------- Inicia - Construye Nuevas Columnas en la BD --------------------//
                    $_tr_i = 1; 
                    
                    foreach ($row_Ls_Rg as $r_p) {
                    
                        $_d_p_a = $__col_attr[ $r_p['ID']];
						
						//Atributos
						foreach($__col_attr[ $r_p['ID']] as $_k_a => $_v_a){
							$_v_a_tt = str_replace([':', '\\', '/', '*', '-', ' ', '(', ')'], "_", $_v_a['t']); //Remplazar simbolos por Guion al piso _
							$__mdl_th_a[$_v_a_tt]['tt'] = $_v_a_tt;
							$__mdl_th_a[$_v_a_tt]['tt_bd'] = $_v_a_tt;
							$__mdl_th_a[$_v_a_tt]['attr'] = $_v_a['attr'];
						}
						
						
						//Responsable financiero
						$_v_count = 1;
						foreach($__col_fnc[ $r_p['ID']] as $_k_f => $_v_f){
							
							$__mdl_th_f[$_v_f['id']][]['tt_bd'] = "Financiero_".$_v_count."_".TX_NM;
							$__mdl_th_f[$_v_f['id']][]['tt_bd'] = "Financiero_".$_v_count."_".TX_SX;
							$__mdl_th_f[$_v_f['id']][]['tt_bd'] = "Financiero_".$_v_count."_Fecha_Nacimiento";
							$__mdl_th_f[$_v_f['id']][]['tt_bd'] = "Financiero_".$_v_count."_Direccion";
							$__mdl_th_f[$_v_f['id']][]['tt_bd'] = "Financiero_".$_v_count."_Tipo_Documento";
							$__mdl_th_f[$_v_f['id']][]['tt_bd'] = "Financiero_".$_v_count."_".TX_DOCS;
							$__mdl_th_f[$_v_f['id']][]['tt_bd'] = "Financiero_".$_v_count."_".TX_EMAIL;
							$__mdl_th_f[$_v_f['id']][]['tt_bd'] = "Financiero_".$_v_count."_Telefonos";
							
							
							$_v_dt_h = _jEnc($_v_f['dt']);
							foreach($_v_dt_h->attr as $__k_attr_h => $__v_attr_h){
								$__v_attr_h_tt = str_replace([':', '\\', '/', '*', '-', ' ', '(', ')'], "_", $__v_attr_h->tt); //Remplazar simbolos por Guion al piso _
								$__mdl_th_f[$_v_f['id']][]['tt_bd'] = "Financiero_".$_v_count."_".$__v_attr_h_tt;
								echo "Financiero_".$_v_count."_".$__v_attr_h_tt." <br>";
							}
							
							echo "<br><br>";
							
							$_v_count++;
							
						}
						
						//Roomats
						for ($i = 1; $i <= $__mdl_th_romt; $i++) {
						    $__mdl_th_r[$i][1]['tt'] = 'Roomat_Titulo_'.$i;
						    $__mdl_th_r[$i][1]['tt_bd'] = 'Roomat_Titulo_'.$i;
						    $__mdl_th_r[$i][2]['tt'] = 'Roomat_Valor_'.$i;
						    $__mdl_th_r[$i][2]['tt_bd'] = 'Roomat_Valor_'.$i;
						}
						
						//Topics
						foreach($__col_tpc[ $r_p['ID']] as $_k_t => $_v_t){
							$_v_t_tt = str_replace([':', '\\', '/', '*', '-', ' ', '(', ')'], "_", $_v_t['t']); //Remplazar simbolos por Guion al piso _
							$__mdl_th_t[$_v_t_tt]['tt_bd'] = 'No_Tolera_'.$_v_t_tt;
						}
						
                        $_tr_i++;
						
                    }

					//Atributos
					foreach($__mdl_th_a as $_k_th => $_v_th){
						if(Chk_TbCol(['bd'=>'dwn', 'tb'=>$__dwn_dt->tab, 'cl'=>$_v_th['tt_bd'] ]) == 'no'){
							$Ls_Mdfy_Attr_A[] = ' ADD '.$_v_th['tt_bd'].' VARCHAR(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci';
						}
					}

					if( !isN($Ls_Mdfy_Attr_A) ){
						$Ls_Mdfy_Attr_g = implode(',', $Ls_Mdfy_Attr_A);
						$Ls_Mdfy_Attr = ' ALTER TABLE '._BdStr(DBD).''.$__dwn_dt->tab.'  '.$Ls_Mdfy_Attr_g; //echo $Ls_Mdfy_Attr." ------- ";
						$Ls_Mdf_A = $pdo_d->prepare($Ls_Mdfy_Attr); $Ls_Mdf_A->execute();
						if(!$Ls_Mdf_A){ print_r($Ls_Mdf_A->errorInfo()); }
					}
					
					
					//Responsable financiero
					foreach($__mdl_th_f as $_k_th_f => $_v_th_f){
						foreach($_v_th_f as $_k_th_f_2 => $_v_th_f_2){
							if(Chk_TbCol(['bd'=>'dwn', 'tb'=>$__dwn_dt->tab, 'cl'=>$_v_th_f_2['tt_bd'] ]) == 'no'){
								$Ls_Mdfy_Fnc_A[] = ' ADD '.$_v_th_f_2['tt_bd'].' VARCHAR(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci';
							}
						}
					}
					
					if( !isN($Ls_Mdfy_Fnc_A) ){
						$Ls_Mdfy_Fnc_g = implode(',', $Ls_Mdfy_Fnc_A);
						$Ls_Mdfy_Fnc = ' ALTER TABLE '._BdStr(DBD).''.$__dwn_dt->tab.'  '.$Ls_Mdfy_Fnc_g; //echo $Ls_Mdfy_Fnc." ------- ";
						$Ls_Mdf_F = $pdo_d->prepare($Ls_Mdfy_Fnc); $Ls_Mdf_F->execute();
						if(!$Ls_Mdf_F){ print_r($Ls_Mdf_F->errorInfo()); }
					}
                    
                    
                    //Roomats
                    for ($c = 1; $c <= count($__mdl_th_r); $c++) { 
                        for ($d = 1; $d <= count( $__mdl_th_r[$c] ); $d++) { 
                            if($d == 2){ $_tp_c_f = 'TEXT'; }else{ $_tp_c_f = 'VARCHAR(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci'; } 
                            if(Chk_TbCol(['bd'=>'dwn', 'tb'=>$__dwn_dt->tab, 'cl'=>$__mdl_th_r[$c][$d]['tt_bd'] ]) == 'no'){
                                $Ls_Mdfy_Romt_A[] = ' ADD '.$__mdl_th_r[$c][$d]['tt_bd'].' '.$_tp_c_f.' ';
                            }
                        }
                    } 
                     
                     if( !isN($Ls_Mdfy_Romt_A) ){
                        $Ls_Mdfy_Romt_g = implode(',', $Ls_Mdfy_Romt_A);
                        $Ls_Mdfy_Romt = ' ALTER TABLE '._BdStr(DBD).''.$__dwn_dt->tab.'  '.$Ls_Mdfy_Romt_g; //echo $Ls_Mdfy_Attr." ------- ";
                        $Ls_Mdf_R = $pdo_d->prepare($Ls_Mdfy_Romt); $Ls_Mdf_R->execute();
                        if(!$Ls_Mdf_R){ print_r($Ls_Mdf_R->errorInfo()); }
                    }
                    
                    
					
					//Topics
					foreach($__mdl_th_t as $_k_th_t => $_v_th_v){
						if(Chk_TbCol(['bd'=>'dwn', 'tb'=>$__dwn_dt->tab, 'cl'=>$_v_th_v['tt_bd'] ]) == 'no'){
                            $Ls_Mdfy_Tpc_A[] = ' ADD '.$_v_th_v['tt_bd'].' VARCHAR(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci';
                        }
					}

                    if( !isN($Ls_Mdfy_Tpc_A) ){
                        $Ls_Mdfy_Tpc_g = implode(',', $Ls_Mdfy_Tpc_A);
                        $Ls_Mdfy_Tpc = ' ALTER TABLE '._BdStr(DBD).''.$__dwn_dt->tab.'  '.$Ls_Mdfy_Tpc_g;
                        $Ls_Mdf_T = $pdo_d->prepare($Ls_Mdfy_Tpc); $Ls_Mdf_T->execute();
                        if(!$Ls_Mdf_T){ print_r($Ls_Mdf_T->errorInfo()); }
                    }
					
					$_a_c = 1;
					$_f_c = 1;
					$_r_c = 1;
					$_t_c = 1;
                    
                    foreach ($row_Ls_Rg as $r_p) {
                    
                        $_r_id = $r_p['id_dwnprc'];
                        $_pc_i = $r_p['ID'];
                        
                        $_pc_a_o = $__col_attr[ $_pc_i ];
                        $_pc_f_o = $__col_fnc[ $_pc_i ];
                        $_pc_r_o = $__col_romt[ $_pc_i ];
                        $_pc_t_o = $__col_tpc[ $_pc_i ];
                        
                        $__r_e = 'ok';
                        $update_f = [];
                        $update_f_go = '';
                         
                        if(count($_pc_a_o) > 0){ //Atributos
                            foreach($_pc_a_o as $_k => $_v ){
                                
                                if($_v['t'] != '' && $_v['t'] != NULL){
                                
                                    $__t = str_replace([':', '\\', '/', '*', '-', ' ', '(', ')'], "_", $_v['t']); //Remplazar simbolos por Guion al piso _
                                    $l_dt = LsDmc([ 'attr'=>$_v['attr'], 'id'=>$_v['v'], 'tp'=>'dt' ]); //Trae el valor de los atributos en texto
                                
                                    if( $l_dt->e == "ok" ){
                                        $_attr_vl = $l_dt->tt;
                                    }else{
                                        $_attr_vl = $_v['v'];
                                    }
                                    
                                    $update_f[] = sprintf(" ".$__t." = %s ",
                                                        GtSQLVlStr($_attr_vl, "text"));
                                
                                }
                                $_a_c++;
                            }   
                        }
                        
                        if(count($_pc_f_o) > 0){ //Responsable financiero
	                        foreach($_pc_f_o as $_k => $_v ){
                                
								$_v_dt = _jEnc($_v['dt']);
								
								//Recorre los documentos para luego separarlos
								foreach($_v_dt->dc_a as $_k_dc => $_v_dc){ $_dc_tp[] = $_v_dc->t; $_dc_tt[] = $_v_dc->n; }
								
								//Recorre los correos para luego separarlos
								foreach($_v_dt->eml as $_k_eml => $_v_eml){ $_eml_tt[] = $_v_eml->v; }
								
								//Recorre los telefonos para luego separarlos
								foreach($_v_dt->tel_all->ls as $_k_tel => $_v_tel){ $_tel_tt[] = $_v_tel->tel; }
                                	
                                	if($_v['id'] != '' && $_v['id'] != NULL){
                                
									$update_f[] = sprintf(" 
		                            						
		                            						Financiero_{$_f_c}_".TX_NM." = %s,
		                            						Financiero_{$_f_c}_".TX_SX." = %s,
		                            						Financiero_{$_f_c}_Fecha_Nacimiento = %s,
		                            						Financiero_{$_f_c}_Direccion = %s,
		                            						Financiero_{$_f_c}_Tipo_Documento = %s,
		                            						Financiero_{$_f_c}_".TX_DOCS." = %s,
															Financiero_{$_f_c}_".TX_EMAIL." = %s,
		                            						Financiero_{$_f_c}_Telefonos = %s
		                            						
		                            					",
														GtSQLVlStr( $_v_dt->nm." ".$_v_dt->ap, "text" ),
														GtSQLVlStr( $_v_dt->sx->tt, "text" ),
														GtSQLVlStr( $_v_dt->fn, "text" ),
														GtSQLVlStr( $_v_dt->dir, "text" ),
														
														GtSQLVlStr( implode("|", $_dc_tp), "text" ), //Separa los documentos por |
														GtSQLVlStr( implode("|", $_dc_tt), "text" ),
														GtSQLVlStr( implode("|", $_eml_tt), "text" ),
														GtSQLVlStr( implode("|", $_tel_tt), "text" )
														
													);
                                
                                }
                                
                                
                                if($_v['id'] != '' && $_v['id'] != NULL){ //Atributo responsable financiero
                                		
                                		foreach($_v_dt->attr as $__k_attr => $__v_attr){
										$l_dt = LsDmc([ 'attr'=>$__v_attr->attr, 'id'=>$__v_attr->vl, 'tp'=>'dt' ]);
										$__v_attr_tt = str_replace([':', '\\', '/', '*', '-', ' ', '(', ')'], "_", $__v_attr->tt); //Remplazar simbolos por Guion al piso _
										
										$update_f[] = sprintf(" 
		                            						Financiero_{$_f_c}_$__v_attr_tt = %s
		                            					",
														GtSQLVlStr( ( ($l_dt->e == "ok")? $l_dt->tt : $__v_attr->vl ) , "text" )
													);
										echo "Financiero_{$_f_c}_$__v_attr_tt <br>";
									}
									
                                	}
                                
                                
                                $_f_c++;
                            }   
                        }
                        
                        if(count($_pc_r_o) > 0){ //Roomats
                            foreach($_pc_r_o as $_k => $_v ){
                                if($_v['t'] != '' && $_v['t'] != NULL){
                                
                                    $update_f[] = sprintf("Roomat_Titulo_$_r_c=%s, Roomat_Valor_$_r_c=%s",
                                                        GtSQLVlStr(/*ctjTx(*/$_v['t']/*,'out')*/, "text"),
                                                        GtSQLVlStr(/*ctjTx(*/$_v['v']/*,'out')*/, "text"));
                                
                                }
                                $_r_c++;
                            }
                        }
                        
                        if(count($_pc_t_o) > 0){ //Topics
                            foreach($_pc_t_o as $_k => $_v ){
                                
                                if($_v['t'] != '' && $_v['t'] != NULL){
                                
                                   $__t = str_replace([':', '\\', '/', '*', '-', ' ', '(', ')'], "_", $_v['t']); //Remplazar simbolos por Guion al piso _
                                    
                                   $update_f[] = sprintf(" No_Tolera_".$__t." = %s ",
                                                        GtSQLVlStr($_v['v'], "text"));
                                
                                }
                                $_t_c++;
                            }
                        }
                        
                        
                        if(is_array($update_f)){ $update_f_go = implode(', ', $update_f); }
                         
                        if(count($update_f) > 0 && !isN($update_f_go)){
                             
                            $updateSQL = "UPDATE "._BdStr(DBD).$__dwn_dt->tab." SET ".$update_f_go." WHERE id_dwnprc='".GtSQLVlStr($_r_id, "int")."'"; 
							
							if(!isN($updateSQL)){ 
                                $Result = $__cnx->_prc($updateSQL);
                                if(!$Result){ 
									$__r_e = 'no'; $__r_all = 'no'; 
									$__w .= $__cnx->c_p->error; 
								} 
                            }
                             
                        }
                         
                        echo "Tab: ".$__dwn_dt->tab." -> Pci $_pc_i <br>";
                        
                        
                        if($__r_e == 'ok' || count($update_f) == 0){ 
                            UPD_Dwn_R(['d'=>$__dwn_dt->tab, 'r'=>$_pc_i]);
                        }else{ 
                            echo $__w;
                        }
                             
                        $_a_c = 1;
                        $_f_c = 1;
                        $_r_c = 1;
                        $_t_c = 1;
                        
                    }
                     
                }
                 
                $Ls_Rg->closeCursor();
                $Ls_Rg_Attr->closeCursor();
                 
                if($__r_all != 'no'){ UPD_Dwn(['i'=>$__dwn_dt->id, 'e'=>'2']); }
                     
                  
            }elseif($__dwn_dt->tot->no_u == 0  && $__dwn_dt->tot != 'no' && $__dwn_dt->blq == 'no'){
				
				//-------------------- Inicia Escritura de Archivo --------------------//
				$__fle_nme = '../../'.DIR_TMP_PRVT_DWN.$__dwn_dt->id.'.xlsx';
				
				
				if( file_exists($__fle_nme) ){
					
					UPD_Dwn(['i'=>$__dwn_dt->id, 'e'=>'1']);
					
				}else{
					
					UPD_Dwn(['i'=>$__dwn_dt->id, 'b'=>'1' ]);
	                
	                try{
		                
		               
		                //node _prc.js --db="c3Vtcl9fZHdu" --hst="bG9jYWxob3N0" --usr="c3Vtcg==" --pss="aGd9JSVOU21BUkZsdDBDOW1R" --fle="Li4vLi4vLi4vLi4vLi4vX3Npcy9fZmxlL3hscy9kd24vOTQ4Ny54bHN4" --qry="U0VMRUNUICogRlJPTSBfZF85NDg3" &
		                $_qry = 'SELECT * FROM _d_'.$__dwn_dt->id;
		                $_exc = exec('node ./_cnt/dwn/_prc.js --db="'.base64_encode('sumr__dwn').'" --hst="'.base64_encode('localhost').'" --usr="'.base64_encode(DB_US).'" --pss="'.base64_encode(DB_US_PSS).'" --fle="'.base64_encode($__fle_nme).'" --qry="'.base64_encode($_qry).'" &', $output); 
						
						$_exc = exec('ls', $_oo);
						
						echo $this->h2('Empty:'.print_r($_exc, true));
						
						// Notificaciones
												
						$_CRM_Ntf = new CRM_Ntf(); 
						
						$_CRM_Ntf->ntf_acc = [ 't'=>_CId('ID_NTFACC_DWNRDY'), 'v1'=>$__dwn_dt->id ];
						$_CRM_Ntf->ntf_tp  = _CId('ID_NTFTP_DWN');
						$_CRM_Ntf->ntf_sub = "cnt_appl";
						$_CRM_Ntf->cl = $_cl_dt->id;
						$_CRM_Ntf->ntf_id_enc = $__dwn_dt->enc;
						$_CRM_Ntf->ntf_id = $__dwn_dt->id;
						$_CRM_Ntf->ntf_us = $__dwn_dt->us->id;
						
						$_CRM_Ntf->Prc();
						
		                
					}catch(Exception $e){
						echo $this->ul($e->getMessage(),'','color:red');
						UPD_Dwn(['i'=>$__dwn_dt->id, 'e'=>'2', 'w'=>'Error:'.$e->getMessage()]);           
					}
	                
	                
	                UPD_Dwn(['i'=>$__dwn_dt->id, 'b'=>'2' ]);
					
				}
                
            }else{
	            
	            $__li .= $this->li('No_U:'.$__dwn_dt->tot->no_u);
	            $__li .= $this->li('Blq:'.$__dwn_dt->blq);
	            $__li .= $this->li('No hace nada');
	            
            }             
			
			echo $this->ul($__li,'','color:'.$__li_clr);
         
        }
     
    }
    
    
    $Ls_RgC->closeCursor();

	$pdo_d = '';
	$pdo = '';
                     
} 
 



?>