<?php 
	if(class_exists('CRM_Cnx')){
	$___Ls->cnx->cl = 'ok';
	$___Ls->_strt();
	
	if(!isN($___Ls->gt->i)){
		
		 
		
	$___Ls->qrys = sprintf("SELECT * ,(
										SELECT cntprnt_cnt_prnt_1 FROM ".TB_CNT_PRNT."  WHERE
											cntprnt_cnt_1 =( SELECT cntprnt_cnt_2 FROM ".TB_CNT_PRNT."  WHERE cntprnt_enc = '".$___Ls->gt->i."' )
										AND cntprnt_cnt_2 =( SELECT cntprnt_cnt_1 FROM ".TB_CNT_PRNT."  WHERE cntprnt_enc = '".$___Ls->gt->i."' )
									) as _cnt_rlc,
									(
										SELECT cntprnt_enc FROM ".TB_CNT_PRNT."  WHERE
											cntprnt_cnt_1 =( SELECT cntprnt_cnt_2 FROM ".TB_CNT_PRNT."  WHERE cntprnt_enc = '".$___Ls->gt->i."' )
										AND cntprnt_cnt_2 =( SELECT cntprnt_cnt_1 FROM ".TB_CNT_PRNT."  WHERE cntprnt_enc = '".$___Ls->gt->i."' )
									) as _cnt_enc  
								FROM ".TB_CNT_PRNT." 
								INNER JOIN ".TB_CNT."  ON cntprnt_cnt_1 = id_cnt
								INNER JOIN "._BdStr(DBM).TB_SIS_SLC."  ON id_sisslc = cntprnt_cnt_prnt_1
								
								LEFT JOIN cnt_dc ON cntdc_cnt = id_cnt
								LEFT JOIN cnt_eml ON cnteml_cnt = id_cnt
								
								WHERE ".$___Ls->ik." = %s 
								LIMIT 1", GtSQLVlStr($___Ls->gt->i, "text"));  							
														                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                         
	}elseif($___Ls->_show_ls == 'ok'){ 
		$Ls_Whr =  "FROM ".TB_CNT."
						INNER JOIN ".TB_CNT_PRNT." ON cntprnt_cnt_1 = id_cnt
						INNER JOIN "._BdStr(DBM).TB_SIS_SLC."  ON id_sisslc = cntprnt_cnt_prnt_1
					WHERE
						cntprnt_cnt_2 IN( SELECT _me.id_cnt FROM ".TB_CNT." as _me WHERE _me.cnt_enc = '".$___Ls->gt->isb ."' ) ORDER BY cntprnt_fi DESC";		   
							   
		$___Ls->qrys = "SELECT *, (SELECT COUNT(*) $Ls_Whr) AS ".QRY_RGTOT." $Ls_Whr";
	}
		
		$___Ls->_bld();
?>
<?php if($___Ls->ls->chk=='ok'){ ?>
	<?php $___Ls->_bld_l_hdr(); ?>
	<?php if(($___Ls->qry->tot > 0)){  ?>
	
		<table width="100%" border="0" cellpadding="0" cellspacing="0" class="Ls_Rg">
			<tr>
			    <th width="1%" <?php echo NWRP ?>><?php echo TX_FM_No ?></th>
			    <th width="5%" <?php echo NWRP ?>><?php echo TX_NM?></th>
			    <th width="5%" <?php echo NWRP ?>><?php echo TX_PRNT1?></th>	  
			    <th width="1%" <?php echo NWRP ?>></th>
			</tr>
		    <?php do {  ?>                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                   
		  	<tr>  
				<td align="left" <?php echo $_clr_rw ?>><?php echo $___Ls->ls->rw[$___Ls->ino]; ?></td>
				<td width="30%" align="left" <?php echo $_clr_rw ?>><?php echo ctjTx($___Ls->ls->rw['cnt_nm'].' '.$___Ls->ls->rw['cnt_ap'],'in'); ?></td>
				<td width="30%" align="left" <?php echo $_clr_rw ?>><?php echo ctjTx($___Ls->ls->rw['sisslc_tt'],'in'); ?></td>
			    <td width="1%" align="left" nowrap="nowrap" class="_btn"><?php echo $___Ls->_btn([ 't'=>'mod' ]); ?></td>
			</tr>                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            
		  	<?php } while ($___Ls->ls->rw = $___Ls->sql->fetch_assoc()); ?>
		</table>
		<?php $___Ls->_bld_l_pgs(); 
	}
	$___Ls->_h_ls_nr(); 
} ?>
<?php if($___Ls->fm->chk=='ok'){ ?>
<div class="FmTb">
	
  	<div id="<?php echo $___Ls->fm->bx->id ?>" class="<?php echo DV_GNR_FM_BX ?>" > 
  		<form method="POST" name="<?php echo $___Ls->fm->id; ?>" target="_self" id="<?php echo $___Ls->fm->id; ?>">	  	
     		<?php $___Ls->_bld_f_hdr(); ?>
	 		<div id="<?php echo $___Ls->fm->fld->id ?>" class="<?php echo DV_GNR_FM_CMP ?>">
	    		<div class="ln_1">
		       		<div class="__sch_json" id="__sch_json">
						<div class="_sch_btn">
							<div class="_c1"><?php echo HTML_inp_tx($___Ls->fm->id.'_nm_sch', TX_DCID.' / '.TT_FM_EML, '', FMRQD); ?></div>
							<div class="_c2"><input id="__sch_json_btn" name="__sch_json_btn" type="button" class="_anm" title="<?php echo TX_SCH ?>" /></div>
						</div>
						<div class="_shw cont_prnt _anm">
							<div class="lnbsc_1" id="__fm_col" style="">
								<div class="dtl"> 
									<div class="_c _c1"> 
										<div class="_csub _c1">
											<div class="fld dc">
												<h1 class="u_nm" id="nm_prnt"><?php echo ctjTx($___Ls->dt->rw['cnt_nm'],'in') .' '. ctjTx($___Ls->dt->rw['cnt_ap'],'in');  ?></h1>
												<div class="c2">
													<div class="_hdd fld dc">
														<div class="c1">
															<?php echo HTML_inp_hd('___tp', ''); ?> 
															<?php echo HTML_inp_hd('cnt_cnt', $___Ls->gt->isb); ?> 
															<?php echo HTML_inp_hd('cnt_cnt_rlc', $___Ls->gt->isb); ?>
															<?php echo HTML_inp_hd('_cnt_enc', $___Ls->dt->rw['_cnt_enc']); ?>
															<?php 
																$l = __Ls([ 'k'=>'cnt_dc', 
																	'opt_v'=>'itm-sg', 
																	'id'=>'cntdc_tp1', 
																	'va'=>$___Ls->dt->rw['cnt_dctp'], 
																	'ph'=>FM_LS_TPDOC,
																	'slc'=>[ 
																		'opt'=>[
																			'attr'=>[
																				'itm-sg'=>'sg'
																			]	
																		] 
																	],
																'rq'=>2
															]); 
															
															echo $l->html; $CntWb .= $l->js;    
															?>	 	
														</div>
														<div class="c2">
															<?php echo HTML_inp_tx('cnt_dc1', TT_FM_ID, ctjTx($___Ls->dt->rw['cnt_dc'],'in'), ''); ?>
														</div>
													</div>
														
													<div class="_hdd fld nm">
														<div class="c1">
															<?php echo HTML_inp_tx('cnt_nm1', TT_FM_NM, ctjTx($___Ls->dt->rw['cnt_nm'],'in'), FMRQD); ?> 
														</div>
														<div class="c2">
															<?php echo HTML_inp_tx('cnt_ap1', TT_FM_AP, ctjTx($___Ls->dt->rw['cnt_ap'],'in'), FMRQD); ?>
														</div>
													</div>
													<div class="_hdd">
														<?php echo HTML_inp_tx('cnt_eml1', TT_FM_EML,'', ''); ?> 	
													</div>
													
							                    </div>
							                </div>
											<div class="_hdd _intel">
					                                
				                                <?php echo __SbT([ 't'=>TX_TLFN, 'i'=>'cnt_tel' ]); ?>
				                                <?php echo LsSis_Tel('cnt_tel_tp1','id_sistel', '', FM_LS_SLTEL, 2); $CntWb .= JQ_Ls('cnt_tel_tp1', FM_LS_SLTEL); ?>
				                                <?php 
														
													$CntWb .= "
														
														$('#cnt_tel_tp1').change(function() {
															
															__id_tp = $(this).val();
															__id_ext = $('#cnt_tel_ext1');
															__id_tel = $('#cnt_tel1'); 
															__sl = $('#cnt_tel_tp1 option:selected');
															__sl_r = __sl.attr('rel');
															__sl_r_o = eval('('+__sl_r+')');
															
															if( __id_tp != 2 ){
															 	__id_ext.fadeOut();  
															}else{
														  		__id_ext.fadeIn();   
														  	}
														  	
														  	__id_tel.attr({
														       'maxlenght' : __sl_r_o._min,
														       'minlenght' : __sl_r_o._max 
														    });
														  
														});
													";
												?>
				                                 
				                                <div class="fld tel">
													<div class="c1">
														<?php 
															echo LsSis_PsOLD('cnt_tel_ps1','id_sisps', 57, '-', 2, '', '', 'iso'); $CntWb .= JQ_Ls('cnt_tel_ps1', '-', '', 'psFlg', ['ac'=>'no']); 
														?>
													</div>
													<div class="c2">
														<div class="tel"><?php echo HTML_inp_tx('cnt_tel1', TX_NMR, '', ''); ?></div>
														<div class="ext"><?php echo HTML_inp_tx('cnt_tel_ext1', TX_EXT, '', FMRQD_NMR, ' style="display:none;" '); ?></div>
													</div>
												</div>
				                            </div>
				                            <div class="__cld"> 
											 	<?php 
												 	
												 	$__dt_cnt = GtCntDt([  't'=>'enc', 'id'=>$___Ls->gt->isb, 'ls_tp'=>'ok', 'ls_f_scl'=>'ok', 'ls_f_org'=>'ok', 'ls_f_tpc'=>'ok' ]);
												 	
												 	echo h2('Parentesco del registro.');
									            	$l = __Ls(['k'=>'ls_prnt', 'id'=>'cnt_prnt1', 'ph'=>"Parentesco", 'va'=>$___Ls->dt->rw['cntprnt_cnt_prnt_1'] ]);
													echo $l->html; $CntWb .= $l->js;   
  
													echo h2('Parentesco del registro '.$__dt_cnt->nm);
									            	$l = __Ls(['k'=>'ls_prnt', 'id'=>'cnt_prnt2', 'ph'=>"Parentesco", 'va'=>$___Ls->dt->rw['_cnt_rlc'] ]);
													echo $l->html; $CntWb .= $l->js;   
									            ?>
											</div>
									
										</div>
									
										<div class="_csub _c1">
											<div class="_emls">
												<div class="_anm new_eml">
													<?php echo HTML_inp_tx('cnt_eml2', TT_FM_EML,'', ''); ?>	
													<p class="_new_itm_eml _new_itm"></p>	
												</div>
												<div class="ls_eml"></div>
											</div>
											<div class="_tels">
												<div class="_anm new_tel">
													<div class="_intel ok">
						                                <?php echo LsSis_Tel('cnt_tel_tp2','id_sistel', '', FM_LS_SLTEL, 2); $CntWb .= JQ_Ls('cnt_tel_tp2', FM_LS_SLTEL); ?> 
						                                <?php 
															$CntWb .= "	
																$('#cnt_tel_tp2').change(function() {
																	
																	__id_tp = $(this).val();
																	__id_ext = $('#cnt_tel_ext2');
																	__id_tel = $('#cnt_tel2'); 
																	__sl = $('#cnt_tel_tp2 option:selected');
																	__sl_r = __sl.attr('rel');
																	__sl_r_o = eval('('+__sl_r+')');
																	
																	if( __id_tp != 2 ){ __id_ext.fadeOut(); }else{ __id_ext.fadeIn(); }
																  	__id_tel.attr({  'maxlenght' : __sl_r_o._min, 'minlenght' : __sl_r_o._max });  
																});
															";
														?>
						                                <div class="fld tel">
															<div class="c1">
																<?php echo LsSis_PsOLD('cnt_tel_ps2','id_sisps',57,'-',2,'','','iso'); $CntWb .= JQ_Ls('cnt_tel_ps2','-','','psFlg', ['ac'=>'no']); ?>
															</div>
															<div class="c2">
																<div class="tel"><?php echo HTML_inp_tx('cnt_tel2', TX_NMR, '', ''); ?></div>
																<div class="ext"><?php echo HTML_inp_tx('cnt_tel_ext2', TX_EXT, '', FMRQD_NMR, ' style="display:none;" '); ?></div>
															</div>
														</div>
														<p class="_new_itm_tel _new_itm"></p>
						                            </div>
												</div>
												<div class="ls_tel"></div>
											</div>
											<div class="_doc">
												<div class="_anm new_doc">
													<div class="c1">
														
														<?php 
															$l = __Ls([ 'k'=>'cnt_dc', 
																'opt_v'=>'itm-sg', 
																'id'=>'cntdc_tp2', 
																'ph'=>FM_LS_TPDOC,
																'slc'=>[ 
																	'opt'=>[
																		'attr'=>[
																			'itm-sg'=>'sg'
																		]	
																	] 
																],
															'rq'=>2
														]); 
														
														echo $l->html; $CntWb .= $l->js;    
														?>	 	
													</div>
													<div class="c2">
														<?php echo HTML_inp_tx('cnt_dc2', TT_FM_ID, ctjTx($___Ls->dt->rw['cnt_dc'],'in'), ''); ?>
													</div>
													<p class="_new_itm_doc _new_itm"></p>	
												</div>
												<div class="ls_doc"></div>	
											</div>	
										</div>
									</div>
								</div>
							</div>
						</div>
						<?php 
							$CntWb .= "

								var _sch_bx = $('#__sch_json');
								var _sch_lead = $('#".$___Ls->fm->id."_nm_sch');
								var _sch_btn = $('#__sch_json_btn');                        
								
								if(!isN(".!isN($___Ls->gt->i).")){
									$('._sch_btn').addClass('_hdd');	
									$('._shw').addClass('ok');
									_sch_lead.val('".$___Ls->dt->rw['cntdc_dc']."');		
									__sch_cnt();
								}

								_sch_btn.off('click').click(function(e){
									e.preventDefault();
									if(e.target != this){ e.stopPropagation(); return; }else{ __sch_cnt(); }
								});	
								
								function Click(){
									$('.prd').off('click').click(function(e){
										
										var __tp = $(this).attr('rel');
										
										if(__tp == 'tel'){
											$('.new_tel').toggleClass('ok');
											$('.prd.new.tel').toggleClass('ok');
											$('.ls_tel').toggleClass('ok');	
										}else if(__tp == 'eml'){
											$('.new_eml').toggleClass('ok');
											$('.prd.new.eml').toggleClass('ok');
											$('.ls_eml').toggleClass('ok');	
										}else if(__tp == 'doc'){
											$('.new_doc').toggleClass('ok');
											$('.prd.new.doc').toggleClass('ok');
											$('.ls_doc').toggleClass('ok');	
										}
										
										
									});	
									
									$('._new_itm_tel').off('click').click(function(e){
										_Rqu({ 
											t:'cnt_prnt',
											d: 'tel',
											_i:'".$___Ls->gt->i."',
											cnt_tel2: $('#cnt_tel2').val(),
											cnt_tel_ps2: $('#cnt_tel_ps2').val(),
											cnt_tel_ext2: $('#cnt_tel_ext2').val(),
											cnt_tel_tp2: $('#cnt_tel_tp2').val(),
											cntt: [ $('#cnt_tel2').val(), $('#cnt_tel_ps2').val(), $('#cnt_tel_ext2').val(), $('#cnt_tel_tp2').val() ],
											_bs:function(){ _sch_bx.addClass('__ld'); },
											_cm:function(){ _sch_bx.removeClass('__ld'); },
											_cl:function(d){
												if(!isN(d)){
													if(d.e == 'ok'){
														$('.new_tel, .prd.new, .ls_tel').removeClass('ok');
														$('.ls_tel').append('<p>'+$('#cnt_tel2').val()+'</p>');	
													}																
												}
											} 
										});
									});	
									
									$('._new_itm_eml').off('click').click(function(e){
										_Rqu({ 
											t:'cnt_prnt',
											d: 'eml',
											_i:'".$___Ls->gt->i."',
											cnt_eml2: $('#cnt_eml2').val(),
											_bs:function(){ _sch_bx.addClass('__ld'); },
											_cm:function(){ _sch_bx.removeClass('__ld'); },
											_cl:function(d){
												if(!isN(d)){
													if(d.e == 'ok'){
														$('.new_eml, .prd.new, .ls_eml').removeClass('ok');
														$('.ls_eml').append('<p>'+$('#cnt_eml2').val()+'</p>');	
													}																
												}
											} 
										});
									});	
									
									$('._new_itm_doc').off('click').click(function(e){
										_Rqu({ 
											t:'cnt_prnt',
											d: 'doc',
											_i:'".$___Ls->gt->i."',
											cnt_dc2: $('#cnt_dc2').val(),
											cntdc_tp2: $('#cntdc_tp2').val(),
											_bs:function(){ _sch_bx.addClass('__ld'); },
											_cm:function(){ _sch_bx.removeClass('__ld'); },
											_cl:function(d){
												if(!isN(d)){
													if(d.e == 'ok'){
														$('.new_doc, .prd.new, .ls_doc').removeClass('ok');
														$('.ls_doc').append('<p>'+$('#cnt_dc2').val()+'</p>');	
													}																
												}
											} 
										});
									});
								}
								
								function __sch_cnt(){	
								
									var __i = _sch_lead.val();
								
									if(_sch_lead.valid()){
								
										_sch_lead.val(__i);
								
										_Rqu({ 
											t:'cnt', 
											_i:__i,
											_bs:function(){ _sch_bx.addClass('__ld'); },
											_cm:function(){ _sch_bx.removeClass('__ld'); },
											_cl:function(d){
												if(!isN(d)){
													if(d.e == 'ok'){
														$('#nm_prnt').html(d.nm+' '+d.ap);
														$('._sch_btn').fadeOut();
														$('#___tp').val('new_prnt');
														$('#cnt_cnt_rlc').val(d.enc); 
												        $('._shw').addClass('ok');
												        
												        $('._tels').prepend('".__SbT([ 't'=>TX_TLFN, 'i'=>'cnt_tel' ])."');
												        $('._tels').prepend('<p class=\"prd tel new\" rel=\"tel\"></p>');
												        for(var i in d._tel){ $('._tels .ls_tel').append('<p>'+d._tel[i]+'</p>'); }
												        
														$('._emls').prepend('".__SbT([ 't'=>TX_EML, 'i'=>'cnt_eml' ])."');
														$('._emls').prepend('<p class=\"prd eml new\" rel=\"eml\"></p>');	 
														for(var i in d._eml){ $('._emls .ls_eml').append('<p>'+d._eml[i]+'</p>'); }
														
														$('._doc').prepend('".__SbT([ 't'=>TX_DC, 'i'=>'cnt_docs' ])."');
														$('._doc').prepend('<p class=\"prd doc new\" rel=\"doc\"></p>');
														for(var i in d._dc){ $('._doc .ls_doc').append('<p>'+d._dc[i]+'</p>'); }
														
														Click();
														
													}else if(d.e == 'no'){							
														$('#___tp').val('new_cnt');
														$('._hdd').removeClass('_hdd');   
														$('._shw').addClass('ok');
														$('#nm_prnt').html('').hide();
	
														if(d.t_s == 'eml'){
															$('#cnt_eml1').val(__i);	
															$('#cnt_eml1').addClass('required error');
															$('#cnt_dc1, #cnt_dctp').removeClass('required error');
														}else{
															$('#cnt_dc1').val(__i);
															$('#cnt_dc1, #cnt_dctp').addClass('required error');
															$('#cnt_eml1').removeClass('required error');
														}
													}
												}
											} 
										});
									}
								}
							";
						?>
					</div>  
				</div>
      		</div>
    	</form>
	</div>
</div>
<?php } ?>
<?php } ?>
<style>
.__sch_json{background-color:transparent!important}
.cont_prnt{display:none;margin-top:33px}
.cont_prnt .lnbsc_1 ._c > ._csub._c1{border-right:1px solid #f2f4f5;padding-right:20px}
.cont_prnt .lnbsc_1 ._c > ._csub{width:50%}
.cont_prnt .lnbsc_1 ._c > ._csub .fld{display:flex}
.cont_prnt .lnbsc_1 ._c > ._csub .select2-selection__placeholder{text-align:left;font-size:10px;margin-left:-10px}
.cont_prnt .lnbsc_1 .dtl > ._c input[type=text]{padding:5px;margin:5px 0}
.cont_prnt .lnbsc_1 ._c > ._csub .__SbT{display:block;position:relative;pointer-events:none;margin-bottom:15px}
.cont_prnt .lnbsc_1 ._c > ._csub .cnt_frst .__SbT ._bx{width:40%;background-color:#fff;padding:5px 6px;margin-left:30%;position:relative;z-index:9}
.cont_prnt .lnbsc_1 ._c > ._csub .__SbT ._bx span{width:20px;height:20px;display:inline-block;margin-bottom:-5px;margin-right:5px}
.cont_prnt .lnbsc_1 ._c > ._csub .cnt_frst .fld.dc .c1{width:35%}
.cont_prnt .lnbsc_1 ._c > ._csub .fld .c1,.cont_prnt .lnbsc_1 ._c > ._csub .fld .c2{display:inline-block;vertical-align:top;flex:1;margin:0 3px}
.cont_prnt ._bx::before{content:'';display:block;background-color:#b5b5b5;width:27%;height:1px;position:absolute;top:10px}
.cont_prnt ._bx::after{content:'';display:block;background-color:#b5b5b5;width:27%;height:1px;position:absolute;top:10px;right:0}
._shw{display:none}
._shw.ok{display:block}
._hdd{display:none !important}

._anm.new_tel, ._anm.new_eml, ._anm.new_doc {overflow: hidden;height: 0;width: 100%;position: absolute;background-color: white;}  
.ls_tel.ok, .ls_eml.ok, .ls_doc.ok  {height: 150px;overflow: hidden;}
.new_tel.ok, .new_eml.ok, .new_doc.ok  {height: 150px;}
._tels, ._emls, ._doc{ position: relative; }
.prd.new {width: 25px;height: 25px;position: absolute;top: -2px;right: 0;cursor: pointer;font-size: 0;background-image: url('<?php echo DMN_IMG_ESTR_SVG ?>add.svg');z-index: 1;}
.prd.new.ok{background-image: url('<?php echo DMN_IMG_ESTR_SVG ?>cancel.svg'); }

p._new_itm{ border: 0;width: 25px;height: 25px;margin: 6px;background-image: url('<?php echo DMN_IMG_ESTR_SVG ?>save.svg');display: inline-block;cursor: pointer}
._anm.new_eml .___txar{ width: 70%; display: inline-block; vertical-align: top }
</style>                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    