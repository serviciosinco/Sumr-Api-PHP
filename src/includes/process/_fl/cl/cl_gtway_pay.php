<?php  
     
// Ingreso de Registro 
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "EdClGtwyPay")) {  
     
    $__Enc = Enc_Rnd($_POST['nm'].'- gtwypay'); 
     
    $insertSQL = sprintf("INSERT INTO "._BdStr(DBM).TB_CL_GTWY_PAY." (clgtwypay_enc, clgtwypay_cl, clgtwypay_nm, clgtwypay_gtwy, clgtwypay_sndbx_key, clgtwypay_sndbx_tkn, clgtwypay_prd_key, clgtwypay_prd_tkn, clgtwypay_e, clgtwypay_sndbx, clgtwypay_url_success, clgtwypay_url_failure, clgtwypay_url_pending)  
    VALUES (%s, (SELECT id_cl FROM "._BdStr(DBM).TB_CL." WHERE cl_enc = %s), %s, %s, AES_ENCRYPT(%s, '".ENCRYPT_PASSPHRASE."'), AES_ENCRYPT(%s, '".ENCRYPT_PASSPHRASE."'), AES_ENCRYPT(%s, '".ENCRYPT_PASSPHRASE."'), AES_ENCRYPT(%s, '".ENCRYPT_PASSPHRASE."'), %s, %s, %s, %s, %s)", 
     
                   GtSQLVlStr(ctjTx($__Enc,'out'), "text"), 
                   GtSQLVlStr(ctjTx($_POST['clgtwypay_cl'],'out'), "text"), 
                   GtSQLVlStr(ctjTx($_POST['clgtwypay_nm'],'out'), "text"), 
                   GtSQLVlStr($_POST['clgtwypay_gtwy'], "int"), 
                   GtSQLVlStr(ctjTx($_POST['clgtwypay_sndbx_key'],'out'), "text"), 
                   GtSQLVlStr(ctjTx($_POST['clgtwypay_sndbx_tkn'],'out'), "text"), 
                   GtSQLVlStr(ctjTx($_POST['clgtwypay_prd_key'],'out'), "text"), 
                   GtSQLVlStr(ctjTx($_POST['clgtwypay_prd_tkn'],'out'), "text"), 
                   GtSQLVlStr(Html_chck_vl($_POST['clgtwypay_e']), "int"),
                   GtSQLVlStr(Html_chck_vl($_POST['clgtwypay_sndbx']), "int"),
                   GtSQLVlStr(ctjTx($_POST['clgtwypay_url_success'],'out'), "text"), 
                   GtSQLVlStr(ctjTx($_POST['clgtwypay_url_failure'],'out'), "text"), 
                   GtSQLVlStr(ctjTx($_POST['clgtwypay_url_pending'],'out'), "text"));        
                    
     
    $Result = $__cnx->_prc($insertSQL); $rsp['w'] = $__cnx->c_p->error; 
         
    if($Result){ 
 
        $rsp['e'] = 'ok'; 
        $rsp['m'] = 1; 
         
    }else{ 
        $rsp['e'] = 'no';     
        $rsp['m'] = 2; 
         
        _ErrSis(['p'=>$insertSQL, 'd'=>$__cnx->c_p->error]); 
    } 
} 
// Modificación de Registro 
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "EdClGtwyPay")) {
     
    $updateSQL = sprintf("UPDATE "._BdStr(DBM).TB_CL_GTWY_PAY." SET clgtwypay_nm=%s, clgtwypay_gtwy=%s, clgtwypay_sndbx_key=AES_ENCRYPT(%s,'".ENCRYPT_PASSPHRASE."'), clgtwypay_sndbx_tkn=AES_ENCRYPT(%s,'".ENCRYPT_PASSPHRASE."'), clgtwypay_prd_key=AES_ENCRYPT(%s,'".ENCRYPT_PASSPHRASE."'), clgtwypay_prd_tkn=AES_ENCRYPT(%s,'".ENCRYPT_PASSPHRASE."'), clgtwypay_e=%s, clgtwypay_sndbx=%s, clgtwypay_url_success=%s, clgtwypay_url_failure=%s, clgtwypay_url_pending=%s WHERE clgtwypay_enc=%s", 
                    GtSQLVlStr(ctjTx($_POST['clgtwypay_nm'],'out'), "text"), 
                    GtSQLVlStr($_POST['clgtwypay_gtwy'], "int"), 
                    GtSQLVlStr(ctjTx($_POST['clgtwypay_sndbx_key'],'out'), "text"), 
                    GtSQLVlStr(ctjTx($_POST['clgtwypay_sndbx_tkn'],'out'), "text"), 
                    GtSQLVlStr(ctjTx($_POST['clgtwypay_prd_key'],'out'), "text"), 
                    GtSQLVlStr(ctjTx($_POST['clgtwypay_prd_tkn'],'out'), "text"), 
                    GtSQLVlStr(Html_chck_vl($_POST['clgtwypay_e']), "int"),
                    GtSQLVlStr(Html_chck_vl($_POST['clgtwypay_sndbx']), "int"),
                    GtSQLVlStr(ctjTx($_POST['clgtwypay_url_success'],'out'), "text"),
                    GtSQLVlStr(ctjTx($_POST['clgtwypay_url_failure'],'out'), "text"),
                    GtSQLVlStr(ctjTx($_POST['clgtwypay_url_pending'],'out'), "text"),
                    GtSQLVlStr(ctjTx($_POST['clgtwypay_enc'],'out'), "text")); 
                    
    $rsp['q'] = $updateSQL; 
    $Result = $__cnx->_prc($updateSQL);  
 
    if($Result){ 
        $rsp['e'] = 'ok';        
        $rsp['m'] = 1; 
    }else{ 
        $rsp['m'] = 2; 
        $rsp['e'] = 'no'; 
        _ErrSis(['p'=>$updateSQL, 'd'=>$__cnx->c_p->error]); 
    }  
} 
 
?>