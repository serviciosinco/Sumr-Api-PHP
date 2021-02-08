<?php 
	
	use Aws\S3\S3Client;
	use Aws\Ses\SesClient;
	use Aws\Ses\Exception\SesException;
			
				
	function _aws_ses_hdrs($p=NULL){
		
		if(!isN($p['v'])){
			foreach($p['v'] as $_k_k=>$_k_v){
				$_r[ $_k_v->name ] = $_k_v->value;
			}
		}
		
		return _jEnc($_r);
	} 
	
?>