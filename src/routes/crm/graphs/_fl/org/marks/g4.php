<?php 


    $__dt_1 = !isN($___Dt->_fl->f1) ? $___Dt->_fl->f1 : date('Y-01-01'); 
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

    $LsQry = "  SELECT  org_nm,
                        org_clr,
                        orgsds_nm,
                        org_img,
                        id_orgsds,
                        orgsdsarr_vl,
                        cllcl_m2,
                        SUM(orgsdsarrsls_vl) AS _t_sls,
                        DATE_FORMAT(orgsdsarrsls_f, '%Y-%m') as _f_i
                FROM "._BdStr(DBM).TB_ORG_SDS_ARR_SLS."
                     INNER JOIN "._BdStr(DBM).TB_ORG_SDS_ARR." ON orgsdsarrsls_arr = id_orgsdsarr 
                     INNER JOIN "._BdStr(DBM).TB_CL_LCL." ON orgsdsarr_lcl = id_cllcl 
                     INNER JOIN "._BdStr(DBM).TB_ORG_SDS." ON orgsdsarr_orgsds = id_orgsds
                     INNER JOIN "._BdStr(DBM).TB_ORG." ON orgsds_org = id_org
                WHERE id_orgsdsarrsls != '' ".$___Dt->qry_f."     
                GROUP BY _f_i, orgsdsarr_orgsds
                ORDER BY org_nm ASC
            ";
        
    $LsRg = $__cnx->_qry($LsQry);


    if($LsRg){ 
        
        $rwLsRg = $LsRg->fetch_assoc(); 
        $TotLsRg = $LsRg->num_rows; 
        
        if($TotLsRg > 0){
            
            do {

                $__img = _ImVrs(['img'=>$rwLsRg['org_img'], 'f'=>DMN_FLE_ORG ]);

                $__v['g'][$rwLsRg['_f_i']]['date'] = $rwLsRg['_f_i'];
                $__v['g'][$rwLsRg['_f_i']]['tot'] = $__v['g'][$rwLsRg['_f_i']]['tot'] + $rwLsRg['_t_sls']; 

                $__v['m'][ $rwLsRg['id_orgsds'] ]['nm'] = $rwLsRg['org_nm'];
                $__v['m'][ $rwLsRg['id_orgsds'] ]['clr'] = $rwLsRg['org_clr'];
                $__v['m'][ $rwLsRg['id_orgsds'] ]['arr'] = $rwLsRg['orgsdsarr_vl'];
                $__v['m'][ $rwLsRg['id_orgsds'] ]['m2'] = $rwLsRg['cllcl_m2'];
                $__v['m'][ $rwLsRg['id_orgsds'] ]['img'] = $__img;
                $__v['m'][ $rwLsRg['id_orgsds'] ]['f'][$rwLsRg['_f_i']]['date'] = $rwLsRg['_f_i'];
                $__v['m'][ $rwLsRg['id_orgsds'] ]['f'][$rwLsRg['_f_i']]['tot'] = $__v[$rwLsRg['_f_i']]['tot'] + $rwLsRg['_t_sls']; 
           
            } while ($rwLsRg = $LsRg->fetch_assoc());


            for($i=$__dt_1; $i<=$__dt_2; $i=date("Y-m", strtotime($i ."+ 1 month"))){ 	
                
                $__tot_g_arr = '';
                $__tot_g_m2 = '';
                $__g_m2_v = '';
                $__fkey = date("Y-m", strtotime($i) );
                $__ctg[] = '"'.FechaESP_OLD($__fkey, 10).'"';

                foreach($__v['m'] as $__marks_k=>$__marks_v){

                    if(!isN($__marks_v['m2'])){

                        $__m2_v = $__marks_v['arr']/$__marks_v['m2'];

                        $__tot_g_arr = $__tot_g_arr + $__marks_v['arr'];
                        $__tot_g_m2 = $__tot_g_m2 + $__marks_v['m2'];
                    
                        if( !isN( $__marks_v['f'][ $__fkey ]['tot'] ) ){
                            $__tot = number_format($__marks_v['f'][ $__fkey ]['tot'] / $__m2_v, 0, '.', '');
                        }else{
                            $__tot = 0;
                        }

                        $__data_bmrk[ $__marks_k ][] = "
                            {
                                y: '".$__tot."',
                                logo:'".$__marks_v['img']->th_50."'
                            }
                        ";

                    }

                }

                $__g_m2_v = $__tot_g_arr/$__tot_g_m2;

                if( !isN( $__v['g'][ $__fkey ]['tot'] ) && !isN($__g_m2_v) ){
                    $__tot_g = number_format( $__v['g'][ $__fkey ]['tot']/$__g_m2_v , 0, '.', '');
                }else{
                    $__tot_g = 0;
                }

                $__data_g[ $__fkey ] = $__tot_g;


            }

            foreach($__v['m'] as $__marks_k=>$__marks_v){

                $__data_mrk[ $__marks_k ] = "
                    {
                        name:\"".$__marks_v['nm']."\",    
                        data:[".implode(",", $__data_bmrk[$__marks_k])."], 
                        color:'".$__marks_v['clr']."'
                    }
                ";
            }

            $_grph_c = implode(",", $__ctg);            
            $_grph_data_g = implode(",", $__data_g);
            $_grph_data_m = implode(",", $__data_mrk);
   
            $CntWb .= "
                    SUMR_Grph.f.g3({ 
                        id: '#bx_grph_".$_gr."_4',
                        tt: 'Ventas Totales x Mts2 Ocupados', 
                        tt_sb: '".$_grph_subt."',
                        c:[".$_grph_c."],
                        c_e: false,
                        d:[
                            {
                                name:'Total General',   
                                data:[".$_grph_data_g."], 
                                color:'#000'
                            },
                            ".$_grph_data_m."
                        ],
                        ttip_frmt:function(d){
                            if(!isN(d) && !isN(d.point)){
                                return '$' + Highcharts.numberFormat(d.y, 0, ',', '.');
                            }
                        },
                        plot_dl_uhtml: true,
                        plot_dl_allwovlp: true,
                        plot_dl_y: -1,
                        plot_dl_frmt:function(d){
                            if(!isN(d) && !isN(d.point)){
                                
                                if(!isN( d.point.logo )){
                                    var point = d.point;

                                    window.setTimeout(function () {
                                        point.dataLabel.attr({
                                            y: point.plotY - 20
                                        });
                                    });

                                    return '<div class=\"HiChrt_Logo_Th _smll\"><div class=\"_imgf\" style=\"background-image:url(' + d.point.logo + ');margin-left:auto;margin-right:auto;\"></div></div>';
                                }

                            }
                        }
                    });
                ";
   
        }
        
    }else{

        echo $__cnx->c_r->error;

    }
            

    $__cnx->_clsr($LsRg);

?>