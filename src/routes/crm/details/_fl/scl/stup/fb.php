<?php
	
	$CntWb .= "	SUMR_Main.scl.f.top({ h:'<button id=\"SclFb_Cnct\" onclick=\"Pop_Facebook();\" class=\"btn_stup fb\">".TX_LNKACC."</button>' }); ";	

	$___prf_ls = GtSclLs([ 'us'=>SISUS_ID, 'cl'=>DB_CL_ENC, 'rds'=>_CId('ID_SCLRDS_FB') ]);
	$___scl_selected = $___prf_ls->scl->{$_scl};
	 
	if($___prf_ls->tot > 0){
		
		foreach($___scl_selected as $k=>$v){
			 
			$__acc_get = GtSclAccLs([ 'rds'=>_CId('ID_SCLRDS_FB'), 'scl'=>$v->id, 'us'=>SISUS_ID/*, 'cl'=>DB_CL_ENC*/ ]);
			$__accounts = $__acc_get->network->ls->{$_scl}->acc->ls;
			$__scl = $v->scl->i;
			
			if(!isN($v->enc)){ 

?>
				<div id="stup_prf_<?php echo $v->enc; ?>">
					<?php echo h2(Spn('','','_o _anm','background-image:url('.$v->scl->attr->img.');').$v->nm); ?>
					<grid class="_flx" width="100%">
<?php	
			
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

	}else{

		echo h1('No accounts fetch');

	}
?>	
<?php 
	
	//$___prf_ls = GtSclLs([ 'us'=>SISUS_ID, 'cl'=>DB_CL_ENC ]);
	
	//$CntJV .= " SUMR_Main.scl.f.set({ t:'scl', v:".json_encode($___prf_ls->scl)." }); "; 
	
	$CntJV .= "
		
		SUMR_Main.scl.f.acc.bld();
		
		
		function Pop_Facebook(){
			
			var pop_url;
			document.domain = '".DMN_S."';
			window['pop_fb'] = window.open('".DMN_OAUTH.'facebook/?_scl='.$___scl_dt_g->d->enc.'&_us='.SISUS_ENC.'&_cl='.DB_CL_ENC."&Rd='+Math.random(), 'CRM - Facebook Login', 'width=400,height=500,scrollbars=no');
			
			var popupTick = setInterval(function() {

		      	if (pop_fb.closed) {
			  		
			        if(!isN(pop_url)){ 
				        
				        var url = pop_url;
				        var tkn = _get({ u:url, n:'oauth_token' });
				        var vrf = _get({ u:url, n:'oauth_verifier' });
				        var scc = _get({ u:url, n:'success' });						

						if(!isN(scc) && scc == 'ok'){
					    	swal('".TX_CNCTSTBLD."', '".TX_APSCONFI."', 'success');
					    	pop_url=null;
					    }
						
					}else{
						
						SUMR_Main.log.f({ m:'Not all the vars' });
						
					}
					
					clearInterval(popupTick);
					 
				}else{
					
					if(!isN(pop_fb.document.URL)){ pop_url = pop_fb.document.URL; }
						
				}
				
		    }, 500);
		
		    return false;
		    
		}
		
		
		SUMR_Main.scl.f.dom_rbld();
		
	";
	
?>