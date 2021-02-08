<div class="ticket_detail"> 
	<div class="wrp">
		<div class="FmTb">	
			<section class="_cvr" style="background-color:#60C198;">
				<iframe src="<?php echo DMN_ANM; ?>ticket/index.html" frameborder="0" width="100%" scrolling="no" height="190"></iframe>			
			</section>
			<div id="<?php echo DV_GNR_FM.$__prfx_fm ?>" class="ticket_detail_c">				
				<?php $___Ls->_bld_l_hdr(); ?>
				<div id="<?php echo $___Ls->fm->fld->id ?>" class="<?php echo DV_GNR_FM_CMP ?>">
					<div class="ln_1">
						<?php								
							$__us = GtUsDt(1, 'chk_tck');	
							echo HTML_inp_hd('_us', $__us->enc); 
							
							$__obs = GtUsDt(1, 'chk_obs');
							echo HTML_inp_hd('_obs', $__obs->enc); 
									
						?>
						
						<?php echo HTML_inp_tx('_tt', TX_SBJCT, '', FMRQD); ?>
						<?php echo HTML_textarea('tra_dsc', 'Describe claramente tu solicitud para dar una respuesta mas eficiente...', ''); ?> 
						
						<button class="send" id="btn_sve_<?php echo $___Ls->id_rnd; ?>">Guardar</button>
						
						<?php 	
							$_tracol_grp = GtTraColDt_Chk(['tck'=>'ok']);
							echo HTML_inp_hd('_col', $_tracol_grp->enc); 		
						?>
					</div>        
				</div>
				
			</div>              
		</div>
	</div>
</div>	
<div class="ticket_detail_bck"></div>
<?php 
	$CntWb .= "
		
		SUMR_Ld.f.css({
			h:'tra',
			tag:'ok',
			c:function () {
			
				$('#btn_sve_".$___Ls->id_rnd."').click(function(){

					var _tt = $('#_tt').val();
					var _dsc = $('#tra_dsc').val();		
					var _us = $('#_us').val();
					var _col = $('#_col').val();
					var _obs = $('#_obs').val();
					
					
					if(!isN(_tt) && !isN(_dsc)){
						
						swal({
							title: '".TX_ETSGR."',              
							text: '".TX_SWAL_SVE."!',  
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
								t:'tra',
								us: _us,
								col: _col,
								tp:'new_tra',
								dsc: _dsc,
								obs: _obs,
								tt: _tt,
								_bs:function(){
									$('.ticket_detail').addClass('_ld');	
								},
								_cl:function(_r){ 
									if(!isN(_r)){ 

										if(_r.e == 'ok' && !isN( _r.enc ) && !isN( _r.d ) && !isN( _r.d.tckid ) ){

											var scss_f = function(){
												swal({
													title: 'Tu ticket es el #'+_r.d.tckid,
													text: '¿Quieres ver el detalle de tu ticket?',  
													type: 'info',
													showCancelButton: true,
													confirmButtonText: 'Si',      
													cancelButtonText: 'No',           
													closeOnConfirm: true
												},
												function(ic){
													if(ic){
														SUMR_Tra.bxajx.enc = _r.enc;
														SUMR_Tra.f.Shw({ o:'ok' });
													}
												});
											};

											if( $('#Dsh_Tra').length > 0 ){

												var d = [];
													d = _r.d;
			
												SUMR_Tra.f.add({ enc:_r.d.enc, d:d });
												scss_f();

											}else{

												scss_f();

											}

											$.colorbox.close();

										}
									}
								},
								_cm:function(){
									$('.ticket_detail').removeClass('_ld');	
								}
							});			
						});
						
					}
	
				});
			}
			
		});

	"; 

?>	