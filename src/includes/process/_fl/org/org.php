<?php 
	
	//@ini_set('display_errors', true); 
	//error_reporting(E_ALL & ~E_NOTICE);
	
	//-------------------- SETUP - START --------------------//
			
			
		$__cl = GtClDt( Gt_SbDMN(), "sbd" );
		$__org = new CRM_Org([ 'cl'=>$__cl->id ]);
		
		
	//-------------------- START PROCESS --------------------//


	if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "EdOrg")) { 
				
		$__org->r_org_cl = 'ok';
		$__org->org_enc = $_POST['org_enc'];
		$__org->org_tp_t = $_POST['org_tp'];
		
		$__org->org_nm = $_POST['org_nm'];
		$__org->org_dir = $_POST['org_dir'];
		$__org->org_cd = $_POST['org_cd'];
		$__org->org_clr = $_POST['org_clr'];
		$__org->org_est = $_POST['org_est'];
		
		$__org->org_web = $_POST['orgweb_web'];
		$__org->org_scec = $_POST['emp_scec'];
		
		$__org->org_sds_dc = $_POST['orgsdsdc_dc'];
		$__org->org_sds_dc_tp = $_POST['orgsdsdc_tp'];

		$__org->org_sds_eml = $_POST['orgsdseml_eml'];
		
		$__org->org_sds_tel = $_POST['orgsdstel_tel'];
		$__org->org_sds_tel_tp = $_POST['orgsdstel_tp'];

		
		
		$prc = $__org->In();
		$rsp['prc'] = $prc;	
			
		if($prc->e == 'ok' && !isN($__org->_org->enc)){

			$rsp['e'] = 'ok';
			$rsp['i'] = $__org->_org->enc;	
			$rsp['m'] = 1;		 	
			$_id = $__cnx->c_p->insert_id;	
	 		
		}else{
			$rsp['e'] = 'no';
			$rsp['m'] = 2;
		}
		
	}
	

	// Modificación de Registro primero este
	if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "EdOrg")) {
		
		$updateSQL = sprintf("UPDATE "._BdStr(DBM).TB_ORG." SET org_nm=%s, org_dir=%s, org_cd=%s, org_clr=%s, org_vrf=%s, org_est=%s WHERE org_enc=%s",
					   GtSQLVlStr(ctjTx($_POST['org_nm_mod'], 'out'), "text"),
                       GtSQLVlStr(ctjTx($_POST['org_dir_mod'], 'out'), "text"),
                       GtSQLVlStr(ctjTx($_POST['org_cd_mod'], 'out'), "int"),
					   GtSQLVlStr(ctjTx($_POST['org_clr_mod'], 'out'), "text"),
					   GtSQLVlStr(Html_chck_vl($_POST['org_vrf']), "int"),
					   GtSQLVlStr(Html_chck_vl($_POST['org_est']), "int"),
                       GtSQLVlStr(ctjTx($_POST['org_enc_mod'], 'out'), "text"));

		$Result = $__cnx->_prc($updateSQL); 
		
		
		if($Result){
			$rsp['e'] = 'ok';
			$rsp['m'] = 1;
			
			if(!isN( $_POST['org_clg_attr'] ) &&  $_POST['org_clg_attr'] == 1){
				
				$_dt = GtOrgDt([ 'i'=>$_POST['org_enc_mod'], 't'=>'enc' ]);
				
				$__org->orgattr_org = $_dt->id;
				$__org->orgattr_rdm = $_POST['orgattr_rdm'];
				$__org->orgattr_nvs = $_POST['orgattr_nvs'];
				$__org->orgattr_tp = $_POST['orgattr_tp'];
				$__org->orgattr_nva = $_POST['orgattr_nva'];
				$__org->orgattr_tmn = $_POST['orgattr_tmn'];
				$__org->orgattr_ntz = $_POST['orgattr_ntz'];
				$__org->orgattr_prtf = $_POST['orgattr_prtf'];
				$__org->orgattr_fch_bnf = $_POST['orgattr_fch_bnf'];

				$rsp['rs_org'] = $__org->InAttr();
			}
			
		}else{
			$rsp['e'] = 'no';
			$rsp['m'] = 2;
			$rsp['w'] = $__cnx->c_p->error;
			_ErrSis(['p'=>$updateSQL, 'd'=>$__cnx->c_p->error]);
		} 
	}
	
		
	// Elimino el Registro
	if ((isset($_POST['uid'])) && ($_POST['uid'] != '') && ((isset($_POST['MM_delete']))&&($_POST['MM_delete'] == 'EdOrg'))) { 
		$deleteSQL = sprintf("DELETE FROM  "._BdStr(DBM).TB_ORG." WHERE org_enc=%s", GtSQLVlStr(ctjTx($_POST['uid'], 'out'), "text"));
		$Result = $__cnx->_prc($deleteSQL); if($Result){$rsp['e'] = 'ok'; $rsp['m'] = 1; 
		//$rsp['a'] = Aud_Sis(Aud_Dsc(144, $_POST['lndfld_tt'], $_POST['id_lndfld']), $rsp['v']);
		}else{$rsp['e'] = 'no';$rsp['m'] = 2; _ErrSis(['p'=>$deleteSQL, 'd'=>$__cnx->c_p->error]);}
	}
?>