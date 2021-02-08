<?php 
    
    
    $__dt_1 = !isN($___Dt->_fl->f1) ? $___Dt->_fl->f1 : date('Y-m-01');
    $__dt_2 = !isN($___Dt->_fl->f2) ? $___Dt->_fl->f2 : date('Y-m-d');


    if(isN($___Dt->_fl->f1) && isN($___Dt->_fl->f2)){
        $_grph_subt = 'Mes actual';
    }elseif(isN($___Dt->_fl->f2)){
        $_grph_subt = FechaESP_OLD($___Dt->_fl->f1);
    }else{
        $_grph_subt = FechaESP_OLD($___Dt->_fl->f1).' - '.FechaESP_OLD($___Dt->_fl->f2);
    }


    if(!isN($__dt_1) && isN($__dt_2)){
        $___Dt->qry_f .= ' AND DATE_FORMAT(orgsdsarrsls_f, "%Y-%m-%d") = "'.$__dt_1.'" ';
    }elseif(isN($__dt_1) && !isN($__dt_2)){
        $___Dt->qry_f .= ' AND DATE_FORMAT(orgsdsarrsls_f, "%Y-%m-%d") = "'.$__dt_2.'" ';
    }elseif(!isN($__dt_1) && !isN($__dt_2)){
        $___Dt->qry_f .= ' AND DATE_FORMAT(orgsdsarrsls_f, "%Y-%m-%d") BETWEEN "'.$__dt_1.'" AND "'.$__dt_2.'" ';
    }

    if(!isN($___Dt->_fl->fk->cllcl_lvl)){
        $__fl .= " AND id_org IN ( SELECT id_org FROM "._BdStr(DBM).TB_ORG." 
                    INNER JOIN "._BdStr(DBM).TB_ORG_SDS." ON orgsds_org = id_org
                    INNER JOIN "._BdStr(DBM).TB_ORG_SDS_ARR." ON orgsdsarr_orgsds = id_orgsds
                    INNER JOIN "._BdStr(DBM).TB_CL_LCL." ON orgsdsarr_lcl = id_cllcl WHERE cllcl_lvl = ".$___Dt->_fl->fk->cllcl_lvl." )";	
    }

    if(!isN($___Dt->_fl->fk->_fl_orgtag)){

        $__fl .= " AND id_org IN ( SELECT id_org FROM "._BdStr(DBM).TB_ORG." 
                    INNER JOIN "._BdStr(DBM).TB_ORG_TAG." ON orgtag_org = id_org
                        WHERE orgtag_tag = ".$___Dt->_fl->fk->_fl_orgtag." )";

    }

    if(!isN($___Dt->_fl->fk->_fl_orgls)){

        $__fl .= " AND id_org IN ( ".$___Dt->_fl->fk->_fl_orgls." )";

    }

    if(!isN($___Dt->_fl->fk->_fl_orgest)){
        $__fl .= " AND org_est = ".$___Dt->_fl->fk->_fl_orgest;	
    }

    $LsQry = "  SELECT  org_nm,
                        org_clr,
                        orgsds_nm,
                        org_img,
                        SUM(orgsdsarrsls_vl) AS _t_sls
                FROM "._BdStr(DBM).TB_ORG_SDS_ARR_SLS."
                     INNER JOIN "._BdStr(DBM).TB_ORG_SDS_ARR." ON orgsdsarrsls_arr = id_orgsdsarr 
                     INNER JOIN "._BdStr(DBM).TB_ORG_SDS." ON orgsdsarr_orgsds = id_orgsds
                     INNER JOIN "._BdStr(DBM).TB_ORG." ON orgsds_org = id_org
                WHERE id_orgsdsarrsls != '' ".$___Dt->qry_f." ".$__fl."    
                GROUP BY orgsdsarr_orgsds
                ORDER BY org_nm ASC
            ";
        
    $LsRg = $__cnx->_qry($LsQry);


    if($LsRg){ 
        
        $rwLsRg = $LsRg->fetch_assoc(); 
        $TotLsRg = $LsRg->num_rows; 
        
        if($TotLsRg > 0){
            
            do {

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
    
   
            $CntWb .= "
                    SUMR_Grph.f.g1({ 
                        id: '#bx_grph_".$_gr."_1',
                        d: [".$_grph_tag."],
                        tt: 'Ventas Totales', 
                        tt_sb: '".$_grph_subt."',
                        c_e: false,
                        ttip_frmt:function(d){
                            if(!isN(d) && !isN(d.point)){
                                return '<b>'+d.series.name+'</b> : $' + Highcharts.numberFormat(d.y, 0, ',', '.');
                            }
                        },
                        plot_dl_e:false,
                        plot_dl_uhtml: true,
                        plot_dl_allwovlp: true,
                        plot_dl_y: -5,
                        plot_dl_gpdng:0,
                        lgnd: true
                    });
                ";

                
        }
        
    }else{

        echo $__cnx->c_r->error;

    }

    
            

?>