<?php

    //--------------------- Dates ---------------------//

        $rsp['e'] = 'ok';
        $__dt_1 = date('Y-m-01');
        $__dt_2 = date('Y-m-d');

    //--------------------- Sales ---------------------//

        $_sles = $___Ls->qta([ 'q'=>"   SELECT SUM( vtexord_tot ) AS _tot, DATE_FORMAT(vtexord_date_creation, '%Y-%m-%d') as f_i
                                        FROM "._BdStr(DBT).VW_VTEX_ORD_TOT."
                                        WHERE   cl_enc = '".CL_ENC."' AND
                                                DATE_FORMAT(vtexord_date_creation, '%Y-%m-%d') BETWEEN '".$__dt_1."' AND '".$__dt_2."' AND
                                                vtexord_status = 'invoiced'
                                        GROUP BY DATE_FORMAT(vtexord_date_creation, '%Y-%m-%d')
                                        ORDER BY vtexord_date_creation DESC
                                    "
                            ]);

    //--------------------- Process Sales Data ---------------------//

        if(!isN($_sles->ls)){

            foreach($_sles->ls as $_sles_k=>$_sles_v){
                $sle_day[ $_sles_v->f_i ] = $_sles_v->_tot;
            }

            for($i=$__dt_1;$i<=$__dt_2;$i = date("Y-m-d", strtotime($i ."+ 1 days"))){
                $_a_day_grph_c[] = $i;
                $_a_day_grph_d[] = (!isN($_a_day_grph->d->{$i}->tot)?$_a_day_grph->d->{$i}->tot:'0');

                $rsp['data']['sles']['c'][] = $i;
                $rsp['data']['sles']['d'][] = !isN($sle_day[$i])?(int)$sle_day[$i]:0;
            }
        }

    //--------------------- Campaigns ---------------------//

        $_cmpg = $___Ls->qta([ 'q'=>"   SELECT id_vtexcmpg, vtexcmpg_enc, vtexcmpg_nm
                                        FROM "._BdStr(DBT).TB_VTEX_CMPG."
                                                INNER JOIN  "._BdStr(DBT).TB_VTEX." ON vtexcmpg_vtex = id_vtex
                                                INNER JOIN  "._BdStr(DBM).TB_CL." ON vtex_cl = id_cl
                                        WHERE  id_vtexcmpg != '' AND cl_enc = '".CL_ENC."'
                                        ORDER BY id_vtexcmpg ASC "
                            ]);

    //--------------------- Process Campaigns Data ---------------------//

        if(!isN($_cmpg->ls)){
            foreach($_cmpg->ls as $_cmpg_k=>$_cmpg_v){
                $rsp['data']['cmpg']['ls'][] = [
                    'id'=>$_cmpg_v->id_vtexcmpg,
                    'enc'=>$_cmpg_v->vtexcmpg_enc,
                    'nm'=>ctjTx($_cmpg_v->vtexcmpg_nm,'in')
                ];
            }
        }

    //--------------------- Orders ---------------------//

        $_ord = $___Ls->qta([ 'q'=>"   SELECT id_vtexord, vtexord_enc, vtexord_cid, vtexord_cnt, vtexord_date_creation, vtexord_status
                                        FROM "._BdStr(DBT).VW_VTEX_ORD."
                                        WHERE cl_enc = '".CL_ENC."'
                                        ORDER BY vtexord_date_creation DESC
                                        LIMIT 20
                                    "
                            ]);

    //--------------------- Process Orders Data ---------------------//

        if(!isN($_ord->ls)){
            foreach($_ord->ls as $_ord_k=>$_ord_v){

                $_cnt = json_decode(ctjTx($_ord_v->vtexord_cnt,'in'));

                $rsp['data']['ord']['ls'][] = [
                    'id'=>$_ord_v->id_vtexord,
                    'enc'=>$_ord_v->vtexord_enc,
                    'cid'=>$_ord_v->vtexord_cid,
                    'nm'=>$_cnt->firstName.' '.$_cnt->lastName,
                    'f'=>$_ord_v->vtexord_date_creation,
                    'est'=>ctjTx($_ord_v->vtexord_status,'in')
                ];

            }
        }

    //--------------------- Orders - No Pay ---------------------//

    $_nopay = $___Ls->qta([ 'q'=>"  SELECT id_vtexord, vtexord_enc, vtexord_cid, vtexord_cnt, vtexord_date_creation, vtexord_status
                                    FROM "._BdStr(DBT).VW_VTEX_ORD."
                                    WHERE cl_enc = '".CL_ENC."' AND
                                          DATE_FORMAT(vtexord_date_creation, '%Y-%m-%d') BETWEEN '".date("Y-m-d", strtotime($i ."- 30 days"))."' AND '".$__dt_2."' AND
                                          vtexord_status = 'payment-pending'
                                    ORDER BY vtexord_date_creation DESC
                                    LIMIT 20
                                "
                        ]);  $rsp['data']['q2'] = compress_code( "  SELECT id_vtexord, vtexord_enc, vtexord_cid, vtexord_cnt, vtexord_date_creation, vtexord_status
                        FROM "._BdStr(DBT).VW_VTEX_ORD."
                        WHERE cl_enc = '".CL_ENC."' AND
                              DATE_FORMAT(vtexord_date_creation, '%Y-%m-%d') BETWEEN '".date("Y-m-d", strtotime($i ."- 30 days"))."' AND '".$__dt_2."' AND
                              vtexord_status = 'payment-pending'
                        ORDER BY vtexord_date_creation DESC
                        LIMIT 20
                    " );

    //--------------------- Process Orders - No Pay Data ---------------------//

    if(!isN($_nopay->ls)){

        foreach($_nopay->ls as $_nopay_k=>$_nopay_v){

            $_cnt = json_decode(ctjTx($_ord_v->vtexord_cnt,'in'));

            $rsp['data']['nopay']['ls'][] = [
                'id'=>$_nopay_v->id_vtexord,
                'enc'=>$_nopay_v->vtexord_enc,
                'cid'=>$_nopay_v->vtexord_cid,
                'nm'=>$_cnt->firstName.' '.$_cnt->lastName,
                'f'=>$_nopay_v->vtexord_date_creation,
                'est'=>ctjTx($_nopay_v->vtexord_status,'in')
            ];

        }

    }


?>