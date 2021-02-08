<?php
if(class_exists('CRM_Cnx')){
	
	$___Ls->sch->f = 'applfm_nm, applfm_plcy';
	
	$___Ls->new->w = 700;
	$___Ls->new->h = 650;
	$___Ls->edit->w = 700;
	$___Ls->edit->h = 400;
	$___Ls->_strt(); 
	
	if(!isN($___Ls->gt->i)){	
		
		$___Ls->qrys = sprintf("SELECT * FROM ".TB_APPL_FM." INNER JOIN "._BdStr(DBM).TB_CL_PLCY." ON applfm_plcy = id_clplcy  WHERE ".$___Ls->ik." = %s LIMIT 1", GtSQLVlStr($___Ls->gt->i, "text"));
		
	}elseif($___Ls->_show_ls == 'ok'){ 
		 
		 
		$Ls_Whr = "FROM ".TB_APPL_FM."
				INNER JOIN ".TB_CL." ON applfm_cl = id_cl
		        ".GtSlc_QryExtra([ 't'=>'tb', 'col'=>'applfm_thm', 'als'=>'f' ])."
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
	    <td width="40%" align="left" nowrap="nowrap"><?php echo ShortTx(ctjTx($___Ls->ls->rw['applfm_nm'],'in'),150,'Pt', true); ?></td>
	    <td width="40%" align="left" nowrap="nowrap"><?php echo ctjTx($___Ls->ls->rw['formulario_sisslc_tt'],'in'); ?></td>
	    <td width="40%" align="left" nowrap="nowrap"><?php echo ctjTx($___Ls->ls->rw['applfm_plcy'],'in'); ?></td>
	    <td width="10%" align="left" nowrap="nowrap"><?php echo ctjTx($___Ls->ls->rw['applfm_thx_url'],'in'); ?></td>
	    <td width="1%" align="left" nowrap="nowrap" class="_btn"><?php echo $___Ls->_btn([ 't'=>'mod' ]); ?></td>
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
		<form method="POST" name="<?php echo $___Ls->fm->id; ?>" target="_self" id="<?php echo $___Ls->fm->id; ?>">
			<?php if(isN($___Ls->gt->bld)){ $___Ls->_bld_f_hdr(); }?>     
			<div id="<?php echo $___Ls->fm->fld->id ?>" class="<?php echo DV_GNR_FM_CMP ?>">	
				
				<?php if(isN($___Ls->gt->bld)){  	
					
					$___Ls->_dvlsfl_all([
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
								<?php echo $___Ls->tab->plcy->l ?>
							</ul>
							<div class="TabbedPanelsContentGroup">
								<div class="TabbedPanelsContent">
									<div class="col_1">
										<?php echo HTML_inp_tx('applfm_nm', TX_NM , ctjTx($___Ls->dt->rw['applfm_nm'],'in'), FMRQD); ?>	
										<?php 
											$l = __Ls(['k'=>'fm_thm', 'id'=>'applfm_thm', 'va'=>$___Ls->dt->rw['applfm_thm'] , 'ph'=>FM_LS_SLGN]); 
											echo $l->html; $CntWb .= $l->js;    
										 
											echo LsClPlcy([ 'id'=>'applfm_plcy', 'v'=>'clplcy_enc', 'va'=>$___Ls->dt->rw['clplcy_enc'] ]); 
							                $CntWb .= JQ_Ls('applfm_plcy', TX_FMSLCPLCY); ?>
							                
										<?php echo OLD_HTML_chck('applfm_thx_top', TX_URL_TOP , $___Ls->dt->rw['applfm_thx_top'], 'in'); ?>
										<?php echo HTML_inp_tx('applfm_thx_url', TX_THX_URL , ctjTx($___Ls->dt->rw['applfm_thx_url'],'in')); ?>
										<?php echo OLD_HTML_chck('applfm_s_sch', 'Activar Buscador' , $___Ls->dt->rw['applfm_s_sch'], 'in'); ?>
									</div>
									<div class="col_2">
										<?php if($___Ls->dt->tot > 0){ ?>
											<div class="fm_fld"></div>		
										<?php } ?>
									</div>
								</div>
								<div class="TabbedPanelsContent">
									<div class="col_1">
										<?php echo HTML_inp_tx('applfm_plcytt', 'Titulo' , ctjTx($___Ls->dt->rw['applfm_plcytt'],'in'), FMRQD); ?>			
										<?php echo HTML_inp_tx('applfm_plcylnk', 'Link' , ctjTx($___Ls->dt->rw['applfm_plcylnk'],'in'), FMRQD); ?>	
									</div>
									<div class="col_2">
										<?php echo HTML_textarea('applfm_plcytx', 'Texto', ctjTx($___Ls->dt->rw['applfm_plcytx'], 'in')); ?>
									</div>
								</div>
							</div>
						</div>
					</div>				  	
				<?php } ?>		
				<?php if(!isN($___Ls->gt->bld)){ $tab_act = 'ok'; }else{ $tab_act = 'pnl_stb'; } ?>
				<?php if(!isN($___Ls->gt->bld)){ $CntJV = "bld_mdl = '1';"; }else{ $CntJV = "bld_mdl = '2';";} ?>
		
				<div id="pnl_stb" class="pln_frm _anm ln_1 <?php echo $tab_act; ?>">
					<div class="fm_btns">
						<ul>
							<?php if(isN($___Ls->gt->bld)){ ?><li class="fm_bck"><?php echo TX_VLVR; ?></li><?php } ?>
							<li class="fm_row_add"><?php echo TX_ADD; ?></li>
						</ul>
					</div> 
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
						<div class="col_1 flds">
							<div id="sortable2" class="sortable1"></div>	
						</div>
						<div class="col_2">
							<div id="sort_enable" class="sort_enable"></div>
							<div id="sortable1" class="sortable1"></div> 	
						</div>
					</div>
				</div>
        
        	<?php if($___Ls->dt->tot > 0){
	        	
	    		$CntJV .= "	  	
					
					var SUMR_Dsh_Fm = {
								id_fldnew:'',
								tp_fldnew:'',
								mdltpfm:{},
								mdltpfmfld:{}
							}; 
		
					function Dom_Rbld(){

						var __clgrp_bx_are_itm = $('#bx_are_".$__Rnd." li.itm.are ');
						var __clgrp_bx_are_fm = $('#bx_fm_are_".$__Rnd."');
						
						$('.fm_bck').click(function(){ $( '.ln_1._anm' ).removeClass('ok'); $( '#pnl_stb' ).addClass('pnl_stb'); __rsz_dsh();	});
						$('.fm_fld').click(function(){ $( '.ln_1._anm' ).addClass('ok'); $( '#pnl_stb' ).removeClass('pnl_stb'); __rsz_dsh({ t:'fll' }); });
						
						$( function() { 
							$( '.sortable1' ).sortable(); 
							$( '.sortable1' ).disableSelection();
						});
						
						$('#".$___Ls->fm->id." .fm_row_add').not('.sch').off('click').click(function(){		 
							_Rqu({ 
								t:'appl_fm', 
								d:'row',
								est: 'in',
								_id_fm : '".Php_Ls_Cln($___Ls->gt->i)."',
								_cl:function(_r){ if(!isN(_r)){ if(!isN(_r)){ ClSet(_r); } } } 
							});
						});
						
						var __mdls_bx_sch_itm = $('#bx_mdl_".$__Rnd." > li.itm ');
						__mdls_bx_sch_itm.not('.sch').off('click').click(function(){
						
							var est = $(this).hasClass('on') ? 'del' : 'ok'; 		
							var _id = $(this).attr('rel');
	
							_Rqu({ 
								t:'appl_fm', 
								d:'cnt_tp',
								est: est,
								_id_fm : '".Php_Ls_Cln($___Ls->gt->i)."',
								_id : _id,
								_cl:function(_r){ if(!isN(_r)){ if(!isN(_r)){ ClSet(_r); } } } 
							});
							
						});	
						
						SUMR_Main.LsSch({ str:'#sch_sch_".$___Ls->id_rnd."', ls:__mdls_bx_sch_itm });
 
						$('.opc_del_fm').click(function(event){
							
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
									t:'appl_fm', 
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
					    
					    $('.opc_fm').click(function(event){
							
							var _id = $(this).parent().attr('data-id');		
							$('div[data-id=\"'+_id+'\"] ul.list_rq').toggleClass('ok');	
							
							$('div[data-id=\"'+_id+'\"] ul.list_rq li').click(function(event){
								
								$('div[data-id=\"'+_id+'\"] ul.list_opc2').removeClass('ok');
								
								if($(this).hasClass('list1')){
									$('div[data-id=\"'+_id+'\"] ul.list_rqs').toggleClass('ok');
									
									$('div[data-id=\"'+_id+'\"] ul.list_rqs li').click(function(event){
										var id_fld = $(this).parent().attr('rel');
									
										var id_rpd = $(this).attr('rel');
										
										_Rqu({ 
											t:'appl_fm', 
											d:'rqd',
											_id_fm : '".Php_Ls_Cln($___Ls->gt->i)."',
											id_fld : id_fld,
											id_rpd : id_rpd,
											_bs:function(){ $('.sortable1').addClass('_ld'); },
											_cm:function(){ $('.sortable1').removeClass('_ld'); },
											_cl:function(_r){ if(!isN(_r)){ if(!isN(_r)){ ClSet(_r); } } } 
										});
									});
								}else if($(this).hasClass('list2')){
									$('div[data-id=\"'+_id+'\"] ul.list_input').toggleClass('ok');
									
									$('div[data-id=\"'+_id+'\"] ul.list_input li.sve').click(function(event){
										var id_fld = $(this).parent().attr('rel');
									
										var val_inpt = $('div[data-id=\"'+_id+'\"] ul.list_input li input').val();
										
										_Rqu({ 
											t:'appl_fm', 
											d:'upd_exc',
											_id_fm : '".Php_Ls_Cln($___Ls->gt->i)."',
											_id_fld : id_fld,
											_val_inpt : val_inpt,
											_bs:function(){ $('.sortable1').addClass('_ld'); },
											_cm:function(){ $('.sortable1').removeClass('_ld'); },
											_cl:function(_r){ if(!isN(_r)){ if(!isN(_r)){ ClSet(_r); } } } 
										});
									});
								}else if($(this).hasClass('list3')){
									$('div[data-id=\"'+_id+'\"] ul.list_input_tp').toggleClass('ok');
									
									$('div[data-id=\"'+_id+'\"] ul.list_input_tp li.sve').click(function(event){
										var id_fld = $(this).parent().attr('rel');
									
										var val_inpt = $('div[data-id=\"'+_id+'\"] ul.list_input_tp li input').val();
										
										_Rqu({ 
											t:'appl_fm', 
											d:'upd_tp',
											_id_fm : '".Php_Ls_Cln($___Ls->gt->i)."',
											_id_fld : id_fld,
											_val_inpt : val_inpt,
											_bs:function(){ $('.sortable1').addClass('_ld'); },
											_cm:function(){ $('.sortable1').removeClass('_ld'); },
											_cl:function(_r){ if(!isN(_r)){ if(!isN(_r)){ ClSet(_r); } } } 
										});
									});	
								}else if($(this).hasClass('list4')){
									$('div[data-id=\"'+_id+'\"] ul.list_input_val').toggleClass('ok');
									
									$('div[data-id=\"'+_id+'\"] ul.list_input_val li.sve').click(function(event){
										var id_fld = $(this).parent().attr('rel');
									
										var val_inpt = $('div[data-id=\"'+_id+'\"] ul.list_input_val li input').val();
										
										_Rqu({ 
											t:'appl_fm', 
											d:'upd_val',
											_id_fm : '".Php_Ls_Cln($___Ls->gt->i)."',
											_id_fld : id_fld,
											_val_inpt : val_inpt,
											_bs:function(){ $('.sortable1').addClass('_ld'); },
											_cm:function(){ $('.sortable1').removeClass('_ld'); },
											_cl:function(_r){ if(!isN(_r)){ if(!isN(_r)){ ClSet(_r); } } } 
										});
									});	
								}
							});
														 
					    });
					    
					    $('.opc_edt_fm').click(function(event){
							var rel = $(this).attr('rel');	
							$(this).parent().addClass('___edt');

							$('#inpt_'+rel).attr('type','text').focus();

							$('#inpt_'+rel).blur(function(){
								
								var _id = $(this).attr('rel'); 
								var _val = $(this).val();
								var _tp = $(this).attr('data-tp'); 
								
								swal({									  
									  title: '".TX_ETSGR."',              
									  text: '".TXBT_GRDR."!',  
									  type: 'warning',                        
									  showCancelButton: true,                 
									  confirmButtonClass: 'btn-danger',       
									  confirmButtonText: '".TX_YSV."',      
									  confirmButtonColor: '#E1544A',          
									  cancelButtonText: '".TX_CNCLR."',           
									  closeOnConfirm: true                   
									},										  
								function(){                               					
									_Rqu({ 
										t:'appl_fm', 
										d:'row_fld',
										est: 'edt',
										data: _val,
										tp: _tp,
										_id_fm : '".Php_Ls_Cln($___Ls->gt->i)."',
										id_row: _id,
										_bs:function(){ $('.sortable1').addClass('_ld'); },
										_cm:function(){ $('.sortable1').removeClass('_ld'); },
										_cl:function(_r){ if(!isN(_r)){ if(!isN(_r)){ ClSet(_r); } } } 
									}); 
								});	
								
							});
	 
					    });
					}

					function Cnt_Cols(p){
						
						var _cnt = p; 
						
						if(_cnt > 0 && _cnt <= 4){
							if(_cnt == 4){
								$('#'+_cnt).removeClass('cols_1 cols_2 cols_3 full_cols').addClass('cols_4 full_cols');	
							}else{
								$('#'+_cnt).removeClass('cols_1 cols_2 cols_3 full_cols').addClass('cols_'+_cnt);										
							}
						}else{
							$('#'+_cnt).removeClass('cols_1 cols_2 cols_3 cols_4 full_cols').addClass('cols_1');	
						}		
					}	

					function __rsz_dsh(p){
                        if(!isN(p) && !isN(p.t) && p.t == 'fll'){
                        	$.colorbox.resize({ width:'90%', height:'90%' });
                        }else{    
                            $.colorbox.resize({ width:".$___Ls->edit->w.", height:".$___Ls->edit->h." });
                    	} 
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
								
									if(v.fld.tot == 1){ var est='cols_1'; }else if(v.fld.tot == 2){ var est='cols_2'; }else if(v.fld.tot == 3){ var est='cols_3'; }else if(v.fld.tot == 4){ var est='cols_4 full_cols'; }else{ var est='cols_1'; }
									$(_id_s).append('<div id=\"'+v.enc+'\" class=\"'+est+' alpha cap ui-sortable\"></div>');
	
									$('#'+v.enc).append('<button class=\"delete_row\" type=\"button\"></button>');
									if(v.fld.tot > 0){
										
										$.each(v.fld.ls, function(_k, _v) {
											
											if(_v.rqd == "._CId('ID_LSRQ_VL_RQ')."){ var itm = '<div class=\'itm_rq itm_rd_ok\'></div>'; }
											else if(_v.rqd == "._CId('ID_LSRQ_VL_RQ_EM')."){ var itm = '<div class=\'itm_rq itm_rd_em\'></div>'; }
											else if(_v.rqd == "._CId('ID_LSRQ_VL_RQ_NM')."){ var itm = '<div class=\'itm_rq itm_rd_nm\'></div>'; }
											else if(_v.rqd == "._CId('ID_LSRQ_VL_RQ_EML')."){ var itm = '<div class=\'itm_rq itm_rd_eml\'></div>'; }
											else if(_v.rqd == "._CId('ID_LSRQ_VL_RQ_NMR')."){ var itm = '<div class=\'itm_rq itm_rd_nmr\'></div>'; }
											else if(_v.rqd == "._CId('ID_LSRQ_VL_RQ_NA')."){ var itm = '<div class=\'itm_rq itm_rd_na\'></div>'; }
											else{ var itm = ''; }

											if(!isN(_v.tt_edt)){ 
												var __edt = '<div rel=\"'+_v.enc_fldrow+'\" class=\'opc_s opc_edt_fm\'></div>'; 
												var cls = '__tt'; 
												var inp_hd = '<input data-tp=\"'+_v.tp+'\" id=\"inpt_'+_v.enc_fldrow+'\" rel=\"'+_v.enc_fldrow+'\" type=\"hidden\" value=\"'+_v.tt_d+'\">'; 
												var rq = '';
												var list_rqs = '';
											}else{ 
												var __edt = ''; 
												var cls = ''; 
												var inp_hd = '';
												var rq = '<div id=\"'+_v.enc_fldrow+'\" class=\'opc_s opc_fm\'></div>';
												var list_rqs = '<ul rel=\"'+_v.enc_fldrow+'\" class=\"list_opc2 list_rqs\"><li rel=\""._CId('ID_LSRQ_VL_RQ')."\" class=\"list_1\"></li><li rel=\""._CId('ID_LSRQ_VL_RQ_EM')."\" class=\"list_2\"></li><li rel=\""._CId('ID_LSRQ_VL_RQ_NM')."\" class=\"list_3\"></li><li rel=\""._CId('ID_LSRQ_VL_RQ_EML')."\" class=\"list_4\"></li><li rel=\""._CId('ID_LSRQ_VL_RQ_NMR')."\" class=\"list_5\"></li><li rel=\""._CId('ID_LSRQ_VL_RQ_NA')."\" class=\"list_6\"></li></ul><ul rel=\"'+_v.enc_fldrow+'\" class=\"list_opc2 list_input_tp\"><li class=\"list_1\"><input type=\"text\" placeholder=\"Tipo\" value=\"'+_v.flt_tp+'\"></li><li class=\"sve\"></li></ul><ul rel=\"'+_v.enc_fldrow+'\" class=\"list_opc2 list_input\"><li class=\"list_1\"><input type=\"text\" placeholder=\"Excepciones\" value=\"'+_v.flt_exc+'\"></li><li class=\"sve\"></li></ul><ul rel=\"'+_v.enc_fldrow+'\" class=\"list_opc2 list_input_val\"><li class=\"list_1\"><input type=\"text\" placeholder=\"Valor Adicional\" value=\"'+_v.val_adc+'\"></li><li class=\"sve\"></li></ul><ul rel=\"'+_v.enc_fldrow+'\" class=\"list_rq\"><li class=\"list1\"></li><li class=\"list2\"></li><li class=\"list3\"></li><li class=\"list4\"></li></ul>';
												
											}
	
											if(!isN(_v.tt)){ var __tt = _v.tt; }else{ var __tt = '-'; }
											
											$('#'+v.enc).append('<div data_tp=\"fld_y\" data-nm=\"'+_v.tt+'\" data-id=\"'+_v.enc+'\" class=\"'+cls+' fld_y tile\">'+inp_hd+' '+rq+'
	<div id=\"'+_v.enc_fldrow+'\" class=\'opc_s opc_del_fm\'></div><div class=\"title\">'+__tt+'</div>'+itm+''+__edt+''+list_rqs+'</div>');		
										});	
									}				
								});
							}else{
								var _id_s = '#sort_enable';
								$(_id_s).html(''); 
								
								$.each(SUMR_Dsh_Fm.mdltpfm['ls'], function(k, v) {
								
									if(v.fld.tot == 1){ var est='cols_1'; }else if(v.fld.tot == 2){ var est='cols_2'; }else if(v.fld.tot == 3){ var est='cols_3'; }else if(v.fld.tot == 4){ var est='cols_4 full_cols'; }else{ var est='cols_1'; }
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
								_Rqu({ 
									t:'appl_fm', 
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
									t:'appl_fm', 
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
								
								if(idsInOrder.length > 0){
									
									Cnt_Cols(_cnt);
									var idsInOrder = $('#'+_id).sortable('toArray',{ attribute: 'data-id' });
								
									_Rqu({ 
										t:'appl_fm', 
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
									
									_Rqu({ 
										t:'appl_fm', 
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
							}

							ClGrpAre_Html();
							
							if(SUMR_Dsh_Fm.mdltpfm['tot'] == 0){
								$('#sortable1').append('<div class=\"empty\"><h3>No hay columnas</h3><p>".TX_NW_ROW."</p></div>');	
							}	
						}
					}
				";

				$CntJV .= " 	
					_Rqu({ 
						t:'appl_fm', 
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
.txt._anm{height:650px;overflow:hidden}
.txt._anm.ok{height:0}
.txt .col_2 .fm_fld{width:150px;height:150px;background-color:#eaeaea;border-radius:50%;-moz-border-radius:50%;-webkit-border-radius:50%;margin:30px auto;cursor:pointer;line-height:1000;background-size:50% auto;background-repeat:no-repeat;background-position:center;background-image:url(<?php echo DMN_IMG_ESTR_SVG ?>mdl_cod_fm.svg)}
.txt .col_2 .fm_fld:hover{background-color:#dcdcdc}
.pnl_stb{height:0;overflow:hidden}
.pln_frm .fm_btns{width:95%;position:relative;height:80px;margin:0 auto}
.pln_frm .fm_btns ul li{display:inline-block;width:50px;height:50px;font-size:0;cursor:pointer;position:absolute}
.pln_frm .fm_btns ul li.fm_bck{left:0;background-image:url(<?php echo DMN_IMG_ESTR_SVG ?>ec_img_edt.svg)}
.pln_frm .fm_btns ul li.fm_row_add{right:0;background-image:url(<?php echo DMN_IMG_ESTR_SVG ?>add.svg)}
.pln_frm .tile{background:#f5f8fa;color:#a2a2a2;display:block;float:left;border:1px solid #d2d2d2;border-radius:5px;-moz-border-radius:5px;-webkit-border-radius:5px;font-size:13px;position:relative;cursor:move;pointer-events:auto}
.pln_frm .flds.col_1 .sortable1 .beta .tile{margin:6px!important;padding:5px 15px;overflow:hidden;white-space:nowrap;text-overflow:ellipsis}
.pln_frm .col_2 .sortable1 .alpha,.pln_frm .col_2 .sort_enable .cols_1,.pln_frm .col_2 .sort_enable .cols_2,.pln_frm .col_2 .sort_enable .cols_3,.pln_frm .col_2 .sort_enable .cols_4{margin:7px 15px;width:94%;background-color:#f5f5f5;height:50px;border:1px dashed #c3c3c3;cursor:grab;position:relative;display:flex}
.delete_row{width:25px;display:none;font-size:0;cursor:pointer;background-image:url(<?php echo DMN_IMG_ESTR_SVG ?>delete.svg);top:0;position:absolute;background-color:#e24d5c;background-repeat:no-repeat;background-position:center;height:100%;left:-25px;border:1px dotted #c3c3c3;top:-1px;height:calc(100% + 2px);border-right:0}
.alpha:hover .delete_row{display:block}
.pln_frm .col_2 .sortable1 .alpha .tile{padding:7px 15px;margin:8px auto;white-space:nowrap}
.pln_frm .col_2 .sortable1 .alpha.cols_1 .tile{width:95%}
.pln_frm .col_2 .sortable1 .alpha.cols_2 .tile{width:45%}
.pln_frm .col_2 .sortable1 .alpha.cols_3 .tile{width:28%}
.pln_frm .col_2 .sortable1 .alpha.cols_4 .tile{width:20%}
.pln_frm .col_2 .sortable1{position:relative}

.pln_frm .col_2 .sortable1 .alpha .fld_y.tile .opc_s{width:25px;height:100%;display:none;position:absolute;	top:0;cursor:pointer;background-repeat:no-repeat;background-position:center;border-radius:0 4px 4px 0;-moz-border-radius:0 4px 4px 0;-webkit-border-radius:0 4px 4px 0}
.pln_frm .col_2 .sortable1 .alpha .fld_y.tile .opc_del_fm{background-image:url(<?php echo DMN_IMG_ESTR_SVG ?>delete.svg);right:0;background-color:#e04f5f;}
.pln_frm .col_2 .sortable1 .alpha .fld_y.tile .opc_edt_fm{background-image:url(<?php echo DMN_IMG_ESTR_SVG ?>editar.svg);right:25px;background-color:#f1543f;}

/* Corregir svg */
.pln_frm .col_2 .sortable1 .alpha .fld_y.tile .opc_fm{ background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>menu_point.svg);right: 25px;background-color: #26bfa6;background-size: 70% auto;border-radius: 0px;}
.pln_frm .col_2 .sortable1 .alpha .fld_y.tile:hover .opc_s{display:block}
.pln_frm .col_2 .sortable1 .alpha::before{content:'';background-color:#e04f5f;width:30px;height:65px;display:none;position:absolute;left:-31px;background-repeat:no-repeat;background-position:center;background-image:url(<?php echo DMN_IMG_ESTR_SVG ?>delete.svg);pointer-events:auto}
.pln_frm .flds.col_1 ._ld,.pln_frm .col_2 ._ld{cursor:none}
.pln_frm .flds.col_1 ._ld .tile,.pln_frm .col_2 ._ld .tile{cursor:none;opacity:.4}
.pln_frm .col_2 .sortable1 .empty{background-position:center;background-repeat:no-repeat;background-size:100% auto;background-image:url(<?php echo DMN_IMG_ESTR_SVG ?>empty-inbox.svg);width:200px;height:200px;display:block;vertical-align:top;margin:90px auto}
.pln_frm .col_2 .sortable1 .empty h3{padding-top:175px;text-align:center}
.pln_frm .col_2 .sortable1 .empty p{text-align:center;width:100%;display:block;white-space:normal;color:#ccc;font-family:Roboto}
.opc_dcd{height:100%;position:absolute;font-size:0;top:0;left:-31px;margin:0;padding:0}
.opc_dcd li{background-repeat:no-repeat;background-position:center;width:30px;display:block;height:63px;cursor:pointer;background-color:#e04f5f;background-image:url(<?php echo DMN_IMG_ESTR_SVG ?>delete.svg)}
p.delete_row{background-image:url(<?php echo DMN_IMG_ESTR_SVG ?>delete.svg);width:25px;height:63px;display:block;top:0;left:0;font-size:0;cursor:pointer;background-color:#e24d5c;background-repeat:no-repeat;background-position:center}
.sort_enable .cols_1 div{width:100%;display:inline-block}
.sort_enable .cols_2 div{width:49%;display:inline-block}
.sort_enable .cols_3 div{width:33%;display:inline-block}
.sort_enable .cols_4 div{width:23%;display:inline-block}
.sort_enable .cols_1 .fld_y,.sort_enable .cols_2 .fld_y,.sort_enable .cols_3 .fld_y,.sort_enable .cols_4 .fld_y{background:#f5f8fa;color:#a2a2a2;display:block;float:left;border:1px solid #d2d2d2;border-radius:5px;-moz-border-radius:5px;-webkit-border-radius:5px;font-size:13px;position:relative;cursor:move;pointer-events:auto;display:inline-block;padding:14px;margin:8px 15px}

.VTabbedPanels.mny.formulario_data_tb > ul.TabbedPanelsTabGroup,.VTabbedPanels.mny.formulario_data_tb > div.TabbedPanelsContentGroup .VTabbedPanels.mny ul.TabbedPanelsTabGroup{width:7%!important}
.VTabbedPanels.mny.formulario_data_tb > ul li.TabbedPanelsTab{width:35px;height:35px;background-size:22px;background-repeat:no-repeat;background-position:center}
.VTabbedPanels.mny.formulario_data_tb .TabbedPanelsTabGroup .TabbedPanelsTab._bsc{background-image:url('<?php echo DMN_IMG_ESTR_SVG ?>cnt_dtl.svg')}
.VTabbedPanels.mny.formulario_data_tb .TabbedPanelsTabGroup .TabbedPanelsTabSelected._bsc{background-image:url('<?php echo DMN_IMG_ESTR_SVG ?>cnt_dtl_w.svg')}
.VTabbedPanels.mny.formulario_data_tb .TabbedPanelsTabGroup .TabbedPanelsTab._plcy{background-image:url('<?php echo DMN_IMG_ESTR_SVG ?>cnt_sec.svg')}
.VTabbedPanels.mny.formulario_data_tb .TabbedPanelsTabGroup .TabbedPanelsTabSelected._plcy{background-image:url('<?php echo DMN_IMG_ESTR_SVG ?>cnt_sec_w.svg')}

.__tt.fld_y.tile{color:#282a2b;font-weight:700}
.__tt.fld_y.tile.___edt{padding:0!important}
.___edt input[type="text"]{background-color:#fff;height:30px;padding:0 15px;z-index:9;position:relative;width:100%}
.list_rq{display:none;background-color:#d4c6c6;height:26px;position:absolute;top:-32px;z-index:9;left:0;padding:0}
.list_rq li{display:inline-flex;width:23px;background-position:center;background-repeat:no-repeat;background-size:70% auto;border-radius:4px;margin:3px;cursor:pointer}
.title{margin-left:10px;width:100%;overflow:hidden;text-overflow:ellipsis}
.list_rq.ok{display:flex}


.list_rqs{display:none;background-color:#d4c6c6;height:26px;position:absolute;top:-65px;z-index:9;left:0;padding:0}
.list_rqs li{display:inline-flex;width:23px;background-position:center;background-repeat:no-repeat;background-size:70% auto;border-radius:4px;margin:3px;cursor:pointer}
.list_rqs.ok{display:flex}

.list_rqs .list_1{background-color:#e04f5f;background-image:url(<?php echo DMN_IMG_ESTR_SVG ?>exclamation.svg)}
.list_rqs .list_2{background-color:#e04f5f;background-image:url(<?php echo DMN_IMG_ESTR_SVG ?>arroba.svg)}
.list_rqs .list_3{background-color:#e04f5f;background-image:url(<?php echo DMN_IMG_ESTR_SVG ?>number.svg)}
.list_rqs .list_4{background-color:#2dab2b;background-image:url(<?php echo DMN_IMG_ESTR_SVG ?>arroba.svg)}
.list_rqs .list_5{background-color:#2dab2b;background-image:url(<?php echo DMN_IMG_ESTR_SVG ?>number.svg)}
.list_rqs .list_6{background-color:#2dab2b;background-image:url(<?php echo DMN_IMG_ESTR_SVG ?>error.svg)}

.list_rq .list1{background-color:#f5f8fa;background-image:url(<?php echo DMN_IMG_ESTR_SVG ?>check_rq.svg)}
.list_rq .list2{background-color:#f5f8fa;background-image:url(<?php echo DMN_IMG_ESTR_SVG ?>cnt_sndi_no.svg)}
.list_rq .list3{background-color:#f5f8fa;background-image:url(<?php echo DMN_IMG_ESTR_SVG ?>filtro.svg)}
.list_rq .list4{background-color:#f5f8fa;background-image:url(<?php echo DMN_IMG_ESTR_SVG ?>addi.svg)}

.list_input{display:none;background-color:#d4c6c6;height:26px;position:absolute;top:-65px;z-index:9;left:0;padding:0}
.list_input li{display:inline-flex;width:80px;background-position:center;background-repeat:no-repeat;background-size:70% auto;border-radius:4px;margin:3px;cursor:pointer}
.list_input.ok{display:flex}

.list_input_tp{display:none;background-color:#d4c6c6;height:26px;position:absolute;top:-65px;z-index:9;left:0;padding:0}
.list_input_tp li{display:inline-flex;width:80px;background-position:center;background-repeat:no-repeat;background-size:70% auto;border-radius:4px;margin:3px;cursor:pointer}
.list_input_tp.ok{display:flex}

.list_input_val{display:none;background-color:#d4c6c6;height:26px;position:absolute;top:-65px;z-index:9;left:0;padding:0}
.list_input_val li{display:inline-flex;width:80px;background-position:center;background-repeat:no-repeat;background-size:70% auto;border-radius:4px;margin:3px;cursor:pointer}
.list_input_val.ok{display:flex}

ul.list_rq.ok:before{content:"";width:0;position:absolute;height:0;top:24px;left:60px;border-top:5px solid #d4c6c6;border-left:10px solid #44386900;border-right:10px solid #00ffd000}
.itm_rq{width:20px;height:20px;display:inline-block;vertical-align:top;position:absolute;top:-5px;left:-5px;background-position:center;background-repeat:no-repeat;background-size:70% auto;border-radius:12px}
.itm_rd_ok{background-image:url(<?php echo DMN_IMG_ESTR_SVG ?>exclamation.svg);background-color:#e04f5f}
.itm_rd_em{background-image:url(<?php echo DMN_IMG_ESTR_SVG ?>arroba.svg);background-color:#e04f5f}
.itm_rd_nm{background-image:url(<?php echo DMN_IMG_ESTR_SVG ?>number.svg);background-color:#e04f5f}
.itm_rd_eml{background-image:url(<?php echo DMN_IMG_ESTR_SVG ?>arroba.svg);background-color:#2dab2b}
.itm_rd_nmr{background-image:url(<?php echo DMN_IMG_ESTR_SVG ?>number.svg);background-color:#2dab2b}
.sve{ width: 25px !important; background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>save.svg); }
</style>
<?php } ?>
<?php } ?>