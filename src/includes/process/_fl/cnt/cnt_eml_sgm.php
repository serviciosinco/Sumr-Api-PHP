<?php
	
$__CntIn = new CRM_Cnt();	
	
$__gteml = _ChckCntEml([ 'id'=>$_POST['cnteml_eml'], 't'=>'enc' ]);

if(!isN($_POST['ec_lsts_sgm_eml'])){
    $sgm_dt = GtEcLstsSgmDt([ 'id'=>$_POST['ec_lsts_sgm_eml'], 't'=>'enc' ]);
}

// Ingreso de Registro
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "EdCntEmlSgm")) { 

	$lsts_dt = GtEcLstsDt([ 'id'=>$_POST['eccmpg_lsts'], 't'=>'enc' ]);

	$__CntIn->ec_lsts_id = $lsts_dt->id;
	$__CntIn->ec_lsts_up = 3;
	$__CntIn->ec_lsts_up_col = NULL;
	$__CntIn->ec_lsts_bdt = NULL;
	$__CntIn->ec_lsts_bdt_2 = NULL;
	$__CntIn->eclstseml_tp = _CId('ID_TPRELLSTSEML_AUTO');
	$__CntIn_Prc = $__CntIn->InCntLsts([ 'e'=>$__gteml->id ]);

    $__enc = Enc_Rnd($_POST['cnteml_eml'].'-'.$sgm_dt->id);

    if(!isN($_POST['ec_lsts_sgm_eml'])){
        $insertSQL = sprintf("INSERT INTO ".TB_EC_LSTS_EML_SGM." (eclstsemlsgm_enc, eclstsemlsgm_eml, eclstsemlsgm_lstssgm, eclstsemlsgm_srce) VALUES (%s, %s, %s, %s)",			
                    GtSQLVlStr($__enc, "text"),
                    GtSQLVlStr($__gteml->id, "text"),
                    GtSQLVlStr($sgm_dt->id, "int"),
                    GtSQLVlStr(2, "int"));	
        $Result = $__cnx->_prc($insertSQL);

        if($Result){				   
            $rsp['e'] = 'ok';
            $rsp['m'] = 1;
        }else{
            $rsp['e'] = 'no';
            $rsp['m'] = 2;
            $rsp['err'] = $insertSQL.$__cnx->c_p->error;
        }
    } 
}

?>