<?php
	try{

		$_tp = Php_Ls_Cln($_POST['t']);
		$_dt = Php_Ls_Cln($_POST['d']);
		$_est = Php_Ls_Cln($_POST['est']);

        $_crg_enc = Php_Ls_Cln($_POST['_crg_enc']);
		$_orgdsdscnt_enc = Php_Ls_Cln($_POST['_orgdsdscnt_enc']);

		$__cnt = new CRM_Cnt();

        $__cnt->crg_enc = $_crg_enc;
		$__cnt->orgdsdscnt_enc = $_orgdsdscnt_enc;

		if($_dt == 'crg' && !isN($__cnt->crg_enc)){

			$__cnt->est = Blnm($_est);

            $PrcDt = $__cnt->CntCrg();

			if($PrcDt->e == 'ok'){
				$rsp['e'] = $PrcDt->e;
			}else{
				throw new Exception((ChckSESS_superadm()) ? "- ".$PrcDt->w : "");
			}
		}

		if(!isN($PrcDt->w_n)){ $rsp['w_n'] = $PrcDt->w_n; }

		$rsp['cnt']['crg'] = $__cnt->CntCrg_Ls();

	}catch(Exception $e){

		$rsp['e'] = 'no';
		$rsp['w'] = TX_NSPPCSR.$e->getMessage();

	}
?>