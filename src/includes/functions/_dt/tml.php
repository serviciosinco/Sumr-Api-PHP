<?php 


	function do_srt_dte($a, $b) {
	    $aval = strtotime($a['fi']);
	    $bval = strtotime($b['fi']);
	    if ($aval == $bval) { return 0; }
	    return $aval > $bval ? -1 : 1;
	}
	
	
	function GtCntTml($p=NULL){
		
		global $__cnx;
		
		$_o = [];

		$_o = GtCntTmlMsj([ 'i'=>$p['cnt'] ]);
		$_o = GtCntTmlEst([ 'i'=>$p['cnt'], 'a'=>$_o ]);
		$_o = GtCntTmlMdl([ 'i'=>$p['cnt'], 'a'=>$_o ]);
		$_o = GtCntTmlMdlHis([ 'i'=>$p['cnt'], 'a'=>$_o ]);
		$_o = GtCntTmlCall([ 'i'=>$p['cnt'], 'a'=>$_o ]);
		$_o = GtCntTmlEc([ 'i'=>$p['cnt'], 'a'=>$_o ]);
		$_o = GtCntTmlTra([ 'i'=>$p['cnt'], 'a'=>$_o ]);
		$_o = GtCntTmlVst([ 'i'=>$p['cnt'], 'a'=>$_o ]);
		$_o = GtCntTmlCkTrck([ 'i'=>$p['cnt'], 'a'=>$_o ]);
		$_o = GtCntTmlEml([ 'i'=>$p['cnt'], 'a'=>$_o ]);
		$_o = GtCntTmlDc([ 'i'=>$p['cnt'], 'a'=>$_o ]);
		$_o = GtCntTmlTel([ 'i'=>$p['cnt'], 'a'=>$_o ]);
		$_o = GtCntTmlWbhk([ 'i'=>$p['mdl_cnt'], 'a'=>$_o ]);
		$_o = GtCntTmlMd([ 'i'=>$p['mdl_cnt'], 'a'=>$_o ]);
		$_o = GtCntTmlMdP([ 'i'=>$p['mdl_cnt'], 'a'=>$_o ]);
		$_o = GtCntTmlTraEst([ 'i'=>$p['cnt'], 'a'=>$_o ]);
		$_o = GtCntTmlTraCmnt([ 'i'=>$p['cnt'], 'a'=>$_o ]);
		$_o = GtCntTmlTraCtrl([ 'i'=>$p['cnt'], 'a'=>$_o ]);
		$_o = GtCntTmlTraHisCol([ 'i'=>$p['cnt'], 'a'=>$_o ]);
		
		
		usort($_o, 'do_srt_dte');
		
		$_r['tot'] = count($_o);
		$_r['ls'] = $_o;
							
		$rtrn = _jEnc($_r);
		return($rtrn);
	}
	
	
	function GtCntTmlMsj($p=NULL){
		
		global $__cnx;
		
		if(!isN($p['i'])){	
			 
			$Ls_Qry = "	SELECT id_mdlcntmsj, mdlcntmsj_msj, mdlcntmsj_fi, mdl_nm
							FROM ".TB_MDL_CNT_MSJ."
								 INNER JOIN ".TB_MDL_CNT." ON mdlcntmsj_mdlcnt = id_mdlcnt
								 INNER JOIN ".TB_MDL." ON mdlcnt_mdl = id_mdl
							WHERE mdlcnt_cnt = ".GtSQLVlStr($p['i'], "int")."	 
							ORDER BY mdlcntmsj_fi DESC
							LIMIT 10";	  	  
							 
			$Ls_Rg = $__cnx->_qry($Ls_Qry);
			
			if($Ls_Rg){
			
				$row_Ls_Rg = $Ls_Rg->fetch_assoc(); $Tot_Ls_Rg = $Ls_Rg->num_rows; 
				
				if($Tot_Ls_Rg > 0){

		            do{

			            $_id = 'mdl-msj-'.$row_Ls_Rg['id_mdlcntmsj'];
		                $_r[$_id]['t'] = 'mdl-msj';
		                $_r[$_id]['id'] = $row_Ls_Rg['id_mdlcntmsj'];
		                $_r[$_id]['fi'] = $row_Ls_Rg['mdlcntmsj_fi'];
		                $_r[$_id]['tt'] = TX_SCRTNTR.' '.Strn(ctjTx($row_Ls_Rg['mdl_nm'],'in')).
										  ' : <div class="cmnt">'.ctjTx($row_Ls_Rg['mdlcntmsj_msj'],'in').'</div> ';
										  

					} while ($row_Ls_Rg = $Ls_Rg->fetch_assoc());
					
				   }
				   
	       	}
	       	
	       	$__cnx->_clsr($Ls_Rg);

		}

	   	return($_r);
	}
	
	function GtCntTmlEst($p=NULL){
		
		global $__cnx;
		
		if(!isN($p['i'])){
			
			$_r = $p['a'];
		    
			$Ls_Qry_Est = "	SELECT id_mdlcntest, mdl_nm, mdlstp_img, siscntest_tt, siscntest_clr_bck, us_nm, us_ap, mdlcntest_fi
							FROM ".TB_MDL_CNT_EST."
								 INNER JOIN "._BdStr(DBM).TB_SIS_CNT_EST." ON mdlcntest_est = id_siscntest
								 INNER JOIN "._BdStr(DBM).TB_US." ON mdlcntest_us = id_us
								 INNER JOIN ".TB_MDL_CNT." ON mdlcntest_mdlcnt = id_mdlcnt
								 INNER JOIN ".TB_MDL." ON mdlcnt_mdl = id_mdl
								 INNER JOIN "._BdStr(DBM).TB_MDL_S." ON mdl_mdls = id_mdls
								 INNER JOIN "._BdStr(DBM).TB_MDL_S_TP." ON mdls_tp = id_mdlstp
								 
							WHERE mdlcnt_cnt = ".GtSQLVlStr($p['i'], "int")."
							ORDER BY mdlcntest_fi DESC
							LIMIT 10";
	
			$Ls_Rg = $__cnx->_qry($Ls_Qry_Est); 
			
			if($Ls_Rg){
				
				$row_Ls_Rg = $Ls_Rg->fetch_assoc(); $Tot_Ls_Rg = $Ls_Rg->num_rows;
	
				if($Tot_Ls_Rg > 0){
	                do{
		                $_id = 'mdl-est-'.$row_Ls_Rg['id_mdlcntest'];
		                $_r[$_id]['t'] = 'mdl-est';
	                	$_r[$_id]['id'] = $row_Ls_Rg['id_mdlcntest'];
	                	$_r[$_id]['tt'] = TX_CMBSTD.' '.Strn( ctjTx($row_Ls_Rg['mdl_nm'],'in') ).
	                					  ' a '. Strn( ctjTx($row_Ls_Rg['siscntest_tt'],'in') ,'','','color:'.$row_Ls_Rg['siscntest_clr_bck']).' '; 
	                					  
	                  	$_r[$_id]['clr'] = $row_Ls_Rg['siscntest_clr_bck'];
	                  	
	                  	if(!isN($row_Ls_Rg['mdlstp_img'])){
	                		$_r[$_id]['icn'] = DMN_FLE_MDL_TP.ctjTx($row_Ls_Rg['mdlstp_img'],'in'); 
	                  	}
	                  	
	                  	
	                  	$_r[$_id]['us'] = ctjTx($row_Ls_Rg['us_nm'].' '.$row_Ls_Rg['us_ap'],'in'); 
	                  	$_r[$_id]['fi'] = $row_Ls_Rg['mdlcntest_fi']; 
	                  	
	                  	
	                  	  		
	                } while ($row_Ls_Rg = $Ls_Rg->fetch_assoc());
				}
			}
			
			$__cnx->_clsr($Ls_Rg);
		
		}

		return($_r);	    
		    
	}
	
	
	
	function GtCntTmlEstHis($p=NULL){
		
		global $__cnx;
		
		if(!isN($p['i'])){
			
			$_r = $p['a'];
		    
			$Ls_Qry_Est = "	SELECT * 
							FROM ".TB_MDL_CNT_HIS."
								 INNER JOIN "._BdStr(DBM).TB_SIS_SLC." ON mdlcnthis_tp = id_sisslc
								 INNER JOIN "._BdStr(DBM).TB_SIS_CNT_EST." ON mdlcntest_est = id_siscntest
								 INNER JOIN "._BdStr(DBM).TB_US." ON mdlcntest_us = id_us
								 INNER JOIN ".TB_MDL_CNT." ON mdlcntest_mdlcnt = id_mdlcnt
								 INNER JOIN ".TB_MDL." ON mdlcnt_mdl = id_mdl
							WHERE mdlcnt_cnt = ".GtSQLVlStr($p['i'], "int")."
							ORDER BY mdlcntest_fi DESC";
	
			$Ls_Rg = $__cnx->_qry($Ls_Qry_Est); 
			
			if($Ls_Rg){
				
				$row_Ls_Rg = $Ls_Rg->fetch_assoc(); $Tot_Ls_Rg = $Ls_Rg->num_rows;
	
				if($Tot_Ls_Rg > 0){
	                do{
		                $_id = 'his-'.$row_Ls_Rg['id_mdlcntest'];
		                $_r[$_id]['t'] = 'est-his';
	                	$_r[$_id]['id'] = $row_Ls_Rg['id_mdlcntest'];
	                	$_r[$_id]['tt'] = TX_RGTGST.' '.Strn( ctjTx($row_Ls_Rg['mdl_nm'],'in') ); 
	                  	$_r[$_id]['clr'] = $row_Ls_Rg['siscntest_clr_bck']; 
	                  	$_r[$_id]['us'] = ctjTx($row_Ls_Rg['us_nm'].' '.$row_Ls_Rg['us_ap'],'in'); 
	                  	$_r[$_id]['fi'] = $row_Ls_Rg['mdlcntest_fi'];   		
	                } while ($row_Ls_Rg = $Ls_Rg->fetch_assoc());
				}
			}
			
			$__cnx->_clsr($Ls_Rg);
		
		}

		return($_r);	    
		    
	}

	
	function GtCntTmlMdl($p=NULL){
		
		global $__cnx;
		
		if(!isN($p['i'])){
			
			$_r = $p['a'];
		    
			$Ls_Qry_Est = "	SELECT id_mdlcnt, mdl_nm, mdlstp_tp, mdlstp_img, mdlcnt_fi
							FROM ".TB_MDL_CNT."
								 INNER JOIN ".TB_MDL." ON mdlcnt_mdl = id_mdl
								 INNER JOIN "._BdStr(DBM).TB_MDL_S." ON mdl_mdls = id_mdls
								 INNER JOIN "._BdStr(DBM).TB_MDL_S_TP." ON mdls_tp = id_mdlstp
							WHERE mdlcnt_cnt = ".GtSQLVlStr($p['i'], "int")."
							ORDER BY mdlcnt_fi DESC
							LIMIT 10";
	
			$Ls_Rg = $__cnx->_qry($Ls_Qry_Est); 
			
			if($Ls_Rg){
				
				$row_Ls_Rg = $Ls_Rg->fetch_assoc(); $Tot_Ls_Rg = $Ls_Rg->num_rows;
	
				if($Tot_Ls_Rg > 0){
	                do{
		                
		                $_id = 'mdl-'.$row_Ls_Rg['id_mdlcnt'];
		                $_r[$_id]['t'] = 'mdl';
						$_r[$_id]['id'] = $row_Ls_Rg['id_mdlcnt'];
						
						if($row_Ls_Rg['mdlstp_tp']=='sac'){
							$_tt_prfx = TX_SRECRD;
						}else{
							$_tt_prfx = TX_SINTRSP;
						}

	                	$_r[$_id]['tt'] = $_tt_prfx.' '.Strn( ctjTx($row_Ls_Rg['mdl_nm'],'in') ).' '; 
	                	
	                	if(!isN($row_Ls_Rg['mdlstp_img'])){
	                		$_r[$_id]['icn'] = DMN_FLE_MDL_TP.ctjTx($row_Ls_Rg['mdlstp_img'],'in'); 
	                  	}
	                  	
	                  	$_r[$_id]['fi'] = $row_Ls_Rg['mdlcnt_fi'];
	                  			
	                } while ($row_Ls_Rg = $Ls_Rg->fetch_assoc());
				}
			}
			
			$__cnx->_clsr($Ls_Rg);
		
		}

		return($_r);	    
		    
	}
	
	
	function GtCntTmlMdlHis($p=NULL){
		
		global $__cnx;
		
		if(!isN($p['i'])){
			
			$_r = $p['a'];
		    
			$Ls_Qry_Est = "	SELECT id_mdlcnthis, mdlcnthis_dsc, sisslc_tt, /*us_img,*/ mdlcnthis_fi
							FROM ".TB_MDL_CNT_HIS."
								 INNER JOIN "._BdStr(DBM).TB_SIS_SLC." ON mdlcnthis_tp = id_sisslc
								 INNER JOIN ".TB_MDL_CNT." ON mdlcnthis_mdlcnt = id_mdlcnt
								 INNER JOIN ".TB_MDL." ON mdlcnt_mdl = id_mdl
								 INNER JOIN "._BdStr(DBM).TB_MDL_S." ON mdl_mdls = id_mdls
								 INNER JOIN "._BdStr(DBM).TB_MDL_S_TP." ON mdls_tp = id_mdlstp
								 INNER JOIN "._BdStr(DBM).TB_US." ON mdlcnthis_us = id_us
							WHERE mdlcnt_cnt = ".GtSQLVlStr($p['i'], "int")."
							ORDER BY mdlcnt_fi DESC
							LIMIT 10";
	
			$Ls_Rg = $__cnx->_qry($Ls_Qry_Est);
			
			if($Ls_Rg){
				
				$row_Ls_Rg = $Ls_Rg->fetch_assoc(); $Tot_Ls_Rg = $Ls_Rg->num_rows;
	
				if($Tot_Ls_Rg > 0){
	                do{
		                
		                $_id = 'mdl-his-'.$row_Ls_Rg['id_mdlcnthis'];
		                $_r[$_id]['t'] = 'mdl-his';
	                	$_r[$_id]['id'] = $row_Ls_Rg['id_mdlcnthis'];
	                	$_r[$_id]['tt'] = TX_GSTN.'('.ctjTx($row_Ls_Rg['sisslc_tt'],'in').') '.Strn( ctjTx($row_Ls_Rg['mdlcnthis_dsc'],'in') ).' '; 
	                	
	                	if(!isN($row_Ls_Rg['us_img'])){
		                	//$dt_img = _ImVrs([ 'img'=>$row_Ls_Rg['us_img'], 'f'=>DMN_FLE_US ]);
	                		//$_r[$_id]['icn'] = $dt_img; 
	                  	}
	                  	
	                  	$_r[$_id]['fi'] = $row_Ls_Rg['mdlcnthis_fi'];   
	                  			
	                } while ($row_Ls_Rg = $Ls_Rg->fetch_assoc());
				}
			}
			
			$__cnx->_clsr($Ls_Rg);
		
		}

		return($_r);	    
		    
	}
	
	
	function GtCntTmlCall($p=NULL){
		
		global $__cnx;
		
		if(!isN($p['i'])){
			
			$_r = $p['a'];
		    
			$Ls_Qry_Est = "	SELECT id_mdlcntcall, cnttel_tel, call_callduration, mdlcntcall_fi
							FROM ".TB_MDL_CNT_CALL."
								 INNER JOIN ".TB_MDL_CNT." ON mdlcntcall_mdlcnt = id_mdlcnt
								 INNER JOIN "._BdStr(DBT).TB_CALL." ON mdlcntcall_call = id_call
								 INNER JOIN ".TB_CNT_TEL." ON call_tel = id_cnttel
							WHERE mdlcnt_cnt = ".GtSQLVlStr($p['i'], "int")."
							ORDER BY mdlcnt_fi DESC
							LIMIT 10";
	
			$Ls_Rg = $__cnx->_qry($Ls_Qry_Est); 
			
			if($Ls_Rg){
				
				$row_Ls_Rg = $Ls_Rg->fetch_assoc(); $Tot_Ls_Rg = $Ls_Rg->num_rows;
	
				if($Tot_Ls_Rg > 0){

	                do{
		                
		                $_id = 'call-'.$row_Ls_Rg['id_mdlcntcall'];
		                $_r[$_id]['t'] = 'call';
	                	$_r[$_id]['id'] = $row_Ls_Rg['id_mdlcntcall'];
	                	$_r[$_id]['tt'] = TX_CLLNMB.' '.Strn( ctjTx($row_Ls_Rg['cnttel_tel'],'in') ).' ('.$row_Ls_Rg['call_callduration'].')'; 
	                  	$_r[$_id]['fi'] = $row_Ls_Rg['mdlcntcall_fi'];   
	                  			
					} while ($row_Ls_Rg = $Ls_Rg->fetch_assoc());
					
				}
			}
			
			$__cnx->_clsr($Ls_Rg);
		
		}

		return($_r);	    
		    
	}
	
	
	function GtCntTmlEc($p=NULL){
		
		global $__cnx;
		
		if(!isN($p['i'])){
			
			$_r = $p['a'];
			
			$Ls_Qry_Est = "	SELECT id_ecsnd, ec_tt, ecsnd_fi
							FROM ".TB_EC_SND."
								INNER JOIN ".TB_CNT." ON ecsnd_cnt = id_cnt
								INNER JOIN "._BdStr(DBM).TB_EC." ON ecsnd_ec = id_ec 
							WHERE ecsnd_cnt = ".GtSQLVlStr($p['i'], "int")."
							ORDER BY ecsnd_fi DESC
							LIMIT 10";
	
			$Ls_Rg = $__cnx->_qry($Ls_Qry_Est); 
			
			if($Ls_Rg){
				
				$row_Ls_Rg = $Ls_Rg->fetch_assoc(); $Tot_Ls_Rg = $Ls_Rg->num_rows;
	
				if($Tot_Ls_Rg > 0){
					
	                do{
		                
	                  	$_id = 'ec-'.$row_Ls_Rg['id_ecsnd'];
		                $_r[$_id]['t'] = 'ec';
	                	$_r[$_id]['id'] = $row_Ls_Rg['id_ecsnd'];
	                	$_r[$_id]['tt'] = TX_SNDPZML.' '.Strn( ctjTx($row_Ls_Rg['ec_tt'],'in') ).' '; 
	                  	$_r[$_id]['fi'] = $row_Ls_Rg['ecsnd_fi'];  
	                  			
	                } while ($row_Ls_Rg = $Ls_Rg->fetch_assoc());
	                
				}
			}
			
			$__cnx->_clsr($Ls_Rg);
		
		}

		return($_r);	    
		    
	}
	
	
	
	function GtCntTmlTra($p=NULL){
		
		global $__cnx;
		
		if(!isN($p['i'])){
			
			$_r = $p['a'];
		    
			$Ls_Qry_Est = "	SELECT id_mdlcnttra, tra_tt, mdlcnttra_fi
							FROM ".TB_MDL_CNT_TRA."
								 INNER JOIN ".TB_MDL_CNT." ON mdlcnttra_mdlcnt = id_mdlcnt
								 INNER JOIN "._BdStr(DBM).TB_TRA." ON mdlcnttra_tra = id_tra
							WHERE mdlcnt_cnt = ".GtSQLVlStr($p['i'], "int")."
							ORDER BY mdlcnt_fi DESC
							LIMIT 10";
	
			$Ls_Rg = $__cnx->_qry($Ls_Qry_Est); 
			
			if($Ls_Rg){
				
				$row_Ls_Rg = $Ls_Rg->fetch_assoc(); $Tot_Ls_Rg = $Ls_Rg->num_rows;
	
				if($Tot_Ls_Rg > 0){
	                do{
		                
		                $_id = 'tra-'.$row_Ls_Rg['id_mdlcnttra'];
		                $_r[$_id]['t'] = 'tra';
	                	$_r[$_id]['id'] = $row_Ls_Rg['id_mdlcnttra'];
	                	$_r[$_id]['tt'] = TX_RLCTSK.' '.Strn( ctjTx($row_Ls_Rg['tra_tt'],'in') ).' '; 
	                  	$_r[$_id]['fi'] = $row_Ls_Rg['mdlcnttra_fi'];   
	                  			
	                } while ($row_Ls_Rg = $Ls_Rg->fetch_assoc());
				}
			}
			
			$__cnx->_clsr($Ls_Rg);
		}

		return($_r);	    
		    
	}
	
	
	function GtCntTmlVst($p=NULL){
		
		global $__cnx;
		
		if(!isN($p['i'])){
			
			$_r = $p['a'];
		    
			$Ls_Qry_Est = "	SELECT id_mdlcntvst, mdlcntvst_f, mdlcntvst_fi
							FROM ".TB_MDL_CNT_VST."
								 INNER JOIN ".TB_MDL_CNT." ON mdlcntvst_mdlcnt = id_mdlcnt
							WHERE mdlcnt_cnt = ".GtSQLVlStr($p['i'], "int")."
							ORDER BY mdlcnt_fi DESC
							LIMIT 10";
	
			$Ls_Rg = $__cnx->_qry($Ls_Qry_Est); 
			
			if($Ls_Rg){
				
				$row_Ls_Rg = $Ls_Rg->fetch_assoc(); $Tot_Ls_Rg = $Ls_Rg->num_rows;
	
				if($Tot_Ls_Rg > 0){
	                do{	                
		                $_id = 'vst-'.$row_Ls_Rg['id_mdlcntvst'];
		                $_r[$_id]['t'] = 'mdl-vst';
	                	$_r[$_id]['id'] = $row_Ls_Rg['id_mdlcntvst'];
	                	$_r[$_id]['tt'] = TX_ASGNCDT.' '.Strn( ctjTx($row_Ls_Rg['mdlcntvst_f'],'in') ).' '; 
	                  	$_r[$_id]['fi'] = $row_Ls_Rg['mdlcntvst_fi']; 			
	                } while ($row_Ls_Rg = $Ls_Rg->fetch_assoc());
				}
			}
			
			$__cnx->_clsr($Ls_Rg);
		
		}

		return($_r);	    
		    
	}
	
	
	function GtCntTmlCkTrck($p=NULL){
		
		global $__cnx;
		
		if(!isN($p['i'])){
			
			$_r = $p['a'];
		    
			$Ls_Qry_Est = "	SELECT id_cntcktrck, cntcktrck_tt, cntcktrck_url, cntcktrck_f
							FROM ".TB_CNT_CK_TRCK."
								 INNER JOIN ".TB_CNT_CK." ON cntck_ck = cntcktrck_ck
								 INNER JOIN ".TB_CNT." ON cntck_cnt = id_cnt
							WHERE cntck_cnt = ".GtSQLVlStr($p['i'], "int")."
							ORDER BY cntck_f DESC
							LIMIT 10";
	
			$Ls_Rg = $__cnx->_qry($Ls_Qry_Est); 
			//$_r['ck'] = $__cnx->c_r->error;
			
			if($Ls_Rg){
				
				$row_Ls_Rg = $Ls_Rg->fetch_assoc(); $Tot_Ls_Rg = $Ls_Rg->num_rows;
	
				if($Tot_Ls_Rg > 0){
	                
	                do{
		                
		                $_id = 'ck-'.$row_Ls_Rg['id_cntcktrck'];
		                $_r[$_id]['t'] = 'ck';
	                	$_r[$_id]['id'] = $row_Ls_Rg['id_cntcktrck'];
	                	$_r[$_id]['tt'] = TX_VSTPG.' '.Strn( ctjTx($row_Ls_Rg['cntcktrck_tt'],'in') ).' '; 
	                	$_r[$_id]['url'] = $row_Ls_Rg['cntcktrck_url']; 
	                  	$_r[$_id]['fi'] = $row_Ls_Rg['cntcktrck_f'];   
	                  			
	                } while ($row_Ls_Rg = $Ls_Rg->fetch_assoc());
				}
			}
			
			$__cnx->_clsr($Ls_Rg);
		
		}

		return($_r);	    
		    
	}
	
	
	
	
	function GtCntTmlEml($p=NULL){
		
		global $__cnx;
		
		if(!isN($p['i'])){
			
			$_r = $p['a'];
		    
			$Ls_Qry_Est = "	SELECT id_cnteml, cnteml_eml, cnteml_fi, cntplcy_sndi
							FROM ".TB_CNT_EML."
								 LEFT JOIN ".TB_CNT_PLCY." ON (cntplcy_cnt = cnteml_cnt AND cntplcy_sndi=1)
								 LEFT JOIN "._BdStr(DBM).TB_CL_PLCY." ON (cntplcy_plcy = id_clplcy AND clplcy_e=1)
							WHERE cnteml_cnt = ".GtSQLVlStr($p['i'], "int")."
							ORDER BY cnteml_fi DESC
							LIMIT 100";
	
			$Ls_Rg = $__cnx->_qry($Ls_Qry_Est); 
			
			if($Ls_Rg){
				
				$row_Ls_Rg = $Ls_Rg->fetch_assoc(); $Tot_Ls_Rg = $Ls_Rg->num_rows;
	
				if($Tot_Ls_Rg > 0){

	                do{
						
						$__eml_nrml = 	_plcy_scre([ 
							't'=>'eml',
							'v'=>ctjTx($row_Ls_Rg['cnteml_eml'],'in'),
							'plcy'=>[ 'e'=>$row_Ls_Rg['cntplcy_sndi'] ]  
						]);

		                $_id = 'add-eml-'.$row_Ls_Rg['id_cnteml'];
		                $_r[$_id]['t'] = 'add-eml';
	                	$_r[$_id]['id'] = $row_Ls_Rg['id_cnteml'];
	                	$_r[$_id]['tt'] = TX_MLADD.' '.Strn( $__eml_nrml ).' '.TX_CNTCT; 
	                  	$_r[$_id]['fi'] = $row_Ls_Rg['cnteml_fi'];   
	                  			
					} while ($row_Ls_Rg = $Ls_Rg->fetch_assoc());
					
				}
			}

			$__cnx->_clsr($Ls_Rg);
		
		}

		return($_r);	    
		    
	}
	
	
	function GtCntTmlDc($p=NULL){
		
		global $__cnx;
		
		if(!isN($p['i'])){
			
			$_r = $p['a'];
		    
			$Ls_Qry_Est = "	SELECT id_cntdc, cntdc_dc, cntdc_fi, cntplcy_sndi
							FROM ".TB_CNT_DC."
								 LEFT JOIN ".TB_CNT_PLCY." ON (cntplcy_cnt = cntdc_cnt AND cntplcy_sndi=1)
								 LEFT JOIN "._BdStr(DBM).TB_CL_PLCY." ON (cntplcy_plcy = id_clplcy AND clplcy_e=1)
							WHERE cntdc_cnt = ".GtSQLVlStr($p['i'], "int")."
							ORDER BY cntdc_fi DESC
							LIMIT 10";
	
			$Ls_Rg = $__cnx->_qry($Ls_Qry_Est); 
			
			if($Ls_Rg){
				
				$row_Ls_Rg = $Ls_Rg->fetch_assoc(); $Tot_Ls_Rg = $Ls_Rg->num_rows;
	
				if($Tot_Ls_Rg > 0){
					
					do{
						
						$__no_nrml = 	_plcy_scre([ 
							'v'=>ctjTx($row_Ls_Rg['cntdc_dc'],'in'),
							'plcy'=>[ 'e'=>$row_Ls_Rg['cntplcy_sndi'] ]  
						]);

		                $_id = 'add-dc-'.$row_Ls_Rg['id_cntdc'];
		                $_r[$_id]['t'] = 'add-dc';
	                	$_r[$_id]['id'] = $row_Ls_Rg['id_cntdc'];
	                	$_r[$_id]['tt'] = TX_AGRGDC.' '.Strn( $__no_nrml ).' '.TX_CNTCT; 
	                  	$_r[$_id]['fi'] = $row_Ls_Rg['cntdc_fi'];
	                  			
					} while ($row_Ls_Rg = $Ls_Rg->fetch_assoc());
					
				}
			}
			
			$__cnx->_clsr($Ls_Rg);
		
		}

		return($_r);	    
		    
	}
	
	
	function GtCntTmlTel($p=NULL){
		
		global $__cnx;
		
		if(!isN($p['i'])){
			
			$_r = $p['a'];

			$Ls_Qry_Est = "	SELECT id_cnttel, cnttel_tel, cnttel_fi, cntplcy_sndi
							FROM ".TB_CNT_TEL."
								 LEFT JOIN ".TB_CNT_PLCY." ON (cntplcy_cnt = cnttel_cnt AND cntplcy_sndi=1)
								 LEFT JOIN "._BdStr(DBM).TB_CL_PLCY." ON (cntplcy_plcy = id_clplcy AND clplcy_e=1)
							WHERE cnttel_cnt = ".GtSQLVlStr($p['i'], "int")."
							ORDER BY cnttel_fi DESC
							LIMIT 10";
	
			$Ls_Rg = $__cnx->_qry($Ls_Qry_Est); 
			
			if($Ls_Rg){
				
				$row_Ls_Rg = $Ls_Rg->fetch_assoc(); $Tot_Ls_Rg = $Ls_Rg->num_rows;
	
				if($Tot_Ls_Rg > 0){

	                do{
						
						$__no_nrml = 	_plcy_scre([ 
							'v'=>ctjTx($row_Ls_Rg['cnttel_tel'],'in'),
							'plcy'=>[ 'e'=>$row_Ls_Rg['cntplcy_sndi'] ]  
						]);

		                $_id = 'add-tel-'.$row_Ls_Rg['id_cnttel'];
		                $_r[$_id]['t'] = 'add-tel';
	                	$_r[$_id]['id'] = $row_Ls_Rg['id_cnttel'];
	                	$_r[$_id]['tt'] = TX_PHNADD.' '.Strn( $__no_nrml ).' '.TX_CNTCT; 
	                  	$_r[$_id]['fi'] = $row_Ls_Rg['cnttel_fi'];   
	                  			
					} while ($row_Ls_Rg = $Ls_Rg->fetch_assoc());
					
				}
			}
			
			$__cnx->_clsr($Ls_Rg);
		
		}

		return($_r);	    
		    
	}
	
	
	
	function GtCntTmlWbhk($p=NULL){
		
		global $__cnx;
		
		if(!isN($p['i'])){
			
			$_r = $p['a'];

		    
			$Ls_Qry_Est = "	SELECT id_wbhksnd, wbhksnd_r_code, wbhksnd_fi
							FROM ".DBP.".".TB_WBHK_SND."
								 INNER JOIN ".DBP.".".TB_WBHK." ON wbhksnd_wbhk
								 INNER JOIN "._BdStr(DBM).TB_CL." ON wbhk_cl = id_cl
							WHERE cl_enc = '".DB_CL_ENC."' AND wbhksnd_id = ".GtSQLVlStr($p['i'], "text")."
							ORDER BY wbhksnd_fi DESC
							LIMIT 10";
	
			$Ls_Rg = $__cnx->_qry($Ls_Qry_Est); 
			
			if($Ls_Rg){
				
				$row_Ls_Rg = $Ls_Rg->fetch_assoc(); $Tot_Ls_Rg = $Ls_Rg->num_rows;
	
				if($Tot_Ls_Rg > 0){
	                do{
		                
		                $_id = 'add-wbhk-'.$row_Ls_Rg['id_wbhksnd'];
		                $_r[$_id]['t'] = 'add-wbhk';
	                	$_r[$_id]['id'] = $row_Ls_Rg['id_wbhksnd'];
	                	$_r[$_id]['tt'] = TX_PHNADD.' '.Strn( ctjTx($row_Ls_Rg['wbhksnd_r_code'],'in') ); 
	                  	$_r[$_id]['fi'] = $row_Ls_Rg['wbhksnd_fi'];   
	                  			
	                } while ($row_Ls_Rg = $Ls_Rg->fetch_assoc());
				}
			}
			
			$__cnx->_clsr($Ls_Rg);
		
		}


		return($_r);	    
		    
	} 

	function GtCntTmlMd($p=NULL){
		
		global $__cnx;
		
		if(!isN($p['i'])){
			
			$_r = $p['a'];

		    
			$Ls_Qry_Est = "	SELECT id_mdlcntm, id_mdlcnt, sismd_tt, mdlcntm_fi
							FROM ".TB_MDL_CNT_M_BD."
								 INNER JOIN ".TB_MDL_CNT." ON id_mdlcnt = mdlcntm_mdlcnt
								 INNER JOIN "._BdStr(DBM).TB_SIS_MD." ON id_sismd = mdlcntm_m
							WHERE id_mdlcnt = ".GtSQLVlStr($p['i'], "text")."
							ORDER BY mdlcntm_fi DESC
							LIMIT 10";
	
			$Ls_Rg = $__cnx->_qry($Ls_Qry_Est); 
			
			if($Ls_Rg){
				
				$row_Ls_Rg = $Ls_Rg->fetch_assoc(); $Tot_Ls_Rg = $Ls_Rg->num_rows;
	
				if($Tot_Ls_Rg > 0){
	                do{
		                
		                $_id = 'mdl-md-'.$row_Ls_Rg['id_mdlcntm'];
		                $_r[$_id]['t'] = 'mdl-md';
	                	$_r[$_id]['id'] = $row_Ls_Rg['id_mdlcnt'];
	                	$_r[$_id]['tt'] = 'Impactado por el medio '.Strn( ctjTx($row_Ls_Rg['sismd_tt'],'in') ); 
	                  	$_r[$_id]['fi'] = $row_Ls_Rg['mdlcntm_fi'];   
	                  			
	                } while ($row_Ls_Rg = $Ls_Rg->fetch_assoc());
				}
			}
			
			$__cnx->_clsr($Ls_Rg);
		
		}


		return($_r);	    
		    
	} 

	function GtCntTmlMdP($p=NULL){
		
		global $__cnx;
		
		if(!isN($p['i'])){
			
			$_r = $p['a'];
		    
			$Ls_Qry_Est = "	SELECT id_mdlcnt, sismd_tt, mdlcnt_fi
							FROM ".TB_MDL_CNT."
								 INNER JOIN "._BdStr(DBM).TB_SIS_MD." ON id_sismd = mdlcnt_m
							WHERE id_mdlcnt = ".GtSQLVlStr($p['i'], "text")."
							ORDER BY mdlcnt_fi DESC
							LIMIT 10";
	
			$Ls_Rg = $__cnx->_qry($Ls_Qry_Est); 
			
			if($Ls_Rg){
				
				$row_Ls_Rg = $Ls_Rg->fetch_assoc(); $Tot_Ls_Rg = $Ls_Rg->num_rows;
	
				if($Tot_Ls_Rg > 0){
	                do{
		                
		                $_id = 'mdl-md-'.$row_Ls_Rg['id_mdlcnt'];
		                $_r[$_id]['t'] = 'mdl-md';
	                	$_r[$_id]['id'] = $row_Ls_Rg['id_mdlcnt'];
	                	$_r[$_id]['tt'] = 'Ingresa por el medio '.Strn( ctjTx($row_Ls_Rg['sismd_tt'],'in') ); 
	                  	$_r[$_id]['fi'] = $row_Ls_Rg['mdlcnt_fi'];   
	                  			
	                } while ($row_Ls_Rg = $Ls_Rg->fetch_assoc());
				}
			}
			
			$__cnx->_clsr($Ls_Rg);
		
		}
		
		return($_r);	    
		    
	}

	function GtCntTmlTraEst($p=NULL){
		
		global $__cnx;
		
		if(!isN($p['i'])){
			
			$_r = $p['a'];
		    
			$Ls_Qry_Est = "	SELECT id_mdlcnttra, tra_tt, mdlcntest_fi, siscntest_tt, id_mdlcnt, id_mdlcntest
							FROM ".TB_MDL_CNT_TRA."
								 INNER JOIN ".TB_MDL_CNT." ON mdlcnttra_mdlcnt = id_mdlcnt
								 INNER JOIN ".TB_MDL_CNT_EST." ON mdlcntest_mdlcnt = id_mdlcnt
								 INNER JOIN "._BdStr(DBM).TB_TRA." ON mdlcnttra_tra = id_tra
								 INNER JOIN "._BdStr(DBM).TB_SIS_CNT_EST." ON mdlcntest_est = id_siscntest
							WHERE mdlcnt_cnt = ".GtSQLVlStr($p['i'], "int")."
							ORDER BY mdlcntest_fi DESC";
	
			$Ls_Rg = $__cnx->_qry($Ls_Qry_Est); 
			
			if($Ls_Rg){
				
				$row_Ls_Rg = $Ls_Rg->fetch_assoc(); $Tot_Ls_Rg = $Ls_Rg->num_rows;
	
				if($Tot_Ls_Rg > 0){
	                do{
		                
		                $_id = 'tra-est-'.$row_Ls_Rg['id_mdlcntest'];
		                $_r[$_id]['t'] = 'tra-est';
	                	$_r[$_id]['id'] = $row_Ls_Rg['id_mdlcntest'];
	                	$_r[$_id]['tt'] = 'Se cambio al estado '.$row_Ls_Rg['siscntest_tt'].' el ticket #'.$row_Ls_Rg['id_mdlcnt'].' '.Strn( ctjTx($row_Ls_Rg['tra_tt'],'in') ).' '; 
	                  	$_r[$_id]['fi'] = $row_Ls_Rg['mdlcntest_fi'];   
	                  			
	                } while ($row_Ls_Rg = $Ls_Rg->fetch_assoc());
				}
			}
			
			$__cnx->_clsr($Ls_Rg);
		}

		return($_r);	    
		    
	}

	function GtCntTmlTraCmnt($p=NULL){
		
		global $__cnx;
		
		if(!isN($p['i'])){
			
			$_r = $p['a'];

			$Ls_Qry_Est = "	SELECT id_mdlcnttra, tra_tt, tracmnt_fi, tracmnt_tt, id_mdlcnt, id_tracmnt
							FROM ".TB_MDL_CNT_TRA."
								 INNER JOIN ".TB_MDL_CNT." ON mdlcnttra_mdlcnt = id_mdlcnt
								 INNER JOIN "._BdStr(DBM).TB_TRA." ON mdlcnttra_tra = id_tra
								 INNER JOIN "._BdStr(DBM).TB_TRA_CMNT." ON tracmnt_tra = id_tra
							WHERE mdlcnt_cnt = ".GtSQLVlStr($p['i'], "int")."
							ORDER BY tracmnt_fi DESC";
	
			$Ls_Rg = $__cnx->_qry($Ls_Qry_Est); 
			
			if($Ls_Rg){
				
				$row_Ls_Rg = $Ls_Rg->fetch_assoc(); $Tot_Ls_Rg = $Ls_Rg->num_rows;
	
				if($Tot_Ls_Rg > 0){
	                do{
		                
		                $_id = 'tra-cmnt-'.$row_Ls_Rg['id_tracmnt'];
		                $_r[$_id]['t'] = 'tra-cmnt';
	                	$_r[$_id]['id'] = $row_Ls_Rg['id_tracmnt'];
						$_r[$_id]['tt'] = 'Escribió un comentario en el ticket #'.$row_Ls_Rg['id_mdlcnt'].' '.Strn( ctjTx($row_Ls_Rg['tra_tt'],'in') ).' '.
											' : <div class="cmnt">'.ctjTx($row_Ls_Rg['tracmnt_tt'],'in').'</div> ';
	                  	$_r[$_id]['fi'] = $row_Ls_Rg['tracmnt_fi'];   
	                  			
	                } while ($row_Ls_Rg = $Ls_Rg->fetch_assoc());
				}
			}
			
			$__cnx->_clsr($Ls_Rg);
		}

		return($_r);	    
		    
	}

	function GtCntTmlTraCtrl($p=NULL){
		
		global $__cnx;
		
		if(!isN($p['i'])){
			
			$_r = $p['a'];

			$Ls_Qry_Est = "	SELECT id_mdlcnttra, tra_tt,tractrl_fi,tractrl_tt, id_mdlcnt, id_tractrl
							FROM ".TB_MDL_CNT_TRA."
								 INNER JOIN ".TB_MDL_CNT." ON mdlcnttra_mdlcnt = id_mdlcnt
								 INNER JOIN "._BdStr(DBM).TB_TRA." ON mdlcnttra_tra = id_tra
								 INNER JOIN "._BdStr(DBM).TB_TRA_CTRL." ON tractrl_tra = id_tra
							WHERE mdlcnt_cnt = ".GtSQLVlStr($p['i'], "int")."
							ORDER BY tractrl_fi DESC";
	
			$Ls_Rg = $__cnx->_qry($Ls_Qry_Est); 
			
			if($Ls_Rg){
				
				$row_Ls_Rg = $Ls_Rg->fetch_assoc(); $Tot_Ls_Rg = $Ls_Rg->num_rows;
	
				if($Tot_Ls_Rg > 0){
	                do{
		                
		                $_id = 'tra-ctrl-'.$row_Ls_Rg['id_tractrl'];
		                $_r[$_id]['t'] = 'tra-ctrl';
	                	$_r[$_id]['id'] = $row_Ls_Rg['id_tractrl'];
						$_r[$_id]['tt'] = 'Agrego una lista de control en el ticket #'.$row_Ls_Rg['id_mdlcnt'].' '.Strn( ctjTx($row_Ls_Rg['tra_tt'],'in') ).' '.
											' : <div class="cmnt">'.ctjTx($row_Ls_Rg['tractrl_tt'],'in').'</div> ';
	                  	$_r[$_id]['fi'] = $row_Ls_Rg['tractrl_fi'];   
	                  			
	                } while ($row_Ls_Rg = $Ls_Rg->fetch_assoc());
				}
			}
			
			$__cnx->_clsr($Ls_Rg);
		}

		return($_r);	    
		    
	}	

	function GtCntTmlTraHisCol($p=NULL){
		
		global $__cnx;
		
		if(!isN($p['i'])){
			
			$_r = $p['a'];

			$Ls_Qry_Est = "	SELECT id_mdlcnttra, tra_tt, trahiscol_fi, id_mdlcnt, id_trahiscol, tracol_tt
							FROM ".TB_MDL_CNT_TRA."
								 INNER JOIN ".TB_MDL_CNT." ON mdlcnttra_mdlcnt = id_mdlcnt
								 INNER JOIN "._BdStr(DBM).TB_TRA." ON mdlcnttra_tra = id_tra
								 INNER JOIN "._BdStr(DBM).TB_TRA_HIS_COL." ON trahiscol_tra = id_tra 
								 INNER JOIN "._BdStr(DBM).TB_TRA_COL." ON trahiscol_tracol = id_tracol
							WHERE mdlcnt_cnt = ".GtSQLVlStr($p['i'], "int")."
							ORDER BY trahiscol_fi DESC";
	
			$Ls_Rg = $__cnx->_qry($Ls_Qry_Est); 
			
			if($Ls_Rg){
				
				$row_Ls_Rg = $Ls_Rg->fetch_assoc(); $Tot_Ls_Rg = $Ls_Rg->num_rows;
	
				if($Tot_Ls_Rg > 0){
	                do{
		                
		                $_id = 'tra-his-'.$row_Ls_Rg['id_trahiscol'];
		                $_r[$_id]['t'] = 'tra-his';
	                	$_r[$_id]['id'] = $row_Ls_Rg['id_trahiscol'];
						$_r[$_id]['tt'] = 'Se cambio el ticket #'.$row_Ls_Rg['id_mdlcnt'].' a la columna '.Strn( ctjTx($row_Ls_Rg['tracol_tt'],'in') ).' ';
	                  	$_r[$_id]['fi'] = $row_Ls_Rg['trahiscol_fi'];   
	                  			
	                } while ($row_Ls_Rg = $Ls_Rg->fetch_assoc());
				}
			}
			
			$__cnx->_clsr($Ls_Rg);
		}

		return($_r);	    
		    
	}

?>