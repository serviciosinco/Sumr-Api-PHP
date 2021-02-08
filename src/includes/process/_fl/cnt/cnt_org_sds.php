<?php 
	// Ingreso de Registro

	if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "EdCntOrgSds")) { 

		if( !isN( Php_Ls_Cln($_POST['OthWrt']) ) ){

			$__Org = new CRM_Org();

			$__tp = $__Org->_GTp( Php_Ls_Cln($_POST['orgsdscnt_tp']) );
			$__t = __LsDt([ 'k'=>'org_tp' ])->ls->org_tp->{$__tp}->enc;

			$__Org->org_nm = Php_Ls_Cln($_POST['OthWrt']);
			$__Org->org_vrf = 2;
			
			$Org = $__Org->_Org_In();
			
			if($Org->e == 'ok'){
				$__Org->_org->id = $Org->id;
				
				$__Org->org_tp_enc = 'id';
				$__Org->id_org = $Org->enc;
				$__Org->org_tp = $__t;
				
				$_Org_tp = $__Org->GtOrgTpLs_In();
				$_Org = $__Org->_Org_Sds_In();
				
				if($_Org->e == 'ok'){
					$_org_id = $_Org->enc;
				}
			}
		}else{
			$_org_id = Php_Ls_Cln($_POST['orgsdscnt_orgsds']) ;						
		}

		$__CntIn = new CRM_Cnt();
		$__CntIn->cnt_id = $_POST['orgsdscnt_cnt'];
		$__CntIn->cnt_org[] = [
			
				'id'=>$_org_id, 
				'tpr'=>$_POST['orgsdscnt_tpr'],
				'tpr_o'=>$_POST['orgsdscnt_tpr_o'],
				'are'=>$_POST['orgsdscnt_are'],
				'crs'=>$_POST['orgsdscnt_crs'],
				'smst'=>$_POST['orgsdscnt_smst'],
				'fs'=>$_POST['orgsdscnt_fs']
			];
			
		$__dtus_in = $__CntIn->_Cnt();	
		
		$rsp['o'] = $__dtus_in;
		
		if($__dtus_in->e == 'ok'){
			$rsp['e'] = 'ok';
			$rsp['m'] = 1;
		}else{
			$rsp['e'] = 'no';
			$rsp['m'] = 2;
			_ErrSis(['p'=>$insertSQL, 'd'=>$__dtus_in->w]);
		}
		
	}

	if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "EdCntOrgSds")) { 

		$__Org = new CRM_Org();
		
		$__Org->enc = 	$_POST['orgsdscnt_enc'];
		$__Org->tpr = 	$_POST['orgsdscnt_tpr'];
		$__Org->are = 	$_POST['orgsdscnt_are'];
		$__Org->crs = 	$_POST['orgsdscnt_crs'];
		$__Org->smst = 	$_POST['orgsdscnt_smst'];
		$__Org->fs 	= 	$_POST['orgsdscnt_fs'];

		$_Org = $__Org->_Org_Sds_Cnt_Upd();
		
		if($_Org->e == 'ok'){
			$rsp['e'] = 'ok';
			$rsp['m'] = 1;
		}else{
			$rsp['e'] = 'no';
			$rsp['m'] = 2;
			$rsp['sm'] = $_Org;
		}
		
	}
?>