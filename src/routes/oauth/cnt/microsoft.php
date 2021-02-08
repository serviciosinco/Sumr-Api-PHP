<?php 
	
	if(!isN($_SESSION['oauth_cl'])){ $__cl_get = $_SESSION['oauth_cl']; }else{ $__cl_get = $__cl;  }
	if(!isN($__cl_get)){ $GtClDt = GtClDt($__cl_get, 'enc'); }
						
	$__mic_oauth_code = Php_Ls_Cln($_GET['code']);
	$__mic_succcess = Php_Ls_Cln($_GET['success']);
	
	$__Mic = new CRM_Microsoft();
	$__Thrd = new CRM_Thrd();
	
		
	if($__scc == 'ok'){
		
		if(!isN($_SESSION['oauth']['id'])){
			$CntJV .= 'setTimeout(function(){ this.close(); }, 2000);';
			$CntJV .= 'window.opener.postMessage({ "type":"login", "method":"oauth2", "id":"'.$_SESSION['oauth']['id'].'" }, "*");';
			unset($_SESSION);
		}else{
			$_rdrct_w = 'ok';
			$_rdrct_w_m = 'no_idr';
		}
		
	}elseif(!isN($__mic_oauth_code)){
		
		for($try=0; $try<5; $try++){
			$__Tkn = $__Mic->_Tkn([ 'code'=>$__mic_oauth_code ]);
			$data = json_decode($__Tkn); 
			if(!isN($data->access_token)){ break; }
		}

		if(!isN($data->access_token)){	
					
			if(!isN($_SESSION['oauth_us'])){ $__us = GtUsDt($_SESSION['oauth_us'], 'enc'); }
			if(!isN($_SESSION['oauth_eml'])){ $__eml = GtEmlDt([ 'id'=>$_SESSION['oauth_eml'], 't'=>'enc' ]); }
			if(!isN($_SESSION['oauth_cl'])){ $__cl = GtClDt($_SESSION['oauth_cl'], 'enc'); }

			$__Mic->access_token = $data->access_token;
			$__prfl = json_decode( $__Mic->_Rqu([ 't'=>'me' ]), true); 
		
			if(!isN($__prfl['displayName'])){
				
				if(!isN($_SESSION['oauth']['login']) && $_SESSION['oauth']['login'] == 'ok'){

					$__eml_o = explode('@', trim($__prfl['mail'])); 
					$__cl_dmn = GtClDmnLs([ 'id'=>$__cl->id ]); 
					
					$__us = GtUsDt($__prfl['mail'], 'usr');

					if(!isN($__us->id)){

						if($__cl_dmn->tot > 0 && !isN($__eml_o[1])){

							foreach($__cl_dmn->main->ls as $_dmn_k=>$_dmn_v){
								if($_dmn_v->url == $__eml_o[1]){ 
									$_dmn_allw='ok';
								}
							}

							if($_dmn_allw != 'ok'){
								foreach($__cl_dmn->sbd as $_dmn_k=>$_dmn_v){
									if($_dmn_v->url == $__eml_o[1]){ 
										$_dmn_allw='ok';
									}
								}
							}

							if($_dmn_allw == 'ok'){

								$___ses = new CRM_SES();
								$___ses_sve = 	$___ses->__oauth([
													'cid'=>$__prfl['id'],
													'us'=>$__us->id,
													'cl'=>$__cl->id,
													'tp'=>_CId('ID_APITHRD_MIC'),
													'data'=>json_encode($__prfl)
												]);
								
								if($___ses_sve->e == 'ok'){
									$_SESSION['oauth']['id'] = $___ses_sve->enc;
									header('Location: ' . DMN_OAUTH.'microsoft/?success=ok&_r='.Gn_Rnd(10));
								}

							}else{
								$_rdrct_w = 'ok';
								$_rdrct_w_m = 'no_dmn_allw';
							}

						}else{
							
							$_rdrct_w = 'ok';
							$_rdrct_w_m = 'no_dmn';

						}

					}else{

						$_rdrct_w = 'ok';
						$_rdrct_w_m = 'no_us';

					}

				}elseif($_SESSION['oauth_tp']){ 
					
					$__emltp = __LsDt([ 'k'=>'sis_eml', 'tp'=>'enc', 'id'=>$_SESSION['oauth_tp'] ]);				
					
					$__Eml = new CRM_Eml();
					$__Eml->__t = 'eml';
			        $__Eml->eml_eml = $__prfl['mail'];
			        $__Eml->eml_nm = $__prfl['displayName'];
			        $__Eml->eml_tp = $__emltp->d->id;
			        $__Eml->eml_us = $__us->id;
			        $__Eml->eml_cl = $__cl->id;
			        $__Prc = $__Eml->In();
					
					if($__Prc->e == 'ok'){	
						$__eml = GtEmlDt([ 'id'=>$__Prc->id ]);
					}

					if(!isN($__eml->id)){
				
						$__Eml->eml_id_upd = $__eml->id;
						$__Eml->eml_attr = json_decode($__Tkn, true); 
						$__Eml->eml_attr = array_merge($__Thrd->eml_attr, $__prfl);	
						$__Prc = $__Eml->Eml_Attr(['tp'=>'eml']);
					
					}
					
					if($__Prc->e == 'ok'){
						header('Location: ' . DMN_OAUTH.'microsoft/?success=ok&_eml='.$__eml->eml.'&_r='.Gn_Rnd(10));
					}else{
						echo 'Error Request, close it please';	
					}

				}

			}else{

				$_rdrct_w = 'ok';
				$_rdrct_w_m = 'no_api_data';

			}
			
		}else{
			
			$_rdrct_w = 'ok';
			$_rdrct_w_m = 'no_tkn';

		}
		
	}else{

		if(!isN($__err)){
			
			if($__err_m == 'no_us'){
				$__err_tt = 'Problemas con tu usuario';
				$__err_dsc = 'La aplicación no ha sido configurada<br>para darte acceso aún.';
			}

		}else{

			if(!isN($__cl)){ $_SESSION['oauth_cl'] = $__cl;  }
			if(!isN($__us)){ $_SESSION['oauth_us'] = $__us; }
			if(!isN($__eml)){ $_SESSION['oauth_eml'] = $__eml; } 
			if(!isN($__eml)){ $_SESSION['oauth_tp'] = $__tp; }

			$_SESSION['oauth_frw']++;
			
			if($_SESSION['oauth_frw'] > 2){ 
				$_rdrct_w = 'ok';
				$_rdrct_w_m = 'no_cod';
			}

			if(!isN($__Mic->url->scope)){
				header('Location: ' .$__Mic->url->scope);
				die();
			}

		}
		
	}
	
	if($_rdrct_w == 'ok'){
		header('Location: '.DMN_OAUTH.'microsoft/?_error=ok&_error_m='.$_rdrct_w_m.'&_r='.Gn_Rnd(20) );
		die();
	}
	
?>