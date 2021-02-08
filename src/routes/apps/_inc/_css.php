<?php	
	
	$__c = Php_Ls_Cln($_GET['_c']);
	$__app = Php_Ls_Cln($_GET['_app']);
	$__css_cl = __Cl(['id'=>$__c, 't'=>'enc']);
	$__appdt = GtClAppDt([ 'id'=>$__app, 't'=>'enc' ]);

	Hdr_CSS(); 
	
	ob_start("cmpr_css"); 

		if(!isN($__appdt->id)){
			include( 'css/anm.css' );
			include( 'css/estr.css' );
			//include( 'css/rspn.css' );
		}

	ob_end_flush(); 


?>