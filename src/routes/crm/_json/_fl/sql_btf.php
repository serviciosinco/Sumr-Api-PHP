<?php 
	
	$_qry_sql = Php_Ls_Cln($_POST['qry_sql']);
	
	if( !isN($_qry_sql) ){
		
		 $rsp['qry_btf'] =  SqlFormatter::format($_qry_sql, true); 
		 $rsp['e'] = 'ok'; 
		 
	} else{ 
		$rsp['e'] = 'no'; 
	}
	
	
	
	
	
?>