<?php  
	
	
	//@ini_set('display_errors', true); 
	//error_reporting(E_ALL & ~E_NOTICE /*&& ~E_WARNING*/);
	//define('DSERR','on');
			
	
	ini_set('max_execution_time', 0);		
			
	$__c_bco = new CRM_Bco();
	$_fle = new CRM_Fle(); 
	
	$rsp['tmp_files'] = $_FILES;
	
	
	try{	
			
			
	  	if (((isset($_POST['MM_update']))&&($_POST['MM_update'] == 'ImgUplNw'))) {
		  	
		  	
			if (!empty($_FILES)) {
				
						
				$_ftp_on = Php_Ls_Cln($_POST['bco_ftp_on']);
				
				if($_ftp_on == 'ok' && !isN( Php_Ls_Cln($_POST['bco_ftp_hid']) )){
					$ftp = GtClFtpDt(['id'=>Php_Ls_Cln($_POST['bco_ftp_hid']) ]);
					$rsp['ftp_qry'] = $ftp;
				}			
							
				$__fl_nm = $_FILES['upl']['name'];
				
				
				$Sch = [DMN_BS];
				$Fldr_Rl = str_replace($Sch,[''],DIR_BCO);
			
				
				if(isset($_FILES['upl']) && $_FILES['upl']['error'] == 0){
					
					$extension = strtolower(pathinfo($_FILES['upl']['name'], PATHINFO_EXTENSION));
	
					$__c_bco->nm = $__fl_nm;
					$__c_bco->ext = $extension;
					$__c_bco->ftp = $ftp;
					$__c_bco->tag = explode(',',$_POST['bco_tag_hid']);
					$__c_bco->are = explode(',',$_POST['bco_are_hid']);
					$__c_bco->cd = explode(',',$_POST['bco_cd_hid']);
					$__in = $__c_bco->_Bco();	
				
					$__ftp = [];
					$__tmp_nm = $_FILES['upl']['tmp_name'];
					$__nw_nm = $_POST['_nm'].'_'.$__in->id.'.'.$extension;
					$__nw_fld = '../../../'.$Fldr_Rl;
					$__nw_fld_th = $__nw_fld.'th/';
					
					
					try{	
						$_sve = $_aws->_s3_put([ 'b'=>'bco', 'fle'=>_TmpFixDir($__nw_nm), 'src'=>$__tmp_nm, 'ctp'=>mime_content_type($__tmp_nm), 'cfr'=>'ok' ]);
					}catch(Exception $e){
						$rsp['e'] = 'no';
						$rsp['w'] = $e->getMessage();
					}
							
					
					if(move_uploaded_file($__tmp_nm, $__nw_fld.$__nw_nm) && !isN($__in->id) && $_sve->e == 'ok'){
						
						$__c_bco->chk[] = 1;
						$__ftp[] = [ 'get'=>$__nw_fld.$__nw_nm, 'sve'=>$__nw_nm, 'pth'=>$ftp->svc->bco->pth ];
	
						$exif = @exif_read_data($__nw_fld.$__nw_nm, 0, true);
						$__c_bco->exif = $exif;
						$__c_bco->_Attr();
						
	
						// Imagen Caracteristicas
						$image_bd = new Imagick($__nw_fld.$__nw_nm);
						$image_bd_s = $image_bd->getImageGeometry();
						
						$__fl_w = $image_bd_s['width'];;
						$__fl_h = $image_bd_s['height'];
						$__fl_b = $image_bd->getImageLength();
	
						$__upd = $__c_bco->_Bco_Upd([ 'img'=>$__nw_nm, 'org'=>$__fl_nm, 'w'=>$__fl_w, 'h'=>$__fl_h, 'b'=>$__fl_b ]);
						
						if($__upd->e != 'ok'){ _ErrSis([ 'p'=>$updateSQL, 'd'=>$__cnx->c_p->error ]); }
								
						// Thumbnail 200
						$__pth_th = $__nw_fld_th.'th_'.$__nw_nm;
						$image_th = new Imagick($__nw_fld.$__nw_nm);
						$image_th->setImageFormat ("jpeg");
						$image_th->setImageCompression(imagick::COMPRESSION_JPEG);
						$image_th->setImageCompressionQuality(0.3);
						$image_th->thumbnailImage(200, 0);
						
						if($image_th->writeImage($__pth_th)){
							
							$_sve = $_aws->_s3_put([ 'b'=>'bco', 'fle'=>_TmpFixDir(DR_IMG_TH.'th_'.$__nw_nm), 'src'=>$__pth_th, 'ctp'=>mime_content_type($__pth_th), 'cfr'=>'ok' ]);
							
							$image_th->clear();
							$image_th->destroy();
							$__c_bco->chk[] = 4;
							
							$__ftp[] = [ 'get'=>$__pth_th, 'sve'=>'th_'.$__nw_nm, 'pth'=>$ftp->svc->bco->pth.'th/' ];	
							
						}
						
						
						// Thumbnail 400
						$__pth_md = $__nw_fld_th.'md_'.$__nw_nm;
						$image_md = new Imagick($__nw_fld.$__nw_nm);
						$image_md->setImageFormat ("jpeg");
						$image_md->thumbnailImage(400, 0);
						
						if($image_md->writeImage($__pth_md)){
							
							$_sve = $_aws->_s3_put([ 'b'=>'bco', 'fle'=>_TmpFixDir(DR_IMG_TH.'md_'.$__nw_nm), 'src'=>$__pth_md, 'ctp'=>mime_content_type($__pth_md), 'cfr'=>'ok' ]);
	
							$image_md->clear();
							$image_md->destroy();
							$__c_bco->chk[] = 2;
							$__ftp[] = [ 'get'=>$__pth_md, 'sve'=>'md_'.$__nw_nm, 'pth'=>$ftp->svc->bco->pth.'th/' ];	
						}
						
						
						
						
						
						
						// Thumbnail 800
						$__pth_bg = $__nw_fld_th.'bg_'.$__nw_nm;
						$image_bg = new Imagick($__nw_fld.$__nw_nm);
						$image_bg->setImageFormat ("jpeg");
						$image_bg->thumbnailImage(800, 0);
						
						if($image_bg->writeImage($__pth_bg)){
							
							$_sve = $_aws->_s3_put([ 'b'=>'bco', 'fle'=>_TmpFixDir(DR_IMG_TH.'bg_'.$__nw_nm), 'src'=>$__pth_bg, 'ctp'=>mime_content_type($__pth_bg), 'cfr'=>'ok' ]);
							
							$image_bg->clear();
							$image_bg->destroy();					
							$__c_bco->chk[] = 3;
							$__ftp[] = [ 'get'=>$__pth_bg, 'sve'=>'bg_'.$__nw_nm, 'pth'=>$ftp->svc->bco->pth.'th/' ];
						}
						
						
						// Thumbnail 2000
						$__fll_bg = $__nw_fld_th.'fll_'.$__nw_nm;
						$image_fll = new Imagick($__nw_fld.$__nw_nm);
						$image_fll->setImageFormat ("jpeg");
						$image_fll->thumbnailImage(2000, 0);
						
						if($image_fll->writeImage($__fll_bg)){
							
							$_sve = $_aws->_s3_put([ 'b'=>'bco', 'fle'=>_TmpFixDir(DR_IMG_TH.'fll_'.$__nw_nm), 'src'=>$__fll_bg, 'ctp'=>mime_content_type($__fll_bg), 'cfr'=>'ok' ]);
							
							$image_fll->clear();
							$image_fll->destroy();					
							$__c_bco->chk[] = 3;
							$__ftp[] = [ 'get'=>$__fll_bg, 'sve'=>'fll_'.$__nw_nm, 'pth'=>$ftp->svc->bco->pth.'th/' ];
						}
						
						
						
						$__c_bco->_ChkTp();
								
						$rsp['status'] = 'success';
						$rsp['e'] = 'ok';
	
	
						if($_ftp_on == 'ok'){
							
							$ftp_i=1;
							
							$rsp['ftp_d']['hst'] = $ftp->hst;
							$rsp['ftp_d']['pth'] = $ftp->svc->bco->pth;
							
							if(!isN($ftp->hst) && !isN($ftp->svc->bco->pth)){
							
								foreach($__ftp as $__ftp_k=>$__ftp_v){
									
									$rsp['ftp'][$ftp_i]['s'] = $___sve;		
									$rsp['ftp'][$ftp_i]['v'] = $__ftp_v;
									
									if($___sve->e != 'ok'){ break; $__ftp_e = 'no'; }
									
									$ftp_i++;
								}
								
								if($__ftp_e != 'no'){
									
									foreach($__ftp as $__ftp_k=>$__ftp_v){
										unlink($__ftp_v['get']);	
									}
									
								}
							
							}
							
						
						}
						
					}else{
						$rsp['status'] = 'error';
						$rsp['message'] = 'No se movio el archivo'; 
						$rsp['error'] = "Not uploaded because of error #".$_FILES["file"]["error"];
						_ErrSis([ 'p'=>$updateSQL, 'd'=>$__cnx->c_p->error ]);
					}
					
				}else{

					$rsp['status'] = 'error';
					$rsp['message'] = 'ImgUplNw: No viene informacion de carga';
					_ErrSis([ 'p'=>$insertSQL, 'd'=>$__cnx->c_p->error ]);
				}
					
			}
			
		}elseif($_POST['_tp'] == '_org'){
			
			$_id = Php_Ls_Cln($_POST['_id']);
			$__fl_nm = $_FILES['upl']['name'];
			
			$Sch = [DMN_BS];
			$Chn = [''];
			$Fldr_Rl = str_replace($Sch,$Chn,DIR_BCO);
			$allowed = ['jpg'];
			
			if(isset($_FILES['upl']) && $_FILES['upl']['error'] == 0){
				
				$extension = strtolower(pathinfo($_FILES['upl']['name'], PATHINFO_EXTENSION));
				
				if(!in_array(strtolower($extension), $allowed)){
					$rsp['status'] = 'error';
					$rsp['message'] = 'Extension no valida';
				}
				
				$__BcoDt = GtBcoDt([ 'id'=>$_id ]);
										
				$__tmp_nm = $_FILES['upl']['tmp_name'];
				
				
				$__nw_nm = $__BcoDt->img;
				$__nw_fld = '../../../'.$Fldr_Rl;
				
				$rsp['newfolder'] = $__nw_fld.$__nw_nm;
				
				
				if(move_uploaded_file($__tmp_nm, $__nw_fld.$__nw_nm)){
					
					// Imagen Caracteristicas
					$image_bd = new Imagick($__nw_fld.$__nw_nm);
					$image_bd_s = $image_bd->getImageGeometry();
					
					$__fl_w = $image_bd_s['width'];;
					$__fl_h = $image_bd_s['height'];
					$__fl_b = $image_bd->getImageLength();
	
					//Insertar el bco_chk
					$insertBcoChk = "INSERT INTO bco_chk (bcochk_bco, bcochk_chktp) VALUES (".$_id.", 1)";	
	        		$ResultBcoChk = $__cnx->_prc($insertBcoChk);
					
					$rsp['status'] = 'success';
					$rsp['e'] = 'ok';
					
					$__cnx->_clsr($ResultBcoChk);
					
				}else{
					$rsp['status'] = 'error';
					$rsp['message'] = 'No se movio el archivo';
					_ErrSis([ 'p'=>$updateSQL, 'd'=>$__cnx->c_p->error ]);
				}
				
				
			}else{
				$rsp['status'] = 'error';
				$rsp['message'] = 'No viene informacion de carga';
				_ErrSis([ 'p'=>$insertSQL, 'd'=>$__cnx->c_p->error ]);
			}
			
		}elseif($_POST['_tp'] == '_th' || $_GET['_tp'] == '_th'){
			
			$_id = Php_Ls_Cln($_POST['_id']);
			
			$__BcoDt = GtBcoDt([ 'id'=>$_id ]);
			
			$__nw_nm = $__BcoDt->img;
			$__nw_fld = DMN_FLE_BCO;
			
			
			$image_th = new Imagick($__nw_fld."bco_6232.jpg");
			$image_th->setImageFormat ("jpeg");
			$image_th->setImageCompression(imagick::COMPRESSION_JPEG);
			$image_th->setImageCompressionQuality(0.3);
			$image_th->thumbnailImage(200, 0);
			$image_th->writeImage($__nw_fld."bco_6232_a.jpg");
			$image_th->clear();
			$image_th->destroy();	
			
			
			$rsp['status'] = 'success';
			$rsp['e'] = 'ok';			
			
		}else{
			
			$rsp['e'] = 'no'; $rsp['m'] = 2;
			$rsp['w'] = 'No hay POST '.$_POST['MM_update']." - ".$_POST['bco_fac_hid'];
			$rsp['w_m'] = error_get_last();
			
		}
		
	}catch(Exception $e){
		
		$rsp['e'] = 'no';
		$rsp['w'] = $e->getMessage();
		$rsp['w_m'] = error_get_last();
		
	}
				
				
					
	Hdr_JSON();
	$rtrn = json_encode($rsp); echo $rtrn;

?>