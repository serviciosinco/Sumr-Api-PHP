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
				
					
			$Sch =[DMN_BS];
			$Chn = [''];
			$allowed = ['ZIP', 'zip'];
			
			
			$__id = Php_Ls_Cln($_POST['_id']); 
			$__lnd_dt = GtDt_HSHTwD($__id, 'enc');
			
			
			if($__lnd_dt->dsgn == 1){
				$_tp = '_v/';	
			}elseif($__lnd_dt->dsgn == 4){
				$_tp = '_h/';	
			}
			
			
			$__dir_pth = '../../../'.DIR_FLE_TW_HTML.$_tp;	
 
				
			if(isset($_FILES['upl']) && $_FILES['upl']['error'] == 0 && $__lnd_dt->id != NULL){
				$extension = pathinfo($_FILES['upl']['name'], PATHINFO_EXTENSION);
				
				
				if(!in_array(strtolower($extension), $allowed)){
					$rsp['status'] = 'errorf';
				}else{	
						
					$rsp['statadasdus'] = in_array(strtolower($extension), $allowed);	
							
					if (!is_dir($__dir_pth) && !isN($__lnd_dt->dir)){
					    mkdir($__dir_pth,0777);
					    chmod($__dir_pth,0777);
					}
						
						
						if (is_dir($__dir_pth) && !isN($__lnd_dt->id)){

							$__fl_tt = $_POST['_nm'].'_'.$_i;
							$__fl_nm = $_FILES['upl']['name'];
							$__tmp_nm = $_FILES['upl']['tmp_name'];
							$__nw_nm = 'srcall'.'.'.$extension;
							$__nw_zip = $__dir_pth.'/'.$__nw_nm;
							
							
							$__nw_fles = glob($__dir_pth.'/*');
							
							foreach($__nw_fles as $file){
							  	
							  	chmod($file, 0777);
							  	
							  	if(is_file($file)){
							    	//$rsp[$file] = 'Delete File:'.unlink($file);
							    }elseif(is_dir($file)){
								    //$rsp[$file] = 'Delete Folder:'. deleteDir($file.'/');
							    }
							    
							}
							
							if(move_uploaded_file($__tmp_nm, $__nw_zip)){
								
								$zip = new ZipArchive;
								
								if ($zip->open($__nw_zip) === TRUE) {
								  
								  	for($i = 0; $i < $zip->numFiles; $i++) {
									  	
									  	$filename = $zip->getNameIndex($i);
									  	$fileinfo = pathinfo($filename);
									  	$filepth = $__dir_pth.'/'.$zip->getNameIndex($i);
									  	
									  	$rsp['ismacos_fle'][] = $zip->getNameIndex($i);
									  	$rsp['ismacos'][] = strpos($zip->getNameIndex($i), '__MACOSX');
									  	
									  	if(!strpos($zip->getNameIndex($i), '__MACOSX') && !strpos($filepth, '__MACOSX')){
								        	
								        	$rsp['ex'][] = $zip->getNameIndex($i);
								        	$zip->extractTo($__dir_pth.'/', [$zip->getNameIndex($i)]);
								        	
								        	if(is_file( $filepth )){
												
												try{	
												
													$_sve = $_aws->_s3_put([ 'b'=>'fle', 'fle'=>_TmpFixDir($filepth), 'src'=>$filepth, 'ctp'=>mime_content_type($filepth), 'cfr'=>'ok' ]);
													$rsp['aws']['fle'][] = [ 'src'=>$filepth, 'sve'=>$_sve, 'rmte'=>_TmpFixDir($filepth) ];
												
												}catch(Exception $e){
		
													$rsp['e'] = 'no';
													$rsp['w'] = $e->getMessage();
													break;
													
												}
												
											}
											
										}
										
								    }
								                    
								    $zip->close();   
									$rsp['zip'] = 'ok';
								  
									$__nw_fles_zip = glob($__dir_pth.'/*');
									
									foreach($__nw_fles_zip as $file_zip){
									  	
									  	if(is_file($file_zip) || is_dir($file_zip)){ 
										
											chmod($file_zip,0777);
									    }
								    }
							
								} else {
								  $rsp['zip'] = 'no';
								}


								$rsp['status'] = 'success';	
								$rsp['status_1'] = $__dir_pth;	
								
							}else{
								
								$rsp['status'] = 'error';
								$rsp['error'] = 'no se movio';
								
							}
							
						}else{
							
							$rsp['status'] = 'error';
							$rsp['error'] = 'problemas con folder dd ->'.$__tmp_nm.' <-> '.$__nw_zip;
							
						}
					}
			}else{
				$rsp['status'] = 'errorx';
				$rsp['error_q'] = isset($_FILES['upl']).'<-->'.$_FILES['upl']['error'].'<<-->>'.$__lnd_dt->dir.'<<<-->>>'.$__id.'<<<<--->>>>'.$__lnd_dt->ids;
			}
				
		}
	}else{
		$rsp['e'] = 'no'; $rsp['m'] = 2; $rsp['adasd']= 'jjfjfjf';	
	}

	Hdr_JSON();
	$rtrn = json_encode($rsp); echo $rtrn;
}
?>