<?php 

        $Ls_Cnt_Qry = " SELECT sismd_tt, COUNT(*) AS __tot_m 
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

?>