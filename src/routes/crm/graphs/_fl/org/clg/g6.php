<?php 

    $Ls_Cnt_Qry = " SELECT id_mdlsprd, mdlsprd_nm, mdlsprd_y, count(*) as prd 
                    FROM ".TB_MDL_CNT."
                        INNER JOIN sumr_bd._sis_cnt_est ON mdlcnt_est = id_siscntest
                        INNER JOIN _mdl_cnt_prd ON mdlcntprd_mdlcnt = id_mdlcnt
                        INNER JOIN sumr_bd._mdl_s_prd ON mdlcntprd_mdlsprd = id_mdlsprd
                        INNER JOIN org_sds_cnt ON orgsdscnt_cnt = mdlcnt_cnt
                        INNER JOIN sumr_bd.org_sds ON orgsdscnt_orgsds = id_orgsds
                        INNER JOIN sumr_bd.org ON orgsds_org = id_org
                        where id_siscntest = 157
                        /*AND org_enc = '".$__i."'*/
                        AND mdlcntprd_est = 1
                        group by id_mdlsprd
                        having mdlsprd_y > 2018
                        order by mdlsprd_y, mdlsprd_nm
    ";

    $Ls_Cnt_Rg = $__cnx->_qry($Ls_Cnt_Qry);

    if($Ls_Cnt_Rg){ 

        $row_Ls_Cnt_Rg = $Ls_Cnt_Rg->fetch_assoc(); 
        $Tot_Ls_Cnt_Rg = $Ls_Cnt_Rg->num_rows; 

        if($Tot_Ls_Cnt_Rg > 0){

            do {

                $Vl_2['ctg'][$row_Ls_Cnt_Rg['id_mdlsprd']] = $row_Ls_Cnt_Rg['mdlsprd_nm'];
                $Vl_2['d']['m_a']['nm'] = 'Total';
				$Vl_2['d']['m_a'][$row_Ls_Cnt_Rg['id_mdlsprd']]['tot'] = number_format($row_Ls_Cnt_Rg['prd'], 0, '.', '');

            } while ($row_Ls_Cnt_Rg = $Ls_Cnt_Rg->fetch_assoc());

            $Vl_Grph_2 = _jEnc($Vl_2);
        }
    }

    foreach($Vl_Grph_2->ctg as $k => $v){
        $__ctg[] = '"'.$v.'"';

        foreach($Vl_Grph_2->d as $_k => $_v){
            $_d[$_k]['nm'] = $_v->nm;
            $_d[$_k]['tot'][] = ( !isN($_v->{$k}->tot) ) ? $_v->{$k}->tot : 0 ;
        }
    }

    //Construye los datos
    foreach(_jEnc($_d) as $_k_d => $_v_d){
        $_medio[] = "{ name:\"".$_v_d->nm."\", data:[".implode(',', $_v_d->tot)."] } ";
    }

    $_grph_d = implode(",", $_medio);
    $_grph_c = implode(",", $__ctg);

    echo bdiv([ 'id'=>'bx_grph_org_clg_2', 'sty'=>'height:300px; max-height:300px;' ]);

    $CntWb .= "

    __g_1({ 
        id: '#bx_grph_org_clg_2',
        c: [".$_grph_c."],
        d: [".$_grph_d."],
        tt: 'Matriculados', 
        tt_sb: 'por periodo',
        c_e: true
    });
        
    ";
?>