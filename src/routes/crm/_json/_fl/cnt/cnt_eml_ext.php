<?php 
	$rsp['e'] = 'no';

	//@ini_set('display_errors', true); 
	//error_reporting(E_ALL & ~E_NOTICE);

	$__mcnt = Php_Ls_Cln($_POST['mdlcnt']);
	$__tp = Php_Ls_Cln($_POST['mdl_mdls']);
	
	if(!isN($__mcnt)){
		
		$__mcnt_a = explode(',', $__mcnt);
		$__mcnt_a = implode("','", $__mcnt_a);
			
		//-------------------- Consulta Principal Leads --------------------//
	
			$Ls_Qry = "SELECT
							id_cnteml,
							cnteml_enc,
							cnteml_cnt,
							cnteml_eml,
							cnteml_est
						FROM ".DB_CL.".".TB_CNT_EML."
						INNER JOIN ".DB_CL.".".TB_CNT." ON cnteml_cnt = id_cnt
						WHERE cnteml_enc IN ('{$__mcnt_a}')"; 
						
			$Ls = $__cnx->_qry($Ls_Qry);
			
			if($Ls){
				
				$row_Ls = $Ls->fetch_assoc(); 
				$Tot_Ls = $Ls->num_rows;
				
				if($Tot_Ls>0){		
					$rsp['e'] = 'ok';
					$rsp['total'] = $Tot_Ls;	
					
					do {
						
						$ido = $row_Ls['id_cnteml'];
						$rsp['l'][$ido]['id'] = $row_Ls['id_cnteml'];
						$rsp['l'][$ido]['est']['tt'] = ctjTx($__k_sest[$row_Ls["cnteml_est"]]['tt'],'in');
						$rsp['l'][$ido]['est']['id'] = $row_Ls["cnteml_est"];
						$rsp['l'][$ido]['fi'] = $row_Ls['cnteml_fi'];
	
						$__k_icn[$ido] = $row_Ls;
						$__k_cnt[] = $row_Ls['cnteml_cnt'];
						$__k_mdlcnt[] = $row_Ls['id_cnteml']; 
						
					} while ($row_Ls = $Ls->fetch_assoc());
					$__k_icns = $rsp['l'];
					$__k_cnt_a = implode("','", $__k_cnt);
					$__k_mdlcnt_a = implode("','", $__k_mdlcnt);

				}
			}
			
		//-------------------- Gestiones Total --------------------//
		
			$LsHisTot_Qry = "	SELECT cntemlplcy_cnteml, cntemlplcy_plcy, cntemlplcy_sndi, id_cntemlplcy, clplcy_nm, id_cnteml
								FROM ".DB_CL.".".TB_CNT_EML_PLCY."
								INNER JOIN ".DB_CL.".".TB_CNT_EML." ON cntemlplcy_cnteml = id_cnteml
								INNER JOIN "._BdStr(DBM).TB_CL_PLCY." ON cntemlplcy_plcy = id_clplcy
								WHERE cntemlplcy_cnteml IN ('{$__k_mdlcnt_a}')
								"; 

			$LsHisTot = $__cnx->_qry($LsHisTot_Qry);
			
			if($LsHisTot){
				
				$row_LsHisTot = $LsHisTot->fetch_assoc(); 
				$Tot_LsHisTot = $LsHisTot->num_rows;
				
				if($Tot_LsHisTot>0){
					
					do {	
						
						$ido = $row_LsHisTot['id_cnteml'];
						$rsp['l'][$ido]['plcy'] .= '<li class="plcy_'.$row_LsHisTot['cntemlplcy_sndi'].'"><span></span>'.ctjTx($row_LsHisTot['clplcy_nm'], 'in').'</li>';
						
						
					} while ($row_LsHisTot = $LsHisTot->fetch_assoc());
					
				}
			
			}
	}
	
?>