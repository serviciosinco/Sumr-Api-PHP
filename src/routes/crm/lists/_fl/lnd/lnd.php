<?php 
if(class_exists('CRM_Cnx')){
	$___Ls->sch->f = 'lnd_tt';
	$___Ls->tp = 'lnd';
	
	$___Ls->new->w = 400;
	$___Ls->new->h = 300;
	$___Ls->edit->w = 800;
	$___Ls->edit->h = 600;
	
	$___Ls->_strt();
	
	
	if(!isN($___Ls->gt->i)){	
		
		$___Ls->qrys = sprintf("SELECT * FROM "._BdStr(DBM).TB_LND." WHERE ".$___Ls->ik." = %s LIMIT 1", GtSQLVlStr($___Ls->gt->i, "text"));
		
		
	}elseif($___Ls->_show_ls == 'ok'){ 
			
		$Ls_Whr = "	FROM "._BdStr(DBM).TB_LND." 
						 INNER JOIN ".TB_CL." ON lnd_cl = id_cl
					WHERE ".$___Ls->ino." != '' ".$___Ls->sch->cod." AND cl_enc = '".DB_CL_ENC."' 
					ORDER BY ".$___Ls->ino." DESC";
					
		$___Ls->qrys = "SELECT *, (SELECT COUNT(*) $Ls_Whr) AS ".QRY_RGTOT." $Ls_Whr";

	}
	
	
	$___Ls->_bld();
?>
<?php if($___Ls->ls->chk=='ok'){ ?>
<?php $___Ls->_bld_l_hdr(); ?>
<?php if(($___Ls->qry->tot > 0)){ ?>

	<table width="100%" border="0" cellpadding="0" cellspacing="0" class="Ls_Rg">
		<tr>
		    <th width="1%" <?php echo NWRP ?>><?php echo TX_FM_No ?></th>
		    <th width="90%" <?php echo NWRP ?>><?php echo TX_NM ?></th>
		    <th width="1%" <?php echo NWRP ?>><?php echo TX_URL ?></th>
		    <th width="1%" <?php echo NWRP ?>></th>
		</tr>
		<?php do { ?>
		<tr>   
		    <td width="1%" <?php echo NWRP ?>><?php echo Spn($___Ls->ls->rw[$___Ls->ino]); ?></td>
		    <td width="90%" align="left" nowrap="nowrap"><?php echo ShortTx(ctjTx($___Ls->ls->rw['lnd_tt'],'in'),40,'Pt', true); ?></td>
		    <td width="1%" align="left" class="_btn"><a target="_blank" href="<?php echo DMN_FLE_LND_HTML.$___Ls->ls->rw['lnd_dir']; ?>">Ir</a></td>
		    <td width="1%" align="left" class="_btn"><?php echo $___Ls->_btn([ 't'=>'mod' ]); ?></td>
	  	</tr>
	  	<?php } while ($___Ls->ls->rw = $___Ls->sql->fetch_assoc()); ?>
	</table>

<?php $___Ls->_bld_l_pgs(); ?>
<?php } ?>
<?php $___Ls->_h_ls_nr(); ?>
<?php } ?>
<?php if($___Ls->fm->chk=='ok'){ ?>
<div class="FmTb __lnd_detail">

  	<div id="<?php  echo DV_GNR_FM ?>">

	  	<?php 

		  	$__tabs = [ 
		  				['n'=>'cod_html', 't'=>'lnd_cod_html', 'l'=>'Código Html'], 
		  				['n'=>'cod_js', 't'=>'lnd_cod_js', 'l'=>'Código Js'], 
		  				['n'=>'cod_css', 't'=>'lnd_cod_css', 'l'=>'Código Css'], 
		  				['n'=>'up', 't'=>'lnd_up', 'l'=>'Carga Archivos'], 
		  				['n'=>'cdn', 't'=>'lnd_cdn', 'l'=>'Scripts / Plugins', 's'=>'ok'],
		  				['n'=>'tp', 't'=>'lnd_tp', 'l'=>'Tipo', 's'=>'ok'],
		  				['n'=>'font', 't'=>'lnd_font', 'l'=>'Font', 's'=>'ok']    
		  			];
		  	
		  	$___Ls->_dvlsfl_all($__tabs,[ 'idb'=>'ok' ]);

	  	?>
	  	
	  	<form method="POST" name="<?php echo $___Ls->fm->id; ?>" target="_self" id="<?php echo $___Ls->fm->id; ?>">
                      	
          	<?php $___Ls->_bld_f_hdr(); ?>  
          				
			<div id="<?php echo $___Ls->fm->fld->id ?>">
							
			  	<div id="<?php echo $___Ls->tab->id ?>" class="VTabbedPanels mny <?php if($___Ls->dt->tot == 0){ echo '_new'; } ?>">
				  	
		            <ul class="TabbedPanelsTabGroup">
			            <?php echo $___Ls->tab->bsc->l ?>
			            <?php echo $___Ls->tab->cod_html->l ?>
			            <?php echo $___Ls->tab->cod_js->l ?>
			            <?php echo $___Ls->tab->cod_css->l ?>
			            <?php echo $___Ls->tab->up->l ?>
			            <?php echo $___Ls->tab->cdn->l ?>
			            <?php echo $___Ls->tab->tp->l ?>
			            <?php echo $___Ls->tab->font->l ?>
		            </ul>
		            <div class="TabbedPanelsContentGroup">
		                <div class="TabbedPanelsContent _main">			
							<div class="ln_1 lft">
								<?php echo HTML_inp_tx('lnd_tt', TX_NM, ctjTx($___Ls->dt->rw['lnd_tt'],'in'), FMRQD); ?> 
								<?php echo OLD_HTML_chck('lnd_opt_cmprs', 'Opción - Comprimir' , $___Ls->dt->rw['lnd_opt_cmprs'], 'in'); ?>
								<?php echo OLD_HTML_chck('lnd_fm_opq', 'Form - Opaco' , $___Ls->dt->rw['lnd_fm_opq'], 'in'); ?>
								<?php echo OLD_HTML_chck('lnd_fm_icn', 'Form - Iconos' , $___Ls->dt->rw['lnd_fm_icn'], 'in'); ?>
							</div>
		                </div> 
		                
		                <?php 
			                  		
							$__id_edtr_1 = '__my_e_'.Gn_Rnd(10);
							$__id_edtr_2 = '__my_e_'.Gn_Rnd(10);
							$__id_edtr_3 = '__my_e_'.Gn_Rnd(10);
							$__id_edtr_4 = '__my_e_'.Gn_Rnd(10);
							$__id_edtr_5 = '__my_e_'.Gn_Rnd(10);
							$__id_edtr_6 = '__my_e_'.Gn_Rnd(10);
			                
		                ?>
		                <div class="TabbedPanelsContent">
			                <div class="ln_1 lft">
								<?php echo HTML_textarea('lnd_html', '<button class="_fll"></button>Código Html', ctjTx($___Ls->dt->rw['lnd_html'],'in','', ['html'=>'ok','schr'=>'ok','nl2'=>'no']), FMRQD, 'ok', '', 50); ?>
			                </div>
		                </div> 
		                
		                <div class="TabbedPanelsContent">
							<div class="ln_1 lft">
								
								
								<div id="FlC_1" class="CollapsiblePanel">
						            <div class="CollapsiblePanelTab" tabindex="0"> <?php echo h2('<button class="_fll"></button>Código Js'); ?> </div>
						            <div class="CollapsiblePanelContent">
							            <?php echo HTML_textarea('lnd_js', ' ', ctjTx($___Ls->dt->rw['lnd_js'],'in','', ['html'=>'ok','schr'=>'no','nl2'=>'no']), '', 'ok', '', 50); ?>
						            </div>
								</div>
								
								<div id="FlC_2" class="CollapsiblePanel">
						            <div class="CollapsiblePanelTab" tabindex="0"> <?php echo h2('<button class="_fll"></button>Código Js Ready'); ?> </div>
						            <div class="CollapsiblePanelContent">
							            <?php echo HTML_textarea('lnd_js_rdy', ' ', ctjTx($___Ls->dt->rw['lnd_js_rdy'],'in','', ['html'=>'ok','schr'=>'no','nl2'=>'no']), '', 'ok', '', 50); ?>
						            </div>
								</div>
								
								<div id="FlC_3" class="CollapsiblePanel">
						            <div class="CollapsiblePanelTab" tabindex="0"><?php echo h2('<button class="_fll"></button>Código Js Load'); ?> </div>
						            <div class="CollapsiblePanelContent">
							            <?php echo HTML_textarea('lnd_js_ld', ' ', ctjTx($___Ls->dt->rw['lnd_js_ld'],'in','', ['html'=>'ok','schr'=>'no','nl2'=>'no']), '', 'ok', '', 50); ?>
						            </div>
								</div>
								
								<div id="FlC_4" class="CollapsiblePanel">
						            <div class="CollapsiblePanelTab" tabindex="0"><?php echo h2('<button class="_fll"></button>Código Js Scroll'); ?> </div>
						            <div class="CollapsiblePanelContent">
							            <?php echo HTML_textarea('lnd_js_scrl', ' ', ctjTx($___Ls->dt->rw['lnd_js_scrl'],'in','', ['html'=>'ok','schr'=>'no','nl2'=>'no']), '', 'ok', '', 50); ?>
						            </div>
								</div>
								<?php $CntWb .= "var FlC_1 = new Spry.Widget.CollapsiblePanel('FlC_1', {contentIsOpen:true });"; ?> 
								<?php $CntWb .= "var FlC_2 = new Spry.Widget.CollapsiblePanel('FlC_2', {contentIsOpen:true });"; ?> 
								<?php $CntWb .= "var FlC_3 = new Spry.Widget.CollapsiblePanel('FlC_3', {contentIsOpen:true });"; ?> 
								<?php $CntWb .= "var FlC_4 = new Spry.Widget.CollapsiblePanel('FlC_4', {contentIsOpen:true });"; ?> 
			                </div>
		                </div> 
		                
		                <div class="TabbedPanelsContent">
							<div class="ln_1">
								<?php echo HTML_textarea('lnd_css', '<button class="_fll"></button>Código Css', ctjTx($___Ls->dt->rw['lnd_css'],'in','', ['html'=>'ok','schr'=>'no','nl2'=>'no']), FMRQD, 'ok', '', 50); ?>
			                </div>
		                </div> 
		                
		                <?php 
							
							$CntWb .= '
									
									var __rsz_dsh_e = "off";
									
									function __rsz_dsh(p){
				                        if(__rsz_dsh_e == "off"){
				                        	$.colorbox.resize({ width:"90%", height:"90%" });
				                        	__rsz_dsh_e = "on";
				                        	$(".__lnd_detail").addClass("flls");
				                        }else{    
				                            $.colorbox.resize({ width:"'.$___Ls->edit->w.'", height:"'.$___Ls->edit->h.'" });
				                            __rsz_dsh_e = "off";
				                            $(".__lnd_detail").removeClass("flls");
				                    	} 
				                    }
                    
									
									function CmrrSet(){
										
										SUMR_Main.ld.f.cdmrr(function(){		
											
											    	
		    								var '.$__id_edtr_1.' = CodeMirror.fromTextArea(document.getElementById("lnd_html"), {
					    											lineNumbers: false,
																    styleActiveLine: true,
																    theme:"solarized dark",
																    matchBrackets: true,
																    viewportMargin: Infinity
																});
	
											'.$__id_edtr_1.'.on("change", function('.$__id_edtr_1.', change) {
												$("#lnd_html").val( '.$__id_edtr_1.'.getValue() );
											});
											
											
											
											var '.$__id_edtr_2.' = CodeMirror.fromTextArea(document.getElementById("lnd_js"), {
					    											lineNumbers: false,
																    styleActiveLine: true,
																    theme:"solarized dark",
																    matchBrackets: true,
																    viewportMargin: Infinity
																});
	
											'.$__id_edtr_2.'.on("change", function('.$__id_edtr_2.', change) {
												$("#lnd_js").val( '.$__id_edtr_2.'.getValue() );
											});
											
											
											
											var '.$__id_edtr_3.' = CodeMirror.fromTextArea(document.getElementById("lnd_js_rdy"), {
					    											lineNumbers: false,
																    styleActiveLine: true,
																    theme:"solarized dark",
																    matchBrackets: true,
																    viewportMargin: Infinity
																});
											
											'.$__id_edtr_3.'.on("change", function('.$__id_edtr_3.', change) {
												$("#lnd_js_rdy").val( '.$__id_edtr_3.'.getValue() );
											});
											
											
											
											var '.$__id_edtr_4.' = CodeMirror.fromTextArea(document.getElementById("lnd_css"), {
					    											lineNumbers: false,
																    styleActiveLine: true,
																    theme:"solarized dark",
																    matchBrackets: true,
																    viewportMargin: Infinity
																});
											
											'.$__id_edtr_4.'.on("change", function('.$__id_edtr_4.', change) {
												$("#lnd_css").val( '.$__id_edtr_4.'.getValue() );
											});
											
											
											
											var '.$__id_edtr_5.' = CodeMirror.fromTextArea(document.getElementById("lnd_js_ld"), {
					    											lineNumbers: false,
																    styleActiveLine: true,
																    theme:"solarized dark",
																    matchBrackets: true,
																    viewportMargin: Infinity
																});
	
											'.$__id_edtr_5.'.on("change", function('.$__id_edtr_5.', change) {
												$("#lnd_js_ld").val( '.$__id_edtr_5.'.getValue() );
											});
											
											
											
											var '.$__id_edtr_6.' = CodeMirror.fromTextArea(document.getElementById("lnd_js_scrl"), {
					    											lineNumbers: false,
																    styleActiveLine: true,
																    theme:"solarized dark",
																    matchBrackets: true,
																    viewportMargin: Infinity
																});
											
											'.$__id_edtr_6.'.on("change", function('.$__id_edtr_6.', change) {
												$("#lnd_js_scrl").val( '.$__id_edtr_6.'.getValue() );
											});
											
											
											
											
											$(".__lnd_detail button._fll").off("click").click(function(e){		
												
												e.preventDefault();
												
												if(e.target != this){
											    	e.stopPropagation(); return;
												}else{
													__rsz_dsh();	
												}
												
												
											});
											
											
											
											
											$("#'.$___Ls->tab->id.' .TabbedPanelsTab").off("click").click(function(e){		
												
												e.preventDefault();
												
												if(e.target != this){
											    	e.stopPropagation(); return;
												}else{
													CmrrSet();	
												}
												
												
											});
											
	
	
										
										});
									
									}
									
									CmrrSet();
										
								';
							
						?>
								
								
		                <div class="TabbedPanelsContent">
		                	
		                	<?php if(($___Ls->dt->tot > 0)){ ?>				
								
								<div class="ln_1"><div id="_upl_fle"></div></div>
								<?php $CntWb .= "_ldCnt({ u:'".Fl_Rnd(FL_FM_GN.__t('up_lnd',true)).Fl_i($___Ls->dt->rw[$___Ls->ik])."', c:'_upl_fle' });"; ?>
								
							<?php } ?>
											            
		                </div> 
		                
		                <div class="TabbedPanelsContent">
		                    <?php echo $___Ls->tab->cdn->d ?>          
		                </div> 
		                
		                <div class="TabbedPanelsContent">
		                    <?php echo $___Ls->tab->tp->d ?>          
		                </div> 
		                
		                <div class="TabbedPanelsContent">
		                    <?php echo $___Ls->tab->font->d ?>          
		                </div> 
		                                                    
		            </div>
		              	
		          	<style>
				  	
				  		
				  		.__lnd_detail button._fll{ width: 20px; height: 20px; background-color: transparent; border: none; margin-right: 10px; }
				  		.__lnd_detail button._fll{ background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>lnd_fll_off.svg); }
				  		.__lnd_detail.flls button._fll{ background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>lnd_fll_on.svg); }
				  		
				  		
				  		.__lnd_detail .VTabbedPanels.mny._new > ul.TabbedPanelsTabGroup{ display: none; }
				  		.__lnd_detail .VTabbedPanels.mny._new > div.TabbedPanelsContentGroup{ width: 100%; border: none; }
					  	
					  	.__lnd_detail .VTabbedPanels.mny{ display: flex; }	
				        .__lnd_detail .VTabbedPanels.mny > ul.TabbedPanelsTabGroup{ background-color: white; width:45px !important; }
				        .__lnd_detail .VTabbedPanels.mny > div.TabbedPanelsContentGroup{ border-left: 1px dotted #bcbfbf; }
				        .__lnd_detail .VTabbedPanels.mny > div.TabbedPanelsContentGroup .TabbedPanelsContent{ padding-top: 0px; }
				        .__lnd_detail .VTabbedPanels.mny > div.TabbedPanelsContentGroup .TabbedPanelsContent._main{ padding-top: 0; }
				        .__lnd_detail .VTabbedPanels.mny:not(._new) > div.TabbedPanelsContentGroup .TabbedPanelsContent .ln_1{ padding-left: 20px; text-align: left; }
				        .__lnd_detail .VTabbedPanels.mny:not(._new) > div.TabbedPanelsContentGroup .TabbedPanelsContent .ln_1 h2{ padding: 0; border: none; }
				        
				        
				        .__lnd_detail .VTabbedPanels .Tt_Tb .btn{ margin-right: 0 !important; }
				        .__lnd_detail .VTabbedPanels .TabbedPanelsTab{ background-size: 60% auto; background-position: center center; min-height: 35px; min-width: 35px; max-width: 35px; background-repeat: no-repeat; opacity: 0.3; } 
				        .__lnd_detail .VTabbedPanels .TabbedPanelsTabSelected,
				        .__lnd_detail .VTabbedPanels .TabbedPanelsTabHover{ opacity: 1; background-color: white !important; }
				        
				        .__lnd_detail .VTabbedPanels .TabbedPanelsTab._bsc{ background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>lnd.svg); }
				        .__lnd_detail .VTabbedPanels .TabbedPanelsTab._cod_html{ background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>lnd_tab_html.svg); }
				        .__lnd_detail .VTabbedPanels .TabbedPanelsTab._cod_js{ background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>lnd_tab_js.svg); }
				        .__lnd_detail .VTabbedPanels .TabbedPanelsTab._cod_css{ background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>lnd_tab_css.svg); }
				        .__lnd_detail .VTabbedPanels .TabbedPanelsTab._up{ background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>lnd_tab_up.svg); }
				        .__lnd_detail .VTabbedPanels .TabbedPanelsTab._cdn{ background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>lnd_tab_cdn.svg); }
				         .__lnd_detail .VTabbedPanels .TabbedPanelsTab._tp{ background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>tipo.svg); }
				        .__lnd_detail .VTabbedPanels .TabbedPanelsTab._font{ background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>font.svg); }
				        
				        .__lnd_detail .__slc_ok{ border: none; padding-top: 20px; }
				        /*.__lnd_detail .__slc_ok h3{ display: none; }*/
						
						.__lnd_detail .Tt_Tb{ padding-left: 10px; }
						
						.__lnd_detail .CollapsiblePanelTab {background-color: #ececec;padding: 9px;cursor: pointer;margin: 4px 0;border-radius: 6px;}
				        
			        </style>
		           
		        </div>
			
			</div>
			
		</form>   
                
  	</div>

</div>
<?php } ?>
<?php } ?>