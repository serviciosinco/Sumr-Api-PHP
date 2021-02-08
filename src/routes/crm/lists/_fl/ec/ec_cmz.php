<?php	
if(class_exists('CRM_Cnx')){
		 
	$___Ls->cnx->cl = 'ok';
	$___Ls->tp = 'ec_cmz';
	$___Ls->sch->f = 'ec_tt, ec_dsc, ec_lnk, ec_pml, ec_ord';
	$___Ls->_strt();
	
	if(_SbLs_ID('i')){ $__fl .= _AndSql($__pro_rlc, _SbLs_ID('i')); }
	
	if(!isN($___Ls->mdlstp->id)){
		
		$_f_tp = " AND (
							id_ec IN ( SELECT ecmdlstp_ec 
								  FROM "._BdStr(DBM).TB_EC_TP." 
								  WHERE ecmdlstp_ec = id_ec AND ecmdlstp_mdlstp = ".$___Ls->mdlstp->id."
								) 
							||	
							
							id_ec NOT IN ( SELECT ecmdlstp_ec 
								  FROM "._BdStr(DBM).TB_EC_TP." 
								) 
						)
				";
	}
	
	if(!isN($___Ls->gt->i)){	

		$_sgm = ", (SELECT GROUP_CONCAT(id_eccmzsgm SEPARATOR ', ') 
					FROM "._BdStr(DBM).TB_EC_CMZ_SGM."
					WHERE id_eccmz = eccmzsgm_eccmz 
					ORDER BY id_eccmzsgm DESC) AS __sgm ";
					
		$___Ls->qrys = sprintf("SELECT * $_sgm {$_fac} 
								FROM "._BdStr(DBM).TB_EC." 
									 INNER JOIN "._BdStr(DBM).TB_EC_CMZ." ON eccmz_ec = id_ec 
								WHERE eccmz_enc = %s 
								LIMIT 1", GtSQLVlStr($___Ls->gt->i, "text")); 

		
	}elseif($___Ls->_show_ls == 'ok'){ 
	
		$_sgm = ", (	SELECT GROUP_CONCAT(id_eccmzsgm SEPARATOR ', ') 
						FROM "._BdStr(DBM).TB_EC_CMZ_SGM." 
						WHERE id_eccmz = eccmzsgm_eccmz 
						ORDER BY id_eccmzsgm DESC) AS __sgm ";
						
		$Ls_Whr = "	FROM "._BdStr(DBM).TB_EC."
						 INNER JOIN "._BdStr(DBM).TB_CL." ON ec_cl = id_cl
						 INNER JOIN "._BdStr(DBM).TB_EC_CMZ." ON eccmz_ec = id_ec
						 "._BdStr(DBM).TB_US." ON eccmz_us = id_us 
					WHERE cl_enc = '".DB_CL_ENC."' AND ".$___Ls->ino." != '' ".$___Ls->sch->cod." $_f_tp 
					ORDER BY ".$___Ls->ino." DESC";
					
		$___Ls->qrys = "SELECT *, (SELECT COUNT(*) $Ls_Whr) AS ".QRY_RGTOT." {$_sgm} $Ls_Lst $Ls_Tot_Fb $Ls_Whr";
	
	} 

	$___Ls->_bld();

?>
<?php if($___Ls->ls->chk=='ok'){ ?>
<?php $___Ls->_bld_l_hdr(); ?>
<?php if(($___Ls->qry->tot > 0)){ ?>


<div class="ec_cmz_edt">
	<ul class="ul_lst ">
		<?php do { ?>
	  		<li class="li_lst">

	  			<div class="dv_img" style="background-image: url(); "><?php echo _LdImg([ 's'=>DIR_IMG_WEB_EC_TH.$___Ls->ls->rw[$__imgid], 'i'=>$___Ls->ls->rw[$___Ls->ino] ]); ?></div>

	  			<div class="dv_lst">
		  			<?php  
			  			
			  			if($___Ls->ls->rw['eccmz_nm'] != ''){ 
			  			
			  				$_tt_ls = $___Ls->ls->rw['eccmz_nm'].' ('.$___Ls->ls->rw['us_nm'].' '.$___Ls->ls->rw['us_ap'].')'; 
			  			
			  			}else{ 
				  			
				  			$_tt_ls = $___Ls->ls->rw['ec_tt']; 
				  		
				  		}
				  		 
		  				echo Spn(ShortTx(ctjTx($_tt_ls,'in'),40,'Pt'),'','_t_lst'); 
		  			
		  			?>
				    <?php if(_ChckMd('snd_ec_mod')){ ?>
				    
	                	<?php $CntWb .= " $('.sp-container').remove(); "; ?>
	                	
	                	<div class="_btn">
		                	
		                	<?php 
			                	  

	                            $_lnktr_l = FL_LS_GN.__t($__bdtp,true)._SbLs_ID().ADM_LNK_DT.$___Ls->ls->rw[$___Ls->ino].$___Ls->ls->vrall.$_adsch;

	                            $_lnktr = _Ls_Lnk_Rw(['l'=>$_lnktr_l, 'sb'=>$__lssb, 'r'=>$___Ls->bx_rld, 'w'=>'90%', 'h'=>'90%']);
	                            cl($_lnktr); 
	                            
			                ?>
			                
			                <a href="<?php echo DMN_EC_PRVW.LNK_HTML.'/'.$___Ls->ls->rw['ec_enc'].'/?_Cmz='.$___Ls->ls->rw['eccmz_enc'] ?>" target="_blank">
				            	<img src="<?php echo DMN_IMG_ESTR ?>icn/ls_outl.png" width="25" height="25" />
				            </a>
	                	</div>
	                	
	                <?php } ?>
	                
	            </div>
	  		</li> 
		<?php } while ($___Ls->ls->rw = $___Ls->sql->fetch_assoc()); ?>
	</ul>
</div>



<?php $___Ls->_bld_l_pgs(); ?>
<?php } ?>

<?php $___Ls->_h_ls_nr(); ?>
<?php } ?>
<?php if($___Ls->fm->chk=='ok'){ ?>
<div class="FmTb ec_cmz_bldr">
  <div id="<?php echo $___Ls->fm->bx->id ?>">                  
    <!--<form method="POST" name="<?php echo $___Ls->fm->id; ?>" target="_self" id="<?php echo $___Ls->fm->id; ?>" >-->
		
	       	<?php 
		       
		       	if($___Ls->dt->tot > 0){					
					$_gt_ec = ChkEcCmzEc([ 'eccmz'=>$___Ls->dt->rw[$___Ls->ino] ]);
					$___cmpg_btn = Gn_Rnd(20);
			   	}
	  
	  		?>

            <div id="<?php echo $___Ls->fm->fld->id ?>">	
					
					<div class="ln_1 ec_cmz_edt" id="__edt_dtl">

						<?php if($___Ls->dt->tot < 1){ // Registro nuevo ?>
		            	
		            	<div class="___slc">
			            		
		            		<div class="c1">
								<div class="icn"></div>
								<?php echo h1('Selección de '.HTML_BR.Spn('Diseño')); ?>
								<p>Puedes escoger del siguiente listado, la plantilla o estructura que mejor se adapte a tu nuevo pushmail.</p>
						
							</div>	
							
							<div class="c2">
							
			            		<div id="__grph_crsl_opt_<?php echo $__rnd_op; ?>" class="ul_lst owl-carousel owl-theme ec-tmpl-dsgn">
									<?php
	
										if(_ChckMd('psh_clr') || ChckSESS_superadm()){ $fl = ''; }else{ $fl = 'AND id_ec != 1'; }

										if(defined('SISUS_ARE') && !isN(SISUS_ARE) && !ChckSESS_superadm()){
			
											$_f_are = ' AND (	
																id_ec IN (	SELECT ecare_ec 
																			FROM '._BdStr(DBM).TB_EC_ARE.'
																			WHERE ecare_are IN ('.SISUS_ARE.')
																		)
																||
																
																id_ec NOT IN (	SELECT ecare_ec 
																				FROM '._BdStr(DBM).TB_EC_ARE.'
																			)	
															) '; 
										
										}	
										
										
										$Ls_Qry = "	SELECT * 
													FROM "._BdStr(DBM).TB_EC." 
														 INNER JOIN "._BdStr(DBM).TB_CL." ON ec_cl = id_cl
													WHERE 	cl_enc = '".DB_CL_ENC."' AND 
															ec_cmz = 1 AND 
															ec_cmzrlc IS NULL 
															$_f_tp 
															$_f_are
															$fl	
													ORDER BY id_ec ASC";
										
										$Ls = $__cnx->_qry($Ls_Qry);
										
										if($Ls){
											
											$row_Ls = $Ls->fetch_assoc(); 
											$Tot_Ls = $Ls->num_rows; 
											
											if($Tot_Ls > 0){
												
												$i = 0;
											
												do {
													
													$img_th = _ImVrs([ 'img'=>$row_Ls['ec_img'], 'f'=>DMN_FLE_EC_IMG, 'img_ste'=>$row_Ls['id_ec'] ]);

													
													$Vl[$i]['html'] .= '<div class="item" style="width:250px">';					
													$Vl[$i]['html'] .= '<div id="_ls_clk_'.$row_Ls['id_ec'].'" class="li_lst _ls _anm">';
													$Vl[$i]['html'] .= '<div class="dv_img" style="background-image:url('.$img_th->th_100.'); "></div>';
													$Vl[$i]['html'] .= '<div class="dv_lst">'. Spn(ShortTx(ctjTx($row_Ls['ec_tt'],'in'),40,'Pt'),'','_t_lst __ls').'</div>';
													$Vl[$i]['html'] .= '<input id="edcmz_ec_'.$row_Ls['id_ec'].'" name="edcmz_ec" type="hidden" value="'.$row_Ls['id_ec'].'" />';
													$Vl[$i]['html'] .= '</div>';
													$Vl[$i]['html'] .= '</div>';
													
													$Vl[$i]['js'] .= " _vle_".$row_Ls['id_ec']." = $('#edcmz_ec_".$row_Ls['id_ec']."').val();";
													$Vl[$i]['js'] .= "$('#_ls_clk_".$row_Ls['id_ec']."').off('click').click(function (){ 
																		SUMR_Ec.f.edt_new({
																					'_t':'snd_ec_cmz',
																					'_t2':'".$___Ls->mdlstp->tp."',
																					'bxrld':'".$___Ls->bx_rld."',
																					'_d':{
																						'MM_insert':'EdEcCmz',
																						'eccmz_ec': '".$row_Ls['id_ec']."'
																					}
																			});																					 																						 
																		});
																";
													$i++;
												
												} while ($row_Ls = $Ls->fetch_assoc());
											
											}else{
												
												echo h1('No hay plantillas actualmente');
												
											}
										
										}
											
										$_ls_add = _jEnc($Vl);

										foreach($_ls_add as &$_ad_itm){
											echo $_ad_itm->html;
											$CntWb .= $_ad_itm->js;
										}
										
										$CntWb .= '
											SUMR_Main.ld.f.owl( function(){	
												SUMR_Main.ld.f.knob( function(){	
													$("#__grph_crsl_opt_'.$__rnd_op.'").owlCarousel({
														margin:5,
														items:3,
														nav: true
													});	
												});		
											});
										';
			
									?>
								</div>
			            
							</div>
							
		            	</div>
		            		
			            <?php }else{ ?> 
			            
			            	<?php if($___Ls->dt->tot == 0){  ?>
			            	
								<?php echo HTML_inp_tx('eccmz_nm', TX_NM, ctjTx($___Ls->dt->rw['eccmz_nm'],'in'), 2); ?>
								<?php echo HTML_inp_tx('eccmz_sbj', TX_SBJCT, ctjTx($___Ls->dt->rw['eccmz_sbj'],'in'), 2); ?>
			            		
			            	<?php }else{ ?>
			            	
			            	<div class="_see_ec _anm _cntr">   
								
					            <div class="mrk"></div>
					            <div class="spnr"></div>
								
								<?php

									if(isN($_gt_ec->enc)){ echo 'Problems to get data'; }

								    $_id_tbpnl = 'TabPnl_'.Gn_Rnd(20); 
								    $_id_tbpnl_snd = 'TabPnl_'.Gn_Rnd(20); 
								    
								    $_id_tbpnl_edt = $_id_tbpnl.'_edt';
								    $_id_tbpnl_vw = $_id_tbpnl.'_vw'; 
								    $_id_tbpnl_cmz = $_id_tbpnl.'_cmz'; 
								    
								    
								    $__startedit = Php_Ls_Cln($_GET['_start']);
								    if($__startedit == 'ok'){ $__tb_str = '0'; }else{ $__tb_str = '1'; }
								    
								    $CntJV .= " SUMR_Main.bxajx.".$_id_tbpnl." = new Spry.Widget.TabbedPanels('".$_id_tbpnl."', { defaultTab: {$__tb_str} }); 
								    
								    	
								    	$('#".$_id_tbpnl_vw."').off('click').click(function (){ 	
											
											SUMR_Ec.f.edt_op_pnl({});
											SUMR_Ec.f.edt_spnr({ id:'._see_ec', e:'o' });
											
											$('#cnt_vw').on('load', function(){
										    	SUMR_Ec.f.edt_spnr({ id:'._see_ec' });
										    });
										    
											$('#cnt_vw').delay(10000).attr('src', '".DMN_EC_PRVW.LNK_HTML.'/'.$_gt_ec->enc."/?_prvw=ok&__edit=ok&__l=ok&Rd='+Math.random());
											
										});
										
										
										$('#".$_id_tbpnl_cmz."').off('click').click(function (){ 	
											SUMR_Ec.f.edt_op_pnl({});	
										});
										
										
										$('#".$_id_tbpnl_edt."').off('click').click(function (){ 	
											SUMR_Ec.f.edt_op_pnl({ _op:'ok' });
										});
										
								    ";
								    
								?>
								<div id="<?php echo $_id_tbpnl ?>" class="TabbedPanels TbEdt TbCol EcCmzDsgnTabs">
								      <ul class="TabbedPanelsTabGroup">
								            <li class="TabbedPanelsTab icn_cmz tbPnlCmz" style="margin-right:50px;" <?php /* ?>style="float: left!important;" <?php*/ ?> id="<?php echo $_id_tbpnl_cmz; ?>"><span style="margin-left: 35px;color:#afb4b8;">Modelo</span></li>
								            <li class="TabbedPanelsTab icn_edt tbPnlEdt" style="margin-right:50px;" id="<?php echo $_id_tbpnl_edt; ?>"><span style="margin-left: 35px;color:#afb4b8;">Diseño</span></li>
								            <li class="TabbedPanelsTab icn_viw tbPnlViw" style="margin-right:80px !important;" id="<?php echo $_id_tbpnl_vw; ?>"><span style="margin-left: 40px;color:#afb4b8!important;white-space:nowrap;">Vista Previa</span></li> 
								      </ul>
								      <div class="TabbedPanelsContentGroup">
									      	<div class="TabbedPanelsContent _gray">
	
												<?php if($__startedit == 'ok'){ ?>
													<div class="_start_edit">	
														<div class="_start_wrp">
															<p>Este es el modelo seleccionado, recuérdalo para que tu diseño se ajuste a la misma estructura.</p>
															<a id="StartAll" href="javascript:void();">Iniciar Edición</a>
															<?php
															
																$CntWb .= "
																
																	$('#StartAll').click(function(){
																	
																		SUMR_Main.bxajx.$_id_tbpnl.showPanel(1); 
																	
																	});
																	
																";
																	
															?>
														</div>
													</div>
													
													<style>
														._start_edit{ width: 100%; z-index: 99999999; background-color: #009ed3; padding: 10px; }
														._start_edit ._start_wrp{ width: 100%; font-family: Economica; text-transform: uppercase; text-align: center; color: #ffffff; }
														._start_edit a{ background-color: #0adeff; color: #000000; border-radius: 102px 102px 102px 102px;
-moz-border-radius: 102px 102px 102px 102px;
-webkit-border-radius: 102px 102px 102px 102px; display: inline-block; padding: 10px 20px; text-decoration: none; }
														._start_edit a:hover{ background-color: #ffffff; }
														
													</style>	
													
												<?php } ?>
												
												<iframe id="cnt_cmz" src="<?php echo $___Ls->dt->rw['ec_dmo']; ?>" frameborder="0" width="100%" height="5000" ></iframe>
								            </div>
								            <div class="TabbedPanelsContent" style="padding-bottom: 600px;background-color:#<?php echo $___Ls->dt->rw['ec_fnd']; ?>;">
												<div class="cnt"></div>		    
								            </div>
								            <div class="TabbedPanelsContent">
												<iframe id="cnt_vw" frameborder="0" width="100%" height="5000" ></iframe>
								            </div>     
								                                     
								      </div>  
								</div>
								
								<div class="apr"> 
									<?php if($___Ls->dt->rw['ec_est'] != 6){ ?>
										<input type="button" class="s grd_blue aprb _anm" name="btn_aprb" id="btn_aprb" value="Aprobación"> 
									<?php } ?>
								</div>
				            </div>
				            
				            <?php $__id = Gn_Rnd(20); ?>
				            
				            <div class="_see_cmz _anm _expnd" id="_see_cmz_<?php echo $__id; ?>">
					            
					           	<button type="button" class="__btn _anm"  onclick="SUMR_Ec.f.edt_op_pnl({ _f:'btn' });"></button>
						        
						        <div class="_cntr _anm">    
						            
						            <div class="_bsc _anm">
							            
							            <?php
								            if($__ntfld != ''){ $_id_tbpnl_d = 2; }else{ $_id_tbpnl_d = 0; }
								            $__idtp_cmnt = 'ec_cmz_cmnt';
								            $CntJV .= " var ".$_id_tbpnl_snd." = new Spry.Widget.TabbedPanels('".$_id_tbpnl_snd."', {defaultTab:".$_id_tbpnl_d."}); ";
										?>
									
							            <div id="<?php echo $_id_tbpnl_snd ?>" class="TabbedPanels TbEcCmzOp TbCol">
							                  <ul class="TabbedPanelsTabGroup">
							                        <li class="TabbedPanelsTab _anm"><?php echo Spn('','','_anm _tt_icn _tt_icn_bsc') ?></li>
							                        
							                        <!--
							                        <li class="TabbedPanelsTab tab2"><?php echo Spn('','','_tt_icn _tt_icn_cmpg') ?></li>
							                        -->
							                        
							                        <li class="TabbedPanelsTab _anm"  id="<?php echo TBGRP.$__idtp_cmnt ?>"><?php echo Spn('','','_anm _tt_icn _tt_icn_cmnt') ?>
							                         	<?php 
								                         	$ecCmntRdTot = GtSisEcCmntRdTot(["id_ec"=>$_gt_ec->id]);
								                         	if($ecCmntRdTot->_tot == 0){ $_tot = '';
								                         	}else{ $_tot = $ecCmntRdTot->_tot; }
														?>
							                         	<spam class="_n cmnt_tb"><?php echo $_tot; ?></spam>
							                        </li>
   
							                  </ul>
							                  <div class="TabbedPanelsContentGroup">
							                        <div class="TabbedPanelsContent">
											            <?php echo HTML_inp_tx('eccmz_nm', TX_NM, ctjTx($___Ls->dt->rw['eccmz_nm'],'in'), 2); ?>
											            <?php echo HTML_inp_tx('eccmz_sbj', TX_SBJCT, ctjTx($___Ls->dt->rw['eccmz_sbj'],'in'), 2); ?>
											            <?php    
												            if(_ChckMd('snd_ec_cmz_est_mod')){ 
												            	$l = __Ls([ 'k'=>'sis_est', 'id'=>'ec_est', 'va'=>$_gt_ec->est, 'ph'=>TX_ETD ]); 
																echo $l->html; $CntWb .= $l->js;
												            }    
														?>

														<?php if($__dt_cl->tag->var->ec_hdrs->v == 'ok'){  ?>
															<div class="__hdrtp_slc _anm">
																<?php
																	echo LsEcCmzRlcTp('eccmz_rlchdr', '', $___Ls->dt->rw['eccmz_rlchdr'], '', 2); 
																	$CntWb .= JQ_Ls('eccmz_rlchdr',''); 
																	echo HTML_inp_hd('eccmz_rlchdr_w', ''); 
																	echo HTML_inp_hd('eccmz_rlchdr_h', '');
																?>	
															</div>
															<div class="__area_slc _anm" style="display:none;">
																<?php 
																	
																	if(_ChckMd('ls_are_all','ok')){ $_all = 'ok'; }else{ $_all = 'no'; }
																	
																	echo LsClAre([
																					'id'=>'eccmz_are',
																					'v'=>'id_clare',
																					'va'=>$___Ls->dt->rw['eccmz_rlchdr']==1?$___Ls->dt->rw['eccmz_are']:'' ,
																					'rq'=>2,
																					'mlt'=>'no',
																					'all'=>$_all
																				]); 
																		
																	$CntWb .= JQ_Ls('eccmz_are', MDL_CL_ARE, '', '_slcClr', ['ac'=>'no']); 
																				
																?>
															</div>
													    <?php } ?>
													    
							                        </div>
							                        
							                        <!--
							                        <div class="TabbedPanelsContent">
														
							                        </div>
							                        -->
							                        
													<div class="TabbedPanelsContent">
															<div class="__dts_snd">
																<div class="ln comments">
																	<?php //if(ChckSESS_superadm()){ ?>
																		<a href="javascript:void(0)" id="_new_cmnt" name="_new_cmnt" class="_new_cmnt" style="text-align: center; display: block;">Agregar Comentario</a><br>
																		
																			<div id="dv_new_<?php echo $___Ls->id_rnd; ?>" name="dv_new_<?php echo $___Ls->id_rnd; ?>" class="_new_cmnt_bx">
																				 <div class="_cmnt_cls"></div>
																				<?php echo HTML_inp_tx('_cmnt_add', 'Comentario', ctjTx($___Ls->dt->rw['_cmnt_add'],'in'), 2, '', '', ''); ?>								
																			</div>
													
																	<?php //} ?>
			                                                        <?php echo bdiv([ 'id'=>DV_LSFL.$__idtp_cmnt ]); ?>
			                                                    </div> 
															</div>    
														</div>
							                         
							                         </div>                           
							                  </div>  
							            </div>

											<?php
												
												$CntJV .= _DvLsFl_Vr([ 'i'=>$_gt_ec->id, 'n'=>$__idtp_cmnt, 't'=>'snd_ec_cmz_cmnt' ]);
												  		  
												$CntWb .= _DvLsFl([ 'i'=>$__idtp_cmnt ]); 
												
												//$CntWb .= "__v_are = $('#eccmz_are').val(); ";
																
																									
													if($__ntfld != '' && $__ntfldt == 'cmn'){ 
														$CntWb .= " $('#".TBGRP.$__idtp_cmnt."').click(); ";
													}
													
													$CntWb .= "
	
													
													$('#_new_cmnt').click(function(){
														$('#dv_new_".$___Ls->id_rnd."').show('slow');
														$('#_cmnt_add').focus();
														__i = 1;
												    });
												    
													
													$('#_cmnt_add').keyup(function(e) {
														
														e.preventDefault(); 
														
														var cl_nm = $('#cl_nm_p').val();
														
													    if(__i == 1 && !isN(cl_nm)){
														    if(e.keyCode == 13) {
													       		__i = 2;
													       		_new_cl();
															}
														}else{
															$('#dv_new_".$___Ls->id_rnd."').hide('slow');
														}
														
													});
														
													$('.tab1, .tab2, ._cmnt_cls').click(function(){
														$('#dv_new_".$___Ls->id_rnd."').hide('slow');				
													});
													
													function _gt_cmnt(){
														_ldCnt({ 
															u:'".FL_LS_GN.__t('snd_ec_cmz_cmnt',true).ADM_LNK_SB.$_gt_ec->id."',
															c:'".DV_LSFL.$__idtp_cmnt."'
														});	
													}
													
													function _new_cl(){
														
														var _cmnt = $('#_cmnt_add').val();
														
														$.ajax({
															type: 'POST',
															dataType: 'json',
															url:'".FL_JSON_GN.__t('snd_ec_cmz', true)."',
															data:{
																_prc:'cmnt_new',
																_cmnt:_cmnt,
																_ec:'".$_gt_ec->id."',
																_us:'".SISUS_ID."'
															},
															beforeSend: function() {
																
															},
															success: function(d) {

															    if(d.e == 'ok'){
																    
																    $('#dv_new_".$___Ls->id_rnd."').hide('slow');
																    $('#_cmnt_add').html('');
																    $('#_cmnt_add').val('');	    
																    $('#".TBGRP.$__idtp_cmnt."').click();

															    }else{
																	$('#dv_new_".$___Ls->id_rnd."').hide('slow');
																}
																
																$('#cl_nm_p').val('');
																
															}
															
														});
														
													}; 
													
													
											    ";
											    
											    if($__t == "snd_ec_cmz_cmnt"){ $CntWb .= " $('#".TBGRP.$__idtp_cmnt."').click(); ";  }
													
												//}
												
											?>	
						            </div>
								    <div class="_pnl_bx" id="_pnl_bx"> 
							            <div class="_btn_cms"><span><span class="_icn"></span>Recomendaciones</span></div>   						            
							            <ul class="rcmnd">
								            <li class="icon enter">
								            	<span></span>
								            	<div>Utiliza <b>(Shift+Enter)</b> para insertar los saltos de línea</div>
								            </li>
								            <li class="icon paste">
								            	<span></span>
								            	<div>Ten en cuenta que al <b>pegar</b> contenidos copiados de Word, Excel o páginas web, pueden afectar la estructura y pre visualización de tu plantilla.</div>
									        </li>
									        <li class="icon edited">
								            	<span></span>
								            	<div>Al <b>finalizar la edición</b> del contenedor haz click en el botón guardar (no puedes guardar varios contenedores al tiempo).</div>
									        </li>
									        <?php //if(ChckSESS_superadm()){ ?>
									        	<li class="icon apr_day">
									            	<span></span>
									            	<div>Recuerda enviar la aprobación con mínimo <b>5 días</b> hábiles antes del envío.</div>
										        </li>
									        <?php //} ?>
							            </ul>
								    </div>
									<div class="_pnl_bx ec_tags"> 
							            <div class="_btn_cms _btn_tags"><span><span class="_icn"></span>Etiquetas</span></div>   						            
										<?php $__ec_tags = GtSisTagCnctLs(['id'=>'EcTagList']); echo $__ec_tags->html; ?>
		                            	<?php $CntWb .= " SUMR_Main.ld.f.html(function(){ SUMR_Ec.f.tags({ id:'#EcTagList li' }); }); "; ?>  
								    </div>
									
					            </div>
				            </div>
				            <?php } ?> 
			            <?php } ?>
					</div>	
			</div>
    <!--</form>-->
</div>
<?php
	
	if(!isN($___Ls->dt->rw['eccmz_are'])){
		$_hdr_p = $___Ls->dt->rw['eccmz_are'];
	}else{
		$_hdr_p = '';
	}
	
	$CntWb .= "	

		SUMR_Ec.f.edt_stvr({
			rnd:'".$__id."',
			id:'".$___Ls->dt->rw['id_eccmz']."',
			enc:'".$___Ls->dt->rw['eccmz_enc']."',
			cdg:'".addslashes(ctjTx($___Ls->dt->rw['ec_cd'],'in','',['html'=>'ok','schr'=>'no','nl2'=>'no','qte'=>'no']))."',
			dir:'".$___Ls->dt->rw['ec_dir']."',
			tp:'".$___Ls->mdlstp->tp."',
			plc:'".$___Ls->gt->plct."',
			w:'".$___Ls->dt->rw['ec_w']."',
			hdr:'".$_hdr_p."',
			hdr_tp:'".$___Ls->dt->rw['eccmz_rlchdr']."',
			ec:{ id:'".$_gt_ec->id."' }
		});
	
		SUMR_Ec.cmz.edit.ld_all();

	";

?>
</div>
<?php $CntWb .= JV_Blq().JV_HtmlEd($__jqte, ['cmz'=>'ok'] ); ?>
<?php } ?>
<?php } ?>