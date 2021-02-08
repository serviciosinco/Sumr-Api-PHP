<?php 

    if(isN($___Dt->_fl->f1) && isN($___Dt->_fl->f2)){
        $___Dt->qry_f .= ' AND DATE_FORMAT(orgsds_fi, "%Y-%m-%d") BETWEEN "'.$__dt_1.'" AND "'.$__dt_2.'" ';
    }

    $Ls_Cnt_Qry = " SELECT *, DATE_FORMAT(orgsds_fi, '%Y-%m-%d') as _f_i
                    FROM ".TB_MDL_CNT."
                        INNER JOIN ".TB_MDL." ON mdlcnt_mdl = id_mdl 
                        INNER JOIN "._BdStr(DBM).TB_MDL_S." ON mdl_mdls = id_mdls
                        INNER JOIN "._BdStr(DBM).TB_MDL_S_TP." AS mdlst ON mdls_tp = mdlst.id_mdlstp
                        INNER JOIN "._BdStr(DBM).TB_SIS_CNT_EST." ON mdlcnt_est = id_siscntest
                        INNER JOIN "._BdStr(DBM).TB_SIS_CNT_EST_TP." ON siscntest_tp = id_siscntesttp
                        INNER JOIN ".TB_CNT." ON mdlcnt_cnt = id_cnt 
                        INNER JOIN "._BdStr(DBM).TB_SIS_MD." ON mdlcnt_m = id_sismd
                        RIGHT JOIN "._BdStr(DBM).TB_SIS_FNT." ON mdlcnt_fnt = id_sisfnt
                        LEFT JOIN "._BdStr(DBM).TB_MDL_S_TP." AS mdlt ON mdl_mdlstp = mdlt.id_mdlstp
                        
                    WHERE mdlst.mdlstp_tp = '".$_t2."' ".$___Dt->qry_f."
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
                
                //$Vl['d'][$row_Ls_Cnt_Rg['id_mdl']]['nm'] = ctjTx($row_Ls_Cnt_Rg['mdl_nm'], 'in');
                //$Vl['d'][$row_Ls_Cnt_Rg['id_mdl']]['f'][$row_Ls_Cnt_Rg['_f_i']]['tot']++;
                
                $Vl['d'][$row_Ls_Cnt_Rg['_f_i']]['tot']++;
                        
            } while ($row_Ls_Cnt_Rg = $Ls_Cnt_Rg->fetch_assoc());
            $Vl_Grph = _jEnc($Vl);
        }
        
    }

    for($i=$__dt_1;$i<=$__dt_2;$i = date("Y-m-d", strtotime($i ."+ 1 days"))){ 
        
        $__ctg[] = '"'.$i.'"'; 
        $_medio[] = (!isN($Vl_Grph->d->{$i}->tot)?$Vl_Grph->d->{$i}->tot:'0');
        
        /*foreach($Vl_Grph->d as $_k => $_v){
            $_d[$_k]['nm'] = $_v->nm;
            $_d[$_k]['tot'][] = ( !isN($_v->f->{$i}->tot) ) ? $_v->f->{$i}->tot : 0 ;
        }*/
        
    }

    //Construye los datos
    /*foreach(_jEnc($_d) as $_k_d => $_v_d){
        $_medio[] = "{ name:'".$_v_d->nm."', data:[".implode(',', $_v_d->tot)."] } ";
    }*/

    //Construye los datos

    /* Pipe: No es necesario recorrer el dato tiene que ser desde la fecha y rellenar con 0 sino la grafica le estalla
    foreach($Vl_Grph->d as $_k => $_v){
        $_medio[] = $_v->tot;
    }
    */

    $_grph_d = "{ name:'Total ', data:[".implode(',', $_medio)."] } ";	

    $_grph_c = implode(",", $__ctg); 

    $CntWb .= "
        SUMR_Grph.f.g4({ 
            id: '#bx_grph_".$_gr."_1',
            c: [".$_grph_c."],
            d: [".$_grph_d."],
            tt: 'Leads', 
            tt_sb: 'Leads por Modulos',
            c_e: false,
            lgnd: false
        });
    ";


?>