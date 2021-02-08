<?php    
    try{

        $_tp = Php_Ls_Cln($_POST['t']);
		$_dt = Php_Ls_Cln($_POST['d']);
	
        $_id_fld = Php_Ls_Cln($_POST['_id_fld']);
		$_id_tp = Php_Ls_Cln($_POST['_id_tp']);

		$__mdl = new CRM_Mdl(); 

        $__mdl->fld = $_id_fld;
		$__mdl->tp = $_id_tp;
		
		if($_dt == 'fld' && !isN($__mdl->fld)){

            $__mdl->c_tp = Php_Ls_Cln($_POST['_tp']);
            $__mdl->c_id = Php_Ls_Cln($_POST['_id']);
            $__mdl->c_enc = Php_Ls_Cln($_POST['_enc']);
            $__mdl->c_est = Php_Ls_Cln($_POST['_est']);

            $PrcDt = $__mdl->MdlSTpFmExc(); 

            if($PrcDt->e == 'ok'){	
				$rsp['e'] = $PrcDt->e;
			}else{
				throw new Exception((ChckSESS_superadm()) ? "- ".$PrcDt->w : "");
			}
		}

		$rsp['mdl_fm']['exc'] = $__mdl->MdlSTpFmExc_Ls();     

	}catch(Exception $e){
		$rsp['e'] = 'no';
		$rsp['w'] = TX_NSPPCSR.$e->getMessage();
    }

?>