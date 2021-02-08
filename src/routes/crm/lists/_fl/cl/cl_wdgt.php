<?php 
if(class_exists('CRM_Cnx')){
	 	
	$___Ls->sch->f = 'clwdgt_nm, clwdgt_clr_strt, clwdgt_clr_hdr';
	$___Ls->new->w = 1000;
	$___Ls->new->h = 600;
	$___Ls->img->dir = DMN_FLE_CL_WDGT;
	$___Ls->img->svg = 'ok';
	$___Ls->_strt();	

	if(!isN($___Ls->gt->isb)){ $__fl .= $___Ls->_andsql([ 'f'=>'_cl.cl_enc', 'v'=>$___Ls->gt->isb ]); }
	
	if(!isN($___Ls->gt->i)){	
		
		$___Ls->qrys = sprintf("SELECT * FROM "._BdStr(DBM).TB_CL_WDGT." WHERE ".$___Ls->ik." = %s LIMIT 1", GtSQLVlStr($___Ls->gt->i, "text"));
		
	}elseif($___Ls->_show_ls == 'ok'){ 

		$Ls_Whr = "	FROM "._BdStr(DBM).TB_CL_WDGT." 
						 INNER JOIN "._BdStr(DBM).TB_CL." AS _cl ON clwdgt_cl = _cl.id_cl
					WHERE _cl.cl_enc != '' AND ".$___Ls->ino." != '' $__fl ".$___Ls->sch->cod." 
					ORDER BY ".$___Ls->ino." DESC";

		$___Ls->qrys = "SELECT *, (SELECT COUNT(*) $Ls_Whr) AS ".QRY_RGTOT." $Ls_Whr"; 
	
	}
	
	$___Ls->_bld(); 
	$___days_week = _WkDays();

?>
<?php if($___Ls->ls->chk=='ok'){ ?>
<?php $___Ls->_bld_l_hdr(); ?>
	<?php if(($___Ls->qry->tot > 0)){ ?>
		<table width="100%" border="0" cellpadding="0" cellspacing="0" class="Ls_Rg"> 
			<tr>
				<th width="1%" <?php echo NWRP ?>><?php echo TX_FM_No ?></th>
				<th width="30%" <?php echo NWRP ?>><?php echo TX_NM ?></th>
				<th width="30%" <?php echo NWRP ?>><?php echo TX_BTSTR ?></th>
				<th width="30%" <?php echo NWRP ?>><?php echo TX_HDR?></th>
				<th width="1%" <?php echo NWRP ?>></th>
			</tr>
			<?php do { ?> 
				<tr>
					<td width="1%" <?php echo NWRP ?>><?php echo Spn($___Ls->ls->rw[$___Ls->ino]); ?></td>
					<td width="30%" align="left" nowrap="nowrap"><?php echo ShortTx(ctjTx($___Ls->ls->rw['clwdgt_nm'],'in'),40,'Pt', true); ?></td>
					<td width="48%" align="left" <?php echo $_clr_rw ?>><?php echo Spn('','', '_clr_icn','background-color:'.$___Ls->ls->rw['clwdgt_clr_strt'].'; ') . ctjTx($___Ls->ls->rw['clwdgt_clr_strt'],'in');?>
					</td>
					<td width="48%" align="left" <?php echo $_clr_rw ?>><?php echo Spn('','', '_clr_icn','background-color:'.$___Ls->ls->rw['clwdgt_clr_hdr'].'; ') . ctjTx($___Ls->ls->rw['clwdgt_clr_hdr'],'in');?>
					</td>
					<td width="1%" align="left" class="_btn"><?php echo $___Ls->_btn([ 't'=>'mod' ]); ?></td>
				</tr>
			<?php } while ($___Ls->ls->rw = $___Ls->sql->fetch_assoc()); ?>
		</table>
		<?php $___Ls->_bld_l_pgs(); ?>
	<?php } ?>
	<?php $___Ls->_h_ls_nr(); ?>
<?php } ?>
<?php if($___Ls->fm->chk=='ok'){ ?>
  	
	<div class="FmTb">
	  <div id="<?php  echo DV_GNR_FM ?>"> 
                                       
	    <form method="POST" name="<?php echo $___Ls->fm->id; ?>" target="_self" id="<?php echo $___Ls->fm->id; ?>" >
	      <?php $___Ls->_bld_f_hdr(); ?>      
		  <div id="<?php echo $___Ls->fm->fld->id ?>" class="<?php echo DV_GNR_FM_CMP ?> widget_detail">			
	        <div class="ln_1" style="margin-bottom: 50px;">
			  	<div class="col_1">
				  	<?php echo HTML_inp_hd('clwdgt_cl', $__i); ?>
					<?php echo HTML_inp_tx('clwdgt_nm', TX_NM, ctjTx($___Ls->dt->rw['clwdgt_nm'],'in')); ?>
					<?php echo HTML_inp_tx('clwdgt_tx_btn_tt', TX_TTBTN, ctjTx($___Ls->dt->rw['clwdgt_tx_btn_tt'],'in')); ?>
					<?php echo HTML_inp_tx('clwdgt_tx_pop_tt', TX_TTLO, ctjTx($___Ls->dt->rw['clwdgt_tx_pop_tt'],'in')); ?>		
					<?php echo HTML_inp_tx('clwdgt_tx_pop_intro', TX_INTR, ctjTx($___Ls->dt->rw['clwdgt_tx_pop_intro'],'in')); ?>
					<?php //echo HTML_inp_tx('clwdgt_tx_call_ph', TX_PLCH, ctjTx($___Ls->dt->rw['clwdgt_tx_call_ph'],'in')); ?>
					<?php echo HTML_inp_tx('clwdgt_test_url', TX_URL.' ('.TX_PRB.')', ctjTx($___Ls->dt->rw['clwdgt_test_url'],'in')); ?>
					<?php echo OLD_HTML_chck('clwdgt_test_inline', TX_URL.' (Live)', $___Ls->dt->rw['clwdgt_test_inline'], 'in'); ?>

					<?php if($___Ls->dt->tot > 0){ ?>
						<div class="_code">
							<?php echo HTML_textarea('clwdgt_prvw', '', __WdgtCod([ 'id'=>$___Ls->dt->rw['clwdgt_enc'] ]) ,'','','','20','','',' readonly="readonly" ');  ?>
						</div>
						<div class="opt">
							<button id="clwdgt_publish" class="clwdgt_button publish">Publicar</button>
							<button id="clwdgt_test" class="clwdgt_button test">Test</button>
						</div>


						<ul class="upl_img_opt">
							<li><button class="_anm upl_img upl_bck" id="<?php echo 'upl_bck_'.$___Ls->fm->id; ?>"> <span class="_anm">Background Demo</span></button></li>
						</ul>
							
						<?php 	
							$_f = HTML_ClrBxImg('cl_wdgt_test').$___Ls->uidn;
							$CntWb .= $___Ls->_h_fm_img([ 'b'=>'upl_bck_'.$___Ls->fm->id, 'u'=>$_f ]);	
						?>

					<?php } ?>
					
				</div>
				<div class="col_2">	
					<?php echo h2('Diseño'); ?>
					<?php 	
						
						$__tab = [
									['n'=>'sndd', 't'=>'snd_ec_snd', 'l'=>TX_SNTCMP],
									['n'=>'lst',  't'=>'snd_ec_lsts_rel', 'l'=>'Listas']
								];
						
						$___Ls->_dvlsfl_all($__tab,[ 'idb'=>'ok' ]);
							
					?>	
					<div id="<?php echo $___Ls->tab->id ?>" class="TabbedPanels pltf_opt">
			            <ul class="TabbedPanelsTabGroup">
				            <li class="TabbedPanelsTab dsktp"></li>
				            <li class="TabbedPanelsTab mbl"></li>
			            </ul>
				        <div class="TabbedPanelsContentGroup _anm">
					        <div class="TabbedPanelsContent _anm">
								
								<?php 
									if($___Ls->dt->tot > 0){
										echo $___Ls->_bld_cllps([
											'tt'=>'Color',
											'cls'=>'clr',
											'c'=>HTML_inp_clr([ 'id'=>'clwdgt_clr_strt', 'plc'=>'Boton Inicio', 'vl'=>$___Ls->dt->rw['clwdgt_clr_strt'] ]).
												 HTML_inp_clr([ 'id'=>'clwdgt_clr_hdr', 'plc'=>TX_HDR, 'vl'=>$___Ls->dt->rw['clwdgt_clr_hdr'] ])
										]);
									}

									$l = __Ls(['k'=>'wdgt_thm', 'id'=>'clwdgt_thm', 'va'=>$___Ls->dt->rw['clwdgt_thm'] , 'ph'=>FM_LS_SLGN]); 
									$CntWb .= $l->js;

									echo $___Ls->_bld_cllps([
										'tt'=>'Apariencia',
										'cls'=>'appr',
										'c'=>OLD_HTML_chck('clwdgt_pwd', TX_PWRDBY, $___Ls->dt->rw['clwdgt_pwd'], 'in').
											 OLD_HTML_chck('clwdgt_puff', 'Puff Effect', $___Ls->dt->rw['clwdgt_puff'], 'in').
											 OLD_HTML_chck('clwdgt_shwtt', 'Mostrar Titulo', $___Ls->dt->rw['clwdgt_shwtt'], 'in').HTML_BR.$l->html
									]);
									
									$_pst_top = '<div class="pst_vl '.(mBln($___Ls->dt->rw['clwdgt_pst_top'])!='ok'?'_off':'_on').'" id="bx_clwdgt_pst_top_v">
													'.HTML_inp_tx('clwdgt_pst_top_v', TX_VLR, ctjTx($___Ls->dt->rw['clwdgt_pst_top_v'],'in')).'
												</div>';
									
									$_pst_right = '<div class="pst_vl '.(mBln($___Ls->dt->rw['clwdgt_pst_right'])!='ok'?'_off':'_on').'" id="bx_clwdgt_pst_right_v">
														'.HTML_inp_tx('clwdgt_pst_right_v', TX_VLR, ctjTx($___Ls->dt->rw['clwdgt_pst_right_v'],'in')).'
													</div>';
									
									$_pst_bottom = '<div class="pst_vl '.(mBln($___Ls->dt->rw['clwdgt_pst_bottom'])!='ok'?'_off':'_on').'" id="bx_clwdgt_pst_bottom_v">
														'.HTML_inp_tx('clwdgt_pst_bottom_v', TX_VLR, ctjTx($___Ls->dt->rw['clwdgt_pst_bottom_v'],'in')).'
													</div>';

									$_pst_left = '	<div class="pst_vl '.(mBln($___Ls->dt->rw['clwdgt_pst_left'])!='ok'?'_off':'_on').'" id="bx_clwdgt_pst_left_v">
														'.HTML_inp_tx('clwdgt_pst_left_v', TX_VLR, ctjTx($___Ls->dt->rw['clwdgt_pst_left_v'],'in')).'
													</div>';

									echo $___Ls->_bld_cllps([
										'tt'=>'Posición',
										'cls'=>'pst',
										'c'=>OLD_HTML_chck('clwdgt_pst_top', 'Top '.$_pst_top, $___Ls->dt->rw['clwdgt_pst_top'], 'in', [ 'attr'=>[ 'bx-id'=>'bx_clwdgt_pst_top_v' ] ]).
											 OLD_HTML_chck('clwdgt_pst_right', 'Right '.$_pst_right, $___Ls->dt->rw['clwdgt_pst_right'], 'in', [ 'attr'=>[ 'bx-id'=>'bx_clwdgt_pst_right_v' ] ]).
											 OLD_HTML_chck('clwdgt_pst_bottom', 'Bottom '.$_pst_bottom, $___Ls->dt->rw['clwdgt_pst_bottom'], 'in', [ 'attr'=>[ 'bx-id'=>'bx_clwdgt_pst_bottom_v' ] ]).
											 OLD_HTML_chck('clwdgt_pst_left', 'Left '.$_pst_left, $___Ls->dt->rw['clwdgt_pst_left'], 'in', [ 'attr'=>[ 'bx-id'=>'bx_clwdgt_pst_left_v' ] ])		 
									]);

									foreach($___days_week as $_k => $_v){
										$_hour_s = SlDt([ 't'=>'hr', 'id'=>'clwdgt_sch_d_'.$_v->id.'_s', 'va'=>$___Ls->dt->rw['clwdgt_sch_d_'.$_v->id.'_s'], 'rq'=>'no', 'lmt'=>'no', 'yr'=>'ok' ]);
										$_hour_e = SlDt([ 't'=>'hr', 'id'=>'clwdgt_sch_d_'.$_v->id.'_e', 'va'=>$___Ls->dt->rw['clwdgt_sch_d_'.$_v->id.'_e'], 'rq'=>'no', 'lmt'=>'no', 'yr'=>'ok' ]);
										$_schl .= OLD_HTML_chck('clwdgt_sch_d_'.$_v->id, $_v->tt.' '.$_hour_s.' '.$_hour_e, $___Ls->dt->rw['clwdgt_sch_d_'.$_v->id] != '' ? $___Ls->dt->rw['clwdgt_sch_d_'.$_v->id] : 1, 'in');
									}

									echo $___Ls->_bld_cllps([
										'tt'=>'Programación',
										'cls'=>'sch',
										'c'=>$_schl
									]);

								?>							
							</div>
							<div class="TabbedPanelsContent _anm">
								
								<?php 
								
									if($___Ls->dt->tot > 0){
										echo $___Ls->_bld_cllps([
											'tt'=>'Color',
											'cls'=>'clr',
											'c'=>HTML_inp_clr([ 'id'=>'clwdgt_clr_mbl_strt', 'plc'=>'Boton Inicio', 'vl'=>$___Ls->dt->rw['clwdgt_clr_mbl_strt'] ]).
												 HTML_inp_clr([ 'id'=>'clwdgt_clr_mbl_hdr', 'plc'=>TX_HDR, 'vl'=>$___Ls->dt->rw['clwdgt_clr_mbl_hdr'] ])
										]);
									}
									
									echo $___Ls->_bld_cllps([
										'tt'=>'Apariencia',
										'cls'=>'appr',
										'c'=>OLD_HTML_chck('clwdgt_mbl_pwd', TX_PWRDBY, $___Ls->dt->rw['clwdgt_mbl_pwd'], 'in').
											 OLD_HTML_chck('clwdgt_mbl_puff', 'Puff Effect', $___Ls->dt->rw['clwdgt_mbl_puff'], 'in').
											 OLD_HTML_chck('clwdgt_mbl_shwtt', 'Mostrar Titulo', $___Ls->dt->rw['clwdgt_mbl_shwtt'], 'in')

									]);


									$_pst_mbl_top = '	<div class="pst_vl '.(mBln($___Ls->dt->rw['clwdgt_pst_mbl_top'])!='ok'?'_off':'_on').'" id="bx_clwdgt_pst_mbl_top_v">
															'.HTML_inp_tx('clwdgt_pst_mbl_top_v', TX_VLR, ctjTx($___Ls->dt->rw['clwdgt_pst_mbl_top_v'],'in')).'
														</div>';
									
									$_pst_mbl_right = '	<div class="pst_vl '.(mBln($___Ls->dt->rw['clwdgt_pst_mbl_right'])!='ok'?'_off':'_on').'" id="bx_clwdgt_pst_mbl_right_v">
															'.HTML_inp_tx('clwdgt_pst_mbl_right_v', TX_VLR, ctjTx($___Ls->dt->rw['clwdgt_pst_mbl_right_v'],'in')).'
														</div>';
									
									$_pst_mbl_bottom = '<div class="pst_vl '.(mBln($___Ls->dt->rw['clwdgt_pst_mbl_bottom'])!='ok'?'_off':'_on').'" id="bx_clwdgt_pst_mbl_bottom_v">
															'.HTML_inp_tx('clwdgt_pst_mbl_bottom_v', TX_VLR, ctjTx($___Ls->dt->rw['clwdgt_pst_mbl_bottom_v'],'in')).'
														</div>';

									$_pst_mbl_left = '	<div class="pst_vl '.(mBln($___Ls->dt->rw['clwdgt_pst_mbl_left'])!='ok'?'_off':'_on').'" id="bx_clwdgt_pst_mbl_left_v">
															'.HTML_inp_tx('clwdgt_pst_mbl_left_v', TX_VLR, ctjTx($___Ls->dt->rw['clwdgt_pst_mbl_left_v'],'in')).'
														</div>';

									echo $___Ls->_bld_cllps([
										'tt'=>'Posición',
										'cls'=>'pst',
										'c'=>OLD_HTML_chck('clwdgt_pst_mbl_top', 'Top '.$_pst_mbl_top, $___Ls->dt->rw['clwdgt_pst_mbl_top'], 'in', [ 'attr'=>[ 'bx-id'=>'bx_clwdgt_pst_mbl_top_v' ] ]).
											 OLD_HTML_chck('clwdgt_pst_mbl_right', 'Right '.$_pst_mbl_right, $___Ls->dt->rw['clwdgt_pst_mbl_right'], 'in', [ 'attr'=>[ 'bx-id'=>'bx_clwdgt_pst_mbl_right_v' ] ]).
											 OLD_HTML_chck('clwdgt_pst_mbl_bottom', 'Bottom '.$_pst_mbl_bottom, $___Ls->dt->rw['clwdgt_pst_mbl_bottom'], 'in', [ 'attr'=>[ 'bx-id'=>'bx_clwdgt_pst_mbl_bottom_v' ] ]).
											 OLD_HTML_chck('clwdgt_pst_mbl_left', 'Left '.$_pst_mbl_left, $___Ls->dt->rw['clwdgt_pst_mbl_left'], 'in', [ 'attr'=>[ 'bx-id'=>'bx_clwdgt_pst_mbl_left_v' ] ])
									]);

									foreach($___days_week as $_k => $_v){
										$_hour_s = SlDt([ 't'=>'hr', 'id'=>'clwdgt_sch_mbl_d_'.$_v->id.'_s', 'va'=>$___Ls->dt->rw['clwdgt_sch_mbl_d_'.$_v->id.'_s'], 'rq'=>'no', 'lmt'=>'no', 'yr'=>'ok' ]);
										$_hour_e = SlDt([ 't'=>'hr', 'id'=>'clwdgt_sch_mbl_d_'.$_v->id.'_e', 'va'=>$___Ls->dt->rw['clwdgt_sch_mbl_d_'.$_v->id.'_e'], 'rq'=>'no', 'lmt'=>'no', 'yr'=>'ok' ]);
										$_schl_mbl .= OLD_HTML_chck('clwdgt_sch_mbl_d_'.$_v->id, $_v->tt.' '.$_hour_s.' '.$_hour_e, $___Ls->dt->rw['clwdgt_sch_mbl_d_'.$_v->id] != '' ? $___Ls->dt->rw['clwdgt_sch_mbl_d_'.$_v->id] : 1, 'in');
									}

									echo $___Ls->_bld_cllps([
										'tt'=>'Programación',
										'cls'=>'sch',
										'c'=>$_schl_mbl
									]);

								?>								

							</div>
			            </div>
	            	</div>
					
					
					<?php 
						
						
						$CntWb .= "								
									
								$('#clwdgt_pst_top, #clwdgt_pst_right, #clwdgt_pst_left, #clwdgt_pst_bottom, #clwdgt_pst_mbl_top, #clwdgt_pst_mbl_right, #clwdgt_pst_mbl_left, #clwdgt_pst_mbl_bottom').change(function(){
									
									var _bxid = $(this).attr('bx-id');
									
									if(this.checked) {
										$('#'+_bxid).removeClass('_off').addClass('_on');
									}else{
										$('#'+_bxid).removeClass('_on').addClass('_off');
									}
									
								});
								
						    ";

						
					?>
					
				</div>
			</div>
	      </div>
	    </form>
	    
	    <?php if($___Ls->dt->tot > 0){ ?>
		<div class="ln">
			<?php
                $__act_f = $___Ls->_dvls([ 'id'=>'act', 'i'=>$___Ls->gt->i, 't'=>'cl_wdgt_act', 't2'=>$___Ls->gt->tsb ]);
		        echo $__act_f->html;
			?> 
        </div> 
		<?php }  ?>
			
			
	  </div>
	</div> 
	
	<style>
		
		.widget_detail .CollapsiblePanelTab{ border-bottom-width:1px; padding-left:35px; position:relative; font-weight: 100; text-align:center; opacity:0.4; color:#ccc; }
		.widget_detail .CollapsiblePanelTab::before{ width:30px; height:30px; display:inline-block; margin-right:10px; background-repeat:no-repeat; background-position:center center; background-size:auto 70%; margin-bottom: -10px; }
		.widget_detail .CollapsiblePanelTab:hover{ color:var(--second-bg-color); }
		.widget_detail .CollapsiblePanelTab:hover::before{ background-size:auto 60%; }
		.widget_detail .CollapsiblePanel.clr .CollapsiblePanelTab::before{ background-image: url('<?php echo DMN_IMG_ESTR_SVG ?>wdgt_stup_clr.svg'); }
		.widget_detail .CollapsiblePanel.appr .CollapsiblePanelTab::before{ background-image: url('<?php echo DMN_IMG_ESTR_SVG ?>wdgt_stup_thm.svg'); }
		.widget_detail .CollapsiblePanel.pst .CollapsiblePanelTab::before{ background-image: url('<?php echo DMN_IMG_ESTR_SVG ?>wdgt_stup_pst.svg'); }
		.widget_detail .CollapsiblePanel.sch .CollapsiblePanelTab::before{ background-image: url('<?php echo DMN_IMG_ESTR_SVG ?>wdgt_stup_sch.svg'); }
		.widget_detail .CollapsiblePanelOpen .CollapsiblePanelTab{ opacity:1; color:var(--second-bg-color); }

		.widget_detail .CollapsiblePanelContent{ padding:20px 20px 20px 20px; border-bottom:none; }
		.widget_detail .CollapsiblePanelContent .__slc_ok{ padding-top:10px; }

		.widget_detail ._code{ margin-top: 20px; margin-bottom: 30px; }
		.widget_detail ._code textarea{ width: 100% !important; padding: 20px 20px 15px 20px !important; height: 200px; font-size: 11.5px; font-family: Roboto; margin: 0; color: #939697; opacity: 0.4; }		
		.widget_detail ._code textarea:hover,
		.widget_detail ._code textarea:focus{ color: #666868; opacity: 1; }
		
		.widget_detail .__slc_ok{ display:flex; }
		.widget_detail .__slc_ok h3{ border: none !important; display:flex; }
		
		.widget_detail .__slc_ok input[type=text]::-webkit-input-placeholder { text-align: center !important; font-size:9px; }
		.widget_detail .__slc_ok input[type=text]::-moz-placeholder { text-align: center !important; font-size:9px; }
		.widget_detail .__slc_ok input[type=text]:-ms-input-placeholder { text-align: center !important; font-size:9px; }
		.widget_detail .__slc_ok input[type=text]:-moz-placeholder { text-align: center !important; font-size:9px; }


		.widget_detail .__slc_ok input[type=text],
		.widget_detail .__slc_ok input[type=text],
		.widget_detail .__slc_ok input[type=text],
		.widget_detail .__slc_ok input[type=text]{ text-align: center !important; font-size:11px; padding:8px 5px; }


		.widget_detail .pst_vl{ margin-top: -5px;; margin-left: 10px; }
		.widget_detail .pst_vl._off{ display: none; }
		
		.widget_detail .pltf_opt .TabbedPanelsTabGroup .TabbedPanelsTab{ border: 1px solid red; width: 40px; height: 40px; background-color: white; border: none; background-repeat: no-repeat; background-position: center center; background-size: auto 40%; border-radius: 200px !important; -moz-border-radius: 200px !important; -webkit-border-radius: 200px !important; padding: 0 !important; }
		.widget_detail .pltf_opt .TabbedPanelsTabGroup .TabbedPanelsTab.dsktp{ background-image: url('<?php echo DMN_IMG_ESTR_SVG ?>dvc_desktop.svg'); }
		.widget_detail .pltf_opt .TabbedPanelsTabGroup .TabbedPanelsTab.mbl{ background-image: url('<?php echo DMN_IMG_ESTR_SVG ?>dvc_mobile.svg'); }
		
		.widget_detail .pltf_opt .TabbedPanelsTabGroup .TabbedPanelsTab.TabbedPanelsTabHover,
		.widget_detail .pltf_opt .TabbedPanelsTabGroup .TabbedPanelsTab.TabbedPanelsTabSelected{ background-color: #e6e8e9 !important; border: none !important;  }
		.widget_detail .pltf_opt .TabbedPanelsContentGroup{ padding-top: 20px; }
		
		.widget_detail .opt{ display:flex; }
		.widget_detail .opt .clwdgt_button{ display: block; border-radius:10px; -moz-border-radius:10px; -webkit-border-radius:10px; border: 1px solid #ccc; background-color:#fff; padding: 10px 15px; margin-left:auto; margin-right:auto; font-family:Economica; }
		.widget_detail .opt .clwdgt_button::before{ width:20px; height:20px; display:inline-block; background-repeat:no-repeat; background-size: auto 80%; background-position:center center; margin-bottom:-4px; margin-right:5px; }
		.widget_detail .opt .clwdgt_button._ld{ opacity:0.5; pointer-events:none; }
		.widget_detail .opt .clwdgt_button._ld::before{ background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>loader_black.svg); }	
		.widget_detail .opt .clwdgt_button.rdy{ border-color:green; color:green; }

		.widget_detail .opt .clwdgt_button.publish::before{ background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>lnd_tab_up.svg); }
		.widget_detail .opt .clwdgt_button.test::before{ background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>go_link.svg); }
		
		
		.widget_detail .CollapsiblePanel.sch .__slc_ok .__slc{ width:15% !important; }
		.widget_detail .CollapsiblePanel.sch .__slc_ok h3{ width: 85% !important; }
		.widget_detail .CollapsiblePanel.sch .__slc_ok .___txar{ margin-left:4px; margin-right:2px; margin-top: -5px; }
		
		
		.widget_detail .CollapsiblePanel.sch .__slc_ok input[type=text]._hour, 
		.widget_detail .CollapsiblePanel.sch .__slc_ok input[type=text].__hour{ background-image:url(none) !important; }

		.widget_detail .upl_img_opt{ text-align: center; margin: 50px 0 0 0; padding: 0; display: flex; }
		.widget_detail .upl_img_opt li{ display: inline-block; vertical-align: top; margin: 0 10px; } 
		.widget_detail .upl_img_opt .upl_img{ border-radius:200px; -moz-border-radius:200px; -webkit-border-radius:200px; width:70px; height:70px; border: 2px solid #b4b8b9; background-size: 120% auto; background-position: center center; position: relative; }
		.widget_detail .upl_img_opt .upl_img:hover{ border-color: #777b7c; background-size: 150% auto; }
		.widget_detail .upl_img_opt .upl_img:hover span{ background-color: #676a6c; }
		
		.widget_detail .upl_img_opt .upl_img.upl_bck{ background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>wdgt_img_test.svg); }
		.widget_detail .upl_img_opt .upl_img.upl_bck_app{ background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>wdgt_img_test.svg); }
		.widget_detail .upl_img_opt .upl_img span{ display:block; background-color: #bcc2c5; color: #ffffff; font-family: Roboto; font-weight: bolder; font-size: 10px; padding: 5px 10px; white-space: nowrap !important; border-radius:10px; -moz-border-radius:10px; -webkit-border-radius:10px; width: 100%; position: absolute; bottom: -5px; left: 0; text-overflow: ellipsis; }
		    
		    

	</style>
	
	
	<?php 
	
		$CntJV .= "	
		

			function Dom_Rbld(){
				
				$('#clwdgt_publish').off('click').click(function(e){

					e.preventDefault();
			
					if(e.target != this){ 
						e.stopPropagation(); return false;
					}else{

						var _this = $(this);

						_Rqu({ 
							f: 'prc',
							t: 'cl_wdgt',
							clwdgt_enc: '".$___Ls->dt->rw['clwdgt_enc']."',
							MM_rebuild: 'EdClWdgt',
							_bs:function(){ _this.addClass('_ld'); },
							_cm:function(){ _this.removeClass('_ld'); },
							_cl:function(d){
								if(!isN(d)){
									if(!isN(d.e) && d.e == 'ok'){ _this.addClass('rdy'); }
								}
							}
						});
					}
				});	


				$('#clwdgt_test').off('click').click(function(e){

					e.preventDefault();
			
					if(e.target != this){
						e.stopPropagation(); return false;
					}else{
						var win = window.open('".DMN_WDGT."test/?id=".$___Ls->dt->rw['clwdgt_enc']."', '_new');
  						win.focus();
					}
					
				});	

			}
			
			Dom_Rbld();

		";

	?>

<?php } ?>
<?php } ?>