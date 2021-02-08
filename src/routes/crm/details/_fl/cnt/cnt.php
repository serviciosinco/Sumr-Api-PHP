<?php

	$__dt_cnt = GtCntDt([  't'=>'enc', 'id'=>$__i, 'ls_tp'=>'ok', 'ls_f_scl'=>'ok', 'ls_f_org'=>'ok', 'ls_f_tpc'=>'ok', 'count'=>'ok' ]);

	$__cld = __LsDt([ 'k'=>'cld' ]);

	foreach($__cld->ls->cld as $__cld_k=>$__cld_v){
		$__cld_go->{$__cld_k} = $__cld_v;
	}

	if($__dt_cnt->tp_cntc->e == 'ok'){
		foreach($__dt_cnt->tp_cntc->ls as $__tp_k =>  $__tp_v){
			if($__tp_v->tp == _CId('ID_TPCNTC_EML')){
				$pef1 = $__dt_cnt->eml->clds->cld_eml;
			}elseif($__tp_v->tp == _CId('ID_TPCNTC_MSG') || $__tp_v->tp == _CId('ID_TPCNTC_WHT') ){
				$pef2 = 'ok';
			}elseif($__tp_v->tp == _CId('ID_TPCNTC_TEL')){
				$pef3 = 'ok';
			}
		}
	}

?>


<div class="__cnt_dtl">

	<div class="__btn" style="z-index: 99999999; ">

		<h1 class="u_nm"><?php if(!isN($__dt_cnt->nm)){ echo $__dt_cnt->nm; } if(!isN($__dt_cnt->ap)){ echo ' '.$__dt_cnt->ap; } ?></h1>

		<div class="_pic_wrp">
			<div class="_pic">
				<?php if(!isN($__dt_cnt->fll->pht)){ ?>
				<div id="__grph_crsl_pic" class="owl-carousel">
			        <?php foreach($__dt_cnt->fll->pht as $_k => $_v){ ?>
			        <div class="item">	<img src="<?php echo $_v->url ?>" />	</div>
			        <?php } ?>
			    </div>
			    <?php

						$CntWb .= '

							SUMR_Main.ld.f.owl( function(){

								SUMR_Main.ld.f.knob( function(){

									$("#__grph_crsl_pic").owlCarousel({
										  autoPlay: true,
										  stopOnHover: true,
										  navigation : true,
										  slideSpeed : 300,
										  paginationSpeed : 400,
										  navigation: true,
										  singleItem: true
									});

								});

							});

						';

					?>
				<?php }else{ ?>
		        	<div class="item"><img src="<?php echo DMN_IMG_ESTR; ?>us_nop.png" /></div>
		        <?php } ?>
			</div>
		</div>
		<div class="__cld">
		 	<?php
                $__sis_cld = LsSis_Cld([ 'id'=>'cnt_cld', 'v'=>'enc', 'va'=>$__dt_cnt->cld->id, 'rq'=>2, 'dsbl'=>'ok' ]);
				echo $__sis_cld->html; $CntWb .= $__sis_cld->js;
            ?>
		</div>

	    <div class="snd_i_all">

		    <?php $____plcy = GtCntPlcyLs([ 'cnt'=>$__dt_cnt->id, 'e'=>'on' ]); ?>

		    <?php

				if($____plcy->tot > 0){

					foreach($____plcy->ls as $plcy_k=>$plcy_v){

						if($plcy_v->tot>0){

							$cls='on'; $cls_v=1;

							$__dattr = ' data-cnt="'.$__dt_cnt->enc.'" data-plcy="'.$plcy_v->enc.'" ';

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
											'plcy_'.$__dt_cnt->enc.'_'.$plcy_v->enc
										);

						}

					}

					echo ul($__plcy_li, '_plcy_ls');
				}

			?>



	    		<div class="snd_i <?php echo '_'.$__dt_cnt->sndi; ?> _anm" title="<?php echo TX_HBSACCPT; ?>" id="snd_i_<?php echo $__dt_cnt->enc; ?>" data-accpt="<?php echo $__dt_cnt->sndi; ?>"></div>

	    </div>

	        <?php if( !_DtV() ){ ?>

	          	<div class="__btn" style="z-index: 99999999; ">

	            	<?php //echo '<a href="'.FL_DT_GN.__t('cnt_tml',true).ADM_LNK_DT.$__dt_cnt->id.$___Dt->ls->vrall.$_adsch.TXGN_BX.DV_LSFL.Gn_Rnd(20).'" class="___tml_btn">Timeline</a>' ; ?>


				<?php echo '<a href="'.Void().'" class="___edt_btn _anm">'.TX_EDIT.'</a>' ; ?>


	            	<?php if(_ChckMd('call')){ ?>

					<div class="btn_cll_bx">

						<?php echo h1(TX_CLL); ?>

			            <?php /*
			            <div class="btn_cll_bx_my _anm">
				            <div class="col_1">
					        	<?php echo h3('Mi Numero'); ?>
					        </div>
				            <div class="col_2">
				            <?php
			            		//echo LsUsTel(array('id'=>'us_tel'.$__rnd_op, 'v'=>'id_ustel', 'us'=>SISUS_ID, 'ct'=>'no', 'rq'=>2 ));
			            		//$CntWb .= JQ_Ls('us_tel'.$__rnd_op, FM_LS_SLTEL, '', '', array('ac'=>'no') );
					        ?>
				            </div>
			            </div>
			            <?php */ ?>

			            <div class="btn_cll_bx_dv _anm _stnd" id="btn_cll_bx_<?php echo $__rnd_op ?>">



				            <div class="col_1">




						       <?php echo '<button type="button" class="___call_btn _anm" id="___call_btn">Llamar</button>'; ?>

				            </div>
				            <div class="col_2">
					            <?php
						           // echo LsSis_PsOLD('cnt_tel_ps','id_sisps', 57, '-', 2, '', '', 'iso'); $CntWb .= JQ_Ls('cnt_tel_ps', '-', '', 'psFlg', ['ac'=>'no']);
						            echo LsCntTel(['id'=>'call_tel'.$__rnd_op, 'cnt'=>$__dt_cnt->id, 'ct'=>'no', 'rq'=>2, 'ps'=>'no', 'img'=>'si','id_sisps'  ]);
				            		$CntWb .= JQ_Ls('call_tel'.$__rnd_op, FM_LS_SLTEL, '', 'psFlg', ['ac'=>'no'] );
						        ?>
				            </div>
			            </div>

			            <div><?php //echo OLD_HTML_chck('call_mydvc', 'Usar mi dispositivo'); ?></div>
					</div>

	            <?php

		            }else{
						echo h3('Llamadas <br>'.Spn(TX_DSH), '_sisno');
					}

				?>

	            <?php

					$CntWb .= '

						$(".___tml_btn").colorbox({
							width: "90%",
							height: "90%",
							onClosed:function(){
						        SUMR_Main.mdlcnt.f.dt();
							}
						});

						$(".___edt_btn").off("click").click(function() {

							_ldCnt({
								u:\''.FL_LS_GN.__t('cnt', true).ADM_LNK_DT.$__dt_cnt->enc.($___Dt->pop()?TXGN_POP:'').'\',
								pop:\'ok\',
								pnl:{
									e:\'ok\',
									s:\'l\',
									tp:\'h\'
								}
							});

						});';


				if(_ChckMd('chck_snd_i')){

					/*$CntWb .= '

						$("#snd_i_'.$__dt_cnt->enc.'").off("click").click(function() {

							var _dac = $(this).attr("data-accpt");
							if(_dac == "ok"){ var _tx="¿El usuario no desea recibir mas información?"; }else{ var _tx="¿El usuario desea recibir nuestra información?"; }

							swal({
								title: "'.TX_HBSACCPT.'",
								text: _tx,
								type: "warning",
								showCancelButton: true,
								confirmButtonColor: "#64b764",
								confirmButtonText:"'.TX_ACPT.'",
								cancelButtonText:"'.TX_CNCLR.'",
								showLoaderOnConfirm: true,
								closeOnConfirm: false
							},
							function(){

								_accpt = $("#snd_i_'.$__dt_cnt->enc.'").attr(\'data-accpt\');

								if(_accpt == "no"){ var est="1"; var newa="ok"; }else if(_accpt == "ok"){ var est="2"; var newa="no"; }

								if(!isN(est)){
									_Rqu({
										t:"cnt_sndi",
										d:"sndi_mod",
										est:est,
										cnt:"'.$__dt_cnt->enc.'",
										_cl:function(_r){
											if(!isN(_r)){
												if(!isN(_r.e) && _r.e == "ok"){

													if(!isN(_r.prc) && !isN(_r.prc.upd) && !isN(_r.prc.upd.cnt) && !isN(_r.prc.upd.cnt.sndi) && !isN(_r.prc.upd.cnt.sndi.e) && _r.prc.upd.cnt.sndi.e == "ok"){
														$("#snd_i_'.$__dt_cnt->enc.'").attr(\'data-accpt\', newa).removeClass(\'_\'+_accpt).addClass(\'_\'+newa);
														swal(\'Cambio Exitoso\', "'.TX_APROEXT.'",\'success\');
													}else{
														swal(\'Error\', "'.TX_NSAPRB.'",\'error\');
													}

												}
											}
										}
									});
								}

							});


						});';*/

						$CntWb .= "

							$('.__cnt_dtl ._plcy_ls > li .opt button').off('click').click(function(e){

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

						$('.__cnt_dtl ._plcy_ls > li .opt button').off('click').click(function(e){

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

				$CntWb .= '

					$("#___call_btn").off("click").click(function() {

						SUMR_Main.ld.f.call(function(){

							'.JQ_Ls("_sis_tp",FM_LS_SLTP).'
							$(".bx_call").addClass("bx_call_opn");
							$(".bx_call_cnt, .div_vlv").show();

							var __tel = $(\'#call_tel'.$__rnd_op.'\').val();
							var __tel_id = $(\'#call_tel'.$__rnd_op.' option:selected\').attr(\'rel\');
							var __mdlcnt = $(\'#mdlcnt_enc\').val();

							SUMR_Call.mdlcnt = __mdlcnt;
							var __evncnt = $(\'#id_evncnt\').val();
							var __actcnt = $(\'#id_actcnt\').val();
							var __ustel = $(\'#us_tel'.$__rnd_op.'\').val();

							SUMR_Call.f.cnt({ tp:\'_slc\', pc:__mdlcnt, __tel_id:__tel_id });

						});

					});

					var __pg = 1;

					SUMR_Main.ld.f.call(function(){
						$("#btn_cll_bx_'.$__rnd_op.'").removeClass(\'_stnd\').addClass(\'_rdy\');
					});


					';
				?>
	          </div>
	        <?php } ?>
	</div>


	<div class="ln_1" id="____edt_dtl">

	    <?php
		    //-------------------- ICONS --------------------//
		    $__icn_sub_dte = Spn('','','_tt_icn _tt_icn_dte');
		    $__icn_sub_hur = Spn('','','_tt_icn _tt_icn_hra');
		    $__icn_sub_eml = Spn('','','_tt_icn _tt_icn_eml');
		    $__icn_sub_tel = Spn('','','_tt_icn _tt_icn_tel');
		    $__icn_sub_docs = Spn('','','_tt_icn _tt_icn_docs');
		    $__icn_sub_tp = Spn('','','_tt_icn _tt_icn_cnt_tp');
		    $__icn_sub_rds = Spn('','','_tt_icn _tt_icn_cnt_rds');
		    $__icn_sub_tpcs = Spn('','','_tt_icn _tt_icn_cnt_tpcs');

			$__icn_sub_sx = Spn('','','_tt_icn _tt_icn_cnt_sx');
			$__icn_sub_dir = Spn('','','_tt_icn _tt_icn_cnt_dir');
		    $__icn_sub_fnc = Spn('','','_tt_icn _tt_icn_cnt_fn');

		    $__icn_sub_prf = Spn('','','_tt_icn _tt_icn_cnt_prf');
			$__icn_sub_cref = Spn('','','_tt_icn _tt_icn_cnt_cref');

	    ?>
	    <ul class="ls_1" >
		    <li class="_tt"><?php echo h4(Spn('','','_tt_icn _tt_icn_bscs').TX_DTSBSC); ?></li>
	 		<li><?php echo $__icn_sub_dte.$___Dt->_dte($__dt_cnt->fi); ?></li>
	 		<li><?php echo $__icn_sub_hur.$___Dt->_tme($__dt_cnt->fi); ?></li>
	 		<?php if(!isN($__dt_cnt->sx)){ ?><li title="<?php echo TX_SX; ?>"><?php echo $__icn_sub_sx.$__dt_cnt->sx->tt; ?> </li><?php } ?>
		    <?php if(!isN($__dt_cnt->fn)){ ?><li title="<?php echo TX_FCHNCM; ?>"><?php echo $__icn_sub_fnc.$__dt_cnt->fn; ?> </li><?php } ?>
			<?php if(!isN($__dt_cnt->dir)){ ?><li title="<?php echo TX_DIRC; ?>"><?php echo $__icn_sub_dir.$__dt_cnt->dir; ?> </li><?php } ?>

	        <?php if(!isN($__dt_cnt->dc_a)){ ?>
	        	<li class="_tt"><?php echo h4(Spn('','','_tt_icn _tt_icn_docs').TX_DOCS); ?></li>
	        	<?php
		        	foreach($__dt_cnt->dc_a as $k => $v){
		        		echo '<li>'.$__icn_sub_docs.$v->t.' '.$v->n .'</li>';

		        	}
		        ?>
	        <?php } ?>

	        <?php if(!isN($__dt_cnt->eml)){  ?>
	        	<li class="_tt"><?php echo h4(Spn('','','_tt_icn _tt_icn_emls').TX_EMAIL); ?></li>
	        	<?php foreach($__dt_cnt->eml as $_eml_k=>$_eml_v){
		        	if($_eml_v->rjct == 'ok'){
			        	$_cls_eml='_lckd'; $_cls_eml_tt='No apto para envio (Hard Bounce)';
			        }else{
				        if(!isN($pef1)){ $__cls = ' ___prf'; }
				        if($_eml_v->est == _CId('ID_SISEMLEST_ACT')){ $_cls_eml=''; }else{ $_cls_eml='_lckd'; $__cls = ''; }
				    }
		        	if(!isN($_eml_v->v)){ ?>
			        	<li class="<?php echo $_cls_eml.$__cls; ?>">
			        		<?php
				        		echo Spn('','','_cld _cld_'.$__cld_go->{$_eml_v->cld}->ptje->vl);
				        		echo $_eml_v->v.Spn('','','_tt_icn _tt_icn_lckd','','',$_cls_eml_tt);
				        	?>
				        </li>
		        	<?php } ?>
	        	<?php } ?>
	        <?php } ?>

		</ul>

		<div class="ln_1">

			<?php if(!isN($__dt_cnt->cd)){ ?>
			<ul class="ls_1" >
				<li class="_tt"><?php echo h4(Spn('','','_tt_icn _tt_icn_geo').TX_GEOGRP); ?></li>
		        <?php foreach($__dt_cnt->cd as $k => $v){ ?>
		        	<?php if(!isN($v)){ ?><li><?php echo Strn($v->rel->tt,'',true).Spn('','','background-image:url('.$v->ps->img->url->th_50.');').$v->cd->tt; ?> </li><?php } ?>
		        <?php } ?>
			</ul>
			<?php } ?>

     		<ul class="ls_1" >

 				<?php if(!isN($__dt_cnt->tel)){ ?>
 				<li class="_tt"><?php echo h4( Spn('','','_tt_icn _tt_icn_tels') . TX_CLRS); ?></li>
 				<?php // echo json_encode($__dt_cnt->tel_all) ?>
		        	<?php foreach($__dt_cnt->tel_all->ls as $_k_tel => $_v_tel){ ?>
		        		<?php $img_th = _ImVrs(array('img'=>$_v_tel->img_ps, 'f'=>DMN_FLE_PS)); ?>
			        	<?php
				        	if((!isN($pef2) && $_v_tel->tp == 3) || (!isN($pef3) && $_v_tel->tp == 2 ) ){
					        	$__cls = ' ___prf';
					        }else{
								$__cls = '';
						    }
						?>
			        	<li class="<?php echo $__cls; ?>">
			        		<div  class="_img_ps1" style="background-image:  url( <?php echo $img_th->th_50;  ?>); "></div>
			        		<?php echo $_v_tel->tel; ?>
			        	</li>
		        	<?php } ?>
		        <?php } ?>

				<?php if(!isN($__dt_cnt->org)){ ?>
		        	<?php

						foreach($__dt_cnt->org as $_org_k=>$_org_v){

							if(!isN($_org_v)){

								$__org_icn = Spn('','','_tt_icn','background-image:url('.$_org_v->img.');');

								echo li( h4($__org_icn.$_org_v->tt), '_tt' );

								foreach($_org_v->ls as $_org_s_k=>$_org_s_v){ //echo h2('JSON:'.json_encode($_org_s_v)).HTML_BR.HTML_BR.HTML_BR;

									echo li( Spn('','','_o','background-image:url('.$_org_s_v->img->sm_s.'); border-color:'.$_org_s_v->clr.'').$_org_s_v->nm.Spn($_org_s_v->tpr->tt, 'ok') );


								}
							}

			        	}

			        ?>
		        <?php } ?>

		        <?php if(!isN($__dt_cnt->bd)){ ?><li><?php echo Strn(TX_BBD,'',true).$__dt_cnt->bd; ?> </li><?php } ?>

				<?php

			    	if(!isN($__dt_cnt->ls_tp->html)){ echo li(h4($__icn_sub_tp.TX_VNC),'_tt').$__dt_cnt->ls_tp->html; }
			    	if(!isN($__dt_cnt->fll->scl->html)){ echo li(h4($__icn_sub_rds.TX_RDSC),'_tt').$__dt_cnt->fll->scl->html; }
			    	//if(!isN($__dt_cnt->fll->org->html)){ echo li(h4(TX_EMPS),'_tt').$__dt_cnt->fll->org->html; }
			    	if(!isN($__dt_cnt->fll->tpc->html)){ echo li(h4(TX_TPIC),'_tt').$__dt_cnt->fll->tpc->html; }

				?>
			</ul>

			<ul class="ls_1" >
				<li class="_tt"><?php echo h4(Spn('','','_tt_icn _tt_icn_oth').TX_OTHDT); ?></li>
		        <?php if(!isN($__dt_cnt->prf)){ ?><li title="<?php echo TX_PRF ?>"><?php echo $__icn_sub_prf.$__dt_cnt->prf; ?> </li><?php } ?>
		        <?php if(!isN($__dt_cnt->count->cref)){ ?><li title="<?php echo TX_CREF ?>"><?php echo $__icn_sub_cref.$__dt_cnt->count->cref; ?> </li><?php } ?>

				<?php if(!isN($__dt_cnt->attr)){ ?>
					<?php foreach($__dt_cnt->attr as $_attr_k=>$_attr_v){

						if(!isN($_attr_v->all->ls->vl)){
							$__slcdt = __LsDt([ 'id'=>$_attr_v->vl, 'no_lmt'=>'ok' ]);
							$__vl = $__slcdt->d->tt;
						}else{
							$__vl = $_attr_v->vl;
						}

						?>

		        		<li><?php echo Strn($_attr_v->tt,'',true).' '.$__vl; ?> </li>
		        	<?php } ?>
				<?php } ?>

			</ul>


		</div>


	</div>
	<div class="spcbtm"></div>

	<?php if(_ChckMd('chck_snd_i')){ ?>
		<style>
			.__cnt_dtl ._pic_wrp .snd_i._no:hover{ background-image: url(<?php echo _iEtg(DMN_IMG_ESTR_SVG.'cnt_sndi_ok.svg') ?>); }
			.__cnt_dtl ._pic_wrp .snd_i._ok:hover{ background-image: url(<?php echo _iEtg(DMN_IMG_ESTR_SVG.'cnt_sndi_no.svg') ?>); }
		</style>
	<?php } ?>

	<style>

		.__cnt_dtl .snd_i_all{ width: 95%; margin-bottom: 20px; margin-left: auto; margin-right: auto; }
		.__cnt_dtl .snd_i_all ._plcy_ls{  }
		.__cnt_dtl .snd_i_all ._plcy_ls li{ position: relative; padding: 0 0 0 30px; min-height: 35px; }
		.__cnt_dtl .snd_i_all ._plcy_ls li::before{ background-image: url(<?php echo _iEtg(DMN_IMG_ESTR_SVG.'plcy_icn.svg') ?>); display: block; width: 20px; height: 20px; background-repeat: no-repeat; background-position: center center; background-size: auto 80%; position: absolute; left: 0; top: 0; }

		.__cnt_dtl .snd_i_all ._plcy_ls li .wrp{ width: 100%; position: relative; text-align: center; }
		.__cnt_dtl .snd_i_all ._plcy_ls li .wrp .tt{ position: absolute; left: 0; white-space: nowrap; text-overflow: ellipsis; overflow: hidden; width: 85%; text-align: center; }
		.__cnt_dtl .snd_i_all ._plcy_ls li .wrp .tt span{ text-align: center; }
		.__cnt_dtl .snd_i_all ._plcy_ls li .wrp .opt{ top:-2px; }

		.__cnt_dtl .spcbtm{ width:100%; min-height:400px; }

		#____edt_dtl ._cld{ display: inline-block; vertical-align: middle; }

		.___prf{ position: relative; }
		.___prf::before {
		    content: "";
		    display: block;
		    position: absolute;
		    width: 12px;
		    height: 12px;
		    top: 12px;
		    left: 6px;
		    background-image: url('<?php echo DMN_IMG_ESTR_SVG; ?>check_rq.svg');
		}

	</style>

</div>