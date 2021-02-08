<?php if(class_exists('CRM_Cnx')){
	$___Ls->new->w = 400;
	$___Ls->new->h = 350;
	$___Ls->edit->w = 400;
	$___Ls->edit->h = 350;
	$__id = 'id_dwn'; // Id de Datos
	$__bd = TB_DWN; // Base de Datos
	$__bd2 =TB_DWN_EST; // Base de Datos
	$__bd3 =TB_US; // Base de Datos
	
	if(!isN($___Ls->gt->i)){	
		
		$___Ls->qrys = sprintf("	
								SELECT * 
								FROM ".DBD.".".$__bd.", ".DBD.".".$__bd2." 
								WHERE  dwn_est = id_dwnest AND ".$___Ls->ik." = %s 
								LIMIT 1", 
								$___Ls->gt->i, "int"
							);

	}elseif($___Ls->_show_ls == 'ok'){ 	
		
		if(!ChckSESS_superadm()){ $__fl .= " AND dwn_us = '".SISUS_ID."' "; }
		
		$Ls_Whr = "	FROM ".DBD.".".$__bd.", ".DBD.".".$__bd2.", ".$__bd3." 
					WHERE id_us = dwn_us AND dwn_est = id_dwnest AND dwn_cl = (SELECT id_cl FROM ".DBM."._cl WHERE cl_enc = '".CL_ENC."') $__fl $__schcod 
					ORDER BY $__id DESC";

		$___Ls->qrys = "SELECT id_dwn, dwn_enc, dwn_est, dwn_tt, dwnest_tt, dwnest_clr, dwn_tp, dwn_fi, dwn_w, us_nm, us_ap, dwn_tm_prg, dwn_tot,
						(SELECT COUNT(*) $Ls_Whr) AS __rgtot 
						$Ls_Whr"; 
	}
	
	$___Ls->_bld();
	
	if($___Ls->ls->chk=='ok'){
?>
<section class="_cvr" style="background-color:#83cfc8;">
	<iframe src="<?php echo DMN_ANM; ?>descargas/index.html" frameborder="0" width="100%" scrolling="no" height="200"></iframe>
</section>	

<?php 
		//$___Ls->_bld_l_hdr();
		
		if(($___Ls->qry->tot > 0)){ 
?>			

			<?php $CntJV .= "var __dwn={};"; ?>
			
			<table width="100%" border="0" cellpadding="0" cellspacing="0" class="Ls_Rg LsDwn">
				<tr>
					<th width="1%" nowrap="nowrap" <?php echo NWRP ?>><?php if(ChckSESS_superadm()){ echo TX_FM_No; } ?></th>
					<th width="0%" nowrap="nowrap" <?php echo NWRP ?>><?php echo TX_FI ?></th>
					<th width="1%" nowrap="nowrap" <?php echo NWRP ?>><?php echo TX_EST ?></th>
					<th width="1%" <?php echo NWRP ?>><?php echo TX_US ?></th>
					<th width="95%" <?php echo NWRP ?>><?php echo TX_TT ?></th> 					
					<th width="95%" <?php echo NWRP ?>><?php echo 'Error' ?></th>
					<th width="1%" <?php echo NWRP ?>><?php echo 'En Proceso' ?></th>
					<th width="1%" <?php echo NWRP ?>><?php echo 'Procesados' ?></th>
					<th width="1%" <?php echo NWRP ?>></th>
					<th width="1%" <?php echo NWRP ?>><?php echo TX_RES ?></th>
					<th width="1%" <?php echo NWRP ?>>&nbsp;</th>
					<th width="1%" <?php echo NWRP ?>>&nbsp;</th>
					<th width="1%" <?php echo NWRP ?>>&nbsp;</th>	
				</tr>
				<?php do { ?>
						<?php 
							
							if($___Ls->ls->rw['dwn_est'] != 1){ 
								/*
								$__dwn_dt = GtDwnDt(['id'=>$___Ls->ls->rw['id_dwn'] ]); 
								$n_dwn_s = (($__dwn_dt->tot->ok_x*100) / $__dwn_dt->tot->all);
								$n_dwn_n = (($__dwn_dt->tot->no_x*100) / $__dwn_dt->tot->all);
								*/
							}else{ 
								$__dwn_dt = ''; 
							} 
						?>
					<tr<?php 
							$Nm = Itc($NmNw); 
							cl('',$Nm); 
							$NmNw = $Nm;
							$AvncId = Gn_Rnd(5).'_avnc';
							$__div_l = '<div class="__avnc_l" id="bx_'.$AvncId.'" style="display:none;"></div>'; 
						?>
						
						id="dwn_<?php echo $___Ls->ls->rw['dwn_enc']; ?>"
					>
						<td width="1%" <?php echo NWRP ?>><?php if(ChckSESS_superadm()){ echo Spn($___Ls->ls->rw['id_dwn'],'',''); } ?></td>
						<td width="0%" <?php echo NWRP ?>><?php echo Spn(_Tme($___Ls->ls->rw['dwn_fi'], 'sng')); ?></td>
						<td width="1%" <?php echo NWRP ?>><?php echo Spn($___Ls->ls->rw['dwnest_tt'],'','est_tt', 'font-weight:700; color:'.$___Ls->ls->rw['dwnest_clr']); ?></td>
						<td width="1%" <?php echo NWRP ?>><?php echo ctjTx($___Ls->ls->rw['us_nm'].' '.$___Ls->ls->rw['us_ap'],'in'); ?></td>
						<td width="95%" align="left" nowrap="nowrap">
							<?php
								if(mBln($___Ls->ls->rw['dwn_tm_prg']) == 'ok'){ $_icn_prgr='<div class="_prgr"></div>'; }else{ $_icn_prgr=''; }
								echo $_icn_prgr.ShortTx(ctjTx($___Ls->ls->rw['dwn_tt'],'in'),80,'Pt', true).HTML_BR.Spn(ctjTx($___Ls->ls->rw['__fac'],'in'),'', '_f').$__icn_sis; 	
							?>
						</td>
						<td width="1%" <?php //echo NWRP ?>>
							<?php 
								if($___Ls->ls->rw['dwn_w'] != '' && $___Ls->ls->rw['dwn_w'] !=  NULL && $___Ls->ls->rw['dwn_est'] !=  2){ 
									echo Spn(ctjTx($___Ls->ls->rw['dwn_w'],'in'),'','', ''); 
								} 
							?>
						</td>
						<td align="left" <?php echo NWRP.$_clr_rw ?> class="<?php echo 'n_dwn_tot'; ?>"></td> 
						<td align="left" <?php echo NWRP.$_clr_rw ?> class="<?php echo 'n_dwn_prc'; ?>"></td>
						<td align="center" width="10%" <?php echo NWRP.$_clr_rw ?>>
								<?php 
									if($___Ls->ls->rw['dwn_est'] != 5){
										echo OLD_HTML_chck('chck_est_dwn'.$___Ls->ls->rw['id_dwn'], '', 1, 'in', ['c'=>'chck_est_dwn', 'attr'=>['rel'=>$___Ls->ls->rw['id_dwn'], 'data-enc'=>$___Ls->ls->rw['dwn_enc'] ]] );
									}
			    				?>
					        </td>
						<td width="1%" align="left" nowrap="nowrap" <?php echo $_clr_rw ?>>
							<?php echo Spn(ctjTx($___Ls->ls->rw['dwn_tot'],'in'),'','_nmb', 'font-weight:500; background-color:'.$___Ls->ls->rw['dwnest_clr']); ?>
						</td>
						<td width="1%" align="left" class="_btn _anm <?php if($___Ls->ls->rw['dwn_est'] == 1){ echo 'on'; } ?>"> 
							<?php echo HTML_Ls_Btn(['t'=>'dwn', 'trg'=>'_blank', 'l'=>DMN_DWND.PrmLnk('bld', $___Ls->ls->rw['dwn_enc'])."?Rnd=".Gn_Rnd(10), 'cls'=>'_btn_dwn' ]); ?>
						</td>
						<td align="left" <?php echo $_clr_rw ?> width="1%"><?php echo $__div_l; ?></td>
						<td width="1%" align="left" <?php echo $_clr_rw ?> class="_btn"><?php if(mBln($___Ls->ls->rw['dwn_tm_prg']) == 'ok'){ echo $___Ls->_btn([ 'id'=>$___Ls->ls->rw['dwn_enc'], 't'=>'mod' ]); } ?></td>
					</tr>
					
				<?php } while ($___Ls->ls->rw = $___Ls->sql->fetch_assoc()); ?>    
			</table>
			<?php 
				$CntWb .= "
				
					$('.chck_est_dwn').click(function() {  
						
						if($(this).is(':checked')) { var est = 'ok'; } else { var est = 'no'; }  
						var id_chck = $(this).attr('rel');
						var enc_chck = $(this).attr('data-enc');
						
						swal({ 
							title: '".TX_ETSGR."',              
							text: '".TX_CNL_DWN."',  
							type: 'warning',                        
							showCancelButton: true,                 
							confirmButtonClass: 'btn-danger',       
							confirmButtonText: '".TX_YSV."',      
							confirmButtonColor: '#8fb360',          
							cancelButtonText: '".TX_CNCLR."',           
							closeOnConfirm: true 
						},
						function(isConfirm){ 

							if (isConfirm) {
								
								_Rqu({ 
									t:'dwn', 
									d:'chck_est',
									est: est,
									_id_chck: id_chck,
									_bs:function(){ $('.Ls_Rg tr').addClass('_ld'); },
									_cm:function(){ $('.Ls_Rg tr').removeClass('_ld'); },
									_cl:function(_r){
										if(!isN(_r)){
											if(_r.e == 'ok'){
												$('#chck_est_dwn'+id_chck+'_div').remove();	
												$('#dwn_'+enc_chck+' .est_tt').html('Error').css('color', '#8C0000');
												$('#dwn_'+enc_chck+' ._btn').removeClass('on');
												$('#dwn_'+enc_chck+' ._nmb').html('').css('background-color', '#8C0000');
											}
										}
									} 
								});

							} else {
								$('#chck_est_dwn'+id_chck).attr('checked','checked');
							}
						});    
					});	
				";
			?>
			<style>
				
				._nmb_blnk{ animation: _blnk_ldr 0.8s cubic-bezier(.5, 0, 1, 1) infinite alternate; }
				.Ls_Rg ._prgr{ display:inline-block; width:20px; height:20px; margin-right:5px; margin-bottom:-5px; background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>dwn_prgr.svg); background-repeat: no-repeat; background-position: center bottom; background-size:auto 95%; }
				.Ls_Rg tr td._btn:not(.on) a{ opacity:0; }
				.Ls_Rg tr td._btn.on a{ opacity:1; } 
				.Ls_Rg tr._ld{pointer-events: none;opacity: 0.2;}

			</style>
			<?php $___Ls->_bld_l_pgs(); ?>
		<?php } ?>
	<?php $___Ls->_h_ls_nr(); ?>
	<?php } ?>
<?php } ?>