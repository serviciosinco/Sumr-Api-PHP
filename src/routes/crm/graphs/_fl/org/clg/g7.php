<?php 

    $__id = Php_Ls_Cln($_POST['id']);

    $__org_tp = __LsDt([ 'k'=>'org_tp' ]);
	foreach($__org_tp->ls->org_tp as $k => $v){
		if($v->key->vl == $__t2){
			$_tp_org = $v->id;
		}
    }

    $_dt_orgdsh = GtOrgDshDt([ 'cl'=>DB_CL_ID, 'tp'=>$_tp_org, 'id'=>$__id ]);

    $Ls_Cnt_Qry = " SELECT
                        COUNT(DISTINCT id_mdlcnt) as tot
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

                ";

    $Ls_Cnt_Rg = $__cnx->_qry($Ls_Cnt_Qry);

    if($Ls_Cnt_Rg){ 

        $row_Ls_Cnt_Rg = $Ls_Cnt_Rg->fetch_assoc(); 
        $Tot_Ls_Cnt_Rg = $Ls_Cnt_Rg->num_rows; 

        if($Tot_Ls_Cnt_Rg > 0){

            echo $row_Ls_Cnt_Rg['tot'];

        }
    }
?>