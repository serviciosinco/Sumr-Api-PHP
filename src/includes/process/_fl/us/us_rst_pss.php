<?php

if(!isN(Php_Ls_Cln($_POST['id'])) && Php_Ls_Cln($_POST['new']) == 'ok'){
	
	$__us = new CRM_Us();

	$__pass = Php_Ls_Cln($_POST['pass']);
	$__pass_chk = Php_Ls_Cln($_POST['pass_chk']);
	$__id = Php_Ls_Cln($_POST['id']);
	$__fP_d = $__us->UsFrgtChk([ 't'=>'enc', 'id'=>$__id ]);
	
	if(!isN($__id) && !isN($__fP_d->id) && !isN($__fP_d->us->id)){
		
		if($__fP_d->hb=='ok'){
	
			if($__pass != $__pass_chk){ 
				
				$rsp['e'] = 'no';
				$___Gt = GtSisPrcDt(Php_Ls_Cln(15));
				$rsp['w'] = $___Gt->tt;	
				
			}else{
				
				$updateSQL = sprintf("UPDATE "._BdStr(DBM).TB_US." SET us_pass=%s, us_est=1 WHERE us_enc=%s",
										GtSQLVlStr(enCad($__pass), "text"),
										GtSQLVlStr($__fP_d->us->enc, "text"));
					
				$Result = $__cnx->_prc($updateSQL);
				
				if($Result){

					$_upd_e = $__us->UsFrgtUpd([ 'id'=>$__fP_d->enc ]);

					if($_upd_e->e == 'ok'){
						$rsp['e'] = 'ok';
						$rsp['m'] = 1;
					}	

				}else{
					$rsp['e'] = 'no';
					$rsp['m'] = 2;
				}
				
			}

		}
		
	}else{

		$rsp['e'] = 'no';
		$___Gt = GtSisPrcDt(Php_Ls_Cln(8));
		$rsp['w'] = $___Gt->tt;	
		
	}
	
}

?>