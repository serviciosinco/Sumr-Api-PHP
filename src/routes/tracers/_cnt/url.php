<?php	
	
	$__i = Php_Ls_Cln($_GET['_i']);
	$__s = Php_Ls_Cln($_GET['_s']);
	$__test = Php_Ls_Cln($_GET['_test']);
	
	$__ec = new API_CRM_ec();
	$__ec->id_l = $__i;
	$__ec->id_t = 'enc';
	$__ec->sve_t = 'ok';
	$__ec->frm = 'Ml';
	$__ec->snd_i = $__s;
	$__ec->eml_cld = 'ok';
	$__lnk = $__ec->_bld_url();
	
	if(!isN($__s) && !isN($__lnk)){ 
		
		if(_Hs_GET(['u'=>$__lnk]) == 'ok'){ 
			$__lnk .= '&'; 
		}else{ 
			$__lnk .= '?'; 
		}

		$__lnk .=  '_s='.$__s;
		
	}
	
	if(!isN( $__lnk )){

		$__lnk = htmlspecialchars_decode($__lnk);
		
		if($__test == 'ok'){ 
			echo urldecode($__lnk); exit();
		} 
		
		if($_GET['Camilo']=='ok'){ 
			print_r($__lnk); exit();
		}

		header('Location:'. urldecode($__lnk)); die();

	}

?>