<?php 
	$_i = Php_Ls_Cln($_GET['_i']);
	$__id_fm = 'FmEnc'.$___Ls->id_rnd;
?>
<div class="_fm_fnc">
    <div class="wrp">
              
		<div class="_img _hdr_dwn" id="__url_end"></div>
			
		<div id="<?php echo $__id_fm ?>_ld" class="_ld" style="display:none;"></div>		

				<div id="<?php echo $__id_fm ?>_flds">

      
	        <form action="" method="POST" <?php if($_GET['Sv'] != 'ok'){ ?>name="<?php echo $__id_fm ?>" id="<?php echo $__id_fm ?>" <?php }else{ ?> target="_blank" <?php } ?> >
	
				<input name="MM_download" id="MM_download" type="hidden" value="MdlCnt" />
				<?php echo HTML_inp_hd('_tp', $___Ls->tpg); ?> 
				<?php echo HTML_inp_hd('_key', $___Ls->id_rnd); ?>   
				
	            <div id="<?php echo $__id_fm ?>_flds">        
			
		            	
		             	<?php /*$l = __Ls(['k'=>'dwn_frmt', 'id'=>'_frm', 'va'=>$___Ls->dt->rw['dwn_frm'] , 'ph'=>FM_LS_SLGN ]); echo $l->html; $CntWb .= $l->js;*/ ?>
		            	
		            	<!--<?php echo LsClAre([
								            	'id'=>'_cntAre',
								            	'v'=>'id_clare',
								            	'va'=>$___Ls->dt->rw['clare_prnt'],
								            	'rq'=>2,
								            	'mlt'=>'no'
											]); 
											
			            	$CntWb .= JQ_Ls('_cntAre',TX_ARE); 
			            ?>
						
						
						<?php echo LsMdl('_cntMdl', 'id_mdl', $___Ls->dt->rw['mdl_enc'], _MdlTx(TX_SLCMDL), 2, '', [ 'tp_k'=>$___Ls->tpg ]); $CntWb .= JQ_Ls('_cntMdl', _MdlTx(TX_SLCMDL));?> 
						<?php echo LsCntEst([ 'id'=>'_est', 'v'=>'siscntest_enc', 'rq'=>2, 'mlt'=>'ok', 'v_go'=>'enc', 'mdlstp'=>$___Ls->mdlstp->id ]); $CntWb .= JQ_Ls('_est', FM_LS_EST); ?> 
						<?php echo LsCntEstTp('_cntEst','id_siscntesttp', '', '', 2, 'ok'); $CntWb .= JQ_Ls('_cntEst', FM_LS_SLFAC);?>
						<?php echo LsSis_Md('_cntMd' ,'id_sismd', '','', 2, '', ['attr'=>['send-id'=>'sismd_enc']] ); $CntWb .= JQ_Ls('_cntMd', FM_LS_SLFAC);?>
						
						<?php if(DB_CL_ENC == '7d51bb17c7bf84009158bd691caccbdeabd3d4cf'){
							echo LsMdlSHrs('_cntSch','mdlssch_enc', '', TX_PSG_HRA, 2, 'ok' ); $CntWb .= JQ_Ls('_cntSch', FM_LS_SLFAC);
							echo LsUs('_cntUs','us_enc', '' ,'Usuarios', 2,'ok'); $CntWb .= JQ_Ls('_cntUs','Usuarios');
						} ?> 
												 
						<div class="_c3">  
							<div class="_d1">
								<?php //echo LsSis_MdlPrd('_prdapl', 'id_proprd','', 'Periodo Aplica', 2, 'ok', array('tp'=>$___Ls->tpg)); $CntWb .= JQ_Ls('_prdapl', 'Periodo Aplica'); ?>
							</div>	
				            <div class="_d2">
					            <?php //echo LsSis_MdlPrd('_prding', 'id_proprd','', 'Periodo de ingreso', 2, 'ok', array('tp'=>$___Ls->tpg)); $CntWb .= JQ_Ls('_prding', 'Periodo de ingreso'); ?> 
				            </div>
				            <div class="_d3">
					            <?php //echo LsCntTp('_u','id_siscnttp', '', '', 2, ''); $CntWb .= JQ_Ls('_u', FM_LS_VNCU); ?>  
				            </div>
	                    </div>-->
						
						
					        
						<div class="_c2">  
				            <div class="_d1"><?php echo SlDt([ 'id'=>'_f_in', 'lmt'=>'no', 'yr'=>'ok', 'mth'=>'ok', 'rq'=>'no', 'ph'=>TX_ORD_FIN ]); ?></div>
							<div class="_d2"><?php echo SlDt([ 'id'=>'_f_out', 'lmt'=>'no', 'yr'=>'ok', 'mth'=>'ok', 'rq'=>'no', 'ph'=>TX_ORD_FOU ]); ?></div>
							
	                    </div>
	                    
	                	<!-- 
	                    <div class="_c2">  
							<div class="_d1"><?php echo OLD_HTML_chck('_inc_dc', 'Sin Documento','', 'in');  ?></div>	
				            <div class="_d2"><?php echo OLD_HTML_chck('_inc_eml', 'Sin E-Mail','', 'in');  ?></div>
							
	                    </div>
	                    <div class="_c2">  
		                    <div class="_d1"><?php echo OLD_HTML_chck('_inc_tel', 'Sin Telefono','', 'in');  ?></div>
							<div class="_d2"><?php echo OLD_HTML_chck('_eml_bad', 'E-mails Errados','', 'in'); ?></div>	
	                    </div>
	                    <div class="_c2">  
				            <div class="_d1"><?php echo OLD_HTML_chck('_tel_bad', 'Telefonos Errados','', 'in');  ?></div>
							<div class="_d2"><?php echo OLD_HTML_chck('_eml_snd', 'Enviar e-mail','', 'in');  ?></div>
	                    </div>
	                    -->
	                    
						<ul>	
							<li class="_snd_fnc"><input type="button" class="btn" id="Sve_Dwn" value="<?php echo 'Descargar' ?>" /></li>		           	   		</ul>
						
						<!-- WebSocket Temporal -->
						<script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/2.1.1/socket.io.js"></script>
						<?php 	
							
							$CntWb .= "	
	

										
								function __ShwDwn(){ _ldCnt({ u:'".FL_LS_GN."?_t=dwn&Rd='+Math.random() }); }		
														

								$('#Sve_Dwn').off('click').click(function() {
									if( $('#{$__id_fm}').valid() ){
										
										$.ajax({
											type: 'POST',
											dataType: 'json',
											url:'".FL_JSON_GN.__t('dwn_cnt_appl', true).$___Ls->ls->vrall."',
											data: $('#{$__id_fm}').serialize(),
											beforeSend: function() {
												$('#{$__id_fm}_ld').fadeIn();
												$('#{$__id_fm}_flds').fadeOut(); 
											},
											success: function(d) {

											    if(d.e == 'ok'){
													$.colorbox.close();	
											    }else{
												    $('#{$__id_fm}_flds').fadeIn();
											    }
											    
											}, 
											complete: function(){
												$.colorbox.close();
												__ShwDwn();
												$('#{$__id_fm}_ld').fadeOut();
											}
										});
	
									}
								}); 
	
										
							";
						?>       		
	    
					
				</div> 	 
					
			</form>   
		</div> 	          
    </div>
</div>