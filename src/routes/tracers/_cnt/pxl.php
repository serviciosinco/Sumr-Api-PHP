<?php
	
	No_Cache();
	
	if($__p1 == 'pxl'){
		$__t = $__p2;
		$__cl = $__p3;
		$__i = $__p4;
	}else{
		$__t = Php_Ls_Cln($_GET['_t']);
		$__i = Php_Ls_Cln($_GET['_i']);
		$__cl = Php_Ls_Cln($_GET['_cl']);
	}
	
	if(!isN($__cl)){ 
		$_cl_dt = GtClDt($__cl, 'enc');
		$_bd = $_cl_dt->bd;
		$_bd1 = $_cl_dt->bd.'.';
	}else{
		$_bd='';
	}

	if($__t == 'cnt' || isN($__t)){

		$__dt_cntec = GtEcSndDt(['id'=>$__i, 'tp'=>'enc', 'bd'=>$_bd1, 'dtl'=>['eml'=>'ok'] ]);
		
		$browser = new Browser();
		$_brws_p = $browser->getPlatform();
		$_brws_t = $browser->getBrowser();
		$_brws_v = $browser->getVersion();
		$_brws_d = LgnDsp();
		$_brws_l = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
		
		$__get_geo = KnGEO();
					

		if(!isN($__dt_cntec->id)){
			
			$insertSQL = sprintf("INSERT INTO ".$_bd1.TB_EC_OP." (ecop_snd, ecop_f, ecop_h, ecop_m, ecop_brw_t, ecop_brw_v, ecop_brw_p, ecop_ps) VALUES (%s, %s, %s, %s, %s, %s, %s, %s)",
							GtSQLVlStr($__dt_cntec->id, "int"),
							GtSQLVlStr(SIS_F, "date"),
							GtSQLVlStr(SIS_H2, "date"),
							GtSQLVlStr($_brws_d, "int"),
							GtSQLVlStr($_brws_t, "text"),
							GtSQLVlStr($_brws_v, "text"),
							GtSQLVlStr($_brws_p, "text"),
							GtSQLVlStr($__get_geo->country_code, "text"));

			$Result = $__cnx->_prc($insertSQL);
			
			if(!isN($__cnx->c_r->error)){
				echo $__cnx->c_r->error;
			}else{	
				UPDCntEml_Cld([ 'bd'=>$_bd, 'id'=>$__dt_cntec->eml->enc, 'cld'=>_CId('ID_CLD_MDM') ]);
				$__cnx->_clsr($Result);
			}

		} 

	}
	
	
	try{

		header("Content-type: image/jpg");
		header("Content-Length: 42");
		header("Cache-Control: private, no-cache, no-cache=Set-Cookie, proxy-revalidate");
		header("Pragma: no-cache");
		
		
		//$_tp = PrmLnk('rtn', 1);
		$im = @imagecreate(1,1);
		$white=imagecolorallocate($im,255,255,255);
		imagesetpixel($im,1,1,$white);
		header("content-type:image/jpg"); 
		imagejpeg($im);
		imagedestroy($im);
		http_response_code(200);

	}catch(Exception $e){
										
		echo $e->getMessage();
				
	}

?>