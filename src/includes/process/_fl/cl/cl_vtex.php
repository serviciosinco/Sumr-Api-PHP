<?php

// Ingreso de Registro
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "EdClVtex")) {

    $__Enc = Enc_Rnd($_POST['nm'].'- clvtex');

    $insertSQL = sprintf("INSERT INTO "._BdStr(DBT).TB_VTEX." (vtex_enc, vtex_cl, vtex_nm, vtex_sndbx_acc, vtex_sndbx_key, vtex_sndbx_tkn, vtex_prd_acc, vtex_prd_key, vtex_prd_tkn, vtex_e, vtex_sndbx)
    VALUES (%s, (SELECT id_cl FROM "._BdStr(DBM).TB_CL." WHERE cl_enc = %s), %s, %s, AES_ENCRYPT(%s, '".ENCRYPT_PASSPHRASE."'), AES_ENCRYPT(%s, '".ENCRYPT_PASSPHRASE."'), %s, AES_ENCRYPT(%s, '".ENCRYPT_PASSPHRASE."'), AES_ENCRYPT(%s, '".ENCRYPT_PASSPHRASE."'), %s, %s)",
                   GtSQLVlStr(ctjTx($__Enc,'out'), "text"),
                   GtSQLVlStr(ctjTx($_POST['vtex_cl'],'out'), "text"),
                   GtSQLVlStr(ctjTx($_POST['vtex_nm'],'out'), "text"),
                   GtSQLVlStr(ctjTx($_POST['vtex_sndbx_acc'],'out'), "text"),
                   GtSQLVlStr(ctjTx($_POST['vtex_sndbx_key'],'out'), "text"),
                   GtSQLVlStr(ctjTx($_POST['vtex_sndbx_tkn'],'out'), "text"),
                   GtSQLVlStr(ctjTx($_POST['vtex_prd_acc'],'out'), "text"),
                   GtSQLVlStr(ctjTx($_POST['vtex_prd_key'],'out'), "text"),
                   GtSQLVlStr(ctjTx($_POST['vtex_prd_tkn'],'out'), "text"),
                   GtSQLVlStr(Html_chck_vl($_POST['vtex_e']), "int"),
                   GtSQLVlStr(Html_chck_vl($_POST['vtex_sndbx']), "int"));

    $Result = $__cnx->_prc($insertSQL);

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
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "EdClVtex")) {

    $updateSQL = sprintf("UPDATE "._BdStr(DBT).TB_VTEX." SET vtex_nm=%s, vtex_sndbx_acc=%s, vtex_sndbx_key=AES_ENCRYPT(%s,'".ENCRYPT_PASSPHRASE."'), vtex_sndbx_tkn=AES_ENCRYPT(%s,'".ENCRYPT_PASSPHRASE."'), vtex_prd_acc=%s, vtex_prd_key=AES_ENCRYPT(%s,'".ENCRYPT_PASSPHRASE."'), vtex_prd_tkn=AES_ENCRYPT(%s,'".ENCRYPT_PASSPHRASE."'), vtex_e=%s, vtex_sndbx=%s WHERE vtex_enc=%s",
                    GtSQLVlStr(ctjTx($_POST['vtex_nm'],'out'), "text"),
                    GtSQLVlStr(ctjTx($_POST['vtex_sndbx_acc'],'out'), "text"),
                    GtSQLVlStr(ctjTx($_POST['vtex_sndbx_key'],'out'), "text"),
                    GtSQLVlStr(ctjTx($_POST['vtex_sndbx_tkn'],'out'), "text"),
                    GtSQLVlStr(ctjTx($_POST['vtex_prd_acc'],'out'), "text"),
                    GtSQLVlStr(ctjTx($_POST['vtex_prd_key'],'out'), "text"),
                    GtSQLVlStr(ctjTx($_POST['vtex_prd_tkn'],'out'), "text"),
                    GtSQLVlStr(Html_chck_vl($_POST['vtex_e']), "int"),
                    GtSQLVlStr(Html_chck_vl($_POST['vtex_sndbx']), "int"),
                    GtSQLVlStr(ctjTx($_POST['vtex_enc'],'out'), "text"));

    $Result = $__cnx->_prc($updateSQL);

    $rsp['q'] = compress_code( $updateSQL );

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