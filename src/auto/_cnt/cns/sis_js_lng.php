<?php

$__sis_tt = dirname(__FILE__, 4).'/includes/system/_tt_all.php';

if(file_exists($__sis_tt)){

    $_auto = new API_CRM_Auto([ 'argv'=>$__argv ]);

    include_once($__sis_tt);

    if(class_exists('CRM_Cnx')){

        $___lng = GtLngLs();

        foreach($___lng->ls as $_lng_k=>$_lng_v){

            $__cde = '';

            $__cde .= "

                SUMR_Ld.t = {

                    new_version:'".G_TX_ADV_NWV[ $_lng_v->cod ]."',
                    new_version_p:'Haz clic aquí para acceder a ella.',

                    offline:'Tenemos un problema con tu conexión',
                    welcome:'".G_TX_BMVND[ $_lng_v->cod ]."',
                    goodjob:'".G_TX_MBN[ $_lng_v->cod ]."',
                    continue:'".G_TX_CNTNR[ $_lng_v->cod ]."',
                    slow:'Tu conexión es muy lenta, puede tomar mas tiempo de lo normal cada solicitud',
                    noback:'Función deshabilitada, intente usar la interface de la aplicación',

                    alrt_tt:'".G_TX_ETSGR[ $_lng_v->cod ]."',
                    alrt_scces:'Creado exitosamente',

                    alrt_hston:'".G_TX_PROBLHST[ $_lng_v->cod ]."',
                    alrt_hston_agn:'Intenta de nuevo',
                    alrt_hston_tmeout:'Puede haber problemas de velocidad en tu conexión, intenta realizar la solicitud de nuevo.',


                    alrt_noie:'".G_TX_PROBLYCNX[ $_lng_v->cod ]."',
                    alrt_noie_dsc:'No tienes una conexión activa a internet, intenta nuevamente cuando todo este ok.',

                    alrt_tmout:'Excede tiempo de carga',
                    alrt_sndscces:'Enviado exitosamente',

                    alrt_cnfr:'".G_TX_CFRMCN[ $_lng_v->cod ]."',
                    alrt_sve:'".G_TX_SWAL_SVE[ $_lng_v->cod ]."',

                    alrt_dterr:'".G_TX_DTERRO[ $_lng_v->cod ]."',

                    alrt_err:'".G_TX_ERROR[ $_lng_v->cod ]."',
                    alrt_bjsn:'".G_TX_PRBLCNST[ $_lng_v->cod ]."',


                    nty_chat_nwmsg:'".G_TX_MSNNW[ $_lng_v->cod ]."',
                    nty_chat_nwmsg_dsc:'Has recibido un nuevo mensaje a través de nuestro chat',

                    pnl_cnfclse:'".G_TX_ETSGR[ $_lng_v->cod ]."',
                    pnl_cnfclse_dsc:'El panel se cerrará sin aplicar ningun filtro',
                    btn_ok:'".G_TX_YESNOPRBLM[ $_lng_v->cod ]."',
                    btn_sve:'".G_TXBT_GRDR[ $_lng_v->cod ]."',
                    btn_eli:'".G_TX_ELMNR[ $_lng_v->cod ]."',

                    pltfdsll:'".G_TX_PLTFDSLL[ $_lng_v->cod ]."',

                    loader:{
                        main:{
                            tt:'".G_TX_LDING[ $_lng_v->cod ]."',
                            sbt:'".G_TX_CNTND[ $_lng_v->cod ]."'
                        }
                    },

                    dsh:{
                        col_cstm:'".G_TX_PRSLCLM[ $_lng_v->cod ]."',
                        col_sum:'".G_TX_SMCLMS[ $_lng_v->cod ]."',
                    },
                    bck:'".G_TX_BCKG[ $_lng_v->cod ]."',
                    clr:'".G_TX_CLR[ $_lng_v->cod ]."',
                    clr_tt:'".G_TX_NM_CL[ $_lng_v->cod ]."',

                    grph:{
                        sgp:'".G_TX_SLCGRF[ $_lng_v->cod ]."',
                        sdm:'".G_TX_SLCDMS[ $_lng_v->cod ]."',
                        smt:'".G_TX_SLCMTRC[ $_lng_v->cod ]."'
                    },

                    prsnlzd:'".G_TX_PRSNLD[ $_lng_v->cod ]."',
                    row:{
                        add:'".G_TX_AGRFL[ $_lng_v->cod ]."'
                    },
                    img:{
                        cutscc:'".G_TX_FTCRTD[ $_lng_v->cod ]."',
                        cutslc:'".G_TX_SLCAR[ $_lng_v->cod ]."'
                    },
                    qts:".json_encode( GtQtsAll() ).",
                    tra:{
                        mdlmsj:'".G_TX_MSJS[ $_lng_v->cod ]."',
                        mdlest:'".G_TX_ESTS[ $_lng_v->cod ]."',
                        mdlmd:'".G_TX_MD[ $_lng_v->cod ]."',
                        mdl:'".G_TX_CNTINTRS[ $_lng_v->cod ]."',
                        call:'".G_TX_LLMDS[ $_lng_v->cod ]."',
                        ec:'".G_TX_PSHML[ $_lng_v->cod ]."',
                        tra:'".G_TX_TRAS[ $_lng_v->cod ]."',
                        vst:'".G_TX_VST[ $_lng_v->cod ]."',
                        ck:'".G_TX_PGWEB[ $_lng_v->cod ]."',
                        emp:'".G_TX_EMPS[ $_lng_v->cod ]."',
                        addeml:'".G_TX_EMAIL[ $_lng_v->cod ]."',
                        adddc:'".G_TX_DOCS[ $_lng_v->cod ]."',
                        addtel:'".G_TX_TLFN[ $_lng_v->cod ]."',
                        traest:'".G_TX_EST_TRA[ $_lng_v->cod ]."',
                        tracmnt:'".G_TX_CMNT_TRA[ $_lng_v->cod ]."',
                        trahis:'".G_TX_HIS_TRA[ $_lng_v->cod ]."',
                        tractrl:'".G_TX_CTRL_TRA[ $_lng_v->cod ]."'
                    }
                };

            ";

            if(SUMR_ENV == 'prd'){ $_cfr='ok'; }else{ $_cfr='no'; }
            $result_sve = $_auto->_aws->_s3_put([ 'b'=>'js', 'fle'=>'_lng/'.$_lng_v->cod.'.js', 'cbdy'=>cmpr_js($__cde), 'ctp'=>'text/javascript', 'cfr'=>$_cfr, 'utf8'=>'ok' ]);

        }

    }

}else{

    echo $this->err('No include text constant files');

}


?>