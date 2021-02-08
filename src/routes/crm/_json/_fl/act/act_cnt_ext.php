<?php 

	$__acts = Php_Ls_Cln($_POST['act']);
	$__tp = Php_Ls_Cln($_POST['tp']);

	if(!isN($__acts)){
		
		$__acts_a = explode(',', $__acts);
		$__acts_a = implode("','", $__acts_a);
			
		//-------------------- Consulta Emails Leads --------------------//	

            $Ls_Qry_Eml =   "SELECT
                                mdlcnt_enc, cnteml_eml, cntplcy_sndi
                            FROM
                                ".TB_MDL_CNT."
                                INNER JOIN ".TB_CNT." ON mdlcnt_cnt = id_cnt
                                INNER JOIN ".TB_CNT_EML." ON cnteml_cnt = id_cnt
                                LEFT JOIN ".TB_CNT_PLCY." ON (cntplcy_cnt = cnteml_cnt AND cntplcy_sndi=1)
								LEFT JOIN "._BdStr(DBM).TB_CL_PLCY." ON (cntplcy_plcy = id_clplcy AND clplcy_e=1)
                            WHERE
                                mdlcnt_enc IN ('{$__acts_a}')";

            $Ls_Eml = $__cnx->_qry($Ls_Qry_Eml);

            if($Ls_Eml){
                $row_Ls_Eml = $Ls_Eml->fetch_assoc(); 
                $Tot_Ls_Eml = $Ls_Eml->num_rows;

                if($Tot_Ls_Eml>0){	
                    $rsp['e'] = 'ok';
                    do {  

                        $ido = $row_Ls_Eml['mdlcnt_enc'];
                        $rsp['l'][$ido]['id'] = $row_Ls_Eml['mdlcnt_enc'];

                        $__eml_nrml = _plcy_scre([ 
                            't'=>'eml',
                            'v'=>$row_Ls_Eml['cnteml_eml'],
                            'plcy'=>[ 'e'=>$row_Ls_Eml['cntplcy_sndi'] ]  
                        ]);

                        $rsp['l'][$ido]['eml'][] = $__eml_nrml;
                        
                    } while ($row_Ls_Eml = $Ls_Eml->fetch_assoc());
                }

            }else{ 
                $rsp['w'] = $__cnx->c_r->error;
            }
    
        //-------------------- Consulta Emails Leads --------------------//	

            $Ls_Qry =  "SELECT
                            mdlcnt_enc, cnttel_tel, cntplcy_sndi
                        FROM
                            ".TB_MDL_CNT."
                            INNER JOIN ".TB_CNT." ON mdlcnt_cnt = id_cnt
                            INNER JOIN ".TB_CNT_TEL." ON cnttel_cnt = id_cnt
                            LEFT JOIN ".TB_CNT_PLCY." ON (cntplcy_cnt = cnttel_cnt AND cntplcy_sndi=1)
							LEFT JOIN "._BdStr(DBM).TB_CL_PLCY." ON (cntplcy_plcy = id_clplcy AND clplcy_e=1)
                        WHERE
                            mdlcnt_enc IN ('{$__acts_a}')";

            $Ls = $__cnx->_qry($Ls_Qry);

            if($Ls){
                $row_Ls = $Ls->fetch_assoc(); 
                $Tot_Ls = $Ls->num_rows;

                if($Tot_Ls>0){	
                    $rsp['e'] = 'ok';
                    do {  

                        $ido = $row_Ls['mdlcnt_enc'];
                        $rsp['l'][$ido]['id'] = $row_Ls['mdlcnt_enc'];

                        $__tel_nrml = 	_plcy_scre([ 
							'v'=>$row_Ls['cnttel_tel'],
							'plcy'=>[ 'e'=>$row_Ls['cntplcy_sndi'] ]  
						]);

                        $rsp['l'][$ido]['tel'][] = $__tel_nrml;
                        
                    } while ($row_Ls = $Ls->fetch_assoc());
                }
            }else{ 
                $rsp['w'] = $__cnx->c_r->error;
            }

	}else{		
		$rsp['w'] = 'No data';
    }
?>