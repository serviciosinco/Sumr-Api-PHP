<?php  if(!isN($__fm->row) && count($__fm->row) > 0){ ?>
	<div class="header" style="background-image:url(<?php echo $__cl->lgo->lght->big ?>);"></div>
	<?php foreach($__fm->row as $_rw_k=>$_rw_v){

		$___rnd = Gn_Rnd(15); ?>

		<div id="<?php echo $___rnd; ?>" class="_ln cx<?php echo $_rw_v->tot; ?> mdl ">

			<?php

				foreach($_rw_v->f as $_fld_k=>$_fld_v){

					if($_fld_v->attr->key->vl == 'cnt_eml'){ $__f_mre['ac'] = 'email'; $__f_tp = 'email'; }else{ $__f_tp = 'text'; }
					if(!isN($_fld_v->attr->cmp_esp->vl)){ $vl = $_fld_v->attr->cmp_esp->vl; }else{ $vl = '[appl]'; }

					$__f_ph = _cns($_fld_v->attr->ph->vl);
					$ft = GtApplRowFldDt(['id'=>$_fld_v->id]);

					if($ft->rqd == _CId('ID_LSRQ_VL_RQ')){ $__f_rq = FMRQD; $_cls = ''; }
					elseif($ft->rqd == _CId('ID_LSRQ_VL_RQ_EM')){ $_cls = FMRQD_EM; $__f_rq = FMRQD; }
					elseif($ft->rqd == _CId('ID_LSRQ_VL_RQ_NM')){ $_cls = FMRQD_NM; $__f_rq = FMRQD; }
					elseif($ft->rqd == _CId('ID_LSRQ_VL_RQ_EML')){ $_cls = FMRQD_EML; $__f_rq = '2';	}
					elseif($ft->rqd == _CId('ID_LSRQ_VL_RQ_NMR')){ $_cls = FMRQD_NMR; $__f_rq = '2';	}
					elseif($ft->rqd == _CId('ID_LSRQ_VL_RQ_NA')){ $_cls = ''; $__f_rq = '2'; }

					if(!isN($_fld_v->attr->get->vl)){

						$__f_id = $_fld_v->attr->get->vl.$__id_rnd;
						$__key_go = $__f_id;
						$__f_mre['cls'] = $_cls;
						$__f_mre['n'] = '';

					}else{


						$__key_go = '____ext_'.$__id_rnd.''.$vl.'['.$_fld_v->attr->key->vl.']';
						$__f_mre['n'] = $__key_go;
						$__f_mre['cls'] = $_cls;
						$__f_id = $_fld_v->attr->key->vl.$__id_rnd;


					}


				?>

				<div <?php if($_rw_v->tot > 1){ ?>class="_blq _c _c<?php echo $_c; ?>" <?php }else{ ?> class="_blq _unq" <?php } ?>>
					<div class="_fd tooltip">

						<?php

							if(!isN($_fld_v->attr->key_tb->vl) || !isN($_fld_v->attr->ls->vl)){
								if(!isN($_fld_v->attr->cmp_esp->vl)){ $vl = $_fld_v->attr->cmp_esp->vl; }else{ $vl = '[appl]'; }

								if(isN($_fld_v->attr->get->vl)){

									$__key_go = '____ext_'.$__id_rnd.''.$vl.'['.$_fld_v->attr->key->vl.']';
									$__f_mre = $_cls;
									$__f__id = $_fld_v->attr->key->vl.$__id_rnd;

								}else{


									$__key_go = $__f_id;
									$__f__id = $_fld_v->attr->get->vl.$__id_rnd;
									$__f_mre = '';

								}



								if(!isN($_fld_v->attr->rto->vl) && $_fld_v->attr->rto->vl == 1) { $f = 'rto'; }else { $f = ''; }
								if(!isN($_fld_v->attr->opc_oth->vl) && $_fld_v->attr->opc_oth->vl == 1) {

									$__oth = 'ok';

									?>
										<div id="bx_ls_1_<?php echo $__f__id; ?>" style="display:none;">
											<?php echo '<div class="_sl"> <select id="Opc_Oth'.$__f__id.'" name="Opc_Oth'.$__f__id.'" class="required"></select> </div>'; ?>
										</div>
										<div id="bx_ls_2_<?php echo $__f__id; ?>" style="display:none;">
											<?php echo _HTML_Input('OthWrt'.$__f__id, TT_FM_NM, '', FMRQD); ?>
										</div>
									<?php

								}else{
									$__oth = 'no';
								}

								if( $_fld_v->attr->key_tb->vl == 'LsCd'){ $rq_cd = 'Rq_cd_oth'; }

								$l = LsDmc([
									'data'=>(!isN($_fld_v->attr->key_tb->vl)) ? 'Tb' : 'Ls',
									'tp'=>(!isN($_fld_v->attr->key_tb->vl)) ? $_fld_v->attr->key_tb->vl : $_fld_v->attr->ls->vl,
									'key'=>$_fld_v->attr->key_tb->vl,
									'id'=>$__f__id,
									'nm'=>$__key_go,
									'cls'=>$__f_mre,
									'rq'=>$__f_rq,
									'ph'=>$__f_ph,
									'cl'=>$__cl->enc,
									'rto'=>$f,
									'mdl'=>$__mdl->id,
									'oth'=>$__oth,
									'fcl'=>mBln($_fld_v->attr->flt_cl->vl),
									'flt_tp' => $ft->flt_tp,
									'flt_exc' => $ft->flt_exc,
									'vl_adc' => $ft->flt_val,
									'rq_cd' => $rq_cd

								]);

							?>

								<div id="<?php echo 'Ls'.$__f__id; ?>"> <?php echo $l->html; $_CntJQ_S2 .= $l->js; ?> </div>	<?php

							}elseif($_fld_v->attr->key->vl == 'cnt_fn'){

								$l = SlDt([ 'a'=>'ok', 'id'=>$__f_id, 'rq'=>$__f_rq, 'ph'=>'Fecha de nacimiento', 'mth'=>'ok', 'yr'=>'ok', 'cls'=>CLS_CLND ]);
								echo $l->html; $_CntJQ_S2 .= $l->js;

							}elseif($_fld_v->attr->key->vl == 'cnt_dc_tp'){

								$l = __Ls([ 'k'=>'cnt_dc',
												'id'=>$__f_id,
												'va'=>177,
												'ph'=>$__f_ph,
												'slc'=>[
													'opt'=>[
														'attr'=>[
															'itm-sg'=>'sg'
														]
													]
												]
											]);

								echo $l->html; $_CntJQ_S2 .= $l->js;

							}elseif($_fld_v->attr->key->vl == 'cnt_dc_exp'){

								$l = SlDt([ 'a'=>'ok', 'id'=>$__f_id, 'rq'=>$__f_rq, 'ph'=>'Fecha de Expedición', 'mth'=>'ok', 'yr'=>'ok', 'cls'=>CLS_CLND ]);
								echo $l->html; $_CntJQ_S2 .= $l->js;

							}elseif($_fld_v->attr->key->vl == 'cs_no_tlr'){
								$fhj = GtTpcLs(['tp'=>'cmpt','cl'=>$__cl->id]);
								echo h2('Que cosas no toleras en convivencia');
								echo '<ul id="tpc_'.$__f_id.'">';
									foreach($fhj->ls as $k => $v){

										echo '<li class="opc _anm" data="'.$v->key.'" rel="'.$v->enc.'"><figure class="_anm" style="background-image: url('.DMN_FLE_TPC.$v->img.')"></figure>'.$v->tt.'<input type="hidden" name="__ext[appl][cs_no_tlr]['.$v->enc.']" id="vl_'.$v->enc.'" value=""></li>';

									}
								echo '</ul>';

								$__f_ph = "";

							}elseif($_fld_v->attr->key->vl == 'prd_drc_cntr'){

								if(isN($_fld_v->attr->get->vl)){
									$__f_mre['n'] = $__key_go;
									$__f_mre['cls'] = $_cls;
								}

								$__key_go = '____ext_'.$__id_rnd.''.$vl;

								echo _HTML_Input('prd__'.$__f_id, $__f_ph, $__f_v, $__f_rq, $__f_tp, $__f_mre);

							}elseif($_fld_v->attr->key->vl == 'slt_romt' && $__cntr_fm->romt == 1){

								$__rnd = Gn_Rnd(20);

								echo h2('Compañeros de apartamento');
								echo '<div class="romt" id="romt_'.$__rnd.'"><button class="otro">otro</button></div>';

							}elseif(!isN($_fld_v->attr->chk_fch->vl) && $_fld_v->attr->chk_fch->vl == 1){

								if($ft->rqd == _CId('ID_LSRQ_VL_RQ_NA')){ $_cls = ''; $__f_rq = 'no'; }
								$l = SlDt([ 'a'=>'ok', 'id'=>$__f_id, 'rq'=>$__f_rq, 'n'=>$__key_go, 'ph'=>$__f_ph, 'mth'=>'ok', 'yr'=>'ok','lmt'=>'no', 'cls'=>CLS_CLND ]);
								echo $l->html; $_CntJQ_S2 .= $l->js;

							}elseif($_fld_v->attr->key->vl == 'tt' || $_fld_v->attr->key->vl == 'sb_tt'  || $_fld_v->attr->key->vl == 'sb_tt_2' || $_fld_v->attr->key->vl == 'hdr' ){
								$__f_ph = "";
								if($_fld_v->attr->key->vl == 'tt'){ echo h2(ctjTx($ft->tt,'in'));}
								elseif($_fld_v->attr->key->vl == 'sb_tt'){ echo Spn(ctjTx($ft->tt,'in'));}
								elseif($_fld_v->attr->key->vl == 'sb_tt_2'){ echo "<p class='dtl_inf'>".ctjTx($ft->tt,'in').'</p>';}
								elseif($_fld_v->attr->key->vl == 'hdr'){ echo ctjTx($ft->tt,'in', '', ['html'=>'ok','schr'=>'no','nl2'=>'no','qte'=>'no']); }

							}elseif($_fld_v->attr->key->vl == 'idm_dmo'){

								$__f_ph = "";
								$__lng = GtLngLs(); ?>
								<div class="my_lng __ld _anm">
									<h1 class="_tt">
										<?php foreach ($__lng->ls as $_k=>$_v) {

											$i++;

											$__key_go = '____ext_'.$__id_rnd.'[appl][idm_'.$i.']';

											?>
											<div class="_anm hvr <?php echo $_v->cod; ?>" rel="<?php echo $_v->id; ?>" id="idm_<?php echo $_v->enc; ?>">
												<figure>
													<div class="_anm" style="background-image: url(<?php echo $_v->flg; ?>); "></div>
												</figure>
												<?php echo Spn($_v->nm) ?>
												<input id="idm_<?php echo $i.''.$__id_rnd; ?>" type="hidden" name="<?php echo $__key_go; ?>" value="">
											</div>
										<?php } ?>
									</h1>
								</div>
								<?php

							}elseif($_fld_v->attr->key->vl == 'cmnt'){ ?>
								<div class="cmnt" id="__cmnt_chk" >
									<span id="cmnt_on<?php echo $__id_rnd; ?>"><?php echo TX_LVCMNT ?></span>
									<?php $_CntJQ_Vld .= "

									$('#__cmnt_chk').off('click').click(function(event){
										$(this).addClass('ok');
										$('#__cmnt_li".$__id_rnd."').fadeIn('fast');
									});

									"; ?>
									</div>
									<div class="bx_cmnt" id="__cmnt_li<?php echo $__id_rnd; ?>" style="display:none;" class="_ln">
									<?php echo _HTML_Text($__f_id, TT_FM_CMN,'',2, [ 'nm' => $__key_go ]); ?>
								</div>
								<?php
									$__f_ph = "";
							}else{
								echo _HTML_Input($__f_id, $__f_ph, $__f_v, $__f_rq, $__f_tp, $__f_mre);
							}

							$__f_mre = [];

							if(!isN($__f_ph)){ ?> <span class="tooltiptext"><?php echo $__f_ph; ?></span><?php }

							include('includes/js/js.php');
						?>
					</div>
				</div>
				<?php $_c++; ?>
			<?php } ?>
		</div>
	<?php } ?>
<?php } ?>