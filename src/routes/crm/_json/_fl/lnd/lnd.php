<?php 
	
	//@ini_set('display_errors', true); 
	//error_reporting(E_ALL & ~E_NOTICE /*&& ~E_WARNING*/);

	
	try{ 
		
		$_tt = Php_Ls_Cln($_POST['_tt']);
		$_t = Php_Ls_Cln($_POST['t']);
		$_t2 = Php_Ls_Cln($_POST['t2']);
		if($_POST['data']['_enc']){ $_enc = Php_Ls_Cln($_POST['data']['_enc']); } else{ $_enc = Php_Ls_Cln($_POST['_enc']); }
		if($_POST['data']['_tp']){ $_tp = Php_Ls_Cln($_POST['data']['_tp']); } else{ $_tp = Php_Ls_Cln($_POST['_tp']); }
		
		if($_tp != ''){ $__LndIn = new CRM_Lnd(); $__LndIn->post = $_POST; $__LndIn->db = $_tp; }
		
		
		if($_tp == '_dsh_start'){
			
			$GtLndLs = GtLndLs();
			$rsp = $GtLndLs;
				
		}elseif($_tp == '_new_lnd'){
			
			$__LndIn->lnd_tt = $_tt;
			
			if(trim($__LndIn->lnd_tt) != ''){ $PrcDt = $__LndIn->In_Lnd(); }
			 
			if($PrcDt->e == 'ok'){
				
				$GtLndLs = GtLndLs();
				
				$rsp['e'] = $PrcDt->e;
				$rsp['enc'] = $__LndIn->rnd_enc;
				$rsp['tt'] = $_tt;
				$rsp['dt'] = $GtLndLs->ls;
				
			}else{
				
				throw new Exception((ChckSESS_superadm()) ? "- ".$PrcDt->w : "");
				
			}
			
		}elseif($_tp == '_mod_lnd'){
			
			$__LndIn->lnd_tt = $_tt;
			$__LndIn->lnd_enc = $_enc;
			
			if(trim($__LndIn->lnd_tt) != ''){ $PrcDt = $__LndIn->Mod_Lnd(); }
			
			if($PrcDt->e == 'ok'){
				
				$GtLndLs = GtLndLs();
				
				$rsp['e'] = $PrcDt->e;
				$rsp['enc'] = $__LndIn->rnd_enc;
				$rsp['tt'] = $_tt;
				$rsp['dt'] = $GtLndLs->ls;
				
			}else{
				throw new Exception((ChckSESS_superadm()) ? "- ".$PrcDt->w : "");
			}
			
		}elseif($_tp == '_ls_mdl_tp'){
			
			$MdlTpLs = GtMdlTpLs( ["tp"=>$_enc] ); 
			if($MdlTpLs->e == 'ok'){
				
				$rsp['e'] = $MdlTpLs->e;
				$rsp['ls'] = $MdlTpLs;
				
			}else{
				$rsp['e'] = 'no';
			}
			
		}elseif($_tp == '_ls_mdl'){
			
			$MdlLs = GtMdlLs( ["tp"=>$_enc] );
			if($MdlLs->e == 'ok'){
				
				$rsp['e'] = $MdlLs->e;
				$rsp['ls'] = $MdlLs;
				
			}else{
				$rsp['e'] = 'no';
			}
			
		}elseif($_tp == '_lnd_us_tab_ls'){
			
			$LndUsTab = GtLndTabUsLs( ["lnd"=>$_enc, "lnd_tp"=>"enc"] );
			
			if($LndUsTab->tot > 0){
				$rsp['e'] = 'ok';
				$rsp['tab']['ls'] = $LndUsTab->ls;	
			}
			
			$rsp['d'] = GtLndDt([ 'id'=>$_enc, 't'=>'enc'] );
			//$rsp['html'] = LsLndTp('_slc_tp_ls','id_mdlstp', '', TX_TP,'','','',[ 'sis'=>'no', 'enc'=>$_enc ]);
			$rsp['js'] = JQ_Ls('_slc_tp_ls',"Tipo");
						 			
						 			
		}elseif($_tp == '_lnd_us_tab_slc'){
			
			$__LndIn->lndtabus_enc = $_enc;
			$__LndIn->lndtabus_lnd = $_POST['_lnd'];
			$__LndIn->tp = 'slc';
			
			if(trim($__LndIn->lndtabus_enc) != ''){ $PrcDt = $__LndIn->Mod_Lnd_Tab_Us(); }
			
			if($PrcDt->e == 'ok'){
				
				$rsp['mdl_enc'] = $PrcDt->mdl_enc;
				$rsp['e'] = $PrcDt->e;
				$rsp['enc'] = $_enc;
				
			}else{
				throw new Exception((ChckSESS_superadm()) ? "- ".$PrcDt->w : "");
			}
			
		}elseif($_tp == '_lnd_us_tab_new'){
			
			$__LndIn->lndtabus_mdl = Php_Ls_Cln($_POST['id_mdl']);
			$__LndIn->lndtabus_lnd = Php_Ls_Cln($_POST['lnd_enc']);
			
			$LndUsTabUlt = GtLndTabUsLs( ["lnd"=>$__LndIn->lndtabus_lnd, "lnd_tp"=>"enc"] );
			
			if($LndUsTabUlt->ult > 0 && $LndUsTabUlt->ult!= '' && $LndUsTabUlt->ult != NULL){
				$__LndIn->lndtabus_ord = ($LndUsTabUlt->ult+1);
			}else{
				$__LndIn->lndtabus_ord = 1;
			}
			
			if(!isN(trim($__LndIn->lndtabus_mdl))){ $PrcDt = $__LndIn->In_Lnd_Us_Tab(); }
			
			if($PrcDt->e == 'ok'){
				
				$LndUsTabDt = GtLndTabUsLs( ["lnd"=>$__LndIn->lndtabus_lnd, "lnd_tp"=>"enc", "id"=>$__LndIn->id_lndtabus] );
				
				$rsp['e'] = $PrcDt->e;
				$rsp['enc'] = $__LndIn->rnd_enc;
				$rsp['dt'] = $LndUsTabDt->ls;
				
				if($PrcDt->upd == 'ok'){ $rsp['exst'] = 'ok'; }
				
			}else{
				
				throw new Exception((ChckSESS_superadm()) ? "- ".$PrcDt->w : "");
				
			}
			
		}elseif($_tp == '_lnd_us_tab_eli'){
			
			$__LndIn->lndtabus_lnd = Php_Ls_Cln($_POST['_lnd']);
			$__LndIn->lndtabus_enc = $_enc;
			
			if(!isN($_enc)){ $PrcDt = $__LndIn->Eli_Lnd_Us_Tab(); }
			
			if($PrcDt->e == 'ok'){
				
				$rsp['e'] = $PrcDt->e;
				$rsp['enc'] = $_enc;
				$rsp['ult_enc'] = $__LndIn->ult_enc;
				
			}else{
				
				throw new Exception((ChckSESS_superadm()) ? "- ".$PrcDt->w : "");
				
			}
			
		}elseif($_tp == 'lnd_sgm_sve_tx' || $_tp == 'lnd_sgm_sve_lgo' || $_tp == 'lnd_sgm_sve_img'){
			
			$__LndIn->mdl->id = Php_Ls_Cln($_POST["_mdl"]);
			$__LndIn->sgm->id = Php_Ls_Cln($_POST["_sgm"]);
			$__LndIn->sgm->tp = $_tp;
			$__LndIn->lnd->id = Php_Ls_Cln($_POST["_lnd"]);
			$__LndIn->mdl->t = $__LndIn->sgm->t = $__LndIn->lnd->t = 'enc';
			
			$__LndIn->lndmdlsgm_vle = Php_Ls_Cln($_POST["_sgm_vle"]);
						
			$__Chk = $__LndIn->MdlSgm_Chk();
			
			$rsp['chk'] = $__Chk;
			
			
			if(!isN($__Chk->id)){
				$__LndIn->lndmdlsgm_enc = $__Chk->enc;
				$PrcDt = $__LndIn->MdlSgm_Mod(); 
				$rsp['tp'] = 'mod'; 	
			}else{ 
				$PrcDt = $__LndIn->MdlSgm_In(); 
				$rsp['tp'] = 'new'; 
			}
			
			if($PrcDt->e == 'ok'){
									
				$rsp['e'] = $PrcDt->e;
				
			}else{
				
				throw new Exception((ChckSESS_superadm()) ? "- ".$PrcDt->w : "");
				
			}
			
		}elseif($_tp == 'lnd_sgm_his'){
			
			$LndSgmHisLs = GtLndMdlSgmHisLs([ "fl"=>"AND lndmdlsgmhis_lndmdlsgm IN (SELECT id_lndmdlsgm FROM ".TB_LND_MDL_SGM." WHERE lndmdlsgm_enc = '".$_enc."')" ]);
			if(count($LndSgmHisLs->ls) > 0){
				
				$rsp['e'] = "ok";
				$rsp['dt'] = $LndSgmHisLs->ls;
				
			}
			
		}elseif($_tp == '_ls_img'){
			
			$ImgLs = GtImgLs();
			if($$ImgLs->e == "ok"){
				
				$rsp['e'] = $ImgLs->e;
				$rsp['ls'] = $ImgLs->ls;
				
			}else{
				
				$rsp['e'] = "no";
				
			}
			
		}elseif($_tp == '_lnd_attr_ls'){
			
			$LndSgmAttrLs = GtLndMdlSgmAttrLs( ["sgm"=>$_enc, "sgm_tp"=>"enc"] );
			if($LndSgmAttrLs->e = 'ok'){
				$rsp['e'] = $LndSgmAttrLs->e;
				$rsp['ls'] = $LndSgmAttrLs->ls;
			}else{
				$rsp['e'] = 'no';
			}
			
		}elseif($_tp == '_lnd_attr_add'){
			
			$_enc = Php_Ls_Cln($_POST["_lnd_enc"]);
			
			$__LndIn->lndmdlsgmattr_sgm = Php_Ls_Cln($_POST["_lnd_sgm"]);
			$__LndIn->lndmdlsgmattr_attr = Php_Ls_Cln($_POST["_attr"]);
			$__LndIn->lndmdlsgmattr_vle = Php_Ls_Cln($_POST["_attr_vle"]);
			
			$__scl = __LsDt(['k'=>'tra_col_clr']);
			
			$LndSgmAttrLs = GtLndMdlSgmAttrLs( ["sgm"=>$__LndIn->lndmdlsgmattr_sgm, "sgm_tp"=>"enc", "attr"=>$__LndIn->lndmdlsgmattr_attr] );
			
			if($LndSgmAttrLs->tot > 0){
				$PrcDt = $__LndIn->MdlSgm_Mod_Attr();
			}else{
				$PrcDt = $__LndIn->MdlSgm_In_Attr();
			}
			
			if($PrcDt->e == 'ok'){
				
				$LndUsTab = GtLndTabUsLs( ["lnd"=>$_enc, "lnd_tp"=>"enc"] );
				
				if($LndUsTab->tot > 0){
					$rsp['ls'] = $LndUsTab->ls;	
				}
				
				$rsp['attr'] = $__scl->ls->lnd_attr->{$__LndIn->lndmdlsgmattr_attr}->attr->vl;
				$rsp['tt'] = $__LndIn->lndmdlsgmattr_vle;
				$rsp['e'] = $PrcDt->e;
				
			}else{
				throw new Exception((ChckSESS_superadm()) ? "- ".$PrcDt->w : "");
			}
			
		}elseif($_t == 'lnd' && $_t2 == 'js'){
			
			$__LndIn = new CRM_Lnd();
			
			$_id_lnd = Php_Ls_Cln($_POST['id_lnd']);
			$_id_js = Php_Ls_Cln($_POST['id_js']);
			$_est = Php_Ls_Cln($_POST['est']);
			$_dt = Php_Ls_Cln($_POST['d']);
			$_vl = Php_Ls_Cln($_POST['val']);

			$__LndIn->id_lnd = $_id_lnd;
			$__LndIn->id_js = $_id_js;
			
			
			if($_dt == 'cdn'){
				if($_est == 'in'){
					$PrcDt = $__LndIn->LsLndJs_In();		
				}elseif($_est == 'del'){
					$PrcDt = $__LndIn->LsLndJs_Del();	
				}
				
				if($PrcDt->e == 'ok'){	
					$rsp['e'] = $PrcDt->e;
				}
			}elseif($_dt == 'edt_ord'){
				
				$__LndIn->vl = $_vl;
				$PrcDt = $__LndIn->LsLndJs_Ord();	
				
				if($PrcDt->e == 'ok'){	
					$rsp['e'] = $PrcDt->e;
					$rsp['es'] = $PrcDt->id;
				}else{
					$rsp['e'] = $PrcDt;	
				}	
			}

			$rsp['lnd']['js'] = $__LndIn->LsLndJs();
					
		}elseif($_t == 'lnd' && $_t2 == 'tp'){
			$__LndIn = new CRM_Lnd();
			
			$_id_lnd = Php_Ls_Cln($_POST['id_lnd']);
			$_id_tp = Php_Ls_Cln($_POST['id_tp']);
			$_est = Php_Ls_Cln($_POST['est']);
			$_dt = Php_Ls_Cln($_POST['d']);

			$__LndIn->id_lnd = $_id_lnd;
			$__LndIn->id_tp = $_id_tp;
			
			
			if($_dt == 'tp'){
				if($_est == 'in'){
					$PrcDt = $__LndIn->LsLndTp_In();		
				}elseif($_est == 'del'){
					$PrcDt = $__LndIn->LsLndTp_Del();	
				}
				
				if($PrcDt->e == 'ok'){	
					$rsp['e'] = $PrcDt->e;
				}else{
					$rsp['e'] = $PrcDt;	
				}
			}

			$rsp['lnd']['tp'] = $__LndIn->LsLndTp();
					
		}elseif($_t == 'lnd' && $_t2 == 'font'){
			$__LndIn = new CRM_Lnd();
			
			$_id_lnd = Php_Ls_Cln($_POST['id_lnd']);
			$_id_font = Php_Ls_Cln($_POST['id_font']);
			$_est = Php_Ls_Cln($_POST['est']);
			$_dt = Php_Ls_Cln($_POST['d']);
			$_vl = Php_Ls_Cln($_POST['val']);

			$__LndIn->id_lnd = $_id_lnd;
			$__LndIn->id_font = $_id_font;
			
			
			if($_dt == 'font'){
				if($_est == 'in'){
					$PrcDt = $__LndIn->LsLndFont_In();		
				}elseif($_est == 'del'){
					$PrcDt = $__LndIn->LsLndFont_Del();	
				}
				
				if($PrcDt->e == 'ok'){	
					$rsp['e'] = $PrcDt->e;
				}
			}

			$rsp['lnd']['font'] = $__LndIn->LsLndFont();
					
		}else{
			throw new Exception((ChckSESS_superadm()) ? "-".TX_NEXTP.$_tp : "");
		}
		
	}catch(Exception $e){
		$rsp['e'] = 'no';
		$rsp['w'] = TX_NSPPCSR .$e->getMessage();
	}
	
?>