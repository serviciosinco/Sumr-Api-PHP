<?php 
	
	try{

        $_id = Php_Ls_Cln($_POST['id']);
        $__mdldt = GtMdlDt([ 'id'=>$_id, 't'=>'enc' ]);
        $__mdl = new CRM_Mdl([ 'cl'=>$_cl_v->id ]);
        $__cl = __Cl([ 'id'=>DB_CL_ID ]);

		$__mdl->id_mdl = $__mdldt->id;
        $__mdl->cl->bd = $__cl->bd;
        $__mdl->cl->sbd = $__cl->sbd;
        $__mdl->cl->nm = $__cl->nm;
        
        $_w_sve = $__mdl->sve_json([ 't'=>'mdl' ]);
        $rsp['es'] = $_w_sve;
        /*if($_w_sve->e == 'ok'){

            $updateSQL = sprintf("UPDATE "._BdStr($__cl->bd).TB_MDL." SET mdl_s3='1' WHERE mdl_enc=%s",
                                GtSQLVlStr($__mdldt->mdl_enc, 'text'));

            $Result = $__cnx->_prc($updateSQL);
                    
            if($Result){
                $rsp['e'] = 'ok';
                $rsp['msj'] = 'Process OK!';
            }else{
                $rsp['e'] = 'no';
                $rsp['e'] = 'Not process $_w_sve '.print_r($_w_sve, true);
            }

        }*/

	}catch(Exception $e){
		
		$rsp['e'] = 'no';
		$rsp['w'] = TX_NSPPCSR.$e->getMessage();
		
	}
	
?>