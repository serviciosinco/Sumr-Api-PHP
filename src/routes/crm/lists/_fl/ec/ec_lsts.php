<?php
if(class_exists('CRM_Cnx')){

	$___Ls->cnx->cl = 'ok';
	$___Ls->tpr = 'ec_lsts';
	$___Ls->sch->f = 'id_eclsts, eclsts_nm';
	$___Ls->flt = 'ok';
	$___Ls->ing->vrall = [ADM_LNK_OP];
	$___Ls->ino = 'id_eclsts';
	$___Ls->ik = 'eclsts_enc';
	$___Ls->new->w = 400;
	$___Ls->new->h = 300;
	$___Ls->edit->w = 700;
	$___Ls->edit->h = 600;

	$___Ls->_strt();

	if(!isN($___Ls->mdlstp->id)){

		$_f_tp = " AND _m_eclsts.id_eclsts IN (	SELECT eclststp_lsts
												FROM "._BdStr(DBM).TB_EC_LSTS_TP."
												WHERE eclststp_lsts = id_eclsts AND eclststp_tp = ".$___Ls->mdlstp->id."
											) ";

	}


	if(!isN($___Ls->gt->i)){

		$___Ls->qrys = sprintf("SELECT *,
										"._QrySisSlcF([ 'als'=>'s', 'als_n'=>'sender' ]).",
										".GtSlc_QryExtra([ 't'=>'fld', 'p'=>'sender', 'als'=>'s' ])."

								FROM "._BdStr(DBM).TB_EC_LSTS."
									 ".GtSlc_QryExtra([ 't'=>'tb', 'col'=>'eclsts_sndr', 'als'=>'s' ])."

								WHERE eclsts_enc = %s
								LIMIT 1", GtSQLVlStr($_GET['_i'], "text"));

	}elseif($___Ls->_show_ls == 'ok'){

		if(!isN($___Ls->_fl->fk->id_clare)){

			if(is_array($___Ls->_fl->fk->id_clare)){
				$__all_are = implode(',', $___Ls->_fl->fk->id_clare);
			}else{
				$__all_are = "'".$___Ls->_fl->fk->id_clare."'";
			}

			$___Ls->qry_f .= ' AND EXISTS( SELECT *
										FROM '._BdStr(DBM).TB_EC_LSTS_ARE.'
											 INNER JOIN '._BdStr(DBM).TB_CL_ARE.' ON eclstsare_clare = id_clare
										WHERE eclstsare_eclsts = _m_eclsts.id_eclsts AND id_clare IN ('.$__all_are.') AND clare_est = 1
									) ';
		}


		if(_ChckMd('snd_ec_lsts_all') ){

			$__fl_all = " || _m_eclsts.id_eclsts  NOT IN ( 	SELECT eclstsare_eclsts
			            									FROM "._BdStr(DBM).TB_EC_LSTS_ARE."
														)
	            		";

		}

		if(!ChckSESS_superadm() && !_ChckMd('snd_ec_lsts_all') ){
            $__fl .= "AND (
            				_m_eclsts.id_eclsts IN ( 	SELECT eclstsare_eclsts
			            								FROM "._BdStr(DBM).TB_EC_LSTS_ARE."
			            								WHERE eclstsare_clare IN (".SISUS_ARE.")
			            							) {$__fl_all}
						)
            		";
        }


		$Ls_Whr = "	FROM "._BdStr(DBM).TB_EC_LSTS." AS _m_eclsts
						 INNER JOIN "._BdStr(DBM).TB_CL." AS _m_cl ON _m_eclsts.eclsts_cl = _m_cl.id_cl
					WHERE _m_eclsts.id_eclsts != '' $_f_tp $__fl ".$___Ls->sch->cod." AND _m_cl.cl_enc = '".DB_CL_ENC."' $___Ls->qry_f
					ORDER BY _m_eclsts.id_eclsts DESC";


		$___Ls->qrys_tot = "SELECT COUNT( DISTINCT _m_eclsts.id_eclsts ) AS ".QRY_RGTOT." $Ls_Whr";


		$___Ls->qrys = "SELECT * $Ls_Whr";

	}

	$___Ls->_bld();

?>
<?php if($___Ls->ls->chk=='ok'){ ?>
<?php $___Ls->_bld_l_hdr(); ?>
<?php if(($___Ls->qry->tot > 0)){ ?>

<table width="100%" border="0" cellpadding="0" cellspacing="0" class="Ls_Rg LsRgNw">
  	<tbody>
		<?php do { ?>
		<?php

			$__are = GtEcLstsAreLs([ 'eclsts'=>$___Ls->ls->rw['id_eclsts'] ]);
			$__ls_json[] = $___Ls->ls->rw['eclsts_enc'];
		?>
        <tr eclsts-id-no="<?php echo $___Ls->ls->rw['id_eclsts']; ?>">
	        <td align="left" <?php echo $_clr_rw ?> width="1%">
	            <?php
		        	echo Spn($___Ls->ls->rw['id_eclsts']);
	            ?>
	        </td>
            <td align="left" <?php echo $_clr_rw ?> class="__sgm_ls"><?php echo h2(ctjTx($___Ls->ls->rw['eclsts_nm'],'in')); if(!isN($__are->html)){ echo $__are->html; } ?></td>
            <td align="center" class="_cntr" <?php echo NWRP.$_clr_rw ?> ><?php echo bdiv([ 'cls'=>'bx_lds_all', 'c'=>Strn('-').HTML_BR.Spn('Correos') ]) ?></td>
            <td align="center" class="_cntr" <?php echo NWRP.$_clr_rw ?> ><?php echo bdiv([ 'cls'=>'bx_lds_on', 'c'=>Strn('-').HTML_BR.Spn('Habilitados') ]) ?></td>
            <td align="center" class="_cntr" <?php echo NWRP.$_clr_rw ?> ><?php echo bdiv([ 'cls'=>'bx_lds_nosndi', 'c'=>Strn('-').HTML_BR.Spn('No habilitados') ]) ?></td>
            <td align="center" class="_cntr" <?php echo NWRP.$_clr_rw ?> ><?php echo bdiv([ 'cls'=>'bx_lds_rmv', 'c'=>Strn('-').HTML_BR.Spn('Desuscritos') ]) ?></td>
            <td align="center" class="_cntr" <?php echo NWRP.$_clr_rw ?> ><?php echo bdiv([ 'cls'=>'bx_lds_rjct', 'c'=>Strn('-').HTML_BR.Spn('Rejected') ]) ?></td>
            <td align="center" class="_cntr" <?php echo NWRP.$_clr_rw ?> ><?php echo bdiv([ 'cls'=>'bx_lds_nexst', 'c'=>Strn('-').HTML_BR.Spn('No existen') ]) ?></td>
            <td align="center" class="_cntr" <?php echo NWRP.$_clr_rw ?> ><?php echo bdiv([ 'cls'=>'bx_lds_onvrf', 'c'=>Strn('-').HTML_BR.Spn('verificando') ]) ?></td>

            <td align="left" <?php echo NWRP.$_clr_rw ?> ><?php echo Strn('-').HTML_BR.Spn(TX_PRO_APR) ?></td>
            <td align="left" <?php echo NWRP.$_clr_rw ?> ><?php echo Strn('-').HTML_BR.Spn(TX_CLCKS) ?></td>

            <?php if(_ChckMd('snd_ec_lsts_mod')){ ?>

	            <td width="1%" align="left" nowrap="nowrap">
	                <?php echo $___Ls->_btn([ 't'=>'mod' ]); ?>
	            </td>

            <?php }elseif(_ChckMd('snd_ec_lsts_dt')){ ?>

            	<td width="1%" align="left" nowrap="nowrap">
	                <?php echo $___Ls->_btn([ 't'=>'mod', 'shw'=>'ok' ]); ?>
	            </td>

            <?php } ?>

        </tr>
        <?php } while ($___Ls->ls->rw = $___Ls->sql->fetch_assoc()); ?>
  	</tbody>
</table>
<style>

	.Ls_Rg tr ._cntr{ text-align: center; }

</style>

<?php $___Ls->_bld_l_pgs(); ?>


<?php

	$CntJV .=	"

		function __getExtData(){


			_Rqu({
				t:'ec_lsts_ext',
				eclsts:'".implode(',', $__ls_json)."',
				_cl:function(_r){
					if(!isN(_r)){
						if(!isN(_r.l)){
							$.each(_r.l, function(_k, _v) {

		                        if(!isN(_v) && !isN(_v.tot) && !isN(_v.tot.lds)){

			                        var _tot = _v.tot.lds;

			                        if(!isN(_tot.all)){ $('tr[eclsts-id-no='+_v.id+'] .bx_lds_all strong').html( _tot.all ); }
		                       		if(!isN(_tot.on)){ $('tr[eclsts-id-no='+_v.id+'] .bx_lds_on strong').html( _tot.on ); }
		                       		if(!isN(_tot.nosndi)){ $('tr[eclsts-id-no='+_v.id+'] .bx_lds_nosndi strong').html( _tot.nosndi ); }
		                       		if(!isN(_tot.rmv)){ $('tr[eclsts-id-no='+_v.id+'] .bx_lds_rmv strong').html( _tot.rmv ); }
		                       		if(!isN(_tot.rjct)){ $('tr[eclsts-id-no='+_v.id+'] .bx_lds_rjct strong').html( _tot.rjct ); }
		                       		if(!isN(_tot.nexst)){ $('tr[eclsts-id-no='+_v.id+'] .bx_lds_nexst strong').html( _tot.nexst ); }
		                       		if(!isN(_tot.onvrf)){ $('tr[eclsts-id-no='+_v.id+'] .bx_lds_onvrf strong').html( _tot.onvrf ); }

		                       	}

	                        });
                        }
					}
				}
			});

        }

	";


	$CntWb .= " setTimeout(function(){ __getExtData(); }, 1000); ";


?>
<?php }?>
<?php $___Ls->_h_ls_nr(); ?>
<?php } ?>
<?php if($___Ls->fm->chk=='ok'){

	$____plcy = GtEcLstsPlcyLs([ 'eclsts'=>$___Ls->dt->rw['id_eclsts'], 'cl'=>DB_CL_ENC, 'e'=>'on' ]);
?>

<div class="FmTb __eclsts_detail <?php if($___Ls->dt->tot == 0){ echo '__new'; } ?>">

  	<div id="<?php echo $___Ls->fm->bx->id ?>">

    <form method="POST" name="<?php echo $___Ls->fm->id; ?>" target="_self" id="<?php echo $___Ls->fm->id; ?>" >

      	<?php $___Ls->_bld_f_hdr(); ?>


	  	<?php

			$___Ls->_dvlsfl_all([
				['n'=>'bsc', 'l'=>TX_INIC],
				['n'=>'sgm', 't'=>'snd_ec_lsts_sgm', 'l'=>TX_SGMNTS, 's'=>'ok', 'ldr'=>'no'],
				['n'=>'eml', 't'=>'snd_ec_lsts_eml', 'l'=>TX_EMAIL],
				['n'=>'up', 't'=>'snd_ec_lsts_up', 'l'=>TX_UPLMSV],
				['n'=>'are', 't'=>'snd_ec_lsts_are', 'l'=>'Áreas'],
				['n'=>'var', 't'=>'snd_ec_lsts_var', 'l'=>'CRM - Leads']
			],[
				'idb'=>'ok',
				'hd'=>'no',
				'sng'=>'ok',
				'tomny'=>'ok',
				'dtb'=>1
			]);

	  	?>

	  	<div id="<?php echo $___Ls->tab->id ?>" class="VTabbedPanels SndIn mny">

            <ul class="TabbedPanelsTabGroup">
	            <li class="TabbedPanelsTab" style="display: none;"></li>
	        	<?php echo $___Ls->tab->bsc->l ?>
	        	<?php echo $___Ls->tab->sgm->l ?>
	        	<?php echo $___Ls->tab->eml->l ?>
	        	<?php if(_ChckMd('snd_ec_lsts_up')){ echo $___Ls->tab->up->l; } ?>
	        	<?php if(_ChckMd('snd_ec_lsts_are')){ echo $___Ls->tab->are->l; } ?>
	        	<?php if(_ChckMd('snd_ec_lsts_var')){ echo $___Ls->tab->var->l; } ?>
            </ul>

            <div class="TabbedPanelsContentGroup">

                <section class="_cvr">
	           		<div class="_tt">
	           			<div class="_shw">
		           			<?php echo h1( ctjTx($___Ls->dt->rw['eclsts_nm'],'in').HTML_BR.h2( ctjTx($___Ls->dt->rw['sender_sisslc_tt'],'in') ) ); ?>

				            <div class="__opt">
								<div class="col_1">
									<?php

										$_dt_ec_lsts = GtEcLstsDt([ 'id'=>$___Ls->dt->rw['id_eclsts'] ]);

										echo OLD_HTML_chck('eclsts_plcy', 'Verificar Habeas data', $_dt_ec_lsts->plcy, 'in');
										echo OLD_HTML_chck('eclsts_auto', 'Automático', $_dt_ec_lsts->auto, 'in');


										$CntWb .= "


										function _snd_auto(_op){
											$.ajax({
												type: 'POST',
												dataType: 'json',
												url: '".Fl_Rnd(PRC_GN.__t('snd_ec_lsts',true))."',
												beforeSend: function() {

												},
												data: {
													eclsts_auto : _op,
													MMM_Update_auto: 'EdEclsts',
													id_eclsts: '".$___Ls->dt->rw['eclsts_enc']."'
												},
												success: function(d){


											    }
											});
										}

										$('#eclsts_auto').change(function (){
											if(this.checked){
												$('._fl_sv').show();
												_snd_auto(1);

											}else{
												$('._fl_sv').hide();
												_snd_auto(2);
											}
										});

										function _snd_plcy(_op){
											$.ajax({
												type: 'POST',
												dataType: 'json',
												url: '".Fl_Rnd(PRC_GN.__t('snd_ec_lsts',true))."',
												beforeSend: function() { },
												data: {
													eclsts_plcy : _op,
													MMM_Update_plcy: 'EdEclsts',
													id_eclsts: '".$___Ls->dt->rw['eclsts_enc']."'
												},
												success: function(d){  }
											});
										}
										$('#eclsts_plcy').change(function (){
											if(this.checked){ _snd_plcy(1); }else{ _snd_plcy(2); }
										});

										$('._fl_sv').colorbox({ inline:true, className:'my-ec-flt', scroll:false, width:'80%' });

										";

									?>
								</div>

								<div class="col_2">

									<a class="_fl_sv" href="#__aut">
										<?php echo h2($___Ls->dt->rw['__rgtot'], '__tot'); ?>
									</a>

								</div>
							</div>




				            <?php
								$CntWb .= '


											$(".__eclsts_detail ._cvr ._tt h1").off("click").click(function(e){

												e.preventDefault();

												if(e.target != this){
											    	e.stopPropagation(); return;
												}else{
													$(".__eclsts_detail ._cvr").addClass("_mod");
													$("#eclsts_nm").focus();
												}
											});


											$("#eclsts_nm").off("blur").blur(function() {

										    	$(".__eclsts_detail ._cvr").removeClass("_mod");

											});




											$("#'.$___Ls->tab->id.' .TabbedPanelsTab").click(function(e){

										    	if( $(this).hasClass("_eml") ){
											    	$.colorbox.resize({ width:"90%", height:"90%" });
										    	}else{
													$.colorbox.resize({ width:"'.$___Ls->edit->w.'", height:"'.$___Ls->edit->h.'" });
										    	}

											});




										';
							?>
	           			</div>
	           			<div class="_fm">
		                    <?php

			                	if($___Ls->dt->tot > 0){
			                    	echo HTML_textarea("eclsts_nm", TX_NM, ctjTx($___Ls->dt->rw['eclsts_nm'],'in'),'','','','','100','','');
			                    }else{
				                    echo HTML_inp_tx('eclsts_nm', TX_NM, ctjTx($___Ls->dt->rw['eclsts_nm'],'in'));
			                    }

			                ?>
		                    <?php
				                $l = __Ls([ 'fcl'=>'ok', 'k'=>'sis_eml', 'id'=>'eclsts_sndr', 'va'=>$___Ls->dt->rw['eclsts_sndr'], 'ph'=>TX_SLUSCLNEML ]);
				                echo $l->html; $CntWb .= $l->js;
			                ?>
		                    <?php echo HTML_inp_hd('eclsts_clf', 1); ?>
		                    <?php

			                    if($___Ls->dt->tot == 0){

				                    echo LsClAre([
										            'id'=>'eclsts_are',
										            'v'=>'id_clare',
										            'v_go'=>'clare_enc',
										            'rq'=>2,
										            'mlt'=>'ok'
										        ]);

							        $CntWb .= JQ_Ls('eclsts_are', TX_SLCAR, '', '_slcClr', ['ac'=>'no']);

			                    }

		                    ?>
						</div>
	           		</div>
	            </section>

                <div class="TabbedPanelsContent">

					<div id="<?php echo $___Ls->fm->fld->id ?>">

						<?php if($___Ls->dt->tot > 0){ ?>

							<div class="ln_1" id="__edt_dtl">
								<div class="col_1">
									<ul class="ls_1" >
										<li><?php echo Strn(TX_DRMTNT). ctjTx($___Ls->dt->rw['eclsts_frm'],'in') ; ?></li>
										<li><?php echo Strn(TX_ORGCPN). ctjTx($___Ls->dt->rw['eclsts_org'],'in') ; ?></li>
										<li><?php echo Strn(TX_DIRC.':'). ctjTx($___Ls->dt->rw['eclsts_adrs'],'in') ; ?></li>
										<li><?php echo Strn(TX_DNM.':'). ctjTx($___Ls->dt->rw['eclsts_cd'],'in') ; ?></li>
										<li><?php echo Strn(TX_DMAIL.':'). ctjTx($___Ls->dt->rw['eclsts_ps'],'in') ; ?></li>
										<li><?php echo Strn(TX_TEL.':'). ctjTx($___Ls->dt->rw['eclsts_tel'],'in') ; ?></li>
										<li><?php echo Strn( $___Ls->dt->rw['eclsts_rsgnup'] ) ; ?></li>
									</ul>

									<?php echo h2(MDL_HBSDTA); ?>
									<?php

										if($____plcy->tot > 0){

											foreach($____plcy->ls as $plcy_k=>$plcy_v){

												if($plcy_v->tot>0){ $cls='on'; $cls_v=1; }else{ $cls='off'; $cls_v=2; }
												$__dattr = ' data-eclsts="'.$___Ls->dt->rw['eclsts_enc'].'" data-plcy="'.$plcy_v->enc.'" ';

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
																'plcy_'.$___Ls->dt->rw['eclsts_enc'].'_'.$plcy_v->enc
															);
											}

											echo ul($__plcy_li, '_plcy_ls');
										}


										if(_ChckMd('chck_snd_i')){

											$CntWb .= "


												$('.__eclsts_detail ._plcy_ls > li .opt button').off('click').click(function(e){

													e.preventDefault();

													if(e.target != this){

												    		e.stopPropagation(); return false;

													}else{

														if( $(this).hasClass('off') ){
															var _e = 2;
															var _e_c = 'off';
														}else{
															var _e = 1;
															var _e_c = 'on';
														}

														var _eclsts = $(this).attr('data-eclsts');
														var _plcy = $(this).attr('data-plcy');

														_Rqu({
															t:'ec_lsts_sndi',
															plcy:_plcy,
															eclsts:_eclsts,
															est:_e,
															_bs:function(){  },
															_cm:function(){  },
															_cl:function(_r){
																if(!isN(_r)){
																	if(!isN(_r.e) && _r.e=='ok'){
																		swal('Cambio Exitoso', '".TX_APROEXT."', 'success');
																		$('#plcy_'+_eclsts+'_'+_plcy).removeClass('on off').addClass(_e_c);
																	}else{
																		swal('Error', '".TX_NSAPRB."','error');
																	}
																}
															}
														});

													}

												});



											";

										}else{


											$CntWb .= "

												$('.__eclsts_detail ._plcy_ls > li .opt button').off('click').click(function(e){

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




								</div>
								<div class="col_2">

									<?php echo h2( TX_STTSMRY ); ?>

								    <div id="__grph_crsl" class="owl-carousel">
								        <div class="item">	<div id="bx_grph" class="__bl"><?php echo TX_APRTU ?></div>	</div>
								        <div class="item">	<div id="bx_grph2" class="__bl"><?php echo TX_RBTO ?></div>	</div>
								        <div class="item">	<div id="bx_grph3" class="__bl">% Desuscript</div>	</div>
								        <div class="item">	<div id="bx_grph4" class="__bl"><?php echo TX_OPNGHRS ?></div>	</div>
								        <div class="item">	<div id="bx_grph5" class="__bl"><?php echo TX_NVGDR ?></div>	</div>
								        <div class="item">	<div id="bx_grph6" class="__bl"><?php echo TX_OS ?></div>	</div>
								        <div class="item">	<div id="bx_grph7" class="__bl"><?php echo TX_CMPRSM ?></div>	</div>
								    </div>

								</div>
							</div>

						<?php } ?>

					</div>


                </div>

                <div class="TabbedPanelsContent">

                    <!-- Inicia Segmentos -->
                        <div class="ln">
                            <?php echo $___Ls->tab->sgm->d ?>
                        </div>
                    <!-- Finaliza Segmentos -->

                </div>
                <div class="TabbedPanelsContent">

                    <!-- Inicia Segmentos -->
                        <div class="ln">
                            <?php echo $___Ls->tab->eml->d ?>
                        </div>
                    <!-- Finaliza Segmentos -->

                </div>
                <?php if(_ChckMd('snd_ec_lsts_up')){ ?>
                <div class="TabbedPanelsContent">
                    <!-- Inicia Carga -->
                        <div class="ln">
                            <?php echo $___Ls->tab->up->d ?>
                        </div>
                    <!-- Finaliza Carga -->
                </div>
                <?php } ?>
                <?php if(_ChckMd('snd_ec_lsts_are')){ ?>
                <div class="TabbedPanelsContent">
                    <!-- Inicia Carga -->
                        <div class="ln">
                            <?php echo $___Ls->tab->are->d ?>
                        </div>
                    <!-- Finaliza Carga -->
                </div>
                <?php } ?>
                <?php if(_ChckMd('snd_ec_lsts_var')){ ?>
                <div class="TabbedPanelsContent">
                    <!-- Inicia Carga -->
                        <div class="ln">
                            <?php echo $___Ls->tab->var->d ?>
                        </div>
                    <!-- Finaliza Carga -->
                </div>
                <?php } ?>
            </div>
        </div>

    </form>
  </div>
</div>
<?php } ?>
<?php } ?>
