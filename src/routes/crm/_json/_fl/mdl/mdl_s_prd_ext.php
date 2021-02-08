<?php 
	
	$rsp['e'] = 'no';

	//@ini_set('display_errors', true); 
	//error_reporting(E_ALL & ~E_NOTICE);

    $__tp = Php_Ls_Cln($_POST['mdl_s_prd']);
    
	if(!isN($__tp)){
        
        $rsp['e'] = 'ok';

        $__tp_a = explode(',', $__tp);
        $__mcnt_a = implode("','", $__tp_a);

		//-------------------- Consulta Principal Leads --------------------//

		$Ls_Qry = " SELECT
							*
					FROM
						sumr_bd._mdl_s_prd
					INNER JOIN sumr_bd._mdl_s_prd_tp ON mdlsprdtp_prd = id_mdlsprd
					INNER JOIN sumr_bd._mdl_s_tp ON  mdlsprdtp_tp = id_mdlstp
					where
						mdlsprd_enc IN ('{$__mcnt_a}')
				";

		$Ls = $__cnx->_qry($Ls_Qry);
		
		if($Ls){
			
			$row_Ls = $Ls->fetch_assoc(); 
			$Tot_Ls = $Ls->num_rows;
			
			if($Tot_Ls>0){		
				$rsp['e'] = 'ok';
				$rsp['total'] = $Tot_Ls;	
				
				do {
	
					$ido = $row_Ls['mdlsprd_enc'];
					
					$rsp['l'][$ido]['id'] = $row_Ls['mdlsprd_enc'];	
					$rsp['l'][$ido]['tp'][$row_Ls['mdlstp_enc']]['enc'] = $row_Ls['mdlstp_enc'];
					$rsp['l'][$ido]['tp'][$row_Ls['mdlstp_enc']]['img'] = $row_Ls['mdlstp_img'];

					$_icn = li(Spn('', '', 'icn_chck_tp', 'background-image: url('.DMN_FLE_MDL_TP.$row_Ls['mdlstp_img'].');','' ));
					$rsp['l'][$ido]['ls_icns'][$row_Ls['id_mdlstp']] = $_icn;

					$__k_icn[$ido] = $row_Ls;
					
				} while ($row_Ls = $Ls->fetch_assoc());

				$__k_icns = $rsp['l'];
				$__k_cnt_a = implode("','", $__k_cnt);
				$__k_mdlcnt_a = implode("','", $__k_mdlcnt);

				foreach($__k_icns as $__k_icns_k => $__k_icns_v){
					foreach($__k_icns_v['ls_icns'] as $__k_icnd_k => $__k_icnd_v){
						$Vl[$__k_icns_k] .= $__k_icnd_v;
					}
					$rsp['l'][$__k_icns_k]['ls_icns'] = __Ls_Chk_Icn([ 'mre'=>$Vl[$__k_icns_k] ]);	
				}
			}
		}
	}
?>