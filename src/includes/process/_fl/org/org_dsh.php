<?php 

    $_vl = implode(",", $_POST['orgdsh_vl']);
    
    if($_vl == true){ $vl = $_vl; }else{ $vl = $_POST['orgdsh_vl']; }

    if ((isset($_POST["MM_Send"])) && ($_POST["MM_Send"] == "OrgDsh")) { 	
        
        $Ls_Qry = sprintf("SELECT id_orgdsh FROM "._BdStr(DBM).TB_ORG_DSH." WHERE id_orgdsh = %s AND orgdsh_tp = %s",
                                
                                GtSQLVlStr(ctjTx($_POST['id_orgdsh'],'out'), "text"),
                                GtSQLVlStr(ctjTx($_POST['orgdsh_tp'],'out'), "text"));

        $Ls = $__cnx->_qry($Ls_Qry);
        $row_Ls = $Ls->fetch_assoc(); 
        $Tot_Ls = $Ls->num_rows;

        if($Tot_Ls > 0){

            $updateSQL = sprintf("UPDATE "._BdStr(DBM).TB_ORG_DSH." SET orgdsh_vl=%s  WHERE id_orgdsh=%s",
                        GtSQLVlStr(ctjTx($vl,'out'), "text"),
                        GtSQLVlStr($_POST['id_orgdsh'], "text"));

            $Result = $__cnx->_prc($updateSQL); 

            if($Result){
                $rsp['e'] = 'ok';
                $rsp['m'] = 1;
                $rsp['vl'] = $_vl;
            }else{
                $rsp['e'] = 'no';
                $rsp['m'] = 2;
            }

        }else{

            $__enc = Enc_Rnd($row_Ls_Rg['orgdsh_vl'].'-'.SISUS_ID);

            $insertSQL = sprintf("INSERT INTO "._BdStr(DBM).TB_ORG_DSH." (orgdsh_enc, orgdsh_cl, orgdsh_tp, orgdsh_otp, orgdsh_vl) VALUES ( %s, %s, %s, %s, %s)",
			                       GtSQLVlStr($__enc, "text"),
			                       GtSQLVlStr(ctjTx(DB_CL_ID,'out'), "text"),
								   GtSQLVlStr(ctjTx($_POST['orgdsh_tp'],'out'), "text"),
								   GtSQLVlStr(ctjTx($_POST['orgdsh_otp'],'out'), "text"),
								   GtSQLVlStr(ctjTx($vl,'out'), "text"));

            $Result = $__cnx->_prc($insertSQL); 

            if($Result){
                $rsp['e'] = 'ok';
                $rsp['m'] = 1;
                $rsp['vl'] = $_vl;
                $rsp['i'] = $__cnx->c_p->insert_id;

                $__enc = Enc_Rnd($__cnx->c_p->insert_id.'-'.SISUS_ID);

                $insertSQL = sprintf("INSERT INTO "._BdStr(DBM).TB_ORG_DSH_ROW_COL_FLD." (orgdshrowcolfld_enc, orgdshrowcolfld_orgdsh, orgdshrowcolfld_orgdshrowcol) VALUES 
                                    ( %s, %s, (SELECT id_orgdshrowcol FROM "._BdStr(DBM).TB_ORG_DSH_ROW_COL." WHERE orgdshrowcol_enc = %s) )",
			                       GtSQLVlStr($__enc, "text"),
								   GtSQLVlStr(ctjTx($__cnx->c_p->insert_id,'out'), "text"),
								   GtSQLVlStr(ctjTx($_POST['orgdshrowcolfld_orgdshrowcol'],'out'), "text"));

            $Result = $__cnx->_prc($insertSQL); 

            }else{
                $rsp['e'] = 'no';
                $rsp['m'] = 2;
            }    

        }
    }

?>