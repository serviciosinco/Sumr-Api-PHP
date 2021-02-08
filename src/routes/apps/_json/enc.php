<?php 
	
	$__tp = Php_Ls_Cln($_POST['__tp']); 

	if($__tp != '' || $__tp != NULL){
		
		$LsPro_Qry = "SELECT * FROM ".TB_ENC."  WHERE  enc_mdlstp = {$__tp} ";
		$LsPro = $__cnx->_qry($LsPro_Qry); echo $__cnx->c_r->error; $row_LsPro = $LsPro->fetch_assoc(); $Tot_LsPro = $LsPro->num_rows;	
	
		if( ($Tot_LsPro>0) ){	
			$rsp['e'] = 'ok';
			
			
			/* Listado de Programa */
			//$rsp['enc']['tt'] = MDL_PRO;
			$rsp['enc']['total'] = $Tot_LsPro;
			if($Tot_LsPro > 0){
				do {				
					$rsp['enc']['list'][] = array('id'=>$row_LsPro['id_enc'], 'tt'=>ctjTx($row_LsPro['enc_tt'],'in'));	
				} while ($row_LsPro = $LsPro->fetch_assoc());
				
			}
	
			
		}else{
			$rsp['e'] = 'no';
			$rsp['QRY'] = $LsPro_Qry;
		}
		
	}
	
	$__cnx->_clsr($LsPro);
?>