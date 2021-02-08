<?php

$_g_alw = $this->tallw([ 't'=>'key', 'id'=>'tot_mntr' ]);

if( $_g_alw->est == 'ok' ){

    try{

        if(class_exists('CRM_Cnx')){

            echo $this->h1('Totals to Show on Monitor Status');

            $ec_prc_aprb = GtEcEstLs([ 'est'=>_CId('ID_SISEST_PAPRB') ])->tot; // Pushmail en Aprobacion

            $cmpg_cla = GtCmpgClaLs()->tot; // Campañas en Cola
            $cmpg_cla_tot = $cmpg_cla->tot;
            $cmpg_cla_tots = $cmpg_cla->tots;

			$cds_vrf = GtCdVrfLs()->tot; // Ciudades por verificar
            $sis_err = GtSisErr()->tot; // Sistema de errores

           $emls_wrg = GtCntEmlEst();
            $emls_wrg_bad_w = $emls_wrg->bad_w; // Correos mal escritos
            $emls_wrg_no_chck = $emls_wrg->no_chck; // Correos en verificacion

            $org_vrf = GtOrgVrfLs()->tot; // Organizaciones por verificar

            $ec_snd_cmpg = GtEcSndCmpgLs(); // Campañas enviando
            $ec_snd_cmpg_tot = $ec_snd_cmpg->tot; // Campañas enviando
            $ec_snd_cmpg_tots = $ec_snd_cmpg->tots; // Campañas enviando

            $ec_snd_pnd = GtEcCmpgPndLs()->tot;

            $dwn_est = GtDwnEstLs()->tot;

            $lead_ads = GtLeadAd();
            $lead_ads_dia = $lead_ads->tot;
            $lead_ads_mes = $lead_ads->tots;

            $scl_rcl = GtSclRcl();
            $scl_rcl_mdl = $scl_rcl->mdl;
            $scl_rcl_plcy = $scl_rcl->plcy;

            /*$api_rqu = GtApiRqu();
            $api_rqu_1 = $api_rqu->act1->d1;
            $api_rqu_2 = $api_rqu->act1->d2;
            $api_rqu_c = $api_rqu->act1->c;
            $api_rqu_d1 = $api_rqu->act1->d_1;
            $api_rqu_d2 = $api_rqu->act1->d_2;*/

            $_Tot_All[] = [ "key"=>"dsh_ec_prc_aprb", "vl"=>$ec_prc_aprb ];

            $_Tot_All[] = [ "key"=>"dsh_cmpg_cla_tot", "vl"=>$cmpg_cla_tot ];
            $_Tot_All[] = [ "key"=>"dsh_cmpg_cla_tots", "vl"=>$cmpg_cla_tots ];

            $_Tot_All[] = [ "key"=>"dsh_cds_vrf", "vl"=>$cds_vrf ];
            $_Tot_All[] = [ "key"=>"dsh_sis_err", "vl"=>$sis_err ];

            $_Tot_All[] = [ "key"=>"dsh_emls_wrg_bad_w", "vl"=>$emls_wrg_bad_w ];
            $_Tot_All[] = [ "key"=>"dsh_emls_wrg_no_chck", "vl"=>$emls_wrg_no_chck ];

            $_Tot_All[] = [ "key"=>"dsh_org_vrf", "vl"=>$org_vrf ];

            $_Tot_All[] = [ "key"=>"dsh_ec_snd_cmpg_tot", "vl"=>$ec_snd_cmpg_tot ];
            $_Tot_All[] = [ "key"=>"dsh_ec_snd_cmpg_tots", "vl"=>$ec_snd_cmpg_tots ];

            $_Tot_All[] = [ "key"=>"dsh_ec_snd_pnd", "vl"=>$ec_snd_pnd ];

            $_Tot_All[] = [ "key"=>"dsh_dwn_est", "vl"=>$dwn_est ];

            $_Tot_All[] = [ "key"=>"dsh_lead_ads_dia", "vl"=>$lead_ads_dia ];
            $_Tot_All[] = [ "key"=>"dsh_lead_ads_mes", "vl"=>$lead_ads_mes ];

            $_Tot_All[] = [ "key"=>"dsh_scl_rcl_mdl", "vl"=>$scl_rcl_mdl ];
            $_Tot_All[] = [ "key"=>"dsh_scl_rcl_plcy", "vl"=>$scl_rcl_plcy ];

            $_Tot_All[] = [ "key"=>"dsh_api_1", "vl"=>json_encode($api_rqu_1) ];
            $_Tot_All[] = [ "key"=>"dsh_api_2", "vl"=>json_encode($api_rqu_2) ];
            $_Tot_All[] = [ "key"=>"dsh_api_c", "vl"=>json_encode($api_rqu_c) ];
            $_Tot_All[] = [ "key"=>"dsh_api_d_1", "vl"=>$api_rqu_d1 ];
            $_Tot_All[] = [ "key"=>"dsh_api_d_2", "vl"=>$api_rqu_d2 ];

            foreach( $_Tot_All as $_k => $_v ){

                if( !isN($_v["vl"]) ){
                    $updateSQL = sprintf(" UPDATE "._BdStr(DBP).TB_TOT." SET tot_vl=%s WHERE tot_key=%s ",
                        GtSQLVlStr(ctjTx($_v["vl"], 'out'), "text"),
                        GtSQLVlStr(ctjTx($_v["key"], 'out'), "text")
                    );

                    $Result = $__cnx->_prc($updateSQL);
                }
            }
        }

    }catch(Exception $e){
        echo h2("Error en trycatch ".$e->getMessage());
    }

}else{

	echo $this->nallw('Global Monitor Totals - Off');

}

?>