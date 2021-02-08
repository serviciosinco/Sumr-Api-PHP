<?php 	
	
	$_fle = new CRM_Fle();
	$__ec_cmz = new API_CRM_ec_Cmz();	
	
//if(ChckSESS_adm()){ 
	
	//@ini_set('display_errors', true); 
	//error_reporting(E_ALL);
			
	//---------------- VARIABLES GET ----------------//
	
	
		$__p_eccmz = Php_Ls_Cln($_POST['ec_cmz']);
		$__p_bdel = Php_Ls_Cln($_POST['bd_el']);
		$__p_drim = Php_Ls_Cln($_POST['dr_im']);
		$__p_drimo = Php_Ls_Cln($_POST['dr_imo']);
		$__p_bdcl = Php_Ls_Cln($_POST['bd_cl']);

	
	//---------------- FIX DATABASE PATH ----------------//	
		
		if($__p_bdel == 'ec_cmz_img'){
			$__bd_pth = _BdStr(DBM);
		}elseif(!isN($__p_bdcl)){ 
			$__bd_pth = _BdStr(DB_CL); 
		}else{ 
			$__bd_pth = _BdStr(DBM); 
		}
	
	//---------------- INICIA PROCESAMIENTO ----------------//
	
	
	
	if(isset($_POST['bdsrc'])&&($_POST['bdsrc'] == 'bst')){ $_sqlbd = DB_BST;}else{$_sqlbd = DB;}
	$colname_Dt_Img = "-1"; if (isset($_POST['i'])){$colname_Dt_Img = $_POST['i'];}	
	
	if(is_numeric($colname_Dt_Img)){ $__t_fld='int'; }else{ $__t_fld='text'; }
	
	if(!isN($_POST['id_el'])){

		$Dt_Qry = sprintf("SELECT * FROM ".$__bd_pth.$__p_bdel." WHERE ".$_POST['id_el']." = %s", GtSQLVlStr($colname_Dt_Img, $__t_fld));
		$Dt_Img = $__cnx->_qry($Dt_Qry); 

		if($Dt_Img){
			$row_Dt_Img = $Dt_Img->fetch_assoc(); 
			$Tot_Dt_Img = $Dt_Img->num_rows;
		}else{
			$rsp['w'] = $__cnx->c_r->error;
			$rsp['sid'] = SISUS_ID;
		}

	}

	//$rsp['qry'] = $Dt_Qry;
	$_NoTh = $_POST['dr_noth'];
	
	if (((isset($_POST['MM_update']))&&($_POST['MM_update'] == 'ImgRte'))) {
		
		$__p_rte = Php_Ls_Cln($_POST['rte']);

		$Th_Wrt = $__p_drim;
		$Th_Fld = str_replace('.jpg','_o.jpg',$__p_drim);
		
		$_fle_exts = $_fle->_ExstO([ 'lcl_u'=>'ok', 'path'=>$Th_Wrt, 'path_o'=>$Th_Fld ]);

		if($_fle_exts->e == 'ok' && $_fle_exts->get->e == 'ok'){

			if($__p_rte == 'left'){ $__rte = '-90.0'; }else{ $__rte = '90.0'; } 
			
			$image_rte = new Imagick( $_fle_exts->rpth_o );
			$image_rte->setImageFormat ("jpeg");
			$image_rte->rotateImage ( 'white', $__rte );
			
			if($image_rte->writeImage( $_fle_exts->rpth )){	
				$_sve = $_aws->_s3_put([ 'b'=>'fle', 'fle'=>_TmpFixDir($Th_Fld), 'src'=>$Th_Fld, 'ctp'=>mime_content_type($Th_Fld), 'cfr'=>'ok' ]);		
			}
			
			$image_rte->clear();
			$image_rte->destroy();
			
			$rsp['e'] = 'ok'; 
			$rsp['m'] = 1;

		}
		
	}elseif(($_POST['x']!='')&&($_POST['y']!='')&&($_POST['w']!='')&&($_POST['h']!='')&&($Tot_Dt_Img==1)){
		
		if((isset($_POST['Sz_Th']))&&($_POST['Sz_Th'] != '')){
			$Th_W = $_POST['Sz_Th'];
			$Th_H = $_POST['Sz_Th'];
		}else{
			$Th_W = $_POST['w'];
			$Th_H = $_POST['h'];
		}
		
		$Th_Q = 100;
			
		$Th_N = /*$_POST['t'].'_'.*/$row_Dt_Img[$_POST['id_el']];
		$Th_Nm = /*$_POST['t'].'_'.*/$row_Dt_Img[$_POST['id_el']];
		$Th_Fld = $__p_drim;

		if( !isN( pathinfo($Th_Fld, PATHINFO_EXTENSION) ) ){
			$Th_Src = $Th_Fld; 
		}else{
			$Th_Src = $Th_Fld.$Th_N.'.jpg'; 
		}	
		
		$Th_FRl = dirname(__FILE__, 6).'/';
		$Th_NwP = $Th_Fld.'th/'.$Th_Nm.'.jpg';
		$Th_Nw = $Th_FRl.$Th_NwP;

		if($_NoTh != 'ok'){	

			$rsp['e'] = 'ok';

			$Th_Wrt = $__p_drim;
			$_fle_exts = $_fle->_ExstO([ 'lcl_u'=>'ok', 'path'=>$Th_Wrt, 'path_o'=>$Th_Src ]);

			if($_fle_exts->e == 'ok' && $_fle_exts->get->e == 'ok'){
	
				if(isset($_POST['i']) && !isN($__p_eccmz)){ 
					//$rsp['u_o'] = __AutoRUN([ 't'=>'ec', 's2'=>'ec_cmz', 'id'=>$_POST['i'] ]); 
				
					$__ec_cmz->ec_cmz = $_POST['i'];
					$rsp['upd_cod'] = $_upd_cod = $__ec_cmz->_bld_ec([ 'cche'=>'ok' ]);

					if($_upd_cod->e == 'ok'){
					}
				}
				
				$rsp['pth'] = $Th_Nw;
				//$rsp['src'] = $Th_Src;
						
				// Croppped
				$image_crp = new Imagick( $_fle_exts->rpth_o );
				$image_crp->setImageFormat ("jpeg");
				$image_crp->cropImage($_POST['w'], $_POST['h'], $_POST['x'], $_POST['y']);
				
				if($image_crp->writeImage($Th_Nw)){
					$_sve = $_aws->_s3_put([ 
								'b'=>'fle', 
								'fle'=>_TmpFixDir($Th_NwP), 
								'src'=>$Th_Nw, 
								'ctp'=>mime_content_type($Th_Nw), 
								'cfr'=>'ok'
							]);	
					
					if($_sve->e != 'ok'){ $rsp['e'] = 'no'; }
				}
				
				$image_crp->clear();
				$image_crp->destroy();
				
				
				// Original
				$image_nr = new Imagick($Th_Nw);
				$image_nr->setImageFormat ("jpeg");
				$image_nr->setImageCompression(imagick::COMPRESSION_JPEG);
				$image_nr->setImageCompressionQuality(90);
				$image_nr->thumbnailImage($_POST['w'], 0);
				
				if($image_nr->writeImage($Th_Nw)){
					$_sve = $_aws->_s3_put([ 
						'b'=>'fle', 
						'fle'=>_TmpFixDir($Th_Nw), 
						'src'=>$Th_Nw, 
						'ctp'=>mime_content_type($Th_Nw), 
						'cfr'=>'ok'
					]);	
					if($_sve->e != 'ok'){ $rsp['e'] = 'no'; }
				}
				
				$image_nr->clear();
				$image_nr->destroy();	
				
				// Thumbnail 50
				$mask_thp = new Imagick('mask.png');
				$mask_thp->thumbnailImage(50, 0);
				$mask_thp_t = new Imagick('mask2.png');
				$mask_thp_t->thumbnailImage(100, 0);
				$image_thp = new Imagick($Th_Nw);
				$image_thp->setImageFormat ("jpeg");
				$image_thp->setImageCompression(imagick::COMPRESSION_JPEG);
				$image_thp->setImageCompressionQuality(0.3);
				$image_thp->thumbnailImage(50, 0);
				
				$image_thp_50 = $Th_FRl.$Th_Fld.'th/'.$Th_Nm.'x50.jpg';

				if($image_thp->writeImage( $image_thp_50 )){
					$_sve = $_aws->_s3_put([ 
									'b'=>'fle', 
									'fle'=>_TmpFixDir($image_thp_50), 
									'src'=>$image_thp_50, 
									'ctp'=>mime_content_type($image_thp_50), 
									'cfr'=>'ok'
								]);	
					if($_sve->e != 'ok'){ $rsp['e'] = 'no'; }			
				}
				
				
				$image_thp->compositeImage($mask_thp, Imagick::COMPOSITE_DEFAULT, 0, 0);
				
				$image_thp_c_50 = $Th_FRl.$Th_Fld.'th/'.$Th_Nm.'_c_x50.jpg';

				if($image_thp->writeImage($image_thp_c_50)){
					$_sve = $_aws->_s3_put([ 
									'b'=>'fle', 
									'fle'=>_TmpFixDir($image_thp_c_50), 
									'src'=>$image_thp_c_50, 
									'ctp'=>mime_content_type($image_thp_c_50),
									'cfr'=>'ok'
								]);
					if($_sve->e != 'ok'){ $rsp['e'] = 'no'; }			
				}
				
				
				$image_thp->compositeImage($mask_thp_t, Imagick::COMPOSITE_DSTIN, 0, 0, Imagick::CHANNEL_ALPHA);
				
				$image_thp_c_50_png = $Th_FRl.$Th_Fld.'th/'.$Th_Nm.'_c_x50.png';

				if($image_thp->writeImage($image_thp_c_50_png)){
					$_sve = $_aws->_s3_put([ 
							'b'=>'fle', 
							'fle'=>_TmpFixDir($image_thp_c_50_png), 
							'src'=>$image_thp_c_50_png, 
							'ctp'=>mime_content_type($image_thp_c_50_png), 
							'cfr'=>'ok'
						]);
					if($_sve->e != 'ok'){ $rsp['e'] = 'no'; }	
				}
				

				$image_thp->clear();
				$image_thp->destroy();
				
				
				// Thumbnail 100
				$mask_th = new Imagick('mask.png');
				$mask_th->thumbnailImage(100, 0);
				$mask_th_t = new Imagick('mask2.png');
				$mask_th_t->thumbnailImage(100, 0);
				$image_th = new Imagick($Th_Nw);
				$image_th->setImageFormat ("jpeg");
				$image_th->setImageCompression(imagick::COMPRESSION_JPEG);
				$image_th->setImageCompressionQuality(0.3);
				$image_th->thumbnailImage(100, 0);
				
				$image_thp_100 = $Th_FRl.$Th_Fld.'th/'.$Th_Nm.'x100.jpg';
				if($image_th->writeImage($image_thp_100)){
					$_sve = $_aws->_s3_put([ 
								'b'=>'fle', 
								'fle'=>_TmpFixDir($image_thp_100), 
								'src'=>$image_thp_100, 
								'ctp'=>mime_content_type($image_thp_100), 
								'cfr'=>'ok' 
							]);
					if($_sve->e != 'ok'){ $rsp['e'] = 'no'; }		
				}
				
				$image_th->compositeImage($mask_th, Imagick::COMPOSITE_DEFAULT, 0, 0);
				
				$image_thp_c_100 = $Th_FRl.$Th_Fld.'th/'.$Th_Nm.'_c_x100.jpg';
				if($image_th->writeImage($image_thp_c_100)){
					$_sve = $_aws->_s3_put([ 
								'b'=>'fle', 
								'fle'=>_TmpFixDir($image_thp_c_100), 
								'src'=>$image_thp_c_100, 
								'ctp'=>mime_content_type($image_thp_c_100), 
								'cfr'=>'ok'
					]);
					if($_sve->e != 'ok'){ $rsp['e'] = 'no'; }
				}
				
				$image_th->compositeImage($mask_th_t, Imagick::COMPOSITE_DSTIN, 0, 0, Imagick::CHANNEL_ALPHA);
				
				$image_thp_c_100_png = $Th_FRl.$Th_Fld.'th/'.$Th_Nm.'_c_x100.png';
				if($image_th->writeImage($image_thp_c_100_png)){
					$_sve = $_aws->_s3_put([ 
								'b'=>'fle', 
								'fle'=>_TmpFixDir($image_thp_c_100_png), 
								'src'=>$image_thp_c_100_png, 
								'ctp'=>mime_content_type($image_thp_c_100_png), 
								'cfr'=>'ok'
					]);
					if($_sve->e != 'ok'){ $rsp['e'] = 'no'; }	
				}
				
				$image_th->clear();
				$image_th->destroy();	
				
				
				// Thumbnail 200
				$mask_md = new Imagick('mask.png');
				$mask_md->thumbnailImage(200, 0);
				$mask_md_t = new Imagick('mask2.png');
				$mask_md_t->thumbnailImage(200, 0);
				$image_md = new Imagick($Th_Nw);
				$image_md->setImageFormat ("jpeg");
				$image_md->setImageCompression(imagick::COMPRESSION_JPEG);
				$image_md->setImageCompressionQuality(0.3);
				$image_md->thumbnailImage(200, 0);
				
				$image_thp_200 = $Th_FRl.$Th_Fld.'th/'.$Th_Nm.'x200.jpg';
				if($image_md->writeImage($image_thp_200)){
					$_sve = $_aws->_s3_put([ 
								'b'=>'fle', 
								'fle'=>_TmpFixDir($image_thp_200), 
								'src'=>$image_thp_200, 
								'ctp'=>mime_content_type($image_thp_200), 
								'cfr'=>'ok'
							]);
					if($_sve->e != 'ok'){ $rsp['e'] = 'no'; }		
				}
				
				$image_md->compositeImage($mask_md, Imagick::COMPOSITE_DEFAULT, 0, 0);
				
				$image_thp_c_200 = $Th_FRl.$Th_Fld.'th/'.$Th_Nm.'_c_x200.jpg';
				if($image_md->writeImage($image_thp_c_200)){
					$_sve = $_aws->_s3_put([ 
								'b'=>'fle', 
								'fle'=>_TmpFixDir($image_thp_c_200), 
								'src'=>$image_thp_c_200, 
								'ctp'=>mime_content_type($image_thp_c_200), 
								'cfr'=>'ok'
					]);
					if($_sve->e != 'ok'){ $rsp['e'] = 'no'; }
				}
				
				$image_md->compositeImage($mask_md_t, Imagick::COMPOSITE_DSTIN, 0, 0, Imagick::CHANNEL_ALPHA);
				
				$image_thp_c_200_png = $Th_FRl.$Th_Fld.'th/'.$Th_Nm.'_c_x200.png';
				if($image_md->writeImage($image_thp_c_200_png)){
					$_sve = $_aws->_s3_put([ 
								'b'=>'fle', 
								'fle'=>_TmpFixDir($image_thp_c_200_png), 
								'src'=>$image_thp_c_200_png, 
								'ctp'=>mime_content_type($image_thp_c_200_png), 
								'cfr'=>'ok'
							]);
					if($_sve->e != 'ok'){ $rsp['e'] = 'no'; }		
				}
				
				$image_md->clear();
				$image_md->destroy();
				
				
				
				// Thumbnail 400
				$mask_bg = new Imagick('mask.png');
				$mask_bg->thumbnailImage(400, 0);
				$mask_bg_t = new Imagick('mask2.png');
				$mask_bg_t->thumbnailImage(400, 0);
				$image_bg = new Imagick($Th_Nw);
				$image_bg->setImageFormat ("jpeg");
				$image_bg->setImageCompression(imagick::COMPRESSION_JPEG);
				$image_bg->setImageCompressionQuality(0.3);
				$image_bg->thumbnailImage(400, 0);
				
				
				$image_thp_400 = $Th_FRl.$Th_Fld.'th/'.$Th_Nm.'x400.jpg';
				if($image_bg->writeImage($image_thp_400)){
					$_sve = $_aws->_s3_put([ 
								'b'=>'fle', 
								'fle'=>_TmpFixDir($image_thp_400), 
								'src'=>$image_thp_400, 
								'ctp'=>mime_content_type($image_thp_400), 
								'cfr'=>'ok'
					]);
					if($_sve->e != 'ok'){ $rsp['e'] = 'no'; }
				}
				
				$image_bg->compositeImage($mask_bg, Imagick::COMPOSITE_DEFAULT, 0, 0);
				
				$image_thp_c_400 = $Th_FRl.$Th_Fld.'th/'.$Th_Nm.'_c_x400.jpg';

				if($image_bg->writeImage($image_thp_c_400)){
					$_sve = $_aws->_s3_put([ 
								'b'=>'fle', 
								'fle'=>_TmpFixDir($image_thp_c_400), 
								'src'=>$image_thp_c_400, 
								'ctp'=>mime_content_type($image_thp_c_400), 
								'cfr'=>'ok'
					]);
					if($_sve->e != 'ok'){ $rsp['e'] = 'no'; }
				}
				
				$image_bg->compositeImage($mask_bg_t, Imagick::COMPOSITE_DSTIN, 0, 0, Imagick::CHANNEL_ALPHA);
				
				$image_thp_c_400_png = $Th_FRl.$Th_Fld.'th/'.$Th_Nm.'_c_x400.png';
				if($image_bg->writeImage($image_thp_c_400_png)){
					$_sve = $_aws->_s3_put([ 
								'b'=>'fle', 
								'fle'=>_TmpFixDir($image_thp_c_400_png), 
								'src'=>$image_thp_c_400_png, 
								'ctp'=>mime_content_type($image_thp_c_400_png), 
								'cfr'=>'ok' 
					]);
					if($_sve->e != 'ok'){ $rsp['e'] = 'no'; }
				}
				
				$image_bg->clear();
				$image_bg->destroy();
				
			}
				

		}else{
			
			
			$updateSQL = sprintf("UPDATE "._BdStr(DBM).TB_EC_CMZ_IMG." SET eccmzimg_w=%s, eccmzimg_h=%s, eccmzimg_x=%s, eccmzimg_x2=%s, eccmzimg_y=%s, eccmzimg_y2=%s WHERE id_eccmzimg=%s",
					   	 GtSQLVlStr( $_POST['w'] , "int"),
					   	 GtSQLVlStr( $_POST['h'] , "int"),
					   	 GtSQLVlStr( $_POST['x'] , "int"),
					   	 GtSQLVlStr( $_POST['x2'] , "int"),
					   	 GtSQLVlStr( $_POST['y'] , "int"),
					   	 GtSQLVlStr( $_POST['y2'] , "int"),
					   	 GtSQLVlStr( $_POST['i'] , "int")); 

			$Result = $__cnx->_prc($updateSQL);
			
			if($Result){
			
				$__ext = pathinfo($__p_drim, PATHINFO_EXTENSION);
				
				$Th_Wrt = $__p_drim;
				$Th_Fld = str_replace('.'.$__ext,'_o.'.$__ext, $__p_drim);	
				$_fle_exts = $_fle->_ExstO([ 'lcl_u'=>'ok', 'path'=>$Th_Wrt, 'path_o'=>$Th_Fld ]);
				
				if($_fle_exts->e == 'ok' && $_fle_exts->get->e == 'ok'){
		
					//$rsp['cut'] = $Th_Fld;
					//$rsp['wrt'] = $Th_Wrt;
		
					// Croppped
					$image_crp = new Imagick( $_fle_exts->rpth_o );
					$image_crp->setImageFormat ("jpeg");
					$image_crp->cropImage($_POST['w'], $_POST['h'], $_POST['x'], $_POST['y']);
					
					if($image_crp->writeImage($_fle_exts->rpth)){
						$_sve = $rsp['sve_cut'] = $_aws->_s3_put([ 'b'=>'fle', 'fle'=>$_fle_exts->rpth_sve, 'src'=>$_fle_exts->rpth, 'ctp'=>mime_content_type($_fle_exts->rpth), 'cfr'=>'ok' ]);
					}	
					
					$image_crp->clear();
					$image_crp->destroy();
					
					if($_sve->e == 'ok'){
						if(!isN($__p_eccmz)){
							//$rsp['u_o'] = __AutoRUN([ 't'=>'ec', 's2'=>'ec_cmz', 'id'=>$__p_eccmz, '_fst'=>'ok' ]);
							
							$__ec_cmz->ec_cmz = $__p_eccmz;
							$rsp['upd_cod'] = $_upd_cod = $__ec_cmz->_bld_ec([ 'cche'=>'ok' ]);

							if($_upd_cod->e == 'ok'){
								$rsp['e'] = 'ok'; 
								$rsp['m'] = 1;	
							}
						}	
					}				
			
				}
			
			}else{

				$rsp['w'] = $__cnx->c_p->error;

			}

		}
									
									
		
		
		
		
			
	}else{
		
		$rsp['e'] = 'no'; $rsp['m'] = 2;
		
	}
	
	$__cnx->_clsr($Dt_Img);
	
//}
Hdr_JSON();
$rtrn = json_encode($rsp); echo $rtrn;
?>