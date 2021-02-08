<?php 

//@ini_set('display_errors', true); 
//error_reporting(E_ALL);

if(ChckSESS_usr()){ 
	
	
	$_fle = new CRM_Fle();
	
	
  	if (((isset($_POST['MM_update_fle']))&&($_POST['MM_update_fle'] == 'FleUplNw'))) {
	  
		if (!empty($_FILES)) {
				
					
			$Sch =[DMN_BS];
			$Chn = [''];
			$allowed = ['ZIP', 'zip', 'js', 'css', 'jpg', 'svg', 'png', 'html'];
			$__prndm = $_fle->RndmFldr();
			
			$__id = Php_Ls_Cln($_POST['_id']);
			$__app_dt = GtClAppDt([ 'id'=>$__id, 't'=>'enc'] );
			
			
			$__dir_upl = dirname(__FILE__, 6).'/'.DIR_TMP_FLE;
			$__dir_urnd = $__dir_upl.$__prndm;
			$__dir_pth = DIR_FLE_APP_HTML.$__app_dt->dir;	
			
			
				
			if(isset($_FILES['upl']) && $_FILES['upl']['error'] == 0 && $__app_dt->dir != NULL){
				
				$extension = pathinfo($_FILES['upl']['name'], PATHINFO_EXTENSION);
				
				if(!in_array(strtolower($extension), $allowed)){

					$rsp['status'] = 'error ';

				}else{	
						

					if (!is_dir($__dir_urnd) && !isN($__app_dt->dir)){
					    if( !mkdir($__dir_urnd,0777) ){ $rsp['tmp']['created_folder'] = 'ok'; }
					    if( !chmod($__dir_urnd,0777) ){ $rsp['tmp']['permission_folder'] = 'ok'; }
					}
					
					
					$rsp['__tmp']['urnd'] = $__dir_urnd;
					$rsp['__tmp']['dir'] = $__app_dt->dir;
					
					
					if (is_dir($__dir_urnd) && !isN($__app_dt->dir)){

						$__fl_tt = $_POST['_nm'].'_'.$_i;
						$__fl_nm = $_FILES['upl']['name'];
						$__tmp_nm = $_FILES['upl']['tmp_name'];
						
						if(strtolower($extension) == 'zip'){
							$__nw_nm = 'srcall'.'.'.$extension;
						}else{
							$__nw_nm = $__fl_nm;
						}

						$__nw_zip = $__dir_urnd.'/'.$__nw_nm;
						
						
						if(file_exists($__tmp_nm)){
							
							if(move_uploaded_file($__tmp_nm, $__nw_zip)){
								
								$zip = new ZipArchive;
								
								if ($zip->open($__nw_zip) === TRUE && strtolower($extension) == 'zip') {
								  
								  	for($i = 0; $i < $zip->numFiles; $i++) {
									  	
									  	$filename = $zip->getNameIndex($i);
									  	$fileinfo = pathinfo($filename);
									  	$filepth = $__dir_urnd.'/'.$zip->getNameIndex($i);
										$filepthaws = $__dir_pth.'/'.$zip->getNameIndex($i);
									  	
									  	$rsp['ismacos_fle'][] = $zip->getNameIndex($i);
									  	$rsp['ismacos'][] = strpos($zip->getNameIndex($i), '__MACOSX');
									  	
									  	if(!strpos($zip->getNameIndex($i), '__MACOSX') && !strpos($filepth, '__MACOSX')){
								        	
								        	$rsp['ex'][] = $zip->getNameIndex($i);
								        	$zip->extractTo($__dir_urnd.'/', [$zip->getNameIndex($i)]);
								        	
								        	if(is_file( $filepth )){
										  		
										  		try{
											  		
										  			$_sve = $_aws->_s3_put([ 'b'=>'fle', 'fle'=>_TmpFixDir($filepthaws), 'src'=>$filepth, 'ctp'=>Mme_C_Typ($filepth) ]); 
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
								  
									$__nw_fles_zip = glob($__dir_urnd.'/*');
									
									foreach($__nw_fles_zip as $file_zip){
										
									  	if(is_file($file_zip) || is_dir($file_zip)){
										  	
											chmod($file_zip,0777);
											
									    }
									    
								    }
							
								} else {

									$_sve = $_aws->_s3_put([ 'b'=>'fle', 'fle'=>_TmpFixDir($__dir_pth.'/'.$__fl_nm), 'src'=>$__nw_zip, 'ctp'=>Mme_C_Typ($__nw_zip) ]); 

									$rsp['aws']['fle'] = [ 'src'=>$__nw_zip, 'sve'=>$_sve, 'rmte'=>_TmpFixDir($__dir_pth.'/'.$__fl_nm) ];
													  
									$rsp['zip'] = 'no';
								  
								}
	
	
								$rsp['status'] = 'success';	
								
							}else{
								
								$rsp['status'] = 'error';
								$rsp['error'] = 'no se movio';
								
							}
						
						}
						
					}else{
						
						$rsp['status'] = 'error';
						$rsp['error'] = 'problemas con folder';
						
					}
				
				}
					
			}else{
				
				$rsp['status'] = 'errorx';
				$rsp['error_q']['f'] = $_FILES['upl'];
				$rsp['error_q']['i'] = isset($_FILES['upl']);
				$rsp['error_q']['e'] = $_FILES['upl']['error'];
				$rsp['error_q']['dir'] = $__app_dt->dir;

			}
				
		}
		
	}else{
		
		$rsp['e'] = 'no'; $rsp['m'] = 2;	
		
	}

	Hdr_JSON();
	$rtrn = json_encode($rsp); echo $rtrn;
}
?>