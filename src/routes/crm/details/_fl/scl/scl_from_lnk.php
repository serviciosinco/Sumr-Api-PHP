<?php 
		
		$__CntIn = new CRM_Cnt();
		
	//---------------------- VARIABLES GET ----------------------//
		
		$__nm = Php_Ls_Cln($_POST['_nm']);
		$__eml = Php_Ls_Cln($_POST['_eml']);
		$__nor = Php_Ls_Cln($_POST['_nor']);
		
	//---------------------- FIX DATA ----------------------//
		
		$__nm_fx = __NmFx($__nm);
	
	//---------------------- INCLUSIÓN DE ARCHIVOS ----------------------//	
	
	if(!isN($__eml) || !isN($__nor)){
		
		if(!isN($__eml)){
			foreach($__eml as $__eml_k=>$__eml_v){
				$__CntIn->cnt_eml = filter_var($__eml_v, FILTER_SANITIZE_EMAIL);
				$__Chk = $__CntIn->_Cnt();	
				if(!isN($__Chk->enc)){ 
					$__dt_cnt = GtCntDt([  't'=>'enc', 'id'=>$__Chk->enc ]);	
					if(!isN($__dt_cnt->id)){ break; }
				}
			}
		}
		
		if(!isN($__nor) && isN($__dt_cnt->id)){
			foreach($__nor as $__nor_k=>$__nor_v){
				$__CntIn->cnt_dc = filter_var($__nor_v, FILTER_SANITIZE_EMAIL);
				$__Chk = $__CntIn->_Cnt();	
				if(!isN($__Chk->enc)){ 
					$__dt_cnt = GtCntDt([ 't'=>'enc', 'id'=>$__Chk->enc ]);	
					if(!isN($__dt_cnt->id)){ break; }
				}
			}
		}
	
	}
	
	if(isN($__dt_cnt->id) && !isN($__nor)){
		$__teldt = GtCntTelDt([ 'id'=>$__nor ]);
		if(!isN($__teldt->cnt->id)){ $__dt_cnt = GtCntDt([ 'id'=>$__teldt->cnt->id ]); }
	}
	
?>
	
<div class="lead_detail from_scl _new">
	
	<div class="_c">
		
		<div class="_csub _c1">
			<h2 class="_data_fnd">Datos Encontrados <span>(Conversación)</span></h2>
			
			<figure></figure>
			
			<p class="_data_p">Encontramos esta información dentro de la conversación puede usarse para crear el lead dentro de la plataforma o actualizar información sobre un registro ya existente.</p>
			<?php 
				
				if(!isN($__eml)){
					echo '<ul class="fnd_eml">';
					foreach($__eml as $__eml_k=>$__eml_v){
						echo li( $__eml_v );
					}	
					echo '</ul>';
				}else{
					$__non = 'ok';
				}
				
				
				if(!isN($__eml)){ 
					
					$__non = '';
					
					echo '<ul class="fnd_nro">';
					foreach($__nor as $__nor_k=>$__nor_v){
						echo li( $__nor_v );
					}	
					echo '</ul>';
				}else{
					$__non = 'ok';
				}
				
				
				if($__non == 'ok'){ echo h3('No se encontraron documentos o <br>teléfonos en la conversación'); }
					
			?>
		</div>
		
		<div class="_csub _c2">
			
			<?php if(isN($__dt_cnt->id)){ ?>
			
				
				<h2 class="_exst">Ingresar <span>(datos)</span></h2>
				
				<div class="cnt_frst">
											
					<div class="fld dc">
						<div class="c1">
							<?php 
								$l = __Ls([ 'k'=>'cnt_dc', 
											'opt_v'=>'itm-sg', 
											'id'=>'cntdc_tp', 
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
							<?php echo HTML_inp_tx('cnt_dc', TT_FM_ID, ctjTx($___Ls->dt->rw['cnt_dc'],'in'), ''); ?>
						</div>
					</div>

					<?php echo HTML_inp_tx('cnt_nm', TT_FM_NM, $__nm_fx->nm, FMRQD); ?> 
					<?php echo HTML_inp_tx('cnt_ap', TT_FM_AP, $__nm_fx->ap, FMRQD); ?>
					
					<?php echo HTML_inp_tx('cnt_eml', TT_FM_EML, $__eml[0], ''); ?> 
					
					<div class="_intel">
						
						<?php echo __SbT([ 't'=>TX_TLFN, 'i'=>'cnt_tel' ]); ?>
						<?php echo LsSis_Tel('cnt_tel_tp','id_sistel', '', FM_LS_SLTEL, 2); $CntWb .= JQ_Ls('cnt_tel_tp', FM_LS_SLTEL); ?>
						<?php 
								
							$CntWb .= "
								
								$('#cnt_tel_tp').change(function() {
									
									__id_tp = $(this).val();
									__id_ext = $('#cnt_tel_ext');
									__id_tel = $('#cnt_tel'); 
									__sl = $('#cnt_tel_tp option:selected');
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
									
									echo LsSis_PsOLD('cnt_tel_ps','id_sisps', 57, '-', 2, '', '', 'iso'); 
									$CntWb .= JQ_Ls('cnt_tel_ps', '-', '', 'psFlg', ['ac'=>'no']); 
									
								?>
								
							</div>
							<div class="c2">
								<div class="tel"><?php echo HTML_inp_tx('cnt_tel', TX_NMR, '', ''); ?></div>
								<div class="ext"><?php echo HTML_inp_tx('cnt_tel_ext', TX_EXT, '', FMRQD_NMR, ' style="display:none;" '); ?></div>
							</div>
						</div>
					
					</div>
					
				</div>
			
								
			<?php }else{ ?>
				
				
				<h2 class="_exst">Datos en la Nube <span>(SUMR)</span></h2>
				
				<ul class="data-basic">
					<?php echo li($__dt_cnt->nm.' '.$__dt_cnt->ap, 'bsc'); ?>
					<?php echo li($__dt_cnt->dc_tp.' '.$__dt_cnt->dc, 'doc'); ?>
					
					<?php if(!isN($__dt_cnt->eml)){?>	
						<?php foreach($__dt_cnt->eml as $_eml_k=>$_eml_v){ echo li($_eml_v->v, 'eml'); } ?>	
					<?php } ?>
					
					<?php if(!isN($__dt_cnt->tel_all)){ ?>	
						<?php 
							
							foreach($__dt_cnt->tel_all->ls as $_tel_k=>$_tel_v){ 
								$img_th = _ImVrs([ 'img'=>$_tel_v->img_ps, 'f'=>DMN_FLE_PS ]);
								echo li(Spn('','','','background-image:url('.$img_th->th_50.')').$_tel_v->tel, 'tel'); 
							} 
							
						?>	
					<?php } ?>
					
				</ul>                       
				
				<div class="_lnk">
					No esta aun relacionado
					<button>Relacionar perfil</button>
				</div>
				
				
			<?php } ?>

		</div>
		
	</div>
	
</div>