<?php
if(class_exists('CRM_Cnx')){
	
	$___Ls->sch->f = 'mdlstpfm_nm, mdlstpfm_plcy';
	
	$___Ls->new->w = 350;
	$___Ls->new->h = 580;
	$___Ls->edit->w = 700;
	$___Ls->edit->h = 680;
	$___Ls->_strt(); 
	
	if(!isN($___Ls->gt->i)){	
		
		$___Ls->qrys = sprintf("	SELECT * 
									FROM ".TB_MDL_S_TP_FM." 
										 INNER JOIN "._BdStr(DBM).TB_CL_PLCY." ON mdlstpfm_plcy = id_clplcy
									WHERE ".$___Ls->ik." = %s LIMIT 1", GtSQLVlStr($___Ls->gt->i, "text"));
		
	}elseif($___Ls->_show_ls == 'ok'){ 
		 
		 
		$Ls_Whr = "FROM ".TB_MDL_S_TP_FM."
				INNER JOIN ".TB_CL." ON mdlstpfm_cl = id_cl
		        ".GtSlc_QryExtra([ 't'=>'tb', 'col'=>'mdlstpfm_thm', 'als'=>'f' ])."
		        WHERE ".$___Ls->ino." != '' $_f_tp $__fl  $_f_tmpl ".$___Ls->sch->cod." AND cl_enc = '".DB_CL_ENC."'
		        ORDER BY ".$___Ls->ino." DESC";
				        
				        
		 $___Ls->qrys = "SELECT *, 
		        "._QrySisSlcF([ 'als'=>'f', 'als_n'=>'formulario' ]).",
		        ".GtSlc_QryExtra([ 't'=>'fld', 'p'=>'formulario', 'als'=>'f' ]).",
		        (SELECT COUNT(*) $Ls_Whr) AS ".QRY_RGTOT." $Ls_Whr "; 
	} 
	
	$___Ls->_bld(); 
?>
<?php if($___Ls->ls->chk=='ok'){ ?>
<?php $___Ls->_bld_l_hdr();?>
<?php if(($___Ls->qry->tot > 0)){ ?>
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="Ls_Rg">
 	<tr>
	    <th width="1%" <?php echo NWRP ?>><?php echo TX_FM_No ?></th>
	    <th width="40%" <?php echo NWRP ?>><?php echo TX_NM ?></th>
	    <th width="40%" <?php echo NWRP ?>><?php echo TX_FM ?></th>
	    <th width="40%" <?php echo NWRP ?>><?php echo TX_THX_URL ?></th>
	    <th width="10%" <?php echo NWRP ?>><?php echo TX_URL_PLCY ?></th> 
	    <th width="1%" <?php echo NWRP ?>></th> 
  	</tr>
  	<?php do { ?>
    <tr>    	   
	    <td width="1%" <?php echo NWRP ?>><?php echo Spn($___Ls->ls->rw[$___Ls->ino]); ?></td>
	    <td width="40%" align="left" nowrap="nowrap"><?php echo ShortTx(ctjTx($___Ls->ls->rw['mdlstpfm_nm'],'in'),150,'Pt', true); ?></td>
	    <td width="40%" align="left" nowrap="nowrap"><?php echo ctjTx($___Ls->ls->rw['formulario_sisslc_tt'],'in'); ?></td>
	    <td width="40%" align="left" nowrap="nowrap"><?php echo ctjTx($___Ls->ls->rw['mdlstpfm_plcy'],'in'); ?></td>
	    <td width="10%" align="left" nowrap="nowrap"><?php echo ctjTx($___Ls->ls->rw['mdlstpfm_thx_url'],'in'); ?></td>
	    <td width="1%" align="left" nowrap="nowrap" class="_btn"><?php echo $___Ls->_btn([ 't'=>'mod' ]); ?></td>
  	</tr>
  	<?php } while ($___Ls->ls->rw = $___Ls->sql->fetch_assoc()); ?>
</table>
<?php $___Ls->_bld_l_pgs(); ?>
<?php } ?>
<?php $___Ls->_h_ls_nr(); ?>
<?php } ?>
<?php if($___Ls->fm->chk=='ok'){ ?>

<div class="FmTb DshBldrFm">
	<div id="<?php  echo DV_GNR_FM ?>">                                
		<form method="POST" name="<?php echo $___Ls->fm->id; ?>" target="_self" id="<?php echo $___Ls->fm->id; ?>">
			<?php if(isN($___Ls->gt->bld)){ $___Ls->_bld_f_hdr(); }?>     
			<div id="<?php echo $___Ls->fm->fld->id ?>" class="<?php echo DV_GNR_FM_CMP ?>">	
				
				<?php if(isN($___Ls->gt->bld)){  	
					
					$___Ls->_dvlsfl_all([
						['n'=>'thnks', 'l'=>'Thank You Page'],
						['n'=>'ps', 't'=>'mdl_s_tp_fm_ps', 'l'=>'Paises'],
						['n'=>'plcy', 'l'=>'Politicas de Privacidad']
					]);
					$_id_tbpnl = 'TabPnl_'.Gn_Rnd(20); 
					$CntWb .= " SUMR_Main.bxajx.".$_id_tbpnl." = new Spry.Widget.TabbedPanels('".$_id_tbpnl."' {$_tb_dfl}); "; 
					$CntWb .= _DvLsFl([ 'i'=>$___Ls->tb->plcy ]);
				?>
					<div class="txt ln_1 _anm">
						<div id="<?php echo $_id_tbpnl ?>" class="VTabbedPanels TbGnrl mny formulario_data_tb <?php if($___Ls->dt->tot == 0){ echo '_new'; } ?>">
							<ul class="TabbedPanelsTabGroup">
								<?php echo $___Ls->tab->bsc->l ?>
								<?php echo $___Ls->tab->thnks->l ?>
								<?php echo $___Ls->tab->ps->l ?>
								<?php //echo $___Ls->tab->plcy->l ?>
								
							</ul>
							<div class="TabbedPanelsContentGroup">
								<div class="TabbedPanelsContent">
									<div class="col_1">
										<?php echo HTML_inp_tx('mdlstpfm_nm', TX_NM , ctjTx($___Ls->dt->rw['mdlstpfm_nm'],'in'), FMRQD); ?>	
										<?php 
											$l = __Ls(['k'=>'fm_thm', 'id'=>'mdlstpfm_thm', 'va'=>$___Ls->dt->rw['mdlstpfm_thm'] , 'ph'=>FM_LS_SLGN]); 
											echo $l->html; $CntWb .= $l->js; 
											
											$_ls_plcy = LsClPlcy([ 'id'=>'mdlstpfm_plcy', 'v'=>'clplcy_enc', 'va'=>$___Ls->dt->rw['clplcy_enc'] ]); 
											
											if(!isN($_ls_plcy)){
												echo $_ls_plcy;
												$CntWb .= JQ_Ls('mdlstpfm_plcy', TX_FMSLCPLCY);
											}else{
												echo '<div class="_msg wrn">Debes crear primero una politica de privacidad asociada</div>';
											}

											echo LsPs([ 'id'=>'mdlstpfm_dft_ps', 'v'=>'id_sisps', 'va'=>$___Ls->dt->rw['mdlstpfm_dft_ps'], 'rq'=>2 ]); $CntWb .= JQ_Ls('mdlstpfm_dft_ps', 'Pais por defecto');
											echo HTML_inp_tx('mdlstpfm_fnt', TX_FNT , ctjTx($___Ls->dt->rw['mdlstpfm_fnt'],'in'), '');
											echo HTML_inp_tx('mdlstpfm_css', 'Estilos Externos' , ctjTx($___Ls->dt->rw['mdlstpfm_css'],'in'), '');
							                echo HTML_inp_clr([ 'id'=>'mdlstpfm_clr_btn', 'plc'=>'Color Boton', 'vl'=>ctjTx($___Ls->dt->rw['mdlstpfm_clr_btn'],'in') ]); ?>	   
										
										<?php //echo HTML_inp_tx('mdlstpfm_plcy', TX_URL_PLCY , ctjTx($___Ls->dt->rw['mdlstpfm_plcy'],'in')); ?>
										
										<?php if($___Ls->dt->tot > 0){ ?>
											<div class="fm_fld"></div>	
											<button id="fmdata_publish" class="fmdata_publish">Publicar JSON</button>	
											<style>
												.fmdata_publish{ display: block; border-radius:10px; -moz-border-radius:10px; -webkit-border-radius:10px; border: 1px solid #ccc; background-color:#fff; padding: 10px 15px; margin-left:auto; margin-right:auto; font-family:Economica; }
												.fmdata_publish::before{ width:20px; height:20px; display:inline-block; background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>lnd_tab_up.svg); background-repeat:no-repeat; background-size: auto 80%; background-position:center center; margin-bottom:-4px; margin-right:5px; }
												.fmdata_publish._ld{ opacity:0.5; pointer-events:none; }
												.fmdata_publish._ld::before{ background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>loader_black.svg); }	
												.fmdata_publish.rdy{ border-color:green; color:green; }
											</style>
											<?php 
	
												$CntJV .= "	
												

													function Dom_Fm_Rbld(){
														
														$('#fmdata_publish').off('click').click(function(e){

															e.preventDefault();
													
															if(e.target != this){ 
																e.stopPropagation(); return false;
															}else{

																var _this = $(this);

																_Rqu({ 
																	f: 'prc',
																	t: 'mdl_s_tp_fm',
																	fm_enc: '".$___Ls->dt->rw['mdlstpfm_enc']."',
																	MM_rebuild: 'EdFmJson',
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

													}
													
													Dom_Fm_Rbld();

												";

											?>
										<?php } ?>
									
									</div>
									<div class="col_2">

										<?php echo OLD_HTML_chck('mdlstpfm_thx_top', TX_URL_TOP , $___Ls->dt->rw['mdlstpfm_thx_top'], 'in'); ?>
										<?php echo OLD_HTML_chck('mdlstpfm_s_sch', 'Activar Buscador' , $___Ls->dt->rw['mdlstpfm_s_sch'], 'in'); ?>
										
										<?php echo h2('Organizaciones'); ?>
										<?php echo OLD_HTML_chck('mdlstpfm_s_org_emp', Spn(TX_SHW).' '.TX_EMP, $___Ls->dt->rw['mdlstpfm_s_org_emp'], 'in'); ?>
										<?php echo OLD_HTML_chck('mdlstpfm_s_org_uni', Spn(TX_SHW).' '.TX_UNI, $___Ls->dt->rw['mdlstpfm_s_org_uni'], 'in'); ?>
										<?php echo OLD_HTML_chck('mdlstpfm_s_org_clg', Spn(TX_SHW).' '.TX_CLG, $___Ls->dt->rw['mdlstpfm_s_org_clg'], 'in'); ?>
										<?php echo OLD_HTML_chck('mdlstpfm_s_cl_sds', Spn(TX_SHW).' '.'Sedes del Cliente', $___Ls->dt->rw['mdlstpfm_s_cl_sds'], 'in'); ?>
										
										<?php echo h2('Otros'); ?>
										<?php echo OLD_HTML_chck('mdlstpfm_s_mdltp', Spn(TX_SHW).' '.'Tipo Modulo', $___Ls->dt->rw['mdlstpfm_s_mdltp'], 'in'); ?>
										<?php echo OLD_HTML_chck('mdlstpfm_s_are', Spn(TX_SHW).' '.'Area', $___Ls->dt->rw['mdlstpfm_s_are'], 'in'); ?>
										<?php echo OLD_HTML_chck('mdlstpfm_s_allmdl', Spn(TX_SHW).' '.'Todos los modulos', $___Ls->dt->rw['mdlstpfm_s_allmdl'], 'in'); ?>
										<?php echo OLD_HTML_chck('mdlstpfm_s_fltmdlstp', 'Filtrar por tipo', $___Ls->dt->rw['mdlstpfm_s_fltmdlstp'], 'in'); ?>

										<?php echo OLD_HTML_chck('mdlstpfm_s_mlt', 'Seleccion Multiple', $___Ls->dt->rw['mdlstpfm_s_mlt'], 'in'); ?>
										<?php echo OLD_HTML_chck('mdlstpfm_s_prd', 'Periodos Activos', $___Ls->dt->rw['mdlstpfm_s_prd'], 'in'); ?>
										<?php echo OLD_HTML_chck('mdlstpfm_s_cmnt', 'Campo comentario', $___Ls->dt->rw['mdlstpfm_s_cmnt'], 'in'); ?>
									</div>
								</div>
								<div class="TabbedPanelsContent">
									<div class="col_1">
										<?php echo HTML_inp_tx('mdlstpfm_thx_tt', TX_TT , ctjTx($___Ls->dt->rw['mdlstpfm_thx_tt'],'in')); ?>
										<?php echo HTML_inp_tx('mdlstpfm_thx_sbt', TX_SBT , ctjTx($___Ls->dt->rw['mdlstpfm_thx_sbt'],'in')); ?>
										<?php echo HTML_inp_tx('mdlstpfm_thx_url', TX_THX_URL , ctjTx($___Ls->dt->rw['mdlstpfm_thx_url'],'in')); ?>
									</div>
									<div class="col_2">
										<?php echo HTML_textarea('mdlstpfm_thx_dsc', '', ctjTx($___Ls->dt->rw['mdlstpfm_thx_dsc'],'in','', ['html'=>'ok','schr'=>'ok','nl2'=>'no']), '', '', '_anm ', 200, '600'); ?>
										<?php 
											$CntWb .= "$('#mdlstpfm_thx_dsc').summernote({ height: 350 });";
										?>
									</div>
								</div>
								<div class="TabbedPanelsContent">
									<div class="col_1">
										<?php echo $___Ls->tab->ps->d ?>
									</div>
								</div>
								<div class="TabbedPanelsContent">
									<div class="col_1">
										<?php //echo HTML_inp_tx('mdlstpfm_plcytt', 'Titulo' , ctjTx($___Ls->dt->rw['mdlstpfm_plcytt'],'in'), FMRQD); ?>			
										<?php //echo HTML_inp_tx('mdlstpfm_plcylnk', 'Link' , ctjTx($___Ls->dt->rw['mdlstpfm_plcylnk'],'in'), FMRQD); ?>	
									</div>
									<div class="col_2">
										<?php //echo HTML_textarea('mdlstpfm_plcytx', 'Texto', ctjTx($___Ls->dt->rw['mdlstpfm_plcytx'], 'in')); ?>
									</div>
								</div>
								
							</div>
						</div>
					</div>				  	
				<?php } ?>		
				<?php if(!isN($___Ls->gt->bld)){ $tab_act = 'ok'; }else{ $tab_act = 'pnl_stb'; } ?>
				<?php if(!isN($___Ls->gt->bld)){ $CntJV = "bld_mdl = '1';"; }else{ $CntJV = "bld_mdl = '2';";} ?>
		
				<div id="pnl_stb" class="pln_frm _anm ln_1 <?php echo $tab_act; ?>">
					<div class="ln_1">  	
						<style>
						.cl_grp_dsh{ text-align: center; margin-top: 10px; display: flex; }
						.cl_grp_dsh ._c{ width: 100%; }
						.cl_grp_dsh ._c._c1{ width: 30%; display: inline-block } 
						.cl_grp_dsh ._c h2{ text-align: center; }
						.cl_grp_dsh ._c ul .itm.prm_tp{ padding: 0; margin: 0 0 10px 0; position: relative;}
						.cl_grp_dsh ._c ul .itm.prm_tp ul{ padding: 0 0 0 30px; margin: 0; z-index: 10; }
						.cl_grp_dsh ._c ul .itm.prm_tp h2{ display: block; position: absolute; left: 0; top: 0; padding: 10px 0; width: 35px; height: 100%; border: none; background-color: #6a6d6e; color: white; z-index: 0; writing-mode: tb-rl; line-height: 38px; font-size: 11px; font-weight: 300; text-overflow: ellipsis; border-radius: 10px 0px 0px 10px;-moz-border-radius: 10px 0px 0px 10px; -webkit-border-radius: 10px 0px 0px 10px; }
						#bx_mdl_<?php echo $__Rnd ?> li._anm.itm.on{border: 2px solid var(--second-bg-color);color: var(--main-bg-color);}
						#bx_mdl_<?php echo $__Rnd ?> li._anm.itm.off{ opacity: 0.5; }
						#bx_mdl_<?php echo $__Rnd ?> li._anm.itm.off:hover{ opacity: 1; }    
						</style>		
					</div>    
					<div class="cl_grp_dsh dsh_cnt">
						<div class="_c _c1 _anm _scrl">
							<?php echo h2('<button new-tp="us"></button> '.'Vinculo'); ?>
							<div class="_wrp">
								<ul id="bx_mdl_<?php echo $__Rnd; ?>" class="_ls _anm dls"></ul>	
								<div class="_new_fm" id="bx_fm_us_<?php echo $__Rnd; ?>"></div>	 
							</div>
						</div>
						<div class="col_1 flds">
							<div id="sortable2" class="sortable1"></div>	
						</div>
						<div class="col_2">
							<div id="sort_enable" class="sort_enable"></div>
							<div id="sortable1" class="sortable1"></div> 	
							<button class="fm_row_add _anm"><?php echo TX_ADD.' Fila'; ?></button>
						</div>	
					</div>
				</div>
				<div class="bldr_fm_btns">
					<ul>
						<?php if(isN($___Ls->gt->bld)){ ?><li class="fm_bck _anm"><?php echo TX_VLVR; ?></li><?php } ?>
					</ul>
				</div> 

        	<?php if($___Ls->dt->tot > 0){
	        	
	    		$CntJV .= "	  	
					
					var SUMR_Dsh_Fm = {
								id_fldnew:'',
								tp_fldnew:'',
								mdltpfm:{},
								mdltpfmfld:{},
								mdltpfmcnttp:{}
							}; 
		
					function Dom_Rbld(){

						var __clgrp_bx_are_itm = $('#bx_are_".$__Rnd." li.itm.are ');
						var __clgrp_bx_are_fm = $('#bx_fm_are_".$__Rnd."');
						
						$('.fm_bck').click(function(){ 
							$( '.ln_1._anm' ).removeClass('ok'); 
							$( '#pnl_stb' ).addClass('pnl_stb'); 
							$( '.DshBldrFm .bldr_fm_btns' ).removeClass('on');	
							__rsz_dsh();	
						});
						$('.fm_fld').click(function(){ 
							$( '.ln_1._anm' ).addClass('ok'); 
							$( '#pnl_stb' ).removeClass('pnl_stb'); 
							$( '.DshBldrFm .bldr_fm_btns' ).addClass('on'); 
							__rsz_dsh({ t:'fll' }); 
						});
						
						$( function() { 
							$( '.sortable1' ).sortable(); 
							$( '.sortable1' ).disableSelection();
						});
						
						$('#".$___Ls->fm->id." .fm_row_add').not('.sch').off('click').click(function(e){		
							
							e.preventDefault();
							var _this = $(this);
							
							if(e.target != this){
								e.stopPropagation();
								return;
							}else{

								_Rqu({ 
									t:'mdl_s_tp_fm', 
									d:'row',
									est: 'in',
									_bs:function(){
										_this.addClass('_ld');
									},
									_cm:function(){
										_this.removeClass('_ld');	
									},
									_id_fm : '".Php_Ls_Cln($___Ls->gt->i)."',
									_cl:function(_r){ if(!isN(_r)){ if(!isN(_r)){ ClSet(_r); } } } 
								});
							
							}

						});
						
						var __mdls_bx_sch_itm = $('#bx_mdl_".$__Rnd." > li.itm ');
						__mdls_bx_sch_itm.not('.sch').off('click').click(function(){
						
							$(this).hasClass('on') ? est = 'del' : est = 'ok'; 		
							var _id = $(this).attr('rel');
	
							_Rqu({ 
								t:'mdl_s_tp_fm', 
								d:'cnt_tp',
								est: est,
								_id_fm : '".Php_Ls_Cln($___Ls->gt->i)."',
								_id : _id,
								_cl:function(_r){ if(!isN(_r)){ if(!isN(_r)){ ClSet(_r); } } } 
							});
							
						});	
						
						SUMR_Main.LsSch({ str:'#sch_sch_".$___Ls->id_rnd."', ls:__mdls_bx_sch_itm });
 
						$('.opc_del_fm').off('click').click(function(event){
							
							var _id = $(this).attr('id'); 
							
							swal({									  
								  title: '".TX_ETSGR."',              
								  text: '".TX_DLTFLD."!',  
								  type: 'warning',                        
								  showCancelButton: true,                 
								  confirmButtonClass: 'btn-danger',       
								  confirmButtonText: '".TX_YESDLT."',      
								  confirmButtonColor: '#E1544A',          
								  cancelButtonText: '".TX_CNCLR."',           
								  closeOnConfirm: true                   
								},										  
							function(){                               					
								_Rqu({ 
									t:'mdl_s_tp_fm', 
									d:'row',
									est: 'eli',
									_id_fm : '".Php_Ls_Cln($___Ls->gt->i)."',
									id_row: _id,
									_bs:function(){ $('.sortable1').addClass('_ld'); },
									_cm:function(){ $('.sortable1').removeClass('_ld'); },
									_cl:function(_r){ if(!isN(_r)){ if(!isN(_r)){ ClSet(_r); } } } 
								}); 
							});		 
					    });
					    
					    $('.opc_edt_fm').off('click').click(function(event){

							var id_fm = $(this).attr('data-id');
					
							_ldCnt({ 
								u:'".FL_LS_GN.__t('mdl_s_tp_fm_attr',true).TXGN_POP.TXGN_BX.$___Ls->bx_rld.ADM_LNK_SB."'+id_fm,
								w:'98%',
								h:'98%',
								pop:'ok',
								pnl:{
									e:'ok',
									tp:'h',
									s:'l'
								}
							});	
	 
						});
						
						$('.opc_flt_fm').off('click').click(function(event){

							var id_fm = $(this).attr('data-id');
							var id_rel = $(this).attr('rel');

							_ldCnt({ 
								u:'".FL_LS_GN.__t('mdl_s_tp_fm_exc',true).TXGN_POP.TXGN_BX.$___Ls->bx_rld.ADM_LNK_SB."'+id_fm+'&_rel='+id_rel,
								w:'98%',
								h:'98%',
								pop:'ok',
								pnl:{
									e:'ok',
									tp:'h',
									s:'l'
								}
							});
	 
					    });
					}
 			

					function Cnt_Cols(p){
						
						var _cnt = p; 
						
						if(_cnt > 0 && _cnt <= 3){
							if(_cnt == 3){
								$('#'+_cnt).removeClass('cols_1 cols_2 cols_3 full_cols').addClass('cols_3 full_cols');	
							}else{
								$('#'+_cnt).removeClass('cols_1 cols_2 cols_3 full_cols').addClass('cols_'+_cnt);										
							}
						}else{
							$('#'+_cnt).removeClass('cols_1 cols_2 cols_3 full_cols').addClass('cols_1');	
						}		
					}	
					
					
					function __rsz_dsh(p){
                        if(!isN(p) && !isN(p.t) && p.t == 'fll'){
                        	$.colorbox.resize({ width:'90%', height:'90%' });
                        }else{    
                            $.colorbox.resize({ width:".$___Ls->edit->w.", height:".$___Ls->edit->h." });
                    	} 
                    }
                    
                    function MdlSSch_Html(){
	                    
	                    var __mdls_bx_sch = $('#bx_mdl_".$__Rnd."');
		
						__mdls_bx_sch.html('');
						__mdls_bx_sch.append('<li class=\"sch\">".HTML_inp_tx('sch_sch_'.$___Ls->id_rnd, TX_SEARCH, '')."<button class=\"_new _anm\" new-tp=\"sch\"></button></li>');
						
						if(!isN(SUMR_Dsh_Fm.mdltpfmcnttp['ls'])){
							$.each(SUMR_Dsh_Fm.mdltpfmcnttp['ls'], function(k, v) { 
								if(!isN(v.est) && v.est >= 1){ var _cls = 'on'; }else{ var _cls = 'off'; }
								__mdls_bx_sch.append('<li class=\"_anm itm '+_cls+'\" sch-id=\"'+v.enc+'\" rel=\"'+v.enc+'\" ><span>'+v.tt+'</span></li>');
							});	
						}
						
						Dom_Rbld();
					}
 											
					function ClGrpAre_Html(){
						$(  '#sortable1' ).html('');
						$(  '#sortable2' ).html('');
						
						$('#sortable2').append('<div id=\"fld_nop\" class=\"cols_1 beta cap ui-sortable\"></div>');
 
						if(SUMR_Dsh_Fm.mdltpfmfld['tot'] > 0){
							$.each(SUMR_Dsh_Fm.mdltpfmfld['ls'], function(k, v) {
								$('#sortable2 #fld_nop').append('<div data_tp=\"dta\" data-nm=\"'+v.tt+'\" data-id=\"'+v.enc+'\" class=\'tile\'>'+v.tt+'</div>');
							});
						}
							
						if(SUMR_Dsh_Fm.mdltpfm['tot'] > 0 ){
							
							if(bld_mdl == 2){ 
								
								var _id_s = '#sortable1'; 
								
								$.each(SUMR_Dsh_Fm.mdltpfm['ls'], function(k, v) {
								
									if(v.fld.tot == 1){ var est='cols_1'; }else if(v.fld.tot == 2){ var est='cols_2'; }else if(v.fld.tot == 3){ var est='cols_3 full_cols'; }else{ var est='cols_1'; }
									$(_id_s).append('<div id=\"'+v.enc+'\" class=\"'+est+' alpha cap ui-sortable\"></div>');
	
									$('#'+v.enc).append('<p class=\"delete_row\">Prueba</p>');
									if(v.fld.tot > 0){
										
										$.each(v.fld.ls, function(_k, _v) {
											
											if(!isN(_v.tt_edt)){ 
												var __edt = '<div rel=\"'+_v.enc_fldrow+'\" class=\'opc_s opc_edt_fm\'></div>'; 
												var cls = '__tt'; 
												var inp_hd = '<input data-tp=\"'+_v.tp+'\" id=\"inpt_'+_v.enc_fldrow+'\" rel=\"'+_v.enc_fldrow+'\" type=\"hidden\" value=\"'+_v.tt_d+'\">'; 
											}else{ 
												var __edt = ''; 
												var cls = ''; 
												var inp_hd = '';
											}

											if(!isN(_v.cmps.ls.ls)){ 
												var flt = '<div data-id=\"'+_v.enc_fldrow+'\" rel=\"'+_v.cmps.ls.ls+'\" class=\'opc_s opc_flt_fm\'></div>';
											}else{ 
												var flt = '';
											}
											
											$('#'+v.enc).append('
												<div data_tp=\"fld_y\" data-nm=\"'+_v.tt+'\" data-id=\"'+_v.enc+'\" class=\'fld_y tile\'>
													<div data-id=\"'+_v.enc_fldrow+'\" class=\'opc_s opc_edt_fm\'></div>
													'+flt+'
													<div id=\"'+_v.enc_fldrow+'\" class=\'opc_s opc_del_fm\'></div>'+inp_hd+''+_v.tt+''+__edt+'
												</div>');		
										});	
									}				
								});
							}else{
								var _id_s = '#sort_enable';
								$(_id_s).html(''); 
								
								$.each(SUMR_Dsh_Fm.mdltpfm['ls'], function(k, v) {
								
									if(v.fld.tot == 1){ var est='cols_1'; }else if(v.fld.tot == 2){ var est='cols_2'; }else if(v.fld.tot == 3){ var est='cols_3 full_cols'; }else{ var est='cols_1'; }
									$(_id_s).append('<div id=\"'+v.enc+'\" class=\"'+est+' \"></div>');

									if(v.fld.tot > 0){
										
										$.each(v.fld.ls, function(_k, _v) {
											$('#'+v.enc).append('<div data_tp=\"fld_y\" data-nm=\"'+_v.tt+'\" data-id=\"'+_v.enc+'\" class=\'fld_y\'>'+_v.tt+'</div>');		
										});	
									}				
								});
							}
						}
						
						$( '#sortable1' ).sortable({
							
							update: function () {
								var _id = $(this).attr('id');
								var idsInOrder = $('#'+_id).sortable('toArray',{ attribute: 'id' });
								console.log('1 -> '+idsInOrder);
								_Rqu({ 
									t:'mdl_s_tp_fm', 
									d:'row',
									est: 'mod',
									_id_fm : '".Php_Ls_Cln($___Ls->gt->i)."',
									id_row: _id,
									pos : idsInOrder,
									_bs:function(){ $('#sortable1').addClass('_ld'); },
									_cm:function(){ $('#sortable1').removeClass('_ld'); },
									_cl:function(_r){ if(!isN(_r)){ if(!isN(_r)){ ClSet(_r); } } } 
								});																		
							}
						});
						
						$('.beta').sortable({
							connectWith: '.alpha',
							update: function ( event, ui ) {
								var _id = $(this).attr('id');
								var _cnt = $('#'+_id+' .tile').length;
								_id_start = '';
								_id_start_int = '';
								var _cnt2 = $('#'+_id+' .tile').attr('data_tp');
								
								if(_id == 'fld_nop'){
									SUMR_Dsh_Fm.id_fldnew = ui.item.attr('data-id');
									SUMR_Dsh_Fm.tp_fldnew = _id;			
								}																		
							}
						});
						
						$('.delete_row').click(function(){
						
							var _id = $(this).parent().attr('id'); 
							swal({									  
								  title: '".TX_ETSGR."',              
								  text: '".TX_DLTFLD."!',  
								  type: 'warning',                        
								  showCancelButton: true,                 
								  confirmButtonClass: 'btn-danger',       
								  confirmButtonText: '".TX_YESDLT."',      
								  confirmButtonColor: '#E1544A',          
								  cancelButtonText: '".TX_CNCLR."',           
								  closeOnConfirm: true                   
								},										  
							function(){                               					
								_Rqu({ 
									t:'mdl_s_tp_fm', 
									d:'row_fll',
									est: 'eli',
									_id_fm : '".Php_Ls_Cln($___Ls->gt->i)."',
									id_row: _id,
									_bs:function(){ $('.sortable1').addClass('_ld'); },
									_cm:function(){ $('.sortable1').removeClass('_ld'); },
									_cl:function(_r){ if(!isN(_r)){ if(!isN(_r)){ ClSet(_r); } } } 
								}); 
							});	
						});
						
						
						$('.alpha').sortable({
							items : ':not(.delete_row)',
							start: function(event, ui) {
							    var _id = $(this).attr('id');
							    var _id_int = ui.item.attr('data-id');
							    _id_start = _id;
							    _id_start_int = _id_int;
								var _cnt = ($('#'+_id+' .tile').length)-1;
								Cnt_Cols(_cnt);	
							},
							over : function(event, ui){
								var _id = $(this).attr('id');
								var _cnt = $('#'+_id+' .tile').length;
								$('#'+_id).css('background-color', '#d0d0d0');
								Cnt_Cols(_cnt);
						    },
							out: function(event, ui){
								$(this).css('background-color', '#f5f5f5');
							},
							stop: function (event, ui) {
								 
									var _id = $(this).attr('id');
									var _cnt = $('#'+_id+' .tile').length;
									Cnt_Cols(_cnt);		
									var idsInOrder = $('#'+_id).sortable('toArray',{ attribute: 'data-id' });
									console.log(idsInOrder);
									
									if(idsInOrder.length > 0){
										
										Cnt_Cols(_cnt);
										var idsInOrder = $('#'+_id).sortable('toArray',{ attribute: 'data-id' });
									
										_Rqu({ 
											t:'mdl_s_tp_fm', 
											d:'row_fld',
											est: 'mod',
											tp: 'fld_y',
											_id_fm : '".Php_Ls_Cln($___Ls->gt->i)."',
											id_row: _id,
											pos : idsInOrder,
											_bs:function(){ $('.sortable1').addClass('_ld'); },
											_cm:function(){ $('.sortable1').removeClass('_ld'); },
											_cl:function(_r){ if(!isN(_r)){ if(!isN(_r)){ ClSet(_r); } } } 
										});		
										
									}	
																		
							},
							update: function (event, ui) {
								var _id = $(this).attr('id');
								var _cnt = $('#'+_id+' .tile').length;
								Cnt_Cols(_cnt);			
								var idsInOrder = $('#'+_id).sortable('toArray',{ attribute: 'data-id' });							
							},
							receive: function(event, ui) {
								if ($(ui.item).parent().hasClass('full_cols')) {
									ui.sender.sortable('cancel'); 
								}else{
						
									var _id_old = _id_start;
									var _id = $(this).attr('id');
									var _tp = $('#'+_id+' div').attr('data_tp');
									
									var _cnt = $('#'+_id+' .tile').length; 
									
									if(!isN(SUMR_Dsh_Fm.tp_fldnew)){
										var _id_newfld = SUMR_Dsh_Fm.id_fldnew;
										var _tp = SUMR_Dsh_Fm.tp_fldnew;
									}else{
										var _id_newfld = '';	
									}
									
									Cnt_Cols(_cnt);
									var idsInOrder = $('#'+_id).sortable('toArray',{ attribute: 'data-id' });
									console.log(idsInOrder);
									
									_Rqu({ 
										t:'mdl_s_tp_fm', 
										d:'row_fld',
										est: 'mod',
										tp: _tp,
										_id_newfld: _id_newfld,
										_id_fm : '".Php_Ls_Cln($___Ls->gt->i)."',
										id_row: _id,
										id_old: _id_old,
										id_start_int: _id_start_int,
										pos : idsInOrder,
										_bs:function(){ $('.sortable1').addClass('_ld'); },
										_cm:function(){ $('.sortable1').removeClass('_ld'); },
										_cl:function(_r){ if(!isN(_r)){ if(!isN(_r)){ ClSet(_r); } } } 
									});	
								}
							},
							connectWith: '.cap'
						});
						Dom_Rbld();                                                                                                                                                                                                                                                                                 
					}
					
					function ClSet(p){

						if( !isN(p) ){ 
							 
							if( !isN(p.mdl_tp.fm) ){ 
								SUMR_Dsh_Fm.mdltpfm['ls'] = p.mdl_tp.fm.row.ls; 
								SUMR_Dsh_Fm.mdltpfm['tot'] = p.mdl_tp.fm.row.tot;
								SUMR_Dsh_Fm.mdltpfmfld['ls'] = p.mdl_tp.fm.fld.ls; 
								SUMR_Dsh_Fm.mdltpfmfld['tot'] = p.mdl_tp.fm.fld.tot;
								SUMR_Dsh_Fm.mdltpfmcnttp['ls'] = p.mdl_tp.fm.cnt_tp.ls; 
								SUMR_Dsh_Fm.mdltpfmcnttp['tot'] = p.mdl_tp.fm.cnt_tp.tot;
							}

							ClGrpAre_Html();
							MdlSSch_Html();
							
							if(SUMR_Dsh_Fm.mdltpfm['tot'] == 0){
								$('#sortable1').append('<div class=\"empty\"><h3>No hay columnas</h3><p>".TX_NW_ROW."</p></div>');	
							}	
						}
					}
				";

				$CntJV .= " 	
					_Rqu({ 
						t:'mdl_s_tp_fm', 
						_id_fm : '".Php_Ls_Cln($___Ls->gt->i)."',
						_cl:function(_r){ if(!isN(_r)){ if(!isN(_r)){ ClSet(_r); } } } 
					});
				";
	    	} ?>
			</div>
		</form>
	</div>
</div>
<style>
	<?php if(isN($___Ls->gt->bld)){ $w = 'width: 30% !important;'; }else{ $w = 'width: 45% !important;'; }?> 
	
	
	.DshBldrFm .txt._anm{height:650px;overflow:hidden}
	.DshBldrFm .txt._anm.ok{ height:0; top:-100px; pointer-events:none; }
	.DshBldrFm .txt .col_1 .fm_fld{width:150px;height:150px;background-color:#eaeaea;border-radius: 50%;-moz-border-radius: 50%;-webkit-border-radius: 50%;margin:30px auto;cursor:pointer;line-height:1000;background-size:50% auto;background-repeat:no-repeat;background-position:center;background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>mdl_cod_fm.svg);}
	.DshBldrFm .txt .col_1 .fm_fld:hover{background-color:#dcdcdc}
	.DshBldrFm .pnl_stb{height: 0px;overflow: hidden; }

	.DshBldrFm .bldr_fm_btns{ width: 50px; height: 50px; position: absolute; left:0; bottom: 25px; z-index: 10000; display:none; pointer-events:none; }
	.DshBldrFm .bldr_fm_btns.on{ display:block; pointer-events:all; }
	.DshBldrFm .bldr_fm_btns ul{ padding:0; margin:0; }
	.DshBldrFm .bldr_fm_btns ul li { display: block; width:40px;height:40px; font-size: 0; cursor: pointer; position: relative; }
	.DshBldrFm .bldr_fm_btns ul li.fm_bck{ background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>ec_img_edt.svg); background-repeat:no-repeat; background-position:center center; background-size:auto 100%; }
	.DshBldrFm .bldr_fm_btns ul li.fm_bck:hover{ background-size: auto 90%; }

	.DshBldrFm .pln_frm{ margin:0; }
	.DshBldrFm .pln_frm .fm_row_add{ text-align:center; width:100%; border:3px dotted #ddd; padding:10px 5px; font-family:Economica; text-transform:uppercase; font-size: 16px; }
	.DshBldrFm .pln_frm .fm_row_add::before{ display:inline-block; background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>add.svg); width:20px; height:20px; background-repeat:no-repeat; background-position:center center; background-size:auto 100%; margin-right:5px; margin-bottom: -3px; }
	.DshBldrFm .pln_frm .fm_row_add:hover::before{ background-size: auto 90%; }
	
	.DshBldrFm .pln_frm .fm_row_add._ld{ pointer-events:none; }
	.DshBldrFm .pln_frm .fm_row_add._ld::before{ background-image: url(<?php echo _iEtg(DMN_IMG_ESTR_SVG.'loader_black.svg') ?>); }

	.DshBldrFm .pln_frm .tile{background:#f5f8fa;color:#a2a2a2;display:inline-flex;border:1px solid #d2d2d2;border-radius:5px;-moz-border-radius:5px;-webkit-border-radius:5px;font-size:13px;position:relative;cursor: move;pointer-events: auto;}
	.DshBldrFm .pln_frm .flds.col_1 .sortable1 .beta .tile{margin: 6px !important;padding:10px 15px;}
	.DshBldrFm .pln_frm .col_2 .sortable1 .alpha,
	.DshBldrFm .pln_frm .col_2 .sort_enable .cols_1,
	.DshBldrFm .pln_frm .col_2 .sort_enable .cols_2,
	.DshBldrFm .pln_frm .col_2 .sort_enable .cols_3{margin:15px;width:94%;background-color:#f5f5f5;height:65px;border:1px dashed #c3c3c3;cursor: grab;position: relative;display: flex}
	
	.DshBldrFm .pln_frm .col_2 .sortable1 .alpha.cols_1 .tile{width:95%;padding:10px 30px;margin:10px 15px}
	.DshBldrFm .pln_frm .col_2 .sortable1 .alpha.cols_2 .tile{width:45%;display:inline-block;padding:10px 30px;margin:8px 15px}
	.DshBldrFm .pln_frm .col_2 .sortable1 .alpha.cols_3 .tile{width:28%;display:inline-block;padding:10px 30px;margin:8px 15px}
	.DshBldrFm .pln_frm .col_2 .sortable1 { position: relative; }		
	.DshBldrFm .pln_frm .col_2 .sortable1 .alpha .fld_y.tile .opc_del_fm {background-image:url(<?php echo DMN_IMG_ESTR_SVG ?>delete.svg);}
	.DshBldrFm .pln_frm .col_2 .sortable1 .alpha .fld_y.tile .opc_s{ background-size: 90% auto; width: 25px;height: 100%;display: none;position: absolute;top: 0px;right: 0px;cursor: pointer;background-color: #CDDC39;background-repeat: no-repeat;background-position: center;border-radius:0px 4px 4px 0px;-moz-border-radius:0px 4px 4px 0px;-webkit-border-radius:0px 4px 4px 0px; }
	
	.DshBldrFm .pln_frm .col_2 .sortable1 .alpha .fld_y.tile:hover .opc_del_fm,
	.DshBldrFm .pln_frm .col_2 .sortable1 .alpha .fld_y.tile:hover .opc_edt_fm,
	.DshBldrFm .pln_frm .col_2 .sortable1 .alpha .fld_y.tile:hover .opc_flt_fm {display: block;}
	
	.DshBldrFm .pln_frm .col_2 .sortable1 .alpha .fld_y.tile.___edt:hover .opc_s {display: none !important;}
	
	.DshBldrFm .pln_frm .col_2 .sortable1 .alpha::before{ content: ''; background-color: #e04f5f;width: 30px;height: 65px;display: none;position: absolute;left: -31px;background-repeat: no-repeat;background-position: center;background-image:url(<?php echo DMN_IMG_ESTR_SVG ?>delete.svg);pointer-events:auto; }
	.DshBldrFm .pln_frm .flds.col_1 ._ld,
	.DshBldrFm .pln_frm .col_2 ._ld{ cursor: none; }
	.DshBldrFm .pln_frm .flds.col_1 ._ld .tile,
	.DshBldrFm .pln_frm .col_2 ._ld .tile{ cursor: none; opacity: 0.4; }
	.DshBldrFm .pln_frm .col_2 .sortable1 .empty{ background-position: center;background-repeat: no-repeat;background-size: 100% auto;background-image:url(<?php echo DMN_IMG_ESTR_SVG ?>empty-inbox.svg);width: 200px;height: 200px;display: block;vertical-align: top;margin: 90px auto;}
	.DshBldrFm .pln_frm .col_2 .sortable1 .empty h3{padding-top: 175px;text-align: center;}
	.DshBldrFm .pln_frm .col_2 .sortable1 .empty p{text-align: center;width: 100%;display: block;white-space: normal;color: #cccccc;font-family: Roboto;}	 
	.DshBldrFm .opc_dcd{height: 100%;position: absolute;font-size: 0;top: 0px;left: -31px;margin: 0;padding: 0; }
	.DshBldrFm .opc_dcd li{ background-repeat: no-repeat;background-position: center;   width: 30px;display: block;height: 63px;cursor: pointer;background-color: #e04f5f;background-image:url(<?php echo DMN_IMG_ESTR_SVG ?>delete.svg);  } 
	.DshBldrFm p.delete_row {background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>delete.svg);width: 25px;height: 63px;display: block;top: 0px;left: 0px;font-size: 0;cursor: pointer;background-color: #e24d5c;background-repeat: no-repeat;background-position: center;}
	.DshBldrFm .sort_enable .cols_1 div{ width: 100%; display: inline-block }
	.DshBldrFm .sort_enable .cols_2 div{ width: 49%;  display: inline-block}
	.DshBldrFm .sort_enable .cols_3 div{ width: 33%; display: inline-block }
	.DshBldrFm .sort_enable .cols_1 .fld_y,
	.DshBldrFm .sort_enable .cols_2 .fld_y,
	.DshBldrFm .sort_enable .cols_3 .fld_y{ background: #f5f8fa;color: #a2a2a2;display: block;float: left;border: 1px solid #d2d2d2;border-radius: 5px;-moz-border-radius: 5px;-webkit-border-radius: 5px;font-size: 13px;position: relative;cursor: move;pointer-events: auto;display: inline-block;padding: 14px;margin: 8px 15px;} 	
	.DshBldrFm .pln_frm .col_2 .sortable1 .alpha .fld_y.tile:hover .opc_edt_fm{left: 0px;background-color: #f15340;border-radius: 4px 0px 0px 4px;-moz-border-radius: 4px 0px 0px 4px;-webkit-border-radius: 4px 0px 0px 4px;background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>editar.svg);}
	.DshBldrFm .pln_frm .col_2 .sortable1 .alpha .fld_y.tile:hover .opc_del_fm{background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>delete.svg);}
	.DshBldrFm .pln_frm .col_2 .sortable1 .alpha .fld_y.tile:hover .opc_flt_fm{background-color: #48c390;background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>mdl_s_t_fm_fltr.svg);right: 25px;background-size: 65% auto;border-radius:0px;-moz-border-radius: 0px;-webkit-border-radius: 0px;}
	
	

	.DshBldrFm .VTabbedPanels.mny.formulario_data_tb._new .col_1{ width: 100%; border: none; }
	.DshBldrFm .VTabbedPanels.mny.formulario_data_tb._new .col_2{ display: none; }
	.DshBldrFm .__tt.fld_y.tile.___edt{padding:0!important}
	.DshBldrFm .___edt input[type="text"] {
		background-color: #fff;
		height: 30px;
		padding: 0 15px;
		z-index: 9;
		position: relative;
		width: 100%;
		margin-top: -4px;
		border: 1px solid #c5c5c5;
	}

	.DshBldrFm .DshBldrFm .pln_frm .col_2 .sortable1 .alpha.cols_1 .tile.___edt{ overflow: hidden }
	.DshBldrFm .VTabbedPanels.mny.formulario_data_tb > ul.TabbedPanelsTabGroup, 
	.DshBldrFm .VTabbedPanels.mny.formulario_data_tb > div.TabbedPanelsContentGroup .VTabbedPanels.mny ul.TabbedPanelsTabGroup{ width: 7% !important; background-color: white !important; }
	
	.DshBldrFm .VTabbedPanels.mny.formulario_data_tb > ul li.TabbedPanelsTab{ width: 35px; height: 35px;background-size: 22px;background-repeat: no-repeat;background-position: center; }
	
	.DshBldrFm .VTabbedPanels.mny.formulario_data_tb .TabbedPanelsTabGroup .TabbedPanelsTab._bsc{ background-image:url('<?php echo DMN_IMG_ESTR_SVG ?>cnt_dtl.svg'); }
	.DshBldrFm .VTabbedPanels.mny.formulario_data_tb .TabbedPanelsTabGroup .TabbedPanelsTabSelected._bsc{ background-image:url('<?php echo DMN_IMG_ESTR_SVG ?>cnt_dtl_w.svg'); }
	
	.DshBldrFm .VTabbedPanels.mny.formulario_data_tb .TabbedPanelsTabGroup .TabbedPanelsTab._plcy{ background-image:url('<?php echo DMN_IMG_ESTR_SVG ?>cnt_sec.svg'); }
	.DshBldrFm .VTabbedPanels.mny.formulario_data_tb .TabbedPanelsTabGroup .TabbedPanelsTabSelected._plcy{ background-image:url('<?php echo DMN_IMG_ESTR_SVG ?>cnt_sec_w.svg'); }
	
	
	
	.DshBldrFm .VTabbedPanels.mny.formulario_data_tb .__slc_ok span{ font-size: 0.8em; color: #a3a7a7; }
</style>
<?php } ?>
<?php } ?>