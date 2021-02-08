<?php 

    //Filtro de area
    if(!isN($_GtSesDt->us->are)){
        $__fl_est .= " AND (
                            id_siscntest IN (	SELECT siscntestare_est 
                                                FROM "._BdStr(DBM).TB_SIS_CNT_EST_ARE."
                                                WHERE siscntestare_are IN (".$_GtSesDt->us->are.")
                                            ) 
                            || id_siscntest NOT IN( SELECT siscntestare_est 
                                                FROM "._BdStr(DBM).TB_SIS_CNT_EST_ARE."
                                            )
                            ||	id_siscntest IN(
                                SELECT
                                    siscntestare_est
                                FROM
                                    "._BdStr(DBM).TB_SIS_CNT_EST_ARE."
                                WHERE
                                    siscntestare_are IN(
                                        SELECT
                                            clare_prnt
                                        FROM
                                            "._BdStr(DBM).TB_CL_ARE."
                                        WHERE
                                            id_clare IN(".$_GtSesDt->us->are.")
                                    )
                            )
                                            
                        )				
                ";                                                                                    
    }

    //Filtro de cliente
    if( !isN($__dt_cl->enc) ){ $__fl_est .= " AND cl_enc = '".$__dt_cl->enc."' "; }

    //Filtro de modulo
    if( !isN($row_Ls_Rg['mdlcnt_mdl']) ){ 
        $__cntestare = LsCntEstAreAll([ 'mdl'=>$row_Ls_Rg['mdlcnt_mdl'], 'cl_enc'=>$__dt_cl->enc, 'bd'=>$_bd."." ]); 
		if(!isN($__cntestare) && !isN($__cntestare->ls)){
            foreach($__cntestare->ls as $__cntestare_k=>$__cntestare_v){
                $___are_in[] = $__cntestare_v->id;
            }
            if(is_array($___are_in)){ $___are_in_go = implode(',', $___are_in); }
        }

        if(!isN($___are_in_go)){
            $__fl_est .= " AND ( id_siscntest IN (	SELECT siscntestare_est 
                                                            FROM "._BdStr(DBM).TB_SIS_CNT_EST_ARE."
                                                            WHERE siscntestare_are IN (".$___are_in_go.")
                                                        ) 
                                                        
                                ||	id_siscntest NOT IN( SELECT siscntestare_est 
                                                     FROM "._BdStr(DBM).TB_SIS_CNT_EST_ARE."
                                                )
                                                
                                ||	id_siscntest IN(
                                    SELECT
                                        siscntestare_est
                                    FROM
                                        "._BdStr(DBM).TB_SIS_CNT_EST_ARE."
                                    WHERE
                                        siscntestare_are IN(
                                            SELECT
                                                clare_prnt
                                            FROM
                                                "._BdStr(DBM).TB_CL_ARE."
                                            WHERE
                                                id_clare IN(".$___are_in_go.")
                                        )
                                )
                    
                            )"; 
        }
    }

    //Filtro mdl_s_tp
    if( !isN($row_Ls_Rg['__id_mdlstp']) ){
		$__fl_est .= sprintf(' AND  
                            (	SELECT COUNT(*) 
                                FROM '._BdStr(DBM).TB_MDL_S_TP_EST.'
                                WHERE siscntest_cl = id_cl AND mdlstpest_mdlstp=%s AND mdlstpest_est = 1 AND mdlstpest_cntest = id_siscntest 
                            ) > 0',
                            GtSQLVlStr($row_Ls_Rg['__id_mdlstp'], 'int'));  						
    }	

    $Ls_Qry_Est = '
        SELECT * FROM '._BdStr(DBM).TB_SIS_CNT_EST.' 
        INNER JOIN '._BdStr(DBM).TB_CL.' ON siscntest_cl = id_cl
        INNER JOIN '._BdStr(DBM).TB_SIS_CNT_EST_TP.' ON siscntest_tp = id_siscntesttp
        WHERE id_siscntest != ""
        '.$__fl_est.'
    ';

    //$rsp['ls'][$row_Ls_Rg["mdlcnt_enc"]]['est_ls'] = LsCntEst([ 'id'=>'mdlcnt_est', 'v'=>'id_siscntest', 'va'=>$row_Ls_Rg['mdlcnt_est'], 'v_go'=>'enc', 'rq'=>1, 'mdl'=>$row_Ls_Rg['mdlcnt_mdl'], 'mdlstp'=>$___Ls->mdlstp->id, 'are'=>$_GtSesDt->us->are,'cl_enc'=>$__dt_cl->enc ]);		       

    $Ls_Rg_Est = $__cnx->_qry($Ls_Qry_Est); 
        if($Ls_Rg_Est){
        $row_Ls_Rg_Est = $Ls_Rg_Est->fetch_assoc(); 
        $Tot_Ls_Rg_Est = $Ls_Rg_Est->num_rows;

        if($Tot_Ls_Rg_Est > 0 ){
            do{
                $rsp['ls'][$row_Ls_Rg["mdlcnt_enc"]]['est_ls'][$row_Ls_Rg_Est["siscntest_enc"]]['tt'] = ctjTx($row_Ls_Rg_Est["siscntest_tt"],'in');
                $rsp['ls'][$row_Ls_Rg["mdlcnt_enc"]]['est_ls'][$row_Ls_Rg_Est["siscntest_enc"]]['enc'] = ctjTx($row_Ls_Rg_Est["siscntest_enc"],'in');
            }while($row_Ls_Rg_Est = $Ls_Rg_Est->fetch_assoc());
        }
    }

?>