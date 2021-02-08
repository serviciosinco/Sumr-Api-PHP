<?php  

if(class_exists('CRM_Cnx')){
	
	$___Ls->tt = _Cns('TX_CNT');
	$___Ls->ik = 'cnt_enc';
	$___Ls->cnx->cl = 'ok';
	$___Ls->_strt();
	
	if(!isN($___Ls->gt->i)){	
		 
		$___Ls->qrys = sprintf("SELECT *
								FROM  ".TB_ORG_SDS_CNT."
								WHERE ".$___Ls->ik." = %s 
								LIMIT 1", GtSQLVlStr($___Ls->gt->i, "text")
							);
		
	}elseif($___Ls->_show_ls == 'ok'){
		
		$Ls_Whr = "	FROM ".TB_ORG_SDS_CNT."
						INNER JOIN "._BdStr(DBM).TB_ORG_SDS." ON orgsdscnt_orgsds = id_orgsds
						INNER JOIN "._BdStr(DBM).TB_ORG."  ON orgsds_org = id_org
						INNER JOIN ".TB_CNT." ON id_cnt = orgsdscnt_cnt
					WHERE ".$___Ls->ino." != '' AND 
						   org_enc = '{$___Ls->gt->isb}' AND
						   orgsdscnt_tpr = '"._CId('ID_ORGCNTRTP_TRB_PRST')."'
						   ".$___Ls->sch->cod."
					ORDER BY ".$___Ls->ino." DESC";
		$___Ls->qrys = "SELECT *, 
						   (SELECT COUNT(*) $Ls_Whr) AS ".QRY_RGTOT." $Ls_Whr";
						   		   		
	}else{
		
		$__org_tp = __LsDt([ 'k'=>'org_tp' ]);
		
		foreach($__org_tp->ls->org_tp as $_k => $_v){
			if($___Ls->gt->tsb == $_v->key->vl){ 
				$_org_tp = $_v;
			}
		}

	}
	
	$___Ls->_bld();

	
	if($__t2 == 'emp'){
		$_id_orgtp = _CId('ID_ORGTP_EMP');
		$_id_orgtpr = _CId('ID_ORGCNTRTP_TRB_PRST');
	}else if($__t2 == 'clg'){
		$_id_orgtp = _CId('ID_ORGTP_CLG');
		$_id_orgtpr = _CId('ID_ORGCNTRTP_TRB_PRST');
	}else if($__t2 == 'uni'){
		$_id_orgtp = _CId('ID_ORGTP_UNI');
		$_id_orgtpr = _CId('ID_ORGCNTRTP_TRB_PRST');
	}else if($__t2 == 'marks'){
		$_id_orgtp = _CId('ID_ORGTP_MARKS');
		$_id_orgtpr = _CId('ID_ORGCNTRTP_TRB_PRST');
	}

			
	
?>
<?php if($___Ls->ls->chk=='ok'){ ?>

	<?php $___Ls->_bld_l_hdr(); ?>
	<?php if(($___Ls->qry->tot > 0)){  ?>
	
		<table width="100%" border="0" cellpadding="0" cellspacing="0" class="Ls_Rg">
			<tr>
			    <th width="1%" <?php echo NWRP ?>><?php echo TX_FM_No ?></th>
			    <th width="5%" <?php echo NWRP ?>><?php echo TX_NM ?></th>
				<?php if($__t2 == 'clg'){ ?>
					<th width="15%" <?php echo NWRP ?>><?php echo 'Cargo' ?></th>
					<th width="15%" <?php echo NWRP ?>><?php echo 'Telefonos' ?></th>
					<th width="15%" <?php echo NWRP ?>><?php echo 'Email' ?></th>
				<?php } ?>
				<?php if($__t2 == 'marks'){ ?> <th width="1%" <?php echo NWRP ?>></th> <?php } ?>
				<th width="1%" <?php echo NWRP ?>></th>
			</tr>
			<?php do {  ?>
				<?php $__ls_json[] = $___Ls->ls->rw['orgsdscnt_enc']; ?>
		  		<tr orgsdscnt-id-no="<?php echo $___Ls->ls->rw[$___Ls->ino]; ?>">	
					<td align="left" <?php echo $_clr_rw ?>><?php echo $___Ls->ls->rw[$___Ls->ino]; ?></td>
				    <td width="30%" align="left" <?php echo $_clr_rw ?>><?php echo ctjTx($___Ls->ls->rw['cnt_nm']." ".$___Ls->ls->rw['cnt_ap'], 'in'); ?></td>
					<?php if($__t2 == 'clg'){ ?>
						<td width="15%" <?php echo NWRP ?>><?php echo bdiv([ 'cls'=>'bx_crg' ]) ?></td>
						<td width="15%" <?php echo NWRP ?>><?php echo bdiv([ 'cls'=>'bx_tel' ]) ?></td>
						<td width="15%" <?php echo NWRP ?>><?php echo bdiv([ 'cls'=>'bx_eml' ]) ?></td>
					<?php } ?>
				    <?php if($__t2 == 'marks'){ ?>
						<td width="1%" align="left" nowrap="nowrap" class="_btn tkn">
							<button id="<?php echo $___Ls->ls->rw['orgsdscnt_enc'] ?>" rel="<?php echo $___Ls->ls->rw['id_orgsds'] ?>" class="_anm _ing_tkn"></button> 
						</td>
					<?php } ?>
					<td width="1%" align="left" nowrap="nowrap" class="_btn"><?php echo $___Ls->_btn([ 't'=>'dtl' ]); ?></td>
				</tr>
		  	<?php } while ($___Ls->ls->rw = $___Ls->sql->fetch_assoc()); ?>
				<?php 
					$CntJV .= " var _encs = '".implode(',', $__ls_json)."'; ";

					$CntWb .= "

						_Rqu({ 
							t:'org_sds_cnt_ext', 
							_i: _encs,
							_bs:function(){   },
							_cm:function(){   },
							_cl:function(d){
								if(!isN(d)){
									
									if(!isN(d.l)){

										$.each(d.l, function(_k, _v) { 

											if(!isN(_v.eml)){
												$('tr[orgsdscnt-id-no='+_v.id+'] .bx_eml').html('');
												$.each(_v.eml, function(_k_eml, _v_eml) { 
													$('tr[orgsdscnt-id-no='+_k+'] .bx_eml').append( '<span style=\"display:block\">'+_v_eml+'</span>' );
												});
											}

											if(!isN(_v.tel)){
												$('tr[orgsdscnt-id-no='+_v.id+'] .bx_tel').html('');
												$.each(_v.tel, function(_k_tel, _v_tel) { 
													$('tr[orgsdscnt-id-no='+_k+'] .bx_tel').append( '<span style=\"display:block\"><div class=\"ps_org_sds_cnt\" style=\"background-image: url(".DMN_FLE_PS_TH."'+_v_tel.ps+')\"></div>'+_v_tel.tel+'</span>' );
												});
											}

											if(!isN(_v.crg)){
												$('tr[orgsdscnt-id-no='+_v.id+'] .bx_crg').html('');
												$.each(_v.crg, function(_k_crg, _v_crg) { 
													$('tr[orgsdscnt-id-no='+_k+'] .bx_crg').append( '<span style=\"display:block\"><div class=\"\"></div>'+_v_crg.crg+'</span>' );
												});
											} 
											
										});
									
									}
									
								}
							} 
						});

					";

					$CntWb .= "
                                    
								$('._ing_tkn').off('click').click(function(e){

									var _id = $(this).attr('id');
									var _rel = $(this).attr('rel');

									e.preventDefault();
									
									if(e.target != this){	
								    	e.stopPropagation();	
									}else{
										_ldCnt({ 
											u:'".Fl_Rnd(FL_LS_GN.__t('org_sds_cnt_tkn', true)).TXGN_POP.TXGN_BX.$___Ls->bx_rld.ADM_LNK_SB."'+_id+'&_sds='+_rel, 
											w:'98%',
											h:'98%',
											pop:'ok',
											pnl:{
												e:'ok',
												tp:'h',
												s:'l'
											}
										});
									}
								});	

							";
				?>
		</table>
		<?php $___Ls->_bld_l_pgs(); 
		
	}
	$___Ls->_h_ls_nr(); 
} ?>

<?php if($___Ls->fm->chk=='ok'){ ?>
<div class="FmTb">
  <div id="<?php echo $___Ls->fm->bx->id ?>" class="<?php echo DV_GNR_FM_BX ?> __cnt_dtl" >
  	<form method="POST" name="<?php echo $___Ls->fm->id; ?>" target="_self" id="<?php echo $___Ls->fm->id; ?>">
  		<?php $___Ls->_bld_f_hdr(); ?>
	 	<div id="<?php echo $___Ls->fm->fld->id ?>" class="<?php echo DV_GNR_FM_CMP ?>">

	    <div class="ln_1">
		   		<?php if(isN($___Ls->gt->i)){ ?>
		   		
		   		<?php 
			   		
			   		$_org_dt = GtOrgDt([ 'i'=>$___Ls->gt->isb, 't'=>'enc' ]);
			   			
			   		echo h1(TX_NW.' '.TX_CNT.' en '.$_org_dt->nm); 
			   		
			   	?>
		   		
		    	<div class="__sch_json_org" id="__sch_json_org">
					<div class="_c1"><?php echo HTML_inp_tx($___Ls->fm->id.'_nm_sch', TX_DCID.' / '.TT_FM_EML, '', FMRQD); ?></div>
					<div class="_c2"><input id="__sch_json_btn_org" name="__sch_json_btn_org" type="button" class="_anm" title="<?php echo TX_SCH ?>" /></div>
		    	</div>
		    	
		    	<?php 
			    	$CntWb .= "
			    	
			    		var _sch_bx = $('#__sch_json_org');
                        var _sch_lead = $('#".$___Ls->fm->id."_nm_sch');
                        var _sch_btn = $('#__sch_json_btn_org');
                        
			    		$('#".$___Ls->fm->id." .Tt_Tb').hide();                            
                            
                        _sch_btn.off('click').click(function(e){
							e.preventDefault();
							
							if(e.target != this){
						    	e.stopPropagation(); return;
							}else{
								__sch_cnt();
							}
						});
						
						
						$('#".$___Ls->fm->id."').on('keyup', function (e) {
							e.preventDefault();
							if(e.keyCode == 13){
						    	__sch_cnt();
						    }
						});
                        
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
											
											var _vl = $('#".$___Ls->fm->id."_nm_sch').val();
		                                    var _eml_chk = /^[-\w.%+]{1,64}@(?:[A-Z0-9-]{1,63}\.){1,125}[A-Z]{2,63}$/i;
											
											if(d.e == 'ok'){
												
												$('#cnt_enc').val(d.enc);
												
	                                            $('.__cnt_dtl').addClass('_exist');
	                                            
	                                            $('#_dtll1').html('
	                                            	".h2('Datos Basicos')."
	                                            	<li id=\"_li_nm\">".Strn(TX_NM, '' ,true)." '+d.nm+' </li>
	                                            	<li id=\"_li_nm\">".Strn(TX_AP, '' ,true)." '+d.ap+' </li>
	                                            ');
	                                            
	                                            $('#_dtll2').html('
	                                            	".h2('Otros Datos')."
	                                            ');
	                                            
	                                            $.each(d._dc, function(k_dc, v_dc) {
													if(!isN(v_dc)){
														$('#_dtll2').append('<li id=\"_li_nm\">".Strn(TX_DC, '' ,true)." '+v_dc+' </li>');
												    }
												});
												
												$.each(d._tel, function(k_tel, v_tel) {
													if(!isN(v_tel)){
														$('#_dtll2').append('<li id=\"_li_nm\">".Strn(TX_TEL, '' ,true)." '+v_tel+' </li>');
												    }
												});
												
												$.each(d._eml, function(k_eml, v_eml) {
													if(!isN(v_eml)){
														$('#_dtll2').append('<li id=\"_li_nm\">".Strn(TX_EML, '' ,true)." '+v_eml+' </li>');
												    }
												});
												
												if (!isNaN( _vl )) { 
										        	$('#cnt_dc_new').val(_vl);
												}else if(_eml_chk.test(_vl)){
													$('#cnt_eml_new').val(_vl);
												}
	                                            
	                                            $('._mod').removeClass('_dts');
	                                            
	                                        }else if(d.e == 'no'){
		                                     
		                                    	$('.ln_1 ._new').removeClass('_new');  
		                                    	
		                                    	if (!isNaN( _vl )) { 
										        	$('#cnt_dc').val(_vl);
												}else if(_eml_chk.test(_vl)){
													$('#cnt_eml').val(_vl);
												}else{
													$('#cnt_nm').val(_vl);
												}
												
	                                        }
	                                        $('#".$___Ls->fm->id." .Tt_Tb').show();
	                                        $('.__sch_json_org').addClass('_cls');
	                                        
										}
									} 
								});
							
							}
                        }
						
			    	";
		    	?>
			<?php }else{ ?>
			    
			<?php } ?>
			
			<?php 
				$CntWb .= "
											
					$('#cnt_tel_tp').change(function() {
						
						var __id_tp = $(this).val();
						var __id_ext = $('#cnt_tel_ext');
						var __id_tel = $('#cnt_tel'); 
						var __sl = $('#cnt_tel_tp option:selected');
						var __sl_r = __sl.attr('rel');
						var __sl_r_o = eval('('+__sl_r+')');
						
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
			
			<?php echo HTML_inp_hd('orgsdscnt_tpr', $_id_orgtpr); ?>
			<?php echo HTML_inp_hd('orgsdscnt_tpr_o', $_id_orgtp); ?>
			
			<div class="ln_1">
				<div class="_new" style="padding-bottom:20px;">

					<?php echo LsOrgSds(['id'=>'orgsdscnt_orgsds_new', 'v'=>'id_orgsds', 'va'=>$___Ls->dt->rw['orgsdscnt_orgsds'], 'rq'=>1, 'org'=>$___Ls->gt->isb ]);
					$CntWb .= JQ_Ls('orgsdscnt_orgsds_new'); ?>
					
				</div>
				<div class="col_1">
					<div class="_new">
						<?php
							
			                echo HTML_inp_tx('cnt_nm', TT_FM_NM, ctjTx($___Ls->dt->rw['cnt_nm'],'in'), FMRQD);
			                echo HTML_inp_tx('cnt_ap', TX_AP, ctjTx($___Ls->dt->rw['cnt_ap'],'in'), FMRQD);
			               
			                $l_sx = __Ls([ 'k'=>'sx', 'id'=>'cnt_sx', 'rq'=>2, 'va'=>$___Ls->dt->rw['cnt_sx'] , 'ph'=>FM_LS_SISSX ]);  
			                echo $l_sx->html; $CntWb .= $l_sx->js;
						          
						?>	  
						
						<div class="trb_smpr" style="display: block;">
							<?php $l = __Ls([ 'k'=>'emp_ars', 'id'=>'orgsdscnt_are', 'va'=>$___Ls->dt->rw['orgsdscnt_are'] ,'rq'=>2,  'ph'=>TX_SLCAR ]); 
			                echo $l->html; $CntWb .= $l->js; ?>	
						</div>

						<div class="org_cnt_plcy">
							<?php 
								echo OLD_HTML_chck('orgcnt_sndi', 'Acepta Polí­tica de Datos','', 'in');

								$__Cl = new CRM_Cl([ 'cl'=>$__dt_cl->id ]);
								$___plcy_main = $__Cl->plcy_main([ 'cl'=>$__dt_cl->id ]);
								echo LsPlcy('orgcnt_plcy', 'id_clplcy', $___plcy_main->id , FM_LS_PLCY, 'ok', '', [ 'cl'=>CL_ENC ] ); 
								$CntWb .= JQ_Ls('orgcnt_plcy', '');
							?>
						</div>
					</div>
					<div class="_mod _dts">
						<ul id="_dtll1" class="ls_1"></ul>
					</div>
				</div>
				<div class="col_2">
					<div class="_new">
						<?php
							
							if($___Ls->gt->tsb != 'clg'){
								
								//echo HTML_inp_hd('orgsdscnt_orgsds', $___Ls->gt->isb);
								$l_dc = __Ls([ 
											'k'=>'cnt_dc', 
				                			'opt_v'=>'itm-sg', 
											'id'=>'cnt_dc_tp', 
											'rq'=>2,
				                			'va'=>$___Ls->dt->rw['cnt_dc_tp'], 
				                			'ph'=>FM_LS_TPDOC,
				                			'slc'=>[ 
												'opt'=>[
														'attr'=>[
															'itm-sg'=>'sg'
														]	
													] 
												]  
				                		]); 
				                		
				                echo $l_dc->html; $CntWb .= $l_dc->js;
			                
								echo HTML_inp_tx('cnt_dc', TT_FM_ID, ctjTx($___Ls->dt->rw['cnt_dc'],'in'), 2);
							}
							
							echo HTML_inp_tx('cnt_eml', TT_FM_EML, ctjTx($___Ls->dt->rw['cnt_eml'],'in'), FMRQD_EML);
							echo LsSis_Tel('cnt_tel_tp','id_sistel', '', FM_LS_SLTEL, 2); $CntWb .= JQ_Ls('cnt_tel_tp', FM_LS_SLTEL);
							echo LsSis_PsOLD('cnt_tel_ps','id_sisps', 57, '-', 2, '', '', 'iso'); $CntWb .= JQ_Ls('cnt_tel_ps', '-', '', 'psFlg', ['ac'=>'no']);
							echo HTML_inp_tx('cnt_tel', TX_NMR, '', FMRQD_NMR);
							echo HTML_inp_tx('cnt_tel_ext', TX_EXT, '', FMRQD_NMR, ' style="display:none;" ');
							
						?>
					</div>
					<div class="_mod _dts">
						<ul id="_dtll2" class="ls_1"></ul>
					</div>
				</div>
				<div class="_mod _dts" style="margin-top: 30px;">
					<div class="col_1">
					<?php 
						
						echo HTML_inp_hd('cnt_enc', NULL);

						echo LsOrgSds(['id'=>'orgsdscnt_orgsds', 'v'=>'id_orgsds', 'va'=>$___Ls->dt->rw['orgsdscnt_orgsds'], 'rq'=>1, 'org'=>$___Ls->gt->isb ]);
						$CntWb .= JQ_Ls('orgsdscnt_orgsds');
						
						
						if($___Ls->gt->tsb != 'clg'){
						
							$l_dc_mod = __Ls([ 'k'=>'cnt_dc', 'id'=>'cnt_dc_tp_new', 'va'=>$___Ls->dt->rw['cnt_dc_tp_new'], 'ph'=>FM_LS_TPDOC, 'rq'=>2 ]); 
							echo $l_dc_mod->html; $CntWb .= $l_dc_mod->js;
							echo HTML_inp_tx('cnt_dc_new', TT_FM_ID, ctjTx($___Ls->dt->rw['cnt_dc_new'],'in'), 2);
						
						}
						
					?>
					</div>
					<div class="col_2">
						<?php
							echo LsSis_Tel('cnt_tel_tp_new','id_sistel', '', FM_LS_SLTEL, 2); $CntWb .= JQ_Ls('cnt_tel_tp_new', FM_LS_SLTEL);
							echo HTML_inp_tx('cnt_tel_new', TX_NMR, '', 'no');
							echo HTML_inp_tx('cnt_eml_new', TT_FM_EML, ctjTx($___Ls->dt->rw['cnt_eml_new'],'in'), FMRQD_EML);
						?>
					</div>
				</div>
			</div>
        </div>
        <style>
        	
        	.__cnt_dtl .__cnt_rsl{ width: 1px; height: 1px; pointer-events: none; opacity: 0; }
        	.__cnt_dtl._exist .__cnt_rsl{ width: 100%; height: auto; pointer-events: all; opacity: 1; }
        	.__sch_json_org._cls{ display: none; }
        	.ln_1 ._new{ display: none; }
        	.ln_1 ._dts{ display: none!important; }
        	
        	
        	.__sch_json_org{ background-color: #f5f3f6; padding: 10px; white-space: nowrap; margin-bottom: 20px; border-radius: 10px; -moz-border-radius: 10px; -webkit-border-radius: 10px; position: relative; }
			.__sch_json_org ._c1{ vertical-align: top; display: inline-block; width: 100%; }
			.__sch_json_org ._c2{ vertical-align: top; display: inline-block; width: 10%; position: absolute; top:10px; right: 10px; }
			.__sch_json_org input[type=button]{ width:40px; height: 40px; background-image: url(<?php echo _iEtg(DMN_IMG_ESTR_SVG.'ls_sch.svg') ?>); opacity: 0.4; background-repeat: no-repeat; background-position: 				center center; border: none; background-size: 40% auto; background-color: transparent; }
			.__sch_json_org input[type=button]:hover{ opacity: 1; }
			
			.__sch_json_org input[type=text]{ text-align: center; }
			
			
			.__sch_json_org.__ld ._c1 input{ opacity: 0.5; background-image: url(<?php echo _iEtg(DMN_IMG_ESTR_SVG.'loader_black.svg') ?>); background-repeat: no-repeat; background-position: center center; background-size: auto 70%; pointer-events: none; }
			.__sch_json_org.__ld ._c2{ opacity: 0.3; }
			.__sch_json_org._sch_enc{ background-color: transparent; margin: 0; }
			.__sch_json_org._sch_enc ._c1{ width: 80%; }
			.__sch_json_org._sch_enc ._c2{  display: inline-block !important; width: 19%; }
			.__sch_json_org._sch_enc input[type=button]{  width: 100%;}
			.__sch_json_org._sch_enc ._c1 input{box-sizing: border-box;}

			.org_cnt_plcy {background-color: #d6d6d6;padding: 10px;border: 2px dashed darkgrey;border-radius: 12px;}
			.org_cnt_plcy .__slc_ok{ border-bottom-width: 0px; }
			.org_cnt_plcy h3{ width: 65% !important;vertical-align: super; }
			.org_cnt_plcy .__slc_ok .__slc{ width: 30% !important; }

			
        
        </style>
        </div>
    </form>
  </div>
</div>
<?php } ?>
<?php } ?>
<style>
	._ing_tkn{background-image: url(<?php echo _iEtg(DMN_IMG_ESTR_SVG.'cnt_sec.svg') ?>);border-radius: 200px;-moz-border-radius: 200px;-webkit-border-radius: 200px;border: 2px solid black;width: 30px;height: 30px;background-repeat: no-repeat;background-position: center center;background-size: 60% auto;display: block;opacity: 0.4;margin:0 auto;}
	.ps_org_sds_cnt{ width: 15px;background-position: center;background-repeat: no-repeat;background-size: 100% auto;border-radius: 50%;height: 15px;display: inline-block;vertical-align: bottom;margin-right: 5px;}
</style>
