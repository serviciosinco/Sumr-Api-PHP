<?php
if(class_exists('CRM_Cnx')){

	$___Ls->cnx->cl = 'ok';
	$___Ls->flt = 'ok';
	$___Ls->edit->w = 500;
	$___Ls->edit->h = '80%';


	$___Ls->sch->f = 'id_cnt, cnt_nm, cnt_ap';
	$___Ls->sch->m = ' || (
							id_cnt IN (SELECT cnteml_cnt FROM '.TB_CNT_EML.' WHERE cnteml_eml LIKE \'%[-SCH-]%\' ) ||
							id_cnt IN (SELECT cntdc_cnt FROM '.TB_CNT_DC.' WHERE cntdc_dc LIKE \'%[-SCH-]%\' ) ||
							id_cnt IN (SELECT cnttel_cnt FROM '.TB_CNT_TEL.' WHERE cnttel_tel LIKE \'%[-SCH-]%\' )
						)';

	$___Ls->edit->scrl = 'ok';
	$___Ls->grph->tot = 2;

	$___Ls->_strt();
	$__tb = Php_Ls_Cln($_GET['Tb']);


	if(!isN($___Ls->gt->i)){

		$___Ls->qrys = sprintf("SELECT *
								FROM ".TB_CNT."
									 LEFT JOIN ".TB_CNT_PLCY." ON (cntplcy_cnt = id_cnt AND cntplcy_sndi=1)
									 LEFT JOIN "._BdStr(DBM).TB_CL_PLCY." ON (cntplcy_plcy = id_clplcy AND clplcy_e=1)
								WHERE ".$___Ls->ik." = %s
								LIMIT 1", GtSQLVlStr($___Ls->gt->i, "text"));

	}elseif($___Ls->_show_ls == 'ok'){

		if($___Ls->gt->tsb == 'tp'){

			if(!isN($___Ls->gt->tsb_m)){

				$___Ls->qry_f .= ' AND id_cnt IN (
											SELECT cnttp_cnt
											FROM '.TB_CNT_TP.'
												 INNER JOIN '._BdStr(DBM).TB_SIS_CNT_TP.' ON cnttp_tp = id_siscnttp
												 INNER JOIN '._BdStr(DBM).TB_SIS_CNT_TP_GRP.' ON siscnttp_grp = id_siscnttpgrp
											WHERE siscnttpgrp_key = "'.$___Ls->gt->tsb_m.'"
									) ';

				$___SisBdDt = GtCntTpGrpDt([ 't'=>'key', 'id'=>$___Ls->gt->tsb_m ]);
				$___Ls->tt = $___SisBdDt->tt;
			}

			if(!isN($___Ls->gt->tsb_d)){

				$___Ls->qry_f .= ' AND id_cnt IN (
											SELECT cnttp_cnt
											FROM '.TB_CNT_TP.'
												 INNER JOIN '._BdStr(DBM).TB_SIS_CNT_TP.' ON cnttp_tp = id_siscnttp
											WHERE siscnttp_key = "'.$___Ls->gt->tsb_d.'"
									) ';

				$___CntTpDt = GtCntTpDt([ 't'=>'key', 'id'=>$___Ls->gt->tsb_d ]);
				$___Ls->tt = $___CntTpDt->tt;
			}
		}



		if($___Ls->gt->tsb == 'bd'){

			if(!isN($___Ls->gt->tsb_m)){

				$___Ls->qry_f .= ' AND id_cnt IN (
											SELECT cntbd_cnt
											FROM '.TB_CNT_BD.'
												 INNER JOIN '._BdStr(DBM).TB_SIS_BD.' ON cntbd_bd = id_sisbd
											WHERE sisbd_key = "'.$___Ls->gt->tsb_m.'"
									) ';

				$___SisBdDt = GtSisBdDt([ 't'=>'key', 'id'=>$___Ls->gt->tsb_m ]);
				$___Ls->tt = $___SisBdDt->tt;
			}

			if(!isN($___Ls->gt->tsb_d)){

				$___Ls->qry_f .= ' AND id_cnt IN (
											SELECT cnttp_cnt
											FROM '.TB_CNT_TP.'
												 INNER JOIN '._BdStr(DBM).TB_SIS_CNT_TP.' ON cnttp_tp = id_siscnttp
											WHERE siscnttp_key = "'.$___Ls->gt->tsb_d.'"
									) ';

				$___CntTpDt = GtCntTpDt([ 't'=>'key', 'id'=>$___Ls->gt->tsb_d ]);
				$___Ls->tt = $___CntTpDt->tt;
			}
		}




		if(!isN($___Ls->_fl->fu1) && !isN($___Ls->_fl->fu2)){

			$___Ls->qry_f .= ' AND DATE_FORMAT(cnt_fa, "%Y-%m-%d") BETWEEN "'.$___Ls->_fl->fu1.'" AND "'.$___Ls->_fl->fu2.'" ';

		}elseif(!isN($___Ls->_fl->fu1)){

			$___Ls->qry_f .= ' AND DATE_FORMAT(cnt_fa, "%Y-%m-%d") = "'.$___Ls->_fl->fu1.'" ';

		}elseif(!isN($___Ls->_fl->fu2)){

			$___Ls->qry_f .= ' AND DATE_FORMAT(cnt_fa, "%Y-%m-%d") = "'.$___Ls->_fl->fu2.'" ';

		}


		if(defined('SISUS_PLCY') && !ChckSESS_superadm()){

			$___Ls->qry_f .= ' AND id_clplcy IN ('.SISUS_PLCY.') ';

		}


		$Ls_Dc = ", 	(SELECT GROUP_CONCAT( CONCAT(cntdc_dc) SEPARATOR ' | ')
						FROM ".TB_CNT_DC."
							 INNER JOIN "._BdStr(DBM).TB_SIS_SLC." ON cntdc_tp = id_sisslc
						WHERE cntdc_cnt = id_cnt) AS __dc ";

		$Ls_Eml = ", 	(SELECT GROUP_CONCAT( CONCAT(cnteml_eml) SEPARATOR ' | ')
						FROM ".TB_CNT_EML."
						WHERE cnteml_cnt = id_cnt) AS __eml ";


		$Ls_Whr = "	FROM ".TB_CNT."
						 LEFT JOIN ".TB_CNT_PLCY." ON cntplcy_cnt = id_cnt
						 LEFT JOIN ".TB_CNT_TP." ON cnttp_cnt = id_cnt
						 LEFT JOIN "._BdStr(DBM).TB_CL_PLCY." ON cntplcy_plcy = id_clplcy
						 LEFT JOIN "._BdStr(DBM).TB_SIS_CNT_TP." ON cnttp_tp = id_siscnttp
					WHERE ".$___Ls->ino." != '' ".$___Ls->sch->cod." ".$___Ls->qry_f." ";

		$___Ls->qrys = "SELECT *,
								(SELECT COUNT(*) FROM ".TB_CNT_CREF." WHERE cntcref_cnt_ref = id_cnt ) AS __tot_cref,
								(SELECT COUNT(DISTINCT id_cnt) $Ls_Whr) AS ".QRY_RGTOT."
								$Ls_Dc $Ls_Eml
						$Ls_Whr
						GROUP BY id_cnt
						ORDER BY ".$___Ls->ino." DESC
					";

	}

	$___Ls->_bld();


	if( isset($_GET['Sv']) && ($_GET['Sv']=='ok') ){ echo $___Ls->qrys; }

?>
<?php if($___Ls->ls->chk=='ok'){ ?>
<?php $___Ls->_bld_l_hdr();


	$CntWb .= "


		SUMR_Main.bxajx.__grph_fl = { fl:{ f:".json_encode($___Ls->c_f_g)."} };


		_ldCnt({
			u:'".Fl_Rnd(FL_GRPH_GN.__t($___Ls->gt->t, true).$_adsch.$___Ls->ls->vrall)."&_h=300&_t2=".$___Ls->gt->tsb."&_t3=".$___Ls->gt->tsb_m."&_tp=grph_1&_g_r=".$___Ls->id_rnd."' ,
			c:'bx_grph_".$___Ls->id_rnd."_1',
			d:SUMR_Main.bxajx.__grph_fl,
			trs:false,
			anm:'no',
			_cl:function(){

				_ldCnt({
					u:'".Fl_Rnd(FL_GRPH_GN.__t($___Ls->gt->t, true).$_adsch.$___Ls->ls->vrall)."&_h=300&_t2=".$___Ls->gt->tsb."&_t3=".$___Ls->gt->tsb_m."&_tp=grph_2&_g_r=".$___Ls->id_rnd."' ,
					c:'bx_grph_".$___Ls->id_rnd."_2',
					d:SUMR_Main.bxajx.__grph_fl,
					trs:false,
					anm:'no',
					_cl:function(){


					}
				});

			}
		});



	";
?>

<?php if(($___Ls->qry->tot > 0)){   ?>

<table width="100%" border="0" cellpadding="0" cellspacing="0" class="Ls_Rg">
	<thead>
        <tr>
        	<th width="1%" <?php echo NWRP ?>><?php echo TX_FM_No ?></th>
            <th <?php echo NWRP ?>><?php echo TT_FM_NM ?></th>
            <th <?php echo NWRP ?>><?php echo TT_FM_AP ?></th>
            <th <?php echo NWRP ?>><?php echo TT_FM_ID ?></th>
            <th <?php echo NWRP ?>><?php echo TX_EMAIL ?></th>
            <th <?php echo NWRP ?>><?php echo TX_CREF ?></th>
            <th width="1%" <?php echo NWRP ?>><?php echo TX_HBSACCPT; ?></th>
            <th width="1%" <?php echo NWRP ?>><?php echo TX_FI; ?></th>
            <th width="1%" <?php echo NWRP ?>></th>
        </tr>
	</thead>
	<tbody>
		<?php

			do {

				$_fnm = _plcy_scre([
							't'=>'nm',
							'nm'=>$___Ls->ls->rw['cnt_nm'],
							'ap'=>$___Ls->ls->rw['cnt_nm'],
							'plcy'=>[ 'e'=>$___Ls->ls->rw['cntplcy_sndi'] ]
						])

		?>
        <tr>
            <?php $_clr_rw = NULL; $_clr_rw = ' style="background-color:'.$___Ls->ls->rw['siscntest_clr_bck'].';" '; ?>

            <td width="1%" <?php echo NWRP.$_clr_rw ?>><?php echo Spn($___Ls->ls->rw[$___Ls->ino]); ?></td>
            <td align="left" <?php echo $_clr_rw ?>><?php echo $_fnm['first']; ?></td>
            <td align="left" <?php echo $_clr_rw ?>><?php echo $_fnm['last']; ?></td>
            <td align="left" <?php echo $_clr_rw ?>>
				<?php
					echo _plcy_scre([
						'v'=>$___Ls->ls->rw['__dc'],
						'plcy'=>[ 'e'=>$___Ls->ls->rw['cntplcy_sndi'] ]
					])
				?>
			</td>
            <?php

			?>
            <td align="left" <?php echo $_clr_rw ?>><?php echo Spn(
																_plcy_scre([
																	't'=>'eml',
																	'v'=>$___Ls->ls->rw['__eml'],
																	'plcy'=>[ 'e'=>$___Ls->ls->rw['cntplcy_sndi'] ]
																]),'','_f'
															);
													?>
			</td>
            <td align="left" <?php echo $_clr_rw ?>><?php echo Spn(ctjTx($___Ls->ls->rw['__tot_cref'],'in'),'','_f'); ?></td>
			<td align="left" <?php echo NWRP.$_clr_rw ?>><?php echo Spn(mBln($___Ls->ls->rw['cntplcy_sndi']), '', 'chk '.mBln($___Ls->ls->rw['cntplcy_sndi'])); ?></td>
            <td align="left" <?php echo NWRP.$_clr_rw ?>><?php echo Spn(_Tme($___Ls->ls->rw['cnt_fi'], 'sng')); ?></td>
            <td width="1%" align="left" class="_btn"><?php echo $___Ls->_btn([ 't'=>'dtl' ]); ?></td>

        </tr>
        <?php } while ($___Ls->ls->rw = $___Ls->sql->fetch_assoc()); ?>
  	</tbody>
</table>
<?php $___Ls->_bld_l_pgs(); ?>
<?php } ?>
<?php $___Ls->_h_ls_nr(); ?>
<?php } ?>

<?php if($___Ls->fm->chk=='ok'){

	$____plcy = GtCntPlcyLs([ 'cnt'=>$___Ls->dt->rw['id_cnt'], 'e'=>'on' ]);
?>
<div class="FmTb">
	<div id="<?php echo $___Ls->fm->bx->id ?>" class="<?php echo DV_GNR_FM_BX ?>" >
  	<?php

	  	$__idtp_bsc = '_bsc'.$___Ls->id_rnd;
		$__idtp_eml = '_eml'.$___Ls->id_rnd;
		$__idtp_dc = '_dc'.$___Ls->id_rnd;
		$__idtp_tel = '_tel'.$___Ls->id_rnd;
		$__idtp_cntrlc = '_tp'.$___Ls->id_rnd;
		$__idtp_cntbd = '_bd'.$___Ls->id_rnd;
		$__idtp_cntcd = '_cd'.$___Ls->id_rnd;
		$__idtp_cntprnt = '_prnt'.$___Ls->id_rnd;

		$__org_tp = __LsDt([ 'k'=>'org_tp', 'cl' => DB_CL_ID ]);

		$__tabs = [
				['n'=>'eml', 't'=>'cnt_eml', 'l'=>TX_EMAIL],
				['n'=>'dc', 't'=>'cnt_dc', 'l'=>TX_DCMTSID],
				['n'=>'tel', 't'=>'cnt_tel', 'l'=>TX_CLRS],
				['n'=>'tp', 't'=>'cnt_tp', 'l'=>TX_VNC],
				['n'=>'bd', 't'=>'cnt_bd', 'l'=>TX_BD],
				['n'=>'cd', 't'=>'cnt_cd', 'l'=>TT_FM_CD],
				['n'=>'prnt', 't'=>'cnt_prnt', 'l'=>TX_PRNT1],
				['n'=>'ec', 't'=>'cnt_ec', 'l'=>'Pushmails']
			];

		foreach($__org_tp->ls->org_tp as $_k=>$_v){
			$__tabs[] = ['n'=>$_v->key->vl, 't'=>'cnt_org_sds', 't2'=>$_v->key->vl, 'l'=>$_v->tt, 'bimg'=>$_v->img ];
		}

		$___Ls->_dvlsfl_all($__tabs);


	?>
    <form method="POST" name="<?php echo $___Ls->fm->id; ?>" target="_self" id="<?php echo $___Ls->fm->id; ?>" >
      <?php $___Ls->_bld_f_hdr(); ?>

      <div id="<?php echo $___Ls->fm->fld->id ?>" class="<?php echo DV_GNR_FM_CMP ?> lead_data">

        <?php $_id_tbpnl = 'TabPnl_'.Gn_Rnd(20); $CntWb .= " SUMR_Main.bxajx.".$_id_tbpnl." = new Spry.Widget.TabbedPanels('".$_id_tbpnl."' {$_tb_dfl}); "; $CntWb .= _DvLsFl([ 'i'=>$___Ls->tb->eml ]);  ?>
        <div id="<?php echo $_id_tbpnl ?>" class="VTabbedPanels TbGnrl mny lead_data_tb">
          	<ul class="TabbedPanelsTabGroup">
				<?php echo $___Ls->tab->bsc->l ?>
	            <?php echo $___Ls->tab->eml->l ?>
	            <?php echo $___Ls->tab->dc->l ?>
	            <?php echo $___Ls->tab->cd->l ?>
	            <?php echo $___Ls->tab->tel->l ?>
	            <?php echo $___Ls->tab->tp->l ?>
				<?php echo $___Ls->tab->bd->l ?>
				<?php echo $___Ls->tab->prnt->l ?>
				<?php echo $___Ls->tab->ec->l ?>
				<?php foreach($__org_tp->ls->org_tp as $_k=>$_v){ ?>
		            <?php echo $___Ls->tab->{$_v->key->vl}->l ?>
	            <?php } ?>

          	</ul>
		  	<div class="TabbedPanelsContentGroup">
	        	<div class="TabbedPanelsContent">
				<div class="ln_1">
	                    <div class="col_1">

	                      	<div class="_cldstars">
		                      	<?php
					             	$__sis_cld = LsSis_Cld([ 'id'=>'cnt_cld', 'v'=>'enc', 'va'=>$___Ls->dt->rw['cnt_cld'], 'rq'=>2, 'dsbl'=>'ok' ]);
									echo $__sis_cld->html; $CntWb .= $__sis_cld->js;
					            	?>
	                      	</div>

						  	<?php if($_bxpop == 'ok'){ ?><input id="___pop" name="___pop" type="hidden" value="ok" /><?php } ?>
							<?php
								if($___Ls->dt->rw['cntplcy_sndi'] == 1 || $___Ls->dt->tot == 0){
									echo HTML_inp_tx('cnt_nm', TT_FM_NM, ctjTx($___Ls->dt->rw['cnt_nm'],'in'));
								}else{
									echo h2( '- '._Cns('TX_ANYMUS').' -' );
								}
							?>
							<?php
								if($___Ls->dt->rw['cntplcy_sndi'] == 1 || $___Ls->dt->tot == 0){
									echo HTML_inp_tx('cnt_ap', TT_FM_AP, ctjTx($___Ls->dt->rw['cnt_ap'],'in'));
								}
							?>
						  	<?php
							  	if($___Ls->dt->tot == 0){
							  		echo HTML_inp_tx('cnteml_eml', TT_FM_EML, ctjTx($___Ls->dt->rw['cnteml_eml'],'in'), FMRQD_EM);
							  	}
							?>

							<?php
								if($___Ls->dt->rw['cntplcy_sndi'] == 1 || $___Ls->dt->tot == 0){
									echo HTML_inp_tx('cnt_dir', TX_DIRC, ctjTx($___Ls->dt->rw['cnt_dir'],'in'));
								}
							?>
							<?php
								if($___Ls->dt->rw['cntplcy_sndi'] == 1 || $___Ls->dt->tot == 0){
									echo SlDt([ 'id'=>'cnt_fn', 'va'=>$___Ls->dt->rw['cnt_fn'], 'rq'=>'no', 'ph'=>TX_FCHNCM, 'cls'=>CLS_CLND, 'mth'=>'ok', 'yr'=>'ok' ]);
								}
							?>
						  	<?php
	                        		$l = __Ls([ 'k'=>'sx', 'id'=>'cnt_sx', 'va'=>$___Ls->dt->rw['cnt_sx'] , 'ph'=>FM_LS_SISSX ]);
								echo $l->html; $CntWb .= $l->js;
						  	?>
	                    	</div>
	                    	<div class="col_2">

	                      	<?php echo h2(MDL_HBSDTA); ?>
							<?php

								if($___Ls->dt->tot == 0){

									$__Cl = new CRM_Cl([ 'cl'=>DB_CL_ID ]);
									$___plcy_main = $__Cl->plcy_main([ 'cl'=>DB_CL_ID ]);
									echo LsPlcy('_cnt_plcy', 'clplcy_enc', $___plcy_main->enc , FM_LS_PLCY, 'ok', '', [ 'cl'=>CL_ENC ] ); $CntWb .= JQ_Ls('_cnt_plcy', '');

								}

								if(!isN($___Ls->gt->tsb) && $___Ls->gt->tsb == 'bd' && !isN($___Ls->gt->tsb_m)){
									$___SisBdDt = GtSisBdDt([ 't'=>'key', 'id'=>$___Ls->gt->tsb_m ]);
									if(!isN($___SisBdDt->id)){
										echo HTML_inp_hd('cnt_bd', $___SisBdDt->id);
									}
								}

								if($____plcy->tot > 0){

									foreach($____plcy->ls as $plcy_k=>$plcy_v){

										if($plcy_v->tot>0){ $cls='on'; $cls_v=1; }else{ $cls='off'; $cls_v=2; }
										$__dattr = ' data-cnt="'.$___Ls->dt->rw['cnt_enc'].'" data-plcy="'.$plcy_v->enc.'" ';

										$__plcy_li .= li(
														bdiv([
															'cls'=>'wrp',
															'c'=>
																bdiv([
																	'c'=>$plcy_v->nm.Spn(TX_VRSN.' '.$plcy_v->v),
																	'cls'=>'tt'
																]).
																bdiv([
																	'c'=>'	<button class="on _anm" '.$__dattr.'>Recibir</button>
																			<button class="off _anm" '.$__dattr.'>No recibir</button>',
																	'cls'=>'opt'
																])
														]),
														$cls,
														'',
														'plcy_'.$___Ls->dt->rw['cnt_enc'].'_'.$plcy_v->enc
													);
									}

									echo ul($__plcy_li, '_plcy_ls');
								}

							?>


	                    </div>
	              	</div>
				</div>
				<div class="TabbedPanelsContent">
	                <!-- Inicia Documentos -->
	                    <div class="ln">
	                        <?php echo $___Ls->tab->eml->d ?>
	                    </div>
	                <!-- Finaliza Documentos -->
	            </div>

	            <div class="TabbedPanelsContent">
	                <!-- Inicia Email -->
	                    <div class="ln">
	                        <?php echo $___Ls->tab->dc->d ?>
	                    </div>
	                <!-- Finaliza Email -->
	            </div>
	               <div class="TabbedPanelsContent">
	                <!-- Inicia ciudad -->
	                    <div class="ln">
	                        <?php echo $___Ls->tab->cd->d ?>
	                    </div>
	                <!-- Finaliza ciudad -->
	            </div>



	            <div class="TabbedPanelsContent">
	          		<!-- Inicia Documentos -->
	                    <div class="ln">
	                        <?php echo $___Ls->tab->tel->d ?>
	                    </div>
	                <!-- Finaliza Documentos -->
	            </div>

	            <div class="TabbedPanelsContent">
	                <!-- Inicia Relacion -->
	                    <div class="ln">
	                        <?php echo $___Ls->tab->tp->d ?>
	                    </div>
	                <!-- Finaliza Sectores Economicos -->
	            </div>
	            <div class="TabbedPanelsContent">
	                <!-- Inicia Sectores Economicos -->
	                    <div class="ln">
	                        <?php echo $___Ls->tab->bd->d ?>
	                    </div>
	                <!-- Finaliza Sectores Economicos -->
	            </div>

	             <div class="TabbedPanelsContent">
	                <!-- Inicia parentesco -->
	                    <div class="ln">
	                        <?php echo $___Ls->tab->prnt->d ?>
	                    </div>
	                <!-- Finaliza parentesco -->
	            </div>
	            <div class="TabbedPanelsContent">
	                <!-- Inicia parentesco -->
	                    <div class="ln">
	                        <?php echo $___Ls->tab->ec->d ?>
	                    </div>
	                <!-- Finaliza parentesco -->
	            </div>
	            <?php foreach($__org_tp->ls->org_tp as $_k=>$_v){ ?>
	            <div class="TabbedPanelsContent">
	                <!-- Inicia <?php echo $_v->tt; ?> -->
	                    <div class="ln">
	                        <?php echo $___Ls->tab->{$_v->key->vl}->d ?>
	                   	</div>
		            <!-- Finaliza <?php echo $_v->tt; ?>  -->
		        </div>
		        <?php } ?>


          	</div>

        </div>


      </div>
    </form>
  </div>
</div>

<?php


	if(_ChckMd('chck_snd_i')){

		$CntWb .= "

			$('.lead_data_tb ._plcy_ls > li .opt button').off('click').click(function(e){

				e.preventDefault();

				if(e.target != this){

			    		e.stopPropagation(); return false;

				}else{

					if( $(this).hasClass('on') ){
						var _tx='¿El usuario desea recibir nuestra información?';
						var _tp = 'info';
						var _clr = '#64b764';
						var _e = 1;
						var _e_c = 'on';
					}else{
						var _tx = '¿El usuario no desea recibir mas información?';
						var _tp = 'warning';
						var _clr = '#a12424';
						var _e = 2;
						var _e_c = 'off';
					}

					var _this = $(this);
					var _cnt = $(this).attr('data-cnt');
					var _plcy = $(this).attr('data-plcy');

					swal({
						title: '".TX_HBSACCPT."',
						text: _tx,
						type: _tp,
						showCancelButton: true,
						confirmButtonColor: _clr,
						confirmButtonText:'".TX_ACPT."',
						cancelButtonText:'".TX_CNCLR."',
						showLoaderOnConfirm: true,
						closeOnConfirm: false
					},
					function(){

						_Rqu({
							t:'cnt_sndi',
							plcy:_plcy,
							cnt:_cnt,
							est:_e,
							_bs:function(){  },
							_cm:function(){  },
							_cl:function(_r){
								if(!isN(_r)){
									if(!isN(_r.e) && _r.e=='ok'){
										swal('Cambio Exitoso', '".TX_APROEXT."', 'success');
										$('#plcy_'+_cnt+'_'+_plcy).removeClass('on off').addClass(_e_c);
									}else{
										swal('Error', '".TX_NSAPRB."','error');
									}
								}
							}
						});

					});

				}

			});


		";

    }else{


		$CntWb .= "

			$('.lead_data_tb ._plcy_ls > li .opt button').off('click').click(function(e){

				e.preventDefault();

				if(e.target != this){
			    		e.stopPropagation(); return false;
				}else{
					swal({
						title: '".TX_HBSACCPT."',
						text: 'No cuenta con este permiso',
						type: 'warning',
						confirmButtonColor: '#a12424',
						confirmButtonText: 'Entendido',
						closeOnConfirm: true
					});
				}
			});


		";


	}


?>


<style>

	.lead_data{ width: 95%; margin-left: auto; margin-right: auto; margin-top: 40px; }


	.lead_data_tb ._cldstars{ border: 2px dashed rgba(207, 213, 215, 1); padding: 10px 15px !important; margin-bottom: 20px; display: block; width: 100%; border-radius:10px; -moz-border-radius:10px; -webkit-border-radius:10px; }

	.lead_data._new .col_1{ display: block; width: 100%; border: none; }
	.lead_data._new .col_2,
	.lead_data._new .__rtio,
	.lead_data._new h2{ display: none; }

</style>

<?php } ?>
<?php } ?>