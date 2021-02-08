<?php
if(class_exists('CRM_Cnx')){
	
	$___Ls->cnx->cl = 'ok';
	$___Ls->sch->f = 'ofr_tt, ofr_ord, ofr_ctlc, ofr_trm, ofr_dsc';
	$___Ls->_strt();
	
	$__lsgt_flt_cmp = 'ofr_emp, ofr_tp, ofr_cmp, ofr_md, ofr_est, ofr_rch';

	
	if(_Chk_GET('fl_ofremp')){ $__fl .= _AndSql('ofr_emp', $_GET['fl_ofremp']); }
	if(_Chk_GET('fl_ofrtp')){ $__fl .= _AndSql('ofr_tp', $_GET['fl_ofrtp']); }
	if(_Chk_GET('fl_ofrcmp')){ $__fl .= _AndSql('ofr_cmp', $_GET['fl_ofrcmp']); }
	if(_Chk_GET('fl_ofrmd')){ $__fl .= _AndSql('ofr_md', $_GET['fl_ofrmd']); }
	if(_Chk_GET('fl_ofrest')){ $__fl .= _AndSql('ofr_est', $_GET['fl_ofrest']); }
	if(_Chk_GET('fl_ofrus')){ $__fl .= _AndSql('ofr_us', $_GET['fl_ofrus']); }
	if(_Chk_GET('fl_ofrrch')){ $__fl .= _AndSql('ofr_rch', $_GET['fl_ofrrch']); }
	
	
	if(_SbLs_ID('i')){ $__fl .= _AndSql('ofr_emp', _SbLs_ID('i')); }
	
	if(!isN($___Ls->gt->i)){	
		
		$___Ls->qrys = sprintf("SELECT * FROM ".MDL_EMP_OFR_BD." WHERE ".$___Ls->ik." = %s LIMIT 1", GtSQLVlStr($___Ls->gt->i, "text"));
		
	}elseif($___Ls->_show_ls == 'ok'){ 


		$Ls_Whr = "FROM ".MDL_EMP_OFR_BD.", ".MDL_EMP_BD." WHERE ofr_emp = id_emp 
				   AND ".$___Ls->ino." != '' $__fl ".$___Ls->sch->cod." ORDER BY ".$___Ls->ino." DESC";
				   
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
            <th width="0%" <?php echo NWRP ?>><?php echo TX_NM ?></th>
            <?php if($__lssb != 'ok'){ ?>
            <th width="1%" <?php echo NWRP ?>><?php echo TX_RS ?></th>
            <?php } ?>
            <th width="1%" <?php echo NWRP ?>>&nbsp;</th>
          </tr>
  </thead>
  <tbody>

		<?php do { ?>
			<?php      
                $__gtusdt = GtUsDt($___Ls->ls->rw['tra_us']);
                $__gtusdt_rsp = GtUsDt($___Ls->ls->rw['tra_us_rsp']);
            ?>
			<tr>
	            <td align="left" <?php echo $_clr_rw ?>><?php echo $___Ls->ls->rw[$___Ls->ino]; ?></td>
	            <td align="left" <?php echo $_clr_rw ?>><?php echo ctjTx($___Ls->ls->rw['ofr_tt'],'in').' '.ctjTx($___Ls->ls->rw['ofr_ap'],'in'); ?></td>
	            <?php if($__lssb != 'ok'){ ?>
	            <td align="left" <?php echo $_clr_rw .NWRP ?>><?php echo ctjTx($___Ls->ls->rw['emp_rs'],'in'); ?></td>
	            <?php } ?>
	            <td width="1%" align="left" nowrap="nowrap"><?php echo $___Ls->_btn([ 't'=>'mod' ]); ?></td>
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
  	<div id="<?php echo $___Ls->fm->bx->id ?>" class="<?php echo DV_GNR_FM_BX ?>">                       
    <form method="POST" name="<?php echo $___Ls->fm->id; ?>" target="_self" id="<?php echo $___Ls->fm->id; ?>">
      	<?php $___Ls->_bld_f_hdr(); ?>
	  	<div id="<?php echo $___Ls->fm->fld->id ?>" class="<?php echo DV_GNR_FM_CMP ?>">

        	
			<?php echo bdiv(['cls'=>'bnr__emp_vst']); ?>
            
			<?php $_id_tbpnl = 'TabPnl_'.Gn_Rnd(20); $CntWb .= " SUMR_Main.bxajx.".$_id_tbpnl." = new Spry.Widget.TabbedPanels('".$_id_tbpnl."'); ";  ?>
            <div id="<?php echo $_id_tbpnl ?>" class="TabbedPanels ">
                          <ul class="TabbedPanelsTabGroup">
                            <li class="TabbedPanelsTab"><?php echo TX_DTSBSC ?></li>
                            <li class="TabbedPanelsTab"><?php echo TX_OBS ?></li>
                            
                            <?php if($___Ls->dt->tot > 0){ ?>
                            <?php 
								$__idtp_fle = '_fle';	
							?>
                            <li class="TabbedPanelsTab"><?php echo TX_RSLT ?></li>
                            <li class="TabbedPanelsTab" id="<?php echo TBGRP.$__idtp_fle ?>"><?php echo TX_ARCHVS ?></li>
                            <?php } ?>
                          </ul>
                          <div class="TabbedPanelsContentGroup">
                                <div class="TabbedPanelsContent"> 
                                                <div class="ln_1">
                                                  <div class="col_1"> 
                                                        <?php 
                                                            
                                                            echo HTML_inp_tx('ofr_tt', TX_TT, ctjTx($___Ls->dt->rw['ofr_tt'],'in'), FMRQD);
                                                            
                                                            if($__lssb != 'ok'){
                                                                //echo LsEmp('ofr_emp','id_emp', $___Ls->dt->rw['ofr_emp'], '', 2); $CntWb .= JQ_Ls('ofr_emp',FM_LS_SLEMP);*/
																echo LsEmp('ofr_emp','id_emp', $___Ls->dt->rw['ofr_emp'], '', 2, '', _SbLs_ID('i')); $CntWb .= JQ_Ls('ofr_emp',FM_LS_SLEMP); 
                                                            }else{
                                                                echo HTML_inp_hd('ofr_emp', _SbLs_ID('i'));
                                                            }
                                                            
                                                            //echo SlDt('ofr_fs',$___Ls->dt->rw['ofr_fs'],'no','',TX_FSLC,'no','','','',CLS_CLND);
                                                            echo SlDt([ 'id'=>'ofr_fs', 'va'=>$___Ls->dt->rw['ofr_fs'], 'rq'=>'no', 'ph'=>TX_FSLC, 'lmt'=>'no', 'cls'=>CLS_CLND ]);  
                                                             

                                                            
                                                            $l = __Ls(['k'=>'ofr_tp', 'id'=>'ofr_tp', 'va'=>$___Ls->dt->rw['ofr_tp'] , 'ph'=>FM_LS_SLTP]); 
																echo $l->html; $CntWb .= $l->js; 
																
															$l = __Ls(['k'=>'ofr_cmp', 'id'=>'ofr_cmp', 'va'=>$___Ls->dt->rw['ofr_tp'] , 'ph'=>FM_LS_SLTPCMP]); 
																echo $l->html; $CntWb .= $l->js; 
                                                            
                                                           
                                                            //echo LsCrr_Md('ofr_md','id_crrmd', $___Ls->dt->rw['ofr_md'], '', 2, '', array('tp'=>$___Ls->mdlstp->id)); $CntWb .= JQ_Ls('ofr_md',FM_LS_MD);
                                                            $l = __Ls(['k'=>'ofr_md', 'id'=>'ofr_md', 'va'=> $___Ls->dt->rw['ofr_md'], 'ph'=>FM_LS_MD]); 
															echo $l->html; $CntWb .= $l->js; 
                                                        ?>
                                                  </div>
                                                  <div class="col_2">  
                                                        <?php 
															//echo LsCrr_Ofr_Est('ofr_est','id_ofrest', ($___Ls->dt->rw['ofr_est']!=''?$___Ls->dt->rw['ofr_est']:5) , '', 2, '', array('tp'=>$___Ls->mdlstp->id)); $CntWb .= JQ_Ls('ofr_est',FM_LS_EST);
															$l = __Ls(['k'=>'ofr_est', 'id'=>'ofr_est', 'va'=>$___Ls->dt->rw['ofr_est'], 'ph'=>FM_LS_EST]); 
															echo $l->html; $CntWb .= $l->js;  
															 
															echo HTML_textarea('ofr_dsc', TX_TMGNRL, ctjTx($___Ls->dt->rw['ofr_dsc'],'in'), '', 'ok'); 
														?>
                                                  </div>
                                                </div>    	 
                                                 
                                                
                                                     
                                </div> 
                               
                                <div class="TabbedPanelsContent">
                                				<div class="ln_1">
                                                    <?php echo HTML_textarea('ofr_obs', TX_OBS, ctjTx($___Ls->dt->rw['ofr_obs'],'in'), '', 'ok');  ?>
                                                </div>  
												
                  								
                                </div>
                                
                               
                                <div class="TabbedPanelsContent">
    											<?php echo HTML_textarea('ofr_trm', TX_TRMRFR, ctjTx($___Ls->dt->rw['ofr_trm'],'in'), '', 'ok'); ?>
                                </div>
                                <div class="TabbedPanelsContent">
                  								<div class="ln_1">
                                                      <div class="col_1"> 
                                                      		<?php 
																	echo HTML_inp_tx('ofr_vlp', TX_VLRPRP, ctjTx($___Ls->dt->rw['ofr_vlp'],'in'), FMRQD_NMR); 				
															?>
                                                      </div>
                                                      <div class="col_2"> 
                                                      		<?php 
																	echo HTML_inp_tx('ofr_rtn', TX_RNTESPR, ctjTx($___Ls->dt->rw['ofr_rtn'],'in'), FMRQD_NMR); 	
																	echo HTML_inp_tx('ofr_equ', TX_PEQULI, ctjTx($___Ls->dt->rw['ofr_equ'],'in'), FMRQD_NMR); 			
															?>
                                                      </div>
                                                </div>  
                                </div>
                                
                                
                                
                                <?php if($___Ls->dt->tot > 0){ ?>
                                <div class="TabbedPanelsContent">
                  							<div class="ln_1">
                                                  <div class="col_1"> 
													  <?php 
                                                            echo SlDt('ofr_fe',$___Ls->dt->rw['ofr_fe'],'no','',TX_FFENV,'no','','','',CLS_CLND);
                                                      ?>
                                                      
                                                      
                                                      
		                                                      <?php echo h2(TX_PRCAVNC); ?>
		                                                      <div id="bar_ofr_avc" class="bar_prgs">
		                                                        	<?php 
																		if($___Ls->dt->rw['ofr_avc'] != NULL && $___Ls->dt->rw['ofr_avc'] != ''){
																			$___tot_avc = $___Ls->dt->rw['ofr_avc'];
																		}else{
																			$___tot_avc = 5;
																		}
																	?>
		                                                            
		                                                            <div class="prcn"><?php echo $___tot_avc.'%' ?></div>
																	<div class="bar"></div>
		                                                            
		                                                            <input id="ofr_avc" name="ofr_avc" type="hidden" value="<?php echo $___tot_avc ?>" />
		                                                            <?php 
																		$CntWb .= "
																					var _bar_p = $('#bar_ofr_avc');
																					
																					_bar_p.find('.bar').slider({
																						range: 'min',
																						min: 0,
																						value: ".$___tot_avc.",
																						max: 100,
																						animate: true,
																						slide: function(event, ui) {
																							var __vle = ui.value;
																							$('#ofr_avc').val(__vle);
																							_bar_p.find('.prcn').html(__vle + '%');
																						}
																					});
																		";
																	?>
		                                                        </div>
		                                                        
                                                        
                                                        
                                                        
                                                  </div>	
                                                  <div class="col_2"> 
                                                  		
                                                  <?php 
														echo HTML_inp_tx('ofr_vla', TX_VLRAPRB, ctjTx($___Ls->dt->rw['ofr_vla'],'in'), FMRQD_NMR); 
												  		//echo LsCrr_Ofr_Rch('ofr_rch','id_ofrrch', $___Ls->dt->rw['ofr_rch'], '', 2, '', array('tp'=>$___Ls->mdlstp->id)); $CntWb .= JQ_Ls('ofr_rch',FM_LS_SLNOI);
												  ?>
												  <?php 
													  $l = __Ls(['k'=>'ofr_rch', 'id'=>'ofr_rch', 'va'=>$___Ls->dt->rw['ofr_rch'] , 'ph'=>FM_LS_SLGN]); 
													  echo $l->html; $CntWb .= $l->js;  
												  ?>
                                                  </div>
                                            </div>      				
                                </div>
                                
                                <div class="TabbedPanelsContent">
                                		<!-- Inicia Archivos -->
                                        <div class="ln">
                                        	<?php echo bdiv(['id'=>DV_LSFL.$__idtp_fle]) ?>
                                        </div> 
                                 		<!-- Finaliza Archivos -->
                                </div>
                                <?php 
									$CntJV .= _DvLsFl_Vr(['i'=>$___Ls->dt->rw[$___Ls->ino], 'n'=>$__idtp_fle, 't'=>'emp_ofr_fle']);
									$CntWb .= _DvLsFl(['i'=>$__idtp_fle]);
								?>
                                <?php } ?>
                          </div>
            </div>
      </div>
    </form>
  </div>

</div>
<?php } ?>

<?php } ?>
