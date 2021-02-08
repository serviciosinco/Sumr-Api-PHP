<?php 
	
if(class_exists('CRM_Cnx')){

	$___Ls->tt = _Cns('TX_CNT');
	$___Ls->cnx->cl = 'ok';
	$___Ls->ino = 'id_orgsdscnt';
	$___Ls->_strt();
	$___Ls->ik = 'orgsdscnt_enc';

	if(!isN($___Ls->gt->i)){	

		$___Ls->qrys = sprintf("SELECT *
									FROM ".TB_ORG_SDS_CNT."
									INNER JOIN "._BdStr(DBM).TB_ORG_SDS." ON orgsdscnt_orgsds = id_orgsds
									INNER JOIN "._BdStr(DBM).TB_ORG." ON orgsds_org = id_org
								WHERE ".$___Ls->ik." = %s 
								LIMIT 1", GtSQLVlStr($___Ls->gt->i, "text")
							);
							
	}elseif($___Ls->_show_ls == 'ok'){
		
		if($___Ls->gt->tsb != 'emp'){
			$__org_tp = __LsDt([ 'k'=>'org_tp' ]);
			
			foreach($__org_tp->ls->org_tp as $_k => $_v){
				if($___Ls->gt->tsb == $_v->key->vl){ 
					$_fl_org[] = $_k; 
				}	
				if(!isN($_fl_org)){ $_fl .= " AND id_org IN ( SELECT orgtp_org FROM "._BdStr(DBM).TB_ORG_TP." WHERE orgtp_tp IN (".implode(',',$_fl_org).") ) "; }
			}
		}
		
		if($___Ls->gt->tsb == 'emp'){
			$_fl .= ' AND (orgsdscnt_tpr="'._CId('ID_ORGCNTRTP_TRB_PRST').'" || orgsdscnt_tpr="'._CId('ID_ORGCNTRTP_TRB_PAS').'" || orgsdscnt_tpr="'._CId('ID_ORGCNTRTP_TRBPRC').'" ) ';
			$cmp = 'orgsdscnt_are';
		}elseif($___Ls->gt->tsb == 'uni'){
			$_fl .= ' AND (orgsdscnt_tpr="'._CId('ID_ORGCNTRTP_ESTD_PRST').'" || orgsdscnt_tpr="'._CId('ID_ORGCNTRTP_ESTD_PAS').'" || orgsdscnt_tpr="'._CId('ID_ORGCNTRTP_ESTD_ITRS').'") ';
			$cmp = 'orgsdscnt_smst';
		}elseif($___Ls->gt->tsb == 'clg'){
			$_fl .= ' AND (orgsdscnt_tpr="'._CId('ID_ORGCNTRTP_ESTD_PRST').'" || orgsdscnt_tpr="'._CId('ID_ORGCNTRTP_ESTD_PAS').'") ';
			$cmp = 'orgsdscnt_crs';
		}elseif($___Ls->gt->tsb == 'marks'){
			$_fl .= ' AND (orgsdscnt_tpr="'._CId('ID_ORGCNTRTP_TRB_PRST').'" || orgsdscnt_tpr="'._CId('ID_ORGCNTRTP_TRB_PAS').'") ';
			$cmp = 'orgsdscnt_are';
		}
		
		
		$Ls_Whr = "	FROM ".TB_ORG_SDS_CNT." 
						 ".GtSlc_QryExtra(['t'=>'tb', 'col'=>'orgsdscnt_tpr', 'als'=>'t'])."
			
						 INNER JOIN ".TB_CNT."   ON id_cnt = orgsdscnt_cnt 
						 INNER JOIN "._BdStr(DBM).TB_ORG_SDS." ON orgsdscnt_orgsds = id_orgsds
						 INNER JOIN "._BdStr(DBM).TB_ORG."  ON orgsds_org = id_org
						 LEFT JOIN "._BdStr(DBM).TB_SIS_SLC." AS fk ON ".$cmp." = fk.id_sisslc
					WHERE ".$___Ls->ino." != ''
					AND cnt_enc = '{$__i}' $_fl
					".$___Ls->sch->cod." 
					
					ORDER BY ".$___Ls->ino." DESC";
					
		$___Ls->qrys = "SELECT *, 
						".GtSlc_QryExtra(['t'=>'fld', 'p'=>'tp', 'als'=>'t']).",
						".GtSlc_QryExtra(['t'=>'fld', 'p'=>'fk', 'als'=>'fk']).",
	
						   (SELECT COUNT(*) $Ls_Whr) AS ".QRY_RGTOT." $Ls_Whr"; 

	} 
	
	$___Ls->_bld();
	
	
	if($___Ls->gt->tsb == 'emp'){
		$_id_orgtp = _CId('ID_ORGTP_EMP');
		$_id_orgtpr = _CId('ID_ORGCNTRTP_TRB_PRST');
	}elseif($___Ls->gt->tsb == 'uni'){
		$_id_orgtp = _CId('ID_ORGTP_UNI');
		$_id_orgtpr = _CId('ID_ORGCNTRTP_ESTD_PRST');
	}elseif($___Ls->gt->tsb == 'clg'){
		$_id_orgtp = _CId('ID_ORGTP_CLG');
		$_id_orgtpr = _CId('ID_ORGCNTRTP_ESTD_PRST');
	}
	
?>
<?php if($___Ls->ls->chk=='ok'){ ?>
<?php $___Ls->_bld_l_hdr(); ?>
<?php if(($___Ls->qry->tot > 0)){ ?>
	
	<table width="100%" border="0" cellpadding="0" cellspacing="0" class="Ls_Rg">
		<tbody>
			<tr>
				<th width="60%" class="c" align="center" <?php echo NWRP ?>><?php echo 'Nombre'; ?></td>
				<th width="10%" class="c" align="center" <?php echo NWRP ?>><?php echo 'Tipo'; ?></td>	
			<?php if($___Ls->gt->tsb=="emp"){?>	
				<th width="20%" class="c" align="center" <?php echo NWRP ?>><?php echo 'Area'; ?></td>			
			<?php } ?>
			<?php if($___Ls->gt->tsb=="clg"){?>
				<th width="10%" class="c" align="center" <?php echo NWRP ?>><?php echo 'Curso';  ?></td>
				<th width="20%" class="c" align="center" <?php echo NWRP ?>><?php echo 'Fecha';  ?></td>
			<?php } ?>
			<?php if($___Ls->gt->tsb=="uni"){?>
				<th width="10%" class="c" align="center" <?php echo NWRP ?>><?php echo 'Semestre';  ?></td>
			<?php } ?>
				<th width="1%" class="c" align="center" <?php echo NWRP ?>></td>
			</tr>
			<?php do {  ?>
		  		<tr>
					<td width="60%" class="c" align="center" <?php echo NWRP ?>><?php echo ctjTx($___Ls->ls->rw['org_nm'],'in').Spn(ctjTx($___Ls->ls->rw['orgsds_nm'],'in'),'ok','_h'); ?></td>
					<td width="10%" class="c" align="center" <?php echo NWRP ?>><?php echo ctjTx($___Ls->ls->rw['tp_sisslc_tt'],'in'); ?></td>	
				<?php if($___Ls->gt->tsb=="emp"){?>	
					<td width="20%" class="c" align="center" <?php echo NWRP ?>><?php echo ctjTx($___Ls->ls->rw['fk_sisslc_tt'],'in'); ?></td>			
				<?php } ?>
				<?php if($___Ls->gt->tsb=="clg"){?>
					<td width="10%" class="c" align="center" <?php echo NWRP ?>><?php echo ctjTx($___Ls->ls->rw['fk_sisslc_tt'],'in');  ?></td>
					<td width="20%" class="c" align="center" <?php echo NWRP ?>><?php echo ctjTx($___Ls->ls->rw['orgsdscnt_fs'],'in');  ?></td>
				<?php } ?>
				<?php if($___Ls->gt->tsb=="uni"){?>
					<td width="10%" class="c" align="center" <?php echo NWRP ?>><?php echo ctjTx($___Ls->ls->rw['fk_sisslc_tt'],'in');  ?></td>
				<?php } ?>
					<td width="1%" align="left" class="_btn"><?php echo $___Ls->_btn([ 't'=>'mod' ]); ?></td>
				
				</tr>
				
		  	<?php } while ($___Ls->ls->rw = $___Ls->sql->fetch_assoc()); ?>
		</tbody>  	
	</table>
	
<?php $___Ls->_bld_l_pgs(); ?>

<?php } ?>
<?php $___Ls->_h_ls_nr(); ?>
<?php } ?>

<?php if($___Ls->fm->chk=='ok'){ ?>
<div class="FmTb">
  	<div id="<?php echo $___Ls->fm->bx->id ?>" class="<?php echo DV_GNR_FM_BX ?> __cnt_dtl" >
	  	<form method="POST" name="<?php echo $___Ls->fm->id; ?>" target="_self" id="<?php echo $___Ls->fm->id; ?>">
	  		<?php $___Ls->_bld_f_hdr(); ?>
		 	<div id="<?php echo $___Ls->fm->fld->id ?>" class="<?php echo DV_GNR_FM_CMP ?>">		
			 	<div class="ln_1">
	         
			 		<div class="col_1">
						<?php

							if(!isN($___Ls->dt->rw['org_img'])){ 
								$img_org = _ImVrs(['img'=>$___Ls->dt->rw['org_img'], 'f'=>DMN_FLE_ORG ]);
							?>
								<div class="__img" style="background-image:url(<?php echo $img_org->th_200; ?>); "></div>	
							<?php }else{ ?>
								<div class="__img" style="background-image:url(<?php echo DMN_IMG_ESTR_SVG ?>empresa.svg); "></div> 
							<?php } 
								
							?><h2><?php echo ctjTx($___Ls->dt->rw['org_nm'],'in').Spn(ctjTx($___Ls->dt->rw['orgsds_nm'],'in'),'ok','_h'); ?></h2><?php

						    /*echo LsOrgSds(['cl'=>'ok<h2><?php echo ctjTx($___Ls->dt->rw['org_nm'],'in').Spn(ctjTx($___Ls->dt->rw['orgsds_nm'],'in'),'ok','_h'); ?></h2>','id'=>'orgsdscnt_orgsds', 'v'=>'orgsds_enc', 'va'=>$___Ls->dt->rw['orgsdstel_orgsds'], 'rq'=>1, 'org_tp_k'=>$___Ls->gt->tsb ]);
							$CntWb .= JQ_Ls('orgsdscnt_orgsds');*/ 

							if($___Ls->gt->tsb == "emp" && $___Ls->dt->tot > 0){
								include('cnt_org_sds_crg.php');
							}

							if($___Ls->gt->tsb == 'clg'){ $ph = 'ingresa el nombre del '.strtolower($_v->tt); }else{ $ph = 'ingresa el nombre de la '.strtolower($_v->tt);	}


							echo $___Ls->dt->tot;
							if( $___Ls->dt->tot == 0 ){ ?>
								<div style="width: 100%;" class="__sch_json" id="__sch_json">
									<div class="_c1">								
										<?php echo '<div class="_sl"><select id="orgsdscnt_orgsds" name="orgsdscnt_orgsds" class="required"></select></div>'; ?> 
										<?php 
										
											$CntWb .= " 
											
												___slc_sch({ 
													id:'orgsdscnt_orgsds', 
													ph:'- ".$ph." -', 
													tp:'".$___Ls->gt->tsb."', 
													t:'org_cnt', 
													w: 'OthWrt' 
												});
												
												function ___slc_sch(_p){

													var _i = _p.id;
													var _ph = _p.ph;
													var _tp = _p.tp;
													var _t = _p.t;
													var _w = _p.w;
																								
													$('#'+_i).select2({
														placeholder: _ph,
														minimumInputLength: 3,
														ajax: {
															url: '_cnt/_json/_gn.php?_t='+_t,
															dataType: 'json',
															delay: 250,
															method:'POST',
															data: function (params) {
																$('#'+_w).val(params.term);
																SUMR_Main.slc.sch = params.term;
																return { __q: params.term, __t: _tp };
															},
															processResults: function (d) {
																return { results: d.items };	
															},
															cache: true
														}
													});
												}

												$('#orgsdscnt_orgsds').change(function() {
													var _t__v = $(this).val();
													
													if(_t__v == '-new-'){
														$('#__sch_json').fadeOut();
														$('#bx_ls_2').fadeIn();
													}else{
														$('#OthWrt').val('');		
													}
												});

											"; 
										?>
									</div>	
								</div>
							<?php } ?>
						

						<div class="__new_data" id="bx_ls_2" style="display:none;">
							<?php echo _HTML_Input('OthWrt', TT_FM_NM, '', FMRQD); ?>
							<?php echo HTML_inp_hd('orgsdscnt_tp', $___Ls->gt->tsb); ?>
						</div>
	          		</div>
	         
			  		<div class="col_2">
				  		
						<?php  
						
							echo HTML_inp_hd('orgsdscnt_cnt', $__i);
							  
							$l = __Ls([ 'k'=>'org_cnt_r_tp', 
										'id'=>'orgsdscnt_tpr', 
										'va'=>$___Ls->dt->rw['orgsdscnt_tpr'],
										'cls'=>'orgsdscnt_tpr_'.$___Ls->gt->tsb,
										'rq'=>1,
										'ph'=>TX_TPR,
										'slc'=>[ 
											'opt'=>[
												'attr'=>[
													'itm-key'=>'key',
													$___Ls->gt->tsb=>$___Ls->gt->tsb														
												]	
											] 
										]	 
									]);

							echo $l->html; $CntWb .= $l->js;
						?>
						
						<?php echo HTML_inp_hd('orgsdscnt_tpr_o', $_id_orgtp); ?>
						
						<?php if($___Ls->gt->tsb == "emp"){ ?>
						<div class="trb_prst"  style="display: block;">
							
							<div class="trb_smpr" style="display: block;">
									<?php $l = __Ls([ 'k'=>'emp_ars', 'id'=>'orgsdscnt_are', 'va'=>$___Ls->dt->rw['orgsdscnt_are'] ,'rq'=>2,  'ph'=>TX_SLCAR ]); 
					                echo $l->html; $CntWb .= $l->js; ?>	
							</div>
						</div>
						
						<?php } else { ?>
						
						<div class="trb_prst _tpr">
						</div>
						
						<?php } ?>	
						
						<?php /*<div class="trb_pas _tpr" >
							<h3 id="orgsdscnt_fs_tt_t<?php echo $___Ls->id_rnd; ?>" style="display: none;">Fecha de terminación</h3>
							<?php echo SlDt([ 'id'=>'orgsdscnt_fs_t', 'va'=>$___Ls->dt->rw['orgsdscnt_fs'], 'rq'=>'no', 'ph'=>TX_F, 'lmt'=>'no', 'yr'=>'ok', 'cls'=>CLS_CLND ]); ?>	  
						</div> */?>
						
						<?php if($___Ls->gt->tsb == "emp"){
							$dsp = 'style="display:block !important;"';
							$tx = 'Fecha de terminación';
						} ?>

						<div <?php echo $dsp; ?> class="estd_pas trb_pas _tpr">	
							<h3 id="orgsdscnt_fs_tt_g<?php echo $___Ls->id_rnd; ?>"><?php echo $tx; ?></h3>
							<?php echo SlDt([ 'id'=>'orgsdscnt_fs', 'va'=>$___Ls->dt->rw['orgsdscnt_fs'], 'rq'=>'no', 'ph'=>TX_F, 'mth'=>'ok', 'lmt'=>'no', 'yr'=>'ok', 'cls'=>CLS_CLND ]); ?>
						</div>
							
						<?php if($___Ls->gt->tsb == "clg"){ ?>
							<div class="estd_prst _tpr _clg" style="display: block;" >
								<h3 id="orgsdscnt_fs_tt_c<?php echo $___Ls->id_rnd; ?>">En que curso vas</h3>
								<?php //echo HTML_inp_tx('orgsdscnt_crs', TX_CRS." ",  ctjTx($___Ls->dt->rw['orgsdscnt_crs'], 'in')  );?>
								<?php //echo Ls_GrdClg('orgsdscnt_crs', 'clgkey', $___Ls->dt->rw['orgsdscnt_crs'],'Curso','2'); $CntWb .= JQ_Ls('orgsdscnt_crs','');  ?>
								<?php 

									$l = __Ls([ 
										'k'=>'crs_o_smst', 
										'id'=>'orgsdscnt_crs', 
										'va'=>$___Ls->dt->rw['orgsdscnt_crs'],
										'ph'=>'- seleccione curso -'
									]); 

									echo $l->html; $CntWb .= $l->js;

								?>
							</div>
						<?php } ?>
					
						<?php if($___Ls->gt->tsb == "uni"){ ?>
							<div class="estd_prst _tpr _uni" style="display: block;" >
								<h3 id="orgsdscnt_fs_tt_c<?php echo $___Ls->id_rnd; ?>">En que semestre vas</h3>
								<?php 

									$l = __Ls([ 
										'k'=>'crs_o_smst', 
										'id'=>'orgsdscnt_smst', 
										'va'=>$___Ls->dt->rw['orgsdscnt_smst'],
										'ph'=>'- seleccione semestre -',
										'rq'=>2
									]); 

									echo $l->html; $CntWb .= $l->js;

								?>
							</div>
						<?php } ?>
						
							 <?php
								/*Constantes Ricardo*/ 
								$CntWb .= "
								
									var _key = $('.orgsdscnt_tpr_".$___Ls->gt->tsb." ._slc_opt:selected').attr('itm-key');

									if( ( 'clg' == '".$___Ls->gt->tsb."' && isN(_key) ) || ( 'uni' == '".$___Ls->gt->tsb."' && isN(_key) ) ){
										$('.'+_key+'').show('slide');
									}else{
										
										if(_key == 'trb_pas'){
											$('#orgsdscnt_fs_tt_g".$___Ls->id_rnd."').html('Fecha de terminación');
										}else if(_key == 'estd_pas'){
											$('#orgsdscnt_fs_tt_g".$___Ls->id_rnd."').html('Fecha de graduación');
											$('.estd_prst._clg').hide();
											$('#orgsdscnt_crs').val('');
											$('.estd_prst._uni').hide();
											$('#orgsdscnt_smst').val('');
										}else{
											$('._tpr').hide();	
										}
										
										$('.'+_key+'').show('slide');
									}

									$('.orgsdscnt_tpr_".$___Ls->gt->tsb."').change(function() {	
												
										var _key = $('.orgsdscnt_tpr_".$___Ls->gt->tsb." ._slc_opt:selected').attr('itm-key');
										
										if(_key == 'trb_pas'){
											$('#orgsdscnt_fs_tt_g".$___Ls->id_rnd."').html('Fecha de terminación');
										}else if(_key == 'estd_pas'){
											$('#orgsdscnt_fs_tt_g".$___Ls->id_rnd."').html('Fecha de graduación');
											$('#orgsdscnt_crs').val('');
											$('#orgsdscnt_smst').val('');
										}else if(_key == 'estd_prst'){
											$('.'+_key+'').show('slide');
											$('#orgsdscnt_fs').val('');
										}else{
											$('#orgsdscnt_fs').val('');
										}
										
										$('._tpr').hide();
										$('.'+_key+'').show('slide');   

									});
									
									
									$('#orgsdscnt_tpr > option').each(function(){
										
										var _tp = $(this).attr('".$___Ls->gt->tsb."');
										if(_tp != 1){
											$(this).remove();
										}					
									});
							
									".JQ_Ls( 'orgsdscnt_tpr_'.$___Ls->gt->tsb, TX_SLC_CLG, '', '', [ "cls"=>"ok" ] )."
										
								";
							 ?>
				
				  		</div>   
	       	 		</div> 				
		   	 	</div>
		   </div>
		</form>
  	</div>
</div>

<style>
	
	._tpr{ display: none; }
	.__img{ width: 150px;margin: 10px auto;height: 150px;background-position: center;background-repeat:no-repeat; background-size: 100% auto;border-radius: 50%;border: 6px solid #bcbcbc; }
	
</style>
				
<?php } ?>
<?php } ?>