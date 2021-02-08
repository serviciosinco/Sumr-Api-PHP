<?php 	
	
	// HASSSS TO FIXXXX ALL UPLOAD PROCESS
	
/*	
if(ChckSESS_usr()){ 
	
	
	$_fle = new CRM_Fle();
	
	
	if (((isset($_POST['MM_update_fle']))&&($_POST['MM_update_fle'] == 'FleUplNw'))) {
		
			
		if (!empty($_FILES)) {
				
			
			$Sch = [DMN_BS];
			$Chn = [''];
			$allowed = ['ZIP', 'zip'];
			
			
			$__id = Php_Ls_Cln($_POST['_id']);
			$__bn_dt = GtBnDt($__id, 'enc');
			$__dir_pth = '../../../'.DIR_FLE_BN_HTML.$__bn_dt->dir;		
			
			
			$_fle->_nw_fld = DIR_FLE_BN_HTML.$__bn_dt->dir;
			$_fle->_tt = 'srcall';
			$_fle->_srce = $_FILES;
			$_flem = $_fle->_SumrToFle();
			$_NEW = $_flem->sze;
					
				
				
			if(isset($_FILES['upl']) && $_FILES['upl']['error'] == 0 && $__bn_dt->dir != NULL){
				
				$extension = pathinfo($_FILES['upl']['name'], PATHINFO_EXTENSION);
				
				if(!in_array(strtolower($extension), $allowed)){
					
					$rsp['status'] = 'error';
					
				}else{	
							
						
					if(is_dir($__dir_pth) && !isN($__bn_dt->dir)){
	
						$__fl_tt = $_POST['_nm'].'_'.$_i;
						$__fl_nm = $_FILES['upl']['name'];
						$__tmp_nm = $_FILES['upl']['tmp_name'];
						$__nw_nm = 'srcall'.'.'.$extension;
						$__nw_zip = $__dir_pth.'/'.$__nw_nm;

						
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
											
												$_sve = $_aws->_s3_put([ 'b'=>'fle', 'fle'=>_TmpFixDir($filepth), 'src'=>$filepth, 'ctp'=>mime_content_type($filepth) ]);
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
							
						}else{
							
							$rsp['status'] = 'error';
							$rsp['error'] = 'no se movio';
							
						}
						
					}else{
						
						$rsp['status'] = 'error';
						$rsp['error'] = 'problemas con folder';
						
					}
				}
					
			}else{
				
				$rsp['status'] = 'error';
				
			}
				
		}
			
	}else{
		
		$rsp['e'] = 'no'; $rsp['m'] = 2;
		
	}		
		
}


Hdr_JSON();
$rtrn = json_encode($rsp); 
echo $rtrn;
*/

?>