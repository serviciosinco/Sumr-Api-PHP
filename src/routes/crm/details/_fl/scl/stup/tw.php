<?php 
	
	$__Tw = new CRM_Twitter();
	$__Tw->o_cllbck = DMN_OAUTH.'twitter/?_scl='.$___scl_dt_g->d->enc.'&_us='.SISUS_ENC.'&_cl='.DB_CL_ENC;
	$__TwC = $__Tw->_Auth(array('c'));	
	
	$__SesURL = DMN_OAUTH.'twitter/?redirect_uri='.urlencode($__TwC->url).'&ses_oauth_token='.$__TwC->oauth_token.'&ses_oauth_token_secret='.$__TwC->oauth_token_secret;
	
	$CntWb .= "	SUMR_Main.scl.f.top({ h:'<button id=\"SclTwt_Cnct\" onclick=\"Pop_Twitter();\" class=\"btn_stup tw\">".TX_LNKACC."</button>' }); ";	
	
	$___tw_ls = GtSclLs(['us'=>SISUS_ID, 'cl'=>DB_CL_ENC, 'rds'=>_CId('ID_SCLRDS_TW') ]);
	$___tw_selected = $___tw_ls->scl->{$_scl};

	
	if($___tw_ls->tot > 0){
		
		foreach($___tw_selected as $k=>$v){
			
			
			$__acc_get = GtSclAccLs([ 'rds'=>_CId('ID_SCLRDS_TW'), 'scl'=>$v->id, 'us'=>SISUS_ID/*, 'cl'=>DB_CL_ENC*/ ]);
			$__accounts = $__acc_get->network->ls->{$_scl}->acc->ls;
			$__scl = $v->scl->i;
			

			
			if($v->id != NULL){
				
				//$__TwD = new CRM_Twitter(array('conn_tkn'=>$v->scl->attr->oauth_token, 'conn_tkns'=>$v->scl->attr->oauth_token_secret));
				//$__TwDC = $__TwD->_ChckCrdn();
				
				if($v->enc != NULL){
	?>
					<div id="stup_prf_<?php echo $v->enc; ?>">
							<?php echo h2(Spn('','','_o _anm','background-image:url('.$v->scl->attr->profile_image_url_https.');').$v->scl->attr->screen_name); ?>
							<grid class="_flx" width="100%">
							
								<?php 
									
									/*
									$__SclBd = new CRM_Thrd();
									$__SclBd->__t = 'acc';
									$__SclBd->acc_scl = $v->id;
									$__SclBd->scl_rds_id = $v->scl->i;
									$__SclBd->acc_id = $v->scl->id;
									$__SclBd->acc_nm = $v->nm;
									$__SclBd->acc_img = $v->scl->attr->profile_image_url_https;
									$__SclBd->acc_tkn = $v->scl->attr->oauth_token;	
									$__Prc = $__SclBd->In();
									*/
									
									
									if(!isN($__accounts)){ 
			
										foreach($__accounts as $__accounts_k=>$__accounts_v){
											
											if(!isN($__accounts_v->img)){ $_fgr_sty='background-image:url('.$__accounts_v->img.')'; }else{ $_fgr_sty=''; }
											if($__accounts_v->cest == 'ok'){ $_cls = '_on'; }else{ $_cls = ''; }	
											
											
											echo '	<cell fb-id="'.$__accounts_v->id.'" class="_anm '.$_cls.'" id="stup_prf_acc_'.$__accounts_v->enc.'">
														<figure style="'.$_fgr_sty.'" class="_o"></figure>
														<h3>'.$__accounts_v->nm.'</h3>
														<ul class="acc_opt _anm">
															<li scl-name="'.TX_ADM.'" class="chk_ok _anm" scl-data-opt="ok" scl-data-acc="'.$__accounts_v->enc.'"></li>
															<li scl-name="'.TX_NODMI.'" class="chk_no _anm" scl-data-opt="no" scl-data-acc="'.$__accounts_v->enc.'"></li>
															<li scl-name="'.TX_ESTD.'" class="anly _anm" scl-data-acc="'.$__accounts_v->enc.'"></li>
														</ul>
													</cell>';
															
										}				
									
									}
										
								?>
			
							</grid>	
					</div>			
	<?php	
				}
			}		
		}
	}
?>	


<?php 
	
	$CntJV .= "SUMR_Main.scl.f.set({t:'scl', v:".json_encode($___tw_ls->scl)."}); "; 
	
	
	$CntJV .= " 
	
	
		SUMR_Main.scl.f.acc.bld();
	
		
		function Pop_Twitter(){
			
			var pop_url;
			document.domain = '".DMN_S."';
			window['pop_tw'] = window.open('".$__SesURL."', 'CRM - Twitter Login', 'width=400,height=500,scrollbars=no');
			
			var popupTick = setInterval(function() {

		      	if (pop_tw.closed) {

			        if(!isN(pop_url)){ 
				        
				        var url = pop_url;
				        var tkn = _get({ u:url, n:'oauth_token' });
				        var vrf = _get({ u:url, n:'oauth_verifier' });
				        var scc = _get({ u:url, n:'success' });						

						if (!isN(tkn) && !isN(vrf)) {
							if(!isN(scc) && scc == 'ok'){
						    	swal('".TX_CNCTSTBLD."', '".TX_APSCONFI."', 'success');
						    	pop_url=null;
						    }
						}
						
					}else{
						SUMR_Main.log.f({ m:'Not all the vars' });
					}
					
					clearInterval(popupTick);
					 
				}else{
					
					if(!isN(pop_tw.document.URL)){ pop_url = pop_tw.document.URL; }
						
				}
				
		    }, 500);
		
		    return false;
		    
		}

	";
	
?>
