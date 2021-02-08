<?php $Rt = '../../includes/'; $__bdfrnt = 'ok'; require($Rt.'inc.php'); ob_start("compress_code"); No_Cache(); Hdr_HTML();

	global $__cnx;
	$_tp = PrmLnk('rtn', 1);

	$__dtcmp = GtCmpDt(['i'=>PrmLnk('rtn', 2), 't'=>'pm', 'tp'=>$_tp]);
	$__rsl_cmp = json_decode( __Cmp_c(['adm'=>'ok',
										'f_str'=>$__dtcmp->f_str,
										'f_end'=>$__dtcmp->f_end,
										'prs'=>$__dtcmp->prs,
										'gst'=>$__dtcmp->gst,
										'gst_f'=>$__dtcmp->gst_fnl,
										'utl'=>$__dtcmp->utl]) );

	if($__dtcmp->fb_id != NULL){ $_FB_Sta = __FB_Ing_Sta(['t'=>$_tp, 'c'=>$__dtcmp->id, 'f'=>$__dtcmp->fb_id, 'c_prs_c'=>$__dtcmp->prs, 'c_inv_s'=>$__rsl_cmp->s_inv]); }


	$Ls_Gst_Qry = sprintf("SELECT * FROM ".TB_PRO_CMP_GST." WHERE procmpgst_cmp = %s ORDER BY id_procmpgst DESC", GtSQLVlStr($__dtcmp->id, "int"));
	$Ls_Gst_Rg = $__cnx->_qry($Ls_Gst_Qry); $row_Ls_Gst_Rg = $Ls_Gst_Rg->fetch_assoc(); $Tot_Ls_Gst_Rg = $Ls_Gst_Rg->num_rows;

	$__crm = Php_Ls_Cln($_GET['crm']);


	$_g_t = new DateTime('now');
	$_g_f1 = new DateTime($__dtcmp->f_str);
	$_g_f2 = new DateTime($__dtcmp->f_end);
	$_g_in = new DateInterval("P1D");

	if($_g_f2 < $_g_t){$_dt_sql = $_g_f2;}else{$_dt_sql = $_g_t;}

	$_g_pr = new DatePeriod($_g_f1, $_g_in, $_dt_sql);

	foreach ($_g_pr as $_g_dt) {
		$_lds_tg[] = "'".$_g_dt->format('Y-m-d')."'";

		$Ls_Sta_Qry = sprintf("SELECT * FROM ".TB_PRO_CMP_STA." WHERE procmpsta_end = %s AND procmpsta_procmp = %s ORDER BY id_procmpsta DESC LIMIT 1", GtSQLVlStr($_g_dt->format('Y-m-d'), "date"), GtSQLVlStr($__dtcmp->id, "int"));
		$Ls_Sta_Rg = $__cnx->_qry($Ls_Sta_Qry); $row_Ls_Sta_Rg = $Ls_Sta_Rg->fetch_assoc(); $Tot_Ls_Sta_Rg = $Ls_Sta_Rg->num_rows;

		if($row_Ls_Sta_Rg['procmpsta_cli'] != ''){ $__gr_cli[] = $row_Ls_Sta_Rg['procmpsta_cli']; }else{ $__gr_cli[] = 0; }
		if($row_Ls_Sta_Rg['procmpsta_prt'] != ''){ $__gr_prt[] = $row_Ls_Sta_Rg['procmpsta_prt']; }else{ $__gr_prt[] = 0; }
	}

	$_grf_tag = implode(",", $_lds_tg);
	$_grf_vle_cli = implode(",", $__gr_cli);
	$_grf_vle_prt = implode(",", $__gr_prt);



	foreach($_g_pr as $_g_dt_cnt){
		$_dt_q = '';
		$_dt_q = $_g_dt_cnt->format('Y-m-d');

		$Ls_Cnt_Qry = "CALL Tot_Cnt_Day('".$_dt_q."','','".$_tp."', '".$__dtcmp->md."', '".$__dtcmp->fac->id."', '".$__dtcmp->p_id_apr."', '', '".$__dtcmp->p_gen."')";
		$Ls_Cnt_Rg = $__cnx->_qry($Ls_Cnt_Qry); $row_Ls_Cnt_Rg = $Ls_Cnt_Rg->fetch_assoc(); $Tot_Ls_Cnt_Rg = $Ls_Cnt_Rg->num_rows;

			$_lds_tg[] = "'".FechaESP_OLD($row_Ls_Cnt_Rg['t_cnt_fi'], 6, true).' '.FechaESP_OLD($row_Ls_Cnt_Rg['t_cnt_fi'], 4).'-'.FechaESP_OLD($row_Ls_Cnt_Rg['t_cnt_fi'], 2)."'";
			$_lds_tot_aspi[] = number_format($row_Ls_Cnt_Rg['__tot_aspi'], 2, '.', '');
			$_lds_tot_insc[] = number_format($row_Ls_Cnt_Rg['__tot_insc'], 2, '.', '');

	}


	$_grf_lds_tag = implode(",", $_lds_tg);
	$_grf_vle_lds = implode(",", $_lds_tot_aspi);

?>
<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title><?php echo '['.$__dtcmp->cod.']' ?></title>
<base href="<?php echo DMN_CMP ?>" target="_self">
<link href="/includes/sty/all.css" rel="stylesheet" type="text/css" />
</head>

<body <?php if($__crm == 'ok'){ ?>class="_crm"<?php } ?> >

	<header><img src="img/logo.png"></header>


    <div class="_wrp _ok_hdr">

        <div id="TabbedPanels1" class="TabbedPanels">
            	<ul class="TabbedPanelsTabGroup">

                    <li class="TabbedPanelsTab"><?php echo TX_DSGNS ?></li>

					<?php if($__dtcmp->tp_id == 2){ ?>
                    <li class="TabbedPanelsTab"><?php echo TX_GOOKEYW ?></li>
                    <?php } ?>

                    <?php if($__dtcmp->tp_id == 1){ ?>
                    <li class="TabbedPanelsTab"><?php echo TX_FBSGMN ?></li>
                    <?php } ?>

                    <li class="TabbedPanelsTab"><?php echo TX_RSLT ?></li>
                    <li class="TabbedPanelsTab"><?php echo TX_OBS ?></li>
                    <li class="TabbedPanelsTab"><?php echo TX_HSTR ?></li>
                </ul>
                <div class="TabbedPanelsContentGroup">

                    <div class="TabbedPanelsContent">

							<h1><?php echo $__dtcmp->p_tt. Spn(_dp(TX_LEADS).$__dtcmp->tot_cnt,'ok'); ?></h1>
							<?php


													if($__dtcmp->fb_id != NULL){ $__Ls_Gst_ads_fb = _FB_Ad_Ls($__dtcmp->fb_id, $__dtcmp->prs, $__rsl_cmp->s_inv); }

													if($__Ls_Gst_ads_fb != NULL && $__Ls_Gst_ads_fb != ''){

															foreach($__Ls_Gst_ads_fb as $row){

																	$__dt_an = '<div class="__st">

																					<div class="_c1">
																						<ul>
																							<li>'.Spn('','','_icn _icn_md').Strn(_dp(TT_SISMED)) . $__dtcmp->md_nm.'</li>
																							<li>'.Spn('','','_icn _icn_md').Strn(_dp(TX_S)) . Spn($__dtcmp->est_nm,'',$__dtcmp->est_cls).'</li>
																							<li>'.Spn('','','_icn _icn_dt').Strn(_dp(TX_INIC)) . $__dtcmp->f_str.'</li>
																							<li>'.Spn('','','_icn _icn_dt').Strn(_dp(TX_FNLZ)) . $__dtcmp->f_end.'</li>
																							<li>'.Spn('','','_icn _icn_us').Strn(_dp(TX_SLCT)) . $__dtcmp->slc_nm.'</li>
																							<li>'.Spn('','','_icn _icn_md').Strn(TX_APRBQ.':') . $__dtcmp->aprb_nm.'</li>
                            																<li>'.Spn('','','_icn _icn_us').Strn(TX_APRBPOR) . $__dtcmp->aprb_us.'</li>
																							<li>'.Spn('','','_icn _icn_mny').Strn('Gastado Hoy: '). cnVlrMon('', __FB_Gst_R(['prs'=>$__dtcmp->prs, 'v_r'=>$row->insights->today_spend, 'inv'=>$__rsl_cmp->s_inv]) ).'</li>
																							<li>'.Spn('','','_icn _icn_mny').Strn('Gastado Total: ').cnVlrMon('', __FB_Gst_R(['prs'=>$__dtcmp->prs, 'v_r'=>$row->insights->spend, 'inv'=>$__rsl_cmp->s_inv]) ).'</li>
																							<li>'.Spn('','','_icn _icn_clc').Strn('Clics: ')._Nmb($row->insights->clicks, 3).'</li>
																						</ul>
																					</div>
																					<div class="_c2">
																						<ul>
																							<li>'.Spn('','','_icn _icn_clc').Strn('CPM: ').cnVlrMon('', __FB_Gst_R(['prs'=>$__dtcmp->prs, 'v_r'=>$row->insights->cpm, 'inv'=>$__rsl_cmp->s_inv]) ).'</li>
																							<li>'.Spn('','','_icn _icn_clc').Strn('CPC: ').cnVlrMon('', __FB_Gst_R(['prs'=>$__dtcmp->prs, 'v_r'=>$row->insights->cpc, 'inv'=>$__rsl_cmp->s_inv]) ).'</li>
																							<li>'.Spn('','','_icn _icn_clc').Strn('CPP: ').cnVlrMon('', __FB_Gst_R(['prs'=>$__dtcmp->prs, 'v_r'=>$row->insights->cpp, 'inv'=>$__rsl_cmp->s_inv]) ).'</li>

																							<li>'.Spn('','','_icn _icn_clc').Strn('CTR: ')._Nmb($row->insights->ctr, 5).'</li>
																							<li>'.Spn('','','_icn _icn_clc').Strn('Impressions: ')._Nmb($row->insights->impressions, 3).'</li>
																							<li>'.Spn('','','_icn _icn_clc').Strn('Frequency: ')._Nmb($row->insights->frequency, 5).'</li>
																							<li>'.Spn('','','_icn _icn_md').Strn('Alcance: ')._Nmb($row->insights->reach, 3).'</li>
																							<li>'.Spn('','','_icn _icn_scr').Strn('Score: ').$row->insights->relevance_score->score.'</li>
																							<li>'.Spn('','','_icn _icn_scr_ok').Strn('Positivo: ').$row->insights->relevance_score->positive_feedback.'</li>
																							<li>'.Spn('','','_icn _icn_scr_no').Strn('Negativo: ').$row->insights->relevance_score->negative_feedback.'</li>
																							<li>'.Spn('','','_icn _icn_md').Strn('Status: ').$row->insights->relevance_score->status.'</li>
																						</ul>
																					</div>
																				</div>
																				';

																$__dt_tt = h3($row->adcreatives->object_story_spec->link_data->name);
																$__dt_img = '<img src="'.$row->adcreatives->image_url.'">';
																$__dt_msg = '<p>'.$row->adcreatives->object_story_spec->link_data->message.'</p>';
																$__dt_dsc = '<p class="_p2">'.$row->adcreatives->object_story_spec->link_data->description.'</p>';
																$_edt_btn = '';

																if($__crm == 'ok'){ $_edt_btn = '<li class="_edt"><a href="'._Fb_Ad_Mod($row->adcampaign->id, $row->id).'" target="_blank">'.TX_EDT.'</a></li>'; }
																$__dt_img_viw = $__dt_tt.'<div class="_ad">
																								 '.$__dt_msg.'
																								 <div class="_im">'.$__dt_img.'
																										<ul class="_viw">
																											<li class="_r _sc_'.$row->insights->relevance_score->score.'">'.$row->insights->relevance_score->score.'</li>
																											<li><a href="'.URL_FB_FEED.$row->id.'" target="_blank">'.TX_ADS_NWS.'</a></li>
																											<li><a href="'.URL_FB_AD.$row->id.'" target="_blank">'.TX_ADS_RGS.'</a></li>
																											<li><a href="'.URL_FB_PST.$row->adcreatives->object_story_id.'" target="_blank">'.TX_ADS_PST.'</a></li>
																											<li class="_e '.$row->adcreatives->run_status.'">'.$row->adcreatives->run_status.'</li>
																											'.$_edt_btn.'
																										</ul>
																								 </div>
																								 '.$__dt_dsc.'
																						  </div>'.$__dt_an
																						;

																$__Crsl_Html .= '<div class="item">'.bdiv(['c'=>$__dt_img_viw, 'id'=>'dt_img', 'cls'=>'cmp_img']).'</div>';
															}

															echo '<div class="_ads_crsl"><div id="__grph_crsl" class="owl-carousel">'.$__Crsl_Html.'</div></div>';

															$CntWb .= '$("#__grph_crsl").owlCarousel({
																		  /*autoPlay: true,*/
																		  stopOnHover: true,
																		  navigation : true,
																		  slideSpeed : 300,
																		  paginationSpeed : 400,
																		  navigation: false,
																		  singleItem:true
																	 });';
													}
							?>
                    </div>


                    <?php if($__dtcmp->tp_id == 2){ ?>
                    <div class="TabbedPanelsContent">
                    		<ul>
                                <li><?php echo Strn('Segmento:') . $__dtcmp->fb_sgm ?></li>
                                <li><?php echo Strn('Descripción Demográfica:') . $__dtcmp->dsc_dmg ?></li>
                                <li><?php echo Strn('Descripción Psicográfica:') . $__dtcmp->dsc_psc ?></li>
                            </ul>
                    </div>
                    <?php } ?>
                    <?php if($__dtcmp->tp_id == 1){ ?>
                    <div class="TabbedPanelsContent">
                    		<ul>
                                <li><?php echo Strn('Segmento:') . $__dtcmp->fb_sgm ?></li>
                                <li><?php echo Strn('Descripción Demográfica:') . $__dtcmp->dsc_dmg ?></li>
                                <li><?php echo Strn('Descripción Psicográfica:') . $__dtcmp->dsc_psc ?></li>
                            </ul>
                    </div>
                    <?php } ?>
                    <div class="TabbedPanelsContent">
                            <div class="_ln">
                                <?php echo h2(_dp(TX_PRSP) . HTML_BR  . Spn(cnVlrMon('', $__dtcmp->prs)) . Spn( _Nmb($__rsl_cmp->c_inv_p, 1) ,'ok','_gst') ); ?>
                                <div class="_c1">
                                        <ul>
                                            <?php if($__dtcmp->rsl_exp != NULL){ ?><li><?php echo Strn(_dp(TX_RSLESPR)) . $__dtcmp->rsl_exp  ?></li><?php } ?>
                                            <?php

                                               if($_FB_Sta->e == 'ok'){

                                                        echo li(Spn('','','_icn _icn_us').Strn(_dp(TX_LEADS)).$__dtcmp->tot_cnt);
														echo li(Spn('','','_icn _icn_mny').Strn(_dp(TX_CPR)).cnVlrMon('', $_FB_Sta->nw_cost_per_result ));
                                                        echo li(Spn('','','_icn _icn_mny').Strn(_dp(TX_CPA)).cnVlrMon('', $_FB_Sta->nw_cost_per_total_action ));
                                                        echo li(Spn('','','_icn _icn_mny').Strn(_dp(TX_CPC)).cnVlrMon('', $_FB_Sta->nw_cpc) );
                                                        echo li(Spn('','','_icn _icn_mny').Strn(_dp(TX_CPUC)).cnVlrMon('', $_FB_Sta->nw_cost_per_unique_click) );
                                                        echo li(Spn('','','_icn _icn_mny').Strn(_dp(TX_CPM)).cnVlrMon('', $_FB_Sta->nw_cpm) );
                                                        echo li(Spn('','','_icn _icn_mny').Strn(_dp(TX_CPP)).cnVlrMon('', $_FB_Sta->nw_cpp) );
                                                        echo li(Spn('','','_icn _icn_clc').Strn(_dp(TX_CTR))._Nmb($_FB_Sta->ctr, 6));
                                                        echo li(Spn('','','_icn _icn_clc').Strn(_dp(TX_CLCKS))._Nmb($_FB_Sta->clicks, 3));
														echo li(Spn('','','_icn _icn_clc').Strn(_dp(TX_IMP))._Nmb($_FB_Sta->impressions, 3));
                                                        echo li(Spn('','','_icn _icn_clc').Strn(_dp(TX_FRQ))._Nmb($_FB_Sta->frequency, 5));
                                                        echo li(Spn('','','_icn _icn_clc').Strn(_dp(TX_CMTN)).$_FB_Sta->a_comment. Spn(_dp(TX_CPA).cnVlrMon('', $_FB_Sta->nw_c_comment ),'ok','_cpa'));
                                                }
                                            ?>
                                        </ul>
                                </div>
                            	<div class="_c2">
                                        <ul>
                                            <?php

                                                if($_FB_Sta->e == 'ok'){

                                                        echo li(Spn('','','_icn _icn_lke').Strn(_dp(TX_LKS)).$_FB_Sta->a_like. Spn(_dp(TX_CPA).cnVlrMon('', $_FB_Sta->nw_c_like ),'ok','_cpa'));
                                                        echo li(Spn('','','_icn _icn_clc').Strn(_dp(TX_CLNK)).$_FB_Sta->a_link_click. Spn(_dp(TX_CPA).cnVlrMon('', $_FB_Sta->nw_c_link_click ),'ok','_cpa'));
                                                        echo li(Spn('','','_icn _icn_clc').Strn(_dp(TX_OFFCNV)).$_FB_Sta->a_offsite_conversion. Spn(_dp(TX_CPA).cnVlrMon('', $_FB_Sta->nw_c_offsite_conversion ),'ok','_cpa'));
                                                        echo li(Spn('','','_icn _icn_clc').Strn(_dp(TX_ADS_PST))._Nmb($_FB_Sta->a_post, 3). Spn(_dp(TX_CPA).cnVlrMon('', $_FB_Sta->nw_c_post ),'ok','_cpa') );
                                                        echo li(Spn('','','_icn _icn_clc').Strn(_dp(TX_ADS_PST.' '.TX_LKS)).$_FB_Sta->a_post_like. Spn(_dp(TX_CPA).cnVlrMon('', $_FB_Sta->nw_c_post_like ),'ok','_cpa'));
                                                        echo li(Spn('','','_icn _icn_clc').Strn(_dp(TX_PGENG)).$_FB_Sta->a_page_engagement. Spn(_dp(TX_CPA).cnVlrMon('', $_FB_Sta->nw_c_page_engagement ),'ok','_cpa'));
                                                        echo li(Spn('','','_icn _icn_clc').Strn(_dp(TX_PSTENG)).$_FB_Sta->a_post_engagement. Spn(_dp(TX_CPA).cnVlrMon('', $_FB_Sta->nw_c_post_engagement ),'ok','_cpa'));
                                                        echo li(Spn('','','_icn _icn_mny').Strn(_dp(TX_GSTD)).cnVlrMon('', $__rsl_cmp->c_gst));
                                                        echo li(Spn('','','_icn _icn_scr').Strn(_dp(TX_RLV_ANC)).$_FB_Sta->relevance_score->score);
                                                        echo li(Spn('','','_icn _icn_scr_ok').Strn(_dp(TX_RLV_PSTV)).$_FB_Sta->relevance_score->positive_feedback);
                                                        echo li(Spn('','','_icn _icn_scr_no').Strn(_dp(TX_RLV_NGTV)).$_FB_Sta->relevance_score->negative_feedback);
                                                        echo li(Spn('','','_icn _icn_cmp').Strn(_dp(TX_RLV_STTS)).$_FB_Sta->relevance_score->status);
                                                }

                                            ?>
                                        </ul>
                                   </div>
                            </div>
                    </div>
                    <div class="TabbedPanelsContent">
                    		<?php echo $__dtcmp->obs ?>
                            <?php
								do {

									$__gtusdt = GtUsDt($row_Ls_Gst_Rg['procmpgst_us']);
									$__gtusdt_rsp = GtUsDt($row_Ls_Gst_Rg['procmpgst_us_rsp']);


									if ($row_Ls_Gst_Rg['procmpgst_shw']==1) {
										$_ul_gst .= li( Spn('','','_icn _icn_us')._dp(Strn($__gtusdt->nm_fll)).
													ctjTx(strip_tags($row_Ls_Gst_Rg['procmpgst_dsc']),'in'). HTML_BR . HTML_BR .
													Spn($row_Ls_Gst_Rg['procmpgst_fi'],'','_f').
													Spn($row_Ls_Gst_Rg['procmpgst_hi'],'','_h')
												);
									 }




                              	}while ($row_Ls_Gst_Rg = $Ls_Gst_Rg->fetch_assoc());
							 ?>
                             <ul class="_gst"><?php echo $_ul_gst ?></ul>
                    </div>
                    <div class="TabbedPanelsContent">
                    		<div id="_grph_1" class="_grph" style="width:800px; height:200px;"></div>
                        	<div id="_grph_2" class="_grph" style="width:800px; height:200px;"></div>
                            <div id="_grph_3" class="_grph" style="width:800px; height:200px;"></div>

                        	<?php $CntWb .= "

											$('#_grph_1').highcharts({
													chart: {type: 'areaspline', backgroundColor:'rgba(255, 255, 255, 0)' },
													title: {text: 'Acumulado de Clics', align:'right', style: { color: '#CCCCCC', fontSize:'11px', fontWeight: 'light'} },
													legend: {
															title: { text: '' }, itemStyle: { fontSize:'9px' , lineHeight: '9px' },
															layout: 'horizontal', backgroundColor: 'transparent', align: 'center', verticalAlign: 'top', x: 0, y: 20, margin: 0, padding: 5,
															borderWidth: 0, symbolWidth: 5, symbolPadding: 2, itemMarginTop: 0, itemMarginBottom: 5, shadow: false
													},
													xAxis: { categories: [".$_grf_tag."], labels: { enabled: false } },
													yAxis: { title: { text: ''}, min:0},
													tooltip: { shared: true },
													credits: { enabled: false },
													plotOptions: { areaspline: { fillOpacity: 0.3 } },
													series: [{ name: '".TX_CLCKS."', data: [".$_grf_vle_cli."], color:'#FFA64D'}]
											});



											$('#_grph_2').highcharts({
													chart: {type: 'areaspline', backgroundColor:'rgba(255, 255, 255, 0)'},
													title: {text: 'Acumulado de Impresiones', align:'right', style: { color: '#CCCCCC',fontSize:'11px', fontWeight: 'light'} },
													legend: {
															title: { text: '' }, itemStyle: { fontSize:'9px' , lineHeight: '9px' },
															layout: 'horizontal', backgroundColor: 'transparent', align: 'center', verticalAlign: 'top', x: 0, y: 20, margin: 0, padding: 5,
															borderWidth: 0, symbolWidth: 5, symbolPadding: 2, itemMarginTop: 0, itemMarginBottom: 5, shadow: false
													},
													xAxis: { categories: [".$_grf_tag."], labels: { enabled: false } },
													yAxis: { title: { text: ''}, min:0 },
													tooltip: { shared: true },
													credits: { enabled: false },
													plotOptions: { areaspline: { fillOpacity: 0.3 } },
													series: [{ name: '".TX_IMP."', data: [".$_grf_vle_prt."], color:'#A3D900'}]
											});



											$('#_grph_3').highcharts({
													chart: {type: 'areaspline', backgroundColor:'rgba(255, 255, 255, 0)'},
													title: {text: 'Cantidad de leads por dia', align:'right', style: { color: '#CCCCCC',fontSize:'11px', fontWeight: 'light'} },
													legend: {
															title: { text: '' }, itemStyle: { fontSize:'9px' , lineHeight: '9px' },
															layout: 'horizontal', backgroundColor: 'transparent', align: 'center', verticalAlign: 'top', x: 0, y: 20, margin: 0, padding: 5,
															borderWidth: 0, symbolWidth: 5, symbolPadding: 2, itemMarginTop: 0, itemMarginBottom: 5, shadow: false
													},
													xAxis: { categories: [".$_grf_lds_tag."], labels: { enabled: false} },
													yAxis: { title: { text: ''}, min:0 },
													tooltip: {shared: true},
													credits: {enabled: false},
													plotOptions: {
														areaspline: {
															fillOpacity: 0.3
														},
														series: {
															marker: {
																enabled: true,
																symbol: 'circle',
																radius: 4
															}
														}
													},
													series: [{ name: '".TX_LEADS."', data: [".$_grf_vle_lds."], color:'".$__dtcmp->md_clr."'}]
											});
							";?>

                    </div>
            </div>

        </div>

    </div>

    <footer>
    	<div class="_fb"></div>
        <div class="_sv"></div>
    </footer>

    <script type="text/javascript" src="<?php echo DMN_JS ?>jquery.js"></script>
    <script type="text/javascript" src="<?php echo DMN_JS ?>_sp_tbd.js"></script>
    <script type="text/javascript" src="<?php echo DMN_JS ?>jquery.carousel.js"></script>
    <script type="text/javascript" src="<?php echo DMN_JS ?>highcharts.js"></script>

	<script type="text/javascript">
			jQuery(document).ready(function() {
					var TabbedPanels1 = new Spry.Widget.TabbedPanels("TabbedPanels1");
    				document.oncontextmenu =new Function("return false;");
					<?php echo $CntWb; ?>
    		});
    </script>
</body>
</html>
<?php $__cnx->_clsr($Ls_Gst_Rg); $__cnx->_clsr($Ls_Sta_Rg); $__cnx->_clsr($Ls_Cnt_Rg); ob_end_flush(); ?>