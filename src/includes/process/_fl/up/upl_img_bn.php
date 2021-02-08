<?php //if(ChckSESS_adm()){ 
	
	//@ini_set('display_errors', true); 
	//error_reporting(E_ALL & ~E_NOTICE);

	if(isset($_POST['bdsrc'])&&($_POST['bdsrc'] == 'bst')){ $_sqlbd = DB_BST;}else{$_sqlbd = DB;}
	
	
	if(!isN($_POST['bd_el']) && !isN($_POST['id_el'])){
		
		global $__cnx;
		
		if(!isN($_POST['bd_cl'])){ $_prfx_bd = DB_CL.'.'; }
		
		$colname_Dt_Img = "-1"; if (isset($_POST['i'])){$colname_Dt_Img = $_POST['i'];}
		$Dt_Qry = sprintf("SELECT * FROM ".$_prfx_bd.$_POST['bd_el']." WHERE ".$_POST['id_el']." = %s LIMIT 1", GtSQLVlStr($colname_Dt_Img, "text"));
		$Dt_Img = $__cnx->_qry($Dt_Qry); 
		
		
		//$rsp['q'] = $Dt_Qry;
		
		if($Dt_Img){
			$row_Dt_Img = $Dt_Img->fetch_assoc(); 
			$Tot_Dt_Img = $Dt_Img->num_rows;
		}else{
			$rsp['w'] = $Dt_Qry.HTML_BR.$__cnx->c_r->error; 	
		}	
		
		$__cnx->_clsr($Dt_Img);
	}
	
	if( ($_POST['x']!='') && ($_POST['y']!='') && !isN($_POST['w']) && !isN($_POST['h']) && $Tot_Dt_Img==1){
		
		
		if((isset($_POST['Sz_Bn']))&&($_POST['Sz_Bn'] != '')){
			$Bn_W = $_POST['Sz_Bn'];
			$Bn_H = $_POST['Sz_Bn'];
		}else{
			$Bn_W = $_POST['w'];
			$Bn_H = $_POST['h'];
		}
		$Bn_Q = 100;
		
		
		$Th_FRl = dirname(__FILE__, 6).'/';
		$Bn_Nm = $row_Dt_Img[$_POST['ImNm']];
		$Bn_Fld = $Th_FRl.$_POST['dr_im'];
		$Bn_Src = $Bn_Fld.$Bn_Nm; 
		
		$Bn_Nw_Nm = $row_Dt_Img[$_POST['id_el']];
		$Bn_Nw = $Bn_Fld.'bn/'.$Bn_Nw_Nm;
		
		
		$rsp['src'] = $Bn_Src;
		
		
		if(file_exists($Bn_Src)){
			
			$Bn_Src_Img = imagecreatefromjpeg($Bn_Src);
			$Bn_Nw_Img = imagecreatefromjpeg($Bn_Nw);
			$Bn_Nw_Bn = imagecreatetruecolor( $Bn_W, $Bn_H );
		
			imagecopyresampled($Bn_Nw_Bn,$Bn_Src_Img,0,0,$_POST['x'],$_POST['y'],$Bn_W,$Bn_H,$_POST['w'],$_POST['h']);
			imagejpeg($Bn_Nw_Bn,$Bn_Nw,$Bn_Q);
		
		
				// Original
				$image_nr = new Imagick($Bn_Nw);
				$image_nr->setImageFormat ("jpeg");
				$image_nr->setImageCompression(imagick::COMPRESSION_JPEG);
				$image_nr->setImageCompressionQuality(0.9);
				$image_nr->thumbnailImage($_POST['w'], 0);

				if($image_nr->writeImage($Bn_Nw)){	
					$rsp['sve']['standard'] = $_sve = $_aws->_s3_put([ 'b'=>'fle', 'fle'=>_TmpFixDir($Bn_Fld), 'src'=>$Bn_Fld, 'ctp'=>mime_content_type($Bn_Fld), 'cfr'=>'ok' ]);		
				}

				$image_nr->clear();
				$image_nr->destroy();	


				// Thumbnail 200
				$image_bn = new Imagick($Bn_Nw);
				$image_bn->setImageFormat ("jpeg");
				$image_bn->setImageCompression(imagick::COMPRESSION_JPEG);
				$image_bn->setImageCompressionQuality(0.7);
				$image_bn->thumbnailImage(200, 0);

				$rsp['tmp200'] = $image_bn_200 = $Bn_Fld.'bn/'.$Bn_Nw_Nm.'x200.jpg';

				if($image_bn->writeImage($image_bn_200)){

					$rsp['sve']['200'] = $_sve = $_aws->_s3_put([ 
											'b'=>'fle', 
											'fle'=>_TmpFixDir($image_bn_200), 
											'src'=>$image_bn_200, 
											'ctp'=>mime_content_type($image_bn_200),
											'cfr'=>'ok'
										]);

					if($_sve->e != 'ok'){ $rsp['e'] = 'no'; }	

				}
				
				$image_bn->clear();
				$image_bn->destroy();	
				
				// Thumbnail 400
				$image_md = new Imagick($Bn_Nw);
				$image_md->setImageFormat ("jpeg");
				$image_md->setImageCompression(imagick::COMPRESSION_JPEG);
				$image_md->setImageCompressionQuality(0.7);
				$image_md->thumbnailImage(400, 0);
				$image_bn_400 = $Bn_Fld.'bn/'.$Bn_Nw_Nm.'x400.jpg';

				if($image_md->writeImage($image_bn_400)){

					$rsp['sve']['400'] = $_sve = $_aws->_s3_put([ 
											'b'=>'fle', 
											'fle'=>_TmpFixDir($image_bn_400), 
											'src'=>$image_bn_400, 
											'ctp'=>mime_content_type($image_bn_400),
											'cfr'=>'ok'
										]);

					if($_sve->e != 'ok'){ $rsp['e'] = 'no'; }	

				}

				$image_md->clear();
				$image_md->destroy();
				
				// Thumbnail 800
				$image_bg = new Imagick($Bn_Nw);
				$image_bg->setImageFormat ("jpeg");
				$image_bg->setImageCompression(imagick::COMPRESSION_JPEG);
				$image_bg->setImageCompressionQuality(0.7);
				$image_bg->thumbnailImage(800, 0);
				$image_bn_800 = $Bn_Fld.'bn/'.$Bn_Nw_Nm.'x800.jpg';

				if($image_bg->writeImage($image_bn_800)){
					
					$rsp['sve']['800'] = $_sve = $_aws->_s3_put([ 
											'b'=>'fle', 
											'fle'=>_TmpFixDir($image_bn_800), 
											'src'=>$image_bn_800, 
											'ctp'=>mime_content_type($image_bn_800),
											'cfr'=>'ok'
										]);

					if($_sve->e != 'ok'){ $rsp['e'] = 'no'; }

				}

				$image_bg->clear();
				$image_bg->destroy();
		
				$rsp['e'] = 'ok'; $rsp['m'] = 1;
		
		
		}else{
			
			$rsp['w'] = $Bn_Src.' not exist';
			
		}
		
		
	}else{
		
		$rsp['e'] = 'no'; $rsp['m'] = 2; $rsp['w'] = 'no all data';
		
	}
	
//}
Hdr_JSON();
$rtrn = json_encode($rsp); echo $rtrn;
?>