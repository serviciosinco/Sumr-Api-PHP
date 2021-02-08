<?php

// Ingreso de Registro
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "EdStoreBrnd")) {

    $__Enc = Enc_Rnd($_POST['nm'].'- clvtex');

    $insertSQL = sprintf("INSERT INTO "._BdStr(DBS).TB_STORE_BRND." (storebrnd_enc, storebrnd_store, storebrnd_nm, storebrnd_pml, storebrnd_dsc, storebrnd_e, storebrnd_ftrd)
    VALUES (%s, (SELECT id_store FROM "._BdStr(DBS).TB_STORE." WHERE store_enc = %s), %s, %s, %s, %s, %s)",
                   GtSQLVlStr(ctjTx($__Enc,'out'), "text"),
                   GtSQLVlStr(ctjTx($_POST['storebrnd_store'],'out'), "text"),
                   GtSQLVlStr(ctjTx($_POST['storebrnd_nm'],'out'), "text"),
                   GtSQLVlStr(ctjTx($_POST['storebrnd_pml'],'out'), "text"),
                   GtSQLVlStr(ctjTx($_POST['storebrnd_dsc'],'out'), "text"),
                   GtSQLVlStr(Html_chck_vl($_POST['storebrnd_e']), "int"),
                   GtSQLVlStr(Html_chck_vl($_POST['storebrnd_ftrd']), "int"));

    $Result = $__cnx->_prc($insertSQL);

    if($Result){

        $rsp['e'] = 'ok';
        $rsp['m'] = 1;

    }else{
        $rsp['e'] = 'no';
        $rsp['m'] = 2;
        $rsp['w'] = $__cnx->c_p->error;

        _ErrSis(['p'=>$insertSQL, 'd'=>$__cnx->c_p->error]);
    }
}


// Modificación de Registro
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "EdStoreBrnd")) {

    $updateSQL = sprintf("UPDATE "._BdStr(DBS).TB_STORE_BRND." SET storebrnd_nm=%s, storebrnd_pml=%s, storebrnd_dsc=%s, storebrnd_e=%s, storebrnd_ftrd=%s WHERE storebrnd_enc=%s",
                    GtSQLVlStr(ctjTx($_POST['storebrnd_nm'],'out'), "text"),
                    GtSQLVlStr(ctjTx($_POST['storebrnd_pml'],'out'), "text"),
                    GtSQLVlStr(ctjTx($_POST['storebrnd_dsc'],'out'), "text"),
                    GtSQLVlStr(Html_chck_vl($_POST['storebrnd_e']), "int"),
                    GtSQLVlStr(Html_chck_vl($_POST['storebrnd_ftrd']), "int"),
                    GtSQLVlStr(ctjTx($_POST['storebrnd_enc'],'out'), "text"));

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