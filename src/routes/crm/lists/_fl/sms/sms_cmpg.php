<?php 
	 
	 
if(class_exists('CRM_Cnx')){
	
	$___Ls->cnx->cl = 'ok';
	
	$___Ls->sch->f = 'smscmpg_nm';
	$___Ls->new->big = 'ok';
	$___Ls->edit->big = 'ok';
	
	$___Ls->_strt();
	
	if(_SbLs_ID('i')){ $__fl .= _AndSql($__mdl_rlc, _SbLs_ID('i')); }
	
	

	if(!isN($___Ls->mdlstp->id)){ 
		
		$_f_tp = " AND id_smscmpg IN (	SELECT smscmpgtp_cmpg 
										FROM ".MDL_SMS_CMPG_TP_BD." 
										WHERE smscmpgtp_cmpg = id_smscmpg AND smscmpgtp_tp = ".$___Ls->mdlstp->id."
									) "; 
																
	}
	
	
	/*
	$Ls_cmpgCtc = ", ( SELECT GROUP_CONCAT(cmpgctg_nm SEPARATOR '<br> ')
							FROM sms_cmpg_ctg , "._BdStr(DBM).TB_SMS_CMPG_CTG."
							WHERE smscmpgctg_sms = id_smscmpg AND smscmpgctg_ctg = id_cmpgctg 
					) AS cmpg_ctg";
	*/
	

	if(!isN($___Ls->gt->i)){	


		$Ls_TotLds = ", (SELECT COUNT(*) FROM ".MDL_SMS_SND_CMPG_BD." WHERE smssndcmpg_cmpg = id_smscmpg) AS __tot_lds ";	
		$___Ls->qrys = sprintf("SELECT * $Ls_TotLds $Ls_cmpgCtc FROM ".TB_SMS_CMPG." WHERE ".$___Ls->ik." = %s LIMIT 1", GtSQLVlStr($___Ls->gt->i, "text"));
		$__tt = ctjTx($___Ls->dt->rw['smscmpg_nm'],'in');
			
	}elseif($___Ls->_show_ls == 'ok'){ 
		
		
		$Ls_TotLds = ", ( SELECT COUNT(*) 
						  FROM ".MDL_SMS_SND_CMPG_BD.", ".TB_SMS_SND." 
						  WHERE smssndcmpg_snd = id_smssnd AND smssndcmpg_cmpg = id_smscmpg
						) AS __tot_lds ";
						
		$Ls_TotLdsOk = ", ( SELECT COUNT(*) 
						  FROM ".MDL_SMS_SND_CMPG_BD.", ".TB_SMS_SND." 
						  WHERE smssndcmpg_snd = id_smssnd AND smssndcmpg_cmpg = id_smscmpg AND smssnd_est = 1 
						) AS __tot_lds_ok ";
		
		$Ls_TotLdsNo = ", ( SELECT COUNT(*) 
							  FROM ".MDL_SMS_SND_CMPG_BD.", ".TB_SMS_SND." 
							  WHERE smssndcmpg_snd = id_smssnd AND smssndcmpg_cmpg = id_smscmpg AND smssnd_est = 2 
						  ) AS __tot_lds_no ";	
					
		
		$Ls_Whr = "	FROM "._BdStr(DBM).TB_SMS_CMPG."
						 INNER JOIN "._BdStr(DBM).TB_SIS_SLC." ON smscmpg_est = id_sisslc
					WHERE ".$___Ls->ino." != '' $_f_tp $__fl 
					ORDER BY ".$___Ls->ino." DESC";
					
		$___Ls->qrys = "SELECT *, (SELECT COUNT(*) $Ls_Whr) AS ".QRY_RGTOT." $Ls_TotLds $Ls_TotLdsOk $Ls_TotLdsNo $Ls_cmpgCtc $Ls_Whr";
		
	} 
	
	$___Ls->_bld(); 

								
	$CntJV .= "
		function __snd_upd(__v){

            $.ajax({
				  type: 'POST',
				  dataType: 'json',
				  url: '".Fl_Rnd(PRC_GN.__t('sms_cmpg',true))."',
				  beforeSend: function() {
					 	
				  },
				  data: {
					  	'smscmpg_est': __v.e,
                        'id_smscmpg': __v.id,
                        'MMM_update_est': 'EdSmsCmpg'  
		          },
	              success: function(d){
		              if(d.e == 'ok'){
					  	if(__v.c!='' && __v.c!='undefined' && __v.c!=null){ __v.c( d ); }
					  }
	              }
			});

		}
	"; 


?>
<?php if($___Ls->ls->chk=='ok'){ ?>
<?php $___Ls->_bld_l_hdr(); ?>
<?php if(($___Ls->qry->tot > 0)){ ?>

<table width="100%" border="0" cellpadding="0" cellspacing="0" class="Ls_Rg LsRgNw">
  	<tbody>
	  	<?php do { ?>
	  
	  	<?php 
		  	$_clr_rw = NULL; 
		  	$_clr_rw = ' style="background-color:'.$___Ls->ls->rw['sissmscmpgest_clr'].';" '; 
		  	
		  	$_IdSmsCmpg = $___Ls->ls->rw['id_smscmpg']; 
   
            $AvncId = Gn_Rnd(5).'_avnc';

            
            $___js_avnc = _Kn_Prcn([ 'id'=>$AvncId, 'l'=>'ok', 'v'=>0, 'w'=>'40', 'di'=>'ok' ]); 
            
            if($___Ls->ls->rw['smscmpg_est'] != 1){
	            
		        $CntWb .= $___js_avnc->js."
		        	
		        	function f_{$AvncId}_js(){
						/*
			        	SUMR_Main.autop({ 
			        		t:'_auto', 
		        			d:{ 
			        			tp:'snd_sms_cmpg',
		        				cmpg:'".$___Ls->ls->rw['id_smscmpg']."',
		        			},
		        			_c:function(r){
		        				
		        				if(r.e == 'ok' && r.p.n != undefined){
		        					$('#".$AvncId."').val(r.p.n).trigger('change');
		        					$('#n_o_".$AvncId." strong').html(r.batch.snd);
		        					$('#n_p_".$AvncId." strong').html(r.batch.p);
		        					if(r.p.n != '100'){ $('#bx_".$AvncId."').fadeIn(); }
								}
										        				
		        				if( $('#".$AvncId."').is(':visible') && !isN(r.p) && r.p.n != '100'){ 
			        				setTimeout(function(){ 
						        		f_{$AvncId}_js();
						        	}, 3000);
					        	}else if(!isN(r.p) && r.p.n == '100'){
						        	$('#bx_".$AvncId."').fadeOut();	
							        $('#rw_".$_IdSmsCmpg." td').css('background-color','#E7FFF0'); 	
					        	}
	        				}
		        		});
						*/
		        	}
		        	
					f_{$AvncId}_js();
		        	
		        ";
		    }    
	        
	        
	        
	        $__div_l = '<div class="__avnc_l" id="bx_'.$AvncId.'" style="display:none;">'.$___js_avnc->html.'</div>';                   				
      	?>
      	<tr id="rw_<?php echo $_IdSmsCmpg ?>">
	        <td align="left" <?php echo $_clr_rw ?> class="__sgm_ls">
	        <?php echo 
	            h2( Strn('SMS'.$___Ls->ls->rw['id_smscmpg'], '_id').' '.ctjTx($___Ls->ls->rw['smscmpg_nm'],'in') ).
	            Spn(FechaESP_OLD($___Ls->ls->rw['smscmpg_p_f']).' - '.$___Ls->ls->rw['smscmpg_p_h'],'','_f'); 
	        ?>
	        </td>
	        <?php if($___Ls->ls->rw['cmpg_ctg'] != NULL){ ?>
	        	<td align="" <?php echo NWRP.$_clr_rw ?>><?php echo Spn(TX_CTGR).HTML_BR.Strn($___Ls->ls->rw['cmpg_ctg']) ?></td>

	        <?php }else{ ?>
	        	<td align="" <?php echo NWRP.$_clr_rw ?>><?php echo Spn(TX_CTGR).HTML_BR.Strn('-NA-') ?></td>
	        <?php } ?>
	        <td align="left" <?php echo NWRP.$_clr_rw ?> id="<?php echo 'n_o_'.$AvncId; ?>"><?php echo Strn($___Ls->ls->rw['__tot_lds_ok']).HTML_BR.Spn(GA_SENT) ?></td>
	        <td align="left" <?php echo NWRP.$_clr_rw ?> id="<?php echo 'n_p_'.$AvncId; ?>"><?php echo Strn($___Ls->ls->rw['__tot_lds_no']).HTML_BR.Spn( TX_PRC.'(Envio)') ?></td>
	        <td width="1%" align="left" <?php echo NWRP.$_clr_rw ?>>
	            <?php if( $_lnktr_l != '' ){echo HTML_Ls_Btn(  ['t'=>'edt', 'js'=>'ok', 'l'=>_Ls_Lnk_Rw(['l'=>$_lnktr_l, 'sb'=>$__lssb, 'r'=>$___Ls->bx_rld ]) ]); } ?>
	        </td>			

			<td width="1%" align="left" <?php echo NWRP.$_clr_rw ?>>
	            <?php echo HTML_Ls_Btn[  [ 't'=>'md', 
	                						    'js'=>'ok', 
	                						    'l'=>_Ls_Lnk_Rw([ 'l'=>FL_FM_GN.__t($__bdtp,true)._SbLs_ID().$___Ls->ls->rw['smscmpg_enc'], 'pop'=>'no', 'jv'=>'no', 'sb'=>'ok', 'w'=>'95%', 'h'=>'95%' ] )
											]
										]; 
				?>
	        </td>
	        <td width="1%" align="left" <?php echo NWRP.$_clr_rw ?> >
	            <?php 
	                $__est_btn_on = HTML_Ls_Btn(['id'=>'est_c_'.$_IdSmsCmpg, 'l'=>Void(), 't'=>'strt', 'cls'=>'strt' ]);
	                $__est_btn_off = HTML_Ls_Btn(['id'=>'est_c_'.$_IdSmsCmpg, 'l'=>Void(), 't'=>'psd', 'cls'=>'psd' ]);
	                
		            if($___Ls->ls->rw['smscmpg_est'] == 4){
		                $__est_btn = $__est_btn_on;
		                echo HTML_inp_hd('smscmpg_est', 2); 
	                }elseif($___Ls->ls->rw['smscmpg_est'] == 2 ){
		              	$__est_btn = $__est_btn_off;
		                echo HTML_inp_hd('smscmpg_est', 4);
	                }
	                
	                if(($___Ls->ls->rw['smscmpg_est'] == 2 || $___Ls->ls->rw['smscmpg_est'] == 4) && ($___Ls->ls->rw['__tot_lds_no'] == 0 && $___Ls->ls->rw['__tot_lds'] > 0)){  
		                echo $__est_btn; 
		            }
	                
	                
	                $CntWb .= "
	                
	                	function cll_btn_{$_IdSmsCmpg}(){
		                	$('#est_c_{$_IdSmsCmpg}').click(function() {
								
								var _btn = $('#est_c_{$_IdSmsCmpg}');
								
								if( _btn.hasClass('strt') ){
									var __e = 2;
									var __c = 'psd';
									var __b = '{$__est_btn_off}';
								}else{
									var __e = 4;
									var __c = 'strt';
									var __b = '{$__est_btn_on}';
								}
								
								__snd_upd({
										id:'{$_IdSmsCmpg}', 
										e:__e, 
										c:function(d){
											
											_btn.addClass( __c );
											_btn.replaceWith( __b );
											
											$('#rw_{$_IdSmsCmpg} td').css('background-color', d.est.clr);
											$('#rw_{$_IdSmsCmpg} .__sgm_ls ._f').html( d.est.tt );
											
											cll_btn_{$_IdSmsCmpg}();
										}
								});
	
							});
						}
						
						cll_btn_{$_IdSmsCmpg}();
	                ";

	
	            ?>
	        </td> 
	        <td align="left" <?php echo $_clr_rw ?> width="1%"><?php echo $__div_l; ?></td>
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
<div class="FmTb">
		
  	<div id="<?php echo $___Ls->fm->bx->id ?>" class="bdy_snd_cmpg">
	  	
	  	
	  	
			  	<div class="hdr_snd_cmpg">
					<ul>
						<li id="btn_1" class="_a"><a><?php echo TX_RCPTR ?></a></li>
						<li id="btn_2"><a><? echo TX_CNFG ?></a></li>
						<li id="btn_3"><a><?php echo TX_CFRMCN ?></a></li>
					</ul>	
				</div>
			
				<?php $CntWb .= "
					
								function _TbCmpg(_p){
									$('.bdy_snd_cmpg ._bxcnt').removeClass('_opn');	
									$('.hdr_snd_cmpg li').removeClass('_a');
									
									if(_p._tb == 1){
										var _idb = '__edt_rcp';	
									}else if(_p._tb == 2){
										var _idb = '__edt_stp';
									}else if(_p._tb == 3){
										var _idb = '__edt_chk';
									}
										
									if(_p._tb > 1){ $('#__Btnec_cmpg').fadeIn(); }else{ $('#__Btnsms_cmpg').fadeOut(); }
									
									$('#'+_idb).addClass('_opn');
									$('#btn_'+_p._tb).addClass('_a');
								}
								
								
								$('#btn_1').click(function(){ _TbCmpg({ _tb:1 }); });
								$('#btn_2').click(function(){ _TbCmpg({ _tb:2 }); });
								
					"; 
					
					
					if($___Ls->dt->tot == 1){ $CntWb .= " _TbCmpg({ _tb:3 }); "; }else{ $CntWb .= "_TbCmpg({ _tb:1 });"; }
												
				?>

			                                                
			    <form method="POST" name="<?php echo $___Ls->fm->id; ?>" target="_self" id="<?php echo $___Ls->fm->id; ?>">
			      <?php $___Ls->_bld_f_hdr(); ?>

				  
				  	
				  	<?php $_cls_bxcnt = '_bxcnt '; ?>
				  	<div id="<?php echo $___Ls->fm->fld->id ?>" class="<?php echo DV_GNR_FM_CMP ?>">
								
		
							<div class="<?php echo $_cls_bxcnt ?> ln_1 __mysl _anm" id="__edt_rcp" >
								<?php echo h2(TX_SLCCNLT) ?>
								<div class="__opt1">
									<?php 
										if(!ChckSESS_superadm()){ $_us_flt = SISUS_ID; }else{$_us_flt = '';}
										echo LsSmsLsts('smscmpg_cmpg','id_smslsts', '', '', 2, '', '', ['u'=>$_us_flt]); $CntWb .= JQ_Ls('smscmpg_cmpg',FM_LS_SLCD); 
										echo LsCmpgCtg('smscmpgctg_ctg','id_cmpgctg', $___Ls->dt->rw['smscmpgctg_ctg'], '', 1, '', ['ctg'=>'cmpgctg_sms']); $CntWb .= JQ_Ls('smscmpgctg_ctg',TX_SLCCNCTG); 
										
									?>
									
									<div id="sms_cmpg_sgm_bx" class="_sbls">
										<?php 
												
			                            	if($___Ls->dt->rw['sissmssgmvar_sgm'] != ''){ 
			                            		$__t_s_i = $___Ls->dt->rw['sissmssgmvar_sgm']; 
			                            	}else{ 
				                            	$__t_s_i = 2; 
				                           	} 
				                            
				                            if($___Ls->dt->rw['smscmpgsgmvar_var'] != ''){
					                        	$__i = $___Ls->dt->rw['smscmpgsgmvar_var'];     
				                            }else{
					                        	$__i = 1;     
				                            }	
				                            
				                            
										   	$__ts = 'smscmpg_cmpg_sgm'; $__inc = 'ok'; include('_slc.php'); 
										   	
										
		                                    $CntWb .= "
												
								
												$('#smscmpg_cmpg').change(function() {
													
													$('#sms_cmpg_sgm_bx').html('');
		
													__id = $(this).val();
													__est_i = $(this).val();
													__sl = $('#smscmpg_cmpg option:selected');
													__sl_r = __sl.attr('rel');
		
													$('#_chck_list').html(__sl_r);
													
													SUMR_Main.ld.f.slc({
														i:__id, 
														t:'sms_cmpg_sgm', 
														t_i:__est_i, 
														b:'sms_cmpg_sgm_bx', 
														_ts:'smscmpg_cmpg_sgm',
														_cl: function(){
															$('#Nxt_1').fadeIn();	
														} 
													});
													
														
		                                		});"; 
										?>		
									</div>
									
									<input type="button" value=<?php echo TX_SGT ?> id="Nxt_1">
									<input type="button" value=<?php echo TX_OMT ?> id="Nxt_1_O">
									<?php 
										$CntWb .= " 
													$('#Nxt_1').click(function(){ _TbCmpg({ _tb:2 }); });
													$('#Nxt_1_O').click(function(){ _TbCmpg({ _tb:2 }); });
													
												"; 
									?>
									
								</div>
							</div>
							
							
							<div class="<?php echo $_cls_bxcnt ?> ln_1 __setup _hdr_sms" id="__edt_stp">

										<div class="col_1">
											<div class="_MblBx">
												<div class="_Hdr"></div>
												<div class="_Bdy">
													<div class="_Lft"></div>
													<div class="_Msj">
														<div class="_MsjBx" id="_MsjBx"></div>
													</div>
													<div class="_Rgh"></div>
												</div>
												<div class="_MsjCountBx" id="_MsjCountBx"><?php echo TX_NCRACT ?></div>
											</div>	
										</div>
										<div class="col_2">
											<?php echo h2(TX_DTSBSC); ?> 
											
											<?php echo HTML_inp_tx('smscmpg_nm', TX_NM. TX_DCMPN, ctjTx($___Ls->dt->rw['smscmpg_nm'],'in'), FMRQD); ?> 
											<?php 
												if($___Ls->dt->rw['smscmpg_est'] != 1){
													echo SlDt([ 'id'=>'smscmpg_p_f', 'va'=>$___Ls->dt->rw['smscmpg_p_f'], 'rq'=>'ok', 'ph'=>TX_F.TX_PRGMD, 'lmt'=>'no', 'cls'=>CLS_CLND, '_mdy'=>['_mdy'=>2] ]);  
													//echo SlDt('smscmpg_p_f', $___Ls->dt->rw['smscmpg_p_f'], 'ok','', TX_F.TX_PRGMD, 'no','','','',CLS_CLND,'',array('_mdy'=>0)); 
												}else{
													echo HTML_inp_hd('smscmpg_p_f', $___Ls->dt->rw['smscmpg_p_f']); 
												}
												
												
												?> 
											<?php 
												
												if($___Ls->dt->rw['smscmpg_est'] != 1){
													echo SlDt('smscmpg_p_h', $___Ls->dt->rw['smscmpg_p_h'], 'ok','hr', TX_HR. TX_PRGMD, 'no','','','',CLS_HOUR,'',['_mdy'=>0]); 
												}else{
													
													echo HTML_inp_hd('smscmpg_p_h', $___Ls->dt->rw['smscmpg_p_h']); 
												}
												
												?> 
											<?php 
												
												$CntWb .= "
													
												";
											?>
											<div class="__msj_cel">
												<?php 
													
													if($___Ls->dt->rw['smscmpg_est'] != 1){
														echo HTML_textarea('smscmpg_msj', ctjTx($___Ls->dt->rw['smscmpg_msj'],'in'), ctjTx($___Ls->dt->rw['smscmpg_msj'],'in'), FMRQD, '', '', 5, 160); 
													}else{
														echo HTML_inp_hd('smscmpg_msj', $___Ls->dt->rw['smscmpg_msj']);
														
													}
													
													?> 
											</div>
										</div>
										<?php 	

											$CntWb .= "
													SUMR_Main.sms.bld({	
														btn:'SndPss',
														bx:{
															msj:'_MsjBx',
															cnt:'_MsjCountBx'
														},
														msj:'smscmpg_msj',
														_c:function(){
															
														}	
													});	
											";

								  		?>							  		
							</div>
							
							<div class="<?php echo $_cls_bxcnt ?> __chck" id="__edt_chk">
								<?php include(DIR_EXT.'sms_cmpg_1.php'); ?>
							</div>
							
					</div>
		
			    </form>
	    
	    
  </div>

</div>
<?php } ?>
<?php } ?>
