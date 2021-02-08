 <?php
	
	try{
		
		$__Atmt = new CRM_Atmt();
		
		//------------------ Post Data ------------------//
		
			$_p_est = Php_Ls_Cln($_POST['est']);
			$_p_atmt = Php_Ls_Cln($_POST['atmt']);
			$_p_plcy = Php_Ls_Cln($_POST['plcy']);
		
		//------------------ Detail Data ------------------//
		
			$___plcydt = GtClPlcyDt([ 'id'=>$_p_plcy, 't'=>'enc' ]); 
			$___atmtdt = GtAtmtDt([ 'id'=>$_p_atmt, 't'=>'enc' ]);
			$__Atmt->plcy_id = $___plcydt->id;
		
		//------------------ Process Change ------------------//
		
		
		$__chk = $__Atmt->AtmtPlcyChk([ 'atmt'=>$___atmtdt->id, 'plcy'=>$___plcydt->id ]);
		
		
		if(!isN($__chk->id)){

			$__prc = $__Atmt->UpdAtmt_Plcy([ 'id'=>$__chk->id, 'e'=>$_p_est ]);
			$rsp = $__prc;
			
		}else{
			
			$__prc = $__Atmt->InAtmt_Plcy([ 'atmt'=>$___atmtdt->id ]); 
			$rsp = $__prc;
			$rsp->in = 'ok';
			
		}
		
		
	}catch(Exception $e){
		$rsp['e'] = 'no';
		$rsp['w'] = TX_NSPPCSR .$e->getMessage();
	}
	
?>