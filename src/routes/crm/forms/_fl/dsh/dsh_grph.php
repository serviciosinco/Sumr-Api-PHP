<?php 
	$_i = Php_Ls_Cln($_GET['_id']);
	$__id_r = Gn_Rnd(20);
	$__id_fm = 'FmEnc'.$__id_r;
	
	//Verifica si es nueva grafica o si es para editar
	$grphRow = GtGrphRowDt($_i, ['tp'=>'grph_bx_mod']);
	
	foreach($grphRow as $_k => $_v){
		$_tt = $_v->tt;
		$_grph = $_v->grph;
		$_dms = $_v->dms;
		$_row = $_v->bx;
		$_mtrc = $_v->mtrc;
		$_id_grphrow = $_v->id_grphbx;
		
		$_clr_bc = $_v->clr_bc;
		$_clr = $_v->clr;
	}
	
?>
<div class="_fm_fnc dsh_slc_grph"> 
    <div class="wrp">  	
		
		<div class="bnr">
			<iframe src="<?php echo DMN_ANM; ?>anm_grph/index.html?Rnd=<?php echo Gn_Rnd(20); ?>" height="180" frameborder="0" width="500px" style="margin-top: 50px;"></iframe>
			<div class="nav">
				<ul>	
					<li class="_snd_fnc"><input type="button" class="btn" id="Do_Rqu" value="<?php echo TXBT_GRDR ?>" /></li>		           	   
				</ul>
			</div>	
		</div>	
	
		<div id="<?php echo $__id_fm ?>_ld" class="_ld" style="display:none;"></div>	
		<div style="display: none" id="UrlS_<?php echo $__id_r ?>"><h2></h2></div>
			
		<div id="<?php echo $__id_fm ?>_flds" class="frm_dsh_grph">
	  		<form style="width: 98%;" action="" method="POST" <?php if($_GET['Sv'] != 'ok'){ ?>name="<?php echo $__id_fm ?>" id="<?php echo $__id_fm ?>" <?php }else{ ?> target="_blank" <?php } ?> >
	
				<input name="MM_download" id="MM_download" type="hidden" value="MdlCnt" />
				<?php echo HTML_inp_hd('_tp_hdn', ''); ?>   
				
				<div id="<?php echo $__id_fm ?>_flds">        
						 
					<div class="_ln1">
						
						<div class="dshgrph_clr_tt _d1">
							<?php echo _HTML_Input('dshgrph_tt', TX_TT, $_tt, '').HTML_BR; ?>
							<div class="dshgrph_clr_tb">
								<div class="c1">
									<label for="dshgrph_clr_bc" class="dshgrph_clr"><?php echo TX_BCKG ?></label>
									<?php echo HTML_inp_clr([ 'id'=>'dshgrph_clr_bc', 'plc'=>TX_BCKG, 'vl'=>($_clr_bc!=NULL && $_clr_bc!='')?$_clr_bc : "#dadada" ]); ?>
								</div>
								<div class="c2">
									<label for="dshgrph_clr" class="dshgrph_clr"><?php echo TX_NM_CL ?></label>
									<?php echo HTML_inp_clr([ 'id'=>'dshgrph_clr', 'plc'=>TX_NM_CL, 'vl'=>$_clr ]); ?>
								</div>
							</div>
						</div>

						<?php
	                        
	                        //Si la grafica existe, que muestre las dimensiones que contiene
	                        if($_dms != '' && $_row != ''){
		                        $_sve = "MM_update";
		                       	$_shw = "_Shw";
	                    	}else{
		                    	$_sve = "MM_insert";
	                    	}
	                        
						?>
						
						<?php echo LsGrph('id_grph','id_grph', $_grph, FM_LS_ASGNTRS, 1, ''); $CntWb .= JQ_Ls('id_grph',FM_LS_ASGNTRS); ?>
						<div class="_dshdms <?php echo $_shw; ?>">
							<?php echo LsDms('id_dshdms','id_dshdms', $_dms, TX_DIMNS, 1); $CntWb .= JQ_Ls('id_dshdms',FM_LS_ASGNTRS); ?>
						</div>
						<div class="_dshmtrc <?php echo $_shw; ?>">
							<?php echo LsMtrc('id_dshmtrc','id_dshmtrc', $_mtrc, TX_DIMNS, 1, '', $_dms); $CntWb .= JQ_Ls('id_dshmtrc',FM_LS_ASGNTRS); ?>
						</div>
						<div class="dshgrph_dms" id="dshgrph_div"></div>
                        
	                </div><br>

					<?php 	
						$CntWb .= "	
						
							$('#id_grph').change(function() {
								
								var _grph = $(this).val();
								$('._dshdms, ._dshmtrc').removeClass('_Shw');
								$('#id_dshdms, #id_dshmtrc').html(''); $('#id_dshdms, #id_dshmtrc').val('');
								
								Grph_Rqu({ 
									'_tp':'_dsh_dms_ls',
									'_grph':_grph,
									_cl:function(_r){
										if(!isN(_r)){
											$('._dshdms').addClass('_Shw');
											if(_r.e == 'ok'){
												$.each(_r.ls, function(k, v) {
													if(!isN(v)){
														$('#id_dshdms').append('<option></option>><option value=\"'+v.id+'\">'+v.nm+'</option>');
												    }
												});
											}
										}
									} 
								});
                    		});
                    		
                    		$('#id_dshdms').change(function() {
								
								var _dms = $(this).val();
								$('._dshmtrc').removeClass('_Shw');
								$('#id_dshmtrc').html(''); $('#id_dshmtrc').val('');
								
								Grph_Rqu({ 
									'_tp':'_dsh_mtrc_ls',
									'_dms':_dms,
									_cl:function(_r){
										if(!isN(_r)){
											$('._dshmtrc').addClass('_Shw');
											if(_r.e == 'ok'){
												$.each(_r.ls, function(k, v) {
													if(!isN(v)){
														$('#id_dshmtrc').append('<option value=\"'+v.id+'\">'+v.nm+'</option>');
												    }
												});
											}
										}
									}
								});
                    		});
                    		
                    		function Grph_Rqu(p=null){
		
								if (SUMR_Main.onl() && isN( SUMR_Main.ibx['grph_rq'] ) ){
					
									try{
										SUMR_Main.ibx['grph_rq'] = $.ajax({
																type:'POST',
																url: '".Fl_Rnd(FL_JSON_GN.__t('dsh',true))."',
																data: p,
																beforeSend: function() {
																	if(!isN(p._bs)){ p._bs(); }
																},
																error:function(e){
																	if(!isN(p._w)){ p._w(e); }
																},
																success:function(e){	
																	SUMR_Main.ibx['grph_rq'] = '';
																	if(!isN(e.w)){ swal('Error!', e.w, 'error');  }
																	if(!isN(p._cl)){ p._cl(e); }
																},
																complete:function(e){
																	SUMR_Main.ibx['grph_rq'] = '';
																}
															});	
										
									}catch(e) {
										SUMR_Main.log.f({ t:'Error', m:e });
									}
														
								}
								
							}
						
							$('#Do_Rqu').click(function() {
								
								if( isN( $('#id_grph').val() ) ){
									swal('Alerta!', '".TX_SLCGRF."', 'error');
								}else if( isN( $('#id_dshdms').val() ) ){
									swal('Alerta!', '".TX_SLCDMS."', 'error');
								}else if( isN( $('#id_dshmtrc').val() ) ){
									swal('Alerta!', '".TX_SLCMTRC."', 'error');
								}else{
									if( $('#{$__id_fm}').valid() ){
										
										var _tt = $('#dshgrph_tt').val();
										
										var _clr_bc = $('#dshgrph_clr_bc').val();
										var _clr = $('#dshgrph_clr').val();
										
										var _tp = $('#id_grph').val();
										var _dms = $('#id_dshdms').val();
										var _mtrc = $('#id_dshmtrc').val();

										SUMR_Main.ld_abrt({ p:'grp' });
							
										SUMR_Main.ibx['grp'] =	$.ajax({
											
																	type: 'POST',
																	dataType: 'json',
																	url:'".FL_JSON_GN.__t('grph_bx', true)."',
																	data: ('_tp='+_tp+'&_dms='+_dms+'&_mtrc='+_mtrc+'&_tt='+_tt+'&_bx='+".$_i."+'&_sve=".$_sve."&id_grphbx=".$_id_grphrow."&_clr='+_clr+'&_clr_bc='+_clr_bc),
																	beforeSend: function() {
																		$('#{$__id_fm}_ld').fadeIn();
																		$('#{$__id_fm}_flds').fadeOut(); 
																	},
																	success: function(d) {
																	    
																	    $('#{$__id_fm}_ld').fadeOut();
																	    
																	    if(d.e == 'ok'){
																		    
																		    var __rl = 'indx';
																		    
																			var __lnk = '".Fl_Rnd(FL_DT_GN.'?')."&_dsh_edt=ok&_t=' + __rl;
																			
																			_ldCnt({ 
																				u:__lnk,
																				_cm:function(){
																					SUMR_Main.pnl.f.shw();
																				}
																			});
																			
																	    }else{
																		    
																		    $('#{$__id_fm}_flds').fadeIn();
																		    
																	    }
																	    
																	}
																	
																});
		
									}
								}
							}); 
						";
					?>    
					
				</div> 	 
					
			</form> 
		</div>
		<?php $CntWb .= ""; ?>             
    </div>
</div>

<style> 
	        
	.dsh_slc_grph ._hdr_bitly{ background-image: url('../../../_img/estr/hdr_bitly.jpg') !important; height: 190px !important; }
	.dsh_slc_grph input[type=text]{ background-color: transparent !important; font-family: Economica; font-size: 30px; text-transform: uppercase; border: 2px dashed #dfe1e2; padding-right: 15%; }
	.dsh_slc_grph input[type=text]:hover,
	.dsh_slc_grph input[type=text]:focus{ border-style: solid; }
	
	
	
	
	.dsh_slc_grph .frm_dsh_grph{ margin-top: 30px; padding: 30px 40px; }
	
	.dsh_slc_grph .dshgrph_clr_tt{ position: relative; display: flex; margin-bottom: 20px; }
	.dsh_slc_grph .dshgrph_clr_tt .dshgrph_clr_tb{ position: absolute; right:0; top: 15px; margin: auto; text-align: center; border-spacing: 10px; border-collapse: separate; width: 25%; text-align: right; padding-right: 10px; }
	.dsh_slc_grph .dshgrph_clr_tt .dshgrph_clr_tb .c1,
	.dsh_slc_grph .dshgrph_clr_tt .dshgrph_clr_tb .c2{ display: inline-block; }
	.dsh_slc_grph .dshgrph_clr_tt .dshgrph_clr_tb label{ display: none !important; }
	
	
	.dsh_slc_grph ._dshdms, ._dshmtrc{ display: none; }
	.dsh_slc_grph ._dshdms._Shw, ._dshmtrc._Shw{ display: block!important; }
	
	.dsh_slc_grph .bnr{ background-color: #ffab54; width: 100%; text-align: center; position: relative; }
	.dsh_slc_grph .bnr .nav{ position: absolute; right: 20px; bottom: -18px; }
	.dsh_slc_grph .bnr .nav ._snd_fnc{}
	.dsh_slc_grph .bnr .nav ._snd_fnc input[type=button]{ padding: 20px 25px; font-size: 17px; }
	


	.dsh_slc_grph input[type="color"]{ -webkit-appearance: none; border:2px solid #ced5d8; width: 30px; height: 30px; border-radius:200px; -moz-border-radius:200px; -webkit-border-radius:200px; overflow: hidden; }
	.dsh_slc_grph input[type="color"]::-webkit-color-swatch-wrapper{ padding: 0; border-radius:200px; -moz-border-radius:200px; -webkit-border-radius:200px; overflow: hidden; }
	.dsh_slc_grph input[type="color"]::-webkit-color-swatch{ border: none; border-radius:200px; -moz-border-radius:200px; -webkit-border-radius:200px; overflow: hidden; }


</style>