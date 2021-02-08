<?php 
	$_i = Php_Ls_Cln($_GET['_i']);
	$__id_r = Gn_Rnd(20);
	$__id_fm = 'FmEnc'.$__id_r;
?>
<div class="_fm_fnc"> 
    <div class="wrp">  
              
		<?php /*<div class="_img _hdr_bitly" id="__url_end"></div>*/ ?>
			
			
		<div id="<?php echo $__id_fm ?>_ld" class="_ld" style="display:none;"></div>	
		<div style="display: none" id="UrlS_<?php echo $__id_r ?>"><h2></h2></div>
			
			<div id="<?php echo $__id_fm ?>_flds">
  			
			<form action="" method="POST" <?php if($_GET['Sv'] != 'ok'){ ?>name="<?php echo $__id_fm ?>" id="<?php echo $__id_fm ?>" <?php }else{ ?> target="_blank" <?php } ?> >

			<?php echo HTML_inp_hd('_tp', $__prfx->tp); ?>   
			
			
            <div id="<?php echo $__id_fm ?>_flds">        
					 
					<div class="_ln1">  
						<div class="_d1">
							<?php echo LsUs('_actfl_us','id_us', $_GET['fl_actus'], 'Responsable (Profesional)', 2, ''); $CntWb .= JQ_Ls('_actfl_us', 'Responsable (Profesional)'); ?>
						</div>
                    </div>

					<ul>	
						<li class="_snd_fnc"><input type="button" class="btn" id="Do_Rqu" value="<?php echo 'Guardar' ?>" /></li>		           	   
					</ul>
                
					<?php 	
						
						echo $___Ls->bx_rld;
						
						$CntWb .= "	
													
							$('#Do_Rqu').click(function() {
								
								if( $('#{$__id_fm}').valid() ){
									
									swal({
										title: '".TX_ETSGR."',
										text: '".TX_DPLCT."',
										type: 'info',
										showCancelButton: true,
										confirmButtonColor: '#64b764',
										confirmButtonText:'".TX_ACPT."',
										cancelButtonText: '".TX_CNCLR."',
										showLoaderOnConfirm: true,
										closeOnConfirm: false
									},
									function(){
										
										$.ajax({
											type: 'POST',
											dataType: 'json',
											url: '".Fl_Rnd(FL_JSON_GN.__t('snd_ec_cpy',true))."&id=".$_i."',
											data: $('#{$__id_fm}').serialize(),
											beforeSend: function() {
												$('#{$__id_fm}_ld').fadeIn();
												$('#{$__id_fm}_flds').fadeOut();
											},
											success: function(d){
										     	if(d.e == 'ok'){
											     	
										            swal('".TX_APROEXT."');
										            
										            $.colorbox.close();
										            
										            _ldCnt({ 
														u:SUMR_Main.url['__ld_".$___Ls->bx_rld."'].lnk,
														c:SUMR_Main.url['__ld_".$___Ls->bx_rld."'].box
													});	

												}else{
													swal('Error', '".TX_NSAPRB."', 'error');
													$('#{$__id_fm}_flds').fadeIn();
												}
										    }
									    })
									  
									});
									
								}
								
							}); 
									
						";
					?>       		
				
				
			</div> 	 
				
		</form> 
          
    </div>
</div>