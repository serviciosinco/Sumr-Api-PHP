<?php
// Ingreso de Registro
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "EdEcChng")) {

    $__dtec = GtEcDt($_POST['ecchng_ec'], 'enc');
    
    $__enc = Enc_Rnd($_POST['ecchng_tx']);

    if(!isN($__dtec->id)){
        $insertSQL = sprintf("INSERT INTO "._BdStr(DBM).TB_EC_CHNG." (ecchng_enc, ecchng_tx, ecchng_ec, ecchng_us) VALUES (%s, %s, %s, %s)",
                    GtSQLVlStr($__enc, "text"),
                    GtSQLVlStr(ctjTx($_POST['ecchng_tx'],'out'), "text"),
                    GtSQLVlStr($__dtec->id, "int"),
                    GtSQLVlStr(SISUS_ID, "int"));
                    
        $Result = $__cnx->_prc($insertSQL);

        if($Result){
            $rsp['e'] = 'ok';
            $rsp['m'] = 1;
            $_POST['id_ecchng'] = $__cnx->c_p->insert_id;
            $_POST['id_ec'] = $__dtec->id;
            $_Crm_Aud->In_Aud([ 'aud'=>_Cns('ID_AUDDSC_EC_CHNG_ING'), "db"=>TB_EC_CHNG, "post"=>$_POST]);
        }else{
            $rsp['e'] = 'no';
            $rsp['m'] = 2;
            _ErrSis(['p'=>$insertSQL, 'd'=>$__cnx->c_p->error]);
        }
    }
}

// Modificación de Registro
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "EdEcChng")) { 

    $__dtec = GtEcDt($_POST['ecchng_ec'], 'enc');
		
    $updateSQL = sprintf("UPDATE "._BdStr(DBM).TB_EC_CHNG." SET ecchng_tx=%s WHERE ecchng_enc=%s",
                            GtSQLVlStr(ctjTx($_POST['ecchng_tx'],'out'), "text"),
                            GtSQLVlStr($_POST['ecchng_enc'], "text"));
    
    $Result = $__cnx->_prc($updateSQL);
    
    if($Result){
        $rsp['e'] = 'ok';
        $rsp['m'] = 1;
        $_POST['id_ec'] = $__dtec->id;
        $_Crm_Aud->In_Aud([ 'aud'=>_Cns('ID_AUDDSC_EC_CHNG_MOD'), "db"=>TB_EC_CHNG, "post"=>$_POST]);
    }else{
        $rsp['e'] = 'no';
        $rsp['m'] = 2;
        $rsp['w'] = $__cnx->c_p->error;
        _ErrSis(['p'=>$updateSQL, 'd'=>$__cnx->c_p->error]);
    }	
}

?>