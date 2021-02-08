<?php 

	$__acts = Php_Ls_Cln($_POST['act']);
	$__tp = Php_Ls_Cln($_POST['tp']);

	if(!isN($__acts)){
		
		$__acts_a = explode(',', $__acts);
		$__acts_a = implode("','", $__acts_a);
			
		//-------------------- Consulta Principal Leads --------------------//	
			
        $_fl_org = ", (SELECT COUNT(*) FROM "._BdStr(DBM).TB_ORG_SDS_ACT." WHERE orgsdsact_act = id_act) AS _org";
        
        $_fl_tp = " , (SELECT GROUP_CONCAT(CONCAT(mdl_nm)) FROM ".TB_MDL."
                            INNER JOIN ".TB_ACT_ACT_TP." ON actacttp_acttp = id_mdl
                            WHERE actacttp_act = id_act
                        ) AS tp";
                        
        $_fl_cnt_t = ", (SELECT COUNT(*) FROM ".TB_MDL_CNT_ACT."
	                        INNER JOIN ".TB_MDL_CNT." ON mdlcntact_mdlcnt = id_mdlcnt
	                        WHERE
	                            mdlcntact_act = id_act
	                    ) AS cnt";

		
		
							
        $_fl_cnt_d = ", (SELECT COUNT(*) FROM ".TB_MDL_CNT_ACT."
                    INNER JOIN ".TB_MDL_CNT." ON mdlcntact_mdlcnt = id_mdlcnt
                    WHERE
                        mdlcntact_act = id_act
                    AND mdlcntact_tpi = "._CId('ID_MDLCNTACTTP_DGT')."
                ) AS cnt_d";
        
        $_fl_cnt_m = ", (SELECT COUNT(*) FROM ".TB_MDL_CNT_ACT."
                INNER JOIN ".TB_MDL_CNT." ON mdlcntact_mdlcnt = id_mdlcnt
                WHERE
                    mdlcntact_act = id_act
                AND mdlcntact_tpi = "._CId('ID_MDLCNTACTTP_MNL')."
            ) AS cnt_m";

        $Ls_Qry = "SELECT *
                            $_fl_org $_fl_tp $_fl_cnt_t $_fl_cnt_d $_fl_cnt_m
                    FROM "._BdStr(DBM).TB_ACT."
                    WHERE act_enc IN ('{$__acts_a}')";

        $Ls = $__cnx->_qry($Ls_Qry);
        
        
        $rsp['qry____tmppp'] = $Ls_Qry;
        
        
        
        if($Ls){
            
            $row_Ls = $Ls->fetch_assoc(); 
            $Tot_Ls = $Ls->num_rows;
            
            $rsp['total'] = $Tot_Ls;
            
            if($Tot_Ls>0){		
            
                $rsp['e'] = 'ok';	
                
                do {  

                    $ido = $row_Ls['act_enc'];
                    
                    $rsp['l'][$ido]['id'] = $row_Ls['act_enc'];

                    $rsp['l'][$ido]['tot']['org'] = $row_Ls["_org"];
                    $rsp['l'][$ido]['tp'] = ctjTx($row_Ls["tp"],'in');
                    $rsp['l'][$ido]['tot']['cnt'] = $row_Ls["cnt"];

                    $rsp['l'][$ido]['tot']['cnt_d'] = $row_Ls["cnt_d"];
                    $rsp['l'][$ido]['tot']['cnt_m'] = $row_Ls["cnt_m"];
                    
                    $rsp['l'][$ido]['fi'] = $row_Ls['act_fi'];
                    
                } while ($row_Ls = $Ls->fetch_assoc());
                
            }
        
        }else{
                
            $rsp['w'] = $__cnx->c_r->error;
            
        }
	
	}else{
					
		$rsp['w'] = 'No data';
		
	}
?>