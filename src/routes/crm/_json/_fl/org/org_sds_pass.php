<?php 
	
	
	try{
		
        $_tp = Php_Ls_Cln($_POST['t']);
        $_id = Php_Ls_Cln($_POST['id']);
        
        $query_DtRg = "SELECT * FROM "._BdStr(DBM).TB_ORG_SDS_PASS." WHERE orgsdspass_pass = '".$_id."' LIMIT 1" ;
					
		$DtRg = $__cnx->_qry($query_DtRg);
		$row_DtRg = $DtRg->fetch_assoc(); 
        $Tot_DtRg = $DtRg->num_rows;
        
        if($DtRg){
            if($Tot_DtRg == 0){
                $rsp['e'] = 'no';
                $rsp['pss'] = Gn_Rnd(7); 
            }else{
                $rsp['e'] = 'ok';
                $rsp['pss'] = $_id;    
            }
        }

	
		
	}catch(Exception $e){
		$rsp['e'] = 'no';
		$rsp['w'] = TX_NSPPCSR .$e->getMessage();
	}
	
?>