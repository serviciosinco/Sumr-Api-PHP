<?php
if(class_exists('CRM_Cnx')){
	
	
	$___Ls->cnx->cl = 'ok';
	$___Ls->img->dir = DIR_IMG_WEB_EMP;
	$___Ls->sch->f = 'emp_rs, emp_nit';
	
	$___Ls->new->big= 'ok';
	$___Ls->_strt();

	$__lsgt_flt_cmp = '_empcd, _empest, _empsec, _empscec';
	
	if(_Chk_GET('fl_empcd')){ $__fl .= _AndSql('emp_cd', $_GET['fl_empcd']);  }
	if(_Chk_GET('fl_empest')){ $__fl .= _AndSql('emp_est', $_GET['fl_empest']); }
	if(_Chk_GET('fl_empsct')){ $__fl .= _AndSql('emp_sct', $_GET['fl_empsct']); }
	if(_Chk_GET('fl_empscec')){ $__fl .= _AndSql('emp_scec', $_GET['fl_empscec']); }
	
	
	if(!isN($___Ls->gt->i)){	
		
		$___Ls->qrys = sprintf("SELECT * FROM ".MDL_EMP_BD." WHERE ".$___Ls->ik." = %s LIMIT 1", GtSQLVlStr($___Ls->gt->i, "text"));
		
	}elseif($___Ls->_show_ls == 'ok'){ 


		$Ls_Whr = "FROM ".MDL_EMP_BD." _a
						INNER JOIN "._BdStr(DBM).MDL_SIS_CD_BD." _b ON emp_cd = id_siscd
						INNER JOIN "._BdStr(DBM).TB_SIS_SLC." _d ON emp_est = _d.id_sisslc
						INNER JOIN "._BdStr(DBM).TB_SIS_SLC." _e ON emp_sct = _e.id_sisslc 
						INNER JOIN "._BdStr(DBM).TB_SIS_SLC." _f ON emp_scec = _f.id_sisslc
				   WHERE ".$___Ls->ino." != '' $__fl ".$___Ls->sch->cod." ORDER BY ".$___Ls->ino." DESC";
		
		$Dt_Logo = " (SELECT fllorg_logo FROM  "._BdStr(DBM).TB_FLL_ORG." WHERE fllorg_web = SUBSTRING_INDEX(SUBSTRING_INDEX(REPLACE(REPLACE(LOWER(emp_web), 'https://', ''), 'http://', ''), '/', 1), '?', 1) ) AS __logo ";
				   
		$___Ls->qrys = "SELECT *, ".$Dt_Logo.",(SELECT COUNT(*) $Ls_Whr) AS ".QRY_RGTOT." $Ls_Whr";
	
	} 

	
	$___Ls->_bld();
	

	
	if(!isN($___Ls->dt->rw['emp_web'])){ 
		$__snddt = ['fll'=>'ok']; 
		$_dt_emp = GtEmpDt($___Ls->dt->rw[$___Ls->ino], $__snddt);
	}
	
?>
<?php if($___Ls->ls->chk=='ok'){ ?>
<?php $___Ls->_bld_l_hdr(); ?>
<?php if(($___Ls->qry->tot > 0)){ ?>
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="Ls_Rg LsRgNw">
    <tbody>
    	<?php do { ?>
		<?php $img_th = _ImVrs(['img'=>$___Ls->ls->rw['__logo'], 'f'=>DMN_FLE_FLL]); ?>
		<tr>
	        <td width="1%" class="__sgm_ls"></td>
	        
	        <?php 
	            if($___Ls->ls->rw['__sbClr'] != NULL){ 
	            $_clr_U = explode(',', $___Ls->ls->rw['__sbClr']) ;
	            	foreach ($_clr_U as &$clr_u) { 
	                	$_clrs .= Spn('','', '_clr_icn','background-color:'.$clr_u.'; '); 
	            	} 
	            }
	        ?>
	        
	        <td width="1%" <?php echo NWRP ?>><div class="_img_o" style="background-image:url(<?php echo $img_th->th_100 ?>);"></div></td>
	        <td width="35%" align="left" <?php echo $_clr_rw ?>>
	            <?php 
		            echo h2(ctjTx($___Ls->ls->rw['emp_rs'],'in')).$_clrs.Spn(ctjTx($___Ls->ls->rw['emp_nit'],'in'),'','_f'); 
	                echo $___Ls->ls->rw['emp_fll_fnd']!=''?HTML_BR.Spn(TX_FNDC.' '.$___Ls->ls->rw['emp_fll_fnd'],'','_f'):'';   
	            ?>       
	        </td>
	        <td width="10%" align="left" nowrap="nowrap" <?php echo $_clr_rw ?>>
	            <?php echo $___Ls->ls->rw['emp_fll_eply']!=''?$___Ls->ls->rw['emp_fll_eply'].HTML_BR.Spn(TX_EMPLY,'','_f'):'' ?>
	        </td>
	        <td width="10%" align="left" nowrap="nowrap" <?php echo $_clr_rw ?>><?php echo $___Ls->ls->rw['emp_fi'].HTML_BR.Spn(TX_FIN,'','_f') ?></td>
	        <td width="10%" align="left" nowrap="nowrap" <?php echo $_clr_rw ?>>
	            <?php echo $___Ls->ls->rw['emp_fa']!=''?$___Ls->ls->rw['emp_fa'].HTML_BR.Spn(TX_FA,'','_f'):'' ?>
	        </td>
	        <td width="1%" align="left" nowrap="nowrap"><?php echo $___Ls->_btn([ 't'=>'mod' ]); ?></td>
      	</tr>
	  	<?php  $_clrs = ''; } while ($___Ls->ls->rw = $___Ls->sql->fetch_assoc()); ?>
    </tbody>
</table>
<?php $___Ls->_bld_l_pgs(); ?>
			
			
<?php } ?>

<?php $___Ls->_h_ls_nr(); ?>
<?php } ?>
<?php if($___Ls->fm->chk=='ok'){ ?>
<div class="FmTb">
  <div id="<?php echo $___Ls->fm->bx->id ?>" class="<?php echo DV_GNR_FM_BX ?>" >

    
    <form method="POST" name="<?php echo $___Ls->fm->id; ?>" target="_self" id="<?php echo $___Ls->fm->id; ?>">
      <?php $___Ls->_bld_f_hdr(); ?>

	 	
	 	<?php $__rnd_mp = Gn_Rnd(10); $__id_map = 'mapdt_'.$__rnd_mp; $__id_map_sch = 'MapSch_'.$__rnd_mp; ?>


            <div class="mapbck _ovrmap_emp" style="height:auto;">		   
                <div class="_ovrmap_logo">
                	<?php echo _DivLogoTM([ 'i'=>$_dt_emp->logo_s->th_200, 'c'=>$_dt_emp->clr ]); ?>
                </div>
            </div>    

                    
                    	

		<div id="<?php echo $___Ls->fm->fld->id ?>" class="<?php echo DV_GNR_FM_CMP ?>">

	  
      	<?php 
			$_id_tbpnl = 'TabPnl_'.Gn_Rnd(20); 
			$CntWb .= " SUMR_Main.bxajx.".$_id_tbpnl." = new Spry.Widget.TabbedPanels('".$_id_tbpnl."'); "; 
			
			$__idtp_cnt = '_cnt';	
			$__idtp_vst = '_vst';
			$__idtp_ofr = '_ofr';
			$__idtp_grp = '_grp';
			$__idtp_his = '_his';
			$__idtp_rsp = '_rsp';
		?>
        <div id="<?php echo $_id_tbpnl ?>" class="VTabbedPanels">
              <ul class="TabbedPanelsTabGroup">
                    <li class="TabbedPanelsTab" id="TbGrp1">
                    	<?php echo Spn('','','_tt_icn _tt_icn_logo', "background-image:url(".$_dt_emp->logo_s->th_50.")").Spn(TX_DTSBSC,'','_tx') ?>
                    </li>
                    <?php if($___Ls->dt->tot == 1){ ?>
						
                        <li class="TabbedPanelsTab <?php echo $_cls_tb ?>" id="<?php echo TBGRP.$__idtp_cnt ?>">
                        	<?php echo Spn('','','_tt_icn _tt_icn_cnt'). Spn(TX_CNT,'','_tx') . Spn($_dt_emp->tot_cnt,'ok','_n','', TBGRP.$__idtp_cnt.'_c') ?>
                        </li>

                        <li class="TabbedPanelsTab <?php echo $_cls_tb ?>" id="<?php echo TBGRP.$__idtp_vst ?>">
                        	<?php echo Spn('','','_tt_icn _tt_icn_vst'). Spn(TX_VST,'','_tx') . Spn($_dt_emp->tot_vst,'ok','_n','', TBGRP.$__idtp_vst.'_c') ?>
                        </li>
                        <li class="TabbedPanelsTab <?php echo $_cls_tb ?>" id="<?php echo TBGRP.$__idtp_ofr ?>">
                        	<?php echo Spn('','','_tt_icn _tt_icn_frmt'). Spn(TX_PROP,'','_tx').Spn($_dt_emp->tot_ofr,'ok','_n','', TBGRP.$__idtp_ofr.'_c') ?>
                        </li>

                        <li class="TabbedPanelsTab <?php echo $_cls_tb ?>" id="<?php echo TBGRP.$__idtp_grp ?>">
                        	<?php echo Spn('','','_tt_icn _tt_icn_crc'). Spn(TX_EMP_GRP,'','_tx') ?>
                        </li>
                        
                        <li class="TabbedPanelsTab <?php echo $_cls_tb ?>" id="<?php echo TBGRP.$__idtp_his ?>">
                        	<?php echo Spn('','','_tt_icn _tt_icn_crc'). Spn(TX_GSTN,'','_tx') ?>
                        </li>	
                        
                        <li class="TabbedPanelsTab <?php echo $_cls_tb ?>" id="<?php echo TBGRP.$__idtp_rsp ?>">
                        	<?php echo Spn('','','_tt_icn _tt_icn_cnt'). Spn(MDL_TR_RSP,'','_tx') ?>
                        </li>	
                    
                    <?php } ?>
              </ul>
              <div class="TabbedPanelsContentGroup">
                <div class="TabbedPanelsContent">

	                <?php if($___Ls->dt->tot == 0){ ?>
	              
	                	<div class="__sch_json" id="__sch_json">
		                	
                                <?php 	
	                                $CntWb .= "
                                    	
                                    	
                                    	$('.ln_1').hide();
                                    	$('#__sch_json_btn').click(function(){
										    var __i = $('#psg_nm_sch').val();
										    if($('#psg_nm_sch').valid()){ __sch_cnt(__i); }
                                        });
                                        
                                        
                                        function __sch_cnt(__i){
	                                        	
	                                        	$.post('".Fl_Rnd(FL_JSON_GN.__t('emp',true))."',{
                                                    _i: __i 
                                                },
                                                function(d, status){
                                                    
                                                    if(d.e == 'ok'){
                                                        
                                                        $('#id_emp').val(d.id);
														_ldCnt({ u:'".Fl_Rnd(FL_LS_GN.__t('emp',true))."'+'".ADM_LNK_DT."'+d.id });
														
														$('.cnt_lst').show();
														$('#__fm_col').slideDown('slow');
														$('#__sch_json').slideToggle(200); 
														
                                                    }else if(d.e == 'no'){
	                                                    
	                                                    $('.ln_1').show();
														$('#____edt').hide();
                                                        $('#____edt_dtl').hide();
                                                        $('#__fm_col').slideDown('slow');
                                                        $('#__sch_json').slideToggle(200);

                                                    }
                                                });
                                        }
                                        
                                      function __ShwDwn(){ ".PgRg($__ls, __t('dwn') )." } 
                                  
                                       
                                ";
                                
                                ?>
                                <div class="_c1"><?php echo HTML_inp_tx('psg_nm_sch', TX_NIT, '', FMRQD); ?></div>
                                <div class="_c2"><input id="__sch_json_btn" name="__sch_json_btn" type="button" class="br_rds grd_blue" value="<?php echo TX_SCH ?>" /></div>
                        </div> 
                    <?php  }  ?>    
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
	
										<?php echo h1( ctjTx($___Ls->dt->rw['emp_rs'],'in') ); ?>
										 
										<div class="_pic">
											<div id="__grph_crsl_pic" class="owl-carousel">
										        <?php if($_dt_emp->fll->pht != NULL){ ?>
											        <?php foreach($_dt_emp->fll->pht as $_k => $_v){ ?>
											        <div class="item"><img src="<?php echo $_v->url ?>" /></div>
											        <?php } ?>
										        <?php }else{ ?>
										        	<div class="item"><img src="<?php echo DMN_IMG_ESTR; ?>us_nop.png" /></div>
										        <?php } ?>
										    </div>  
										</div>
	
	
										<ul class="ls_1" >

											<li><?php echo Strn(TX_NIT.': '). ctjTx($___Ls->dt->rw['emp_nit'],'in') ; ?></li>
											<li><?php echo Strn(TX_DIRC.': '). ctjTx($___Ls->dt->rw['emp_dir'],'in') ; ?></li>
											<li><?php echo Strn(TX_FNT.': '). ctjTx($___Ls->dt->rw['emp_fnt'],'in') ; ?></li>
											<li><?php echo Strn(TX_BTN_WB.': '). ctjTx($___Ls->dt->rw['emp_web'],'in') ; ?></li>
										</ul>
										
										<?php 
											if($_dt_emp->fll->scl->html != NULL){ echo h2(TX_RDSC).$_dt_emp->fll->scl->html; }
									    	if($_dt_emp->fll->kyw->html != NULL){ echo h2(TX_KYW).$_dt_emp->fll->kyw->html; }
										?>
									</div>
									<div class="col_2">
										<?php echo h2( TX_ETDSRSM ); ?>
											<div id="__grph_crsl" class="owl-carousel">
										        <div class="item">	<div id="bx_grph" class="__bl"></div></div>
										        <div class="item">	<div id="bx_grph4" class="__bl"></div></div>
										        <div class="item">	<div id="bx_grph5" class="__bl"></div></div>
										        <div class="item">	<div id="bx_grph2" class="__bl"></div></div>
										        <div class="item">	<div id="bx_grph3" class="__bl"></div></div>
										    </div>
										    <?php 
											    

												$CntWb .= "
												
													_ldCnt({
														u:'".Fl_Rnd(FL_DT_GN.__t('alz_emp_grph',true).$_adsch.$___Ls->ls->vrall)."&_emp=".$___Ls->gt->i."&_w=1100&_h=300', 
														c:'bx_grph', 
														trs:false 
													});
													
													$('#bx_grph2').hover(function() {
														if($(this).is(':empty') && $(this).is(':visible')){
															_ldCnt({ 
																u:'".Fl_Rnd(FL_DT_GN.__t('alz_emp_grph2',true).$_adsch.$___Ls->ls->vrall)."&_emp=".$___Ls->gt->i."&_w=1100&_h=300', 
																c:'bx_grph2', 
																trs:false 
															});
														}
													});		
													
													$('#bx_grph3').hover(function() {
														if($(this).is(':empty') && $(this).is(':visible')){
															_ldCnt({ 
																u:'".Fl_Rnd(FL_DT_GN.__t('alz_emp_grph3',true).$_adsch.$___Ls->ls->vrall)."&_emp=".$___Ls->gt->i."&_w=1100&_h=300', 
																c:'bx_grph3', 
																trs:false 
															});
														}
													});			
													
													$('#bx_grph4').hover(function() {
														if($(this).is(':empty') && $(this).is(':visible')){
															_ldCnt({ 
																u:'".Fl_Rnd(FL_DT_GN.__t('alz_emp_grph4',true).$_adsch.$___Ls->ls->vrall)."&_emp=".$___Ls->gt->i."&_w=1100&_h=300', 
																c:'bx_grph4', 
																trs:false 
															});
														}
													});			
													
													$('#bx_grph5').hover(function() {
														if($(this).is(':empty') && $(this).is(':visible')){
															_ldCnt({ 
																u:'".Fl_Rnd(FL_DT_GN.__t('alz_emp_grph5',true).$_adsch.$___Ls->ls->vrall)."&_emp=".$___Ls->gt->i."&_w=1100&_h=300', 
																c:'bx_grph5', 
																trs:false 
															});
														}
													});		
														
	 ";											
											?>
									</div>
								</div>
							<?php } ?>		
										  
           					<div class="ln_1" id="__edt" <?php if($___Ls->dt->tot > 0){ ?>style="display: none;"<?php } ?> > 
               						    
									<div class="col_1" >
										 
                                      	<?php echo LsSis_PsOLD('emp_ps','id_sisps',  $___Ls->dt->rw['emp_ps'], TX_SLCPS, 2, '', '', ''); 
											//$CntWb .= JQ_Ls('emp_ps', '-', '', 'psFlg');
											$CntWb .= JQ_Ls('emp_ps', TX_SLCPS , 'psFlg');
											
													
											
											$CntWb .= "
											
												
												__id_tp = $('#emp_ps').val(); 
												
												if(__id_tp != 57){
													$('#emp_cd').val(1);
													$('._emp_cd').hide();
												}else{
													$('#emp_nit').addClass('".$_cls_nt."');
												}
												
												$('#emp_ps').change(function() {
													
													__id_tp = $(this).val();
													
													
													if(__id_tp != 57){
														$('#emp_cd').val(1);
														$('._emp_cd').hide();
													}else{
														$('._emp_cd').show();
														$('#emp_cd').val(1);
													}  
												});
		
												
												
												
												
												$('#emp_web').focusout(function(){ __getEmpUpdJs(); });
                                      
												function __getEmpUpdJs(){
											  			
											  			var __web = $('#emp_web').val(); 
											  	
								                        $.ajax({
															type: 'POST',
															dataType: 'json',
															timeout:30000,
															url:'".Fl_Rnd(FL_JSON_GN.__t("emp_upd",true))."'+'&Rd='+Math.random(),
															async: true,
															success: function(_d) {
																if( _d.img != undefined ){
																	$('._ovrmap_logo ._im img').attr('src', _d.img.s_200);
																	$('._tt_icn_logo').css('background-image','url('+_d.img.s_50+')');
																}
															},
															data: {
															  	'__emp': '".$___Ls->dt->rw['id_emp']."',
									                            '__emp_web': __web   
												            }
														});     
																		                        
								                } 
								                
								                
								                __getEmpUpdJs();
		
											";
										?>
									  	<?php echo HTML_inp_tx('emp_nit', TX_NIT, ctjTx(  $___Ls->dt->rw['emp_nit'],'in'), FMRQD,''); ?> 
                                        <?php echo HTML_inp_tx('emp_rs', TX_RS, ctjTx( $___Ls->dt->rw['emp_rs'],'in'), FMRQD,'', $_cls_rs.' '.$_cls_frc); ?>
                                        <?php echo HTML_inp_tx('emp_dir', TX_DIRC, ctjTx($___Ls->dt->rw['emp_dir'],'in'), '','',''); ?>
                                        <?php echo HTML_inp_tx('emp_fnt', TX_FNT, ctjTx($___Ls->dt->rw['emp_fnt'],'in')); ?> 
                                        <?php echo HTML_inp_tx('emp_web', 'Web', ctjTx($___Ls->dt->rw['emp_web'],'in'), FMRQD_URL); ?>  
                                        
									</div>
                                  	
								  	<div class="col_2" >
								  		<?php if($___Ls->dt->rw['emp_ps'] == 57 || !isset($___Ls->gt->i) ){?>
									  		<div class="_emp_cd"  style="display:<?php echo ($___Ls->dt->rw['emp_ps'] == 57)? "block" : "none" ; ?>">
										  		
										  		<?php echo LsCdOld(['id'=>'emp_cd', 'v'=>'id_siscd', 'va'=>$___Ls->dt->rw['emp_cd'], 'rq'=>1 ]);
														 $CntWb .= JQ_Ls('emp_cd',FM_LS_SLCD); 
											  	?>
										  		
	                                        	<?php //echo LsCdOld('emp_cd','id_siscd', $___Ls->dt->rw['emp_cd'], '', 1, ' _hdn'); $CntWb .= JQ_Ls('emp_cd',FM_LS_SLCD); ?>
	                                        </div>
                                        <?php }else{ echo HTML_inp_hd('emp_cd', ''); } ?>
                                        <?php 
	                                        $l = __Ls(['k'=>'emp_est', 'id'=>'emp_est', 'v'=>'id_sisslc', 'va'=>$___Ls->dt->rw['emp_est'] , 'ph' => FM_LS_EST]); 
	                                        echo $l->html; $CntWb .= $l->js; 
										?>
										<?php 
	                                        $l = __Ls(['k'=>'emp_sct', 'id'=>'emp_sct', 'v'=>'id_sisslc', 'va'=>$___Ls->dt->rw['emp_sct'], 'ph' => FM_LS_SLSCT ]); 
	                                        echo $l->html; $CntWb .= $l->js; 
	                                    ?>
                                        <?php 
	                                        $l = __Ls(['k'=>'emp_scec', 'id'=>'emp_scec', 'v'=>'id_sisslc', 'va'=>$___Ls->dt->rw['emp_scec'], 'ph' => FM_LS_SLSCT ]); 
	                                        echo $l->html; $CntWb .= $l->js; 
	                                    ?>
	                                    
										<?php echo HTML_inp_clr(['id'=>'emp_clr', 'plc'=>TX_CLR, 'vl'=>ctjTx($___Ls->dt->rw['emp_clr'],'in')]); ?>
									</div>
                            </div>             	 			 
                </div>
                
                
                <?php if($___Ls->dt->tot == 1){ ?>
                    
                    
						<?php //if(_ChckMd('emp_cnt_ls')){ ?>    
                            <div class="TabbedPanelsContent">
                                     <!-- Inicia Contactos -->
                                            <div class="ln">
                                                <?php echo bdiv(['id'=>DV_LSFL.$__idtp_cnt, 'cls'=>'_sbls']) ?>
                                            </div> 
                                     <!-- Finaliza Contactos -->
                            </div>
                        <?php //} ?>
                        <?php //if(_ChckMd('emp_vst_ls')){ ?> 
                           
                            <div class="TabbedPanelsContent">
                                            <!-- Inicia Contactos -->
                                                    <div class="ln">
                                                        <?php echo bdiv(['id'=>DV_LSFL.$__idtp_vst, 'cls'=>'_sbls']) ?>
                                                    </div> 
                                             <!-- Finaliza Contactos -->
                            </div>
                        <?php //} ?>
                        <?php //if(_ChckMd('emp_ofr_ls')){ ?>    
                            <div class="TabbedPanelsContent">
                                            <!-- Inicia Contactos -->
                                                    <div class="ln">
                                                        <?php echo bdiv(['id'=>DV_LSFL.$__idtp_ofr, 'cls'=>'_sbls']) ?>
                                                    </div> 
                                             <!-- Finaliza Contactos -->
                            </div>
                        <?php //} ?>
                        
                        <?php //if(_ChckMd('emp_grp_ls')){ ?>    
                            <div class="TabbedPanelsContent">
                                            <!-- Inicia Contactos -->
                                                    <div class="ln">
                                                        <?php echo bdiv(['id'=>DV_LSFL.$__idtp_grp, 'cls'=>'_sbls']) ?>
                                                    </div> 
                                            <!-- Finaliza Contactos -->
                            </div>
                            <div class="TabbedPanelsContent">
                                            <!-- Inicia Contactos -->
                                                    <div class="ln">
                                                        <?php echo bdiv(['id'=>DV_LSFL.$__idtp_his, 'cls'=>'_sbls']) ?>
                                                    </div> 
                                            <!-- Finaliza Contactos -->
                            </div>
                            <div class="TabbedPanelsContent">
                                            <!-- Inicia Contactos -->
                                                    <div class="ln">
                                                        <?php echo bdiv(['id'=>DV_LSFL.$__idtp_rsp, 'cls'=>'_sbls']) ?>
                                                    </div> 
                                            <!-- Finaliza Contactos -->
                            </div>
                        <?php //} ?>
                    
                <?php } 
	                $CntWb .= "$('#TbGrp1').click(function(){ $('#".ID_BTNSVE.$__bdtp.$__prfx_fm."').show(); }); ";
					$CntWb .= "$('#".TBGRP.$__idtp_cnt.", #".TBGRP.$__idtp_vst.", #".TBGRP.$__idtp_ofr.", #".TBGRP.$__idtp_grp.", #".TBGRP.$__idtp_his.", #".TBGRP.$__idtp_bco.", #".TBGRP.$__idtp_rsp."').click(function(){ $('#".ID_BTNSVE.$__bdtp.$__prfx_fm."').hide(); }); ";
                ?>
                
                
              </div>
			  <?php       
                    $CntJV .= _DvLsFl_Vr(['i'=>$___Ls->dt->rw[$___Ls->ino], 'n'=>$__idtp_cnt, 't'=>$__prfx->prfx2_c.'_cnt']) .
							  _DvLsFl_Vr(['i'=>$___Ls->dt->rw[$___Ls->ino], 'n'=>$__idtp_vst, 't'=>$__prfx->prfx2_c.'_vst']) .
							  _DvLsFl_Vr(['i'=>$___Ls->dt->rw[$___Ls->ino], 'n'=>$__idtp_ofr, 't'=>$__prfx->prfx2_c.'_ofr']) .
							  _DvLsFl_Vr(['i'=>$___Ls->dt->rw[$___Ls->ino], 'n'=>$__idtp_grp, 't'=>$__prfx->prfx2_c.'_grp']) .
							  _DvLsFl_Vr(['i'=>$___Ls->dt->rw[$___Ls->ino], 'n'=>$__idtp_his, 't'=>$__prfx->prfx2_c.'_his']) .
							  _DvLsFl_Vr(['i'=>$___Ls->dt->rw[$___Ls->ino], 'n'=>$__idtp_rsp, 't'=>$__prfx->prfx2_c.'_rsp']);
					
					$CntWb .= _DvLsFl(['i'=>$__idtp_cnt]) . 
							  _DvLsFl(['i'=>$__idtp_vst]) . 
							  _DvLsFl(['i'=>$__idtp_ofr]) . 
							  _DvLsFl(['i'=>$__idtp_grp]) . 
							  _DvLsFl(['i'=>$__idtp_his]) .
							  _DvLsFl(['i'=>$__idtp_rsp]); 
					
					
					$CntWb .= "SUMR_Main.ls.btn({i:'TbGrp1', i2:'".TBGRP.$__idtp_cnt."', t:'".strtoupper('snd')."', tb:'{$_id_tbpnl}' });	";
					$CntWb .= "SUMR_Main.ls.btn({i:'TbGrp1', i2:'".TBGRP.$__idtp_vst."', t:'".strtoupper('snd')."', tb:'{$_id_tbpnl}' });	";
					$CntWb .= "SUMR_Main.ls.btn({i:'TbGrp1', i2:'".TBGRP.$__idtp_ofr."', t:'".strtoupper('snd')."', tb:'{$_id_tbpnl}' });	";
					$CntWb .= "SUMR_Main.ls.btn({i:'TbGrp1', i2:'".TBGRP.$__idtp_grp."', t:'".strtoupper('snd')."', tb:'{$_id_tbpnl}' });	";
					

              ?>
							  
        </div>
        
        
        
      </div>
    </form>
  </div>
  
		<?php 
			$CntJV .= " 
				
				function __NxtEmp(a, t){
					var _t = t;
					if(a == 'nxt_cnt'){
						$('#".TBGRP.$__idtp_2."_c').empty().append('('+_t+')');
							$('#".TBGRP.$__idtp_cnt."').removeClass('_hd').effect('highlight');
					
					} else if(a == 'nxt_vst'){
						$('#".TBGRP.$__idtp_cnt."_c').empty().append('('+_t+')');
						$('#".TBGRP.$__idtp_vst."').removeClass('_hd').effect('highlight');
						$('#".TBGRP.$__idtp_ofr."').removeClass('_hd').effect('highlight');
						
					} else if(a == 'nxt_ofr'){
						$('#".TBGRP.$__idtp_vst."_c').empty().append('('+_t+')');
						$('#".TBGRP.$__idtp_ofr."').removeClass('_hd').effect('highlight');
			
					} else if(a == 'last'){
						$('#".TBGRP.$__idtp_ofr."_c').empty().append('('+_t+')');
						
					}
				} 
			";
		?>
</div>
<?php } ?>
<?php } ?>