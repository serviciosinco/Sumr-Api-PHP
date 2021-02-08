<?php	
/*]
@ini_set('display_errors', true); 
error_reporting(E_ALL);*/
	 
$__ec = new API_CRM_ec();	
$__ec_cmz = new API_CRM_ec_Cmz();


// Ingreso de Registro
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "EdEcCmz")) { 

	$__enc = Enc_Rnd($_POST['eccmz_ec'].'-'.$_POST['eccmz_nm'].'-'.SISUS_ID);
	
	$insertSQL = sprintf("INSERT INTO "._BdStr(DBM).TB_EC_CMZ." (eccmz_enc, eccmz_cl, eccmz_ec, eccmz_nm , eccmz_us) VALUES (%s, (SELECT id_cl FROM "._BdStr(DBM).TB_CL." WHERE cl_enc=%s), %s, %s, %s)",
                   GtSQLVlStr($__enc, "text"),
                   GtSQLVlStr(DB_CL_ENC, "text"),
                   GtSQLVlStr($_POST['eccmz_ec'], "int"),
                   GtSQLVlStr(ctjTx($_POST['eccmz_nm'],'out'), "text"),
                   GtSQLVlStr(SISUS_ID, "int"));
	
	$Result = $__cnx->_prc($insertSQL);
	
	if($Result){
 		
		$_g_id = $__cnx->c_p->insert_id;		
		$__ec->_EcCmzUpd_Fld([ 'id'=>$_g_id, 'f'=>'eccmz_rbld', 'v'=>1 ]);
		
		//$rsp['u_o'] = $__u_o = __AutoRUN([ 't'=>'ec', 's2'=>'ec_cmz', 'id'=>$rsp['i'], '_fst'=>'ok', 'tmout'=>5 ]);
		//$rsp['tmp_eccmz'] = $_g_id;
		$__ec_cmz->ec_cmz = $_g_id;
		$rsp['upd_cod'] = $_upd_cod = $__ec_cmz->_bld_ec([ 'cche'=>'ok' ]);

		if($_upd_cod->e == 'ok'){
			if($__cnx->c_p->commit()){
				$rsp['e'] = 'ok';
				$rsp['i'] = $_g_id;	
				$rsp['enc'] = $__enc;
			}else{
				$__cnx->c_p->rollback();
			}
		}else{
			$__cnx->c_p->rollback();
		}

		$rsp['m'] = 1;
		$rsp['a'] = Aud_Sis(Aud_Dsc(7, $_POST['ec_tt'], $_g_id), $rsp['v']);	
		
	}else{
		
		$rsp['e'] = 'no';
		$rsp['m'] = 2;
		$rsp['w'] = $insertSQL.'err->'.$__cnx->c_p->error;
		
	}

}

// Modificación de Registro
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "EdEcCmz")) { 

	$updateSQL = sprintf("UPDATE "._BdStr(DBM).TB_EC_CMZ." SET eccmz_nm=%s, eccmz_rlctp=%s WHERE eccmz_enc=%s",
					   GtSQLVlStr(ctjTx($_POST['eccmz_nm'],'out'), "text"),
                       GtSQLVlStr($_POST['eccmz_rlctp'], "int"),
                       GtSQLVlStr($_POST['eccmz_enc'], "text"));				   	   
	
	$Result = $__cnx->_prc($updateSQL); 

	if($Result){		
		
		$Result = $__cnx->_prc($sql);
		
		$__ec->_EcCmzUpd_Fld([ 'id'=>$_POST['id_eccmz'], 'f'=>'eccmz_rbld', 'v'=>1 ]);
		
		///*$rsp['u_o'] = */__AutoRUN([ 't'=>'ec', 's2'=>'ec_cmz', 'id'=>$_POST['id_eccmz'], '_fst'=>'ok', 'tmout'=>5 ]);	
		
		$__ec_cmz->ec_cmz = $_POST['id_eccmz'];
		$rsp['upd_cod'] = $_upd_cod = $__ec_cmz->_bld_ec([ 'cche'=>'ok' ]);

		if($_upd_cod->e == 'ok'){
			$rsp['e'] = 'ok';
			$rsp['i'] = $_POST['id_eccmz'];
			$rsp['m'] = 1;
			$rsp['a'] = Aud_Sis(Aud_Dsc(8, $_POST['ec_tt'], $_POST['id_bn']), $rsp['v']);
		}

	}else{
		$rsp['e'] = 'no';
		$rsp['m'] = 2;
	}
}


// Elimino el Registro
if ((isset($_POST['id_eccmz'])) && ($_POST['id_eccmz'] != '') && ((isset($_POST['MM_delete']))&&($_POST['MM_delete'] == 'EdEcCmz'))) { 
	$deleteSQL = sprintf('DELETE FROM '._BdStr(DBM).TB_EC_CMZ.' WHERE id_eccmz=%s', GtSQLVlStr($_POST['id_eccmz'], 'int'));
	$Result = $__cnx->_prc($deleteSQL); if($Result){$rsp['e'] = 'ok'; $rsp['m'] = 1; $rsp['a'] = Aud_Sis(Aud_Dsc(9, $_POST['ec_tt'], $_POST['id_bn']), $rsp['v']);}else{ $rsp['e'] = 'no'. $__cnx->c_p->error; $rsp['m'] = 2;}
}



if ((isset($_POST["MM_insert_sgm"])) && ($_POST["MM_insert_sgm"] == "EdEcCmz")) {
	
		$Chk_sgm = ChkEcEdtSgm([ 'sgm'=>$_POST['eccmzsgm_sgm'], 'eccmz'=>$_POST['id_eccmz'] ]);

		$_sch_word = strpos( _SpclChng($_POST['eccmzsgm_vle']) , 'MsoNormal');
		
		if($_sch_word == true){ $rsp['wrdt'] = 'ok'; }else{ $rsp['wrdt'] = 'no'; }
		
		if($rsp['wrdt'] != 'ok' && !isN($_POST['id_eccmz']) && !isN($_POST['eccmzsgm_sgm']) ){
			
			/*if(SISUS_ID == 1){
				$_ec_clnr = _EcCln([ 'cod'=>$_POST['eccmzsgm_vle'], 'no_mso'=>'ok' ]);
				$_ec_html = $_ec_clnr->cod;
			}else{*/
				$_ec_clnr = /*_EcCln([ 'cod'=>*/$_POST['eccmzsgm_vle']/* ])*/;
				$_ec_html = $_ec_clnr;
			//}
			//$_ec_html = str_replace("amp;", "", $_ec_clnr->cod);

			//$rsp['htmlp'] = $_POST['eccmzsgm_vle'];
			//$rsp['htmlg']['get'] = $_ec_clnr;
			
			if($_ec_html != ''){	
							
				if($Chk_sgm->r == 'ok'){

					$_Qry = sprintf("UPDATE "._BdStr(DBM).TB_EC_CMZ_SGM." SET eccmzsgm_vle=%s, eccmzsgm_hb=%s WHERE eccmzsgm_eccmz=%s AND eccmzsgm_sgm=%s",
							   GtSQLVlStr(ctjTx( _SpclChng($_ec_html) ,'out','', ['html'=>'ok','schr'=>'no','nl2'=>'no'/*, 'qt'=>'no'*/]), "text"),
		                       GtSQLVlStr(1, "int"),
		                       GtSQLVlStr($_POST['id_eccmz'], "int"),
		                       GtSQLVlStr($_POST['eccmzsgm_sgm'], "int"));
							   
				}else{
					
					$__enc = Enc_Rnd($_POST['id_eccmz'].'-'.$_POST['eccmzsgm_sgm'].'-'.SISUS_ID);
					
					$_Qry = sprintf("INSERT INTO "._BdStr(DBM).TB_EC_CMZ_SGM." (eccmzsgm_enc, eccmzsgm_eccmz, eccmzsgm_sgm, eccmzsgm_vle) VALUES (%s, %s, %s, %s)",
						   GtSQLVlStr($__enc, "text"),
						   GtSQLVlStr($_POST['id_eccmz'], "int"),
						   GtSQLVlStr($_POST['eccmzsgm_sgm'], "text"),
						   GtSQLVlStr(ctjTx( _SpclChng($_ec_html) ,'out','', ['html'=>'ok','schr'=>'no','nl2'=>'no'/*, 'qt'=>'no'*/]), "text"));
						   
				}	
				
				//$rsp['html_prc'] = ctjTx( _SpclChng($_ec_html) ,'out','', ['html'=>'ok','schr'=>'no','nl2'=>'no'/*, 'qt'=>'no'*/]);

			}

			//$rsp['html']['h'] = $_ec_clnr->domp->cod;
		
		}
		
		$rclnr = _EcCln([ 'cod'=>_SpclChng($_ec_html) ]);
		
		if(!isN($rclnr->cod)){ 
			//$rsp['html']['c'] = $rclnr->cod; 
		}
		
		if($_Qry != ''){
			$Result = $__cnx->_prc($_Qry); 
		}
		
		if($Result){
			
			$sgm_dt = ChkEcEdtSgm([ 'sgm'=>$_POST['eccmzsgm_sgm'], 'eccmz'=>$_POST['id_eccmz'] ]);
			
			if(!isN($sgm_dt->id)){
				
				$__ec->id_eccmzsgm = $sgm_dt->id;
				$__ec->eccmzsgm_vle = $_ec_html;
				$__rsl = $__ec->_EcCmzSgmHis();
				
				//$rsp['sgmhis'] = $__rsl;
			}
			
			if($__rsl->e == 'ok'){	
				
				$__ec->_EcCmzUpd_Fld([ 'id'=>$_POST['id_eccmz'], 'f'=>'eccmz_rbld', 'v'=>1 ]);
				
				//$rsp['u_o'] = __AutoRUN([ 't'=>'ec_cmz', 'id'=>$_POST['id_eccmz'], 'tmout'=>30 ]);
				
				$__ec_cmz->ec_cmz = $_POST['id_eccmz'];
				$rsp['upd_cod'] = $__ec_cmz->_bld_ec([ 'cche'=>'ok' ]);

				$rsp['i'] = $_POST['id_eccmz'];
				$rsp['e'] = 'ok';
				$rsp['m'] = 1;
				//$rsp['a'] = Aud_Sis(Aud_Dsc(8, $_POST['ec_tt'], $_POST['id_bn']), $rsp['v']);
				
			}
			
		}else{
			$rsp['e'] = 'no';
			$rsp['m'] = 2;
			$rsp['j'] = $__cnx->c_p->error;
		}
}

// Ingreso de segmentos
if ((isset($_POST["MM_insert_chr"])) && ($_POST["MM_insert_chr"] == "EdEcCmz")) {
	
		$Chk_sgm = ChkEcEdtSgm(['sgm'=>$_POST['eccmzsgm_sgm'], 'eccmz'=>$_POST['id_eccmz']]);

		if($Chk_sgm->e == 'ok'){ 
			
			$rsp['j'] = $Chk_sgm->id;
			
			$Chk_chr = ChkEcEdtSgmChr(['eccmzsgm'=>$Chk_sgm->id, 'chr'=>$_POST['eccmzsgmchr_chr']]);
			
			$rsp['chr'] = $Chk_chr->id;
			
			
			if($Chk_chr->r == 'ok'){
				
				$_Qry = sprintf("UPDATE ".DBM.".ec_cmz_sgm_chr SET eccmzsgmchr_vle=%s WHERE id_eccmzsgmchr=%s",
					   GtSQLVlStr(ctjTx($_POST['eccmzsgmchr_vle'],'out'), "text"),
                       GtSQLVlStr($Chk_chr->id, "int"));
			
			}else{
				
				$_Qry = sprintf("INSERT INTO ".DBM.".ec_cmz_sgm_chr (eccmzsgmchr_eccmzsgm, eccmzsgmchr_chr, eccmzsgmchr_vle) VALUES (%s, %s, %s)",
					   GtSQLVlStr($Chk_sgm->id, "int"),
					   GtSQLVlStr($_POST['eccmzsgmchr_chr'], "text"),
					   GtSQLVlStr(ctjTx($_POST['eccmzsgmchr_vle'],'out'), "text"));
			
			}
			
	
			$Result = $__cnx->_prc($_Qry); 
			
			if($Result){

				$__ec->_EcCmzUpd_Fld([ 'id'=>$_POST['id_eccmz'], 'f'=>'eccmz_rbld', 'v'=>1 ]);
				
				//$rsp['u_o'] = __AutoRUN([ 't'=>'ec', 's2'=>'ec_cmz', 'id'=>$_POST['id_eccmz'], '_fst'=>'ok', 'tmout'=>5 ]);
				
				$__ec_cmz->ec_cmz = $_POST['id_eccmz'];
				$rsp['upd_cod'] = $_upd_cod = $__ec_cmz->_bld_ec([ 'cche'=>'ok' ]);
				
				if($_upd_cod->e == 'ok'){
					$rsp['i'] = $_POST['id_eccmz'];
					$rsp['e'] = 'ok';
					$rsp['m'] = 1;
				}

				//$rsp['a'] = Aud_Sis(Aud_Dsc(8, $_POST['ec_tt'], $_POST['id_bn']), $rsp['v']);
			}else{
				$rsp['e'] = 'no';
				$rsp['m'] = 2;
				$rsp['j'] = $__cnx->c_p->error;
			}
				
		}
	
		
}


// Ingreso de caracteristicas imagen
if ((isset($_POST["MM_insert_chrimg"])) && ($_POST["MM_insert_chrimg"] == "EdEcCmz")) {
	
		$Chk_img = ChkEcCmzImg(['img'=>$_POST['eccmzimg_img'], 'eccmz'=>$_POST['id_eccmz']]);

		if($Chk_img->r == 'ok'){ 
			
			$rsp['j'] = $Chk_img->id;
			
			
			$Chk_chr = ChkEcCmzImgChr(['eccmzimg'=>$Chk_img->id, 'chr'=>$_POST['eccmzimgchr_chr']]);
			
			$rsp['chr'] = $Chk_chr->id;
			
			
			if($Chk_chr->r == 'ok'){
				
				$_Qry = sprintf("UPDATE "._BdStr(DBM).TB_EC_CMZ_IMG_CHR." SET eccmzimgchr_vle=%s WHERE id_eccmzimgchr=%s",
					   GtSQLVlStr(ctjTx($_POST['eccmzimgchr_vle'],'out'), "text"),
                       GtSQLVlStr($Chk_chr->id, "int"));
			
			}else{
				
				$_Qry = sprintf("INSERT INTO "._BdStr(DBM).TB_EC_CMZ_IMG_CHR." (eccmzimgchr_eccmzimg, eccmzimgchr_chr, eccmzimgchr_vle) VALUES (%s, %s, %s)",
					   GtSQLVlStr($Chk_img->id, "int"),
					   GtSQLVlStr($_POST['eccmzimgchr_chr'], "text"),
					   GtSQLVlStr(ctjTx($_POST['eccmzimgchr_vle'],'out'), "text"));
			
			}
			
	
			$Result = $__cnx->_prc($_Qry); 
			
			if($Result){
				
				$__ec->_EcCmzUpd_Fld([ 'id'=>$_POST['id_eccmz'], 'f'=>'eccmz_rbld', 'v'=>1 ]);
				
				//$rsp['u_o'] = __AutoRUN([ 't'=>'ec', 's2'=>'ec_cmz', 'id'=>$_POST['id_eccmz'], '_fst'=>'ok', 'tmout'=>5 ]);
				//$rsp['a'] = Aud_Sis(Aud_Dsc(8, $_POST['ec_tt'], $_POST['id_bn']), $rsp['v']);

				$__ec_cmz->ec_cmz = $_POST['id_eccmz'];
				$rsp['upd_cod'] = $_upd_cod = $__ec_cmz->_bld_ec([ 'cche'=>'ok' ]);

				if($_upd_cod->e == 'ok'){
					$rsp['i'] = $_POST['id_eccmz'];
					$rsp['e'] = 'ok';
					$rsp['m'] = 1;
				}

			}else{
				$rsp['e'] = 'no';
				$rsp['m'] = 2;
				$rsp['j'] = $__cnx->c_p->error;
			}
				
		}
	
		
}

// Modificación de Registro otros datos
if ((isset($_POST["MM_Update_OthDt"])) && ($_POST["MM_Update_OthDt"] == "EdEcCmz")) { 
	
	if(!isN($_POST['eccmz_enc'])){
			
		$updateSQL = sprintf("UPDATE "._BdStr(DBM).TB_EC_CMZ." SET eccmz_sbj=%s, eccmz_f_snd=%s, eccmz_h_snd=%s, eccmz_dsc=%s, eccmz_nm=%s WHERE eccmz_enc=%s",
	                   GtSQLVlStr(ctjTx($_POST['eccmz_sbj'], 'out'), "text"),
	                   GtSQLVlStr(ctjTx($_POST['eccmz_f_snd'], 'out'), "text"),
	                   GtSQLVlStr(ctjTx($_POST['eccmz_h_snd'], 'out'), "text"),
	                   GtSQLVlStr(ctjTx($_POST['eccmz_dsc'], 'out'), "text"),
	                   GtSQLVlStr(ctjTx($_POST['eccmz_nm'], 'out'), "text"),
	                   GtSQLVlStr($_POST['eccmz_enc'], "text"));				   
		
		
		$Result = $__cnx->_prc($updateSQL); 
	
		if($Result){
			
			$__gteccmz = GtEcCmzDt([ 'cmz'=>$_POST['eccmz_enc'], 'tp'=>'enc' ]);
			$__gtec = ChkEcCmzEc([ 'eccmz'=>$__gteccmz->id ]);
			
			if(!isN($__gtec->id)){
				
				$updateSQL_Ec = sprintf("UPDATE "._BdStr(DBM).TB_EC." SET ec_tt=%s WHERE id_ec=%s",
			                   GtSQLVlStr(ctjTx($_POST['eccmz_nm'], 'out'), "text"),
			                   GtSQLVlStr($__gtec->id, "int"));
			    
			    $Result = $__cnx->_prc($updateSQL_Ec); 
			                   
		    }   
	    
	    }            
	                   			   
	}
	
	if($Result){

		//$rsp['a'] = Aud_Sis(Aud_Dsc(8, $_POST['ec_tt'], $_POST['id_bn']), $rsp['v']);
		//$rsp['u_o'] =__AutoRUN([ 't'=>'ec', 's2'=>'ec_cmz', 'id'=>$__gteccmz->id, '_fst'=>'ok', 'tmout'=>5 ]);
		
		$__ec_cmz->ec_cmz = $__gteccmz->id;
		$rsp['upd_cod'] = $_upd_cod = $__ec_cmz->_bld_ec([ 'cche'=>'ok' ]);

		if($_upd_cod->e == 'ok'){
			$rsp['e'] = 'ok';
			$rsp['m'] = 1;
		}

	}else{
		$rsp['e'] = 'no';
		$rsp['m'] = 2;
	}
}


// Modificación de Registro relacion header
if ((isset($_POST["MM_Update_HdrRlc"])) && ($_POST["MM_Update_HdrRlc"] == "EdEcCmz")) { 
	
	if(isset($_POST['eccmz_rlchdr'])){
		
		$updateSQL = sprintf("UPDATE "._BdStr(DBM).TB_EC_CMZ." SET eccmz_rlchdr=%s WHERE id_eccmz=%s",
                       GtSQLVlStr($_POST['eccmz_rlchdr'], "int"),
                       GtSQLVlStr($_POST['id_eccmz'], "int"));				   
		
	}else{
		
		$updateSQL = sprintf("UPDATE "._BdStr(DBM).TB_EC_CMZ." SET eccmz_are=%s WHERE id_eccmz=%s",
                       GtSQLVlStr($_POST['eccmz_are'], "int"),
                       GtSQLVlStr($_POST['id_eccmz'], "int"));				   
		
	}
	
	$Result = $__cnx->_prc($updateSQL); 
	
	if($Result){

		$_ec_cmz = GtEcCmzDt([ 'cmz'=>$_POST['id_eccmz'] ]); 

		if(!isN($_ec_cmz->id)){
			
			$_attr='';
			if(!isN($_POST['eccmz_h_w'])){ $_attr .=' w='.$_POST['eccmz_h_w'].' '; }
			if(!isN($_POST['eccmz_h_h'])){ $_attr .=' h='.$_POST['eccmz_h_h'].' '; }
			$rsp['tmp_attr'] = $_attr;
			$rsp['hdr_c'] = $__ec_cmz->gt_hdr([ 
								'c'=>'[H1'.$_attr.']', //Code
								'id'=>$_ec_cmz->are, //Id Header
								'tp'=>$_ec_cmz->rlc->hdr, //Type Header
								'eccmz'=>$_ec_cmz->id,  // Id Pushmail,
								'dir'=>$_ec_cmz->rlc->hdr, // S3Folder Pushmail
								'intv'=>'ok'
							]);

			$__ec->_EcCmzUpd_Fld([ 'id'=>$_POST['id_eccmz'], 'f'=>'eccmz_rbld', 'v'=>1 ]);
			//$rsp['u_o'] =__AutoRUN([ 't'=>'ec', 's2'=>'ec_cmz', 'id'=>$_POST['id_eccmz'], '_fst'=>'ok', 'tmout'=>5 ]);
			
			$__ec_cmz->ec_cmz = $_ec_cmz->id;
			$rsp['upd_cod'] = $_upd_cod = $__ec_cmz->_bld_ec([ 'cche'=>'ok' ]);

			if($_upd_cod->e == 'ok'){
				$rsp['e'] = 'ok';
				$rsp['m'] = 1;
				$rsp['a'] = Aud_Sis(Aud_Dsc(8, $_POST['ec_tt'], $_POST['id_bn']), $rsp['v']);
				//$rsp['tmp_ndhdr_are'] = $_POST['eccmz_are'];	
			}

		}

	}else{
		$rsp['e'] = 'no';
		$rsp['m'] = 2;
	}
}


// Modificación de Registro relacion header
if ((isset($_POST["MM_Update_LstsRlc"])) && ($_POST["MM_Update_LstsRlc"] == "EdEcCmz")) { 
	
	$CmzLsts = ChkEcCmzLsts(['eccmz'=>$_POST['id_eccmz']]);
	$SqlUp = 1;
		
	if($CmzLsts->r != 'ok'){
		if($_POST['eccmzlsts_lsts'] != ''){
			
			$sql = sprintf("INSERT INTO ".DBM.".ec_cmz_lsts  (eccmzlsts_eccmz, eccmzlsts_lsts) VALUES (%s, %s) ",
								   GtSQLVlStr($_POST['id_eccmz'], "int"),
								   GtSQLVlStr($_POST['eccmzlsts_lsts'], "int"));
								   
		}
		
	}else{
		
		if($_POST['eccmzlsts_lsts'] == ''){
			
			$sql = sprintf('DELETE FROM '.DBM.'.ec_cmz_lsts WHERE eccmzlsts_eccmz=%s', GtSQLVlStr($_POST['id_eccmz'], 'int'));
			$SqlUp = 2;
			
		}elseif($CmzLsts->lsts->id != $_POST['eccmzlsts_lsts']){
		
			$sql = sprintf("UPDATE ".DBM.".ec_cmz_lsts SET eccmzlsts_lsts=%s WHERE id_eccmzlsts=%s",
                       GtSQLVlStr($_POST['eccmzlsts_lsts'], "int"),
                       GtSQLVlStr($CmzLsts->id, "int"));
        
        }
		
	}
	
	$updateSQL = sprintf("UPDATE "._BdStr(DBM).TB_EC_CMZ." SET eccmz_rlctp=%s WHERE id_eccmz=%s",
                       GtSQLVlStr($SqlUp, "int"),
                       GtSQLVlStr($_POST['id_eccmz'], "int"));	
	
	
	$Result_U = $__cnx->_prc($updateSQL); 
	
	if($Result_U){ $Result = $__cnx->_prc($sql);  }
	
	if($Result){
		$rsp['e'] = 'ok';
		$rsp['m'] = 1;
		$rsp['a'] = Aud_Sis(Aud_Dsc(8, $_POST['ec_tt'], $_POST['id_bn']), $rsp['v']);
	}else{
		$rsp['e'] = 'no';
		$rsp['m'] = 2;
	}
}

// Modificación de Registro relacion header

if ((isset($_POST["MM_Update_Aprb"])) && ($_POST["MM_Update_Aprb"] == "EdEcCmz")) { 
	
	$_gt_ec = ChkEcCmzEc([ 'eccmz'=>$_POST['id_eccmz'] ]);
	
	if($_gt_ec->id){
			
		$updateSQL = sprintf("UPDATE "._BdStr(DBM).TB_EC." SET ec_est=%s WHERE id_ec=%s",
	                   GtSQLVlStr(_CId('ID_SISEST_PAPRB'), "int"),
	                   GtSQLVlStr($_gt_ec->id, "int"));				   
		
		//$rsp['q'] =	$updateSQL;
	
		$Result = $__cnx->_prc($updateSQL); 
		
		if($Result){

			$__Cl = new CRM_Cl();
			$__Cl->clflj_t = 'ec_cmz_new'; 
			$__Cl->clflj_mre->ec_cmz = $_gt_ec->cmzrlc;
			$rsp['flj'] = $__flj = $__Cl->__flj();
			
			if($__flj->ec->e == 'ok' && isN($__flj->ec->w)){
				$rsp['e'] = 'ok';
				$rsp['m'] = 1;
			}

		}else{
			$rsp['e'] = 'no';
			$rsp['m'] = 2;
		}
		
	}
		
}


// Ingreso de segmentos
if ((isset($_POST["MM_Delete_sgm"])) && ($_POST["MM_Delete_sgm"] == "EdEcCmz")) {
	
	$Chk_sgm = ChkEcEdtSgm(['sgm'=>$_POST['eccmzsgm_sgm'], 'eccmz'=>$_POST['id_eccmz']]);

	
	if($Chk_sgm->r == 'ok'){
		
		$_Qry = sprintf("UPDATE "._BdStr(DBM).TB_EC_CMZ_SGM." SET eccmzsgm_hb=%s, eccmzsgm_vle=%s WHERE eccmzsgm_eccmz=%s AND eccmzsgm_sgm=%s",
				   GtSQLVlStr(2, "text"),
				   GtSQLVlStr(NULL, "text"),
                   GtSQLVlStr($_POST['id_eccmz'], "int"),
                   GtSQLVlStr($_POST['eccmzsgm_sgm'], "int"));
		
		
	}else{
		
		$__enc = Enc_Rnd($_POST['id_eccmz'].'-'.$_POST['eccmzsgm_sgm'].'-'.SISUS_ID);
		
		$_Qry = sprintf("INSERT INTO "._BdStr(DBM).TB_EC_CMZ_SGM." (eccmzsgm_enc, eccmzsgm_eccmz, eccmzsgm_sgm, eccmzsgm_hb, eccmzsgm_vle) VALUES (%s, %s, %s, %s, %s)",
			   GtSQLVlStr($__enc, "text"),
			   GtSQLVlStr($_POST['id_eccmz'], "int"),
			   GtSQLVlStr($_POST['eccmzsgm_sgm'], "text"),
			   GtSQLVlStr(2, "text"),
			   GtSQLVlStr(NULL, "text"));
			   
	}

	

	$Result = $__cnx->_prc($_Qry); 
	
	if($Result){
		
		$__ec->_EcCmzUpd_Fld([ 'id'=>$_POST['id_eccmz'], 'f'=>'eccmz_rbld', 'v'=>1 ]);
		//$rsp['u_o'] = __AutoRUN([ 't'=>'ec', 's2'=>'ec_cmz', 'id'=>$_POST['id_eccmz'], '_fst'=>'ok', 'tmout'=>5 ]);
		
		$__ec_cmz->ec_cmz = $_POST['id_eccmz'];
		$rsp['upd_cod'] = $_upd_cod = $__ec_cmz->_bld_ec([ 'cche'=>'ok' ]);

		if($_upd_cod->e == 'ok'){
			$rsp['i'] = $_POST['id_eccmz'];
			$rsp['e'] = 'ok';
			$rsp['m'] = 1;
			//$rsp['a'] = Aud_Sis(Aud_Dsc(8, $_POST['ec_tt'], $_POST['id_bn']), $rsp['v']);
		}
		
	}else{
		$rsp['e'] = 'no';
		$rsp['m'] = 2;
		$rsp['j'] = $__cnx->c_p->error;
	}
}


// Aprobar
if ((isset($_POST["MM_Update_ec_est"])) && ($_POST["MM_Update_ec_est"] == "EdEcEst")) {
	
	$_Qry = sprintf("UPDATE "._BdStr(DBM).TB_EC." SET ec_est=%s, ec_us_ntf=%s, ec_fa=%s, ec_fs=%s WHERE ec_enc=%s",
			   GtSQLVlStr(_CId('ID_SISEST_OK'), "int"),
			   GtSQLVlStr(1, "int"),
			   GtSQLVlStr(SIS_F, "date"),
			   GtSQLVlStr(SIS_F, "date"),
			   GtSQLVlStr($_POST['ec_enc'], "text"));		   
	
	$Result = $__cnx->_prc($_Qry); 
	
	if($Result){
		
		$rsp['e'] = 'ok';
		$rsp['m'] = 1;
		//$rsp['q'] = $_Qry;
		
		$__Cl = new CRM_Cl();
		$__Cl->clflj_t = 'ec_cmz_aprb'; 
		$__Cl->clflj_mre->ec_cmz = $_POST['ec_enc'];
		$rsp['flj'] = $__Cl->__flj();

		$rsp['a'] = $_Crm_Aud->In_Aud([ 'aud'=>_CId('ID_AUDDSC_EC_APRD'), "db"=>'ec', "iddb"=>$_POST['ec_enc'], "post"=>$_POST]);
		
	}else{
		$rsp['e'] = 'no';
		$rsp['m'] = 2;
		$rsp['j'] = $__cnx->c_p->error;
	}
}


// Cambiar estado de pushmail
if ((isset($_POST["MM_Update_ecEst"])) && ($_POST["MM_Update_ecEst"] == "EdEcEstCmz")) {
	
		$_Qry = sprintf("UPDATE "._BdStr(DBM).TB_EC." SET ec_est=%s WHERE id_ec=%s",
				   GtSQLVlStr($_POST['ec_est'], "int"),
				   GtSQLVlStr($_POST['id_ec'], "int"));
		$Result = $__cnx->_prc($_Qry); 
		
		if($Result){
			$rsp['e'] = 'ok';
			$rsp['m'] = 1;
			//$rsp['qry'] = $_Qry;
			
		}else{
			$rsp['e'] = 'no';
			$rsp['m'] = 2;
			$rsp['j'] = $__cnx->c_p->error;
		}
}


// Eliminar Pushmail
if ((isset($_POST["MM_Delete_ec"])) && ($_POST["MM_Delete_ec"] == "EdEc")) {
	
		$_Qry = sprintf("DELETE FROM "._BdStr(DBM).TB_EC." WHERE id_ec=%s",
				  GtSQLVlStr($_POST['id_ec'], "int"));
		$Result = $__cnx->_prc($_Qry); 
		
		if($Result){
			$rsp['e'] = 'ok';
			$rsp['m'] = 1;
		}else{
			$rsp['e'] = 'no';
			$rsp['m'] = 2;
			$rsp['j'] = $__cnx->c_p->error;
		}
}



// Elimino el Registro header personalizado
if ((isset($_POST['id_eccmz'])) && ($_POST['id_eccmz'] != '') && ((isset($_POST['MM_Delete_hdr']))&&($_POST['MM_Delete_hdr'] == 'EdEcCmz'))) {

	$deleteSQL = sprintf('	DELETE 
							FROM '._BdStr(DBM).TB_EC_CMZ_HDR.' 
							WHERE eccmzhdr_eccmz=%s', GtSQLVlStr($_POST['id_eccmz'], 'int'));

	$Result = $__cnx->_prc($deleteSQL); 
	
	if($Result){
		$rsp['e'] = 'ok';
		$rsp['m'] = 1; 
		$rsp['a'] = Aud_Sis(Aud_Dsc(9, $_POST['ec_tt'], $_POST['id_bn']), $rsp['v']); 
		/*$rsp['u_o'] = */__AutoRUN(['t'=>'ec_cmz', 'id'=>$_POST['id_eccmz'], '_fst'=>'ok', 'tmout'=>5 ]); 
	}else{ 
		$rsp['e'] = 'no'; 
		$rsp['m'] = 2;
		$rsp['w'] = $__cnx->c_p->error;
	}

}

// Elimino el imagen personalizado
if (!isN($_POST['eccmzimg_img']) && $_POST['MM_Delete_img'] == 'EdEcCmz') {
	
	$deleteSQL = sprintf('DELETE FROM '._BdStr(DBM).TB_EC_CMZ_IMG.' WHERE eccmzimg_eccmz=%s AND eccmzimg_img=%s', GtSQLVlStr($_POST['eccmzimg_eccmz'], 'int'), GtSQLVlStr($_POST['eccmzimg_img'], 'int'));
	$Result = $__cnx->_prc($deleteSQL); 
	
	if($Result){

		$__ec_cmz->ec_cmz = $_POST['eccmzimg_eccmz'];
		$rsp['upd_cod'] = $_upd_cod = $__ec_cmz->_bld_ec([ 'cche'=>'ok' ]);
		
		if($_upd_cod->e == 'ok'){
			$rsp['e'] = 'ok'; $rsp['m'] = 1; 
		}else{
			$rsp['w'] = 'No update code';
		}

	}else{ 
		$rsp['e'] = 'no';
		$rsp['m'] = 2;
		$rsp['w'] = $__cnx->c_p->error;
	}
}

?>			