<?php 
if(class_exists('CRM_Cnx')){
	
	$___Ls->cnx->cl = 'ok';
	$___Ls->flt = 'ok';
	$___Ls->tpr = 'ec_cmpg';
	$___Ls->sch->f = 'id_eccmpg, eccmpg_nm';
	$___Ls->ing->vrall = [ADM_LNK_OP];
	$___Ls->ino = 'id_eccmpg'; 
	$___Ls->ik = 'eccmpg_enc';
	$___Ls->new->w = 600;
	$___Ls->new->h = 320;
	$___Ls->edit->w = 900;
	$___Ls->edit->h = 700;	 
	
	if(_ChckMd('snd_ec_cmpg_grph')){
		$___Ls->grph->h = 'mny';
		$___Ls->grph->tot = 1; 
	}
	
	$___Ls->_strt();
	
	if(!isN($___Ls->mdlstp->id)){
			
		$_f_tp = " AND id_eccmpg IN (	SELECT eccmpgtp_cmpg 
										FROM "._BdStr(DBM).TB_EC_CMPG_TP." 
										WHERE eccmpgtp_cmpg = id_eccmpg AND eccmpgtp_tp = ".$___Ls->mdlstp->id."
									) ";
									
	}
	

	if(!isN($___Ls->gt->i)){ 	
		
		$Ls_TotLds = ", (	SELECT COUNT(*) 
							FROM ".TB_EC_SND_CMPG." 
							WHERE ecsndcmpg_cmpg = id_eccmpg) AS __tot_lds ";
		
		$___Ls->qrys = sprintf("SELECT * $Ls_TotLds,
										"._QrySisSlcF([ 'als'=>'s', 'als_n'=>'Sender' ]).",
										".GtSlc_QryExtra([ 't'=>'fld', 'p'=>'Sender', 'als'=>'s' ]).",
										"._QrySisSlcF([ 'als'=>'e', 'als_n'=>'Estado' ]).",
										".GtSlc_QryExtra([ 't'=>'fld', 'p'=>'Estado', 'als'=>'e' ])."
								FROM "._BdStr(DBM).TB_EC_CMPG."
									 INNER JOIN "._BdStr(DBM).TB_EC." ON eccmpg_ec = id_ec
									 INNER JOIN "._BdStr(DBM).TB_CL." ON eccmpg_cl = id_cl
									 ".GtSlc_QryExtra([ 't'=>'tb', 'col'=>'eccmpg_est', 'als'=>'e' ])."
									 ".GtSlc_QryExtra([ 't'=>'tb', 'col'=>'eccmpg_sndr', 'als'=>'s' ])."
								WHERE eccmpg_enc = %s AND cl_enc = '".DB_CL_ENC."' 
								LIMIT 1", GtSQLVlStr($_GET['_i'], "text"));

		
	}elseif($___Ls->_show_ls == 'ok'){ 

		if(!ChckSESS_superadm() && !_ChckMd('snd_ec_cmpg_all') && !_ChckMd('snd_ec_cmpg_are','ok') ){
			$___Ls->qry_f .= " AND eccmpg_us = '".SISUS_ID."' ";
		}
        
		if(!isN($___Ls->_fl->fk->us_enc)){ 
			if(is_array($___Ls->_fl->fk->us_enc)){ $__all_are = implode(',', $___Ls->_fl->fk->us_enc); }else{ $__all_are = "'".$___Ls->_fl->fk->us_enc."'"; }
			$___Ls->qry_f .= ' AND eccmpg_us IN ( SELECT id_us FROM '._BdStr(DBM).TB_US.' WHERE us_enc IN ('.$__all_are.') ) ';					
		}

		if(!isN($___Ls->_fl->fk->eccmpg_sndr)){ 
			if(is_array($___Ls->_fl->fk->eccmpg_sndr)){ $__all_are = implode(',', $___Ls->_fl->fk->eccmpg_sndr); }else{ $__all_are = "'".$___Ls->_fl->fk->eccmpg_sndr."'"; }
			$___Ls->qry_f .= ' AND eccmpg_sndr IN ( '.$__all_are.' ) ';					
		}
        		
		if(!isN($___Ls->_fl->fs1)){ 
			$___Ls->qry_f .= ' AND DATE_FORMAT(eccmpg_p_f, "%Y-%m-%d") = "'.$___Ls->_fl->fs1.'" '; 
		} 

		
		if( _ChckMd('snd_ec_cmpg_are','ok') && !ChckSESS_superadm() && !_ChckMd('snd_ec_cmpg_all') ){

			if(isN(_Cns('SISUS_ARE'))){
				$__us_are = " = ".SISUS_ID;
			}else{
				$__us_are = " IN( SELECT usare_us FROM "._BdStr(DBM).TB_US_ARE." WHERE usare_clare IN('".SISUS_ARE."') ) ";
			}

			$___Ls->qry_f .= " AND eccmpg_us $__us_are ";
		}
			
		$Ls_Whr = "	FROM "._BdStr(DBM).TB_EC_CMPG."
						 INNER JOIN "._BdStr(DBM).TB_CL." ON eccmpg_cl = id_cl
						 INNER JOIN "._BdStr(DBM).TB_US." ON eccmpg_us = id_us
						 ".GtSlc_QryExtra([ 't'=>'tb', 'col'=>'eccmpg_est', 'als'=>'e' ])."
						 ".GtSlc_QryExtra([ 't'=>'tb', 'col'=>'eccmpg_sndr', 'als'=>'s' ])."
					WHERE id_eccmpg != '' ".$___Ls->qry_f." AND cl_enc = '".DB_CL_ENC."' $_f_tp $__fl ".$___Ls->sch->cod." 
					ORDER BY id_eccmpg DESC"; 
					
		$___Ls->qrys = "SELECT id_eccmpg, eccmpg_sndr, eccmpg_nm, eccmpg_enc, eccmpg_est, eccmpg_opn, eccmpg_p_f, eccmpg_p_h, eccmpg_tot_lds, eccmpg_tot_nallw, /*siseccmpgest_clr,*/ us_nm, us_ap, us_user, eccmpg_fi, 
								"._QrySisSlcF([ 'als'=>'e', 'als_n'=>'Estado' ]).",
								".GtSlc_QryExtra([ 't'=>'fld', 'p'=>'Estado', 'als'=>'e' ]).",
								"._QrySisSlcF([ 'als'=>'s', 'als_n'=>'Sender' ]).",
								".GtSlc_QryExtra([ 't'=>'fld', 'p'=>'Sender', 'als'=>'s' ]).",
								(SELECT COUNT(*) $Ls_Whr) AS __rgtot $Ls_TotLds $Ls_TotLdsOk $Ls_TotSnd $Ls_TotLdsNo 
						$Ls_Whr";
						
		//if(SISUS_ID == 231){ echo $___Ls->qrys; }			
	}else{
		
		$___Ls->fm->sve->bfr .= "$('#shw_crtng".$___Ls->id_rnd."').addClass('on');";
		$___Ls->fm->sve->aft .= "$('#shw_crtng".$___Ls->id_rnd."').removeClass('on');";
		
	} 
	
	$___Ls->_bld(); 
?>
<?php if($___Ls->ls->chk=='ok'){ ?>
	
	<?php $___Ls->_bld_l_hdr(); ?>
	
	<?php 
			
		if(!isN($___Ls->grph)){
			
			$CntWb .= "
			
				_ldCnt({ 
					u:'".Fl_Rnd(FL_GRPH_GN.__t($___Ls->gt->t, true).$___Ls->ls->vrall)."&_h=150&_t2=".$___Ls->gt->tsb."&_tp=grph_1&_g_r=".$___Ls->id_rnd."' , 
					c:'bx_grph_".$___Ls->id_rnd."_1',
					trs:false, 
					anm:'no',
					_cl:function(){
						
					
					}
				});
			
			";
		
		}
		
	?>
		
	<?php if(($___Ls->qry->tot > 0)){ ?>
	
	<?php $CntJV .= "SUMR_Main.bxajx.__cmpg={};"; ?>
	
	<table width="100%" border="0" cellpadding="0" cellspacing="0" class="Ls_Rg LsRgNw EcCmpg">
	  <tbody>
			  <?php 

			  	if(SISUS_ID == 163 || SISUS_ID == 1 || SISUS_ID == 439){
					$CntWb .= " 
						
						$('.g_tot_l').off('click').click(function (){

							var _g_tot_tp = $(this).attr('rel');
							var _id = $(this).parent().parent().parent().parent().parent().attr('id');

							var string = _id; 
							var _id = string.replace('rw_', ''); 

							_ldCnt({	
								u:'".FL_LS_GN.__t('ec_snd_rprt',true).TXGN_POP.TXGN_BX.$___Ls->bx_rld.ADM_LNK_SB."'+_id+'&_g_tot_tp='+_g_tot_tp,
								w:'98%',
								h:'98%',
								pop:'ok',
								pnl:{
									e:'ok',
									tp:'h',
									s:'l'
								}	
							});
							
						});
					
					";	
				}
				  
				do { 
				  	
					$__estado = json_decode($___Ls->ls->rw['___Estado']);
					
					if($___Ls->ls->rw['eccmpg_sndr'] == _CId('ID_SISEML_SUMR')){
						$__ls_json[] = $___Ls->ls->rw['eccmpg_enc'];
					}
					
				  	foreach($__estado as $__estado_k=>$__estado_v){
				  		$__estado_attr[$__estado_v->key] = $__estado_v->vl; 
			  		}
				  		
				  	if($___Ls->ls->rw['eccmpg_sndr'] == _CId('ID_SISEML_SISIN')){
					  	
				  		$__sndr_img = $___Ls->cl->lgo->lght->big;
				  		
				  	}elseif($___Ls->ls->rw['Sender_sisslc_img'] != ''){ 
					  	
						$__sndr_img = DMN_FLE_SIS_SLC.ctjTx($___Ls->ls->rw['Sender_sisslc_img'],'in');
						
					}else{
						
						$__sndr_img = '';
						
					}			
					
					$_clr_rw = NULL; 
					$_clr_rw = ' style="background-color:'.$___Ls->ls->rw['siseccmpgest_clr'].';" '; 
					
					$_IdEcCmpg = $___Ls->ls->rw['id_eccmpg']; 
					$_EcEcCmpg = $___Ls->ls->rw['eccmpg_enc'];
					
			  ?>	  
	          <tr id="rw_<?php echo $_EcEcCmpg ?>" <?php         
	                
	                $AvncId = Gn_Rnd(5).'_avnc';
	                
		            $___js_avnc = _Kn_Prcn([ 'id'=>$AvncId, 'l'=>'ok', 'w'=>'40', 'ds'=>'0.01' ]);   
		            
		            if(	($___Ls->ls->rw['eccmpg_est'] == _CId('ID_ECCMPGEST_APRBD') || $___Ls->ls->rw['eccmpg_est'] == _CId('ID_ECCMPGEST_SNDIN')) &&
			        	($___Ls->ls->rw['eccmpg_sndr'] == _CId('ID_SISEML_SUMR'))    
				    ){
			            
			            $CntWb .= $___js_avnc->js;
			            
				        $CntJV .= "
				        	
				        	function f_{$AvncId}_js(r){
						        
						        
						        try{ 
							        	
						        	if(!isN(r)){
							        	
							        	if(!isN(r.online)){	
					        					
						        			$('#n_o_".$AvncId." strong').html(r.online.snd);
				        					$('#n_p_".$AvncId." strong').html(r.online.p);
					        				
					        				
					        				$('#n_ldd_".$AvncId." strong').html('<span class=\"_nm\">'+r.online.ldd + '</span><span class=\"_pc\">'+ r.online.ldd_p + '%</span>' );
						        			$('#n_opn_".$AvncId." strong').html('<span class=\"_nm\">'+r.online.op + '</span><span class=\"_pc\">'+ r.online.op_p + '%</span>' );		
						        			$('#n_clc_".$AvncId." strong').html('<span class=\"_nm\">'+r.online.clc + '</span><span class=\"_pc\">'+ r.online.clc_p + '%</span>' );		
							        		$('#n_bnc_".$AvncId." strong').html('<span class=\"_nm\">'+r.online.bnc + '</span><span class=\"_pc\">'+ r.online.bnc_p + '%</span>' );					        				
					        				$('#n_p_".$AvncId." strong').html('<span class=\"_nm\">'+r.online.sndin + '</span>' );
					        				
					        				
					        				$('#rw_{$_EcEcCmpg} ._est_nm').html( r.n.est.nm ).css('color', r.n.est.clr);
				        					
										}
										        
							        	if(!isN(r) && !isN(r.n) && !isN(r.n.html)){
							        		f_{$AvncId}_knob(r.n);
										}
								        		
					        		}
					        		
					        		return true;
					        		
				        		}catch(e) {
					        		
									SUMR_Main.log.f({ t:'".TX_ERROR." Cmpg', m:err });
									
								}
			
				        	}
				        	
				        	
				        	function f_{$AvncId}_knob(r){
					        	
					        	try{ 
						        	
						        	if(!isN(r)){
							        	
							        	if(!isN(r.html)){ var html = r.html; }
							        	
							        	$('#bx_{$AvncId}').html(html);
							        	
							        	if(!isN(r.js)){ eval(r.js); }
							        	
							        	if(r.est.id == '"._CId('ID_ECCMPGEST_SND')."'){ 
								        	delete SUMR_Main.bxajx.__cmpg['{$AvncId}'];	
									        $('#bx_{$AvncId}').fadeOut();			
							        	}else{
								        	$('#bx_{$AvncId}').fadeIn();
							        	}
						        	}
						        	
					        	}catch(e) {
					        		
									SUMR_Main.log.f({ t:'".TX_ERROR." Cmpg Knob', m:e });
									
								}
					        	
				        	}
					        	
				        	
							f_{$AvncId}_js();
				        	
				        ";
				        

						$CntJV .= "
											    		
				    		SUMR_Main.bxajx.__cmpg['{$AvncId}'] = { id:'".$___Ls->ls->rw['eccmpg_enc']."', f:'{$AvncId}', e:'".$___Ls->ls->rw['eccmpg_est']."' };
					    		
							f_{$AvncId}_knob();
							
				    	";	 
				    
				    }    
			    	
			        $__div_l = '<div class="__avnc_l" id="bx_'.$AvncId.'">'.$___js_avnc->html.'</div>';           
				        
				    if($___Ls->ls->rw['eccmpg_sndr'] == _CId('ID_SISEML_SUMR') || $___Ls->ls->rw['eccmpg_sndr'] == _CId('ID_SISEML_OFC')){		
						$__anly_snd = 'ok';		
					}else{
						$__anly_snd = 'no';
					}	    		
						    				
	          	?>>        
		          
		        <td class="_img_rnd" width="1%" <?php echo NWRP ?>>
				    <div class="_img_cod">
				    	<div class="_bimg"><div class="_sndr Old" style="background-image:url(<?php echo $__sndr_img; ?>);"></div></div>
				    	<div class="_btt"><?php echo Strn(CODNM_EC_CMPG.ctjTx($___Ls->ls->rw['id_eccmpg'],'in'),'_nmb'); ?></div>
				    </div>
				</td>	
				  
	            <td align="left" <?php echo $_clr_rw ?> >  
		            <?php 
			            
			            echo h2(ctjTx($___Ls->ls->rw['eccmpg_nm'],'in')).
			            	 Spn( ctjTx($___Ls->ls->rw['Estado_sisslc_tt'],'in'), '', '_est_nm', 'color:'.$__estado_attr['clr'] ).HTML_BR; 
			        
					    echo Spn( ctjTx($___Ls->ls->rw['us_nm'].' '.$___Ls->ls->rw['us_ap'],'in') ,'','_f').HTML_BR;
						echo Spn( ctjTx($___Ls->ls->rw['us_user'],'in') ,'','_f').HTML_BR;
						echo Spn( 'Solicitado el '.FechaESP_OLD($___Ls->ls->rw['eccmpg_fi']).' '._DteHTML(['d'=>$___Ls->ls->rw['eccmpg_fi'], 'nd'=>'no']),'','_f').HTML_BR;	 

			        ?>
		        </td>
				
				<td align="left" <?php echo $_clr_rw ?> > 
					
				</td>	

				<td width="1%" class="" align="center" style="" nowrap="nowrap">
					
					<?php if($__anly_snd == 'ok'){ $__cls_no_show=''; }else{ $__cls_no_show='_no_show'; }  ?>	
					
					<table width="100%" border="0" cellpadding="0" cellspacing="0"  class="_anly <?php echo $__cls_no_show; ?>">
						<tr>	
				            <td width="1%" align="center" <?php echo NWRP.$_clr_rw ?> rel="g_tot_snd" class="g_tot_l cntr _leads_allw ">
					            <?php
						            if($__anly_snd=='ok'){ echo bdiv([ 'tt'=>TX_LEADS, 'cls'=>'icn' ]).HTML_BR.Strn(_Nmb($___Ls->ls->rw['eccmpg_tot_lds'],3)); }
						        ?>
					        </td>
					        <td width="1%" align="center" <?php echo NWRP.$_clr_rw ?> rel="g_tot_nallw" class="g_tot_l cntr _leads_nallw">
					            <?php 
						            if($__anly_snd=='ok'){ echo bdiv([ 'tt'=>TX_LEADS.' No habilitados', 'cls'=>'icn' ]).HTML_BR.Strn(_Nmb($___Ls->ls->rw['eccmpg_tot_nallw'],3)); }
						        ?>
					        </td>
					        <td width="1%" align="center" <?php echo NWRP.$_clr_rw ?> rel="g_tot_snd"  id="<?php echo 'n_ldd_'.$AvncId; ?>" class="g_tot_l cntr pc _ldd">
						        <?php 
							        if($__anly_snd=='ok'){ echo bdiv([ 'tt'=>TX_CRGD, 'cls'=>'icn' ]).HTML_BR. Strn( Spn( '0','','_nm bx_btch_l_v' ).Spn('','','_pc bx_btch_l_p') ); }
							    ?>
						    </td>
				            <td width="1%" align="center" <?php echo NWRP.$_clr_rw ?> rel="g_tot_op" id="<?php echo 'n_opn_'.$AvncId; ?>" class="g_tot_l cntr pc _opn">
					            <?php 
						            if($__anly_snd=='ok'){ echo bdiv([ 'tt'=>TX_OPN, 'cls'=>'icn' ]).HTML_BR.Strn( Spn( '0','','_nm bx_tot_op_v').Spn('','','_pc bx_tot_op_p') ); } 
						        ?>
					        </td>
				            <td width="1%" align="center" <?php echo NWRP.$_clr_rw ?> rel="g_tot_trck" id="<?php echo 'n_clc_'.$AvncId; ?>" class="g_tot_l cntr pc _clc">
					            <?php 
						            if($__anly_snd=='ok'){ echo bdiv([ 'tt'=>TX_CLCKS, 'cls'=>'icn' ]).HTML_BR.Strn( Spn('0','','_nm bx_tot_trck_v').Spn(round($trck)."%",'','_pc bx_tot_trck_v') ); } 
						        ?>
					        </td>
				            <td width="1%" align="center" <?php echo NWRP.$_clr_rw ?> rel="g_tot_err" id="<?php echo 'n_bnc_'.$AvncId; ?>" class="g_tot_l cntr pc _bnc">
					            <?php 
						            if($__anly_snd=='ok'){ echo bdiv([ 'tt'=>TX_RBNDS, 'cls'=>'icn' ]).HTML_BR.Strn( Spn('0','','_nm bx_tot_err_v').Spn(round($err)."%",'','_pc bx_tot_err_v') ); } 
						        ?>
					        </td>
				            <td width="1%" align="center" <?php echo NWRP.$_clr_rw ?> rel="g_tot_snd" id="<?php echo 'n_o_'.$AvncId; ?>" class="g_tot_l cntr _n_o">
					            <?php 
						            if($__anly_snd=='ok'){ echo bdiv([ 'tt'=>TX_SNTCMP, 'cls'=>'icn' ]).HTML_BR.Strn( Spn('0','','_nm bx_btch_snd_v') ); } 
						        ?>
					        </td>
				            <td width="1%" align="center" <?php echo NWRP.$_clr_rw ?> rel="g_tot_prc" id="<?php echo 'n_p_'.$AvncId; ?>" class="g_tot_l cntr _n_p">
					            <?php
						            if($__anly_snd=='ok'){ echo bdiv([ 'tt'=>TX_PRCSHPNG, 'cls'=>'icn' ]).HTML_BR.Strn( Spn('0','','_nm bx_btch_p_v') ); } 
						        ?>
					        </td>
				            <td width="1%" align="center" width="1%" <?php echo NWRP.$_clr_rw ?>>
						     	<?php 	
					            	if($___Ls->ls->rw['eccmpg_opn'] == 1){ $__icn_opn = Spn('','','_tt_icn _tt_icn_etp'); }else{ $__icn_opn = ''; }
					            	echo $__icn_opn;
					            ?>  
						    </td>
						</tr>
					</table>
				</td>

				<td width="1%" class="c cntr _date" align="center" style="" nowrap="nowrap">
					<?php 	
						echo bdiv([ 'tt'=>TX_FFENV, 'cls'=>'icn' ]).HTML_BR.Spn($___Ls->ls->rw['eccmpg_p_f']);	
					?>	
				</td>
				<td width="1%" class="c cntr _hour" align="center" style="" nowrap="nowrap">
					<?php 	
						echo bdiv([ 'tt'=>TX_HENV, 'cls'=>'icn' ]).HTML_BR.Spn($___Ls->ls->rw['eccmpg_p_h']);	
					?>
				</td>	        
		        
				<td width="1%" class="c" align="center" <?php echo NWRP.$_clr_rw ?>>
				
			     	<div class="__ls_btn">
				 		
				 		<?php if(_ChckMd('snd_cmpg_aprb') && $___Ls->ls->rw['eccmpg_est'] != _CId('ID_ECCMPGEST_APRBD') && $___Ls->ls->rw['eccmpg_est'] != _CId('ID_ECCMPGEST_NAPRBD') && $___Ls->ls->rw['eccmpg_est'] != _CId('ID_ECCMPGEST_SND') && $___Ls->ls->rw['eccmpg_est'] != _CId('ID_ECCMPGEST_SNDIN')){  ?>
				     	<div> 	
					     	<?php  
								echo HTML_Ls_Btn([ 't'=>'aprb', 'rel'=>$___Ls->ls->rw['id_eccmpg'], 'cls'=>'_ec_apr icn_fll', 'l'=>Void(), 'attr'=>[ 'data-enc'=>$___Ls->ls->rw['eccmpg_enc'] ] ]); 	
							?>	 	
				     	</div>
				     	<?php } ?>
				     	
				     	<?php if(_ChckMd('snd_cmpg_aprb') && $___Ls->ls->rw['eccmpg_est'] != _CId('ID_ECCMPGEST_APRBD') && $___Ls->ls->rw['eccmpg_est'] != _CId('ID_ECCMPGEST_NAPRBD') && $___Ls->ls->rw['eccmpg_est'] != _CId('ID_ECCMPGEST_SND') && $___Ls->ls->rw['eccmpg_est'] != _CId('ID_ECCMPGEST_SNDIN')){  ?>
				     	<div> 	
					     	<?php 
								echo HTML_Ls_Btn([ 't'=>'no_aprb', 'rel'=>$___Ls->ls->rw['id_eccmpg'], 'cls'=>'_cmpg_no_apr icn_fll', 'l'=>Void(), 'attr'=>[ 'data-enc'=>$___Ls->ls->rw['eccmpg_enc'] ] ]); 	
							?>	 	
				     	</div>
				     	<?php } ?>
				     	
				    	<div>
							<?php echo $___Ls->_btn([ 't'=>'mod' ]); ?>
			            </div>  
			            <div>
			                <?php 
				                
				                if($__anly_snd == 'ok'){
					                
					                echo HTML_Ls_Btn( [ 't'=>'md', 
					                						    'js'=>'ok', 
					                						    'l'=>_Ls_Lnk_Rw([ 'l'=>FL_FM_GN.__t('snd_ec_cmpg',true).'&__i='.$___Ls->ls->rw['eccmpg_enc'], 'pop'=>'no', 'jv'=>'no', 'sb'=>'ok', 'w'=>'95%', 'h'=>'95%' ] )
															]
														); 
														
								}
													
							?>
			            </div>			            
				        <div>
			                <?php 
				               
				               
				                $__est_btn_on = HTML_Ls_Btn(['id'=>'est_c_'.$_EcEcCmpg, 'l'=>Void(), 't'=>'strt', 'cls'=>'strt' ]);
				                $__est_btn_off = HTML_Ls_Btn(['id'=>'est_c_'.$_EcEcCmpg, 'l'=>Void(), 't'=>'psd', 'cls'=>'psd' ]);
				                
				                $__est_btn = $__est_btn_off;
				                
					            if($___Ls->ls->rw['eccmpg_est'] == _CId('ID_ECCMPGEST_PSD')){
					                $__est_btn = $__est_btn_on;
					                echo HTML_inp_hd('eccmpg_est', _CId('ID_ECCMPGEST_SNDIN')); 
				                }elseif($___Ls->ls->rw['eccmpg_est'] == _CId('ID_ECCMPGEST_SNDIN')){
					              	$__est_btn = $__est_btn_off;
					                echo HTML_inp_hd('eccmpg_est', _CId('ID_ECCMPGEST_PSD'));
				                }
				                
				                if(($___Ls->ls->rw['eccmpg_est'] == _CId('ID_ECCMPGEST_SNDIN') || $___Ls->ls->rw['eccmpg_est'] == _CId('ID_ECCMPGEST_PSD')) && ($__cmpg_dt->btch->p == 0 && $__cmpg_dt->btch->l > 0)){  
					                echo $__est_btn; 
					            }
				                
				                
				                $CntWb .= "
				                
				                	function cll_btn_{$_EcEcCmpg}(){
					                	
					                	$('#est_c_{$_EcEcCmpg}').click(function() {
											
											var _btn = $('#est_c_{$_EcEcCmpg}');
											
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
													id:'{$_IdEcCmpg}', 
													e:__e, 
													c:function(d){
														
														_btn.addClass( __c );
														_btn.replaceWith( __b );
														
														if( !isN(d.est) ){
															if( !isN(d.est.clr) ){
																$('#rw_{$_EcEcCmpg} td').css('background-color', d.est.clr);
															}
															
															if( !isN(d.est.tt) ){
																$('#rw_{$_EcEcCmpg} .__sgm_ls ._f').html( d.est.tt );
															}
														}
														
														
														
														cll_btn_{$_EcEcCmpg}();
													}
											});
				
										});
										
									}
									
									cll_btn_{$_EcEcCmpg}();
				                ";
			
			                ?>
				        </div> 	

			     	</div>	   
					
				</td>
				
				<td align="center" <?php echo $_clr_rw ?> width="1%">
					<?php if(/*$___Ls->ls->rw['eccmpg_est'] != _CId('ID_ECCMPGEST_APRBD') &&*/ $___Ls->ls->rw['eccmpg_est'] == _CId('ID_ECCMPGEST_SNDIN') || $___Ls->ls->rw['eccmpg_est'] == _CId('ID_ECCMPGEST_PRC')){  ?>
						<?php if($__anly_snd=='ok'){ echo $__div_l; } ?>
					<?php } ?>
				</td>
	            
	             
	            <?php 
									
			      		$CntJV .= "
			      		
							function __snd_upd(__v){
								
								if(!isN(__v.e)){
									_v = __v.e;
								}else{
									_v = $('#eccmpg_est').val();
								}
			                    $.ajax({
									  type: 'POST',
									  dataType: 'json',
									  url: '".Fl_Rnd(PRC_GN.__t('ec_cmpg',true))."',
									  beforeSend: function() {
										 	
									 },
									  data: {
										  	'eccmpg_est': _v,
				                            'id_eccmpg': __v.id,
				                            'MMM_update_est': 'EdEcCmpg'      
							          },
						              success: function(d){
							              if(d.e == 'ok'){
										  	if(!isN(__v.c)){ __v.c( d ); }
										  }else{
												            	
							              }
						              }
								});
			
							}
							" 
			
					?>
	            
	        </tr>
	        <?php } while ($___Ls->ls->rw = $___Ls->sql->fetch_assoc()); ?>
	        
	        <?php 
	        
	        
	                  
                $CntJV .= "
                  			
                  		function f_snd_cmpg_updt(){
				        	
				        	try{ 
					        	
					        	var _ob = Object.keys(SUMR_Main.bxajx.__cmpg).length; 
					        	
					        	
					        	if(!isN(SUMR_Main.bxajx.__cmpg) && _ob > 0){ 
									
									/*
						        	SUMR_Main.autop({ 
						        		t:'_auto', 
					        			d:{ 
						        			tp:'snd_ec_cmpg',
					        				cmpg:SUMR_Main.bxajx.__cmpg,
					        			},
					        			_c:function(r){	
						        			if(!isN(r)){						  
							        			if(!isN(r.ls)){
								        			$.each(r.ls, function(k, v) { 
									        			if(!isN(v.f)){	
								        					window['f_'+v.f+'_js'](v);	        					
								        				}
								        			});
							        			}	
							        		}		        				
				        				},
				        				_cm:function(e){
					        				
					        				
					        				setTimeout(function(){ 
								        		f_snd_cmpg_updt();
								        	}, 10000);
								        	
								    		
				        				}
					        		}); 
									*/
				        		}
				        		
				        		
				        		return true;
				        		
			        		}catch(e) {
				        		
								SUMR_Main.log.f({ t:'".TX_ERROR."', m:e });
								
							}
							
			        	}	
                  		
                  	
                ";
	                
	            
	            if(ChckSESS_superadm()){
		            
	            	//$CntJV .= " f_snd_cmpg_updt();";
	            
	            }
	                   
            ?>
	            
	            
	  </tbody>
	</table>
	<style>
		span._f .__dte, 
		span._f .__dte strong{ font-weight: normal !important; }

		td.cntr:hover .icn{
			background-color: #d4d4d4;
    		border-radius: 50%;
		}
		
	</style>

<?php 

	$CntJV .=	"

		function __getExtData(){


			_Rqu({ 
				t:'ec_cmpg_ext', 
				eccmpg:'".implode(',', $__ls_json)."',
				_cl:function(_r){
					if(!isN(_r)){
						if(!isN(_r.l)){
							$.each(_r.l, function(_k, _v){

								if(!isN(_v) && !isN(_v.btch) && !isN(_v.tot)){ 
									
									var _btch = _v.btch;
									var _tot = _v.tot; 
									 
									if(!isN(_btch)){ 

										if(!isN(_btch.l)){ 
											$('#rw_'+_v.id+' .bx_btch_l_v').html( _btch.l.v ); 
											$('#rw_'+_v.id+' .bx_btch_l_p').html( _btch.l.p ); 
										}

										if(!isN(_btch.snd)){ 
											$('#rw_'+_v.id+' .bx_btch_snd_v').html( _btch.snd.v ); 
										}

										if(!isN(_btch.p)){ 
											$('#rw_'+_v.id+' .bx_btch_p_v').html( _btch.p.v );
										}

									}

									if(!isN(_tot)){ 

										if(!isN(_tot.op)){ 
											$('#rw_'+_v.id+' .bx_tot_op_v').html( _tot.op.v ); 
											$('#rw_'+_v.id+' .bx_tot_op_p').html( _tot.op.p ); 
										}
										
										if(!isN(_tot.trck)){ 
											$('#rw_'+_v.id+' .bx_tot_trck_v').html( _tot.trck.v ); 
											$('#rw_'+_v.id+' .bx_tot_trck_p').html( _tot.trck.p ); 
										}

										if(!isN(_tot.err)){ 
											$('#rw_'+_v.id+' .bx_tot_err_v').html( _tot.err.v ); 
											$('#rw_'+_v.id+' .bx_tot_err_p').html( _tot.err.p ); 
										}

									}

								}	
								
							});      
						} 
					}
				} 
			});     
				
		}       
		
	";
		
	$CntWb .= '
					$("._rpr").colorbox({ width:"450px", height:"400px", overlayClose:false, escKey:false, trapFocus:false });
					$("._html").colorbox({ width:"450px", height:"400px", overlayClose:false, escKey:false, trapFocus:false }); 
					$("._dwn").colorbox({ iframe:true, width:"1000px", height:"600px", overlayClose:false, escKey:false, trapFocus:false });
					$("._dsgn").colorbox({ width:"95%", height:"95%", overlayClose:false, escKey:false});
				'; 

	
	$CntWb .= "
	
		function _rld_ec_cmpg(){ 

			_ldCnt({ 
				u:SUMR_Main.url['".$___Ls->gt->plct."'].lnk,
				c:SUMR_Main.url['".$___Ls->gt->plct."'].box
			});
		}

	
		$('a._ec_apr').click(function() {
						
			var _id = $(this).attr('data-enc');
			
			swal({
				title: '".TX_APR."',
				text: '".TX_ECCMPGAPRPM."',
				type: 'info',
				showCancelButton: true,
				confirmButtonColor: '#64b764',
				confirmButtonText:'".TX_ACPT."',
				cancelButtonText: '".TX_CNCLR."',
				showLoaderOnConfirm: true,
				closeOnConfirm: false
			},
			function(){
				
				$.ajax({
					type: 'POST',
					data:{
						eccmpg_enc:_id,
						eccmpg_est:'"._CId('ID_ECCMPGEST_APRBD')."',
						MMM_update_est:'EdSndEcCmpg'
					},
					dataType: 'json',
					url: '".Fl_Rnd(PRC_GN.__t('snd_ec_cmpg',true))."',
					beforeSend: function() {
					},
					success: function(d){
						if(d.e == 'ok'){
							swal('".TX_APROEXT."', 'La solicitud fue procesada', 'success');
							_rld_ec_cmpg();
						}else{
							swal('Error', '".TX_NSAPRB."', 'error');
						}
					}
				})
				
			});
						
		});
		
		
		
		$('a._cmpg_no_apr').click(function() {
						
			var _id = $(this).attr('data-enc');
			
			swal({
				title: '¿No Aprobado?',
				/*text: '¿Estas seguro(a) de marcar como no aprobada esta campaña?',*/
				type: 'input',
				showCancelButton: true,
				confirmButtonColor: '#c59700',
				confirmButtonText:'Si, estoy seguro(a)',
				cancelButtonText: '".TX_CNCLR."',
				showLoaderOnConfirm: true,
				inputPlaceholder: 'Ingresa el motivo de la no aprobación',
				closeOnConfirm: false
			},
			function(_iVle){
				
				if(_iVle === false){ return false; }
				if(!isN(_iVle)){ var _mtv = _iVle; }else{ var _mtv = ''; }
				
				$.ajax({
					type: 'POST',
					data:{
						eccmpg_enc:_id,
						eccmpg_est:'"._CId('ID_ECCMPGEST_NAPRBD')."',
						eccmpg_nprb_dsc:_mtv,
						MMM_update_est:'EdSndEcCmpg'
					},
					dataType: 'json',
					url: '".Fl_Rnd(PRC_GN.__t('snd_ec_cmpg',true))."',
					beforeSend: function() {
					},
					success: function(d){
						if(d.e == 'ok'){
							swal('Proceso exitoso', 'La solicitud fue procesada', 'success');
							_rld_ec_cmpg();
						}else{
							swal('Error', '".TX_NSAPRB."', 'error');
						}
					}
				})
				
			});
						
		});
		
		
	";
				

	$CntWb .= " setTimeout(function(){ __getExtData(); }, 1000); ";
?>


	<style>
		
		.Ls_Rg .__sgm_ls ._thmb{ width: 25px; height: 25px; border: 1px solid #afb6b9; display: inline-block; border-radius:200px; -moz-border-radius:200px; -webkit-border-radius:200px; background-repeat: no-repeat; background-position: center center; background-size: 90% auto; margin-bottom: -3px; margin-left: 5px; }
		
		
		.Ls_Rg ._bimg ._sndr{ width: 30px; height: 30px; opacity: 1 !important; }
		 
		.Ls_Rg .__ls_btn{ display: block; list-style: none; padding: 0; margin: 0; text-align:right; width: 100%; white-space: nowrap; }
		.Ls_Rg .__ls_btn div{ display:inline-block; vertical-align: top; }
		
		.Ls_Rg.EcCmpg tr td.cntr{ text-align: center; background-image: none !important; font-size: 11px; line-height: 11px; position: relative; padding-right: 10px; padding-left: 10px; cursor: pointer; background-color: transparent;  }
		.Ls_Rg.EcCmpg tr td.cntr:hover .icn{ background-size: auto 60%; }
		
		.Ls_Rg.EcCmpg tr td.cntr::after{ width: 1px; height: 40px; background-color: #605a5a; position: absolute; right: 0; top: 50%; margin-top: -20px; display: block; opacity: 0.3; }
		.Ls_Rg.EcCmpg tr td.cntr .icn{ width: 25px; height: 25px; display: inline-block; background-repeat: no-repeat; background-position: center center; background-size: auto 70%; opacity: 0.7; }
		.Ls_Rg.EcCmpg tr td.cntr:hover .icn{ opacity:1; }
		
		
		.Ls_Rg.EcCmpg table._anly{ width: 100%; }
		.Ls_Rg.EcCmpg table._anly._no_show{ display: none;  }
		
		.Ls_Rg.EcCmpg table._anly tr,
		.Ls_Rg.EcCmpg table._anly td{ background-color: transparent;  }
		
		.Ls_Rg.EcCmpg tr td.cntr._date .icn{ background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>snd_cmpg_dte.svg); }
		
		.Ls_Rg.EcCmpg tr td.cntr._hour:after{ display:none; }
		.Ls_Rg.EcCmpg tr td.cntr._hour .icn{ background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>snd_cmpg_hra.svg); }
		.Ls_Rg.EcCmpg tr td.cntr._leads_allw .icn{ background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>snd_cmpg_leads.svg); }
		.Ls_Rg.EcCmpg tr td.cntr._leads_nallw .icn{ background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>snd_cmpg_leads_nallw.svg); }
		
		.Ls_Rg.EcCmpg tr td.cntr._ldd .icn{ background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>snd_cmpg_leads_load.svg); }
		.Ls_Rg.EcCmpg tr td.cntr._opn .icn{ background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>snd_cmpg_opnd.svg); }
		.Ls_Rg.EcCmpg tr td.cntr._clc .icn{ background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>snd_cmpg_click.svg); }
		.Ls_Rg.EcCmpg tr td.cntr._bnc .icn{ background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>snd_cmpg_bnce.svg); }
		.Ls_Rg.EcCmpg tr td.cntr._n_o .icn{ background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>snd_cmpg_sended.svg); }
		.Ls_Rg.EcCmpg tr td.cntr._n_p .icn{ background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>snd_cmpg_wait.svg); }
		
		
		.Ls_Rg.EcCmpg tr td.cntr ._pc{ width: 100%; white-space: nowrap; opacity: 0; color: #9d9a9a; text-align: center; display: none; }
		
		.Ls_Rg.EcCmpg tr td.cntr strong,
		.Ls_Rg.EcCmpg tr td.cntr strong ._nm{ color:#242121; font-weight: 700; }
		
		.Ls_Rg.EcCmpg tr td.cntr.pc:hover strong ._nm{ opacity: 0; pointer-events: none; display: none; }
		.Ls_Rg.EcCmpg tr td.cntr.pc:hover strong ._pc{ opacity: 1; display: block; margin-top: 4px; }
		
		.Ls_Rg.EcCmpg tr td.cntr._leads_allw strong,
		.Ls_Rg.EcCmpg tr td.cntr._leads_allw strong ._nm{ color: #3a8a12; font-weight: 700;  }
		
		
		.Ls_Rg.EcCmpg tr td.cntr._leads_nallw strong,
		.Ls_Rg.EcCmpg tr td.cntr._leads_nallw strong ._nm{ color: #700505; font-weight: 700;  }
		
		
		
	</style>	
	
	<?php $___Ls->_bld_l_pgs(); ?>
<?php } ?>
<?php $___Ls->_h_ls_nr(); ?>
<?php } ?>


<?php if($___Ls->fm->chk=='ok'){ ?>

<div class="FmTb">
		
  	<div id="<?php echo $___Ls->fm->bx->id ?>" class="bdy_snd_cmpg">
	  	
	  	
	  	<?php 
		  	
		  	if(	$___Ls->dt->tot > 0 ){ 
			  				  	
		?>
	  	
	  			<?php $___Ls->_bld_f_hdr(); ?>
  			
				<div class="ln_1 _cmpg_dtl">
					<?php include(DIR_EXT.'ec_cmpg_1.php'); ?>
				</div>	
	  			
	  	<?php }else{ echo $___Ls->dt->rw['eccmpg_est']; ?>
	  	
			  	<div class="hdr_snd_cmpg">
					<ul>
						<li id="btn_1" class="_a _anm _sis" data-tab="1"><a><?php echo TX_SIS ?></a></li>
						<li id="btn_2" class="_anm _rcp" data-tab="2"><a><?php echo TX_RCPTR ?></a></li>
						<li id="btn_3" class="_anm _stup" data-tab="3"><a><?php echo TX_CNFG ?></a></li>
						<li id="btn_4" class="_anm _ec" data-tab="4"><a><?php echo TX_PSHML ?></a></li>
						<li id="btn_5" class="_anm _cnf" data-tab="5"><a><?php echo TX_CFRMCN ?></a></li>
					</ul>
   		
				</div>
				
				<div id="shw_crtng<?php echo $___Ls->id_rnd; ?>" class="shw_crtng _anm">	                 	
                	<h2>Estamos procesando <span>Tu solicitud</span></h2>	
            	</div>

				<?php 
					
					
					if($___Ls->dt->tot > 0){	
						$CntWb .= "__ec_cmpg_tab_mod='ok';";		
					}else{
						$CntWb .= "__ec_cmpg_tab_mod='';";	
					}
					
					
					$CntWb .= "
								
						__ec_cmpg_tab_nw = '';
						__ec_cmpg_tab_op = $('.hdr_snd_cmpg li');
						
						
						function _TbCmpg(_p){
							
							if(!isN(_p)){
								
								__cb_rsz = {};
								_w='';
								_h='';
								
								$('.bdy_snd_cmpg ._bxcnt').removeClass('_opn');	
								$('.hdr_snd_cmpg li').removeClass('_a');
								$('.__mysl').removeClass('__sumr');
								$('.__cont ._col_2 .count').html(0);

								if(_p._tb == 1){
									var _idb = '__edt_sis';	
									var _w = '".$___Ls->new->w."'; var _h = ".$___Ls->new->h.";
								}else if(_p._tb == 2){
									var _idb = '__edt_rcp';
									var _w = '".$___Ls->new->w."'; var _h = 350;	
								}else if(_p._tb == 3){
									var _idb = '__edt_stp';
									var _w = '".$___Ls->new->w."'; var _h = 580;
								}else if(_p._tb == 4){
									
									var _idb = '__edt_ec';
									
									$('#Tt_Tb_".$__prfx->prfx4_u." .btn').show();
									if(__ld_ec_ifr == 'ok'){ var _w = 700; }else{ var _w = '".$___Ls->new->w."'; }
									if(__ld_ec_ifr == 'ok'){ var _h = '95%'; }else{ var _h = 330; }
									
									
									SUMR_EcCmpg_Html();
									
									setTimeout(function(){ 
						        		
						        		$('#__grph_crsl_ec_".$___Ls->id_rnd."').trigger('next.owl.carousel');
										$('#__grph_crsl_ec_".$___Ls->id_rnd."').trigger('prev.owl.carousel');
										
										$('#__grph_crsl_ec_".$___Ls->id_rnd." .owl-nav').removeClass('disabled');
						        		
						        	}, 1000);
										
									
									
								}else if(_p._tb == 5){
									var _idb = '__edt_chk';	
									var _w = '".$___Ls->new->w."'; var _h = 550;
								}
								
								if(_p._tb > __ec_cmpg_tab_nw || SUMR_Main.log.e() == 'ok'){ __ec_cmpg_tab_nw = _p._tb; }

								if(_p._tb > 3){ 
									$('#__Btnec_cmpg').fadeIn(); 
								}else{ 
									$('#__Btnec_cmpg').fadeOut(); 	
								}
								
								if(!isN(_w)){ __cb_rsz.width = _w+'px'; }
								if(!isN(_h)){ __cb_rsz.height = _h+'px'; }
								
								if(!isN(__cb_rsz)){ $.colorbox.resize( __cb_rsz ); }
								
								$('#'+_idb).addClass('_opn');
								$('#btn_'+_p._tb).addClass('_actv').addClass('_a');
							}
							
							__ec_cmpg_tab_op.off('click').click(function(){ 
								
								var __id = $(this).attr('data-tab');
								
								
								if( $(this).hasClass('_actv') && 
									( __id <= __ec_cmpg_tab_nw || ( !isN(__ec_cmpg_tab_mod) && __ec_cmpg_tab_mod == 'ok') || Spr_Log_e() == 'ok' )){
									_TbCmpg({ _tb:__id });
								}

							});
						}
						
						
						_TbCmpg({ _tb:1 });
		
								
					"; ?>
				
				
			  	<?php if($___Ls->dt->tot == 0){ $CntWb .= " $('#Tt_Tb_".$__prfx->prfx4_u." .btn').hide(); "; } ?>
                       
			    <form method="POST" name="<?php echo $___Ls->fm->id; ?>" target="_self" id="<?php echo $___Ls->fm->id; ?>" >
			    					  
		
				  	<div id="<?php echo $___Ls->fm->fld->id ?>">	
					  		
					  		<div class="_bxcnt ln_1 __mysis _anm" id="__edt_sis" style="display:none;">
						  		
						  		<?php $__siseml = __LsDt([ 'k'=>'sis_eml', 'cl'=>$___Ls->cl->id ]); ?>
						  		
						  		<div id="__grph_crsl_snd_<?php echo $___Ls->id_rnd; ?>" class="siseml_lst owl-carousel owl-theme no-draggable-area">
									
									<div class="item _opt tt">
										<div class="_bx">
											<h1 class="__tt"><?php echo TX_SLCTH ?><br><span><?php echo TX_SYSTSND ?></span></h1>	
										</div>
									</div>
										
									<?php foreach($__siseml->ls->sis_eml as $_sis_k=>$_sis_v){ 
											
											if(mBln($_sis_v->prm->vl) == 'ok'){ 
												if(!_ChckMd('snd_ec_sndr_'.$_sis_v->key->vl)){
													$__show_snd = 'no';
												}else{
													$__show_snd = 'ok';	
												}
											}else{
												$__show_snd = 'ok'; 
											}
																					
									?>
										
										<?php if(mBln($_sis_v->msv->vl) == 'ok' && $__show_snd == 'ok'){ ?>
											
											<?php 
												
												if($___Ls->dt->rw['eccmpg_sndr'] == $_sis_v->id){ $__sl_ok='_slctd'; }else{ $__sl_ok=''; }
												
											?>
											<div class="item _opt no-draggable-area <?php echo $__sl_ok; ?>" data-id="<?php echo $_sis_v->enc; ?>" data-tp="<?php echo $_sis_v->key->vl; ?>">
												<div class="_bx">
													<?php if($_sis_v->key->vl == 'sisin'){ $_img = $___Ls->cl->lgo->lght->big; }else{ $_img = $_sis_v->img; } ?>
													<?php if($_sis_v->img_v->ext == 'svg'){ $_cls='_svg'; }else{ $_cls=''; } ?>
													<figure style="background-image:url(<?php echo $_img; ?>);" class="<?php echo $_cls; ?>"></figure>
													<?php echo h2($_sis_v->tt) ?>
												</div>
											</div>
										<?php } ?>
									
									<?php } ?>
									
									<?php

											$CntWb .= '
											
												SUMR_Main.ld.f.owl( function(){

													
													$("#__grph_crsl_snd_'.$___Ls->id_rnd.'").owlCarousel({
														autoPlay: false,
														nav: true,
														margin: 10
													});
													
													$("#__grph_crsl_snd_'.$___Ls->id_rnd.' .item").not(".tt").off("click").click(function(){ 
														
														var __id = $(this).attr("data-id"); 
														var __tp = $(this).attr("data-tp");
														
														
														if(__tp!="sisin" && __tp!="sumr"){ 
															$("#ec_lsts_bx, #ec_lsts_sgm_bx").html(""); 
														}	
														
														if(__tp=="sumr"){
															$("#__edt_stp_eml").show();
														}else{
															$("#__edt_stp_eml").hide();
														}
														
														if(__tp=="ofc"){ __siseml = "all"; }else{ __siseml = __id; }
														
														$("#eccmpg_sndr").val(__id);
														
														SUMR_Main.bxajx.cmpg.sndr = __tp;
														
														if(__tp == "sumr" || __tp == "ofc"){
															$("#li_run_code_'.$___Ls->id_rnd.'").show();
														}else{
															$("#li_run_code_'.$___Ls->id_rnd.'").hide();
														}
														
														$("#__grph_crsl_snd_'.$___Ls->id_rnd.' .item").removeClass("_on");
														$(this).addClass("_on");
														
														_TbCmpg({ _tb:2 });
														
														__ld_lsts();
														

													});
												
												});
											
											';
			
									?>
								</div>
								
									
								
					  		</div>
					  		
					  			
							<div class="_bxcnt ln_1 __mysl _anm" id="__edt_rcp" style="display:none;">
								<style>
									.__mysl .__cont ._col_2{ display: none; }
									.__mysl.__sumr{width:80% !important;margin-top: 0;}
									.__mysl.__sumr .__cont{display: flex;}
									.__mysl.__sumr .__cont ._col_1,
									.__mysl.__sumr .__cont ._col_2{display: inline-block;width: 50%;}
									.__mysl.__sumr .__cont ._col_2 .icon{width: 50px;height: 50px;background-size: 100%;margin: 0 auto;background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>tot_eml.svg); }
									.__mysl.__sumr .__cont ._col_2 .count{font-size: 23px;margin: 10px 0;color: #989898;font-family: 'Economica';}
									.__mysl.__sumr .__cont ._col_2.__ld {filter: grayscale(1);opacity: 0.5;}
									.__mysl.__sumr .__cont ._col_1 #ec_lsts_sgm_bx.__ld {pointer-events:none;}
								</style>
								<?php echo h2(TX_FMSLC.' '.TX_LST) ?> 
								<div class="__cont">
									<div class="_col_1">
										<div class="__opt1">
									
											<?php echo HTML_inp_hd('eccmpg_sndr', $___Ls->dt->rw['eccmpg_sndr']); ?>
											
											<div id="ec_lsts_bx" class="_sbls">
												
												<?php 
													
													$CntWb .= "
														
														__siseml='';
														
														function __ld_lsts(){	
															
															if(isN(__siseml)){ __siseml = '".$___Ls->dt->rw['eccmpg_sndr']."'; }
															
															SUMR_Main.ld.f.slc({
																i:'".$___Ls->dt->rw['eccmpg_sgm']."', 
																t:'ec_lsts', 
																d:{
																	_tp:'".$___Ls->mdlstp->tp."',
																	_sndr:__siseml
																}, 
																b:'ec_lsts_bx', 
																_cl: function(){
																	$('#Nxt_1').fadeIn();
																	_DomRbld();	
																} 
															});
															
														}
														
														
													"; 
														
												?>
											
											</div>
												
											<div id="ec_lsts_sgm_bx" class="_sbls">
												<?php 
													
													$CntWb .= "
														
														function __ld_sgm(p){
															
															SUMR_Main.ld.f.slc({
																i:p.id, 
																t:'ec_lsts_sgm', 
																t_i:p.est_i, 
																b:'ec_lsts_sgm_bx', 
																_ts:'eccmpg_cmpg_sgm',
																_ts_p:'".$___Ls->mdlstp->id."',
																_cl: function(){
																	$('#Nxt_1').fadeIn();	
																} 
															});
															
														}
															
													";
														
															
													$DomRbld .= "
														
										
														$('#eccmpg_lsts').change(function() {
				
															var _id = $(this).val();
															var _est_i = $(this).val();
															
															var __sl = $('#eccmpg_lsts option:selected');
															var __sl_are = __sl.attr('are-tot');
															
															SUMR_Main.bxajx.cmpg.lsts.are_tot = __sl_are;
															
															__ld_sgm({ id:_id, est_i:_est_i });	
																
														});
													
													";  	 
												?>		
											</div>
											
											<input type="button" value="<?php echo TX_SIG ?>" id="Nxt_1" style="display: none;">
											<?php 
											
											if(!isN($__dt_cl->tag->txt->cmpg_cnf->v)){
												
												$__cnf_nxt_1 = "
													
													if(!isN(SUMR_Main.bxajx.cmpg.lsts.are_tot) && SUMR_Main.bxajx.cmpg.lsts.are_tot == 0){
														swal({
															title: 'Recuerde',
															text: '".$__dt_cl->tag->txt->cmpg_cnf->v."',
															type: 'warning',
															showCancelButton: true,
															confirmButtonColor: '#64b764',
															confirmButtonText:'".TX_ACPT."',
															cancelButtonText: '".TX_CNCLR."',
															showLoaderOnConfirm: true,
															closeOnConfirm: false
														});
													}
													
												";
												
											}
											
											$CntWb .= " 
												
												$('#Nxt_1').off('click').click(function(){ 
													
													if($('#".$___Ls->fm->id."').valid()) {
														{$__cnf_nxt_1}
														_TbCmpg({ _tb:3 }); 
													}
												
												});
											
											"; ?>
										</div>			
									</div>	
									<div class="_col_2">
										<div class="icon"></div>
										<div class="count">0</div>
									</div>
								</div>
							</div>

							
							<div class="_bxcnt ln_1 __setup" id="__edt_stp" style="display: none;" >
									
									<div class="col_1">
										
										<div class="_bsc _anm">
											
					                    	<?php echo h2(TX_DTSBSC); ?> 
					                    	
					                    	<div id="__edt_stp_eml" class="eml_sndr" style="display: none;">
						                    	<?php 
							                    	
							                    	if(_ChckMd('snd_ec_slc_eml')){
							                    		echo LsClEml('eccmpg_eml','eml_enc', $___Ls->dt->rw['eccmpg_eml'], 'Seleccione Sender', 2, '', 'Width'); 
							                    		$CntWb .= JQ_Ls('eccmpg_eml', '- seleccione sender -');	
							                    	}
							                    	
							                    ?>
					                    	</div>
					                    	
					                    	<?php echo HTML_inp_hd('eccmpg_nwid', ''); ?>
											<?php echo HTML_inp_tx('eccmpg_nm', TX_NM.' '.TX_DE.' '.TX_CAMP, ctjTx($___Ls->dt->rw['eccmpg_nm'],'in'), FMRQD, '', '_nm'); ?> 
											
											<div class="__sbj_wrp">
												<?php echo HTML_inp_tx('eccmpg_sbj', TX_SBJCT, ctjTx($___Ls->dt->rw['eccmpg_sbj'],'in'), FMRQD, '', '_sbj', 40); ?> 
												<?php echo '<a href="'.Void().'" id="emoji_opn" class="get_moji _anm">'._mJi('\u1F600').'</a>'; ?>
											</div>
											
											
											<?php echo HTML_inp_tx('eccmpg_prhdr', TX_PRHDR, ctjTx($___Ls->dt->rw['eccmpg_prhdr'],'in'), FMRQD, '', '_prhdr', 40); ?>

							                <?php 
			
												$CntWb .= "
												
													$('#eccmpg_sndr').change(function() {
														var _sl = $('#eccmpg_sndr option:selected');
														var _rel = _sl.attr('rel'); 
														$('#eccmpg_frm').val( _rel );
													});
												";
								                
							                ?>
							                <?php echo HTML_inp_hd('eccmpg_tp', (!isN($__sis_tp->id)?$__sis_tp->id:1 )); ?>
						                    
										</div>                                              
										<div class="_moj _anm">
											<?php 
												
												$__emoji = __LsDt([ 'k'=>'emoji', 'cl'=>$__dt_cl->id ]);
												
												foreach($__emoji->ls->emoji as $_k => $_v){
													$__moji .= li( '<a href="'.Void().'" rel="'._mJi($_v->cdg->vl).'">'._mJi($_v->cdg->vl).'</a>', '_emoji' );
												}

												echo bdiv([ 'id'=>'emoji_bx', 'sty'=>'display:none;', 'c'=>ul( $__moji, 'bx_emoji' ).'<input id="_cpyCpb_v" class="_cpy">' ]);
												
												
												$CntWb .= " 
												
													$('#emoji_opn').off('click').click(function(){	
														$('._bxcnt.__setup').addClass('__emoji');
													});";
												
												$CntWb .= " 
												
													$('._emoji').off('click').click(function(){ 
																
														$('._emoji').removeClass('_sl');
														var rel_emoji = $(this).find('a').prop('rel');
														$(this).addClass('_sl');
														
														SUMR_Main.cpy.cpb({ 
										  			  		_t: rel_emoji,
										  			  		_bx: '#_cpyCpb_v',
										  			  		_c: function(){
											  			  		
											  			  		$('._bxcnt.__setup').removeClass('__emoji');
											  			  		
										  			  		}
										  			  	});
													
													});
												
												"; 
															
															
											?>
										</div>
					                </div>
					                <div class="col_2"> 
						                
						                <?php echo h2(TX_DTSSND); ?>
						                <?php //echo HTML_inp_tx('eccmpg_frm', TX_DE.' '.'('.TX_NM.')', ctjTx($___Ls->dt->rw['eccmpg_frm'],'in'), FMRQD, '', '_frm' ); ?>
					                    <?php echo HTML_inp_tx('eccmpg_rply', TX_RPLYTO, ctjTx($___Ls->dt->rw['eccmpg_rply'],'in'), FMRQD_EML, '', '_rply' ); ?>
					                    
					                    <?php 
						                    
						                    if(defined('TAG_EC_CMPG_DAYS_APRB') && !_ChckMd('eccmpg_p_f_lmt')){
							                	$__days_aprb = TAG_EC_CMPG_DAYS_APRB;    
						                    }
						                    
						                    echo SlDt([ 
						                    				'id'=>'eccmpg_p_f', 
						                    				'va'=>$___Ls->dt->rw['eccmpg_p_f'], 
						                    				'rq'=>'ok', 
						                    				'lmt'=>'no', 
						                    				'ph'=>TX_F.' '.TX_PRGMD, 
						                    				'_mdy'=>$__days_aprb, 
						                    				'drp'=>['data-l-d'=>'ok'] 
						                    			]);
						                    			
						                    			 
						                ?> 
					                    <?php echo SlDt([ 't'=>'hr', 'id'=>'eccmpg_p_h', 'va'=>$___Ls->dt->rw['eccmpg_p_h'], 'rq'=>'ok', 'ph'=>TX_HR.' '.TX_PRGMD ]); ?> 

					                    <?php
						                     
						                    if($___Ls->dt->rw['eccmpg_est'] == _CId('ID_ECCMPGEST_PSD')){
								                echo HTML_inp_hd('eccmpg_est', _CId('ID_ECCMPGEST_SNDIN')); 
							                }elseif($___Ls->dt->rw['eccmpg_est'] == _CId('ID_ECCMPGEST_SNDIN') ){
								                echo HTML_inp_hd('eccmpg_est', _CId('ID_ECCMPGEST_PSD'));
							                }
							                
					                    ?>
						
					                </div>
					                
					                <?php $__id_op_crs = 'opt-'.Gn_Rnd(20); ?>            
					                <div id="<?php echo $__id_op_crs; ?>" class="owl-carousel owl-theme __nts">
						            	<div class="item _nm"><?php echo TX_NVSHM ?></div>
										<div class="item _rply"><?php echo TX_MRSPSHM ?></div>
					                </div>    
									
									<?php 
										$CntWb .= "
											SUMR_Main.ld.f.owl( function(){
												$('#".$__id_op_crs."').owlCarousel({
													items:1
												});
											});
										"; 
									?>
										
					                <div class="ln_1">
									
					                	<input type="button" value="<?php echo TX_SIG ?>" id="Nxt_2">
					                </div>
									<?php 
										
										$CntWb .= " 
										
											$('#Nxt_2').click(function(){ 
										
												var __c_nm = $('#eccmpg_nm').val();
												var __c_sbj = $('#eccmpg_sbj').val();
												var __c_frm = $('#eccmpg_frm').val();
												
												var __c_dte = $('#eccmpg_p_f').val();
												var __c_hra = $('#eccmpg_p_h').val();
	
												/*var __c_sndr = $('#eccmpg_sndr').val();*/

												$('#".$___Ls->fm->id."').valid();

												if($('#eccmpg_rply').hasClass('error')){

												}else{
													if( !isN(__c_nm) && !isN(__c_sbj) /* && !isN(__c_frm) */ /*&& __c_sndr != ''*/ ){
														
														$('#rsmn_sbj').html(__c_sbj);
														$('#rsmn_dte').html(__c_dte);
														$('#rsmn_hra').html(__c_hra);
														
														_TbCmpg({ _tb:4 }); 
														
													}
												}	
											});
										"; 
									?>
							</div>
							
							
							<div class="_bxcnt ln_1 __pushm" id="__edt_ec" style="display:none;">
									
					                
					                <?php echo HTML_inp_hd('eccmpg_ec', $___Ls->dt->rw['ec_enc']); ?>
					                
					                <?php if($___Ls->dt->tot == 0){ ?>
					                
									<div class="ln_x6">
					                        <div class="">
						                        
						                        <div id="ec_all_bx" class="_sbls ec_all_bx _anm">	
							                        <div class="__grph_crsl_ec_sch _anm">
								                        <div class="_bx_wrp _anm">
									                        <?php echo HTML_inp_tx('ec_sch_tx', TX_SEARCH); ?>
								                        	<button class="_x"></button>
								                        </div>   
								                    </div>
							                    	<div id="__grph_crsl_ec_<?php echo $___Ls->id_rnd; ?>" class="ec_lst owl-carousel owl-theme _anm"></div>	
							                    	<button class="_dwn_crsl _anm" style="display: none;"></button>   
						                        </div>
												
												<?php
									
														$CntWb .= '
															
															
															function __ld_ec_owl(){
																
																SUMR_Main.ld.f.owl( function(){
																		
																	$("#__grph_crsl_ec_'.$___Ls->id_rnd.'").owlCarousel({
																		autoPlay: true,
																		autoplayHoverPause: true,
																		items:5,
																		margin:5,
																		nav: true
																	});
																	
																});
															
															}
															
															__ld_ec_owl();
														
														';
										
												?>
												
												
												    
						                        <?php 
							                        
							                        $CntWb .= "
														
														
														__ld_ec_i = 1;
														__ld_ec_lst = 1;
														__ld_ec_tot = '';
														__ld_ec_ifr = '';
														__upd='';
														
														
														__ec_sch_bx = $('.__grph_crsl_ec_sch input[type=text]');
														
														
														
														function __ld_ec_btn_rmv(p){
															
															if(__ld_ec_i > 1){ var __upd='ok'; }
															
															__ld_ec_tot = $('#__grph_crsl_ec_".$___Ls->id_rnd." .owl-item').length - 3;

															if(__upd == 'ok'){
																
																for (var i=0; i<=2; i++) {
																	var _itm_del = __ld_ec_tot;
																    $('#__grph_crsl_ec_".$___Ls->id_rnd."').owlCarousel('remove', _itm_del ).owlCarousel('update');
																}	
															
															}
															
														}
														
														
														function __ld_ec_all_rmv(p){
															
															__ld_ec_tot = $('#__grph_crsl_ec_".$___Ls->id_rnd." .owl-item').length;

															if(__ld_ec_tot > 0){
																
																for (var i=0; i<=__ld_ec_tot; i++) {
																	var _itm_del = i;
																    $('#__grph_crsl_ec_".$___Ls->id_rnd."').owlCarousel('remove', _itm_del ).owlCarousel('update');
																}	
															
															}
															
														}
														
														
														
														function __ld_ec_btn_add(p){
												

															$('#__grph_crsl_ec_".$___Ls->id_rnd."').owlCarousel('add', 
																'<div class=\"item _anm _opt dynmc mre no-draggable-area\">
																	<div class=\"_bx\">
																		<figure class=\"_anm\"></figure>
																		<h3>Cargar más items</h3>
																	</div>
																</div>').owlCarousel('update');														
																
															$('#__grph_crsl_ec_".$___Ls->id_rnd."').owlCarousel('add', 
																'<div class=\"item _anm _opt dynmc sch no-draggable-area\">
																	<div class=\"_bx\">
																		<figure class=\"_anm\"></figure>
																		<h3>Buscar...</h3>
																	</div>
																</div>').owlCarousel('update');
																
															$('#__grph_crsl_ec_".$___Ls->id_rnd."').owlCarousel('add', 
																'<div class=\"item _anm _opt dynmc empty no-draggable-area\">
																	<div class=\"_bx\">
																		<figure class=\"_anm\"></figure>
																	</div>
																</div>').owlCarousel('update');
															
														}
														
														
														function SUMR_EcCmpg_Html(p){
															
															if(!isN(p) && !isN(p.rst) && p.rst == 'ok'){ 
																_lst = '';
															}else{
																_lst = __ld_ec_lst;	
															}	
															
															if(!isN(p) && !isN(p.sch)){ 
																_tsch = p.sch;
															}else{
																_tsch = '';	
															}
															
																
															_Rqu({
																t:'snd_ec',
																mre:'&sch='+_tsch,
																_tp:'".$___Ls->mdlstp->enc."',
																_lst:_lst,
																_cl:function(_r){

																	if(!isN(_r)){
																		
																		if(!isN(_r.ls)){	
																			
																			if(!isN(p) && !isN(p.rst) && p.rst == 'ok'){ 		
																				__ld_ec_all_rmv();
																				$('.__grph_crsl_ec_sch').removeClass('on');	
																			}
																			
																			__ld_ec_btn_rmv();
																																				
																			$.each(_r.ls, function(_k, _v) {
																				
																				var _bck_url='';
																				
																				if(isN(_v.img)){ 
																					var _cls='_non'; 
																				}else{ 
																					var _cls=''; 
																					
																					if(!isN(_v.img.th_200)){
																						var _bck_url = ' background-image:url('+ _v.img.th_200 + ');  ' ;
																					}
																				}
																				
																				if(!isN(_v.ord)){
																					var __cr_tt = _v.ord;
																				}else if(!isN(_v.id)){
																					var __cr_tt = '".CODNM_EC."'+_v.id;
																				}else{
																					var __cr_tt = _v.tt;
																				}
																				
																				$('#__grph_crsl_ec_".$___Ls->id_rnd."').owlCarousel('add', '
																					<div class=\"item renc _anm _opt no-draggable-area\" data-enc=\"'+_v.enc+'\" title=\"'+_v.tt+'\" alt=\"'+_v.tt+'\">
																						<div class=\"_bx\">
																							<figure class=\"_anm '+_cls+'\">
																								<img style=\"'+_bck_url+'\" >
																								<!--<button class=\"_dtl _anm\" data-enc=\"'+_v.enc+'\"></button>-->
																							</figure>
																							<h2>'+__cr_tt+'</h2>
																						</div>
																					</div>																				
																				').owlCarousel('update');
																				
																				__ld_ec_lst = _v.enc; 
																				
																			});	
																			
																			__ld_ec_btn_add();
																				
																			if(__ld_ec_i == 1){ __ld_ec_owl(); }
																			
																			$('#__grph_crsl_ec_".$___Ls->id_rnd."').trigger('to.owl.carousel', __ld_ec_tot);

																			__ld_ec_i++;
																				
																		}
																	}	
																	
																	_DomRbld();
																	
																}
															});
															
															
														}
														
														
														
																
														function __sch_ec(){
															__txt = __ec_sch_bx.val();
														    SUMR_EcCmpg_Html({ rst:'ok', sch:__txt });    		
														};
															
													";
													
													
													$DomRbld .= ' 
														
														
														
														
														$("#__grph_crsl_ec_'.$___Ls->id_rnd.' .item.mre").off("click").click(function(e){ 
															
															e.preventDefault();

															if(e.target != this){ 
														    	e.stopPropagation(); return false;
															}else{
																SUMR_EcCmpg_Html();
															}
																										
														});
														
														
														$("#__grph_crsl_ec_'.$___Ls->id_rnd.' .item.sch").off("click").click(function(e){ 
															
															e.preventDefault();

															if(e.target != this){ 
														    	e.stopPropagation(); return false;
															}else{
																
																$(".__grph_crsl_ec_sch").addClass("on");
																
																__ec_sch_bx.off("keyup").on("keyup", function (e) {							
																	e.preventDefault();
																	if(e.keyCode == 13){
																		__sch_ec();
																    }  
																});
																
																
																$(".__grph_crsl_ec_sch ._bx_wrp button._x").off("click").click(function(e){							
																	e.preventDefault();
																	__sch_ec();
																	$(".__grph_crsl_ec_sch").removeClass("on");
																});
																
															}
																										
														});
														
														
														$("#__grph_crsl_ec_'.$___Ls->id_rnd.' .item ._dtl").off("click").click(function(e){ 

															e.preventDefault();

															if(e.target != this){ 
														    	e.stopPropagation(); return false;
															}else{
																var __id = $(this).attr("data-enc");
																/*alert(__id);*/
															}

														});
														
														
														$("#__grph_crsl_ec_'.$___Ls->id_rnd.' .item.renc").off("click").click(function(e){ 
														
															e.preventDefault();
															
															if(e.target != this){ 
														    	e.stopPropagation(); return false;
															}else{
																var __id = $(this).attr("data-enc");
																$("#eccmpg_ec").val(__id);
																
																$("#__grph_crsl_ec_'.$___Ls->id_rnd.' .item").removeClass(\'_slct\');
																$(this).addClass(\'_slct\');
																
																_____shw_ec();
															}
																										
														});
														
														
														
														$(".__pushm ._dwn_crsl").off("click").click(function(e){ 
														
															e.preventDefault();
															
															if(e.target != this){ 
														    	e.stopPropagation(); return false;
															}else{
																__stay_opn = "ok";
																$("#__edt_ec").removeClass("_ec_ldd");
															}
																										
														});
														
														
														
														
													';
											
											
						                        ?> 
					                        </div> 
											
											<div class="_tmpl_opt" style="display: none;">
												
												<div class="_c c_1"></div>
												<div class="_c c_2">
													<?php 	
														echo OLD_HTML_chck('eccmpg_scl', TX_RDSC, ($___Ls->dt->rw['eccmpg_scl']?$___Ls->dt->rw['Estado']:'1'), 'in'); 
													?>
												</div>
												<div class="_c c_3">
													<?php 
														echo OLD_HTML_chck('eccmpg_tll', TX_TLLFRND, ($___Ls->dt->rw['eccmpg_tll']?$___Ls->dt->rw['eccmpg_scl']:'1'), 'in');  
													?>
												</div>
												<div class="_c c_4">	
													<input type="button" value="<?php echo TX_FNLZR ?>" id="Nxt_3" class="_sve_all" style="display: none;">
												</div>
											</div>
					                </div>
					                <?php } ?>

					                <div class="ln_1">
					                	<iframe id="__html_ec" width="100%" height="1500" frameborder="0">Here</iframe>
					                </div>
					                	
					                <?php 
						                
						                $CntWb .= "
						                	
						                	
						                	__stay_opn = '';
						                	
						                	SUMR_Main.bxajx.cmpg = { sve:'', sndr:'', lsts:{ are_tot:'' } };
						                	
						                	function _____shw_ec(p){	
							                	
							                	
							                	try{

								                	/*if(!isN(p.mod)){*/
														$.colorbox.resize({ width:700, height:'95%' });
													/*}*/
								                	
								                	$('.bdy_snd_cmpg ._tmpl_opt').fadeIn();
								                	
								                	
								                	if(isN(__stay_opn)){
								                		$('#__edt_ec').addClass('_ec_ldd');
								                	}
								                	
								                	var __id = $('#eccmpg_ec').val();
	
												  	if( $('#eccmpg_scl').is(':checked') ){ var __scl = 'ok'; }else{ var __scl = 'no'; }
												  	if( $('#eccmpg_tll').is(':checked') ){ var __tll = 'ok'; }else{ var __tll = 'no'; }
													
												  	__ifr_ec({ id:__id, mre:'&_scl='+__scl+'&_tll='+__tll });
												  	
												  	$('#Nxt_3').fadeIn();
												  	
												  	/*_TbCmpg({ _tb:5 });*/
											  	
											  	}catch(e) {
												  	
													SUMR_Main.log.f({ t:'_____shw_ec:', m:e });
													
												}

											  	
						                	}
						                	
						                	
						                	$('#eccmpg_scl, #eccmpg_tll').change(function() {
											  	
											  	_____shw_ec();
		
											});
											
											
											function __ifr_ec(p){
												var __if_url = '".DMN_EC.LNK_HTML."/'+p.id+'/?'+p.mre;  
												$('#__html_ec').attr('src', __if_url);
												__ld_ec_ifr = 'ok';
											}
											
											
											$('#eccmpg_sbj').keyup(function(){
											    var __k_sbj = $(this).val();
											    $('#_chck_sbj').html(__k_sbj);
											});
											
											
											$('#Nxt_3').off('click').click(function(){ 
												
												var _data = {};
												var _data_s = $('#".$___Ls->fm->id."').serializeArray();
												
												if(!isN(_data_s)){
													$.each(_data_s, function(_data_s_k, _data_s_v) {

														var _nm = _data_s_v.name;
														var _arr = 'no';
														
														if(_nm.indexOf('[]') !== -1){ 
															_nm = _nm.replace('[]','');
															_arr = 'ok';
														}
														
														if(_arr == 'ok'){	
												       		if(isN(_data[ _nm ])){ _data[ _nm ] = []; }
												       		_data[ _nm ].push( _data_s_v.value );
												        }else{
													        _data[ _nm ] = _data_s_v.value; 
												        }
												        
													});
												}

												_data.f = 'prc';
												_data.t = 'snd_ec_cmpg';
												
												_data._bs = function(){ 
													$('#Nxt_3').addClass('_ld');
												};
												
												_data._cm = function(){
													$('#Nxt_3').removeClass('_ld');
												}; 
												
												_data._cl = function(_r){
													
													if(!isN(_r)){
														
														if(!isN(_r.e) && _r.e == 'ok'){
															
															swal('Campaña Guardada', 'Ahora revisemos los últimos detalles', 'success');
															
															_TbCmpg({ _tb:5 }); 
																
															$('#Nxt_3').fadeOut();
															
															SUMR_Main.bxajx.cmpg.sve = 'ok';
															
															if(!isN(_r.dt.enc)){
																$('#eccmpg_nwid').val(_r.dt.enc);
															}
															if(!isN(_r.dt.eml_allw)){
																$('#snd_to_tot".$___Ls->id_rnd."').html(' '+_r.dt.eml_allw+' ');	
															}
															if(!isN(_r.dt.lsts) && !isN(_r.dt.lsts.html)){
																$('#snd_to_lsts".$___Ls->id_rnd."').html(_r.dt.lsts.html);	
															}
															if(!isN(_r.dt.sgm) && !isN(_r.dt.sgm.html)){
																$('#snd_to_sgm".$___Ls->id_rnd."').html(_r.dt.sgm.html);	
															}
															
															
															_ldCnt({ 
																u:SUMR_Main.url['".$___Ls->gt->plcf."'].lnk,
																c:SUMR_Main.url['".$___Ls->gt->plcf."'].box
															});
															
												
														}else{	
															_Rqu_Msg({ t:'w' });		
														}
													}
												};

												if(isN( SUMR_Main.bxajx.cmpg.sve ) && !isN(_data)){
													_Rqu( _data );
												}
											
											});
											
											
											$('#lets_go_".$___Ls->id_rnd."').off('click').click(function(e){ 	
												
												e.preventDefault();
													
												if(e.target != this){
													
											    	e.stopPropagation(); return;
											    	
												}else{
													
													if(!isN( SUMR_Main.bxajx.cmpg.sve ) && SUMR_Main.bxajx.cmpg.sve == 'ok'){
														
														SUMR_Main.pop.bck({ t:'pop' });
															
													}		
														
												}
											
											});
											
											
						                ";
						                 
						                 
						                 if($___Ls->dt->tot > 0){  $CntWb .= " _____shw_ec({ mod:'ok' });"; }
						                
										 if($___Ls->dt->tot > 0){  $CntWb .= "__ifr_ec('".$___Ls->dt->rw['eccmpg_ec']."', '"._SbLs_ID('i')."', '');"; }
										 
										 
										 if(!isN($_GET['_ec'])){ $CntWb .= " _____shw_ec(); "; }
					                ?>
					                
					                
							</div>
							
							
							<div class="_bxcnt ln_1 __chck" id="__edt_chk" style="display:none;">
								<?php include(DIR_EXT.'ec_cmpg_2.php'); ?>	
							</div>
							
							
							
							<?php 
								
								$CntWb .= "
								
									
									function _DomRbld(){
										
										".$DomRbld."
										
									}
									
								";
								
								
							?>
					</div>

		
			    </form>
				
				
				
				<style>
									
					.bdy_snd_cmpg .siseml_lst{  }
					
					.bdy_snd_cmpg .siseml_lst ._opt{ position: relative; }
					
					.bdy_snd_cmpg .siseml_lst ._opt ._bx{ border: 1px solid #b6babc; height:150px; border-radius:10px; -moz-border-radius:10px; -webkit-border-radius:10px; cursor: pointer; }
					.bdy_snd_cmpg .siseml_lst ._opt._on ._bx{ border-color:var(--second-bg-color); border-width: 2px; }
					
					.bdy_snd_cmpg .siseml_lst ._opt ._bx:hover{ background-color: #f0f4f5; }
					.bdy_snd_cmpg .siseml_lst ._opt ._bx figure{ width: 90px; height: 90px; background-repeat: no-repeat; background-position: center center; background-size:contain; margin-left: auto; margin-right: auto; margin-top: 10px; }
					.bdy_snd_cmpg .siseml_lst ._opt ._bx figure._svg{ background-size:auto 50%; }
					
					.bdy_snd_cmpg .siseml_lst ._opt ._bx h2{ font-weight: 300; margin:0; padding: 0; border: none; text-align: center; font-family: Work Sans; font-size: 14px; }
					
					.bdy_snd_cmpg .siseml_lst ._opt._slctd::before{ width:20px; height: 20px; position: absolute; border-radius:200px; -moz-border-radius:200px; -webkit-border-radius:200px; right: 5px; bottom: 5px; background-color: #51c392; }
					
					
					.bdy_snd_cmpg .siseml_lst ._opt.tt ._bx{ background-color: #e5e8e8; }
					.bdy_snd_cmpg .siseml_lst ._opt ._bx h1.__tt{ border: none; line-height: 20px; padding-top: 30px; }
					.bdy_snd_cmpg .siseml_lst ._opt ._bx h1.__tt span{ font-size: 17px; color: #8c9595;  }

					.__sbj_wrp{ position: relative; }
					.__sbj_wrp .get_moji{ opacity: 0; pointer-events: none; position: absolute; right: 10px; top: 10px; text-decoration: none;  }
					.__sbj_wrp:hover .get_moji{ opacity:1; pointer-events:all; }
					.__sbj_wrp:hover input[type="text"]{ background-image: none !important; }
					 
					
		                    
		            .bdy_snd_cmpg .__nts{ padding: 30px 20px 0 20px; margin: 0; list-style: none; }
		            .bdy_snd_cmpg .__nts .item{ font-family: Work Sans; font-size: 11px; line-height: 11px; color: #8a8787; width: 100%; white-space: normal; display: block; border-radius:10px; -moz-border-radius:10px; -webkit-border-radius:10px; padding: 10px 15px 10px 40px; margin-bottom: 10px; background-repeat: no-repeat; background-position: left top; background-size: 25px auto; }
		            
		            
		            .bdy_snd_cmpg .__nts .item._nm{ background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>snd_cmpg_nm.svg); }
		            .bdy_snd_cmpg .__nts .item._rply{ background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>snd_cmpg_rply.svg); }
		            
		            .bdy_snd_cmpg input[type="text"]{ background-repeat: no-repeat; background-position: right 10px center; background-size: auto 40%; padding-right: 35px; }        
		            .bdy_snd_cmpg input[type="text"].error{ background-position: right 5px bottom 5px; background-size: auto 30%; }
		            .bdy_snd_cmpg input[type="text"]._nm{ background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>snd_cmpg_nm.svg); }
		            .bdy_snd_cmpg input[type="text"]._sbj{ background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>snd_cmpg_sbj.svg); } 
		            .bdy_snd_cmpg input[type="text"]._prhdr{ background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>snd_cmpg_prhdr.svg); } 
		            .bdy_snd_cmpg input[type="text"]._frm{ background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>snd_cmpg_frm.svg); } 
		            .bdy_snd_cmpg input[type="text"]._rply{ background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>snd_cmpg_rply.svg); } 
					
					
					
					.bdy_snd_cmpg .__grph_crsl_ec_sch{ position: absolute; background-color: rgba(255, 255, 255, 0.9); width: 100%; height: 100%; z-index: 10; top:-1000px; opacity: 0; pointer-events: none; }
					.bdy_snd_cmpg .__grph_crsl_ec_sch.on{ top:0; opacity: 1; pointer-events: all; }
					.bdy_snd_cmpg .__grph_crsl_ec_sch ._bx_wrp{ position: absolute; top: 50%; left: 50%; margin-top: -40px; margin-left: -100px; width: 200px; }
					
					.bdy_snd_cmpg .__grph_crsl_ec_sch input[type=text]{ background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>ec_sch.svg); background-size: auto 20px; background-repeat: no-repeat; background-position: left 10px center; padding-left: 40px; border: 2px solid #d3d1d1; background-color: white; border-radius:10px;
-moz-border-radius:10px; -webkit-border-radius:10px; text-align: center; }

					.bdy_snd_cmpg .__grph_crsl_ec_sch ._bx_wrp button._x{ width: 14px; height: 14px; top: -5px; right: -5px; display: block; position: absolute; background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>ec_x.svg); background-size: 100% auto; background-repeat: no-repeat; background-position: center center; opacity: 0.5; border: none; background-color: transparent; }
					.bdy_snd_cmpg .__grph_crsl_ec_sch ._bx_wrp button._x:hover{ opacity: 1; }
					
					
					
					.bdy_snd_cmpg .ec_lst{ margin-top: 20px; margin-bottom: 20px; }
					.bdy_snd_cmpg .ec_lst ._opt ._bx{ border:none; cursor: pointer; pointer-events: none; }
					
					.bdy_snd_cmpg .ec_lst ._opt ._bx figure{ width: 90px; height: 90px;  margin-left: auto; margin-right: auto; margin-top: 10px; border-radius:200px; -moz-border-radius:200px; -webkit-border-radius:200px; border: 2px solid #f2f4f5; position: relative; pointer-events: none; }
					.bdy_snd_cmpg .ec_lst ._opt ._bx figure img{ width: 75px; height: 75px; border-radius:200px; -moz-border-radius:200px; -webkit-border-radius:200px; background-repeat: no-repeat; background-position: center center; background-size:contain; position: absolute; left: 5.5px; top: 5.5px; overflow: hidden; pointer-events: none; }
					
					
					.bdy_snd_cmpg .ec_lst ._opt{ cursor: pointer; }
					.bdy_snd_cmpg .ec_lst ._opt h3{ font-size: 14px !important; font-family: Economica !important; width: 100%; padding: 0; margin: 5px 0 0 0 !important; border: 0 !important; color: #565252 !important; font-weight: 300 !important; }
					.bdy_snd_cmpg .ec_lst ._opt:not(.mre):hover ._bx figure{ border-color:var(--main-bg-color);  }
					
					
					.bdy_snd_cmpg .ec_lst ._opt ._bx figure._non img{ background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>ec_broken.svg); background-color: #bfc3c5; background-size: 50% auto; opacity: 0.2; }
					
					.bdy_snd_cmpg .ec_lst ._opt ._bx figure ._dtl{ width: 30px; height: 30px; background-color: white; position: absolute; bottom: -100px; right: 0; border-radius:200px; -moz-border-radius:200px; -webkit-border-radius:200px; background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>ls_detail.svg); background-repeat: no-repeat; background-position: center center; background-size: 60% auto; border: 2px solid #adaaaa; opacity: 0; pointer-events: none; }
					.bdy_snd_cmpg .ec_lst ._opt:hover ._bx figure ._dtl{ opacity: 1; pointer-events: all; bottom: 0; right: 0; }
					.bdy_snd_cmpg .ec_lst ._opt ._bx figure ._dtl:hover{ background-size: 50% auto; border-color:var(--main-bg-color); }
					.bdy_snd_cmpg .ec_lst ._opt._slct ._bx figure{ border-color:var(--main-bg-color); }
					
					.bdy_snd_cmpg .ec_lst ._opt ._bx h2{ font-weight: 400; margin:0; padding: 0; border: none; text-align: center; font-family: Work Sans; font-size: 14px; text-overflow: ellipsis; margin-top: -10px; font-size: 12px; width: 80%; margin-left: auto; margin-right: auto; background-color:var(--second-bg-color); color: white; border-radius:10px; -moz-border-radius:10px; -webkit-border-radius:10px; font-size: 11px; padding: 5px 7px; white-space: nowrap; text-overflow: ellipsis; }
					
					
					.bdy_snd_cmpg .ec_lst ._opt.tt ._bx{ background-color: #e5e8e8; height: 150px; }
					.bdy_snd_cmpg .ec_lst ._opt ._bx h1.__tt{ border: none; line-height: 20px; padding-top: 30px; }
					.bdy_snd_cmpg .ec_lst ._opt ._bx h1.__tt span{ font-size: 17px; color: #8c9595;  }
					
					
					.bdy_snd_cmpg .ec_lst ._opt.mre{ height: 100px; }
					.bdy_snd_cmpg .ec_lst ._opt.mre ._bx figure{ margin-top: 30px; width: 50px; height: 50px; background-repeat: no-repeat; background-position: center center; background-size:contain; margin-left: auto; margin-right: auto; border-radius:200px; -moz-border-radius:200px; -webkit-border-radius:200px; background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>ec_more.svg); background-size: 70% auto; opacity: 0.2; border: 2px solid #b0aeae; }
					.bdy_snd_cmpg .ec_lst ._opt.mre:hover ._bx figure{ background-size: 50% auto; opacity: 1 !important; }
					
					
					
					.bdy_snd_cmpg .ec_lst ._opt.sch{ height: 100px; }
					.bdy_snd_cmpg .ec_lst ._opt.sch ._bx figure{ margin-top: 30px; width: 50px; height: 50px; background-repeat: no-repeat; background-position: center center; background-size:contain; margin-left: auto; margin-right: auto; border-radius:200px; -moz-border-radius:200px; -webkit-border-radius:200px; background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>ec_sch.svg); background-size: 70% auto; opacity: 0.2; border: 2px solid #b0aeae; position: relative; }
					.bdy_snd_cmpg .ec_lst ._opt.sch:hover ._bx figure{ background-size: 50% auto; opacity: 1 !important; }
					

					
					.bdy_snd_cmpg .ec_lst ._opt.empty{ border:none !important; height: 120px; }
					.bdy_snd_cmpg .ec_lst ._opt.empty ._bx figure{ border: none !important; margin-top: 40px; width: 40px; height: 40px; opacity: 0.2; }
					
					
					.bdy_snd_cmpg ._tmpl_opt{ display: flex; margin-top: 10px; }
					.bdy_snd_cmpg ._tmpl_opt ._c{ vertical-align: top; display: inline-block; width: 25%; text-align: right; white-space: nowrap; }
					.bdy_snd_cmpg ._tmpl_opt ._c h3{ border: none !important; padding-left: 20px; padding-bottom: 5px; margin-top: 4px !important; vertical-align: top; }
					.bdy_snd_cmpg ._tmpl_opt ._c .__slc_ok{ border: none !important; margin-right: 50px; }
					.bdy_snd_cmpg ._tmpl_opt ._c .__slc_ok .__slc{ width: 40% !important; }
					
					
					.bdy_snd_cmpg .ec_all_bx{ position: relative !important; }
					.bdy_snd_cmpg .__pushm._ec_ldd .ec_all_bx{ background-color: #f2f4f5; border-radius: 0px 0px 10px 10px; -moz-border-radius: 0px 0px 10px 10px; -webkit-border-radius: 0px 0px 10px 10px; height: 30px; margin-bottom: 20px; }
					.bdy_snd_cmpg .__pushm._ec_ldd .ec_all_bx ._dwn_crsl{ display: block !important; background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>ec_cmpg_dwn.svg); background-repeat: no-repeat; background-position: center bottom 5px; background-size: 20px auto; width: 100%; height: 25px; position: absolute; bottom: 2px; left: 0; background-color: transparent;border: none; }
					.bdy_snd_cmpg .__pushm._ec_ldd .ec_all_bx ._dwn_crsl:hover{ background-size: 15px auto; }
					.bdy_snd_cmpg .__pushm._ec_ldd .ec_all_bx .ec_lst{ opacity: 0; top: -2000px; pointer-events: none; }
					
					
					
					.bdy_snd_cmpg .ln_1 .___txar label{ display: none; }
					
					
					
					
						
					.bdy_snd_cmpg .shw_crtng{ width: 100%; height:1px; pointer-events: none; display: inline-block; background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>new_ldng.svg); background-repeat:no-repeat; background-position: center top; background-size: auto 90%; opacity:0; position: relative; margin-left: auto; margin-right: auto; margin-top: -50px; position: absolute; }
					.bdy_snd_cmpg .shw_crtng.on{ opacity: 1; animation: _blnk 0.8s cubic-bezier(.5, 0, 1, 1) infinite alternate; height: 200px; margin-top: 50px; position: relative; }
					.bdy_snd_cmpg .shw_crtng.on h2{ display: block; }
					
					.bdy_snd_cmpg .shw_crtng h2{ font-family: Economica; text-transform: uppercase; font-size: 20px; font-weight: 300; color: #000; width: 100%; margin: 0; padding: 0; text-align: center; position: absolute; left: 0; bottom: -30px; display: none; }
					.bdy_snd_cmpg .shw_crtng h2 span{ font-size: 16px; display: block; width: 100%; color: #9d9fa0; }
					
					
					
					.Cvr_Snd ._est_nm{ font-weight: 700; }
	
					
				</style>
								
								
	    <?php } ?>
  </div>

</div>
<?php $CntWb .= JV_Blq().JV_HtmlEd($__jqte); ?>
<?php } ?>
<?php } ?>

