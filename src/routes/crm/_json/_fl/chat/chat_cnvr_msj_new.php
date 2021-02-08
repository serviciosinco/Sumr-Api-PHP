 <?php
	
	$__chat = new CRM_Chat();

	try{
		
		$_cnv_enc = Php_Ls_Cln($_POST['cnv']);
		$_cnv_msj = Php_Ls_Cln($_POST['tx']);
		
		$__chat->maincnv_enc = $_cnv_enc;
		$__mcnv = $__chat->MainCnvDt();

		if( !isN( $__mcnv->d->enc ) && !isN($_cnv_msj) ){
			
			$__chat->cnvrmsj_msj = $_cnv_msj;
			$__chat->cnvrmsj_us = SISUS_ID;
			$__chat->cnvr_enc = $__mcnv->d->enc;
			$__sve = $__chat->_Cht_Msg_Nw();

			if($__sve->e == 'ok'){
				$rsp['e'] = 'ok';
				$rsp['id'] = $__sve->enc;
				$rsp['d']['f'] = $__sve->d->f;
				$rsp['d']['me'] = 'ok';
				$rsp['d']['tx'] = $__sve->d->msg;
				$rsp['d']['img'] = $__sve->from->img;
				$rsp['tmp'] = $__sve;
			}else{
				$rsp['e'] = 'no';
			}
			
		}else{
			$rsp['e'] = 'no';
			$rsp['w'] = 'No existe ____key';
		}
	
	}catch(Exception $e){
		$rsp['e'] = 'no';
		$rsp['w'] = TX_NSPPCSR .$e->getMessage();
	}
	
?>