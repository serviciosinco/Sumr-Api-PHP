<?php 
	$__Rdrct = DMN_OAUTH.'instagram/?_scl='.$___scl_dt_g->d->enc.'&_us='.SISUS_ENC.'&_cl='.DB_CL_ENC;
	
	
	$__InsC = 'https://api.instagram.com/oauth/authorize/?client_id=' . _INSTAGRAM_CLIENT_ID . 
			  '&redirect_uri=' . urlencode($__Rdrct) .
			  '&response_type=code&scope=basic+comments+likes';	
	
	
	$config = [
			'site_url' => 'https://api.instagram.com/oauth/access_token',
			'grant_type' => 'authorization_code+comments+likes',
			'redirect_uri' => $__Rdrct, 
	];
	
	$___ins_ls = GtSclLs([ 'us'=>SISUS_ID, 'cl'=>DB_CL_ENC, 'rds'=>346 ]);
	$___ins_selected = $___ins_ls->scl->{$_scl};
	
	if($___ins_ls->tot > 0){
		
		foreach($___ins_selected as $k=>$v){
			
			if($v->id != NULL){
				if($v->enc != NULL){
	?>
		<div id="stup_prf_<?php echo $v->enc; ?>">
				<?php echo h2(Spn('','','_o _anm','background-image:url('.$v->scl->attr->profile_picture.');').$v->scl->attr->full_name); ?>
				<grid class="_flx" width="100%">
				
					<?php 
						
						$__SclBd = new CRM_Thrd();
						$__SclBd->__t = 'acc';
						$__SclBd->acc_scl = $v->id;
						$__SclBd->scl_rds_id = $v->scl->i;
						$__SclBd->acc_id = $v->scl->id;
						$__SclBd->acc_nm = $v->nm;
						$__SclBd->acc_img = $v->scl->attr->profile_picture;
						$__SclBd->acc_tkn = $v->scl->attr->access_token;	
						$__Prc = $__SclBd->In();
							
					?>

				</grid>	
		</div>			
	<?php	
				}
			}		
		}
	}
	
	
	if($___ins_ls->tot == 0){
		$AddFrst = h1(TX_THLNKACC);
		$CntWb .= " SUMR_Main.scl.f.stup.e();";
	}
	
	$CntWb .= "	
		SUMR_Main.scl.f.top({ h:'".$AddFrst."<button id=\"SclIns_Cnct\" onclick=\"Pop_Instagram();\" class=\"btn_stup ins\">".TX_LNKACC."</button>' });
	";	

	
	$CntJV .= " SUMR_Main.scl.f.SclS({ t:'scl', v:".json_encode($___ins_ls->scl)." }); "; 
	
	
	$CntJV .= " 
	
	
		SUMR_Main.scl.f.acc.bld();
	
		
		function Pop_Instagram(){
			
			var pop_url;
			document.domain = '".DMN_S."';
			window['pop_ins'] = window.open('{$__InsC}', 'CRM - Instagram Login', 'width=400,height=500,scrollbars=no');
			
			var popupTick = setInterval(function() {

		      	if (pop_ins.closed) {

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
