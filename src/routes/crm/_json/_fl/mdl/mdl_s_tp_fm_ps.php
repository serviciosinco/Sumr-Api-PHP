<?php 
		
	try{
		$_dt = Php_Ls_Cln($_POST['_d']);
		$mdl_fm = Php_Ls_Cln($_POST['_id_mdl_fm']);
		$_id_ps = Php_Ls_Cln($_POST['_id']);

		$__fm_dt = GtMdlSTpFmDt([ 't'=>'enc', 'id'=>$mdl_fm ]);

        $__mdl = new CRM_Mdl();
		$__mdl->mdlstpfmps_mdlstpfm = $__fm_dt->id;

		if($_dt == 'prc' && !isN($mdl_fm)){
			
			$__ps_dt = GtPsDt([ 'tp'=>'enc', 'v'=>$_id_ps ]);
			$__mdl->mdlstpfmps_ps = $__ps_dt->id;
			
			$PrcDt = $__mdl->GtMdlSTpFmPs();

			$rsp['prc'] = $PrcDt;

			if($PrcDt->e == 'ok'){
                $rsp['e'] = 'ok';
			}else{
                throw new Exception((ChckSESS_superadm()) ? "- ".$PrcDt->w : "");  
			}
		}
        
        if($_dt == 'ls' || $PrcDt->e == 'ok'){
            $rsp['mdlfm']['ps'] = $__mdl->GtMdlSTpFmPs_Ls(); 
        }
		
		if(!isN($PrcDt->w_n)){ $rsp['w_n'] = $PrcDt->w_n; }

	}catch(Exception $e){
		
		$rsp['e'] = 'no';
		$rsp['w'] = TX_NSPPCSR.$e->getMessage();
		
	}
	
?>