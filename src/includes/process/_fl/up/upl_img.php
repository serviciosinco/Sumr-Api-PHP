<?php 
//@ini_set('display_errors', true); 
//error_reporting(E_ALL & ~E_NOTICE);
		
//if(ChckSESS_adm()){ 
	
	try{
		
		$rsp['status'] = 'error';
		
		$_fle = new CRM_Fle();
		
	  	if (((isset($_POST['MM_update']))&&($_POST['MM_update'] == 'ImgUpl'))) {
			
			
			if (!empty($_FILES)) {		
						
				$__idt = Php_Ls_Cln($_POST['_idt']);
				$__p_i = Php_Ls_Cln($_POST['_i']);
				$__noupd = Php_Ls_Cln($_POST['_noupd']);
				
				
				$Sch = [DMN_BS];
				$Chn = [''];
				$Fldr_Rl = str_replace($Sch,$Chn,$_POST['_dr']);
				$allowed = ['jpg', 'svg', 'png'];
				
				if(isset($_FILES['upl']) && $_FILES['upl']['error'] == 0){
					
					$extension = pathinfo($_FILES['upl']['name'], PATHINFO_EXTENSION);
					
					if(!in_array(strtolower($extension), $allowed)){
						$rsp['status'] = 'error';
					}
					
					if($_POST['_enc'] != ''){
						$__fl_tt = $_POST['_enc'];
					}else{
						$__fl_tt = $_POST['_nm'].'_'.$_POST['_i'];
					}
					
					$_fle->_nw_fld = $Fldr_Rl;
					$_fle->_tt = $__fl_tt;
					$_fle->_srce = $_FILES;
					$_flem = $_fle->_SumrToFle();
					$_SZE = $_flem->sze;
					
					
					$rsp['sumrsze'] = $_SZE;
					
					$_sve = $_aws->_s3_put([ 'b'=>'fle', 'fle'=>$_SZE->main->sve, 'src'=>$_flem->rpth, 'ctp'=>$_flem->fle->tp, 'cfr'=>'ok' ]);
					
					
					if($_flem->e == 'ok' && $_sve->e == 'ok'){
							
						if(class_exists("Imagick") && $extension != 'svg'){
							
							$image_bd = new Imagick($_flem->rpth);
							$image_bd_s = $image_bd->getImageGeometry();
							
							$__fl_w = $image_bd_s['width'];
							$__fl_h = $image_bd_s['height'];
							$__fl_b = $image_bd->getImageLength();
						
						}
						
						
						if($__idt == 't'){ $__tp_r = 'text'; }else{ $__tp_r = 'int'; }
							
						if(!isN($__p_i) && !isN($_POST['_bd']) && !isN($_POST['_fl'])){	
							
							if(!isN($_POST['_bd_cl'])){ 
								$_prfx_bd = _BdStr(DB_CL); 
							}elseif(!isN($_POST['_bd_store'])){ 
								$_prfx_bd = _BdStr(DBS); 
							}elseif(!isN($_POST['_bd_thrd'])){ 
								$_prfx_bd = _BdStr(DBT); 
							}else{ 
								$_prfx_bd = _BdStr(DBM); 
							}
							
							$updateSQL = sprintf("UPDATE ".$_prfx_bd.$_POST['_bd']." SET ".$_POST['_fl']."=%s WHERE ".$_POST['_id']."=%s",                    
									GtSQLVlStr($_flem->name->new, "text"),                 						 			
									GtSQLVlStr($__p_i, $__tp_r));
							$Result = $__cnx->_prc($updateSQL);
							
							if(ChckSESS_superadm()){ $rsp['query'] = $__idt.' -> '.$updateSQL; }
						}
						
						
						if(!$Result || $__noupd=='ok'){ 
							
						
							if(!isN($_POST['_bd']) && $__noupd != 'ok'){
								_ErrSis(['p'=>$updateSQL, 'd'=>$__cnx->c_p->error]); 
								$rsp['status'] = $updateSQL.'error - no update database - '.$__cnx->c_p->error." - ".$_POST['_bd'];
							}else{
								$rsp['w'] = ' - Se movio a la carpeta: '.print_r($Sch, true)." <--> ".print_r($Chn, true)." <--> ".$_POST['_dr']; 
								$rsp['status'] = 'success';
							}
							
									
						}else{
							
							if(class_exists("Imagick")){
								
								if($extension != 'svg'){
									
									// Baja Calidad de Original
									$image_nr = new Imagick($_flem->rpth);
									$image_nr->setImageFormat ("jpeg");
									$image_nr->thumbnailImage(1920, 0);
									if($image_nr->writeImage($_flem->rpth)){
										$rsp['sve']['main'] = $_sve = $_aws->_s3_put([ 'b'=>'fle', 'fle'=>$_SZE->main->sve, 'src'=>$_SZE->main->src, 'ctp'=>$_flem->fle->tp, 'cfr'=>'ok' ]);	
									}
									$image_nr->clear();
									$image_nr->destroy();
									
	
									
									// GrayScale
									$image_gry = new IMagick($_flem->rpth); 
									$image_gry->setImageColorSpace(imagick::COLORSPACE_GRAY); 
									

									if($image_gry->writeImage($_SZE->gry->src)){
										$rsp['sve']['gry'] = $_sve = $_aws->_s3_put([ 'b'=>'fle', 'fle'=>$_SZE->gry->sve, 'src'=>$_SZE->gry->src, 'ctp'=>$_flem->fle->tp, 'cfr'=>'ok' ]);	
										if($_sve->e=='no'){ $__aws='no';}
									}
									$image_gry->clear();
									$image_gry->destroy();
									
									
									// Thumbnail 200
									$image_th = new IMagick($_flem->rpth);
									$image_th->setImageFormat ("jpeg");
									$image_th->setImageCompression(imagick::COMPRESSION_JPEG);
									$image_th->setImageCompressionQuality(0.3);
									$image_th->thumbnailImage(200, 0);
									if($image_th->writeImage($_SZE->sm->src)){
										$rsp['sve']['sm'] = $_sve = $_aws->_s3_put([ 'b'=>'fle', 'fle'=>$_SZE->sm->sve, 'src'=>$_SZE->sm->src, 'ctp'=>$_flem->fle->tp, 'cfr'=>'ok' ]);
										if($_sve->e=='no'){ $__aws='no';}	
									}
									$image_th->clear();
									$image_th->destroy();	
									
									
									// Thumbnail 400
									$image_md = new IMagick($_flem->rpth);
									$image_md->setImageFormat ("jpeg");
									$image_md->thumbnailImage(400, 0);
									if($image_md->writeImage($_SZE->md->src)){
										$rsp['sve']['md'] = $_sve = $_aws->_s3_put([ 'b'=>'fle', 'fle'=>$_SZE->md->sve, 'src'=>$_SZE->md->src, 'ctp'=>$_flem->fle->tp, 'cfr'=>'ok' ]);	
										if($_sve->e=='no'){ $__aws='no';}	
									}
									$image_md->clear();
									$image_md->destroy();
									
									
									// Thumbnail 800
									$image_bg = new IMagick($_flem->rpth);
									$image_bg->setImageFormat ("jpeg");
									$image_bg->thumbnailImage(800, 0);
									if($image_bg->writeImage($_SZE->bg->src)){
										$rsp['sve']['bg'] = $_sve = $_aws->_s3_put([ 'b'=>'fle', 'fle'=>$_SZE->bg->sve, 'src'=>$_SZE->bg->src, 'ctp'=>$_flem->fle->tp, 'cfr'=>'ok' ]);	
										if($_sve->e=='no'){ $__aws='no';}	
									}
									$image_bg->clear();
									$image_bg->destroy();
									
									
									
									//---------------------- THUMBNAILS ----------------------//
									
									
									
									// Croppped
									$image_crp = new Imagick($_flem->rpth);  
									$image_crp->setImageFormat ("jpeg");
									$image_crp->cropImage($_POST['w'], $_POST['h'], $_POST['x'], $_POST['y']);
									if($image_crp->writeImage( $_SZE->th->src )){
										$rsp['sve']['th']['main'] = $_sve = $_aws->_s3_put([ 'b'=>'fle', 'fle'=>$_SZE->th->sve, 'src'=>$_SZE->th->src, 'ctp'=>$_flem->th->tp, 'cfr'=>'ok' ]);	
										if($_sve->e=='no'){ $__aws='no';}	
									}
									$image_crp->clear();
									$image_crp->destroy();
									
									
									// Thumbnail 50
									$mask_thp = new Imagick('mask.png');
									$mask_thp->thumbnailImage(50, 0);
									
									$mask_thp_t = new Imagick('mask2.png');
									$mask_thp_t->thumbnailImage(50, 0);
									
									$image_thp = new Imagick($_SZE->th->src);
									$image_thp->setImageFormat ("jpeg");
									$image_thp->setImageCompression(imagick::COMPRESSION_JPEG);
									$image_thp->setImageCompressionQuality(0.3);
									$image_thp->thumbnailImage(50, 0);
									
									if($image_thp->writeImage($_SZE->t50->src)){
										$rsp['sve']['th']['50'] = $_sve = $_aws->_s3_put([ 'b'=>'fle', 'fle'=>$_SZE->t50->sve, 'src'=>$_SZE->t50->src, 'ctp'=>$_SZE->t50->tp, 'cfr'=>'ok' ]);
										if($_sve->e=='no'){ $__aws='no';}	
									}
									
									$image_thp->compositeImage($mask_thp, Imagick::COMPOSITE_DEFAULT, 0, 0);

									if($image_thp->writeImage($_SZE->tc50->src)){
										$rsp['sve']['th']['c50'] = $_sve = $_aws->_s3_put([ 'b'=>'fle', 'fle'=>$_SZE->tc50->sve, 'src'=>$_SZE->tc50->src, 'ctp'=>$_SZE->tc50->tp, 'cfr'=>'ok', 'cfr'=>'ok' ]);
										if($_sve->e=='no'){ $__aws='no';}	
									}
									
									$image_thp->compositeImage($mask_thp_t, Imagick::COMPOSITE_DSTIN, 0, 0, Imagick::CHANNEL_ALPHA);
									
									if($image_thp->writeImage($_SZE->tc50p->src)){
										$rsp['sve']['th']['c50p'] = $_sve = $_aws->_s3_put([ 'b'=>'fle', 'fle'=>$_SZE->tc50p->sve, 'src'=>$_SZE->tc50p->src, 'ctp'=>$_SZE->tc50p->tp, 'cfr'=>'ok' ]);
										if($_sve->e=='no'){ $__aws='no';}	
									}					
									
									$image_thp->clear();
									$image_thp->destroy();
									
									
									
									
									// Thumbnail 100
									$mask_th = new Imagick('mask.png');
									$mask_th->thumbnailImage(100, 0);
									
									$mask_th_t = new Imagick('mask2.png');
									$mask_th_t->thumbnailImage(100, 0);
									
									$image_th = new Imagick($_SZE->th->src);
									$image_th->setImageFormat ("jpeg");
									$image_th->setImageCompression(imagick::COMPRESSION_JPEG);
									$image_th->setImageCompressionQuality(0.3);
									$image_th->thumbnailImage(100, 0);
									
									if($image_th->writeImage($_SZE->t100->src)){
										$rsp['sve']['th']['100'] = $_sve = $_aws->_s3_put([ 'b'=>'fle', 'fle'=>$_SZE->t100->sve, 'src'=>$_SZE->t100->src, 'ctp'=>$_SZE->t100->tp, 'cfr'=>'ok' ]);
										if($_sve->e=='no'){ $__aws='no';}	
									}
									
									$image_th->compositeImage($mask_th, Imagick::COMPOSITE_DEFAULT, 0, 0);
									
									if($image_th->writeImage($_SZE->tc100->src)){
										$rsp['sve']['th']['c100'] = $_sve = $_aws->_s3_put([ 'b'=>'fle', 'fle'=>$_SZE->tc100->sve, 'src'=>$_SZE->tc100->src, 'ctp'=>$_SZE->tc100->tp, 'cfr'=>'ok' ]);		
										if($_sve->e=='no'){ $__aws='no';}					
									}					
														
									$image_th->compositeImage($mask_th_t, Imagick::COMPOSITE_DSTIN, 0, 0, Imagick::CHANNEL_ALPHA);
									
									if($image_th->writeImage($_SZE->tc100p->src)){
										$rsp['sve']['th']['c100p'] = $_sve = $_aws->_s3_put([ 'b'=>'fle', 'fle'=>$_SZE->tc100p->sve, 'src'=>$_SZE->tc100p->src, 'ctp'=>$_SZE->tc100p->tp, 'cfr'=>'ok' ]);
										if($_sve->e=='no'){ $__aws='no';}	
									}					
									
									$image_th->clear();
									$image_th->destroy();	
									
									// Thumbnail 200
									$mask_md = new Imagick('mask.png');
									$mask_md->thumbnailImage(200, 0);
									$mask_md_t = new Imagick('mask2.png');
									$mask_md_t->thumbnailImage(200, 0);
									$image_md = new Imagick($_flem->rpth);
									$image_md->setImageFormat ("jpeg");
									$image_md->setImageCompression(imagick::COMPRESSION_JPEG);
									$image_md->setImageCompressionQuality(0.3);
									$image_md->thumbnailImage(200, 0);
										
									if($image_md->writeImage($_SZE->t200->src)){
										$rsp['sve']['th']['200'] = $_sve = $_aws->_s3_put([ 'b'=>'fle', 'fle'=>$_SZE->t200->sve, 'src'=>$_SZE->t200->src, 'ctp'=>$_SZE->t200->tp, 'cfr'=>'ok' ]);
										if($_sve->e=='no'){ $__aws='no';}	
									}					
														
									$image_md->compositeImage($mask_md, Imagick::COMPOSITE_DEFAULT, 0, 0);
									
									if($image_md->writeImage($_SZE->tc200->src)){	
										$rsp['sve']['th']['c200'] = $_sve = $_aws->_s3_put([ 'b'=>'fle', 'fle'=>$_SZE->tc200->sve, 'src'=>$_SZE->tc100->src, 'ctp'=>$_SZE->tc100->tp, 'cfr'=>'ok' ]);
										if($_sve->e=='no'){ $__aws='no';}						
									}
									
														
									$image_md->compositeImage($mask_md_t, Imagick::COMPOSITE_DSTIN, 0, 0, Imagick::CHANNEL_ALPHA);
									
									if($image_md->writeImage($_SZE->tc200p->src)){
										$rsp['sve']['th']['c200p'] = $_sve = $_aws->_s3_put([ 'b'=>'fle', 'fle'=>$_SZE->tc200p->sve, 'src'=>$_SZE->tc200p->src, 'ctp'=>$_SZE->tc200p->tp, 'cfr'=>'ok' ]);
										if($_sve->e=='no'){ $__aws='no';}	
									}
									
									
									$image_md->clear();
									$image_md->destroy();
									
									// Thumbnail 400
									$mask_bg = new Imagick('mask.png');
									$mask_bg->thumbnailImage(400, 0);
									$mask_bg_t = new Imagick('mask2.png');
									$mask_bg_t->thumbnailImage(400, 0);
									
									$image_bg = new Imagick($_flem->rpth);
									$image_bg->setImageFormat ("jpeg");
									$image_bg->setImageCompression(imagick::COMPRESSION_JPEG);
									$image_bg->setImageCompressionQuality(0.3);
									$image_bg->thumbnailImage(400, 0);
									
									if($image_bg->writeImage($_SZE->t400->src)){
										$rsp['sve']['th']['400'] = $_sve = $_aws->_s3_put([ 'b'=>'fle', 'fle'=>$_SZE->t400->sve, 'src'=>$_SZE->t400->src, 'ctp'=>$_SZE->t400->tp, 'cfr'=>'ok' ]);
										if($_sve->e=='no'){ $__aws='no';}	
									}
														
														
									$image_bg->compositeImage($mask_bg, Imagick::COMPOSITE_DEFAULT, 0, 0);
									
									
									if($image_bg->writeImage($_SZE->tc400->src)){
										$rsp['sve']['th']['c400'] = $_sve = $_aws->_s3_put([ 'b'=>'fle', 'fle'=>$_SZE->tc400->sve, 'src'=>$_SZE->tc400->src, 'ctp'=>$_SZE->tc400->tp, 'cfr'=>'ok' ]);
										if($_sve->e=='no'){ $__aws='no';}							
									}
														
														
									$image_bg->compositeImage($mask_bg_t, Imagick::COMPOSITE_DSTIN, 0, 0, Imagick::CHANNEL_ALPHA);
									
									if($image_bg->writeImage($_SZE->tc400p->src)){
										$rsp['sve']['th']['c400'] = $_sve = $_aws->_s3_put([ 'b'=>'fle', 'fle'=>$_SZE->tc400->sve, 'src'=>$_SZE->tc400p->src, 'ctp'=>$_SZE->tc400p->tp, 'cfr'=>'ok' ]);
										if($_sve->e=='no'){ $__aws='no';}	
									}
														
									
									$image_bg->clear();
									$image_bg->destroy();
		 
								}else{
									
									$rsp['message'] = 'Its SVG dont create versions';
									
								}
								
							}			 
							
							if($__aws != 'no'){			 
								$rsp['w'] = ' - Se movio a la carpeta: '.print_r($Sch, true)." <--> ".print_r($Chn, true)." <--> ".$_POST['_dr']; 
								$rsp['status'] = 'success';
							}
						}	
						
					}else{
						
						$rsp['status'] = 'error -> no move to '.$_fle->_nw_fld.$_flem->name->new;
						$rsp['save'] = $_sve;
						
						_ErrSis(['p'=>$updateSQL, 'd'=>$__cnx->c_p->error]);
						
					}
					
				}else{
					
					$rsp['status'] = 'error';
					_ErrSis(['p'=>$insertSQL, 'd'=>$__cnx->c_p->error]);
					
				}
					
			}
			
		}else{
			
			$rsp['status'] = 'error'; $rsp['w'] = 'No inicia el proceso'; $rsp['e'] = 'no'; $rsp['m'] = 2;	
			
		}
	
	
	}catch(Exception $e){
		
		$rsp['e'] = 'no';
		$rsp['w'] = $e->getMessage();
		
	}
	
	
	//$__us = GtUsDt(SISUS_ID,'',['prvt'=>'ok']);
	//$rsp['us'] = $__us;

//}

Hdr_JSON();
$rtrn = json_encode($rsp); echo $rtrn;
?>