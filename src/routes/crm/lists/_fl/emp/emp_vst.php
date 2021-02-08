<?php 
if(class_exists('CRM_Cnx')){ 
	
	$___Ls->tt = MDL_VST;
	$___Ls->cnx->cl = 'ok';
	$___Ls->sch->f = 'emp_rs, empcnt_nm, empcnt_ap, vstest_nm';		
	$___Ls->_strt();		
	
	$__lsgt_flt_cmp = 'empvst_tp, empvst_pln, empvst_rxc, empvst_us, empvst_est, empvst_aplz, empvst_tra';
	
	if(_Chk_GET('fl_empemp')){ $__fl .= _AndSql('empcnt_emp', $_GET['fl_empemp']); }
	if(_Chk_GET('fl_empvsttp')){ $__fl .= _AndSql('empvst_tp', $_GET['fl_empvsttp']); }
	if(_Chk_GET('fl_empvstpln')){ $__fl .= _AndSql('empvst_pln', $_GET['fl_empvstpln']); }
	if(_Chk_GET('fl_empvstrxc')){ $__fl .= _AndSql('empvst_rxc', $_GET['fl_empvstrxc']); }   
	if(_Chk_GET('fl_empvstus')){ $__fl .= _AndSql('empvst_us', $_GET['fl_empvstus']); }
	if(_Chk_GET('fl_empvstest')){ $__fl .= _AndSql('empvst_est', $_GET['fl_empvstest']); }
	if(_Chk_GET('fl_empvstaplz')){ $__fl .= _AndSql('empvst_aplz', $_GET['fl_empvstaplz']); }
	if(_Chk_GET('fl_empvsttra')){ $__fl .= _AndSql('empvst_tra', $_GET['fl_empvsttra']); }
	
	if(_SbLs_ID('i')){ $__fl .= _AndSql('empcnt_emp', _SbLs_ID('i')); }
	
	if(!isN($___Ls->gt->i)){	
		
		$___Ls->qrys = sprintf("SELECT * FROM ".MDL_EMP_VST_BD." WHERE ".$___Ls->ik." = %s LIMIT 1", GtSQLVlStr($___Ls->gt->i, "text"));
		
	}elseif($___Ls->_show_ls == 'ok'){ 


		$Ls_Whr = "FROM ".MDL_EMP_VST_BD.", ".TB_EMP_CNT.", "._BdStr(DBM).TB_SIS_SLC.", "._BdStr(DBM).TB_US.", ".MDL_EMP_BD." WHERE 
				 		empvst_us = id_us AND
						empvst_cnt = id_empcnt AND
						empvst_est = id_sisslc AND
						empcnt_emp = id_emp AND
				  		".$___Ls->ino." != '' $__fl ".$___Ls->sch->cod." ORDER BY ".$___Ls->ino." DESC";
		$___Ls->qrys = "SELECT *, (SELECT COUNT(*) $Ls_Whr) AS ".QRY_RGTOT." $Ls_Whr";
		
	} 
	
	$___Ls->_bld();
	
?>
<?php if($___Ls->ls->chk=='ok'){ ?>
<?php $___Ls->_bld_l_hdr(); ?>
<?php if(($___Ls->qry->tot > 0)){ ?>

<table width="100%" border="0" cellpadding="0" cellspacing="0" class="Ls_Rg">
  	<thead>
        <tr>
            <th width="1%" <?php echo NWRP ?>><?php echo TX_FM_No ?></th>
            <?php if($__lssb != 'ok'){ ?>
            <th width="0%" <?php echo NWRP ?>><?php echo TX_RS ?></th>
            <?php } ?>
            <th width="0%" <?php echo NWRP ?>>&nbsp;</th>
            <th width="0%" <?php echo NWRP ?>><?php echo TX_NM ?></th>
            <th width="1%" <?php echo NWRP ?>><?php echo TX_F ?></th>
            <th width="1%" <?php echo NWRP ?>><?php echo TX_S ?></th>
            <th width="1%" <?php echo NWRP ?>>&nbsp;</th>
            <th width="1%" <?php echo NWRP ?>>&nbsp;</th>

        </tr>
  	</thead>
  	<tbody>
		<?php do { ?>
	    <tr>
            <td align="left" <?php echo $_clr_rw ?>><?php echo $___Ls->ls->rw[$___Ls->ino]; ?></td>

            <?php if($__lssb != 'ok'){ ?>
            <td align="left" <?php echo $_clr_rw ?>><?php echo ctjTx($___Ls->ls->rw['emp_rs'],'in').HTML_BR.Spn(ctjTx($___Ls->ls->rw['empcnt_nm'],'in').' '.ctjTx($___Ls->ls->rw['empcnt_ap'],'in'), '', '_f'); ?></td>
            <?php } ?>
            <td align="center" <?php echo $_clr_rw ?>><?php if($___Ls->ls->rw['empvst_grn'] == '1' || $___Ls->ls->rw['empvst_dir'] == '1'){ echo Spn('','','icn_dstc'); }else{ echo Spn('','','icn_dstc_off'); } ?></td>
            <td align="left" <?php echo $_clr_rw ?>><?php echo ctjTx($___Ls->ls->rw['us_nm'],'in').' '.ctjTx($___Ls->ls->rw['us_ap'],'in'); ?></td>
            <td align="left" <?php echo $_clr_rw ?> nowrap="nowrap"><?php echo Spn(ctjTx($___Ls->ls->rw['empvst_f'],'in'),'','_f'); ?></td>
            <td align="left" <?php echo $_clr_rw ?>><?php echo ctjTx($___Ls->ls->rw['vstest_nm'],'in'); ?></td>

            <td width="1%" align="left" nowrap="nowrap" class="_btn"><?php echo $___Ls->_btn([ 't'=>'mod' ]); ?></td>
            <td width="1%" align="left" nowrap="nowrap" class="_btn">
                <?php echo HTML_Ls_Btn([ 't'=>'outl', 'l'=>DMN_ICS.'vst_emp/'.$___Ls->ls->rw[$___Ls->ino], 'trg'=>'_self' ]); ?>
            </td>
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
  <div <?php 
			echo HTML_Fm_Del($__id, $row_Dt_Rg[$__id], Fl_Rnd(PRC_GN.__t($__bdtp,true)), $__fmnm, ['f1'=>'___t', 'f1_v'=>$__prfx->prfx2_c]); 
  			 
	?>
                      


    <form method="POST" name="<?php echo $___Ls->fm->id; ?>" target="_self" id="<?php echo $___Ls->fm->id; ?>">
      <?php $___Ls->_bld_f_hdr(); ?>

      <div id="<?php echo $___Ls->fm->fld->id ?>" class="<?php echo DV_GNR_FM_CMP ?>">
        	
			<?php echo bdiv(['cls'=>'bnr__emp_vst']); ?>
                    <?php 
	        $_id_tbpnl = 'TabPnl_'.Gn_Rnd(20); $CntWb .= " SUMR_Main.bxajx.".$_id_tbpnl." = new Spry.Widget.TabbedPanels('".$_id_tbpnl."'); "; $CntWb .= _DvLsFl(['i'=>$__idtp_tra, ]);
        
			$__idtp_tra = 'tra';
			
		?>
        <div id="<?php echo $_id_tbpnl ?>" class="VTabbedPanels">
                      <ul class="TabbedPanelsTabGroup">
                        <li class="TabbedPanelsTab"><?php echo Spn('','','_tt_icn _tt_icn_vst').Spn(TX_DTSBSC,'','_tx') ?></li>
                        <?php if($___Ls->dt->tot > 0){ ?>
	                        <li class="TabbedPanelsTab"><?php echo Spn('','','_tt_icn _tt_icn_his').Spn(TX_RVST,'','_tx') ?></li>
	                        <li class="TabbedPanelsTab" id="<?php echo TBGRP.$__idtp_vst_ofr ?>"><?php echo Spn('','','_tt_icn _tt_icn_gstn').TX_PROP ?></li>
	                        <li class="TabbedPanelsTab" id="<?php echo TBGRP.$__idtp_vst_his ?>"><?php echo Spn('','','_tt_icn _tt_icn_gstn').TX_GSTN ?></li>

	                        <?php if(($row_Dt_Rg['empvst_tra']) == 1){?>
	                        	<li  class="TabbedPanelsTab " id="<?php echo TBGRP.$__idtp_tra ?>"><?php echo Spn('','','_tt_icn _tt_icn_gstn').TX_TRA ?></li>
	                        <?php }else{ ?>
		                        <li  class="TabbedPanelsTab _hd" id="<?php echo TBGRP.$__idtp_tra ?>"><?php echo Spn('','','_tt_icn _tt_icn_gstn').TX_TRA ?></li>
	                       <?php } ?>
	                       
                        <?php } ?>
                      </ul>
                      <div class="TabbedPanelsContentGroup">
                            <div class="TabbedPanelsContent"> 
                                 	 
                                            <div class="ln_1">
                                              <div class="col_1">
                                              		<?php $__dt_flt_1 = _AndSql('id_emp', _SbLs_ID('i')); ?>
                                                    <?php 
															if(ChckSESS_superadm() || _ChckMd('emp_vst_prgr')){
																echo LsUs('empvst_us','id_us', $row_Dt_Rg['empvst_us'], '', 2); $CntWb .= JQ_Ls('empvst_us',FM_LS_SLUS); 
															}else{
																echo HTML_inp_hd('empvst_us', SISUS_ID);
															}
													?>
													<?php echo LsEmp_Cnt('empvst_cnt','id_empcnt', $row_Dt_Rg['empvst_cnt'], '', 1, '', $__dt_flt_1); $CntWb .= JQ_Ls('empvst_cnt',FM_LS_SLEMP); ?>
													
                                                    <?php echo SlDt([ 'id'=>'empvst_f', 'va'=>($__fpck != '')?$__fpck:$row_Dt_Rg['empvst_f'], 'rq'=>'no', 'ph'=>TX_FPRG, 'lmt'=>'no', 'cls'=>CLS_CLND ]);  
	                                                         //SlDt('empvst_f', ($__fpck != '')?$__fpck:$row_Dt_Rg['empvst_f'] ,'no','',TX_FPRG,'no','','','',CLS_CLND);  ?> 
                                                    <?php //echo SlDt('empvst_h', ($__hpck != '')?$__hpck.':00':$row_Dt_Rg['empvst_h'] ,'no','hr',TX_HP,'no','','','',CLS_HOUR); 
	                                                      echo SlDt([ 'id'=>'empvst_h', 'va'=>($__hpck != '')?$__hpck.':00':$row_Dt_Rg['empvst_h'], 'rq'=>'no', 't'=>'hr', 'ph'=>TX_HP, 'lmt'=>'no', 'cls'=>CLS_HOUR ]);
                                                    ?> 
													<?php //echo LsEmp_Vst_Tp('empvst_tp','id_vsttp', $row_Dt_Rg['empvst_tp'], '', 2); $CntWb .= JQ_Ls('empvst_tp',FM_LS_SLEMP); 
														 $l = __Ls(['k'=>'vst_tp', 'id'=>'empvst_tp', 'va'=>$row_Dt_Rg['empvst_tp'] , 'ph'=>FM_LS_SLVSTTP]); 
														 echo $l->html; $CntWb .= $l->js;
													?>
													<?php 
															$__dt_flt_2 = _AndSql('empcnt_emp', _SbLs_ID('i'))." AND id_empvst != '".$row_Dt_Rg['id_empvst']."' ";
															echo LsEmp_Vst('empvst_va','id_empvst', $row_Dt_Rg['empvst_va'], '', 2, '', $__dt_flt_2); $CntWb .= JQ_Ls('empvst_va',FM_LS_SLVSTA);
															 															
													?> 
                                              </div>
                                              <div class="col_2">
                                              		

                                                    <?php //echo LsEmp_Vst_Est('empvst_est','id_sisslctp', $row_Dt_Rg['empvst_est'], '', FMRQD); $CntWb .= JQ_Ls('empvst_est',FM_LS_SLEMP);
                                                   // $l = __Ls(array('k'=>'vst_est', 'id'=>'empvst_est', 'va'=>$row_Dt_Rg['empvst_est'], 'ph'=>TX_SLCEST)); 
													//echo $l->html; $CntWb .= $l->js;    
                                                    	 $l = __Ls(['k'=>'vst_est', 'id'=>'empvst_est', 'va'=>$row_Dt_Rg['empvst_est'] , 'ph'=>TX_SLCEST]); 
														 echo $l->html; $CntWb .= $l->js;

                                                    
                                                     ?>
                                                    <?php echo HTML_textarea('empvst_obs', TX_OBS, ctjTx($row_Dt_Rg['empvst_obs'],'in'), '', 'ok'); ?> 
                                                    
                                                    <?php echo OLD_HTML_chck('empvst_pln', FM_LS_SLPLN, $row_Dt_Rg['empvst_pln'], 'in'); ?>
                                                    <?php echo OLD_HTML_chck('empvst_rxc', TX_RXC, $row_Dt_Rg['empvst_rxc'], 'in'); ?>  
                                                    <?php echo OLD_HTML_chck('empvst_grn', TX_VGRN, $row_Dt_Rg['empvst_grn'], 'in'); ?>
                                                    <?php
	                                                    
	                                                    
															echo HTML_inp_hd('empvst_dir', $row_Dt_Rg['empvst_dir']);
	                                                
	                                                ?>       
                                              </div>
                                            </div>  
                                            
                                                 
                            </div>
                            <div class="TabbedPanelsContent">
                               				<div class="ln_1">
                                              <div class="col_1">
                                              		
                                              		<?php if($row_Dt_Rg['empvst_fr'] != ''){ $_f_df = $row_Dt_Rg['empvst_fr']; }else{ $_f_df = $row_Dt_Rg['empvst_f']; } ?>
                                              		<?php echo SlDt('empvst_fr',$_f_df,'no','',TX_FRL,'no','','','',CLS_CLND);  ?>
                                              		<?php if($row_Dt_Rg['empvst_hr'] != ''){ $_h_df = $row_Dt_Rg['empvst_hr']; }else{ $_h_df = $row_Dt_Rg['empvst_h']; } ?>
                                                    <?php echo SlDt('empvst_hr',$_h_df,'no','hr',TX_HRL,'no','','','',CLS_HOUR); ?> 
                                                    <?php 

		                                                    $l = __Ls(['k'=>'vst_aplz', 'id'=>'empvst_aplz', 'va'=>$row_Dt_Rg['empvst_aplz'] , 'ph'=>FM_LS_SLMAPLZ]); 
															echo $l->html; $CntWb .= $l->js;    
	                                                    
                                                    ?>    
                                              </div> 
                                              <div class="col_2">
                                              		<?php echo HTML_textarea('empvst_rsl', TX_RVST, ctjTx($row_Dt_Rg['empvst_rsl'],'in'), '', 'ok'); ?>
                                                    <?php echo OLD_HTML_chck('empvst_tra', TX_GNTRA, $row_Dt_Rg['empvst_tra'], 'in');?>
                                                    	<?php		
																$CntWb .= "	
																			
																			$('#empvst_tra').change(function(){
																				if($(this).is(':checked')){
																					$('#".TBGRP.$__idtp_tra."').removeClass('_hd').effect('highlight');																		
																				}else{
																					$('#".TBGRP.$__idtp_tra."').addClass('_hd');		
																				}
																			});	
																";  
															?>
													<?php echo OLD_HTML_chck('empvst_ofr', TX_GNOFR, $row_Dt_Rg['empvst_ofr'], 'in');
	                                                      
																			$CntWb .= "
																			
																						$('#empvst_ofr').change(function(){
																							if($(this).is(':checked')){
																								$('#__tra_tb').removeClass('_hd');
																								
																							}else{
																								$('#__ofr_tb').addClass('_hd');
																							}
																							
																						});
																						
																			";  
													?>

                                              </div>  
                                            </div>               
                            </div>
                            <?php if($___Ls->dt->tot > 0){ ?>
                        	
                        	<div class="TabbedPanelsContent">
                                 <!-- Inicia Ofertas -->
                                        <div class="ln">
                                            <?php echo bdiv(['id'=>DV_LSFL.$__idtp_vst_ofr]) ?>
                                        </div> 
                                 <!-- Finaliza Ofertas -->
                            </div>
                            
                            <div class="TabbedPanelsContent">
                                 <!-- Inicia Ofertas -->
                                        <div class="ln">
                                            <?php echo bdiv(['id'=>DV_LSFL.$__idtp_vst_his]) ?>
                                        </div> 
                                 <!-- Finaliza Ofertas -->
                            </div>
                            
                             <?php if(($row_Dt_Rg['empvst_tra']) == 1){?>
	                             <div class="TabbedPanelsContent">
		                            <div class="ln">
	                                	<?php echo bdiv(['id'=>DV_LSFL.$__idtp_tra]) ?>
	                                </div> 
	                             </div>
							 <?php }else{?>
								<div class="TabbedPanelsContent">
		                            <div class="ln">
	                                	<?php echo bdiv(['id'=>DV_LSFL.$__idtp_tra]) ?>
	                                </div> 
	                             </div>
							 <?php } ?>
							
                            <?php } 
	               
					$CntWb .= "$('#".TBGRP.$__idtp_tra."').click(function(){ $('#".ID_BTNSVE.$__bdtp.$__prfx_fm."').hide(); }); ";
                ?>
                            
                            
                            <?php 
	                            $CntJV .= _DvLsFl_Vr(['i'=>$row_Dt_Rg[$__id], 'n'=>$__idtp_vst_ofr, 't'=>'emp_ofr']);	
								$CntJV .= _DvLsFl_Vr(['i'=>$row_Dt_Rg[$__id], 'n'=>$__idtp_vst_his, 't'=>'emp_his']);
								$CntJV .= _DvLsFl_Vr(['i'=>$row_Dt_Rg[$__id], 'n'=>$__idtp_tra, 't'=>'emp_vst_tra&_id_emp='._SbLs_ID('i')]);	   		  	  
								$CntWb .= _DvLsFl(['i'=>$__idtp_vst_ofr]);
								$CntWb .= _DvLsFl(['i'=>$__idtp_vst_his]);
								$CntWb .= _DvLsFl(['i'=>$__idtp_tra]);		  
              				?>                                   
   
                      </div>
        </div>
      </div>
    </form>
  </div>

</div>
<?php } ?>


<?php } ?>                                                                                                                                                                                                                                                                        