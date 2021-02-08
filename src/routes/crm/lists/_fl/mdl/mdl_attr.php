<?php
if(class_exists('CRM_Cnx')){	
		
	$___Ls->gt->pr = 'Dt';	
	$___Ls->hb->mod = 'ok';
	$___Ls->_strt();
	$___Ls->_bld(); 	
?>
	<div class="FmTb">
		<div id="<?php echo $___Ls->fm->bx->id ?>" class="<?php echo DV_GNR_FM_BX ?>">
			<form method="POST" name="<?php echo $___Ls->fm->id; ?>" target="_self" id="<?php echo $___Ls->fm->id; ?>" >
				
				<div class="Tt_Tb _anm">
					<div class="__hdr_btn">
						<div class="___edt">
							<button id="Sve_Dwn" name="Sve_Dwn" class="_anm "><?php echo Spn(TXBT_GRDR,'','_anm'); ?></button>
						</div>
					</div>
				</div>
				
				<?php echo HTML_inp_hd('mdl_rel', $__i); ?>	
				<div id="<?php echo $___Ls->fm->fld->id ?>" class="<?php echo DV_GNR_FM_BX ?> dsh_cnt dsh_mdl_attr">
					
					<ul id="bx_mdl_attr<?php echo $___Ls->id_rnd; ?>" class="_ls _anm dls">
						
						<li class="sch fll"><?php echo HTML_inp_tx('sch_sch_'.$___Ls->id_rnd, TX_SEARCH, ''); ?></li>
						
						<?php 
							

							$cols = GtClRow_Ls($__t2, $__i);
							$__mdl_cnt_tabs = __LsDt([ 'k'=>'mdls_tp_attr' ]);
							
							foreach($cols as $k=>$v){	
									
								echo '<li class="cols_'.$v->cols.' _anm itm">';
								
								foreach($v->flds->ls as $_k=>$_v){
								     
									$tt =  $__mdl_cnt_tabs->ls->mdls_tp_attr->{$_v->fld}->tt;	
									$cns =  $__mdl_cnt_tabs->ls->mdls_tp_attr->{$_v->fld}->cns;	
									$id =  $__mdl_cnt_tabs->ls->mdls_tp_attr->{$_v->fld}->enc;
									
									if($__mdl_cnt_tabs->ls->mdls_tp_attr->{$_v->fld}->dte->vl == 1){ 
										echo SlDt([ 'id'=>$id, 'va'=>$_v->vl_mdl->vl, 'rq'=>'no', 'ph'=>$tt, 'lmt'=>'no', 'yr'=>'ok', 'cls'=>CLS_CLND ]);
									}elseif($__mdl_cnt_tabs->ls->mdls_tp_attr->{$_v->fld}->chk->vl == 1){ 
										echo OLD_HTML_chck($id.'_old', $tt,$_v->vl_mdl->vl, 'in');
										echo HTML_inp_hd($id, $_v->vl_mdl->vl);
									}elseif($__mdl_cnt_tabs->ls->mdls_tp_attr->{$_v->fld}->hour->vl == 1){
										echo SlDt([ 'id'=>$id, 'va'=>$_v->vl_mdl->vl, 'rq'=>'no', 'ph'=>$tt, 'lmt'=>'no', 't'=>'hr', 'cls'=>CLS_CLND ]);
									}elseif($__mdl_cnt_tabs->ls->mdls_tp_attr->{$_v->fld}->lsus->vl == 1){
										echo LsUs($id,'id_us', $_v->vl_mdl->vl, '', 2); $CntWb .= JQ_Ls($id,'');
									}elseif($__mdl_cnt_tabs->ls->mdls_tp_attr->{$_v->fld}->lslgr->vl == 1){
										$l = __Ls(['k'=>$__t2.'_lgr','id'=>$id,'ph'=>TX_WHR,'va'=>$_v->vl_mdl->vl]); 
										echo $l->html; $CntWb .= $l->js;
									}elseif($__mdl_cnt_tabs->ls->mdls_tp_attr->{$_v->fld}->lscd->vl == 1){
										echo LsCdOld(['id'=>$id, 'v'=>'id_siscd', 'va'=>$_v->vl_mdl->vl, 'rq'=>1 ]); 
										$CntWb .= JQ_Ls($id,FM_LS_SLCD);	
									}else{
										echo HTML_inp_tx($id, $tt, $_v->vl_mdl->vl, 'in','','','','');
									}
								}
								
								echo '<div style="display:none;">'.$tt.'</div>';
								echo '</li>';

							}
							
							
							
							$CntWb .= "SUMR_Main.LsSch({ str:'#sch_sch_".$___Ls->id_rnd."', ls:$('#bx_mdl_attr".$___Ls->id_rnd." > li.itm ') }); ";
							
							
						?>
					
						
					</ul>
							
				</div>
			</form>
		</div>
	</div>
<?php } ?>
<style>

	.cols_2 .___txar._anm ,
	.cols_2 .styled-select-bx {width: 50%;display: inline-flex;}
	
	.dsh_mdl_attr{ margin-top: 60px; }
	.dsh_mdl_attr ul{ width: 100%; padding: 0; margin: 0; list-style: none; }


</style>
<?php
	
	$CntWb .= "		
				
		$('input:checkbox').change(function(){
			
			var id = $(this).attr('id');
			var new_id = id.replace('_old', '');
			
			if($(this).is(':checked')) {
            	$('#'+new_id).val(1);
			}else{
				$('#'+new_id).val(2);
			}
		});			

		$('#Sve_Dwn').off('click').click(function(e) {
			
			e.preventDefault();
		
			swal({
				title: '".TX_SWAL_SVE."',
				type: 'warning',
				showCancelButton: true,
				confirmButtonColor: '#64b764',
				confirmButtonText:'".TX_ACPT."',
				cancelButtonText:'".TX_CNCLR."',
				closeOnConfirm: true
			},
			function(){
				$.ajax({
					type: 'POST',
					dataType: 'json',
					url:'".PRC_GN.__t('mdl_attr', true).$___Ls->ls->vrall."',
					data: $('#".$___Ls->fm->id."').serialize(),
					beforeSend: function() {
					},
					success: function(d) {
						if(d.e == 'ok'){
							swal('".TX_EX."', '".TX_PRCEXT."', 'success');		
						}else{
							swal('".TX_ERROR."', '".TX_NSPDGRD."', 'error');		
						}	
					}, 
					complete: function(){ }
				});
				
			});
		}); 		
	";
?>