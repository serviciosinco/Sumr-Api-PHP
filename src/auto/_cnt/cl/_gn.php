<?php 		

if(class_exists('CRM_Cnx')){			
	
	echo $this->h1('Run all Auto of Accounts');
	
	try {
		
		foreach($this->_s_cl->ls as $__cl_k=>$__cl_v){
			
			$___cl = '../'.DR_AC.$__cl_v->sbd.'/_auto/index.php';
			
			if(file_exists($___cl)){
					
				echo $this->h2('Run crons of '.$__cl_v->nm);
				include($___cl);
				
			}
			
		}
	    
	} catch (Exception $e) {
		
	    echo 'Level AccountS:'.$e->getMessage();
	    
	}

}
?>