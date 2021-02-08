<?php

if(class_exists('CRM_Cnx')){
	$___Ls->sch->f = 'act_tt, act_dsc, act_cod';

	$___Ls->tp = 'act';
	$___Ls->flt = 'ok';

	$___Ls->tt = MDL_ACT;
	$___Ls->new->big = 'ok';
	$___Ls->edit->big = 'ok';

	$___Ls->grph->h = 'mny';
	$___Ls->img->dir = DMN_FLE_ACT;

	if($__t != 'org_act'){

		$___Ls->grph->tot = 1;

	}

	/*
	$___Ls->new->w = 800;
	$___Ls->new->h = 600;
	$___Ls->edit->w = 800;
	$___Ls->edit->h = 600;
	*/

	$___Ls->_strt();

	if($__t == 'org_act' || ($__t == 'act' && $__t2 == 'clg')){
		$__fl = "INNER JOIN "._BdStr(DBM).TB_ORG_SDS_ACT." ON id_act = orgsdsact_act INNER JOIN "._BdStr(DBM).TB_ORG_SDS." ON id_orgsds = orgsdsact_orgsds INNER JOIN "._BdStr(DBM).TB_ORG." ON id_org = orgsds_org";
	}

	if(!isN($___Ls->_fl->fk->_actfl_est)){

		if(is_array( $___Ls->_fl->fk->_actfl_est )){
			$__all_prd_i = implode(',', $___Ls->_fl->fk->_actfl_est);
		}else{
			$__all_prd_i = '"'.$___Ls->_fl->fk->_actfl_est.'"';
		}

		if(!isN($__all_prd_i)){ $___Ls->qry_f .= ' AND act_est IN ('.$__all_prd_i.') ';	}

	}else{

		if(isN($___Ls->gt->isb)){
			//$___Ls->qry_f .= ' AND act_est IN ('._CId('ID_ACTEST_ACT').','._CId('ID_ACTEST_SLCT').') ';
		}

	}

	if(!isN($___Ls->gt->i)){

		$___Ls->qrys = sprintf("SELECT * FROM "._BdStr(DBM).TB_ACT." $__fl WHERE ".$___Ls->ik." = %s LIMIT 1", GtSQLVlStr($___Ls->gt->i, "text"));

	}elseif($___Ls->_show_ls == 'ok'){

		if($__t == 'org_act'){  $___f = "AND org_enc = '".$___Ls->gt->isb."'";  }

		if($__t == 'act'){
			$__fl = "INNER JOIN "._BdStr(DBM).TB_ACT_TP." ON acttp_act = id_act
					 INNER JOIN "._BdStr(DBM).TB_MDL_S_TP." ON acttp_mdlstp = id_mdlstp";
			$___Ls->qry_f .= " AND mdlstp_tp = '".$__t2."' ";
		}

		$Ls_Whr = "FROM "._BdStr(DBM).TB_ACT."
						 $__fl
					WHERE ".$___Ls->ino." != '' $___fld ".$___Ls->sch->cod." ".$___Ls->qry_f." AND act_cl = '".DB_CL_ID."' $___f ORDER BY ".$___Ls->ino." DESC";

		$___Ls->qrys = "SELECT *, (SELECT COUNT(*) $Ls_Whr) AS ".QRY_RGTOT." $Ls_Whr";

	}

	$___Ls->hdr->mre = '<button id="show_clndr_'.$___Ls->id_rnd.'" class="_anm act_clndr"></button>';


	$___Ls->_bld(); //echo compress_code( $___Ls->qrys );


	$__id_div = 'clndr_'.$___Ls->id_rnd;

?>
	<div class="cont_cld" style="display:none;height: 700px;">
		<button class="_anm btn_bck_lstd"></button>
		<div id='calendar'></div>
	</div>
	<div class="act_list">

	<div id="<?php echo $__id_div; ?>"></div>

	<?php if($___Ls->ls->chk=='ok'){ ?>
		<?php $___Ls->_bld_l_hdr(); ?>

		<?php

			if(!isN($___Ls->grph) && $__t != 'org_act'){

				$CntWb .= "

					_ldCnt({
						u:'".Fl_Rnd(FL_GRPH_GN.__t($___Ls->gt->t, true).$___Ls->ls->vrall)."&_h=150&_t2=".$___Ls->gt->tsb."&_tp=grph_1&_g_r=".$___Ls->id_rnd."' ,
						c:'bx_grph_".$___Ls->id_rnd."_1',
						trs:false,
						anm:'no',
						_cl:function(){


						}
					});

				";

			}

		?>

		<?php if(($___Ls->qry->tot > 0)){

				$__ls_json_clnd = [];


			?>
				<table width="100%" border="0" cellpadding="0" cellspacing="0" class="Ls_Rg">
					<tr>
						<th width="1%" <?php echo NWRP ?>><?php echo TX_FM_No ?></th>
						<?php if($__t == 'act'){ ?>
							<th width="1%" <?php echo NWRP ?>><?php echo TX_CLG ?></th>
						<?php } ?>
						<th width="20%" <?php echo NWRP ?>><?php echo TX_NM ?></th>
						<th width="10%" <?php echo NWRP ?>><?php echo TX_ETD ?></th>
						<th width="10%" <?php echo NWRP ?>><?php echo "LEADS (TOTAL)"; ?></th>
						<th width="10%" <?php echo NWRP ?>><?php echo "LEADS (D)"; ?></th>
						<th width="10%" <?php echo NWRP ?>><?php echo "LEADS (M)"; ?></th>
						<th width="10%" <?php echo NWRP ?>><?php echo "CODIGO"; ?></th>
						<th width="10%" <?php echo NWRP ?>><?php echo TX_ORD_FOU ?></th>
						<th width="10%" <?php echo NWRP ?>><?php echo TX_ORD_FIN ?></th>
						<th width="1%" <?php echo NWRP ?>></th>
					</tr>
					<?php do { ?>
					<?php $__ls_json[] = $___Ls->ls->rw['act_enc']; $_est = __LsDt([ 'k'=>'act_est' ]);  ?>
					<?php $__ls_json_clnd[] = [
												'title' => $___Ls->ls->rw['act_tt'],
												'start' => $___Ls->ls->rw['act_f_start'],
												'end' => $___Ls->ls->rw['act_f_end']
											];
					?>

					<tr id="<?php echo $___Ls->ls->nxt->id.$___Ls->ls->rw['act_enc'] ?>" act-id-no="<?php echo $___Ls->ls->rw['act_enc']; ?>">
						<td width="1%" <?php echo NWRP ?>><?php echo Spn($___Ls->ls->rw[$___Ls->ino]); ?></td>
						<?php if($__t == 'act'){ ?>
							<td width="5%" align="left" <?php echo $_clr_rw ?>><?php echo bdiv([ 'cls'=>'bx_sds', 'c'=>'-' ]) ?></td>
						<?php } ?>
						<td width="20%" align="left" nowrap="nowrap"><?php echo ShortTx(ctjTx($___Ls->ls->rw['act_tt'],'in'),40,'Pt', true); ?><?php echo bdiv([ 'cls'=>'bx_tp', 'c'=>'-' ]) ?></td>
						<td width="10%" align="left" nowrap="nowrap" style="color:<?php echo $_est->ls->act_est->{$___Ls->ls->rw['act_est']}->clr->vl; ?>;">
							<?php echo ctjTx($_est->ls->act_est->{$___Ls->ls->rw['act_est']}->tt,'in'); ?>
						</td>
						<td width="10%" align="left" nowrap="nowrap"><?php echo bdiv([ 'cls'=>'bx_cnt', 'c'=>'-' ]) ?></td>
						<td width="10%" align="left" nowrap="nowrap"><?php echo bdiv([ 'cls'=>'bx_cnt_d', 'c'=>'-' ]) ?></td>
						<td width="10%" align="left" nowrap="nowrap"><?php echo bdiv([ 'cls'=>'bx_cnt_m', 'c'=>'-' ]) ?></td>
						<td width="10%" align="left" nowrap="nowrap"><?php echo ShortTx(ctjTx($___Ls->ls->rw['act_cod'],'in'),40,'Pt', true); ?></td>
						<td width="1%" align="left" nowrap="nowrap"> <?php echo Spn(_Tme($___Ls->ls->rw['act_f_end'], 'sng')); ?> </td>
						<td width="10%" align="left" nowrap="nowrap"> <?php echo Spn(_Tme($___Ls->ls->rw['act_f_start'], 'sng')); ?> </td>
						<td width="1%" align="left" class="_btn"><?php echo $___Ls->_btn([ 't'=>'mod' ]); ?></td>
					</tr>
					<?php } while ($___Ls->ls->rw = $___Ls->sql->fetch_assoc()); ?>
					<?php $__ls_json_clnd_j = json_encode($__ls_json_clnd); ?>

				</table>

<?php

	// ------- Datos Externos de la actividad -------- //
		$CntJV .=	"

			function __getActJs(){

				$.post('".Fl_Rnd(FL_JSON_GN.__t('act_ext',true))."', { tp:'".$___Ls->gt->tsb."', act:'".implode(',', $__ls_json)."' },

				function(d, status){
					if(d.e == 'ok'){
						if( d.total > 0 ){
							$.each(d.l, function(_k, _v) {

									if(!isN(_v.tot.org)){ $('tr[act-id-no='+_v.id+'] .bx_sds').html( _v.tot.org ); }
									if(!isN(_v.tp)){ $('tr[act-id-no='+_v.id+'] .bx_tp').html( _v.tp ); }
									if(!isN(_v.tot.cnt)){ $('tr[act-id-no='+_v.id+'] .bx_cnt').html( _v.tot.cnt ); }
									if(!isN(_v.tot.cnt_d)){ $('tr[act-id-no='+_v.id+'] .bx_cnt_d').html( _v.tot.cnt_d ); }
									if(!isN(_v.tot.cnt_m)){ $('tr[act-id-no='+_v.id+'] .bx_cnt_m').html( _v.tot.cnt_m ); }

							});
						}
					}
				});
			}

			function __getActClndr(data){

				SUMR_Main.ld.f.cal(()=>{

						try{

							var calendarEl = document.getElementById('calendar');

							var calendar = new FullCalendar.Calendar(calendarEl, {
								headerToolbar: {
									left: 'prevYear,prev,next,nextYear today',
									center: 'title',
									right: 'dayGridMonth,dayGridWeek,dayGridDay'
								},
								selectable: true,
								eventClick: function(e){
									console.log(e.event.id);

									_ldCnt({
										u:'_cnt/_ls/_gn.php?_t=act&_t2=prg&Pr=Dt&_i='+e.event.id+'&&_pop=ok&__rnd='+Math.random(),
										pop:'ok',
										w:'95%',
										h:'95%',
										scrl:'ok' ,
										pf:'main'
									});



								},
								height: '100%',
								expandRows: true,
								navLinks: true,
								dayMaxEvents: true,
								events: data
							});

							calendar.render();

						}catch(e) {
							SUMR_Main.log.f({ m:e });
						}



				});

			}

		";

	$CntWb .= "

		setTimeout(function(){

			__getActJs(); ".$__grph_shw."

		}, 1000);

		$('.btn_bck_lstd').off('click').click(function(){
			$('.cont_cld').hide();
			$('#calendar').html('');
			$('.act_list').show();
		});

		$('.act_clndr').off('click').click(function(){

			$('.cont_cld').show();
			$('.act_list').hide();

			_Rqu({
				t:'act',
				d:'act_clnd',
				t2: '".$___Ls->gt->tsb."',
				_bs:function(){ $('.cont_cld').addClass('__ld'); },
				_cm:function(){ $('.cont_cld').removeClass('__ld'); },
				_cl:function(_r){
					if(!isN(_r)){
						if(!isN(_r.data)){

							var data=[];

							for(var k_r in _r.data){
								var v_r =  _r.data [k_r];
								data.push({
									id:v_r.enc,
									title:v_r.nm,
									start:v_r.f_i,
									end:v_r.f_f,
									color: v_r.attr.clr.vl
								});

							}

							__getActClndr(data);


						}
					}
				}
			});


		});

	";

?>
	<?php $___Ls->_bld_l_pgs(); ?>
	<?php } ?>
	<?php $___Ls->_h_ls_nr(); ?>
	</div>

	<style>
		.act_list{  }
		.act_list .__hdr_mre .act_clndr{ background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>wall-calendar.svg); background-repeat: no-repeat; background-position: center center; background-size: auto 70%; }
		.act_list .__hdr_mre .act_clndr:hover{ background-size: auto 60%; }
		#calendar *::before, #calendar *::after {content: unset;}
		#calendar .fc-icon-chevrons-left:before {content: "\e902";}
		#calendar .fc-icon-chevron-left:before {content: "\e900";}
		#calendar .fc-icon-chevron-right:before {content: "\e901";}
		#calendar .fc-icon-chevrons-right:before {content: "\e903";}
		.btn_bck_lstd{min-height: 35px;background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>listado.svg);background-repeat: no-repeat;background-position: center center;background-size: auto 70%;text-transform: lowercase;font-weight: 700;border: 1px solid #dadbde;padding: 7px 10px 7px 35px;display: block;cursor: pointer; position: absolute;right: 160px;top: 0px;}
		.btn_bck_lstd:hover{padding-left: 50px;padding-right: 50px;}
		.cont_cld{position:relative;height:700px;}
		.cont_cld.__ld{ background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>mail_loader.svg) !important;background-repeat: no-repeat;background-position: center center;background-size: 30px 30px;}
		.lead_data .VTabbedPanels.mny > .TabbedPanelsTabGroup{ width: 5% !important;}
	</style>

	<?php } ?>
	<?php if($___Ls->fm->chk=='ok'){ ?>
		<div class="FmTb">
			<div id="<?php  echo DV_GNR_FM ?>">

				<form method="POST" name="<?php echo $___Ls->fm->id; ?>" target="_self" id="<?php echo $___Ls->fm->id; ?>" >
					<div id="<?php echo $___Ls->fm->fld->id ?>" class="<?php echo DV_GNR_FM_CMP ?> lead_data">
						<?php $___Ls->_bld_f_hdr(); ?>

						<?php

							$__tabs = [
								['n'=>'mdl', 't'=>'act_mdl', 't3'=>$__t3, 'l'=>'Programas'],
								['n'=>'clg', 't'=>'act_org', 't3'=>$__t3, 'l'=>'Colegios'],
								['n'=>'grd', 't'=>'act_grd', 't3'=>$__t3, 'l'=>'Grados'],
								['n'=>'act_cnt', 't'=>'act_cnt', 't3'=>$__t3, 'l'=>'Contactos'],
								['n'=>'act_cnt_up', 't'=>'act_cnt_up', 't3'=>$__t3, 'l'=>'Carga']
							];

							$___Ls->_dvlsfl_all($__tabs);
						?>
						<?php $_id_tbpnl = 'TabPnl_'.Gn_Rnd(20); $CntWb .= " SUMR_Main.bxajx.".$_id_tbpnl." = new Spry.Widget.TabbedPanels('".$_id_tbpnl."' {$_tb_dfl}); "; $CntWb .= _DvLsFl([ 'i'=>$___Ls->tb->eml ]);  ?>
						<div id="<?php echo $_id_tbpnl ?>" class="VTabbedPanels TbGnrl mny lead_data_tb">

							<ul class="TabbedPanelsTabGroup">
					            <?php echo $___Ls->tab->bsc->l ?>
								<?php
									if($___Ls->dt->tot > 0){ echo $___Ls->tab->mdl->l; }
									if($__t == 'act' && $__t2 != 'clg'){ echo $___Ls->tab->clg->l; }
									if($___Ls->dt->tot > 0){ echo $___Ls->tab->grd->l; }
									if($___Ls->dt->tot > 0){ echo $___Ls->tab->act_cnt->l; }
									if($___Ls->dt->tot > 0){ echo $___Ls->tab->act_cnt_up->l; }
								?>
				          	</ul>

						  	<div class="TabbedPanelsContentGroup">
					        	<div class="TabbedPanelsContent">
								    <!-- Inicia Documentos -->
				                    	<div class="ln">
				                        	<div id="<?php echo $___Ls->fm->fld->id ?>" class="<?php echo DV_GNR_FM_CMP ?>">
												<div class="ln_1">
													<div class="col_1">

														<?php echo h2(TX_DTSBSC);

															if($__prfx->tp == 'prg'){ echo h1('Codigo: '.$___Ls->dt->rw['act_cod']); }


															$_dt = GtOrgDt([ 'i'=>$___Ls->gt->isb,'t' => 'enc' ]);

															if(!isN($_dt->id)){
																echo LsOrgSds(['cl'=>'ok','id'=>'org_act', 'v'=>'orgsds_enc', 'va'=>$___Ls->dt->rw['orgsds_enc'], 'rq'=>'2', 'org_tp_k'=>'clg', 'org'=>Php_Ls_Cln($__i) ]);
																$CntWb .= JQ_Ls('org_act');
															}





															echo HTML_inp_tx('act_tt', TX_NM, ctjTx($___Ls->dt->rw['act_tt'],'in'));
															echo HTML_inp_tx('act_pml', TX_PML, ctjTx($___Ls->dt->rw['act_pml'],'in'));

															$l = __Ls(['k'=>'act_est', 'id'=>'act_est', 'va'=>$___Ls->dt->rw['act_est'] , 'ph'=>'Estado']);
	                										echo $l->html; $CntWb .= $l->js;

	                										$l = __Ls(['k'=>'act_lgr', 'id'=>'act_lgr', 'va'=>$___Ls->dt->rw['act_lgr'] , 'ph'=>'Lugar']);
	                										echo $l->html; $CntWb .= $l->js;

															?>
															<div class="ln ln_x3" style="border-radius: 12px;border: 1px dashed #cccccc;padding: 10px 15px;">
																	<div class="col_1" style="border: 10px;margin-right:0;">
																		<?php echo h2(TX_ORD_FIN); ?>

																		<?php
																			echo SlDt(['lmt'=>'no', 'id'=>'act_f_start', 'va'=>date_format(date_create($___Ls->dt->rw['act_f_start']), 'Y-m-d'), 'rq'=>'ok', 'ph'=> TX_ORD_FIN ]);
																			echo SlDt([ 't'=>'hr', 'id'=>'act_h_start', 'va'=>date_format(date_create($___Ls->dt->rw['act_f_start']), 'H:i:s'), 'rq'=>'ok', 'ph'=>TX_HR.' '.TX_PRGMD ]);
																		?>
																	</div>
																	<div class="col_2">
																		<?php echo h2(TX_ORD_FOU); ?>
																		<?php
																			echo SlDt(['lmt'=>'no', 'id'=>'act_f_end', 'va'=>date_format(date_create($___Ls->dt->rw['act_f_end']), 'Y-m-d'), 'rq'=>'ok', 'ph'=> TX_ORD_FOU ]);
																			echo SlDt([ 't'=>'hr', 'id'=>'act_h_end', 'va'=>date_format(date_create($___Ls->dt->rw['act_f_end']), 'H:i:s'), 'rq'=>'ok', 'ph'=>TX_HR.' '.TX_PRGMD ]);
																		?>
																	</div>
																	<div class="col_3">
																		<?php echo h2('Fecha Cierre'); ?>
																		<?php
																			echo SlDt(['lmt'=>'no', 'id'=>'act_f_close', 'va'=>date_format(date_create($___Ls->dt->rw['act_f_close']), 'Y-m-d'), 'rq'=>'ok', 'ph'=> TX_ORD_FOU ]);
																			echo SlDt([ 't'=>'hr', 'id'=>'act_h_close', 'va'=>date_format(date_create($___Ls->dt->rw['act_f_close']), 'H:i:s'), 'rq'=>'ok', 'ph'=>TX_HR.' '.TX_PRGMD ]);
																		?>
																	</div>
																</div>
															<?php

																echo HTML_textarea('act_dsc', 'Descripcion', ctjTx($___Ls->dt->rw['act_dsc'],'in'));
																echo HTML_inp_tx('act_fctx', 'Fecha Texto', ctjTx($___Ls->dt->rw['act_fctx'],'in'));
																echo HTML_inp_tx('act_lat', 'Latitud', ctjTx($___Ls->dt->rw['act_lat'],'in'));
																echo HTML_inp_tx('act_lng', 'Longitud', ctjTx($___Ls->dt->rw['act_lng'],'in'));

															?>
															<div class="fnt_md_fm">
																<div class="_d_tt"> Fuente / Medio / Formulario </div>
																<?php
																	echo LsSis_Md('act_md' ,'id_sismd', $___Ls->dt->rw['act_md'],'', 2, '', ['attr'=>['send-id'=>'sismd_enc']] ); $CntWb .= JQ_Ls('act_md', FM_LS_SLFAC);
																	echo LsCntFnt('act_fnt','id_sisfnt', $___Ls->dt->rw['act_fnt'] , FM_LS_CNTFNT, '', '', ['tp'=>$___Ls->mdlstp->tp]); $CntWb .= JQ_Ls('act_fnt');
																	//echo LsMdlSTpFm([ 'id'=>'act_fm', 'v'=>'id_mdlstpfm', 'va'=>$___Ls->dt->rw['act_fm'] , 'ph'=>'Formulario' ]); $CntWb .= JQ_Ls('act_fm');
																	echo LsMdlGen([ 'id'=>'act_mdlgen', 'v'=>'id_mdlgen', 'va'=>$___Ls->dt->rw['act_mdlgen'], 'bd'=>DB_CL, 'prfx'=>'id_mdlgen', 'tp'=>$___Ls->mdlstp->id ]); $CntWb .= JQ_Ls('act_mdlgen');
																?>
															</div>
													</div>
													<div class="col_2">
														<?php
															echo LsCdOld(['id'=>'act_cd', 'v'=>'id_siscd', 'va'=>$___Ls->dt->rw['act_cd'], 'rq'=>'ok' ]);
															$CntWb .= JQ_Ls('act_cd',FM_LS_SLCD);

															echo LsUs('act_us','id_us', $___Ls->dt->rw['act_us'], '', 1);
															$CntWb .= JQ_Ls('act_us','');

															echo h2(TX_VWONL). '<a href="'.DMN_ACT.$___Ls->dt->rw['act_enc'].'/qr/" target="_blank" class="___onl_btn">Ir a URL</a>';

														if($___Ls->dt->tot > 0){


															echo h2('Tipo Actividad');
															?>
																<div class="cl_mdl_act_dsh dsh_cnt">
																	<div class="_c _c1 _anm _scrl">
																		<div class="_wrp">
																			<ul id="bx_mdl_<?php echo $__Rnd; ?>" class="_ls _anm dls"></ul>
																		</div>
																	</div>
																</div>
															<?php

																$CntJV .= "

																	var SUMR_Dsh_Act = {
																		acttp:{}
																	};

																	function Dom_Rbld(){

																		var __mdls_bx_act_itm = $('#bx_mdl_".$__Rnd." > li.itm ');

																		__mdls_bx_act_itm.not('.sch').off('click').click(function(){

																			$(this).hasClass('on') ? est = 'del' : est = 'ok';
																			var _id = $(this).attr('rel');

																			_Rqu({
																				t:'act_tp',
																				d:'act',
																				est: est,
																				_id_clg : '".Php_Ls_Cln($__i)."',
																				_id_act : '".Php_Ls_Cln($_i)."',
																				_id_acttp : _id,
																				_bs:function(){ $('.cl_mdl_act_dsh').addClass('_ld'); },
																				_cm:function(){ $('.cl_mdl_act_dsh').removeClass('_ld'); },
																				_cl:function(_r){ if(!isN(_r)){ if(!isN(_r)){ ActSet(_r); } } }
																			});

																		});

																		SUMR_Main.LsSch({ str:'#sch_act_".$___Ls->id_rnd."', ls:__mdls_bx_act_itm });
																	}

																	function ActMdl_Html(){
																		var __mdls_bx_act = $('#bx_mdl_".$__Rnd."');

																		__mdls_bx_act.html('');
																		__mdls_bx_act.append('<li class=\"sch\">".HTML_inp_tx('sch_act_'.$___Ls->id_rnd, TX_SEARCH, '')."</li>');

																		if(!isN(SUMR_Dsh_Act.acttp['ls'])){
																			$.each(SUMR_Dsh_Act.acttp['ls'], function(k, v) {
																				if(!isN(v.est) && v.est >= 1){ var _cls = 'on'; }else{ var _cls = 'off'; }
																				__mdls_bx_act.append('<li class=\"_anm itm '+_cls+'\" sch-id=\"'+v.enc+'\" rel=\"'+v.enc+'\" ><span>'+v.nm+'</span></li>');
																			});
																		}

																		Dom_Rbld();
																	}

																	function ActSet(p){
																		if( !isN(p) ){

																			if( !isN(p.mdl.tp.act) ){
																				SUMR_Dsh_Act.acttp['ls'] = p.mdl.tp.act.ls;
																				SUMR_Dsh_Act.acttp['tot'] = p.mdl.tp.act.tot;
																			}

																			ActMdl_Html();
																		}
																	}
																	";


														}
														if(($___Ls->dt->tot > 0)){

															echo $___Ls->qry->tot;

															$CntWb .= "

																_Rqu({
																	t:'act_tp',
																	d:'act',
																	_id_clg : '".Php_Ls_Cln($__i)."',
																	_id_act : '".Php_Ls_Cln($_i)."',
																	_t3 : '".$__t3."',
																	_cl:function(_r){
																		if(!isN(_r)){
																			ActSet(_r);
																		}
																	}
																});
															";
														}
														?>

													</div>
												</div>
											</div>
				                    	</div>
									<!-- Finaliza Documentos -->
					        	</div>
					        	<div class="TabbedPanelsContent">
								    <!-- Inicia Documentos -->
				                    	<div class="ln">
											<?php echo $___Ls->tab->mdl->d ?>
				                    	</div>
									<!-- Finaliza Documentos -->
					        	</div>
					        	<?php if($__t == 'act' && $__t2 != 'clg'){  ?>
									<div class="TabbedPanelsContent">
									    <!-- Inicia Documentos -->
					                    	<div class="ln">
												<?php echo $___Ls->tab->clg->d ?>
					                    	</div>
										<!-- Finaliza Documentos -->
						        	</div>
						        <?php } ?>
								<div class="TabbedPanelsContent">

									<!-- Inicia Documentos -->

									<div class="ln">
										<?php echo $___Ls->tab->grd->d ?>
									</div>

									<!-- Finaliza Documentos -->

								</div>
								<div class="TabbedPanelsContent">

									<!-- Inicia Documentos -->

									<div class="ln">
										<?php echo $___Ls->tab->act_cnt->d ?>
									</div>

									<!-- Finaliza Documentos -->

								</div>
								<div class="TabbedPanelsContent">

									<!-- Inicia Documentos -->

									<div class="ln">
										<?php echo $___Ls->tab->act_cnt_up->d ?>
									</div>

									<!-- Finaliza Documentos -->

								</div>
						</div>


					</div>
				</form>
			</div>
		</div>
	<?php } ?>
<?php } ?>