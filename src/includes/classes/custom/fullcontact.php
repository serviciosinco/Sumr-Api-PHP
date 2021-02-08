<?php

class CRM_Fll {
		
	function __construct() { 

		$this->_aws = new API_CRM_Aws();
		
	}
	
	
	public function _url($u=NULL){
		$c = parse_url($u);
		return $c['host'];
	}
	
	
	public function _eml($e=NULL){
		$sanitized_a = filter_var($e, FILTER_SANITIZE_EMAIL);
		if (filter_var($sanitized_a, FILTER_VALIDATE_EMAIL)) {
		    return $sanitized_a;
		}
	}
	
	public function _gti($p=NULL){
		$this->{$p['t']} = $p['id'];
		$this->{$p['set']} = $p['set_v'];
	}
	
	public function _chk($p=NULL){
		
		global $__cnx;
		
		$Vl['e'] = 'no';

		if($p['t']=='org'){ 
			$_bd=TB_FLL_ORG; $_bd_i='fllorg_web'; $url_id = 'http://'.$p['id'];
			if (filter_var($url_id, FILTER_VALIDATE_URL)){ $__v=$this->_url($url_id); }
			$_setid='dmn';
		}else{ 
			$_bd=TB_FLL_CNT; $_bd_i='fllcnt_eml'; 
			$__v=$this->_eml($p['id']);
			$_setid='eml';
		}
		
		if(!isN($_bd) && !isN($__v)){
			
			$query_DtRg = sprintf("SELECT * FROM "._BdStr(DBM).$_bd." WHERE ".$_bd_i."=%s LIMIT 1", GtSQLVlStr(strtolower($__v), "text"));
			$DtRg = $__cnx->_prc($query_DtRg); 
			
			if($DtRg){
				
				$row_DtRg = $DtRg->fetch_assoc(); 
				$Tot_DtRg = $DtRg->num_rows;   
				
				if($Tot_DtRg > 0){
					
					$Vl['e'] = 'ok';
					$Vl['t'] = $p['t'];
					$Vl['id'] = $row_DtRg['id_fll'.$p['t']];
					$Vl['vrfd'] = mBln( $row_DtRg['fll'.$p['t'].'_vrfd'] );
					$Vl['est'] = mBln( $row_DtRg['fll'.$p['t'].'_est'] );
	
					if($p['t']!='org'){ 
						$Vl['nm']['fll'] = ctjTx($row_DtRg['fllcnt_nm_fll'],'in');
						$Vl['nm']['gvn'] = ctjTx($row_DtRg['fllcnt_nm_gvn'],'in');
						$Vl['nm']['fmly'] = ctjTx($row_DtRg['fllcnt_nm_fmly'],'in');
					}
					
					if($p['t']!='org'){
						$this->_upd_cnt(['t'=>'nm', 'nm'=>$p['nm'], 'id'=>$this->cnt]); 
					}
					
					$this->_gti(['t'=>$p['t'], 'id'=>$Vl['id'], 'set'=>$_setid, 'set_v'=>$__v ]);
					
				}else{
					
					$svebase = $this->_sve_base(['t'=>$p['t'], 'id'=>$p['id'] ]);
					
					if($svebase->e=='ok'){ 
						$Vl['e'] = 'ok'; 
						$Vl['id'] = $svebase->id; 
						$this->_gti(['t'=>$p['t'], 'id'=>$Vl['id'], 'set'=>$_setid, 'set_v'=>$__v ]);
					}
				}
			
			}else{

				$Vl['w'] = $__cnx->c_p->error; 

			}
			
			$__cnx->_clsr($Ls);
		
		}else{

			if(isN($_bd)){ $Vl['w'][] = '$_bd is empty '.$_bd; } 
			if(isN($__v)){ $Vl['w'][] = '$__v is empty '.$__v.' from '.$p['id']; } 

		}
			
		return _jEnc($Vl);
	
	}
	
	public function _sve_base($p=NULL){
		
		global $__cnx;
		
		if($p['id'] != NULL){
			
			if($p['t']=='org'){ 
				$insertSQL = sprintf("INSERT INTO "._BdStr(DBM).TB_FLL_ORG." (fllorg_web) VALUES (%s)",
									   GtSQLVlStr(trim(strtolower( $this->_url($p['id']) )), "text"));
			}else{ 
				$insertSQL = sprintf("INSERT INTO "._BdStr(DBM).TB_FLL_CNT." (fllcnt_enc, fllcnt_eml, fllcnt_nm_fll) VALUES ("._BdStr(DBM)."f_Enc(), %s, %s)",
									   GtSQLVlStr(trim(strtolower( $this->_eml($p['id']) )), "text"),
									   GtSQLVlStr(trim(strtolower( $this->_eml($p['nm']['fll']) )), "text"));
			}
			
			$Result = $__cnx->_prc($insertSQL);
			
			if($Result){ $_v['e'] = 'ok'; $_v['id'] = $__cnx->c_p->insert_id; }else{ $_v['e'] = 'no';}
		}
		
		return _jEnc($_v);
	}
		
		
	public function sve_P($p=NULL){
		
		global $__cnx;
		
		if($p['t'] == 'pht'){
			
			if($this->cnt != NULL){
				$insertSQL = sprintf("INSERT INTO "._BdStr(DBM).TB_FLL_CNT_PHT." (fllcntpht_cnt, fllcntpht_type, fllcntpht_typeid, fllcntpht_typename, fllcntpht_url, fllcntpht_p) VALUES (%s,%s,%s,%s,%s,%s)",
									   GtSQLVlStr(ctjTx($this->cnt,'out'), "text"),
									   GtSQLVlStr(ctjTx($p['pht_type'],'out'), "text"),
									   GtSQLVlStr(ctjTx($p['pht_typeid'],'out'), "text"),
									   GtSQLVlStr(ctjTx($p['pht_typename'],'out'), "text"),
									   GtSQLVlStr(ctjTx($p['pht_url'],'out'), "text"),
									   GtSQLVlStr(ctjTx($p['pht_p'],'out'), "text"));
			}elseif($this->org != NULL){
				$insertSQL = sprintf("INSERT INTO "._BdStr(DBM).TB_FLL_ORG_PHT." (fllorgpht_org, fllorgpht_label, fllorgpht_url) VALUES (%s,%s,%s)",
									   GtSQLVlStr(ctjTx($this->org,'out'), "text"),
									   GtSQLVlStr(ctjTx($p['pht_label'],'out'), "text"),
									   GtSQLVlStr(ctjTx($p['pht_url'],'out'), "text"));
			}
								   	
		}elseif($p['t'] == 'org'){
			
			$insertSQL = sprintf("INSERT INTO "._BdStr(DBM).TB_FLL_CNT_ORG." (fllcntorg_cnt, fllcntorg_name, fllcntorg_startdate, fllcntorg_title, fllcntorg_c) VALUES (%s,%s,%s,%s,%s)",
								   GtSQLVlStr(ctjTx($this->cnt,'out'), "text"),
								   GtSQLVlStr(ctjTx($p['org_name'],'out'), "text"),
								   GtSQLVlStr(ctjTx($p['org_startdate'],'out'), "text"),
								   GtSQLVlStr(ctjTx($p['org_title'],'out'), "text"),
								   GtSQLVlStr(ctjTx($p['org_c'],'out'), "text"));	
								   
		}elseif($p['t'] == 'kyw'){
			
			if($this->org != NULL){
				
				$insertSQL = sprintf("INSERT INTO "._BdStr(DBM).TB_FLL_ORG_KYW." (fllorgkyw_org, fllorgkyw_value) VALUES (%s,%s)",
									   GtSQLVlStr($this->org, "int"),
									   GtSQLVlStr(ctjTx($p['kyw_value'],'out'), "text"));	
			
			}
								   
		}elseif($p['t'] == 'scl'){
			
			if($this->cnt != NULL){ $_prfx = 'cnt'; }
			elseif($this->org != NULL){ $_prfx = 'org'; }
			
			$insertSQL = sprintf("INSERT INTO ".DBM.".fll_{$_prfx}_scl (fll{$_prfx}scl_{$_prfx}, fll{$_prfx}scl_type, fll{$_prfx}scl_typeid, fll{$_prfx}scl_typename, fll{$_prfx}scl_url, fll{$_prfx}scl_username, fll{$_prfx}scl_bio, fll{$_prfx}scl_id, fll{$_prfx}scl_followers, fll{$_prfx}scl_following) VALUES (%s,%s,%s,%s,%s,%s,%s,%s,%s,%s)",
								   GtSQLVlStr(ctjTx($p[$_prfx],'out'), "text"),
								   GtSQLVlStr(ctjTx($p['scl_type'],'out'), "text"),
								   GtSQLVlStr(ctjTx($p['scl_typeid'],'out'), "text"),
								   GtSQLVlStr(ctjTx($p['scl_typename'],'out'), "text"),
								   GtSQLVlStr(ctjTx($p['scl_url'],'out'), "text"),
								   GtSQLVlStr(ctjTx($p['scl_username'],'out'), "text"),
								   GtSQLVlStr(ctjTx($p['scl_bio'],'out'), "text"),
								   GtSQLVlStr(ctjTx($p['scl_id'],'out'), "text"),
								   GtSQLVlStr(ctjTx($p['scl_followers'],'out'), "text"),
								   GtSQLVlStr(ctjTx($p['scl_following'],'out'), "text"));
								   	
		}elseif($p['t'] == 'tpc'){
			
			$insertSQL = sprintf("INSERT INTO "._BdStr(DBM).TB_FLL_CNT_TPC." (fllcnttpc_cnt, fllcnttpc_provider, fllcnttpc_value) VALUES (%s,%s,%s)",
								   GtSQLVlStr($this->cnt, "text"),
								   GtSQLVlStr(ctjTx($p['tpc_provider'],'out'), "text"),
								   GtSQLVlStr(ctjTx($p['tpc_value'],'out'), "text"));	
		}
		
		$Result = $__cnx->_prc($insertSQL);
		
		if($Result){ $_v['e'] = 'ok'; }else{ $_v['e'] = 'no';}
		
		return _jEnc($_v);
		
		
	}
	
	public function sve_R($p=NULL){
		
		global $__cnx;
		
		if($p['id'] != NULL){
			
			$insertSQL = sprintf("INSERT INTO "._BdStr(DBM).TB_FLL_CNT_RQS." (fllcntrqs_id) VALUES (%s)",
									   GtSQLVlStr($p['id'], "text"));
			
			$Result = $__cnx->_qry($insertSQL);
			
			if($Result){ $_v['e'] = 'ok'; }else{ $_v['e'] = 'no';}
		}
		
		$_r = _jEnc($_v);
		
		return $_r;
	}
	
	public function sve($p=NULL){
		
		$Vl['e'] = 'no';

		if(!isN($this->c_eml) || !isN($this->c_dmn)){
			
			if(!isN($this->c_eml)){	
				if(!isN($this->c_eml_nm)){ $this->c_eml_nm = _jEnc($this->c_eml_nm); } 
				$chk = $this->_chk(['t'=>'cnt', 'id'=>$this->c_eml, 'nm'=>$this->c_eml_nm ]);
			}elseif(!isN($this->c_dmn)){
				$chk = $this->_chk(['t'=>'org', 'id'=>$this->c_dmn]);
			}
			
			if($chk->e =='ok' && $chk->vrfd == 'ok' && $chk->est == 'no'){  
	
				$__lb_indx = ['logo'=>'1', 'twitter'=>'2', 'linkedin'=>'3', 'facebook'=>'4'];
				$__sze_img = ['800'=>['s'=>800],
					'600'=>['s'=>600, 'l'=>'_bg_'],
					'400'=>['s'=>400, 'l'=>'_md_'],
					'200'=>['s'=>200, 'l'=>'_sm_'],
					'100'=>['s'=>100],
					'50'=>['s'=>50]
				];
		
				if(($this->eml != NULL && $this->cnt != NULL)){
					$_o = $this->eml; $_o_t = 'cnt';
				}elseif($this->dmn != NULL && $this->org != NULL){
					$_o = $this->dmn; $_o_t = 'org';
				}
				
				if($_o!=''){	
						
					try {
		
						if($_o_t == 'cnt'){
							$Fl = new API_FullContact();
							$Fl->email = $_o;
							$Fl_r = $Fl->Get();
							$result = $Fl_r->r;
						}elseif($_o_t == 'org'){
							$Fl = new API_FullContact();
							$Fl->domain = $_o;
							$Fl_r = $Fl->Get();
							$result = $Fl_r->r;
						}
						
						
						$this->sve_R(['id'=>$result->requestId]);

						$Vl['RqI'] = $result->requestId; 
		
						if($_o_t == 'cnt'){
		
							if(count($result->photos) > 0){
								
								$__has_info = 'ok';
								
								foreach ($result->photos as &$_photo) {
									$this->sve_P([
												't'=>'pht',
												'cnt'=>$this->cnt,
												'pht_type'=>$_photo->type,
												'pht_typeid'=>$_photo->typeId,
												'pht_typename'=>$this->cnt,
												'pht_url'=>$_photo->url,
												'pht_p'=>$_photo->isPrimary
											]);
		
								}
							}
		
						}elseif($_o_t == 'org'){
							
							$_p_id = $this->{$_o_t};
							
							if($_o_t == 'org'){
								$_fld = DIR_FLE_FLL;
								$_fld_th = DIR_FLE_FLL_TH;
							}
	
							if(count($result->organization->images) > 0){
								foreach ($result->organization->images as &$_photo) {
									$this->sve_P([
													't'=>'pht',
													$_o_t=>$_p_id,
													'pht_label'=>$_photo->label,
													'pht_url'=>$_photo->url
												]);
		
									$_logo[ $__lb_indx[$_photo->label] ] = $_photo->url;
								}
							}
		
							if(!is_array($_logo) && $_logo != NULL){ $___image = $_logo; }
							elseif($_logo[1] != NULL){ $___image = $_logo[1]; }
							elseif($_logo[2] != NULL){ $___image = $_logo[2]; }
							elseif($_logo[3] != NULL){ $___image = $_logo[3]; }
							elseif($_logo[4] != NULL){ $___image = $_logo[4]; }
							elseif($result->logo != NULL){ $___image = $result->logo; }
		
							if($___image != ''){
		
								$__nw_nm = $_o_t.'_'.$_p_id;
								$__nw_ext = '.jpg';
								$__nw_fld = dirname( dirname( dirname( dirname(__FILE__) ) ) ) .'/'. $_fld;
								$__nw_fld_th = dirname( dirname( dirname( dirname(__FILE__) ) ) ) . '/' . $_fld_th;
								
								$image_nr = new Imagick($___image);
								$image_nr->setImageBackgroundColor('#ffffff');
								$image_nr = $image_nr->flattenImages();
		
								$image_nr->setImageFormat ("jpeg");
								$image_nr->setImageCompression(imagick::COMPRESSION_JPEG);
								$image_nr->setImageCompressionQuality(0.9);
								$image_nr->thumbnailImage(1920, 0);
								$image_nr->writeImage($__nw_fld.$__nw_nm.$__nw_ext);
								
								$_sve = $this->_aws->_s3_put([ 'b'=>'fle', 
																'fle'=>_TmpFixDir($__nw_fld.$__nw_nm.$__nw_ext), 
																'src'=>$__nw_fld.$__nw_nm.$__nw_ext, 
																'ctp'=>mime_content_type($__nw_fld.$__nw_nm.$__nw_ext) 
															]);
								
		
								foreach($__sze_img as $_k => $_v){
									
									if($_v['l'] != NULL){
										
										$image_nr->thumbnailImage($_v['s'], 0);
										$image_nr->writeImage($__nw_fld.$_v['l'].$__nw_nm.$__nw_ext);
										
										$_sve = $this->_aws->_s3_put([ 'b'=>'fle', 
																'fle'=>_TmpFixDir($__nw_fld.$_v['l'].$__nw_nm.$__nw_ext), 
																'src'=>$__nw_fld.$_v['l'].$__nw_nm.$__nw_ext, 
																'ctp'=>mime_content_type($__nw_fld.$_v['l'].$__nw_nm.$__nw_ext) 
															]);
															
									}
									
									$image_nr->thumbnailImage($_v['s'], 0);
									$image_nr->writeImage($__nw_fld_th.$__nw_nm.'x'.$_v['s'].'.jpg');
									
									$_sve = $this->_aws->_s3_put([ 'b'=>'fle', 
																'fle'=>_TmpFixDir($__nw_fld_th.$__nw_nm.'x'.$_v['s'].'.jpg'), 
																'src'=>$__nw_fld_th.$__nw_nm.'x'.$_v['s'].'.jpg', 
																'ctp'=>mime_content_type($__nw_fld_th.$__nw_nm.'x'.$_v['s'].'.jpg') 
															]);
															
								}
								
								$image_nr->setImageColorSpace(imagick::COLORSPACE_GRAY);
								$image_nr->writeImage($__nw_fld.'gry_'.$__nw_nm.$__nw_ext);
								
								$_sve = $this->_aws->_s3_put([ 'b'=>'fle', 
																'fle'=>_TmpFixDir($__nw_fld.'gry_'.$__nw_nm.$__nw_ext), 
																'src'=>$__nw_fld.'gry_'.$__nw_nm.$__nw_ext, 
																'ctp'=>mime_content_type($__nw_fld.'gry_'.$__nw_nm.$__nw_ext) 
															]);

								$image_nr->clear();$image_nr->destroy();
								$_imgsve = 'ok';
							}
							
							$result->organization->images[0]->url;
							if(count($result->organization->keywords)>0){
								
								$__has_info = 'ok';
								
								foreach ($result->organization->keywords as $_kyw){
									$this->sve_P([
													't'=>'kyw',
													$_o_t=>$_p_id,
													'kyw_value'=>$_kyw
												]);
		
								}
							}
		
						}
		
						if($_o_t == 'cnt'){
							if(count($result->organizations) > 0){
								
								$__has_info = 'ok';
								
								foreach ($result->organizations as &$_organization) {
									$this->sve_P([
													't'=>'org',
													'cnt'=>$this->cnt,
													'org_name'=>$_organization->name,
													'org_startdate'=>$_organization->startDate,
													'org_title'=>$_organization->title,
													'org_c'=>$_organization->current
												]);
								}
							}
						}
		
						if($_o_t == 'cnt' || $_o_t == 'org'){
							if(count($result->socialProfiles) > 0){
								
								$__has_info = 'ok';
								
								foreach ($result->socialProfiles as &$_scl) {
		
									$f['t']='scl';
									$f[$_o_t]=$this->{$_o_t};
									$f['scl_type']=$_scl->type;
									$f['scl_typeid']=$_scl->typeId;
									$f['scl_typename']=$_scl->typeName;
									$f['scl_url']=$_scl->url;
									$f['scl_username']=$_scl->username;
									$f['scl_bio']=$_scl->bio;
									$f['scl_id']=$_scl->id;
									$f['scl_followers']=$_scl->followers;
									$f['scl_following']=$_scl->following;
		
		
									$this->sve_P($f);
								}
							}
						}
		
		
						if(count($result->digitalFootprint->topics) > 0){
							
							$__has_info = 'ok';
							
							foreach ($result->digitalFootprint->topics as &$_tpc) {
								$this->sve_P([
												't'=>'tpc',
												'cnt'=>$this->cnt,
												'tpc_provider'=>$_tpc->provider,
												'tpc_value'=>$_tpc->value
											]);
							}
						}
		
						if($_o_t == 'org'){
							
							$__has_info = 'ok';
							
							$this->org_upd(
										[									 
											'id'=>$this->org,
											'eply'=>$result->organization->approxEmployees,
											'fnd'=>$result->organization->founded,
											'img'=>$_imgsve
										]
									);
						}
						
						
						if($_o_t == 'cnt' && $__has_info == 'ok'){
							$this->_upd_cnt(['t'=>'est', 'est'=>1, 'id'=>$this->cnt]);
						}elseif($_o_t == 'org' && $__has_info == 'ok'){
							$this->_upd_org(['t'=>'est', 'est'=>1, 'id'=>$this->org]);
						}
		
					} catch (Exception $e) {
						$Vl['w'] = 'Excepción capturada: '.$e->getMessage()."\n";
					}
					
				}
	
			}else{

				$Vl['tmp']['chk'] = $chk->e;
				$Vl['tmp']['vrfd'] = $chk->vrfd;
				$Vl['tmp']['est'] = $chk->est;
				$Vl['tmp']['all'] = $chk;

			}
			
			if($this->c_eml != NULL){
				$chk = $this->_chk(['t'=>'cnt', 'id'=>$this->c_eml, 'nm'=>$this->c_eml_nm ]);
				if($chk->e=='ok'){ $Vl['eml']['id'] = $chk->id; }
			}elseif($this->c_dmn != NULL){
				$chk = $this->_chk(['t'=>'org', 'id'=>$this->c_dmn]);
				if($chk->e=='ok'){ $Vl['dmn']['id'] = $chk->id; }
			}
			
		}else{
			
			$Vl['e'] = 'no';
			$Vl['w'] = 'No data key';
	
		}
	
		return _jEnc($Vl);

	}
	
	
	
	public function UPDCnt_Fll($p=NULL){
		
		global $__cnx;
		
		if($p['id']!=NULL){
			
			$updateSQL = sprintf("UPDATE cnt SET cnt_fll_fa=%s WHERE id_cnt=%s",
					   GtSQLVlStr(SIS_F_D, "date"),
					   GtSQLVlStr($p['id'], "int"));
			
			$Result_UPD = $__cnx->_prc($updateSQL);
			
			$rsp['e'] = 'ok';
			
		}else{
			$rsp['e'] = 'no';
			$rsp['w'] = $__cnx->c_p->error;
			_ErrSis(['p'=>$insertSQL, 'd'=>$__cnx->c_p->error]);
		}

		return _jEnc($rsp);		
	}
	
	
	
	public function org_upd($p=NULL){
		
		global $__cnx;
		
		if($p['id']!=NULL){
			
			if($p['img'] == 'ok'){ $__img = sprintf(', fllorg_logo=%s ', GtSQLVlStr('org_'.$p['id'].'.jpg', "text") );  }
			
			$updateSQL = sprintf("UPDATE "._BdStr(DBM).TB_FLL_ORG." SET fllorg_eply=%s, fllorg_fnd=%s {$__img} WHERE id_fllorg=%s",
					   GtSQLVlStr($p['eply'], "date"),
					   GtSQLVlStr($p['fnd'], "date"),
					   GtSQLVlStr($p['id'], "int"));

			$Result_UPD = $__cnx->_prc($updateSQL);
			
			$rsp['e'] = 'ok';
		}else{
			$rsp['e'] = 'no';
			$rsp['w'] = $__cnx->c_p->error;
			_ErrSis(['p'=>$insertSQL, 'd'=>$__cnx->c_p->error]);
		}
		
		$rtrn = json_decode(json_encode($rsp)); 
		if(!isN($rtrn)){ return($rtrn); }		
	}	
	
	
	public function _upd_cnt($p=NULL){
		
		global $__cnx;
		
		$rsp['e'] = 'no';
		
		if($p['id']!=NULL){
			
			if($p['t'] == 'chk_f'){
				
				$updateSQL = sprintf("UPDATE "._BdStr(DBM).TB_FLL_CNT." SET fllcnt_chk_f=%s WHERE id_fllcnt=%s LIMIT 1",
					   GtSQLVlStr(SIS_F2.' '.SIS_H2, "date"),
					   GtSQLVlStr($p['id'], "int"));
					   
			}elseif($p['t'] == 'est'){
				
				$updateSQL = sprintf("UPDATE "._BdStr(DBM).TB_FLL_CNT." SET fllcnt_est=%s WHERE id_fllcnt=%s LIMIT 1",
					   GtSQLVlStr($p['est'], "int"),
					   GtSQLVlStr($p['id'], "int"));
					   
			}elseif($p['t'] == 'nm'){

				$updateSQL = sprintf("UPDATE "._BdStr(DBM).TB_FLL_CNT." SET fllcnt_nm_fll=%s WHERE id_fllcnt=%s LIMIT 1",
					   GtSQLVlStr($p['nm']->fll, "text"),
					   GtSQLVlStr($p['id'], "int"));
					   
			}else{
				
				$updateSQL = sprintf("UPDATE "._BdStr(DBM).TB_FLL_CNT." SET fllcnt_vrfd=%s, fllcnt_vrfd_usr=%s, fllcnt_vrfd_dmn=%s, fllcnt_vrfd_c_sntx=%s, fllcnt_vrfd_c_dlvr=%s, fllcnt_vrfd_c_ctch=%s WHERE id_fllcnt=%s LIMIT 1",
					   GtSQLVlStr($p['vrfd'], "int"),
					   GtSQLVlStr($p['vrfd_usr'], "text"),
					   GtSQLVlStr($p['vrfd_dmn'], "text"),
					   GtSQLVlStr($p['vrfd_c_sntx'], "int"),
					   GtSQLVlStr($p['vrfd_c_dlvr'], "int"),
					   GtSQLVlStr($p['vrfd_c_ctch'], "int"),
					   GtSQLVlStr($p['id'], "int"));
					   	
			}	   
					   
			$Result_UPD = $__cnx->_prc($updateSQL);
			
			if($Result_UPD){
				$rsp['e'] = 'ok';
			}else{
				$rsp['w'] = $__cnx->c_p->error;
				_ErrSis(['p'=>$insertSQL, 'd'=>$__cnx->c_p->error]);
			}
			
		}else{
			
			$rsp['w'] = 'No trae ID';
			
		}
		
		
		$rtrn = _jEnc($rsp); 
		if(!isN($rtrn)){ return($rtrn); }	
	}
	
	
	public function _upd_org($p=NULL){
		
		global $__cnx;
		
		if($p['id']!=NULL){
			
			if($p['t'] == 'chk_f'){
				
				$updateSQL = sprintf("UPDATE "._BdStr(DBM).TB_FLL_ORG." SET fllorg_chk_f=%s WHERE id_fllorg=%s",
					   GtSQLVlStr(SIS_F2.' '.SIS_H2, "date"),
					   GtSQLVlStr($p['id'], "int"));
					   
			}elseif($p['t'] == 'est'){
				
				$updateSQL = sprintf("UPDATE "._BdStr(DBM).TB_FLL_ORG." SET fllorg_est=%s WHERE id_fllorg=%s",
					   GtSQLVlStr($p['est'], "int"),
					   GtSQLVlStr($p['id'], "int"));
					   
			}else{
				
				$updateSQL = sprintf("UPDATE "._BdStr(DBM).TB_FLL_ORG." SET fllorg_vrfd=%s WHERE id_fllorg=%s",
					   GtSQLVlStr($p['vrfd'], "int"),
					   GtSQLVlStr($p['id'], "int"));
					   	
			}	   
					   
			$Result_UPD = $__cnx->_prc($updateSQL);
			$rsp['e'] = 'ok';
			
		}else{
			
			$rsp['e'] = 'no';
			$rsp['w'] = $__cnx->c_p->error;
			_ErrSis(['p'=>$insertSQL, 'd'=>$__cnx->c_p->error]);
		
		}
		
		$rtrn = json_decode(json_encode($rsp)); 
		if(!isN($rtrn)){ return($rtrn); }	
	}
	
			
		
}




	function GtFll_Scl_Dt($_p=NULL){
		
		global $__cnx;
		
		if(($_p['id']!='')){
			
			if($_p['tp'] == 'org'){ 
				$__t='org'; $__k='web'; $__bd = _BdStr(DBM).TB_FLL_ORG; 
			}else{ 
				$__t='cnt'; $__k='eml'; $__bd = _BdStr(DBM).TB_FLL_CNT;
			}
			
			if($_p['t'] == 'eml'){ $__f = 'fll'.$__t.'_'.$__k; $__ft = 'text'; }else{ $__f = 'fll'.$__t.'scl_'.$__t; $__ft = 'int'; }
			 
			 
			if(is_array($_p['id'])){
				foreach($_p['id'] as $__shc_id_k=>$__shc_id_v){
					$_schf_a [] = sprintf($__f."=%s", GtSQLVlStr($__shc_id_v, $__ft));
				}
				$_schf = ' AND ('.implode(' || ', $_schf_a).')';
			}else{
				$_schf = sprintf($__f." = %s", GtSQLVlStr($_p['id'], $__ft));
			}
			
			 
			$query_DtRg = sprintf("SELECT * FROM ".DBM.".fll_{$__t}_scl
											INNER JOIN ".$__bd." ON fll{$__t}scl_{$__t} = id_fll{$__t}
								   WHERE id_fll{$__t} != '' {$_schf}");			 	   
			
			$DtRg = $__cnx->_qry($query_DtRg);
			
			if($DtRg){
				
				$row_DtRg = $DtRg->fetch_assoc(); 
				$Tot_DtRg = $DtRg->num_rows;
	
				if($Tot_DtRg > 0){ 
					$_i=1;
					do{
						$id = $row_DtRg['id_fll'.$__t.'scl'];	
						$Vl['ls'][$id]['id'] = $row_DtRg['id_fll'.$__t.'scl'];
						$Vl['ls'][$id]['type'] = ctjTx($row_DtRg['fll'.$__t.'scl_type'],'in');
						$Vl['ls'][$id]['type_id'] = ctjTx($row_DtRg['fll'.$__t.'scl_typeid'],'in');
						$Vl['ls'][$id]['type_name'] = ctjTx($row_DtRg['fll'.$__t.'scl_typename'],'in');
						$Vl['ls'][$id]['url'] = ctjTx($row_DtRg['fll'.$__t.'scl_url'],'in');
						$Vl['ls'][$id]['username'] = ctjTx($row_DtRg['fll'.$__t.'scl_username'],'in');
						$Vl['ls'][$id]['bio'] = ctjTx($row_DtRg['fll'.$__t.'scl_bio'],'in');
						$Vl['ls'][$id]['id'] = ctjTx($row_DtRg['fll'.$__t.'scl_id'],'in');
						$Vl['ls'][$id]['followers'] = ctjTx($row_DtRg['fll'.$__t.'scl_followers'],'in');
						$Vl['ls'][$id]['following'] = ctjTx($row_DtRg['fll'.$__t.'scl_following'],'in');
						
						//Formato Especial
						$_r_li .= li( Spn( '<a href="'.$row_DtRg['fll'.$__t.'scl_url'].'" target="blank" title="'.$row_DtRg['fll'.$__t.'scl_bio'].'" style="color:#fff;">'.ctjTx($row_DtRg['fll'.$__t.'scl_typename'],'in').'</a>','', '__e', 'font-weight:bolder; background-color:#000; color:#fff;')  );
						
						$_i++;
					} while ($row_DtRg = $DtRg->fetch_assoc());
				}
				
				
				if(!isN($_r_li)){ $Vl['html'] = ul($_r_li, '_anm ls_tag'); }
				
				$rtrn = _jEnc($Vl);
				
			
			}
			
			if(isN($_p['cnx'])){ $__cnx->_clsr($DtRg); }		
			return($rtrn);
		}
	}
	
	
	
	function GtFll_Tpc_Dt($_p=NULL){
		
		global $__cnx;
		
		if(($_p['id']!='')){
			
			if($_p['t'] == 'eml'){ $__f = 'fllcnt_eml'; $__ft = 'text'; }else{ $__f = 'fllcnttpc_cnt'; $__ft = 'int'; }

			if(is_array($_p['id'])){
				foreach($_p['id'] as $__shc_id_k=>$__shc_id_v){
					$_schf_a [] = sprintf($__f."=%s", GtSQLVlStr($__shc_id_v, $__ft));
				}
				$_schf = ' AND ('.implode(' || ', $_schf_a).')';
			}else{
				$_schf = sprintf($__f." = %s", GtSQLVlStr($_p['id'], $__ft));
			}
			
			
			$query_DtRg = sprintf('SELECT * FROM '._BdStr(DBM).TB_FLL_CNT_TPC.'
											INNER JOIN '._BdStr(DBM).TB_FLL_CNT.' ON fllcnttpc_cnt = id_fllcnt
								   WHERE id_fllcnt != "" '.$_schf);	
								   				   
			$DtRg = $__cnx->_qry($query_DtRg); 
			
			if($DtRg){
				
				$row_DtRg = $DtRg->fetch_assoc(); $Tot_DtRg = $DtRg->num_rows;
				
				if($Tot_DtRg > 0){
					$_i=1;
					
					do{
						$id = $row_DtRg['id_fllcnttpc'];	
						$Vl['ls'][$id]['id'] = $row_DtRg['id_fllcnttpc'];
						$Vl['ls'][$id]['provider'] = ctjTx($row_DtRg['fllcnttpc_provider'],'in');
						$Vl['ls'][$id]['value'] = ctjTx($row_DtRg['fllcnttpc_value'],'in');
						
						//Formato Especial
						$_r_li .= li( Spn(ctjTx($row_DtRg['fllcnttpc_value'],'in'),'', '__e', 'font-weight:bolder; background-color:#69008C; color:#fff;')  );
						
						$_i++;
					} while ($row_DtRg = $DtRg->fetch_assoc());
				}
	
				if(!isN($_r_li)){ $Vl['html'] = ul($_r_li, '_anm ls_tag'); }
			
			}
			
			
			$rtrn = _jEnc($Vl);
			
			if(isN($_p['cnx'])){ $__cnx->_clsr($DtRg); }
			
			return($rtrn);
		}
	}
	
	
	
	function GtFll_Kyw_Dt($_p=NULL){
		
		global $__cnx;
		
		if(($_p['id']!='')){
			
			if($_p['t'] == 'dmn'){ $__f = 'fllorg_web'; $__ft = 'text'; }else{ $__f = 'fllorgkyw_org'; $__ft = 'int'; }

			if(is_array($_p['id'])){
				foreach($_p['id'] as $__shc_id_k=>$__shc_id_v){
					$_schf_a [] = sprintf($__f."=%s", GtSQLVlStr($__shc_id_v, $__ft));
				}
				$_schf = ' AND ('.implode(' || ', $_schf_a).')';
			}else{
				$_schf = sprintf($__f." = %s", GtSQLVlStr($_p['id'], $__ft));
			}
			
			
			$query_DtRg = sprintf('SELECT * FROM '._BdStr(DBM).TB_FLL_ORG_KYW.'
											INNER JOIN '._BdStr(DBM).TB_FLL_ORG.' ON fllorgkyw_org = id_fllorg
								   WHERE id_fllorg != "" '.$_schf);		
			$DtRg = $__cnx->_qry($query_DtRg); 	
			
			if($DtRg){
				
				$row_DtRg = $DtRg->fetch_assoc(); 
				$Tot_DtRg = $DtRg->num_rows;
			
				if($Tot_DtRg > 0){
					$_i=1;
					
					do{
						$id = $row_DtRg['id_fllorgkyw'];	
						$Vl['ls'][$id]['id'] = $row_DtRg['id_fllorgkyw'];
						$Vl['ls'][$id]['value'] = ctjTx($row_DtRg['fllorgkyw_value'],'in');
						
						//Formato Especial
						$_r_li .= li( Spn(ctjTx($row_DtRg['fllorgkyw_value'],'in'),'', '__e', 'font-weight:bolder; background-color:#69008C; color:#fff;')  );
						
						$_i++;
					} while ($row_DtRg = $DtRg->fetch_assoc());
				}
				
				
				if(!isN($_r_li)){ $Vl['html'] = ul($_r_li, '_anm ls_tag'); }
			
			}else{
				
				echo $__cnx->c_r->error;
				
			}
			
			
			$rtrn = _jEnc($Vl);
			
			if(isN($_p['cnx'])){ $__cnx->_clsr($DtRg); }
					
			return($rtrn);
		}
	}
	
	
	function GtFll_Pht_Dt($_p=NULL){
		
		global $__cnx;
		
		if(!isN($_p['id'])){ 

			if($_p['t'] == 'eml'){ $__f = 'fllcnt_eml'; $__ft = 'text'; }else{ $__f = 'fllcntpht_cnt'; $__ft = 'int'; }
			
			if($_p['tp'] == 'org'){ 
				$__t='org'; $__bd = TB_FLL_ORG; $__bd_r = TB_FLL_ORG_PHT; 
			}else{ 
				$__t='cnt'; $__bd = TB_FLL_CNT; $__bd_r = TB_FLL_CNT_PHT; 
			}
			
			
			if(is_array($_p['id'])){
				foreach($_p['id'] as $__shc_id_k=>$__shc_id_v){
					$_schf_a [] = sprintf($__f."=%s", GtSQLVlStr($__shc_id_v, $__ft));
				}
				$_schf = ' AND ('.implode(' || ', $_schf_a).')';
			}else{
				$_schf = sprintf($__f." = %s", GtSQLVlStr($_p['id'], $__ft));
			}

			$query_DtRg = sprintf("SELECT * FROM "._BdStr(DBM).$__bd_r."
											INNER JOIN "._BdStr(DBM).$__bd." ON fll{$__t}pht_{$__t} = id_fll{$__t}
								   WHERE id_fll{$__t} != '' ".$_schf." ORDER BY id_fll{$__t}pht ASC");			   
			$DtRg = $__cnx->_qry($query_DtRg); $row_DtRg = $DtRg->fetch_assoc(); $Tot_DtRg = $DtRg->num_rows;	
			
			if($Tot_DtRg > 0){

				$_i=1;
				
				do{
					
					$id = $row_DtRg['id_fll'.$__t.'pht'];	
					$Vl[$id]['id'] = $row_DtRg['id_fll'.$__t.'pht'];
					$Vl[$id]['type'] = ctjTx($row_DtRg['fll'.$__t.'pht_type'],'in');
					$Vl[$id]['typeid'] = ctjTx($row_DtRg['fll'.$__t.'pht_typeid'],'in');
					$Vl[$id]['typename'] = ctjTx($row_DtRg['fll'.$__t.'pht_typename'],'in');
					$Vl[$id]['url'] = ctjTx($row_DtRg['fll'.$__t.'pht_url'],'in');
					$Vl[$id]['p'] = ctjTx($row_DtRg['fll'.$__t.'pht_p'],'in');
					$Vl[$id]['label'] = ctjTx($row_DtRg['fll'.$__t.'pht_p'],'in');
					$Vl[$id]['fi'] = ctjTx($row_DtRg['fll'.$__t.'pht_fi'],'in');
					$_i++;
					
				} while ($row_DtRg = $DtRg->fetch_assoc());
				
			}
			
			if(isN($_p['cnx'])){ $__cnx->_clsr($DtRg); }	
			
			return _jEnc($Vl);
		}
	}
	
	
	
	function GtFll_Org_Dt($_p=NULL){
		
		global $__cnx;
		
		if(($_p['id']!='')){
			
			if($_p['t'] == 'eml'){ $__f = 'fllcnt_eml'; $__ft = 'text'; }else{ $__f = 'fllcntorg_cnt'; $__ft = 'int'; }

			if(is_array($_p['id'])){
				foreach($_p['id'] as $__shc_id_k=>$__shc_id_v){
					$_schf_a [] = sprintf($__f."=%s", GtSQLVlStr($__shc_id_v, $__ft));
				}
				$_schf = ' AND ('.implode(' || ', $_schf_a).')';
			}else{
				$_schf = sprintf($__f." = %s", GtSQLVlStr($_p['id'], $__ft));
			}
			
			
			$query_DtRg = sprintf('SELECT * FROM '._BdStr(DBM).TB_FLL_CNT_ORG.'
											INNER JOIN '._BdStr(DBM).TB_FLL_CNT.' ON fllcntorg_cnt = id_fllcnt
								   WHERE id_fllcnt != "" '.$_schf);
								   		   
			$DtRg = $__cnx->_qry($query_DtRg); 
			
			if($DtRg){
				
				$row_DtRg = $DtRg->fetch_assoc(); 
				$Tot_DtRg = $DtRg->num_rows;	
				
				if($Tot_DtRg > 0){
					$_i=1;
					do{
						$id = $row_DtRg['id_fllcntorg'];	
						$Vl['ls'][$id]['id'] = $row_DtRg['id_fllcntorg'];
						$Vl['ls'][$id]['name'] = ctjTx($row_DtRg['fllcntorg_name'],'in');
						$Vl['ls'][$id]['startDate'] = ctjTx($row_DtRg['fllcntorg_startDate'],'in');
						$Vl['ls'][$id]['title'] = ctjTx($row_DtRg['fllcntorg_title'],'in');
						$Vl['ls'][$id]['c'] = ctjTx($row_DtRg['fllcntorg_c'],'in');
						
						//Formato Especial
						$_r_li .= li( Spn(ctjTx($row_DtRg['fllcntorg_name'],'in'),'', '__e', 'font-weight:bolder; background-color:#000; color:#fff;')  );
						
						$_i++;
					} while ($row_DtRg = $DtRg->fetch_assoc());
				}
				
				if(!isN($_r_li)){ $Vl['html'] = ul($_r_li, '_anm ls_tag'); }
			
			}
			
			$rtrn = _jEnc($Vl);
			
			if(isN($_p['cnx'])){ $__cnx->_clsr($DtRg); }		
			return($rtrn);
		}
	}
	
	
	function Gt_FllCnt($p=NULL){
		
		if(!isN($p['bd'])){ $_bd=$p['bd']; }else{ $_bd=''; }
		
		if($p['t']=='org'){ 
			$_prfx = 'org'; 
		}else{ 
			$_prfx = 'cnt'; 
			$_emls = GtCntEmlLs([ 'i'=>$p['id'], 'r'=>'c', 'bd'=>$_bd ]);
			$_id = explode(',',$_emls);
		}

		$Vl['pht'] = GtFll_Pht_Dt([ 'tp'=>$_prfx, 't'=>'eml', 'id'=>$_id, 'f'=>$p['f'] ]);
		$Vl['org'] = GtFll_Org_Dt([ 'tp'=>$_prfx, 't'=>'eml', 'id'=>$_id, 'f'=>$p['f'] ]);
		$Vl['scl'] = GtFll_Scl_Dt([ 'tp'=>$_prfx, 't'=>'eml', 'id'=>$_id, 'f'=>$p['f'] ]);
		$Vl['tpc'] = GtFll_Tpc_Dt([ 'tp'=>$_prfx, 't'=>'eml', 'id'=>$_id, 'f'=>$p['f'] ]);
		$Vl['kyw'] = GtFll_Kyw_Dt([ 'tp'=>$_prfx, 't'=>'dmn', 'id'=>$_id, 'f'=>$p['f'] ]);
		
		
		
		return(_jEnc($Vl));
	}

	
	
	
?>