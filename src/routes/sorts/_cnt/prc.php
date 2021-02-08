<?php 
	
	try{
		
		define('MSV_HST', 'massive-db1.cd437whamugk.us-east-1.rds.amazonaws.com');
		define('MSV_DB', 'nmgrid');
		define('MSV_PORT', '5432');
		define('MSV_DB_US', 'massivespaceappl');
		define('MSV_DB_US_PSS', 'massivespacepl2018');
		define('MSV_URL_MEDIA', 'https://server.massivespace.rocks/media/');
		
		
		function PG_CnRdi($p=NULL){ 
			$_cn = new PDO("pgsql:dbname=".MSV_DB.";host=".MSV_HST.";port=".MSV_PORT."", MSV_DB_US, MSV_DB_US_PSS); return($_cn);
		}
		
		$cnx = PG_CnRdi();
		
		$_pth = dirname(__FILE__).'/prc/';
		
		$__t = Php_Ls_Cln($_GET['_t']);
		$__s = Php_Ls_Cln($_POST['sort']);
		
		if(!isN($__t)){
			include($_pth.''.$__t.'.php');
		}
		
	
	}catch(Exception $e){
		
		echo $e->getMessage();
		
	}
	
	
	
	
	
?>