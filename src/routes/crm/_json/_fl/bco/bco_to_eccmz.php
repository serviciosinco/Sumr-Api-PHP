<?php 

$__ec_cmz = new API_CRM_ec_Cmz();

if(class_exists('CRM_Cnx')){
	
	ini_set("allow_url_fopen", 1);
	
	$__bco = Php_Ls_Cln($_POST['bco']);
	$__ecdir = Php_Ls_Cln($_POST['ecdir']);
	$__eccmz = Php_Ls_Cln($_POST['eccmz']);
	$__img = Php_Ls_Cln($_POST['img']);
	$__imgmw = Php_Ls_Cln($_POST['maxw']);
	$__imgmh = Php_Ls_Cln($_POST['maxh']);
	
	$_aws = new API_CRM_Aws();
	$_fle = new CRM_Fle();

	if(!isN($_POST['maxd'])){ $__imgmd = Php_Ls_Cln($_POST['maxd']); }else{ $__imgmd = 1; }
	
	$rsp['e'] = 'no';
	
	if(!isN($__eccmz) && !isN($__img)){
		
		$_chk_img = ChkEcCmzImg([ 'eccmz'=>$__eccmz, 'img'=>$__img ]);
		$_ec_cmz = GtEcCmzDt([ 'cmz'=>$__eccmz ]); 
		$_bcodt = GtBcoDt([ 'id'=>$__bco ]);
		
		//$rsp['_bcodt'] = $_bcodt;
		
		$rsp['e'] = 'no';
		
		
		if($_chk_img->r != 'ok'){
			
			$insertSQL = sprintf("INSERT INTO "._BdStr(DBM).TB_EC_CMZ_IMG." (eccmzimg_eccmz, eccmzimg_img) VALUES (%s, %s)",
										                       GtSQLVlStr($__eccmz, "int"),
										                       GtSQLVlStr($__img, "int"));
			$Result = $__cnx->_prc($insertSQL);
			
			if($Result){
				$rsp['in'] = 'ok';
				$rsp['id'] = $__cnx->c_p->insert_id;
			}
			
		}elseif($_chk_img->r == 'ok'){
			
			$rsp['exst'] = 'ok';
			$rsp['id'] = $_chk_img->id;
			
		}
		
		if(!isN($rsp['id']) && !isN($__bco) && ( $rsp['in']=='ok' || $rsp['exst']=='ok' )){
					
			$__url = DIR_BCO_TH;
			
	    	$___ext = '.'.$_bcodt->ext;
	    	
			$___fle = $__url.'bg_bco_'.$__bco.$___ext;
			
			$___fle_n = 'cmz_'.$rsp['id'].$___ext;	
			$___fle_n_o = 'cmz_'.$rsp['id'].'_o'.$___ext;
						
			$___fle_m = dirname(__FILE__, 6).'/'.DIR_FLE_EC_CMZ.$___fle_n;
			$___fle_m_o = dirname(__FILE__, 6).'/'.DIR_FLE_EC_CMZ.$___fle_n_o;
			
			$rsp['fle']['prc']['url'] = $__url.'bg_bco_'.$__bco.$___ext;			
			$rsp['fle']['mve'] = $___fle_m;
	
			$rsp['fle']['srcs'] = DIR_FLE_EC_CMZ.$___fle_n;
			$rsp['fle']['src'] = DMN_FLE_EC_CMZ.$___fle_n;
			$rsp['fle']['srcf'] = DIR_FLE_EC_CMZ.$___fle_n;
			$rsp['fle']['srco'] = DMN_FLE_EC_CMZ.$___fle_n_o;
			
			$_fle_bco_exts = $_fle->_ExstBco([ 't'=>'bco', 'lcl_u'=>'ok', 'path'=>$___fle ]);			
					
			if($_fle_bco_exts->e == 'ok' && $_fle_bco_exts->get->e == 'ok'){
								
				$_sve = $rsp['aws_put']['f'] = $_aws->_s3_put([ 'b'=>'fle', 'fle'=>_TmpFixDir(DIR_FLE_EC_CMZ.$___fle_n), 'src'=>$_fle_bco_exts->rpth, 'ctp'=>mime_content_type($_fle_bco_exts->rpth), 'cfr'=>'ok' ]);
				
				$_sve_o = $rsp['aws_put']['o'] = $_aws->_s3_put([ 'b'=>'fle', 'fle'=>_TmpFixDir(DIR_FLE_EC_CMZ.$___fle_n_o), 'src'=>$_fle_bco_exts->rpth, 'ctp'=>mime_content_type($_fle_bco_exts->rpth), 'cfr'=>'ok' ]);
			
				$rsp['fle']['bco'] = $_fle_bco_exts->rpth;
				
				if(copy($_fle_bco_exts->rpth, $___fle_m) && copy($_fle_bco_exts->rpth, $___fle_m_o) && $_sve->e == 'ok' && $_sve_o->e == 'ok'){		
					
					try{
						
						if($__imgmw > $__imgmh){
							$__c_imgmw = ($__imgmw*$__imgmd);
						}else{
							$__c_imgmh = $__imgmh;
						}
						
						$rsp['cut']['w'] = $__c_imgmw;
						$rsp['cut']['h'] = $__c_imgmh;
										
						// Baja Calidad de Original
						$image_nr = new Imagick($_fle_bco_exts->rpth);
						$image_nr->setImageFormat ("jpeg");
						$image_nr->setImageCompression(imagick::COMPRESSION_JPEG);
						$image_nr->setImageCompressionQuality(0.9);
						$image_nr->thumbnailImage($__c_imgmw, $__c_imgmh);
											
						if($image_nr->writeImage($___fle_m)){
							$_sve = $_aws->_s3_put([ 'b'=>'fle', 'fle'=>_TmpFixDir(DIR_FLE_EC_CMZ.$___fle_n), 'src'=>$___fle_m, 'ctp'=>mime_content_type($___fle_m), 'cfr'=>'ok' ]);	
							if($_sve->e!='ok'){$_notsve='on';}
						}else{
							$_notsve='on';
						}
	
						$image_nr->clear();
						$image_nr->destroy();
						
						if($_notsve != 'on'){

							// Baja Calidad de Original
							$image_nr = new Imagick($___fle_m_o);
							$image_nr->setImageFormat ("jpeg");
							$image_nr->setImageCompression(imagick::COMPRESSION_JPEG);
							$image_nr->setImageCompressionQuality(0.9);
							$image_nr->thumbnailImage($__c_imgmw, $__c_imgmh);
							
							if($image_nr->writeImage($___fle_m_o)){
								$_sve = $_aws->_s3_put([ 'b'=>'fle', 'fle'=>_TmpFixDir(DIR_FLE_EC_CMZ.$___fle_n_o), 'src'=>$___fle_m_o, 'ctp'=>mime_content_type($___fle_m_o), 'cfr'=>'ok' ]);	
								if($_sve->e!='ok'){$_notsve='on';}
							}else{
								$_notsve='on';
							}
							
							$image_nr->clear();
							$image_nr->destroy();
		
							if($_notsve != 'on'){	

								$updateSQL = sprintf("UPDATE "._BdStr(DBM).TB_EC_CMZ_IMG." SET eccmzimg_fle=%s WHERE id_eccmzimg=%s",
													GtSQLVlStr($___fle_n, "text"),
													GtSQLVlStr($rsp['id'], "int"));	
								$Result_Upd = $__cnx->_prc($updateSQL);
								
								
								//$rsp['u_o'] = __AutoRUN([ 't'=>'ec', 's2'=>'ec_cmz', 'id'=>$_POST['eccmz'] ]);
								
								$__ec_cmz->ec_cmz = $_POST['eccmz'];
								$rsp['upd_cod'] = $_upd_cod = $__ec_cmz->_bld_ec([ 'cche'=>'ok' ]);

								if($_upd_cod->e == 'ok'){
									$rsp['e'] = 'ok';
								}

							}

						}
					
					}catch(Exception $e){
						
						$rsp['w'] = $e->getMessage();    
						      
					}
						
				}else{
					
					$rsp['w_m'] = 'Not copy';
					$rsp['w'] = error_get_last();
					$rsp['e'] = 'no';
					
				}
				
			}else{

				$rsp['w'] = 'Not exists bco';
				$rsp['tmp_w'] = $_fle_bco_exts;
				
			}
			
		}else{
			
			$rsp['e'] = 'no';
			
		}
		
	}else{
		$rsp['e'] = 'no';
	}
	
} 

?>