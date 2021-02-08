<?php 
if(class_exists('CRM_Cnx')){
	
	$___Ls->cnx->aut = 'ok';
	$___Ls->sch->f = 'Trigger_sisslc_tt';
	$___Ls->_strt();
	
	
	if(!isN($___Ls->gt->i)){	
		 
		$___Ls->qrys = sprintf("	SELECT *,
										   "._QrySisSlcF([ 'als'=>'t', 'als_n'=>'Trigger' ]).",
										   "._QrySisSlcF([ 'als'=>'d', 'als_n'=>'Delay']).",
										   "._QrySisSlcF([ 'als'=>'s', 'als_n'=>'Schedules']).",
										   ".GtSlc_QryExtra([ 't'=>'fld', 'p'=>'Trigger', 'als'=>'t' ]).", 
										   ".GtSlc_QryExtra([ 't'=>'fld', 'p'=>'Delay', 'als'=>'d' ]).",
										   ".GtSlc_QryExtra([ 't'=>'fld', 'p'=>'Schedules', 'als'=>'s' ])."
										   
									FROM ".TB_ATMT_TRGR."
										 INNER JOIN ".TB_ATMT." ON atmttrgr_atmt = id_atmt
										 ".GtSlc_QryExtra([ 't'=>'tb', 'col'=>'atmttrgr_trgr', 'als'=>'t' ])."
										 ".GtSlc_QryExtra([ 't'=>'tb', 'col'=>'atmttrgr_dly', 'als'=>'d' ])."
										 ".GtSlc_QryExtra([ 't'=>'tb', 'col'=>'atmttrgr_sch', 'als'=>'s' ])."
									WHERE ".$___Ls->ik." = %s 
									LIMIT 1", GtSQLVlStr($___Ls->gt->i, "text")
								);	

	}elseif($___Ls->_show_ls == 'ok'){
		
		if(!isN($___Ls->gt->isb)){ $__fl .= $___Ls->_andsql([ 'f'=>'atmt_enc', 'v'=>$___Ls->gt->isb ]); }
		if(!isN($___Ls->gt->etp)){ $__fl .= " AND cletp_enc='".$___Ls->gt->etp."' "; }
		
		$Ls_Whr = "	FROM ".TB_ATMT_TRGR."
						 INNER JOIN ".TB_ATMT." ON atmttrgr_atmt = id_atmt
						 INNER JOIN "._BdStr(DBM).TB_CL_ETP." ON atmttrgr_etp = id_cletp
						 ".GtSlc_QryExtra([ 't'=>'tb', 'col'=>'atmttrgr_trgr', 'als'=>'t' ])."
						 ".GtSlc_QryExtra([ 't'=>'tb', 'col'=>'atmttrgr_dly', 'als'=>'d' ])."
						 ".GtSlc_QryExtra([ 't'=>'tb', 'col'=>'atmttrgr_sch', 'als'=>'s' ])."
			  		WHERE ".$___Ls->ino." != '' $_f_tp $__fl 
			  		ORDER BY atmttrgr_ord ASC";
			   
		$___Ls->qrys = "SELECT *, 
						  (SELECT COUNT(*) $Ls_Whr) AS __rgtot,
						  
						  "._QrySisSlcF([ 'als'=>'t', 'als_n'=>'Trigger' ]).",
						  "._QrySisSlcF([ 'als'=>'d', 'als_n'=>'Delay']).",
						  "._QrySisSlcF([ 'als'=>'s', 'als_n'=>'Schedules']).",
						 
						  ".GtSlc_QryExtra([ 't'=>'fld', 'p'=>'Trigger', 'als'=>'t' ]).", 
						  ".GtSlc_QryExtra([ 't'=>'fld', 'p'=>'Delay', 'als'=>'d' ]).",
						  ".GtSlc_QryExtra([ 't'=>'fld', 'p'=>'Schedules', 'als'=>'s' ])."
						  
						  $Ls_Whr";
					  
					  		
	} 

	
	$___Ls->_bld();
	$___days_week = _WkDays();
	
	
?>
<?php if($___Ls->ls->chk=='ok'){ ?>
<?php $___Ls->_bld_l_hdr(); ?>
<?php if(($___Ls->qry->tot > 0)){ ?>

<table width="100%" border="0" cellpadding="0" cellspacing="0" class="Ls_Rg LsRgNw LsSpcl">
  <tbody>
		  <?php do { 
			  
			  if($___Ls->ls->rw['atmttrgr_hbl'] == 2){ $__cls_tr = '_off'; }else{ $__cls_tr = ''; }
		  ?>
          <tr <?php $atmttrgrdt = GtAtmtTrgrDt([ 'id'=>$___Ls->ls->rw[$___Ls->ino], 'ls'=>'ok' ]); ?> class="<?php echo $__cls_tr; ?>">   
		          
            <td align="left" <?php echo $_clr_rw ?> class="__sgm_ls" width="1%" valign="top"><?php echo Spn($___Ls->ls->rw['atmttrgr_ord'], '', '_etp_n'); ?></td>
            <td align="left" <?php echo $_clr_rw ?>>
	            <?php 
		           
		            
		            $___days = [];
		            $___invk = [];
		            $___ls_sgm = '';
		            $___ls_act = '';
		            $___ls_cndc = '';
		            $__icn_tt = '';
		            
					foreach($___days_week as $_k => $_v){
						if($___Ls->ls->rw['atmttrgr_sch_d_'.$_v->id] == 1){ $___days[] = li($_v->sgl); }
					}

					if($___Ls->ls->rw['atmttrgr_rpt'] == 1){
						$__icn_tt .= bdiv([ 'cls'=>'trgr_rpt' ]);
					}
					  
					if($___Ls->ls->rw['atmttrgr_lnl'] == 1){
						$__icn_tt .= bdiv([ 'cls'=>'trgr_lnl' ]);
					}									
					
					if(count($atmttrgrdt->ls->sgm->tot) > 0){
						foreach($atmttrgrdt->ls->sgm->ls as $_k => $_v){
							$___ls_sgm .= li($_v->nm);
						}
					}
					
					if(count($atmttrgrdt->ls->act->tot) > 0){
						foreach($atmttrgrdt->ls->act->ls as $_k => $_v){
							$___ls_act .= li($_v->nm);
						}
					}
					
					if(count($atmttrgrdt->ls->cndc->tot) > 0){
						foreach($atmttrgrdt->ls->cndc->ls as $_k => $_v){
							$___ls_cndc .= li($_v->nm);
						}
					}
														
		            echo h2( ctjTx($___Ls->ls->rw['atmttrgr_nm'],'in') . 
		              		   bdiv([
			              		    'cls'=>'trgr_icn',
		              		   		'c'=>$__icn_tt
		              		   ])
		              	   );
		              
		            
		              	   
		            echo bdiv([ 'c'=>ctjTx($___Ls->ls->rw['Trigger_sisslc_tt'],'in'), 'cls'=>'c1' ]);
		            echo bdiv([ 'c'=>Strn('Actualizado: ').Spn(ctjTx($___Ls->ls->rw['atmttrgr_fa'],'in')), 'cls'=>'c1' ]);
		            echo bdiv([ 'c'=>Strn('Esperar: ').$___Ls->ls->rw['atmttrgr_dly_v']. ' ' .ctjTx($___Ls->ls->rw['Delay_sisslc_tt'],'in'), 'cls'=>'c1' ]);
		            echo bdiv([ 'c'=>Strn('Ejecutar: ').
		            	   							ctjTx($___Ls->ls->rw['Schedules_sisslc_tt'],'in') . 
													Spn( _DteHTML([ 'd'=>$___Ls->ls->rw['atmttrgr_sch_h1'], 'nd'=>'no' ]).' - '.
													   	 _DteHTML([ 'd'=>$___Ls->ls->rw['atmttrgr_sch_h2'], 'nd'=>'no' ])
													,'ok')
		            	   
		            	   , 'cls'=>'c1' ]);
		            
		            if(!isN($___days)){	   
		            	echo bdiv([ 'c'=>Strn('Dias: ').ul( implode('', $___days), '__days'), 'cls'=>'c1 __days_bx' ]);
		            }	   
		            	   
					if(!isN($___ls_sgm)){
            	   		echo bdiv([ 'c'=>Strn('Segmento: ').(!isN($___ls_sgm)?ul($___ls_sgm):''), 'cls'=>'c1' ]);
            	   	}

				   	if(!isN($___ls_act)){
            	   		echo bdiv([ 'c'=>Strn('Acción: ').(!isN($___ls_act)?ul($___ls_act):''), 'cls'=>'c1 __action_bx' ]);
            	   	}
            	   
				   	if(!isN($___ls_cndc)){
            	   		echo bdiv([ 'c'=>Strn('Condiciones: ').(!isN($___ls_cndc)?ul($___ls_cndc):''), 'cls'=>'c1' ]); 
				   	}
				   	
				   	
				   	$___invk[] = li('', mBln($___Ls->ls->rw['atmttrgr_invk_api']).' api','','',['tt'=>'API']);
				   	$___invk[] = li('', mBln($___Ls->ls->rw['atmttrgr_invk_up']).' up','','',['tt'=>'Carga']);
				   	$___invk[] = li('', mBln($___Ls->ls->rw['atmttrgr_invk_crm']).' crm','','',['tt'=>'Manual']);
				   	$___invk[] = li('', mBln($___Ls->ls->rw['atmttrgr_invk_auto']).' auto','','',['tt'=>'CronJob']);
				   	$___invk[] = li('', mBln($___Ls->ls->rw['atmttrgr_invk_form']).' form','','',['tt'=>'Formulario']);

                
				   	if(!isN($___invk)){	   
		            	echo bdiv([ 'c'=>Strn('Fuentes: ').ul( implode('', $___invk), '__invk'), 'cls'=>'c1 __invk_bx' ]);
		            }
		        
		        ?>
	        </td>
			
            <?php if(ChckSESS_superadm() || (_ChckMd('ec_trgr_mod'))){ ?>
	            <td width="1%" align="left" nowrap="nowrap">
	                <?php echo $___Ls->_btn([ 't'=>'mod' ]); ?>
	            </td>
            <?php } ?>
          </tr>
          <?php } while ($___Ls->ls->rw = $___Ls->sql->fetch_assoc()); ?>
  </tbody>
</table>

<style>
	
	.__days_bx{ display: flex; margin-top: 5px; }
	.__days_bx strong{ margin-right: 5px; }
	.__days_bx .__days{ white-space: nowrap; width: 100%; text-align: left; display: flex; margin: 0; padding: 0; }
	.__days_bx .__days li{ text-transform: lowercase; border-radius:200px; -moz-border-radius:200px; -webkit-border-radius:200px; width: 20px; height: 20px; background-color: #ced5d8; display: inline-block; margin: 0 2px; text-align: center !important; line-height: 20px; color: #ffffff; font-weight: bolder; font-size: 10px; }
	
	
	.__action_bx{}
	.__action_bx li{ font-size:10px; color: #95a1b0; }
	
	
	.__invk_bx{ display: flex; margin-top: 5px; }
	.__invk_bx strong{ margin-right: 5px; }
	.__invk_bx .__invk{ white-space: nowrap; width: 100%; text-align: left; display: flex; margin: 0; padding: 0; }
	.__invk_bx .__invk li{ text-transform: lowercase; width: 20px; height: 20px; background-color:transparent; display: inline-block; margin: 0 5px 0 0; text-align: center !important; line-height: 20px; }
	.__invk_bx .__invk li.ok{ opacity: 1; }
	.__invk_bx .__invk li.no{ opacity: 0.5; -webkit-filter: grayscale(100%); filter: grayscale(100%); }
	
	.__invk_bx .__invk li.api{ background-image: url(<?php echo _iEtg(DMN_IMG_ESTR_SVG.'atmt_invk_api.svg') ?>); }
	.__invk_bx .__invk li.up{ background-image: url(<?php echo _iEtg(DMN_IMG_ESTR_SVG.'atmt_invk_up.svg') ?>); }
	.__invk_bx .__invk li.crm{ background-image: url(<?php echo _iEtg(DMN_IMG_ESTR_SVG.'atmt_invk_crm.svg') ?>); }
	.__invk_bx .__invk li.auto{ background-image: url(<?php echo _iEtg(DMN_IMG_ESTR_SVG.'atmt_invk_auto.svg') ?>); }
	.__invk_bx .__invk li.form{ background-image: url(<?php echo _iEtg(DMN_IMG_ESTR_SVG.'atmt_invk_form.svg') ?>); }
	
	
	.LsRgNw.LsSpcl tr:nth-child(even){ background-color: transparent !important; }
	.LsRgNw.LsSpcl tr td{ padding-top: 20px; padding-bottom: 20px; }
	
	
	.LsRgNw.LsSpcl td.__sgm_ls{ background-image: url(<?php echo _iEtg(DMN_IMG_ESTR_SVG.'atmt_trgr_icn.svg') ?>); background-repeat: no-repeat; background-position: top 28px left 10px; padding-left: 60px; background-size: 30px auto; /*opacity: 0.6;*/ }
	.LsRgNw.LsSpcl tr:hover td.__sgm_ls{ background-position: top 32px left 10px; opacity: 1; }
	
	
	.LsRgNw.LsSpcl tr._off:hover{ opacity: 1; }
	.LsRgNw.LsSpcl tr._off ._etp_n{ background-color:#800000; }


</style>

<?php $___Ls->_bld_l_pgs(); ?>
<?php }?>
<?php $___Ls->_h_ls_nr(); ?>
<?php } ?>
<?php if($___Ls->fm->chk=='ok'){ ?>
<div class="FmTb __atmt_trgr">
  	<div id="<?php echo $___Ls->fm->bx->id ?>">                       
    <form method="POST" name="<?php echo $___Ls->fm->id; ?>" target="_self" id="<?php echo $___Ls->fm->id; ?>">
     	
     	<?php $___Ls->_bld_f_hdr(); ?> 
	  
	 	<?php 
		  
		  	$___Ls->_dvlsfl_all([ 
		  		['n'=>'hra', 'l'=>'Horarios'], 
		  		['n'=>'fnt', 'l'=>'Fuentes'], 
		  		['n'=>'sgm', 't'=>'atmt_trgr_sgm', 'l'=>'Segmentos'], 
		  		['n'=>'act', 't'=>'atmt_trgr_act', 'l'=>'Acciones', 's'=>'ok'],
		  		['n'=>'cndc', 't'=>'atmt_trgr_cndc', 'l'=>'Condicionales', 's'=>'ok'] 
		  	],[ 'idb'=>'ok' ]);

			
	  	?>
	  	<div id="<?php echo $___Ls->tab->id ?>" class="VTabbedPanels mny <?php if($___Ls->dt->tot == 0){ ?>__new<?php } ?>">
        <ul class="TabbedPanelsTabGroup">
	        <?php echo $___Ls->tab->bsc->l ?>
	        <?php echo $___Ls->tab->hra->l ?>
	        <?php echo $___Ls->tab->fnt->l ?>
	        <?php echo $___Ls->tab->sgm->l ?>
	        <?php echo $___Ls->tab->act->l ?>
	        <?php echo $___Ls->tab->cndc->l ?>
        </ul>
        <div class="TabbedPanelsContentGroup">
            <div class="TabbedPanelsContent">
              				
				<div id="<?php echo $___Ls->fm->fld->id ?>">
					
					<?php if($___Ls->dt->tot > 0){ ?>
					
					<?php 
						
						echo h1( Spn($___Ls->dt->rw['atmttrgr_ord'], '', '_etp_n'). 
								   	
								   bdiv([
								   			'c'=>ctjTx($___Ls->dt->rw['atmttrgr_nm'],'in').HTML_BR. 
								   				 Spn(ctjTx($___Ls->dt->rw['Trigger_sisslc_tt'],'in'),'','_sbt').HTML_BR.
								   				 Spn($atmttrgrdt->trgr->ls->d->tt).HTML_BR.
								   				 Spn($atmttrgrdt->trgr->ls2->d->tt),
								   			'cls'=>'_bx'	 
								   		])
								   		   
							   , '_etp'); 
					?>
							
							
					<div class="ln_1 __dtl _anm" id="__edt_dtl<?php echo $___Ls->fm->id; ?>">
						<div class="col_1">
							
							<div class="__bx_dt __fm_opt">
								<div class="__btn" style="z-index: 99999999; ">
								 	<?php $_lnktr_l = FL_LS_GN.__t('cnt',true).TXGN_POP._SbLs_ID().ADM_LNK_DT.$__dt_cnt->id.$__vrall.$_adsch.TXGN_BX.DV_LSFL.Gn_Rnd(20); ?>
							        <?php if( !_DtV() ){ ?>
							            <?php echo '<a href="'.Void().'" class="___edt_btn" id="___edt_btn'.$___Ls->fm->id.'">'.TX_EDIT.'</a>' ; ?>
							            <?php 
											$CntWb .= '$("#___edt_btn'.$___Ls->fm->id.'").click(function(){ 
															
															$("#__edt_dtl'.$___Ls->fm->id.'").addClass("_non").fadeOut("fast", function(){
																$("#__edt'.$___Ls->fm->id.'").fadeIn();	
															});
															
							
														}); ';
										?>
							        <?php } ?>
								</div>
							</div>
							
							<ul class="ls_1" >
								<li><?php echo Strn('Esperar: '). $___Ls->dt->rw['atmttrgr_dly_v']. ' ' .ctjTx($___Ls->dt->rw['Delay_sisslc_tt'],'in') ; ?></li>
								<li><?php echo Strn('Enviar: '). 
									 		   ctjTx($___Ls->dt->rw['Schedule_sisslc_tt'],'in') . 
											   Spn( _DteHTML([ 'd'=>$___Ls->dt->rw['atmttrgr_sch_h1'], 'nd'=>'no' ]).' - '.
											   		_DteHTML([ 'd'=>$___Ls->dt->rw['atmttrgr_sch_h2'], 'nd'=>'no' ])
											   	,'ok') ; 
									?>
								</li>
								<li><?php echo Strn(TX_TLNL.': ').  _sino( $___Ls->dt->rw['atmttrgr_lnl'] ) . bdiv([ 'cls'=>'trgr_icn', 'c'=>bdiv([ 'cls'=>'trgr_lnl' ]) ])  ; ?></li>
								<li><?php echo Strn(TX_CCLC.': '). _sino( $___Ls->dt->rw['atmttrgr_rpt'] ) . bdiv([ 'cls'=>'trgr_icn', 'c'=>bdiv([ 'cls'=>'trgr_rpt' ]) ]) ; ?></li>
							</ul>	
							
							<?php echo h2( 'Dias' ); ?>
							<ul class="ls_1 __days" >
								<?php $___days_week = _WkDays();
									foreach($___days_week as $_k => $_v){
								?>
									<li class="<?php echo _sinoDwn( $___Ls->dt->rw['atmttrgr_sch_d_'.$_v->id] ); ?>"><?php echo $_v->sgl ?></li>
								<?php } ?>
								
							</ul>
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
					
					<div class="ln_1 __form _anm" id="__edt<?php echo $___Ls->fm->id; ?>" <?php if($___Ls->dt->tot > 0){ ?>style="display: none;"<?php } ?> >
						
						
						<div class="blq_ln_fll">
							
							<?php echo h2('Disparador'); ?> 
		                    <?php echo HTML_inp_hd('atmttrgr_atmt', !isN($___Ls->dt->rw['atmttrgr_atmt'])?$___Ls->dt->rw['atmttrgr_atmt']:_SbLs_ID('i') ); ?>
							<?php echo HTML_inp_hd('atmttrgr_etp', !isN($___Ls->dt->rw['atmttrgr_etp'])?$___Ls->dt->rw['atmttrgr_etp']:_SbLs_Etp('i') ); ?>
							<?php 
								
								$l = __Ls([	'k'=>'sis_atmt_trgr', 
											'id'=>'atmttrgr_trgr', 
											'va'=>$___Ls->dt->rw['atmttrgr_trgr'], 
											'ph'=>FM_LS_SLGN]); 
								
								echo $l->html; 
								
								$CntWb .= $l->js; 

                                $CntWb .= "
									
									function ShwTrgOpt(){	
										__var_id = $('#atmttrgr_trgr').val();
										__sl = $('#atmttrgr_trgr option:selected');
										__sl_r = __sl.attr('rel');	
										SUMR_Main.ld.f.slc({i:'atmttrgr_v_ls', t:'atmt_trgr_ls', t_i:__sl_r });
									}
									
									function ShwTrgSlc(p){
											
										$('#atmt_trgr_ls_bx').html('');
										$('#atmt_trgr_vl_bx').html('');
										
										SUMR_Main.ld.f.slc({
											i:p.i, 
											t:'atmt_trgr_ls', 
											b:'atmt_trgr_ls_bx',
											d:p
										});
										
									}
					
									$('#atmttrgr_trgr').change(function() {

										var __id = $(this).val();
										var __est_i = $(this).val();
										
										ShwTrgSlc({ 
											trgr:__id
										});
											
                            		});
                            		
                            		
                            		ShwTrgSlc({ 
                            			trgr:'".$___Ls->dt->rw['atmttrgr_trgr']."', 
                            			v_ls:'".$___Ls->dt->rw['atmttrgr_v_ls']."', 
                            			v_vl:'".$___Ls->dt->rw['atmttrgr_v_vl']."' 
                            		});
                            			
                            	";
                                		 
								
							?>
										
                            <div id="atmt_trgr_ls_bx" class="_sbls"> </div> 
							<div id="atmt_trgr_vl_bx" class="_sbls"></div>
		                    
		                    
		                    <?php echo HTML_inp_tx('atmttrgr_nm', TX_NM, ctjTx($___Ls->dt->rw['atmttrgr_nm'],'in'), FMRQD); ?>
		                    <?php echo HTML_inp_tx('atmttrgr_ord', TX_ORD, $___Ls->dt->rw['atmttrgr_ord'], FMRQD_NMR); ?>	
							
							<div class="_cc">
								<div class="_c1"><?php echo OLD_HTML_chck('atmttrgr_lnl', TX_TLNL, $___Ls->dt->rw['atmttrgr_lnl']); ?></div>
								<div class="_c2"><?php echo OLD_HTML_chck('atmttrgr_rpt', TX_CCLC, $___Ls->dt->rw['atmttrgr_rpt']); ?></div>
								<div class="_c3"><?php echo OLD_HTML_chck('atmttrgr_hbl', 'Habilitado', $___Ls->dt->rw['atmttrgr_hbl']); ?></div>
							</div>
						</div>
					</div>			
				</div>	
            </div>
            <div class="TabbedPanelsContent">
            	<?php 
					if($___Ls->dt->rw['atmttrgr_dly'] == 1){ 
						$__dly_v = 'style="display:none;"'; }else{ $__dly_v = ''; 	
					} 
				?>
				
				
				<?php $l = __Ls(['k'=>'sis_atmt_dly', 'id'=>'atmttrgr_dly', 'va'=>$___Ls->dt->rw['atmttrgr_dly'] , 'ph'=>FM_LS_SLGN]); $CntWb .= $l->js; ?>
				
				
				<?php echo h2('<div class="_c3">
									<div class="_d1">Tiempo de Espera</div>
									<div class="_d2">'.
											HTML_inp_tx('atmttrgr_dly_v', '', $___Ls->dt->rw['atmttrgr_dly_v']!=''?ctjTx($___Ls->dt->rw['atmttrgr_dly_v'],'in'):0, FMRQD_NMR, $__dly_v).
									'</div>
									<div class="_d3">'.$l->html.'</div>
								</div>', '_h2tt');
					
					
					$CntWb .= "$('#atmttrgr_dly').change(function(){ 	
							
									if( $(this).val() != 1){
										$('#atmttrgr_dly_v').show();	
									}else{
										$('#atmttrgr_dly_v').hide();
									}
							   });
					";

					foreach($___days_week as $_k => $_v){
						echo OLD_HTML_chck('atmttrgr_sch_d_'.$_v->id, $_v->tt, $___Ls->dt->rw['atmttrgr_sch_d_'.$_v->id] != '' ? $___Ls->dt->rw['atmttrgr_sch_d_'.$_v->id] : 1, 'in');
					}
					
				?>
				
				<?php $l = __Ls(['k'=>'sis_atmt_sch', 'id'=>'atmttrgr_sch', 'va'=>$___Ls->dt->rw['atmttrgr_sch'] , 'ph'=>FM_LS_SLGN]); $CntWb .= $l->js; ?>
				
				<?php echo h2('<div class="_d x2">
									<div class="_d1">Hora de Envio</div>
									<div class="_d2">'.$l->html.'</div>
								</div>', '_h2tt');
					
					$CntWb .= JQ_Ls('atmttrgr_sch', FM_LS_TRGR);
					
					$CntWb .= "$('#atmttrgr_sch').change(function(){ 	
									var _v = $(this).val();
									
									if( _v != "._CId('ID_SISATMTSCH_PRNT')."){
										$('#___sch_opt').show();
										$('#___sch_opt .c2').hide();
										
										if(_v == "._CId('ID_SISATMTSCH_HRA')."){ 
											$('#___sch_opt').removeClass('_cx2');
										}else{ 
											$('#___sch_opt').addClass('_cx2');
											$('#___sch_opt .c2').fadeIn();
										}
											
									}else{
										$('#___sch_opt').hide();
									}
							   });
					";
					
					
					$__sch_hr_1 = _Dte_([ 'd'=>$___Ls->dt->rw['atmttrgr_sch_h1'] ]);
					$__sch_hr_2 = _Dte_([ 'd'=>$___Ls->dt->rw['atmttrgr_sch_h2'] ]);
				?>	
				
				
				<?php if($___Ls->dt->tot == 0 || $___Ls->dt->rw['atmttrgr_sch'] == _CId('ID_SISATMTSCH_PRNT')){ $__shc_h_v = 'style="display:none;"'; }else{ $__shc_h_v = ''; } ?>
				<div <?php if($___Ls->dt->rw['atmttrgr_sch'] == _CId('ID_SISATMTSCH_RNG')){ ?> class="_cx2" <?php } ?> <?php echo $__shc_h_v; ?> id="___sch_opt">
					<div class="c1 _d1">
                    	<?php echo SlDt([ 'id'=>'atmttrgr_sch_h1', 'va'=>$__sch_hr_1->h, 'rq'=>'no', 't'=>'hr', 'ph'=>TX_HR, 'lmt'=>'no', 'cls'=>CLS_HOUR ]); ?> 
					</div>
					<div class="c2 _d2" <?php if($___Ls->dt->rw['atmttrgr_sch'] == _CId('ID_SISATMTSCH_HRA')){ echo 'style="display:none;"'; } ?> >
                    	<?php echo SlDt([ 'id'=>'atmttrgr_sch_h2', 'va'=>$__sch_hr_2->h, 'rq'=>'no', 't'=>'hr', 'ph'=>TX_HR, 'lmt'=>'no', 'cls'=>CLS_HOUR ]); ?>
					</div>
				</div>	
				
            </div>
            <div class="TabbedPanelsContent">
            	
        		<?php echo h3('Fuentes', '_sbtt'); ?>
                <?php echo OLD_HTML_chck('atmttrgr_invk_api', 'API', $___Ls->dt->rw['atmttrgr_invk_api']); ?>
                <?php echo OLD_HTML_chck('atmttrgr_invk_up', 'Carga', $___Ls->dt->rw['atmttrgr_invk_up']); ?>
                <?php echo OLD_HTML_chck('atmttrgr_invk_crm', 'Manual', $___Ls->dt->rw['atmttrgr_invk_crm']); ?>
                <?php echo OLD_HTML_chck('atmttrgr_invk_auto', 'CronJob', $___Ls->dt->rw['atmttrgr_invk_auto']); ?>
                <?php echo OLD_HTML_chck('atmttrgr_invk_form', 'Formulario', $___Ls->dt->rw['atmttrgr_invk_form']); ?>
		                    	 
            </div>
            <div class="TabbedPanelsContent">
            	<?php echo $___Ls->tab->sgm->d ?> 
            </div>
            <div class="TabbedPanelsContent">
                <?php echo $___Ls->tab->act->d ?> 
            </div>
            <div class="TabbedPanelsContent">
                <?php echo $___Ls->tab->cndc->d ?>      
            </div>                                                
        </div>              
    </div>
        
    </form>

</div>

<style>
	
	.__atmt_trgr .__new{  }
	.__atmt_trgr .__new .TabbedPanelsTabGroup{ display: none !important; }
	
	
	.__atmt_trgr .ln_1{ margin-top: 0; }
	.__atmt_trgr .ln_1:not(.__form){ display: flex !important; padding: 0 20px; }
	.__atmt_trgr .ln_1:not(.__form) .col_1{ width: 60% !important; }
	.__atmt_trgr .ln_1:not(.__form) .col_2{ width: 38% !important; }
	
	.__atmt_trgr .ln_1.__dtl._non{ display: none; max-height: 1px; position: absolute; top: -1000px; opacity: 0; pointer-events: none; }
	
	.__atmt_trgr .VTabbedPanels{ display: flex; }	
	.__atmt_trgr .VTabbedPanels.mny > ul.TabbedPanelsTabGroup{ background-color: white; width:45px !important; list-style: none; padding-top: 10px; }
    .__atmt_trgr .VTabbedPanels.mny > div.TabbedPanelsContentGroup{ border-left: 1px dotted #bcbfbf; }
    .__atmt_trgr .VTabbedPanels.mny > div.TabbedPanelsContentGroup .TabbedPanelsContent{ padding-left:20px !important; padding-top:30px; }
    
    
    .__atmt_trgr .__new.VTabbedPanels.mny > div.TabbedPanelsContentGroup{ border: none !important; }
    .__atmt_trgr .__new.VTabbedPanels.mny > div.TabbedPanelsContentGroup .TabbedPanelsContent{ padding-top: 30px; }
    
    .__atmt_trgr .VTabbedPanels .Tt_Tb .btn{ margin-right: 0 !important; }
    .__atmt_trgr .VTabbedPanels .TabbedPanelsTab{ background-size: 60% auto; background-position: center center; min-height: 35px; min-width: 35px; max-width: 35px; background-repeat: no-repeat; opacity: 0.3; cursor: pointer; } 
    .__atmt_trgr .VTabbedPanels .TabbedPanelsTabSelected,
    .__atmt_trgr .VTabbedPanels .TabbedPanelsTabHover{ opacity: 1; background-color: white !important; }
    
    .__atmt_trgr .VTabbedPanels .TabbedPanelsTab._bsc{ background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>atmt_etp.svg); }
    .__atmt_trgr .VTabbedPanels .TabbedPanelsTab._sgm{ background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>atmt_sgm.svg); }
    .__atmt_trgr .VTabbedPanels .TabbedPanelsTab._hra{ background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>atmt_hra.svg); }
    .__atmt_trgr .VTabbedPanels .TabbedPanelsTab._fnt{ background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>atmt_fnt.svg); }
    .__atmt_trgr .VTabbedPanels .TabbedPanelsTab._act{ background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>atmt_act.svg); }
    .__atmt_trgr .VTabbedPanels .TabbedPanelsTab._cndc{ background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>atmt_cndc.svg); }
    
    .__atmt_trgr ul.__days{ white-space: nowrap; width: 100%; text-align: center; display: flex; margin: 20px 0; }
	.__atmt_trgr ul.__days li{ border-radius:200px; -moz-border-radius:200px; -webkit-border-radius:200px; width: 30px; height: 30px; background-color: #a2a6a6; display: inline-block; margin: 0 5px; text-align: center !important; line-height: 29px; color: #ffffff; font-weight: bolder; }
    .__atmt_trgr ul.__days li.si{ background-color: var(--second-bg-color); }
    .__atmt_trgr ul.__days li.no{ opacity: 0.5; }
    
    
    
    .__atmt_trgr .ln_1 .ls_1:not(.__days) > li{ padding: 5px 0; }
    .__atmt_trgr .ln_2col{ margin-top: 20px; }
    
    
    
    
    
    .__atmt_trgr ._cc{ width: 100%; display: flex; margin-top: 50px; }
    .__atmt_trgr ._cc ._c1,
    .__atmt_trgr ._cc ._c2,
    .__atmt_trgr ._cc ._c3{ width: 33.3%; vertical-align: top; text-align: center; }
	.__atmt_trgr ._cc .__slc_ok{ display: flex; border: none; }
	.__atmt_trgr ._cc .__slc_ok h2{ text-align: right !important; margin-right: 5px !important; }
	.__atmt_trgr ._cc .__slc_ok .__slc{ text-align: left !important; } 
	
	
	.__atmt_trgr h2._h2tt{ font-family: Economica; font-size: 20px; }
	.__atmt_trgr h2._h2tt ._d.x2{ display: flex; }
	.__atmt_trgr h2._h2tt ._d.x2 ._d1,
	.__atmt_trgr h2._h2tt ._d.x2 ._d2{ width:50%; }
	
	
	.__atmt_trgr h3._sbtt{ color: #989898; display: block; font: 20px Economica; margin: 0 0 10px; overflow: hidden; padding: 20px 0 0; position: relative; text-align: right; width: 100%; margin-bottom: 40px; }
	
</style>
		        

</div>
<?php } ?>
<?php } ?>