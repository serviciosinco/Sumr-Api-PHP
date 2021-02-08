<?php 
	try{
		
        $_tp = Php_Ls_Cln($_POST['t']);
		$_dt = Php_Ls_Cln($_POST['d']);

		$_id_mdlcnt = Php_Ls_Cln($_POST['_id_mdlcnt']);
        $_id_attr = Php_Ls_Cln($_POST['_id_attr']);
        $_vl = Php_Ls_Cln($_POST['_vl']);
        
        $_dt_cnt = GtMdlCntDt([ 't' => 'enc', 'id' => $_id_mdlcnt ]);

        if(!isN($_dt_cnt->id)){
            $query_DtRg = sprintf('SELECT * FROM '.TB_MDL_CNT_ATTR.' WHERE mdlcntattr_attr = %s AND mdlcntattr_mdlcnt = %s', 
            GtSQLVlStr($_id_attr,'int'),
            GtSQLVlStr($_dt_cnt->id,'int'));
			
            $DtRg = $__cnx->_qry($query_DtRg); 
            
            if($DtRg){
                
                $row_DtRg = $DtRg->fetch_assoc(); 
                $Tot_DtRg = $DtRg->num_rows;	
                
                if($Tot_DtRg > 0){
                    $id = $row_DtRg['id_mdlcntattr'];
                    $enc = $row_DtRg['mdlcntattr_enc'];
                }
            }

            if(!isN($id)){
                $updateSQL = sprintf("UPDATE ".TB_MDL_CNT_ATTR." SET mdlcntattr_vl = %s WHERE mdlcntattr_attr=%s AND mdlcntattr_mdlcnt=%s",
                                            GtSQLVlStr(ctjTx($_vl,'out'), "text"),
                                            GtSQLVlStr(ctjTx($_id_attr,'out'), "int"),
                                            GtSQLVlStr(ctjTx($_dt_cnt->id,'out'), "int"));                   
					
				$Result = $__cnx->_prc($updateSQL);

            }else{
                $__enc = Enc_Rnd($_id_mdlcnt.'-'.$_id_attr);
			
                $query_DtRg =   sprintf("INSERT INTO ".TB_MDL_CNT_ATTR." (mdlcntattr_enc, mdlcntattr_attr, mdlcntattr_mdlcnt, mdlcntattr_vl) VALUES 
                                        ( %s,%s,%s,%s )",
                            GtSQLVlStr(ctjTx($__enc,'out'), "text"),
                            GtSQLVlStr(ctjTx($_id_attr,'out'), "int"),
                            GtSQLVlStr(ctjTx($_dt_cnt->id,'out'), "int"),
                            GtSQLVlStr(ctjTx($_vl,'out'), "text"));		

                $Result = $__cnx->_prc($query_DtRg);  
            }

            if($Result){
                $rsp['e'] = 'ok';
                $rsp['m'] = 1;
                $rsp['vl'] = $_vl;
            }else{
                $rsp['e'] = 'no';
                $rsp['m'] = 2;
                $rsp['w'] = $__cnx->c_p->error;
                $rsp['w_n'] = $__cnx->c_p->errno;
            }
        }
	}catch(Exception $e){
		
		$rsp['e'] = 'no';
		$rsp['w'] = TX_NSPPCSR.$e->getMessage();
		
	}
	
?>