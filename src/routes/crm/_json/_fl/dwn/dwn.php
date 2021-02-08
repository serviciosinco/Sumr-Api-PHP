<?php 
	
	try{
		
        $_id_chck = Php_Ls_Cln($_POST['_id_chck']);
        
        $updateSQL = sprintf("UPDATE "._BdStr(DBD).TB_DWN." SET dwn_est=5 WHERE id_dwn=%s LIMIT 1",
						   GtSQLVlStr($_id_chck, "int"));

        $Result_UPD = $__cnx->_prc($updateSQL);

        if($Result_UPD){       
            $rsp['e'] = 'ok'; 
        }else{ 
            $rsp['e'] = 'no'; 
        }

	}catch(Exception $e){
		$rsp['e'] = 'no';
		$rsp['w'] = TX_NSPPCSR .$e->getMessage();
	}
	
?>