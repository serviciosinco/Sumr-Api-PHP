<?php 
	
if(class_exists('CRM_Cnx')){
	
	$___Ls->cnx->cl = 'ok';
	$___Ls->sch->f = 'smslsts_nm';
	$___Ls->_strt();
	
	if(_SbLs_ID('i')){ $__fl .= _AndSql($__pro_rlc, _SbLs_ID('i')); }
	
	if(!isN($___Ls->mdlstp->id)){ $_f_tp = " AND id_smslsts IN (SELECT smslststp_lsts FROM ".MDL_SMS_LSTS_TP_BD." WHERE smslststp_lsts = id_smslsts AND smslststp_tp = ".$___Ls->mdlstp->id.") "; }
	
	if(!isN($___Ls->gt->i)){	
		
		$___Ls->qrys = sprintf("SELECT * FROM ".MDL_SMS_LSTS_BD." WHERE ".$___Ls->ik." = %s LIMIT 1", GtSQLVlStr($___Ls->gt->i, "text"));
		$__tt = ctjTx($___Ls->dt->rw['eclsts_nm'],'in');
			
	}elseif($___Ls->_show_ls == 'ok'){ 

		$Ls_TotLds = ", (SELECT COUNT(*) FROM ".MDL_SMS_LSTS_BD." WHERE smslststel_lsts = id_smslsts) AS __tot_lds ";	
		$Ls_Whr = "FROM $__bd WHERE ".$___Ls->ino." != '' $_f_tp $__fl ORDER BY ".$___Ls->ino." DESC";
		$___Ls->qrys = "SELECT *, (SELECT COUNT(*) $Ls_Whr) AS ".QRY_RGTOT." $Ls_TotLds $Ls_Whr";  
		
	} 


	$___Ls->_bld(); 
 
?>
<?php if($___Ls->ls->chk=='ok'){ ?>
<?php $___Ls->_bld_l_hdr(); ?>
<?php if(($___Ls->qry->tot > 0)){ ?>


<table width="100%" border="0" cellpadding="0" cellspacing="0" class="Ls_Rg LsRgNw">
  	<tbody>
	  <?php do { ?>
      	<tr>
	        <td align="left" <?php echo $_clr_rw ?> class="__sgm_ls"><?php echo h2(ctjTx($___Ls->ls->rw['smslsts_nm'],'in')); ?></td>
	        <td align="left" <?php echo NWRP.$_clr_rw ?>><?php echo Strn($___Ls->ls->rw['__tot_lds']).HTML_BR.Spn(TX_LEADS) ?></td>
	        <td align="left" <?php echo NWRP.$_clr_rw ?>><?php echo Strn('0.0%').HTML_BR.Spn(TX_PRO_APR) ?></td>
	        <td align="left" <?php echo NWRP.$_clr_rw ?>><?php echo Strn('0.0%').HTML_BR.Spn(TX_CLCKS) ?></td>
	        <td width="1%" align="left" nowrap="nowrap" class="_btn"><?php echo $___Ls->_btn([ 't'=>'mod' ]); ?></td>
		</tr>
		<?php } while ($___Ls->ls->rw = $___Ls->sql->fetch_assoc()); ?>
  	</tbody>
</table>
<?php $___Ls->_bld_l_pgs(); ?>
<?php } ?>

<?php $___Ls->_h_ls_nr(); ?>
<?php } ?>
<?php if($___Ls->fm->chk=='ok'){ ?>

	<?php if($___Ls->dt->tot > 0){ ?>
				  		
	
	<div class="FmTb">
	  <div id="<?php echo $___Ls->fm->bx->id ?>" class="<?php echo DV_GNR_FM_BX ?>" >
	
		  
	    <form method="POST" name="<?php echo $___Ls->fm->id; ?>" target="_self" id="<?php echo $___Ls->fm->id; ?>" >
	      <?php $___Ls->_bld_f_hdr(); ?>
	
		  
		  
		  <?php 
			  
			  	$_id_tbpnl = 'TabPnl_'.Gn_Rnd(20); 
				$CntWb .= " SUMR_Main.bxajx.".$_id_tbpnl." = new Spry.Widget.TabbedPanels('".$_id_tbpnl."'); "; 
				
			    /*$__idtp_tel = '_';
			    $__idtp_bsc = '_lsts_bsc';
			    $__idtp_sgm = '_lsts_sgm';
				$__idtp_grp = '_lsts_grp';
				$__idtp_up = '_lsts_up';
				$__idtp_adm = '_lsts_adm';*/
				
				
				$___Ls->_dvlsfl_all([
					['n'=>'lsts_tel', 't'=>'sms_lsts_tel', 'l'=>TX_DTSBSC],
					['n'=>'lsts_bsc', 't'=>'sms_lsts_sgm', 'l'=>MDL_EC_LSTS_SGM],
					['n'=>'lsts_grp', 't'=>'sms_lsts_grp', 'l'=>MDL_EC_LSTS_GRP],
					['n'=>'lsts_up',  't'=>'sms_lsts_up', 'l'=>TX_UPLMSV],
					['n'=>'lsts_adm', 't'=>'sm_lsts_adm', 'l'=>'Administradores', 's'=>'ok']
				],[
					'hd'=>'no',
					'sng'=>'ok',
					'icn_sty'=>'bsc',						
				]); 
				
				
		  
		  ?>
		  <div id="<?php echo $_id_tbpnl ?>" class="VTabbedPanels SndIn">
	              <ul class="TabbedPanelsTabGroup">
		              
		             	<?php echo $___Ls->tab->lsts_tel->l ?>
	                  	<?php echo $___Ls->tab->lsts_bsc->l ?>
					  	<?php echo $___Ls->tab->lsts_grp->l ?>
					  	<?php echo $___Ls->tab->ec_lsts_up->l ?>
					  	<?php echo $___Ls->tab->lsts_adm->l ?> 
		              
	                 <!--<li class="TabbedPanelsTab" id="<?php echo TBGRP.$__idtp_bsc ?>"><?php echo Spn('','','_tt_icn _tt_icn_lsts').TX_DTSBSC ?></li>
	                <li class="TabbedPanelsTab <?php if($___Ls->dt->tot == 0){ ?>_hd<?php } ?>" id="<?php echo TBGRP.$__idtp_sgm ?>"><?php echo Spn('','','_tt_icn _tt_icn_lsts_sgm').MDL_EC_LSTS_SGM ?></li> 
	                <?php /* ?><li class="TabbedPanelsTab " id="<?php echo TBGRP.$__idtp_grp ?>"><?php echo Spn('','','_tt_icn _tt_icn_lsts_grp').MDL_EC_LSTS_GRP ?></li><?php */ ?>
	                <li class="TabbedPanelsTab <?php if($___Ls->dt->tot == 0){ ?>_hd<?php } ?>" id="<?php echo TBGRP.$__idtp_up ?>"><?php echo Spn('','','_tt_icn _tt_icn_up').TX_UPLMSV ?></li>
	               <?php ?>
	                <li class="TabbedPanelsTab <?php if($___Ls->dt->tot == 0){ ?>_hd<?php } ?>" id="<?php echo TBGRP.$__idtp_adm ?>"><?php echo Spn('','','_tt_icn _tt_icn_est').'Administradores' ?></li>
					<?php ?>-->
	              </ul>
	              <div class="TabbedPanelsContentGroup">
	                        <div class="TabbedPanelsContent">
	                          				
									<div id="<?php echo $___Ls->fm->fld->id ?>" class="<?php echo DV_GNR_FM_CMP ?>">
												
											
											
											<?php if($___Ls->dt->tot > 0){ ?>
											<div class="ln_1" id="__edt_dtl">
												<div class="col_1">
													
													<div class="__bx_dt __fm_opt">
														<div class="__btn" style="z-index: 99999999; ">
															 	<?php $_lnktr_l = FL_LS_GN.__t('cnt',true).TXGN_POP._SbLs_ID().ADM_LNK_DT.$__dt_cnt->id.$___Ls->ls->vrall.$_adsch.TXGN_BX.DV_LSFL.Gn_Rnd(20); ?>
														        <?php if( !_DtV() ){ ?>
														            
	
														            <?php echo '<a href="'.Void().'" class="___edt_btn">'.TX_EDIT.'</a>' ; ?>
														            
														            <?php 
																		$CntWb .= '$(".___edt_btn").click(function(){ 
																						
																						$("#__edt_dtl").fadeOut("fast", function(){
																							$("#__edt").fadeIn();	
																						});
																						
														
																					}); ';
																	?>
														        <?php } ?>
														</div>
													</div>
	 
													<?php echo h1( ctjTx($___Ls->dt->rw['smslsts_nm'],'in') ); ?>
													<ul class="ls_1" >
														
														
														<li><?php echo Strn(TX_DRMTNT). ctjTx($___Ls->dt->rw['smslsts_frm'],'in') ; ?></li>
														<li><?php echo Strn(TX_ORGCPN). ctjTx($___Ls->dt->rw['smslsts_org'],'in') ; ?></li>
														<li><?php echo Strn( $___Ls->dt->rw['smslsts_rsgnup'] ) ; ?></li>
														
													</ul>
												</div>
												<div class="col_2">
													<?php echo h2( TX_ETDSRSM ); ?>
													
													
													    <div id="__grph_crsl" class="owl-carousel">
													        <div class="item">	<div id="bx_grph" class="__bl"><?php echo TX_APRTU ?></div>	</div>
													        <div class="item">	<div id="bx_grph2" class="__bl"><?php echo TX_RBTO ?></div>	</div>
													        <div class="item">	<div id="bx_grph3" class="__bl"><?php echo TX_SCRP ?></div>	</div>
													        <div class="item">	<div id="bx_grph4" class="__bl"><?php echo TX_HRAPRTU ?></div>	</div>
													        <div class="item">	<div id="bx_grph5" class="__bl"><?php echo TX_NVGDR?></div>	</div>
													        <div class="item">	<div id="bx_grph6" class="__bl"><?php echo TX_OS ?></div>	</div>
													        <div class="item">	<div id="bx_grph7" class="__bl"><?php echo TX_CMPRSM ?></div>	</div>
													    </div>
													
		
												</div>
											</div>
											<?php } ?>		
	
											
											<div class="ln_1" id="__edt" <?php if($___Ls->dt->tot > 0){ ?>style="display: none;"<?php } ?> >
													<div class="col_1">
														<?php echo h2(TX_DTSBSC); ?> 
									                    <?php echo HTML_inp_tx('smslsts_nm', TX_NM, ctjTx($___Ls->dt->rw['smslsts_nm'],'in')); ?>
									                    <?php echo LsSis_Tel('smslsts_sndr','id_sistel', $___Ls->dt->rw['smslsts_sndr'], TX_MVL.':', '', '', ['tp'=>'sis']); $CntWb .= JQ_Ls('smslsts_sndr', TX_DMAIL.':'); ?>
									                    <?php echo HTML_inp_tx('smslsts_frm', TX_DNM, ctjTx($___Ls->dt->rw['smslsts_frm'],'in'), FMRQD); ?>
									                    <?php echo HTML_inp_tx('smslsts_org', TX_ORGZ, $___Ls->dt->rw['smslsts_org']!=''?ctjTx($___Ls->dt->rw['smslsts_org'],'in'):$__dt_cl->dir); ?>
									                </div>
									                <div class="col_2">                                               		
														<?php echo h2(TX_OTHDT) ?>
														<?php echo HTML_textarea('smslsts_rsgnup', TX_RSGNUP, ctjTx($___Ls->dt->rw['smslsts_rsgnup'],'in'), FMRQD, '', '', 5); ?>
														<div> <?php echo Spn(TX_RSGNUP_EXM, '', '_nta'); ?></div>
									                </div>
											</div>
											
											<?php if($___Ls->dt->tot > 0){ ?>
											<!-- Inicia Segmentos -->
		                                        <div class="ln">
		                                            <!--<?php echo bdiv(['id'=>DV_LSFL.$__idtp_tel, 'cls'=>'_sbls']) ?>-->
		                                            <?php echo $___Ls->tab->tel->d ?>
		                                        </div> 
			                                <!-- Finaliza Segmentos -->	
											<?php } ?>
												
									</div>
									
									
	                        </div>
	                        <div class="TabbedPanelsContent">
	                                 
	                                 <!-- Inicia Segmentos -->
	                                        <div class="ln">
	                                            <!--<?php echo bdiv(['id'=>DV_LSFL.$__idtp_sgm, 'cls'=>'_sbls']) ?>-->
	                                            <?php echo $___Ls->tab->sgm->d ?>
	                                        </div> 
	                                 <!-- Finaliza Segmentos -->
	                                 
	                        </div> 
	                        <?php ?>
	                        <div class="TabbedPanelsContent">
	                                 <!-- Inicia Grupo -->
	                                        <div class="ln">
	                                            <!--<?php echo bdiv(array('id'=>DV_LSFL.$__idtp_grp, 'cls'=>'_sbls')) ?>-->
	                                            <?php echo $___Ls->tab->grp->d ?>
	                                        </div> 
	                                 <!-- Finaliza Grupos -->
	                                 
	                        </div>
	                        <?php  ?>
	                        <div class="TabbedPanelsContent">
	                                 <!-- Inicia Carga -->
	                                        <div class="ln">
	                                            <?php echo $___Ls->tab->up->d ?>
	                                        </div> 
	                                 <!-- Finaliza Carga -->      
	                        </div>
	                        
	                        <?php ?>  
	                        <div class="TabbedPanelsContent">
	                                 <!-- Inicia Administradores -->
	                                        <div class="ln">
	                                            <!--<?php echo bdiv(array('id'=>DV_LSFL.$__idtp_adm, 'cls'=>'_sbls')) ?>-->
	                                              <?php echo $___Ls->tab->adm->d ?>                                          
	                                        </div> 
	                                 <!-- Finaliza Administradores -->      
	                        </div>
	                        <?php ?> 
	                                                             
	              </div>
	              <?php       
							/*$CntJV .= _DvLsFl_Vr(['i'=>$___Ls->dt->rw[$___Ls->ino], 'n'=>$__idtp_tel, 't'=>'sms_lsts_tel']).
									  _DvLsFl_Vr(['i'=>$___Ls->dt->rw[$___Ls->ino], 'n'=>$__idtp_sgm, 't'=>'sms_lsts_sgm']).
									  _DvLsFl_Vr(['i'=>$___Ls->dt->rw[$___Ls->ino], 'n'=>$__idtp_grp, 't'=>'sms_lsts_grp']).
									  _DvLsFl_Vr(['i'=>$___Ls->dt->rw[$___Ls->ino], 'n'=>$__idtp_up, 't'=>'sms_lsts_up']).	
									  _DvLsFl_Vr(['i'=>$___Ls->dt->rw[$___Ls->ino], 'n'=>$__idtp_adm, 't'=>'sm_lsts_adm']);	
									    		  
							$CntWb .= _DvLsFl(['i'=>$__idtp_tel, 't'=>'s']).
									  _DvLsFl(['i'=>$__idtp_sgm]).
									  _DvLsFl(['i'=>$__idtp_grp]).
									  _DvLsFl(['i'=>$__idtp_up]).
									  _DvLsFl(['i'=>$__idtp_adm]); */
							
							
							$CntWb .= "SUMR_Main.ls.btn({i:'".TBGRP.$__idtp_bsc ."', i2:'".TBGRP.$__idtp_acr."', t:'".strtoupper($__bdtp)."', h:true });	";		  
					?>               
	        </div>
	        
	    </form>
	  </div>
	
	</div>
	<?php } ?>
<?php } ?>	
<?php } ?>