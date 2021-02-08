<?php 

    $__id = Php_Ls_Cln($_POST['id']);
    $c = Php_Ls_Cln($_POST['c']);

    $__org_tp = __LsDt([ 'k'=>'org_tp' ]);
	foreach($__org_tp->ls->org_tp as $k => $v){
		if($v->key->vl == $__t2){
			$_tp_org = $v->id;
		}
    }

    $_dt_orgdsh = GtOrgDshDt([ 'cl'=>DB_CL_ID, 'tp'=>$_tp_org, 'id'=>$__id ]);

    $Ls_Cnt_Qry = " SELECT
                        id_mdlsprd,
                        mdlsprd_nm,
                        mdlsprd_y,
                        (
                        SELECT
                            COUNT(DISTINCT id_mdlcnt) 
                        FROM
                            ".TB_MDL_CNT."		
                            INNER JOIN ".TB_MDL_CNT_PRD." ON mdlcntprd_mdlcnt = id_mdlcnt
                            INNER JOIN ".TB_MDL." ON mdlcnt_mdl = id_mdl
                            INNER JOIN "._BdStr(DBM).TB_MDL_S." ON mdl_mdls = id_mdls
                            INNER JOIN "._BdStr(DBM).TB_MDL_S_TP." ON mdls_tp = id_mdlstp 
                        WHERE
                            mdlcnt_est = ".$_dt_orgdsh->dt->vl."
                            AND mdlstp_tp = '".$__t3."'
                            AND mdlcntprd_est = 1 
                            AND mdlcntprd_mdlsprd = id_mdlsprd
                        ) AS prd_ins,
                        (SELECT siscntest_tt FROM "._BdStr(DBM).TB_SIS_CNT_EST." WHERE id_siscntest = ".$_dt_orgdsh->dt->vl.") as tt
                    FROM
                        "._BdStr(DBM).TB_MDL_S_PRD."
                        INNER JOIN "._BdStr(DBM).TB_MDL_S_PRD_TP." ON mdlsprdtp_prd = id_mdlsprd
                        INNER JOIN "._BdStr(DBM).TB_MDL_S_TP." AS e ON mdlsprdtp_tp = e.id_mdlstp 
                    WHERE
                        mdlsprd_cl = (SELECT id_cl FROM "._BdStr(DBM).TB_CL." WHERE cl_enc = '".CL_ENC."') 
                        AND e.mdlstp_tp = '".$__t3."' 
                    HAVING
                        mdlsprd_y > 2018 
                    ORDER BY
                        mdlsprd_y,
                        mdlsprd_nm
                ";

    $Ls_Cnt_Rg = $__cnx->_qry($Ls_Cnt_Qry);

    if($Ls_Cnt_Rg){ 

        $row_Ls_Cnt_Rg = $Ls_Cnt_Rg->fetch_assoc(); 
        $Tot_Ls_Cnt_Rg = $Ls_Cnt_Rg->num_rows; 

        if($Tot_Ls_Cnt_Rg > 0){

            do {
                $Vl_2['tt'] = $row_Ls_Cnt_Rg['tt'];
                $Vl_2['ctg'][$row_Ls_Cnt_Rg['id_mdlsprd']] = $row_Ls_Cnt_Rg['mdlsprd_nm'];
                $Vl_2['d']['m_a']['nm'] = $row_Ls_Cnt_Rg['mdlsprd_nm'];
                $Vl_2['d']['m_a'][$row_Ls_Cnt_Rg['id_mdlsprd']]['tot'] = number_format($row_Ls_Cnt_Rg['prd_ins'], 0, '.', '');

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

    $CntWb .= "
        SUMR_Grph.f.g1({ 
            id: '#".$c."',
            c: [".$_grph_c."],
            d: [".$_grph_d."],
            tt: '".$Vl_Grph_2->tt."', 
            tt_sb: 'Estado por periodo',
            c_e: true
        });        
    ";
?>