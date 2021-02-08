<?php 
		
	try{
		
		$_dt = Php_Ls_Cln($_POST['d']);
        $_id_tra = Php_Ls_Cln($_POST['tra']);
		$_id_tag = Php_Ls_Cln($_POST['id']);

		if($_dt == 'tag' && !isN($_id_tag)){

			$PrcDt = GtTraTag([ 'tra'=>$_id_tra, 'tag'=>$_id_tag ]);

			if($PrcDt->e == 'ok' && !isN($PrcDt->enc)){
                $rsp['e'] = 'ok';
                $rsp['est']['enc'] = $PrcDt->enc;
			}else{
                throw new Exception((ChckSESS_superadm()) ? "- ".$PrcDt->w : "");  
			}
		}
		
		if(!isN($PrcDt->w_n)){ $rsp['w_n'] = $PrcDt->w_n; }

	}catch(Exception $e){
		
		$rsp['e'] = 'no';
		$rsp['w'] = TX_NSPPCSR.$e->getMessage();
		
	}
	
?>