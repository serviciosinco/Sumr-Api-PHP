<?php 
	
	
	$_org_dt = GtOrgSdsDt([ 'i'=>$___Ls->dt->rw['orgsds_enc'], 't'=>'enc', 'd'=>['org'=>'ok'] ]);
	
	$__prices = __LsDt([ 'k'=>'sis_prc', 'cl'=>DB_CL_ID ]);
	$__mney = new CRM_Mney();
	$__usd = $__mney->Cnvrt_Crrcy();
	$__vlto = $__usd->rsl->quotes->USDCOP;
	
		
	foreach($__prices->ls->sis_prc as $_usr_k=>$_usr_v){
		if(mBln($_usr_v->vl_usr->vl) == 'ok'){
			$_usr_tp = str_replace('usr_', '', $_usr_v->cns);
			$_usr_tp_for[] = $_usr_tp;
		}		
	} 


	foreach($__prices->ls->sis_prc as $_usr_k=>$_usr_v){
		
		if(mBln($_usr_v->vl_usr->vl) == 'ok'){
			$_usr_tp = str_replace('usr_', '', $_usr_v->cns);
			
			foreach($_usr_tp_for as $_usr_tp_for_k=>$_usr_tp_for_v){
				$__urst_tp .= $_usr_tp_for_v.":'".number_format( $_usr_v->{'vl_'.$_usr_tp_for_v}->vl * $__vlto, 0, '.', '')."', ";
			}
					
			$__tp_pln .= " SUMR_Rsllr.plntp.$_usr_v->cns = { 	key:'".$_usr_tp."',
																lmt:{ 
																	max:'".$_usr_v->vl_usr_lmt_max->vl."', 
																	min:'".$_usr_v->vl_usr_lmt_min->vl."' 
																},
																vl:{
																	{$__urst_tp}	
																}
														}; ";
																	
		}		
	} 	
	
			
?>

<div class="quote_detail">
	
	<div class="itms">
		
		<?php 

			$__tabs = [ 
		  				['n'=>'mdl', 't'=>'atmt_mdl', 'l'=>TX_MDLS]
		  			];
		  	
		  	$___Ls->_dvlsfl_all($__tabs,[ 'idb'=>'ok' ]);	 	
		  	
		?>
		<div id="<?php echo $___Ls->tab->id ?>" class="VTabbedPanels mny _bld_quot">
	        <ul class="TabbedPanelsTabGroup">
		    	<?php echo $___Ls->tab->bsc->l ?>
	            <?php echo $___Ls->tab->mdl->l ?>
	        </ul>
	        <div class="TabbedPanelsContentGroup">
		        <div class="TabbedPanelsContent">
			        
					<ul class="bsnss_lne">
						
						<li class="_us">
							<div class="_tt">Usuarios</div>
							<?php echo HTML_inp_tx('usr_qty',TX_USR, 0, FMRQD_NM); ?>
						</li>
						<?php 
						
						foreach($__prices->ls->sis_prc as $_price_k=>$_price_v){
							
							if( (!isN($_price_v->vl_bsc->vl) || mBln($_price_v->bsc->vl) == 'ok') && mBln($_price_v->vl_usr->vl) != 'ok' && $_price_v->cns != 'bse'){
					
								if(mBln($_price_v->vl_unit->vl) == 'ok'){
									
									$___unit = bdiv([
										'cls'=>'bx_qty',
										'c'=>HTML_inp_tx('itm_qty_'.$_price_v->enc, TX_CNTD,'',FMRQD_NM,'','','','','',[ 'attr'=>[ 'data-itm-id'=>$_price_v->enc ] ])
									]);
									$___unit_c = ' _qty ';
									
								}else{
									
									$___unit = '';
									$___unit_c = '';
									
								}
								
								if(mBln($_usr_v->vl_usr->vl) == 'ok'){
									$_usr_tp = str_replace('usr_', '', $_price_v->cns);
								}
								
								foreach($_usr_tp_for as $_usr_tp_for_k=>$_usr_tp_for_v){
									${'__vl_'.$_usr_tp_for_v.'_pss'} = number_format( $_price_v->{'vl_'.$_usr_tp_for_v}->vl*$__vlto, 0, '.', '');
								}
								
								if(mBln($_price_v->bsc->vl) == 'ok'){ $__vl = 1; $__vl_cls = 'on'; $__vl_clsi = ' bsc'; }else{ $__vl = 2; $__vl_cls = ''; $__vl_clsi = ''; }
								
								
								$CntWb .= "
											
									Rsllr_Itm_Html({	
										
										bsc:'".mBln($_price_v->bsc->vl)."',	
										c:'".
										addslashes(
											li(
											
												OLD_HTML_chck(	
															'itm_chk_'.$_price_v->enc, 
															Spn('','','_icn','background-image:url('.$_price_v->img.');').
															Spn($_price_v->tt,'','tt').
															Spn(cnVlrMon('', $__vl_bsc_pss ),'','prc').
															Spn('','','_mre _anm').
															$___unit
															
															, $__vl, 'in', [ 'attr'=>['data-itm-id'=>$_price_v->enc] ]
														),
												$__vl_cls.$__vl_clsi.$___unit_c,
												'',
												'itm_'.$_price_v->enc,
												[
													'attr'=>[
														'data-itm-id'=>$_price_v->enc,
														'data-itm-bsc'=>mBln($_price_v->bsc->vl)
													]
												]
											
											)
										)
										
										."'
										
									});
									"
								;
								
								
								
								$__prc_tp='';
								
								foreach($_usr_tp_for as $_usr_tp_for_k=>$_usr_tp_for_v){
									$__prc_tp .= $_usr_tp_for_v.":'".${'__vl_'.$_usr_tp_for_v.'_pss'}."', ";
								}
									
								$__tp_add .= " 
									_sto['".$_price_v->enc."'] = {
										{$__prc_tp}	
									};
								";	
								
							}
							
							if($_price_v->cns == 'bse'){
								foreach($_usr_tp_for as $_usr_tp_for_k=>$_usr_tp_for_v){	
									$__n = number_format( $_price_v->{'vl_'.$_usr_tp_for_v}->vl*$__vlto, 0, '.', '');
									$__prc_bse .= ''.$_usr_tp_for_v.":{ tt:'"._Cns('TX_PLN_'.strtoupper($_usr_tp_for_v))."', v:'". $__n ."' }, ";	
								}	
								$__tp_pln .= " SUMR_Rsllr.bse = { $__prc_bse }; ";	
							}
								
						
						} 
						 
					
					?>
					</ul>
			 
	        	</div> 
	        	<div class="TabbedPanelsContent">
					  
	        	</div>                                      
	        </div>
	    </div>      
		
	</div>
	
	<div class="total">
		
		<section class="plan_dsc">
			<section class="hdr">
				<div class="org">
					<figure>
						<div class="clogo" style="background-image: url(<?php echo $_org_dt->org->img->th_200; ?>); ">
							<div class="cflag" style="background-image: url(<?php echo $_org_dt->ps->img->th_200; ?>); "></div>	
						</div>	
					</figure>
					<?php echo h1($_org_dt->org->nm.Spn($_org_dt->nm)); ?>
					<?php echo h2($_org_dt->cd->nm); ?>
				</div>
				<div class="nm" id="rsllr_nme"></div>
				<div class="psos" id="rsllr_psos"></div>
			</section>
			<ul id="rsllr_itms" class="rsllr_itms"></ul>	
		</section>	
		
		
	</div>	
</div>
<?php include(GL_RSLLR.'rsllr_quot_detail_js.php'); ?>