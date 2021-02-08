<?php
if(class_exists('CRM_Cnx')){
	
	$___Ls->sch->f = 'ustel_tel, sisps_tt';
	$___Ls->new->w = 500;
	$___Ls->new->h = 400;
	$___Ls->edit->w = 500;
	$___Ls->edit->h = 400;
	$___Ls->_strt();
	
	if(!ChckSESS_superadm() && $___Ls->gt->tsb != 'cl'){ 
		$__fl .= _AndSql('id_us', SISUS_ID); 
	}

	if(!isN($___Ls->gt->i)){		
		 $___Ls->qrys = sprintf("SELECT * FROM ".MDL_US_TEL_BD." WHERE ".$___Ls->ik." = %s LIMIT 1", GtSQLVlStr($___Ls->gt->i, "text"));	
	}elseif($___Ls->_show_ls == 'ok'){ 
		if(!isN($___Ls->gt->isb)){ $__fl .= $___Ls->_andsql([ 'f'=>'us_enc', 'v'=>$___Ls->gt->isb ]); }
		$Ls_Whr = "FROM ".MDL_US_TEL_BD.", ".TB_US.", ".TB_SIS_PS.", ".MDL_SIS_TEL_BD." WHERE ustel_us = id_us AND ustel_ps = id_sisps AND ustel_tp = id_sistel AND ".$___Ls->ino." != '' $__fl ".$___Ls->sch->cod." ORDER BY ".$___Ls->ino." DESC";
		$___Ls->qrys = "SELECT *, (SELECT COUNT(*) $Ls_Whr) AS ".QRY_RGTOT." $Ls_Whr";
	} 
	
	$___Ls->_bld();
?>
<?php if($___Ls->ls->chk=='ok'){ ?>

<?php if($___Ls->gt->tsb != 'cl'){ ?>
	<section class="_cvr" style="background-color:#6cbfa5;">
		<iframe src="<?php echo DMN_ANM; ?>mis_numeros/index.html" frameborder="0" width="100%" scrolling="no" height="200"></iframe>
	</section>
<?php } ?>

<?php $___Ls->_bld_l_hdr(); ?>
<?php if(($___Ls->qry->tot > 0)){ ?>

<table width="100%" border="0" cellpadding="0" cellspacing="0" class="Ls_Rg">
  <tr>
    <th width="1%" <?php echo NWRP ?>><?php echo TX_FM_No ?></th>
    <th width="1%" <?php echo NWRP ?>><?php echo TX_DCNMR ?></th>
    <th width="1%" <?php echo NWRP ?>><?php echo TX_EXT ?></th>
    <th width="1%" <?php echo NWRP ?>><?php echo TT_FM_PS ?></th>
    <th width="1%" <?php echo NWRP ?>><?php echo TX_VRFCD ?></th>
    <th width="1%" <?php echo NWRP ?>><?php echo TX_PC ?></th>
    <th width="1%" <?php echo NWRP ?>><?php echo TX_TP ?></th>
    <th width="1%" <?php echo NWRP ?>><?php echo TX_FI ?></th>
    <th width="1%"></th>
  </tr>
  <?php do { ?>

  <tr>
    <td width="1%" <?php echo NWRP ?>><?php echo Spn($___Ls->ls->rw[$___Ls->ino]); ?></td>
    <td width="1%" align="left" nowrap="nowrap"><?php echo ShortTx(ctjTx($___Ls->ls->rw['ustel_tel'],'in'),150,'Pt', true); ?></td>
    <td width="1%" align="left" nowrap="nowrap"><?php echo ShortTx(ctjTx($___Ls->ls->rw['ustel_ext'],'in'),150,'Pt', true); ?></td>
    <td width="1%" align="left" nowrap="nowrap"><?php echo ShortTx(ctjTx($___Ls->ls->rw['sisps_tt'],'in'),150,'Pt', true); ?></td>
    <td width="1%" align="left" nowrap="nowrap"><?php echo _sino( $___Ls->ls->rw['ustel_est'] ); ?></td>
    <td width="1%" align="left" nowrap="nowrap"><?php echo _sino( $___Ls->ls->rw['ustel_dfl'] ); ?></td>
    <td width="1%" align="left" nowrap="nowrap"><?php echo ShortTx(ctjTx($___Ls->ls->rw['sistel_nm'],'in'),150,'Pt', true); ?></td>
    <td width="1%" align="left" nowrap="nowrap"><?php echo ShortTx(ctjTx($___Ls->ls->rw['ustel_fi'],'in'),150,'Pt', true); ?></td>
    <td width="1%" align="left" class="_btn">
	    <?php
		    if(_ChckMd('sis_us')){  
	        	echo $___Ls->_btn([ 't'=>'mod' ]); 
			} 
		?>
    </td>
  </tr>
  <?php } while ($___Ls->ls->rw = $___Ls->sql->fetch_assoc()); ?>
</table>

<?php $___Ls->_bld_l_pgs(); ?>
<?php } ?>

<?php $___Ls->_h_ls_nr(); ?>
<?php } ?>


<?php if($___Ls->fm->chk=='ok'){ ?>
<div class="FmTb">


  <div id="<?php echo $___Ls->fm->bx->id ?>" class="<?php echo DV_GNR_FM_BX ?> dsh_us_tel" >
    <form method="POST" name="<?php echo $___Ls->fm->id; ?>" target="_self" id="<?php echo $___Ls->fm->id; ?>" >
      <?php $___Ls->_bld_f_hdr(); ?>

      <div id="<?php echo $___Ls->fm->fld->id ?>" class="<?php echo DV_GNR_FM_CMP ?>">
	  
       		<div class="ln_1">
          	    <div class="_d">					
					<div class="_d1">
					<?php 	
						if($___Ls->dt->tot > 0){ $ps = $___Ls->dt->rw['ustel_ps']; }else{ $ps = 57; }
						echo LsSis_PsOLD('ustel_ps','id_sisps', $ps, '-', 2, '', '', 'iso'); 
						$CntWb .= JQ_Ls('ustel_ps', '-', '', 'psFlg'); 
					?>
					</div>
					<div class="_d2">
						<?php echo HTML_inp_tx('ustel_tel', TX_NMR, $___Ls->dt->rw['ustel_tel'], FMRQD_NMR); ?>  
					</div>
					<?php 
						if($___Ls->dt->rw['ustel_tp'] == 3 || $___Ls->dt->rw['ustel_tp'] == ''){ $__ext_sty = ' style="display:none;" '; }
						echo HTML_inp_tx('ustel_ext', TX_EXT, ctjTx($___Ls->dt->rw['ustel_ext'],'in'), FMRQD_NMR, $__ext_sty); 

						if(!isN( $___Ls->dt->rw['ustel_us'] )){
							echo HTML_inp_hd('ustel_us', $___Ls->dt->rw['ustel_us'] );
						}else{
							echo HTML_inp_hd('ustel_us', !isN($___Ls->gt->isb)?$___Ls->gt->isb:SISUS_ID );
						}
					?>	
				</div>
	        	<?php 
		        
					echo LsSis_Tel('ustel_tp','id_sistel', $___Ls->dt->rw['ustel_tp'], FM_LS_SLTEL, 2); $CntWb .= JQ_Ls('ustel_tp', FM_LS_SLTEL); 
					echo OLD_HTML_chck('ustel_dfl', TX_PC, $___Ls->dt->rw['ustel_dfl']); 
								
					$CntWb .= "
						
						$('#ustel_tp').change(function() {
							
							__id_tp = $(this).val(); 
							__id_ext = $('#ustel_ext');
							__id_tel = $('#ustel_tel'); 
							__sl = $('#ustel_tp option:selected');
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
				<?php if($___Ls->dt->rw['ustel_est'] != 1 && $___Ls->dt->tot > 0){ ?>
				<div class="__chck_twl">
					<a href="<?php echo Void(); ?>" class="___onl_btn _anm" id="__call_chck"><?php echo Verificar ?></a>
				</div>
				<?php } ?>
				<br><br>
				<?php 
					if($___Ls->dt->tot > 0 && ChckSESS_superadm()){					
						echo HTML_chck([ 'id'=>'ustel_ntf_sms', 'ph'=>'Notificaciones SMS', 'v'=>$___Ls->dt->rw['ustel_ntf_sms'], 'tp'=>'in', 'dc'=>'ustel_ntf_sms' ]);
						echo HTML_chck([ 'id'=>'ustel_ntf_wthsp', 'ph'=>'Notificaciones Whatsapp', 'v'=>$___Ls->dt->rw['ustel_ntf_wthsp'], 'tp'=>'in', 'dc'=>'ustel_ntf_wthsp' ]);	
					}else{
						echo HTML_inp_hd('ustel_ntf_sms', $___Ls->dt->rw['ustel_ntf_sms'] );
						echo HTML_inp_hd('ustel_ntf_wthsp', $___Ls->dt->rw['ustel_ntf_wthsp'] );
					}	
				?>
	        
	        <?php 	
				
				$FncRnd = Gn_Rnd(20);
				
				$CntWb .= "
					
					$('#__call_chck').off('click').click(function() {
							
							var __id_tel = '".$___Ls->dt->rw['id_ustel']."';
																		
							$.ajax({
								type: 'POST',
								dataType: 'json',
								url:'".FL_JSON_GN.__t('call_phnadd', true)."',
								data: { '__id': __id_tel },
								beforeSend: function() { swal('".TX_PRCSVRF."', '".TX_PRCINCW."', 'info'); },
								success: function(d) {
									
									if(d.e == 'ok'){

										swal({
											title: '<div>Código <span style=\"color:#3398bd\" id=\"f_{$FncRnd}_cod\">'+d.cod+'<span></div>',
											text:'".TX_CLLCDVRF."',
											html: true,
											type: 'info'
										});
										
										setTimeout(function(){ 
											f_{$FncRnd}();
										}, 3000);
								
									}else{
										swal('".TX_TNMPRBL."', '".TX_MPRC."', 'error');
									}
									
								}
							});
						
					});
					
					
					
					
					function f_{$FncRnd}(){
						var __id_tel = '".$___Ls->dt->rw['id_ustel']."';
																		
						$.ajax({
							type: 'POST',
							dataType: 'json',
							url:'".FL_JSON_GN.__t('call_phnadd', true)."',
							data: { '__id': __id_tel, '__p': 'dt' },
							success: function(d) {
								
								if(d.tel.est != 'ok' && $('#f_{$FncRnd}_cod').is(':visible')){
									
									setTimeout(function(){ 
										f_{$FncRnd}();
									}, 3000);
							
								}else{
																			
									swal({
										title:'".TX_PERF."',
										text: '".TX_NPDUSD."',
										html: true,
										type: 'success',
										timer: 5000
									});
									
								}
							}
						});
					}
				";
			?>

        </div>
      </div>
    </form>
  </div>
</div>

<style>
	
	.dsh_us_tel .__chck_twl{ text-align: center; margin-top: 20px; display: block; width: 100%; }
	.dsh_us_tel .__chck_twl .___onl_btn{ display: block; margin-left: auto; margin-right: auto; float: none; }
	
	.dsh_us_tel .__slc_ok.ustel_ntf_sms,
	.dsh_us_tel .__slc_ok.ustel_ntf_wthsp{ border:none; display:flex; position:relative; border-radius:10px; -moz-border-radius:10px; -webkit-border-radius:10px; background-color:#f1f1f1; padding:10px 5px 5px 40px; margin-bottom:10px; }
	
	.dsh_us_tel .__slc_ok h3{ border:none; }

	.dsh_us_tel .__slc_ok.ustel_ntf_sms::before,
	.dsh_us_tel .__slc_ok.ustel_ntf_wthsp::before{ width:25px; height:25px; margin-right:10px; position:absolute; left:10px; top:8px; background-repeat:no-repeat; background-position:center center; background-size:auto 90%; }
	
	.dsh_us_tel .__slc_ok.ustel_ntf_sms::before{ background-image:url('<?php echo DMN_IMG_ESTR_SVG ?>cnttel_sndi_sms.svg'); }
	.dsh_us_tel .__slc_ok.ustel_ntf_wthsp::before{ background-image:url('<?php echo DMN_IMG_ESTR_SVG ?>cnttel_sndi_whtsp.svg'); }

</style>
	
<?php } ?>
<?php } ?>
