<?php
if(class_exists('CRM_Cnx')){

	$___Ls->cnx->cl = 'ok';
	$___Ls->sch->f = 'mdlgen_tt, mdlgen_pml';
	$___Ls->new->w = 650;
	$___Ls->new->h = 600;
	$___Ls->new->scrl = 'no';
	$___Ls->edit->big = 'ok';
	$___Ls->img->dir = DMN_FLE_MDL_GEN;
	
	$___Ls->_strt();
	
	$__fl .= " AND mdlstp_tp = '".$___Ls->gt->tsb."' ";
	

	if(!isN($___Ls->gt->i)){	
		
		$___Ls->qrys = sprintf("SELECT * FROM ".TB_MDL_GEN." WHERE ".$___Ls->ik." = %s LIMIT 1", GtSQLVlStr($___Ls->gt->i, "text"));
		
	}elseif($___Ls->_show_ls == 'ok'){ 
		
		if($___Ls->gt->tsb == 'act'){ 
			$__flt = " INNER JOIN ".TB_MDL_GEN_TP." ON id_mdlgen = mdlgentp_mdlgen"; 
			$__fl = " AND mdlgentp_mdlstp = (SELECT id_mdlstp FROM "._BdStr(DBM).TB_MDL_S_TP." WHERE mdlstp_tp = '".$__t3."' )"; 
		}

		$Ls_Whr = "	FROM ".TB_MDL_GEN." 
						 INNER JOIN "._BdStr(DBM).TB_MDL_S_TP." ON mdlgen_tp = id_mdlstp 
						 $__flt
					WHERE id_mdlgen != '' $__fl ".$___Ls->sch->cod." 
					ORDER BY ".$___Ls->ino." DESC";
					
		$___Ls->qrys = "SELECT id_mdlgen, mdlgen_enc, mdlgen_tt, mdlgen_pml, mdlgen_s3, (SELECT COUNT(*) $Ls_Whr) AS ".QRY_RGTOT." $Ls_Whr"; 

	} 
	
	$___Ls->_bld(); 
	
?>
<?php if($___Ls->ls->chk=='ok'){ ?>

<?php $___Ls->_bld_l_hdr(); ?>
<?php if(($___Ls->qry->tot > 0)){ ?>

<table width="100%" border="0" cellpadding="0" cellspacing="0" class="Ls_Rg">
	<thead>
      	<tr>
	        <th width="1%" <?php echo NWRP ?>><?php echo TX_FM_No ?></th>
			<th width="98%" <?php echo NWRP ?>><?php echo TX_NM ?></th>
			<?php if(ChckSESS_superadm()){ ?>
			<th width="1%" <?php echo NWRP ?>><?php echo TX_FA ?></th>
			<?php } ?>
	        <th width="1%" <?php echo NWRP ?>>&nbsp;</th>
	        <th width="1%" <?php echo NWRP ?>>&nbsp;</th>
	        <th width="1%" <?php echo NWRP ?>>&nbsp;</th>
	        <th width="1%" <?php echo NWRP ?>>&nbsp;</th>
      	</tr>
	</thead>
	<tbody>
	  	<?php do { ?>
	  	<tr>
	        <td width="1%" <?php echo NWRP ?>><?php echo Spn($___Ls->ls->rw[$___Ls->ino]); ?></td>
			<td width="98%" align="left" nowrap="nowrap"><?php echo ctjTx($___Ls->ls->rw['mdlgen_tt'],'in'); ?></td>
			
			<?php if(ChckSESS_superadm()){ ?>
			<td width="1%" align="left" nowrap="nowrap">
				<?php if(mBln($___Ls->ls->rw['mdlgen_s3']) != 'ok'){ ?>
				<div class="_awss3"><div style="display: inline-block;" class="_tt_prd"></div><div class="icn"></div></div>
				<?php } ?>
			</td>
			<?php } ?>

	        <td width="1%" align="left" nowrap="nowrap" class="_btn"><?php echo HTML_Ls_Btn(['t'=>'pgs', 'l'=>Fl_Rnd(FL_FM_GN.__t('mdl_gen_cod_md',true).Fl_i($___Ls->ls->rw['id_mdlgen']).$___Ls->ls->vrall), 'cls'=>'_md']); ?></td>
	        <td width="1%" align="left" nowrap="nowrap" class="_btn"><?php echo HTML_Ls_Btn(['t'=>'rss', 'l'=>Fl_Rnd(FL_FM_GN.__t('mdl_gen_cod_md',true).Fl_i($___Ls->ls->rw['id_mdlgen']).$___Ls->ls->vrall), 'cls'=>'_md']); ?></td>
	        <td width="1%" align="left" nowrap="nowrap" class="_btn"><?php echo HTML_Ls_Btn(['t'=>'onl', 'l'=>DMN_HTTP.DMN.PrmLnk('bld', _Cns('LNK_') ).PrmLnk('bld', LNK_G).PrmLnk('bld', $___Ls->ls->rw['mdlgen_pml']), 'trg'=>'_blank']); ?></td>
	        <td width="1%" align="left" nowrap="nowrap" class="_btn"><?php echo $___Ls->_btn([ 't'=>'mod' ]); ?></td>
      	</tr>
	  	<?php } while ($___Ls->ls->rw = $___Ls->sql->fetch_assoc()); ?>
	</tbody>  
	<?php $CntWb .= '$("._dtl").colorbox({ width:"1000px", height:"600px", overlayClose:false, escKey:false}); '; ?>
	<?php $CntWb .= '$("._md").colorbox({ width:"450px", height:"300px", trapFocus:false, overlayClose:false, escKey:false}); '; ?>  
</table>	
<?php $___Ls->_bld_l_pgs(); ?>

<style>
	
	._prdopn{ color: var(--main-bg-color); padding:6px 8px; display:block; font-size:11px; border-radius:5px; position:relative; overflow:visible; text-overflow: ellipsis; text-transform: lowercase; position: relative; text-align: center; }
	._prdopn .icn{ display:inline-block; border-radius:200px; -moz-border-radius:200px; -webkit-border-radius:200px; border: none; width: 20px; height: 20px; right: 4px; top:4px; cursor: pointer; background-image:url('<?php echo DMN_IMG_ESTR_SVG ?>mdl_prd_live.svg'); background-repeat: no-repeat; background-position: center center; background-size: 70% auto; animation: _blnk 0.8s cubic-bezier(.5, 0, 1, 1) infinite alternate; background-color:var(--second-bg-color); margin-bottom: -6px; margin-left: 4px; }
	
	._awss3{ padding:6px 8px; display:block; font-size:11px; border-radius:5px; position:relative; overflow:visible; text-overflow: ellipsis; text-transform: lowercase; position: relative; text-align: center; }
	._awss3 .icn{ display:inline-block; border-radius:200px; -moz-border-radius:200px; -webkit-border-radius:200px; border: none; width: 20px; height: 20px; right: 4px; top:4px; cursor: pointer; background-image:url('<?php echo DMN_IMG_ESTR_SVG ?>upd_s3.svg'); background-repeat: no-repeat; background-position: center center; background-size: 90% auto; animation: _blnk 0.8s cubic-bezier(.5, 0, 1, 1) infinite alternate; margin-bottom: -6px; margin-left: 4px; }
	

	.cnt_wrap .Ls_Rg .no_are{animation: _blnk 0.8s cubic-bezier(.5, 0, 1, 1) infinite alternate;background-color: #c78383;color: white; }

</style>


<?php } ?>
<?php $___Ls->_h_ls_nr(); ?>	
<?php } ?>

<?php if($___Ls->fm->chk=='ok'){ ?>
<div class="FmTb">
  <div id="<?php echo $___Ls->fm->bx->id ?>" class="<?php echo DV_GNR_FM_BX ?>" >
    <form method="POST" name="<?php echo $___Ls->fm->id; ?>" target="_self" id="<?php echo $___Ls->fm->id; ?>" >
      <?php $___Ls->_bld_f_hdr(); ?>

        <div id="<?php echo $___Ls->fm->fld->id ?>" class="<?php echo DV_GNR_FM_CMP ?>">
	        
	        <?php $__dt_img = _ImVrs([ 'img'=>ctjTx($___Ls->dt->rw['mdlgen_img'],'in'), 'f'=>DMN_FLE_MDL_GEN ]); ?>
	        
    			<div class="mdl_dsh_imgbn imgbn">
				<div class="_img" style="background-image:url(<?php echo $__dt_img->bn_800; ?>);"></div>
				<div class="_nm"><?php echo h1(ctjTx($___Ls->dt->rw['mdl_nm'],'in')); ?></div>
					
				<?php $__act_tabs = __LsDt([ 'k'=>'mdl_gen_tabs' , 'cl'=>$__dt_cl->id, 'mdl_s_tp'=>$___Ls->gt->tsb ]); ?>
				
				<?php echo $___Ls->gt->tsb; ?>

				<div class="_opt"> 
					<ul>
						<?php foreach($__act_tabs->ls->mdl_gen_tabs as $_tab__k=>$_tab_v){ ?>
							<?php if($_tab_v->rel->vl == 'mdl_mdl'){ $_icn=$___Ls->mdlstp_m->img->big; }else{ $_icn=$_tab_v->img_v->big; } ?>
							<li>
								<button data-t="<?php echo $_tab_v->tp_rel->vl ?>" data-r="<?php echo $_tab_v->rel->vl ?>" title="<?php echo _Cns($_tab_v->plch->vl) ?>" class="_anm" style="background-image:url(<?php echo $_icn; ?>)">
									
								</button>
							</li>
						<?php } ?>
						
						<?php if($___Ls->gt->tsb == 'act' && $___Ls->gt->tsb_m == 'prg'){ ?>
							<li>
								<button data-t="ls" data-r="mdlgen_grd" title="Grados" class="_anm" style="background-image:url(<?php echo DMN_IMG_ESTR_SVG ?>grado.svg)"></button>
							</li>
						<?php } ?>
							
					</ul>
				</div>
				<?php 

		            $CntWb .= "
		            
		            		$('.mdl_dsh_imgbn ._opt button').click(function(e) {

								e.preventDefault();
	
								if(e.target != this){
									
							       e.stopPropagation();
								   return;
								   
								}else{
									
									var _data_trel = $(this).attr('data-t');
									var _data_rel = $(this).attr('data-r');
									
									if(_data_trel == 'ls'){ var _f='".FL_LS_GN."'; }else{ var _f='".FL_DT_GN."'; }
									
									_ldCnt({ 
										u:_f+'?_t='+_data_rel+'&__i=".$___Ls->dt->rw['mdlgen_enc'].$___Ls->ls->vrall."', 
										pop:'ok',
										pnl:{
											e:'ok',
											tp:'h',
											s:'l',
										},
										_cm:function(){		
											
										}
									});
									
								}
								 
							});
							
		             ";
		            
	            ?>
    			</div>
			
			<?php
	        
			    $__Cl = new CRM_Cl();
				$__Rnd = Gn_Rnd(20);
				
				$CntJV .= " 
				
				var SUMR_Mdl_Gen = {
					
					mdl : $('#bx_mdl_".$__Rnd."'),
					fm : $('#bx_fm_".$__Rnd."'),
					
					mdlgenmdl: {},
					mdlgenfm: {}
				}; 
								
				function MdlGen_Dom_Rbld(){
					
					var __mdlgen_bx_mdl_itm = $('#bx_mdl_".$__Rnd." > li.itm ');
					var __mdlgen_bx_fm_itm = $('#bx_fm_".$__Rnd." > li.itm.mdl ');
					var __mdlgen_bx_mdl_fm = $('#bx_fm_mdl_".$__Rnd."');
					var __mdlgen_bx_fm_fm = $('#bx_fm_fm_".$__Rnd."');
					var __mdlgen_bx_new = $('.mdlgen_dsh .sch button._new');
					var __mdlgen_bx_new_bck = $('.mdlgen_dsh h2 button');
					var __mdlgen_bx_new_sve = $('.mdlgen_dsh ._scrl ._new_fm button');
			
					
					
					__mdlgen_bx_mdl_itm.not('.sch, .nosnd').off('click').click(function(){
						
						var est = $(this).hasClass('on') ? 'del' : 'in'; 	
						var _id = $(this).attr('rel');
						
						_Rqu({ 
							t:'mdl_gen', 
							t2:'".$___Ls->gt->tsb."',
							d:'mdl_r',
							est: est,
							_id_mdl : _id,
							_id_mdlgen : '".Php_Ls_Cln($___Ls->gt->i)."',
							_bs:function(){ SUMR_Mdl_Gen.mdl.addClass('_ld'); },
							_cm:function(){ SUMR_Mdl_Gen.mdl.removeClass('_ld'); },
							_cl:function(_r){
								if(!isN(_r)){
									if(!isN(_r.cl)){
										MdlGenSet(_r.cl);			
									}
								}
							} 
						});
						
					});

					
					__mdlgen_bx_new.off('click').click(function(e){
						
						e.preventDefault();
						var _tp = $(this).attr('new-tp');
						
						if(e.target != this){ 
					    	e.stopPropagation(); return false;
						}else{
							MdlGenFmBld({ t:_tp });
							$('.mdlgen_dsh').addClass('_new _new_'+_tp);
						}
				
					});
					
					
					__mdlgen_bx_new_bck.off('click').click(function(e){
						e.preventDefault();
						var _tp = $(this).attr('new-tp');
						
						if(e.target != this){
					    	e.stopPropagation(); return;
						}else{
							$('.mdlgen_dsh').removeClass('_new _new_'+_tp);
						}
					});	
					
					
					__mdlgen_bx_new_sve.off('click').click(function(e){
						
						e.preventDefault();
						var _tp = $(this).attr('new-tp');
						
						if(e.target != this){
					    	e.stopPropagation(); return;
						}else{
			
							var __data_snd = { 
									t:'mdl_gen', 
									d:'new_'+_tp, 
									est:'in', 
									_id_mdlgen : '".Php_Ls_Cln($___Ls->gt->i)."',
									_bs:function(){ _Rqu_Msg({ t:'prc' }); },
									_w:function(){ _Rqu_Msg({ t:'w' }); },
									_cl:function(_r){
										if(!isN(_r)){
											if(!isN(_r.e) && _r.e == 'ok'){
												MdlGenSet(_r.cl);	
												$('.mdlgen_dsh').removeClass('_new _new_'+_tp);
												_Rqu_Msg({ t:'inok' });
												MdlGenFmBld({ t:_tp });		
											}else{	
												_Rqu_Msg({ t:'w' });		
											}
										}
									} 
								};
							
							
							$('#bx_fm_'+_tp+'_{$__Rnd} :input').each(function(e){	
								id = this.id;
								__data_snd[ this.id ] = this.value ;
							});
							
							swal({									  
								  title: '".TX_ETSGR."',              
								  text: '".TX_SWAL_SVE."!',                        
								  showCancelButton: true,                      
								  confirmButtonText: '".TX_SWAL_YES."',      
								  confirmButtonColor: '".BTN_OK_CLR."',          
								  cancelButtonText: '".TX_SWAL_CNCL."',           
								  closeOnConfirm: false                   
							},										  
							function(){                               
								_Rqu( __data_snd );
							});
			
							
						}
					});
					
					SUMR_Main.LsSch({ str:'#mdl_sch_".$__Rnd."', ls:__mdlgen_bx_mdl_itm });
					
				}
				
				function MdlGenMdl_Html(){
					SUMR_Mdl_Gen.mdl.html('');
					SUMR_Mdl_Gen.mdl.append('<li class=\"sch\">".HTML_inp_tx('mdl_sch_'.$__Rnd, TX_SEARCH, '')."<button class=\"_new _anm\" new-tp=\"cl\"></button></li>');
					if(!isN( SUMR_Mdl_Gen.mdlgenmdl['ls'] )){
					
						$.each(SUMR_Mdl_Gen.mdlgenmdl['ls'], function(k, v) { 
							
							if(!isN(v.tot) && !isN(v.tot.gen) && v.tot.gen > 0){ var _cls = 'on'; }else{ var _cls = 'off'; }
							
							if(!isN(v.tp)){
								if(!isN(v)){ var img = v.tp.icn; }else{ var img = ''; }
							}else{ 
								var img = ''; 
							}
							
							if(!isN(v.clr)){ var _bclr = v.clr; }else{ var _bclr = ''; }
							
							SUMR_Mdl_Gen.mdl.append('	<li class=\"_anm itm mdl '+_cls+'\" cl-id=\"'+v.enc+'\" rel=\"'+v.enc+'\" style=\"background-color:'+_bclr+'\">
														<figure style=\"background-image:url('+img+')\" class=\"_bg\"></figure>
														<span>'+v.nm+'</span>
													</li>');
						});	
					}
					
					$('#tot_us_".$__Rnd."').html( SUMR_Mdl_Gen.mdlgenmdl['tot'] );
					
					MdlGen_Dom_Rbld();
				}
				
				function MdlGenFm_Html(){
					SUMR_Mdl_Gen.fm.html('');
					SUMR_Mdl_Gen.fm.append('<li class=\"sch\">".HTML_inp_tx('fm_sch_'.$__Rnd, TX_SEARCH, '')."<button class=\"_new _anm\" new-tp=\"fm\"></button></li>');
					
					if( !isN(SUMR_Mdl_Gen.mdlgenfm['ls']) ){
						$.each(SUMR_Mdl_Gen.mdlgenfm['ls'], function(k, v) { 
							if(v.tot > 0){ var _cls = 'on'; }else{ var _cls = 'off'; }
							SUMR_Mdl_Gen.fm.append('<li class=\"_anm itm fm '+_cls+'\" us-id=\"'+v.enc+'\" rel=\"'+v.enc+'\" ><span>'+v.nm+'</span></li>');
						});	
					}
					
					MdlGen_Dom_Rbld();
				}
				
				
				";
				
				$l_mdlgen = __Ls([ 'k'=>'mdl_tp_mdl', 'id'=>'mdlgenmdl_tp', 'ph'=>'-' ]);
				$l_mdlgenfm = __Ls([ 'k'=>'mdl_tp_fm', 'id'=>'mdlgenfm_fm', 'ph'=>'-' ]);
				
				$CntJV .= "
				
					function MdlGenFmBld(p){
						
						if(p.t == 'mdl'){
							
							var _html = '".HTML_inp_hd('mdlgenmdl_mdlgen',Php_Ls_Cln($___Ls->gt->i)).
										   $l_mdlgen->html.			 
						    			   HTML_inp_tx('mdlgenmdl_nm', TX_NM , '', FMRQD).   	
										   HTML_inp_tx('mdlgenmdl_vl', TX_KEY, '', FMRQD)."
										   <button new-tp=\"mdl\">".TXBT_GRDR."</button>'; 
							
							__mdlgen_bx_mdl_fm.html( _html );
							$l_mdlgen->js 
						
						}else if(p.t == 'fm'){
							
							var _html = '".$l_mdlgenfm->html."		
										   <button new-tp=\"fm\">".TXBT_GRDR."</button>'; 
							
							__mdlgen_bx_fm_fm.html( _html );
							$l_mdlgenfm->js 
						
						}
						
						MdlGen_Dom_Rbld();
					}
					
					
					function MdlGenSet(p){
						if(!isN(p)){	
							
							if( !isN(p.mdlgen.mdl) ){ SUMR_Mdl_Gen.mdlgenmdl['ls'] = p.mdlgen.mdl.ls; SUMR_Mdl_Gen.mdlgenmdl['tot'] = p.mdlgen.mdl.tot; }
							if( !isN(p.mdlgen.fm) ){ SUMR_Mdl_Gen.mdlgenfm['ls'] = p.mdlgen.fm.ls; SUMR_Mdl_Gen.mdlgenfm['tot'] = p.mdlgen.fm.tot; }
							MdlGenMdl_Html();
							MdlGenFm_Html();
						}
					}
						
				";
				
				if($___Ls->dt->tot > 0){
				
					$CntJV .= " 
					
						
						_Rqu({ 
							t:'mdl_gen', 
							t2:'".$___Ls->gt->tsb."',
							_id_mdlgen : '".Php_Ls_Cln($___Ls->gt->i)."',
							_cl:function(_r){
								if(!isN(_r)){
									if(!isN(_r.cl)){
										MdlGenSet(_r.cl);			
									}
								}
							} 
						});
						
					";
					
				}			
				
			?>	
				
			<div class="mdl_gen_dsh dsh_cnt <?php if($___Ls->dt->tot == 0){ echo '_new'; } ?>">
				<div class="_c _c1 _scrl">	

          			<?php 

	          			$__tpdt = GtMdlSTpDt([ 'tp'=>$___Ls->gt->tsb ]);
	          			echo HTML_inp_hd('mdlgen_tp', $__tpdt->id); 
	          			
	          			if($___Ls->gt->tsb == 'act'){
		          			$__tp_act = GtMdlSTpDt([ 'tp'=> $__t3]);
				  			echo HTML_inp_hd('mdlgen_mdlstp', $__tp_act->id); 	
	          			}

	          		?>
          			 
                    <?php echo HTML_inp_tx('mdlgen_tt', TX_NM, ctjTx($___Ls->dt->rw['mdlgen_tt'],'in'), FMRQD, 'onblur="SUMR_Main.pml.input({ tt:\'#mdlgen_tt\', pml:\'#mdlgen_pml\' });"'); ?>
                    <?php echo HTML_inp_tx('mdlgen_pml', TX_PML, ctjTx($___Ls->dt->rw['mdlgen_pml'],'in'), FMRQD, 'onblur="SUMR_Main.pml.input({ tt:\'#mdlgen_tt\', pml:\'#mdlgen_pml\' });"'); ?>   
                    <?php echo OLD_HTML_chck('mdlgen_all', TX_MDLSALL, $___Ls->dt->rw['mdlgen_all']).HTML_BR.HTML_BR; ?>		
					<?php echo LsLnd('mdlgen_lnd','id_lnd', $___Ls->dt->rw["mdlgen_lnd"], MDL_LND, 2); $CntWb .= JQ_Ls('mdlgen_lnd',MDL_LND); ?>
					<?php echo HTML_inp_tx('mdlgen_s_ph', TX_PLCH.' '.TX_LST, ctjTx($___Ls->dt->rw['mdlgen_s_ph'],'in'), FMRQD); ?> 
                    
                    <div id="_upl_fle"> </div>
                	<?php 
	                	if($___Ls->dt->tot > 0){ 
	                		$CntWb .= "_ldCnt({ u:'".Fl_Rnd(FL_LS_GN.__t($__prfx->prfx2_c.'_up',true)).Fl_i($___Ls->dt->rw[$___Ls->ino])."', c:'_upl_fle' });"; 
	                	} 
	                ?>
            	 
				</div>
				<div class="_c _c2 _scrl">
					<?php echo h2( _Cns('MDL_S_TP_'. strtoupper($___Ls->gt->tsb) ) ); ?>
					<div class="_wrp">
						<ul id="bx_mdl_<?php echo $__Rnd; ?>" class="dls"></ul>
					</div>
				</div>
				<div class="_c _c3 _scrl">
					
					<?php 
						
						$_id_tbpnl = 'TabPnl_'.Gn_Rnd(20); $CntJV .= " SUMR_Main.bxajx.".$_id_tbpnl." = new Spry.Widget.TabbedPanels('".$_id_tbpnl."', {defaultTab:0}); ";  
			
						$___Ls->_dvlsfl_all([
							['n'=>'flds',  'l'=>TX_FLDS. TX_FM],
							['n'=>'fm_gen', 't'=>'mdl_gen_fm', 'l'=>TX_FM]		
						]);	
	
					?>
					
					<div id="<?php echo $_id_tbpnl ?>" class="VTabbedPanels mny lead_detail_tb">
			          	<ul class="TabbedPanelsTabGroup">
					  	
				            <?php echo $___Ls->tab->flds->l ?>
				            <?php echo $___Ls->tab->fm_gen->l ?>
			            
			          	</ul>
					  	<div class="TabbedPanelsContentGroup">
				            <div class="TabbedPanelsContent">
			            		<div class="ln _scrl">
				            		
				            		<?php echo h2(TX_FLDS. TX_FM); ?>
									<ul id="bx_fm_<?php echo $__Rnd; ?>" class="dls"></ul>
								
				            		
				            		
			                    </div>
				            </div> 
				            <div class="TabbedPanelsContent">
			            		<div class="ln _scrl">
				            		
				            		<div class="__lve">
					            		<?php 
						            		
						            		$__form = _IfBld([ 
												'cl'=>DB_CL_PRFL,
												'id'=>$___Ls->dt->rw[$___Ls->ik], 
												'g'=>'ok'
											]);
											
											echo $__form->all;	           		
					            		?>
					            	</div>	
					            	
					            	<?php echo $___Ls->tab->fm_gen->d ?>				            		
				            		
				            		
			                    </div>
				            </div>                                       
				        </div>
			        </div>
					
					
				</div>	
			</div> 
				        
      	</div>
    </form>
  </div>
</div>
<style>
	.mdl_gen_dsh ._c{ width: 40%; }
	.mdl_gen_dsh ._c._c1{ width: 30%; } 	
	.mdl_gen_dsh._new ._c._c1{ width:100%; border:none; } 
	.mdl_gen_dsh._new ._c._c2,
	.mdl_gen_dsh._new ._c._c3{ display: none; } 
	
	
	.mdl_gen_dsh ._c ul .itm.mdl figure{ background-size: 50% auto; left: -6px; }
	.mdl_gen_dsh ._c ul .itm.mdl.off{ -webkit-filter: grayscale(100%); filter: grayscale(100%); opacity: 0.5; } 
	.mdl_gen_dsh ._c ul .itm.mdl.off:hover{ -webkit-filter: grayscale(0%); filter: grayscale(0%); opacity: 1; } 
	
	.mdl_dsh_imgbn{ min-height: 200px; height: 200px; position: relative; background-image: none !important; z-index: 1; }
	
	.mdl_dsh_imgbn::before{ z-index: 1; position: absolute; left: 0; top: 0; width: 100%; height: 100%; background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>ec_broken.svg); background-color: #bfc3c5; background-size: 50% auto; opacity: 0.2; background-size: auto 60%; background-repeat: no-repeat; background-position: center center; }
	.mdl_dsh_imgbn ._img{ position: absolute; left: 0; top: 0; width: 100%; height: 100%; background-size: cover; background-repeat: no-repeat; background-position: center center; z-index: 2; }
	.mdl_dsh_imgbn ._img::after{ position: absolute; left: 0; top: 0; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.4); }
	.mdl_dsh_imgbn ._nm{ position: absolute; right: 50px; bottom: 15px; width: 70%; pointer-events: none; }
	.mdl_dsh_imgbn ._opt{ position: absolute; right:0; top:0; height: 100%; width: 50px; padding: 0 5px; z-index: 10; }
	
	.mdl_dsh_imgbn ._opt::after{ position: absolute; right: 0; top: 0; height: 100%; width: 200px; z-index: 1; background: rgba(0,0,0,0); background: -moz-linear-gradient(left, rgba(0,0,0,0) 18%, rgba(0,0,0,0.14) 28%, rgba(0,0,0,0.59) 62%, rgba(0,0,0,1) 92%, rgba(0,0,0,1) 100%); background: -webkit-gradient(left top, right top, color-stop(18%, rgba(0,0,0,0)), color-stop(28%, rgba(0,0,0,0.14)), color-stop(62%, rgba(0,0,0,0.59)), color-stop(92%, rgba(0,0,0,1)), color-stop(100%, rgba(0,0,0,1))); background: -webkit-linear-gradient(left, rgba(0,0,0,0) 18%, rgba(0,0,0,0.14) 28%, rgba(0,0,0,0.59) 62%, rgba(0,0,0,1) 92%, rgba(0,0,0,1) 100%); background: -o-linear-gradient(left, rgba(0,0,0,0) 18%, rgba(0,0,0,0.14) 28%, rgba(0,0,0,0.59) 62%, rgba(0,0,0,1) 92%, rgba(0,0,0,1) 100%); background: -ms-linear-gradient(left, rgba(0,0,0,0) 18%, rgba(0,0,0,0.14) 28%, rgba(0,0,0,0.59) 62%, rgba(0,0,0,1) 92%, rgba(0,0,0,1) 100%); background: linear-gradient(to right, rgba(0,0,0,0) 18%, rgba(0,0,0,0.14) 28%, rgba(0,0,0,0.59) 62%, rgba(0,0,0,1) 92%, rgba(0,0,0,1) 100%); filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#000000', endColorstr='#000000', GradientType=1 ); opacity: 0.6;
	}
	
	.mdl_dsh_imgbn ._opt ul{ z-index: 2; list-style: none; padding: 0; margin: 0; position: relative; }
	.mdl_dsh_imgbn ._opt ul li{}
	.mdl_dsh_imgbn ._opt ul li button{ text-indent: -1000px; width: 40px; height: 40px; overflow: hidden; background-color: transparent; background-position: center center; background-repeat: no-repeat; background-size: auto 60%; margin-bottom: 5px; border: none; }
	.mdl_dsh_imgbn ._opt ul li button:hover{ background-size: auto 40%; }
	
	
	.mdl_gen_dsh ._c .__lve{ border: 4px dashed #e6e8e9; padding: 20px; }
	
	
	.VTabbedPanels.mny > ul.TabbedPanelsTabGroup, .VTabbedPanels.mny > div.TabbedPanelsContentGroup .VTabbedPanels.mny ul.TabbedPanelsTabGroup{ width: 7% !important; }
	
	.FmDivBx .VTabbedPanels > .TabbedPanelsTabGroup .TabbedPanelsTab{ background-position: center;background-size: 21px;height: 4%;width: 100%; }
	.FmDivBx .VTabbedPanels > .TabbedPanelsTabGroup .TabbedPanelsTabSelected._flds{ background-image:url('<?php echo DMN_IMG_ESTR_SVG ?>text-w.svg'); }
	.FmDivBx .VTabbedPanels > .TabbedPanelsTabGroup .TabbedPanelsTabSelected._fm_gen{ background-image:url('<?php echo DMN_IMG_ESTR_SVG ?>form-w.svg'); }
	
	.FmDivBx .VTabbedPanels > .TabbedPanelsTabGroup ._flds{ background-image:url('<?php echo DMN_IMG_ESTR_SVG ?>text.svg'); }
	.FmDivBx .VTabbedPanels > .TabbedPanelsTabGroup ._fm_gen{ background-image:url('<?php echo DMN_IMG_ESTR_SVG ?>form.svg'); }
	
</style>


<?php } ?>
<?php } ?>