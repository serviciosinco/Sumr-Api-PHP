<?php 
	
	
	try{
		
		$_id_chck = Php_Ls_Cln($_POST['_id_chck']);
		
		$__Up = new CRM_Up();
		$Prc_Up = json_decode($__Up->_InUp_Est([ 'id'=>$_id_chck, 'e'=>_CId('ID_UPEST_ELI'), 't'=>'enc' ]));
		
		if($Prc_Up->e == 'ok'){
			$rsp['e'] = 'ok';
			$rsp['a'] = $_Crm_Aud->In_Aud([ "aud"=>_Cns('ID_AUDDSC_UP_DEL'), "db"=>"up", "post"=>$_POST ]);
		}else{
			$rsp['e'] = 'no';	
		}

		if(!isN($PrcDt->w_n)){ $rsp['w_n'] = $PrcDt->w_n; }

	}catch(Exception $e){
		$rsp['e'] = 'no';
		$rsp['w'] = TX_NSPPCSR .$e->getMessage();
	}
	
?>