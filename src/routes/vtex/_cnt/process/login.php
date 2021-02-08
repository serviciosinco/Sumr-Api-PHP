<?php
    
    $_key = Php_Ls_Cln($_POST['____key']);
    $_eml = Php_Ls_Cln($_POST['Cnt_Eml'.$_key]);
    $_pss = Php_Ls_Cln($_POST['Cnt_Pss'.$_key]);

    if(!isN( $__cl->bd )){

        $query_DtRg = sprintf("SELECT vtexcntpss_cnt, vtexcntpss_eml FROM "._BdStr($__cl->bd).TB_VTEX_CNT_PSS." WHERE vtexcntpss_eml = %s AND vtexcntpss_pss = AES_ENCRYPT(%s, '".ENCRYPT_PASSPHRASE."' ) LIMIT 1", GtSQLVlStr($_eml, "text"), GtSQLVlStr($_pss, "text") ); 
        $DtRg = $__cnx->_qry($query_DtRg);
        
        if($DtRg){ 
            
            $row_DtRg = $DtRg->fetch_assoc(); 
            $Tot_DtRg = $DtRg->num_rows;   

            if($Tot_DtRg == 1){

                $_r['e'] = 'ok';
                $cnt = GtCntDt([ 'id' => $row_DtRg['vtexcntpss_cnt'], 't'=>'id', 'bd'=>$__cl->bd ]);

                if(!isN( $cnt->enc )){
                    $_SESSION[DB_CL_ENC_SES.MM_CNT] = $cnt->enc;
                    $_r['cnt'] = $cnt->enc;
                }

            }else{
                $_r['e'] = 'no';
            }

        }else{
            $_r['e'] = 'no';
        }

    }

?>