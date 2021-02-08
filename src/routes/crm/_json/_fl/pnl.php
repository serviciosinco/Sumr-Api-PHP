<?php 
	
	$__tp =Php_Ls_Cln($_GET['_tp']);
	$__b =Php_Ls_Cln($_GET['b']);
	
	if($__tp == 'tmp'){
		
	}else{
		
		$__box = explode('|', $__b);
		
		//print_r($__box);
		foreach($__box as $_v){
			
			$_v_enc = $_v;
			$_v_tbl['_tt'] = '';
			$_v_tbl['_vl'] = '';
			$_v_tbl['_id'] = '';
			$_v_tbl['_ctg'] = '';
			$_tot = ''; $_js_v = []; $_js_name = [];
			
			//echo $_v_enc; exit();
			
			try {
			
				$__tme_s = microtime(true);
				$__k_r = $_v;
				// Reemplaza por Query
				
				if($_v != '' && $_v != NULL){
	
					$_v = str_replace("box_", "", $_v);
					
					$Ls_Cnt_Qry = "SELECT * FROM "._BdStr(DBM).TB_DSH_GRPH_BX." INNER JOIN "._BdStr(DBM).TB_DSH_MTRC." ON dshgrphbx_mtrc = id_dshmtrc WHERE dshgrphbx_enc = '".$_v."'";
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
							
							if($__rw[$row_Ls_Cnt_Rg['dshmtrc_qry_vl']] != '' && $__rw[$row_Ls_Cnt_Rg['dshmtrc_qry_vl']] != NULL ){
								if($___i_grph == 5){
									if($__rw[$___f_tt] != '' && $__rw[$___f_tt] != NULL){
										if($___f_tt != '' && $___f_tt != NULL){ $_v_tbl['_tt'][] = ctjTx($__rw[$___f_tt],'in'); }else{ $_v_tbl['_tt'][] = '-NA-'; $_v_tbl['_tt_th'] = '-NA-'; }
										if($___f_vl != '' && $___f_vl != NULL){ $_v_tbl['_vl'][] = ctjTx($__rw[$___f_vl],'in'); }else{ $_v_tbl['_vl'][] = '-NA-'; $_v_tbl['_vl_th'] = '-NA-'; }
										if($___f_id != '' && $___f_id != NULL){ $_v_tbl['_id'][] = ctjTx($__rw[$___f_id],'in'); }else{ $_v_tbl['_id'][] = '-NA-'; $_v_tbl['_id_th'] = '-NA-'; }
										if($___f_ctg != '' && $___f_ctg != NULL){ $_v_tbl['_ctg'][] = ctjTx($__rw[$___f_ctg],'in'); }else{ $_v_tbl['_ctg'][] = '-NA-'; $_v_tbl['_ctg_th'] = '-NA-'; }
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
			
			} catch (Exception $e) {
			    $rsp['w'] = $_v.' -> '.$e->getMessage();
			}
		}
		
	}
	
	$rsp['g'] = $pnl;	
	$rsp['g_tme'] = $pnl_t;
	$rsp['e'] = "ok";


?>