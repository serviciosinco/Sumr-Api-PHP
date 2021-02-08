<?php 
	
	$rsp['e'] = 'no';
	
	$_i = Php_Ls_Cln($_POST['_i']);

	if(!isN($_i)){
		
		$__enc = explode(',', $_i);
		$__enc_a = implode("','", $__enc);
		
		//-------------------- Consulta Email Organizacion Sedes Contactos --------------------//
		
		
			$LsOrgSdsCntEml_Qry = " 	SELECT
                                            id_orgsdscnt, cnteml_eml
                                        FROM
                                            ".TB_ORG_SDS_CNT."
                                            INNER JOIN ".TB_CNT_EML." ON orgsdscnt_cnt = cnteml_cnt	
                                        WHERE
                                            orgsdscnt_enc IN ('{$__enc_a}') 
    
                                    ";
							
			$Ls_OrgSdsCntEml = $__cnx->_qry($LsOrgSdsCntEml_Qry);
			
			if($Ls_OrgSdsCntEml){

				while( $row_Ls_OrgSdsCntEml = $Ls_OrgSdsCntEml->fetch_assoc() ){

                    $rsp['l'][$row_Ls_OrgSdsCntEml['id_orgsdscnt']]['eml'][] = $row_Ls_OrgSdsCntEml['cnteml_eml'];
                    
                }
                
            }
        //-------------------- Consulta Email Organizacion Sedes Contactos --------------------//
		
		
			$LsOrgSdsCntEml_Qry = " 	SELECT
                                                id_orgsdscnt, cnttel_tel, sisps_img
                                            FROM
                                                ".TB_ORG_SDS_CNT."
                                                INNER JOIN ".TB_CNT_TEL." ON orgsdscnt_cnt = cnttel_cnt	
                                                INNER JOIN "._BdStr(DBM).TB_SIS_PS." ON cnttel_ps = id_sisps	
                                            WHERE
                                                orgsdscnt_enc IN ('{$__enc_a}') 

                                        ";

            $Ls_OrgSdsCntEml = $__cnx->_qry($LsOrgSdsCntEml_Qry);

            if($Ls_OrgSdsCntEml){

                while( $row_Ls_OrgSdsCntEml = $Ls_OrgSdsCntEml->fetch_assoc() ){

                    $rsp['l'][$row_Ls_OrgSdsCntEml['id_orgsdscnt']]['tel'][] = [ 
                                                                                    'tel' => $row_Ls_OrgSdsCntEml['cnttel_tel'],
                                                                                    'ps' =>  $row_Ls_OrgSdsCntEml['sisps_img']
                                                                                ];

                }

            }

        //-------------------- Consulta Email Organizacion Sedes Contactos --------------------//
		
		
			$LsOrgSdsCntCrg_Qry = " SELECT
                                        id_orgsdscnt, sisslc_tt
                                    FROM
                                        ".TB_ORG_SDS_CNT."
                                        INNER JOIN cnt_crg ON orgsdscnt_cnt = cntcrg_cnt	
                                        INNER JOIN "._BdStr(DBM).TB_SIS_SLC." ON cntcrg_crg = id_sisslc	
                                    WHERE
                                        orgsdscnt_enc IN ('{$__enc_a}') 

                                ";

            $Ls_OrgSdsCntCrg = $__cnx->_qry($LsOrgSdsCntCrg_Qry);

            if($Ls_OrgSdsCntCrg){

                while( $row_Ls_OrgSdsCntCrg = $Ls_OrgSdsCntCrg->fetch_assoc() ){

                    $rsp['l'][$row_Ls_OrgSdsCntCrg['id_orgsdscnt']]['crg'][] = [ 
                                                                'crg' => $row_Ls_OrgSdsCntCrg['sisslc_tt']
                                                            ];

                }

            }
            
	}
	
?>