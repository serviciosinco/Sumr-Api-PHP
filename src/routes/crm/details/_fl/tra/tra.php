<?php
  	if(!isN($___Dt->gt->i)){

	$_dt_tra = GtTraDt([ 'id'=>$___Dt->gt->i, 't'=>'enc', 'ext'=>['usest'=>'ok'] ]);
	$_tp_tt = TX_TRA;

  	if(
		(!isN($_dt_tra->col->chk->pqr) && $_dt_tra->col->chk->pqr == 'ok') ||
		( $_dt_tra->tp->slc->id == _CId('ID_TRACOLTP_TCKT_PQR'))
	){
		  $__clss_m .= ' tck sac '; $_sac_c='ok'; $_tp_tt=TX_TCKT;
	}
  	if(!isN($_dt_tra->col->chk->tck) && $_dt_tra->col->chk->tck == 'ok'){ $__clss_m .= ' tck sumr '; $_tp_tt=TX_TCKT;  }

?>
  <div class="DshTraDetail <?php echo $__clss_m; ?> <?php if($_dt_tra->col->chk->tck == 'ok' && !ChckSESS_superadm() && !_ChckMd('tra_obs')){ echo '_dsbld'; } ?>">
  	<div class="_tra_mod _anm">
  		<div class="mn_dsp _anm">
  			<button id="tra_cmpl" class="cmpl"><?php echo TX_TRMN; ?></button>
			<?php if(_ChckMd('tra_arch')){ ?>
  			<button id="tra_arch" class="arch"><?php echo TX_ARCHV; ?></button>
			<?php } ?>
  			<button id="tra_prc" class="prc"><?php echo TX_ACTVR; ?></button>
			<?php if(_ChckMd('tra_eli')){ ?>
  			<button id="tra_elim" class="elim"><?php echo TX_MNDRAPPLR; ?></button>
			<?php } ?>
  		</div>
  		<div class="slc_asg">
  			<?php echo HTML_inp_hd('trarsp_us_asg', SISUS_ID); ?>
  		</div>

  		<div class="_c">
  			<div class="_hdr">
  				<nav>
  					<div class="_left">

  						<div class="_prc">
  							<div class="btn_upd _ldr _anm"><button class="_anm"><?php echo TX_CMPLTR.' '.$_tp_tt; ?></button></div>
  							<div class="enf"></div>
  							<div class="asg">
  								<figure><div class="_img"></div></figure>
  								<div class="_nm"><?php echo TX_ASIGNDA; ?><strong class="us"></strong></div>
  								<div class="_not">- sin asignar -</div>
  								<div class="a-dwn _anm"><?php echo Tra_Tag_Html('a-dwn') ?></div>
  							</div>
  						</div>


  						<div class="_cmpl">
  							<div class="btn_upd _ldr _anm"><button class="_anm"><?php echo TX_ARCHV; ?></button></div>
  							<div class="enf _anm"></div>
							<div class="asg">
  								<figure><div class="_img"></div></figure>
  								<div class="_nm"><?php echo TX_TRMNDA.' '.TX_BY.' '; ?><strong class="us"></strong></div>
  								<div class="_not">- sin asignar -</div>
  								<div class="a-dwn _anm"><?php echo Tra_Tag_Html('a-dwn') ?></div>
							</div>
  						</div>



						<div class="_arch">
  							<div class="btn_upd _anm"><button class="_anm"><?php echo $_tp_tt.' '.TX_ARCHVD; ?></button></div>
  							<div class="enf"></div>
  							<div class="asg">
  								<figure><div class="_img"></div></figure>
  								<div class="_nm"><?php echo TX_ASIGNDA; ?><strong class="us"></strong></div>
  								<div class="_not">- sin asignar -</div>
  							</div>
  						</div>


  					</div>
  					<div class="_right">
  						<div class="mn"></div>
  					</div>
  				</nav>
  				<div class="tme_i" id="tme<?php echo $_dt_tra->enc; ?>">
  					<span class="icn"></span>
  					<p class="min"></p>:<p class="seg"></p><p class="tx_tme"></p>
  				</div>
  			</div>
  			<div class="_bdy">
  				<div class="_left">

  					<?php //if($_sac_c!='ok'){ echo HTML_inp_tx('tramod_tt', '', '', '', '', '_anm _tt'); } ?>
					<?php

						if($_sac_c=='ok'){ $_tt_cls='disabled'; }
					  	if($_sac_c!='ok'){ echo HTML_textarea('tramod_tt', TX_TT, '', '', '', '_anm _tt', '1', '200', '', 'onkeydown="if(event.keyCode == 13){ SUMR_Tra.f.TxA({id:this}); return false; } "'.$_tt_cls ); }

						if($_sac_c =='ok' && !isN($_dt_tra->dsc)){ $_dsc_cls='disabled'; }
						echo HTML_textarea('tramod_dsc', TX_DSC, '', '', '', '_anm _dsc', '1', ''/*'200'*/, $_dt_tra->enc, 'onkeydown="if(event.keyCode == 13){ SUMR_Tra.f.TxA({id:this}); return false; } "'.$_dsc_cls );

					?>
					<div class="attch owl-carousel owl-theme"></div>
  					<div class="ctrl">
  						<h2></h2>
  						<div class="ctrl_row"></div>

  						<?php if($_dt_tra->col->chk->tck != 'ok' || ChckSESS_superadm()){ ?>
  						<div class="add_ctrl">
  							<?php echo HTML_textarea('tractrl_tt', '', '', '', '', '_anm ', '1', '200', '', 'onkeydown="if(event.keyCode == 13){ SUMR_Tra.f.TxA({id:this}); return false; }"'); ?>
  							<span><?php echo TX_ADDCTRL; ?></span>
  						</div>
  						<?php } ?>

  					</div>

  					<div class="actv">

						<?php

							$__tabs = [
										[ 'n'=>'act', 'l'=>TX_ACTVD.' Interna' ],
										[ 'n'=>'tmlne', 't'=>'cnv_tmlne', 't4'=>'tra', 'l'=>'e-Mail' ]
									];

							$___Dt->_dvlsfl_all($__tabs,[ 'id'=>$_dt_tra->enc, 'idb'=>'ok' ]);

						?>

						<div id="<?php echo $___Dt->tab->id ?>" class="TabbedPanels">
							<ul class="TabbedPanelsTabGroup">
								<?php echo $___Dt->tab->act->l ?>
								<?php if($_sac_c == 'ok'){ echo $___Dt->tab->tmlne->l; } ?>
							</ul>
							<div class="TabbedPanelsContentGroup">
								<div class="TabbedPanelsContent">
									<h2 class="advrt"><?php echo TX_ACTVD; ?> / Gestión<span> (Visible solo para usuarios de <?php echo DB_CL_NM ?>)</span></h2>
									<div class="tx_cmnt"><?php echo HTML_textarea('tracmnt_tt', '', '', '', '', '_anm ', '', '1500', '', 'onkeydown="if(event.keyCode == 13){ SUMR_Tra.f.TxA({id:this}); return false; }"'); ?></div>
									<div class="btn_c_cmnt"><button class="_anm btn_cmnt"><?php echo TX_DL; ?></button></div>
									<div class="cmnt_tra"></div>
									<div class="_aud_tra" style=" display: none;"></div>
								</div>
								<?php if($_sac_c == 'ok'){ ?>
								<div class="TabbedPanelsContent">
									<?php echo $___Dt->tab->tmlne->d; ?>
								</div>
								<?php } ?>
							</div>
						</div>


  					</div>

  				</div>
  				<div class="_right">
  					<ul>

					  	<li class="tck">
  							<span class="_icn"></span>
  							<div class="___tck _wrp">
  								<h3><i><?php echo 'Ticket #'. ( !isN($_dt_tra->mdl_cnt->id)?$_dt_tra->mdl_cnt->id:$_dt_tra->id ); ?></i></h3>
  							</div>
						</li>

  						<?php if(!isN($_dt_tra->mdl_cnt)){ ?>

  							<li class="mdl_cnt _anm" id="tra_mdl_cnt">
  								<span id="tra_mdl_img" class="img _anm _icn" style="background-image:url(<?php echo $_dt_tra->mdl_cnt->mdl->tp->img->big; ?>);"></span>
  								<div class="___mdlcnt _wrp">
  									<h3><?php echo 'Relación a '; ?></h3>
  									<div class="___mdl _anm">
  										<h2 id="tra_mdl_cnt_nm"><?php echo $_dt_tra->mdl_cnt->cnt->nm.' '.$_dt_tra->mdl_cnt->cnt->ap; ?></h2>
  										<h3 id="tra_mdl_nm"><?php echo $_dt_tra->mdl_cnt->mdl->nm; ?></h3>
										<span id="tra_mdl_cnt_fi"><?php echo $_dt_tra->mdl_cnt->fi; ?></span>
										<div id="tra_mdl_cnt_attr"><ul></ul></div>
  									</div>
  								</div>
  							</li>

  							<?php

  								$CntWb .= "

  									$('#tra_mdl_cnt').off('click').click(function(){

										var t2='';
										if(!isN(SUMR_Tra) && !isN(SUMR_Tra.t2)){ t2 = '&_t2='+SUMR_Tra.t2; }

  										_ldCnt({
  											u:'".Fl_Rnd(FL_LS_GN.__t('mdl_cnt', true)).TXGN_PNL.ADM_LNK_DT.$_dt_tra->mdl_cnt->enc."'+t2,
											pf:'".(!isN($___Dt->bx_rld)?$___Dt->bx_rld:'pop')."',
  											pop:'ok',
  											pnl:{
												e:'ok',
  												s:'lc',
  												tp:'h'
											}
  										});

  									});

  								";

  							?>

  						<?php } ?>

						<?php if(ChckSESS_superadm() || _ChckMd('tra_tmlne')){ ?>
							<li class="tmlne" rel="<?php echo $_dt_tra->mdl_cnt->enc; ?>">
								<span class="_icn"></span>
								<div class="___tmlne _wrp">
									<h3><?php echo 'Time-Line'; ?></h3>
									<div class="___tmlne _anm">
										<h2 id="tmlne_nm">Datos Históricos</h2>
									</div>
								</div>
							</li>
						<?php } ?>

						<?php if(!isN($_dt_tra->store->brnd->id) && _ChckMd('tra_brnd')){ ?>
							<li class="store_brnd _anm" id="tra_store_brnd">
								<span id="tra_store_brnd_img" class="img _anm _icn" style="background-image:url(<?php echo $_dt_tra->store->brnd->img; ?>);"></span>
								<div class="___storebrnd _wrp">
									<h3><?php echo 'Marca relacionada '; ?></h3>
									<div class="___brnd _anm" rel="<?php echo $_dt_tra->store->brnd->id; ?>">
										<h2 id="store_brnd_nm"><?php echo $_dt_tra->store->brnd->nm; ?></h2>
									</div>
								</div>
							</li>
						<?php }else{ ?>
							<?php if(_ChckMd('tra_brnd')){ ?>
								<li class="store_brnd _anm" id="tra_store_brnd">
									<span id="tra_store_brnd_img" class="img _anm _icn _empty"></span>
									<div class="___storebrnd _wrp">
										<h3><?php echo 'Marca relacionada '; ?></h3>
										<div class="___brnd _anm">
											<h2 id="store_brnd_nm">-Ninguna-</h2>
										</div>
									</div>
								</li>
							<?php } ?>
						<?php } ?>

						<?php if(_ChckMd('tra_col_mod')){ ?>
								<li class="tra_col_data _anm" id="tra_col_data">
									<span id="tra_col_data_img" class="img _anm _icn" style="background-image:url(<?php echo $_dt_tra->col->icn; ?>);"></span>
									<div class="___coldata _wrp">
										<h3><?php echo 'Columna'; ?></h3>
										<div class="___col_data _anm" rel="<?php echo $_dt_tra->col->id; ?>">
											<h2 id="tra_col_data_nm"><?php echo $_dt_tra->col->tt; ?></h2>
										</div>
									</div>
								</li>
							<?php } ?>

						<?php if($_sac_c == 'ok' && _ChckMd('tra_dlvry')){ ?>
							<li class="dlvry">
								<span class="_icn"></span>
								<div class="___dlvry _wrp">
									<h3><?php echo 'Logística'; ?></h3>
									<div class="___brnd _anm">
										<h2 id="dlvry_nm">-Sin Datos-</h2>
									</div>
								</div>
							</li>
						<?php } ?>

  						<li class="tme">
  							<span class="_icn"></span>
  							<div class="___tme _wrp">
  								<h3><?php echo TX_TTRCD; ?></h3>
  								<div class="tot_tme"><?php echo $_dt_tra->tme_t->time_tot; ?></div>
  								<div class="a-dwn"><?php echo Tra_Tag_Html('a-dwn') ?></div>
  							</div>
  							<button class="btn_tme_rgs" tra-id="<?php echo $_dt_tra->enc; ?>"><?php echo TX_INRGSTR; ?></button>
						</li>

  						<li class="lmt" id="lmt_<?php echo $_dt_tra->enc; ?>">
  							<span class="_icn"></span>
  							<div class="___lmt _wrp">
  								<h3><?php echo TX_FCHLMT; ?></h3>
  								<div class="a-dwn"><?php echo Tra_Tag_Html('a-dwn') ?></div>
  								<div class="lmt_f" id="lmt_f_<?php echo $_dt_tra->enc; ?>"></div>
  								<div class="lmt_h" id="lmt_h_<?php echo $_dt_tra->enc; ?>"></div>
  							</div>
  						</li>
  						<li class="obs">
  							<span class="img_obs _icn"></span>
  							<div class="___obs _wrp">
  								<h3><?php echo TX_OBSRVRS; ?></h3>
  								<div class="obs_dwn"><?php echo Tra_Tag_Html('a-dwn') ?></div>
  								<div class="add_obs">
  									<ul></ul>
  								</div>
  							</div>
  						</li>
  						<li class="tag">
  							<span class="_icn"></span>
  							<div class="___tag _wrp">
  								<h3><?php echo TX_TAGS; ?></h3>
  								<!--<div class="_tag"><?php //echo Tra_Tag_Html('a-dwn') ?></div>-->
  								<div class="ls_tag"></div>
  							</div>
  						</li>
  						<li class="inf">
  							<span class="_icn"></span>
  							<div class="___inf _wrp">
  								<h3><?php echo TX_INFTSK; ?></h3>
  								<div class="info">
  									<div class="col_nm"><span><?php echo $_dt_tra->col->tt; ?></span></div>
  									<div class="fch_crd"><span><?php echo $_dt_tra->fi->m; ?></span></div>
									<div class="fch_mod"><span><?php echo $_dt_tra->fa->m; ?></span></div>
									<div class="tmlne_shw"><span><?php echo $_dt_tra->fa->m; ?></span></div>
  								</div>
  							</div>
  						</li>
  					</ul>
  				</div>
  			</div>
  		</div>
  	</div>
</div>
<?php

  	$CntWb .= '

		document.documentElement.style.setProperty("--tra_dt_clr", "'.$_dt_tra->clr->vl.'");

		SUMR_Tra.f.DtEst({ e:"'.$_dt_tra->est.'", enc:"'.$_dt_tra->enc.'" });

  		setTimeout(function(){

  			SUMR_Tra.f.AutoH({ id:"#tramod_tt", val:"'.$_dt_tra->tt.'" });
  			SUMR_Tra.f.AutoH({ id:"#tramod_dsc", val:"'.addslashes($_dt_tra->dsc).'" });
  			SUMR_Tra.f.AutoH({ id:"#tra_f", val:"'.$_dt_tra->f.'" });
  			SUMR_Tra.f.AutoH({ id:"#tra_h", val:"'.$_dt_tra->h.'" });
			SUMR_Tra.f.o();

  		}, 1000);

  	';

?>
<?php } ?>