<?php 

//@ini_set('display_errors', true); 
//error_reporting(E_ALL);
$__ec_cmz = new API_CRM_ec_Cmz();			

$__max_w = Php_Ls_Cln($_REQUEST['maxw']);
$__max_h = Php_Ls_Cln($_REQUEST['maxh']);
$__max_d = Php_Ls_Cln($_REQUEST['maxd']);

if($_REQUEST['maxd'] != ''){ $__max_d = Php_Ls_Cln($_REQUEST['maxd']); }else{ $__max_d = 1; }


if(ChckSESS_usr()){ 
	
  	if(((isset($_POST['MM_update']))&&($_POST['MM_update'] == 'ImgUpl'))) {
	  
		if (!empty($_FILES)) {
			
			$Sch = array(DMN_BS);
			$Chn = array('');
			$Fldr_Rl = str_replace($Sch,$Chn,$_POST['_dr']);
			$allowed = array('jpeg', 'jpg', 'png');
			
			
			$rsp['file'] = $_FILES;
			
			if(isset($_FILES['upl']) && $_FILES['upl']['error'] == 0){
				
				$extension = strtolower( pathinfo($_FILES['upl']['name'], PATHINFO_EXTENSION) );
				
					if(!in_array(strtolower($extension), $allowed)){
						
						$rsp['status'] = 'error';
					
					}else{
						
						
						if($_POST['_tp'] == 'cmz'){	
							
							$_chk_img = ChkEcCmzImg([ 'eccmz'=>$_POST['id_eccmz'], 'img'=>$_POST['id_img'] ]);							
							
							$rsp['dt']['chk_img'] = $_chk_img;
							
							if($_chk_img->r != 'ok'){
								
								if(!isN($_POST['_bd_cl'])){ 
									$_prfx_bd = DB_CL.'.'; 	
								}else{
									$_prfx_bd = _BdStr(DBM);
								}
								
								$insertSQL = sprintf("INSERT INTO ".$_prfx_bd.$_POST['_bd']." (eccmzimg_enc, eccmzimg_eccmz, eccmzimg_img, eccmzimg_us) VALUES (%s, %s, %s, %s)",
						                       GtSQLVlStr(Enc_Rnd($_POST['eccmzimg_eccmz'].'-'.$_POST['id_img']), "text"),
						                       GtSQLVlStr($_POST['id_eccmz'], "int"),
											   GtSQLVlStr($_POST['id_img'], "int"),
											   GtSQLVlStr(SISUS_ID, "int"));
							
								$Result = $__cnx->_prc($insertSQL);
								
								$_id_r = $__cnx->c_p->insert_id;
								
							}else{
								
								$_id_r = $_chk_img->id;
								$Result_Upd = true;
								
							}
							
							$_upd_fld = 'eccmzimg_fle';
							$_upd_id = 'id_eccmzimg';
							
							if($_chk_img->img->c != $__nw_nm){ 
								$id_upd = $_chk_img->id; 
							}else{ 
								$id_upd = $__cnx->c_p->insert_id; 
							}
							
							
						}elseif($_POST['_tp'] == 'cmz_hdr'){
							
							$_chk_hdr = ChkEcCmzHdr([ 'eccmz'=>$_POST['id_eccmz'] ]);								
							
							if($_chk_hdr->r != 'ok'){
								
								$insertSQL = sprintf("INSERT INTO "._BdStr(DBM).$_POST['_bd']." (eccmzhdr_enc, eccmzhdr_eccmz) VALUES (%s, %s)",
						                       GtSQLVlStr(Enc_Rnd($_POST['id_eccmz']), "text"),
						                       GtSQLVlStr($_POST['id_eccmz'], "int"));

								$Result = $__cnx->_prc($insertSQL);
								
								if($Result){
									$_id_r = $__cnx->c_p->insert_id;
									$rsp['tprc'] = 'in';
								}
								
							}else{
								
								$_id_r = $_chk_hdr->id;
								$Result_Upd = true;

							}
							
							$_upd_fld = 'eccmzhdr_fle';
							$_upd_id = 'id_eccmzhdr';
							
							if($_chk_hdr->img != $__nw_nm){ $id_upd = $_chk_hdr->id; }else{ $id_upd = $__cnx->c_p->insert_id; }
							
						}
						
						if(!isN($_id_r)){
							$__fl_tt = $_POST['_nm'].'_'.$_id_r;
							$__fl_nm = $_FILES['upl']['name'];
							$__tmp_nm = $_FILES['upl']['tmp_name'];
							$__nw_nm = $__fl_tt.'.'.$extension;
							$__nw_nm_o = $__fl_tt.'_o.'.$extension;
						}
						
						if(!isN($_id_r)){
						
							if($_POST['_pth'] == 'sis'){ 
								$__pth = dirname(dirname(dirname(dirname(dirname(__FILE__))))).'/'; 
							}else{ 
								$__pth = dirname(dirname(dirname(dirname(dirname(dirname(__FILE__)))))).'/'; 
							}
							
							$__nw_fld = $__pth.$Fldr_Rl;
							$__nw_fld_th = $__nw_fld.'th/';
							
							//$rsp['mve']['to'] = $__nw_fld.$__nw_nm;
							$rsp['mve']['o'] = $__nw_fld.$__nw_nm_o;
							
							try{	
								
								$_sve_o = $_aws->_s3_put([ 'b'=>'fle', 'fle'=>_TmpFixDir($Fldr_Rl.$__nw_nm_o), 'src'=>$__tmp_nm, 'ctp'=>mime_content_type($__tmp_nm), 'cfr'=>'ok' ]);
								$rsp['mve']['aws']['origin'] = [ 'p'=>$_sve_o, 'f'=>_TmpFixDir($Fldr_Rl.$__nw_nm_o) ];
									
							}catch(Exception $e){
								
								$rsp['w'][] = $e->getMessage();
							
							}
							
							if( move_uploaded_file($__tmp_nm, $__nw_fld.$__nw_nm_o) && $_sve_o->e == 'ok'){
								
								
								//$rsp['u_o'] = __AutoRUN([ 't'=>'ec', 's2'=>'ec_cmz', 'id'=>$_POST['id_eccmz'] ]);
								
								$__ec_cmz->ec_cmz = $_POST['id_eccmz'];
								/*$rsp['upd_cod'] = */$_upd_cod = $__ec_cmz->_bld_ec([ 'cche'=>'ok' ]);

								if($_upd_cod->e == 'ok'){
									//$rsp['e'] = 'ok';
								}

								$image_bd = new Imagick($__nw_fld.$__nw_nm_o);
								$image_bd_s = $image_bd->getImageGeometry();
								
								$__fl_w = $image_bd_s['width'];
								$__fl_h = $image_bd_s['height'];
								
								
								if(!isN($__max_w)){ $__fl_r_w = ($__max_w*$__max_d); }else{ $__fl_r_w = $image_bd_s['width']; }
								if(!isN($__max_h)){ $__fl_r_h = $__max_h; }else{ $__fl_r_h = 0; }
	
								if($__max_w > $__max_h){
									$__fl_r_w = ($__max_w*$__max_d);
								}else{
									$__fl_r_h = $__imgmh;
								}
								
								
								$rsp['sz']['w'] = $__fl_r_w;
								$rsp['sz']['h'] = $__fl_r_h;
								
								
								$__fl_b = $image_bd->getImageLength();
								
								$rsp['img']['w'] = $__fl_w;
								//$rsp['img']['f'] = $__nw_fld.$__nw_nm;
								//$rsp['img']['o'] = $__nw_fld.$__nw_nm_o;
								
								$rsp['img']['max']['w'] = $__fl_r_w;
								$rsp['img']['max']['h'] = $__fl_r_h;
								
								$rsp['img']['src']['id'] = $_id_r;
								$rsp['img']['src']['u']['n'] = DMN_FLE.str_replace(['_sb/ec/', DIR_TMP_FLE, DIR_TMP_BCO, '_fle/'],'',$Fldr_Rl).$__nw_nm;
								$rsp['img']['src']['u']['o'] = DMN_FLE.str_replace(['_sb/ec/', DIR_TMP_FLE, DIR_TMP_BCO, '_fle/'],'',$Fldr_Rl).$__nw_nm_o;
								$rsp['img']['src']['f'] = $Fldr_Rl.$__nw_nm;
								$rsp['img']['src']['o'] = DMN_FLE.str_replace(['_sb/ec/', DIR_TMP_FLE, DIR_TMP_BCO, '_fle/'],'',$Fldr_Rl).$__nw_nm_o;
								
								/*if($__fl_w > 600){*/
									
									
									$image_rszo = new Imagick($__nw_fld.$__nw_nm_o);
									$image_rszo->setImageFormat ("jpeg");
									$image_rszo->setImageCompression(imagick::COMPRESSION_JPEG);
									$image_rszo->setImageCompressionQuality(0);
									
									if($__fl_r_w > 0){
										$image_rszo->thumbnailImage($__fl_r_w, NULL);
										$rsp['cut']['w'] = 'ok';
										$rsp['cut']['s'] = $__fl_r_w;
									}elseif($__fl_r_h > 0){
										$image_rszo->thumbnailImage(NULL, $__fl_r_h);
										$rsp['cut']['h'] = 'ok';
										$rsp['cut']['s'] = $__fl_r_h;
									}
									
									if($image_rszo->writeImage($__nw_fld.$__nw_nm_o)){
									
										try{	
											$_sve = $_aws->_s3_put([ 'b'=>'fle', 'fle'=>_TmpFixDir($Fldr_Rl.$__nw_nm_o), 'src'=>$__nw_fld.$__nw_nm_o, 'ctp'=>mime_content_type($__nw_fld.$__nw_nm_o), 'cfr'=>'ok' ]);
											$rsp['mve']['aws']['cut'] = [ 'p'=>$_sve, 'f'=>_TmpFixDir($Fldr_Rl.$__nw_nm_o) ];	
										}catch(Exception $e){	
											$rsp['w'][] = $e->getMessage();	
										}
									
									}
									
									
									$image_rszo->clear();
									$image_rszo->destroy();
									
									
									$image_rsz = new Imagick($__nw_fld.$__nw_nm_o);
									$image_rsz->setImageFormat ("jpeg");
									$image_rsz->setImageCompression(imagick::COMPRESSION_JPEG);
									$image_rsz->setImageCompressionQuality(0.9);
									
									if($__fl_r_w > 0 /*&& $__fl_r_h > 0*/){
										$image_rsz->thumbnailImage($__fl_r_w, $__fl_r_h);
									}

									if($image_rsz->writeImage($__nw_fld.$__nw_nm)){
									
										try{	
											$_sve = $_aws->_s3_put([ 'b'=>'fle', 'fle'=>_TmpFixDir($Fldr_Rl.$__nw_nm), 'src'=>$__nw_fld.$__nw_nm, 'ctp'=>mime_content_type($__nw_fld.$__nw_nm), 'cfr'=>'ok' ]);
											$rsp['mve']['aws']['main'] = [ 'p'=>$_sve, 'f'=>_TmpFixDir($Fldr_Rl.$__nw_nm) ];	
										}catch(Exception $e){	
											$rsp['w'][] = $e->getMessage();	
										}
									
									}
									
									$image_rsz->clear();
									$image_rsz->destroy();
									
								/*}*/
								
						 		if(($Result || $_chk_img->img->c != $__nw_nm) && !isN($_upd_id) && !isN($id_upd)){
							 		
							 		
							 		if(!isN($_POST['_bd_cl'])){ 
								 		
										$_prfx_bd = DB_CL.'.';
										 	
									}else{
										
										$_prfx_bd = _BdStr(DBM);
										
									}
									
									
									$updateSQL = sprintf("UPDATE ".$_prfx_bd.$_POST['_bd']." SET ".$_upd_fld."=%s WHERE ".$_upd_id."=%s",
										   					GtSQLVlStr($__nw_nm, "text"),
										   					GtSQLVlStr($id_upd, "int"));	
										   					
									$Result_Upd = $__cnx->_prc($updateSQL);
									
									if($Result_Upd){
										$rsp['tprc'] = 'upd';
										//$rsp['q'] = $updateSQL;
									}	
										
								}else{
									
								}
								
								if(!$Result_Upd){ 
									_ErrSis([ 'p'=>$updateSQL, 'd'=>$__cnx->c_p->error ]); 
									//$rsp['q'] = $updateSQL.$__cnx->c_p->error;
									$rsp['status'] = 'error';
									$rsp['error'] = 'no se actualizo en BD';
								}else{
																		
									$rsp['w'][] = ' - Se movio a la carpeta:'; 
									$rsp['status'] = 'success';
									
								}	
							}else{
								
								$rsp['status'] = 'error';
								$rsp['error'] = 'no se movio archivo';

								if($_sve_o->e != 'ok'){
									$rsp['error_save'] = $_sve_o;
								}

								_ErrSis([ 'p'=>$updateSQL, 'd'=>$__cnx->c_p->error ]);
							}
						
						}else{
							
							$rsp['error'] = 'No Id Return';
							
						}
						
						
					}
						
			}else{
				
				$rsp['status'] = 'error';
				$rsp['error'] = 'no viene archivo en solicitud';
				_ErrSis([ 'p'=>$insertSQL, 'd'=>$__cnx->c_p->error ]);
				
				//$rsp['lerror'] = error_get_last();
				
			}
		}
		
	}else{
		
		$rsp['status'] = 'error'; $rsp['w'][] = 'No inicia el proceso'; $rsp['e'] = 'no'; $rsp['m'] = 2;	$rsp['jd'] = 'Update es:'.$_POST['MM_update'];
		
	}
}

Hdr_JSON();
$rtrn = json_encode($rsp); echo $rtrn;
?>