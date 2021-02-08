<?php


    if( $_tp == "all" || $_tp == "dt" ){
        
        $___ses->bd = $_bd."."; //Base de datos
       
        /* -----> Filtros y permisos -----> */
        //Permisos de area
        if( !isN($_GtSesDt->us->are) ){
            $fl_are = ' EXISTS (	SELECT *  
										FROM '._BdStr($_bd).TB_MDL_ARE.' 
										WHERE mdlare_mdl = id_mdl AND mdlare_are IN ('.$_GtSesDt->us->are.')	 
									) ';
        }

        //Permisos de modulo
        if( !isN($_GtSesDt->us->mdl->mdl_n) ){	
            if(!isN($fl_are)){ $fl_mdl = ' || '; }
			$fl_mdl .= ' (	 id_mdl IN ( '.$_GtSesDt->us->mdl->mdl_n.' )	 ) ';
        }

        if( !isN($fl_mdl) || !isN($fl_are) ){  $__fl  .= ' AND ( '.$fl_are.$fl_mdl.' ) ';   } 

        //Filtro buscar por (Nombre - Apellido)
        if( !isN($_cnt_nm_fl) ){
            include('_ext/mdl_cnt_sch.php');
        }
        /* <----- Filtros y permisos <----- */

        if($_tp == "dt"){ $__fl .= ' AND mdlcnt_enc = "'.$_mdlcnt_enc.'" '; } //Detalle del lead

        $_pgs_row_i = (int)$_pgs_row; //Contador para infinite-scroll - Inicial
        $_pgs_row_f = (int)$_pgs_row+50; //Contador para infinite-scroll - Final

		$Ls_Qry = "
                    SELECT 

                        DISTINCT id_mdlcnt,	

                        mdlcnt_cnt AS __tcnt,
                        mdlcnt_enc,
                        mdlcnt_m,
                        mdlcnt_dsp,
                        mdlcnt_ref,
                        mdlcnt_est,
                        mdlcnt_mdl,
                        mdlcnt_fi,
                        mdlcnt_fa,
                        mdlcnt_cnt,
                        mdlcnt_m_k,
                        mdlcnt_chk_chi,
                        mdlcnt_us,
                        mdlcnt_prd,
                        
                        id_cnt,
                        cnt_nm,
                        cnt_ap,
                        cnt_sx,
                        
                        mdlst.mdlstp_tp AS __mdlstp_tp,
                        mdlt.mdlstp_tp AS __mdlttp_tp,
                        mdlst.id_mdlstp as __id_mdlstp, 
                        
                        id_mdl,
                        mdl_nm,
                        mdl_enc,
                        mdl_est,
                        
                        siscntest_enc,
                        siscntest_tt,
                        siscntest_clr_bck,
                        siscntesttp_enc,
                        
                        sismd_enc,
                        sismd_tt,
                        sisfnt_enc,
                        mdlcntsch_mdlssch

                    FROM "._BdStr($_bd).TB_MDL_CNT." 
                    INNER JOIN "._BdStr($_bd).TB_MDL." ON mdlcnt_mdl = id_mdl 
                    INNER JOIN "._BdStr(DBM).TB_SIS_CNT_EST." ON mdlcnt_est = id_siscntest
                    INNER JOIN "._BdStr(DBM).TB_SIS_CNT_EST_TP." ON siscntest_tp = id_siscntesttp
                    INNER JOIN "._BdStr($_bd).TB_CNT." ON mdlcnt_cnt = id_cnt
                    INNER JOIN "._BdStr(DBM).TB_MDL_S." ON mdl_mdls = id_mdls
                    INNER JOIN "._BdStr(DBM).TB_MDL_S_TP." AS mdlst ON mdls_tp = mdlst.id_mdlstp
                    INNER JOIN "._BdStr(DBM).TB_SIS_MD." ON mdlcnt_m = id_sismd
                    LEFT JOIN "._BdStr(DBM).TB_SIS_FNT." ON mdlcnt_fnt = id_sisfnt
                    LEFT JOIN "._BdStr(DBM).TB_MDL_S_PRD." ON mdlcnt_prd = id_mdlsprd
                    LEFT JOIN "._BdStr(DBM).TB_MDL_S_TP." AS mdlt ON mdl_mdlstp = mdlt.id_mdlstp 
                    LEFT JOIN "._BdStr($_bd).TB_MDL_CNT_SCH." ON mdlcntsch_mdlcnt = id_mdlcnt
                    
                    WHERE id_mdlcnt != ''

                    ".$__fl."

                    ORDER BY id_mdlcnt DESC LIMIT  $_pgs_row_i,$_pgs_row_f
                ";

		if(!isN($Ls_Qry)){
            
			$Ls_Rg = $__cnx->_qry($Ls_Qry); 
			
			if($Ls_Rg){
				
				$row_Ls_Rg = $Ls_Rg->fetch_assoc(); 
				$Tot_Ls_Rg = $Ls_Rg->num_rows;
				
				$rsp['tot'] = $Tot_Ls_Rg;

                if($Tot_Ls_Rg > 0){
                    
                    $rsp['e'] = "ok";

                    do{

                        $__diff = _Df_Dte($row_Ls_Rg["mdlcnt_fi"], SIS_F_TS); 
                        
                        if($__diff->d < 1){
                            $_fgo = _HrHTML($row_Ls_Rg["mdlcnt_fi"]);
                        }elseif($__diff->d == 1){
                            $_fgo = 'Ayer';
                        }elseif($__diff->d < 7){
                            $_fgo = FechaESP_OLD($row_Ls_Rg["mdlcnt_fi"], 6);
                        }else{
                            $_fgo = _Dte_([ 'd'=>$row_Ls_Rg["mdlcnt_fi"] ])->f;
                        }

                        $rsp['ls'][$row_Ls_Rg["mdlcnt_enc"]]['enc'] = ctjTx($row_Ls_Rg["mdlcnt_enc"],'in');
                        $rsp['ls'][$row_Ls_Rg["mdlcnt_enc"]]['cnt_nm'] = ctjTx($row_Ls_Rg["cnt_nm"],'out');
                        $rsp['ls'][$row_Ls_Rg["mdlcnt_enc"]]['cnt_ap'] = ctjTx($row_Ls_Rg["cnt_ap"],'out');
                        $rsp['ls'][$row_Ls_Rg["mdlcnt_enc"]]['fi'] = $_fgo;
                        $rsp['ls'][$row_Ls_Rg["mdlcnt_enc"]]['mdl_nm'] = ctjTx($row_Ls_Rg["mdl_nm"],'in');
                        $rsp['ls'][$row_Ls_Rg["mdlcnt_enc"]]['est_clr'] = ctjTx($row_Ls_Rg["siscntest_clr_bck"],'in');
                        $rsp['ls'][$row_Ls_Rg["mdlcnt_enc"]]['est_tt'] = ctjTx($row_Ls_Rg["siscntest_tt"],'in');
                        $rsp['ls'][$row_Ls_Rg["mdlcnt_enc"]]['est_enc'] = ctjTx($row_Ls_Rg["siscntest_enc"],'in');
                        
                        $rsp["pgs_row_i"] = $_pgs_row_i;
                        $rsp["pgs_row_f"] = $_pgs_row_f;

                        //Listado de estados - Solo si es detalle del lead
                        if($_tp == "dt"){
                            include('_ext/mdl_cnt_est.php');
                        }

                    }while($row_Ls_Rg = $Ls_Rg->fetch_assoc());

				}else{
                    $rsp['e'] = "no";
                    $rsp["pgs_row_i"] = 0;
                    $rsp["pgs_row_f"] = 0;
                }
                

			}else{

                $rsp['e'] = "no";
				$rsp['w'] = $__cnx->c_r->error;
	
			}

		}else{

			$rsp['w'] = 'No query';

		}
	
	}

?>