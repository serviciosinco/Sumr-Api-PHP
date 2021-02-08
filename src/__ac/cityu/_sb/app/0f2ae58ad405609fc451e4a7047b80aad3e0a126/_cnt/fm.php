<?php

    $__id_bx = 'FmBx'.$__id_rnd;
    $__id_fm = 'FmApp'.$__id_rnd;
    $__id_fm_btn = 'FmAppBtn'.$__id_rnd;

    if($appdt->e == 'ok'){

        if(!isN($__l)){ $_lng = $__l; }else{ $_lng='es'; }

        if($__pm_3 == 'dashboard' && ChckSESS_cnt()){

            $__logged='ok';

            function OrgSds_Sls_ByMonth($p=NULL){

                global $__cnx;

                $LsQry = "
                    SELECT SUM(orgsdsarrsls_vl) as _t_sls,
                        DATE_FORMAT(orgsdsarrsls_f, '%Y-%m') as _f_i
                    FROM "._BdStr(DBM).TB_ORG_SDS_ARR_SLS."
                        INNER JOIN "._BdStr(DBM).TB_ORG_SDS_ARR." ON orgsdsarrsls_arr = id_orgsdsarr
                        INNER JOIN "._BdStr(DBM).TB_ORG_SDS." ON orgsdsarr_orgsds = id_orgsds
                        INNER JOIN "._BdStr(DBM).TB_ORG." ON orgsds_org = id_org
                    WHERE org_enc = '".$_GET['i']."' GROUP BY _f_i
                ";

                $LsRg = $__cnx->_qry($LsQry);



                if($LsRg){

                    $rwLsRg = $LsRg->fetch_assoc();
                    $TotLsRg = $LsRg->num_rows;

                    if($TotLsRg > 0){

                        do {
                            $Vl['ctg'][$rwLsRg['_f_i']] = $rwLsRg['_f_i'];
						    $Vl['d']['m_a']['nm'] = 'Total';
						    $Vl['d']['m_a']['f'][$rwLsRg['_f_i']]['tot'] = $rwLsRg['_t_sls'];
                        } while ($rwLsRg = $LsRg->fetch_assoc());

                        $Vl_Grph = _jEnc($Vl);

                        foreach($Vl_Grph->ctg as $k => $v){

                            $_r['c'][] = '"'.FechaESP_OLD($v, 10).'"';

                            foreach($Vl_Grph->d as $_k => $_v){
                                $_r['v'][] = ( !isN($_v->f->{$k}->tot) ) ? $_v->f->{$k}->tot : 0 ;
                            }

                        }

                    }

                }else{

                    echo $__cnx->c_r->error;

                }

                return _jEnc($_r);
            }

            function OrgSds_Sls_ByDay($p=NULL){

                global $__cnx;

                $__dt_1 = date('Y-m-01');
			    $__dt_2 = date ( 'Y-m-d' , strtotime ( '- 1 days' , strtotime ( date('Y-m-d') ) ) );

                $LsQry = "
                    SELECT orgsdsarrsls_vl,
                        DATE_FORMAT(orgsdsarrsls_f, '%Y-%m-%d') as _f_i
                    FROM "._BdStr(DBM).TB_ORG_SDS_ARR_SLS."
                        INNER JOIN "._BdStr(DBM).TB_ORG_SDS_ARR." ON orgsdsarrsls_arr = id_orgsdsarr
                        INNER JOIN "._BdStr(DBM).TB_ORG_SDS." ON orgsdsarr_orgsds = id_orgsds
                        INNER JOIN "._BdStr(DBM).TB_ORG." ON orgsds_org = id_org
                    WHERE org_enc = '".$_GET['i']."' AND
                            DATE_FORMAT(orgsdsarrsls_f, '%Y-%m-%d') BETWEEN '".$__dt_1."' AND '".$__dt_2."'
                ";



                $LsRg = $__cnx->_qry($LsQry);

                if($LsRg){

                    $rwLsRg = $LsRg->fetch_assoc();
                    $TotLsRg = $LsRg->num_rows;



                        do {
                            $__v[$rwLsRg['_f_i']]['tot'] = $rwLsRg['orgsdsarrsls_vl'];
                        } while ($rwLsRg = $LsRg->fetch_assoc());

                        for($i=$__dt_1;$i<=$__dt_2;$i = date("Y-m-d", strtotime($i ."+ 1 days"))){
                            $__fkey = date("Y-m-d", strtotime($i) );
                            $_r['c'][] = '"'.$__fkey.'"';
                            $_r['v'][] = !isN($__v[$__fkey]['tot'])?$__v[$__fkey]['tot']:'0';
                        }

                }else{
                    echo $__cnx->c_r->error;
                }

                return _jEnc($_r);
            }

            function OrgSds_Sls_ByYear($p=NULL){

                global $__cnx;

                $LsQry = "
                    SELECT
                        DATE_FORMAT( orgsdsarrsls_f, '%Y' ) AS anio,
                        DATE_FORMAT( orgsdsarrsls_f, '%m' ) AS mes,
                        DATE_FORMAT( orgsdsarrsls_f, '%Y-%m' ) AS all_f,
                        SUM( orgsdsarrsls_vl ) AS tot
                    FROM "._BdStr(DBM).TB_ORG_SDS_ARR_SLS."
                        INNER JOIN "._BdStr(DBM).TB_ORG_SDS_ARR." ON orgsdsarrsls_arr = id_orgsdsarr
                        INNER JOIN "._BdStr(DBM).TB_ORG_SDS." ON orgsdsarr_orgsds = id_orgsds
                        INNER JOIN "._BdStr(DBM).TB_ORG." ON orgsds_org = id_org
                    WHERE org_enc = '".$_GET['i']."' GROUP BY DATE_FORMAT(orgsdsarrsls_f, '%Y-%m') ORDER BY mes ASC, anio DESC
                ";

                $LsRg = $__cnx->_qry($LsQry);

                if($LsRg){

                    $rwLsRg = $LsRg->fetch_assoc();
                    $TotLsRg = $LsRg->num_rows;

                    if($TotLsRg > 0){

                        do {
                            $Vl['ctg'][$rwLsRg['mes']]['mes'] = $rwLsRg['mes'];
                            $Vl['ctg'][$rwLsRg['mes']]['all_f'] = $rwLsRg['all_f'];

                            $Vl['d'][$rwLsRg['anio']]['nm'] = ctjTx($rwLsRg['anio'], 'in');
                            $Vl['d'][$rwLsRg['anio']]['f'][$rwLsRg['mes']]['tot'] = $rwLsRg['tot'];
                        } while ($rwLsRg = $LsRg->fetch_assoc());

                        $Vl_Grph = _jEnc($Vl);

                        foreach($Vl_Grph->ctg as $k => $v){
                            $_r['c'][] = '"'.FechaESP_OLD($v->all_f, 2).'"';

                            foreach($Vl_Grph->d as $_k => $_v){
                                $_d[$_k]['nm'] = $_v->nm;
                                $_d[$_k]['tot'][] = ( !isN($_v->f->{$k}->tot) ) ? $_v->f->{$k}->tot : 0 ;
                            }

                        }

                        foreach(_jEnc($_d) as $_k_d => $_v_d){
                            $_r['v'][] = "{ name:\"".$_v_d->nm."\", data:[".implode(',', $_v_d->tot)."] } ";
                        }
                    }
                }else{
                    echo $__cnx->c_r->error;
                }

                return _jEnc($_r);
            }

            function OrgSds_Sls_ByTrs($p=NULL){

                global $__cnx;

                $__dt_1 = date('Y-m-01');
			    $__dt_2 = date ( 'Y-m-d' , strtotime ( '- 1 days' , strtotime ( date('Y-m-d') ) ) );

                $LsQry = "
                    SELECT orgsdsarrsls_trs,
                        DATE_FORMAT(orgsdsarrsls_f, '%Y-%m-%d') as _f_i
                    FROM "._BdStr(DBM).TB_ORG_SDS_ARR_SLS."
                        INNER JOIN "._BdStr(DBM).TB_ORG_SDS_ARR." ON orgsdsarrsls_arr = id_orgsdsarr
                        INNER JOIN "._BdStr(DBM).TB_ORG_SDS." ON orgsdsarr_orgsds = id_orgsds
                        INNER JOIN "._BdStr(DBM).TB_ORG." ON orgsds_org = id_org
                    WHERE org_enc = '".$_GET['i']."' AND
                            DATE_FORMAT(orgsdsarrsls_f, '%Y-%m-%d') BETWEEN '".$__dt_1."' AND '".$__dt_2."'
                ";

                $LsRg = $__cnx->_qry($LsQry);

                if($LsRg){

                    $rwLsRg = $LsRg->fetch_assoc();
                    $TotLsRg = $LsRg->num_rows;



                        do {
                            $__v[$rwLsRg['_f_i']]['tot'] = $rwLsRg['orgsdsarrsls_trs'];
                        } while ($rwLsRg = $LsRg->fetch_assoc());

                        for($i=$__dt_1;$i<=$__dt_2;$i = date("Y-m-d", strtotime($i ."+ 1 days"))){
                            $__fkey = date("Y-m-d", strtotime($i) );
                            $_r['c'][] = '"'.$__fkey.'"';
                            $_r['v'][] = !isN($__v[$__fkey]['tot'])?$__v[$__fkey]['tot']:'0';
                        }

                }else{
                    echo $__cnx->c_r->error;
                }

                return _jEnc($_r);
            }

            function OrgSds_Sls_ByTck($p=NULL){

                global $__cnx;

                $__dt_1 = date('Y-m-01');
			    $__dt_2 = date ( 'Y-m-d' , strtotime ( '- 1 days' , strtotime ( date('Y-m-d') ) ) );

                $LsQry = "
                    SELECT orgsdsarrsls_vl, orgsdsarrsls_trs,
                        DATE_FORMAT(orgsdsarrsls_f, '%Y-%m-%d') as _f_i
                    FROM "._BdStr(DBM).TB_ORG_SDS_ARR_SLS."
                        INNER JOIN "._BdStr(DBM).TB_ORG_SDS_ARR." ON orgsdsarrsls_arr = id_orgsdsarr
                        INNER JOIN "._BdStr(DBM).TB_ORG_SDS." ON orgsdsarr_orgsds = id_orgsds
                        INNER JOIN "._BdStr(DBM).TB_ORG." ON orgsds_org = id_org
                    WHERE org_enc = '".$_GET['i']."' AND
                            DATE_FORMAT(orgsdsarrsls_f, '%Y-%m-%d') BETWEEN '".$__dt_1."' AND '".$__dt_2."'
                ";

                $LsRg = $__cnx->_qry($LsQry);

                if($LsRg){

                    $rwLsRg = $LsRg->fetch_assoc();
                    $TotLsRg = $LsRg->num_rows;



                        do {
                            $_vl = $rwLsRg['orgsdsarrsls_vl'];
                            $_trs = $rwLsRg['orgsdsarrsls_trs'];

                            $__v[$rwLsRg['_f_i']]['tot'] = number_format( $_vl/$_trs, 0, ",", ".") ;
                        } while ($rwLsRg = $LsRg->fetch_assoc());

                        for($i=$__dt_1;$i<=$__dt_2;$i = date("Y-m-d", strtotime($i ."+ 1 days"))){
                            $__fkey = date("Y-m-d", strtotime($i) );
                            $_r['c'][] = '"'.$__fkey.'"';
                            $_r['v'][] = !isN($__v[$__fkey]['tot'])?$__v[$__fkey]['tot']:'0';
                        }

                }else{
                    echo $__cnx->c_r->error;
                }

                return _jEnc($_r);
            }

            function OrgSds_SlsBst_Tot($p=NULL){

                if(!isN($p)){

                    if($p['dte']=='ok'){
                        $__sqld_f = '%Y';
                        $__sqld_f_q = 'Y';
                        $__sqld_dte = ' orgsdsarrsls_f AS _f_sle ';
                        $__sqld_tot = ' orgsdsarrsls_vl AS _t_sls ';
                        $__sqld_orby = 'orgsdsarrsls_vl';
                    }elseif($p['day']=='ok'){
                        $__sqld_f = '%Y-%m';
                        $__sqld_f_q = 'Y-m';
                        $__sqld_dte = ' orgsdsarrsls_f AS _f_sle ';
                        $__sqld_tot = ' orgsdsarrsls_vl AS _t_sls ';
                        $__sqld_orby = '_t_sls';
                    }elseif($p['mth']=='ok'){
                        $__sqld_f = '%Y';
                        $__sqld_f_q = 'Y';
                        $__sqld_dte = ' DATE_FORMAT(orgsdsarrsls_f, "%Y-%m") AS _f_sle ';
                        $__sqld_tot = ' SUM(orgsdsarrsls_vl) AS _t_sls ';
                        $__sqld_orby = '_t_sls';
                    }

                    global $__cnx;

                    $LsQry = "  SELECT ".$__sqld_tot.",
                                        ".$__sqld_dte."
                                FROM "._BdStr(DBM).TB_ORG_SDS_ARR_SLS."
                                    INNER JOIN "._BdStr(DBM).TB_ORG_SDS_ARR." ON orgsdsarrsls_arr = id_orgsdsarr
                                    INNER JOIN "._BdStr(DBM).TB_ORG_SDS." ON orgsdsarr_orgsds = id_orgsds
                                    INNER JOIN "._BdStr(DBM).TB_ORG." ON orgsds_org = id_org
                                WHERE org_enc = '".$_GET['i']."' AND DATE_FORMAT(orgsdsarrsls_f, '".$__sqld_f."') = '".date($__sqld_f_q)."'
                                GROUP BY _f_sle
                                ORDER BY ".$__sqld_orby." DESC
                                LIMIT 1
                            ";

                    if($p['day']=='ok'){
                        //echo compress_code( $LsQry );
                    }

                    $DtRg = $__cnx->_qry($LsQry);

                    if($DtRg){

                        $rwDtRg = $DtRg->fetch_assoc();
                        $TotDtRg = $DtRg->num_rows;

                        if($TotDtRg > 0){
                            $_r['f']['v'] = $rwDtRg['_f_sle'];
                            $_r['f']['d'] = FechaESP_OLD($rwDtRg['_f_sle'], 's');
                            $_r['v'] = $rwDtRg['_t_sls'];
                        }
                    }else{
                        echo $__cnx->c_r->error;
                    }

                }

                return _jEnc($_r);
            }

            $__sbmt_b = OrgSds_Sls_ByMonth();
            $__sbmt_n = OrgSds_Sls_ByDay();
            $__sbmt_y = OrgSds_Sls_ByYear();
            $__sbmt_t = OrgSds_Sls_ByTrs();
            $__sbmt_tck = OrgSds_Sls_ByTck();

            $__tot_dte = OrgSds_SlsBst_Tot([ 'dte'=>'ok' ]);
            $__tot_day = OrgSds_SlsBst_Tot([ 'day'=>'ok' ]);
            $__tot_mth = OrgSds_SlsBst_Tot([ 'mth'=>'ok' ]);

        }

        $_dt = GtOrgDt([ 'i'=>$_GET['i'],'t' => 'enc' ]);

?>
<!DOCTYPE HTML>
<html lang="<?php echo $_lng; ?>">
	<head>
		<title><?php echo 'APP | '.$__dt_cl->nm; ?></title>
		<base href="<?php echo DMN_APP.$__pm_1; ?>/" target="_self">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<meta name="apple-mobile-web-app-status-bar-style" content="black">
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="mobile-web-app-capable" content="yes">
		<link rel="icon" href="img/touch-icon-iphone.png" type="image/x-icon" />
		<link rel="apple-touch-icon-precomposed" href="<?php echo $__dt_cl->img->th_400 ?>"/>
		<link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php echo $__dt_cl->img->th_100 ?>"/>
		<link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?php echo $__dt_cl->img->th_200 ?>"/>
		<link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?php echo $__dt_cl->img->th_200 ?>"/>
		<link rel="shortcut icon" href="<?php echo $__dt_cl->lgo->ico->big; ?>" type="image/x-icon"/>
		<link rel="manifest" href="/manifest.json">
		<style>


			*{ box-sizing: border-box; outline: none; background-repeat: no-repeat; background-position: center center; font-weight: 300; }
            body{ padding: 0; margin: 0; font-family: Tahoma, Verdana, Arial, Helvetica, sans-serif;  }

            body:not(.on) header,
            body:not(.on) footer,
            body:not(.on) .app-main{ display: none; }

            body ._prld{ z-index: 99999999; position: absolute; width: 100%; height: 100%; left: 0; top: 0; background-size: 50px auto; }
            body ._prld{ background-image: url('<?php echo DMN_APP; ?>img/estr/loader_white.svg'); }


            body.on ._prld{ display: none; }
            body.on .app-main,
            body.on header,
            body.on footer{ display: block; }

            .lgt {position: relative;cursor:pointer;opacity:0.7;}
            .lgt:hover {opacity:1;}
            .lgt::before {content: "";background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>app_out.svg);position: absolute;right: 70px;top: 2px;width: 15px;opacity: .5;cursor: pointer;height: 15px;background-size: 100% auto;background-position: center center;z-index: 999999;}

            body._logged .sld_brnd .logo{     width: 70px !important; }
            .user_mrks{ display: inline-block;vertical-align: top;color: #7d7d7d;font-size: 13px;position: relative;top: 15px; }
            .user_mrks h1{ padding: 0;margin: 0; }

            @media (max-width: 700px) {

                .wrp{width: 100% !important;}
                body._logged .col_opt{display: block !important;height: auto !important;}
                body._logged .col_opt ._c{padding: 15px 0;margin-left: 0px !important;margin: 10px auto;width: 88% !important;display: inline-block;}
                body._logged .col_opt ._c .bx h3{margin: 15px 0 0 0 !important;}
                body._logged .col_opt ._c .bx span{margin-top: 15px !important;}
                body._logged .col_opt ._c .tools{padding: 0px 0 !important;;margin: 0px 0 0 0 !important;;}
                .app-main .dsh-main{margin-top: 50px !important;}

            }
			<?php

				$__cl_tag = $__dt_cl->tag;
				$__cl_clr = $__cl_tag->clr;

				if(!isN($__cl_clr->main->v)){ $__root_v .= ' --main-bg-color: '.$__cl_clr->main->v.'; '; }else{ $__root_v .= ' --main-bg-color:#4f006f;'; }
				if(!isN($__cl_clr->second->v)){ $__root_v .= ' --second-bg-color: '.$__cl_clr->second->v.'; '; }else{ $__root_v .= ' --second-bg-color:#de86d4; '; }

				echo '
					:root {
						'.$__root_v.'
					}
				';

	        ?>
		</style>
	</head>
	<body class="<?php if($__logged=='ok'){ echo '_logged'; } ?>">
		<div class="_bcki"></div>
		<header>
			<div class="wrp">
				<div class="lg _anm">
					<div class="lg_cl"></div>
				</div>
			</div>
		</header>

		<section class="app-main">

			<div class="wrp">

				<div class="app-cnt _anm" id="app-cnt">
					<div class="_ldr _anm"><div class="_spn"></div></div>
					<div class="_clse _anm"></div>
					<div class="_bxhtt _anm">
						<div class="_bxhtt_cnt"></div>
					</div>
				</div>

				<div class="dsh-main" id="dsh-main">

                    <?php if($__logged=='ok'){ ?>

                        <div class="sld_brnd">
                            <div class="user_mrks" style="">
                                <h1><?php echo $_SESSION['eml_mrks']; ?></h1>
                                <div class="lgt">cerrar sesion</div>
                            </div>
                            <div class="logo" style="background-image:url(<?php echo $_dt->img->th_400; ?>);"></div>
                        </div>

                        <div class="owl-carousel owl-theme">
                            <div class="item"><div class="sld_bnr" id="sales_this_day"></div></div>
                            <div class="item"><div class="sld_bnr" id="sales_this_month"></div></div>
                            <div class="item"><div class="sld_bnr" id="sales_this_year"></div></div>
                            <div class="item"><div class="sld_bnr" id="sales_this_tsr"></div></div>
                            <div class="item"><div class="sld_bnr" id="sales_this_tck"></div></div>
                        </div>

                        <div class="col_opt">

                            <div class="_c _c1">
                                <h2>Mejor Dia de Ventas <?php echo Spn( FechaESP_OLD( date('Y-m-01'), 2 ) ); ?></h2>
                                <div class="bx">
                                    <h3><?php echo $__tot_day->f->d->ds ?></h3>
                                    <h4><?php echo $__tot_day->f->d->d.' '.$__tot_day->f->d->m ?></h4>
                                    <span><?php echo _Nmb($__tot_day->v, 8) ?></span>
                                </div>
                            </div>
                            <div class="_c _c2">
                                <h2>Mejor Mes de Ventas <?php echo Spn( FechaESP_OLD( date('Y-m-01'), 3 ) ); ?></h2>
                                <div class="bx">
                                    <h3><?php echo $__tot_mth->f->d->m ?></h3>
                                    <h4><?php echo $__tot_mth->f->d->a ?></h4>
                                    <span><?php echo _Nmb($__tot_mth->v, 8) ?></span>
                                </div>
                            </div>
                            <div class="_c _c3">
                                <h2>Mejor Fecha de Ventas <?php echo Spn( FechaESP_OLD( date('Y-m-01'), 3 ) ); ?></h2>
                                <div class="bx">
                                    <h3><?php echo $__tot_dte->f->d->ds ?></h3>
                                    <h4><?php echo $__tot_dte->f->d->d.' '.$__tot_dte->f->d->m ?></h4>
                                    <span><?php echo _Nmb($__tot_dte->v, 8) ?></span>
                                </div>
                            </div>
                            <div class="_c _c4">
                                <h2>Herramientas</h2>
                                <ul class="tools">
                                    <li class="new_sles _anm"><button id="btn_new_sles">Nuevo <span>Registro</span></button></li>
                                </ul>
                                <div id="new_sles_form" class="new_sles_form">
                                    <div class="__chk_vl">
                                        <span class="_dlr">$</span>
                                        <span class="_vl"><?php echo number_format( $___Ls->dt->rw['orgsdsarrsls_vl'], 0, ",", "."); ?></span>
                                    </div>
                                    <form action="<?php echo VoId(); ?>" id="form_marks">
                                        <?php

                                            $_org_dt = GtOrgSdsArrDt([ 'i'=>$_GET['i'], 't'=>'org_enc' ]);

                                            $__dte = SlDt([ 'a'=>'ok', 'id'=>'orgsdsarrsls_f', 'va'=>$___Ls->dt->rw['orgsdsarrsls_f'], 'rq'=>'ok', 'ph'=>'Fecha' ]);
                                            echo $__dte->html;

                                            echo HTML_inp_tx('orgsdsarrsls_vl', "Ventas" , ctjTx($___Ls->dt->rw['orgsdsarrsls_vl'],'in'), FMRQD_NM);
                                            echo HTML_inp_tx('orgsdsarrsls_trs', "Transacciones" , ctjTx($___Ls->dt->rw['orgsdsarrsls_trs'],'in'), FMRQD_NM);
                                            echo HTML_inp_hd('orgsdsarr_sls_enc', $_org_dt->enc_sds);
                                            echo HTML_inp_hd('orgsdsarrsls_enc', '');
                                            echo HTML_inp_hd('orgsdsarr_sls_tp_bd', 'Insert');
                                            echo HTML_inp_hd('orgsdscnt_cnt', $_SESSION[DB_CL_ENC_SES.MM_CNT]);
                                        ?>
                                        <button id="send_form_sles">Guardar</button>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <?php

                        if($_org_dt->mnt == 1){ $CntWb .= " SUMR_AppCm.OnlyMonth(); "; }

                        $CntWb .= '
                            $(".owl-carousel").owlCarousel({
                                loop:false,
                                margin:10,
                                nav:false,
                                items:1
                            });
                        ';

                        $CntWb .= "
                            SUMR_AppCm.routes.pm1 = '{$__pm_1}';
                            SUMR_AppCm.routes.pm2= '{$__pm_2}';
                            SUMR_AppCm.routes.module = '{$_pm_module}';
                            SUMR_AppCm.stup.fm.id = '{$__id_fm}';
                        ";

                        $CntWb .= "

                            SUMR_AppCm.stup.org.id = '".$_GET['i']."';
                            SUMR_AppCm.Logt();
                            SUMR_AppCm.fm.mnt = '".($_org_dt->mnt==1?1:2)."';

                            SUMR_AppCm.snd({
                                p: 'data',
                                t: 'org_sds_arr_sls',
                                d: {
                                    i: SUMR_AppCm.stup.org.id
                                },
                                _bs:function(){ },
                                _cl:function(r){
                                    if(!SUMR_Ld.f.isN(r.app)){
                                        if(r.app.e == 'ok'){
                                            SUMR_AppCm.AppSet(r.app);
                                        }
                                    }
                                },
                                _cm:function(r){ },
                                _w:function(r){ }
                            });

                            SUMR_Grph.f.g1({
                                id: '#sales_this_month',
                                tt: ' ',
                                tt_sb: ' ',
                                plot_dl_y:-1,
                                c: SUMR_AppCm.grph.tot_sales_m.c,
                                d: SUMR_AppCm.grph.tot_sales_m.d,
                                c_e:true,
                                ttip_frmt:function(d){
                                    if(!SUMR_Ld.f.isN(d) && !SUMR_Ld.f.isN(d.point)){
                                        return '$' + Highcharts.numberFormat(d.y, 0, ',', '.');
                                    }
                                },
                                plot_dl_e: false,
                                plot_dl_frmt:function(d){
                                    if(!SUMR_Ld.f.isN(d) && !SUMR_Ld.f.isN(d.point)){
                                        if(!SUMR_Ld.f.isN( d.y )){
                                            var point = d.point;
                                            window.setTimeout(function () {
                                                point.dataLabel.attr({
                                                    y: point.plotY - 20
                                                });
                                            });

                                            return '$ ' + Highcharts.numberFormat(d.y, 0, ',', '.');
                                        }
                                    }
                                }
                            });

                            SUMR_Grph.f.g4({
                                id: '#sales_this_day',
                                c: SUMR_AppCm.grph.tot_sales.c,
                                d: SUMR_AppCm.grph.tot_sales.d,
                                tt: 'Ventas',
                                tt_sb: 'Ventas por día',
                                c_e: false,
                                g_spc_l: 0,
                                ttip_frmt:function(d){
                                    if(!SUMR_Ld.f.isN(d) && !SUMR_Ld.f.isN(d.point)){
                                        return '$' + Highcharts.numberFormat(d.y, 0, ',', '.');
                                    }
                                },
                            });

                            SUMR_Grph.f.g3({
                                id: '#sales_this_year',
                                c: SUMR_AppCm.grph.tot_sales_y.c,
                                d: SUMR_AppCm.grph.tot_sales_y.d,
                                tt: 'Ventas',
                                tt_sb: 'Ventas por año acumulado',
                                c_e: false,
                                ttip_frmt:function(d){
                                    if(!SUMR_Ld.f.isN(d) && !SUMR_Ld.f.isN(d.point)){
                                        return '$' + Highcharts.numberFormat(d.y, 0, ',', '.');
                                    }
                                }
                            });

                            SUMR_Grph.f.g4({
                                id: '#sales_this_tsr',
                                c: SUMR_AppCm.grph.tot_sales_t.c,
                                d: SUMR_AppCm.grph.tot_sales_t.d,
                                tt: 'Transacciones',
                                tt_sb: 'Transacciones por día',
                                c_e: false,
                                g_spc_l: 0,
                                ttip_frmt:function(d){
                                    if(!SUMR_Ld.f.isN(d) && !SUMR_Ld.f.isN(d.point)){
                                        return '$' + Highcharts.numberFormat(d.y, 0, ',', '.');
                                    }
                                }
                            });

                            SUMR_Grph.f.g4({
                                id: '#sales_this_tck',
                                c: SUMR_AppCm.grph.tot_sales_tck.c,
                                d: SUMR_AppCm.grph.tot_sales_tck.d,
                                tt: 'Tickets',
                                tt_sb: 'Promedio de ticket por día',
                                c_e: false,
                                g_spc_l: 0,
                                ttip_frmt:function(d){
                                    if(!SUMR_Ld.f.isN(d) && !SUMR_Ld.f.isN(d.point)){
                                        return '$' + Highcharts.numberFormat(d.y, 0, ',', '.');
                                    }
                                }
                            });

                        ";

                            ?>
                                <div>
                                    <div class="fst">
                                        <div><?php echo "Valor" ?></div>
                                        <div><?php echo "Transacciones" ?></div>
                                        <div><?php echo 'Fecha' ?></div>
                                        <div><?php echo '' ?></div>
                                    </div>
                                    <div id="valores" class="cont"></div>
                                </div>
                            <?php

                        ?>


                        <style>
                            .fst{width:100%;display:flex;flex-wrap:nowrap;margin-top:15px;background-color:#cacaca;border-radius:12px 12px 0 0}
                            .fst div{width:33%;padding:15px 0}
                            .cont .clds_cont{display:flex}
                            .clds_cont div{width:33%;padding:10px 0}
                            .cont{border:1px solid #cacaca;margin-bottom:100px}
                            .clds_cont:nth-child(even){background-color:#f2f2f2}
                            .clds_cont:hover{background-color:#ddd}
                            .edt button{background-image:url(<?php echo DMN_IMG_ESTR_SVG ?>atmt_act.svg);width:30px;height:30px;background-position:center;background-repeat:no-repeat;background-size:60% auto;border:1px solid #c5c5c5;border-radius:15px;cursor:pointer;opacity:.4}
                        </style>

                    <?php }else{

                        $CntWb .= "
                            SUMR_AppCm.routes.pm1 = '{$__pm_1}';
                            SUMR_AppCm.routes.pm2= '{$__pm_2}';
                            SUMR_AppCm.routes.module = '{$_pm_module}';
                            SUMR_AppCm.stup.fm.id = '{$__id_fm}';
                        ";

                        ?>

                        <div class="login">
                            <form action="<?php echo VoId(); ?>" id="<?php echo $__id_fm ?>" autocomplete="off">
                                <input name="user_form" type="email" id="user_form" autocomplete="off" placeholder="Usuario" />
                                <input name="passwor_for" type="password" class="required" id="passwor_for" autocomplete="off" placeholder="Clave" />
                                <button class="pin" id="<?php echo $__id_fm_btn ?>" name="<?php echo $__id_fm_btn ?>"><?php echo 'Ingresar'; ?></button>
                            </form>
                        </div>
                    <?php } ?>
                    <?php



                    ?>
				</div>

			</div>
		</section>
		<footer>
			<div class="lg_sumr"></div>
		</footer>
		<div class="_ovly _anm"></div>
		<div class="_prld _anm"></div>
	</body>
</html>

<script type="text/javascript">

    var SUMR_Main={slc:{ sch:''}};

	function __ld_all(){

        SUMR_AppCm={};

		SUMR_Ld.f.css({

            t:'p',
            h:'/css/?_c=<?php echo $__dt_cl->enc; ?>&_app=<?php echo $appdt->enc; ?>&Rd='+Math.random(),

	        c:function(){

                SUMR_Ld.f.css({

                    t:'p',
                    h:'<?php echo DMN_FLE_APP; ?>html/<?php echo $appdt->dir; ?>/main.css?rnd='+Math.random(),
                    c:function(){

                        SUMR_Ld.f.js({

                            t:'c',
					        u:'jquery.js',
                            c:function(){

                                SUMR_Ld.f.js({

                                    u:'<?php echo DMN_FLE_APP; ?>html/<?php echo $appdt->dir; ?>/main.js?rnd='+Math.random(),
                                    c:function(){

                                        SUMR_Ld.f.js({

                                            u:'<?php echo DMN_JS ?>js.js?rnd='+Math.random(),
                                            c:function(){

                                                SUMR_Ld.f.js({
                                                    t:'c',
                                                    u:'jquery-ui.js',
                                                    c:function(){

                                                        SUMR_Ld.f.js({ u:'/js/?_c=<?php echo $__dt_cl->enc; ?>&_a=<?php echo $appdt->enc; ?>&Rd='+Math.random() });

                                                        SUMR_Ld.f.js({
                                                            t:'c',
                                                            u: 'highcharts/highcharts.js',
                                                            c:function(){
                                                                SUMR_Ld.f.js({
                                                                    u:'<?php echo DMN_JS ?>jquery.colorbox-min.js',
                                                                    c:function(){
                                                                        SUMR_Ld.f.css({ t:'p', h:'<?php echo DMN_CSS ?>colorbox.css' });

                                                                        SUMR_Ld.f.js({
                                                                            u:'<?php echo DMN_JS ?>select2.js',
                                                                            c:function(){
                                                                                SUMR_Ld.f.css({ t:'p', h:'<?php echo DMN_CSS ?>select2.css' });

                                                                                SUMR_Ld.f.css({
                                                                                    t:'p',
                                                                                    h:'<?php echo DMN_CSS ?>ui/jquery-ui.css',
                                                                                    c:function(){

                                                                                        SUMR_Ld.f.js({
                                                                                            u:'<?php echo DMN_JS ?>sweetalert.js',
                                                                                            c:function(){
                                                                                                SUMR_Ld.f.css({ t:'p', h:'<?php echo DMN_CSS ?>sweetalert.css' });

                                                                                                SUMR_Ld.f.js({
                                                                                                    u:'<?php echo DMN_JS ?>jquery.carousel.js',
                                                                                                    c:function(){

                                                                                                        SUMR_Ld.f.css({ t:'p', h:'<?php echo DMN_CSS ?>carousel.css' });

                                                                                                            try{

                                                                                                                SUMR_AppCm.ldg({
                                                                                                                    cl:function(){

                                                                                                                        SUMR_Ld.f.js({
                                                                                                                            u:'https://ajax.googleapis.com/ajax/libs/webfont/1/webfont.js',
                                                                                                                            c:function(){

                                                                                                                            }
                                                                                                                        });

                                                                                                                        SUMR_AppCm.Dom_Rbld();

                                                                                                                        <?php if($__logged == 'ok'){ ?>

                                                                                                                            setTimeout(function() {

                                                                                                                                if(
                                                                                                                                    (!SUMR_Ld.f.isN(SUMR_Main) && !SUMR_Ld.f.isN(SUMR_Main.is_f) && !SUMR_Ld.f.isN(Highcharts)) ||
                                                                                                                                    (!SUMR_Ld.f.isN(SUMR_Ld) && !SUMR_Ld.f.isN(SUMR_Ld.f) && !SUMR_Ld.f.isN(Highcharts))
                                                                                                                                ){

                                                                                                                                    /*console.log('Setup Data');*/

                                                                                                                                    SUMR_AppCm.grph.tot_sales.c = [<?php if(!isN($__sbmt_n->c)){ echo implode(",", $__sbmt_n->c); } ?>];
                                                                                                                                    SUMR_AppCm.grph.tot_sales.d = [
                                                                                                                                        {
                                                                                                                                            data: [<?php if(!isN($__sbmt_n->v)){ echo implode(",", $__sbmt_n->v); } ?>],
                                                                                                                                            color: '<?php echo $_dt->clr; ?>'
                                                                                                                                        }
                                                                                                                                    ];

                                                                                                                                    SUMR_AppCm.grph.tot_sales_m.c = [<?php if(!isN($__sbmt_b->c)){ echo implode(",", $__sbmt_b->c); } ?>];
                                                                                                                                    SUMR_AppCm.grph.tot_sales_m.d = [
                                                                                                                                        {
                                                                                                                                            name: 'Total',
                                                                                                                                            data: [<?php if(!isN($__sbmt_b->v)){ echo implode(",", $__sbmt_b->v); } ?>],
                                                                                                                                            color: '<?php echo $_dt->clr; ?>'
                                                                                                                                        }
                                                                                                                                    ];

                                                                                                                                    SUMR_AppCm.grph.tot_sales_y.c = [<?php if(!isN($__sbmt_y->c)){ echo implode(",", $__sbmt_y->c); } ?>];
                                                                                                                                    SUMR_AppCm.grph.tot_sales_y.d = [<?php if(!isN($__sbmt_y->v)){ echo implode(",", $__sbmt_y->v); } ?>];

                                                                                                                                    SUMR_AppCm.grph.tot_sales_t.c = [<?php if(!isN($__sbmt_t->c)){ echo implode(",", $__sbmt_t->c); } ?>];
                                                                                                                                    SUMR_AppCm.grph.tot_sales_t.d = [
                                                                                                                                        {
                                                                                                                                            data: [<?php if(!isN($__sbmt_t->v)){ echo implode(",", $__sbmt_t->v); } ?>],
                                                                                                                                            color: '<?php echo $_dt->clr; ?>'
                                                                                                                                        }
                                                                                                                                    ];

                                                                                                                                    SUMR_AppCm.grph.tot_sales_tck.c = [<?php if(!isN($__sbmt_tck->c)){ echo implode(",", $__sbmt_tck->c); } ?>];
                                                                                                                                    SUMR_AppCm.grph.tot_sales_tck.d = [
                                                                                                                                        {
                                                                                                                                            data: [<?php if(!isN($__sbmt_tck->v)){ echo implode(",", $__sbmt_tck->v); } ?>],
                                                                                                                                            color: '<?php echo $_dt->clr; ?>'
                                                                                                                                        }
                                                                                                                                    ];


                                                                                                                                    SUMR_AppCm.Dom_Rbld();
                                                                                                                                    SUMR_AppCm.rndr_g();
                                                                                                                                    <?php echo $__dte->js; ?>

                                                                                                                                }else{

                                                                                                                                    /*console.log('No basic functions to display data');*/

                                                                                                                                }

                                                                                                                            }, 3000);

                                                                                                                        <?php } ?>

                                                                                                                    }

                                                                                                                });

                                                                                                            }catch(e){

                                                                                                                console.info(e.message);
                                                                                                                console.info(e);

                                                                                                            }


                                                                                                        $(document).ready(function(){

                                                                                                            $('body').addClass('on');

                                                                                                            <?php echo $CntWb; ?>

                                                                                                        });

                                                                                                    }
                                                                                                });

                                                                                            }
                                                                                        });

                                                                                    }
                                                                                });

                                                                            }
                                                                        });
                                                                    }
                                                                });
                                                            }
                                                        });

                                                    }
                                                });

                                            }
                                        });

                                    }

                                });

                            }

                        });
                    }

                });

			}

		});

	}

    SUMR_RquClg = {
        rnd:'',
        snd:{},
        _utt: 'Envio Exitoso',
        _utx: 'Tus datos fueron enviados.'
    };

</script>
<script type="text/javascript" id="main-script" src="<?php echo DMN_JS ?>_ld.js?__r=<?php if(!Dvlpr()){ echo E_TAG; }else{ echo Enc_Rnd('r'); } ?>" async></script>
<!-- Widget - SUMR CRM --><script>(function(w,d,s,l,i){ var f=d.getElementsByTagName(s)[0], j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:''; j.async=true; j.src='https://wdgt.sumr.co/main.js?id='+i; f.parentNode.insertBefore(j,f); })(window,document,'script','dataLayer','f0a1ad1071033588bb0e893a3e7e5992fd0e9c48');</script>
<?php } ?>