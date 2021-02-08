<section class="_wrp upd" style="opacity:0; filter: alpha(opacity=0);">
	
	<?php if($__tab_thm != 'ok'){ 
		
		if($___cntbddt->comp == 'ok'){ $__new_cls = 'oth_sty'; }
		
	?>
	
		<style type="text/css" media="screen">
			
			<?php if($___cntbddt->comp == 'ok'){ ?>
					._wrp.upd header._lgo{width:220px;margin:0 auto -50px}
					._wrp.upd .oth_sty .VTabbedPanels .TabbedPanelsContentGroup{margin:0 auto;padding: 20px 20px 0px 20px;}
					._wrp.upd .oth_sty .TabbedPanelsContent{border-bottom:5px solid #ffffff8c;padding-bottom:0px !important}			
					._wrp.upd .oth_sty .list-1.bsc,
					._wrp.upd .oth_sty .pnote.strt.rfr{margin-top:0!important; margin-bottom: 20px;}
					._wrp.upd .oth_sty .psub{padding:10px 0!important;font-size:12px!important}
					._wrp.upd .oth_sty .pnote{font-size:11px;padding:10px 40px}
					._wrp.upd .oth_sty._cnt ._icn{width:30%}
					._wrp.upd .oth_sty ._cnt h2{vertical-align:top;font-size:24px;display: inline-block !important}
					._wrp.upd .oth_sty._cnt ._dt_cnt .pmain{padding-top:10px;padding-bottom:10px;font-size:12px !important}
					._wrp.upd .oth_sty .title{display:flex}
					._wrp.upd .oth_sty._cnt ._dt_cnt ._icn{width:30%;display:inline-block}
					._wrp.upd .oth_sty._cnt ._dt_cnt h2{width:59%;display:inline-block}
					._wrp.upd .oth_sty ._only{border-bottom:0!important}
					._wrp.upd .oth_sty .TabbedPanelsContent,._wrp.upd .list-1.big li{padding-bottom:10px}
					._wrp.upd .oth_sty ._wrp.upd .oth_sty .list-1 li._new,._wrp.upd .list-1.sblst{margin-top:10px}
					._wrp.upd .oth_sty ._only.oth::before{content:""}
					._wrp.upd .oth_sty li.oth:not(._mod_on)._only{margin:10px auto;width:250px!important;height:38px;border-radius:8px;border:1px solid #787878!important}
					._wrp.upd .oth_sty ._only.oth:not(._mod_on)::before{content:"NUEVO DOCUMENTO";background-image:url(/img/estr/upd_cnt_docs.svg)!important;width:100%!important;display:block;position:relative!important;top:0!important;left:0!important;text-transform:uppercase;font-family:'Yanone Kaffeesatz',Economica,sans-serif;color:#000;font-size:14px;background-repeat:no-repeat;background-position:left 10px top 2px!important;background-size:auto 60%;cursor:pointer;opacity:.5;-webkit-transition-property:all;-moz-transition-property:all;-ms-transition-property:all;-o-transition-property:all;transition-property:all;-webkit-transition-duration:.4s;-moz-transition-duration:.4s;-ms-transition-duration:.4s;-o-transition-duration:.4s;transition-duration:.4s;-webkit-transition-timing-function:ease-in-out;-moz-transition-timing-function:ease-in-out;-ms-transition-timing-function:ease-in-out;-o-transition-timing-function:ease-in-out;transition-timing-function:ease-in-out;-webkit-transition-delay:0;-moz-transition-delay:0;-ms-transition-delay:0;-o-transition-delay:0;transition-delay:0}
					._wrp.upd .oth_sty ._only.oth:hover::before{background-size:auto 70%!important;opacity:1;font-size:16px}
					._wrp.upd .list-1 li._new{ margin-top: 0px !important; margin-bottom: 0 !important }	
					._wrp.upd .oth_sty ._last .pnote.strt.rfr,
					.___doc .pnote.no{ display: none; }
					._wrp.upd .list-1 li._last{ border-bottom: 0px !important; }
			<?php }else{ ?>
					._wrp.upd ._lgo{ width: 220px;margin: 50px auto -50px auto;}
					.VTabbedPanels .TabbedPanelsContentGroup{ margin: 0 auto; }
					.TabbedPanelsContent { border-bottom: 5px solid #ffffff8c; padding-bottom: 32px; }
					._wrp.upd .list-1.bsc,
					._wrp.upd .pnote.strt.rfr{ margin-top: 0 !important; }	
			<?php } ?>

			
		</style>
		
		<header class="_lgo"></header>	
		
	<?php } ?>					
    		
	<div class="_cnt <?php echo $__new_cls ?>">
	
		<?php
		
			//print_r($___cntbddt);
			
			$__shrt = new CRM_Shrt([ 'cl'=>$_cl_dt->enc ]);
			
			$_id_tbpnl = 'TabPnl_'.Gn_Rnd(20);
			
			if($__tab_thm == 'ok'){
				$_CntJQ_Spry .= $_id_tbpnl." = new Spry.Widget.TabbedPanels('".$_id_tbpnl."', { defaultTab: 1 }); "; 
				$_CntJQ_Spry .= _DvLsFl([ 'i'=>$___Ls->tb->eml ]);  		
			}

			if(isN($__dtcnt->id) || ($__dtdvrf->e != 'ok' && $___cnt_no_tel == 'no' && $___cnt_no_eml == 'no') ){ $_TTbGrp_hde = '_hde'; }
			
			if(!isN($__dtcnt->plcy)){
				foreach($__dtcnt->plcy->ls as $_plcy_k=>$_plcy_v){
					if($_plcy_v->on == 'ok'){
						$__dtcnt_sndi = 'ok';
						$__dtcnt_sndi_on[] = $_plcy_v->id;	
					}
				}
			}
			
		?>
	    
	    <div style="width: 100%;" id="<?php echo $_id_tbpnl ?>" class="TabbedPanels VTabbedPanels">
		    <?php if($__tab_thm == 'ok'){ ?>
	      		<ul class="TabbedPanelsTabGroup <?php echo $_TTbGrp_hde; ?>">
		      		
			     	<li class="TabbedPanelsTab non_clic" tabindex="0"><header class="_lgo"></header>	</li>
				   	<li class="TabbedPanelsTab _bsc" tabindex="1">Datos Básicos</li>
				   	<?php if($___cntbddt->dc == 'ok' || isN($___cntbddt)){ ?><li class="TabbedPanelsTab _doc" tabindex="2">Documentos</li><?php } ?>
				   	<?php if($___cntbddt->tel == 'ok' || isN($___cntbddt)){ ?><li class="TabbedPanelsTab _tel" tabindex="2">Teléfonos</li><?php } ?>
				   	<?php if($___cntbddt->eml == 'ok' || isN($___cntbddt)){ ?><li class="TabbedPanelsTab _eml" tabindex="3">Correos</li><?php } ?>
				   	<?php if($___cntbddt->cd == 'ok' || isN($___cntbddt)){ ?><li class="TabbedPanelsTab _geo" tabindex="3">Geográficos</li><?php } ?>
				   	<?php if($___cntbddt->emp == 'ok' || $___cntbddt->md == 'ok' || isN($___cntbddt)){ ?><li class="TabbedPanelsTab _emp" tabindex="3">Empresa</li><?php } ?>
				   	<?php if($___cntbddt->uni == 'ok' || isN($___cntbddt)){ ?><li class="TabbedPanelsTab _uni" tabindex="3">Universidad</li><?php } ?>
				   	<?php if($___cntbddt->clg == 'ok' || isN($___cntbddt)){ ?><li class="TabbedPanelsTab _clg" tabindex="3">Colegio</li><?php } ?>
				   	<?php if($___cntbddt->fnt == 'ok'){ ?><li class="TabbedPanelsTab _fnt" tabindex="3">Fuente</li><?php } ?>
	      		</ul>
	      	<?php } ?>
		  	<div class="TabbedPanelsContentGroup">
	        	<div class="TabbedPanelsContent non_clic">
		        	1	   
	        	</div>
				<div class="TabbedPanelsContent">
					
					<div class="_dt_cnt">
						<div class="_icn"></div>
						<h2>Actualizar Datos <div class="_sub"><?php echo '<span style=" background-image : url('.DMN_FLE_BD.$___cntbddt->img.') "></span>'; ?> <?php echo TX_BD.' '.$___cntbddt->tt ?></div></h2>
						<div class="pmain"><?php echo $_cl_dt->tag->txta->{'plcy-upd-txt'}->v; ?></div>
					</div>	
					
					<?php if(!isN($__dtcnt) && ($__dtdvrf->e == 'ok' || ($___cnt_no_tel == 'ok' && $___cnt_no_eml == 'ok') || !isN($__dtsnd->enc) )){ ?>
						
						<!--
						<form id="Fm_upd_ec" class="upd_fm _off _anm">
							<div class="_slc _anm">
								<ul class="opt">
									<li class="_ofrst _non _anm"><button class="upd _anm" id="opt_upd">Modificar</button></li>
									<li class="_ofrst _non _anm _or"> <span>o</span> </li>
									<li class="_ofrst _anm">
										<button class="add _anm" id="opt_add">Agregar nuevo</button>
										<ul class="opt_sub _anm">	
											
											
											<li><button class="add bck _anm" id="opt_add_bck">Volver</button></li>
										</ul>
									</li>
								</ul>	
							</div>
							<div class="_edt _anm">
								<input type="hidden" id="_cnt" name="_cnt" value="<?php echo $__dtcnt->enc; ?>">
								<div class="bx_c"></div>
								
							</div>
						</form>	
						-->
					
					<?php }else{ ?>	
						
						<?php include('cnt/dt/ec_getcnt.php'); ?>
					
					<?php } ?>
					
					
					<?php if(!isN($__dtcnt) && ($__dtdvrf->e == 'ok' || ($___cnt_no_tel == 'ok' && $___cnt_no_eml == 'ok') ) || !isN($__dtsnd->enc) ){ ?>
					<!--<h2 class="dts_bsc"><?php echo Spn().TX_DTSBSC ?></h2>-->
					
					<?php echo HTML_inp_hd('CRef'.$__ec->id_rnd, $_ref); ?>
					
					
					<ul class="list-1 bsc" data-cnt-enc="<?php echo $__dtcnt->enc ?>">
						<?php
							if($___cntbddt->fld_nm == 'ok'){ ?>
								<li class="_anm _mod" data-tp="cnt" data-id="nm" data-in-tp="text" data-vl="<?php echo $__dtcnt->nm; ?>">
									<div class="_pr"><strong>Nombre</strong> <?php echo $__dtcnt->nm; ?></div>
								</li>	
							<?php }else{ ?>
								<li class="_anm"><strong>Nombre</strong> <?php echo $__dtcnt->nm; ?></li>	
							<?php }
								
							if($___cntbddt->fld_ap == 'ok'){ ?>
								<li class="_anm _mod" data-tp="cnt" data-id="ap" data-in-tp="text" data-vl="<?php echo $__dtcnt->ap; ?>">
									<div class="_pr"><strong>Apellido</strong> <?php echo $__dtcnt->ap; ?></div>
								</li>	
							<?php }else{ ?>
								<li class="_anm"><strong>Apellido</strong> <?php echo $__dtcnt->ap; ?></li>	
							<?php }
						?>

						<?php if(isN($__dtcnt->fn)){ $_fn_cls='_empty'; } ?>
						<?php if($___cntbddt->fn == 'ok' || isN($___cntbddt)){ ?>
							
							<li class="_anm _mod <?php echo $_fn_cls; ?>" data-tp="cnt" data-id="fn" data-in-tp="date" data-vl="<?php echo $__dtcnt->fn; ?>">
								<div class="_pr"><strong>Fecha de Nacimiento</strong> <?php echo $__dtcnt->fn; ?></div>
							</li>
							
						<?php } ?>

						<?php if($__dtcnt->sx->id == _CId('ID_SX_N_DF')){ $_sx_cls='_empty'; } ?>
						<?php if($___cntbddt->gnr == 'ok' || isN($___cntbddt)){ ?>
							<li class="_anm _mod <?php echo $_sx_cls; ?>" data-tp="cnt" data-id="sx" data-in-tp="sis-list" data-vl="<?php echo $__dtcnt->sx->enc; ?>" data-vl-tx="<?php echo $__dtcnt->sx->tt; ?>">
								<div class="_pr"><strong>Genero</strong> <?php echo $__dtcnt->sx->tt; ?></div>
							</li>
						<?php } ?>
						
						<?php if($__tab_thm == 'ok'){ ?>
							<li class="_anm">
								<?php $__shr_url = $__shrt->get([ 'url'=>DMN_EC.$_cl_dt->sbd.'/update/?_rf='.$__dtcnt->enc ])->url; ?>
								<div class="pnote strt rfr"><?php echo $_cl_dt->tag->txta->{'upd-note-rfr'}->v; ?></div>
								<br><?php echo $__shr_url ?><br><strong>Código de Referencia</strong><br><br>
								
	
								
								<div class="addthis_inline_share_toolbox"></div>
								<script type="text/javascript">
									
									var addthis_share = {
									   url: "<?php echo $__shr_url ?>",
									   title: "Actualiza tus datos",
									   description: "THE DESCRIPTION",
									   media: "THE IMAGE"
									}
									
								</script>
	
								<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-5c7c00f8f9fe2e6d"></script>
								
	
							</li>
						<?php } ?>
						 
					</ul>	
					<?php } ?>
					
	            </div>
	            <?php if($___cntbddt->dc == 'ok' || isN($___cntbddt)){ ?>
		        	<div class="TabbedPanelsContent ___doc">
			        	<h2 class="dts_docs"><?php echo Spn().TX_DOCS; ?></h2>
			        	<?php if(!isN($__dtcnt->dc_a)){ ?>
			        		<?php if($___cntbddt->comp != 'ok' || isN($___cntbddt)){ ?>
								<div class="psub">Los documentos de identidad asociados a su perfil son:</div>
							<?php } ?>
				        	<ul class="list-1 sblst big doc">
				        	<?php foreach($__dtcnt->dc_a as $_k_doc => $_v_doc){ ?>
					        	<li>
					        		<?php echo Spn($_v_doc->t).' '.__tel_scre([ 'v'=>$_v_doc->n ]); ?>
					        	</li>
				        	<?php } ?>
				        	</ul>
				        	
				        	<div class="pnote"><?php echo $_cl_dt->tag->txta->{'upd-note-doc'}->v; ?></div>
				        	
				        <?php }elseif( $___cntbddt->comp == 'ok' && !isN($___cntbddt) ){  ?>
				        	
				        	<div class="dtl_doc">
						        <ul class="list-1 bsc" data-cnt-enc="<?php echo $__dtcnt->enc ?>">
									<li class="_anm oth _only _mod <?php echo $_fn_cls; ?>" data-tp="cnt" data-id="dc" data-in-tp="text" data-vl="<?php echo $__dtcnt->dc; ?>"></li>
						        </ul>
				        	</div>
					        <div class="pnote no"><?php echo $_cl_dt->tag->txta->{'upd-note-doc'}->v; ?></div>
					    <?php }else{ ?>
							<div class="pnote"><?php echo $_cl_dt->tag->txta->{'upd-note-doc'}->v; ?></div>
						<?php } ?>
			        </div>      
	            <?php } ?>
	            <?php if($___cntbddt->tel == 'ok' || isN($___cntbddt)){ ?>  
	            	<div class="TabbedPanelsContent">
		        	
					<h2 class="dts_tels"><?php echo Spn().TX_CLRS; ?></h2>
					<?php if($___cntbddt->comp != 'ok'){ ?>
						<div class="psub">Los teléfonos y celulares asociados a su perfil son:</div>
					<?php } ?>
		        		<ul class="list-1 sblst big tel">
				        	<?php if(!isN($__dtcnt->tel)){ ?>
					        	<?php foreach($__dtcnt->tel_all->ls as $_k_tel => $_v_tel){ ?>
					        		<?php $img_th = _ImVrs([ 'img'=>$_v_tel->img_ps, 'f'=>DMN_FLE_PS ]); ?>
						        	<li class="_anm" data-vl="<?php echo $_v_tel->enc ?>">
						        		
						        		<div  class="_img_ps1" style="background-image:url(<?php echo $img_th->th_50; ?>);"></div>
						        		
						        		<?php echo __tel_scre([ 'v'=>$_v_tel->tel ]); ?>
						        		
						        		<?php foreach($__dtcnt->plcy->ls as $_plcy_k=>$_plcy_v){ ?>
						        			<?php if($_plcy_v->on == 'ok'){ ?>
						        				<?php $__hbs = $_v_tel->plcy->ls->{$_plcy_v->enc}; ?>
						        				<?php if($__hbs->tot > 0){ $_tsndi_l='on'; }else{ $_tsndi_l='off'; } ?>
						        				<div class="_plcy <?php echo $_tsndi_l ?>" id="plcy_<?php echo $_v_tel->enc ?>_<?php echo $_plcy_v->enc ?>">
							        				<div class="nm"><?php echo $_plcy_v->nm; ?></div>
									        		<div class="opt _anm">	
										        		<button class="_del _anm" data-vl="<?php echo $_v_tel->enc ?>" data-mod-tp="tel" data-prc-tp="del">Ya no uso <span>este número</span></button>
										        		<?php if($__hbs->sndi == 'ok'){ $_tsndi_d='off'; $_tel_sndi_tt='on'; }else{ $_tsndi_d='on'; $_tel_sndi_tt='off'; } ?>
										        		<button class="_sndi <?php echo $__hbs->sndi; ?> _anm" data-vl="<?php echo $_v_tel->enc ?>" data-mod-tp="sndi" data-prc-tp="<?php echo $_tsndi_d; ?>" data-plcy-id="<?php echo $_plcy_v->enc; ?>">Llamadas<span><?php echo $_tel_sndi_tt; ?></span></button>	
										        		<?php if($__hbs->sms == 'ok'){ $_sms_d='off'; $_tel_sms_tt='on'; }else{ $_sms_d='on'; $_tel_sms_tt='off'; } ?>
										        		<button class="_sms <?php echo $__hbs->sms; ?> _anm" data-vl="<?php echo $_v_tel->enc ?>" data-mod-tp="sms" data-prc-tp="<?php echo $_sms_d; ?>" data-plcy-id="<?php echo $_plcy_v->enc; ?>">SMS<span><?php echo $_tel_sms_tt; ?></span></button>			        		
										        		<?php if($__hbs->whtsp == 'ok'){ $_whtsp_d='off'; $_tel_whtsp_tt='on'; }else{ $_whtsp_d='on'; $_tel_whtsp_tt='off'; } ?>
										        		<button class="_whtsp <?php echo $__hbs->whtsp; ?> _anm" data-vl="<?php echo $_v_tel->enc ?>" data-mod-tp="whtsp" data-prc-tp="<?php echo $_whtsp_d; ?>" data-plcy-id="<?php echo $_plcy_v->enc; ?>">Whatsapp<span><?php echo $_tel_whtsp_tt; ?></span></button>
										        	</div>
						        				</div>
							        		<?php } ?>
							        	<?php } ?>
							        	
							        	
						        	</li>
					        	<?php } ?>
				        	<?php } ?>
			        		
			        		<li class="_anm _new"><button class="add tel _anm" id="opt_add_tel">Nuevo Teléfono</button></li>
			        	</ul>
			        	   
	        	</div>
	            <?php } ?>
	            <?php if($___cntbddt->eml == 'ok' || isN($___cntbddt)){ ?> 
	        		<div class="TabbedPanelsContent">
		        	
			        	<h2 class="dts_emls"><?php echo Spn().TX_EMAIL; ?></h2>
			        	<?php if($___cntbddt->comp != 'ok'){ ?>
			        		<div class="psub">Los correos asociados a su perfil son:</div>
			        	<?php } ?>
			        	<ul class="list-1 sblst mdm eml">
				        	
					        <?php if(!isN($__dtcnt->eml)){ ?>	
					        	<?php foreach($__dtcnt->eml as $_eml_k=>$_eml_v){ ?>
					        		<?php if($_eml_v->rjct=='ok'){ $_cls_eml='_lckd'; $_cls_eml_tt='No apto para envio (Hard Bounce)'; }else{ $_cls_eml=''; } ?>
									<?php if(!isN($_eml_v->v)){ ?>
										<?php if(!isN($_eml_v->est) && $_eml_v->est == _CId('ID_SISEMLEST_ACT') ){ ?>
												<li class="_anm" data-vl="<?php echo $_eml_v->eml->enc ?>">
												<?php echo $__icn_sub_eml.__eml_scre([ 'v'=>$_eml_v->v ]).Spn('','','_tt_icn _tt_icn_lckd','','',$_cls_eml_tt); ?>
									
												<?php foreach($__dtcnt->plcy->ls as $_plcy_k=>$_plcy_v){ ?>
													<?php if($_plcy_v->on == 'ok'){ ?>
														<?php $__hbs = $_eml_v->plcy->ls->{$_plcy_v->enc}; ?>
														<?php if($__hbs->tot > 0){ $_tsndi_l='on'; }else{ $_tsndi_l='off'; } ?>
														<div class="_plcy <?php echo $_tsndi_l ?>" id="plcy_<?php echo $_eml_v->eml->enc ?>_<?php echo $_plcy_v->enc ?>">
															<div class="nm"><?php echo $_plcy_v->nm; ?></div>
															<div class="opt _anm">	
																<button class="_del _anm" data-vl="<?php echo $_eml_v->eml->enc ?>" data-mod-tp="eml" data-prc-tp="del">Ya no uso <span>este correo</span></button>
																<?php if($__hbs->tot > 0){ $_tsndi_d='off'; $_eml_sndi_tt='on'; }else{ $_tsndi_d='on'; $_tel_sndi_tt='off'; } ?>
																<button class="_sndi <?php if($__hbs->tot > 0){ echo 'ok'; }else{ echo 'no'; } ?> _anm" data-vl="<?php echo $_eml_v->eml->enc ?>" data-mod-tp="sndi" data-prc-tp="<?php echo $_tsndi_d; ?>" data-plcy-id="<?php echo $_plcy_v->enc; ?>">Recibir Info<span><?php echo $_tel_sndi_tt; ?></span></button>	
															</div>
														</div>
													<?php } ?>
												<?php } ?>

												<!--
													<div class="opt _anm">
														<button class="_del _anm" data-vl="<?php echo $_eml_v->eml->enc ?>" data-mod-tp="eml" data-prc-tp="del">Ya no uso <span>este correo</span></button>
														
														<?php if($_eml_v->sndi == 'ok'){ $_eml_d='off'; $_eml_tt='on'; }else{ $_eml_d='on'; $_eml_tt='off'; } ?>
														<button class="_sndi <?php echo $_eml_v->sndi ?> _anm" data-vl="<?php echo $_eml_v->eml->enc ?>" data-mod-tp="sndi" data-prc-tp="<?php echo $_eml_d; ?>">Recibir Info<span><?php echo $_eml_tt; ?></span></button>
													</div>
												-->
											</li>
										<?php } ?>  		
									<?php } ?>
					        	<?php } ?>
				        	<?php } ?>	
			        	
			        		<li class="_anm _new"><button class="add eml _anm" id="opt_add_eml">Nuevo Correo</button></li>
			        	</ul>
			       
	        	</div>
	        	<?php } ?>
	        	<?php if($___cntbddt->cd == 'ok' || isN($___cntbddt)){ ?> 
	        		<div class="TabbedPanelsContent">
		        	<h2 class="dts_geo"><?php echo Spn().'Geográficos'; ?></h2>
		        	<div class="psub">Los datos geográficos asociados a su perfil son:</div>

		        	<ul class="list-1 sblst big geo">
			        	
			        	<?php 
				        	
				        	foreach($__dtcnt->cd as $__k=>$__v){ 
				        		if($__v->rel->id == _CId('ID_TPRLCC_VVE')){	
					        		$___cd_lve_id = $__v->cd->id;	
									$___cd_lve_tt = $__v->cd->tt;	
									$___cd_lve_icn = $__v->ps->img->url->th_50;
								}elseif($__v->rel->id == _CId('ID_TPRLCC_NCO')){	
					        		$___cd_nco_id = $__v->cd->id;	
									$___cd_nco_tt = $__v->cd->tt;	
									$___cd_nco_icn = $__v->ps->img->url->th_50;
								}
							}	
					        	
			        	?>
			        	
			        	
			        	<?php 
				        	if(isN($___cd_lve_id)){ $_fn_geo_vve='_empty'; } 
				        	if(!isN($___cd_lve_id)){ $___cd_lve_id_go = $___cd_lve_id; }else{ $___cd_lve_id_go = '-'; }
				        	if(!isN($___cd_lve_tt)){ $___cd_lve_tt_go = $___cd_lve_tt; }else{ $___cd_lve_tt_go = '-'; }
				        	
				        ?>
			        	<li class="_anm _mod <?php echo $_fn_geo_vve; ?>" data-tp="cnt" data-id="cd" data-rel="vve" data-in-tp="city" data-vl="<?php echo $___cd_lve_id_go; ?>" data-vl-tx="<?php echo $___cd_lve_tt_go; ?>">
							<div class="_pr"><strong>Vive en</strong> <span style="background-image:url(<?php echo $___cd_lve_icn; ?>);" class="_flg"></span> <?php echo $___cd_lve_tt_go; ?></div>
						</li>
						
						<?php 
							if(isN($___cd_nco_id)){ $_fn_geo_nco='_empty'; } 
							if(!isN($___cd_nco_id)){ $___cd_nco_id_go = $___cd_nco_id; }else{ $___cd_nco_id_go = '-'; }
				        	if(!isN($___cd_nco_tt)){ $___cd_nco_tt_go = $___cd_nco_tt; }else{ $___cd_nco_tt_go = '-'; }
						?>
						<li class="_anm _mod <?php echo $_fn_geo_nco; ?>" data-tp="cnt" data-id="cd" data-rel="nco" data-in-tp="city" data-vl="<?php echo $___cd_nco_id_go; ?>" data-vl-tx="<?php echo $___cd_nco_tt_go; ?>">
							<div class="_pr"><strong>Nació en</strong> <span style="background-image:url(<?php echo $___cd_nco_icn; ?>);" class="_flg"></span> <?php echo $___cd_nco_tt_go; ?></div>
						</li>
			        	
		        	</ul>
			        	
		        </div>
	        	<?php } ?>
				<?php if($___cntbddt->emp == 'ok' || $___cntbddt->md == 'ok' || isN($___cntbddt)){ ?>
		        	<div class="TabbedPanelsContent">
			        <h2 class="dts_emp"><?php echo Spn().'Empresa'; ?></h2>
			        <?php if($___cntbddt->comp != 'ok'){ ?>
			        	<div class="psub">Las empresas asociadas a su perfil son:</div>
					<?php } ?>
			        <ul class="list-1 sblst mdm emp">			    
			        	<?php if(!isN($__dtcnt->org->emp->ls)){ ?>
				        	<?php foreach($__dtcnt->org->emp->ls as $__k=>$__v){  ?>
				        		<?php //if($__v->tpr->id == _CId('ID_ORGCNTRTP_TRB_PRST')){ ?>
								<li class="_anm <?php echo $__v->tpr->cns; ?>" data-tp="cnt" data-id="org" data-rel="trb_prst" data-in-tp="emp" data-vl="<?php echo $__v->r_enc; ?>" data-vl-tx="<?php echo $__v->nm; ?>">
									<div class="_pr"><span style="border-color:<?php echo $__v->clr; ?>; " class="_log"><figure style="background-image:url(<?php echo $__v->img->th_50; ?>);"></figure></span> <?php echo $__v->nm; ?><strong class="subtt"><?php echo $__v->tpr->tt; ?></strong> </div>
									<div class="opt _anm">
										<button class="_org _mod _anm" data-vl="<?php echo $__v->r_enc; ?>" data-mod-tp="emp" data-prc-tp="mod">Ya no <span>trabajo aquí</span></button>
										<button class="_org _del _anm" data-vl="<?php echo $__v->r_enc; ?>" data-mod-tp="emp" data-prc-tp="del">Nunca he <span>trabajado aquí</span></button>
									</div>
								</li>								
								<?php //} ?>
							<?php } ?>	
						<?php } ?>
						<li class="_anm _new"><button class="add emp _anm" id="opt_add_emp">Nuevo Empleo</button></li>	
		        	</ul>
		        	
		        </div>
		        <?php } ?>
		        <?php if($___cntbddt->uni == 'ok' || isN($___cntbddt)){ ?>
		        	<div class="TabbedPanelsContent">
			        <h2 class="dts_uni"><?php echo Spn().'Universidad'; ?></h2>
			        <?php if($___cntbddt->comp != 'ok'){ ?>
			        	<div class="psub">Los universidades asociadas a su perfil son:</div>
			        <?php } ?>
			        <ul class="list-1 sblst mdm uni">
			        	<?php if(!isN($__dtcnt->org->uni->ls)){ ?>	
				        	<?php foreach($__dtcnt->org->uni->ls as $__k=>$__v){ ?>
				        		<?php //if($__v->tpr->id == _CId('ID_ORGCNTRTP_ESTD_PRST') || $__v->tpr->id == _CId('ID_ORGCNTRTP_ESTD_PAS')){ ?>
								<li class="_anm <?php echo $__v->tpr->cns; ?>" data-tp="cnt" data-id="org" data-rel="trb_prst" data-in-tp="uni" data-vl="<?php echo $__v->r_enc; ?>" data-vl-tx="<?php echo $__v->nm; ?>">
									<div class="_pr"><span style="border-color:<?php echo $__v->clr; ?>; " class="_log"><figure style="background-image:url(<?php echo $__v->img->th_50; ?>);"></figure></span> <?php echo $__v->nm; ?><strong class="subtt"><?php echo $__v->tpr->tt; ?></strong> </div>
									<div class="opt _anm">
										<button class="_org _mod _anm" data-vl="<?php echo $__v->r_enc; ?>" data-mod-tp="uni" data-prc-tp="mod">Ya no <span>estudio aquí</span></button>
										<button class="_org _del _anm" data-vl="<?php echo $__v->r_enc; ?>" data-mod-tp="uni" data-prc-tp="del">Nunca <span>he estudiado aquí</span></button>
									</div>
								</li>
								<?php //} ?>
							<?php } ?>	
						<?php } ?>
						<li class="_anm _new"><button class="add uni _anm" id="opt_add_uni">Nueva Universidad</button></li>
		        	</ul>
		        	
		        </div>
		        <?php } ?>
		        <?php if($___cntbddt->clg == 'ok' || isN($___cntbddt)){ ?>
		        	<div class="TabbedPanelsContent">
			        <h2 class="dts_clg"><?php echo Spn().'Colegio'; ?></h2>
			        <?php if($___cntbddt->comp != 'ok'){ ?>
			        	<div class="psub">Los colegios asociados a su perfil son:</div>
			        <?php } ?> 
			        <ul class="list-1 sblst mdm clg">
			        	<?php if(!isN($__dtcnt->org->clg->ls)){ ?>	
				        	<?php foreach($__dtcnt->org->clg->ls as $__k=>$__v){ ?>
				        		<?php //if($__v->tpr->id == _CId('ID_ORGCNTRTP_ESTD_PRST') || $__v->tpr->id == _CId('ID_ORGCNTRTP_ESTD_PAS')){ ?>
								<li class="_anm <?php echo $__v->tpr->cns; ?>" data-tp="cnt" data-id="org" data-rel="trb_prst" data-in-tp="uni" data-vl="<?php echo $__v->r_enc; ?>" data-vl-tx="<?php echo $__v->nm; ?>">
									<div class="_pr"><span style="border-color:<?php echo $__v->clr; ?>; " class="_log"><figure style="background-image:url(<?php echo $__v->img->th_50; ?>);"></figure></span> <?php echo $__v->nm; ?><strong class="subtt"><?php echo $__v->tpr->tt; ?></strong> </div>
									<div class="opt _anm">
										<button class="_org _mod _anm" data-vl="<?php echo $__v->r_enc; ?>" data-mod-tp="clg" data-prc-tp="mod">Ya no <span>estudio aquí</span></button>
										<button class="_org _del _anm" data-vl="<?php echo $__v->r_enc; ?>" data-mod-tp="clg" data-prc-tp="del">Nunca he <span>estudiado aquí</span></button>
									</div>
								</li>
								<?php //} ?>
							<?php } ?>	
						<?php } ?>
						<li class="_anm _new"><button class="add colg _anm" id="opt_add_clg">Nuevo Colegio</button></li>
		        	</ul>
		        	
		        </div>	
		        <?php } ?>

		        <?php if($___cntbddt->fnt == 'ok' || isN($___cntbddt)){ ?>
		        	<div class="TabbedPanelsContent">
			        <h2 class="dts_clg"><?php echo Spn().'Fuente'; ?></h2>
			        <div class="psub">Las fuentes periodisticas que cubres son:</div>
			        
			        <?php $__report_d = __LsDt(['k'=>'fnt_que_cbr']);  ?>
					<ul class="list-1 bsc" data-cnt-enc="<?php echo $__dtcnt->enc ?>">
				    	<?php
					    	
					    	foreach($__dtcnt->attr as $_k => $_v){
						       $item[] = $_v->attr;
					        }
					    
					        foreach($__report_d->ls->fnt_que_cbr as $k => $v){
						        
						        if (in_array($v->id, $item)){ $vl = 'ok';  }else{ $vl = 'no'; }
						        
						        echo '<li id="_fnt_'.$v->id.'" class="_anm ___fnts '.$vl.'" rel="'.$v->id.'"><figure class="_anm" style="background-image:url('.$v->img.')"></figure>'.$v->tt.'</li>';
					        }
			        	?>  
			    	</ul>
			       
			         
			       
		        	
		        </div>	
		        <?php } ?>

		        <?php if($__tab_thm != 'ok'){ ?>

			        <ul class="list-1 bsc" data-cnt-enc="<?php echo $__dtcnt->enc ?>">
						<li class="_anm _last">
							<?php $__shr_url = $__shrt->get([ 'url'=>DMN_EC.$_cl_dt->sbd.'/update/?_rf='.$__dtcnt->enc ])->url; ?>
							<div class="pnote strt rfr"><?php echo $_cl_dt->tag->txta->{'upd-note-rfr'}->v; ?></div>
							<br><?php echo $__shr_url ?><br><strong>Código de Referencia</strong><br><br>
							<div class="addthis_inline_share_toolbox"></div>
							<script type="text/javascript">
								
								var addthis_share = {
								   url: "<?php echo $__shr_url ?>",
								   title: "Actualiza tus datos",
								   description: "THE DESCRIPTION",
								   media: "THE IMAGE"
								}
								
							</script>
							<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-5c7c00f8f9fe2e6d"></script>
						</li>
					</ul>
				<?php } ?>
	      	</div>   	  
		</div>
	
	</div>

</section>
<style type="text/css" media="screen">
	.___fnts{ width: 90px !important;display: inline-block; border: 0 !important; cursor: pointer }
	.___fnts figure{ width: 25px;height: 25px;background-position: center center;background-repeat: no-repeat;background-size: 90% auto;vertical-align: middle;margin: 5px auto;	-webkit-filter: grayscale(100%);filter: grayscale(100%);	} 
	.___fnts:hover figure{ background-size: 100% auto !important; -webkit-filter: grayscale(0%) !important; filter: grayscale(0%) !important; }
	.___fnts.ok figure{ -webkit-filter: grayscale(0%) !important; filter: grayscale(0%) !important; }
</style>