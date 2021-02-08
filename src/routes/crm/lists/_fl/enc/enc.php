<?php 
if(class_exists('CRM_Cnx')){

	
	$___Ls->cnx->cl = 'ok';
	$___Ls->sch->f = 'enc_tt';
	$___Ls->grph->tot = 2;
	$___Ls->new->big = 'ok';
	$___Ls->edit->big = 'ok';
	$___Ls->_strt();
	
	
	$_sistp = GtMdlSTpDt([ 'tp'=>$___Ls->gt->tsb ]);
	$__tb = Php_Ls_Cln($_GET['Tb']);
	
	if(!isN($___Ls->gt->i)){	
		
		$___Ls->qrys = sprintf("SELECT * FROM "._BdStr(DBM).TB_ENC." WHERE ".$___Ls->ik." = %s LIMIT 1", GtSQLVlStr($___Ls->gt->i, "text"));
		
	}elseif($___Ls->_show_ls == 'ok'){ 
			
		if(!isN($___Ls->mdlstp->id)){	
			$_f_tp = " AND id_ec IN (SELECT enctp_enc FROM ".TB_ENC_TP." WHERE ectp_enc = id_enc AND ectp_mdlstp = ".$___Ls->mdlstp->id.") ";
		}
		
		$Ls_Whr = "	FROM "._BdStr(DBM).TB_ENC." 
						 INNER JOIN "._BdStr(DBM).TB_CL." ON enc_cl = id_cl
					WHERE ".$___Ls->ino." != '' $__fl $_f_tp ".$___Ls->sch->cod." AND cl_enc = '".CL_ENC."' 
					ORDER BY ".$___Ls->ino." DESC";
					
		$___Ls->qrys = "SELECT *, (SELECT COUNT(*) $Ls_Whr) AS ".QRY_RGTOT.",(SELECT COUNT(*) FROM ".TB_ENC_CNT." WHERE id_enc = enccnt_enc $__fl ORDER BY id_enc DESC) AS ".QRY_RGTOT."_cnt $Ls_Whr"; 
		
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
            <th width="15%" <?php echo NWRP ?>><?php echo TX_FING ?></th>
            <th width="15%" <?php echo NWRP ?>><?php echo TX_TT ?></th>
            <th width="15%" <?php echo NWRP ?>><?php echo TX_ENCTCNTDS ?></th>
            <th width="1%" <?php echo NWRP ?>>&nbsp;</th>
            <th width="1%" <?php echo NWRP ?>>&nbsp;</th>
        </tr>
    </thead>
	<tbody>
		<?php do { ?>
		<tr>

            <td  width="1%" <?php echo NWRP.$_clr_rw ?> <?php echo NWRP ?>><?php echo Spn($___Ls->ls->rw[$___Ls->ino]); ?></td>

            <?php $___date = date_create($___Ls->ls->rw['svctc_fi']); $___fecha=date_format($___date, 'Y-m-d'); $___hora=date_format($___date, 'G:i:s'); ?>
            <td width="15%" <?php echo NWRP.$_clr_rw ?> align="left" nowrap="nowrap"><?php echo Spn($___fecha).HTML_BR.Spn($___hora, 'ok', '_tx'); ?></td>
            <td width="15%" <?php echo NWRP.$_clr_rw ?> align="left" nowrap="nowrap"><?php echo $___Ls->ls->rw['enc_tt']; ?></td>
            <td width="15%" <?php echo NWRP.$_clr_rw ?> align="left" nowrap="nowrap"><?php echo Spn($___Ls->ls->rw['__rgtot_cnt']); ?></td>

            <td width="1%" align="left" nowrap="nowrap" class="_btn"><?php echo $___Ls->_btn([ 't'=>'mod' ]); ?></td>
            <td width="1%" align="left" <?php echo $_clr_rw ?> class="_btn"><a href="javascript:_ldCnt({ u:FL_CL_FM_GN.'?_t=<?php echo "enc_cnt"; ?>&_m=3&Pr=Ing<?php echo Fl_i($___Ls->ls->rw[$___Ls->ino]) ?>&__rnd=bcf<?php echo TXGN_POP ?>', pop:'ok', w:'<?php echo '90%' ?>', h:'<?php echo '90%' ?>' });" target="_self"><img src="<?php echo DIR_IMG_ESTR ?>icn/ls_md.png" width="25" height="25" /></a></td>

            
        </tr>
	    <?php } while ($___Ls->ls->rw = $___Ls->sql->fetch_assoc()); ?>
	</tbody>
  
  <?php $CntWb .= '$("._dtl").colorbox({ width:"95%", height:"95%", trapFocus:false, overlayClose:false, escKey:false }); '; ?>
  <?php $CntWb .= '$("._md").colorbox({ width:"450px", height:"550px", trapFocus:false, overlayClose:false, escKey:false }); '; ?>
  
</table>

<?php $___Ls->_bld_l_pgs(); ?>
<?php } ?>

<?php $___Ls->_h_ls_nr(); ?>
<?php } ?>

<?php if($___Ls->fm->chk=='ok'){ ?>
<div class="FmTb">
  <div id="<?php echo $___Ls->fm->bx->id ?>" class="<?php echo DV_GNR_FM_BX ?>" >

    <form method="POST" name="<?php echo $___Ls->fm->id; ?>" target="_self" id="<?php echo $___Ls->fm->id; ?>" >
      	<?php $___Ls->_bld_f_hdr(); ?>

        <div class="imgbn">
			<?php echo $__dt_img->img; ?>
			<?php echo h1(ctjTx($___Ls->dt->rw['clg_tt'],'in')); ?>
        </div>
                   
        <?php 
				$_id_tbpnl = 'TabPnl_'.Gn_Rnd(20); 
				$CntWb .= " SUMR_Main.bxajx.".$_id_tbpnl." = new Spry.Widget.TabbedPanels('".$_id_tbpnl."'); "; 
				$__idtp_frm = '_enc_frm';
				$__idtp_cnt = '_enc_cnt';

		?>
        <div id="<?php echo $_id_tbpnl ?>" class="VTabbedPanels Tb<?php echo $___Ls->gt->tsb ?>">
              <ul class="TabbedPanelsTabGroup">
                <li class="TabbedPanelsTab" id="TbGrp1"><?php echo Spn('','','_tt_icn _tt_icn_'.$___Ls->gt->tsb).TX_DTSBSC ?></li>
                 <?php if($___Ls->dt->tot == 1){ ?>
                <li class="TabbedPanelsTab" id="<?php echo TBGRP.$__idtp_frm ?>"><?php echo Spn('','','_tt_icn _tt_icn_gstn').Forms ?></li>
				<li class="TabbedPanelsTab" id="<?php echo TBGRP.$__idtp_cnt ?>"><?php echo Spn('','','_tt_icn _tt_icn_gstn').MDL_CNT ?></li>
				 <?php }  ?>
                
              </ul>
              
              <div class="TabbedPanelsContentGroup">
                        <div class="TabbedPanelsContent">
                          				
                          				<div id="<?php echo $___Ls->fm->fld->id ?>" class="<?php echo DV_GNR_FM_CMP ?>">
                          				<div class="ln_1">
                                               <div class="col_1">
	                                               	<?php echo HTML_inp_hd('id_enc', $___Ls->dt->rw['id_enc']); ?>
	                                               	<?php if($___Ls->gt->tsb != 'mdl'){
		                                               	echo HTML_inp_hd('enc_mdlstp', $_sistp->id);
	                                               	}else{
		                                               	echo LsMdlS($___Ls->gt->tsb, 'enc_mdlstp', 'id_mdlstp', $___Ls->dt->rw['enc_mdlstp'], '', 1); $CntWb .= JQ_Ls('enc_mdlstp', FM_LS_SLTP);
	                                               	} ?> 
	                                             	
	                                            	<?php echo HTML_inp_tx('enc_tt', TX_TT, ctjTx($___Ls->dt->rw['enc_tt'],'in'), 2); ?>
	                                            	
     
                                                </div>                               
												<div class="col_2">
													
													<div id="__grph_crsl_<?php echo $___Ls->id_rnd; ?>" class="owl-carousel">
												        <div class="item">	<div id="bx_grph1" class="__bl"></div>	</div>
												        <div class="item">	<div id="bx_grph2" class="__bl"></div>	</div>
												        <div class="item">	<div id="bx_grph3" class="__bl"></div>	</div>
													</div>	
																
													<?php 
														
														
														$CntWb .= 'SUMR_Main.ld.f.owl( function(){
																		
																		SUMR_Main.ld.f.knob( function(){
																			$("#__grph_crsl_'.$___Ls->id_rnd.'").owlCarousel({
																				  /*autoPlay: true,*/
																				  stopOnHover: true,
																				  navigation : true,
																				  slideSpeed : 300,
																				  paginationSpeed : 400,
																				  navigation: true,
																				  singleItem:true 
																			});
																		
																		});	
																		
																	});  
							  
														';
														
														
														$CntWb .= "
														
														_ldCnt({ 
															u:'".Fl_Rnd(FL_DT_GN.__t('enc_grph',true).$_adsch.$___Ls->ls->vrall)."&_enc=".$___Ls->dt->rw['id_enc']."&_w=1100&_h=300', 
															c:'bx_grph', 
															trs:false 
														});
														
														$('#bx_grph2').hover(function() {
															if($(this).is(':empty') && $(this).is(':visible')){
																_ldCnt({ 
																	u:'".Fl_Rnd(FL_DT_GN.__t('enc_grph2',true).$_adsch.$___Ls->ls->vrall)."&_enc=".$___Ls->dt->rw['id_enc']."&_w=1100&_h=300',
																	c:'bx_grph2', 
																	trs:false 
																});
															}
														});		
														
														$('#bx_grph3').hover(function() {
															if($(this).is(':empty') && $(this).is(':visible')){
																_ldCnt({
																	u:'".Fl_Rnd(FL_DT_GN.__t('enc_grph3',true).$_adsch.$___Ls->ls->vrall)."&_enc=".$___Ls->dt->rw['id_enc']."&_w=1100&_h=300', 
																	c:'bx_grph3', 
																	trs: false
																});
															}
														});	
														
													";	 ?>
													
												</div>   
        								</div>
                          				</div>
                        </div>
                        <?php if($___Ls->dt->tot == 1){ ?>
	                        <div class="TabbedPanelsContent">
	                                 <!-- Inicia Sectores FACULTADES -->
	                                        <div class="ln">
	                                            <?php echo bdiv(['id'=>DV_LSFL.$__idtp_frm]) ?>
	                                        </div> 
	                                 <!-- Finaliza Sectores FACULTADES -->
	                                 
	                        </div> 
	                        <div class="TabbedPanelsContent">
	                                 <!-- Inicia Sectores FACULTADES -->
	                                        <div class="ln">
	                                             <?php echo bdiv(['id'=>DV_LSFL.$__idtp_cnt]) ?>
	                                        </div> 
	                                 <!-- Finaliza Sectores FACULTADES -->
	                                 
	                        </div>   
                        <?php } 
	                        
	                        $CntWb .= "$('#TbGrp1').click(function(){ $('#".ID_BTNSVE.$__bdtp.$__prfx_fm."').show(); }); ";
							$CntWb .= "$('#".TBGRP.$__idtp_frm."').click(function(){ $('#".ID_BTNSVE.$__bdtp.$__prfx_fm."').hide(); }); ";
							$CntWb .= "$('#".TBGRP.$__idtp_cnt."').click(function(){ $('#".ID_BTNSVE.$__bdtp.$__prfx_fm."').hide(); }); ";
                        ?>     
                           <?php    
	                           
			                    $CntJV .= _DvLsFl_Vr([ 'i'=>$___Ls->dt->rw[$___Ls->ino], 'n'=>$__idtp_frm, 't'=>'enc_fld', 't2'=>$___Ls->gt->tsb ]);
			                    $CntJV .= _DvLsFl_Vr([ 'i'=>$___Ls->dt->rw[$___Ls->ino], 'n'=>$__idtp_cnt, 't'=>'enc_cnt', 't2'=>$___Ls->gt->tsb ]);
			
										  	  
								$CntWb .= _DvLsFl([ 'i'=>$__idtp_frm ]);
								$CntWb .= _DvLsFl([ 'i'=>$__idtp_cnt ]);
										  
              				?>                                   
              </div>
              
            </div>   
        </div>

    </form>
  </div>
</div>
<?php } ?>
<?php } ?>