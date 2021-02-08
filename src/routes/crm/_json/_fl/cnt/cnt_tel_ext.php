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
							id_cnttel,
							cnttel_enc,
							cnttel_cnt,
							cnttel_tel,
							cnttel_est
						FROM ".DB_CL.".".TB_CNT_TEL."
						INNER JOIN ".DB_CL.".".TB_CNT." ON cnttel_cnt = id_cnt
						WHERE cnttel_enc IN ('{$__mcnt_a}')"; 
						
			$Ls = $__cnx->_qry($Ls_Qry);
			
			if($Ls){
				
				$row_Ls = $Ls->fetch_assoc(); 
				$Tot_Ls = $Ls->num_rows;
				
				if($Tot_Ls>0){		
					$rsp['e'] = 'ok';
					$rsp['total'] = $Tot_Ls;	
					
					do {
						
						$ido = $row_Ls['id_cnttel'];
						$rsp['l'][$ido]['id'] = $row_Ls['id_cnttel'];
						$rsp['l'][$ido]['est']['tt'] = ctjTx($__k_sest[$row_Ls["cnttel_est"]]['tt'],'in');
						$rsp['l'][$ido]['est']['id'] = $row_Ls["cnttel_est"];
						$rsp['l'][$ido]['fi'] = $row_Ls['cnttel_fi'];
	
						$__k_icn[$ido] = $row_Ls;
						$__k_cnt[] = $row_Ls['cnttel_cnt'];
						$__k_mdlcnt[] = $row_Ls['id_cnttel']; 
						
					} while ($row_Ls = $Ls->fetch_assoc());
					$__k_icns = $rsp['l'];
					$__k_cnt_a = implode("','", $__k_cnt);
					$__k_mdlcnt_a = implode("','", $__k_mdlcnt);

				}
			}
			
		//-------------------- Gestiones Total --------------------//
		
			$LsHisTot_Qry = "	SELECT cnttelplcy_cnttel, cnttelplcy_plcy, cnttelplcy_sndi, id_cnttelplcy, clplcy_nm, id_cnttel
								FROM ".DB_CL.".".TB_CNT_TEL_PLCY."
								INNER JOIN ".DB_CL.".".TB_CNT_TEL." ON cnttelplcy_cnttel = id_cnttel
								INNER JOIN "._BdStr(DBM).TB_CL_PLCY." ON cnttelplcy_plcy = id_clplcy
								WHERE cnttelplcy_cnttel IN ('{$__k_mdlcnt_a}')
								"; 

			$LsHisTot = $__cnx->_qry($LsHisTot_Qry);
			
			if($LsHisTot){
				
				$row_LsHisTot = $LsHisTot->fetch_assoc(); 
				$Tot_LsHisTot = $LsHisTot->num_rows;
				
				if($Tot_LsHisTot>0){
					
					do {	
						
						$ido = $row_LsHisTot['id_cnttel'];
						$rsp['l'][$ido]['plcy'] .= '<li class="plcy_'.$row_LsHisTot['cnttelplcy_sndi'].'"><span></span>'.ctjTx($row_LsHisTot['clplcy_nm'], 'in').'</li>';
						
						
					} while ($row_LsHisTot = $LsHisTot->fetch_assoc());
					
				}
			
			}
	}
	
?>