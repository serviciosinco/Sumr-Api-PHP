<?php 
	$_i = Php_Ls_Cln($_GET['_id']);
	$__id_r = Gn_Rnd(20);
	$__id_fm = 'FmEnc'.$__id_r;
?>
<div class="_fm_fnc"> 
    <div class="wrp">  
              	
        <style> 
	        ._fm_fnc ._hdr_bitly{ background-image: url('../../../_img/estr/hdr_bitly.jpg') !important; height: 190px !important; }
	        #dshgrph_tt{ background-color: rgba(202, 202, 202, 0.61); }
	        .frm_dsh_grph{ margin-top: 30px; }
	        ._num{ width: 100px; display: inline-table; margin-left: 6px; height: 30px; font-size: 15px; border: 1px solid #7b7a7a; }
	        .dv_col_prs{ text-align: center; }
	        .dv_col_dmo{ height: 100px; margin: auto; width: 80%; margin-top: 20px; text-align: center; display: flex;}
	        .dv_bx_dmo{ border: 1px solid #6f6f9e; display: inline-table; height: 100%; }
	        .dv_bx_dmo span{ color:#7b7a7a; font-family: Economica; display: block; text-align: center;margin-top: 30px;}
	        .wrp h3, .wrp h4{ color:#7b7a7a;text-align:center; font-family: Economica; }
 		</style>		
		
		<div class="_img _hdr_bitly" id="__url_end"></div>
			
		<div id="<?php echo $__id_fm ?>_ld" class="_ld" style="display:none;"></div>	
		<div style="display: none" id="UrlS_<?php echo $__id_r ?>"><h2></h2></div>
			
		<div id="<?php echo $__id_fm ?>_flds" class="frm_dsh_grph">
	  		<form style="width: 80%;margin:auto;" action="" method="POST" <?php if($_GET['Sv'] != 'ok'){ ?>name="<?php echo $__id_fm ?>" id="<?php echo $__id_fm ?>" <?php }else{ ?> target="_blank" <?php } ?> >
	
				<input name="MM_download" id="MM_download" type="hidden" value="MdlCnt" />
				<?php echo HTML_inp_hd('_tp_hdn', ''); ?>   
				
				<div id="<?php echo $__id_fm ?>_flds">        
						 
					<div class="_ln1">
						<?php echo h3(TX_COLS. TX_PRSLCLM, '', ''); ?>  
						<?php echo LsNum('dshcolprs_cant',6, ''); $CntWb .= JQ_Ls('dshcolprs_cant',FM_LS_ASGNTRS); ?>
						<div class="dv_col_prs" style="display:none;">
							<?php echo h4(TX_SMCLMS,'',''); ?>
						</div>
						<div style="display: none;" class="dv_col_dmo"></div>
						<br><br>
						<ul>	
							<li class="_snd_fnc"><input type="button" class="btn" id="Do_Rqu" value="<?php echo TXBT_GRDR ?>" /></li>	           	   
						</ul>
	            
						<?php 	
							$CntWb .= "	
							
								$('#dshcolprs_cant').change(function(){
									var _cant = $(this).val();
									var _vlr_u = (100/_cant).toFixed(2);
									
									if((_cant*_vlr_u) > 100){
										do {
										   _vlr_u = (_vlr_u-0.1).toFixed(2);
										} while (_vlr_u > 100);
									}
									
									$('.dv_col_prs, .dv_col_dmo').show('slow');
									$('._num, .dv_bx_dmo').remove('');
									for(var i = 1; i <= _cant; i++){
										$('.dv_col_prs').append('<input type=\"number\" id=\"w_'+i+'\" rel=\"'+i+'\" name=\"w_'+i+'\" min=\"1\" max=\"100\" class=\"_num\"  value=\"'+_vlr_u+'\"/>');
										$('.dv_col_dmo').append('<div class=\"dv_bx_dmo dv_bx_dmo_'+i+'\" rel=\"'+i+'\" style=\"width:'+_vlr_u+'%;\"><span>Columna '+i+'</span></div>');
									}
									$('._num').change(function(){
										var _id = $(this).attr('rel');
										var _val = $(this).val();
										$('.dv_bx_dmo_'+_id).css('width', _val+'%');
									});
								});
							
								
							
								$('#Do_Rqu').click(function() {
									var _frm = $('#".$__id_fm."').serialize();
									SUMR_Main.ld_abrt({ p:'col_prs' });
							
									SUMR_Main.ibx['col_prs'] = $.ajax({
														type: 'POST',
														dataType: 'json',
														url:'".FL_JSON_GN.__t('dsh', true)."',
														data: (_frm+'&_tp=_dsh_col_prs&_id_dsh=".$_i."'),
														beforeSend: function() {
															$('#{$__id_fm}_ld').fadeIn();
															$('#{$__id_fm}_flds').fadeOut(); 
														},
														success: function(d) {
														    
														    $('#{$__id_fm}_ld').fadeOut();
														    
														    if(d.e == 'ok'){
															    var __rl = 'indx';
																var __lnk = '".Fl_Rnd(FL_DT_GN.'?')."&_dsh_edt=ok&_t=' + __rl;
																_ldCnt({ u:__lnk });
																$.colorbox.close();
														    }else{
															    swal('Error!', d.w, 'error'); 
															    $('#{$__id_fm}_flds').fadeIn();
														    }
														    
														}
													});
								}); 
							";
						?>    
					
				</div> 	 
					
			</form> 
		</div>
		<?php $CntWb .= ""; ?>             
    </div>
</div>
