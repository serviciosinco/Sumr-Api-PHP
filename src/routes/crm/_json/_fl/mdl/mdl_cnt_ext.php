<?php 
	
	$rsp['e'] = 'no';
	
	
	//@ini_set('display_errors', true); 
	//error_reporting(E_ALL & ~E_NOTICE);
	
	/*
	
		HAVE TO BUILD 
		
		{
			cnt_img: null
			gst_dif: "</br>"
			id: "108142"
			ls_icn: null
			mdlcnt_est: "Nunca Contactado"
			tot_ck: ""
			tot_cmpr: "0"
			tot_his: ""
			tot_his_call: null
			tot_intn: null
			tot_ints: "1"
		}

	
		
	*/	
	
	
	$__mcnt = Php_Ls_Cln($_POST['mdlcnt']);
	$__tp = Php_Ls_Cln($_POST['tp']);

	
	/*	
		
		
	if($__mcnt != ''){
		
		$Ls_Qry = "CALL ".DBM.".Ls_MdlCnt_Ext('{$__mcnt}', '".DB_CL."')"; 
		
		$Ls = $__cnx->_qry($Ls_Qry);
		
		if($Ls){
			
			$row_Ls = $Ls->fetch_assoc(); 
			$Tot_Ls = $Ls->num_rows;
			
			if( ($Tot_Ls>0) ){	
				
				$rsp['e'] = 'ok';
				$rsp['total'] = $Tot_Ls;
				
				if($Tot_Ls > 0){
					
					
					//Consultas secundarias
					$Ls_CntEst_Qry = " SELECT * FROM "._BdStr(DBM).TB_SIS_CNT_EST." "; //Estados
					$Ls_CntEst = $__cnx->_qry($Ls_CntEst_Qry); //Estados
					
					while( $row_Ls_CntEst = $Ls_CntEst->fetch_assoc() ){
						$_ls['ls']['est'][$row_Ls_CntEst["id_siscntest"]]['tt'] = $row_Ls_CntEst["siscntest_tt"];
					}
					
					
					do {
						
						$___mre_icn = '';
						
						
						//------- Calculo de Fechas -------//
						if(!isN($row_Ls['__cnt_gst_lst']) && defined('SIS_F_D')){ 
			          	
				          	$___date = date_create($row_Ls['__cnt_gst_lst']);  	
				          	$___fecha= date_format($___date, 'Y-m-d');
				          	$_gst_fcmp = Spn($___fecha);
			          		$_gst_dif = _Df_Dte_Wk($row_Ls['__cnt_gst_lst'], SIS_F_D, ['_fr'=>'b', 'e'=>$row_Ls['mdlcnt_est']] );
	
			          	}else{ 
				          	
				          	$_f_lgst_f = ''; 
				          	$_f_lgst_h = '';
				          	$_gst_fcmp = '';
				          	$_gst_dif = '';
				          	
				      	} 
					  	
					  	
					  	//------- Url de Gestion -------//
					  	if($row_Ls['___histot'] > 0){ 
							  	if($row_Ls['___histot_call'] > 0 && ChckSESS_superadm()){ $__call_clss = '_call';  }else{ $__call_clss = ''; }
							  	$_gst_lnk = '<a href="'.FL_DT_GN.__t('mdl_cnt_his',true).ADM_LNK_SB.$row_Ls['mdlcnt_enc'].TXGN_POP.LNK_RND.Gn_Rnd(20).'" class="_dtl _nmb '.$__call_clss.'">'.$row_Ls['___histot'].'</a>';
			            	}else{
				            	$_gst_lnk = '';
			            	}
			            	
			            							
						
					
		            	
						//------- Url de Gestion -------//
					  	if($row_Ls['___tot_ck'] > 0){ 
							$_ck_lnk = '<a href="'.FL_DT_GN.__t('cnt_ck',true).ADM_LNK_DT.$row_Ls['mdlcnt_cnt'].TXGN_POP.LNK_RND.Gn_Rnd(20).'" class="_dtl _nmb _p">'.$row_Ls['___tot_ck'].'</a>';
			            	}else{
				            	$_ck_lnk = '';
			            	} 
						
						
						$Ls_Chk = __LsDt(['k'=>'sis_chk', 'cl'=>DB_CL_ID ]);
										
						foreach($Ls_Chk->ls->sis_chk as $chk_k => $chk_v){	
							$__ls_val = GtLsChckDt([ 'id'=>$row_Ls['mdlcnt_enc'],'id_chk'=>$chk_v->id ]);	
							if($__ls_val->est == 1){ 
								$___mre_icn .= li(Spn('', '', 'icn_chck_'.$__ls_val->est, 'background-image: url('.$chk_v->img.');','', $chk_v->tt )); 
							}
						}
						
													
						$rsp['l'][] = [	
										'id'=>$row_Ls['id_mdlcnt'],
										'gst_dif'=>$_gst_fcmp.HTML_BR.$_gst_dif->_r,
										'tot_his'=>$_gst_lnk,
										'tot_his_call'=>$row_Ls['___histot_call'],
										'tot_ints'=>$row_Ls['___tot_ints'],
										'tot_cmpr'=>$row_Ls['___tot_cmpr'],
										'tot_intn'=>$row_Ls['___tot_intn'],
										'tot_ck'=>$_ck_lnk,
										'cnt_img'=>$row_Ls['___img'],
										'ls_icn'=>__Ls_Chk_Icn(['d'=>$row_Ls, 'tp'=>$__tp, 'mre'=>$___mre_icn ]),
										'mdlcnt_est'=>$_ls['ls']['est'][$row_Ls["mdlcnt_est"]]['tt']
									];	
										
						
					} while ($row_Ls = $Ls->fetch_assoc());
				}
				
			}
		
		}
	}
	
	*/
	
	
	
	
	
	
	if(!isN($__mcnt)){
		
		$__mcnt_a = explode(',', $__mcnt);
		$__mcnt_a = implode("','", $__mcnt_a);
		
		
		//-------------------- Consulta Principal Leads --------------------//
		
		
			$Ls_CntEst_Qry = " 	SELECT * 
								FROM "._BdStr(DBM).TB_SIS_CNT_EST." 
									 INNER JOIN "._BdStr(DBM).TB_CL." ON siscntest_cl = id_cl
								WHERE cl_enc = '".DB_CL_ENC."'
							";
							
			$Ls_CntEst = $__cnx->_qry($Ls_CntEst_Qry);
			
			if($Ls_CntEst){
				while( $row_Ls_CntEst = $Ls_CntEst->fetch_assoc() ){
					$__k_sest[$row_Ls_CntEst["id_siscntest"]]['tt'] = $row_Ls_CntEst["siscntest_tt"];
				}
			}
			
		//-------------------- Consulta Principal Leads --------------------//
		
			$Ls_Qry = "SELECT
							id_mdlcnt,
							mdlcnt_enc,
							mdlcnt_cnt,
							mdlcnt_est,
							mdlcnt_gen,
							mdlcnt_chk_rga, 
							mdlcnt_chk_dcc, 
							mdlcnt_chk_nop, 
							mdlcnt_chk_rpt, 
							mdlcnt_chk_mlt,
							mdlcnt_chk_vll,
							mdlcnt_chk_pin,
							mdlcnt_chk_rvp,
							mdlcnt_chk_ner,
							mdlcnt_chk_spp,
							mdlcnt_cnt AS __tcnt,
							mdlcnt_fi,
							id_sisslc,
							sisslc_tt,
							sisslc_img,
							mdlcntchck_est
						FROM ".DB_CL.".".TB_MDL_CNT."
						LEFT JOIN ".DB_CL.".".TB_MDL_CNT_CHCK." ON mdlcntchck_mdlcnt = id_mdlcnt
						LEFT JOIN "._BdStr(DBM).TB_SIS_SLC." ON mdlcntchck_sisslc = id_sisslc
						WHERE mdlcnt_enc IN ('{$__mcnt_a}')"; 
						
			$Ls = $__cnx->_qry($Ls_Qry);
			
			if($Ls){
				
				$row_Ls = $Ls->fetch_assoc(); 
				$Tot_Ls = $Ls->num_rows;
				
				if($Tot_Ls>0){		
					$rsp['e'] = 'ok';
					$rsp['total'] = $Tot_Ls;	
					
					do {
						
						
						$ido = $row_Ls['id_mdlcnt'];
						$rsp['l'][$ido]['id'] = $row_Ls['id_mdlcnt'];
						$rsp['l'][$ido]['est']['tt'] = ctjTx($__k_sest[$row_Ls["mdlcnt_est"]]['tt'],'in');
						$rsp['l'][$ido]['est']['id'] = $row_Ls["mdlcnt_est"];
						$rsp['l'][$ido]['fi'] = $row_Ls['mdlcnt_fi'];

						if($row_Ls['mdlcntchck_est'] == 1 && !isN($row_Ls['id_sisslc'])){
							$_icn = li(Spn('', '', 'icn_chck_1', 'background-image: url('.DMN_FLE_SIS_SLC.$row_Ls['sisslc_img'].');','', $row_Ls['sisslc_tt'].' - '. $row_Ls['id_mdlcnt']));
							$rsp['l'][$ido]['ls_icns'][$row_Ls['id_sisslc']] = $_icn;
						}

						

						$__k_icn[$ido] = $row_Ls;
						$__k_cnt[] = $row_Ls['mdlcnt_cnt'];
						$__k_mdlcnt[] = $row_Ls['id_mdlcnt']; 
						
					} while ($row_Ls = $Ls->fetch_assoc());
					
					
					$__k_icns = $rsp['l'];
					$__k_cnt_a = implode("','", $__k_cnt);
					$__k_mdlcnt_a = implode("','", $__k_mdlcnt);

					

					foreach($__k_icns as $__k_icns_k => $__k_icns_v){
						foreach($__k_icns_v['ls_icns'] as $__k_icnd_k => $__k_icnd_v){
							$Vl[$__k_icns_k] .= $__k_icnd_v;
						}
						$rsp['l'][$__k_icns_k]['ls_icns'] = __Ls_Chk_Icn([ 'mre'=>$Vl[$__k_icns_k] ]);	
					}
					
			
				}
			
			}
			
		
		
		//-------------------- Gestiones Total --------------------//
		
			$LsHisTot_Qry = "	SELECT mdlcnthis_mdlcnt, mdlcnt_enc, COUNT(*) AS __tot
								FROM ".DB_CL.".".TB_MDL_CNT_HIS."
								INNER JOIN ".DB_CL.".".TB_MDL_CNT." ON mdlcnthis_mdlcnt = id_mdlcnt
								WHERE mdlcnthis_mdlcnt IN ('{$__k_mdlcnt_a}')
								GROUP BY mdlcnthis_mdlcnt"; 

			$LsHisTot = $__cnx->_qry($LsHisTot_Qry);
			
			if($Ls){
				
				$row_LsHisTot = $LsHisTot->fetch_assoc(); 
				$Tot_LsHisTot = $LsHisTot->num_rows;
				
				if($Tot_LsHisTot>0){
					
					do {	
						
						$ido = $row_LsHisTot['mdlcnthis_mdlcnt'];
						
						if($row_LsHisTot['__tot'] > 0){ 
						  	if($row_LsHisTot['__tot'] > 0 && ChckSESS_superadm()){ $__call_clss = '_call';  }else{ $__call_clss = ''; }
						  	$_gst_lnk = '<a href="'.FL_DT_GN.__t('mdl_cnt_his',true).ADM_LNK_SB.
						  							$row_LsHisTot['mdlcnt_enc'].TXGN_POP.LNK_RND.Gn_Rnd(20).'" class="_dtl _nmb '.$__call_clss.'">'.$row_LsHisTot['__tot'].'</a>';
		            	}else{
			            	$_gst_lnk = '';
		            	}

						$rsp['l'][$ido]['tot_his'] = $_gst_lnk;	
						
					} while ($row_LsHisTot = $LsHisTot->fetch_assoc());
					
				}
			
			}
		
		
		//-------------------- Oportunidades Total --------------------//
			
			if($__dt_cl->mdlstp->{$__tp}->col->gst->allw == 'ok' || isN($__tp)){

				/*$LsIntsTot_Qry = "	SELECT id_mdlcnt, mdlcnt_cnt, COUNT(*) AS __tot
									FROM ".DB_CL.".".TB_MDL_CNT."
									WHERE id_mdlcnt IN ('{$__k_mdlcnt_a}')
									GROUP BY id_mdlcnt"; 
							
				$LsIntsTot = $__cnx->_qry($LsIntsTot_Qry);
				
				if($Ls){
					
					$row_LsIntsTot = $LsIntsTot->fetch_assoc(); 
					$Tot_LsIntsTot = $LsIntsTot->num_rows;
					
					if($Tot_LsIntsTot>0){
						
						do {	
							
							$ido = $row_LsIntsTot['id_mdlcnt'];
							$rsp['l'][$ido]['tot_ints'] = $row_LsIntsTot['__tot'];	
							
						} while ($row_LsIntsTot = $LsIntsTot->fetch_assoc());
						
					}
				
				}*/

			}
		
		//-------------------- Compras Total --------------------//
			
			if($__dt_cl->mdlstp->{$__tp}->col->buy->allw == 'ok' || isN($__tp)){

				$LsBuiTot_Qry = "	SELECT id_mdlcnt, mdlcnt_cnt, siscntest_buy, COUNT(*) AS __tot
									FROM ".DB_CL.".".TB_MDL_CNT."
										INNER JOIN "._BdStr(DBM).TB_SIS_CNT_EST." ON mdlcnt_est = id_siscntest
									WHERE id_mdlcnt IN ('{$__k_mdlcnt_a}') AND siscntest_buy = 1
									GROUP BY mdlcnt_cnt"; 
							
				$LsBuiTot = $__cnx->_qry($LsBuiTot_Qry);
				
				if($Ls){
					
					$row_LsBuiTot = $LsBuiTot->fetch_assoc(); 
					$Tot_LsBuiTot = $LsBuiTot->num_rows;
					
					if($Tot_LsBuiTot>0){
						
						do {	
							
							$ido = $row_LsBuiTot['id_mdlcnt'];
							$rsp['l'][$ido]['tot_cmpr'] = $row_LsBuiTot['__tot'];	
							
						} while ($row_LsBuiTot = $LsBuiTot->fetch_assoc());
						
					}
				
				}
			
			}
			
			
		//-------------------- Gestiones - First --------------------//
		
			$LsHisFrst_Qry = "	SELECT mdlcnthis_mdlcnt, mdlcnthis_fi, mdlcnthis_hi
								FROM ".DB_CL.".".TB_MDL_CNT_HIS."
								WHERE mdlcnthis_mdlcnt IN ('{$__k_mdlcnt_a}')
								GROUP BY mdlcnthis_mdlcnt
								ORDER BY mdlcnthis_fi ASC, mdlcnthis_hi ASC";
						
			$LsHisFrst = $__cnx->_qry($LsHisFrst_Qry);
			
			if($Ls){
				
				$row_LsHisFrst = $LsHisFrst->fetch_assoc(); 
				$Tot_LsHisFrst = $LsHisFrst->num_rows;
				
				if($Tot_LsHisFrst>0){
					
					do {	
						
						$ido = $row_LsHisFrst['mdlcnthis_mdlcnt'];	
						$rsp['l'][$ido]['prm'] = _Df_Dte_Wk($row_LsHisFrst['mdlcnthis_fi'].' '.$row_LsHisFrst['mdlcnthis_hi'], $rsp['l'][$ido]['fi'], ['_fr'=>'c'])->_r;	
						
					} while ($row_LsHisFrst = $LsHisFrst->fetch_assoc());
					
				}

			}
		
		
		//-------------------- Gestiones - Last --------------------//
		
			$LsHisLst_Qry = "	SELECT mdlcnthis_mdlcnt, MAX(mdlcnthis_fi) AS mdlcnthis_fi, MAX(mdlcnthis_hi) AS mdlcnthis_hi
								FROM ".DB_CL.".".TB_MDL_CNT_HIS."
								WHERE mdlcnthis_mdlcnt IN ('{$__k_mdlcnt_a}')
								GROUP BY mdlcnthis_mdlcnt
								ORDER BY mdlcnthis_fi DESC, mdlcnthis_hi DESC";
						
			$LsHisLst = $__cnx->_qry($LsHisLst_Qry);
			
			if($Ls){
				
				$row_LsHisLst = $LsHisLst->fetch_assoc(); 
				$Tot_LsHisLst = $LsHisLst->num_rows;
				
				if($Tot_LsHisLst>0){
					
					do {	
						
						$ido = $row_LsHisLst['mdlcnthis_mdlcnt'];
						$__k_glst[$ido] = $row_LsHisLst['mdlcnthis_fi'].' '.$row_LsHisLst['mdlcnthis_hi'];	
						
					} while ($row_LsHisLst = $LsHisLst->fetch_assoc());
					
				}

			}	
			
		//-------------------- Imagenes Lead --------------------//
		
			$LsFllImg_Qry = "	SELECT id_mdlcnt, mdlcnt_cnt, fllcntpht_url
								FROM "._BdStr(DBM).TB_FLL_CNT_PHT."
									 INNER JOIN "._BdStr(DBM).TB_FLL_CNT." ON fllcntpht_cnt = id_fllcnt
									 INNER JOIN ".DB_CL.".".TB_CNT_EML." ON fllcnt_eml=cnteml_eml
									 INNER JOIN ".DB_CL.".".TB_MDL_CNT." ON mdlcnt_cnt = cnteml_cnt
								WHERE id_mdlcnt IN ('{$__k_mdlcnt_a}')
								GROUP BY id_mdlcnt"; 
						
			$LsFllImg = $__cnx->_qry($LsFllImg_Qry);
			
			if($Ls){
				
				$row_LsFllImg = $LsFllImg->fetch_assoc(); 
				$Tot_LsFllImg = $LsFllImg->num_rows;
				
				if($Tot_LsFllImg>0){
					
					do {	
						
						$ido = $row_LsFllImg['id_mdlcnt'];
						$__k_pic[$ido] = $row_LsFllImg['fllcntpht_url'];
						
					} while ($row_LsFllImg = $LsFllImg->fetch_assoc());
					
				}
			
			}	
		
		//-------------------- Lead Score --------------------//
		
			$LsCntCld_Qry = "	SELECT id_mdlcnt, 
										"._QrySisSlcF([ 'als'=>'cld', 'als_n'=>'calidad' ]).",
										".GtSlc_QryExtra([ 't'=>'fld', 'p'=>'calidad', 'als'=>'cld' ])."		
								FROM ".DB_CL.".".TB_CNT."
									 INNER JOIN ".DB_CL.".".TB_MDL_CNT." ON mdlcnt_cnt = id_cnt
									 ".GtSlc_QryExtra([ 't'=>'tb', 'col'=>'cnt_cld', 'als'=>'cld' ])."	 
								WHERE id_mdlcnt IN ('{$__k_mdlcnt_a}')
								GROUP BY id_mdlcnt"; 
						
			$LsCntCld = $__cnx->_qry($LsCntCld_Qry);
			
			if($Ls){
				
				$row_LsCntCld = $LsCntCld->fetch_assoc(); 
				$Tot_LsCntCld = $LsCntCld->num_rows;
				
				if($Tot_LsCntCld>0){
					
					do {	
						
						$__cld = json_decode($row_LsCntCld['___calidad']);
					
						foreach($__cld as $__cld_k=>$__cld_v){
							$__cld_go->{$__cld_v->key} = $__cld_v;
						}
			
						$ido = $row_LsCntCld['id_mdlcnt'];
						$rsp['l'][$ido]['cnt']['cld'] = Spn('','','_cld _cld_'.$__cld_go->ptje->vl);	
						
						
					} while ($row_LsCntCld = $LsCntCld->fetch_assoc());
					
				}
			
			}
	
		//-------------------- Build Gestion Difference --------------------//
				
			foreach($__k_glst as $__k_glst_k=>$__k_glst_v){	
				
				$___date = date_create($__k_glst_v);  	
	          	$___fecha= date_format($___date, 'Y-m-d');
	          	$_gst_fcmp = Spn($___fecha);
          		$_gst_dif = _Df_Dte_Wk($__k_glst_v, SIS_F_D2, [ '_fr'=>'b', 'e'=>$rsp['l'][$ido]['est']['id'] ])->_r;	          		
          		
				$rsp['l'][$__k_glst_k]['gst_dif'] = $_gst_fcmp.HTML_BR.$_gst_dif;
					
			}			

		//-------------------- Build Icons --------------------//
				
			foreach($__k_icn as $__k_icn_k=>$__k_icn_v){		
				$__ob = $__k_icn_v;
				$__ob['___img'] = $__k_pic[$__k_icn_k];	
				$rsp['l'][$__k_icn_k]['ls_icn'] = __Ls_Chk_Icn(['d'=>$__ob, 'tp'=>$__tp, 'mre'=>$___mre_icn ]);		
			}

		//-------------------- Lead Score --------------------//
		
			$LsCntCld_Qry = "	SELECT id_mdlcnt, 
										"._QrySisSlcF([ 'als'=>'cld', 'als_n'=>'calidad' ]).",
										".GtSlc_QryExtra([ 't'=>'fld', 'p'=>'calidad', 'als'=>'cld' ])."		
								FROM ".DB_CL.".".TB_CNT."
									 INNER JOIN ".DB_CL.".".TB_MDL_CNT." ON mdlcnt_cnt = id_cnt
									 ".GtSlc_QryExtra([ 't'=>'tb', 'col'=>'cnt_cld', 'als'=>'cld' ])."	 
								WHERE id_mdlcnt IN ('{$__k_mdlcnt_a}')
								GROUP BY id_mdlcnt"; 
						
			$LsCntCld = $__cnx->_qry($LsCntCld_Qry);
			
			if($Ls){
				
				$row_LsCntCld = $LsCntCld->fetch_assoc(); 
				$Tot_LsCntCld = $LsCntCld->num_rows;
				
				if($Tot_LsCntCld>0){
					
					do {	
						
						$__cld = json_decode($row_LsCntCld['___calidad']);
					
						foreach($__cld as $__cld_k=>$__cld_v){
							$__cld_go->{$__cld_v->key} = $__cld_v;
						}
			
						$ido = $row_LsCntCld['id_mdlcnt'];
						$rsp['l'][$ido]['cnt']['cld'] = Spn('','','_cld _cld_'.$__cld_go->ptje->vl);	
						
						
					} while ($row_LsCntCld = $LsCntCld->fetch_assoc());
					
				}
			
			}


		//-------------------- Medios Relacionados --------------------//
		
			$LsMdlCntM_Qry = "SELECT
									id_mdlcnt, mdlcnt_enc, mdlcnt_m, id_mdlcntm, mdlcntm_m, sismd_tt,  sismd_img	
								FROM
									".TB_MDL_CNT."
									LEFT JOIN ".TB_MDL_CNT_M_BD." ON id_mdlcnt = mdlcntm_mdlcnt 
									INNER JOIN "._BdStr(DBM).TB_SIS_MD." ON id_sismd = mdlcntm_m
								WHERE
									mdlcnt_enc IN ('{$__mcnt_a}') 
								GROUP BY
									mdlcntm_mdlcnt, mdlcntm_m	
							"; 
			
			$LsMdlCntM = $__cnx->_qry($LsMdlCntM_Qry);
			
			if($Ls){
				
				$row_LsMdlCntM = $LsMdlCntM->fetch_assoc(); 
				$Tot_LsMdlCntM = $LsMdlCntM->num_rows;
				
				if($Tot_LsMdlCntM>0){
					
					do {	

						$vl_m[$row_LsMdlCntM['id_mdlcntm']]['id'] = $row_LsMdlCntM['id_mdlcnt'];
						$vl_m[$row_LsMdlCntM['id_mdlcntm']]['enc'] = $row_LsMdlCntM['mdlcnt_enc'];
						$vl_m[$row_LsMdlCntM['id_mdlcntm']]['m'] = $row_LsMdlCntM['mdlcnt_m'];
						$vl_m[$row_LsMdlCntM['id_mdlcntm']]['m_m'] = $row_LsMdlCntM['mdlcntm_m'];
						$vl_m[$row_LsMdlCntM['id_mdlcntm']]['tt'] = $row_LsMdlCntM['sismd_tt'];
						$vl_m[$row_LsMdlCntM['id_mdlcntm']]['img'] = $row_LsMdlCntM['sismd_img'];

					} while ($row_LsMdlCntM = $LsMdlCntM->fetch_assoc());

					foreach($vl_m as $vl_m_k=>$vl_m_v){

						if(isN($vl_m_v['img'])){
							$img = DMN_IMG_ESTR_SVG.'unknow.svg';
						}else{
							$img = DMN_FLE.'sis/md/'.$vl_m_v['img'];
						}

						$rsp['l'][$vl_m_v['id']]['__md'] .= '<span><img title="'.$vl_m_v['tt'].'" src="'.$img.'"></span>';	
					}
					
				}
			
			}

		//-------------------- Paises Relacionados --------------------//

			$LsMdlCntPs_Qry = "SELECT
									id_mdlcnt, mdlcnt_enc, 
									ps.id_sisps AS id_ps, ps.sisps_tt AS ps, ps.sisps_img AS ps_img, 
									ps_tel.id_sisps AS id_ps_tel, ps_tel.sisps_tt AS ps_tel, ps_tel.sisps_img AS ps_tel_img
								FROM
									".TB_MDL_CNT."
									INNER JOIN ".TB_CNT." ON mdlcnt_cnt = id_cnt
									LEFT JOIN ".TB_CNT_CD." ON cntcd_cnt = id_cnt AND cntcd_rel = 724
									LEFT JOIN "._BdStr(DBM).TB_SIS_CD." ON cntcd_cd = id_siscd
									LEFT JOIN "._BdStr(DBM).TB_SIS_CD_DP." ON siscd_dp = id_siscddp
									LEFT JOIN "._BdStr(DBM).TB_SIS_PS." AS ps ON siscddp_ps = ps.id_sisps
									LEFT JOIN ".TB_CNT_TEL." ON cnttel_cnt = id_cnt
									LEFT JOIN "._BdStr(DBM).TB_SIS_PS." AS ps_tel ON cnttel_ps = ps_tel.id_sisps
								WHERE mdlcnt_enc IN ('{$__mcnt_a}') AND ( ps.sisps_tt IS NOT NULL OR ps_tel.sisps_tt IS NOT NULL)  
								GROUP BY id_mdlcnt";

			$LsMdlCntPs = $__cnx->_qry($LsMdlCntPs_Qry);

			if($Ls){

				$row_LsMdlCntPs = $LsMdlCntPs->fetch_assoc(); 
				$Tot_LsMdlCntPs= $LsMdlCntPs->num_rows;

				if($Tot_LsMdlCntPs>0){

					do {	

						if(!isN($row_LsMdlCntPs['ps'])){
							$rsp['l'][$row_LsMdlCntPs['id_mdlcnt']]['__ps']['img'] = DMN_FLE_PS_TH."sis_ps_".$row_LsMdlCntPs['id_ps']."x50.jpg"; ;
							$rsp['l'][$row_LsMdlCntPs['id_mdlcnt']]['__ps']['tt'] = $row_LsMdlCntPs['ps'];
						}else{
							$rsp['l'][$row_LsMdlCntPs['id_mdlcnt']]['__ps']['img'] = DMN_FLE_PS_TH."sis_ps_".$row_LsMdlCntPs['id_ps_tel']."x50.jpg"; ;
							$rsp['l'][$row_LsMdlCntPs['id_mdlcnt']]['__ps']['tt'] = $row_LsMdlCntPs['ps_tel'];
						}

					} while ($row_LsMdlCntPs = $LsMdlCntPs->fetch_assoc());
				}
			}

	}
	
?>