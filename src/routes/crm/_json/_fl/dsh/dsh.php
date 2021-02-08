<?php			  
	
	Hdr_JSON();
	$_tp = Php_Ls_Cln($_POST['_tp']);
	$_enc = Php_Ls_Cln($_POST['_enc']);
	
	try{
		
		if($_tp == '_start'){
			
			//Trae la informacion de la tabla dsh
			$GtDshLs = GtDshLs(['tp'=>'dsh', 'Sv'=>'ok']);	
			//Consulta la tabla sis_col_tp y muestra los tipos de columnas a elegir
			$GtSisColTpDt = GtSisColTpDt();	
			//Consulta las graficas
			$GrphRow = GtGrphRowDt();

			$rsp['d']['ls'] = $GtDshLs->ls;
			$rsp['d']['dt'] = $GtDshLs->dt;
			$rsp['d']['row']['ls'] = $GrphRow;
			$rsp['d']['col']['tp'] = $GtSisColTpDt;

		}elseif($_tp == '_box'){
			
			$_id_col = Php_Ls_Cln($_POST['_id_col']);
			
			$query_DtRg = "INSERT INTO "._BdStr(DBM).TB_DSH_COL_BX." (dshcolbx_dshcol, dshcolbx_us) VALUES (".$_id_col.", ".SISUS_ID.")";
			$DtRg = $__cnx->_prc($query_DtRg);

			if($DtRg){
				$rsp['e'] = 'ok';
				$rsp['tp'] = TX_INGRSD;
				$rsp['_grph_ls'] = GtGrphRowDt();
				$GtDshLs = GtDshLs(["tp"=>"dsh"]); 
				$rsp['_dsh_ls'] = $GtDshLs->ls; 
			}else{
				$rsp['e'] = 'no';
				$rsp['tps'] = $query_DtRg;
			}
			
		}elseif($_tp == '_dsh'){
			
			
			
			$GtDshDt = GtDshLs(["tp"=>"null"]);
			if($GtDshDt->dsh_ord_ult > 0 && $GtDshDt->dsh_ord_ult != '' && $GtDshDt->dsh_ord_ult != NULL){
				$_ult = ($GtDshDt->dsh_ord_ult+1);
			}else{
				$_ult = 1;
			}
			
			//Insertar una fila DashBoard
			$_enc = enCad($_tp."-".SISUS_ID.Gn_Rnd(5));
			
			$query_DtRg = "INSERT INTO "._BdStr(DBM).TB_DSH." (dsh_us, dsh_enc, dsh_ord) VALUES (".SISUS_ID.", '".$_enc."', ".$_ult.")";
			$DtRg = $__cnx->_prc($query_DtRg);
			$_id_prnt = $__cnx->c_p->insert_id;
			
			if($DtRg){	
				
				//Insertar una Columna
				$_enc_dsh_col = enCad($_id_prnt.Gn_Rnd(5));
				$_qry_col = "INSERT INTO "._BdStr(DBM).TB_DSH_COL." (dshcol_dsh, dshcol_enc, dshcol_ord, dshcol_us) VALUES (".$_id_prnt.", '".$_enc_dsh_col."', 1, ".SISUS_ID.")";
				$query_upd = "UPDATE "._BdStr(DBM).TB_DSH." SET dsh_coltp = 1 WHERE id_dsh = ".$_id_prnt."";
				$DtRg_col = $__cnx->_prc($_qry_col); 
				$DtRg_upd = $__cnx->_prc($query_upd);
				
				//Segunda Fila
				$_id_prnt = $__cnx->c_p->insert_id;
				$GtDshDtPrnt = GtDshLs(["tp"=>"dsh_prnt", "dsh_prnt"=>$_id_prnt]);
				if($GtDshDtPrnt->dsh_ord_ult > 0 && $GtDshDtPrnt->dsh_ord_ult != '' && $GtDshDtPrnt->dsh_ord_ult != NULL){
					$_ultPrnt = ($GtDshDtPrnt->dsh_ord_ult+1);
				}else{
					$_ultPrnt = 1;
				}
				
				//Insertar segunda fila
				$_enc_dsh = enCad($_id_prnt.'-'.SISUS_ID.Gn_Rnd(5));
				$query_DtRgPrnt = "INSERT INTO "._BdStr(DBM).TB_DSH." (dsh_us, dsh_enc, dsh_prnt, dsh_ord) VALUES (".SISUS_ID.", '".$_enc_dsh."', ".$_id_prnt.", ".$_ultPrnt.")";
				$DtRgPrnt = $__cnx->_prc($query_DtRgPrnt);
				$_id_dsh = $__cnx->c_p->insert_id;
				
				if($DtRg){	
				
					$_enc_dsh_col = enCad($_id_prnt.SISUS_ID.Gn_Rnd(5));
					$_qry_col_prnt = "INSERT INTO "._BdStr(DBM).TB_DSH_COL." (dshcol_dsh, dshcol_enc, dshcol_ord, dshcol_us) VALUES (".$_id_dsh.", '".$_enc_dsh_col."', 1, ".SISUS_ID.")";
					$DtRg_col_prnt = $__cnx->_prc($_qry_col_prnt);
					
					$query_upd_prnt = "UPDATE "._BdStr(DBM).TB_DSH." SET dsh_coltp = 1 WHERE id_dsh = ".$_id_dsh."";
					$DtRg_upd_prnt = $__cnx->_prc($query_upd_prnt);
					
					$_id_col = $__cnx->c_p->insert_id;
					$query_DtRg = "INSERT INTO "._BdStr(DBM).TB_DSH_COL_BX." (dshcolbx_dshcol, dshcolbx_us) VALUES (".$_id_col.", ".SISUS_ID.")";
					$DtRg = $__cnx->_prc($query_DtRg);
					
				}
				
				$rsp['e'] = 'ok';
				$rsp['_grph_ls'] = GtGrphRowDt();
				$GtDshLs = GtDshLs(["tp"=>"dsh"]); 
				$rsp['_dsh_ls'] = $GtDshLs->ls;
				$rsp['tp'] = TX_INGRSD;
				
			}else{
				$rsp['e'] = 'no';
			}
			
		}elseif($_tp == '_dsh_prnt'){
			
			$_id_prnt = Php_Ls_Cln($_POST['_id_prnt']);
			
			
			$GtDshDt = GtDshLs(["tp"=>"dsh_prnt", "dsh_prnt"=>$_id_prnt]);
			//echo $GtDshDt->dsh_ord_ult." pi ".$_id_prnt." ".$GtDshDt->qry; exit();
			if($GtDshDt->dsh_ord_ult > 0 && $GtDshDt->dsh_ord_ult != '' && $GtDshDt->dsh_ord_ult != NULL){
				$_ult = ($GtDshDt->dsh_ord_ult+1);
			}else{
				$_ult = 1;
			}
			
			//Insertar una fila DashBoard
			$query_DtRg = "INSERT INTO "._BdStr(DBM).TB_DSH." (dsh_us, dsh_prnt, dsh_ord) VALUES (".SISUS_ID.", ".$_id_prnt.", ".$_ult.")";
			$DtRg = $__cnx->_prc($query_DtRg);
			$_id_dsh = $__cnx->c_p->insert_id;
			
			if($DtRg){	
				
				$_qry_col = "INSERT INTO "._BdStr(DBM).TB_DSH_COL." (dshcol_dsh, dshcol_ord, dshcol_us) VALUES (".$_id_dsh.", 1, ".SISUS_ID.")";
				$query_upd = "UPDATE "._BdStr(DBM).TB_DSH." SET dsh_coltp = 1 WHERE id_dsh = ".$_id_dsh."";
				$DtRg_col = $__cnx->_prc($_qry_col); $DtRg_upd = $__cnx->_prc($query_upd);
				
				$rsp['e'] = 'ok';
				$rsp['tp'] = TX_INGRSD;
				$rsp['_grph_ls'] = GtGrphRowDt();
				$GtDshLs = GtDshLs(["tp"=>"dsh"]); 
				$rsp['_dsh_ls'] = $GtDshLs->ls; 
				
			}else{
				$rsp['e'] = 'no';
			}
			
		}elseif($_tp == '_dsh_eli' || $_tp == '_dsh_eli_prnt'){
			
			$_id_dsh = Php_Ls_Cln($_POST['_id_dsh']);
			$_id_prnt = Php_Ls_Cln($_POST['_id_prnt']);
			
			
			
			//Insertar una fila DashBoard
			$query_DtRg = "DELETE FROM  ".TB_DSH." WHERE id_dsh = ".$_id_dsh."";
			$DtRg = $__cnx->_prc($query_DtRg);
			
			if($_tp == '_dsh_eli_prnt'){
				$GtDshDt = GtDshLs(["tp"=>"dsh_prnt", "dsh_prnt"=>$_id_prnt]);
			}else{
				$GtDshDt = GtDshLs(["tp"=>"null"]);
			}
			
			$_ord = 1;
			
			foreach($GtDshDt->ls as $_k => $_v){
				if($_v->id != '' && $_v->id != NULL){
					$_qry_ord = "UPDATE  ".TB_DSH." SET dsh_ord = ".$_ord." WHERE id_dsh = ".$_v->id." ";
					$DtRg_Ord = $__cnx->_prc($_qry_ord);
					$_ord++;
				}
			}
			
			if($DtRg){	
				$rsp['e'] = 'ok';
				$rsp['_grph_ls'] = GtGrphRowDt();
				$GtDshLs = GtDshLs(["tp"=>"dsh"]); 
				$rsp['_dsh_ls'] = $GtDshLs->ls; 
				$rsp['tp'] = TX_RMVD;
			}else{
				$rsp['e'] = 'no';
			}
			
		}elseif($_tp == '_dsh_col_prs'){
		
			$w_1 = Php_Ls_Cln($_POST['w_1']);
			$w_2 = Php_Ls_Cln($_POST['w_2']);
			$w_3 = Php_Ls_Cln($_POST['w_3']);
			$w_4 = Php_Ls_Cln($_POST['w_4']);
			$w_5 = Php_Ls_Cln($_POST['w_5']);
			$w_6 = Php_Ls_Cln($_POST['w_6']);
		
			if(($w_1+$w_2+$w_3+$w_4+$w_5+$w_6) > 100){
				$rsp['e'] = 'no';
				$rsp['w'] = TX_SMCLMNS;
			}else{
		
				//Da formato decimal a los numeros y les resta 0.5
				if($w_1 > 0){ $w_1 = number_format(($w_1-0.5), 2, '.', ','); }
				if($w_2 > 0){ $w_2 = number_format(($w_2-0.5), 2, '.', ','); }
				if($w_3 > 0){ $w_3 = number_format(($w_3-0.5), 2, '.', ','); }
				if($w_4 > 0){ $w_4 = number_format(($w_4-0.5), 2, '.', ','); }
				if($w_5 > 0){ $w_5 = number_format(($w_5-0.5), 2, '.', ','); }
				if($w_6 > 0){ $w_6 = number_format(($w_6-0.5), 2, '.', ','); }
				
				$_id_prnt = Php_Ls_Cln($_POST['_id_dsh']);
				$_clmn_tp = Php_Ls_Cln($_POST['dshcolprs_cant']);
				
				//Consultar la tabla sis_col_tp
				$GtSisColTpDt = GtSisColTpDt(["v"=>$_clmn_tp]);
				foreach($GtSisColTpDt as $_k => $_v){
					$_v_clmn_tp = $_v->id;
				}
				
				
				//Actualizar el campo dsh_coltp de la fila DashBoard 
				$query_DtRg = "UPDATE  ".TB_DSH." SET dsh_coltp = ".$_v_clmn_tp." WHERE id_dsh = ".$_id_prnt."";
				
				// -- Validar si se necesitan agregar o eliminar columnas --
				$GtDshDt = GtDshLs(["id"=>$_id_prnt]);
				
				//Valor absoluto
				$_v_abs = abs(($GtDshDt->dt->{$_id_prnt}->tot - $_clmn_tp));
				
				if($GtDshDt->dt->{$_id_prnt}->coltp_prs > 0){
					$_qry_prs = sprintf("UPDATE ".TB_DSH_COLTP_PRS." SET dshcoltpprs_v = %s, dshcoltpprs_w1 = %s, dshcoltpprs_w2 = %s,
																  dshcoltpprs_w3 = %s, dshcoltpprs_w4 = %s, dshcoltpprs_w5 = %s,
																  dshcoltpprs_w6 = %s WHERE dshcoltpprs_dsh = %s
																  ",
																  GtSQLVlStr($_clmn_tp, "int"), GtSQLVlStr($w_1, "text"), GtSQLVlStr($w_2, "text"),
																  GtSQLVlStr($w_3, "text"), GtSQLVlStr($w_4, "text"), GtSQLVlStr($w_5, "text"),
																  GtSQLVlStr($w_6, "text"), GtSQLVlStr($_id_prnt, "int"));
				}else{
					$_qry_prs = sprintf("INSERT INTO ".TB_DSH_COLTP_PRS." (dshcoltpprs_v, dshcoltpprs_w1, dshcoltpprs_w2,
																	dshcoltpprs_w3, dshcoltpprs_w4, dshcoltpprs_w5,
																	dshcoltpprs_w6, dshcoltpprs_dsh)
															 VALUES( %s, %s, %s, 
																     %s, %s, %s, 
																 	 %s, %s )",
														 		     GtSQLVlStr($_clmn_tp, "int"), GtSQLVlStr($w_1, "text"), GtSQLVlStr($w_2, "text"),
														 		     GtSQLVlStr($w_3, "text"), GtSQLVlStr($w_4, "text"), GtSQLVlStr($w_5, "text"),
														 		     GtSQLVlStr($w_6, "text"), GtSQLVlStr($_id_prnt, "int"));
				}
				
				//Validar si se inserta o elimina
				if($GtDshDt->dt->{$_id_prnt}->tot < $_clmn_tp){
					$_qry = "INSERT INTO ".TB_DSH_COL." (dshcol_dsh, dshcol_ord, dshcol_us) VALUES (".$_id_prnt.", %s, ".SISUS_ID.")";
				}elseif($GtDshDt->dt->{$_id_prnt}->tot > $_clmn_tp){
					$_qry = "DELETE FROM ".TB_DSH_COL." WHERE dshcol_dsh = ".$_id_prnt."  ORDER BY id_dshcol DESC LIMIT 1";
				}else{
					$_sme = 'ok';
					$rsp['tp'] = TX_INGRSD;
				}
				
				if($GtDshDt->dt->{$_id_prnt}->ord_ult > 0){
					$_ord = $GtDshDt->dt->{$_id_prnt}->ord_ult;
				}else{
					$_ord = 0;
				}
				
				//Inserta o elimina las columnas
				for($i=1; $i <= $_v_abs; $i++){
					$_ord = ($_ord+1);
					$query_dsh_col = sprintf($_qry, GtSQLVlStr($_ord, "int"));
					$DtRg_dsh_col = $__cnx->_prc($query_dsh_col);
				}
				$DtRg_dsh_col_prs = $__cnx->_prc($_qry_prs);
				$DtRg = $__cnx->_prc($query_DtRg);
				
				if($DtRg && $DtRg_dsh_col && $DtRg_dsh_col_prs || $_sme == 'ok'){	
					$rsp['e'] = 'ok';
					$rsp['_grph_ls'] = GtGrphRowDt();
					$GtDshLs = GtDshLs(["tp"=>"dsh"]); 
					$rsp['_dsh_ls'] = $GtDshLs->ls; 
					$rsp['tp'] = TX_INGRSD;
				}else{
					$rsp['e'] = 'no';
					$rsp['w'] = TX_ERNGRSR;
				}
			}
			
		}elseif($_tp == '_dsh_col'){
		
			$_id_prnt = Php_Ls_Cln($_POST['_id_prnt']);
			$_clmn_tp = Php_Ls_Cln($_POST['_clmn_tp']);
			
			//Consultar la tabla sis_col_tp
			$GtSisColTpDt = GtSisColTpDt(["id"=>$_clmn_tp]);
			
			
			//Actualizar el campo dsh_coltp de la fila DashBoard 
			$query_DtRg = "UPDATE  ".TB_DSH." SET dsh_coltp = ".$_clmn_tp." WHERE id_dsh = ".$_id_prnt."";
			
			// -- Validar si se necesitan agregar o eliminar columnas --
			$GtDshDt = GtDshLs(["id"=>$_id_prnt]);
			
			if($GtDshDt->dt->{$_id_prnt}->coltp_prs > 0){
				$_qry_prs = "DELETE FROM ".TB_DSH_COLTP_PRS." WHERE dshcoltpprs_dsh = ".$_id_prnt." ";
				$DtRg_dsh_col_prs = $__cnx->_prc($_qry_prs);
			}
			
			//Valor absoluto
			$_v_abs = abs(($GtDshDt->dt->{$_id_prnt}->tot - $GtSisColTpDt->{$_clmn_tp}->v));
			
			//Validar si se inserta o elimina
			if($GtDshDt->dt->{$_id_prnt}->tot < $GtSisColTpDt->{$_clmn_tp}->v){
				$_qry = "INSERT INTO ".TB_DSH_COL." (dshcol_dsh, dshcol_ord, dshcol_us) VALUES (".$_id_prnt.", %s, ".SISUS_ID.")";
			}elseif($GtDshDt->dt->{$_id_prnt}->tot > $GtSisColTpDt->{$_clmn_tp}->v){
				$_qry = "DELETE FROM ".TB_DSH_COL." WHERE dshcol_dsh = ".$_id_prnt."  ORDER BY id_dshcol DESC LIMIT 1";
			}else{
				$_sme = 'ok';
				$rsp['tp'] = TX_INGRSD;
			}
			
			if($GtDshDt->dt->{$_id_prnt}->ord_ult > 0){
				$_ord = $GtDshDt->dt->{$_id_prnt}->ord_ult;
			}else{
				$_ord = 0;
			}
			
			//Inserta o elimina las columnas
			for($i=1; $i <= $_v_abs; $i++){
				
				$_ord = ($_ord+1);
				
				$query_dsh_col = sprintf($_qry, GtSQLVlStr($_ord, "int"));
				$DtRg_dsh_col = $__cnx->_prc($query_dsh_col);
			}
			
			$DtRg = $__cnx->_prc($query_DtRg);
			
			if($DtRg && $DtRg_dsh_col || $_sme == 'ok'){	
				$rsp['_grph_ls'] = GtGrphRowDt();
				$GtDshLs = GtDshLs(["tp"=>"dsh"]); 
				$rsp['_dsh_ls'] = $GtDshLs->ls; 
				$rsp['e'] = 'ok';
			}else{
				$rsp['e'] = 'no';
			}
			
		}elseif($_tp == '_dsh_str' || $_tp == '_dsh_str_prnt'){
		
			$_id_dsh = Php_Ls_Cln($_POST['_id_dsh']);
			$_new_position = Php_Ls_Cln($_POST['new_position']);
			$_old_position = Php_Ls_Cln($_POST['old_position']);
			$_id_prnt = Php_Ls_Cln($_POST['_id_prnt']);
			
			if($_tp == '_dsh_str_prnt'){
				$GtDshDt = GtDshLs(["tp"=>"dsh_prnt", "dsh_prnt"=>$_id_prnt]);
				$_fl .= "AND dsh_prnt = $_id_prnt ";
			}else{
				$GtDshDt = GtDshLs(["tp"=>"null"]);
			}			
			
			foreach($GtDshDt->ls as $_k => $_v){
				if($_v->id != '' && $_v->id != NULL && $_v->id != $_id_dsh){
					if($_new_position > $_old_position){
						$query_DtRg_ord = "UPDATE  ".TB_DSH." SET dsh_ord = ".($_v->dsh_ord-1)." WHERE id_dsh = ".$_v->id." AND id_dsh != ".$_id_dsh." AND dsh_ord <= ".$_new_position." AND dsh_ord > ".$_old_position." ".$_fl." ";
					}elseif($_new_position < $_old_position){
						$query_DtRg_ord = "UPDATE  ".TB_DSH." SET dsh_ord = ".($_v->dsh_ord+1)." WHERE id_dsh = ".$_v->id." AND id_dsh != ".$_id_dsh." AND dsh_ord < ".$_old_position." AND dsh_ord >= ".$_new_position." ".$_fl." ";
					}
					$DtRg_ord = $__cnx->_prc($query_DtRg_ord);
				}
			}
			
			$query_DtRg = "UPDATE  ".TB_DSH." SET dsh_ord = ".$_new_position." WHERE id_dsh = ".$_id_dsh." ";
			$DtRg = $__cnx->_prc($query_DtRg);
			
			if($DtRg){	
				$rsp['e'] = 'ok';
				$rsp['tp'] = TX_MVD;
			}else{
				$rsp['e'] = 'no';
			}
			
		}elseif($_tp == '_dsh_dms_ls'){
			
			$_grph = Php_Ls_Cln($_POST['_grph']);
			$DshDmsLs = GtDshDmsLs( ['id_grph'=>$_grph] );
			
			if($DshDmsLs->tot > 0){
				$rsp['e'] = 'ok';
				$rsp['ls'] = $DshDmsLs->ls;
			}else{
				throw new Exception((ChckSESS_superadm()) ? "- ".$DshDmsLs->w : "- ".$DshDmsLs->w);
			}
			
		}elseif($_tp == '_dsh_mtrc_ls'){
			
			$_dms = Php_Ls_Cln($_POST['_dms']);
			$DshMtrcLs = GtDshMtrcLs( ['id_dms'=>$_dms] );
			
			if($DshMtrcLs->tot > 0){
				$rsp['e'] = 'ok';
				$rsp['ls'] = $DshMtrcLs->ls;
			}else{
				throw new Exception((ChckSESS_superadm()) ? "- ".$DshMtrcLs->w : "- ".$DshMtrcLs->w);
			}
			
		}elseif($_tp == '_dsh_pnl'){
			
			$__b = Php_Ls_Cln($_POST['b']);
			$__box = json_decode(json_encode($__b));
			
			foreach($__box as $_k => $_v){
				
				$_v_enc = $_v->enc;
				$_v_tbl['_tt'] = '';
				$_v_tbl['_vl'] = '';
				$_v_tbl['_id'] = '';
				$_v_tbl['_ctg'] = '';
				$_tot = ''; $_js_v = []; $_js_name = [];
				
				//echo $_v_enc; exit();
				
				try {
				
					$__tme_s = microtime(true);
					$__k_r = $_v->enc;
					// Reemplaza por Query
					
					if($_v->enc != '' && $_v->enc != NULL){
		
						$_v->enc = str_replace("box_", "", $_v->enc);
						
						$Ls_Cnt_Qry = "	SELECT * 
										FROM "._BdStr(DBM).TB_DSH_GRPH_BX." 
											 INNER JOIN "._BdStr(DBM).TB_DSH_MTRC." ON dshgrphbx_mtrc = id_dshmtrc 
										WHERE dshgrphbx_enc = '".$_v->enc."'";
						
						$Ls_Cnt_Rg = $__cnx->_qry($Ls_Cnt_Qry);  
						$row_Ls_Cnt_Rg = $Ls_Cnt_Rg->fetch_assoc(); 
						$Tot_Ls_Cnt_Rg = $Ls_Cnt_Rg->num_rows;
						
						$Qry_Grph = $row_Ls_Cnt_Rg['dshmtrc_qry'];
						
						//Convertir en costantes
						
						preg_match_all('/\[.*?\]/', $Qry_Grph, $__all);
						
						if(count($__all) > 0){
							foreach($__all[0] as $Key_sch){
								$key_cln = str_replace(['[',']'],'', $Key_sch);
								$Qry_Grph = str_replace($Key_sch, _Cns($key_cln),  $Qry_Grph);
							}
						}
						
						$Qry_Grph_Exc = $__cnx->_qry($Qry_Grph);
				
						$___i_grph = $row_Ls_Cnt_Rg['dshgrphbx_grph'];
						$___f_id = $row_Ls_Cnt_Rg['dshmtrc_qry_id'];
						$___f_tt = $row_Ls_Cnt_Rg['dshmtrc_qry_tt'];
						$___f_ctg = $row_Ls_Cnt_Rg['dshmtrc_qry_ctg'];
						$___f_vl = $row_Ls_Cnt_Rg['dshmtrc_qry_vl'];
						
						if($Qry_Grph_Exc){
						
							$_v_tbl['_tot'] = $Qry_Grph_Exc->num_rows;
							
							do {
								
								if( !isN( $__rw[$row_Ls_Cnt_Rg['dshmtrc_qry_vl']] ) ){
									if($___i_grph == 5){
										if(!isN($$__rw[$___f_tt])){
											if(!isN($___f_tt)){ $_v_tbl['_tt'][] = ctjTx($__rw[$___f_tt],'in'); }else{ $_v_tbl['_tt'][] = '-NA-'; $_v_tbl['_tt_th'] = '-NA-'; }
											if(!isN($___f_vl)){ $_v_tbl['_vl'][] = ctjTx($__rw[$___f_vl],'in'); }else{ $_v_tbl['_vl'][] = '-NA-'; $_v_tbl['_vl_th'] = '-NA-'; }
											if(!isN($___f_id)){ $_v_tbl['_id'][] = ctjTx($__rw[$___f_id],'in'); }else{ $_v_tbl['_id'][] = '-NA-'; $_v_tbl['_id_th'] = '-NA-'; }
											if(!isN($___f_ctg)){ $_v_tbl['_ctg'][] = ctjTx($__rw[$___f_ctg],'in'); }else{ $_v_tbl['_ctg'][] = '-NA-'; $_v_tbl['_ctg_th'] = '-NA-'; }
										}
									}else{
										$_tot = (int)$__rw[$row_Ls_Cnt_Rg['dshmtrc_qry_vl']];
									
										if($___i_grph == 2){
											$_js_v[] = ['name'=>$__rw[$___f_tt], 'data'=>$_tot, 'color'=>Gn_Rnd_Clr()];
										}else{
											$_js_v[] = ['name'=>$__rw[$___f_tt], 'data'=>[$_tot], 'color'=>Gn_Rnd_Clr()];
										}
										
										if($___f_ctg != NULL){ $_js_c[] = $__rw[$___f_ctg]; } 
										
										//--------------- Trabaja Historicos ---------------//
										
										$_js_name[ $__rw[$___f_id] ] = ['id'=>$__rw[$___f_id], 'name'=>$__rw[$___f_tt].$__rw['_id_grp'], 'data'=>[$_tot], 'color'=>Gn_Rnd_Clr()];
										$_js_series[ $__rw[$___f_ctg] ][ $__rw[$___f_id] ] = $_tot>0?$_tot:'0';
									}
									
								}
								
								
							} while ($__rw = $Qry_Grph_Exc->fetch_assoc()); 
						
						}
							
						if($___i_grph != 3 && $___i_grph != 4){ $_js_name = $_js_v; }
						
						$__bld = Dsh_Bld([ 
							'graphic'=>$___i_grph, 
							'name'=>$_js_name,
							'categories'=>$_js_c,
							'series'=>$_js_series
						]); 
						
						if($___i_grph == 5){
							$pnl[$__k_r]['d'] = $_v_tbl;
						}elseif($___i_grph == 2){
							foreach($_js_v as $_k => $_v){
								$_t = $_t  + $_v['data'];
							}
							foreach($_js_v as $_k => $_v){
								$pnl[$__k_r]['d'][] = ['name'=>$_v['name'], 'y'=>($_v['data']/$_t)*100];
							}
							
							
						}else{
							$pnl[$__k_r]['d'] = $__bld->js->v;
							$pnl[$__k_r]['c'] = $__bld->js->c;
						}
					}		
									
					$__tmexc = _Rg_Tme($__tme_s, microtime(true));
					$pnl_t[$__k_r] = $__tmexc->tme_s; 
				
					$rsp['e'] = 'ok';
					$rsp['g'] = $pnl;	
					$rsp['g_tme'] = $pnl_t;
				
				} catch (Exception $e) {
				    $rsp['w'] = $_v->enc.' -> '.$e->getMessage();
				}
				
			}
			
		}elseif($_tp == '_dsh_grph_bx'){
		
			$_dsh_tp = Php_Ls_Cln($_POST['_dsh_tp']);
			$_dms = Php_Ls_Cln($_POST['_dms']);
			$_mtrc = Php_Ls_Cln($_POST['_mtrc']);
			$_tt = Php_Ls_Cln($_POST['_tt']);
			$_clr_bc = Php_Ls_Cln($_POST['_clr_bc']);
			$_clr = Php_Ls_Cln($_POST['_clr']);
			$_row = Php_Ls_Cln($_POST['_bx']);
			$_i = Php_Ls_Cln($_POST['_id_grphbx']);
			
			
		
							
			if($_POST['_tp_sve'] == '_in'){
				
			$query_DtRg = "INSERT INTO ".TB_DSH_GRPH_BX." (dshgrphbx_tt, dshgrphbx_bx, dshgrphbx_mtrc, dshgrphbx_grph, dshgrphbx_us, dshgrphbx_clr_bc, dshgrphbx_clr) VALUES ('".$_tt."', ".$_row.", ".$_mtrc.", ".$_dsh_tp.", ".SISUS_ID.", '".$_clr_bc."','".$_clr."')";
				$DtRg = $__cnx->_prc($query_DtRg);

				$_id = $__cnx->c_p->insert_id;
				$_enc = enCad(ctjTx($_id.$_tt,'out'));
				$query_Enc = "UPDATE ".TB_DSH_GRPH_BX." SET dshgrphbx_enc = '".$_enc."' WHERE id_dshgrphbx = ".$_id."";
				$DtEnc = $__cnx->_prc($query_Enc);
				
			}elseif($_POST['_tp_sve'] == '_mod'){
				$_enc = enCad(ctjTx($_i.$_tt,'out'));
							
				$query_DtRg = "UPDATE ".TB_DSH_GRPH_BX." SET dshgrphbx_tt='".$_tt."', dshgrphbx_bx=".$_row.", dshgrphbx_mtrc=".$_mtrc.", dshgrphbx_grph=".$_dsh_tp.", dshgrphbx_us=".SISUS_ID.", dshgrphbx_enc = '".$_enc."', dshgrphbx_clr_bc = '".$_clr_bc."', dshgrphbx_clr = '".$_clr."' WHERE id_dshgrphbx = ".$_i."";
				$DtRg = $__cnx->_prc($query_DtRg);

			}
			if($DtRg){	
					$rsp['e'] = 'ok';
					$rsp['ls'] = GtGrphRowDt();
				}else{
					$rsp['e'] = 'no';
					$rsp['t'] = $query_DtRg;
					$rsp['w'] = $__cnx->c_p->error;
					
				}
		
		 	
		}else{
			throw new Exception((ChckSESS_superadm()) ? "-".TX_NEXTP.$_tp : "");
		}
	}catch(Exception $e){
		$rsp['e'] = 'no';
		$rsp['w'] = TX_NSPPCSR.$e->getMessage();
	} 
?> 