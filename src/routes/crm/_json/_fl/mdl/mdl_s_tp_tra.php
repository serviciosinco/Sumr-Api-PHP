<?php 
	try{
		
		$_tp = Php_Ls_Cln($_GET['_t']);

        $__mdl = new CRM_Mdl(); 

		if($_tp == 'mdl_s_tp_tra'){

            $__mdl->id = Php_Ls_Cln($_GET['id']);;
            $__mdl->pst = $_POST;

            $PrcDt = $__mdl->MdlSTp_Tra(); 

            $rsp['essss'] = $PrcDt;

			if($PrcDt->e == 'ok'){	
				$rsp['e'] = $PrcDt->e;
			}else{
                $rsp['es'] = $PrcDt;
				throw new Exception((ChckSESS_superadm()) ? "- ".$PrcDt->w : "");
			}
		}
		
		if(!isN($PrcDt->w_n)){ $rsp['w_n'] = $PrcDt->w_n; }

	}catch(Exception $e){
		
		$rsp['e'] = 'no';
		$rsp['w'] = TX_NSPPCSR.$e->getMessage();
		
	}	
?>