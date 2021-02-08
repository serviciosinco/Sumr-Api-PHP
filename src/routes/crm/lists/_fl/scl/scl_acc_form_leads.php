<?php  



if(class_exists('CRM_Cnx')){
	
	$___Ls->tt = _Cns('TX_CNT');
	$___Ls->ik = 'sclaccform_enc';
	$___Ls->cnx->cl = 'ok';
	$___Ls->_strt();

	if(!isN($___Ls->gt->sbi)){	
		 
		$___Ls->qrys = sprintf("SELECT *
								FROM  ".TB_ORG_SDS_CNT."
								WHERE ".$___Ls->ik." = %s 
								LIMIT 1", GtSQLVlStr($___Ls->gt->i, "text")
							);
		
	}elseif($___Ls->_show_ls == 'ok'){
		
		$Ls_Whr = "	FROM "._BdStr(DBT).TB_SCL_ACC_FORM_LEADS."
						INNER JOIN "._BdStr(DBT).TB_SCL_ACC_FORM." ON id_sclaccform = sclaccformleads_form
					WHERE ".$___Ls->ino." != '' AND 
						   sclaccform_enc = '{$___Ls->gt->isb}'
						   ".$___Ls->sch->cod."
					ORDER BY ".$___Ls->ino." DESC";
		$___Ls->qrys = "SELECT *, 
						   (SELECT COUNT(*) $Ls_Whr) AS ".QRY_RGTOT." $Ls_Whr";
						   		   		
	}
	
	$___Ls->_bld();	//echo $___Ls->qrys;
	
?>
<?php if($___Ls->ls->chk=='ok'){ ?>

	<?php if(($___Ls->qry->tot > 0)){  ?>
	
		<table width="100%" border="0" cellpadding="0" cellspacing="0" class="Ls_Rg">
			<tr>
			    <th width="1%" <?php echo NWRP ?>><?php echo TX_FM_No ?></th>
			    <th width="5%" <?php echo NWRP ?>><?php echo TX_DTS ?></th>
				<th width="5%" <?php echo NWRP ?>><?php echo TX_FI ?></th>
				<th width="5%" <?php echo NWRP ?>><?php echo TX_EST ?></th>
			</tr>
			<?php do {  ?>
		  		<tr>
					<td align="left" <?php echo $_clr_rw ?>><?php echo $___Ls->ls->rw[$___Ls->ino]; ?></td>
				    <td width="30%" align="left" <?php echo $_clr_rw ?>>
					    <?php $array = json_decode($___Ls->ls->rw['sclaccformleads_lead'], true); ?>
					    <?php
						    
						    foreach ($array as $value => $val) {
							    
								echo ctjTx($val['name'],'in').': '.ctjTx($val['values'][0],'in').HTML_BR;
								
							}
						    
					    ?>
						
						
					    
					</td>
					<td align="left" <?php echo $_clr_rw ?>><?php echo Spn(_Tme($___Ls->ls->rw['sclaccformleads_fi'], 'sng')); ?></td>		
					<td align="left" <?php echo $_clr_rw ?>><?php echo Spn(mBln($___Ls->ls->rw['sclaccformleads_est']),'',mBln($___Ls->ls->rw['sclaccformleads_est'])); ?></td>	
				</tr>
		  	<?php } while ($___Ls->ls->rw = $___Ls->sql->fetch_assoc()); ?>
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

					<?php echo LsOrgSds(['id'=>'orgsdscnt_orgsds_new', 'v'=>'orgsds_enc', 'va'=>$___Ls->dt->rw['orgsdscnt_orgsds'], 'rq'=>1, 'org'=>$___Ls->gt->isb ]);
					$CntWb .= JQ_Ls('orgsdscnt_orgsds_new'); ?>
					
				</div>
				<div class="col_1">
					<div class="_new">
						<?php
							
			                echo HTML_inp_tx('cnt_nm', TT_FM_NM, ctjTx($___Ls->dt->rw['cnt_nm'],'in'), FMRQD);
			                echo HTML_inp_tx('cnt_ap', TX_AP, ctjTx($___Ls->dt->rw['cnt_ap'],'in'), FMRQD);
			               
			                $l_sx = __Ls([ 'k'=>'sx', 'id'=>'cnt_sx', 'va'=>$___Ls->dt->rw['cnt_sx'] , 'ph'=>FM_LS_SISSX ]);  
			                echo $l_sx->html; $CntWb .= $l_sx->js;
						          
						?>	  
						
						<div class="trb_smpr" style="display: block;">
							<?php $l = __Ls([ 'k'=>'emp_ars', 'id'=>'orgsdscnt_are', 'va'=>$___Ls->dt->rw['orgsdscnt_are'] ,'rq'=>2,  'ph'=>TX_SLCAR ]); 
			                echo $l->html; $CntWb .= $l->js; ?>	
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
								$l_dc = __Ls([ 'k'=>'cnt_dc', 
				                			'opt_v'=>'itm-sg', 
				                			'id'=>'cnt_dc_tp', 
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
							
							echo HTML_inp_tx('cnt_eml', TT_FM_EML, ctjTx($___Ls->dt->rw['cnt_eml'],'in'), FMRQD_EM);
							echo LsSis_Tel('cnt_tel_tp','id_sistel', '', FM_LS_SLTEL, 2); $CntWb .= JQ_Ls('cnt_tel_tp', FM_LS_SLTEL);
							echo LsSis_PsOLD('cnt_tel_ps','id_sisps', 57, '-', 2, '', '', 'iso'); $CntWb .= JQ_Ls('cnt_tel_ps', '-', '', 'psFlg', ['ac'=>'no']);
							echo HTML_inp_tx('cnt_tel', TX_NMR, '', FMRQD);
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

						echo LsOrgSds(['id'=>'orgsdscnt_orgsds', 'v'=>'orgsds_enc', 'va'=>$___Ls->dt->rw['orgsdscnt_orgsds'], 'rq'=>1, 'org'=>$___Ls->gt->isb ]);
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
        
        </style>
        </div>
    </form>
  </div>
</div>
<?php } ?>
<?php } ?>
