<?php 
	$__Rdrct = DMN_OAUTH.'linkedin/?_scl='.$___scl_dt_g->d->enc.'&_us='.SISUS_ENC.'&_cl='.DB_CL_ENC;
	
	
	$__InsC = 'https://www.linkedin.com/oauth/v2/authorization?response_type=code'.
				'&client_id='._LINKEDIN_CLIENT_ID.
				'&redirect_uri='.urlencode($__Rdrct);	

	$CntWb .= "	
		SUMR_Main.scl.f.Scl_Top({ h:'<button id=\"SclIns_Cnct\" onclick=\"Pop_LinkedIn();\" class=\"btn_stup lnkin\">".TX_LNKACC."</button>' });
	";	
	
	$___lnkin_ls = GtSclLs([ 'us'=>SISUS_ID, 'cl'=>DB_CL_ENC, 'rds'=>427 ]);
	$___lnkin_selected = $___lnkin_ls->scl->{$_scl};

	
	if($___lnkin_ls->tot > 0){
		foreach($___lnkin_selected as $k=>$v){	
			if($v->id != NULL){
	?>			
	
				<?php if($v->enc != NULL){ ?>
	
					<div id="stup_prf_<?php echo $v->enc; ?>">
							<?php echo h2(Spn('','','_o _anm','background-image:url('.$v->scl->attr->profile_picture.');').$v->nm); ?>
							<grid class="_flx" width="100%">
							
								<?php 
									
									$__SclBd = new CRM_Thrd();
									$__SclBd->__t = 'acc';
									$__SclBd->acc_scl = $v->id;
									$__SclBd->scl_rds_id = $v->scl->i;
									$__SclBd->acc_id = $v->scl->id;
									$__SclBd->acc_nm = $v->nm;
									$__SclBd->acc_img = $v->scl->attr->profile_picture;
									$__Prc = $__SclBd->In();
										
								?>
			
							</grid>	
					</div>			
	
				<?php } ?>
				
				
				<?php $__emp_ls = Lnkin_Emp(['tkn'=>$v->scl->attr->access_token]); ?>
				
				<?php 
					
					foreach($__emp_ls->values as $k2=>$v2){
						$__emp_dt = Lnkin_EmpDt(['id'=>$v2->id, 'tkn'=>$v->scl->attr->access_token]);
								
						if($__emp_dt->id != NULL){
							
							$__SclBd = new CRM_Thrd();
							$__SclBd->__t = 'acc';
							$__SclBd->acc_scl = $v->id;
							$__SclBd->scl_rds_id = $__scl;
							$__SclBd->acc_id = $__emp_dt->id;
							$__SclBd->acc_nm = $__emp_dt->name;
							$__SclBd->acc_img = $__emp_dt->logoUrl;	
							$__Prc = $__SclBd->In();			
		
						} 
					} 
				
				?>
				
			<?php } ?>		
		<?php } ?>
	<?php } ?>	


<?php 
	
	$CntJV .= " SUMR_Main.scl.f.set({t:'scl', v:".json_encode($___lnkin_ls->scl)."}); "; 
	
	
	$CntJV .= " 
	
	
		SUMR_Main.scl.f.acc.bld();
	
		
		function Pop_LinkedIn(){
			
			var pop_url;
			document.domain = '".DMN_S."';
			window['pop_lkin'] = window.open('{$__InsC}', 'sumr-pop', 'width=400,height=600,scrollbars=no');

			var popupTick = setInterval(function() {

		      	if (pop_lkin.closed) {
			  		
			        if(!isN(pop_url)){ 
				        
				        var url = pop_url;
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
					
					if(!isN(pop_lkin.document.URL)){ pop_url = pop_lkin.document.URL; }
						
				}
				
				
		    }, 500);
		
		    return false;
		    
		}

	";
	
?>
