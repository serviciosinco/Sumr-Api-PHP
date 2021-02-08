<?php 
	
	
	try{
		
		
		$_tp = Php_Ls_Cln($_POST['t']);
		$_dt = Php_Ls_Cln($_POST['d']);
		$_id_appl = Php_Ls_Cln($_POST['_id_appl']);

		if($_dt == 'cntrc_pdf'){
			
			$__sbdmn = Gt_SbDMN();	
			$__dt_cl = __Cl(['id'=>$__sbdmn, 't'=>'sbd' ]);
			$__enc = Enc_Rnd($_id_appl.'-'.$_tp);
			
			$insertSQL = sprintf("
									INSERT INTO ".$__dt_cl->bd.".cntrc_appl 
										(
											cntrcappl_enc, 
											cntrcappl_cntrc, 
											cntrcappl_cntappl
										) VALUES 
										(
											%s, 
											2,
											(SELECT id_cntappl FROM ".$__dt_cl->bd.".".TB_CNT_APPL." WHERE cntappl_enc = %s)
										)
								",
		                       GtSQLVlStr($__enc, "text"),
							   GtSQLVlStr($_id_appl, "text")
						   );

			$Result = $__cnx->_prc($insertSQL);	

			if($Result){
				$rsp['e'] = 'ok';	
				$rsp['enc'] = $__enc;
			}	
		}
		
	}catch(Exception $e){
		$rsp['e'] = 'no';
		$rsp['w'] = TX_NSPPCSR .$e->getMessage();
	}
	
?> 