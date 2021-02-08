<?php if(ChckSESS_usr()){ 
	
	
	
	
function deleteDir($dir){
   if (substr($dir, strlen($dir)-1, 1) != '/'){
       $dir .= '/';
	   if ($handle = opendir($dir)) {
	       while ($obj = readdir($handle)){
	           if ($obj != '.' && $obj != '..'){
	               if (is_dir($dir.$obj)){
	                    if (!deleteDir($dir.$obj)){
	                       return false;
	                    }
	               } elseif (is_file($dir.$obj)){
	                    if (!unlink($dir.$obj)){
	                       return false;
	                    }
	               }
	           }
	       }
	
	       closedir($handle);
	
	       if (!@rmdir($dir)){
	           return false;
	       }else{
	       	   return true;
	       }
	   }
   }
   return false;
}


if (((isset($_POST['MM_update_fle']))&&($_POST['MM_update_fle'] == 'FleUplNw'))) {
		
	if (!empty($_FILES)) {
			
				
		$Sch = [DMN_BS];
		$Chn = [''];
		$Fldr_Rl = str_replace($Sch,$Chn,DIR_IMG_SIS_BCO);
		$allowed = ['ZIP', 'zip'];
		
		$__id = Php_Ls_Cln($_POST['_id']);
		$__ec_dt = GtSgnDt($__id, 'id');
		$__dir_pth = '../../_sb/sgn/fl/'.$__ec_dt->dir;	
		
		
		$rsp['path'] = $__dir_pth;
		
			
		if(isset($_FILES['upl']) && $_FILES['upl']['error'] == 0 && $__ec_dt->dir != NULL){
			$extension = pathinfo($_FILES['upl']['name'], PATHINFO_EXTENSION);
			
			
			if(!in_array(strtolower($extension), $allowed)){
				$rsp['status'] = 'error';
			}else{
						
						
						
						if (!is_dir($__dir_pth) && $__ec_dt->dir != NULL ){
							$rsp['status12'] = 123;
						    mkdir($__dir_pth,0777);
						    chmod($__dir_pth,0777);
						}
						
						$rsp['status1'] = $__dir_pth;
						$rsp['status2'] = $__ec_dt->dir;
						
						if (is_dir($__dir_pth) && $__ec_dt->dir != NULL ){

								$__fl_tt = $_POST['_nm'].'_'.$_i;
								$__fl_nm = $_FILES['upl']['name'];
								$__tmp_nm = $_FILES['upl']['tmp_name'];
								$__nw_nm = 'srcall'.'.'.$extension;
								$__nw_zip = $__dir_pth.'/'.$__nw_nm;
								
								
								$__nw_fles = glob($__dir_pth.'/*');
								
								
								foreach($__nw_fles as $file){
								  	
								  	chmod($file, 0777);
								  	
								  	if(is_file($file)){
								    	$rsp[$file] = 'Delete File:'.unlink($file);
								    }elseif(is_dir($file)){
									    $rsp[$file] = 'Delete Folder:'. deleteDir($file);
								    }
								    
								}
								
								if(move_uploaded_file($__tmp_nm, $__nw_zip)){
									
									$zip = new ZipArchive;
									if ($zip->open($__nw_zip) === TRUE) {
									  
									  	for($i = 0; $i < $zip->numFiles; $i++) {
										  	
										  	$filename = $zip->getNameIndex($i);
										  	$fileinfo = pathinfo($filename);
										  	$rsp['Nm:'.$filename] = 'ok';
										  	
										  	if($zip->getNameIndex($i) != '__MACOSX/'){
									        	$zip->extractTo($__dir_pth.'/', [$zip->getNameIndex($i)]);
											}
									    }
									                    
									    $zip->close();   
										$rsp['zip'] = 'ok';
									  
										$__nw_fles_zip = glob($__dir_pth.'/*');
										
										foreach($__nw_fles_zip as $file_zip){
											
										  	if(is_file($file_zip) || is_dir($file_zip)){ 
											  	
												chmod($file_zip,0777);
												
												if(is_file($file_zip)){
												
													try{	
													
														$_sve = $_aws->_s3_put([ 'b'=>'fle', 'fle'=>_TmpFixDir($file_zip), 'src'=>$file_zip, 'ctp'=>mime_content_type($file_zip) ]);
														$rsp['aws']['fle'][] = [ 'src'=>$file_zip, 'sve'=>$_sve, 'rmte'=>_TmpFixDir($file_zip) ];
													
													}catch(Exception $e){
			
														$rsp['e'] = 'no';
														$rsp['w'] = $e->getMessage();
														break;
														
													}													
													
												}
												
										    }
										    
									    }
								
									} else {
										
										$rsp['zip'] = 'no';
									  
									}

									$rsp['status'] = 'success';	
									
								}else{
									
									$rsp['status'] = 'error';
								
								}
								
						}else{
							
							$rsp['status'] = 'error';
							
						}
				}
				
		}else{
			
			$rsp['status'] = 'error';
		
		}
			
	}
		
		
}else{
	$rsp['e'] = 'no'; $rsp['m'] = 2;	
}

Hdr_JSON();
$rtrn = json_encode($rsp); echo $rtrn;


}


?>