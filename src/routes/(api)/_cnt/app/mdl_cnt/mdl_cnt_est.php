<?php

    if( $_tp == "upd" ){

        if( !isN($_siscntest_enc) ){
            
            $updateSQL = sprintf(" UPDATE "._BdStr($_bd).TB_MDL_CNT."
                                    SET mdlcnt_est = (
                                        SELECT id_siscntest 
                                        FROM "._BdStr(DBM).TB_SIS_CNT_EST." 
                                        WHERE siscntest_enc = %s
                                    ) WHERE mdlcnt_enc = %s",
                                GtSQLVlStr($_siscntest_enc, "text"),
                                GtSQLVlStr($_mdlcnt_enc, "text"));   
            $Result = $__cnx->_prc($updateSQL);
            
            if($Result){
                $rsp['e'] = "ok";
            }else{
                $rsp['e'] = "no";
            }

        }

    }

?>