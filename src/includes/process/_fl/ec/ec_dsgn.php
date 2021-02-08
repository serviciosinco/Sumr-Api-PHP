<?php 

$_i = Php_Ls_Cln($_POST['id_ecdsgn']);
$__dtec = GtEcDt($_i, 'enc');

if ((isset($_POST["MM_insert_sgm"])) && ($_POST["MM_insert_sgm"] == "EdEcDsgn")) {
	
		$_chk_sgm = ChkEcEdtSgm([ 'sgm'=>$_POST['ecdsgnsgm_sgm'], 'ec'=>$__dtec->id, 'mdl'=>$_POST['ecdsgnsgm_mdl'] ]);
		$_ec_clnr = _EcCln([ 'cod'=>$_POST['ecdsgnsgm_vle'] ]); 
		$_ec_html = str_replace("amp;", "", $_ec_clnr->cod);
		
		if($_chk_sgm->r == 'ok'){
			
			$_Qry = sprintf("UPDATE ".TB_MDL_EC_CRT." SET mdleccrt_vl_es=%s, mdleccrt_tag_es=%s WHERE mdleccrt_enc=%s",
					   GtSQLVlStr(ctjTx( _SpclChng($_ec_html) ,'out','', ['html'=>'ok','schr'=>'no','nl2'=>'no'/*, 'qt'=>'no'*/]), "text"),
					   GtSQLVlStr(ctjTx($_POST['ecdsgnsgm_tag'],'out','',true), "text"),
                       GtSQLVlStr($_chk_sgm->enc, "text"));
			
		}else{
			
			
			$__enc = Enc_Rnd($_POST['ecdsgnsgm_mdl'].'-'.$_POST['ecdsgnsgm_sgm'].'-'.$__dtec->id);
			
			$_Qry = sprintf("INSERT INTO ".TB_MDL_EC_CRT." ( mdleccrt_enc, mdleccrt_mdl, mdleccrt_eccrt, mdleccrt_ec, mdleccrt_vl_es, mdleccrt_tag_es) VALUES (%s, (SELECT id_mdl FROM ".TB_MDL." WHERE mdl_enc=%s), %s, %s, %s, %s)",
				   GtSQLVlStr($__enc, "text"),
				   GtSQLVlStr($_POST['ecdsgnsgm_mdl'], "text"),
				   GtSQLVlStr($_POST['ecdsgnsgm_sgm'], "int"),
				   GtSQLVlStr($__dtec->id, "int"),
				   GtSQLVlStr(ctjTx( _SpclChng($_ec_html) ,'out','', ['html'=>'ok','schr'=>'no','nl2'=>'no'/*, 'qt'=>'no'*/]), "text"),
				   GtSQLVlStr(ctjTx($_POST['ecdsgnsgm_tag'],'out','',true), "text"));
				   
		}
	
		

		$Result = $__cnx->_prc($_Qry); 
		
		if($Result){
			
			$rsp['i'] = $_POST['id_mdleccrt'];
			
			if($_POST['ecdsgnsgm_vle_u'] == 'ok'){
				$_ec_sve = new API_CRM_ec();
				$_ec_sve->_GtNLnSve([
											'ec'=>$__dtec->id, 
											'lnk'=>ctjTx($_POST['ecdsgnsgm_vle'],'out') 
									]);
			}
			
			$rsp['e'] = 'ok';
			$rsp['m'] = 1;
			//$rsp['a'] = Aud_Sis(Aud_Dsc(8, $_POST['ec_tt'], $_POST['id_bn']), $rsp['v']);
		}else{
			$rsp['e'] = 'no';
			$rsp['m'] = 2;
			$rsp['j'] = $__cnx->c_p->error;
		}
}


?>