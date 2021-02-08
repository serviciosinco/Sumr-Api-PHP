	<?php 
		
	if(class_exists('CRM_Cnx')){
		
		$___Ls->cnx->aut = 'ok';
		$___Ls->sch->f = 'atmt_nm';
	
		$___Ls->new->w = 500;
		$___Ls->new->h = 300;
		$___Ls->edit->w = 650;
		$___Ls->edit->h = 800;	
		$___Ls->ls->lmt = 500;
			
		$___Ls->_strt();
		
		
		if(!isN($___Ls->gt->i)){	
			 
			$___Ls->qrys = sprintf("	SELECT *
										FROM ".TB_ATMT."
										WHERE ".$___Ls->ik." = %s 
										LIMIT 1", GtSQLVlStr($___Ls->gt->i, "text")
									);	
			
		}elseif($___Ls->_show_ls == 'ok'){
		
			$Ls_Tot_Mdl = " ( SELECT DISTINCT COUNT(*) FROM ".DB_CL.".".TB_MDL_ATMT." WHERE mdlatmt_atmt = id_atmt) AS __tot_mdl";
			$Ls_Tot_Trg = " ( SELECT DISTINCT COUNT(*) FROM ".TB_ATMT_TRGR." WHERE atmttrgr_atmt = id_atmt ) AS __tot_trgr";
			$Ls_Tot_Trg_Act = " ( SELECT DISTINCT COUNT(*) FROM ".TB_ATMT_TRGR_ACT." INNER JOIN ".TB_ATMT_TRGR." ON atmttrgract_trgr = id_atmttrgr WHERE atmttrgr_atmt = id_atmt ) AS __tot_trgr_act";
			$Ls_Tot_Trg_Cndc = " ( SELECT DISTINCT COUNT(*) FROM ".TB_ATMT_TRGR_CNDC." INNER JOIN ".TB_ATMT_TRGR." ON atmttrgrcndc_trgr = id_atmttrgr WHERE atmttrgr_atmt = id_atmt ) AS __tot_trgr_cndc";
			$Ls_Tot_Trg_Sgm = " ( SELECT DISTINCT COUNT(*) FROM ".TB_ATMT_TRGR_SGM." INNER JOIN ".TB_ATMT_TRGR." ON atmttrgrsgm_trgr = id_atmttrgr WHERE atmttrgr_atmt = id_atmt ) AS __tot_trgr_sgm";
									
			$Ls_Whr = " FROM ".TB_ATMT."
							 INNER JOIN "._BdStr(DBM).TB_CL." ON atmt_cl = id_cl 
						WHERE ".$___Ls->ino." != '' ".$___Ls->sch->cod." AND cl_enc = '".DB_CL_ENC."' 
						ORDER BY atmt_on ASC, ".$___Ls->ino." DESC";
			
			$___Ls->qrys = "SELECT *, 
									(SELECT COUNT(*) $Ls_Whr) AS __rgtot, 
									$Ls_Tot_Mdl, $Ls_Tot_Trg, $Ls_Tot_Trg_Act, $Ls_Tot_Trg_Cndc, $Ls_Tot_Trg_Sgm 
							$Ls_Whr";
		
					
		} 
	
		
		$___Ls->_bld();
		
		
	?>
	<?php if($___Ls->ls->chk=='ok'){ ?>
		<div class="Ls_Rg_Wrp">
		<?php $___Ls->_bld_l_hdr();  ?>
		<?php if(($___Ls->qry->tot > 0)){ ?>
			
			<table width="100%" border="0" cellpadding="0" cellspacing="0" class="Ls_Rg LsRgNw LsRgAtmt">
			  	<tbody>
					  <?php do { ?>
					  <?php if($___Ls->ls->rw["atmt_on"] == 1){ $on = 'Si'; $cls_e='on'; }elseif($___Ls->ls->rw["atmt_on"] == 2){ $on = 'No'; $cls_e='off'; } ?>
			          <tr class="<?php echo $cls_e; ?>">
			            <td align="left" width="95%" class="__icn_ls"><?php echo h2(ctjTx($___Ls->ls->rw['atmt_nm'],'in')); ?></td>
			            <td align="center" width="1%" class="_cn"><?php echo Strn($___Ls->ls->rw['__tot_mdl']).HTML_BR.Spn('Módulos') ?></td>
			            <td align="center" width="1%" class="_cn"><?php echo Strn($___Ls->ls->rw['__tot_trgr']).HTML_BR.Spn('Disparadores') ?></td>
			            <td align="center" width="1%" class="_cn"><?php echo Strn($___Ls->ls->rw['__tot_trgr_act']).HTML_BR.Spn('Acciones') ?></td>
			            <td align="center" width="1%" class="_cn"><?php echo Strn($___Ls->ls->rw['__tot_trgr_cndc']).HTML_BR.Spn('Condiciones') ?></td>
			            <td align="center" width="1%" class="_cn"><?php echo Strn($___Ls->ls->rw['__tot_trgr_sgm']).HTML_BR.Spn('Segmentos') ?></td>
			            <td align="center" width="1%" class="_cn"><?php echo Strn($on).HTML_BR.Spn('Activo') ?></td>
			            <?php if(_ChckMd('atmt_mod')){ ?>
				            <td width="1%" align="left" nowrap="nowrap">
				                <?php if( $_lnktr_l != ''){ echo HTML_Ls_Btn(  ['t'=>'edt', 'js'=>'ok', 'l'=>_Ls_Lnk_Rw(['l'=>$_lnktr_l, 'sb'=>$__lssb, 'r'=>$__bxrld ]) ]); } ?>
				            </td>
			            <?php } ?>
			            	 <td width="1%" align="left"><?php echo $___Ls->_btn([ 't'=>'mod' ]); ?></td>
			          </tr>
			          <?php } while ($___Ls->ls->rw = $___Ls->sql->fetch_assoc()); ?>
				</tbody>
			</table>
			
		<?php  $___Ls->_bld_l_pgs(); ?>
		<?php }?>
		<?php $___Ls->_h_ls_nr(); ?>
		</div>
		
		<style>		
			.Ls_Rg_Wrp{ padding: 20px 25px; }		
			.LsRgNw.LsRgAtmt td._cn{ text-align: center; }
			.LsRgNw.LsRgAtmt tr.on{  }
			.LsRgNw.LsRgAtmt tr.off{  }			
			.LsRgNw.LsRgAtmt tr td{ padding-top: 5px; padding-bottom: 13px; }
			.LsRgNw.LsRgAtmt tr td.__icn_ls{ background-repeat: no-repeat; background-position: left 10px center; background-size: auto 50%; padding-left: 50px; }
			.LsRgNw.LsRgAtmt tr.on td.__icn_ls{ background-image: url(<?php echo _iEtg(DMN_IMG_ESTR_SVG.'atmt_on.svg') ?>); }
			.LsRgNw.LsRgAtmt tr.off td.__icn_ls{ background-image: url(<?php echo _iEtg(DMN_IMG_ESTR_SVG.'atmt_off.svg') ?>); }
		</style>
			
	<?php } ?>
	
	<?php if($___Ls->fm->chk=='ok'){ 
		
		
		$____plcy = GtAtmtPlcyLs([ 'atmt'=>$___Ls->dt->rw['id_atmt'], 'e'=>'on' ]);
		
	?>
	<div class="FmTb __atmt_detail">
	  <div id="<?php echo $___Ls->fm->bx->id ?>">         
			  
		 	<?php 
			  
			  	$__atm_etp = GtAtmtEtpLs([ 'auto'=>$___Ls->dt->rw[$___Ls->ino] ]);
			  	$__tabs = [ 
			  				['n'=>'mdl', 't'=>'atmt_mdl', 'l'=>TX_MDLS], 
			  				['n'=>'etp', 't'=>'atmt_etp', 'l'=>TX_ETPS, 's'=>'ok'] 
			  			];
			  	
			  	foreach($__atm_etp->ls as $_k=>$_v){
					$__tabs[] = [ 'n'=>'etp_'.$_v->etp->key, 't'=>'atmt_trgr', 'l'=>$_v->tt, 'cls'=>'_etp', 'm'=>'&__etp='.$_v->etp->enc ];
				}
			  	
			  	$___Ls->_dvlsfl_all($__tabs,[ 'idb'=>'ok' ]);
	
		  	?>
		  	<div id="<?php echo $___Ls->tab->id ?>" class="VTabbedPanels mny <?php if($___Ls->dt->tot == 0){ echo '_new'; } ?>">
	            <ul class="TabbedPanelsTabGroup">
		            <?php echo $___Ls->tab->bsc->l ?>
		            <?php echo $___Ls->tab->mdl->l ?>
	                <?php foreach($__atm_etp->ls as $_k=>$_v){ echo $___Ls->tab->{'etp_'.$_v->etp->key}->l; } ?>
	              </ul>
	              <div class="TabbedPanelsContentGroup">
	                    <div class="TabbedPanelsContent _main">
	                      	
	                      	<form method="POST" name="<?php echo $___Ls->fm->id; ?>" target="_self" id="<?php echo $___Ls->fm->id; ?>">
		                      	
		                      	<?php $___Ls->_bld_f_hdr(); ?>  
		                      				
								<div id="<?php echo $___Ls->fm->fld->id ?>">
		
									<?php if($___Ls->dt->tot > 0){ ?>
									<div class="ln_1" id="__edt_dtl">
										<div class="col_1">
											
											<div class="__bx_dt __fm_opt">
												<div class="__btn" style="z-index: 99999999; ">
													 	<?php $_lnktr_l = FL_LS_GN.__t('cnt',true).TXGN_POP._SbLs_ID().ADM_LNK_DT.$__dt_cnt->id.$__vrall.$_adsch.TXGN_BX.DV_LSFL.Gn_Rnd(20); ?>
												        <?php if( !_DtV() ){ ?>
												            <?php echo '<a href="'.Void().'" class="___edt_btn">'.TX_EDIT.'</a>' ; ?> 
												            <?php 
																$CntWb .= '$(".___edt_btn").click(function(){ 
																				
																				$("#__edt_dtl").fadeOut("fast", function(){
																					$("#__edt").fadeIn();	
																				});
																				
												
																			}); ';
															?>
												        <?php } ?>
												</div>
											</div>
		
											<?php echo h1( ctjTx($___Ls->dt->rw['atmt_nm'],'in') ); ?>
											<ul class="ls_1" >
												<li><?php echo Strn('De (remitente):'). ctjTx($___Ls->dt->rw['atmt_frm'],'in') ; ?></li>	
											</ul>
											
											<?php echo h2(MDL_HBSDTA); ?>
											<?php 
												
												if($____plcy->tot > 0){
													
													foreach($____plcy->ls as $plcy_k=>$plcy_v){
														
														if($plcy_v->tot>0){ $cls='on'; $cls_v=1; }else{ $cls='off'; $cls_v=2; }
														$__dattr = ' data-atmt="'.$___Ls->dt->rw['atmt_enc'].'" data-plcy="'.$plcy_v->enc.'" ';
														
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
																		'plcy_'.$___Ls->dt->rw['atmt_enc'].'_'.$plcy_v->enc
																	);
													}
													
													echo ul($__plcy_li, '_plcy_ls');
												}
												
											?>
											
											
										</div>
										<div class="col_2">
											
											<?php echo h2( 'Estadísticas Resumen' ); ?>
											
										    <div id="__grph_crsl" class="owl-carousel">
										        <div class="item">	<div id="bx_grph" class="__bl">% Apertura</div>	</div>
										        <div class="item">	<div id="bx_grph2" class="__bl">% Rebote</div>	</div>
										        <div class="item">	<div id="bx_grph3" class="__bl">% Desuscript</div>	</div>
										        <div class="item">	<div id="bx_grph4" class="__bl">Horarios Apertura</div>	</div>
										        <div class="item">	<div id="bx_grph5" class="__bl">Navegador</div>	</div>
										        <div class="item">	<div id="bx_grph6" class="__bl">Sistema Operativo</div>	</div>
										        <div class="item">	<div id="bx_grph7" class="__bl">Campañas Resumen</div>	</div>
										    </div>
										
		
										</div>
									</div>
									<?php } ?>		
									
									<div class="ln_1" id="__edt" <?php if($___Ls->dt->tot > 0){ ?>style="display: none;"<?php } ?> >
											<div class="col_1">
							                    <?php echo h2(TX_DTSBSC); ?> 
												<?php echo HTML_inp_tx('atmt_nm', TX_NM, ctjTx($___Ls->dt->rw['atmt_nm'],'in')); ?>
												<?php 
													echo LsClEml('atmt_sndr','id_eml', $___Ls->dt->rw['atmt_sndr'], 'Seleccione Sender', 2, '', 'Width'); 
													$CntWb .= JQ_Ls('atmt_sndr', '- seleccione sender -');	
												?>
							                </div>
							                <div class="col_2">
												<div style="display:flex;">
													<?php echo h2('Activo '); ?>                                              		
													<?php echo OLD_HTML_chck('atmt_on', 'Activo', $___Ls->dt->rw['atmt_on'], 'in'); ?>
												</div>
												<div style="display:flex;">
													<?php echo h2('Tods los Modulos '); ?>                                             		
													<?php echo OLD_HTML_chck('atmt_allmdl', 'Tods los Modulos', $___Ls->dt->rw['atmt_allmdl'], 'in'); ?>
												</div>
							                </div>
									</div>
			
								</div>
							
							</form>
							
							<!-- Inicia Etapas Editar -->
	                            <div class="ln">
	                                <?php if($___Ls->dt->tot > 0){ echo $___Ls->tab->etp->d; } ?> 
	                            </div> 
	                        <!-- Finaliza Etapas Editar -->
	                             
	                    </div>
	                    <div class="TabbedPanelsContent">
	                        <?php echo $___Ls->tab->mdl->d ?>          
	                    </div> 
	                    <?php foreach($__atm_etp->ls as $_k=>$_v){ ?>
	                    <div class="TabbedPanelsContent">
	                        <?php echo $___Ls->tab->{'etp_'.$_v->etp->key}->d; ?>          
	                    </div> 
	                    <?php } ?>
	                                                    
	              	</div>
	              	
	              	<style>
				  	
				  		
				  		.__atmt_detail .VTabbedPanels.mny._new > ul.TabbedPanelsTabGroup{ display: none; }
				  		.__atmt_detail .VTabbedPanels.mny._new > div.TabbedPanelsContentGroup{ width: 100%; border: none; }
					  	
					  	.__atmt_detail .VTabbedPanels.mny{ display: flex; }	
				        .__atmt_detail .VTabbedPanels.mny > ul.TabbedPanelsTabGroup{ background-color: white; width:45px !important; }
				        .__atmt_detail .VTabbedPanels.mny > div.TabbedPanelsContentGroup{ border-left: 1px dotted #bcbfbf; }
				        .__atmt_detail .VTabbedPanels.mny > div.TabbedPanelsContentGroup .TabbedPanelsContent{ padding-top: 30px; }
				        .__atmt_detail .VTabbedPanels.mny > div.TabbedPanelsContentGroup .TabbedPanelsContent._main{ padding-top: 0; }
				        
				        
				        .__atmt_detail .VTabbedPanels .Tt_Tb .btn{ margin-right: 0 !important; }
				        .__atmt_detail .VTabbedPanels .TabbedPanelsTab{ background-size: 60% auto; background-position: center center; min-height: 35px; min-width: 35px; max-width: 35px; background-repeat: no-repeat; opacity: 0.3; } 
				        .__atmt_detail .VTabbedPanels .TabbedPanelsTabSelected,
				        .__atmt_detail .VTabbedPanels .TabbedPanelsTabHover{ opacity: 1; background-color: white !important; }
				        
				        .__atmt_detail .VTabbedPanels .TabbedPanelsTab._bsc{ background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>atmt_main.svg); }
				        .__atmt_detail .VTabbedPanels .TabbedPanelsTab._mdl{ background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>atmt_mdl.svg); }
						.__atmt_detail .VTabbedPanels .TabbedPanelsTab._etp{ background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>atmt_etp.svg); }
				        
				        .__atmt_detail .__slc_ok{ border: none; padding-top: 20px; }
				        .__atmt_detail .__slc_ok h3{ display: none; }
				        
				        .__atmt_detail .Tt_Tb{ padding-left: 20px; }
				        
			        </style>
	           
	        </div>
	        
	    	
	  	</div>
	
	</div>


<?php
	
	
	if(_ChckMd('chck_snd_i')){        
	
		$CntWb .= " 
		
			$('.__atmt_detail ._plcy_ls > li .opt button').off('click').click(function(e){
					
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
					var _atmt = $(this).attr('data-atmt');
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
							t:'atmt_sndi', 
							plcy:_plcy,
							atmt:_atmt,
							est:_e,
							_bs:function(){  },
							_cm:function(){  },
							_cl:function(_r){ 
								if(!isN(_r)){ 
									if(!isN(_r.e) && _r.e=='ok'){
										swal('Cambio Exitoso', '".TX_APROEXT."', 'success');	
										$('#plcy_'+_atmt+'_'+_plcy).removeClass('on off').addClass(_e_c);
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

			$('.__atmt_detail ._plcy_ls > li .opt button').off('click').click(function(e){
					
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
	.cnt_wrap{ padding: 0 !important; }
</style>
<?php } ?>
<?php } ?>