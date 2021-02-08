<?php 
		
	if(class_exists('CRM_Cnx')){
		
		$__prnt = dirname(__FILE__, 4);
		$__main = $__prnt.'/.tmp/';
		
		function getAllDir($path) {
		    
		    $rii = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path));
		    $files = array(); 
		    
		    foreach ($rii as $file){
		        if (!$file->isDir()){
			        
					$_f_mdfd = date ("Y-m-d H:i:s", filemtime( $file->getPathname() ));
					$date1 = new DateTime($_f_mdfd); 
					$date2 = new DateTime(SIS_F2.' '.SIS_H2); 	
					$dDiff = $date2->diff($date1);						
					
					if($dDiff->i > 30 || $dDiff->h > 0 || $dDiff->d > 0){
						$files[] = $file->getPathname();		
					}   
					           
		        }    
			}
			
		    return $files;
		}
		
		if(is_dir($__main)){
			
			$____fltodel = getAllDir($__main);
			
			if(!isN($____fltodel)){
				foreach($____fltodel as $_fl_k=>$_fl_v){
					unlink($_fl_v);
				}
			}
		
		}

	}
?>