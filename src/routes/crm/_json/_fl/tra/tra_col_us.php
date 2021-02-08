<?php 
		
	try{
		$_dt = Php_Ls_Cln($_POST['_d']);
		$_id_tra_col = Php_Ls_Cln($_POST['_id_tra_col']);
		$_id_grp = Php_Ls_Cln($_POST['_id_grp']);
		
		$_id_us = Php_Ls_Cln($_POST['_id']);
		$_id_tp = Php_Ls_Cln($_POST['_tp']);


		$_us_dt = GtUsDt($_id_us, 'enc');
		$_tracol_dt = GtTraColDt(['id'=>$_id_tra_col, 't'=>'enc', 'nous'=>'ok' ]);
		$_grp = GtClGrpDt([ 'enc'=>$_id_grp ]);

		if(!isN($_grp->id)){
			$__tra->id_grp = $_id_grp;
		}

        $__tra = new CRM_Tra();
		$__tra->tra_col = $_tracol_dt->id;
		

		if($_dt == 'prc' && !isN($_id_tra_col)){

			$__tra->tra_col_us = $_us_dt->id;
			$__tra->tra_col_tp = $_id_tp;
			$PrcDt = $__tra->GtTraColUs();

			//$rsp['prc'] = $PrcDt;

			if($PrcDt->e == 'ok'){
                $rsp['e'] = 'ok';
			}else{
                throw new Exception((ChckSESS_superadm()) ? "- ".$PrcDt->w : "");  
			}
		}
        
        if($_dt == 'ls' || $PrcDt->e == 'ok'){
            $rsp['tra']['us'] = $__tra->GtTraColUs_Ls(); 
        }
		
		if(!isN($PrcDt->w_n)){ $rsp['w_n'] = $PrcDt->w_n; }

	}catch(Exception $e){
		
		$rsp['e'] = 'no';
		$rsp['w'] = TX_NSPPCSR.$e->getMessage();
		
	}
	
?>